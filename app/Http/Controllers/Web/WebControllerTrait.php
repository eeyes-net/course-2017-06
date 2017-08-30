<?php

namespace App\Http\Controllers\Web;

/**
 * Trait WebControllerTrait
 *
 * @package App\Http\Controllers\Web
 */
trait WebControllerTrait
{
    /**
     * @return \App\Http\Controllers\Api\Controller
     */
    public function apiController()
    {
        return new $this->apiControllerClass;
    }
}
