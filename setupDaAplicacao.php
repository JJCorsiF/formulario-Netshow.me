<?php

$httpHost = 'https://' . $_SERVER['HTTP_HOST'];
$documentRoot = $_SERVER['DOCUMENT_ROOT'];
$fcPath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$dir = str_replace($documentRoot, '', $fcPath); //$httpHost . DIRECTORY_SEPARATOR
$scriptName = $_SERVER['SCRIPT_NAME'];
$currentDir = str_replace(
	dirname(dirname($scriptName)),
	'',
	dirname($scriptName)
);
$parentDir = str_replace($currentDir, '', $dir);
$base_url = 'https://' . $_SERVER['HTTP_HOST'] . str_replace(
	basename($_SERVER['SCRIPT_NAME']),
	'',
	$_SERVER['SCRIPT_NAME']
);

//echo 'HTTP HOST: ', $httpHost . DIRECTORY_SEPARATOR, "<br />\n";
//echo 'SERVER[DOCUMENT_ROOT]: ', $documentRoot, "<br />\n";
//echo 'DIR: ', $dir, "<br />\n";
//echo "<br />\n";
//echo 'SCRIPTNAME: ', $scriptName, "<br />\n";
//echo 'SCRIPTNAME: ', dirname($scriptName), "<br />\n";
//echo 'SCRIPTNAME: ', dirname(dirname(dirname($scriptName))), "<br />\n";
//echo 'CURRENT FILENAME: ', $currentFileName = basename($scriptName), "<br />\n";
//echo 'CURRENT DIRNAME: ', $currentDir, "<br />\n";
//echo 'PARENT DIR: ', $parentDir, "<br />\n";
//echo 'PARENT DIR without HTTP HOST: ', str_replace($httpHost . DIRECTORY_SEPARATOR, '', $parentDir), "<br />\n";
//echo 'BASE_URL: ', $base_url . "<br />\n";

$rootUrl = $httpHost . DIRECTORY_SEPARATOR;

//echo $parentDir . "<br />\n";

if (is_string($parentDir) && $parentDir !== '/') {
	$rootUrl .= $parentDir;
}

define('ROOT_URL', $rootUrl);

//echo 'ROOT_URL: ', ROOT_URL, "<br />\n";

//require $fcPath . 'app/aplicacao/vendor/autoload.php';

defined('DIRETORIO_DA_APLICACAO') or define('DIRETORIO_DA_APLICACAO', APPPATH . 'aplicacao' . DIRECTORY_SEPARATOR);
defined('DIRETORIO_DE_PERSISTENCIA') or define('DIRETORIO_DE_PERSISTENCIA', DIRETORIO_DA_APLICACAO . 'codigo-fonte' . DIRECTORY_SEPARATOR . 'Infraestrutura' . DIRECTORY_SEPARATOR . 'Persistencia' . DIRECTORY_SEPARATOR);
defined('DIRETORIO_DE_ANEXOS') or define('DIRETORIO_DE_ANEXOS', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'anexos' . DIRECTORY_SEPARATOR);
