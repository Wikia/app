<?php
/**
 * Author: Sean Colombo
 * Date: 20100127
 *
 * Internationalization file for Interstitials extension.
 */

$messages = array();

$messages['en'] = array(
	// If we were displaying interstitials but there is no campaign code, this would be an egregious error.
	// An extremely friendly message is probably much better than a blank interstitial.  At least we get to tell them
	// how we feel for X seconds.
	"interstitial-default-campaign-code" => "Wikia Loves You!",
	"interstitial-skip-ad" => "Skip this ad",

	"interstitial-already-logged-in-no-link" => "You are already logged in and there is no destination set.",
	"interstitial-disabled-no-link" => "There is no destination set and interstitials are not enabled on this wiki.",
	"interstitial-link-away" => "There is nothing to see here!<br /><br />Would you like to go to the [[{{MediaWiki:Mainpage}}|Main Page]] or perhaps a [[Special:Random|random page]]?",

	// oasis Exitstitial
	"exitstitial-title" => "Leaving ", // @todo FIXME: no trailing whitespace support in Translate extension. Needs parameter or hard coded space.
	"exitstitial-register" => "<a href=\"#\" class=\"register\">Register</a> or <a href=\"#\" class=\"login\">Login</a> to skip ads.",
	"exitstitial-button" => "Skip This Ad"
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'interstitial-disabled-no-link' => "''On the World Wide Web, interstitials are web page advertisements that are displayed before or after an expected content page, often to display advertisements or confirm the user's age.''",
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'interstitial-default-campaign-code' => 'Wikia те обича!',
);

/** Breton (brezhoneg)
 * @author Fohanno
 */
$messages['br'] = array(
	'interstitial-default-campaign-code' => "Wikia a gar ac'hanoc'h !",
);

/** Czech (česky)
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'interstitial-default-campaign-code' => 'Wikia Vás miluje!',
	'interstitial-skip-ad' => 'Přeskočit tuto reklamu',
	'interstitial-already-logged-in-no-link' => 'Jste již přihlášeni a není nastaven žádný cíl.',
	'interstitial-disabled-no-link' => 'Není nastavena destinace a interstitials nejsou na této wiki povoleny.',
	'interstitial-link-away' => 'Není tu nic k vidění!<br /><br />Chcete jít na [[{{MediaWiki:Mainpage}}|hlavní stránku]] nebo na [[Special:Random|náhodnou stránku]]?',
	'exitstitial-register' => '<a href="#" class="register">Registrujte se</a> nebo <a href="#" class="login">se přihlašte</a> pro přeskočení reklam.',
	'exitstitial-button' => 'Přeskočit tuto reklamu',
);

/** German (Deutsch)
 * @author LWChris
 */
$messages['de'] = array(
	'interstitial-default-campaign-code' => 'Wikia Liebt Dich!',
	'interstitial-skip-ad' => 'Anzeige überspringen',
	'interstitial-already-logged-in-no-link' => 'Du bist bereits angemeldet und es wurde kein Ziel angegeben.',
	'interstitial-disabled-no-link' => 'Es wurde kein Ziel angegeben und Interstitials sind in diesem Wiki nicht aktiviert.',
	'interstitial-link-away' => 'Es gibt hier nichts zu sehen!<br /><br />Möchtest du zur [[{{MediaWiki:Mainpage}}|Hauptseite]] oder vielleicht auf eine [[Special:Random|zufällige Seite]]?',
	'exitstitial-register' => '<a href="#" class="register">Registrieren</a> oder <a href="#" class="login">Anmelden</a> um Anzeigen zu überspringen.',
	'exitstitial-button' => 'Diese Anzeige Überspringen',
);

/** Spanish (español)
 * @author Bola
 */
