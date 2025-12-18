<?php

namespace NFePHP\BPe\Common;

/**
 * Class base responsible for communication with SEFAZ
 *
 * @category  NFePHP
 * @package   NFePHP\BPe\Common\Tools
 * @copyright NFePHP Copyright (c) 2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @author    Anderson Minuto Consoni Vaz <anderson at wdhouse dot com dot br>
 * @link      http://github.com/nfephp-org/sped-bpe for the canonical source repository
 */

use DOMDocument;
use InvalidArgumentException;
use RuntimeException;
use NFePHP\Common\Certificate;
use NFePHP\Common\Signer;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\Common\Soap\SoapInterface;
use NFePHP\Common\Strings;
use \NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\TimeZoneByUF;
use NFePHP\Common\UFList;
use NFePHP\Common\Validator;
use NFePHP\BPe\Factories\Header;
use NFePHP\BPe\Factories\QRCode;

class Tools
{
    /**
     * config class
     * @var \stdClass
     */
    public $config;
    /**
     * Path to storage folder
     * @var string
     */
    public $pathwsfiles = '';
    /**
     * Path to schemes folder
     * @var string
     */
    public $pathschemes = '';
    /**
     * ambiente
     * @var string
     */
    public $ambiente = 'homologacao';
    /**
     * Environment
     * @var int
     */
    public $tpAmb = 2;
    /**
     * contingency class
     * @var Contingency
     */
    public $contingency;
    /**
     * soap class
     * @var SoapInterface
     */
    public $soap;
    /**
     * Application version
     * @var string
     */
    public $verAplic = '';
    /**
     * last soap request
     * @var string
     */
    public $lastRequest = '';
    /**
     * last soap response
     * @var string
     */
    public $lastResponse = '';
    /**
     * certificate class
     * @var Certificate
     */
    protected $certificate;
    /**
     * Sign algorithm from OPENSSL
     * @var int
     */
    protected $algorithm = OPENSSL_ALGO_SHA1;
    /**
     * Canonical conversion options
     * @var array
     */
    protected $canonical = [true,false,null,null];
    /**
     * Model of BPe 63
     * @var int
     */
    protected $modelo = 63;
    /**
     * Version of layout
     * @var string
     */
    protected $versao = '1.00';
    /**
     * urlPortal
     * Inst�ncia do WebService
     *
     * @var string
     */
    protected $urlPortal = 'http://www.portalfiscal.inf.br/bpe';
    /**
     * urlcUF
     * @var string
     */
    protected $urlcUF = '';
    /**
     * urlVersion
     * @var string
     */
    protected $urlVersion = '';
    /**
     * urlService
     * @var string
     */
    protected $urlService = '';
    /**
     * @var string
     */
    protected $urlMethod = '';
    /**
     * @var string
     */
    protected $urlOperation = '';
    /**
     * @var string
     */
    protected $urlNamespace = '';
    /**
     * @var string
     */
    protected $urlAction = '';
    /**
     * @var \SOAPHeader
     */
    protected $objHeader;
    /**
     * @var string
     */
    protected $urlHeader = '';
    /**
     * @var bool
     */
    protected $allowSignatureInQRCode = false;
    /**
     * @var array
     */
    protected $soapnamespaces = [
        'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
        'xmlns:xsd' => "http://www.w3.org/2001/XMLSchema",
        'xmlns:soap' => "http://www.w3.org/2003/05/soap-envelope"
    ];
    /**
     * @var array
     */
    protected $availableVersions = [
        '1.00' => 'PL_BPe_100b_RTC'
    ];

    /**
     * Constructor
     * load configurations,
     * load Digital Certificate,
     * map all paths,
     * set timezone and
     * and instanciate Contingency::class
     * @param string $configJson content of config in json format
     * @param Certificate $certificate
     */
    public function __construct($configJson, Certificate $certificate)
    {
        $this->config = json_decode($configJson);
        $this->pathwsfiles = realpath(
            __DIR__ . '/../../storage'
        ).'/';
        $this->version($this->config->versao);
        $this->setEnvironmentTimeZone($this->config->siglaUF);
        $this->certificate = $certificate;
        $this->setEnvironment($this->config->tpAmb);
        if ($this->config->schemes) $this->availableVersions = ['1.00' => $this->config->schemes];
    }

    /**
     * Sets environment time zone
     * @param string $acronym (ou seja a sigla do estado)
     * @return void
     */
    public function setEnvironmentTimeZone($acronym)
    {
        date_default_timezone_set(TimeZoneByUF::get($acronym));
    }

    /**
     * Set application version
     * @param string $ver
     */
    public function setVerAplic($ver)
    {
        $this->verAplic = $ver;
    }
    
    /**
     * Set for inclusion of sign in qrcode string
     * @param bool $flag
     * @return bool
     */
    public function setSignatureInQRCode($flag = false)
    {
        return $this->allowSignatureInQRCode = $flag;
    }

