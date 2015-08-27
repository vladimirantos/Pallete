<?php
namespace App\Model\Mapper\File;
use App\Model\Mapper\IMapper;
use Nette\Http\FileUpload;

interface IFileMapper{

    /**
     * @param FileUpload $fileUpload
     */
    function upload(FileUpload $fileUpload);
}

/**
 * Class AbstractFileMapper
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Mapper\File
 */
abstract class AbstractFileMapper implements IFileMapper{

    public function __construct() {

    }
}