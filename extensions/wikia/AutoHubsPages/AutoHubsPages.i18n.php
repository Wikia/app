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
	'hub-topusers-header' => 'Top Editor this week on $1 Wikis',
	'hub-featured' => 'Top $1 wikis',
	'hub-header' => '$1 Wikis',
	'hub-hotspot-info' => 'These are the hottest pages this week, ranked by most editors.',
	'hub-blog-comments' => '{{PLURAL:$1|one comment|$1 comments}}',
	'hub-blog-continue' => 'Continue reading',
	'hub-blog-showarticle' => 'Show page',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">edit {{PLURAL:$1|point|points}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 edit {{PLURAL:$1|point|points}}',
	'hub-hotspot-from' => 'from', # @todo FIXME: should be followed by a parameter; requires template change.
	'hub-hide-feed' => 'Hide feed',
	'hub-show-feed' => 'Show Feed',
	'hub-contributors-info' => 'These are the top users this week, ranked by most edits.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editors}}</span>',
	'hub-hot-news' => 'What\'s Hot',
	'hub-hot-news-post-details' => 'By $1 on $2 $3',
);

/** Message documentation (Message documentation)
 * @author McDutchie
 */
$messages['qqq'] = array(
	'unhide' => 'Toggle link to show what is hidden.',
	'hub-blog-header' => 'Parameters:
* $1 is the blog title.',
	'hub-topusers-header' => 'Parameters:
* $1 is the list title.',
	'hub-featured' => 'Heading of a section on the Wikia hub preceding a list of the top wikis in a particular category. For example: [http://www.wikia.com/Entertainment Top Entertainment wikis].
* $1 is the category. It stays in English even in the translated sentence.',
	'hub-header' => 'Parameters:
* $1 is a hub page title.',
	'hub-blog-comments' => 'Parameters:
* $1 is the number of comments.',
	'hub-topusers-editpoints' => 'Parameters:
* $1 is the number of edit points.',
	'hub-topusers-editpoints-nonformatted' => 'Parameters:
* $1 is the number of edit points.',
	'hub-editors' => 'Parameters:
* $1 is the number of editors.',
	'hub-hot-news-post-details' => 'Parameters:
* $1 is the username linked to userprofile.
* $2 is the wikiname linked to wiki main page.
* $3 is the publish date.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'hub-hotspot-from' => 'van',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'hub-topusers-header' => 'Top $1 istifadəçi',
	'hub-featured' => 'Top $1 viki',
	'hub-header' => '$1 Viki',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'hub-blog-comments' => '{{PLURAL:$1|един коментар|$1 коментара}}',
	'hub-blog-showarticle' => 'Показване на страницата',
	'hub-hotspot-from' => 'от',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'unhide' => 'Diskouez',
	'hub-blog-header' => 'Kemennadennoù pennañ $1',
	'hub-hotspot-header' => 'Pajennoù buhezekañ',
	'hub-topusers-header' => 'Implijerien pennañ eus $1',
	'hub-featured' => 'Wikioù pennañ eus $1',
	'hub-header' => 'Wikioù $1',
	'hub-hotspot-info' => 'Setu pajennoù buhezekañ ar sizhun, urzhiet dre an niver a skridaozerien.',
	'hub-blog-comments' => '{{PLURAL:$1|un evezhiadenn|$1 evezhiadenn}}',
	'hub-blog-continue' => "Kenderc'hel da lenn",
	'hub-blog-showarticle' => 'Gwelet ar bajenn',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|poent|poent}} kemmañ</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|poent|poent}} kemmañ',
	'hub-hotspot-from' => 'eus',
	'hub-hide-feed' => 'Kuzhat al lanvad',
	'hub-show-feed' => 'Diskouez al lanvad',
	'hub-contributors-info' => 'Setu implijerien oberiantañ ar sizhun, urzhiet dre an niver a gemmoù.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|oberour|oberour}}</span>',
);

