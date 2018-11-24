<?php
require_once 'AbstractRepository.php';
require_once '../Model/Metodo.php';

class MetodoRepository extends AbstractRepository {

    public function get($id) {
        try{
            $sql = "SELECT * FROM metodo WHERE id=:id";
            $db = $this->connect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $item = $stmt->fetchObject();
                    
            if ($item == null) {
                return null;
            }
            
            $metodo = new Metodo();

            $metodo->setId((int)$item->id);
            $metodo->setNombre($item->nombre);
        }finally{
            $stmt = null;            
            $this->disconnect();
        }
        
        return $metodo;
    }

    public function getAll(): Array{
        
        try{
            $db = $this->connect();
            $metodos = Array();
            $sql = "SELECT * FROM metodo";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $metodos;
            }

            foreach ($items as $item) {
                $metodo = new Metodo();

                $metodo->setId((int)$item->id);
                $metodo->setNombre($item->nombre);
                
                array_push($metodos,$metodo);
            }            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $metodos;
    }
}