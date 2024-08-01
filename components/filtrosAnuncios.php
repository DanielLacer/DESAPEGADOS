<div class="containerFiltro col-12 d-flex bg-white align-items-center p-4">
    <div class="filtros col-1 d-flex bg-white justify-content-center align-items-center">
        <h5>Filtros:</h5>
    </div>
    <div class="filtros filtroData col-2 d-flex">
        <input type="text" data-provide="datepicker" class="input-filtros col-sm-12 border border-success-subtle border-2 ps-3" style="height: 39.2px" id="iDataPostagem" name="nDataPostagem" placeholder="Data de Postagem">
    </div>
    <div class="filtros filtroNomeAnunciante col-2 d-flex">
        <input class="input-filtros form-control border border-success-subtle border-2 rounded-0" id="iAnunciante" name="nAnunciante" type="text" placeholder="Nome do Anunciante..." >
    </div>
    <?php 
    if ($_GET['tipoAnuncio'] == 1) {
        ?>
        <div class="filtros filtroCategoriaProdutos col-2 d-flex">
            <select name="nCategoriaProduto" id="iCategoriaProduto" class="input-filtros form-control option border border-success-subtle border-2 rounded-0" style="height: 39.2px"></select>
        </div>
        <?php
    } else {
        ?>
        <div class="filtros filtroCategoriaServicos col-2 d-flex">
            <select  name="nCategoriaServico" id="iCategoriaServico" class="input-filtros form-control option border border-success-subtle border-2 rounded-0" style="height: 39.2px"></select>
        </div>
        <?php
    }
    ?>
    <div class="filtros filtrar col-1 d-flex">
        <button type="button" class="btn btn-success rounded-0" id="iFiltrar" name="nFiltrar">FILTRAR</button>
    </div>
</div>

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