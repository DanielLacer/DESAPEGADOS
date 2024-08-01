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
    <title>DESAPEGADOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../../assets/styles/pagesPerfil/meusAnuncios.css">
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
      <div class="container col-sm-10 mt-3 d-flex flex-row" style="height: 480px">
        <div class="containerEsquerda col-sm-4 h-100 d-flex flex-column justify-content-between align-items-center ps-2 pe-2 p-4">
            <div class="tituloMeusAnuncios col-12">
                <h5 class="m-0 text-center mt-2">OPÇÕES</h5>
            </div>
            <div class="acoesMeusAnuncios col-12 d-flex flex-column pb-5">
              <button class="btn btn-success  mb-3 rounded-0" onclick="window.location.href='meusAnuncios.php?tipoAnuncio=1'"><p class="fs-9">MEUS ANÚNCIOS (PRODUTOS)</p></button>
              <button class="btn btn-success  mb-3 rounded-0" onclick="window.location.href='meusAnuncios.php?tipoAnuncio=2'"><p class="fs-9">MEUS ANÚNCIOS (SERVIÇOS)</p></button>
              <button class="btn btn-success  mb-3 rounded-0" onclick="window.location.href='../cadastrarAnuncioProduto.php'"><p class="fs-9">CADASTRAR ANÚNCIO (PRODUTOS)</p></button>
              <button class="btn btn-success  mb-3 rounded-0" onclick="window.location.href='../cadastrarAnuncioServico.php'"><p class="fs-9">CADASTRAR ANÚNCIO (SERVIÇOS)</p></button>
            </div>
        </div>
        <div class="containerDireita col-sm-8 d-flex flex-column h-100 justify-content-center align-items-center p-4">
          <div class="tituloConteudo col-12">
              <h5 class="m-0 text-center mb-2 mt-3">MEUS ANUNCIOS</h5>
          </div>
          <div class="filtroAnuncios col-12 d-flex border-bottom border-dark pb-1 mt-4">
            <div class="tituloFiltro col-1">
              <p class="m-0 text-center fs-6 text-black">Filtros:</p>
            </div>
            <div class="filtroData col-2 ms-2">
              <input type="text" data-provide="datepicker" class="input-filtros input-date w-100 border border-success-subtle border-2 text-center filtros" id="iDataPostagem" name="nDataPostagem" placeholder="Data Postagem">
            </div>
            <div class="filtroCategoriaProdutos col-2 ms-2">
              <select type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iCategoriaProduto" name="nCategoriaProduto"></select>
            </div>
            <div class="filtroCategoriaServicos col-2 ms-2">
              <select type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iCategoriaServico" name="nCategoriaServico"></select>
            </div>
            <div class="filtrar col-2 ms-2">
              <button type="button" class="btn btn-success filtros rounded-0 d-flex justify-content-center align-items-center" id="iFiltrar" name="nFiltrar">FILTRAR</button>
            </div>
          </div>
          <div class="conteudo col-12 d-flex flex-column align-items-center justify-content-between mt-4 mb-4 p-3 bg-light border border-dark" id="conteudo">
          </div>
        </div>
      </div>
    </section>

    <div class="toast position-fixed bottom-0 end-0 m-2" id="filtroToast" role="alert" aria-live="assertive" aria-atomic="true" ata-animation="true" data-autohide="true" data-delay="3000" >
      <div class="toast-header text-bg-warning">
        <strong class="me-auto">Aviso</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Por favor, preencha pelo menos um dos campos do filtro!
      </div>
    </div>

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

      let urlParams = new URLSearchParams(window.location.search);
      let tipoAnuncio = urlParams.get('tipoAnuncio');
      let resultadoFiltrado = false;

      function retornarAnuncios(tipoAnuncio, dataPostagem, categoriaProduto, categoriaServico){

        $.ajax({
          method: "GET",
          url: "../../config/consultasGerais.php",
          data: { action: 'resgatarMeusAnuncios', tipoAnuncio: tipoAnuncio, dataPostagem: dataPostagem, categoriaProduto: categoriaProduto, categoriaServico: categoriaServico},
          success: function(response) {

            let anunciosUsuario = JSON.parse(response);
            let anuncios = document.getElementById('conteudo');
            let menssagem = '';

            if (anunciosUsuario != 'nenhumAnuncioEncontrado') {
                anuncios.innerHTML = anunciosUsuario;
            }else{

              if(resultadoFiltrado == true){

                if(tipoAnuncio == 1){
                  menssagem = 'Não foi possível encontrar nenhum anúncio de produto com base nos filtros selecionados!'
                }else{
                  menssagem = 'Não foi possível encontrar nenhum anúncio de serviço com base nos filtros selecionados!'
                }

                Swal.fire(
                  'Eita...😬',
                  menssagem,
                  'error'
                )

                resultadoFiltrado = false;

                retornarAnuncios(tipoAnuncio, null, null, null);

              }else{

                if(tipoAnuncio == 1){
                  menssagem = '<h7 class="text-center">Você não tem nenhum anúncio de produto cadastrado no sistema!</h7>'
                }else{
                  menssagem = '<h7 class="text-center">Você não tem nenhum anúncio de serviço cadastrado no sistema!</h7>'
                }

                anuncios.classList.remove('justify-content-between');
                anuncios.classList.add('justify-content-center');
                anuncios.innerHTML = menssagem;
              }
            }       
          }
        });
      }

      function resgatarCategoriasProdutos() {

        $.ajax({
          method: "GET",
          url: "../../config/consultasGerais.php",
          data: { action: 'resgatarCategoriasProdutos', id_produto: null},
          success: function(response) {
            let categorias = JSON.parse(response);
            let optionCategoria = null;
            let categoriaParts = null;
            let selectCategoria = document.getElementById('iCategoriaProduto');
            selectCategoria.innerHTML = '';

            optionCategoria = document.createElement('option');
            optionCategoria.text = "Todos";
            optionCategoria.value = "todos";
            selectCategoria.appendChild(optionCategoria);

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

      function resgatarCategoriasServicos() {

        $.ajax({
          method: "GET",
          url: "../../config/consultasGerais.php",
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
              optionCategoria.text = categoriaParts[0].charAt(0).toUpperCase()+categoriaParts[0].slice(1);
              optionCategoria.value = categoriaParts[1];
              selectCategoria.appendChild(optionCategoria);
            }
          }
        });

      }

      $(document).on('click', '.excluirAnuncio', function(event){

        let id_anuncio = $(this).closest('.conteudoAnuncio').find('#identificadorAnuncio').val();
        let urlParams = new URLSearchParams(window.location.search);
        let tipoAnuncio = urlParams.get('tipoAnuncio');
        let nomePaginaAtual = window.location.pathname.split('/').pop();
        let usuarioAdm = false;

        if(nomePaginaAtual == "areaAdm.php"){
          usuarioAdm = true;
        }

        Swal.fire({
          title: 'Você tem certeza?',
          text: "Uma vez excluído, você não poderá recuperar este anúncio!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3DED3F',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Deletar!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              method: "DELETE",
              url: "../../config/deletarAnuncio.php?id_anuncio=" + id_anuncio + "&tipoAnuncio=" + tipoAnuncio + "&usuarioAdm=" + usuarioAdm,
              success: function(response) {
                if (response.status === 'error') {
                  Swal.fire(
                    'Eita...😬',
                    response.message,
                    'error'
                  )
                } else {
                  Swal.fire(
                    'Boa!!! 😄',
                    response.message,
                    'success'
                  )
                  retornarAnuncios(tipoAnuncio, null, null, null);
                }
              },
              error: function (xhr, status, erro) {
                console.error('Erro na requisição. Status:', erro);
              }
            });
          }
        });
      });

      $('#iEstadoUsuario').on('change', function() {

        let estadoSelecionado = $(this).find('option:selected').val(); 
        nomeEstadoSelecionado = $(this).find('option:selected')[0].innerText; 

        let url = `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoSelecionado}/municipios`;

        fetch(url)
          .then(function(response) {
            return response.json();
          })
          .then(function(cidades) {

            let selectCidade = document.getElementById('iCidadeUsuario');
                selectCidade.innerHTML = '';

            for (let i = 0; i < cidades.length; i++) {

              let optionCidade = document.createElement('option');

              optionCidade.classList.add('cidade-option');
              optionCidade.id = 'cidade-'+i;

              optionCidade.value = cidades[i].id;
              optionCidade.text = cidades[i].nome;
              cidadeSelecionado = cidades[i].nome;

              selectCidade.appendChild(optionCidade);

            }

            $(".cidade").removeClass("d-none");

          })
          .catch(function(error) {
            console.error('Erro ao preencher os estados:', error);
          });

      });

      $("#iFiltrar").on('click', function(){

        let urlParams = new URLSearchParams(window.location.search);
        let tipoAnuncio = urlParams.get('tipoAnuncio');
        let dataPostagem = $(this).parent(".filtrar").siblings(".filtroData").children("#iDataPostagem").val();
        let categoriaProduto = null;
        let categoriaServico = null;

        resultadoFiltrado = true;

        if(tipoAnuncio == 1){

          categoriaProduto = $(this).parent(".filtrar").siblings(".filtroCategoriaProdutos").children("#iCategoriaProduto").val()

          if((dataPostagem != "" && dataPostagem != null)  || (categoriaProduto != "" && categoriaProduto != null)){
            retornarAnuncios(tipoAnuncio, dataPostagem, categoriaProduto, null);
          }else{
            $("#filtroToast").toast("show");
          }
          
        }else if(tipoAnuncio == 2){

          categoriaServico = $(this).parent(".filtrar").siblings(".filtroCategoriaServicos").children("#iCategoriaServico").val()

          if((dataPostagem != "" && dataPostagem != null)  || (categoriaServico != "" && categoriaServico != null)){
            retornarAnuncios(tipoAnuncio, dataPostagem, null, categoriaServico);
          }else{
            $("#filtroToast").toast("show");
          }

        }

        $(this).parent(".filtrar").siblings(".filtroData").children("#iDataPostagem").val('');
        $(this).parent(".filtrar").siblings(".filtroCategoriaProdutos").children("#iCategoriaProduto")[0].selectedIndex = 0;
        $(this).parent(".filtrar").siblings(".filtroCategoriaServicos").children("#iCategoriaServico")[0].selectedIndex = 0;

      })

      $('#iDataPostagem').on('click', function(){
        $(this).val('');
      });

      $('#filtroToast').toast({
        autohide: true,
        delay: 3000
      });

      if(tipoAnuncio == 1 && !$('.filtroCategoriaProdutos').hasClass('d-none')){
        
        $('.filtroCategoriaProdutos').removeClass('d-none');
        $('.filtroCategoriaServicos').addClass('d-none');

        resgatarCategoriasProdutos();
        retornarAnuncios(tipoAnuncio, null, null, null);

      }else if(tipoAnuncio == 2 && !$('.filtroCategoriaServicos').hasClass('d-none')){

        $('.filtroCategoriaServicos').removeClass('d-none');
        $('.filtroCategoriaProdutos').addClass('d-none');

        resgatarCategoriasServicos();
        retornarAnuncios(tipoAnuncio, null, null, null);

      }
      
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