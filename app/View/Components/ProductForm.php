<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductForm extends Component
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
        return view('components.product-form');
    }

    public function inputField(string $name, $value = null, $id, $type = 'text'){

        return "<input type='$type' name='$name' id='$id' class='form-control'>";

    }
}
