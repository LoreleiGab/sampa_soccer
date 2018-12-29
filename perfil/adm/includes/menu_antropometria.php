<?php
/**
 * Created by PhpStorm.
 * User: lorel
 * Date: 22/12/2018
 * Time: 10:55
 */

$con = bancoMysqli();
$sql_estatura = "SELECT * FROM estaturas WHERE cliente_id = '$idCliente'";
$query_estatura = mysqli_query($con,$sql_estatura);
$estatura = mysqli_fetch_array($query_estatura);
if($estatura == NULL) {
    $link = "?perfil=administrador&p=estatura_add";
}
else{
    $link = "?perfil=administrador&p=estatura_edit";
}
?>
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="?perfil=administrador&p=peso_altura_list">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>
                <div class="info-box-content">
                    <h3>Peso e altura</h3>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="<?= $link ?>">
            <div class="info-box bg-lime">
                <span class="info-box-icon"><i class="fa fa-male"></i></span>
                <div class="info-box-content">
                    <h3>Estatura prevista</h3>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="?perfil=administrador&p=perimetria_list">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion ion-stats-bars"></i></span>
                <div class="info-box-content">
                    <h3>Perimetria</h3>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="?perfil=administrador&p=dobras_list">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="ion ion-pie-graph"></i></span>
                <div class="info-box-content">
                    <h3>Dobras</h3>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="?perfil=administrador&p=mapeamento_corporal">
            <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="ion ion-person-add"></i></span>
                <div class="info-box-content">
                    <h3>Mapeamento corporal</h3>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- /.col -->
</div>