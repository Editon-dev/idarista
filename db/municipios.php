<?php
    include_once('../dao/connection.php');

    $municipios = $conn->prepare("select * from `agenda`.`municipio` where Uf='".$_POST['id']."'");
    $municipios->execute();

    $fetchAll = $municipios->fetchAll();

    echo '<option value="">Selecione</option>';
    foreach ($fetchAll as $municipio){
        echo '<option value="'.$municipio['Nome'].'">'.$municipio['Nome'].'</option>';
    }
?>