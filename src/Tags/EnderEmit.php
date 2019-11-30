<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Identificação do Endereço do emitente
 * tag BPe/infBPe/emit/enderEmit
 */
class EnderEmit extends Tag implements TagInterface
{
    protected $name = 'enderEmit';
    protected $parent = 'emit';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'xLgr' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Logradouro',
            'format'   => ''
        ],
        'nro' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Número do logradouro',
            'format'   => ''
        ],
        'xCpl' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Complemento',
            'format'   => ''
        ],
        'xBairro' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Bairro',
            'format'   => ''
        ],
        'cMun' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{7}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Código do município',
            'format'   => ''
        ],
        'xMun' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Municipio',
            'format'   => ''
        ],
        'CEP' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{8}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CEP do local',
            'format'   => ''
        ],
        'UF' => [
            'type'     => 'string',
            'regex'    => '^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Sigla da UF',
            'format'   => ''
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
