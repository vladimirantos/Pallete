<?php
namespace App\Model\Mapper\File;
use App\Model\Core\FileNotFoundException;
use App\Model\Core\RuntimeException;
use Nette\Database\Table\Selection;
use Nette\Http\FileUpload;
use Nette\Utils\Finder;

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
    public function upload(FileUpload $fileUpload, $path) {
        if(!$fileUpload->isOk())
            throw new ImageUploadedException('Chyba při nahrávání obrázku');
        $fileUpload->move($path);
    }

    public function delete($path){
        if(!file_exists($path))
            throw new FileNotFoundException('Soubor neexistuje');
        unlink($path);
    }

    public function deleteFolder($dir){
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteFolder("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);

    }

    public function getFiles($path){
        return array_diff(scandir($path), array('.', '..'));
      //  return Finder::findFiles('*')->in($path);
    }
}