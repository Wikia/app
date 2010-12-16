<?php
/**
 * Internationalization file for DynamicPageList extension.
 *
 * @file
 * @ingroup Extensions
 * @author m:User:Dangerman <cyril.dangerville@gmail.com>
 * @version 1.0.5
 * @version 1.0.8
 * 			removed blank lines at the end of the file
 * @version 1.0.9
 * 			added message: ERR_OpenReferences
 */

class DPL_i18n {
	// FATAL

	const FATAL_WRONGNS						= 1;	// $0: 'namespace' or 'notnamespace'
													// $1: wrong parameter given by user
													// $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)

	const FATAL_WRONGLINKSTO				= 2;	// $0: linksto' (left as $0 just in case the parameter is renamed in the future)
													// $1: the wrong parameter given by user
												
	const FATAL_TOOMANYCATS					= 3;	// $0: max number of categories that can be included

	const FATAL_TOOFEWCATS					= 4;	// $0: min number of categories that have to be included

	const FATAL_NOSELECTION					= 5;

	const FATAL_CATDATEBUTNOINCLUDEDCATS	= 6;

	const FATAL_CATDATEBUTMORETHAN1CAT		= 7;

	const FATAL_MORETHAN1TYPEOFDATE			= 8;

	const FATAL_WRONGORDERMETHOD			= 9;	// $0: param=val that is possible only with $1 as last 'ordermethod' parameter
													// $1: last 'ordermethod' parameter required for $0

	const FATAL_DOMINANTSECTIONRANGE		= 10;	// $0: the number of arguments in includepage

	const FATAL_NOCLVIEW					= 11;	// $0: prefix_dpl_clview where 'prefix' is the prefix of your mediawiki table names
													// $1: SQL query to create the prefix_dpl_clview on your mediawiki DB

	const FATAL_OPENREFERENCES				= 12;

	// ERROR

	// WARN

	const WARN_UNKNOWNPARAM					= 13;	// $0: unknown parameter given by user
													// $1: list of DPL available parameters separated by ', '

	const WARN_WRONGPARAM					= 14;	// $3: list of valid param values separated by ' | '

	const WARN_WRONGPARAM_INT				= 15;	// $0: param name
													// $1: wrong param value given by user
													// $2: default param value used instead by program

	const WARN_NORESULTS					= 16;

	const WARN_CATOUTPUTBUTWRONGPARAMS		= 17;

	const WARN_HEADINGBUTSIMPLEORDERMETHOD	= 18;	// $0: 'headingmode' value given by user
													// $1: value used instead by program (which means no heading)

	const WARN_DEBUGPARAMNOTFIRST			= 19;	// $0: 'log' value

	const WARN_TRANSCLUSIONLOOP				= 20;	// $0: title of page that creates an infinite transclusion loop


	// INFO

	// DEBUG

	const DEBUG_QUERY						= 21;	// $0: SQL query executed to generate the dynamic page list

	// TRACE

													// Output formatting
													// $1: number of articles

	private static $messages = array();

