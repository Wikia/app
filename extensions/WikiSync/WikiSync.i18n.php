<?php

/**
 * Messages list.
 */

$messages = array();

/** English (English)
 * @author QuestPC
 */
$messages['en'] = array(
	'wikisync' => 'Wiki synchronization',
	'wikisync-desc' => 'Provides a [[Special:WikiSync|special page]] to synchronize recent changes of two wikis - local one and remote one',
	'wikisync_direction' => 'Please choose the direction of synchronization',
	'wikisync_local_root' => 'Local wiki site root',
	'wikisync_remote_root' => 'Remote wiki site root',
	'wikisync_remote_log' => 'Remote operations log',
	'wikisync_clear_log' => 'Clear log',
	'wikisync_login_to_remote_wiki' => 'Login to remote wiki',
	'wikisync_remote_wiki_root' => 'Remote wiki root',
	'wikisync_remote_wiki_example' => 'Path to api.php, for example: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Remote wiki user name',
	'wikisync_remote_wiki_pass' => 'Remote wiki password',
	'wikisync_remote_login_button' => 'Log in',
	'wikisync_sync_files' => 'Synchronize files',
	'wikisync_store_password' => 'Store remote wiki password',
	'wikisync_storing_password_warning' => 'Storing remote password is insecure and is not recommended',
	'wikisync_synchronization_button' => 'Synchronize',
	'wikisync_scheduler_log' => 'Scheduler log',
	'wikisync_scheduler_setup' => 'Scheduler setup',
	'wikisync_scheduler_turn_on' => 'Turn on the scheduler',
	'wikisync_scheduler_switch_direction' => 'Automatically switch the direction of synchronization',
	'wikisync_scheduler_time_interval' => 'Time in minutes between automatical synchronizations',
	'wikisync_apply_button' => 'Apply',
	'wikisync_log_imported_by' => 'Imported by [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Uploaded by [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Only a special bot user $1 can perform wiki synchronizations. Please login as $1. Do not change $1 name in between the synchronizations, otherwise informational null revisions will not be properly skipped (see [http://www.mediawiki.org/wiki/Extension:WikiSync] for more info).',
	'wikisync_api_result_unknown_action' => 'Unknown API action',
	'wikisync_api_result_exception' => 'Exception occured in local API call',
	'wikisync_api_result_noaccess' => 'Only members of the following {{PLURAL:$2|group|groups}} can perform this action: $1',
	'wikisync_api_result_invalid_parameter' => 'Invalid value of parameter',
	'wikisync_api_result_http' => 'HTTP error while querying data from remote API',
	'wikisync_api_result_Unsupported' => 'Your version of MediaWiki is unsupported (less than 1.15)',
	'wikisync_api_result_NoName' => 'You did not set the lgname parameter',
	'wikisync_api_result_Illegal' => 'You provided an illegal username',
	'wikisync_api_result_NotExists' => 'The username you provided does not exist',
	'wikisync_api_result_EmptyPass' => 'You did not set the lgpassword parameter or you left it empty',
	'wikisync_api_result_WrongPass' => 'The password you provided is incorrect',
	'wikisync_api_result_WrongPluginPass' => 'The password you provided is incorrect',
	'wikisync_api_result_CreateBlocked' => 'The wiki tried to automatically create a new account for you, but your IP address has been blocked from account creation',
	'wikisync_api_result_Throttled' => 'You have logged in too many times in a short time.',
	'wikisync_api_result_Blocked' => 'User is blocked',
	'wikisync_api_result_mustbeposted' => 'The login module requires a POST request',
	'wikisync_api_result_NeedToken' => 'Either you did not provide the login token or the sessionid cookie. Request again with the token and cookie given in this response',
	'wikisync_api_result_no_import_rights' => 'This user is not allowed to import XML dump files',
	'wikisync_api_result_Success' => 'Successfully logged into remote wiki site',
	'wikisync_js_last_op_error' => 'Last operation returned an error.

Code: $1

Message: $2

Press [OK] to retry last operation',
	'wikisync_js_synchronization_confirmation' => 'Are you sure you want to synchronize

from $1
	
to $2
	
starting from revision $3?',
	'wikisync_js_synchronization_success' => 'Synchronization was completed successfully',
	'wikisync_js_already_synchronized' => 'Source and destination wikis seems to be already synchronized',
	'wikisync_js_sync_to_itself' => 'You cannot synchronize the wiki to itself',
	'wikisync_js_diff_search' => 'Looking for difference in destination revisions',
	'wikisync_js_revision' => 'Revision $1',
	'wikisync_js_file_size_mismatch' => 'Temporary file "$1" size ($2 {{PLURAL:$2|byte|bytes}}) does not match required size ($3 {{PLURAL:$3|byte|bytes}}). Make sure the file "$4" was not manually overwritten in repository of source wiki.',
	'wikisync_js_invalid_scheduler_time' => 'Scheduler time must be a positive integer number',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|minute|minutes}} left',
	'wikisync_js_sync_start_ltr' => 'Starting the synchronization from local wiki to remote wiki at $1',
	'wikisync_js_sync_start_rtl' => 'Starting the synchronization from remote wiki to local wiki at $1',
	'wikisync_js_sync_end_ltr' => 'Finished the synchronization from local wiki to remote wiki at $1',
	'wikisync_js_sync_end_rtl' => 'Finished the synchronization from remote wiki to local wiki at $1',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Тест
 */
$messages['qqq'] = array(
	'wikisync_remote_login_button' => '{{Identical|Log in}}',
	'wikisync_apply_button' => '{{Identical|Apply}}',
	'wikisync_api_result_WrongPluginPass' => 'Same as WrongPass, returned when an authentication plugin rather than MediaWiki itself rejected the password',
	'wikisync_js_revision' => '{{Identical|Revision}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wikisync' => 'Wiki-sinchronisasie',
	'wikisync_clear_log' => 'Maak logoek skoon',
	'wikisync_sync_files' => 'Sinchroniseer lêers',
	'wikisync_synchronization_button' => 'Sinchroniseer',
	'wikisync_apply_button' => 'Pas toe',
	'wikisync_api_result_Blocked' => 'Die gebruiker is geblokkeer',
	'wikisync_js_revision' => 'Weergawe $1',
);

/** Arabic (العربية)
 * @author روخو
 */
