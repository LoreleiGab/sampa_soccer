<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 29/12/2018
 * Time: 18:10
 */
?>
<div class="row">
    <!-- JACKSON POLLOCK 7 -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Jackson Pollock 7 dobras</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
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
                            <th>% Gordura</th>
                            <th>Massa Magra</th>
                            <th>Massa Gorda</th>
                        </tr>
                        </thead>
                        <?php
                        echo "<tbody>";
                        while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                            $jp = jackson($avaliacao['id']);
                            echo "<tr>";
                            echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                            echo "<td>" . $jp['gordura7'] . "</td>";
                            echo "<td>" . $jp['mg7'] ."</td>";
                            echo "<td>" . $jp['mm7'] . "</td>";
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
    </div>
    <!-- ./JACKSON POLLOCK 7 -->
    <!-- JACKSON POLLOCK 3 -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Jackson Pollock 3 dobras</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
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
                            <th>% Gordura</th>
                            <th>Massa Magra</th>
                            <th>Massa Gorda</th>
                        </tr>
                        </thead>
                        <?php
                        echo "<tbody>";
                        if($cliente['classificacao_id'] == 3) {
                            $aluno = recuperaDados("alunos", "cliente_id", $idCliente);
                            if($aluno['sexo_id'] == 2){
                                while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                    $jp = jackson($avaliacao['id']);
                                    echo "<tr>";
                                    echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                    echo "<td>" . $jp['gordura3'] . "</td>";
                                    echo "<td>" . $jp['mg3'] . "</td>";
                                    echo "<td>" . $jp['mm3'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                            else{
                                while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                    $jp = jackson($avaliacao['id']);
                                    echo "<tr>";
                                    echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                    echo "<td>" . $jp['gordura3'] . "</td>";
                                    echo "<td>" . $jp['mg3'] . "</td>";
                                    echo "<td>" . $jp['mm3'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        else{
                            while ($avaliacao = mysqli_fetch_array($query_avaliacao)) {
                                $jp = jackson($avaliacao['id']);
                                echo "<tr>";
                                echo "<td>" . dataBR($avaliacao['data']) . "</td>";
                                echo "<td>" . $jp['gordura3'] . "</td>";
                                echo "<td>" . $jp['mg3'] . "</td>";
                                echo "<td>" . $jp['mm3'] . "</td>";
                                echo "</tr>";
                            }
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
    </div>
    <!-- ./JACKSON POLLOCK 3 -->
</div>
