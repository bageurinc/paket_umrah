<?php
namespace Bageur\PaketUmrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Bageur\PaketUmrah\model\transportasi;
use Bageur\PaketUmrah\Processors\UploadProcessor;
use Validator;
class TransportasiController extends Controller
{

    public function index(Request $request)
    {
       $query = transportasi::datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'nama_transportasi'		        => 'required',
                        'tipe_transportasi'            => 'required',
                    ];              
        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $transportasi              			    = new transportasi;
            $transportasi->nama_transportasi	    = $request->nama_transportasi;
            $transportasi->nama_transportasi_seo	= Str::slug($request->nama_transportasi);
            $transportasi->tipe_transportasi        = $request->tipe_transportasi;
            $transportasi->save();
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
        return transportasi::findOrFail($id);
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
                        'nama_transportasi'                => 'required',
                        'tipe_transportasi'                => 'required',
                      ];           
        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $transportasi                             = transportasi::findOrFail($id);
            $transportasi->nama_transportasi          = $request->nama_transportasi;
            $transportasi->nama_transportasi_seo      = Str::slug($request->nama_transportasi);
            $transportasi->tipe_transportasi          = $request->tipe_transportasi;
            $transportasi->save();
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
          $delete = transportasi::findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}