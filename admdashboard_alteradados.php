<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/constants.css">
    <link rel="stylesheet" href="css/style.css">
	<meta  charset="utf-8">
	<title>FORMULARIO DE CADASTRO DE PRESTADORA</title>
    <link class rel="icon" href="img/favicon.png" sizes="any">

	<?php
		require_once 'dao/connection.php';

		if($_GET['cd'] == "pr"){
			$table = "prestadoras";
			$pag = "prestadora";
		}
		if($_GET['cd'] == "cr"){
			$table = "contratantes";
			$pag = "contratante";
		}

		$selectprestadoras = $conn->prepare("SELECT * FROM ".$table." WHERE token = '".$_GET['tk']."';");
		$selectprestadoras->execute();
		if($selectprestadoras->rowCount()>0){
			$prestadoras = $selectprestadoras->fetchALL();
			foreach($prestadoras as $pres){}
		}
		else{
			header("Location: paineladm.php");
		}

		$selectestados = $conn->prepare("SELECT * FROM `agenda`.`estados` ORDER BY Nome");
		$selectestados->execute();
		if($selectestados->rowCount()>0){
			$estados = $selectestados->fetchALL();
		}

		$selectcidades = $conn->prepare("SELECT * FROM `agenda`.`municipio` WHERE Uf = '".$pres['estado']."' ORDER BY Nome");
		$selectcidades->execute();
		if($selectcidades->rowCount()>0){
			$cidades = $selectcidades->fetchALL();
		}
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
              <button class="nav-link" value="<?php echo $_GET['tk'] ?>" onclick="exitDashboard(this, <?php echo $table ?>)" style="background-color:transparent; box-shadow:none;">Sair</button>
            </li>
          </ul>
        </div>
      </nav> 
</header>

<div class="container">
	<form name="form-contratante" id="form" class="margem-contratante" method="post">
	<h1>ALTERAR DADOS</h1><hr><br>
	Nome Completo*: <input type="text" name="nome" ID="nome" maxlength="200" autofocus="1" required value="<?php echo $pres['nome'] ?>"><br><br>
	Data de Nascimento*: <input type="date" name="nascimento" ID="nascimento" required value="<?php echo $pres['nascimento'] ?>"> <br><br>
	<div style="display:flex; align-items:center;">Endereço*: <input type="text" name="endereco" ID="endereco" maxlength="120" required placeholder="Ou use o GPS" value="<?php echo $pres['endereco'] ?>" style="margin-left:10px;"> <div class="normal-button" name="gps" ID="gps" onclick="emDesenvolvimento()" style="margin-left:10px;">USAR GPS</div></div><br>
	Telefone*: <input type="tel" ID="telefone" name="telefone" maxlength="9" title="Apenas números" pattern="[0-9]{5,4}-[0-9]{4}" required placeholder="Digite seu telefone" value="<?php echo $pres['telefone'] ?>"><br><br>
	Estado*: <select name="estado" ID="estado" onchange="pegaCidades()">
				<?php
					if(isset($estados)){
						foreach($estados as $est){
							if($est['Uf'] == $pres['estado'])
								echo '<option value="'.$est['Uf'].'" selected>'.$est['Nome'].'</option>';
							else
								echo '<option value="'.$est['Uf'].'">'.$est['Nome'].'</option>';
						}
					}
				?>
			</select> 
	Cidade*: <select name="cidade" id="cidade" style="width: 270px;">
										<?php
											if(isset($cidades)){
												foreach($cidades as $cid){
													if($cid['Nome'] == $pres['cidade'])
														echo '<option value="'.$cid['Nome'].'" selected>'.$cid['Nome'].'</option>';
													else
														echo '<option value="'.$cid['Nome'].'">'.$cid['Nome'].'</option>';
												}
											}
										?>
									</select><br><br>
	Sexo: <select class="" name="sexo" ID="sexo" placeholder="Selecione">
				<?php
					if($pres['sexo'] == "m")
						echo '<option value="m" selected>Masculino</option>';
						echo '<option value="f">Feminino</option>';
					if($pres['sexo'] == "f")
						echo '<option value="m">Masculino</option>';
						echo '<option value="f" selected>Feminino</option>';
				?>
				</select><br><br>
	RG*: <input type="text" name="rg" ID="rg" maxlength="10" required pattern="[0-9]{10}" title="Apenas números" placeholder="Apenas números" value="<?php echo $pres['rg'] ?>">       
	CPF*: <input type="text" name="cpf" ID="cpf" maxlength="11" required pattern="[0-9]{11)" title="Apenas números" placeholder="Apenas números" value="<?php echo $pres['cpf'] ?>"><br><br>
	Email: <input type="email" ID="email" name="email" placeholder="Digite seu email" value="<?php echo $pres['email'] ?>"><br><br>
	<?php
		if($table == "contratantes"){
			echo 'Número do Cartão*: <input type="text" ID="cartao" name="cartao" maxlength="20" placeholder="Digite o número do cartão" required pattern="[0-9]{20}" value="'.$pres['cartao'].'"> CVC*: <input type="text" ID="cvc" name="cvc" size="3" maxlength="3" placeholder="Ex: 123" value="'.$pres['cvc'].'"> <img src="img/bandeira-cartao.png" width="200" height="25"><br><br>';
		}
	?>
	Login*: <input type="text" ID="login" name="login" maxlength="60" placeholder="Digite o login" required value="<?php echo $pres['login'] ?>"> Senha*: <input type="password" ID="senha" name="senha" maxlength="8" placeholder="8 dígitos" value="<?php echo $pres['senha'] ?>"><br><br>
	<hr>
	<br><br>
	<div class="button-field" id="center">
		<button type="button" class="btn btn-secondary cadastro" name="cadastrar" onclick="document.location.href='admdashboard_<?php echo $pag ?>.php?tk=<?php echo $_GET['tk'] ?>'" style="background-color:red; color:white;">Cancelar</button>
		<button type="button" class="btn btn-secondary cadastro" name="cadastrar" onclick="atualizaDados(<?php echo $pres['id'] ?>, '<?php echo $table ?>', '<?php echo $_GET['tk'] ?>', '<?php echo $pag ?>')">Atualizar Dados</button>
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
	$("#rg").mask("99.999.999-99");
	$("#cpf").mask("999.999.999-99");
	$("#senha").mask("AAAAAAAA");
	$("#cvc").mask("999");
	$("#telefone").mask("(99) 99999-9999");
</script>
<script>
    const inputEle = document.getElementById('form');
    inputEle.addEventListener('keyup', function(e){
    var key = e.which || e.keyCode;
    if (key == 13) {
        atualizaDados(<?php echo $pres['id'] ?>, '<?php echo $table ?>', '<?php echo $_GET['tk'] ?>', '<?php echo $pag ?>');
    }
    });
</script>
</html>