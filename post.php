<?php
class post{
    private $id;
    private $user_id;
    private $title;
    private $content;

    function __get($name){
        return $this->$name;
    }

    function __set($name,$value){
        $this->$name = $value;
    }

    function insert() {
        require 'config.php';

        $query = "insert into posts(user_id, title, content) values(?,?,?)";

        $stmt = $mysqli->prepare($query);

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        $user_id = $this->user_id;
        $title = $this->title;
        $content = $this->content;

        $stmt->bind_param('iss', $user_id, $title, $content);

        $stmt->execute();

        if($stmt->affected_rows > 0) {
            $this->id=$stmt->insert_id;
            return $this;
        }
        else {
            return false;
        } 
    }

    function delete($id, $user_id) {
        require 'config.php';
    
        $query = "delete from posts where id = ? and user_id = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('ii', $id, $user_id);

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

        $query = "select * from posts where id = ?";

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
            $this->user_id = $obj->user_id;
            $this->title = $obj->title;
            $this->content = $obj->content;
            $this->stamp_created = $obj->stamp_created;
            $this->stamp_updated = $obj->stamp_updated;
            return $this;
        }
        else {
            return false;
        }
    }

    function selectbyidanduserid($id, $user_id) {
        require 'config.php';

        $query = "select * from posts where id = ? and user_id = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('ii', $id, $user_id);

        $stmt->execute();

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        $result = $stmt->get_result();
        $obj = $result->fetch_object();

        if($obj) {
            $this->id = $obj->id;
            $this->user_id = $obj->user_id;
            $this->title = $obj->title;
            $this->content = $obj->content;
            $this->stamp_created = $obj->stamp_created;
            $this->stamp_updated = $obj->stamp_updated;
            return $this;
        }
        else {
            return false;
        }
    }

    function selectbyuser($user_id) {
        require 'config.php';

        $query = "select * from posts where user_id = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('i', $user_id);

        $stmt->execute();

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
            exit;
        }

        $result = $stmt->get_result();

        $posts = [];
        if($result) {
            while($obj = $result->fetch_object()) {
                array_push($posts, $obj);
            }
            return $posts;
        }
        else {
            return false;
        }
    }


    function update() {
        require 'config.php';

        $query = "update posts set title=?, content=? where id=? and user_id=?";

        $stmt = $mysqli->prepare($query);

        $id = $this->id;
        $user_id = $this->user_id;
        $title = $this->title;
        $content = $this->content;

        $stmt->bind_param('ssii', $title, $content, $id, $user_id);

        $stmt->execute();

        $query = "select * from posts where id = ? and user_id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ii', $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = $result->fetch_object();
        

        if($stmt->affected_rows > 0) {
            echo "post successfully updated";
            $this->stamp_created = $obj->stamp_created;
            $this->stamp_updated = $obj->stamp_updated;
            return $this;
        }
        else {
            return false;
        }
    }

    function selectAll() {
        require 'config.php';

        $query = "select * from posts";
        $stmt = $mysqli->prepare($query);

        if(!$stmt){
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        } 
        
        $stmt->execute();

        $result = $stmt->get_result();

        $posts = [];
        if($result) {
            while($obj = $result->fetch_object()) {
                array_push($posts, $obj);
            }
            return $posts;
        }
        else {
            return false;
        }
    }

}

 ?>
