<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $books = book::all();

            if ($books->count() > 0){
                return response()->json([
                    'status' => 'success',
                    'message' => 'successful',
                    'data'=>$books
                ]);
            } else {
                return response()->json([
                    'message' =>'no stored Book at the moment'
                ]);
            }

        } catch (\Exception $e){
            return response()->json([
                'errors' => 'an exceptional error occured'
            ]);
        } catch (\Error $e){
            return response()->json([
                'errors' => 'an error occured'
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'isbn' => ['required', 'max:255', 'string'],
            'name' => ['required', 'min:2', 'string'],
            'authors' => ['required', 'max:255', 'string'],
            'number_of_pages' => ['required','integer'],
            'publisher' => ['required','min:5', 'max:255', 'string'],
            'country' => ['required','min:5', 'max:255', 'string'],
            'release_date' => ['required','min:5', 'max:255', 'string']
        ]);


        #if there is an error
        if($validator->fails()) {
            return response()->json([
                'errors'=> $validator->errors(),
            ],401);
        };

        #create
        try {
            $books = book::create($validator->validated());

            if ($books){
                return response()->json([
                    'status' => 'success',
                    'message' => 'record saved successfully',
                    'data' =>$books
                ]);
            } else {
                return response()->json([
                    'error' =>'something went wrong record could not be saved '

                ],500);
            }

            }catch (Exception $e) {
                return response()->json([
                    'errors' => $e->getMessage()
                ], 500);
          } catch (Error $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $books = book::find($id);

            if($books != 'null'){
                return response()->json([
                    'status' =>'success',
                    'message' => 'successful',
                    'data' => $books
                ]);
            } else{
                return response()->json([
                    'message' => 'Subcategory does not exits'
                ]);
            }

        } catch(\Exception $e){
            return response()->json([
                'errors' => 'an exceptional error has occured'
            ],500);
        } catch(\Error $e){
            return response()->json([
                'errors' => 'an exceptional error has occured'
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'isbn' => ['required', 'max:255', 'string'],
            'name' => ['required', 'min:2', 'string'],
            'authors' => ['required', 'max:255', 'string'],
            'number_of_pages' => ['required','integer'],
            'publisher' => ['required','min:5', 'max:255', 'string'],
            'country' => ['required','min:5', 'max:255', 'string'],
            'release_date' => ['required','min:5', 'max:255', 'string']
        ]);


        #if there is an error
        if($validator->fails()) {
            return response()->json([
                'errors'=> $validator->errors(),
            ],401);
        };

        try {
            $update_book = book::find($id);
            if($update_book != null){
                 if($update_book->update($validator->validated())){
                     return response()->json([
                         'status' => 'success',
                         'message' => 'subcategory Successfully saved',
                         'data' =>$update_book
                     ]);
                 }
             } else{

                 return response()->json([
                     'status' => 'success',
                     'message' => 'subcategory not found',
          
                 ]);
                 
             }

         }catch (Exception $e) {
             return response()->json([
                 'errors' => $e->getMessage()
             ], 500);
       } catch (Error $e) {
         return response()->json([
             'errors' => $e->getMessage()
         ], 500);
     }
       
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            if (book::destroy($id)){
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Book Deleted successfully'
                ]);
            }  else {
                return response()->json([
                    'errors' => 'Book could not be deleted'
                ], 401);
            }
        } catch(\Exception $e){
            return response()->json([
                'errors' => 'an exceptional error has occured'
            ],500);
        } catch(\Error $e){
            return response()->json([
                'errors' => 'an exceptional error has occured'
            ],500);
        }
        
    }
}
