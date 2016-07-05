<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Guide;
use App\Place_guide;
use Auth;
use App\Place;
use DB;
use App\Events\SomeEvent;
use Event;
class GuideController extends Controller
{
    public function addguide(Request $request){
    		$username=Auth::guard('api')->user()->id;
			$place=Guide::create([
				"normal_user_id"=>$username,
				]);
			if(!$place){
				return ('guide wasnt crieitid');
			}
			else{
				return 'saccsessfullicieitid';
			}
    	}
    public function fire(){
    	//Event::fire(new SomeEvent("squek"));
    	$guide_con_servizi=Guide::with('services.infos')->where('id','=','1')->get();
    	dd($guide_con_servizi[0]['relations']['services'][0]['relations']['infos']);    	



    }



    
    
}
