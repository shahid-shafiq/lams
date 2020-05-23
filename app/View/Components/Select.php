<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{

    public $data;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.select', ['data' => $this->data]);
        //return view('components.select', ['type' => $this->type]);
    }
}
