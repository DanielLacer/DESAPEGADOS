<?php
require_once 'conexao.php';

$id_usuario_nivel = "";
$novo_nivel = "";
$response = array();

if($_GET["id_usuario_nivel"] != ""){
    $id_usuario_nivel = htmlspecialchars($_GET["id_usuario_nivel"],  ENT_QUOTES, 'UTF-8');
}

if($_GET["novo_nivel"] != ""){
    $novo_nivel = htmlspecialchars($_GET["novo_nivel"],  ENT_QUOTES, 'UTF-8');
}

$conn->autocommit(FALSE);
$stmt = $conn->stmt_init();
$stmt = $conn->prepare("UPDATE usuarios SET nivel_usuario = ? WHERE id_usuario = ?");
$stmt->bind_param("ss", $novo_nivel, $id_usuario_nivel);

if ($stmt->execute()) {
    $conn->commit();
    $response['status']  = 'success';
    $response['message'] = "Nível do usuário alterado com sucesso.";
} else {
    $conn->rollback();
    $response['status']  = 'error';
    $response['message'] = "Erro ao alterar o nível do usuário: " . $stmt->error;
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