<?php
/**
 * @ingroup Wikia
 * @package AutoHubsPages
 * @file AutoHubsPages.i18n.php
 */

$messages = array();

$messages['en'] = array(
	'unhide' => 'Unhide',
	'hub-blog-header' => 'Top $1 Posts',
	'hub-hotspot-header' => 'Hot Spots',
	'hub-topusers-header' => 'Top $1 Users',
	'hub-featured' => 'Top $1 wikis',
	'hub-header' => '$1 Wikis',
	'hub-hotspot-info' => 'These are the hottest pages this week, ranked by most editors.',
	'hub-blog-comments' => '{{PLURAL:$1|one comment|$1 comments}}',
	'hub-blog-continue' => 'Continue reading',
	'hub-blog-showarticle' => 'Show page',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">edit {{PLURAL:$1|point|points}}</span>',
	'hub-hotspot-from' => 'from', # @todo FIXME: should be followed by a parameter; requires template change.
	'hub-hide-feed' => 'Hide feed',
	'hub-show-feed' => 'Show Feed',
	'hub-contributors-info' => 'These are the top users this week, ranked by most edits.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editors}}</span>',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'unhide' => 'Toggle link to show what is hidden.',
	'hub-blog-header' => 'Parameters:
* $1 is the blog title.',
	'hub-topusers-header' => 'Parameters:
* $1 is the list title.',
	'hub-featured' => 'Parameters:
* $1 is a page title.',
	'hub-header' => 'Parameters:
* $1 is a hub page title.',
	'hub-blog-comments' => 'Parameters:
* $1 is the number of comments.',
	'hub-topusers-editpoints' => 'Parameters:
* $1 is the number of edit points.',
	'hub-hotspot-from' => 'from',
	'hub-editors' => 'Parameters:
* $1 is the number of editors.',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'unhide' => 'Diskouez',
	'hub-blog-header' => 'Kemennadennoù pennañ $1',
	'hub-hotspot-header' => 'Pajennoù ar muiañ oberiant',
	'hub-topusers-header' => 'Implijerien pennañ eus $1',
	'hub-featured' => 'Wikioù pennañ eus $1',
	'hub-header' => 'Wikioù $1',
	'hub-blog-comments' => '{{PLURAL:$1|un evezhiadenn|$1 evezhiadenn}}',
	'hub-blog-continue' => "Kenderc'hel da lenn",
	'hub-blog-showarticle' => 'Gwelet ar bajenn',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|poent|poent}} kemmañ</span>',
	'hub-hotspot-from' => 'eus',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|oberour|oberour}}</span>',
);

/** Spanish (Español)
 * @author Absay
 */
$messages['es'] = array(
	'unhide' => 'Mostrar',
	'hub-blog-header' => 'Mensajes más populares de $1',
	'hub-hotspot-header' => 'Páginas con mayor actividad',
	'hub-topusers-header' => 'Lista $1 de usuarios con más ediciones',
	'hub-featured' => 'Wikis más populares de $1',
	'hub-header' => 'Wikis de $1',
	'hub-hotspot-info' => 'Estas son las páginas más populares de la semana, ordenadas por el número de editores.',
	'hub-blog-comments' => '{{PLURAL:$1|un comentario|$1 comentarios}}',
	'hub-blog-continue' => 'Seguir leyendo',
	'hub-blog-showarticle' => 'Mostrar página',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|punto|puntos}} de edición</span>',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Ocultar feed',
	'hub-show-feed' => 'Mostrar feed',
	'hub-contributors-info' => 'Estos son los usuarios más activos de esta semana, ordenados por su número de ediciones.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editores}}</span>',
);

/** French (Français)
 * @author Peter17
 */
