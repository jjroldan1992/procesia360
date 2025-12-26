<?php

namespace App\Http\Controllers;

use App\Models\{WebSetting, Banner, FastAccess, Event, TablonParroquial, SocialNetwork, ContactConfig, FooterLink, Post, GridConfig};

class FrontController extends Controller
{
    public function home()
    {
        $settings = WebSetting::first();
        $template = $settings->template ?? 'campanilleros';
        $modulos = $settings->modulos_config ?? [];
        $data = [];
        
        // Carga condicional de datos
        if ($this->active($modulos, 'banners')) $data['banners'] = Banner::where('activo', true)->orderBy('orden')->get();
        if ($this->active($modulos, 'fast_access')) $data['fast_access'] = FastAccess::orderBy('orden')->take(3)->get();
        if ($this->active($modulos, 'calendario')) $data['eventos'] = Event::where('fecha', '>=', now()->toDateString())->orderBy('fecha')->take(4)->get();
        if ($this->active($modulos, 'tablon')) $data['tablon'] = TablonParroquial::orderBy('fijado', 'desc')->take(6)->get();
        
        // Datos globales para el Footer/Nav
        $data['contacto'] = ContactConfig::first();
        $data['redes'] = SocialNetwork::all();
        $data['footer_links'] = FooterLink::orderBy('orden')->get();

        return view("web.templates.{$template}.home", compact('settings', 'data'));
    }

    private function active($modulos, $key) {
        return isset($modulos[$key]) && $modulos[$key] === true;
    }
}