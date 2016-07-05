<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;  //used to authenticate
use DB;

Use App\Guide;
use App\Info;
use App\PlaceGuideInfo;
use App\Place_guide;
use App\Place;  //used to insert
use App\Reservation;//to create reservations
use App\Review;
class PlaceController extends Controller
{
    public function dump(Request $request){
        $pls=Place::all();
        foreach ($pls as $key => $value) {
           echo $value['id'].':'.$value['name'].'</br>';
        }
    }

    public function addservice(Request $request){
        //recupero i dati d'interesse
        //request structure: 
        //user declares a begin and an end day
        //service inserts begin day +7*n days til end day

            //search for a guide_place relationship

        $guide_id=Auth::guard('api')->user()->id;
        $place_id=$request->input('place_id');
        $costo=$request->input('cost');
        $begin=$request->input('begin');
        $end=$request->input('end');
        $time=$request->input('time');
        
        $relationship=Place_guide::where("guide_id","=",$guide_id)
        ->where("place_id","=",$place_id)
        ->first();
        if($relationship){
            $relation_id=$relationship->id;
            $created_now=false;
        }
        else{
            $new_relation=Place_guide::create([
                'place_id'=>$place_id,
                'guide_id'=>$guide_id,
                ]);
            $relation_id=$new_relation->id;
            $created_now=true;
        }

        //create an array of rows <info>, whose dates are 
        //7-days-spaced
        
        $date=date_create($begin);
        $end=date_create($end);
        $cont=0;
        while($date<$end){
            $data_stringa=date_format($date,"Y-m-d"); 
            
            $esistente=Place_guide::whereHas('infos',function($query) use($time,$data_stringa){
                $query
                ->where('time',$time)
                ->where('date',$data_stringa);
            })
            ->where('guide_id',$guide_id)
            ->where('place_id',$place_id)
            ->first();
                        
            if(!$esistente){//if guide is free
                //no other control is necessary: this set of cols is uq 
                $datas=[
                "date"=>$data_stringa,
                "cost"=>$costo,
                "guide_place_id"=>$relation_id,
                "time"=>$time,
                "reserved"=>0,
                ];
                $detail2=Info::create($datas);
                $full_datas[$cont]=$datas;
                $cont++;
                
            }
            $date=date_add($date,date_interval_create_from_date_string("7 days"));
               
        }
        if(!isset($datas[0])&&$created_now){//if place created and no service created
            Place_guide::destroy($id);
        }
        if(isset($full_datas[0]))
            echo json_encode($full_datas);
        else
            echo json_encode(false);
        
    }


    public function findguides(Request $request){



        //should return 
        //guide_id cost date time
        //great problem: user doesn't basically know 
        //what is place id
        $data_visita=$request->input('date');
        $place_name=$request->input('place_name');//to lower
        $place_in_db=Place::where('name',$place_name)
        ->first();

//find id from name
        if($place_in_db)//if found great!
            $place_id=$place_in_db->id;
        else{//if not let's ask google
            $place_name=str_replace(' ', '+', $place_name);
            $url='https://maps.googleapis.com/maps/api/geocode/json?address='.$place_name.'&key=AIzaSyAV-OVyJpJLWGYrWUCxhzjzjCkY4YOpnTM';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $output_obj=json_decode($output);
            //dd($output_obj);
            if($output_obj->status=='OK'){//if google could find
                $lat=$output_obj->results[0]->geometry->location->lat;
                $lng=$output_obj->results[0]->geometry->location->lng;
            
                $places=Place::all();
                $min=17000;
                foreach ($places as $key => $current_place) {
                    $tmp=($current_place->lat-$lat)^2+($current_place->lng-$lng)^2;
                    if($tmp<$min){
                        $min=$tmp;
                        $id_min=$current_place->id;
                    }
                }
                $place_id=$id_min;
            }
            else{
                die('no result found');         
            }
        }
        $guide=Place_guide::with([
                'infos'=>function($q) use ($data_visita){
                                $q->where('date',$data_visita);
                        }
                        ])
        ->where("place_id",'=',$place_id)
        ->get()
        ;
        foreach ($guide as $key => $value) {
            echo 'la guida numero '.$value['guide_id'].' potrebbe a costo ';
            echo $value->infos[0]['cost'].'</br>';
        }
    }

    public function reserve(Request $request){
        $username=Auth::guard('api')->user()->id;
        $guide_id=$request->input('guide_id');
        $date=$request->input('date');
        $time=$request->input('time');
        
        $info=Info::with([
            'place_guide_owner'=>function($query) use ($guide_id){
            $query->where('guide_id',$guide_id);
        }])
        ->where('date',$date)
        ->where('time',$time)
        ->first();
        if($info){//if not deleted just now
            if(!$info->reserved){//and not reserved just now
            $id=$info->id;
                Reservation::create([
                        'info_id'=>$id,
                        'user_id'=>$username,
                ]);
                $info->reserved=true;
                $info->save();
            }
        }
        
        echo json_encode($info);
    }

    public function review(Request $request){
        $username=Auth::guard('api')->user()->id;
        $reservation_id=$request->input('reservation_id');
        $text=$request->input('text');
        $rating=$request->input('rating');
        $reservation=Reservation::find($reservation_id)
        ->with('info')
        ->first();
        if($reservation){//if exists
            $visit_date=date_create($reservation->info->date);
            $now=date_create();
            if($reservation->user_id==$username&&$now>$visit_date){//and belongs to auth
               
               $att=Review::where('reservation_id',$reservation_id)
               ->where('reservation_id',$reservation_id)
               ->delete();
               
               $recensione=Review::create([
                    'text'=>$text,
                    'rating'=>$rating,
                    'reservation_id'=>$reservation_id,
                ]);
                    echo json_encode($recensione);
                exit();
            }
            else
                dd('unauthorized attempt');
        }
        else{
            dd('visit does not exist');
        }
    }
    


}
