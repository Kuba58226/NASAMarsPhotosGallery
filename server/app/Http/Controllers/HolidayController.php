<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function refresh()
    {
        $holidays = array('2020-01-01','2020-01-06','2020-04-12','2020-04-13','2020-05-01','2020-05-03','2020-05-31','2020-06-11','2020-08-15','2020-11-01','2020-11-11','2020-12-25','2020-12-26');

        foreach ($holidays as $element) {
            Holiday::updateOrCreate([
                'date' => $element,
            ]);
        }
    }
}
