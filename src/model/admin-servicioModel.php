<?php
require_once "../library/conexion.php";

class ServicioModel
{
    private $conexion;
    
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }

    /**
     * Registrar un servicio global (sin hotel específico)
     * y asociarlo a un hotel a través de la tabla intermedia
     */
    public function registrarServicio($id_hotel, $nombre)
    {
        // Primero verificar si el servicio ya existe globalmente
        $stmt = $this->conexion->prepare("SELECT servicio_id FROM servicios WHERE nombre = ?");
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            // El servicio ya existe, obtener su ID
            $row = $resultado->fetch_object();
            $servicio_id = $row->servicio_id;
        } else {
            // Crear nuevo servicio global
            $stmt = $this->conexion->prepare("INSERT INTO servicios (nombre) VALUES (?)");
            $stmt->bind_param('s', $nombre);
            
            if ($stmt->execute()) {
                $servicio_id = $this->conexion->insert_id;
            } else {
                return 0;
            }
        }
        
        // Verificar si ya existe la relación hotel-servicio
        $stmt = $this->conexion->prepare("SELECT id FROM hoteles_servicios WHERE hotel_id = ? AND servicio_id = ?");
        $stmt->bind_param('ii', $id_hotel, $servicio_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            // La relación ya existe
            return $servicio_id;
        }
        
        // Asociar el servicio al hotel
        $stmt = $this->conexion->prepare("INSERT INTO hoteles_servicios (hotel_id, servicio_id) VALUES (?, ?)");
        $stmt->bind_param('ii', $id_hotel, $servicio_id);
        
        if ($stmt->execute()) {
            return $servicio_id;
        } else {
            return 0;
        }
    }

    /**
     * Eliminar la asociación entre un hotel y un servicio
     * (No elimina el servicio global, solo la relación)
     */
    public function eliminarServicio($id_servicio, $id_hotel = null)
    {
        if ($id_hotel !== null) {
            // Eliminar solo la relación hotel-servicio
            $stmt = $this->conexion->prepare("DELETE FROM hoteles_servicios WHERE servicio_id = ? AND hotel_id = ?");
            $stmt->bind_param('ii', $id_servicio, $id_hotel);
        } else {
            // Eliminar todas las relaciones de este servicio
            $stmt = $this->conexion->prepare("DELETE FROM hoteles_servicios WHERE servicio_id = ?");
            $stmt->bind_param('i', $id_servicio);
        }
        
        $resultado = $stmt->execute();
        
        if ($resultado === false) {
            return false;
        }
        
        $filasAfectadas = $stmt->affected_rows;
        $stmt->close();
        
        return $filasAfectadas > 0;
    }

    /**
     * Listar servicios asociados a un hotel específico
     */
    public function listarServiciosHotel($idHotel)
    {
        $arrRespuesta = array();
        
        $stmt = $this->conexion->prepare("
            SELECT 
                s.servicio_id,
                s.nombre,
                hs.id as relacion_id,
                hs.hotel_id
            FROM servicios s
            INNER JOIN hoteles_servicios hs ON s.servicio_id = hs.servicio_id
            WHERE hs.hotel_id = ?
            ORDER BY s.nombre ASC
        ");
        
        $stmt->bind_param('i', $idHotel);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        while ($objeto = $resultado->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        
        return $arrRespuesta;
    }

    /**
     * Buscar un servicio por su ID
     */
    public function buscarServicioById($id)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM servicios WHERE servicio_id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_object();
        }
        
        return null;
    }

    /**
     * Actualizar el nombre de un servicio
     */
    public function actualizarServicio($id_servicio, $nombre)
    {
        $stmt = $this->conexion->prepare("UPDATE servicios SET nombre = ? WHERE servicio_id = ?");
        $stmt->bind_param('si', $nombre, $id_servicio);
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    /**
     * Listar todos los servicios disponibles (globales)
     */
    public function listarTodosServicios()
    {
        $arrRespuesta = array();
        
        $sql = $this->conexion->query("
            SELECT servicio_id, nombre 
            FROM servicios 
            ORDER BY nombre ASC
        ");
        
        while ($objeto = $sql->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        
        return $arrRespuesta;
    }

    /**
     * Verificar si un servicio está asociado a un hotel
     */
    public function verificarServicioEnHotel($id_servicio, $id_hotel)
    {
        $stmt = $this->conexion->prepare("
            SELECT COUNT(*) as total 
            FROM hoteles_servicios 
            WHERE servicio_id = ? AND hotel_id = ?
        ");
        
        $stmt->bind_param('ii', $id_servicio, $id_hotel);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_object();
        
        return $row->total > 0;
    }

    /**
     * Obtener hoteles que tienen un servicio específico
     */
    public function obtenerHotelesPorServicio($id_servicio)
    {
        $arrRespuesta = array();
        
        $stmt = $this->conexion->prepare("
            SELECT 
                h.hotel_id,
                h.nombre
            FROM hoteles h
            INNER JOIN hoteles_servicios hs ON h.hotel_id = hs.hotel_id
            WHERE hs.servicio_id = ?
            ORDER BY h.nombre ASC
        ");
        
        $stmt->bind_param('i', $id_servicio);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        while ($objeto = $resultado->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        
        return $arrRespuesta;
    }
}
?>