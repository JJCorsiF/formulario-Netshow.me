<?php

use JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Busca\GerenciadorDeConfiguracoesEmJson;
use JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Notificacoes\Email\Phpmailer\MensageiroDeEmailDoPhpmailer;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Email;

class MensagemEnviadaTest extends \Codeception\Test\Unit
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
	public function testeEmailEEnviadoComSucesso()
	{
		//throw new Exception(__DIR__ . '/../../configuracoes/email.json');
		$mensageiroDeEmail = new MensageiroDeEmailDoPhpmailer(new GerenciadorDeConfiguracoesEmJson(__DIR__ . '/../../configuracoes/smtp.json'));
		$resposta = $mensageiroDeEmail->enviarEmail(new Email('a@b.c'), 'Teste de envio de email', 'Esse é um email de teste. Por favor, não o responda.');
	}
}
