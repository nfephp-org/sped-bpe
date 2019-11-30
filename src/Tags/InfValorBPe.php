<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe
 */
class InfValorBPe extends Tag implements TagInterface
{
    protected $name = 'infValorBPe';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'vBP' => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor',
            'format'   => '13v2'
        ],
        'vDesconto' => [
            'type'     => 'numeric',
            'regex'    => '^0|0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor Desconto',
            'format'   => '13v2'
        ],
        'vPgto' => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor pago pelo BP-e (vBP - vDesconto)',
            'format'   => '13v2'
        ],
        'vTroco' => [
            'type'     => 'numeric',
            'regex'    => '^0|0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor do troco',
            'format'   => '13v2'
        ],
        'tpDesconto' => [
            'type'     => 'number',
            'regex'    => '^[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'tipo de desconto/benefício concedido',
            'format'   => ''
        ],
        'xDesconto' => [
            'type'     => 'string',
            'regex'    => '^.{2,100}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Descrição do tipo de desconto/benefício concedido',
            'format'   => ''
        ],
        'cDesconto' => [
            'type'     => 'string',
            'regex'    => '^.{2,20}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Código do desconto concedido, informar somente quando tpDesconto = 99',
            'format'   => ''
        ],
    ];
}
