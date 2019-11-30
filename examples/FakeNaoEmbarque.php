<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\BPe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\BPe\Common\FakePretty;
use NFePHP\Common\Soap\SoapFake;

try {
    
    $content = file_get_contents('expired_certificate.pfx');
    $certificate = Certificate::readPfx($content, 'associacao');
    $config = json_encode([
        "atualizacao" => "2019-11-29 16:56:00",
        "tpAmb" => 2,
        "razaosocial" => "Fulano de Tal",
        "cnpj" => "12345678901234",
        "siglaUF" => "SP",
        "schemes" => "PL_BPe_100b",
        "versao" => '1.00'
    ]);
    $soap = new SoapFake();
    $soap->disableCertValidation(true);
    $soap->loadCertificate($certificate);
    
    $tools = new Tools($config, $certificate);
    $tools->loadSoapClass($soap);

    $response = $tools->sefazNaoEmbarque(
        '35345678901234567890123456789012345678901234',
        'Apenas um teste de de não embarque',
        '123456789012345'
    );
    
    echo FakePretty::prettyPrint($response, '');
    //header('Content-Type: application/xml; charset=utf-8');
    //echo "{$xmlsigned}";
} catch (\Exception $e) {
    echo $e->getMessage();
}