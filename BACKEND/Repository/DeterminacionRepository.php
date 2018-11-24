<?php
require_once 'Db.php';
require_once 'AbstractRepository.php';
require_once '../Model/Determinacion.php';

class DeterminacionRepository extends AbstractRepository {

    public function get($id) {
        try{
            $sql = "SELECT * FROM determinaciones WHERE id=:id";
            $db = $this->connect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $item = $stmt->fetchObject();                                
            
            if ($item == null) {
                return null;
            }
            $determinacion = new Determinacion();

            $determinacion->setId((int)$item->id);
            $determinacion->setTitulo($item->titulo);
            $determinacion->setDescripcion($item->descripcion);
            $determinacion->setActivo($item->activo);
            
        }finally{
            $stmt = null;            
            $this->disconnect();
        }
        
        return $determinacion;
    }

    public function getAll(): Array{

        $determinaciones = Array();
        $sql = "SELECT * FROM determinaciones WHERE activo = 1 ORDER BY titulo ASC";
        try{
            $db = $this->connect();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $determinaciones;
            }
            
            foreach ($items as $item) {
                $determinacion = new Determinacion();

                $determinacion->setId((int)$item->id);
                $determinacion->setTitulo($item->titulo);
                $determinacion->setDescripcion($item->descripcion);
                $determinacion->setActivo($item->activo);

                array_push($determinaciones,$determinacion);
            }            
        }finally{
            $stmt = null;            
            $this->disconnect();
        }
        
        return $determinaciones;
    }

    public function grilla(): Array{
        try{            
            $db = $this->connect();
            $determinaciones = Array();
            $sql = "SELECT * FROM determinaciones ORDER BY titulo ASC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $determinaciones;
            }
            
            foreach ($items as $item) {
                $determinacion = new Determinacion();

                $determinacion->setId((int)$item->id);
                $determinacion->setTitulo($item->titulo);
                $determinacion->setDescripcion($item->descripcion);
                $determinacion->setActivo($item->activo);

                array_push($determinaciones,$determinacion);
            }            
        }finally{
            $stmt = null;            
            $this->disconnect();
        }
        
        return $determinaciones;
    }    

    public function create(Determinacion $determinacion): Determinacion {
        try {
            $consulta = "INSERT INTO determinaciones 
                            (`titulo`, `descripcion`, `activo`) 
                         VALUES (:titulo, :descripcion, :activo)";

            $db = $this->connect();
            $stmt = $db->prepare($consulta);
            
            $titulo = $determinacion->getTitulo();
            $descripcion = $determinacion->getDescripcion();
            $activo = $determinacion->getActivo();            
                
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);            
                
            $stmt->execute();
            $determinacion->setId($db->lastInsertId());
        } catch (Exception $e) {            
            if ($e instanceof PDOException && $stmt->errorInfo()[0] == 23000 && $stmt->errorInfo()[1] == 1062) {
                $array = explode("'", $stmt->errorInfo()[2]);
                switch ($array[3]) {
                    case 'titulo':
                        throw new BadRequestException("El " . $array[1] . " para una determinación ya existe.");
                        break;
                }
            } else {
                throw $e;
            }
        } finally {
            $stmt = null;            
            $this->disconnect();
        }
        return $determinacion;
    }

    public function update(Determinacion $determinacion){

        try{
            $consulta = "UPDATE determinaciones
                         SET `titulo`=:titulo, `descripcion`=:descripcion, `activo`=:activo
                         WHERE `id`=:id";
            
            $db = $this->connect();
            $stmt = $db->prepare($consulta);

            $id = $determinacion->getId();
            $titulo = $determinacion->getTitulo();
            $descripcion = $determinacion->getDescripcion();
            $activo = $determinacion->getActivo();
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);

            $stmt->execute();
        } catch (Exception $e) {
            if ($e instanceof PDOException && $stmt->errorInfo()[0] == 23000 && $stmt->errorInfo()[1] == 1062) {
                $array = explode("'", $stmt->errorInfo()[2]);
                switch ($array[3]) {
                    case 'titulo':
                    throw new BadRequestException("El " . $array[1] . " para una determinación ya existe.");
                    break;
                }
            } else {
                throw $e;
            }
        } finally {
            $stmt = null;
            $this->disconnect();
        }
    }   
}