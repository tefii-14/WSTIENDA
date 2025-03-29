<?php
require_once 'Conexion.php';

class Usuario extends Conexion {
    private $conexion;

    public function __construct() {
        $this->conexion = parent::getConexion();
    }

    // Obtener todos los usuarios
    public function getAll(): array {
        try {
            $sql = "SELECT id_usuario, nombre_completo, nombre_usuario, telefono, email, contraseña, fecha_creacion FROM usuarios ORDER BY id_usuario DESC";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    // Obtener un usuario por ID
    public function getById($id_usuario): array {
        try {
            $sql = "SELECT id_usuario, nombre_completo, nombre_usuario, telefono, email, contraseña, fecha_creacion FROM usuarios WHERE id_usuario = ?";
            $query = $this->conexion->prepare($sql);
            $query->execute([$id_usuario]);
            return $query->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    // Verificar si un usuario ya existe
    private function usuarioExiste($nombre_usuario, $telefono, $email): bool {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios WHERE nombre_usuario = ? OR telefono = ? OR email = ?";
            $query = $this->conexion->prepare($sql);
            $query->execute([$nombre_usuario, $telefono, $email]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total'] > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // Agregar un usuario (sin encriptar la contraseña)
    public function add($params = []): array {
        try {
            if ($this->usuarioExiste($params["nombre_usuario"], $params["telefono"], $params["email"])) {
                return ['status' => false, 'msg' => 'El usuario, teléfono o email ya están registrados.'];
            }
    
            $sql = "INSERT INTO usuarios (nombre_completo, nombre_usuario, telefono, email, contraseña) VALUES (?, ?, ?, ?, ?)";
            $query = $this->conexion->prepare($sql);
            $query->execute([
                $params["nombre_completo"],
                $params["nombre_usuario"],
                $params["telefono"],
                $params["email"],
                $params["contraseña"]
            ]);
    
            return ['status' => true, 'msg' => 'Usuario registrado exitosamente.'];
        } catch (Exception $e) {
            return ['status' => false, 'msg' => 'Error al registrar: ' . $e->getMessage()];
        }
    }    

    // Iniciar sesión (sin encriptar contraseñas)
    public function login($nombre_usuario, $contraseña): array {
        try {
            $sql = "SELECT id_usuario, nombre_usuario, contraseña FROM usuarios WHERE nombre_usuario = ?";
            $query = $this->conexion->prepare($sql);
            $query->execute([$nombre_usuario]);
            $usuario = $query->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return ['status' => false, 'msg' => 'Usuario no encontrado'];
            }

            // Comparar la contraseña en texto plano
            if ($contraseña === $usuario['contraseña']) {
                return [
                    'status' => true, 
                    'msg' => 'Inicio de sesión exitoso', 
                    'id_usuario' => $usuario['id_usuario']
                ];
            } else {
                return ['status' => false, 'msg' => 'Credenciales incorrectas'];
            }
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }
}