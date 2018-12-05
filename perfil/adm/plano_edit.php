<?php
$con = bancoMysqli();

if(isset($_SESSION['idCliente'])){
    $idCliente = $_SESSION['idCliente'];
}
if(isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
}

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $data_inicio = $_POST['data_inicio'];
    $data_vencimento = addslashes($_POST['data_vencimento']);
    $plano = addslashes($_POST['plano']);
    $valor = decimalMysql($_POST['valor']);
    $forma_pagamento = addslashes($_POST['forma_pagamento']);
    $outros = addslashes($_POST['outros']);
}

if(isset($_POST['cadastra'])){
    $sql = "INSERT INTO planos (cliente_id, data_inicio, data_vencimento, plano, valor, forma_pagamento, outros) 
            VALUES ('$idCliente', '$data_inicio', '$data_vencimento', '$plano', '$valor','$forma_pagamento','$outros')";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success","Gravado com suscesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.").$sql;
    }
}

if(isset($_POST['edita'])){
    $sql = "UPDATE planos SET data_inicio = '$data_inicio', data_vencimento = '$data_vencimento', plano = '$plano', valor = '$valor', forma_pagamento = '$forma_pagamento', outros = '$outros' WHERE cliente_id = '$idCliente'";
    if(mysqli_query($con,$sql)){
        $mensagem = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['insere_pagto'])){
    $idCliente = $_POST['idCliente'];
    $data = $_POST['data'];
    $sql_pagto = "INSERT INTO plano_pagamentos (data, cliente_id) VALUES ('$data','$idCliente')";
    if(mysqli_query($con,$sql_pagto)){
        $mensagem2 = mensagem("success", "Gravado com sucesso!");
    }
    else{
        $mensagem2 = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['apagar'])){
    $id = $_POST['idPagto'];
    $sql_apaga_cliente = "DELETE FROM plano_pagamentos WHERE id = '$id'";
    if(mysqli_query($con,$sql_apaga_cliente)){
        $mensagem = mensagem("success", "Excluído com sucesso!");
    }
    else {
        $mensagem = mensagem("danger", "Erro ao excluir! Tente novamente.");
    }
}

include "includes/menu.php";

$plano = recuperaDados("planos","cliente_id",$idCliente);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cliente
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de plano</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=plano_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="data_inicio">Data</label>
                                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= $plano['data_inicio'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_vencimento">Data vencimento</label>
                                    <input type="text" id="data_vencimento" name="data_vencimento" class="form-control" maxlength="100" value="<?= $plano['data_vencimento'] ?>">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="plano">Plano</label>
                                    <input type="text" id="plano" name="plano" class="form-control" maxlength="120" value="<?= $plano['plano'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="valor">Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control" value="<?= $plano['valor'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="forma_pagamento">Forma de Pagamento</label>
                                    <input type="text" id="forma_pagamento" name="forma_pagamento" class="form-control" maxlength="100" value="<?= $plano['forma_pagamento'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="outros">Outros</label>
                                    <input type="text" id="outros" name="outros" class="form-control" maxlength="100" value="<?= $plano['outros'] ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="edita" class="btn btn-info pull-right">Gravar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastro de pagamentos</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem2)){echo $mensagem2;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=plano_edit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="data">Data</label>
                                    <input type="date" id="data" name="data" class="form-control" value="<?= date('Y-m-d')?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="insere_pagto" class="btn btn-info pull-right">Gravar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Pagamentos</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Ação</th>
                            </tr>
                            </thead>

                            <?php
                            echo "<tbody>";
                            $sql_pagamentos = "SELECT * FROM plano_pagamentos WHERE cliente_id = '$idCliente' ORDER BY data";
                            $query_pagamentos = mysqli_query($con,$sql_pagamentos);
                            while ($pagtos = mysqli_fetch_array($query_pagamentos)){
                                echo "<tr>";
                                echo "<td>".dataBR($pagtos['data'])."</td>";
                                echo "<td>
                                    <button type=\"button\" class=\"btn btn-danger pull-left\" data-toggle=\"modal\" data-target=\"#modal-danger\">Excluir</button>
                                </td>";
                                echo "</tr>";
                                ?>
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
                                                <form method="POST" action="?perfil=administrador&p=plano_edit" role="form">
                                                    <input type='hidden' name='idPagto' value="<?= $pagtos['id'] ?>">
                                                    <button type="submit" name="apagar" class="btn btn-outline">Sim</button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Fim Confirmação de Exclusão -->
                            <?php
                            }
                            echo "</tbody>";
                            ?>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script>
    $('#valor').mask('000.000.000.000.000,00', {reverse: true});
</script>