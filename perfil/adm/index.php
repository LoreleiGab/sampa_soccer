<?php
include "includes/menu.php";
$idUser = $_SESSION['idUser'];
$user = recuperaDados("usuarios","id",$idUser);
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
          <h1>SACC - Sistema de Avaliação e Controle de Carga</h1>
      </section>

    <!-- Main content -->
      <section class="content">

          <div class="row">
              <!-- /.col -->
              <div class="col-md-12">
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-aqua-active">
                          <h3 class="widget-user-username"><?= $user['nome'] ?></h3>
                          <h5 class="widget-user-desc"><?= $user['empresa'] ?></h5>
                      </div>
                      <div class="box-footer">
                          <div class="row">
                              <div class="col-sm-4 border-right">
                                  <div class="description-block">
                                      <h5 class="description-header">Email</h5>
                                      <span class="description-text"><?= $user['email'] ?></span>
                                  </div>
                                  <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-4 border-right">
                                  <div class="description-block">
                                      <h5 class="description-header">Telefone</h5>
                                      <span class="description-text"><?= $user['telefone'] ?></span>
                                  </div>
                                  <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-4">
                                  <div class="description-block">
                                      <h5 class="description-header">Ativado até</h5>
                                      <span class="description-text"><?= dataBR($user['data_ativacao'])?></span>
                                  </div>
                                  <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                          </div>
                          <!-- /.row -->
                      </div>
                  </div>
                  <!-- /.widget-user -->
              </div>
              <!-- /.col -->

          </div>
          <!-- /.row -->

      </section>
    <!-- /.content -->
  </div>
