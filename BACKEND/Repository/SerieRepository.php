<?php
require_once 'Db.php';
require_once 'AbstractRepository.php';
require_once '../Model/Serie.php';
require_once '../Model/SerieGrid.php';

class SerieRepository extends AbstractRepository {

    public function get($id) {
        try{
            $sql = "SELECT * FROM series WHERE id=:id ORDER BY cargaInicio ASC";
            $db = $this->connect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $item = $stmt->fetchObject();            
            
            if ($item == null) {
                return null;
            }
            $serie = new Serie();

            $serie->setId((int)$item->id);
            $serie->setCargaInicio($item->cargaInicio);
            $serie->setCargaFin($item->cargaFin);
            $serie->setEnvioMuestra($item->envioMuestra);
            $serie->setLaboratorioId($item->laboratorioId);            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $serie;
    }

    public function getAll(): Array{

        try{
            $db = $this->connect();
            $series = Array();
            $sql = "SELECT * FROM series ORDER BY cargaInicio ASC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $series;
            }

            foreach ($items as $item) {
                $serie = new Serie();
                
                $serie->setId((int)$item->id);
                $serie->setCargaInicio($item->cargaInicio);
                $serie->setCargaFin($item->cargaFin);
                $serie->setEnvioMuestra($item->envioMuestra);
                $serie->setLaboratorioId($item->laboratorioId);                
                
                array_push($series,$serie);
            }            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $series;
    }

    public function getBotella(int $serieId, int $botella, int $usuarioId): Array{
        try{
            $query = "SELECT *
                        FROM presentaciones
                        WHERE serieId = :serieId AND botella = :botella
                            AND laboratorioId NOT IN (SELECT laboratorioId
                                                        FROM usuarios
                                                        WHERE id = :usuarioId)";
            $db = $this->connect();
            
            $stmt = $db->prepare($query);            
            $stmt->bindParam(':usuarioId', $usuarioId);
            $stmt->bindParam(':serieId', $serieId);
            $stmt->bindParam(':botella', $botella);

            
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return [ 'existe' => false ];
            }
            return [ 'existe' => true ];
        }finally{
            $stmt = null;
            $this->disconnect();
        }
    }


    public function create(Serie $serie): Serie {
        
        try {
            $consulta = "INSERT INTO series (`cargaInicio`, `cargaFin`, `envioMuestra`, `laboratorioId`)
                         VALUES (:cargaInicio, :cargaFin, :envioMuestra, :laboratorioId)";

            $db = $this->connect();
            $stmt = $db->prepare($consulta);

            $cargaInicio = $serie->getCargaInicio();
            $cargaFin = $serie->getCargaFin();
            $envioMuestra = $serie->getEnvioMuestra();
            $laboratorioId = $serie->getLaboratorioId();

            $stmt->bindParam(':cargaInicio', $cargaInicio);
            $stmt->bindParam(':cargaFin', $cargaFin);
            $stmt->bindParam(':envioMuestra', $envioMuestra);
            $stmt->bindParam(':laboratorioId', $laboratorioId, PDO::PARAM_INT);
            
            $stmt->execute();
            $serie->setId($db->lastInsertId());
        } catch (Exception $e) {
            if ($e instanceof PDOException && $stmt->errorInfo()[0] == 23000) {                
                throw new BadRequestException("Laboratorio inexistente para el alta de la serie.");
            } else {
                throw $e;
            }
        } finally {
            $stmt = null;            
            $this->disconnect();
        }
        return $serie;
    }

