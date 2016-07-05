<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;//?????
use App\Guide;//per trovare l'utente in questopm
use DB;//per le query
use View;//per ritornare la view in showform
use App\Reservation;

class UserController extends Controller
{
    public function showuser(Request $request,$id){
      $data_inizio='2016-06-10';
      $data_fine='2016-06-29';
      //date da recuperare dalla richiesta
    	//prende id.
    	//guide_place: day e time non devono essere in  
    	//reservation dayofweek,time dove la guida è lei
    	//TODO e la dta della visita cade dell'intervallo d'interesse

    	$user=User::find($id); //e poi ne stampa alcune/tutte
      if($user){

    	$guide_avail=Guide::find($id)
    	->places()->join("guide_place as g","g.place_id","=","places.id")
    	->first();
      $guide_avail=DB::table('guides as g')
      ->where('g.id','=',$id)
      ->join("guide_place as g2","g2.guide_id","=","g.id")
      ->whereNotIn(DB::raw('(g2.day,g2.time)'), 
	    function($query) use ($id,$data_fine,$data_inizio)
		  {
    		$query->select(DB::raw('DAYOFWEEK(date) as day'),'time')
          		  ->from('reservations')
          		  ->where('guide_id',"=",$id)	  
          		  ->where('date','>',$data_inizio)
          		  ->where('date','<',$data_fine);
		  })
      ->get();

      //sarebbe più elegante passare i dati alla view

      foreach ($guide_avail as $key => $value) {
        echo $value->day.'<-----DAy  '.$value->time.'<----time</br>';
        //richiesta asincrona? sincrona? come?
        //redirect withInput() no
        //form con roba si
        echo '<a href="prenota/'.$id.'">';
      }
      echo $name=$user->name.'<---nome utente</br>' ;
    	dd($guide_avail);
    }
    }

    public function showform(Request $request,$id){//crea la view di prenotazione
        $id=['id_prenotando'=>$id,
            'richiesta'=>$request,
            ];
        Return View::make('reserve',$id);//da aggiungere anche parametri post
    }

    public function reserve(Request $request){//user id lo devo raccatare 
      //dall'autenticazione via API. in alternativa sarebbe simparico csrf
        $attempt=Reservation::create([
          'guide_id'=>$request->input('guide_id'),
          'user_id'=>$request->input('user_id'),
          'date'=>$request->input('date'),
          'time'=>$request->input('time'),
          ]);
        if(!$attempt){
          return 'pschttt';
        }
        else{
          return 'miaok';
        }
        return 'sono il ghetto di lino benfi';
    }
}
