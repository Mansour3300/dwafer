<?php

namespace App\Http\Controllers\Home;
use App\Models\Provider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FilterProviderController extends Controller
{

    public function filter(Request $request)
    {
        $request->validated();
        $filter = Provider::where('city',$request->city)
                        ->where('provider_type',$request->type)
                        ->get();
                        // ->where('rate',$rate);
    }
}
