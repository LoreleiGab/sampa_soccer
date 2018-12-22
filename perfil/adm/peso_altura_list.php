<?php
$con = bancoMysqli();

if(isset($_POST['resumo'])){
    $idCliente = $_POST['idCliente'];
    $_SESSION['idCliente'] = $idCliente;
}

if(isset($_SESSION['idCliente'])){
    $idCliente = $_SESSION['idCliente'];
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
        include 'includes/menu_antropometria.php';
        ?>

        <div class="row">
            <div class="col-md-12">
                <!-- AVALIAÇÕES general form elements -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Peso / altura</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=peso_altura_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="avaliacao" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <?php
                    $sql_avaliacao = "SELECT * FROM imcs WHERE cliente_id = '$idCliente'";
                    $query_avaliacao = mysqli_query($con,$sql_avaliacao);
                    if($query_avaliacao != NULL) {
                        ?>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Peso</th>
                                    <th>Altura</th>
                                    <th>IMC</th>
                                    <th width="10%">Ação</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                    echo "<tr>";
                                    echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                    echo "<td>" . decimalBr($avaliacao['peso'],3) . "</td>";
                                    echo "<td>" . decimalBr($avaliacao['altura'],1) . "</td>";
                                    echo "<td>" . imc($avaliacao['peso'],$avaliacao['altura']) ."</td>";
                                    echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=peso_altura_edit\" role=\"form\">
                                    <input type='hidden' name='idAvaliacao' value='" . $avaliacao['id'] . "'>
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
                <!-- AVALIAÇÕES - Fim -->
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
