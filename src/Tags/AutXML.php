<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Identificação do emitente da NF-e C01 pai A01
 * tag BPe/infBPe/autXML
 */
class AutXML extends Tag implements TagInterface
{
    protected $name = 'autXML';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'CNPJ' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{14}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CNPJ',
            'format'   => ''
        ],
        'CPF' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{11}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CPF',
            'format'   => ''
        ],
    ];
}
