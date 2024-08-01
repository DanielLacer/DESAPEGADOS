<?php
session_start();
require_once('conexao.php');

$nome = "";
$email = "";
$nivel_usuario = "";
$telefone = "";
$estado = "";
$cidade = "";
$senha = "";
$senha_hash = null;
$usuarioAdm = 0;
$email_bancos = array();
$telefone_bancos = array();
$response = array();
$data_atual = date('Y-m-d');
$result = $conn->query("SELECT * FROM usuarios");

if($_POST["nNomeUsuario"] != ""){
    $nome = $_POST["nNomeUsuario"];
}

if($_POST["nEmail"] != ""){
    $email = strtolower($_POST["nEmail"]);
}

if($_POST["nNivelUsuario"] != ""){
    $nivel_usuario = intval($_POST["nNivelUsuario"]);
}

if($_POST["nTelefoneUsuario"] != ""){
    $telefone = $_POST["nTelefoneUsuario"];
}

if($_POST["nNomeEstadoUsuario"] != ""){
    $estado = $_POST["nNomeEstadoUsuario"];
}

if($_POST["nNomeCidadeUsuario"] != ""){
    $cidade = $_POST["nNomeCidadeUsuario"];
}

if($_POST["nSenhaUsuario"] != ""){
    $senha = $_POST["nSenhaUsuario"];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
}

if($_POST["nUsuarioAdm"] != ""){
    $usuarioAdm = intval($_POST["nUsuarioAdm"]);
}

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $email_bancos[] = strtolower($row['email_usuario']); 
        $telefone_bancos[] = strtolower($row['telefone_usuario']); 
    }

    if (in_array($email, $email_bancos)) {

        $response['status']  = 'error';
        $response['message'] = "O email inserido já existe no sistema. Por favor, insira um email diferente!";

    }else if(in_array($telefone, $telefone_bancos)){
        
        $response['status']  = 'error';
        $response['message'] = "O telefone inserido já existe no sistema. Por favor, insira um telefone diferente!";

    }else{

        $conn->autocommit(FALSE);
        $stmt = $conn->stmt_init();
        $sql = "INSERT INTO usuarios (nome_usuario, telefone_usuario, senha_usuario, email_usuario, estado_usuario, cidade_usuario, data_cadastro, nivel_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $nome, $telefone, $senha_hash, $email, $estado, $cidade, $data_atual, $nivel_usuario);
        $stmt->execute();

        $stmt = $conn->stmt_init();
        $stmt = $conn->prepare("SELECT id_usuario, nivel_usuario, senha_usuario FROM usuarios WHERE email_usuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if (password_verify($senha, $rows[0]['senha_usuario'])) {
            $conn->commit();
            $response['status']  = 'success';
            $response['message'] = "Cadastro do usuário feito com sucesso!";
        } else {
            $conn->rollback();
            $response['status']  = 'error';
            $response['message'] = "Erro ao cadastrar o usuário: " . $stmt->error;
        }

        $conn->autocommit(TRUE);
        $stmt->close();
        $conn->close();

        if($usuarioAdm == 0){
            $_SESSION['nivel_usuario'] = $rows[0]["nivel_usuario"];
            $_SESSION['id_usuario'] = $rows[0]["id_usuario"];
        }

    }

    header('Content-Type: application/json');
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