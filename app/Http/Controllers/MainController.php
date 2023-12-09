<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\global_model;

class MainController extends Controller
{
    public function index(){
        return view('quiz');
    }

    public function getDataQuestion(){
        $query = DB::select("SELECT * from questions");

        foreach($query as $val){
            $array[] = array(
                'question' => $val->QNS,
                'options' => [$val->A, $val->B, $val->C, $val->D, $val->E],
                'correct' => $val->CHOICE
            );
        }

        return response()->json($array);

    }

    public function dashboard(){
        $getDataQeustion = global_model::getDataQns();
        return view('admin/dashboard', compact('getDataQeustion'));
    }

    public function insDataSoal(Request $request){
        if($request->jawaban_benar == 'A'){
            $choice = '0';
        }elseif($request->jawaban_benar == 'B'){
            $choice = '1';
        }elseif($request->jawaban_benar == 'C'){
            $choice = '2';
        }elseif($request->jawaban_benar == 'D'){
            $choice = '3';
        }else{
            $choice = '4';
        }
        
        $params = [
            'soal'      => $request->question,
            'ans_a'     => $request->ans_a, 
            'ans_b'     => $request->ans_b,
            'ans_c'     => $request->ans_c,
            'ans_d'     => $request->ans_d,
            'ans_e'     => $request->ans_e,
            'chs'       => $choice,
            'real_chs'  => $request->jawaban_benar
        ];

        $insData = global_model::InsertDataQuestion($params);

        if($insData > 0){
            return redirect()->route('dashboard');
        }

    }

    public function getEditQns($idData){
        $getDataQnsEdit = global_model::getDataQns($idData);
        return $getDataQnsEdit;
    }

    public function edtDataSoal(Request $request){

        if($request->Edt_jawaban_benar == 'A'){
            $choice = '0';
        }elseif($request->Edt_jawaban_benar == 'B'){
            $choice = '1';
        }elseif($request->Edt_jawaban_benar == 'C'){
            $choice = '2';
        }elseif($request->Edt_jawaban_benar == 'D'){
            $choice = '3';
        }else{
            $choice = '4';
        }

        $params = [
            'Edtsoal'      => $request->Edt_qns,
            'Edtans_a'     => $request->Edt_ans_a, 
            'Edtans_b'     => $request->Edt_ans_b,
            'Edtans_c'     => $request->Edt_ans_c,
            'Edtans_d'     => $request->Edt_ans_d,
            'Edtans_e'     => $request->Edt_ans_e,
            'Edtchs'       => $choice,
            'Edtreal_chs'  => $request->Edt_jawaban_benar,
            'Edtid_data'   => $request->id_data
        ];

        $edtSoal = global_model::editDtSoal($params);

        if($edtSoal > 0){
            return redirect()->route('dashboard');
        }
    }

    public function deleteDataSoal($idData){
        $dltDataQns = global_model::deleteData($idData);
        return $dltDataQns;
    }
}
