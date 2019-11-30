<?php

namespace NFePHP\BPe;

/**
 * Class responsible for communication with SEFAZ extends
 * NFePHP\BPe\Common\Tools
 *
 * @category  NFePHP
 * @package   NFePHP\BPe\Tools
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @author    Anderson Minuto Consoni Vaz <anderson at wdhouse dot com dot br>
 * @link      http://github.com/nfephp-org/sped-bpe for the canonical source repository
 */

use NFePHP\Common\Strings;
use NFePHP\Common\Signer;
use NFePHP\Common\UFList;
use NFePHP\BPe\Factories\Events;
use NFePHP\BPe\Common\Tools as ToolsCommon;
use RuntimeException;
use InvalidArgumentException;

class Tools extends ToolsCommon
{
    
    const EVT_CANCELA = '110111';
    const EVT_NAOEMBARQUE = '110115';
    const EVT_POLTRONA = '110116';
    
    /**
     * Check services status SEFAZ
     * @param string $uf  initials of federation unit
     * @param int $tpAmb
     * @return string xml soap response
     */
    public function sefazStatus($uf = '', $tpAmb = null)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        if (empty($uf)) {
            $uf = $this->config->siglaUF;
        }
        $servico = 'BPeStatusServico';
        $this->servico($servico, $uf, $tpAmb);
        $request = "<consStatServBPe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<xServ>STATUS</xServ>"
            . "</consStatServBPe>";
        $this->isValid($this->urlVersion, $request, 'consStatServBPe');
        $this->lastRequest = $request;
        $parameters = ['bpeDadosMsg' => $request];
        $body = "<bpeDadosMsg xmlns=\"$this->urlNamespace\">$request</bpeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }
    
    /**
     * Request authorization to issue BPe in batch with one or more documents
     * @param array $aXml array of bpe's xml
     * @param string $idLote lote number
     * @return string soap response xml
     */
    public function sefazEnviaLote(
        $aXml,
        $idLote = '',
        &$xmls = []
    ) {
        if (!is_array($aXml)) {
            throw new \InvalidArgumentException('Os XML das BPe devem ser passados em um array.');
        }
        $servico = 'BPeRecepcao';
        $sxml = implode("", $aXml);
        $sxml = preg_replace("/<\?xml.*?\?>/", "", $sxml);
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $this->tpAmb
        );
        $request = $sxml;
        $this->lastRequest = $request;
        $parameters = ['bpeDadosMsg' => $request];
        $request = base64_encode(gzencode($request, 9, FORCE_GZIP));
        $body = "<bpeDadosMsg xmlns=\"$this->urlNamespace\">$request</bpeDadosMsg>";
        $method = $this->urlMethod;
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Check the BPe status
     * @param string $chave
     * @param int $tpAmb
     * @return string
     */
    public function sefazConsultaChave($chave, $tpAmb = null)
    {
        $uf = UFList::getUFByCode(substr($chave, 0, 2));
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        $servico = 'BPeConsulta';
        $this->servico(
            $servico,
            $uf,
            $tpAmb
        );
        $request = "<consSitBPe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<xServ>CONSULTAR</xServ>"
            . "<chBPe>$chave</chBPe>"
            . "</consSitBPe>";
        $this->isValid($this->urlVersion, $request, 'consSitBPe');
        $this->lastRequest = $request;
        $parameters = ['bpeDadosMsg' => $request];
        $body = "<bpeDadosMsg xmlns=\"$this->urlNamespace\">$request</bpeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Requires bpe cancellation
     * @param  string $chave key of CTe
     * @param  string $xJust justificative 255 characters max
     * @param  string $nProt protocol number
     * @return string
     */
    public function sefazCancela($chave, $xJust, $nProt)
    {
        $uf = $this->validKeyByUF($chave);
        $xJust = substr(trim(Strings::replaceUnacceptableCharacters($xJust)), 0, 255);
        $tpEvento = self::EVT_CANCELA;
        $nSeqEvento = 1;
        $tagAdic = "<evCancBPe>"
            . "<descEvento>Cancelamento</descEvento>"
            . "<nProt>$nProt</nProt>"
            . "<xJust>$xJust</xJust>"
            . "</evCancBPe>";
        return $this->sefazEvento(
            $uf,
            $chave,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
    
    /**
     * Aleração de poltrona
     * @param string $chave
     * @param string $nProt
     * @param integer $poltrona
     * @param integer $nSeqEvento
     * @return string
     */
    public function sefazPoltrona($chave, $nProt, $poltrona, $nSeqEvento = 1)
    {
        $uf = $this->validKeyByUF($chave);
        $tpEvento = self::EVT_POLTRONA;
        $tagAdic = "<evAlteracaoPoltrona>"
            . "<descEvento>Alteração de Poltrona</descEvento>"
            . "<nProt>$nProt</nProt>"
            . "<poltrona>$poltrona</poltrona>"
            . "</evAlteracaoPoltrona>";
        return $this->sefazEvento(
            $uf,
            $chave,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
    
    /**
     * Evento de Não Embarque
     * @param string $chave
     * @param string $xJust
     * @param string $nProt
     * @param integer $nSeqEvento
     * @return string
     */
    public function sefazNaoEmbarque($chave, $xJust, $nProt, $nSeqEvento = 1)
    {
        $uf = $this->validKeyByUF($chave);
        $xJust = substr(trim(Strings::replaceUnacceptableCharacters($xJust)), 0, 255);
        $tpEvento = self::EVT_NAOEMBARQUE;
        $tagAdic = "<evNaoEmbBPe>"
            . "<descEvento>Não Embarque</descEvento>"
            . "<nProt>$nProt</nProt>"
            . "<xJust>$xJust</xJust>"
            . "</evNaoEmbBPe>";
        return $this->sefazEvento(
            $uf,
            $chave,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }

    /**
     * Send event to SEFAZ
     * @param string $uf
     * @param string $chave
     * @param int $tpEvento
     * @param int $nSeqEvento
     * @param string $tagAdic
     * @return string
     */
    protected function sefazEvento(
        $uf,
        $chave,
        $tpEvento,
        $nSeqEvento = 1,
        $tagAdic = ''
    ) {
        $ignore = false;
        $servico = 'BPeRecepcaoEvento';
        $this->servico(
            $servico,
            $uf,
            $this->tpAmb,
            $ignore
        );
        $cnpj = $this->config->cnpj;
        $dt = new \DateTime();
        $dhEvento = $dt->format('Y-m-d\TH:i:sP');
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $eventId = "ID".$tpEvento.$chave.$sSeqEvento;
        $cOrgao = UFList::getCodeByUF($uf);
        $request = "<eventoBPe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<CNPJ>$cnpj</CNPJ>"
            . "<chBPe>$chave</chBPe>"
            . "<dhEvento>$dhEvento</dhEvento>"
            . "<tpEvento>$tpEvento</tpEvento>"
            . "<nSeqEvento>$nSeqEvento</nSeqEvento>"
            . "<detEvento versaoEvento=\"$this->urlVersion\">"
            . "$tagAdic"
            . "</detEvento>"
            . "</infEvento>"
            . "</eventoBPe>";
        //assinatura dos dados
        $request = Signer::sign(
            $this->certificate,
            $request,
            'infEvento',
            'Id',
            $this->algorithm,
            $this->canonical
        );
        $request = Strings::clearXmlString($request, true);
        $this->isValid($this->urlVersion, $request, 'eventoBPe');
        $this->lastRequest = $request;
        $parameters = ['bpeDadosMsg' => $request];
        $body = "<bpeDadosMsg xmlns=\"$this->urlNamespace\">$request</bpeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }
}
