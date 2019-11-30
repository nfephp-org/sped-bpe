<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infPassagem/infPassageiro
 */
class InfPassageiro extends Tag implements TagInterface
{
    protected $name = 'infPassageiro';
    protected $parent = 'infPassagem';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'xNome' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Nome do passageiro',
            'format'   => ''
        ],
        'CPF' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{11}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CPF do passagiro',
            'format'   => ''
        ],
        'tpDoc' => [
            'type'     => 'integer',
            'regex'    => '^[1-5]{1}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo de documento',
            'format'   => ''
        ],
        'nDoc' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Numero do documento',
            'format'   => ''
        ],
        'xDoc' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Descrição do doc quando tpDoc = 5 - outros',
            'format'   => ''],
        'dNasc' => [
            'type'     => 'date',
            'regex'    => '^(19[0-9][0-9]|2[0-9][0-9][0-9])-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01])$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Data ',
            'format'   => 'Y-m-d'
        ],
        'fone' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{7,12}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Telefone',
            'format'   => ''
        ],
        'email' => [
            'type'     => 'string',
            'regex'    => "email",
            'position' => 'node',
            'required' => false,
            'info'     => 'email',
            'format'   => ''
        ],
    ];
}
