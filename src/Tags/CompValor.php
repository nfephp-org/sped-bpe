<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe/Comp
 */
class CompValor extends Tag implements TagInterface
{
    protected $name = 'Comp';
    protected $parent = 'infValorBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'tpComp' => [
            'type'     => 'number',
            'regex'    => '^[0-9]{2}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo do Componente',
            'format'   => ''
        ],
        'vComp' => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor do componente',
            'format'   => '13v2'
        ]
    ];
}
