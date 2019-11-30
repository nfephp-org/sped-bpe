<?php

namespace NFePHP\BPe;

use NFePHP\BPe\Common\Make as MakeBase;
use NFePHP\Common\Keys;

class Make extends MakeBase
{
    protected $rootname = 'BPe';
    protected $versao = '1.00';
    protected $xmlns = 'http://www.portalfiscal.inf.br/bpe';
    
    protected $available = [
        'taginfbpe' => ['class' => Tags\InfBpe::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'tagide' => ['class' => Tags\Ide::class, 'type' => 'single', 'occurrence' => [1, 1]],
        'tagemit' => ['class' => Tags\Emit::class, 'type' => 'single', 'occurrence' => [1, 1]],
        'tagenderemit' => ['class' => Tags\EnderEmit::class, 'type' => 'single', 'occurrence' => [1, 1]],
        'tagcomp' => ['class' => Tags\Comp::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'tagendercomp' => ['class' => Tags\EnderComp::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'tagagencia' => ['class' => Tags\Agencia::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'tagenderagencia' => ['class' => Tags\EnderAgencia::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'taginfbpesub' => ['class' => Tags\InfBpeSub::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'taginfpassagem' => ['class' => Tags\InfPassagem::class, 'type' => 'single', 'occurrence' => [1, 1]],
        'taginfpassageiro' => ['class' => Tags\InfPassageiro::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'taginfviagem' => ['class' => Tags\InfViagem::class, 'type' => 'multiple', 'occurrence' => [1, 9999]],
        'taginfvalorbpe' => ['class' => Tags\InfValorBPe::class, 'type' => 'single', 'occurrence' => [1, 1]],
        'tagcompvalor' => ['class' => Tags\CompValor::class, 'type' => 'multiple', 'occurrence' => [1, 999]],
        'tagicms' => ['class' => Tags\Icms::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'tagicmsuffim' => ['class' => Tags\IcmsUfFim::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'tagpag' => ['class' => Tags\Pag::class, 'type' => 'multiple', 'occurrence' => [1, 10]],
        'tagautxml' => ['class' => Tags\AutXML::class, 'type' => 'multiple', 'occurrence' => [0, 10]],
        'taginfadic' => ['class' => Tags\InfAdic::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'tagresptec' => ['class' => Tags\RespTec::class, 'type' => 'single', 'occurrence' => [0, 1]],
        'taginfbpesupl' => ['class' => Tags\InfBPeSupl::class, 'type' => 'single', 'occurrence' => [0, 1]],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->createEmptyProperties();
    }
    
    /**
     * Convert all subclasse to DOMNodes and creates entire XML
     * NOTE: append order is very important
     * @return string
     */
    public function parse()
    {
        //valida se algum objeto não foi passado ou se supera o limite estabelecido
        $this->validateDataObjects();
        try {
            //infBPe tag  OBRIGATÓRIA mas pode ser construida a partir de outras
            if (!empty($this->ide) && !empty($this->emit)) {
                //construir a chave e montar a tag
                $data = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:sP', $this->ide->std->dhemi);
                $buildId = Keys::build(
                    $this->ide->std->cuf,
                    $data->format('y'),
                    $data->format('m'),
                    $this->emit->std->cnpj,
                    $this->ide->std->mod,
                    $this->ide->std->serie,
                    $this->ide->std->nbp,
                    $this->ide->std->tpemis,
                    $this->ide->std->cbp
                );
                if (empty($this->infbpe)) {
                    $this->ide->std->cdv = substr($buildId, -1);
                    $std = (object) ['Id' => $buildId, 'versao' => $this->versao];
                    $class = $this->available["taginfbpe"]['class'];
                    $this->createProperty('infbpe', $this->loadTagClass($class, [$std]));
                    $this->chave = $buildId;
                } else {
                    if (!empty($this->infbpe->std->id)) {
                        if ($buildId != $this->infbpe->std->id) {
                            $this->errors[] = "Chave passada na tagInfBPe está incorreta! Chave correta [$buildId].";
                        }
                        $this->chave = $buildId;
                    } else {
                        $this->infbpe->std->id = $buildId;
                        $this->infbpe->std->versao = !empty($this->infbpe->std->versao)
                            ? $this->infbpe->std->versao
                            : $this->versao;
                        $this->ide->std->cdv = substr($buildId, -1);
                    }
                }
            }
            //cria o hashCSRT geralmente é necessário quando não é criada a chave
            //durante a montagem com a classe make
            if (!empty($this->resptec)) {
                $this->resptec->std->hashcsrt = $this->hashCSRT(
                    $this->resptec->stdsubnode->csrt,
                    $buildId
                );
            }
            
            
            //caso não seja criada a tag infBPe
            if (empty($this->infbpe)) {
                throw new \Exception('A Tag infBPE é obrigatória.');
            }
            //cria o node infBPe
            $infBPe = $this->infbpe->toNode();
            //cria Ide
            $this->appendNodeToParent($infBPe, $this->ide);
            //cria emit
            $this->appendNodeToParent($infBPe, $this->emit, $this->enderemit);
            //cria comp
            $this->appendNodeToParent($infBPe, $this->comp, $this->endercomp);
            //cria agencia
            $this->appendNodeToParent($infBPe, $this->agencia, $this->enderagencia);
            //cria infBPeSub
            $this->appendNodeToParent($infBPe, $this->infbpesub);
            //cria infPassagem
            $this->appendNodeToParent($infBPe, $this->infpassagem, $this->infpassageiro);
            //cria infViagem
            $this->appendNodeToParent($infBPe, $this->infviagem);
            //cria infValorBPe
            $this->appendNodeToParent($infBPe, $this->infvalorbpe, $this->compvalor);
            //cria imp
            $imp = $this->dom->createElement('imp');
            //cria imp/ICMS
            $this->appendNodeToParent($imp, $this->icms);
            //cria imp/ICMSUFFIM
            $this->appendNodeToParent($imp, $this->icmsuffim);
            $this->dom->appChild($infBPe, $imp);
            //cria pag
            $this->appendNodeToParent($infBPe, $this->pag);
            //cria autXML
            $this->appendNodeToParent($infBPe, $this->autxml);
            //cria infAdic
            $this->appendNodeToParent($infBPe, $this->infadic);
            //cria infRespTec
            $this->appendNodeToParent($infBPe, $this->resptec);
            $this->dom->appChild($this->BPe, $infBPe);
            //cria infBPeSupl
            $this->appendNodeToParent($this->BPe, $this->infbpesupl);
            $this->dom->appendChild($this->BPe);
            $this->xml = null;
            $this->xml = $this->dom->saveXML();
            return $this->xml;
        } catch (\ErrorException $e) {
            throw new \Exception($e);
        }
    }
    
    /**
     * Append tags in parent with subtags
     * @param \DOMElement $parent
     * @param \NFePHP\BPe\Factories\TagInterface $nodes | null
     * @param \NFePHP\BPe\Factories\TagInterface $subnode | null
     * @return void
     * @throws \Exception
     */
    protected function appendNodeToParent($parent, $nodes, $subnode = null)
    {
        if (empty($nodes)) {
            return;
        }
        if (is_array($nodes)) {
            foreach ($nodes as $node) {
                $this->dom->appChild($parent, $node->toNode());
            }
        } elseif (is_object($nodes)) {
            if ($subnode != null) {
                $novonode = $nodes->toNode();
                if (is_array($subnode)) {
                    foreach ($subnode as $sub) {
                        $this->dom->appChild($novonode, $sub->toNode());
                    }
                } elseif (is_object($subnode)) {
                    $this->dom->appChild($novonode, $subnode->toNode());
                }
                $this->dom->appChild($parent, $novonode);
            } else {
                $this->dom->appChild($parent, $nodes->toNode());
            }
        } else {
            throw new \Exception('Algo errado no código.');
        }
    }
}
