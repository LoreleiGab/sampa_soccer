<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $classificacao_id = $_POST['classificacao_id'];
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
    $classificacao_id = $_POST['classificacao_id'];
    $usuario_id = $_SESSION['idUser'];
}

if(isset($_POST['cadastrar'])){
    $sql_adiciona = "INSERT INTO clientes (nome, apelido, posicao, pe_dominante, data_nascimento, clube, categoria, telefone01, telefone02, emal, diagnostico, classificacao_id, usuario_id) VALUES ('$nome', '$apelido', '$posicao', '$pe_dominante', '$data_nascimento', '$clube', '$categoria', '$telefone01', '$telefone02', '$email', '$diagnostico', '$classificacao_id', '$usuario_id')";
    if(mysqli_query($con,$sql_adiciona)){
        $mensagem = mensagem("success","Cadastrado com suscesso!");
        $idCliente = recuperaUltimo("clientes");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}
if(isset($_POST['editar'])){
    $idCliente = $_POST['idCliente'];
    $sql_edita = "UPDATE clientes SET nome = '$nome', apelido = '$apelido' WHERE id = '$idCliente'";
    if(mysqli_query($con,$sql_edita)){
        $mensagem = mensagem("success","Gravado com suscesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['carregar'])){
    $idCliente = $_POST['idCliente'];
}

$cliente = recuperaDados("clientes","id",$idCliente);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Cliente</h2>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro</h3>
                    <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
                </div>
                <form method="POST" action="?perfil=administrador&p=cliente_edit" role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Classificação do cliente</label>
                            <select class="form-control" name="classificacao_id">
                                <option value="">Selecione...</option>
                                <?php
                                geraOpcao("classificacao",$cliente['classificacao_id'])
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nome completo</label>
                            <input type="text" name="nome" class="form-control" maxlength="180" value="<?= $cliente['nome'] ?>">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <labeL>Apelido</labeL>
                                <input type="text" name="apelido" class="form-control" value="<?= $cliente['apelido'] ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <labeL>Posição</labeL>
                                <input type="text" name="posicao" class="form-control" value="<?= $cliente['posicao'] ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <labeL>Pé dominante</labeL>
                                <input type="text" name="pe_dominante" class="form-control" value="<?= $cliente['pe_dominante'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Clube</labeL>
                                <input type="text" name="clube" class="form-control" value="<?= $cliente['clube'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Categoria</labeL>
                                <input type="text" name="categoria" class="form-control" value="<?= $cliente['categoria'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <labeL>Data de Nascimento</labeL>
                                <input type="date" name="data_nascimento" class="form-control" value="<?= $cliente['data_nascimento'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Telefone #1</labeL>
                                <input type="text" name="telefone01" class="form-control" value="<?= $cliente['telefone01'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <labeL>Telefone #2</labeL>
                                <input type="text" name="telefone02" class="form-control" value="<?= $cliente['telefone02'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <labeL>Email</labeL>
                                <input type="text" name="email" class="form-control" value="<?= $cliente['emal'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Diagnóstico</label>
                            <textarea class="form-control" rows="5" name="diagnostico"><?= $cliente['diagnostico'] ?></textarea>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-default">Cancelar</button>
                        <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                        <button type="submit" name="editar" class="btn btn-info pull-right">Gravar</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
