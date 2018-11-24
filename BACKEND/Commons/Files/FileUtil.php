<?php
require_once '../Commons/Exceptions/BadRequestException.php';
require_once '../Model/Archivo.php';

use Slim\Http\UploadedFile;

class FileUtil {
	public static function moveUploadedFile(string $directory, UploadedFile $uploadedFile, int $serieId) {
		// TODO: Verificar errores.
	    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
		
		$archivos = glob($directory.DIRECTORY_SEPARATOR."Informe_$serieId.*");
		if(!is_null($archivos)){
			foreach ($archivos as $archivo) {
				unlink($archivo);
			}	
		}

	    $filename = sprintf('%s.%0.8s', "Informe_$serieId", $extension);

	    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

	    return $filename;
	}

	public static function readFile(string $directory, int $serieId) {
		$arrayArchivos = glob($directory.DIRECTORY_SEPARATOR."Informe_$serieId.*");
		if($arrayArchivos){
			
			$fileName = explode('\\',$arrayArchivos[0]);						
			$file = @file_get_contents($directory . DIRECTORY_SEPARATOR . $fileName[2]);
			$tipo = mime_content_type($arrayArchivos[0]);

			$archivo = new Archivo();
			$archivo->setNombre($fileName[2]);
			$archivo->setContenido($file);
			$archivo->setTipo($tipo);

			if($file !== false) {
				return $archivo;
			} else {
				throw new BadRequestException("Archivo no encontrado.");			
			}
		}		
	}
}