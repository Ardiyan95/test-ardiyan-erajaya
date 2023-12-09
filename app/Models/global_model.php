<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class global_model extends Model
{
    use HasFactory;

    public static function getDataQns($where = false){
        if($where){
            $query = DB::select("SELECT * from questions where 1=1 and ID_DATA = :id", ["id" => $where]);
        }else{
            $query = DB::select("SELECT * from questions");
        }
        return $query;
    }

    public static function InsertDataQuestion($params){
        
        $queryIns = DB::insert("INSERT INTO questions (QNS, A, B, C, D, E, CHOICE, REAL_CHOICE) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $params['soal']
                , $params['ans_a']
                , $params['ans_b']
                , $params['ans_c']
                , $params['ans_d']
                , $params['ans_e']
                , $params['chs']
                , $params['real_chs']
            ]
        );

        return $queryIns;
    }

    public static function editDtSoal($params){
        $queryUpdSoal = DB::update("UPDATE questions SET QNS = ?, A = ?, B = ?, C = ?, D = ?, E = ?, CHOICE = ?, REAL_CHOICE = ? WHERE ID_DATA = ?",
            [
                $params['Edtsoal']
                , $params['Edtans_a']
                , $params['Edtans_b']
                , $params['Edtans_c']
                , $params['Edtans_d']
                , $params['Edtans_e']
                , $params['Edtchs']
                , $params['Edtreal_chs']
                , $params['Edtid_data']
            ]
        );

        return $queryUpdSoal;
    }

    public static function deleteData($idData){
        
        $queryDeleteDt = DB::select("DELETE FROM questions WHERE 1=1 and ID_DATA = :id_data", ["id_data" => $idData]);
        return $queryDeleteDt;
    }
}
