<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Busca;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Servicos\GerenciadorDeConfiguracoes;

final class GerenciadorDeConfiguracoesEmJson implements GerenciadorDeConfiguracoes
{
	private $arquivoDeConfiguracoes;

	public function __construct($arquivoDeConfiguracoes)
	{
		$this->arquivoDeConfiguracoes = $arquivoDeConfiguracoes;
	}

	public function buscarConfiguracao(string $itemConfiguravel)
	{
		if (!file_exists($this->arquivoDeConfiguracoes)) {
			throw new \Exception('O arquivo de configurações não foi encontrado.');
		}

		$conteudoDoArquivo = file_get_contents($this->arquivoDeConfiguracoes);

		if ($conteudoDoArquivo === FALSE) {
			throw new \Exception('Ocorreu um erro na leitura do arquivo informado.');
		}

		$conteudoDecodificado = json_decode($conteudoDoArquivo);

		if ($conteudoDecodificado === FALSE) {
			throw new \Exception('O conteúdo do arquivo não está em um formato JSON válido.');
		}

		if (!property_exists($conteudoDecodificado, $itemConfiguravel)) {
			throw new \Exception('O item configurável "' . $itemConfiguravel . '" não foi especificado no arquivo informado.');
		}

		return $conteudoDecodificado->{$itemConfiguravel};
	}
}
