<?php
session_start();
// mysqli database connection

const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_NAME = "pictogram";

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Can't Connect to Data Base!");

$table_posts = "CREATE TABLE IF NOT EXISTS posts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    post_img TEXT NOT NULL,
    post_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";
mysqli_query($db, $table_posts);

$table_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    gender INT(11) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password TEXT NOT NULL,
    profile_pic VARCHAR(255) NOT NULL DEFAULT 'default_profile.jpg',
    create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ac_status INT(11) NOT NULL,
    PRIMARY KEY (id)
);";

mysqli_query($db, $table_users);



$table_follower_list = "CREATE TABLE IF NOT EXISTS follow_list
(`id` INT NOT NULL AUTO_INCREMENT ,
 `follower_id` INT NOT NULL , 
 `user_id` INT NOT NULL , 
 PRIMARY KEY (`id`)
 );";
mysqli_query($db, $table_follower_list);


$table_likes = "CREATE TABLE IF NOT EXISTS likes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    post_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    PRIMARY KEY (id)
);";
mysqli_query($db, $table_likes);

$table_comments = "CREATE TABLE IF NOT EXISTS comments (
    id INT(11) NOT NULL AUTO_INCREMENT,
    post_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";
mysqli_query($db, $table_comments);

$table_block = "CREATE TABLE IF NOT EXISTS `block` (
id INT(11) NOT NULL AUTO_INCREMENT,
user_id INT(11) NOT NULL,
blocked_id INT(11) NOT NULL,
PRIMARY KEY (id)
);";
mysqli_query($db, $table_block);



$notification_table = "CREATE TABLE IF NOT EXISTS`notification` (
`id` INT NOT NULL AUTO_INCREMENT ,
`user_id` INT NOT NULL ,
`sub` VARCHAR(255) NOT NULL ,
`disc` VARCHAR(255) NOT NULL ,
`follower_id` INT NOT NULL ,
`read_status` INT NOT NULL DEFAULT '0' ,
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
);";
mysqli_query($db, $notification_table);
