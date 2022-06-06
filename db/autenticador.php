<?php
        include_once('../dao/connection.php');

        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $tipousuario = $_POST['tipousuario'];

        try{
            if($tipousuario == "1")
                $queryUsuarios = "select id from prestadoras where login = '".$login."' and senha ='".$senha."' LIMIT 1;";
            if($tipousuario == "2")
                $queryUsuarios = "select id from contratantes where login = '".$login."' and senha ='".$senha."' LIMIT 1;";

            $sqlUsuarios = $conn->prepare($queryUsuarios);
            $sqlUsuarios->execute();
            $result = $sqlUsuarios->rowCount();
            if($result>0){
                $autent = $sqlUsuarios->fetchALL(PDO::FETCH_ASSOC);
                foreach($autent as $at){}
                echo ($at['id']);
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
?>