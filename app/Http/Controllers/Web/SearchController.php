<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    use WebControllerTrait;

    protected $apiControllerClass = \App\Http\Controllers\Api\SearchController::class;

    public function search(Request $request)
    {
        $result = $this->apiController()->search($request);
        return view('web.search.search', [
            'course' => $result['course'],
            'teacher' => $result['teacher'],
            'q' => $request->query('q', ''),
        ]);
    }
}
