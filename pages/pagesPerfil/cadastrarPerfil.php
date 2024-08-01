<?php
ini_set('display_errors', 0);
session_start(); 
require '../../config/conexao.php';
?>

<!doctype html>
<html lang="PT-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/styles/pagesPerfil/cadastroPerfil.css">
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
      <div class="tituloPerfil d-flex justify-content-center col-sm-12">
        <h4>CADASTRO USUÁRIO</h4>
      </div>
      <div class="container col-sm-10 mt-3 d-flex flex-row" style="height: 480px">
        <div class="containerUnico col-12 d-flex flex-column h-100 justify-content-center align-items-center">
        <form id="formCadastro" class="col-11 h-100">
          <div class="containerInformacoesUsuario col-sm-12 d-flex justify-content-between align-items-center" style="height: 75%">
            <div class="coluna col-3 d-flex flex-column" style="height: 270px">
                <div class="Nome">
                  <div class="label d-flex justify-content-center align-items-center"><label for="iNomeUsuario">Nome:</label></div>
                  <input class="form-control" type="text" id="iNomeUsuario" name="nNomeUsuario" value="" placeholder="Daniel" >
                </div>
                <div class="Email mt-5">
                  <div class="label d-flex justify-content-center align-items-center"><label for="iEmail">Email:</label></div>
                  <input class="form-control" type="text" id="iEmail" name="nEmail" placeholder="seuemail@email.com">
                </div>
                
                <div class="nivelUsuario mt-5">
                  <div class="label d-flex justify-content-center align-items-center mb-1"><label for="iNivelUsuario">Nivel do usuário:</label></div>
                  <select name="nNivelUsuario" id="iNivelUsuario" class="form-control">
                    <option value="1" >Usuário</option>
                    <option value="2" >Funcionário</option>
                  </select>
                </div>
            </div>
            <div class="coluna col-3 d-flex flex-column" style="height: 270px">
                <div class="Localidade">
                  <div class="label d-flex justify-content-center align-items-center"><label for="iTelefoneUsuario">Telefone:</label></div>
                  <input class="form-control" type="text" id="iTelefoneUsuario" name="nTelefoneUsuario" placeholder="4744028922">
                </div>
                <div class="Estado mt-5">
                <div class="label d-flex justify-content-center align-items-center"><label for="iEstadoUsuario">Estado:</label></div>
                  <select name="nEstadoUsuario" id="iEstadoUsuario" class="form-control">
                  </select>
                </div>
            </div>
            <div class="coluna col-3 d-flex flex-column" style="height: 270px">
                <div class="senha">
                  <div class="label d-flex justify-content-center align-items-center"><label for="iSenhaUsuario">Senha:</label></div>
                  <input class="form-control" type="text" id="iSenhaUsuario" name="nSenhaUsuario" value="" placeholder="Abc321">
                </div>
                <div class="cidade mt-5 d-none">
                  <div class="label d-flex justify-content-center align-items-center"><label for="iCidadeUsuario">Cidade:</label></div>
                  <select name="nCidadeUsuario" id="iCidadeUsuario" class="form-control">
                  </select>
                </div>
            </div>  
            </div>
            <div class="linha col-12 bg-success" style="height: 0.5%"></div>
            <div class="acoesPerfil col-sm-12 d-flex flex-row justify-content-between align-items-center" style="height: 24.5%">
              <button class="btn btn-success  cadastrarPerfil col-sm-12" type="submit" >CADASTRAR PERFIL</button>
            </div>
          </div>
          <input class="form-control d-none" type="text" id="iNomeEstadoUsuario" name="nNomeEstadoUsuario" >
          <input class="form-control d-none" type="text" id="iNomeCidadeUsuario" name="nNomeCidadeUsuario" >
          <input class="form-control d-none" type="text" id="iUsuarioAdm" name="nUsuarioAdm" >
        </form>
      </div>
    </section>

    <div class="toast position-fixed bottom-0 end-0 m-2" id="cadastroToast" role="alert" aria-live="assertive" aria-atomic="true" ata-animation="true" data-autohide="true" data-delay="3000" >
      <div class="toast-header text-bg-warning">
        <strong class="me-auto">Aviso</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Por favor, preencha o estado e a cidade do novo usuário!
      </div>
    </div>

  </body>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function(){

      var nomeEstadoSelecionado = "";
      var nomeCidadeSelecionado = "";
      let urlParams = new URLSearchParams(window.location.search);
      let liberarNivelUsuario = parseInt(urlParams.get('liberarNivelUsuario'));

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

              $(".cidade").removeClass("d-none");

            })
            .catch(function(error) {
              console.error('Erro ao preencher os estados:', error);
            });
      });

      $('#iCidadeUsuario').on('change', function() {
        nomeCidadeSelecionado = $(this).find('option:selected')[0].innerText;
      });

      $("#formCadastro").on('submit', function(e) {
        e.preventDefault();
          
        let nome = document.getElementById("iNomeUsuario").value;
        let telefone = document.getElementById('iTelefoneUsuario').value;
        let email = document.getElementById('iEmail').value;
        let senha = document.getElementById('iSenhaUsuario').value;
        let cidade = $('#iNomeCidadeUsuario').val(nomeCidadeSelecionado);
        let estado = $('#iNomeEstadoUsuario').val(nomeEstadoSelecionado);
        let regexTelefone = /^\(?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
        let regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        let regexSenha = /^(?=.*[0-9])(?=.*[$@#])[a-zA-Z0-9$@#]{6,}$/;
        let cont = 0;
        let message = "";
        let formData = null;

        if(nome == "" && nome.length <= 4){
          cont++;
          message += "Por favor, o nome deve conter no mínimo 4 digitos! <br><br>";
        }

        if(!regexTelefone.test(telefone)) {
          cont++;
          message += "Por favor, insira um número de telefone válido! <br><br>";
        }

        if(!regexEmail.test(email)) {
          cont++;
          message += "Por favor, insira um endereço de e-mail válido! <br><br>";
        }

        if(!regexSenha.test(senha)) {
          cont++;
          message += "Por favor, insira uma senha com pelo menos 6 caracteres, incluindo um número e um caractere especial.<br>";
        }
        
        if(cont > 0){

          Swal.fire({
            title: "Crendenciais Incorretas",
            html: message,
            icon: "error"
          });

        }else if(estado.val() != "" && estado.val() != null && cidade.val() != "" && cidade.val() != null){

          $('#iUsuarioAdm').val(liberarNivelUsuario);
          formData = new FormData(this);
          
          $.ajax({
            method: "POST",
            url: "../../config/cadastrarUsuario.php",
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
                    if (liberarNivelUsuario === 0) {
                      window.location.href = '../../index.php';
                    } else if (liberarNivelUsuario === 1) {
                      window.location.href = 'areaAdm.php?tipoAnuncio=1';
                    }
                  }
                });
              }
            }
          });

        }else{
          $("#cadastroToast").toast("show");
        }
          
      });

      $('#iLocalidadeUsuario').mask('(00) 0000-0000');
      $('#iEmail').mask("A", {
          translation: {
              "A": { pattern: /[\w@\-.+]/, recursive: true }
          }
      });

      $('#cadastroToast').toast({
        autohide: true,
        delay: 3000
      });

      if(liberarNivelUsuario == 0){
        $('.nivelUsuario').addClass('d-none');
      }else if(liberarNivelUsuario == 1 && $('.nivelUsuario').hasClass('d-none')){
        $('.nivelUsuario').removeClass('d-none');
      }

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
