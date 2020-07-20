<?php

// namespace JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Persistencia\Codeigniter;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Repositorios\RepositorioDeUsuarios;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Email;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Usuario;
use Ramsey\Uuid\Uuid;

final class RepositorioDeUsuariosDoCodeigniter extends \CI_Model implements RepositorioDeUsuarios
{
	const NOME_DA_TABELA = 'usuario';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function armazenarUsuario(Usuario $usuario)
	{
		$usuariosExistentes = $this->buscarUsuarioPorEmail($usuario->email());

		if (count($usuariosExistentes) > 0) {
			return $usuariosExistentes[0]->id_usuario;
		}

		$informacoesDoUsuario = $this->converterUsuarioEmArray($usuario);

		$sucesso = $this->db->insert(self::NOME_DA_TABELA, $informacoesDoUsuario);

		$usuario->informarId($informacoesDoUsuario['id_usuario']);

		return ($sucesso !== FALSE ? $usuario->idDoUsuario() : FALSE);
	}

	public function buscarUsuarioPorEmail(Email $email)
	{
		return $this->db
			->select('id_usuario')
			->from(self::NOME_DA_TABELA)
			->where('email = "' . $email->enderecoDeEmail() . '"')
			->get()
			->result();
	}

	private function converterUsuarioEmArray(Usuario $usuario)
	{
		$array = [
			'id_usuario' => $this->gerarId(),
			'nome' => $usuario->nome(),
			'email' => $usuario->email()->enderecoDeEmail(),
			'telefone' => $usuario->telefone()->numero(),
		];

		return $array;
	}

	private function gerarId()
	{
		$uuid = Uuid::uuid4();

		return $uuid->toString();
	}
}
