<?php 
// Check to see if $_SERVER[PHP_AUTH_USER] already contains info
if (!isset($_SERVER[PHP_AUTH_USER])) {
	// If empty, send header causing dialog box to appear
	header('WWW-Authenticate: Basic realm="Sementes da Sorte"');
	header('HTTP/1.0 401 Unauthorized');
	echo 'Authorization Required.';
	exit;
} else {
	// If not empty, do something else
// Try to validate against hard-coded values
	if (($_SERVER[PHP_AUTH_USER] != "admin") && ($_SERVER[PHP_AUTH_PW] != "53m3nt3")) {
		header('HTTP/1.0 401 Unauthorized');
		echo 'Authorization Required.';
		exit;
	}
}
?>
