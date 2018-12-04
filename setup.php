<?php
require 'config.php';
// open connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//create database
$res = $mysqli->query('create database if not exists iti_blog');
if(!$res){
    echo "database creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
}

//select database
$mysqli->select_db('iti_blog');
if($mysqli->errno){
    echo "database selection failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
}
// create users table
$query = "create table if not exists users(
    id smallint unsigned auto_increment primary key,
    username varchar(20) not null unique,
    pass char(40) not null,
    email varchar(40) not null unique)";
$res = $mysqli->query($query);
if(!$res){
    echo "users table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
}

// create posts table  /****CHANGE HERE *****/
$query = "create table if not exists posts(
    id int unsigned auto_increment primary key,
    user_id smallint unsigned,
    title varchar(100) not null,
    content text not null,
    stamp_created timestamp default now(), 
    stamp_updated timestamp default now() on update now(), 
    foreign key (user_id) references users(id) on delete cascade
    )";
$res = $mysqli->query($query);
if(!$res){
    echo "posts table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
}

// create table comments /******* CHHHANNGEE HEEEREEE TOOO *******/
$query = "create table if not exists comments(
    id int unsigned auto_increment primary key,
    user_id smallint unsigned,
    post_id int unsigned,
    title varchar(100) not null,
    content text not null,
    stamp_created timestamp default now(), 
    foreign key (user_id) references users(id) on delete cascade,
    foreign key (post_id) references posts(id) on delete cascade
    )";
$res = $mysqli->query($query);
if(!$res){
    echo "comments table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
}
$mysqli->close();
?>
