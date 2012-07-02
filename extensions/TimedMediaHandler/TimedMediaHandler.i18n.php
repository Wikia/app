<?php
/**
 * Internationalisation file for extension OggPlayer.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'timedmedia-desc'             => 'Handler for audio, video and timed text, with format support for WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio'  => 'Ogg $1 sound file, $2',
	'timedmedia-ogg-short-video'      => 'Ogg $1 video file, $2',
	'timedmedia-ogg-short-general'    => 'Ogg $1 media file, $2',
	'timedmedia-ogg-long-audio'       => 'Ogg $1 sound file, length $2, $3',
	'timedmedia-ogg-long-video'       => 'Ogg $1 video file, length $2, $4 × $5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg multiplexed audio/video file, $1, length $2, $4 × $5 pixels, $3 overall',
	'timedmedia-ogg-long-general'     => 'Ogg media file, length $2, $3',
	'timedmedia-ogg-long-error'       => 'Invalid Ogg file: $1',

	'timedmedia-webm-short-video' => 'WebM $1 video file, $2',
	'timedmedia-webm-long-video' => 'WebM audio/video file, $1, length $2, $4 × $5 pixels, $3 overall',

	'timedmedia-no-player-js' 	  => 'Sorry, your browser either has JavaScript disabled or does not have any supported player.<br />
You can <a href="$1">download the clip</a> or <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">download a player</a> to play the clip in your browser.',

	'timedmedia-more'             => 'More…',
	'timedmedia-dismiss'          => 'Close',
	'timedmedia-download'         => 'Download file',
	'timedmedia-play-media'		  => 'Play media',
	'timedmedia-desc-link'        => 'About this file',
	'timedmedia-oggThumb-version' => 'OggHandler requires oggThumb version $1 or later.',
	'timedmedia-oggThumb-failed'  => 'oggThumb failed to create the thumbnail.',

	// Transcode status table:

	'timedmedia-status-header' 		=> 'Transcode status',
	'timedmedia-update-status'		=> 'Update transcode status',
	'timedmedia-status'				=> 'Status',
	'timedmedia-status-unknown'		=> 'Unknown status',
	'timedmedia-transcodeinfo' 		=> 'Transcode derivative description',
	'timedmedia-actions'			=> 'Actions',
	'timedmedia-direct-link'		=> 'Download derivative',
	'timedmedia-not-ready'			=> 'Not ready',
	'timedmedia-completed-on'		=> 'Completed transcode $1',
	'timedmedia-error-on'			=> 'Error in transcode on $1.',
	'timedmedia-started-transcode'	=> 'Transcode started $1 ago. $2',
	'timedmedia-percent-done'		=> 'About $1% done',
	'timedmedia-in-job-queue'		=> 'Added to Job queue $1 ago',
	'timedmedia-unknown-target-size'=> 'Unknown target size, $1 encoded',
	'timedmedia-days' 				=> '{{PLURAL:$1|day|$1 days}}',
	'timedmedia-hours'				=> '{{PLURAL:$1|hour|$1 hours}}',
	'timedmedia-minutes'			=> '{{PLURAL:$1|minute|$1 minutes}}',
	'timedmedia-seconds'			=> '{{PLURAL:$1|second|$1 seconds}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 and $4',
	'timedmedia-time-3-measurements' => '$1, $2 and $3',
	'timedmedia-time-2-measurements' => '$1 and $2',
	'timedmedia-time-1-measurements' => '$1',
	'timedmedia-show-error'			=> 'Show error',
	'timedmedia-reset'				=> 'Reset transcode',
	'timedmedia-reset-confirm'		=> 'Resetting this transcode will remove any existing file (if present), and it will re-add the transcode to the job queue. It will take some time to re-transcode. <br /><br />
Are you sure you want to proceed?',
	'timedmedia-reset-error'		=> 'Error in resetting transcode job.',

	// Original uploaded asset
	'timedmedia-ogg' => 'Ogg',
	'timedmedia-webm' => 'WebM',
	'timedmedia-source-file' => '$1 source',
	'timedmedia-source-file-desc' => 'Original $1, $2 × $3 ($4)',

	'timedmedia-derivative-160p.ogv' => 'Ogg 160P',
	'timedmedia-derivative-desc-160p.ogv' => 'Low bandwidth Ogg video (160P)',

	'timedmedia-derivative-360p.ogv' => 'Ogg 360P',
	'timedmedia-derivative-desc-360p.ogv' => 'Web streamable Ogg video (360P)',

	'timedmedia-derivative-480p.ogv' => 'Ogg 480P',
	'timedmedia-derivative-desc-480p.ogv' => 'Web streamable Ogg video (480P)',

	'timedmedia-derivative-720p.ogv' => 'Ogg 720P',
	'timedmedia-derivative-desc-720p.ogv' => 'High quality downloadable Ogg video (720P)',

	// WebM profiles:
	'timedmedia-derivative-360p.webm' => 'WebM 360P',
	'timedmedia-derivative-desc-360p.webm' => 'Web streamable WebM (360P)',
	'timedmedia-derivative-480p.webm' => 'WebM 480P',
	'timedmedia-derivative-desc-480p.webm' => 'Web streamable WebM (480P)',
	'timedmedia-derivative-720p.webm' => 'WebM 720P',
	'timedmedia-derivative-desc-720p.webm' => 'High quality downloadable WebM (720P)',

	'timedmedia-subtitle-language' => '$1 ($2) subtitles',
	'timedmedia-subtitle-no-video' => 'There is no video associated with the current subtitle page',
	'timedmedia-subtitle-no-subtitles' => 'There are currently no subtitles in $1 for this video, you can [{{fullurl:{{FULLPAGENAME}}|action=edit}} edit this page] to add them',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author BrokenArrow
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Meno25
 * @author Mormegil
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'timedmedia-desc' => '{{desc}}',
	'timedmedia-ogg-short-general' => 'File details for generic (non-audio, non-video) Ogg files, short version.
Parameters are:
* $1 file type, e.g. Vorbis, Speex
* $2 ?',
	'timedmedia-ogg-long-audio' => 'File details for Ogg files, shown after the filename in the image description page.
Parameters are:
* $1 file codec, f.e. Vorbis, Speex
* $2 file duration, f.e. 1m34s
* $3 file sampling rate, f.e. 97kbps',
	'timedmedia-webm-short-video' => 'Parameters:
* $1 is a slash ("/") separated list of stream types.
* $2 is a time period.',
	'timedmedia-more' => '{{Identical|More...}}',
	'timedmedia-dismiss' => '{{Identical|Close}}',
	'timedmedia-download' => '{{Identical|Download}}',
	'timedmedia-status' => '{{Identical|Status}}',
	'timedmedia-transcodeinfo' => 'A table column header for description of Transcode derivative',
	'timedmedia-actions' => '{{Identical|Action}}',
	'timedmedia-not-ready' => 'State of a given transcode job being not yet complete or not yet ready',
	'timedmedia-completed-on' => 'Completed transcode message
Parameters are:
* $1 The date that the transcode was completed',
	'timedmedia-error-on' => 'Parameters:
* $1 is a timestamp.',
	'timedmedia-started-transcode' => 'Status update for Transcodes
Parameters are:
* $1 Time passed since transcoded started
* $2 Percentage of transcode complete',
	'timedmedia-unknown-target-size' => 'Status update for Transcodes
Parameters are:
* $1 The number of bytes of the file transcoded so far',
	'timedmedia-ogg' => '{{optional}}',
	'timedmedia-webm' => '{{optional}}',
	'timedmedia-source-file' => 'The source file
* $1 file type webm or ogg
{{Identical|Source}}',
	'timedmedia-source-file-desc' => 'Source file description. Paramaters:
* $1 file type ie webm or ogg
* $2 resolution width
* $3 resolution height
* $4 human readable bitrate',
	'timedmedia-derivative-160p.ogv' => '{{optional}}',
	'timedmedia-derivative-360p.ogv' => '{{optional}}',
	'timedmedia-derivative-480p.ogv' => '{{optional}}',
	'timedmedia-derivative-720p.ogv' => '{{optional}}',
	'timedmedia-derivative-360p.webm' => '{{optional}}',
	'timedmedia-derivative-480p.webm' => '{{optional}}',
	'timedmedia-derivative-720p.webm' => '{{optional}}',
	'timedmedia-subtitle-language' => 'Subtitle names
Paramaters are:
* $1 Subtitle language
* $2 Subtitle key',
	'timedmedia-subtitle-no-subtitles' => 'Parameters:
* $1 is a language name.',
);

/** Albaamo innaaɬiilka (Albaamo innaaɬiilka)
 * @author Ulohnanne
 */
