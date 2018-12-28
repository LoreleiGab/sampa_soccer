<?php
include "includes/menu.php";
$con = bancoMysqli();

if(isset($_POST['idCliente'])){
    $idCliente = $_POST['idCliente'];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Dobras
        <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_antropometria.php';
        ?>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <form method="POST" action="?perfil=administrador&p=cliente_resumo" role="form">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cadastro de dobras</h3>
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="resumo" class="btn btn-info pull-right">Voltar Para o Resumo</button>
                        </div>
                    </form>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrador&p=dobras3m_edit" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="imc_id">Data</labeL> <a href="?perfil=administrador&p=peso_altura_list"><i class="fa fa-plus"></i></a>
                                    <select id="imc_id" name="imc_id" class="form-control" required>
                                        <option value="">Selecione...</option>
                                        <?php geraOpcaoData("dobras",$idCliente,"") ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="peitoral">PT</labeL>
                                    <input type="text" id="peitoral" name="peitoral" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="abdominal">AB</labeL>
                                    <input type="text" id="abdominal" name="abdominal" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="coxa">CX</labeL>
                                    <input type="text" id="coxa" name="coxa" class="form-control">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type='hidden' name='idCliente' value="<?= $idCliente ?>">
                            <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
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

<script>
    $('#peitoral').mask('000,0', {reverse: true});
    $('#abdominal').mask('000,0', {reverse: true});
    $('#coxa').mask('000,0', {reverse: true});
</script>