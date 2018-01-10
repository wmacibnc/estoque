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
          <h1>Produto</h1>
			<div class="row">
			<div class="col-12">
				<a href="produto-novo.html"><button type="button" class="btn btn-success"><i class="fa fa-fw fa-plus-square"></i>Novo</button></a>
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
                  <th>Imagem</th>
                  <th>Nome</th>
                  <th>Qtd</th>
                  <th>Preço Custo</th>
                  <th>Preço Venda</th>
				          <th>Ação</th>
                </tr>
              </thead>
			  <tbody>
                <tr>
                  <td>1</td>
                  <td>-</td>
                  <td>teste</td>
                  <td>10</td>
                  <td>R$ 5,00</td>
                  <td>R$ 10,00</td>

				  <td>
					<a href="editor-produto.html"><button type="button" class="btn btn-warning"><i class="fa fa-fw fa-pencil-square"></i>Editar</button></a>
					<a href="excluir-produto.html"><button type="button" class="btn btn-danger"><i class="fa fa-fw fa-minus-square"></i>Excluir</button></a>
          <a href="imagens-produtos.html"><button type="button" class="btn btn-default"><i class="fa fa-fw fa-picture-o"></i>Imagens</button></a>
				  </td>
				</tr>
				     
             <tr>
                  <td>1</td>
                  <td>-</td>
                  <td>teste</td>
                  <td>10</td>
                  <td>R$ 5,00</td>
                  <td>R$ 10,00</td>

          <td>
          <a href="editor-produto.html"><button type="button" class="btn btn-warning"><i class="fa fa-fw fa-pencil-square"></i>Editar</button></a>
          <a href="excluir-produto.html"><button type="button" class="btn btn-danger"><i class="fa fa-fw fa-minus-square"></i>Excluir</button></a>
          <a href="imagens-produtos.html"><button type="button" class="btn btn-default"><i class="fa fa-fw fa-picture-o"></i>Imagens</button></a>
          </td>
        </tr>
				
				
				 
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