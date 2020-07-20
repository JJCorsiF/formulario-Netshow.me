import * as i18n from './leitorDeArquivos.i18n.pt-br.js';

const leitorDeArquivo = new FileReader();

leitorDeArquivo.onload = (onLoadEvent) => {
	const arquivos = document.getElementById('anexo').files;
	const arquivo = document.getElementById('arquivo');
	if (arquivos.length > 0) {
		const tamanhoDoArquivo = arquivos[0].size;

		if (tamanhoDoArquivo > 500 * 1024) {
			arquivo.value = '';
			labelDoAnexo.innerHTML = i18n.filesileIsgraterThanMaximumAllowed;
			return false;
		}

		switch (arquivos[0].type) {
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-office':
			case 'application/vnd.oasis.opendocument.text':
			case 'text/plain':
				labelDoAnexo.innerHTML = arquivos[0].name;
				arquivo.value = onLoadEvent.target.result;
				return true;
			default:
				arquivo.value = '';
				labelDoAnexo.innerHTML = i18n.invalidFile;
				return false;
		}
	}

	arquivo.value = '';
	labelDoAnexo.innerHTML = i18n.noFileSelected;
	return false;
};

export {
	leitorDeArquivo
};