<?php
require_once 'AbstractRepository.php';
require_once '../Model/Material.php';
require_once '../Model/InstrumentalGrid.php';

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
    }*/

    public function getAll(): Array{
        
        try{
            $db = $this->connect();
            $instrumentales = Array();
            $sql = "SELECT m.id, op.nombre, m.paciente, m.numeroHistoriaClinica, m.medicoSolicitante 
                        FROM material m
                            INNER JOIN operadorce op ON (m.operador = op.id)";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $instrumentales;
            }

            foreach ($items as $item) {
                $instrumentalGrid = new InstrumentalGrid();
                                
                $instrumentalGrid->setId((int)$item->id);
                $instrumentalGrid->setOperador($item->nombre);
                $instrumentalGrid->setPaciente($item->paciente);
                $instrumentalGrid->setNumeroHistoriaClinica((int)$item->numeroHistoriaClinica);
                $instrumentalGrid->setMedicoSolicitante($item->medicoSolicitante);
                
                array_push($instrumentales,$instrumentalGrid);
            }            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $instrumentales;
    }

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