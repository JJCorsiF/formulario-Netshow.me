<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Repositorios;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada\MensagemEnviada;

interface RepositorioDeMensagensEnviadas
{
	public function armazenarRegistro(MensagemEnviada $mensagemEnviada);
}
