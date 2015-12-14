<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Schema;
use DB;

class API extends Controller
{
    /**
     * Indique quel methode utiliser selon ce qui est indiqué dans l'URL
     * INPUT : methode & matiere
     * OUTPUT : JSON
     */
    public function index($meth, $mat)
    {
        switch ($meth) {
            case 'show':
                $json = $this->show($mat);
                break;
            case 'var':
                $json = $this->variation($mat);
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
        if ($date == false)
            return false;
        $interval = date_diff($date_first, $date);
        $date_id = $interval->m + ($interval->y * 12);
        return $date_id;
    }

    public function get_mat_info($mat)
    {
        if (isset($_GET["lang"])) {
            if ($_GET["lang"] == "fr")
                $sql = "SELECT name_fr, unite_fr, source_fr";
            elseif ($_GET["lang"] == "en")
                $sql = "SELECT name_en, unite_en, source_en";
            else
                $sql = "SELECT name_fr, name_en, unite_fr, unite_en, source_fr, source_en";
        }
        else
            $sql = "SELECT name_fr, name_en, unite_fr, unite_en, source_fr, source_en";
        if (strlen($mat) == 12)
            $sql .= " FROM `api_customs_liste` WHERE nc8txt = '" . $mat . "'";
        else
            $sql .= " FROM `api_imf_liste` WHERE code_imf = '" . $mat . "'";
        $info = $this->store($sql);
        if (isset($info[0]))
            return $info[0];
        else
            return (NULL);
    }

    public function get_sql_res($mat, $req)
    {
        if (strlen($mat) == 12)
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
                WHERE c.nc8txt = '" . $mat . "'";
            if (isset($_GET["flux"])) {
                if ($_GET["flux"] == "i")
                    $sql .= " AND data.flux = 1";
                elseif ($_GET["flux"] == "e")
                    $sql .= " AND data.flux = 0";
            }
            if (isset($_GET["country"]))
                $sql .= " AND pays.code_pays ='" . $_GET["country"] . "'";
        }
        else {
            $sql = "SELECT (CASE WHEN c.currency = 'USD / EUR' THEN a.valeur/b.valeur WHEN c.currency = 'EUR / EUR' THEN a.valeur END) * c.factor as prix, d.mois, d.annee 
                FROM api_imf_data a LEFT JOIN api_imf_liste c ON a.code_imf = c.code_imf 
                INNER JOIN (SELECT valeur,id_date FROM api_imf_data WHERE code_imf='EURUSD' GROUP BY id_date) as b ON a.id_date = b.id_date 
                INNER JOIN api_dates d ON a.id_date = d.id WHERE a.code_imf = '" . $mat . "'";
        }
        if (isset($_GET["start"]) && $req == "show") {
            $start_id = $this->get_date_id($_GET["start"]);
            if ($start_id != false)
                $sql .= " AND d.id > " . $start_id;
        }
        if (isset($_GET["end"]) && $req == "show") {
            $end_id = $this->get_date_id($_GET["end"]);
            if ($end_id != false)
                $sql .= " AND d.id <= " . ++$end_id;
        }
        if (!isset($_GET["flux"]) && strlen($mat) == 12)
            $sql .= " ORDER BY data.flux, d.id";
        else
            $sql .= " ORDER BY d.id";
        if ($req == "variation") {
            if (isset($_GET["inter"])) {
                if ($_GET["inter"] == "t")
                    $sql .= " DESC LIMIT 6";
                elseif ($_GET["inter"] == "s")
                    $sql .= " DESC LIMIT 12";
                else
                    $sql .= " DESC LIMIT 2";
            }
            else
                $sql .= " DESC LIMIT 2";
        }
        $res = $this->store($sql);
        return $res;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($mat)
    {
        $info = $this->get_mat_info($mat);
        $res = $this->get_sql_res($mat, "show");
        $res_c = count($res);
        for ($i = 1; $i < $res_c; $i++) {
            $diff = ($res[$i]->prix - $res[$i - 1]->prix) / $res[$i - 1]->prix * 100;
            $res[$i]->diff = round($diff, 1);
        }
        if ($res_c != 0)
            return response()->json(["http_response" => "200", "search" => $mat,
                "count" => $res_c, "info" => $info, "results" => $res]);
        else
            return response()->json(["http_response" => "200", "search" => $mat, "count" => $res_c, "results" => []]);
    }

    public function variation($mat)
    {
        $info = $this->get_mat_info($mat);
        $res = $this->get_sql_res($mat, "variation");
        $res_c = count($res);
        if ($res_c == 2) {
            $avg1 = $res[0]->prix;
            $avg2 = $res[1]->prix;
        }
        elseif ($res_c == 6) {
            $avg1 = ($res[0]->prix + $res[1]->prix + $res[2]->prix) / 3;
            $avg2 = ($res[3]->prix + $res[4]->prix + $res[5]->prix) / 3;
        }
        elseif ($res_c == 12) {
            $avg1 = ($res[0]->prix + $res[1]->prix + $res[2]->prix + $res[3]->prix + $res[4]->prix + $res[5]->prix) / 6;
            $avg2 = ($res[6]->prix + $res[7]->prix + $res[8]->prix + $res[9]->prix + $res[10]->prix + $res[11]->prix) / 6;
        }
        $variation = ($avg1 - $avg2) / $avg2 * 100;
        if ($res_c != 0)
            return response()->json(["http_response" => "200", "search" => $mat, "info" => $info,
                "previous price" => round($avg2, 2), "current price" => round($avg1, 2),"variation" => round($variation, 1)]);
        else
            return response()->json(["http_response" => "200", "search" => $mat, "results" => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        return DB::select(
                    DB::raw($request)
                );
    }
}