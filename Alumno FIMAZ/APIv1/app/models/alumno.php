<?php
// models/AlumnoModel.php

require_once('./config.php');

class alumno {

    private $PDO;

    //Tabla de la base de datos que se utiliza
    private $tabla = "alumno";

    public function __construct()
    {
        $conn = new connection();
        $this->PDO = $conn->getConnection();
    }

    public function __destruct()
    {
        $this->PDO = null;
    }

    //Validar credenciales del usuario (Matricula y NIP)
    public function validarCredenciales($matricula, $nip){
        $query = "SELECT matricula, nip FROM ".$this->tabla ." WHERE matricula =:matricula AND nip =:nip";
        $stmt= $this->PDO->prepare($query);

        $stmt->bindParam(":matricula",$matricula);
        $stmt->bindParam(":nip",$nip);

        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario;
    }


    //Extraer datos del usuario por su matrícula
    public function obtenerDatosUsuario($matricula){
        $query = "SELECT * FROM ".$this->tabla." WHERE matricula =:matricula";
    
        $stmt = $this->PDO->prepare($query);
    
        $stmt->bindParam(":matricula", $matricula);
    
        $stmt->execute();
    
        $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuario;
        }
    
        //Actulizar los datos del usuario en la base de datos
        public function actualizarDatosUsuarioModel($nuevosDatos){
            //Convertir el JSON a un array asociativo
            //$datos = json_decode($nuevosDatos, true);
        
            if (!$nuevosDatos) {
                // Devolver un mensaje de error si el JSON es inválido
                return "Error: JSON inválido.";
            }
        
            // Extraer los datos del array
            $matricula = $nuevosDatos['matricula'] ?? null;
            $direccion = $nuevosDatos['direccion'] ?? null;
            $colonias = $nuevosDatos['colonias'] ?? null;
            $CP = $nuevosDatos['CP'] ?? null;
            $poblacion = $nuevosDatos['poblacion'] ?? null;
            $localidad = $nuevosDatos['localidad'] ?? null;
            $celular = $nuevosDatos['celular'] ?? null;
            $correo = $nuevosDatos['correo'] ?? null;
        
            if (!$matricula) {
                // Devolver un mensaje de error si no se proporciona la matrícula
                return "Error: Matrícula no proporcionada.";
            }
        
            $query = "UPDATE ".$this->tabla." SET direccion = :direccion, colonias = :colonias, CP = :CP, poblacion = :poblacion, localidad = :localidad, celular = :celular, correo = :correo WHERE matricula = :matricula";
        
            try {
                $this->PDO->beginTransaction();
        
                $stmt = $this->PDO->prepare($query);
        
                // Bind de parámetros
                $stmt->bindParam(":matricula", $matricula);
                $stmt->bindParam(":direccion", $direccion);
                $stmt->bindParam(":colonias", $colonias);
                $stmt->bindParam(":CP", $CP);
                $stmt->bindParam(":poblacion", $poblacion);
                $stmt->bindParam(":localidad", $localidad);
                $stmt->bindParam(":celular", $celular);
                $stmt->bindParam(":correo", $correo);
        
                $stmt->execute();
        
                $this->PDO->commit();
        
                // Verificar si la consulta fue exitosa
                if ($stmt->rowCount() > 0) {
                    // Si la actualización fue exitosa, devolver un mensaje de éxito
                    return "Actualización de datos con matrícula $matricula se realizó correctamente.";
                } else {
                    // Si no se actualizó ningún registro, devolver un mensaje indicando que no se encontró el usuario
                    return "No se encontró ningún usuario con la matrícula $matricula.";
                }
            } catch (PDOException $e) {
                // Manejar errores de base de datos
                $this->PDO->rollBack();
                return "Error al actualizar los datos: " . $e->getMessage();
            }
        }



}
?>
