<?php

namespace App\Http\Controllers;

use App\mdlImagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        foreach ($request->file('file') as $key => $value) {
            $images=$value;
            if($request->hasfile('file'))
            {
        
            $seq = mdlImagem::where('IMB_IMV_ID','=', $request->id )
            ->max( 'IMB_IMG_SEQUENCIA');
            $seq = $seq + 2;


            $images=$value;

    
            // Get file extension
            $extension = $value->getClientOriginalExtension();
    
            // Valid extensions
            $validextensions = array("jpeg","jpg","png","pdf");
    
            // Check extension
            if(in_array(strtolower($extension), $validextensions))
            {
    
                // Rename file 
                //$fileName = $request->file('file')->getClientOriginalName().time() .'.' . $extension;
                // Uploading file to given path
                $file_name=$seq.'-'.time().'.'.$images->getClientOriginalExtension();
                Log::info('Nome do arquivo '.$file_name);
                
                $pasta='/images/'.$request->input('imbmaster').'/imoveis/'.$request->input('id');
                $pastaThumb='/images/'.$request->input('imbmaster').'/imoveis/'.'thumb/'.$request->input('id');
                Storage::disk('public')->makeDirectory( $pasta);
                Storage::disk('public')->makeDirectory( $pastaThumb);
                $photo = Image::make( $images )
                                    ->resize(1080, null, function ($constraint) { $constraint->aspectRatio(); } )
                                    ->encode('jpg',80);
                Storage::disk('public')->put( $pasta.'/'.$file_name, $photo);
                                    
                
                $photo = Image::make( $images )
                                    ->resize(100, null, function ($constraint) { $constraint->aspectRatio(); } )
                                    ->encode('jpg',80);
                Storage::disk('public')->put( $pastaThumb.'/100_75'.$file_name, $photo);
                
                $maxValue = DB::table( 'IMB_IMAGEM')
                                    ->where( 'IMB_IMV_ID','=',  $request->input('id'))
                                    ->max('IMB_IMG_SEQUENCIA');
                                    
                $t = new mdlImagem();
                $t->IMB_IMB_ID          = $request->input('imbmaster');
                $t->IMB_IMV_ID          = $request->input('id');
                $t->IMB_IMG_SEQUENCIA   = $seq;
                $t->IMB_IMG_ARQUIVO     = $file_name;
                $t->imb_img_dthativo    = date('Y/m/d');
                $t->IMB_ATD_ID          = 1; //Auth::user()->IMB_IMB_ID;
                $t->save();
                //return response()->json(['success' => 'Arquivo Gravado'], 200);                
                $data[] = $t;
            }
    
            }

        }
        return response()->json(['name'=> $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mdlImagem  $media
     * @return \Illuminate\Http\Response
     */
    public function show(mdlImagem $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mdlImagem  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(mdlImagem $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mdlImagem  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mdlImagem $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mdlImagem  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(mdlImagem $media)
    {
        //
    }
}
