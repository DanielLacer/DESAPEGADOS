<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'resgatarCategoriasProdutos') {

    if($_GET['id_produto'] != null){
        $retorno = resgatarCategoriaProdutoEspecifico($conn, $_GET['id_produto']);
        array_push($retorno, resgatarCategoriasProdutos($conn));
    }else{
        $retorno = resgatarCategoriasProdutos($conn);
    }

    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'resgatarCategoriasServicos') {

    if($_GET['id_servico'] != null){
        $retorno =  resgatarCategoriaServicoEspecifico($conn, $_GET['id_servico']);
        array_push($retorno, resgatarCategoriasServicos($conn));
    }else{
        $retorno = resgatarCategoriasServicos($conn);
    }

    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'resgatarMeusAnuncios') {
    $retorno = resgatarMeusAnuncios($conn, $_GET['tipoAnuncio'], $_GET['dataPostagem'], $_GET['categoriaProduto'], $_GET['categoriaServico']);
    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'retornaImagensAnuncio') {
    $retorno = retornaImagensAnuncio($conn, $_GET['tipoAnuncio'], $_GET['idAnuncio']);
    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'resgatarUsuarios') {
    $retorno = retornaUsuarios($conn, $_GET['idUsuario'], $_GET['nomeUsuario'], $_GET['emailUsuario']);
    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'retornaTodosAnuncioAdmin') {
    $retorno = retornaTodosAnuncioAdmin($conn, $_GET['tipoAnuncio'], $_GET['dataPostagem'], $_GET['categoriaProduto'], $_GET['categoriaServico'], $_GET['nomeAnunciante']);
    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'retornaTodosAnuncioProduto') {
    $retorno = retornaTodosAnuncioProduto($conn, $_GET['nomeDoProduto'], $_GET['dataPostagem'], $_GET['categoriaProduto'], $_GET['nomeAnunciante']);
    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'retornaTodosAnuncioServico') {
    $retorno = retornaTodosAnuncioServico($conn, $_GET['nomeDoServico'], $_GET['dataPostagem'], $_GET['categoriaServico'], $_GET['nomeAnunciante']);
    echo json_encode($retorno);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'retornarNivelUsuario') {
    $retorno = retornarNivelUsuario($conn, $_GET['idUsuario']);
    echo json_encode($retorno);
}

function carregarDadosUsuario($conn) {

    $id_usuario = $_SESSION['id_usuario'];
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, telefone_usuario, email_usuario, senha_usuario, data_cadastro, estado_usuario, cidade_usuario, nivel_usuario, foto_usuario FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $row;
    } else {
        return null; 
    }
}

function resgatarCategoriasProdutos($conn){

    $categorias_array = array();

    $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT * FROM categorias_produto");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $categorias_array[] = $row['nome_categoria'].' | '.$row['id_categoria']; 
        }

        $stmt->close();
        $conn->close();
    }

    return $categorias_array;
}

function resgatarCategoriasServicos($conn){

    $categorias_array = array();

    $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT * FROM categorias_servico");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $categorias_array[] = $row['nome_categoria'].' | '.$row['id_categoria']; 
        }

        $stmt->close();
        $conn->close();
    }

    return $categorias_array;
}

function resgatarCategoriaProdutoEspecifico($conn, $id_produto){
    
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare("SELECT ctp.nome_categoria FROM produtos pro INNER JOIN categorias_produto ctp ON ctp.id_categoria = pro.id_categoria_produto WHERE pro.id_produto = ?");
    $stmt->bind_param("s", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $categoria_produto = $result->fetch_assoc();
        $stmt->close();
        return $categoria_produto; 
    } else {
        return null; 
    }
}

function resgatarCategoriaServicoEspecifico($conn, $id_servico){
    
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare("SELECT cts.nome_categoria FROM servicos sev INNER JOIN categorias_servico cts ON cts.id_categoria = sev.id_categoria_servico WHERE sev.id_servico = ?");
    $stmt->bind_param("s", $id_servico);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $categoria_servico = $result->fetch_assoc();
        $stmt->close();
        return $categoria_servico; 
    } else {
        return null; 
    }
}

