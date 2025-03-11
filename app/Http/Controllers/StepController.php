<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class StepController extends Controller
{
    // Step 1
    public function showStep1()
    {
        return view('step.1');
    }

    // Step 2
    public function showStep2()
    {
        $products = Produk::all();
        return view('step.2', compact('products'));
    }

    // Step 3
    public function showStep3()
    {
        $products = Produk::all();
        return view('step.3', compact('products'));
    }

    // Step 4
    public function showStep4()
    {
        $products = Produk::all();
        return view('step.4', compact('products'));
    }
}
