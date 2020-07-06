<?php
declare(strict_types=1);

namespace App\Helper;

class GpsCoords{
    // https://stackoverflow.com/questions/2526304/php-extract-gps-exif-data
    public function getGps($exifCoord, $hemi) {
        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;
    
        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
   
        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }
    
    protected function gps2Num($coordPart) {
        $parts = explode('/', $coordPart);
    
        if (count($parts) <= 0)
            return 0;
    
        if (count($parts) == 1)
            return $parts[0];
    
        return floatval($parts[0]) / floatval($parts[1]);
    }
}
