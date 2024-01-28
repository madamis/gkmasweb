<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextField extends Component
{
    public string $type;
    public string $input;
    public string $required = '';
    public $item;
    /**
     * Create a new component instance.
     */
    public function __construct($input, $item, $type='text')
    {
        $this->type = $type;
        $this->item = $item;
        if(str_ends_with($input, '*'))
        {
            $this->required = "required";
            $this->input = substr($input, 0, strlen($input)-1);
        }
        else
        {
            $this->input = $input;
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.text-field');
    }
}
