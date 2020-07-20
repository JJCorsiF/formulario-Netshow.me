<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario;

/**
 * Usuario
 */
final class Usuario
{
	/**
	 * idDoUsuario
	 *
	 * @var mixed
	 */
	private $idDoUsuario;

	/**
	 * nome
	 *
	 * @var mixed
	 */
	private $nome;

	/**
	 * email
	 *
	 * @var Email 
	 */
	private $email;

	/**
	 * telefone
	 *
	 * @var Telefone
	 */
	private $telefone;

	/**
	 * __construct
	 *
	 * @param  mixed $nome
	 * @param  mixed $email
	 * @param  mixed $telefone
	 * @return void
	 */
	public function __construct($nome, Email $email, Telefone $telefone)
	{
		$this->nome = $this->validarNome($nome);
		$this->email = $email;
		$this->telefone = $telefone;
	}

	/**
	 * validarNome
	 *
	 * @param  mixed $nome
	 * @return void
	 */
	private function validarNome($nome)
	{
		if (!is_string($nome) or trim($nome) === '') {
			throw new \Exception('O campo nome deve ser um texto não vazio.');
		}

		return trim($nome);
	}

	/**
	 * informarId
	 *
	 * @param  mixed $idDoUsuario
	 * @return void
	 */
	public function informarId($idDoUsuario)
	{
		$this->idDoUsuario = $idDoUsuario;
	}

	/**
	 * idDoUsuario
	 *
	 * @return type
	 */
	public function idDoUsuario()
	{
		return $this->idDoUsuario;
	}

	/**
	 * nome
	 *
	 * @return type
	 */
	public function nome()
	{
		return $this->nome;
	}

	/**
	 * email
	 *
	 * @return Email
	 */
	public function email(): Email
	{
		return $this->email;
	}

	/**
	 * telefone
	 *
	 * @return Telefone
	 */
	public function telefone(): Telefone
	{
		return $this->telefone;
	}
}
