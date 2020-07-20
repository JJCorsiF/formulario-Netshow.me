<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada;

final class MensagemEnviada
{
	private $id;

	private $idDoUsuario;

	private $ipDoDispositivo;

	private $urlDoAnexo;

	public function __construct($idDoUsuario, $urlDoAnexo, $ipDoDispositivo)
	{
		$this->idDoUsuario = $idDoUsuario;
		$this->urlDoAnexo = $urlDoAnexo;
		$this->ipDoDispositivo = $ipDoDispositivo;
	}

	public function informarId($id)
	{
		$this->id = $id;
	}

	public function id()
	{
		return $this->id;
	}

	public function idDoUsuario()
	{
		return $this->idDoUsuario;
	}

	public function urlDoAnexo()
	{
		return $this->urlDoAnexo;
	}

	public function ipDoDispositivo()
	{
		return $this->ipDoDispositivo;
	}
}
