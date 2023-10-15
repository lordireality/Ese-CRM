<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class OrganizationItemController extends Controller
{
    function GetAllPositions(){
        return DB::table('organizationitem')->orderby('id')->get();
    }
    function BuildTree(){
        
        return view('ese/organizationitem/organizationitemtree')->with('organizationitems',DB::table('organizationitem')->orderby('id')->get());


       
    }
}
