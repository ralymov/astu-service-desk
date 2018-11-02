<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends ApiController
{

    public function index(Request $request)
    {
        $this->validate($request, [
            'table_name' => 'required|max:255',
            'field_name' => 'required|max:255',
            'search_string' => 'required|max:255',
        ]);
        $query = DB::table($request->input('table_name'))
            ->where($request->input('field_name'), 'ILIKE', '%' . $request->input('search_string') . '%');
        if($request->input('search_conditionals')) {
            foreach ($request->input('search_conditionals') as $conditional) {
                $query->where($conditional['field'], $conditional['value']);
            }
        }
        return $query->get();
    }

}
