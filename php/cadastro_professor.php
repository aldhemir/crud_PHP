<!DOCTYPE html>

<html>
    <head>
        <title>CRUD PROFESSOR - FLEXPEAK</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../css/style_cadastro.css">
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
    <body>

        <?php
        $id = 0;
        $nome = '';
        $data_nascimento = '';
        $alterar = false;

        $mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
        $result_prof = $mysqli->query("SELECT * FROM PROFESSOR") or die($mysqli->error);

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
        ?>

        <div class="container" id="centralizar">
            <div class="row justify-content-center">
                <form action="process_professor.php" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" 
                               placeholder="Nome" required>
                        <div class="invalid-feedback">
                            Por favor preencha seu nome.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Data Nascimento</label>
                        <input type="text" name="data_nascimento" class="form-control" value="<?php echo $data_nascimento; ?>" 
                               placeholder="Data de nascimento">
                    </div>  

                    <div class="text-right" >
                        <hr>
                        <div class="form-group">

                            <?php if ($alterar): ?>
                                <button type="submit" class="btn btn-outline-warning" name="editar">Editar</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-outline-primary" name="salvar">Salvar</button>
                            <?php endif; ?>

                            <a class="btn btn-outline-secondary" href="crud_professor.php">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>    
        <script>
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    </body>
</html>