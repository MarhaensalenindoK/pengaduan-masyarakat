<?php

namespace App\Http\Controllers;

use App\Service\Database\ClinicService;
use Illuminate\Http\Request;

class landingpageController extends Controller
{
    public function index()
    {

        return view('landingpage');
    }
}
