<?php

function isRedirectOn() {
//	$requestedURL = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$requestedURL = $_SERVER['REQUEST_URI'];
//	echo "<!-- requestedURL: ".$requestedURL." -->";
//	$requestedURL = str_replace('http://', '', $requestedURL);
//	$requestedURL = str_replace('https://', '', $requestedURL);

	$redirectOn = array();
	$redirectOn[] = 'http://www.wikia.com/';
//	$redirectOn[] = 'http://www.wikia.com/wiki/Wikia';

	if ( array_search ( $requestedURL, $redirectOn ) !== false ) {
		return true;
	}
}

function getRedirectURL() {
	$accept_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$accept_langs = explode(',', $accept_lang);
	$prefered = array();

	foreach ($accept_langs as $lang) {
		ereg('([a-z]{1,2})(-([a-z0-9]+))?(;q=([0-9\.]+))?', $lang, $found);
		$code = $found[1];
		$morecode = $found[3];
		$fullcode = $morecode ? $code . '-'. $morecode : $code;
		$coef = sprintf('%3.1f', $found[5] ? $found[5] : '1.0');
		$key = $coef;
		$prefered[$key] = array( 'code' => $code, 'coef' => $coef, 'morecode' => $morecode, 'fullcode' => $fullcode);
	}
	krsort( $prefered );

	if( $prefered['1.0']['code'] == 'en' ) {
		return false;
	}

	$lang_links = array();
	$lang_links['bg'] = 'http://www.wikia.com/wiki/%D0%9D%D0%B0%D1%87%D0%B0%D0%BB%D0%BD%D0%B0_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0';
	$lang_links['da'] = 'http://www.wikia.com/wiki/Forside';
	$lang_links['de'] = 'http://de.wikia.com/wiki/Hauptseite';
	$lang_links['eo'] = 'http://www.wikia.com/wiki/Vikiurboj';
	$lang_links['es'] = 'http://www.wikia.com/wiki/Portada';
	$lang_links['fr'] = 'http://www.wikia.com/wiki/Accueil';
	$lang_links['id'] = 'http://www.wikia.com/wiki/Halaman_Utama';
	$lang_links['it'] = 'http://www.wikia.com/wiki/Pagina_principale';
	$lang_links['ja'] = 'http://ja.wikia.com/wiki/%E3%83%A1%E3%82%A4%E3%83%B3%E3%83%9A%E3%83%BC%E3%82%B8';
	$lang_links['pl'] = 'http://pl.wikia.com/wiki/Strona_g%C5%82%C3%B3wna';
	$lang_links['pt'] = 'http://www.wikia.com/wiki/P%C3%A1gina_principal';
	$lang_links['ru'] = 'http://www.wikia.com/wiki/%D0%9D%D0%B0%D1%87%D0%B0%D0%BB%D1%8C%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0';
	$lang_links['sv'] = 'http://www.wikia.com/wiki/Huvudsida';

	foreach ($prefered as $lang) {
		if( $lang_links[$lang['code']] != '' ) {
			return $lang_links[$lang['code']];
		}
	}

	return false;
}

if(isRedirectOn() === true) {
	if(($url = getRedirectURL()) !== false) {
		header('Location: '.$url);
		exit();
	}
}
?>
