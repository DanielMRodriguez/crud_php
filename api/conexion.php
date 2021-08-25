<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class conexion
{
    private $usuario;
    private $password;
    private $host;
    private $db;
    public $pdo;
    public function __construct()
    {
        $this->usuario = $_SERVER['DB_USER'];
        $this->password = $_SERVER['DB_PASSWORD'];
        $this->host = $_SERVER['DB_HOST'];
        $this->db = $_SERVER['DB_NAME'];
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->usuario, $this->password, $opciones);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