    /**
     * Load Soap Class
     * Soap Class may be \NFePHP\Common\Soap\SoapNative
     * or \NFePHP\Common\Soap\SoapCurl
     * @param SoapInterface $soap
     * @return void
     */
    public function loadSoapClass(SoapInterface $soap)
    {
        $this->soap = $soap;
        $this->soap->loadCertificate($this->certificate);
    }

    /**
     * Set OPENSSL Algorithm using OPENSSL constants
     * @param int $algorithm
     * @return void
     */
    public function setSignAlgorithm($algorithm = OPENSSL_ALGO_SHA1)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Set or get model of document BPe = 63
     * @param int $model
     * @return int modelo class parameter
     */
    public function model($model = null)
    {
        if ($model == 63) {
            $this->modelo = $model;
        }
        return $this->modelo;
    }

    /**
     * Set or get parameter layout version
     * @param string $version
     * @return string
     * @throws InvalidArgumentException
     */
    public function version($version = '')
    {
        if (!empty($version)) {
            if (!array_key_exists($version, $this->availableVersions)) {
                throw new \InvalidArgumentException('Essa versão de layout não está disponível');
            }
            $this->versao = $version;
            $this->config->schemes = $this->availableVersions[$version];
            $this->pathschemes = realpath(
                __DIR__ . '/../../schemes/'. $this->config->schemes
            ).'/';
        }
        return $this->versao;
    }

    /**
     * Recover cUF number from state acronym
     * @param string $acronym Sigla do estado
     * @return int number cUF
     */
    public function getcUF($acronym)
    {
        return UFlist::getCodeByUF($acronym);
    }

    /**
     * Recover state acronym from cUF number
     * @param int $cUF
     * @return string acronym sigla
     */
    public function getAcronym($cUF)
    {
        return UFlist::getUFByCode($cUF);
    }

    /**
     * Validate cUF from the key content and returns the state acronym
     * @param string $chave
     * @return string
     * @throws InvalidArgumentException
     */
    public function validKeyByUF($chave)
    {
        $uf = $this->config->siglaUF;
        if ($uf != UFList::getUFByCode(substr($chave, 0, 2))) {
            throw new \InvalidArgumentException(
                "A chave do BPe indicado [$chave] não pertence a [$uf]."
            );
        }
        return $uf;
    }

    /**
     * Sign BPe
     * @param  string  $xml BPe xml content
     * @return string singed BPe xml
     * @throws RuntimeException
     */
    public function signBPe($xml)
    {
        //remove all invalid strings
        $xml = Strings::clearXmlString($xml);
        $dom = new Dom('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        if (!empty($dom->getElementsByTagName('Signature')->item(0))) {
            return $xml;
        }
        $signed = Signer::sign(
            $this->certificate,
            $xml,
            'infBPe',
            'Id',
            $this->algorithm,
            $this->canonical
        );
        $signed = $this->addQRCode($signed);
        $method = 'bpe';
        $this->isValid($this->versao, $signed, $method);
        return $signed;
    }
    
