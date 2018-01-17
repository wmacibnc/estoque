<?php include 'head.php'; ?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Início</a>
			</li>
			<li class="breadcrumb-item">
				<a href="cliente.php">Cliente</a>
			</li>
			<li class="breadcrumb-item active">Novo Cliente</li>
		</ol>
		<div class="row">
			<div class="col-12">
				<h1>Novo Cliente</h1>
				<form class="form-horizontal" action="salvar-cliente.php" method="POST">
					<?php

					if($_GET && (isset($_GET['id'])) ){
						$query = "SELECT ID, NOME, EMAIL, SENHA, DD, TELEFONE, CPF, CEP, COMPLEMENTO, NUMERO FROM CLIENTE WHERE ID=".$_GET['id'];

						$result = $con->query($query);
						$cliente = $result->fetch_array(MYSQLI_ASSOC);


						echo ' <input type="hidden" name="id" value="'.$_GET['id'].'" >';
					}else{
						$cliente = null;
					}
					?>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="nome">Nome</label>  
						<div>
							<input id="nome" name="nome" maxlength="50" type="text" placeholder="Informe o nome" class="form-control input-md" required <?php echo ' value="'.$cliente['NOME'].'"'; ?>>
							<span class="help-block">Informe o nome do cliente</span>  
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="email">E-mail</label>  
						<div>
							<input id="email" name="email" maxlength="50" type="text" placeholder="Informe o e-mail" class="form-control input-md" required <?php echo ' value="'.$cliente['EMAIL'].'"'; ?>>
							<span class="help-block">Informe o e-mail do cliente</span>  
						</div>
					</div>

					<!-- Password input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="senha">Senha</label>
						<div>
							<input id="senha" name="senha" maxlength="10" type="password" placeholder="Informe a senha" class="form-control input-md" required <?php echo ' value="'.$cliente['SENHA'].'"'; ?>>
							<span class="help-block">Informe a senha do cliente</span>
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="telefone">Telefone</label>  
						<div>
							<input id="telefone" name="telefone" maxlength="11" type="number" placeholder="Informe o telefone" class="form-control input-md" required <?php echo ' value="'.$cliente['DD'].$cliente['TELEFONE'].'"'; ?>>
							<span class="help-block">Informe o Telefone do cliente</span>  
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="cpf">C.P.F</label>  
						<div>
							<input id="cpf" name="cpf" type="number" maxlength="11" placeholder="Informe o C.P.F" class="form-control input-md" onblur="TestaCPF(this)" required <?php echo ' value="'.$cliente['CPF'].'"'; ?>>
							<span class="help-block">Informe o C.P.F do cliente</span>  
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="cep">CEP</label>  
						<div>
							<input id="cep" name="cep" type="number" maxlength="8" placeholder="Informe o CEP" class="form-control input-md" required <?php echo ' value="'.$cliente['CEP'].'"'; ?>>
							<span class="help-block">Informe o CEP do cliente</span>  
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="endereco">Endereço</label>  
						<div>
							<input id="endereco" disabled name="endereco" type="text" class="form-control input-md" required>
							<span class="help-block">Informe o Endereço do cliente</span>  
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="numero">Número</label>  
						<div>
							<input id="numero" name="numero" type="number" maxlength="4" placeholder="Informe o número" class="form-control input-md" required <?php echo ' value="'.$cliente['NUMERO'].'"'; ?>>
							<span class="help-block">Informe o número do cliente</span>  
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group class-md-6">
						<label class="control-label" for="complemento">Complemento</label>  
						<div>
							<input id="complemento" name="complemento" maxlength="20" type="text" placeholder="informe o Complemento" class="form-control input-md" required <?php echo ' value="'.$cliente['COMPLEMENTO'].'"'; ?>>
							<span class="help-block">Informe o Complemento do endereço do cliente</span>  
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
			</div>
		</div>
	</div>
	<!-- /.container-fluid-->
	<!-- /.content-wrapper-->
	<?php include 'footer.php'; ?>

	<!-- Adicionando Javascript -->
    <script type="text/javascript" >

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#endereco").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#endereco").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                
                                var endereco = dados.logradouro + " - " + dados.bairro + "  - " + dados.localidade + "/"+ dados.uf;
                                $("#endereco").val(endereco);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

function TestaCPF(strCPF2) {
	var strCPF = strCPF2.value;
    var Soma;
    var Resto;
    Soma = 0;
	if (strCPF === "00000000000"
		|| strCPF === "11111111111"
		|| strCPF === "22222222222"
		|| strCPF === "33333333333"
		|| strCPF === "44444444444"
		|| strCPF === "55555555555"
		|| strCPF === "66666666666"
		|| strCPF === "77777777777"
		|| strCPF === "88888888888"
		|| strCPF === "99999999999") {
		alert("CPF inválido!");
    	document.getElementById("cpf").value = "";
    	return false;
	}
    
	for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
	Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) {
    	alert("CPF inválido!");
    	document.getElementById("cpf").value = "";
    	return false;
    }
	
	Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  Resto = 0;

    if (Resto != parseInt(strCPF.substring(10, 11) ) ){
    	alert("CPF inválido!");
    	document.getElementById("cpf").value = "";
    	return false;
    }
    return true;
}
var strCPF = "12345678909";

alert(TestaCPF(strCPF));
</script>