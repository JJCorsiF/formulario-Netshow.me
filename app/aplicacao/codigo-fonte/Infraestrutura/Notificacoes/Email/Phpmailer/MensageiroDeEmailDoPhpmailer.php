<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Notificacoes\Email\Phpmailer;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Servicos\GerenciadorDeConfiguracoes;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Servicos\MensageiroDeEmail;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class MensageiroDeEmailDoPhpmailer implements MensageiroDeEmail
{
	private $gerenciadorDeConfiguracoes;

	public function __construct(GerenciadorDeConfiguracoes $gerenciadorDeConfiguracoes)
	{
		$this->gerenciadorDeConfiguracoes = $gerenciadorDeConfiguracoes;
	}

	public function enviarEmail(Email $email, $assunto, $mensagem)
	{
		$emailDeOrigem = new Email($this->gerenciadorDeConfiguracoes->buscarConfiguracao('emailDeOrigem'));
		$phpMailer = new PHPMailer(TRUE);
		$resposta = '';

		try {
			if ($this->gerenciadorDeConfiguracoes->buscarConfiguracao('isSMTP') === TRUE) {
				$phpMailer->isSMTP();
			}

			$phpMailer->Host = $this->gerenciadorDeConfiguracoes->buscarConfiguracao('host');
			$phpMailer->SMTPAuth = FALSE; //TRUE
			$phpMailer->Username = $this->gerenciadorDeConfiguracoes->buscarConfiguracao('username');;
			$phpMailer->Password = $this->gerenciadorDeConfiguracoes->buscarConfiguracao('password');
			$phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //PHPMailer::ENCRYPTION_SMTPS;
			$phpMailer->Port = 25; //587; //465;

			$phpMailer->setFrom($emailDeOrigem->enderecoDeEmail());
			$phpMailer->addAddress($email->enderecoDeEmail());

			$phpMailer->isHTML(TRUE);
			$phpMailer->CharSet = 'UTF-8';
			$phpMailer->Subject = $assunto;
			$phpMailer->Body = $mensagem;
			$phpMailer->AltBody = $mensagem;

			$emailEnviadoComSucesso = $phpMailer->send();

			if ($emailEnviadoComSucesso) {
				$resposta = [
					'codigo' => 200,
					'emailDeDestino' => $email->enderecoDeEmail(),
					'mensagem' => 'O email foi enviado com sucesso.',
					'status' => 'sucesso',
				];
			} else {
				$resposta = [
					'codigo' => 0,
					'emailDeDestino' => $email->enderecoDeEmail(),
					'mensagem' => 'O email não pôde ser enviado.',
					'status' => 'falha',
				];
			}
		} catch (Exception $excecao) {
			$resposta = [
				'codigo' => $excecao->getCode(),
				'emailDeDestino' => $email->enderecoDeEmail(),
				'erro' => $phpMailer->ErrorInfo,
				'mensagem' => 'O email não pôde ser enviado.',
				'status' => 'falha',
			];
		}

		return $resposta;
	}
}
