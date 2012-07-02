<?php
/**
 * Internationalisation file for extension FramedVideo.
 */

$messages = array();

$messages['en'] = array(
	'framedvideo_default_width' => '270', # do not translate or duplicate this message to other languages
	'framedvideo_force_default_size' => 'false', # do not translate or duplicate this message to other languages
	'framedvideo_max_width' => '852', # do not translate or duplicate this message to other languages
	'framedvideo_max_height' => '510', # do not translate or duplicate this message to other languages
	'framedvideo_allow_full_screen' => 'true', # do not translate or duplicate this message to other languages
	'framedvideo_force_allow_full_screen' => 'false', # do not translate or duplicate this message to other languages
	'framedvideo_frames' => 'true', # do not translate or duplicate this message to other languages
	'framedvideo_force_frames' => 'false', # do not translate or duplicate this message to other languages
	'framedvideo_force_position' => 'false', # do not translate or duplicate this message to other languages
	'framedvideo_position' => 'right', # only translate this message to other languages if you have to change it
	'framedvideo_errors' => 'Multiple errors have occurred!',
	'framedvideo_error' => 'An error has occurred!',
	'framedvideo_error_unknown_type' => 'Unknown video service id ("$1"): check "type" parameter.',
	'framedvideo_error_no_id_given' => 'Missing "id" parameter.',
	'framedvideo_error_height_required' => 'Video type "$1" requires "height" parameter.',
	'framedvideo_error_height_required_not_only_width' => 'Video type "$1" requires "height" parameter, not only "width" parameter.',
	'framedvideo_error_width_too_big' => 'Given value of "width" parameter is too large.',
	'framedvideo_error_height_too_big' => 'Given value of "height" parameter is too large.',
	'framedvideo_error_no_integer' => 'Given value of "$1" is not a positive number.',
	'framedvideo_error_limit' => 'The highest allowed value is $1.',
	'framedvideo_error_full_size_not_allowed' => 'Value "full" for "size" parameter not allowed for video service id "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|More about syntax]].',
	'framedvideo_error_height_and_width_required' => 'Video type "$1" requires "height" and "width2" or "width" parameters.',
	'framedvideo-desc' => 'Allows embedding videos from various websites using the tag <code>&lt;video&gt;</code>',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'framedvideo_position' => '{{optional}}
Consider using "left" for right to left languages. Should left untranslated for other languages.',
	'framedvideo_error_unknown_type' => '{{doc-important|Do not translate "type".}}',
	'framedvideo_error_no_id_given' => '{{doc-important|Do not translate "id".}}',
	'framedvideo_error_height_required' => '{{doc-important|Do not translate "height".}}',
	'framedvideo_error_height_required_not_only_width' => '{{doc-important|Do not translate "height" and "width".}}',
	'framedvideo_error_width_too_big' => '{{doc-important|Do not translate "width".}}',
	'framedvideo_error_height_too_big' => '{{doc-important|Do not translate "height".}}',
	'framedvideo_error_full_size_not_allowed' => '{{doc-important|Do not translate "full" and "size".}}',
	'framedvideo_helppage' => '{{doc-important|Leave "Help:" untranslated.}}
Link to the help page for the extension Framed Video.',
	'framedvideo_error_height_and_width_required' => '{{doc-important|Do not translate "height", "width2", or "width".}}',
	'framedvideo-desc' => '{{desc}}',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'framedvideo_position' => 'left',
	'framedvideo_errors' => 'حدثت أخطاء متعددة!',
	'framedvideo_error' => 'حدث خطأ!',
	'framedvideo_error_unknown_type' => 'رقم خدمة فيديو غير معروف ("$1"): تحقق من المحدد "type".',
	'framedvideo_error_no_id_given' => 'محدد "id" ناقص.',
	'framedvideo_error_height_required' => 'نوع الفيديو "$1" يتطلب المحدد "height".',
	'framedvideo_error_height_required_not_only_width' => 'نوع الفيديو "$1" يتطلب المحدد "height"، وليس فقط المحدد "width".',
	'framedvideo_error_width_too_big' => 'القيمة المعطاة لمحدد "width" كبيرة جدا.',
	'framedvideo_error_height_too_big' => 'القيمة المعطاة لمحدد "height" كبيرة جدا.',
	'framedvideo_error_no_integer' => 'القيمة المعطاة ل"$1" ليست رقما موجبا.',
	'framedvideo_error_limit' => 'أعلى قيمة مسموح بها هي $1.',
	'framedvideo_error_full_size_not_allowed' => 'القيمة "full" للمحدد "size" غير مسموح بها لرقم خدمة الفيديو "$1".',
	'framedvideo_helppage' => 'Help:فيديو',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|المزيد حول الصياغة]].',
	'framedvideo_error_height_and_width_required' => 'نوع الفيديو "$1" يتطلب المحددين "height" و "width2" أو "width".',
	'framedvideo-desc' => 'يسمح بتضمين الفيديو من مواقع ويب متعددة باستخدام الوسم <code>&lt;video&gt;</code>',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'framedvideo_helppage' => 'Help:ܒܝܕܝܘ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'framedvideo_errors' => 'حدثت أخطاء متعددة!',
	'framedvideo_error' => 'حدث خطأ!',
	'framedvideo_error_unknown_type' => 'رقم خدمة فيديو غير معروف ("$1"): تحقق من المحدد "type".',
	'framedvideo_error_no_id_given' => 'محدد "id" ناقص.',
	'framedvideo_error_height_required' => 'نوع الفيديو "$1" يتطلب المحدد "height".',
	'framedvideo_error_height_required_not_only_width' => 'نوع الفيديو "$1" يتطلب المحدد "height"، وليس فقط المحدد "width".',
	'framedvideo_error_width_too_big' => 'القيمة المعطاة لمحدد "width" كبيرة جدا.',
	'framedvideo_error_height_too_big' => 'القيمة المعطاة لمحدد "height" كبيرة جدا.',
	'framedvideo_error_no_integer' => 'القيمة المعطاة ل"$1" ليست رقما موجبا.',
	'framedvideo_error_limit' => 'أعلى قيمة مسموح بها هى $1.',
	'framedvideo_error_full_size_not_allowed' => 'القيمة "full" للمحدد "size" غير مسموح بها لرقم خدمة الفيديو "$1".',
	'framedvideo_helppage' => 'Help:فيديو',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|المزيد حول الصياغة]].',
	'framedvideo_error_height_and_width_required' => 'نوع الفيديو "$1" يتطلب المحددين "height" و "width2" أو "width".',
	'framedvideo-desc' => 'يسمح بتضمين الفيديو من مواقع ويب متعددة باستخدام الوسم <code>&lt;video&gt;</code>',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'framedvideo_errors' => 'Узьніклі шматлікія памылкі!',
	'framedvideo_error' => 'Узьнікла памылка!',
	'framedvideo_error_unknown_type' => 'Невядомы ідэнтыфікатар відэа-сэрвісу («$1»): праверце парамэтар «type».',
	'framedvideo_error_no_id_given' => 'Няма парамэтру «id».',
	'framedvideo_error_height_required' => 'Тып відэа «$1» патрабуе парамэтар «height».',
	'framedvideo_error_height_required_not_only_width' => 'Тып відэа «$1» патрабуе парамэтар «height», ня толькі парамэтар «width».',
	'framedvideo_error_width_too_big' => 'Пададзенае значэньне парамэтру «width» занадта вялікае.',
	'framedvideo_error_height_too_big' => 'Пададзенае значэньне парамэтру «height» занадта вялікае.',
	'framedvideo_error_no_integer' => 'Пададзенае значэньне «$1» не зьяўляецца дадатным лікам.',
	'framedvideo_error_limit' => 'Самым вялікім дазволеным значэньнем зьяўляецца $1.',
	'framedvideo_error_full_size_not_allowed' => 'Значэньне «full» для парамэтру «size» недапушчальнае для відэа-сэрвісу з ідэнтыфікатарам «$1».',
	'framedvideo_helppage' => 'Help:Відэа',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Падрабязьней пра сынтаксіс]].',
	'framedvideo_error_height_and_width_required' => 'Тып відэа «$1» патрабуе парамэтры «height» і «width2» ці «width».',
	'framedvideo-desc' => 'Дазваляе убудоўваць відэа з розных сайтаў з дапамогай тэга <code>&lt;video&gt;</code>',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'framedvideo_error' => 'Възникна грешка!',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'framedvideo_errors' => 'একাধিক ত্রুটি দেখা দিয়েছে!',
	'framedvideo_error' => 'একটি ত্রুটি দেখা দিয়েছে!',
	'framedvideo_helppage' => 'Help:ভিডিও',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'framedvideo_position' => 'dehou',
	'framedvideo_errors' => "Meur a fazi zo c'hoarvezet !",
	'framedvideo_error' => 'Ur fazi zo bet !',
	'framedvideo_error_unknown_type' => 'Dianav eo ID ar servij  video ("$1") : adwelit an arventenn "seurt".',
	'framedvideo_error_no_id_given' => 'Mankout a ra an arventenn "id".',
	'framedvideo_error_height_required' => 'Ar seurt video "$1" en deus ezhomm eus an arventenn "height".',
	'framedvideo_error_height_required_not_only_width' => 'Ar seurt video "$1" en deus ezhomm eus an arventenn "height", ha ket hepken an arventenn "width".',
	'framedvideo_error_width_too_big' => 'Re vras eo an talvoudenn bet roet d\'an arventenn "width".',
	'framedvideo_error_height_too_big' => 'Re vras eo an talvoudenn bet roet d\'an arventenn "height".',
	'framedvideo_error_no_integer' => 'An dalvoudenn roet "$1" n\'eo ket un niver pozitivel.',
	'framedvideo_error_limit' => '$1 eo an dalvoudenn uhelañ aotreet.',
	'framedvideo_error_full_size_not_allowed' => 'N\'eo ket aotreet an talvoudenn "full" evit an arventenn "size" evit ar servij video gant ID "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => "[[{{MediaWiki:Framedvideo_helppage}}|Muioc'h a ditouroù da geñver an ereadurezh]].",
	'framedvideo_error_height_and_width_required' => 'Ar seurt video "$1" en deus ezhomm eus an arventennoù "height" pe "width2" pe "width".',
	'framedvideo-desc' => "Aotreañ a ra da ouzhpennañ videioù eus lec'hiennoù wed disheñvel en ur implijout ar balizenn <code>&lt;video&gt;</code>",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'framedvideo_position' => 'desno',
	'framedvideo_errors' => 'Desilo se više poruke!',
	'framedvideo_error' => 'Nastala je greška!',
	'framedvideo_error_unknown_type' => 'Nepoznat id video usluge ("$1"): provjerite parametar "type".',
	'framedvideo_error_no_id_given' => 'Nedostaje parametar "id".',
	'framedvideo_error_height_required' => 'Video tipa "$1" zahtijeva parametar "height".',
	'framedvideo_error_height_required_not_only_width' => 'Video tipa "$1" zahtijeva parametar "height", ne samo parametar "width".',
	'framedvideo_error_width_too_big' => 'Navedena vrijednost parametra "width" je prevelika.',
	'framedvideo_error_height_too_big' => 'Navedena vrijednost parametra "height" je prevelika.',
	'framedvideo_error_no_integer' => 'Navedena vrijednost "$1" nije pozitivan broj.',
	'framedvideo_error_limit' => 'Najveća dopuštena vrijednost je $1.',
	'framedvideo_error_full_size_not_allowed' => 'Vrijednosti parametara "full" i "size" nisu dopuštene za id video usluge "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Više o sintaksi]].',
	'framedvideo_error_height_and_width_required' => 'Video tipa "$1" zahtijeva parametre "height" i "width2" ili "width".',
	'framedvideo-desc' => 'Omogućuje uključivanje video snimaka sa raznih web stranica koristeći oznaku <code>&lt;video&gt;</code>',
);

