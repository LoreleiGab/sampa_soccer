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
                        <h3 class="box-title">Cadastro de Atleta</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="row" align="center">
                        <?php if(isset($mensagem)){echo $mensagem;};?>
                    </div>
                    <form method="POST" action="?perfil=administrador&p=atleta_edit" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nome">Nome completo</label>
                                <input type="text" id="nome" name="nome" class="form-control" maxlength="180">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="data_nascimento">Data de Nascimento</labeL>
                                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="telefone01">Telefone #1</labeL>
                                    <input type="text" id="telefone01" name="telefone01" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="telefone02">Telefone #2</labeL>
                                    <input type="text" id="telefone02" name="telefone02" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <labeL for="email">Email</labeL>
                                    <input type="email" id="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <labeL for="apelido">Apelido</labeL>
                                    <input type="text" id="apelido" name="apelido" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="posicao">Posição</labeL>
                                    <input type="text" id="posicao" name="posicao" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <labeL for="pe_dominante">Pé dominante</labeL>
                                    <input type="text" id="pe_dominante" name="pe_dominante" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="clube">Clube</labeL>
                                    <input type="text" id="clube" name="clube" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <labeL for="categoria">Categoria</labeL>
                                    <input type="text" id="categoria" name="categoria" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <labeL for="contatos">Contatos</labeL>
                                <input id="contatos" type="text" name="contatos" class="form-control" maxlength="255">
                            </div>
                            <div class="form-group">
                                <labeL for="ultimos_clubes">Últimos clubes</labeL>
                                <input type="text" id="ultimos_clubes" name="ultimos_clubes" class="form-control" maxlength="255">
                            </div>
                            <div class="form-group">
                                <label for="diagnostico">Diagnóstico</label>
                                <textarea class="form-control" rows="5" id="diagnostico" name="diagnostico"></textarea>
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