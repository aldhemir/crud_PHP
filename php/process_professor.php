<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));

$id = 0;
$nome = '';
$data_nascimento = '';
$alterar = false;

if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];

    $mysqli->query("INSERT INTO PROFESSOR (NOME, DATA_NASCIMENTO) VALUES ('$nome', '$data_nascimento')") or
            die($mysqli->error);

    $_SESSION['message'] = "Professor salvo!";
    $_SESSION['msg_type'] = "success";

    header("location: crud_professor.php");
}

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM PROFESSOR WHERE ID_PROFESSOR=$id") or die($mysqli->error);

    $_SESSION['message'] = "Professor deletado!";
    $_SESSION['msg_type'] = "danger";

    header("location: crud_professor.php");
}

if (isset($_POST['editar'])) {
    
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];

    $mysqli->query("UPDATE PROFESSOR SET NOME='$nome', DATA_NASCIMENTO='$data_nascimento' WHERE ID_PROFESSOR=$id") or 
            die($mysqli->error);
    
    $_SESSION['message'] = "Professor alterado!";
    $_SESSION['msg_type'] = "warning";

    header("location: crud_professor.php");
}

if (isset($_GET['editar'])) {

    $id = $_GET['editar'];
    $alterar = true;
    $result = $mysqli->query("SELECT * FROM PROFESSOR WHERE ID_PROFESSOR=$id") or die($mysqli->error);
   
    if (!is_array($result)) {
        $row = $result->fetch_array();
        $nome = $row['NOME'];
        $data_nascimento = $row['DATA_NASCIMENTO'];
    }
}