<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infBPeSub
 */
class InfBpeSub extends Tag implements TagInterface
{
    protected $name = 'infBPeSub';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'chBPe' => [
            'type'     => 'stringr',
            'regex'    => '^[0-9]{44}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Chave do Bilhete de Passagem Substituído',
            'format'   => ''
        ],
        'tpSub' => [
            'type'     => 'integer',
            'regex'    => '^[1-3]{1}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo de Substituição',
            'format'   => ''
        ]
    ];
}
