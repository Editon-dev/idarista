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
    $tipo = 1;
    $status = 1;
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    try{
        $insere = $conn->prepare("INSERT INTO prestadoras (
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
            login,
            senha,
            tipo,
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
            :login,
            :senha,
            :tipo,
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
            ':login' => $login,
            ':senha' => $senha,
            ':tipo' => $tipo,
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