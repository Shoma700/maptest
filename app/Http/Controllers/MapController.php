<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 


class MapController extends Controller
{
    public function topPage(Request $request)
    {
        
        
        //配列にいくつかの緯度経度のセットを格納
        //緯度経度はカンマでつなぎ、スペースは含めない
        $latlngList = array("43.041403,141.31998", "43.157152,141.39035", "43.12192,141.374715", "43.042741,141.395135");
        $key = 'AIzaSyABi2A12CToQD-cW0SnaaitdLI6UBQTOew';
        $keyword = 'ボーリング場';
        foreach($latlngList as $latlng){
            $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latlng.'&radius=10000&language=ja&keyword='.$keyword.'&key='.$key;
            $data= json_decode(@file_get_contents($url), true);
            dump($data);
            foreach($data["results"] as $info){
                $lat = $info["geometry"]["location"]["lat"]; //対象施設の緯度
                $lng = $info["geometry"]["location"]["lng"]; //対象施設の経度
                //緯度経度をもとに日本語の住所を取得
                $geo = json_decode(@file_get_contents('http://maps.google.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false&language=ja'), true);
                $address = $geo['results'][0]['formatted_address'];
                //緯度、経度、施設名、住所をカンマ区切りで画面に出力
                //dump($lat.",".$lng.",".$info["name"].$info["vicinity"].$address."<br>");
                //dump($geo);
                dump($key);
                //dump("test");
                
            }
        }
        // データーベースなどから表示したい住所を取得。
        // 本記事では「東京都庁」の住所を固定で設定する。
        $address = "東京都新宿区西新宿２−８−１";
        dump($key);
        dump($address);

        //return view('topPage', compact('address'));
    }
    
}
