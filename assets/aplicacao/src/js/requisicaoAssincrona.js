import {jQuery} from './vendor/jQuery.js';

async function requisicaoAjaxComJQuery(
	url,
	metodoHttp = 'GET',
	data = {},
	callbackAntesDeEnviar = () => {},
	callbackEmCasoDeSucesso = (resposta, textStatus, jqXHR) => {},
	callbackEmCasoDeFalha = (jqXHR, textStatus, errorThrown) => {},
	callbackEmTodosOsCasos = () => {}
) {
	await jQuery
		.ajax({
			url,
			type: metodoHttp,
			data,
			beforeSend: callbackAntesDeEnviar,
		})
		.done(callbackEmCasoDeSucesso)
		.fail(callbackEmCasoDeFalha)
		.always(callbackEmTodosOsCasos);
}

export {jQuery, requisicaoAjaxComJQuery};