<?php
class user{
    private $id;
    private $username;
    private $pass;
    private $email;

    function __get($name){
        return $this->$name;
    }

    function __set($name,$value){
        $this->$name = $value;
    }

    function insert() {
        require 'config.php';

        $query = "insert into users(username, pass, email) values(?,?,?)";

        $stmt = $mysqli->prepare($query);

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        $username = $this->username;
        $pass = $this->pass;
        $email = $this->email;

        $stmt->bind_param('sss', $username, $pass, $email);

        $stmt->execute();

        if($stmt->affected_rows > 0) {
            $this->id=$stmt->insert_id;
            return $this;
        }
        else {
            return false;
        } 
    }

    function delete() {
        require 'config.php';
    
        $query = "delete from users where id = ?";

        $stmt = $mysqli->prepare($query);

        $id = $this->id;

        $stmt->bind_param('i', $id);

        $stmt->execute();

        if(!$stmt){
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        if($stmt->affected_rows > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    function selectbyid($id) {
        require 'config.php';

        $query = "select * from users where id = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('i', $id);

        $stmt->execute();

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        $result = $stmt->get_result();
        $obj = $result->fetch_object();

        if($obj) {
            $this->id = $obj->id;
            $this->username = $obj->username;
            $this->pass = $obj->pass;
            $this->email = $obj->email;
            return $this;
        }
        else {
            return false;
        }
    }

    function selectbyname($username) {
        require 'config.php';

        $query = "select * from users where username = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('s', $username);

        $stmt->execute();

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        $result = $stmt->get_result();
        $obj = $result->fetch_object();

        if($obj) {
            $this->id = $obj->id;
            $this->username = $obj->username;
            $this->pass = $obj->pass;
            $this->email = $obj->email;
            return $this;
        }
        else {
            return false;
        }
    }

    function update() {
        require 'config.php';

        $query = "update users set username=?, pass=?, email=? where id=?";

        $stmt = $mysqli->prepare($query);

        $id = $this->id;
        $username = $this->username;
        $pass = $this->pass;
        $email = $this->email;

        $stmt->bind_param('sssi', $username, $pass, $email, $id);

        $stmt->execute();

        $query = "select * from users where id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = $result->fetch_object();
        

        if($stmt->affected_rows > 0) {
            echo "user successfully updated";
            return $this;
        }
        else {
            return false;
        }
    }

    function selectAll() {
        require 'config.php';

        $query = "select * from users";
        $stmt = $mysqli->prepare($query);

        if(!$stmt){
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        } 
        
        $stmt->execute();

        $result = $stmt->get_result();

        $users = [];
        if($result) {
            while($obj = $result->fetch_object()) {
                array_push($users, $obj);
            }
            return $users;
        }
        else {
            return false;
        }
    }

    function login() {
        require 'config.php';

        $query = "select * from users where username = ? and pass = ?";

        $stmt = $mysqli->prepare($query);
        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        $username = $this->username;
        $pass =  $this->pass;

        $stmt->bind_param('ss', $username, $pass);
        
        $stmt->execute();

        $result = $stmt->get_result();
        $obj = $result->fetch_object('user');

        if($obj){
            $this->id = $obj->id;
            $this->username = $obj->username;
            $this->pass = $obj->pass;
            $this->email = $obj->email;
            return $this;
        }
        else {
            return false;
        }
    }


}

 ?>