	public static function getMessages() {
		/**
		 * To translate messages into your language, create a self::$messages['lang'] array where 'lang' is your language code and take self::$messages['en'] as a model. Replace values with appropriate translations.
		 */

		self::$messages['en'] = array(
			'intersection-desc'		  => 'Outputs a bulleted list of the most recent items residing in a category, or an intersection of several categories',
			'intersection_toomanycats'   => 'Error: Too many categories!',
			'intersection_toofewcats'	=> 'Error: Too few categories!',
			'intersection_noresults'	 => 'Error: No results!',
			'intersection_noincludecats' => 'Error: You need to include at least one category, or specify a namespace!',
			'dpl-desc' => 'A highly flexible report generator for MediaWikis',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "ERROR: Wrong '$0' parameter: '$1'! Help:  <code>$0= <i>empty string</i> (Main)$3</code>.",
			'dpl_log_' . self::FATAL_WRONGLINKSTO 				=> "ERROR: Wrong '$0' parameter: '$1'! Help:  <code>$0= <i>full pagename</i></code>.",
			'dpl_log_' . self::FATAL_TOOMANYCATS 				=> 'ERROR: Too many categories! Maximum: $0. Help: increase <code>ExtDynamicPageList::$maxCategoryCount</code> to specify more categories or set <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> for no limitation. (Set the variable in <code>LocalSettings.php</code>, after including <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS 				=> 'ERROR: Too few categories! Minimum: $0. Help: decrease <code>ExtDynamicPageList::$minCategoryCount</code> to specify fewer categories. (Set the variable preferably in <code>LocalSettings.php</code>, after including <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION 				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS 	=> "ERROR: You need to include at least one category if you want to use 'addfirstcategorydate=true' or 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT 	=> "ERROR: If you include more than one category, you cannot use 'addfirstcategorydate=true' or 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE 		=> 'ERROR: You cannot add more than one type of date at a time!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD 			=> "ERROR: You can use '$0' with 'ordermethod=[...,]$1' only!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE 		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "ERROR: Cannot perform logical operations on the Uncategorized pages (f.e. with the 'category' parameter) because the $0 view does not exist on the database! Help: have the database administrator execute this query: <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES 			=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM 				=> "WARNING: Unknown parameter '$0' is ignored. Help: available parameters: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM 					=> "WARNING: Wrong '$0' parameter: '$1'! Using default: '$2'. Help: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT 				=> "WARNING: Wrong '$0' parameter: '$1'! Using default: '$2' (no limit). Help: <code>$0= <i>empty string</i> (no limit) | n</code>, with <code>n</code> a positive integer.",
			'dpl_log_' . self::WARN_NORESULTS 					=> 'WARNING: No results.',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS 	=> "WARNING: Add* parameters ('adduser', 'addeditdate', etc.)' and 'includepage' have no effect with 'mode=category'. Only the page namespace/title can be viewed in this mode.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "WARNING: 'headingmode=$0' has no effect with 'ordermethod' on a single component. Using: '$1'. Help: you can use not-$1 'headingmode' values with 'ordermethod' on multiple components. The first component is used for headings. E.g. 'ordermethod=category,<i>comp</i>' (<i>comp</i> is another component) for category headings.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST 			=> "WARNING: 'debug=$0' is not in first position in the DPL element. The new debug settings are not applied before all previous parameters have been parsed and checked.",
			'dpl_log_' . self::WARN_TRANSCLUSIONLOOP			=> "WARNING: An infinite transclusion loop is created by page '$0'.",
			'dpl_log_' . self::DEBUG_QUERY						=> 'QUERY: <code>$0</code>',
			'dpl_articlecount' 									=> 'There {{PLURAL:$1|is one article|are $1 articles}} in this heading.',
			'dpl_description'									=> 'A flexible report generator for MediaWikis - manual and examples: see [http://semeb.com/dpldemo]',
		);

		/** Message documentation (Message documentation)
		 * @author Purodha
		 */
		self::$messages['qqq'] = array(
			'intersection-desc' => 'Short description of the Intersection extension, shown in [[Special:Version]]. Do not translate or change links.',
		);

		/** Afrikaans (Afrikaans)
		 * @author Naudefj
		 */
		self::$messages['af'] = array(
			'intersection_toomanycats' => 'Fout: Te veel kategorieë!',
			'intersection_toofewcats' => 'Fout: Te min kategorieë!',
			'intersection_noresults' => 'Fout: Geen resultate!',
		);

		/** Aragonese (Aragonés)
		 * @author Juanpabl
		 */
		self::$messages['an'] = array(
			'intersection-desc' => "Preduz una lista d'os elementos más rezients que bi ha en una categoría u a unión de barios categorías",
			'intersection_toomanycats' => 'Error: Masiadas categorías!',
			'intersection_toofewcats' => 'Error: numero insufizient de categorías!',
			'intersection_noresults' => 'Error: No bi ha garra resultau!',
			'intersection_noincludecats' => "Error: Ha d'encluyir á lo menos una categoría u endicar un espazio de nombres!",
		);

		/** Arabic (العربية)
		 * @author Meno25
		 */
		self::$messages['ar'] = array(
			'intersection-desc' => 'يخرج قائمة معلمة بأحدث المدخلات الساكنة في تصنيف، أو اتحاد عدة تصنيفات',
			'intersection_toomanycats' => 'خطأ: تصنيفات كثيرة جدا!',
			'intersection_toofewcats' => 'خطأ: تصنيفات قليلة جدا!',
			'intersection_noresults' => 'خطأ: لا نتائج!',
			'intersection_noincludecats' => 'خطأ: ينبغي أن تضمن تصنيفا واحدا على الأقل، أو تحدد نطاقا!',
		);

		/** Egyptian Spoken Arabic (مصرى)
		 * @author Meno25
		 * @author Ramsis II
		 */
		self::$messages['arz'] = array(
			'intersection-desc' => 'بيطلع لستة مترقمة لاحدث الحاجات الموجودة فى تصنيف,او اتحاد اكتر من تصنيف',
			'intersection_toomanycats' => 'غلط:تصانيف كتيرة خالص!',
			'intersection_toofewcats' => 'غلط:تصانيف قليلة خالص!',
			'intersection_noresults' => 'غلط:مافيش نتايج!',
			'intersection_noincludecats' => 'غلط: لازم تحط تصنيف واحد على الأقل، أو تحدد نطاق!',
		);

		/** Asturian (Asturianu)
		 * @author Esbardu
		 */
		self::$messages['ast'] = array(
			'intersection-desc' => 'Amuesa una llista de los elementos más recién que tenga una categoría o una xuntanza de varies categoríes',
			'intersection_toomanycats' => 'Error: ¡Demasiaes categoríes!',
			'intersection_toofewcats' => 'Error: ¡Demasiaes poques categoríes!',
			'intersection_noresults' => 'Error: ¡Nun hai resultaos!',
			'intersection_noincludecats' => 'Error: ¡Necesites amiestar a lo menos una categoría, o especificar un espaciu de nomes!',
		);

		/** Southern Balochi (بلوچی مکرانی)
		 * @author Mostafadaneshvar
		 */
		self::$messages['bcc'] = array(
			'intersection_toomanycats' => 'DynamicPageList: بازگین دسته جات!',
			'intersection_toofewcats' => 'DynamicPageList: باز کمین دسته جات!',
			'intersection_noresults' => 'DynamicPageList: هچ نتیجه ای',
			'intersection_noincludecats' => 'لیست صفحات دینامیکی: شما لازمنت حداقل یک دسته هور کنیت یا یک نام فضایی مشخص کنیت!',
		);

		/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
		 * @author EugeneZelenko
		 * @author Jim-by
		 */
		self::$messages['be-tarask'] = array(
			'intersection-desc' => "Выводзіць у маркіраваны сьпіс апошнія дабаўленьні да катэгорыі альбо аб'ядноўвае некалькі катэгорыяў",
			'intersection_toomanycats' => 'Памылка: Зашмат катэгорыяў!',
			'intersection_toofewcats' => 'Памылка: Занадта мала катэгорыяў!',
			'intersection_noresults' => 'Памылка: Няма вынікаў!',
			'intersection_noincludecats' => 'Памылка: Вам неабходна ўключыць хаця б адну катэгорыю альбо ўказаць прастору назваў!',
		);

		/** Bulgarian (Български)
		 * @author DCLXVI
		 * @author Spiritia
		 */
		self::$messages['bg'] = array(
			'intersection-desc' => 'Извежда списък на най-скорошните записи в дадена категория или сечение на няколко категории',
			'intersection_toomanycats' => 'Error: Твърде много категории!',
			'intersection_toofewcats' => 'Error: Твърде малко категории!',
			'intersection_noresults' => 'Error: Няма резултати!',
			'intersection_noincludecats' => 'Error: Необходимо е да се включи поне една категория или да се посочи именно пространство!',
		);

		/** Bengali (বাংলা)
		 * @author Bellayet
		 */
		self::$messages['bn'] = array(
			'intersection_toomanycats' => 'Error: অনেক বেশি বিষয়শ্রেণী!',
			'intersection_toofewcats' => 'Error: অনেক কম বিষয়শ্রেণী!',
			'intersection_noresults' => 'Error: ফলাফল নাই!',
			'intersection_noincludecats' => 'ত্রুটি:আপনার অন্তত একটি বিষয়শ্রেণী যুক্ত করতে, অথবা একটি নেমস্পেস দিতে হবে!',
		);

		/** Breton (Brezhoneg)
		 * @author Fulup
		 */
		self::$messages['br'] = array(
			'intersection_toomanycats' => 'Error: Re a rummadoù !',
			'intersection_toofewcats' => 'Error: Re nebeut a rummadoù !',
			'intersection_noresults' => "Error: Disoc'h ebet !",
		);

		/** Bosnian (Bosanski)
		 * @author CERminator
		 * @author Seha
		 */
		self::$messages['bs'] = array(
			'intersection-desc' => 'Izbacuje listu najčešćih tačaka koje se nalaze u kategoriji ili u sekciji nekoliko kategorija.',
			'intersection_toomanycats' => 'Greška: Previše kategorija!',
			'intersection_toofewcats' => 'Greška: Premalo kategorija!',
			'intersection_noresults' => 'Greška: Nema rezultata!',
			'intersection_noincludecats' => 'Greška: Potrebno je da uključite najmanje jednu kategoriju ili odredite imenski prostor!',
		);

		/** Catalan (Català)
		 * @author Paucabot
		 * @author SMP
		 */
		self::$messages['ca'] = array(
			'intersection-desc' => "Genera una llista d'elements recents en una categoria o en la intersecció de diverses.",
			'intersection_toomanycats' => 'Error: Massa categories!',
			'intersection_toofewcats' => 'Error: Massa poques categories!',
			'intersection_noresults' => 'Error: Cap resultat!',
			'intersection_noincludecats' => "Error: Heu d'incloure almenys una categoria o especificar un espai de noms!",
		);

		/** Czech (Česky)
		 * @author Li-sung
		 * @author Matěj Grabovský
		 */
		self::$messages['cs'] = array(
			'intersection-desc' => 'Vypíše seznam nejnovějších položek v kategorii nebo sjednotí několik kategorií',
			'intersection_toomanycats' => 'Error: Příliš mnoho kategorií!',
			'intersection_toofewcats' => 'Error: Málo kategorií!',
			'intersection_noresults' => 'Error: Žádné výsledky!',
			'intersection_noincludecats' => 'Error: Musíte zahrnout alespoň jednu kategorii nebo určit jmenný prostor!',
		);

		/** German (Deutsch)
		 * @author Gero Scholz
		 */
		self::$messages['de'] = array(
			'intersection-desc' => 'Ausgabe einer Liste der aktuellsten Einträge in einer Kategorie, oder der Schnittmenge mehrerer Kategorien',
			'intersection_toomanycats' => 'DynamicPageList: Zuviele Kategorien!',
			'intersection_toofewcats' => 'DynamicPageList: Zuwenige Kategorien!',
			'intersection_noresults' => 'DynamicPageList: Kein Ergebnis!',
			'intersection_noincludecats' => 'DynamicPageList: Es muss mindestens eine Kategorie eingebunden werden oder gebe einen Namensraum an!',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "Fehler: bei '$0' Parameter: '$1'! Hilfe:  <code>$0= <i>(leer)</i> (Hauptnamensraum)$3</code>.",
			'dpl_log_' . self::FATAL_WRONGLINKSTO 				=> "Fehler: bei '$0' Parameter: '$1'! Hilfe:  <code>$0= <i>vollständiger Seitenname</i></code>.",
			'dpl_log_' . self::FATAL_TOOMANYCATS 				=> 'Fehler: Zu viele Kategorien angegeben! Maximum: $0.',
			'dpl_log_' . self::FATAL_TOOFEWCATS 				=> 'Fehler: Zu wenige Kategorien angegeben! Minimum: $0.',
			'dpl_log_' . self::FATAL_NOSELECTION 				=> "Fehler: Keine Auswahlkriterien angegeben! Mindestens einer der folgenden Parameter ist erforderlich: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby oder die 'not'-Varianten davon.",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS 	=> "Fehler: Sie müssen mindestens eine Kategorie angeben, wenn Sie 'addfirstcategorydate=true' oder 'ordermethod=categoryadd' benutzen.",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT 	=> "Fehler: Wenn Sie mehr als eine Kategorie angeben, können Sie 'addfirstcategorydate=true' oder 'ordermethod=categoryadd' nicht benutzen.",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE 		=> 'Fehler: Es ist nur eine einzige Art der Datumsangabe möglich.',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD 			=> "Fehler: Sie können '$0' nur in Verbindung mit 'ordermethod=[...,]$1' benutzen.",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE 		=> "Fehler: Die Indexangabe bei 'dominantsection' muss zwischen 1 und  der Anzahl der Argumente von 'includepage' liegen ($0 in diesem Fall).",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "Fehler: Abfragen auf unkategorisierte Seiten sind nicht möglich, da die Datenbank nicht dafür eingerichtet wurde. Ein Administrator kann dies ändern.",
			'dpl_log_' . self::FATAL_OPENREFERENCES 			=> 'Fehler: Die Angabe von "openreferences" ist nicht vereinbar mit bestimmten anderen Optionen, die Sie angegegeben haben. Details dazu stehen im DPL-Manual.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM 				=> "Warnung: Der unbekannte Parameter '$0' wird ignoriert. Hilfe: Verfügbare Parameter: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM 					=> "Warnung: Parameter '$0': Der Wert '$1' ist unzulässig. Es wird der Defaultwert benutzt: '$2'. Hilfe: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT 				=> "Warnung: Parameter '$0': Der Wert '$1' ist unzulässig. Es wird der Defaultwert benutzt: '$2'. Help: <code>$0= <i>(leer)</i> (unbegrenzt) | n</code>, wobei <code>n</code> eine positive Ganzzahl sein muss.",
			'dpl_log_' . self::WARN_NORESULTS 					=> 'Warnung: Kein passender Eintrag gefunden!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS 	=> "Warnung: Add* Parameter ('adduser', 'addeditdate', etc.)' und 'includepage' haben keinen Effekt in Verbindung mit 'mode=category'. Es kann nur der Artikel und der Namensraum angezeigt werden.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD => "Warnung: 'headingmode=$0' hat keinen Effekt, wenn 'ordermethod' sich auf eine einzelne Komponente bezieht. Es wird '$1' verwendet. Hilfe: Sie können nicht not-$1 'headingmode' Werte in verbindung mit 'ordermethod' für mehrfache Komponenten verwenden. Die erste Konponente wird als Überschrift verwendet. Z.B. 'ordermethod=category,<i>comp</i>' (<i>comp</i> ist eine andere Komponente) für Kategorie-Überschriften.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST 			=> "Warnung: 'debug=$0' steht nicht an erster Stelle in der DPL-Anweisung. Die Einstellung wird erst wirksam, nachdem die vorausgehenden Parameter geprüft und verarbeitet sind.",
			'dpl_log_' . self::WARN_TRANSCLUSIONLOOP			=> "Warnung: Endlosschleife beim Inkludieren von Inhalten der Seite '$0'.",
			'dpl_log_' . self::DEBUG_QUERY						=> 'Datenbank-Abfrage: <code>$0</code>',
			'dpl_articlecount' 									=> 'Diese Gruppe enthält {{PLURAL:$1|einen|$1}} Artikel.'
		);

		/** Lower Sorbian (Dolnoserbski)
		 * @author Michawiki
		 */
		self::$messages['dsb'] = array(
			'intersection-desc' => 'Wudawa lisćina nejaktualnjejšych zapiskow w kategoriji abo zgromadneje młogosći někotarych kategorijow',
			'intersection_toomanycats' => 'Zmólka: Pśewjele kategorijow!',
			'intersection_toofewcats' => 'Zmólka: Pśemało kategorijow!',
			'intersection_noresults' => 'Zmólka: Žedne wuslědki!',
			'intersection_noincludecats' => 'Zmólka: Musyš nanejmjenjej jadnu kategoriju zapśěgnuś abo mjenjowy rum pódaś!',
		);

		/** Greek (Ελληνικά)
		 * @author Dead3y3
		 */
		self::$messages['el'] = array(
			'intersection-desc' => 'Έχει ως έξοδο μια μη αριθμημένη λίστα των πιο πρόσφατων στοιχείων σε μια κατηγορία, ή μια τομή μερικών κατηγοριών',
			'intersection_toomanycats' => 'Σφάλμα: Πάρα πολλές κατηγορίες!',
			'intersection_toofewcats' => 'Σφάλμα: Πολύ λίγες κατηγορίες!',
			'intersection_noresults' => 'Σφάλμα: Δεν υπάρχουν αποτελέσματα!',
			'intersection_noincludecats' => 'Σφάλμα: Πρέπει να περιλάβετε τουλάχιστον μία κατηγορία, ή να ορίσετε μια περιοχή ονομάτων!',
		);

		/** Esperanto (Esperanto)
		 * @author Yekrats
		 */
		self::$messages['eo'] = array(
			'intersection-desc' => 'Eligas bulpunktitan liston de la plej lastaj kategorianoj, aŭ unuigo de pluraj kategorioj',
			'intersection_toomanycats' => 'Eraro: Tro da kategorioj!',
			'intersection_toofewcats' => 'Error: Tro malmultaj da kategorioj!',
			'intersection_noresults' => 'Error: Neniom da rezultoj!',
			'intersection_noincludecats' => 'Error: Vi devas inkluzivi almenaŭ unu kategorion, aŭ specifigu nomspacon!',
		);

		/** Spanish (Español)
		 * @author Aleator
		 * @author Remember the dot
		 * @author Sanbec
		 */
		self::$messages['es'] = array(
			'intersection-desc' => 'Devuelve una lista de los elementos más recientes que están en una categoría o en una intersección de varias categorías',
			'intersection_toomanycats' => '¡Error: Demasiadas categorías!',
			'intersection_toofewcats' => 'Error: ¡Muy pocas categorías!',
			'intersection_noresults' => 'Error: ¡Sin resultados!',
			'intersection_noincludecats' => 'Error: ¡Necesita incluir al menos una categoría, o especificar un espacio de nombres!',
		);

		/** Basque (Euskara)
		 * @author An13sa
		 */
		self::$messages['eu'] = array(
			'intersection_toomanycats' => 'Errorea: Kategoria gehiegi!',
			'intersection_toofewcats' => 'Errorea: Kategoria gutxiegi!',
			'intersection_noresults' => 'Errorea: Emaitzarik ez!',
			'intersection_noincludecats' => 'Errorea: Gutxienez kategoria bat gehitu edo izen bat zehaztu behar duzu!',
		);

		/** Persian (فارسی)
		 * @author Huji
		 */
		self::$messages['fa'] = array(
			'intersection-desc' => 'فهرست گلوله‌ای از صفحه‌هایی به نمایش در می‌آورد که به تازگی در یک یا چند رده وارد شده‌اند',
			'intersection_toomanycats' => 'DynamicPageList: تعداد رده‌ها زیاد است!',
			'intersection_toofewcats' => 'DynamicPageList: تعداد رده‌ها کم است!',
			'intersection_noresults' => 'DynamicPageList: نتیجه‌ای وجود ندارد!',
			'intersection_noincludecats' => 'DynamicPageList: شما حداقل باید یک رده را وارد کنید، یا یک فضای نام را مشخص کنید!',
		);

		/** Finnish (Suomi)
		 * @author Nike
		 */
		self::$messages['fi'] = array(
			'intersection-desc' => 'Tulostaa listan luokassa tai useamman luokan yhdisteessä olevista sivuista.',
			'intersection_toomanycats' => 'Error: Liian monta luokkaa.',
			'intersection_toofewcats' => 'Error: Liian vähän luokkia.',
			'intersection_noresults' => 'Error: Ei tuloksia.',
			'intersection_noincludecats' => 'Error: Lisää vähintään yksi luokka tai määritä nimiavaruus.',
		);

		/** French (Français)
		 * @author Grondin
		 * @author Urhixidur
		 * @author Verdy p
		 */
		self::$messages['fr'] = array(
			'intersection-desc' => 'Affiche une liste, à puces, des articles les plus récents dans une catégorie, ou à partir d’une combinaison de plusieurs catégories.',
			'intersection_toomanycats' => 'DynamicPageList : trop de catégories !',
			'intersection_toofewcats' => 'DynamicPageList : pas assez de catégories !',
			'intersection_noresults' => 'DynamicPageList : aucun résultat !',
			'intersection_noincludecats' => 'Error : vous devez inclure au moins une catégorie, ou préciser un nom d’espace !',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "ERREUR : Mauvais paramètre '$0' : '$1'! Aide :  <code>$0= <i>chaîne vide</i> (Principal)$3</code>. (Les équivalents avec des mots magiques sont aussi autorisés.)",
			'dpl_log_' . self::FATAL_WRONGLINKSTO				=> "ERREUR : Mauvais paramètre '$0' : '$1'! Aide :  <code>$0= <i>Nom complet de la page</i></code>. (Les mots magiques sont autorisés.)",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'ERREUR : Trop de catégories ! Maximum : $0. Aide : accroître <code>ExtDynamicPageList::$maxCategoryCount</code> pour autoriser plus de catégories ou régler <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> pour aucune limite. (À régler dans <code>LocalSettings.php</code>, après avoir inclus <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'ERREUR : Pas assez de catégories ! Minimum : $0. Aide : décroître <code>ExtDynamicPageList::$minCategoryCount</code> pour autoriser moins de catégories. (À régler dans <code>LocalSettings.php</code> de préférence, après avoir inclus <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "ERREUR : Vous devez inclure au moins une catégorie si vous voulez utiliser 'addfirstcategorydate=true' ou 'ordermethod=categoryadd' !",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "ERREUR : Si vous incluez plus d’une catégorie, vous ne pouvez pas utiliser 'addfirstcategorydate=true' ou 'ordermethod=categoryadd' !",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'ERREUR : Vous ne pouvez pas utiliser plus d’un type de date à la fois !',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "ERREUR : Vous ne pouvez utiliser '$0' qu’avec 'ordermethod=[...,]$1' !",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "ERREUR : Ne peut pas effectuer d’opérations logiques sur les pages sans catégories (avec la paramètre 'category') car la vue $0 n’existe pas dans la base de données ! Aide : demander à un administrateur de la base de données d'effectuer : <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "AVERTISSEMENT : Le paramètre inconnu '$0' est ignoré. Aide : paramètres disponibles : <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "AVERTISSEMENT : Mauvais paramètre '$0' : '$1'! Utilisation de la valeur par défaut : '$2'. Aide : <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "AVERTISSEMENT : Mauvais paramètre '$0' : '$1'! Utilisattion de la valeur par défaut : '$2' (aucune limite). Aide : <code>$0= <i>chaîne vide</i> (aucune limite) | n</code>, avec <code>n</code> un entier positif.",
			'dpl_log_' . self::WARN_NORESULTS					=> 'AVERTISSEMENT : Aucun résultat !',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "AVERTISSEMENT : Les paramètres Add* ('adduser', 'addeditdate', etc.)' et 'includepage' n’ont aucun effet avec 'mode=category'. Seuls l’espace de nom et le titre de la page peuvent être vus dans ce mode..",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "AVERTISSEMENT : 'headingmode=$0' n'a aucun effet avec 'ordermethod' sur une simple composante. Utiliser : '$1'. Aide : vous pouvez utiliser not-$1  sur les valeurs de 'headingmode' avec 'ordermethod' sur plusieurs composantes.  La première composante est utilisée pour les en-têtes. Exemple : 'ordermethod=category,<i>comp</i>' (<i>comp</i> est une autre composante) pour les en-têtes de catégorie.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "AVERTISSEMENT : 'debug=$0' n’est pas en première position dans l’élément DPL. Les nouveaux réglages de débogage ne seront appliqués qu’après que les paramètres précédents aient été vérifiés.",
			'dpl_log_' . self::WARN_TRANSCLUSIONLOOP			=> "AVERTISSEMENT : Une boucle d’inclusion infinie est créée par la page '$0'.",
			'dpl_log_' . self::DEBUG_QUERY						=> 'REQUÊTE : <code>$0</code>',
			'dpl_articlecount'									=> 'Il y a {{PLURAL:$1|un article|$1 articles}} dans cette section.'
		);

		/** Franco-Provençal (Arpetan)
		 * @author ChrisPtDe
		 */
		self::$messages['frp'] = array(
			'intersection-desc' => 'Afiche una lista de puges des articllos los ples novéls dens una catègorie, ou ben dês una combinèson de plusiors catègories.',
			'intersection_toomanycats' => 'Error : trop de catègories !',
			'intersection_toofewcats' => 'Error : pas prod de catègories !',
			'intersection_noresults' => 'Error : nion rèsultat !',
			'intersection_noincludecats' => 'Error : vos avéd fôta d’encllure u muens yona catègorie, ou ben de spècefiar un èspâço de nom !',
		);

		/** Galician (Galego)
		 * @author Toliño
		 * @author Xosé
		 */
		self::$messages['gl'] = array(
			'intersection-desc' => 'Devolve unha lista punteada dos elementos máis recentes que están nunha categoría ou nunha unión de varias categorías',
			'intersection_toomanycats' => 'Erro: demasiadas categorías!',
			'intersection_toofewcats' => 'Erro: moi poucas categorías!',
			'intersection_noresults' => 'Erro: ningún resultado!',
			'intersection_noincludecats' => 'Erro: ten que incluír unha categoría polo menos ou especificar un espazo de nomes!',
		);

		/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
		 * @author Omnipaedista
		 */
		self::$messages['grc'] = array(
			'intersection_noresults' => 'Σφάλμα: οὐδὲν ἀποτέλεσμα',
			'intersection_noincludecats' => 'Σφάλμα: Ἔξεστί σοι περιλαμβάνειν μίαν τοὐλάχιστον κατηγορίαν, ἢ καθορίζειν ὀνοματεῖον τι!',
		);

		/** Swiss German (Alemannisch)
		 * @author Als-Holder
		 */
		self::$messages['gsw'] = array(
			'intersection-desc' => 'Usgabe vun ere Lischt vu dr aktuällschte Yyträg in ere Kategorii, oder vu dr Schnittmängi vu mehrere Kategorie',
			'intersection_toomanycats' => 'Fähler: Zvyyl Kategorie!',
			'intersection_toofewcats' => 'Fähler: Zwenig Kategorie!',
			'intersection_noresults' => 'Fähler: Kei Ergebnis!',
			'intersection_noincludecats' => 'Fähler: S muess zmindescht ei Kategorii yybunde wäre oder gib e Namensruum aa!',
		);

		/** Hebrew (עברית)
		 * @author Rotem Liss
		 */
		self::$messages['he'] = array(
			'intersection-desc' => 'רשימה עם תבליטים של הפריטים האחרונים המצויים בקטגוריה, או במספר קטגוריות',
			'intersection_toomanycats' => 'DynamicPageList: קטגוריות רבות מדי!',
			'intersection_toofewcats' => 'DynamicPageList: קטגוריות מעטות מדי!',
			'intersection_noresults' => 'DynamicPageList: אין תוצאות!',
			'intersection_noincludecats' => 'DynamicPageList: עליכם לכלול לפחות קטגוריה אחת, או לציין מרחב שם!',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "שגיאה: פרמטר '$0' שגוי: '$1'! עזרה: <code>$0= <i>מחרוזת ריקה</i> (ראשי)$3</code>. (ניתן להשתמש גם בשווי ערך באמצעות מילות קסם.)",
			'dpl_log_' . self::FATAL_WRONGLINKSTO				=> "שגיאה: פרמטר '$0' שגוי: '$1'! עזרה: <code>$0= <i>שם הדף המלא</i></code>. (ניתן להשתמש במילות קסם.)",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'שגיאה: קטגוריות רבות מדי! מקסימום: $0. עזרה: העלו את <code>ExtDynamicPageList::$maxCategoryCount</code> כדי לציין עוד קטגוריות או הגדירו <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> כדי לבטל את ההגבלה. (הגידרו את המשתנה בקובץ <code>LocalSettings.php</code>, לאחר הכללת <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'שגיאה: קטגוריות מעטות מדי! מינימום: $0. עזרה: הורידו את <code>ExtDynamicPageList::$minCategoryCount</code> כדי לציין פחות קטגוריות. (הגידרו את המשתנה בקובץ <code>LocalSettings.php</code>, לאחר הכללת <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "שגיאה: עליכם להכליל לפחות קטגוריה אחת אם ברצונכם להשתמש ב־'addfirstcategorydate=true' או ב־'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "שגיאה: אם אתם מכלילים יותר מקטגוריה אחת, אינכם יכולים להשתמש ב־'addfirstcategorydate=true' או ב־'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'שגיאה: אינכם יכולים להוסיף יותר מסוג אחד של תאריך בו זמנית!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "?????: ????????? ?????? ??'$0' ?? 'ordermethod=[...,]$1' ????!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "שגיאה: לא ניתן לבצע פעולות לוגיות על דפים ללא קטגוריות (למשל, עם הפרמטר 'קטגוריה') כיוון שתצוגת $0 אינה קיימת במסד הנתונים! עזרה: מנהל מסד הנתונים צריך להריץ את השאילתה: <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "אזהרה: בוצעה התעלמות מהפרמטר הלא ידוע '$0'. עזרה: פרמטרים זמינים: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "אזהרה: פרמטר '$0' שגוי: '$1'! משתמש בברירת המחדל: '$2'. עזרה: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "אזהרה: פרמטר '$0' שגוי: '$1'! משתמש בברירת המחדל: '$2' (ללא הגבלה). עזרה: <code>$0= <i>מחרוזת ריקה</i> (ללא הגבלה) | n</code>, עם <code>n</code> כמספר שלם וחיובי.",
			'dpl_log_' . self::WARN_NORESULTS					=> '?????: ??? ??????!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "אזהרה: להוספת* הפרמטרים ('adduser',‏ 'addeditdate' וכדומה) וכן ל־'includepage' אין השפעה עם 'mode=category'. ניתן לצפות רק במרחב השם או בכותרת הדף במצב זה.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "אזהרה: ל־'headingmode=$0' אין השפעה עם 'ordermethod' על פריט יחיד. משתמש ב: '$1'. עזרה: באפשרותכם להשתמש בערכים של 'headingmode' שאינם $1 עם 'ordermethod' על פריטים מרובים. משתמשים בפריט הראשון לכותרת. למשל, 'ordermethod=category,<i>comp</i>' (<i>comp</i> הוא פריט אחר) לכותרות הקטגוריה.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "אזהרה: 'debug=$0w הוא לא במקום הראשון ברכיב ה־DPL. הגדרות ניפוי השגיאות החדשות לא יחולו לפני שכל הפרמטרים הקודמים ינותחו וייבדקו.",
			'dpl_log_' . self::WARN_TRANSCLUSIONLOOP			=> "אזהרה: לולאת הכללה אינסופית נוצרה בדף '$0'.",
			'dpl_log_' . self::DEBUG_QUERY						=> 'שאילתה: <code>$0</code>',
			'dpl_articlecount' 									=> '{{PLURAL:$1|ישנם $1 דפים|ישנו דף אחד}} תחת כותרת זו.'
		);

		/** Hindi (हिन्दी)
		 * @author Kaustubh
		 */
		self::$messages['hi'] = array(
			'intersection-desc' => 'एक श्रेणी या श्रेणीसमूहमें उपलब्ध नवीनतम लेख दर्शायें।',
			'intersection_toomanycats' => 'Error: बहुत ज्यादा श्रेणीयां!',
			'intersection_toofewcats' => 'Error: बहुत कम श्रेणीयां!',
			'intersection_noresults' => 'Error: रिज़ल्ट नहीं!',
			'intersection_noincludecats' => 'Error: कमसे कम एक श्रेणी या नामस्थान देना अनिवार्य हैं!',
		);

		/** Croatian (Hrvatski)
		 * @author Dalibor Bosits
		 * @author Dnik
		 */
		self::$messages['hr'] = array(
			'intersection-desc' => 'Omogućava popis najnovijih stranica ili datoteka iz kategorije, ili presjeka nekoliko kategorija',
			'intersection_toomanycats' => 'Error: Previše kategorija!',
			'intersection_toofewcats' => 'Error: Premalo kategorija!',
			'intersection_noresults' => 'Error: Nema rezultata!',
			'intersection_noincludecats' => 'Error: Morate uključiti bar jednu kategoriju, ili odabrati imenski prostor!',
		);

		/** Upper Sorbian (Hornjoserbsce)
		 * @author Michawiki
		 */
		self::$messages['hsb'] = array(
			'intersection-desc' => 'Wudaće lisćiny najaktualnišich zapiskow w jednej kategoriji abo w skupinje kategorijow',
			'intersection_toomanycats' => 'Error: Přewjele kategorijow!',
			'intersection_toofewcats' => 'Error: Přemało kategorijow!',
			'intersection_noresults' => 'Error: Žane wuslědki!',
			'intersection_noincludecats' => 'Error: Dyrbiš znajmjeńša kednu kategoriju zapřijeć abo mjenowy rum podać!',
		);

		/** Hungarian (Magyar)
		 * @author Dani
		 * @author Gondnok
		 * @author KossuthRad
		 */
		self::$messages['hu'] = array(
			'intersection-desc' => 'Megjeleníti egy adott kategóriában, vagy kategóriák uniójában lévő legújabb szócikkek listáját',
			'intersection_toomanycats' => 'Hiba: Túl sok kategória!',
			'intersection_toofewcats' => 'Hiba: Túl kevés kategória!',
			'intersection_noresults' => 'Hiba: Nincs eredmény!',
			'intersection_noincludecats' => 'Hiba: Legalább egy listázandó kategóriát meg kell adnod, vagy pedig egy névteret!',
		);

		/** Interlingua (Interlingua)
		 * @author McDutchie
		 */
		self::$messages['ia'] = array(
			'intersection-desc' => 'Face un lista a punctos del elementos le plus recente in un categoria, o un union de plure categorias',
			'intersection_toomanycats' => 'Error: Troppo de categorias!',
			'intersection_toofewcats' => 'Error: Non bastante categorias!',
			'intersection_noresults' => 'Error: Nulle resultatos!',
			'intersection_noincludecats' => 'Error: Tu debe includer al minus un categoria, o specificar un spatio de nomines!',
		);

		/** Indonesian (Bahasa Indonesia)
		 * @author IvanLanin
		 */
		self::$messages['id'] = array(
			'intersection-desc' => 'Menghasilkan suatu daftar item terbaru pada suatu kategori atau gabungan beberapa kategori',
			'intersection_toomanycats' => 'DynamicPageList: Terlalu banyak kategori!',
			'intersection_toofewcats' => 'DynamicPageList: Terlalu sedikit kategori!',
			'intersection_noresults' => 'DynamicPageList: Tak ada hasil yang sesuai!',
			'intersection_noincludecats' => 'DynamicPageList: Anda perlu mencantumkan paling tidak satu kategori, atau menyebutkan satu ruang nama!',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "KESALAHAN: Parameter '$0' salah: '$1'! Bantuan: <code>$0= <i>string kosong</i> (Utama)$3</code>. (Ekivalen kata kunci juga diizinkan.)",
			'dpl_log_' . self::FATAL_WRONGLINKSTO				=> "KESALAHAN: Parameter '$0' salah: '$1'! Bantuan:  <code>$0= <i>nama lengkap halaman</i></code>. (Kata kunci diizinkan.)",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'KESALAHAN: Kategori terlalu banyak! Maksimum: $0. Bantuan: perbesar <code>ExtDynamicPageList::$maxCategoryCount</code> untuk memberikan lebih banyak kategori atau atur  <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> untuk menghapus batasan. (Atur variabel tersebut di <code>LocalSettings.php</code>, setelah mencantumkan <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'KESALAHAN: Kategori terlalu sedikit! Minimum: $0. Bantuan: kurangi <code>ExtDynamicPageList::$minCategoryCount</code> untuk mengurangi kategori. (Atur variabel tersebut di <code>LocalSettings.php</code>, setelah mencantumkan <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "KESALAHAN: Anda harus memberikan paling tidak satu kategori jika menggunakan 'addfirstcategorydate=true' atau 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "KESALAHAN: Jika Anda memberikan lebih dari satu kategori, Anda tidak dapat menggunakan 'addfirstcategorydate=true' atau 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'KESALAHAN: Anda tidak dapat memberikan lebih dari satu jenis tanggal dalam satu waktu!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "KESALAHAN: Anda dapat menggunakan '$0' hanya dengan 'ordermethod=[...,]$1'!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "KESALAHAN: Tidak dapat melakukan operasi logika pada halaman yang tak terkategori (misalnya dengan parameter 'kategori') karena view $0 tidak ada di basis data! Bantuan: mintalah admin basis data untuk menjalankan kueri berikut: <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "KESALAHAN: Paramater yang tak dikenal '$0' diabaikan. Bantuan: parameter yang tersedia: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "KESALAHAN: Parameter '$0' salah: '$1'! Menggunakan konfigurasi baku: '$2'. Bantuan: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "KESALAHAN: Parameter '$0' salah: '$1'! Menggunakan konfigurasi baku: '$2' (tanpa limitasi). Bantuan: <code>$0= <i>string kosong</i> (tanpa limitasi) | n</code>, dengan <code>n</code> suatu bilangan positif.",
			'dpl_log_' . self::WARN_NORESULTS					=> 'KESALAHAN: Hasil tak ditemukan!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "KESALAHAN: Menambahkan * parameter ('adduser', 'addeditdate', dll.)' dan 'includepage' tidak berpengaruh pada 'mode=category'. Hanya ruang nama/judul halaman yang dapat ditampilkan dengan mode ini.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "KESALAHAN: 'headingmode=$0' tidak berpengaruh dengan 'ordermethod' pada suatu komponen tunggal. Menggunakan: '$1'. Bantuan: Anda dapat menggunakan nilai not-$1 'headingmode' dengan 'ordermethod' terhadap beberapa komponen. Komponen pertama digunakan sebagai judul. Misalnya 'ordermethod=category,<i>comp</i>' (<i>comp</i> adalah komponen lain) untuk judul kategori.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "KESALAHAN: 'debug=$0' tidak pada posisi pertama pada elemen DPL. Aturan debug tidak diterapkan sebelum semua variabel sebelumnya telah diparsing dan dicek.",
			'dpl_log_' . self::WARN_TRANSCLUSIONLOOP			=> "KESALAHAN: Suatu lingkaran transklusi tak hingga ditimbulkan oleh halaman '$0'.",
			'dpl_log_' . self::DEBUG_QUERY						=> 'KUERI: <code>$0</code>',
			'dpl_articlecount'									=> 'Terdapat {{PLURAL:$1|artikel|artikel}} dalam judul ini.'
		);

		/** Ido (Ido)
		 * @author Malafaya
		 */
		self::$messages['io'] = array(
			'intersection_toomanycats' => 'Eroro: Tro multa kategorii!',
			'intersection_toofewcats' => 'Eroro: Tro poka kategorii!',
			'intersection_noresults' => 'Eroro: Nula rezultaji!',
			'intersection_noincludecats' => 'Eroro: Vu mustas inkluzar adminime un kategorio, o specigez nomaro!',
		);

		/** Italian (Italiano)
		 * @author BrokenArrow
		 * @author Darth Kule
		 */
		self::$messages['it'] = array(
			'intersection-desc' => "Visualizza un elenco puntato con gli elementi più recenti inseriti in una categoria o nell'unione di più categorie",
			'intersection_toomanycats' => 'Errore: Numero di categorie eccessivo.',
			'intersection_toofewcats' => 'Errore: Numero di categorie insufficiente.',
			'intersection_noresults' => 'Errore: Nessun risultato.',
			'intersection_noincludecats' => 'Errore: È necessario includere almeno una categoria oppure specificare un namespace.',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "ERRORE nel parametro '$0': '$1'. Suggerimento:  <code>$0= <i>stringa vuota</i> (Principale)$3</code>.",
			'dpl_log_' . self::FATAL_WRONGLINKSTO				=> "ERRORE nel parametro '$0': '$1'. Suggerimento:  <code>$0= <i>nome completo della pagina</i></code>.",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'ERRORE: Categorie sovrabbondanti (massimo $0). Suggerimento: aumentare il valore di <code>ExtDynamicPageList::$maxCategoryCount</code> per indicare un numero maggiore di categorie, oppure impostare <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> per non avere alcun limite. (Impostare le variabili nel file <code>LocalSettings.php</code>, dopo l\'inclusione di <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'ERRORE: Categorie insufficienti (minimo $0). Suggerimento: diminuire il valore di <code>ExtDynamicPageList::$minCategoryCount</code> per indicare un numero minore di categorie. (Impostare la variabile nel file <code>LocalSettings.php</code>, dopo l\'inclusione di <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "ERRORE: L'uso dei parametri 'addfirstcategorydate=true' e 'ordermethod=categoryadd' richiede l'inserimento di una o più categorie.",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "ERRORE: L'inserimento di più categorie impedisce l'uso dei parametri 'addfirstcategorydate=true' e 'ordermethod=categoryadd'.",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'ERRORE: Non è consentito l\'uso contemporaneo di più tipi di data.',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "ERRORE: L'uso del parametro '$0' è consentito unicamente con 'ordermethod=[...,]$1'.",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "ERRORE: Impossibile effettuare operazioni logiche sulle pagine prive di categoria (ad es. con il parametro 'category') in quanto il database non contiene la vista $0. Suggerimento: chiedere all'amministratore del database di eseguire la seguente query: <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "ATTENZIONE: Il parametro non riconosciuto '$0' è stato ignorato. Suggerimento: i parametri disponibili sono: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "ATTENZIONE: Errore nel parametro '$0': '$1'. È stato usato il valore predefinito '$2'. Suggerimento: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "ATTENZIONE: errore nel parametro '$0': '$1'. È stato usato il valore predefinito '$2' (nessun limite). Suggerimento: <code>$0= <i>stringa vuota</i> (nessun limite) | n</code>, con <code>n</code> intero positivo.",
			'dpl_log_' . self::WARN_NORESULTS					=> 'ATTENZIONE: Nessun risultato.',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "ATTENZIONE: I parametri add* ('adduser', 'addeditdate', ecc.)' non hanno alcun effetto quando è specificato 'mode=category'. In tale modalità vengono visualizzati unicamente il namespace e il titolo della pagina.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "ATTENZIONE: Il parametro 'headingmode=$0' non ha alcun effetto quando è specificato 'ordermethod' su un solo componente. Verrà utilizzato il valore '$1'. Suggerimento: è posibile utilizzare i valori diversi da $1 per il parametro 'headingmode' nel caso di 'ordermethod' su più componenti. Il primo componente viene usato per generare i titoli di sezione. Ad es. 'ordermethod=category,<i>comp</i>' (dove <i>comp</i> è un altro componente) per avere titoli di sezione basati sulla categoria.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "ATTENZIONE: Il parametro 'debug=$0' non è il primo elemento della sezione DPL. Le nuove impostazioni di debug non verranno applicate prima di aver completato il parsing e la verifica di tutti i parametri che lo precedono.",
			'dpl_log_' . self::DEBUG_QUERY						=> 'QUERY: <code>$0</code>',
			'dpl_articlecount' 									=> 'Questa sezione contiene {{PLURAL:$1|una voce|$1 voci}}.'
		);

		/** Japanese (日本語)
		 * @author Fryed-peach
		 * @author JtFuruhata
		 */
		self::$messages['ja'] = array(
			'intersection-desc' => '単一カテゴリ内または複数カテゴリ内において最近更新された項目を箇条書きで表示する',
			'intersection_toomanycats' => 'エラー: カテゴリ指定が多すぎます！',
			'intersection_toofewcats' => 'エラー: カテゴリ指定が少なすぎます！',
			'intersection_noresults' => 'エラー: 最近更新された項目はありません！',
			'intersection_noincludecats' => 'エラー: 1つ以上のカテゴリ、または名前空間を指定する必要があります！',
		);

		/** Jutish (Jysk)
		 * @author Huslåke
		 */
		self::$messages['jut'] = array(
			'intersection-desc' => 'Outputs en bulleted liste der senestste itemer ræsidende i en klynge, æller æ unje der severæl klynger',
			'intersection_toomanycats' => 'Error: Åverføl klynger!',
			'intersection_toofewcats' => 'Error: Åverwæneg klynger!',
			'intersection_noresults' => 'Error: Ekke ræsultåter!',
			'intersection_noincludecats' => 'Error: Du nødst til inkludær til mendst en klynge, æller spæsifiær en navnerum!',
		);

		/** Javanese (Basa Jawa)
		 * @author Meursault2004
		 */
		self::$messages['jv'] = array(
			'intersection-desc' => 'Ngasilaké sawijining daftar item paling anyar ing sawijining kategori utawa gabungan sawetara kategori',
			'intersection_toomanycats' => 'Error: Kakèhan kategori!',
			'intersection_toofewcats' => 'Error: Kesithikan kategori!',
			'intersection_noresults' => 'Error: Ora ana pituwasé (kasilé)!',
			'intersection_noincludecats' => 'Error: Panjenengan perlu minimal mènèhi kategori sawiji, utawa spésifikasi bilik nama sawiji!',
		);

		/** Khmer (ភាសាខ្មែរ)
		 * @author Chhorran
		 * @author Thearith
		 */
		self::$messages['km'] = array(
			'intersection_toomanycats' => 'កំហុស​៖ ចំណាត់ថ្នាក់ក្រុម​ច្រើនពេក​!',
			'intersection_toofewcats' => 'កំហុស​៖ ចំណាត់ថ្នាក់ក្រុម​តិចពេក​!',
			'intersection_noresults' => 'កំហុស​៖ គ្មាន​លទ្ធផល​!',
			'intersection_noincludecats' => 'កំហុស​៖ អ្នក​ត្រូវតែ​មាន​ចំណាត់ថ្នាក់ក្រុម​មួយយ៉ាងតិច ឬ សំដៅ​មួយ​លំហឈ្មោះ​!',
		);

		/** Korean (한국어)
		 * @author Kwj2772
		 * @author Yknok29
		 */
		self::$messages['ko'] = array(
			'intersection_toomanycats' => '에러: 분류가 너무 많습니다!',
			'intersection_toofewcats' => '에러: 분류가 너무 적습니다!',
			'intersection_noresults' => '오류: 결과가 없습니다!',
			'intersection_noincludecats' => '에러: 최소한 하나의 분류에 포함시켜 주시거나 이름공간을 명확히 적어 주세요!',
		);

		/** Ripoarisch (Ripoarisch)
		 * @author Purodha
		 */
		self::$messages['ksh'] = array(
			'intersection-desc' => 'Zeij_en Liß met de neuste Enndrääsch en en Saachjrupp, udder de neuste Enndrääsch, die en alle Jruppe uss_enem Knubbel fun Saachjrupp dren sin.',
			'intersection_toomanycats' => '<i lang="en">DynamicPageList</i> hät ene Fääler jefonge: Dat sinn_er zo vill Saachjroppe!',
			'intersection_toofewcats' => '<i lang="en">DynamicPageList</i> hät ene Fääler jefonge: Dat sin ze winnisch Saachjruppe!',
			'intersection_noresults' => '<i lang="en">DynamicPageList</i> hät ene Fääler jefonge: Do kohm nix bei erus!',
			'intersection_noincludecats' => '<i lang="en">DynamicPageList</i> hät ene Fääler jefonge: Mer bruch winnischßdens ein Saachjrupp. Söns jivv e Appachtemang aan!',
		);

		/** Luxembourgish (Lëtzebuergesch)
		 * @author Robby
		 */
		self::$messages['lb'] = array(
			'intersection-desc' => 'Generéiert eng Lëscht mat de rezentesten Androungen an eng Kategorie, oder an eng Intersektioun vu méi Kategorien',
			'intersection_toomanycats' => 'Dynamesch Säite-Lëscht: Zevill Kategorien!',
			'intersection_toofewcats' => 'Dynamesch Säite-Lëscht: Ze wéineg Kategorien!',
			'intersection_noresults' => 'Dynamesch Säite-Lëscht: Kee Resultat!',
			'intersection_noincludecats' => 'Dynamesch Säite-Lëscht: Dir musst mindestens eng Kategorie abannen, oder de Nummraum uginn!',
		);

		/** Limburgish (Limburgs)
		 * @author Matthias
		 */
		self::$messages['li'] = array(
			'intersection-desc' => 'Geeft als uitvoer een ongenummerde lijst met de meest recent toegevoegde items in een categorie, of een combinatie van categorieë',
			'intersection_toomanycats' => 'Error: Te veel categorieë!',
			'intersection_toofewcats' => 'Error: Te weinig categorieë!',
			'intersection_noresults' => 'Error: Gein resultate!',
			'intersection_noincludecats' => 'Error: U moet tenminste een categorie of een naamruimte opgeve!',
		);

		/** Lithuanian (Lietuvių)
		 * @author Matasg
		 */
		self::$messages['lt'] = array(
			'intersection_toomanycats' => 'Error: Per daug kategorijų!',
			'intersection_toofewcats' => 'Error: Per mažai kategorijų!',
			'intersection_noresults' => 'Error: Nėra rezultatų!',
			'intersection_noincludecats' => 'Error: Jums reikia įtraukti bent vieną kategoriją, arba nurodyti vardų sritį!',
		);

		/** Latvian (Latviešu)
		 * @author Xil
		 */
		self::$messages['lv'] = array(
			'intersection_toomanycats' => 'Kļūda: pārāk daudz kategoriju!',
			'intersection_toofewcats' => 'Kļūda: pārāk maz kategoriju!',
		);

		/** Malagasy (Malagasy)
		 * @author Jagwar
		 */
		self::$messages['mg'] = array(
			'intersection_toomanycats' => 'DynamicPageList : Be laotra ny sokajy',
		);

		/** Malayalam (മലയാളം)
		 * @author Shijualex
		 */
		self::$messages['ml'] = array(
			'intersection-desc' => 'ഒരു കാറ്റഗറിയില്‍ പുതിയതായി വന്ന ഇനങ്ങളുടെ ബുള്ളറ്റ് പട്ടികയോ, അല്ലെങ്കില്‍ നിരവധി കാറ്റഗറികളുടെ കൂട്ടത്തെയോ ഔട്ട് പുട്ടായി കിട്ടുന്നു.',
			'intersection_toomanycats' => 'Error: വളരെയധികം കാറ്റഗറികള്‍!',
			'intersection_toofewcats' => 'Error: വളരെ കുറച്ച് കാറ്റഗറികള്‍!',
			'intersection_noresults' => 'Error: ഫലങ്ങള്‍ ഒന്നുമില്ല!',
			'intersection_noincludecats' => 'Error: ചുരുങ്ങിയത് ഒരു കാറ്റഗറിയെങ്കിലും ഉള്‍പ്പെടുത്തുകയോ അല്ലെങ്കില്‍ ഒരു നേംസ്പേസ് എങ്കിലും നിഷ്കര്‍ഷിച്ചിരിക്കുകയോ വേണം!',
		);

		/** Marathi (मराठी)
		 * @author Kaustubh
		 */
		self::$messages['mr'] = array(
			'intersection-desc' => 'एखाद्या वर्गातील अथवा वर्गसमूहातील नवीनतम लेख दर्शवितो.',
			'intersection_toomanycats' => 'Error: खूप जास्त वर्ग!',
			'intersection_toofewcats' => 'Error: खूप कमी वर्ग!',
			'intersection_noresults' => 'Error: निकाल नाहीत!',
			'intersection_noincludecats' => 'Error: कमीतकमी एक वर्ग अथवा नामविश्व देणे गरजेचे आहे!',
		);

		/** Malay (Bahasa Melayu)
		 * @author Aviator
		 */
		self::$messages['ms'] = array(
			'intersection-desc' => 'Mengoutput senarai item terkini dalam sesebuah kategori atau kesatuan beberapa buah kategori',
			'intersection_toomanycats' => 'Error: Kategori terlalu banyak!',
			'intersection_toofewcats' => 'Error: Kategori terlalu sedikit!',
			'intersection_noresults' => 'Error: Tiada hasil!',
			'intersection_noincludecats' => 'Error: Anda hendaklah memasukkan sekurang-kurangnya sebuah kategori atau menyatakan sebuah ruang nama!',
		);

		/** Low German (Plattdüütsch)
		 * @author Slomox
		 */
		self::$messages['nds'] = array(
			'intersection-desc' => 'Wiest en List mit de aktuellsten Indrääg in en Kategorie, oder de Snittmengd vun mehr Kategorien',
			'intersection_toomanycats' => 'Fehler: Toveel Kategorien!',
			'intersection_toofewcats' => 'Fehler: To wenig Kategorien!',
			'intersection_noresults' => 'Fehler: Nix funnen!',
			'intersection_noincludecats' => 'Fehler: Dor mutt opminnst een Kategorie angeven warrn! ODer geev en Naamruum an.',
		);

		/** Dutch (Nederlands)
		 * @author SPQRobin
		 * @author Siebrand
		 */
		self::$messages['nl'] = array(
			'intersection-desc' => 'Geeft als uitvoer een ongenummerde lijst met de meest recent toegevoegde items in een categorie, of een combinatie van categorieën',
			'intersection_toomanycats' => 'Fout: Te veel categorieën!',
			'intersection_toofewcats' => 'Fout: Te weinig categorieën!',
			'intersection_noresults' => 'Fout: Geen resultaten!',
			'intersection_noincludecats' => 'Fout: U moet tenminste een categorie of een naamruimte opgeven!',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "FOUT: Verkeerde parameter '$0': '$1'! Hulp:  <code>$0= <i>lege string</i> (Main)$3</code>.",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'FOUT: Te veel categoriën! Maximum: $0. Hulp: verhoog <code>ExtDynamicPageList::$maxCategoryCount</code> om meer categorieën op te kunnen geven of stel geen limiet in met <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code>. (Neem deze variabele op in <code>LocalSettings.php</code>, na het toevoegen van <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'FOUT: Te weinig categorieën! Minimum: $0. Hulp: verlaag <code>ExtDynamicPageList::$minCategoryCount</code> om minder categorieën aan te hoeven geven. (Stel de variabele bij voorkeur in via <code>LocalSettings.php</code>, na het toevoegen van <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "FOUT: U dient tenminste één categorie op te nemen als u 'addfirstcategorydate=true' of 'ordermethod=categoryadd' wilt gebruiken!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "FOUT: Als u meer dan één categorie opneemt, kunt u 'addfirstcategorydate=true' of 'ordermethod=categoryadd' niet gebruiken!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'FOUT: U kunt niet meer dan één type of datum tegelijk gebruiken!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "FOUT: U kunt '$0' alleen met 'ordermethod=[...,]$1' gebruiken!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=>		  self::$messages['en']['dpl_log_' . self::FATAL_NOCLVIEW],
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=>		  self::$messages['en']['dpl_log_' . self::WARN_UNKNOWNPARAM],
			'dpl_log_' . self::WARN_WRONGPARAM					=> "WAARSCHUWING: Verkeerde parameter '$0': '$1'! Nu wordt de standaard gebruikt: '$2'. Hulp: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=>		  self::$messages['en']['dpl_log_' . self::WARN_WRONGPARAM_INT],
			'dpl_log_' . self::WARN_NORESULTS					=> 'WAARSCHUWING: Geen resultaten!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "WAARSCHUWING: Add* parameters ('adduser', 'addeditdate', etc.)' heeft geen effect bij 'mode=category'. Alleen de paginanaamruimte/titel is in deze modus te bekijken.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "WAARSCHUWING: 'headingmode=$0' heeft geen effect met 'ordermethod' op een enkele component. Nu wordt gebruikt: '$1'. Hulp: u kunt een niet-$1 'headingmode'-waarde gebruiken met 'ordermethod' op meerdere componenten. De eerste component wordt gebruikt als kop. Bijvoorbeeld 'ordermethod=category,<i>comp</i>' (<i>comp</i> is een ander component) voor categoriekoppen.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "WAARSCHUWING: 'debug=$0' is niet de eerste positie in het DPL-element. De nieuwe debuginstellingen zijn niet toegepast voor alle voorgaande parameters zijn verwerkt en gecontroleerd.",
			'dpl_log_' . self::DEBUG_QUERY 						=> 'QUERY: <code>$0</code>',
			'dpl_articlecount' 									=> 'Er {{PLURAL:$1|is één pagina|zijn $1 pagina\'s}} onder deze kop.'
		);

		/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
		 * @author Harald Khan
		 */
		self::$messages['nn'] = array(
			'intersection-desc' => 'Gjev ei punktlista over dei nyaste elementa i ein kategori, eller element som er felles i fleire kategoriar',
			'intersection_toomanycats' => 'Feil: For mange kategoriar!',
			'intersection_toofewcats' => 'Feil: For få kategoriar!',
			'intersection_noresults' => 'Feil: Ingen resultat!',
			'intersection_noincludecats' => 'Feil: Du må inkludera minst éin kategori, eller oppgje eit namnerom!',
		);

		/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
		 * @author Jon Harald Søby
		 */
		self::$messages['no'] = array(
			'intersection-desc' => 'Gir en punktliste over de nyeste elementene i en kategori, eller elementer som er felles i flere kategorier',
			'intersection_toomanycats' => 'Dynamisk sideliste: For mange kategorier!',
			'intersection_toofewcats' => 'Dynamisk sidelist: For få kategorier!',
			'intersection_noresults' => 'Dynamisk sideliste: Ingen resultater!',
			'intersection_noincludecats' => 'Dynamisk sideliste: Du må inkludere minst én kategori, eller oppgi et navnerom!',
		);

		/** Occitan (Occitan)
		 * @author Cedric31
		 */
		self::$messages['oc'] = array(
			'intersection-desc' => 'Aficha una lista, amb de piuses, dels articles mai recents dins una categoria, o a partir d’una combinason de mantuna categoria.',
			'intersection_toomanycats' => 'Error : Tròp de categorias !',
			'intersection_toofewcats' => 'Error : Pas pro de categorias !',
			'intersection_noresults' => 'Error : Pas cap de resultat !',
			'intersection_noincludecats' => 'Error : avètz besonh d’inclure almens una categoria, o de precisar un nom d’espaci !',
		);

		/** Ossetic (Иронау)
		 * @author Amikeco
		 */
		self::$messages['os'] = array(
			'intersection_toomanycats' => 'Рæдыд: æгæр бирæ категоритæ!',
		);

		/** Polish (Polski)
		 * @author Sp5uhe
		 */
		self::$messages['pl'] = array(
			'intersection-desc' => 'Zwraca listę wypunktowaną najnowszych elementów w kategorii lub grupie kilku kategorii',
			'intersection_toomanycats' => 'Błąd – zbyt wiele kategorii!',
			'intersection_toofewcats' => 'Błąd – zbyt mało kategorii!',
			'intersection_noresults' => 'Błąd – brak wyników!',
			'intersection_noincludecats' => 'Błąd – musisz załączyć co najmniej jedną kategorię lub określić przestrzeń nazw!',
		);

		/** Portuguese (Português)
		 * @author 555
		 * @author Malafaya
		 */
		self::$messages['pt'] = array(
			'intersection-desc' => 'constrói uma lista pontuada dos itens mais recentes presentes numa categoria, ou uma união de várias categorias',
			'intersection_toomanycats' => 'Error: Categorias em excesso!',
			'intersection_toofewcats' => 'Error: Poucas categorias!',
			'intersection_noresults' => 'Error: Sem resultados!',
			'intersection_noincludecats' => 'Error: É necessário incluir no mínimo uma categoria ou especificar um espaço nominal!',
		);

		/** Brazilian Portuguese (Português do Brasil)
		 * @author Eduardo.mps
		 */
		self::$messages['pt-br'] = array(
			'intersection-desc' => 'Exibe uma lista pontuada dos itens mais recentes presentes numa categoria, ou uma intersecção de várias categorias',
			'intersection_toomanycats' => 'Erro: Categorias demais!',
			'intersection_toofewcats' => 'Erro: Poucas categorias!',
			'intersection_noresults' => 'Erro: Sem resultados!',
			'intersection_noincludecats' => 'Erro: É necessário incluir no mínimo uma categoria ou especificar um espaço nominal!',
		);

		/** Romanian (Română)
		 * @author Mihai
		 */
		self::$messages['ro'] = array(
			'intersection-desc' => 'Întoarce o lista celor mai recenţi itemi care fac parte dintr-o categorie, sau intersecţia a mai multor categorii',
			'intersection_toomanycats' => 'Eroare: Prea multe categorii!',
			'intersection_toofewcats' => 'Eroare: Prea puţine categorii!',
			'intersection_noresults' => 'Eroare: Niciun rezultat!',
			'intersection_noincludecats' => 'Eroare: Trebuie să incluzi cel puţin o categorie, sau să specifici un spaţiu de nume!',
		);

		/** Tarandíne (Tarandíne)
		 * @author Joetaras
		 */
		self::$messages['roa-tara'] = array(
			'intersection-desc' => "Fa assè 'na liste cu le palle de le urteme urteme artichele ca stonne jndr'à 'na categorije, o 'n'interseziona de cchiù categorije",
			'intersection_toomanycats' => 'Errore: Troppe categorije!',
			'intersection_toofewcats' => 'Errore: Troppe picche categorije!',
			'intersection_noresults' => 'Errore: Nisciune resultete!',
			'intersection_noincludecats' => "Errore: Tu è abbesogne de 'ngludere ninde ninde 'na categorije, o specificà 'nu namespace!",
		);

		/** Russian (Русский)
		 * @author Александр Сигачёв
		 */
		self::$messages['ru'] = array(
			'intersection-desc' => 'Выводит в маркированный список последние добавления в категорию или объединение нескольких категорий',
			'intersection_toomanycats' => 'Error: слишком много категорий!',
			'intersection_toofewcats' => 'Error: слишком мало категорий!',
			'intersection_noresults' => 'Error: нет результатов!',
			'intersection_noincludecats' => 'Error: вы должны включить хотя бы одну категорию или указать пространство имён!',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "ОШИБКА: неправильный «$0»-параметр: «$1»! Подсказка:  <code>$0= <i>пустая строка</i> (Основное)$3</code>.",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'ОШИБКА: слишком много категорий! Максимум: $0. Подсказка: увеличте <code>ExtDynamicPageList::$maxCategoryCount</code> чтобы разрешить больше категорий или установите <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> для снятия ограничения. (Устанавливайте переменные в <code>LocalSettings.php</code>, после подключения <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'ОШИБКА: слишком мало категорий! Минимум: $0. Подсказка: уменьшите <code>ExtDynamicPageList::$minCategoryCount</code> чтобы разрешить меньше категорий. (Устанавливайте переменную в <code>LocalSettings.php</code>, после подключения <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "ОШИБКА: вы должны включить хотя бы одну категорию, если вы хотите использовать «addfirstcategorydate=true» или «ordermethod=categoryadd»!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "ОШИБКА: если вы включаете больше одной категории, то вы не можете использовать «addfirstcategorydate=true» или «ordermethod=categoryadd»!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'ОШИБКА: вы не можете добавить более одного типа данных за раз!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "ОШИБКА: вы можете использовать «$0» только с «ordermethod=[...,]$1»!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=>		  self::$messages['en']['dpl_log_' . self::FATAL_NOCLVIEW],
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "ПРЕДУПРЕЖДЕНИЕ: неизвестный параметр «$0» проигнорирован. Подсказка: доступные параметры: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "ПРЕДУПРЕЖДЕНИЕ: неправильный параметр «$0»: «$1»! Использование параметра по умолчанию: «$2». Подсказка: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "ПРЕДУПРЕЖДЕНИЕ: неправильный параметр «$0»: «$1»! Использование параметра по умолчанию: «$2» (без ограничений). Подсказка: <code>$0= <i>пустая строка</i> (без ограничений) | n</code>, с <code>n</code> равным положительному целому числу.",
			'dpl_log_' . self::WARN_NORESULTS					=> 'ПРЕДУПРЕЖДЕНИЕ: не найдено!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "ПРЕДУПРЕЖДЕНИЕ: Добавление* параметров («adduser», «addeditdate», и др.) не действительны с «mode=category». Только пространства имён или названия могут просматриваться в этом режиме.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "ПРЕДУПРЕЖДЕНИЕ: «headingmode=$0» не действителен с «ordermethod» в одном компоненте. Использование: «$1». Подсказка: вы можете использоватьe не-$1 «headingmode» значения с «ordermethod» во множестве компонентов. Первый компонент используется для заголовков. Например, «ordermethod=category,<i>comp</i>» (<i>comp</i> является другим компонентом) для заголовков категорий.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "ПРЕДУПРЕЖДЕНИЕ: «debug=$0» не находится на первом месте в DPL-элементе. Новые настройки отладки не будут применены пока все предыдущие параметры не будут разобраны и проверены.",
			'dpl_log_' . self::DEBUG_QUERY 						=> 'ЗАПРОС: <code>$0</code>',
			'dpl_articlecount' 									=> 'В этом заголовке $1 {{PLURAL:$1|статья|статьи|статей}}.'
		);

		/** Yakut (Саха тыла)
		 * @author HalanTul
		 */
		self::$messages['sah'] = array(
			'intersection-desc' => 'Категорияларга бүтэһик эбиилэри эбэтэр категориялар холбонууларын бэлиэлээх (маркированнай) испииһэк курдук таһаарар',
			'intersection_toomanycats' => 'Error: категорийата наһаа элбэх!',
			'intersection_toofewcats' => 'Error: Категорията наһаа аҕыйах',
			'intersection_noresults' => 'Error: Түмүк суох!',
			'intersection_noincludecats' => 'Error: Биир эмит категорияны эбэтэр ааты (пространство имен) талыахтааххын!',
		);

		/** Slovak (Slovenčina)
		 * @author Helix84
		 */
		self::$messages['sk'] = array(
			'intersection-desc' => 'Vypíše zoznam najnovších položiek v kategórii alebo zjednotení niekoľkých kategórií',
			'intersection_toomanycats' => 'Error: Príliš veľa kategórií!',
			'intersection_toofewcats' => 'Error: Príliš málo kategórií!',
			'intersection_noresults' => 'Error: Žiadne výsledky!',
			'intersection_noincludecats' => 'Error: Musíte uviesť aspoň jednu kategóriu alebo menný priestor!',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "CHYBA: nesprávny parameter '$0': '$1'! Pomocník <code>$0= <i>prázdny retazec</i> (Hlavný)$3<code>.",
			'dpl_log_' . self::FATAL_WRONGLINKSTO				=> "CHYBA: Zlý parameter '$0': '$1'! Pomocník <code>$0= <i>plný názov stránky</i></code>.",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'CHYBA: Príli vela kategórií! Maximum: $0. Pomocník: zväcite <code>ExtDynamicPageList::$maxCategoryCount</code>, aby ste mohli pecifikovat viac kategórií alebo nastavte <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> pre vypnutie limitu. (Premennú nastatavte v <code>LocalSettings.php</code>, potom ako bol includovaný <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'CHYBA: Príli málo kategórií! Minimum: $0. Pomocník: zníte <code>ExtDynamicPageList::$minCategoryCount</code>, aby ste mohli pecifikovat menej kategórií. (Premennú nastavte najlepie v <code>LocalSettings.php</code> potom, ako v nom bol includovaný <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "CHYBA: Musíte uviest aspon jednu kategóriu ak chcete pouit 'addfirstcategorydate=true' alebo 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "CHYBA: Ak zahrniete viac ako jednu kategóriu, nemôete pouit 'addfirstcategorydate=true' alebo 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'CHYBA: Nemôete naraz pridat viac ako jeden typ dátumu!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "CHYBA: '$0' môete pouit iba s 'ordermethod=[...,]$1'!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "CHYBA: Nie je momoné vykonávat logické operácie na nekategorizovaných kategóriách (napr. s parametrom 'Kategória') lebo neexistuje na databázu pohlad $0! Pomocník: nech admin databázy vykoná tento dotaz: <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "VAROVANIE: Neznámy parameter '$0' ignorovaný. Pomocník: dostupné parametre: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "VAROVANIE: Nesprávny '$0' parameter: '$1'! Pouívam tandardný '$2'. Pomocník: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "VAROVANIE: Nesprávny parameter  '$0': '$1'! Pouívam tandardný: '$2' (bez obmedzenia). Pomocník: <code>$0= <i>prázdny retazec</i> (bez obmedzenia) | n</code>, s kladným celým císlom <code>n</code>.",
			'dpl_log_' . self::WARN_NORESULTS					=> 'VAROVANIE: No results!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "VAROVANIE: Parametre Add* ('adduser', 'addeditdate', atd' nepracujú s mode=category'. V tomto reime je moné prehliadat iba menná priestor/titulok stránky.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "VAROVANIE: 'headingmode=$0' nepracuje s 'ordermethod' na jednom komponente. Pouitie: '$1'. Pomocník: môete pouit not-$1 hodnoty 'headingmode' s 'ordermethod' na viaceré komponenty. Prvý komponent sa pouíva na nadpisy. Napr. 'ordermethod=category,<i>comp</i>' (<i>comp</i> je iný komponent) pre nadpisy kategórií.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "VAROVANIE: 'debug=$0' nie je na prvej pozícii v prvku DPL. Nové ladiacie nastavenia nebudú pouíté skôr ne budú parsované a skontrolované vetky predchádzajúce.",
			'dpl_log_' . self::DEBUG_QUERY 						=> 'DOTAZ: <code>$0</code>',
			'dpl_articlecount' 									=> 'V tomto nadpise {{PLURAL:$1|je jeden clánok|sú $1 clánky|je $1 clánkov}}.'
		);

		/** Serbian Cyrillic ekavian (ћирилица)
		 * @author Millosh
		 */
		self::$messages['sr-ec'] = array(
			'intersection-desc' => 'Даје редни списак најскорије додатих чланака у једну или више категорија.',
			'intersection_toomanycats' => 'Грешка: Превише категорија!',
			'intersection_toofewcats' => 'Грешка:Премало категорија!',
			'intersection_noresults' => 'Грешка: Нема резулатата!',
			'intersection_noincludecats' => 'Грешка: Потребно је укључити бар једну категорију или одредити именски простор!',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "ГРЕШКА: Погреан '$0' параметар: '$1'! Помоћ:  <code>$0= <i>погрешан стринг</i> (Главно)$3</code>. (Еквиваленти са магичним речима су такође дозвољени.)",
			'dpl_log_' . self::FATAL_WRONGLINKSTO				=> "ГРЕШКА: Погрешан '$0' параметар: '$1'! Помоћ:  <code>$0= <i>пуно име странице</i></code>. (Магичне речи су дозвољене.)",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'ГРЕШКА: Превише категорија! Максимум је: $0. Помоћ: повећајте <code>ExtDynamicPageList::$maxCategoryCount</code> како бисте поставили више категорија или промените <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> за без граница. (Подесите варијаблу у <code>LocalSettings.php</code>, након укључивања <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'ГРЕШКА: Премало категорија! Минимум је: $0. Помоћ: повећајте <code>ExtDynamicPageList::$minCategoryCount</code> како бисте поставили мање категорија. (Подесите варијаблу у <code>LocalSettings.php</code>, након укључивања <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "ГРЕШКА: Морате укључити бар једну категорију уколико желите да користите 'addfirstcategorydate=true' или 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "ГРЕШКА: Уколико укључујете више од једне категорије, не можете користити 'addfirstcategorydate=true' или 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'ГРЕШКА: Не можете додати више од једног типа датума!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "ГРЕШКА: Можете користити '$0' са 'ordermethod=[...,]$1' искључиво!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ГРЕШКА: Немогуће извршити операцију на некатегоризованим страницама (нпр. са 'category' параметром) зато што $0 преглед не постоји у бази података! Помоћ: нека администратор базе изврши овај упит: <code>$1</code>.",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "ERROR: Cannot perform logical operations on the Uncategorized pages (f.e. with the 'category' parameter) because the $0 view does not exist on the database! Help: have the database administrator execute this query: <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "ПАЖЊА: Непознат параметар '$0' је игнорисан. Помоћ: доступни параметри су: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "ПАЖЊА: Погрешан '$0' параметар: '$1'! Користи се основни: '$2'. Помоћ: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "ПАЖЊА: Погрешан '$0' параметар: '$1'! Користи се основни: '$2' (без границе). Помоћ: <code>$0= <i>празан стринг</i> (без границе) | n</code>, с <code>n</code> је позитиван интегер.",
			'dpl_log_' . self::WARN_NORESULTS					=> 'ПАЖЊА: Нема резултата!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "ПАЖЊА: Додавање* параметара ('adduser', 'addeditdate', итд.)' и 'includepage' нема ефекта са 'mode=category'. Искључиво име странице/именски простор могу да се виде у овом моду.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "ПАЖЊА: 'headingmode=$0' нема ефекта са 'ordermethod' на једној компоненти. Користи се: '$1'. Помоћ: не морате користити-$1 'headingmode' податке 'ordermethod' на више компоненти. Прва компонента се користи за наслов. Нпр. 'ordermethod=category,<i>компонента</i>' (<i>компонента</i> је друга компонента) за наслове категорија.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "ПАЖЊА: 'debug=$0' није на првом месту у DPL елементу. Нова дебаг подешавања нису примењена пре свих параметара који су проверени",
			'dpl_log_' . self::WARN_TRANSCLUSIONLOOP			=> "ПАЖЊА: Бесконачна петљаса странице '$0'.",
			'dpl_log_' . self::DEBUG_QUERY 						=> 'УПИТ: <code>$0</code>',
			'dpl_articlecount' 									=> 'У овом наслову се тренутно налази {{PLURAL:$1|један чланак|$1 чланка|$1 чланака}}.'
		);

		self::$messages['sr'] = self::$messages['sr-ec'];

		self::$messages['sr-el'] = array(
			'dpl_log_' . self::FATAL_WRONGNS 					=> "GREŠKA: Pogrean '$0' parametar: '$1'! Pomoć:  <code>$0= <i>pogrešan string</i> (Glavno)$3</code>. (Ekvivalenti sa magičnim rečima su takođe dozvoljeni.)",
			'dpl_log_' . self::FATAL_WRONGLINKSTO				=> "GREŠKA: Pogrešan '$0' parametar: '$1'! Pomoć:  <code>$0= <i>puno ime stranice</i></code>. (Magične reči su dozvoljene.)",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> 'GREŠKA: Previše kategorija! Maksimum je: $0. Pomoć: povećajte <code>ExtDynamicPageList::$maxCategoryCount</code> kako biste postavili više kategorija ili promenite <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> za bez granica. (Podesite varijablu u <code>LocalSettings.php</code>, nakon uključivanja <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> 'GREŠKA: Premalo kategorija! Minimum je: $0. Pomoć: povećajte <code>ExtDynamicPageList::$minCategoryCount</code> kako biste postavili manje kategorija. (Podesite varijablu u <code>LocalSettings.php</code>, nakon uključivanja <code>DynamicPageList.php</code>.)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "GREŠKA: Morate uključiti bar jednu kategoriju ukoliko želite da koristite 'addfirstcategorydate=true' ili 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "GREŠKA: Ukoliko uključujete više od jedne kategorije, ne možete koristiti 'addfirstcategorydate=true' ili 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> 'GREŠKA: Ne možete dodati više od jednog tipa datuma!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "GREŠKA: Možete koristiti '$0' sa 'ordermethod=[...,]$1' isključivo!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=> "GREŠKA: Nemoguće izvršiti operaciju na nekategorizovanim stranicama (npr. sa 'category' parametrom) zato što $0 pregled ne postoji u bazi podataka! Pomoć: neka administrator baze izvrši ovaj upit: <code>$1</code>.",
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "PAŽNJA: Nepoznat parametar '$0' je ignorisan. Pomoć: dostupni parametri su: <code>$1</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "PAŽNJA: Pogrešan '$0' parametar: '$1'! Koristi se osnovni: '$2'. Pomoć: <code>$0= $3</code>.",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "PAŽNJA: Pogrešan '$0' parametar: '$1'! Koristi se osnovni: '$2' (bez granice). Pomoć: <code>$0= <i>prazan string</i> (bez granice) | n</code>, s <code>n</code> je pozitivan integer.",
			'dpl_log_' . self::WARN_NORESULTS					=> 'PAŽNJA: Nema rezultata!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "PAŽNJA: Dodavanje* parametara ('adduser', 'addeditdate', itd.)' i 'includepage' nema efekta sa 'mode=category'. Isključivo ime stranice/imenski prostor mogu da se vide u ovom modu.",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "PAŽNJA: 'headingmode=$0' nema efekta sa 'ordermethod' na jednoj komponenti. Koristi se: '$1'. Pomoć: ne morate koristiti-$1 'headingmode' podatke 'ordermethod' na više komponenti. Prva komponenta se koristi za naslov. Npr. 'ordermethod=category,<i>komponenta</i>' (<i>komponenta</i> je druga komponenta) za naslove kategorija.",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "PAŽNJA: 'debug=$0' nije na prvom mestu u DPL elementu. Nova debag podešavanja nisu primenjena pre svih parametara koji su provereni",
			'dpl_log_' . self::WARN_TRANSCLUSIONLOOP			=> "PAŽNJA: Beskonačna petljasa stranice '$0'.",
			'dpl_log_' . self::DEBUG_QUERY 						=> 'UPIT: <code>$0</code>',
			'dpl_articlecount' 									=> 'U ovom naslovu se trenutno nalazi {{PLURAL:$1|jedan članak|$1 članka|$1 članaka}}'
		);

		/** Seeltersk (Seeltersk)
		 * @author Pyt
		 */
		self::$messages['stq'] = array(
			'intersection-desc' => 'Uutgoawe fon ne Lieste fon do aktuälste Iendraage in ne Kategorie, of n Truchsnit fon moorere Kategorien.',
			'intersection_toomanycats' => 'Error: Toufuul Kategorien!',
			'intersection_toofewcats' => 'Error: Toumin Kategorien!',
			'intersection_noresults' => 'Error: Neen Resultoat!',
			'intersection_noincludecats' => 'Error: Der mout mindestens een Kategorie ienbuunen weese of reek n Noomensruum oun!',
		);

		/** Swedish (Svenska)
		 * @author Lejonel
		 */
		self::$messages['sv'] = array(
			'intersection-desc' => 'Skapar punktlistor över de nyaste sidorna i en eller flera kategorier',
			'intersection_toomanycats' => 'Fel: För många kategorier!',
			'intersection_toofewcats' => 'Fel: För få kategorier!',
			'intersection_noresults' => 'Fel: Inga resultat!',
			'intersection_noincludecats' => 'Fel: Du måste inkludera minst en kategori eller ange en namnrymd!',
		);

		/** Telugu (తెలుగు)
		 * @author Veeven
		 */
		self::$messages['te'] = array(
			'intersection_toomanycats' => 'Error: చాలా ఎక్కువ వర్గాలు!',
			'intersection_toofewcats' => 'Error: మరీ తక్కువ వర్గాలు!',
			'intersection_noresults' => 'Error: ఫలితాలు లేవు!',
			'intersection_noincludecats' => 'Error: మీరు కనీసం ఒక్క వర్గాన్నైనా చేర్చాలి, లేదా ఓ నేమ్&zwnj;స్పేసునైనా ఇవ్వాలి!',
		);

		/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
		 * @author Ibrahim
		 */
		self::$messages['tg-cyrl'] = array(
			'intersection-desc' => 'Феҳристи гулулае аз саҳифаҳое ба намоиш дар меояд, ки ба тозагӣ дар як ё чанд гурӯҳ ворид шудаанд',
			'intersection_toomanycats' => 'Error: Теъдоди гурӯҳҳо зиёд аст!',
			'intersection_toofewcats' => 'Error: Теъдоди гурӯҳҳо кам аст!',
			'intersection_noresults' => 'Error: Натиҷае вуҷуд надорад!',
			'intersection_noincludecats' => 'Error: Шумо ҳадди ақал бояд як гурӯҳро ворид кунед, ё як фазои номро мушаххас кунед!',
		);

		/** Tagalog (Tagalog)
		 * @author AnakngAraw
		 */
		self::$messages['tl'] = array(
			'intersection-desc' => 'Naglalabas ng isang tinuldukang talaan ng pinakakamakailang mga bagay-bagay na naninirahan sa loob ng isang kaurian, o isang pinagsangahang daanan ng ilang mga kaurian',
			'intersection_toomanycats' => 'Kamalian: Napakaraming mga kaurian!',
			'intersection_toofewcats' => 'Kamalian: Napakakaunti ng mga kaurian!',
			'intersection_noresults' => 'Kaurian: Walang mga kinalabasan/resulta!',
			'intersection_noincludecats' => 'Kamalian: Kinakailangan mong magsama ng kahit na isang kaurian, o tumukoy ng isang espasyo ng pangalan!',
		);

		/** Turkish (Türkçe)
		 * @author Joseph
		 */
		self::$messages['tr'] = array(
			'intersection-desc' => 'Bir kategoride, yada birçok kategorinin kesişiminde bulunan en son öğelerin, madde işaretli listesini üretir',
			'intersection_toomanycats' => 'Hata: Çok fazla kategori!',
			'intersection_toofewcats' => 'Hata: Çok az kategori!',
			'intersection_noresults' => 'Hata: Sonuç yok!',
			'intersection_noincludecats' => 'Hata: En az bir kategori eklemeli, ya da bir ad alanı belirtmelisiniz!',
		);

		/** Ukrainian (Українська)
		 * @author Ahonc
		 */
		self::$messages['uk'] = array(
			'intersection-desc' => "Виводить у маркований список останні додавання до категорії або об'єднання кількох категорій",
			'intersection_toomanycats' => 'Error: дуже багато категорій!',
			'intersection_toofewcats' => 'Error: дуже мало категорій!',
			'intersection_noresults' => 'Error: нема результатів!',
			'intersection_noincludecats' => 'Error: ви повинні включити хоча б одну категорію або зазначити простір назв!',
		);

		/** Vèneto (Vèneto)
		 * @author Candalua
		 */
		self::$messages['vec'] = array(
			'intersection-desc' => "Mostra un elenco puntato coi elementi piassè reçenti inserìi in te na categoria o ne l'union de più categorie",
			'intersection_toomanycats' => 'Error: Ghe xe massa categorie!',
			'intersection_toofewcats' => 'Error: Ghe xe massa póche categorie!',
			'intersection_noresults' => 'Error: Nissun risultato!',
			'intersection_noincludecats' => 'Error: Te ghè da inclùdar almanco na categoria opure specificar un namespace.',
		);

		/** Veps (Vepsan kel')
		 * @author Игорь Бродский
		 */
		self::$messages['vep'] = array(
			'intersection_toomanycats' => 'Error: äjahk kategorijoid!',
			'intersection_toofewcats' => 'Error: Vähähk kategorijoid!',
			'intersection_noresults' => "Error: Ei ole rezul'tatoid!",
		);

		/** Vietnamese (Tiếng Việt)
		 * @author Minh Nguyen
		 */
		self::$messages['vi'] = array(
			'intersection-desc' => 'Cho ra danh sách những khoản gần đây nhất được xếp vào một thể loại hay hợp của hơn một thể loại',
			'intersection_toomanycats' => 'Error: Nhiều thể loại quá!',
			'intersection_toofewcats' => 'Error: Ít thể loại quá!',
			'intersection_noresults' => 'Error: Không tìm thấy trang nào!',
			'intersection_noincludecats' => 'Error: Cần phải bao gồm ít nhất một thể loại hay định rõ một không gian tên!',
		);

		/** Volapük (Volapük)
		 * @author Smeira
		 */
		self::$messages['vo'] = array(
			'intersection_toomanycats' => 'Error: Klads tu mödiks!',
			'intersection_toofewcats' => 'Error: Klads tu nemödiks!',
			'intersection_noresults' => 'Error: Seks nonik!',
			'intersection_noincludecats' => 'Error: Nedol välön kladi pu bali, u nemaspadi!',
		);

		/** Yue (粵語)
		 * @author Shinjiman
		 */
		self::$messages['yue'] = array(
			'intersection-desc' => '輸出一個點列最近響分類嘅項目，或者係幾個分類嘅一個聯繫',
			'intersection_toomanycats' => 'DynamicPageList: 太多分類!',
			'intersection_toofewcats' => 'DynamicPageList: 太少分類!',
			'intersection_noresults' => 'DynamicPageList: 無結果!',
			'intersection_noincludecats' => 'DynamicPageList: 你需要去包含最少一個分類，或者指定一個空間名!',
			'dpl-desc' => '一個畀MediaWiki嘅高彈性報告產生器',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "錯誤: 錯嘅 '$0' 參數: '$1'! 幫助:  <code>$0= <i>空字串</i> (主)$3</code>。",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> '錯誤: 太多分類! 最大值: $0。 幫助: 增加 <code>ExtDynamicPageList::$maxCategoryCount</code> 嘅值去指定更多嘅分類或者設定 <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> 以解除限制。 (當加上 <code>DynamicPageList.php</code>之後，響<code>LocalSettings.php</code>度設定變數。)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> '錯誤: 太少分類! 最小值: $0. 幫助: 減少 <code>ExtDynamicPageList::$minCategoryCount</code> 嘅值去指定更少嘅分類。 (當加上 <code>DynamicPageList.php</code>之後，響<code>LocalSettings.php</code>度設定一個合適嘅變數。)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "錯誤: 如果你想去用 'addfirstcategorydate=true' 或者 'ordermethod=categoryadd' ，你需要包含最少一個分類!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "錯誤: 如果你包含多過一個分類，你唔可以用 'addfirstcategorydate=true' 或者 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> '錯誤: 你唔可以響一個時間度加入多個一種嘅日期!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "錯誤: 你只可以用 'ordermethod=[...,]$1' 響 '$0' 上!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=>		  self::$messages['en']['dpl_log_' . self::FATAL_NOCLVIEW],
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "警告: 不明嘅參數 '$0' 被忽略。 幫助: 可用嘅參數: <code>$1</code>。",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "警告: 錯誤嘅 '$0' 參數: '$1'! 用緊預設嘅: '$2'。 幫助: <code>$0= $3</code>。",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "警告: 錯誤嘅 '$0' 參數: '$1'! 用緊預設嘅: '$2' (冇上限)。 幫助: <code>$0= <i>空字串</i> (冇上限) | n</code>, <code>n</code>係一個正整數。",
			'dpl_log_' . self::WARN_NORESULTS					=> '警告: 無結果!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "警告: 加入* 參數 ('adduser', 'addeditdate', 等)' 係對 'mode=category' 冇作用嘅。只有頁空間名／標題至可以響呢個模式度睇到。",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "警告: 響單一部件中， 'ordermethod' 度用 'headingmode=$0' 係冇作用嘅。 用緊: '$1'。 幫助: 你可以用非$1 'headingmode' 數值，響多個部件中用 'ordermethod' 。第一個部件係用嚟做標題。例如響分類標題度用 'ordermethod=category,<i>comp</i>' (<i>comp</i>係另外一個部件) 。",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "警告: 'debug=$0' 唔係第一個響DPL元素嘅第一位。新嘅除錯設定響所有參數都能夠處理同檢查之前都唔會應用。",
			'dpl_log_' . self::DEBUG_QUERY 						=> '查訽: <code>$0</code>',
			'dpl_articlecount' 									=> '響呢個標題度有$1篇文。'
		);

		self::$messages['zh-yue'] = self::$messages['yue'];

		/** Simplified Chinese (‪中文(简体)‬)
		 * @author Shinjiman
		 */
		self::$messages['zh-hans'] = array(
			'intersection-desc' => '输出一个点列最近在分类中的项目，或者系数个分类的一个联系',
			'intersection_toomanycats' => 'DynamicPageList: 太多分类!',
			'intersection_toofewcats' => 'DynamicPageList: 太少分类!',
			'intersection_noresults' => 'DynamicPageList: 没有结果!',
			'intersection_noincludecats' => 'DynamicPageList: 您需要去包含最少一个分类，或者指定一个空间名!',
			'dpl-desc' => '一个给MediaWiki的高弹性报告产生器',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "错误: 错误的 '$0' 参数: '$1'! 帮助:  <code>$0= <i>空白字符串</i> (主)$3</code>。",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> '错误: 过多分类! 最大值: $0。 帮助: 增加 <code>ExtDynamicPageList::$maxCategoryCount</code> 的值去指定更多的分类或设定 <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> 以解除限制。 (当加上 <code>DynamicPageList.php</code>后，在<code>LocalSettings.php</code>中设定变量。)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> '错误: 过少分类! 最小值: $0。 帮助: 减少 <code>ExtDynamicPageList::$minCategoryCount</code> 的值去指定更少的分类。 (当加上 <code>DynamicPageList.php</code>后，在<code>LocalSettings.php</code>中设定一个合适的变量。)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "错误: 如果您想用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd' ，您需要包含最少一个分类!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "错误: 如果您包含多一个分类，您不可以用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> '错误: 您不可以在一个时间里加入多于一种的日期!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "错误: 你只可以用 'ordermethod=[...,]$1' 在 '$0' 上!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=>		  self::$messages['en']['dpl_log_' . self::FATAL_NOCLVIEW],
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "警告: 不明的参数 '$0' 被忽略。 帮助: 可用的参数: <code>$1</code>。",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "警告: 错误的 '$0' 参数: '$1'! 正在使用默认值: '$2'。 帮助: <code>$0= $3</code>。",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "警告: 错误的 '$0' 参数: '$1'! 正在使用默认值: '$2' (没有上限)。 帮助: <code>$0= <i>空白字符串</i> (没有上限) | n</code>, <code>n</code>是一个正整数。",
			'dpl_log_' . self::WARN_NORESULTS					=> '警告: 无结果!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "警告: 加入* 参数 ('adduser', 'addeditdate', 等)' 是对 'mode=category' 没有作用。只有页面空间名／标题才可以在这个模式度看到。",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "警告: 在单一部件中， 'ordermethod' 用 'headingmode=$0' 是没有作用的。 正在使用: '$1'。 帮助: 你可以用非$1 'headingmode' 数值，在多个部件中用 'ordermethod' 。第一个部是用来作标题。例如在分类标题中用 'ordermethod=category,<i>comp</i>' (<i>comp</i>是另外一个部件) 。",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "警告: 'debug=$0' 不是第一个在DPL元素嘅第一位置。新的除错设定在所有参数都能处理和检查前都不会应用。",
			'dpl_log_' . self::DEBUG_QUERY 						=> '查訽: <code>$0</code>',
			'dpl_articlecount' 									=> '在这个标题中有$1篇条目。'
		);


		self::$messages['zh-cn'] = self::$messages['zh-hans'];
		self::$messages['zh-my'] = self::$messages['zh-hans'];
		self::$messages['zh-sg'] = self::$messages['zh-hans'];

		/** Traditional Chinese (‪中文(繁體)‬)
		 * @author Shinjiman
		 */
		self::$messages['zh-hant'] = array(
			'intersection-desc' => '輸出一個點列最近在分類中的項目，或者係數個分類的一個聯繫',
			'intersection_toomanycats' => 'DynamicPageList: 太多分類!',
			'intersection_toofewcats' => 'DynamicPageList: 太少分類!',
			'intersection_noresults' => 'DynamicPageList: 沒有結果!',
			'intersection_noincludecats' => 'DynamicPageList: 您需要去包含最少一個分類，或者指定一個空間名!',
			'dpl-desc' => '一個給MediaWiki的高彈性報告產生器',
			'dpl_log_' . self::FATAL_WRONGNS 					=> "錯誤: 錯誤的 '$0' 參數: '$1'! 說明:  <code>$0= <i>空白字串</i> (主)$3</code>。",
			'dpl_log_' . self::FATAL_TOOMANYCATS				=> '錯誤: 過多分類! 最大值: $0。 說明: 增加 <code>ExtDynamicPageList::$maxCategoryCount</code> 的值去指定更多的分類或設定 <code>ExtDynamicPageList::$allowUnlimitedCategories=true</code> 以解除限制。 (當加上 <code>DynamicPageList.php</code>後，在<code>LocalSettings.php</code>中設定變數。)',
			'dpl_log_' . self::FATAL_TOOFEWCATS					=> '錯誤: 過少分類! 最小值: $0。 說明: 減少 <code>ExtDynamicPageList::$minCategoryCount</code> 的值去指定更少的分類。 (當加上 <code>DynamicPageList.php</code>後，在<code>LocalSettings.php</code>中設定一個合適的變數。)',
			'dpl_log_' . self::FATAL_NOSELECTION				=> "ERROR: No selection criteria found! You must use at least one of the following parameters: category, namespace, titlematch, linksto, uses, createdby, modifiedby, lastmodifiedby or their 'not' variants",
			'dpl_log_' . self::FATAL_CATDATEBUTNOINCLUDEDCATS	=> "錯誤: 如果您想用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd' ，您需要包含最少一個分類!",
			'dpl_log_' . self::FATAL_CATDATEBUTMORETHAN1CAT		=> "錯誤: 如果您包含多一個分類，您不可以用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd'!",
			'dpl_log_' . self::FATAL_MORETHAN1TYPEOFDATE		=> '錯誤: 您不可以在一個時間裡加入多於一種的日期!',
			'dpl_log_' . self::FATAL_WRONGORDERMETHOD			=> "錯誤: 你只可以用 'ordermethod=[...,]$1' 在 '$0' 上!",
			'dpl_log_' . self::FATAL_DOMINANTSECTIONRANGE		=> "ERROR: the index for the dominant section must be between 1 and the number of arguments of includepage ($0 in this case)",
			'dpl_log_' . self::FATAL_NOCLVIEW 					=>		  self::$messages['en']['dpl_log_' . self::FATAL_NOCLVIEW],
			'dpl_log_' . self::FATAL_OPENREFERENCES				=> 'ERROR: specifying "openreferences" is incompatible with some other option you specified. See the manual for details.',
			'dpl_log_' . self::WARN_UNKNOWNPARAM				=> "警告: 不明的參數 '$0' 被忽略。 說明: 可用的參數: <code>$1</code>。",
			'dpl_log_' . self::WARN_WRONGPARAM					=> "警告: 錯誤的 '$0' 參數: '$1'! 正在使用預設值: '$2'。 說明: <code>$0= $3</code>。",
			'dpl_log_' . self::WARN_WRONGPARAM_INT				=> "警告: 錯誤的 '$0' 參數: '$1'! 正在使用預設值: '$2' (沒有上限)。 說明: <code>$0= <i>空白字串</i> (沒有上限) | n</code>, <code>n</code>是一個正整數。",
			'dpl_log_' . self::WARN_NORESULTS					=> '警告: 無結果!',
			'dpl_log_' . self::WARN_CATOUTPUTBUTWRONGPARAMS		=> "警告: 加入* 參數 ('adduser', 'addeditdate', 等)' 是對 'mode=category' 沒有作用。只有頁面空間名／標題才可以在這個模式度看到。",
			'dpl_log_' . self::WARN_HEADINGBUTSIMPLEORDERMETHOD	=> "警告: 在單一部件中， 'ordermethod' 用 'headingmode=$0' 是沒有作用的。 正在使用: '$1'。 說明: 你可以用非$1 'headingmode' 數值，在多個部件中用 'ordermethod' 。第一個部是用來作標題。例如在分類標題中用 'ordermethod=category,<i>comp</i>' (<i>comp</i>是另外一個部件) 。",
			'dpl_log_' . self::WARN_DEBUGPARAMNOTFIRST			=> "警告: 'debug=$0' 不是第一個在DPL元素嘅第一位置。新的除錯設定在所有參數都能處理和檢查前都不會應用。",
			'dpl_log_' . self::DEBUG_QUERY 						=> '查訽: <code>$0</code>',
			'dpl_articlecount' 									=> '在這個標題中有$1篇條目。'
		);

		self::$messages['zh-hk'] = self::$messages['zh-hant'];
		self::$messages['zh-mo'] = self::$messages['zh-hant'];
		self::$messages['zh-tw'] = self::$messages['zh-hant'];

		return self::$messages;
	}
}
