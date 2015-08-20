<?php
namespace App\Model\Core;

/**
 * @author Vladimír Antoš
 * @version 1.0.0
 */
class AsterixException extends \Exception{

}

class SystemException extends AsterixException{

}

class RuntimeException extends AsterixException{

}

class UnsupportedOperationException extends RuntimeException{

}

class DevideByZeroException extends RuntimeException{

}

class ArgumentException extends RuntimeException{

}

class ArgumentOutOfRangeException extends ArgumentException{

}

class ArgumentNullException extends ArgumentException{

}

class StaticClassException extends SystemException{

}

class MemberAccessException extends SystemException{

}

class InvalidOperationException extends SystemException{

}

class IndexOutOfRangeException extends SystemException{

}

class NotImplementedException extends SystemException{

}

class IOException extends SystemException{

}

class FileNotFoundException extends IOException{

}

class DirectoryNotFoundException extends IOException{

}

class FileExistsException extends IOException{

}

class EmptyFileException extends IOException{

}

class ApplicationException extends AsterixException{

}

class EntityExistsException extends ApplicationException{

}

class FormatException extends SystemException{

}

class NotFoundException extends RuntimeException{

}