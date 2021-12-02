<?php
namespace Lum\Jose\Algorithms;

interface Algorithm
{
    public function getName() : string;

    public function getSigner();
}