function resgatarMeusAnuncios($conn, $tipo_anuncio, $data_postagem, $categoria_produto, $categoria_servico){
    
    $id_usuario = $_SESSION['id_usuario'];
    $sql = "";
    $retorno = "";
    $params = array();
    $types = '';
    
    if($tipo_anuncio == 1){

        $sql = "SELECT * FROM produtos WHERE id_usuario LIKE ?";
        $id_usuario = '%'.$id_usuario.'%';
        $params[] = &$id_usuario; 
        $types .= 's';

        if($categoria_produto != null && $categoria_produto != "todos"){
            $sql .= " AND id_categoria_produto  = ?";
            $params[] = &$categoria_produto; 
            $types .= 's';
        }

        if($data_postagem != null){
            $data = DateTime::createFromFormat('m/d/Y', $data_postagem);
            $data_formatada = $data->format('Y-m-d');
            $sql .= " AND data_postagem = ?";
            $params[] = &$data_formatada; 
            $types .= 's';
        }

    }else{

        $sql = "SELECT * FROM servicos WHERE id_usuario LIKE ?";
        $id_usuario = '%'.$id_usuario.'%';
        $params[] = &$id_usuario; 
        $types .= 's';

        if($categoria_servico != null && $categoria_servico != "todos"){
            $sql .= " AND id_categoria_servico = ?";
            $params[] = &$categoria_servico; 
            $types .= 's';
        }

        if($data_postagem != null){
            $data = DateTime::createFromFormat('m/d/Y', $data_postagem);
            $data_formatada = $data->format('Y-m-d');
            $sql .= " AND data_postagem = ?";
            $params[] = &$data_formatada; 
            $types .= 's';
        }
    }

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);

    array_unshift($params, $types);
    call_user_func_array(array($stmt, 'bind_param'), $params);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0 && $tipo_anuncio == 1) { //Produtos

        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();

            $imagensAnuncio = explode(";", $row['fotos_produto']);

            $retorno .= ' <div class="conteudoAnuncio d-flex justify-content-between col-12 p-2 mb-2 mt-2 border border-3 border-secondary">';
            $retorno .= '   <div class="imagemAnuncio col-3 ms-1 rounded p-1 border border-success">';
            $retorno .= '     <img src="../../assets/imagensAnunciosProdutos/'.$imagensAnuncio[0].'" class="w-100 h-100 rounded">';
            $retorno .= '   </div>';
            $retorno .= '   <div class="informacoesAnuncio col-8 d-flex flex-column align-items-center justify-content-between me-4">';
            $retorno .= '     <div class="tituloAnuncio mulish col-12 border-bottom border-success m-0 text-start text-black mt-2">';
            $retorno .= '       '.$row['nome_produto'].'';
            $retorno .= '     </div>';
            $retorno .= '     <div role="button" class="opcoesAnuncio col-12 d-flex align-items-end">';
            $retorno .= '       <div class="excluirAnuncio h-100 col-3 border border-danger ps-1 d-flex align-items-center">';
            $retorno .= '         <i class="bi bi-trash3 text-danger"></i>';
            $retorno .= '         <p class="m-0 text-center text-danger w-100">Excluir Anúncio</p>';
            $retorno .= '       </div>';
            $retorno .= '       <a href="../editarAnuncioProduto.php?id_produto='.$row['id_produto'].'" class="editarAnuncio ms-3 h-100 col-3 border border-success ps-1 d-flex  align-items-center">';
            $retorno .= '         <i class="bi bi-pencil-square text-success fs-5"></i>';
            $retorno .= '         <p class="m-0 text-center text-success w-100">Editar Anúncio</p>';
            $retorno .= '       </a>';          
            $retorno .= '     </div>';
            $retorno .= '   </div>';
            $retorno .= '   <input type="text" value="'.$row['id_produto'].'" class="d-none" id="identificadorAnuncio">';
            $retorno .= ' </div>';

        }

        $stmt->close();
        $conn->close();

        return $retorno; 

    }else if($result->num_rows > 0 && $tipo_anuncio == 2){ //Servicos

        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();

            $imagensAnuncio = explode(";", $row['fotos_servico']);

            $retorno .= ' <div class="conteudoAnuncio d-flex justify-content-between col-12 p-2 mb-2 mt-2 border border-3 border-secondary">';
            $retorno .= '   <div class="imagemAnuncio col-3 ms-1 rounded p-1 border border-success">';
            $retorno .= '     <img src="../../assets/imagensAnunciosServicos/'.$imagensAnuncio[0].'" class="w-100 h-100 rounded">';
            $retorno .= '   </div>';
            $retorno .= '   <div class="informacoesAnuncio col-8 d-flex flex-column align-items-center justify-content-between me-4">';
            $retorno .= '     <div class="tituloAnuncio mulish col-12 border-bottom border-success m-0 text-start text-black mt-2">';
            $retorno .= '       '.$row['nome_servico'].'';
            $retorno .= '     </div>';
            $retorno .= '     <div role="button" class="opcoesAnuncio col-12 d-flex align-items-end">';
            $retorno .= '       <div class="excluirAnuncio h-100 col-3 border border-danger ps-1 d-flex align-items-center">';
            $retorno .= '         <i class="bi bi-trash3 text-danger"></i>';
            $retorno .= '         <p class="m-0 text-center text-danger w-100">Excluir Anúncio</p>';
            $retorno .= '       </div>';
            $retorno .= '       <a href="../editarAnuncioServico.php?id_servico='.$row['id_servico'].'" class="editarAnuncio ms-3 h-100 col-3 border border-success ps-1 d-flex align-items-center">';
            $retorno .= '         <i class="bi bi-pencil-square text-success fs-5"></i>';
            $retorno .= '         <p class="m-0 text-center text-success w-100">Editar Anúncio</p>';
            $retorno .= '       </a>';          
            $retorno .= '     </div>';
            $retorno .= '   </div>';
            $retorno .= '   <input type="text" value="'.$row['id_servico'].'" class="d-none" id="identificadorAnuncio">';
            $retorno .= ' </div>';

        }

        $stmt->close();
        $conn->close();

        return $retorno;

    }else{

        $retorno = 'nenhumAnuncioEncontrado';
        
        $stmt->close();
        $conn->close();
        
        return $retorno;
    }
}

