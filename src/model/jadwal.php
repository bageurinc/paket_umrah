<?php

namespace Bageur\PaketUmrah\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Bageur\PaketUmrah\Processors\AvatarProcessor;
use Bageur\PaketUmrah\Processors\TglProcessor;

class jadwal extends Model
{
    protected $table   = 'bgr_umrah_jadwal';
    protected $appends = ['itinerary','data_component','data_include','data_exclude','idr_double','idr_triple','idr_quad','avatar','indo_keberangkatan','indo_kepulangan'];
    protected $hidden = ['gambar_itinerary','component','include','cover','created_at','updated_at'];

    public function getAvatarAttribute()
    {
            return AvatarProcessor::get($this->nama_jadwal,@$this->cover);
    }   
    public function getItineraryAttribute()
    {
            if(@$this->gambar_itinerary != null){
                return url('storage/umrah/'.@$this->gambar_itinerary);
            }
    }   
    public function getDataComponentAttribute()
    {
            return json_decode($this->component);
    }        
    public function getDataIncludeAttribute()
    {
            // return json_decode($this->include);
        $data = [];
        foreach (json_decode($this->include,true) as $key) {
            $data[] = ['content' => $key];
        }
        return $data;
    }
    public function getDataExcludeAttribute()
    {
        $data = [];
        foreach (json_decode($this->exclude,true) as $key) {
            $data[] = ['content' => $key];
        }
        return $data;
    }      
    public function getIdrDoubleAttribute()
    {
            $cur = number_format($this->double, 0, '.', '.');
            return $cur;
    }     
    public function getIndoKeberangkatanAttribute()
    {
            $cur = TglProcessor::get($this->keberangkatan);
            return $cur;
    }    
    public function getIndoKepulanganAttribute()
    {
            $cur = TglProcessor::get($this->kepulangan);
            return $cur;
    }    
    public function getIdrTripleAttribute()
    {
            $cur = number_format($this->triple, 0, '.', '.');
            return $cur;
    }    
    public function getIdrQuadAttribute()
    {
            $cur = number_format($this->quad, 0, '.', '.');
            return $cur;
    }   
    public function scopeDatatable($query,$request,$page=12)
    {
        $search       = ["nama_jadwal"];
        $searchqry    = '';

        if(!empty($request->t)){
            $query->where('keberangkatan',$request->t);
        }

        if(!empty($request->p)){
            $query->where('umrah_paket_id',$request->p);
        }

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
    public function paket()
    {
      return $this->hasOne('Bageur\PaketUmrah\model\paket','id','umrah_paket_id');
    }
    public function gallery()
    {
      return $this->hasMany('Bageur\PaketUmrah\model\jadwalgalery','umrah_jadwal_id')->with('foto');
    }
}
