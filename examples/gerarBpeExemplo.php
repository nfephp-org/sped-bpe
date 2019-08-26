<?php
/**
 * User: Anderson Vaz - DEVOPS - WDHOUSE
 */
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\BPe\Make;
use NFePHP\BPe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\BPe\Common\Standardize;

//? cUF - Código da UF do emitente do Documento Fiscal
//? AAMM - Ano e Mês de emissão do BP-e
//? CNPJ - CNPJ do emitente
//? mod - Modelo do Documento Fiscal
//? serie - Série do Documento Fiscal
//? nNF - Número do Documento Fiscal
//? tpEmis - forma de emissão do BP-e
//? cBPe - Código Numérico que compõe a Chave de Acesso
//? cDV - Dígito Verificador da Chave de Acesso

function montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $numero, $tpEmis, $codigo = '')
{
    if ($codigo == '') {
        $codigo = $numero;
    }
    $forma = "%02d%02d%02d%s%02d%03d%09d%01d%08d";
    $chave = sprintf($forma, $cUF, $ano, $mes, $cnpj, $mod, $serie, $numero, $tpEmis, $codigo);
    return $chave . calculaDV($chave);
}
function calculaDV($chave43)
{
    $multiplicadores = array(2, 3, 4, 5, 6, 7, 8, 9);
    $iCount = 42;
    $somaPonderada = 0;
    while ($iCount >= 0) {
        for ($mCount = 0; $mCount < count($multiplicadores) && $iCount >= 0; $mCount++) {
            $num = (int) substr($chave43, $iCount, 1);
            $peso = (int) $multiplicadores[$mCount];
            $somaPonderada += $num * $peso;
            $iCount--;
        }
    }
    $resto = $somaPonderada % 11;
    if ($resto == '0' || $resto == '1') {
        $cDV = 0;
    } else {
        $cDV = 11 - $resto;
    }
    return (string) $cDV;
}

$arr = [
    "atualizacao" => "2019-07-11 16:56:00",
    "tpAmb" => 2,
    "razaosocial" => "",
    "cnpj" => "",
    "siglaUF" => "RS",
    "schemes" => "PL_BPe_100_NT012019",
    "versao" => '1.00',
    "proxyConf" => [
        "proxyIp" => "",
        "proxyPort" => "",
        "proxyUser" => "",
        "proxyPass" => ""
    ]
];
//monta o config.json
$configJson = \json_encode($arr);
//carrega o conteudo do certificado.
$content = file_get_contents('CERTIFICADO.pfx');
//intancia a classe tools
$tools = new Tools($configJson, Certificate::readPfx($content, '123456'));
$tools->model('63');

$dhEmi = date("Y-m-d\TH:i:sP");
$numeroCTE = 2;
$codigo = 10;
$chave = montaChave('43', date('y', strtotime($dhEmi)), date('m', strtotime($dhEmi)), $arr['cnpj'], $tools->model(), '1', $numeroCTE, $arr['tpAmb'], $codigo);
//echo $chave;
//exit;
$bpe = new Make();
$infBPe = new stdClass();
$infBPe->Id = ''; //$chave;
$infBPe->versao = "1.00";
$bpe->taginfBPe($infBPe);
$ide = new stdClass();
$ide->cUF = '43';
$ide->tpAmb = $arr['tpAmb'];
$ide->mod = 63;
$ide->serie = 1;
$ide->nBP = $numeroCTE;
$ide->cBP = sprintf('%08d', $codigo);
$ide->cDV = substr($chave, -1);
$ide->modal = 3;
$ide->dhEmi = $dhEmi;
$ide->tpEmis = 1;
$ide->verProc = 0;
$ide->tpBPe = 0;
$ide->indPres = 1;
$ide->UFIni = 'RS';
$ide->cMunIni = 4315602;
$ide->UFFim = 'RS';
$ide->cMunFim = 4315602;
$ide->dhCont = '';
$ide->xJust = '';
$bpe->tagide($ide);

