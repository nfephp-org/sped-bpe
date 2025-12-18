<?php

namespace NFePHP\BPe\Tags;

use NFePHP\BPe\Factories\Tag;
use NFePHP\BPe\Factories\TagInterface;
use NFePHP\BPe\Common\Make;

/**
 * Informações de identificação
 * tag BPe/infBPe/infValorBPe/imp/icms/icms[00|20|45|90]
 */
class IBSCBS extends Tag implements TagInterface
{

    protected $name = 'IBSCBS';
    protected $parent = 'infBPe';
    protected $after = '';
    protected $before = '';
    protected $possible = [
        'CST' => [
            'type' => 'string',
            'regex' => '^[0-9]{3}$',
            'position' => 'node',
            'required' => true,
            'info' => 'Código de Situação Tributária do IBS e CBS (CST)',
            'format' => ''
        ],
        'cClassTrib' => [
            'type' => 'string',
            'regex' => '^[0-9]{6}$',
            'position' => 'node',
            'required' => true,
            'info' => 'Código de Classificação Tributária do IBS e CBS (cClassTrib)',
            'format' => ''
        ],
        'vBC' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Base de cálculo do IBS e CBS (vBC)',
            'format' => '13v2'
        ],

        // Grupo gIBSUF
        'gIBSUF_pIBSUF' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota do IBS de competência das UF',
            'format' => '3v2-4'
        ],
        'gIBSUF_pDif' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Percentual do diferimento (pDif)',
            'format' => '3v2-4'
        ],
        'gIBSUF_vDif' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do diferimento (vDif)',
            'format' => '13v2'
        ],
        'gIBSUF_vDevTrib' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do tributo devolvido (vDevTrib)',
            'format' => '13v2'
        ],
        'gIBSUF_pRedAliq' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Percentual da redução de alíquota (pRedAliq)',
            'format' => '3v2-4'
        ],
        'gIBSUF_pAliqEfet' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota efetiva do IBS de competência das UF (pAliqEfet)',
            'format' => '3v2-4'
        ],
        'gIBSUF_vIBSUF' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => true,
            'info' => 'Valor do IBS de competência da UF (vIBSUF)',
            'format' => '13v2'
        ],

        // Grupo gIBSMun
        'gIBSMun_pIBSMun' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota do IBS de competência do Município (pIBSMun)',
            'format' => '3v2-4'
        ],
        'gIBSMun_pDif' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Percentual do diferimento (pDif)',
            'format' => '3v2-4'
        ],
        'gIBSMun_vDif' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do diferimento (vDif)',
            'format' => '13v2'
        ],
        'gIBSMun_vDevTrib' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do tributo devolvido (vDevTrib)',
            'format' => '13v2'
        ],
        'gIBSMun_pRedAliq' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Percentual da redução de alíquota (pRedAliq)',
            'format' => '3v2-4'
        ],
        'gIBSMun_pAliqEfet' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota Efetiva do IBS de competência do Município (pAliqEfet)',
            'format' => '3v2-4'
        ],
        'gIBSMun_vIBSMun' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do IBS de competência do Município (vIBSMun)',
            'format' => '13v2'
        ],

        'vIBS' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => true,
            'info' => 'Valor total do IBS (soma de vIBSUF + vIBSMun)',
            'format' => '13v2'
        ],

        // Grupo gCBS
        'gCBS_pCBS' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota da CBS (pCBS)',
            'format' => '3v2-4'
        ],
        'gCBS_pDif' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Percentual do diferimento (pDif)',
            'format' => '3v2-4'
        ],
        'gCBS_vDif' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do diferimento (vDif)',
            'format' => '13v2'
        ],
        'gCBS_vDevTrib' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor do tributo devolvido (vDevTrib)',
            'format' => '13v2'
        ],
        'gCBS_pRedAliq' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Percentual da redução de alíquota (pRedAliq)',
            'format' => '3v2-4'
        ],
        'gCBS_pAliqEfet' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,3}\.[0-9]{2,4}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Alíquota Efetiva da CBS aplicada à BC (pAliqEfet)',
            'format' => '3v2-4'
        ],
        'gCBS_vCBS' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor da CBS (vCBS)',
            'format' => '13v2'
        ],

        // total
        'vTotDFe' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{1,13}\.[0-9]{2}$',
            'position' => 'node',
            'required' => false,
            'info' => 'Valor total do documento fiscal eletrônico (vTotDFe)',
            'format' => '13v2'
        ]
    ];

    /**
     * DOMElement constructor
     * @return \DOMElement
     */

    public function toNode()
    {
        $node = $this->tagIBSCBS();
        return $node;
    }

    public function tagIBSCBS()
    {
        $std = $this->std;
        $possible = [
            'CST',
            'cClassTrib',
            'vBC',
            //dados IBS Estadual
            'gIBSUF_pIBSUF', //opcional Alíquota do IBS de competência das UF 3v2-4, OBRIGATÓRIO se vBC for informado
            'gIBSUF_pDif', //opcional Percentual do diferimento 3v2-4
            'gIBSUF_vDif', //opcional Valor do Diferimento 13v2
            'gIBSUF_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gIBSUF_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gIBSUF_pAliqEfet', //opcional Alíquota Efetiva do IBS de competência das UF que será aplicada a BC 3v2-4
            'gIBSUF_vIBSUF', //OBRIGATÓRIO Valor do IBS de competência da UF 13v2
            //dados IBS Municipal
            'gIBSMun_pIBSMun', //opcional Alíquota do IBS de competência do município 3v2-4
            //OBRIGATÓRIO se vBC for informado
            'gIBSMun_pDif', //opcional Percentual do diferimento 3v2-4
            'gIBSMun_vDif', //opcional Valor do Diferimento 13v2
            'gIBSMun_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gIBSMun_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gIBSMun_pAliqEfet', //opcional Alíquota Efetiva do IBS de competência do Município
            // que será aplicada a BC 3v2-4
            'gIBSMun_vIBSMun', //opcional Valor do IBS de competência do Município 13v2
            // Valor do IBS (soma de vIBSUF e vIBSMun) 13v2
            'vIBS',
            // dados CBS (imposto federal)
            'gCBS_pCBS', //opcional Alíquota da CBS 3v2-4
            // OBRIGATÓRIO se vBC for informado
            'gCBS_pDif', //opcional Percentual do diferimento 3v2-4
            'gCBS_vDif', //opcional Valor do Diferimento 13v2
            'gCBS_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gCBS_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gCBS_pAliqEfet', //opcional Alíquota Efetiva da CBS que será aplicada a Base de Cálculo 3v2-4
            'gCBS_vCBS', //opcional Valor da CBS 13v2
            // total
            'vTotDFe'
        ];
        $std = Make::equilizeParameters($std, $possible);
        $identificador = "UB12 <IBSCBS> -";

        $ibscbs = $this->dom->createElement("IBSCBS");
        $this->dom->addChild(
            $ibscbs,
            "CST",
            $std->CST,
            true,
            "$identificador Código de Situação Tributária do IBS e CBS (CST)"
        );
        $this->dom->addChild(
            $ibscbs,
            "cClassTrib",
            $std->cClassTrib,
            true,
            "$identificador Código de Classificação Tributária do IBS e CBS (cClassTrib)"
        );
        //gIBSCBS é opcional e também é um choice com IBSCBSMono
        if (!is_null($std->vBC) && is_numeric($std->vBC)) {
            $identificador = "UB12 <IBSCBS/gIBSCBS> -";
            $gIBSCBS = $this->dom->createElement("gIBSCBS");
            $this->dom->addChild(
                $gIBSCBS,
                "vBC",
                Make::conditionalNumberFormatting($std->vBC),
                true,
                "$identificador Base de cálculo do IBS e CBS (vBC)"
            );
            $identificador = "UB12 <IBSCBS/gIBSCBS/gIBSUF> -";
            $gIBSUF = $this->dom->createElement("gIBSUF");
            $this->dom->addChild(
                $gIBSUF,
                "pIBSUF",
                Make::conditionalNumberFormatting($std->gIBSUF_pIBSUF ?? null, 4),
                true,
                "$identificador Alíquota do IBS de competência das UF (pIBSUF)"
            );
            if (!empty($std->gIBSUF_pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    "pDif",
                    Make::conditionalNumberFormatting($std->gIBSUF_pDif, 4),
                    true,
                    "$identificador Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    "vDif",
                    Make::conditionalNumberFormatting($std->gIBSUF_vDif ?? null),
                    true,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gIBSUF->appendChild($gDif);
            }
            if (!empty($std->gIBSUF_vDevTrib)) {
                //Grupo de Informações da devolução de tributos IBSUF
                $gDevTrib = $this->dom->createElement("gDevTrib");
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    Make::conditionalNumberFormatting($std->gIBSUF_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gIBSUF->appendChild($gDevTrib);
            }
            if (!empty($std->gIBSUF_pRedAliq)) {
                //Grupo de informações da redução da alíquota
                $gRed = $this->dom->createElement("gRed");
                $this->dom->addChild(
                    $gRed,
                    "pRedAliq",
                    Make::conditionalNumberFormatting($std->gIBSUF_pRedAliq, 4),
                    true,
                    "$identificador Percentual da redução de alíquota (pRedAliq)"
                );
                $this->dom->addChild(
                    $gRed,
                    "pAliqEfet",
                    Make::conditionalNumberFormatting($std->gIBSUF_pAliqEfet ?? null),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF "
                    . "que será aplicada a Base de Cálculo (pAliqEfet)"
                );
                $gIBSUF->appendChild($gRed);
            }
            $this->dom->addChild(
                $gIBSUF,
                "vIBSUF",
                Make::conditionalNumberFormatting($std->gIBSUF_vIBSUF ?? null),
                true,
                "$identificador Valor do IBS de competência da UF (vIBSUF)"
            );
            //adiciona gIBSUF => $gIBSCBS
            $gIBSCBS->appendChild($gIBSUF);
            //Grupo de Informações do IBS para o município
            $identificador = "UB12 <IBSCBS/gIBSCBS/gIBSMun> -";
            $gIBSMun = $this->dom->createElement("gIBSMun");
            $this->dom->addChild(
                $gIBSMun,
                "pIBSMun",
                Make::conditionalNumberFormatting($std->gIBSMun_pIBSMun ?? null),
                true,
                "$identificador Alíquota do IBS de competência do Município (pIBSMun)"
            );
            if (!empty($std->gIBSMun_pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    "pDif",
                    Make::conditionalNumberFormatting($std->gIBSMun_pDif, 4),
                    true,
                    "$identificador Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    "vDif",
                    Make::conditionalNumberFormatting($std->gIBSMun_vDif ?? null),
                    true,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gIBSMun->appendChild($gDif);
            }
            if (!empty($std->gIBSMun_vDevTrib)) {
                //Grupo de Informações da devolução de tributos
                $gDevTrib = $this->dom->createElement("gDevTrib");
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    Make::conditionalNumberFormatting($std->gIBSMun_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gIBSMun->appendChild($gDevTrib);
            }
            if (!empty($std->gIBSMun_pRedAliq)) {
                //Grupo de informações da redução da alíquota IBSMun
                $gRed = $this->dom->createElement("gRed");
                $this->dom->addChild(
                    $gRed,
                    "pRedAliq",
                    Make::conditionalNumberFormatting($std->gIBSMun_pRedAliq, 4),
                    true,
                    "$identificador Percentual da redução de alíquota (pRedAliq)"
                );
                $this->dom->addChild(
                    $gRed,
                    "pAliqEfet",
                    Make::conditionalNumberFormatting($std->gIBSMun_pAliqEfet ?? null),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF que será aplicada "
                    . "a Base de Cálculo (pAliqEfet)"
                );
                $gIBSMun->appendChild($gRed);
            }
            $this->dom->addChild(
                $gIBSMun,
                "vIBSMun",
                Make::conditionalNumberFormatting($std->gIBSMun_vIBSMun ?? null),
                true,
                "$identificador Valor do IBS de competência do Município (vIBSMun)"
            );
            $gIBSCBS->appendChild($gIBSMun);
            $identificador = "UB12 <IBSCBS/gIBSCBS> -";
            $this->dom->addChild(
                $gIBSCBS,
                "vIBS",
                Make::conditionalNumberFormatting($std->vIBS),
                true,
                "$identificador Valor do Total do IBS"
            );
            //gripo de Informações da CBS
            $identificador = "UB12 <IBSCBS/gIBSCBS/gCBS> -";
            $gCBS = $this->dom->createElement("gCBS");
            $this->dom->addChild(
                $gCBS,
                "pCBS",
                Make::conditionalNumberFormatting($std->gCBS_pCBS ?? null, 4),
                true,
                "$identificador Alíquota da CBS (pCBS)"
            );
            if (!empty($std->gCBS_pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    "pDif",
                    Make::conditionalNumberFormatting($std->gCBS_pDif, 4),
                    true,
                    "$identificador Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    "vDif",
                    Make::conditionalNumberFormatting($std->gCBS_vDif ?? null),
                    false,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gCBS->appendChild($gDif);
            }
            if (!empty($std->gCBS_vDevTrib)) {
                //Grupo de Informações da devolução de tributos
                $gDevTrib = $this->dom->createElement("gDevTrib");
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    Make::conditionalNumberFormatting($std->gCBS_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gCBS->appendChild($gDevTrib);
            }
            if (!empty($std->gCBS_pRedAliq)) {
                //Grupo de informações da redução da alíquota CBS
                $gRed = $this->dom->createElement("gRed");
                $this->dom->addChild(
                    $gRed,
                    "pRedAliq",
                    Make::conditionalNumberFormatting($std->gCBS_pRedAliq, 4),
                    true,
                    "$identificador Percentual da redução de alíquota (pRedAliq)"
                );
                $this->dom->addChild(
                    $gRed,
                    "pAliqEfet",
                    Make::conditionalNumberFormatting($std->gCBS_pAliqEfet ?? null),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF que será aplicada "
                    . "a Base de Cálculo (pAliqEfet)"
                );
                $gCBS->appendChild($gRed);
            }
            $this->dom->addChild(
                $gCBS,
                "vCBS",
                Make::conditionalNumberFormatting($std->gCBS_vCBS ?? null),
                true,
                "$identificador Valor do CBS (vCBS)"
            );
            $gIBSCBS->appendChild($gCBS);
            $ibscbs->appendChild($gIBSCBS);
        }
        $this->IBSCBS = $ibscbs;
        if (!empty($std->vTotDFe)) {
            $this->vTotDFe = $this->dom->createElement("vTotDFe", Make::conditionalNumberFormatting($std->vTotDFe));
        }
        return $ibscbs;
    }


}
