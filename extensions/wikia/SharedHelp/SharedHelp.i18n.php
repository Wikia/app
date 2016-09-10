<?php
/**
 * Internationalisation file for SharedHelp extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 */
$messages['en'] = array(
	'sharedhelp-desc' => 'Takes pages from [[w:Help:Contents|Community Central]] and inserts them into the {{ns:help}} namespace on this wiki',
	'sharedhelp-autotalkcreate-summary' => 'Talk page created automatically',
	'sharedhelp-searchprofile' => 'Help pages',
	'sharedhelp-searchprofile-tooltip' => 'Search Help pages',

	#Special:SharedHelp
	'shared_help_info' => 'Questions? Ask in the [[w:Special:Forum|Community Forum]].',
	'shared_help_edit_info' => 'The help text within the box is stored at [[w:Help:$1|Help:$1]] on Fandom $2. See [[Help:Shared Help]] for more info.

Any changes that apply to ''all'' wikis should be made to the Fandom $2 copy. [[w:Help_talk:$1|Suggest changes here]].

Text should be placed on this page if you wish to explain usage, style and policy guidelines which apply only to {{SITENAME}}. Text added in this edit box will be displayed above the boxed help text.',
	'shared_help_search_info' => 'To search for help with editing, please visit [http://c.wikia.com/wiki/Special:Search?search=$1 Community Central]',
	'shared_help_was_redirect' => 'This page is a redirect to $1',
);

/** Message documentation (Message documentation)
 * @author TK-999
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'sharedhelp-desc' => '{{desc}}',
	'sharedhelp-searchprofile' => 'Search profile link name displayed in left sidebar on search',
	'sharedhelp-searchprofile-tooltip' => 'Tooltip for search profile link',
	'shared_help_info' => 'Message displayed on top of help pages',
	'shared_help_edit_info' => 'Edit information message on help pages in edit mode. Parameters: $1 - PAGENAME the transcluded page is stored on. $2 - SITENAME the transcluded page is stored on.',
	'shared_help_search_info' => 'Information about where to find editing help',
	'shared_help_was_redirect' => 'Information about redirect target. Parameters: $1 - PAGENAME of redirect destination.',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Kuwaity26
 * @author Malhargan
 */
$messages['ar'] = array(
	'sharedhelp-desc' => 'تأخذ صفحات من [[w:Help:Contents|ويكي المساعدة]] وتدرجها في نطاق ال{{ns:help}} في هذه الويكي',
	'sharedhelp-autotalkcreate-summary' => 'إنشاء صفحة نقاش تلقائيا',
	'sharedhelp-searchprofile' => 'صفحات المساعدة',
	'sharedhelp-searchprofile-tooltip' => 'البحث في صفحات المساعدة',
	'shared_help_was_redirect' => 'هذه الصفحة عبارة عن صفحة تحويل لصفحة $1',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'sharedhelp-desc' => 'Бярэ старонкі з [[w:Help:Contents|Community Central]] і ўстаўляе ў прастору назваў {{ns:help}} {{GRAMMAR:родны|{{SITENAME}}}}',
	'sharedhelp-autotalkcreate-summary' => 'Старонка абмеркаваньня створаная аўтаматычна',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'sharedhelp-desc' => "Kemer a ra pajennoù [[w:Help:Contents|skoazell Wikia]] hag ensoc'hañ a ra anezho en esaouenn anv {{ns:help}} eus ar wiki-mañ",
	'sharedhelp-autotalkcreate-summary' => 'Pajenn gaozeal krouet ent emgefreek',
	'sharedhelp-searchprofile' => 'Pajennoù skoazell',
	'sharedhelp-searchprofile-tooltip' => 'Furchal ar pajennoù skoazell',
);

/** Catalan (català)
 * @author Marcmpujol
 * @author Unapersona
 */
