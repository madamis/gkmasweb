<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MasterForm extends Component
{
    public string $url;
    public array $fields;
    public string $formData = '';
    public string $method;
    public $item;
    public string $title;
    /**
     * Create a new component instance.
     */
    public function __construct($url, $title, $fields = [], $item = null, $method = '')
    {
        $this->url = $url;
        $this->title = $title;
        $this->item = $item;
        $this->method = $method;
        $default_values = [
            'files'=>[],
            'inputs'=>[],
            'dates'=>[],
            'selects'=>[],
            'textfields'=>[],
        ];
        $this->fields = array_merge($default_values, $fields);
        if(!empty($this->fields['files']))
        {
            $this->formData = "enctype=multipart/form-data";
        }
    }

    public function isRequired($input)
    {
        return str_ends_with($input, '*');
    }

    public function fieldName($input)
    {
        if (str_ends_with($input, '*')) {
            $input = substr($input, 0, strlen($input) - 1);
        }
        return $input;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.master-form');
    }
}
