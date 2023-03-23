<?php
$usuario SERVIDOR = "localhost:3306";

$senha BANCO = "imc-master";

$database USUARIO = "";

$host SENHA = "root";

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli->error) {
    die("fanha ao conctar" . $mysqli->error);
}
else{
    echo"fai";
}