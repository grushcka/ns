<?php

namespace NS\Http\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Trait ViewHelper
 * Code Sugar for views
 * @package NS\Http\Traits
 */
trait ViewHelper
{
    /**
     * @param  string  $name
     * @param  array  $params
     * @return Application|Factory|View
     */
    protected function view(string $name, $params = [])
    {
        return view("{$this->viewPrefix}.{$name}", $params);
    }
}
