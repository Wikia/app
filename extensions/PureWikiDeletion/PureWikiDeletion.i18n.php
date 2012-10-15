<?php
/**
 * Internationalisation file for extension AbsenteeLandlord.
 */

$messages = array();

/** English
 */
$messages['en'] = array(
	'purewikideletion' => 'Pure wiki deletion',
	'randomexcludeblank' => 'Random page (exclude blank)',
	'populateblankedpagestable' => 'Populate blanked pages table',
	'purewikideletion-desc' => 'Among other things, causes blanked pages to be redlinked',
	'purewikideletion-pref-watchblank' => 'Add pages I blank to my watchlist',
	'purewikideletion-pref-watchunblank' => 'Add pages I unblank to my watchlist',
	'purewikideletion-blanked' => "A former version of this page was blanked by [[User:$1|$1]] ([[User talk:$1|talk]]) ([[Special:Contributions/$1|contribs]]) on $5 at $6.

The reason given for blanking was: ''<nowiki>$3</nowiki>''.

You may [{{fullurl:{{FULLPAGENAMEE}}|action=history}} view the page's history], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} edit the last version], or type new page into the white space below.",
	'blank-log' => 'blank',
	'blank-log-name' => 'Blank log',
	'blank-log-header' => 'Below is a list of page blankings and unblankings.',
	'blank-log-entry-blank' => 'blanked $1',
	'blank-log-entry-unblank' => 'unblanked $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|blank log]]',
	'purewikideletion-blanknologin' => 'Not logged in',
	'purewikideletion-blanknologintext' => 'You must be a registered user and [[Special:UserLogin|logged in]] to blank a page.',
	'purewikideletion-unblanknologintext' => 'You must be a registered user and [[Special:UserLogin|logged in]] to unblank a page.',
	'purewikideletion-blankedtext' => '[[$1]] has been blanked.
See $2 for a record of recent blankings.',
	'purewikideletion-population-done' => 'Done populating blanked_page table.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Populate]] the blanked pages table',
);

/** Message documentation (Message documentation)
 * @author Amire80
 * @author EugeneZelenko
 * @author Purodha
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'purewikideletion-desc' => '{{desc}}',
	'purewikideletion-pref-watchblank' => 'This message is supposed to be similar to {{msg-mw|Tog-watchcreations}}.',
	'purewikideletion-pref-watchunblank' => 'This message is supposed to be similar to {{msg-mw|Tog-watchcreations}}.',
	'purewikideletion-blanked' => 'Parameters:
* $1 - a user name
* $2 - date and time (duplicated in $5 and $6)
* $3 - the summary text of the log entry of the blanking
* $4 - the revision ID of the page contend before it was blanked
* $5 - the date part from $2
* $5 - the time part from $2',
	'purewikideletion-blanknologin' => '{{Identical|Not logged in}}',
	'right-purewikideletion' => '{{doc-right|purewikideletion}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'purewikideletion-blanknologin' => 'Nie ingeteken nie',
);

/** Arabic (العربية) */
$messages['ar'] = array(
	'purewikideletion' => 'حذف الويكي النقي',
	'randomexcludeblank' => 'صفحة عشوائية (لا يشمل ذلك الفارغة)',
	'populateblankedpagestable' => 'املأ جدول الصفحات الفارغة',
	'purewikideletion-desc' => 'من ضمن أشياء أخرى، يؤدي إلى أن تكون الصفحات الفارغة ذات وصلات حمراء',
	'purewikideletion-pref-watchblank' => 'أضف الفصفحات التي أفرغها إلى قائمة مراقبتي',
	'purewikideletion-pref-watchunblank' => 'أضف الصفحات التي أملؤها إلى قائمة مراقبتي',
	'purewikideletion-blanked' => "نسخة سابقة من هذه الصفحة تم إفراغها بواسطة [[User:$1|$1]] ([[User talk:$1|نقاش]]) ([[Special:Contributions/$1|مساهمات]]) في $2

السبب المعطى للإفراغ كان: ''<nowiki>$3</nowiki>''.

يمكنك [{{fullurl:{{FULLPAGENAMEE}}|action=history}} رؤية تاريخ المقالة], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} تعديل آخر نسخة]،
أو كتابة صفحة جديدة في الفراغ الأبيض بالأسفل.",
	'blank-log' => 'فارغة',
	'blank-log-name' => 'سجل الإفراغ',
	'blank-log-header' => 'بالأسفل قائمة بعمليات إفراغ وملأ الصفحات.',
	'blank-log-entry-blank' => 'أفرغ $1',
	'blank-log-entry-unblank' => 'ملأ $1',
	'purewikideletion-blanknologin' => 'غير مسجل الدخول',
	'purewikideletion-blanknologintext' => 'يجب أن تكون مستخدما مسجلا و [[Special:UserLogin|تسجل الدخول]] لإفراغ أو ملأ صفحة.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'blank-log' => 'ܣܦܝܩܬܐ',
	'blank-log-name' => 'ܣܓܠܐ ܣܦܝܩܐ',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'purewikideletion' => 'Строгае вікі-выдаленьне',
	'randomexcludeblank' => 'Выпадковая старонка (за выключэньнем пустых)',
	'populateblankedpagestable' => 'Запоўніць табліцу пустых старонак',
	'purewikideletion-desc' => 'Сярод іншых наступстваў, спасылкі на пустыя старонкі будуць выдзяляцца чырвоным колерам',
	'purewikideletion-pref-watchblank' => 'Дадаваць у мой сьпіс назіраньня старонкі, якія я буду ачышчаць',
	'purewikideletion-pref-watchunblank' => 'Дадаваць у мой сьпіс назіраньня старонкі, у якіх я буду адмяняць ачыстку',
	'purewikideletion-blanked' => "Папярэдняя вэрсія гэтай старонкі была ачышчаная [[User:$1|$1]] ([[User talk:$1|гутаркі]]) ([[Special:Contributions/$1|унёсак]]) $5 у $6.

Пададзеная прычына ачысткі была: ''<nowiki>$3</nowiki>''.

Вы можаце [{{fullurl:{{FULLPAGENAMEE}}|action=history}} праглядзець гісторыю старонкі], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} рэдагаваць апошнюю вэрсію], альбо ўвесьці тэкст новай старонкі ў белае поле ніжэй.",
	'blank-log' => 'ачыстка',
	'blank-log-name' => 'Журнал ачыстак',
	'blank-log-header' => 'Ніжэй пададзены сьпіс ачышчаных старонак і ў якіх ачыстка была адмененая.',
	'blank-log-entry-blank' => 'ачышчаная $1',
	'blank-log-entry-unblank' => 'адмененая ачыстка $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|журнал ачыстак]]',
	'purewikideletion-blanknologin' => 'Вы не ўвайшлі ў сыстэму',
	'purewikideletion-blanknologintext' => 'Вам неабходна [[Special:UserLogin|ўвайсьці ў сыстэму]], каб ачысьціць старонку.',
	'purewikideletion-unblanknologintext' => 'Вам неабходна [[Special:UserLogin|ўвайсьці ў сыстэму]], каб адмяніць ачыстку старонкі.',
	'purewikideletion-blankedtext' => 'Старонка [[$1]] была ачышчаная.
Глядзіце сьпіс апошніх ачыстак на $2.',
	'purewikideletion-population-done' => 'Выкананае запаўненьне табліцы blanked_page.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|запаўненьне]] табліцы ачышчаных старонак',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'purewikideletion' => "Dilamidigezh c'hlan wiki",
	'randomexcludeblank' => "Ur bajenn dre zegouezh (forc'hañ ar bajennoù gwenn)",
	'populateblankedpagestable' => 'Leuniañ taolenn ar pajennoù gwennaet',
	'purewikideletion-desc' => "Un dra all c'hoazh, lakaat a ra ar pajennoù gwennaet e liamm ruz",
	'purewikideletion-pref-watchblank' => "Ouzhpennañ da'm roll evezhiañ ar pajennoù gwennaet ganin",
	'purewikideletion-pref-watchunblank' => "Ouzhpennañ da'm roll evezhiañ ar pajennoù diwennaet ganin",
	'purewikideletion-blanked' => "Gwennet ez eus bet ur stumm kozh eus ar bajenn-mañ gant [[User:$1|$1]] ([[User talk:$1|kaozeal]]) ([[Special:Contributions/$1|degasadennoù]]) d'an $5 da $6.

