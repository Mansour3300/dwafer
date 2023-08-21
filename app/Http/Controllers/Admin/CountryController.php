<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;

class CountryController extends Controller
{
    public function index()
    {
        $country= Country::all();
        return response()->json(['success'=>'true','data'=>$country,'message'=>'']);
    }

    public function store(CountryRequest $request)
    {
        $new_country = $request->validated();
        $new_country['country_image']= $request->file('country_image')->store('image','public');
        Country::create($new_country);

        return response()->json(['success'=>'true','data'=>null,'message'=>trans('message.country.you_added_country_successfully')]);
    }


    public function show(string $id)
    {
        $country = Country::findorfail($id);
        return response()->json(['status'=>'success','data'=>$country,'message'=>'']);
    }


    public function update(CountryRequest $request, string $id)
    {
        $data = $request->validated();
        $data['country_image']= $request->file('country_image')->store('image','public');
        Country::findorfail($id)->update($data);
        return response()->json(['success'=>'true','data'=>null,'message'=>trans('message.country.country_updated')]);
    }

    public function destroy(string $id)
    {
        $country_image = Country::findorfail($id)->country_image;
        $country = Country::findorfail($id);
        unlink(storage_path('app/public/'.$country_image));
        $country->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.country.country_deleted')]);
    }
}
