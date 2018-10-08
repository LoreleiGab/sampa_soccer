<?php
//carrega as funcoes gerais
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

//carrega o cabeçalho
require "cabecalho.php";

// carrega o perfil
if(isset($_GET['perfil']))
{
    include "../perfil/".$_GET['perfil'].".php";
}
else
{
    include "../perfil/administrador.php";
}

//carrega o rodapé
include "rodape.php";