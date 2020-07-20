import { jQuery } from './vendor/jQuery.js';

import {leitorDeArquivo} from './leitorDeArquivos.js';
import {requisicaoAjaxComJQuery} from './requisicaoAssincrona.js';
import * as i18n from './formulario.i18n.pt-br.js';

jQuery('#anexo').on(
	'change',
	() => {
		const anexo = document.getElementById('anexo');
		if (anexo.files && anexo.files[0]) {
			leitorDeArquivo.readAsDataURL(anexo.files[0]);
		}
	}
);

jQuery('#formularioParaContato').on('submit', (event) => {
	event.preventDefault();
	const botaoDeSubmit = document.getElementById(
		'botaoDeSubmitDoFormularioDeMensagem'
	);
	const textoDoBotao = botaoDeSubmit.innerHTML;
	botaoDeSubmit.innerHTML = i18n.sendingMessage;
	botaoDeSubmit.disabled = true;
	const url = 'formulario/submeterFormulario';
	const metodoHttp = 'POST';
	
	const anexo = document.getElementById('labelDoAnexo').innerText;
	const arquivo = document.getElementById('arquivo').value.replace(/^.*;base64,/, '');
	const contato = document.getElementById('telefone').value;
	const email = document.getElementById('email').value;
	const mensagem = document.getElementById('mensagem').value;
	const nome = document.getElementById('nome').value;
	
	if (anexo.length === 0 || arquivo.length === 0 || contato.length === 0 || email.length === 0 || mensagem.length === 0 || nome.length === 0) {
		const notificacoes = document.getElementById('notificacoes');
		const heading = notificacoes.querySelector('h4');
		heading.innerHTML = i18n.pleaseFillAllInput;

		jQuery('#notificacoes').show('slow');
		setTimeout(() => {
			jQuery('#notificacoes').hide('slow');
			heading.innerHTML = '';
		}, 5000);
		
		
		botaoDeSubmit.innerHTML = textoDoBotao;
		botaoDeSubmit.disabled = false;
		return false;
	}
	
	const data = {
		anexo,
		arquivo,
		contato,
		email,
		mensagem,
		nome
	};
	
	const callbackAntesDeEnviar = () => {};
	const callbackEmCasoDeSucesso = (resposta, textStatus, jqXHR) => {
		const notificacoes = document.getElementById('notificacoes');
		const heading = notificacoes.querySelector('h4');
		
		heading.innerHTML = resposta[0].mensagem;
	};
	const callbackEmCasoDeFalha = (jqXHR, textStatus, errorThrown) => {
		const notificacoes = document.getElementById('notificacoes');
		const heading = notificacoes.querySelector('h4');
		
		console.table({ errorThrown });
		
		heading.innerHTML = errorThrown;
	};
	const callbackEmTodosOsCasos = () => {
		jQuery('#notificacoes').show('slow');
		const notificacoes = document.getElementById('notificacoes');
		const heading = notificacoes.querySelector('h4');
		
		setTimeout(() => {
			jQuery('#notificacoes').hide('slow');
			heading.innerHTML = '';
		}, 5000);
		
		const botaoDeSubmit = document.getElementById(
			'botaoDeSubmitDoFormularioDeMensagem'
		);
		botaoDeSubmit.innerHTML = textoDoBotao;
		botaoDeSubmit.disabled = false;
	};
	requisicaoAjaxComJQuery(
		url,
		metodoHttp,
		data,
		callbackAntesDeEnviar,
		callbackEmCasoDeSucesso,
		callbackEmCasoDeFalha,
		callbackEmTodosOsCasos
	);
});

export { jQuery, leitorDeArquivo, requisicaoAjaxComJQuery };