<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

/**
 * Informações de identificação
 * tag BPe/infBPe/ide
 */
class Ide extends Tag implements TagInterface
{
    protected $name = 'ide';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
   
    protected $possible = [
        'cUF' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{2}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Codigo da UF',
            'format'   => ''
        ],
        'tpAmb' => [
            'type'     => 'integer',
            'regex'    => '^[1-2]{1}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Identificação do Ambiente',
            'format'   => ''
        ],
        'mod' => [
            'type'     => 'integer',
            'default'  => 63,
            'regex'    => '^(63)$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Modelo',
            'format'   => ''
        ],
        'serie' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{1,3}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Série da NFe',
            'format'   => ''
        ],
        'nBP' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{1,9}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Número da NFe',
            'format'   => ''
        ],
        'cBP' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{1,8}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'randomico',
            'format'   => '',
            'macro'    => 'zeroLeft|8'
        ],
        'cDV' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{1}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Dígito Verificador da Chave de Acesso',
            'format'   => ''
        ],
        'modal' => [
            'type'     => 'integer',
            'regex'    => '^(1|3|4)$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Modal de transporte',
            'format'   => ''
        ],
        'dhEmi' => [
            'type'     => 'date',
            'regex'    => '^(2[0-9][0-9][0-9])[-](0?[1-9]'
            . '|1[0-2])[-](0?[1-9]'
            . '|[12][0-9]'
            . '|3[01])T([0-9]|0[0-9]'
            . '|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]-(00|01|02|03|04):00$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Data e hora de emissão',
            'format'   => 'Y-m-d\TH:i:sP'
        ],
        'tpEmis' => [
            'type'     => 'integer',
            'regex'    => '^[1-2]{1}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo de Emissão',
            'format'   => ''
        ],
        'verProc' => [
            'type'     => 'string',
            'regex'    => '^.{1,20}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Versão do Processo de emissão da NF-e',
            'format'   => ''
        ],
        'tpBPe' => [
            'type'     => 'integer',
            'regex'    => '^(0|3)$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Tipo do BP-e',
            'format'   => ''
        ],
        'indPres' => [
            'type'     => 'integer',
            'regex'    => '^(1|2|3|4|5|9)$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Indicador de presença do comprador',
            'format'   => ''
        ],
        'UFIni' => [
            'type'     => 'string',
            'regex'    => '^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Sigla da UF Início da Viagem',
            'format'   => ''
        ],
        'cMunIni' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{7}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Código do Município inicio viagem',
            'format'   => ''
        ],
        'UFFim' => [
            'type'     => 'string',
            'regex'    => '^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Sigla da UF Fim da Viagem',
            'format'   => ''
        ],
        'cMunFim' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{7}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Código do Município fim viagem',
            'format'   => ''
        ],
        'dhCont' => [
            'type'     => 'string',
            'regex'    => '^(2[0-9][0-9][0-9])[-](0?[1-9]'
            . '|1[0-2])[-](0?[1-9]'
            . '|[12][0-9]|3[01])T([0-9]|0[0-9]'
            . '|1[0-9]'
            . '|2[0-3]):[0-5][0-9]:[0-5][0-9]-(00|01|02|03|04):00$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Data e Hora da entrada em contingência',
            'format'   => ''
        ],
        'xJust' => [
            'type'     => 'string',
            'regex'    => '^.{15,256}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Justificativa da entrada em contingência',
            'format'   => ''
        ]
    ];
    
    /**
     * Load TAG parameters
     * @param \stdClass $std
     */
    public function loadParameters($std)
    {
        $this->std = $this->equalize($std, $this->name, $this->possible);
        $this->postProcess();
    }
    
    protected function postProcess()
    {
        if (!empty($this->std->dhcont) && $this->std->tpemis == 1) {
            $this->std->tpemis = 2;
        }
        if ((empty($this->std->dhcont) || empty($this->std->xjust)) && $this->std->tpemis == 2) {
            $this->std->dhcont = null;
            $this->std->xjust = null;
            $this->std->tpemis = 1;
        }
    }
}
