<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function addition($a, $b){

        return $a + $b;

    }

    public function subtract($a, $b){

        return $a - $b;

    }
}