$emit = new stdClass();
$emit->CNPJ = $arr['cnpj'];
$emit->IE = '';
$emit->IEST = '00';
$emit->xNome = 'HIDROVIAS';
$emit->xFant = 'HIDROVIAS';
$emit->IM = '00';
$emit->CNAE = '0000000';
$emit->CRT = '3';
$emit->TAR = '';
$bpe->tagemit($emit);

$enderEmit = new stdClass();
$enderEmit->xLgr = ''; // Logradouro
$enderEmit->nro = ''; // Numero
$enderEmit->xCpl = ''; // Complemento
$enderEmit->xBairro = 'Centro'; // Bairro
$enderEmit->cMun = '4318507'; // Código do município (utilizar a tabela do IBGE)
$enderEmit->xMun = 'SAO JOSE DO NORTE'; // Nome do municipio
$enderEmit->CEP = '96225000'; // CEP
$enderEmit->UF = 'RS'; // Sigla UF
$enderEmit->fone = ''; // Fone
$bpe->tagenderEmit($enderEmit);

$comp = new stdClass();
$comp->xNome = 'HIDROVIAS';
$comp->CNPJ = '';
//$comp->CPF = '';
//$comp->idEstrangeiro = '';
$comp->IE = 'ISENTO';
$bpe->tagcomp($comp);

$enderComp = new stdClass();
$enderComp->xLgr = ''; // Logradouro
$enderComp->nro = ''; // Numero
$enderComp->xCpl = ''; // Complemento
$enderComp->xBairro = 'Centro'; // Bairro
$enderComp->cMun = '4318507'; // Código do município (utilizar a tabela do IBGE)
$enderComp->xMun = 'SAO JOSE DO NORTE'; // Nome do municipio
$enderComp->CEP = '96225000'; // CEP
$enderComp->UF = 'RS'; // Sigla UF
$enderComp->cPais = '55'; // Sigla UF
$enderComp->xPais = 'BR'; // Sigla UF
$enderComp->fone = ''; // Fone
$enderComp->email = 'teste@teste.com.br'; // Fone
$bpe->tagenderComp($enderComp);

$agencia = new stdClass();
$agencia->xNome = 'HIDROVIAS';
$agencia->CNPJ = '';
$bpe->tagagencia($agencia);

$enderAgencia = new stdClass();
$enderAgencia->xLgr = ''; // Logradouro
$enderAgencia->nro = ''; // Numero
$enderAgencia->xCpl = ''; // Complemento
$enderAgencia->xBairro = 'Centro'; // Bairro
$enderAgencia->cMun = '4318507'; // Código do município (utilizar a tabela do IBGE)
$enderAgencia->xMun = 'SAO JOSE DO NORTE'; // Nome do municipio
$enderAgencia->CEP = '96225000'; // CEP
$enderAgencia->UF = 'RS'; // Sigla UF
$enderAgencia->cPais = '55'; // Sigla UF
$enderAgencia->xPais = 'BR'; // Sigla UF
$enderAgencia->fone = ''; // Fone
$enderAgencia->email = 'teste@teste.com.br'; // Fone
$bpe->tagenderAgencia($enderAgencia);

//$infBPeSub = new stdClass();
//$infBPeSub->chBPe = '';
//$infBPeSub->tpSub = '';
//$bpe->taginfBPeSub($infBPeSub);

$infPassagem = new stdClass();
$infPassagem->cLocOrig = '4318507';
$infPassagem->xLocOrig = 'SAO JOSE DO NORTE';
$infPassagem->cLocDest = '4318507';
$infPassagem->xLocDest = 'SAO JOSE DO NORTE';
$infPassagem->dhEmb = date("Y-m-d\TH:i:sP");
$infPassagem->dhValidade = date("Y-m-d\TH:i:sP");
$bpe->taginfPassagem($infPassagem);

$infPassageiro = new stdClass();
$infPassageiro->xNome = 'Joao Silva';
$infPassageiro->CPF = '';
$infPassageiro->tpDoc = '';
$infPassageiro->nDoc = '';
//$infPassageiro->xDoc = '';
//$infPassageiro->dNasc = '';
//$infPassageiro->fone = '';
//$infPassageiro->email = '';
$bpe->taginfPassageiro($infPassageiro);

