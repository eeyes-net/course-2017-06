<?php

namespace App\Http\ViewComposers;

use App\Category;
use Illuminate\View\View;

class CategoryComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', Category::all());
    }
}