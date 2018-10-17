<?php
	date_default_timezone_set("Brazil/East");
	function verificaMysql($sql_inserir)
	{
		//Verifica erro na string/query
		$mysqli = new mysqli("localhost", "root", "lic54eca","igsisbeta");
		if (!$mysqli->query($sql_inserir))
		{
			printf("Errormessage: %s\n", $mysqli->error);
		}
	}
	function habilitarErro()
	{
		@ini_set('display_errors', '1');
		error_reporting(E_ALL);
	}
	function verificaSessao($idUsuario)
	{
		$con = bancoMysqli();
		$time = date('Y-m-d H:i:s');
		$ip = $_SERVER["REMOTE_ADDR"];
		//Verifica se o usuário está no banco
		$sql_busca = "SELECT * FROM igsis_time WHERE idUsuario = '$idUsuario' AND ip = '$ip'";
		$query_busca = mysqli_query($con,$sql_busca);
		$numero_busca = mysqli_num_rows($query_busca);
		if($numero_busca > 0)
		{
			$sql_atualiza = "UPDATE igsis_time SET time = '$time', ip = '$ip' WHERE idUsuario = '$idUsuario'";
			mysqli_query($con,$sql_atualiza); 
		}
		else
		{
			$sql_insere = "INSERT INTO igsis_time (`id`, `idUsuario`, `time`, `ip`) VALUES (NULL, '$idUsuario', '$time', '$ip')";
			mysqli_query($con,$sql_insere);
		}
	}
	// Framework
	
	//saudacao inicial
	function saudacao()
	{ 
		$hora = date('H');
		if(($hora > 12) AND ($hora <= 18))
		{
			return "Boa tarde";	
		}
		else if(($hora > 18) AND ($hora <= 23))
		{
			return "Boa noite";	
		}
		else if(($hora >= 0) AND ($hora <= 4))
		{
			return "Boa noite";	
		}
		else if(($hora > 4) AND ($hora <=12))
		{
			return "Bom dia";
		}
	}
	// Formatação de datas, valores
	// Retira acentos das strings
	function semAcento($string)
	{
		$newstring = preg_replace("/[^a-zA-Z0-9_.]/", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
		return $newstring;
	}
	//retorna data d/m/y de mysql/date(a-m-d)
	function exibirDataBr($data)
	{
		$timestamp = strtotime($data); 
		return date('d/m/Y', $timestamp);	
	}
	// retorna datatime sem hora
	function retornaDataSemHora($data)
	{
		$semhora = substr($data, 0, 10);
		return $semhora;
	}	
	//retorna data d/m/y de mysql/datetime(a-m-d H:i:s)	
	function exibirDataHoraBr($data)
	{
		$timestamp = strtotime($data); 
		return date('d/m/y - H:i:s', $timestamp);	
	}
	//retorna hora H:i de um datetime
	function exibirHora($data)
	{
		$timestamp = strtotime($data); 
		return date('H:i', $timestamp);	
	}
	//retorna data mysql/date (a-m-d) de data/br (d/m/a)
	function exibirDataMysql($data)
	{ 
		list ($dia, $mes, $ano) = explode ('/', $data);
		if(strlen($dia) == 1){
			$dia = "0".$dia;
		}
		if(strlen($mes) == 1){
			$dia = "0".$mes;
		}

		
		$data_mysql = $ano.'-'.$mes.'-'.$dia;
		return $data_mysql;
	}
	//retorna o endereço da página atual
	function urlAtual()
	{
		$dominio= $_SERVER['HTTP_HOST'];
		$url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
		return $url;
	}
	//retorna valor xxx,xx para xxx.xx
	function dinheiroDeBr($valor)
	{
		$valor = str_ireplace(".","",$valor);
		$valor = str_ireplace(",",".",$valor);
		return $valor;
	}
	//retorna valor xxx.xx para xxx,xx
	function dinheiroParaBr($valor)
	{ 
		$valor = number_format($valor, 2, ',', '.');
		return $valor;
	}
	//use em problemas de codificacao utf-8
	function _utf8_decode($string)
	{
		$tmp = $string;
		$count = 0;
		while (mb_detect_encoding($tmp)=="UTF-8")
		{
			$tmp = utf8_decode($tmp);
			$count++;
		}
		for ($i = 0; $i < $count-1 ; $i++)
		{
			$string = utf8_decode($string);
		}
		return $string;
	}
	//retorna o dia da semana segundo um date(a-m-d)
	function diasemana($data)
	{
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana)
		{
			case"0": $diasemana = "Domingo";       break;
			case"1": $diasemana = "Segunda-Feira"; break;
			case"2": $diasemana = "Terça-Feira";   break;
			case"3": $diasemana = "Quarta-Feira";  break;
			case"4": $diasemana = "Quinta-Feira";  break;
			case"5": $diasemana = "Sexta-Feira";   break;
			case"6": $diasemana = "Sábado";        break;
		}
		return "$diasemana";
	}
	//soma(+) ou substrai(-) dias de um date(a-m-d)
	function somarDatas($data,$dias)
	{
		$data_final = date('Y-m-d', strtotime("$dias days",strtotime($data)));	
		return $data_final;
	}
	//retorna a diferença de dias entre duas datas
	function diferencaDatas($data_inicial,$data_final)
	{
		// Define os valores a serem usados
		// Usa a função strtotime() e pega o timestamp das duas datas:
		$time_inicial = strtotime($data_inicial);
		$time_final = strtotime($data_final);
		// Calcula a diferença de segundos entre as duas datas:
		$diferenca = $time_final - $time_inicial; // 19522800 segundos
		// Calcula a diferença de dias
		$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
		return $dias;
	}
	//Outras bibliotecas
	//envia um email pela conta igccsp2015@gmail.com é preciso que a classe phpmailer esteja instalada - vale dar uma revisada geral
	function enviarEmail($conteudo_email, $instituicao, $subject, $idEvento, $num_pedidos )
	{
		require_once('../include/phpmailer/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
		try
		{
			//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
			$mail->CharSet = 'UTF-8';
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
			$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
			$mail->Username   = "";  // GMAIL username
			$mail->Password   = "";            // GMAIL password
			$mail->AddReplyTo('sistema.igsis@gmail.com', 'IGSIS');
			//criar laço com todos os interessados
			$con = bancoMysqli();
			if($num_pedidos == -1)
			{
				$sql_user = "SELECT DISTINCT ig_usuario.nomeCompleto, ig_usuario.email 
					FROM ig_usuario, ig_papelusuario 
					WHERE ig_papelusuario.idPapelUsuario = ig_usuario.ig_papelusuario_idPapelUsuario 
					AND ig_usuario.receberNotificacao = '1' 
					AND (ig_papelusuario.admin = '1' OR ig_papelusuario.administrador = '1')";
				$query_user = mysqli_query($con,$sql_user);
				while($campo_user = mysqli_fetch_array($query_user))
				{
					$mail->AddBCC($campo_user['email'],$campo_user['nomeCompleto']);
				}
			}
			else
			{
				$sql_user = "SELECT DISTINCT ig_usuario.nomeCompleto, ig_usuario.email 
					FROM ig_usuario, ig_papelusuario 
					WHERE ig_usuario.idInstituicao = '$instituicao' 
					AND ig_papelusuario.idPapelUsuario = ig_usuario.ig_papelusuario_idPapelUsuario 
					AND ig_usuario.receberNotificacao = '1' 
					AND(
						ig_papelusuario.admin = '1' OR
						ig_papelusuario.administrador = '1' OR
						ig_papelusuario.comunicacao = '1' OR
						ig_papelusuario.financa = '1' OR
						ig_papelusuario.producao = '1' OR
						ig_papelusuario.curadoria = '1' OR
						ig_papelusuario.bilhetagem = '1' OR
						ig_papelusuario.servicos = '1')"; //mudar para 2
				$query_user = mysqli_query($con,$sql_user);
				while($campo_user = mysqli_fetch_array($query_user))
				{	
					$mail->AddBCC($campo_user['email'],$campo_user['nomeCompleto']);
				}
				// Responsáveis pelo evento
				$user = recuperaDados("ig_evento",$idEvento,"idEvento");
				$usuario = recuperaDados("ig_usuario",$user['idUsuario'],"idUsuario");
				$fiscal = recuperaDados("ig_usuario",$user['idResponsavel'],"idUsuario");
				$suplente = recuperaDados("ig_usuario",$user['suplente'],"idUsuario");
				if($usuario['receberNotificacao'] == 1)
				{
					$mail->AddBCC($usuario['email'],$usuario['nomeCompleto']);
				}
				if($fiscal['receberNotificacao'] == 1)
				{
					$mail->AddBCC($fiscal['email'],$fiscal['nomeCompleto']);
				}
				if($suplente['receberNotificacao'] == 1)
				{
					$mail->AddBCC($suplente['email'],$suplente['nomeCompleto']);
				}
				if($num_pedidos > 0)
				{
					$sql_user = "SELECT nomeCompleto, email 
						FROM ig_usuario 
						WHERE contratos IS NOT NULL 
						AND receberNotificacao = '1'"; //seleciona somente a área de contratos
					$query_user = mysqli_query($con,$sql_user);
					while($campo_user = mysqli_fetch_array($query_user))
					{
						$mail->AddBCC($campo_user['email'],$campo_user['nomeCompleto']);
					}
				}
			}
			//$mail->AddAddress(emailUserLogin($logado), nomeUserLogin($logado));
			$mail->SetFrom('sistema.igsis@gmail.com', 'IGSIS');
			$mail->AddReplyTo('sistema.igsis@gmail.com', 'IGSIS');
			//assunto da IGCCSP 	
			$mail->Subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			//	Criar uma variável com as informações
			$mail->MsgHTML(utf8_decode ($conteudo_email));
			$mail->Send();
			return "Um email foi enviado para seu endereço eletrônico cadastrado.</p>\n";
		}
		catch (phpmailerException $e)
		{
			return $e->errorMessage(); //Pretty error messages from PHPMailer
		}
		catch (Exception $e)
		{
			return $e->getMessage(); //Boring error messages from anything else!
		}
	}
	function enviarEmailSimples($conteudo_email, $subject, $toEmail, $toUsuario, $fromEmail, $fromUsuario )
	{
		//envia um email pela conta igccsp2015@gmail.com é preciso que a classe phpmailer esteja instalada - vale dar uma revisada geral
		require_once('../include/phpmailer/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
		try
		{
			//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
			$mail->CharSet = 'UTF-8';
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
			$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
			$mail->Username   = "";  // GMAIL username
			$mail->Password   = "";            // GMAIL password
			$mail->AddAddress($toEmail,$toUsuario);
			$mail->AddBcc("igccsp2015@gmail.com"); //hidden copy to igcssp2015
			//$mail->AddAddress(emailUserLogin($logado), nomeUserLogin($logado));
			$mail->SetFrom($fromEmail, $fromUsuario);
			$mail->AddReplyTo($fromEmail, $fromUsuario);
			//assunto da IGCCSP
			$mail->Subject = $subject;
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			//	Criar uma variável com as informações
			$mail->MsgHTML($conteudo_email);
			$mail->Send();
		}
		catch (phpmailerException $e)
		{
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
		}
		catch (Exception $e)
		{
			echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
	function verificaOpcao($opcao)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_opcoes WHERE opcao = '$opcao' LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$valor = mysqli_fetch_array($query);
		return $valor['valor'];	
	}
	function gravarLog($log)
	{
		//grava na tabela ig_log os inserts e updates
		$valor = verificaOpcao("log"); //verifica se a opção de gravação de log está habilitada
		if($valor == 1)
		{
			$logTratado = addslashes($log);
			$idUsuario = $_SESSION['idUsuario'];
			$ip = $_SERVER["REMOTE_ADDR"];
			$data = date('Y-m-d H:i:s');
			$sql = "INSERT INTO `ig_log` (`idLog`, `ig_usuario_idUsuario`, `enderecoIP`, `dataLog`, `descricao`) 
				VALUES (NULL, '$idUsuario', '$ip', '$data', '$logTratado')";
			$mysqli = bancoMysqli();
			$mysqli->query($sql);
		}
	}
	function geraOpcaoPublicado($tabela,$select,$instituicao)
	{
		//gera os options de um select
		if($instituicao != "")
		{
			$sql = "SELECT * FROM $tabela WHERE publicado = 0 AND idInstituicao = $instituicao OR idInstituicao = 999  ";
		}
		else
		{
			$sql = "SELECT * FROM $tabela WHERE publicado = 1";
		}
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";	
			}
		}
	}
	function geraOpcao($tabela,$select,$instituicao)
	{
		//gera os options de um select
		if($instituicao != "")
		{
			$sql = "SELECT * FROM $tabela WHERE idInstituicao = $instituicao OR idInstituicao = 999 ORDER BY 2 ASC";
		}
		else
		{
			$sql = "SELECT * FROM $tabela ORDER BY 2";
		}
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";	
			}
		}
	}
	function geraOpcaoRelJuridica($select,$idUsuario)
	{
		//gera os options de um select
		$con = bancoMysqli();
		$usuario = recuperaDados("ig_usuario",$idUsuario,"idUsuario");
		$verbas = $usuario['verba'];
		$sql = "SELECT * FROM sis_verba WHERE Id_Verba IN ($verbas)";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";	
			}
		}
	}
	function geraOpcaoOrder($tabela,$select,$instituicao)
	{
		//gera os options de um select
		if($instituicao != "")
		{
			$sql = "SELECT * FROM $tabela WHERE idInstituicao = $instituicao OR idInstituicao = 999 ORDER BY Verba ASC";
		}
		else
		{
			$sql = "SELECT * FROM $tabela ORDER BY Verba ASC";
		}
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";	
			}
		}
	}
	function geraOpcaoTipoChamado($select)
	{
		//gera os options de um select
		$sql = "SELECT * FROM igsis_tipo_chamado WHERE tipo='1'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_row($query))
		{
			if($option[0] == $select)
			{
				echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
			}
			else
			{
				echo "<option value='".$option[0]."'>".$option[1]."</option>";	
			}
		}
	}
	function geraOpcaoPai($tabela,$select,$instituicao)
	{
		if($instituicao != "")
		{
			$sql = "SELECT * FROM $tabela WHERE idInstituicao = $instituicao OR idInstituicao = 999";
		}
		else
		{
			$sql = "SELECT * FROM $tabela";
		}
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_array($query))
		{
			if($option['pai'] != NULL)
			{
				if($option[0] == $select)
				{
					echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
				}
				else
				{
					echo "<option value='".$option[0]."'>".$option[1]."</option>";	
				}
			}
		}
	}
	function geraOpcaoSub($idEvento,$selecionado)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_sub_evento WHERE ig_evento_idEvento = '$idEvento' AND publicado = '1'";
		$query = mysqli_query($con,$sql);
		while($option = mysqli_fetch_array($query))
		{
			if($option['idSubEvento'] == $selecionado)
			{
				echo "<option value='".$option['idSubEvento']."' selected >".$option['titulo']."</option>";	
			}
			else
			{
				echo "<option value='".$option['idSubEvento']."'>".$option['titulo']."</option>";	
			}
		}		
	}
	function recuperaModulo($modulo)
	{
		$sql = "SELECT * FROM modulos WHERE sigla = '$modulo'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$modulo = mysqli_fetch_array($query);
		return $modulo;
	}
	function listaModulos($perfil)
	{
		//gera as tds dos módulos a carregar
		// recupera quais módulos o usuário tem acesso
		$sql = "SELECT * FROM ig_papelusuario WHERE idPapelUsuario = $perfil"; 
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campoFetch = mysqli_fetch_array($query);
		while($fieldinfo = mysqli_fetch_field($query))
		{
			if(($campoFetch[$fieldinfo->name] == 1) AND ($fieldinfo->name != 'idPapelUsuario'))
			{
				$descricao = recuperaModulo($fieldinfo->name);
				echo "<tr>";
				echo "<td class='list_description'><b>".$descricao['nome']."</b></td>";
				echo "<td class='list_description'>".$descricao['descricao']."</td>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=$fieldinfo->name'>
							<input type ='submit' class='btn btn-theme btn-lg btn-block' value='carregar'></td></form>"	;
				echo "</tr>";
			}
		}
	}
	function listaModulosAlfa($perfil)
	{
		//gera as tds dos módulos a carregar
		$con = bancoMysqli();
		// recupera os módulos do sistema
		$sql_modulos = "SELECT pag FROM ig_modulo ORDER BY nome";
		$query_modulos = mysqli_query($con,$sql_modulos);
		while($modulos = mysqli_fetch_array($query_modulos))
		{
			$sql = "SELECT * FROM ig_papelusuario WHERE idPapelUsuario = $perfil"; 
			$query = mysqli_query($con,$sql);
			$campoFetch = mysqli_fetch_array($query);
			if(($campoFetch[$modulos['pag']] == 1) AND ($campoFetch[$modulos['pag']] != 'idPapelUsuario'))
			{
				$descricao = recuperaModulo($modulos['pag']);
				echo "<tr>";
				echo "<td class='list_description'><b>".$descricao['nome']."</b></td>";
				echo "<td class='list_description'>".$descricao['descricao']."</td>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=".$modulos['pag']."' >
							<input type ='submit' class='btn btn-theme btn-lg btn-block' value='carregar'></td></form>"	;
				echo "</tr>";
			}
		}	
	}
	function verificaAcesso($usuario,$pagina)
	{
		//verifica se o usuário tem permissão de acesso a uma determinada página
		$sql = "SELECT * FROM ig_usuario,ig_papelusuario 
			WHERE ig_usuario.idUsuario = $usuario 
			AND ig_usuario.ig_papelusuario_idPapelUsuario = ig_papelusuario.idPapelUsuario LIMIT 0,1";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$verifica = mysqli_fetch_array($query);
		if($verifica["$pagina"] == 1)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	function recuperaEvento($idEvento)
	{
		//retorna uma array com os dados da tabela ig_evento
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_evento WHERE idEvento = '$idEvento' LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo;		
	}
	function recuperaDados($tabela,$idEvento,$campo)
	{
		//retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
		$con = bancoMysqli();
		$sql = "SELECT * FROM $tabela WHERE ".$campo." = '$idEvento' LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo;		
	}
	function opcaoUsuario($idInstituicao,$idUsuario)
	{
		//cria as options com usuários de uma instituicao
		$sql = "SELECT DISTINCT * FROM ig_usuario,ig_papelusuario 
			WHERE ig_usuario.ig_papelusuario_idPapelUsuario = ig_papelusuario.idPapelUsuario 
			AND ig_papelusuario.evento = 1 
			ORDER BY nomeCompleto";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($campo = mysqli_fetch_array($query))
		{
			if($campo['idUsuario'] == $idUsuario)
			{
				echo "<option value=".$campo['idUsuario']." selected >".$campo['nomeCompleto']."</option>";
			}
			else
			{
				echo "<option value=".$campo['idUsuario']." >".$campo['nomeCompleto']."</option>";
			}
		}	
	}
	function verificaExiste($idTabela,$idCampo,$idDado,$st)
	{
		//retorna uma array com indice 'numero' de registros e 'dados' da tabela
		$con = bancoMysqli();
		if($st == 1)
		{
			// se for 1, é uma string
			$sql = "SELECT * FROM $idTabela WHERE $idCampo = '%$idDado%'";
		}
		else
		{
			$sql = "SELECT * FROM $idTabela WHERE $idCampo = '$idDado'";
		}
		$query = mysqli_query($con,$sql);
		$numero = mysqli_num_rows($query);
		$dados = mysqli_fetch_array($query);
		$campo['numero'] = $numero;
		$campo['dados'] = $dados;	
		return $campo;
	}
	function retornaUltimo($idTabela)
	{
		//retorna o id do ultimo dado inserido. em desuso e subsitutir por mysqli_insert_id()
		$sql_ultimo = "SELECT * FROM $idTabela ORDER BY idEvento DESC LIMIT 1";
		$id_evento = mysql_query($sql_ultimo);
		$id = mysql_fetch_array($id_evento);
		$_SESSION['idEvento'] = $id['idEvento'];
	}
	function recuperaIdDado($tabela,$id)
	{ 
		$con = bancoMysqli();
		//recupera os nomes dos campos
		$sql = "SELECT * FROM $tabela";
		$query = mysqli_query($con,$sql);
		$campo01 = mysqli_field_name($query, 0);
		$campo02 = mysqli_field_name($query, 1);	
		$sql = "SELECT * FROM $tabela WHERE $campo01 = $id";
		$query = mysql_query($sql);
		$campo = mysql_fetch_array($query);
		return $campo[$campo02];
	}
	function recuperaProdutor($idProdutor)
	{
		//recupera dados da tabela produtor
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_produtor WHERE idProdutor = $idProdutor";
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo;	
	}
	function listaEventosGravados($idUsuario)
	{
		//tabela para gerenciar eventos em aberto
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_evento 
		WHERE publicado = 1 
		AND (idUsuario = '$idUsuario' OR suplente = '$idUsuario' OR idResponsavel = '$idUsuario') 
		AND dataEnvio IS NULL ORDER BY idEvento DESC";
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td width='5%'>ID evento</td>
						<td>Nome do evento</td>
						<td>Tipo de evento</td>
						<td>Data/Período</td>
						<td>Status do evento</td>
						<td width='10%'></td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
				$chamado = recuperaAlteracoesEvento($campo['idEvento']);
				echo "<tr>";
				echo "<td class='list_description'>".$campo['idEvento']."</td>";
				echo "<td class='list_description'>".$campo['nomeEvento']." <a href='?perfil=chamado&p=evento&id=".$campo['idEvento']."' target='_blank'>[".$chamado['numero']."]</a></td>";
				echo "<td class='list_description'>".retornaTipo($campo['ig_tipo_evento_idTipoEvento'])."</td>";
				echo "<td class='list_description'>".retornaPeriodo($campo['idEvento'])."</td>";
				If ($campo['statusEvento'] == "Aguardando")
				{
					echo "<td class='list_description'>Aguardando Aprovação";
				}
				elseif ($campo['statusEvento'] == "Enviado")
				{
					echo "<td class='list_description'>Aprovado</td>";
				}
				elseif ($campo['statusEvento'] == "Não Aprovado")
				{
					echo "<td class='list_description'><a href='?perfil=evento&p=naoaprovado&idEvento=".$campo['idEvento']."' target='_blank'><font color='red'>Não Aprovado</font></a></td>";
				}
				else
				{
					echo "<td class='list_description'>Em Elaboração</td>";
				}
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=evento&p=basica'>
							<input type='hidden' name='carregar' value='".$campo['idEvento']."' />
							<input type ='submit' class='btn btn-theme btn-block' value='carregar'></td></form>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=evento&p=carregar'>
							<input type='hidden' name='apagar' value='".$campo['idEvento']."' />
							<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
				echo "</tr>";		
		}
		echo "
			</tbody>
			</table>";
	}
	function retornaInstituicao($local)
	{ 
		$con = bancoMysqli();
		$sql = "SELECT idInstituicao FROM ig_local WHERE idLocal = $local";
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo['idInstituicao'];
	}
	function listaOcorrencias($idEvento)
	{
		//lista ocorrencias de determinado evento
		$sql = "SELECT * FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			AND idTipoOcorrencia <> '5' 
			ORDER BY dataInicio";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td>Ocorrência</td>
						<td width='10%'></td>
						<td width='10%'></td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			$tipo_de_evento = retornaTipoOcorrencia($campo['idTipoOcorrencia']); // retorna o tipo de ocorrência
			if($campo['idSubEvento'] != NULL)
			{
				$sub = recuperaDados("ig_sub_evento",$campo['idSubEvento'],"idSubEvento");
			}
			else
			{
				$sub['titulo'] = "";		
			}
			if($campo['dataFinal'] == '0000-00-00')
			{
				$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
				$semana = "";
			}
			else
			{
				$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
				if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
				if($campo['terca'] == 1){$ter = "terça";}else{$ter = "";}
				if($campo['quarta'] == 1){$qua = "quarta";}else{$qua = "";}
				if($campo['quinta'] == 1){$qui = "quinta";}else{$qui = "";}
				if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
				if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
				if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
				$semana = "(".$seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom.")";	
			}
			if($campo['diaEspecial'] == 1)
			{
				if($campo['libras'] == 1){$libras = "Tradução em libras";}else{$libras = "";}
				if($campo['audiodescricao'] == 1){$audio = "Audiodescrição";}else{$audio = "";}
				if($campo['precoPopular'] == 1){$popular = "Preço popular";}else{$popular = "";}
				if($campo['virada'] == 1){$virada = "Virada Cultural";}else{$virada = "";}
				$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular." ".$virada;
			}
			else
			{
				$dia_especial = "";
			}
			//recuperaDados($tabela,$idEvento,$campo)
			$hora = exibirHora($campo['horaInicio']);
			$duracao = recuperaDuracao($campo ['duracao']);
			$retirada = recuperaIngresso($campo['retiradaIngresso']);
			$observacao = recuperaObservacao($campo['observacao']);
			$valor = dinheiroParaBr($campo['valorIngresso']);
			$local = recuperaDados("ig_local",$campo['local'],"idLocal");
			$espaco = $local['sala'];
			$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
			$instituicao = $inst['instituicao'];
			$id = $campo['idOcorrencia'];
			if($campo['virada'] == 1)
			{
				$hora = "De acordo com a programação da Virada Cultural";
				$local = "De acordo com a programação da Virada Cultural";
				$espaco = "De acordo com a programação da Virada Cultural";	
			}
			$ocorrencia = "<div class='left'>$tipo_de_evento $dia_especial ".
				$sub['titulo']
				."<br />
				Data: $data $semana <br />
				Horário: $hora<br />
				Duração: $duracao<br />
				Local: $espaco - $instituicao<br />
				Retirada de ingresso: $retirada  - Valor: $valor <br />
				Observações: $observacao<br />";
				
			echo "<tr>";
			echo "<td class='list_description'>".$ocorrencia."</td>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=evento&p=ocorrencias&action=editar'>
						<input type='hidden' name='id' value='$id' />
						<input type ='submit' class='btn btn-theme btn-block' value='Editar'></td></form>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=evento&p=ocorrencias&action=listar'>
						<input type='hidden' name='duplicar' value='".$campo['idOcorrencia']."' />
						<input type ='submit' class='btn btn-theme btn-block' value='Duplicar'></td></form>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=evento&p=ocorrencias&action=listar'>
						<input type='hidden' name='apagar' value='".$campo['idOcorrencia']."' />
						<input type ='submit' class='btn btn-theme  btn-block' value='Apagar'></td></form>";
			echo "</tr>";	
		}
		echo "
			</tbody>
			</table>";
	}
	function listaOcorrenciasTexto($idEvento)
	{
		//lista ocorrencias de determinado evento
		$sql = "SELECT * FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = 1 
			AND idTipoOcorrencia NOT LIKE '5' 
			ORDER BY dataInicio";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		if($evento['ig_tipo_evento_idTipoEvento'] != 1)
		{
			while($campo = mysqli_fetch_array($query))
			{
				$tipo_de_evento = retornaTipoOcorrencia($campo['idTipoOcorrencia']); // retorna o tipo de ocorrência
				if($campo['idSubEvento'] != NULL)
				{
					$sub = recuperaDados("ig_sub_evento",$campo['idSubEvento'],"idSubEvento");
				}
				else
				{
					$sub['titulo'] = "";		
				}
				if($campo['dataFinal'] == '0000-00-00')
				{
					$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
					$semana = "";
				}
				else
				{
					$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
					if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
					if($campo['terca'] == 1){$ter = "terça";}else{$ter = "";}
					if($campo['quarta'] == 1){$qua = "quarta";}else{$qua = "";}
					if($campo['quinta'] == 1){$qui = "quinta";}else{$qui = "";}
					if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
					if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
					if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
					$semana = "(".$seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom.")";	
				}
				if($campo['diaEspecial'] == 1)
				{
					if($campo['libras'] == 1){$libras = "Tradução em libras";}else{$libras = "";}
					if($campo['audiodescricao'] == 1){$audio = "Audiodescrição";}else{$audio = "";}
					if($campo['precoPopular'] == 1){$popular = "Preço popular";}else{$popular = "";}
					$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular;
				}
				else
				{
					$dia_especial = "";
				}
				//recuperaDados($tabela,$idEvento,$campo)
				$hora = exibirHora($campo['horaInicio']);
				$duracao = recuperaDuracao($campo ['duracao']);
				$retirada = recuperaIngresso($campo['retiradaIngresso']);
				$observacao = recuperaObservacao($campo['observacao']);
				$valor = dinheiroParaBr($campo['valorIngresso']);
				$local = recuperaDados("ig_local",$campo['local'],"idLocal");
				$espaco = $local['sala'];
				$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
				$instituicao = $inst['instituicao'];
				$id = $campo['idOcorrencia'];
				$ocorrencia = "<div class='left'>
					<strong>$tipo_de_evento $dia_especial ".$sub['titulo']."</strong><br />
					<strong>Data:</strong> $data $semana <br />
					<strong>Horário:</strong> $hora<br />
					<strong>Duração:</strong> $duracao min<br />
					<strong>Local:</strong> $espaco - $instituicao<br />
					<strong>Retirada de ingresso:</strong> $retirada  - Valor: $valor <br />
					<strong>Observações:</strong> $observacao</br></br></div>";
				echo $ocorrencia;
			}
		}
	}
	function resumoOcorrencias($idEvento)
	{
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		$mostra = periodoMostra($idEvento);
		$local = listaLocais($idEvento);
		$localMostra = listaLocaisMostra($idEvento);
		$periodo = retornaPeriodo($idEvento);
		$observacao = recuperaObservacao($idEvento);
		if($evento['ig_tipo_evento_idTipoEvento'] == 1)
		{
			$final = $mostra."<br />".substr($localMostra,1);
			return $final;
		}
		else
		{
			$final = $periodo."<br />".substr($local,1);
			return $final;
		}
	}
	function checar($id)
	{
		//funcao para imprimir checked do checkbox
		if($id == 1)
		{
			echo "checked";	
		}	
	}
	function listaArquivos($idEvento)
	{
		//lista arquivos de determinado evento
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_arquivo WHERE ig_evento_idEvento = '$idEvento' AND publicado = '1'";
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td>Nome do arquivo</td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			echo "<tr>";
			echo "<td class='list_description'><a href='../uploads/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=evento&p=arquivos'>
						<input type='hidden' name='apagar' value='".$campo['idArquivo']."' />
						<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
			echo "</tr>";		
		}
		echo "
			</tbody>
			</table>";	
	}
	function listaArquivosDetalhe($idEvento)
	{
		//lista arquivos de determinado evento
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_arquivo 
			WHERE ig_evento_idEvento = '$idEvento' 
			AND publicado = '1'";
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td></td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			echo "<tr>";
			echo "<td class='list_description'><a href='../uploads/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
			echo "</tr>";		
		}
		echo "
			</tbody>
			</table>";	
	}
	function verificaSubEvento($idEvento)
	{
		//retorna os dados de um subevento
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_sub_evento WHERE ig_evento_idEvento = '$idEvento'";
		$query = mysqli_query($con,$sql);
		//$num = mysqli_num_rows($query);
		//$subEvento['num'] = $num;
		if($num > 0)
		{
			$subEvento = mysql_fetch_array($query);	
		}
		return $subEvento;
	}
	function recuperaUsuario($idUsuario)
	{
		//retorna dados do usuário
		$recupera = recuperaDados('ig_usuario',$idUsuario,'idUsuario');
		if($recupera)
		{
			return $recupera;
		}
		else
		{
			return NULL;
		}	
	}
	function descricaoEvento($idEvento)
	{
		//imprime dados de um evento
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento"); 
		$tipoEvento = recuperaDados('ig_tipo_evento',$evento['ig_tipo_evento_idTipoEvento'],'idTipoEvento');
		$programa = recuperaDados('ig_programa',$evento['ig_programa_idPrograma'],'idPrograma');
		$projetoEspecial = recuperaDados('ig_projeto_especial',$evento['projetoEspecial'],'idProjetoEspecial');
		$relacaojur = recuperaDados('ig_modalidade',$evento['ig_modalidade_IdModalidade'],'idModalidade');
		$usuarioCadastro = recuperaDados("ig_usuario",$evento['idUsuario'],"idUsuario");
		$responsavel = recuperaDados("ig_usuario",$evento['idResponsavel'],"idUsuario");
		$suplente = recuperaDados("ig_usuario",$evento['suplente'],"idUsuario");
		$faixa = recuperaDados('ig_etaria',$evento['faixaEtaria'],'idIdade');
		//exibe as informações principais
		echo "ID do Evento: <b>".$idEvento."</b><br />";
		if($evento['dataEnvio'] != NULL)
		{
			echo "Evento enviado em ".exibirDataHoraBr($evento['dataEnvio'])."<br />";
		}
		echo "<b>Tipo de evento:</b> ".$tipoEvento['tipoEvento']."<br />";
		if($evento['ig_programa_idPrograma'] != 0)
		{
			echo "<b>Programa especial:</b> ".$programa['programa']."<br />";
		}
		if($evento['projetoEspecial'] != 0)
		{
			echo "<b>Projeto especial:</b> ".$projetoEspecial['projetoEspecial']."<br />";
		}
		if($evento['projeto'] != "")
		{
			echo "<b>Projeto:</b> ".$evento['projeto']."<br />";
		}
		if($evento['ig_modalidade_IdModalidade'] != NULL)
		{
			echo "<b>Relação Jurídica:</b> ".$relacaojur['modalidade']."<br />";
		}
		echo "<br />";
		echo "<p align='left'><b>Usuário que cadastrou o evento:</b> ".$usuarioCadastro['nomeCompleto']." <br/><b>Telefone:</b> ".$usuarioCadastro['telefone']." <br/><b>E-mail:</b> ".$usuarioCadastro['email']."</p><br/>";
		echo "<p align='left'><b>Responsável pelo evento:</b> ".$responsavel['nomeCompleto']."<br/><b>Telefone:</b> ".$responsavel['telefone']." <br/><b>E-mail:</b> ".$responsavel['email']."</p><br/>";
		echo "<p align='left'><b>Suplente:</b> ".$suplente['nomeCompleto']."<br/><b>Telefone:</b> ".$suplente['telefone']." <br/><b>E-mail:</b> ".$suplente['email']."</p>";
		echo "<br />";
		echo "<b>Ficha técnica:</b><br />".nl2br($evento['fichaTecnica'])."<br /><br />";
		echo "<b>Faixa ou indicação etária:</b> ".$faixa['faixa']."<br /><br />";
		//echo "<br /><br />";
		echo "<b>Sinopse:</b><br />".nl2br($evento['sinopse'])."<br /><br />";
		echo "<b>Release:</b><br />".nl2br($evento['releaseCom'])."<br /><br />";
		//echo "<b>Duração:</b> ".retornaDuracao($evento['idEvento'])." min.<br /><br />";
		// Foi para área de pedido de contratação
		//echo "<b>Justificativa:</b><br />".$evento['justificativa']."<br /><br />"; 
		//echo "<b>Parecer artístico:</b><br />".$evento['parecerArtistico']."<br /><br />";
	}
	function descricaoEspecificidades($idEvento,$tipo)
	{
		//switch das áreas específicas
		switch($tipo)
		{
			case 2: //artes visuais
				$artes = recuperaDados("ig_artes_visuais",$idEvento,"idEvento");
				echo"
					<strong>Artes Visuais</strong><br />
					Tipo de contratação: ".$artes['tipo'].
					"<br />Número de contratados: ".$artes['numero']."
					<br />Valor total : R$".dinheiroParaBr($artes['valorTotal'])."<br /><br />";
			break;
			case 9:
				$artes = recuperaDados("ig_teatro_danca",$idEvento,"ig_evento_idEvento");
				if($artes['estreia'] == 0)
				{
					$estreia = "Não";
				}
				else
				{
					$estreia = "SIM";
				}
				echo"
					<strong>Teatro / Dança</strong><br />
					Estréia: ".$estreia.
					"<br />Gênero: ".$artes['genero']."<br /><br />";
			break;
			case 5:
				$oficinas = recuperaDados("ig_oficinas",$idEvento,"idEvento");
				if($oficinas['certificado'] == 1)
				{
					echo "<b>Certificado:</b> Sim<br />";	
				}
				if($oficinas['vagas'] != 0)
				{
					echo "<b>Vagas:</b> ".$oficinas['vagas']."<br />"; 	
				}
					if($oficinas['publico'] != "")
					{
						echo "<b>Público:</b> ".$oficinas['publico']."<br />"; 	
					}
					if($oficinas['vagas'] != "")
					{
						echo "<b>Vagas:</b> ".$oficinas['vagas']."<br />"; 	
					}
				if($oficinas['material'] != "")
				{
					echo "<b>Material:</b> ".$oficinas['material']."<br />"; 	
				}
				switch($oficinas['inscricao'])
				{
					case 1:
						echo "<b>Inscrição:</b> Sem necessidade.</br />";
					break;
					case 2:
						echo "<b>Inscrição:</b>Pelo site - ficha de inscrição.</br />"; 	
					break;
					case 3:
						echo "<b>Inscrição:</b>Pelo site - por email.</br />"; 	
					break;
					case 4:
						echo "<b>Inscrição:</b> Pessoalmente.</br />"; 	
					break;
				}
				if($oficinas['valorHora'] != 0)
				{
					echo "<b>Valor/Hora (em reais):</b> ".$oficinas['valorHora']."<br />"; 	
				}
				if($oficinas['divulgacao'] != "0000-00-00")
				{
					echo "<b>Divulgação dos resultados da inscrição:</b> ".exibirDataBr($oficinas['divulgacao'])."(ver data da inscrição em ocorrências).<br />"; 	
				}
				if($oficinas['cargaHoraria'] != 0)
				{
					echo "<b>Carga Horária:</b> ".$oficinas['cargaHoraria']."<br />"; 	
				}
			break;
			case 19:
				$artes = recuperaDados("ig_musica",$idEvento,"ig_evento_idEvento");
				if($artes['venda'] == 0)
				{
					$venda = "Não";
				}
				else
				{
					$venda = "SIM";
				}
				echo"
					<strong>Música</strong><br />
					Gênero: ".$artes['genero'].
					"<br />Venda de material: ".$venda."
					<br />Especificação do material : ".$artes['material']."<br /><br />";
			break;
		}
		//sub-evento
	}
	function verificaEdicao($idEvento)
	{
		//exibe o evento que está sendo editado.
		if(isset($idEvento))
		{
			if($idEvento != '')
			{
				$campo = recuperaEvento($idEvento);
				echo "- Você está editando o evento <strong>'".$campo['nomeEvento']."'</strong>";	
			}
		}
	}
	function recuperaPessoa($id,$tipo)
	{
		//recupera os dados de uma pessoa
		$con = bancoMysqli();
		if($id == 0)
		{
			$y['nome'] = ""; 
			$y['tipo'] = "";
			$y['numero'] = "";		
			return $y;
		}
		else
		{
			switch($tipo)
			{
				case '1':
					$sql = "SELECT * FROM sis_pessoa_fisica WHERE Id_PessoaFisica = $id";
					$query = mysqli_query($con,$sql);
					$x = mysqli_fetch_array($query);
					$y['nome'] = $x['Nome']; 
					$y['tipo'] = "Pessoa física";
					$y['numero'] = $x['CPF'];
					$y['cep'] = $x['CEP'];
					$y['ccm'] = $x['CCM'];
					$y['email'] = $x['Email'];
					$y['telefones'] = $x['Telefone1']." / ".$x['Telefone2']." / ".$x['Telefone3'];
					return $y;
				break;
				case '2':
					$sql = "SELECT * FROM sis_pessoa_juridica WHERE Id_PessoaJuridica = $id";
					$query = mysqli_query($con,$sql);
					$x = mysqli_fetch_array($query);
					$y['nome'] = $x['RazaoSocial']; 
					$y['tipo'] = "Pessoa jurídica";
					$y['numero'] = $x['CNPJ'];
					$y['cep'] = $x['CEP'];
					$y['ccm'] = $x['CCM'];
					$y['email'] = $x['Email'];
					$y['telefones'] = $x['Telefone1']." / ".$x['Telefone2']." / ".$x['Telefone3'];
					return $y;	
				break;
				case '3':
					$sql = "SELECT * FROM sis_representante_legal WHERE Id_RepresentanteLegal = $id";
					$query = mysqli_query($con,$sql);
					$x = mysqli_fetch_array($query);
					$y['nome'] = $x['RepresentanteLegal']; 
					$y['tipo'] = "Representante legal";
					$y['numero'] = $x['CPF'];		
					return $y;
				break;
			}
		}
	}
	function recuperaEstadoCivil($id)
	{
		$estadoCivil = recuperaDados("sis_estado_civil",$id,"Id_EstadoCivil");
		$x['IdEstadoCivil'] = $estadoCivil['Id_EstadoCivil'];
		$x['EstadoCivil'] = $estadoCivil['EstadoCivil'];
		return $x;		
	}
	function retornaEndereco($cep,$numero,$complemento)
	{
		$con = bancoMysqliCEP();
		$cep_index = substr($cep, 0, 5);
		$sql01 = "SELECT * FROM igsis_cep_cep_log_index WHERE cep5 = '$cep_index' LIMIT 0,1";
		$query01 = mysqli_query($con,$sql01);
		$num = mysqli_num_rows($query01);
		if($num > 0)
		{
			$campo01 = mysqli_fetch_array($query01);
			$uf = "igsis_cep_".$campo01['uf'];
			$sql02 = "SELECT * FROM $uf WHERE cep = '$cep'";
			$query02 = mysqli_query($con,$sql02);
			$campo02 = mysqli_fetch_array($query02);
			$endereco =  $campo02['tp_logradouro']." ".$campo02['logradouro'].", ".$numero." / ".$complemento." - ".
			$campo02['bairro']." - ".$campo02['cidade']." / ".strtoupper($campo01['uf']);
			return $endereco;
		}
		else
		{
		}
	}
	function geraOpcaoLegal($idEvento)
	{
		//gera options de representantes legais
		$sql = "SELECT * FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento' AND tipoPessoa = '3'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($campo = mysqli_fetch_array($query))
		{
			$id = $campo['idPessoa'];	
			$nome = recuperaPessoa($id,3);
			$representante = $nome['nome'];
			echo "<option value='".$id."'>".$representante."</option>";
		}		
	}
	function valorPorExtenso($valor=0)
	{
		//retorna um valor por extenso
		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
		$z=0;
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];
		$rt = "";
		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;) 
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++)
		{
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
		return($rt ? $rt : "zero");
	}
	
	function qtdApresentacoesPorExtenso($valor=0)
	{
		//retorna um valor por extenso
		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
		$z=0;
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];
		$rt = "";
		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;) 
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++)
		{
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
		return($rt ? $rt : "zero");
	}
	
	function recuperaModalidade($id)
	{
		//imprime a modalidade
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_modalidade WHERE idModalidade = '$id'";
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		echo $campo['modalidade'];	
	}
	function retornaTipo($id)
	{
		//retorna o tipo de evento
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_tipo_evento WHERE idTipoEvento = '$id'";
		$query = mysqli_query($con,$sql);
		$x = mysqli_fetch_array($query);		
		return $x['tipoEvento'];
	}
	function retornaRelacaoJuridica($id)
	{
		//retorna o tipo de evento
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_modalidade WHERE idModalidade = '$id'";
		$query = mysqli_query($con,$sql);
		$x = mysqli_fetch_array($query);		
		return $x['modalidade'];
	}
	function iniciaFormulario($idUsuario,$idInstituicao)
	{
		//inicia um evento zerado
		unset($_SESSION['idEvento']);
		// Query para inserir um registro em branco
		$sql_inicio = "INSERT INTO  `ig_evento` (
			`idEvento` ,
			`ig_produtor_idProdutor` ,
			`ig_tipo_evento_idTipoEvento` ,
			`ig_programa_idPrograma` ,
			`projetoEspecial` ,
			`nomeEvento` ,
			`projeto` ,
			`memorando` ,
			`idResponsavel` ,
			`suplente` ,
			`autor` ,
			`fichaTecnica` ,
			`faixaEtaria` ,
			`sinopse` ,
			`releaseCom` ,
			`confirmaFinanca` ,
			`confirmaDiretoria` ,
			`confirmaComunicacao` ,
			`confirmaDocumentacao` ,
			`confirmaProducao` ,
			`numeroProcesso` ,
			`publicado` ,
			`idInstituicao` ,
			`idUsuario`)
			VALUES (
			NULL ,  '',  '',  '',  '',  '', NULL , NULL ,  '',  '',  '',  '',  '',  '',  '', NULL , NULL , NULL , NULL , NULL , NULL , NULL , $idInstituicao, $idUsuario)";
		// Executa a query
		$con = bancoMysqli();
		mysqli_query($con,$sql_inicio);
		// Retorna o ID gerado na tabela ig_evento
		$sql_ultimo = "SELECT * FROM ig_evento ORDER BY idEvento DESC LIMIT 1";
		$id_evento = mysqli_query($con,$sql_ultimo);
		$id = mysqli_fetch_array($id_evento);
		$_SESSION['idEvento'] = $id['idEvento'];
	}
	function recuperaResponsavel($nomeResponsavel)
	{
		//retorna um array com os dados do responsavel
		$sql = "SELECT * FROM ig_usuario WHERE nomeUsuario = '%$nomeResponsavel%'";
		$con = bancoMysqli();
		$query = mysqli_query($sql,$con);
		$num_resultado = mysql_num_rows($query);
		if($num_resultado = 0)
		{
			$campo['existe'] = 0;
			$campo['idUsuario'] = 0;
			$campo['nomeUsuario'] = "";
			return $campo; // retorna uma array com ['existe'] e ['idResponsavel']
		}
		else if($num_resultado = 1)
		{
			$id = mysql_fetch_array($query);
			$campo['existe'] = 1;
			$campo['idResponsavel'] = $id['idUsuario']; 
			$campo['nomeUsuario'] = $id['nomeUsuario']; 
			return $campo;
		}
	}
	function recuperaIngresso($id)
	{
		//retorna o tipo de retirada de ingresso
		$sql = "SELECT * FROM ig_retirada WHERE idRetirada = '$id'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo['retirada'];	
	}
	function recuperaDuracao($id)
	{
		//retorna duração
		$sql = "SELECT * FROM ig_ocorrencia WHERE duracao = '$id'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo['duracao'];	
	}
	function recuperaObservacao($id)
	{
		//retorna duração
		$sql = "SELECT * FROM ig_ocorrencia WHERE observacao = '$id'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo['observacao'];	
	}
	function retornaTipoOcorrencia($id)
	{
		//retorna o tipo de ocorrencia
		$sql = "SELECT * FROM ig_tipo_ocorrencia WHERE idTipoOcorrencia = '$id'";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo['tipoOcorrencia'];	
	}
	function cadastroPessoa($idEvento,$doc,$tipo)
	{
		//cria um cadastro de pessoa zerado
		$con = bancoMysqli();
		switch($tipo)
		{	
			case 1:	
				$sql = "INSERT INTO sis_pessoa_fisica (CPF,publicado,idEvento) VALUES ('$doc','0','idEvento')";
				$tabela = "sis_pessoa_fisica";
			break;
			case 2:	
				$sql = "INSERT INTO sis_pessoa_juridica (CNPJ,publicado,idEvento) VALUES ('$doc','0','idEvento')";
				$tabela = "sis_pessoa_juridica";
			break;
			case 3:
				$sql = "INSERT INTO sis_representante_legal (CPF,publicado,idEvento) VALUES ('$doc','0','idEvento')";
				$tabela = "sis_representante_legal";
			break;
		}
		$query = mysqli_query($con,$sql); 
		$ultimo = recuperaUltimo($tabela);
		return $ultimo;
	}
	function apagarRepresentante($pedido,$tipo,$evento)
	{
		//atualiza o publicado do representante para 0
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_pedido_contratacao 
			WHERE idPessoa = '$pedido' 
			AND idEvento = '$evento' 
			AND tipoPessoa = '3'  
			AND publicado = '1' LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$num_rows = mysqli_num_rows($query);
		if($num_rows > 0)
		{
			while($campo = mysqli_fetch_array($query))
			{
				$sql_jur = "SELECT * FROM igsis_pedido_contratacao WHERE idEvento = '$evento' AND tipoPessoa = '2' AND publicado = '1'";
				$query_jur = mysqli_query($con,$sql_jur);
				while($campo_jur = mysqli_fetch_array($query_jur))
				{
					if(($campo_jur['idRepresentante01'] == $campo['idPessoa']) OR ($campo_jur['idRepresentante02'] == $campo['idPessoa']))
					{
						echo " disabled ";
					}
					else
					{
						echo " erro 1 ";
					}
				}
			}
		}
	}
	function listaArquivosPessoa($idPessoa,$tipo)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = $idPessoa AND idTipoPessoa = $tipo AND publicado = 1";
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td width='30%'>Tipo</td>
						<td>Nome do arquivo</td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			$tipoDoc = recuperaDados("igsis_upload_docs",$campo['tipo'],"idTipoDoc");
				echo "<tr>";
				echo "<td class='list_description'>".$tipoDoc['documento']."</td>";
				echo "<td class='list_description'><a href='../uploadsdocs/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=contratados&p=arquivos'>
							<input type='hidden' name='idPessoa' value='".$idPessoa."' />
							<input type='hidden' name='tipoPessoa' value='".$tipo."' />
							<input type='hidden' name='apagar' value='".$campo['idArquivosPessoa']."' />
							<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
				echo "</tr>";		
		}
		echo "
			</tbody>
			</table>";	
	}
	function listaArquivosPedido($idPedido)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_arquivos_pedidos WHERE idPedido = '$idPedido' AND publicado = 1";
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td width='30%'>Tipo</td>
						<td>Nome do arquivo</td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			$tipoDoc = recuperaDados("igsis_upload_docs",$campo['tipo'],"idTipoDoc");
			echo "<tr>";
			echo "<td class='list_description'>".$tipoDoc['documento']."</td>";
			echo "<td class='list_description'><a href='../uploadsdocs/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=contratos&p=frm_arquivos_pedidos&id_ped=$idPedido'>
						<input type='hidden' name='apagar' value='".$campo['idArquivosPedidos']."' />
						<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
			echo "</tr>";
		}
		echo "
			</tbody>
			</table>";	
	}
	function listaArquivosPedidoEvento($idPedido)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_arquivos_pedidos WHERE idPedido = '$idPedido' AND publicado = 1";
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td width='30%'>Tipo</td>
						<td>Nome do arquivo</td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			$tipoDoc = recuperaDados("igsis_upload_docs",$campo['tipo'],"idTipoDoc");
			echo "<tr>";
			echo "<td class='list_description'>".$tipoDoc['documento']."</td>";
			echo "<td class='list_description'><a href='../uploadsdocs/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=contratados&p=arqped'>
						<input type='hidden' name='idPedido' value='".$campo['idArquivosPedidos']."' />
						<input type='hidden' name='apagar' value='".$campo['idArquivosPedidos']."' />
						<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
			echo "</tr>";		
		}
		echo "
			</tbody>
			</table>";	
	}
	function listaLocais($idEvento)
	{
		$con = bancoMysqli();
		$sql_virada = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1' AND virada = '1' ";
		$query_virada = mysqli_query($con,$sql_virada);
		$num = mysqli_num_rows($query_virada);
		if($num > 0)
		{	
			$locais = " DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
		}
		else
		{
			$sql = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1'";
			$query = mysqli_query($con,$sql);	
			$locais = "";
			while($local = mysqli_fetch_array($query))
			{
				$sala = recuperaDados("ig_local",$local['local'],"idLocal");
				$instituicao = recuperaDados("ig_instituicao",$sala['idInstituicao'],"idInstituicao");
				$locais = $locais.", ".$sala['sala']." (".$instituicao['sigla'].")";
			}
		}
		return $locais;
	}
	/*
	function listaLocais($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1'";
		$query = mysqli_query($con,$sql);	
		$locais = "";
		while($local = mysqli_fetch_array($query))
		{
			$sala = recuperaDados("ig_local",$local['local'],"idLocal");
			$instituicao = recuperaDados("ig_instituicao",$sala['idInstituicao'],"idInstituicao");
			$locais = $locais.", ".$sala['sala']." (".$instituicao['sigla'].")";
		}
		return $locais;
	}
	*/
	function listaLocaisJuridico($idEvento)
	{
		$con = bancoMysqli();
		$sql_virada = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1' AND virada = '1' ";
		$query_virada = mysqli_query($con,$sql_virada);
		$num = mysqli_num_rows($query_virada);
		if($num > 0)
		{
			$locais = "DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
		}
		else
		{
			$sql = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1'";
			$query = mysqli_query($con,$sql);	
			$locais = "";
			while($local = mysqli_fetch_array($query))
			{
				$sala = recuperaDados("ig_local",$local['local'],"idLocal");
				$instituicao = recuperaDados("ig_instituicao",$sala['idInstituicao'],"idInstituicao");
				$locais = $locais.", ".$sala['sala']." (".$instituicao['instituicao'].")";
				if($sala['rua'] == 1)
				{
					$locais .= " - Em itinerância na rua toda";	
				}
			}
		}
		return $locais;
	}
	/*
	function listaLocaisJuridico($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1'";
		$query = mysqli_query($con,$sql);	
		$locais = "";
		while($local = mysqli_fetch_array($query))
		{
			$sala = recuperaDados("ig_local",$local['local'],"idLocal");
			$instituicao = recuperaDados("ig_instituicao",$sala['idInstituicao'],"idInstituicao");
			$locais = $locais.", ".$sala['sala']." (".$instituicao['instituicao'].")";
			if($sala['rua'] == 1)
			{
				$locais .= " - Em itinerância na rua toda";	
			}
		}
		return $locais;
	}
	*/
	function listaLocaisMostra($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1' AND idTipoOcorrencia = '5' ";
		$query = mysqli_query($con,$sql);	
		$locais = "";	
		while($local = mysqli_fetch_array($query))
		{
			$sala = recuperaDados("ig_local",$local['local'],"idLocal");
			$instituicao = recuperaDados("ig_instituicao",$sala['idInstituicao'],"idInstituicao");
			$locais = $locais.", ".$sala['sala']." (".$instituicao['sigla'].")";
		}
		return $locais;
	}
	function retornaDuracao($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT DISTINCT duracao FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1' ORDER BY duracao DESC LIMIT 0,1";
		$query = mysqli_query($con,$sql);	
		$campo = mysqli_fetch_array($query);
		return $campo['duracao'];
	}
	/*
	function retornaPeriodo($id)
	{
		//retorna o período
		$con = bancoMysqli();
		$sql_anterior = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
		$query_anterior = mysqli_query($con,$sql_anterior);
		$data = mysqli_fetch_array($query_anterior);
		$data_inicio = $data['dataInicio'];
		$sql_posterior01 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataFinal DESC LIMIT 0,1"; //quando existe data final
		$sql_posterior02 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio DESC LIMIT 0,1"; //quando há muitas datas únicas
		$query_anterior01 = mysqli_query($con,$sql_posterior01);
		$data = mysqli_fetch_array($query_anterior01);
		$num = mysqli_num_rows($query_anterior01);
		if(($num > 0) AND ($data['dataFinal'] != '0000-00-00'))
		{
			$dataFinal01 = $data['dataFinal'];	
		}
		else
		{
			return "Não há ocorrências. <br />
			Por favor, insira pelo menos uma ocorrência.";	
		}
		$query_anterior02 = mysqli_query($con,$sql_posterior02);
		$data = mysqli_fetch_array($query_anterior02);
		$dataFinal02 = $data['dataInicio'];
		if(isset($dataFinal01))
		{
			if($dataFinal01 > $dataFinal02)
			{
				$dataFinal = $dataFinal01;
			}
			else
			{
				$dataFinal = $dataFinal02;
			}
		}
		if($data_inicio == $dataFinal)
		{
			return exibirDataBr($data_inicio);
		}
		else
		{
			return "de ".exibirDataBr($data_inicio)." a ".exibirDataBr($dataFinal);
		}
	}
	function retornaPeriodo($id)
	{
		//retorna o período
		$con = bancoMysqli();
		$sql_anterior = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
		$query_anterior = mysqli_query($con,$sql_anterior);
		$data = mysqli_fetch_array($query_anterior);
		$data_inicio = $data['dataInicio'];
		$sql_posterior01 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataFinal DESC LIMIT 0,1"; //quando existe data final
		$sql_posterior02 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio DESC LIMIT 0,1"; //quando há muitas datas únicas
		$query_anterior01 = mysqli_query($con,$sql_posterior01);
		$data = mysqli_fetch_array($query_anterior01);
		$num = mysqli_num_rows($query_anterior01);
		if(($data['dataFinal'] != '0000-00-00') OR ($data['dataFinal'] != NULL))
		{
			//se existe uma data final e que é diferente de NULO
			$dataFinal01 = $data['dataFinal'];	
		}
		$query_anterior02 = mysqli_query($con,$sql_posterior02); //recupera a data única mais tarde
		$data = mysqli_fetch_array($query_anterior02);
		$dataFinal02 = $data['dataInicio'];
		if(isset($dataFinal01))
		{
			//se existe uma temporada, compara com a última data única
			if($dataFinal01 > $dataFinal02)
			{
				$dataFinal = $dataFinal01;
			}
			else
			{
				$dataFinal = $dataFinal02;
			}
		}
		else
		{
			$dataFinal = $dataFinal02;		
		}
		if($data_inicio == $dataFinal)
		{ 
			return exibirDataBr($data_inicio);
		}
		else
		{
			return "de ".exibirDataBr($data_inicio)." a ".exibirDataBr($dataFinal);
		}
	}
	*/
	function retornaPrazo($id)
	{
		$con = bancoMysqli();
		$sql_anterior = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
		$query_anterior = mysqli_query($con,$sql_anterior);
		$data = mysqli_fetch_array($query_anterior);
		$data_inicio = $data['dataInicio'];
		
		//$dataPrazo = $data_inicio - $dias;
		
		//return $dataPrazo;
		
		return $data_inicio;
	}
	function retornaPeriodo($id)
	{
		//retorna o período
		$con = bancoMysqli();
		$sql_virada = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' AND virada = '1' ";
		$query_virada = mysqli_query($con,$sql_virada);
		$num = mysqli_num_rows($query_virada);
		if($num > 0)
		{
			$sql_anterior = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
			$query_anterior = mysqli_query($con,$sql_anterior);
			$data = mysqli_fetch_array($query_anterior);
			$data_inicio = $data['dataInicio'];
			$sql_posterior01 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataFinal DESC LIMIT 0,1"; //quando existe data final
			$sql_posterior02 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio DESC LIMIT 0,1"; //quando há muitas datas únicas
			$query_anterior01 = mysqli_query($con,$sql_posterior01);
			$data = mysqli_fetch_array($query_anterior01);
			$num = mysqli_num_rows($query_anterior01);
			if(($data['dataFinal'] != '0000-00-00') OR ($data['dataFinal'] != NULL))
			{
				//se existe uma data final e que é diferente de NULO
				$dataFinal01 = $data['dataFinal'];	
			}
			$query_anterior02 = mysqli_query($con,$sql_posterior02); //recupera a data única mais tarde
			$data = mysqli_fetch_array($query_anterior02);
			$dataFinal02 = $data['dataInicio'];
			if(isset($dataFinal01))
			{
				//se existe uma temporada, compara com a última data única
				if($dataFinal01 > $dataFinal02)
				{
					$dataFinal = $dataFinal01;
				}
				else
				{
					$dataFinal = $dataFinal02;
				}
			}
			else
			{
				$dataFinal = $dataFinal02;		
			}
			if($data_inicio == $dataFinal)
			{ 
				return exibirDataBr($data_inicio)." DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
			}
			else
			{
				return "de ".exibirDataBr($data_inicio)." a ".exibirDataBr($dataFinal)." DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
			}	
		}
		else
		{
			$sql_anterior = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
			$query_anterior = mysqli_query($con,$sql_anterior);
			$data = mysqli_fetch_array($query_anterior);
			$data_inicio = $data['dataInicio'];
			$sql_posterior01 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataFinal DESC LIMIT 0,1"; //quando existe data final
			$sql_posterior02 = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$id' AND publicado = '1' ORDER BY dataInicio DESC LIMIT 0,1"; //quando há muitas datas únicas
			$query_anterior01 = mysqli_query($con,$sql_posterior01);
			$data = mysqli_fetch_array($query_anterior01);
			$num = mysqli_num_rows($query_anterior01);
			if(($data['dataFinal'] != '0000-00-00') OR ($data['dataFinal'] != NULL))
			{
				//se existe uma data final e que é diferente de NULO
				$dataFinal01 = $data['dataFinal'];	
			}
			$query_anterior02 = mysqli_query($con,$sql_posterior02); //recupera a data única mais tarde
			$data = mysqli_fetch_array($query_anterior02);
			$dataFinal02 = $data['dataInicio'];
			if(isset($dataFinal01))
			{
				//se existe uma temporada, compara com a última data única
				if($dataFinal01 > $dataFinal02)
				{
					$dataFinal = $dataFinal01;
				}
				else
				{
					$dataFinal = $dataFinal02;
				}
			}
			else
			{
				$dataFinal = $dataFinal02;		
			}
			if($data_inicio == $dataFinal)
			{ 
				return exibirDataBr($data_inicio);
			}
			else
			{
				return "de ".exibirDataBr($data_inicio)." a ".exibirDataBr($dataFinal);
			}
		}
	}
	function retornaData($id)
	{
		//retorna o período
		$con = bancoMysqli();
		$sql_inicio = "SELECT * FROM igsis_agenda WHERE idEvento = '$id' ORDER BY data ASC LIMIT 0,1";
		$sql_final = "SELECT * FROM igsis_agenda WHERE idEvento = '$id' ORDER BY data DESC LIMIT 0,1";
		$query_inicio = mysqli_query($con,$sql_inicio);
		$query_final = mysqli_query($con,$sql_final);
		$inicio = mysqli_fetch_array($query_inicio);
		$final = mysqli_fetch_array($query_final);
		$x['inicio'] = $inicio['data'];
		$x['final'] = $final['data'];
		return $x;
	}
	//Comunicação
	function saudacaoCom()
	{
		return "Olá amigo comunicador!";	
	}
	function listarComunicacao($order,$sentido)
	{
		if($order != "")
		{
			$query_order = "ORDER BY ".$order." ".$sentido;
		}
		else
		{
			$query_order = "";
		}
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_comunicacao $query_order";
		$query = mysqli_query($con,$sql);
		$i = 1;
		while($com = mysqli_fetch_array($query))
		{
			$nomeEvento = recuperaDados("ig_evento",$com['ig_evento_idEvento'],"idEvento");
			$evento = $nomeEvento['nomeEvento'];
			$enviado = $nomeEvento['idUsuario'];
			$dataEnvio = $nomeEvento['dataEnvio'];
			$nomeUsuario = recuperaUsuario($nomeEvento['idUsuario']);
			$devolve[$i]['codigo'] = $com['idCom'];
			$devolve[$i]['evento'] = $evento;
			$devolve[$i]['enviadoPor'] = $nomeUsuario['nomeCompleto'];
			$devolve[$i]['dataEnvio'] = $dataEnvio;
			$i++;
		}	
		return $devolve;
	}
	function analisaArray($array)
	{
		//imprime o conteúdo de uma array
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
	function listaSubEventos($idEvento)
	{
		//lista ocorrencias de determinado evento
		$sql = "SELECT * FROM ig_sub_evento WHERE ig_evento_idEvento = '$idEvento' AND publicado = '1' ORDER BY idSubEvento DESC";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td>Sub-evento</td>
						<td width='10%'></td>

						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{	
			$descricao = "<strong>".$campo['titulo']."</strong> (".retornaTipo($campo['idTipo']).")<br />";
			$id = $campo['idSubEvento'];	
			echo "<tr>";
			echo "<td class='list_description'>".$descricao."</td>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=evento&p=subEvento&action=inserir'>
						<input type='hidden' name='editar' value='$id' />
						<input type ='submit' class='btn btn-theme btn-block' value='Editar'></td></form>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=evento&p=subEvento&action=listar'>
						<input type='hidden' name='apagar' value='$id' />
						<input type ='submit' class='btn btn-theme  btn-block' value='Apagar'></td></form>"	;
			echo "</tr>";		
		}
		echo "</tbody></table>";
	}
	function recuperaUltimo($tabela)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM $tabela ORDER BY 1 DESC LIMIT 0,1";
		$query =  mysqli_query($con,$sql);
		$campo = mysqli_fetch_array($query);
		return $campo[0];	
	}
	/*function geraOpcaoSub($idEvento,$select)
	{
		$con =  bancoMysqli();
		$sql = "SELECT * FROM ig_sub_evento WHERE ig_evento_idEvento = '$idEvento'";
		$query = mysqli_query($con,$sql);
		while($campo = mysqli_fetch_array($query))
		{
			if($select == $campo['idSubEvento'])
			{
				echo "<option value=".$campo['idSubEvento']." selected >".$campo['titulo']."</option>";
			}
			else
			{
				echo "<option value=".$campo['idSubEvento'].">".$campo['titulo']."</option>";	
			}
		}		
	}
	*/
	function listaFilmes($idEvento)
	{
		//lista ocorrencias de determinado evento
		$sql = "SELECT * FROM ig_cinema WHERE ig_evento_idEvento = '$idEvento' AND publicado = 1";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td>Filmes</td>
						<td>Ocorrências</td>
						<td width='10%'></td>
						<td width='10%'></td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			if($campo['tituloOriginal'] != "")
			{
				$tituloOriginal = $campo['tituloOriginal'];	
			}
			else
			{
				$tituloOriginal = "";
			}
			if(($campo['ig_pais_IdPais_2'] != 0) OR ($campo['ig_pais_IdPais_2'] != NULL))
			{
				$coproducao = " / ".$campo['ig_pais_IdPais_2'];
			}
			else
			{
				$coproducao = "";	
			}
			$filme = "<div class='left'> ".
			$campo['titulo']
				."<br />
				(".$tituloOriginal." - ".retornaPais($campo['ig_pais_idPais'])." - ".retornaPais($campo['ig_pais_IdPais_2'])." - ".$campo['anoProducao']
				." - ".$campo['minutagem']."min. - ".$campo['bitola']." ) <br />
				Direção: ".$campo['direcao']."<br />";					
			echo "<tr>";
			echo "<td class='list_description'>".$filme."</td>";
			echo "<td class='list_description'><div class='left'>";
			listaOcorrenciasFilmes($campo['idCinema']);
			echo "</div></td>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=cinema&p=editar'>
						<input type='hidden' name='carregarFilme' value='".$campo['idCinema']."' />
						<input type ='submit' class='btn btn-theme btn-block' value='Editar'></td></form>";
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=cinema&p=ocorrencias&action=listar'>
						<input type='hidden' name='idCinema' value='".$campo['idCinema']."' />
						<input type ='submit' class='btn btn-theme btn-block' value='Ocorrências'></td></form>"	;
			echo "
				<td class='list_description'>
					<form method='POST' action='?perfil=cinema&p=listar'>
						<input type='hidden' name='apagarFilme' value='".$campo['idCinema']."' />
						<input type ='submit' class='btn btn-theme  btn-block' value='Apagar'></td></form>"	;
			echo "</tr>";
		}
		echo "
			</tbody>
			</table>";
	}
	function retornaPais($id)
	{
		$pais = recuperaDados("ig_pais",$id,"paisId");
		return $pais['paisNome'];	
	}
	function listaOcorrenciasCinema($idCinema)
	{
		//lista ocorrencias de determinado evento
		$sql = "SELECT * FROM ig_ocorrencia WHERE idCinema = '$idCinema' AND publicado = 1 ORDER BY dataInicio";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			echo "
				<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Ocorrência</td>
							<td width='10%'></td>
							<td width='10%'></td>
							<td width='10%'></td>
						</tr>
					</thead>
					<tbody>";
			while($campo = mysqli_fetch_array($query))
			{
				$tipo_de_evento = retornaTipoOcorrencia($campo['idTipoOcorrencia']); // retorna o tipo de ocorrência
				if($campo['idSubEvento'] != NULL)
				{
					$sub = recuperaDados("ig_sub_evento",$campo['idSubEvento'],"idSubEvento");
				}
				else
				{
					$sub['titulo'] = "";		
				}
				if($campo['dataFinal'] == '0000-00-00')
				{
					$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
					$semana = "";
				}
				else
				{
					$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
					if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
					if($campo['terca'] == 1){$ter = "terça";}else{$ter = "";}
					if($campo['quarta'] == 1){$qua = "quarta";}else{$qua = "";}
					if($campo['quinta'] == 1){$qui = "quinta";}else{$qui = "";}
					if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
					if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
					if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
					$semana = "(".$seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom.")";	
				}
				if($campo['diaEspecial'] == 1)
				{
					if($campo['libras'] == 1)
					{
						$libras = "Tradução em libras";
					}
					else
					{
						$libras = "";
					}
					if($campo['audiodescricao'] == 1)
					{
						$audio = "Audiodescrição";
					}
					else
					{
						$audio = "";
					}
					if($campo['precoPopular'] == 1)
					{
						$popular = "Preço popular";
					}
					else
					{
						$popular = "";
					}
					$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular;
				}
				else
				{
					$dia_especial = "";
				}
				//recuperaDados($tabela,$idEvento,$campo)
				$hora = exibirHora($campo['horaInicio']);
				$duracao = recuperaDuracao($campo ['duracao']);
				$retirada = recuperaIngresso($campo['retiradaIngresso']);
				$valor = dinheiroParaBr($campo['valorIngresso']);
				$local = recuperaDados("ig_local",$campo['local'],"idLocal");
				$espaco = $local['sala'];
				$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
				$instituicao = $inst['instituicao'];
				$id = $campo['idOcorrencia'];
				$ocorrencia = "<div class='left'>$tipo_de_evento $dia_especial ".
				$sub['titulo']
					."<br />
					Data: $data $semana <br />
					Horário: $hora<br />
					Duração: $duracao <br />
					Local: $espaco - $instituicao<br />
					Retirada de ingresso: $retirada  - Valor: $valor <br /></br>";	
				echo "<tr>";
				echo "<td class='list_description'>".$ocorrencia."</td>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=cinema&p=ocorrencias&action=editar'>
							<input type='hidden' name='id' value='$id' />
							<input type='hidden' name='idCinema' value='".$campo['idCinema']."' />
							<input type ='submit' class='btn btn-theme btn-block' value='Editar'></td></form>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=cinema&p=ocorrencias&action=listar'>
							<input type='hidden' name='duplicar' value='".$campo['idOcorrencia']."' />
							<input type='hidden' name='idCinema' value='".$campo['idCinema']."' />
							<input type ='submit' class='btn btn-theme btn-block' value='Duplicar'></td></form>";
				echo "
					<td class='list_description'>
						<form method='POST' action='?perfil=cinema&p=ocorrencias&action=listar'>
							<input type='hidden' name='apagar' value='".$campo['idOcorrencia']."' />
							<input type='hidden' name='idCinema' value='".$campo['idCinema']."' />
							<input type ='submit' class='btn btn-theme  btn-block' value='Apagar'></td></form>";
				echo "</tr>";
			}
			echo "
				</tbody>
				</table>";
		}
		else
		{
			echo "<h3>Não há ocorrências cadastradas.</h3>";
		}
	}
	function listaOcorrenciasFilmes($idCinema)
	{
		//lista ocorrencias de determinado filme
		$sql = "SELECT * FROM ig_ocorrencia WHERE idCinema = '$idCinema' AND publicado = 1 ORDER BY dataInicio";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($campo = mysqli_fetch_array($query))
		{
			if($campo['dataFinal'] == '0000-00-00')
			{
				$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
				$semana = "";
			}
			else
			{
				$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
				if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
				if($campo['terca'] == 1){$ter = "terça";}else{$ter = "";}
				if($campo['quarta'] == 1){$qua = "quarta";}else{$qua = "";}
				if($campo['quinta'] == 1){$qui = "quinta";}else{$qui = "";}
				if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
				if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
				if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
				$semana = "(".$seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom.")";	
			}
			if($campo['diaEspecial'] == 1)
			{
				if($campo['libras'] == 1)
				{
					$libras = "Tradução em libras";
				}
				else
				{
					$libras = "";
				}
				if($campo['audiodescricao'] == 1)
				{
					$audio = "Audiodescrição";
				}
				else
				{
					$audio = "";
				}
				if($campo['precoPopular'] == 1)
				{
					$popular = "Preço popular";
				}
				else
				{
					$popular = "";
				}
				$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular;
			}
			else
			{
				$dia_especial = "";
			}
			//recuperaDados($tabela,$idEvento,$campo)
			$hora = exibirHora($campo['horaInicio']);
			$duracao = recuperaDuracao($campo ['duracao']);
			$retirada = recuperaIngresso($campo['retiradaIngresso']);
			$valor = dinheiroParaBr($campo['valorIngresso']);
			$local = recuperaDados("ig_local",$campo['local'],"idLocal");
			$espaco = $local['sala'];
			$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
			$instituicao = $inst['instituicao'];
			$id = $campo['idOcorrencia'];
			$ocorrencia = "
				Data: $data $semana <br />
				Horário: $hora<br />
				Duração: $duracao<br />
				Local: $espaco - $instituicao<br />
				Retirada de ingresso: $retirada  - Valor: $valor <br /></br>";
			echo $ocorrencia;		
		}
	}
	function periodoMostra($idEvento)
	{
		$con = bancoMysqli();
		$sql_anterior = "SELECT * FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			AND idTipoOcorrencia = '5' 
			AND idCinema IS NOT NULL 
			ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
		$query_anterior = mysqli_query($con,$sql_anterior);
		$data = mysqli_fetch_array($query_anterior);
		$data_inicio = $data['dataInicio'];
		$sql_posterior = "SELECT * FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			AND idTipoOcorrencia = '5' 
			AND idCinema IS NOT NULL 
			ORDER BY dataInicio DESC LIMIT 0,1"; //quando há muitas datas únicas
		$query_anterior = mysqli_query($con,$sql_posterior);
		$data = mysqli_fetch_array($query_anterior);
		$dataFinal = $data['dataInicio'];
		if($data_inicio == $dataFinal)
		{
			return exibirDataBr($data_inicio);
		}
		else
		{
			return "Período da Mostra: <br />
				de ".exibirDataBr($data_inicio)." a ".exibirDataBr($dataFinal);
		}
	}
	function retornaTipoPessoa($tipo)
	{
		switch($tipo)
		{
			case 1:
				return "Pessoa física";
			break;
			case 2:
				return "Pessoa jurídica";
			break;
			case 3:
				return "Representante legal";
			break;
		}
	}
	function retornaVerba($tipo)
	{
		$verba = recuperaDados("sis_verba",$tipo,"Id_verba");
		return $verba['Verba'];
	}
	function listaServicosInternos($idEvento)
	{
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		$interno = recuperaDados("ig_producao",$idEvento,"ig_evento_idEvento");
		$produtor = recuperaDados("ig_produtor",$evento['ig_produtor_idProdutor'],"idProdutor");
		if($produtor)
		{
			echo "<strong>Produtor responsável:</strong> ".$produtor['nome']."<br />";	
			echo "<strong>E-mail:</strong> ".$produtor['email']."<br />";	
			echo "<strong>Telefone:</strong> ".$produtor['telefone']." / ".$produtor['telefone2']."<br />";	
			echo "<br />"; 
		}
		if($interno)
		{
			if(($interno['carros'] != '') AND ($interno['carros'] != NULL))
			{
				echo "Carros: ".nl2br($interno['carros'])."<br />";
			}	
			if(($interno['equipe'] != '') AND ($interno['equipe'] != NULL))
			{
				echo "Equipe: ".nl2br($interno['equipe'])."<br />";
			}	
			if(($interno['infraestrutura'] != '') AND ($interno['infraestrutura'] != NULL))
			{
				echo "Infraestrutura: ".nl2br($interno['infraestrutura'])."<br />";
			}	
			if($interno['registroAudio'] == 1)
			{
				echo "Registro de Áudio: Sim <br />";
			}	
			if($interno['registroFotografia'] == 1)
			{
				echo "Registro de Fotografia: Sim <br />";
			}	
			if($interno['registroVideo'] == 1)
			{
				echo "Registro de Vídeo: Sim <br />";
			}	
		}
		else
		{
			echo "Não há dados.";	
		}
		if($evento['ig_tipo_evento_idTipoEvento'] == '2')
		{
			$artes = recuperaDados("ig_artes_visuais",$idEvento,"idEvento");
			if($artes)
			{
				echo "<br /><br />";
				echo "<h5>Serviços para Exposições</h5>";
				if($artes['painel'] == 1)
				{
					echo "Confecção de Painel: Sim <br />";
				}	
				if($artes['legendas'] == 1)
				{
					echo "Confecção de Legendas: Sim <br />";
				}	
				if($artes['identidade'] == 1)
				{
					echo "Criação de Identidade Visual: Sim <br />";
				}	
				if($artes['suporte'] == 1)
				{
					echo "Pedido de suporte de comunicação: Sim <br />";
				}	
			}
		}
	}
	function listaServicosExternos($idEvento)
	{
		$externo = recuperaDados("ig_servico",$idEvento,"ig_evento_idEvento");
		if($externo)
		{
			if(($externo['legenda'] != '') AND ($externo['legenda'] != NULL))
			{
				echo "Legenda / legendagem: ".$externo['legenda']."<br />";
			}
			if(($externo['traducao'] != '') AND ($externo['traducao'] != NULL))
			{
				echo "Tradução: ".$externo['traducao']."<br />";
			}
			if(($externo['seguro'] != '') AND ($externo['seguro'] != NULL))
			{
				echo "Seguro: ".$externo['seguro']."<br />";
			}
			if(($externo['transporte'] != '') AND ($externo['transporte'] != NULL))
			{
				echo "Transporte: ".$externo['transporte']."<br />";
			}
			if(($externo['montagem'] != '') AND ($externo['montagem'] != NULL))
			{
				echo "Montagem fina: ".$externo['montagem']."<br />";
			}
			if(($externo['passagens'] != '') AND ($externo['passagens'] != NULL))
			{
				echo "Passagem aérea: ".$externo['passagens']."<br />";
			}
			if(($externo['itinerario'] != '') AND ($externo['itinerario'] != NULL))
			{
				echo "Descrição da passagem: ".$externo['itinerario']."<br />";
			}
			if(($externo['hospedagem'] != '') AND ($externo['hospedagem'] != NULL))
			{
				echo "Hospedagem: ".$externo['hospedagem']."<br />";
			}
			if(($externo['locacao'] != '') AND ($externo['locacao'] != NULL))
			{
				echo "Locação de equipamentos: ".$externo['locacao']."<br />";
			}
			if(($externo['bilhetagem'] != '') AND ($externo['bilhetagem'] != NULL))
			{
				echo "<br />Bilhetagem: <br /> ".nl2br($externo['bilhetagem'])."<br />";
			}
		}
		else
		{
			echo "Não há dados.";	
		}
	}
	function retornaDatas($id)
	{
		//retorna o período
		$con = bancoMysqli();
		$evento = recuperaDados("ig_evento",$id,"idEvento");
		if($evento['ig_tipo_evento_idTipoEvento'] != 1)
		{
			//Não é Mostra de Cinema
			$sql_anterior = "SELECT * FROM ig_ocorrencia 
				WHERE idEvento = '$id' 
				AND publicado = '1' 
				ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
			$query_anterior = mysqli_query($con,$sql_anterior);
			$data_i = mysqli_fetch_array($query_anterior);
			$data_inicio = $data_i['dataInicio'];
			$sql_posterior01 = "SELECT * FROM ig_ocorrencia 
				WHERE idEvento = '$id' 
				AND publicado = '1' 
				ORDER BY dataFinal DESC LIMIT 0,1"; //quando existe data final
			$sql_posterior02 = "SELECT * FROM ig_ocorrencia 
				WHERE idEvento = '$id' 
				AND publicado = '1' 
				ORDER BY dataInicio DESC LIMIT 0,1"; //quando há muitas datas únicas
			$query_posterior01 = mysqli_query($con,$sql_posterior01);
			$data = mysqli_fetch_array($query_posterior01);
			$num = mysqli_num_rows($query_posterior01); //verifica se tem data final
		}
		else
		{
			// é Mostra de Cinema
			$sql_anterior = "SELECT * FROM ig_ocorrencia 
				WHERE idEvento = '$id' 
				AND publicado = '1' 
				AND idTipoOcorrencia = '5' 
				ORDER BY dataInicio ASC LIMIT 0,1"; //a data inicial mais antecedente
			$query_anterior = mysqli_query($con,$sql_anterior);
			$data_i = mysqli_fetch_array($query_anterior);
			$data_inicio = $data_i['dataInicio'];
			$sql_posterior01 = "SELECT * FROM ig_ocorrencia 
				WHERE idEvento = '$id' 
				AND publicado = '1' 
				AND idTipoOcorrencia = '5'  
				ORDER BY dataFinal DESC LIMIT 0,1"; //quando existe data final
			$sql_posterior02 = "SELECT * FROM ig_ocorrencia 
				WHERE idEvento = '$id' 
				AND publicado = '1' 
				AND idTipoOcorrencia = '5'  
				ORDER BY dataInicio DESC LIMIT 0,1"; //quando há muitas datas únicas
			$query_posterior01 = mysqli_query($con,$sql_posterior01);//verifica se tem data final
			$data = mysqli_fetch_array($query_posterior01);
			$num = mysqli_num_rows($query_posterior01);
		}
		if(($num > 0) AND ($data['dataFinal'] != '0000-00-00'))
		{
			//verifica se é temporada
			$dataFinal01 = $data['dataFinal'];	
		}
		else
		{
			$dataFinal01 = $data['dataInicio'];	
		}
		$query_anterior02 = mysqli_query($con,$sql_posterior02);
		$data = mysqli_fetch_array($query_anterior02);
		$dataFinal02 = $data['dataInicio'];
		if(isset($dataFinal01))
		{
			if($dataFinal01 > $dataFinal02)
			{
				$dataFinal = $dataFinal01;
			}
			else
			{
				$dataFinal = $dataFinal02;
			}
		}
		$x['dataInicio'] = $data_inicio;
		$x['dataFinal'] = $dataFinal;
		return $x;
	}
	function busca($busca,$tipo)
	{
		$con = bancoMysqli();
		switch($tipo)
		{
			case 1:	// busca em ig_eventos
				$sql_busca = "SELECT DISTINCT * FROM ig_evento 
					WHERE (nomeEvento LIKE '%$busca%' 
					OR autor LIKE '%$busca%' 
					OR fichaTecnica LIKE '%$busca%' 
					OR sinopse LIKE '%$busca%' 
					OR releaseCom LIKE '%$busca%' 
					OR projeto LIKE '%$busca%') 
					AND publicado = '1' 
					AND dataEnvio IS NOT NULL";
				$query_busca = mysqli_query($con,$sql_busca);
				gravarLog($sql_busca);
				$num = mysqli_num_rows($query_busca);
				if($num > 0)
				{
					$i = 0;
					while($evento = mysqli_fetch_array($query_busca))
					{
						$usuario = recuperaUsuarioCompleto($evento['idResponsavel']);
						$x[$i]['tipo'] = $evento['ig_tipo_evento_idTipoEvento'];
						$x[$i]['responsavel'] = $usuario['nomeCompleto'];
						$x[$i]['dataEnvio'] = $evento['dataEnvio'];
						$x[$i]['nomeEvento'] = $evento['nomeEvento'];
						$x[$i]['idEvento'] = $evento['idEvento'];
						$x[$i]['instituicao'] = $usuario['instituicao'];
						$i++;
					}	
				}
				$x['numReg'] = $num;
				return $x;
			break;
			case 2:
				$con = bancoMysqli();
				// busca em sis_pessoa_fisica
				$sql = "SELECT  * FROM sis_pessoa_fisica 
					WHERE (Nome LIKE '%$busca%' 
					OR NomeArtistico LIKE '%$busca%' 
					OR Funcao LIKE '%$busca%' 
					OR Nacionalidade LIKE '%$busca%')";
				$query = mysqli_query($con,$sql);
				gravarLog($sql);
				$num_pf = mysqli_num_rows($query);
				if($num_pf > 0)
				{
					$i = 0;
					while($evento = mysqli_fetch_array($query))
					{
						$x['fisica'][$i]['Nome'] = $evento['Nome'];
						$x['fisica'][$i]['IdPessoa'] = $evento['Id_PessoaFisica'];
						$x['fisica'][$i]['CPF'] = $evento['CPF'];
						$i++;
					}	
				}
				// busca em sis_pessoa_juridica
				$sql = "SELECT * FROM sis_pessoa_juridica WHERE RazaoSocial LIKE '%$busca%'";
				$query = mysqli_query($con,$sql);
				$num_pj = mysqli_num_rows($query);
				if($num_pj > 0)
				{
					$i = 0;
					while($evento = mysqli_fetch_array($query))
					{
						$x['juridica'][$i]['Nome'] = $evento['RazaoSocial'];
						$x['juridica'][$i]['IdPessoa'] = $evento['Id_PessoaJuridica'];
						$x['juridica'][$i]['CNPJ'] = $evento['CNPJ'];
						$i++;
					}
				}
				$x['numReg'] = $num_pf + $num_pj;
				$x['numPf'] = $num_pf;
				$x['numPj'] = $num_pj;
				return $x;	
			break;
			case 3:
				$sql_busca_instituicao = "SELECT * FROM ig_instituicao WHERE instituicao LIKE '%$busca%'";
				$query_busca_instituicao = mysqli_query($con,$sql_busca_instituicao);  
				$num_instituicao = mysqli_num_rows($query_busca_instituicao); 
				if($num_instituicao > 0)
				{ 
					$i = 0;	
					while($instituicao = mysqli_fetch_array($query_busca_instituicao))
					{
						$x['instituicao'][$i]['idInstituicao'] = $instituicao['idInstituicao'];	
						$x['instituicao'][$i]['nome'] = $instituicao['instituicao'];	
						$x['instituicao'][$i]['sigla'] = $instituicao['sigla'];	
						$i++;
					}
				}
				$sql_busca_usuario = "SELECT * FROM ig_usuario WHERE nomeCompleto LIKE '%$busca%'";
				$query_busca_usuario = mysqli_query($con,$sql_busca_usuario);    	
				$num_usuario = mysqli_num_rows($query_busca_usuario);
				if($num_usuario > 0)
				{
					$i = 0;
					while($usuario = mysqli_fetch_array($query_busca_usuario))
					{
						$instituicao = recuperaDados("ig_instituicao",$usuario['idInstituicao'],"idInstituicao");
						$x['usuario'][$i]['nome'] = $usuario['nomeCompleto'];
						$x['usuario'][$i]['instituicao'] = $instituicao['instituicao'];
						$x['usuario'][$i]['email'] = $usuario['email'];
						$x['usuario'][$i]['telefone'] = $usuario['telefone'];
						$i++;				
					}
				}
				$sql_busca_local = "SELECT * FROM ig_local WHERE sala LIKE '%$busca%'";
				$query_busca_local = mysqli_query($con,$sql_busca_local);    	
				$num_local = mysqli_num_rows($query_busca_local);
				if($num_local > 0)
				{
					$i = 0;
					while($local = mysqli_fetch_array($query_busca_local))
					{
						$instituicao = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
						$x['local'][$i]['nome'] = $local['sala'];
						$x['local'][$i]['instituicao'] = $instituicao['instituicao'];
						$i++; 
					}
				}
				$x['num_instituicao'] = $num_instituicao;
				$x['num_usuario'] = $num_usuario;
				$x['num_local'] = $num_local;
				return $x;
			break;    
		}
	}
	function resumoOcorrenciasDoc($idEvento)
	{
		$con = bancoMysqli();	
		//Eventos únicos
		$sql_unico = "SELECT * FROM ig_ocorrencias 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			AND dataFinal = '0000-00-00'";
		$query_unico = mysqli_query($con,$sql_unico);
		//Temporadas
	}
	function primeiraData($idEvento)
	{
		$con = bancoMysqli();
		$sql_primeiro = "SELECT dataInicio FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			ORDER BY dataInicio DESC LIMIT 0,1";
		$query_primeiro = mysqli_query($con,$sql_primeiro);
		$data_primeiro = mysqli_fetch_array($query_primeiro);
		return $data_primeiro['dataInicio'];	
	}
	function listaOcorrenciasInstituicao($idInstituicao,$ordem)
	{
		$con = bancoMysqli();
		//Recupera todos os espaços da instituição
		if($idInstituicao == 4)
		{
			//SMC
		}
		$sql_sala = "SELECT * FROM ig_local WHERE idInstituicao = '$idInstituicao'";
		$query_sala = mysqli_query($con,$sql_sala);
		$i = 0;
		$sql_limpa = "TRUNCATE TABLE temp_data";
		mysqli_query($con,$sql_limpa);
		while($sala = mysqli_fetch_array($query_sala))
		{
			$idLocal = $sala['idLocal'];
			//$sql_ocorrencia = "SELECT * FROM ig_ocorrencia WHERE local = '$idLocal' AND publicado = '1'"; //recupera as ocorrências que tenham os locais da instituicao
			$sql_ocorrencia = "SELECT DISTINCT idEvento FROM ig_ocorrencia WHERE local = '$idLocal' AND publicado = '1' ORDER BY dataInicio DESC ";
			$query_ocorrencia = mysqli_query($con,$sql_ocorrencia);
			while($ocorrencia = mysqli_fetch_array($query_ocorrencia))
			{
				$idEvento = $ocorrencia['idEvento'];
				$dataInicio = primeiraData($ocorrencia['idEvento']);
				$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
				$dataEnvio = $evento['dataEnvio'];
				if($evento['publicado'] == 1 AND $evento['dataEnvio'] != NULL )
				{
					// somente os publicados e enviados
					$sql_verifica = "SELECT * FROM temp_data WHERE idEvento = '$idEvento'"; //verifica se tem duplicata
					$query_verifica = mysqli_query($con,$sql_verifica);
					$num = mysqli_num_rows($query_verifica);
					if($num == 0)
					{
						$sql_temp = "INSERT INTO 
							`temp_data` ( `idEvento`, `dataInicio`, `dataEnvio`) 
							VALUES ( '$idEvento', '$dataInicio', '$dataEnvio')"; //insere numa tabela temporária
						mysqli_query($con,$sql_temp);	
					}
				}
			}
		}
		$sql_recupera = "SELECT * FROM temp_data ORDER BY $ordem DESC";
		$query_recupera = mysqli_query($con,$sql_recupera);
		$numero = mysqli_num_rows($query_recupera);
		if($numero > 0)
		{
			while($recupera = mysqli_fetch_array($query_recupera))
			{
				$x[$i]['idEvento'] = $recupera['idEvento'];		
				$x[$i]['dataInicio'] = $recupera['dataInicio'];
				$i++;
			}
			$x['num'] = $i;
		}
		else
		{
			$x['num'] = 0;
		}
		return $x;		
	}
	function retornaPessoa($tipo)
	{
		if($tipo == 1)
		{
			return "Pessoa física";	
		}
		else
		{
			return "Pessoa jurídica";
		}
	}
	function retornaModulos($perfil)
	{
		// recupera quais módulos o usuário tem acesso
		$sql = "SELECT * FROM ig_papelusuario WHERE idPapelUsuario = $perfil"; 
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$campoFetch = mysqli_fetch_array($query);
		$nome = "";
		while($fieldinfo = mysqli_fetch_field($query))
		{
			if(($campoFetch[$fieldinfo->name] == 1) AND ($fieldinfo->name != 'idPapelUsuario'))
			{
				$descricao = recuperaModulo($fieldinfo->name);
				$nome = $nome.";\n + ".$descricao['nome'];
			}
		}
		return substr($nome,1);
	}
	function recuperaUsuarioCompleto($idUsuario)
	{
		//retorna dados do usuário
		$recupera = recuperaDados('ig_usuario',$idUsuario,'idUsuario');
		if($recupera)
		{
			$instituicao = recuperaDados("ig_instituicao",$recupera['idInstituicao'],"idInstituicao");
			$perfil = recuperaDados("ig_papelusuario",$recupera['ig_papelusuario_idPapelUsuario'],"idPapelUsuario");
			$modulos = retornaModulos($recupera['ig_papelusuario_idPapelUsuario']);
			if($recupera['receberNotificacao'] == 1)
			{
				$notificacao = "Habilitado";	
			}
			else
			{
				$notificacao = "Não habilitado";	
			}
			$x = array(
				"nomeCompleto" => $recupera['nomeCompleto'],
				"email" => $recupera['email'],
				"nomeUsuario" => $recupera['nomeUsuario'],
				"perfil" => $perfil['nomePapelUsuario'],
				"telefone" => $recupera['telefone'],
				"receberNotificacao" => $recupera['receberNotificacao'],
				"modulos" => $modulos,
				"notificacao" => $notificacao,		
				"instituicao" => $instituicao['instituicao']);
			return $x;
		}
		else
		{
			return NULL;
		}
	}
	function listaEventosEnviados($idUsuario)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_evento 
			WHERE (idUsuario = $idUsuario 
			OR idResponsavel = $idUsuario 
			OR suplente = $idUsuario) 
			AND publicado = 1 
			AND dataEnvio IS NOT NULL 
			ORDER BY idEvento DESC";
		$query = mysqli_query($con,$sql);
		echo "
			<table class='table table-condensed'>
				<thead>
					<tr class='list_menu'>
						<td>Cod. Evento</td>
						<td>Nome do evento</td>
						<td>Tipo de evento</td>
						<td>Data/Período</td>
						<td width='10%'>Cod. Pedido Contratação</td>
						<td width='10%'></td>
					</tr>
				</thead>
				<tbody>";
		while($campo = mysqli_fetch_array($query))
		{
			$protocolo = recuperaDados("ig_protocolo",$campo['idEvento'],"ig_evento_idEvento");
			$chamado = recuperaAlteracoesEvento($campo['idEvento']);	
			echo "<tr>";
			echo "<td class='list_description'><a href='?perfil=detalhe&evento=".$campo['idEvento']."' target='_blank'>".$campo['idEvento']."</a></td>";
			echo "<td class='list_description'>".$campo['nomeEvento']." ["; 
			if($chamado['numero'] == '0')
			{
				echo "0";
			}
			else
			{
				echo "<a href='?perfil=chamado&p=evento&id=".$campo['idEvento']."' target='_blank'>".$chamado['numero']."</a>";	
			}
			echo "]</td>";
			echo "<td class='list_description'>".retornaTipo($campo['ig_tipo_evento_idTipoEvento'])."</td>";
			echo "<td class='list_description'>".retornaPeriodo($campo['idEvento'])."</td>";
			echo "<td class='list_description'>".substr(retornaPedidos($campo['idEvento']),7)."</td>";
			echo "<td class='list_description'></td>";
			echo "</tr>";		
		}
		echo "
			</tbody>
			</table>";	
	}
	function retornaPedidos($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM sis_protocolo, igsis_pedido_contratacao 
			WHERE sis_protocolo.idPedido = igsis_pedido_contratacao.idPedidoContratacao 
			AND igsis_pedido_contratacao.idEvento = '$idEvento'";
		$query = mysqli_query($con,$sql);
		$protos = "";
		while($protocolo = mysqli_fetch_array($query))
		{
			$protos = ",<br /><a href='?perfil=detalhe&pedido=".$protocolo['idPedidoContratacao']."' target='_blank'>".$protocolo['idPedidoContratacao']."</a>"; 	
		}
		return $protos;
	}
	function retornaProtoPedido($idPedido)
	{
		$con = bancoMysqli();
		$protocolo = recuperaDados("sis_protocolo",$idPedido,"idPedido");
		return $protocolo['idProtocolo'];				
	}
	function retornaProtoEvento($idEvento)
	{
		$con = bancoMysqli();
		$protocolo = recuperaDados("ig_protocolo",$idEvento,"ig_evento_idEvento");
		return $protocolo['idProtocolo'];		
	}
	function retornaMes($mes)
	{
		switch($mes)
		{
			case "01":
				return "Janeiro";
			break;
			case "02":
				return "Fevereiro";
			break;
			case "03":
				return "Março";
			break;
			case "04":
				return "Abril";
			break;
			case "05":
				return "Maio";
			break;
			case "06":
				return "Junho";
			break;
			case "07":
				return "Julho";
			break;
			case "08":
				return "Agosto";
			break;
			case "09":
				return "Setembro";
			break;
			case "10":
				return "Outubro";
			break;
			case "11":
				return "Novembro";
			break;
			case "12":
				return "Dezembro";
			break;
		}
	}
	function resumoSubEventosProducao($idEvento)
	{
		$con = bancoMysqli();
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		if($evento['subEvento'] == 0 OR $evento['subEvento'] == NULL)
		{
			return "";	
		}
		else
		{
			$sql_sub = "SELECT * FROM ig_sub_evento 
				WHERE ig_evento_idEvento = '$idEvento' 
				AND publicado = '1'";
			$query_sub = mysqli_query($con,$sql_sub);
			$i = 0;	
			while($sub = mysqli_fetch_array($query_sub))
			{
				$id = $sub['idSubEvento'];
				$x[$i]['titulo'] = $sub['titulo'];
				$x[$i]['descricao'] = $sub['descricao'];
				$sql = "SELECT * FROM ig_ocorrencia WHERE idSubEvento = '$id' AND publicado = '1' ORDER BY dataInicio";
				$query = mysqli_query($con,$sql);
				$campo = mysqli_fetch_array($query);
				if($campo['dataFinal'] == '0000-00-00')
				{
					$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
					$semana = "";
				}
				else
				{
					$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
					if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
					if($campo['terca'] == 1){$ter = "terça";}else{$ter = "";}
					if($campo['quarta'] == 1){$qua = "quarta";}else{$qua = "";}
					if($campo['quinta'] == 1){$qui = "quinta";}else{$qui = "";}
					if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
					if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
					if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
					$semana = "(".$seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom.")";	
				}
				if($campo['diaEspecial'] == 1)
				{
					if($campo['libras'] == 1)
					{
						$libras = "Tradução em libras";
					}
					else
					{
						$libras = "";
					}
					if($campo['audiodescricao'] == 1)
					{
						$audio = "Audiodescrição";
					}
					else
					{
						$audio = "";
					}
					if($campo['precoPopular'] == 1)
					{
						$popular = "Preço popular";
					}
					else
					{
						$popular = "";
					}
					$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular;
				}
				else
				{
					$dia_especial = "";
				}
				//recuperaDados($tabela,$idEvento,$campo)
				$hora = exibirHora($campo['horaInicio']);
				$duracao = recuperaDuracao($campo ['duracao']);
				$retirada = recuperaIngresso($campo['retiradaIngresso']);
				$valor = dinheiroParaBr($campo['valorIngresso']);
				$local = recuperaDados("ig_local",$campo['local'],"idLocal");
				$espaco = $local['sala'];
				$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
				$instituicao = $inst['instituicao'];
				$id = $campo['idOcorrencia'];
				$tipo = recuperaDados("ig_tipo_evento",$sub['idTipo'],"idTipoEvento");
				$x[$i]['ocorrencia'] = "<div class='left'>".$tipo['tipoEvento']." $dia_especial <br />
					Data: $data $semana <br />
					Horário: $hora<br />
					Duração: $duracao<br />
					Local: $espaco - $instituicao<br />
					Retirada de ingresso: $retirada  - Valor: $valor <br /></br>";  
				$i++;
			}
			$x['registros'] = $i;
			return $x;						
		}
	}
	function resumoSubEventos($idEvento)
	{
		$con = bancoMysqli();
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		if($evento['subEvento'] == 0 OR $evento['subEvento'] == NULL)
		{
			return "";	
		}
		else
		{
			$sql_sub = "SELECT * FROM ig_sub_evento 
				WHERE ig_evento_idEvento = '$idEvento' 
				AND publicado = '1'";
			$query_sub = mysqli_query($con,$sql_sub);
			$i = 0;	
			$sub = mysqli_fetch_array($query_sub);
			$id = $sub['idSubEvento'];
			$x['titulo'] = $sub['titulo'];
			$x['descricao'] = $sub['descricao'];
			$sql = "SELECT * FROM ig_ocorrencia WHERE idSubEvento = '$id' AND publicado = '1' ORDER BY dataInicio";
			$query = mysqli_query($con,$sql);
			$campo = mysqli_fetch_array($query);
			if($campo['dataFinal'] == '0000-00-00')
			{
				$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
				$semana = "";
			}
			else
			{
				$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
				if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
				if($campo['terca'] == 1){$ter = "terça";}else{$ter = "";}
				if($campo['quarta'] == 1){$qua = "quarta";}else{$qua = "";}
				if($campo['quinta'] == 1){$qui = "quinta";}else{$qui = "";}
				if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
				if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
				if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
				$semana = "(".$seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom.")";	
			}
			if($campo['diaEspecial'] == 1)
			{
				if($campo['libras'] == 1)
				{
					$libras = "Tradução em libras";
				}
				else
				{
					$libras = "";
				}
				if($campo['audiodescricao'] == 1)
				{
					$audio = "Audiodescrição";
				}
				else
				{
					$audio = "";
				}
				if($campo['precoPopular'] == 1)
				{
					$popular = "Preço popular";
				}
				else
				{
					$popular = "";
				}
				$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular;
			}
			else
			{
				$dia_especial = "";
			}
			//recuperaDados($tabela,$idEvento,$campo)
			$hora = exibirHora($campo['horaInicio']);
			$duracao = recuperaDuracao($campo ['duracao']);
			$retirada = recuperaIngresso($campo['retiradaIngresso']);
			$valor = dinheiroParaBr($campo['valorIngresso']);
			$local = recuperaDados("ig_local",$campo['local'],"idLocal");
			$espaco = $local['sala'];
			$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
			$instituicao = $inst['instituicao'];
			$id = $campo['idOcorrencia'];
			$tipo = recuperaDados("ig_tipo_evento",$sub['idTipo'],"idTipoEvento");
			$x['ocorrencia'] = "<div class='left'>".$tipo['tipoEvento']." $dia_especial <br />
				Data: $data $semana <br />
				Horário: $hora<br />
				Duração: $duracao<br />
				Local: $espaco - $instituicao<br />
				Retirada de ingresso: $retirada  - Valor: $valor <br /></br>";
			return $x;						
		}
	}
	function gradeFilmes($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			ORDER BY dataInicio, horaInicio ASC";
		$query = mysqli_query($con,$sql);
		$data_antiga = "";
		while($cinema = mysqli_fetch_array($query))
		{
			$data = $cinema['dataInicio'];
			$idCinema = $cinema['idCinema'];
			$filme = recuperaDados("ig_cinema",$idCinema,"idCinema");
			$local = recuperaDados("ig_local",$cinema['local'],"idLocal");
			$retirada = recuperaDados("ig_retirada",$cinema['retiradaIngresso'],"idRetirada");
			if($data_antiga != $data)
			{
				echo "<h4>".exibirDataBr($cinema['dataInicio'])." - ".diasemana($cinema['dataInicio'])."</h4>";
			}
			if($cinema['idTipoOcorrencia'] != 5)
			{	
			}
			else
			{
				echo "<div class='left'>".substr($cinema['horaInicio'], 0, -3)."<h5>".$filme['titulo']."</h5>";
				echo "(".$filme['tituloOriginal'].", ".$filme['anoProducao'].", ".$filme['minutagem']." min, ".$filme['bitola'].", ".$filme['genero'].")<br />";
				echo $filme['elenco']."<br />";
				echo $filme['sinopse'];
				echo "<br />";
				echo $local['sala']." - ".$retirada['retirada']." valor: R$".dinheiroParaBr($cinema['valorIngresso']);
				echo "</div><br /><br /><br />";
				$data_antiga = $data;			
			}
		}
	}
	function listaSubEventosCom($idEvento)
	{
		//lista ocorrencias de determinado evento
		$sql = "SELECT * FROM ig_sub_evento 
			WHERE ig_evento_idEvento = '$idEvento' 
			AND publicado = '1' 
			ORDER BY idSubEvento DESC";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		while($campo = mysqli_fetch_array($query))
		{	
			$descricao = "<strong>".$campo['titulo']."</strong> (".retornaTipo($campo['idTipo']).")<br />";
			$id = $campo['idSubEvento'];
			echo $descricao."<br />";
			echo "Sinopse:<br />";
			echo $campo['descricao'];
			echo "<br /><br /><br />";	
		}
	}
	function recuperaBancos($id)
	{
		$bancos = recuperaDados("igsis_bancos",$id,"ID");
		$x['codBanco'] = $bancos['ID'];
		$x['banco'] = $bancos['banco'];
		$x['CodigoBanco'] = $bancos['codigo'];
		return $x;		
	}
	function enderecoCEP($cep)
	{
		$con = bancoMysqliCEP();
		$cep_index = substr($cep, 0, 5);
		$dados['sucesso'] = 0;
		$sql01 = "SELECT * FROM igsis_cep_cep_log_index WHERE cep5 = '$cep_index' LIMIT 0,1";
		$query01 = mysqli_query($con,$sql01);
		$campo01 = mysqli_fetch_array($query01);
		$uf = "igsis_cep_".$campo01['uf'];
		$sql02 = "SELECT * FROM $uf WHERE cep = '$cep'";
		$query02 = mysqli_query($con,$sql02);
		$campo02 = mysqli_fetch_array($query02);
		$res = mysqli_num_rows($query02);
		if($res > 0)
		{
			$dados['sucesso'] = 1;
		}
		else
		{
			$dados['sucesso'] = 0;
		}
		$dados['rua']     = $campo02['tp_logradouro']." ".$campo02['logradouro'];
		$dados['bairro']  = $campo02['bairro'];
		$dados['cidade']  = $campo02['cidade'];
		$dados['estado']  = strtoupper($campo01['uf']);
		return $dados;
	}
	function recuperaAlteracoesEvento($idEvento)
	{
		$con = bancoMysqli();
		$sql =	"SELECT * FROM igsis_chamado WHERE idEvento = '$idEvento' ORDER BY idChamado DESC";
		$query = mysqli_query($con,$sql);
		$i = 0;
		while($chamado = mysqli_fetch_array($query))
		{
			$usuario = recuperaUsuario($chamado['idUsuario']);
			$x[$i]['titulo'] = $chamado['titulo'];
			$x[$i]['descricao'] = $chamado['descricao'];
			$x[$i]['justificativa'] = $chamado['justificativa'];
			$x[$i]['usuario'] = $usuario['nomeCompleto'];
			$x[$i]['tipo'] = $chamado['tipo'];
			$i++;		
		}
		$x['numero'] = $i;
		return $x;
	}
	function somaParcela($idPedido,$numero)
	{
		$con = bancoMysqli();
		$sql = "SELECT valor FROM igsis_parcelas WHERE idPedido = '$idPedido'";
		$query = mysqli_query($con,$sql);
		$soma = 0;
		$i = 1;
		$parcela = array();
		while($valor = mysqli_fetch_array($query))
		{
			$parcela[$i] = $valor['valor'];
			$i++;	
		}
		for($i = 1; $i <= $numero; $i++)
		{
			if(isset($parcela[$i]) AND $parcela[$i] != NULL)
			{	
				$soma = $soma + $parcela[$i];
			}
		}
		return $soma;
	}
	function somaVerbas($idPedido)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$idPedido'";
		$query = mysqli_query($con,$sql);
		$soma = 0;
		while($valor = mysqli_fetch_array($query))
		{
			$soma = $soma + $valor['valor'];	
		}		
		return $soma;
	}
	function comparaValores($idPedido)
	{
		$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
		$verba = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
		if($pedido['parcelas'] == 1 OR $verba['multiplo'] != 1)
		{
			return "Sem conflito de valores.";	
		}
		else
		{
			$parcela = somaParcela($idPedido,$pedido['parcelas']);
			$verba = somaVerbas($idPedido);
			if($verba != $parcela)
			{
				return 	"Conflito entre valores parcelados e verbas múltiplas.";
			}
			else
			{
				return "Sem conflitos de valores.";	
			}	
			return "Sem conflitos de valores.";
		}
	}
	function infoContrato($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT idPedidoContratacao,valor FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			$valor = 0;
			while($pedido = mysqli_fetch_array($query))
			{
				$valor = $valor + $pedido['valor'];	
			}
			return $valor;
		}
		else
		{
			return 0;	
		}
	}
	function retornaLocal($idLocal)
	{
		$con = bancoMysqli();
		$local = recuperaDados("ig_local",$idLocal,"idLocal");
		return $local['sala'];	
	}
	//retorna o dia da semana segundo um date(a-m-d)
	function diaSemanaBase($data)
	{ 
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana)
		{
			case"0":
				$diasemana = "domingo";
			break;
			case"1":
				$diasemana = "segunda";
			break;
			case"2":
				$diasemana = "terca";
			break;
			case"3":
				$diasemana = "quarta";
			break;
			case"4":
				$diasemana = "quinta";
			break;
			case"5":
				$diasemana = "sexta";
			break;
			case"6":
				$diasemana = "sabado";
			break;
		}
		return "$diasemana";
	}
	function listaOcorrenciasContrato($idEvento)
	{
		//lista ocorrencias de determinado evento
		$sql = "SELECT * FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = 1 
			AND idTipoOcorrencia NOT LIKE '5' 
			ORDER BY dataInicio";
		$con = bancoMysqli();
		$query = mysqli_query($con,$sql);
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		$i = 0;
		if($evento['ig_tipo_evento_idTipoEvento'] != 1)
		{
			while($campo = mysqli_fetch_array($query))
			{
				$tipo_de_evento = retornaTipoOcorrencia($campo['idTipoOcorrencia']); // retorna o tipo de ocorrência
				if($campo['idSubEvento'] != NULL)
				{
					$sub = recuperaDados("ig_sub_evento",$campo['idSubEvento'],"idSubEvento");
				}
				else
				{
					$sub['titulo'] = "";		
				}
				if($campo['dataFinal'] == '0000-00-00' OR $campo['dataFinal'] == $campo['dataInicio'])
				{
					$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
					$semana = "";
					$tipo_de_evento = "Evento de data única";
				}
				else
				{
					$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
					if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
					if($campo['terca'] == 1){$ter = " terça";}else{$ter = "";}
					if($campo['quarta'] == 1){$qua = " quarta";}else{$qua = "";}
					if($campo['quinta'] == 1){$qui = " quinta";}else{$qui = "";}
					if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
					if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
					if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
					$semana = $seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom;	
				}
				if($campo['diaEspecial'] == 1)
				{
					if($campo['libras'] == 1)
					{
						$libras = "Tradução em libras";
					}
					else
					{
						$libras = "";
					}
					if($campo['audiodescricao'] == 1)
					{
						$audio = "Audiodescrição";
					}
					else
					{
						$audio = "";
					}
					if($campo['precoPopular'] == 1)
					{
						$popular = "Preço popular";
					}
					else
					{
						$popular = "";
					}
					$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular;
				}
				else
				{
					$dia_especial = "";
				}
				//recuperaDados($tabela,$idEvento,$campo)
				$hora = exibirHora($campo['horaInicio']);
				$duracao = recuperaDuracao($campo ['duracao']);
				$retirada = recuperaIngresso($campo['retiradaIngresso']);
				$valor = dinheiroParaBr($campo['valorIngresso']);
				$local = recuperaDados("ig_local",$campo['local'],"idLocal");
				$espaco = $local['sala'];
				$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
				$instituicao = $inst['instituicao'];
				$id = $campo['idOcorrencia'];
				$y1 = $tipo_de_evento." ".$dia_especial." ".$sub['titulo'];
				$x[$i]['tipo'] = $y1;
				if($semana != "")
				{
					$x[$i]['data'] = $data." (".trim($semana).")";
				}
				else
				{
					$x[$i]['data'] = $data." ".trim($semana);
				}
				$x[$i]['hora'] = $hora;
				$x[$i]['espaco'] = $local['sala']." (".$instituicao.")";
				if($campo['virada'] == 1)
				{
					$x[$i]['data'] = $data." ".trim($semana);
					$x[$i]['hora'] = "";
					$x[$i]['espaco'] = "DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL 2018.";
				}
				$i++;
			}
		}
		$x['numero'] = $i;
		return $x;
	}
	function reloadAgenda()
	{	
		$con = bancoMysqli();
		$novaTabela = "igsis_agenda_".date('YmdHis');
		$sql_backup = "CREATE TABLE $novaTabela SELECT * FROM igsis_agenda";
		$query_backup = mysqli_query($con,$sql_backup);
		if($query_backup)
		{
			$sql_limpa = "TRUNCATE TABLE igsis_agenda";
			if(mysqli_query($con,$sql_limpa))
			{
				$sql_auto = "ALTER TABLE igsis_agenda AUTO_INCREMENT = 1";
				$sql_query = mysqli_query($con,$sql_auto);
				mysqli_query($con,$sql_auto);		
			}
			$sql_pesquisar = "SELECT 
				ig_ocorrencia.idEvento, 
				dataInicio, 
				idTipoOcorrencia, 
				local, 
				horaInicio, 
				idInstituicao, 
				dataFinal, 
				segunda, 
				terca, 
				quarta, 
				quinta, 
				sexta, 
				sabado, 
				domingo, 
				idOcorrencia, 
				idCinema, 
				virada 
				FROM ig_ocorrencia, 
				ig_evento 
				WHERE ig_evento.dataEnvio IS NOT NULL 
				AND ig_evento.publicado = '1' 
				AND ig_evento.idInstituicao IS NOT NULL 
				AND ig_evento.publicado = '1' 
				AND ig_evento.idEvento = ig_ocorrencia.idEvento 
				AND ig_ocorrencia.publicado = '1' 
				ORDER BY dataInicio, horaInicio";
			$query_pesquisar = mysqli_query($con,$sql_pesquisar);
			$data = "";
			$data_antigo = "1";
			while($evento = mysqli_fetch_array($query_pesquisar))
			{
				$idEvento = $evento['idEvento'];
				$dataInicio = $evento['dataInicio'];
				$dataFinal = $evento['dataFinal'];
				$local = $evento['local'];
				$idTipo = $evento['idTipoOcorrencia'];
				$hora = $evento['horaInicio'];
				$idInstituicao = $evento['idInstituicao'];
				$segunda = $evento['segunda'];
				$terca = $evento['terca'];
				$quarta = $evento['quarta'];
				$quinta = $evento['quinta'];
				$sexta = $evento['sexta'];
				$sabado = $evento['sabado'];
				$domingo = $evento['domingo'];
				$idOcorrencia = $evento['idOcorrencia'];
				$idCinema = $evento['idCinema'];
				if($evento['virada'] == 1)
				{
					$sql_virada = "INSERT INTO `igsis_agenda` 
						(`idAgenda`, 
						`idEvento`, 
						`data`, 
						`hora`, 
						`idLocal`, 
						`idInstituicao`, 
						`idTipo`, 
						`idOcorrencia`, 
						`idCinema`) 
						VALUES (NULL, 
						'$idEvento', 
						'2018-05-20', 
						'00:00:00', 
						'388', 
						'4', 
						'$idTipo', 
						'$idOcorrencia', 
						'$idCinema');";
					$query_virada = mysqli_query($con,$sql_virada);
					if($query)
					{
						//echo "Data importada na agenda.<br />";	
					}
					else
					{
						$mensagem = $mensagem."Erro.<br />";	
					}		
				}
				else
				{
					if($dataFinal == '0000-00-00' OR $dataFinal == $dataInicio)
					{
						//Evento de data única
						$sql = "INSERT INTO `igsis_agenda` 
							(`idAgenda`, 
							`idEvento`, 
							`data`, 
							`hora`, 
							`idLocal`, 
							`idInstituicao`, 
							`idTipo`, 
							`idOcorrencia`, 
							`idCinema`) 
							VALUES (NULL, 
							'$idEvento', 
							'$dataInicio', 
							'$hora', 
							'$local', 
							'$idInstituicao', 
							'$idTipo', 
							'$idOcorrencia', 
							'$idCinema');";
						$query = mysqli_query($con,$sql);
						if($query)
						{
							//echo "Data importada na agenda.<br />";	
						}
						else
						{
							$mensagem - $mensagem."Erro.<br />";	
						}		
					}
					else
					{
						// Evento de tempoarada
						while(strtotime($dataInicio) <=  strtotime($dataFinal))
						{
							$semana = diaSemanaBase($dataInicio);
							switch($semana)
							{
								case 'segunda':
									if($segunda == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											//echo "Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem - $mensagem."Erro.<br />";	
										}
									}
								break;
								case 'terca':
									if($terca == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											//echo "Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem - $mensagem."Erro.<br />";	
										}		
									}
								break;
								case 'quarta':
									if($quarta == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											//echo "Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem - $mensagem."Erro.<br />";	
										}
									}
								break;
								case 'quinta':
									if($quinta == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											//echo "Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem - $mensagem."Erro.<br />";
										}				
									}
								break;
								case 'sexta':
									if($sexta == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											//echo "Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem - $mensagem."Erro.<br />";	
										}
									}
								break;
								case 'sabado':
									if($sabado == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											//echo "Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem - $mensagem."Erro.<br />";	
										}
									}
								break;
								case 'domingo':
									if($domingo == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											//echo "Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem - $mensagem."Erro.<br />";	
										}
									}
								break;
							}// fim da switch
							$dataInicio = date('Y-m-d', strtotime("+1 days",strtotime($dataInicio)));
						}
					}
				}
			}
		}
	}
	function atualizarAgenda($idEvento)
	{
		$con = bancoMysqli();
		// apaga da agenda as ocorrencias com os idEvento 
		$sql_limpa = "DELETE FROM igsis_agenda WHERE idEvento = '$idEvento'";
		mysqli_query($con,$sql_limpa);
		$sql_pesquisar = "SELECT ig_ocorrencia.idEvento, 
			dataInicio, 
			idTipoOcorrencia, 
			local, 
			horaInicio, 
			idInstituicao, 
			dataFinal, 
			segunda, 
			terca, 
			quarta, 
			quinta, 
			sexta, 
			sabado, 
			domingo, 
			idOcorrencia, 
			idCinema, 
			virada, 
			ocupacao, 
			dataEnvio 
			FROM ig_ocorrencia, 
			ig_evento 
			WHERE ig_evento.publicado = '1' 
			AND ig_evento.publicado = '1' 
			AND ig_evento.idEvento = ig_ocorrencia.idEvento 
			AND ig_ocorrencia.publicado = '1' 
			AND ig_evento.idEvento = '$idEvento' 
			ORDER BY dataInicio, horaInicio";
		$query_pesquisar = mysqli_query($con,$sql_pesquisar);
		$mensagem = "Erro";
		$data = "";
		$data_antigo = "1";
		while($evento = mysqli_fetch_array($query_pesquisar))
		{
			if($evento['ocupacao'] == 1 OR $evento['dataEnvio'] != NULL)
			{
				$inst = recuperaDados("ig_local",$evento['local'],"idLocal");
				$idInstituicao = $inst['idInstituicao'];
				$idEvento = $evento['idEvento'];
				$dataInicio = $evento['dataInicio'];
				$dataFinal = $evento['dataFinal'];
				$local = $evento['local'];
				$idTipo = $evento['idTipoOcorrencia'];
				$hora = $evento['horaInicio'];
				//$idInstituicao = $idInst;
				$segunda = $evento['segunda'];
				$terca = $evento['terca'];
				$quarta = $evento['quarta'];
				$quinta = $evento['quinta'];
				$sexta = $evento['sexta'];
				$sabado = $evento['sabado'];
				$domingo = $evento['domingo'];
				$idOcorrencia = $evento['idOcorrencia'];
				$idCinema = $evento['idCinema'];
				$mensagem = "Atualização de Agenda<br />";
				if($evento['virada'] == 1)
				{
					$sql = "INSERT INTO `igsis_agenda` 
						(`idAgenda`, 
						`idEvento`, 
						`data`, 
						`hora`, 
						`idLocal`, 
						`idInstituicao`, 
						`idTipo`, 
						`idOcorrencia`, 
						`idCinema`) 
						VALUES (NULL, 
						'$idEvento', 
						'2018-05-20', 
						'00:00:00', 
						'388', 
						'4', 
						'$idTipo', 
						'$idOcorrencia', 
						'$idCinema');";
					$query = mysqli_query($con,$sql);
					if($query)
					{
						//echo "Data importada na agenda.<br />";	
					}
					else
					{
						$mensagem = $mensagem."Erro 1.<br />";	
					}
				}
				else
				{
					if($dataFinal == '0000-00-00' OR $dataFinal == $dataInicio)
					{
						//Evento de data única
						$sql = "INSERT INTO `igsis_agenda` 
							(`idAgenda`, 
							`idEvento`, 
							`data`, 
							`hora`, 
							`idLocal`, 
							`idInstituicao`, 
							`idTipo`, 
							`idOcorrencia`, 
							`idCinema`) 
							VALUES (NULL, 
							'$idEvento', 
							'$dataInicio', 
							'$hora', 
							'$local', 
							'$idInstituicao', 
							'$idTipo', 
							'$idOcorrencia', 
							'$idCinema');";
						$query = mysqli_query($con,$sql);
						if($query)
						{
							$mensagem = $mensagem."Data importada na agenda.<br />";	
						}
						else
						{
							$mensagem = $mensagem."Erro 2.<br />";
						}		
					}
					else
					{
						// Evento de tempoarada
						while(strtotime($dataInicio) <=  strtotime($dataFinal))
						{
							$semana = diaSemanaBase($dataInicio);
							switch($semana)
							{
								case 'segunda':
									if($segunda == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											$mensagem = $mensagem."Data importada na agenda.<br />";
										}
										else
										{
											$mensagem = $mensagem."Erro 3.<br />";	
										}
									}
								break;
								case 'terca':
									if($terca == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											$mensagem = $mensagem."Data importada na agenda.<br />";;	
										}
										else
										{
											$mensagem = $mensagem."Erro 4.<br />";	
										}
									}
								break;
								case 'quarta':
									if($quarta == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											$mensagem = $mensagem."Data importada na agenda.<br />";
										}
										else
										{
											$mensagem = $mensagem."Erro 5.<br />";	
										}
									}
								break;
								case 'quinta':
									if($quinta == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											$mensagem = $mensagem."Data importada na agenda.<br />";
										}
										else
										{
											$mensagem = $mensagem."Erro 6.<br />";
										}
									}
								break;
								case 'sexta':
									if($sexta == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											$mensagem = $mensagem."Data importada na agenda.<br />";	
										}
										else
										{
											$mensagem = $mensagem."Erro 7.<br />";	
										}
									}
								break;
								case 'sabado':
									if($sabado == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											$mensagem = $mensagem."Data importada na agenda.<br />";
										}
										else
										{
											$mensagem = $mensagem."Erro 8.<br />";	
										}
									}
								break;
								case 'domingo':
									if($domingo == '1')
									{
										$sql = "INSERT INTO `igsis_agenda` 
											(`idAgenda`, 
											`idEvento`, 
											`data`, 
											`hora`, 
											`idLocal`, 
											`idInstituicao`, 
											`idTipo`, 
											`idOcorrencia`, 
											`idCinema`) 
											VALUES (NULL, 
											'$idEvento', 
											'$dataInicio', 
											'$hora', 
											'$local', 
											'$idInstituicao', 
											'$idTipo', 
											'$idOcorrencia', 
											'$idCinema');";
										$query = mysqli_query($con,$sql);
										if($query)
										{
											$mensagem = $mensagem."Data importada na agenda .<br />";
										}
										else
										{
											$mensagem = $mensagem."Erro 9.<br />";	
										}
									}
								break;
							}// fim da switch
							$dataInicio = date('Y-m-d', strtotime("+1 days",strtotime($dataInicio)));
						}
					}
				}
			}
		}
		return $mensagem;
	}
	function recuperaComentarios($idChamado)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_chamado_comentarios WHERE idChamado = '$idChamado' ORDER BY data DESC";
		$query = mysqli_query($con,$sql);
		while($comentario = mysqli_fetch_array($query))
		{
			$usuario = recuperaDados("ig_usuario",$comentario['idUsuario'],"idUsuario");
			echo "<div style='border: 1px solid gray; padding: 20px;'>";
			echo nl2br($comentario['comentario']);
			echo "<br />";
			echo "<i>enviado por ".$usuario['nomeCompleto']." em ".exibirDataHoraBr($comentario['data'])."</i><br /><br /></div>";
		}
	}
	function detalhesEmail($idEvento)
	{
		require "../funcoes/funcoesSiscontrat.php";
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		$pedido = listaPedidoContratacao($idEvento);
		$conteudo = "<h4>".$evento['nomeEvento']."</h4>
			<p>".descricaoEvento($idEvento)."</p>      
			<h5>Ocorrências</h5>
			".resumoOcorrencias($idEvento)."<br /><br />
			".listaOcorrenciasTexto($idEvento)."
			<h5>Especificidades</h5>
			<p>".descricaoEspecificidades($idEvento,$evento['ig_tipo_evento_idTipoEvento'])."</p>";
		if($pedido != NULL)
		{ 
			$conteudo .= "<h4>Pedidos de contratação</h4>";
			for($i = 0; $i < count($pedido); $i++)
			{
				$dados = siscontrat($pedido[$i]);
				$pessoa = siscontratDocs($dados['IdProponente'],$dados['TipoPessoa']);
				$conteudo .= "<p align='left'>
					Nome ou Razão Social: <b>".$pessoa['Nome']."</b><br />
					Tipo de pessoa: <b>".retornaTipoPessoa($dados['TipoPessoa'])."</b><br />
					Dotação: <b>".retornaVerba($dados['Verba'])."</b><br />
					Valor:<b>R$ ".dinheiroParaBr($dados['ValorGlobal'])."</b><br />		
					Forma de pagamento:<b>".$dados['FormaPagamento']."</b><br />		
					</p>";      
			}// fechamento do for
		}
		else
		{
			$conteudo .= "<h5> Não há pedidos de contratação. </h5>";
		}
		$conteudo .= "
			<h4></h4>
			<p align='left'>
			<br />
			<br />
			<h5>Previsão de serviços externos</h5>
			".listaServicosExternos($idEvento)."<br /><br />
			<h5>Serviços Internos</h5>
			".listaServicosInternos($idEvento)."
			</p>
			</p>";
		return $conteudo;
	}
	function geraFrase()
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_frases ORDER BY RAND() LIMIT 1";
		$query = mysqli_query($con,$sql);
		$frase = mysqli_fetch_array($query);
		echo $frase['frase'];
	}
	function geraPenalidades($id)
	{
		$con = bancoMysqli();
		$pena = recuperaDados("sis_penalidades",$id,"modelo");
		echo nl2br($pena['txt']);
	}
	function recuperaPenalidades($id)
	{
		$penal = recuperaDados("sis_penalidades",$id,"idPenalidades");
		$x['idPenalidade'] = $penal['idPenalidades'];
		$x['txt'] = $penal['txt'];
		return $x;		
	}
	function soNumero($str)
	{
		return preg_replace("/[^0-9]/", "", $str);
	}
	function avisoComunicacao($idEvento)
	{
		$con = bancoMysqli();
		$sql = "INSERT INTO ig_com_re_evento 
			(`ig_produtor_idProdutor`, 
			`ig_tipo_evento_idTipoEvento`, 
			`ig_programa_idPrograma`, 
			`projetoEspecial`, 
			`nomeEvento`, 
			`projeto`, 
			`memorando`, 
			`idResponsavel`, 
			`suplente`, 
			`autor`, 
			`fichaTecnica`, 
			`faixaEtaria`, 
			`sinopse`, 
			`releaseCom`, 
			`parecerArtistico`, 
			`confirmaFinanca`, 
			`confirmaDiretoria`, 
			`confirmaComunicacao`, 
			`confirmaDocumentacao`, 
			`confirmaProducao`, 
			`numeroProcesso`, 
			`publicado`, 
			`idUsuario`, 
			`ig_modalidade_IdModalidade`, 
			`linksCom`, 
			`subEvento`, 
			`dataEnvio`, 
			`justificativa`, 
			`idInstituicao`, 
			`ocupacao`, 
			`idEvento`) 
			SELECT `ig_produtor_idProdutor`, 
			`ig_tipo_evento_idTipoEvento`, 
			`ig_programa_idPrograma`, 
			`projetoEspecial`, 
			`nomeEvento`, 
			`projeto`, 
			`memorando`, 
			`idResponsavel`, 
			`suplente`, 
			`autor`, 
			`fichaTecnica`, 
			`faixaEtaria`, 
			`sinopse`, 
			`releaseCom`, 
			`parecerArtistico`, 
			`confirmaFinanca`, 
			`confirmaDiretoria`, 
			`confirmaComunicacao`, 
			`confirmaDocumentacao`, 
			`confirmaProducao`, 
			`numeroProcesso`, 
			`publicado`, 
			`idUsuario`, 
			`ig_modalidade_IdModalidade`, 
			`linksCom`, 
			`subEvento`, 
			`dataEnvio`, 
			`justificativa`, 
			`idInstituicao`, 
			`ocupacao`, 
			`idEvento` 
			FROM ig_evento 
			WHERE idEvento = '$idEvento'";
		$query = mysqli_query($con,$sql);	
		if($query)
		{
			$sql_agenda = "INSERT INTO ig_com_re_agenda 
				(`idAgenda`, 
				`idEvento`, 
				`data`, 
				`hora`, 
				`idLocal`, 
				`idInstituicao`, 
				`idTipo`, 
				`idOcorrencia`, 
				`idCinema`) 
				SELECT `idAgenda`, 
				`idEvento`, 
				`data`, 
				`hora`, 
				`idLocal`, 
				`idInstituicao`, 
				`idTipo`, 
				`idOcorrencia`, 
				`idCinema` 
				FROM igsis_agenda 
				WHERE idEvento = '$idEvento'";
			$query_agenda = mysqli_query($con,$sql_agenda);
			if($query_agenda)
			{
				return TRUE;	
			}
			else
			{
				return FALSE;	
			}
		}
		else
		{
			return FALSE;	
		}
	}
	function comparaVersoesCom($idEvento)
	{	
		// compara eventos
		$novo = recuperaDados("ig_evento",$idEvento,"idEvento");
		$antigo = recuperadados("ig_com_re_evento",$idEvento,"idEvento");
		$x = "";
		$evento = strcmp($novo['nomeEvento'],$antigo['nomeEvento']);
		$projeto_especial = strcmp($novo['projetoEspecial'],$antigo['projetoEspecial']);
		$projeto = strcmp($novo['projeto'],$antigo['projeto']);
		$tipo_evento = strcmp($novo['ig_tipo_evento_idTipoEvento'],$antigo['ig_tipo_evento_idTipoEvento']);
		$autor = strcmp($novo['autor'],$antigo['autor']);
		$ficha_tecnica = strcmp($novo['fichaTecnica'],$antigo['fichaTecnica']);
		$sinopse = strcmp($novo['sinopse'],$antigo['sinopse']);
		$releaseCom = strcmp($novo['releaseCom'],$antigo['releaseCom']);
		if($evento != 0)
		{
			$x .= "O nome do evento foi modificado. <br />";
		}
		if($projeto_especial != 0)
		{
			$x .= "O Projeto Especial foi modificado. <br />";
		}
		if($projeto != 0)
		{
			$x .= "O Projeto foi modificado. <br />";
		}
		if($tipo_evento != 0)
		{
			$x .= "O tipo de evento foi modificado. <br />";
		}
		if($autor != 0)
		{
			$x .= "O autor do evento foi modificado. <br />";
		}
		if($ficha_tecnica != 0)
		{
			$x .= "A ficha técnica do evento foi modificada. <br />";
		}
		if($sinopse != 0)
		{
			$x .= "A sinopse do evento foi modificada. <br />";
		}
		if($releaseCom != 0)
		{
			$x .= "O release do evento foi modificado. <br />";
		}
		// Compara Datas
		$con = bancoMysqli();
		$sql_data = "SELECT * FROM igsis_agenda WHERE idEvento = '$idEvento'";
		$query_data = mysqli_query($con,$sql_data);
		$data_nova = mysqli_num_rows($query_data);
		while($data = mysqli_fetch_array($query_data))
		{
		}
	}
	function viradaOcorrencia($idEvento)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND virada = '1'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		$x['num'] = $num;
		if($num > 0)
		{
			$x['bool'] = '1';	
		}
		else
		{
			$x['bool'] = '0';	
		}
		return $x;
	}
	function recuperaAtualizacao($tipo)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM igsis_atualizacao WHERE tipo LIKE '$tipo' ORDER BY id DESC LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$x = mysqli_fetch_array($query);
		return $x['texto'];
	}
	function retornaMesExtenso($data)
	{
		$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		$data = explode("-", $dataMysql);
		$mes = $data[1];
		return $meses[($mes) - 1];
	}
	function retornaVerbaMultiplas($idPedido)
	{
		$con = bancoMysqli();
		$sql = "SELECT * FROM sis_verbas_multiplas 
			WHERE idPedidoContratacao = '$idPedido' 
			AND valor > '0'";
		$query = mysqli_query($con,$sql);
		$i = 0;
		while($verbas = mysqli_fetch_array($query))
		{
			$m_verbas = recuperaDados("sis_verba",$verbas['idVerba'],"Id_Verba");
			$x[$i]['verba'] = $m_verbas['Verba'];
			$x[$i]['valor'] = dinheiroParaBr($verbas['valor']);
			$x[$i]['idValor'] = $verbas['idVerba'];
			$i++;	
		} 
		$x['numero'] = $i;
		return $x;
	}
	function geraVerbaUsuario($usuario,$idverba)
	{
		$con = bancoMysqli();
		$usuario = recuperaDados("ig_usuario",$usuario,"idUsuario");
		$verba = $usuario['verba'];
		$sql = "SELECT * FROM sis_verba	WHERE Id_Verba IN ($verba) ORDER BY Verba";
		$query = mysqli_query($con,$sql);
		while($verbas = mysqli_fetch_array($query))
		{
			if($verbas['Id_Verba'] == $idverba)
			{
				echo "<option value='".$verbas['Id_Verba']."' selected >".$verbas['Verba']."</option>";	
			}
			else
			{
				echo "<option value='".$verbas['Id_Verba']."' >".$verbas['Verba']."</option>";
			}	
		}
	}
		// Função que valida o CPF
