<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Course;
use App\Download;
use App\Teacher;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        return [
            'course' => Course::search($q)->ordered()->paginatePluckSimpleData(5),
            'teacher' => Teacher::search($q)->ordered()->paginatePluckSimpleData(5),
            'download' => Download::search($q)->ordered()->paginatePluckSimpleData(),
            'category' => Category::search($q)->paginatePluckSimpleData(5),
        ];
    }
}
