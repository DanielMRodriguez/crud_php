<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . './.env');

class conexion
{
    private $usuario;
    private $password;
    private $host;
    private $db;
    public $pdo;
    public function __construct()
    {
        $this->usuario = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->host = $_ENV['DB_HOST'];
        $this->db = $_ENV['DB_NAME'];
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
