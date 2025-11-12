<?php
require_once "../library/conexion.php";

class Api {
    private $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    
    

    /**
     * Obtener todos los hoteles con sus habitaciones
     */
    public function obtenerTodosHoteles() {
        $sql = $this->conexion->query("
            SELECT 
                h.hotel_id as id,
                h.nombre,
                h.ciudad as ubicacion,
                h.descripcion,
                h.direccion,
                h.telefono,
                h.email_contacto,
                h.categoria
            FROM hoteles h
            ORDER BY h.nombre ASC
        ");
        
        $hoteles = [];
        while ($hotel = $sql->fetch_object()) {
            // Obtener habitaciones de cada hotel
            $habitaciones = $this->obtenerHabitacionesPorHotel($hotel->id);
            
            $hoteles[] = array(
                'id' => (int)$hotel->id,
                'nombre' => $hotel->nombre,
                'ubicacion' => $hotel->ubicacion,
                'descripcion' => $hotel->descripcion,
                'direccion' => $hotel->direccion ?? '',
                'telefono' => $hotel->telefono ?? '',
                'email' => $hotel->email_contacto ?? '',
                'categoria' => (int)$hotel->categoria,
                'habitaciones' => $habitaciones
            );
        }
        
        return $hoteles;
    }
    
    /**
     * Obtener hotel por ID
     */
    public function obtenerHotelPorId($hotel_id) {
        $stmt = $this->conexion->prepare("
            SELECT 
                hotel_id as id,
                nombre,
                ciudad as ubicacion,
                descripcion,
                direccion,
                telefono,
                email_contacto,
                categoria
            FROM hoteles 
            WHERE hotel_id = ?
        ");
        
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($hotel = $result->fetch_object()) {
            return array(
                'id' => (int)$hotel->id,
                'nombre' => $hotel->nombre,
                'ubicacion' => $hotel->ubicacion,
                'descripcion' => $hotel->descripcion,
                'direccion' => $hotel->direccion ?? '',
                'telefono' => $hotel->telefono ?? '',
                'email' => $hotel->email_contacto ?? '',
                'categoria' => (int)$hotel->categoria
            );
        }
        
        return null;
    }
    
    /**
     * Obtener habitaciones por hotel
     */
    public function obtenerHabitacionesPorHotel($hotel_id) {
        $stmt = $this->conexion->prepare("
            SELECT 
                h.id,
                h.tipo,
                h.capacidad,
                h.precio_noche as precio,
                h.moneda,
                h.cantidad_disponible,
                h.fecha
            FROM habitaciones h
            WHERE h.hotel_id = ?
            ORDER BY h.precio_noche ASC
        ");
        
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $habitaciones = [];
        while ($hab = $result->fetch_object()) {
            // Obtener servicios de la habitación
            $servicios = $this->obtenerServiciosPorHabitacion($hab->id);
            
            $habitaciones[] = array(
                'id' => (int)$hab->id,
                'tipo' => $hab->tipo,
                'capacidad' => $hab->capacidad ?? '',
                'precio' => (float)$hab->precio,
                'moneda' => $hab->moneda ?? 'EUR',
                'disponible' => ((int)$hab->cantidad_disponible > 0),
                'cantidad_disponible' => (int)$hab->cantidad_disponible,
                'servicios' => $servicios
            );
        }
        
        return $habitaciones;
    }
    
    /**
     * Obtener servicios por habitación (relación muchos a muchos)
     */
    private function obtenerServiciosPorHabitacion($habitacion_id) {
        // Asumiendo que tienes una tabla intermedia habitaciones_servicios
        $sql = $this->conexion->query("
            SELECT s.nombre
            FROM servicios s
            INNER JOIN hoteles_servicios hs ON s.servicio_id = hs.servicio_id
            INNER JOIN habitaciones h ON hs.hotel_id = h.hotel_id
            WHERE h.id = {$habitacion_id}
        ");
        
        $servicios = [];
        while ($servicio = $sql->fetch_object()) {
            $servicios[] = $servicio->nombre;
        }
        
        // Si no hay servicios, retornar servicios por defecto
        if (empty($servicios)) {
            $servicios = ['Wi-Fi', 'Aire acondicionado'];
        }
        
        return $servicios;
    }
    
    /**
     * Buscar hoteles por nombre o ubicación (ciudad)
     */
    public function buscarHotelesPorNombre($termino) {
        $termino = '%' . $termino . '%';
        
        $stmt = $this->conexion->prepare("
            SELECT 
                h.hotel_id as id,
                h.nombre,
                h.ciudad as ubicacion,
                h.descripcion,
                h.direccion,
                h.telefono,
                h.email_contacto,
                h.categoria
            FROM hoteles h
            WHERE h.nombre LIKE ? OR h.ciudad LIKE ?
            ORDER BY h.nombre ASC
        ");
        
        $stmt->bind_param("ss", $termino, $termino);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $hoteles = [];
        while ($hotel = $result->fetch_object()) {
            $habitaciones = $this->obtenerHabitacionesPorHotel($hotel->id);
            
            $hoteles[] = array(
                'id' => (int)$hotel->id,
                'nombre' => $hotel->nombre,
                'ubicacion' => $hotel->ubicacion,
                'descripcion' => $hotel->descripcion,
                'direccion' => $hotel->direccion ?? '',
                'telefono' => $hotel->telefono ?? '',
                'email' => $hotel->email_contacto ?? '',
                'categoria' => (int)$hotel->categoria,
                'habitaciones' => $habitaciones
            );
        }
        
        return $hoteles;
    }
    
    /**
     * Buscar habitaciones por tipo con información del hotel
     */
    public function buscarHabitacionesPorTipo($tipo) {
        $tipo = '%' . $tipo . '%';
        
        $stmt = $this->conexion->prepare("
            SELECT 
                h.hotel_id,
                h.nombre as hotel_nombre,
                h.ciudad as hotel_ubicacion,
                hab.id as habitacion_id,
                hab.tipo,
                hab.capacidad,
                hab.precio_noche as precio,
                hab.moneda,
                hab.cantidad_disponible
            FROM habitaciones hab
            INNER JOIN hoteles h ON hab.hotel_id = h.hotel_id
            WHERE hab.tipo LIKE ?
            ORDER BY hab.precio_noche ASC
        ");
        
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $habitaciones = [];
        while ($row = $result->fetch_object()) {
            $servicios = $this->obtenerServiciosPorHabitacion($row->habitacion_id);
            
            $habitaciones[] = array(
                'hotel' => array(
                    'id' => (int)$row->hotel_id,
                    'nombre' => $row->hotel_nombre,
                    'ubicacion' => $row->hotel_ubicacion
                ),
                'habitacion' => array(
                    'id' => (int)$row->habitacion_id,
                    'tipo' => $row->tipo,
                    'capacidad' => $row->capacidad ?? '',
                    'precio' => (float)$row->precio,
                    'moneda' => $row->moneda ?? 'EUR',
                    'disponible' => ((int)$row->cantidad_disponible > 0),
                    'cantidad_disponible' => (int)$row->cantidad_disponible,
                    'servicios' => $servicios
                )
            );
        }
        
        return $habitaciones;
    }
    
    /**
     * Buscar hoteles combinando nombre + tipo de habitación
     */
    public function buscarHotelesNombreHabitacion($nombre, $tipo_habitacion) {
        $nombre = '%' . $nombre . '%';
        $tipo_habitacion = '%' . $tipo_habitacion . '%';
        
        $stmt = $this->conexion->prepare("
            SELECT DISTINCT
                h.hotel_id as id,
                h.nombre,
                h.ciudad as ubicacion,
                h.descripcion,
                h.direccion,
                h.telefono,
                h.email_contacto,
                h.categoria
            FROM hoteles h
            INNER JOIN habitaciones hab ON h.hotel_id = hab.hotel_id
            WHERE (h.nombre LIKE ? OR h.ciudad LIKE ?)
            AND hab.tipo LIKE ?
            ORDER BY h.nombre ASC
        ");
        
        $stmt->bind_param("sss", $nombre, $nombre, $tipo_habitacion);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $hoteles = [];
        while ($hotel = $result->fetch_object()) {
            $habitaciones = $this->obtenerHabitacionesPorHotel($hotel->id);
            
            $hoteles[] = array(
                'id' => (int)$hotel->id,
                'nombre' => $hotel->nombre,
                'ubicacion' => $hotel->ubicacion,
                'descripcion' => $hotel->descripcion,
                'direccion' => $hotel->direccion ?? '',
                'telefono' => $hotel->telefono ?? '',
                'email' => $hotel->email_contacto ?? '',
                'categoria' => (int)$hotel->categoria,
                'habitaciones' => $habitaciones
            );
        }
        
        return $hoteles;
    }
    
    /**
     * Obtener todos los servicios disponibles
     */
    public function obtenerServicios() {
        $sql = $this->conexion->query("
            SELECT 
                servicio_id as id,
                nombre
            FROM servicios
            ORDER BY nombre ASC
        ");
        
        $servicios = [];
        while ($servicio = $sql->fetch_object()) {
            $servicios[] = array(
                'id' => (int)$servicio->id,
                'nombre' => $servicio->nombre
            );
        }
        
        return $servicios;
    }

  public function validarEstadoCliente($id_cliente) {
    // Verificar que el ID sea numérico
    $id_cliente = intval($id_cliente);

    // Consultar el estado del cliente
    $sql = $this->conexion->query("SELECT estado FROM client_api WHERE id = '$id_cliente'");

    // Verificar si hay resultados válidos
    if ($sql && $sql->num_rows > 0) {
        $sql = $sql->fetch_object();
        return $sql->estado; // 1 = activo, 0 = inactivo
    } else {
        // Si no se encontró el cliente o hubo error, devolver 0 (inactivo)
        return 0;
    }
    
}

    
}
?>