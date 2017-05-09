<?php
/** Internationalization file for /extensions/wikia/WikiaRSS/WikiaRss extension. */
$messages = [];

$messages['en'] = [
	'wikia-rss-desc' => 'Enhanced 3rd party RSS extension. Loads RSS data asynchronously via AJAX requests and displays a RSS feed on a wiki page',
	'wikia-rss-error-parse' => 'A parse error occurred. Check if data you provided to <rss> tag is valid.',
	'wikia-rss-error-ajax-loading' => 'An error occurred while fetching RSS data. Try again or change your <rss> tag data.',
	'wikia-rss-error-invalid-options' => 'Invalid options set. Make sure you pass at least valid url to the RSS source, please.',
	'wikia-rss-empty' => 'No feeds found on: $1',
	'wikia-rss-error' => 'An error occurred during fetching feeds from: $1. Error: $2',
	'wikia-rss-placeholder-loading' => 'Loading RSS data...',
	'wikia-rss-date-format' => 'm/d/Y',
	'wikia-rss-error-wrong-status-404' => 'The provided RSS link is probably an invalid RSS feed or the page does not exist.',
	'wikia-rss-error-wrong-status-503' => 'The service is unavailable. It is possible the URL is busy or we exceeded limit of queries to the RSS URL address.',
];

$messages['qqq'] = [
	'wikia-rss-empty' => '$1 is a rss url given in parser tag',
	'wikia-rss-error' => '$1 is a rss url given in parser tag, $2 is an error description',
];

$messages['fr'] = [
	'wikia-rss-date-format' => 'd/m/Y',
	'wikia-rss-desc' => 'Extension RSS tierce-partie améliorée. Charge les données RSS de façon asynchrone via des requêtes AJAX et affiche un flux RSS sur une page de wikia.',
	'wikia-rss-empty' => 'Aucun flux trouvé sur : $1',
	'wikia-rss-error-ajax-loading' => 'Une erreur est survenue lors de la récupération des données RSS. Veuillez réessayer ou modifier les données de la balise <nowiki><rss></nowiki>.',
	'wikia-rss-error-invalid-options' => 'Mauvaises options définies. SVP, assurez-vous de passer au mois une URL valide comme source du RSS.',
	'wikia-rss-error-parse' => 'Une erreur de parsage est survenue. Vérifiez que les données fournies à la balise <nowiki><rss></nowiki> sont valides.',
	'wikia-rss-error-wrong-status-404' => 'Le lien RSS fourni est probablement un flux RSS non valide ou la page n\'existe pas.',
	'wikia-rss-error-wrong-status-503' => 'Le service est indisponible. Il est possible que l\'URL soit occupée ou que nous avons dépassé la limite de requêtes vers l\'adresse URL du flux RSS.',
	'wikia-rss-error' => 'Une erreur est survenue lors de la récupération du flux de : $1. Erreur : $2.',
	'wikia-rss-placeholder-loading' => 'Chargement des données RSS...',
];

$messages['ko'] = [
	'wikia-rss-date-format' => 'Y/m/d',
	'wikia-rss-empty' => '다음에서 피드를 찾을 수 없습니다: $1',
	'wikia-rss-error-ajax-loading' => 'RSS 데이터를 불러오는 데 오류가 발생했습니다. <rss> 태그를 올바르게 수정한 후에 다시 시도해보세요.',
	'wikia-rss-error-invalid-options' => '올바르지 않은 설정이 있습니다. 올바르게 고치신 후 다시 시도해보세요.',
	'wikia-rss-error-parse' => '구문 해석 오류가 발생했습니다. 입력한 <rss> 태그가 올바른지 확인한 후 다시 시도해보세요.',
	'wikia-rss-error-wrong-status-404' => '지정한 RSS 링크에 올바른 RSS 피드가 존재하지 않습니다.',
	'wikia-rss-error-wrong-status-503' => 'RSS 피드를 일시적으로 불러올 수 없습니다. 트래픽이 초과했거나 서버가 폭주 상태일 수 있습니다.',
	'wikia-rss-error' => '다음에서 피드를 불러오는 데 오류가 발생했습니다: $1. 오류 내역: $2',
	'wikia-rss-placeholder-loading' => 'RSS 데이터를 불러오고 있습니다...',
];

$messages['ru'] = [
	'wikia-rss-date-format' => 'м/д/г',
];

$messages['vi'] = [
	'wikia-rss-date-format' => 'd/m/Y',
];

$messages['pl'] = [
	'wikia-rss-desc' => 'Rozszerza strony RSS osób trzecich. Dane RSS sa ładowane asynchronicznie poprzez żądania AJAX i wyświetlane na kanale RSS na stronie wiki.',
	'wikia-rss-empty' => 'Nie znaleziono kanałów dla: $1',
	'wikia-rss-error-ajax-loading' => 'Wystąpił błąd podczas pobierania danych RSS. Spróbuj ponownie lub zmień dane tagu <rss>.',
	'wikia-rss-error-invalid-options' => 'Ustawione opcję są nieprawidłowe. Upewnij się, że posiadają co najmniej jeden poprawny adres URL RSS.',
	'wikia-rss-error-parse' => 'Wystąpił błąd parsowania. Sprawdź czy dane przekazywane przez tag <rss> są poprawne.',
	'wikia-rss-error-wrong-status-404' => 'Odnośnik RSS jest prawdopodobnie nieprawidłowy lub strona nie istnieje.',
	'wikia-rss-error-wrong-status-503' => 'Usługa jest niedostępna. Możliwe jest, że adres URL jest zajęty lub przekroczony został limit zapytań do adresu RSS URL.',
	'wikia-rss-error' => 'Wystąpił błąd podczas pobierania kanałów z: $1. Błąd: $2',
	'wikia-rss-placeholder-loading' => 'Ładowanie danych RSS...',
];

$messages['ja'] = [
	'wikia-rss-error-wrong-status-404' => '提供されたRSSリンクは妥当なRSSフィードでないか、ページが存在しない可能性があります。',
];

