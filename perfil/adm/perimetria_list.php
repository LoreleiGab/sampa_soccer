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

        <div class="row">
            <div class="col-md-12">
                <!-- PERIMETRIA - Início -->
                <div class="box box-default">
                <?php


                            $sql_perimetria = "SELECT * FROM perimetrias ";
                            $query_perimetria = mysqli_query($con,$sql_perimetria);
                            $num_perimetria = mysqli_num_rows($query_perimetria);
                            if($num_perimetria > 0){
                            ?>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Perimetria</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
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
                                        </tr>
                                        </thead>
                                        <?php
                                        while($perim = mysqli_fetch_array($query_perimetria)){
                                            echo "<tbody>";
                                            echo "<tr>";
                                            echo "<td>".dataBR($avaliacao['data'])."</td>";
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
                                            echo "</tr>";
                                            echo "</tbody>";
                                        }
                                        ?>
                                    </table>
                                </div>
                            <?php
                    }
                ?>
                </div>
                <!-- PERIMETRIA - Fim -->
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
