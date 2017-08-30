<?php

namespace App\Http\Controllers\Web;

use App\Comment;
use Illuminate\Http\Request;

/**
 * Trait PostControllerTrait
 *
 * @package App\Http\Controllers\Web
 *
 * @property string $viewPrefix
 *
 * @method \App\Http\Controllers\Api\Controller apiController()
 */
trait PostControllerTrait
{
    public function index()
    {
        return view('web.' . $this->viewPrefix . '.index', ['data' => $this->apiController()->index()]);
    }

    public function show($id)
    {
        return view('web.' . $this->viewPrefix . '.show', ['data' => $this->apiController()->show($id)]);
    }

    public function search(Request $request)
    {
        return view('web.' . $this->viewPrefix . '.search', ['data' => $this->apiController()->search($request)]);
    }

    public function comment($id)
    {
        return view('web.' . $this->viewPrefix . '.comment', ['data' => $this->apiController()->comment($id)]);
    }
}