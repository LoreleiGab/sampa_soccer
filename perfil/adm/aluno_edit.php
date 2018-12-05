<?php
$con = bancoMysqli();

if(isset($_SESSION['idCliente'])){
    $idCliente = $_SESSION['idCliente'];
}

if(isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo_id'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone01 = $_POST['telefone01'];
    $telefone02 = $_POST['telefone02'];
    $email = $_POST['email'];
    $restricao = $_POST['restricao'];
    $atividade_interesse = $_POST['atividade_interesse'];
    $diagnostico = $_POST['diagnostico'];
    $classificacao_id = 3;
    $usuario_id = $_SESSION['idUser'];
}

if(isset($_POST['cadastrar'])){
    $sql_cliente = "INSERT INTO clientes (nome, data_nascimento,  telefone01, telefone02, email, diagnostico, classificacao_id, usuario_id) VALUES ('$nome', '$data_nascimento', '$telefone01', '$telefone02', '$email', '$diagnostico', '$classificacao_id', '$usuario_id')";
    if(mysqli_query($con,$sql_cliente)){
        $idCliente = recuperaUltimo("clientes");
        $sql_aluno = "INSERT INTO alunos (sexo_id, atividade_interesse, restricao, cliente_id) VALUES ('$sexo', '$atividade_interesse', '$restricao', '$idCliente')";
        if(mysqli_query($con,$sql_aluno)) {
            $mensagem = mensagem("success", "Cadastrado com sucesso!");
        }
        else{
            $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
        }
    }
    else{
        $mensagem = mensagem("danger","[COD2]Erro ao gravar! Tente novamente.");
    }
}
if(isset($_POST['editar'])){
    $idCliente = $_POST['idCliente'];
    $sql_edita_cliente = "UPDATE clientes SET nome = '$nome', data_nascimento = '$data_nascimento', telefone01 = '$telefone01', telefone02 = '$telefone02', email = '$email', diagnostico = '$diagnostico', classificacao_id = '$classificacao_id' WHERE id = '$idCliente'";
    if(mysqli_query($con,$sql_edita_cliente)){
        $sql_edita_aluno = "UPDATE alunos SET sexo_id = '$sexo', atividade_interesse = '$atividade_interesse', restricao = '$restricao' WHERE cliente_id = '$idCliente'";
        if(mysqli_query($con,$sql_edita_aluno)) {
            $_SESSION['idCliente'] = $idCliente;
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

include "includes/menu.php";

$cliente = recuperaDados("clientes","id",$idCliente);
$aluno = recuperaDados("alunos","cliente_id",$idCliente);
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
                        <h3 class="box-title">Cadastro de Aluno</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=aluno_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="nome">Nome completo</label>
                                    <input type="text" id="nome" name="nome" class="form-control" maxlength="180" value="<?= $cliente['nome'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sexo_id">Sexo</label>
                                    <select id="sexo_id" name="sexo_id" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <?php geraOpcao("sexos",$aluno['sexo_id']) ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-1" align="center">
                                    <label>Idade</label><br/>
                                    <?= idade($cliente['data_nascimento']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data_nascimento">Data de Nascimento</labeL>
                                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" value="<?= $cliente['data_nascimento'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="telefone01">Telefone #1</labeL>
                                    <input type="text" id="telefone01" name="telefone01" onkeyup="mascara( this, mtel );" class="form-control" value="<?= $cliente['telefone01'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="telefone02">Telefone #2</labeL>
                                    <input type="text" id="telefone02" name="telefone02" onkeyup="mascara( this, mtel );" class="form-control" value="<?= $cliente['telefone02'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="email">Email</labeL>
                                    <input type="email" id="email" name="email" class="form-control" value="<?= $cliente['email'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <labeL for="restricao">Alguma restrição</labeL>
                                    <input type="text" id="restricao" name="restricao" class="form-control" maxlength="255" value="<?= $aluno['restricao'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <labeL for="atividade_interesse">Atividade de interesse</labeL>
                                    <input type="text" id="atividade_interesse" name="atividade_interesse" class="form-control" maxlength="255" value="<?= $aluno['atividade_interesse'] ?>">
                                </div>
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
                            <button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="#modal-danger">Excluir</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- Confirmação de Exclusão -->
        <div class="modal modal-danger fade" id="modal-danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmação de exclusão</h4>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir?<br/> Todos os dados relacionados serão excluídos e essa ação não poderá ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="?perfil=administrador&p=aluno_list" role="form">
                            <input type='hidden' name='idCliente' value="<?= $cliente['id'] ?>">
                            <button type="submit" name="apagar" class="btn btn-outline">Sim</button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fim Confirmação de Exclusão -->
    </section>
    <!-- /.content -->
</div>