function validaCPF($cpf)
{
	$cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
	// Valida tamanho
	if (strlen($cpf) != 11)
		return false;
	// Calcula e confere primeiro dígito verificador
	for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Lista de CPFs inválidos
	$invalidos = array(
		'11111111111',
		'22222222222',
		'33333333333',
		'44444444444',
		'55555555555',
		'66666666666',
		'77777777777',
		'88888888888',
		'99999999999');
	// Verifica se o CPF está na lista de inválidos
	if (in_array($cpf, $invalidos))
		return false;
	// Calcula e confere segundo dígito verificador
	for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
}

// Função que valida o CNPJ
function validaCNPJ($cnpj)
{
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;
	// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Lista de CNPJs inválidos
	$invalidos = array(
		'11111111111111',
		'22222222222222',
		'33333333333333',
		'44444444444444',
		'55555555555555',
		'66666666666666',
		'77777777777777',
		'88888888888888',
		'99999999999999'
	);
	// Verifica se o CNPJ está na lista de inválidos
	if (in_array($cnpj, $invalidos)) {	
		return false;
	}
	// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}

function mensagem($tipo,$texto){
    return "
	    <div class=\"col-md-12\">
                <div class=\"box box-".$tipo." box-solid\">
                    <div class=\"box-header with-border\">
                        <h3 class=\"box-title\">".$texto."</h3>
                        <div class=\"box-tools pull-right\">
                            <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                        </div>
                    </div>
                </div>
            </div>
	    ";
}
?>