function carrega(page) {

		scroll(0,0);

	if (window.XMLHttpRequest)

		ajax = new XMLHttpRequest();

	else

		ajax = new ActiveXObject("Microsoft.XMLHTTP");

	ajax.open("GET", page, true);

	ajax.onreadystatechange=function() {

		if (ajax.readyState == 1)

			document.getElementById("centro").innerHTML = "<img src='images/loading.gif'><br><br><center>Por favor, aguarde!</center>";

		if (ajax.readyState == 4) {

			document.getElementById("centro").innerHTML = ajax.responseText;

			newTag();

		}

	}

	ajax.send(null);

}
