<?php
require_once 'AbstractRepository.php';
require_once '../Model/Usuario.php';
require_once '../Model/Persona.php';
require_once '../Model/Perfil.php';
require_once '../Repository/PerfilesRepository.php';

class PersonaRepository extends AbstractRepository {

    public function get($id) {
        try{
            $sql = "SELECT * FROM usuarios WHERE id=:id";
            $db = $this->connect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $item = $stmt->fetchObject();
                    
            if ($item == null) {
                return null;
            }
            $usuario = new Usuario();

            $usuario->setId((int)$item->id);
            $usuario->setNombre($item->nombre);
            $usuario->setApellido($item->apellido);
            $usuario->setUsuario($item->usuario);
            $usuario->setClave($item->clave);
            $usuario->setPerfil((new PerfilesRepository())->get($item->perfil));
            $usuario->setLaboratorioId($item->laboratorioId);
            $usuario->setActivo($item->es_activo);            
        }finally{
            $stmt = null;            
            $this->disconnect();
        }
        
        return $usuario;
    }

    public function getAll(): Array{
        
        try{
            $db = $this->connect();
            $usuarios = Array();
            $sql = "SELECT * FROM usuarios WHERE es_activo = 1";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if($items == null){
                return null;
            }

            foreach ($items as $item) {
                $usuario = new Usuario();

                $usuario->setId((int)$item->id);
                $usuario->setNombre($item->nombre);
                $usuario->setApellido($item->apellido);
                $usuario->setUsuario($item->usuario);
                $usuario->setClave($item->clave);
                $usuario->setPerfil((new PerfilesRepository())->get($item->perfil));
                $usuario->setLaboratorioId($item->laboratorioId);
                $usuario->setActivo($item->es_activo);
                
                array_push($usuarios,$usuario);
            }            
        }finally{
            $stmt = null;         
            $this->disconnect();
        }
        
        return $usuarios;
    }

    public function delete($id){

        $consulta = "DELETE FROM usuarios WHERE persona=:id";
        
        $db = $this->connect();
        $stmt = $db->prepare($consulta);

        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function create(Usuario $usuario): Usuario {
        try {
            $consulta = "INSERT INTO usuarios (
                nombre,
                apellido,
                usuario,
                clave,
                perfil,
                laboratorioId,
                es_activo
            ) VALUES (
                :nombre,
                :apellido,
                :usuario,
                :clave,
                :perfil,
                :laboratorioId,
                :es_activo
            )";

            $db = $this->connect();
            $stmt = $db->prepare($consulta);
            
            $nombre = $usuario->getNombre();
            $apellido = $usuario->getApellido();
            $usuarioNombre = $usuario->getUsuario();
            $clave = $usuario->getClave();
            $perfil = $usuario->getPerfil()->getId();
            $laboratorioId = $usuario->getLaboratorioId();
            $esActivo = $usuario->getActivo();            
                
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':usuario', $usuarioNombre);
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':perfil', $perfil, PDO::PARAM_INT);
            $stmt->bindParam(':laboratorioId', $laboratorioId, PDO::PARAM_INT);
            $stmt->bindParam(':es_activo', $esActivo, PDO::PARAM_BOOL);

            $stmt->execute();
            $usuario->setId($db->lastInsertId());
        } catch (Exception $e) {
            /*if ($e instanceof PDOException && $stmt->errorInfo()[0] == 23000 && $stmt->errorInfo()[1] == 1062) {
                $array = explode("'", $stmt->errorInfo()[2]);
                switch ($array[3]) {
                    case 'usuario_unico':
                        throw new BadRequestException("El usuario " . $array[1] . " ya existe.");
                        break;
                }
            } else {
                throw $e;
            }*/
        } finally {
            $stmt = null;
            //$db = null;
            $this->disconnect();
        }
        return $usuario;
    }

    public function update(Usuario $usuario){

        try{
            $consulta = "UPDATE usuarios 
                            SET nombre=:nombre,
                                apellido=:apellido, 
                                usuario=:usuario, 
                                clave=:clave, 
                                perfil=:perfil,
                                laboratorioId=:laboratorioId,
                                es_activo=:es_activo 
                            WHERE id=:id";
            
            $db = $this->connect();
            $stmt = $db->prepare($consulta);

            $id = $usuario->getId();
            $nombre = $usuario->getNombre();
            $apellido = $usuario->getApellido();
            $usuarioNombre = $usuario->getUsuario();
            $clave = $usuario->getClave();
            $perfil = $usuario->getPerfil()->getId(); 
            $laboratorioId = $usuario->getLaboratorioId();           
            $esActivo = $usuario->getActivo();            
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':usuario', $usuarioNombre);
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':perfil', $perfil, PDO::PARAM_INT);
            $stmt->bindParam(':laboratorioId', $laboratorioId, PDO::PARAM_INT);
            $stmt->bindParam(':es_activo', $esActivo, PDO::PARAM_BOOL);

            $stmt->execute();
        } catch (Exception $e) {
            /*if ($e instanceof PDOException && $stmt->errorInfo()[0] == 23000 && $stmt->errorInfo()[1] == 1062) {
                $array = explode("'", $stmt->errorInfo()[2]);
                switch ($array[3]) {
                    case 'usuario_unico':
                        throw new BadRequestException("El usuario " . $array[1] . " ya existe.");
                        break;
                }
            } else {
                throw $e;
            }*/
        } finally {
            $stmt = null;
            $this->disconnect();
        }
    }

    public function getByToken(string $token): ?Usuario {
        $sql = "SELECT u.*, ut.token, ut.expiracion
                FROM usuarios_tokens ut
                LEFT JOIN usuarios u ON ut.usuario = u.id
                WHERE ut.token = :token";

        $db = $this->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $result = $stmt->fetchObject();

        $item = null;
        if ($result != null) {
            $item = new Usuario();
            $item->setId((int)$result->id);
            $item->setUsuario($result->usuario);
            $item->setNombre($result->nombre);
            $item->setApellido($result->apellido);
            $item->setPerfil((new PerfilesRepository())->get($result->perfil));                        
            $item->setToken($result->token);
            $item->setTokenExpire($result->expiracion);
            
        }

        return $item;
    }
    public function getByUsuario(string $usuario): ?Persona
    {
        $sql = "SELECT p.*, u.id as usuario
                FROM personas p
                LEFT JOIN usuarios u ON p.id = u.persona
                WHERE p.es_activo = '1' 
                AND u.usuario=:usuario";

        $db = $this->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $result = $stmt->fetchObject();        
        $item = null;
        if ($result != null) {
            $item = $this->createFromResultset($result, ['*'], $this->db);
        }

        $this->disconnect();
        return $item;
    }

    private function createFromResultset($result, array $fields, $db) {        
        $item = new Persona();
        $item->setId((int)$result->id);
        $item->setNombre($result->nombre);
        $item->setApellido($result->apellido);
        $item->setMail($result->email);
        $item->setTelefono($result->telefono);
        $item->setNroDocumento($result->documento_numero);
        $item->setTipoDocumento((int)$result->documento_tipo);
        $item->setEsUsuario((bool)$result->es_usuario);
        $item->setEsActivo($result->es_activo);
                
        if((in_array('*', $fields) || in_array('usuario', $fields)) && $item->getEsUsuario())
            $item->setUsuario((new UsuarioRepository($db))->get($result->usuario));
        
        return $item;
    }
}