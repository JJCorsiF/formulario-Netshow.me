<?php

use JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Persistencia\Arquivo\RepositorioDeAnexosEmArquivo;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada\Anexo;

class AnexoTest extends \Codeception\Test\Unit
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before()
	{
	}

	protected function _after()
	{
	}

	// tests
	public function testeQuandoOAnexoNaoForValidoUmaExcecaoELancada()
	{
		$conteudoDoAnexoDecodificado = '';
		$tamanhoDoArquivo = strlen($conteudoDoAnexoDecodificado);
		$this->assertLessThanOrEqual(500, $tamanhoDoArquivo, 'O anexo é grande demais');

		$this->expectException(Exception::class);
		$caminhoDoAnexo = '';
		$conteudoDoAnexo = base64_encode($conteudoDoAnexoDecodificado);
		new Anexo($caminhoDoAnexo, $conteudoDoAnexo);

		$finfo = finfo_open();
		$mime_type = finfo_buffer($finfo, $conteudoDoAnexoDecodificado, FILEINFO_MIME_TYPE);

		$mimeTypesAceitos = [
			'application/msword',
			'application/pdf',
			'application/vnd.ms-office',
			'application/vnd.oasis.opendocument.text',
			'text/plain'
		];

		$this->assertNotContains($mime_type, $mimeTypesAceitos, 'O anexo não está em um formato aceitável.');
	}

	public function testeQuandoOAnexoForValidoNenhumaExcecaoELancada()
	{
		$conteudoDoAnexoDecodificado = 'texto';
		$tamanhoDoArquivo = strlen($conteudoDoAnexoDecodificado);
		$this->assertLessThanOrEqual(500, $tamanhoDoArquivo, 'O anexo é grande demais');

		$caminhoDoAnexo = 'anexo.txt';
		//$this->assertIsWritable(DIRETORIO_DE_ANEXOS . $caminhoDoAnexo, 'O diretório não tem permissão de escrita');
		$conteudoDoAnexo = base64_encode($conteudoDoAnexoDecodificado);
		new Anexo($caminhoDoAnexo, $conteudoDoAnexo);
	}

	public function testeUmaExcecaoELancadaQuandoOConteudoDoAnexoForMaiorQue($tamanhoMaximoDoConteudo = Anexo::TAMANHO_MAXIMO_ACEITAVEL)
	{
		$texto = 'texto';
		$tamanhoDoConteudo = strlen($texto);
		$numeroDeIteracoes = ceil($tamanhoMaximoDoConteudo / $tamanhoDoConteudo);
		$conteudoDoAnexoDecodificado = ' ';
		for (
			$i = 0;
			$i < $numeroDeIteracoes;
			$i++
		) {
			$conteudoDoAnexoDecodificado .= $texto;
		}

		$tamanhoDoArquivo = strlen($conteudoDoAnexoDecodificado);
		$this->assertGreaterThan($tamanhoMaximoDoConteudo, $tamanhoDoArquivo, 'O anexo é aceitável.');

		$this->expectException(Exception::class);
		$caminhoDoAnexo = 'anexo.txt';
		//$this->assertIsWritable(DIRETORIO_DE_ANEXOS . $caminhoDoAnexo, 'O diretório não tem permissão de escrita');
		$conteudoDoAnexo = base64_encode($conteudoDoAnexoDecodificado);
		new Anexo($caminhoDoAnexo, $conteudoDoAnexo);
	}

	public function testeNenhumaExcecaoELancadaQuandoOConteudoDoAnexoForMenorOuIgualA($tamanhoMaximoDoConteudo = Anexo::TAMANHO_MAXIMO_ACEITAVEL)
	{
		$conteudoDoAnexoDecodificado = 'texto';
		$tamanhoDoArquivo = strlen($conteudoDoAnexoDecodificado);
		$this->assertLessThanOrEqual($tamanhoMaximoDoConteudo, $tamanhoDoArquivo, 'O anexo é grande demais');

		$caminhoDoAnexo = 'anexo.txt';
		//$this->assertIsWritable(DIRETORIO_DE_ANEXOS . $caminhoDoAnexo, 'O diretório não tem permissão de escrita');
		$conteudoDoAnexo = base64_encode($conteudoDoAnexoDecodificado);
		new Anexo($caminhoDoAnexo, $conteudoDoAnexo);
	}

	public function testeQuandoOMimetypeDoArquivoNaoForAceitoUmaExcecaoELancada()
	{
		$this->expectException(Exception::class);
		$conteudoDoAnexo = 'UEsDBBQAAAAIALtNf0ob+L4OhsIAAADIAQAMAAAAU3R1ZGlvQlIucGxn1L0NeFNF9gd806Q0LSkN0PKhIFGD8m1rUYFSTWmDBQFDS8tn1UBTGixtN70XUCm0m/YvlzFr14Vd96/uny64qy67WxS14FcgpaWCWgpCoSBVcL0lgAUqBKjkPWfuJL0NKu7zPs/7PG8fuWfuzO+cOTNz5syZuffGmQssXBjHcRouhvP7Oa6Wk/9M3G3cLf9UHLdTz/UZtj3ysztrVTM+u7Oqak6+vcRQ7Cha6rAuNywXSnjDYpvBIRQahMJcm8Mw116YeH90lPGhW4n+/+rPYua4GaoIbvATU0YF8tq431X3VoUN5sZAA1+W84ZMgrQeEiYVXuR0GPab/BegnL47Mww7KPinl3k4RopVXF0u0KdU3KheMjpQ3uOvTcVp+/9E/v/Lv9TH08xIx49i7cK2Bhsh/xlAu7SUOSmY1mEZth11jVe2i/aGe0pmJk2/FgEXCyt/sCcO/tzj7LlW3srJbYa2c9qbcSbE2WQc7SPoKy4P6MM34SzjHLaCoiWc3EfQV1ws0C0/hStxLMEbPV5YX9fejOuRgWOJf3tvgfv/8Z9Gb+KiemXyDnvh0nmQ/qU/LA+YyIyxJm4e/FsE/56Cf3Pg36AxJm48/LPAv4g5jy9eZlvC+4fHWlM44vYP1zOqY1TLqIbREYxyjBoZ7XpKpj5GOxntYPQsoxKjpxltY/Q4oy2MHmLUwOQ3sfv9jE5g+eMZjWd0Lys3sfs6du+mNNNZ9+EHUdAxcyTR7/dfTjOOUfHhMe8vMsYTj7MubaEHsR8ynlpGtzNaw+hWRt9gdAujm+Q6sj9uy0rhnA9zwqT8NJhAyzjpDaiM7K1sFMIT3U8s9FQfB4CoEqORJjaT3Wq3K22XhtwhDhJ7TXFeyxXOkl5ELw4AbJXIiSaNB+WSi6RFeg1EVbqZIDJAtGhJtka06Eh/US/O04hTNKK6RoVlFg3R…';
		$conteudoDoAnexoDecodificado = base64_decode($conteudoDoAnexo);
		$caminhoDoAnexo = 'anexo.zip';
		//$this->assertIsWritable(DIRETORIO_DE_ANEXOS . $caminhoDoAnexo, 'O diretório não tem permissão de escrita');
		new Anexo($caminhoDoAnexo, $conteudoDoAnexo);

		$finfo = finfo_open();
		$mime_type = finfo_buffer($finfo, $conteudoDoAnexoDecodificado, FILEINFO_MIME_TYPE);

		$mimeTypesAceitos = [
			'application/msword',
			'application/pdf',
			'application/vnd.ms-office',
			'application/vnd.oasis.opendocument.text',
			'text/plain'
		];

		$this->assertNotContains($mime_type, $mimeTypesAceitos, 'O anexo não está em um formato aceitável.');
	}

	public function testeQuandoOMimetypeDoArquivoForAceitoNenhumaExcecaoELancada()
	{
		$conteudoDoAnexoDecodificado = 'texto';
		$finfo = finfo_open();
		$mime_type = finfo_buffer($finfo, $conteudoDoAnexoDecodificado, FILEINFO_MIME_TYPE);

		$mimeTypesAceitos = [
			'application/msword',
			'application/pdf',
			'application/vnd.ms-office',
			'application/vnd.oasis.opendocument.text',
			'text/plain'
		];

		$this->assertContains($mime_type, $mimeTypesAceitos, 'O anexo não está em um formato aceitável.');

		$caminhoDoAnexo = 'anexo.txt';
		//$this->assertIsWritable(DIRETORIO_DE_ANEXOS . $caminhoDoAnexo, 'O diretório não tem permissão de escrita');
		$conteudoDoAnexo = base64_encode($conteudoDoAnexoDecodificado);
		new Anexo($caminhoDoAnexo, $conteudoDoAnexo);
	}

	public function testeOAnexoEArmazenadoEmDisco()
	{
		$conteudoDoAnexoDecodificado = 'texto';
		$caminhoDoAnexo = 'anexo.txt';
		//$this->assertIsWritable(DIRETORIO_DE_ANEXOS . $caminhoDoAnexo, 'O diretório não tem permissão de escrita');
		$conteudoDoAnexo = base64_encode($conteudoDoAnexoDecodificado);
		$anexo = new Anexo($caminhoDoAnexo, $conteudoDoAnexo);
		$repositorioDeAnexos = new RepositorioDeAnexosEmArquivo();
		$arquivoArmazenadoComSucesso = $repositorioDeAnexos->armazenarAnexo($anexo);
		$this->assertNotFalse($arquivoArmazenadoComSucesso);
		$anexoArmazenado = $repositorioDeAnexos->buscarAnexo($caminhoDoAnexo);

		$this->assertSame($conteudoDoAnexoDecodificado, ($anexoArmazenado instanceof Anexo) ? $anexoArmazenado->conteudoDoAnexo() : json_encode($anexoArmazenado));
	}
}
