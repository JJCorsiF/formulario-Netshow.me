<?php

namespace JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Persistencia\Arquivo;

use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Aplicacao\Repositorios\RepositorioDeAnexos;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada\Anexo;

final class RepositorioDeAnexosEmArquivo implements RepositorioDeAnexos
{
	public function armazenarAnexo(Anexo $anexo)
	{
		defined('DIRETORIO_DE_ANEXOS') or define('DIRETORIO_DE_ANEXOS', __DIR__ . '/../../../../../../public/anexos/');
		$diretorioCompleto = DIRETORIO_DE_ANEXOS . $anexo->caminhoDoAnexo();

		$arquivoArmazenadoComSucesso = file_put_contents($diretorioCompleto, $anexo->conteudoDoAnexo());

		if ($arquivoArmazenadoComSucesso !== FALSE) {
			return $diretorioCompleto;
		}

		return FALSE;
	}

	public function buscarAnexo($caminhoDoAnexo)
	{
		$diretorioCompleto = DIRETORIO_DE_ANEXOS . $caminhoDoAnexo;

		$conteudoDoAnexoArmazenado = file_get_contents($diretorioCompleto);

		if ($conteudoDoAnexoArmazenado === FALSE) {
			return NULL;
		}

		return new Anexo($caminhoDoAnexo, base64_encode($conteudoDoAnexoArmazenado));
	}
}
