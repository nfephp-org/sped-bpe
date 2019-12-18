<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infViagem
 */
class RespTec extends Tag implements TagInterface
{
    protected $name = 'infRespTec';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    protected $subnode = null;


    protected $possible = [
        'CNPJ' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{14}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'CNPJ do Responsavel Técnico',
            'format'   => ''
        ],
        'xContato' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Nome da pessoa a ser contatada',
            'format'   => ''
        ],
        'email' => [
            'type'     => 'string',
            'regex'    => 'email',
            'position' => 'node',
            'required' => true,
            'info'     => 'E-mail da pessoa jurídica a ser contatada',
            'format'   => ''
        ],
        'fone' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{7,12}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Telefone da pessoa jurídica/física a ser contatada',
            'format'   => ''
        ],
        'idCSRT' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{3}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Identificador do CSRT',
            'format'   => ''
        ],
        'hashCSRT' => [
            'type'     => 'string',
            'regex'    => '^.{20}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'hashCSRT',
            'format'   => ''
        ],
    ];
    
    protected $possiblesubnode = [
        'CSRT' => [
            'type'     => 'string',
            'regex'    => '^.{20,200}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CSRT',
            'format'   => ''
        ],
    ];
}
