<?php

namespace NFePHP\BPe;

use NFePHP\Common\Strings;
use NFePHP\BPe\Common\Standardize;
use NFePHP\BPe\Exception\DocumentsException;
use DOMDocument;

class Complements
{
    protected static $urlPortal = 'http://www.portalfiscal.inf.br/bpe';

    /**
     * Authorize document adding his protocol
     * @param string $request
     * @param string $response
     * @return string
     */
    public static function toAuthorize($request, $response)
    {
        $st = new Standardize();
        $key = ucfirst($st->whichIs($request));
        if ($key != 'BPe' && $key != 'EnvEvento') {
            //wrong document, this document is not able to recieve a protocol
            throw DocumentsException::wrongDocument(0, $key);
        }
        $func = "add".$key."Protocol";
        return self::$func($request, $response);
    }

    /**
     * Add cancel protocol to a autorized BPe
     * if event is not a cancellation will return
     * the same autorized NFe passing
     * NOTE: This action is not necessary, I use only for my needs to
     *       leave the BPe marked as Canceled in order to avoid mistakes
     *       after its cancellation.
     * @param  string $bpe content of autorized NFe XML
     * @param  string $cancelamento content of SEFAZ response
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function cancelRegister($bpe, $cancelamento)
    {
        $procXML = $bpe;
        $dombpe = new DOMDocument('1.0', 'utf-8');
        $dombpe->formatOutput = false;
        $dombpe->preserveWhiteSpace = false;
        $dombpe->loadXML($bpe);
        $proBPe = $dombpe->getElementsByTagName('protBPe')->item(0);
        if (empty($proNFe)) {
            //not protocoladed NFe
            throw DocumentsException::wrongDocument(1);
        }
        $chaveBPe = $proNFe->getElementsByTagName('chBPe')->item(0)->nodeValue;

        $domcanc = new DOMDocument('1.0', 'utf-8');
        $domcanc->formatOutput = false;
        $domcanc->preserveWhiteSpace = false;
        $domcanc->loadXML($cancelamento);
        $eventos = $domcanc->getElementsByTagName('retEvento');
        foreach ($eventos as $evento) {
            $infEvento = $evento->getElementsByTagName('infEvento')->item(0);
            $cStat = $infEvento->getElementsByTagName('cStat')
                ->item(0)
                ->nodeValue;
            $nProt = $infEvento->getElementsByTagName('nProt')
                ->item(0)
                ->nodeValue;
            $chaveEvento = $infEvento->getElementsByTagName('chBPe')
                ->item(0)
                ->nodeValue;
            $tpEvento = $infEvento->getElementsByTagName('tpEvento')
                ->item(0)
                ->nodeValue;
            if (in_array($cStat, ['135', '136', '155'])
                && ($tpEvento == Tools::EVT_CANCELA
                    || $tpEvento == Tools::EVT_CANCELASUBSTITUICAO
                )
                && $chaveEvento == $chaveNFe
            ) {
                $proNFe->getElementsByTagName('cStat')
                    ->item(0)
                    ->nodeValue = '101';
                $proNFe->getElementsByTagName('nProt')
                    ->item(0)
                    ->nodeValue = $nProt;
                $proNFe->getElementsByTagName('xMotivo')
                    ->item(0)
                    ->nodeValue = 'Cancelamento de BPe homologado';
                $procXML = Strings::clearProtocoledXML($dombpe->saveXML());
                break;
            }
        }
        return $procXML;
    }

    /**
     * Authorize BPe
     * @param string $request
     * @param string $response
     * @return string
     * @throws \InvalidArgumentException
     */
    protected static function addBPeProtocol($request, $response)
    {
        $req = new DOMDocument('1.0', 'UTF-8');
        $req->preserveWhiteSpace = false;
        $req->formatOutput = false;
        $req->loadXML($request);

        $bpe = $req->getElementsByTagName('BPe')->item(0);
        $infBPe = $req->getElementsByTagName('infBPe')->item(0);
        $versao = $infBPe->getAttribute("versao");
        $chave = preg_replace('/[^0-9]/', '', $infBPe->getAttribute("Id"));
        $digBPe = $req->getElementsByTagName('DigestValue')
            ->item(0)
            ->nodeValue;

        $ret = new DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        $retProt = !empty($ret->getElementsByTagName('protBPe')) ? $ret->getElementsByTagName('protBPe') : null;
        if ($retProt === null) {
            throw DocumentsException::wrongDocument(3, "&lt;protBPe&gt;");
        }
        $digProt = '000';
        foreach ($retProt as $rp) {
            $infProt = $rp->getElementsByTagName('infProt')->item(0);
            $cStat = $infProt->getElementsByTagName('cStat')->item(0)->nodeValue;
            $xMotivo = $infProt->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            $dig = $infProt->getElementsByTagName("digVal")->item(0);
            $key = $infProt->getElementsByTagName("chBPe")->item(0)->nodeValue;
            if (isset($dig)) {
                $digProt = $dig->nodeValue;
                if ($digProt == $digNFe && $chave == $key) {
                    //100 Autorizado
                    //150 Autorizado fora do prazo
                    //110 Uso Denegado
                    //205 NFe Denegada
                    //301 Uso denegado por irregularidade fiscal do emitente
                    //302 Uso denegado por irregularidade fiscal do destinatário
                    //303 Uso Denegado Destinatario nao habilitado a operar na UF
                    $cstatpermit = ['100', '150', '110', '205', '301', '302', '303'];
                    if (!in_array($cStat, $cstatpermit)) {
                        throw DocumentsException::wrongDocument(4, "[$cStat] $xMotivo");
                    }
                    return self::join(
                        $req->saveXML($bpe),
                        $ret->saveXML($rp),
                        'bpeProc',
                        $versao
                    );
                }
            }
        }
        if ($digBPe !== $digProt) {
            throw DocumentsException::wrongDocument(5, "Os digest são diferentes");
        }
        return $req->saveXML();
    }

