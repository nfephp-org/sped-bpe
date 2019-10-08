<?php
namespace NFePHP\BPe;

/**
 * Classe a construção do xml do BPe modelo 63
 * Esta classe basica está estruturada para montar XML do BPe para o
 * layout versão 1.00, os demais modelos serão derivados deste
 *
 * @category  API
 * @package   NFePHP\Bpe\
 * @copyright Copyright (c) 2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Anderson Minuto Consoni Vaz <anderson at wdhouse dot com dot br>
 * @link      http://github.com/nfephp-org/sped-bpe for the canonical source repository
 */
use stdClass;
use RuntimeException;
use InvalidArgumentException;
use DOMElement;
use DateTime;
use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;

class Make
{
    /**
     * @var array
     */
    public $erros = [];

    /**
     * versao
     * numero da versão do xml da CTe
     * @var string
     */
    public $versao = '1.00';
    /**
     * xml
     * String com o xml do documento fiscal montado
     * @var string
     */
    public $xml = '';
    /**
     * dom
     * Variável onde será montado o xml do documento fiscal
     * @var \NFePHP\Common\Dom\Dom
     */
    public $dom;

    /**
     * tpAmb
     * tipo de ambiente
     * @var string
     */
    public $tpAmb = '2';

    /**
     * mod
     * modelo da BPe 63
     * @var integer
     */
    public $mod = 63;

    /**
     * Informações do BPe
     * @var \DOMNode
     */
    private $BPe = '';

    /**
     * Identificação do BPe
     * @var \DOMNode
     */
    private $infBPe = '';

    /**
     * Identificação do BPe
     * @var \DOMNode
     */
    private $ide = '';

    /**
     * Identificação do emitente do BPe
     * @var \DOMNode
     */
    private $emit = '';

    /**
     * Identificação do endereço do emitente do BPe
     * @var \DOMNode
     */
    private $enderEmit = '';

    /**
     * Identificação do comprador
     * @var \DOMNode
     */
    private $comp = '';

    /**
     * Identificação do endereço do comprador
     * @var \DOMNode
     */
    private $enderComp = '';

    /**
     * Identificação da agencia
     * @var \DOMNode
     */
    private $agencia = '';

    /**
     * Identificação do endereço da agencia
     * @var \DOMNode
     */
    private $enderAgencia = '';

    /**
     * Informações substituição BPe
     * @var \DOMNode
     */
    private $infBPeSub = '';

    /**
     * Informações do detalhamento da passagem
     * @var \DOMNode
     */
    private $infPassagem = '';

    /**
     * Informações do passageiro
     * @var \DOMNode
     */
    private $infPassageiro = '';

    /**
     * Informações da viagem
     * @var \DOMNode
     */
    private $infViagem = '';

    /**
     * Informações da travessia
     * @var \DOMNode
     */
    private $infTravessia = '';

    /**
     * Informações dos valores do BPe
     * @var \DOMNode
     */
    private $infValorBPe = '';

    /**
     * Informações componentes dos valores do BPe
     * @var \DOMNode
     */
    private $infValorBPeComp = array();

    /**
     * Informações relativas a impostos
     * @var \DOMNode
     */
    private $imp = '';

    /**
     * Informações relativas ao ICMS
     * @var \DOMNode
     */
    private $impICMS = '';

    /**
     * Informações relativas a prestação sujeito a tributacao normal do ICMS
     * @var \DOMNode
     */
    private $impICMSICMS00 = '';

    /**
     * Dados do pagamento
     * @var \DOMNode
     */
    private $pag = '';

    /**
     * Informações suplementares do BPe
     * @var \DOMNode
     */
    private $infBPeSupl = '';

    public function __construct()
    {
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;
    }

    /**
     * Returns xml string and assembly it is necessary
     * @return string
     */
    public function getXML()
    {
        if (empty($this->xml)) {
            $this->montaBPe();
        }
        return $this->xml;
    }

    public function taginfBPe($std)
    {
        $chave = preg_replace('/[^0-9]/', '', $std->Id);
        $this->infBPe = $this->dom->createElement('infBPe');
        $this->infBPe->setAttribute('Id', 'BPe' . $chave);
        $this->infBPe->setAttribute('versao', $std->versao);
        return $this->infBPe;
    }