function carregarAnuncioProduto($conn, $id_produto, $exibir_anunciante){
    
    $stmt = $conn->stmt_init();

    if($exibir_anunciante == true){
        $stmt = $conn->prepare("SELECT * FROM produtos pro INNER JOIN usuarios usu ON pro.id_usuario = usu.id_usuario WHERE pro.id_produto = ?");
    }else{
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id_produto = ?");
    }

    $stmt->bind_param("s", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $row;
    } else {
        return null;
    }
    
}

function carregarAnuncioServico($conn, $id_servico, $exibir_anunciante){
    
    $stmt = $conn->stmt_init();

    if($exibir_anunciante == true){
        $stmt = $conn->prepare("SELECT * FROM servicos sev INNER JOIN usuarios usu ON sev.id_usuario = usu.id_usuario WHERE sev.id_servico = ?");
    }else{
        $stmt = $conn->prepare("SELECT * FROM servicos WHERE id_servico = ?");
    }

    $stmt->bind_param("s", $id_servico);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $row;
    } else {
        return null;
    }
    
}

function retornaImagensAnuncio($conn, $tipo_anuncio, $id_anuncio){

    if($tipo_anuncio == 1){
        $sql = "SELECT fotos_produto FROM produtos WHERE id_produto = ?";
    }else{
        $sql = "SELECT fotos_servico FROM servicos WHERE id_servico = ?";
    }

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_anuncio);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if($tipo_anuncio == 1){
            $imagensAnuncio = array_filter(explode(";", $row['fotos_produto']));
        }else{
            $imagensAnuncio = array_filter(explode(";", $row['fotos_servico']));
        }

        $stmt->close();
        $conn->close();
        return $imagensAnuncio;
    } else {
        return null;
    }
}

