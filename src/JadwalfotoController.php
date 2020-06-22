<?php
namespace Bageur\PaketUmrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Bageur\PaketUmrah\model\jadwalgalery;
use Bageur\PaketUmrah\Processors\UploadProcessor;
use Validator;
class JadwalfotoController extends Controller
{

    public function index(Request $request)
    {
       $query = jadwalgalery::with(['foto'])->whereNull('sub_id')->datatable($request);
       // $query->each(function ($q) {
       //      $q->foto->append('img');
       // });
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'jadwal'		     => 'required',
                        'nama'           => 'required|unique:bgr_umrah_galeri|min:3',
                        'gambar.*'       => 'required|mimes:jpg,jpeg,png|max:2000',
                        
                    ];
        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $paket              			= new jadwalgalery;
            $paket->umrah_jadwal_id	  = $request->jadwal;
            $paket->nama              = $request->nama;
            $paket->save();

           $gambar = $request->file('gambar');
           for ($i=0; $i < count($gambar); $i++) { 
              $upload                   = UploadProcessor::go($gambar[$i],'umrah');
              $paketfoto                = new jadwalgalery;
              $paketfoto->sub_id        = $paket->id;
              $paketfoto->gambar        = $upload;
              $paketfoto->save();
            }
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return paket::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules      = [
                        'nama'                  => 'required|unique:bgr_umrah_paket,nama,'.$id.',id|min:2',
                        'tipe_paket'            => 'required',
                      ];

      if($request->file('gambar') != null){
            $rules['gambar'] = 'mimes:jpg,jpeg,png|max:1000';
        }              
        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $paket                          = paket::findOrFail($id);
            $paket->nama                    = $request->nama;
            $paket->nama_seo                = Str::slug($request->nama);
            $paket->tipe_paket              = $request->tipe_paket;
            if($request->file('gambar') != null){
                $upload                     = UploadProcessor::go($request->file('gambar'),'umrah');
                $paket->gambar            = $upload;
            }
            $paket->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $delete = paket::findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}