Setu an abeg gwennañ : ''<nowiki>$3</nowiki>''.

Gallout a rit [{{fullurl:{{FULLPAGENAMEE}}|action=history}} gwelet istor ar bajenn], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} kemmañ ar stumm diwezhañ], pe skrivañ ur bajenn nevez en ur leuniañ an ichoù amañ dindan.",
	'blank-log' => 'gwennadurioù',
	'blank-log-name' => 'Roll ar gwennadurioù',
	'blank-log-header' => 'Roll ar pajennoù gwennaet ha diwennaet a zo diskouezet amañ a-is.',
	'blank-log-entry-blank' => 'en deus gwennaet $1',
	'blank-log-entry-unblank' => 'en deus diwennaet $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|roll ar gwennadurioù]]',
	'purewikideletion-blanknologin' => 'Digevreet',
	'purewikideletion-blanknologintext' => 'A-benn gellout gwennaat ur pennad e rankit bezañ un implijer enrollet ha bezañ [[Special:UserLogin|kevreet]].',
	'purewikideletion-unblanknologintext' => 'A-benn gellout diwennaat ur pennad e rankit bezañ un implijer enrollet ha bezañ [[Special:UserLogin|kevreet]].',
	'purewikideletion-blankedtext' => '[[$1]] a zo bet gwennaet.
Sellit ouzh $2 evit ur roll eus ar gwennadurioù nevez.',
	'purewikideletion-population-done' => 'Leuniet eo bet an daolenn blanked_page.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Leuniañ]] taolenn ar pajennoù gwennaet',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'purewikideletion' => 'Pražnjenje wiki stranica',
	'randomexcludeblank' => 'Slučajna stranica (neuključujući prazne)',
	'populateblankedpagestable' => 'Popuni tabele ispražnjenih stranica',
	'purewikideletion-desc' => 'Između drugih stvari, stvara od praznih stranica da izgledaju kao crveni linkovi',
	'purewikideletion-pref-watchblank' => 'Dodaj stranice koje ja ispraznim na moj spisak praćenih članaka',
	'purewikideletion-pref-watchunblank' => 'Dodaj prazne stranice koje ja vratim na moj spisak praćenih članaka',
	'blank-log' => 'prazno',
	'blank-log-name' => 'Zapisnik pražnjenja',
	'blank-log-link' => '[[{{#Special:Log}}/blank|zapisnik pražnjenja]]',
	'purewikideletion-blanknologin' => 'Niste prijavljeni',
);

/** German (Deutsch)
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'purewikideletion' => 'Leerung von Seiten',
	'randomexcludeblank' => 'Zufällige Seite (geleerte Seiten ausgenommen)',
	'populateblankedpagestable' => 'Tabelle mit geleerten Seiten erzeugen',
	'purewikideletion-desc' => 'Sorgt unter anderem dafür, dass geleerte Seiten als roter Link erscheinen',
	'purewikideletion-pref-watchblank' => 'Selbst geleerte Seiten automatisch beobachten',
	'purewikideletion-pref-watchunblank' => 'Seiten mit von mir zurückgenommenen Leerungen automatisch beobachten',
	'purewikideletion-blanked' => "Eine ehemalige Version dieser Seite wurde am $5 um $6 von [[User:$1|$1]] ([[User talk:$1|Diskussion]]) ([[Special:Contributions/$1|Beiträge]]) geleert.

Angegebene Begründung für die Leerung: ''<nowiki>$3</nowiki>''.

Du kannst [{{fullurl:{{FULLPAGENAMEE}}|action=history}} die Versionsgeschichte betrachten], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} dessen letzte Version bearbeiten] oder unten im Bearbeitungsfeld eine neue Seite erfassen.",
	'blank-log' => 'leeren',
	'blank-log-name' => 'Leerungs-Logbuch',
	'blank-log-header' => 'Es folgt eine Liste von Seitenleerungen und zurückgenommenen Entleerungen.',
	'blank-log-entry-blank' => 'leerte „$1“',
	'blank-log-entry-unblank' => 'entleerte „$1“',
	'blank-log-link' => '[[{{#Special:Log}}/blank|Leerungs-Logbuch]]',
	'purewikideletion-blanknologin' => 'Nicht angemeldet',
	'purewikideletion-blanknologintext' => 'Du musst ein registrierter Benutzer und [[Special:UserLogin|angemeldet sein]], um eine Seite zu leeren.',
	'purewikideletion-unblanknologintext' => 'Du musst ein registrierter Benutzer und [[Special:UserLogin|angemeldet sein]], um die Leerung einer Seite zurücknehmen zu können.',
	'purewikideletion-blankedtext' => '„[[$1]]“ wurde geleert.
Siehe das $2 für eine Liste der letzten Leerungen.',
	'purewikideletion-population-done' => 'Tabelle „blanked_page“ mit geleerten Seiten erzeugt',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Erzeuge]] Tabelle mit geleerten Seiten',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'purewikideletion-blanked' => "Eine ehemalige Version dieser Seite wurde am $5 um $6 von [[User:$1|$1]] ([[User talk:$1|Diskussion]]) ([[Special:Contributions/$1|Bearbeitungen]]) geleert.

Angegebene Begründung für die Leerung: ''<nowiki>$3</nowiki>''.

Sie können [{{fullurl:{{FULLPAGENAMEE}}|action=history}} die Versionsgeschichte betrachten], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} dessen letzte Version bearbeiten] oder unten im Bearbeitungsfeld eine neue Seite erfassen.",
	'purewikideletion-blanknologintext' => 'Sie müssen ein registrierter Benutzer und [[Special:UserLogin|angemeldet sein]], um eine Seite zu leeren.',
	'purewikideletion-unblanknologintext' => 'Sie müssen ein registrierter Benutzer und [[Special:UserLogin|angemeldet sein]], um die Leerung einer Seite zurücknehmen zu können.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'purewikideletion' => 'Dopołne wulašowanje',
	'randomexcludeblank' => 'Pśipadny bok (bźez proznych bokow)',
	'populateblankedpagestable' => 'Tabelu wuproznjonych bokow napóraś',
	'purewikideletion-desc' => 'Zawinujo mj. dr., až se wuproznjone boki pokazuju se ako cerwjone wótkaze',
	'purewikideletion-pref-watchblank' => 'Boki, kótarež som wuproznił, awtomatiski wobglědowaś',
	'purewikideletion-pref-watchunblank' => 'Boki, kótarež som napołnił, awtomatiski wobglědowaś',
	'purewikideletion-blanked' => "Pjerwjejšna wersija toś togo boka jo se wót [[User:$1|$1]] ([[User talk:$1|diskusija]]) ([[Special:Contributions/$1|pśinoski]]) $5  $6 wuprozniła.

Pśicyna za wuproznjenje: ''<nowiki>$3</nowiki>''.

Móžoš [{{fullurl:{{FULLPAGENAMEE}}|action=history}} historiju boka se woglědaś], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} slědnu wersiju wobźěłaś] abo nowy bok spisaś.",
	'blank-log' => 'prozniś',
	'blank-log-name' => 'Protokol wuproznjenjow',
	'blank-log-header' => 'Dołojce jo lisćina wuproznjenjow a napołnjenjow bokow.',
	'blank-log-entry-blank' => 'jo $1 wuproznił',
	'blank-log-entry-unblank' => 'jo $1 napołnił',
	'blank-log-link' => '[[{{#Special:Log}}/blank|protokol wuproznjenjow]]',
	'purewikideletion-blanknologin' => 'Njepśizjawjony',
	'purewikideletion-blanknologintext' => 'Musyš zregistrěrowany wužywaŕ a [[Special:UserLogin|pśizjawjony]] byś, aby wuproznił bok.',
	'purewikideletion-unblanknologintext' => 'Musyš zregistrěrowany wužywaŕ a [[Special:UserLogin|pśizjawjony]] byś, aby napołnił bok.',
	'purewikideletion-blankedtext' => '[[$1]] jo se wuproznił.
Glědaj $2 za dataowa sajźbu nejnowšych wuproznjenjow.',
	'purewikideletion-population-done' => 'Tabela z wuproznjonymi bokami napórana',
	'right-purewikideletion' => 'Tabelu z wuproznjonymi bokami [[Special:PopulateBlankedPagesTable|napóraś]]',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Diego Grez
 * @author Drini
 * @author Translationista
 */
