<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infPassagem
 */
class InfPassagem extends Tag implements TagInterface
{
    protected $name = 'infPassagem';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'cLocOrig' => [
            'type'     => 'string',
            'regex'    => '^.{1,7}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Código da Localidade de Origem',
            'format'   => ''
        ],
        'xLocOrig' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Descrição da Localidade de Origem',
            'format'   => ''
        ],
        'cLocDest' => [
            'type'     => 'string',
            'regex'    => '^.{1,7}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Código da Localidade de Destino',
            'format'   => ''
        ],
        'xLocDest' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Descrição da Localidade de Destino',
            'format'   => ''
            
        ],
        'dhEmb' => [
            'type'     => 'date',
            'regex'    => '^(2[0-9][0-9][0-9])[-](0?[1-9]'
            . '|1[0-2])[-](0?[1-9]'
            . '|[12][0-9]'
            . '|3[01])T([0-9]|0[0-9]'
            . '|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]-(00|01|02|03|04):00$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Data e hora de empbarque',
            'format'   => 'Y-m-d\TH:i:sP'
        ],
        'dhValidade' => [
            'type'     => 'date',
            'regex'    => '^(2[0-9][0-9][0-9])[-](0?[1-9]'
            . '|1[0-2])[-](0?[1-9]'
            . '|[12][0-9]'
            . '|3[01])T([0-9]|0[0-9]'
            . '|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]-(00|01|02|03|04):00$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Data e hora de validade do bilhete',
            'format'   => 'Y-m-d\TH:i:sP'
        ],
    ];
}
