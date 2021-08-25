<?php

require_once 'conexion.php';

class usuario extends conexion
{
    public $id = null;
    public $name;
    public $last_name;
    public $email;
    public $phone;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users where deleted=0;");
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
        $stmt = null;
    }


    public function save()
    {
        $query = '';
        $params = [];
        if ($this->id != null) {
            $query = "UPDATE users SET name =?, last_name=?, email=?, phone=? where id = ?";
            $params = [$this->name, $this->last_name, $this->email, $this->phone, $this->id];
        } else {
            $query = "INSERT INTO users(name,last_name,email,phone) VALUES (?,?,?,?)";
            $params = [$this->name, $this->last_name, $this->email, $this->phone];
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }

    public function getUser($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users where id=? AND deleted=0;");
        $stmt->execute([$id]);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->id = $arr[0]['id'];
        $this->name = $arr[0]['name'];
        $this->last_name = $arr[0]['last_name'];
        $this->email = $arr[0]['email'];
        $this->phone = $arr[0]['phone'];
        $stmt = null;
        return $arr[0];
    }

    public function delete_user()
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users set deleted=1 WHERE id=?;");
            $stmt->execute([$this->id]);
            $stmt = null;
            return true;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
