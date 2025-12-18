<?php

namespace NFePHP\BPe\Common;

/**
 * Abstract class to build Make::class
 */
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Keys;
use NFePHP\Common\Strings;
use NFePHP\BPe\Factories\TagInterface;
use \DOMElement;

abstract class Make
{
    /**
     * @var array
     */
    public $errors = [];
    /**
     * @var string
     */
    public $chave;
    /**
     * @var NFePHP\Common\DOMImproved
     */
    protected $dom;
    /**
     * @var \DOMElement
     */
    protected $root;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $xmlns = 'http://www.portalfiscal.inf.br/bpe';

    /**
     * @var bool
     */
    protected $onlyAscii = false;

    /**
     * @var array
     */
    protected $available = [];
    /**
     * @var string
     */
    protected $xml;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;
        $rootname = 'BPe';
        $this->$rootname = $this->dom->createElement($rootname);
        $this->$rootname->setAttribute("xmlns", $this->xmlns);
    }

    public function __toString()
    {
        if (empty($this->xml)) {
            $this->parse();
        }
        return $this->xml;
    }
    
    /**
     * Return document key
     * @return type
     */
    public function getChave()
    {
        return $this->chave;
    }
    
    /**
     * Returns XML
     * @return type
     */
    public function getXML()
    {
        return $this->xml;
    }

    /**
     * To force convertion strings to ASCII
     * @param bool $flag
     * @return bool
     */
    public function setToAscii($flag = null)
    {
        if (isset($flag) && is_bool($flag)) {
            $this->onlyAscii = $flag;
        }
        return $this->onlyAscii;
    }

    /**
     * Abstract function to convert Tag::classes into DOM objects
     */
    abstract public function parse();

    /**
     * Call classes to build each element for XML
     * @param string $name
     * @param array $arguments [std]
     * @return object|array
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $name = str_replace('-', '', strtolower($name));
        $realname = $name;
        $arguments[0]->onlyAscii = $this->onlyAscii;
        if (!array_key_exists($realname, $this->available)) {
            throw new \Exception("Não encontrada referencia ao método $name.");
        }
        $className = $this->available[$realname]['class'];
        if (empty($arguments[0])) {
            throw new \Exception("Sem dados passados para o método [$name].");
        }
        $propname = str_replace('tag', '', $name);
        $c = $this->loadTagClass($className, $arguments);
        if ($this->available[$realname]['type'] == 'multiple') {
            if (!isset($this->$propname)) {
                $this->createProperty($propname, []);
            }
            array_push($this->$propname, $c);
        } else {
            $this->createProperty($propname, $c);
        }
        return $this->$propname;
    }

    /**
     * Load Tag::class
     * @param string $className
     * @param array $arguments
     * @return \NFePHP\BPe\Tags\className
     */
    protected function loadTagClass($className, $arguments)
    {
        $c = new $className($this->dom);
        $c->setToASCII($this->onlyAscii);
        $c->loadParameters($arguments[0]);
        if (!empty($c->errors)) {
            array_push($this->errors, $c->errors);
        }
        return $c;
    }

    /**
     * Create properties
     * @param string $name
     * @param TagInterface $value
     */
    public function createProperty($name, TagInterface $value)
    {
        $this->{$name} = $value;
    }

    private function removeTagPrefix($string)
    {
        return strtolower(str_replace('tag', '', $string));
    }

    protected function createEmptyProperties()
    {
        $nodes = array_keys($this->available);
        $nodes = array_map([$this, 'removeTagPrefix'], $nodes);
        foreach ($nodes as $node) {
            $type = $this->available["tag{$node}"]['type'];
            if ($type == 'single') {
                $this->{$node} = null;
            } else {
                $this->{$node} = [];
            }
        }
    }
    
    /**
     * Validate all objects
     */
    protected function validateDataObjects()
    {
        $nodes = array_keys($this->available);
        $nodes = array_map([$this, 'removeTagPrefix'], $nodes);
        foreach ($nodes as $node) {
            $occur = $this->available["tag{$node}"]['occurrence'];
            if ($occur[0] == 1 && empty($this->$node)) {
                //o objeto é obrigatório e não foi instanciado
                $this->errors[] = "O objeto [tag{$node}] é obrigatório e "
                    . "não foi instanciado!";
            }
            if (is_array($this->$node)) {
                $n = count($this->$node);
                if ($n >  $occur[1]) {
                    //existem mais objetos que o permitido
                    $this->errors[] = "Existem mais objetos [tag{$node}: $n] "
                        . "que o limite permitido [max: {$occur[1]}]!";
                }
            }
        }
    }
    
    protected function hashCSRT($csrt, $chave)
    {
        return strtoupper(base64_encode(sha1($csrt . $chave, true)));
    }


    public static function conditionalNumberFormatting($value = null, int $decimal = 2): ?string
    {
        if (is_numeric($value)) {
            return number_format($value, $decimal, '.', '');
        }
        return null;
    }
    public static function equilizeParameters(object $data, array $possible): object
    {
        $ppl = array_map('strtolower', $possible);
        $data = self::propertiesToLower($data);
        $equalized = Strings::equilizeParameters(
            $data,
            $ppl,
            false
        );
        return self::propertiesToBack($equalized, $possible);
    }

    public static function propertiesToLower(object $data): object
    {
        $properties = get_object_vars($data);
        $clone = clone $data; 
        foreach ($clone as $key => $value) {
            unset($clone->$key);
        }
        foreach ($properties as $key => $value) {
            if (is_object($value)) {
                $value = self::propertiesToLower($value);
            }
            $nk = trim(strtolower($key));
            $clone->$nk = $value;
        }
        return $clone;
    }

    public static function propertiesToBack(object $data, array $possible): object
    {
        $new = clone $data;
        foreach ($new as $key => $value) {
            unset($new->$key);
        }
        $properties = get_object_vars($data);
        foreach ($properties as $key => $value) {
            foreach ($possible as $p) {
                if (strtolower($p) === $key) {
                    $new->$p = $value;
                    break;
                }
            }
        }
        return $new;
    }
}
