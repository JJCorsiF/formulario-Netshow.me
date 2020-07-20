<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Repositorios;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada\Anexo;

interface RepositorioDeAnexos
{
	public function armazenarAnexo(Anexo $anexo);

	public function buscarAnexo($caminhoDoAnexo);
}