$messages['ar'] = array(
	'wikisync' => 'مزامنة الويكي',
	'wikisync_remote_login_button' => 'دخول',
	'wikisync_sync_files' => 'مزامنة الملفات',
	'wikisync_synchronization_button' => 'مزامنة',
	'wikisync_scheduler_log' => 'سجل الجدولة',
	'wikisync_scheduler_setup' => 'إعداد الجدولة',
	'wikisync_scheduler_turn_on' => 'تشغيل الجدولة',
	'wikisync_apply_button' => 'طب',
	'wikisync_api_result_Blocked' => 'مستخدم محظور',
	'wikisync_js_synchronization_confirmation' => 'هل أنت متأكد أنك تريد مزامنة

من $1

إلى $2

بدءا من مراجعة $3؟',
	'wikisync_js_revision' => 'تنقيح $1',
	'wikisync_js_sync_start_ltr' => 'بدء التزامن من ويكي محلي إلى ويكي عن بعد على 1$',
	'wikisync_js_sync_start_rtl' => 'بدء التزامن من ويكي عن بعد إلى ويكي محلي على 1$',
	'wikisync_js_sync_end_ltr' => 'انهاء التزامن من ويكي محلي إلى ويكي عن بعد على 1$',
	'wikisync_js_sync_end_rtl' => 'انهاء التزامن من ويكي عن بعد إلى ويكي محلي على 1$',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'wikisync_remote_login_button' => 'Daxil ol',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'wikisync' => 'Сынхранізацыя вікі',
	'wikisync-desc' => 'Дадае [[Special:WikiSync|спэцыяльную старонку]] для сынхранізацыі апошніх зьменаў двух вікі — аддаленай і лякальнай',
	'wikisync_direction' => 'Калі ласка, выберыце напрамак сынхранізацыі',
	'wikisync_local_root' => 'Каранёвы каталёг сайта лякальнай вікі',
	'wikisync_remote_root' => 'Каранёвы каталёг сайта аддаленай вікі',
	'wikisync_remote_log' => 'Журнал аддаленых дзеяньняў',
	'wikisync_clear_log' => 'Ачысьціць журнал',
	'wikisync_login_to_remote_wiki' => 'Увайсьці на аддалены вікі-сайт',
	'wikisync_remote_wiki_root' => 'Каранёвы адрас аддаленай вікі',
	'wikisync_remote_wiki_example' => 'Шлях да <code>api.php</code>, напрыклад: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Імя карыстальніка аддаленай вікі',
	'wikisync_remote_wiki_pass' => 'Пароль аддаленай вікі',
	'wikisync_remote_login_button' => 'Увайсьці',
	'wikisync_sync_files' => 'Сынхранізаваць файлы',
	'wikisync_store_password' => 'Захоўваць пароль аддаленай вікі',
	'wikisync_storing_password_warning' => 'Захаваньне паролю аддаленай вікі небясьпечнае, таму не рэкамэндуецца',
	'wikisync_synchronization_button' => 'Сынхранізаваць',
	'wikisync_scheduler_log' => 'Журнал плянавальніка',
	'wikisync_scheduler_setup' => 'Налады плянавальніка',
	'wikisync_scheduler_turn_on' => 'Уключыць плянавальнік',
	'wikisync_scheduler_switch_direction' => 'Аўтаматычна зьмяняць накірунак сынхранізацыі',
	'wikisync_scheduler_time_interval' => 'Час між аўтаматычнымі сынхранізацыямі (у хвілінах)',
	'wikisync_apply_button' => 'Ужыць',
	'wikisync_log_imported_by' => 'Імпартаванае [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Загружанае [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Толькі спэцыяльны робат $1 можа выканаць сынхранізацыю вікі-сайтаў. Калі ласка, увайдзіце як $1. Не зьмяняйце імя $1 паміж сынхранізацыямі, у адваротным выпадку нулявыя вэрсіі ня будуць слушна прапушчаныя (глядзіце [http://www.mediawiki.org/wiki/Extension:WikiSync] для дадатковай інфармацыі).',
	'wikisync_api_result_unknown_action' => 'Невядомае дзеяньне API',
	'wikisync_api_result_exception' => 'Адбылося выключэньне падчас лякальнага выкліку API',
	'wikisync_api_result_noaccess' => 'Гэтае дзеяньне могуць выконваць удзельнікі толькі {{PLURAL:$2|наступнай групы|наступных групаў}}: $1',
	'wikisync_api_result_invalid_parameter' => 'Няслушнае значэньне парамэтра',
	'wikisync_api_result_http' => 'Адбылася памылка HTTP падчас запыту зьвестак праз аддаленае API',
	'wikisync_api_result_Unsupported' => 'Вашая вэрсія MediaWiki не падтрымліваецца (меней 1.15)',
	'wikisync_api_result_NoName' => 'Вы не пазначылі парамэтар <code>lgname</code>',
	'wikisync_api_result_Illegal' => 'Няслушнае імя карыстальніка',
	'wikisync_api_result_NotExists' => 'Карыстальнік з пададзеным іменем не існуе',
	'wikisync_api_result_EmptyPass' => 'Вы не ўстанавілі парамэтар lgpassword ці пакінулі яго пустым',
	'wikisync_api_result_WrongPass' => 'Пададзены Вамі пароль зьяўляецца няслушным',
	'wikisync_api_result_WrongPluginPass' => 'Пададзены Вамі пароль зьяўляецца няслушным',
	'wikisync_api_result_CreateBlocked' => 'Вікі спрабавала аўтаматычна стварыць новы рахунак для Вас, але Ваш IP-адрас заблякаваны ад стварэньня рахункаў',
	'wikisync_api_result_Throttled' => 'Вы ўваходзілі ў сыстэму зашмат разоў за кароткі пэрыяд часу.',
	'wikisync_api_result_Blocked' => 'Удзельнік заблякаваны',
	'wikisync_api_result_mustbeposted' => 'Модуль аўтарызацыі патрабуе выкарыстаньня POST-запытаў',
	'wikisync_api_result_NeedToken' => 'Вы не падалі ключ уваходу ў сыстэму ці закладку (cookie) сэсіі. Запытайце зноў з ключом і закладкай, якія пададзеныя у гэтым адказе',
	'wikisync_api_result_no_import_rights' => 'Гэтаму ўдзельніку не дазволена імпартаваць копіі базы зьвестак ў фармаце XML',
	'wikisync_api_result_Success' => 'Пасьпяховы ўваход ў аддалены вікі-сайт',
	'wikisync_js_last_op_error' => 'Апошняя апэрацыя вярнула памылку.

Код: $1

Паведамленьне: $2

Націсьніце [Добра] каб паўтарыць апошнюю апэрацыю',
	'wikisync_js_synchronization_confirmation' => 'Вы ўпэўнены, што жадаеце сынхранізаваць

з $1
	
да $2
	
пачынаючы з вэрсіі $3?',
	'wikisync_js_synchronization_success' => 'Сынхранізацыя пасьпяхова скончаная',
	'wikisync_js_already_synchronized' => 'Крынічная і мэтавая вікі выглядаюць ужо сынхранізаванымі',
	'wikisync_js_sync_to_itself' => 'Немагчыма сынхранізаваць вікі з самой сябе',
	'wikisync_js_diff_search' => 'Пошук адрозьненьняў у мэтавых вэрсіях',
	'wikisync_js_revision' => 'Вэрсія $1',
	'wikisync_js_file_size_mismatch' => 'Памер часовага файла «$1» ($2 {{PLURAL:$2|байт|байты|байтаў}}) не адпавядае патрабуемаму памеру ($3 {{PLURAL:$3|байт|байты|байтаў}}). Упэўніцеся, што файл «$4» ня быў перапісаны ўручную ў сховішчы крынічнай вікі.',
	'wikisync_js_invalid_scheduler_time' => 'Час пляніроўшчыка павінен быць станоўчай цэлай лічбай',
	'wikisync_js_scheduler_countdown' => 'Засталася $1 {{PLURAL:$1|хвіліна|хвіліны|хвілінаў}}',
	'wikisync_js_sync_start_ltr' => 'Запуск сынхранізацыі лякальнай і аддаленай вікі: $1',
	'wikisync_js_sync_start_rtl' => 'Запуск сынхранізацыі аддаленай і лякальнай вікі: $1',
	'wikisync_js_sync_end_ltr' => 'Сканчэньне сынхранізацыі лякальнай і аддаленай вікі: $1',
	'wikisync_js_sync_end_rtl' => 'Сканчэньне сынхранізацыі аддаленай і лякальнай вікі: $1',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'wikisync_remote_login_button' => 'Влизане',
	'wikisync_synchronization_button' => 'Синхронизиране',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'wikisync' => 'Sinkroneladur ar wiki',
	'wikisync-desc' => "Pourchas a ra ur [[Special:WikiSync|bajenn dibar]] da sinkronelaat kemmoù diwezhañ daou wiki - unan lec'hel hag unan a-bell",
	'wikisync_direction' => 'Dibab tu ar sinkronelaat',
	'wikisync_local_root' => "Gwrizienn al lec'hienn wiki lec'hel",
	'wikisync_remote_root' => "Gwrizienn al lec'hienn wiki a-bell",
	'wikisync_remote_log' => 'Marilh an oberiadennoù a-bell',
	'wikisync_clear_log' => 'Riñsañ ar marilh',
	'wikisync_login_to_remote_wiki' => "Kevreadenn d'ar wiki a-bell",
	'wikisync_remote_wiki_root' => 'Gwrizienn ar wiki a-bell',
	'wikisync_remote_wiki_example' => 'Hent betek an api.php, da skouer : http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Anv implijer war ar wiki a-bell',
	'wikisync_remote_wiki_pass' => 'Ger-tremen war ar wiki a-bell',
	'wikisync_remote_login_button' => 'Kevreañ',
	'wikisync_sync_files' => 'Sinkronelañ restroù',
	'wikisync_store_password' => 'Memoriñ ger-tremen ar wiki a-bell',
	'wikisync_storing_password_warning' => "N'eo ket suraet ar memoriñ gerioù-temen a-bell ha, dre se, n'eo ket erbedet",
	'wikisync_synchronization_button' => 'Sinkronaat',
	'wikisync_scheduler_log' => 'Marilh ar steuñvekaer',
	'wikisync_scheduler_setup' => 'Kefluniadur ar steuñvekaer',
	'wikisync_scheduler_turn_on' => 'Gweredekaat ar steuñvekaer',
	'wikisync_scheduler_switch_direction' => 'Eilpennañ tu ar sinkronelaat ent emgefre',
	'wikisync_scheduler_time_interval' => 'Amzer, e munutennoù, etre an sinkroneladurioù emgefre',
	'wikisync_apply_button' => 'Arloañ',
	'wikisync_log_imported_by' => 'Enporzhiet gant [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Karget gant [[Special:WikiSync|WikiSync]]',
	'wikisync_api_result_unknown_action' => 'Oberiadenn API dianav',
	'wikisync_api_result_exception' => "C'hoarvezet ez eus un nemedenn e-pad galvadenn an API lec'hel",
	'wikisync_api_result_noaccess' => "N'eus nemet an izili zo er {{PLURAL:$2|strollad|strolladoù}} da-heul a c'hall seveniñ an ober-mañ : $1",
	'wikisync_api_result_invalid_parameter' => 'Direizh eo talvoud an arventenn',
	'wikisync_api_result_http' => "C'hoarvezet ez eus ur fazi HTTP en ur c'houlenn roadennoù digant an API a-bell",
	'wikisync_api_result_Unsupported' => "N'eo ket skoret ho stumm eus Media Wiki (koshoc'h eget 1.15)",
	'wikisync_api_result_NoName' => "N'hoc'h eus ket termenet an arventenn <code>lgname</code>",
	'wikisync_api_result_Illegal' => "Un anv implijer fall hoc'h eus lakaet",
	'wikisync_api_result_NotExists' => "An anv implijer lakaet ganeoc'h n'eus ket anezhañ",
	'wikisync_api_result_EmptyPass' => "N'hoc'h eus ket termenet an arventenn <code>lgpassword</code> pe lezet eo bet goullo ganeoc'h",
	'wikisync_api_result_WrongPass' => "Fall eo an ger-tremen merket ganeoc'h",
	'wikisync_api_result_WrongPluginPass' => "Fall eo an ger-tremen merket ganeoc'h",
	'wikisync_api_result_CreateBlocked' => "Klasket en deus ar wiki-mañ krouiñ ent emgefre ur gont nevez evitdoc'h met stanket eo bet ho chomlec'h IP evit mirout a grouiñ kontoù drezañ",
	'wikisync_api_result_Throttled' => "Klasket hoc'h eus kevreañ re alies e re nebeut a amzer.",
	'wikisync_api_result_Blocked' => 'Implijer stanket',
	'wikisync_api_result_mustbeposted' => 'Ezhomm en deus ar vodulenn gevreañ eus ur reked POST',
	'wikisync_api_result_NeedToken' => "N'hoc'h eus ket pourchaset ar jedouer kevreañ pe toupin anavezout an dalc'h. Goulenn en-dro gant ar jedouer hag an toupin roet er respont-mañ.",
	'wikisync_api_result_no_import_rights' => "N'eo ket aotreet an implijer-mañ da enporzhiañ restroù skarzh XML",
	'wikisync_api_result_Success' => "Kevreet oc'h ervat war lec'hienn ar wiki a-bell",
	'wikisync_js_last_op_error' => "Ur c'hemenn fazi zo bet da-heul an oberiadenn ziwezhañ.

Kod : $1

Kemenn : $2

Pouezañ war [Mat eo] evit klask en-dro.",
	'wikisync_js_synchronization_confirmation' => "Ha sur oc'h e fell deoc'h sinkronelaat

eus $1
	
war-zu $2
	
adalek an adweladenn $3?",
	'wikisync_js_synchronization_success' => 'Kaset eo bet ar sinkronelaat da benn ervat',
	'wikisync_js_already_synchronized' => 'Evit doare eo sinkronelaet dija ar wikioù tal ha kein',
	'wikisync_js_sync_to_itself' => "N'haller ket sinkronelaat ar wiki gantañ e-unan",
	'wikisync_js_diff_search' => "O klask diforc'hioù en adweladennoù tal",
	'wikisync_js_revision' => 'Adweladenn $1',
	'wikisync_js_file_size_mismatch' => 'Ne glot ket ment ar restr dibas "$1" ($2 {{PLURAL:$2|byte|byte}}) gant ar vent rekis ($3 {{PLURAL:$3|byte|bytes}}). Bezit sur n\'eo ket bet friket ar restr "$4" gant an dorn e sanailh ar wiki mammenn.',
	'wikisync_js_invalid_scheduler_time' => 'Rankout a ra pad ar steuñvekaer bezañ un niver anterin pozitivel',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|munut|munut}} a chom',
	'wikisync_js_sync_start_ltr' => "Kregiñ gant ar sinkroneladur adalek ar wiki lec'hel betek ar wiki a-bell da $1",
	'wikisync_js_sync_start_rtl' => "Kregiñ gant ar sinkroneladur adalek ar wiki a-bell betek ar wiki lec'hel da $1",
	'wikisync_js_sync_end_ltr' => "Echuet ar sinkroneladur adalek ar wiki lec'hel betek ar wiki a-bell da $1",
	'wikisync_js_sync_end_rtl' => "Echuet ar sinkroneladur adalek ar wiki a-bell betek ar wiki lec'hel da $1",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'wikisync' => 'Wiki sinhronizacija',
	'wikisync-desc' => 'Omogućava [[Special:WikiSync|posebnu stranicu]] za sinhronizaciju nedavnih izmjena na dvije wiki - lokalnoj i udaljenoj',
	'wikisync_direction' => 'Molimo odaberite smjer sinhronizacije',
	'wikisync_local_root' => 'Osnovna adresa lokalne wiki',
	'wikisync_remote_root' => 'Osnovna adresa udaljene wiki',
	'wikisync_remote_log' => 'Zapisnik udaljenih operacija',
	'wikisync_clear_log' => 'Očisti zapisnik',
	'wikisync_login_to_remote_wiki' => 'Prijava na udaljenu wiki',
	'wikisync_remote_wiki_root' => 'Osnovna adresa udaljene wiki',
	'wikisync_remote_wiki_example' => 'Putanja do api.php, Na primjer: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Korisničko ime na udaljenoj wiki',
	'wikisync_remote_wiki_pass' => 'Šifra udaljene wiki',
	'wikisync_remote_login_button' => 'Prijava',
	'wikisync_sync_files' => 'Usaglasi datotek',
	'wikisync_store_password' => 'Sačuvaj šifru udaljene wiki',
	'wikisync_storing_password_warning' => 'Čuvanje udaljene šifre nije sigurno i nije preporučeno',
	'wikisync_synchronization_button' => 'Usaglasi',
	'wikisync_scheduler_log' => 'Zapisnik izvođenja',
	'wikisync_scheduler_setup' => 'Postavke izvođenja',
	'wikisync_apply_button' => 'Primijeni',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'wikisync' => 'Wiki-Synchronisierung',
	'wikisync-desc' => 'Ermöglicht eine [[Special:WikiSync|Spezialseite]] mit der die letzten Änderungen von zwei Wikis, einem Lokalen und einem Fernen, synchronisiert werden können',
	'wikisync_direction' => 'Bitte Synchronisierungsrichtung auswählen',
	'wikisync_local_root' => 'Hauptverzeichnis des lokalen Wikis',
	'wikisync_remote_root' => 'Hauptverzeichnis des fernen Wikis',
	'wikisync_remote_log' => 'Logbuch der fernen Aktivitäten',
	'wikisync_clear_log' => 'Logbuch löschen',
	'wikisync_login_to_remote_wiki' => 'Anmeldung beim entfernten Wiki',
	'wikisync_remote_wiki_root' => 'Hauptverzeichnis des fernen Wikis',
	'wikisync_remote_wiki_example' => 'Pfad zur api.php, beispielsweise http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Benutzername beim fernen Wiki',
	'wikisync_remote_wiki_pass' => 'Passwort beim fernen Wiki',
	'wikisync_remote_login_button' => 'Anmelden',
	'wikisync_sync_files' => 'Dateien synchronisieren',
	'wikisync_store_password' => 'Passwort des fernen Wikis speichern',
	'wikisync_storing_password_warning' => 'Das Speichern des Passworts des fernen Wikis ist unsicher und wird nicht empfohlen',
	'wikisync_synchronization_button' => 'Synchronisieren',
	'wikisync_scheduler_log' => 'Ausführungs-Logbuch',
	'wikisync_scheduler_setup' => 'Einrichtung der Ausführungen',
	'wikisync_scheduler_turn_on' => 'Ausführungen aktivieren',
	'wikisync_scheduler_switch_direction' => 'Automatisch die Richtung der Synchronisierung ändern',
	'wikisync_scheduler_time_interval' => 'Zeit in Minuten zwischen automatischen Synchronisierungen',
	'wikisync_apply_button' => 'Anwenden',
	'wikisync_log_imported_by' => 'Importiert von [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Hochgeladen von [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Nur der Bot $1 kann Wiki-Synchronisierungen durchführen. Bitte als $1 anmelden. Der Name $1 darf nicht zwischen den Synchronisierungen geändert werden, da ansonsten Versionen ohne Veränderungen nicht ordnungsgemäß übersprungen werden können (siehe hierzu [http://www.mediawiki.org/wiki/Extension:WikiSync] für weitere Informationen).',
	'wikisync_api_result_unknown_action' => 'Unbekannte API-Aktion',
	'wikisync_api_result_exception' => 'Eine Ausnahme ist beim lokalen API-Aufruf aufgetreten',
	'wikisync_api_result_noaccess' => 'Nur Mitglieder der folgenden {{PLURAL:$2|Benutzergruppe|Benutzergruppen}} können diese Aktion ausführen: $1',
	'wikisync_api_result_invalid_parameter' => 'Ungültiger Parameterwert',
	'wikisync_api_result_http' => 'HTTP-Fehler beim Abfragen von Daten mit ferner API',
	'wikisync_api_result_Unsupported' => 'Diese MediaWiki-Version wird nicht unterstützt (niedriger als 1.15)',
	'wikisync_api_result_NoName' => 'Der Parameter „lgname“ wurde nicht angegeben',
	'wikisync_api_result_Illegal' => 'Ein unzulässiger Benutzername wurde angegeben',
	'wikisync_api_result_NotExists' => 'Der angegebene Benutzername ist nicht vorhanden',
	'wikisync_api_result_EmptyPass' => 'Der Parameter „lgpassword“ wurde nicht angegeben',
	'wikisync_api_result_WrongPass' => 'Das angegebene Passwort ist ungültig',
	'wikisync_api_result_WrongPluginPass' => 'Das angegebene Passwort ist ungültig',
	'wikisync_api_result_CreateBlocked' => 'Das Wiki versuchte ein neues Benutzerkonto automatisch anzulegen. Die verwendete IP-Adresse wurde allerdings für die Erstellung von Benutzerkonten gesperrt.',
	'wikisync_api_result_Throttled' => 'Es erfolgte zu häufig eine Anmeldung während eines zu kurzen Zeitraums.',
	'wikisync_api_result_Blocked' => 'Der Benutzer ist gesperrt',
	'wikisync_api_result_mustbeposted' => 'Das Anmeldemodul benötigt eine POST-Anfrage',
	'wikisync_api_result_NeedToken' => 'Entweder wurde kein Anmeldetoken oder kein Sitzungscookie angegeben. Bitte erneut mit Token und Cookie anfragen, die bei dieser Meldung angegeben wurden.',
	'wikisync_api_result_no_import_rights' => 'Diesem Benutzer ist es nicht gestatten XML-Speicherauszüge zu importieren',
	'wikisync_api_result_Success' => 'Erfolgreich auf dem entfernten Wiki angemeldet',
	'wikisync_js_last_op_error' => 'Der letzte Vorgang führte zu einem Fehler.

Code: $1

Nachricht: $2

[OK] klicken, um zu versuchen den letzten Vorgang zu wiederholen.',
	'wikisync_js_synchronization_confirmation' => 'Soll wirklich eine Synchronisierung

zwischen $1

und $2

ab Version $3 durchgeführt werden?',
	'wikisync_js_synchronization_success' => 'Die Synchronisierung wurde erfolgreich abgeschlossen',
	'wikisync_js_already_synchronized' => 'Beide Wikis scheinen bereits synchronisiert zu sein',
	'wikisync_js_sync_to_itself' => 'Das Wiki kann nicht mit sich selbst synchronisiert werden',
	'wikisync_js_diff_search' => 'Suche nach Unterschieden bei den Zielversionen',
	'wikisync_js_revision' => 'Version $1',
	'wikisync_js_file_size_mismatch' => 'Die Größe der temporären Datei „$1“ ($2 {{PLURAL:$2|Byte|Bytes}}) entspricht nicht der erforderlichen Größe ($3 {{PLURAL:$3|Byte|Bytes}}). Es muss sichergestellt sein, dass Datei „$4“ im Repositorium des Quellwikis nicht manuell überschrieben wurde.',
	'wikisync_js_invalid_scheduler_time' => 'Der Ausführungszeitpunkt muss eine positive ganze Zahl sein',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|Minute|Minuten}} verbleiben',
	'wikisync_js_sync_start_ltr' => 'Synchronisierung des fernen Wikis mit dem lokalen Wiki startet um $1',
	'wikisync_js_sync_start_rtl' => 'Synchronisierung des lokalen Wikis mit dem fernen Wiki startet um $1',
	'wikisync_js_sync_end_ltr' => 'Synchronisierung des fernen Wikis mit dem lokalen Wiki war um $1 fertig',
	'wikisync_js_sync_end_rtl' => 'Synchronisierung des lokalen Wikis mit dem fernen Wiki war um $1 fertig',
);

/** Spanish (Español)
 * @author Dferg
 */
$messages['es'] = array(
	'wikisync_api_result_Blocked' => 'El usuario está bloqueado',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'wikisync_apply_button' => 'Käytä',
);

/** French (Français)
 * @author IAlex
 * @author Verdy p
 */
