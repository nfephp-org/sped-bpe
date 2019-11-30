<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

class InfBpe extends Tag implements TagInterface
{
    protected $name = 'infBPe';
    protected $parent = 'BPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'Id' => [
            'type' => 'string',
            'regex' => '^[0-9]{44}$',
            'position' => 'attribute',
            'required' => false,
            'info' => 'Id da NFe',
            'format'   => '',
            'prefix'   => 'BPe'
        ],
        'versao' => [
            'type' => 'string',
            'regex' => '^[0-9]{1,2}.[0-9]{2}$',
            'position' => 'attribute',
            'required' => false,
            'info' => 'Versão do layout da BPe',
            'format'   => ''
        ]
    ];
}
