<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Identificação do emitente da NF-e C01 pai A01
 * tag BPe/infBPe/emit
 */
class InfBPeSupl extends Tag implements TagInterface
{
    protected $name = 'infBPeSupl';
    protected $parent = 'BPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'qrCodBPe' => [
            'type'     => 'string',
            'regex'    => '^.{50,1000}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'QR-Code impresso no DABPE',
            'format'   => 'cdata'
        ],
        'boardPassBPe' => [
            'type'     => 'string',
            'regex'    => '^.{50,1000}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'boarding Pass impresso no DABPE (padrão PDF417)',
            'format'   => ''
        ]
    ];
}
