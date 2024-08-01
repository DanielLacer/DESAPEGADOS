<?php
require_once 'conexao.php';

$nova_categoria = "";
$categorias_servico_existente = array();
$response = array();
$result = $conn->query("SELECT nome_categoria FROM categorias_servico");

if($_GET["nova_categoria"] != ""){
    $nova_categoria = strtolower(htmlspecialchars($_GET["nova_categoria"],  ENT_QUOTES, 'UTF-8'));
}

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $categorias_servico_existente[] = strtolower($row['nome_categoria']); 
    }

    if (in_array($nova_categoria, $categorias_servico_existente)) {
   
        $response['status']  = 'error';
        $response['message'] = "A categoria inserido já existe no sistema";
    
    } else {
        
        $conn->autocommit(FALSE);
        $stmt = $conn->stmt_init();
        $stmt = $conn->prepare("INSERT INTO categorias_servico (nome_categoria) VALUES (?)");
        $stmt->bind_param("s", $nova_categoria);
    
        if ($stmt->execute()) {
    
            $conn->commit();
            $response['status']  = 'success';
            $response['message'] = "Categoria inserida com sucesso!";
        } else {
    
            $conn->rollback();
            $response['status']  = 'error';
            $response['message'] = "Erro ao inserir a categoria: " . $stmt->error;
        }
    
        $conn->autocommit(TRUE);

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