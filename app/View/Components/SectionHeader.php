<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SectionHeader extends Component
{
    public string $sectionName;
    public string $sectionTitle;
    public string $sectionDescription;
    /**
     * Create a new component instance.
     */
    public function __construct($sectionName, $sectionTitle, $sectionDescription)
    {
        $this->sectionName = $sectionName;
        $this->sectionTitle = $sectionTitle;
        $this->sectionDescription = $sectionDescription;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.section-header');
    }
}
