<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class iceandcube extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $response = Http::get('https://anapioficeandfire.com/api/characters/583');

        try {
            $response = Http::get('https://anapioficeandfire.com/api/books');
        
            if ($response->successful()) {
                $data = $response->json();
        
                return response()->json([
                    'status' => 'success',
                    'message' => 'successful',
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    'message' => 'an error occurred',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'an exceptional error occurred',
            ]);
        } catch (Error $e) {
            return response()->json([
                'errors' => 'an error occurred',
            ]);
        }
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        
    try {
        $response = Http::get('https://anapioficeandfire.com/api/books/'.$id);

        if ($response->successful()) {
            $book = $response->json();

            // Check if the book title matches "Game of Thrones"
            if ($book['name'] == 'A Game of Thrones') {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Book found',
                    'data' => $book,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Book not found',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
            ]);
        }
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'An exceptional error occurred',
        ]);
    } catch (Error $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred',
        ]);
    }
}

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
