<?php
    include_once('../dao/connection.php');

    $diaristas = $conn->prepare("select p.*, p.id idprestadora, tp.nome nometipo, tp.valor from prestadoras p, tipoprestadoras tp where p.cidade='".$_POST['cidade']."' AND tp.id = p.tipo AND p.status = 1");
    $diaristas->execute();
    if($diaristas->rowCount()>0){
        $fetchAll = $diaristas->fetchAll();
    }

    if(isset($fetchAll)){
        $count = 1;
        echo '<div class="listadiaristas-row">';
        $collapsecount = 1;
        foreach ($fetchAll as $diarista){
            $feedbacks = $conn->prepare("SELECT *, DATE_FORMAT(data, '%d/%m/%Y') datafeedback FROM feedbacks WHERE idprestadora = ".$diarista['idprestadora']." ORDER BY data DESC");
            $feedbacks->execute();
            if($feedbacks->rowCount()>0){
                $feedback = $feedbacks->fetchAll();
            }
            $pontos = $conn->prepare("SELECT count(id) pontos FROM feedbacks WHERE idprestadora = ".$diarista['idprestadora']." AND tipo = 'Positiva'");
            $pontos->execute();
            if($pontos->rowCount()>0){
                $ponto = $pontos->fetch();
                $letra = $ponto < 2 ? '' : 's';

            }

            $sexo = $diarista['sexo'] == "f" ? 'Feminino' : 'Masculino';
            echo '<div class="listadiaristas-dados">';
            echo '<div class="listadiaristas-dados-row">';
            echo '<div class="listadiaristas-dados" style="box-shadow: none; max-width: none; width:100%;">';
            echo '   Nome: '.$diarista['nome'].' ('.$ponto['pontos'].' Ponto'.$letra.')<br>';
            echo '   Endereço: '.$diarista['endereco'].'<br>';
            echo '   Nascimento: '.$diarista['nascimento'].'<br>';
            echo '   Sexo: '.$sexo.'<br>';
            echo '   Nível: '.$diarista['nometipo'].'<br><br>';
            echo '   <div style="display:flex; flex-direction:row;">Valor:<div style="color:forestgreen; font-weight:bold; white-space: break-spaces;"> '.$diarista['valor'].'</div></div>';

            if($feedbacks->rowCount()>0){
                echo '<button class="btn btn-primary" id="collapse-feedback" type="button" data-toggle="collapse" data-target="#collapsefeedback'.$collapsecount.'" aria-expanded="false" aria-controls="collapsefeedback'.$collapsecount.'">';
                echo '    <img src="img/seta_down.png" alt="seta_down"> Feedbacks ';
                echo '</button>';
                echo '<div class="collapse" id="collapsefeedback'.$collapsecount.'">';
                echo '  <div style="overflow: auto; max-height: 100px;">';
                foreach($feedback as $fb){
                    if($fb['tipo'] == "Positiva"){
                        $icon = '<img src="img/positivo.png" alt="positivo" style="width:20px;">';
                    }
                    else{
                        $icon = '<img src="img/negativo.png" alt="negativo" style="width:20px;">';
                    }
                    echo '      <div id="feedback-div">';
                            echo '   <b>Feedback de '.$fb['contratante'].' '.$icon.'</b><br>';
                            echo $fb['detalhe'].'<br>';
                            echo '   Data: '.$fb['datafeedback'].'<br>';
                    echo '      </div>';
                }
                echo '  </div>';
                echo '</div>';
                $collapsecount++;
            }

            echo '</div>';
            echo '<img class="foto" src="img/prestadoras/exemplo/foto.png">';
            echo '</div>';
            echo '<button class="normal-button" onclick="criaContrato(\''.$diarista['id'].'\', \''.$_POST['idcon'].'\', \''.$_POST['status'].'\')">Contratar</button>';
            echo '</div>';
            if($count == 2){
                echo '</div>';
                echo '<div class="listadiaristas-row">';
                $count = 0;
            }
            $count++;
        }
        echo '</div>';
    }
    else{
        echo 'Não foram encontradas Diaristas nessa localidade aproximada!';
    }
?>