$messages['es'] = array(
	'purewikideletion' => 'Eliminación wiki pura',
	'randomexcludeblank' => 'Página aleatoria (excluye páginas en blanco)',
	'populateblankedpagestable' => 'Llenar la tabla de páginas vaciadas',
	'purewikideletion-desc' => 'Entre otras cosas, hace que los vínculos a las páginas vaciadas se muestren en rojo',
	'purewikideletion-pref-watchblank' => 'Añadir las páginas que blanquee a mi lista de seguimiento',
	'purewikideletion-pref-watchunblank' => 'Añadir a mi lista de seguimiento las páginas cuyo vaciado revierta',
	'purewikideletion-blanked' => "Una anterior versión de esta página fue dejada en blanco por [[User:$1|$1]] ([[User talk:$1|talk]]) ([[Special:Contributions/$1|contribuciones]]) el $5 a las $6.

La razón dada para dejar en blanco fue: ''<nowiki>$3</nowiki>''.

Puedes [{{fullurl:{{FULLPAGENAMEE}}|action=history}} ver el historial de la página], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} editar la última versión], o escribir una nueva página dentro del espacio en blancom de abajo.",
	'blank-log' => 'en blanco',
	'blank-log-name' => 'Registro de vaciados',
	'blank-log-header' => 'A continuación se muestra un listado de vaciados y reversiones de vaciados de páginas.',
	'blank-log-entry-blank' => 'se ha vaciado $1',
	'blank-log-entry-unblank' => 'se ha revertido el vaciado de $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|registro de páginas en blanco]]',
	'purewikideletion-blanknologin' => 'No has iniciado sesión',
	'purewikideletion-blanknologintext' => 'Debes ser un usuario registrado e [[Special:UserLogin|iniciar sesión]] para dejar en blanco un página.',
	'purewikideletion-unblanknologintext' => 'Debes ser un usuario registrado e [[Special:UserLogin|iniciar sesión]] para revertir un blanqueado de página.',
	'purewikideletion-blankedtext' => '[[$1]] ha sido dejada en blanco.
Ver $2 para un registro de blanqueado de páginas reciente.',
	'purewikideletion-population-done' => 'Se completó el llenado de la tabla blanked_page',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Llenar]] la tabla de páginas blanqueadas',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'purewikideletion' => 'Pure suppression wiki',
	'randomexcludeblank' => 'Page au hasard (exclure les pages blanches)',
	'populateblankedpagestable' => 'Remplir la table des pages blanchies',
	'purewikideletion-desc' => 'Entre autres choses, met les pages blanchies en lien rouge',
	'purewikideletion-pref-watchblank' => 'Ajouter les pages que je blanchis à ma liste de suivi',
	'purewikideletion-pref-watchunblank' => 'Ajouter les pages dé-blanchis à ma liste de suivi',
	'purewikideletion-blanked' => "Une ancienne version de cette page a été blanchie par [[User:$1|$1]] ([[User talk:$1|discuter]]) ([[Special:Contributions/$1|contributions]]) le $5 à $6.

La raison du blanchissement était : ''<nowiki>$3</nowiki>''.

Vous pouvez [{{fullurl:{{FULLPAGENAMEE}}|action=history}} voir l'historique de cet article], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} modifier la dernière version] ou taper une nouvelle page en remplissant le vide ci-dessous.",
	'blank-log' => 'blanchissements',
	'blank-log-name' => 'Journal des blanchissements',
	'blank-log-header' => 'Une liste des pages blanchies et dé-blanchies est affichée ci-dessous.',
	'blank-log-entry-blank' => 'a blanchi $1',
	'blank-log-entry-unblank' => 'a dé-blanchi $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|journal des blanchissements]]',
	'purewikideletion-blanknologin' => 'Non connecté',
	'purewikideletion-blanknologintext' => 'Vous devez être enregistré et [[Special:UserLogin|connecté]] pour blanchir des pages.',
	'purewikideletion-unblanknologintext' => 'Vous devez être enregistré et [[Special:UserLogin|connecté]] pour dé-blanchir des pages.',
	'purewikideletion-blankedtext' => '[[$1]] a été blanchi.
Voyez le $2 pour un journal des blanchissements récents.',
	'purewikideletion-population-done' => 'Remplissage de la table blanked_page effectué.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Remplir]] la table des pages blanchies',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'purewikideletion' => 'Pura suprèssion vouiqui',
	'randomexcludeblank' => 'Pâge a l’hasârd (èxcllure les pâges blanchies)',
	'populateblankedpagestable' => 'Remplir la trâbla de les pâges blanchies',
	'purewikideletion-pref-watchblank' => 'Apondre les pâges que blanchésso a ma lista de survelyence',
	'purewikideletion-pref-watchunblank' => 'Apondre les pâges que dè-blanchésso a ma lista de survelyence',
	'blank-log' => 'blanchiments',
	'blank-log-name' => 'Jornal des blanchiments',
	'blank-log-entry-blank' => 'at blanchi $1',
	'blank-log-entry-unblank' => 'at dè-blanchi $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|jornal des blanchiments]]',
	'purewikideletion-blanknologin' => 'Pas branchiê',
	'purewikideletion-population-done' => 'Remplissâjo de la trâbla blanked_page fêt.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Remplir]] la trâbla de les pâges blanchies',
);

/** Galician (Galego)
 * @author Gallaecio
 * @author Toliño
 */
$messages['gl'] = array(
	'purewikideletion' => 'Borrado wiki',
	'randomexcludeblank' => 'Páxina ao chou (excluíndo as baleiras)',
	'populateblankedpagestable' => 'Encher a táboa de páxinas baleiradas',
	'purewikideletion-desc' => 'Entre outras cousas, provoca que as páxinas baleiras se convertan en ligazóns vermellas',
	'purewikideletion-pref-watchblank' => 'Engadir á miña lista de vixilancia aquelas páxinas que baleire',
	'purewikideletion-pref-watchunblank' => 'Engadir á miña lista de vixilancia aquelas páxinas cuxo baleirado reverta',
	'purewikideletion-blanked' => "[[User:$1|$1]] ([[User talk:$1|conversa]]) ([[Special:Contributions/$1|contribucións]]) baleirou unha versión vella desta páxina o $5 ás $6.

A razón que deu para o borrado foi: ''<nowiki>$3</nowiki>''.

Pode [{{fullurl:{{FULLPAGENAMEE}}|action=history}} ollar o historial da páxina], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} editar a última versión] ou escribir unha nova páxina no espazo en branco que hai embaixo.",
	'blank-log' => 'baleirado',
	'blank-log-name' => 'Rexistro de baleirados',
	'blank-log-header' => 'A continuación está a lista cos baleirados de páxinas, así como as reversións de baleirados de páxinas.',
	'blank-log-entry-blank' => 'baleirou "$1"',
	'blank-log-entry-unblank' => 'reverteu o baleirado de "$1"',
	'blank-log-link' => '[[{{#Special:Log}}/blank|rexistro de baleirados]]',
	'purewikideletion-blanknologin' => 'Non accedeu ao sistema',
	'purewikideletion-blanknologintext' => 'Debe ser un usuario rexistrado e [[Special:UserLogin|acceder ao sistema]] para baleirar unha páxina.',
	'purewikideletion-unblanknologintext' => 'Debe ser un usuario rexistrado e [[Special:UserLogin|acceder ao sistema]] para reverter o baleirado dunha páxina.',
	'purewikideletion-blankedtext' => 'Baleirouse a páxina "[[$1]]".
No $2 pode ver unha lista cos baleirados máis recentes.',
	'purewikideletion-population-done' => 'Encheuse a táboa blanked_page.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Encher]] a táboa de páxinas baleiradas',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'purewikideletion' => 'Wikisyte-Läärig',
	'randomexcludeblank' => 'Zuefelligi Syte (gläärti uusgnuu)',
	'populateblankedpagestable' => 'Tabälle mit gläärte Syten aalege',
	'purewikideletion-desc' => 'Sorgt unter anderem derfir, ass gläärti Syten as rote Link erschyyne',
	'purewikideletion-pref-watchblank' => 'Sälber gläärti Sytene beobachte',
	'purewikideletion-pref-watchunblank' => 'Sytene, wun i d Läärig ruckgängig gmacht haa, beobachte',
	'purewikideletion-blanked' => "E ehmoligi Version vu däre Syten isch am $5 am $6 vu [[User:$1|$1]] ([[User talk:$1|Diskussion]]) ([[Special:Contributions/$1|Byytreg]]) gläärt wore.

