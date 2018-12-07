<style>
    .disabled {
        pointer-events:none; //This makes it not clickable
        opacity:0.6;         //This grays it out to look disabled
    }
</style>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-plus"></i> <span>Novo Cliente</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="?perfil=administrador&p=atleta_add"><i class="fa fa-futbol-o"></i> Atleta</a></li>
                    <li><a href="?perfil=administrador&p=base_add"><i class="fa fa-child"></i> Base</a></li>
                    <li><a href="?perfil=administrador&p=aluno_add"><i class="fa fa-male"></i> Aluno</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Clientes cadastrados</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="?perfil=administrador&p=atleta_list"><i class="fa fa-futbol-o"></i> Atleta</a></li>
                    <li><a href="?perfil=administrador&p=base_list"><i class="fa fa-child"></i> Base</a></li>
                    <li><a href="?perfil=administrador&p=aluno_list"><i class="fa fa-male"></i> Aluno</a></li>
                    <li><a href="?perfil=administrador&p=cliente_list"><i class="fa fa-list"></i> Listar todos</a>
                </ul>
            </li>
            <?php
            /*
             * Se existir cliente
             */
            if(isset($_SESSION['idCliente'])){
                $cliente = recuperaDados("clientes","id",$_SESSION['idCliente']);
            ?>
                <li class="header">CLIENTE</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book"></i> <span>Cadastro</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <!--<li><a href="?perfil=administrador&p=cliente_resumo"><i class="fa fa-circle-o"></i> Resumo</a></li>-->
                        <?php
                        if($cliente['classificacao_id'] == 1) {
                            echo "<li><a href=\"?perfil=administrador&p=atleta_edit\"><i class=\"fa fa-futbol-o\"></i> Dados pessoais</a></li>";
                        }
                        if($cliente['classificacao_id'] == 2) {
                            echo "<li><a href=\"?perfil=administrador&p=base_edit\"><i class=\"fa fa-child\"></i> Dados pessoais</a></li>";
                        }
                        if($cliente['classificacao_id'] == 3) {
                            echo "<li><a href=\"?perfil=administrador&p=aluno_edit\"><i class=\"fa fa-male\"></i> Dados pessoais</a></li>";
                        }
                        /* plano */
                        $matricula = recuperaDados("planos","cliente_id",$_SESSION['idCliente']);
                        if($matricula == NULL){
                            echo "<li><a href=\"?perfil=administrador&p=plano_add\"><i class=\"fa fa-circle-o\"></i> Plano</a></li>";
                        }
                        else{
                            echo "<li><a href=\"?perfil=administrador&p=plano_edit\"><i class=\"fa fa-circle-o\"></i> Plano</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-circle-o text-green"></i> <span>Antropometria</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="?perfil=administrador&p=peso_altura_list"><i class="fa fa-circle-o"></i> Peso / Altura</a></li>
                        <li><a href="?perfil=administrador&p=perimetria_list"><i class="fa fa-circle-o"></i> Perimetria</a></li>
                        <li class="disabled"><a href="?perfil=administrador&p=dobras_list"><i class="fa fa-circle-o"></i> Dobras</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Mapeamento corporal</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-circle-o text-lime"></i> <span>Testes</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="disabled"><a href="?perfil=administrador&p=wells_list"><i class="fa fa-circle-o"></i> Banco de Wells</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Salto horizontal</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Saltos 1 minuto</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Yoyo test</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Rast test</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Six mobility</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-circle-o text-aqua"></i> <span>Controle de carga</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Minutagem</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Tempo treinado</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Tempo jogado</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Distância</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> PSE</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Peso corporal</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Atividades</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-circle-o text-light-blue"></i> <span>Resultados</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> IMC</a></li>
                        <?php
                        /* estatura */
                        $estatura = recuperaDados("estaturas","cliente_id",$_SESSION['idCliente']);
                        if($estatura == NULL){
                            echo "<li class='disabled'><a href=\"?perfil=administrador&p=estatura_add\"><i class=\"fa fa-circle-o\"></i> Estatura</a></li>";
                        }
                        else{
                            echo "<li class='disabled'><a href=\"?perfil=administrador&p=estatura_edit\"><i class=\"fa fa-circle-o\"></i> Estatura</a></li>";
                        }
                        ?>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Percentual de gordura</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Massa magra</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Massa gorda</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-circle-o text-purple"></i> <span>Relatório</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Cardápio</a></li>
                        <li class="disabled"><a href="#"><i class="fa fa-circle-o"></i> Treino</a></li>
                    </ul>
                </li>
            <?php
            }
            /*
             * ./Se existir cliente
             */
            ?>
            <li class="header">OUTROS</li>
            <li><a href="?perfil=administrador"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="../include/logoff.php"><i class="fa fa-sign-out"></i><span>Sair</span></a></li>
            <!--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Avaliações</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="disabled"><a href="?perfil=administrador&p=avaliacao_add"><i class="fa fa-circle-o"></i> Cadastro</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Boxed</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Level One
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>