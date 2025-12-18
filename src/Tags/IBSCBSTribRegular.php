<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;
use NFePHP\BPe\Common\Make;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe/imp/icms/icms[00|20|45|90]
 */
class IBSCBSTribRegular extends Tag implements TagInterface
{

    protected $name = 'gTribRegular';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';

    protected $possible = [

        'CSTReg' => [
            'type' => 'string',
            'regex' => '^[0-9]{3}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Código da Situação Tributária do Regime (CSTReg)',
            'format' => ''
        ],

        'cClassTribReg' => [
            'type' => 'string',
            'regex' => '^[0-9]{6}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Classificação Tributária do Regime (cClassTribReg)',
            'format' => ''
        ],

        'pAliqEfetRegIBSUF' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota Efetiva do IBS Estadual no Regime (pAliqEfetRegIBSUF)',
            'format' => '3v2-4'
        ],

        'vTribRegIBSUF' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do Tributo IBS Estadual no Regime (vTribRegIBSUF)',
            'format' => '13v2'
        ],

        'pAliqEfetRegIBSMun' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota Efetiva do IBS Municipal no Regime (pAliqEfetRegIBSMun)',
            'format' => '3v2-4'
        ],

        'vTribRegIBSMun' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do Tributo IBS Municipal no Regime (vTribRegIBSMun)',
            'format' => '13v2'
        ],

        'pAliqEfetRegCBS' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota Efetiva da CBS no Regime (pAliqEfetRegCBS)',
            'format' => '3v2-4'
        ],

        'vTribRegCBS' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor da CBS no Regime (vTribRegCBS)',
            'format' => '13v2'
        ],
    ];

    /**
     * DOMElement constructor
     * @return \DOMElement
     */

    public function toNode()
    {
        $node = $this->tagIBSCBSTribRegular();
        return $node;
    }

    public function tagIBSCBSTribRegular()
    {
        $std = $this->std;
        $possible = [
            'CSTReg',
            'cClassTribReg',
            'pAliqEfetRegIBSUF',
            'vTribRegIBSUF',
            'pAliqEfetRegIBSMun',
            'vTribRegIBSMun',
            'pAliqEfetRegCBS',
            'vTribRegCBS',
        ];
        $std = Make::equilizeParameters($std, $possible);
        $identificador = "UB68 <gTribRegular> -";
        $gTribRegular = $this->dom->createElement("gTribRegular");
        $this->dom->addChild(
            $gTribRegular,
            "CSTReg",
            $std->CSTReg,
            true,
            "$identificador Código de Situação Tributária do IBS e CBS (CSTReg)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "cClassTribReg",
            $std->cClassTribReg,
            true,
            "$identificador Informar qual seria o cClassTrib caso não cumprida a condição "
            . "resolutória/suspensiva (cClassTribReg)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegIBSUF",
            Make::conditionalNumberFormatting($std->pAliqEfetRegIBSUF, 4),
            true,
            "$identificador Alíquota do IBS da UF (pAliqEfetRegIBSUF)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegIBSUF",
            Make::conditionalNumberFormatting($std->vTribRegIBSUF),
            true,
            "$identificador Valor do IBS da UF (vTribRegIBSUF)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegIBSMun",
            Make::conditionalNumberFormatting($std->pAliqEfetRegIBSMun, 4),
            true,
            "$identificador Alíquota do IBS do Município (pAliqEfetRegIBSMun)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegIBSMun",
            Make::conditionalNumberFormatting($std->vTribRegIBSMun),
            true,
            "$identificador Valor do IBS do Município (vTribRegIBSMun)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegCBS",
            Make::conditionalNumberFormatting($std->pAliqEfetRegCBS, 4),
            true,
            "$identificador Alíquota da CBS (pAliqEfetRegCBS)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegCBS",
            Make::conditionalNumberFormatting($std->vTribRegCBS),
            true,
            "$identificador Valor da CBS (vTribRegCB)"
        );
        $this->gTribRegular = $gTribRegular;
        return $gTribRegular;
    }

}
