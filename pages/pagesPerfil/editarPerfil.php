<?php
ini_set('display_errors', 0);
session_start();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/styles/pagesPerfil/editarPerfil.css">
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
        <h4>EDITAR PERFIL</h4>
      </div>
      <div class="container col-sm-10 mt-3 d-flex flex-row" style="height: 480px">
        <div class="containerEsquerda col-sm-4 h-100 d-flex flex-column justify-content-center align-items-center">
          <div class="imagemContainer">
            <form action="../../config/editarImagem.php?idUsuario=<?php echo $_SESSION['id_usuario']?>" method="POST" enctype="multipart/form-data" id="uploadImagem">
              <?php 
                if($_SESSION['id_usuario'] != "" && isset($_SESSION['foto_usuario'])){
                  ?><label for="iFotoPerfil"><img src="../../assets/imagensUsuarios/<?php echo $_SESSION['foto_usuario']?>" width="100px" height="100px" id="ImagemUsuario"></label><?php
                }else{
                  ?><label for="iFotoPerfil"><img src="../../assets/imagens_padrao/contaHeader.png" width="100px" height="100px" id="ImagemUsuario"></label><?php
                }
            ?>
            <input type="file" accept="image/*" id="iFotoPerfil" name="nFotoPerfil"> 
            </form>
          </div>
        </div>
        <div class="containerDireita col-sm-8 d-flex flex-column h-100 justify-content-center align-items-center">
        <form class="col-sm-11 h-100" id="formEditarInformacoesUsuario" >
          <div class="containerInformacoesUsuario col-sm-12 d-flex justify-content-between align-items-center" style="height: 75%">
            <div class="coluna col-sm-3 d-flex flex-column justify-content-center" style="height: 186px">
                <div class="Nome">
                  <div class="label d-flex justify-content-center align-items-center"><label for="iNomeUsuario">Nome:</label></div>
                  <input class="form-control" type="text" id="iNomeUsuario" name="nNomeUsuario" value="">
                </div>
                <div class="Email mt-5">
                  <div class="label d-flex justify-content-center align-items-center"><label for="iEmail">Email:</label></div>
                  <input class="form-control" type="text" id="iEmail" name="nEmail" value="">
                </div>
            </div>
            <div class="coluna col-sm-3 d-flex flex-column justify-content-center" style="height: 186px">
              <div class="Estado">
                <div class="label d-flex justify-content-center align-items-center"><label for="iEstadoUsuario">Estado:</label></div>
                <select name="nEstadoUsuario" id="iEstadoUsuario" class="form-control mb-1">
                </select>
              </div>
              <div class="cidade mt-5">
                <div class="label d-flex justify-content-center align-items-center"><label for="iCidadeUsuario">Cidade:</label></div>
                <select name="nCidadeUsuario" id="iCidadeUsuario" class="form-control" disabled>
                </select>
              </div>
            </div>
            <div class="coluna col-sm-3 d-flex flex-column justify-content-center" style="height: 186px">
              <div class="senha">
                <div class="label d-flex justify-content-center align-items-center"><label for="iSenhaUsuario">Senha:</label></div>
                <input class="form-control" type="text" id="iSenhaUsuario" name="nSenhaUsuario">
              </div>
              <div class="Localidade mt-5">
                <div class="label d-flex justify-content-center align-items-center"><label for="iTelefoneUsuario">Telefone:</label></div>
                <input class="form-control" type="text" id="iTelefoneUsuario" name="nTelefoneUsuario">
              </div>
            </div>  
            </div>
            <div class="linha col-sm-12 bg-success" style="height: 0.5%"></div>
            <div class="acoesPerfil col-sm-12 d-flex flex-row justify-content-between align-items-center" style="height: 24.5%">
              <button type="submit" class="btn btn-success  editarPerfil col-sm-12"><p>CONFIRMA ALTERAÇÕES</p></button>
              <input type="text" class="d-none" value="<?php echo $_SESSION['id_usuario']?>" id="identificadorUsuario">
            </div>
          </div>
          <input class="form-control d-none" type="text" id="iNomeEstadoUsuario" name="nNomeEstadoUsuario" >
          <input class="form-control d-none" type="text" id="iNomeCidadeUsuario" name="nNomeCidadeUsuario" >
        </form>
      </div>
    </section>
  </body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  
  <script>

    jQuery(document).ready(function() {
        
      var nomeEstadoSelecionado = "";
      var nomeCidadeSelecionado = "";

      // Função para fazer a requisição à API e preencher o campo select
      function preencherEstados() {
        // URL da API
        let url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados';

        // Faz a requisição à API
        fetch(url)
        .then(function(response) {
          // Converte a resposta em JSON
          return response.json();
        })
        .then(function(estados) {

          let selectEstado = document.getElementById('iEstadoUsuario');
          selectEstado.innerHTML = '';

          for (let i = 0; i < estados.length; i++) {

            let optionEstado = document.createElement('option');
            
            optionEstado.classList.add('estado-option');
            optionEstado.id = 'estado-'+i;

            optionEstado.value = estados[i].id;
            optionEstado.text = estados[i].nome;
            selectEstado.appendChild(optionEstado);

          }

        })
        .catch(function(error) {
          console.error('Erro ao preencher os estados:', error);
        });
      }

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

          $("#iCidadeUsuario").removeAttr("disabled");

        })
        .catch(function(error) {
          console.error('Erro ao preencher os estados:', error);
        });
      });

      $('#iCidadeUsuario').on('change', function() {
        nomeCidadeSelecionado = $(this).find('option:selected')[0].innerText;
      });

      document.getElementById('formEditarInformacoesUsuario').addEventListener('submit', function(e) {
          
        let nome = document.getElementById("iNomeUsuario").value;
        let telefone = document.getElementById('iTelefoneUsuario').value;
        let email = document.getElementById('iEmail').value;
        let senha = document.getElementById('iSenhaUsuario').value;
        let regexTelefone = /^\(?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
        let regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        let regexSenha = /^(?=.*[0-9])(?=.*[$@#])[a-zA-Z0-9$@#]{6,}$/;
        let cont = 0;
        let message = "";
        let formData = null 
        let idUsuario = $('#identificadorUsuario').val();

        if(nome != "" && nome.length <= 4){
          cont++;
          message += "Por favor, o nome deve conter no minimo 4 digitos! <br><br>";
        }

        if(telefone != "" && !regexTelefone.test(telefone)) {
          cont++;
          message += "Por favor, insira um número de telefone válido! <br><br>";
        }

        if(email != "" && !regexEmail.test(email)) {
          cont++;
          message += "Por favor, insira um endereço de e-mail válido! <br><br>";
        }

        if(senha != "" && !regexSenha.test(senha)) {
          cont++;
          message += "Por favor, insira uma senha com pelo menos 6 caracteres<br>";
          message += "Inclua pelo menos um número e um caractere especial como '$'<br>";
        }

        $('#iNomeEstadoUsuario').val(nomeEstadoSelecionado);
        $('#iNomeCidadeUsuario').val(nomeCidadeSelecionado);

        e.preventDefault();

        if(cont > 0){

          Swal.fire({
            title: "Crendenciais Incorretas",
            html: message,
            icon: "error"
          });

        }else{

          formData = new FormData(this); 

          $.ajax({
              method: "POST",
              url: "../../config/editarInformacoesUsuario.php?idUsuario="+idUsuario,
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
                    title: 'Boa!!! 😄',
                    text: response.message,
                    icon: 'success'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = 'perfilUsuario.php';
                    }
                  });
                }
              }
          });
        }   
      });

      //Função feita em Java Script PURO que permite a alteração automática da foto do usuário no front!
      $('#iFotoPerfil').on('change', function() {

        let input = this;
        if (input.value.length > 0) {
          let fileReader = new FileReader();
          fileReader.onload = function(data) {
              document.querySelector(`#ImagemUsuario`).src = data.target.result;
          };
          fileReader.readAsDataURL(input.files[0]);
        }

        //Função feita em Java Script PURO (Sem JQuery), que retorna no 'Swal' a requesição da mudança de foto de perfil do usuário! 
        $('#uploadImagem').on('change', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);
            let xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action, true);
            xhr.onload = function() {
              if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: response.message
                  });
                  $('#fotoUsuarioHeader').attr('src', `/Projetos/Desapegados/assets/imagensUsuarios/${response.foto}`);
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: response.message
                  });
                }
              }
            };
            xhr.onerror = function() {
              Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro na requisição'
              });
            };
            xhr.send(formData);
            
        });

      });

      preencherEstados();

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
