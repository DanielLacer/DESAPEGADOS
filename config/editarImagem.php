<?php
session_start();
require_once('conexao.php');

if(isset($_FILES['nFotoPerfil'])) {

    $_SESSION['foto_usuario'] = '';
    $urlImagem = '';
    $nomeArquivo = $_FILES['nFotoPerfil']['name'];
    $tipoArquivo = $_FILES['nFotoPerfil']['type'];
    $tamanhoArquivo = $_FILES['nFotoPerfil']['size'];
    $diretorio = "C:".DIRECTORY_SEPARATOR."xampp".DIRECTORY_SEPARATOR."htdocs".DIRECTORY_SEPARATOR."Projetos".DIRECTORY_SEPARATOR."Desapegados".DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."imagensUsuarios".DIRECTORY_SEPARATOR;
    $idUsuario = intval($_GET['idUsuario']);
    $response = array();
    $remover_fotos = array();
    
    // Verifique se o arquivo é uma imagem
    $extensoesPermitidas = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/svg", "image/webp");

    if(in_array($tipoArquivo, $extensoesPermitidas)) {

        //Criptografando o nome da imagem no diretório destino
        $nomeArquivo = md5($nomeArquivo.microtime()).'.'.pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        // Definindo o diretório de destino para salvar a imagem
        $urlImagem = $diretorio.$nomeArquivo;

        // Move o arquivo do diretório temporário para o diretório de destino
        if(move_uploaded_file($_FILES['nFotoPerfil']['tmp_name'], $urlImagem)) {

            $stmt = $conn->stmt_init();
            $stmt = $conn->prepare("SELECT foto_usuario FROM usuarios WHERE id_usuario = ?");
            $stmt->bind_param("i", $idUsuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $result = $result->fetch_assoc();
                if($result['foto_usuario'] != null){
                    $remover_fotos = array_filter(explode(";", $result['foto_usuario']));
                    $urlImagem = '';
            
                    $urlImagem .= $diretorio.$remover_fotos[0];
                    if(file_exists($urlImagem)){
                        unlink($urlImagem);
                    }
                }
            }

            $stmt = $conn->stmt_init();
            $stmt = $conn->prepare("UPDATE usuarios SET foto_usuario = ? WHERE id_usuario = ?");
            $stmt->bind_param("si", $nomeArquivo, $idUsuario);

            if ($stmt->execute()) {
                $response['status']  = 'success';
                $response['message'] = 'Imagem do usuário atualizado!';
                $response['foto'] = $nomeArquivo;
                $_SESSION['foto_usuario'] = $nomeArquivo;
                $stmt->close();
                $conn->close();
            } else {
                $response['status']  = 'error';
                $response['message'] = 'Erro ao atualizar a imagem do usuário!';
                $stmt->close();
                $conn->close();
            }

        } else {
            $response['status']  = 'error';
            $response['message'] = 'Erro ao mover o arquivo para o diretório de destino!';
        }

    } else {
        $response['status']  = 'error';
        $response['message'] = 'Tipo de arquivo não permitido! Por favor envie uma imagem do formato: JPEG, PNG, GIF, JPG, WEBP ou SVG!';
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