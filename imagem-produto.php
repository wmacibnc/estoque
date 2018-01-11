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
      <li class="breadcrumb-item active">Imagens Produto</li>
    </ol>
    <div class="row">
      <div class="col-12">
        <h1>Imagens Produto</h1>



        <form action="salvar-imagem.php" method="post" enctype="multipart/form-data">
          <?php 
          echo ' <input type="hidden" name="id" value="'.$_GET['id'].'" >';
          ?>
          <!-- File Button --> 
          <div class="form-group col-md-12" >
            <label class="control-label" for="fileToUpload"></label>
            <div>
              <input name="fileToUpload" id="fileToUpload" class="input-file" type="file">
            </div>
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

        <div class="row">

          <?php
          $query = "SELECT ID, BASE_64 FROM IMAGEM WHERE ID_PRODUTO=".$_GET['id']." ORDER BY ID DESC ";

          $result = $con->query($query);
          while($imagem = $result->fetch_array(MYSQLI_ASSOC)){
            $BASE_64 = $imagem['BASE_64'];
            $id = $imagem['ID'];
            echo '
            <div class="gallery_product col-md-4">
            <img src="'.$BASE_64.'" class="img-responsive" width="300px" height="auto">
            <div class="col-md-12 center">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal'.$id.'"><i class="fa fa-fw fa-plus-square"></i></button>
            <a href="salvar-imagem.php?id='.$id.'&id_produto='.$_GET['id'].'"><button type="button" class="btn btn-danger" title="Excluir"><i class="fa fa-fw fa-minus-square"></i></button></a>
            </div>
            </div>





            <!-- Modal -->
            <div class="modal fade" id="exampleModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Imagem</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <img src="'.$BASE_64.'" class="img-responsive">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </div>
            </div>
            </div>
            ';
          }
          ?>          

        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include 'footer.php'; ?>