$messages['ca'] = array(
	'sharedhelp-desc' => "Agafa les pàgines de la [[w:Ayuda:Contenidos|Comunitat Central]] i els afegeix a l'espai de noms {{ns:help}} d'aquest wiki.",
	'sharedhelp-autotalkcreate-summary' => 'Pàgina de discussió creada automàticament',
	'sharedhelp-searchprofile' => "Pàgines d'ajuda",
	'sharedhelp-searchprofile-tooltip' => "Cercar pàgines d'ajuda",
	'shared_help_info' => 'Preguntes? Pregunta al [[w:c:ca:Special:Forum|Fòrum comunitari]].', # Fuzzy
	'shared_help_edit_info' => "El text dins d'aquesta caixa està emmagatzemat a [[w:c:comunidad:Ayuda:$1|Ajuda:$1]] al wiki $2. Vegeu [[Ajuda:Ajuda compartida]] per més informació.

Qualsevol canvi que vulguis fer a ''tots'' els wikis s'ha de fer a la còpia del wiki $2. [[w:c:comunidad:Ayuda_discusión:$1|Suggeriu canvis aquí]].

Només has d'afegir text en aquesta pàgina si vols especificar les polítiques i directrius de {{SITENAME}}. El text que afegiu en aquesta caixa d'edició es mostrarà a sobre de l'ajuda compartida.", # Fuzzy
	'shared_help_search_info' => "Per buscar ajuda sobre l'edició, si us plau visita la [http://c.wikia.com/wiki/Special:Search?search=$1 Community Central]",
	'shared_help_was_redirect' => 'Aquesta pàgina és una redirecció cap a $1',
);

/** Czech (čeština)
 * @author Darth Daron
 * @author Mormegil
 */
