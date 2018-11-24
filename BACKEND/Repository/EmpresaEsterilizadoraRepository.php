<?php
require_once 'AbstractRepository.php';
require_once '../Model/EmpresaEsterilizadora.php';

class EmpresaEsterilizadoraRepository extends AbstractRepository {

    public function get($id) {
        try{
            $sql = "SELECT * FROM empresaesterilizadora WHERE id=:id";
            $db = $this->connect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $item = $stmt->fetchObject();
                    
            if ($item == null) {
                return null;
            }
            
            $proveedor = new Proveedor();

            $proveedor->setId((int)$item->id);
            $proveedor->setNombre($item->nombre);
        }finally{
            $stmt = null;            
            $this->disconnect();
        }
        
        return $proveedor;
    }

    public function getAll(): Array{
        
        try{
            $db = $this->connect();
            $proveedores = Array();
            $sql = "SELECT * FROM empresaesterilizadora";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $proveedores;
            }

            foreach ($items as $item) {
                $proveedor = new Proveedor();

                $proveedor->setId((int)$item->id);
                $proveedor->setNombre($item->nombre);
                
                array_push($proveedores,$proveedor);
            }            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $proveedores;
    }
}