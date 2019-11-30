<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

class Pag extends Tag implements TagInterface
{
    protected $name = 'pag';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    protected $subnode = 'card';
    
    protected $possible = [
        'tPag' => [
            'type' => 'string',
            'regex' => '^(01|02|03|04|05|99)$',
            'position' => 'node',
            'required' => true,
            'info' => 'Forma de Pagamento',
            'format'   => ''
        ],
        'xPag' => [
            'type' => 'string',
            'regex' => '^.{2,100}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Descrição da forma de pagamento 99 - Outros',
            'format'   => ''
        ],
        'nDocPag' => [
            'type' => 'string',
            'regex' => '^.{1,20}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Número do documento ou carteira apresentada nas formas de pagamento diferentes de 03 e 04',
            'format'   => ''
        ],
        'vPag' => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Valor do Pagamento',
            'format'   => '13v2'
        ]
    ];
    
    protected $possiblesubnode = [
        'tpIntegra' => [
            'type' => 'integer',
            'regex' => '^[1-2]{1}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Tipo de Integração',
            'format'   => ''
        ],
        'CNPJ' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{14}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CNPJ da operadora',
            'format'   => ''
        ],
        'tBand' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Bandeira da operadora',
            'format'   => ''
        ],
        'xBand' => [
            'type' => 'string',
            'regex' => '^.{2,100}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Descrição da operadora de cartão para 99 - Outros',
            'format'   => ''
        ],
        'cAut' => [
            'type' => 'string',
            'regex' => '^.{2,20}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Número de autorização da operação',
            'format'   => ''
        ],
        'nsuTrans' => [
            'type' => 'string',
            'regex' => '^.{2,20}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Número sequencial único da transação',
            'format'   => ''
        ],
        'nsuHost' => [
            'type' => 'string',
            'regex' => '^.{2,20}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Número sequencial único do Host',
            'format'   => ''
        ],
        'nParcelas' => [
            'type' => 'number',
            'regex' => '^[0-9]{1,3}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Número de parcelas',
            'macro'    => 'zeroLeft|3',
            'format'   => ''
        ],
        'infAdCard' => [
            'type' => 'string',
            'regex' => '^.{1,2000}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Informações adicionais operacionais para integração do cartão de crédito',
            'format'   => ''
        ],
    ];
}
