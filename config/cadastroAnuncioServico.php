<?php
session_start();
require_once 'conexao.php';

$fotoName = array();
$response = array();
$fotoType = array();
$fotoSize = array();
$fotoDimension = array();
$fotoTmpName = array();
$urlsImagem = array();
$continue = true;
$dataAtual = date('Y-m-d');
$fotosImagens = "";
$pastaDestino = "C:".DIRECTORY_SEPARATOR."xampp".DIRECTORY_SEPARATOR."htdocs".DIRECTORY_SEPARATOR."Projetos".DIRECTORY_SEPARATOR."Desapegados".DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."imagensAnunciosServicos".DIRECTORY_SEPARATOR;
$cont = 0;
$largura = 4928;
$altura = 3264;
$tamanho = 10000000;

if($_POST["nNomeAnuncioServico"] != ""){
    $nomeAnuncioServico = htmlspecialchars($_POST["nNomeAnuncioServico"], ENT_QUOTES, 'UTF-8');
}

if($_POST["nCategoriaServico"] != ""){
    $categoriaServico = htmlspecialchars($_POST["nCategoriaServico"], ENT_QUOTES, 'UTF-8');
}

if($_POST["nDuracaoServico"] != ""){
    $duracaoServico = preg_replace('/[^0-9]/', '', htmlspecialchars($_POST["nDuracaoServico"], ENT_QUOTES, 'UTF-8'));
}

if($_POST["nDescricaoAnuncioServico"] != ""){
    $descricaoAnuncioServico = htmlspecialchars($_POST["nDescricaoAnuncioServico"], ENT_QUOTES, 'UTF-8');
}

foreach($_FILES["nImagens"]["name"] as $i=> $name) {

    if (is_uploaded_file($_FILES['nImagens']['tmp_name'][$i])) {
        array_push($fotoName, basename($_FILES['nImagens']['name'][$i]));
        array_push($fotoType, $_FILES['nImagens']['type'][$i]);
        array_push($fotoSize, $_FILES['nImagens']['size'][$i]);
        array_push($fotoTmpName, $_FILES['nImagens']['tmp_name'][$i]);

    }else{
        $response['status']  = 'error';
        $response['message'] = "Por favor, cadastre pelo menos uma imagem para um novo anúncio de serviço.";
        $continue = false;
        break;
    }
    
}

if($continue){

    $extensoesPermitidas = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/svg", "image/webp");

    foreach($fotoType as $i => $type){

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fotoTmpName[$i]);

        if ((strpos($mime, 'image/') !== 0 || getimagesize($fotoTmpName[$i]) === false) && exif_imagetype($fotoName[$i]) === false) {
            $response['status']  = 'error';
            $response['message'] = "O arquivo enviado não é uma imagem";
            $continue = false;
            break;
        }  

        if($fotoType[$i] != "" && !in_array($fotoType[$i], $extensoesPermitidas)){
            $response['status']  = 'error';
            $response['message'] = "A imagem ".$fotoName[$i]." não está dentro dos formato permitido. Os formato permitidos são: JPEG, PNG, GIF, JPG, SVG ou WEBP.";
            $continue = false;
            break;
        }
    }

    if($continue){

        foreach($fotoName as $i => $name){

            array_push($fotoDimension, getimagesize($fotoTmpName[$i]));

            if($fotoDimension[$i][0] > $largura){
                $response['status']  = 'error';
                $response['message'] = "A largura da imagem ".$fotoName[$i]." não deve ultrapassar ".$largura." pixels";
                $continue = false;
                break; 
            }
            if($fotoDimension[$i][1] > $altura){
                $response['status']  = 'error';
                $response['message'] = "A altura da imagem ".$fotoName[$i]." não deve ultrapassar ".$altura." pixels";
                $continue = false;
                break;
            }
            if($fotoSize[$i] > $tamanho){
                $response['status']  = 'error';
                $response['message'] = "O tamanho da imagem ".$fotoName[$i]." não deve ultrapassar ".$tamanho." em bytes";
                $continue = false;
                break;
            }
        }

        if($continue){

            foreach($fotoName as $i => $name){

                $fotoName[$i] = md5($fotoName[$i].microtime()).'.'.pathinfo($fotoName[$i], PATHINFO_EXTENSION);
                $urlsImagem[$i] = $pastaDestino.$fotoName[$i];

                if(move_uploaded_file($fotoTmpName[$i], $urlsImagem[$i]) && is_dir($pastaDestino)){
                    $fotosImagens .= $fotoName[$i].";";
                    $cont++;
                }else{
                    $response['status']  = 'error';
                    $response['message'] = "Falha ao mover o arquivo carregado";
                    $continue = false;
                    break;
                }
                
            }

            if($cont > 0){

                $conn->autocommit(FALSE);
                $stmt = $conn->prepare("INSERT INTO servicos (nome_servico, descri_servico, fotos_servico, id_categoria_servico, duracao_servico, data_postagem, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssisss", $nomeAnuncioServico, $descricaoAnuncioServico, $fotosImagens, $categoriaServico, $duracaoServico, $dataAtual, $_SESSION['id_usuario']);

                if ($stmt->execute() && $stmt->affected_rows > 0) {
                    $conn->commit();
                    $response['status']  = 'success';
                    $response['message'] = "Cadastro do anúncio feito com sucesso!!";
                }else{
                    $conn->rollback();
                    $response['status']  = 'error';
                    $response['message'] = "Cadastro do anúncio não feito com sucesso...";
                }

                $conn->autocommit(TRUE);
            } 

            $stmt->close();
            $conn->close();
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);

/*

  /                 DESAPEGADOS                  \
  \ (SISTEMA PROTÓTIPO DE MARKETPLACE DE TROCAS) /

  - Programador do Sistema: Daniel Lacerda Ferreira de Souza  
  - Email do Programador: daniellacerdagtr@gmail.com 
  - Linkedln: https://www.linkedin.com/in/daniel-lacerda-16150b204/

  Direitos Autorais:

    O sistema é de domínio público. O download está liberado para quaisquer fins, incluindo atualizações ou outras modificações.
    Caso deseje referenciar o criador original do sistema, eu agradeço bastante sua cortesia.

  História do Sistema:

    A ideia do DESAPEGADOS teve início como um projeto em grupo durante minha graduação em Análise e Desenvolvimento de Sistemas no SENAI.
    Devido a outros projetos em andamento e à escassez de tempo, o projeto foi cancelado.
    No entanto, decidi retomar a ideia original de um sistema de Marketplace de Trocas por conta própria.
    O DESAPEGADOS, desenvolvido exclusivamente por mim, reutiliza muito pouco do código do sistema original elaborado na faculdade.
    Embora o sistema seja funcionalmente enxuto, meu objetivo com este projeto é mais voltado para a criação de um portfólio do que para a produção de um sistema em larga escala.

  Documentação do Sistema:

    Está exemplificado no arquivo PDF a documentação do sistema DESAPEGADOS.

  Possíveis Melhorias para Quem Quiser Atualizar Esse Sistema:

  - Criar um carrinho de anúncios tanto de produtos quanto de serviços do usuário.
  - Criar um sistema de favoritos para anúncios de produtos e serviços para o usuário.
  - Criar mais filtros no sistema em geral.

  Sinta-se à vontade para atualizar o sistema e realizar um git push na branch principal do repositório no GitHub, caso deseje.

  Atenciosamente,  
  Daniel Lacerda

*/

?>