    public function tagide($std)
    {
        $this->tpAmb = $std->tpAmb;
        $this->mod = $std->mod;
        $identificador = '#4 <ide> - ';
        $this->ide = $this->dom->createElement('ide');
        $this->dom->addChild(
            $this->ide,
            'cUF',
            $std->cUF,
            true,
            $identificador . 'Código da UF do emitente do CT-e'
        );
        $this->dom->addChild(
            $this->ide,
            'tpAmb',
            $std->tpAmb,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'mod',
            $std->mod,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'serie',
            $std->serie,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'nBP',
            $std->nBP,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'cBP',
            $std->cBP,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'cDV',
            $std->cDV,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'modal',
            $std->modal,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'dhEmi',
            $std->dhEmi,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'tpEmis',
            $std->tpEmis,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'verProc',
            $std->verProc,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'tpBPe',
            $std->tpBPe,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'indPres',
            $std->indPres,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'UFIni',
            $std->UFIni,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'cMunIni',
            $std->cMunIni,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'UFFim',
            $std->UFFim,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'cMunFim',
            $std->cMunFim,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->ide,
            'dhCont',
            $std->dhCont,
            false,
            $identificador . 'Data e Hora da entrada em contingência'
        );
        $this->dom->addChild(
            $this->ide,
            'xJust',
            Strings::replaceSpecialsChars(substr(trim($std->xJust), 0, 256)),
            false,
            $identificador . 'Justificativa da entrada em contingência'
        );
        return $this->ide;
    }

