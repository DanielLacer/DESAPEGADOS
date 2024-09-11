<?php
ini_set('display_errors', 0);
session_start();
require '../../config/conexao.php';
$_GET['tipoAnuncio'] = 0;

?>

<!doctype html>
<html lang="PT-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/styles/pagesPerfil/loginPerfil.css">
    <link rel="stylesheet" href="../../assets/styles/headerLogado.css">
    <link rel="stylesheet" href="../../assets/styles/headerDeslogado.css">
  </head>

  <body>
    <header>
        <?php
          
          if(isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] != ""){
            include_once '../../components/headerLogado.php'; 
          }else{
            include_once '../../components/headerDeslogado.php';
          }

        ?>
    </header>
    <section class="section m-0 p-4 d-flex justify-content-center align-items-center col-sm-12 d-flex flex-column">
      <div class="container col-sm-10 d-flex flex-row justify-content-center align-items-center" style="height: 400px">
        <div class="containerUnico col-sm-4 d-flex flex-column h-100 justify-content-center align-items-center">
          <form class="col-sm-10 d-flex flex-column justify-content-between align-items-center pb-5 pt-5" style="height: 100%">
              <div class="row col-12">
                  <div class="tituloPerfil d-flex justify-content-center col-sm-12">
                      <h4 class="font-weight-normal">LOGAR</h4>
                  </div>
              </div>
              <div class="row col-12 mt-2">
                  <div class="Email">
                      <div class="label d-flex justify-content-center align-items-center"><label for="iEmail">Email:</label></div>
                      <input class="form-control" type="text" placeholder="Seu email..." id="iEmail" name="nEmail" value="">
                  </div>
              </div>
              <div class="row col-12 mb-2">
                  <div class="senha">
                      <div class="label d-flex justify-content-center align-items-center"><label for="iSenha">Senha:</label></div>
                      <input class="form-control" type="password" placeholder="Sua senha..." id="iSenha" name="nSenha" value="">
                  </div>
              </div>
              <div class="row col-12">
                  <div class="form-floating d-flex justify-content-center align-items-center col-12">
                    <button type="button" class="btn  col-12 rounded-0" onclick="autenticar();"><p class="fs-9 m-0 text-white logar">LOGAR</p></button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </section>
  </body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    function autenticar() {
      const email = $('#iEmail').val();
      const senha = $('#iSenha').val();
      if (email != '' || password != '') {
        $.ajax({
            method: "POST",
            url: "../../config/loginUsuario.php",
            dataType: "json",
            data: {
                email: email,
                senha: senha
            },
            beforeSend: function() {
              $(".logar").html("Logando...");
            },
            success: function(response) {
              if (response == 3) {
                Swal.fire({
                    icon: 'error',
                    title: 'Eita...😬',
                    text: 'Email incorreto ou não preenchido!',
                })
                $(".logar").html("LOGIN");
              } else if (response == 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Eita...😬',
                    text: 'Senha incorreto ou não preenchido!',
                })
                $(".logar").html("LOGIN");
              }else if (response == 1) {
                window.location.href = "perfilUsuario.php?logado=1";
              }
            }
        })
      } else {
          alert('Preencha todos os campos!')
      }
    }
  </script>

</html>

<!--

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

-->