/** Catalan (Català)
 * @author Paucabot
 * @author Qllach
 */
$messages['ca'] = array(
	'framedvideo_errors' => "S'han produït diversos errors!",
	'framedvideo_error' => 'Hi ha hagut un error!',
	'framedvideo_error_no_id_given' => 'Manca el paràmetre "id".',
	'framedvideo_error_limit' => 'El valor màxim permès és $1.',
	'framedvideo_helppage' => 'Help:Vídeo',
	'framedvideo-desc' => "Permet incrustar vídeos de diversos llocs web mitjançant l'etiqueta <code>&lt;video&gt;</code>",
);

/** Czech (Česky)
 * @author Jkjk
 */
$messages['cs'] = array(
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Více o syntaxi]].',
	'framedvideo_error_height_and_width_required' => 'Typ videa "$1" vyžaduje parametry "height" a "width2" nebo parametr "width".',
	'framedvideo-desc' => 'Umožňuje vkládání videií z různých webových stránek za použití tagu <code>&lt;video&gt;</code>',
);

/** Danish (Dansk)
 * @author BabelFrode
 */
$messages['da'] = array(
	'framedvideo_errors' => 'Forskellige fejl er opstået!',
	'framedvideo_error' => 'En fejl opstod!',
	'framedvideo_error_unknown_type' => 'Ubekendt videotjeneste-id ("$1"): Tjek "type" parameteren.',
	'framedvideo_error_no_id_given' => 'Manglende "id" parameter.',
	'framedvideo_error_height_required' => 'Videotypen "$1" behøver "height"-parameteren.',
	'framedvideo_error_height_required_not_only_width' => 'Videotypen "$1" behøver "height", ikke kun "width"-parameteren.',
	'framedvideo_error_width_too_big' => 'Den opgivede værdi for "width" er for høj.',
	'framedvideo_error_height_too_big' => 'Den opgivede værdi for "height" er for høj.',
	'framedvideo_error_no_integer' => 'Den opgivne værdi for "$1" er ikke et positivt tal.',
	'framedvideo_error_limit' => 'Den højeste tilladte værdi er $1.',
	'framedvideo_error_full_size_not_allowed' => 'Værdien "full" i "size"-parameteren er ikke tilladt for videotjenesten "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mere om syntaks]].',
	'framedvideo_error_height_and_width_required' => 'Videotypen "$1" behøver "height" og "width2"- eller "width"-parametre.',
	'framedvideo-desc' => 'Tillader indlejring af videoer fra forskellige websites vha. taggen <code>&lt;video&gt;</code>',
);

/** German (Deutsch)
 * @author Umherirrender
 * @author ✓
 */
$messages['de'] = array(
	'framedvideo_position' => 'rechts',
	'framedvideo_errors' => 'Mehrere Fehler sind aufgetreten!',
	'framedvideo_error' => 'Ein Fehler ist aufgetreten!',
	'framedvideo_error_unknown_type' => 'Unbekannte Video-Service-ID („$1“): prüfe den Parameter „type“.',
	'framedvideo_error_no_id_given' => 'Der Parameter „id“ fehlt.',
	'framedvideo_error_height_required' => 'Der Videotyp „$1“ erfordert den Parameter „height“.',
	'framedvideo_error_height_required_not_only_width' => 'Der Videotyp „$1“ erfordert den Parameter „height“, nicht nur den Parameter „width“.',
	'framedvideo_error_width_too_big' => 'Der Wert für „width“ ist zu groß.',
	'framedvideo_error_height_too_big' => 'Der Wert für „height“ ist zu groß.',
	'framedvideo_error_no_integer' => 'Der Wert für „$1“ ist keine positive Zahl.',
	'framedvideo_error_limit' => 'Der größe erlaubte Wert ist $1.',
	'framedvideo_error_full_size_not_allowed' => 'Wert „full“ von dem Parameter „size“ ist nicht erlaubt für die Video-Service-ID „$1“.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mehr über die Syntax]].',
	'framedvideo_error_height_and_width_required' => 'Der Videotyp „$1“ erfordert den Parameter „height“ und einen Parameter „width2“ oder „width“.',
	'framedvideo-desc' => 'Ermöglicht das Einbinden von Videos von verschiedensten Webseiten mithilfe des <code>&lt;video&gt;</code>-Tags.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'framedvideo_errors' => 'Někotare zmólki su nastali!',
	'framedvideo_error' => 'Zmólka jo nastała!',
	'framedvideo_error_unknown_type' => 'Njeznaty ID wideosłužby ("$1"): kontrolěruj parameter "type".',
	'framedvideo_error_no_id_given' => 'Felujucy parameter "id".',
	'framedvideo_error_height_required' => 'Wideotyp "$1" pomina se parameter "height".',
	'framedvideo_error_height_required_not_only_width' => 'Wideotyp "$1" pomina se parameter "height", nic jano parameter "width".',
	'framedvideo_error_width_too_big' => 'Pódana gódnota parametra "width" jo pśewjelika.',
	'framedvideo_error_height_too_big' => 'Pódana gódnota parametra "height" jo pśewjelika.',
	'framedvideo_error_no_integer' => 'Pódana gódnota "$1" njejo pozitiwna licba.',
	'framedvideo_error_limit' => 'Nejwuša dowólona gódnota jo $1.',
	'framedvideo_error_full_size_not_allowed' => 'Gódnota "full" parametra "size" njejo dowólona za id wideosłužby "$1".',
	'framedvideo_helppage' => 'Help:Wideo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Wěcej wó syntaksy]].',
	'framedvideo_error_height_and_width_required' => 'Wideotyp "$1" pomina se parametry "height" a "width2" abo "width".',
	'framedvideo-desc' => 'Zmóžnja zasajźowanje wideo z wšakich websedłow z pomocu toflicki <code>&lt;video&gt;</code>',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 */
$messages['el'] = array(
	'framedvideo_errors' => 'Εμφανίστηκαν πολλαπλά σφάλματα!',
	'framedvideo_error' => 'Εμφανίστηκε ένα σφάλμα!',
	'framedvideo_error_unknown_type' => 'Άγνωστη ταυτότητα υπηρεσίας βίντεο ("$1"): ελέγξτε την παράμετρο "type".',
	'framedvideo_error_no_id_given' => 'Η παράμετρος "id" λείπει.',
	'framedvideo_error_height_required' => 'Ο τύπος βίντεο "$1" απαιτεί την παράμετρο "height".',
	'framedvideo_error_height_required_not_only_width' => 'Ο τύπος βίντεο "$1" απαιτεί την παράμετρο "height", όχι μόνο την παράμετρο "width".',
	'framedvideo_error_width_too_big' => 'Η δοθείσα τιμή της παραμέτρου "width" είναι πολύ μεγάλη.',
	'framedvideo_error_height_too_big' => 'Η δοθείσα τιμή της παραμέτρου "height" είναι πολύ μεγάλη.',
	'framedvideo_error_no_integer' => 'Η δοθείσα τιμή της "$1" δεν είναι θετικός αριθμός.',
	'framedvideo_error_limit' => 'Η μέγιστη επιτρεπόμενη τιμή είναι $1.',
	'framedvideo_error_full_size_not_allowed' => 'Η τιμή "full" για την παράμετρο "size" δεν επιτρέπεται για την ταυτότητα υπηρεσίας βίντεο "$1".',
	'framedvideo_helppage' => 'Help:Βίντεο',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Περισσότερα για το συντακτικό]].',
	'framedvideo_error_height_and_width_required' => 'Ο τύπος βίντεο "$1" απαιτεί τις παραμέτρους "height" και "width2" ή την παράμετρο "width".',
	'framedvideo-desc' => 'Επιτρέπει την ενσωμάτωση βίντεο από διάφορους ιστοτόπους χρησιμοποιώντας την ετικέτα <code>&lt;video&gt;</code>',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'framedvideo_errors' => 'Pluraj eraroj okazis!',
	'framedvideo_error' => 'Eraro okazis!',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Translationista
 */
