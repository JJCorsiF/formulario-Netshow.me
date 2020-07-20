<?php

// namespace JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Persistencia\Codeigniter;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Repositorios\RepositorioDeMensagensEnviadas;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada\MensagemEnviada;
use Ramsey\Uuid\Uuid;

final class RepositorioDeMensagensEnviadasDoCodeigniter extends \CI_Model implements RepositorioDeMensagensEnviadas
{
	const NOME_DA_TABELA = 'mensagem_enviada';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function armazenarRegistro(MensagemEnviada $mensagemEnviada)
	{
		$dadosDaMensagemEnviada = [
			'id_mensagem_enviada' => $this->gerarId(),
			'id_usuario' => $mensagemEnviada->idDoUsuario(),
			'url_do_anexo' => $mensagemEnviada->urlDoAnexo(),
			'ip_do_dispositivo' => $mensagemEnviada->ipDoDispositivo(),
			'data_do_envio' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
		];

		$this->db->insert(self::NOME_DA_TABELA, $dadosDaMensagemEnviada);
	}

	private function gerarId()
	{
		$uuid = Uuid::uuid4();

		return $uuid->toString();
	}
}