Grund, wu aagee isch fir d Läärig: ''<nowiki>$3</nowiki>''.

Du chasch [{{fullurl:{{FULLPAGENAMEE}}|action=history}} d Versionsgschicht bschaue], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} di letscht Version vun em bearbeite] oder unten im Bearbeitigsfäld e neji Syte yygee.",
	'blank-log' => 'lääre',
	'blank-log-name' => 'Läärigs-Logbuech',
	'blank-log-header' => 'Do unte chunnt e Lischt vu Syteläärige un Lärrige, wu zruckgnuu wore sin.',
	'blank-log-entry-blank' => 'het „$1“ gläärt',
	'blank-log-entry-unblank' => 'het d Läärig vu „$1“ zruckgnuu',
	'blank-log-link' => '[[{{#Special:Log}}/blank|Läärigs-Logbuech]]',
	'purewikideletion-blanknologin' => 'Nit aagmäldet',
	'purewikideletion-blanknologintext' => 'Du muesch e regischtrierte Benutzer un [[Special:UserLogin|aagmäldet syy]] go ne Syte lääre.',
	'purewikideletion-unblanknologintext' => 'Du muesch e regischtrierte Benutzer un [[Special:UserLogin|aagmäldet syy]] go d Läärig vun ere Syte zruckneh.',
	'purewikideletion-blankedtext' => '„[[$1]]“ isch gläärt wore.
Lueg au s $2 fir e Lischt vu dr letschte Läärige.',
	'purewikideletion-population-done' => 'Tabälle „blanked_page“ mit gläärte Syten aagleit',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Tabälle aalege mit gläärte Syte]]',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'purewikideletion' => 'מחיקת ויקי טהורה',
	'randomexcludeblank' => 'דף אקראי (למעט ריקים)',
	'populateblankedpagestable' => 'לאכלס את טבלת הדפים הריקים',
	'purewikideletion-desc' => 'בין היתר, הפיכת קישורים לדפים ריקים לאדומים',
	'purewikideletion-pref-watchblank' => 'מעקב אחרי דפים שרוקנתי',
	'purewikideletion-pref-watchunblank' => 'מעקב אחרי דפים שביטלתי את ריקונם',
	'purewikideletion-blanked' => "גרסה קודמת של הדף הזה רוקנה על־ידי [[User:$1|$1]] ([[User talk:$1|שיחה]]) ([[Special:Contributions/$1|תרומות]]) בתאריך $5 בשעה $6.

הסיבה שניתנה לריקון היא ''<nowiki>$3</nowiki>''.

אפשר לצפות ב[[{{fullurl:{{FULLPAGENAMEE}}|action=history}}] גרסאות הקודמות של הדף], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} לערוך את הגרסה האחרונה] או להקליד דף חדש בתיבת העריכה להלן.",
	'blank-log' => 'ריק',
	'blank-log-name' => 'יומן ריקונים',
	'blank-log-header' => 'להלן רשימת דפים שרוקנו ושמולאו מחדש',
	'blank-log-entry-blank' => 'רוקן את $1',
	'blank-log-entry-unblank' => 'ביטל את הריקון של $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|יומן ריקונים]]',
	'purewikideletion-blanknologin' => 'לא נכנסתם לחשבון',
	'purewikideletion-blanknologintext' => 'צריך להיות משתמש רשום ו[[Special:UserLogin|להיכנס לחשבון]] כדי לרוקן דף.',
	'purewikideletion-unblanknologintext' => 'צריך להיות משתמש רשום ו[[Special:UserLogin|להיכנס לחשבון]] כדי לבטל ריקון של דף.',
	'purewikideletion-blankedtext' => "[[$1]] רוקן.
ר' $2 לרישום של ריקונים אחרונים.",
	'purewikideletion-population-done' => 'אכלוס טבלת הדפים המרוקנים (blanked_page) הושלם.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|לאכלס]] את טבלת הדפים המרוקנים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'purewikideletion' => 'Dospołna wikizhašenje',
	'randomexcludeblank' => 'Připadna strona (prózdne wuzamknyć)',
	'populateblankedpagestable' => 'Tabelu wuprózdnjenych stronow pjelnić',
	'purewikideletion-desc' => 'Wuskutkuje mj. dr., zo prózdne strony jewja so jako čerwjene wotkazy',
	'purewikideletion-pref-watchblank' => 'Strony, kotrež prózdnju, mojim wobkedźbowankam přidać',
	'purewikideletion-pref-watchunblank' => 'Strony, kotrež pjelnju, mojim wobkedźbowankam přidać',
	'purewikideletion-blanked' => "Prjedawša wersija tuteje strony bu wot [[User:$1|$1]] ([[User talk:$1|diskusija]]) ([[Special:Contributions/$1|přinoški]])  $5 $6 wuprózdnjena.

Přičina za wuprózdnjenje: ''<nowiki>$3</nowiki>''.

Móžeš sej  [{{fullurl:{{FULLPAGENAMEE}}|action=history}} wersijowe stawizny nastawka wobhladać],  [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} poslednju wersiju wobdźěłać] abo nowu stronu zapodać.",
	'blank-log' => 'wuprózdnić',
	'blank-log-name' => 'Protokol wuprózdnjenjow',
	'blank-log-header' => 'Deleka je lisćina wuprózdnjenjow a napjelnjenjow stronow.',
	'blank-log-entry-blank' => 'je $1 wuprózdnił',
	'blank-log-entry-unblank' => 'je $1 napjelnił',
	'blank-log-link' => '[[{{#Special:Log}}/blank|protokol wuprózdnjenjow]]',
	'purewikideletion-blanknologin' => 'Njepřizjewjeny',
	'purewikideletion-blanknologintext' => 'Dyrbiš zregistrowany wužiwar a  [[Special:UserLogin|přizjewjeny]] być, zo by stronu wuprózdnił.',
	'purewikideletion-unblanknologintext' => 'Dyrbiš zregistrowany wužiwar a  [[Special:UserLogin|přizjewjeny]] być, zo by stronu napjelnił.',
	'purewikideletion-blankedtext' => 'Strona [[$1]] je so wuprózdniła.
Hlej $2 za datowu sadźbu najnowšich wuprózdnjenjow.',
	'purewikideletion-population-done' => 'Pjelnjenje tabele wuprózdnjenych stronow skónčene.',
	'right-purewikideletion' => 'Tabelu wuprózdnjenych stronow [[Special:PopulateBlankedPagesTable|napjelnić]]',
);

/** Hungarian (Magyar)
 * @author BáthoryPéter
 * @author Dani
 */
$messages['hu'] = array(
	'randomexcludeblank' => 'Véletlen lap (üres lapokat kivéve)',
	'purewikideletion-pref-watchblank' => 'Az általam kiürített lapok felvétele a figyelőlistára',
	'purewikideletion-blanknologin' => 'Nem vagy bejelentkezve',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'purewikideletion' => 'Pur deletion wiki',
	'randomexcludeblank' => 'Pagina aleatori (non vacue)',
	'populateblankedpagestable' => 'Plenar le tabella de paginas vacuate',
	'purewikideletion-desc' => 'Inter altere cosas, causa que le ligamines a paginas vacuate appare in rubie',
	'purewikideletion-pref-watchblank' => 'Adder le paginas que io vacua a mi observatorio',
	'purewikideletion-pref-watchunblank' => 'Adder le paginas que io replena a mi observatorio',
	'purewikideletion-blanked' => "Un ancian version de iste pagina ha essite vacuate per [[User:$1|$1]] ([[User talk:$1|discussion]]) ([[Special:Contributions/$1|contribs]]) le $5 a $6.

Le motivo date pro le vacuation es: ''<nowiki>$3</nowiki>''.

Tu pote [{{fullurl:{{FULLPAGENAMEE}}|action=history}} vider le historia del pagina], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} modificar le ultime version], o scriber un nove pagina in le spatio in blanco hic infra.",
	'blank-log' => 'vacuationes',
	'blank-log-name' => 'Registro de vacuationes',
	'blank-log-header' => 'Infra es un lista de vacuationes e replenationes de paginas.',
	'blank-log-entry-blank' => 'vacuava $1',
	'blank-log-entry-unblank' => 'replenava $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|registro de vacuationes]]',
	'purewikideletion-blanknologin' => 'Tu non ha aperite un session',
	'purewikideletion-blanknologintext' => 'Tu debe esser un usator registrate e [[Special:UserLogin|aperir un session]] pro poter vacuar un pagina.',
	'purewikideletion-unblanknologintext' => 'Tu debe esser un usator registrate e [[Special:UserLogin|aperir un session]] pro poter replenar un pagina.',
	'purewikideletion-blankedtext' => '[[$1]] ha essite vacuate.
