<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Muestra el dashboard o menú principal de configuración.
     */
    public function index()
    {
        return view('admin.config.index');
    }
}