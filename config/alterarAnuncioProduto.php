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
$remover_fotos = array();
$continue = true;
$fotosImagens = "";
$foto_caminho = "";
$pastaDestino = "C:".DIRECTORY_SEPARATOR."xampp".DIRECTORY_SEPARATOR."htdocs".DIRECTORY_SEPARATOR."Projetos".DIRECTORY_SEPARATOR."Desapegados".DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."imagensAnunciosProdutos".DIRECTORY_SEPARATOR;
$cont = 0;
$largura = 4928;
$altura = 3264;
$tamanho = 10000000;

if($_POST["nNomeAnuncioProduto"] != ""){
    $nomeAnuncioProduto = htmlspecialchars($_POST["nNomeAnuncioProduto"], ENT_QUOTES, 'UTF-8');
}

if($_POST["nCategoriaProduto"] != ""){
    $categoriaProduto = intval(htmlspecialchars($_POST["nCategoriaProduto"], ENT_QUOTES, 'UTF-8'));
}

if($_POST["nQuantidadeProduto"] != ""){
    $quantidadeProduto = htmlspecialchars($_POST["nQuantidadeProduto"], ENT_QUOTES, 'UTF-8');
}

if($_POST["nDescricaoAnuncioProduto"] != ""){
    $descricaoAnuncioProduto = htmlspecialchars($_POST["nDescricaoAnuncioProduto"], ENT_QUOTES, 'UTF-8');
}

if($_POST["nIdAnuncioProduto"] != ""){
    $id_produto = htmlspecialchars($_POST["nIdAnuncioProduto"], ENT_QUOTES, 'UTF-8');
}

foreach($_FILES["nImagens"]["name"] as $i=> $name) {
    if (is_uploaded_file($_FILES['nImagens']['tmp_name'][$i])) {
        array_push($fotoName, basename($_FILES['nImagens']['name'][$i]));
        array_push($fotoType, $_FILES['nImagens']['type'][$i]);
        array_push($fotoSize, $_FILES['nImagens']['size'][$i]);
        array_push($fotoTmpName, $_FILES['nImagens']['tmp_name'][$i]);
    }   
}

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

        if(!empty($fotoName)){
            $stmt = $conn->stmt_init();
            $stmt = $conn->prepare("SELECT * FROM produtos WHERE id_produto = ?");
            $stmt->bind_param("i", $id_produto);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $result = $result->fetch_assoc();
                $remover_fotos = array_filter(explode(";", $result['fotos_produto']));

                foreach ($remover_fotos as $key => $nome_foto) {
                    $foto_caminho .= $pastaDestino.$nome_foto;
                    if(file_exists($foto_caminho)){
                        unlink($foto_caminho);
                        $foto_caminho = "";
                    }
                }
            }
        }

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

        if($cont > 0 || empty($fotoName)){

            $conn->autocommit(FALSE);

            if(empty($fotoName)){
                $stmt = $conn->prepare("UPDATE produtos SET nome_produto = ?, quantidade_produto = ?, descri_produto = ?, id_categoria_produto = ? WHERE id_produto = ? AND id_usuario = ?");
                $stmt->bind_param("sssiss", $nomeAnuncioProduto, $quantidadeProduto, $descricaoAnuncioProduto, $categoriaProduto, $id_produto, $_SESSION['id_usuario']);
            }else{
                $stmt = $conn->prepare("UPDATE produtos SET nome_produto = ?, quantidade_produto = ?, descri_produto = ?, id_categoria_produto = ?, fotos_produto = ? WHERE id_produto = ? AND id_usuario = ?");
                $stmt->bind_param("sssisss", $nomeAnuncioProduto, $quantidadeProduto, $descricaoAnuncioProduto, $categoriaProduto, $fotosImagens, $id_produto, $_SESSION['id_usuario']);
            }

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $conn->commit();
                $response['status']  = 'success';
                $response['message'] = "Alteração do anúncio feito com sucesso!!";
            }else{
                $conn->rollback();
                $response['status']  = 'error';
                $response['message'] = "Alteração do anúncio não feito com sucesso...";
            }
            
            $conn->autocommit(TRUE);
        } 

        $stmt->close();
        $conn->close();
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