/** Czech (Česky)
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'unhide' => 'Odkrýt',
	'hub-blog-header' => 'Vrchních $1 příspěvků',
	'hub-hotspot-header' => 'Žhavé body',
	'hub-topusers-header' => 'Vrchních $1 uživatelů',
	'hub-featured' => 'Vrchních $1 wiki',
	'hub-header' => '$1 Wiki',
	'hub-hotspot-info' => 'Tyto stránky jsou tento týden nejžhavější (dle počtu editorů)',
	'hub-blog-comments' => '{{PLURAL:$1|jeden komentář|$1 komentáře|$1 komentářů}}',
	'hub-blog-continue' => 'Pokračovat ve čtení',
	'hub-blog-showarticle' => 'Zobrazit stránku',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">editační{{PLURAL:$1| bod| body|ch bodů}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 editační {{PLURAL:$1| bod| body|ch bodů}}',
	'hub-hotspot-from' => 'od',
	'hub-hide-feed' => 'Skrýt informační kanál',
	'hub-show-feed' => 'Zobrazit informační kanál',
	'hub-contributors-info' => 'Toto jsou nejaktivnější uživatelé tento týden, dle počtu editací,',
	'hub-editors' => '<strong>$1</strong><span> {{PLURAL:$1|editor|editoři|editorů}}</span>',
);

/** German (Deutsch)
 * @author Diebuche
 * @author George Animal
 * @author LWChris
 * @author SVG
 * @author Tiin
 */
$messages['de'] = array(
	'unhide' => 'Einblenden���',
	'hub-blog-header' => 'Top $1 Beiträge',
	'hub-hotspot-header' => 'Angesagte Seiten',
	'hub-topusers-header' => 'Top-Bearbeiter in dieser Woche auf $1 Wikis',
	'hub-featured' => 'Top $1 Wikis',
	'hub-header' => '$1 Wikis',
	'hub-hotspot-info' => 'Dies sind die angesagtesten Seiten dieser Woche, gerankt nach den meisten Bearbeitern.',
	'hub-blog-comments' => '{{PLURAL:$1|ein Kommentar|$1 Kommentare}}',
	'hub-blog-continue' => 'Weiterlesen',
	'hub-blog-showarticle' => 'Seite anzeigen',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">Bearbeitungs{{PLURAL:$1|punkt|punkte}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 Bearbeitungs{{PLURAL:$1|punkt|punkte}}',
	'hub-hotspot-from' => 'von',
	'hub-hide-feed' => 'Feed ausblenden',
	'hub-show-feed' => 'Feed anzeigen',
	'hub-contributors-info' => 'Dies sind die Top-Benutzer dieser Woche, gerankt nach den meisten Bearbeitungen.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|Bearbeiter|Bearbeiter}}</span>',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'unhide' => 'me nımnê',
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
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|punto|puntos}} de edición',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Ocultar feed',
	'hub-show-feed' => 'Mostrar feed',
	'hub-contributors-info' => 'Estos son los usuarios más activos de esta semana, ordenados por su número de ediciones.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editores}}</span>',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Wayiran
 */
$messages['fa'] = array(
	'unhide' => 'آشکارسازی',
	'hub-blog-header' => '$1 پست برتر',
	'hub-hotspot-header' => 'نقاط داغ',
	'hub-topusers-header' => 'برترین کاربران $1',
	'hub-featured' => 'برترین ویکی‌های $1',
	'hub-header' => 'ویکی‌های $1',
	'hub-hotspot-info' => 'این‌ها داغ‌ترین صفحات این هفته هستند، که توسط بیش‌ترین ویرایش‌گران امتیاز داده شده‌اند.',
	'hub-blog-comments' => '$1 نظر',
	'hub-blog-showarticle' => 'نمایش صفحه',
	'hub-hotspot-from' => 'از',
	'hub-hide-feed' => 'پنهان‌کردن خوراک',
	'hub-show-feed' => 'نمایش خوراک',
	'hub-contributors-info' => 'این‌ها برترین کاربران این هفته هستند، که توسط بیش‌ترین کاربران امتیاز داده شده‌اند.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|ویرایش‌گر|ویرایش‌گر}}</span>',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'hub-topusers-header' => 'Suurimmat käyttäjät ($1)',
	'hub-blog-continue' => 'Jatka lukemista',
	'hub-blog-showarticle' => 'Näytä sivu',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|muokkaaja|muokkaajaa}}</span>',
);

/** French (Français)
 * @author Peter17
 * @author Wyz
 */