$messages['es'] = array(
	'framedvideo_errors' => 'Múltiples errores han ocurrido!',
	'framedvideo_error' => 'Un error ha ocurrido!',
	'framedvideo_error_unknown_type' => 'Id de servicio de video desconocido ("$1"): Marca el parámetro "tipo".',
	'framedvideo_error_no_id_given' => 'Parámetro "id" faltante.',
	'framedvideo_error_height_required' => 'Tipo de video "$1" requiere parámetro "height".',
	'framedvideo_error_height_required_not_only_width' => 'Tipo de video "$1" requiere parámetro "height", no solamente parámetro "width".',
	'framedvideo_error_width_too_big' => 'Valor dado de parámetro "width" es demasiado grande.',
	'framedvideo_error_height_too_big' => 'Valor dado de parámetro "heigth" es demasiado largo.',
	'framedvideo_error_no_integer' => 'Valor dado de "$1" no es un número positivo.',
	'framedvideo_error_limit' => 'El valor permitido más alto es $1.',
	'framedvideo_error_full_size_not_allowed' => 'Valor "full" para parámetro "size" no permitido para servicio de video id "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Más información acerca de sintaxis]].',
	'framedvideo_error_height_and_width_required' => 'Tipo de video "$1" requiere parámetros "height" y "width2" o "width".',
	'framedvideo-desc' => 'Permite incrustar videos de varios sitios web mediante la etiqueta <code>&lt;video&gt;</code>',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'framedvideo_helppage' => 'Help:Bideoa',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'framedvideo_errors' => 'Tapahtui useita virheitä!',
	'framedvideo_error' => 'Tapahtui virhe!',
	'framedvideo_error_unknown_type' => 'Tuntematon  videopalvelutunnus ("$1"): tarkista "tyyppi"-parametri.',
	'framedvideo_error_no_id_given' => 'Parametri "id" puuttuu.',
	'framedvideo_error_height_required' => 'Videotyyppi "$1" vaatii "height"-parametrin.',
	'framedvideo_error_height_required_not_only_width' => 'Videotyyppi "$1" vaatii "height"-parametrin, ei vain "width"-parametrin.',
	'framedvideo_error_width_too_big' => 'Parametrille "width" annettu arvo on liian iso.',
	'framedvideo_error_height_too_big' => 'Parametrille "height" annettu arvo on liian iso.',
	'framedvideo_error_no_integer' => 'Annettu arvo "$1" ei ole positiivinen luku.',
	'framedvideo_error_limit' => 'Korkein sallittu arvo on $1.',
	'framedvideo_error_full_size_not_allowed' => 'Arvo "full" parametrille "size" ei ole sallittu videopalvelutunnukselle "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Lisätietoja syntaksista]].',
	'framedvideo_error_height_and_width_required' => 'Videotyyppi "$1" vaatii parametrit "height" ja "width2" tai "width".',
	'framedvideo-desc' => 'Mahdollistaa videoiden upottamisen eri verkkosivuilta käyttäen elementtiä <code>&lt;video&gt;</code>.',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'framedvideo_errors' => 'Des erreurs multiples sont survenues !',
	'framedvideo_error' => 'Une erreur est survenue !',
	'framedvideo_error_unknown_type' => 'ID de service vidéo inconnu (« $1 ») : vérifiez le paramètre « type ».',
	'framedvideo_error_no_id_given' => 'Paramètre « id » manquant.',
	'framedvideo_error_height_required' => 'Le type de vidéo « $1 » requiert le paramètre « height ».',
	'framedvideo_error_height_required_not_only_width' => 'Le type de vidéo « $1 » requiert le paramètre « height », pas seulement le paramètre « width ».',
	'framedvideo_error_width_too_big' => 'La valeur du paramètre « width » est trop grande.',
	'framedvideo_error_height_too_big' => 'La valeur du paramètre « height » est trop grande.',
	'framedvideo_error_no_integer' => "La valeur donnée « $1 » n'est pas un nombre positif.",
	'framedvideo_error_limit' => 'La plus grande valeur autorisée est $1.',
	'framedvideo_error_full_size_not_allowed' => "La valeur « full » pour le paramètre « size » n'est pas autorisée pour le service vidéo d'ID « $1 ».",
	'framedvideo_helppage' => 'Help:Vidéo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Plus à propos de la syntaxe]].',
	'framedvideo_error_height_and_width_required' => 'Le type de vidéo « $1 » requiert les paramètres « height » et « width2 »  ou « width ».',
	'framedvideo-desc' => "Permet d'intégrer des vidéos de différents sites web en utilisant la balise <code>&lt;video&gt;</code>",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'framedvideo_errors' => 'Un mouél d’èrrors sont arrevâs !',
	'framedvideo_error' => 'Una èrror est arrevâ !',
	'framedvideo_error_unknown_type' => 'Numerô de sèrviço vidèô encognu (« $1 ») : controlâd lo paramètre « type ».',
	'framedvideo_error_no_id_given' => 'Paramètre « id » manquent.',
	'framedvideo_helppage' => 'Help:Vidèô',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'framedvideo_errors' => 'Producíronse varios erros!',
	'framedvideo_error' => 'Produciuse un erro!',
	'framedvideo_error_unknown_type' => 'ID de servizo de vídeo descoñecido ("$1"): verifique o parámetro "type".',
	'framedvideo_error_no_id_given' => 'Falta o parámetro "id".',
	'framedvideo_error_height_required' => 'O tipo de vídeo "$1" precisa do parámetro "height".',
	'framedvideo_error_height_required_not_only_width' => 'O tipo de vídeo "$1" precisa do parámetro "height", e non só do parámetro "width".',
	'framedvideo_error_width_too_big' => 'O valor dado ao parámetro "width" é moi grande.',
	'framedvideo_error_height_too_big' => 'O valor dado ao parámetro "height" é moi grande.',
	'framedvideo_error_no_integer' => 'O valor dado a "$1" non é un número positivo.',
	'framedvideo_error_limit' => 'O valor máis grande permitido é $1.',
	'framedvideo_error_full_size_not_allowed' => 'O valor "full" para o parámetro "size" non está permitido para o id do servizo de vídeo "$1".',
	'framedvideo_helppage' => 'Help:Vídeo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Máis información sobre a sintaxe]].',
	'framedvideo_error_height_and_width_required' => 'O tipo de vídeo "$1" precisa dos parámetros "height" e "width2" ou "width".',
	'framedvideo-desc' => 'Permite embelecer os vídeos de varios sitios web usando a etiqueta <code>&lt;video&gt;</code>',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'framedvideo_errors' => 'S het e Hufe Fähler gee!',
	'framedvideo_error' => 'S het e Fähler gee!',
	'framedvideo_error_unknown_type' => 'Nit bekannti Videoservice ID ("$1"): prief "type" Parameter.',
	'framedvideo_error_no_id_given' => '"id"-Parameter fählt.',
	'framedvideo_error_height_required' => 'Videotyp "$1" bruucht "height"-Parameter.',
	'framedvideo_error_height_required_not_only_width' => 'Videotyp "$1" bruucht nit nume dr "width"-Parameter, s bruucht au dr "height"-Parameter.',
	'framedvideo_error_width_too_big' => 'Dr Wärt, wu fir dr "width"-Parameter aagee isch, isch z groß.',
	'framedvideo_error_height_too_big' => 'Dr Wärt, wu fir dr "height"-Parameter aagee isch, isch z groß.',
	'framedvideo_error_no_integer' => 'Dr Wärt wu fir "$1" aagee isch, isch kei positivi Zahl.',
	'framedvideo_error_limit' => 'Dr hegscht erlaubt Wärt isch $1.',
	'framedvideo_error_full_size_not_allowed' => 'Dr Wärt "full" fir dr "size"-Parameter isch nit erlaubt fir Videoservice ID "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Meh iber d Syntax]].',
	'framedvideo_error_height_and_width_required' => 'Videotyp "$1" bruucht "height" un "width2" oder "width"-Parameter.',
	'framedvideo-desc' => 'Erlaubt s Yybette vu Video vu verschidene Website mit em Tag <code>&lt;video&gt;</code>',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'framedvideo_errors' => 'ארעו מספר שגיאות!',
	'framedvideo_error' => 'ארעה שגיאה!',
	'framedvideo_error_unknown_type' => 'מספר שירות הווידאו אינו ידוע ("$1"): בדקו את הפרמטר "type".',
	'framedvideo_error_no_id_given' => 'הפרמטר "id" חסר.',
	'framedvideo_error_height_required' => 'לסוג הווידאו "$1" נדרש הפרמטר "height".',
	'framedvideo_error_height_required_not_only_width' => 'לסוג הווידאו "$1" נדרש גם הפרמטר "height" ולא רק הפרמטר "width".',
	'framedvideo_error_width_too_big' => 'הערך שניתן לפרמטר "width" גדול מדי.',
	'framedvideo_error_height_too_big' => 'הערך שניתן לפרמטר "height" גדול מדי.',
	'framedvideo_error_no_integer' => 'הערך שניתן לפרמטר "$1" אינו מספר חיובי.',
	'framedvideo_error_limit' => 'הערך המורשה הגבוה ביותר הוא $1.',
	'framedvideo_error_full_size_not_allowed' => 'הערך "full" עבור הפרמטר "size" אינו מורשה עבור מספר שירות הווידאו "$1".',
	'framedvideo_helppage' => 'Help:וידאו',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|עוד אודות התחביר]].',
	'framedvideo_error_height_and_width_required' => 'סוג הווידאו "$1" דורש את הפרמטרים"height" ו־"width2" או "width".',
	'framedvideo-desc' => 'מתן האפשרות להטמעת וידאו מאתרים שונים באמצעות התגית <code>&lt;video&gt;</code>',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'framedvideo_errors' => 'Wjacore zmylki su wustupili!',
	'framedvideo_error' => 'Zmylk je wustupił!',
	'framedvideo_error_unknown_type' => 'Njeznaty ID widejosłužby ("$1"): přepruwuj parameter "type".',
	'framedvideo_error_no_id_given' => 'Falowacy parameter "id".',
	'framedvideo_error_height_required' => 'Widejotyp "$1" wužaduje sej parameter "height".',
	'framedvideo_error_height_required_not_only_width' => 'Widejotyp "$1" wužaduje sej parameter "height", nic jenož parameter "width".',
	'framedvideo_error_width_too_big' => 'Podata hódnota parametra "width" je přewulka.',
	'framedvideo_error_height_too_big' => 'Podata hódnota parametra "height" je přewulka.',
	'framedvideo_error_no_integer' => 'Podata hódnota "$1" pozitiwna ličba njeje.',
	'framedvideo_error_limit' => 'Najwyša dowolena hódnota je $1.',
	'framedvideo_error_full_size_not_allowed' => 'Hódnota "full" za parameter "size" njeje za id widejosłužby "$1" dowolena.',
	'framedvideo_helppage' => 'Help:Widejo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Wjace wo syntaksy]].',
	'framedvideo_error_height_and_width_required' => 'Widejotyp "$1" wužaduje sej parametry "height" a "width2" abo "width".',
	'framedvideo-desc' => 'Zmóžnja zasadźowanje widejow z wšelakich websydłow z pomocu taflički <code>&lt;video&gt;</code>',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'framedvideo_errors' => 'Több hiba történt!',
	'framedvideo_error' => 'Hiba történt!',
	'framedvideo_error_unknown_type' => 'Ismeretlen videószolgáltatás-azonosító („$1”): ellenőrizd a „type” paramétert.',
	'framedvideo_error_no_id_given' => 'Hiányzó „id” paraméter.',
	'framedvideo_error_height_required' => 'A(z) „$1” videótípusnál kötelező a „height” paraméter.',
	'framedvideo_error_height_required_not_only_width' => 'A(z) „$1” videótípusnál kötelező a „height” paraméter is, nem csak a „width” paraméter.',
	'framedvideo_error_width_too_big' => 'A „width” paraméter megadott értéke túl nagy.',
	'framedvideo_error_height_too_big' => 'A „height” paraméter megadott értéke túl nagy.',
	'framedvideo_error_no_integer' => 'A(z) „$1” megadott értéke nem pozitív szám.',
	'framedvideo_error_limit' => 'A legmagasabb megadható érték $1.',
	'framedvideo_error_full_size_not_allowed' => 'A „size” paraméternél nem használható a „full” érték $1 videószolgáltató-azonosító esetén.',
	'framedvideo_helppage' => 'Help:Videó',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|További segítség a szintaxisról]].',
	'framedvideo_error_height_and_width_required' => 'A(z) „$1” videótípusnál kötelező a „height” és „width2”, vagy a „width” paraméter.',
	'framedvideo-desc' => 'Lehetővé teszi videók beágyazását számos weboldalról a <code>&lt;video&gt;</code> tag segítségével',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'framedvideo_errors' => 'Multiple errores ha occurrite!',
	'framedvideo_error' => 'Un error ha occurrite!',
	'framedvideo_error_unknown_type' => 'ID de servicio video incognite ("$1"): verifica le parametro "type".',
	'framedvideo_error_no_id_given' => 'Le parametro "id" manca.',
	'framedvideo_error_height_required' => 'Le typo de video "$1" require le parametro "height".',
	'framedvideo_error_height_required_not_only_width' => 'Le typo de video "$1" require le parametro "height", e non solmente le parametro "width".',
	'framedvideo_error_width_too_big' => 'Le valor date del parametro "width" es troppo grande.',
	'framedvideo_error_height_too_big' => 'Le valor date del parametro "height" es troppo grande.',
	'framedvideo_error_no_integer' => 'Le valor date de "$1" non es un numero positive.',
	'framedvideo_error_limit' => 'Le maxime valor permittite es $1.',
	'framedvideo_error_full_size_not_allowed' => 'Le valor "full" pro le parametro "size" non es permittite pro le servicio video del ID "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Plus a proposito del syntaxe]].',
	'framedvideo_error_height_and_width_required' => 'Le typo de video "$1" require le parametros "height" e "width2" o "width".',
	'framedvideo-desc' => 'Permitte incastrar videos ab varie sitos web con le etiquetta <code>&lt;video&gt;</code>',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'framedvideo_errors' => 'Beberapa kesalahan terjadi!',
	'framedvideo_error' => 'Sebuah kesalahan terjadi!',
	'framedvideo_error_unknown_type' => 'Penyedia jasa video tidak diketahui id ("$1): cek parameter "type".',
	'framedvideo_error_no_id_given' => 'Parameter "id" tidak dicantumkan.',
	'framedvideo_error_height_required' => 'Jenis video "$1" membutuhkan parameter "height".',
	'framedvideo_error_height_required_not_only_width' => 'Jenis video "$1" membutuhkan parameter "height", tidak hanya parameter "width".',
	'framedvideo_error_width_too_big' => 'Nilai parameter "width" yang diberikan terlalu besar.',
	'framedvideo_error_height_too_big' => 'Nilai parameter "height" yang diberikan terlalu besar.',
	'framedvideo_error_no_integer' => 'Nilai "$1" yang diberikan bukan angka positif.',
	'framedvideo_error_limit' => 'Nilai terbesar yang diijinkan adalah $1.',
	'framedvideo_error_full_size_not_allowed' => 'Nilai parameter "full" dan "size" yang diberikan tidak diijinkan untuk penyedia jasa video id "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Lebih lanjut tentang sintaks]].',
	'framedvideo_error_height_and_width_required' => 'Jenis video "$1" membutuhkan parameter "height" dan "width" atau "width2".',
	'framedvideo-desc' => 'Mengijinkan memasang video dari berbagai situs web dengan menggunakan tag <code>&lt;video&gt;</code>',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'framedvideo_error' => 'Si è verificato un errore!',
	'framedvideo_helppage' => 'Help:Video',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'framedvideo_errors' => '複数のエラーが発生しました！',
	'framedvideo_error' => 'エラーが発生しました！',
	'framedvideo_error_unknown_type' => '不明な動画サービスID ("$1"): 引数 "type" を確かめてください。',
	'framedvideo_error_no_id_given' => '引数 "id" が不足しています。',
	'framedvideo_error_height_required' => '動画種別 "$1" には引数 "height" が必要です。',
	'framedvideo_error_height_required_not_only_width' => '動画種別 "$1" には、引数として "width" だけでなく、"height" が必要です。',
	'framedvideo_error_width_too_big' => '引数 "width" に指定した値が大きすぎます。',
	'framedvideo_error_height_too_big' => '引数 "height" に指定した値が大きすぎます。',
	'framedvideo_error_no_integer' => '引数 "$1" に指定した値が正の数ではありません。',
	'framedvideo_error_limit' => '許されている最大の値は $1です。',
	'framedvideo_error_full_size_not_allowed' => '動画サービスID "$1" に対しては、引数 "size" に値 "full" を指定することが認められていません。',
	'framedvideo_helppage' => 'Help:動画',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|構文の詳細]]',
	'framedvideo_error_height_and_width_required' => '動画種別 "$1" には、引数として "height" および、"width2" もしくは "width" が必要です。',
	'framedvideo-desc' => '<code>&lt;video&gt;</code> タグを使って、様々なウェブサイトからの動画を埋め込めるようにする',
);

