<?php

namespace NFePHP\BPe\Factories;

use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use \DOMElement;
use \stdClass;

class Tag
{
    /**
     * @var array
     */
    public $errors = [];
    /**
     * @var \stdClass
     */
    public $std;
    /**
     * @var \stdClass | null
     */
    public $stdsubnode;
    /**
     * @var DOMElement
     */
    protected $node;
    /**
     * @var NFePHP\Common\DOMImproved
     */
    protected $dom;
    /**
     * @var bool
     */
    protected $onlyAscii = false;
    
    /**
     * Constructor
     * @param NFePHP\Common\DOMImproved $dom
     */
    public function __construct(\NFePHP\Common\DOMImproved $dom = null)
    {
        $this->dom = $dom;
        if (empty($dom)) {
            $this->dom = new Dom('1.0', 'UTF-8');
            $this->dom->preserveWhiteSpace = false;
            $this->dom->formatOutput = false;
        }
    }
    
    /**
     * Set to convert all string to have only ASCII characters
     * @param bool $option
     */
    public function setToASCII($option = false)
    {
        $this->onlyAscii = $option;
    }
    
    public function parent()
    {
        return $this->parent;
    }
    
    public function after()
    {
        return $this->after;
    }
    
    public function before()
    {
        return $this->before;
    }
    
    /**
     * Load TAG parameters
     * @param \stdClass $std
     */
    public function loadParameters(\stdClass $std)
    {
        $this->std = $this->equalize($std, $this->name, $this->possible);
        if (!empty($this->possiblesubnode)) {
            $this->stdsubnode = $this->equalize($std, $this->subnode, $this->possiblesubnode);
        }
    }
    
    /**
     * DOMElement constructor
     * @return \DOMElement
     */
    public function toNode()
    {
        $node = $this->dom->createElement($this->name);
        $this->builder($node, $this->std, $this->possible);
        if (!empty($this->subnode) && $this->checkIfContentsExists($this->stdsubnode)) {
            $subnode = $this->dom->createElement($this->subnode);
            $this->builder($subnode, $this->stdsubnode, $this->possiblesubnode);
            $node->appendChild($subnode);
        }
        $this->dom->appendChild($node);
        return $node;
    }
    
    protected function checkIfContentsExists($std)
    {
        $response = false;
        $arr = get_object_vars($std);
        foreach ($arr as $key => $value) {
            if ($value != null) {
                $response = true;
                break;
            }
        }
        return $response;
    }


    /**
     * Retruns node as string
     * @return string
     */
    public function __toString()
    {
        if (empty($this->node)) {
            $this->node = $this->toNode();
        }
        return preg_replace("/<\\?xml.*\\?>/", '', $this->dom->saveXML($this->node));
    }
    
    /**
     * Includes missing or unsupported default properties in stdClass
     * @param stdClass $std  fields
     * @param array $possible  possible fields
     * @return stdClass
     */
    public function equalize($std, $node, $possible)
    {
        $errors = [];
        $arr = array_change_key_case(get_object_vars($std), CASE_LOWER);
        $std = json_decode(json_encode($arr));
        $possibles = array_keys($possible);
        $psstd = json_decode(json_encode($possible));
        $newstd = new \stdClass();
        foreach ($possibles as $key) {
            $possibleKeyLower = strtolower($key);
            if (!key_exists($possibleKeyLower, $arr)) {
                $newstd->$possibleKeyLower = null;
            } else {
                $newstd->$possibleKeyLower = $std->$possibleKeyLower;
            }
            if ($newstd->$possibleKeyLower === null && !empty($possible[$key]['default'])) {
                $newstd->$possibleKeyLower = $possible[$key]['default'];
            }
            if ($newstd->$possibleKeyLower === null && $possible[$key]['required']) {
                $errors[] = "O campo $node:$key (" . $possible[$key]['info'] . ") é OBRIGATÓRIO.";
            }
            if ($newstd->$possibleKeyLower !== null) {
                if ($err = $this->fieldIsInError($newstd->$possibleKeyLower, $key, $node, $possible[$key])) {
                    $errors[] = $err;
                }
                $newstd->$possibleKeyLower = (string) $newstd->$possibleKeyLower;
                if ($this->onlyAscii) {
                    $newstd->$possibleKeyLower = Strings::replaceSpecialsChars($newstd->$possibleKeyLower);
                } else {
                    $newstd->$possibleKeyLower = Strings::replaceUnacceptableCharacters($newstd->$possibleKeyLower);
                }
                if ($newstd->$possibleKeyLower != null && !empty($possible[$key]['macro'])) {
                    $value = $newstd->$possibleKeyLower;
                    $macro = $possible[$key]['macro'];
                    $newstd->$possibleKeyLower = $this->macro($value, $macro);
                }
                $param = $possible[$key];
                $newstd->$possibleKeyLower = $this->formater($newstd->$possibleKeyLower, $param['format']);
            }
        }
        if (!empty($errors)) {
            $this->errors[] = $errors;
            //throw new \InvalidArgumentException(implode("\n", $errors));
        }
        return $newstd;
    }
    