Vide $2 pro un registro de vacuationes recente.',
	'purewikideletion-population-done' => 'Le tabella blanked_page ha essite plenate.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Plenar]] le tabella de paginas vacuate',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 */
$messages['id'] = array(
	'purewikideletion' => 'Penghapusan wiki murni',
	'randomexcludeblank' => 'Halaman acak (tidak termasuk kosong)',
	'populateblankedpagestable' => 'Isi tabel halaman yang dikosongkan',
	'purewikideletion-desc' => 'Antara lain, menyebabkan halaman yang dikosongkan menjadi pranala merah',
	'purewikideletion-pref-watchblank' => 'Tambahkan halaman yang saya kosongkan ke daftar pantauan',
	'purewikideletion-pref-watchunblank' => 'Tambahkan halaman yang saya takjadi kosongkan ke daftar pantauan',
	'purewikideletion-blanked' => "Versi sebelumnya dari halaman ini dikosongkan oleh [[User:$1|$1]] ([[User talk:$1|bicara]]) ([[Special:Contributions/$1|kontrib]]) pada tanggal $5 pukul $6.

Alasan pengosongan adalah: ''<nowiki>$3</nowiki>''.

Anda dapat [{{fullurl:{{FULLPAGENAMEE}}|action=history}} melihat versi terdahulu halaman ini], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} menyunting versi terakhir], atau menyunting halaman baru menggunakan kotak putih di bawah.",
	'blank-log' => 'kosong',
	'blank-log-name' => 'Log pengosongan',
	'blank-log-header' => 'Berikut adalah daftar pengosongan dan takjadi pengosongan halaman.',
	'blank-log-entry-blank' => 'dikosongkan $1',
	'blank-log-entry-unblank' => 'tidak dikosongkan $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|log pengosongan]]',
	'purewikideletion-blanknologin' => 'Belum masuk log',
	'purewikideletion-blanknologintext' => 'Anda harus menjadi pengguna terdaftar dan telah [[Special:UserLogin|masuk log]] untuk mengosongkan suatu halaman.',
	'purewikideletion-unblanknologintext' => 'Anda harus menjadi pengguna terdaftar dan telah [[Special:UserLogin|masuk log]] untuk takjadi kosongkan suatu halaman.',
	'purewikideletion-blankedtext' => '[[$1]] telah dikosongkan.
Lihat $2 untuk catatan pengosongan terkini.',
	'purewikideletion-population-done' => 'Berhasil mengisi tabel blanked_page.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Isi]] tabel halaman yang dikosongkan',
);

/** Japanese (日本語)
 * @author 青子守歌
 */
$messages['ja'] = array(
	'purewikideletion' => 'ピュア・ウィキ削除',
	'randomexcludeblank' => 'ランダムページ（白紙状態を除く）',
	'populateblankedpagestable' => '白紙化されたページの一覧表を読み込む',
	'purewikideletion-desc' => 'ページが白紙化されるなど、赤リンクになるべきものに関する機能',
	'purewikideletion-pref-watchblank' => '自分が白紙化したページをウォッチリストに追加する',
	'purewikideletion-pref-watchunblank' => '自分が白紙化解除したページをウォッチリストに追加する',
	'purewikideletion-blanked' => "このページの以前の版は、[[User:$1|$1]]（[[User talk:$1|トーク]]) ([[Special:Contributions/$1|投稿記録]]）によって、 $5の$6に白紙化されました。

白紙化の理由は次の通り：''<nowiki>$3</nowiki>''

[{{fullurl:{{FULLPAGENAMEE}}|action=history}} このページの履歴を閲覧]したり、[{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} 最後の版を編集]することができます。あるいは、新しい内容を直接入力してください。",
	'blank-log' => '白紙化',
	'blank-log-name' => '白紙化ログ',
	'blank-log-header' => '以下は、白紙化されたあるいは白紙化が解除されたページの一覧です。',
	'blank-log-entry-blank' => '$1を白紙化',
	'blank-log-entry-unblank' => '$1を白紙化解除',
	'blank-log-link' => '[[{{#Special:Log}}/blank|白紙化ログ]]',
	'purewikideletion-blanknologin' => 'ログインしていません',
	'purewikideletion-blanknologintext' => 'ページを白紙化するためには、利用者登録をし、[[Special:UserLogin|ログイン]]しなければなりません。',
	'purewikideletion-unblanknologintext' => 'ページを白紙化解除するためには、利用者登録をし、[[Special:UserLogin|ログイン]]しなければなりません。',
	'purewikideletion-blankedtext' => '[[$1]]は既に白紙化されています。
最近の白紙化の記録は、$2をご覧下さい。',
	'purewikideletion-population-done' => '白紙化されたページの一覧表の読み込みが完了しました。',
	'right-purewikideletion' => '白紙化されたページの一覧表を[[Special:PopulateBlankedPagesTable|読み込む]]',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'purewikideletion' => 'Sigge läddesh maache',
	'randomexcludeblank' => 'Zohfälleje Sigg, ävver nit läddesch',
	'populateblankedpagestable' => 'De Daatebangktabäll met de läddije Sigge fölle',
	'purewikideletion-desc' => 'Sorresch nävve ander Saache doför, dat op leddisch jemaate Sigge bloß ruude Lengks jonn.',
	'purewikideletion-pref-watchblank' => 'Dun de Sigge, die ich läddesch maachen, för ming Oppassliss vürschlage',
	'purewikideletion-pref-watchunblank' => 'Dun de Sigge, di läddesch jemaat wohre, wo esch dat retuur nämmen, för ming Oppassliss vürschlage',
	'purewikideletion-blanked' => "En älder Version vun heh dä Sigg hät {{GENDER:$1|dä|et|dä Metmaacher|de|dat}} [[User:$1|$1]] ([[User talk:$1|Klaaf]]) ([[Special:Contributions/$1|Beidrääsch]]) aam $5 om $6 Uhr läddesch jemaat.

Der Jrond doför wohr: ''<nowiki>$3</nowiki>''.

Do kanns [{{fullurl:{{FULLPAGENAMEE}}|action=history}} de Leß met de Version vun dä Sigg beloore], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} de läzde Version dovör ändere], udder en neu Sigg en dä läddejje Plaz onge schrieve.",
	'blank-log' => 'läddesch Maache',
	'blank-log-name' => 'Logbooch vum Sigge läddesch Maache',
	'blank-log-header' => 'Heh küdd_en Leß met läddesch jemaate Sigg un met dovun  retuur jehollte Sigge.',
	'blank-log-entry-blank' => 'hät de Sigg „$1“ läddesch jemaat',
	'blank-log-entry-unblank' => 'hät de läddejje Sigg „$1“ widder retuur jehollt',
	'blank-log-link' => 'Et [[{{#Special:Log}}/blank|{{int:blank-log-name}}]]',
	'purewikideletion-blanknologin' => 'Nit enjelogg',
	'purewikideletion-blanknologintext' => 'Do mööts ald aanjemeldt un [[Special:UserLogin|enjelogg]] sin, öm en Sigg läddesch ze maache.',
	'purewikideletion-unblanknologintext' => 'Do mööts ald aanjemeldt un [[Special:UserLogin|enjelogg]] sin, öm en läddesch jemaate Sigg widder retuur ze holle.',
	'purewikideletion-blankedtext' => '[[$1]] es läddesch jemaat.
