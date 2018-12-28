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

$idCliente = $_SESSION['idCliente'];

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
                <!-- WELLS - Início -->
                <div class="box box-default">
                    <?php
                    $sql_testes = "SELECT * FROM testes WHERE cliente_id = '$idCliente'";
                    $query_testes = mysqli_query($con,$sql_testes);
                    ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">Banco de Wells</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=testes_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="carregar" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Medida</th>
                                <th>Observação</th>
                                <th width="20%">Ação</th>
                            </tr>
                            </thead>
                            <?php
                            echo "<tbody>";
                            while($wel = mysqli_fetch_array($query_testes)){
                                echo "<tr>";
                                echo "<td>".dataBR($wel['data'])."</td>";
                                echo "<td>".$wel['medida']."</td>";
                                echo "<td>".$wel['observacao']."</td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=testes_edit\" role=\"form\">
                                    <input type='hidden' name='idTeste' value='" . $wel['id'] . "'>
                                    <input type='hidden' name='idCliente' value='" . $idCliente. "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            ?>
                        </table>
                    </div>
                </div>
                <!-- WELLS - Fim -->
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