function retornaUsuarios($conn, $id_usuario, $nome_usuario, $email_usuario){
    
    $sql = "SELECT * FROM usuarios";
    $condicaoSql = false;
    $params = array();
    $types = '';
    $retorno = '';

    if($id_usuario != "" && $id_usuario != null){
        $sql .= " WHERE id_usuario LIKE ?";
        $condicaoSql = true;
        $id_usuario = '%'.$id_usuario.'%';
        $params[] = &$id_usuario; 
        $types .= 's';
    }

    if($nome_usuario != "" && $nome_usuario != null){

        if($condicaoSql == true){
            $sql .= " AND nome_usuario LIKE ?";
        }else{
            $sql .= " WHERE nome_usuario LIKE ?";
            $condicaoSql = true;
        }

        $nome_usuario = '%'.$nome_usuario.'%';
        $params[] = &$nome_usuario; 
        $types .= 's';
 
    }

    if($email_usuario != "" && $email_usuario != null){

        if($condicaoSql == true){
            $sql .= " AND email_usuario LIKE ?";
        }else{
            $sql .= " WHERE email_usuario LIKE ?";
            $condicaoSql = true;
        }

        $email_usuario = '%'.$email_usuario.'%';
        $params[] = &$email_usuario; 
        $types .= 's';

    }
    
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);

    if($condicaoSql == true){
        array_unshift($params, $types);
        call_user_func_array(array($stmt, 'bind_param'), $params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { //Usuários

        $retorno = '<table class="table table-striped mt-2" id="myTable">';
        $retorno .= '  <thead>';
        $retorno .= '    <tr class="text-white" style="background-color: #3DED3F !important;">';
        $retorno .= '      <th class=" align-middle text-start text-nowrap colorfy">ID Usuário</th>';
        $retorno .= '      <th class=" align-middle text-start text-nowrap colorfy">Nome Usuário</th>';
        $retorno .= '      <th class=" align-middle text-start text-nowrap colorfy">Email Usuário</th>';
        $retorno .= '      <th class=" align-middle text-start text-nowrap colorfy">Telefone</th>';
        $retorno .= '      <th class=" align-middle text-start text-nowrap colorfy">Data Cadastro</th>';
        $retorno .= '      <th class=" align-middle text-start text-nowrap colorfy">Nível</th>';
        $retorno .= '      <th class=" align-middle text-start text-nowrap colorfy">Excluir</th>';
        $retorno .= '    </tr>';
        $retorno .= '  </thead>';
        $retorno .= '  <tbody class="usuarios">';

        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();

            $retorno .= '<tr>';
            $retorno .= '  <td class="id_celulas" style="width: 30%;" ><p class="fontCelulas m-0">'.$row['id_usuario'].'</p></td>';
            $retorno .= '  <td class="nome_celulas" style="width: 30%;" ><p class="fontCelulas m-0">'.$row['nome_usuario'].'</p></td>';
            $retorno .= '  <td class="email_celulas" style="width: 30%;" ><p class="fontCelulas m-0">'.$row['email_usuario'].'</p></td>';
            $retorno .= '  <td class="telefone_celulas" style="width: 10%;" ><p class="fontCelulas m-0">'.$row['telefone_usuario'].'</p></td>';
            $retorno .= '  <td class="data_celulas" style="width: 10%;" ><p class="fontCelulas text-center m-0">'.$row['data_cadastro'].'</p></td>';
            $retorno .= '  <td class="nivel_celulas" style="width: 10%;" >'; 
            
            if($_SESSION['id_usuario'] != $row['id_usuario']){
                $retorno .= '<a role="button" class="ms-2 editarNivelUsuario" data-bs-toggle="modal" data-bs-target="#editarNivelModal" title="Editar nível da permissão desse usuário no sistema."><i class="bi bi-key"></i></a>';
            }
            
            $retorno .= '  </td>';
            $retorno .= '  <td class="excluir_celulas" style="width: 10%;" >';

            if($_SESSION['id_usuario'] != $row['id_usuario']){
                $retorno .= '<p class="d-none" id="identificadorUsuario">'.$row['id_usuario'].'</p>';         
                $retorno .= '<a role="button" class="me-2 excluirUsuario" title="Excluir esse usuário do sistema."><i class="bi bi-trash3 fs-5"></i></a>';
            }
            
            $retorno .= '  </td>';
            $retorno .= '</tr>';

        }

        $stmt->close();
        $conn->close();

        $retorno .= '  </tbody>';
        $retorno .= '</table>';

        $retorno .= '<div class="rodapeTable d-flex col-2 justify-content-center align-items-center border border-success border-bottom">';
        $retorno .= '  <div id="prev" class="d-flex col-4 justify-content-center align-items-center">';
        $retorno .= '    <i class="bi bi-arrow-left"></i>';
        $retorno .= '  </div>';
        $retorno .= '  <span id="page-num" class="d-flex col-4 justify-content-center align-items-center"></span>';
        $retorno .= '  <div id="next" class="d-flex col-4 justify-content-center align-items-center">';
        $retorno .= '    <i class="bi bi-arrow-right"></i>';
        $retorno .= '  </div>';
        $retorno .= '</div>';

        return $retorno;

    }else{

        $retorno = 'filtrosIncorretos';
        $stmt->close();
        $conn->close();

        return $retorno;

    }
    
}

