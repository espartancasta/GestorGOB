<?php

namespace App\View\Components\Frontend;

use App\Models\Menu;
use App\Models\SiteSetting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $sitesettings = SiteSetting::first();
        $menuModel = Menu::first();
        $menu = $menuModel ? json_decode($menuModel->header_menu, true) : [];
        return view('components.frontend.header', compact("sitesettings", "menu"));
    }
}
