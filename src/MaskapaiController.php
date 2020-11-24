<?php
namespace Bageur\PaketUmrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Bageur\PaketUmrah\model\maskapai;
use Bageur\PaketUmrah\Processors\UploadProcessor;
use Validator;
class MaskapaiController extends Controller
{

    public function index(Request $request)
    {
       $query = maskapai::datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'nama_maskapai'		        => 'required',
                        'tipe_maskapai'            => 'required',
                    ];              
        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $maskapai              			    = new maskapai;
            $maskapai->nama_maskapai	    = $request->nama_maskapai;
            $maskapai->nama_maskapai_seo	= Str::slug($request->nama_maskapai);
            $maskapai->tipe_maskapai        = $request->tipe_maskapai;
            $maskapai->save();
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
        return maskapai::findOrFail($id);
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
                        'nama_maskapai'                => 'required',
                        'tipe_maskapai'                => 'required',
                      ];           
        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $maskapai                             = maskapai::findOrFail($id);
            $maskapai->nama_maskapai          = $request->nama_maskapai;
            $maskapai->nama_maskapai_seo      = Str::slug($request->nama_maskapai);
            $maskapai->tipe_maskapai          = $request->tipe_maskapai;
            $maskapai->save();
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
          $delete = maskapai::findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}