    /**
     * Authorize Event
     * @param string $request
     * @param string $response
     * @return string
     * @throws \InvalidArgumentException
     */
    protected static function addEnvEventoProtocol($request, $response)
    {
        $ev = new \DOMDocument('1.0', 'UTF-8');
        $ev->preserveWhiteSpace = false;
        $ev->formatOutput = false;
        $ev->loadXML($request);
        //extrai numero do lote do envio
        $envLote = $ev->getElementsByTagName('idLote')->item(0)->nodeValue;
        //extrai tag evento do xml origem (solicitação)
        $event = $ev->getElementsByTagName('evento')->item(0);
        $versao = $event->getAttribute('versao');

        $ret = new \DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        //extrai numero do lote da resposta
        $resLote = $ret->getElementsByTagName('idLote')->item(0)->nodeValue;
        //extrai a rag retEvento da resposta (retorno da SEFAZ)
        $retEv = $ret->getElementsByTagName('retEvento')->item(0);
        $cStat  = $retEv->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo = $retEv->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        $tpEvento = $retEv->getElementsByTagName('tpEvento')->item(0)->nodeValue;
        $cStatValids = ['135', '136'];
        if ($tpEvento == Tools::EVT_CANCELA) {
            $cStatValids[] = '155';
        }
        if (!in_array($cStat, $cStatValids)) {
            throw DocumentsException::wrongDocument(4, "[$cStat] $xMotivo");
        }
        if ($resLote !== $envLote) {
            throw DocumentsException::wrongDocument(
                5,
                "Os numeros de lote dos documentos são diferentes."
            );
        }
        return self::join(
            $ev->saveXML($event),
            $ret->saveXML($retEv),
            'procEventoBPe',
            $versao
        );
    }

    /**
     * Join the pieces of the source document with those of the answer
     * @param string $first
     * @param string $second
     * @param string $nodename
     * @param string $versao
     * @return string
     */
    protected static function join($first, $second, $nodename, $versao)
    {
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
                . "<$nodename versao=\"$versao\" "
                . "xmlns=\"".self::$urlPortal."\">";
        $xml .= $first;
        $xml .= $second;
        $xml .= "</$nodename>";
        return $xml;
    }
}
