<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Classe;
use App\Imports\AnswerImport;
use App\Mapel;
use App\Question;
use Dompdf\FontMetrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Phpml\Classification\NaiveBayes;
use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpWord\Element\TextBreak;
use PhpOffice\PhpWord\IOFactory;

class AnalysisController extends Controller
{
    public function index(){
        return view('pages.analysis', ['class' => Classe::all(), 'mapel' => Mapel::all()]);
    }

    public function analysis(Request $request) {

        if (Route::getCurrentRoute()->uri() == "analysis/export-pdf"){
            $pdf = PDF::loadView('pdf.analysis');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf ->get_canvas();

            $font = new FontMetrics($canvas, $dom_pdf->getOPtions());

            $canvas->page_text($canvas->get_width()/2-35, $canvas->get_height()-35, "Page {PAGE_NUM} of {PAGE_COUNT}", $font->getFont('helvetica', 'normal'), 10, array(0, 0, 0));

            return $pdf->stream('Hasil Analisis.pdf');
        }

        $mc["m"] = (Mapel::where('id', $request->input('mapel'))->first())->name;
        $mc["c"] = (Classe::where('id', $request->input('class'))->first())->class;

        $data = $this->import($request->input('mapel'), $request->input('class'));
        $question = $this->getQuestion($request->input('mapel'), $request->input('class'));
        $name = [];
        $difficulty = [];
        $diffStrength = [];

        foreach ($data as $key => $arr){
            $name = array_merge($name, [$arr[1]]);
            $data[$key] = array_slice($arr, 2);
        }

        $n = count($name);

        $score = [];

        foreach ($data as $key => $arr){
            $score[$key] = array_sum($arr);
        }

        arsort($score);
        $rank = array_keys($score);

        $data_t = $this->transpose($data);
        $pq = [];

        foreach ($data_t as $key => $d) {
            array_push($difficulty, $this->getDifficulty(array_sum($d), $n));
            array_push($diffStrength, $this->diffStrength($d, $rank, $n));

            $p = array_sum($d)/count($d);
            $pq[$key] = $p * (1-$p);
        }

        $output = [];

        for($i=0; $i<count($difficulty); $i++){
            array_push($output, $this->getDecision($difficulty[$i][1], $diffStrength[$i][1]));
        }

        $variant = array_sum(array_map("self::square", $score))/$n - pow(array_sum($score)/$n, 2);

        $r = $n/($n-1) * (1-array_sum($pq)/$variant);


        if(Route::getCurrentRoute()->uri() == "analysis/tes")
            dd($data, $name, $score, $data_t, $difficulty, $diffStrength, $output);
        else {
            Session::put('question', $question);
            Session::put('difficulty', $difficulty);
            Session::put('diffStrength', $diffStrength);
            Session::put('output', $output);
            Session::put('mc', $mc);

            Session::put('reliable', ["n" => $n, "n_question" => count($data_t), "avg" => array_sum($score)/$n, "variant" => $variant, "r" => $r]);
        }


        return redirect('analysis')->with('success', true);
    }

    private function square($num){
        return ($num*$num);
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

    private function getQuestion($m_id, $c_id){
        $files = (Question::where('class_id', $c_id)->where('mapel_id', $m_id))->first();

        $filePath = storage_path('app/'.$files->path);

        $phpWord = IOFactory::createReader('Word2007')->load($filePath);

        if(method_exists($phpWord, 'getSections')) {
            foreach ($phpWord->getSections() as $section) {

                $body = '';
                if (method_exists($section, 'getElements')) {
                    foreach ($section->getElements() as $e) {
                        if (method_exists($e, 'getElements')) {
                            foreach ($e->getElements() as $element) {
                                if (method_exists($element, 'getText')) {
                                    if (method_exists($element, 'getFontStyle')) {
                                        $font = $element->getFontStyle();
                                        $bold = $font->isBold() ? 'font-weight:bold;' : '';
                                        $fontFamily = $font->getName();

                                        $body .= '<span  style="font-family:' . $fontFamily . ';' . $bold . '">';
                                        $body .= $element->getText() . '</span>';
                                    }
                                }
                            }
                        }

                        if (class_exists(TextBreak::class)) {
                            $body .= '<br/>';
                        }

                    }
                }

                return $body;
            }
        }

        return '';
    }
}