    /**
     * Check if the data given meets the parameters
     * if false is no errors
     * if string the input does not meet the requirements
     * @param string|float|integer $input
     * @param string $fieldname
     * @param string $nodename
     * @param array $pattern
     * @return bool|string
     */
    protected function fieldIsInError($input, $fieldname, $nodename, $pattern)
    {
        $type = $pattern['type'];
        $regex = $pattern['regex'];
        if (empty($regex)) {
            return false;
        }
        switch ($type) {
            case 'integer':
                if (!is_integer($input)) {
                    return "$nodename campo: $fieldname deve ser um valor numérico inteiro.";
                }
                break;
            case 'numeric':
                if (!is_numeric($input)) {
                    return "$nodename campo: $fieldname deve ser um numero.";
                }
                break;
            case 'string':
                if (!is_string($input)) {
                    return "$nodename campo: $fieldname deve ser uma string.";
                }
                break;
        }
        $input = (string) $input;
        if ($regex === 'email') {
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return "$nodename campo: $fieldname Esse email [$input] está incorreto.";
            }
            return false;
        }
        if (!preg_match("/$regex/", $input)) {
            return "$nodename campo: $fieldname valor incorreto [$input]. (validação: $regex)";
        }
        return false;
    }
   
    /**
     * DOM constructor based in parameters
     * @param \DOMElement $node
     * @param \stdClass $std
     * @param array $parameters
     * @return void
     */
    protected function builder(&$node, $std, $parameters)
    {
        foreach ($parameters as $key => $param) {
            if ($key === 'item') {
                continue;
            }
            $keyLower = strtolower($key);
            $value = (string) $std->$keyLower;
            
            if ($param['position'] === 'attribute') {
                if ($param['required'] || $std->$keyLower !== null) {
                    $prefix = !empty($param['prefix']) ? $param['prefix'] : '';
                    $node->setAttribute(
                        $key,
                        $prefix . $value
                    );
                }
            }
            if ($param['position'] === 'node') {
                if ($param['format'] === 'cdata' && !empty($value)) {
                    $ncdata = $node->appendChild($this->dom->createElement($key));
                    $ncdata->appendChild($this->dom->createCDATASection($value));
                } else {
                    $this->dom->addChild(
                        $node,
                        $key,
                        $value,
                        $param['required'],
                        $param['info']
                    );
                }
            }
        }
    }
    
    public function realStd($std, $possibles)
    {
        $real = new \stdClass();
        foreach ($possibles as $key => $param) {
            $possibleKeyLower = strtolower($key);
            if ($std->$possibleKeyLower !== null) {
                $real->$key = $std->$possibleKeyLower;
            }
        }
        return $real;
    }

    protected function macro($value, $macro)
    {
        $m = explode('|', $macro);
        $func = $m[0];
        if (method_exists($this, $func)) {
            return $this->$func($value, $m[1]);
        }
        return $value;
    }

    /**
     * Format float numbers if necessary
     * @param string $value
     * @param string $format
     * @return string
     */
    protected function formater($value, $format = null)
    {
        if (empty($format) || !isset($value)) {
            return $value;
        }
        if (!is_numeric($value)) {
            return trim($value);
        }
        $n = explode('v', $format);
        $mdec = strpos($n[1], '-');
        $numberasstring = number_format($value, 0, '.', '');
        $p = explode('.', $value);
        $ndec = !empty($p[1]) ? strlen((string) $p[1]) : 0;//decimal digits
        $nint = strlen($numberasstring);//integer digits
        if ($nint > $n[0]) {
            $this->errors[] = "O numero [$value] é maior que o permitido [$format].";
            return $value;
            //throw new \InvalidArgumentException("O numero é maior que o permitido [$format].");
        }
        if ($mdec !== false) {
            //is multi decimal
            $mm = explode('-', $n[1]);
            $decmin = $mm[0];
            $decmax = $mm[1];
            //verificar a quantidade de decimais informada
            //se menor que o minimo, formata para o minimo
            if ($ndec <= $decmin) {
                return number_format($value, $decmin, '.', '');
            }
            //se maior que o minimo, formata para o maximo
            if ($ndec > $decmin) {
                return number_format($value, $decmax, '.', '');
            }
        }
        return number_format($value, $n[1], '.', '');
    }
    
    /**
     * Add left zeros if necessary
     * @param string $value
     * @param integer $length
     * @return string
     */
    protected function zeroLeft($value, $length)
    {
        return str_pad($value, $length, '0', STR_PAD_LEFT);
    }
    
    protected function hashCSRT($CSRT)
    {
        $comb = $CSRT . $this->chNFe;
        return base64_encode(sha1($comb, true));
    }
}
