<header>
  <nav class="navbar navbar-expand-lg navbar-light m-0" style="background-color: #3DED3F;">
    <!-- Título à esquerda -->
    <div class="col-3 d-flex justify-content-center align-items-center h-100">
      <a href="/Projetos/Desapegados/"><h2>DESAPEGADOS</h2></a>
    </div>

    <!-- Barra de Pesquisa no centro com ícone à esquerda -->
    <div class="pesquisa col-7 my-2 my-lg-0 p-4">
    <?php 
      if ($_GET['tipoAnuncio'] == 1 || $_GET['tipoAnuncio'] == 2) {
        ?>
          <form class="form-inline" style="margin-right: 5%;">
              <div class="input-group justify-content-start">
                  <input class="form-control custom-input" type="search" placeholder="Pesquisar Anuncio..." id="iPesquisaAnuncio" name="nPesquisaAnuncio">
                  <span class="input-group-append custom-span">
                      <button class="pesquisarButton btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5 custom-button" type="button">
                          <i class="fa fa-search custom-icon"></i>
                      </button>
                  </span>
              </div>
          </form>
        <?php
      }
    ?>
    </div>
    
    <!-- Seção de Favoritos à esquerda -->
    <div class="col-1 d-flex flex-row favoritos justify-content-center align-items-center favoritos" style="height: 60px;">
      <form method="post" action="/Projetos/Desapegados/config/loggout.php" class="headerHover d-flex flex-column">
        <div class="loggout d-flex justify-content-center mt-1">
          <button type="submit" name="logout" class="btn btn-outline-dark fs-7 d-flex justify-content-center align-items-center"><i class="bi bi-box-arrow-left me-1"></i>SAIR</button>
        </div>
      </form>  
    </div>
    <div class="col-1 d-flex justify-content-center contaIcone" style="height: 60px;">
      <div class="d-flex headerHover justify-content-center align-items-center">
        <a href="/Projetos/Desapegados/pages/pagesPerfil/perfilUsuario.php" class="imagemContaUsuario">
          <?php 
              if($_SESSION['id_usuario'] != "" && isset($_SESSION['foto_usuario'])){
                ?><img src="/Projetos/Desapegados/assets/imagensUsuarios/<?php echo $_SESSION['foto_usuario']?>" width="50px" height="50px" id="fotoUsuarioHeader"><?php
              }else{
                ?><img src="/Projetos/Desapegados/assets/imagens_padrao/contaHeader.png" width="50px" height="50px" id="fotoUsuarioHeader"><?php
              }
          ?>
        </a>
      </div>
    </div>
  </nav>
</header>

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


