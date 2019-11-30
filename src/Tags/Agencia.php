<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/agencia
 */
class Agencia extends Tag implements TagInterface
{
    protected $name = 'agencia';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'xNome' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Razão Social ou Nome da agência',
            'format'   => ''
        ],
        'CNPJ' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{14}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'CNPJ da agência',
            'format'   => ''
        ]
    ];
}
