<?php 
    $servername = "localhost";
    $database = "exemplo";
    $username = "root";
    $password = "admin";
    $conexao = mysqli_connect($servername, $username, $password, $database);
	mysqli_set_charset($conexao, "utf8");
    if (!$conexao){
        die("Connection failed: " . mysqli_connect_error());
    }
