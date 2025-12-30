<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DispThSort extends Component
{
    /**
     * Create a new component instance.
     */

    public $page;
    public $name;
    public $sortBy;
    public $sortOrder;
    public $displayName;
    public $showId;
    public $filtersId;
    public $otherId;
    public $class;
    public $width;

    public function __construct($page='',$name='',$sortOrder='',$displayName='',$sortBy='',$otherId='',$showId='tbl-result',$filtersId='frm-filters',$class='',$width='')
    {
        $this->page = $page;
        $this->name = $name;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
        $this->displayName = $displayName;
        $this->showId = $showId;
        $this->filtersId = $filtersId;
        $this->otherId = $otherId;
        $this->class = $class;
        $this->width = $width;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.disp-th-sort');
    }
}
