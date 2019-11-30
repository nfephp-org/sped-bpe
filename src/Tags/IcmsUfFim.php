<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe/imp/ICMSUFFIM
 */
class IcmsUfFim extends Tag implements TagInterface
{
    protected $name = 'ICMSUFFim';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    
    protected $possible = [
        'vBCUFFim' => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor da BC do ICMS na UF fim da viagem',
            'format'   => '13v2'
        ],
        'pFCPUFFim' => [
            'type'     => 'numeric',
            'regex'    => '^0|0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Percentual do ICMS relativo ao Fundo de Combate à pobreza (FCP) na UF fim da viagem',
            'format'   => '3v2'
        ],
        'pICMSUFFim' => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Alíquota interna da UF fim da viagem',
            'format'   => '3v2'
        ],
        'pICMSInter' => [
            'type'     => 'numeric',
            'regex'    => '^0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Alíquota interestadual das UF envolvidas',
            'format'   => '3v2'
        ],
        'vFCPUFFim' => [
            'type'     => 'numeric',
            'regex'    => '^0|0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor do ICMS relativo ao Fundo de Combate á Pobreza (FCP) da UF fim da viagem',
            'format'   => '13v2'
        ],
        'vICMSUFFim' => [
            'type'     => 'numeric',
            'regex'    => '^0|0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor do ICMS de partilha para a UF fim da viagem',
            'format'   => '13v2'
        ],
        'vICMSUFIni' => [
            'type'     => 'numeric',
            'regex'    => '^0|0\.[0-9]{1}[1-9]{1}|0\.[1-9]{1}[0-9]{1}|[1-9]{1}[0-9]{0,12}(\.[0-9]{2})?$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Valor do ICMS de partilha para a UF início da viagem',
            'format'   => '13v2'
        ],
    ];
}