    /**
     * @param $std
     * @return DOMElement|\DOMNode
     */
    public function tagemit($std)
    {
        $identificador = '#3 <emit> - ';
        $this->emit = $this->dom->createElement('emit');
        $this->dom->addChild(
            $this->emit,
            'CNPJ',
            $std->CNPJ,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->emit,
            'IE',
            Strings::onlyNumbers($std->IE),
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->emit,
            'IEST',
            Strings::onlyNumbers($std->IEST),
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->emit,
            'xNome',
            $std->xNome,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->emit,
            'xFant',
            $std->xFant,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->emit,
            'IM',
            $std->IM,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->emit,
            'CNAE',
            $std->CNAE,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->emit,
            'CRT',
            $std->CRT,
            true,
            $identificador . ''
        );
        $this->TAR = $std->TAR;
//        if (isset($std->TAR)) {
//            $this->dom->addChild(
//                $this->emit,
//                'TAR',
//                $std->TAR,
//                true,
//                $identificador . ''
//            );
//        }
        return $this->emit;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function tagenderEmit($std)
    {
        $identificador = '#33 <enderEmit> - ';
        $this->enderEmit = $this->dom->createElement('enderEmit');
        $this->dom->addChild(
            $this->enderEmit,
            'xLgr',
            $std->xLgr,
            true,
            $identificador . 'Logradouro'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'nro',
            $std->nro,
            true,
            $identificador . 'Número'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'xCpl',
            $std->xCpl,
            false,
            $identificador . 'Complemento'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'xBairro',
            $std->xBairro,
            true,
            $identificador . 'Bairro'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'cMun',
            $std->cMun,
            true,
            $identificador . 'Código do município'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'xMun',
            $std->xMun,
            true,
            $identificador . 'Nome do município'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'CEP',
            $std->CEP,
            false,
            $identificador . 'CEP'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'UF',
            $std->UF,
            true,
            $identificador . 'Sigla da UF'
        );
        $this->dom->addChild(
            $this->enderEmit,
            'fone',
            $std->fone,
            false,
            $identificador . 'Telefone'
        );
        return $this->enderEmit;
    }

    /**
     * @param $std
     * @return DOMElement|\DOMNode
     */
    public function tagcomp($std)
    {
        $identificador = '#45 <comp> - ';
        $this->comp = $this->dom->createElement('comp');
        $this->dom->addChild(
            $this->comp,
            'xNome',
            $std->xNome,
            true,
            $identificador . ''
        );
        if ($std->CNPJ != '') {
            $this->dom->addChild(
                $this->comp,
                'CNPJ',
                $std->CNPJ,
                true,
                $identificador . ''
            );
        } elseif ($std->CPF != '') {
            $this->dom->addChild(
                $this->comp,
                'CPF',
                $std->CPF,
                true,
                $identificador . ''
            );
        } else {
            $this->dom->addChild(
                $this->comp,
                'CNPJ',
                $std->CNPJ,
                true,
                $identificador . ''
            );
            $this->dom->addChild(
                $this->comp,
                'CPF',
                $std->CPF,
                true,
                $identificador . ''
            );
        }
        if (isset($std->idEstrangeiro)) {
            $this->dom->addChild(
                $this->comp,
                'idEstrangeiro',
                $std->idEstrangeiro,
                true,
                $identificador . ''
            );
        }
        $this->dom->addChild(
            $this->comp,
            'IE',
            $std->IE,
            true,
            $identificador . ''
        );
        return $this->comp;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function tagenderComp($std)
    {
        $identificador = '#51 <enderComp> - ';
        $this->enderComp = $this->dom->createElement('enderComp');
        $this->dom->addChild(
            $this->enderComp,
            'xLgr',
            $std->xLgr,
            true,
            $identificador . 'Logradouro'
        );
        $this->dom->addChild(
            $this->enderComp,
            'nro',
            $std->nro,
            true,
            $identificador . 'Número'
        );
        $this->dom->addChild(
            $this->enderComp,
            'xCpl',
            $std->xCpl,
            false,
            $identificador . 'Complemento'
        );
        $this->dom->addChild(
            $this->enderComp,
            'xBairro',
            $std->xBairro,
            true,
            $identificador . 'Bairro'
        );
        $this->dom->addChild(
            $this->enderComp,
            'cMun',
            $std->cMun,
            true,
            $identificador . 'Código do município'
        );
        $this->dom->addChild(
            $this->enderComp,
            'xMun',
            $std->xMun,
            true,
            $identificador . 'Nome do município'
        );
        $this->dom->addChild(
            $this->enderComp,
            'CEP',
            $std->CEP,
            false,
            $identificador . 'CEP'
        );
        $this->dom->addChild(
            $this->enderComp,
            'UF',
            $std->UF,
            true,
            $identificador . 'Sigla da UF'
        );
        $this->dom->addChild(
            $this->enderComp,
            'cPais',
            $std->cPais,
            true,
            $identificador . 'Codigo do Pais'
        );
        $this->dom->addChild(
            $this->enderComp,
            'xPais',
            $std->xPais,
            true,
            $identificador . 'Nome do Pais'
        );
        $this->dom->addChild(
            $this->enderComp,
            'fone',
            $std->fone,
            false,
            $identificador . 'Telefone'
        );
        $this->dom->addChild(
            $this->enderComp,
            'email',
            $std->email,
            false,
            $identificador . 'Email'
        );
        return $this->enderComp;
    }

    /**
     * @param $std
     * @return DOMElement|\DOMNode
     */
    public function tagagencia($std)
    {
        $identificador = '#64 <agencia> - ';
        $this->agencia = $this->dom->createElement('agencia');
        $this->dom->addChild(
            $this->agencia,
            'xNome',
            $std->xNome,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->agencia,
            'CNPJ',
            $std->CNPJ,
            true,
            $identificador . ''
        );
        return $this->agencia;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function tagenderAgencia($std)
    {
        $identificador = '#67 <enderAgencia> - ';
        $this->enderAgencia = $this->dom->createElement('enderAgencia');
        $this->dom->addChild(
            $this->enderAgencia,
            'xLgr',
            $std->xLgr,
            true,
            $identificador . 'Logradouro'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'nro',
            $std->nro,
            true,
            $identificador . 'Número'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'xCpl',
            $std->xCpl,
            false,
            $identificador . 'Complemento'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'xBairro',
            $std->xBairro,
            true,
            $identificador . 'Bairro'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'cMun',
            $std->cMun,
            true,
            $identificador . 'Código do município'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'xMun',
            $std->xMun,
            true,
            $identificador . 'Nome do município'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'CEP',
            $std->CEP,
            false,
            $identificador . 'CEP'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'UF',
            $std->UF,
            true,
            $identificador . 'Sigla da UF'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'cPais',
            $std->cPais,
            true,
            $identificador . 'Codigo do Pais'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'xPais',
            $std->xPais,
            true,
            $identificador . 'Nome do Pais'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'fone',
            $std->fone,
            false,
            $identificador . 'Telefone'
        );
        $this->dom->addChild(
            $this->enderAgencia,
            'email',
            $std->email,
            false,
            $identificador . 'Email'
        );
        return $this->enderAgencia;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function taginfBPeSub($std)
    {
        $identificador = '#80 <infBPeSub> - ';
        $this->infBPeSub = $this->dom->createElement('infBPeSub');
        $this->dom->addChild(
            $this->infBPeSub,
            'chBPe',
            $std->chBPe,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infBPeSub,
            'tpSub',
            $std->tpSub,
            true,
            $identificador . ''
        );
        return $this->infBPeSub;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function taginfPassagem($std)
    {
        $identificador = '#83 <infPassagem> - ';
        $this->infPassagem = $this->dom->createElement('infPassagem');
        $this->dom->addChild(
            $this->infPassagem,
            'cLocOrig',
            $std->cLocOrig,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infPassagem,
            'xLocOrig',
            $std->xLocOrig,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infPassagem,
            'cLocDest',
            $std->cLocDest,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infPassagem,
            'xLocDest',
            $std->xLocDest,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infPassagem,
            'dhEmb',
            $std->dhEmb,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infPassagem,
            'dhValidade',
            $std->dhValidade,
            true,
            $identificador . ''
        );
        return $this->infPassagem;
    }
    /**
     * @param $std
     * @return DOMElement
     */
    public function taginfPassageiro($std)
    {
        $identificador = '#90 <infPassageiro> - ';
        $this->infPassageiro = $this->dom->createElement('infPassageiro');
        $this->dom->addChild(
            $this->infPassageiro,
            'xNome',
            $std->xNome,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infPassageiro,
            'CPF',
            $std->CPF,
            true,
            $identificador . ''
        );
        if (isset($std->tpDoc)) {
            $this->dom->addChild(
                $this->infPassageiro,
                'tpDoc',
                $std->tpDoc,
                true,
                $identificador . ''
            );
            $this->dom->addChild(
                $this->infPassageiro,
                'nDoc',
                $std->nDoc,
                true,
                $identificador . ''
            );
            if (isset($std->xDoc)) {
                $this->dom->addChild(
                    $this->infPassageiro,
                    'xDoc',
                    $std->xDoc,
                    true,
                    $identificador . ''
                );
            }
        }
        if (isset($std->dNasc)) {
            $this->dom->addChild(
                $this->infPassageiro,
                'dNasc',
                $std->dNasc,
                true,
                $identificador . ''
            );
        }
        if (isset($std->fone)) {
            $this->dom->addChild(
                $this->infPassageiro,
                'fone',
                $std->fone,
                true,
                $identificador . ''
            );
        }
        if (isset($std->email)) {
            $this->dom->addChild(
                $this->infPassageiro,
                'email',
                $std->email,
                true,
                $identificador . ''
            );
        }
        return $this->infPassageiro;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function taginfViagem($std)
    {
        $identificador = '#99 <infViagem> - ';
        $this->infViagem = $this->dom->createElement('infViagem');
        $this->dom->addChild(
            $this->infViagem,
            'cPercurso',
            $std->cPercurso,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infViagem,
            'xPercurso',
            $std->xPercurso,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infViagem,
            'tpViagem',
            $std->tpViagem,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infViagem,
            'tpServ',
            $std->tpServ,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infViagem,
            'tpAcomodacao',
            $std->tpAcomodacao,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infViagem,
            'tpTrecho',
            $std->tpTrecho,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infViagem,
            'dhViagem',
            $std->dhViagem,
            true,
            $identificador . ''
        );
        if (isset($std->dhConexao)) {
            $this->dom->addChild(
                $this->infViagem,
                'dhConexao',
                $std->dhConexao,
                true,
                $identificador . ''
            );
        }
        if (isset($std->prefixo)) {
            $this->dom->addChild(
                $this->infViagem,
                'prefixo',
                $std->prefixo,
                true,
                $identificador . ''
            );
        }
        if (isset($std->poltrona)) {
            $this->dom->addChild(
                $this->infViagem,
                'poltrona',
                $std->poltrona,
                true,
                $identificador . ''
            );
        }
        if (isset($std->plataforma)) {
            $this->dom->addChild(
                $this->infViagem,
                'plataforma',
                $std->plataforma,
                true,
                $identificador . ''
            );
        }
        return $this->infViagem;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function taginfTravessia($std)
    {
        $identificador = '#188 <infTravessia> - ';
        $this->infTravessia = $this->dom->createElement('infTravessia');
        $this->dom->addChild(
            $this->infTravessia,
            'tpVeiculo',
            $std->tpVeiculo,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infTravessia,
            'sitVeiculo',
            $std->sitVeiculo,
            true,
            $identificador . ''
        );
        return $this->infTravessia;
    }


    /**
     * @param $std
     * @return DOMElement
     */
    public function taginfValorBPe($std)
    {
        $identificador = '#114 <infValorBPe> - ';
        $this->infValorBPe = $this->dom->createElement('infValorBPe');
        $this->dom->addChild(
            $this->infValorBPe,
            'vBP',
            $std->vBP,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infValorBPe,
            'vDesconto',
            $std->vDesconto,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infValorBPe,
            'vPgto',
            $std->vPgto,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->infValorBPe,
            'vTroco',
            $std->vTroco,
            true,
            $identificador . ''
        );
        if (isset($std->tpDesconto)) {
            $this->dom->addChild(
                $this->infValorBPe,
                'tpDesconto',
                $std->tpDesconto,
                true,
                $identificador . ''
            );
            $this->dom->addChild(
                $this->infValorBPe,
                'xDesconto',
                $std->xDesconto,
                true,
                $identificador . ''
            );
            if (isset($std->cDesconto)) {
                $this->dom->addChild(
                    $this->infValorBPe,
                    'cDesconto',
                    $std->cDesconto,
                    true,
                    $identificador . ''
                );
            }
        }
        return $this->infValorBPe;
    }

    /**
     * @param $std
     * @return \DOMNode
     */
    public function taginfValorBPeComp($std)
    {
        $identificador = '#122 <Comp> - ';
        $infValorBPeCompN = $this->dom->createElement('Comp');
        $this->dom->addChild(
            $infValorBPeCompN,
            'tpComp',
            $std->tpComp,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $infValorBPeCompN,
            'vComp',
            $std->vComp,
            true,
            $identificador . ''
        );
        $this->infValorBPeComp[] = $infValorBPeCompN;
        return $this->infValorBPeComp;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function tagimp($std)
    {
        $identificador = '#125 <imp> - ';
        $this->imp = $this->dom->createElement('imp');
        $this->impICMS = $this->dom->createElement('ICMS');
        if (isset($std->vTotTrib)) {
            $this->dom->addChild(
                $this->imp,
                'vTotTrib',
                $std->vTotTrib,
                true,
                $identificador . ''
            );
        }
        if (isset($std->infAdFisco)) {
            $this->dom->addChild(
                $this->imp,
                'infAdFisco',
                $std->infAdFisco,
                true,
                $identificador . ''
            );
        }
        return $this->imp;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function tagimpICMSICMS00($std)
    {
        $identificador = '#127 <ICMS00> - ';
        $this->impICMSICMS00 = $this->dom->createElement('ICMS00');
        $this->dom->addChild(
            $this->impICMSICMS00,
            'CST',
            $std->CST,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->impICMSICMS00,
            'vBC',
            $std->vBC,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->impICMSICMS00,
            'pICMS',
            $std->pICMS,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->impICMSICMS00,
            'vICMS',
            $std->vICMS,
            true,
            $identificador . ''
        );
        return $this->impICMSICMS00;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function tagpag($std)
    {
        $identificador = '#160 <pag> - ';
        $this->pag = $this->dom->createElement('pag');
        $this->dom->addChild(
            $this->pag,
            'tPag',
            $std->tPag,
            true,
            $identificador . ''
        );
        $this->dom->addChild(
            $this->pag,
            'vPag',
            $std->vPag,
            true,
            $identificador . ''
        );
        return $this->pag;
    }

    /**
     * @param $std
     * @return DOMElement
     */
    public function taginfBPeSupl($std)
    {
        $this->infBPeSupl = $this->dom->createElement('infBPeSupl');
        $cdata = $this->dom->createCDATASection($std->qrCodBPe);
        $qrCodBPe = $this->dom->createElement('qrCodBPe');
        $qrCodBPe->appendChild($cdata);
        $this->infBPeSupl->appendChild($qrCodBPe);
        return $this->infBPeSupl;
    }

    /**
     * Tag raiz do documento xml
     * Função chamada pelo método [ monta ]
     * @return \DOMElement
     */
    private function buildBPe()
    {
        if (empty($this->BPe)) {
            $this->BPe = $this->dom->createElement('BPe');
            $this->BPe->setAttribute('xmlns', 'http://www.portalfiscal.inf.br/bpe');
        }
        return $this->BPe;
    }

    public function montaBPe()
    {
        if (count($this->erros) > 0) {
            return false;
        }
        $this->buildBPe();
        $this->dom->appChild($this->infBPe, $this->ide, 'Falta tag "infBPe"');
        $this->dom->appChild($this->emit, $this->enderEmit, 'Falta tag "emit"');
        $this->dom->addChild(
            $this->emit,
            'TAR',
            $this->TAR,
            true,
            'TAR'
        );
        $this->dom->appChild($this->infBPe, $this->emit, 'Falta tag "infCte"');

        if ($this->comp != '') {
            if ($this->enderComp != '') {
                $this->dom->appChild($this->comp, $this->enderComp, 'Falta tag "comp"');
            }
            $this->dom->appChild($this->infBPe, $this->comp, 'Falta tag "infCte"');
        }

        $this->dom->appChild($this->agencia, $this->enderAgencia, 'Falta tag "agencia"');
        $this->dom->appChild($this->infBPe, $this->agencia, 'Falta tag "infCte"');
        if ($this->infBPeSub != '') {
            $this->dom->appChild($this->infBPe, $this->infBPeSub, 'Falta tag "infCte"');
        }
        if ($this->infPassageiro != '') {
            $this->dom->appChild($this->infPassagem, $this->infPassageiro, 'Falta tag "infPassagem"');
        }
        $this->dom->appChild($this->infBPe, $this->infPassagem, 'Falta tag "infCte"');
        if ($this->infTravessia != '') {
            $this->dom->appChild($this->infViagem, $this->infTravessia, 'Falta tag "infViagem"');
        }
        $this->dom->appChild($this->infBPe, $this->infViagem, 'Falta tag "infCte"');
        if (count($this->infValorBPeComp) > 0) {
            foreach ($this->infValorBPeComp as $key => $value) {
                $this->dom->appChild($this->infValorBPe, $value, 'Falta tag "infValorBPe"');
            }
        }
        $this->dom->appChild($this->infBPe, $this->infValorBPe, 'Falta tag "infCte"');
        if ($this->impICMSICMS00 != '') {
            $this->dom->appChild($this->impICMS, $this->impICMSICMS00, 'Falta tag "impICMS"');
        }
        $this->dom->appChild($this->imp, $this->impICMS, 'Falta tag "imp"');
        $this->dom->appChild($this->infBPe, $this->imp, 'Falta tag "infCte"');

        $this->dom->appChild($this->infBPe, $this->pag, 'Falta tag "infCte"');


        //[1] tag infBPe
        $this->dom->appChild($this->BPe, $this->infBPe, 'Falta tag "BPe"');
        $this->dom->appChild($this->BPe, $this->infBPeSupl, 'Falta tag "BPe"');
        //[0] tag BPe
        $this->dom->appendChild($this->BPe);

        $this->xml = $this->dom->saveXML();
        return true;
    }
}