function retornaTodosAnuncioAdmin($conn, $tipo_anuncio, $data_postagem, $categoria_produto, $categoria_servico, $nome_anunciante){

    $sql = "";
    $retorno = "";
    $condicaoSql = false;
    $params = array();
    $types = '';
    
    if($tipo_anuncio == 1){

        $sql = "SELECT pro.fotos_produto, pro.nome_produto, pro.id_produto, pro.data_postagem, usu.nome_usuario FROM produtos pro INNER JOIN usuarios usu ON pro.id_usuario = usu.id_usuario";

        if($categoria_produto != null && $categoria_produto != "todos"){
            $sql .= " WHERE pro.id_categoria_produto = ?";
            $condicaoSql = true;
            $params[] = &$categoria_produto; 
            $types .= 's';
        }

        if($data_postagem != null){

            $data = DateTime::createFromFormat('m/d/Y', $data_postagem);
            $data_formatada = $data->format('Y-m-d');

            if($condicaoSql == true){
                $sql .= " AND pro.data_postagem = ?";
            }else{
                $sql .= " WHERE pro.data_postagem = ?";
                $condicaoSql = true;
            }

            $params[] = &$data_formatada; 
            $types .= 's';
            
        }

        if($nome_anunciante != "" && $nome_anunciante != null){

            if($condicaoSql == true){
                $sql .= " AND usu.nome_usuario LIKE ?";
            }else{
                $sql .= " WHERE usu.nome_usuario LIKE ?";
                $condicaoSql = true;
            }

            $nome_anunciante = '%'.$nome_anunciante.'%';
            $params[] = &$nome_anunciante; 
            $types .= 's';
            
        }

    }else{

        $sql = "SELECT sev.fotos_servico, sev.nome_servico, sev.id_servico, sev.data_postagem, usu.nome_usuario FROM servicos sev INNER JOIN usuarios usu ON sev.id_usuario = usu.id_usuario";

        if($categoria_servico != null && $categoria_servico != "todos"){
            $sql .= " AND sev.id_categoria_servico = ?";
            $condicaoSql = true;
            $params[] = &$categoria_servico; 
            $types .= 's';
        }

        if($data_postagem != null){

            $data = DateTime::createFromFormat('m/d/Y', $data_postagem);
            $data_formatada = $data->format('Y-m-d');

            if($condicaoSql == true){
                $sql .= " AND sev.data_postagem = ?";
            }else{
                $sql .= " WHERE sev.data_postagem = ?";
                $condicaoSql = true;
            }

            $params[] = &$data_formatada; 
            $types .= 's';
        }

        if($nome_anunciante != "" && $nome_anunciante != null){

            if($condicaoSql == true){
                $sql .= " AND usu.nome_usuario LIKE ?";
            }else{
                $sql .= " WHERE usu.nome_usuario LIKE ?";
                $condicaoSql = true;
            }

            $nome_anunciante = '%'.$nome_anunciante.'%';
            $params[] = &$nome_anunciante; 
            $types .= 's';
            
        }
    }

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);

    if($condicaoSql == true){
        array_unshift($params, $types);
        call_user_func_array(array($stmt, 'bind_param'), $params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0 && $tipo_anuncio == 1) { //Produtos

        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();

            $imagensAnuncio = explode(";", $row['fotos_produto']);

            $retorno .= ' <div class="conteudoAnuncio d-flex justify-content-between col-12 p-2 mb-2 mt-2 border border-3 border-secondary">';
            $retorno .= '   <div class="imagemAnuncio col-3 ms-1 rounded p-1 border border-success">';
            $retorno .= '     <img src="../../assets/imagensAnunciosProdutos/'.$imagensAnuncio[0].'" class="w-100 h-100 rounded">';
            $retorno .= '   </div>';
            $retorno .= '   <div class="informacoesAnuncio col-8 d-flex flex-column align-items-center justify-content-between me-4">';
            $retorno .= '     <div class="tituloAnuncio mulish col-12 border-bottom border-success m-0 text-start text-black mt-2">';
            $retorno .= '       '.$row['nome_produto'].'';
            $retorno .= '     </div>';
            $retorno .= '     <div class="opcoesAnuncio col-12 d-flex align-items-end">';
            $retorno .= '       <div role="button" class="excluirAnuncio h-100 col-3 border border-danger ps-1 d-flex align-items-center pointer">';
            $retorno .= '         <i class="bi bi-trash3 text-danger"></i>';
            $retorno .= '         <p class="m-0 text-center text-danger w-100">Excluir Anúncio</p>';
            $retorno .= '       </div>';  
            $retorno .= '       <a href="../exibirAnuncioProduto.php?id_produto='.$row['id_produto'].'&exibirWhatsapp=0" class="exibirAnuncio ms-3 h-100 col-3 border border-success ps-1 d-flex align-items-center">';
            $retorno .= '         <i class="bi bi-eye text-success fs-5"></i>';
            $retorno .= '         <p class="m-0 text-center text-success w-100">Ver Anúncio</p>';
            $retorno .= '       </a>';
            $retorno .= '       <div class="h-100 col-5 border-bottom border-primary d-flex align-items-center ms-3 d-flex flex-column">';
            $retorno .= '         <p class="m-0 text-start text-primary mulish w-100">Anúnciante: <b class="m-0 text-start text-black mulish w-100">'.$row['nome_usuario'].'</b></p>';
            $retorno .= '         <p class="m-0 text-start text-primary mulish w-100">Data de Postagem: <b class="m-0 text-start text-black mulish w-100">'.$row['data_postagem'].'</b></p>';
            $retorno .= '       </div>';       
            $retorno .= '     </div>';
            $retorno .= '   </div>';
            $retorno .= '   <input type="text" value="'.$row['id_produto'].'" class="d-none" id="identificadorAnuncio">';
            $retorno .= ' </div>';

        }

        $stmt->close();
        $conn->close();

        return $retorno; 

    }else if($result->num_rows > 0 && $tipo_anuncio == 2){
        
        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();

            $imagensAnuncio = explode(";", $row['fotos_servico']);

            $retorno .= ' <div class="conteudoAnuncio d-flex justify-content-between col-12 p-2 mb-2 mt-2 border border-3 border-secondary">';
            $retorno .= '   <div class="imagemAnuncio col-3 ms-1 rounded p-1 border border-success">';
            $retorno .= '     <img src="../../assets/imagensAnunciosServicos/'.$imagensAnuncio[0].'" class="w-100 h-100 rounded">';
            $retorno .= '   </div>';
            $retorno .= '   <div class="informacoesAnuncio col-8 d-flex flex-column align-items-center justify-content-between me-4">';
            $retorno .= '     <div class="tituloAnuncio mulish col-12 border-bottom border-success m-0 text-start text-black mt-2">';
            $retorno .= '       '.$row['nome_servico'].'';
            $retorno .= '     </div>';
            $retorno .= '     <div class="opcoesAnuncio col-12 d-flex align-items-end">';
            $retorno .= '       <div role="button" class="excluirAnuncio h-100 col-3 border border-danger ps-1 d-flex align-items-center pointer">';
            $retorno .= '         <i class="bi bi-trash3 text-danger"></i>';
            $retorno .= '         <p class="m-0 text-center text-danger w-100">Excluir Anúncio</p>';
            $retorno .= '       </div>';  
            $retorno .= '       <a href="../exibirAnuncioServico.php?id_servico='.$row['id_servico'].'&exibirWhatsapp=0" class="exibirAnuncio ms-3 h-100 col-3 border border-success ps-1 d-flex align-items-center">';
            $retorno .= '         <i class="bi bi-eye text-success fs-5"></i>';
            $retorno .= '         <p class="m-0 text-center text-success w-100">Ver Anúncio</p>';
            $retorno .= '       </a>';
            $retorno .= '       <div class="h-100 col-5 border-bottom border-primary d-flex align-items-center ms-3 d-flex flex-column">';
            $retorno .= '         <p class="m-0 text-start text-primary mulish w-100">Anúnciante: <b class="m-0 text-start text-black mulish w-100">'.$row['nome_usuario'].'</b></p>';
            $retorno .= '         <p class="m-0 text-start text-primary mulish w-100">Data de Postagem: <b class="m-0 text-start text-black mulish w-100">'.$row['data_postagem'].'</b></p>';
            $retorno .= '       </div>';       
            $retorno .= '     </div>';
            $retorno .= '   </div>';
            $retorno .= '   <input type="text" value="'.$row['id_servico'].'" class="d-none" id="identificadorAnuncio">';
            $retorno .= ' </div>';

        }

        $stmt->close();
        $conn->close();

        return $retorno; 

    }else{

        $retorno = 'nenhumAnuncioEncontrado';
        
        $stmt->close();
        $conn->close();
        
        return $retorno;
    }
    
}

