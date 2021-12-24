<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DatePicker extends Component
{
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */



    // argument ($id) is a id="appointmentStartDate or appointmentEndDate" 
    public function __construct($id)
    {
        //$this->id means public $id;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.date-picker');
    }
}
