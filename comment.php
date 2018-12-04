<?php
class comment{
    private $id;
    private $user_id;
    private $post_id;
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

        $query = "insert into comments(user_id, post_id, title, content) values(?,?,?,?)";

        $stmt = $mysqli->prepare($query);

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        }

        $user_id = $this->user_id;
        $post_id = $this->post_id;
        $title = $this->title;
        $content = $this->content;

        $stmt->bind_param('iiss', $user_id, $post_id, $title, $content);

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
    
        $query = "delete from comments where id = ? and user_id = ?";

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

        $query = "select * from comments where id = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('s', $id);

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
            return $this;
        }
        else {
            return false;
        }
    }

    
    function selectbypost($post_id) {
        require 'config.php';

        $query = "select * from comments where post_id = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('i', $post_id);

        $stmt->execute();

        if(!$stmt) {
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
            exit;
        }

        $result = $stmt->get_result();

        $comments = [];
        if($result) {
            while($obj = $result->fetch_object()) {
                array_push($comments, $obj);
            }
            return $comments;
        }
        else {
            return false;
        }
    }


    function update() {
        require 'config.php';

        $query = "update comments set title=?, content=? where id=? and user_id=?";

        $stmt = $mysqli->prepare($query);

        $id = $this->id;
        $user_id = $this->user_id;
        $title = $this->title;
        $content = $this->content;

        $stmt->bind_param('ssii', $title, $content, $id, $user_id);

        $stmt->execute();

        $query = "select * from comments where id = ? and user_id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ii', $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = $result->fetch_object();
        

        if($stmt->affected_rows > 0) {
            echo "post successfully updated";
            $this->stamp_created = $obj->stamp_created;
            return $this;
        }
        else {
            return false;
        }
    }

    function selectAll() {
        require 'config.php';

        $query = "select * from comments";
        $stmt = $mysqli->prepare($query);

        if(!$stmt){
            echo "preparation failed ".$mysqli->errno." : ".$mysqli->error."<br>";
        } 
        
        $stmt->execute();

        $result = $stmt->get_result();

        $comments = [];
        if($result) {
            while($obj = $result->fetch_object()) {
                array_push($comments, $obj);
            }
            return $comments;
        }
        else {
            return false;
        }
    }

}

 ?>
