<?php
session_start();
require_once 'conexao.php';

$id_anuncio = "";
$foto_caminho = "";
$remover_fotos = array();
$response = array();
$diretorio = "C:".DIRECTORY_SEPARATOR."xampp".DIRECTORY_SEPARATOR."htdocs".DIRECTORY_SEPARATOR."Projetos".DIRECTORY_SEPARATOR."Desapegados".DIRECTORY_SEPARATOR."assets";

if($_GET["id_anuncio"] != ""){
    $id_anuncio = htmlspecialchars($_GET["id_anuncio"],  ENT_QUOTES, 'UTF-8');
}

if($_GET["tipoAnuncio"] != ""){
    $tipo_anuncio = intval(htmlspecialchars($_GET["tipoAnuncio"],  ENT_QUOTES, 'UTF-8'));
}

if($_GET["usuarioAdm"] != ""){
    $usuario_adm = htmlspecialchars($_GET["usuarioAdm"],  ENT_QUOTES, 'UTF-8');
}

if($tipo_anuncio == 1){

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare("SELECT fotos_produto FROM produtos WHERE id_produto = ?");
    $stmt->bind_param("s", $id_anuncio);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        $remover_fotos = array_filter(explode(";", $result['fotos_produto']));
        $diretorio .= DIRECTORY_SEPARATOR."imagensAnunciosProdutos".DIRECTORY_SEPARATOR;

        foreach ($remover_fotos as $key => $nome_foto) {
            $foto_caminho .= $diretorio.$nome_foto;
            if(file_exists($foto_caminho)){
                unlink($foto_caminho);
                $foto_caminho = "";
            }
        }
    }

}else{

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare("SELECT fotos_servico FROM servicos WHERE id_servico = ?");
    $stmt->bind_param("s", $id_anuncio);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        $remover_fotos = array_filter(explode(";", $result['fotos_servico']));
        $diretorio .= DIRECTORY_SEPARATOR."imagensAnunciosServicos".DIRECTORY_SEPARATOR;

        foreach ($remover_fotos as $key => $nome_foto) {
            $foto_caminho .= $diretorio.$nome_foto;
            if(file_exists($foto_caminho)){
                unlink($foto_caminho);
                $foto_caminho = "";
            }
        }
    }
}

$conn->autocommit(FALSE);
$stmt = $conn->stmt_init();

if($tipo_anuncio == 1 && $usuario_adm == "false"){

    $sql = "DELETE FROM produtos WHERE id_produto = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id_anuncio, $_SESSION['id_usuario']);

}else if($tipo_anuncio == 2 && $usuario_adm == "false"){

    $sql = "DELETE FROM servicos WHERE id_servico = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id_anuncio, $_SESSION['id_usuario']);

}else if($tipo_anuncio == 1 && $usuario_adm == "true"){

    $sql = "DELETE FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_anuncio);

}else if($tipo_anuncio == 2 && $usuario_adm == "true"){

    $sql = "DELETE FROM servicos WHERE id_servico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_anuncio);
}

if ($stmt->execute()) {
    $conn->commit();
    $response['status']  = 'success';
    $response['message'] = "Anúncio deletado com sucesso.";
} else {
    $conn->rollback();
    $response['status']  = 'error';
    $response['message'] = "Erro ao deletar o anúncio: " . $stmt->error;
}

$conn->autocommit(TRUE);
$stmt->close();
$conn->close();

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