<?php include 'head.php'; ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
      </li>
      <li class="breadcrumb-item active">Cadastros</li>
      <li class="breadcrumb-item active">Produto</li>
    </ol>
    <div class="row">
      <div class="col-12">
        <?php if(isset($_GET['mensagem'])){ ?>
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sucesso!</strong> <?php echo $_GET['mensagem']; ?>
        </div>
        <?php } ?>
        <h1>Produto</h1>
        <div class="row">
         <div class="col-12">
          <a href="produto-novo.php"><button type="button" class="btn btn-success"><i class="fa fa-fw fa-plus-square"></i>Novo</button></a>
        </div>
      </div>


      <div class="card mb-3">
       <div class="card-header">
        <i class="fa fa-table"></i> Produtos</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>*</th>
                  <th>Tipo</th>
                  <th>Nome</th>
                  <th>Qtd</th>
                  <th>Preço Custo</th>
                  <th>Preço Venda</th>
                  <th>Peso</th>
                  <th>Altura</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php
                ECHO $query = "SELECT PROD.ID, 
                case 
                when PROD.ID_CATEGORIA > 0 then 
                (SELECT C.NOME FROM CATEGORIA C WHERE C.ID = ID_CATEGORIA)
                else (SELECT P.NOME FROM PRODUTO P WHERE P.ID = PROD.ID_PRODUTO)
                  END AS NOME_TIPO,
                PROD.NOME,PROD.QUANTIDADE, PROD.ID_PRODUTO, PROD.PRECO_CUSTO, PROD.ID_CATEGORIA, PROD.PRECO_VENDA, PROD.PESO, PROD.ALTURA FROM PRODUTO PROD ORDER BY NOME asc ";

                $result = $con->query($query);
                while($produto = $result->fetch_array(MYSQLI_ASSOC)){
                  echo '<tr>';
                  echo '<td>';
                  echo $produto['ID'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['NOME_TIPO'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['NOME'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['QUANTIDADE'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['PRECO_CUSTO'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['PRECO_VENDA'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['PESO'];
                  echo '</td>';
                  echo '<td>';
                  echo $produto['ALTURA'];
                  echo '</td>';

                  echo '<td>';
                  $id = $produto['ID'];
                  echo '<a href="produto-novo.php?id='.$id.'"><button type="button" class="btn btn-warning" title="Editar"><i class="fa fa-fw fa-pencil-square"></i></button></a>
                  <a href="salvar-produto.php?id='.$id.'"><button type="button" class="btn btn-danger" title="Excluir"><i class="fa fa-fw fa-minus-square"></i></button></a>
                  <a href="imagem-produto.php?id='.$id.'"><button type="button" class="btn btn-default" title="Imagens"><i class="fa fa-fw fa-picture-o"></i></button></a>';
                  echo '</td>';
                  echo '</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Atualizado às 13:29 PM</div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->
<?php include 'footer.php'; ?>