<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;
use NFePHP\BPe\Common\Make;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe/imp/icms/icms[00|20|45|90]
 */
class TribCompraGov extends Tag implements TagInterface
{

    protected $name = 'gTribCompraGov';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    protected $possible = [
        'pAliqIBSUF' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota do IBS de competência da UF (pAliqIBSUF)',
            'format' => '3v2-4'
        ],
        'vTribIBSUF' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do IBS devido à UF (vTribIBSUF)',
            'format' => '13v2'
        ],
        'pAliqIBSMun' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota do IBS de competência do município (pAliqIBSMun)',
            'format' => '3v2-4'
        ],
        'vTribIBSMun' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do IBS devido ao município (vTribIBSMun)',
            'format' => '13v2'
        ],
        'pAliqCBS' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota da CBS aplicada à BC (pAliqCBS)',
            'format' => '3v2-4'
        ],
        'vTribCBS' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor da CBS (vTribCBS)',
            'format' => '13v2'
        ],
    ];
    public $std = '';

    /**
     * DOMElement constructor
     * @return \DOMElement
     */

    public function taggTribCompraGov()
    {
        $std = $this->std;
        $possible = [
            'pAliqIBSUF',
            'vTribIBSUF',
            'pAliqIBSMun',
            'vTribIBSMun',
            'pAliqCBS',
            'vTribCBS',
        ];
        $std = Make::equilizeParameters($std, $possible);
        $identificador = "UB82a <gTribCompraGov> -";
        $gTrib = $this->dom->createElement("gTribCompraGov");
        $this->dom->addChild(
            $gTrib,
            "pAliqIBSUF",
            Make::conditionalNumberFormatting($std->pAliqIBSUF, 4),
            true,
            "$identificador Alíquota do IBS de competência do Estado. (pAliqIBSUF)"
        );
        $this->dom->addChild(
            $gTrib,
            "vTribIBSUF",
            Make::conditionalNumberFormatting($std->vTribIBSUF),
            true,
            "$identificador Valor do Tributo do IBS da UF calculado. (vTribIBSUF)"
        );
        $this->dom->addChild(
            $gTrib,
            "pAliqIBSMun",
            Make::conditionalNumberFormatting($std->pAliqIBSMun, 4),
            true,
            "$identificador Alíquota do IBS de competência do Município. (pAliqIBSMun)"
        );
        $this->dom->addChild(
            $gTrib,
            "vTribIBSMun",
            Make::conditionalNumberFormatting($std->vTribIBSMun),
            true,
            "$identificador Valor do Tributo do IBS do Município calculado. (vTribIBSMun)"
        );
        $this->dom->addChild(
            $gTrib,
            "pAliqCBS",
            Make::conditionalNumberFormatting($std->pAliqCBS, 4),
            true,
            "$identificador Alíquota da CBS. (pAliqCBS)"
        );
        $this->dom->addChild(
            $gTrib,
            "vTribCBS",
            Make::conditionalNumberFormatting($std->vTribCBS),
            true,
            "$identificador Valor do Tributo da CBS calculado. (vTribCBS)"
        );
        $this->gTribCompraGov = $gTrib;
        return $gTrib;
    }
}
