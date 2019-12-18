<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\BPe\Make;
use NFePHP\BPe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\BPe\Common\FakePretty;
use NFePHP\Common\Soap\SoapFake;

try {
    
    $make = new Make();
    
    // A tag infBPe é OPCIONAL e se não for passada será criada na construção
    // pelo metodo Make::parse()
    
    //$std = new \stdClass();
    //$std->id = '12345678901234567890123456789012345678901234';  //opcional será inserido de qq forma
    //$std->versao = '1.00'; //opcional será inserido de qq forma
    //$make->taginfbpe($std); //opcional será inserido de qq forma
    //uf aamm cnpj..........
    //35 1911 12345678901234 111163001000000100200000333
    //12 3456 78901234567890 123456789012345678901234
    $std = new \stdClass();
    $std->cUF = 35;
    $std->tpAmb = 2;
    //$std->mod = 63; //opcional será inserido de qq forma
    $std->serie = 1;
    $std->nBP = 100;
    $std->cBP = 333;
    //$std->cDV = 2;
    $std->modal = 1;
    $std->dhEmi = '2019-11-25T20:53:22-03:00';
    $std->tpEmis = 1;
    $std->verProc = '1.11';
    $std->tpBPe = 0;
    $std->indPres = 9;
    $std->ufini = 'SP';
    $std->cmunini = '1234567';
    $std->uffim = 'PR';
    $std->cmunfim = '7654321';
    $std->dhCont = '2019-11-25T16:20:03-03:00';
    $std->xJust = 'Teste OFFLINE de BPe em desenvolvimento';
    $make->tagide($std);

    $std = new \stdClass();
    $std->cnpj = '12345678901234';
    $std->ie = '12345678901';
    $std->iest = '99999999999';
    $std->xNome = 'VIAÇÃO HAMBURGO LTDA';
    $std->xFant = 'HAMBURGO';
    $std->im = '123456787';
    $std->cnae = '1234567';
    $std->crt = 3;
    $make->tagemit($std);

    $std = new \stdClass();
    $std->xLgr = 'Rua Santana do Mirante';
    $std->nro = '123';
    $std->xCpl = 'Sala 12';
    $std->xbairro = 'Centro';
    $std->cMun = 1234567;
    $std->xMun = 'Santa Cruz da Ribalta';
    $std->cep = '12345678';
    $std->uf = 'MG';
    $std->fone = '999999999';
    $std->email = 'fulano@hamburgo.com.br';
    $std->tar = 'C1233';
    $make->tagenderemit($std);

    $std = new \stdClass();
    $std->xNome = 'Fulano da Silva';
    $std->cnpj = null;
    //$std->cpf = '00000000000';
    $std->idestrangeiro = 'CC2993-12';
    //$std->ie = 'PR1234';
    $make->tagcomp($std);

    $std = new \stdClass();
    $std->xLgr = 'Rua Valdeci';
    $std->nro = '34';
    $std->xCpl = null;
    $std->xbairro = 'Vila Bulhões';
    $std->cMun = 1234567;
    $std->xMun = 'Santa Cruz da Ribalta';
    $std->cep = '12345678';
    $std->uf = 'MG';
    $std->fone = '999999999';
    $std->email = 'ciclano@gmail.com';
    $make->tagendercomp($std);

    $std = new \stdClass();
    $std->xNome = 'Agencia Galvão Passagens LTDA';
    $std->cnpj = '12345678901234';
    $make->tagagencia($std);

    $std = new \stdClass();
    $std->xLgr = 'Rua São Crispin';
    $std->nro = '2976';
    $std->xCpl = 'Loja 22';
    $std->xbairro = 'Centro';
    $std->cMun = 1234567;
    $std->xMun = 'Santa Cruz da Ribalta';
    $std->cep = '12345678';
    $std->uf = 'MG';
    $std->cPais = '1058';
    $std->xPais = 'Brasil';
    $std->fone = '999999999';
    $std->email = 'nome@galvao.com.br';
    $make->tagenderagencia($std);

    $std = new \stdClass();
    $std->chBPe = '12345678901234567890123456789012345678901234';
    $std->tpSub = 2; //1 - Remarcação 2 - Transferência 3 – Transferência e Remarcação
    $make->taginfbpesub($std);

    $std = new \stdClass();
    $std->cLocOrig = '1234567';
    $std->xLocOrig = 'Santa Cruz da Ribalta';
    $std->cLocDest = '9999999';
    $std->xLocDest = 'Campo Mourão';
    $std->dhEmb = '2019-11-29T12:05:00-03:00';
    $std->dhValidade = '2019-11-29T12:05:00-03:00';
    $make->taginfpassagem($std);

    $std = new \stdClass();
    $std->xNome = 'Beltrano de Tal';
    $std->CPF = null;
    $std->tpDoc = 5; //1-RG 2-Título de Eleitor 3-Passaporte 4-CNH 5-Outros
    $std->nDoc = '19202029';
    $std->xDoc = 'Carteira de Trabalho';
    $std->dNasc = '1987-12-31';
    $std->fone = '22222222';
    $std->email = 'beltrano@mail.com.br';
    $make->taginfpassageiro($std);

    $std = new \stdClass();
    $std->cPercurso = 'A12';
    $std->xPercurso = 'descricao do percurso';
    $std->tpViagem = '00';
    $std->tpServ = 1;
    $std->tpAcomodacao = 1;
    $std->tpTrecho = 2;
    $std->dhViagem = '2019-11-29T12:05:00-03:00';
    $std->dhConexao = null;
    $std->prefixo = 'XPT4';
    $std->poltrona = 23;
    $std->plataforma = 'A20';
    //subnode inftravessia
    $std->tpVeiculo = '01';
    $std->sitVeiculo = 1;
    $make->taginfviagem($std);
    
    $std = new \stdClass();
    $std->cPercurso = '2';
    $std->xPercurso = 'descricao do percurso 2';
    $std->tpViagem = '00';
    $std->tpServ = 1;
    $std->tpAcomodacao = 1;
    $std->tpTrecho = 2;
    $std->dhViagem = '2019-11-30T12:05:00-03:00';
    $std->dhConexao = null;
    $std->prefixo = 'ZZ4';
    $std->poltrona = 45;
    $std->plataforma = '2';
    //subnode inftravessia
    $std->tpVeiculo = null;
    $std->sitVeiculo = null;
    $make->taginfviagem($std);

    $std = new \stdClass();
    $std->vBP = 123.89789;
    $std->vDesconto = 10.50;
    $std->vPgto = 113.3911111;
    $std->vTroco = 0;
    $std->tpDesconto = '99'; //01 - Tarifa promocional 02 - Idoso 03 - Criança 04 - Deficiente 05 - Estudante 06 - Animal Doméstico 07 - Acordo Coletivo 08 - Profissional em Deslocamento 09 - Profissional da Empresa 10 - Jovem 99 - Outros
    $std->xDesconto = 'cara simpatico';
    $std->cDesconto = 'X991'; //informar apenas qunado tpDesconto = 99
    $make->taginfvalorbpe($std);

    $std = new \stdClass();
    $std->tpComp = '01'; //01 - TARIFA; 02 - PEDÁGIO; 03 - TAXA EMBARQUE; 04 - SEGURO; 05-TAXA DE MANUTENÇÃO RODOVIA (TMR); 06 - SERVIÇOS DE VENDA INTEGRADA (SVI); 99 - OUTROS
    $std->vComp = 80.50;
    $make->tagcompvalor($std);
    $std = new \stdClass();
    $std->tpComp = '02'; //01 - TARIFA; 02 - PEDÁGIO; 03 - TAXA EMBARQUE; 04 - SEGURO; 05-TAXA DE MANUTENÇÃO RODOVIA (TMR); 06 - SERVIÇOS DE VENDA INTEGRADA (SVI); 99 - OUTROS
    $std->vComp = 2.22;
    $make->tagcompvalor($std);
    $std = new \stdClass();
    $std->tpComp = '03'; //01 - TARIFA; 02 - PEDÁGIO; 03 - TAXA EMBARQUE; 04 - SEGURO; 05-TAXA DE MANUTENÇÃO RODOVIA (TMR); 06 - SERVIÇOS DE VENDA INTEGRADA (SVI); 99 - OUTROS
    $std->vComp = 14.00;
    $make->tagcompvalor($std);

    $std = new \stdClass();
    $std->CST = '90';
    $std->indsn = 1;
    $std->vtottrib = 22.08;
    $std->infAdFisco = 'Sei uma coisa qualquer';
    $std->pRedBC = 5;
    $std->vBC = 120.50;
    $std->pICMS = 10;
    $std->vICMS = 12.05;
    $std->vCred = 6.55;
    $make->tagicms($std);

    $std = new \stdClass();
    $std->vBCUFFim = 125.00;
    $std->pFCPUFFim = 0;
    $std->pICMSUFFim = 10;
    $std->pICMSInter = 7;
    $std->vFCPUFFim = 0;
    $std->vICMSUFFim = 12.5;
    $std->vICMSUFIni = 7;
    $make->tagicmsuffim($std);

    $std = new \stdClass();
    $std->cnpj = '12345678901234';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678901';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678902';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678903';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678904';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678905';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678906';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678907';
    $make->tagautxml($std);
    $std = new \stdClass();
    $std->cpf = '12345678908';
    $make->tagautxml($std);
    

    $std = new \stdClass();
    $std->tPag = '03';
    $std->xPag = 'sei lá so teste';
    $std->nDocPag = '123456789';
    $std->vPag = 201.33;

    $std->tpIntegra = 1;
    $std->CNPJ = '12345678901234';
    $std->tBand = '01';
    $std->xBand = 'nada';
    $std->cAut = '1234567878888';
    $std->nsuTrans = '022929292';
    $std->nsuHost = 'balblabla';
    $std->nParcelas = 1;
    $std->infAdCard = 'qq coisa';
    $make->tagpag($std);
    
    $std = new \stdClass();
    $std->tPag = '01';
    $std->xPag = 'dimdim';
    //$std->nDocPag = '123456789';
    $std->vPag = 100.00;
    $make->tagpag($std);



    $std = new \stdClass();
    //$std->infAdFisco = 'Senhor fisco já estou duro.';
    //$std->infCpl = 'complementando pegar emprestado para pagar o socio governo';
    $make->taginfadic($std);

    $std = new \stdClass();
    $std->cnpj = '12345678901234';
    $std->xcontato = 'Eu mais eu soft ltda';
    $std->email = 'eu@gmail.com';
    $std->fone = '999999999';
    //$std->idCSRT = '012';
    //$std->hashCSRT = '1234567890123456789012345';
    //$std->csrt = 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO';
    $make->tagresptec($std);

    $std = new \stdClass();
    //$std->qrCodBPe = 'http://dfe-portal.svrs.rs.gov.br/bpe/QrCode?chBPe=35191112345678901234630010000001002000003335&tpAmb=2';
    //$std->boardPassBPe = '123456789012345678901234567890123456789012345678901234567890';
    //$make->taginfbpesupl($std);
    
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
    
    //$tools->setSignatureInQRCode(true);
    //$xml = $make->parse();
    $xml = $tools->signBPe($make->parse());
    header('Content-Type: application/xml; charset=utf-8');
    echo "{$xml}";

} catch (\Exception $e) {
    echo $e->getMessage();
}