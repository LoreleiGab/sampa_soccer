<?php
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];
$teste_tipo_id = $_GET['teste_tipo_id'];
$tipo = recuperaDados("teste_tipos","id",$teste_tipo_id);

if(isset($_POST['apagar'])){
    $idTeste = $_POST['idTeste'];
    $sql_apaga_dobra = "DELETE FROM testes WHERE id = '$idTeste'";
    if(mysqli_query($con,$sql_apaga_dobra)){
        $mensagem = mensagem("success", "Excluído com sucesso!");
    }
    else {
        $mensagem = mensagem("danger", "Erro ao excluir! Tente novamente.");
    }
}

if(isset($_POST['resumo'])){
    $idCliente = $_POST['idCliente'];
}

include "includes/menu.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START FORM-->
        <h2 class="page-header">Cliente
            <small><?= recuperaNomeCliente($idCliente) ?></small></h2>
        <?php
        include 'includes/menu_testes.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row" align="center">
                    <?php if(isset($mensagem)){echo $mensagem;};?>
                </div>
                <!-- general form elements -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $tipo['teste_tipo'] ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=testes_add&teste_tipo_id=<?= $teste_tipo_id ?>" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="testes" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <?php
                    $sql_testes = "SELECT * FROM testes WHERE cliente_id = '$idCliente' AND teste_tipo_id = '$teste_tipo_id'";
                    $query_testes = mysqli_query($con,$sql_testes);
                    if($query_testes != NULL) {
                        ?>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Medida</th>
                                    <th>Observação</th>
                                    <th width="10%">Ação</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                while ($testes = mysqli_fetch_array($query_testes)) {
                                    echo "<tr>";
                                    echo "<td>" . dataBR($testes['data']) . "</td>";
                                    echo "<td>" . $testes['medida']. "</td>";
                                    echo "<td>" . $testes['observacao']. "</td>";
                                    echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=testes_edit&teste_tipo_id=$teste_tipo_id\" role=\"form\">
                                    <input type='hidden' name='idTeste' value='" . $testes['id'] . "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                ?>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <?php
                    }
                    ?>
                </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
