<!DOCTYPE html>

<html>
    <head>
        <title>CRUD CURSO - FLEXPEAK</title>
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

        <?php require_once '../php/process_curso.php'; ?>

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

        $result = $mysqli->query("SELECT ID_CURSO, C.NOME AS NOME_CURSO, C.DATA_CRIACAO AS DCC, 
                C.ID_PROFESSOR, P.NOME AS NOME_PROF, DATA_NASCIMENTO, P.DATA_CRIACAO AS DCP FROM CURSO AS C "
                . "INNER JOIN PROFESSOR AS P ON C.ID_PROFESSOR = P.ID_PROFESSOR ORDER BY C.NOME") or die($mysqli->error);
        ?>               

        <div class="container" id="centralizar">

            <div class="form-group row" >
                <div class="col-sm-8">
                    <a href="../php/cadastro_curso.php" class="btn btn-outline-primary">Novo</a>
                </div>
                <div class="col-sm-4">
                    <input id="pesquisar" type="text" class="form-control" placeholder="Digite a pesquisa">  
                </div>
            </div>

            <div class="row" >
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-success">
                                <th style="width: 20%">Nome</th>
                                <th style="width: 40%">Professor</th>
                                <th style="width: 20%">Data Criação</th>
                                <th style="width: 20%" colspan="2">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td> <?php echo $row['NOME_CURSO']; ?></td>
                                    <td> <?php echo $row['NOME_PROF']; ?></td>
                                    <td> <?php echo (new DateTime($row['DCC']))->format('d/m/Y H:i'); ?></td>
                                    <td class="text-center">
                                        <a href="../php/cadastro_curso.php?editar=<?php echo $row['ID_CURSO']; ?>" 
                                           class="btn btn-outline-warning">Editar</a>
                                        <a href="../php/process_curso.php?delete=<?php echo $row['ID_CURSO']; ?>"
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
