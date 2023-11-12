<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignerController extends Controller
{
    function AllUIReports(){
        $allReports = DB::table('uireport')->select('id','visiblename')->get();
        return view('ese/designer/indexAllReports')->with("allReports",$allReports);
    }
    function AllUIPages(){
        $allPages = DB::table('uipage')->select('id','path','visiblename')->get();
        return view('ese/designer/indexAllPages')->with("allPages",$allPages);
    }
    function AllUIWidgets(){
        //AllWidgets
        $allWidgets = DB::table('uiwidget')->select('id','path','visiblename')->get();
        return view('ese/designer/indexAllWidgets')->with("allWidgets",$allWidgets);


        //allWidgets
    }
    function AllObjects(){
        //тупа список
    }
    function AllProcess(){
        //тупа список
    }
    function OrganizationItemPreview(){
        $organizationItems = DB::table('organizationItem')->get();
        return view('ese/designer/organizationItem')->with("organizationItems",$organizationItems);
        //короче идея такова, выводится SVG со штаткой, по клику - открывается Editor
    }
}
