<?php include 'head.php'; ?>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
      </l?>i>
      <li class="breadcrumb-item">
        <a href="venda.php">Venda</a>
      </li>
      <?php 
      $GLOBALS['produto'] = null;
      $queryProd = "SELECT PROD.ID, PROD.ID_CATEGORIA, (SELECT C.NOME FROM CATEGORIA C WHERE C.ID = PROD.ID_CATEGORIA) AS CATEGORIA, PROD.ID_PRODUTO, PROD.NOME, (SELECT SUM(P.QUANTIDADE) FROM PRODUTO P WHERE P.ID_PRODUTO = PROD.ID) as QUANTIDADE, PROD.PRECO_CUSTO, PROD.PRECO_VENDA, PROD.PESO, PROD.ALTURA FROM PRODUTO PROD WHERE PROD.ID=".$_GET['id'];

      $resultProd = $con->query($queryProd);
      $produto = $resultProd->fetch_array(MYSQLI_ASSOC);
      
      ?>
      <li class="breadcrumb-item active">
        <?php  
        echo 
        "<a href='venda-categoria.php?id=".$produto['ID_CATEGORIA']."'>".$produto['CATEGORIA']."</a>";
        ?>
      </li>
    </ol>
    <div class="row">
      <div class="col-12">

        <div class="row">
          <div class="col-md-6">

            <div class="row justify-content-center">
              <div class="col-md-12">

                <a href="https://unsplash.it/1200/768.jpg?image=254" data-toggle="lightbox" data-gallery="example-gallery" class="col-md-4">
                  <img src="https://unsplash.it/600.jpg?image=254" class="img-fluid">
                </a>
                
              </div>
            </div>

          </div>

          <div class="col-md-6">
            <p class="titulo">
              <?php 
              echo "".$produto['NOME']." - "."<span class='preco'>R$ ".$produto['PRECO_VENDA'].",00</p>";
              ?>
              <label>
                <b>Medidas:</b> <?php echo $produto['ALTURA'] ?>
                <b>Peso:</b> <?php echo $produto['PESO'] ?>g
              </label><br />
              <br />
              <form action="atualizar-carrinho.php" method="POST">

              <?php  
              $query = "SELECT P.ID, P.NOME, P.ID_PRODUTO, P.QUANTIDADE FROM PRODUTO P WHERE P.ID_PRODUTO=".$produto['ID'];
              $result = $con->query($query);
              while($subProduto = $result->fetch_array(MYSQLI_ASSOC)){
                echo "<input type='hidden' name='id[]' value='".$subProduto['ID']."' />";
                echo "<p><img src='https://unsplash.it/50.jpg?image=251' class='img-responsive'>
                <input type='number' name='subprodutoqtd[]' class='form-control input-qtd' min='0' max='".$subProduto['QUANTIDADE']."' />".$produto['NOME']." - ".$subProduto['NOME']." - ".$subProduto['QUANTIDADE']." disponíveis</p>";
              }
              ?>

              <input type="submit" class="btn btn-success" name="add-carrinho" value="Adicionar produto"/>
              </form>
            </div>



          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container -->
  <?php include 'footer.php'; ?>