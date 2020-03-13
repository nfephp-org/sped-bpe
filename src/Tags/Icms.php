<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe/imp/icms/icms[00|20|45|90]
 */
class Icms extends Tag implements TagInterface
{

    protected $name = 'ICMS';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    protected $possible = [
        'CST'        => [
            'type'     => 'number',
            'regex'    => '^(00|20|45|90)$',
            'position' => 'node',
            'required' => true,
            'info'     => 'classificação Tributária do Serviço',
            'format'   => ''
        ],
        'indSN'      => [
            'type'     => 'integer',
            'regex'    => '^(1)$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Indica se o contribuinte é Simples Nacional',
            'format'   => ''
        ],
        'pRedBC'     => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Percentual de redução da BC',
            'format'   => '3v2'
        ],
        'vBC'        => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Valor da BC do ICMS',
            'format'   => '13v2'
        ],
        'pICMS'      => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Percentual ICMS',
            'format'   => '3v2'
        ],
        'vICMS'      => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Valor do ICMS',
            'format'   => '13v2'
        ],
        'vCred'      => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Valor do Crédito Outorgado/Presumido',
            'format'   => '13v2'
        ],
        'vTotTrib'   => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Valor Total dos Tributos',
            'format'   => '13v2'
        ],
        'infAdFisco' => [
            'type'     => 'string',
            'regex'    => '^.{1,2000}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Informações adicionais de interesse do Fisco',
            'format'   => ''
        ]
    ];

    /**
     * DOMElement constructor
     * @return \DOMElement
     */
    public function toNode()
    {
        $node = $this->dom->createElement($this->name);
        switch ($this->std->cst) {
            case '00':
                $icms = $this->dom->createElement('ICMS00');
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $this->std->cst,
                    true,
                    ''
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->std->vbc,
                    true,
                    ''
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->std->picms,
                    true,
                    ''
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->std->vicms,
                    true,
                    ''
                );
                break;
            case '20':
                $icms = $this->dom->createElement('ICMS20');
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $this->std->cst,
                    true,
                    ''
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->std->predbc,
                    true,
                    ''
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->std->vbc,
                    true,
                    ''
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->std->picms,
                    true,
                    ''
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->std->vicms,
                    true,
                    ''
                );
                break;
            case '40':
            case '41':
            case '51':
            case '45':
                $icms = $this->dom->createElement('ICMS45');
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $this->std->cst,
                    true,
                    ''
                );
                break;
            case '90':
                if ($this->std->indsn == 1) {
                    $icms = $this->dom->createElement('ICMSSN');
                    $this->dom->addChild(
                        $icms,
                        'CST',
                        $this->std->cst,
                        true,
                        ''
                    );
                    $this->dom->addChild(
                        $icms,
                        'indSN',
                        $this->std->indsn,
                        true,
                        ''
                    );
                } else {
                    $icms = $this->dom->createElement('ICMS90');
                    $this->dom->addChild(
                        $icms,
                        'CST',
                        $this->std->cst,
                        true,
                        ''
                    );
                    $this->dom->addChild(
                        $icms,
                        'pRedBC',
                        $this->std->predbc,
                        false,
                        ''
                    );
                    $this->dom->addChild(
                        $icms,
                        'vBC',
                        $this->std->vbc,
                        true,
                        ''
                    );
                    $this->dom->addChild(
                        $icms,
                        'pICMS',
                        $this->std->picms,
                        true,
                        ''
                    );
                    $this->dom->addChild(
                        $icms,
                        'vICMS',
                        $this->std->vicms,
                        true,
                        ''
                    );
                    $this->dom->addChild(
                        $icms,
                        'vCred',
                        $this->std->vcred,
                        false,
                        ''
                    );
                }
                break;
        }
        $node->appendChild($icms);
        $this->dom->appendChild($node);
        return $node;
    }
}