$messages['akz'] = array(
	'timedmedia-more' => 'Maatàasasi...',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'timedmedia-desc' => "Hanteer Ogg Theora- en Vorbis-lêers met 'n JavaScript-mediaspeler",
	'timedmedia-ogg-short-audio' => 'Ogg $1 klanklêer, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 video lêer, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 medialêer, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 klanklêer, lengte $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videolêer, lengte $2, $4×$5 pixels, $3',
	'timedmedia-ogg-long-general' => 'Ogg medialêer, lengte $2, $3',
	'timedmedia-ogg-long-error' => 'Ongeldige Ogg-lêer: $1',
	'timedmedia-more' => 'Meer…',
	'timedmedia-dismiss' => 'Sluit',
	'timedmedia-download' => 'Laai lêer af',
	'timedmedia-desc-link' => 'Aangaande die lêer',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'timedmedia-desc' => 'Mbajtës për mediat në kohën e duhur (video, audio, timedText) me transcoding të ZQM Theora / Vorbis',
	'timedmedia-ogg-short-audio' => 'Ogg tingull $1 fotografi, $2',
	'timedmedia-ogg-short-video' => 'video file Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 media file, $2',
	'timedmedia-ogg-long-audio' => 'ZQM file $1 shëndoshë, gjatë $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 video file, gjatë $2, $4 × $5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'ZQM multiplexed audio / video file, $1, gjatë $2, $4 × $5 pixels, $3 e përgjithshme',
	'timedmedia-ogg-long-general' => 'Ogg media file, gjatë $2, $3',
	'timedmedia-ogg-long-error' => 'E pavlefshme Ogg file: $1',
	'timedmedia-no-player-js' => 'Na vjen keq, browser-i juaj ose ka JavaScript paaftë ose nuk ka asnjë lojtar të mbështetur. <br /> Ju mund të <a href="$1">shkarkoni clip</a> ose <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">shkarkoni një lojtar</a> për të luajtur clip në shfletuesin tuaj.',
	'timedmedia-more' => 'Më shumë ...',
	'timedmedia-dismiss' => 'Afër',
	'timedmedia-download' => 'Shkarko file',
	'timedmedia-desc-link' => 'Për këtë fotografi',
	'timedmedia-oggThumb-version' => 'OggHandler kërkon version oggThumb $1 ose më vonë.',
	'timedmedia-oggThumb-failed' => 'oggThumb dështuar për të krijuar tablo.',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'timedmedia-desc' => 'Maneyador de fichers sincronizatos (vidio, son y texto sincronizato) con transcodificación Ogg Theora/Vorbis',
	'timedmedia-ogg-short-audio' => 'Fichero de son ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Fichero de vidio ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Fichero multimedia ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Fichero de son ogg $1, durada $2, $3',
	'timedmedia-ogg-long-video' => 'Fichero de vidio ogg $1, durada $2, $4×$5 píxels, $3',
	'timedmedia-ogg-long-multiplexed' => 'fichero ogg multiplexato audio/vidio, $1, durada $2, $4×$5 píxels, $3 total',
	'timedmedia-ogg-long-general' => 'fichero ogg multimedia durada $2, $3',
	'timedmedia-ogg-long-error' => 'Fichero ogg no conforme: $1',
	'timedmedia-more' => 'Más…',
	'timedmedia-dismiss' => 'Zarrar',
	'timedmedia-download' => 'Escargar fichero',
	'timedmedia-desc-link' => 'Información sobre este fichero',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 * @author روخو
 */
$messages['ar'] = array(
	'timedmedia-desc' => 'متحكم لملفات Ogg Theora وVorbis، مع لاعب جافاسكريت',
	'timedmedia-ogg-short-audio' => 'Ogg $1 ملف صوت، $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 ملف فيديو، $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 ملف ميديا، $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 ملف صوت، الطول $2، $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 ملف فيديو، الطول $2، $4×$5 بكسل، $3',
	'timedmedia-ogg-long-multiplexed' => 'ملف Ogg مالتي بليكسد أوديو/فيديو، $1، الطول $2، $4×$5 بكسل، $3 إجمالي',
	'timedmedia-ogg-long-general' => 'ملف ميديا Ogg، الطول $2، $3',
	'timedmedia-ogg-long-error' => 'ملف Ogg غير صحيح: $1',
	'timedmedia-webm-short-video' => 'نسق WebM، $1 ملف فيديو $2',
	'timedmedia-webm-long-video' => 'ملف صوت/فيديو بنسق WebM , $1, الطول $2, $4×$5 بكسل، $3 إجمالا',
	'timedmedia-no-player-js' => 'عذرا، متصفحك إما انه لا يدعم الجافا سكريبت أو انها معطلة.<br />
تستطيع <a href="$1">تحميل المقطع</a> أو <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">تحميل مشغل</a> يستطيع تشغيل المقطع على متصفحك.',
	'timedmedia-more' => 'المزيد...',
	'timedmedia-dismiss' => 'أغلق',
	'timedmedia-download' => 'نزل الملف',
	'timedmedia-play-media' => 'تشغيل الوسائط',
	'timedmedia-desc-link' => 'عن هذا الملف',
	'timedmedia-status' => 'الحالة',
	'timedmedia-status-unknown' => 'حالة غير معروفة',
	'timedmedia-actions' => 'الإجراءات',
	'timedmedia-not-ready' => 'غير جاهز',
	'timedmedia-percent-done' => 'وصل لنسبة $1% انتهى',
	'timedmedia-time-4-measurements' => '$1, $2, $3 و $4',
	'timedmedia-time-3-measurements' => '$1, $2 و $3',
	'timedmedia-time-2-measurements' => '$1 و $2',
	'timedmedia-show-error' => 'إظهار الخطأ',
	'timedmedia-ogg' => 'أو جي جي',
	'timedmedia-source-file' => '$1 مصدر',
	'timedmedia-derivative-desc-160p.ogv' => 'انخفاض عرض النطاق الترددي أوج فيديو (160P)',
	'timedmedia-derivative-desc-720p.ogv' => 'تحميل أوج فيديو بجودة عالية  (720P)',
	'timedmedia-subtitle-language' => '$1 ($2) ترجمات',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'timedmedia-more' => 'ܝܬܝܪ…',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'timedmedia-desc' => 'متحكم لملفات أو جى جى ثيورا و فوربيس، مع بلاير جافاسكريبت',
	'timedmedia-ogg-short-audio' => 'Ogg $1 ملف صوت، $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 ملف فيديو, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 ملف ميديا، $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 ملف صوت، الطول $2، $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 ملف فيديو، الطول $2، $4×$5 بكسل، $3',
	'timedmedia-ogg-long-multiplexed' => 'ملف Ogg مالتى بليكسد أوديو/فيديو، $1، الطول $2، $4×$5 بكسل، $3 إجمالي',
	'timedmedia-ogg-long-general' => 'ملف ميديا Ogg، الطول $2، $3',
	'timedmedia-ogg-long-error' => 'ملف ogg مش صحيح: $1',
	'timedmedia-more' => 'أكتر...',
	'timedmedia-dismiss' => 'اقفل',
	'timedmedia-download' => 'نزل الملف',
	'timedmedia-desc-link' => 'عن الملف دا',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'timedmedia-desc' => 'Remanador de soníu, videu y testu cronometráu, con sofitu pa los formatos WebM, Ogg Theora, Vorbis y srt',
	'timedmedia-ogg-short-audio' => 'Archivu de soníu ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Archivu de videu ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Archivu multimedia ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Archivu de soníu ogg $1, llonxitú $2, $3',
	'timedmedia-ogg-long-video' => 'Archivu de videu ogg $1, llonxitú $2, $4×$5 píxeles, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ficheru de soníu/videu ogg multiplexáu, $1, llonxitú $2, $4×$5 píxeles, $3',
	'timedmedia-ogg-long-general' => 'Archivu multimedia ogg, llonxitú $2, $3',
	'timedmedia-ogg-long-error' => 'Archivu ogg non válidu: $1',
	'timedmedia-webm-short-video' => 'Ficheru de videu  WebM $1, $2',
	'timedmedia-webm-long-video' => 'Ficheru de soníu/videu  WebM, $1, llonxitú $2, $4 × $5 pixels, $3 total',
	'timedmedia-more' => 'Más...',
	'timedmedia-dismiss' => 'Zarrar',
	'timedmedia-download' => 'Descargar archivu',
	'timedmedia-desc-link' => 'Tocante a esti archivu',
);

/** Kotava (Kotava)
 * @author Sab
 */
$messages['avk'] = array(
	'timedmedia-download' => 'Iyeltakkalvajara',
	'timedmedia-desc-link' => 'Icde bat iyeltak',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'timedmedia-status' => 'Status',
	'timedmedia-time-4-measurements' => '$1, $2, $3 və $4',
	'timedmedia-time-3-measurements' => '$1, $2 və $3',
	'timedmedia-time-2-measurements' => '$1 və $2',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'timedmedia-desc' => 'دسگیره په فایلان Ogg Theora و Vorbis, گون پخش کنوک جاوا اسکرسیپت',
	'timedmedia-ogg-short-audio' => 'فایل صوتی Ogg $1، $2',
	'timedmedia-ogg-short-video' => 'فایل تصویری Ogg $1، $2',
	'timedmedia-ogg-short-general' => 'فایل مدیا Ogg $1، $2',
	'timedmedia-ogg-long-audio' => 'اوجی جی  $1 فایل صوتی, طول $2, $3',
	'timedmedia-ogg-long-video' => 'اوجی جی $1 فایل ویدیو, طول $2, $4×$5 پیکسل, $3',
	'timedmedia-ogg-long-multiplexed' => 'اوجی جی چند دابی فایل صوت/تصویر, $1, طول $2, $4×$5 پیکسل, $3 کل',
	'timedmedia-ogg-long-general' => 'اوجی جی فایل مدیا, طول $2, $3',
	'timedmedia-ogg-long-error' => 'نامعتبرین فایل اوجی جی: $1',
	'timedmedia-more' => 'گیشتر...',
	'timedmedia-dismiss' => 'بندگ',
	'timedmedia-download' => 'ایرگیزگ فایل',
	'timedmedia-desc-link' => 'ای فایل باره',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'timedmedia-more' => 'Dakol pa..',
	'timedmedia-dismiss' => 'Isara',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'timedmedia-desc' => 'Апрацоўшчык аўдыё, відэа і субтытраў у фарматах WebM, Ogg Theora, Vorbis і SRT',
	'timedmedia-ogg-short-audio' => 'Аўдыё-файл Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Відэа-файл у фармаце Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Мэдыяфайл Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'аўдыё-файл Ogg $1, даўжыня $2, $3',
	'timedmedia-ogg-long-video' => 'відэа-файл Ogg $1, даўжыня $2, $4×$5 піксэляў, $3',
	'timedmedia-ogg-long-multiplexed' => 'мультыплексны аўдыё/відэа-файл Ogg, $1, даўжыня $2, $4×$5 піксэляў, усяго $3',
	'timedmedia-ogg-long-general' => 'мэдыяфайл Ogg, даўжыня $2, $3',
	'timedmedia-ogg-long-error' => 'Няслушны файл у фармаце Ogg: $1',
	'timedmedia-webm-short-video' => 'WebM $1 відэа-файл, $2',
	'timedmedia-webm-long-video' => 'Аўдыё/відэа-файл WebM, $1, працягласьць $2, $4×$5 піксэлаў, усяго $3',
	'timedmedia-no-player-js' => 'Прабачце, але ў Вашым браўзэры адключаны JavaScript альбо няма неабходнага прайгравальніка.<br />
Вы можаце <a href="$1">загрузіць кліп</a> ці <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">загрузіць прайгравальнік</a> для прайграваньня кліпу ў Вашым браўзэры.',
	'timedmedia-more' => 'Болей…',
	'timedmedia-dismiss' => 'Зачыніць',
	'timedmedia-download' => 'Загрузіць файл',
	'timedmedia-play-media' => 'Прайграць',
	'timedmedia-desc-link' => 'Інфармацыя пра гэты файл',
	'timedmedia-oggThumb-version' => 'OggHandler патрабуе oggThumb вэрсіі $1 ці больш позьняй.',
	'timedmedia-oggThumb-failed' => 'oggThumb не атрымалася стварыць мініятуру.',
	'timedmedia-status-header' => 'Статус транскадаваньня',
	'timedmedia-update-status' => 'Абнавіць статус транскадаваньня',
	'timedmedia-status' => 'Статус',
	'timedmedia-status-unknown' => 'Статус невядомы',
	'timedmedia-actions' => 'Дзеяньні',
	'timedmedia-completed-on' => 'Транскадаваньне завершанае $1',
	'timedmedia-source-file' => 'Крыніца $1',
	'timedmedia-source-file-desc' => '$1 (арыгінал), $2×$3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Нізкапаточнае Ogg-відэа (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Паточнае Ogg-відэа (360 пкс)',
	'timedmedia-derivative-desc-480p.ogv' => 'Паточнае Ogg-відэа (480 пкс)',
	'timedmedia-derivative-desc-720p.ogv' => 'Высакаякаснае Ogg-відэа для загрузкі (720p)',
	'timedmedia-derivative-desc-360p.webm' => 'Паточны WebM (360p)',
	'timedmedia-derivative-desc-480p.webm' => 'Паточны WebM (480p)',
	'timedmedia-derivative-desc-720p.webm' => 'Высакаякаснае WebM-відэа для загрузкі (720p)',
	'timedmedia-subtitle-language' => 'Субтытры ($2) на $1',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'timedmedia-desc' => 'Приложение за файлове тип Ogg Theora и Vorbis, с плейър на JavaScript',
	'timedmedia-ogg-short-audio' => 'Ogg $1 звуков файл, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 видео файл, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 звуков файл, продължителност $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 видео файл, продължителност $2, $4×$5 пиксела, $3',
	'timedmedia-ogg-long-general' => 'Мултимедиен файл в ogg формат с дължина $2, $3',
	'timedmedia-ogg-long-error' => 'Невалиден ogg файл: $1',
	'timedmedia-more' => 'Повече...',
	'timedmedia-dismiss' => 'Затваряне',
	'timedmedia-download' => 'Изтегляне на файла',
	'timedmedia-desc-link' => 'Информация за файла',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'timedmedia-ogg-short-audio' => 'অগ $1 সাউন্ড ফাইল, $2',
	'timedmedia-ogg-short-video' => 'অগ $1 ভিডিও ফাইল, $2',
	'timedmedia-ogg-short-general' => 'অগ $1 মিডিয়া ফাইল, $2',
	'timedmedia-ogg-long-audio' => 'অগ $1 সাউন্ড ফাইল, দৈর্ঘ্য $2, $3',
	'timedmedia-ogg-long-video' => 'অগ $1 ভিডিও ফাইল, দৈর্ঘ্য $2, $4×$5 পিক্সেল, $3',
	'timedmedia-ogg-long-multiplexed' => 'অগ মাল্টিপ্লেক্সকৃত অডিও/ভিডিও ফাইল, $1, দৈর্ঘ্য $2, $4×$5 পিক্সেল, $3 সামগ্রিক',
	'timedmedia-ogg-long-general' => 'অগ মিডিয়া ফাইল, দৈর্ঘ্য $2, $3',
	'timedmedia-ogg-long-error' => 'অবৈধ অগ ফাইল: $1',
	'timedmedia-more' => 'আরও...',
	'timedmedia-dismiss' => 'বন্ধ',
	'timedmedia-download' => 'ফাইল ডাউনলোড করুন',
	'timedmedia-desc-link' => 'এই ফাইলের বৃত্তান্ত',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'timedmedia-desc' => 'Skor video, son ha testenn sinkronelaet gant ar furmadoù WebM, Ogg Theora hag SRT skoret',
	'timedmedia-ogg-short-audio' => 'Restr son Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Restr video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Restr media Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Restr son Ogg $1, pad $2, $3',
	'timedmedia-ogg-long-video' => 'Restr video Ogg $1, pad $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Restr Ogg klevet/video liesplezhet $1, pad $2, $4×$5 piksel, $3 hollad',
	'timedmedia-ogg-long-general' => 'Restr media Ogg, pad $2, $3',
	'timedmedia-ogg-long-error' => 'Restr ogg direizh : $1',
	'timedmedia-webm-short-video' => 'Restr video WebM $1, $2',
	'timedmedia-webm-long-video' => 'Restr video/son WebM, $1, pad $2, $4 × $5 piksel, $3 en holl',
	'timedmedia-no-player-js' => 'Ho tigarez, pe eo diweredekaet JavaScript war ho merdeer pen n\'eo ket skoret lenner ebet gantañ.<br />
<a href="$1">Pellgargañ ar c\'hlip</a> a c\'hallit pe <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">pellgargañ ul lenner</a> da lenn ar c\'hlip gant ho merdeer.',
	'timedmedia-more' => "Muioc'h...",
	'timedmedia-dismiss' => 'Serriñ',
	'timedmedia-download' => 'Pellgargañ ar restr',
	'timedmedia-play-media' => 'Lenn ar media',
	'timedmedia-desc-link' => 'Diwar-benn ar restr-mañ',
	'timedmedia-oggThumb-version' => "Rekis eo stumm $1 oggThumb, pe nevesoc'h, evit implijout OggHandler.",
	'timedmedia-oggThumb-failed' => "N'eo ket deuet a-benn oggThumb da grouiñ ar munud.",
	'timedmedia-status' => 'Statud',
	'timedmedia-status-unknown' => 'Statud dianav',
	'timedmedia-not-ready' => "N'eo ket prest",
	'timedmedia-days' => '$1 {{PLURAL: $1|devezh|devezh}}',
	'timedmedia-hours' => '$1 {{PLURAL: $1|eurvezh|eurvezh}}',
	'timedmedia-minutes' => '$1 {{PLURAL: $1|munutenn|munutenn}}',
	'timedmedia-seconds' => '$1 {{PLURAL:$1|eilenn|eilenn}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 ha $4',
	'timedmedia-time-3-measurements' => '$1, $2 ha $3',
	'timedmedia-time-2-measurements' => '$1 ha $2',
	'timedmedia-show-error' => 'Diskouez ar fazi',
	'timedmedia-source-file' => 'Mammenn $1',
	'timedmedia-source-file-desc' => 'Orin $1, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Video Ogg izelgas (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Video Ogg lennus war-eeun war ar Gwiad (360p)',
	'timedmedia-derivative-desc-480p.ogv' => 'Video Ogg lennus war-eeun war ar Gwiad (480p)',
	'timedmedia-derivative-desc-720p.ogv' => "Video Ogg da bellgargañ gant ur c'halite a-feson (720p)",
	'timedmedia-derivative-desc-360p.webm' => 'WebM lennus war-eeun eus ar Gwiad (360p)',
	'timedmedia-derivative-desc-480p.webm' => 'WebM lennus war-eeun eus ar Gwiad (480p)',
	'timedmedia-derivative-desc-720p.webm' => "Video WebM da bellgargañ gant ur c'halite a-feson (720p)",
	'timedmedia-subtitle-language' => 'istitloù e $1 ($2)',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'timedmedia-desc' => 'Upravljač za zvuk, video i vremenski tekst sa podrškom formata za WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Ogg $1 zvučna datoteka, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 video datoteka, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 medijalna datoteka, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 zvučna datoteka, dužina $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 video datoteka, dužina $2, $4×$5 piksela, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg multipleksna zvučna/video datoteka, $1, dužina $2, $4×$5 piksela, $3 sveukupno',
	'timedmedia-ogg-long-general' => 'Ogg medijalna datoteka, dužina $2, $3',
	'timedmedia-ogg-long-error' => 'Nevaljana ogg datoteka: $1',
	'timedmedia-no-player-js' => 'Žao nam je, vaš preglednik ili je onemogućio JavaScript ili nema nijednog podržanog playera.<br />
Možete <a href="$1">učitati klip</a> ili <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">učitati player</a> za reproduciranje klipa u vašem pregledniku.',
	'timedmedia-more' => 'Više...',
	'timedmedia-dismiss' => 'Zatvori',
	'timedmedia-download' => 'Učitaj datoteku',
	'timedmedia-desc-link' => 'O ovoj datoteci',
	'timedmedia-oggThumb-version' => 'OggHandler zahtijeva oggThumb verziju $1 ili kasniju.',
	'timedmedia-oggThumb-failed' => 'oggThumb nije uspio napraviti smanjeni pregled.',
	'timedmedia-source-file' => '$1 izvor',
	'timedmedia-source-file-desc' => 'Original $1, $2 × $3 ($4)',
	'timedmedia-subtitle-language' => '$1 ($2) podnaslovi',
);

/** Catalan (Català)
 * @author Aleator
 * @author Paucabot
 * @author SMP
 * @author Toniher
 * @author Vriullop
 */
$messages['ca'] = array(
	'timedmedia-desc' => 'Gestor de fitxers Ogg Theora i Vorbis, amb reproductor de Javascript',
	'timedmedia-ogg-short-audio' => "Fitxer OGG d'àudio $1, $2",
	'timedmedia-ogg-short-video' => 'Fitxer OGG de vídeo $1, $2',
	'timedmedia-ogg-short-general' => 'Fitxer multimèdia OGG $1, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 fitxer de so, llargada $2, $3',
	'timedmedia-ogg-long-video' => 'Fitxer OGG de vídeo $1, llargada $2, $4×$5 píxels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Arxiu àudio/vídeo multiplex, $1, llargada $2, $4×$5 píxels, $3 de mitjana',
	'timedmedia-ogg-long-general' => 'Fitxer multimèdia OGG, llargada $2, $3',
	'timedmedia-ogg-long-error' => 'Fitxer OGG invàlid: $1',
	'timedmedia-more' => 'Més...',
	'timedmedia-dismiss' => 'Tanca',
	'timedmedia-download' => 'Descarrega el fitxer',
	'timedmedia-desc-link' => 'Informació del fitxer',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'timedmedia-download' => 'Чуйаккха хlум',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'timedmedia-desc' => 'Obsluha časovaných souborů (video, audio, titulky) s převodem do Ogg Theora/Vorbis',
	'timedmedia-ogg-short-audio' => 'Zvukový soubor ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Videosoubor ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Multimediální soubor ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Zvukový soubor ogg $1, délka $2, $3',
	'timedmedia-ogg-long-video' => 'Videosoubor $1, délka $2, $4×$5 pixelů, $3',
	'timedmedia-ogg-long-multiplexed' => 'Audio/video soubor ogg, $1, délka $2, $4×$5 pixelů, $3',
	'timedmedia-ogg-long-general' => 'Soubor média ogg, délka $2, $3',
	'timedmedia-ogg-long-error' => 'Chybný soubor ogg: $1',
	'timedmedia-no-player-js' => 'Je mi líto, ale váš prohlížeč má buď vypnutý JavaScript, nebo nemáte žádný podporovaný přehrávač.<br />
Můžete si <a href="$1">stáhnout klip</a> nebo si <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/cs">stáhnout přehrávač</a>, kterým si klip přehrajete v prohlížeči.',
	'timedmedia-more' => 'Více...',
	'timedmedia-dismiss' => 'Zavřít',
	'timedmedia-download' => 'Stáhnout soubor',
	'timedmedia-desc-link' => 'O tomto souboru',
	'timedmedia-oggThumb-version' => 'OggHandler vyžaduje oggThumb verze $1 nebo novější.',
	'timedmedia-oggThumb-failed' => 'oggThumb nedokázal vytvořit náhled.',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'timedmedia-desc' => 'Understøtter Ogg Theora- og Vorbis-filer med en JavaScript-afspiller.',
	'timedmedia-ogg-short-audio' => 'Ogg $1 lydfil, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videofil, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 mediafil, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 lydfil, længde $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videofil, længde $2, $4×$5 pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Sammensat Ogg-lyd- og -videofil, $1, længde $2, $4×$5 pixel, $3 samlet',
	'timedmedia-ogg-long-general' => 'Ogg mediafil, længde $2, $3',
	'timedmedia-ogg-long-error' => 'Ugyldig Ogg-fil: $1',
	'timedmedia-more' => 'Mere...',
	'timedmedia-dismiss' => 'Luk',
	'timedmedia-download' => 'Download fil',
	'timedmedia-desc-link' => 'Om denne fil',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Leithian
 * @author Metalhead64
 * @author MichaelFrey
 * @author Raimond Spekking
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'timedmedia-desc' => 'Stellt ein Steuerungsprogramm für zeitgesteuerte Medien (Video, Audio, timedText) bereit, welches die Formate WebM, Ogg Theora, Ogg Vorbis und SubRip unterstützt',
	'timedmedia-ogg-short-audio' => 'Ogg-$1-Audiodatei, $2',
	'timedmedia-ogg-short-video' => 'Ogg-$1-Videodatei, $2',
	'timedmedia-ogg-short-general' => 'Ogg-$1-Mediadatei, $2',
	'timedmedia-ogg-long-audio' => 'Ogg-$1-Audiodatei, Länge: $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg-$1-Videodatei, Länge: $2, $4×$5 Pixel, $3 insgesamt',
	'timedmedia-ogg-long-multiplexed' => 'Ogg-Audio-/Video-Datei, $1, Länge: $2, $4×$5 Pixel, $3 insgesamt',
	'timedmedia-ogg-long-general' => 'Ogg-Mediadatei, Länge: $2, $3',
	'timedmedia-ogg-long-error' => 'Ungültige Ogg-Datei: $1',
	'timedmedia-webm-short-video' => 'WebM-$1-Videodatei, $2',
	'timedmedia-webm-long-video' => 'WebM-Audio-/Video-Datei, $1, Länge: $2, $4×$5 Pixel, $3 insgesamt',
	'timedmedia-no-player-js' => 'Entschuldige, aber dein Browser hat entweder JavaScript deaktiviert oder keine unterstützte Abspielsoftware.<br />
Du kannst <a href="$1">den Clip herunterladen</a> oder <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">eine Abspielsoftware herunterladen</a>, um den Clip im Browser abzuspielen.',
	'timedmedia-more' => 'Optionen …',
	'timedmedia-dismiss' => 'Schließen',
	'timedmedia-download' => 'Datei herunterladen',
	'timedmedia-play-media' => 'Mediendatei abspielen',
	'timedmedia-desc-link' => 'Über diese Datei',
	'timedmedia-oggThumb-version' => 'OggHandler erfordert oggThumb in der Version $1 oder höher.',
	'timedmedia-oggThumb-failed' => 'oggThumb konnte kein Miniaturbild erstellen.',
	'timedmedia-status-header' => 'Umschlüsselungsstatus',
	'timedmedia-update-status' => 'Umschlüsselungsstatus aktualisieren',
	'timedmedia-status' => 'Status',
	'timedmedia-status-unknown' => 'Unbekannter Status',
	'timedmedia-transcodeinfo' => 'Abgeleitete Beschreibung umschlüsseln',
	'timedmedia-actions' => 'Aktionen',
	'timedmedia-direct-link' => 'Ableitung herunterladen',
	'timedmedia-not-ready' => 'Nicht bereit',
	'timedmedia-completed-on' => 'Umschlüsselung von $1 abgeschlossen',
	'timedmedia-error-on' => 'Fehler beim Umschlüsseln in $1.',
	'timedmedia-started-transcode' => 'Umschlüsselung startete vor $1. $2',
	'timedmedia-percent-done' => 'Ungefähr $1 % sind erledigt',
	'timedmedia-in-job-queue' => 'Vor $1 der Auftragswarteschlange hinzugefügt',
	'timedmedia-unknown-target-size' => 'Unbekannte Zielgröße, $1 codiert',
	'timedmedia-days' => '{{PLURAL:$1|Tag|$1 Tage}}',
	'timedmedia-hours' => '{{PLURAL:$1|Stunde|$1 Stunden}}',
	'timedmedia-minutes' => '{{PLURAL:$1|Minute|$1 Minuten}}',
	'timedmedia-seconds' => '{{PLURAL:$1|Sekunde|$1 Sekunden}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 und $4',
	'timedmedia-time-3-measurements' => '$1, $2 und $3',
	'timedmedia-time-2-measurements' => '$1 und $2',
	'timedmedia-show-error' => 'Fehler anzeigen',
	'timedmedia-reset' => 'Umschlüsselung zurücksetzen',
	'timedmedia-reset-confirm' => 'Das Zurücksetzen dieser Umschlüsselung wird, sofern vorhanden, die bestehende Datei entfernen und die Umschlüsselung erneut der Auftragswarteschlange hinzufügen. Die erneute Umschlüsselung wird einige Zeit dauern.<br /><br />Soll dies tatsächlich gemacht werden?',
	'timedmedia-reset-error' => 'Fehler beim Zurücksetzen der Umschlüsselung',
	'timedmedia-source-file' => 'Quelle ($1)',
	'timedmedia-source-file-desc' => 'Original $1, $2 x $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg (160p)',
	'timedmedia-derivative-desc-160p.ogv' => 'Ogg-Videodatei mit niedriger Datenübertragungsrate (160p)',
	'timedmedia-derivative-desc-360p.ogv' => 'Webstreamingfähige Ogg-Videodatei (360p)',
	'timedmedia-derivative-desc-480p.ogv' => 'Webstreamingfähige Ogg-Videodatei (480p)',
	'timedmedia-derivative-desc-720p.ogv' => 'Qualitativ hochwertige Ogg-Videodatei (720p)',
	'timedmedia-derivative-desc-360p.webm' => 'Webstreamingfähige WebM-Videodatei (360p)',
	'timedmedia-derivative-desc-480p.webm' => 'Webstreamingfähige WebM-Videodatei (480p)',
	'timedmedia-derivative-desc-720p.webm' => 'Qualitativ hochwertige WebM-Videodatei (720p)',
	'timedmedia-subtitle-language' => '$1 ($2) Untertitel',
	'timedmedia-subtitle-no-video' => 'Der aktuellen Seite mit Untertiteln ist kein Video zugeordnet.',
	'timedmedia-subtitle-no-subtitles' => 'Derzeit gibt es keine Untertitel auf $1 für dieses Video. Zum Hinzufügen von Untertiteln kann [{{fullurl:{{FULLPAGENAME}}|action=edit}} diese Seite] bearbeitet werden.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'timedmedia-desc' => 'Qe dosyayanê Ogg Theora u Vorbisî pê JavaScriptî qulp',
	'timedmedia-ogg-short-audio' => 'Ogg $1 dosyaya vengi, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 dosyaya filmi, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 dosyaya medyayi, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 dosyaya medyayi,  mudde $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 dosyaya filmi, mudde $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg dosyaya filmi/vengi yo multiexed, $1, mudde $2, $4×$5 piksel, $3 bıumumi',
	'timedmedia-ogg-long-general' => 'Ogg dosyaya medyayi, mudde $2, $3',
	'timedmedia-ogg-long-error' => 'dosyaya oggi yo nemeqbul: $1',
	'timedmedia-more' => 'hema....',
	'timedmedia-dismiss' => 'bıqefeln',
	'timedmedia-download' => 'dosya biyar war',
	'timedmedia-desc-link' => 'derheqê dosyayi de',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'timedmedia-desc' => 'Wóźeński program za awdio, wideo a timedText, z formatoweju pódpěru za WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Ogg $1 awdiodataja, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 wideodataja, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 medijowa dataja, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 awdiodataja, dłujkosć $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 wideodataja, dłujkosć $2, $4×$5 pikselow, $3',
	'timedmedia-ogg-long-multiplexed' => 'ogg multipleksowa awdio-/wideodataja, $1, dłujkosć $2, $4×$5 pikselow, $3 dogromady',
	'timedmedia-ogg-long-general' => 'Ogg medijowa dataja, dłujkosć $2, $3',
	'timedmedia-ogg-long-error' => 'Njepłaśiwa Ogg-dataja: $1',
	'timedmedia-webm-short-video' => 'WebM $1 wideodataja, $2',
	'timedmedia-webm-long-video' => 'WebM dataja awdio/wideo, $1, dłujkosć $2, $4 x $5, $3 dogromady',
	'timedmedia-no-player-js' => 'Twój wobglědowak jo bóžko pak JavaScript znjemóžnił abo njama njepódpěrany wótegrawak.<br />
Móžoš  <a href="$1">klip ześěgnuś</a> abo <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">wótgrawak ześěgnuś</a>, aby klip w swójom wobglědowaku wótegrał.',
	'timedmedia-more' => 'Wěcej...',
	'timedmedia-dismiss' => 'Zacyniś',
	'timedmedia-download' => 'Dataju ześěgnuś',
	'timedmedia-play-media' => 'Medijowu dataju wótegraś',
	'timedmedia-desc-link' => 'Wó toś tej dataji',
	'timedmedia-oggThumb-version' => 'OggHandler trjeba wersiju $1 oggThumb abo nowšu.',
	'timedmedia-oggThumb-failed' => 'oggThumb njejo mógł wobrazk napóraś.',
	'timedmedia-source-file' => 'Žrědło ($1)',
	'timedmedia-source-file-desc' => 'Original $1, $2 x $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Niska šyrokosć pasma Ogg-widea (200p)',
	'timedmedia-subtitle-language' => '$1 ($2) pódtitele',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Dead3y3
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'timedmedia-desc' => 'Χειριστής για αρχεία Ogg Theora και Vorbis, με αναπαραγωγέα JavaScript',
	'timedmedia-ogg-short-audio' => 'Αρχείο ήχου Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Αρχείο βίντεο Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Αρχείο μέσων Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Αρχείο ήχου Ogg $1, διάρκεια $2, $3',
	'timedmedia-ogg-long-video' => 'Αρχείο βίντεο Ogg $1, διάρκεια $2, $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Αρχείο πολυπλεκτικού ήχου/βίντεο Ogg, $1, διάρκεια $2, $4×$5 pixels, $3 ολικά',
	'timedmedia-ogg-long-general' => 'Αρχείο μέσων Ogg, διάρκεια $2, $3',
	'timedmedia-ogg-long-error' => 'Άκυρο αρχείο ogg: $1',
	'timedmedia-more' => 'Περισσότερα...',
	'timedmedia-dismiss' => 'Κλείσιμο',
	'timedmedia-download' => 'Κατεβάστε το αρχείο',
	'timedmedia-desc-link' => 'Σχετικά με αυτό το αρχείο',
);

/** Esperanto (Esperanto)
 * @author Amikeco
 * @author ArnoLagrange
 * @author Yekrats
 */
$messages['eo'] = array(
	'timedmedia-desc' => 'Traktilo por sondosieroj, videoj, kaj horloĝigita teksto, kun formatsubteno por WebM kaj Ogg Theora kaj Vobis kaj srt.',
	'timedmedia-ogg-short-audio' => 'Ogg $1 sondosiero, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videodosiero, $2',
	'timedmedia-ogg-short-general' => 'Media Ogg-dosiero $1, $2',
	'timedmedia-ogg-long-audio' => 'Aŭda Ogg-dosiero $1, longeco $2, $3 entute',
	'timedmedia-ogg-long-video' => 'Video Ogg-dosiero $1, longeco $2, $4×$5 pikseloj, $3 entute',
	'timedmedia-ogg-long-multiplexed' => 'Kunigita aŭdio/video Ogg-dosiero, $1, longeco $2, $4×$5 pikseloj, $3 entute',
	'timedmedia-ogg-long-general' => 'Ogg-mediodosiero, longeco $2, $3',
	'timedmedia-ogg-long-error' => 'Malvalida Ogg-dosiero: $1',
	'timedmedia-more' => 'Pli...',
	'timedmedia-dismiss' => 'Fermi',
	'timedmedia-download' => 'Alŝuti dosieron',
	'timedmedia-desc-link' => 'Pri ĉi tiu dosiero',
);

/** Spanish (Español)
 * @author Aleator
 * @author Crazymadlover
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 * @author Translationista
 */
$messages['es'] = array(
	'timedmedia-desc' => 'Herramienta de control de elementos multimedia sincronizados (vídeo, sonido y texto sincronizado) con transcodificación Ogg Theora y Vorbis',
	'timedmedia-ogg-short-audio' => 'Archivo de sonido Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Archivo de video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Archivo Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Archivo de sonido Ogg $1, tamaño $2, $3',
	'timedmedia-ogg-long-video' => 'Archivo de video Ogg $1, tamaño $2, $4×$5 píxeles, $3',
	'timedmedia-ogg-long-multiplexed' => 'Archivo Ogg de audio/video multiplexado, $1, tamaño $2, $4×$5 píxeles, $3 en todo',
	'timedmedia-ogg-long-general' => 'Archivo Ogg. tamaño $2, $3',
	'timedmedia-ogg-long-error' => 'Archivo Ogg no válido: $1',
	'timedmedia-no-player-js' => 'Lo sentimos, pero tu navegador tiene JavaScript inhabilitado o no tiene ningún reproductor compatible instalado.<br />
Puedes <a href="$1">descargar el clip</a> o <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descargar un reproductor</a> para poder ver el vídeo en tu navegador.',
	'timedmedia-more' => 'Opciones...',
	'timedmedia-dismiss' => 'Cerrar',
	'timedmedia-download' => 'Descargar archivo',
	'timedmedia-desc-link' => 'Sobre este archivo',
	'timedmedia-oggThumb-version' => 'OggHandler requiere una versión oggThumb $1 o posterior.',
	'timedmedia-oggThumb-failed' => 'oggThumb no pudo crear la imagen miniatura.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'timedmedia-desc' => 'Ogg Theora ja Vorbis failide töötleja JavaScript-esitajaga.',
	'timedmedia-ogg-long-error' => 'Vigane Ogg-fail: $1',
	'timedmedia-more' => 'Lisa...',
	'timedmedia-dismiss' => 'Sule',
	'timedmedia-download' => 'Laadi fail alla',
	'timedmedia-desc-link' => 'Info faili kohta',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Joxemai
 * @author Theklan
 */
$messages['eu'] = array(
	'timedmedia-desc' => 'Ogg Theora eta Vorbis fitxategientzako edukiontzia, JavaScript playerrarekin',
	'timedmedia-ogg-short-audio' => 'Ogg $1 soinu fitxategia, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 bideo fitxategia, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 media fitxategia, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 soinu fitxategia, $2 iraupea, $3',
	'timedmedia-ogg-long-error' => 'ogg fitxategi okerra: $1',
	'timedmedia-more' => 'Gehiago...',
	'timedmedia-dismiss' => 'Itxi',
	'timedmedia-download' => 'Fitxategia jaitsi',
	'timedmedia-desc-link' => 'Fitxategi honen inguruan',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'timedmedia-desc' => 'به دست گیرندهٔ پرونده‌های صوتی، تصویری و متن‌های زمان‌بندی شده با پشتیبانی از Ogg Theora ،Vorbis و srt',
	'timedmedia-ogg-short-audio' => 'پرونده صوتی Ogg $1، $2',
	'timedmedia-ogg-short-video' => 'پرونده تصویری Ogg $1، $2',
	'timedmedia-ogg-short-general' => 'پرونده Ogg $1، $2',
	'timedmedia-ogg-long-audio' => 'پرونده صوتی Ogg $1، مدت $2، $3',
	'timedmedia-ogg-long-video' => 'پرونده تصویری Ogg $1، مدت $2 ، $4×$5 پیکسل، $3',
	'timedmedia-ogg-long-multiplexed' => 'پرونده صوتی/تصویری پیچیده Ogg، $1، مدت $2، $4×$5 پیکسل، $3 در مجموع',
	'timedmedia-ogg-long-general' => 'پرونده Ogg، مدت $2، $3',
	'timedmedia-ogg-long-error' => 'پرونده Ogg غیرمجاز: $1',
	'timedmedia-more' => 'بیشتر...',
	'timedmedia-dismiss' => 'بستن',
	'timedmedia-download' => 'بارگیری پرونده',
	'timedmedia-desc-link' => 'دربارهٔ این پرونده',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'timedmedia-desc' => 'Käsittelijä Ogg Theora ja Vorbis -tiedostoille ja JavaScript-soitin.',
	'timedmedia-ogg-short-audio' => 'Ogg $1 -äänitiedosto, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 -videotiedosto, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 -mediatiedosto, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 -äänitiedosto, $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 -videotiedosto, $2, $4×$5, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg-tiedosto limitetty kuva ja ääni, $1, $2, $4×$5, $3',
	'timedmedia-ogg-long-general' => 'Ogg-tiedosto, $2, $3',
	'timedmedia-ogg-long-error' => 'Kelvoton Ogg-tiedosto: $1',
	'timedmedia-more' => 'Lisää…',
	'timedmedia-dismiss' => 'Sulje',
	'timedmedia-download' => 'Lataa',
	'timedmedia-desc-link' => 'Tiedoston tiedot',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'timedmedia-more' => 'Meira...',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author Hashar
 * @author IAlex
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Od1n
 * @author Peter17
 * @author Seb35
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'timedmedia-desc' => 'Support pour les vidéo, audio et texte synchronisé avec support des formats WebM, Ogg Theora, Vorbis et srt',
	'timedmedia-ogg-short-audio' => 'Fichier son Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Fichier vidéo Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Fichier média Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Fichier son Ogg $1, durée $2, $3',
	'timedmedia-ogg-long-video' => 'Fichier vidéo Ogg $1, durée $2, $4 × $5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Fichier multiplexé audio/vidéo Ogg, $1, durée $2, $4 × $5 pixels, $3',
	'timedmedia-ogg-long-general' => 'Fichier média Ogg, durée $2, $3',
	'timedmedia-ogg-long-error' => 'Fichier Ogg invalide : $1',
	'timedmedia-webm-short-video' => 'Fichier vidéo WebM $1, $2',
	'timedmedia-webm-long-video' => "Fichier audio/vidéo WebM, $1, longueur $2, $4 x $5 pixels, $3 l'ensemble",
	'timedmedia-no-player-js' => 'Désolé, soit votre navigateur a JavaScript désactivé, soit il ne dispose d’aucun lecteur pris en charge.<br />
Vous pouvez <a href="$1">télécharger le clip</a> ou <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">télécharger un lecteur</a> pour lire le clip dans votre navigateur.',
	'timedmedia-more' => 'Plus…',
	'timedmedia-dismiss' => 'Fermer',
	'timedmedia-download' => 'Télécharger le fichier',
	'timedmedia-play-media' => 'Lire le média',
	'timedmedia-desc-link' => 'À propos de ce fichier',
	'timedmedia-oggThumb-version' => 'OggHandler nécessite oggThumb, version $1 ou supérieure.',
	'timedmedia-oggThumb-failed' => 'oggThumb n’a pas réussi à créer la miniature.',
	'timedmedia-status-header' => 'Statut de transcodage',
	'timedmedia-update-status' => 'Mettre à jour le statut de transcodage',
	'timedmedia-status' => 'Statut',
	'timedmedia-status-unknown' => 'État inconnu',
	'timedmedia-transcodeinfo' => 'Description dérivée du transcodage',
	'timedmedia-actions' => 'Actions',
	'timedmedia-direct-link' => 'Télécharger le dérivé',
	'timedmedia-not-ready' => 'Pas prêt',
	'timedmedia-completed-on' => 'Transcodage de $1 terminé',
	'timedmedia-error-on' => 'Erreur dans le transcodage de $1.',
	'timedmedia-started-transcode' => 'Transcodage démarré depuis $1. $2',
	'timedmedia-percent-done' => 'Environ $1 % complété',
	'timedmedia-in-job-queue' => "Ajouté à la file d'attente il y a $1",
	'timedmedia-unknown-target-size' => 'Taille de la cible inconnue, $1 encodé',
	'timedmedia-days' => '$1 {{PLURAL:$1| jour|jours}}',
	'timedmedia-hours' => '$1 {{PLURAL:$1|heure|heures}}',
	'timedmedia-minutes' => '$1 {{PLURAL:$1|minute|minutes}}',
	'timedmedia-seconds' => '$1 {{PLURAL:$1|seconde|secondes}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 et $4',
	'timedmedia-time-3-measurements' => '$1, $2 et $3',
	'timedmedia-time-2-measurements' => '$1 et $2',
	'timedmedia-show-error' => 'Afficher les erreurs',
	'timedmedia-reset' => 'Réinitialiser le transcodage',
	'timedmedia-reset-confirm' => "Remettre à zéro ce transcodage supprimera tout fichier existant (s'il y en a) et ajoutera de nouveau le transcodage à la file de travaux. Cela prendra un certain temps pour être transcodé de nouveau. <br /><br />
Êtes-vous sûr de vouloir continuer ?",
	'timedmedia-reset-error' => 'Erreur en réinitialisant le travail de transcodage.',
	'timedmedia-source-file' => 'Source $1',
	'timedmedia-source-file-desc' => 'Initial $1, $2 × $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg 160P',
	'timedmedia-derivative-desc-160p.ogv' => 'Vidéo Ogg bas débit (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Vidéo Ogg lisible en continu sur le Web (360p)',
	'timedmedia-derivative-desc-480p.ogv' => 'Vidéo Ogg lisible en continu sur le web (480p)',
	'timedmedia-derivative-desc-720p.ogv' => 'Vidéo Ogg téléchargeable de grande qualité (720p)',
	'timedmedia-derivative-desc-360p.webm' => 'WebM lisible en continu depuis le web (360p)',
	'timedmedia-derivative-desc-480p.webm' => 'WebM lisible en continu depuis le web (480p)',
	'timedmedia-derivative-desc-720p.webm' => 'Vidéo WebM téléchargeable de grande qualité (720p)',
	'timedmedia-subtitle-language' => 'sous-titres en $1 ($2)',
	'timedmedia-subtitle-no-video' => 'Il n’y a aucune vidéo associée à la page actuelle de sous-titre',
	'timedmedia-subtitle-no-subtitles' => "Il n'y a actuellement aucun sous-titres en $1 pour cette vidéo, vous pouvez [{{fullurl: {{FULLPAGENAME}} | action=edit}} modifier cette page] pour les ajouter",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'timedmedia-desc' => 'Assistance por los fichiérs mèdia que dèfilont (ôdiô, vidèô et tèxto sincronisâ) avouéc transcodâjo en WebM, Ogg Theora, Vorbis et srt.',
	'timedmedia-ogg-short-audio' => 'Fichiér son Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Fichiér vidèô Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Fichiér mèdia Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Fichiér son Ogg $1, temps $2, $3',
	'timedmedia-ogg-long-video' => 'Fichiér vidèô Ogg $1, temps $2, $4×$5 pixèls, $3',
	'timedmedia-ogg-long-multiplexed' => 'Fichiér multiplèxo ôdiô / vidèô Ogg, $1, temps $2, $4×$5 pixèls, $3',
	'timedmedia-ogg-long-general' => 'Fichiér mèdia Ogg, temps $2, $3',
	'timedmedia-ogg-long-error' => 'Fichiér Ogg envalido : $1',
	'timedmedia-webm-short-video' => 'Fichiér vidèô WebM $1, $2',
	'timedmedia-webm-long-video' => 'Fichiér ôdiô / vidèô WebM, $1, longior $2, $4 x $5 pixèls, en tot $3',
	'timedmedia-more' => 'De ples...',
	'timedmedia-dismiss' => 'Cllôre',
	'timedmedia-download' => 'Tèlèchargiér lo fichiér',
	'timedmedia-play-media' => 'Liére lo mèdia',
	'timedmedia-desc-link' => 'A propôs de ceti fichiér',
	'timedmedia-oggThumb-version' => 'OggHandler at fôta d’oggThumb, vèrsion $1 ou ben ples novèla.',
	'timedmedia-oggThumb-failed' => 'oggThumb at pas reussi a fâre la figura.',
	'timedmedia-status' => 'statut',
	'timedmedia-status-unknown' => 'statut encognu',
	'timedmedia-actions' => 'Accions',
	'timedmedia-not-ready' => 'Pas prèst',
	'timedmedia-percent-done' => 'A pou prés $1 % complètâ',
	'timedmedia-days' => '$1 jorn{{PLURAL:$1||s}}',
	'timedmedia-hours' => '$1 hor{{PLURAL:$1|a|es}}',
	'timedmedia-minutes' => '$1 menut{{PLURAL:$1|a|es}}',
	'timedmedia-seconds' => '$1 second{{PLURAL:$1|a|es}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 et $4',
	'timedmedia-time-3-measurements' => '$1, $2 et $3',
	'timedmedia-time-2-measurements' => '$1 et $2',
	'timedmedia-show-error' => 'Fâre vêre les èrrors',
	'timedmedia-source-file' => 'Sôrsa $1',
	'timedmedia-source-file-desc' => 'Originâl $1, $2 × $3 ($4)',
	'timedmedia-subtitle-language' => 'sot-titros en $1 ($2)',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'timedmedia-desc' => 'Gjestôr pai files audio, video e di test cul timp, cun supuart pai formâts WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'File audio Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'File video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'File multimediâl Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'File audio Ogg $1, durade $2, $3',
	'timedmedia-ogg-long-video' => 'File video Ogg $1, durade $2, dimensions $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'File audio/video multiplexed Ogg $1, lungjece $2, dimensions $4×$5 pixels, in dut $3',
	'timedmedia-ogg-long-general' => 'File multimediâl Ogg, durade $2, $3',
	'timedmedia-ogg-long-error' => 'File ogg no valit: $1',
	'timedmedia-webm-short-video' => 'File video WebM $1, $2',
	'timedmedia-more' => 'Altri...',
	'timedmedia-dismiss' => 'Siere',
	'timedmedia-download' => 'Discjame il file',
	'timedmedia-desc-link' => 'Informazions su chest file',
	'timedmedia-status' => 'Stât',
	'timedmedia-actions' => 'Azions',
);

/** Irish (Gaeilge)
 * @author Spacebirdy
 */
$messages['ga'] = array(
	'timedmedia-dismiss' => 'Dún',
);

/** Galician (Galego)
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'timedmedia-desc' => 'Manipulador de son, vídeo e texto sincronizado, con soporte para os formatos WebM, Ogg Theora, Vorbis e srt',
	'timedmedia-ogg-short-audio' => 'Ficheiro de son Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Ficheiro de vídeo Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Ficheiro multimedia Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Ficheiro de son Ogg $1, duración $2, $3',
	'timedmedia-ogg-long-video' => 'Ficheiro de vídeo Ogg $1, duración $2, $4×$5 píxeles, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ficheiro de son/vídeo Ogg multiplex, $1, duración $2, $4×$5 píxeles, $3 total',
	'timedmedia-ogg-long-general' => 'Ficheiro multimedia Ogg, duración $2, $3',
	'timedmedia-ogg-long-error' => 'Ficheiro Ogg non válido: $1',
	'timedmedia-webm-short-video' => 'Ficheiro de vídeo WebM $1, $2',
	'timedmedia-webm-long-video' => 'Ficheiro WebM de son/vídeo, $1, duración $2, $4×$5 píxeles, $3 total',
	'timedmedia-no-player-js' => 'O seu navegador ten o JavaScript desactivado ou non conta con ningún reprodutor dos soportados.<br />
Pode <a href="$1">descargar o vídeo</a> ou <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">un reprodutor</a> para reproducir o vídeo no seu navegador.',
	'timedmedia-more' => 'Máis...',
	'timedmedia-dismiss' => 'Pechar',
	'timedmedia-download' => 'Descargar o ficheiro',
	'timedmedia-play-media' => 'Reproducir o contido',
	'timedmedia-desc-link' => 'Acerca deste ficheiro',
	'timedmedia-oggThumb-version' => 'O OggHandler necesita a versión $1 ou unha posterior do oggThumb.',
	'timedmedia-oggThumb-failed' => 'Houbo un erro por parte do oggThumb ao crear a miniatura.',
	'timedmedia-status-header' => 'Estado da transcodificación',
	'timedmedia-update-status' => 'Actualizar o estado de transcodificación',
	'timedmedia-status' => 'Estado',
	'timedmedia-status-unknown' => 'Estado descoñecido',
	'timedmedia-transcodeinfo' => 'Descrición da transcodificación derivada',
	'timedmedia-actions' => 'Accións',
	'timedmedia-direct-link' => 'Descargar o derivado',
	'timedmedia-not-ready' => 'Aínda non está preparado',
	'timedmedia-completed-on' => 'Transcodificación completada o $1',
	'timedmedia-error-on' => 'Erro na transcodificación o $1.',
	'timedmedia-started-transcode' => 'A transcodificación comezou hai $1. $2',
	'timedmedia-percent-done' => 'Preto do $1% feito',
	'timedmedia-in-job-queue' => 'Engadido á cola de traballos hai $1',
	'timedmedia-unknown-target-size' => 'Tamaño de destino descoñecido; $1 codificados',
	'timedmedia-days' => '{{PLURAL:$1|día|$1 días}}',
	'timedmedia-hours' => '{{PLURAL:$1|hora|$1 horas}}',
	'timedmedia-minutes' => '{{PLURAL:$1|minuto|$1 minutos}}',
	'timedmedia-seconds' => '{{PLURAL:$1|segundo|$1 segundos}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 e $4',
	'timedmedia-time-3-measurements' => '$1, $2 e $3',
	'timedmedia-time-2-measurements' => '$1 e $2',
	'timedmedia-show-error' => 'Mostrar o erro',
	'timedmedia-reset' => 'Restablecer a transcodificación',
	'timedmedia-reset-confirm' => 'Ao restablecer a transcodificación eliminarase calquera ficheiro existente e volverá engadir a transcodificación á cola de traballos. A nova transcodificación levará bastante tempo.<br /><br />
Está seguro de querer continuar?',
	'timedmedia-reset-error' => 'Erro no restablecemento do traballo de transcodificación.',
	'timedmedia-source-file' => 'Fonte $1',
	'timedmedia-source-file-desc' => 'Orixinal $1, $2 × $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg 160P',
	'timedmedia-derivative-desc-160p.ogv' => 'Vídeo Ogg de baixo ancho de banda (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Vídeo Ogg para a web (360P)',
	'timedmedia-derivative-desc-480p.ogv' => 'Vídeo Ogg para a web (480P)',
	'timedmedia-derivative-desc-720p.ogv' => 'Vídeo Ogg de alta calidade que se pode descargar (720P)',
	'timedmedia-derivative-desc-360p.webm' => 'WebM para a web (360P)',
	'timedmedia-derivative-desc-480p.webm' => 'WebM para a web (480P)',
	'timedmedia-derivative-desc-720p.webm' => 'WebM de alta calidade que se pode descargar (720P)',
	'timedmedia-subtitle-language' => 'Subtítulos en $1 ($2)',
	'timedmedia-subtitle-no-video' => 'Non hai ningún vídeo asociado coa páxina de subtítulos actual',
	'timedmedia-subtitle-no-subtitles' => 'Actualmente non hai subtítulos en $1 para este vídeo; pode [{{fullurl:{{FULLPAGENAME}}|action=edit}} editar esta páxina] para engadilos',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Flyax
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'timedmedia-ogg-long-error' => 'Ἄκυρα ἀρχεῖα ogg: $1',
	'timedmedia-more' => 'πλέον...',
	'timedmedia-dismiss' => 'Κλῄειν',
	'timedmedia-source-file' => '$1 Πηγή',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 * @author Melancholie
 */
$messages['gsw'] = array(
	'timedmedia-desc' => 'Stellt e Styyrigsprogramm fir zytgstyyrti Medie (Video, Audio, timedText) zur Verfiegig, wo d Format WebM, Ogg Theora, Ogg Vorbis un SubRip unterstützt',
	'timedmedia-ogg-short-audio' => 'Ogg-$1-Audiodatei, $2',
	'timedmedia-ogg-short-video' => 'Ogg-$1-Videodatei, $2',
	'timedmedia-ogg-short-general' => 'Ogg-$1-Mediadatei, $2',
	'timedmedia-ogg-long-audio' => 'Ogg-$1-Audiodatei, Längi: $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg-$1-Videodatei, Längi: $2, $4×$5 Pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg-Audio-/Video-Datei, $1, Längi: $2, $4×$5 Pixel, $3',
	'timedmedia-ogg-long-general' => 'Ogg-Mediadatei, Längi: $2, $3',
	'timedmedia-ogg-long-error' => 'Uugiltigi Ogg-Datei: $1',
	'timedmedia-webm-short-video' => 'WebM-$1-Videodatei, $2',
	'timedmedia-webm-long-video' => 'WebM-Audio-/Video-Datei, $1, Längei: $2, $4×$5 Pixel, $3 insgsamt',
	'timedmedia-no-player-js' => 'Excusez, aber Dyy Browser het entwäder JavaScript deaktiviert oder kei unterstitzti Abspilsoftware.<br />
Du chasch <a href="$1">dr Clip abelade</a> oder <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">e Abspielsoftware abelade</a> go dr Clip im Browser abspile.',
	'timedmedia-more' => 'Meh …',
	'timedmedia-dismiss' => 'Zuemache',
	'timedmedia-download' => 'Datei spychere',
	'timedmedia-play-media' => 'Mediedatei abspiile',
	'timedmedia-desc-link' => 'Iber die Datei',
	'timedmedia-oggThumb-version' => 'OggHandler brucht oggThumb in dr Version $1 oder hecher.',
	'timedmedia-oggThumb-failed' => 'oggThumb het kei Miniaturbild chenne aalege.',
	'timedmedia-status-header' => 'Umschlüsseligsstatus',
	'timedmedia-update-status' => 'Umschlüsseligsstatus aktualisiere',
	'timedmedia-status' => 'Status',
	'timedmedia-status-unknown' => 'Status nit bekannt',
	'timedmedia-transcodeinfo' => 'Abgleiteti Beschryybig umschlüssle',
	'timedmedia-actions' => 'Aktione',
	'timedmedia-direct-link' => 'Ableitig abelade',
	'timedmedia-not-ready' => 'Nit parat',
	'timedmedia-completed-on' => 'Umschlüsselig vo $1 abgschlosse',
	'timedmedia-error-on' => 'Fääler bim Umschlüssle in $1.',
	'timedmedia-started-transcode' => 'Umschlüsselig het vor $1 aagfange. $2',
	'timedmedia-percent-done' => 'Öbe $1 % fertig',
	'timedmedia-in-job-queue' => 'Vor $1 zur Ufftragswarteschlange dezuegfiegt worde',
	'timedmedia-unknown-target-size' => 'Unbekannti Ziilgrößi, $1 codiert',
	'timedmedia-days' => '{{PLURAL:$1|1 Tag|$1 Täg}}',
	'timedmedia-hours' => '{{PLURAL:$1|1 Stund|$1 Stunde}}',
	'timedmedia-minutes' => '{{PLURAL:$1|1 Minut|$1 Minute}}',
	'timedmedia-seconds' => '{{PLURAL:$1|1 Sekund|$1 Sekunde}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 un $4',
	'timedmedia-time-3-measurements' => '$1, $2 un $3',
	'timedmedia-time-2-measurements' => '$1 un $2',
	'timedmedia-show-error' => 'Fääler aazeige',
	'timedmedia-reset' => 'Umschlüsselig zruggsetze',
	'timedmedia-reset-confirm' => "S Zruggsetze vo dere Umschlüsselig wird (wänn's vorhande isch), die aktuelli Datei ussenee un d Umschlüsselig no emool uff d Ufftragswarteschlange dezuefiege. E nöii Umschlüsselig wird e Wyyl goo.<br /><br /> Söll des würkli gmacht werde?",
	'timedmedia-reset-error' => 'Fääler bim Zruggsetze vo de Umschlüsselig.',
	'timedmedia-source-file' => 'Quell ($1)',
	'timedmedia-source-file-desc' => 'Original $1, $2 x $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Ogg-Videodatei mit niidriger Dateübertragigsrate (160p)',
	'timedmedia-derivative-desc-360p.ogv' => 'Webstreamingfähigi Ogg-Videodatei (360p)',
	'timedmedia-derivative-desc-480p.ogv' => 'Webstreamingfähigi Ogg-Videodatei (480p)',
	'timedmedia-derivative-desc-720p.ogv' => 'Qualitativ hochwertigi Ogg-Videodatei (720p)',
	'timedmedia-derivative-desc-360p.webm' => 'Webstreamingfähigi WebM-Videodatei (360p)',
	'timedmedia-derivative-desc-480p.webm' => 'Webstreamingfähigi WebM-Videodatei (480p)',
	'timedmedia-derivative-desc-720p.webm' => 'Qualitativ hochwertigi WebM-Videodatei (720p)',
	'timedmedia-subtitle-language' => '$1 ($2) Untertitel',
	'timedmedia-subtitle-no-video' => 'Dere Untertitel-Syte isch kei Video zuegordnet.',
	'timedmedia-subtitle-no-subtitles' => 'Es git uff $1 zurzit kei Untertitel für des Video. Bim dezuefiege vo Untertitel cha [{{fullurl:{{FULLPAGENAME}}|action=edit}} die Syte] bearbeitet werde.',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'timedmedia-desc-link' => 'Mychione y choadan shoh',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotem Liss
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'timedmedia-desc' => 'מטפל במדיה מתוזמנת – וידאו, שמע, טקסט מתוזמן – עם תמיכה בתסדירי WebM&rlm;, Ogg Theora&rlm;, Vorbis ו־srt',
	'timedmedia-ogg-short-audio' => 'קובץ שמע $1 של Ogg, $2',
	'timedmedia-ogg-short-video' => 'קובץ וידאו $1 של Ogg, $2',
	'timedmedia-ogg-short-general' => 'קובץ מדיה $1 של Ogg, $2',
	'timedmedia-ogg-long-audio' => 'קובץ שמע $1 של Ogg, באורך $2, $3',
	'timedmedia-ogg-long-video' => 'קובץ וידאו $1 של Ogg, באורך $2, $4×$5 פיקסלים, $3',
	'timedmedia-ogg-long-multiplexed' => 'קובץ Ogg מרובב של שמע ווידאו, $1, באורך $2, $4×$5 פיקסלים, $3 בסך הכול',
	'timedmedia-ogg-long-general' => 'קובץ מדיה של Ogg, באורך $2, $3',
	'timedmedia-ogg-long-error' => 'קובץ ogg בלתי תקין: $1',
	'timedmedia-webm-short-video' => 'קובץ וידוא WebM $1&rlm;, $2',
	'timedmedia-webm-long-video' => 'קובץ שמע ווידאו WebM&rlm;, $1, באורך $2&rlm;, $4 × $5 פיקסלים, $3 סך הכול',
	'timedmedia-no-player-js' => 'סליחה, בדפדפן שלכם לא מופעלת תמיכה ב־JavaScript או שאין לכם נגן נתמך.<br />
אתם יכולים <a href="$1">להוריד למחשב את הסרטון</a> או <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">להוריד למחשב שלכם נגן</a> שינגן את הסרטון בדפדפן שלכם.',
	'timedmedia-more' => 'עוד…',
	'timedmedia-dismiss' => 'סגירה',
	'timedmedia-download' => 'הורדת הקובץ',
	'timedmedia-play-media' => 'לנגן את המדיה',
	'timedmedia-desc-link' => 'אודות הקובץ',
	'timedmedia-oggThumb-version' => 'OggHandler דורש oggThumb מגרסה $1 או גרסה חדשה יותר.',
	'timedmedia-oggThumb-failed' => 'oggThumb לא הצליח ליצור תמונה מוקטנת.',
	'timedmedia-status-header' => 'מצב המרה מחדש',
	'timedmedia-update-status' => 'עדכון מצב המרה מחדש',
	'timedmedia-status' => 'מצב',
	'timedmedia-status-unknown' => 'מצב לא ידוע',
	'timedmedia-actions' => 'פעולות',
	'timedmedia-not-ready' => 'לא מוכן',
	'timedmedia-completed-on' => 'ההמרה מחדש $1 הושלמה',
	'timedmedia-error-on' => 'שגיאה בהמרה מחדש ב־$1.',
	'timedmedia-started-transcode' => 'המרה מחדש התחילה לפני $1‏. $2',
	'timedmedia-percent-done' => 'בערך $1% נעשה',
	'timedmedia-in-job-queue' => 'נוסף לתור משימות לפני $1',
	'timedmedia-unknown-target-size' => 'גודל יעד אינו ידוע, קודדו $1',
	'timedmedia-days' => '{{PLURAL:$1|יום אחד|$1 ימים}}',
	'timedmedia-hours' => '{{PLURAL:$1|שעה אחת|$1 שעות}}',
	'timedmedia-minutes' => '{{PLURAL:$1|דקה אחת|$1 דקות}}',
	'timedmedia-seconds' => '{{PLURAL:$1|שנייה אחת|$1 שניות}}',
	'timedmedia-time-4-measurements' => '$1‏, ‏$2, $3 ו{{GRAMMAR:תחילית|$4}}',
	'timedmedia-time-3-measurements' => '$1‏, ‏$2 ו{{GRAMMAR:תחילית|$3}}',
	'timedmedia-time-2-measurements' => '$1 ו{{GRAMMAR:תחילית|$2}}',
	'timedmedia-show-error' => 'להציג את השגיאה',
	'timedmedia-reset' => 'אתחול המרה מחדש',
	'timedmedia-reset-confirm' => 'אתחול ההמרה הזאת תמחק כל קובץ קיים (אם יש כזה) ותוסיף שוב את ההמרה מחדש לתור המשימות. ייקח זמן כדי להמיר מחדש שוב.<br /><br />להמשיך?',
	'timedmedia-reset-error' => 'שגיאה באתחול משימת המרה מחדש',
	'timedmedia-source-file' => 'ממקור $1',
	'timedmedia-source-file-desc' => '$1 מקורי, $2 × $3&rlm; ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'וידאו Ogg (160P)&lrm; לרוחב פס נמוך',
	'timedmedia-derivative-desc-360p.ogv' => 'וידאו Ogg (360P)&lrm; לנגינה שוטפת מהרשת',
	'timedmedia-derivative-desc-480p.ogv' => 'וידאו Ogg (480P)&lrm; לנגינה שוטפת מהרשת',
	'timedmedia-derivative-desc-720p.ogv' => 'וידאו Ogg (720P)&lrm; באיכות גבוהה שניתן להורדה',
	'timedmedia-derivative-desc-360p.webm' => 'WebM ניתן לשידור שטף ברשת (360P)',
	'timedmedia-derivative-desc-480p.webm' => 'וידאו WebM (480P)&lrm; לנגינה שוטפת מהרשת',
	'timedmedia-derivative-desc-720p.webm' => 'וידאו WebM (720P)&lrm; באיכות גבוהה שניתן להורדה',
	'timedmedia-subtitle-language' => 'כתוביות ב$1&rlm; ($2)',
	'timedmedia-subtitle-no-video' => 'אין וידאו שמשויך לדף הכתוביות הנוכחי',
	'timedmedia-subtitle-no-subtitles' => 'אין כעת כתוביות עבור השפה הבאה: $1. אפשר [{{fullurl:{{FULLPAGENAME}}|action=edit}} לערוך את הדף הזה] ולהוסיף אותן',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'timedmedia-desc' => 'ऑग थियोरा और वॉर्बिस फ़ाईल्सके लिये चालक, जावास्क्रीप्ट प्लेयर के साथ',
	'timedmedia-ogg-short-audio' => 'ऑग $1 ध्वनी फ़ाईल, $2',
	'timedmedia-ogg-short-video' => 'ऑग $1 चलतचित्र फ़ाईल, $2',
	'timedmedia-ogg-short-general' => 'ऑग $1 मीडिया फ़ाईल, $2',
	'timedmedia-ogg-long-audio' => 'ऑग $1 ध्वनी फ़ाईल, लंबाई $2, $3',
	'timedmedia-ogg-long-video' => 'ऑग $1 चलतचित्र फ़ाईल, लंबाई $2, $4×$5 पीक्सेल्स, $3',
	'timedmedia-ogg-long-multiplexed' => 'ऑग ध्वनी/चित्र फ़ाईल, $1, लंबाई $2, $4×$5 पिक्सेल्स, $3 कुल',
	'timedmedia-ogg-long-general' => 'ऑग मीडिया फ़ाईल, लंबाई $2, $3',
	'timedmedia-ogg-long-error' => 'गलत ऑग फ़ाईल: $1',
	'timedmedia-more' => 'और...',
	'timedmedia-dismiss' => 'बंद करें',
	'timedmedia-download' => 'फ़ाईल डाउनलोड करें',
	'timedmedia-desc-link' => 'इस फ़ाईलके बारे में',
);

/** Croatian (Hrvatski)
 * @author CERminator
 * @author Dalibor Bosits
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'timedmedia-desc' => 'Poslužitelj za Ogg Theora i Vorbis datoteke, s JavaScript preglednikom',
	'timedmedia-ogg-short-audio' => 'Ogg $1 zvučna datoteka, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 video datoteka, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 medijska datoteka, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 zvučna datoteka, duljine $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 video datoteka, duljine $2, $4x$5 piksela, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg multipleksirana zvučna/video datoteka, $1, duljine $2, $4×$5 piksela, $3 ukupno',
	'timedmedia-ogg-long-general' => 'Ogg medijska datoteka, duljine $2, $3',
	'timedmedia-ogg-long-error' => 'nevaljana ogg datoteka: $1',
	'timedmedia-more' => 'Više...',
	'timedmedia-dismiss' => 'Zatvori',
	'timedmedia-download' => 'Snimi datoteku',
	'timedmedia-desc-link' => 'O ovoj datoteci',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 * @author Reedy
 */
$messages['hsb'] = array(
	'timedmedia-desc' => 'Wodźenski program za awdio, widejo a timedText z podpěru za formaty WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Awdiodataja Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Widejodataja Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Ogg medijowa dataja $1, $2',
	'timedmedia-ogg-long-audio' => 'Ogg-awdiodataja $1, dołhosć: $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg-widejodataja $1, dołhosć: $2, $4×$5 pikselow, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg multipleksna awdio-/widejodataja, $1, dołhosć: $2, $4×$5 pikselow, $3',
	'timedmedia-ogg-long-general' => 'Ogg medijowa dataja, dołhosć: $2, $3',
	'timedmedia-ogg-long-error' => 'Njepłaćiwa Ogg-dataja: $1',
	'timedmedia-webm-short-video' => 'Widejodataja WebM $1, $2',
	'timedmedia-webm-long-video' => 'Awdio-/widejodataja WebM, $1, dołhosć $2, $4 x $5 pikselow, $3 dohromady',
	'timedmedia-no-player-js' => 'Twój wobhladowak je pak JavaScript znjemóžnił pak nima podpěrowany wothrawak.<br />
Móžeš <a href="$1">klip sćahnyć</a> abo <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">wothrawak sćahnyć</a>, zo by klip w swojim wobhladowaku wothrawał.',
	'timedmedia-more' => 'Wjace ...',
	'timedmedia-dismiss' => 'Začinić',
	'timedmedia-download' => 'Dataju sćahnyć',
	'timedmedia-play-media' => 'Medijowu dataju wothrać',
	'timedmedia-desc-link' => 'Wo tutej dataji',
	'timedmedia-oggThumb-version' => 'OggHandler trjeba wersiju $1 oggThumb abo nowšu.',
	'timedmedia-oggThumb-failed' => 'oggThumb njemóžeše wobrazk wutworić.',
	'timedmedia-status-header' => 'Překodowanski status',
	'timedmedia-update-status' => 'Překodowanski status aktualizować',
	'timedmedia-status' => 'Status',
	'timedmedia-status-unknown' => 'Njeznaty status',
	'timedmedia-transcodeinfo' => 'Wotwodźene wopisanje překodować',
	'timedmedia-actions' => 'Akcije',
	'timedmedia-direct-link' => 'Wotwodźenje sćahnyć',
	'timedmedia-not-ready' => 'Nic hotowy',
	'timedmedia-completed-on' => 'Překodowanje $1 wotzamknjene',
	'timedmedia-error-on' => 'Zmylk při překodowanju $1.',
	'timedmedia-started-transcode' => 'Překodowanje před $1 startowane. $2',
	'timedmedia-percent-done' => 'Na wšě $1% sčinjene',
	'timedmedia-in-job-queue' => 'Před $1 čakanskemu rynčkej přidaty',
	'timedmedia-unknown-target-size' => 'Njeznata cilowa wulkosć, $1 kodowane',
	'timedmedia-days' => '{{PLURAL:$1|dźeń|$1 dnjej|$1 dny|$1 dnjow}}',
	'timedmedia-hours' => '{{PLURAL:$1|hodźina|$1 hodźinje|$1 hodźiny|$1 hodźin}}',
	'timedmedia-minutes' => '{{PLURAL:$1|mjeńšina|$1 mjeńšinje|$1 mjeńšiny|$1 mjeńšin}}',
	'timedmedia-seconds' => '{{PLURAL:$1|sekunda|$1 sekundźe|$1 sekundy|$1 sekundow}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 a $4',
	'timedmedia-time-3-measurements' => '$1, $2 a $3',
	'timedmedia-time-2-measurements' => '$1 a $2',
	'timedmedia-show-error' => 'Zmylk pokazać',
	'timedmedia-reset' => 'Překodowanje wróćo stajić',
	'timedmedia-reset-confirm' => 'Wróćostajenje tutoho překodowanja wotstroni eksistowacu dataju (jeli tajka eksistuje), a budźe překodowanje znowa čakanskemu rynčkej přidawać. Nowe překodowanje budźe někotry čas trać.<br /><br />
Chceš woprawdźe pokročować?',
	'timedmedia-reset-error' => 'Zmylk při wróćostajenju překodowanja.',
	'timedmedia-source-file' => 'Žórło ($1)',
	'timedmedia-source-file-desc' => 'Originalny $1, $2 x $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Ogg-widejo z niskej šěrokosću pasma (160p)',
	'timedmedia-derivative-desc-360p.ogv' => 'Ogg-widejo (360p), kotrež da so přez Web přenjesć',
	'timedmedia-derivative-desc-480p.ogv' => 'Ogg-widejo (480p), kotrež da so přez Web přenjesć',
	'timedmedia-derivative-desc-720p.ogv' => 'Sćahujomne Ogg-widejo wysokeje kwality (720p)',
	'timedmedia-derivative-desc-360p.webm' => 'WebM-widejo (360p), kotrež da so přez Web přenjesć',
	'timedmedia-derivative-desc-480p.webm' => 'WebM-widejo (480p), kotrež da so přez Web přenjesć',
	'timedmedia-derivative-desc-720p.webm' => 'Sćahujomna WebM-dataja wysokeje kwality (720p)',
	'timedmedia-subtitle-language' => '$1 ($2) podtitule',
	'timedmedia-subtitle-no-video' => 'Widejo zwjazane z aktuelnej stronu podtitulow njeje',
	'timedmedia-subtitle-no-subtitles' => 'Tuchwilu podtitule w $1 zu tute widejo njejsu, móžeš [{{fullurl:{{FULLPAGENAME}}|action=edit}} tutu stronu wobdźěłać], zo by je přidał',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author Tgr
 */
$messages['hu'] = array(
	'timedmedia-desc' => 'JavaScript nyelven írt lejátszó Ogg Theora és Vorbis fájlokhoz',
	'timedmedia-ogg-short-audio' => 'Ogg $1 hangfájl, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videofájl, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 médiafájl, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 hangfájl, hossza: $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videófájl, hossza $2, $4×$5 képpont, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg egyesített audió- és videófájl, $1, hossz: $2, $4×$5 képpont, $3 összesen',
	'timedmedia-ogg-long-general' => 'Ogg médiafájl, hossza: $2, $3',
	'timedmedia-ogg-long-error' => 'Érvénytelen ogg fájl: $1',
	'timedmedia-no-player-js' => 'Sajnáljuk, a böngésződben vagy le van tiltva a JavaScript, vagy nincs egyetlen támogatott lejátszója sem.<br />
<a href="$1">Letöltheted a klipet</a>, vagy <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">letölthetsz egy lejátszót</a> a böngészőben való megtekintéshez.',
	'timedmedia-more' => 'Tovább...',
	'timedmedia-dismiss' => 'Bezárás',
	'timedmedia-download' => 'Fájl letöltése',
	'timedmedia-play-media' => 'Média lejátszása',
	'timedmedia-desc-link' => 'Fájlinformációk',
	'timedmedia-oggThumb-version' => 'Az OggHandlerhez $1 vagy későbbi verziójú oggThumb szükséges.',
	'timedmedia-oggThumb-failed' => 'Az oggThumb nem tudta elkészíteni a bélyegképet.',
	'timedmedia-source-file-desc' => 'Eredeti $1, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Alacsony sávszélességű Ogg videó (160P)',
	'timedmedia-derivative-desc-720p.ogv' => 'Magas minőségű, letölthető Ogg videó (720P)',
	'timedmedia-derivative-desc-720p.webm' => 'Magas minőségű, letölthető WebM (720P)',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'timedmedia-desc' => 'Gestor pro audio, video e texto synchronisate, con supporto del formatos WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'File audio Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'File video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'File media Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'File audio Ogg $1, duration $2, $3',
	'timedmedia-ogg-long-video' => 'File video Ogg $1, duration $2, $4×$5 pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'File multiplexate audio/video Ogg, $1, duration $2, $4×$5 pixel, $3 in total',
	'timedmedia-ogg-long-general' => 'File media Ogg, duration $2, $3',
	'timedmedia-ogg-long-error' => 'File Ogg invalide: $1',
	'timedmedia-webm-short-video' => 'File video WebM $1, $2',
	'timedmedia-webm-long-video' => 'File audio/video WebM, $1, longitude $2, $4 × $5 pixels, $3 in total',
	'timedmedia-no-player-js' => 'Pardono, tu systema o ha JavaScript disactivate o non ha un reproductor supportate.<br />
Tu pote <a href="$1">discargar le clip</a> o <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">discargar un reproductor</a> pro reproducer le clip in tu navigator.',
	'timedmedia-more' => 'Plus…',
	'timedmedia-dismiss' => 'Clauder',
	'timedmedia-download' => 'Discargar file',
	'timedmedia-play-media' => 'Reproducer multimedia',
	'timedmedia-desc-link' => 'A proposito de iste file',
	'timedmedia-oggThumb-version' => 'OggHandler require oggThumb version $1 o plus recente.',
	'timedmedia-oggThumb-failed' => 'oggThumb ha fallite de crear le miniatura.',
	'timedmedia-status-header' => 'Stato de transcodification',
	'timedmedia-update-status' => 'Actualisar stato de transcodification',
	'timedmedia-status' => 'stato',
	'timedmedia-status-unknown' => 'stato incognite',
	'timedmedia-transcodeinfo' => 'Description del file transcodificate',
	'timedmedia-actions' => 'actiones',
	'timedmedia-direct-link' => 'Discargar file transcodificate',
	'timedmedia-not-ready' => 'Non preste',
	'timedmedia-completed-on' => 'Transcodification de $1 complete',
	'timedmedia-error-on' => 'Error in transcodification a $1.',
	'timedmedia-started-transcode' => 'Le transcodification comenciava $1 retro. $2',
	'timedmedia-percent-done' => 'Circa $1% complete',
	'timedmedia-in-job-queue' => 'Addite al cauda de actiones $1 retro',
	'timedmedia-unknown-target-size' => 'Dimension del destination incognite, $1 codificate',
	'timedmedia-days' => '{{PLURAL:$1|die|$1 dies}}',
	'timedmedia-hours' => '{{PLURAL:$1|hora|$1 horas}}',
	'timedmedia-minutes' => '{{PLURAL:$1|minuta|$1 minutas}}',
	'timedmedia-seconds' => '{{PLURAL:$1|secunda|$1 secundas}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 e $4',
	'timedmedia-time-3-measurements' => '$1, $2 e $3',
	'timedmedia-time-2-measurements' => '$1 e $2',
	'timedmedia-show-error' => 'Monstrar error',
	'timedmedia-reset' => 'Reinitialisar transcodification',
	'timedmedia-reset-confirm' => 'Reinitialisar iste transcodification removera tote le files existente (si presente), e illo re-addera le transcodification al cauda de actiones. Le transcodification prendera un tempore. <br /><br />Es tu secur de voler continuar?',
	'timedmedia-reset-error' => 'Error durante le reinitialisation del action de transcodification',
	'timedmedia-source-file' => 'original $1',
	'timedmedia-source-file-desc' => 'Original $1, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Video Ogg a basse largor de banda (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Video Ogg transmissibile per fluxo web (360P)',
	'timedmedia-derivative-desc-480p.ogv' => 'Video Ogg transmissibile per fluxo web (480P)',
	'timedmedia-derivative-desc-720p.ogv' => 'Video Ogg discargabile de alte qualitate (720P)',
	'timedmedia-derivative-desc-360p.webm' => 'WebM transmissibile per fluxo web (360P)',
	'timedmedia-derivative-desc-480p.webm' => 'WebM transmissibile per fluxo web (480P)',
	'timedmedia-derivative-desc-720p.webm' => 'WebM discargabile de alte qualitate (720P)',
	'timedmedia-subtitle-language' => '$1 ($2) subtitulos',
	'timedmedia-subtitle-no-video' => 'Il non ha video associate con le actual pagina de subtitulos',
	'timedmedia-subtitle-no-subtitles' => 'Il ha actualmente nulle subtitulos in $1 pro iste video. Tu pote [{{fullurl:{{FULLPAGENAME}}|action=edit}} modificar iste pagina] pro adder los.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'timedmedia-desc' => 'Pemroses audio, video, dan teks berwaktu, dengan dukungan format WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Berkas suara $1 ogg, $2',
	'timedmedia-ogg-short-video' => 'Berkas video $1 ogg, $2',
	'timedmedia-ogg-short-general' => 'Berkas media $1 ogg, $2',
	'timedmedia-ogg-long-audio' => 'Berkas suara $1 ogg, panjang $2, $3',
	'timedmedia-ogg-long-video' => 'Berkas video $1 ogg, panjang $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Berkas audio/video multiplexed ogg, $1, panjang $2, $4×$5 piksel, $3 keseluruhan',
	'timedmedia-ogg-long-general' => 'Berkas media ogg, panjang $2, $3',
	'timedmedia-ogg-long-error' => 'Berkas ogg tak valid: $1',
	'timedmedia-webm-short-video' => 'Berkas video $1 WebM, $2',
	'timedmedia-webm-long-video' => 'Berkas audio/video WebM, $1, lama $2, $4 × $5 piksel, $3 keseluruhan',
	'timedmedia-no-player-js' => 'Maaf, peramban Anda memiliki JavaScript yang dinonaktifkan atau tidak memiliki pemutar media apapun.<br />
Anda dapat <a href="$1">mengunduh klip</a> atau <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">mengunduh pemutar</a> untuk memutar klip di peramban Anda.',
	'timedmedia-more' => 'Lainnya...',
	'timedmedia-dismiss' => 'Tutup',
	'timedmedia-download' => 'Unduh berkas',
	'timedmedia-play-media' => 'Putar media',
	'timedmedia-desc-link' => 'Mengenai berkas ini',
	'timedmedia-oggThumb-version' => 'OggHandler membutuhkan oggThumb versi $1 atau terbaru.',
	'timedmedia-oggThumb-failed' => 'oggThumb gagal membuat miniatur gambar.',
	'timedmedia-source-file' => 'Sumber $1',
	'timedmedia-source-file-desc' => '$1 asli, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Video Ogg lebar pita rendah (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Video Ogg aliran web (360P)',
	'timedmedia-derivative-desc-480p.ogv' => 'Video Ogg aliran web (480P)',
	'timedmedia-derivative-desc-720p.ogv' => 'Video Ogg unduhan berkualitas tinggi (720P)',
	'timedmedia-derivative-desc-360p.webm' => 'WebM aliran web (360P)',
	'timedmedia-derivative-desc-480p.webm' => 'WebM aliran web (480P)',
	'timedmedia-derivative-desc-720p.webm' => 'WebM unduhan berkualitas tinggi (720P)',
	'timedmedia-subtitle-language' => 'Teks film $1 ($2)',
	'timedmedia-subtitle-no-video' => 'Tidak ada video yang terkait dengan halaman subjudul ini',
	'timedmedia-subtitle-no-subtitles' => 'Saat ini tidak ada subjudul $1 untuk video ini. Anda dapat [{{fullurl: {{FULLPAGENAME}}|action = edit}} menyunting halaman ini] untuk menambahkannya',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'timedmedia-ogg-long-error' => 'Ne-valida Ogg-arkivo: $1',
	'timedmedia-more' => 'Plus…',
	'timedmedia-dismiss' => 'Klozar',
	'timedmedia-desc-link' => 'Pri ca arkivo',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Spacebirdy
 */
$messages['is'] = array(
	'timedmedia-more' => 'Meira...',
	'timedmedia-dismiss' => 'Loka',
	'timedmedia-download' => 'Sækja skrá',
);

/** Italian (Italiano)
 * @author .anaconda
 * @author Beta16
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'timedmedia-desc' => 'Gestore per i file Ogg Theora e Vorbis, con programma di riproduzione in JavaScript',
	'timedmedia-ogg-short-audio' => 'File audio Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'File video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'File multimediale Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'File audio Ogg $1, durata $2, $3',
	'timedmedia-ogg-long-video' => 'File video Ogg $1, durata $2, dimensioni $4×$5 pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'File audio/video multiplexed Ogg $1, durata $2, dimensioni $4×$5 pixel, complessivamente $3',
	'timedmedia-ogg-long-general' => 'File multimediale Ogg, durata $2, $3',
	'timedmedia-ogg-long-error' => 'File ogg non valido: $1',
	'timedmedia-more' => 'Altro...',
	'timedmedia-dismiss' => 'Chiudi',
	'timedmedia-download' => 'Scarica il file',
	'timedmedia-desc-link' => 'Informazioni su questo file',
	'timedmedia-source-file-desc' => 'Originale $1, $2 × $3 ($4)',
	'timedmedia-subtitle-language' => '$1 ($2) sottotitoli',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Kahusi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'timedmedia-desc' => 'Theora および Vorbis 形式の Ogg ファイルハンドラーと JavaScript プレイヤー',
	'timedmedia-ogg-short-audio' => 'Ogg $1 音声ファイル、$2',
	'timedmedia-ogg-short-video' => 'Ogg $1 動画ファイル、$2',
	'timedmedia-ogg-short-general' => 'Ogg $1 メディアファイル、$2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 音声ファイル、長さ $2、$3',
	'timedmedia-ogg-long-video' => 'Ogg $1 動画ファイル、長さ $2、$4×$5px、$3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg 多重音声/動画ファイル、$1、長さ $2、$4×$5 ピクセル、$3',
	'timedmedia-ogg-long-general' => 'Ogg メディアファイル、長さ $2、$3',
	'timedmedia-ogg-long-error' => '無効な Ogg ファイル: $1',
	'timedmedia-no-player-js' => '申し訳ありません。あなたのブラウザはJavaScriptが有効でないか、プレイヤーをサポートしていません。<br />
再生するには、<a href="$1">クリップをダウンロード</a>するか、<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">プレイヤーをダウンロード</a>する必要があります。',
	'timedmedia-more' => 'その他……',
	'timedmedia-dismiss' => '閉じる',
	'timedmedia-download' => 'ファイルをダウンロード',
	'timedmedia-desc-link' => 'ファイルの詳細',
	'timedmedia-oggThumb-version' => 'OggHandler は oggThumb バージョン$1またはそれ以降が必要です。',
	'timedmedia-oggThumb-failed' => 'oggThumb によるサムネイル作成に失敗しました。',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'timedmedia-desc' => 'Håndlær før Ogg Theora og Vorbis filer, ve JavaScript spæler',
	'timedmedia-ogg-short-audio' => 'Ogg $1 sond file, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 video file, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 media file, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 sond file, duråsje $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 video file, duråsje $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg multipleksen audio/video file, $1, duråsje $2, $4×$5 piksler, $3 åverål',
	'timedmedia-ogg-long-general' => 'Ogg $1 media file, duråsje $2, $3',
	'timedmedia-ogg-long-error' => 'Ugyldegt ogg file: $2',
	'timedmedia-more' => 'Mære...',
	'timedmedia-dismiss' => 'Slut',
	'timedmedia-download' => 'Nærlæĝ billet',
	'timedmedia-desc-link' => 'Åver dette file',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'timedmedia-desc' => 'Sing ngurusi berkas Ogg Theora lan Vorbis mawa pamain JavaScript',
	'timedmedia-ogg-short-audio' => 'Berkas swara $1 ogg, $2',
	'timedmedia-ogg-short-video' => 'Berkas vidéo $1 ogg, $2',
	'timedmedia-ogg-short-general' => 'Berkas média $1 ogg, $2',
	'timedmedia-ogg-long-audio' => 'Berkas swara $1 ogg, dawané $2, $3',
	'timedmedia-ogg-long-video' => 'Berkas vidéo $1 ogg, dawané $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Berkas audio/vidéo multiplexed ogg, $1, dawané $2, $4×$5 piksel, $3 gunggungé',
	'timedmedia-ogg-long-general' => 'Berkas média ogg, dawané $2, $3',
	'timedmedia-ogg-long-error' => 'Berkas ogg ora absah: $1',
	'timedmedia-more' => 'Luwih akèh...',
	'timedmedia-dismiss' => 'Tutup',
	'timedmedia-download' => 'Undhuh berkas',
	'timedmedia-desc-link' => 'Prekara berkas iki',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'timedmedia-ogg-short-video' => 'Ogg $1 ვიდეო ფაილი, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 მედია ფაილი, $2',
	'timedmedia-more' => 'მეტი...',
	'timedmedia-dismiss' => 'დახურვა',
	'timedmedia-download' => 'ფაილის ჩამოტვირთვა',
	'timedmedia-desc-link' => 'ამ ფაილის შესახებ',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'timedmedia-ogg-short-audio' => 'Ogg $1 دىبىس فايلى, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 بەينە فايلى, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 تاسپا فايلى, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 دىبىس فايلى, ۇزاقتىعى $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 بەينە فايلى, ۇزاقتىعى $2, $4 × $5 پىيكسەل, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg قۇرامدى دىبىس/بەينە فايلى, $1, ۇزاقتىعى $2, $4 × $5 پىيكسەل, $3 نە بارلىعى',
	'timedmedia-ogg-long-general' => 'Ogg تاسپا فايلى, ۇزاقتىعى $2, $3',
	'timedmedia-ogg-long-error' => 'جارامسىز ogg فايلى: $1',
	'timedmedia-more' => 'كوبىرەك...',
	'timedmedia-dismiss' => 'جابۋ',
	'timedmedia-download' => 'فايلدى جۇكتەۋ',
	'timedmedia-desc-link' => 'بۇل فايل تۋرالى',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'timedmedia-ogg-short-audio' => 'Ogg $1 дыбыс файлы, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 бейне файлы, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 таспа файлы, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 дыбыс файлы, ұзақтығы $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 бейне файлы, ұзақтығы $2, $4 × $5 пиксел, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg құрамды дыбыс/бейне файлы, $1, ұзақтығы $2, $4 × $5 пиксел, $3 не барлығы',
	'timedmedia-ogg-long-general' => 'Ogg таспа файлы, ұзақтығы $2, $3',
	'timedmedia-ogg-long-error' => 'Жарамсыз ogg файлы: $1',
	'timedmedia-more' => 'Көбірек...',
	'timedmedia-dismiss' => 'Жабу',
	'timedmedia-download' => 'Файлды жүктеу',
	'timedmedia-desc-link' => 'Бұл файл туралы',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'timedmedia-ogg-short-audio' => 'Ogg $1 dıbıs faýlı, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 beýne faýlı, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 taspa faýlı, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 dıbıs faýlı, uzaqtığı $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 beýne faýlı, uzaqtığı $2, $4 × $5 pïksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg quramdı dıbıs/beýne faýlı, $1, uzaqtığı $2, $4 × $5 pïksel, $3 ne barlığı',
	'timedmedia-ogg-long-general' => 'Ogg taspa faýlı, uzaqtığı $2, $3',
	'timedmedia-ogg-long-error' => 'Jaramsız ogg faýlı: $1',
	'timedmedia-more' => 'Köbirek...',
	'timedmedia-dismiss' => 'Jabw',
	'timedmedia-download' => 'Faýldı jüktew',
	'timedmedia-desc-link' => 'Bul faýl twralı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author T-Rithy
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'timedmedia-desc' => 'គាំទ្រចំពោះ Ogg Theora និង Vorbis files, ជាមួយ ឧបករណ៍អាន JavaScript',
	'timedmedia-ogg-short-audio' => 'ឯកសារ សំឡេង Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'ឯកសារវីដេអូ Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'ឯកសារមេឌាOgg $1, $2',
	'timedmedia-ogg-long-audio' => 'ឯកសារសំឡេងប្រភេទOgg $1, រយៈពេល$2 និងទំហំ$3',
	'timedmedia-ogg-long-video' => 'ឯកសារវីដេអូប្រភេទOgg $1, រយៈពេល$2, $4×$5px, $3',
	'timedmedia-ogg-long-multiplexed' => 'ឯកសារអូឌីយ៉ូ/វីដេអូចម្រុះប្រភេទOgg , $1, រយៈពេល$2, $4×$5px, ប្រហែល$3',
	'timedmedia-ogg-long-general' => 'ឯកសារមេឌាប្រភេទOgg, រយៈពេល$2, $3',
	'timedmedia-ogg-long-error' => 'ឯកសារ ogg មិនមាន សុពលភាព ៖ $1',
	'timedmedia-more' => 'បន្ថែម...',
	'timedmedia-dismiss' => 'បិទ',
	'timedmedia-download' => 'ទាញយកឯកសារ',
	'timedmedia-desc-link' => 'អំពីឯកសារនេះ',
);

/** Korean (한국어)
 * @author ITurtle
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'timedmedia-desc' => 'OGG Theora 및 Vorbis 파일 핸들러와 자바스크립트 플레이어',
	'timedmedia-ogg-short-audio' => 'Ogg $1 소리 파일, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 영상 파일, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 미디어 파일, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 소리 파일, 길이 $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 영상 파일, 길이 $2, $4×$5 픽셀, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg 다중 소리/영상 파일, $1, 길이 $2, $4×$5 픽셀, 대략 $3',
	'timedmedia-ogg-long-general' => 'Ogg 미디어 파일, 길이 $2, $3',
	'timedmedia-ogg-long-error' => '잘못된 ogg 파일: $1',
	'timedmedia-no-player-js' => '죄송합니다, 당신의 시스템은 자바스크립트를 지원하지 않거나 지원하는 미디어 플레이어가 설치되어 있지 않습니다.<br />
<a href="$1">미디어 클립을 다운로드</a>하거나, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">미디어 플레이어를 다운로드</a>할 수 있습니다.',
	'timedmedia-more' => '더 보기...',
	'timedmedia-dismiss' => '닫기',
	'timedmedia-download' => '파일 다운로드',
	'timedmedia-desc-link' => '파일 정보',
	'timedmedia-oggThumb-version' => 'OggHandler는 oggThumb 버전 $1 이상을 요구합니다.',
	'timedmedia-oggThumb-failed' => 'oggThumb가 섬네일을 생성하지 못했습니다.',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'timedmedia-more' => 'Raku pa...',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'timedmedia-desc' => 'E Projamm (<i lang="en">handler</i>) för Meedije met Zickaandeil
— Viddejos, Tondatteieje, <i lang="en">timedText</i> (Ongertittelle) —
met Ongershtözung för de Fommaate <i lang="en">WebM</i>, <i lang="en">Ogg Theora</i>, <i lang="en">Vorbis</i> un <i lang="en">srt</i>.',
	'timedmedia-ogg-short-audio' => '<i lang="en">Ogg $1</i> Tondatei, $2',
	'timedmedia-ogg-short-video' => '<i lang="en">Ogg $1</i> Viddejodatei, $2',
	'timedmedia-ogg-short-general' => '<i lang="en">Ogg $1</i> Medijedatei, $2',
	'timedmedia-ogg-long-audio' => '<i lang="en">Ogg $1</i> Tondatei fum Ömfang $2, $3',
	'timedmedia-ogg-long-video' => '<i lang="en">Ogg $1</i> Viddejodatei fum Ömfang $2 un {{PLURAL:$4|ein Pixel|$4 Pixelle|kei Pixel}} × {{PLURAL:$5|ei Pixel|$4 Pixelle|kei Pixel}}, $3',
	'timedmedia-ogg-long-multiplexed' => '<i lang="en">Ogg</i> jemultipex Ton- un Viddejodatei, $1, fum Ömfang $2 un {{PLURAL:$4|ein Pixel|$4 Pixelle|kei Pixel}} × {{PLURAL:$5|ei Pixel|$4 Pixelle|kei Pixel}}, $3 ennsjesammp',
	'timedmedia-ogg-long-general' => '<i lang="en">Ogg</i> Medijedatei fum Ömfang $2, $3',
	'timedmedia-ogg-long-error' => 'ene kapodde <i lang="en">Ogg</i> Datei: $1',
	'timedmedia-webm-short-video' => 'En $1 Viddejo-Dattei em WebM-Fommaat vun $2',
	'timedmedia-webm-long-video' => 'Ene Viddejo udder en Toondattei em WebM-Fommaat, $1, $2 jruuß, $4 × $5 Pixelle, $3 enßjesammp',
	'timedmedia-no-player-js' => 'Schad, Dinge Brauser hät entweder JavaSkrepp ußjeschalldt udder kein zopaß Projramm zom Afschpelle.<br />Do kanns jäz <a href="$1">dat Stöck eronger laade</a> udder <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">e Afspeller-Projramm eronger laade</a>, öm dat Schtöck en Dingem Brauser afzeschpelle.',
	'timedmedia-more' => 'Enshtelle&nbsp;…',
	'timedmedia-dismiss' => 'Zohmaache!',
	'timedmedia-download' => 'Datei erunger lade',
	'timedmedia-play-media' => 'Afshpelle',
	'timedmedia-desc-link' => 'Övver di Datei',
	'timedmedia-oggThumb-version' => 'Dä <code lang="en">OggHandler</code> bruch <code lang="en">oggThumb</code> in dä Version $1 udder hüüter.',
	'timedmedia-oggThumb-failed' => '<code lang="en">oggThumb</code> kunnt kei MiniBelldsche maache.',
	'timedmedia-source-file' => 'Quell-Dattei em $1-Fommaat',
	'timedmedia-source-file-desc' => 'Ojinaal $1-Dattei, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'En Viddejo-Dattei met winnesch Bandbreide (160P) em <i lang="en">Ogg</i>-Fommaat',
	'timedmedia-derivative-desc-360p.ogv' => 'En Viddejo-Dattei em <i lang="en">Ogg</i>-Fommaat (360p) för ene Dahteshtrohm övver et Nez',
	'timedmedia-derivative-desc-480p.ogv' => 'En Viddejo-Dattei (met 480p) em <i lang="en">Ogg</i>-Fommaat för ene Dahteshtrohm övver et Nez',
	'timedmedia-derivative-desc-720p.ogv' => 'En Viddejo-Dattei met huhe Qualiteit (met 720p) em <i lang="en">Ogg</i>-Fommaat zom eronger laade',
	'timedmedia-derivative-desc-360p.webm' => 'Ene WebM Viddejo (met 360p) för ene Dahteshtrohm övver et Nez',
	'timedmedia-derivative-desc-480p.webm' => 'Ene WebM Viddejo (met 480p) för ene Dahteshtrohm övver et Nez',
	'timedmedia-derivative-desc-720p.webm' => 'En <i lang="en">WebM</i> Viddejo-Dattei met huhe Qualiteit (met 720p) zom eronger laade',
	'timedmedia-subtitle-language' => 'Ongertittele en $1 ($2)',
);

/** Latin (Latina)
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'timedmedia-more' => 'Plus…',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'timedmedia-desc' => "Steierungsprogramm fir Audio, Video an 'timed text', mat Ënnerstëtzung vun de Formater WebM, Ogg Theora, Vorbis, srt",
	'timedmedia-ogg-short-audio' => 'Ogg-$1-Tounfichier, $2',
	'timedmedia-ogg-short-video' => 'Ogg-$1-Videofichier, $2',
	'timedmedia-ogg-short-general' => 'Ogg-$1-Mediefichier, $2',
	'timedmedia-ogg-long-audio' => 'tmh-$1-Tounfichier, Dauer: $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg-$1-Videofichier, Dauer: $2, $4×$5 Pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg-Toun-/Video-Fichier, $1, Dauer: $2, $4×$5 Pixel, $3',
	'timedmedia-ogg-long-general' => 'Ogg Media-Fichier, Dauer $2, $3',
	'timedmedia-ogg-long-error' => 'Ongëltegen Ogg-Fichier: $1',
	'timedmedia-no-player-js' => 'Pardon, Äre Browser huet entweder JavaScript ausgeschalt oder en huet kee Player-Programm deen ënnerstëtzt gëtt.<br />
Dir kënnt <a href="$1"> de Clip eroflueden</a> oder <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">e Player-Programm erofluede</a> fir de Clip an Ärem Browser ze spillen.',
	'timedmedia-more' => 'Méi ...',
	'timedmedia-dismiss' => 'Zoumaachen',
	'timedmedia-download' => 'Fichier eroflueden',
	'timedmedia-desc-link' => 'Iwwer dëse Fichier',
	'timedmedia-oggThumb-version' => "Den OggHandler brauch d'Versioun $1 (oder méi eng nei Versioun) vun OggThumb.",
	'timedmedia-oggThumb-failed' => "oggThumb konnt d'Miniaturbild (thumbnail) net uleeën.",
	'timedmedia-actions' => 'Aktiounen',
	'timedmedia-not-ready' => 'Net fäerdeg',
	'timedmedia-percent-done' => 'Ongeféier $1% fäerdeg',
	'timedmedia-days' => '{{PLURAL:$1|Dag|$1 Deeg}}',
	'timedmedia-hours' => '{{PLURAL:$1|Stonn|$1 Stonnen}}',
	'timedmedia-minutes' => '{{PLURAL:$1|Minutt|$1 Minutten}}',
	'timedmedia-seconds' => '{{PLURAL:$1|Sekonn|$1 Sekonnen}}',
	'timedmedia-show-error' => 'Feeler weisen',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'timedmedia-more' => 'Plu…',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'timedmedia-desc' => "Handelt Ogg Theora- en Vorbis-bestande aaf met 'n JavaScript-mediaspeler",
	'timedmedia-ogg-short-audio' => 'Ogg $1 geluidsbestandj, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videobestandj, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 mediabestandj, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 geluidsbestandj, lingdje $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videobestandj, lingdje $2, $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg gemultiplexeerd geluids-/videobestandj, $1, lingdje $2, $4×$5 pixels, $3 totaal',
	'timedmedia-ogg-long-general' => 'Ogg mediabestandj, lingdje $2, $3',
	'timedmedia-ogg-long-error' => 'Óngeljig oggg-bestandj: $1',
	'timedmedia-more' => 'Mieë...',
	'timedmedia-dismiss' => 'Sloet',
	'timedmedia-download' => 'Bestandj downloade',
	'timedmedia-desc-link' => 'Euver dit bestandj',
);

/** Lithuanian (Lietuvių)
 * @author Homo
 * @author Matasg
 */
$messages['lt'] = array(
	'timedmedia-desc' => 'Įrankis groti Ogg Theora ir Vorbis failus su JavaScript grotuvu',
	'timedmedia-ogg-short-audio' => 'Ogg $1 garso byla, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 video byla, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 medija byla, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 garso byla, ilgis $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 video byla, ilgis $2, $4×$5 pikseliai, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg sutankinta audio/video byla, $1, ilgis $2, $4×$5 pikseliai, $3 viso',
	'timedmedia-ogg-long-general' => 'Ogg media byla, ilgis $2, $3',
	'timedmedia-ogg-long-error' => 'Bloga ogg byla: $1',
	'timedmedia-more' => 'Daugiau...',
	'timedmedia-dismiss' => 'Uždaryti',
	'timedmedia-download' => 'Atsisiųsti bylą',
	'timedmedia-desc-link' => 'Apie šią bylą',
);

/** Latvian (Latviešu)
 * @author Xil
 */
$messages['lv'] = array(
	'timedmedia-dismiss' => 'Aizvērt',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'timedmedia-desc' => 'Обработувач за аудио, видео и синхронизиран текст, со поддршка за форматите WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Ogg $1 звучна податотека, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 видео податотека, $2',
	'timedmedia-ogg-short-general' => 'Мултимедијална податотека Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 звучна податотека, времетраење $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 видео податотека, времетраење $2, $4 × $5 пиксели, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg мултиплексирана аудио/видео податотека, $1, времетраење $2, $4 × $5 пиксели, вкупно $3',
	'timedmedia-ogg-long-general' => 'Мултимедијална податотека Ogg, времетраење $2, $3',
	'timedmedia-ogg-long-error' => 'Оштетена ogg податотека: $1',
	'timedmedia-webm-short-video' => 'WebM $1 видеоснимка, $2',
	'timedmedia-webm-long-video' => 'WebM аудио/видео снимка, $1, должина: $2, $4 × $5 пиксели, вкупно $3',
	'timedmedia-no-player-js' => 'Нажалост, вашиот прелистувач или има оневозможено JavaScript, или нема ниту еден поддржан изведувач.<br />
Можете да го <a href="$1">преземете клипот</a> или <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">да преземете изведувач</a> за да ја пуштите снимката во вашиот прелистувач.',
	'timedmedia-more' => 'Повеќе...',
	'timedmedia-dismiss' => 'Затвори',
	'timedmedia-download' => 'Преземи податотека',
	'timedmedia-play-media' => 'Пушти снимка',
	'timedmedia-desc-link' => 'Информации за оваа податотека',
	'timedmedia-oggThumb-version' => 'OggHandler бара oggThumb верзија $1 или понова.',
	'timedmedia-oggThumb-failed' => 'oggThumb не успеа да ја создаде минијатурата.',
	'timedmedia-status-header' => 'Статус на прекодирањето',
	'timedmedia-update-status' => 'Поднови статус на прекодирање',
	'timedmedia-status' => 'статус',
	'timedmedia-status-unknown' => 'Непознат статус',
	'timedmedia-transcodeinfo' => 'Опис на изводот од прекодирањето',
	'timedmedia-actions' => 'Дејства',
	'timedmedia-direct-link' => 'Преземи изведено',
	'timedmedia-not-ready' => 'Не е готово',
	'timedmedia-completed-on' => 'Прекодирањето е завршено $1',
	'timedmedia-error-on' => 'Грешка при прекодирањето на $1.',
	'timedmedia-started-transcode' => 'Прекодирањето започна пред $1. $2',
	'timedmedia-percent-done' => 'Сработено: околу $1%',
	'timedmedia-in-job-queue' => 'Додадено во редицата на задачи пред $1',
	'timedmedia-unknown-target-size' => 'Непозната целна големина. $1 е шифрирано',
	'timedmedia-days' => '{{PLURAL:$1|ден|$1 дена}}',
	'timedmedia-hours' => '{{PLURAL:$1|час|$1 часа}}',
	'timedmedia-minutes' => '{{PLURAL:$1|минута|$1 минути}}',
	'timedmedia-seconds' => '{{PLURAL:$1|секунда|$1 секунди}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 и $4',
	'timedmedia-time-3-measurements' => '$1, $2 и $3',
	'timedmedia-time-2-measurements' => '$1 и $2',
	'timedmedia-show-error' => 'Покажи ја грешката',
	'timedmedia-reset' => 'Одново',
	'timedmedia-reset-confirm' => 'Враќајќи го ова прекодирање одново ќе ја отстраните постоечката податотека (ако ја има) и ќе го вратите прекодирањето во редицата на задачи. Повторното прекодирање ќе потрае. <br /><br />Дали сте сигурни дека сакате да продолжите?',
	'timedmedia-reset-error' => 'Грешка при враќањето одново на задачата за транскодирање',
	'timedmedia-ogg' => 'Ogg',
	'timedmedia-webm' => 'WebM',
	'timedmedia-source-file' => 'Извор на $1',
	'timedmedia-source-file-desc' => 'Изворен $1, $2 × $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg 160п',
	'timedmedia-derivative-desc-160p.ogv' => 'Нископропусно Ogg-видео (160п)',
	'timedmedia-derivative-360p.ogv' => 'Ogg 360п',
	'timedmedia-derivative-desc-360p.ogv' => 'Ogg-видео за емитување (360 пиксели)',
	'timedmedia-derivative-480p.ogv' => 'Ogg 480п',
	'timedmedia-derivative-desc-480p.ogv' => 'Ogg-видео за емитување (480 пиксели)',
	'timedmedia-derivative-720p.ogv' => 'Ogg 720п',
	'timedmedia-derivative-desc-720p.ogv' => 'Висококвалитетно Ogg-видео за преземање (720п)',
	'timedmedia-derivative-360p.webm' => 'WebM 360п',
	'timedmedia-derivative-desc-360p.webm' => 'WebM за каналско емитување (360п)',
	'timedmedia-derivative-480p.webm' => 'Висококвалитетен WebM за преземање (720п)',
	'timedmedia-derivative-desc-480p.webm' => 'Висококвалитетен WebM за преземање (720п)',
	'timedmedia-derivative-720p.webm' => 'WebM 720п',
	'timedmedia-derivative-desc-720p.webm' => 'Висококвалитетен WebM за преземање (720п)',
	'timedmedia-subtitle-language' => '$1 ($2) титлови',
	'timedmedia-subtitle-no-video' => 'Нема видеоснимка поврзана со тековната страница со титлови',
	'timedmedia-subtitle-no-subtitles' => 'Моментално нема $1 титлови за оваа видеоснимка. Можете да ги додадете [{{fullurl:{{FULLPAGENAME}}|action=edit}} уредувајќи ја страницава]',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'timedmedia-desc' => 'ജാവാസ്ക്രിപ്റ്റ് പ്ലേയർ ഉപയോഗിച്ച് ഓഗ് തിയോറ, വോർബിസ് പ്രമാണങ്ങൾ കൈകാര്യം ചെയ്യൽ',
	'timedmedia-ogg-short-audio' => 'ഓഗ് $1 ശബ്ദപ്രമാണം, $2',
	'timedmedia-ogg-short-video' => 'ഓഗ് $1 വീഡിയോ പ്രമാണം, $2',
	'timedmedia-ogg-short-general' => 'ഓഗ് $1 മീഡിയ പ്രമാണം, $2',
	'timedmedia-ogg-long-audio' => 'ഓഗ് $1 ശബ്ദ പ്രമാണം, ദൈർഘ്യം $2, $3',
	'timedmedia-ogg-long-video' => 'ഓഗ് $1 വീഡിയോ പ്രമാണം, ദൈർഘ്യം $2, $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'ഓഗ് മൾട്ടിപ്ലക്സ്‌‌ഡ് ശബ്ദ/ചലച്ചിത്ര പ്രമാണം, $1, ദൈർഘ്യം $2, $4×$5 ബിന്ദു, ആകെക്കൂടി $3',
	'timedmedia-ogg-long-general' => 'ഓഗ് മീഡിയ പ്രമാണം, ദൈർഘ്യം $2, $3',
	'timedmedia-ogg-long-error' => 'അസാധുവായ ഓഗ് പ്രമാണം: $1',
	'timedmedia-more' => 'കൂടുതൽ...',
	'timedmedia-dismiss' => 'അടയ്ക്കുക',
	'timedmedia-download' => 'പ്രമാണം ഡൗൺലോഡ് ചെയ്യുക',
	'timedmedia-desc-link' => 'ഈ പ്രമാണത്തെക്കുറിച്ച്',
	'timedmedia-oggThumb-version' => 'ഓഗ്-തമ്പ് പതിപ്പ് $1 അല്ലെങ്കിൽ പുതിയത് ഓഗ്-ഹാൻഡ്ലറിനാവശ്യമാണ്.',
	'timedmedia-oggThumb-failed' => 'ലഘുചിത്രം സൃഷ്ടിക്കുന്നതിൽ ഓഗ്-തമ്പ് പരാജയപ്പെട്ടു.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'timedmedia-desc' => 'ऑग थियोरा व वॉर्बिस संचिकांसाठीचा चालक, जावास्क्रीप्ट प्लेयर सकट',
	'timedmedia-ogg-short-audio' => 'ऑग $1 ध्वनी संचिका, $2',
	'timedmedia-ogg-short-video' => 'ऑग $1 चलतचित्र संचिका, $2',
	'timedmedia-ogg-short-general' => 'ऑग $1 मीडिया संचिका, $2',
	'timedmedia-ogg-long-audio' => 'ऑग $1 ध्वनी संचिका, लांबी $2, $3',
	'timedmedia-ogg-long-video' => 'ऑग $1 चलतचित्र संचिका, लांबी $2, $4×$5 पीक्सेल्स, $3',
	'timedmedia-ogg-long-multiplexed' => 'ऑग ध्वनी/चित्र संचिका, $1, लांबी $2, $4×$5 पिक्सेल्स, $3 एकूण',
	'timedmedia-ogg-long-general' => 'ऑग मीडिया संचिका, लांबी $2, $3',
	'timedmedia-ogg-long-error' => 'चुकीची ऑग संचिका: $1',
	'timedmedia-more' => 'आणखी...',
	'timedmedia-dismiss' => 'बंद करा',
	'timedmedia-download' => 'संचिका उतरवा',
	'timedmedia-desc-link' => 'या संचिकेबद्दलची माहिती',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'timedmedia-desc' => 'Pemproses audio, video dan teks bermasa, dengan sokongan format untuk WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'fail bunyi Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'fail video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'fail media Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'fail bunyi Ogg $1, tempoh $2, $3',
	'timedmedia-ogg-long-video' => 'fail video Ogg $1, tempoh $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'fail audio/video multipleks Ogg, $1, tempoh $2, $4×$5 piksel, keseluruhan $3',
	'timedmedia-ogg-long-general' => 'fail media Ogg, tempoh $2, $3',
	'timedmedia-ogg-long-error' => 'Fail Ogg tidak sah: $1',
	'timedmedia-more' => 'Lagi…',
	'timedmedia-dismiss' => 'Tutup',
	'timedmedia-download' => 'Muat turun fail',
	'timedmedia-play-media' => 'Mainkan media',
	'timedmedia-desc-link' => 'Perihal fail ini',
	'timedmedia-source-file' => 'Sumber $1',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'timedmedia-more' => 'Седе ламо...',
	'timedmedia-dismiss' => 'Пекстамс',
	'timedmedia-download' => 'Таргамо файла',
	'timedmedia-play-media' => 'Седямо медия',
	'timedmedia-desc-link' => 'Те файладонть',
	'timedmedia-show-error' => 'Невтемс манявкс',
	'timedmedia-source-file' => '$1 лисьмапря',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'timedmedia-more' => 'Huehca ōmpa...',
	'timedmedia-download' => 'Tictemōz tlahcuilōlli',
	'timedmedia-desc-link' => 'Inīn tlahcuilōltechcopa',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'timedmedia-desc' => 'Håndteringsprogram for lyd, video og tidsbestemt tekst, med formatstøtte for WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Ogg $1 lydfil, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videofil, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 mediefil, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 lydfil, lengde $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videofil, lengde $2, $4×$5 piksler, $3',
	'timedmedia-ogg-long-multiplexed' => 'Sammensatt ogg lyd-/videofil, $1, lengde $2, $4×$5 piksler, $3 til sammen',
	'timedmedia-ogg-long-general' => 'Ogg mediefil, lengde $2, $3',
	'timedmedia-ogg-long-error' => 'Ugyldig Ogg-fil: $1',
	'timedmedia-webm-short-video' => 'WebM $1 videofil, $2',
	'timedmedia-webm-long-video' => 'WebM lyd-/videofil, $1, lengde $2, $4 × $5 piksler, $3 til sammen',
	'timedmedia-no-player-js' => 'Beklager, nettleseren din har enten deaktivert JavaScript eller har ingen støttet spiller.<br />
Du kan <a href="$1">laste ned klippet</a> eller <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">laste ned en spiller</a> for å spille av klippet i nettleseren din.',
	'timedmedia-more' => 'Mer …',
	'timedmedia-dismiss' => 'Lukk',
	'timedmedia-download' => 'Last ned fil',
	'timedmedia-play-media' => 'Spill av media',
	'timedmedia-desc-link' => 'Om denne filen',
	'timedmedia-oggThumb-version' => 'OggHandler krever oggThumb versjon $1 eller senere.',
	'timedmedia-oggThumb-failed' => 'oggThumb klarte ikke å opprette miniatyrbildet.',
	'timedmedia-source-file' => '$1 kilde',
	'timedmedia-source-file-desc' => 'Original $1, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Lav båndbredde Ogg-video (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Nett-strømbar Ogg-video (360P)',
	'timedmedia-derivative-desc-480p.ogv' => 'Nett-strømbar Ogg-video (480P)',
	'timedmedia-derivative-desc-720p.ogv' => 'Høykvalitets nedlastbar Ogg-video (720P)',
	'timedmedia-derivative-desc-360p.webm' => 'Nett-strømbar WebM (360P)',
	'timedmedia-derivative-desc-480p.webm' => 'Nett-strømbar WebM (480P)',
	'timedmedia-derivative-desc-720p.webm' => 'Høykvalitets nedlastbar WebM (720P)',
	'timedmedia-subtitle-language' => '$1 ($2) undertekster',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'timedmedia-desc' => 'Stüürprogramm för Ogg-Theora- un Vorbis Datein, mitsamt en Afspeler in JavaScript',
	'timedmedia-ogg-short-audio' => 'Ogg-$1-Toondatei, $2',
	'timedmedia-ogg-short-video' => 'Ogg-$1-Videodatei, $2',
	'timedmedia-ogg-short-general' => 'Ogg-$1-Mediendatei, $2',
	'timedmedia-ogg-long-audio' => 'Ogg-$1-Toondatei, $2 lang, $3',
	'timedmedia-ogg-long-video' => 'Ogg-$1-Videodatei, $2 lang, $4×$5 Pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg-Multiplexed-Audio-/Video-Datei, $1, $2 lang, $4×$5 Pixels, $3 alltohoop',
	'timedmedia-ogg-long-general' => 'Ogg-Mediendatei, $2 lang, $3',
	'timedmedia-ogg-long-error' => 'Kaputte Ogg-Datei: $1',
	'timedmedia-more' => 'Mehr...',
	'timedmedia-dismiss' => 'Dichtmaken',
	'timedmedia-download' => 'Datei dalladen',
	'timedmedia-desc-link' => 'Över disse Datei',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'timedmedia-desc' => 'Haandelt veur Ogg Theora- en Vorbis-bestaanden, mit JavaScript-mediaspeuler',
	'timedmedia-ogg-short-audio' => 'Ogg $1 geluudsbestaand, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videobestaand, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 mediabestaand, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 geluudsbestaand, lengte $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videobestaand, lengte $2, $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg-emultiplext geluuds-/videobestaand, $1, lengte $2, $4×$5 pixels, $3 totaal',
	'timedmedia-ogg-long-general' => 'Ogg-mediabestaand, lengte $2, $3',
	'timedmedia-ogg-long-error' => 'Ongeldig Ogg-bestaand: $1',
	'timedmedia-more' => 'Meer...',
	'timedmedia-dismiss' => 'Sluten',
	'timedmedia-download' => 'Bestaand binnenhaolen',
	'timedmedia-desc-link' => 'Over dit bestaand',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'timedmedia-desc' => 'Handelt audio, video en ondertitels af met ondersteuning voor WebM, Ogg Theora, Vorbis en srt',
	'timedmedia-ogg-short-audio' => 'Ogg $1 geluidsbestand, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videobestand, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 mediabestand, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 geluidsbestand, lengte $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videobestand, lengte $2, $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg gemultiplexed geluids/videobestand, $1, lengte $2, $4×$5 pixels, $3 totaal',
	'timedmedia-ogg-long-general' => 'Ogg mediabestand, lengte $2, $3',
	'timedmedia-ogg-long-error' => 'Ongeldig Ogg-bestand: $1',
	'timedmedia-webm-short-video' => 'WebM $1 videobestand, $2',
	'timedmedia-webm-long-video' => 'WebM audio/videobestand, $1, lengte $2, $4x$5 pixels, $3 totaal',
	'timedmedia-no-player-js' => 'Uw systeem heeft JavaScript uitgeschakeld of er is geen ondersteunde mediaspeler.<br />
U kunt <a href="$1">de clip downloaden</a> of <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">een mediaspeler downloaden</a> om de clip af te spelen in uw browser.',
	'timedmedia-more' => 'Meer…',
	'timedmedia-dismiss' => 'Sluiten',
	'timedmedia-download' => 'Bestand downloaden',
	'timedmedia-play-media' => 'Media afspelen',
	'timedmedia-desc-link' => 'Over dit bestand',
	'timedmedia-oggThumb-version' => 'OggHandler vereist oggThumb versie $1 of hoger.',
	'timedmedia-oggThumb-failed' => 'oggThumb kon geen miniatuur aanmaken.',
	'timedmedia-status-header' => 'Conversiestatus',
	'timedmedia-update-status' => 'Conversiestatus bijwerken',
	'timedmedia-status' => 'status',
	'timedmedia-status-unknown' => 'onbekende status',
	'timedmedia-transcodeinfo' => 'Beschrijving van afgeleide conversie',
	'timedmedia-actions' => 'handelingen',
	'timedmedia-direct-link' => 'Afgeleid werk downloaden',
	'timedmedia-not-ready' => 'Niet klaar',
	'timedmedia-completed-on' => 'Conversie voltooid op $1',
	'timedmedia-error-on' => 'Fout in de conversie om $1.',
	'timedmedia-started-transcode' => 'De conversie is $1 geleden begonnen. $2',
	'timedmedia-percent-done' => 'Ongeveer $1% afgerond',
	'timedmedia-in-job-queue' => '$1 geleden toegevoegd aan de Job queue',
	'timedmedia-unknown-target-size' => 'Onbekende doelgrootte, $1 gecodeerd',
	'timedmedia-days' => '{{PLURAL:$1|dag|$1 dagen}}',
	'timedmedia-hours' => '{{PLURAL:$1|uur|$1 uur}}',
	'timedmedia-minutes' => '{{PLURAL:$1|minuut|$1 minuten}}',
	'timedmedia-seconds' => '{{PLURAL:$1|seconde|$1 seconden}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 en $4',
	'timedmedia-time-3-measurements' => '$1, $2 en $3',
	'timedmedia-time-2-measurements' => '$1 en $2',
	'timedmedia-show-error' => 'Foutmelding weergeven',
	'timedmedia-reset' => 'Transcodering opnieuw instellen',
	'timedmedia-reset-confirm' => 'Door de transcodering opnieuw in te stellen worden alle bestanden bestanden (als aanwezig) verwijderd en de transcodering wordt opnieuw toegevoegd aan de wachtrij. Transcoderen kost tijd.<br /><br />
Weet u zeker dat u wilt doorgaan?',
	'timedmedia-reset-error' => 'Er is een fout opgetreden tijdens het opnieuw instellen van de transcoderingstaak.',
	'timedmedia-ogg' => 'Ogg',
	'timedmedia-webm' => 'WebM',
	'timedmedia-source-file' => 'Bron van $1',
	'timedmedia-source-file-desc' => 'Origineel $1, $2 × $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg 160P',
	'timedmedia-derivative-desc-160p.ogv' => 'Lage bandbreedte Ogg video (160P)',
	'timedmedia-derivative-360p.ogv' => 'Ogg 360P',
	'timedmedia-derivative-desc-360p.ogv' => 'Te webstreamen Off video (360P)',
	'timedmedia-derivative-480p.ogv' => 'Ogg 480P',
	'timedmedia-derivative-desc-480p.ogv' => 'Te webstreamen Ogg video (480P)',
	'timedmedia-derivative-720p.ogv' => 'Ogg 720P',
	'timedmedia-derivative-desc-720p.ogv' => 'Hoge kwaliteit downloadbare Ogg video (720P)',
	'timedmedia-derivative-360p.webm' => 'WebM 360P',
	'timedmedia-derivative-desc-360p.webm' => 'Web streamable WebM (360P)',
	'timedmedia-derivative-480p.webm' => 'WebM 480P',
	'timedmedia-derivative-desc-480p.webm' => 'Via web te streamen WebM (480P)',
	'timedmedia-derivative-720p.webm' => 'WebM 720P',
	'timedmedia-derivative-desc-720p.webm' => 'Hoge kwaliteit downloadbare WebM (720P)',
	'timedmedia-subtitle-language' => 'Ondertitels in $1 ($2)',
	'timedmedia-subtitle-no-video' => 'Er is geen video gekoppeld aan de huidige ondertitelpagina',
	'timedmedia-subtitle-no-subtitles' => 'Er zijn op het moment geen ondertitels in het $1 voor deze video. U kunt [{{fullurl:{{FULLPAGENAME}}|action=edit}} deze pagina bewerken] om ze toe te voegen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Harald Khan
 */
$messages['nn'] = array(
	'timedmedia-desc' => 'Gjer at Ogg Theora- og Ogg Vorbis-filer kan verta køyrte ved hjelp av JavaScript-avspelar.',
	'timedmedia-ogg-short-audio' => 'Ogg $1-lydfil, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1-videofil, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1-mediafil, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1-lydfil, lengd $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1-videofil, lengd $2, $4×$5 pikslar, $3',
	'timedmedia-ogg-long-multiplexed' => 'Samansett ogg lyd-/videofil, $1, lengd $2, $4×$5 pikslar, $3 til saman',
	'timedmedia-ogg-long-general' => 'Ogg mediafil, lengd $2, $3',
	'timedmedia-ogg-long-error' => 'Ugyldig Ogg-fil: $1',
	'timedmedia-more' => 'Meir...',
	'timedmedia-dismiss' => 'Lat att',
	'timedmedia-download' => 'Last ned fila',
	'timedmedia-desc-link' => 'Om denne fila',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'timedmedia-desc' => 'Supòrt pels fichièrs Ogg Theora e Vorbis, amb un lector Javascript',
	'timedmedia-ogg-short-audio' => 'Fichièr son Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Fichièr vidèo Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Fichièr mèdia Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Fichièr son Ogg $1, durada $2, $3',
	'timedmedia-ogg-long-video' => 'Fichièr vidèo Ogg $1, durada $2, $4×$5 pixèls, $3',
	'timedmedia-ogg-long-multiplexed' => 'Fichièr multiplexat àudio/vidèo Ogg, $1, durada $2, $4×$5 pixèls, $3',
	'timedmedia-ogg-long-general' => 'Fichièr mèdia Ogg, durada $2, $3',
	'timedmedia-ogg-long-error' => 'Fichièr Ogg invalid : $1',
	'timedmedia-more' => 'Mai…',
	'timedmedia-dismiss' => 'Tampar',
	'timedmedia-download' => 'Telecargar lo fichièr',
	'timedmedia-desc-link' => "A prepaus d'aqueste fichièr",
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'timedmedia-more' => 'Фылдæр…',
	'timedmedia-download' => 'Файл æрбавгæн',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Gman124
 */
$messages['pa'] = array(
	'timedmedia-more' => 'ਹੋਰ...',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'timedmedia-more' => 'Mehr…',
	'timedmedia-download' => 'Feil runnerlaade',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'timedmedia-desc' => 'Obsługa plików audio, wideo i napisów filmowych w formatach WebM, Ogg Theora, Vorbis i srt',
	'timedmedia-ogg-short-audio' => 'Plik dźwiękowy Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Plik wideo Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Plik multimedialny Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'plik dźwiękowy Ogg $1, długość $2, $3',
	'timedmedia-ogg-long-video' => 'plik wideo Ogg $1, długość $2, rozdzielczość $4×$5, $3',
	'timedmedia-ogg-long-multiplexed' => 'plik audio/wideo Ogg, $1, długość $2, rozdzielczość $4×$5, ogółem $3',
	'timedmedia-ogg-long-general' => 'plik multimedialny Ogg, długość $2, $3',
	'timedmedia-ogg-long-error' => 'niepoprawny plik Ogg: $1',
	'timedmedia-no-player-js' => 'Niestety, Twoja przeglądarka ma wyłączoną obsługę JavaScript lub nie wspiera odtwarzania.<br />
Możesz <a href="$1">pobrać plik</a> lub <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">pobrać odtwarzacz</a> pozwalający oglądać wideo w przeglądarce.',
	'timedmedia-more' => 'Więcej...',
	'timedmedia-dismiss' => 'Zamknij',
	'timedmedia-download' => 'Pobierz plik',
	'timedmedia-desc-link' => 'Właściwości pliku',
	'timedmedia-oggThumb-version' => 'OggHandler wymaga oggThumb w wersji $1 lub późniejszej.',
	'timedmedia-oggThumb-failed' => 'oggThumb nie udało się utworzyć miniaturki.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'timedmedia-desc' => 'Gestor për ij son, filmà e test a sincronisà, con manteniment dij formà për WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Registrassion Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Film Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Archivi Multimojen Ogg $1, $2',
	'timedmedia-ogg-long-audio' => "Registrassion Ogg $1, ch'a dura $2, $3",
	'timedmedia-ogg-long-video' => "Film Ogg $1, ch'a dura $2, formà $4×$5 px, $3",
	'timedmedia-ogg-long-multiplexed' => "Archivi audio/video multiplessà Ogg, $1, ch'a dura $2, formà $4×$5 px, $3 an tut",
	'timedmedia-ogg-long-general' => "Archivi multimojen Ogg, ch'a dura $2, $3",
	'timedmedia-ogg-long-error' => 'Archivi ogg nen bon: $1',
	'timedmedia-webm-short-video' => 'Archivi filmà WebM $1, $2',
	'timedmedia-webm-long-video' => 'WebM archivi sonor/filmà, $1, longheur $2, $4 x $5 pontin, $3 an tut',
	'timedmedia-no-player-js' => 'Darmagi, sò navigador a l\'ha JavaScript disabilità o a supòrta pa ël riprodutor.<br />
A peul <a href="$1">dëscarié la senëtta</a> o <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">dëscarié un riprodutor</a> për visualisé la senëtta su sò navigador.',
	'timedmedia-more' => 'Dë pì...',
	'timedmedia-dismiss' => 'sëré',
	'timedmedia-download' => "Dëscarié l'archivi",
	'timedmedia-play-media' => 'Lese ël mojen',
	'timedmedia-desc-link' => "Rësgoard a st'archivi",
	'timedmedia-oggThumb-version' => "OggHandler a ciama la version $1 d'oggThumb o pi agiornà.",
	'timedmedia-oggThumb-failed' => "oggThumb a l'ha falì a creé la figurin-a.",
	'timedmedia-source-file' => '$1 sorziss',
	'timedmedia-source-file-desc' => 'Original $1, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Larghëssa ëd banda bassa Ogg video (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Web streamable Ogg video (360P)',
	'timedmedia-derivative-desc-480p.ogv' => "Filmà Ogg lesìbil an continuà an sl'aragnà (480P)",
	'timedmedia-derivative-desc-720p.ogv' => "Filmà Ogg dëscariàbil d'àuta qualità (720P)",
	'timedmedia-derivative-desc-360p.webm' => "WebM lesìbil an continuà an sl'aragnà (360P)",
	'timedmedia-derivative-desc-480p.webm' => "WebM lesìbil an continuà an sl'aragnà (480P)",
	'timedmedia-derivative-desc-720p.webm' => "WebM dëscariàbil d'àuta qualità (720P)",
	'timedmedia-subtitle-language' => '$1 ($2) sot-tìtoj',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'timedmedia-ogg-short-audio' => 'Ogg $1 غږيزه دوتنه، $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 ويډيويي دوتنه، $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 رسنيزه دوتنه، $2',
	'timedmedia-more' => 'نور...',
	'timedmedia-dismiss' => 'تړل',
	'timedmedia-download' => 'دوتنه ښکته کول',
	'timedmedia-desc-link' => 'د همدې دوتنې په اړه',
	'timedmedia-status' => 'دريځ',
);

/** Portuguese (Português)
 * @author 555
 * @author Giro720
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'timedmedia-desc' => 'Tratamento de áudio, vídeo e legendagem, nos formatos WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Áudio Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Vídeo Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Multimédia Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Áudio Ogg $1, $2 de duração, $3',
	'timedmedia-ogg-long-video' => 'Vídeo Ogg $1, $2 de duração, $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Áudio/vídeo Ogg multifacetado, $1, $2 de duração, $4×$5 pixels, $3 no todo',
	'timedmedia-ogg-long-general' => 'Multimédia Ogg, $2 de duração, $3',
	'timedmedia-ogg-long-error' => 'Ficheiro ogg inválido: $1',
	'timedmedia-webm-short-video' => 'Vídeo WebM $1, $2',
	'timedmedia-webm-long-video' => 'Áudio/vídeo WebM, $1, $2 de duração, $4 × $5 pixels, $3 no todo',
	'timedmedia-no-player-js' => 'Desculpe, mas ou o seu browser está com o JavaScript desactivado ou não tem nenhum dos leitores suportados.<br />
Pode fazer o <a href="$1">download do vídeo</a> ou o <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">download de um leitor</a> para assistir ao vídeo no seu browser.',
	'timedmedia-more' => 'Mais...',
	'timedmedia-dismiss' => 'Fechar',
	'timedmedia-download' => 'Fazer download do ficheiro',
	'timedmedia-play-media' => 'Reproduzir conteúdo',
	'timedmedia-desc-link' => 'Sobre este ficheiro',
	'timedmedia-oggThumb-version' => 'O oggHandler requer o oggThumb versão $1 ou posterior.',
	'timedmedia-oggThumb-failed' => 'O oggThumb não conseguiu criar a miniatura.',
	'timedmedia-status-header' => 'Estado da transcodificação',
	'timedmedia-update-status' => 'Actualizar o estado da transcodificação',
	'timedmedia-status' => 'estado',
	'timedmedia-status-unknown' => 'estado desconhecido',
	'timedmedia-transcodeinfo' => 'Descrição do ficheiro transcodificado',
	'timedmedia-actions' => 'acções',
	'timedmedia-direct-link' => 'Download do ficheiro transcodificado',
	'timedmedia-not-ready' => 'Ainda não está pronto',
	'timedmedia-completed-on' => 'Transcodificação de $1 terminada',
	'timedmedia-error-on' => 'Erro na transcodificação, em $1.',
	'timedmedia-started-transcode' => 'A transcodificação foi iniciada há $1. $2',
	'timedmedia-percent-done' => 'O progresso é cerca de $1%',
	'timedmedia-in-job-queue' => 'Adicionado à fila de tarefas há $1',
	'timedmedia-unknown-target-size' => 'Dimensão do destino desconhecida; $1 codificados',
	'timedmedia-days' => '{{PLURAL:$1|dia|$1 dias}}',
	'timedmedia-hours' => '{{PLURAL:$1|hora|$1 horas}}',
	'timedmedia-minutes' => '{{PLURAL:$1|minuto|$1 minutos}}',
	'timedmedia-seconds' => '{{PLURAL:$1|segundo|$1 segundos}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 e $4',
	'timedmedia-time-3-measurements' => '$1, $2 e $3',
	'timedmedia-time-2-measurements' => '$1 e $2',
	'timedmedia-show-error' => 'Mostrar erro',
	'timedmedia-reset' => 'Reiniciar transcodificação',
	'timedmedia-reset-confirm' => 'Reiniciar esta transcodificação elimina qualquer ficheiro existente e volta a adicionar a transcodificação à fila de tarefas. A nova transcodificação irá demorar algum tempo. <br /><br />Tem a certeza de que pretende continuar?',
	'timedmedia-reset-error' => 'Ocorreu um erro ao reiniciar a tarefa de transcodificação',
	'timedmedia-source-file' => 'Fonte $1',
	'timedmedia-source-file-desc' => 'Original $1, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Vídeo Ogg de baixa largura de banda (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Vídeo Ogg para web streaming (360P)',
	'timedmedia-derivative-desc-480p.ogv' => 'Vídeo Ogg para web streaming (480P)',
	'timedmedia-derivative-desc-720p.ogv' => 'Vídeo Ogg de alta qualidade para download (720 P)',
	'timedmedia-derivative-desc-360p.webm' => 'WebM para web streaming (360P)',
	'timedmedia-derivative-desc-480p.webm' => 'WebM para web streaming (480P)',
	'timedmedia-derivative-desc-720p.webm' => 'WebM de alta qualidade para download (720P)',
	'timedmedia-subtitle-language' => 'Legendas em $1 ($2)',
	'timedmedia-subtitle-no-video' => 'Não existe nenhum vídeo associado à actual página de legendas',
	'timedmedia-subtitle-no-subtitles' => 'Neste momento não existem legendas em $1 para este vídeo. Pode [{{fullurl:{{FULLPAGENAME}}|action=edit}} editar a página] e adicioná-las.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'timedmedia-desc' => 'Manipulador para arquivos Ogg Theora e Vorbis, com reprodutor JavaScript',
	'timedmedia-ogg-short-audio' => 'Arquivo de áudio Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Arquivo de vídeo Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Arquivo multimídia Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Arquivo de Áudio Ogg $1, $2 de duração, $3',
	'timedmedia-ogg-long-video' => 'Vídeo Ogg $1, $2 de duração, $4×$5 pixels, $3',
	'timedmedia-ogg-long-multiplexed' => 'Áudio/vídeo Ogg multifacetado, $1, $2 de duração, $4×$5 pixels, $3 no todo',
	'timedmedia-ogg-long-general' => 'Multimídia Ogg, $2 de duração, $3',
	'timedmedia-ogg-long-error' => 'Ficheiro ogg inválido: $1',
	'timedmedia-no-player-js' => 'Desculpe, seu navegador ou está com JavaScript desabilitado ou não tem nenhum "player" suportado.<br />
Você pode <a href="$1">descarregar o clipe</a> ou <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descarregar um "player"</a> para executar o clipe em seu navegador.',
	'timedmedia-more' => 'Mais...',
	'timedmedia-dismiss' => 'Fechar',
	'timedmedia-download' => 'Descarregar arquivo',
	'timedmedia-desc-link' => 'Sobre este arquivo',
	'timedmedia-oggThumb-version' => 'O oggHandler requer o oggThumb versão $1 ou posterior.',
	'timedmedia-oggThumb-failed' => 'O oggThumb não conseguiu criar a miniatura.',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'timedmedia-more' => 'Astawan...',
	'timedmedia-dismiss' => "Wichq'ay",
	'timedmedia-download' => 'Willañiqita chaqnamuy',
	'timedmedia-desc-link' => 'Kay willañiqimanta',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'timedmedia-ogg-short-audio' => 'Fișier audio ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Fișier video ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Fișier media ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Fișier audio ogg $1, lungime $2, $3',
	'timedmedia-ogg-long-video' => 'Fișier video ogg $1, lungime $2, $4×$5 pixeli, $3',
	'timedmedia-ogg-long-multiplexed' => 'Fișier multiplexat audio/video ogg, $1, lungime $2, $4×$5 pixeli, $3',
	'timedmedia-ogg-long-general' => 'Fișier media ogg, lungime $2, $3',
	'timedmedia-ogg-long-error' => 'Fișier ogg incorect: $1',
	'timedmedia-more' => 'Mai mult…',
	'timedmedia-dismiss' => 'Închide',
	'timedmedia-download' => 'Descarcă fișier',
	'timedmedia-desc-link' => 'Despre acest fișier',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'timedmedia-desc' => 'Gestore pe le file audio, video e teste temporizzate, cu le formate supportate pe WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'File audie Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'File video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'File media Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'File audie Ogg $1, lunghezze $2, $3',
	'timedmedia-ogg-long-video' => 'File video Ogg $1, lunghezze $2, $4 x $5 pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'File multiplexed audie e video Ogg $1, lunghezze $2, $4 x $5 pixel, $3 in totale',
	'timedmedia-ogg-long-general' => 'File media Ogg, lunghezze $2, $3',
	'timedmedia-ogg-long-error' => 'Ogg file invalide: $1',
	'timedmedia-webm-short-video' => 'WebM $1 file video, $2',
	'timedmedia-more' => 'De cchiù...',
	'timedmedia-dismiss' => 'Chiude',
	'timedmedia-download' => 'Scareche stu file',
	'timedmedia-desc-link' => "'Mbormaziune sus a stu file",
	'timedmedia-oggThumb-version' => "OggHandler vole 'a versine de oggThumb $1 o cchiù ierte.",
	'timedmedia-oggThumb-failed' => 'oggThumn ha fallite a ccrejà le miniature.',
	'timedmedia-source-file' => '$1 sorgende',
	'timedmedia-subtitle-language' => '$1 ($2) sottotitele',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Eleferen
 * @author Kaganer
 * @author Kv75
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'timedmedia-desc' => 'Обработчик для аудио, видео и субтитров, с поддержкой форматов: WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Звуковой файл Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Видео-файл Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Медиа-файл Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'звуковой файл Ogg $1, длительность $2, $3',
	'timedmedia-ogg-long-video' => 'видео-файл Ogg $1, длительность $2, $4 × $5 {{PLURAL:$5|пиксель|пикселя|пикселей}}, $3',
	'timedmedia-ogg-long-multiplexed' => 'мультиплексный аудио/видео-файл Ogg, $1, длительность $2, $4 × $5 {{PLURAL:$5|пиксель|пикселя|пикселей}}, $3 всего',
	'timedmedia-ogg-long-general' => 'медиа-файл Ogg, длительность $2, $3',
	'timedmedia-ogg-long-error' => 'неправильный Ogg-файл: $1',
	'timedmedia-webm-short-video' => 'WebM $1 видео-файл, $2',
	'timedmedia-webm-long-video' => 'WebM аудио/видео файл, $1, продолжительность $2, $4 × $5 {{PLURAL:$5|пиксель|пикселя|пикселей}}, всего $3',
	'timedmedia-no-player-js' => 'К сожалению, в вашем браузере отключён JavaScript, или не имеется требуемого проигрывателя.<br />
Вы можете <a href="$1">загрузить ролик</a> или <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">загрузить проигрыватель</a> для воспроизведения ролика в браузере.',
	'timedmedia-more' => 'Больше…',
	'timedmedia-dismiss' => 'Скрыть',
	'timedmedia-download' => 'Загрузить файл',
	'timedmedia-play-media' => 'Воспроизвести медиа-файл',
	'timedmedia-desc-link' => 'Информация об этом файле',
	'timedmedia-oggThumb-version' => 'OggHandler требует oggThumb версии $1 или более поздней.',
	'timedmedia-oggThumb-failed' => 'oggThumb не удалось создать миниатюру.',
	'timedmedia-status-header' => 'Состояние декодирования',
	'timedmedia-update-status' => 'Обновить статус декодирования',
	'timedmedia-status' => 'Состояние',
	'timedmedia-status-unknown' => 'Неизвестное состояние',
	'timedmedia-transcodeinfo' => 'Описание производных декодироания',
	'timedmedia-actions' => 'Действия',
	'timedmedia-direct-link' => 'Скачать модифицированный вариант',
	'timedmedia-not-ready' => 'Не готов',
	'timedmedia-completed-on' => 'Завершено декодирование $1',
	'timedmedia-error-on' => 'Ошибка при декодировании на $1.',
	'timedmedia-started-transcode' => 'Декодирование запущено $1 назад. $2',
	'timedmedia-percent-done' => 'Примерно $1% выполнено',
	'timedmedia-in-job-queue' => 'Добавлено в очередь заданий $1 назад',
	'timedmedia-unknown-target-size' => 'Неизвестный целевой размер, $1 при кодировке',
	'timedmedia-days' => '{{PLURAL:$1|день|$1 дня|$1 дней}}',
	'timedmedia-hours' => '{{PLURAL:$1|$1 час|$1 часа|$1 часов}}',
	'timedmedia-minutes' => '{{PLURAL:$1|$1 минута|$1 минуты|$1 минут}}',
	'timedmedia-seconds' => '{{PLURAL:$1|$1 секунда|$1 секунды|$1 секунд}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 и $4',
	'timedmedia-time-3-measurements' => '$1, $2 и $3',
	'timedmedia-time-2-measurements' => '$1 и $2',
	'timedmedia-show-error' => 'Показать ошибку',
	'timedmedia-reset' => 'Перезапуск декодирования',
	'timedmedia-reset-confirm' => 'Перезапуск декодирования удалит существующий файл (если он существует), и  декодирование вновь будет добавлено в очередь заданий. Повторное декодирование займет некоторое время. <br /><br />
Вы уверены, что хотите продолжить?',
	'timedmedia-reset-error' => 'Ошибка при перезапуске декодирования.',
	'timedmedia-source-file' => 'Источник $1',
	'timedmedia-source-file-desc' => 'Оригинал $1, $2 × $3 ($4)',
	'timedmedia-derivative-desc-160p.ogv' => 'Ogg-видео низкого качества (160p)',
	'timedmedia-derivative-desc-360p.ogv' => 'Потоковое Ogg-видео (360p)',
	'timedmedia-derivative-desc-480p.ogv' => 'Потоковое Ogg-видео (480p)',
	'timedmedia-derivative-desc-720p.ogv' => 'Ogg-видео высокого качества (720p)',
	'timedmedia-derivative-desc-360p.webm' => 'Потоковое WebM-видео (360p)',
	'timedmedia-derivative-desc-480p.webm' => 'Потоковое WebM-видео (480p)',
	'timedmedia-derivative-desc-720p.webm' => 'WebM-видео высокого качества (720p)',
	'timedmedia-subtitle-language' => '$1 ($2) субтитры',
	'timedmedia-subtitle-no-video' => 'Нет видео, связанного с текущей страницей субтитров',
	'timedmedia-subtitle-no-subtitles' => 'В настоящее время нет субтитров на $1 для этого видео, Вы можете [{{fullurl:{{FULLPAGENAME}}|action=edit}} изменить эту страницу] для их добавления',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'timedmedia-more' => 'Веце...',
	'timedmedia-dismiss' => 'Заперти',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'timedmedia-desc' => 'Обработчик файлов Ogg Theora и Vorbis с использованием JavaScript-проигрывателя',
	'timedmedia-ogg-short-audio' => 'Звуковой файл Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Видео-файл Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Медиа-файл Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'звуковой файл Ogg $1, уһуна $2, $3',
	'timedmedia-ogg-long-video' => 'видео-файл Ogg $1, уһуна $2, $4×$5 пииксэллээх, $3',
	'timedmedia-ogg-long-multiplexed' => 'мультиплексный аудио/видео-файл Ogg, $1, уһуна $2, $4×$5 пииксэллээх, барыта $3',
	'timedmedia-ogg-long-general' => 'медиа-файл Ogg, уһуна $2, $3',
	'timedmedia-ogg-long-error' => 'сыыһа Ogg-файл: $1',
	'timedmedia-more' => 'Өссө...',
	'timedmedia-dismiss' => 'Кистээ/сап',
	'timedmedia-download' => 'Билэни хачайдаа',
	'timedmedia-desc-link' => 'Бу билэ туһунан',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 */
$messages['sgs'] = array(
	'timedmedia-download' => 'Atsėsiōstė faila',
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'timedmedia-desc' => 'Ogg Theora සහ Vorbis ගොනු සඳහා හසුරුවනය, ජාවාස්ක්‍රිප්ට් ප්ලේයර් සමඟ',
	'timedmedia-ogg-short-audio' => 'Ogg $1 ශ්‍රව්‍ය ගොනුව, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 දෘශ්‍ය ගොනුව, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 මාධ්‍ය ගොනුව, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 ශ්‍රව්‍ය ගොනුව, ප්‍රවර්තනය $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 දෘශ්‍ය ගොනුව, ප්‍රවර්තනය $2, $4×$5 පික්සල්, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg බහුපථකාරක ශ්‍රව්‍ය/දෘශ්‍ය ගොනුව, $1, ප්‍රවර්තනය $2, $4×$5 පික්සල්, $3 සමස්ත',
	'timedmedia-ogg-long-general' => 'Ogg මාධ්‍ය ගොනුව, ප්‍රවර්තනය $2, $3',
	'timedmedia-ogg-long-error' => 'අනීතික ogg ගොනුව: $1',
	'timedmedia-more' => 'ඉතිරිය…',
	'timedmedia-dismiss' => 'වසන්න',
	'timedmedia-download' => 'ගොනුව බා ගන්න',
	'timedmedia-desc-link' => 'මෙම ගොනුව පිළිබඳ',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'timedmedia-desc' => 'Obsluha súborov Ogg Theora a Vorbis s JavaScriptovým prehrávačom',
	'timedmedia-ogg-short-audio' => 'Zvukový súbor ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Video súbor ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Multimediálny súbor ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Zvukový súbor ogg $1, dĺžka $2, $3',
	'timedmedia-ogg-long-video' => 'Video súbor ogg $1, dĺžka $2, $4×$5 pixelov, $3',
	'timedmedia-ogg-long-multiplexed' => 'Multiplexovaný zvukový/video súbor ogg, $1, dĺžka $2, $4×$5 pixelov, $3 celkom',
	'timedmedia-ogg-long-general' => 'Multimediálny súbor ogg, dĺžka $2, $3',
	'timedmedia-ogg-long-error' => 'Neplatný súbor ogg: $1',
	'timedmedia-more' => 'viac...',
	'timedmedia-dismiss' => 'Zatvoriť',
	'timedmedia-download' => 'Stiahnuť súbor',
	'timedmedia-desc-link' => 'O tomto súbore',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'timedmedia-desc' => 'Upravljavec zvoka, videa in časovnega besedila s podporo oblikam WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Zvočna datoteka Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Videodatoteka Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Predstavnostna datoteka Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'zvočna datoteka ogg $1, dolžine $2, $3',
	'timedmedia-ogg-long-video' => 'videodatoteka ogg $1, dolžine $2, $4 × $5 pik, $3',
	'timedmedia-ogg-long-multiplexed' => 'multipleksna zvočna/videodatoteka ogg, $1, dolžina $2, $4 × $5 pik, $3 skupno',
	'timedmedia-ogg-long-general' => 'predstavnostna datoteka Ogg, dolžina $2, $3',
	'timedmedia-ogg-long-error' => 'Neveljavna datoteka Ogg: $1',
	'timedmedia-webm-short-video' => 'Videodatoteka WebM $1, $2',
	'timedmedia-webm-long-video' => 'zvočna/videodatoteka WebM, $1, dolžina $2, $4 × $5 pik, $3 skupno',
	'timedmedia-no-player-js' => 'Oprostite, vaš brskalnik ima ali onemogočen JavaScript ali pa nima podprtega predvajalnika.<br />
Lahko <a href="$1">prenesete posnetek</a> ali <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">prenesete predvajalnik</a> za predvajanje posnetka v vašem brskalniku.',
	'timedmedia-more' => 'Več ...',
	'timedmedia-dismiss' => 'Zapri',
	'timedmedia-download' => 'Prenesi datoteko',
	'timedmedia-play-media' => 'Predvajaj predstavnost',
	'timedmedia-desc-link' => 'O datoteki',
	'timedmedia-oggThumb-version' => 'OggHandler potrebuje oggThumb različice $1 ali višje.',
	'timedmedia-oggThumb-failed' => 'oggThumb ni uspel ustvariti predogledne sličice.',
	'timedmedia-status-header' => 'Stanje pretvorbe',
	'timedmedia-update-status' => 'Posodobi stanje pretvorbe',
	'timedmedia-status' => 'Stanje',
	'timedmedia-status-unknown' => 'Neznano stanje',
	'timedmedia-transcodeinfo' => 'Opis pretvorjene izpeljave',
	'timedmedia-actions' => 'Dejanja',
	'timedmedia-direct-link' => 'Prenos izpeljave',
	'timedmedia-not-ready' => 'Ni pripravljeno',
	'timedmedia-completed-on' => 'Pretvorba dokončana dne $1',
	'timedmedia-error-on' => 'Napaka pri pretvorbi dne $1.',
	'timedmedia-started-transcode' => 'Pretvorba se je začela pred $1. $2',
	'timedmedia-percent-done' => 'Dokončanih približno $1 %',
	'timedmedia-in-job-queue' => 'Dodano v čakalno vrsto pred $1',
	'timedmedia-unknown-target-size' => 'Neznana ciljna velikost, pretvorjeno $1',
	'timedmedia-days' => '$1 {{PLURAL:$1|dan|dneva|dnevi|dni}}',
	'timedmedia-hours' => '{{PLURAL:$1|ura|$1 uri|$1 ure|$1 ur}}',
	'timedmedia-minutes' => '{{PLURAL:$1|minuta|$1 minuti|$1 minute|$1 minut}}',
	'timedmedia-seconds' => '{{PLURAL:$1|sekunda|$1 sekundi|$1 sekunde|$1 sekund}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 in $4',
	'timedmedia-time-3-measurements' => '$1, $2 in $3',
	'timedmedia-time-2-measurements' => '$1 in $2',
	'timedmedia-show-error' => 'Prikaži napako',
	'timedmedia-reset' => 'Ponastavi pretvorbo',
	'timedmedia-reset-confirm' => 'Ponastavitev te pretvorbe bo odstranila vse obstoječe datoteke (če obstajajo) in pretvorbo ponovno dodala v čakalno vrsto. Ponovna pretvorba bo trajala nekaj časa. <br /><br />Ste prepričani, da želite nadaljevati?',
	'timedmedia-reset-error' => 'Napaka pri ponastavitvi opravila pretvorbe.',
	'timedmedia-source-file' => 'vir $1',
	'timedmedia-source-file-desc' => 'Izvirnik $1, $2 × $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg 160P',
	'timedmedia-derivative-desc-160p.ogv' => 'Video Ogg za majhno pasovno širino (160P)',
	'timedmedia-derivative-desc-360p.ogv' => 'Video Ogg za pretakanje preko spleta (360P)',
	'timedmedia-derivative-desc-480p.ogv' => 'Video Ogg za pretakanje preko spleta (480P)',
	'timedmedia-derivative-desc-720p.ogv' => 'Visoko ločljivostni video Ogg za prenos (720P)',
	'timedmedia-derivative-desc-360p.webm' => 'WebM za pretakanje preko spleta (360P)',
	'timedmedia-derivative-desc-480p.webm' => 'WebM za pretakanje preko spleta (480P)',
	'timedmedia-derivative-desc-720p.webm' => 'Visokokakovostni WebM za prenos (720P)',
	'timedmedia-subtitle-language' => 'podnapisi v jeziku $1 ($2)',
	'timedmedia-subtitle-no-video' => 'S trenutno podnaslovno stranjo ni povezan noben videoposnetek',
	'timedmedia-subtitle-no-subtitles' => 'V jeziku $1 trenutno ni nobenih podnapisov za ta video; lahko [{{fullurl:{{FULLPAGENAME}}|action=edit}} uredite to stran] in jih dodate',
);

/** Albanian (Shqip)
 * @author Dori
 */
$messages['sq'] = array(
	'timedmedia-ogg-short-audio' => 'Skedë zanore Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Skedë pamore Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Skedë mediatike Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'Skedë zanore Ogg $1, kohëzgjatja $2, $3',
	'timedmedia-ogg-long-video' => 'Skedë pamore Ogg $1, kohëzgjatja $2, $4×$5 pixel, $3',
	'timedmedia-more' => 'Më shumë...',
	'timedmedia-dismiss' => 'Mbylle',
	'timedmedia-download' => 'Shkarko skedën',
	'timedmedia-desc-link' => 'Rreth kësaj skede',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'timedmedia-desc' => 'Обрађивач за звук, видео и усклађени текст, с подршком за формате WebM, Ogg Theora, Vorbis и SRT',
	'timedmedia-ogg-short-audio' => 'Ogg $1 звучни фајл, $2.',
	'timedmedia-ogg-short-video' => 'Ogg $1 видео-снимак, $2.',
	'timedmedia-ogg-short-general' => 'Ogg $1 медијска датотека, $2.',
	'timedmedia-ogg-long-audio' => 'Ogg $1 звучни фајл, дужина $2, $3.',
	'timedmedia-ogg-long-video' => 'Ogg $1 видео-снимак, трајање $2, $4 × $5 пиксела, $3.',
	'timedmedia-ogg-long-multiplexed' => 'Мултиплексирани .ogg аудио/видео снимак, $1, трајање $2, $4 × $5 пиксела, $3.',
	'timedmedia-ogg-long-general' => 'Ogg медијски фајл, дужина $2, $3.',
	'timedmedia-ogg-long-error' => 'Неисправна .ogg датотека: $1.',
	'timedmedia-more' => 'Више...',
	'timedmedia-dismiss' => 'Затвори',
	'timedmedia-download' => 'Преузми датотеку',
	'timedmedia-desc-link' => 'Подаци о овој датотеци',
	'timedmedia-days' => '{{PLURAL:$1|дан|$1 дана|$1 дана}}',
	'timedmedia-hours' => '{{PLURAL:$1|сат|$1 сата|$1 сати}}',
	'timedmedia-minutes' => '{{PLURAL:$1|минут|$1 минута|$1 минута}}',
	'timedmedia-seconds' => '{{PLURAL:$1|секунд|$1 секунде|$1 секунди}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 и $4',
	'timedmedia-time-3-measurements' => '$1, $2 и $3',
	'timedmedia-time-2-measurements' => '$1 и $2',
	'timedmedia-show-error' => 'Прикажи грешку',
	'timedmedia-reset' => 'Поништи прекодирање',
	'timedmedia-reset-confirm' => 'Поништавање овог прекодирања ће уклонити постојећу датотеку (ако постоји) и вратити прекодирање на списак задатака. Ова радња може да потраје. <br /><br />
Желите ли да наставите?',
	'timedmedia-reset-error' => 'Грешка при поништавању задатака за прекодирање.',
	'timedmedia-ogg' => 'Ogg',
	'timedmedia-webm' => 'WebM',
	'timedmedia-source-file' => 'Изворни $1',
	'timedmedia-source-file-desc' => 'Изворни $1, $2 × $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg 160п',
	'timedmedia-derivative-desc-160p.ogv' => 'Нископропусни .ogg видео (160п)',
	'timedmedia-derivative-360p.ogv' => 'Ogg 360п',
	'timedmedia-derivative-desc-360p.ogv' => 'Ogg видео за емитовање (360п)',
	'timedmedia-derivative-480p.ogv' => 'Ogg 480п',
	'timedmedia-derivative-desc-480p.ogv' => 'Ogg видео за емитовање (480п)',
	'timedmedia-derivative-720p.ogv' => 'Ogg 720п',
	'timedmedia-derivative-desc-720p.ogv' => 'Висококвалитетни .ogg видео за преузимање (720п)',
	'timedmedia-derivative-360p.webm' => 'WebM 360п',
	'timedmedia-derivative-desc-360p.webm' => 'WebM за емитовање (360п)',
	'timedmedia-derivative-480p.webm' => 'WebM 480п',
	'timedmedia-derivative-desc-480p.webm' => 'WebM за емитовање (480п)',
	'timedmedia-derivative-720p.webm' => 'WebM 720п',
	'timedmedia-derivative-desc-720p.webm' => 'Висококвалитетни WebM за преузимање (720п)',
	'timedmedia-subtitle-language' => '$1 ($2) титлови',
	'timedmedia-subtitle-no-video' => 'Нема видео-снимака повезаних са текућом страницом с титловима',
	'timedmedia-subtitle-no-subtitles' => 'Тренутно нема $1 титлова за овај видео-снимак. Можете да их додате тако што ћете [{{fullurl:{{FULLPAGENAME}}|action=edit}} уредити страницу]',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'timedmedia-desc' => 'Obrađivač za zvuk, video i usklađeni tekst, s podrškom za formate WebM, Ogg Theora, Vorbis i SRT',
	'timedmedia-ogg-short-audio' => 'Ogg $1 zvučni fajl, $2.',
	'timedmedia-ogg-short-video' => 'Ogg $1 video-snimak, $2.',
	'timedmedia-ogg-short-general' => 'Ogg $1 medijska datoteka, $2.',
	'timedmedia-ogg-long-audio' => 'Ogg $1 zvučni fajl, dužina $2, $3.',
	'timedmedia-ogg-long-video' => 'Ogg $1 video-snimak, trajanje $2, $4 × $5 piksela, $3.',
	'timedmedia-ogg-long-multiplexed' => 'Multipleksirani .ogg audio/video snimak, $1, trajanje $2, $4 × $5 piksela, $3.',
	'timedmedia-ogg-long-general' => 'Ogg medijski fajl, dužina $2, $3.',
	'timedmedia-ogg-long-error' => 'Neispravna .ogg datoteka: $1.',
	'timedmedia-more' => 'Više...',
	'timedmedia-dismiss' => 'Zatvori',
	'timedmedia-download' => 'Preuzmi datoteku',
	'timedmedia-desc-link' => 'Podaci o ovoj datoteci',
	'timedmedia-days' => '{{PLURAL:$1|dan|$1 dana|$1 dana}}',
	'timedmedia-hours' => '{{PLURAL:$1|sat|$1 sata|$1 sati}}',
	'timedmedia-minutes' => '{{PLURAL:$1|minut|$1 minuta|$1 minuta}}',
	'timedmedia-seconds' => '{{PLURAL:$1|sekund|$1 sekunde|$1 sekundi}}',
	'timedmedia-time-4-measurements' => '$1, $2, $3 i $4',
	'timedmedia-time-3-measurements' => '$1, $2 i $3',
	'timedmedia-time-2-measurements' => '$1 i $2',
	'timedmedia-show-error' => 'Prikaži grešku',
	'timedmedia-reset' => 'Poništi prekodiranje',
	'timedmedia-reset-confirm' => 'Poništavanje ovog prekodiranja će ukloniti postojeću datoteku (ako postoji) i vratiti prekodiranje na spisak zadataka. Ova radnja može da potraje. <br /><br />
Želite li da nastavite?',
	'timedmedia-reset-error' => 'Greška pri poništavanju zadataka za prekodiranje.',
	'timedmedia-ogg' => 'Ogg',
	'timedmedia-webm' => 'WebM',
	'timedmedia-source-file' => 'Izvorni $1',
	'timedmedia-source-file-desc' => 'Izvorni $1, $2 × $3 ($4)',
	'timedmedia-derivative-160p.ogv' => 'Ogg 160p',
	'timedmedia-derivative-desc-160p.ogv' => 'Niskopropusni .ogg video (160p)',
	'timedmedia-derivative-360p.ogv' => 'Ogg 360p',
	'timedmedia-derivative-desc-360p.ogv' => 'Ogg video za emitovanje (360p)',
	'timedmedia-derivative-480p.ogv' => 'Ogg 480p',
	'timedmedia-derivative-desc-480p.ogv' => 'Ogg video za emitovanje (480p)',
	'timedmedia-derivative-720p.ogv' => 'Ogg 720p',
	'timedmedia-derivative-desc-720p.ogv' => 'Visokokvalitetni .ogg video za preuzimanje (720p)',
	'timedmedia-derivative-360p.webm' => 'WebM 360p',
	'timedmedia-derivative-desc-360p.webm' => 'WebM za emitovanje (360p)',
	'timedmedia-derivative-480p.webm' => 'WebM 480p',
	'timedmedia-derivative-desc-480p.webm' => 'WebM za emitovanje (480p)',
	'timedmedia-derivative-720p.webm' => 'WebM 720p',
	'timedmedia-derivative-desc-720p.webm' => 'Visokokvalitetni WebM za preuzimanje (720p)',
	'timedmedia-subtitle-language' => '$1 ($2) titlovi',
	'timedmedia-subtitle-no-video' => 'Nema video-snimaka povezanih sa tekućom stranicom s titlovima',
	'timedmedia-subtitle-no-subtitles' => 'Trenutno nema $1 titlova za ovaj video-snimak. Možete da ih dodate tako što ćete [{{fullurl:{{FULLPAGENAME}}|action=edit}} urediti stranicu]',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'timedmedia-desc' => 'Stjuurengsprogramm foar Ogg Theora- un Vorbis-Doatäie, inklusive n JavaScript-Ouspielsoftware',
	'timedmedia-ogg-short-audio' => 'Ogg-$1-Audiodoatäi, $2',
	'timedmedia-ogg-short-video' => 'Ogg-$1-Videodoatäi, $2',
	'timedmedia-ogg-short-general' => 'Ogg-$1-Mediadoatäi, $2',
	'timedmedia-ogg-long-audio' => 'Ogg-$1-Audiodoatäi, Loangte: $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg-$1-Videodoatäi, Loangte: $2, $4×$5 Pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg-Audio-/Video-Doatäi, $1, Loangte: $2, $4×$5 Pixel, $3',
	'timedmedia-ogg-long-general' => 'Ogg-Mediadoatäi, Loangte: $2, $3',
	'timedmedia-ogg-long-error' => 'Uungultige Ogg-Doatäi: $1',
	'timedmedia-more' => 'Optione …',
	'timedmedia-dismiss' => 'Sluute',
	'timedmedia-download' => 'Doatäi spiekerje',
	'timedmedia-desc-link' => 'Uur disse Doatäi',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'timedmedia-ogg-short-audio' => 'Koropak sora $1 ogg, $2',
	'timedmedia-ogg-short-video' => 'Koropak vidéo $1 ogg, $2',
	'timedmedia-ogg-short-general' => 'Koropak média $1 ogg, $2',
	'timedmedia-ogg-long-audio' => 'Koropak sora $1 ogg, lilana $2, $3',
	'timedmedia-ogg-long-video' => 'Koropak vidéo $1 ogg, lilana $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Koropak sora/vidéo ogg multipléks, $1, lilana $2, $4×$5 piksel, $3 gembleng',
	'timedmedia-ogg-long-general' => 'Koropak média ogg, lilana $2, $3',
	'timedmedia-ogg-long-error' => 'Koropak ogg teu valid: $1',
	'timedmedia-more' => 'Lianna...',
	'timedmedia-dismiss' => 'Tutup',
	'timedmedia-download' => 'Bedol',
	'timedmedia-desc-link' => 'Ngeunaan ieu koropak',
);

/** Swedish (Svenska)
 * @author Jon Harald Søby
 * @author Lejonel
 * @author Rotsee
 * @author Skalman
 */
$messages['sv'] = array(
	'timedmedia-desc' => 'Stöder filtyperna Ogg Theora och Ogg Vorbis med en JavaScript-baserad mediaspelare',
	'timedmedia-ogg-short-audio' => 'Ogg $1 ljudfil, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 videofil, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 mediafil, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 ljudfil, längd $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 videofil, längd $2, $4×$5 pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg multiplexad ljud/video-fil, $1, längd $2, $4×$5 pixel, $3 totalt',
	'timedmedia-ogg-long-general' => 'Ogg mediafil, längd $2, $3',
	'timedmedia-ogg-long-error' => 'Felaktig Ogg-fil: $1',
	'timedmedia-more' => 'Mer...',
	'timedmedia-dismiss' => 'Stäng',
	'timedmedia-download' => 'Ladda ner filen',
	'timedmedia-desc-link' => 'Om filen',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'timedmedia-ogg-short-audio' => 'Ogg $1 శ్రావ్యక ఫైలు, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 వీడియో ఫైలు, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 మీడియా ఫైలు, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 శ్రవణ ఫైలు, నిడివి $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 వీడియో ఫైలు, నిడివి $2, $4×$5 పిక్సెళ్ళు, $3',
	'timedmedia-ogg-long-multiplexed' => 'ఓగ్ మల్టిప్లెక్సుడ్ శ్రవణ/దృశ్యక ఫైలు, $1, నిడివి $2, $4×$5 పిక్సెళ్ళు, $3 మొత్తం',
	'timedmedia-ogg-long-general' => 'Ogg మీడియా ఫైలు, నిడివి $2, $3',
	'timedmedia-ogg-long-error' => 'తప్పుడు ogg ఫైలు: $1',
	'timedmedia-more' => 'మరిన్ని...',
	'timedmedia-dismiss' => 'మూసివేయి',
	'timedmedia-download' => 'ఫైలుని దిగుమతి చేసుకోండి',
	'timedmedia-desc-link' => 'ఈ ఫైలు గురించి',
	'timedmedia-subtitle-language' => '$1 ($2) ఉపశీర్షికలు',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'timedmedia-desc' => 'Ба дастгирандае барои парвандаҳои  Ogg Theora ва Vorbis, бо пахшкунандаи JavaScript',
	'timedmedia-ogg-short-audio' => 'Ogg $1 парвандаи савтӣ, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 парвандаи наворӣ, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 парвандаи расона, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 парвандаи савтӣ, тӯл $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 парвандаи наворӣ, тӯл $2, $4×$5 пикселҳо, $3',
	'timedmedia-ogg-long-multiplexed' => 'Парвандаи Ogg савтӣ/наворӣ печида, $1, тӯл $2, $4×$5 пикселҳо, дар маҷмӯъ $3',
	'timedmedia-ogg-long-general' => 'Парвандаи расонаи Ogg, тӯл $2, $3',
	'timedmedia-ogg-long-error' => 'Парвандаи ғайримиҷози ogg: $1',
	'timedmedia-more' => 'Бештар...',
	'timedmedia-dismiss' => 'Бастан',
	'timedmedia-download' => 'Боргирии парванда',
	'timedmedia-desc-link' => 'Дар бораи ин парванда',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'timedmedia-desc' => 'Ba dastgirandae baroi parvandahoi  Ogg Theora va Vorbis, bo paxşkunandai JavaScript',
	'timedmedia-ogg-short-audio' => 'Ogg $1 parvandai savtī, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 parvandai navorī, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 parvandai rasona, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 parvandai savtī, tūl $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 parvandai navorī, tūl $2, $4×$5 pikselho, $3',
	'timedmedia-ogg-long-multiplexed' => "Parvandai Ogg savtī/navorī pecida, $1, tūl $2, $4×$5 pikselho, dar maçmū' $3",
	'timedmedia-ogg-long-general' => 'Parvandai rasonai Ogg, tūl $2, $3',
	'timedmedia-ogg-long-error' => 'Parvandai ƣajrimiçozi ogg: $1',
	'timedmedia-more' => 'Beştar...',
	'timedmedia-dismiss' => 'Bastan',
	'timedmedia-download' => 'Borgiriji parvanda',
	'timedmedia-desc-link' => 'Dar borai in parvanda',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'timedmedia-desc' => 'Ogg Theora we Vorbis faýllary üçin işleýji, JavaScript pleýeri bilen bilelikde',
	'timedmedia-ogg-short-audio' => 'Ogg $1 ses faýly, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 wideo faýly, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 media faýly, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 ses faýly, uzynlyk $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 wideo faýly, uzynlyk $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg multipleks audio/wideo faýly, $1, uzynlyk $2, $4×$5 piksel, $3 jemi',
	'timedmedia-ogg-long-general' => 'Ogg media faýly, uzynlyk $2, $3',
	'timedmedia-ogg-long-error' => 'Nädogry ogg faýly: $1',
	'timedmedia-more' => 'Has köp...',
	'timedmedia-dismiss' => 'Ýap',
	'timedmedia-download' => 'Faýl düşür',
	'timedmedia-desc-link' => 'Bu faýl hakda',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'timedmedia-desc' => 'Tagahawak para sa audio, bidyo at inoorasang teksto, na may pagtangkilik ng anyo para sa WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => '$1 na talaksang pangtunog ng Ogg, $2',
	'timedmedia-ogg-short-video' => "$1 talaksang pampalabas (''video'') ng Ogg, $2",
	'timedmedia-ogg-short-general' => '$1 talaksang pangmidya ng Ogg, $2',
	'timedmedia-ogg-long-audio' => '$1 talaksang pantunog ng Ogg, haba $2, $3',
	'timedmedia-ogg-long-video' => '$1 talaksan ng palabas ng Ogg, haba $2, $4×$5 mga piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'magkasanib at nagsasabayang talaksang nadirinig o audio/palabas ng Ogg, $1, haba $2, $4×$5 mga piksel, $3 sa kalahatan',
	'timedmedia-ogg-long-general' => "Talaksang pangmidya ng ''Ogg'', haba $2, $3",
	'timedmedia-ogg-long-error' => "Hindi tanggap na talaksang ''ogg'': $1",
	'timedmedia-webm-short-video' => '$1 na talaksan ng bidyo ng WebM, $2',
	'timedmedia-no-player-js' => 'Paumahin, ang pantingin-tingin mo ay maaaring may hindi gumaganang JavaScript o walang anumang tinatangkilik na pampaandar.<br />
Maaari kang <a href="$1">magkargang pababa ng kaputol</a> o <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">magkargang pababa ng isang pampaandar</a> upang mapaandar ang kaputol sa loob ng iyong pantingin-tingin.',
	'timedmedia-more' => 'Marami pa…',
	'timedmedia-dismiss' => 'Isara',
	'timedmedia-download' => 'Ikarga ang talaksan',
	'timedmedia-play-media' => 'Paandarin ang midya',
	'timedmedia-desc-link' => 'Tungkol sa talaksang ito',
	'timedmedia-oggThumb-version' => 'Nangangailangan ang OggHandler ng bersyong $1 o mas luma ng oggThumb.',
	'timedmedia-oggThumb-failed' => 'Nabigong lumikha ang oggThumb ng munting larawan.',
	'timedmedia-source-file' => '$1 pinagkukunan',
	'timedmedia-source-file-desc' => 'Orihinal na $1, $2 × $3 ( $4)',
	'timedmedia-derivative-desc-720p.webm' => 'May mataas na uring WebM na maikakargang paibaba (720P)',
	'timedmedia-subtitle-language' => '$1 ($2) kabahaging mga pamagat',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Mach
 * @author Runningfridgesrule
 * @author Srhat
 */
$messages['tr'] = array(
	'timedmedia-desc' => 'Ogg Theora ve Vorbis dosyaları için işleyici, JavaScript oynatıcısı ile',
	'timedmedia-ogg-short-audio' => 'Ogg $1 ses dosyası, $2',
	'timedmedia-ogg-short-video' => 'Ogg $1 film dosyası, $2',
	'timedmedia-ogg-short-general' => 'Ogg $1 medya dosyası, $2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 ses dosyası, süre $2, $3',
	'timedmedia-ogg-long-video' => 'Ogg $1 film dosyası, süre $2, $4×$5 piksel, $3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg çok düzeyli ses/film dosyası, $1, süre $2, $4×$5 piksel, $3 genelde',
	'timedmedia-ogg-long-general' => 'Ogg medya dosyası, süre $2, $3',
	'timedmedia-ogg-long-error' => 'Geçersiz ogg dosyası: $1',
	'timedmedia-more' => 'Daha...',
	'timedmedia-dismiss' => 'Kapat',
	'timedmedia-download' => 'Dosya indir',
	'timedmedia-desc-link' => 'Bu dosya hakkında',
);

/** Tsonga (Xitsonga)
 * @author Thuvack
 */
$messages['ts'] = array(
	'timedmedia-more' => 'Swinwana…',
	'timedmedia-dismiss' => 'Pfala',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'timedmedia-more' => 'Тулырак...',
	'timedmedia-dismiss' => 'Ябу',
	'timedmedia-download' => 'Файлны алу',
	'timedmedia-desc-link' => 'Файл турында мәгълүмат',
	'timedmedia-oggThumb-version' => 'OggHandler $1 юрамасыннан да югарырак oggThumb тәэминатын сорый.',
	'timedmedia-oggThumb-failed' => 'oggThumb нигезендә миниатюраны ясап булмады.',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author NickK
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'timedmedia-desc' => 'Оброблювач для аудіо, відео і субтитрів з підтримкою форматів WebM, Ogg Theora, Vorbis, srt',
	'timedmedia-ogg-short-audio' => 'Звуковий файл Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Відео-файл Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Файл Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'звуковий файл Ogg $1, довжина $2, $3',
	'timedmedia-ogg-long-video' => 'відео-файл Ogg $1, довжина $2, $4×$5 пікселів, $3',
	'timedmedia-ogg-long-multiplexed' => 'мультиплексний аудіо/відео-файл ogg, $1, довжина $2, $4×$5 пікселів, $3 усього',
	'timedmedia-ogg-long-general' => 'медіа-файл Ogg, довжина $2, $3',
	'timedmedia-ogg-long-error' => 'Неправильний Ogg-файл: $1',
	'timedmedia-more' => 'Більше…',
	'timedmedia-dismiss' => 'Закрити',
	'timedmedia-download' => 'Завантажити файл',
	'timedmedia-desc-link' => 'Інформація про цей файл',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'timedmedia-desc' => 'Gestor par i file Ogg Theora e Vorbis, con riprodutor JavaScript',
	'timedmedia-ogg-short-audio' => 'File audio Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'File video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'File multimedial Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'File audio Ogg $1, durata $2, $3',
	'timedmedia-ogg-long-video' => 'File video Ogg $1, durata $2, dimensioni $4×$5 pixel, $3',
	'timedmedia-ogg-long-multiplexed' => 'File audio/video multiplexed Ogg $1, durata $2, dimensioni $4×$5 pixel, conplessivamente $3',
	'timedmedia-ogg-long-general' => 'File multimedial Ogg, durata $2, $3',
	'timedmedia-ogg-long-error' => 'File ogg mìa valido: $1',
	'timedmedia-more' => 'Altro...',
	'timedmedia-dismiss' => 'Sara',
	'timedmedia-download' => 'Descarga el file',
	'timedmedia-desc-link' => 'Informazion su sto file',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'timedmedia-more' => 'Enamba...',
	'timedmedia-dismiss' => 'Peitta',
	'timedmedia-download' => 'Jügutoitta fail',
	'timedmedia-desc-link' => 'Informacii neciš failas',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'timedmedia-desc' => 'Bộ trình bày các tập tin âm thanh, video, và phụ đề hỗ trợ WebM, Ogg Theora, Vorbis, và srt',
	'timedmedia-ogg-short-audio' => 'Tập tin âm thanh Ogg $1, $2',
	'timedmedia-ogg-short-video' => 'Tập tin video Ogg $1, $2',
	'timedmedia-ogg-short-general' => 'Tập tin Ogg $1, $2',
	'timedmedia-ogg-long-audio' => 'tập tin âm thanh Ogg $1, dài $2, $3',
	'timedmedia-ogg-long-video' => 'tập tin video Ogg $1, dài $2, $4×$5 điểm ảnh, $3',
	'timedmedia-ogg-long-multiplexed' => 'tập tin Ogg có âm thanh và video ghép kênh, $1, dài $2, $4×$5 điểm ảnh, $3 tất cả',
	'timedmedia-ogg-long-general' => 'tập tin phương tiện Ogg, dài $2, $3',
	'timedmedia-ogg-long-error' => 'Tập tin Ogg có lỗi: $1',
	'timedmedia-more' => 'Thêm nữa…',
	'timedmedia-dismiss' => 'Đóng',
	'timedmedia-download' => 'Tải tập tin xuống',
	'timedmedia-desc-link' => 'Chi tiết của tập tin này',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'timedmedia-more' => 'Pluikos...',
	'timedmedia-dismiss' => 'Färmükön',
	'timedmedia-download' => 'Donükön ragivi',
	'timedmedia-desc-link' => 'Tefü ragiv at',
);

/** Walloon (Walon) */
$messages['wa'] = array(
	'timedmedia-dismiss' => 'Clôre',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'timedmedia-download' => 'אראָפלאָדן טעקע',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'timedmedia-desc' => 'Ogg Theora 同 Vorbis 檔案嘅處理器，加埋 JavaScript 播放器',
	'timedmedia-ogg-short-audio' => 'Ogg $1 聲檔，$2',
	'timedmedia-ogg-short-video' => 'Ogg $1 畫檔，$2',
	'timedmedia-ogg-short-general' => 'Ogg $1 媒檔，$2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 聲檔，長度$2，$3',
	'timedmedia-ogg-long-video' => 'Ogg $1 畫檔，長度$2，$4×$5像素，$3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg 多工聲／畫檔，$1，長度$2，$4×$5像素，總共$3',
	'timedmedia-ogg-long-general' => 'Ogg 媒檔，長度$2，$3',
	'timedmedia-ogg-long-error' => '無效嘅ogg檔: $1',
	'timedmedia-more' => '更多...',
	'timedmedia-dismiss' => '閂',
	'timedmedia-download' => '下載檔案',
	'timedmedia-desc-link' => '關於呢個檔案',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'timedmedia-desc' => 'Ogg Theora 和 Vorbis 文件的处理器，含 JavaScript 播放器',
	'timedmedia-ogg-short-audio' => 'Ogg $1 声音文件，$2',
	'timedmedia-ogg-short-video' => 'Ogg $1 视频文件，$2',
	'timedmedia-ogg-short-general' => 'Ogg $1 媒体文件，$2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 声音文件，长度$2，$3',
	'timedmedia-ogg-long-video' => 'Ogg $1 视频文件，长度$2，$4×$5像素，$3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg 多工声音／视频文件，$1，长度$2，$4×$5像素，共$3',
	'timedmedia-ogg-long-general' => 'Ogg 媒体文件，长度$2，$3',
	'timedmedia-ogg-long-error' => '无效的ogg文件: $1',
	'timedmedia-more' => '更多...',
	'timedmedia-dismiss' => '关闭',
	'timedmedia-download' => '下载文件',
	'timedmedia-desc-link' => '关于这个文件',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gaoxuewei
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'timedmedia-desc' => 'Ogg Theora 和 Vorbis 檔案的處理器，含 JavaScript 播放器',
	'timedmedia-ogg-short-audio' => 'Ogg $1 聲音檔案，$2',
	'timedmedia-ogg-short-video' => 'Ogg $1 影片檔案，$2',
	'timedmedia-ogg-short-general' => 'Ogg $1 媒體檔案，$2',
	'timedmedia-ogg-long-audio' => 'Ogg $1 聲音檔案，長度 $2，$3',
	'timedmedia-ogg-long-video' => 'Ogg $1 影片檔案，長度 $2，$4 × $5像素，$3',
	'timedmedia-ogg-long-multiplexed' => 'Ogg 多工聲音／影片檔案，$1，長度 $2，$4 × $5 像素，共 $3',
	'timedmedia-ogg-long-general' => 'Ogg 媒體檔案，長度 $2，$3',
	'timedmedia-ogg-long-error' => '無效的 ogg 檔案：$1',
	'timedmedia-more' => '更多...',
	'timedmedia-dismiss' => '關閉',
	'timedmedia-download' => '下載檔案',
	'timedmedia-desc-link' => '關於這個檔案',
);

