<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;
use NFePHP\BPe\Common\Make;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe/imp/icms/icms[00|20|45|90]
 */
class EstornoCred extends Tag implements TagInterface
{

    protected $name = 'gEstornoCred';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    protected $possible = [
        'vIBSEstCred' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do crédito de IBS Estadual (vIBSEstCred)',
            'format' => '13v2'
        ],

        'vCBSEstCred' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do crédito de CBS Estadual (vCBSEstCred)',
            'format' => '13v2'
        ],
    ];

    /**
     * DOMElement constructor
     * @return \DOMElement
     */

    public function toNode()
    {
        $node = $this->EstornoCred();
        return $node;
    }

    public function EstornoCred()
    {
        $std = $this->std;
        $possible = [
            'item',
            'vIBSEstCred',
            'vCBSEstCred',
        ];
        $std = Make::equilizeParameters($std, $possible);
        $identificador = "UB116 gEstornoCred: ";

        $estorno = $this->dom->createElement("gEstornoCred");
        $this->dom->addChild(
            $estorno,
            "vIBSEstCred",
            Make::conditionalNumberFormatting($std->vIBSEstCred),
            true,
            "$identificador Valor do IBS a ser estornado (vIBSEstCred)"
        );
        $this->dom->addChild(
            $estorno,
            "vCBSEstCred",
            Make::conditionalNumberFormatting($std->vCBSEstCred),
            true,
            "$identificador Valor do CBS a ser estornado (vCBSEstCred)"
        );
        $this->aGEstornoCred = $estorno;
        return $estorno;
    }
}
