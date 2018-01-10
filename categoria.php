<?php include 'head.php'; ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
      </li>
      <li class="breadcrumb-item active">Cadastros</li>
      <li class="breadcrumb-item active">Categoria</li>
    </ol>
    <div class="row">

      <div class="col-12">
        <?php if(isset($_GET['mensagem'])){ ?>
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sucesso!</strong> <?php echo $_GET['mensagem']; ?>
        </div>
        <?php } ?>
        

        <h1>Categoria</h1>
        <div class="row">
         <div class="col-12">
          <a href="categoria-novo.php"><button type="button" class="btn btn-success"><i class="fa fa-fw fa-plus-square"></i>Novo</button></a>
        </div>
      </div>


      <div class="card mb-3">
       <div class="card-header">
        <i class="fa fa-table"></i> Categorias</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>*</th>
                  <th>Nome</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php
                  $query = "SELECT ID, NOME FROM CATEGORIA ORDER BY NOME ";

                  $result = $con->query($query);
                  while($categoria = $result->fetch_array(MYSQLI_ASSOC)){
                    echo '<tr>';
                    echo '<td>';
                    echo $categoria['ID'];
                    echo '</td>';
                    echo '<td>';
                    echo $categoria['NOME'];
                    echo '</td>';
                    echo '<td>';
                    $id = $categoria['ID'];
                    echo '<a href="categoria-novo.php?id='.$id.'"><button type="button" class="btn btn-warning"><i class="fa fa-fw fa-pencil-square"></i>Editar</button></a>
                    <a href="salvar-categoria.php?id='.$id.'"><button type="button" class="btn btn-danger"><i class="fa fa-fw fa-minus-square"></i>Excluir</button></a>';
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