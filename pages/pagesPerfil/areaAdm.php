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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../../assets/styles/pagesPerfil/areaADM.css">
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
    <section class="section m-0 p-4 d-flex flex-column justify-content-center align-items-center col-sm-12">
      <div class="container col-sm-10 mt-3 d-flex flex-row" style="height: 480px">
        <div class="containerEsquerda col-sm-4 h-100 d-flex flex-column justify-content-center align-items-center ps-2 pe-2 p-4">
            <div class="tituloADM col-12 pb-5">
                <h5 class="m-0 text-center mt-2 pb-1">AREA ADM</h5>
            </div>
            <div class="col-12 d-flex flex-column pt-5 pb-4">
                <button class="acoesADM btn btn-success  mb-3 rounded-0" onclick="window.location.href='areaAdm.php?tipoAnuncio=1'"><p class="fs-9">TODOS ANÚNCIOS (PRODUTOS)</p></button>
                <button class="acoesADM btn btn-success  mb-3 rounded-0" onclick="window.location.href='areaAdm.php?tipoAnuncio=2'"><p class="fs-9">TODOS ANÚNCIOS (SERVIÇOS)</p></button>
                <!--<button class="btn btn-success  mb-3 rounded-0"><p class="fs-9" onclick="window.location.href='cadastrarPerfil.php?liberarNivelUsuario=1'">CADASTRAR USUÁRIOS</p></button>-->
                <button class="acoesADM btn btn-success  mb-3 rounded-0" onclick="window.location.href='areaAdm.php?tipoAnuncio=3'"><p class="fs-9">VISUALIZAR TODOS USUÁRIOS DO SISTEMA</p></button>
                <button class="acoesADM btn btn-success  mb-3 rounded-0"><p class="fs-9" onclick="window.location.href='areaAdm.php?tipoAnuncio=4'">CONFIGURAÇÕES SISTEMA</p></button>
            </div>
        </div>
        <div class="containerDireita col-sm-8 d-flex flex-column h-100 justify-content-between align-items-center p-4">
          <div class="col-12 mt-2">
              <h5 class="m-0 text-center tituloConteudo"></h5>
          </div>
          <div class="filtroAnuncios col-12 d-flex border-bottom border-dark pb-1 mt-4">
            <div class="tituloFiltro col-1">
              <p class="m-0 text-center fs-6 text-black">Filtros:</p>
            </div>
            <div class="filtroData col-2  ms-2">
              <input type="text" data-provide="datepicker" class="input-filtros input-date w-100 border border-success-subtle border-2 text-center filtros" id="iDataPostagem" name="nDataPostagem" placeholder="Data Postagem">
            </div>
            <div class="filtroCategoriaProdutos col-2  ms-2">
              <select type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iCategoriaProduto" name="nCategoriaProduto"></select>
            </div>
            <div class="filtroCategoriaServicos col-2 ms-2">
              <select type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iCategoriaServico" name="nCategoriaServico"></select>
            </div>
            <div class="filtroNomeAnunciante col-2  ms-2">
              <input type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iNomeAnunciante" name="nNomeAnunciante" placeholder="Anunciante...">
            </div>
            <div class="filtroIdUsuario col-2  ms-2">
              <input type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iIdUsuario" name="nIdUsuario" placeholder="ID do Usuário...">
            </div>
            <div class="filtroNomeUsuario col-2  ms-2">
              <input type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iNomeUsuario" name="nNomeUsuario" placeholder="Nome do Usuário...">
            </div>
            <div class="filtroEmailUsuario col-2  ms-2">
              <input type="text" class="input-filtros w-100 border border-success-subtle border-2 text-center filtros" id="iEmailUsuario" name="nEmailUsuario" placeholder="Email do Usuário...">
            </div>
            <div class="filtrar col-2 ms-2">
              <button type="button" class="btn btn-success filtros rounded-0 d-flex justify-content-center align-items-center" id="iFiltrar" name="nFiltrar">FILTRAR</button>
            </div>
          </div>
          <div class="conteudo col-12 d-flex flex-column align-items-center justify-content-between mb-4 p-3 bg-light border border-dark" id="conteudo">          
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

    <div class="modal fade" id="editarNivelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar nível de permissão do usuário</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="label d-flex justify-content-center align-items-center mb-1"><label for="iNivelUsuario">Nivel do usuário:</label></div>
            <select name="nNivelUsuario" id="iNivelUsuario" class="form-control">
              <option value="1" >Usuário</option>
              <option value="2" >Funcionário</option>
            </select>
            <input type="text" class="d-none" value="" id="idUsuarioAlterado">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FECHAR</button>
            <button type="button" class="btn btn-success salvarNovoNivel">SALVAR</button>
          </div>
        </div>
      </div>
    </div>

  </body>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  <!-- Bibliotecas do Sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Bibliotecas do datepicker Bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>

  <script>
    
    $(document).ready(function(){
        
        let pageNum = 0;
        let urlParams = new URLSearchParams(window.location.search);
        let tipoAnuncio = urlParams.get('tipoAnuncio');
        let tituloConteudo = document.getElementsByClassName("tituloConteudo")[0];
        let resultadoFiltrado = false;
        let idUsuarioNivel = null;

        function retornarUsuarios(idUsuario, nomeUsuario, emailUsuario) {

          $('.conteudo').removeClass('overflow');
          $('.conteudo').addClass('pt-0');
          
          $.ajax({
            method: "GET",
            url: "../../config/consultasGerais.php",
            data: { action: 'resgatarUsuarios', idUsuario: idUsuario, nomeUsuario: nomeUsuario, emailUsuario: emailUsuario},
            success: function(response) {

                let tabelaUsuarios = JSON.parse(response);

                if(tabelaUsuarios != "filtrosIncorretos"){

                  $('.conteudo').removeClass('bg-light border border-dark');

                  let divConteudo = document.getElementsByClassName("conteudo");
                  divConteudo[0].innerHTML = tabelaUsuarios;

                  showPage(pageNum);

                }else{
                  
                  Swal.fire(
                      'Eita...😬',
                      'Não foi possível encontrar nenhum usuário com base nos filtros selecionados!',
                      'error'
                  )

                  retornarUsuarios(null, null, null);
                }
                
            }
          });

        }

        function resgatarCategoriasProdutos(tipoTela) {

          $.ajax({
            method: "GET",
            url: "../../config/consultasGerais.php",
            data: { action: 'resgatarCategoriasProdutos', id_produto: null},
            success: function(response) {

                let categorias = JSON.parse(response);
                let optionCategoria = null;
                let categoriaParts = null;
                let selectCategoria = null;

                if(tipoTela == 1){
                  selectCategoria = $('#iCategoriaProduto').empty();
                }else{
                  selectCategoria = $('#iCategoriaProdutoConfig').empty();
                }

                optionCategoria = document.createElement('option');
                optionCategoria.text = "Todos";
                optionCategoria.value = "todos";
                selectCategoria.append(optionCategoria);

                for (let i = 0; i < categorias.length; i++) {
                  categoriaParts = categorias[i].split(' | ');
                  optionCategoria = document.createElement('option');
                  optionCategoria.text = categoriaParts[0].charAt(0).toUpperCase()+categoriaParts[0].slice(1);;
                  optionCategoria.value = categoriaParts[1];
                  selectCategoria.append(optionCategoria);
                }
            }
          });

        }

        function resgatarCategoriasServicos(tipoTela) {

          $.ajax({
            method: "GET",
            url: "../../config/consultasGerais.php",
            data: { action: 'resgatarCategoriasServicos', id_servico: null},
            success: function(response) {

                let categorias = JSON.parse(response);
                let optionCategoria = null;
                let categoriaParts = null;
                let selectCategoria = null;

                if(tipoTela == 1){
                  selectCategoria = $('#iCategoriaServico').empty();
                }else{
                  selectCategoria = $('#iCategoriaServicoConfig').empty();
                }

                optionCategoria = document.createElement('option');
                optionCategoria.text = "Todos";
                optionCategoria.value = "todos";
                selectCategoria.append(optionCategoria);

                for (let i = 0; i < categorias.length; i++) {
                  categoriaParts = categorias[i].split(' | ');
                  optionCategoria = document.createElement('option');
                  optionCategoria.text = categoriaParts[0].charAt(0).toUpperCase()+categoriaParts[0].slice(1);;
                  optionCategoria.value = categoriaParts[1];
                  selectCategoria.append(optionCategoria);
                }
            }
          });

        }

        function retornaAnunciosTotais(tipoAnuncio, dataPostagem, categoriaProduto, categoriaServico, nomeAnunciante){

          $('.conteudo').addClass('overflow');
          $('.conteudo').removeClass('pt-0');

          $.ajax({
            method: "GET",
            url: "../../config/consultasGerais.php",
            data: { action: 'retornaTodosAnuncioAdmin', tipoAnuncio: tipoAnuncio, dataPostagem: dataPostagem, categoriaProduto: categoriaProduto, categoriaServico: categoriaServico, nomeAnunciante: nomeAnunciante},
            success: function(response) {
              
                let anunciosTotais = JSON.parse(response);
                let anuncios = document.getElementById('conteudo');
                let menssagem = '';

                if(anunciosTotais != "nenhumAnuncioEncontrado"){
                  anuncios.innerHTML = anunciosTotais;
                }else{

                  if(resultadoFiltrado == true){

                    if(tipoAnuncio == 1){
                      menssagem = 'Não foi possível encontrar nenhum anúncio de produto com base nos filtros selecionados!';
                    }else{
                      menssagem = 'Não foi possível encontrar nenhum anúncio de serviço com base nos filtros selecionados!';
                    }

                    Swal.fire(
                      'Eita...😬',
                      menssagem,
                      'error'
                    )

                    resultadoFiltrado = false;

                    retornaAnunciosTotais(tipoAnuncio, null, null, null, null);

                  }else{

                    if(tipoAnuncio == 1){
                      menssagem = '<h7 class="text-center">Não existe nenhum anúncio de produto cadastrado no sistema!</h7>'
                    }else{
                      menssagem = '<h7 class="text-center">Não existe nenhum anúncio de serviço cadastrado no sistema!</h7>';
                    }

                    anuncios.classList.remove('justify-content-between');
                    anuncios.classList.add('justify-content-center');
                    anuncios.innerHTML = menssagem;
                  }
                }
            }
          })

        }

        function showPage(pageNum) {

          let rowsShown = 4;
          let rowsTotal = $('#myTable tbody tr').length;
          let numPages = Math.ceil(rowsTotal/rowsShown);

          $('#myTable tbody tr').hide().slice(pageNum*rowsShown, (pageNum+1)*rowsShown).show();
          $('#page-num').text(pageNum + 1);

          if (pageNum === 0) {
            $('.bi-arrow-left').addClass('d-none');
          } else {
            $('.bi-arrow-left').removeClass('d-none');
          }
          
          if (pageNum === numPages-1) {
            $('.bi-arrow-right').addClass('d-none');
          } else {
            $('.bi-arrow-right').removeClass('d-none');
          }
        }

        function ajustarTela(){

          if($('.filtroAnuncios').hasClass('d-none')){
            $('.filtroAnuncios').removeClass('d-none');
            $('.filtroAnuncios').addClass('d-flex');
          }

          if($('.conteudo').hasClass('p-4')){
            $('.conteudo').removeClass('p-4');
            $('.conteudo').addClass('p-3');
          }
          
        }

        $(document).on('click', '.bi-arrow-left', function(){
          showPage(--pageNum);
        });

        $(document).on('click', '.bi-arrow-right', function(){
          showPage(++pageNum);
        });

        $(document).on('click', '.excluirAnuncio', function(event){

          let id_anuncio = $(this).closest('.conteudoAnuncio').find('#identificadorAnuncio').val();
          let urlParams = new URLSearchParams(window.location.search);
          let tipoAnuncio = urlParams.get('tipoAnuncio');
          let nomePaginaAtual = window.location.pathname.split('/').pop();
          let usuarioAdm = false;

          if (nomePaginaAtual == "areaAdm.php") {
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
                              retornaAnunciosTotais(tipoAnuncio, null, null, null, null);
                          }
                      }
                  });
              }
          });

        });

        $(document).on('click', '.excluirUsuario', function(event){

          let id_usuario = $(this).siblings('#identificadorUsuario')[0].innerText;

          Swal.fire({
            title: 'Você tem certeza?',
            text: "Você deseja realmente excluir esse usuário?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Deletar!',
            confirmButtonColor: '#3DED3F'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                method: "DELETE",
                url: "../../config/deletarUsuario.php?id_usuario=" + id_usuario,
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
                    retornarUsuarios(null, null, null);
                  }
                }
              });
            }
          });

        });

        $(document).on('click', '.editarNivelUsuario', function(event){

          idUsuarioNivel = $(this).parent('td').siblings('.excluir_celulas')[0].children[0].innerText;

          $.ajax({
            method: "GET",
            url: "../../config/consultasGerais.php",
            data: { action: 'retornarNivelUsuario', idUsuario: idUsuarioNivel},
            success: function(response) {

              let retorno = JSON.parse(response);
              let selectElement = document.getElementById('iNivelUsuario');

              for (let i = 0; i < selectElement.options.length; i++) {

                  if (parseInt(selectElement.options[i].value) == retorno['nivel_usuario']) {
                      selectElement.options[i].selected = true;
                      break; 
                  }
              }
                
            }
          });

        })

        $(document).on('click', '.salvarNovoNivel', function(event){

          let novo_nivel = $('#iNivelUsuario').val();

          $.ajax({
            method: "UPDATE",
            url: "../../config/alterarNivelUsuario.php?id_usuario_nivel=" + idUsuarioNivel + "&novo_nivel=" + novo_nivel,
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
              }
            }
          });

        })

        $(document).on('click', '.salvarCategoriaProduto', function(event){

          let novaCategoria = $('#iSalvarCategoriaProduto').val();

          $.ajax({
            method: "POST",
            url: "../../config/cadastrarCategoriaProduto.php?nova_categoria=" + novaCategoria,
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

                $('#iSalvarCategoriaProduto').val('');
                resgatarCategoriasProdutos(2);
              }
            }
          });

        })

        $(document).on('click', '.salvarCategoriaServico', function(event){

          let novaCategoria = $('#iSalvarCategoriaServico').val();

          $.ajax({
            method: "POST",
            url: "../../config/cadastrarCategoriaServico.php?nova_categoria=" + novaCategoria,
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

                $('#iSalvarCategoriaServico').val('');
                resgatarCategoriasServicos(2);
              }
            }
          });

        })

        $(document).on('click', '.removerCategoriaProduto', function(event){

          let removerCategoria = $('#iRemoverCategoriaProduto').val();

          $.ajax({
            method: "DELETE",
            url: "../../config/removerCategoriaProduto.php?remover_categoria=" + removerCategoria,
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

                $('#iRemoverCategoriaProduto').val('');
                resgatarCategoriasProdutos(2);
              }
            }
          });

        })

        $(document).on('click', '.removerCategoriaServico', function(event){

          let removerCategoria = $('#iRemoverCategoriaServico').val();

          $.ajax({
            method: "DELETE",
            url: "../../config/removerCategoriaServico.php?remover_categoria=" + removerCategoria,
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

                $('#iRemoverCategoriaServico').val('');
                resgatarCategoriasServicos(2);
              }
            }
          });

        })

        $(document).on('click', '#iFiltrar', function(event){

          let urlParams = new URLSearchParams(window.location.search);
          let tipoAnuncio = urlParams.get('tipoAnuncio');
          let dataPostagem = $(this).parent(".filtrar").siblings(".filtroData").children("#iDataPostagem").val();
          let nomeAnunciante = $(this).parent(".filtrar").siblings(".filtroNomeAnunciante").children("#iNomeAnunciante").val();
          let categoriaProduto = null;
          let categoriaServico = null;
          let idUsuario = null;
          let nomeUsuario = null;
          let emailUsuario = null;

          resultadoFiltrado = true;

          if(tipoAnuncio == 1){

            categoriaProduto = $(this).parent(".filtrar").siblings(".filtroCategoriaProdutos").children("#iCategoriaProduto").val();

            if((dataPostagem != "" && dataPostagem != null)  || (categoriaProduto != "" && categoriaProduto != null) || (nomeAnunciante != "" && nomeAnunciante != null)){
              retornaAnunciosTotais(tipoAnuncio, dataPostagem, categoriaProduto, null, nomeAnunciante);
            }else{
              $("#filtroToast").toast("show");
            }

          }else if(tipoAnuncio == 2){

            categoriaServico = $(this).parent(".filtrar").siblings(".filtroCategoriaServicos").children("#iCategoriaServico").val();

            if((dataPostagem != "" && dataPostagem != null)  || (categoriaServico != "" && categoriaServico != null) || (nomeAnunciante != "" && nomeAnunciante != null)){
              retornaAnunciosTotais(tipoAnuncio, dataPostagem, null, categoriaServico, nomeAnunciante);
            }else{
              $("#filtroToast").toast("show");
            }

          }else{

            idUsuario = $(this).parent(".filtrar").siblings(".filtroIdUsuario").children("#iIdUsuario").val();
            nomeUsuario = $(this).parent(".filtrar").siblings(".filtroNomeUsuario").children("#iNomeUsuario").val();
            emailUsuario = $(this).parent(".filtrar").siblings(".filtroEmailUsuario").children("#iEmailUsuario").val();

            if((idUsuario != "" && idUsuario != null)  || (nomeUsuario != "" && nomeUsuario != null) || (emailUsuario != "" && emailUsuario != null)){
              retornarUsuarios(idUsuario, nomeUsuario, emailUsuario);

              $(this).parent(".filtrar").siblings(".filtroIdUsuario").children("#iIdUsuario").val('');
              $(this).parent(".filtrar").siblings(".filtroNomeUsuario").children("#iNomeUsuario").val('');
              $(this).parent(".filtrar").siblings(".filtroEmailUsuario").children("#iEmailUsuario").val('');

            }else{
              $("#filtroToast").toast("show");
            }

          }

          $(this).parent(".filtrar").siblings(".filtroData").children("#iDataPostagem").val('');
          $(this).parent(".filtrar").siblings(".filtroCategoriaProdutos").children("#iCategoriaProduto")[0].selectedIndex = 0;
          $(this).parent(".filtrar").siblings(".filtroCategoriaServicos").children("#iCategoriaServico")[0].selectedIndex = 0;
          
        });

        $('#iDataPostagem').on('click', function(){
          $(this).val('');
        });

        $('#filtroToast').toast({
          autohide: true,
          delay: 3000
        });

        if($('.filtroData').hasClass('d-none') && $('.filtroNomeAnunciante').hasClass('d-none')){

          $('.filtroData').removeClass('d-none');
          $('.filtroData').addClass('d-flex');

          $('.filtroNomeAnunciante').removeClass('d-none');
          $('.filtroNomeAnunciante').addClass('d-flex');

        }else{

          $('.filtroIdUsuario').removeClass('d-flex');
          $('.filtroIdUsuario').addClass('d-none');

          $('.filtroNomeUsuario').removeClass('d-flex');
          $('.filtroNomeUsuario').addClass('d-none');

          $('.filtroEmailUsuario').removeClass('d-flex');
          $('.filtroEmailUsuario').addClass('d-none');
          
        }

        if(tipoAnuncio == 1 && !$('.filtroCategoriaProdutos').hasClass('d-none')){

          ajustarTela();

          tituloConteudo.innerHTML = "QUANTIDADE DE ANÚNCIOS DE PRODUTOS CADASTRADOS NO SISTEMA.";

          $('.filtroCategoriaProdutos').removeClass('d-none');
          $('.filtroCategoriaServicos').addClass('d-none');

          resgatarCategoriasProdutos(1);
          retornaAnunciosTotais(tipoAnuncio, null, null, null, null);

        }else if(tipoAnuncio == 2 && !$('.filtroCategoriaServicos').hasClass('d-none')){

          ajustarTela();

          tituloConteudo.innerHTML = "QUANTIDADE DE ANÚNCIOS DE SERVIÇOS CADASTRADOS NO SISTEMA.";

          $('.filtroCategoriaServicos').removeClass('d-none');
          $('.filtroCategoriaProdutos').addClass('d-none');

          resgatarCategoriasServicos(1);
          retornaAnunciosTotais(tipoAnuncio, null, null, null, null);
          
        }else if(tipoAnuncio == 3){

          ajustarTela();

          $('.configuracoes').removeClass('d-none');
          $('.configuracoes').addClass('d-flex');

          $('.filtroCategoriaProdutos').removeClass('d-flex');
          $('.filtroCategoriaProdutos').addClass('d-none');

          $('.filtroCategoriaServicos').removeClass('d-flex');
          $('.filtroCategoriaServicos').addClass('d-none');

          $('.filtroData').removeClass('d-flex');
          $('.filtroData').addClass('d-none');

          $('.filtroNomeAnunciante').removeClass('d-flex');
          $('.filtroNomeAnunciante').addClass('d-none');

          if($('.filtroIdUsuario').hasClass('d-none') && $('.filtroNomeUsuario').hasClass('d-none') && $('.filtroEmailUsuario').hasClass('d-none')){

            $('.filtroIdUsuario').removeClass('d-none');
            $('.filtroIdUsuario').addClass('d-flex');

            $('.filtroNomeUsuario').removeClass('d-none');
            $('.filtroNomeUsuario').addClass('d-flex');

            $('.filtroEmailUsuario').removeClass('d-none');
            $('.filtroEmailUsuario').addClass('d-flex');

          }

          tituloConteudo.innerHTML = "QUANTIDADE DE USUÁRIOS CADASTRADOS NO SISTEMA";
          retornarUsuarios(null, null, null);

        }else if(tipoAnuncio == 4){

          let divConfiguracoes1 = $('<div>').addClass('configuracoes d-flex justify-content-start col-12 border-bottom border-dark');
          let divConfiguracoes2 = $('<div>').addClass('configuracoes d-flex justify-content-start col-12 border-bottom border-dark mt-3');
          let divConfiguracoes3 = $('<div>').addClass('configuracoes d-flex justify-content-start col-12 border-bottom border-dark mt-3');
          let divConfiguracoes4 = $('<div>').addClass('configuracoes d-flex justify-content-start col-12 border-bottom border-dark mt-3');
          let divConfiguracoes5 = $('<div>').addClass('configuracoes d-flex justify-content-start col-12 border-bottom border-dark mt-3');

          $('.filtroAnuncios').removeClass('d-flex');
          $('.filtroAnuncios').addClass('d-none');

          if(!$('.conteudo').hasClass('overflow')){
            $('.conteudo').addClass('overflow');
          }

          if($('.conteudo').hasClass('p-3')){
            $('.conteudo').removeClass('p-3');
            $('.conteudo').addClass('p-4');
          }

          divConfiguracoes1 .append(`
            <div class="tituloConfiguracao col-5 d-flex justify-content-start align-items-center mb-3">
                <h7 class="fontTituloSecundario mulish m-0 ps-2">CADASTRAR NOVO USUÁRIO:</h7>
            </div>
            <div class="cadastroNovoUsuario mb-3 d-flex align-items-center">
                <button class="acoesADM btn btn-success  rounded-0 ms-2 w-100">
                    <p class="mb-2 pt-1" onclick="window.location.href='cadastrarPerfil.php?liberarNivelUsuario=1'">CADASTRAR USUÁRIOS</p>
                </button>
            </div>
          `);
      
          divConfiguracoes2.append(`
            <div class="tituloConfiguracao col-5 d-flex justify-content-start align-items-center mb-3">
              <h7 class="fontTituloSecundario mulish m-0 ps-2">CADASTRAR CATEGORIA (PRODUTOS):</h7>
            </div>
            <div class="acaoConfig col-7 mb-3 d-flex">
              <div class="input-group w-50 d-flex align-items-center justify-content-end p-1 pt-2 ps-2 pe-2">
                <input type="text" class="form-control h-100 rounded-0 bordaVerde" name="nSalvarCategoriaProduto" id="iSalvarCategoriaProduto">
                <div class="input-group-append h-100">
                  <button class="btn btn-outline-success h-100 rounded-0 p-2 salvarCategoriaProduto" type="button"><h7 class="fontTituloSecundario mulish">SALVAR</h7></button>
                </div>
              </div>
              <div class="w-50 d-flex flex-column justify-content-start align-items-center">
                <div class="label d-flex justify-content-center align-items-center"><label for="iCategoriaProdutoConfig">Categorias Produtos</label></div>
                <select name="nCategoriaProdutoConfig" id="iCategoriaProdutoConfig" class="form-control rounded-0 bordaVerde">
                </select>
              </div>
            </div>
          `);

          divConfiguracoes3.append(`
            <div class="tituloConfiguracao col-5 d-flex justify-content-start align-items-center mb-3">
              <h7 class="fontTituloSecundario mulish m-0 ps-2">CADASTRAR CATEGORIA (SERVIÇO):</h7>
            </div>
            <div class="acaoConfig col-7 mb-3 d-flex">
              <div class="input-group w-50 d-flex align-items-center justify-content-end p-1 pt-2 ps-2 pe-2">
                <input type="text" class="form-control h-100 rounded-0 bordaVerde" name="nSalvarCategoriaServico" id="iSalvarCategoriaServico">
                <div class="input-group-append h-100">
                  <button class="btn btn-outline-success h-100 rounded-0 p-2 salvarCategoriaServico" type="button"><h7 class="fontTituloSecundario mulish">SALVAR</h7></button>
                </div>
              </div>
              <div class="w-50 d-flex flex-column justify-content-start align-items-center">
                <div class="label d-flex justify-content-center align-items-center"><label for="iCategoriaServicoConfig">Categorias Serviços</label></div>
                <select name="nCategoriaServicoConfig" id="iCategoriaServicoConfig" class="form-control rounded-0 bordaVerde">
                </select>
              </div>
            </div>
          `);

          divConfiguracoes4.append(`
            <div class="tituloConfiguracao col-5 d-flex justify-content-start align-items-center mb-3">
              <h7 class="fontTituloSecundario mulish m-0 ps-2">REMOVER CATEGORIA (PRODUTOS):</h7>
            </div>
            <div class="acaoConfig col-7 mb-3 d-flex">
              <div class="input-group w-75 d-flex align-items-center justify-content-end p-1 pt-2 ps-2 pe-5">
                <input type="text" class="form-control h-100 rounded-0 bordaVermelha" name="nRemoverCategoriaProduto" id="iRemoverCategoriaProduto">
                <div class="input-group-append h-100">
                  <button class="btn btn-outline-danger h-100 rounded-0 p-2 removerCategoriaProduto" type="button"><h7 class="fontTituloSecundario mulish">REMOVER</h7></button>
                </div>
              </div>
            </div>
          `);

          divConfiguracoes5.append(`
            <div class="tituloConfiguracao col-5 d-flex justify-content-start align-items-center mb-3">
              <h7 class="fontTituloSecundario mulish m-0 ps-2">REMOVER CATEGORIA (SERVIÇOS):</h7>
            </div>
            <div class="acaoConfig col-7 mb-3 d-flex">
              <div class="input-group w-75 d-flex align-items-center justify-content-end p-1 pt-2 ps-2 pe-5">
                <input type="text" class="form-control h-100 rounded-0 bordaVermelha" name="nRemoverCategoriaServico" id="iRemoverCategoriaServico">
                <div class="input-group-append h-100">
                  <button class="btn btn-outline-danger h-100 rounded-0 p-2 removerCategoriaServico" type="button"><h7 class="fontTituloSecundario mulish">REMOVER</h7></button>
                </div>
              </div>
            </div>
          `);

          tituloConteudo.innerHTML = "CONFIGURAÇÕES SISTEMA";

          $('#conteudo').html(divConfiguracoes1).append(divConfiguracoes2).append(divConfiguracoes3).append(divConfiguracoes4).append(divConfiguracoes5);

          resgatarCategoriasProdutos(2);
          resgatarCategoriasServicos(2);

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