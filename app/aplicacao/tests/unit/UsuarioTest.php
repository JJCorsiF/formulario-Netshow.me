<?php

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Email;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Telefone;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Usuario;

class UsuarioTest extends \Codeception\Test\Unit
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before()
	{
	}

	protected function _after()
	{
	}

	// tests
	public function testeQuandoONomeDoUsuarioNaoForValidoUmaExcecaoELancada()
	{
		$this->expectException(Exception::class);
		$nomeDoUsuario = NULL;
		new Usuario($nomeDoUsuario, new Email('a@b.c'), new Telefone('00000000000'));
	}

	public function testeQuandoONomeDoUsuarioForValidoNenhumaExcecaoELancada()
	{
		$nomeDoUsuario = 'John Doe';
		new Usuario($nomeDoUsuario, new Email('a@b.c'), new Telefone('00000000000'));
	}
}
