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
	'framedvideo-desc' => 'Allows embedding videos from various websites using the tag <tt><nowiki><video></nowiki></tt>',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'framedvideo_position' => 'Consider using "left" for right to left languages. Should left untranslated for other languages.',
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
	'framedvideo-desc' => 'يسمح بتضمين الفيديو من مواقع ويب متعددة باستخدام الوسم <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => 'يسمح بتضمين الفيديو من مواقع ويب متعددة باستخدام الوسم <tt><nowiki><video></nowiki></tt>',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'framedvideo_errors' => 'Desilo se više poruke!',
	'framedvideo_error' => 'Nastala je greška!',
	'framedvideo_error_no_id_given' => 'Nedostaje parametar "id".',
	'framedvideo_error_width_too_big' => 'Navedena vrijednost parametra "width" je prevelika.',
	'framedvideo_error_height_too_big' => 'Navedena vrijednost parametra "height" je prevelika.',
	'framedvideo_error_limit' => 'Najveća dopuštena vrijednost je $1.',
	'framedvideo_helppage' => 'Help:Video',
);

/** German (Deutsch)
 * @author Umherirrender
 */
$messages['de'] = array(
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
	'framedvideo-desc' => 'Ermöglicht das Einbinden von Videos von verschiedensten Webseiten mithilfe des <tt><nowiki><video></nowiki></tt>-Tags.',
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
	'framedvideo-desc' => 'Zmóžnja zasajźowanje wideo z wšakich websedłow z pomocu toflicki <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => 'Επιτρέπει την ενσωμάτωση βίντεο από διάφορους ιστοτόπους χρησιμοποιώντας την ετικέτα <tt><nowiki><video></nowiki></tt>',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'framedvideo_errors' => 'Múltiples errores han ocurrido!',
	'framedvideo_error' => 'Un error ha ocurrido!',
	'framedvideo_error_height_required' => 'Tipo de video "$1" requiere parámetro "height".',
	'framedvideo_error_height_required_not_only_width' => 'Tipo de video "$1" requiere parámetro "height", no solamente parámetro "width".',
	'framedvideo_error_width_too_big' => 'Valor dado de parámetro "width" es demasiado grande.',
	'framedvideo_error_height_too_big' => 'Valor dado de parámetro "heigth" es demasiado largo.',
	'framedvideo_error_no_integer' => 'Valor dado de "$1" no es un número positivo.',
	'framedvideo_error_limit' => 'El valor permitido más alto es $1.',
	'framedvideo_error_full_size_not_allowed' => 'Valor "full" para parámetro "size" no permitido para servicio de video id "$1".',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_height_and_width_required' => 'Tipo de video "$1" requiere parámetros "height" y "width2" o "width".',
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
	'framedvideo-desc' => "Permet d'intégrer des vidéos de différents sites web en utilisant la balise <tt><nowiki><video></nowiki></tt>",
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
	'framedvideo-desc' => 'Permite embelecer os vídeos de varios sitios web usando a etiqueta <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => 'Erlaubt s Yybette vu Video vu verschidene Website mit em Tag <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => 'מתן האפשרות להטמעת וידאו מאתרים שונים באמצעות התגית <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => 'Zmóžnja zasadźowanje widejow z wšelakich websydłow z pomocu taflički <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => '<tt><nowiki><video></nowiki></tt> タグを使って、様々なウェブサイトからの動画を埋め込めるようにする',
);

/** Ripoarisch (Ripoarisch)
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
 * @author Robby
 */
$messages['lb'] = array(
	'framedvideo_errors' => 'Et si méi Feeler virkomm!',
	'framedvideo_error' => 'Et ass zu engem Feeler komm!',
	'framedvideo_error_unknown_type' => 'ID vum Videoservice onbekannt ("$1"): kuckt de Parameter "type" no.',
	'framedvideo_error_no_id_given' => '"id"-Parameter feelt',
	'framedvideo_error_height_required' => 'De Video-Typ "$1" verlaangt de Parameter "height".',
	'framedvideo_error_height_required_not_only_width' => 'De Video-Typ "$1" verlaangt de Parameter "height", net nëmmen de Parameter "width".',
	'framedvideo_error_width_too_big' => 'De Wert vum Parameter "width" ass ze grouss.',
	'framedvideo_error_height_too_big' => 'De Wert vum Parameter "height" ass ze grouss.',
	'framedvideo_error_no_integer' => 'De Wert dee fir "$1" ugi gouf ass keng positiv Zuel.',
	'framedvideo_error_limit' => 'Den héijsten erlaabte Wert ass $1.',
	'framedvideo_error_full_size_not_allowed' => 'De Wert "full" ass fir de Parameter "size" fir de Videoservicemat der ID "$1" net erlaabt.',
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => "[[{{MediaWiki:Framedvideo_helppage}}|Méi iwwert d'Syntax]]",
	'framedvideo_error_height_and_width_required' => 'De Video-Typ "$1" verlaangt d\'Parameter "height" an "width2" oder "width".',
	'framedvideo-desc' => 'Erlaabt et Videoen vu verschiddenen Internetsiten matt dem Tag <tt><nowiki><video></nowiki></tt> anzebannen',
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
	'framedvideo-desc' => "Maakt het mogelijk om video's van verschillende websites op de nemen in pagina's met de tag <tt><nowiki><video></nowiki></tt>",
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
	'framedvideo-desc' => 'Tillèt inkludering av videoar frå ymse nettstader ved å nytta <tt><nowiki><video></nowiki></tt>-merket.',
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
	'framedvideo-desc' => "Permet d'integrar de vidèos de diferents sits web en utilizant la balisa <tt><nowiki><video></nowiki></tt>",
);

/** Polish (Polski)
 * @author Leinad
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
	'framedvideo_helppage' => 'Help:Video',
	'framedvideo_error_see_help' => 'Aby dowiedzieć się więcej o formatowaniu, zobacz [[{{MediaWiki:Framedvideo_helppage}}|stronę pomocy]].',
	'framedvideo_error_height_and_width_required' => 'Wideo z serwisu o identyfikatorze „$1” wymaga podania parametru „height” i „width2” lub „width”.',
	'framedvideo-desc' => 'Pozwala na osadzanie wideo z innych serwisów',
);

/** Portuguese (Português)
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
	'framedvideo-desc' => 'Permite incorporar vídeos de vários sítios web, usando a marca <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => 'Permite incorporar vídeos de vários sítios web, usando a marca <tt><nowiki><video></nowiki></tt>',
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
	'framedvideo-desc' => 'Umožňuje vkladanie videa z rozličných webstránok pomocou značky <tt><nowiki><video></nowiki></tt>',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'framedvideo_helppage' => 'Help:వీడియో',
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
	'framedvideo-desc' => 'Nagpapahintulot sa pagbabaon ng mga palabas mula sa sari-saring mga websayt na ginagamit ang tatak na <tt><nowiki><video></nowiki></tt>',
);