Loor op $2, doh es en Leß met de zoläz läddesch jemaate Sigge.',
	'purewikideletion-population-done' => 'De Daatebangktabäll met de läddije Sigge es jäz jeföllt.',
	'right-purewikideletion' => 'De [[Special:PopulateBlankedPagesTable|Daatebangktabäll met de läddije Sigge fölle]]',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'purewikideletion' => 'Eidelmaache vu Säiten',
	'randomexcludeblank' => 'Zoufälleg Säit (ouni déi eidelgemaachte Säiten)',
	'populateblankedpagestable' => "D'Tabell vun den eidelgemaachte Säiten opfëllen",
	'purewikideletion-desc' => 'Féiert ënner anerem dozou datt eidelgemaachte Säiten als roude Link gewise ginn',
	'purewikideletion-pref-watchblank' => 'Säiten déi ech eidelmaachen op meng Iwwerwaachungslëscht derbäisetzen',
	'purewikideletion-pref-watchunblank' => 'Säiten déi ech eidelmaachen op meng Iwwerwaachungslëscht derbäisetzen',
	'purewikideletion-blanked' => "Eng vireg Versioun vun dëser Säit gouf eidelgemaach vum [[User:$1|$1]] ([[User talk:$1|talk]]) ([[Special:Contributions/$1|contribs]]) den $5 ëm $6 Auer.

De Grond fir d'Eidelmaache war: ''<nowiki>$3</nowiki>''.

Dir kënnt [{{fullurl:{{FULLPAGENAMEE}}|action=history}} de Versiounshistorique vun der Säit gesinn], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} déi lescht Versioun änneren] oder eng nei Säit an de wäisse Raum hei drënner schreiwen.",
	'blank-log' => 'eidel maachen',
	'blank-log-name' => 'Logbuch vun de Säiten déi eidel gemaach goufen',
	'blank-log-header' => "Hei ass d'Lëscht vun de Säiten déi eidelgemaach goufen respektiv wou eidel Säiten nees zréck gesat goufen.",
	'blank-log-entry-blank' => 'huet $1 eidegemaacht',
	'blank-log-entry-unblank' => "huet d'eidelmaache vu(n) $1 réckgängeg gemaach",
	'blank-log-link' => '[[{{#Special:Log}}/blank|Logbuch vun den eidelgmaachte Säiten]]',
	'purewikideletion-blanknologin' => 'Net ageloggt',
	'purewikideletion-blanknologintext' => 'Dir musst e registréierte Benotzer an [[Special:UserLogin|ageloggt]] sinn, fir eng Säit eidelzemaachen.',
	'purewikideletion-unblanknologintext' => 'Dir musst e registréierte Benotzer an [[Special:UserLogin|ageloggt]] sinn, fir eng Säit eidel ze maachen.',
	'purewikideletion-blankedtext' => "[[$1]] gouf eidel gemaacht.
Kuckt $2 fir d'Lëscht vun de Säiten déi rezent eidel gemaach goufen.",
	'purewikideletion-population-done' => "D'Tabell mat den eidelgemaachte Säiten ass fäerdeg.",
	'right-purewikideletion' => "D'Tabell mat den eidelgemaachte Säite [[Special:PopulateBlankedPagesTable|generéieren]]",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'purewikideletion' => 'Чисто вики-бришење',
	'randomexcludeblank' => 'Случајна страница (без празни)',
	'populateblankedpagestable' => 'Исполни ја табелата со испразнети страници',
	'purewikideletion-desc' => 'Меѓу останатите функции, ги брише испразнетите страници',
	'purewikideletion-pref-watchblank' => 'Додавај ги страниците што ги празнам во мојот список на набљудувања',
	'purewikideletion-pref-watchunblank' => 'Додавај ги испразнетите страници што ги враќам во мојот список на набљудувања',
	'purewikideletion-blanked' => "Претходна верзија на оваа страница беше испразнета од [[User:$1|$1]] ([[User talk:$1|разговор]]) ([[Special:Contributions/$1|придонеси]]) на $5 во $6.

За испразнувањето беше наведена следнава причина: ''<nowiki>$3</nowiki>''.

Можете да ја [{{fullurl:{{FULLPAGENAMEE}}|action=history}} погледате историјата на статијата], да ја [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} уредите најновата верзија], или пак да напишете нова содржина за страницата во просторот подолу.",
	'blank-log' => 'испразнета',
	'blank-log-name' => 'Дневник на празнења',
	'blank-log-header' => 'Подолу е наведен список на празнења и враќања на испразнети страници.',
	'blank-log-entry-blank' => 'испразнета $1',
	'blank-log-entry-unblank' => 'вратено празнење на $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|дневник на празнења]]',
	'purewikideletion-blanknologin' => 'Не сте најавени',
	'purewikideletion-blanknologintext' => 'Мора да сте регистриран корисник и да сте [[Special:UserLogin|најавени]] за да можете да празните страници.',
	'purewikideletion-unblanknologintext' => 'Мора да сте регистриран корисник и да сте [[Special:UserLogin|најавени]] за да можете да враќате испразнети страници.',
	'purewikideletion-blankedtext' => '[[$1]] е испразнета.
Видете $2 за евиденција на скорешни празнења.',
	'purewikideletion-population-done' => 'Завршив со исполнувањето на табелата blanked_page.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Исополни]] ја тебалата со испразнети страници',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'purewikideletion-blanknologin' => 'Belum log masuk',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'purewikideletion' => 'Ren wikisletting',
	'randomexcludeblank' => 'Tilfeldig side (ekskludert tomme)',
	'purewikideletion-desc' => 'Gjør blant annet at lenker til tomme sider blir røde',
	'purewikideletion-pref-watchblank' => 'Legg til sider jeg tømmer i overvåkningslisten min',
	'purewikideletion-blanked' => "En tidligere versjon av denne siden ble tømt av [[User:$1|$1]] ([[User talk:$1|diskusjon]]) ([[Special:Contributions/$1|bidrag]]) $5 $6.

Begrunnelsen for tømmingen var: ''<nowiki>$3</nowiki>''.

Du kan [{{fullurl:{{FULLPAGENAMEE}}|action=history}} vis sidens historikk], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} redigere den siste versjonen] eller starte på nytt i boksen nedenfor.",
	'blank-log' => 'tom',
	'blank-log-name' => 'Tømmingslogg',
	'blank-log-header' => 'Nedenfor er en liste over sidetømminger og gjenopprettinger.',
	'blank-log-entry-blank' => 'tømte $1',
	'blank-log-entry-unblank' => 'gjenopprettet $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|tømmingslogg]]',
	'purewikideletion-blanknologin' => 'Ikke innlogget',
	'purewikideletion-blanknologintext' => 'Du må være registrert bruker og [[Special:UserLogin|innlogget]] for å tømme en side.',
	'purewikideletion-unblanknologintext' => 'Du må være en registrert bruker og [[Special:UserLogin|innlogget]] for å gjenopprette en side.',
	'purewikideletion-blankedtext' => '[[$1]] har blitt tømt.
Se $2 for en oversikt over de nyeste tømmingene.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'purewikideletion' => 'Pure wikiverwijdering',
	'randomexcludeblank' => "Willekeurige pagina (lege pagina's uitgezonderd)",
	'populateblankedpagestable' => "Tabel met lege pagina's vullen",
	'purewikideletion-desc' => "Zorgt er onder anderen voor dat met rode verwijzingen naar lege pagina's wordt verwezen",
	'purewikideletion-pref-watchblank' => 'Pagina’s die ik leegmaak automatisch volgen',
	'purewikideletion-pref-watchunblank' => 'Pagina’s die ik vul automatisch volgen',
	'purewikideletion-blanked' => "Een eerdere versie van deze pagina is leeggemaakt door [[User:$1|$1]] ([[User talk:$1|overleg]]) ([[Special:Contributions/$1|bijdragen]]) op $5 om $6.

De opgegeven reden bij leegmaken is: ''<nowiki>$3</nowiki>''.

U kunt de [{{fullurl:{{FULLPAGENAMEE}}|action=history}} geschiedenis van de pagina bekijken], de [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} laatste versie bewerken] of de pagina hieronder vullen.",
	'blank-log' => 'leeggemaakt',
	'blank-log-name' => "Logboek lege pagina's",
	'blank-log-header' => "Hieronder staat een lijst met leeggemaakte en gevulde pagina's.",
	'blank-log-entry-blank' => 'heeft $1 leeggemaakt',
	'blank-log-entry-unblank' => 'heeft $1 gevuld',
	'blank-log-link' => "[[{{#Special:Log}}/blank|Logboek lege pagina's]]",
	'purewikideletion-blanknologin' => 'Niet aangemeld',
	'purewikideletion-blanknologintext' => 'U moet geregistreerd zijn en [[Special:UserLogin|aangemeld]] zijn om een pagina leeg te kunnen maken.',
	'purewikideletion-unblanknologintext' => 'U moet geregistreerd zijn en [[Special:UserLogin|aangemeld]] zijn om een pagina te kunnen vullen.',
	'purewikideletion-blankedtext' => "[[$1]] is leeggemaakt.