$messages['fr'] = array(
	'unhide' => 'Afficher',
	'hub-blog-header' => 'Principaux messages de $1',
	'hub-hotspot-header' => 'Pages les plus actives',
	'hub-topusers-header' => 'Principaux contributeurs cette semaine de « $1 »',
	'hub-featured' => 'Principaux wikis de « $1 »',
	'hub-header' => 'Wikis de $1',
	'hub-hotspot-info' => 'Ces pages sont les plus actives cette semaine, classées par le nombre de contributeurs.',
	'hub-blog-comments' => '{{PLURAL:$1|un commentaire|$1 commentaires}}',
	'hub-blog-continue' => 'Continuer la lecture',
	'hub-blog-showarticle' => 'Afficher la page',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|point|points}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|point|points}}',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Masquer le flux',
	'hub-show-feed' => 'Afficher le flux',
	'hub-contributors-info' => 'Ces utilisateurs sont les plus actifs cette semaine, classés par nombre de modifications.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|contributeur|contributeurs}}</span>',
	'hub-hot-news' => 'Actualité brûlante',
	'hub-hot-news-post-details' => 'De $1 sur $2 le $3',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'unhide' => 'Mostrar',
	'hub-blog-header' => 'Mensaxes máis populares de $1',
	'hub-hotspot-header' => 'Páxinas máis populares',
	'hub-topusers-header' => 'Os usuarios máis activos esta semana nos wikis $1',
	'hub-featured' => 'Os wikis máis populares de $1',
	'hub-header' => 'Wikis de $1',
	'hub-hotspot-info' => 'Estas son as páxinas máis populares desta semana, clasificadas polo número de editores.',
	'hub-blog-comments' => '{{PLURAL:$1|un comentario|$1 comentarios}}',
	'hub-blog-continue' => 'Continuar lendo',
	'hub-blog-showarticle' => 'Mostrar a páxina',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|punto|puntos}} de edición</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|punto|puntos}} de edición',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Agochar a fonte de novas',
	'hub-show-feed' => 'Mostrar a fonte de novas',
	'hub-contributors-info' => 'Estes son os usuarios máis populares desta semana, clasificados polo número de edicións.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editores}}</span>',
	'hub-hot-news' => 'Cousas populares',
	'hub-hot-news-post-details' => 'Por $1 en $2 o $3',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'hub-topusers-header' => 'Legjobb $1 felhasználó',
	'hub-featured' => 'Legjobb $1 wiki',
	'hub-header' => '$1 wikik',
	'hub-editors' => '<strong>{{PLURAL:$1|Egy|$1}}</strong><span>szerkesztő</span>',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'unhide' => 'Revelar',
	'hub-blog-header' => 'Top $1 de articulos',
	'hub-hotspot-header' => 'Paginas popular',
	'hub-topusers-header' => 'Redactor principal iste septimana sur le wikis de $1',
	'hub-featured' => 'Wikis popular de $1',
	'hub-header' => 'Wikis de $1',
	'hub-hotspot-info' => 'Le paginas le plus popular de iste septimana, rangiate per numero de contributores.',
	'hub-blog-comments' => '{{PLURAL:$1|un commento|$1 commentos}}',
	'hub-blog-continue' => 'Continuar a leger',
	'hub-blog-showarticle' => 'Monstrar pagina',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|puncto|punctos}} de modification</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|puncto|punctos}} de modification',
	'hub-hotspot-from' => 'de',
	'hub-hide-feed' => 'Celar syndication',
	'hub-show-feed' => 'Revelar syndication',
	'hub-contributors-info' => 'Le usatores le plus productive de iste septimana, rangiate per numero de modificationes.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|redactor|redactores}}</span>',
	'hub-hot-news' => 'Popular',
	'hub-hot-news-post-details' => 'Per $1 in $2 le $3',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'hub-blog-showarticle' => 'Rûpelê nîşan bide',
	'hub-hotspot-from' => 'ji',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'unhide' => 'Nees weisen',
	'hub-topusers-header' => 'Top Editeur dës Woch op $1 Wiki',
	'hub-featured' => 'Top $1 Wikien',
	'hub-header' => '$1 Wikien',
	'hub-blog-comments' => '{{PLURAL:$1|eng Bemierkung|$1 Bemierkungen}}',
	'hub-blog-continue' => 'Weider liesen',
	'hub-blog-showarticle' => 'Säit weisen',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span> <span class="txt">Ännerungs-{{PLURAL:$1|Punkt|Punkten}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 Ännerungs-{{PLURAL:$1|Punkt|Punkten}}',
	'hub-hotspot-from' => 'vu(n)',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|Auteur|Auteuren}}</span>',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'unhide' => 'Neslėpti',
	'hub-blog-header' => 'Top $1 Pranešimai',
	'hub-blog-showarticle' => 'Rodyti puslapį',
	'hub-hotspot-from' => 'iš',
	'hub-hot-news' => 'Kas Karšto',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'unhide' => 'Прикажи',
	'hub-blog-header' => 'Најкотирани $1 објави',
	'hub-hotspot-header' => 'Најактивни места',
	'hub-topusers-header' => 'Најкотиран уредник за наделава на $1 викија',
	'hub-featured' => 'Најкотирани $1 викија',
	'hub-header' => 'Викија на $1',
	'hub-hotspot-info' => 'Ова се најактивните страници неделава, рангирани по број на уредници.',
	'hub-blog-comments' => '{{PLURAL:$1|еден коментар|$1 коментари}}',
	'hub-blog-continue' => 'Продолжете со читање',
	'hub-blog-showarticle' => 'Прикажи страница',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|бод|бода}} за уредување</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|бод|бода}} за уредување',
	'hub-hotspot-from' => 'од',
	'hub-hide-feed' => 'Скриј канал',
	'hub-show-feed' => 'Прикажи канал',
	'hub-contributors-info' => 'Ова се најкотираните корисници неделава, рангирани по број науредувања.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|уредник|уредници}}</span>',
	'hub-hot-news' => 'Актуелности',
	'hub-hot-news-post-details' => 'Од $1 на $2 $3',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'hub-blog-showarticle' => 'താൾ പ്രദർശിപ്പിക്കുക',
	'hub-hide-feed' => 'ഫീഡ് മറയ്ക്കുക',
	'hub-show-feed' => 'ഫീഡ് പ്രദർശിപ്പിക്കുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'unhide' => 'Dedahkan',
	'hub-blog-header' => 'Kiriman $1 Teratas',
	'hub-hotspot-header' => 'Hotspot',
	'hub-topusers-header' => 'Pengguna Terunggul di Wiki $1 minggu ini',
	'hub-featured' => 'Wiki $1 teratas',
	'hub-header' => 'Wiki $1',
	'hub-hotspot-info' => 'Inilah laman-laman yang terhangat pada minggu ini, disusun mengikut jumlah penyunting terbanyak.',
	'hub-blog-comments' => '{{PLURAL:$1|Satu ulasan|$1 ulasan}}',
	'hub-blog-continue' => 'Teruskan membaca',
	'hub-blog-showarticle' => 'Paparkan laman',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span> <span class="txt">{{PLURAL:$1|mata|mata}} suntingan</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|mata|mata}} suntingan',
	'hub-hotspot-from' => 'dari',
	'hub-hide-feed' => 'Sorokkan suapan',
	'hub-show-feed' => 'Paparkan suapan',
	'hub-contributors-info' => 'Inilah para penyunting yang paling giat pada minggu ini, disusun mengikut suntingan terbanyak.',
	'hub-editors' => '<strong>$1</strong><span>orang penyunting</span>',
	'hub-hot-news' => 'Terhangat',
	'hub-hot-news-post-details' => 'Oleh $1 di $2 pada $3',
);

