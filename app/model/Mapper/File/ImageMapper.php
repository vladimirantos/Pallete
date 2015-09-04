<?php
namespace App\Model\Mapper\File;
use App\Model\Core\RuntimeException;
use Nette\Database\Table\Selection;
use Nette\Http\FileUpload;

class ImageUploadedException extends RuntimeException{

}

/**
 * Class ImageMapper
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Mapper\File
 */
class ImageMapper extends AbstractFileMapper {

    public function __construct() {

    }


    /**
     * @param FileUpload $fileUpload
     */
    public function upload(FileUpload $fileUpload, $fileName) {
        if(!$fileUpload->isOk())
            throw new ImageUploadedException('Chyba při nahrávání obrázku');
        $fileUpload->move(articleImagesPath.$fileName);
    }

    public function delete($name){
        unlink(articleImagesPath.$name);
    }
}