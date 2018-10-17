<?php
include "includes/menu.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cliente</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastro</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=cliente_edit" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Classificação do cliente</label>
                                <select class="form-control" name="classificacao_id">
                                    <option value="">Selecione...</option>
                                    <?php
                                    geraOpcao("classificacao","")
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nome completo</label>
                                <input type="text" name="nome" class="form-control" maxlength="180">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL>Apelido</labeL>
                                    <input type="text" name="apelido" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Posição</labeL>
                                    <input type="text" name="posicao" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL>Pé dominante</labeL>
                                    <input type="text" name="pe_dominante" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Clube</labeL>
                                    <input type="text" name="clube" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Categoria</labeL>
                                    <input type="text" name="categoria" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL>Data de Nascimento</labeL>
                                    <input type="date" name="data_nascimento" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Telefone #1</labeL>
                                    <input type="text" name="telefone01" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL>Telefone #2</labeL>
                                    <input type="text" name="telefone02" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL>Email</labeL>
                                    <input type="text" name="email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Diagnóstico</label>
                                <textarea class="form-control" rows="5" name="diagnostico"></textarea>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-default">Cancela</button>
                            <button type="submit" name="cadastrar" class="btn btn-info pull-right">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>