$messages['es'] = array(
	'interstitial-default-campaign-code' => '¡Wikia te quiere!',
	'interstitial-skip-ad' => 'Omitir este anuncio',
	'interstitial-already-logged-in-no-link' => 'Ya estás identificado y no hay ninguna configuración destinada',
	'interstitial-disabled-no-link' => 'No hay ninguna configuración destinada y no está activado en este wiki interstitials.',
	'interstitial-link-away' => '¡Aquí no hay nada que ver!<br /><br />¿Prefieres ir a la [[{{MediaWiki:Mainpage}}|Portada]] o quizás prefieres una [[Special:Random|página aleatoria]]?',
	'exitstitial-register' => '<a href="#" class="register">Regístrate</a> o <a href="#" class="login">identifícate</a> para omitir la publicidad.',
	'exitstitial-button' => 'Omitir este anuncio',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Tofu II
 */
$messages['fi'] = array(
	'interstitial-default-campaign-code' => 'Wikia rakastaa sinua!',
	'interstitial-skip-ad' => 'Ohita tämä mainos',
	'exitstitial-button' => 'Ohita tämä mainos',
);

/** French (français)
 * @author Brunoperel
 * @author Crochet.david
 * @author Iketsi
 * @author Zcqsc06
 */
$messages['fr'] = array(
	'interstitial-default-campaign-code' => 'Wikia vous aime !',
	'interstitial-skip-ad' => 'Ignorer cette annonce',
	'interstitial-already-logged-in-no-link' => "Vous êtes déjà connecté et il n'y a pas de destination.",
	'interstitial-disabled-no-link' => "Il n'ya pas de destination et les interstitiels ne sont pas activés sur ce wiki.",
	'interstitial-link-away' => 'Il n’y a rien à voir ici !<br /><br />Si vous souhaitez aller à la [[{{MediaWiki:Mainpage}}|page d’accueil]] ou peut-être une [[Special:Random|une page au hasard]] ?',
	'exitstitial-register' => '<a href="#" class="register">Inscription</a> ou <a href="#" class="login">connexion</a> pour sauter les publicité.',
	'exitstitial-button' => 'Ignorer cette annonce',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'interstitial-default-campaign-code' => 'Wikia quérete!',
	'interstitial-skip-ad' => 'Saltar este anuncio',
	'interstitial-already-logged-in-no-link' => 'Xa está conectado e non hai ningún destino fixado.',
	'interstitial-disabled-no-link' => 'Non hai ningún destino fixado e as páxinas intersticiais non están activadas neste wiki.',
	'interstitial-link-away' => 'Non hai nada que ver aquí!<br /><br />Desexa ir á [[{{MediaWiki:Mainpage}}|páxina principal]] ou quizais a unha [[Special:Random|páxina ao chou]]?',
	'exitstitial-register' => '<a href="#" class="register">Rexístrexe</a> ou <a href="#" class="login">acceda ao sistema</a> para saltar os anuncios.',
	'exitstitial-button' => 'Saltar este anuncio',
);

/** Hungarian (magyar)
 * @author Dani
 * @author TK-999
 */
$messages['hu'] = array(
	'interstitial-default-campaign-code' => 'A Wikia szeret téged!',
	'interstitial-skip-ad' => 'Hirdetés átugrása',
	'interstitial-already-logged-in-no-link' => 'Már bejelentkeztél és nincs cél beállítva.',
	'interstitial-disabled-no-link' => 'Nincsen cél megadva, és az oldalközi hirdetések nem engedélyezettek ezen a wikin.',
	'interstitial-link-away' => 'Itt nincs semmi látnivaló!<br /><br />Szeretnél a [[{{MediaWiki:Mainpage}}|főoldalra]] vagy egy [[Special:Random|véletlenszerű oldalra]] menni?',
	'exitstitial-register' => '<a href="#" class="register">Regisztrálj</a> vagy <a href="#" class="login">lépj be</a> a hirdetések átugrásához.',
	'exitstitial-button' => 'Hirdetés átugrása',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'interstitial-default-campaign-code' => 'Wikia te ama!',
	'interstitial-skip-ad' => 'Saltar iste annuncio',
	'interstitial-already-logged-in-no-link' => 'Tu ha jam aperite session e il non ha un destination definite.',
	'interstitial-disabled-no-link' => 'Nulle destination ha essite definite e le annuncios interstitial non es activate in iste wiki.',
	'interstitial-link-away' => 'Il ha nihil a vider hic!<br /><br />Vole tu ir al [[{{MediaWiki:Mainpage}}|pagina principal]] o forsan a un [[Special:Random|pagina aleatori]]?',
	'exitstitial-register' => '<a href="#" class="register">Crea un conto</a> o <a href="#" class="login">aperi session</a> pro saltar le publicitate.',
	'exitstitial-button' => 'Saltar iste annuncio',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'interstitial-default-campaign-code' => 'Викија ве сака!',
	'interstitial-skip-ad' => 'Прескокни ја рекламава',
	'interstitial-already-logged-in-no-link' => 'Веќе сте најавени, а нема зададено одредница.',
	'interstitial-disabled-no-link' => 'Нема зададено одредница, а на викито не се овозможени меѓупросторни реклами.',
	'interstitial-link-away' => 'Тука нема што да се види!<br /><br />Дали би сакале да појдете на [[{{MediaWiki:Mainpage}}|Главната страница]] или пак да отворите [[Special:Random|случајна]]?',
	'exitstitial-register' => '<a href="#" class="register">Регистрирајте се</a> или <a href="#" class="login">Најавете се</a> за да ги прескокнете рекламите.',
	'exitstitial-button' => 'Прескокни ја рекламава',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'interstitial-default-campaign-code' => 'വിക്കിയ താങ്കളെ സ്നേഹിക്കുന്നു!',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'interstitial-default-campaign-code' => 'Wikia Sayang Anda!',
	'interstitial-skip-ad' => 'Langkau iklan ini',
	'interstitial-already-logged-in-no-link' => 'Anda sudah log masuk tetapi destinasi belum ditetapkan.',
	'interstitial-disabled-no-link' => 'Destinasi tidak ditetapkan, dan ruang-antara (<i>interstitials</i>) tidak dihidupkan di wiki ini.',
	'interstitial-link-away' => 'Di sini tiada apa-apa langsung!<br /><br />Adakah anda ingin ke [[{{MediaWiki:Mainpage}}|Laman Utama]] ataupun [[Special:Random|memilih laman secara rawak]]?',
	'exitstitial-register' => '<a href="#" class="register">Berdaftar</a> atau <a href="#" class="login">Log Masuk</a> untuk melangkaui iklan.',
	'exitstitial-button' => 'Langkau Iklan Ini',
);

/** Norwegian Bokmål (norsk (bokmål)‎)
 * @author Audun
 */
$messages['nb'] = array(
	'interstitial-default-campaign-code' => 'Wikia elsker deg!',
	'interstitial-skip-ad' => 'Hopp over annonse',
	'interstitial-already-logged-in-no-link' => 'Du er allerede logget inn, og det er ikke angitt et mål.',
	'interstitial-disabled-no-link' => 'Det er ikke valgt noe mål, og entrésider er ikke aktivert for denne wikien.',
	'interstitial-link-away' => 'Det er ingenting å se her!<br /><br />Vil du gå til [[{{MediaWiki:Mainpage}}|hovedsiden]] eller kanskje til en [[Special:Random|tilfeldig side]]?',
	'exitstitial-register' => '<a href="#" class="register">Registrer deg</a> eller <a href="#" class="login">Logg inn</a> for å hoppe over annonser.',
	'exitstitial-button' => 'Hopp over annonse',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'interstitial-default-campaign-code' => 'Wikia houdt van u!',
	'interstitial-skip-ad' => 'Deze advertentie overslaan',
	'interstitial-already-logged-in-no-link' => 'U bent al aangemeld en er is nog geen bestemming ingesteld.',
	'interstitial-disabled-no-link' => 'Er is nog geen bestemming ingesteld en voorloopadvertenties zijn niet ingeschakeld op deze wiki.',
	'interstitial-link-away' => 'Er is hier niets te zien!<br /><br />Wilt u naar de [[{{MediaWiki:Mainpage}}|Hoofdpagina]] of misschien naar een [[Special:Random|willekeurige pagina]]?',
	'exitstitial-register' => '<a href="#" class="register">Registreer</a> of <a href="#" class="login">Meld u aan</a> om advertenties te kunnen verbergen.',
	'exitstitial-button' => 'Deze advertentie overslaan',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'interstitial-default-campaign-code' => 'Wikia houdt van jou!',
	'interstitial-already-logged-in-no-link' => 'Je bent al aangemeld en er is nog geen bestemming ingesteld.',
	'interstitial-link-away' => 'Er is hier niets te zien!<br /><br />Wil je naar de [[{{MediaWiki:Mainpage}}|Hoofdpagina]] of misschien naar een [[Special:Random|willekeurige pagina]]?',
);

/** Polish (polski)
 * @author Cloudissimo
 * @author Sovq
 */
$messages['pl'] = array(
	'interstitial-default-campaign-code' => 'Wikia Cię Kocha!',
	'interstitial-skip-ad' => 'Pomiń tę reklamę',
	'interstitial-already-logged-in-no-link' => 'Jesteś już zalogowany i nie ustawiono lokalizacji docelowej.',
	'interstitial-disabled-no-link' => 'Nie ustawiono docelowej lokalizacji a strony pośrednie nie są włączone na tej wiki.',
	'interstitial-link-away' => 'Nie ma tu nic do oglądania! <br /><br />Może chcesz zobaczyć [[{{MediaWiki:Mainpage}}|Stronę główną]] lub [[Special:Random|losową stronę]]?',
	'exitstitial-register' => '<a href="#" class="register">Zarejestruj się</a> lub <a href="#" class="login">zaloguj</a> żeby ominąć reklamy.',
	'exitstitial-button' => 'Pomiń reklamę',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'interstitial-default-campaign-code' => 'Wikia at Veul Bin!',
	'interstitial-skip-ad' => "Sauté s'areclam",
	'interstitial-already-logged-in-no-link' => "A l'é già intrà ant ël sistema e a-i son gnun-e destinassion ampostà.",
	'interstitial-disabled-no-link' => 'A-i son gnun-e destinassion ampostà e ij trames a son pa abilità su sta wiki.',
	'interstitial-link-away' => "A-i é gnente da vëdde ambelessì!<br /><br />Veul-lo andé a la [[{{MediaWiki:Mainpage}}|Pàgina d'intrada]] o miraco a na [[Special:Random|pàgina qualsëssìa]]?",
	'exitstitial-register' => '<a href="#" class="register">Argistresse</a> o <a href="#" class="login">Intré ant ël sistema</a> për sauté j\'areclam.',
	'exitstitial-button' => "Sauté S'areclam",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'interstitial-default-campaign-code' => 'ويکييا له تاسې سره مينه لري!',
	'interstitial-skip-ad' => 'له دې خبرتيا تېرېدل',
	'exitstitial-register' => 'د خبرتيا نه تېرېدلو لپاره <a href="#" class="register">نومليکنه</a> or <a href="#" class="login">ننوتنه</a> ترسره کړۍ.',
	'exitstitial-button' => 'له دې خبرتيا تېرېدل',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'interstitial-default-campaign-code' => 'A Wikia Ama-te!',
	'interstitial-skip-ad' => 'Ignorar este anúncio',
	'interstitial-already-logged-in-no-link' => 'Já está autenticado e não está definido nenhum destino.',
	'interstitial-disabled-no-link' => 'Não está definido nenhum destino nem estão activadas intersticiais nesta wiki.',
	'interstitial-link-away' => 'Não há nada para ver aqui!<br /><br />Deseja ir para a [[{{MediaWiki:Mainpage}}|Página principal]] ou talvez para uma [[Special:Random|página aleatória]]?',
	'exitstitial-register' => '<a href="#" class="register">Registe-se</a> ou <a href="#" class="login">Autentique-se</a> para ignorar anúncios.',
	'exitstitial-button' => 'Ignorar este anúncio',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 */
$messages['pt-br'] = array(
	'interstitial-default-campaign-code' => 'A Wikia ama você!',
	'interstitial-skip-ad' => 'Ignore este anúncio',
	'interstitial-already-logged-in-no-link' => 'Você já está autenticado e não há nenhum destino especificado.',
	'interstitial-disabled-no-link' => 'Nenhum destino foi especificado e as intersticiais não estão ativadas neste wiki.',
	'interstitial-link-away' => 'Não há nada para ver aqui!<br /><br />Deseja ir para a [[{{MediaWiki:Mainpage}}|Página principal]] ou talvez para uma [[Special:Random|página aleatória]]?',
	'exitstitial-register' => '<a href="#" class="register">Registre-se</a> ou <a href="#" class="login">Autentique-se</a> para ignorar anúncios.',
	'exitstitial-button' => 'Ignore este anúncio',
);

/** Russian (русский)
 * @author Kuzura
 * @author Ole Yves
 */
$messages['ru'] = array(
	'interstitial-default-campaign-code' => 'Викия любит вас!',
	'interstitial-skip-ad' => 'Пропустить эту рекламу',
	'interstitial-already-logged-in-no-link' => 'Вы уже вошли в систему, и не можете выбирать другие учётные записи.',
	'interstitial-disabled-no-link' => 'Не существует назначения набора и междоузлия не включены на этой вики.',
	'interstitial-link-away' => 'Здесь ничего увидеть нельзя!<br /><br />Вы хотите перейти к [[{{MediaWiki:Mainpage}}|Заглавной странице]] или возможно [[Special:Random|случайной странице]]?',
	'exitstitial-register' => '<a href="#" class="register">Зарегистрироваться</a> или <a href="#" class="login">войти</a>, чтобы пропустить рекламу.',
	'exitstitial-button' => 'Пропустить эту рекламу',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'interstitial-default-campaign-code' => 'Викија вас воли!',
	'interstitial-skip-ad' => 'Прескочи оглас',
	'exitstitial-button' => 'Прескочи оглас',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'interstitial-default-campaign-code' => 'Wikia älskar dig!',
	'interstitial-skip-ad' => 'Hoppa över denna annons',
	'interstitial-already-logged-in-no-link' => 'Du redan är inloggad och det inte finns någon destination inställd.',
	'interstitial-disabled-no-link' => 'Det finns ingen destination angiven och mellanrum är inte aktiverade på denna wiki.',
	'interstitial-link-away' => 'Det finns ingenting att se här!<br /><br />Vill du gå till [[{{MediaWiki:Mainpage}}|Huvudsidan]] eller kanske en [[Special:Random|slumpartad sida]]?',
	'exitstitial-register' => '<a href="#" class="register">Registrera</a> eller <a href="#" class="login">Logga in</a> för att hoppa över annonser.',
	'exitstitial-button' => 'Hoppa över denna annons',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'interstitial-default-campaign-code' => 'Mahal Ka ng Wikia!',
	'interstitial-skip-ad' => 'Laktawan ang patalastas na ito',
	'interstitial-already-logged-in-no-link' => 'Nakalagda ka na at walang nakatakdang patutunguhan.',
	'interstitial-disabled-no-link' => 'Walang itinakdang kapupuntahan at hindi pinagagana ang mga siwang sa wiking ito.',
	'interstitial-link-away' => 'Walang makikita rito!<br /><br />Nais mo bang pumunta sa [[{{MediaWiki:Mainpage}}|Pangunahing Pahina]] o marahil sa [[Special:Random|alin mang pahina]]?',
	'exitstitial-register' => '<a href="#" class="register">Magpatala</a> o <a href="#" class="login">Lumagda</a> upang laktawan ang mga patalastas.',
	'exitstitial-button' => 'Laktawan ang Patalastas na Ito',
);

/** толышә зывон (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'interstitial-default-campaign-code' => 'Викиа пидәше шымәни!',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'interstitial-default-campaign-code' => 'Викия сезне ярата!',
	'interstitial-skip-ad' => 'Бу рекламаны калдырырга',
	'interstitial-already-logged-in-no-link' => 'Сез инде системага кердегез һәм башка хисап язмаларын сайлый алмыйсыз.',
	'interstitial-disabled-no-link' => 'There is no destination set and interstitials are not enabled on this wiki.',
	'interstitial-link-away' => 'Монда берни дә күреп булмый!<br /><br />Сез [[{{MediaWiki:Mainpage}}|Баш биткә ]] яки  [[Special:Random|очраклы сәхифәгә]] күчәргә телисезме?',
	'exitstitial-register' => '<a href="#" class="register">Теркәлү</a> яки <a href="#" class="login">Керү</a> (реклама булмасын өчен).',
	'exitstitial-button' => 'Бу рекламаны калдырырга',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 */
$messages['zh-hans'] = array(
	'interstitial-default-campaign-code' => 'Wikia爱你！',
	'interstitial-skip-ad' => '跳过这则广告',
	'exitstitial-button' => '跳过这则广告',
);

