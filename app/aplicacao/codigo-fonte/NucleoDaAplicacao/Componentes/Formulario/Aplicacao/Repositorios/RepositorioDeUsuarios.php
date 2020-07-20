<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Repositorios;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Usuario;

interface RepositorioDeUsuarios
{
	public function armazenarUsuario(Usuario $usuario);
}
