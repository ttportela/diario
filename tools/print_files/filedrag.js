/*
filedrag.js - HTML5 File Drag & Drop demonstration
Featured on SitePoint.com
Developed by Craig Buckler (@craigbuckler) of OptimalWorks.net
*/
(function() {

	// getElementById
	function $id(id) {
		return document.getElementById(id);
	}

	function guid() {
	  function s4() {
	    return Math.floor((1 + Math.random()) * 0x10000)
	      .toString(16)
	      .substring(1);
	  }
	  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
	    s4() + '-' + s4() + s4() + s4();
	}


	// output information
	function Output(msg) {
		Uppend("messages", msg);
	}

	// output information
	function Uppend(inid, msg) {
		var m = $id(inid);
		m.innerHTML = msg + m.innerHTML;
	}


	// file drag hover
	function FileDragHover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.target.className = (e.type == "dragover" ? "hover" : "");
	}


	// file selection
	function FileSelectHandler(e) {

		// cancel event and hover styling
		FileDragHover(e);

		// fetch FileList object
		var files = e.dataTransfer.files || e.target.files;

		// READ STUDENT NAME:
		var person = prompt("Digite o Nome do Aluno:", "");

		var uuid = guid();
		Uppend("print_files", "<div id='"+uuid+"'></div><hr/>");

		// WRITE STUDENT NAME:
		Uppend("print_files", "<h3>"+person+"</h3><hr/>");

		// WRITE PAGE BREAK:
		Uppend("print_files", "<p style='page-break-after:always;'></p>");

		// process all File objects
		for (var i = 0, f; f = files[i]; i++) {
			ParseFile(f, uuid);
		}

	}


	// output file information
	function ParseFile(file, uuid) {

		Output(
			"<p>File information: <strong>" + file.name +
			"</strong> type: <strong>" + file.type +
			"</strong> size: <strong>" + file.size +
			"</strong> bytes</p>"
		);

		// display an image
		if (file.type.indexOf("image") == 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
				Uppend("print_files", 
					"<p><strong>" + file.name + ":</strong><br />" +
					'<img src="' + e.target.result + '" /></p>'
				);
			}
			reader.readAsDataURL(file);
		}

		// display text
		if (file.type.indexOf("text") == 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
				/*Output(
					"<p><strong>" + file.name + ":</strong></p><pre>" +
					e.target.result.replace(/</g, "&lt;").replace(/>/g, "&gt;") +
					"</pre>"
				);*/
				Uppend(uuid, 
					"<p><strong>" + file.name + ":</strong></p><pre class='prettyprint'>" +
					e.target.result.replace(/</g, "&lt;").replace(/>/g, "&gt;") +
					"</pre>"
				);
				PR.prettyPrint();
			}
		    /*reader.onerror = function(e) {
		      	console.log("error", e);
		      	console.log (e.getMessage());
		      	Output(
					"<p>Error reading file: <strong>" + file.name +
					" msg: " + e.getMessage() + "</p>"
				);
		    }*/
			reader.readAsText(file);
		}

	}


	// initialize
	function Init() {

		var fileselect = $id("fileselect"),
			filedrag = $id("filedrag"),
			submitbutton = $id("submitbutton");

		// file select
		fileselect.addEventListener("change", FileSelectHandler, false);

		// is XHR2 available?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {

			// file drop
			filedrag.addEventListener("dragover", FileDragHover, false);
			filedrag.addEventListener("dragleave", FileDragHover, false);
			filedrag.addEventListener("drop", FileSelectHandler, false);
			filedrag.style.display = "block";

			// remove submit button
			submitbutton.style.display = "none";
		}

	}

	// call initialization file
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}


})();
