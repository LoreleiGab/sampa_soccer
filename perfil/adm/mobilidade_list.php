<?php
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];

if(isset($_POST['apagar'])){
    $idMobilidade = $_POST['idMobilidade'];
    $sql_apaga_dobra = "DELETE FROM mobilidade WHERE id = '$idMobilidade'";
    if(mysqli_query($con,$sql_apaga_dobra)){
        $mensagem = mensagem("success", "Excluído com sucesso!");
    }
    else {
        $mensagem = mensagem("danger", "Erro ao excluir! Tente novamente.");
    }
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
        include 'includes/menu_mapeamento_corporal.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- AVALIAÇÕES general form elements -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Mobilidade articular</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=mobilidade_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="musculos" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <?php
                    $sql_mobilidade = "SELECT * FROM mobilidade WHERE cliente_id = '$idCliente'";
                    $query_mobilidade = mysqli_query($con,$sql_mobilidade);
                    if($query_mobilidade != NULL) {
                        ?>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Quadril</th>
                                    <th>Isquiotibiais</th>
                                    <th>Quadríceps</th>
                                    <th width="10%">Ação</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                while ($mobilidade = mysqli_fetch_array($query_mobilidade)) {
                                    echo "<tr>";
                                    echo "<td>" . dataBR($mobilidade['data']) . "</td>";
                                    echo "<td>" . $mobilidade['quadril']. "</td>";
                                    echo "<td>" . $mobilidade['isquiotibiais']. "</td>";
                                    echo "<td>" . $mobilidade['quadriceps']. "</td>";
                                    echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=mobilidade_edit\" role=\"form\">
                                    <input type='hidden' name='idMobilidade' value='" . $mobilidade['id'] . "'>
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
