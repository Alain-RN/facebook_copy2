<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PublicationPopup extends Component
{
    public $post;
    public $authUser;

    public function __construct($post, $authUser)
    {
        $this->post = $post;
        $this->authUser = $authUser;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.publication-popup');
    }
}
