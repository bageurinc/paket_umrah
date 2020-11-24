<?php

namespace Bageur\PaketUmrah\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\PaketUmrah\Processors\AvatarProcessor;

class hotel extends Model
{
    protected $table = 'bgr_umrah_hotel';
    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        return AvatarProcessor::get($this->nama_hotel,$this->gambar,$this->gambar_path);
    }   
    public function scopeDatatable($query,$request,$page=7)
    {
          $search       = ["nama_hotel"];
          $searchqry    = '';

        $searchqry = "(";
        foreach ($search as $key => $value) {
            if($key == 0){
                $searchqry .= "lower($value) like '%".strtolower($request->search)."%'";
            }else{
                $searchqry .= "OR lower($value) like '%".strtolower($request->search)."%'";
            }
        } 
        $searchqry .= ")";
        if(@$request->sort_by){
            if(@$request->sort_by != null){
            	$explode = explode('.', $request->sort_by);
                 $query->orderBy($explode[0],$explode[1]);
            }else{
                  $query->orderBy('created_at','desc');
            }

             $query->whereRaw($searchqry);
        }else{
             $query->whereRaw($searchqry);
        }
        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }
}
