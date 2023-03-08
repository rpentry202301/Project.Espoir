<?php

namespace App\View\Components;

use App\Models\PrimaryCategory;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $user = Auth::user();
        $categories = PrimaryCategory::orderBy('id')->get();

        return view('components.header')->with([
            'user' => $user,
            'categories' => $categories
        ]);
    }
}
