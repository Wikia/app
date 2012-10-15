<?php

header("Cache-Control: no-cache");
header("HTTP/1.0 404 Not Found");
exit(0);

/**
if (preg_match("/^\/google([0-9a-f]{16}).html$/", $_SERVER["REQUEST_URI"], $matches)) {
	header("Cache-Control: public, max-age=3600", true);
	echo "google-site-verification: google{$matches[1]}.html";
} else {
	header("Cache-Control: no-cache");
	header("HTTP/1.0 404 Not Found");
}
**/