$messages['fr'] = array(
	'wikisync' => 'Synchronisation de wikis',
	'wikisync-desc' => 'Fournit une [[Special:WikiSync|page spéciale]] permettant de synchroniser les modifications récentes sur deux wikis — un local et un distant',
	'wikisync_direction' => 'Veuillez choisir la direction de la synchronisation',
	'wikisync_local_root' => 'Racine du site wiki local',
	'wikisync_remote_root' => 'Racine du site wiki distant',
	'wikisync_remote_log' => 'Journal des opérations à distance',
	'wikisync_clear_log' => 'Effacer le journal',
	'wikisync_login_to_remote_wiki' => 'Connexion au wiki distant',
	'wikisync_remote_wiki_root' => 'Racine du wiki distant',
	'wikisync_remote_wiki_example' => "Chemin d'accès au api.php, par exemple : http://www.mediawiki.org/w",
	'wikisync_remote_wiki_user' => 'Nom d’utilisateur sur le wiki distant',
	'wikisync_remote_wiki_pass' => 'Mot de passe sur le wiki distant',
	'wikisync_remote_login_button' => 'Connexion',
	'wikisync_sync_files' => 'Synchroniser des fichiers',
	'wikisync_store_password' => 'Stocker le mot de passe du wiki distant',
	'wikisync_storing_password_warning' => 'Le stockage d’un mot de passe distant n’est pas sécurisé et n’est pas recommandé',
	'wikisync_synchronization_button' => 'Synchroniser',
	'wikisync_scheduler_log' => 'Journal du planificateur',
	'wikisync_scheduler_setup' => 'Configuration du planificateur',
	'wikisync_scheduler_turn_on' => 'Activer le planificateur',
	'wikisync_scheduler_switch_direction' => 'Basculer automatiquement la direction de synchronisation',
	'wikisync_scheduler_time_interval' => 'Durée en minutes entre les synchronisations automatiques',
	'wikisync_apply_button' => 'Appliquer',
	'wikisync_log_imported_by' => 'Importé par [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Téléversé par [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => "Seul un robot spécialisé $1 peut effectuer les synchronisations des wikis. Veuillez vous connecter en tant que $1. Ne modifiez pas le nom de $1 entre les synchronisations, sinon les révisions nulles d'information ne seront pas correctement sautées (voir [http://www.mediawiki.org/wiki/Extension:WikiSync] pour plus d'infos).",
	'wikisync_api_result_unknown_action' => 'Action inconnue de l’API',
	'wikisync_api_result_exception' => 'Une exception s’est produite durant l’appel de l’API locale',
	'wikisync_api_result_noaccess' => 'Seuls les membres {{PLURAL:$2|du groupe suivant|des groupes suivants}} peuvent effectuer cette action : $1',
	'wikisync_api_result_invalid_parameter' => 'Valeur invalide du paramètre',
	'wikisync_api_result_http' => 'Une erreur HTTP est survenue lors de la requête de données de l’API distante',
	'wikisync_api_result_Unsupported' => 'Votre version de MediaWiki n’est pas pris en charge (inférieure à 1.15)',
	'wikisync_api_result_NoName' => 'Vous n’avez pas défini le paramètre <code>lgname</code>',
	'wikisync_api_result_Illegal' => 'Vous avez fourni un mauvais nom d’utilisateur',
	'wikisync_api_result_NotExists' => 'Le nom d’utilisateur que vous avez fourni n’existe pas',
	'wikisync_api_result_EmptyPass' => 'Vous n’avez pas défini le paramètre <code>lgpassword</code> ou vous l’avez laissé vide',
	'wikisync_api_result_WrongPass' => 'Le mot de passe que vous avez fourni est incorrect',
	'wikisync_api_result_WrongPluginPass' => 'Le mot de passe que vous avez fourni est incorrect',
	'wikisync_api_result_CreateBlocked' => 'Le wiki a essayé de créer automatiquement un nouveau compte pour vous, mais votre adresse IP a été bloquée contre toute création de compte',
	'wikisync_api_result_Throttled' => 'Vous avez tenté de vous connecter de trop nombreuses fois en peu de temps.',
	'wikisync_api_result_Blocked' => 'L’utilisateur est bloqué',
	'wikisync_api_result_mustbeposted' => 'Le module de connexion nécessite une requête POST',
	'wikisync_api_result_NeedToken' => 'Vous n’avez fourni aucun jeton de connexion ou cookie d’identification de session. Demander à nouveau avec le jeton et le cookie donnés dans cette réponse',
	'wikisync_api_result_no_import_rights' => 'Cet utilisateur n’est pas autorisé à importer des fichiers de vidage XML',
	'wikisync_api_result_Success' => 'Connecté avec succès sur le site wiki distant',
	'wikisync_js_last_op_error' => 'La dernière opération a retourné une erreur.

Code : $1

Message : $2

Appuyez sur [OK] pour tenter à nouveau la dernière opération',
	'wikisync_js_synchronization_confirmation' => 'Êtes-vous sûr de vouloir lancer la synchronisation

depuis $1

vers $2

à compter de la révision $3 ?',
	'wikisync_js_synchronization_success' => 'La synchronisation a été complétée avec succès',
	'wikisync_js_already_synchronized' => 'Les wikis source et destination semblent être déjà synchronisés',
	'wikisync_js_sync_to_itself' => 'Vous ne pouvez pas synchroniser le wiki avec lui-même',
	'wikisync_js_diff_search' => 'À la recherche de différences dans les révisions de destination',
	'wikisync_js_revision' => 'Révision $1',
	'wikisync_js_file_size_mismatch' => 'La taille du fichier temporaire « $1 » ($2 octet{{PLURAL:$2||s}}) ne correspond pas à la taille requise ($3 octet{{PLURAL:$3||s}}). Assurez-vous que le fichier « $4 » n’a pas été écrasé manuellement dans le dépôt du wiki source.',
	'wikisync_js_invalid_scheduler_time' => 'La durée du planificateur doit être un nombre entier positif',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|minute restante|minutes restantes}}',
	'wikisync_js_sync_start_ltr' => 'Démarrage de la synchronisation depuis le wiki local vers le wiki distant à $1',
	'wikisync_js_sync_start_rtl' => 'Démarrage de la synchronisation depuis le wiki distant vers le wiki local à $1',
	'wikisync_js_sync_end_ltr' => 'Fin de la synchronisation depuis le wiki local vers le wiki distant à $1',
	'wikisync_js_sync_end_rtl' => 'Fin de la synchronisation depuis le wiki distant vers le wiki local à $1',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'wikisync' => 'Sincronisacion de vouiquis',
	'wikisync-desc' => 'Balye una [[Special:WikiSync|pâge spèciâla]] que pèrmèt de sincronisar los dèrriérs changements dessus doux vouiquis — yon local et yon distant.',
	'wikisync_direction' => 'Volyéd chouèsir la dirèccion de la sincronisacion',
	'wikisync_local_root' => 'Racena du seto vouiqui local',
	'wikisync_remote_root' => 'Racena du seto vouiqui distant',
	'wikisync_remote_log' => 'Jornal de les opèratcions a distance',
	'wikisync_clear_log' => 'Èfaciér lo jornal',
	'wikisync_login_to_remote_wiki' => 'Branchement u vouiqui distant',
	'wikisync_remote_wiki_root' => 'Racena du vouiqui distant',
	'wikisync_remote_wiki_example' => 'Chemin d’accès u api.php, per ègzemplo : http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Nom d’utilisator sur lo vouiqui distant',
	'wikisync_remote_wiki_pass' => 'Contresegno sur lo vouiqui distant',
	'wikisync_remote_login_button' => 'Branchement',
	'wikisync_sync_files' => 'Sincronisar des fichiérs',
	'wikisync_store_password' => 'Stocar lo contresegno du vouiqui distant',
	'wikisync_storing_password_warning' => 'Lo stocâjo d’un contresegno distant est pas sècurisâ et est pas recomandâ',
	'wikisync_synchronization_button' => 'Sincronisar',
	'wikisync_scheduler_log' => 'Jornal du planifior',
	'wikisync_scheduler_setup' => 'Configuracion du planifior',
	'wikisync_scheduler_turn_on' => 'Activar lo planifior',
	'wikisync_scheduler_switch_direction' => 'Bascular ôtomaticament la dirèccion de sincronisacion',
	'wikisync_scheduler_time_interval' => 'Temps en menutes entre-mié les sincronisacions ôtomatiques',
	'wikisync_apply_button' => 'Aplicar',
	'wikisync_log_imported_by' => 'Importâ per [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Tèlèchargiê per [[Special:WikiSync|WikiSync]]',
	'wikisync_api_result_unknown_action' => 'Accion encognua de l’API',
	'wikisync_api_result_exception' => 'Una èxcèpcion est arrevâ pendent l’apèl de l’API locala',
	'wikisync_api_result_noaccess' => 'Solament los membros de {{PLURAL:$2|ceta tropa|cetes tropes}} pôvont fâre cela accion : $1',
	'wikisync_api_result_invalid_parameter' => 'Valor envalida du paramètre',
	'wikisync_api_result_http' => 'Una èrror HTTP est arrevâ pendent la requéta de balyês de l’API distanta',
	'wikisync_api_result_NoName' => 'Vos éd pas dèfeni lo paramètre <code>lgname</code>',
	'wikisync_api_result_Illegal' => 'Vos éd balyê un crouyo nom d’utilisator',
	'wikisync_api_result_NotExists' => 'Lo nom d’utilisator que vos éd balyê ègziste pas',
	'wikisync_api_result_EmptyPass' => 'Vos éd pas dèfeni lo paramètre <code>lgpassword</code> ou ben vos l’éd lèssiê vouedo',
	'wikisync_api_result_WrongPass' => 'Lo contresegno que vos éd balyê est fôx',
	'wikisync_api_result_WrongPluginPass' => 'Lo contresegno que vos éd balyê est fôx',
	'wikisync_api_result_Blocked' => 'L’utilisator est blocâ',
	'wikisync_api_result_mustbeposted' => 'Lo modulo de branchement at fôta d’una requéta POST',
	'wikisync_api_result_no_import_rights' => 'Cél usanciér est pas ôtorisâ a importar des fichiérs de vouedâ XML',
	'wikisync_api_result_Success' => 'Branchiê avouéc reusséta sur lo seto vouiqui distant',
	'wikisync_js_last_op_error' => 'La dèrriére opèracion at retornâ una èrror.

Code : $1

Mèssâjo : $2

Apoyéd dessus [D’acôrd] por tornar tentar la dèrriére opèracion',
	'wikisync_js_synchronization_confirmation' => 'Éte-vos de sûr de volêr emmodar la sincronisacion

dês $1

de vers $2

a comptar de la vèrsion $3 ?',
	'wikisync_js_synchronization_success' => 'La sincronisacion at étâ complètâ avouéc reusséta',
	'wikisync_js_already_synchronized' => 'Los vouiquis sôrsa et dèstinacion semblont étre ja sincronisâs',
	'wikisync_js_sync_to_itself' => 'Vos pouede pas sincronisar lo vouiqui avouéc lui-mémo',
	'wikisync_js_revision' => 'Vèrsion $1',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|menuta que réste|menutes que réstont}}',
	'wikisync_js_sync_start_ltr' => 'Emmodâ de la sincronisacion dês lo vouiqui local de vers lo vouiqui distant a $1',
	'wikisync_js_sync_start_rtl' => 'Emmodâ de la sincronisacion dês lo vouiqui distant de vers lo vouiqui local a $1',
	'wikisync_js_sync_end_ltr' => 'Fin de la sincronisacion dês lo vouiqui local de vers lo vouiqui distant a $1',
	'wikisync_js_sync_end_rtl' => 'Fin de la sincronisacion dês lo vouiqui distant de vers lo vouiqui local a $1',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wikisync' => 'Sincronización de wikis',
	'wikisync-desc' => 'Proporciona unha [[Special:WikiSync|páxina especial]] para sincronizar os cambios recentes de dous wikis: un local e outro remoto',
	'wikisync_direction' => 'Seleccione a dirección da sincronización',
	'wikisync_local_root' => 'Raíz do sitio wiki local',
	'wikisync_remote_root' => 'Raíz do sitio wiki remoto',
	'wikisync_remote_log' => 'Rexistro das operacións remotas',
	'wikisync_clear_log' => 'Limpar o rexistro',
	'wikisync_login_to_remote_wiki' => 'Rexistro no wiki remoto',
	'wikisync_remote_wiki_root' => 'Raíz do wiki remoto',
	'wikisync_remote_wiki_example' => 'Ruta de api.php, por exemplo: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Nome de usuario no wiki remoto',
	'wikisync_remote_wiki_pass' => 'Contrasinal no wiki remoto',
	'wikisync_remote_login_button' => 'Rexistro',
	'wikisync_sync_files' => 'Sincronizar os ficheiros',
	'wikisync_store_password' => 'Almacenar o contrasinal do wiki remoto',
	'wikisync_storing_password_warning' => 'Almacenar o contrasinal remoto é inseguro e non está recomendado',
	'wikisync_synchronization_button' => 'Sincronizar',
	'wikisync_scheduler_log' => 'Rexistro do programador',
	'wikisync_scheduler_setup' => 'Configuración do programador',
	'wikisync_scheduler_turn_on' => 'Activar o programador',
	'wikisync_scheduler_switch_direction' => 'Cambiar automaticamente a dirección da sincronización',
	'wikisync_scheduler_time_interval' => 'Tempo, en minutos, entre as sincronizacións automáticas',
	'wikisync_apply_button' => 'Aplicar',
	'wikisync_log_imported_by' => 'Importado por [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Cargado por [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Só un bot especial como $1 pode realizar as sincronizacións entre wikis. Inicie sesión como $1. Non modifique o nome de $1 entre as sincronizacións, do contrario as revisións nulas de información non se saltarán debidamente (véxase [http://www.mediawiki.org/wiki/Extension:WikiSync] para obter máis información).',
	'wikisync_api_result_unknown_action' => 'Non se coñece esa acción API',
	'wikisync_api_result_exception' => 'Houbo unha excepción na chamada API local',
	'wikisync_api_result_noaccess' => 'Só os membros {{PLURAL:$2|do seguinte grupo|dos seguintes grupos}} poden levar a cabo esta acción: $1',
	'wikisync_api_result_invalid_parameter' => 'O valor do parámetro é inválido',
	'wikisync_api_result_http' => 'Houbo un erro HTTP ao consultar datos da API remota',
	'wikisync_api_result_Unsupported' => 'A súa versión de MediaWiki non está soportada (anterior á 1.15)',
	'wikisync_api_result_NoName' => 'Non definiu o parámetro lgname',
	'wikisync_api_result_Illegal' => 'Deu un nome de usuario inadecuado',
	'wikisync_api_result_NotExists' => 'O nome de usuario que deu non existe',
	'wikisync_api_result_EmptyPass' => 'Non definiu o parámetro lgpassword ou deixouno baleiro',
	'wikisync_api_result_WrongPass' => 'O contrasinal dado é incorrecto',
	'wikisync_api_result_WrongPluginPass' => 'A clave dada é incorrecta',
	'wikisync_api_result_CreateBlocked' => 'O wiki intentou crear automaticamente unha nova conta para vostede, pero o seu enderezo IP foi bloqueado desde a creación da conta',
	'wikisync_api_result_Throttled' => 'Accedeu ao sistema demasiadas veces nun curto espazo de tempo.',
	'wikisync_api_result_Blocked' => 'O usuario está bloqueado',
	'wikisync_api_result_mustbeposted' => 'O módulo de rexistro necesita unha solicitude POST',
	'wikisync_api_result_NeedToken' => 'Ou non proporcionou o pase de rexistro ou a cookie de identificación da sesión. Faga de novo a solicitude co pase e a cookie dados nesta resposta',
	'wikisync_api_result_no_import_rights' => 'Este usuario non ten os permisos necesarios para importar ficheiros de descarga XML',
	'wikisync_api_result_Success' => 'Accedeu ao sistema correctamente no sitio wiki remoto',
	'wikisync_js_last_op_error' => 'A última operación devolveu un erro.

Código: $1

Mensaxe: $2

Prema sobre [OK] para repetir a última operación',
	'wikisync_js_synchronization_confirmation' => 'Está seguro de querer sincronizar

desde $1

cara a $2

comezando a partir da revisión $3?',
	'wikisync_js_synchronization_success' => 'A sincronización completouse correctamente',
	'wikisync_js_already_synchronized' => 'O wiki de orixe e mais o de destino semellan estar xa sincronizados',
	'wikisync_js_sync_to_itself' => 'Non pode sincronizar o wiki consigo mesmo',
	'wikisync_js_diff_search' => 'Buscando as diferenzas nas revisións de destino',
	'wikisync_js_revision' => 'Revisión $1',
	'wikisync_js_file_size_mismatch' => 'O tamaño do ficheiro temporal "$1" ($2 {{PLURAL:$2|byte|bytes}}) non coincide co tamaño necesario ($3 {{PLURAL:$3|byte|bytes}}). Asegúrese de que o ficheiro "$4" non foi sobrescrito manualmente no repositorio do wiki de orixe.',
	'wikisync_js_invalid_scheduler_time' => 'A hora do programador debe ser un número enteiro positivo',
	'wikisync_js_scheduler_countdown' => '{{PLURAL:$1|queda un minuto|quedan $1 minutos}}',
	'wikisync_js_sync_start_ltr' => 'Inicio da sincronización do wiki local co wiki remoto ás $1',
	'wikisync_js_sync_start_rtl' => 'Inicio da sincronización do wiki remoto co wiki local ás $1',
	'wikisync_js_sync_end_ltr' => 'Fin da sincronización do wiki local co wiki remoto ás $1',
	'wikisync_js_sync_end_rtl' => 'Fin da sincronización do wiki remoto co wiki local ás $1',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'wikisync' => 'Wiki-Synchronisierig',
	'wikisync-desc' => 'Stellt e [[Special:WikiSync|Spezialsyte]] z Verfiegig, wu di letschte Änderige vu zwei Wiki, eme Lokalen un eme andere, dermit chenne synchronisiert wäre',
	'wikisync_direction' => 'Bitte d Synchronisierigsrichtig uuswehle',
	'wikisync_local_root' => 'Hauptverzeichnis vum lokale Wiki',
	'wikisync_remote_root' => 'Hauptverzeichnis vum andere Wiki',
	'wikisync_remote_log' => 'Logbuech vu dr extärne Aktivitete',
	'wikisync_clear_log' => 'Logbuech lesche',
	'wikisync_login_to_remote_wiki' => 'Bim andere Wiki aamälde',
	'wikisync_remote_wiki_root' => 'Hauptverzeichnis vum andere Wiki',
	'wikisync_remote_wiki_example' => 'Pfad zue dr api.php, zem Byschpel http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Benutzername bim andere Wiki',
	'wikisync_remote_wiki_pass' => 'Passwort bim andere Wiki',
	'wikisync_remote_login_button' => 'Aamälde',
	'wikisync_sync_files' => 'Dateie synchronisiere',
	'wikisync_store_password' => 'Passwort vum amdere Wiki spychere',
	'wikisync_storing_password_warning' => 'S Spychere vum Passwort vum andere Wiki isch nit sicher un wird nit empfohle',
	'wikisync_synchronization_button' => 'Synchronisiere',
	'wikisync_scheduler_log' => 'Uusfierigs-Logbuech',
	'wikisync_scheduler_setup' => 'Yyrichtig vu dr Uusfierige',
	'wikisync_scheduler_turn_on' => 'Uusfierige aktiviere',
	'wikisync_scheduler_switch_direction' => 'D Richtig vu dr Synchronisierig automatisch ändere',
	'wikisync_scheduler_time_interval' => 'Zyt in Minute zwische automatische Synchronisierige',
	'wikisync_apply_button' => 'Aawände',
	'wikisync_log_imported_by' => 'Importiert vu [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Uffeglade vu [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Numme s Bötli $1 cha Wiki-Synchronisierige durefiere. Bitte due dich als $1 aamälde. De Name $1 derf nit zwüsche de Synchronisierige gänderet werde, wyl sunscht Versione ohni Veränderige nit gscheit übersprunge werde chönne (lueg dezue uff [http://www.mediawiki.org/wiki/Extension:WikiSync] für mee Informatione).',
	'wikisync_api_result_unknown_action' => 'Nit bekannti API-Aktion',
	'wikisync_api_result_exception' => 'Bim lokale API-Ufruef isch e Uusnahm ufträtte',
	'wikisync_api_result_noaccess' => 'Nume Mitglider vu {{PLURAL:$2|derre Benutzergrupp|dänne Benutzergruppe}} chenne die Aktion uusfiere: $1',
	'wikisync_api_result_invalid_parameter' => 'Nit giltige Parameterwärt',
	'wikisync_api_result_http' => 'HTTP-Fähler bim Abfroge vu Date vu dr andere API',
	'wikisync_api_result_Unsupported' => 'Die MediaWiki-Version wird nit unterstitzt (niderer wie 1.15)',
	'wikisync_api_result_NoName' => 'Du hesch kei Parameter „lgname“ aagee',
	'wikisync_api_result_Illegal' => 'Du hesch e nit giltige Benutzername aagee',
	'wikisync_api_result_NotExists' => 'Dr Benutzername, wu Du aagee hesch, git s nit',
	'wikisync_api_result_EmptyPass' => 'Du hesch dr Parameter lgpassword nit aagee oder hesch s Fäld läär gloo',
	'wikisync_api_result_WrongPass' => 'S Passwort, wu Du aagee hesch, isch nit giltig',
	'wikisync_api_result_WrongPluginPass' => 'S Passwort, wu Du aagee hesch, isch nit giltig',
	'wikisync_api_result_CreateBlocked' => 'S Wiki het versuecht, fir di automatisch e nej Benutzerkonto aazlege, aber Dyy IP-Adräss isch fir s Aaletge vu Benutzerkonte gsperrt wore.',
	'wikisync_api_result_Throttled' => 'Du hesch du z vilmol aagmäldet in ere z churze Zyt.',
	'wikisync_api_result_Blocked' => 'Benutzer isch gsperrt.',
	'wikisync_api_result_mustbeposted' => 'S Aamäldmodul brucht e POST-Aafrog',
	'wikisync_api_result_NeedToken' => 'Entweder hesch du kei Aamäld-Token oder kei Sitzig-Ccookie aagee. Bitte frog nomol aa mit em Token un em Cookie, wu in däre Antwort aagee sin.',
	'wikisync_api_result_no_import_rights' => 'Dää Benutzer derf kei XML-Spycheruuszig importiere',
	'wikisync_api_result_Success' => 'Erfolgrych uf em andere Wiki aagmäldet',
	'wikisync_js_last_op_error' => 'Dr letschte Vorgang het zue me Fähler gfiert.

