<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 29/12/2018
 * Time: 18:12
 */
?>
<div class="row">
    <!-- WELLS - Início -->
    <div class="col-md-6">
        <div class="box box-default">
            <?php
            $sql_wells = "SELECT * FROM testes WHERE cliente_id = '$idCliente' AND teste_tipo_id = 1 ORDER BY data";
            $query_wells = mysqli_query($con,$sql_wells);
            ?>
            <div class="box-header with-border">
                <h3 class="box-title">Banco de Wells</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <form method="POST" action="?perfil=administrador&p=wells_add" role="form">
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
                        <th width="20%">Ação</th>
                    </tr>
                    </thead>
                    <?php
                    echo "<tbody>";
                    $wells_charts = '';
                    while($wel = mysqli_fetch_array($query_wells)){
                        echo "<tr>";
                        echo "<td>".dataBR($wel['data'])."</td>";
                        echo "<td>".$wel['medida']."</td>";
                        echo "<td>
                                    <form method=\"POST\" action=\"?perfil=administrador&p=wells_edit\" role=\"form\">
                                    <input type='hidden' name='idWells' value='" . $wel['id'] . "'>
                                    <input type='hidden' name='idCliente' value='" . $idCliente. "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\">Editar</button>
                                    </form>
                                    </td>";
                        echo "</tr>";
                        $wells_charts .= "{y: '".dataBR($wel['data'])."', a: ".$wel['medida']."}, ";
                    }
                    $wells_charts = substr($wells_charts,0,-2);
                    echo "</tbody>";
                    ?>
                </table>
            </div>
        </div>
    </div>
    <!-- PESO CHART -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Banco de Wells</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart" id="wells-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <!-- ./PESO CHART -->
    <!-- WELLS - Fim -->
</div>
