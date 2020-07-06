<?php
declare(strict_types=1);

namespace App\Controller\Views;

use Psr\Http\Message\ServerRequestInterface;
use App\Controller\AbsController;
use App\Controller\ViewController;
use App\Middleware\InjectableMiddleware;
use App\Helper\ViewControllerDependencies;
use App\Middleware\Auth\NeedsAuthMiddleware;
use App\Db\ImagesDbCollection;
use App\Db\UserDbCollection;
use App\Helper\GpsCoords;

class PhotoMaps extends ViewController implements \App\Controller\IController {
    use \App\Traits\GetCookieTrait;
    
    public function __construct(
        ViewControllerDependencies $view,
        NeedsAuthMiddleware $needsAuth,
        UserDbCollection $userCollection,
        ImagesDbCollection $imgCollection,
        GpsCoords $gps
    ) {
        $this->userCollection = $userCollection;
        $this->imgCollection  = $imgCollection;
        $this->gps = $gps;

        $template = 'photomaps';
        $middlewares = [
            new InjectableMiddleware($needsAuth)
        ];
        parent::__construct($template, $view, $middlewares);

    }

    // process coords
    protected function processCoords(string $exif, bool $isLat) {
        $key = 'GPSLongitude';
        if ($isLat){
            $key = 'GPSLatitude';
        }
        preg_match('/'.$key.'\W+\[(.*?)\]/', $exif, $coords);
        preg_match('/'.$key.'Ref\W+(\w)/', $exif, $hemisphere);
        if (count($coords) > 1) {
            return $this->gps->getGps(
                explode(',', str_replace(['\\', '"'], '', $coords[1])), 
                $hemisphere[1])
            ;
        }  
        return 0;      
    }


    /**
     * If some data is needed work here!
     */
    protected function setViewParams($request) :array{
        $cookies = $this->getCookies($request);

        $gpsImages=[];
        // here are selected only the images WITH exif data
        if ($this->userCollection->findByEmail($cookies['user'])) {
            $gpsImages = $this->imgCollection->selectAllByUser(
                $this->userCollection->mapObj->getId(),
                ['exif' => new \MongoDB\BSON\Regex('latitude', 'i')],
                false
            );
        }
        $images=[];
        foreach($gpsImages as $img) {
            $lat = $this->processCoords($img->exif, true);
            $lng = $this->processCoords($img->exif, false);

            array_push($images, [
                'photo' => str_replace('.', '%20', $img->filename), 
                'lat' => $lat, 
                'lng' => $lng 
            ]);
        }

        $gMapsKey = \App\Config\Env::get('GOOGLE_MAPS_KEY');

        return [
            'images' => $images,
            'gMapsKey' => $gMapsKey
        ];
    }
}