Code: $1

Nochricht: $2

Druck [OK] zum dr letscht Vorgang widerhole',
	'wikisync_js_synchronization_confirmation' => 'Bisch sicher, ass Du wirkli ne Synchronisierig

zwische $1

un $2

ab dr Version $3 witt durfiere?',
	'wikisync_js_synchronization_success' => 'D Synchronisierig isch erfolgrych abgschlosse wore',
	'wikisync_js_already_synchronized' => 'S Quäll- un s Ziil-Wiki sin schyns scho synchronisier',
	'wikisync_js_sync_to_itself' => 'Du chasch des wiki nit mit sich sälber synchronisiere',
	'wikisync_js_diff_search' => 'Am Sueche no Unterschid bi dr Ziilversione',
	'wikisync_js_revision' => 'Version $1',
	'wikisync_js_file_size_mismatch' => 'D Greßi vu dr temporären Datei „$1“ ($2 {{PLURAL:$2|Byte|Bytes}}) entspricht nit dr erforderlige Greßi ($3 {{PLURAL:$3|Byte|Bytes}}). S mueß sichergstellt syy, ass d Datei „$4“ im Repositorium vum Quällwiki nit manuäll iberschribe woren sich.',
	'wikisync_js_invalid_scheduler_time' => 'Dr Uusfierigszytpunkt mueß e positivi ganzi Zahl syy',
	'wikisync_js_scheduler_countdown' => 'No $1 {{PLURAL:$1|Minut|Minute}}',
	'wikisync_js_sync_start_ltr' => 'Synchronisierig vum andre Wiki mit em lokale Wiki fangt aa am $1',
	'wikisync_js_sync_start_rtl' => 'Synchronisierig vum lokale Wiki mit em andre Wiki fangt aa am $1',
	'wikisync_js_sync_end_ltr' => 'Synchronisierig vum andre Wiki mit em lokale Wiki isch fertig gsi am $1',
	'wikisync_js_sync_end_rtl' => 'Synchronisierig vum lokale Wiki mit em andre Wiki isch fertig gsi am $1',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'wikisync_unsupported_user' => "רק משתמש בוט מיוחד $1 יכול לבצע סנכרוני ויקי. נא להיכנס לחשבון $1. אין לשנות את השם של $1 בין הסנכרונים, אחרת התכנה לא תוכל לדלג כראוי על הגרסאות הריקות (למידע נוסף ר' [http://www.mediawiki.org/wiki/Extension:WikiSync]).",
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'wikisync' => 'Wikisynchronizacija',
	'wikisync-desc' => 'Steji [[Special:WikiSync|specialnu stronu]] za synchronizowanje najnowšich změnow dweju wikijow - lokalneho a zdaleneho - k dispoziciji',
	'wikisync_direction' => 'Prošu wubjer směr synchronizacije',
	'wikisync_local_root' => 'Hłowny sydłowy zapis lokalneho wikija',
	'wikisync_remote_root' => 'Hłowny sydłowy zapis zdaleneho wikija',
	'wikisync_remote_log' => 'Protokol zdalenych operacijow',
	'wikisync_clear_log' => 'Protokol wuprózdnić',
	'wikisync_login_to_remote_wiki' => 'Pola zdaleneho wikija so přizjewić',
	'wikisync_remote_wiki_root' => 'Hłowny zapis zdaleneho wikija',
	'wikisync_remote_wiki_example' => 'Šćežka k api.php, na přikład: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Wužiwarske mjeno zdaleneho wikija',
	'wikisync_remote_wiki_pass' => 'Hesło zdaleneho wikija',
	'wikisync_remote_login_button' => 'Přizjewić',
	'wikisync_sync_files' => 'Dataje synchronizować',
	'wikisync_store_password' => 'Hesło zdaleneho wikija składować',
	'wikisync_storing_password_warning' => 'Składowanje hesła zdaleneho wikija je njewěste a so njedoporuča',
	'wikisync_synchronization_button' => 'Synchronizować',
	'wikisync_scheduler_log' => 'Protokol časoweho planowaka',
	'wikisync_scheduler_setup' => 'Konfiguracija časoweho planowaka',
	'wikisync_scheduler_turn_on' => 'Časowy planowak aktiwizować',
	'wikisync_scheduler_switch_direction' => 'Směr synchronizacije awtomatisce přepinyć',
	'wikisync_scheduler_time_interval' => 'Čas w mjeńšinach  mjez awtomatiskimaj synchronizacijomaj',
	'wikisync_apply_button' => 'Nałožić',
	'wikisync_log_imported_by' => 'Importowany přez [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Nahraty přez [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Jenož specialny boćik $1 móže wikisynchronizacije přewjesć. Prošu přizjew so jako $1. Njezměń mjeno $1 mjez synchronizacijemi, hewak so informacionelne prózdne wersije projadnje njepřeskakuja (hlej [http://www.mediawiki.org/wiki/Extension:WikiSync] za dalše informacije).',
	'wikisync_api_result_unknown_action' => 'Njeznata API-akcija',
	'wikisync_api_result_exception' => 'Wuwzaće je při lokalnym API-wołanju wustupiło',
	'wikisync_api_result_noaccess' => 'Jenož čłonojo {{PLURAL:$2|slědowaceje skupiny|slědowaceju skupinow|slědowacych skupinow|slědowacych skupinow}} móža tutu akciju přewjesć: $1',
	'wikisync_api_result_invalid_parameter' => 'Njepłaćiwa parametrowa hódnota',
	'wikisync_api_result_http' => 'HTTP-zmylk při naprašowanju datow wot zdaleneho API',
	'wikisync_api_result_Unsupported' => 'Twoja wersija MediaWiki so njepodpěruje (starša wersija hač 1.15)',
	'wikisync_api_result_NoName' => 'Njejsy parameter lgname stajił',
	'wikisync_api_result_Illegal' => 'Sy njedowolene wužiwarske mjeno podał',
	'wikisync_api_result_NotExists' => 'Wužiwarske mjeno, kotrež sy podak, njeeksistuje.',
	'wikisync_api_result_EmptyPass' => 'Njejsy parameter lgpassword stajił abo sy jón prózdny wostajił',
	'wikisync_api_result_WrongPass' => 'Hesło, kotrež sy podał, je wopak',
	'wikisync_api_result_WrongPluginPass' => 'Hesło, kotrež sy podał, je wopak',
	'wikisync_api_result_CreateBlocked' => 'Wiki je spytał, za tebje nowe konto awtomatisce załožić, ale twoja IP-adresa je za załoženje kontow zablokowana.',
	'wikisync_api_result_Throttled' => 'Sy so w krótkim času přečasto přizjewił.',
	'wikisync_api_result_Blocked' => 'Wužiwar je zablokowany',
	'wikisync_api_result_mustbeposted' => 'Přizjewjenski modul wužaduje sej POST-naprašowanje',
	'wikisync_api_result_NeedToken' => 'Pak njejsy přozjewjenski token pak posedźenski plack podał. Prošu naprašuj znowa z tokenom a plackom, kotrejž buštej w tutej wotmołwje podatej.',
	'wikisync_api_result_no_import_rights' => 'Tutón wužiwar njesmě dataje wućahow ze składowaka we formaće XML importować',
	'wikisync_api_result_Success' => 'Wuspěšnje do zdaleneho wikisydła přizjewjeny',
	'wikisync_js_last_op_error' => 'Poslednja operacija je zmylk wróćiła.

Kode: $1

Zdźělenka: $2

Klikń na [W porjadku], zo by posldenju operaciju wospjetował',
	'wikisync_js_synchronization_confirmation' => 'Chceš woprawdźe 

z $1

do $2

započinajo z wersiju $3 synchronizować?',
	'wikisync_js_synchronization_success' => 'Synchronizacija je so wuspěšnje dokónčiła.',
	'wikisync_js_already_synchronized' => 'Zda so, zo žórłowe a cilowe wikije su hižo synchronizowane',
	'wikisync_js_sync_to_itself' => 'Njemóžeš wiki ze sobu synchronizować',
	'wikisync_js_diff_search' => 'Rozdźěl w cilowych wersijach pytać',
	'wikisync_js_revision' => 'Wersija $1',
	'wikisync_js_file_size_mismatch' => 'Wulkosć nachwilneje dataje "$1" ($2 {{PLURAL:|bajt|bajtaj|bajty|bajtow}}) njewotpowěduje trěbnej wulkosći ($3 {{PLURAL:$3|bajt|bajta|bajty|bajtow}}). Zawěsć, zo dataja "$4" njeje so w repozitoriju žórłoweho wikija manuelnje přepisała.',
	'wikisync_js_invalid_scheduler_time' => 'Čas planowaka dyrbi pozitiwne cyłe čisło',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|mjeńšina|mjeńšinje|mjeńšiny|mjeńšin}} wyše',
	'wikisync_js_sync_start_ltr' => 'Synchronizacija z lokalneho wikija do zdaleneho wikija so $1 započina',
	'wikisync_js_sync_start_rtl' => 'Synchronizacija ze zdaleneho wikija do lokalneho wikija so $1 započina',
	'wikisync_js_sync_end_ltr' => 'Synchronizacija z lokalneho wikija do zdaleneho wikija so $1 započina',
	'wikisync_js_sync_end_rtl' => 'Synchronizacija ze zdaleneho wikija do lokalneho wikija $1 dokónčena',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'wikisync_clear_log' => 'Napló törlése',
	'wikisync_apply_button' => 'Alkalmazás',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wikisync' => 'Synchronisation inter wikis',
	'wikisync-desc' => 'Forni un [[Special:WikiSync|pagina special]] pro synchronisar le modificationes recente de duo wikis - un local e un remote',
	'wikisync_direction' => 'Selige le direction del synchronisation',
	'wikisync_local_root' => 'Directorio principal del sito wiki local',
	'wikisync_remote_root' => 'Directorio principal del sito wiki remote',
	'wikisync_remote_log' => 'Registro de operationes remote',
	'wikisync_clear_log' => 'Rader registro',
	'wikisync_login_to_remote_wiki' => 'Aperir session in wiki remote',
	'wikisync_remote_wiki_root' => 'Directorio principal del wiki remote',
	'wikisync_remote_wiki_example' => 'Cammino verso api.php, per exemplo: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Nomine de usator in wiki remote',
	'wikisync_remote_wiki_pass' => 'Contrasigno in wiki remote',
	'wikisync_remote_login_button' => 'Aperir session',
	'wikisync_sync_files' => 'Synchronisar files',
	'wikisync_store_password' => 'Immagazinar contrasigno wiki remote',
	'wikisync_storing_password_warning' => 'Le immagazinage del contrasigno remote es insecur e non es recommendate',
	'wikisync_synchronization_button' => 'Synchronisar',
	'wikisync_scheduler_log' => 'Registro de planification',
	'wikisync_scheduler_setup' => 'Configuration del planificator',
	'wikisync_scheduler_turn_on' => 'Activar le planificator',
	'wikisync_scheduler_switch_direction' => 'Inverter automaticamente le direction del synchronisation',
	'wikisync_scheduler_time_interval' => 'Tempore in minutas inter synchronisationes automatic',
	'wikisync_apply_button' => 'Applicar',
	'wikisync_log_imported_by' => 'Importate per [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Incargate per [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Solmente un special usator robotic "$1" pote exequer le synchronisationes de wikis. Per favor aperi session como $1. Non cambia le nomine de $1 inter synchronisationes, alteremente le modificationes informative sin alteration del contento non essera correctemente saltate (vide [http://www.mediawiki.org/wiki/Extension:WikiSync] pro plus info).',
	'wikisync_api_result_unknown_action' => 'Action API incognite',
	'wikisync_api_result_exception' => 'Exception occurreva in appello API local',
	'wikisync_api_result_noaccess' => 'Solmente membros del sequente {{PLURAL:$2|gruppo|gruppos}} pote exequer iste action: $1',
	'wikisync_api_result_invalid_parameter' => 'Valor invalide de parametro',
	'wikisync_api_result_http' => 'Error HTTP durante le recuperation de datos ab API remote',
	'wikisync_api_result_Unsupported' => 'Iste version de MediaWiki non es supportate (minus de 1.15)',
	'wikisync_api_result_NoName' => 'Tu non specificava le parametro lgname',
	'wikisync_api_result_Illegal' => 'Tu forniva un nomine de usator invalide',
	'wikisync_api_result_NotExists' => 'Le nomine de usator que tu forniva non existe',
	'wikisync_api_result_EmptyPass' => 'Tu non specificava le parametro lgpassword o tu lo lassava vacue',
	'wikisync_api_result_WrongPass' => 'Le contrasigno que tu forniva es incorrecte',
	'wikisync_api_result_WrongPluginPass' => 'Le contrasigno que tu forniva es incorrecte',
	'wikisync_api_result_CreateBlocked' => 'Le wiki tentava crear automaticamente un nove conto pro te, ma tu adresse IP ha essite blocate del creation de contos',
	'wikisync_api_result_Throttled' => 'Tu ha aperite session troppo de vices durante un curte tempore.',
	'wikisync_api_result_Blocked' => 'Le usator es blocate',
	'wikisync_api_result_mustbeposted' => 'Le modulo de authentication require un requesta POST',
	'wikisync_api_result_NeedToken' => 'Tu non forniva le indicio de session o le cookie "sessionid". Repete le requesta con le indicio e cookie date in iste responsa.',
	'wikisync_api_result_no_import_rights' => 'Iste usator non ha le permission de importar files de datos in XML',
	'wikisync_api_result_Success' => 'Apertura de session in sito wiki remote succedite',
	'wikisync_js_last_op_error' => 'Le ultime operation resultava in un error.

