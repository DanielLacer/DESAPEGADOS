<?php
ini_set('display_errors', 0);
require '../../config/conexao.php';
require '../../config/consultasGerais.php';
$_GET['tipoAnuncio'] = 0;

if((isset($_GET['logado']) && $_GET['logado'] == 1) || isset($_SESSION['id_usuario'])){
    
  $dadosUsuario = carregarDadosUsuario($conn);

  $dataCadastro    = new DateTime($dadosUsuario['data_cadastro']);
  $dataAtual       = new DateTime();
  $intervalo       = $dataCadastro->diff($dataAtual);

  if($intervalo->d == 1){
    $tempoCadastrado = $intervalo->d.' - dia';
  }else{
    $tempoCadastrado = $intervalo->d.' - dias';
  }

}
?>

<!doctype html>
<html lang="PT-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DESAPEGADOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/styles/pagesPerfil/perfilUsuario.css">
    <link rel="stylesheet" href="../../assets/styles/headerLogado.css">
    <link rel="stylesheet" href="../../assets/styles/headerDeslogado.css">
  </head>
  <header>   
  <?php
  
    if(isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] != ""){
      include_once '../../components/headerLogado.php'; 
    }else{
      include_once '../../components/headerDeslogado.php';
    }
    
  ?>
  </header>
  <body>
    <section class="section m-0 p-4 d-flex justify-content-center align-items-center col-sm-12 d-flex flex-column">
      <div class="tituloPerfil d-flex justify-content-center col-sm-12">
        <h4>TELA PERFIL</h4>
      </div>
      <div class="container col-sm-10 mt-3 d-flex flex-row" style="height: 480px">
        <div class="containerEsquerda col-sm-4 h-100 d-flex flex-column justify-content-center align-items-center"> 
          <?php 
            if($_SESSION['id_usuario'] != "" && isset($_SESSION['foto_usuario'])){
              ?><label for="ifotoperfil"><img src="../../assets/imagensUsuarios/<?php echo $_SESSION['foto_usuario']?>" width="100px" height="100px" id="ImagemUsuario"></label><?php
            }else{
              ?><label for="ifotoperfil"><img src="../../assets/imagens_padrao/contaHeader.png" width="100px" height="100px" id="ImagemUsuario"></label><?php
            }
          ?>   
        </div>
        <div class="containerDireita col-sm-8 d-flex flex-column h-100 justify-content-center align-items-center">
          <div class="containerInformacoesUsuario col-sm-11 d-flex justify-content-between align-items-center" style="height: 75%">
            <div class="coluna col-sm-3 d-flex flex-column">
                <div class="Nome">
                  <div class="label d-flex justify-content-center align-items-center"><label class="fs-8" for="tituloProduto">Nome:</label></div>
                  <p class="text-center"><?php echo $dadosUsuario["nome_usuario"] ?></p>
                </div>
                <div class="Email mt-5">
                  <div class="label d-flex justify-content-center align-items-center"><label class="fs-8" for="tituloProduto">Email:</label></div>
                  <p class="text-center"><?php echo $dadosUsuario["email_usuario"] ?></p>
                </div>
            </div>
            <div class="coluna col-sm-3 d-flex flex-column">
                <div class="Localidade">
                  <div class="label d-flex justify-content-center align-items-center"><label class="fs-8" for="tituloProduto">Localidade:</label></div>
                  <p class="text-center"><?php echo $dadosUsuario["estado_usuario"] ?> - <?php echo $dadosUsuario["cidade_usuario"] ?></p>
                </div>
                <div class="tempoCadastrado mt-5">
                  <div class="label d-flex justify-content-center align-items-center"><label class="fs-8" for="tituloProduto">Tempo Cadastrado:</label></div>
                  <p class="text-center"><?php echo $tempoCadastrado ?></p>
                </div>
            </div>
            <div class="coluna col-sm-3 d-flex flex-column" style="height: 176px">
                <div class="telefone">
                  <div class="label d-flex justify-content-center align-items-center"><label class="fs-8" for="tituloProduto">Telefone:</label></div>
                  <p class="text-center"><?php echo $dadosUsuario["telefone_usuario"] ?></p>
                </div>
            </div>  
          </div>
          <div class="linha col-sm-11 bg-success" style="height: 0.5%"></div>
            <div class="acoesPerfil col-sm-11 d-flex flex-row justify-content-center align-items-center flex-nowrap ps-3 pe-3" style="height: 24.5%">
              <button class="btn btn-success  editarPerfil me-1 ms-1 col-4" onclick="window.location.href='editarPerfil.php'"><p class="m-0 fs-7">Editar Perfil</p></button>
              <button class="btn btn-success  cadastrarAnuncioServico me-1 ms-1 col-4" onclick="window.location.href='meusAnuncios.php?tipoAnuncio=1'" ><p class="m-0 fs-7">Meus Anúncios</p></button>
              
              <?php 
                if($_SESSION['nivel_usuario'] == 2){
                  ?><button class="btn btn-info  cadastrarAnuncioServico me-1 ms-1 col-4" onclick="window.location.href='areaAdm.php?tipoAnuncio=1'" ><p class="m-0 fs-7">AREA ADM</p></button><?php
                }
              ?>  
            </div>
        </div>
      </div>
    </section>
  </body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

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


