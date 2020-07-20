<?php

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Telefone;

class TelefoneTest extends \Codeception\Test\Unit
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
	public function testeQuandoOTelefoneNaoForValidoUmaExcecaoELancada()
	{
		$this->expectException(Exception::class);
		$numero = 'telefoneInvalido';
		new Telefone($numero);
	}

	public function testeQuandoOTelefoneForValidoNenhumaExcecaoELancada()
	{
		$numero = '91999999999';
		new Telefone($numero);
	}
}
