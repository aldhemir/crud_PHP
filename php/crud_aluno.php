<!DOCTYPE html>

<html>
    <head>
        <title>CRUD ALUNO - FLEXPEAK</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

        <link rel="stylesheet" href="../css/style_crud.css">

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body>

        <?php require_once 'process_aluno.php'; ?>

        <?php if (isset($_SESSION['message'])): ?>

            <div class="alert alert-<?= $_SESSION['msg_type'] ?>">

                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>

            </div>        
        <?php endif ?>

        <?php
        $mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
        $result = $mysqli->query("SELECT A.ID_ALUNO, A.NOME, A.DATA_NASCIMENTO AS DATA_NASCIMENTO, A.LOGRADOURO,  
        A.NUMERO, A.BAIRRO, A.CIDADE, A.ESTADO, A.DATA_CRIACAO AS DATA_CRIACAO_ALUNO, A.CEP, 
        A.ID_CURSO, C.ID_CURSO, C.NOME AS NOME_CURSO, C.DATA_CRIACAO AS DATA_CRIACAO_CURSO, C.ID_PROFESSOR FROM ALUNO A
        INNER JOIN CURSO C ON A.ID_CURSO = C.ID_CURSO ORDER BY A.NOME") or die($mysqli->error);
        ?>

        <div class="container" id="centralizar">

            <div class="form-group row" >
                <div class="col-sm-8">
                    <a href="../php/cadastro_aluno.php" class="btn btn-outline-primary">Novo</a>
                </div>
                <div class="col-sm-4">
                    <input id="pesquisar" type="text" class="form-control" placeholder="Digite a pesquisa">  
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-success">
                                <th>Nome</th>
                                <th>Data de Nascimento</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>Data Criação</th>
                                <th>Curso</th>
                                <th style="width: 20%" colspan="2">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td> <?php echo $row['NOME']; ?></td>
                                    <td> <?php echo (new DateTime($row['DATA_NASCIMENTO']))->format('d/m/Y'); ?></td>
                                    <td> <?php echo $row['CIDADE']; ?></td>
                                    <td> <?php echo $row['ESTADO']; ?></td>
                                    <td> <?php echo (new DateTime($row['DATA_CRIACAO_ALUNO']))->format('d/m/Y H:i'); ?></td>
                                    <td> <?php echo $row['NOME_CURSO']; ?></td>
                                    <td class="text-center">
                                        <a href="cadastro_aluno.php?editar=<?php echo $row['ID_ALUNO']; ?>"
                                           class="btn btn-outline-warning">Editar</a>
                                        <a href="process_aluno.php?delete=<?php echo $row['ID_ALUNO']; ?>"
                                           class="btn btn-outline-danger">Deletar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>           
                </div>            
            </div>
            <div class="text-right" >
                <hr>
                <a href="../index.php" class="btn btn-outline-secondary">Sair</a>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $("#pesquisar").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#tabela tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
    </body>
</html>