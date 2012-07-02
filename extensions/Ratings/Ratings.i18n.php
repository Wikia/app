<?php

/**
 * Internationalization file for the Ratings extension.
 *
 * @since 0.1
 *
 * @file Ratings.i18n.php
 * @ingroup Ratings
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	'ratings-desc' => 'Allows users to rate different "properties" of pages',
	'right-rate' => 'Rate a certain property of a page',

	// Rating stars
	'ratings-starsratings-desc' => 'Displays a simple star rating control allowing the user to rate a certain property of a page.
The current vote of the user will be displayed initially when he already voted.',
	'ratings-par-page' => 'The page the rating applies to.',
	'ratings-par-tag' => 'The rating tag. The tag indicates what "property" of the page gets rated.',
	'ratings-par-showdisabled' => 'Show ratings when the user can not vote (in read-only mode).',
	'ratings-par-incsummary' => 'Show a summary of the current votes above the rating element?',

	// Vote summary
	'ratings-votesummary-desc' => 'Displays a short summary of the votes for the specified page and property pair.',
	'ratings-current-score' => 'Current user rating: $1 ($2 {{PLURAL:$2|rating|ratings}})',
	'ratings-no-votes-yet' => 'No one has rated this yet.',
);

/** Message documentation (Message documentation)
 * @author Jeroen De Dauw
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'ratings-desc' => '{{desc}}',
	'right-rate' => '{{doc-right|rate}}',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'ratings-desc' => 'Дазваляе ўдзельнікам ацэньваць розныя «ўласьцівасьці» старонкі',
	'right-rate' => 'адзначэньне асобных ўласьцівасьцяў старонак',
	'ratings-starsratings-desc' => 'Паказвае простае кіраваньне адзнакамі з дапамогай зорак, які дазваляе ўдзельнікам адзначаць некаторыя ўласьцівасьці старонкі.
Цяперашняя адзнака будзе паказаная адразу, калі ўдзельнік прагаласуе.',
	'ratings-par-page' => 'Старонка, якая адзначаецца.',
	'ratings-par-tag' => 'Тэг адзнакі. Ён паказвае, што «ўласьцівасьць» старонкі была адзначаная.',
	'ratings-par-showdisabled' => 'Паказваць адзнакі, калі ўдзельнік ня можа галасаваць (толькі для чытаньня)',
	'ratings-par-incsummary' => 'Паказваць справаздачу цяперашніх галасоў над элемэнтам адзначэньня?',
	'ratings-votesummary-desc' => 'Паказвае справаздачу цяперашніх галасоў для пазначанай старонкі і ўласьцівасьці.',
	'ratings-current-score' => 'Цяперашняя адзнака ўдзельнікаў: $1 ($2 {{PLURAL:2|адзнака|адзнакі|адзнак}})',
	'ratings-no-votes-yet' => 'Ніхто яшчэ не адзначаў.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'ratings-desc' => 'Talvezout a ra d\'an implijerien da briziañ "perzhioù" disheñvel eus ar pajennoù',
	'ratings-par-page' => 'Ar bajenn emeur o priziañ.',
	'ratings-current-score' => 'Priziadenn an implijer a-vremañ : $1 ($2 {{PLURAL:$2|briziadenn|priziadenn}})',
	'ratings-no-votes-yet' => "N'eo ket bet priziet gant den evit c'hoazh.",
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'ratings-desc' => 'Ermöglicht es Benutzern einzelne Inhalte einer Seite unabhängig voneinander bewerten zu können',
	'right-rate' => 'Bestimmte Inhalte einer Seite bewerten',
	'ratings-starsratings-desc' => 'Zeigt ein einfaches Bewertungssteuerelement (Sterne) mit dem ein Benutzer bestimmte Inhalte einer Seite bewerten kann.
Die aktuelle Bewertung eines Benutzers wird angezeigt, sofern er bereits eine vorgenommen hat.',
	'ratings-par-page' => 'Die Seite auf die sich die Bewertung bezieht.',
	'ratings-par-tag' => 'Das Bewertungselement. Das Element gibt an, welcher Inhalt einer Seite bewertet wird.',
	'ratings-par-showdisabled' => 'Zeigt die Bewertungen an, sofern der Benutzer nicht selbst bewerten kann (im schreibgeschützten Modus).',
	'ratings-par-incsummary' => 'Soll eine Zusammenfassung der aktuellen Bewertungen über dem zu bewertenden Element angezeigt werden?',
	'ratings-votesummary-desc' => 'Zeigt eine kurze Zusammenfassung der Bewertungen für die angegebene Seite und den dort bewerteten Bereich.',
	'ratings-current-score' => 'Aktuelle Benutzerbewertung: $1 ($2 {{PLURAL:$2|Bewertung|Bewertungen}})',
	'ratings-no-votes-yet' => 'Bislang wurde dies von niemanden bewertet.',
);

/** French (Français)
 * @author IAlex
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'ratings-desc' => 'Permet aux utilisateurs de classer différentes « propriétés » des pages',
	'right-rate' => "Classer une propriété d'une page",
	'ratings-starsratings-desc' => "Affiche un simple contrôle de classement en étoile permettant à l'utilisateur de classer une certaine propriété d'une page.
Le vote actuel de l'utilisateur s'affichera initialement lorsqu'il a déjà voté.",
	'ratings-par-page' => "La page sur laquelle le classement s'applique.",
	'ratings-par-tag' => 'La balise de classement. Cette balise indique quelle « propriété » de la page sera classée.',
	'ratings-par-showdisabled' => "Afficher les classements lorsque l'utilisateur ne peut pas voter (en mode lecture seule).",
	'ratings-par-incsummary' => "Afficher un résumé des classements actuels au-dessus de l'élément à classer ?",
	'ratings-votesummary-desc' => 'Affiche un bref résumé des classements pour la page et de la paire de propriétés spécifiées.',
	'ratings-current-score' => 'Classement actuel des utilisateurs : $1 ($2 {{PLURAL:$2|classement|classements}})',
	'ratings-no-votes-yet' => "Personne n'a encore classé ceci.",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'ratings-desc' => 'Permite aos usuarios valorar diferentes "propiedades" das páxinas',
	'right-rate' => 'Valorar certas propiedades dunha páxina',
	'ratings-starsratings-desc' => 'Mostra un simple control de avaliación con estrelas que permite ao usuario valorar unha determinada propiedade dunha páxina.
O voto actual do usuario aparecerá inicialmente unha vez que xa votase.',
	'ratings-par-page' => 'A páxina á que se aplican as valoracións.',
	'ratings-par-tag' => 'A etiqueta de valoración. Indica a "propiedade" da páxina que recibe as valoracións.',
	'ratings-par-showdisabled' => 'Mostrar as valoración cando o usuario non pode votar (en modo de só lectura).',
	'ratings-par-incsummary' => 'Quere mostrar un resumo dos votos actuais enriba do elemento de avaliación?',
	'ratings-votesummary-desc' => 'Mostra un breve resumo dos votos sobre a páxina e o par de propiedades especificados.',
	'ratings-current-score' => 'Avaliación actual do usuario: $1 ($2 {{PLURAL:$2|valoración|valoracións}})',
	'ratings-no-votes-yet' => 'Ninguén avaliou isto aínda.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'ratings-desc' => 'אפשרות לדרג "מאפיינים" שונים של דפים',
	'right-rate' => 'לדרג מאפיין מסוים של דף',
	'ratings-starsratings-desc' => 'הצגה של רכיב פשוט שמאפשר למשתמש לדרג בכוכבים מאפיין מסוים בדף.
ההצבעה הנוכחית של המשתמש תוצג בתחילה אחרי שהוא יצביע.',
	'ratings-par-page' => 'הדף שאליו מתייחס הדירוג.',
	'ratings-par-tag' => 'תג הדירוג. התג מציין איזה "מאפיין" של הדף מדורג.',
	'ratings-par-showdisabled' => 'להציג דירוגים כאשר המשתמש לא יכול להצביע (מצב קריאה בלבד).',
	'ratings-par-incsummary' => 'להציג סיכום של ההצבעות הנוכחיות מעל רכיב הדירוג?',
	'ratings-votesummary-desc' => 'הצגת סיכום קצר של הצבעות לדף המוגדר וזוגות של מאפיינים.',
	'ratings-current-score' => 'דירוג משתמשים נוכחי: $1‏ ({{PLURAL:$2|דירוג אחד|$2 דירוגים}})',
	'ratings-no-votes-yet' => 'איש לא דירג את זה עדיין.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'ratings-desc' => 'Zmóžnja wužiwarjam wšelake "kajkosće" stronow pohódnoćić',
	'right-rate' => 'Wěstu kajkosć strony pohódnoćić',
	'ratings-starsratings-desc' => 'Zwobraznja jednory wodźenski element (hwěžki) za pohódnoćenje, kotryž wužiwarjej dowola, wěstu kajkosć strony pohódnoćić. Aktualny hłós wužiwarja so zwobrazni, jeli je hižo pohódnoćił.',
	'ratings-par-page' => 'Strona, na kotruž pohódnoćenje so nałožuje.',
	'ratings-par-tag' => 'Pohódnoćenski element. Element podawa, kotra "kajkosć" strony so pohódnoćuje.',
	'ratings-par-showdisabled' => 'Pohódnoćenja pokazać, hdyž wužiwar njemóže wothłosować (w přećiwo pisanju škitanym modusu).',
	'ratings-par-incsummary' => 'Ma so zjeće aktualnych pohódnoćenjow nad pohódnoćenskim elementom pokazać?',
	'ratings-votesummary-desc' => 'Zwobraznja krótke zjeće pohódnoćenjow za podatu stronu a por kajkosćow.',
	'ratings-current-score' => 'Aktualne wužiwarske pohódnoćenje: $1 ($2 {{PLURAL:$2|pohódnoćenje|pohódnoćeni|pohódnoćenja|pohódnoćenjow}})',
	'ratings-no-votes-yet' => 'Dotal nichtó njeje pohódnoćił.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'ratings-desc' => 'Permitter al usatores de evalutar diverse "proprietates" de paginas',
	'right-rate' => 'Evalutar un certe proprietate de un pagina',
	'ratings-starsratings-desc' => 'Presenta un icone de stella con que le usator pote valutar un certe proprietate de un pagina.
Le voto actual del usator essera monstrate initialmente si ille ha jam votate.',
	'ratings-par-page' => 'Le pagina al qual le evalutation pertine.',
	'ratings-par-tag' => 'Le etiquetta de evalutation. Le etiquetta specifica le "proprietate" del pagina que es evalutate.',
	'ratings-par-showdisabled' => 'Monstrar le evalutationes si le usator non pote votar (in modo de lectura sol).',
	'ratings-par-incsummary' => 'Monstrar un summario del votos actual supra le elemento de evalutation?',
	'ratings-votesummary-desc' => 'Presenta un curte summario del votos pro le pagina e par de proprietates specificate.',
	'ratings-current-score' => 'Evalutation actual del usator: $1 ($2 {{PLURAL:$2|evalutation|evalutationes}})',
	'ratings-no-votes-yet' => 'Nemo ha ancora evalutate isto.',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'ratings-desc' => 'Memungkinkan pengguna untuk memberi nilai terhadap berbagai "properti" halaman',
	'right-rate' => 'Memberi nilai untuk properti tertentu suatu halaman',
	'ratings-starsratings-desc' => 'Menampilkan alat pemeringkat bintang sederhana yang memungkinkan pengguna untuk menilai properti tertentu dari sebuah halaman.
Suara pengguna saat ini akan ditampilkan ketika ia sudah memilih.',
	'ratings-par-page' => 'Halaman yang diberi peringkat.',
	'ratings-par-tag' => 'Tag peringkat. Tag tersebut menunjukkan "properti" halaman apa yang diberi peringkat.',
	'ratings-par-showdisabled' => 'Tunjukkan peringkat ketika pengguna tidak dapat memberi suara (pada mode baca-saja).',
	'ratings-par-incsummary' => 'Tunjukkan ringkasan pilihan saat ini di atas elemen peringkat?',
	'ratings-votesummary-desc' => 'Menampilkan ringkasan pendek pilihan untuk pasangan halaman dan properti tertentu.',
	'ratings-current-score' => 'Peringkat pengguna sekarang: $1 ($2 {{PLURAL:$2|peringkat|peringkat}})',
	'ratings-no-votes-yet' => 'Belum ada yang memberi peringkat.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'ratings-desc' => 'Määd et müjjelesch, dat Metmaacher för ongerscheidlijje Eijeschaffte vun de Sigge Note jävve künne.',
	'right-rate' => 'Note jävve för beshtemmpte ijeschaffte vun Sigge.',
	'ratings-starsratings-desc' => 'Zeisch Note eijfach met Shtäänsche aan un määd_et müjjelesch, dat ene Metmaacher för beshtemmpte Eijescahfte vun an Sigg Note verdeile kann. Wann hä ald ein verdeilt hät, kritt ene Mtmaacher aam Aanfang singe aktoälle Note_Shtand för di Sigg aanjezeisch.',
	'ratings-par-page' => 'De Sigg, woh en Note för jejovve weed.',
	'ratings-par-tag' => 'De Eijeschaff, för wat aan dä Sigg en Note jejovve weed.',
	'ratings-par-showdisabled' => 'Donn de Note aanzeije, wann der Metmaacher kein Note jävve kann, sönders nur lässe.',
	'ratings-par-incsummary' => 'Donn en Zosammefaßong vun de Note bovve övver däm Käßje zom Note verdeile aanzeije.',
	'ratings-votesummary-desc' => 'Zeisch en koote Zosammefassong vun de Note för de aanjejovve Sigg un de zwai Eijeschafte.',
	'ratings-current-score' => 'De Metmaacher han {{PLURAL:$2|ein|$2|noch kein}} Note jejovve, zosamme jenumme kohm dobei $1 eruß.',
	'ratings-no-votes-yet' => 'Doför hät noch Keiner Note jejovve.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'ratings-desc' => 'Erméiglecht et Benotzer fir verschidden "Eegeschaften" vu Säiten ze bewäerten',
	'right-rate' => 'Bestëmmten Eegeschafte vun enger Säit bewäerten',
	'ratings-starsratings-desc' => 'Weist en einfache Bewäertungssystem mat Hëllef vu Stären, deen de Benotzer et erlaabt fir eng Rei Eegeschafte vun enger Säit ze bewäerten.
Déi aktuell Bewäertung vun engem Benotzer gëtt gewisen, wann e seng Bewäertung schonn ofginn huet.',
	'ratings-par-page' => "D'Säit op déi sech d'Bewäertung bezitt.",
	'ratings-par-tag' => 'De Bewäertungs-Tag. Den Tag gëtt u watfir eng "Eegeschaft" vun der Säit bewäert gëtt.',
	'ratings-par-showdisabled' => 'Bewäertunge weisen wann de Benotzer net mat ofstëmme kann (Read-Only Modus)',
	'ratings-par-incsummary' => 'E Resumé vun den aktuelle Bewäertungen iwwer dem Element dat bewäert gëtt weisen?',
	'ratings-votesummary-desc' => 'Weist e kuerze Resumé vun de Bewäertungen fir déi spezifizéiert Säit an de bewäerte Beräich.',
	'ratings-current-score' => 'Aktuell Benotzerbewäertung: $1 ($2 {{PLURAL:$2|Bewäertung|Bewäertungen}})',
	'ratings-no-votes-yet' => 'Et huet nach keen dëst bewäert.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'ratings-desc' => 'Им овозможува на корисниците да оценуваат разни „својства“ на страниците',
	'right-rate' => 'Оценување на извесно својство на страница',
	'ratings-starsratings-desc' => 'Прикажува проста можност за доделување на ѕвездички за оценување на одредено својство на страницата.
Ако корисникот веќе еднаш гласал, тогаш ќе се прикажува тековната оценка (глас).',
	'ratings-par-page' => 'На која страница се однесува оценкава.',
	'ratings-par-tag' => 'Ознака за оценка. Ознаката покажува кое „својство“ на страницата се оценува.',
	'ratings-par-showdisabled' => 'Прикажувај оценки кога корисникот не може да гласа (во режим „само читање“).',
	'ratings-par-incsummary' => 'Да прикажувам опис на тековните гласови над елементот за оценка?',
	'ratings-votesummary-desc' => 'Прикажува краток опис на оценките (гласовите) за наведената страница и својство.',
	'ratings-current-score' => 'Тековна корисничка оценка: $1 ($2 {{PLURAL:$2|оценка|оценки}})',
	'ratings-no-votes-yet' => 'Сè уште никој го нема оценето ова.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 */