    public function update(Serie $serie){

        try{                                
            $consulta = "UPDATE series 
                            SET `cargaInicio`=:cargaInicio, `cargaFin`=:cargaFin, `envioMuestra`=:envioMuestra, `laboratorioId`=:laboratorioId
                            WHERE `id`=:id";
            
            $db = $this->connect();
            $stmt = $db->prepare($consulta);            

            $id = $serie->getId();
            $cargaInicio = $serie->getCargaInicio();
            $cargaFin = $serie->getCargaFin();
            $envioMuestra = $serie->getEnvioMuestra();
            $laboratorioId = $serie->getLaboratorioId();

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':cargaInicio', $cargaInicio);
            $stmt->bindParam(':cargaFin', $cargaFin);
            $stmt->bindParam(':envioMuestra', $envioMuestra);
            $stmt->bindParam(':laboratorioId', $laboratorioId);                                    

            $stmt->execute();
        } catch (Exception $e) {
            if ($e instanceof PDOException && $stmt->errorInfo()[0] == 23000) {                
                throw new BadRequestException("Laboratorio inexistente para modificar la serie.");
            } else {
                throw $e;
            }
        } finally {
            $stmt = null;
            $this->disconnect();
        }
    }

    public function getCsvData(int $id){
        // CONTINUAR MAS ADELANTE 15-08.
        try{
            $file = fopen('php://output', 'w');
            $encabezado = Array("Lab#", "#Botella Recibida", "Agitación");

            $db = $this->connect();

            $sql = "SELECT l.codigo, p.botella, p.agitacion
                    FROM presentaciones p 
                    INNER JOIN laboratorios l ON (p.laboratorioId = l.id)
                    WHERE p.serieId = :serieId";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':serieId', $id);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $queryHeaders = "SELECT DISTINCT(m.titulo)	
                             FROM presentaciones p
                                INNER JOIN resultados r ON (p.serieId = r.serieId AND p.laboratorioId = r.laboratorioId)
                                INNER JOIN metodos m ON (r.metodoId = m.id)
                                INNER JOIN determinaciones d ON (m.determinacionId = d.id)
                             WHERE p.serieId = :serieId
                             ORDER BY d.titulo";

            $stmt = $db->prepare($queryHeaders);
            $stmt->bindParam(':serieId', $id);
            $stmt->execute();
            $headers = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $queryDatos = "SELECT l.codigo, r.valor, m.titulo
                            FROM presentaciones p
                                INNER JOIN resultados r ON (p.serieId = r.serieId AND p.laboratorioId = r.laboratorioId)
                                INNER JOIN metodos m ON (r.metodoId = m.id)
                                INNER JOIN determinaciones d ON (m.determinacionId = d.id)
                                INNER JOIN laboratorios l ON (p.laboratorioId = l.id)
                            WHERE
                                p.serieId = :serieId
                            ORDER BY
                                m.titulo, l.codigo";

            $stmt = $db->prepare($queryDatos);
            $stmt->bindParam(':serieId', $id);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $matriz = array();
            $a = 0;
            $b = 1;
            foreach ($headers as $header) {                
                $matriz[0][$a] = "Lab#";
                $matriz[0][$b] = $header->titulo;
                $a+=2;
                $b+=2;                
            }            
            
            $a = array();
            $metodoEstadoAnterior = $datos[0]->titulo;
            
            $b = array();
            foreach ($datos as $dato) {
               
                $valoresGuardar = array($dato->codigo, $dato->valor);
                               
                if($dato->titulo != $metodoEstadoAnterior){
                    array_push($a, $b);
                    $b = array();      
                    array_push($b, $valoresGuardar);
                }else{
                    array_push($b, $valoresGuardar);                                        
                }
                if(!next($datos)){
                    array_push($a, $b);
                }
                
                $metodoEstadoAnterior = $dato->titulo;
            }
            print_r($a);
            die();

            // Calcula cantidad de filas y columnas totales.
            $filas = 0;
            $columnas = 0;
            foreach($matriz as $f => $matrizItem) { 
                $filas++;
                
                $columnaSize = max(array_keys($matriz[$f]));
                if($columnas < $columnaSize + 1) $columnas = $columnaSize + 1;
            } 
            
            isset($matriz[$f][$c]) ? fputcsv($file, $matriz[$f]) : "";

            // Recorre la matriz por fila y columna.
            for($f = 0; $f < $filas; $f++) { 
                for($c = 0; $c < $columnas; $c++) { 
                    
                }
            }

            /*die();
            fputcsv($file, $encabezado);
                        
            foreach ($items as $item) {
                $info = Array(
                    $item->codigo, $item->botella, $item->agitacion
                );
                fputcsv($file, $info);
            }*/
            

            fclose($file);
        }catch(Exception $e){

        }
        /*$header = Array("Columna 1", "Columna 2", "Columna 3");

        fputcsv($file, $header);

        $data = Array(
            Array("Dato 11", "Dato 12", "Dato 13"),
            Array("Dato 21", "Dato 22", "Dato 23"),
            Array("Dato 31", "Dato 32", "Dato 33")
        );

        
            SELECT p.laboratorioId, r.valor, d.titulo
            FROM presentaciones p
                INNER JOIN resultados r ON (p.serieId = r.serieId AND p.laboratorioId = r.laboratorioId)
                INNER JOIN metodos m ON (r.metodoId = m.id)
                INNER JOIN determinaciones d ON (m.determinacionId = d.id)
            WHERE
                p.serieId = 3
            ORDER BY
                d.titulo
         

        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);*/    
    }

    public function grilla(): Array{
        
        try{
            $db = $this->connect();
            $seriesGrid = Array();
            $sql = "SELECT  s.id,
                            s.cargaInicio,
                            s.cargaFin,
                            s.envioMuestra,
                            l.id as laboratorioId,
                            l.descripcion as laboratorioDescripcion                  
                    FROM series s 
                        LEFT JOIN laboratorios l ON ( s.laboratorioId = l.id )
                    ORDER BY s.cargaInicio ASC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return $seriesGrid;
            }

            foreach ($items as $item) {
                $serieGrid = new SerieGrid();
                
                $serieGrid->setId((int)$item->id);
                $serieGrid->setCargaInicio($item->cargaInicio);
                $serieGrid->setCargaFin($item->cargaFin);
                $serieGrid->setEnvioMuestra($item->envioMuestra);
                $serieGrid->setLaboratorioId($item->laboratorioId);                
                $serieGrid->setLaboratorioDescripcion($item->laboratorioDescripcion);

                array_push($seriesGrid,$serieGrid);
            }            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $seriesGrid;
    }

    public function getSeries($serie, $isUpdate){

        $querySerie = "SELECT *
                        FROM series
                        WHERE ((:fCargaInicio >= cargaInicio AND :fCargaInicio <= cargaFin)
                            OR
                              (:fCargaFin >= cargaInicio AND :fCargaFin <= cargaFin)
                            OR
                              (:fCargaInicio < cargaInicio AND :fCargaFin > cargaFin))";

        $db = $this->connect();
        
        if($isUpdate){
            $querySerie .= "AND id <> :serieId";
            
            $stmt = $db->prepare($querySerie);

            $serieId = $serie->getId();
            $fCargaInicio = $serie->getCargaInicio();
            $fCargaFin = $serie->getCargaFin();

            $stmt->bindParam(':serieId', $serieId);
            $stmt->bindParam(':fCargaInicio', $fCargaInicio);
            $stmt->bindParam(':fCargaFin', $fCargaFin);
        }else{
            $stmt = $db->prepare($querySerie);

            $fCargaInicio = $serie->getCargaInicio();
            $fCargaFin = $serie->getCargaFin();

            $stmt->bindParam(':fCargaInicio', $fCargaInicio);
            $stmt->bindParam(':fCargaFin', $fCargaFin);
        }

        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $items;
    }
}