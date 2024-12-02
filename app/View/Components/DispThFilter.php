<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DispThFilter extends Component
{
    /**
     * Create a new component instance.
     */

    public $page;
    public $name;
    public $value;
    public $sortBy;
    public $sortOrder;
    public $placeholder;
    public $showId;
    public $filtersId;
    public $otherId;
    public $class;
    public $id;
    public $type;
    public $items=[];
    public function __construct($page,$name,$value='',$placeholder='',$sortOrder='',$sortBy='',$otherId='',$showId='tbl-result',$filtersId='frm-filters',$class='',$id='',$type='text',$items=array())
    {
        $this->page = $page;
        $this->name = $name;
        $this->sortBy = $sortBy;
        $this->value = $value;
        $this->sortOrder = $sortOrder;
        $this->placeholder = $placeholder;
        $this->showId = $showId;
        $this->filtersId = $filtersId;
        $this->otherId = $otherId;
        $this->class = $class;
        $this->id = $id;
        $this->type = $type;
        $this->items = $items;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.disp-th-filter');
    }
}
