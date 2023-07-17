<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));

$id = 0;
$id_prof = 0;
$nome = '';
$nome_prof = '';
$string = '';
$alterar = false;


if (isset($_POST['salvar'])) {

    $id_prof = $_POST['professor'];
    $nome = $_POST['nome'];

    printf($id_prof);

    $mysqli->query("INSERT INTO CURSO (NOME, ID_PROFESSOR) VALUES ('$nome', '$id_prof')") or
            die($mysqli->error);

    $_SESSION['message'] = "Curso salvo!";
    $_SESSION['msg_type'] = "success";

    header("location: crud_curso.php");
}

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM CURSO WHERE ID_CURSO=$id") or die($mysqli->error);

    $_SESSION['message'] = "Curso deletado!";
    $_SESSION['msg_type'] = "danger";

    header("location: crud_curso.php");
}

if (isset($_GET['editar'])) {

    $id = $_GET['editar'];
    $alterar = true;
    $result = $mysqli->query("SELECT ID_CURSO, C.NOME AS NOME_CURSO, C.DATA_CRIACAO AS DCC, 
                C.ID_PROFESSOR AS ID_PROF_CURSO, P.NOME AS NOME_PROF, DATA_NASCIMENTO, P.DATA_CRIACAO AS DCP FROM CURSO AS C "
            . "INNER JOIN PROFESSOR AS P ON C.ID_PROFESSOR = P.ID_PROFESSOR where ID_CURSO = $id")
            or die($mysqli->error);

    if (!is_array($result)) {
        $row = $result->fetch_array();
        $nome = $row['NOME_CURSO'];
        $id_prof = $row['ID_PROF_CURSO'];
        $nome_prof = $row['NOME_PROF'];
    }
}

if (isset($_POST['editar'])) {

    $id = $_POST['id'];
    $id_prof = $_POST['professor'];
    $nome = $_POST['nome'];

    $mysqli->query("UPDATE CURSO SET NOME='$nome', ID_PROFESSOR='$id_prof' WHERE ID_CURSO=$id") or
            die($mysqli->error);

    $_SESSION['message'] = "Curso alterado!";
    $_SESSION['msg_type'] = "warning";

    header("location: crud_curso.php");
}

