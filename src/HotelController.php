<?php
namespace Bageur\PaketUmrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Bageur\PaketUmrah\model\hotel;
use Bageur\PaketUmrah\Processors\UploadProcessor;
use Validator;
class HotelController extends Controller
{

    public function index(Request $request)
    {
       $query = hotel::datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'nama_hotel'		        => 'required',
                        'domisili_hotel'            => 'required',
                    ];             
        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $hotel              			  = new hotel;
            $hotel->nama_hotel	              = $request->nama_hotel;
            $hotel->nama_hotel_seo	          = Str::slug($request->nama_hotel);
            $hotel->domisili_hotel            = $request->domisili_hotel;
            if($request->file != null){
                $upload                       = UploadProcessor::go($request->file,'hotel');
	           	$hotel->gambar	              = $upload['up'];
                $hotel->gambar_path           = $upload['path'];
       		}
            $hotel->save();
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
        return hotel::findOrFail($id);
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
                        'nama_hotel'                    => 'required',
                        'domisili_hotel'                => 'required',
                      ];       
        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $hotel                          = hotel::findOrFail($id);
            $hotel->nama_hotel              = $request->nama_hotel;
            $hotel->nama_hotel_seo          = Str::slug($request->nama_hotel);
            $hotel->domisili_hotel          = $request->domisili_hotel;
            if($request->file != null){
                $upload                     = UploadProcessor::go($request->file,'hotel');
	           	$hotel->gambar	            = $upload['up'];
                $hotel->gambar_path         = $upload['path'];
       		}
            $hotel->save();
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
          $delete = hotel::findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}