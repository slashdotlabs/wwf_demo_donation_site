<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;
use Illuminate\View\View;

class InputWithLabel extends Component
{
    public string $labelText;
    public string $name;

    public function __construct(string $labelText, string $name)
    {
        $this->labelText = $labelText;
        $this->name = $name;
    }

    public function getErrorBagName()
    {
        $pattern = '/(.*)\[(.*)\]/';
        preg_match($pattern, $this->name, $matches);
        return empty($matches) ? $this->name : "{$matches[1]}.{$matches[2]}";
    }

    public function getDefaultClasses()
    {
        $default = "form-input block w-full sm:text-sm sm:leading-5 ";
        if( session()->has('errors') && session('errors')->has($this->getErrorBagName())){
            $default .= "border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red ";
        }
        return $default;
    }

    public function render(): View
    {
        return view('components.inputs.input-with-label');
    }
}
