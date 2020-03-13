<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Identificação do emitente da NF-e C01 pai A01
 * tag BPe/infBPe/emit
 */
class Emit extends Tag implements TagInterface
{
    protected $name = 'emit';
    protected $parent = 'infBPe';
    protected $after = 'ide';
    protected $before = '';
    
    protected $possible = [
        'CNPJ' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{14}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CNPJ do emitente',
            'format'   => ''
        ],
        'IE' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{2,14}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'IE do emitente',
            'format'   => ''
        ],
        'IEST' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{2,14}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'IE do Substituto Tributário',
            'format'   => ''
        ],
        'xNome' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Razão Social ou Nome do emitente',
            'format'   => ''
        ],
        'xFant' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Nome fantasia',
            'format'   => ''
        ],
        'IM' => [
            'type'     => 'string',
            'regex'    => '^[A-Za-z0-9]{1,15}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Inscrição Municipal do Prestador de Serviço',
            'format'   => ''
        ],
        'CNAE' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{7}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CNAE fiscal',
            'format'   => ''
        ],
        'CRT' => [
            'type'     => 'integer',
            'regex'    => '^[1,3]{1}',
            'position' => 'node',
            'required' => false,
            'info'     => 'Código de Regime Tributário',
            'format'   => ''
        ],
        'TAR' => [
            'type'     => 'string',
            'regex'    => '^.{1,20}',
            'position' => 'node',
            'required' => false,
            'info'     => 'Termo de Autorização de Serviço Regular',
            'format'   => ''
        ]
    ];
}
