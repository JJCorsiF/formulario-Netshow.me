<!DOCTYPE html>
<html lang="pt-br">

<head>
	<base href="<?php echo base_url(); ?>" />
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="robots" content="index, follow" />
	<title>Formulário Netshow.me</title>

	<link rel="shortcut icon" href="assets/aplicacao/src/img/favicon.png" />
	<link rel="stylesheet" type="text/css" href="assets/aplicacao/node_modules/@fortawesome/fontawesome-free/css/all.css" />
	<link rel="stylesheet" type="text/css" href="assets/aplicacao/src/css/index.css" />

	<script type="module" src="assets/aplicacao/dist/main.js" crossorigin></script>
	<script nomodule src="assets/aplicacao/src/js/index.js" crossorigin></script>
</head>

<body class="container">
	<header class="row">
		<!-- Conteúdo do Header da página -->
	</header>
	<article class="row">
		<div class="card-deck col-sm-12">
			<div class="card bg-light">
				<form id="formularioParaContato" class="" action="formulario/submeterFormulario" method="POST" enctype="multipart/form-data" lang="pt-br">
					<div class="card-header text-center">
						<h5 class="card-title">{{ tituloDoFormulario }}</h5>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col">
								<div class="form-label-group">
									<label for="nome" class="card-text">Nome:</label>
									<input id="nome" name="nome" class="form-control" placeholder="Digite o seu nome" value="" autocomplete="on" required="required" data-validate="Este campo é obrigatório" />
								</div>
							</div>
							<div class="form-group col">
								<div class="form-label-group">
									<label for="email" class="card-text">Email:</label>
									<input type="email" id="email" name="email" class="form-control" placeholder="Digite o seu email" value="" autocomplete="on" required="required" data-validate="Este campo é obrigatório" />
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<div class="form-label-group">
									<label for="telefone" class="card-text">Contato:</label>
									<input type="phone" id="telefone" name="telefone" class="form-control" maxlength="11" placeholder="Digite o seu número para contato" value="" autocomplete="on" required="required" data-validate="Este campo é obrigatório" />
								</div>
							</div>
							<div class="form-group col custom-file" lang="pt-br">
								<div class="form-label-group#">
									<label for="anexo">Anexo: </label>
									<label id="labelDoAnexo" class="custom-file-label" style="margin-top: 32px;">Selecione um anexo</label>
									<input type="file" id="anexo" name="anexo" class="custom-file-input" accept="application/pdf,application/msword,application/vnd.ms-office,application/vnd.oasis.opendocument.text,text/plain" title=" " placeholder="" required="required" data-validate="Este campo é obrigatório" />
									<input type="hidden" id="arquivo" name="arquivo" value="" />
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<div class="form-label-group">
									<label for="mensagem" class="card-text">Mensagem:</label>
									<textarea id="mensagem" name="mensagem" class="form-control" placeholder="Digite a sua mensagem" required="required" data-validate="Este campo é obrigatório" style="resize: none;"></textarea>
								</div>
							</div>
						</div>

						<div id="notificacoes" class="alert alert-primary" role="alert" style="display: none;">
							<h4 class="alert-heading text-center"></h4>
						</div>
					</div>

					<div class="card-footer text-right">
						<div class="form-group">
							<div class="form-label-group">
								<button type="submit" id="botaoDeSubmitDoFormularioDeMensagem" name="botaoDeSubmitDoFormularioDeMensagem" class="btn btn-primary">Enviar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</article>
	<footer class="row sticky-footer">
		<div class="container my-auto">
			<!--div class="copyright text-center my-auto">
				<span>Desenvolvido por João Corsi (jjcorsif@hotmail.com)</span>
			</div-->
			<div class="copyright text-center my-auto">
				<span>Copyright © <?php echo (((int) (new \DateTime())->format('Y')) > 2020 ? '2020-' : '') . (new \DateTime())->format('Y'); ?> João Corsi (jjcorsif@hotmail.com). Todos os direitos reservados.</span>
			</div>
		</div>
	</footer>
</body>

</html>