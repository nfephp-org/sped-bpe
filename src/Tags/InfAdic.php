<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Identificação do emitente da NF-e C01 pai A01
 * tag BPe/infBPe/infAdic
 */
class InfAdic extends Tag implements TagInterface
{
    protected $name = 'infAdic';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'infAdFisco' => [
            'type'     => 'string',
            'regex'    => '^.{1,2000}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Informações adicionais de interesse do Fisco',
            'format'   => ''
        ],
        'infCpl' => [
            'type'     => 'string',
            'regex'    => '^.{1,2000}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Informações complementares de interesse do Contribuinte',
            'format'   => ''
        ],
    ];
}
