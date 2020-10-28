<?php
namespace Bageur\PaketUmrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Bageur\PaketUmrah\model\jadwal;
use Bageur\PaketUmrah\Processors\UploadProcessor;
use Bageur\PaketUmrah\Processors\TglProcessor;
use Validator;
class JadwalController extends Controller
{

    public function index(Request $request)
    {
       $query = jadwal::datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'paket_id'		     		=> 'required',
                        'nama_jadwal'               => 'required|unique:bgr_umrah_jadwal|min:3',
                        'mata_uang'                 => 'required',
                        'keberangkatan'             => 'required|date',
                        'kepulangan'                => 'required|date',
                        'double'                    => 'required|numeric',
                        'triple'                    => 'required|numeric',
                        'makkah'                    => 'required',
                        'madinah'                   => 'required',
                        'transportasi'              => 'required',
                        'jeddah'                    => 'required',
                        'departure'                 => 'required',
                        'arrival'                   => 'required',
                    ];
        if($request->file('gambar') != null){
            $rules['gambar'] = 'mimes:jpg,jpeg,png,svg|max:1000';
        }              
        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{


            $component['makkah']             = $request->makkah;
            $component['madinah']            = $request->madinah;
            $component['transportasi']       = $request->transportasi;
            $component['jeddah']             = $request->jeddah;
            $component['departure']          = $request->departure;
            $component['arrival']            = $request->arrival;

            $paket                           = new jadwal;
            $paket->umrah_paket_id           = $request->paket_id;
            $paket->nama_jadwal              = $request->nama_jadwal;
            $paket->mata_uang               = $request->mata_uang;
            $paket->nama_jadwal_seo          = Str::slug($request->nama_jadwal);
            $paket->keberangkatan            = $request->keberangkatan;
            $paket->kepulangan               = $request->kepulangan;
            $paket->durasi                   = TglProcessor::countday($request->keberangkatan,$request->kepulangan);
            $paket->component                = json_encode($component);
            $paket->double                   = $request->double;
            $paket->triple                   = $request->triple;
            $paket->quad                     = $request->quad;
            $paket->include                  = json_encode($request->include);

            if($request->file('gambar') != null){
                $upload                     = UploadProcessor::go($request->file('gambar'),'umrah');
                $paket->gambar_itinerary    = $upload;
            }

            $paket->save();
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
        $jadwal =  jadwal::with(['paket','gallery'])->findOrFail($id);
        foreach($jadwal->data_component as $key => $value) {
            $jadwal->{$key} = $value;
        }
        unset($jadwal->data_component);
        return $jadwal;
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
                        'paket_id'                  => 'required',
                        'nama_jadwal'               => 'required|unique:bgr_umrah_jadwal,nama_jadwal,'.$id.',id|min:3',
                        'mata_uang'                 => 'required',
                        'keberangkatan'             => 'required|date',
                        'kepulangan'                => 'required|date',
                        'double'                    => 'required',
                        'triple'                    => 'required',
                        'makkah'                    => 'required',
                        'madinah'                   => 'required',
                        'transportasi'              => 'required',
                        'jeddah'                    => 'required',
                        'departure'                 => 'required',
                        'arrival'                   => 'required',
                    ];
        if($request->file('gambar') != null){
            $rules['gambar'] = 'mimes:jpg,jpeg,png,svg|max:1000';
        }              
        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $component['makkah']             = $request->makkah;
            $component['madinah']            = $request->madinah;
            $component['transportasi']       = $request->transportasi;
            $component['jeddah']             = $request->jeddah;
            $component['departure']          = $request->departure;
            $component['arrival']            = $request->arrival;

            $paket                           = jadwal::findOrFail($id);
            $paket->umrah_paket_id           = $request->paket_id;
            $paket->nama_jadwal              = $request->nama_jadwal;
            $paket->mata_uang               = $request->mata_uang;
            $paket->nama_jadwal_seo          = Str::slug($request->nama_jadwal);
            $paket->keberangkatan            = $request->keberangkatan;
            $paket->kepulangan               = $request->kepulangan;
            $paket->durasi                   = TglProcessor::countday($request->keberangkatan,$request->kepulangan);
            $paket->component                = json_encode($component);
            $paket->double                   = $request->double;
            $paket->triple                   = $request->triple;
            $paket->quad                     = $request->quad;
            $paket->include                  = json_encode($request->include);

            if($request->file('gambar') != null){
                $upload                     = UploadProcessor::go($request->file('gambar'),'umrah');
                $paket->gambar_itinerary    = $upload;
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
          $delete = jadwal::findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}