Codice: $1

Message: $2

Preme [OK] pro tentar repeter le ultime operation.',
	'wikisync_js_synchronization_confirmation' => 'Es tu secur de voler synchronisar

de $1
	
a $2
	
a partir del version $3?',
	'wikisync_js_synchronization_success' => 'Synchronisation completate con successo',
	'wikisync_js_already_synchronized' => 'Le wikis de origine e de destination pare esser jam synchronisate',
	'wikisync_js_sync_to_itself' => 'Non es possibile synchronisar un wiki con se mesme',
	'wikisync_js_diff_search' => 'Cerca differentias in versiones de destination',
	'wikisync_js_revision' => 'Version $1',
	'wikisync_js_file_size_mismatch' => 'Le dimension del file temporari "$1" ($2 {{PLURAL:$2|byte|bytes}}) non corresponde al dimension requirite ($3 {{PLURAL:$3|byte|bytes}}). Assecura te que le file $4 non ha essite superscribite manualmente in le deposito del wiki de origine.',
	'wikisync_js_invalid_scheduler_time' => 'Le hora del planificator debe esser un numero integre positive',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|minuta|minutas}} restante',
	'wikisync_js_sync_start_ltr' => 'Initio del synchronisation del wiki local al wiki remote a $1',
	'wikisync_js_sync_start_rtl' => 'Initio del synchronisation del wiki remote al wiki local a $1',
	'wikisync_js_sync_end_ltr' => 'Fin del synchronisation del wiki local al wiki remote a $1',
	'wikisync_js_sync_end_rtl' => 'Fin del synchronisation del wiki remote al wiki local a $1',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'wikisync' => 'Sinkronisasi wiki',
	'wikisync-desc' => 'Menyediakan [[Special:WikiSync|halaman istimewa]] untuk sinkronisasi perubahan terbaru dari dua wiki - satu lokal dan satu luar',
	'wikisync_direction' => 'Silakan pilih arah sinkronisasi',
	'wikisync_local_root' => 'Akar situs wiki lokal',
	'wikisync_remote_root' => 'Akar situs wiki luar',
	'wikisync_remote_log' => 'Log operasi luar',
	'wikisync_clear_log' => 'Hapus log',
	'wikisync_login_to_remote_wiki' => 'Masuk ke wiki luar',
	'wikisync_remote_wiki_root' => 'Akar wiki luar',
	'wikisync_remote_wiki_example' => 'Jalur api.php, misalnya: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Nama pengguna wiki luar',
	'wikisync_remote_wiki_pass' => 'Sandi wiki luar',
	'wikisync_remote_login_button' => 'Masuk',
	'wikisync_sync_files' => 'Sinkronisasi berkas',
	'wikisync_store_password' => 'Simpan sandi wiki luar',
	'wikisync_storing_password_warning' => 'Menyimpan sandi luar tidak aman dan tidak dianjurkan',
	'wikisync_synchronization_button' => 'Sinkronisasi',
	'wikisync_scheduler_log' => 'Log penjadwal',
	'wikisync_scheduler_setup' => 'Penyiapan penjadwal',
	'wikisync_scheduler_turn_on' => 'Aktifkan penjadwal',
	'wikisync_scheduler_switch_direction' => 'Alihkan arah sinkronisasi secara otomatis',
	'wikisync_scheduler_time_interval' => 'Waktu sinkronisasi otomatis (dalam menit)',
	'wikisync_apply_button' => 'Terapkan',
	'wikisync_log_imported_by' => 'Diimpor oleh [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Diunggah oleh [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Hanya pengguna bot khusus $1 yang dapat melakukan sinkronisasi wiki. Silakan login sebagai $1 . Jangan ganti nama $1 pada saat sinkronisasi, atau revisi kosong informatif tidak akan dilewati dengan benar (lihat [http://www.mediawiki.org/wiki/Extension:WikiSync] untuk informasi lebih lanjut).',
	'wikisync_api_result_unknown_action' => 'Tindakan API tidak dikenal',
	'wikisync_api_result_exception' => 'Terjadi kesalahan dalam pemanggilan API lokal',
	'wikisync_api_result_noaccess' => 'Hanya anggota dari {{PLURAL:$2|kelompok|kelompok-kelompok}} berikut yang dapat melakukan tindakan ini: $1',
	'wikisync_api_result_invalid_parameter' => 'Nilai parameter tidak sah',
	'wikisync_api_result_http' => 'Kesalahan HTTP sewaktu mengambil data dari API luar',
	'wikisync_api_result_Unsupported' => 'Versi MediaWiki tidak didukung (lebih lama dari 1.15)',
	'wikisync_api_result_NoName' => 'Anda tidak menetapkan parameter lgname',
	'wikisync_api_result_Illegal' => 'Anda memberikan nama pengguna yang tidak sah',
	'wikisync_api_result_NotExists' => 'Nama pengguna yang Anda berikan tidak ada',
	'wikisync_api_result_EmptyPass' => 'Anda tidak menetapkan parameter lgpassword atau Anda membiarkannya kosong',
	'wikisync_api_result_WrongPass' => 'Sandi yang Anda berikan tidak benar',
	'wikisync_api_result_WrongPluginPass' => 'Sandi yang Anda berikan tidak benar',
	'wikisync_api_result_CreateBlocked' => 'Wiki mencoba untuk secara otomatis membuat akun baru untuk Anda, namun alamat IP Anda telah diblokir dari pembuatan akun',
	'wikisync_api_result_Throttled' => 'Anda telah terlalu sering masuk dalam waktu singkat.',
	'wikisync_api_result_Blocked' => 'Pengguna diblokir',
	'wikisync_api_result_mustbeposted' => 'Modul masuk memerlukan permintaan POST',
	'wikisync_api_result_NeedToken' => 'Anda tidak menyediakan token masuk atau kuki sessionid. Minta lagi dengan token dan kuki yang diberikan di sini',
	'wikisync_api_result_no_import_rights' => 'Pengguna tidak diizinkan untuk mengimpor berkas cadangan XML',
	'wikisync_api_result_Success' => 'Berhasil masuk ke situs wiki luar',
	'wikisync_js_last_op_error' => 'Operasi terakhir memberikan kesalahan.

Kode: $1

Pesan: $2

Tekan [OK] untuk mengulangi operasi terakhir',
	'wikisync_js_synchronization_confirmation' => 'Apakah Anda yakin untuk melakukan sinkronisasi

dari $1

ke $2

mulai dari revisi $3?',
	'wikisync_js_synchronization_success' => 'Sinkronisasi berhasil diselesaikan',
	'wikisync_js_already_synchronized' => 'Wiki sumber dan tujuan tampaknya sudah disinkronkan',
	'wikisync_js_sync_to_itself' => 'Anda tidak dapat menyinkronkan wiki dengan dirinya sendiri',
	'wikisync_js_diff_search' => 'Mencari perbedaan pada revisi tujuan',
	'wikisync_js_revision' => 'Revisi $1',
	'wikisync_js_file_size_mismatch' => 'Ukuran berkas sementara "$1" ($2 {{PLURAL:$2|bita|bita}}) tidak cocok dengan ukuran yang diperlukan ($3 {{PLURAL:$3|bita|bita}}). Pastikan berkas "$4" tidak secara manual ditimpa dalam repositori wiki sumber.',
	'wikisync_js_invalid_scheduler_time' => 'Waktu penjadwal harus berupa bilangan bulat positif',
	'wikisync_js_scheduler_countdown' => 'Tinggal $1 {{PLURAL:$1|menit|menit}}',
	'wikisync_js_sync_start_ltr' => 'Sinkronisasi dari wiki lokal ke wiki luar dimulai pada $1',
	'wikisync_js_sync_start_rtl' => 'Sinkronisasi dari wiki luar ke wiki lokal dimulai pada $1',
	'wikisync_js_sync_end_ltr' => 'Sinkronisasi dari wiki lokal ke wiki luar selesai pada $1',
	'wikisync_js_sync_end_rtl' => 'Sinkronisasi dari wiki luar ke wiki lokal selesai pada $1',
);

