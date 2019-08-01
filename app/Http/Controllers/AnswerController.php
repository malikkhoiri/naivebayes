<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Classe;
use App\Mapel;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AnswerController extends Controller
{
    public function index()
    {
        return view('pages.answer', ['member' => Member::all(), 'class' => Classe::all(), 'mapel' => Mapel::all(), 'answer' => Answer::all()]);
    }

    public function upload(Request $request)
    {

        try {
            $this->validate($request, [
                'answer' => 'required|file|mimes:xls,xlsx'
            ]);
        } catch (ValidationException $e) {
            $e->getMessage();
        }

        $mapel = Mapel::find($request->input('mapel'));
        $class = Classe::find($request->input('class'));
        $member = Member::find($request->input('member'));

        $file = $request->file('answer');
        $filename = "Jawaban_".$mapel->name."_".$class->class."_".$member->member.".".$file->getClientOriginalExtension();
        $path = $file->storeAs('public/answers/'.$mapel->name.'/'.$class->class, $filename);

        if(File::exists(storage_path('app/'.$path))){
            DB::table('answers')->updateOrInsert([
                'mapel_id' => $request->input('mapel'),
                'class_id' => $request->input('class'),
                'member_id' => $request->input('member')
            ], [
                'filename' => $filename,
                'size' => Storage::size($path),
                'type' => pathinfo($path, PATHINFO_EXTENSION),
                'path' => $path
            ]);
        }

        return redirect('/answer');
    }

    public function download($id){
        $answer = Answer::find($id);
        return Storage::download($answer->path, $answer->filename);
    }

    public function destroy($id){
        $answer = Answer::find($id);

        if(Storage::delete($answer->path))
            $answer->delete();

        return redirect('/answer');
    }
}
