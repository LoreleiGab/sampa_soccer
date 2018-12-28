<?php
$con = bancoMysqli();

$idCliente = $_SESSION['idCliente'];
$musculo_tipo_id = $_GET['musculo_tipo_id'];
$tipo = recuperaDados("musculo_tipos","id",$musculo_tipo_id);

if(isset($_POST['apagar'])){
    $idMusculo = $_POST['idMusculo'];
    $sql_apaga_dobra = "DELETE FROM musculos WHERE id = '$idMusculo'";
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
        include 'includes/menu_mapeamento_corporal.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row" align="center">
                    <?php if(isset($mensagem)){echo $mensagem;};?>
                </div>
                <!-- general form elements -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $tipo['musculo_tipo'] ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=musculos_add&musculo_tipo_id=<?= $musculo_tipo_id ?>" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="musculos" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <?php
                    $sql_musculos = "SELECT * FROM musculos WHERE cliente_id = '$idCliente' AND musculo_tipo_id = '$musculo_tipo_id'";
                    $query_musculos = mysqli_query($con,$sql_musculos);
                    if($query_musculos != NULL) {
                        ?>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th width="10%">Ação</th>
                                </tr>
                                </thead>
                                <?php
                                echo "<tbody>";
                                while ($musculos = mysqli_fetch_array($query_musculos)) {
                                    echo "<tr>";
                                    echo "<td>" . dataBR($musculos['data']) . "</td>";
                                    echo "<td>" . $musculos['descricao']. "</td>";
                                    echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=musculos_edit&musculo_tipo_id=$musculo_tipo_id\" role=\"form\">
                                    <input type='hidden' name='idMusculo' value='" . $musculos['id'] . "'>
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
