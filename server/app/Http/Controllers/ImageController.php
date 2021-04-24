<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use App\Models\Image;
use Validator;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function getMany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'camera_name' => 'string|in:FHAZ,RHAZ',
            'rover_name' => 'string|in:Curiosity,Opportunity,Spirit',
            'date' => 'date',
            'date_from' => 'date',
            'date_to' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = DB::table('images');

        if ($request->has('date')) {
            $query->where('date', $request->date);
        }
        else if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('date',[$request->date_from, $request->date_to]);
        }
        else {
            $holidays = json_decode(Holiday::get(),true);
            $dates = array_map(function ($ar) {return $ar['date'];}, $holidays);
            $query->whereIn('date',$dates);
        }

        if ($request->has('rover_name')) {
            $query->where('rover_name', $request->rover_name);
        }
        if ($request->has('camera_name')) {
            $query->where('camera_name', $request->camera_name);
        }

        $images = $query->get();

        return response()->json([
            'message' => 'Images successfully returned',
            'images' => $images
        ], 201);
    }
    public function getSingle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_url' => 'url',
            'date' => 'date',
            'rover' => 'string',
            'camera' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = DB::table('images');

        if ($request->has('image_url')) {
            $query->where('img_src', $request->image_url);
        }

        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        if ($request->has('rover')) {
            $query->where('rover_name', $request->rover);
        }

        if ($request->has('camera')) {
            $query->where('camera_name', $request->camera);
        }

        $images = $query->get();

        return response()->json([
            'message' => 'Images successfully returned',
            'images' => $images
        ], 201);
    }
    public function refresh()
    {
        $dates = Holiday::get();
        $api_key = 'dR16HqWVdt8m3sRX44MQwWgeVMpbB4zfN4lA4MOg';

        $rovers = array('curiosity','opportunity','spirit');

        foreach ($dates as $date) {
            foreach ($rovers as $rover) {
                $url='https://api.nasa.gov/mars-photos/api/v1/rovers/'.$rover.'/photos?earth_date='.$date->date.'&api_key='.$api_key;
                $client = new \GuzzleHttp\Client();
                $res = $client->get($url);
                $content = json_decode($res->getBody());

                foreach ($content->photos as $photo) {
                    Image::updateOrCreate([
                        'date' => $photo->earth_date,
                        'img_src' => $photo->img_src,
                        'rover_name' => $photo->rover->name,
                        'camera_name' => $photo->camera->name,
                    ]);
                }
            }
        }
    }
}