Zie $2 voor een overzicht van recent leeggemaakte pagina's.",
	'purewikideletion-population-done' => 'De tabel blanked_page is gevuld.',
	'right-purewikideletion' => "[[Special:PopulateBlankedPagesTable|De tabel met leggemaakte pagina's vullen]]",
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'purewikideletion' => 'Dokładne czyszczenie wiki',
	'randomexcludeblank' => 'Losowa strona (bez pustych)',
	'populateblankedpagestable' => 'Wypełnij spis pustych stron',
	'purewikideletion-desc' => 'Między innymi powoduje oznaczenie czerwonym kolorem linków do pustych stron',
	'purewikideletion-pref-watchblank' => 'Dodawaj strony, których treść usunąłem do mojej listy obserwowanych',
	'purewikideletion-pref-watchunblank' => 'Dodawaj strony, których treść odtworzyłem do mojej listy obserwowanych',
	'purewikideletion-blanked' => "Poprzednia wersja tej strony została wyczyszczona przez [[User:$1|$1]] ([[User talk:$1|dyskusja]]) ([[Special:Contributions/$1|wkład]]) dnia $5 o $6.

Uzasadnieniem czyszczenia było – ''<nowiki>$3</nowiki>''.

Możesz [{{fullurl:{{FULLPAGENAMEE}}|action=history}} sprawdzić historię edycji strony], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} edytować ostatnią wersję] lub napisać treść strony od nowa w pustym polu poniżej.",
	'blank-log' => 'czyszczenie',
	'blank-log-name' => 'Historia czyszczenia',
	'blank-log-header' => 'Poniżej znajduje się spis czyszczeń i anulowania czyszczeń stron.',
	'blank-log-entry-blank' => 'wyczyścił „$1”',
	'blank-log-entry-unblank' => 'anulował czyszczenie „$1”',
	'blank-log-link' => '[[{{#Special:Log}}/blank|rejestr czyszczenia]]',
	'purewikideletion-blanknologin' => 'Nie jesteś zalogowany',
	'purewikideletion-blanknologintext' => 'Czyszczenie stron jest możliwe dopiero po zarejestrowaniu się i [[Special:UserLogin|zalogowaniu]].',
	'purewikideletion-unblanknologintext' => 'Anulowanie czyszczenia stron jest możliwe dopiero po zarejestrowaniu się i [[Special:UserLogin|zalogowaniu]].',
	'purewikideletion-blankedtext' => '[[$1]] została wyczyszczona.
Zobacz $2 aby przejrzeć ostatnie czyszczenia.',
	'purewikideletion-population-done' => 'Wypełniono tabelę blanked_page.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Wypełnianie]] tabeli czyszczonych stron',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'purewikideletion' => 'Pura scancelassion wiki',
	'randomexcludeblank' => 'Pàgina a cas (ma pa veuida)',
	'populateblankedpagestable' => 'Ampinì la tàula dle pàgine vujdà',
	'purewikideletion-desc' => "Tra j'àutre còse, le pàgine dësvuidà a son colegà an ross",
	'purewikideletion-pref-watchblank' => "Gionta le pàgine che i dësveuido a lòn ch'i ten-o sot euj",
	'purewikideletion-pref-watchunblank' => "Gionté le pàgine andoa i gavo ël dësvujdament a lòn ch'i ten-o sot-euj",
	'purewikideletion-blanked' => "Na version veja dë sta pàgina-sì a l'é stàita dësvuidà da [[User:$1|$1]] ([[User talk:$1|talk]]) ([[Special:Contributions/$1|contribs]]) ël $5 a $6.

La rason dàita për dësvuidé a l'era: ''<nowiki>$3</nowiki>''.

A peul [{{fullurl:{{FULLPAGENAMEE}}|action=history}} vardé la stòria dla pàgina], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} modifiché l'ùltima version], o anserì na pàgina neuva ant lë spassi bianch sì-sota.",
	'blank-log' => 'dësveuida',
	'blank-log-name' => 'Registr dij dësvuidament',
	'blank-log-header' => 'Sota a-i é na lista ëd pàgine dësvuidà e torna ampinìe.',
	'blank-log-entry-blank' => 'dësvuidà $1',
	'blank-log-entry-unblank' => "a l'ha gavà ël dësvujdament $1",
	'blank-log-link' => '[[{{#Special:Log}}/blank|registr dij dësvuidament]]',
	'purewikideletion-blanknologin' => 'Nen rintrà ant ël sistema',
	'purewikideletion-blanknologintext' => "A dev esse n'utent registrà e [[Special:UserLogin|intrà ant ël sistema]] për dësvuidé na pàgina.",
	'purewikideletion-unblanknologintext' => "A dev esse n'utent registrà e [[Special:UserLogin|intrà ant ël sistema]] për gavé ël dësvujdament ëd na pàgina.",
	'purewikideletion-blankedtext' => "[[$1]] a l'é stàita dësvuidà.
Vardé $2 për na lista dij dësvuidament recent.",
	'purewikideletion-population-done' => 'Ampiniment ëd la tàula blanked_page fàit.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Ampinì]] la tàula dle pàgine dësvuidà',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'blank-log' => 'تش',
	'blank-log-name' => 'تش يادښت',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'purewikideletion' => 'Eliminação pura',
	'randomexcludeblank' => 'Página aleatória (excluir vazias)',
	'populateblankedpagestable' => 'Preencher tabela de páginas esvaziadas',
	'purewikideletion-desc' => 'Entre outras coisas, causa que links para páginas esvaziadas apareçam a vermelho',
	'purewikideletion-pref-watchblank' => 'Adicionar as páginas que eu esvaziar às minhas páginas vigiadas',
	'purewikideletion-pref-watchunblank' => 'Adicionar as páginas cujo esvaziamento eu reverter, às minhas páginas vigiadas',
	'purewikideletion-blanked' => "Uma versão anterior desta página foi esvaziada por [[User:$1|$1]] ([[User talk:$1|discussão]]) ([[Special:Contributions/$1|contribs]]) em $5 às $6.

O motivo apresentado para o esvaziamento da página, foi: ''<nowiki>$3</nowiki>''.

Pode [{{fullurl:{{FULLPAGENAMEE}}|action=history}} ver o historial da página], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} editar a última versão], ou escrever a página nova no espaço em branco abaixo.",
	'blank-log' => 'esvaziada',
	'blank-log-name' => 'Registo de esvaziamento de páginas',
	'blank-log-header' => 'Encontra abaixo uma lista de esvaziamentos e reversões de esvaziamentos de páginas.',
	'blank-log-entry-blank' => 'esvaziou $1',
	'blank-log-entry-unblank' => 'reverteu esvaziamento de $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|registo de esvaziamento de páginas]]',
	'purewikideletion-blanknologin' => 'Não está autenticado',
	'purewikideletion-blanknologintext' => 'Tem de ser um utilizador registado e estar [[Special:UserLogin|autenticado]] para esvaziar uma página.',
	'purewikideletion-unblanknologintext' => 'Tem de ser um utilizador registado e estar [[Special:UserLogin|autenticado]] para reverter o esvaziamento de uma página.',
	'purewikideletion-blankedtext' => '[[$1]] foi esvaziada.
Consulte $2 para ver um registo dos esvaziamentos recentes de páginas.',
	'purewikideletion-population-done' => 'O preenchimento da tabela de páginas esvaziadas foi terminado.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Preencher]] a tabela de páginas esvaziadas',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'purewikideletion' => 'Eliminação pura',
	'randomexcludeblank' => 'Página aleatória (excluir páginas vazias)',
	'populateblankedpagestable' => 'Preencher tabela de páginas esvaziadas',
	'purewikideletion-desc' => 'Entre outras coisas, faz com que os links para páginas esvaziadas apareçam em vermelho',
	'purewikideletion-pref-watchblank' => 'Adicionar as páginas que eu esvaziar às minhas páginas vigiadas',
	'purewikideletion-pref-watchunblank' => 'Adicionar as páginas, que eu venha a reverter o esvaziamento, às minhas páginas vigiadas',
	'purewikideletion-blanked' => "Uma versão anterior desta página foi esvaziada por [[User:$1|$1]] ([[User talk:$1|discussão]]) ([[Special:Contributions/$1|contribs]]) em $5 às $6.

