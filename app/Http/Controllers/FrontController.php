<?php

namespace App\Http\Controllers;

use App\Models\{WebSetting, NavMenu, Banner, FastAccess, Event, TablonParroquial, SocialNetwork, ContactConfig, FooterLink, Post, GridConfig};

class FrontController extends Controller
{
    public function home()
    {
        $settings = WebSetting::first();
        $template = $settings->template ?? 'campanilleros';
        $modulos = $settings->modulos_config ?? [];
        $data = [];

        // 0. Menu (Llave coincide: 'menu')
        if ($this->active($modulos, 'menu')) 
        {
            $menuItems = \App\Models\NavMenu::where('activo', true)
                ->orderBy('orden')
                ->get();
            
            // Agrupamos: los que no tienen parent_id son raíces
            $data['menu'] = $menuItems->whereNull('parent_id')->map(function($item) use ($menuItems) {
                $item->children = $menuItems->where('parent_id', $item->id);
                return $item;
            });
        }

        // 1. Banners (Llave coincide: 'banners')
        if ($this->active($modulos, 'banners')) {
            $data['banners'] = Banner::where('activo', true)->orderBy('orden')->get();
        }

        // 2. Accesos Rápidos (Cambio 'fast_access' por 'acceso_rapido')
        if ($this->active($modulos, 'acceso_rapido')) {
            $data['fast_access'] = FastAccess::orderBy('orden')->take(3)->get();
        }

        // 3. Calendario (Llave coincide: 'calendario')
        if ($this->active($modulos, 'calendario')) {
            $data['eventos'] = Event::where('fecha', '>=', now()->toDateString())
            ->orderBy('fecha')
            ->get()
            ->groupBy(function($item) {
                // Agrupamos por "Enero 2026" (o el formato que prefieras para el ID)
                return \Carbon\Carbon::parse($item->fecha)->translatedFormat('F Y');
            });
        }

        // 4. Tablón Parroquial
        if ($this->active($modulos, 'tablon')) {
            $data['tablon'] = TablonParroquial::orderBy('fijado', 'desc')->orderBy('created_at', 'desc')->take(6)->get();
        }
        
        // 5. Grid de noticias (Llave coincide: 'grid')
        if ($this->active($modulos, 'grid')) {
            $gridConfig = GridConfig::first();
            if ($gridConfig) {
                $data['grid_items'] = Post::whereIn('tipo', $gridConfig->tipos_permitidos)
                                        ->where('publicado', true)
                                        ->orderBy('created_at', 'desc')
                                        ->take($gridConfig->cantidad_mostrar)
                                        ->get();
                $data['grid_titulo'] = $gridConfig->titulo_seccion;
            }
        }
        
        // Datos globales (Se cargan siempre para el Footer/Nav)
        $data['contacto'] = ContactConfig::first();
        $data['redes'] = SocialNetwork::all();
        $data['footer_links'] = FooterLink::orderBy('orden')->get();

        return view("web.templates.{$template}.home", compact('settings', 'data'));
    }

    private function active($modulos, $key) 
    {
        if (!isset($modulos[$key])) return false;
        return $modulos[$key] == true || $modulos[$key] == 1 || $modulos[$key] == 'true';
    }

    public function showPost($slug)
    {
        $settings = WebSetting::first();
        $template = $settings->template ?? 'campanilleros';
        
        // Buscamos el post por slug y que esté publicado
        $post = Post::where('slug', $slug)
                    ->where('publicado', true)
                    ->firstOrFail(); // Si no existe, lanza un 404 automáticamente

        // Cargamos datos globales para el layout (menú, footer, etc.)
        $modulos = $settings->modulos_config ?? [];
        $data['contacto'] = ContactConfig::first();
        $data['redes'] = SocialNetwork::all();
        $data['footer_links'] = FooterLink::orderBy('orden')->get();
        
        // Carga del Menú anidado (la misma lógica que en la Home)
        if (isset($modulos['menu']) && $modulos['menu']) {
            $menuItems = \App\Models\NavMenu::where('activo', true)->orderBy('orden')->get();
            $data['menu'] = $menuItems->whereNull('parent_id')->map(function($item) use ($menuItems) {
                $item->children = $menuItems->where('parent_id', $item->id);
                return $item;
            });
        }

         // 2. Accesos Rápidos (Cambio 'fast_access' por 'acceso_rapido')
        if ($this->active($modulos, 'acceso_rapido')) {
            $data['fast_access'] = FastAccess::orderBy('orden')->take(3)->get();
        }

        return view("web.templates.{$template}.post", compact('settings', 'post', 'data'));
    }
}