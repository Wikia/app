<?php
/**
 * Internationalisation file for extension Wiki At Home.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Michael Dale
 * @author Purodha 	http://ksh.wikipedia.org/wiki/User:Purodha
 */
$messages['en'] = array(
	'specialwikiathome' => 'Wiki@Home',
	'wah-desc' => 'Enables distributing transcoding video jobs to clients using Firefogg',
	'wah-user-desc' => 'Wiki@Home enables community members to donate spare cpu cycles to help with resource intensive operations',
	'wah-short-audio' => '$1 sound file, $2',
	'wah-short-video' => '$1 video file, $2',
	'wah-short-general' => '$1 media file, $2',

	'wah-long-audio' => '$1 sound file, length $2, $3',
	'wah-long-video' => '$1 video file, length $2, $4×$5 pixels, $3',
	'wah-long-multiplexed' => 'multiplexed audio/video file, $1, length $2, $4×$5 pixels, $3 overall',
	'wah-long-general' => 'media file, length $2, $3',
	'wah-long-error' => 'ffmpeg could not read this file: $1',

	'wah-transcode-working' => 'This video is being processed, please try again later',
	'wah-transcode-helpout' => 'You can help transcode this video by visiting [[Special:WikiAtHome|Wiki@Home]].',

	'wah-transcode-fail' => 'This file failed to transcode.',

	'wah-javascript-off' => 'You must have JavaScript enabled to participate in Wiki@Home',
	'wah-loading' => 'loading Wiki@Home interface ...',

	/* javascript msgs WikiAtHome.js */
	"wah-menu-jobs"	=> "Jobs",
	"wah-menu-stats" => "Stats",
	"wah-menu-pref"	=> "Preferences",
	"wah-loading"	=> "loading Wiki@Home interface ...",

	"wah-lookingforjob"	=> "Looking for a job ...",

	"wah-start-on-visit" => "Start up Wiki@Home any time I visit this site.",
	"wah-jobs-while-away"=> "Only run jobs when I have been away from my browser for 20 minutes.",

	"wah-nojobfound" 	=> "No job found. Will retry in $1.",

	"wah-notoken-login" => "Are you logged in? If not, please log in first.",
	"wah-apioff"		=> "The Wiki@Home API appears to be off. Please contact the wiki administrator.",

	"wah-doing-job"		=> "Job: <i>$1</i> on: <i>$2</i>",
	"wah-downloading"	=> "Downloading file <i>$1%</i> complete",
	"wah-encoding"		=> "Encoding file <i>$1%</i> complete",

	"wah-encoding-fail"	=> "Encoding failed. Please reload this page or try back later.",

	"wah-uploading"		=> "Uploading file <i>$1</i> complete",
	"wah-uploadfail"	=> "Uploading failed",
	"wah-doneuploading" => "Upload complete. Thank you for your contribution.",

	"wah-needs-firefogg"=> "To participate in Wiki@Home you need to install <a href=\"http://firefogg.org\">Firefogg</a>.",
	"wah-api-error"		=> "There has been an error with the API. Please try back later."
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 */
$messages['qqq'] = array(
	'wah-desc' => '{{desc}}',
	'wah-short-audio' => '* $1 is codec name(s)
* $2 is file length (time)',
	'wah-short-video' => '* $1 is codec name(s)
* $2 is file length (time)',
	'wah-short-general' => '* $1 is codec name(s)
* $2 is file length (time)',
	'wah-long-audio' => '* $1 is codec names
* $2 is file length time
* $3 is bitrate',
	'wah-long-video' => '* $1 is codec names
* $2 is file length time
* $3 is bitrate
* $4 is width
* $5 is height',
	'wah-long-multiplexed' => '* $1 is codec names
* $2 is file length time
* $3 is bitrate
* $4 is width
* $5 is height',
	'wah-long-general' => '* $2 is file length time
* $3 is bitrate',
	'wah-long-error' => '* $1 is error message',
	'wah-menu-pref' => '{{Identical|Preferences}}',
	'wah-doing-job' => 'Parameters:
* $1 is the job type
* $2 is the job name',
	'wah-uploading' => 'Parameters:
* $1 is the file name of the file that is being uploaded',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wah-desc' => "Maak dit moontlik om die transkodering van video's na kliënte te versprei via firefogg",
	'wah-user-desc' => 'Wiki@Home maak dit vir gemeenskapslede moontlik om rekenaartyd te skenk om sodoende te help met die uitvoer van moeilike take',
	'wah-short-audio' => '$1-klanklêer, $2',
	'wah-short-video' => '$1-videolêer, $2',
	'wah-short-general' => '$1-medialêer, $2',
	'wah-long-audio' => '$1-klanklêer, lengte $2, $3',
	'wah-long-video' => '$1-videolêer, lengte $2, $4×$5 pixsels, $3',
	'wah-long-multiplexed' => 'gemultiplekseerde klank/videolêer, $1, lengte $2, $4×$5 pixels, $3 totaal',
	'wah-long-general' => 'medialêer, lengte $2, $3',
	'wah-long-error' => 'ffmpeg kon die lêer nie lees nie: $1',
	'wah-transcode-working' => 'Hierdie video word tans verwerk.
Probeer later weer.',
	'wah-transcode-helpout' => 'U kan help om die lêer te transkodeer deur na [[Special:WikiAtHome|Wiki@Home]] te gaan',
	'wah-transcode-fail' => 'Die transkodering van die lêer het misluk.',
	'wah-javascript-off' => 'JavaScript moet geaktiveer wees om aan Wiki@Home deel te neem',
	'wah-loading' => 'Die Wiki@Home-koppelvlak is besig om te laai ...',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'wah-desc' => 'Mundëson shpërndarjen transcoding Punë në video për klientët duke përdorur Firefogg',
	'wah-user-desc' => 'Wiki @ Home mundëson anëtarëve të komunitetit për të dhuruar ciklet e CPU rezervë për të ndihmuar me operacionet intensiv të burimeve',
	'wah-short-audio' => 'file $1 shëndoshë, $2',
	'wah-short-video' => '$1 video file, $2',
	'wah-short-general' => '$1 media file, $2',
	'wah-long-audio' => 'Gjatësi file $1 shëndoshë, $2, $3',
	'wah-long-video' => 'Gjatësi video file $1, $2, $4 × $5 pixels, $3',
	'wah-long-multiplexed' => 'Multiplexed audio / video file, $1, gjatë $2, $4 × $5 pixels, $3 e përgjithshme',
	'wah-long-general' => 'Media file, gjatë $2, $3',
	'wah-long-error' => 'Ffmpeg mund të mos lexoni këtë file: $1',
	'wah-transcode-working' => 'Kjo video është duke u procesuar, ju lutem provoni përsëri më vonë',
	'wah-transcode-helpout' => 'Ju mund të ndihmoni transcode këtë video duke vizituar [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Ky skedar nuk transcode.',
	'wah-javascript-off' => 'Ju duhet të aktivizoni Java skriptet për të marrë pjesë në Wiki @ Home',
	'wah-loading' => 'loading Wiki interface @ Ballina ...',
	'wah-menu-jobs' => 'Jobs',
	'wah-menu-stats' => 'Stats',
	'wah-menu-pref' => 'Preferenca',
	'wah-lookingforjob' => 'Duke kërkuar për një punë ...',
	'wah-start-on-visit' => 'Fillimi Wiki @ Ballina çdo kohë që unë të vizitoni këtë faqe.',
	'wah-jobs-while-away' => 'Vetëm drejtuar Punë kur unë kam qenë larg nga shfletuesin tim për 20 minuta.',
	'wah-nojobfound' => 'Nuk ka gjetur punë. Do të rigjykuar në $1.',
	'wah-notoken-login' => 'A jeni regjistruar? Nëse jo, ju lutem hyni në të parë.',
	'wah-apioff' => '@ Wiki Home API duket të jetë jashtë. Ju lutem kontaktoni administratorin wiki.',
	'wah-doing-job' => 'Punë: <i>$1</i> më: <i>$2</i>',
	'wah-downloading' => 'Shkarkim file <i>$1%</i> të plotë',
	'wah-encoding' => 'Encoding file <i>$1%</i> të plotë',
	'wah-encoding-fail' => 'Encoding dështuar. Ju lutemi Rifresko këtë faqe ose provo përsëri më vonë.',
	'wah-uploading' => 'Ngarkimi i file <i>$1</i> plotë',
	'wah-uploadfail' => 'Ngarkimi dështuar',
	'wah-doneuploading' => 'Ngarko plotë. Faleminderit për kontributin tuaj.',
	'wah-needs-firefogg' => 'Për të marrë pjesë në Wiki @ Ballina ju duhet ta instaloni <a href="http://firefogg.org">Firefogg</a> .',
	'wah-api-error' => 'Ka qenë një gabim me API. Ju lutemi provoni sërish më vonë.',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'wah-menu-pref' => 'Preferencias',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'wah-desc' => 'يساعد في توزيع مهمات تحويل الفيديو على العملاء باستخدام Fireogg.',
	'wah-user-desc' => 'يمكن أعضاء المجتمع من التبرع بدوائر المعالج الشاغرة للمساعدة في العمليات المستهلكة للموارد',
	'wah-short-audio' => 'ملف صوتي $1، $2',
	'wah-short-video' => 'ملف فيديو $1، $2',
	'wah-short-general' => 'ملف وسائط $1، $2',
	'wah-long-audio' => 'ملف صوتي، طوله $2، $3 $1',
	'wah-long-video' => 'ملف فيديو، طوله $2، $4×$5 بكسل، $3 $1',
	'wah-long-multiplexed' => 'ملف صوت/فيديو, $1, الطول $2, $4×$5 بكسل، $3 إجمالا',
	'wah-long-general' => 'ملف وسائط طوله $2، $3',
	'wah-long-error' => 'لم يتمكن ffmpeg من قراءة هذا الملف: $1',
	'wah-transcode-working' => 'تتم الآن معالجة الفيديو، من فضلك حاول لاحقًا مرة أخرى',
	'wah-transcode-helpout' => 'تستطيع المساعدة في تحويل هذا الفيديو بزيارة [[Special:WikiAtHome|ويكي@المنزل]].',
	'wah-transcode-fail' => 'فشل تحويل الملف.',
	'wah-javascript-off' => 'يجب أن تمكن جافاسكربت لتنضم ويكي@المنزل',
	'wah-loading' => 'يحمّل واجهة ويكي@المنزل...',
	'wah-menu-jobs' => 'مهام',
	'wah-menu-stats' => 'إحصاءات',
	'wah-menu-pref' => 'تفضيلات',
	'wah-lookingforjob' => 'يبحث عن مهمة...',
	'wah-start-on-visit' => 'ابدأ ويكي@المنزل كل مرة أزور فيها هذا الموقع.',
	'wah-jobs-while-away' => 'شغّل المهمات فقط عندما أبتعد عن متصفحي ل20 دقيقة.',
	'wah-nojobfound' => 'لم أجد أية مهمة. سوف أحاول مرة أخرى خلال $1.',
	'wah-notoken-login' => 'أأنت والج؟ إن لم تكن كذلك، فلُج أولا من فضلك.',
	'wah-apioff' => 'يبدو أن واجهة ويكي@المنزل البرمجية مُطفأة. من فضلك اتصل بمدير الويكي.',
	'wah-doing-job' => 'المهمة: <i>$1</i> على: <i>$2</i>',
	'wah-downloading' => 'اكتمل تنزيل الملف <i>$1%</i>',
	'wah-encoding' => 'اكتمل ترميز الملف <i>$1%</i>',
	'wah-encoding-fail' => 'فشل الترميز. من فضلك أعد تحميل هذه الصفحة أو حاول مرة أخرى لاحقًا.',
	'wah-uploading' => 'اكتمل رفع الملف <i>$1%</i>',
	'wah-uploadfail' => 'فشل الرفع',
	'wah-doneuploading' => 'اكتمل الرفع. شكرا لمساهمتك.',
	'wah-needs-firefogg' => 'يتعين عليك تثبيت <a href="http://firefogg.org">Firefogg</a> للانضمام إلى ويكي@المنزل.',
	'wah-api-error' => 'وُجد خطأ في الواجهة البرمجية. من فضلك حاول مرة أخرى لاحقًا.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'wah-desc' => 'يساعد فى توزيع مهمات تحويل الفيديو على العملاء باستخدام Fireogg.',
	'wah-user-desc' => 'يمكن أعضاء المجتمع من التبرع بدوائر المعالج الشاغره للمساعده فى العمليات المستهلكه للموارد',
	'wah-short-audio' => 'ملف صوتى $1، $2',
	'wah-short-video' => 'ملف فيديو $1، $2',
	'wah-short-general' => 'ملف وسائط $1، $2',
	'wah-long-audio' => 'ملف صوتى، طوله $2، $3 $1',
	'wah-long-video' => 'ملف فيديو، طوله $2، $4×$5 بكسل، $3 $1',
	'wah-long-multiplexed' => 'ملف صوت/فيديو, $1, الطول $2, $4×$5 بكسل، $3 إجمالا',
	'wah-long-general' => 'ملف وسائط طوله $2، $3',
	'wah-long-error' => 'لم يتمكن ffmpeg من قراءه هذا الملف: $1',
	'wah-transcode-working' => 'تتم الآن معالجه الفيديو، من فضلك حاول لاحقًا مره أخرى',
	'wah-transcode-helpout' => 'تستطيع المساعده فى تحويل هذا الفيديو بزياره [[Special:WikiAtHome|ويكي@المنزل]].',
	'wah-transcode-fail' => 'فشل تحويل الملف.',
	'wah-javascript-off' => 'يجب أن تمكن جافاسكربت لتنضم ويكي@المنزل',
	'wah-loading' => 'يحمّل واجهه ويكي@المنزل...',
	'wah-menu-jobs' => 'مهام',
	'wah-menu-stats' => 'إحصاءات',
	'wah-menu-pref' => 'تفضيلات',
	'wah-lookingforjob' => 'يبحث عن مهمه...',
	'wah-start-on-visit' => 'ابدأ ويكي@المنزل كل مره أزور فيها هذا الموقع.',
	'wah-jobs-while-away' => 'شغّل المهمات فقط عندما أبتعد عن متصفحى ل20 دقيقه.',
	'wah-nojobfound' => 'لم أجد أيه مهمه. سوف أحاول مره أخرى خلال $1.',
	'wah-notoken-login' => 'أأنت والج؟ إن لم تكن كذلك، فلُج أولا من فضلك.',
	'wah-apioff' => 'يبدو أن واجهه ويكي@المنزل البرمجيه مُطفأه. من فضلك اتصل بمدير الويكى.',
	'wah-doing-job' => 'المهمة: <i>$1</i> على: <i>$2</i>',
	'wah-downloading' => 'اكتمل تنزيل الملف <i>$1%</i>',
	'wah-encoding' => 'اكتمل ترميز الملف <i>$1%</i>',
	'wah-encoding-fail' => 'فشل الترميز. من فضلك أعد تحميل هذه الصفحه أو حاول مره أخرى لاحقًا.',
	'wah-uploading' => 'اكتمل رفع الملف <i>$1%</i>',
	'wah-uploadfail' => 'فشل الرفع',
	'wah-doneuploading' => 'اكتمل الرفع. شكرا لمساهمتك.',
	'wah-needs-firefogg' => 'يتعين عليك تثبيت <a href="http://firefogg.org">Firefogg</a> للانضمام إلى ويكي@المنزل.',
	'wah-api-error' => 'وُجد خطأ فى الواجهه البرمجيه. من فضلك حاول مره أخرى لاحقًا.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'wah-desc' => 'Дазваляе разьмяркаванньне працы перакадыроўкі відэа да кліентаў праз выкарыстаньне firefogg.',
	'wah-user-desc' => 'Wiki@Home дазваляе ўдзельнікам супольнасьці ахвяраваць не выкарыстоўваемую магутнасьць працэсараў на дапамогу з рэсурсаёмістымі апэрацыямі',
	'wah-short-audio' => 'Аўдыё-файл у фармаце $1, $2',
	'wah-short-video' => 'Відэа-файл у фармаце $1, $2',
	'wah-short-general' => 'Мэдыя-файл у фармаце $1, $2',
	'wah-long-audio' => 'Аўдыё-файл у фармаце $1, працягласьць $2, $3',
	'wah-long-video' => 'Відэа-файл у фармаце $1, працягласьць $2, $4×$5 піксэляў, $3',
	'wah-long-multiplexed' => 'мультыплексны аўдыё/відэа-файл у фармаце $1, працягласьць $2, $4×$5 піксэлаў, усяго $3',
	'wah-long-general' => 'Мэдыяфайл, працягласьць $2, $3',
	'wah-long-error' => 'ffmpeg ня можа прачытаць гэты файл: $1',
	'wah-transcode-working' => 'Гэты відэа-файл зараз апрацоoўваецца. Калі ласка, паспрабуйце ізноў пазьней',
	'wah-transcode-helpout' => 'Вы можаце дапамагчы перакадаваць гэты відэа-файл наведаўшы [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Немагчыма перакадаваць гэты файл.',
	'wah-javascript-off' => 'У Вас павінен быць уключаны JavaScript для ўдзелу ў Wiki@Home',
	'wah-loading' => 'загрузка інтэрфэйсу Wiki@Home ...',
	'wah-menu-jobs' => 'Заданьні',
	'wah-menu-stats' => 'Статыстыка',
	'wah-menu-pref' => 'Налады',
	'wah-lookingforjob' => 'Пошук заданьняў ...',
	'wah-start-on-visit' => 'Запускаць Wiki@Home у любы час, калі я наведваю гэты сайт.',
	'wah-jobs-while-away' => 'Запускаць заданьні толькі пасьля таго, як я не карыстаюся браўзэрам болей 20 хвілінаў.',
	'wah-nojobfound' => 'Заданьні ня знойдзеныя. Паўтор спробы ў $1.',
	'wah-notoken-login' => 'Вы ўвайшлі ў сыстэму? Калі не, калі ласка, спачатку ўвайдзіце ў сыстэму.',
	'wah-apioff' => 'Выглядае, што Wiki@Home API выключаны. Калі ласка, зьвяжыцеся з адміністратарам вікі.',
	'wah-doing-job' => 'Заданьне: <i>$1</i> на: <i>$2</i>',
	'wah-downloading' => 'Загрузка файла <i>$1%</i> скончаная',
	'wah-encoding' => 'Кадаваньне файла <i>$1%</i> скончанае',
	'wah-encoding-fail' => 'Кадаваньне не атрымалася. Калі ласка, перагрузіце гэтую старонку альбо паспрабуйце вярнуцца пазьней.',
	'wah-uploading' => 'Загрузка файла <i>$1</i> скончаная',
	'wah-uploadfail' => 'Загрузка не атрымалася',
	'wah-doneuploading' => 'Загрузка скончаная. Дзякуй за Ваш унёсак.',
	'wah-needs-firefogg' => 'Для ўдзелу ў Wiki@Home Вам неабходна ўсталяваць <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Адбылася памылка ў API. Калі ласка, паспрабуйце вярнуцца пазьней.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'wah-short-audio' => '$1 звуков файл, $2',
	'wah-short-video' => '$1 видео файл, $2',
	'wah-transcode-working' => 'Видеото се обработва. Моля, опитайте пак по-късно.',
	'wah-javascript-off' => 'За да участвате в Wiki@Home е необходимо браузърът ви да е с включена поддръжка на Джаваскрипт.',
	'wah-loading' => 'зареждане на интерфейса на Wiki@Home ...',
	'wah-menu-pref' => 'Предпочитания',
	'wah-notoken-login' => 'Влязохте ли в системата? Ако не, моля, първо влезте с потребителското си име.',
	'wah-downloading' => 'Свалянето на файла <i>$1%</i> завърши',
	'wah-encoding' => 'Кодирането на файла <i>$1%</i> завърши',
	'wah-encoding-fail' => 'Възникна грешка при кодирането на файла. Моля, опреснете страницата или опитайте пак по-късно.',
	'wah-uploading' => 'Качването на файла <i>$1</i> завърши',
	'wah-uploadfail' => 'Възникна грешка при качването',
	'wah-doneuploading' => 'Качването на файла завърши. Благодарим ви за приноса.',
	'wah-needs-firefogg' => 'За да участвате в Wiki@Home, необходимо е да инсталирате <a href="http://firefogg.org">Firefogg.</a>',
	'wah-api-error' => 'Възникна грешка в приложно-програмния интерфейс. Моля, опитайте пак по-късно.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'wah-menu-jobs' => 'চাকুরী',
	'wah-menu-pref' => 'আমার পছন্দ',
	'wah-lookingforjob' => 'চাকুরী অনুসন্ধান...',
	'wah-downloading' => 'ফাইল ডাউনলোড <i>$1%</i> সম্পন্ন',
	'wah-encoding' => 'ফাইল এনকোড <i>$1%</i> সম্পন্ন',
	'wah-uploading' => 'ফাইল আপলোড <i>$1%</i> সম্পন্ন',
	'wah-uploadfail' => 'আপলোড ব্যর্থ',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'wah-desc' => "Talvezout a ra da zasparzh al labour treuzkodañ videoioù d'ar c'hliantoù dre firefogg",
	'wah-user-desc' => "Talvezout a ra Wiki@Home da izili ar gumuniezh da reiñ kelc'hioù prosesor diac'hub evit harpañ oberadurioù pounner da gas da benn",
	'wah-short-audio' => 'restr son $1, $2',
	'wah-short-video' => 'restr video $1, $2',
	'wah-short-general' => 'restr media $1, $2',
	'wah-long-audio' => 'restr son $1, pad $2, $3',
	'wah-long-video' => 'restr video $1, pad $2, $4×$5 piksel, $3',
	'wah-long-multiplexed' => 'restr klevet/video liesplezhet $1, pad $2, $4×$5 piksel, $3 hollad',
	'wah-long-general' => 'restr media, pad $2, $3',
	'wah-long-error' => "n'eo ket bet ffmpeg evit lenn ar restr-mañ : $1",
	'wah-transcode-working' => "Emeur o treuzkodañ ar video, klaskit en-dro diwezhatoc'hik",
	'wah-transcode-helpout' => "Skoazellañ da dreuzkodañ ar video-mañ a c'hallit ober en ur vont war [[Special:WikiAtHome|Wiki@Home]]",
	'wah-transcode-fail' => "C'hwitet eo treuzkodañ ar restr.",
	'wah-javascript-off' => 'Rekis eo bezañ gweredekaet JavaScript evit kemer perzh e Wiki@Home',
	'wah-loading' => 'o kargañ etrefas Wiki@Home ...',
	'wah-menu-jobs' => 'Trevelloù',
	'wah-menu-stats' => 'Stadegoù',
	'wah-menu-pref' => 'Penndibaboù',
	'wah-lookingforjob' => 'O klask un tamm labour ...',
	'wah-start-on-visit' => "Lañsañ Wiki@Home bep tro ma weladennan al lec'hienn-mañ.",
	'wah-jobs-while-away' => "Na lañsañ un trevell bennak nemet ma n'on ket bet ouzh ma merdeer e-pad 20 munutenn.",
	'wah-nojobfound' => "N'eus bet kavet trevell ebet. Adklasket e vo a-benn $1.",
	'wah-notoken-login' => "Ha kevreet oc'h ? Ma n'oc'h ket, kevreit da gentañ, mar plij.",
	'wah-apioff' => "Evit doare ne'z a ket en-dro API Wiki@Home. Kit e darempred gant merour ar wiki.",
	'wah-doing-job' => 'Labour: <i>$1</i> war : <i>$2</i>',
	'wah-downloading' => 'Echu eo pellgargañ ar restr <i>$1%</i>',
	'wah-encoding' => 'Echu eo kodañ ar restr <i>$1%</i>',
	'wah-encoding-fail' => "C'hwitet eo bet an enkodañ. Adkargit ar bajenn-mañ pe klaskit en-dro diwezhatoc'h.",
	'wah-uploading' => 'Echu eo kargañ ar restr <i>$1</i>',
	'wah-uploadfail' => "C'hwitet eo ar gargadenn",
	'wah-doneuploading' => 'Echuet eo pellgargañ. Trugarez da gemer perzh.',
	'wah-needs-firefogg' => 'Evit kemer perzh e Wiki@Home e rankit staliañ <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => "Ur gudenn zo bet gant an API. Klaskit en-dro diwezhatoc'hik.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'wah-desc' => 'Omogućava distribuciju transkodiranih video poslova klijentima putem Firefogga',
	'wah-user-desc' => 'Wiki@Home omogućava članovima zajednice da doniraju neiskorištene cpu cikluse za pomoć pri operacijama koje zahtjevaju dosta resursa',
	'wah-short-audio' => '$1 zvučna datoteka, $2',
	'wah-short-video' => '$1 video datoteka, $2',
	'wah-short-general' => '$1 medijalna datoteka, $2',
	'wah-long-audio' => '$1 zvučna datoteka, dužina $2, $3',
	'wah-long-video' => '$1 video datoteka, dužina $2, $4×$5 piksela, $3',
	'wah-long-multiplexed' => 'multipleksirana audio/video datoteka, $1, dužina $2, $4×$5 piksela, $3 sveukupno',
	'wah-long-general' => 'medijalna datoteka, dužina $2, $3',
	'wah-long-error' => 'ffmpeg nije mogao pročitati ovu datoteku: $1',
	'wah-transcode-working' => 'Ovaj video se obrađuje, molimo pokušajte kasnije',
	'wah-transcode-helpout' => 'Možete pomoći pri transkodiranju ovog videa ako posjetite [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Ova datoteka se nije uspjela transkodirati.',
	'wah-javascript-off' => 'Morate imati omogućenu JavaScript za učestvovanje u Wiki@Home',
	'wah-loading' => 'učitavam interfejs Wiki@Home ...',
	'wah-menu-jobs' => 'Poslovi',
	'wah-menu-stats' => 'Statistike',
	'wah-menu-pref' => 'Postavke',
	'wah-lookingforjob' => 'Tražim posao ...',
	'wah-start-on-visit' => 'Započni Wiki@Home svaki put kada posjetim ovu stranicu.',
	'wah-jobs-while-away' => 'Pokreni poslove samo kada sam odsutan van svog preglednika više od 20 minuta.',
	'wah-nojobfound' => 'Nije pronađen posao. Pokušaću opet za $1.',
	'wah-notoken-login' => 'Jeste li prijavljeni? Ako niste, prvo se prijavite.',
	'wah-apioff' => 'Izgleda da je Wiki@Home API ugašen. Molimo kontaktirajte administratora wikija.',
	'wah-doing-job' => 'Posao: <i>$1</i> na: <i>$2</i>',
	'wah-downloading' => 'Preuzimanje datoteke <i>$1</i> završeno',
	'wah-encoding' => 'Kodiranje datoteke <i>$1</i> završeno',
	'wah-encoding-fail' => 'Kodiranje nije uspjelo. Molimo ponovo učitajte ovu stranicu ili pokušajte kasnije.',
	'wah-uploading' => 'Postavljanje datoteke <i>$1</i> završeno',
	'wah-uploadfail' => 'Postavljanje nije uspjelo',
	'wah-doneuploading' => 'Postavljanje završeno. Hvala vam na vašim doprinosima.',
	'wah-needs-firefogg' => 'Da biste učestvovali na Wiki@Home trebate instalirati <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Nastala je greška sa API. Molimo pokušajte kasnije.',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'wah-menu-jobs' => 'Feines',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'wah-desc' => 'Umožňuje distribuci úloh překódování videa klientům pomocí Firefogg',
	'wah-user-desc' => 'Wiki@Home umožňuje členům komunity věnovat nevyužitý čas procesoru na pomoc při operacích náročných na zdroje',
	'wah-short-audio' => '$1 zvukový soubor, $2',
	'wah-short-video' => '$1 videosoubor, $2',
	'wah-short-general' => '$1 multimediální soubor, $2',
	'wah-long-audio' => '$1 zvukový soubor, délka: $2, $3',
	'wah-long-video' => '$1 videosoubor, délka: $2, $4×$5 pixelů, $3',
	'wah-long-multiplexed' => 'multiplexovaný audio/videsoubor, $1, délka: $2, $4×$5 pixels, celkem $3',
	'wah-long-general' => 'multimediální soubor, délka: $2, $3',
	'wah-long-error' => 'ffmpeg nedokázal načíst následující soubor: $1',
	'wah-transcode-working' => 'Toto video se zpracovává, zkuste to prosím později',
	'wah-transcode-helpout' => 'Můžete pomoci s překódováním tohoto videa navštívením [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Tento soubor se nepodařilo překódovat.',
	'wah-javascript-off' => 'Abyste se mohli zúčastnit Wiki@Home, musíte mít zapnutý JavaScript',
	'wah-loading' => 'načítám rozhraní Wiki@Home …',
	'wah-menu-jobs' => 'Úlohy',
	'wah-menu-stats' => 'Statistiky',
	'wah-menu-pref' => 'Nastavení',
	'wah-lookingforjob' => 'Hledá se úloha…',
	'wah-start-on-visit' => 'Spustit Wiki@Home vždy, když navštívím tuto stránku.',
	'wah-jobs-while-away' => 'Spouštět úlohy pouze, pokud jsem prohlížeč nepoužíval více než 20 minut.',
	'wah-nojobfound' => 'Nebyla nalezena žádná úloha. Opětovný pokus za $1.',
	'wah-notoken-login' => 'Jste přihlášeni? Pokud ne, přihlaste se, prosím.',
	'wah-apioff' => 'Zdá se, že API Wiki@Home je vypnuto. Zkontaktuje prosím správce wiki.',
	'wah-doing-job' => 'Úloha: <i>$1</i>: <i>$2</i>',
	'wah-downloading' => 'Stahování souboru <i>$1%</i> dokončeno',
	'wah-encoding' => 'Kódování souboru <i>$1%</i> dokončeno',
	'wah-encoding-fail' => 'Kódování selhalo. Znovu načtěte tuto stránku nebo to zkuste pozěji.',
	'wah-uploading' => 'Nahrávání souboru <i>$1</i> dokončeno',
	'wah-uploadfail' => 'Nahrávání selhalo',
	'wah-doneuploading' => 'Nahrávání dokončeno. Děkujeme vám za příspěvek.',
	'wah-needs-firefogg' => 'Abyste se mohli zúčastnit Wiki@Home, musíte mít nainstalovaný <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Objevila se chyba týkající se API. Zkuste to prosím později.',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Imre
 * @author Pill
 * @author Sebastian Wallroth
 * @author Umherirrender
 */
$messages['de'] = array(
	'wah-desc' => 'Ermöglicht das Verteilen von Video-Transkodier-Jobs an Clients mit firefogg',
	'wah-user-desc' => 'Wiki@Home ermöglicht Community-Mitgliedern freie CPU-Zeiten zu spenden, um bei ressourcenintensiven Operationen zu helfen',
	'wah-short-audio' => '$1-Audiodatei, $2',
	'wah-short-video' => '$1-Videodatei, $2',
	'wah-short-general' => '$1-Mediadatei, $2',
	'wah-long-audio' => '$1-Audiodatei, Länge: $2, $3',
	'wah-long-video' => '$1-Videodatei, Länge: $2, $4×$5 Pixel, $3',
	'wah-long-multiplexed' => 'Multiplex-Audio-/Video-Datei, $1, Länge: $2, $4×$5 Pixel, $3',
	'wah-long-general' => 'Mediadatei, Länge: $2, $3',
	'wah-long-error' => 'ffmpeg konnte diese Datei nicht lesen: $1',
	'wah-transcode-working' => 'Das Video wird verarbeitet, bitte versuche es später wieder',
	'wah-transcode-helpout' => 'Du kannst dabei helfen dieses Video zu verarbeiten, indem du [[Special:WikiAtHome|Wiki@Home]] besuchst',
	'wah-transcode-fail' => 'Diese Datei konnte nicht transkodiert werden.',
	'wah-javascript-off' => 'Du musst JavaScript aktiviert haben, um bei Wiki@Home teilnehmen zu können',
	'wah-loading' => 'Lade Wiki@Home-Benutzeroberfläche …',
	'wah-menu-jobs' => 'Aufgaben',
	'wah-menu-stats' => 'Statistiken',
	'wah-menu-pref' => 'Einstellungen',
	'wah-lookingforjob' => 'Aufgabensuche...',
	'wah-start-on-visit' => 'Wiki@Home bei jedem Besuch dieser Seite aufrufen.',
	'wah-jobs-while-away' => 'Aufgaben nur ausführen, wenn ich mindestens 20 Minuten keine Browseraktivität hatte',
	'wah-nojobfound' => 'Keine Aufgabe gefunden. Versuche die Prozedur erneut in $1.',
	'wah-notoken-login' => 'Hast du dich bereits angemeldet? Falls nicht, hole dies bitte zuerst nach.',
	'wah-apioff' => 'Die Wiki@Home-API scheint abgeschaltet zu sein. Bitte kontaktiere den Administrator des Wikis.',
	'wah-doing-job' => 'Aufgabe: <i>$1</i> auf: <i>$2</i>',
	'wah-downloading' => 'Herunterladen der Datei zu <i>$1 %</i> abgeschlossen.',
	'wah-encoding' => 'Dateiverschlüsselung zu <i>$1%</i> fertiggestellt',
	'wah-encoding-fail' => 'Verschlüsselung fehlgeschlagen. Bitte lade diese Seite erneut oder versuche es später noch einmal.',
	'wah-uploading' => '<i>$1</i> wurde erfolgreich hochgeladen.',
	'wah-uploadfail' => 'Hochladen nicht erfolgreich',
	'wah-doneuploading' => 'Hochladen erfolgreich. Vielen Dank für deinen Beitrag.',
	'wah-needs-firefogg' => 'Um an Wiki@Home teilzunehmen, müssen Sie <a href="http://firefogg.org">Firefogg</a> installieren.',
	'wah-api-error' => 'Es ist ein Fehler mit dem API aufgetreten. Bitte versuche es später noch einmal.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 * @author Imre
 */
$messages['de-formal'] = array(
	'wah-transcode-working' => 'Das Video wird verarbeitet, bitte versuchen Sie es später wieder',
	'wah-transcode-helpout' => 'Sie können dabei helfen dieses Video zu verarbeiten, indem Sie [[Special:WikiAtHome|Wiki@Home]] besuchen',
	'wah-javascript-off' => 'Sie müssen JavaScript aktiviert haben, um bei Wiki@Home teilnehmen zu können',
	'wah-notoken-login' => 'Sind Sie bereits angemeldet? Falls nicht, holen Sie dies bitte zuerst nach.',
	'wah-apioff' => 'Die Wiki@Home-API scheint abgeschaltet zu sein. Bitte kontaktieren Sie den Administrator des Wikis.',
	'wah-encoding-fail' => 'Verschlüsselung fehlgeschlagen. Bitte laden Sie diese Seite erneut oder versuchen Sie es später noch einmal.',
	'wah-doneuploading' => 'Hochladen erfolgreich. Vielen Dank für Ihren Beitrag.',
	'wah-needs-firefogg' => 'Um an Wiki@Home teilzunehmen müssen Sie <a href="http://firefogg.org">Firefogg</a> installieren.',
	'wah-api-error' => 'Es ist ein Fehler mit dem API aufgetreten. Bitte versuchen Sie es später noch einmal.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'wah-desc' => 'Zmóžnja rozdźělenje nadawkow wideopśekoděrowanja klientam z pomocu Firefogg',
	'wah-user-desc' => 'Wiki@Home zmóžnja cłonkam zgromaźenstwa liche CPU-cykluse dariś, aby pomagał pśi operacijach, kótarež pśetrjebuju wjele resursow',
	'wah-short-audio' => 'Awdiodataja $1, $2',
	'wah-short-video' => 'Wideodataja $1, $2',
	'wah-short-general' => 'Medijowa dataja $1, $2',
	'wah-long-audio' => 'Awdiodataja $1, dłujkosć $2, $3',
	'wah-long-video' => 'Wideodataja $1, dłujkosć $2, $4×$5 pikselow, $3',
	'wah-long-multiplexed' => 'multipleksna awdio/wideodataja, $1, dłujkosć $2, $4×$5 pikselow, $3 dogromady',
	'wah-long-general' => 'medijowa dataja, dłujkosć $2, $3',
	'wah-long-error' => 'ffmpeg njejo mógł toś tu dataju cytaś: $1',
	'wah-transcode-working' => 'Wideo se pśeźěłujo, pšosym wopytaj póznjej hyšći raz',
	'wah-transcode-helpout' => 'Móžoš pomagaś toś te wideo pśekoděrowaś, z tym až woglědujoš k [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Toś ta dataja njejo se dała pśekoděrowaś.',
	'wah-javascript-off' => 'Musyš JavaScript zmóžniś, aby se na Wiki@Home wobźělił',
	'wah-loading' => 'Pówjerch Wiki@Home se zacytujo ...',
	'wah-menu-jobs' => 'Źěła',
	'wah-menu-stats' => 'Statistika',
	'wah-menu-pref' => 'Nastajenja',
	'wah-lookingforjob' => 'Pyta se źěło ...',
	'wah-start-on-visit' => 'Wiki@Home kuždy raz startowaś, gaž woglědujom se k toś tomu sedłoju.',
	'wah-jobs-while-away' => 'Źěła jano wuwjasć, gaž som 20 minutow wót swójogo wobglědowaka pšec.',
	'wah-nojobfound' => 'Žadne źěło namakane. Nowy wopyt za $1.',
	'wah-notoken-login' => 'Sy se pśizjawił? Jolic nic, pśizjaw se pšosym njepjerwjej.',
	'wah-apioff' => 'Zda se, až API Wiki@Home jo wušaltowany. Pšosym staj se z wikiadministratorom do zwiska.',
	'wah-doing-job' => 'Źěło: <i>$1</i> na: <i>$2</i>',
	'wah-downloading' => 'Ześěgnjenje dataje <i>$1</i> dokóńcone',
	'wah-encoding' => 'Koděrowanje dataje <i>$1</i> dokóńcone',
	'wah-encoding-fail' => 'Koděrowanje njejo se raźiło. Pšosym zacytaj bok znowego abo wopytaj pózdźej hyšći raz.',
	'wah-uploading' => 'Nagraśe dataje <i>$1</i> dokóńcone',
	'wah-uploadfail' => 'Nagraśe jo se njeraźiło',
	'wah-doneuploading' => 'Nagraśe dokóńcone. Źěkujomy se za twój pśinosk.',
	'wah-needs-firefogg' => 'Aby se na Wiki@Home wobźělił, musyš <a href="http://firefogg.org">Firefogg</a> instalěrowaś.',
	'wah-api-error' => 'Zmólka z API jo nastała. Pšosym wopytaj pózdźej hyšći raz.',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Dada
 * @author Lou
 * @author ZaDiak
 * @author Περίεργος
 */
$messages['el'] = array(
	'wah-short-audio' => '$1 αρχείο ήχου, $2',
	'wah-short-video' => '$1 αρχείο βίντεο, $2',
	'wah-short-general' => '$1 αρχείο μέσου, $2',
	'wah-long-audio' => '$1 αρχείο ήχου, διάρκεια $2, $3',
	'wah-long-video' => '$1 αρχείο βίντεο, διάρκεια $2, $4×$5 πίξελ, $3',
	'wah-long-general' => 'αρχείο μέσου, διάρκεια $2, $3',
	'wah-long-error' => 'το ffmpeg δεν μπορούσε να διαβάσει αυτό το αρχείο: $1',
	'wah-transcode-working' => 'Αυτό το βίντεο προωθείται, παρακαλώ δοκιμαστε ξανά αργότερα',
	'wah-javascript-off' => 'Θα πρέπει να έχετε ενεργοποιημένη τη Javascript για να συμμετάσχετε στο Wiki@Home',
	'wah-menu-jobs' => 'Εργασίες',
	'wah-menu-stats' => 'Στατιστικά',
	'wah-menu-pref' => 'Προτιμήσεις',
	'wah-lookingforjob' => 'Αναζήτηση νέας εργασίας ...',
	'wah-notoken-login' => 'Είστε συνδεδεμένος (-η); Εάν όχι, παρακαλούμε συνδεθείτε πρώτα.',
	'wah-downloading' => 'Η μεταφόρτωση του αρχείου <i>$1</i> ολοκληρώθηκε',
	'wah-uploadfail' => 'Η φόρτωση απέτυχε',
	'wah-doneuploading' => 'Η επιφόρτωση ολοκληρώθηκε. Ευχαριστούμε για τη συνεισφορά σας.',
	'wah-api-error' => 'Υπήρξε ένα λάθος με το API. Παρακαλώ δοκιμάστε αργότερα.',
);

/** Esperanto (Esperanto)
 * @author Airon90
 * @author Lucas
 * @author Yekrats
 */
$messages['eo'] = array(
	'wah-loading' => 'ŝarĝante interfacon Wiki@Home ...',
	'wah-menu-jobs' => 'Laboroj',
	'wah-menu-stats' => 'Statistikoj',
	'wah-menu-pref' => 'Agordoj',
	'wah-lookingforjob' => 'Serĉante laboron ...',
	'wah-uploadfail' => 'Alŝutado malsukcesis',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Imre
 * @author Translationista
 */
$messages['es'] = array(
	'wah-desc' => 'Permitir la distribución de videos convertidos a los clientes utilizando firefogg',
	'wah-user-desc' => 'Wiki@Home permite a los miembros de la comunidad donar ciclos ociosos de cpu para ayudar en operaciones intensivas',
	'wah-short-audio' => 'Archivo de sonido $1, $2',
	'wah-short-video' => 'Archivo de vídeo $1, $2',
	'wah-short-general' => 'Archivo de media $1, $2',
	'wah-long-audio' => ' archivo de sonido $1, tamaño $2, $3',
	'wah-long-video' => 'archivo de video $1, tamaño $2, $4x$5 pixels, $3',
	'wah-long-multiplexed' => 'archivo mutiplexado de audio/video, $1, largo $2, $4x$5 pixeles, total $3',
	'wah-long-general' => 'archivo de media, tamaño $2, $3',
	'wah-long-error' => 'ffmpeg no puede leer el archivo: $1',
	'wah-transcode-working' => 'Este video está siendo procesado, por favor intente de nuevo mas tarde.',
	'wah-transcode-helpout' => 'Ud. puede ayudar a convertir este video visitando [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Falló la conversión del archivo.',
	'wah-javascript-off' => 'Ud. debe tener JavaScript activo para participar en Wiki@Home',
	'wah-loading' => 'cargando interfaz Wiki@Home ...',
	'wah-menu-jobs' => 'Trabajos',
	'wah-menu-stats' => 'Estadísticas',
	'wah-menu-pref' => 'Preferencias',
	'wah-lookingforjob' => 'En busca de trabajo',
	'wah-start-on-visit' => 'Iniciar Wiki@Home cada vez que visite este sitio.',
	'wah-jobs-while-away' => 'Ejecutar trabajos sólo cuando haya estado inactivo en mi navegador por al menos 20 minutos.',
	'wah-nojobfound' => 'No se ha encontrado trabajos. Se volverá a intentar en $1.',
	'wah-notoken-login' => '¿Has accedido? Si no, accede primero.',
	'wah-apioff' => 'La API de Wiki@Home parece estar desactivada. Por favor, contacte al administrador del wiki.',
	'wah-doing-job' => 'Trabajo: <i>$1</i> en: <i>$2</i>',
	'wah-downloading' => 'Descarga del archivo <i>$1%</i> completada',
	'wah-encoding' => 'Codificación del archivo <i>$1%</i> completada',
	'wah-encoding-fail' => 'Codificación fallida. Por favor, cargue esta página de nuevo o inténtelo más tarde.',
	'wah-uploading' => 'Subida del archivo <i>$1</i> completada',
	'wah-uploadfail' => 'Subida fallida',
	'wah-doneuploading' => 'Subida completada. Gracias por su colaboración.',
	'wah-needs-firefogg' => 'Para participar en Wiki@Home, necesitas instalar <a href="http://firefogg.org">Firefogg</a>',
	'wah-api-error' => 'Ha habido un error con el API. Por favor, inténtelo de nuevo más tarde.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'wah-menu-stats' => 'Arvandmestik',
	'wah-menu-pref' => 'Eelistused',
	'wah-notoken-login' => 'Kas oled sisse logitud? Kui ei, logi palun esiteks sisse.',
	'wah-uploadfail' => 'Üleslaadimine ebaõnnestus',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Unai Fdz. de Betoño
 */
$messages['eu'] = array(
	'wah-short-audio' => '$1 soinu fitxategia, $2',
	'wah-short-video' => '$1 bideo fitxategia, $2',
	'wah-short-general' => '$1 media fitxategia, $2',
	'wah-long-audio' => '$1 soinu fitxategia, luzeera $2, $3',
	'wah-long-video' => '$1 bideo fitxategia, luzeera $2, $4×$5 pixel, $3',
	'wah-long-general' => 'multimedia fitxategia, iraupena $2, $3',
	'wah-long-error' => 'ffmpeg-ek ezin du fitxategi hau irakurri: $1',
	'wah-transcode-working' => 'Bideo hau prozesatzen ari da, mesedez, saia zaitez beranduago',
	'wah-menu-stats' => 'Estatistikak',
	'wah-menu-pref' => 'Hobespenak',
	'wah-uploadfail' => 'Igoerak huts egin du',
	'wah-doneuploading' => 'Igoera amaitu da. Eskerrik asko zure ekarpenagatik.',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'wah-user-desc' => 'Wiki@Homen avulla yhteisön jäsenet voivat lahjoittaa käyttämätöntä suoritinaikaa paljon resursseja kuluttaviin operaatioihin.',
	'wah-short-audio' => 'Äänitiedosto $1, $2',
	'wah-short-video' => 'Videotiedosto $1, $2',
	'wah-short-general' => 'Mediatiedosto $1, $2',
	'wah-long-audio' => 'äänitiedosto $1, pituus $2, $3',
	'wah-long-video' => '$1 videotiedosto, pituus $2, $4×$5 pikseliä, $3',
	'wah-long-general' => 'mediatiedosto, pituus $2, $3',
	'wah-long-error' => 'ffmpeg ei kyennyt lukemaan tätä tiedostoa: $1',
	'wah-transcode-working' => 'Tätä videota käsitellään parhaillaan, yritä myöhemmin uudelleen',
	'wah-transcode-fail' => 'Tämä tiedosto ei transkoodautunut.',
	'wah-javascript-off' => 'JavaScriptin on oltava käytössä, jotta voit osallistua Wiki@Homeen',
	'wah-loading' => 'ladataan Wiki@Home-käyttöliittymää...',
	'wah-menu-jobs' => 'Työt',
	'wah-menu-stats' => 'Tilastot',
	'wah-menu-pref' => 'Asetukset',
	'wah-lookingforjob' => 'Etsitään työtä...',
	'wah-start-on-visit' => 'Käynnistä Wiki@Home aina kun vierailen tällä sivulla.',
	'wah-uploading' => 'Tiedoston <i>$1</i> tallennus onnistui',
	'wah-uploadfail' => 'Tallennus epäonnistui',
	'wah-doneuploading' => 'Lähetys valmis. Kiitos osallistumisestasi.',
	'wah-needs-firefogg' => 'Osallistuaksesi Wiki@Homeen sinun täytyy asentaa <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'API-virhe. Yritä myöhemmin uudelleen.',
);

/** French (Français)
 * @author IAlex
 * @author Jean-Frédéric
 * @author PieRRoMaN
 * @author Urhixidur
 */
$messages['fr'] = array(
	'wah-desc' => 'Permet, à l’aide de Firefogg, de distribuer aux clients les tâches de transcodage vidéo.',
	'wah-user-desc' => 'Wiki@Home permet aux membres de la communauté de donner des cycles de processeur libres pour aider des opérations exigeantes en ressources.',
	'wah-short-audio' => 'fichier sonore $1, $2',
	'wah-short-video' => 'fichier vidéo $1, $2',
	'wah-short-general' => 'fichier média $1, $2',
	'wah-long-audio' => 'fichier son $1, durée $2, $3',
	'wah-long-video' => 'fichier son $1, durée $2, $4×$5 pixels, $3',
	'wah-long-multiplexed' => 'fichier audio / vidéo multiplexé $1, durée $2, $4×$5 pixels, $3 total',
	'wah-long-general' => 'fichier média, durée $2, $3',
	'wah-long-error' => 'ffmpeg n’a pas pu lire ce fichier : $1',
	'wah-transcode-working' => 'Cette vidéo est en train d’être transcodée, ressayez plus tard',
	'wah-transcode-helpout' => 'Vous pouvez aider à transcoder cette vidéo en visitant [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Ce fichier n’a pas pu être transcodé.',
	'wah-javascript-off' => 'Vous devez activer JavaScript pour participer à Wiki@Home',
	'wah-loading' => 'chargement de l’interface Wiki@Home ...',
	'wah-menu-jobs' => 'Tâches',
	'wah-menu-stats' => 'Statistiques',
	'wah-menu-pref' => 'Préférences',
	'wah-lookingforjob' => 'Recherche de tâche ...',
	'wah-start-on-visit' => 'Démarrer Wiki@Home à chaque fois que je visite ce site.',
	'wah-jobs-while-away' => 'Lancer une tâche seulement quand je ne me suis pas servi de mon navigateur pendant 20 minutes.',
	'wah-nojobfound' => 'Pas de tâche trouvée. Nouvel essai dans $1.',
	'wah-notoken-login' => 'Êtes-vous connecté ? Si ce n’est pas le cas, veuillez commencer par vous connecter.',
	'wah-apioff' => 'L’API de Wiki@Home semble ne pas fonctionner. Veuillez contacter l’administrateur wiki.',
	'wah-doing-job' => 'Tâche : <i>$1</i> sur : <i>$2</i>',
	'wah-downloading' => 'Téléchargement du fichier <i>$1%</i> terminé',
	'wah-encoding' => 'Encodage du fichier <i>$1%</i> terminé',
	'wah-encoding-fail' => 'L’encodage a échoué. Veuillez recharger cette page ou ressayer plus tard.',
	'wah-uploading' => 'Téléversement du fichier <i>$1</i> terminé.',
	'wah-uploadfail' => 'Le téléversement a échoué',
	'wah-doneuploading' => 'Téléversement terminé. Merci de votre contribution.',
	'wah-needs-firefogg' => 'Pour contribuer à Wiki@Home vous devez installer <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Il y a eu une erreur avec l’API. Veuillez ressayer plus tard.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'wah-short-audio' => 'fichiér son $1, $2',
	'wah-short-video' => 'fichiér vidèô $1, $2',
	'wah-short-general' => 'fichiér mèdia $1, $2',
	'wah-long-audio' => 'fichiér son $1, temps $2, $3',
	'wah-long-video' => 'fichiér vidèô $1, temps $2, $4×$5 pixèls, $3',
	'wah-long-multiplexed' => 'fichiér multiplèxo ôdiô / vidèô $1, temps $2, $4×$5 pixèls, en tot $3',
	'wah-long-general' => 'fichiér mèdia, temps $2, $3',
	'wah-long-error' => 'ffmpeg at pas possu liére ceti fichiér : $1',
	'wah-transcode-fail' => 'Ceti fichiér at pas possu étre transcodâ.',
	'wah-javascript-off' => 'Vos dête activar JavaScript por participar a Wiki@Home',
	'wah-loading' => 'chargement de l’entèrface Wiki@Home ...',
	'wah-menu-jobs' => 'Travâlys',
	'wah-menu-stats' => 'Statistiques',
	'wah-menu-pref' => 'Prèferences',
	'wah-lookingforjob' => 'Rechèrche de travâly ...',
	'wah-start-on-visit' => 'Emmodar Wiki@Home a châque côp que visito ceti seto.',
	'wah-doing-job' => 'Travâly : <i>$1</i> dessus : <i>$2</i>',
	'wah-downloading' => 'Tèlèchargement du fichiér <i>$1 %</i> chavonâ',
	'wah-encoding' => 'Encodâjo du fichiér <i>$1 %</i> chavonâ',
	'wah-encoding-fail' => 'L’encodâjo at pas reussi. Volyéd rechargiér ceta pâge ou ben tornar èprovar pués aprés.',
	'wah-uploading' => 'Tèlèchargement du fichiér <i>$1</i> chavonâ',
	'wah-uploadfail' => 'Lo tèlèchargement at pas reussi',
	'wah-needs-firefogg' => 'Por participar a Wiki@Home vos dête enstalar <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Y at avu una èrror avouéc l’API. Volyéd tornar èprovar pués aprés.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wah-desc' => 'Activa a distribución de postos de traballo de transcodificación de vídeo para os clientes que usen firefogg.',
	'wah-user-desc' => 'O Wiki@Home permite que os membros da comunidade doen ciclos CPU de recambio para axudar con operacións intensivas de recursos',
	'wah-short-audio' => 'Ficheiro de son $1, $2',
	'wah-short-video' => 'Ficheiro de vídeo $1, $2',
	'wah-short-general' => 'Ficheiro multimedia $1, $2',
	'wah-long-audio' => 'ficheiro de son $1, duración $2, $3',
	'wah-long-video' => 'Ficheiro de vídeo $1, duración $2, $4×$5 píxeles, $3',
	'wah-long-multiplexed' => 'ficheiro multiplex de son/vídeo, $1, duración $2, $4×$5 píxeles, $3 total',
	'wah-long-general' => 'ficheiro multimedia, duración $2, $3',
	'wah-long-error' => 'ffmpeg non puido ler este ficheiro: $1',
	'wah-transcode-working' => 'Este vídeo está sendo procesado, por favor, inténteo máis tarde',
	'wah-transcode-helpout' => 'Pode axudar na transcodificación deste vídeo visitando [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Fallou a transcodificación do ficheiro.',
	'wah-javascript-off' => 'Debe ter o Javascript activado para participar no Wiki@Home',
	'wah-loading' => 'cargando a interface do Wiki@Home...',
	'wah-menu-jobs' => 'Tarefas',
	'wah-menu-stats' => 'Estatísticas',
	'wah-menu-pref' => 'Preferencias',
	'wah-lookingforjob' => 'Procurando unha tarefa...',
	'wah-start-on-visit' => 'Iniciar o Wiki@Home cada vez que visite este sitio.',
	'wah-jobs-while-away' => 'Executar só as tarefas cando non use o meu navegador durante 20 minutos.',
	'wah-nojobfound' => 'Non se atopou ningunha tarefa. Volverase intentar en $1.',
	'wah-notoken-login' => 'Accedeu ao sistema? Se aínda non, acceda primeiro.',
	'wah-apioff' => 'A API do Wiki@Home semella estar desactivada. Póñase en contacto co administrador do wiki.',
	'wah-doing-job' => 'Tarefa: <i>$1</i> en: <i>$2</i>',
	'wah-downloading' => 'Descarga do ficheiro completada ao <i>$1%</i>',
	'wah-encoding' => 'Codificación do ficheiro completada ao <i>$1%</i>',
	'wah-encoding-fail' => 'Fallou a codificación. Recargue esta páxina ou inténteo de novo máis tarde.',
	'wah-uploading' => 'Completouse a carga do ficheiro <i>$1</i>',
	'wah-uploadfail' => 'Fallou a carga',
	'wah-doneuploading' => 'Completouse a carga. Grazas pola súa contribución.',
	'wah-needs-firefogg' => 'Para participar no Wiki@Home ten que instalar o <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Houbo un erro coa API. Por favor, inténteo de novo máis tarde.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'wah-desc' => 'Macht s Verteile vu Video-Transkodier-Jobs an Clients mit firefogg megli',
	'wah-user-desc' => 'Wiki@Home macht s Gmeinschafts-Mitglider megli freji CPU-Zyte z spände go bi ressourceintensive Operatione z hälfe',
	'wah-short-audio' => '$1-Audiodatei, $2',
	'wah-short-video' => '$1-Videodatei, $2',
	'wah-short-general' => '$1-Mediadatei, $2',
	'wah-long-audio' => '$1-Audiodatei, Lengi: $2, $3',
	'wah-long-video' => '$1-Videodatei, Lengi: $2, $4×$5 Pixel, $3',
	'wah-long-multiplexed' => 'Multiplex-Audio-/Video-Datei, $1, Lengi: $2, $4×$5 Pixel, $3 insgsamt',
	'wah-long-general' => 'Mediadatei, Lengi: $2, $3',
	'wah-long-error' => 'ffmpeg het die Datei nit chenne läse: $1',
	'wah-transcode-working' => 'S Video wird verarbeitet, bitte versuech s speter nomol',
	'wah-transcode-helpout' => 'Du chasch hälfe des Video z verarbeite, indäm Du [[Special:WikiAtHome|Wiki@Home]] bsuechsch',
	'wah-transcode-fail' => 'Die Datei het nit chenne transkodiert wäre.',
	'wah-javascript-off' => 'Du muesch JavaScript megli mache go bi Wiki@Home mitmache',
	'wah-loading' => 'Am Lade vu dr Wiki@Home-Benutzeroberflächi …',
	'wah-menu-jobs' => 'Uftreg',
	'wah-menu-stats' => 'Statischtike',
	'wah-menu-pref' => 'Yystellige',
	'wah-lookingforjob' => 'Am Sueche noch eme Uftrag ...',
	'wah-start-on-visit' => 'Wiki@Home jedes Mol starte, wänn ich uf die Syte gang.',
	'wah-jobs-while-away' => 'Uftreg nume laufe loo, wänn ich fir meh wie 20 Minute myy Browser nit brucht haa.',
	'wah-nojobfound' => 'Kei Uftrag gfunde. Neje Versuech: $1.',
	'wah-notoken-login' => 'Bisch aagmäldet? Wänn nit, no tue di bitte zerscht aamälde.',
	'wah-apioff' => 'Wiki@Home API isch schyns abgstellt. Bitte nimm Kontakt uf zum Wikiadministrator.',
	'wah-doing-job' => 'Uftrag: <i>$1</i> uf: <i>$2</i>',
	'wah-downloading' => 'Datei <i>$1%</i> abeglade',
	'wah-encoding' => 'Datei <i>$1%</i> fertig konvertiert',
	'wah-encoding-fail' => 'Konvertierig isch fähl gschlaa. Bitte lad die Syte nej oder versuech s speter nomol.',
	'wah-uploading' => 'Datei <i>$1</i> uffeglade',
	'wah-uploadfail' => 'Uffelade isch fähl gschlaa',
	'wah-doneuploading' => 'Uffelade abgschlosse. Dankschen fir Dyy Byytrag.',
	'wah-needs-firefogg' => 'Go mitmache bi Wiki@Home muesch <a href="http://firefogg.org">Firefogg</a> inschtalliere.',
	'wah-api-error' => 'S het e Fähler mit dr API gee. Bitte versuech s speter nomol.',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'wah-desc' => 'מתן האפשרות להפצת עבודות לקידוד וידאו אל לקוחות באמצעות firefogg',
	'wah-user-desc' => 'ההרחבה Wiki@Home מאפשרת לחברי הקהילה לתרום כוחות עיבוד עודפים על מנת לעזור לפעולות הדורשות משאבים רבים',
	'wah-short-audio' => 'קובץ שמע מסוג $1, $2',
	'wah-short-video' => 'קובץ וידאו מסוג $1, $2',
	'wah-short-general' => 'קובץ מדיה מסוג $1, $2',
	'wah-long-audio' => 'קובץ שמע מסוג $1, באורך $2, $3',
	'wah-long-video' => 'קובץ וידאו מסוג $1, באורך $2, $4×$5 פיקסלים, $3',
	'wah-long-multiplexed' => 'קובץ שמע/וידאו מרובב, $1, באורך $2, $4×$5 פיקסלים, $3 בסך הכול',
	'wah-long-general' => 'קובץ מדיה, באורך $2, $3',
	'wah-long-error' => 'ffmpeg לא הצליח לקרוא קובץ זה: $1',
	'wah-transcode-working' => 'וידאו זה נמצא בתהליכי עיבוד, נא לנסות שוב מאוחר יותר',
	'wah-transcode-helpout' => 'ניתן לעזור בקידוד הווידאו הזה על ידי ביקור בדף [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'קידוד קובץ זה נכשל.',
	'wah-javascript-off' => 'עליכם להפעיל את תכונת ה־JavaScript כדי לקחת חלק ב־Wiki@Home',
	'wah-loading' => 'ממשק Wiki@Home נטען כעת ...',
	'wah-menu-jobs' => 'משימות',
	'wah-menu-stats' => 'סטטיסטיקה',
	'wah-menu-pref' => 'העדפות',
	'wah-lookingforjob' => 'מתבצע חיפוש אחר משימה ...',
	'wah-start-on-visit' => 'יש להפעיל את Wiki@Home בכל פעם שאבקר באתר זה.',
	'wah-jobs-while-away' => 'יש להריץ משימות רק כאשר אינני משתמש בדפדפן למשך 20 דקות.',
	'wah-nojobfound' => 'לא נמצאה משימה. נסיון חוזר בעוד $1.',
	'wah-notoken-login' => 'האם ביצעתם כניסה? אם לא, אנא הכנסו תחילה.',
	'wah-apioff' => 'מסתבר כי ה־API של Wiki@Home כבוי. נא ליצור קשר עם מנהל הוויקי.',
	'wah-doing-job' => 'משימה: <i>$1</i> על: <i>$2</i>',
	'wah-downloading' => 'הורדת הקובץ <i>$1%</i> הושלמה',
	'wah-encoding' => 'קידוד הקובץ <i>$1%</i> הושלם',
	'wah-encoding-fail' => 'הקידוד נכשל. יש לטעון דף זה מחדש או לנסות שוב מאוחר יותר.',
	'wah-uploading' => 'העלאת הקובץ <i>$1</i> הושלמה',
	'wah-uploadfail' => 'ההעלאה נכשלה',
	'wah-doneuploading' => 'ההעלאה הושלמה. תודה לכם על תרומכתם.',
	'wah-needs-firefogg' => 'כדי לקחת חלק ב־Wiki@Home יהיה עליך להתקין את <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'ארעה שגיאה במנשק תפעול התוכנית. יש לנסות שוב מאוחר יותר.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'wah-desc' => 'Zmóžnja rozdźělenje nadawkow překodowanja widejow klientam z pomocu firefogg.',
	'wah-user-desc' => 'Wiki@Home zmóžnja čłonam zhromadźenstwa, zo bychu nadbytkowe cyklusy CPU darili, zo bychu při operacoje pomhali, kotrež wjele resursow přetrjebuja',
	'wah-short-audio' => 'zwukodataja $1, $2',
	'wah-short-video' => 'widejodataja $1, $2',
	'wah-short-general' => 'medijowa dataja $1, $2',
	'wah-long-audio' => 'zwukodataja $1, dołhosć $2, $3',
	'wah-long-video' => 'widejodataja $1, dołhosć $2, $4×$5 pikselow, $3',
	'wah-long-multiplexed' => 'multipleksowana awdio-/widejodatja, $1, dołhosć $2, $4×$5 pikselow, $3 dohromady',
	'wah-long-general' => 'medijowa dataja, dołhosć $2, $3',
	'wah-long-error' => 'ffmpeg njeje móhł tutu dataju čitać: $1',
	'wah-transcode-working' => 'Tute widejo so wobdźěłuje, prošu spytaj pozdźišo hišće raz',
	'wah-transcode-helpout' => 'Móžeš pomhać tute widejo přez wopyt na [[Special:WikiAtHome|Wiki@Home]] překodować',
	'wah-transcode-fail' => 'Njeje so poradźiło tutu dataju překodować.',
	'wah-javascript-off' => 'Dyrbiš JavaScript zmóžnić, zo by so na Wiki@Home wobdźělił',
	'wah-loading' => 'Začitanje powjercha Wik@Home  ...',
	'wah-menu-jobs' => 'Dźěła',
	'wah-menu-stats' => 'Statistika',
	'wah-menu-pref' => 'Nastajenja',
	'wah-lookingforjob' => 'Pyta so dźěło ...',
	'wah-start-on-visit' => 'Wiki@Home kóždy raz startować, hdyž tute sydło wopytuju.',
	'wah-jobs-while-away' => 'Dźěła jenož wuwjesć, hdyž sym hižo 20 mjeńšin wot swojeho wobhladowaka preč.',
	'wah-nojobfound' => 'Žane dźěło namakane. Nowy pospyt budźe za $1.',
	'wah-notoken-login' => 'Sy so přizjewił? Jeli nic, prošu přizjew so najprjedy.',
	'wah-apioff' => 'Zda so, zo API Wiki@Home je wupinjeny. Prošu staj so z wikiadministratorom do zwiska.',
	'wah-doing-job' => 'Dźěło: <i>$1</i> na: <i>$2</i>',
	'wah-downloading' => 'Sćehnjenje dataje <i>$1%</i> zakónčene',
	'wah-encoding' => 'Kodowanje dataje <i>$1%</i> zakónčene',
	'wah-encoding-fail' => 'Kodowanje je so njeporadźiło. Prošu začitaj tutu stronu znowa abo spytaj pozdźišo hišće raz.',
	'wah-uploading' => 'Nahraće dataje <i>$1%</i> zakónčene',
	'wah-uploadfail' => 'Nahraće je so njeporadźiło',
	'wah-doneuploading' => 'Nharaće zakónčene. Dźakujemy so za twój přinošk.',
	'wah-needs-firefogg' => 'Zo by so na Wiki@Home wobdźělił, dyrbiš <a href="http://firefogg.org">Firefogg</a> instalować.',
	'wah-api-error' => 'Zmylk z API je wustupił. Prošu spytaj pozdźišo hišće raz.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'wah-desc' => 'Lehetővé teszi a videó-átkódolási feladatok elosztott feldolgozását a Firefoggot használó klienseken',
	'wah-user-desc' => 'A Wiki@Home segítségével a közösség tagjai felajánlhatják a felesleges CPU idejüket az erőforrásigényes műveletekhez',
	'wah-short-audio' => '$1 hangfájl, $2',
	'wah-short-video' => '$1 videofájl, $2',
	'wah-short-general' => '$1 médiafájl, $2',
	'wah-long-audio' => '$1 hangfájl, hossza: $2, bitsűrűsége: $3',
	'wah-long-video' => '$1 videófájl, hossza $2, $4×$5 képpont, bitsűrűsége: $3',
	'wah-long-multiplexed' => 'multiplexelt audió/videó fájl, $1, hossza: $2, $4×$5 képpont, $3 bitsűrűség',
	'wah-long-general' => 'médiafájl, hossza: $2, bitsűrűsége: $3',
	'wah-long-error' => 'az ffmpeg nem tudja olvasni a következő fájlt: $1',
	'wah-transcode-working' => 'Ez a videó feldolgozás alatt van, kérlek próbáld később',
	'wah-transcode-helpout' => 'Segíthetsz a videó átkódolásában a [[Special:WikiAtHome|Wiki@Home]] lap felkeresésével.',
	'wah-transcode-fail' => 'A fájl átkódolása meghiúsult.',
	'wah-javascript-off' => 'A Wiki@Home-ban való részvételhez engedélyezned kell a JavaScriptet',
	'wah-loading' => 'Wiki@Home interfész betöltése …',
	'wah-menu-jobs' => 'Feladatok',
	'wah-menu-stats' => 'Statisztikák',
	'wah-menu-pref' => 'Beállítások',
	'wah-lookingforjob' => 'Feladatra várok…',
	'wah-start-on-visit' => 'Wiki@Home elindítása minden alkalommal, amikor ellátogatok az oldalra.',
	'wah-jobs-while-away' => 'Csak akkor futtasd a feladatokat, ha már 20 perce távol vagyok a böngészőtől.',
	'wah-nojobfound' => 'Nem található feladat. Újrapróbálom ekkor: $1.',
	'wah-notoken-login' => 'Be vagy jelentkezve? Ha nem, kérlek előbb tedd meg.',
	'wah-apioff' => 'Úgy tűnik, hogy a Wiki@Home API nincs bekapcsolva. Lépj kapcsolatba a wiki adminisztrátorával.',
	'wah-doing-job' => 'Feladat típusa: <i>$1</i>, neve: <i>$2</i>',
	'wah-downloading' => 'A fájl letöltésének <i>$1%</i>-a kész',
	'wah-encoding' => 'A fájl átkódolásának <i>$1%</i>-a kész',
	'wah-encoding-fail' => 'Az átkódolás nem sikerült. Kérlek frissítsd a lapot, vagy nézz vissza később.',
	'wah-uploading' => 'A(z) <i>$1</i> fájl feltöltése kész',
	'wah-uploadfail' => 'Sikertelen feltöltés',
	'wah-doneuploading' => 'A feltöltés kész. Köszönjük a közreműködésed.',
	'wah-needs-firefogg' => 'Hogy közreműködj a Wiki@Home-ban, fel kell telepítened a <a href="http://firefogg.org">Firefogg</a>-ot.',
	'wah-api-error' => 'Hiba történt az API-val. Kérlek nézz vissza később.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wah-desc' => 'Permitte le division del carga de transcodification de video inter computatores-clientes per medio de firefogg',
	'wah-user-desc' => 'Wiki@Home permitte al membros del communicate donar cyclos libere del processator pro adjutar operationes intensive in ressources.',
	'wah-short-audio' => 'file audio $1, $2',
	'wah-short-video' => 'file video $1, $2',
	'wah-short-general' => 'file multimedia $1, $2',
	'wah-long-audio' => 'file audio $1, durata $2, $3',
	'wah-long-video' => 'file video $1, durata $2, $4×$5 pixels, $3',
	'wah-long-multiplexed' => 'file audio/video multiplexate, $1, durata $2, $4×$5 pixels, $3 in total',
	'wah-long-general' => 'file multimedia, durata $2, $3',
	'wah-long-error' => 'ffmpeg non poteva leger le file: $1',
	'wah-transcode-working' => 'Iste video es in le processo de esser transcodificate. Per favor reproba plus tarde.',
	'wah-transcode-helpout' => 'Tu pote adjutar a transcodificar iste video per visitar [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Le transcodification de iste file ha fallite.',
	'wah-javascript-off' => 'Tu debe activar JavaScript pro participar in Wiki@Home.',
	'wah-loading' => 'carga interfacie de Wiki@Home ...',
	'wah-menu-jobs' => 'Cargas',
	'wah-menu-stats' => 'Statisticas',
	'wah-menu-pref' => 'Preferentias',
	'wah-lookingforjob' => 'Recerca de un carga ...',
	'wah-start-on-visit' => 'Mitter Wiki@Home in action cata vice que io visita iste sito.',
	'wah-jobs-while-away' => 'Executar cargas solmente quando io ha essite absente de mi navigator durante 20 minutas.',
	'wah-nojobfound' => 'Nulle carga trovate. Reprobara in $1.',
	'wah-notoken-login' => 'Es tu authenticate? Si non, per favor aperi un session primo.',
	'wah-apioff' => 'Le API de Wiki@Home pare esser inactive. Per favor contacta le administrator del wiki.',
	'wah-doing-job' => 'Carga: <i>$1</i> in: <i>$2</i>',
	'wah-downloading' => 'Discargamento del file <i>$1%</i> complete',
	'wah-encoding' => 'Codification del file <i>$1%</i> complete',
	'wah-encoding-fail' => 'Codification falleva. Per favor recarga iste pagina o reproba plus tarde.',
	'wah-uploading' => 'Incargamento del file <i>$1%</i> complete',
	'wah-uploadfail' => 'Le incargamento ha fallite',
	'wah-doneuploading' => 'Incargamento complete. Gratias pro tu contribution.',
	'wah-needs-firefogg' => 'Pro participar in Wiki@Home tu debe installar <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Il ha occurrite un error con le API. Per favor reproba plus tarde.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Anakmalaysia
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Kandar
 */
$messages['id'] = array(
	'wah-desc' => '

Memungkinkan mendistribusikan pekerjaan video transcoding untuk klien yang menggunakan Firefogg',
	'wah-user-desc' => 'Wiki@Home memungkinkan anggotan komunitas untuk mendonasikan cadangan CPU untuk membantu beroperasi intensif sumber daya',
	'wah-short-audio' => '$1 berkas suara, $2',
	'wah-short-video' => 'Berkas video $1, $2',
	'wah-short-general' => 'Berkas media $1, $2',
	'wah-long-audio' => '$1 berkas suara, panjang $2, $3',
	'wah-long-video' => '$1 berkas video, panjang $2, $4×$5 piksel, $3',
	'wah-long-multiplexed' => 'Berkas multiplexed audio/video, $1, lama $2, $4x$5 piksel, $3 keseluruhan',
	'wah-long-general' => 'berkas media, panjang $2, $3',
	'wah-long-error' => 'ffmpeg tak bisa membaca berkas ini: $1',
	'wah-transcode-working' => 'Video ini sedang diolah, silakan coba lagi nanti',
	'wah-transcode-helpout' => 'Anda dapat membantu video transcode ini dengan mengunjungi [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Berkas ini gagal untuk di transcode.',
	'wah-javascript-off' => 'Anda harus mengaktifkan JavaScript agar dapat berpartisipasi di Wiki@Home',
	'wah-loading' => 'Memuat Antarmuka Wiki@Home ...',
	'wah-menu-jobs' => 'Pekerjaan',
	'wah-menu-stats' => 'Statistik',
	'wah-menu-pref' => 'Preferensi',
	'wah-lookingforjob' => 'Mencari pekerjaan ...',
	'wah-start-on-visit' => 'Aktifkan Wiki@Home setiap kali saya mengunjungi situs ini.',
	'wah-jobs-while-away' => 'Hanya jalankan pekerjaan ketika saya telah tidak menggunakan penjelajah saya selama 20 menit.',
	'wah-nojobfound' => 'Tidak ada pekerjaan yang ditemukan. Akan mencoba lagi dalam $1.',
	'wah-notoken-login' => 'Apakah Anda telah masuk log? Jika belum, silakan masuk log dulu.',
	'wah-apioff' => 'API Wiki@Home tampaknya mati. Silakan hubungi pengelola wiki ini.',
	'wah-doing-job' => 'Pekerjaan: <i>$1</i> pada: <i>$2</i>',
	'wah-downloading' => 'Pengunduhan berkas <i>$1%</i> selesai',
	'wah-encoding' => 'Pengkodean berkas <i>$1%</i> selesai',
	'wah-encoding-fail' => 'Pengkodean gagal. Silakan muat ulang halaman atau coba lagi nanti.',
	'wah-uploading' => 'Pengunggahan berkas <i>$1</i> selesai',
	'wah-uploadfail' => 'Pengunggahan gagal',
	'wah-doneuploading' => 'Pengunggahan selesai. Terima kasih atas kontribusi Anda.',
	'wah-needs-firefogg' => 'Untuk berpartisipasi dalam Wiki@Home, Anda perlu menginstal <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Ada kesalahan pada API. Silakan coba lagi nanti.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'wah-menu-jobs' => 'Orü',
	'wah-lookingforjob' => 'Nètú orü ...',
	'wah-doing-job' => 'Orü: <i>$1</i> na: <i>$2</i>',
	'wah-uploadfail' => 'Itinyé elu á dálá',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Gianfranco
 */
$messages['it'] = array(
	'wah-javascript-off' => 'Devi avere i JavaScript abilitati per poter partecipare a Wiki@Home',
	'wah-menu-pref' => 'Preferenze',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author 青子守歌
 */
$messages['ja'] = array(
	'wah-desc' => '動画のトランスコード・ジョブを Firefogg を使ってクライアントに分散できるようにする。',
	'wah-user-desc' => 'Wiki@Home は、コミュニティ参加者が余った CPU サイクルを提供することで、リソース集約的な処理を手伝えるようにします',
	'wah-short-audio' => '$1音声ファイル、$2',
	'wah-short-video' => '$1動画ファイル、$2',
	'wah-short-general' => '$1メディアファイル、$2',
	'wah-long-audio' => '$1音声ファイル、長さ：$2、$3',
	'wah-long-video' => '$1動画ファイル、長さ：$2、$4×$5ピクセル、$3',
	'wah-long-multiplexed' => '多重化された音声/動画ファイル、$1、長さ：$2、$4×$5ピクセル、全体で$3',
	'wah-long-general' => 'メディアファイル、長さ：$2、$3',
	'wah-long-error' => 'ffmpeg はこのファイルを読み取れませんでした: $1',
	'wah-transcode-working' => 'この動画は現在処理中です。後でまた試してください。',
	'wah-transcode-helpout' => '[[Special:WikiAtHome|Wiki@Home]] を使用すると、この動画のトランスコードをあなたが手伝うことができます',
	'wah-transcode-fail' => 'このファイルはトランスコードに失敗しました。',
	'wah-javascript-off' => 'Wiki@Home に参加するには JavaScript を有効にする必要があります',
	'wah-loading' => 'Wiki@Home のインタフェースを読み込み中…',
	'wah-menu-jobs' => 'ジョブ',
	'wah-menu-stats' => '統計',
	'wah-menu-pref' => '設定',
	'wah-lookingforjob' => 'ジョブを探しています...',
	'wah-start-on-visit' => 'サイトを訪れたら常にWiki@Homeを開始する',
	'wah-jobs-while-away' => '20分以上ブラウザから離れた時にだけ、ジョブを行なう。',
	'wah-nojobfound' => 'ジョブが見つかりませんでした、$1にリトライします。',
	'wah-notoken-login' => 'ログインしていますか？していない場合は最初にログインしてください。',
	'wah-apioff' => 'Wiki@HomeのAPI機能がオフになっています。ウィキの管理人に連絡を取ってみてください。',
	'wah-doing-job' => 'ジョブ：<i>$1</i>の<i>$2</i>',
	'wah-downloading' => 'ファイル<i>$1%</i>のダウンロードが完了しました',
	'wah-encoding' => 'ファイル<i>$1%</i>のエンコードが完了しました',
	'wah-encoding-fail' => 'エンコードに失敗しました。ページを更新するか、後でもう一度試してください。',
	'wah-uploading' => 'ファイル<i>$1%</i>のアップロードが完了しました',
	'wah-uploadfail' => 'アップロードに失敗',
	'wah-doneuploading' => 'アップロードは成功しました。投稿ありがとうございました。',
	'wah-needs-firefogg' => 'Wiki@Homeに参加するためには、<a href="http://firefogg.org">Firefogg</a>のインストールが必要です。',
	'wah-api-error' => 'APIでエラーが発生しました。後でもう一度試してください。',
);

/** Khmer (ភាសាខ្មែរ)
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'wah-short-audio' => '$1 ឯកសារ​សំលេង​, $2',
	'wah-short-video' => '$1 ឯកសារ​វីដេអូ​, $2',
	'wah-short-general' => '$1 ឯកសារ​មេឌា​, $2',
	'wah-long-audio' => '$1 ឯកសារសំឡេង, រយៈពេល$2, $3',
	'wah-long-video' => '$1 ឯកសារវីដេអូ, រយៈពេល $2, $4×$5 pixels, $3',
	'wah-long-general' => 'ឯកសារមេឌា, រយៈពេល$2, $3',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'wah-desc' => 'Määt et müjjelesch, et Viddejos ömzekodeere met <code lang="en">firefogg</code> als en Aufjab aan Metmaacher ze verdeile.',
	'wah-user-desc' => 'Wiki@Home määt et müjjelesch för Metmaacher, Leistung vum eijene Kompjuter affzejävve — en Momänte, woh dä söns jraad nix ze donn hät — öm bei opwändeje Rääschnereije vum Wiki ze hellfe.',
	'wah-short-audio' => '$1 Tondattei, $2',
	'wah-short-video' => '$1 Viddejodattei, $2',
	'wah-short-general' => '$1 Meedijedattei, $2',
	'wah-long-audio' => '$1 Tondattei, Ömfang $2, $3',
	'wah-long-video' => '$1 Viddejodattei, Ömfang $2, $4×$5 Pixele, $3',
	'wah-long-multiplexed' => 'Multipläx- Ton- un Viddejodattei, $1, Ömfang $2, $4×$5 Pixele, $3 zosamme',
	'wah-long-general' => 'Meedijedattei, Ömfang $2, $3',
	'wah-long-error' => '<code lang="en">ffmpeg</code> kunnt di Dattei nit lässe: $1',
	'wah-transcode-working' => 'Heh dä Viddejo weed ömkodeet, versöhk et schpääder norr_ens',
	'wah-transcode-helpout' => 'Do kanns beim Ömkodeere hellfe för heh dä Viddejo, jangk doför noh de Sigg [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Di Dattei lehß sesch ömkodeere.',
	'wah-javascript-off' => 'Dinge Brauser moß JavaSkrep künne un ennjeschalldt han, domet De bei Wiki@Home metmaache kanns.',
	'wah-loading' => 'Ben wiki@home sing Schnetshtëll aam laade{{int:ellipsis}}',
	'wah-menu-jobs' => 'Aufjabe',
	'wah-menu-stats' => 'Statißtike',
	'wah-menu-pref' => 'Ennshtellunge',
	'wah-lookingforjob' => 'Op en Aufjab aam waade&nbsp;{{int:ellipsis}}',
	'wah-start-on-visit' => 'Donn Wiki@Home jeedes Mohl aanwerfe, wann esch op heh di Webßaijt kummen.',
	'wah-jobs-while-away' => 'Nur dann Aufjabe beärbeide, wann esch 20 Mennutte lang fott jewääse ben vum Brauser.',
	'wah-nojobfound' => 'Kein Aufjab jevonge. Wider versöhke en $1.',
	'wah-notoken-login' => 'Bes De enjelogg? Wann nit, donn Desch eez ens enlogge.',
	'wah-apioff' => 'De <i lang="en">API</i> vun Wiki@Home schingk affjeschalldt ze sinn. Donn desch aan ene Wiki_Köbes wende.',
	'wah-doing-job' => 'Aufjab: <i>$1</i> vun: <i>$2</i>',
	'wah-downloading' => 'De Dattei es zoh $1% fäädesch eronger jelaade',
	'wah-encoding' => 'De Dattei es zoh $1% fäädesch kodeet',
	'wah-encoding-fail' => 'Dat Kodeere es donevve jejange. Donn heh di Sigg norr_ens laade, udder versöhk et schpääder widder.',
	'wah-uploading' => 'De Datei „$1“ es fäädesch huhjelaade',
	'wah-uploadfail' => 'Dat Huhlaade es donevve jejange',
	'wah-doneuploading' => 'Dat Huhlaade es fädesch. Mer donn uns för Dinge Beidraach bedangke.',
	'wah-needs-firefogg' => 'Öm bei Wiki@Home metzemaache, moß De <i lang="en"><a href="http://firefogg.org">Firefogg</a></i> enshtalleere.',
	'wah-api-error' => 'Ene Fähler es opjedrodde em Zosammehang met däm <i lang="en">API</i>. Donn et schpääder norr_ens versöhke.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'wah-desc' => "Erlaabten et fir d'Ëmschreiwe vu Video-Aarbechten op Client ze verdeelen déi Firefogg benotzen.",
	'wah-user-desc' => 'Wiki@Doheem erlaabt et Membere vun der Gemeinschaft fir spuersam CPU-Perioden ze spenden fir bäi resourcenintensiven Operatiounen ze hëllefen',
	'wah-short-audio' => '$1 Toun-Fichier, $2',
	'wah-short-video' => '$1 Video-Fichier, $2',
	'wah-short-general' => '$1 Medie-Fichier, $2',
	'wah-long-audio' => '$1 Tounfichier, Längt $2, $3',
	'wah-long-video' => '$1 Video-Fichier, Längt $2, $4x$5 Pixel, $3',
	'wah-long-multiplexed' => 'Multiplex-Audio-/Video-Fichier, $1, Längt: $2, $4×$5 Pixel, $3 am Ganzen',
	'wah-long-general' => 'Mediefichier, Längt $2, $3',
	'wah-long-error' => 'ffmpeg konnt de Fichier $1 net liesen',
	'wah-transcode-working' => 'Dëse Video gëtt elo ëmgewandelt, versicht et spéider w.e.g. nach eng kéier',
	'wah-transcode-helpout' => 'Dir kënnt hëllefen dëse Video ze transcodéiere wann Dir [[Special:WikiAtHome|Wiki@Home]] besicht',
	'wah-transcode-fail' => 'Dëse Fichier konnt net ëmgeschriwwe ginn.',
	'wah-javascript-off' => 'Dir musst JavaScript zouloossen fir bäi Wiki@Doheem matzemaachen',
	'wah-loading' => 'wiki@home Interface lueden ...',
	'wah-menu-jobs' => 'Aarbechten',
	'wah-menu-stats' => 'Statistiken',
	'wah-menu-pref' => 'Astellungen',
	'wah-lookingforjob' => 'No enger Aarbecht sichen ...',
	'wah-start-on-visit' => 'Wiki@Home all Kéiers beim Opmaache vun dëser Säit demarréieren.',
	'wah-jobs-while-away' => "Aufgaben nëmmen ausféieren, wann ech op d'mannst 20 Minutte keng Browseraktivitéit hat.",
	'wah-notoken-login' => "Sidd Dir ageloggt? Wann net, da loggt Iech w.e.g. fir d'éischt an.",
	'wah-downloading' => "D'Erofluede vum Fichier <i>$1%</i> ass fäerdeg",
	'wah-encoding-fail' => 'Encodage huet net geklappt. Luet dës Säit frësch oder probéiert méi spéit nach eng Kéier.',
	'wah-uploading' => 'De Fichier <i>$1</i> gouf komplett eropgelueden',
	'wah-uploadfail' => 'Eroplueden hue tnet fonctionnéiert',
	'wah-doneuploading' => 'Eroplueden ofgeschloss. Merci fir Äre Beitrag.',
	'wah-api-error' => 'Et gouf e Feeler mat dem API. Probéiert w.e.g. méi spéit nach eng Kéier.',
);

/** Lazuri (Lazuri)
 * @author Bombola
 */
$messages['lzz'] = array(
	'wah-menu-jobs' => 'Dulyape',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wah-desc' => 'Овозможува распределба на задачи за прекодирање на видеоснимки на клиенти користејќи Firefogg',
	'wah-user-desc' => 'Wiki@Home им овозможува на членовите на заедницата да донираат одвишок обработувачка (CPU) моќ како помош во операции кои бараат доста ресурси',
	'wah-short-audio' => '$1 аудиоснимка, $2',
	'wah-short-video' => '$1 видеоснимка, $2',
	'wah-short-general' => '$1 снимка, $2',
	'wah-long-audio' => '$1 снимка, времетраење $2, $3',
	'wah-long-video' => '$1 видеоснимка, времетраење $2, $4×$5 пиксели, $3',
	'wah-long-multiplexed' => 'мултиплексирана аудио/видео снимка, $1, времетраење $2, $4×$5 пиксели, $3 долж снимката',
	'wah-long-general' => 'снимка, времетраење $2, $3',
	'wah-long-error' => 'ffmpeg не можеше да ја прочита оваа податотека: $1',
	'wah-transcode-working' => 'Оваа видеоснимка се обработува, обидете се подоцна',
	'wah-transcode-helpout' => 'Можете да помогнете со транскодирање на оваа видеоснимка ако ја посетите страницата [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Оваа податотека не успеа да се транскодира.',
	'wah-javascript-off' => 'Мора да имате овозможено JavaScript за да учествувате во Wiki@Home',
	'wah-loading' => 'се вчитува посредникот на Wiki@Home ...',
	'wah-menu-jobs' => 'Задачи',
	'wah-menu-stats' => 'Статистики',
	'wah-menu-pref' => 'Нагодувања',
	'wah-lookingforjob' => 'Барам задача ...',
	'wah-start-on-visit' => 'Пушти го Wiki@Home секој пат кога ќе го посетам ова мрежно место.',
	'wah-jobs-while-away' => 'Пуштај задачи само кога не го користам прелистувачот веќе 20 минути.',
	'wah-nojobfound' => 'Нема пронајдено задача. Ќе се обидам повторно за  $1.',
	'wah-notoken-login' => 'Дали сте најавени? Ако не сте, прво ќе треба да се најавите.',
	'wah-apioff' => 'Изгледа дека Wiki@Home API е исклучен. Контактирајте го администраторот на викито.',
	'wah-doing-job' => 'Задача: <i>$1</i> за: <i>$2</i>',
	'wah-downloading' => 'Преземањето на податотеката  <i>$1%</i> заврши',
	'wah-encoding' => 'Кодирањето на податотеката <i>$1%</i> е завршено',
	'wah-encoding-fail' => 'Кодирањето не успеа. Превчитајте ја страницава или обидете се подоцна.',
	'wah-uploading' => 'Подигањето на податотеката <i>$1</i> е завршено',
	'wah-uploadfail' => 'Подигањето не успеа',
	'wah-doneuploading' => 'Подигањето заврши. Ви благодариме за придонесот.',
	'wah-needs-firefogg' => 'За да учествувате во Wiki@Home ќе треба да го инсталирате <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Настана грешка при работата со  API. Повторно обидете се подоцна.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wah-desc' => 'Membolehkan pengedaran tugas-tugas mentranskodkan video kepada klien dengan menggunakan Firefogg',
	'wah-user-desc' => 'Wiki@Home membolehkanpara  ahli komuniti untuk menderma kitaran cpu ganti untuk membantu operasi intensif sumber',
	'wah-short-audio' => 'Fail bunyi $1, $2',
	'wah-short-video' => 'Fail video $1, $2',
	'wah-short-general' => 'Fail media $1, $2',
	'wah-long-audio' => 'Fail bunyi $1, jangka masa $2, $3',
	'wah-long-video' => 'Fail video $1, jangka masa $2, $4×$5 piksel, $3',
	'wah-long-multiplexed' => 'fail audio/video bermultipleks, $1, jangka masa $2, $4×$5 piksel, $3 keseluruhannya',
	'wah-long-general' => 'fail media, jangka masa $2, $3',
	'wah-long-error' => 'ffmpeg tidak dapat membaca fail ini: $1',
	'wah-transcode-working' => 'Video ini sedang diproses, sila cuba lagi nanti',
	'wah-transcode-helpout' => 'Anda boleh membantu mentranskodkan video ini dengan mengunjungi [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Fail ini tidak dapat ditranskodkan.',
	'wah-javascript-off' => 'Anda mesti menghidupkan JavaScript untuk menyertai Wiki@Home',
	'wah-loading' => 'antaramuka Wiki@Home sedang dimuatkan ...',
	'wah-menu-jobs' => 'Tugas',
	'wah-menu-stats' => 'Statistik',
	'wah-menu-pref' => 'Keutamaan',
	'wah-lookingforjob' => 'Mencari tugas ...',
	'wah-start-on-visit' => 'Lancarkan Wiki@Home setiap kali saya mengunjungi tapak web ini.',
	'wah-jobs-while-away' => 'Jalankan tugas hanya sewaktu saya tidak menggunakan pelayar web selama 20 minit.',
	'wah-nojobfound' => 'Tiada tugas dijumpai. Akan dicuba lagi dalam masa $1.',
	'wah-notoken-login' => 'Sudahkah anda log masuk? Jika tidak, sila log masuk terlebih dahulu.',
	'wah-apioff' => 'API Wiki@Home nampaknya dimatikan. Sila hubungi pentadbir wiki.',
	'wah-doing-job' => 'Tugas: <i>$1</i> pada: <i>$2</i>',
	'wah-downloading' => 'Fail <i>$1%</i> siap dimuat turun',
	'wah-encoding' => 'Fail <i>$1%</i> siap dikodkan',
	'wah-encoding-fail' => 'Pengekodan tidak berjaya. Sila muatkan semula laman ini atau cuba lagi nanti.',
	'wah-uploading' => 'Fail <i>$1%</i> siap dimuat naik',
	'wah-uploadfail' => 'Muat naik gagal',
	'wah-doneuploading' => 'Muat naik selesai. Terima kasih atas sumbangan anda.',
	'wah-needs-firefogg' => 'Untuk menyertai Wiki@Home, anda perlu memasang <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Terdapat ralat dengan API. Sila cuba lagi nanti.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'wah-desc' => 'Aktiverer distribusjon av videoomkodingsjobber til klienter gjennom Firefogg',
	'wah-user-desc' => 'Wiki@Home tillater samfunnsmedlemmer å donere bort ubrukt prosessortid for å hjelpe til med ressurskrevende oppgaver',
	'wah-short-audio' => '$1-lydfil, $2',
	'wah-short-video' => '$1-videofil, $2',
	'wah-short-general' => '$1-mediafil, $2',
	'wah-long-audio' => '$1-lydfil, lengde $2, $3',
	'wah-long-video' => '$1-videofil, lengde $2, $4x$5 pixler, $3',
	'wah-long-multiplexed' => 'multiplexet lyd-/videofil, $1, lengde $2, $4x$5 pixler, $3 totalt',
	'wah-long-general' => 'mediafil, lengde $2, $3',
	'wah-long-error' => 'ffmpeg kunne ikke lese denne filen: $1',
	'wah-transcode-working' => 'Denne videoen blir bearbeidet, vennligst prøv igjen senere',
	'wah-transcode-helpout' => 'Du kan hjelpe til med å omkode denne videoen ved å besøke [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Kunne ikke konvertere denne filen.',
	'wah-javascript-off' => 'Du må aktivere JavaScript for å delta i Wiki@Home',
	'wah-loading' => 'laster grensesnittet for Wiki@Home ...',
	'wah-menu-jobs' => 'Oppgaver',
	'wah-menu-stats' => 'Statistikk',
	'wah-menu-pref' => 'Innstillinger',
	'wah-lookingforjob' => 'Leter etter en oppgave...',
	'wah-start-on-visit' => 'Start Wiki@Home hver gang jeg besøker dette nettstedet.',
	'wah-jobs-while-away' => 'Bare kjør oppgaver når jeg har vært borte fra nettleseren i 20 minutt.',
	'wah-nojobfound' => 'Ingen oppgave funnet. Prøver igjen om $1.',
	'wah-notoken-login' => 'Er du innlogget? Om ikke, vennligst logg inn først.',
	'wah-apioff' => 'Wiki@Home-API-en ser ut til å være av. Vennligst kontakt en wikiadministrator.',
	'wah-doing-job' => 'Oppgave: <i>$1</i> på: <i>$2</i>',
	'wah-downloading' => 'Nedlasting av filen er <i>$1%</i> ferdig',
	'wah-encoding' => 'Koding av filen er <i>$1%</i> ferdig',
	'wah-encoding-fail' => 'Koding mislyktes. Oppdater denne siden eller prøv igjen senere.',
	'wah-uploading' => 'Opplasting av filen <i>$1</i> er ferdig',
	'wah-uploadfail' => 'Opplastingen feilet',
	'wah-doneuploading' => 'Opplasting ferdig. Takk for bidraget ditt.',
	'wah-needs-firefogg' => 'For å delta i Wiki@Home må du innstallere <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Det har oppstått en feil med API-en. Vennligst prøv igjen senere.',
);

/** Dutch (Nederlands)
 * @author Reedy
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'wah-desc' => 'Maakt het mogelijk videotranscoderingwerk te distribueren via firefogg',
	'wah-user-desc' => 'Wiki@Home maakt het voor gemeenschapsleden mogelijk computertijd te doneren om zo mee te helpen aan het uitvoeren van rekenintensieve taken',
	'wah-short-audio' => '$1-geluidsbestand, $2',
	'wah-short-video' => '$1-videobestand, $2',
	'wah-short-general' => '$1-mediabestand, $2',
	'wah-long-audio' => '$1-geluidsbestand, lengte $2, $3',
	'wah-long-video' => '$1-videobestand, lengte $2, $4×$5 pixels, $3',
	'wah-long-multiplexed' => 'gemultiplexed geluids/videobestand, $1, lengte $2, $4×$5 pixels, $3 totaal',
	'wah-long-general' => 'mediabestand, lengte $2, $3',
	'wah-long-error' => 'ffmpeg kon dit bestand niet lezen: $1',
	'wah-transcode-working' => 'Deze video wordt verwerkt.
Probeer het later nog eens.',
	'wah-transcode-helpout' => 'U kunt helpen dit bestand te transcoderen door naar [[Special:WikiAtHome|Wiki@Home]] te gaan',
	'wah-transcode-fail' => 'Het transcoderen van dit bestand is mislukt.',
	'wah-javascript-off' => 'JavaScript moet ingeschakeld zijn om deel te nemen aan Wiki@Home',
	'wah-loading' => 'Wiki@Home-interface aan het laden ...',
	'wah-menu-jobs' => 'Taken',
	'wah-menu-stats' => 'Statistieken',
	'wah-menu-pref' => 'Voorkeuren',
	'wah-lookingforjob' => 'Bezig met zoeken naar een taak...',
	'wah-start-on-visit' => 'Wiki@Home starten als ik deze site bezoek.',
	'wah-jobs-while-away' => 'Alleen aan taken werken als ik meer dan 20 minuten mijn browser niet gebruik.',
	'wah-nojobfound' => 'Er is geen taak gevonden. Wordt opnieuw geprobeerd over $1.',
	'wah-notoken-login' => 'Bent u wel aangemeld? Zo niet, meld u dan eerst aan.',
	'wah-apioff' => 'De API voor Wiki@Home is uitgeschakeld. Neem contact op met de wikibeheerder.',
	'wah-doing-job' => 'Taak: bezig met <i>$1</i> van <i>$2</i>',
	'wah-downloading' => 'Het te downloaden bestand is <i>$1%</i> compleet',
	'wah-encoding' => 'Het converteren van het bestand is <i>$1%</i> compleet',
	'wah-encoding-fail' => 'Het converteren is mislukt. Herlaad deze pagina of probeer het later nog eens.',
	'wah-uploading' => 'Het uploaden van het bestand is <i>$1%</i> compleet',
	'wah-uploadfail' => 'Het uploaden is mislukt',
	'wah-doneuploading' => 'Het uploaden is afgerond. Dank u voor uw bijdrage.',
	'wah-needs-firefogg' => 'Om deel te nemen aan Wiki@Home moet u <a href="http://firefogg.org">Firefogg</a> installeren.',
	'wah-api-error' => 'Er is een fout opgetreden in de API. Probeer het later nog eens.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 */
$messages['nn'] = array(
	'wah-short-audio' => '$1 lydfil, $2',
	'wah-short-video' => '$1-videofil, $2',
	'wah-short-general' => '$1-mediafil, $2',
	'wah-long-audio' => '$1-lydfil, lengd $2, $3',
	'wah-transcode-working' => 'Videoen vert arbeidd med, ver venleg og prøv igjen seinare',
	'wah-transcode-fail' => 'Kunde ikkje konvertera denne fila.',
	'wah-javascript-off' => 'Du må ha JavaScript aktivert for kunna delta i Wiki@Home',
	'wah-menu-stats' => 'Statistikk',
	'wah-menu-pref' => 'Innstillingar',
	'wah-lookingforjob' => 'Ser etter eit oppdrag ...',
	'wah-start-on-visit' => 'Start opp Wiki@Home kvar gong eg vitjar denne nettstaden.',
	'wah-jobs-while-away' => 'Køyrer berre oppgåver når eg har vore vekke frå nettlesaren i 20 minutt.',
	'wah-nojobfound' => 'Ingen jobb funne. Prøver igjen om $1.',
	'wah-notoken-login' => 'Er du logga inn? Om ikkje, ver venleg og logg inn først.',
	'wah-downloading' => 'Nedlasting av fila <i>$1%</i>  er ferdig',
	'wah-uploadfail' => 'Opplastinga mislukkast',
	'wah-doneuploading' => 'Opplastinga er ferdig. Takk for bidraget ditt.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'wah-desc' => 'Permet de distribuir lo trabalh de transcodatge de vidèo als clients en utilizant firefogg.',
	'wah-user-desc' => "Wiki@Home permet als membres de la comunautat de balhar de cicles processor liures per ajudar d'operacions intensivas en ressorsas.",
	'wah-short-audio' => 'fichièr de son $1, $2',
	'wah-short-video' => 'fichièr vidèo $1, $2',
	'wah-short-general' => 'fichièr mèdia $1, $2',
	'wah-long-audio' => 'fichièr son $1, durada $2, $3',
	'wah-long-video' => 'fichièr vidèo $1, durada $2, $4×$5 pixèls, $3',
	'wah-long-multiplexed' => 'fichièr àudio / vidèo multiplexada $1, durada $2, $4×$5 pixèls, $3 total',
	'wah-long-general' => 'fichièr mèdia, durada $2, $3',
	'wah-long-error' => 'ffmpeg a pas pogut legir aqueste fichièr : $1',
	'wah-transcode-working' => 'Aquesta vidèo es a èsser transcodada, ensajatz tornamai mai tard',
	'wah-transcode-helpout' => 'Podètz ajudar a transcodar aquesta vidèo en visitant [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Aqueste fichièr a pas pogut èsser transcodat.',
	'wah-javascript-off' => 'Vos cal activar JavaScript per participar a Wiki@Home',
	'wah-loading' => "cargament de l'interfàcia Wiki@Home ...",
	'wah-menu-jobs' => 'Prètzfaches',
	'wah-menu-stats' => 'Estatisticas',
	'wah-menu-pref' => 'Preferéncias',
	'wah-lookingforjob' => 'Recèrca de prètzfach ...',
	'wah-start-on-visit' => 'Aviar Wiki@Home a cada còp que visiti aqueste site.',
	'wah-jobs-while-away' => 'Aviar un prètzfach solament quand me soi pas servit de mon navigador pendent 20 minutas.',
	'wah-nojobfound' => 'Cap de prètzfach pas trobat. Tornatz ensajar en $1.',
	'wah-notoken-login' => "Sètz connectat ? S'es pas lo cas, començatz per vos connectar.",
	'wah-apioff' => 'Sembla que l’API de Wiki@Home fonciona pas. Contactatz l’administrator wiki.',
	'wah-doing-job' => 'Prètzfach : <i>$1</i> sus : <i>$2</i>',
	'wah-downloading' => 'Telecargament del fichièr <i>$1%</i> acabat',
	'wah-encoding' => 'Encodatge del fichièr <i>$1%</i> acabat',
	'wah-encoding-fail' => 'L’encodatge a fracassat. Recargatz aquesta pagina o tornatz ensajar pus tard.',
	'wah-uploading' => 'Telecargament del fichièr <i>$1</i> acabat.',
	'wah-uploadfail' => 'Lo telecargament a fracassat',
	'wah-doneuploading' => 'Telecargament acabat. Mercés per vòstra contribucion.',
	'wah-needs-firefogg' => 'Per contribuir a Wiki@Home vos cal installar <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'I a agut una error amb l’API. Tornatz ensajar pus tard.',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Aalam
 */
$messages['pa'] = array(
	'wah-menu-pref' => 'ਮੇਰੀ ਪਸੰਦ',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'wah-desc' => 'Włącza rozsyłanie zadań przekodowywania wideo do klientów za pomocą firefogg',
	'wah-user-desc' => 'Wiki@Home umożliwia członkom społeczności na dzielenie się wolnymi cyklami procesora, aby pomóc w operacjach intensywnie wykorzystujących zasoby',
	'wah-short-audio' => 'Plik dźwiękowy $1, $2',
	'wah-short-video' => 'Plik wideo $1, $2',
	'wah-short-general' => 'Plik multimedialny $1, $2',
	'wah-long-audio' => 'plik dźwiękowy $1, długość $2, $3',
	'wah-long-video' => 'plik wideo $1, długość $2, $4×$5 pikseli, $3',
	'wah-long-multiplexed' => 'multipleksowany plik audio i wideo, $1, długość $2, $4×$5 pikseli, w sumie $3',
	'wah-long-general' => 'plik multimedialny, długość $2, $3',
	'wah-long-error' => 'ffmpeg nie mógł odczytać pliku – $1',
	'wah-transcode-working' => 'Ten plik wideo jest przetwarzany, spróbuj ponownie później',
	'wah-transcode-helpout' => 'Możesz pomóc w przekodowywaniu wideo, odwiedzając stronę [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Nie udało się przekodować tego pliku.',
	'wah-javascript-off' => 'Musisz mieć włączony JavaScript, aby brać udział w Wiki@Home',
	'wah-loading' => 'ładowanie interfejsu Wiki@Home ...',
	'wah-menu-jobs' => 'Zadania',
	'wah-menu-stats' => 'Statystyki',
	'wah-menu-pref' => 'Preferencje',
	'wah-lookingforjob' => 'Szukam zadania...',
	'wah-start-on-visit' => 'Uruchom Wiki@Home za każdym razem gdy odwiedzam tę witrynę.',
	'wah-jobs-while-away' => 'Uruchamiaj zadania gdy nie korzystam z przeglądarki przez 20 minut.',
	'wah-nojobfound' => 'Nie znaleziono zadań. Ponowienie próby za $1.',
	'wah-notoken-login' => 'Czy jesteś zalogowany? Jeśli nie, zrób to najpierw.',
	'wah-apioff' => 'Wiki@Home wydaje się być wyłączona. Skontaktuj się z administratorem.',
	'wah-doing-job' => 'Zadanie <i>$1</i> – <i>$2</i>',
	'wah-downloading' => 'Pobierano <i>$1&nbsp;%</i> pliku.',
	'wah-encoding' => 'Zakodowano <i>$1&nbsp;%</i> pliku',
	'wah-encoding-fail' => 'Kodowanie nie powiodło się. Odśwież stronę lub spróbuj ponownie później.',
	'wah-uploading' => 'Przesłano <i>$1&nbsp;%</i> pliku',
	'wah-uploadfail' => 'Przesyłanie nie powiodło się',
	'wah-doneuploading' => 'Przesyłanie zakończone. Dziękujemy za pomoc.',
	'wah-needs-firefogg' => 'Uczestnictwo w Wiki@Home wymaga zainstalowania <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Wystąpił błąd API. Spróbuj ponownie później.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'wah-desc' => "A abìlita dij job ëd distribussion ëd video transcoding a client ch'a dòvro Firefogg",
	'wah-user-desc' => 'Wiki@Home a përmëtt a member ëd la comunità ëd doné dla potensa CPU për giuté con arzorse dle operassion intensive',
	'wah-short-audio' => '$1 file ëd son, $2',
	'wah-short-video' => '$1 file ëd video, $2',
	'wah-short-general' => '$1 file multimoien, $2',
	'wah-long-audio' => '$1 file ëd son, lunghëssa $2, $3',
	'wah-long-video' => '$1 file ëd video, lunghëssa $2, $4x$5 pixel, $3',
	'wah-long-multiplexed' => 'file audio/video multiplexà, $1, lunghëssa $2, $4×$5 pixel, $3 an tut',
	'wah-long-general' => 'file multimoien, lunghëssa $2, $3',
	'wah-long-error' => 'ffmpeg a peul pa lese sto file-sì: $1',
	'wah-transcode-working' => "Sto video-sì a l'é stàit tratà, për piasì preuva pì tard",
	'wah-transcode-helpout' => 'It peule giuté a trascodifiché sto video-sì an visitand [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => "Sto file-sì a l'é pa podusse trascodifiché.",
	'wah-javascript-off' => 'It deuve avèj JavaScript abilità për partessipé an Wiki@Home',
	'wah-loading' => "carié l'antërfassa ëd Wiki@Home ...",
	'wah-menu-jobs' => 'Travaj',
	'wah-menu-stats' => 'Statìstiche',
	'wah-menu-pref' => 'Mè gust',
	'wah-lookingforjob' => 'An sërcand un travaj ...',
	'wah-start-on-visit' => "Fà parte Wiki@Home minca vira ch'i vìsito sto sit-sì.",
	'wah-jobs-while-away' => 'Fà parte ij travaj mach quand che i son ëstàit lontan da mè navigador për 20 minute.',
	'wah-nojobfound' => 'Pa gnun travaj trovà. As provrà torna an $1.',
	'wah-notoken-login' => 'Ses-to intrà? Se nò, për piasì, prima intra.',
	'wah-apioff' => "L'API Wiki@Home a smija ch'a sia giù. Për piasì contata n'aministrator ëd la wiki.",
	'wah-doing-job' => 'Travaj: <i>$1</i> dzora a: <i>$2</i>',
	'wah-downloading' => "Dëscaria dl'archivi <i>$1%</i> completa",
	'wah-encoding' => "Codìfica dl'archivi <i>$1%</i> completa",
	'wah-encoding-fail' => 'Codìfica falìa. Për piasì caria torna sta pàgina-sì o preuva torna pì tard.',
	'wah-uploading' => "Caria dl'archivi <i>$1</i> completa",
	'wah-uploadfail' => 'Caria falìa',
	'wah-doneuploading' => 'Caria finìa. Mersì për toa contribussion.',
	'wah-needs-firefogg' => 'Për partessipé a Wiki@Home it deve anstalé <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => "A-i é staje n'eror con l'API. Për piasì preuva torna pì tard.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wah-short-audio' => '$1 غږيزه دوتنه، $2',
	'wah-short-video' => '$1 ويډيويي دوتنې، $2',
	'wah-short-general' => '$1 رسنيزه دوتنه، $2',
	'wah-long-audio' => '$1 غږيزه دوتنه، اوږدوالی $2، $3',
	'wah-long-video' => '$1 ويډيويي دوتنه، اوږدوالی $2، $4×$5 پېکسل، $3',
	'wah-menu-jobs' => 'دندې',
	'wah-menu-pref' => 'غوره توبونه',
	'wah-lookingforjob' => 'د يو کار په لټه کې ياست ...',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 */
$messages['pt'] = array(
	'wah-desc' => 'Possibilita a distribuição de tarefas de transcodificação de vídeo para clientes que utilizam o Firefogg',
	'wah-user-desc' => 'Wiki@Home permite que membros da comunidade doem os seus ciclos de CPU em excesso para ajudar em operações com uso intensivo de recursos',
	'wah-short-audio' => 'Ficheiro de áudio $1, $2',
	'wah-short-video' => 'Ficheiro de vídeo $1, $2',
	'wah-short-general' => 'Ficheiro multimédia $1, $2',
	'wah-long-audio' => 'ficheiro de áudio $1, duração $2, $3',
	'wah-long-video' => 'ficheiro de vídeo $1, duração $2, $4×$5 pixels, $3',
	'wah-long-multiplexed' => 'ficheiro de áudio/vídeo multiplex, $1, duração $2, $4×$5 pixels, total $3',
	'wah-long-general' => 'ficheiro multimédia, duração $2, $3',
	'wah-long-error' => 'ffmpeg não conseguiu ler este ficheiro: $1',
	'wah-transcode-working' => 'Este vídeo está a ser processado. Por favor, tente mais tarde',
	'wah-transcode-helpout' => 'Pode ajudar a transcodificar este vídeo visitando [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Falha na transcodificação deste ficheiro.',
	'wah-javascript-off' => 'Precisa de possibilitar o uso de JavaScript para participar no Wiki@Home',
	'wah-loading' => 'carregando a interface do Wiki@Home ...',
	'wah-menu-jobs' => 'Tarefas',
	'wah-menu-stats' => 'Estatísticas',
	'wah-menu-pref' => 'Preferências',
	'wah-lookingforjob' => 'Procurando uma tarefa ...',
	'wah-start-on-visit' => 'Iniciar o Wiki@Home sempre que eu visitar este site.',
	'wah-jobs-while-away' => 'Executar tarefas só quando eu me ausentar do browser por mais de 20 minutos.',
	'wah-nojobfound' => 'Não foram encontradas tarefas. Nova tentativa em $1.',
	'wah-notoken-login' => 'Está autenticado? Se não, por favor, entre e autentique-se.',
	'wah-apioff' => 'A API do Wiki@Home parece estar desligada. Por favor, contacte o administrador da wiki.',
	'wah-doing-job' => 'Tarefa: <i>$1</i> em: <i>$2</i>',
	'wah-downloading' => 'Descarregamento do ficheiro <i>$1%</i> terminado',
	'wah-encoding' => 'Codificação do ficheiro <i>$1%</i> terminada',
	'wah-encoding-fail' => 'A codificação falhou. Por favor, refresque esta página ou tente novamente mais tarde.',
	'wah-uploading' => 'Carregamento do ficheiro <i>$1</i> terminado',
	'wah-uploadfail' => 'Carregamento do ficheiro falhou',
	'wah-doneuploading' => 'Carregamento do ficheiro terminou. Obrigado pela sua contribuição.',
	'wah-needs-firefogg' => 'Para participar no Wiki@Home precisa de instalar o <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Ocorreu um erro na API. Por favor, tente novamente mais tarde.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'wah-desc' => 'Permite a distribuição de tarefas de transcodificação para clientes utilizando firefogg',
	'wah-user-desc' => 'Wiki@Home permite que membros da comunidade doem ciclos de cpu ociosos para ajudar em operações com uso intensivo de recursos.',
	'wah-short-audio' => 'Arquivo de áudio $1, $2',
	'wah-short-video' => 'Arquivo de vídeo $1, $2',
	'wah-short-general' => 'Arquivo multimídia $1, $2',
	'wah-long-audio' => 'Arquivo de Áudio $1, $2 de duração, $3',
	'wah-long-video' => 'Arquivo de vídeo $1, $2 de duração, $4×$5 pixels, $3',
	'wah-long-multiplexed' => 'Arquivo de áudio/vídeo multifacetado, $1, $2 de duração, $4×$5 pixels, $3 no todo',
	'wah-long-general' => 'Arquivo multimídia, $2 de duração, $3',
	'wah-long-error' => 'ffmpeg não pode ler este arquivo: $1',
	'wah-transcode-working' => 'Este vídeo está sendo processado, por favor tente novamente mais tarde',
	'wah-transcode-helpout' => 'Você pode ajudar a transcodificar este vídeo visitando [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Falha na transcodificação do arquivo',
	'wah-javascript-off' => 'Você precisa ter habilitado JavaScript para participar de Wiki@Home',
	'wah-loading' => 'carregando interface Wiki@Home ...',
	'wah-menu-jobs' => 'Tarefas',
	'wah-menu-stats' => 'Estatísticas',
	'wah-menu-pref' => 'Preferências',
	'wah-lookingforjob' => 'Procurando uma tarefa ...',
	'wah-start-on-visit' => 'Iniciar o Wiki@Home sempre que eu visitar este site.',
	'wah-jobs-while-away' => 'Executar tarefas só quando eu me ausentar do navegador por mais de 20 minutos.',
	'wah-nojobfound' => 'Não foram encontradas tarefas. Nova tentativa em $1.',
	'wah-notoken-login' => 'Está autenticado? Se não, por favor, entre e autentique-se.',
	'wah-apioff' => 'A API do Wiki@Home parece estar desligada. Por favor, contate o administrador da wiki.',
	'wah-doing-job' => 'Tarefa: <i>$1</i> em: <i>$2</i>',
	'wah-downloading' => 'Descarregamento do arquivo <i>$1%</i> terminado',
	'wah-encoding' => 'Codificação do arquivo <i>$1%</i> terminada',
	'wah-encoding-fail' => 'A codificação falhou. Por favor, recarregue esta página ou tente novamente mais tarde.',
	'wah-uploading' => 'Carregamento do arquivo <i>$1</i> terminado',
	'wah-uploadfail' => 'O carregamento do arquivo falhou',
	'wah-doneuploading' => 'Carregamento completado. Obrigado pela sua contribuição.',
	'wah-needs-firefogg' => 'Para participar no Wiki@Home você precisa instalar o <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Ocorreu um erro na API. Por favor, tente novamente mais tarde.',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 */
$messages['ro'] = array(
	'wah-short-audio' => 'Fișier audio $1, $2',
	'wah-short-video' => 'Fișier video $1, $2',
	'wah-short-general' => 'Fișier media $1, $2',
	'wah-long-audio' => 'fișier audio $1, lungime $2, $3',
	'wah-long-video' => 'fișier video $1, lungime $2, $4×$5 pixeli, $3',
	'wah-long-general' => 'fișier media, lungime $2, $3',
	'wah-transcode-working' => 'Acest video este procesat, încercați mai târziu',
	'wah-menu-jobs' => 'Job-uri',
	'wah-menu-stats' => 'Statistici',
	'wah-menu-pref' => 'Preferințe',
	'wah-notoken-login' => 'Sunteți autentificat? Dacă nu, vă rugăm să vă autentificați înainte.',
	'wah-downloading' => 'Descărcarea fișierului <i>$1%</i> terminată',
	'wah-uploadfail' => 'Încărcarea eșuată',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'wah-desc' => 'Позволяет использовать распределённое перекодирование видео, с помощью firefogg.',
	'wah-user-desc' => 'Wiki@Home позволяет членам сообщества пожертвовать излишней мощностью процессоров, помогая с ресурсоёмкими операциями',
	'wah-short-audio' => '$1 звуковой файл, $2',
	'wah-short-video' => '$1 видео-файл, $2',
	'wah-short-general' => '$1 медиа-файл, $2',
	'wah-long-audio' => '$1 звуковой файл, продолжительность $2, $3',
	'wah-long-video' => '$1 видео-файл, продолжительность $2, $4×$5 {{PLURAL:$5|пиксель|пикселя|пикселей}}, $3',
	'wah-long-multiplexed' => 'мультиплексированный аудио/видео-файл, $1, продолжительность $2, $4×$5 {{PLURAL:$5|пиксель|пикселя|пикселей}}, всего $3',
	'wah-long-general' => 'медиа-файл, продолжительность $2, $3',
	'wah-long-error' => 'ffmpeg не может прочитать этот файл: $1',
	'wah-transcode-working' => 'Это видео сейчас перекодируется, пожалуйста, обратитесь позднее',
	'wah-transcode-helpout' => 'Вы можете помочь перекодировать это видео, посетите [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Не удалось перекодировать этот файл.',
	'wah-javascript-off' => 'У вас должен быть включён JavaScript, для возможности участия в Wiki@Home',
	'wah-loading' => 'Загрузка интерфейса Wiki@Home ...',
	'wah-menu-jobs' => 'Задания',
	'wah-menu-stats' => 'Статистика',
	'wah-menu-pref' => 'Настройка',
	'wah-lookingforjob' => 'Поиск задания …',
	'wah-start-on-visit' => 'Запускать Wiki@Home всегда, когда я посещаю этот сайт.',
	'wah-jobs-while-away' => 'Запускать задания только когда я не пользовался браузером более 20 минут.',
	'wah-nojobfound' => 'Задание не найдено. Повтор будет произведён $1.',
	'wah-notoken-login' => 'Вы представились системе? Если нет, то пожалуйста, сначала представьтесь.',
	'wah-apioff' => 'Судя по всему, Wiki@Home API выключен. Пожалуйста, свяжитесь с администратором вики.',
	'wah-doing-job' => 'Задание: <i>$1</i> — <i>$2</i>',
	'wah-downloading' => 'Загрузка файла выполнена на <i>$1 %</i>',
	'wah-encoding' => 'Кодирование файла выполнено на <i>$1 %</i>',
	'wah-encoding-fail' => 'Ошибка кодирования. Пожалуйста, перезагрузите страницу или повторите попытку позже.',
	'wah-uploading' => 'Закачивание файла выполнена на <i>$1</i>',
	'wah-uploadfail' => 'Ошибка закачивания',
	'wah-doneuploading' => 'Закачивание завершено. Спасибо за ваше участие.',
	'wah-needs-firefogg' => 'Для участия в проекте Wiki@Home вам нужно установить <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Обнаружена ошибка при работе с API. Пожалуйста, повторите попытку позже.',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'wah-desc' => 'වීඩියෝ පරාකේතනය කිරීමේ කාර්යය Firefogg භාවිතා කරන සේවාදායකයන්ට බෙදා හැරීමට හැකියාව ලබා දෙයි',
	'wah-short-audio' => '$1 නාද ගොනුව, $2',
	'wah-short-video' => '$1 වීඩියෝ ගොනුව, $2',
	'wah-short-general' => '$1 මාධ්‍ය ගොනුව, $2',
	'wah-long-audio' => '$1නාද ගොනුව, දිග $2, $3',
	'wah-long-video' => '$1l වීඩියෝ ගොනුව,දිග $2, $4×$5 පික්සල්, $3',
	'wah-long-multiplexed' => 'බහු පික්සල් සහිත ශ්‍රව්‍ය/වීඩියෝ ගොනුව, $1, දිග $2, $4×$5 පික්සල්, $3 සමස්ථය',
	'wah-long-general' => 'මාධ්‍ය ගොනුව, දිග $2, $3',
	'wah-long-error' => 'ffmpegට මෙම ගොනුව කියවීමට නොහැකි විය: $1',
	'wah-transcode-working' => 'මෙම වීඩියෝව සකසනු ලැබෙමින් පවතී,කරුණාකර පසුව උත්සාහ කරන්න',
	'wah-transcode-helpout' => 'ඔබට [[Special:WikiAtHome|Wiki@Home]] වෙත ගමන් කිරීමෙන් මෙම වීඩියෝව පරාකේතනය කිරීමට උදව්විය හැක.',
	'wah-transcode-fail' => 'මෙම ගොනුව පරාකේතනය කිරීම අසාර්ථක විය.',
	'wah-javascript-off' => 'Wiki@Home හි සහභාගිවීම සඳහා ඔබ JavaScript සක්‍රීය කර තිබිය යුතුය',
	'wah-loading' => ' Wiki@Home අතුරු මුහුණත ප්‍රවේශනය වෙමින් පවතී ...',
	'wah-menu-jobs' => 'කාර්යයන්',
	'wah-menu-stats' => 'ගණනයන්',
	'wah-menu-pref' => 'වරණයන්',
	'wah-lookingforjob' => 'කාර්යයක් සඳහා බලා සිටිමින් සිටියි...',
	'wah-start-on-visit' => 'මා මෙම අඩවියට පැමිණෙන ඕනෑම වේලාවක Wiki@Home අරඹන්න.',
	'wah-jobs-while-away' => 'මා මාගේ බ්‍රව්සරයෙන් මිනිත්තු 20ක් ඉවත්ව සිටිය විට පමණක් කාර්යයන් ධාවනය කරන්න.',
	'wah-nojobfound' => 'කිසිදු කාර්යයක් හමු නොවුණි. $1 දී යළි උත්සාහ කරනු ඇත.',
	'wah-notoken-login' => 'ඔබ ප්‍රවිෂ්ට වී ඇත්ද?නැතිනම්,මුලින්ම ප්‍රව්ෂ්ට වන්න.',
	'wah-apioff' => 'Wiki@Home API ක්‍රියා විරහිත කර ඇති බවක් පෙන්නුම් කරයි.කරුණාකර විකි පරිපාලක හා සම්බන්ධ වෙන්න.',
	'wah-doing-job' => 'කාර්යය: <i>$1</i> මත: <i>$2</i>',
	'wah-downloading' => '<i>$1%</i> ගොනුව භාගතකිරීම සම්පූර්ණයි',
	'wah-encoding' => '<i>$1%</i> ගොනුව කේතනය කිරීම සම්පූර්ණයි',
	'wah-encoding-fail' => 'කේතනය කිරීම අසාර්ථකයි.මෙම පිටුව යළි ප්‍රවේශනය කිරීම හෝ නැවත උත්සාහ කිරීම කරන්න.',
	'wah-uploading' => '<i>$1</i> ගොනුව උඩුගත කිරීම සම්පූර්ණයි',
	'wah-uploadfail' => 'උඩුගත කිරීම අසාර්ථකයි',
	'wah-doneuploading' => 'උඩුගත කිරීම ස්ම්පූර්ණයි.ඔබේ සහයෝගයට ස්තුතියි.',
	'wah-needs-firefogg' => 'Wiki@Homeහි සහභාගි වීම සඳහා ඔබ <a href="http://firefogg.org">Firefogg</a> ස්ථාපනය කළ යුතුය.',
	'wah-api-error' => 'API සමඟ දෝෂයක් තිබේ.කරුණාකර පසුව උත්සාහ කරන්න.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'wah-desc' => 'Umožňuje šírenie úloh prekódovania videa klientom pomocou firefogg',
	'wah-user-desc' => 'Wiki@Home umožnuje členom komunity venovať nevyužitý výpočtový čas procesora na pomoc pri operáciách náročných na zdroje',
	'wah-short-audio' => '$1 zvukový súbor, $2',
	'wah-short-video' => '$1 videosúbor, $2',
	'wah-short-general' => '$1 multimediálny súbor, $2',
	'wah-long-audio' => '$1 zvukový súbor, dĺžka $2, $3',
	'wah-long-video' => '$1 videosúbor, dĺžka $2, $4×$5 pixlov, $3',
	'wah-long-multiplexed' => 'multiplexovaný zvukový/videosúbor, $1, dĺžka $2, $4×$5 pixlov, $3 celkom',
	'wah-long-general' => 'multimediálny súbor, dĺžka $2, $3',
	'wah-long-error' => 'ffmpeg nedokázal načítať nasledovný súbor: $1',
	'wah-transcode-working' => 'Toto video sa spracováva, skúste to prosím neskôr',
	'wah-transcode-helpout' => 'Môžete pomôcť s prekódovaním tohto videa po navštívení [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Tento súbor sa nepodarilo prekódovať.',
	'wah-javascript-off' => 'Aby ste sa mohli zúčastniť Wiki@Home musíte mať zapnutý JavaScript',
	'wah-loading' => 'načítava sa rozhranie Wiki@Home ...',
	'wah-menu-jobs' => 'Úlohy',
	'wah-menu-stats' => 'Štatistiky',
	'wah-menu-pref' => 'Nastavenie',
	'wah-lookingforjob' => 'Hľadá sa úloha...',
	'wah-start-on-visit' => 'Spustiť Wiki@Home vždy, keď navštívim túto stránku.',
	'wah-jobs-while-away' => 'Spúšťať úlohy iba keď som prehliadač nepoužíval viac ako 20 minút.',
	'wah-nojobfound' => 'Nebola nájdená žiadna úloha. Opätovný pokus o $1.',
	'wah-notoken-login' => 'Ste prihlásený? Ak nie, najprv sa prihláste.',
	'wah-apioff' => 'Zdá sa, že API Wiki@Home nebeží. Prosím, kontaktujte správcu lokality.',
	'wah-doing-job' => 'Úloha: <i>$1</i>: <i>$2</i>',
	'wah-downloading' => 'Sťahovanie súboru <i>$1%</i> dokončené',
	'wah-encoding' => 'Kódovanie súboru <i>$1%</i> dokončené',
	'wah-encoding-fail' => 'Kódovanie sa nepodarilo. Prosím, znova načítajte túto stránku alebo to skúste znova neskôr.',
	'wah-uploading' => 'Nahrávanie súboru <i>$1</i> dokončené',
	'wah-uploadfail' => 'Nahrávanie sa nepodarilo',
	'wah-doneuploading' => 'Nahrávanie dokončené. Ďakujeme vám za príspevok.',
	'wah-needs-firefogg' => 'Aby ste sa mohli zúčastniť Wiki@Home, musíte si nainštalovať <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Nastala chyba týkajúca sa API. Skúste to prosím znova neskôr.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'wah-short-audio' => '$1 звучни фајл, $2',
	'wah-short-video' => '$1 видео-снимак, $2',
	'wah-short-general' => '$1 медијска датотека, $2',
	'wah-long-audio' => '$1 звучни фајл, трајање $2, $3',
	'wah-long-video' => '$1 видео-снимак, трајање $2, $4 × $5 пиксела, $3',
	'wah-long-multiplexed' => 'мултиплексирани аудио/видео снимак, $1, трајање $2, $4 × $5 пиксела, $3',
	'wah-long-general' => 'медијска датотека, трајање $2, $3',
	'wah-long-error' => 'ffmpeg није могао да прочита овај фајл: $1',
	'wah-transcode-working' => 'Видео-снимак се обрађује. Покушајте касније.',
	'wah-javascript-off' => 'Морате омогућити JavaScript, да бисте учествовали у Wiki@Home',
	'wah-loading' => 'учитавање Wiki@Home интерфејса ...',
	'wah-menu-pref' => 'Поставке',
	'wah-uploading' => 'Слање фајла <i>$1</i> је комплетирано',
	'wah-uploadfail' => 'Слање фајла неуспело',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'wah-short-audio' => '$1 zvučni fajl, $2',
	'wah-short-video' => '$1 video-snimak, $2',
	'wah-short-general' => '$1 medijska datoteka, $2',
	'wah-long-audio' => '$1 zvučni fajl, trajanje $2, $3',
	'wah-long-video' => '$1 video-snimak, trajanje $2, $4 × $5 piksela, $3',
	'wah-long-multiplexed' => 'multipleksirani audio/video snimak, $1, trajanje $2, $4 × $5 piksela, $3',
	'wah-long-general' => 'medijska datoteka, trajanje $2, $3',
	'wah-long-error' => 'ffmpeg nije mogao da pročita ovaj fajl: $1',
	'wah-transcode-working' => 'Video-snimak se obrađuje. Pokušajte kasnije.',
	'wah-javascript-off' => 'Morate omogućiti JavaScript, da biste učestvovali u Wiki@Home',
	'wah-loading' => 'učitavanje Wiki@Home interfejsa ...',
	'wah-menu-pref' => 'Postavke',
	'wah-uploading' => 'Slanje fajla <i>$1</i> je kompletirano',
	'wah-uploadfail' => 'Slanje fajla neuspelo',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Ozp
 * @author Per
 */
$messages['sv'] = array(
	'wah-desc' => 'Möjliggör distribution av videoomkodningsarbeten till klienter som använder Firefogg',
	'wah-user-desc' => 'Wiki@Home möjliggör för communitymedlemmar att donera oanvänd processortid för att hjälpa till med resurskrävande uppgifter',
	'wah-short-audio' => '$1-ljudfil, $2',
	'wah-short-video' => '$1-videofil, $2',
	'wah-short-general' => '$1-mediafil, $2',
	'wah-long-audio' => '$1-ljudfil, längd $2, $3',
	'wah-long-video' => '$1-videofil, längd $2, $4×$5 pixlar, $3',
	'wah-long-multiplexed' => 'multiplexad ljud-/video-fil, $1, längd $2, $4×$5 pixlar, $3 totalt',
	'wah-long-general' => 'mediafil, längd $2, $3',
	'wah-long-error' => 'ffmpeg kunde inte läsa filen: $1',
	'wah-transcode-working' => 'Videon bearbetas just ju, vänligen försök igen senare',
	'wah-transcode-helpout' => 'Du kan hjälpa till att konvertera den här videon genom att besöka [[Special:WikiAtHome|Wiki@Home]]',
	'wah-transcode-fail' => 'Kunde inte konvertera den här filen.',
	'wah-javascript-off' => 'Du måste ha JavaScript aktiverat för att delta i Wiki@Home',
	'wah-loading' => 'laddar gränssnittet för Wiki@Home ...',
	'wah-menu-jobs' => 'Uppgifter',
	'wah-menu-stats' => 'Statistik',
	'wah-menu-pref' => 'Inställningar',
	'wah-lookingforjob' => 'Letar efter en uppgift...',
	'wah-start-on-visit' => 'Starta Wiki@Home varje gång jag besöker denna sajt.',
	'wah-jobs-while-away' => 'Kör bara uppgifter när jag har varit borta från min webbläsare i 20 minuter.',
	'wah-nojobfound' => 'Inga uppgifter hittades. Provar igen om $1.',
	'wah-notoken-login' => 'Har du loggat in? Om inte, vänligen logga in först.',
	'wah-apioff' => 'Wiki@Home API-et ser ut att vara avstängt. Vänligen kontakta wikiadministratören.',
	'wah-doing-job' => 'Uppgift: <i>$1</i> på: <i>$2</i>',
	'wah-downloading' => 'Laddar ner fil <i>$1%</i> färdigt',
	'wah-encoding' => 'Encodar fil <i>$1%</i> färdigt',
	'wah-encoding-fail' => 'Encodingen misslyckades. Vänligen ladda om denna sida eller försök igen lite senare.',
	'wah-uploading' => 'Uppladdning av fil <i>$1</i> är komplett',
	'wah-uploadfail' => 'Uppladdningen falerade',
	'wah-doneuploading' => 'Uppladdningen komplett. Tack för ditt bidrag.',
	'wah-needs-firefogg' => 'För att delta i Wiki@Home måste du installera <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Det är ett fel i API:et. Försök igen senare.',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'wah-short-audio' => '$1 శ్రవణ ఫైలు, $2',
	'wah-short-video' => '$1 దృశ్యక ఫైలు, $2',
	'wah-short-general' => '$1 మాధ్యమ ఫైలు, $2',
	'wah-long-audio' => '$1 శ్రవణ ఫైలు, నిడివి $2, $3',
	'wah-long-video' => '$1 దృశ్యక ఫైలు, నిడివి $2, $4×$5 పిక్సెళ్ళు, $3',
	'wah-long-general' => 'మాధ్యమ ఫైలు, నిడివి $2, $3',
	'wah-javascript-off' => 'Wiki@Homeలో పాల్గొనడానికి మీకు జావాస్క్రిప్టుని చేతనం చేసి ఉండాలి',
	'wah-menu-jobs' => 'పనులు',
	'wah-menu-stats' => 'గణాంకాలు',
	'wah-menu-pref' => 'అభిరుచులు',
	'wah-lookingforjob' => 'పనుల కోసం చూస్తున్నాం ...',
	'wah-start-on-visit' => 'నేనీ సైటుకు ఎప్పుడొచ్చినా Wiki@Home వద్ద మొదలుపెట్టు.',
	'wah-notoken-login' => 'మీరు ప్రవేశించి ఉన్నారా? లేకపోతే, ముందు ప్రవేశించండి.',
	'wah-downloading' => '<i>$1%</i> ఫైలు దింపుకోలు పూర్తయింది',
	'wah-uploading' => '<i>$1</i> ఫైలు ఎక్కింపు పూర్తయ్యింది',
	'wah-uploadfail' => 'ఎక్కింపు విఫలమైంది',
	'wah-doneuploading' => 'ఎక్కింపు పూర్తయింది. మీ తోడ్పాటుకి ధన్యవాదాలు.',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'wah-menu-pref' => 'Ileri tutmalar',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'wah-desc' => 'Nagpapagana ng pagpapamahagi ng mga pagtatranskodigo ng mga trabahong pangbidyo papunta sa mga kliyente sa pamamagitan ng Firefogg',
	'wah-user-desc' => 'Nagbibigay-daan ang Wiki@Home na makapag-ambag ang mga kasapi ng pamayanan ng nakatabing mga ikot ng cpu upang makatulong sa masusing mga operasyon na pangpinagmulan',
	'wah-short-audio' => '$1 na talaksan ng tunog, $2',
	'wah-short-video' => '$1 talaksa ng bidyo, $2',
	'wah-short-general' => '$1 talaksan ng midya, $2',
	'wah-long-audio' => '$1 talaksan ng tunog, haba $2, $3',
	'wah-long-video' => '$1 talaksan ng bidyo, haba $2, $4×$5 mga piksel, $3',
	'wah-long-multiplexed' => 'audiong multipleks/talaksan ng bidyo, $1, haba $2, $4×$5 mga piksel, $3 ang kabuoan',
	'wah-long-general' => 'talaksan ng midya, haba $2, $3',
	'wah-long-error' => 'hindi mabasa ng ffmpeg ang talaksang ito: $1',
	'wah-transcode-working' => 'Isinasagawa na ang bidyong ito, sumubok na lang ulit mamaya',
	'wah-transcode-helpout' => 'Makakatulong ka sa paglilipat ng kodigo ng bidyong ito sa pamamagitan ng pagdalaw sa [[Special:WikiAtHome|Wiki@Home]].',
	'wah-transcode-fail' => 'Nabigong maglipat ng kodigo ang talaksang ito.',
	'wah-javascript-off' => 'Kailangang mayroon kang JavaScript upang makalahok sa Wiki@Home',
	'wah-loading' => 'ikinakarga ang inter-mukha ng Wiki@Home ...',
	'wah-menu-jobs' => 'Mga gawain',
	'wah-menu-stats' => 'Estadistika',
	'wah-menu-pref' => 'Mga nais',
	'wah-lookingforjob' => 'Naghahanap ng isang gawain ...',
	'wah-start-on-visit' => 'Simulan ang Wiki@Home anumang oras na dadalawin ko ang sityong ito.',
	'wah-jobs-while-away' => 'Patakbuhin lamang ang mga gawain kapag lumayo ako mula sa pambasa-basa ko na may tagal na 20 mga minuto.',
	'wah-nojobfound' => 'Walang natagpuang gawain.  Susubukan uli sa loob ng $1.',
	'wah-notoken-login' => 'Nakalagda ka ba? Kung hindi, lumagda ka muna.',
	'wah-apioff' => 'Tila lumilitaw na hindi buhay ang Wiki@Home API.  Mangyaring makipag-ugnayan sa tagapangasiwa ng wiki.',
	'wah-doing-job' => 'Gawain: <i>$1</i> sa: <i>$2</i>',
	'wah-downloading' => 'Kumpleto na ang pagkakarga ng talaksang <i>$1%</i>',
	'wah-encoding' => 'Kumpleto na ang pagkokodigo ng talaksang <i>$1%</i>',
	'wah-encoding-fail' => 'Nabigo ang pagkokodigo.  Mangyaring muling ikarga ang pahinang ito o subukan ulit mamaya.',
	'wah-uploading' => 'Nakumpleto na ang pagkakarga ng talaksang <i>$1</i>',
	'wah-uploadfail' => 'Nabigo ang paitaas na pagkarga',
	'wah-doneuploading' => 'Kumpleto na ang paitaas na pagkarga.  Salamat sa iyong ambag.',
	'wah-needs-firefogg' => 'Upang makalahok sa Wiki@Home kailangang mong ilagay ang <a href="http://firefogg.org">Firefogg</a>.',
	'wah-api-error' => 'Nagkaroon ng kamalian sa API.  Subukan ulit mamaya.',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'wah-short-audio' => '$1 ses dosyası, $2',
	'wah-short-video' => '$1 video dosyası, $2',
	'wah-short-general' => '$1 ortam dosyası, $2',
	'wah-long-audio' => '$1 ses dosyası, uzunluk $2, $3',
	'wah-menu-jobs' => 'İşler',
	'wah-menu-stats' => 'İstatistikler',
	'wah-menu-pref' => 'Tercihler',
	'wah-uploadfail' => 'Yükleme başarısız oldu',
	'wah-doneuploading' => 'Yükleme tamamlandı. Katkınız için teşekkür ederiz.',
);

/** Ukrainian (Українська)
 * @author Olvin
 */
$messages['uk'] = array(
	'wah-long-video' => '$1-відео, $4х$5, тривалість - $2, бітрейт - $3,',
	'wah-transcode-working' => 'Це відео обробляється, будь ласка, повторіть спробу пізніше',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'wah-short-audio' => '$1 קול טעקע, $2',
	'wah-short-video' => '$1 ווידעא טעקע, $2',
	'wah-short-general' => '$1 מעדיע טעקע, $2',
	'wah-long-audio' => '$1 קול טעקע, לענג $2, $3',
	'wah-long-video' => '$1 ווידעא טעקע, לענג $2, $4×$5 פיקסעלן, $3',
	'wah-menu-pref' => 'פרעפֿערענצן',
	'wah-uploadfail' => 'אַרויפֿלאָדן דורכגעפֿאַלן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author Xiaomingyan
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'wah-desc' => '把视频转码的工作分配予使用Firefogg的用户端',
	'wah-user-desc' => 'Wiki@Home 可使参与者提供剩余的CPU运算能力，协助执行资源密集的作业',
	'wah-short-audio' => '$1声音文件，$2',
	'wah-short-video' => '$1视频文件，$2',
	'wah-short-general' => '$1媒体文件，$2',
	'wah-long-audio' => '（$1声音文件，长度$2，$3）',
	'wah-long-video' => '（$1视频文件，长度$2，$4×$5像素，$3）',
	'wah-long-general' => '（媒体文件，长度$2，$3）',
	'wah-long-error' => '（ffmpeg不能读取这个文件：$1）',
	'wah-transcode-working' => '这个视频正在被处理，请稍后再试',
	'wah-transcode-helpout' => '您可以透过到访 [[Special:WikiAtHome|Wiki@Home]] 协助本视频的转码。',
	'wah-transcode-fail' => '这个文件转码失败',
	'wah-javascript-off' => '你必须启用JavaScript以参与Wiki@Home',
	'wah-loading' => '正在载入Wiki@Home界面……',
	'wah-menu-jobs' => '工作',
	'wah-menu-stats' => '统计',
	'wah-menu-pref' => '系统设置',
	'wah-lookingforjob' => '正在寻找工作...',
	'wah-start-on-visit' => '在每次访问本网站时启动 Wiki@Home。',
	'wah-jobs-while-away' => '只于本人离开浏览器后20分钟方开始执行工作。',
	'wah-nojobfound' => '未有新工作，将于 $1 后再试。',
	'wah-notoken-login' => '您已登入了吗？如果没有，请先登入。',
	'wah-apioff' => 'Wiki@Home API 似乎处于关机状态，请联络该 wiki 的管理员。',
	'wah-downloading' => '已完成下载档案 <i>$1%</i>',
	'wah-encoding' => '已完成档案 <i>$1%</i> 的编码',
	'wah-encoding-fail' => '编码失败，请重新载入本页或稍后再试。',
	'wah-uploading' => '已完成上传档案 <i>$1%</i>',
	'wah-uploadfail' => '上传失败',
	'wah-doneuploading' => '上载完成，谢谢您的贡献。',
	'wah-needs-firefogg' => '您必须安装 <a href="http://firefogg.org">Firefogg</a> 方能参与 Wiki@Home。',
	'wah-api-error' => 'API 出现错误，请稍后再试。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'wah-desc' => '把視頻轉碼的工作分配予使用Firefogg的用戶端',
	'wah-user-desc' => 'Wiki@Home 可使參與者提供剩餘的CPU運算能力，協助執行資源密集的作業',
	'wah-short-audio' => '$1 聲音檔案，$2',
	'wah-short-video' => '$1 視訊檔案，$2',
	'wah-short-general' => '$1 媒體檔案，$2',
	'wah-long-audio' => '（$1 聲音檔案，長度 $2，$3）',
	'wah-long-video' => '（$1 視訊檔案，長度 $2，$4×$5 像素，$3）',
	'wah-long-general' => '（媒體檔案，長度 $2，$3）',
	'wah-long-error' => '（ffmpeg 不能讀取這個檔案：$1）',
	'wah-transcode-working' => '該影片正在處理中，請稍後再試',
	'wah-transcode-helpout' => '您可以透過到訪 [[Special:WikiAtHome|Wiki@Home]] 協助本視頻的轉碼。',
	'wah-transcode-fail' => '這個檔案轉碼失敗',
	'wah-javascript-off' => '你必須啟用 JavaScript 以參與 Wiki@Home',
	'wah-loading' => '正在載入 Wiki@Home 介面...',
	'wah-menu-jobs' => '工作',
	'wah-menu-stats' => '統計',
	'wah-menu-pref' => '偏好設定',
	'wah-lookingforjob' => '正在尋找工作...',
	'wah-start-on-visit' => '在每次訪問本網站時啟動 Wiki@Home。',
	'wah-jobs-while-away' => '只於本人離開瀏覽器後20分鐘方開始執行工作。',
	'wah-nojobfound' => '未有新工作，將於 $1 後再試。',
	'wah-notoken-login' => '您已登入了嗎？如果沒有，請先登入。',
	'wah-apioff' => 'Wiki@Home API 似乎處於關機狀態，請聯絡該 wiki 的管理員。',
	'wah-downloading' => '已完成下載檔案 <i>$1%</i>',
	'wah-encoding' => '已完成檔案 <i>$1%</i> 的編碼',
	'wah-encoding-fail' => '編碼失敗，請重新載入本頁或稍後再試。',
	'wah-uploading' => '已完成上傳檔案 <i>$1%</i>',
	'wah-uploadfail' => '上傳失敗',
	'wah-doneuploading' => '上載完成，謝謝您的貢獻。',
	'wah-needs-firefogg' => '您必須安裝 <a href="http://firefogg.org">Firefogg</a> 方能參與 Wiki@Home。',
	'wah-api-error' => 'API 出現錯誤，請稍後再試。',
);

