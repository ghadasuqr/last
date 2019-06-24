<?php
try{
    $host="localhost";
    $db="projectcopy";
    $user="root";
    $password="";
    $conn= new PDO("mysql:host=$host;dbname=$db" ,$user,$password);
    $conn->query("SET NAMES utf8"); 
    $conn->query("SET CHARACTER SET utf8");  
    }catch(PDOException $ex ){
     
        echo "Error !".$ex;
    
    
    }

    ?>