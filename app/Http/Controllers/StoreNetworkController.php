<?php

namespace App\Http\Controllers;

use App\Models\StoreNetwork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class StoreNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getall()
    {

        $timestamp = Carbon::now()->timestamp;

        $connections = StoreNetwork::all();
        foreach ($connections as $connection) {

            $curr_time =  $connection->current_timestamp;

            $con_status =  $timestamp - $curr_time;

            if ($curr_time == null) {
                $status = "New Connection";
                $stat = 2;
            } else if ($con_status >= 180) {
                $status = "Disconnected";
                $stat = 0;
            } else {
                $status = "Connected";
                $stat = 1;
            }
            $connection->status = $status;
            $connection->bin = $stat;
          
        }

        $sorted =  $connections->sortBy('bin')->toArray();

        $arr = array_values($sorted);

        return response()->json($arr , 200);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function networkprompt(Request $request, $store_code)

    {
        $clientIP = $request->getClientIp(true);

        $store_code = $store_code;
        $network_promt = StoreNetwork::where('store_code', $store_code)->get();


        if (count($network_promt) != 0) {

            $previous_timestamp = $network_promt[0]->current_timestamp;
            $current__timestamp = Carbon::now()->timestamp;
            $previous_ip = $network_promt[0]->current_ip;


            StoreNetwork::where('store_code', $store_code)->update([
                'previous_timestamp' =>  $previous_timestamp,
                'current_timestamp' =>  $current__timestamp,
               // "previous_ip" =>   $previous_ip
               //  Previous ip is to be assigned 
               "current_ip" => $clientIP

            ]);

            //$resmsg = ["msg" => "connection prompt updated"];
            $resmsg = StoreNetwork::where('store_code', $store_code)->get();

            return response()->json($resmsg, 200);
        } else {
            $store_code = $store_code;
            $network_promt = new StoreNetwork(

                [
                    "store_code" => $store_code,
                    "current_ip" => $clientIP,
                    "previous_ip" =>  $clientIP
                ]
            );

            /**Finally, it saves the newly created network-promt object and returns a JSON response with the newly created product details. */
            $network_promt->save();

            // $resmsg = ["msg" => "connection prompt created"];
            $resmsg = StoreNetwork::where('store_code', $store_code)->get();
            return response()->json($resmsg, 200);
        }
    }
}
