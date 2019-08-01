<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Classe;
use App\DataTraining;
use App\Imports\AnswerImport;
use App\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Phpml\Classification\NaiveBayes;

class AnalysisController extends Controller
{
    public function index(){
        return view('pages.analysis', ['class' => Classe::all(), 'mapel' => Mapel::all()]);
    }

    public function analysis(Request $request) {

        $data = $this->import($request->input('mapel'), $request->input('class'));
        $name = [];
        $difficulty = [];
        $diffStrength = [];

        foreach ($data as $key => $arr){
            $name = array_merge($name, [$arr[1]]);
            $data[$key] = array_slice($arr, 2);
        }

        $score = [];

        foreach ($data as $key => $arr){
            $score[$key] = array_sum($arr);
        }

        arsort($score);
        $rank = array_keys($score);

        $data_t = $this->transpose($data);

        foreach ($data_t as $d) {
            array_push($difficulty, $this->getDifficulty(array_sum($d), count($name)));
            array_push($diffStrength, $this->diffStrength($d, $rank, count($name)));
        }

        $output = [];

        for($i=0; $i<count($difficulty); $i++){
            array_push($output, $this->getDecision($difficulty[$i][1], $diffStrength[$i][1]));
        }

        if(Route::getCurrentRoute()->uri() == "analysis/tes")
            dd($data, $name, $score, $data_t, $difficulty, $diffStrength, $output);
        else {
            Session::put('difficulty', $difficulty);
            Session::put('diffStrength', $diffStrength);
            Session::put('output', $output);
        }
            return redirect('analysis')->with('success', true);

    }

    private function import($m_id, $c_id): array {
        $files = Answer::where('class_id', $c_id)->where('mapel_id', $m_id)->get();
        $data = [];

        foreach ($files as $file){
            $data_im = (new AnswerImport())->toArray(storage_path('app/'.$file->path));
            $data = array_merge($data, array_slice($data_im[0],10));
        }

        return $data;
    }

    private function transpose($arrays):array {

        $data = [];

        foreach ($arrays as $row => $array) {
            foreach ($array as $key => $val) {
                $data[$key][$row] = $val;
            }
        }

        return $data;
    }

    private function getDifficulty($sum_of_true, $n): array {
        $result = [];

        $diff = $sum_of_true/$n;
        array_push($result, sprintf("%0.4f", $diff));

        if($diff >= 0.3000 && $diff <= 0.7000)
            array_push($result, "diterima");
        elseif ($diff >= 0.1000 && $diff <= 0.2900)
            array_push($result, "direvisi");
        elseif ($diff >= 0.7100 && $diff <= 0.9000)
            array_push($result, "direvisi");
        else
            array_push($result, "ditolak");

        return $result;
    }

    private function diffStrength($data, $rank, $n):array {
        $result = [];

        $n = (int) round(27/100 * $n);

        $up = array_slice($rank, 0, $n);
        $down = array_slice($rank, -$n);

        $_up = 0;
        $_down = 0;

        foreach ($up as $u) {
            $_up += $data[$u];
        }

        foreach ($down as $d) {
            $_down += $data[$d];
        }

        $diffStrength = ($_up - $_down) / $n;
        array_push($result, sprintf("%0.4f", $diffStrength));

        if($diffStrength > 0.3000)
            array_push($result, "diterima");
        elseif ($diffStrength < 0.1000)
            array_push($result, "ditolak");
        else
            array_push($result, "direvisi");

        return $result;
    }

    private function getDecision($difficulty, $diffStrength){
        $dTrain = (DB::table('data_trainings')->selectRaw('kesukaran, pembeda, keputusan')->get())->toArray();

        $samples = [];
        $target = [];

        foreach ($dTrain as $arr) {
            array_push($samples, [$arr->kesukaran, $arr->pembeda]);
            array_push($target, $arr->keputusan);
        }

        $classifier = new NaiveBayes();
        $classifier->train($samples, $target);

        return $classifier->predict([$difficulty, $diffStrength]);
    }
}
