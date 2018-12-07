<?php
require_once 'AbstractRepository.php';
require_once '../Model/Material.php';

class MaterialRepository extends AbstractRepository {

    /*public function get($id) {
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
    }*/

    public function create($material): Material{
        try{            
            $consulta = "INSERT INTO `material` (`operador`, `fecha`, `hora`, `paciente`, `numeroHistoriaClinica`, `descripcionMaterial`, `medicoSolicitante`, `pesoDeLaCaja`, `proveedor`, `empresa`, `metodo`, `observaciones`) 
                            VALUES (:operador, :fecha, :hora, :paciente, :numeroHistoriaClinica, :descripcionMaterial, :medicoSolicitante, :pesoDeLaCaja, :proveedor, :empresa, :metodo, :observaciones)";

            $db = $this->connect();
            $stmt = $db->prepare($consulta);

            $operador = $material->getOperador();
            $fecha = $material->getFecha();
            $hora = $material->getHora();
            $paciente = $material->getPaciente();
            $numeroHistoriaClinica = $material->getNumeroHistoriaClinica();
            $descripcionMaterial = $material->getDescripcionMaterial();
            $medicoSolicitante = $material->getMedicoSolicitante();
            $pesoDeLaCaja = $material->getPesoDeLaCaja();
            $proveedor = $material->getProveedor();
            $empresa = $material->getEmpresa();
            $metodo = $material->getMetodo();
            $observaciones = $material->getObservaciones();
            
            $stmt->bindParam(':operador', $operador, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':paciente', $paciente);
            $stmt->bindParam(':numeroHistoriaClinica', $numeroHistoriaClinica);
            $stmt->bindParam(':descripcionMaterial', $descripcionMaterial);
            $stmt->bindParam(':medicoSolicitante', $medicoSolicitante);
            $stmt->bindParam(':pesoDeLaCaja', $pesoDeLaCaja);
            $stmt->bindParam(':proveedor', $proveedor);
            $stmt->bindParam(':empresa', $empresa);
            $stmt->bindParam(':metodo', $metodo);
            $stmt->bindParam(':observaciones', $observaciones);

            $stmt->execute();
            $material->setId($db->lastInsertId());
        }finally{
            $stmt = null;
            $this->disconnect();
        }

        return $material;
    }
}