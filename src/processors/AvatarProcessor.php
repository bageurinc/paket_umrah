<?php
namespace Bageur\PaketUmrah\Processors;

class AvatarProcessor {

    public static function get( $name, $image = null, $folder = "bageur.id/umrah", $type = "initials") {
        if (empty($image)) {
            if (!empty($name)) {
                return 'https://avatars.dicebear.com/v2/'.$type.'/' . preg_replace('/[^a-z0-9 _.-]+/i', '', $name) . '.svg';
            }
            return null;
        }
        return url('storage/'.$folder.'/'.$image);
    }
}
