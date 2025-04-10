<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PlacesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlaceExports;

class PlacesController extends Controller
{
    public function show(Request $request){
        try{
            $get = PlacesModels::all();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetched all places',
                'data' => $get
            ]);
        }catch(\Exception $e){
            return $e;
        }
    }

    public function create(Request $request){
        try{
            PlacesModels::firstOrCreate([
                'name' => $request->name,
                'address' => $request->address,
                'long' => $request->long,
                'lat' => $request->lat,
                'type' => $request->type,
                'rating' => $request->rating,    
                'vicinity' => $request->vicinity,
                'photo' => $request->photo,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan'
            ]);
        }catch(\Exception $e){
            return $e;
        }
    }

    public function search(Request $request){
        try{
            $url = "https://maps.googleapis.com/maps/api/place/textsearch/json";
            $apiKey = env("MAPS_API");
         
            $query = $request->category . " di " . $request->location;
            
            $allResults = []; 
            $nextPageToken = null;
        
            do {
                
                $params = [
                    'query' => $query,
                    'key' => $apiKey
                ];
        
                if ($nextPageToken) {
                    $params['pagetoken'] = $nextPageToken;
                    sleep(2); 
                }
        
                
                $response = Http::get($url, $params);
                $data = $response->json();
        
                
                if (isset($data['results'])) {
                    $allResults = array_merge($allResults, $data['results']);
                }
        
                
                $nextPageToken = $data['next_page_token'] ?? null;
                
            } while ($nextPageToken);

            foreach( $allResults as $res ){
                PlacesModels::firstOrCreate([
                    'name' => $res['name'],
                    'address' => $res['formatted_address'],
                    'long' => $res['geometry']['location']['lng'],
                    'lat' => $res['geometry']['location']['lat'],
                    'type' => $res['types'][0],
                    'rating' => $res['rating'],    
                    'vicinity' => $res['formatted_address'],
                ]);
            }
            
            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetched all places',
                'data' => $allResults
            ]);     
        }catch(\Exception $e){
            return $e;
        }
    }

    public function export(Request $request){
        return Excel::download(new PlaceExports, 'places-'.Date('d-m-Y-H:i:s').'.xlsx');
    }

    public function reset_places(Request $request){
        try{
            PlacesModels::truncate();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully reset all places'
            ]);
        }catch(\Exception $e){
            return $e;
        }
    }
}
