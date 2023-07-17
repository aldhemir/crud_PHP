<!DOCTYPE html>

<html>
    <head>
        <title>CRUD ALUNO - FLEXPEAK</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>

        <script src="../script/buscar_cep.js"></script>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            #centralizar {
                position:absolute;
                left:8%;
                top:30%;
                margin-left:-50px;
                margin-top:-40px;
            }
        </style>

    </head>
    <body>

        <?php
        $id = 0;
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

        $mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
        $result_cursos = $mysqli->query("SELECT * FROM CURSO ORDER BY NOME") or die($mysqli->error);

        if (isset($_GET['editar'])) {

            $id = $_GET['editar'];
            $alterar = true;

            $result = $mysqli->query("SELECT A.ID_ALUNO, A.NOME, A.DATA_NASCIMENTO, A.LOGRADOURO,  
            A.NUMERO, A.BAIRRO, A.CIDADE, A.ESTADO, A.DATA_CRIACAO, A.CEP, 
            A.ID_CURSO, C.ID_CURSO AS ID_CURSO, C.NOME AS NOME_CURSO, C.DATA_CRIACAO, C.ID_PROFESSOR FROM ALUNO A
            INNER JOIN CURSO C ON A.ID_CURSO = C.ID_CURSO WHERE ID_ALUNO='$id'") or die($mysqli->error);

            $row = $result->fetch_array();
            $nome = $row['NOME'];
            $data_nascimento = $row['DATA_NASCIMENTO'];
            $logradouro = $row['LOGRADOURO'];
            $numero = $row['NUMERO'];
            $bairro = $row['BAIRRO'];
            $cidade = $row['CIDADE'];
            $estado = $row['ESTADO'];
            $cep = $row['CEP'];
            $nome_curso = $row['NOME_CURSO'];
            $id_curso = $row['ID_CURSO'];
        }

        if (isset($_GET['pesquisar'])) {
            $resultado_busca = busca_cep($_GET['cep']);
            $logradouro = $resultado_busca['logradouro'];
        }
        ?>

        <div class="container" id="centralizar">
            <form action="../php/process_aluno.php" method="POST" class="needs-validation" novalidate>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" 
                               value="<?php echo $nome; ?>" placeholder="Nome" required>
                        <div class="invalid-feedback">
                            Por favor preencha seu nome.
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Data Nascimento</label>
                        <input type="text" name="data_nascimento" class="form-control" value="<?php echo $data_nascimento; ?>" 
                               placeholder="Data de nascimento">
                    </div>

                    <div class="form-group col-md-4">
                        <label>CEP</label>
                        <div class="input-group">
                            <input type="text" id="cep" name="cep" class="form-control" value="<?php echo $cep; ?>" 
                                   placeholder="CEP">                            <span class="input-group-btn">
                                <button type="button" onclick="pesquisacep(cep.value)" name="pesquisar" class="btn btn-outline-success">Pesquisar</button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Logradouro</label>
                        <input type="text" id="logradouro" name="logradouro" class="form-control" value="<?php echo $logradouro; ?>" 
                               placeholder="Logradouro">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Numero</label>
                        <input type="text" id="numero" name="numero" class="form-control" value="<?php echo $numero; ?>" 
                               placeholder="Numero">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Bairro</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" value="<?php echo $bairro; ?>" 
                               placeholder="Bairro">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Cidade</label>
                        <input type="text" id="cidade" name="cidade" class="form-control" value="<?php echo $cidade; ?>" 
                               placeholder="Cidade">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Estado</label>
                        <input type="text" id="uf" name="estado" class="form-control" value="<?php echo $estado; ?>" 
                               placeholder="Estado">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Curso</label>
                        <select name="curso"  class="custom-select" required>
                            <option value="">..::Selecione::..</option>
                            <?php while ($r = $result_cursos->fetch_assoc()): ?>
                                <option value="<?php echo $r['ID_CURSO']; ?>">
                                    <?php echo $r['NOME']; ?> 
                                </option>
                            <?php endwhile; ?>

                            <?php if ($alterar && $r['NOME_CURSO'] = $nome_curso): ?>
                                <option selected="selected" value="<?php echo $id_curso; ?>">
                                    <?php echo $r['NOME_CURSO']; ?> 
                                </option>
                            <?php endif; ?>
                        </select>
                        <div class="invalid-feedback">
                            Por favor escolha um curso.
                        </div>
                    </div> 
                    <hr>
                </div>
                <div class="text-right" >
                    <hr>
                    <div class="form-group">
                        <?php if ($alterar): ?>
                            <button type="submit" class="btn btn-outline-warning" name="editar">Editar</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-outline-primary" name="salvar">Salvar</button>
                        <?php endif; ?>
                        <a class="btn btn-outline-secondary" href="../php/crud_aluno.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
        <script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
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