/** Japanese (日本語)
 * @author Iwai.masaharu
 * @author Ohgi
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'wikisync' => 'ウィキの同期',
	'wikisync-desc' => 'ローカルとリモートの2つのウィキ間の最近の更新を同期する[[Special:WikiSync|特別ページ]]を提供する',
	'wikisync_direction' => '同期の方向を選択してください。',
	'wikisync_local_root' => 'ローカルのウィキサイトのルート',
	'wikisync_remote_root' => 'リモートのウィキサイトのルート',
	'wikisync_remote_log' => 'リモートの操作記録',
	'wikisync_clear_log' => '記録の消去',
	'wikisync_login_to_remote_wiki' => 'リモートのウィキにログイン',
	'wikisync_remote_wiki_root' => 'リモートのウィキのルート',
	'wikisync_remote_wiki_example' => 'api.phpへのパス（例：http://www.mediawiki.org/w）',
	'wikisync_remote_wiki_user' => 'リモートのウィキの利用者名',
	'wikisync_remote_wiki_pass' => 'リモートのウィキのパスワード',
	'wikisync_remote_login_button' => 'ログイン',
	'wikisync_sync_files' => 'ファイルの同期',
	'wikisync_store_password' => 'リモートのウィキのパスワードを保存',
	'wikisync_storing_password_warning' => 'リモートのパスワードの保存は安全ではなく、推奨されません',
	'wikisync_synchronization_button' => '同期',
	'wikisync_scheduler_log' => 'スケジューラーの記録',
	'wikisync_scheduler_setup' => 'スケジューラーの設定',
	'wikisync_scheduler_turn_on' => 'スケジューラーを有効にする',
	'wikisync_scheduler_switch_direction' => '自動的に同期の方向を切り替え',
	'wikisync_scheduler_time_interval' => '自動的な同期をする時間間隔（分単位）',
	'wikisync_apply_button' => '適用',
	'wikisync_log_imported_by' => '[[Special:WikiSync|ウィキ同期]]によりインポート',
	'wikisync_log_uploaded_by' => '[[Special:WikiSync|ウィキ同期]]によりアップロード',
	'wikisync_unsupported_user' => '$1という特殊なボットだけが同期を実行できます。$1としてログインしてください。$1という名前は同期のあいだ変更しないでください。変更した場合は空の変更が正常にスキップされません（詳細については[http://www.mediawiki.org/wiki/Extension:WikiSync]をご覧ください）。',
	'wikisync_api_result_unknown_action' => '不明なAPI動作',
	'wikisync_api_result_exception' => 'ローカルのAPI呼び出しで例外が発生しました',
	'wikisync_api_result_noaccess' => '次のグループ{{PLURAL:$2|}}の利用者のみが、この操作を実行できます：$1',
	'wikisync_api_result_invalid_parameter' => '不正な引数値',
	'wikisync_api_result_http' => 'リモートのAPIからデータをクエリー中のHTTPエラー',
	'wikisync_api_result_Unsupported' => '使用中のMediaWikiのバージョンはサポートされていません（1.15未満）',
	'wikisync_api_result_NoName' => 'lgname引数は指定できません',
	'wikisync_api_result_Illegal' => '不正な利用者名を指定しました',
	'wikisync_api_result_NotExists' => '指定した利用者名は存在しません',
	'wikisync_api_result_EmptyPass' => 'lgpassword引数を設定しなかったか、空のままでした',
	'wikisync_api_result_WrongPass' => '指定されたパスワードは間違っています',
	'wikisync_api_result_WrongPluginPass' => '指定されたパスワードは間違っています',
	'wikisync_api_result_CreateBlocked' => 'ウィキは新しいアカウントを自動的に作成しようとしましたが、使用中のIPアドレスがアカウントの作成をブロックされています。',
	'wikisync_api_result_Throttled' => '短時間で何度もログインしました',
	'wikisync_api_result_Blocked' => '利用者はブロックされています',
	'wikisync_api_result_mustbeposted' => 'ログイン機能はPOST要求が必要です',
	'wikisync_api_result_NeedToken' => 'ログイントークンか、セッションIDのクッキーのどちらかを指定しませんでした。応答中で返されたトークンとクッキーを指定してもう一度試してください。',
	'wikisync_api_result_no_import_rights' => 'この利用者は、XMLダンプファイルの読み込みを許可されていません',
	'wikisync_api_result_Success' => 'リモートのウィキサイトに正常にログインできました',
	'wikisync_js_last_op_error' => '最後の操作がエラーを返しました。

コード：$1

メッセージ：$2

[OK]を押して、最後の操作を再試行してください',
	'wikisync_js_synchronization_confirmation' => '本当に同期を実行してもよいですか？

同期元：$1

同期先：$2

同期開始版：$3',
	'wikisync_js_synchronization_success' => '同期は正常に完了しました',
	'wikisync_js_already_synchronized' => '同期元と同期先のウィキは、既に同期されているようです',
	'wikisync_js_sync_to_itself' => '同一のウィキ間で同期することはできません',
	'wikisync_js_diff_search' => '同期先の版での差分を探しています',
	'wikisync_js_revision' => '$1版',
	'wikisync_js_file_size_mismatch' => '一時ファイル「$1」のサイズ（$2{{PLURAL:$2|バイト}}）が、必要なサイズ（$3{{PLURAL:$3|バイト}}）と一致しません。ファイル「$4」が同期元のウィキの格納場所に手動で上書きされていないか確認してください。',
	'wikisync_js_invalid_scheduler_time' => 'スケジューラーの時間は正の整数でなければなりません',
	'wikisync_js_scheduler_countdown' => '残り$1{{PLURAL:$1|分}}',
	'wikisync_js_sync_start_ltr' => '$1でローカルのウィキから、リモートのウィキへの同期を開始',
	'wikisync_js_sync_start_rtl' => '$1でリモートのウィキから、ローカルのウィキへの同期を開始',
	'wikisync_js_sync_end_ltr' => '$1でローカルのウィキから、リモートのウィキへの同期を完了',
	'wikisync_js_sync_end_rtl' => '$1でリモートのウィキから、ローカルのウィキへの同期を完了',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'wikisync-desc' => 'Brängk en [[Special:WikiSync|{{int:specialpage}}]] in et Wiki eren, öm de {{lcfirst:{{int:recentchanges}}}} vum eije Wiki un vun enem andere Wiki zosamme ze bränge.',
	'wikisync_remote_login_button' => 'Enlogge',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wikisync' => 'Wiki-Synchronisatioun',
	'wikisync_direction' => "Sicht w.e.g. d'Richtung vun der Synchronisatioun eraus",
	'wikisync_clear_log' => 'Logbuch eidelmaachen',
	'wikisync_remote_login_button' => 'Umellen',
	'wikisync_sync_files' => 'Fichiere synchroniséieren',
	'wikisync_synchronization_button' => 'Synchroniséieren',
	'wikisync_scheduler_turn_on' => "De 'Scheduler' aschalten",
	'wikisync_scheduler_time_interval' => 'Zäit a Minutten tëschen automatesche Synchronisatiounen',
	'wikisync_apply_button' => 'Applizéieren',
	'wikisync_log_imported_by' => 'Vu [[Special:WikiSync|WikiSync]] importéiert',
	'wikisync_log_uploaded_by' => 'Vu [[Special:WikiSync|WikiSync]] eropgelueden',
	'wikisync_api_result_unknown_action' => 'Onbekannten API Aktioun',
	'wikisync_api_result_noaccess' => 'Nëmme Membere {{PLURAL:$2|vum Grupp|vun de Gruppe}} $1 kënnen dës Aktioun duerchféieren',
	'wikisync_api_result_invalid_parameter' => 'Net valabele Wäert vum Parameter',
	'wikisync_api_result_Illegal' => 'Dir hutt en illegale Benotzernumm uginn',
	'wikisync_api_result_NotExists' => 'De Benotzernumm deen Dir uginn hutt gëtt et net',
	'wikisync_api_result_WrongPass' => "D'Passwuert dat Dir ginn hutt ass net richteg",
	'wikisync_api_result_WrongPluginPass' => "D'Passwuert dat Dir uginn hutt ass net richteg",
	'wikisync_api_result_Throttled' => 'Dir hutt Iech während kuerzer Zäit ze dacks ageloggt.',
	'wikisync_api_result_Blocked' => 'Benotzer ass gespaart',
	'wikisync_api_result_no_import_rights' => 'Dëse Benotzer däerf keng XML-Dump-Fichieren importéieren',
	'wikisync_js_synchronization_success' => "D'Synchronisatioun ass komplett ofgeschloss",
	'wikisync_js_already_synchronized' => 'Déi zwou Wikie schénge scho synchroniséiert ze sinn',
	'wikisync_js_sync_to_itself' => "Dir kënnt d'Wiki net mat sech selwer synchroniséieren",
	'wikisync_js_revision' => 'Versioun $1',
	'wikisync_js_scheduler_countdown' => '{{PLURAL:$1|Eng Minutt|$1 Minutten}} iwwreg',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'wikisync' => 'Wiki sinchronizacija',
	'wikisync_direction' => 'Prašome pasirinkti sinchronizacijos kryptį',
	'wikisync_clear_log' => 'Valyti žurnalą',
	'wikisync_remote_login_button' => 'Prisijungti',
	'wikisync_sync_files' => 'Sinchronizuoti failus',
	'wikisync_synchronization_button' => 'Sinchronizuoti',
	'wikisync_scheduler_time_interval' => 'Laikas minutėmis tarp automatinės sinchronizacijos',
	'wikisync_apply_button' => 'Taikyti',
	'wikisync_api_result_unknown_action' => 'Nežinomas API veiksmas',
	'wikisync_api_result_noaccess' => 'Tik nariai tokių {{PLURAL:$2| grupė | grupių}} gali atlikti šį veiksmą: $1',
	'wikisync_api_result_invalid_parameter' => 'Neleistina parametro reikšmė',
	'wikisync_api_result_Unsupported' => 'Jūsų versija MediaWiki yra netinkama (mažiau nei 1.15)',
	'wikisync_api_result_Illegal' => 'Jūs nurodėte neteisėta vardą',
	'wikisync_api_result_NotExists' => 'Pateikėte vartotojo vardą kurio nėra',
	'wikisync_api_result_EmptyPass' => 'Jūs nenustatė lgpassword parametro arba jūs jį palikote tuščia',
	'wikisync_api_result_WrongPass' => 'Slaptažodis yra neteisingas',
	'wikisync_api_result_WrongPluginPass' => 'Slaptažodis yra neteisingas',
	'wikisync_api_result_CreateBlocked' => 'Wiki bandė automatiškai sukurti jums naują sąskaitą, tačiau Jūsų IP adresas yra užblokuotas nuo sąskaitų kūrimo',
	'wikisync_api_result_Throttled' => 'Jūs prisijungėte, per daug kartų per trumpą laiką.',
	'wikisync_api_result_Blocked' => 'Naudotojas yra užblokuotas',
	'wikisync_api_result_no_import_rights' => 'Šis vartotojas neturi teisės importuoti XML failų',
	'wikisync_js_last_op_error' => 'Paskutinė operacija grąžino klaidą.
Kodas: $1
Pranešimas: $2
Paspauskite [OK] Norėdami kartoti paskutinę operaciją',
	'wikisync_js_synchronization_success' => 'Sinchronizavimas buvo sėkmingai baigtas',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1| minutė | minučių}} liko',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wikisync' => 'Усогласување на викија',
	'wikisync-desc' => 'Дава [[Special:WikiSync|специјална страница]] за усогласување на скорешните страници на две викија - локално и далечинско',
	'wikisync_direction' => 'Одберете насока на усогласувањето',
	'wikisync_local_root' => 'Основна адреса на локалното мреж. место',
	'wikisync_remote_root' => 'Основна адреса на далечинското мреж. место',
	'wikisync_remote_log' => 'Дневник на далечински дејства',
	'wikisync_clear_log' => 'Исчисти дневник',
	'wikisync_login_to_remote_wiki' => 'Најава на далечинското вики',
	'wikisync_remote_wiki_root' => 'Основна адреса на викито',
	'wikisync_remote_wiki_example' => 'Патека до api.php, на пример: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Корисничко име на далечинското вики',
	'wikisync_remote_wiki_pass' => 'Лозинка на далечинското вики',
	'wikisync_remote_login_button' => 'Најава',
	'wikisync_sync_files' => 'Усогласи податотеки',
	'wikisync_store_password' => 'Зачувај ја лозинката за далечинското вики',
	'wikisync_storing_password_warning' => 'Складирањето на лозинки за далечинско мреж. место не е безбедно и затоа не се препорачува',
	'wikisync_synchronization_button' => 'Усогласи',
	'wikisync_scheduler_log' => 'Дневник на распоредувачот',
	'wikisync_scheduler_setup' => 'Поставки за распоредувачот',
	'wikisync_scheduler_turn_on' => 'Вклучи го распоредувачот',
	'wikisync_scheduler_switch_direction' => 'Автоматски менувај ја насоката на усогласување',
	'wikisync_scheduler_time_interval' => 'Број на минути помеѓу автоматските усогласувања',
	'wikisync_apply_button' => 'Примени',
	'wikisync_log_imported_by' => 'Увезено со [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Поигнато со [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Услогласувањата на викијата може да ги врши само посебниот бот $1. Најавете се како $1. Не го менувајте името $1 од едно до друго усогласување - во спротивно нема да може правилно да се прескокнат нуларните ревизии (повеќе информации на страницата [http://www.mediawiki.org/wiki/Extension:WikiSync]).',
	'wikisync_api_result_unknown_action' => 'Непознато дејство на API',
	'wikisync_api_result_exception' => 'Се појави исклучок во повикот на локалниот API',
	'wikisync_api_result_noaccess' => 'Само членови на {{PLURAL:$2|следнава  група|следниве групи}} можат да го извршат ова дејство: $1',
	'wikisync_api_result_invalid_parameter' => 'Неважечка вредност за параметарот',
	'wikisync_api_result_http' => 'HTTP-грешка при барањето на податоци од далечинскиот API',
	'wikisync_api_result_Unsupported' => 'Вашата верзија на МедијаВики не е поддржана (постара е од 1.15)',
	'wikisync_api_result_NoName' => 'Не го утврдивте парамтетарот lgname',
	'wikisync_api_result_Illegal' => 'Наведовте недопуштено корисничко име',
	'wikisync_api_result_NotExists' => 'Корисничкото име што го наведовте не постои',
	'wikisync_api_result_EmptyPass' => 'Не го утврдивте параметарот lgpassword или го имате оставено празен',
	'wikisync_api_result_WrongPass' => 'Наведената лозинка е грешна',
	'wikisync_api_result_WrongPluginPass' => 'Наведената лозинка е грешна',
	'wikisync_api_result_CreateBlocked' => 'Викито се обиде автоматски да ви создаде сметка, но вашата IP-адреса е блокирана за создавање сметки',
	'wikisync_api_result_Throttled' => 'Се најавивте премногу пати за кратко време.',
	'wikisync_api_result_Blocked' => 'Корисникот е блокиран',
	'wikisync_api_result_mustbeposted' => 'Најавниот модул бара POST-барање',
	'wikisync_api_result_NeedToken' => 'Немате наведено најавен жетон или колаче за назнаката на сесијата. Поднесете го барањето повторно, со жетонот и колачето наведени во овој одговор',
	'wikisync_api_result_no_import_rights' => 'На корисников не му е дозолено да увезува резервни XML-податотеки',
	'wikisync_api_result_Success' => 'Најавата на далечинското вики е успешна',
	'wikisync_js_last_op_error' => 'Последното дејство врати грешка.

Код: $1

Порака: $2

Притиснете [ОК] за да ја повторите',
	'wikisync_js_synchronization_confirmation' => 'Дали сте сигурни дека сакате да извршите усогласување

од $1

на $2

почнувајќи од ревизијата $3?',
	'wikisync_js_synchronization_success' => 'Усогласувањето е успешно завршено',
	'wikisync_js_already_synchronized' => 'Изворното и целнот вики се веќе усогласени',
	'wikisync_js_sync_to_itself' => 'Не можете да го усогласите викито според самото себе',
	'wikisync_js_diff_search' => 'Барам разлики во ревизиите на целното вики',
	'wikisync_js_revision' => 'Ревизија $1',
	'wikisync_js_file_size_mismatch' => 'Големината на привремената податотека „$1“ ($2 {{PLURAL:$2|бајт|бајти}}) не соодветствува на потребната големина ($3 {{PLURAL:$3|бајт|бајти}}). Проверете дали податотеката „$4“ не била рачно презапишана во складиштето на изворното вики.',
	'wikisync_js_invalid_scheduler_time' => 'Времето за распоредувачот мора да биде позитивен цел број',
	'wikisync_js_scheduler_countdown' => '{{PLURAL:$1|Преостанува $1 минута|Преостануваат $1 минути}}',
	'wikisync_js_sync_start_ltr' => 'Го започнувам усогласувањето од локалното вики на далечинското вики на $1',
	'wikisync_js_sync_start_rtl' => 'Го започнувам усогласувањето од далечинското вики на локалното вики на $1',
	'wikisync_js_sync_end_ltr' => 'Завршив со усогласување од локалното вики на далечинското вики на $1',
	'wikisync_js_sync_end_rtl' => 'Завршив со усогласување од далечинското вики на локалното вики на $1',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wikisync_remote_login_button' => 'Log masuk',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'wikisync' => 'Wikisynchronisatie',
	'wikisync-desc' => "Biedt een [[Special:WikiSync|speciale pagina]] om recente wijzigingen tussen twee wiki's te synchroniseren - de lokale wiki en een andere wiki",
	'wikisync_direction' => 'Kies de richting van de synchronisatie',
	'wikisync_local_root' => 'Siteroot van de lokale wiki',
	'wikisync_remote_root' => 'Siteroot van de andere wiki',
	'wikisync_remote_log' => 'Logboek externe activiteiten',
	'wikisync_clear_log' => 'Logboek wissen',
	'wikisync_login_to_remote_wiki' => 'Aanmelden bij andere wiki',
	'wikisync_remote_wiki_root' => 'Root andere wiki',
	'wikisync_remote_wiki_example' => 'Pad naar api.php, bijvoorbeeld http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Gebruikersnaam andere wiki',
	'wikisync_remote_wiki_pass' => 'Wachtwoord andere wiki',
	'wikisync_remote_login_button' => 'Aanmelden',
	'wikisync_sync_files' => 'Bestanden synchroniseren',
	'wikisync_store_password' => 'Wachtwoord van de andere wiki opslaan',
	'wikisync_storing_password_warning' => 'Het opslaan van het externe wachtwoord is onveilig en is niet aan te raden',
	'wikisync_synchronization_button' => 'Synchroniseren',
	'wikisync_scheduler_log' => 'Taakplannerlogboek',
	'wikisync_scheduler_setup' => 'Taakplannerinstellingen',
	'wikisync_scheduler_turn_on' => 'Taakplanner inschakelen',
	'wikisync_scheduler_switch_direction' => 'Automatisch de richting van synchronisatie wijzigen',
	'wikisync_scheduler_time_interval' => 'Tijd in minuten tussen automatische synchronisaties',
	'wikisync_apply_button' => 'Toepassen',
	'wikisync_log_imported_by' => 'Geïmporteerd via [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Geüpload via [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Alleen een speciale robotgebruiker $1 kan wikisynchronisaties uitvoeren. Meld aan als $1. Wijzig de naam $1 niet tussen synchronisaties niet, omdat lege versies anders waarschijnlijk niet correct worden overgeslagen. Zie [http://www.mediawiki.org/wiki/Extension:WikiSync] voor meer informatie.',
	'wikisync_api_result_unknown_action' => 'Onbekende API-handeling',
	'wikisync_api_result_exception' => 'Er is een fout opgetreden in de lokale API-aanroep',
	'wikisync_api_result_noaccess' => 'Alleen leden van de volgende {{PLURAL:$2|groep|groepen}} kunnen deze handeling uitvoeren: $1',
	'wikisync_api_result_invalid_parameter' => 'Ongeldige waarde voor parameter',
	'wikisync_api_result_http' => 'Er is een HTTP-fout opgetreden tijdens het opvragen van gegevens via de API van de andere wiki',
	'wikisync_api_result_Unsupported' => 'Uw versie van MediaWiki wordt niet ondersteund (lager dan 1.15)',
	'wikisync_api_result_NoName' => 'U hebt de parameter "lgname" niet ingesteld',
	'wikisync_api_result_Illegal' => 'U hebt een ongeldige gebruikersnaam opgegeven',
	'wikisync_api_result_NotExists' => 'De gebruikersnaam die u hebt opgegeven bestaat niet',
	'wikisync_api_result_EmptyPass' => 'U hebt de parameter "lgpassword" niet ingesteld of leeg gelaten',
	'wikisync_api_result_WrongPass' => 'Het wachtwoord dat u hebt opgegeven is niet correct',
	'wikisync_api_result_WrongPluginPass' => 'Het wachtwoord dat u hebt opgegeven is niet correct',
	'wikisync_api_result_CreateBlocked' => 'De wiki heeft geprobeerd automatisch een gebruiker voor u aan te maken, maar via uw IP-adres mogen geen gebruikers aangemaakt worden',
	'wikisync_api_result_Throttled' => 'U bent te vaak aangemeld in een korte tijd.',
	'wikisync_api_result_Blocked' => 'De gebruiker is geblokkeerd',
	'wikisync_api_result_mustbeposted' => 'De aanmeldmodule vereist een POST-aanvraag',
	'wikisync_api_result_NeedToken' => 'U hebt het aanmeldtoken of het cookie met het sessie-ID niet opgegeven. Probeer het opnieuw met het in dit antwoord geleverde token en cookie',
	'wikisync_api_result_no_import_rights' => 'Deze gebruiker mag geen XML-dumpbestanden importeren',
	'wikisync_api_result_Success' => 'Aangemeld bij de andere wiki',
	'wikisync_js_last_op_error' => 'De laatste handeling heeft een fout opgeleverd.

Code: $1

Bericht: $2

Klik [OK] om de laatste handeling te herhalen.',
	'wikisync_js_synchronization_confirmation' => 'Weet u zeker dat u wilt synchroniseren

van $1

naar $2

vanaf versie $3?',
	'wikisync_js_synchronization_success' => 'De synchronisatie is voltooid',
	'wikisync_js_already_synchronized' => "Bron- en doelwiki's lijken al te zijn gesynchroniseerd",
	'wikisync_js_sync_to_itself' => 'U kunt de wiki niet naar zichzelf synchroniseren',
	'wikisync_js_diff_search' => 'Op zoek naar verschillen in doelversies',
	'wikisync_js_revision' => 'versie $1',
	'wikisync_js_file_size_mismatch' => 'De grootte van het tijdelijke bestand "$1" ($2 {{PLURAL:$2|byte|bytes}}) komt niet overeen met de vereiste grootte ($3 {{PLURAL:$3|byte|bytes}}). Controleer of het bestand "$4" niet handmatig overschreven is in de bronwiki.',
	'wikisync_js_invalid_scheduler_time' => 'De taakplannertijd moet een positief geheel getal zijn',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|minuut|minuten}} te gaan',
	'wikisync_js_sync_start_ltr' => 'De synchronisatie van de lokale wiki naar de externe wiki wordt gestart op $1',
	'wikisync_js_sync_start_rtl' => 'De synchronisatie van de externe wiki naar de lokale wiki wordt gestart op $1',
	'wikisync_js_sync_end_ltr' => 'De synchronisatie van de lokale wiki naar de externe wiki is afgerond op $1',
	'wikisync_js_sync_end_rtl' => 'De synchronisatie van de externe wiki naar de lokale wiki is afgerond op $1',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'wikisync' => 'Synchronizacja wiki',
	'wikisync-desc' => 'Dodaje [[Special:WikiSync|stronę specjalną]] służącą do synchronizacji ostatnich zmian pomiędzy dwoma wiki – lokalną i zdalną',
	'wikisync_direction' => 'Wybierz kierunek synchronizacji',
	'wikisync_local_root' => 'Katalog główny witryny lokalnej wiki',
	'wikisync_remote_root' => 'Katalog główny witryny zdalnej wiki',
	'wikisync_remote_log' => 'Rejestr operacji zdalnych',
	'wikisync_clear_log' => 'Wyczyść rejestr',
	'wikisync_login_to_remote_wiki' => 'Zaloguj się do zdalnej wiki',
	'wikisync_remote_wiki_root' => 'Katalog główny zdalnej wiki',
	'wikisync_remote_wiki_example' => 'Ścieżka do „api.php”, na przykład „http://www.mediawiki.org/w”',
	'wikisync_remote_wiki_user' => 'Nazwa użytkownika zdalnej wiki',
	'wikisync_remote_wiki_pass' => 'Hasło do zdalnej wiki',
	'wikisync_remote_login_button' => 'Zaloguj się',
	'wikisync_sync_files' => 'Synchronizuj pliki',
	'wikisync_store_password' => 'Zapamiętaj hasło do zdalnej wiki',
	'wikisync_storing_password_warning' => 'Przechowywanie hasła zdalnego nie jest bezpiecznie i nie jest zalecane',
	'wikisync_synchronization_button' => 'Synchronizuj',
	'wikisync_scheduler_log' => 'Rejestr harmonogramu',
	'wikisync_scheduler_setup' => 'Ustawienia harmonogramu',
	'wikisync_scheduler_turn_on' => 'Włącz harmonogram',
	'wikisync_scheduler_switch_direction' => 'Automatycznie przełącz kierunek synchronizacji',
	'wikisync_scheduler_time_interval' => 'Czas w minutach pomiędzy automatycznymi synchronizowaniami',
	'wikisync_apply_button' => 'Zastosuj',
	'wikisync_log_imported_by' => 'Zaimportowane przez [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Przesłane przez [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Wyłącznie użytkownik $1, który jest specjalnym botem może wykonać synchronizację wiki. Zaloguj się jako $1. Nie należy zmieniać nazwy $1 pomiędzy synchronizacjami, w przeciwnym wypadku puste zmiany nie będą poprawnie pomijane (więcej informacji na stronie [http://www.mediawiki.org/wiki/Extension:WikiSync]).',
	'wikisync_api_result_unknown_action' => 'Nieznane działanie API',
	'wikisync_api_result_exception' => 'Wystąpił wyjątek w lokalnym wywołaniu API',
	'wikisync_api_result_noaccess' => 'Wykonać tę akcję mogą wyłącznie członkowie {{PLURAL:$2|grupy|następujących grup:}} $1',
	'wikisync_api_result_invalid_parameter' => 'Nieprawidłowa wartość parametru',
	'wikisync_api_result_http' => 'Wystąpił błąd HTTP podczas zapytania o dane ze zdalnego API',
	'wikisync_api_result_Unsupported' => 'Ta wersja MediaWiki nie jest wspierana (niższa od 1.15)',
	'wikisync_api_result_NoName' => 'Nie ustawiłeś parametru „lgname”',
	'wikisync_api_result_Illegal' => 'Podałeś niedopuszczalną nazwę użytkownika',
	'wikisync_api_result_NotExists' => 'Nie istnieje użytkownik o nazwie, którą podałeś',
	'wikisync_api_result_EmptyPass' => 'Nie ustawiłeś wartości parametru „lgpassword” lub pozostawiłeś ją pustą',
	'wikisync_api_result_WrongPass' => 'Podane hasło jest nieprawidłowe',
	'wikisync_api_result_WrongPluginPass' => 'Podane hasło jest nieprawidłowe',
	'wikisync_api_result_CreateBlocked' => 'Wiki próbowała utworzyć dla Ciebie nowe konto, ale dla Twojego adresu IP zablokowano możliwość tworzenia kont',
	'wikisync_api_result_Throttled' => 'Zalogowałeś się zbyt wiele razy w zbyt krótkim przedziale czasu.',
	'wikisync_api_result_Blocked' => 'Użytkownik jest zablokowany',
	'wikisync_api_result_mustbeposted' => 'Moduł logowania wymaga użycia metody POST',
	'wikisync_api_result_NeedToken' => 'Brak żetonu logowania lub ciasteczka z identyfikatorem sesji. Ponów zapytanie z żetonem oraz ciasteczkiem podanych w tej odpowiedzi',
	'wikisync_api_result_no_import_rights' => 'Ten użytkownik nie ma możliwości importu plików zrzutu w formacie XML',
	'wikisync_api_result_Success' => 'Zalogowano do zdalnej wiki',
	'wikisync_js_last_op_error' => 'Ostatnia operacja zwróciła błąd.

Kod – $1.

Komunikat – $2

Wciśnij „OK” aby ponowić ostatnią operację',
	'wikisync_js_synchronization_confirmation' => 'Czy na pewno chcesz zsynchronizować

$2

z $1

rozpoczynając od wersji $3?',
	'wikisync_js_synchronization_success' => 'Synchronizacja została zakończona',
	'wikisync_js_already_synchronized' => 'Źródłowa i docelowa wiki wyglądają na zsynchronizowane',
	'wikisync_js_sync_to_itself' => 'Nie możesz zsynchronizować wiki z nią samą',
	'wikisync_js_diff_search' => 'Wyszukiwanie różnic w docelowych wersjach',
	'wikisync_js_revision' => 'Wersja $1',
	'wikisync_js_file_size_mismatch' => 'Rozmiar pliku tymczasowego „$1” ($2 {{PLURAL:$2|bajt|bajty|bajtów}}) jest różny od wymaganego ($3 {{PLURAL:$3|bajt|bajty|bajtów}}). Upewnij się, że plik „$4” znajdujący się w repozytorium źródłowej wiki, nie został ręcznie nadpisany.',
	'wikisync_js_invalid_scheduler_time' => 'Czas harmonogramu musi być zapisany dodatnią całkowitą liczbą',
	'wikisync_js_scheduler_countdown' => '{{PLURAL:$1|pozostała $1 minuta|pozostały $1 minuty|pozostało $1 minut}}',
	'wikisync_js_sync_start_ltr' => 'Uruchamianie synchronizacji z lokalnej do zdalnej wiki $1',
	'wikisync_js_sync_start_rtl' => 'Uruchamianie synchronizacji ze zdalnej do lokalnej wiki $1',
	'wikisync_js_sync_end_ltr' => 'Zakończenie synchronizacji z lokalnej do zdalnej wiki $1',
	'wikisync_js_sync_end_rtl' => 'Zakończenie synchronizacji ze zdalnej do lokalnej wiki $1',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'wikisync' => 'Sincronisassion ëd wiki',
	'wikisync-desc' => "A dà na [[Special:WikiSync|pàgina special]] për sincronisé j'ùltime modìfiche ëd doe wiki, un-a local e un-a lontan-a",
	'wikisync_direction' => 'Për piasì sern la diression ëd la sincronisassion',
	'wikisync_local_root' => 'Radis dël sit ëd la wiki local',
	'wikisync_remote_root' => 'Radis dël sit ëd la wiki lontan-a',
	'wikisync_remote_log' => "Registr ëd j'operassion lontan-e",
	'wikisync_clear_log' => 'Scancelé ël registr',
	'wikisync_login_to_remote_wiki' => 'Intré ant ël sistema ëd la wiki lontan-a',
	'wikisync_remote_wiki_root' => 'Radis ëd la wiki lontan-a',
	'wikisync_remote_wiki_example' => 'Përcors a api.php, për esempi: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Stranòm an sla wiki lontan-a',
	'wikisync_remote_wiki_pass' => 'Ciav an sla wiki lontan-a',
	'wikisync_remote_login_button' => 'Intré ant ël sistema',
	'wikisync_sync_files' => "Sincronisé dj'archivi",
	'wikisync_store_password' => 'Memorisé la ciav ëd la wiki lontan-a',
	'wikisync_storing_password_warning' => "La memorisassion ëd na ciav leugna a l'é pa sigur e a l'é pa racomandà",
	'wikisync_synchronization_button' => 'Sincronisa',
	'wikisync_scheduler_log' => 'Registr dël pianificator',
	'wikisync_scheduler_setup' => 'Ampostassion dël pianificator',
	'wikisync_scheduler_turn_on' => 'Ativé ël pianificator',
	'wikisync_scheduler_switch_direction' => 'Cangia automaticament la diression ëd la sincronisassion',
	'wikisync_scheduler_time_interval' => 'Temp an minute tra sincronisassion automàtiche',
	'wikisync_apply_button' => 'Fà',
	'wikisync_log_imported_by' => 'Amportà da [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Carià da [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => "Mach un trigomiro special $1 a peul fé le sincronisassion ëd le wiki. Për piasì, ch'a intra ant ël sistema com $1. Ch'a cangia pa ël nòm ëd $1 tra le sincronisassion, dësnò le revision ch'a l'han gnun-e anformassion a saran pa sautà për da bin (vëdde [http://www.mediawiki.org/wiki/Extension:WikiSync] për savèjne ëd pi).",
	'wikisync_api_result_unknown_action' => "Assion d'API pa conossùa",
	'wikisync_api_result_exception' => "Ecession capità ant la ciamà d'API local",
	'wikisync_api_result_noaccess' => 'Mach ij mémber ëd {{PLURAL:$2|la partìa|le partìe}} sì-sota a peulo fé costa assion-sì: $1',
	'wikisync_api_result_invalid_parameter' => 'Valor dël paràmetr pa bon',
	'wikisync_api_result_http' => "Eror HTTP antramentre ch'as ciamavo dij dat da l'API lontan-a",
	'wikisync_api_result_Unsupported' => "Soa version ëd MediaWiki a l'é pa sostnùa (anferior a 1.15)",
	'wikisync_api_result_NoName' => "It l'has pa ampostà ëd paràmetr lgname",
	'wikisync_api_result_Illegal' => "A l'ha dàit në stranòm pa bon",
	'wikisync_api_result_NotExists' => "La stranòm ch'a l'ha dàit a esist pa",
	'wikisync_api_result_EmptyPass' => "It l'has pa ampostà ël paràmetr lgpassword o it l'has lassalo veuid",
	'wikisync_api_result_WrongPass' => "La ciav ch'it l'has dàit a l'é pa giusta",
	'wikisync_api_result_WrongPluginPass' => "La ciav ch'it l'has dàit a l'é pa giusta",
	'wikisync_api_result_CreateBlocked' => "La wiki a l'ha provà a creé automaticament un cont neuv për chiel, ma soa adrëssa IP a l'é stàita blocà contra la creassion ëd cont",
	'wikisync_api_result_Throttled' => "A l'é intrà ant ël sistema tròpe vire an pòch temp.",
	'wikisync_api_result_Blocked' => "L'utent a l'é blocà",
	'wikisync_api_result_mustbeposted' => "Ël mòdul d'intrada ant ël sistema a l'ha da manca ëd n'arcesta POST",
	'wikisync_api_result_NeedToken' => "O a l'ha pa dàit ël geton ëd conession o ël bëscotin d'identificassion ëd session. Ch'a ciama torna con ël geton e ël bëscotin dàit an costa rispòsta",
	'wikisync_api_result_no_import_rights' => "Cost utent a peul pa amporté dj'archivi ëd dësvuidament XML",
	'wikisync_api_result_Success' => 'Intrà ant ël sistema për da bin ant ël sit ëd la wiki lontan-a',
	'wikisync_js_last_op_error' => "L'ùltima operassion a l'ha dàit n'eror.

Còdes: $1

Mëssagi: $2

Ch'a sgnaca [Va bin] për prové torna l'ùltima operassion",
	'wikisync_js_synchronization_confirmation' => 'Ses-to sigur ëd vorèj sincronisé

da $1

a $2

an partend da la revision $3?',
	'wikisync_js_synchronization_success' => "La sincronisassion a l'é stàita completà da bin",
	'wikisync_js_already_synchronized' => 'Le wiki ëd sorgiss e destinassion a smijo esse già stàite sincronisà',
	'wikisync_js_sync_to_itself' => 'It peule pa sincronisé la wiki midema',
	'wikisync_js_diff_search' => 'Vardé le diferense ant le revision ëd destinassion',
	'wikisync_js_revision' => 'Revision $1',
	'wikisync_js_file_size_mismatch' => 'La dimension ëd l\'archivi temporani "$1" ($2 {{PLURAL:$2|byte|byte}}) a corëspond pa a la dimension ch\'a-i va ($3 {{PLURAL:$3|byte|byte}}). Ch\'as sicura che l\'archivi "$4" a sia pa stàit coatà a man ant ël depòsit ëd la wiki sorgiss.',
	'wikisync_js_invalid_scheduler_time' => 'Ël temp dël pianificator a dev esse un nùmer antregh positiv',
	'wikisync_js_scheduler_countdown' => 'A-i resto $1 {{PLURAL:$1|minuta|minute}}',
	'wikisync_js_sync_start_ltr' => 'Ancaminé la sincronisassion da la wiki local a la wiki lontan-a a $1',
	'wikisync_js_sync_start_rtl' => 'Ancaminé la sincronisassion da la wiki lontan-a a la wiki local a $1',
	'wikisync_js_sync_end_ltr' => 'Finì la sincronisassion da la wiki local a la wiki lontan-a a $1',
	'wikisync_js_sync_end_rtl' => 'Finì la sincronisassion da la wiki lontan-a a la wiki local a $1',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wikisync_remote_login_button' => 'ننوتل',
	'wikisync_api_result_Blocked' => 'پر کارن بنديز لګېدلی',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'wikisync' => 'Sincronização de wikis',
	'wikisync-desc' => 'Fornece uma [[Special:WikiSync|página especial]] para sincronizar as mudanças recentes de duas wikis - uma local e outra remota',
	'wikisync_direction' => 'Escolha a direcção da sincronização',
	'wikisync_local_root' => 'Raiz do site da wiki local',
	'wikisync_remote_root' => 'Raiz do site da wiki remota',
	'wikisync_remote_log' => 'Registo de operações remotas',
	'wikisync_clear_log' => 'Limpar o registo',
	'wikisync_login_to_remote_wiki' => 'Entrar na wiki remota',
	'wikisync_remote_wiki_root' => 'Raiz da wiki remota',
	'wikisync_remote_wiki_example' => 'Caminho para o ficheiro api.php, por exemplo: http:/www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Nome de utilizador na wiki remota',
	'wikisync_remote_wiki_pass' => 'Palavra-chave na wiki remota',
	'wikisync_remote_login_button' => 'Autenticação',
	'wikisync_sync_files' => 'Sincronizar ficheiros',
	'wikisync_store_password' => 'Guardar a palavra-chave da wiki remota',
	'wikisync_storing_password_warning' => 'Armazenar a palavra-chave remota é inseguro e não é recomendado',
	'wikisync_synchronization_button' => 'Sincronizar',
	'wikisync_scheduler_log' => 'Registo de agendamentos',
	'wikisync_scheduler_setup' => 'Configuração de agendamentos',
	'wikisync_scheduler_turn_on' => 'Activar a execução dos agendamentos',
	'wikisync_scheduler_switch_direction' => 'Inverter automaticamente a direcção da sincronização',
	'wikisync_scheduler_time_interval' => 'Intervalo, em minutos, entre sincronizações automáticas',
	'wikisync_apply_button' => 'Aplicar',
	'wikisync_log_imported_by' => 'Importação de [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Upload de [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'A sincronização de wikis só pode ser realizada pelo utilizador robô especial $1. Autentique-se como $1, por favor. Não altere o nome $1 entre as sincronizações, pois de outra forma as revisões nulas informativas não serão devidamente ignoradas (consulte [http://www.mediawiki.org/wiki/Extension:WikiSync] para mais informações).',
	'wikisync_api_result_unknown_action' => 'Operação desconhecida da API',
	'wikisync_api_result_exception' => 'Ocorreu uma excepção na chamada local da API',
	'wikisync_api_result_noaccess' => 'Esta operação só pode ser executada pelos membros {{PLURAL:$2|do seguinte grupo|dos seguintes grupos}}: $1',
	'wikisync_api_result_invalid_parameter' => 'O valor do parâmetro é inválido',
	'wikisync_api_result_http' => 'Ocorreu um erro de HTTP ao fazer uma consulta de dados pela API remota',
	'wikisync_api_result_Unsupported' => 'A sua versão do MediaWiki não é suportada (anterior à 1.15)',
	'wikisync_api_result_NoName' => 'Não definiu o parâmetro lgname',
	'wikisync_api_result_Illegal' => 'O nome de utilizador fornecido não é adequado',
	'wikisync_api_result_NotExists' => 'O nome de utilizador fornecido não existe',
	'wikisync_api_result_EmptyPass' => 'Não definiu o parâmetro lgpassword, ou deixou-o vazio',
	'wikisync_api_result_WrongPass' => 'A palavra-chave fornecida está incorrecta',
	'wikisync_api_result_WrongPluginPass' => 'A palavra-chave fornecida está incorrecta',
	'wikisync_api_result_CreateBlocked' => 'A wiki tentou criar automaticamente uma conta nova para si, mas a criação de contas foi bloqueada para o seu endereço IP',
	'wikisync_api_result_Throttled' => 'Autenticou-se demasiadas vezes num curto espaço de tempo.',
	'wikisync_api_result_Blocked' => 'O utilizador está bloqueado',
	'wikisync_api_result_mustbeposted' => 'O módulo de autenticação requer um pedido POST',
	'wikisync_api_result_NeedToken' => 'Não forneceu uma chave de autenticação ou um cookie de identificação da sessão. Faça o pedido novamente com a chave e o cookie desta resposta',
	'wikisync_api_result_no_import_rights' => 'Este utilizador não pode importar ficheiros de arquivo XML',
	'wikisync_api_result_Success' => 'Foi autenticado no site da wiki remota',
	'wikisync_js_last_op_error' => 'A última operação retornou um erro. 

 Código: $1 

 Mensagem: $2 

 Pressione [OK] para repetir a última operação',
	'wikisync_js_synchronization_confirmation' => 'Tem a certeza de que quer sincronizar 

 de $1 

 para $2 

 a partir da revisão $3?',
	'wikisync_js_synchronization_success' => 'A sincronização terminou com êxito',
	'wikisync_js_already_synchronized' => 'As wikis de origem e destino parecem já estar sincronizadas',
	'wikisync_js_sync_to_itself' => 'Não pode sincronizar a wiki consigo própria',
	'wikisync_js_diff_search' => 'A procurar a diferença nas revisões de destino',
	'wikisync_js_revision' => 'Revisão $1',
	'wikisync_js_file_size_mismatch' => 'O tamanho ($2 {{PLURAL:$2|byte|bytes}}) do ficheiro temporário "$1" não corresponde ao tamanho requerido ($3 {{PLURAL:$3|byte|bytes}}). Certifique-se de que o ficheiro "$4" não foi alterado manualmente no repositório da wiki de origem.',
	'wikisync_js_invalid_scheduler_time' => 'A hora dos agendamentos tem de ser um número inteiro positivo',
	'wikisync_js_scheduler_countdown' => 'faltam $1 {{PLURAL:$1|minuto|minutos}}',
	'wikisync_js_sync_start_ltr' => 'A sincronização a partir da wiki local para a wiki remota foi iniciada às $1',
	'wikisync_js_sync_start_rtl' => 'A sincronização a partir da wiki remota para a wiki local foi iniciada às $1',
	'wikisync_js_sync_end_ltr' => 'A sincronização a partir da wiki local para a wiki remota foi concluída às $1',
	'wikisync_js_sync_end_rtl' => 'A sincronização a partir da wiki remota para a wiki local foi concluída às $1',
);

/** Russian (Русский)
 * @author QuestPC
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'wikisync' => 'Синхронизация вики сайтов',
	'wikisync-desc' => 'Предоставляет специальную страницу [[Special:WikiSync]] для автоматической синхронизации последних изменений двух вики-сайтов - удалённого сайта и его локальной копии.',
	'wikisync_direction' => 'Пожалуйста выберите направление синхронизации',
	'wikisync_local_root' => 'Корневой адрес локального сайта',
	'wikisync_remote_root' => 'Корневой адрес удалённого сайта',
	'wikisync_remote_log' => 'Журнал удалённых действий',
	'wikisync_clear_log' => 'Очистить журнал',
	'wikisync_login_to_remote_wiki' => 'Зайти на удалённый сайт',
	'wikisync_remote_wiki_root' => 'Корневой адрес удалённого сайта',
	'wikisync_remote_wiki_example' => 'путь к api.php, например: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Имя пользователя удалённого сайта',
	'wikisync_remote_wiki_pass' => 'Пароль на удалённом сайте',
	'wikisync_remote_login_button' => 'Зайти',
	'wikisync_sync_files' => 'Синхронизировать файлы',
	'wikisync_store_password' => 'Сохранить пароль удалённого сайта',
	'wikisync_storing_password_warning' => 'Сохранение пароля удалённого сайта является небезопасным и поэтому не рекомендуется',
	'wikisync_synchronization_button' => 'Синхронизировать',
	'wikisync_scheduler_log' => 'Журнал планировщика',
	'wikisync_scheduler_setup' => 'Настройки планировщика',
	'wikisync_scheduler_turn_on' => 'Включить планировщик',
	'wikisync_scheduler_switch_direction' => 'Автоматически изменять направление синхронизации',
	'wikisync_scheduler_time_interval' => 'Количество минут между автоматическими синхронизациями',
	'wikisync_apply_button' => 'Применить',
	'wikisync_log_imported_by' => 'Импортировано с помощью [[Special:WikiSync]]',
	'wikisync_log_uploaded_by' => 'Загружено с помощью [[Special:WikiSync]]',
	'wikisync_unsupported_user' => 'Только специальный бот под именем $1 может синхронизировать вики сайты. Пожалуйста зайдите как пользователь $1. Не изменяйте имя учетной записи $1 между синхронизациями, в противном случае информационные нулевые ревизии не будут правильно пропущены (см. [http://www.mediawiki.org/wiki/Extension:WikiSync] для более подробной информации).',
	'wikisync_api_result_unknown_action' => 'Неизвестное действие (action) API',
	'wikisync_api_result_exception' => 'Произошло исключение в местном API-вызове',
	'wikisync_api_result_noaccess' => 'Только пользователи из {{PLURAL:$2|следующей группы|следующих групп}} могут выполнять указанное действие: $1',
	'wikisync_api_result_invalid_parameter' => 'Недопустимое значение параметра',
	'wikisync_api_result_http' => 'Ошибка HTTP при запросе данных из отдаленного API',
	'wikisync_api_result_Unsupported' => 'Ваша версия MediaWiki не поддерживается (менее 1.15)',
	'wikisync_api_result_NoName' => 'Вы не установили параметр lgname',
	'wikisync_api_result_Illegal' => 'Недопустимое имя пользователя',
	'wikisync_api_result_NotExists' => 'Такого пользователя не существует',
	'wikisync_api_result_EmptyPass' => 'Вы не установили параметр lgpassword, или оставили его пустым',
	'wikisync_api_result_WrongPass' => 'Неверный пароль',
	'wikisync_api_result_WrongPluginPass' => 'Неверный пароль для плагина авторизации',
	'wikisync_api_result_CreateBlocked' => 'Вики попыталась автоматически создать для вас новую учетную запись, но для вашего IP-адреса установлен запрет на создание учётных записей',
	'wikisync_api_result_Throttled' => 'Слишком много логинов в течение короткого времени.',
	'wikisync_api_result_Blocked' => 'Пользователь заблокирован',
	'wikisync_api_result_mustbeposted' => 'Модуль входа требует POST-запрос',
	'wikisync_api_result_NeedToken' => 'Вы не указали либо токен входа, либо куку SessionID. Повторите запрос с токеном или кукой, указанными в данном ответе',
	'wikisync_api_result_no_import_rights' => 'У пользователя нет прав на импортирование xml дампов',
	'wikisync_api_result_Success' => 'Успешный заход на удалённый вики сайт',
	'wikisync_js_last_op_error' => 'Последнее действие вызвало ошибку
Код ошибки: $1
Сообщение: $2
Нажмите [OK], чтобы попытаться повторить последнее действие',
	'wikisync_js_synchronization_confirmation' => 'Вы уверены в том что хотите синхронизировать последние изменения
с $1
на $2
начиная с ревизии $3?',
	'wikisync_js_synchronization_success' => 'Синхронизация успешно завершена',
	'wikisync_js_already_synchronized' => 'Исходный и назначенный вики-сайты выглядят уже синхронизированными',
	'wikisync_js_sync_to_itself' => 'Невозможно синхронизировать вики сайт сам в себя',
	'wikisync_js_diff_search' => 'Поиск отличий в ревизиях вики-сайта назначения',
	'wikisync_js_revision' => 'Ревизия $1',
	'wikisync_js_file_size_mismatch' => 'Размер временного файла "$1" ($2 {{PLURAL:$2|байт|байта|байтов}}) не соответствует требуемому размеру файла ($3 {{PLURAL:$3|байт|байта|байтов}}). Пожалуйста убедитесь, что файл "$4" не был переписан вручную в репозиторий исходного вики-сайта.',
	'wikisync_js_invalid_scheduler_time' => 'Время планировщика должно быть положительным целым числом',
	'wikisync_js_scheduler_countdown' => 'Осталось $1 {{PLURAL:$1|минута|минуты|минут}}',
	'wikisync_js_sync_start_ltr' => 'Запуск синхронизации с локального вики-сайта на удалённый $1',
	'wikisync_js_sync_start_rtl' => 'Запуск синхронизации с удалённого вики-сайта на локальный $1',
	'wikisync_js_sync_end_ltr' => 'Окончание синхронизации с локального вики-сайта на удалённый $1',
	'wikisync_js_sync_end_rtl' => 'Окончание синхронизации с удалённого вики-сайта на локальный $1',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'wikisync_remote_login_button' => 'ప్రవేశించండి',
	'wikisync_apply_button' => 'ఆపాదించు',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|నిమిషం|నిమిషాలు}} ఉంది',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'wikisync' => 'Pagsasabay ng Wiki',
	'wikisync-desc' => 'Nagbibigay ng isang [[Special:WikiSync|natatanging pahina]] upang maisabay ang kamakailang mga pagbabago ng dalawang mga wiki - isang katutubo at isang malayo',
	'wikisync_direction' => 'Mangyaring piliin ang kapupuntahan ng pagpapasabayan',
	'wikisync_local_root' => 'Katutubong ugat ng lugar ng wiki',
	'wikisync_remote_root' => 'Malayong ugat ng lugar ng wiki',
	'wikisync_remote_log' => 'Malayong talaan ng mga pagsasagawa',
	'wikisync_clear_log' => 'Hawiin ang talaan',
	'wikisync_login_to_remote_wiki' => 'Lumagdang papasok sa malayong wiki',
	'wikisync_remote_wiki_root' => 'Malayong ugat ng wiki',
	'wikisync_remote_wiki_example' => 'Landas papunta sa api.php, halimbawa na: http://www.mediawiki.org/w',
	'wikisync_remote_wiki_user' => 'Malayong pangalan ng tagagamit ng wiki',
	'wikisync_remote_wiki_pass' => 'Malayong hudyat ng wiki',
	'wikisync_remote_login_button' => 'Lumagdang papasok',
	'wikisync_sync_files' => 'Pagsabay-sabayin ang mga talaksan',
	'wikisync_store_password' => 'Iimbak ang malayong hudyat ng wiki',
	'wikisync_storing_password_warning' => 'Hindi ligtas ang pag-iimbak ng malayong hudyat at hindi iminumungkahi',
	'wikisync_synchronization_button' => 'Pagsabayin',
	'wikisync_scheduler_log' => 'Talaan ng tagapagtakda',
	'wikisync_scheduler_setup' => 'Pagkakahanda ng tagapagtakda',
	'wikisync_scheduler_turn_on' => 'Buhayin ang pangtakda',
	'wikisync_scheduler_switch_direction' => 'Kusang pagpalitin ang patutunguhan ng pagsasabayan',
	'wikisync_scheduler_time_interval' => 'Oras na nasa mga minuto sa pagitan ng kusang mga pagsasabayan',
	'wikisync_apply_button' => 'Ilapat',
	'wikisync_log_imported_by' => 'Inangkat ng [[Special:WikiSync|WikiSync]]',
	'wikisync_log_uploaded_by' => 'Ikinargang papaitaas ng [[Special:WikiSync|WikiSync]]',
	'wikisync_unsupported_user' => 'Tanging isang tagagamit na $1 lamang ng natatanging bot ang makapagsasagawa ng mga pagsasabay ng wiki. Mangyaring lumagda bilang $1. Huwag baguhin ang pangalang $1 na nasa pagitan ng mga pagsasabay, kung hindi ay hindi magiging tama ang paglaktaw sa pangkabatiran na mga rebisyong walang bisa (tingnan ang [http://www.mediawiki.org/wiki/Extension:WikiSync] para sa mas marami pang kabatiran).',
	'wikisync_api_result_unknown_action' => 'Hindi nalalamang galaw ng API',
	'wikisync_api_result_exception' => 'Naganap ang hindi pagsasali sa loob ng katutubong pagtawag ng API',
	'wikisync_api_result_noaccess' => 'Tanging mga kasapi lamang ng sumusunod na {{PLURAL:$2|pangkat|mga pangkat}} ang makapagsasagawa ng galaw na ito: $1',
	'wikisync_api_result_invalid_parameter' => 'Hindi katanggap-tanggap na halaga ng parametro',
	'wikisync_api_result_http' => 'Kamalian ng HTTP habang nagtatanong ng dato mula sa malayong API',
	'wikisync_api_result_Unsupported' => 'Hindi tinatangkilik ang bersyon mo ng MediaWiki (mas mababa kaysa 1.15)',
	'wikisync_api_result_NoName' => 'Hindi mo itinakda ang parametrong lgname',
	'wikisync_api_result_Illegal' => 'Nagbigay ka ng isang hindi makabatas na pangalan ng tagagamit',
	'wikisync_api_result_NotExists' => 'Hindi umiiral ang ibinigay mong pangalan ng tagagamit',
	'wikisync_api_result_EmptyPass' => 'Hindi mo itinakda ang parametrong lgpassword o iniwan mo itong walang laman',
	'wikisync_api_result_WrongPass' => 'Hindi tama ang ibinigay mong hudyat',
	'wikisync_api_result_WrongPluginPass' => 'Hindi tama ang ibinigay mong hudyat',
	'wikisync_api_result_CreateBlocked' => 'Ang wiki ay sumubok na kusang lumikha ng isang bagong akawnt para sa iyo, ngunit ang iyong tirahan ng IP ay hinadlangan mula sa paglikha ng akawnt',
	'wikisync_api_result_Throttled' => 'Masyadong marami ang naging paglagda mo sa loob ng maikling panahon.',
	'wikisync_api_result_Blocked' => 'Hinahadlangan ang tagagamit',
	'wikisync_api_result_mustbeposted' => 'Ang modyul ng paglagda ay nangangailangan ng hiling ng PASKIL',
	'wikisync_api_result_NeedToken' => 'Maaaring hindi ka nagbigay ng kahalip ng paglagda o ng otap ng ID ng laang panahon. Humiling ulit na ibinigay ang kahalip at otap sa loob ng tugong ito',
	'wikisync_api_result_no_import_rights' => 'Ang tagagamit na ito ay hindi pinapayagang umangkat ng mga talaksang tambakan ng XML',
	'wikisync_api_result_Success' => 'Matagumpay na nakalagdang papaloob sa malayong sityo ng wiki',
	'wikisync_js_last_op_error' => 'Ang huling pagsasagawa ay nagbalik ng isang kamalian.

Kodigo: $1

Mensahe: $2

Pindutin anag [Sige] upang muling subukan ang huling pagsasagawa',
	'wikisync_js_synchronization_confirmation' => 'Nakatitiyak ka bang nais mong pagsabayin

mula sa $1

papunta sa $2

nagsisimula mula sa rebisyong $3?',
	'wikisync_js_synchronization_success' => 'Matagumpay na nabuo ang pagsasabay',
	'wikisync_js_already_synchronized' => 'Tila sumasabay na ang mga wiki pinagkukunan at pinatutunguhan',
	'wikisync_js_sync_to_itself' => 'Hindi mo maisasabay ang sarili sa kanyang sarili',
	'wikisync_js_diff_search' => 'Naghahanap ng kaibahan sa mga rebisyon ng kapupuntahan',
	'wikisync_js_revision' => 'Rebisyong $1',
	'wikisync_js_invalid_scheduler_time' => 'Ang oras ng tagapagtakda ay dapat na isang positibong bilang na buumbilang',
	'wikisync_js_scheduler_countdown' => '$1 {{PLURAL:$1|minuto|mga minuto}} pa ang natitira',
	'wikisync_js_sync_start_ltr' => 'Sinisimulan ang pagsasabayan mula sa katutubong wiki papunta sa malayong wiki sa $1',
	'wikisync_js_sync_start_rtl' => 'Sinisimulan ang pagsasabayan mula sa malayong wiki papunta sa katutubong wiki sa $1',
	'wikisync_js_sync_end_ltr' => 'Natapos na ang pagsasabayan mula sa katutubong wiki papunta sa malayong wiki sa $1',
	'wikisync_js_sync_end_rtl' => 'Natapos na ang pagsasabayan mula sa malayong wiki papunta sa katutubong wiki sa $1',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'wikisync' => 'Синхронізація вікі',
	'wikisync-desc' => 'Впроваджує [[Special:WikiSync|спеціальну сторінку]] для синхронізації останніх зміни двох вікі - локальної і віддаленої',
	'wikisync_direction' => 'Будь ласка, оберіть напрямок синхронізації',
	'wikisync_clear_log' => 'Очистити журнал',
	'wikisync_remote_login_button' => 'Увійти',
	'wikisync_sync_files' => 'Синхронізувати файли',
	'wikisync_synchronization_button' => 'Синхронізувати',
	'wikisync_api_result_invalid_parameter' => 'Неприпустиме значення параметра',
	'wikisync_api_result_WrongPass' => 'Пароль, що ви вказали — невірний',
	'wikisync_js_synchronization_success' => 'Синхронізацію успішно завершено',
	'wikisync_js_sync_to_itself' => 'Ви не можете синхронізувати вікі саму до себе',
	'wikisync_js_revision' => 'Версія $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'wikisync_remote_login_button' => '登入',
	'wikisync_js_revision' => '版本$1',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'wikisync_remote_login_button' => '登入',
	'wikisync_js_revision' => '版本$1',
);

