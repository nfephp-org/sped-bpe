<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;

class Comp extends Tag implements TagInterface
{
    protected $name = 'comp';
    protected $parent = 'infBPe';
    protected $after = 'emit';
    protected $before = '';
    
    protected $possible = [
        'xNome' => [
            'type'     => 'string',
            'regex'    => '^.{2,60}$',
            'position' => 'node',
            'required' => true,
            'info'     => 'Nome do comprador',
            'format'   => ''
        ],
        'CNPJ' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{0}|[0-9]{14}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CNPJ do comprador',
            'format'   => ''
        ],
        'CPF' => [
            'type'     => 'numeric',
            'regex'    => '^[0-9]{11}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'CPF do comprador',
            'format'   => ''
        ],
        'idEstrangeiro' => [
            'type'     => 'string',
            'regex'    => '^([!-ÿ]{0}|[!-ÿ]{5,20})$',
            'position' => 'node',
            'required' => false,
            'info'     => 'Id de estrangeiro',
            'format'   => ''
        ],
        'IE' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{0,14}|ISENTO|PR[0-9]{4,8}$',
            'position' => 'node',
            'required' => false,
            'info'     => 'IE do comprador',
            'format'   => ''
        ],
    ];
    
    /**
     * Load TAG parameters
     * @param \stdClass $std
     */
    public function loadParameters(\stdClass $std)
    {
        $this->std = $this->equalize($std, $this->name, $this->possible);
        $this->postProcess();
    }
    
    protected function postProcess()
    {
        //não está claro na documentação se os dados de CNPJ CPF e idEstrangeiro
        //podem ou devem ser grafadas no xml simultaneamente
        //então se não puderem ser simultâneas aqui podemos remover qq um dos itens
        //adicionais
        if ($this->std->cnpj != null) {
            $this->std->cpf =  null;
            $this->std->idestrangeiro = null;
        } elseif ($this->std->cpf != null) {
            $this->std->idestrangeiro = null;
        }
    }
}
