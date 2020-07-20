<?php

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Email;

class EmailTest extends \Codeception\Test\Unit
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
	public function testeQuandoOEmailNaoForValidoUmaExcecaoELancada()
	{
		$this->expectException(Exception::class);
		$email = 'emailInvalido';
		new Email($email);
	}

	public function testeQuandoOEmailForValidoNenhumaExcecaoELancada()
	{
		$email = 'jjcorsif@hotmail.com';
		new Email($email);
	}
}
