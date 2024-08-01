<?php
ini_set('display_errors', 0);
session_start();
require '../config/conexao.php';
require '../config/consultasGerais.php';
$_GET['tipoAnuncio'] = 0;

if(isset($_GET['id_produto'])){
    
  $dadosAnuncio = carregarAnuncioProduto($conn, $_GET['id_produto'], true);

}

?>

<!doctype html>
<html lang="PT-BR">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DESAPEGADOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/styles/exibirAnuncioProduto.css">
    <link rel="stylesheet" href="../assets/styles/headerLogado.css">
    <link rel="stylesheet" href="../assets/styles/headerDeslogado.css">
  </head>
  <body>
    <header>
      
      <?php
        
        if(isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] != ""){
          include_once '../components/headerLogado.php'; 
        }else{
          include_once '../components/headerDeslogado.php';
        }
        
      ?>

    </header>
    <section class="section m-0 p-4 d-flex justify-content-center align-items-center col-sm-12 d-flex flex-column">
      <div class="tituloPerfil d-flex justify-content-center col-sm-12">
        <h4>ANÚNCIO DO PRODUTO</h4>
      </div>
      <div class="container col-10 mt-3 d-flex" style="height: 480px">
        <form id="formCadastroAnuncio" method="POST" action="" class="d-flex col-12">
          <div class="containerEsquerda col-4 h-100 d-flex flex-column justify-content-center align-items-center p-4"> 
            <div class="divPreviewImagens">
              <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>  
            </div>
          </div>
          <div class="containerDireita col-8 d-flex flex-column h-100 justify-content-between align-items-center ps-3 pe-3 p-4">
            <div class="row col-12">
              <div class="tituloAnuncio d-flex justify-content-center align-items-center col-12">
                <input type="text" class="form-control text-center disabledBackground" id="iNomeAnuncioProduto" name="nNomeAnuncioProduto" value="<?php echo $dadosAnuncio['nome_produto'] ?>" disabled>
              </div>
            </div>
            <div class="row col-12">
              <div class="categoriasProdutos d-flex flex-column justify-content-center align-items-center col-4">
                <label for="categoria" >Categoria:</label>
                <select type="text" class="form-control text-center disabledBackground" id="iCategoriaProduto" name="nCategoriaProduto" disabled>
                </select>
              </div>
              <div class="quantidade d-flex flex-column justify-content-center align-items-center col-4">
                <label for="quantidade">Quantidade do produto:</label>
                <input type="text" class="form-control text-center disabledBackground" id="iQuantidadeProduto" name="nQuantidadeProduto" value="<?php echo $dadosAnuncio['quantidade_produto'] ?>" disabled>
              </div>
              <div class="localidade d-flex flex-column justify-content-center align-items-center col-4" >
                <label for="localidade">Localidade do Anunciante:</label>
                <input type="text" class="form-control text-center disabledBackground" id="iLocalidadeAnunciante" name="nLocalidadeAnunciante" value="<?php echo $dadosAnuncio["estado_usuario"] ?> - <?php echo $dadosAnuncio["cidade_usuario"] ?>" disabled>
              </div>
            </div>
            <div class="row col-12">
              <div class="nome d-flex flex-column justify-content-center align-items-center col-4">
                <label for="nome_anunciante" >Nome do Anunciante:</label>
                <input type="text" class="form-control text-center disabledBackground" id="iNomeAnunciante" name="nNomeAnunciante" value="<?php echo $dadosAnuncio['nome_usuario'] ?>" disabled>
              </div>
              <div class="telefone d-flex flex-column justify-content-center align-items-center col-4">
                <label for="telefone_anunciante" >Telefone do Anunciante:</label>
                <input type="text" class="form-control text-center disabledBackground" id="iTelefoneAnunciante" name="nTelefoneAnunciante" value="<?php echo $dadosAnuncio['telefone_usuario'] ?>" disabled>
              </div>
              <div class="email d-flex flex-column justify-content-center align-items-center col-4">
                <label for="email_anunciante" >Email do Anunciante:</label>
                <input type="text" class="form-control text-center disabledBackground" id="iEmailAnunciante" name="nEmailAnunciante" value="<?php echo $dadosAnuncio['email_usuario'] ?>" disabled>
              </div>
            </div>
            <div class="row col-12">
              <div class="form-floating nome d-flex flex-column justify-content-center align-items-center col-12">
                <textarea class="form-control textarea disabledBackground" name="nDescricaoAnuncioProduto" id="iDescricaoAnuncioProduto" disabled><?php echo $dadosAnuncio['descri_produto'] ?></textarea>
              </div>
            </div>
            <div class="row col-12">
              <div class="form-floating d-flex justify-content-center align-items-center col-12">
                <input type="text" class="d-none" value="<?php echo $_GET['id_produto'] ?>" name="nIdAnuncioProduto">
                <?php if(intval($_GET['exibirWhatsapp']) != 0){ ?><button class="btn btn-info col-12 rounded-0 chamarTelegram"><p class="fs-9 m-0 text-white">CHAMAR NO TELEGRAM</p></button><?php } ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  <script>

  jQuery(document).ready(function() {

    $('.chamarTelegram').on('click', function() {
      
      const destinatarioTelefone = $('#iTelefoneAnunciante').val();
      const novaJanela = window.open("", "_blank");

      // Crie o link direto para o chat do Telegram
      const linkTelegram = `https://t.me/+55${destinatarioTelefone}`;

      // Redirecione para o chat do Telegram
      novaJanela.location.href = linkTelegram;
      
    });

    function resgatarCategoriasProduto() {

      let urlParams = new URLSearchParams(window.location.search);
      let id_produto = urlParams.get('id_produto');

      $.ajax({
        method: "GET",
        url: "../config/consultasGerais.php",
        data: { action: 'resgatarCategoriasProdutos', id_produto: id_produto},
        success: function(response) {
          let categorias = JSON.parse(response);
          let optionCategoria = null;
          let categoriaParts = null;
          let selectCategoria = document.getElementById('iCategoriaProduto');
          selectCategoria.innerHTML = '';

          for (let i = 0; i < categorias[0].length; i++) {
            categoriaParts = categorias[0][i].split(' | ');
            optionCategoria = document.createElement('option');
            optionCategoria.text = categoriaParts[0].charAt(0).toUpperCase()+categoriaParts[0].slice(1);
            optionCategoria.value = categoriaParts[1];

            if(categoriaParts[0] == categorias['nome_categoria']){
              optionCategoria.selected = true;
            }

            selectCategoria.appendChild(optionCategoria);
          }
        }
      });

    }

    function retornaImagensAnuncio() {

      let urlParams = new URLSearchParams(window.location.search);
      let id_produto = urlParams.get('id_produto');

      $.ajax({

        method: "GET",
        url: "../config/consultasGerais.php",
        data: { action: 'retornaImagensAnuncio', idAnuncio: id_produto, tipoAnuncio: 1 },
        success: function(response) {

            var arrayImagens = JSON.parse(response);
            var imagensPreview = "";
            for(let i = 0; i < arrayImagens.length; i++){

                if(i == 0){
                    imagensPreview += `<div class="carousel-item active">`;
                }else{
                    imagensPreview += `<div class="carousel-item">`;
                }
                
                imagensPreview += `<img class="mx-auto d-block rounded" src="../assets/imagensAnunciosProdutos/${arrayImagens[i]}" height="365px" width="350px">`;
                imagensPreview += `</div>`;

            };

            $('.carousel-inner')[0].innerHTML = "";
            $('.carousel-inner').append(imagensPreview);

        }

      });

    }

    resgatarCategoriasProduto();
    retornaImagensAnuncio();

  })

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
