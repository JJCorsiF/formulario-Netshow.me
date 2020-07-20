<?php

use JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Busca\GerenciadorDeConfiguracoesEmJson;
use JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Notificacoes\Email\Phpmailer\MensageiroDeEmailDoPhpmailer;
use JJCorsiF\Aplicacao\CodigoFonte\Infraestrutura\Persistencia\Arquivo\RepositorioDeAnexosEmArquivo;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada\Anexo;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\MensagemEnviada\MensagemEnviada;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Email;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Telefone;
use JJCorsiF\Aplicacao\CodigoFonte\NucleoDaAplicacao\Componentes\Formulario\Dominio\Usuario\Usuario;

final class Formulario extends CI_Controller
{
	const CODIGO_DE_RETORNO_NENHUM_ARQUIVO_VALIDO = 0;

	private $gerenciadorDeConfiguracoes;

	private $mensageiroDeEmail;

	public $repositorioDeMensagensEnviadas;

	public $repositorioDeUsuarios;

	public function __construct()
	{
		parent::__construct();

		$this->gerenciadorDeConfiguracoes = new GerenciadorDeConfiguracoesEmJson(DIRETORIO_DA_APLICACAO . 'configuracoes/email.json');

		$this->mensageiroDeEmail = new MensageiroDeEmailDoPhpmailer(new GerenciadorDeConfiguracoesEmJson(DIRETORIO_DA_APLICACAO . 'configuracoes/smtp.json'));
		$this->repositorioDeAnexos = new RepositorioDeAnexosEmArquivo();
		//$this->repositorioDeUsuarios = new RepositorioDeUsuariosDoCodeigniter();
		$this->load->repository('RepositorioDeMensagensEnviadasDoCodeigniter', 'repositorioDeMensagensEnviadas');
		$this->load->repository('RepositorioDeUsuariosDoCodeigniter', 'repositorioDeUsuarios');
	}


	public function index()
	{
		$this->load->helper('url');

		$this->load->view('formulario');
	}

	public function submeterFormulario()
	{
		$this->load->helper('url');

		try {
			$anexo = $this->solicitarArmazenamentoDeAnexo();

			$nome = $this->input->post('nome');
			$emailDeOrigem = $this->input->post('email');
			$telefone = $this->input->post('contato');

			$usuario = new Usuario($nome, new Email($emailDeOrigem), new Telefone($telefone));

			$usuario = $this->solicitarArmazenamentoDeUsuario($usuario);

			$mensagem = $this->input->post('mensagem');

			$resposta = $this->solicitarEnvioDeEmail($usuario, $anexo, $mensagem);
		} catch (Exception $ex) {
			$resposta = [
				'codigo' => $ex->getCode(),
				'mensagem' => $ex->getMessage(),
				'status' => 'falha',
			];
		}

		$respostaEmJson = json_encode(
			$resposta,
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
		);

		return $this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output($respostaEmJson);
	}


	private function solicitarArmazenamentoDeAnexo()
	{
		$this->load->helper('security');

		$nomeDoAnexo = $this->input->post('anexo');
		$extensao = substr($nomeDoAnexo, strrpos($nomeDoAnexo, '.'));
		$conteudoDoAnexo = $this->security->xss_clean($this->input->post('arquivo'));

		if (empty($conteudoDoAnexo) or $this->security->xss_clean($conteudoDoAnexo, TRUE) === FALSE) {
			throw new Exception('Não foi selecionado nenhum arquivo válido.', self::CODIGO_DE_RETORNO_NENHUM_ARQUIVO_VALIDO);
		}

		$nomeDoArquivo = md5((new DateTime('now'))->format('Y-m-d H:i:s')) . $extensao;
		$caminhoDoAnexo = urlencode(sanitize_filename($nomeDoArquivo));
		$anexo = new Anexo($caminhoDoAnexo, $conteudoDoAnexo);
		$this->repositorioDeAnexos->armazenarAnexo($anexo);

		return $anexo;
	}


	private function solicitarArmazenamentoDeUsuario(Usuario $usuario)
	{
		$idDoUsuario = $this->repositorioDeUsuarios->armazenarUsuario($usuario);
		$usuario->informarId($idDoUsuario);
		return $usuario;
	}


	private function solicitarEnvioDeEmail(Usuario $usuario, Anexo $anexo, $mensagem)
	{
		$emailsDeDestino = $this->gerenciadorDeConfiguracoes->buscarConfiguracao('emailsDeDestino');
		$assunto = 'Você recebeu uma nova mensagem do formulário Netshow.me';
		$nomeDoUsuario = $usuario->nome();
		$enderecoDeEmail = $usuario->email()->enderecoDeEmail();
		$contato = $usuario->telefone()->numero();
		$urlDoAnexo = base_url() . 'public/anexos/' . rawurlencode($anexo->caminhoDoAnexo());
		$mensagem = 'Nome: ' . $nomeDoUsuario . '<br />Email: ' . $enderecoDeEmail . '<br />Contato: ' . $contato . '<br />Mensagem: ' . $mensagem . '<br />Anexo: ' . $urlDoAnexo;

		$respostaDoEnvioDeEmail = [];

		foreach ($emailsDeDestino as $emailDeDestino) {
			try {
				$respostaDoEnvioDeEmail[] = $this->mensageiroDeEmail->enviarEmail(new Email($emailDeDestino), $assunto, $mensagem);

				$mensagemEnviada = new MensagemEnviada($usuario->idDoUsuario(), $urlDoAnexo, $this->input->ip_address());
				$this->repositorioDeMensagensEnviadas->armazenarRegistro($mensagemEnviada);
			} catch (Exception $ex) {
				$respostaDoEnvioDeEmail[] = [
					'codigo' => $ex->getCode(),
					'emailDeDestino' => $emailDeDestino,
					'mensagem' => $ex->getMessage(),
					'status' => 'falha',
				];
			}
		}

		return $respostaDoEnvioDeEmail;
	}
}
