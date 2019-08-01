<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Mapel;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    public function index()
    {
        return view('pages.question', ['class' => Classe::all(), 'mapel' => Mapel::all(), 'question' => Question::all()]);
    }

    public function upload(Request $request)
    {

        try {
            $this->validate($request, [
                'question' => 'required|file|mimes:doc,docx'
            ]);
        } catch (ValidationException $e) {
            $e->getMessage();
        }

        $mapel = Mapel::find($request->input('mapel'));
        $class = Classe::find($request->input('class'));

        $file = $request->file('question');
        $filename = "Soal_".$mapel->name."_".$class->class.".".$file->getClientOriginalExtension();
        $path = $file->storeAs('public/questions/'.$mapel->name, $filename);

        if(File::exists(storage_path('app/'.$path))){
            DB::table('questions')->updateOrInsert([
                'mapel_id' => $request->input('mapel'),
                'class_id' => $request->input('class')
            ], [
                'filename' => $filename,
                'size' => Storage::size($path),
                'type' => pathinfo($path, PATHINFO_EXTENSION),
                'path' => $path
            ]);
        }

        return redirect('/question');
    }

    public function download($id){
        $question = Question::find($id);
        return Storage::download($question->path, $question->filename);
    }

    public function destroy($id){
        $question = Question::find($id);

        if(Storage::delete($question->path))
            $question->delete();

        return redirect('/question');
    }
}
