<?php
require_once('conexao.php');
header('Content-Type: application/json');

$nome = "";
$email = "";
$nivel_usuario = "";
$telefone = "";
$estado = "";
$cidade = "";
$senha = "";
$sql = "UPDATE usuarios SET";
$data_atual = date('Y-m-d');
$params = array();
$response = array();
$types = '';
$cont = 0;

if($_POST["nNomeUsuario"] != ""){

    $nome = $_POST["nNomeUsuario"];
    $sql .= " nome_usuario = ?";
    $params[] = &$nome; 
    $types .= 's';
    $cont++;
}

if($_POST["nEmail"] != ""){

    $email = $_POST["nEmail"];
    if($cont != 0){
        $sql .= ","; 
    }
    $sql .= " email_usuario = ?";
    $params[] = &$email; 
    $types .= 's';
    $cont++;
}

if($_POST["nTelefoneUsuario"] != ""){

    $telefone = $_POST["nTelefoneUsuario"];
    if($cont != 0){
        $sql .= ","; 
    }
    $sql .= " telefone_usuario = ?";
    $params[] = &$telefone; 
    $types .= 's';
    $cont++;
}

if($_POST["nNomeEstadoUsuario"] != ""){

    $estado = $_POST["nNomeEstadoUsuario"];
    if($cont != 0){
        $sql .= ","; 
    }
    $sql .= " estado_usuario = ?";
    $params[] = &$estado; 
    $types .= 's';
    $cont++;
}

if($_POST["nNomeCidadeUsuario"] != ""){

    $cidade = $_POST["nNomeCidadeUsuario"];
    if($cont != 0){
        $sql .= ",";
    }
    $sql .= " cidade_usuario = ?";
    $params[] = &$cidade;
    $types .= 's';
    $cont++;
}

if($_POST["nSenhaUsuario"] != ""){

    $senha = $_POST["nSenhaUsuario"];
    if($cont != 0){
        $sql .= ",";
    }
    $sql .= " senha_usuario = ?";
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $params[] = &$senha_hash;
    $types .= 's';
    $cont++;
}

if($cont > 0){

    $types .= 's';
    $sql .= " WHERE id_usuario = ?";
    $idUsuario = $_GET['idUsuario'];
    $params[] = &$idUsuario;
    array_unshift($params, $types);

    $conn->autocommit(FALSE);
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    call_user_func_array(array($stmt, 'bind_param'), $params);
    $stmt->execute();
    $conn->autocommit(TRUE);
    $stmt->close();
    $conn->close();
  
    $response['status']  = 'success';
    $response['message'] = "Informações do usuário alterado com sucesso!";
    echo json_encode($response);   

}else{

    $response['status']  = 'error';
    $response['message'] = "Não foi selecionado ou alterado nenhuma das informações do usuário. Por favor, insira as informações a serem alteradas!";
    echo json_encode($response);    
}

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