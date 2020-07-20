<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Servicos;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Email;

interface MensageiroDeEmail
{
	public function enviarEmail(Email $email, $assunto, $mensagem);
}
