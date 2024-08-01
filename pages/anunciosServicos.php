<?php
ini_set('display_errors', 0);
session_start();
require '../config/conexao.php';
$_GET['tipoAnuncio'] = 2;
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../assets/styles/anunciosServicos.css">
    <link rel="stylesheet" href="../assets/styles/headerLogado.css">
    <link rel="stylesheet" href="../assets/styles/headerDeslogado.css">
    <link rel="stylesheet" href="../assets/styles/filtrosAnuncios.css">
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
    <section class="section m-0 p-4">
        <div class="container col-sm-12 d-flex flex-column">

          <?php
            require_once '../components/filtrosAnuncios.php'; 
          ?>

          <div id="carouselServicos" class="carousel slide d-flex justify-content-start mt-4" data-ride="carousel">
            <div class="carousel-inner justify-content-start mt-4" id="containerAnuncios">                          
            </div>

            <button class="carousel-control-prev d-flex justify-content-start" data-bs-target="#carouselServicos" type="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>

            <button class="carousel-control-next d-flex justify-content-end" data-bs-target="#carouselServicos" type="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>

          </div>
        </div>
    </section>
  </body>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Bibliotecas do Sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Bibliotecas do datepicker Bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>

  <script>
    $(document).ready(function(){
        $('.input-date').datepicker();

        let resultadoFiltrado = false;

        function retornaAnunciosTotais(nomeDoServico, dataPostagem, categoriaServico, nomeAnunciante) {

          $.ajax({
            method: "GET",
            url: "../config/consultasGerais.php",
            data: { action: 'retornaTodosAnuncioServico', nomeDoServico: nomeDoServico, dataPostagem: dataPostagem, categoriaServico: categoriaServico, nomeAnunciante: nomeAnunciante},
            success: function(response) {

              let anunciosTotais = JSON.parse(response);
              let anuncios = document.getElementById('containerAnuncios');
              let menssagem = '';

              if (anunciosTotais != 'nenhumAnuncioEncontrado') {

                anuncios.innerHTML = anunciosTotais;

              }else{

                if(resultadoFiltrado == true){

                  menssagem = 'Não foi possível encontrar nenhum anúncio de serviço com base nos filtros selecionados!';
                  resultadoFiltrado = false;

                  Swal.fire(
                    'Eita...😬',
                    menssagem,
                    'error'
                  )

                  retornaAnunciosTotais(null, null, null, null);

                }else{

                  menssagem = 'Você não tem nenhum anúncio de serviço cadastrado no sistema!';

                  Swal.fire(
                    'Eita...😬',
                    menssagem,
                    'error'
                  )

                }
              }     
            }
          })
        }

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

                optionCategoria = document.createElement('option');
                optionCategoria.text = "Todos";
                optionCategoria.value = "todos";
                selectCategoria.appendChild(optionCategoria);

                for (let i = 0; i < categorias.length; i++) {
                  categoriaParts = categorias[i].split(' | ');
                  optionCategoria = document.createElement('option');
                  optionCategoria.text = categoriaParts[0].charAt(0).toUpperCase()+categoriaParts[0].slice(1);;
                  optionCategoria.value = categoriaParts[1];
                  selectCategoria.appendChild(optionCategoria);
                }
            }
          });

        }

        resgatarCategoriasServicos();
        retornaAnunciosTotais(null, null, null, null);

        // Adicione este código
        $('#carouselServicos').on('slid.bs.carousel', function () {
          let $this = $(this);

          $this.children('.carousel-control-prev').show();
          $this.children('.carousel-control-next').show();

          if ($('.carousel-inner .carousel-item:first').hasClass('active')) {
            $this.children('.carousel-control-prev').hide();
          } else if ($('.carousel-inner .carousel-item:last').hasClass('active')) {
            $this.children('.carousel-control-next').hide();
          }

        });

        $(".pesquisarButton").on('click', function(){

          let urlParams = new URLSearchParams(window.location.search);
          let tipoAnuncio = urlParams.get('tipoAnuncio');
          let nomeDoServico = $('#iPesquisaAnuncio').val();

          retornaAnunciosTotais(nomeDoServico, null, null, null);

        })

        $("#iFiltrar").on('click', function(){

          let dataPostagem = $(this).parent(".filtrar").siblings(".filtroData").children("#iDataPostagem").val();
          let categoriaServico = $(this).parent(".filtrar").siblings(".filtroCategoriaServicos").children("#iCategoriaServico").val();
          let nomeAnunciante = $(this).parent(".filtrar").siblings(".filtroNomeAnunciante").children("#iAnunciante").val();

          resultadoFiltrado = true;

          if((dataPostagem != "" && dataPostagem != null)  || (categoriaServico != "" && categoriaServico != null) || (nomeAnunciante != "" && nomeAnunciante != null)){
            retornaAnunciosTotais(null, dataPostagem, categoriaServico, nomeAnunciante);
          }

          $(this).parent(".filtrar").siblings(".filtroData").children("#iDataPostagem").val('');
          $(this).parent(".filtrar").siblings(".filtroCategoriaServicos").children("#categoriaServico")[0].selectedIndex = 0;

        })

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

