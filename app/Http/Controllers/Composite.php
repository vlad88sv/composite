<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Composite extends Controller
{
    function composite() {
        $img1 = new \Imagick();
        $img1->readImage(realpath(resource_path('img/modelo.jpg')));
    
        $img2 = new \Imagick();
        $img2->readImage(realpath(resource_path('img/logo.jpg')));
    
        $img1->resizeimage(
            $img2->getImageWidth(),
            $img2->getImageHeight(),
            \Imagick::FILTER_LANCZOS,
            1
        );
    
        $opacity = new \Imagick();
        $opacity->newPseudoImage(
            $img1->getImageHeight(), 
            $img1->getImageWidth(),
            "gradient:gray(10%)-gray(90%)"
        );
        //$opacity->rotateimage('black', 95);
    
        $img2->compositeImage($opacity, \Imagick::COMPOSITE_COPYOPACITY, 0, 0);
        $img1->compositeImage($img2, \Imagick::COMPOSITE_ATOP, 0, 0);
    
        header("Content-Type: image/jpeg");
        echo $img1->getImageBlob();
    }
}
