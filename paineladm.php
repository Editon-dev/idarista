<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/constants.css">
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/paineladm.css">
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

<div class="maincontainer">
	<div class="maincontainer-row">
		<div class="shadow-box">
			<img class="img-bigbox" src="img/exclamacao.png">
			<b><h1 id="title">Área de Usuários</h1></b>
			Essa área é de Usuários e de uso exclusivo para cadastrados.<br>
			Por favor se não for o seu caso sugerimos que volte para a página anterior,<br>
			caso tenha cadastro para acesso a essa área por favor entre com Login e Senha<br>
			no painel indicado.<br><br>
			<div class="button-field" id="exemplos">
				<button class="menu-button" style="margin-left:0px;" id="voltar" onclick="document.location.href='index.html'">Voltar para a Tela Inicial</button>
			</div>
		</div>
		<div class="shadow-box" id="box-shadow-login">
			<div class="login-paineladm-div">
				<img class="img-smallbox" src="img/Diarista_Logo_fundo.png"><br><br>
				<b><h1 id="title">Área de Login</h1></b>
				Acesse por aqui seu painel de usuário com suas credenciais e tenha acesso aos nossos serviços.<br>
				<div class="login-field" id="login-field">
					Login: <input type="text" name="login" id="login" autofocus>
					Senha: <input type="password" name="senha" id="senha">
					Tipo de Usuário: <select name="tipousuario" id="tipousuario">
						<option value="">Selecione</option>
						<option value="1">Prestador de Serviços</option>
						<option value="2">Contratante</option>
					</select>
					<div class="button-field" style="justify-content: center;">
						<button class="menu-button" id="entrar" style="margin-left:0px;" onclick="autenticaEntrada()">Entrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<script src="js/script_diarista.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/jquery-3.5.1.min.js"></script>
<script>
    const inputEle = document.getElementById('login-field');
    inputEle.addEventListener('keyup', function(e){
    var key = e.which || e.keyCode;
    if (key == 13) {
        autenticaEntrada();
    }
    });
</script>
</html>