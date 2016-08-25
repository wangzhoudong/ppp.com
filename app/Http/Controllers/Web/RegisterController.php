<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;

class RegisterController extends Controller
{

    private $_service;


    function __construct()
    {
        parent::__construct();
    }


    public function gov() {
        return view('web.register.gov');
    }

    public function expert() {
        $territory = dict()->get('global',"territory");
        $education = dict()->get('global',"education");

        return view('web.register.expert',compact('territory','education'));
    }

}
