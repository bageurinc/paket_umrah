<?php

namespace Bageur\PaketUmrah\Model;

use Illuminate\Database\Eloquent\Model;

class jadwalgalery extends Model
{
    protected $table    = 'bgr_umrah_galeri';
    protected $appends  = ['img'];
    protected $hidden   = ['gambar','sub_id'];

    public function getImgAttribute()
    {   
        if($this->gambar != null){
           return url('umrah/'.$this->gambar);
        }
    }   
    public function scopeDatatable($query,$request,$page=12)
    {
          $search       = ["nama"];
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

    public function foto()
    {
      return $this->hasMany('Bageur\PaketUmrah\model\jadwalgalery','sub_id')->select('sub_id','gambar');
    }
}