$messages['nb'] = array(
	'ratings-desc' => 'Tillater brukere å gi karakter på ulike "egenskaper" for sider',
	'right-rate' => 'Gi karakter på en bestemt egenskap for en side',
	'ratings-starsratings-desc' => 'Viser en enkel stjernebasert kontroll som tillater brukeren å gi karakterer på bestemte egenskaper for en side.',
	'ratings-par-page' => 'Siden som karakteren gjelder.',
	'ratings-par-tag' => 'Karaktertaggen. Taggen viser hvilken "egenskap" for siden som får karakter.',
	'ratings-par-showdisabled' => 'Vis karakterene for brukere som ikke tillates å gi karakterer (i lesemodus).',
	'ratings-par-incsummary' => 'Vise et sammendrag av de aktuelle stemmene over karakterelementet?',
	'ratings-votesummary-desc' => 'Viser et kort sammendrag over karakterstemmene for den angitte siden med egenskapspar.',
	'ratings-current-score' => 'Aktuell brukerkarakter: $1 (basert på $2 {{PLURAL:$2|karakter|karakterer}})',
	'ratings-no-votes-yet' => 'Ingen har gitt karakter på denne så langt.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'ratings-desc' => "Maakt het voor gebruikers mogelijk verschillende eigenschappen van pagina's te waarderen",
	'right-rate' => 'Een eigenschap van een pagina waarderen',
	'ratings-starsratings-desc' => 'Geeft een eenvoudig besturingselement met sterren weer waarin gebruikers een eigenschap van een pagina kunnen waarderen.
De huidige waardering van gebruikers wordt weergegeven als er al gewaardeerd is.',
	'ratings-par-page' => 'De pagina waar de waardering op van toepassing is.',
	'ratings-par-tag' => 'Het waarderingslabel. Het label geeft aan welke "eigenschap" van de pagina wordt gewaardeerd.',
	'ratings-par-showdisabled' => 'Waarderingen weergeven als de gebruiker niet kan waarderen (bij alleen-lezen).',
	'ratings-par-incsummary' => 'Een samenvatting weergeven van de huidige waarderingen boven het waarderingselement?',
	'ratings-votesummary-desc' => 'Geeft een korte samenvatting van de stemmen voor de opgegeven pagina en eigenschapspaar weer.',
	'ratings-current-score' => 'Huidige gebruikerswaardering: $1 ($2 {{PLURAL:$2|waardering|waarderingen}})',
	'ratings-no-votes-yet' => 'Dit onderdeel is nog door niemand gewaardeerd.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'ratings-desc' => 'A përmët a j\'utent ëd valuté "propietà" diferente dle pàgine',
	'right-rate' => 'Valuté na propietà ëd na pàgina',
	'ratings-starsratings-desc' => "A smon un contròl ëd valutassion sempi an stèile an përmëttend a l'utent ëd valuté na serta propietà ëd na pàgina.
Ël vot atual ëd l'utent a sarà visualisà inissialment quand ch'a l'ha già votà.",
	'ratings-par-page' => "La pàgina ch'a l'é valutà.",
	'ratings-par-tag' => 'La tichëtta ëd valutassion. La tichëtta a mòstra che "propietà" dla pàgina a l\'é valutà.',
	'ratings-par-showdisabled' => "Smon-e le valutassion quand l'utent a peul pa voté (mach an letura).",
	'ratings-par-incsummary' => "Mostré un resumé dij vot atuaj dzora a l'element an valutassion?",
	'ratings-votesummary-desc' => 'A mostra un curt resumé dij vot për la pàgina e la cobia ëd propietà spessificà.',
	'ratings-current-score' => "Valutassion corenta dl'utent: $1 ($2 {{PLURAL:$2|valutassion|valutassion}})",
	'ratings-no-votes-yet' => "Pa gnun a l'ha anco' valutà sossì.",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'ratings-desc' => 'Permite que os utilizadores avaliem várias "propriedades" das páginas',
	'right-rate' => 'Avalie uma determinada propriedade de uma página',
	'ratings-starsratings-desc' => 'Mostra um controlo simples de avaliação com estrelas, que permite que o utilizador avalie uma determinada propriedade de uma página.
Quando o utilizador já tiver votado antes, será inicialmente mostrado o seu voto actual.',
	'ratings-par-page' => 'A página à qual a avaliação se aplica.',
	'ratings-par-tag' => 'A marca da avaliação. A marca indica a "propriedade" que será avaliada na página.',
	'ratings-par-showdisabled' => 'Mostrar as avaliações quando o utilizador não pode votar (no modo de leitura).',
	'ratings-par-incsummary' => 'Mostrar um resumo dos votos actuais acima do elemento de avaliação?',
	'ratings-votesummary-desc' => 'Apresenta um resumo da votação referente à página e propriedades indicadas.',
	'ratings-current-score' => 'Avaliação actual dos utilizadores: $1 ($2 {{PLURAL:$2|avaliação|avaliações}})',
	'ratings-no-votes-yet' => 'Ainda não existem avaliações.',
);

