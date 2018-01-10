<?php include 'head.php'; ?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Início</a>
      </li>
      <li class="breadcrumb-item">
        <a href="categoria.php">Categoria</a>
      </li>
      <li class="breadcrumb-item active">Nova Categoria</li>
    </ol>
    <div class="row">
      <div class="col-12">
        <h1>Nova Categoria</h1>
        <form class="form-horizontal" action="salvar-categoria.php" method="POST">
          <fieldset>
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="nome">Nome:</label>  
              <div class="col-md-4">
                <?php if(isset($_GET['id'])){ 
                  echo ' <input type="hidden" name="id" value="'.$_GET['id'].'" >';
                }
                ?>
                <input id="nome" name="nome" type="text" placeholder="" class="form-control input-md" required
                <?php if(isset($_GET['id'])){
                  $query = "SELECT NOME FROM CATEGORIA WHERE ID=".$_GET['id'];
                  echo $query;
                  $result = $con->query($query);
                  $categoria = $result->fetch_array(MYSQLI_ASSOC);
                  echo ' value="'.$categoria['NOME'].'"';
                }?>
                >

                <span class="help-block">Informe o nome da categoria</span>  
              </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
              <label class="col-md-4 control-label" for="button1id"></label>
              <div class="col-md-8">
                <button id="button1id" name="button1id" class="btn btn-success">Enviar</button>
                <button id="button2id" name="button2id" class="btn btn-warning">Limpar</button>
              </div>
            </div>

          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->
  <?php include 'footer.php'; ?>