<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()

    {
        $this->middleware('auth:api')->except('index'); //function ini untuk memasukan toke ke dalam controller
    }
        
    public function index()
    {
        $subcategories =  Subcategory::all();
        
        return response()->json([
         'data' => $subcategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,webp'
        ]);
        if($validator->fails()) {
            return response()->json(
                $validator->errors(),
                400
            );
        }

        $input = $request->all();

        if($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads',$nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

      $Subcategory = Subcategory::create($input);
        
        return response()->json([
            'data' => $Subcategory
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $category)
    {

        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',

        ]);
        if($validator->fails()) {
            return response()->json(
                $validator->errors(),
                400
            );
        }

        $input = $request->all();

        if($request->has('gambar')) {
            File::delete('uploads/' . $category->gambar);

            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads',$nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }
        

        $category->update($input);
        return response()->json([
            'message' => 'succes',
            'data' => $category
        ]);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $category)
    {
        // dd($category);

        // Subcategory::delete($category);

        File::delete('uploads/'. $category->gambar);
        $category->delete();

        return response()->json([
            'message' => 'succes'
        ]);
    }
}
