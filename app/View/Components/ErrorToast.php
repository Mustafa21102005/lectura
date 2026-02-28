<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ErrorToast extends Component
{
    public ?string $message;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Automatically grab the first error if any
        $this->message = session('errors')?->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Only render if there is an error
        return $this->message
            ? view('components.error-toast') : '';
    }
}
