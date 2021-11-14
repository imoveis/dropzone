<?php

namespace App\Http\Controllers;

use App\mdlImagem;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::find($id);
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // pega as imagens conforme vem o id do imovel
        $imagens = \App\mdlImagem::where('IMB_IMV_ID', $id)->get();
        // verifica a quantidade de imagens no banco de dados
        if (count($imagens) > 0) {
            // faz o laço com as imagens existentes
            foreach ($imagens as $imagem) {
                // comparação
                if (!in_array($imagem->IMB_IMG_ID, $request->input('imagens', []))) {
    
                    \App\mdlImagem::where('IMB_IMG_ID', $imagem->IMB_IMG_ID)->delete();

                    $pasta='/images/imoveis';
                    
                    $pastaThumb='/images/imoveis/thumb';        
                    
                    Storage::disk('public')->delete(  $pasta.'/'. $id.'/'.$imagem->IMB_IMG_ARQUIVO );
                    Storage::disk('public')->delete(  $pastaThumb.'/'.$id.'/800_600_'.$imagem->IMB_IMG_ARQUIVO);
                    Storage::disk('public')->delete(  $pastaThumb.'/'.$id.'/100_75'.$imagem->IMB_IMG_ARQUIVO );
                    Storage::disk('public')->delete(  $pastaThumb.'/'.$id.'/60_45_'.$imagem->IMB_IMG_ARQUIVO );
                    $delete = 'imagem: '.$pastaThumb.'/'.$id.'/180_135_'.$imagem->IMB_IMG_ID;            

                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