$infViagem = new stdClass();
$infViagem->cPercurso = '1';
$infViagem->xPercurso = 'PASSEIO';
$infViagem->tpViagem = '00';
$infViagem->tpServ = '1';
$infViagem->tpAcomodacao = '1';
$infViagem->tpTrecho = '1';
$infViagem->dhViagem = date("Y-m-d\TH:i:sP");
//$infViagem->dhConexao = '';
//$infViagem->prefixo = '';
//$infViagem->poltrona = '';
//$infViagem->plataforma = '';
$bpe->taginfViagem($infViagem);

//$infTravessia = new stdClass();
//$infTravessia->tpVeiculo = '';
//$infTravessia->sitVeiculo = '';
//$bpe->taginfTravessia($infTravessia);

$infValorBPe = new stdClass();
$infValorBPe->vBP = '10.00';
$infValorBPe->vDesconto = '1.00';
$infValorBPe->vPgto = '9.00';
$infValorBPe->vTroco = '0.00';
$infValorBPe->tpDesconto = '99';
$infValorBPe->xDesconto = 'valor de teste';
//$infValorBPe->cDesconto = '';
$bpe->taginfValorBPe($infValorBPe);

$infValorBPeComp = new stdClass();
$infValorBPeComp->tpComp = '01'; // tarifa
$infValorBPeComp->vComp = '10.00';
$bpe->taginfValorBPeComp($infValorBPeComp);

//$infValorBPeComp = new stdClass();
//$infValorBPeComp->tpComp = '04'; // seguro
//$infValorBPeComp->vComp = '1.00';
//$bpe->taginfValorBPeComp($infValorBPeComp);

$imp = new stdClass();
//$imp->vTotTrib = '';
//$imp->infAdFisco = '';
$bpe->tagimp($imp);

$impICMSICMS00 = new stdClass();
$impICMSICMS00->CST = '00';
$impICMSICMS00->vBC = '9.00';
$impICMSICMS00->pICMS = '12.00';
$impICMSICMS00->vICMS = '1.08';
$bpe->tagimpICMSICMS00($impICMSICMS00);

$pag = new stdClass();
$pag->tPag = '01'; //dinheiro
$pag->xPag = '';
$pag->nDocPag = '';
$pag->vPag = '11.00';
$bpe->tagpag($pag);

$infBPeSupl = new stdClass();
$infBPeSupl->qrCodBPe = 'https://bpe-portal.sefazvirtual.rs.gov.br/Site/qrCode?chBPe='.$chave.'&tpAmb=2';
$bpe->taginfBPeSupl($infBPeSupl);

try {
    $bpe->montaBPe();
    $xml = $bpe->getXML();
    $filename = "xml/{$chave}-bpe.xml";
    file_put_contents($filename, $xml);
//Assina
    $xml = $tools->signBPe($xml);
    $filename = "xml/{$chave}-bpe-sign.xml";
    file_put_contents($filename, $xml);
//    print_r($xml);
//envia
//Envia lote e autoriza
    $axmls[] = $xml;
    $lote = substr(str_replace(',', '', number_format(microtime(true) * 1000000, 0)), 0, 15);
    $res = $tools->sefazEnviaLote($axmls, $lote, true);
//Converte resposta
    $stdCl = new Standardize($res);
//Output array
    $arr = $stdCl->toArray();
    print_r($arr);
//Output object
    $std = $stdCl->toStd();
    if ($std->cStat != 103) {//103 - Lote recebido com Sucesso
        //processa erros
        print_r($arr);
    }
//Consulta Recibo
//    $res = $tools->sefazConsultaRecibo($std->infRec->nRec);
//    $stdCl = new Standardize($res);
//    $arr = $stdCl->toArray();
//    $std = $stdCl->toStd();
//    if ($std->protCTe->infProt->cStat == 100) {//Autorizado o uso do CT-e
//        adicionar protocolo
//        $auth = Complements::toAuthorize($xml, $res);
//        $filename = "xml/{$chave}-cteos-prot.xml";
//        file_put_contents($filename, $auth);
//
//
//    }
} catch (\Exception $e) {
    var_dump($e);
}
