<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario;

final class Email
{
	private $enderecoDeEmail;

	public function __construct($enderecoDeEmail)
	{
		$this->enderecoDeEmail = $this->validarEmail($enderecoDeEmail);
	}

	public function enderecoDeEmail()
	{
		return $this->enderecoDeEmail;
	}

	private function validarEmail($email)
	{
		if (
			!is_string($email)
			or trim($email) === ''
			or preg_match('/^[a-z0-9.!#$%&\'*+\/=?^_`{|}~-]+\@[a-z0-9]+(\.([a-z0-9]+))+$/iD', trim($email)) !== 1
		) {
			throw new \Exception('O email informado não é valido.');
		}

		return trim($email);
	}
}
