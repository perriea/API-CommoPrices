<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Schema;
use DB;
use Session;

class API extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($meth, $mat)
    {
        switch ($meth) {
            case 'show':
                $json = $this->show($mat);
                break;
            
            default:
                $json = response()->json(["count" => "0", "error" => "404", "results" => []]);
                break;
        }
        return ($json);
    }

    public function get_date_id($date)
    {
        $date = date_create_from_format('n-Y|', $date);
        $date_first =  date_create("2012-01-01");
        $interval = date_diff($date_first, $date);
        $date_id = $interval->m + ($interval->y * 12);
        return $date_id;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($materiau)
    {
        if (strlen($materiau) == 12) 
        {
            $sql =  "SELECT prix, volume, d.mois ,d.annee";
            if (!isset($_GET["flux"]))
                $sql .= " , data.flux";
            if (isset($_GET["country"])) {
                $sql .= " FROM api_customs_data_pays data 
                    INNER JOIN api_customs_pays pays ON data.id_code_pays = pays.id
                    INNER JOIN api_customs_niv niv ON niv.id_code_nc8 = data.id_code_nc8
                    AND niv.flux = data.flux AND niv.id_code_pays = data.id_code_pays ";
            }
            else
                $sql .= " FROM api_customs_data_global data";
            $sql .= " INNER JOIN api_customs_nc8 n ON data.id_code_nc8 = n.id
                INNER JOIN api_dates d ON data.id_date = d.id
                INNER JOIN api_customs_liste c ON n.code_nc8 = c.nc8
                WHERE c.nc8txt = '" . $materiau . "'";
            if (isset($_GET["flux"]))
                $sql .= " AND data.flux = " . $_GET["flux"];
            if (isset($_GET["country"]))
                $sql .= " AND pays.code_pays ='" . $_GET["country"] . "'";
        }
        else {
            $sql = "SELECT (CASE WHEN c.currency = 'USD / EUR' THEN a.valeur/b.valeur WHEN c.currency = 'EUR / EUR' THEN a.valeur END) * c.factor as prix, d.mois, d.annee 
                FROM api_imf_data a LEFT JOIN api_imf_liste c ON a.code_imf = c.code_imf 
                INNER JOIN (SELECT valeur,id_date FROM api_imf_data WHERE code_imf='EURUSD' GROUP BY id_date) as b ON a.id_date = b.id_date 
                INNER JOIN api_dates d ON a.id_date = d.id WHERE a.code_imf = '".$materiau."'";
        }
        if (isset($_GET["start"])) {
            $start_id = $this->get_date_id($_GET["start"]);
            $sql .= " AND d.id > " . $start_id;
        }
        if (isset($_GET["end"])) {
            $end_id = $this->get_date_id($_GET["end"]);
            $sql .= " AND d.id <= " . ++$end_id;
        }
        $res = $this->store($sql." ORDER BY d.id");
        $res_c = count($res);
        for ($i=1; $i < $res_c; $i++) {
            $diff = ($res[$i]->prix - $res[$i - 1]->prix) / $res[$i - 1]->prix * 100;
            $res[$i]->diff = round($diff, 1);
        }
        if ($res_c != 0)
            return response()->json(["count" => $res_c, "error" => "200", "search" => $materiau, "results" => $res]);
        else
            return response()->json(["count" => $res_c, "error" => "200", "search" => $materiau, "results" => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    **/
    public function store($request)
    {
        return DB::select(DB::raw($request));
    }
}
