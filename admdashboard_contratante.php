<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/constants.css">
	<link rel="stylesheet" href="css/admdashboard.css">
	<link rel="stylesheet" href="css/collapse.css">
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

		$selectcontratantes = $conn->prepare("SELECT * FROM contratantes WHERE token = '".$_GET['tk']."'");
		$selectcontratantes->execute();
		if($selectcontratantes->rowCount()>0){
			$contratantes = $selectcontratantes->fetchALL();
			foreach($contratantes as $cont){}
		}
		else{
			header("Location: paineladm.php");
		}

		$selectcontratos = $conn->prepare("SELECT p.nome nomeprestadora,
		p.id idprestadora,
		tp.nome nometipo,
		tp.valor valor,
		p.telefone telefoneprestadora,
		c.endereco enderecocontratante,
		DATE_FORMAT(con.data, '%d/%m/%Y') datacontrato,
		con.detalhe detalhecontrato,
		con.status statuscontrato,
		con.id idcontrato
		
		FROM contratos con, prestadoras p, contratantes c, tipoprestadoras tp
		
		WHERE con.idprestadora = p.id AND
		c.id = con.idcontratante AND
		con.idcontratante = ".$cont['id']." AND
		tp.id = p.tipo ORDER BY con.id DESC LIMIT 1;");
		$selectcontratos->execute();
		if($selectcontratos->rowCount()>0){
			$contratos = $selectcontratos->fetchALL();
			foreach($contratos as $con){}
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
              <button class="nav-link" value="<?php echo $_GET['tk'] ?>" onclick="exitDashboard(this, 'contratantes')" style="background-color:transparent; box-shadow:none;">Sair</button>
            </li>
          </ul>
        </div>
      </nav> 
</header>

<div class="maincontainer">
	<div class="shadow-box" style="width:100%">
		<div class="title-dashboard">
			<div>
				<h1>Olá <?php echo $cont['nome'] ?></h1>
			</div>
			<div style="width:30%; justify-content:right;">
				<button class="normal-button" onclick="removeDado(<?php echo $cont['id'] ?>, 'contratante')" style="background-color:red; color:white; margin-right:10px;">Remover Conta</button>
				<button class="normal-button" onclick="document.location.href='admdashboard_alteradados.php?tk=<?php echo $_GET['tk'] ?>&cd=cr'">Alterar Dados</button>
			</div>
			<hr>
		</div>
	</div>
	<div class="maincontainer-row">
		<div class="shadow-box" id="small">
			<h2>Serviço Contratado</h2><hr>
			<?php
				if(isset($contratos)){
					echo '<img class="foto" src="img/prestadoras/exemplo/foto.png"><br>';
					echo '<div><b>Contratado(a):</b> '.$con['nomeprestadora'].'<br></div>';
					echo '<div><b>Nível:</b> '.$con['nometipo'].'<br></div>';
					echo '<div><b>Telefone:</b> '.$con['telefoneprestadora'].'<br></div>';
					echo '<div><b>Endereço do Serviço:</b> '.$con['enderecocontratante'].'<br></div>';
					echo '<div><b>Data do Serviço:</b> '.$con['datacontrato'].'<br></div>';
					echo '<div><b>Valor:</b> '.$con['valor'].'<br></div>';
					echo '<div><b>Status:</b> '.$con['statuscontrato'].'<br></div>';
					echo '<div><b>Detalhes:</b> '.$con['detalhecontrato'].'<br><br></div>';
					if($con['statuscontrato'] == "Aceito"){
						echo '<b>Seu contrato foi aceito! Por favor entre em contato com a prestadora para mais detalhes.</b><br>';
					}
					echo '<i>Você não pode contratar outro serviço até que esse seja concluído ou cancelado!</i><br>';
					echo '<div style="display:flex; flex-direction:row;">';
					echo '<button class="normal-button" onclick="cancelarContrato('.$con['idcontrato'].', '.$con['idprestadora'].', '.$cont['id'].')" style="background-color:red; color:white;">Cancelar Serviço</button>';
					if($con['statuscontrato'] == "Aceito"){
						echo '<button class="normal-button" onclick="" style="margin-left:10px;">Finalizar Serviço</button>';
					}
					echo '</div>';
				}
				else{
					echo 'Você não tem serviços contratados ainda, mas pode contratar um novo agora. O que acha?<br>Use o painel da direita!';
				}
			?>
		</div>
		<div class="shadow-box" id="large">
			<h2>Contratar Novo Serviço</h2><hr>
			<form class="form-novoservico" name="novoservico" id="novoservico">
				<div class="form-item">
					Nome do Contratante: <input type="text" name="nome" id="nome" value="<?php echo $cont['nome'] ?>" disabled>
				</div>
				<div class="form-item">
					Endereço: <input type="text" name="endereco" id="endereco" value="<?php echo $cont['endereco'] ?>" disabled>
				</div>
				<div class="form-row">
					<div class="form-item" id="first">
						Telefone: <input type="text" name="telefone" id="telefone" value="<?php echo $cont['telefone'] ?>" disabled>
					</div>
					<div class="form-item" id="last">
						E-mail: <input type="text" name="email" id="email" value="<?php echo $cont['email'] ?>" disabled>
					</div>
				</div>
				<div class="form-item">
					Detalhes do Serviço*: <textarea name="detalhe" id="detalhe" placeholder="Digite aqui os detalhes do serviço."></textarea>
				</div>
				<div class="form-row">
					<div class="form-item" id="first" style="width:20%">
						Data do Serviço*: <input type="date" name="data" id="data">
					</div>
					<div class="form-item" style="width:40%">
						Estado*: <select name="estado" id="estado" onchange="pegaCidades()">
							<option value="">Selecione</option>
							<?php
								if(isset($estados)){
									foreach($estados as $est){
										echo '<option value="'.$est['Uf'].'">'.$est['Nome'].'</option>';
									}
								}
							?>
						</select>
					</div>
					<div class="form-item" id="last" style="width:40%">
						Cidade*: <select name="cidade" id="cidade" onchange="pegaDiaristas(this, <?php echo $cont['id'] ?>, <?php echo $cont['status'] ?>)">
								<option value=""></option>
							</select>
					</div>
				</div>
			</form>
			<div style="width:100%; text-align:center;"><h3>Busca de Diaristas</h3></div>
			<div class="listadiaristas">
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
<script src="js/bootstrap.min.js"></script>
<script>
	$("#cidade").select2();
	$("#estado").select2();
</script>
<script>
	$("#telefone").mask("(99) 99999-9999");
</script>
</html>