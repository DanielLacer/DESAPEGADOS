<?php
ini_set('display_errors', 0);
session_start();
require '../config/conexao.php';
require '../config/consultasGerais.php';
$_GET['tipoAnuncio'] = 0;

if(isset($_GET['id_produto'])){
    
  $dadosAnuncio = carregarAnuncioProduto($conn, $_GET['id_produto'], false);

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
    <link rel="stylesheet" href="../assets/styles/cadastrarAnuncioProduto.css">
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
        <h4>TELA PERFIL</h4>
      </div>
      <div class="container col-10 mt-3 d-flex" style="height: 480px">
        <form id="formEditarAnuncio" class="d-flex col-12">
          <div class="containerEsquerda col-4 h-100 d-flex flex-column justify-content-between align-items-center ps-3 pe-3 p-4">
              <div class="tituloAnuncio col-12">
                  <h5 class="m-0 text-center">EDITAR ANÚNCIO DO PRODUTO</h5>
              </div>

              <div class="divPreviewImagens" style="width: 367px !important">
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

              <div class="divCadastrarImagens col-12">
                  <input type="file" name="nImagens[]" id="iImagens" class="d-none" multiple/>
                  <label for="iImagens" class="btn btn-info  editarPerfil w-100 text-white text-center pb-2 rounded-0">Cadastrar Imagens</label>
              </div>
          </div>
          <div class="containerDireita col-8 d-flex flex-column h-100 justify-content-between align-items-center ps-3 pe-3 p-4">
            <div class="row col-12">
              <div class="tituloAnuncio d-flex justify-content-center align-items-center col-12">
                <input type="text" class="form-control text-center" id="iNomeAnuncioProduto" name="nNomeAnuncioProduto" value="<?php echo $dadosAnuncio['nome_produto'] ?>">
              </div>
            </div>
            <div class="row col-12 d-flex justify-content-between">
              <div class="categoriasProdutos d-flex flex-column justify-content-center align-items-center col-4">
                <label for="categoria" >Categoria:</label>
                <select type="text" class="form-control text-center" id="iCategoriaProduto" name="nCategoriaProduto">
                </select>
              </div>
              <div class="postagem d-flex flex-column justify-content-center align-items-center col-4">
                <label for="quantidade">Quantidade:</label>
                <input type="text" class="form-control text-center" id="iQuantidadeProduto" name="nQuantidadeProduto" value="<?php echo $dadosAnuncio['quantidade_produto'] ?>">
              </div>
              <div class="postagem d-flex flex-column justify-content-center align-items-center col-4">
                <label for="postagem">Data de Postagem:</label>
                <input type="text" class="form-control text-center bg-transparent" id="iDataPostagemAnuncio" name="nDataPostagemAnuncio" value="<?php echo date('d/m/Y', strtotime($dadosAnuncio['data_postagem']))?>" disabled>
              </div>
            </div>
            <div class="row col-12">
              <div class="form-floating d-flex flex-column justify-content-center align-items-center col-12">
                <textarea class="form-control textarea" name="nDescricaoAnuncioProduto" id="iDescricaoAnuncioProduto"><?php echo $dadosAnuncio['descri_produto'] ?></textarea>
              </div>
            </div>
            <div class="row col-12">
              <div class="form-floating d-flex justify-content-center align-items-center col-12">
                <input type="text" class="d-none" value="<?php echo $_GET['id_produto'] ?>" name="nIdAnuncioProduto">
                <button class="btn  col-12 rounded-0 cadastrarAnuncio" type="submit" ><p class="fs-9 m-0 text-white">EDITAR ANÚNCIO</p></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>

    <div class="toast position-fixed bottom-0 end-0 m-2" id="cadastroToast" role="alert" aria-live="assertive" aria-atomic="true" ata-animation="true" data-autohide="true" data-delay="3000" >
      <div class="toast-header text-bg-warning">
        <strong class="me-auto">Aviso</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
      Por favor, preencha os campos: Titulo do Anúncio, Categoria, Quantidade e Descrição do Anúncio para editar um Anúncio!
      </div>
    </div>

  </body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  <script>

  jQuery(document).ready(function() {

    $(document).on("change", "#iImagens", function(){  

      var files = this.files;
      var imagensPreview = "";
      for(let i = 0; i < files.length; i++){

          var fileURL = URL.createObjectURL(files[i]);

          if(i == 0){
              imagensPreview += `<div class="carousel-item active">`;
          }else{
              imagensPreview += `<div class="carousel-item">`;
          }
          
          imagensPreview += `<img class="mx-auto d-block rounded" src="${fileURL}" height="250px" width="250px">`;
          imagensPreview += `</div>`;

      };

      $('.carousel-inner')[0].innerHTML = "";
      $('.carousel-inner').append(imagensPreview);

    });

    $("#formEditarAnuncio").on('submit', function(e) {
        e.preventDefault(); 

        let nomeAnuncioProduto = document.getElementById("iNomeAnuncioProduto").value;
        let categoriaAnuncioProduto = document.getElementById('iCategoriaProduto').value;
        let quantidadeAnuncioProduto = document.getElementById('iQuantidadeProduto').value;
        let descricaoAnuncioProduto = document.getElementById('iDescricaoAnuncioProduto').value;

        if(nomeAnuncioProduto != "" && nomeAnuncioProduto != null && categoriaAnuncioProduto != "" && categoriaAnuncioProduto != null 
          && quantidadeAnuncioProduto != "" && quantidadeAnuncioProduto != null && descricaoAnuncioProduto != "" && descricaoAnuncioProduto != null){

          let formData = new FormData(this); 

          $.ajax({
              method: "POST",
              url: "../config/alterarAnuncioProduto.php",
              data: formData,
              processData: false,
              contentType: false, // 
              success: function(response) {
                if (response.status === 'error') {
                  Swal.fire({
                    icon: 'error',
                    title: 'Eita...😬',
                    text: response.message,
                  })
                } else {
                  Swal.fire({
                    icon: 'success',
                    title: 'Boa!!! 😄',
                    text: response.message,
                  })
                }
              }
          });

        }else{
          $("#cadastroToast").toast("show");
        }
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
            optionCategoria.text = categoriaParts[0].charAt(0).toUpperCase()+categoriaParts[0].slice(1);;
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
                
                imagensPreview += `<img class="mx-auto d-block rounded" src="../assets/imagensAnunciosProdutos/${arrayImagens[i]}" height="250px" width="250px">`;
                imagensPreview += `</div>`;

            };

            $('.carousel-inner')[0].innerHTML = "";
            $('.carousel-inner').append(imagensPreview);

        }

      });

    }

    resgatarCategoriasProduto();
    retornaImagensAnuncio();

  });

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
