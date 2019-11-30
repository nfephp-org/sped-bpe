<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infViagem
 */
class InfViagem extends Tag implements TagInterface
{
    protected $name = 'infViagem';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    protected $subnode = 'infTravessia';
    
    protected $possible = [
        'cPercurso' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Código do percurso',
            'format'   => ''
        ],
        'xPercurso' => [
            'type'     => 'string',
            'regex'    => '^.{2,100}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Descrição do percurso',
            'format'   => ''
        ],
        'tpViagem' => [
            'type'     => 'string',
            'regex'    => '^0[0-1]{1}$', //00-regular, 01-extra
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo de viagem',
            'format'   => ''
        ],
        'tpServ' => [
            'type'     => 'integer',
            'regex'    => '^[1-9]{1}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo de serviço',
            'format'   => ''
        ],
        'tpAcomodacao' => [
            'type'     => 'integer',
            'regex'    => '^[1-5]{1}$', //1-Assento/poltrona, 2-Rede, 3-Rede com ar-condicionado, 4-Cabine, 5-Outros
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo de acomodação',
            'format'   => ''
        ],
        'tpTrecho' => [
            'type'     => 'integer',
            'regex'    => '^[1-5]{1}$', // 1-Normal, 2-Trecho Inicial, 3-Conexão
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo de trecho',
            'format'   => ''
        ],
        'dhViagem' => [
            'type'     => 'date',
            'regex'    => '^(2[0-9][0-9][0-9])[-](0?[1-9]'
            . '|1[0-2])[-](0?[1-9]'
            . '|[12][0-9]'
            . '|3[01])T([0-9]|0[0-9]'
            . '|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]-(00|01|02|03|04):00$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Data e hora da viagem',
            'format'   => 'Y-m-d\TH:i:sP'
        ],
        'dhConexao' => [
            'type'     => 'date',
            'regex'    => '^(2[0-9][0-9][0-9])[-](0?[1-9]'
            . '|1[0-2])[-](0?[1-9]'
            . '|[12][0-9]'
            . '|3[01])T([0-9]|0[0-9]'
            . '|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]-(00|01|02|03|04):00$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Data e hora da conexão',
            'format'   => 'Y-m-d\TH:i:sP'
        ],
        'prefixo' => [
            'type'     => 'string',
            'regex'    => '^.{1,20}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Prefixo da linha',
            'format'   => ''
        ],
        'poltrona' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{1,3}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Número da Poltrona/assento/cabine',
            'format'   => ''
        ],
        'plataforma' => [
            'type'     => 'string',
            'regex'    => '^.{1,10}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Plataforma/carro/barco de Embarque',
            'format'   => ''
        ]
    ];
    
    protected $possiblesubnode = [
        'tpVeiculo' => [
            'type'     => 'number',
            'regex'    => '^[0-9]{2}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo do veículo transportado',
            'format'   => ''
            
        ],
        'sitVeiculo' => [
            'type'     => 'integer',
            'regex'    => '^[1-3]{1}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Situação do veículo transportado',
            'format'   => ''
        ]
    ];
}