function retornaTodosAnuncioProduto($conn, $nome_produto, $data_postagem, $categoria_produto, $nome_anunciante){

    $retorno = '';
    $cont = 0;
    $imagensAnuncio = '';
    $params = array();
    $types = '';
    $condicaoSql = false;

    $sql = "SELECT * FROM produtos pro INNER JOIN usuarios usu ON pro.id_usuario = usu.id_usuario";
    
    if($nome_produto != null && $nome_produto != ""){
        $sql .= " WHERE pro.nome_produto LIKE ?";
        $condicaoSql = true;
        $nome_produto = '%'.$nome_produto.'%';
        $params[] = &$nome_produto;
        $types .= 's';
    }

    if($data_postagem != null){

        $data = DateTime::createFromFormat('m/d/Y', $data_postagem);
        $data_formatada = $data->format('Y-m-d');

        if($condicaoSql == true){
            $sql .= " AND pro.data_postagem = ?";
        }else{
            $sql .= " WHERE pro.data_postagem = ?";
            $condicaoSql = true;
        }

        $params[] = &$data_formatada; 
        $types .= 's';
        
    }

    if($categoria_produto != null && $categoria_produto != "todos"){
        
        if($condicaoSql == true){
            $sql .= " AND pro.id_categoria_produto = ?";
        }else{
            $sql .= " WHERE pro.id_categoria_produto = ?";
            $condicaoSql = true;
        }

        $params[] = &$categoria_produto; 
        $types .= 's';
    }

    if($nome_anunciante != "" && $nome_anunciante != null){

        if($condicaoSql == true){
            $sql .= " AND usu.nome_usuario LIKE ?";
        }else{
            $sql .= " WHERE usu.nome_usuario LIKE ?";
            $condicaoSql = true;
        }

        $nome_anunciante = '%'.$nome_anunciante.'%';
        $params[] = &$nome_anunciante; 
        $types .= 's';
        
    }

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);

    if($condicaoSql == true){
        array_unshift($params, $types);
        call_user_func_array(array($stmt, 'bind_param'), $params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $retorno = '<div class="carousel-item active">';
        $retorno .= '  <div class="item-grid grid-template-columns">';
        
        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();

            $imagensAnuncio = explode(";", $row['fotos_produto']);

            if($cont % 8 == 0 && $cont != 0){
                $retorno .= '</div></div>';
                $retorno .= '<div class="carousel-item">';
                $retorno .= '  <div class="item-grid grid-template-columns">';
            }

            $retorno .= '    <div class="item d-flex justify-content-center">';
            $retorno .= '      <a href="exibirAnuncioProduto.php?id_produto='.$row['id_produto'].'&exibirWhatsapp=1" class="anuncio bg-white shadow border">';
            $retorno .= '        <div class="imagemAnuncio d-flex justify-content-center align-itens-center border" style="height: 80%;">';
            $retorno .= '          <img class="category_img" src="../assets/imagensAnunciosProdutos/'.$imagensAnuncio[0].'" alt="imagem" width="100%">';
            $retorno .= '        </div>';
            $retorno .= '        <div class="tituloProduto mt-1 text-center ps-2 pe-2 lato">';
            $retorno .= '          '.$row['nome_produto'].'';
            $retorno .= '        </div>';
            $retorno .= '      </a>';
            $retorno .= '    </div>';

            $cont++;
            
        }

        $retorno .= '</div></div>';

        $stmt->close();
        $conn->close();

        return $retorno; 

    }else{

        $retorno = 'nenhumAnuncioEncontrado';
        
        $stmt->close();
        $conn->close();
        
        return $retorno;

    }

}

