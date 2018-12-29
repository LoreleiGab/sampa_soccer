<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 29/12/2018
 * Time: 17:46
 */
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Peso / Altura</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <form method="POST" action="?perfil=administrador&p=peso_altura_add" role="form">
                    <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
                    <button type="submit" name="avaliacao" class="btn btn-info pull-right">Adicionar</button>
                </form>
            </div>
            <?php
            $sql_avaliacao = "SELECT * FROM imcs WHERE cliente_id = '$idCliente' ORDER BY data";
            $query_avaliacao = mysqli_query($con,$sql_avaliacao);
            if($query_avaliacao != NULL) {
                ?>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
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
                        $avaliacao_charts = '';
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
                            $avaliacao_charts .= "{y: '".dataBR($avaliacao['data'])."', a: ".$avaliacao['peso']."}, ";
                        }
                        $avaliacao_charts = substr($avaliacao_charts,0,-2);
                        echo "</tbody>";
                        ?>
                    </table>
                </div>
                <!-- /.box-body -->
                <?php
            }
            ?>
        </div>
    </div>
    <!-- PESO CHART -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Peso corporal total</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart" id="peso-chart" style="height: 275px;"></div>
            </div>
        </div>
    </div>
    <!-- ./PESO CHART -->
</div>
<!-- AVALIAÇÕES - Fim -->

