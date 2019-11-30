<?php

namespace NFePHP\BPe\Factories;

interface TagInterface
{
    public function loadParameters(\stdClass $std);
    public function toNode();
}