$messages['fr'] = array(
	'unhide' => 'Afficher',
	'hub-blog-header' => 'Principaux messages de $1',
	'hub-hotspot-header' => 'Pages les plus actives',
	'hub-topusers-header' => 'Principaux utilisateurs de $1',
	'hub-featured' => 'Principaux wikis de $1',
	'hub-header' => 'Wikis de $1',
	'hub-hotspot-info' => 'Ces pages sont les plus actives cette semaine, triées par nombre d’auteurs.',
	'hub-blog-comments' => '{{PLURAL:$1|un commentaire|$1 commentaires}}',
	'hub-blog-continue' => 'Continuer la lecture',
	'hub-blog-showarticle' => 'Afficher la page',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|point|points}} de modification</span>',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Masquer le flux',
	'hub-show-feed' => 'Afficher le flux',
	'hub-contributors-info' => 'Ces utilisateurs sont les plus actifs cette semaine, classés par nombre de modifications.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|auteur|auteurs}}</span>',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'unhide' => 'Mostrar',
	'hub-blog-header' => 'Mensaxes máis populares de $1',
	'hub-hotspot-header' => 'Páxinas máis populares',
	'hub-topusers-header' => 'Os usuarios máis populares de $1',
	'hub-featured' => 'Os wikis máis populares de $1',
	'hub-header' => 'Wikis de $1',
	'hub-hotspot-info' => 'Estas son as páxinas máis populares desta semana, clasificadas polo número de editores.',
	'hub-blog-comments' => '{{PLURAL:$1|un comentario|$1 comentarios}}',
	'hub-blog-continue' => 'Continuar lendo',
	'hub-blog-showarticle' => 'Mostrar a páxina',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|punto|puntos}} de edición</span>',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Agochar a fonte de novas',
	'hub-show-feed' => 'Mostrar a fonte de novas',
	'hub-contributors-info' => 'Estes son os usuarios máis populares desta semana, clasificados polo número de edicións.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editores}}</span>',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'unhide' => 'Revelar',
	'hub-blog-header' => 'Top $1 de articulos',
	'hub-hotspot-header' => 'Paginas popular',
	'hub-topusers-header' => 'Top $1 de usatores',
	'hub-featured' => 'Top $1 de wikis',
	'hub-header' => 'Wikis de $1',
	'hub-hotspot-info' => 'Le paginas le plus popular de iste septimana, rangiate per numero de contributores.',
	'hub-blog-comments' => '{{PLURAL:$1|un commento|$1 commentos}}',
	'hub-blog-continue' => 'Continuar a leger',
	'hub-blog-showarticle' => 'Monstrar pagina',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|puncto|punctos}} de modification</span>',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Celar syndication',
	'hub-show-feed' => 'Revelar syndication',
	'hub-contributors-info' => 'Le usatores le plus productive de iste septimana, rangiate per numero de modificationes.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|redactor|redactores}}</span>',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'unhide' => 'Прикажи',
	'hub-blog-header' => 'Најкотирани $1 објави',
	'hub-hotspot-header' => 'Најактивни места',
	'hub-topusers-header' => 'Најкотирани $1 корисници',
	'hub-featured' => 'Најкотирани $1 викија',
	'hub-header' => 'Викија од $1',
	'hub-hotspot-info' => 'Ова се најактивните страници неделава, рангирани по број на уредници.',
	'hub-blog-comments' => '{{PLURAL:$1|еден коментар|$1 коментари}}',
	'hub-blog-continue' => 'Продолжете со читање',
	'hub-blog-showarticle' => 'Прикажи страница',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|бод|бода}} за уредување</span>',
	'hub-hotspot-from' => 'од',
	'hub-hide-feed' => 'Сокриј канал',
	'hub-show-feed' => 'Прикажи канал',
	'hub-contributors-info' => 'Ова се најкотираните корисници неделава, рангирани по број науредувања.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|уредник|уредници}}</span>',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'unhide' => 'Weergeven',
	'hub-blog-header' => 'Topberichten van $1',
	'hub-hotspot-header' => "Populaire pagina's",
	'hub-topusers-header' => 'Topgebruikers van $1',
	'hub-featured' => "Topwiki's van $1",
	'hub-header' => 'Wikia van $1',
	'hub-hotspot-info' => "Dit zijn de meer populaire pagina's van deze week, gesorteerd op aantal gebruikers met bewerkingen.",
	'hub-blog-comments' => '$1 {{PLURAL:$1|opmerking|opmerkingen}}',
	'hub-blog-continue' => 'Meer lezen',
	'hub-blog-showarticle' => 'Pagina weergeven',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">edit {{PLURAL:$1|punt|punten}}</span>',
	'hub-hotspot-from' => 'van',
	'hub-hide-feed' => 'Feed verbergen',
	'hub-show-feed' => 'Feed weergeven',
	'hub-contributors-info' => 'Dit zijn de topgebruikers van deze week, gesorteerd op het aantal bewerkingen.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|redacteur|redacteuren}}</span>',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'unhide' => 'Vis',
	'hub-blog-header' => 'Topp $1 poster',
	'hub-hotspot-header' => 'Hot Spots',
	'hub-topusers-header' => 'Topp $1 brukere',
	'hub-featured' => 'Topp $1 wikier',
	'hub-header' => '$ wikier',
	'hub-hotspot-info' => 'Dette er de heteste sidene denne uken, rangert etter flest redaktører.',
	'hub-blog-comments' => ' {{PLURAL:$1|én kommentar|$1 kommentarer}}',
	'hub-blog-continue' => 'Fortsett å lese',
	'hub-blog-showarticle' => 'Vis side',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">redigerings{{PLURAL:$1|poeng|poeng}}</span>',
	'hub-hotspot-from' => 'fra',
	'hub-hide-feed' => 'Skjul feed',
	'hub-show-feed' => 'Vis feed',
	'hub-contributors-info' => 'Dette er ukens toppbrukere, rangert etter flest redigeringer.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|redaktør|redaktører}}</span>',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'unhide' => 'Mostré',
	'hub-blog-header' => 'Prim $1 Mëssagi',
	'hub-hotspot-header' => 'Ròba Càuda',
	'hub-topusers-header' => 'Prim $1 Utent',
	'hub-featured' => 'Prime $1 wiki',
	'hub-header' => '$1 Wiki',
	'hub-hotspot-info' => 'Coste a son le pàgine pi ative dë sta sman-a, valutà da tanti editor.',
	'hub-blog-comments' => '{{PLURAL:$1|un coment|$1 coment}}',
	'hub-blog-continue' => 'Continua a lese',
	'hub-blog-showarticle' => 'Smon-e la pàgina',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt"> {{PLURAL:$1|pont|pont}} ëd modìfica</span>',
	'hub-hotspot-from' => 'da',
	'hub-hide-feed' => 'Stërmé ël fluss',
	'hub-show-feed' => 'Smon-e ël fluss',
	'hub-contributors-info' => 'Costi a son ij prim utent dë sta sman-a, an órdin ëd nùmer ëd modìfiche.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editor}}</span>',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'hub-blog-showarticle' => 'مخ ښکاره کول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'unhide' => 'Mostrar',
	'hub-blog-header' => 'Publicações Populares em $1',
	'hub-hotspot-header' => 'Pontos Quentes',
	'hub-topusers-header' => 'Maiores Editores em $1',
	'hub-featured' => 'Wikis de Topo em $1',
	'hub-header' => 'Wikis do Portal $1',
	'hub-hotspot-info' => 'Estas são as páginas mais populares da semana, ordenadas pelo número de editores.',
	'hub-blog-comments' => '{{PLURAL:$1|um comentário|$1 comentários}}',
	'hub-blog-continue' => 'Continuar a ler',
	'hub-blog-showarticle' => 'Mostrar página',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|ponto|pontos}} de edições</span>',
	'hub-hotspot-from' => 'da',
	'hub-hide-feed' => 'Esconder feed',
	'hub-show-feed' => 'Mostrar feed',
	'hub-contributors-info' => 'Estes são os melhores editores da semana, ordenados pelo número de edições.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editores}}</span>',
);

/** Russian (Русский)
 * @author Eleferen
 */
$messages['ru'] = array(
	'unhide' => 'Показать',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'hub-header' => '$1 விக்கிகள்',
	'hub-blog-continue' => 'படிப்பதைத் தொடரவும்',
	'hub-blog-showarticle' => 'பக்கத்தைக் காட்டவும்',
);

