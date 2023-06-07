<!DOCTYPE html>
<!-- saved from url=(0068)http://blogs.sitepointstatic.com/examples/tech/filedrag/1/index.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>Arquivos</title>
<link rel="stylesheet" type="text/css" media="all" href="./print_files/styles.css">

</head>
<body>
<!-- <small><a onclick="window.history.back();">&lt; voltar</a></small> -->
<h1>Drag &amp; Drop API de Impressão de arquivos</h1>
<form id="upload" action="http://blogs.sitepointstatic.com/examples/tech/filedrag/1/index.html" method="POST" enctype="multipart/form-data">

<fieldset>
<legend>Arraste os Arquivos Aqui</legend>

<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000">

<div>
	<label for="fileselect">Arquivos:</label>
	<input type="file" id="fileselect" name="fileselect[]" multiple="multiple">
	<div id="filedrag" class="" style="display: block;">ou arraste os arquivos aqui</div>
</div>

<div id="submitbutton" style="display: none;">
	<button type="submit">Carregar</button>
</div>

</fieldset>

</form>

<div id="messages"><p>:: Mensagens de Status ::</p></div>

<!--p style="page-break-after:always;"></p-->

<div id="print_files"></div>

<script src="./print_files/filedrag.js"></script>

<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

</body></html>
