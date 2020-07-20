<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario;

final class Telefone
{
	private $numero;

	public function __construct($numero)
	{
		$this->numero = $this->validarNumero($numero);
	}

	private function validarNumero($numero)
	{
		if (preg_match('/^[0-9]{11}$/', preg_replace('/[^0-9]/', '', trim($numero))) !== 1) {
			throw new \Exception('O número para contaro deve conter 11 dígitos (ddd incluso).');
		}

		return trim($numero);
	}

	public function numero()
	{
		return $this->numero;
	}
}