function retornaTodosAnuncioServico($conn, $nome_servico, $data_postagem, $categoria_servico, $nome_anunciante){

    $retorno = '';
    $cont = 0;
    $imagensAnuncio = '';
    $params = array();
    $types = '';
    $condicaoSql = false;

    $sql = "SELECT * FROM servicos sev INNER JOIN usuarios usu ON sev.id_usuario = usu.id_usuario";
    
    if($nome_servico != null && $nome_servico != ""){
        $sql .= " WHERE sev.nome_servico LIKE ?";
        $condicaoSql = true;
        $nome_servico = '%'.$nome_servico.'%';
        $params[] = &$nome_servico;
        $types .= 's';
    }

    if($data_postagem != null){

        $data = DateTime::createFromFormat('m/d/Y', $data_postagem);
        $data_formatada = $data->format('Y-m-d');

        if($condicaoSql == true){
            $sql .= " AND sev.data_postagem = ?";
        }else{
            $sql .= " WHERE sev.data_postagem = ?";
            $condicaoSql = true;
        }

        $params[] = &$data_formatada; 
        $types .= 's';
        
    }

    if($categoria_servico != null && $categoria_servico != "todos"){
        
        if($condicaoSql == true){
            $sql .= " AND sev.id_categoria_servico = ?";
        }else{
            $sql .= " WHERE sev.id_categoria_servico = ?";
            $condicaoSql = true;
        }

        $params[] = &$categoria_servico; 
        $types .= 's';
    }

    if($nome_anunciante != "" && $nome_anunciante != null){

        if($condicaoSql == true){
            $sql .= " AND usu.nome_usuario LIKE ?";
        }else{
            $sql .= " WHERE usu.nome_usuario LIKE ?";
            $condicaoSql = true;
        }

        $nome_anunciante = '%'.$nome_anunciante.'%';
        $params[] = &$nome_anunciante; 
        $types .= 's';
        
    }

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);

    if($condicaoSql == true){
        array_unshift($params, $types);
        call_user_func_array(array($stmt, 'bind_param'), $params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $retorno = '<div class="carousel-item active">';
        $retorno .= '<div class="anunciosServicos d-flex flex-row justify-content-center" style="height: 450px;">';
        
        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();

            $imagensAnuncio = explode(";", $row['fotos_servico']);

            if($cont % 3 == 0 && $cont != 0){
                $retorno .= '</div></div>';
                $retorno .= '<div class="carousel-item">';
                $retorno .= '<div class="anunciosServicos d-flex flex-row justify-content-center" style="height: 450px;">';
            }

            $retorno .= '<div class="anuncio d-flex flex-column justify-content-center align-items-center col-3 border border-dark border-2 rounded-0 me-3 ms-3">';
            $retorno .= '    <div class="image-container justify-content-center align-items-center">';
            $retorno .= '        <img src="../assets/imagensAnunciosServicos/'.$imagensAnuncio[0].'">';
            $retorno .= '        <div class="overlay d-flex flex-column justify-content-center align-items-center">';
            $retorno .= '            <div class="tituloServico d-flex text-center lato">';
            $retorno .= '                '.$row['nome_servico'].'';
            $retorno .= '            </div>';
            $retorno .= '            <div class="button mt-4 mb-4">';
            $retorno .= '                <button type="button" class="btn btn-outline-primary rounded-0 text-white border-2" onclick="window.location.href=\'exibirAnuncioServico.php?id_servico='.$row['id_servico'].'&exibirWhatsapp=1\'">Ver Mais</button>';
            $retorno .= '            </div>';
            $retorno .= '            <div class="duracaoEstimado">';
            $retorno .= '                <h6>Duração Estimada:</h6>';
            $retorno .= '                <h6 class="text-center">'.$row['duracao_servico'].' horas</h6>';
            $retorno .= '            </div>';
            $retorno .= '        </div>';
            $retorno .= '    </div>';
            $retorno .= '</div>';

            $cont++;
            
        }

        $retorno .= '</div></div>';

        $stmt->close();
        $conn->close();

        return $retorno; 

    }else{

        $retorno = 'nenhumAnuncioEncontrado';
        
        $stmt->close();
        $conn->close();
        
        return $retorno;

    }

}

function retornarNivelUsuario($conn, $id_usuario){

    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare("SELECT nivel_usuario FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $nivel_usuario = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $nivel_usuario; 
    } else {
        return null; 
    }
}

/*

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

*/

?>