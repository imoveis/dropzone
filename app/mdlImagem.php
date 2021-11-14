<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mdlImagem extends Model
{

    protected $table = 'imb_imagem';
    public $timestamps = false;
    /*protected $primaryKey = null;
    public $incrementing = false;*/



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IMB_IMB_ID',
        'IMB_IMV_ID',
        'IMB_IMG_ID',
        'IMB_IMG_PRINCIPAL',
        'IMB_IMG_NOME',
        'IMB_IMV_DESCRICAO',
        'IMB_IMG_CAPA',
        'IMB_IMG_LANCAMENTO',
        'IMB_IMV_FINALIDADE',
        'IMB_IMG_NAOIRPROSITE',
        'IMB_IMG_SEQUENCIA',
        'IMB_IMG_ARQUIVO',
        'IMB_IMG_IMAGEM',
        'Imb_img_dthativo',
        'Imb_atd_id',
        'IMB_IMG_IMAGEMDESCOMP',
        'Idantigo'
    ];   
}