/** Norwegian Bokmål (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'unhide' => 'Vis',
	'hub-blog-header' => 'Topp $1 poster',
	'hub-hotspot-header' => 'Populære områder',
	'hub-topusers-header' => 'Toppredaktører denne uken på $1-wikier',
	'hub-featured' => 'Topp $1 wikier',
	'hub-header' => '$ wikier',
	'hub-hotspot-info' => 'Dette er de heteste sidene denne uken, rangert etter flest redaktører.',
	'hub-blog-comments' => ' {{PLURAL:$1|én kommentar|$1 kommentarer}}',
	'hub-blog-continue' => 'Fortsett å lese',
	'hub-blog-showarticle' => 'Vis side',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">redigerings{{PLURAL:$1|poeng|poeng}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 redigerings{{PLURAL:$1|poeng|poeng}}',
	'hub-hotspot-from' => 'fra',
	'hub-hide-feed' => 'Skjul feed',
	'hub-show-feed' => 'Vis feed',
	'hub-contributors-info' => 'Dette er ukens toppbrukere, rangert etter flest redigeringer.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|redaktør|redaktører}}</span>',
	'hub-hot-news' => 'Hva er i skuddet',
	'hub-hot-news-post-details' => 'Av $1 på $2 $3',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'unhide' => 'Weergeven',
	'hub-blog-header' => 'Topberichten van $1',
	'hub-hotspot-header' => "Populaire pagina's",
	'hub-topusers-header' => "Topgebruikers van $1-wiki's in deze week",
	'hub-featured' => "Topwiki's over $1",
	'hub-header' => "$1 wiki's",
	'hub-hotspot-info' => "Dit zijn de meer populaire pagina's van deze week, gesorteerd op aantal gebruikers met bewerkingen.",
	'hub-blog-comments' => '$1 {{PLURAL:$1|opmerking|opmerkingen}}',
	'hub-blog-continue' => 'Meer lezen',
	'hub-blog-showarticle' => 'Pagina weergeven',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">edit {{PLURAL:$1|punt|punten}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 edit {{PLURAL:$1|punt|punten}}',
	'hub-hotspot-from' => 'van',
	'hub-hide-feed' => 'Feed verbergen',
	'hub-show-feed' => 'Feed weergeven',
	'hub-contributors-info' => 'Dit zijn de topgebruikers van deze week, gesorteerd op het aantal bewerkingen.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|redacteur|redacteuren}}</span>',
	'hub-hot-news' => 'Wat is populair',
	'hub-hot-news-post-details' => 'Door $1 op $2 $3',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'unhide' => 'Mostré',
	'hub-blog-header' => 'Prim $1 Mëssagi',
	'hub-hotspot-header' => 'Ròba Càuda',
	'hub-topusers-header' => 'Prim Editor sta sman-a dzora a $1 Wiki',
	'hub-featured' => 'Prime $1 wiki',
	'hub-header' => '$1 Wiki',
	'hub-hotspot-info' => 'Coste a son le pàgine pi ative dë sta sman-a, valutà da tanti editor.',
	'hub-blog-comments' => '{{PLURAL:$1|un coment|$1 coment}}',
	'hub-blog-continue' => 'Continua a lese',
	'hub-blog-showarticle' => 'Smon-e la pàgina',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt"> {{PLURAL:$1|pont|pont}} ëd modìfica</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|pont|pont}} ëd modìfica',
	'hub-hotspot-from' => 'da',
	'hub-hide-feed' => 'Stërmé ël fluss',
	'hub-show-feed' => 'Smon-e ël fluss',
	'hub-contributors-info' => 'Costi a son ij prim utent dë sta sman-a, an órdin ëd nùmer ëd modìfiche.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editor}}</span>',
	'hub-hot-news' => 'Neuve frësche',
	'hub-hot-news-post-details' => 'Da $1 dzora a $2 $3',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'hub-header' => '$1 ويکي ګانې',
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
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|ponto|pontos}} de edições',
	'hub-hotspot-from' => 'da',
	'hub-hide-feed' => 'Esconder feed',
	'hub-show-feed' => 'Mostrar feed',
	'hub-contributors-info' => 'Estes são os melhores editores da semana, ordenados pelo número de edições.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editores}}</span>',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Aristóbulo
 */