/** Swedish (Svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'ratings-desc' => 'Tillåter användare betygsätta olika "egenskaper" av sidor',
	'right-rate' => 'Betygsätt en viss egenskap för en sida',
	'ratings-starsratings-desc' => 'Visar en enkel stjärnklassificeringskontroll som tillåter användaren att betygsätta en viss egenskap för en sida.
Den aktuella omröstningen av användaren visas först när han redan röstat.',
	'ratings-par-page' => 'Sidan betygsättningen gäller för.',
	'ratings-par-tag' => 'Betyget-taggen. Taggen anger vilken "egenskap" av sidan som blir betygsatt.',
	'ratings-par-showdisabled' => 'Visa betyg när användaren inte kan rösta (i skrivskyddat läge).',
	'ratings-par-incsummary' => 'Visa en sammanfattning av de aktuella rösterna ovanför betygselementet?',
	'ratings-votesummary-desc' => 'Visar en kort sammanfattning av rösterna för den angivna sidan och egenskapspar.',
	'ratings-current-score' => 'Aktuellt användarbetyg: $1 ($2 {{PLURAL:$2|betyg|betyg}})',
	'ratings-no-votes-yet' => 'Ingen har betygsatt detta ännu.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'ratings-no-votes-yet' => 'దీన్నింకా ఎవరూ మూల్యాంకన చెయ్యలేదు.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'ratings-desc' => 'Nagpapahintulot sa mga tagagamit na antasan ang iba\'t ibang mga "pag-aari" ng mga pahina',
	'ratings-par-page' => 'Ang pahinang malalapatan ng kaantasan.',
	'ratings-par-tag' => 'Ang tatak ng antas. Nagpapahiwatig ang tatak ng kung anong "pag-aari" ng pahina ang aantasan.',
	'ratings-par-showdisabled' => 'Ipakita ang mga antas kapag hindi makakaboto ang tagagamit (nasa pamamaraang mababasa lamang).',
	'ratings-par-incsummary' => 'Magpakita ng isang buod ng pangkasalukuyang mga boto na nasa itaas ng sangkap na antas?',
	'ratings-current-score' => 'Pangkasalukuyang antas ng tagagamit: $1 ($2 {{PLURAL:$2|antas|mga antas}})',
	'ratings-no-votes-yet' => 'Wala pang isang nag-aantas nito.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'ratings-desc' => '允许用户评价页面的不同“属性”',
	'right-rate' => '评价页面的某个属性',
	'ratings-starsratings-desc' => '显示简单的星级评价控件以允许用户评价页面的特定属性。
当用户投票后，用户的当前投票将被显示。',
	'ratings-par-page' => '评价应用到的页面。',
	'ratings-par-tag' => '评价标签。此标签指示页面的哪个“属性”被评价。',
	'ratings-par-showdisabled' => '当用户不能投票时显示评价（在只读模式中）。',
	'ratings-par-incsummary' => '在评价元素上方显示当前投票的摘要？',
	'ratings-votesummary-desc' => '显示指定的页面-属性对的投票摘要。',
	'ratings-current-score' => '当前用户评价：$1（$2次评价）',
	'ratings-no-votes-yet' => '还没有人为此评价。',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'ratings-desc' => '允許用戶評價頁面的不同“屬性”',
	'right-rate' => '評價頁面的某個屬性',
	'ratings-starsratings-desc' => '顯示簡單的星級評價控件以允許用戶評價頁面的特定屬性。
當用戶投票後，用戶的當前投票將被顯示。',
	'ratings-par-page' => '評價應用到的頁面。',
	'ratings-par-tag' => '評價標籤。此標籤指示頁面的哪個“屬性”被評價。',
	'ratings-par-showdisabled' => '當用戶不能投票時顯示評價（在只讀模式中）。',
	'ratings-par-incsummary' => '在評價元素上方顯示當前投票的摘要？',
	'ratings-votesummary-desc' => '顯示指定的頁面-屬性對的投票摘要。',
	'ratings-current-score' => '當前用戶評價：$1（$2次評價）',
	'ratings-no-votes-yet' => '還沒有人為此評價。',
);

