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

		$selectestados = $conn->prepare("SELECT * FROM `agenda`.`estados` ORDER BY Nome");
		$selectestados->execute();
		if($selectestados->rowCount()>0){
			$estados = $selectestados->fetchALL();
		}

		$selecttipoprestadoras = $conn->prepare("SELECT * FROM tipoprestadoras");
		$selecttipoprestadoras->execute();
		if($selecttipoprestadoras->rowCount()>0){
			$tipoprestadoras = $selecttipoprestadoras->fetchALL();
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
            <li class="nav-item active">
              <a class="nav-link" href="index.html">Inicio</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="index.html#pop-up">Quem Somos</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="form_contratante.php">Seja um Contratante</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="form_prestadora.php">Seja uma Prestadora</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="paineladm.php">Painel de Usuário</a>
            </li>
          </ul>
        </div>
      </nav> 
</header>

<div class="container">
	<form name="form-prestadora" id="form" class="margem-contratante" method="post">
	<h1>FORMULARIO DE PRESTADORA</h1><hr><br>
	Nome Completo*: <input type="text" name="nome" ID="nome" maxlength="200" autofocus="1" required><br><br>
	Data de Nascimento*: <input type="date" ID="nascimento" name="nascimento" value=""> <br><br>
	<div style="display:flex; align-items:center;">Endereço*: <input type="text" name="endereco" ID="endereco" maxlength="120" required placeholder="Ou use o GPS" style="margin-left:10px;"> <div class="normal-button" name="gps" ID="gps" onclick="emDesenvolvimento()" style="margin-left:10px;">USAR GPS</div></div><br>
	Telefone*: <input type="tel" ID="telefone" name="telefone" value="" maxlength="11" required pattern="\[0-9]{2}-\[0-9]{5}-[0-9]{4}$" placeholder="Digite seu telefone"><br><br>
	Estado*: <select name="estado" ID="estado" onchange="pegaCidades()">
				<option value="">Selecione</option>
				<?php
					if(isset($estados)){
						foreach($estados as $est){
							echo '<option value="'.$est['Uf'].'">'.$est['Nome'].'</option>';
						}
					}
				?>
			</select> 
	Cidade*: <select name="cidade" id="cidade" style="width: 270px;">
										<option value=""></option>
									</select><br><br>
	Sexo: <select class="" name="sexo" ID="sexo" placeholder="Selecione">
				<option value="">Selecione</option>
				<option value="m">Masculino</option>
				<option value="f">Feminino</option>
				</select>
	Nível: <select class="" name="nivel" ID="nivel" placeholder="Selecione">
				<?php
					if(isset($tipoprestadoras)){
						foreach($tipoprestadoras as $prest){
							if($prest['id'] == "1")
								echo '<option value="'.$prest['Id'].'">'.$prest['nome'].'</option>';
						}
					}
				?>
				</select><br><br>
	RG*: <input type="text" name="rg" ID="rg" maxlength="10" required pattern="[0-9]{10}" title="Apenas números" placeholder="Apenas números">       
	CPF*: <input type="text" name="cpf" ID="cpf" maxlength="11" required pattern="[0-9]{11)" title="Apenas números" placeholder="Apenas números"><br><br>
	Email: <input type="email" ID="email" name="email" placeholder="Digite seu email"><br><br>
	Login*: <input type="text" ID="login" name="login" maxlength="60" placeholder="Digite o login" required> Senha*: <input type="password" ID="senha" name="senha" maxlength="8" placeholder="8 dígitos"><br><br>
	<hr>
	Escolha o tipo de prestadora*: <br><br>
	<div class="radio-row">
	<input type="radio" name="regras" ID="regras" value="cont_normal" onclick="mudaPag(this, 'prest')"><div>Regras Contratante Normal</div> <input type="radio" name="regras" ID="regras" value="cont_contribuinte" onclick="mudaPag(this, 'prest')"><div>Regras Contratante Contribuinte</div><br><br>
	</div>
	<br><p align=center><iframe src="" name="iframes" ID="frame" width="500" height="500" frameborder="0" style="display:none;"></iframe>
	<div class="radio-row">
	<br><input type="checkbox" ID="aceita-termos" name="aceita-termos" value="" onclick="mudaChecked(this.value)"> <div>Lí e aceito os termos de uso do serviço.</div></p>
	</div>
	<br><br>
	<div class="button-field" id="center">
		<button type="button" class="btn btn-secondary cadastro" name="cadastrar" onclick="validaAll()">Cadastrar</button>
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
</html>