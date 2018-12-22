<?php
$con = bancoMysqli();

if(isset($_POST['apagar'])){
    $idPerimetria = $_POST['idPerimetria'];
    $sql_apaga_perimetria = "DELETE FROM perimetrias WHERE id = '$idPerimetria'";
    if(mysqli_query($con,$sql_apaga_perimetria)){
        $mensagem = mensagem("success", "Excluído com sucesso!");
    }
    else {
        $mensagem = mensagem("danger", "Erro ao excluir! Tente novamente.");
    }
}

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
                <div class="row" align="center">
                    <?php if(isset($mensagem)){echo $mensagem;};?>
                </div>
                <!-- PERIMETRIA - Início -->
                <div class="box box-default">
                    <?php
                    $sql_perimetria = "SELECT per.id AS idPerimetria, `imc_id`, `torax`, `cintura`, `abdome`, `quadril`, `coxa_direita`, `coxa_esquerda`, `perna_direita`, `perna_esquerda`, `biceps_direito`, `biceps_esquerdo`, `punho`, i.id, `data`, `peso`, `altura`, `resultado`, `cliente_id` FROM perimetrias AS per INNER JOIN imcs i on per.imc_id = i.id WHERE i.cliente_id = '$idCliente'";
                    $query_perimetria = mysqli_query($con,$sql_perimetria);
                    ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">Perimetria</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <form method="POST" action="?perfil=administrador&p=perimetria_add" role="form">
                            <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                            <button type="submit" name="perimetria" class="btn btn-info pull-right">Adicionar</button>
                        </form>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Torax</th>
                                <th>Cintura</th>
                                <th>Abdome</th>
                                <th>Quadril</th>
                                <th>Coxa D.</th>
                                <th>Coxa E.</th>
                                <th>Perna D.</th>
                                <th>Perna E.</th>
                                <th>Bíceps D.</th>
                                <th>Bíceps E.</th>
                                <th>Punho</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <?php
                            while($perim = mysqli_fetch_array($query_perimetria)){
                                echo "<tbody>";
                                echo "<tr>";
                                echo "<td>".dataBR($perim['data'])."</td>";
                                echo "<td>".decimalBr($perim['torax'],1)."</td>";
                                echo "<td>".decimalBr($perim['cintura'],1)."</td>";
                                echo "<td>".decimalBr($perim['abdome'],1)."</td>";
                                echo "<td>".decimalBr($perim['quadril'],1)."</td>";
                                echo "<td>".decimalBr($perim['coxa_direita'],1)."</td>";
                                echo "<td>".decimalBr($perim['coxa_esquerda'],1)."</td>";
                                echo "<td>".decimalBr($perim['perna_direita'],1)."</td>";
                                echo "<td>".decimalBr($perim['perna_esquerda'],1)."</td>";
                                echo "<td>".decimalBr($perim['biceps_direito'],1)."</td>";
                                echo "<td>".decimalBr($perim['biceps_esquerdo'],1)."</td>";
                                echo "<td>".decimalBr($perim['punho'],1)."</td>";
                                echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=perimetria_edit\" role=\"form\">
                                    <input type='hidden' name='idPerimetria' value='" . $perim['idPerimetria'] . "'>
                                    <input type='hidden' name='idCliente' value='" . $idCliente. "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                                echo "</tr>";
                                echo "</tbody>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <!-- PERIMETRIA - Fim -->
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
