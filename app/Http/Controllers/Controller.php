<?php

namespace NS\Http\Controllers;

use Illuminate\Foundation\{Auth\Access\AuthorizesRequests, Bus\DispatchesJobs, Validation\ValidatesRequests};
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
