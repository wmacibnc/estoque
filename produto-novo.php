<?php include 'head.php'; ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
      </li>
      <li class="breadcrumb-item">
        <a href="produto.php">Produto</a>
      </li>
      <li class="breadcrumb-item active">Novo Produto</li>
    </ol>
    <div class="row">
      <div class="col-12">
        <h1>Novo Produto</h1>

        <form class="form-horizontal" action="salvar-produto.php" method="POST">

          <!-- Select Basic -->
          <div class="form-group">
            <label class="control-label" for="tipo">Tipo de Cadastro</label>
            <div>
              <select id="tipo" name="tipo" class="form-control" onchange="alteraDiv();">
                <option value="1">Categoria</option>
                <option value="2">Produto</option>
              </select>
            </div>
          </div>

          <!-- Select Basic -->
          <div class="form-group" id="cat">
            <label class="control-label" for="categoria">Categoria</label>
            <div>
              <select id="id_categoria" name="id_categoria" class="form-control">
                <?php
                $query = "SELECT C.ID, C.NOME FROM CATEGORIA C";

                if($_GET && (isset($_GET['id'])) ){
                $queryProd = "SELECT ID, ID_CATEGORIA, ID_PRODUTO, NOME, QUANTIDADE, PRECO_CUSTO, PRECO_VENDA, PESO, ALTURA FROM PRODUTO WHERE ID=".$_GET['id'];

                $resultProd = $con->query($queryProd);
                $produto = $resultProd->fetch_array(MYSQLI_ASSOC);
              }else{
              $produto = null;  
            }

            $result = $con->query($query);
            while($categorias = $result->fetch_array(MYSQLI_ASSOC)){
            $id_categoria = $categorias['ID'];
            $nome_categoria = $categorias['NOME'];
            ?>
            <option value="<?php 
            echo $id_categoria.'" ';

            if($id_categoria==$produto['ID_CATEGORIA']){
            echo ' selected';
          }

          ?>
          ><?php echo $nome_categoria; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <?php if(isset($_GET['id'])){ 
    echo ' <input type="hidden" name="id" value="'.$_GET['id'].'" >';
  }
  ?>

  <!-- Select Basic -->
  <div class="form-group" id="prod">
    <label class="control-label" for="produto">Sub-Produto</label>
    <div>
      <select id="id_produto" name="id_produto" class="form-control">
        <?php
        $queryProdutos = "SELECT P.ID, P.NOME, P.ID_CATEGORIA FROM PRODUTO P WHERE P.ID_CATEGORIA IS NOT NULL ";
        $resultProdutos = $con->query($queryProdutos);
        while($produtos = $resultProdutos->fetch_array(MYSQLI_ASSOC)){
        $id_produto = $produtos['ID'];
        $nome_produto = $produtos['NOME'];
        ?>
        <option value="<?php echo $id_produto.'" ';

        if($id_produto==$produto['ID_PRODUTO']){
        echo ' selected';
      }

      ?>
      ><?php echo $nome_produto; ?></option>
      <?php } ?>
    </select>
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="control-label" for="nome">Nome</label>  
  <div>
    <input id="nome" name="nome" type="text" placeholder="Informe o nome do Produto" class="form-control input-md" required <?php echo ' value="'.$produto['NOME'].'"'; ?> >
    <span class="help-block">Informe o nome do Produto</span>  
  </div>
</div>

<!-- Select Basic -->
<div class="form-group" id="quant">
  <label class="control-label" for="quantidade">Quantidade</label>
  <div>
    <select id="quantidade" name="quantidade" class="form-control">
      <?php for ($i=0; $i <= 50; $i++) { 
      $quantidade = $produto['QUANTIDADE'];
      ?>
      <option value="<?php echo ''.$i.'"';

      if($quantidade==$i){
      echo ' selected';
    }
    ?>

    ><?php echo $i; ?> </option>
    <?php } ?>
  </select>
</div>
</div>

<!-- Text input-->
<div class="form-group" id="pc">
  <label class="control-label" for="precoCusto">Preço de Custo</label>  
  <div>
    <input id="precoCusto" name="precoCusto" type="number" placeholder="Informe o Preço de Custo do Produto" class="form-control input-md" <?php echo ' value="'.$produto['PRECO_CUSTO'].'"'; ?> >
    <span class="help-block">Informe o Preço de Custo do Produto</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group" id="pv">
  <label class="control-label" for="precoVenda">Preço de Venda</label>  
  <div>
    <input id="precoVenda" name="precoVenda" type="number" placeholder="Informe o Preço de Venda" class="form-control input-md" <?php echo ' value="'.$produto['PRECO_VENDA'].'"'; ?> >
    <span class="help-block">Informe o Preço de Venda do Produto</span>  
  </div>
</div>


<!-- Text input-->
<div class="form-group" id="pe">
  <label class="control-label" for="peso">Peso</label>  
  <div>
    <input id="peso" name="peso" type="number" placeholder="Informe o Peso" class="form-control input-md" <?php echo ' value="'.$produto['PESO'].'"'; ?> >
    <span class="help-block">Informe o Peso do Produto</span> </div>
  </div>


  <!-- Text input-->
  <div class="form-group" id="al">
    <label class="control-label" for="altura">Altura</label>  
    <div>
      <input id="altura" name="altura" type="number" placeholder="Informe a altura" class="form-control input-md" <?php echo ' value="'.$produto['ALTURA'].'"'; ?> >
      <span class="help-block">Informe a Altura do Produto</span> </div>
    </div>

    <!-- Button (Double) -->
    <div class="form-group">
      <label class="control-label" for="enviar"></label>
      <div class="col-md-8">
        <button id="enviar" type="submit" name="enviar" class="btn btn-success">Enviar</button>
        <button id="limpar" type="reset" name="limpar" class="btn btn-danger">Limpar</button>
      </div>
    </div>
  </form>



</div>
</div>
</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->
<?php include 'footer.php'; ?>
<script type="text/javascript">
  alteraDiv();

    function alteraDiv(){

    if(document.getElementById("tipo").value === '1'){
      document.getElementById("prod").style.display = "none";
      document.getElementById("cat").style.display = "block";
      document.getElementById("pc").style.display = "block";
      document.getElementById("pv").style.display = "block";
      document.getElementById("pe").style.display = "block";
      document.getElementById("al").style.display = "block"; 
    }

    if(document.getElementById("tipo").value === '2'){
      document.getElementById("prod").style.display = "block";
      document.getElementById("cat").style.display = "none";
      document.getElementById("pc").style.display = "none";
      document.getElementById("pv").style.display = "none";
      document.getElementById("pe").style.display = "none";
      document.getElementById("al").style.display = "none";
    }
}
  </script>