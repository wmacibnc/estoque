<?php include 'head.php'; ?>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
      </li>
      <li class="breadcrumb-item active">Efetura Venda</li>
    </ol>
    <div class="row">
      <div class="col-12">
        <?php if(isset($_GET['mensagem'])){ ?>
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sucesso!</strong> <?php echo $_GET['mensagem']; ?>
        </div>
        <?php } ?>
        <h1>Efetuar Nova Venda</h1>
        
        <div class="card mb-3">
         <div class="card-header">
          <i class="fa fa-table"></i> Produtos</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT PROD.ID, 
                  case 
                  when PROD.ID_CATEGORIA > 0 then 
                  (SELECT C.NOME FROM CATEGORIA C WHERE C.ID = ID_CATEGORIA)
                  else (SELECT P.NOME FROM PRODUTO P WHERE P.ID = PROD.ID_PRODUTO)
                    END AS NOME_TIPO,
                  PROD.NOME,PROD.QUANTIDADE, PROD.ID_PRODUTO, PROD.PRECO_CUSTO, PROD.ID_CATEGORIA, PROD.PRECO_VENDA, PROD.PESO, PROD.ALTURA FROM PRODUTO PROD WHERE PROD.ID_CATEGORIA > 0 ORDER BY NOME asc ";

                  $result = $con->query($query);
                  while($produto = $result->fetch_array(MYSQLI_ASSOC)){
                    echo '<tr>';
                    echo '<td>';
                    echo $produto['NOME'];
                    echo '</td>';
                    echo '<td>';
                    echo $produto['PRECO_VENDA'];
                    echo '</td>';
                    echo '<td>';
                    $id = $produto['ID'];
                    echo '<a href="adicionar-carrinho.php?id='.$id.'"><button type="button" class="btn btn-warning" title="Selecionar"><i class="fa fa-fw fa-plus-square"></i></button></a>';
                    echo '</td>';
                    echo '</tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->
  <?php include 'footer.php'; ?>

  https://viacep.com.br/ws/01452002/json/