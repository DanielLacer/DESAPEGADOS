<?php
ini_set('display_errors', 0);
session_start();
require '../config/conexao.php';
$_GET['tipoAnuncio'] = 0;
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
    <link rel="stylesheet" href="../assets/styles/cadastrarAnuncioServico.css">
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
      <div class="container col-sm-10 mt-3 d-flex" style="height: 480px">
        <form id="formCadastroAnuncio" class="d-flex col-12">
          <div class="containerEsquerda col-4 h-100 d-flex flex-column justify-content-between align-items-center ps-3 pe-3 p-4">
              <div class="tituloAnuncio col-12">
                  <h5 class="m-0 text-center">CADASTRO ANÚNCIO DO SERVIÇO</h5>
              </div>

              <div class="divPreviewImagens" style="width: 367px !important">
                <div id="carouselExample" class="carousel slide">
                  <div class="carousel-inner">
                    <div class="carousel-item active d-flex justify-content-center align-items-center">
                      <img src="../assets/imagens_padrao/addImage.jpg" height="330px">
                    </div>
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
                <input type="text" class="form-control text-center" id="iNomeAnuncioServico" name="nNomeAnuncioServico" placeholder="Titulo do Anúncio...">
              </div>
            </div>
            <div class="row col-12 d-flex justify-content-between">
              <div class="categoriaServico d-flex flex-column justify-content-center align-items-center col-4">
                <label for="iCategoriaServico" >Categoria:</label>
                <select type="text" class="form-control text-center" id="iCategoriaServico" name="nCategoriaServico">
                </select>
              </div>
              <div class="duracao d-flex flex-column justify-content-center align-items-center col-4">
                <label for="iDuracaoServico">Duração:</label>
                <input type="text" class="form-control text-center" placeholder="4 horas" id="iDuracaoServico" name="nDuracaoServico">
              </div>
              <div class="postagem d-flex flex-column justify-content-center align-items-center col-4">
                <label for="iDataPostagemServico">Data de Postagens:</label>
                <input type="text" class="form-control text-center bg-transparent" id="iDataPostagemServico" name="nDataPostagemServico" disabled>
              </div>
            </div>
            <div class="row col-12">
              <div class="form-floating d-flex flex-column justify-content-center align-items-center col-12">
                <textarea class="form-control textarea" name="nDescricaoAnuncioServico" id="iDescricaoAnuncioServico" >Digite a descrição anuncio...</textarea>
              </div>
            </div>
            <div class="row col-12">
              <div class="form-floating d-flex justify-content-center align-items-center col-12">
                <button type="submit" class="btn  col-12 rounded-0 cadastrarAnuncio"><p class="fs-9 m-0 text-white">CADASTRAR ANÚNCIO</p></button>
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
        Por favor, preencha os campos: Titulo do Anúncio, Categoria, Duração e Descrição do Anúncio para cadastrar um novo Anúncio!
      </div>
    </div>
    
  </body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  <script>

  jQuery(document).ready(function() {

    $('#iDuracaoServico').on('input', function() {
        const valorDigitado = $(this).val().trim();
        const numero = parseFloat(valorDigitado);

        if (!isNaN(numero)) {
            $(this).val(numero + ' horas');
        }
    });

    $(document).on("change", "#iImagens", function(){  

      var files = this.files;
      var imagensPreview = ""
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
      $('.carousel-inner').append(imagensPreview)

    });

    $("#formCadastroAnuncio").on('submit', function(e) {
      e.preventDefault(); 

      let nomeAnuncioServico = document.getElementById("iNomeAnuncioServico").value;
      let categoriaAnuncioServico = document.getElementById('iCategoriaServico').value;
      let quantidadeAnuncioServico = document.getElementById('iDuracaoServico').value;
      let descricaoAnuncioServico = document.getElementById('iDescricaoAnuncioServico').value;

      if(nomeAnuncioServico != "" && nomeAnuncioServico != null && categoriaAnuncioServico != "" && categoriaAnuncioServico != null 
        && quantidadeAnuncioServico != "" && quantidadeAnuncioServico != null && descricaoAnuncioServico != "" && descricaoAnuncioServico != null){

        let formData = new FormData(this); 

        $.ajax({
          method: "POST",
          url: "../config/cadastroAnuncioServico.php",
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

    function resgatarCategoriasServicos() {

      $.ajax({
        method: "GET",
        url: "../config/consultasGerais.php",
        data: { action: 'resgatarCategoriasServicos', id_servico: null },
        success: function(response) {
          let categorias = JSON.parse(response);
          let optionCategoria = null;
          let categoriaParts = null;
          let selectCategoria = document.getElementById('iCategoriaServico');
          selectCategoria.innerHTML = '';

          for (let i = 0; i < categorias.length; i++) {
            categoriaParts = categorias[i].split(' | ');
            optionCategoria = document.createElement('option');
            optionCategoria.text = categoriaParts[0].charAt(0).toUpperCase()+categoriaParts[0].slice(1);
            optionCategoria.value = categoriaParts[1];
            selectCategoria.appendChild(optionCategoria);
          }
        }
      });

    }
    
    function retornaDataHoje() {

      var dataAtual = new Date();
      var dia = String(dataAtual.getDate()).padStart(2, '0');
      var mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Os meses em JavaScript começam do 0 para janeiro
      var ano = dataAtual.getFullYear();

      var dataFormatada = dia + '/' + mes + '/' + ano;

      document.getElementById('iDataPostagemServico').value = dataFormatada;

    }

    retornaDataHoje();
    resgatarCategoriasServicos();

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