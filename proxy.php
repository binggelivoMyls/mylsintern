<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
if (isset($_GET["url"])){ 
    $url = $_GET["url"];
    echo file_get_contents($url);
}else{
?>
<body style="font-family: Helvetica, sans-serif; background-color: #ECF0F1">
<h1>API Proxy</h1>
<h2>How to:</h2>
<p>Der API Proxy funktioniert ganz einfach. Einfach die API-Url and die Url 
	<br>
	<span style="font-family: Courier, monospace; background-color: #FCF3CF">https://mylsintern.mls-test.ch/proxy.php?url=</span>
</p>
<h2>Einschrängungen</h2>
<p>Im Moment sind nur GET Abfragen möchlich keine POST. Ebenfalls funktionieren keine Tokens und kein OAuth.</p>
<h2>Tipps:</h2>
<p>Wenn du die Url im JavaScript übergeben möchtest ist es einfacher wenn du die URL mit <span style="font-family: Courier, monospace; background-color: #FCF3CF">encodeURIComponent()</span> encodest.</p>
</body>
<?php
}	
?>