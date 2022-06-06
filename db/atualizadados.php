<?php
    require_once '../dao/connection.php';

    $id = $_POST['id'];
    $table = $_POST['table'];
    if($table == "contratantes"){
        $cartaoquery = "
        cartao = ".$_POST['cartao'].",
        cvc = ".$_POST['cvc'].",
        ";
    }
    else{
        $cartaoquery = "";
    }

    $pass = 'ok';
    foreach($_POST as $key=>$value){
        if($value == ''){
            $pass = 'none';
        }
    }

    if($pass != 'none'){
        try{
            $atualiza = $conn->prepare("UPDATE ".$table." SET
                nome = '".$_POST['nome']."',
                nascimento = '".$_POST['nascimento']."',
                endereco = '".$_POST['endereco']."',
                telefone = '".$_POST['telefone']."',
                cidade = '".$_POST['cidade']."',
                estado = '".$_POST['estado']."',
                sexo = '".$_POST['sexo']."',
                rg = '".$_POST['rg']."',
                cpf = '".$_POST['cpf']."',
                email = '".$_POST['email']."',
                ".$cartaoquery."
                login = '".$_POST['login']."',
                senha = '".$_POST['senha']."'
            WHERE id = ".$id.";");
            $atualiza->execute();

            $conn = null;

            echo 1;
        }
        catch(PDOException $e){
            $e->getMessage();
            $conn = null;
        }
    }
    else{
        die("Por favor preencha todos os campos!");
    }

?>