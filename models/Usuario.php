<?php

namespace Model;

class Usuario extends ActiveRecord
{
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'confirmado', 'admin', 'telefono', 'email', 'token', 'password'];

    public $id;
    public $nombre;
    public $apellido;
    public $confirmado;
    public $admin;
    public $telefono;
    public $email;
    public $token;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->admin = $args['admin'] ?? '0';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validarNuevaCuenta()
    {

        if (!$this->nombre) {
            self::$alertas['error'][] = "El Nombre del cliente es obligatorio";
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido del cliente es Obligatorio';
        }

        if (!$this->telefono) {
            self::$alertas['error'][] = 'El Teléfono del cliente es obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del cliente es obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña del cliente es obligatoria';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }

        return self::$alertas;
    }
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }


    //Revisa si el usuario ya existe
    public function existeUsuario()
    {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        };
        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password)
    {
        $resultado = password_verify($password, $this->password);
        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }
}
