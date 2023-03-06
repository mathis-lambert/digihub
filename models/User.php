<?php

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    public function __construct($id, $name, $email, $password, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM users');

        foreach ($req->fetchAll() as $user) {
            $list[] = new User($user['id'], $user['name'], $user['email'], $user['password'], $user['created_at'], $user['updated_at']);
        }

        return $list;
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM users WHERE id = :id');
        $req->execute(array('id' => $id));
        $user = $req->fetch();

        return new User($user['id'], $user['name'], $user['email'], $user['password'], $user['created_at'], $user['updated_at']);
    }

    public static function create($name, $email, $password)
    {
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $req->execute(array('name' => $name, 'email' => $email, 'password' => $password));
    }

    public static function update($id, $name, $email, $password)
    {
        $db = Db::getInstance();
        $req = $db->prepare('UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id');
        $req->execute(array('id' => $id, 'name' => $name, 'email' => $email, 'password' => $password));
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $id = intval($id);
        $req = $db->prepare('DELETE FROM users WHERE id = :id');
        $req->execute(array('id' => $id));
    }
}