$messages['pt-br'] = array(
	'unhide' => 'Reexibir',
	'hub-blog-header' => 'Publicações Populares em $1',
	'hub-hotspot-header' => 'Pontos Quentes',
	'hub-topusers-header' => 'Maiores Editores em $1',
	'hub-featured' => 'Wikis de Topo em $1',
	'hub-header' => 'Wikis do Portal $1',
	'hub-hotspot-info' => 'Estas são as páginas mais populares da semana, ordenadas pelo número de editores.',
	'hub-blog-comments' => '{{PLURAL:$1|um comentário|$1 comentários}}',
	'hub-blog-continue' => 'Continuar lendo',
	'hub-blog-showarticle' => 'Mostrar página',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|ponto|pontos}} de edições</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|ponto|pontos}} de edições',
	'hub-hotspot-from' => 'da',
	'hub-hide-feed' => 'Esconder feed',
	'hub-show-feed' => 'Mostrar feed',
	'hub-contributors-info' => 'Estes são os melhores editores da semana, ordenados pelo número de edições.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editores}}</span>',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'unhide' => 'Reafişare',
	'hub-header' => 'Wiki-uri $1',
	'hub-blog-showarticle' => 'Arată pagina',
	'hub-hotspot-from' => 'de la',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Kuzura
 */
