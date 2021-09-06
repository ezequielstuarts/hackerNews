<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticiaController extends Controller
{
    public function index() {
        return view('noticias');
    }
    
    public function getNoticias() {
        
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://hacker-news.firebaseio.com/v0/maxitem.json?print=pretty')->getBody();
        $maxId = json_decode($response->getContents(), true);
        $ultimasDiez = [];
        $count=0;
        for($i=0; $i<500; $i++) {
            if($count<10) {
                $response = $client->get('https://hacker-news.firebaseio.com/v0/item/'.$maxId.'.json?print=pretty')->getBody();
                $noticia = json_decode($response->getContents(), true);
                if(isset($noticia['title']) AND isset($noticia['url'])) {
                    $ultimasDiez += [$i => $maxId];
                    $maxId--;
                    $count++;
                } else {
                    $maxId--;
                }
            }
        };
        $noticias = [];
        foreach ($ultimasDiez as $key => $value) {
            $response = $client->get('https://hacker-news.firebaseio.com/v0/item/'.$value.'.json?print=pretty')->getBody();
            $last = json_decode($response->getContents(), true);
            $noticias[$key] = $last;
            $noticias[$key] += ['noticia_id' => $value];
        }
        $fav = Auth::user()->load('favoritas');
        foreach ($noticias as $key => $value) {
            foreach ($fav['favoritas'] as $keyf => $valuef) {
                if($valuef['noticia_id'] == $value['id']) {
                    $noticias[$key] += ['fav' => 1];
                }
            }
        }
        return response()->json(['data' => $noticias], 200);
    }

    public function toggleFavourite($id) {        
        $favoritasByUser = Auth::user()->favoritas->where('noticia_id', $id);
        if($favoritasByUser->count()) {
            DB::table('favourite_news')
            ->where('user_id',Auth::user()->id)
            ->where('noticia_id',$id)
            ->delete();
            $success = 204;
        } else {
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://hacker-news.firebaseio.com/v0/item/'.$id.'.json?print=pretty')->getBody();
            $noticia = json_decode($response->getContents(), true);
            if(!isset($noticia['title'])) {
                $success = 'No se puede agregar una noticia sin título.';
                return response()->json($success);
            };
            if(!isset($noticia['url'])) {
                $success = 'No se puede agregar una noticia sin link.';
                return response()->json($success);
            };
            DB::table('favourite_news')->insert([
                'user_id' => Auth::user()->id,
                'noticia_id' => $noticia['id'],
                'title' => $noticia['title'],
                'url' => $noticia['url'],
                'fav' => 1,
            ]);
            $success = 200;
        }        
        return response()->json($success);
    }
    
    public function favoritas() {
        return view('favoritas');
    }
    
    public function getFavoritasByUser() {
        return response()->json(['user' => Auth::user()->load('favoritas')]);
    }
}
