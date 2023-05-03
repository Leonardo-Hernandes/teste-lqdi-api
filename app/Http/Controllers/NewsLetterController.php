<?php

namespace App\Http\Controllers;

use App\Models\NewsLetter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsLetterController extends Controller
{
    public function getAll()
    {
        $newsLetters = NewsLetter::all();
        
        return response()->json($newsLetters, 200);
    }
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', 'max:15'],
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required'],
        ]);

        try {
            $response = NewsLetter::create($data);

            return response(
                array(
                    'message' => 'Created',
                    'data' => $response
                ), 201);
        } catch (\Exception $e) {
            return response('Email arleady registered', 400);
        }
    }

    public function delete($id = null)
    {
        if ($id == null)
            return response("Id cannot be null", 400);

        try {
            NewsLetter::where('id', $id)->firstOrFail();

            NewsLetter::where('id', $id)->delete();

            return response(`NewsLetter Deleted`, 200);
        } catch (\Exception $e) {
            return response("NewsLetter not found", 404);
        }

    }
}