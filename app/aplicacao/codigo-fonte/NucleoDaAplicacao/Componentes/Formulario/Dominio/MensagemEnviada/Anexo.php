<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada;

final class Anexo
{
	const TAMANHO_MAXIMO_ACEITAVEL = 500 * 1024;

	private $caminhoDoAnexo;

	private $conteudoDoAnexo;

	public function __construct($caminhoDoAnexo, $conteudoDoAnexo)
	{
		$this->validarCaminhoDoAnexo($caminhoDoAnexo);
		$conteudoDoAnexo = $this->validarConteudoDoAnexo($conteudoDoAnexo);

		$this->caminhoDoAnexo = $caminhoDoAnexo;
		$this->conteudoDoAnexo = $conteudoDoAnexo;
	}

	private function validarCaminhoDoAnexo($caminhoDoAnexo)
	{
		if (!is_string($caminhoDoAnexo) or $caminhoDoAnexo === '') {
			throw new \Exception('O nome do arquivo deve ser um texto não vazio.');
		}
	}

	private function validarConteudoDoAnexo($conteudoDoAnexo)
	{
		if ($conteudoDoAnexo === FALSE or !is_string($conteudoDoAnexo) or $conteudoDoAnexo === '') {
			throw new \Exception('Ocorreu um erro ao decodificar o conteúdo do anexo (ou o conteúdo está vazio).');
		}

		$conteudoDoAnexoDecodificado = base64_decode($conteudoDoAnexo);

		$finfo = finfo_open();
		$mime_type = finfo_buffer($finfo, $conteudoDoAnexoDecodificado, FILEINFO_MIME_TYPE);

		switch ($mime_type) {
			case 'application/msword':
			case 'application/pdf':
			case 'application/vnd.ms-office':
			case 'application/vnd.oasis.opendocument.text':
			case 'text/plain':
				break;
			default:
				throw new \Exception('O anexo não está em um formato aceitável.');
		}

		$tamanhoDoArquivo = strlen($conteudoDoAnexoDecodificado);

		if ($tamanhoDoArquivo > self::TAMANHO_MAXIMO_ACEITAVEL) {
			throw new \Exception('O tamanho do anexo (' . ($tamanhoDoArquivo / 1024) . 'kb) excede o máximo aceitável (' . (self::TAMANHO_MAXIMO_ACEITAVEL / 1024) . 'kb).');
		}

		return $conteudoDoAnexoDecodificado;
	}

	public function caminhoDoAnexo()
	{
		return $this->caminhoDoAnexo;
	}

	public function conteudoDoAnexo()
	{
		return $this->conteudoDoAnexo;
	}
}
