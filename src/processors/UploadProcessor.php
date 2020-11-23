<?php
namespace Bageur\PaketUmrah\Processors;

class UploadProcessor {

    public static function go($data,$loc) 
    {
        $path       = 'bageur.id/'.$loc;
        \Storage::makeDirectory('public/'.$path);
        $namaBerkas = 'avatar'.date('ymdhis').'.png';
        $image = \Image::make($data);
        $image->save(storage_path('app/public/'.$path.'/'.$namaBerkas));
        $arr = ['up' => $namaBerkas , 'path' => $path];
        return $arr;
    }
}
