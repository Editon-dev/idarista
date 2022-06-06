<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/constants.css">
	<link rel="stylesheet" href="css/admdashboard.css">
	<meta  charset="utf-8">
	<title>FORMULARIO DE CADASTRO DE PRESTADORA</title>
    <link class rel="icon" href="img/favicon.png" sizes="any">

	<?php
		require_once 'dao/connection.php';

		$selectestados = $conn->prepare("SELECT * FROM `agenda`.`estados` ORDER BY Nome");
		$selectestados->execute();
		if($selectestados->rowCount()>0){
			$estados = $selectestados->fetchALL();
		}

		$selectprestadoras = $conn->prepare("SELECT p.*, tp.nome nivel FROM prestadoras p, tipoprestadoras tp WHERE token = '".$_GET['tk']."' AND tp.id = p.tipo");
		$selectprestadoras->execute();
		if($selectprestadoras->rowCount()>0){
			$prestadoras = $selectprestadoras->fetchALL();
			foreach($prestadoras as $pres){}
		}
		else{
			header("Location: paineladm.php");
		}

		$selectcontratos = $conn->prepare("SELECT c.nome nomecontratante,
		c.telefone telefonecontratante,
		c.endereco enderecocontratante,
		c.email emailcontratante,
		c.cidade cidadecontratante,
		c.estado estadocontratante,
		c.sexo sexo,
		c.id idcontratante,
		p.id idprestadora,
		tp.valor valor,
		DATE_FORMAT(con.data, '%d/%m/%Y') datacontrato,
		con.data,
		con.detalhe detalhecontrato,
		con.status statuscontrato,
		con.id idcontrato
		
		FROM contratos con, prestadoras p, contratantes c, tipoprestadoras tp
		
		WHERE con.idprestadora = p.id AND
		c.id = con.idcontratante AND
		con.idprestadora = ".$pres['id']." AND
		tp.id = p.tipo ORDER BY con.data;");
		$selectcontratos->execute();
		if($selectcontratos->rowCount()>0){
			$contratos = $selectcontratos->fetchALL();
			foreach($contratos as $con){}
		}

		$selectcontratoaceito = $conn->prepare("SELECT p.nome nomeprestadora,
		p.id idprestadora,
		tp.nome nometipo,
		tp.valor valor,
		p.telefone telefoneprestadora,
		c.endereco enderecocontratante,
		c.cidade cidadecontratante,
		c.estado estadocontratante,
		DATE_FORMAT(con.data, '%d/%m/%Y') datacontrato,
		con.detalhe detalhecontrato,
		con.status statuscontrato,
		con.id idcontrato
		
		FROM contratos con, prestadoras p, contratantes c, tipoprestadoras tp
		
		WHERE con.idprestadora = p.id AND
		c.id = con.idcontratante AND
		con.idprestadora = ".$pres['id']." AND
		con.status = 'Aceito' AND
		tp.id = p.tipo ORDER BY con.id DESC LIMIT 1;");
		$selectcontratoaceito->execute();
		if($selectcontratoaceito->rowCount()>0){
			$contratoaceito = $selectcontratoaceito->fetchALL();
		}

		$conn = null;
	?>
</head>
<body>

<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light menu">
      <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>
		
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
			<li class="nav-item">
              <button class="nav-link" value="<?php echo $_GET['tk'] ?>" onclick="exitDashboard(this, 'prestadoras')" style="background-color:transparent; box-shadow:none;">Sair</button>
            </li>
          </ul>
        </div>
      </nav> 
</header>

<div class="maincontainer">
	<div class="shadow-box" style="width:100%">
		<h1>Olá <?php echo $pres['nome'] ?></h1><hr>
	</div>
	<div class="maincontainer-row">
		<div class="shadow-box" id="small">
			<h2>Seus Dados</h2><hr>
			<?php
				if(isset($prestadoras)){
					echo '<img class="foto" src="img/prestadoras/exemplo/foto.png"><br>';
					echo '<div><b>Nome:</b> '.$pres['nome'].'<br></div>';
					echo '<div><b>Data de Nascimento:</b> '.$pres['nascimento'].'<br></div>';
					echo '<div><b>Endereço:</b> '.$pres['endereco'].'<br></div>';
					echo '<div><b>Telefone:</b> '.$pres['telefone'].'<br></div>';
					echo '<div><b>E-mail:</b> '.$pres['email'].'<br></div>';
					echo '<div><b>RG:</b> '.$pres['rg'].'<br></div>';
					echo '<div><b>CPF:</b> '.$pres['cpf'].'<br></div>';
					echo '<div><b>Nível Atual:</b> '.$pres['nivel'].'<br><br></div>';
					echo '<i>Caso queira gerenciar sua conta clique em Atualizar Dados!</i><br>';
					echo '<div style="display:flex; flex-direction:row;">';
					echo '<button class="normal-button" onclick="removeDado('.$pres['id'].', \'prestadora\')" style="background-color:red; color:white; margin-right:10px;">Remover Conta</button>';
					echo '<button class="normal-button" onclick="document.location.href=\'admdashboard_alteradados.php?tk='.$_GET['tk'].'&cd=pr\'">Alterar Dados</button>';
					echo '</div>';
				}
			?>
		</div>
		<div class="shadow-box" id="large">
			<h2>Seus Pedidos de Serviço</h2><hr>
			<div class="listadiaristas">
				
				<?php
					if(!isset($contratoaceito)){
						if(isset($contratos)){
							$cont = 1;
							echo '<div class="listadiaristas-row">';
							foreach ($contratos as $con){
								$sexo = $con['sexo'] == "f" ? 'Feminino' : 'Masculino';
								echo '<div class="listadiaristas-dados">';
								echo '<div class="listadiaristas-dados-row">';
								echo '<div class="listadiaristas-dados" style="box-shadow: none; max-width: none; width:100%;">';
								echo '   Nome do Contratante: '.$con['nomecontratante'].'<br>';
								echo '   Endereço: '.$con['enderecocontratante'].' '.$con['cidadecontratante'].' - '.$con['estadocontratante'].'<br>';
								echo '   Telefone: '.$con['telefonecontratante'].'<br>';
								echo '   Sexo: '.$sexo.'<br>';
								echo '   E-mail: '.$con['emailcontratante'].'<br>';
								echo '   Data do Serviço: '.$con['datacontrato'].'<br>';
								echo '   Detalhes: '.$con['detalhecontrato'].'<br><br>';
								echo '   <div style="display:flex; flex-direction:row;">Valor:<div style="color:forestgreen; font-weight:bold; white-space: break-spaces;"> '.$con['valor'].'</div></div><br>';
								echo '</div>';
								echo '<img class="foto" src="img/contratantes/exemplo/foto.png">';
								echo '</div>';
								echo '<button class="normal-button" onclick="aceitaContrato(\''.$con['idprestadora'].'\', \''.$con['idcontratante'].'\', \''.$con['idcontrato'].'\')">Aceitar Contrato</button>';
								echo '</div>';
								if($cont == 2){
									echo '</div>';
									echo '<div class="listadiaristas-row">';
									$cont = 0;
								}
								$cont++;
							}
							echo '</div>';
						}
						else{
							echo 'Desculpe! Infelizmente não temos pedidos de serviços para você, mas não desista. Logo logo alguém aparecerá aqui.';
						}
					}
					else{
						foreach ($contratoaceito as $conaceito){}
						$sexo = $con['sexo'] == "f" ? 'Feminino' : 'Masculino';
						echo '<div class="listadiaristas-row">';
						echo '<div class="listadiaristas-dados-row">';
						echo '<div class="listadiaristas-dados" style="box-shadow: none; max-width: none; width:100%;">';
						echo '<h2>Você tem um pedido aceito te esperando!</h2>';
						echo '<i style="font-size:10pt;">Você não pode aceitar outro contrato enquanto este não for finalizado. Caso queira cancelar esse contrato entre em contato com o contratante! ';
						echo 'Recomendamos que acerte tudo direitinho e não faça cobrança de valor pelo serviço. ELE JÁ FOI PAGO! O valor se encontra na sua conta aguardando a liberação do contratante.<br>';
						echo 'Após finalizado o serviço não se esqueça de solicitar a liberação do pagamento e seu feedback. Ele é muito importante para você! Aguarde o dia marcado e não se atrase.</i><br>';
						echo '   <div><b>Nome do Contratante:</b> '.$con['nomecontratante'].'<br></div>';
						echo '   <div><b>Endereço:</b> '.$con['enderecocontratante'].' '.$con['cidadecontratante'].' - '.$con['estadocontratante'].'<br></div>';
						echo '   <div><b>Telefone:</b> '.$con['telefonecontratante'].'<br></div>';
						echo '   <div><b>Sexo:</b> '.$sexo.'<br></div>';
						echo '   <div><b>E-mail:</b> '.$con['emailcontratante'].'<br></div>';
						echo '   <div><b>Data do Serviço:</b> '.$con['datacontrato'].'<br></div>';
						echo '   <div style="display:flex;"><b>Valor:</b><div style="color:forestgreen; font-weight:bold; white-space: break-spaces;"> '.$con['valor'].'</div></div><br>';
						echo '   <div style="text-align:center; font-weight:bold;">Detalhes do Serviço</div>';
						echo $con['detalhecontrato'].'<br>';
						echo '</div>';
						echo '<img class="foto" src="img/contratantes/exemplo/foto.png">';
						echo '</div>';
						echo '</div>';
					}
				?>
			</div>
		</div>
	</div>
</div>
</body>
<script src="js/script_diarista.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jquery.mask.min.js"></script>
<script>
	$("#cidade").select2();
	$("#estado").select2();
</script>
<script>
	$("#telefoneaddcliente").mask("(00) 0000-0000");
</script>
</html>