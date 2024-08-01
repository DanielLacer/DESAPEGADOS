<?php
session_start();
require_once 'conexao.php';
    
$_SESSION['nivel_usuario'] = '';
$_SESSION['id_usuario'] = '';
$email = "";
$senha = "";

if($_POST["email"] != ""){
    $email = $_POST["email"];
}

if($_POST["senha"] != ""){
    $senha = $_POST["senha"];
}

$stmt = $conn->stmt_init();
$stmt = $conn->prepare("SELECT id_usuario, nome_usuario, telefone_usuario, email_usuario, senha_usuario, data_cadastro, estado_usuario, cidade_usuario, nivel_usuario, foto_usuario FROM usuarios WHERE email_usuario = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
        $result->data_seek($row_no);
        $row = $result->fetch_assoc();

        if(password_verify($senha, $row["senha_usuario"])){
            $_SESSION['nivel_usuario'] = $row["nivel_usuario"];
            $_SESSION['id_usuario'] = $row["id_usuario"];
            $_SESSION['foto_usuario'] = $row["foto_usuario"];
            echo "1"; //Sucesso
            $stmt->close();
            $conn->close();
            exit;
        }else{
            echo "2"; //Senha Incorreta
            $stmt->close();
            $conn->close();
            exit;
        }
    }

} else {
    echo "3"; //Email Incorreto
    $stmt->close();
    $conn->close();
    exit;
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