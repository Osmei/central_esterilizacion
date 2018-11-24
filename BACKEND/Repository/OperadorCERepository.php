<?php
require_once 'AbstractRepository.php';
require_once '../Model/OperadorCE.php';

class OperadorCERepository extends AbstractRepository {

    public function get($id) {
        try{
            $sql = "SELECT * FROM operadorCE WHERE id=:id";
            $db = $this->connect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $item = $stmt->fetchObject();
                    
            if ($item == null) {
                return null;
            }
            
            $operadorCE = new OperadorCE();

            $operadorCE->setId((int)$item->id);
            $operadorCE->setNombre($item->nombre);
        }finally{
            $stmt = null;            
            $this->disconnect();
        }
        
        return $operadorCE;
    }

    public function getAll(): Array{
        
        try{
            $db = $this->connect();
            $operadoresCE = Array();
            $sql = "SELECT * FROM operadorCE";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $operadoresCE;
            }

            foreach ($items as $item) {
                $operadorCE = new OperadorCE();

                $operadorCE->setId((int)$item->id);
                $operadorCE->setNombre($item->nombre);
                
                array_push($operadoresCE,$operadorCE);
            }            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $operadoresCE;
    }
}