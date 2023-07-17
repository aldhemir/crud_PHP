<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));

$id = 0;
$id_curso = '';
$nome = '';
$data_nascimento = '';
$logradouro = '';
$numero = '';
$bairro = '';
$cidade = '';
$estado = '';
$id_curso = 0;
$cep = '';
$alterar = false;

if (isset($_POST['salvar'])) {
    
    $id_curso = $_POST['curso'];

    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    $mysqli->query("INSERT INTO ALUNO (NOME, DATA_NASCIMENTO, 
        LOGRADOURO, NUMERO, BAIRRO, CIDADE, ESTADO, CEP, ID_CURSO) 
        VALUES ('$nome', '$data_nascimento', '$logradouro', '$numero', "
            . "'$bairro', '$cidade', '$estado', '$cep', '$id_curso')") or
            die($mysqli->error);

    $_SESSION['message'] = "Aluno salvo!";
    $_SESSION['msg_type'] = "success";

    header("location: crud_aluno.php");
}

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM ALUNO WHERE ID_ALUNO=$id") or die($mysqli->error);

    $_SESSION['message'] = "Aluno deletado!";
    $_SESSION['msg_type'] = "danger";

    header("location: crud_aluno.php");
}

if (isset($_POST['editar'])) {

    $id_curso = $_POST['curso'];
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    $mysqli->query("UPDATE ALUNO SET NOME='$nome', DATA_NASCIMENTO='$data_nascimento', "
            . "NUMERO='$numero', BAIRRO='$bairro', CIDADE='$cidade', ESTADO='$estado', "
            . "CEP='$cep', LOGRADOURO='$logradouro', ID_CURSO='$id_curso' "
                    . "WHERE ID_ALUNO=$id") or
            die($mysqli->error);

    $_SESSION['message'] = "Aluno alterado!";
    $_SESSION['msg_type'] = "warning";

    header("location: crud_aluno.php");
}

if (isset($_GET['editar'])) {

    $id = $_GET['editar'];
    $alterar = true;
    $result = $mysqli->query("SELECT * FROM ALUNO WHERE ID_ALUNO=$id") or die($mysqli->error);

    if (!is_array($result)) {
        $row = $result->fetch_array();
        $nome = $row['NOME'];
        $data_nascimento = $row['DATA_NASCIMENTO'];
        $logradouro = $row['LOGRADOURO'];
        $numero = $row['NUMERO'];
        $bairro = $row['BAIRRO'];
        $cidade = $row['CIDADE'];
        $estado = $row['ESTADO'];
        $cep = $row['CEP'];
    }
}