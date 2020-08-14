<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InfaaqGrid extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    /*
    $infaaq = [
        'infaaq' => [
            [
            'year' => 2018,
            'month' => [91, 92, 93, 94, 95, 96, 97, 98, 99, 80, 81, 82]
            ],
            [
                'year' => 2019,
                'month' => [91, 92, 93, 94, 95, 96, 97, 98, 99, 80, 81, 82]
            ],
            [
                'year' => 2020,
                'month' => [91, 92, 93, 94, 95, 96, 97, 98, 0, 0, 0, 0]
            ]     
        ]
    ];
    */

    public $title;
    public $myinf;

    public function __construct($title, $myinf)
    {
        $this->title = $title;
        $this->myinf = $myinf;
        //var_dump($this->data);        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.infaaq-grid', ['data' => $this->myinf]);
    }
}
