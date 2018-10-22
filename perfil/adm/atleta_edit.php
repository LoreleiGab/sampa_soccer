<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $posicao = $_POST['posicao'];
    $pe_dominante = $_POST['pe_dominante'];
    $data_nascimento = $_POST['data_nascimento'];
    $clube = $_POST['clube'];
    $categoria = $_POST['categoria'];
    $telefone01 = $_POST['telefone01'];
    $telefone02 = $_POST['telefone02'];
    $email = $_POST['email'];
    $diagnostico = $_POST['diagnostico'];
    $contatos = $_POST['contatos'];
    $ultimos_clubes = $_POST['ultimos_clubes'];
    $classificacao_id = 1;
    $usuario_id = $_SESSION['idUser'];
}

if(isset($_POST['cadastrar'])){
    $sql_cliente = "INSERT INTO clientes (nome, data_nascimento,  telefone01, telefone02, email, diagnostico, classificacao_id, usuario_id) VALUES ('$nome', '$data_nascimento', '$telefone01', '$telefone02', '$email', '$diagnostico', '$classificacao_id', '$usuario_id')";
    if(mysqli_query($con,$sql_cliente)){
        $idCliente = recuperaUltimo("clientes");
        $sql_atleta = "INSERT INTO atleta (apelido, posicao, pe_dominante, clube, categoria, contatos, ultimos_clubes, cliente_id) VALUES ('$apelido', '$posicao', '$pe_dominante', '$clube', '$categoria', '$contatos', '$ultimos_clubes', '$idCliente')";
        if(mysqli_query($con,$sql_atleta)) {
            $mensagem = mensagem("success", "Cadastrado com sucesso!");
        }
        else{
            $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
        }
    }
    else{
        $mensagem = mensagem("danger","[COD2]Erro ao gravar! Tente novamente.").$sql_cliente;
    }
}
if(isset($_POST['editar'])){
    $idCliente = $_POST['idCliente'];
    $sql_edita_cliente = "UPDATE clientes SET nome = '$nome', data_nascimento = '$data_nascimento', telefone01 = '$telefone01', telefone02 = '$telefone02', email = '$email', diagnostico = '$diagnostico', classificacao_id = '$classificacao_id' WHERE id = '$idCliente'";
    if(mysqli_query($con,$sql_edita_cliente)){
        $sql_edita_atleta = "UPDATE atleta SET apelido = '$apelido', posicao = '$posicao', pe_dominante = '$pe_dominante',clube = '$clube', categoria = '$categoria', contatos = '$contatos', ultimos_clubes = '$ultimos_clubes' WHERE cliente_id = '$idCliente'";
        if(mysqli_query($con,$sql_edita_atleta)) {
            $mensagem = mensagem("success", "Gravado com sucesso!");
        }
        else{
            $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
        }
    }
    else{
        $mensagem = mensagem("danger","[COD2]Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['carregar'])){
    $idCliente = $_POST['idCliente'];
}

$cliente = recuperaDados("clientes","id",$idCliente);
$atleta = recuperaDados("atleta","cliente_id",$idCliente);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cliente</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastro de Atleta</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=atleta_edit" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nome">Nome completo</label>
                                <input type="text" id="nome" name="nome" class="form-control" maxlength="180" value="<?= $cliente['nome'] ?>">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data_nascimento">Data de Nascimento</labeL>
                                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" value="<?= $cliente['data_nascimento'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="telefone01">Telefone #1</labeL>
                                    <input type="text" id="telefone01" name="telefone01" class="form-control" value="<?= $cliente['telefone01'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="telefone02">Telefone #2</labeL>
                                    <input type="text" id="telefone02" name="telefone02" class="form-control" value="<?= $cliente['telefone02'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="email">Email</labeL>
                                    <input type="email" id="email" name="email" class="form-control" value="<?= $cliente['email'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="apelido">Apelido</labeL>
                                    <input type="text" id="apelido" name="apelido" class="form-control" value="<?= $atleta['apelido'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="posicao">Posição</labeL>
                                    <input type="text" id="posicao" name="posicao" class="form-control" value="<?= $atleta['posicao'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="pe_dominante">Pé dominante</labeL>
                                    <input type="text" id="pe_dominante" name="pe_dominante" class="form-control" value="<?= $atleta['pe_dominante'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="clube">Clube</labeL>
                                    <input type="text" id="clube" name="clube" class="form-control" value="<?= $atleta['clube'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="categoria">Categoria</labeL>
                                    <input type="text" id="categoria" name="categoria" class="form-control" value="<?= $atleta['categoria'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <labeL for="contatos">Contatos</labeL>
                                <input id="contatos" type="text" name="contatos" class="form-control" maxlength="255" value="<?= $atleta['contatos'] ?>">
                            </div>
                            <div class="form-group">
                                <labeL for="ultimos_clubes">Últimos clubes</labeL>
                                <input type="text" id="ultimos_clubes" name="ultimos_clubes" class="form-control" maxlength="255" value="<?= $atleta['ultimos_clubes'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="diagnostico">Diagnóstico</label>
                                <textarea class="form-control" rows="5" id="diagnostico" name="diagnostico"><?= $cliente['diagnostico'] ?></textarea>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value="<?= $cliente['id'] ?>">
                            <button type="submit" name="editar" class="btn btn-info pull-right">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>