$messages['ru'] = array(
	'unhide' => 'Показать',
	'hub-blog-header' => 'Топ $1 сообщений',
	'hub-hotspot-header' => 'Горячие точки',
	'hub-topusers-header' => 'Топ редакторов этой недели на $1 Викия',
	'hub-featured' => 'Топ $1 викий',
	'hub-header' => '$1 викии',
	'hub-hotspot-info' => 'Это горячие страницы этой недели, распределённые по количеству правок.',
	'hub-blog-comments' => '{{PLURAL:$1|комментарий|комментария|комментариев}}',
	'hub-blog-continue' => 'Продолжить чтение',
	'hub-blog-showarticle' => 'Показать страницу',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">{{PLURAL:$1|очко|очка|очков}} правок</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 {{PLURAL:$1|очко|очков|очков}} правок',
	'hub-hotspot-from' => 'от',
	'hub-hide-feed' => 'Скрыть канал',
	'hub-show-feed' => 'Показать канал',
	'hub-contributors-info' => 'Это лучшие участники этой недели, распределённые по количеству правок.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|правка|правки|правок}}</span>',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'unhide' => 'Откриј',
	'hub-hotspot-header' => 'Вруће тачке',
	'hub-topusers-header' => 'Најбољи уредник ове недеље на $1 викија',
	'hub-featured' => 'Топ $1 викија',
	'hub-header' => '$1 викије',
	'hub-blog-comments' => '{{PLURAL:$1|један коментар|$1 коментара|$1 коментара}}',
	'hub-blog-continue' => 'Настави читање',
	'hub-blog-showarticle' => 'Прикажи страницу',
	'hub-hotspot-from' => 'из',
	'hub-hide-feed' => 'Сакриј довод',
	'hub-show-feed' => 'Прикажи довод',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|уређивач|уређивачи}}</span>',
);

/** Swedish (Svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'unhide' => 'Ta fram',
	'hub-blog-header' => 'Topp $1 inlägg',
	'hub-hotspot-header' => 'Hot spots',
	'hub-topusers-header' => 'Toppredaktör den här veckan på $1 wikis',
	'hub-featured' => 'Topp $1 wikis',
	'hub-header' => '$1 Wikis',
	'hub-hotspot-info' => 'Dessa är de hetaste sidorna den här veckan, rankas av flesta redaktörer.',
	'hub-blog-comments' => '{{PLURAL:$1|en kommentar|$1 kommentarer}}',
	'hub-blog-continue' => 'Fortsätt läsa',
	'hub-blog-showarticle' => 'Visa sida',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">redigerings{{PLURAL:$1|poäng|poäng}}</span>',
	'hub-topusers-editpoints-nonformatted' => '$1 redigerings{{PLURAL:$1|poäng|poäng}}',
	'hub-hotspot-from' => 'från',
	'hub-hide-feed' => 'Göm feed',
	'hub-show-feed' => 'Visa feed',
	'hub-contributors-info' => 'Dessa är veckans toppanvändare, rangordnade efter flest redigeringar.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|redigerare|redigerare}}</span>',
	'hub-hot-news' => 'Vad som är populärt',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'hub-header' => '$1 விக்கிகள்',
	'hub-blog-continue' => 'படிப்பதைத் தொடரவும்',
	'hub-blog-showarticle' => 'பக்கத்தைக் காட்டவும்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'hub-header' => '$1 వికీలు',
	'hub-blog-showarticle' => 'పుటను చూపించు',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'unhide' => 'Показати',
	'hub-blog-showarticle' => 'Показати сторінку',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|редактор|редактори|редакторів}}</span>',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'hub-header' => '$1 Wikid',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Anakmalaysia
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'unhide' => '取消隐藏',
	'hub-topusers-header' => '$1维基顶级编者',
	'hub-featured' => '首 $1 维基',
	'hub-header' => '$1 维基',
	'hub-blog-continue' => '继续读',
	'hub-blog-showarticle' => '显示页面',
	'hub-hotspot-from' => '从',
);