    protected function addQRCode($signed)
    {
        $dom = new Dom('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($signed);
        $infBPeSupl = !empty($dom->getElementsByTagName('infBPeSupl')->item(0))
            ? $dom->getElementsByTagName('infBPeSupl')->item(0)
            : null;
        $qr = null;
        if ($infBPeSupl != null) {
            $qr = !empty($infBPeSupl->getElementsByTagName('qrCodBPe')->item(0))
                ? $infBPeSupl->getElementsByTagName('qrCodBPe')->item(0)->nodeValue
                : null;
        }
        if ($qr != null) {
            return $signed;
        }
        $bpe = $dom->documentElement;
        
        $infBPe = $dom->getElementsByTagName('infBPe')->item(0);
        $chave = preg_replace('/[^0-9]/', '', $infBPe->getAttribute("Id"));
        $ide = $dom->getElementsByTagName('ide')->item(0);
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $tpAmb = $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $signature = $dom->getElementsByTagName('Signature')->item(0);
        $hash = base64_encode($this->certificate->privateKey->sign($chave));
        $uf = UFList::getUFByCode($cUF);
        $this->servico('BPeQrCode', $uf, $tpAmb);
        $url = $this->urlService;
        $qrcode = "{$url}?chBPe={$chave}&tpAmb={$tpAmb}";
        if ($this->allowSignatureInQRCode) {
            $qrcode .= "&sign={$hash}";
        }
        if (empty($infBPeSupl)) {
            //não existe a tag suplementar
            $infBPeSupl = $dom->createElement("infBPeSupl");
            $nodeqr = $infBPeSupl->appendChild($dom->createElement('qrCodBPe'));
            $nodeqr->appendChild($dom->createCDATASection($qrcode));
            $bpe->insertBefore($infBPeSupl, $signature);
            return $dom->saveXML();
        } else {
            //a tag já existe, então verificar se existe o node qrCodBPe
            $boardPassBPe = !empty($infBPeSupl->getElementsByTagName('boardPassBPe')->item(0)->nodeValue)
                ? $infBPeSupl->getElementsByTagName('boardPassBPe')->item(0)->nodeValue
                : null;
            //o node qr não existe
            $old = $bpe->removeChild($infBPeSupl);
            $infBPeSupl = $dom->createElement("infBPeSupl");
            $nodeqr = $infBPeSupl->appendChild($dom->createElement('qrCodBPe'));
            $nodeqr->appendChild($dom->createCDATASection($qrcode));
            if ($boardPassBPe != null) {
                $infBPeSupl->appendChild($dom->createElement('boardPassBPe', $boardPassBPe));
            }
            $bpe->insertBefore($infBPeSupl, $signature);
            return $dom->saveXML();
        }
    }

    /**
     * Performs xml validation with its respective
     * XSD structure definition document
     * NOTE: if dont exists the XSD file will return true
     * @param string $version layout version
     * @param string $body
     * @param string $method
     * @return boolean
     */
    protected function isValid($version, $body, $method)
    {
        $schema = $this->pathschemes.$method."_v$version.xsd";
        if (!is_file($schema)) {
            return true;
        }
        return Validator::isValid(
            $body,
            $schema
        );
    }

    /**
     * Alter environment from "homologacao" to "producao" and vice-versa
     * @param int $tpAmb
     * @return void
     */
    public function setEnvironment($tpAmb = 2)
    {
        if (!empty($tpAmb) && ($tpAmb == 1 || $tpAmb == 2)) {
            $this->tpAmb = $tpAmb;
            $this->ambiente = ($tpAmb == 1) ? 'producao' : 'homologacao';
        }
    }

    /**
     * Set option for canonical transformation see C14n
     * @param array $opt
     * @return array
     */
    public function canonicalOptions($opt = [true,false,null,null])
    {
        if (!empty($opt) && is_array($opt)) {
            $this->canonical = $opt;
        }
        return $this->canonical;
    }

    /**
     * Assembles all the necessary parameters for soap communication
     * @param string $service
     * @param string $uf
     * @param string $tpAmb
     * @param bool $ignoreContingency
     * @return void
     */
    protected function servico(
        $service,
        $uf,
        $tpAmb,
        $ignoreContingency = false
    ) {
        $ambiente = $tpAmb == 1 ? "producao" : "homologacao";
        $webs = new Webservices($this->getXmlUrlPath());
        $sigla = $uf;
        $stdServ = $webs->get($sigla, $ambiente, $this->modelo);
        if ($stdServ === false) {
            throw new \RuntimeException(
                "Nenhum serviço foi localizado para esta unidade "
                . "da federação [$sigla], com o modelo [$this->modelo]."
            );
        }
        if (empty($stdServ->$service->url)) {
            throw new \RuntimeException(
                "Este serviço [$service] não está disponivel para esta "
                . "unidade da federação [$uf] ou para este modelo ["
                . $this->modelo
                ."]."
            );
        }
        $this->urlcUF = $this->getcUF($uf);
        $this->urlVersion = $stdServ->$service->version;
        $this->urlService = $stdServ->$service->url;
        $this->urlMethod = $stdServ->$service->method;
        $this->urlOperation = $stdServ->$service->operation;
        $this->urlNamespace = sprintf(
            "%s/wsdl/%s",
            $this->urlPortal,
            $this->urlOperation
        );
        $this->urlHeader = Header::get(
            $this->urlNamespace,
            $this->urlcUF,
            $this->urlVersion
        );
        $this->urlAction = "\""
            . $this->urlNamespace
            . "/"
            . $this->urlMethod
            . "\"";
    }

    /**
     * Send request message to webservice
     * @param array $parameters
     * @param string $request
     * @return string
     */
    protected function sendRequest($request, array $parameters = [])
    {
        $this->checkSoap();
        return (string) $this->soap->send(
            $this->urlService,
            $this->urlMethod,
            $this->urlAction,
            SOAP_1_2,
            $parameters,
            $this->soapnamespaces,
            $request
        );
    }

    /**
     * Recover path to xml data base with list of soap services
     * @return string
     */
    protected function getXmlUrlPath()
    {
        $file = $this->pathwsfiles
            . DIRECTORY_SEPARATOR
            . "wsbpe_".$this->versao."_mod63.xml";
        if (! file_exists($file)) {
            return '';
        }
        return file_get_contents($file);
    }
    
    /**
     * Verify if SOAP class is loaded, if not, force load SoapCurl
     */
    protected function checkSoap()
    {
        if (empty($this->soap)) {
            $this->soap = new SoapCurl($this->certificate);
        }
    }
}