/** Khmer (ភាសាខ្មែរ)
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'framedvideo_helppage' => 'Help: វិដេអូ',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'framedvideo_errors' => '여러 가지 오류가 발생했습니다!',
	'framedvideo_error' => '오류가 발생했습니다!',
	'framedvideo_error_unknown_type' => '비디어 서비스 ID("$1")를 알 수 없습니다: "type" 변수를 확인하십시오.',
	'framedvideo_error_no_id_given' => '"id" 변수가 없습니다.',
	'framedvideo_error_height_required' => '"$1" 비디오 종류에는 "height" 변수가 필요합니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'framedvideo_position' => 'right',
	'framedvideo_errors' => 'Ene Pöngel vun Fähler es opjetrodde!',
	'framedvideo_error' => 'Ene Fähler es opjetrodde!',
	'framedvideo_error_unknown_type' => '„$1“ es ene unbikannte Viddejo-Deens-Kennong — donn ens noh dämm „<code>type=</code>“ Parammeeter loore!',
	'framedvideo_error_no_id_given' => 'Dä Parrameeter „<code>id=</code>“ es nit doh.',
	'framedvideo_error_height_required' => 'De Zoot „$1“ Viddejo bruch ävver dä „<code>height=</code>“ Parrammeeter.',
	'framedvideo_error_height_required_not_only_width' => 'De Zoot „$1“ Viddejo bruch ävver och dä „<code>height=</code>“
Parrammeeter, nit nuur dä „<code>width=</code>“ Parrammeeter.',
	'framedvideo_error_width_too_big' => 'Dä Wäät fö dä „<code>width=</code>“ Parrammeeter eß ze jruuß.',
	'framedvideo_error_height_too_big' => 'Dä Wäät för dä „<code>height=</code>“ Parrammeeter es ze jruuß.',
	'framedvideo_error_no_integer' => 'Dä Wäät för dä „<code>$1=</code>“ Parrammeeter eß jedreße, un keij possitiive janze Zahl.',
	'framedvideo_error_limit' => 'Dä jrüüßte müjjeleshe Wäät eß $1.',
	'framedvideo_error_full_size_not_allowed' => 'Dä Wäät „full“ för dä „<code>eize=</code>“ Parrammeeter eß fö dä Viddejo-Deenß met dä Kännong „$1“ nit zohjelohße .',
	'framedvideo_helppage' => 'Help:Viddejo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mieh övver de <code>&lt;video&gt;</code> Syntax]].',
	'framedvideo_error_height_and_width_required' => 'De Viddejo Zoot „$1“ bruch dä „<code>height=</code>“ Parrmeeter, un dä „<code>width2=</code>“ udder dä „<code>width=</code>“ Parrammeeter.',
	'framedvideo-desc' => 'Määt et müjjlesh, Viddejos uß ungerscheidleshe Websigge em Wiki
enzebenge, övver dä <code>&lt;video&gt;=</code>“ Befähl.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'framedvideo_errors' => 'Et si méi Feeler virkomm!',
	'framedvideo_error' => 'Et ass zu engem Feeler komm!',
	'framedvideo_error_unknown_type' => 'ID vum Videoservice onbekannt ("$1"): kuckt de Parameter "type" no.',
	'framedvideo_error_no_id_given' => '"id"-Parameter feelt',
	'framedvideo_error_height_required' => 'De Video-Typ "$1" verlaangt de Parameter "height".',
	'framedvideo_error_height_required_not_only_width' => 'De Video-Typ "$1" verlaangt de Parameter "height", net nëmmen de Parameter "width".',
	'framedvideo_error_width_too_big' => 'De Wäert vum Parameter "width" ass ze grouss.',
	'framedvideo_error_height_too_big' => 'De Wäert vum Parameter "height" ass ze grouss.',
	'framedvideo_error_no_integer' => 'De Wäert dee fir "$1" ugi gouf ass keng positiv Zuel.',
	'framedvideo_error_limit' => 'Den héijsten erlaabte Wäert ass $1.',
	'framedvideo_error_full_size_not_allowed' => 'De Wäert "full" ass fir de Parameter "size" fir de Videoservice mat der ID "$1" net erlaabt.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => "[[{{MediaWiki:Framedvideo_helppage}}|Méi iwwert d'Syntax]]",
	'framedvideo_error_height_and_width_required' => 'De Video-Typ "$1" verlaangt d\'Parameter "height" an "width2" oder "width".',
	'framedvideo-desc' => 'Erlaabt et Videoe vu verschidden Internetsäite mat der Markéierung <code>&lt;video&gt;</code> anzebannen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'framedvideo_position' => 'десно',
	'framedvideo_errors' => 'Настанаа повеќе грешки!',
	'framedvideo_error' => 'Настана грешка!',
	'framedvideo_error_unknown_type' => 'Непознат id на видеосервисот („$1“): проверете го параметарот „type“.',
	'framedvideo_error_no_id_given' => 'Недостасува „id“ параметар.',
	'framedvideo_error_height_required' => 'Типот на видео „$1“ бара параметар „height“.',
	'framedvideo_error_height_required_not_only_width' => 'Типот на видео „$1“ бара параметар „height“, а не само параметар „width“.',
	'framedvideo_error_width_too_big' => 'Дадената вредност за параметарот „width“ е преголема.',
	'framedvideo_error_height_too_big' => 'Дадената вредност за параметарот „height“ е преголема.',
	'framedvideo_error_no_integer' => 'Дадената вредност „$1“ не е позитивен број.',
	'framedvideo_error_limit' => 'Највисоката дозволена вредност е $1.',
	'framedvideo_error_full_size_not_allowed' => 'Вредноста „full“ за параметрот „size“ не е дозволена за видеосервисот со id „$1“.',
	'framedvideo_helppage' => 'Help:Видео',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Повеќе за синтаксата]].',
	'framedvideo_error_height_and_width_required' => 'Типот на видео „$1“ бара параметри „height“ и „width2“ или „width“.',
	'framedvideo-desc' => 'Овозможува вметнување на видеоклипови од разни мрежни места со помош на ознаката <code>&lt;video&gt;</code>',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'framedvideo_errors' => 'Flere feil har oppstått!',
	'framedvideo_error' => 'En feil har oppstått!',
	'framedvideo_error_unknown_type' => 'Ukjent videotjeneste id ("$1"): sjekk "type" parameteret.',
	'framedvideo_error_no_id_given' => 'Manglende "id" parameter.',
	'framedvideo_error_height_required' => 'Videotypen "$1" krever "height" parameteren.',
	'framedvideo_error_height_required_not_only_width' => 'Videotypen "$1" krever "height" parametern, ikke bare "width" parameteren.',
	'framedvideo_error_width_too_big' => 'Gitt verdi for "width" parametern er for høy.',
	'framedvideo_error_height_too_big' => 'Gitt verdi for "height" parametern er for stor.',
	'framedvideo_error_no_integer' => 'Gitt verdi for "$1" er ikke et positivt tall.',
	'framedvideo_error_limit' => 'Den høyeste tillatte verdien er $1.',
	'framedvideo_error_full_size_not_allowed' => 'Verdien "full" i "size" parameteren er ikke tillatt for videotjeneste-id-en "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mer om syntaks]].',
	'framedvideo_error_height_and_width_required' => 'Videotypen "$1" krever "height" og "width2" eller "width" parametrene.',
	'framedvideo-desc' => 'Tillater inkludering av videoer fra forskjellige nettsteder ved bruk av <code>&lt;video&gt;</code>-markering',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'framedvideo_errors' => 'Er zijn meerdere fouten opgetreden!',
	'framedvideo_error' => 'Er is een fout opgetreden!',
	'framedvideo_error_unknown_type' => 'Er is een onbekende videoservice ("$1") opgegeven. Controleer de parameter "type".',
	'framedvideo_error_no_id_given' => 'De parameter "id" mist.',
	'framedvideo_error_height_required' => 'Het videotype "$1" heeft de parameter "height" nodig.',
	'framedvideo_error_height_required_not_only_width' => 'Het videotype "$1" heeft de parameter "height" nodig, niet alleen de parameter "width".',
	'framedvideo_error_width_too_big' => 'De ingegeven waarde voor de parameter "width" is te groot.',
	'framedvideo_error_height_too_big' => 'De ingegeven waarde voor de parameter "height" is te groot.',
	'framedvideo_error_no_integer' => 'De ingegeven waarde voor "$1" is geen positief getal.',
	'framedvideo_error_limit' => 'De hoogst toegelaten waarde is $1.',
	'framedvideo_error_full_size_not_allowed' => 'De waarde "full" voor de parameter "size" is niet toegestaan voor de videoservice "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Meer over syntaxis]].',
	'framedvideo_error_height_and_width_required' => 'Voor het videotype "$1" zijn de parameters "height" en "width2" of "width" nodig.',
	'framedvideo-desc' => "Maakt het mogelijk om video's van verschillende websites op de nemen in pagina's met de tag <code>&lt;video&gt;</code>",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'framedvideo_errors' => 'Fleire feil oppstod!',
	'framedvideo_error' => 'Ein feil oppstod!',
	'framedvideo_error_unknown_type' => 'Ukjend videoteneste-id («$1»): sjekk «type»-parameteren.',
	'framedvideo_error_no_id_given' => 'Manglande «id»-parameter.',
	'framedvideo_error_height_required' => 'Videotypen «$1» krev «height»-parameteren.',
	'framedvideo_error_height_required_not_only_width' => 'Videotypen «$1» krev «height»-parameteren, ikkje berre «width»-parameteren.',
	'framedvideo_error_width_too_big' => 'Den oppgjevne verdien til «width»-parameteren er for stor.',
	'framedvideo_error_height_too_big' => 'Den oppgjevne verdien til «height»-parameteren er for stor.',
	'framedvideo_error_no_integer' => 'Den oppgjevne verdien til «$1» er ikkje eit positivt tal.',
	'framedvideo_error_limit' => 'Den høgaste tillatne verdien er $1.',
	'framedvideo_error_full_size_not_allowed' => '«full»-verdien for «size»-parameteren er ikkje tillaten for videoteneste-id-en «$1».',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Meir om syntaks]].',
	'framedvideo_error_height_and_width_required' => 'Videotypen «$1» krev «height» og «width2» eller «width» mellom parametrane.',
	'framedvideo-desc' => 'Tillèt inkludering av videoar frå ymse nettstader ved å nytta <code>&lt;video&gt;</code>-merket.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'framedvideo_errors' => "D'errors multiplas son arribadas !",
	'framedvideo_error' => 'Una error es arribada!',
	'framedvideo_error_unknown_type' => 'ID de servici vidèo desconeguda (« $1 ») : verificatz lo paramètre « type ».',
	'framedvideo_error_no_id_given' => 'Paramètre « id » mancant.',
	'framedvideo_error_height_required' => 'Lo tipe de vidèo « $1 » requerís lo paramètre « height ».',
	'framedvideo_error_height_required_not_only_width' => 'Lo tipe de vidèo « $1 » requerís lo paramètre « height », pas solament lo paramètre « width ».',
	'framedvideo_error_width_too_big' => 'La valor del paramètre « width » es tròp granda.',
	'framedvideo_error_height_too_big' => 'La valor del paramètre « height » es tròp granda.',
	'framedvideo_error_no_integer' => 'La valor donada « $1 » es pas un nombre positiu.',
	'framedvideo_error_limit' => 'La valor mai granda autorizada es $1.',
	'framedvideo_error_full_size_not_allowed' => "La valor « full » pel paramètre « size » es pas autorizada pel servici vidèo d'ID « $1 ».",
	'framedvideo_helppage' => 'Help:Vidèo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mai a prepaus de la sintaxi]].',
	'framedvideo_error_height_and_width_required' => 'Lo tipe de vidèo « $1 » requerís los paramètres « height » e « width2 »  o « width ».',
	'framedvideo-desc' => "Permet d'integrar de vidèos de diferents sites web en utilizant la balisa <code>&lt;video&gt;</code>",
);

/** Polish (Polski)
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'framedvideo_errors' => 'Wystąpiły błędy!',
	'framedvideo_error' => 'Wystąpił błąd!',
	'framedvideo_error_unknown_type' => 'Nieznany identyfikator „$1” dla serwisu wideo: sprawdź parametr „type”.',
	'framedvideo_error_no_id_given' => 'Brakuje parametru „id”.',
	'framedvideo_error_height_required' => 'Wideo z serwisu o identyfikatorze „$1” wymaga podania parametru „height”.',
	'framedvideo_error_height_required_not_only_width' => 'Wideo z serwisu o identyfikatorze „$1” wymaga podania parametru „height”, nie tylko „width”.',
	'framedvideo_error_width_too_big' => 'Podana wartość „width” jest zbyt duża.',
	'framedvideo_error_height_too_big' => 'Podana wartość „height” jest zbyt duża.',
	'framedvideo_error_no_integer' => 'Podana wartość dla parametru „$1” nie jest dodatnią wartością liczbową.',
	'framedvideo_error_limit' => 'Największa dopuszczalna wartość to $1.',
	'framedvideo_error_full_size_not_allowed' => 'Wartość „full” dla parametru „size” niedopuszczalna dla identyfikatora „$1”.',
	'framedvideo_helppage' => 'Help:Wideo',
	'framedvideo_error_see_help' => 'Aby dowiedzieć się więcej o formatowaniu, zobacz [[{{MediaWiki:Framedvideo_helppage}}|stronę pomocy]].',
	'framedvideo_error_height_and_width_required' => 'Wideo z serwisu o identyfikatorze „$1” wymaga podania parametru „height” i „width2” lub „width”.',
	'framedvideo-desc' => 'Pozwala na osadzanie wideo z innych serwisów',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'framedvideo_errors' => 'A son capitaje eror multipl!',
	'framedvideo_error' => "A l'é capitaje n'eror!",
	'framedvideo_error_unknown_type' => 'Id dël sërvissi video ("$1") pa conossù: contròla ël paràmetr "type".',
	'framedvideo_error_no_id_given' => 'Paràmetr "id" mancant.',
	'framedvideo_error_height_required' => 'La sòrt ëd video "$1" a veul ël paràmetr "height".',
	'framedvideo_error_height_required_not_only_width' => 'La sòrt ëd video "$1" a veul ël paràmetr "height", pa mach ël paràmetr "width".',
	'framedvideo_error_width_too_big' => 'Ël valor dàit dël paràmetr "width" a l\'é tròp gròss.',
	'framedvideo_error_height_too_big' => 'Ël valor dàit dël paràmetr "height" a l\'é tròp gròss.',
	'framedvideo_error_no_integer' => 'Ël valor dàit ëd "$1" a l\'é pa un nùmer positiv.',
	'framedvideo_error_limit' => "Ël valor pì àut përmëttù a l'é $1.",
	'framedvideo_error_full_size_not_allowed' => 'Ël valor "full" për ël paràmetr "size" a l\'é pa përmëttù për l\'id dël servissi video "$1".',
	'framedvideo_helppage' => 'Help: Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Ëd pì an sla sintassi]].',
	'framedvideo_error_height_and_width_required' => 'La sòrt ëd video "$1" a veul ij paràmetr "height" e "width2" o "width".',
	'framedvideo-desc' => 'A përmëtt video embedded da vàire sit web an dovrand ël tag <code>&lt;video&gt;</code>.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'framedvideo_helppage' => 'Help:ويډيو',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'framedvideo_errors' => 'Ocorreram múltiplos erros!',
	'framedvideo_error' => 'Ocorreu um erro!',
	'framedvideo_error_unknown_type' => 'Identificador de serviço vídeo desconhecido ("$1"): verifique o parâmetro "type".',
	'framedvideo_error_no_id_given' => 'Parâmetro "id" em falta.',
	'framedvideo_error_height_required' => 'Vídeo tipo "$1" requer o parâmetro "height".',
	'framedvideo_error_height_required_not_only_width' => 'Vídeo tipo "$1" requer o parâmetro "height", e não apenas o parâmetro "width".',
	'framedvideo_error_width_too_big' => 'O valor dado do parâmetro "width" é demasiado grande.',
	'framedvideo_error_height_too_big' => 'O valor dado do parâmetro "height" é demasiado grande.',
	'framedvideo_error_no_integer' => 'O valor dado de "$1" não é um número positivo.',
	'framedvideo_error_limit' => 'O máximo valor permitido é $1.',
	'framedvideo_error_full_size_not_allowed' => 'Valor "full" no parâmetro "size" não permitido para o serviço de vídeo id "$1".',
	'framedvideo_helppage' => 'Help:Vídeo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mais sobre a sintaxe]].',
	'framedvideo_error_height_and_width_required' => 'Vídeo tipo "$1" requer os parâmetros "height" e "width2" ou "width".',
	'framedvideo-desc' => 'Permite incorporar vídeos de vários sites web, usando o elemento <code>&lt;video&gt;</code>',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'framedvideo_errors' => 'Ocorreram múltiplos erros!',
	'framedvideo_error' => 'Ocorreu um erro!',
	'framedvideo_error_unknown_type' => 'Identificador de serviço de vídeo desconhecido ("$1"): verifique o parâmetro "type".',
	'framedvideo_error_no_id_given' => 'Parâmetro "id" em falta.',
	'framedvideo_error_height_required' => 'Vídeo tipo "$1" requer o parâmetro "height".',
	'framedvideo_error_height_required_not_only_width' => 'Vídeo tipo "$1" requer o parâmetro "height", e não apenas o parâmetro "width".',
	'framedvideo_error_width_too_big' => 'O valor dado do parâmetro "width" é muito grande.',
	'framedvideo_error_height_too_big' => 'O valor dado do parâmetro "height" é muito grande.',
	'framedvideo_error_no_integer' => 'O valor dado de "$1" não é um número positivo.',
	'framedvideo_error_limit' => 'O valor máximo permitido é $1.',
	'framedvideo_error_full_size_not_allowed' => 'Valor "full" no parâmetro "size" não permitido para o serviço de vídeo id "$1".',
	'framedvideo_helppage' => 'Help:Vídeo',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mais sobre a sintaxe]].',
	'framedvideo_error_height_and_width_required' => 'Vídeo tipo "$1" requer os parâmetros "height" e "width2" ou "width".',
	'framedvideo-desc' => 'Permite incorporar vídeos de vários sítios web, usando a marca <code>&lt;video&gt;</code>',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'framedvideo_errors' => 'Au avut loc mai multe erori!',
	'framedvideo_error' => 'A avut loc o eroare!',
	'framedvideo_error_no_id_given' => 'Parametrul "id" lipsă.',
	'framedvideo_error_height_required' => 'Tipul video "$1" necesită parametrul "height".',
	'framedvideo_error_height_required_not_only_width' => 'Tipul video "$1" necesită parametrul "height", nu doar parametrul "width".',
	'framedvideo_error_width_too_big' => 'Valoarea dată pentru parametrul "width" este prea mare.',
	'framedvideo_error_height_too_big' => 'Valoarea dată pentru parametrul "height" este prea mare.',
	'framedvideo_error_no_integer' => 'Valoarea dată pentru "$1" nu este număr pozitiv.',
	'framedvideo_error_limit' => 'Valoarea maximă permisă este $1.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_height_and_width_required' => 'Tipul video "$1" necesită parametrii "height" și "width2" sau "width".',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'framedvideo_helppage' => 'Help:Video',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'framedvideo_errors' => 'Произошло множество ошибок!',
	'framedvideo_error' => 'Произошла ошибка!',
	'framedvideo_error_unknown_type' => 'Неизвестный id видеосервиса («$1»): проверьте параметр «type».',
	'framedvideo_error_no_id_given' => 'Нет параметра «id».',
	'framedvideo_error_height_required' => 'Тип видео «$1» требует параметр «height».',
	'framedvideo_error_height_required_not_only_width' => 'Тип видео «$1» требует не только параметр «width», но и «height».',
	'framedvideo_error_width_too_big' => 'Данное значение параметра «width» слишком большое.',
	'framedvideo_error_height_too_big' => 'Данное значение параметра «height» слишком большое.',
	'framedvideo_error_no_integer' => 'Данное значение «$1» не является положительным числом.',
	'framedvideo_error_limit' => 'Наибольшее допустимое значение — $1.',
	'framedvideo_error_full_size_not_allowed' => 'Значение «full» для параметра «size» не допустимо для видеосервиса id «$1».',
	'framedvideo_helppage' => 'Help:Видео',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Больше о синтаксисе]].',
	'framedvideo_error_height_and_width_required' => 'Тип видео «$1» требует парамерты «height» и «width2» или «width».',
	'framedvideo-desc' => 'Позволяет включать видео с различных веб-сайтов, используя тег <code>&lt;video&gt;</code>',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'framedvideo_errors' => 'Vyskytli sa viaceré chyby!',
	'framedvideo_error' => 'Vyskytla sa chyba!',
	'framedvideo_error_unknown_type' => 'Neznámy ID služby ("$1"): skontrolujte parameter „type“.',
	'framedvideo_error_no_id_given' => 'Chýba parameter „ID“.',
	'framedvideo_error_height_required' => 'Typ videa „$1“ vyžaduje parameter „height“.',
	'framedvideo_error_height_required_not_only_width' => 'Typ videa „$1“ vyžaduje parameter „height“, nie len parameter „width“.',
	'framedvideo_error_width_too_big' => 'Zadaná hodnota parametra „width“ je príliš veľká.',
	'framedvideo_error_height_too_big' => 'Zadaná hodnota parametra „height“ je príliš veľká.',
	'framedvideo_error_no_integer' => 'Zadaná hodnota „$1“ nie je kladné číslo.',
	'framedvideo_error_limit' => 'Najvyššia povolená hodnota je $1.',
	'framedvideo_error_full_size_not_allowed' => 'Hodnota „full“ parametra „size“ nie je povolená pri ID služby videa „$1“.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Viac o syntaxi]].',
	'framedvideo_error_height_and_width_required' => 'Video typu „$1“ vyžaduje parametre „height“ a „width2“ alebo „width“.',
	'framedvideo-desc' => 'Umožňuje vkladanie videa z rozličných webstránok pomocou značky <code>&lt;video&gt;</code>',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'framedvideo_errors' => 'Prišlo je do več napak!',
	'framedvideo_error' => 'Prišlo je do napake!',
	'framedvideo_error_unknown_type' => 'Neznan id storitve videoposnetkov (»$1«): preverite parameter »type«.',
	'framedvideo_error_no_id_given' => 'Manjka parameter »id«.',
	'framedvideo_error_height_required' => 'Vrsta videoposnetka »$1« zahteva parameter »height«.',
	'framedvideo_error_height_required_not_only_width' => 'Vrsta videoposnetka »$1« zahteva parameter »height«, ne samo parameter »width«.',
	'framedvideo_error_width_too_big' => 'Dana vrednost parametra »width« je prevelika.',
	'framedvideo_error_height_too_big' => 'Dana vrednost parametra »height« je prevelika.',
	'framedvideo_error_no_integer' => 'Dana vrednost »$1« ni pozitivno število.',
	'framedvideo_error_limit' => 'Najvišja dovoljena vrednost je $1.',
	'framedvideo_error_full_size_not_allowed' => 'Vrednost »full« parametra »size« ni dovoljena za storitev videoposnetkov z id-jem »$1«.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Več o skladnji]].',
	'framedvideo_error_height_and_width_required' => 'Vrsta videoposnetka »$1« zahteva parametre »height« in »width2« ali »width«.',
	'framedvideo-desc' => 'Omogoča vdelovanje videoposnetkov z različnih spletnih strani z uporabo etikete <code>&lt;video&gt;</code>',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'framedvideo_position' => 'десно',
	'framedvideo_errors' => 'Дошло је до неколико грешака!',
	'framedvideo_error' => 'Дошло је до грешке.',
	'framedvideo_error_height_required' => 'Видео-снимак врсте „$1“ захтева параметар „height“.',
	'framedvideo_error_height_required_not_only_width' => 'Видео типу "$1" је потребан и "height" параметар, не само "width" параметар.',
	'framedvideo_error_width_too_big' => 'Задата вредност за параметар "width" је превелика.',
	'framedvideo_error_height_too_big' => 'Задата вредност за параметар "height" је превелика.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'framedvideo_position' => 'desno',
	'framedvideo_errors' => 'Došlo je do nekoliko grešaka!',
	'framedvideo_error' => 'Došlo je do greške!',
	'framedvideo_error_height_required' => 'Video tipu "$1" je potreban parametar "height".',
	'framedvideo_error_height_required_not_only_width' => 'Video tipu "$1" je potreban i "height" parametar, ne samo "width" parametar.',
	'framedvideo_error_width_too_big' => 'Zadata vrednost za parametar "width" je prevelika.',
	'framedvideo_error_height_too_big' => 'Zadata vrednost za parametar "height" je prevelika.',
);

/** Swedish (Svenska)
 * @author Najami
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'framedvideo_errors' => 'Flera fel har uppstått!',
	'framedvideo_error' => 'Ett fel har uppstått!',
	'framedvideo_error_unknown_type' => 'Okänd videotjänst-id ("$1"): kontrollera "type"-parametern.',
	'framedvideo_error_no_id_given' => 'Saknad "id"-parameter.',
	'framedvideo_error_height_required' => 'Videotypen "$1" behöver "height"-parametern.',
	'framedvideo_error_height_required_not_only_width' => 'Videotypen "$1" behöver "height"-parametern, inte bara "width"-parametern.',
	'framedvideo_error_width_too_big' => 'Det uppgivna värdet till "width"-parametern är för stort.',
	'framedvideo_error_height_too_big' => 'Det uppgivna värdet till "height"-parametern är för stort.',
	'framedvideo_error_no_integer' => 'Det uppgivna värdet till "$1" är inte ett positivt tal.',
	'framedvideo_error_limit' => 'Det högsta tillåtna värdet är $1.',
	'framedvideo_error_full_size_not_allowed' => '"full"-värdet för "size"-parametern är inte tillåten för videotjänst-id "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mer om syntax]].',
	'framedvideo_error_height_and_width_required' => 'Videotypen "$1" behöver "height" och "width2" eller "width"-parametrarna.',
	'framedvideo-desc' => 'Tillåter inkludering av videoklipp från olika webbplatser genom att använda <code>&lt;video&gt;</code>-taggen',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'framedvideo_error_no_id_given' => '"id" పరామితిని ఇవ్వలేదు.',
	'framedvideo_error_width_too_big' => '"width" పరామితికి ఇచ్చిన విలువ చాలా పెద్దది.',
	'framedvideo_error_height_too_big' => '"height" పరామితికి ఇచ్చిన విలువ చాలా పెద్దది.',
	'framedvideo_error_no_integer' => '"$1"కి ఇచ్చిన విలువ ధన సంఖ్య కాదు.',
	'framedvideo_error_limit' => 'ఇవ్వగలిగే గరిష్ఠ విలువ $1.',
	'framedvideo_helppage' => 'Help:వీడియో',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|సంజ్ఞావళి గురించి మరింత]].',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'framedvideo_errors' => 'Naganap ang maramihang mga kamalian!',
	'framedvideo_error' => 'Naganap ang isang kamalian!',
	'framedvideo_error_unknown_type' => 'Hindi kilalang id ng palingkuran ng palabas ("$1"): suriin ang parametrong "type".',
	'framedvideo_error_no_id_given' => 'Nawawalang parametrong "id".',
	'framedvideo_error_height_required' => 'Ang uri ng palabas na "$1" ay nangangailangan ng parametrong "height".',
	'framedvideo_error_height_required_not_only_width' => 'Ang uri ng palabas na "$1" ay nangangailangan din ng parametrong "height", hindi lamang ang parametrong "width".',
	'framedvideo_error_width_too_big' => 'Ang ibinigay na halaga ng parametrong "width" ay napakalaki.',
	'framedvideo_error_height_too_big' => 'Ang ibinigay na halaga ng parametrong "height" ay napakalaki.',
	'framedvideo_error_no_integer' => 'Ang ibinigay na halagang "$1" ay hindi isang bilang na walang butal.',
	'framedvideo_error_limit' => 'Ang pinakamataas na pinahihintulutang halaga ay $1.',
	'framedvideo_error_full_size_not_allowed' => 'Ang halagang "full" para sa parametrong "size" ay hindi pinapahintulutan para sa id na "$1" ng palingkuran ng palabas.',
	'framedvideo_helppage' => 'Help:Palabas na napapanood',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Mas marami pang hinggil sa palaugnayan]].',
	'framedvideo_error_height_and_width_required' => 'Ang uri ng palabas na "$1" ay nangangailangan ng mga parametrong "height" at "width2" o "width".',
	'framedvideo-desc' => 'Nagpapahintulot sa pagbabaon ng mga palabas mula sa sari-saring mga websayt na ginagamit ang tatak na <code>&lt;video&gt;</code>',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'framedvideo_errors' => 'Birden fazla hata oluştu!',
	'framedvideo_error' => 'Bir hata oluştu!',
	'framedvideo_error_unknown_type' => 'Bilinmeyen video hizmet id ("$1"): "type" parametresini kontrol edin.',
	'framedvideo_error_no_id_given' => 'Eksik "id" parametresi',
	'framedvideo_error_height_required' => 'Video türü "$1", "height" parametresine ihtiyaç duyuyor.',
	'framedvideo_error_height_required_not_only_width' => 'Video türü "$1", sadece "width" parametresine değil, aynı zamanda "height" parametresine de ihtiyaç duyuyor.',
	'framedvideo_error_width_too_big' => 'Verilen "width" parametresi değeri çok büyük.',
	'framedvideo_error_height_too_big' => 'Verilen "height" parametresi değeri çok büyük.',
	'framedvideo_error_no_integer' => 'Verilen "$1" değeri pozitif bir sayı değil.',
	'framedvideo_error_limit' => 'İzin verilen en yüksek değer $1.',
	'framedvideo_error_full_size_not_allowed' => 'Video servis id "$1" için "size" parametresinde "full" değerine izin verilmiyor.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Sözdizimi hakkında daha fazla bilgi]].',
	'framedvideo_error_height_and_width_required' => 'Video türü "$1", "height", "width2" veya "width" parametrelerine ihtiyaç duyuyor.',
	'framedvideo-desc' => '<code>&lt;video&gt;</code> etiketi kullanılarak çeşitli web sitelerinden alınan videoların yerleştirilmesini mümkün kılmaktadır',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'framedvideo_error_no_id_given' => 'Відсутній параметр "id".',
	'framedvideo_helppage' => 'Help:Відео',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Детальніше про синтаксис]].',
	'framedvideo-desc' => 'Дозволяє вбудовувати відео з різних веб-сайтів за допомогою тега <code>&lt;video&gt;</code>',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'framedvideo_helppage' => 'Help:Video',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'framedvideo_errors' => 'Có nhiều lỗi xảy ra!',
	'framedvideo_error' => 'Có một lỗi xảy ra!',
	'framedvideo_error_unknown_type' => 'Không hiểu mã số dịch vụ video (“$1”): kiểm tra thông số “type”.',
	'framedvideo_error_no_id_given' => 'Không có tham số “id”.',
	'framedvideo_error_height_required' => 'Loại video “$1” cần tham số “height”.',
	'framedvideo_error_height_required_not_only_width' => 'Loại video “$1” cần tham số “height”, chứ không chỉ tham số “width”.',
	'framedvideo_error_width_too_big' => 'Giá trị tham số “width” quá lớn.',
	'framedvideo_error_height_too_big' => 'Giá trị tham số “height” quá lớn.',
	'framedvideo_error_no_integer' => 'Giá trị “$1” không phải số dương.',
	'framedvideo_error_limit' => 'Giá trị cao nhất là $1.',
	'framedvideo_error_full_size_not_allowed' => 'Không cho phép giá trị “full” dành cho thông số “size” trong mã số dịch vụ video “$1”.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => '[[{{MediaWiki:Framedvideo_helppage}}|Thêm về cú pháp]].',
	'framedvideo_error_height_and_width_required' => 'Kiểu video “$1” bắt buộc phải có thoong số “height” và “width2” hoặc “width”.',
	'framedvideo-desc' => 'Cho phép nhúng video từ nhiều website khác nhau bằng cách dùng thẻ <code>&lt;video&gt;</code>',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'framedvideo_position' => '对',
	'framedvideo_errors' => '出现多个错误！',
	'framedvideo_error' => '出现错误！',
	'framedvideo_helppage' => 'Help:视频',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'framedvideo_position' => '對',
	'framedvideo_errors' => '出現多個錯誤！',
	'framedvideo_error' => '出現錯誤！',
	'framedvideo_helppage' => 'Help:視頻',
);

