<?php
    require_once '../dao/connection.php';

    $nome = $_POST['nome'];
    $nascimento = $_POST['nascimento'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $sexo = $_POST['sexo'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $cartao = $_POST['cartao'];
    $cvc = $_POST['cvc'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $status = 1;

    try{
        $insere = $conn->prepare("INSERT INTO contratantes (
            nome,
            nascimento,
            endereco,
            telefone,
            cidade,
            estado,
            sexo,
            rg,
            cpf,
            email,
            cartao,
            cvc,
            login,
            senha,
            status
        )
        VALUES(
            :nome,
            :nascimento,
            :endereco,
            :telefone,
            :cidade,
            :estado,
            :sexo,
            :rg,
            :cpf,
            :email,
            :cartao,
            :cvc,
            :login,
            :senha,
            :status
        );");
        $insere->execute(array(
            ':nome' => $nome,
            ':nascimento' => $nascimento,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':sexo' => $sexo,
            ':rg' => $rg,
            ':cpf' => $cpf,
            ':email' => $email,
            ':cartao' => $cartao,
            ':cvc' => $cvc,
            ':login' => $login,
            ':senha' => $senha,
            ':status' => $status
        ));
        echo $insere->rowCount();
        $conn = null;
    }
    catch(PDOException $e){
        $e->getMessage();
        $conn = null;
    }

?>