$messages['cs'] = array(
	'sharedhelp-desc' => 'Přebírá stránky z [[w:Help:Contents|Nápovědy Wikia]] a vkládá je do jmenného prostoru {{ns:help}} na této wiki',
	'sharedhelp-autotalkcreate-summary' => 'Diskusní stránka založena automaticky',
	'sharedhelp-searchprofile' => 'Nápověda',
	'sharedhelp-searchprofile-tooltip' => 'Hledat v nápovědě',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author PtM
 * @author SVG
 * @author The Evil IP address
 */
$messages['de'] = array(
	'sharedhelp-desc' => 'Holt Seiten aus [[w:Help:Contents|Community Central]] und fügt sie in den {{ns:help}}-Namensraum dieses Wikis ein',
	'sharedhelp-autotalkcreate-summary' => 'Diskussionsseite automatisch erstellt',
	'sharedhelp-searchprofile' => 'Hilfeseiten',
	'sharedhelp-searchprofile-tooltip' => 'Hilfeseiten durchsuchen',
	'shared_help_info' => 'Fragen? Stelle sie im [[w:Special:Forum|Gemeinschaftsforum]].',
	'shared_help_edit_info' => "Der Hilfetext innerhalb des Kastens ist gespeichert unter [[w:Help:$1|Help:$1]] auf Wikia $2. Siehe [[Help:Shared Help]] für weitere Informationen.

Jegliche Änderungen, die sich auf ''alle'' Wikis auswirken, sollten an der Wikia-$2-Kopie durchgeführt werden. [[w:Help_talk:$1|Schlage hier Änderungen vor]].

Text sollte auf diese Seite platziert werden, falls du die Verwendung, Gestaltungs- und Grundsatzrichtlinien erklären möchtest, die sich nur auf {{SITENAME}} beziehen. Text, der in diesem Bearbeitungsfeld hinzugefügt wird, erscheint oberhalb des Kastens mit dem Hilfetext.",
	'shared_help_search_info' => 'Um nach Bearbeitungshilfe zu suchen, besuche bitte [http://c.wikia.com/wiki/Special:Search?search=$1 Community Central].',
	'shared_help_was_redirect' => 'Diese Seite ist eine Weiterleitung nach $1',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'sharedhelp-desc' => 'Bjerjo boki z [[w:Help:Contents|Pomoc Wikia]] a zasajźujo je do mjenjowego ruma {{ns:help}} w toś tom wikiju',
	'sharedhelp-autotalkcreate-summary' => 'Awtomatiski napórany diskusijny bok',
);

/** Spanish (español)
 * @author Crazymadlover
 * @author VegaDark
 */
$messages['es'] = array(
	'sharedhelp-desc' => 'Toma páginas de [[w:Help:Contents|Community Central]] y los inserta en el espacio de nombre {{ns:help}} en este wiki',
	'sharedhelp-autotalkcreate-summary' => 'Página de discusión creada automáticamente',
	'sharedhelp-searchprofile' => 'Páginas de ayuda',
	'sharedhelp-searchprofile-tooltip' => 'Buscar páginas de ayuda',
	'shared_help_info' => '¿Tienes preguntas? Hazlas en el [[w:Special:Forum|Foro de la comunidad]].',
	'shared_help_edit_info' => "El texto de ayuda dentro de la caja está en [[w:Help:$1|Ayuda:$1]] en $2 Wiki. Véase [[Help:Shared Help|Ayuda compartida]] para obtener más información.

Cualquier cambio que se aplique a '''todos''' los wikis deben hacerse en $2 Wiki. [[w:Help_talk:$1|Sugiere cambios aquí]].

El texto debe colocarse en esta página si deseas explicar las su uso, estilo y política que se aplican solo a {{SITENAME}}. El texto añadido en esta caja de edición aparecerá encima de la caja de texto de ayuda.",
	'shared_help_search_info' => 'Para buscar ayuda con la edición, visita [http://c.wikia.com/wiki/Special:Search?search=$1 de la Comunidad Central]',
	'shared_help_was_redirect' => 'Esta página es una redirección a $1',
);

/** Persian (فارسی)
 * @author Movyn
 */
$messages['fa'] = array(
	'sharedhelp-searchprofile-tooltip' => 'جستجوی صفحات راهنما',
);

/** Finnish (suomi)
 * @author Elseweyr
 * @author Ilkea
 */
$messages['fi'] = array(
	'sharedhelp-desc' => 'Ottaa sivut [[w:Help:Contents|Community Central]] ja liittää ne {{ns:help}} nimiavaruuteen tässä wikissä',
	'sharedhelp-autotalkcreate-summary' => 'Keskustelusivu luotiin automaattisesti',
	'sharedhelp-searchprofile' => 'Ohjesivut',
	'sharedhelp-searchprofile-tooltip' => 'Etsi ohjesivuja',
	'shared_help_info' => 'Kysymyksiä tai huolia? Apua löytyy [[w:c:yhteiso:Toiminnot:Forum|Yhteisöwikin foorumeista]].', # Fuzzy
	'shared_help_edit_info' => "Tämän laatikon ohjeteksti säilytetään $2n sivulla [[w:c:yhteiso:Ohje:$1|Ohje:$1]]. Katso [[Ohje:Jaetut ohjeet]] saadaksesi lisätietoa.

'''Kaikkia wikioita''' koskevat muutokset tulee tehdä $2n kappaleelle. [[w:c:yhteiso:Keskustelu_ohjeesta:$1|Ehdota muutoksista täällä]].

Mikäli haluat lisätä vain sivustoa {{SITENAME}} koskevia ohjeita liittyen esimerkiksi käyttöön, käytäntöön tai tyyliin, voit muokata tätä sivua. Tähän laatikkoon lisätty teksti näkyy jaetun ohjesivun sisällön yläpuolella.", # Fuzzy
	'shared_help_search_info' => 'Mikäli haluat hakea neuvoja muokkaamiseen, siirry [http://yhteiso.wikia.com/wiki/Special:Search?search=$1 Yhteisöwikiin]',
	'shared_help_was_redirect' => 'Tämä sivu on ohjaus sivulle $1',
);

/** French (français)
 * @author Gomoko
 * @author Peter17
 * @author Wyz
 * @author Yumeki
 */
$messages['fr'] = array(
	'sharedhelp-desc' => 'Prend des pages de [[w:Help:Contents|Community Central]] et les insère dans l’espace de nom {{ns:help}} de ce wiki',
	'sharedhelp-autotalkcreate-summary' => 'Page de discussion créée automatiquement',
	'sharedhelp-searchprofile' => "Pages d'aide",
	'sharedhelp-searchprofile-tooltip' => "Rechercher dans les pages d'aide",
	'shared_help_info' => 'Des questions ? Posez-les sur le [[w:Special:Forum|forum de la communauté]].',
	'shared_help_edit_info' => "Le texte d'aide dans l'encadré se trouve sur [[w:Help:$1|Help:$1]] sur le wiki $2. Consultez [[Help:Shared Help]] pour plus d'informations.

Toute modification qui s'applique à ''tous'' les wikis doit être effectuée sur la copie sur le wiki $2. [[w:Help_talk:$1|Suggérez des modifications ici]].

Du texte devrait être mis sur cette page si vous souhaitez expliquer l'utilisation, le style et les règles qui s'appliquent uniquement à {{SITENAME}}. Le texte ajouté dans cette zone sera affiché au-dessus du texte d’aide encadré.",
	'shared_help_search_info' => 'Pour trouver de l’aide sur comment modifier, veuillez visiter le [http://fr.c.wikia.com/wiki/Special:Search?search=$1 wiki des communautés]',
	'shared_help_was_redirect' => 'Cette page est une redirection vers $1',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'sharedhelp-desc' => 'Toma páxinas da [[w:Help:Contents|central da comunidade]] e insíreas no espazo de nomes "{{ns:help}}" deste wiki',
	'sharedhelp-autotalkcreate-summary' => 'Páxina de conversa creada automaticamente',
	'sharedhelp-searchprofile' => 'Páxinas de axuda',
	'sharedhelp-searchprofile-tooltip' => 'Procurar nas páxinas de axuda',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'sharedhelp-desc' => 'Bjerje strony z [[w:Help:Contents|Community Central]] a zasuwa je do mjenoweho ruma {{ns:help}} w tutym wikiju',
	'sharedhelp-autotalkcreate-summary' => 'Awtomatisce wutworjena diskusijna strona',
);

/** Hungarian (magyar)
 * @author TK-999
 * @author Tacsipacsi
 */
$messages['hu'] = array(
	'sharedhelp-desc' => 'A [[w:Help:Contents|Community Central]] oldalait illeszti be az {{ns:help}} névtérbe ezen a wikin',
	'sharedhelp-autotalkcreate-summary' => 'Automatikusan létrehozott vitalap',
	'sharedhelp-searchprofile-tooltip' => 'Keresés a Segítség lapokon',
	'shared_help_info' => 'Kérdéseid vannak? Tedd fel őket a [[w:Special:Forum|Közösségi Központ fórumain]].',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'sharedhelp-desc' => 'Prende paginas del [[w:Help:Contents|Community Central]] e los insere in le spatio de nomines {{ns:help}} in iste wiki',
	'sharedhelp-autotalkcreate-summary' => 'Paginas de discussion create automaticamente',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 */
$messages['id'] = array(
	'sharedhelp-desc' => 'Mengambil halaman dari [[w:Help:Contents|Community Central]] dan memasukkannya ke ruang nama {{ns:help}} di wiki ini',
	'sharedhelp-autotalkcreate-summary' => 'Halaman pembicaraan dibuat secara otomatis',
);

/** Italian (italiano)
 * @author Ontsed
 * @author Pietrodn
 */
$messages['it'] = array(
	'sharedhelp-desc' => "Prende le pagine dall'[[w:Help:Contents|Community Central]] e le inserisce nel namespace {{ns:help}} su questa wiki",
	'sharedhelp-autotalkcreate-summary' => 'Pagina di discussione creata automaticamente',
	'shared_help_info' => 'Hai delle domande? Chiedile su [[w:Special:Forum|Forum della comunità]].',
	'shared_help_search_info' => 'Per chiedere aiuto con le modifiche, visita [http://c.wikia.com/wiki/Special:Search?search=$1 Centrale della comunità]',
	'shared_help_was_redirect' => 'Questa pagina è una redirezione di $1',
);

/** Japanese (日本語)
 * @author Plover-Y
 * @author Tommy6
 */
$messages['ja'] = array(
	'sharedhelp-desc' => '[[w:Help:Contents|Community Central]] のページをこのウィキの {{ns:help}} 名前空間に挿入する。',
	'sharedhelp-autotalkcreate-summary' => 'ノートページの自動作成',
	'sharedhelp-searchprofile' => 'ヘルプページ',
	'sharedhelp-searchprofile-tooltip' => 'ヘルプの検索',
);

/** Kannada (ಕನ್ನಡ)
 * @author VASANTH S.N.
 */
$messages['kn'] = array(
	'sharedhelp-searchprofile' => 'ಸಹಾಯ ಪುಟಗಳು',
);

/** Korean (한국어)
 * @author Miri-Nae
 */
$messages['ko'] = array(
	'sharedhelp-searchprofile' => '도움말',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'sharedhelp-desc' => 'Nimmb Sigge us däm <em lang="en">[[w:Help:Contents|Community Central]]</em> un deiht se en et {{ns:help}}-Appachtemang en heh däm Wikis erin.',
	'sharedhelp-autotalkcreate-summary' => 'Klaafsigg automattesch aanjelaat',
	'sharedhelp-searchprofile' => 'Hölpsigge',
	'sharedhelp-searchprofile-tooltip' => 'En de Hölpsigge söhke',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'sharedhelp-searchprofile' => 'Rûpelên alîkariyê',
);

/** Latin (Latina)
 * @author TK-999
 */
$messages['la'] = array(
	'shared_help_info' => 'Habes quaestiones? Quaere in [[w:Special:Forum|Foris Communitatis Centralis]].',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'shared_help_was_redirect' => 'Dës Säit ass eng Viruleedung op $1',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'sharedhelp-desc' => 'Презема страници од [[w:Help:Contents|Помогнете ѝ на Викија]] и ги вметнува во именскиот простор {{ns:help}} на ова вики',
	'sharedhelp-autotalkcreate-summary' => 'Страницата за разговор е автоматски создадена',
	'sharedhelp-searchprofile' => 'Страници за помош',
	'sharedhelp-searchprofile-tooltip' => 'Пребарување на страниците за помош',
	'shared_help_info' => 'Имате прашања? Поставете ги на [[w:Special:Forum|Форумот на заедницата]].',
);

/** Marathi (मराठी)
 * @author Ydyashad
 */
$messages['mr'] = array(
	'sharedhelp-searchprofile' => 'साहाय्यक पाने',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'sharedhelp-desc' => 'Mengambil laman dari [[w:Help:Contents|Community Central]] lalu menyisipkannya ke dalam ruang nama {{ns:help}} di wiki ini',
	'sharedhelp-autotalkcreate-summary' => 'Laman perbincangan dicipta secara automatik',
	'sharedhelp-searchprofile' => 'Halaman bantuan',
	'sharedhelp-searchprofile-tooltip' => 'Cari dalam halaman Bantuan',
	'shared_help_info' => 'Soalan? Tanya di [[w:Special:Forum|Forum Komuniti]].',
	'shared_help_edit_info' => "Teks bantuan di dalam petak ini tersimpan di [[w:Help:$1|Help:$1]] di Wikia $2. Rujuk [[Help:Shared Help]] untuk keterangan lanjut.

Sebarang perubahan yang dikenakan kepada ''semua'' wiki harus dilakukan kepada salinan Wikia $2. [[w:Help_talk:$1|Cadangkan perubahan di sini]].

Teks seharusnya terletak di halaman ini jika anda ingin menerangkan penggunaan, gaya dan garis panduan dasar yang hanya berkenaan dengan {{SITENAME}}. Teks yang ditambahkan pada petak suntingan ini akan disiarkan di atas teks bantuan dalam petak.",
	'shared_help_search_info' => 'Untuk mencari pertolongan mengenai penyuntingan, sila kunjungi [http://c.wikia.com/wiki/Special:Search?search=$1 Community Central]',
	'shared_help_was_redirect' => 'Halaman ini adalah lencongan ke $1',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'sharedhelp-desc' => 'Tar sider fra [[w:Help:Contents|Community Central]] og setter dem inn i {{ns:help}}-navnerommet på denne wikien', # Fuzzy
	'sharedhelp-autotalkcreate-summary' => 'Diskusjonsside opprettet automatisk',
	'sharedhelp-searchprofile' => 'Hjelpesider',
	'sharedhelp-searchprofile-tooltip' => 'Søk i hjelpesidene',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'sharedhelp-desc' => "Haalt pagina's op van [[w:Help:Contents|Community Central]] en voegt ze toe aan de naamruimte {{ns:help}} in deze wiki",
	'sharedhelp-autotalkcreate-summary' => 'Overlegpagina automatisch aangemaakt',
	'sharedhelp-searchprofile' => "Hulppagina's",
	'sharedhelp-searchprofile-tooltip' => "Hulppagina's zoeken",
	'shared_help_info' => 'Vragen? Stel ze in het [[w:Special:Forum|Communityforum]].',
	'shared_help_edit_info' => "De hulptekst binnen het venster is opgeslagen in [[w:Help:$1|Help:$1]] op Wikia $2. Zie [[Help:Shared Help|Gedeelde hulp]] voor meer informatie.

Alle wijzigingen die van toepassing zijn op ''alle'' wiki's moeten gemaakt worden in de copy van Wikia $2. [[w:Help_talk:$1|Stel hier wijzigingen voor]].

Plaats tekst op deze pagina als u het gebruik wilt uitleggen, of stijl en beleid dat alleen van toepassing is op {{SITENAME}}. Tekst die wordt toegevoegd aan dit venster wordt weergegeven boven het venster met hulptekst.",
	'shared_help_search_info' => 'Ga als u hulp nodig heeft bij bewerken naar [http://c.wikia.com/wiki/Special:Search?search=$1 Community Central]',
	'shared_help_was_redirect' => 'Deze pagina is een doorverwijzing naar $1',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'sharedhelp-desc' => "Pren de paginas de [[w:Help:Contents|Community Central]] e las inserís dins l’espaci de nom {{ns:help}} d'aqueste wiki",
	'sharedhelp-autotalkcreate-summary' => 'Pagina de discussion creada automaticament',
	'sharedhelp-searchprofile' => "Paginas d'ajuda",
	'sharedhelp-searchprofile-tooltip' => "Recercar dins las paginas d'ajuda",
	'shared_help_info' => 'De questions ? Demandatz sul [[w:Special:Forum|Forum de la comunautat]].',
	'shared_help_was_redirect' => 'Aquesta pagina es una redireccion cap a $1',
);

/** Polish (polski)
 * @author Chrumps
 * @author NexGaming
 * @author Pio387
 * @author Sovq
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'sharedhelp-desc' => 'Dodaje [[w:Help:Contents|Community Central]] do tej wiki w przestrzeni {{ns:help}}',
	'sharedhelp-autotalkcreate-summary' => 'Strona dyskusji utworzona automatycznie',
	'sharedhelp-searchprofile' => 'Strony pomocy',
	'sharedhelp-searchprofile-tooltip' => 'Przeszukaj strony pomocy',
	'shared_help_info' => 'Masz jakieś pytania? Zadaj je na [[w:c:spolecznosc:Specjalna:Forum|Forum Społeczności]].', # Fuzzy
	'shared_help_search_info' => 'Jeżeli szukasz pomocy z edytowaniem, odwiedź [http://pl.c.wikia.com/wiki/Special:Search?search=$1 Centrum Społeczności]',
	'shared_help_was_redirect' => 'Ta strona jest przekierowaniem do $1',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'sharedhelp-desc' => "A pija dle pàgine da [[w:Help:Contents|Community Central]] e a j'anseriss ant lë spassi nominal {{ns:help}} dë sta wiki-sì",
	'sharedhelp-autotalkcreate-summary' => 'Pàgina ëd discussion creà automaticament',
	'sharedhelp-searchprofile' => "Pàgine d'agiut",
	'sharedhelp-searchprofile-tooltip' => "Sërché ant le pàgine d'agiut",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'sharedhelp-autotalkcreate-summary' => 'د خبرو اترو مخ په خپلکاره توگه جوړ شو',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 */
$messages['pt'] = array(
	'sharedhelp-desc' => 'Insere páginas da [[w:Help:Contents|Community Central]] no espaço nominal {{ns:help}} desta wiki',
	'sharedhelp-autotalkcreate-summary' => 'Página de discussão criada automaticamente',
	'sharedhelp-searchprofile' => 'Páginas de ajuda',
	'sharedhelp-searchprofile-tooltip' => 'Pesquisar nas páginas de ajuda',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Giro720
 * @author JM Pessanha
 */
$messages['pt-br'] = array(
	'sharedhelp-desc' => 'Insere páginas da [[w:Help:Contents|Community Central]] no espaço nominal {{ns:help}} desta wiki',
	'sharedhelp-autotalkcreate-summary' => 'Página de discussão criada automaticamente',
	'sharedhelp-searchprofile' => 'Páginas de ajuda',
	'sharedhelp-searchprofile-tooltip' => 'Pesquisar páginas de ajuda',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'sharedhelp-desc' => "Pigghie le pàggene da l'[[w:Help:Contents|Community Central]] e sckaffele jndr'à 'u namespace {{ns:help}} sus a sta uicchi",
	'sharedhelp-autotalkcreate-summary' => "Pàgene de le 'ngazzaminde ccrejate automaticamende",
	'sharedhelp-searchprofile' => "Pàgene d'ajute",
	'sharedhelp-searchprofile-tooltip' => 'Cirche le pàggene de ajute',
	'shared_help_info' => "Domande? Cirche sus a 'u [[w:Special:Forum|Forum d'a Comunitate]].",
	'shared_help_was_redirect' => 'Sta pàgene jè redirezionate sus a $1',
);

/** Russian (русский)
 * @author Eleferen
 * @author Kuzura
 * @author Okras
 * @author Ytsukeng Fyvaprol
 */
$messages['ru'] = array(
	'sharedhelp-desc' => 'Берутся страницы из [[w:Help:Contents|Community Central]] и вставляются в пространство имён {{ns:help}} данной вики',
	'sharedhelp-autotalkcreate-summary' => 'Страница обсуждения создана автоматически',
	'sharedhelp-searchprofile' => 'Страницы справки',
	'sharedhelp-searchprofile-tooltip' => 'Поиск по Справке',
	'shared_help_info' => 'Вопросы? Спросите на [[w:Special:Forum|Форуме сообщества]].',
	'shared_help_edit_info' => "Справочный текст в рамке хранится в [[w:Help:$1|Help:$1]] в Викии $2. См. [[Help:Shared Help]] для получения дополнительной информации.

Любые изменения, относящееся ко ''всем'' вики, должны быть внесены в копию Викии $2. [[w:Help_talk:$1|Предложите изменения здесь]].

Текст должен быть размещён на этой странице, если вы хотите объяснить использование, стиль и правила, которые применяются только к {{SITENAME}}. Текст, добавленный в это поле ввода, будет отображаться над справочным текстом в рамке.",
	'shared_help_search_info' => 'Для поиска справки по редактированию, пожалуйста, посетите [http://c.wikia.com/wiki/Special:Search? поиск = $1 Community Central]',
	'shared_help_was_redirect' => 'Эта страница является перенаправлением на $1',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'sharedhelp-desc' => 'Tar sidor från [[w:Help:Contents|Community Central]] och infogar dem i namnområdet {{ns:help}} på denna wiki',
	'sharedhelp-autotalkcreate-summary' => 'Diskussionssidan skapas automatiskt',
	'sharedhelp-searchprofile' => 'Hjälpsidor',
	'sharedhelp-searchprofile-tooltip' => 'Sök hjälpsidor',
	'shared_help_info' => 'Har du några frågor? Ställ dem på [[w:Special:Forum|gemenskapsforumet]].',
	'shared_help_edit_info' => "Hjälptexten i rutan lagras i [[w:Help:$1|Help:$1]] på Wikia $2. Se sidan [[Help:Shared Help]] för mer information.

Alla ändringar som gäller på ''alla'' wikis bör göras i kopian av Wikia $2. [[w:Help_talk:$1|Föreslå ändringar här]].

Text bör placeras på denna sida om du vill förklara användning, stil och policyriktlinjer som endast gäller på {{SITENAME}}. Text som läggs till i detta redigeringsfält kommer att visas nedanför hjälptextrutan.",
	'shared_help_search_info' => 'Besök [http://c.wikia.com/wiki/Special:Search?search=$1 gemenskapscentralen] för att söka efter redigeringshjälp.',
	'shared_help_was_redirect' => 'Denna sida är en omdirigering till $1',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'sharedhelp-desc' => 'Kumukuha ng mga pahina mula sa [[w:Help:Contents|Community Central]] at isinisingit ang mga ito sa loob ng puwang ng pangalang {{ns:help}} sa wiking ito',
	'sharedhelp-autotalkcreate-summary' => 'Kusang nilikha ang pahina ng usapan',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Mykola Swarnyk
 * @author Steve.rusyn
 * @author SteveR
 * @author Ua2004
 * @author Тест
 */
$messages['uk'] = array(
	'sharedhelp-desc' => 'Бере сторінки з [[w:Help:Contents|Community Central]] і додає їх до простору назв {{ns:help}} цієї вікі',
	'sharedhelp-autotalkcreate-summary' => 'Сторінку обговорення створено автоматично',
	'sharedhelp-searchprofile' => 'Сторінки довідки',
	'sharedhelp-searchprofile-tooltip' => 'Пошук у довідці',
	'shared_help_info' => 'Питання? Запитайте на [[w:Special:Forum|Форумі спільноти]].',
	'shared_help_edit_info' => 'Текст довідки у вікні зберігається в [[w:Help:$1|Help:$1]] на Вікії $2. Див. [[Help:Shared Help]] для додаткової інформації.

Будь-які зміни, які поширюються на "всі" Вікії, повинні бути виконані на примірнику Вікії $2. [[w:Help_talk:$1|Запропонувати зміни тут]].

Якщо ви захочете пояснити використання, стиль і вказівки до процедур, які будуть застосовуватись лише на {{SITENAME}}, текст має бути розміщений на цій сторінці. Текст, доданий у цьому полі редагування, буде відображатися понад рамкою вікна довідкового тексту.',
	'shared_help_search_info' => 'Щоб знайти допомогу з редагування, будь ласка, відвідайте  [http://c.wikia.com/wiki/Special:Search?search=$1 Портал спільноти]',
	'shared_help_was_redirect' => 'Ця сторінка є переспрямуванням до $1',
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author Dinhxuanduyet
 */
$messages['vi'] = array(
	'sharedhelp-desc' => 'Mất trang từ [[w:Help:Contents|Community Central]] và chèn chúng vào không gian tên {{ns:help}} wiki này',
	'sharedhelp-autotalkcreate-summary' => 'Thảo luận trang tự động tạo ra',
	'sharedhelp-searchprofile' => 'Trang trợ giúp',
	'sharedhelp-searchprofile-tooltip' => 'Trang trợ giúp tìm kiếm',
	'shared_help_info' => 'Muốn hỏi? Hãy yêu cầu trên [[w:Special:Forum|Diễn đàn cộng đồng]].',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Liuxinyu970226
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'sharedhelp-desc' => '将[[w:Help:Contents|Wikia帮助]]带来并嵌入到此wiki的{{ns:help}}命名空间',
	'sharedhelp-autotalkcreate-summary' => '讨论页已自动创建',
	'sharedhelp-searchprofile' => '帮助页面',
	'sharedhelp-searchprofile-tooltip' => '搜索帮助页面',
	'shared_help_info' => '有问题？[[w:Special:Forum|欢迎点此询问]]。',
	'shared_help_edit_info' => "框内的帮助文本保存在Wikia站点$2上的[[w:Help:$1|Help:$1]]。更多信息参见[[Help:Shared Help]]。
任何请求''所有''wiki的更改应该在Wikia站点$2拷贝中进行。[[w:Help_talk:$1|在此提议更改]]。
如果您希望说明用途、样式和只用于{{SITENAME}}的方针与指引文本应放在此页。在此编辑框加入的文本将显示在上方的帮助文本框。",
	'shared_help_search_info' => '要搜索编辑帮助，请访问[http://c.wikia.com/wiki/Special:Search?search=$1 社群中心]',
	'shared_help_was_redirect' => '此页面是重定向页，前往$1',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 * @author LNDDYL
 */
$messages['zh-hant'] = array(
	'sharedhelp-desc' => '自[[w:c:Help|Wikia幫助]]獲取頁面並嵌入到這個維基的 {{ns:help}}命名空間', # Fuzzy
	'sharedhelp-autotalkcreate-summary' => '討論頁已自動建立',
	'sharedhelp-searchprofile' => '幫助頁面',
	'sharedhelp-searchprofile-tooltip' => '搜尋使用說明頁面',
);
