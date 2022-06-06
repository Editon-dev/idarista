		function valida(dado){
			if (dado.value == "" || dado == ""){
				//alert ("O campo "+dado.name+" precisa ser preenchido!");
				return 0;
				}
			else{
			return 1;
			}
		}
		
		function validaNum(dado){
		var teste = /^[0-9]+$/;
			if (dado.value.match(teste)){
			return 1;
			}
			else{
				alert("O campo "+dado.name+" precisa ser numérico!");
				return 0;	
			}
		}
		
		function mudaPag(dado, tipo){
			if (dado.value == "cont_normal"){
				document.getElementById("frame").src = "regras_"+tipo+"_normal.html";
				$("#frame").css({'display':'block'});
			}
			else{
				if (dado.value = "cont_contribuinte"){
					document.getElementById("frame").src = "regras_"+tipo+"_contribuinte.html";
					$("#frame").css({'display':'block'});
				}
				else{
					document.getElementById("frame").src = "";
					$("#frame").css({'display':'none'});
				}
			}
		}
			
		function validaNumRequired(dado){
			var passed = 0;
			if (dado.value == "" || dado == ""){
				//alert ("O campo "+dado.name+" precisa ser preenchido!");
				return 0;
				}
			else{
			passed = validaNum(dado);
			return passed;
			
			}
		}
		
		function mudaChecked(dado){
			if (dado==""){
				dado = "checked-ok";
				document.getElementById("aceita-termos").value = dado;
			}
			else{
				dado = "";
				document.getElementById("aceita-termos").value = dado;
			}
		}
		
		function validaTermos(dado){
			if (dado!="checked-ok"){
				alert ("Você precisa aceitar os termos antes de concluir o cadastro.");
				return 0;
				}
			else{
				return 1;
			}
		}
		
		function validaTermos2 (){
			var passed = 0;
			dado = document.getElementById("aceita-termos").value;
			passed = validaTermos(dado);
			return passed;
		}
		
		function emDesenvolvimento(){
			alert ("Em Desenvolvimento...");
		}
		
		function validaAll(){
			var cont = 0;
			var passed = 0;
			dado = document.getElementById("nome");
			cont ++;
			passed = valida(dado);
			dado = document.getElementById("endereco");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("telefone");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("cidade");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("estado");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("rg");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("cpf");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("email");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("login");
			cont ++;
			passed += valida(dado);
			dado = document.getElementById("senha");
			cont ++;
			passed += valida(dado);
			if (document.getElementById("form").name == "form-contratante"){
				dado = document.getElementById("cartao");
				cont ++;
				passed += valida(dado);
				dado = document.getElementById("cvc");
				cont ++;
				passed += valida(dado);
				cont ++;
				passed += validaTermos2(dado);
			}
			else{
			cont ++;
			passed += validaTermos2(dado);
			}
			if (cont == passed){
				if(document.getElementById("form").name == "form-contratante")
					cadastraContratante();
				if(document.getElementById("form").name == "form-prestadora")
					cadastraPrestadora();
				//alert ("Cadastro efetuado com sucesso!");
			}
			else
				alert ("Não foi possivel efetuar o cadastro, por favor verifique os campos obrigatórios!");
			
		}

		function cadastraContratante() {
			confirmacao = confirm("Deseja realmente realizar esse registro?");
			if(confirmacao == true){
				var fd = new FormData(form);
				$.ajax({
					url: 'db/criacontratante.php',
					data: fd,
					type: 'POST',
					processData: false,
					contentType: false,
					success: function (data) {
						if(!isNaN(data) && data > 0){
							alert("Registrado com sucesso!");
							document.location.reload(true);
						}
						else{
							alert(data);
						}
					},
				});
			}
		}

		function cadastraPrestadora() {
			confirmacao = confirm("Deseja realmente realizar esse registro?");
			if(confirmacao == true){
				var fd = new FormData(form);
				$.ajax({
					url: 'db/criaprestadora.php',
					data: fd,
					type: 'POST',
					processData: false,
					contentType: false,
					success: function (data) {
						if(!isNaN(data) && data > 0){
							alert("Registrado com sucesso!");
							document.location.reload(true);
						}
						else{
							alert(data);
						}
					},
				});
			}
		}

		function atualizaDados(id, table, token, pag) {
			confirmacao = confirm("Deseja realmente atualizar esse registro?");
			if(confirmacao == true){
				var fd = new FormData(form);
				fd.append('id', id);
				fd.append('table', table);
				$.ajax({
					url: 'db/atualizadados.php',
					data: fd,
					type: 'POST',
					processData: false,
					contentType: false,
					success: function (data) {
						if(!isNaN(data)){
							alert("Dados atualizados com sucesso!");
							document.location.href='admdashboard_'+pag+'.php?tk='+token;
						}
						else{
							alert(data);
						}
					},
				});
			}
		}

		function autenticaEntrada() {
			login = document.getElementById("login").value;
			senha = document.getElementById("senha").value;
			tipousuario = document.getElementById("tipousuario").value;
			num = (valida(login) + valida(senha) + valida(tipousuario)) /3;
			if ((num == 1)){
				$.ajax({
					url: 'db/autenticador.php',
					data: {login:login, senha:senha, tipousuario:tipousuario}, 
					type: 'POST',
					success: function(data){
						if(data>0){
							alert ("Login e senha corretos. Carregando sistema!");
							var token = data;
							$.ajax({
							url: 'db/geratokenadm.php',
							data: {id:token, tipousuario:tipousuario},
							type: 'POST',
							success: function(data){
								alert("Por favor, durante o uso do sistema evite clicar no botão voltar ou fechar a janela sem finalizar a sessão clicando no botão sair do menu superior.");
								document.location.href = data;
							}
							});
						}
						else{
							alert ("Login, senha ou tipo de usuário incorretos!");
						}
					}
				});
			}
			else    
				alert("Por favor preencha os campos vazios!");
		}

		function pegaCidades() {
			var idEstado = document.getElementById("estado").value;
			$.ajax({
				url: 'db/municipios.php',
				type: 'POST',
				data: {id:idEstado},
				success: function(data){
					$("#cidade").html(data);
				},
			})
		}

		function pegaDiaristas(dado, idcon, status) {
			var cidade = dado.value;
			$.ajax({
				url: 'db/pegadiaristas.php',
				type: 'POST',
				data: {cidade:cidade, idcon:idcon, status:status},
				success: function(data){
					$(".listadiaristas").html(data);
				},
			})
		}

		function criaContrato(idpre, idcon, status) {
			if(status == "1"){
				confirmacao = confirm("Deseja realmente contratar esse serviço? Confira todos os dados antes de continuar.");
				if(confirmacao == true){
					detalhe = document.getElementById("detalhe").value;
					data = document.getElementById("data").value;
					if(detalhe != ""){
						$.ajax({
							url: 'db/criacontrato.php',
							data: {idpre:idpre, idcon:idcon, detalhe:detalhe, data:data},
							type: 'POST',
							success: function (data) {
								if(!isNaN(data)){
									alert("Diarista contratada com sucesso!");
									document.location.reload(true);
								}
								else{
									alert(data);
								}
							},
						});
					}
					else{
						alert("Por favor preencha os campos vazios!");
					}
				}
			}
			else{
				alert("Você não pode contratar uma diarista com um contrato em aberto vinculado a você!");
			}
		}

		function cancelarContrato(idcontrato, idpre, idcon) {
			confirmacao = confirm("Deseja realmente cancelar esse contrato de serviço? Recomendamos que entre em contato com a prestadora antes.");
			if(confirmacao == true){
				$.ajax({
					url: 'db/cancelacontrato.php',
					data: {idpre:idpre, idcon:idcon, idcontrato:idcontrato},
					type: 'POST',
					success: function (data) {
						if(!isNaN(data)){
							alert("Serviço cancelado com sucesso!");
							document.location.reload(true);
						}
						else{
							alert(data);
						}
					},
				});
			}
		}

		function removeDado(id, tipo) {
			confirmacao = confirm("Deseja realmente remover a sua conta? Todos os seus dados serão removidos do sistema e essa ação não pode ser desfeita.");
			if(confirmacao == true){
				$.ajax({
					url: 'db/remove'+tipo+'.php',
					data: {id:id},
					type: 'POST',
					success: function (data) {
						if(!isNaN(data)){
							alert("Conta removida com sucesso! Esperamos que volte.");
							document.location.reload(true);
						}
						else{
							alert(data);
						}
					},
				});
			}
		}
		
		function exitDashboard(dado, tipo) {
			var id = dado.value;
			$.ajax({
				url: 'db/limpatoken.php',
				type: 'POST',
				data: {id:id, tipo:tipo},
				success: function(data){
					if(data == "1"){
						alert("Sessão no sistema finalizada!");
						window.location.href = 'paineladm.php';
					}
					else{
						alert("Falha ao fechar sessão!");
					}
				},
			});
		}

		function aceitaContrato(idpre, idcon, idcontrato) {
			confirmacao = confirm("Deseja realmente aceitar esse contrato de serviço?");
			if(confirmacao == true){
				$.ajax({
					url: 'db/aceitacontrato.php',
					data: {idpre:idpre, idcon:idcon, idcontrato:idcontrato},
					type: 'POST',
					success: function (data) {
						if(!isNaN(data)){
							alert("Serviço aceito com sucesso! Entre em contato com o contratante para ter mais detalhes.");
							document.location.reload(true);
						}
						else{
							alert(data);
						}
					},
				});
			}
		}