O motivo apresentado para o esvaziamento da página, foi: ''<nowiki>$3</nowiki>''.

Pode [{{fullurl:{{FULLPAGENAMEE}}|action=history}} ver o histórico da página], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} editar a última versão], ou escrever a página nova no espaço em branco abaixo.",
	'blank-log' => 'esvaziada',
	'blank-log-name' => 'Registro de esvaziamento de páginas',
	'blank-log-header' => 'Encontra-se abaixo uma lista de esvaziamentos e reversões de esvaziamentos de páginas.',
	'blank-log-entry-blank' => 'esvaziou $1',
	'blank-log-entry-unblank' => 'reverteu esvaziamento de $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|registro de esvaziamento de páginas]]',
	'purewikideletion-blanknologin' => 'Não está autenticado',
	'purewikideletion-blanknologintext' => 'Você deve ser um usuário registrado e estar [[Special:UserLogin|autenticado]] para esvaziar uma página.',
	'purewikideletion-unblanknologintext' => 'Você deve ser um usuário registrado e estar [[Special:UserLogin|autenticado]] para reverter o esvaziamento de uma página.',
	'purewikideletion-blankedtext' => '[[$1]] foi esvaziada.
Consulte $2 para ver um registro dos esvaziamentos recentes de páginas.',
	'purewikideletion-population-done' => 'O preenchimento da tabela de páginas esvaziadas foi feito.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Preencher]] a tabela de páginas esvaziadas',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'blank-log' => 'gol',
	'blank-log-name' => 'Jurnal gol',
	'purewikideletion-blanknologin' => 'Neautentificat',
);

/** Russian (Русский)
 * @author Grigol
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'purewikideletion' => '«Чистое» вики-удаление',
	'randomexcludeblank' => 'Случайная страница (кроме очищенных)',
	'populateblankedpagestable' => 'Заполнить таблицу очищенных страниц',
	'purewikideletion-desc' => 'Среди прочего, делает красными ссылки на пустые страницы',
	'purewikideletion-pref-watchblank' => 'Добавлять очищенные мной страницы в список наблюдения',
	'purewikideletion-pref-watchunblank' => 'Добавлять возвращённые после очистки мной страницы в список наблюдения',
	'purewikideletion-blanked' => "Предыдущая версия этой страницы была очищена участником [[User:$1|$1]] ([[User talk:$1|обсуждение]]) ([[Special:Contributions/$1|вклад]]) $5 $6.

Указанная причина очистки: ''<nowiki>$3</nowiki>''.

Вы можете [{{fullurl:{{FULLPAGENAMEE}}|action=history}} просмотреть историю страницы], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} исправить последнюю версию] или ввести текст новой страницы в расположенное ниже пустое поле.",
	'blank-log' => 'очистка',
	'blank-log-name' => 'Журнал очисток',
	'blank-log-header' => 'Ниже приведён список очищенных страниц и страниц, возвращённых после очистки.',
	'blank-log-entry-blank' => 'очищена $1',
	'blank-log-entry-unblank' => 'возвращена после очистки $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|журнал очисток]]',
	'purewikideletion-blanknologin' => 'Вы не представились системе',
	'purewikideletion-blanknologintext' => 'Вы должны [[Special:UserLogin|представиться системе]], чтобы иметь возможность очищать страницы.',
	'purewikideletion-unblanknologintext' => 'Вы должны [[Special:UserLogin|представиться системе]], чтобы иметь возможность возвращать страницы после очистки.',
	'purewikideletion-blankedtext' => 'Страница [[$1]] была очищена.
Список недавних очисток см. на $2.',
	'purewikideletion-population-done' => 'Закончено заполнение таблицы blanked_page.',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|заполнение]] таблицы очищенных страниц',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'purewikideletion-blanknologin' => 'Нисте пријављени',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'purewikideletion-blanknologin' => 'Niste prijavljeni',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'randomexcludeblank' => 'యాదృచ్చిక పుట (ఖాళీలను మినహాయించి)',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'purewikideletion' => 'Pagbura ng dalisay na wiki',
	'randomexcludeblank' => 'Alinmang pahina (huwag isali ang walang laman)',
	'populateblankedpagestable' => 'Damihan ang laman ng tabla ng mga pahinang inalisan ng laman',
	'purewikideletion-desc' => 'Kabilang sa ibang mga bagay, nagsasanhi na maging pulang kawing ang mga pahinang inalisan ng laman',
	'purewikideletion-pref-watchblank' => 'Idagdag ang mga pahinang inalisan ko ng laman sa aking tala ng mga binabantayan',
	'purewikideletion-pref-watchunblank' => 'Idagdag ang mga pahinang hindi ko tinanggalan ng laman sa aking tala ng mga binabantayan',
	'purewikideletion-blanked' => "Isang dating bersyon ng pahinang ito ang inalisan ng laman ni [[User:$1|$1]] ([[User talk:$1|usapan]]) ([[Special:Contributions/$1|ambag]]) noong $5 ng $6.
        
Ang ibinigay na dahilan ng pagtanggal ng laman ay: ''<nowiki>$3</nowiki>''.

Maaari mong [{{fullurl:{{FULLPAGENAMEE}}|action=history}} tingnan ang kasaysayan ng artikulo], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} baguhin ang huling bersyon], o magmakiniliya ng bagong pahina sa puting puwang sa ibaba.",
	'blank-log' => 'Walang laman',
	'blank-log-name' => 'Talaan ng pag-alis ng laman',
	'blank-log-header' => 'Nasa ibaba ang isang talaan ng mga pag-aalis at paglalagay ng laman sa pahina.',
	'blank-log-entry-blank' => 'inalisan ng laman ang $1',
	'blank-log-entry-unblank' => 'hindi inalis ang laman ng $1',
	'blank-log-link' => '[[{{#Special:Log}}/blank|talaan ng pagtanggal ng laman]]',
	'purewikideletion-blanknologin' => 'Hindi nakalagda',
	'purewikideletion-blanknologintext' => 'Dapat na isa kang nagpatalang tagagamit at [[Special:UserLogin|nakalagdang papasok]] upang makapag-alis ng laman ng isang pahina.',
	'purewikideletion-unblanknologintext' => 'Dapat na isa kang nagpatalang tagagamit at [[Special:UserLogin|nakalagdang papasok]] upang makapaglagay ng laman sa isang pahina.',
	'purewikideletion-blankedtext' => 'Inalis ang laman ng  [[$1]].
Tingnan ang $2 para sa isang tala ng kamakailang lamang na mga pagtanggal ng laman.',
	'purewikideletion-population-done' => 'Tapos na ang pagpapadami sa tabla ng pahinang_inalisan_ng_laman .',
	'right-purewikideletion' => '[[Special:PopulateBlankedPagesTable|Paramihin ang loob]] ng tabla ng mga pahinang inalisan ng laman',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 */
$messages['uk'] = array(
	'purewikideletion' => 'Чистове видалення в Вікі',
	'randomexcludeblank' => 'Випадкові сторінки (крім порожніх)',
	'populateblankedpagestable' => 'Заповнити таблицю очищенних сторінок',
	'purewikideletion-desc' => 'Помічає посилання на очищені сторінки червоним кольором',
	'purewikideletion-pref-watchblank' => 'Додати сторінки які я очищаю до мого списку спостереження',
	'purewikideletion-pref-watchunblank' => 'Додавати сторінки після очистки до мого списку спостереження',
	'purewikideletion-blanked' => "A former version of this page was blanked by [[User:$1|$1]] ([[User talk:$1|talk]]) ([[Special:Contributions/$1|contribs]]) on $5 at $6.

The reason given for blanking was: ''<nowiki>$3</nowiki>''.

You may [{{fullurl:{{FULLPAGENAMEE}}|action=history}} view the page's history], [{{fullurl:{{FULLPAGENAMEE}}|oldid=$4&action=edit}} edit the last version], or type new page into the white space below.",
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'blank-log' => '空白',
	'blank-log-name' => '空白日志',
	'purewikideletion-blanknologin' => '未登入',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'blank-log' => '空白',
	'blank-log-name' => '空白日誌',
	'purewikideletion-blanknologin' => '未登入',
);

