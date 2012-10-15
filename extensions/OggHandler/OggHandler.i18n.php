<?php
/**
 * Internationalisation file for extension OggPlayer.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'ogg-desc'             => 'Handler for Ogg Theora and Vorbis files, with JavaScript player',
	'ogg-short-audio'      => 'Ogg $1 sound file, $2',
	'ogg-short-video'      => 'Ogg $1 video file, $2',
	'ogg-short-general'    => 'Ogg $1 media file, $2',
	'ogg-long-audio'       => 'Ogg $1 sound file, length $2, $3',
	'ogg-long-video'       => 'Ogg $1 video file, length $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => 'Ogg multiplexed audio/video file, $1, length $2, $4×$5 pixels, $3 overall',
	'ogg-long-general'     => 'Ogg media file, length $2, $3',
	'ogg-long-error'       => 'Invalid ogg file: $1',
	'ogg-play'             => 'Play',
	'ogg-pause'            => 'Pause',
	'ogg-stop'             => 'Stop',
	'ogg-play-video'       => 'Play video',
	'ogg-play-sound'       => 'Play sound',
	'ogg-no-player'        => 'Sorry, your system does not appear to have any supported player software.
Please <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">download a player</a>.',
	'ogg-no-xiphqt'        => 'You do not appear to have the XiphQT component for QuickTime.
QuickTime cannot play Ogg files without this component.
Please <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">download XiphQT</a> or choose another player.',

	'ogg-player-videoElement' => 'Native browser support',
	'ogg-player-oggPlugin' => 'Browser plugin',
	'ogg-player-cortado'   => 'Cortado (Java)', # only translate this message to other languages if you have to change it
	'ogg-player-vlc-mozilla' => 'VLC', # only translate this message to other languages if you have to change it
	'ogg-player-vlc-activex' => 'VLC (ActiveX)', # only translate this message to other languages if you have to change it
	'ogg-player-quicktime-mozilla' => 'QuickTime', # only translate this message to other languages if you have to change it
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX)', # only translate this message to other languages if you have to change it
	'ogg-player-totem'     => 'Totem', # only translate this message to other languages if you have to change it
	'ogg-player-kmplayer'  => 'KMPlayer', # only translate this message to other languages if you have to change it
	'ogg-player-kaffeine'  => 'Kaffeine', # only translate this message to other languages if you have to change it
	'ogg-player-mplayerplug-in' => 'mplayerplug-in', # only translate this message to other languages if you have to change it
	'ogg-player-thumbnail' => 'Still image only',
	'ogg-player-soundthumb' => 'No player',
	'ogg-player-selected'  => '(selected)',
	'ogg-use-player'       => 'Use player:',
	'ogg-more'             => 'More…',
	'ogg-dismiss'          => 'Close',
	'ogg-download'         => 'Download file',
	'ogg-desc-link'        => 'About this file',
	'ogg-oggThumb-version' => 'OggHandler requires oggThumb version $1 or later.',
	'ogg-oggThumb-failed'  => 'oggThumb failed to create the thumbnail.',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author BrokenArrow
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Lloffiwr
 * @author Meno25
 * @author Mormegil
 * @author Purodha
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'ogg-desc' => '{{desc}}',
	'ogg-short-general' => 'File details for generic (non-audio, non-video) Ogg files, short version.
Parameters are: 
* $1 file type, e.g. Vorbis, Speex
* $2 ?',
	'ogg-long-audio' => 'File details for Ogg files, shown after the filename in the image description page.
Parameters are: 
* $1 file codec, f.e. Vorbis, Speex
* $2 file duration, f.e. 1m34s
* $3 file sampling rate, f.e. 97kbps',
	'ogg-play' => '{{Identical|Play}}',
	'ogg-player-videoElement' => 'Message used in JavaScript. 

For definition of "native support" see [http://en.wiktionary.org/wiki/native_support Wiktionary].',
	'ogg-player-cortado' => '{{optional}}',
	'ogg-player-vlc-mozilla' => '{{optional}}',
	'ogg-player-vlc-activex' => '{{optional}}',
	'ogg-player-quicktime-mozilla' => '{{optional}}',
	'ogg-player-quicktime-activex' => '{{optional}}',
	'ogg-player-totem' => '{{optional}}',
	'ogg-player-kmplayer' => '{{optional}}',
	'ogg-player-kaffeine' => '{{optional}}',
	'ogg-player-mplayerplug-in' => '{{optional}}',
	'ogg-more' => '{{Identical|More...}}',
	'ogg-dismiss' => '{{Identical|Close}}',
	'ogg-download' => '{{Identical|Download}}',
);

/** Albaamo innaaɬiilka (Albaamo innaaɬiilka)
 * @author Ulohnanne
 */
$messages['akz'] = array(
	'ogg-more' => 'Maatàasasi...',
);

/** Afrikaans (Afrikaans)
 * @author AVRS
 * @author Naudefj
 * @author SPQRobin
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'ogg-desc' => "Hanteer Ogg Theora- en Vorbis-lêers met 'n JavaScript-mediaspeler",
	'ogg-short-audio' => 'Ogg $1 klanklêer, $2',
	'ogg-short-video' => 'Ogg $1 video lêer, $2',
	'ogg-short-general' => 'Ogg $1 medialêer, $2',
	'ogg-long-audio' => '(Ogg $1 klanklêer, lengte $2, $3)',
	'ogg-long-video' => 'Ogg $1 videolêer, lengte $2, $4×$5 pixels, $3',
	'ogg-long-general' => '(Ogg medialêer, lengte $2, $3)',
	'ogg-long-error' => '(Ongeldige ogg-lêer: $1)',
	'ogg-play' => 'Speel',
	'ogg-pause' => 'Wag',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Speel video',
	'ogg-play-sound' => 'Speel geluid',
	'ogg-player-videoElement' => 'Standaardondersteuning in webblaaier',
	'ogg-player-oggPlugin' => 'Webblaaier-plugin',
	'ogg-player-thumbnail' => 'Still image net',
	'ogg-player-soundthumb' => 'Geen mediaspeler',
	'ogg-player-selected' => '(geselekteer)',
	'ogg-use-player' => 'Gebruik speler:',
	'ogg-more' => 'Meer…',
	'ogg-dismiss' => 'Sluit',
	'ogg-download' => 'Laai lêer af',
	'ogg-desc-link' => 'Aangaande die lêer',
);

/** Gheg Albanian (Gegë)
 * @author AVRS
 * @author Mdupont
 */
$messages['aln'] = array(
	'ogg-desc' => 'Mbajtës për Ogg Vorbis Theora dhe fotografi, me JavaScript lojtar',
	'ogg-short-audio' => 'Ogg tingull $1 fotografi, $2',
	'ogg-short-video' => 'video file Ogg $1, $2',
	'ogg-short-general' => 'Ogg $1 media file, $2',
	'ogg-long-audio' => '(ZQM file $1 shëndoshë, gjatë $2, $3)',
	'ogg-long-video' => 'Ogg $1 video file, gjatë $2, $4 × $5 pixels, $3',
	'ogg-long-multiplexed' => '(ZQM multiplexed audio / video file, 1 $, gjatë $2, $4 × $5 pixels, $3 e përgjithshme)',
	'ogg-long-general' => '(Ogg media file, gjatë $2, $3)',
	'ogg-long-error' => '(Invalid ogg file: $1)',
	'ogg-play' => 'Luaj',
	'ogg-pause' => 'Pushim',
	'ogg-stop' => 'Ndalo',
	'ogg-play-video' => 'video Play',
	'ogg-play-sound' => 'Tingull',
	'ogg-no-player' => 'Na vjen keq, sistemi juaj nuk duket të ketë ndonjë lojtar software mbështetur. Ju lutemi <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">të shkarkoni një lojtar</a> .',
	'ogg-no-xiphqt' => 'Ju nuk duket të ketë komponent XiphQT për QuickTime. QuickTime nuk mund të luajnë Ogg files pa këtë element. Ju lutem <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">shkarkoni XiphQT</a> ose zgjidhni një tjetër lojtar.',
	'ogg-player-videoElement' => 'mbështetje Gjuha shfletuesin',
	'ogg-player-oggPlugin' => 'Browser plugin',
	'ogg-player-thumbnail' => 'Ende image vetëm',
	'ogg-player-soundthumb' => 'Nuk ka lojtar',
	'ogg-player-selected' => '(Zgjedhur)',
);

/** Aragonese (Aragonés)
 * @author AVRS
 * @author Juanpabl
 */
$messages['an'] = array(
	'ogg-desc' => 'Maneyador ta fichers Ogg Theora and Vorbis, con un reproductor JavaScript',
	'ogg-short-audio' => 'Fichero de son ogg $1, $2',
	'ogg-short-video' => 'Fichero de vidio ogg $1, $2',
	'ogg-short-general' => 'Fichero multimedia ogg $1, $2',
	'ogg-long-audio' => '(Fichero de son ogg $1, durada $2, $3)',
	'ogg-long-video' => 'Fichero de vidio ogg $1, durada $2, $4×$5 píxels, $3',
	'ogg-long-multiplexed' => '(fichero ogg multiplexato audio/vidio, $1, durada $2, $4×$5 píxels, $3 total)',
	'ogg-long-general' => '(fichero ogg multimedia durada $2, $3)',
	'ogg-long-error' => '(Fichero ogg no conforme: $1)',
	'ogg-play' => 'Reproducir',
	'ogg-pause' => 'Pausa',
	'ogg-stop' => 'Aturar',
	'ogg-play-video' => 'Reproducir vidio',
	'ogg-play-sound' => 'Reproducir son',
	'ogg-no-player' => 'No puedo trobar garra software reproductor suportato.
Habría d\'<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">escargar un reproductor</a>.',
	'ogg-no-xiphqt' => 'No puedo trobar o component XiphQT ta QuickTime.
QuickTime no puede reproducir ficheros ogg sin este component.
Puede <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">escargar XiphQT</a> u trigar un atro reproductor.',
	'ogg-player-videoElement' => "Soporte nativo d'o navegador",
	'ogg-player-oggPlugin' => "Plugin d'o navegador",
	'ogg-player-thumbnail' => 'Nomás imachen fixa',
	'ogg-player-soundthumb' => 'Garra reproductor',
	'ogg-player-selected' => '(trigato)',
	'ogg-use-player' => 'Fer servir o reproductor:',
	'ogg-more' => 'Más…',
	'ogg-dismiss' => 'Zarrar',
	'ogg-download' => 'Escargar fichero',
	'ogg-desc-link' => 'Información sobre este fichero',
	'ogg-oggThumb-version' => 'OggHandler requiere una versión oggThumb $1 u posterior.',
	'ogg-oggThumb-failed' => 'oggThumb no podió creyar a imachen miniatura.',
);

/** Arabic (العربية)
 * @author Aiman titi
 * @author Alnokta
 * @author Majid Al-Dharrab
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'ogg-desc' => 'متحكم لملفات Ogg Theora وVorbis، مع لاعب جافاسكريت',
	'ogg-short-audio' => 'Ogg $1 ملف صوت، $2',
	'ogg-short-video' => 'Ogg $1 ملف فيديو، $2',
	'ogg-short-general' => 'Ogg $1 ملف ميديا، $2',
	'ogg-long-audio' => '(Ogg $1 ملف صوت، الطول $2، $3)',
	'ogg-long-video' => 'Ogg $1 ملف فيديو، الطول $2، $4×$5 بكسل، $3',
	'ogg-long-multiplexed' => '(ملف Ogg مالتي بليكسد أوديو/فيديو، $1، الطول $2، $4×$5 بكسل، $3 إجمالي)',
	'ogg-long-general' => '(ملف ميديا Ogg، الطول $2، $3)',
	'ogg-long-error' => '(ملف Ogg غير صحيح: $1)',
	'ogg-play' => 'شغّل',
	'ogg-pause' => 'ألبث',
	'ogg-stop' => 'أوقف',
	'ogg-play-video' => 'شغّل الفيديو',
	'ogg-play-sound' => 'شغّل الصوت',
	'ogg-no-player' => 'معذرة ولكن يبدو أنه لا يوجد لديك برنامج عرض مدعوم. من فضلك ثبت <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">الجافا</a>.',
	'ogg-no-xiphqt' => 'لا يبدو أنك تملك مكون XiphQT لكويك تايم.
كويك تايم لا يمكنه عرض ملفات Ogg بدون هذا المكون.
من فضلك <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">حمل XiphQT</a> أو اختر برنامجا آخر.',
	'ogg-player-videoElement' => 'دعم متصفح مدمج',
	'ogg-player-oggPlugin' => 'إضافة متصفح',
	'ogg-player-cortado' => 'كورتادو (جافا)',
	'ogg-player-vlc-mozilla' => 'في إل سي',
	'ogg-player-vlc-activex' => 'في إل سي (أكتيف إكس)',
	'ogg-player-quicktime-mozilla' => 'كويك تايم',
	'ogg-player-quicktime-activex' => 'كويك تايم (أكتيف إكس)',
	'ogg-player-totem' => 'توتيم',
	'ogg-player-kmplayer' => 'كيه إم بلاير',
	'ogg-player-kaffeine' => 'كافيين',
	'ogg-player-mplayerplug-in' => 'إضافة إم بلاير',
	'ogg-player-thumbnail' => 'ما زال صورة فقط',
	'ogg-player-soundthumb' => 'لا يوجد مشغل',
	'ogg-player-selected' => '(مختار)',
	'ogg-use-player' => 'استخدم البرنامج:',
	'ogg-more' => 'المزيد...',
	'ogg-dismiss' => 'أغلق',
	'ogg-download' => 'نزّل الملف',
	'ogg-desc-link' => 'عن هذا الملف',
	'ogg-oggThumb-version' => 'OggHandler يتطلب الإصدار oggThumb $1 أو في وقت لاحق.',
	'ogg-oggThumb-failed' => 'فشل في إنشاء المصغرات',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'ogg-player-soundthumb' => 'ܠܝܬ ܛܐܠܢܐ',
	'ogg-more' => 'ܝܬܝܪ…',
	'ogg-download' => 'ܐܚܬ ܠܦܦܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author AVRS
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'ogg-desc' => 'متحكم لملفات أو جى جى ثيورا و فوربيس، مع بلاير جافاسكريبت',
	'ogg-short-audio' => 'Ogg $1 ملف صوت، $2',
	'ogg-short-video' => 'Ogg $1 ملف فيديو, $2',
	'ogg-short-general' => 'Ogg $1 ملف ميديا، $2',
	'ogg-long-audio' => '(Ogg $1 ملف صوت، الطول $2، $3)',
	'ogg-long-video' => 'Ogg $1 ملف فيديو، الطول $2، $4×$5 بكسل، $3',
	'ogg-long-multiplexed' => '(ملف Ogg مالتى بليكسد أوديو/فيديو، $1، الطول $2، $4×$5 بكسل، $3 إجمالي)',
	'ogg-long-general' => '(ملف ميديا Ogg، الطول $2، $3)',
	'ogg-long-error' => '(ملف ogg مش صحيح: $1)',
	'ogg-play' => 'شغل',
	'ogg-pause' => ' توقيف مؤقت',
	'ogg-stop' => 'توقيف',
	'ogg-play-video' => 'شغل الفيديو',
	'ogg-play-sound' => 'شغل الصوت',
	'ogg-no-player' => 'متاسفين الظاهر أنه ماعندكش برنامج عرض مدعوم.
لو سمحت تنزل < a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">الجافا</a>.',
	'ogg-no-xiphqt' => 'الظاهر انه ماعندكش مكون الـ XiphQT لكويك تايم.
كويك تايم مش ممكن يعرض ملفات Ogg  من غير المكون دا.
لو سمحت <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">تنزل XiphQT</a> أو تختار برنامج تانى.',
	'ogg-player-videoElement' => 'دعم البراوزر الاصلي',
	'ogg-player-oggPlugin' => 'اضافة براوزر',
	'ogg-player-cortado' => 'كورتادو (جافا)',
	'ogg-player-vlc-mozilla' => 'فى إل سي',
	'ogg-player-vlc-activex' => 'فى إل سى (أكتيف إكس)',
	'ogg-player-quicktime-mozilla' => 'كويك تايم',
	'ogg-player-quicktime-activex' => 'كويك تايم (أكتيف إكس)',
	'ogg-player-totem' => 'توتيم',
	'ogg-player-kmplayer' => 'كيه إم بلاير',
	'ogg-player-kaffeine' => 'كافيين',
	'ogg-player-mplayerplug-in' => 'إضافة إم بلاير',
	'ogg-player-thumbnail' => 'صورة ثابتة بس',
	'ogg-player-soundthumb' => 'ما فيش برنامج',
	'ogg-player-selected' => '(مختار)',
	'ogg-use-player' => 'استخدم البرنامج:',
	'ogg-more' => 'أكتر...',
	'ogg-dismiss' => 'اقفل',
	'ogg-download' => 'نزل الملف',
	'ogg-desc-link' => 'عن الملف دا',
);

/** Asturian (Asturianu)
 * @author AVRS
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'ogg-desc' => "Remanador d'archivos Ogg Theora y Vorbis, con un reproductor JavaScript",
	'ogg-short-audio' => 'Archivu de soníu ogg $1, $2',
	'ogg-short-video' => 'Ficheru de videu ogg $1, $2',
	'ogg-short-general' => 'Archivu multimedia ogg $1, $2',
	'ogg-long-audio' => '(Archivu de soníu ogg $1, llonxitú $2, $3)',
	'ogg-long-video' => 'Archivu de videu ogg $1, llonxitú $2, $4×$5 píxeles, $3',
	'ogg-long-multiplexed' => "(Archivu d'audiu/videu ogg multiplexáu, $1, llonxitú $2, $4×$5 píxeles, $3)",
	'ogg-long-general' => '(Archivu multimedia ogg, llonxitú $2, $3)',
	'ogg-long-error' => '(Archivu ogg non válidu: $1)',
	'ogg-play' => 'Reproducir',
	'ogg-pause' => 'Pausar',
	'ogg-stop' => 'Aparar',
	'ogg-play-video' => 'Reproducir videu',
	'ogg-play-sound' => 'Reproducir soníu',
	'ogg-no-player' => 'Sentímoslo, el to sistema nun paez tener nengún de los reproductores soportaos. Por favor <a
href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descarga un reproductor</a>.',
	'ogg-no-xiphqt' => 'Paez que nun tienes el componente XiphQT pa QuickTime. QuickTime nun pue reproducr archivos ogg ensin esti componente. Por favor <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descarga XiphQT</a> o escueyi otru reproductor.',
	'ogg-player-videoElement' => 'Soporte nativu del navegador',
	'ogg-player-oggPlugin' => 'Plugin del navegador',
	'ogg-player-thumbnail' => 'Namái imaxe en pausa',
	'ogg-player-soundthumb' => 'Nun hai reproductor',
	'ogg-player-selected' => '(seleicionáu)',
	'ogg-use-player' => 'Utilizar el reproductor:',
	'ogg-more' => 'Más...',
	'ogg-dismiss' => 'Zarrar',
	'ogg-download' => 'Descargar archivu',
	'ogg-desc-link' => 'Tocante a esti archivu',
	'ogg-oggThumb-version' => 'OggHandler requier oggThumb version $1 o mayor.',
	'ogg-oggThumb-failed' => 'oggThumb nun pudo crear la miniatura.',
);

/** Kotava (Kotava)
 * @author Sab
 */
$messages['avk'] = array(
	'ogg-download' => 'Iyeltakkalvajara',
	'ogg-desc-link' => 'Icde bat iyeltak',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 * @author Vugar 1981
 */
$messages['az'] = array(
	'ogg-play' => 'Başla',
	'ogg-pause' => 'Fasilə',
	'ogg-stop' => 'Dur',
	'ogg-play-video' => 'Videonu başla',
	'ogg-play-sound' => 'Səsi başla',
	'ogg-player-cortado' => 'Cortado (Java)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (ActiveX)',
	'ogg-player-quicktime-mozilla' => 'QuickTime',
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-kaffeine' => 'Kaffeine',
	'ogg-player-mplayerplug-in' => 'mplayerplug-in',
	'ogg-player-selected' => '(seçildi)',
	'ogg-more' => 'Çox…',
	'ogg-dismiss' => 'Bağla',
	'ogg-download' => 'Fayl yüklə',
);

/** Bashkir (Башҡортса)
 * @author Haqmar
 * @author Рустам Нурыев
 */
$messages['ba'] = array(
	'ogg-desc' => 'Ogg Theora һәм Vorbis файлдарын JavaScript-уйнатыусы ҡулланған эшкәртеүсе',
	'ogg-short-audio' => 'Тауыш файлы Ogg $1, $2',
	'ogg-short-video' => 'Видео-файл Ogg $1, $2',
	'ogg-short-general' => 'Медиа-файл Ogg $1, $2',
	'ogg-long-audio' => '(тауыш файлы Ogg $1, оҙонлоҡ $2, $3)',
	'ogg-long-video' => 'видео-файл Ogg $1, оҙонлоҡ $2, $4×$5 {{PLURAL:$5|пиксель}}, $3',
	'ogg-long-multiplexed' => 'мультиплекс аудио/видео-файл Ogg, $1, оҙонлоҡ $2, $4×$5 {{PLURAL:$5|пиксель}}, барыһы $3',
	'ogg-long-general' => '(медиа-файл Ogg, оҙонлоҡ $2, $3)',
	'ogg-long-error' => '(яңылыш ogg-файл: $1)',
	'ogg-play' => 'Уйнатырға',
	'ogg-pause' => 'Туҡтатып тору',
	'ogg-stop' => 'Туҡтатыу',
	'ogg-play-video' => 'Видеояҙманы ҡарау',
	'ogg-play-sound' => 'Көйҙе тыңлау',
	'ogg-no-player' => 'Ғәфү итегеҙ, ләкин һеҙнең системағыҙ был файлдар төрен аса алмай, зинһар кәрәк булған программаларҙы  <ahref="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">үҙегеҙгә күсереп алыгыҙ</a>.',
	'ogg-player-oggPlugin' => 'Ogg модуль',
	'ogg-player-thumbnail' => 'Хәрәкәтһеҙ рәсем генә',
	'ogg-player-soundthumb' => 'Уйнатыусы юҡ',
	'ogg-player-selected' => '(һайланған)',
	'ogg-use-player' => 'Ҡулланыласаҡ уйнатыусы:',
	'ogg-more' => 'Тағы...',
	'ogg-dismiss' => 'Ябырға',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'ogg-desc' => 'دسگیره په فایلان Ogg Theora و Vorbis, گون پخش کنوک جاوا اسکرسیپت',
	'ogg-short-audio' => 'فایل صوتی Ogg $1، $2',
	'ogg-short-video' => 'فایل تصویری Ogg $1، $2',
	'ogg-short-general' => 'فایل مدیا Ogg $1، $2',
	'ogg-long-audio' => '(اوجی جی  $1 فایل صوتی, طول $2, $3)',
	'ogg-long-video' => 'اوجی جی $1 فایل ویدیو, طول $2, $4×$5 پیکسل, $3',
	'ogg-long-multiplexed' => '(اوجی جی چند دابی فایل صوت/تصویر, $1, طول $2, $4×$5 پیکسل, $3 کل)',
	'ogg-long-general' => '(اوجی جی فایل مدیا, طول $2, $3)',
	'ogg-long-error' => '(نامعتبرین فایل اوجی جی: $1)',
	'ogg-play' => 'پخش',
	'ogg-pause' => 'توقف',
	'ogg-stop' => 'بند',
	'ogg-play-video' => 'پخش ویدیو',
	'ogg-play-sound' => 'پخش توار',
	'ogg-no-player' => 'شرمنده،شمی سیستم جاه کیت که هچ برنامه حمایتی پخش کنوک نیست.
لطفا <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download"> یک پخش کنوکی ای گیزیت</a>.',
	'ogg-no-xiphqt' => 'چوش جاه کیت که شما را جز XiphQTپه کویک تایم نیست.
کویک تایم بی ای جز نه تونیت فایلان اوجی جی بوانیت.
لطف <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ایرگیزیت XiphQT</a> یا دگه وانوکی انتخاب کنیت.',
	'ogg-player-videoElement' => '<video> جزء',
	'ogg-player-oggPlugin' => ' پلاگین اوجی جی',
	'ogg-player-cortado' => 'کارتادو(جاوا)',
	'ogg-player-vlc-mozilla' => 'وی ال سی',
	'ogg-player-vlc-activex' => 'VLC (ActiveX)وی ال سی',
	'ogg-player-quicktime-mozilla' => 'کویک تایم',
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX) کویک تایم',
	'ogg-player-thumbnail' => 'هنگت فقط عکس',
	'ogg-player-soundthumb' => 'هچ پخش کنوک',
	'ogg-player-selected' => '(انتخابی)',
	'ogg-use-player' => 'استفاده کن پخش کنوک',
	'ogg-more' => 'گیشتر...',
	'ogg-dismiss' => 'بندگ',
	'ogg-download' => 'ایرگیزگ فایل',
	'ogg-desc-link' => 'ای فایل باره',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'ogg-more' => 'Dakol pa..',
	'ogg-dismiss' => 'Isara',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'ogg-dismiss' => 'Закрыць',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author AVRS
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'ogg-desc' => 'Апрацоўшчык файлаў Ogg Theora і Vorbis з прайгравальнікам JavaScript',
	'ogg-short-audio' => 'Аўдыё-файл Ogg $1, $2',
	'ogg-short-video' => 'Відэа-файл у фармаце Ogg $1, $2',
	'ogg-short-general' => 'Мэдыяфайл Ogg $1, $2',
	'ogg-long-audio' => '(аўдыё-файл Ogg $1, даўжыня $2, $3)',
	'ogg-long-video' => 'відэа-файл Ogg $1, даўжыня $2, $4×$5 піксэляў, $3',
	'ogg-long-multiplexed' => '(мультыплексны аўдыё/відэа-файл Ogg, $1, даўжыня $2, $4×$5 піксэляў, усяго $3)',
	'ogg-long-general' => '(мэдыяфайл Ogg, даўжыня $2, $3)',
	'ogg-long-error' => '(Няслушны файл у фармаце Ogg: $1)',
	'ogg-play' => 'Прайграць',
	'ogg-pause' => 'Паўза',
	'ogg-stop' => 'Спыніць',
	'ogg-play-video' => 'Прайграць відэа',
	'ogg-play-sound' => 'Прайграць аўдыё',
	'ogg-no-player' => 'Прабачце, Ваша сыстэма ня мае неабходнага праграмнага забесьпячэньня для прайграваньня файлаў. Калі ласка, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">загрузіце прайгравальнік</a>.',
	'ogg-no-xiphqt' => 'Адсутнічае кампанэнт  XiphQT для QuickTime.
QuickTime ня можа прайграваць файлы ў фармаце Ogg бяз гэтага кампанэнта.
Калі ласка, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">загрузіце XiphQT</a> альбо выберыце іншы прайгравальнік.',
	'ogg-player-videoElement' => 'Убудаваная падтрымка браўзэра',
	'ogg-player-oggPlugin' => 'Плагін для браўзэра',
	'ogg-player-thumbnail' => 'Толькі нерухомая выява',
	'ogg-player-soundthumb' => 'Няма прайгравальніка',
	'ogg-player-selected' => '(выбраны)',
	'ogg-use-player' => 'Выкарыстоўваць прайгравальнік:',
	'ogg-more' => 'Болей…',
	'ogg-dismiss' => 'Зачыніць',
	'ogg-download' => 'Загрузіць файл',
	'ogg-desc-link' => 'Інфармацыя пра гэты файл',
	'ogg-oggThumb-version' => 'OggHandler патрабуе oggThumb вэрсіі $1 ці больш позьняй.',
	'ogg-oggThumb-failed' => 'oggThumb не атрымалася стварыць мініятуру.',
);

/** Bulgarian (Български)
 * @author AVRS
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'ogg-desc' => 'Приложение за файлове тип Ogg Theora и Vorbis, с плейър на JavaScript',
	'ogg-short-audio' => 'Ogg $1 звуков файл, $2',
	'ogg-short-video' => 'Ogg $1 видео файл, $2',
	'ogg-long-audio' => '(Ogg $1 звуков файл, продължителност $2, $3)',
	'ogg-long-video' => 'Ogg $1 видео файл, продължителност $2, $4×$5 пиксела, $3',
	'ogg-long-general' => '(Мултимедиен файл в ogg формат с дължина $2, $3)',
	'ogg-long-error' => '(Невалиден ogg файл: $1)',
	'ogg-play' => 'Пускане',
	'ogg-pause' => 'Пауза',
	'ogg-stop' => 'Спиране',
	'ogg-play-video' => 'Пускане на видео',
	'ogg-play-sound' => 'Пускане на звук',
	'ogg-no-player' => 'Съжаляваме, но на вашия компютър изглежда няма някой от поддържаните плейъри.
Моля <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">изтеглете си плейър</a>.',
	'ogg-no-xiphqt' => 'Изглежда нямате инсталиран компонента XiphQT за QuickTime.
Без този компонент, QuickTime не може да пуска файлове във формат Ogg.
Моля, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">свалете си XiphQT</a> или изберете друго приложение.',
	'ogg-player-videoElement' => 'Локална поддръжка от браузъра',
	'ogg-player-oggPlugin' => 'Плъгин към браузъра',
	'ogg-player-thumbnail' => 'Само неподвижни изображения',
	'ogg-player-soundthumb' => 'Няма плеър',
	'ogg-player-selected' => '(избран)',
	'ogg-use-player' => 'Ползване на плеър:',
	'ogg-more' => 'Повече...',
	'ogg-dismiss' => 'Затваряне',
	'ogg-download' => 'Изтегляне на файла',
	'ogg-desc-link' => 'Информация за файла',
);

/** Bengali (বাংলা)
 * @author AVRS
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'ogg-short-audio' => 'অগ $1 সাউন্ড ফাইল, $2',
	'ogg-short-video' => 'অগ $1 ভিডিও ফাইল, $2',
	'ogg-short-general' => 'অগ $1 মিডিয়া ফাইল, $2',
	'ogg-long-audio' => '(অগ $1 সাউন্ড ফাইল, দৈর্ঘ্য $2, $3)',
	'ogg-long-video' => 'অগ $1 ভিডিও ফাইল, দৈর্ঘ্য $2, $4×$5 পিক্সেল, $3',
	'ogg-long-multiplexed' => '(অগ মাল্টিপ্লেক্সকৃত অডিও/ভিডিও ফাইল, $1, দৈর্ঘ্য $2, $4×$5 পিক্সেল, $3 সামগ্রিক)',
	'ogg-long-general' => '(অগ মিডিয়া ফাইল, দৈর্ঘ্য $2, $3)',
	'ogg-long-error' => '(অবৈধ অগ ফাইল: $1)',
	'ogg-play' => 'চালানো হোক',
	'ogg-pause' => 'বিরতি',
	'ogg-stop' => 'বন্ধ',
	'ogg-play-video' => 'ভিডিও চালানো হোক',
	'ogg-play-sound' => 'অডিও চালানো হোক',
	'ogg-no-player' => 'দুঃখিত, আপনার কম্পিউটারে ফাইলটি চালনার জন্য কোন সফটওয়্যার নেই। অনুগ্রহ করে <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">চালনাকারী সফটওয়্যার ডাউনলোড করুন</a>।',
	'ogg-no-xiphqt' => 'আপনার কুইকটাইম সফটওয়্যারটিতে XiphQT উপাদানটি নেই। এই উপাদানটি ছাড়া কুইকটাইম অগ ফাইল চালাতে পারবে না। অনুগ্রহ করে <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT ডাউনলোড করুন</a> অথবা অন্য একটি চালনাকারী সফটওয়্যার ব্যবহার করুন।',
	'ogg-player-videoElement' => 'স্থানীয় ব্রাউজার সাপোর্ট',
	'ogg-player-oggPlugin' => 'ব্রাউজার প্লাগ-ইন',
	'ogg-player-thumbnail' => 'শুধুমাত্র স্থির চিত্র',
	'ogg-player-soundthumb' => 'কোন চালনাকারী সফটওয়্যার নেই',
	'ogg-player-selected' => '(নির্বাচিত)',
	'ogg-use-player' => 'এই চালনাকারী সফটওয়্যার ব্যবহার করুন:',
	'ogg-more' => 'আরও...',
	'ogg-dismiss' => 'বন্ধ',
	'ogg-download' => 'ফাইল ডাউনলোড করুন',
	'ogg-desc-link' => 'এই ফাইলের বৃত্তান্ত',
);

/** Breton (Brezhoneg)
 * @author AVRS
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'ogg-desc' => 'Skor evit ar restroù Ogg Theora ha Vorbis, gant ul lenner JavaScript',
	'ogg-short-audio' => 'Restr son Ogg $1, $2',
	'ogg-short-video' => 'Restr video Ogg $1, $2',
	'ogg-short-general' => 'Restr media Ogg $1, $2',
	'ogg-long-audio' => '(Restr son Ogg $1, pad $2, $3)',
	'ogg-long-video' => 'Restr video Ogg $1, pad $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Restr Ogg klevet/video liesplezhet $1, pad $2, $4×$5 piksel, $3 hollad)',
	'ogg-long-general' => '(Restr media Ogg, pad $2, $3)',
	'ogg-long-error' => '(Restr ogg direizh : $1)',
	'ogg-play' => 'Lenn',
	'ogg-pause' => 'Ehan',
	'ogg-stop' => 'Paouez',
	'ogg-play-video' => 'Lenn ar video',
	'ogg-play-sound' => 'Lenn ar son',
	'ogg-no-player' => 'Evit doare n\'eus gant ho reizhiad hini ebet eus al lennerioù skoret.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Pellgargit ul lenner skoret</a> mar plij.',
	'ogg-no-xiphqt' => 'Evit doare e vank deoc\'h ar parzh XiphQT evit QuickTime.
N\'hall ket QuickTime lenn ar restroù Ogg files hep ar parzh-se.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Pellgargit XiphQT</a> pe dibabit ul lenner all.',
	'ogg-player-videoElement' => 'Skor ar merdeer orin',
	'ogg-player-oggPlugin' => 'Adveziant ar merdeer',
	'ogg-player-thumbnail' => 'Skeudenn statek hepken',
	'ogg-player-soundthumb' => 'Lenner ebet',
	'ogg-player-selected' => '(diuzet)',
	'ogg-use-player' => 'Ober gant al lenner :',
	'ogg-more' => "Muioc'h...",
	'ogg-dismiss' => 'Serriñ',
	'ogg-download' => 'Pellgargañ ar restr',
	'ogg-desc-link' => 'Diwar-benn ar restr-mañ',
	'ogg-oggThumb-version' => "Rekis eo stumm $1 oggThumb, pe nevesoc'h, evit implijout OggHandler.",
	'ogg-oggThumb-failed' => "N'eo ket deuet a-benn oggThumb da grouiñ ar munud.",
);

/** Bosnian (Bosanski)
 * @author AVRS
 * @author CERminator
 */
$messages['bs'] = array(
	'ogg-desc' => 'Upravljač za Ogg Theora i Vorbis datotekem sa JavaScript preglednikom',
	'ogg-short-audio' => 'Ogg $1 zvučna datoteka, $2',
	'ogg-short-video' => 'Ogg $1 video datoteka, $2',
	'ogg-short-general' => 'Ogg $1 medijalna datoteka, $2',
	'ogg-long-audio' => '(Ogg $1 zvučna datoteka, dužina $2, $3)',
	'ogg-long-video' => 'Ogg $1 video datoteka, dužina $2, $4×$5 piksela, $3',
	'ogg-long-multiplexed' => '(Ogg multipleksna zvučna/video datoteka, $1, dužina $2, $4×$5 piksela, $3 sveukupno)',
	'ogg-long-general' => '(Ogg medijalna datoteka, dužina $2, $3)',
	'ogg-long-error' => '(Nevaljana ogg datoteka: $1)',
	'ogg-play' => 'Pokreni',
	'ogg-pause' => 'Pauza',
	'ogg-stop' => 'Zaustavi',
	'ogg-play-video' => 'Pokreni video',
	'ogg-play-sound' => 'Sviraj zvuk',
	'ogg-no-player' => 'Žao nam je, Vaš sistem izgleda da nema nikakvog podržanog softvera za pregled.
Molimo Vas <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">da skinete preglednik</a>.',
	'ogg-no-xiphqt' => 'Izgleda da nemate XiphQT komponentu za program QuickTime.
QuickTime ne može reproducirati Ogg datoteke bez ove komponente.
Molimo Vas da <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">skinete XiphQT</a> ili da odaberete drugi preglednik.',
	'ogg-player-videoElement' => 'Prirodna podrška preglednika',
	'ogg-player-oggPlugin' => 'Dodatak pregledniku',
	'ogg-player-thumbnail' => 'Samo mirne slike',
	'ogg-player-soundthumb' => 'Nema preglednika',
	'ogg-player-selected' => '(odabrano)',
	'ogg-use-player' => 'Koristi svirač:',
	'ogg-more' => 'Više...',
	'ogg-dismiss' => 'Zatvori',
	'ogg-download' => 'Učitaj datoteku',
	'ogg-desc-link' => 'O ovoj datoteci',
	'ogg-oggThumb-version' => 'OggHandler zahtijeva oggThumb verziju $1 ili kasniju.',
	'ogg-oggThumb-failed' => 'oggThumb nije uspio napraviti smanjeni pregled.',
);

/** Catalan (Català)
 * @author AVRS
 * @author Aleator
 * @author Paucabot
 * @author SMP
 * @author Toniher
 * @author Vriullop
 */
$messages['ca'] = array(
	'ogg-desc' => 'Gestor de fitxers Ogg Theora i Vorbis, amb reproductor de Javascript',
	'ogg-short-audio' => "Fitxer OGG d'àudio $1, $2",
	'ogg-short-video' => 'Fitxer OGG de vídeo $1, $2',
	'ogg-short-general' => 'Fitxer multimèdia OGG $1, $2',
	'ogg-long-audio' => '(Ogg $1 fitxer de so, llargada $2, $3)',
	'ogg-long-video' => 'Fitxer OGG de vídeo $1, llargada $2, $4×$5 píxels, $3',
	'ogg-long-multiplexed' => '(Arxiu àudio/vídeo multiplex, $1, llargada $2, $4×$5 píxels, $3 de mitjana)',
	'ogg-long-general' => '(Fitxer multimèdia OGG, llargada $2, $3)',
	'ogg-long-error' => '(Fitxer OGG invàlid: $1)',
	'ogg-play' => 'Reprodueix',
	'ogg-pause' => 'Pausa',
	'ogg-stop' => 'Atura',
	'ogg-play-video' => 'Reprodueix vídeo',
	'ogg-play-sound' => 'Reprodueix so',
	'ogg-no-player' => 'No teniu instaŀlat cap reproductor acceptat. Podeu <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descarregar-ne</a> un.',
	'ogg-no-xiphqt' => 'No disposeu del component XiphQT al vostre QuickTime. Aquest component és imprescindible per a que el QuickTime pugui reproduir fitxers OGG. Podeu <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descarregar-lo</a> o escollir un altre reproductor.',
	'ogg-player-videoElement' => 'Suport natiu del navegador',
	'ogg-player-oggPlugin' => 'Connector del navegador',
	'ogg-player-thumbnail' => 'Només un fotograma',
	'ogg-player-soundthumb' => 'Cap reproductor',
	'ogg-player-selected' => '(seleccionat)',
	'ogg-use-player' => 'Usa el reproductor:',
	'ogg-more' => 'Més...',
	'ogg-dismiss' => 'Tanca',
	'ogg-download' => 'Descarrega el fitxer',
	'ogg-desc-link' => 'Informació del fitxer',
	'ogg-oggThumb-version' => "L'OggHandler necessita l'oggThumb versió $1 o posterior.",
	'ogg-oggThumb-failed' => "L'oggThumb no ha pogut crear una miniatura.",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'ogg-dismiss' => 'Къайлайаккха',
	'ogg-download' => 'Чуйаккха хlум',
);

/** Sorani (کوردی)
 * @author Asoxor
 */
$messages['ckb'] = array(
	'ogg-more' => 'زیاتر',
	'ogg-dismiss' => 'بەستن',
);

/** Czech (Česky)
 * @author AVRS
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'ogg-desc' => 'Obsluha souborů Ogg Theora a Vorbis s JavaScriptovým přehrávačem',
	'ogg-short-audio' => 'Zvukový soubor ogg $1, $2',
	'ogg-short-video' => 'Videosoubor ogg $1, $2',
	'ogg-short-general' => 'Soubor média ogg $1, $2',
	'ogg-long-audio' => '(Zvukový soubor ogg $1, délka $2, $3)',
	'ogg-long-video' => 'Videosoubor $1, délka $2, $4×$5 pixelů, $3',
	'ogg-long-multiplexed' => 'Audio/video soubor ogg, $1, délka $2, $4×$5 pixelů, celkem $3',
	'ogg-long-general' => '(Soubor média ogg, délka $2, $3)',
	'ogg-long-error' => '(Chybný soubor ogg: $1)',
	'ogg-play' => 'Přehrát',
	'ogg-pause' => 'Pozastavit',
	'ogg-stop' => 'Zastavit',
	'ogg-play-video' => 'Přehrát video',
	'ogg-play-sound' => 'Přehrát zvuk',
	'ogg-no-player' => 'Váš systém zřejmě neobsahuje žádný podporovaný přehrávač. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Váš systém zřejmě neobsahuje žádný podporovaný přehrávač. </a>.',
	'ogg-no-xiphqt' => 'Nemáte rozšíření XiphQT pro QuickTime. QuickTime nemůže přehrávat soubory ogg bez tohoto rozšíření. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Stáhněte XiphQT</a> nebo vyberte jiný přehrávač.',
	'ogg-player-videoElement' => 'Vestavěná podpora v prohlížeči',
	'ogg-player-oggPlugin' => 'Zásuvný modul do prohlížeče',
	'ogg-player-thumbnail' => 'Pouze snímek náhledu',
	'ogg-player-soundthumb' => 'Žádný přehrávač',
	'ogg-player-selected' => '(zvoleno)',
	'ogg-use-player' => 'Vyberte přehrávač:',
	'ogg-more' => 'Více...',
	'ogg-dismiss' => 'Zavřít',
	'ogg-download' => 'Stáhnout soubor',
	'ogg-desc-link' => 'O tomto souboru',
	'ogg-oggThumb-version' => 'OggHandler vyžaduje oggThumb verze $1 nebo novější.',
	'ogg-oggThumb-failed' => 'oggThumb nedokázal vytvořit náhled.',
);

/** Welsh (Cymraeg)
 * @author AVRS
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'ogg-desc' => 'Trinydd ffeiliau Ogg Theora a Vorbis, gyda chwaraewr JavaScript',
	'ogg-short-audio' => 'Ffeil sain Ogg $1, $2',
	'ogg-short-video' => 'Ffeil fideo Ogg $1, $2',
	'ogg-short-general' => 'Ffeil gyfrwng Ogg $1, $2',
	'ogg-long-audio' => '(Ffeil sain Ogg $1, o hyd $2, $3)',
	'ogg-long-video' => 'Ffeil fideo Ogg $1, o hyd $2, $4×$5 picsel, $3',
	'ogg-long-multiplexed' => '(Ffeil sain/fideo amlbleth Ogg, $1, o hyd $2, $4×$5 picsel, $3 o ben i ben)',
	'ogg-long-general' => '(Ffeil gyfrwng Ogg, o hyd $2, $3)',
	'ogg-long-error' => '(Ffeil OGG annilys: $1)',
	'ogg-play' => 'Chwarae',
	'ogg-pause' => 'Oedi',
	'ogg-stop' => 'Aros',
	'ogg-play-video' => "Chwarae'r fideo",
	'ogg-play-sound' => 'Gwrando',
	'ogg-no-player' => 'Mae\'n ddrwg gennym, mae\'n debyg nad oes unrhyw feddalwedd chwaraewr a gefnogir ar eich system. 
Byddwch gystal à <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">lawrlwytho chwaraewr</a>.',
	'ogg-no-xiphqt' => 'Ymddengys nad yw\'r gydran XiphQT ar gyfer QuickTime gennych.
Ni all QuickTime chwarae ffeiliau Ogg heb y gydran hon.
Os gwelwch yn dda, a wnewch chi <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">lawrlwytho XiphQT</a> neu ddewis chwaraewr arall.',
	'ogg-player-videoElement' => 'Cynhaliad porwr ar gael yn barod',
	'ogg-player-oggPlugin' => 'Ategyn porwr',
	'ogg-player-thumbnail' => 'Llun llonydd yn unig',
	'ogg-player-soundthumb' => 'Dim chwaraewr',
	'ogg-player-selected' => '(dethol)',
	'ogg-use-player' => 'Dewis chwaraewr:',
	'ogg-more' => 'Mwy...',
	'ogg-dismiss' => 'Cau',
	'ogg-download' => 'Islwytho ffeil',
	'ogg-desc-link' => "Ynglŷn â'r ffeil hon",
	'ogg-oggThumb-version' => 'Mae ar OggHandler angen fersiwn $1 o oggThumb (neu fersiwn diweddarach).',
	'ogg-oggThumb-failed' => "Methodd oggThumb â chynhyrchu'r mân-lun.",
);

/** Danish (Dansk)
 * @author AVRS
 * @author Byrial
 * @author Jon Harald Søby
 * @author Peter Alberti
 */
$messages['da'] = array(
	'ogg-desc' => 'Understøtter Ogg Theora- og Vorbis-filer med en JavaScript-afspiller.',
	'ogg-short-audio' => 'Ogg $1 lydfil, $2',
	'ogg-short-video' => 'Ogg $1 videofil, $2',
	'ogg-short-general' => 'Ogg $1 mediafil, $2',
	'ogg-long-audio' => '(Ogg $1 lydfil, længde $2, $3)',
	'ogg-long-video' => 'Ogg $1 videofil, længde $2, $4×$5 pixel, $3',
	'ogg-long-multiplexed' => '(Sammensat ogg-lyd- og -videofil, $1, længde $2, $4×$5 pixel, $3 samlet)',
	'ogg-long-general' => '(Ogg mediafil, længde $2, $3)',
	'ogg-long-error' => '(Ugyldig ogg-fil: $1)',
	'ogg-play' => 'Afspil',
	'ogg-pause' => 'Pause',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Afspil video',
	'ogg-play-sound' => 'Afspil lyd',
	'ogg-no-player' => 'Desværre ser det ud til at dit system har nogen understøttede medieafspillere.
<a href="http://mediawiki.org/wiki/Extension:OggHandler/Client_download">Download venligst en afspiller</a>.',
	'ogg-no-xiphqt' => 'Det ser ud til at du ikke har XiphQT-komponenten til QuickTime.
QuickTime kan ikke afspille Ogg-file uden denne komponent.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Download venligst XiphQT</a> eller vælg en anden afspiller.',
	'ogg-player-videoElement' => 'Indbygget browserunderstøttelse',
	'ogg-player-oggPlugin' => 'Browsertilføjelse',
	'ogg-player-thumbnail' => 'Kun stillbilleder',
	'ogg-player-soundthumb' => 'Ingen afspiller',
	'ogg-player-selected' => '(valgt)',
	'ogg-use-player' => 'Brug afspiller:',
	'ogg-more' => 'Mere...',
	'ogg-dismiss' => 'Luk',
	'ogg-download' => 'Download fil',
	'ogg-desc-link' => 'Om denne fil',
	'ogg-oggThumb-version' => 'OggHandler kræver oggThumb version $1 eller nyere.',
	'ogg-oggThumb-failed' => 'oggThumb kunne ikke oprette et miniaturebillede.',
);

/** German (Deutsch)
 * @author AVRS
 * @author Kghbln
 * @author Leithian
 * @author Metalhead64
 * @author MichaelFrey
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'ogg-desc' => 'Stellt ein Steuerungsprogramm, einschließlich einer JavaScript-gestützten Abspielsoftware, für Ogg Theora- und Ogg Vorbis-Dateien bereit',
	'ogg-short-audio' => 'Ogg-$1-Audiodatei, $2',
	'ogg-short-video' => 'Ogg-$1-Videodatei, $2',
	'ogg-short-general' => 'Ogg-$1-Mediadatei, $2',
	'ogg-long-audio' => '(Ogg-$1-Audiodatei, Länge: $2, $3)',
	'ogg-long-video' => 'Ogg-$1-Videodatei, Länge: $2, $4×$5 Pixel, $3',
	'ogg-long-multiplexed' => '(Ogg-Audio-/Video-Datei, $1, Länge: $2, $4×$5 Pixel, $3)',
	'ogg-long-general' => '(Ogg-Mediadatei, Länge: $2, $3)',
	'ogg-long-error' => '(Ungültige Ogg-Datei: $1)',
	'ogg-play' => 'Start',
	'ogg-pause' => 'Pause',
	'ogg-stop' => 'Stopp',
	'ogg-play-video' => 'Video abspielen',
	'ogg-play-sound' => 'Audio abspielen',
	'ogg-no-player' => 'Das System scheint über keine Abspielsoftware zu verfügen. Bitte <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">eine Abspielsoftware</a> installieren.',
	'ogg-no-xiphqt' => 'Das System scheint nicht über die XiphQT-Komponente für QuickTime zu verfügen. QuickTime kann ohne diese Komponente keine Ogg-Dateien abspielen. Bitte <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT</a> installieren oder eine andere Abspielsoftware wählen.',
	'ogg-player-videoElement' => 'Vorhandene Browserunterstützung',
	'ogg-player-oggPlugin' => 'Browser-Plugin',
	'ogg-player-thumbnail' => 'nur Vorschaubild',
	'ogg-player-soundthumb' => 'Kein Player',
	'ogg-player-selected' => '(ausgewählt)',
	'ogg-use-player' => 'Abspielsoftware:',
	'ogg-more' => 'Optionen …',
	'ogg-dismiss' => 'Schließen',
	'ogg-download' => 'Datei speichern',
	'ogg-desc-link' => 'Über diese Datei',
	'ogg-oggThumb-version' => 'OggHandler erfordert oggThumb in der Version $1 oder höher.',
	'ogg-oggThumb-failed' => 'oggThumb konnte kein Miniaturbild erstellen.',
);

/** Zazaki (Zazaki)
 * @author AVRS
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'ogg-desc' => 'Qe dosyayanê Ogg Theora u Vorbisî pê JavaScriptî qulp',
	'ogg-short-audio' => 'Ogg $1 dosyaya vengi, $2',
	'ogg-short-video' => 'Ogg $1 dosyaya filmi, $2',
	'ogg-short-general' => 'Ogg $1 dosyaya medyayi, $2',
	'ogg-long-audio' => '(Ogg $1 dosyaya medyayi,  mudde $2, $3)',
	'ogg-long-video' => 'Ogg $1 dosyaya filmi, mudde $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Ogg dosyaya filmi/vengi yo multiexed, $1, mudde $2, $4×$5 piksel, $3 bıumumi)',
	'ogg-long-general' => '(Ogg dosyaya medyayi, mudde $2, $3)',
	'ogg-long-error' => '(dosyaya oggi yo nemeqbul: $1)',
	'ogg-play' => "bıd' kaykerdış",
	'ogg-pause' => 'vındarn',
	'ogg-stop' => 'vındarn',
	'ogg-play-video' => "video bıd' kaykerdış",
	'ogg-play-sound' => "veng bıd' kaykerdış",
	'ogg-no-player' => 'ma meluli, wina aseno ke sistemê şıma wayirê softwareyi yo player niyo.
kerem kerê <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">yew player biyare war</a>.',
	'ogg-no-xiphqt' => 'qey QuickTimeyi wina aseno ke şıma wayirê parçeyê XiphQTi niyê.
heta ke parçeyê QuickTimeyi çinibi dosyayê Oggyi nêxebıtiyeni.
kerem kerê<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT\'i biyar war</a> ya zi yewna player bıvıcinê.',
	'ogg-player-videoElement' => 'destekê cıgêrayoxê mehelliyi',
	'ogg-player-oggPlugin' => 'zeylê cıgêrayoxi',
	'ogg-player-thumbnail' => 'hema têna resm o.',
	'ogg-player-soundthumb' => 'player çino',
	'ogg-player-selected' => '(vıciyaye)',
	'ogg-use-player' => 'player bışuxuln:',
	'ogg-more' => 'hema....',
	'ogg-dismiss' => 'bıqefeln',
	'ogg-download' => 'dosya biyar war',
	'ogg-desc-link' => 'derheqê dosyayi de',
	'ogg-oggThumb-version' => 'OggHandler rê oggThumb versiyon $1 ya zi newiyer lazim o.',
	'ogg-oggThumb-failed' => 'oggThumb nieskene thumbnail biviraze.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author AVRS
 * @author Michawiki
 */
$messages['dsb'] = array(
	'ogg-desc' => 'Wóźeński program za dataje Ogg Theora a Vprbis z JavaScriptowym wótegrawakom',
	'ogg-short-audio' => 'Ogg $1 awdiodataja, $2',
	'ogg-short-video' => 'Ogg $1 wideodataja, $2',
	'ogg-short-general' => 'Ogg $1 medijowa dataja, $2',
	'ogg-long-audio' => '(Ogg $1 awdiodataja, dłujkosć $2, $3)',
	'ogg-long-video' => 'Ogg $1 wideodataja, dłujkosć $2, $4×$5 pikselow, $3',
	'ogg-long-multiplexed' => '(ogg multipleksowa awdio-/wideodataja, $1, dłujkosć $2, $4×$5 pikselow, $3 dogromady)',
	'ogg-long-general' => '(Ogg medijowa dataja, dłujkosć $2, $3)',
	'ogg-long-error' => '(Njepłaśiwa ogg-dataja: $1)',
	'ogg-play' => 'Wótegraś',
	'ogg-pause' => 'Pśestank',
	'ogg-stop' => 'Stoj',
	'ogg-play-video' => 'Wideo wótegraś',
	'ogg-play-sound' => 'Zuk wótegraś',
	'ogg-no-player' => 'Wódaj, twój system njezda se pódpěrany wótegrawak měś.
Pšosym <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ześěgni wótegrawak</a>.',
	'ogg-no-xiphqt' => 'Zda se, až njamaš komponentu XiphQT za QuickTime.
QuickTime njamóžo ogg-dataje bźez toś teje komponenty wótegraś.
Pšosym <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Cient_download">ześěgni XiphQT</a> abo wubjeŕ drugi wótegrawak.',
	'ogg-player-videoElement' => 'Zatwarjona pódpěra pśez wobglědowak',
	'ogg-player-oggPlugin' => 'Tykac za wobglědowak',
	'ogg-player-thumbnail' => 'Jano njegibny wobraz',
	'ogg-player-soundthumb' => 'Žeden wótegrawak',
	'ogg-player-selected' => '(wubrany)',
	'ogg-use-player' => 'Wubjeŕ wótgrawak:',
	'ogg-more' => 'Wěcej...',
	'ogg-dismiss' => 'Zacyniś',
	'ogg-download' => 'Dataju ześěgnuś',
	'ogg-desc-link' => 'Wó toś tej dataji',
	'ogg-oggThumb-version' => 'OggHandler trjeba wersiju $1 oggThumb abo nowšu.',
	'ogg-oggThumb-failed' => 'oggThumb njejo mógł wobrazk napóraś.',
);

/** Greek (Ελληνικά)
 * @author AVRS
 * @author Consta
 * @author Dead3y3
 * @author Glavkos
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'ogg-desc' => 'Χειριστής για αρχεία Ogg Theora και Vorbis, με αναπαραγωγέα JavaScript',
	'ogg-short-audio' => 'Αρχείο ήχου Ogg $1, $2',
	'ogg-short-video' => 'Αρχείο βίντεο Ogg $1, $2',
	'ogg-short-general' => 'Αρχείο μέσων Ogg $1, $2',
	'ogg-long-audio' => '(Αρχείο ήχου Ogg $1, διάρκεια $2, $3)',
	'ogg-long-video' => 'Αρχείο βίντεο Ogg $1, διάρκεια $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(Αρχείο πολυπλεκτικού ήχου/βίντεο Ogg, $1, διάρκεια $2, $4×$5 pixels, $3 ολικά)',
	'ogg-long-general' => '(Αρχείο μέσων Ogg, διάρκεια $2, $3)',
	'ogg-long-error' => '(Άκυρο αρχείο ogg: $1)',
	'ogg-play' => 'Αναπαραγωγή',
	'ogg-pause' => 'Παύση',
	'ogg-stop' => 'Διακοπή',
	'ogg-play-video' => 'Αναπαραγωγή βίντεο',
	'ogg-play-sound' => 'Αναπαραγωγή ήχου',
	'ogg-no-player' => 'Συγγνώμη, το σύστημά σας δεν φαίνεται να έχει κάποιο υποστηριζόμενο λογισμικό αναπαραγωγής.<br />
Παρακαλώ <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">κατεβάστε ένα πρόγραμμα αναπαραγωγής</a>.',
	'ogg-no-xiphqt' => 'Δεν φαίνεται να έχετε το στοιχείο XiphQT για το πρόγραμμα QuickTime.<br />
Το πρόγραμμα QuickTime δεν μπορεί να αναπαράγει αρχεία Ogg χωρίς αυτό το στοιχείο.<br />
Παρακαλώ <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">κατεβάστε το XiphQT</a> ή επιλέξτε ένα άλλο πρόγραμμα αναπαραγωγής.',
	'ogg-player-videoElement' => 'Τοπική υποστήριξη φυλλομετρητή',
	'ogg-player-oggPlugin' => 'Πρόσθετο φυλλομετρητή',
	'ogg-player-thumbnail' => 'Ακίνητη εικόνα μόνο',
	'ogg-player-soundthumb' => 'Κανένας αναπαραγωγέας',
	'ogg-player-selected' => '(επιλέχθηκε)',
	'ogg-use-player' => 'Χρησιμοποίησε αναπαραγωγέα:',
	'ogg-more' => 'Περισσότερα...',
	'ogg-dismiss' => 'Κλείσιμο',
	'ogg-download' => 'Κατεβάστε το αρχείο',
	'ogg-desc-link' => 'Σχετικά με αυτό το αρχείο',
	'ogg-oggThumb-version' => 'Ο OggHandler απαιτεί την έκδοση oggThumb $1 ή μεταγενέστερη',
	'ogg-oggThumb-failed' => 'το oggThumb απέτυχε να δημιουργήσει τη μικρογραφία.',
);

/** Esperanto (Esperanto)
 * @author AVRS
 * @author Amikeco
 * @author ArnoLagrange
 * @author Yekrats
 */
$messages['eo'] = array(
	'ogg-desc' => 'Traktilo por dosieroj Ogg Theora kaj Vobis kun Ĵavaskripta legilo.',
	'ogg-short-audio' => 'Ogg $1 sondosiero, $2',
	'ogg-short-video' => 'Ogg $1 videodosiero, $2',
	'ogg-short-general' => 'Media ogg-dosiero $1, $2',
	'ogg-long-audio' => '(Aŭda ogg-dosiero $1, longeco $2, $3 entute)',
	'ogg-long-video' => 'Video ogg-dosiero $1, longeco $2, $4×$5 pikseloj, $3 entute',
	'ogg-long-multiplexed' => 'Kunigita aŭdio/video ogg-dosiero, $1, longeco $2, $4×$5 pikseloj, $3 entute',
	'ogg-long-general' => '(Ogg-mediodosiero, longeco $2, $3)',
	'ogg-long-error' => '(Malvalida ogg-dosiero: $1)',
	'ogg-play' => 'Legi',
	'ogg-pause' => 'Paŭzi',
	'ogg-stop' => 'Halti',
	'ogg-play-video' => 'Montri videon',
	'ogg-play-sound' => 'Aŭdigi sonon',
	'ogg-no-player' => 'Ŝajnas ke via sistemo malhavas ian medilegilan programon por legi tian dosieron. 
Bonvolu <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">elŝuti iun</a>.',
	'ogg-no-xiphqt' => 'Ŝajnas ke vi malhavas la XiphQT-komponaĵon por QuickTime. 
QuickTime ne kapablas aŭdigi sondosierojn sentiu komponaĵo. 
Bonvolu <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">elŝuti XiphQT</a> aux elektu alian legilon.',
	'ogg-player-videoElement' => 'Fundamenta subteno per retumilo',
	'ogg-player-oggPlugin' => 'Retumila kromprogramo',
	'ogg-player-thumbnail' => 'Nur senmova bildo',
	'ogg-player-soundthumb' => 'Neniu legilo',
	'ogg-player-selected' => '(elektita)',
	'ogg-use-player' => 'Uzi legilon:',
	'ogg-more' => 'Pli...',
	'ogg-dismiss' => 'Fermi',
	'ogg-download' => 'Alŝuti dosieron',
	'ogg-desc-link' => 'Pri ĉi tiu dosiero',
	'ogg-oggThumb-version' => 'OggHandler bezonas oggThumb version $1 aŭ postan.',
	'ogg-oggThumb-failed' => 'oggThumb malsukcis krei etan version.',
);

/** Spanish (Español)
 * @author AVRS
 * @author Aleator
 * @author Crazymadlover
 * @author Fitoschido
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 */
$messages['es'] = array(
	'ogg-desc' => 'Manejador de archivos de Ogg Thedora y Vorbis, con reproductor de JavaScript',
	'ogg-short-audio' => 'Archivo de sonido Ogg $1, $2',
	'ogg-short-video' => 'Archivo de video Ogg $1, $2',
	'ogg-short-general' => 'Archivo Ogg $1, $2',
	'ogg-long-audio' => '(Archivo de sonido Ogg $1, tamaño $2, $3)',
	'ogg-long-video' => 'Archivo de video Ogg $1, tamaño $2, $4×$5 píxeles, $3',
	'ogg-long-multiplexed' => '(Archivo Ogg de audio/video multiplexado, $1, tamaño $2, $4×$5 píxeles, $3 en todo)',
	'ogg-long-general' => '(Archivo Ogg. tamaño $2, $3)',
	'ogg-long-error' => '(Archivo ogg no válido: $1)',
	'ogg-play' => 'Reproducir',
	'ogg-pause' => 'Pausar',
	'ogg-stop' => 'Detener',
	'ogg-play-video' => 'Reproducir vídeo',
	'ogg-play-sound' => 'Reproducir sonido',
	'ogg-no-player' => 'Lo sentimos, su sistema parece no tener disponible un programa para reproducción de archivos multimedia.
Por favor <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descargue un reproductor</a>.',
	'ogg-no-xiphqt' => 'Parece que Ud. no tiene el componente XiphQT de QuickTime.
QuckTime no puede reproducir archivos en formato Ogg sin este componente.
Por favor <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descargue XiphQT</a> o elija otro reproductor de archivos multimedia.',
	'ogg-player-videoElement' => 'Apoyo nativo de navegador',
	'ogg-player-oggPlugin' => 'Complemento de navegador',
	'ogg-player-thumbnail' => 'Únicamente imagen',
	'ogg-player-soundthumb' => 'Ningún reproductor',
	'ogg-player-selected' => '(seleccionado)',
	'ogg-use-player' => 'Usar reproductor:',
	'ogg-more' => 'Opciones...',
	'ogg-dismiss' => 'Cerrar',
	'ogg-download' => 'Descargar archivo',
	'ogg-desc-link' => 'Sobre este archivo',
	'ogg-oggThumb-version' => 'OggHandler requiere una versión oggThumb $1 o posterior.',
	'ogg-oggThumb-failed' => 'oggThumb no pudo crear la imagen miniatura.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'ogg-desc' => 'Ogg Theora ja Vorbis failide töötleja JavaScript-esitajaga.',
	'ogg-long-error' => '(Vigane Ogg-fail: $1)',
	'ogg-play' => 'Esita',
	'ogg-pause' => 'Paus',
	'ogg-stop' => 'Peata',
	'ogg-play-video' => 'Esita video',
	'ogg-play-sound' => 'Esita heli',
	'ogg-no-player' => 'Kahjuks ei paista su süsteemis olevat ühtki ühilduvat esitustarkvara.
Palun <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">laadi tarkvara alla</a>.',
	'ogg-player-soundthumb' => 'Mängijat ei ole',
	'ogg-player-selected' => '(valitud)',
	'ogg-use-player' => 'Kasuta mängijat:',
	'ogg-more' => 'Lisa...',
	'ogg-dismiss' => 'Sule',
	'ogg-download' => 'Laadi fail alla',
	'ogg-desc-link' => 'Info faili kohta',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Joxemai
 * @author Theklan
 */
$messages['eu'] = array(
	'ogg-desc' => 'Ogg Theora eta Vorbis fitxategientzako edukiontzia, JavaScript playerrarekin',
	'ogg-short-audio' => 'Ogg $1 soinu fitxategia, $2',
	'ogg-short-video' => 'Ogg $1 bideo fitxategia, $2',
	'ogg-short-general' => 'Ogg $1 media fitxategia, $2',
	'ogg-long-audio' => '(Ogg $1 soinu fitxategia, $2 iraupea, $3)',
	'ogg-long-error' => '(ogg fitxategi okerra: $1)',
	'ogg-play' => 'Hasi',
	'ogg-pause' => 'Eten',
	'ogg-stop' => 'Gelditu',
	'ogg-play-video' => 'Bideoa hasi',
	'ogg-play-sound' => 'Soinua hasi',
	'ogg-player-soundthumb' => 'Erreproduktorerik ez',
	'ogg-player-selected' => '(aukeratua)',
	'ogg-use-player' => 'Erabili erreproduktore hau:',
	'ogg-more' => 'Gehiago...',
	'ogg-dismiss' => 'Itxi',
	'ogg-download' => 'Fitxategia jaitsi',
	'ogg-desc-link' => 'Fitxategi honen inguruan',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Sahim
 * @author Wayiran
 */
$messages['fa'] = array(
	'ogg-desc' => 'به دست گیرندهٔ پرونده‌های Ogg Theora و Vorbis، با پخش‌کنندهٔ مبتنی بر JavaScript',
	'ogg-short-audio' => 'پرونده صوتی Ogg $1، $2',
	'ogg-short-video' => 'پرونده تصویری Ogg $1، $2',
	'ogg-short-general' => 'پرونده Ogg $1، $2',
	'ogg-long-audio' => 'پروندهٔ صوتی آگ $1، مدت $2، $3',
	'ogg-long-video' => 'پروندهٔ تصویری آگ $1، مدت $2 ، $4×$5 پیکسل، $3',
	'ogg-long-multiplexed' => 'پروندهٔ صوتی/تصویری پیچیدهٔ آگ، $1، مدت $2، $4×$5 پیکسل، $3 در مجموع',
	'ogg-long-general' => 'پروندهٔ رسانه‌ای آگ، مدت $2، $3',
	'ogg-long-error' => 'پروندهٔ نامعتبر آگ: $1',
	'ogg-play' => 'پخش',
	'ogg-pause' => 'توقف',
	'ogg-stop' => 'بایست',
	'ogg-play-video' => 'پخش تصویر',
	'ogg-play-sound' => 'پخش صوت',
	'ogg-no-player' => 'متاسفانه دستگاه شما نرم‌افزار پخش‌کنندهٔ مناسب ندارد. لطفاً <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">یک برنامهٔ پخش‌کننده بارگیری کنید</a>.',
	'ogg-no-xiphqt' => 'به نظر نمی‌سرد که شما جزء XiphQT از برنامهٔ QuickTime را داشته باشید. برنامهٔ QuickTime بدون این جزء توان پخش پرونده‌های Ogg را ندارد. لطفاً <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT را بارگیری کنید</a> یا از یک پخش‌کنندهٔ دیگر استفاده کنید.',
	'ogg-player-videoElement' => 'پشتیبانی ذاتی مرورگر',
	'ogg-player-oggPlugin' => 'افزایهٔ مرورگر',
	'ogg-player-thumbnail' => 'فقط تصاویر ثابت',
	'ogg-player-soundthumb' => 'فاقد پخش‌کننده',
	'ogg-player-selected' => '(انتخاب شده)',
	'ogg-use-player' => 'این پخش‌کننده را به کارگیر:',
	'ogg-more' => 'بیشتر...',
	'ogg-dismiss' => 'بستن',
	'ogg-download' => 'بارگیری پرونده',
	'ogg-desc-link' => 'پیرامون این پرونده',
	'ogg-oggThumb-version' => 'OggHandler به oggThumb نسخهٔ $1 یا بعدتر از آن نیاز دارد.',
	'ogg-oggThumb-failed' => 'oggThumb موفق به ایجاد بندانگشتی نشد.',
);

/** Finnish (Suomi)
 * @author AVRS
 * @author Agony
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'ogg-desc' => 'Käsittelijä Ogg Theora ja Vorbis -tiedostoille ja JavaScript-soitin.',
	'ogg-short-audio' => 'Ogg $1 -äänitiedosto, $2',
	'ogg-short-video' => 'Ogg $1 -videotiedosto, $2',
	'ogg-short-general' => 'Ogg $1 -mediatiedosto, $2',
	'ogg-long-audio' => '(Ogg $1 -äänitiedosto, $2, $3)',
	'ogg-long-video' => 'Ogg $1 -videotiedosto, $2, $4×$5, $3',
	'ogg-long-multiplexed' => '(Ogg-tiedosto (limitetty kuva ja ääni), $1, $2, $4×$5, $3)',
	'ogg-long-general' => '(Ogg-tiedosto, $2, $3)',
	'ogg-long-error' => '(Kelvoton ogg-tiedosto: $1)',
	'ogg-play' => 'Soita',
	'ogg-pause' => 'Tauko',
	'ogg-stop' => 'Pysäytä',
	'ogg-play-video' => 'Toista video',
	'ogg-play-sound' => 'Soita ääni',
	'ogg-no-player' => 'Järjestelmästäsi ei löytynyt mitään tuetuista soitinohjelmista. Voit ladata sopivan <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">soitinohjelman</a>.',
	'ogg-no-xiphqt' => 'Tarvittavaa QuickTimen XiphQT-komponenttia ei löytynyt. QuickTime ei voi toistaa Ogg-tiedostoja ilman tätä komponenttia. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Lataa XiphQT</a> tai valitse toinen soitin.',
	'ogg-player-videoElement' => 'Luontainen selaintuki',
	'ogg-player-oggPlugin' => 'Selainlaajennos',
	'ogg-player-thumbnail' => 'Pysäytyskuva',
	'ogg-player-soundthumb' => 'Ei soitinta',
	'ogg-player-selected' => '(valittu)',
	'ogg-use-player' => 'Soitin:',
	'ogg-more' => 'Lisää…',
	'ogg-dismiss' => 'Sulje',
	'ogg-download' => 'Lataa',
	'ogg-desc-link' => 'Tiedoston tiedot',
	'ogg-oggThumb-version' => 'OggHandler vaatii oggThumbin version $1 tai uudemman.',
	'ogg-oggThumb-failed' => 'oggThumb ei onnistunut luomaan pienoiskuvaa.',
);

/** Faroese (Føroyskt)
 * @author EileenSanda
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'ogg-short-audio' => 'Ogg $1 ljóð fíla, $2',
	'ogg-short-video' => 'Ogg $1 video fíla, $2',
	'ogg-play' => 'Play',
	'ogg-pause' => 'Pausa',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Spæl video',
	'ogg-play-sound' => 'Spæl ljóð',
	'ogg-player-videoElement' => 'Innbygdur brovsara stuðul',
	'ogg-player-soundthumb' => 'Ongin avspælari',
	'ogg-use-player' => 'Brúka avspælara:',
	'ogg-more' => 'Meira...',
	'ogg-dismiss' => 'Lat aftur',
	'ogg-download' => 'Tak niður fílu',
	'ogg-desc-link' => 'Um hesa fílu',
);

/** French (Français)
 * @author AVRS
 * @author Crochet.david
 * @author DavidL
 * @author Grondin
 * @author Jean-Frédéric
 * @author Peter17
 * @author Seb35
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'ogg-desc' => 'Support pour les fichiers Ogg Theora et Vorbis, avec un lecteur Javascript',
	'ogg-short-audio' => 'Fichier son Ogg $1, $2',
	'ogg-short-video' => 'Fichier vidéo Ogg $1, $2',
	'ogg-short-general' => 'Fichier média Ogg $1, $2',
	'ogg-long-audio' => '(Fichier son Ogg $1, durée $2, $3)',
	'ogg-long-video' => 'Fichier vidéo Ogg $1, durée $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(Fichier multiplexé audio/vidéo Ogg, $1, durée $2, $4×$5 pixels, $3)',
	'ogg-long-general' => '(Fichier média Ogg, durée $2, $3)',
	'ogg-long-error' => '(Fichier Ogg invalide : $1)',
	'ogg-play' => 'Lecture',
	'ogg-pause' => 'Pause',
	'ogg-stop' => 'Arrêt',
	'ogg-play-video' => 'Lire la vidéo',
	'ogg-play-sound' => 'Lire le son',
	'ogg-no-player' => 'Désolé, votre système ne possède apparemment aucun des lecteurs supportés. Veuillez installer <a href="//www.mediawiki.org/wiki/Extension:OggHandler/Client_download/fr">un des lecteurs supportés</a>.',
	'ogg-no-xiphqt' => 'Vous n’avez apparemment pas le composant XiphQT pour Quicktime. Quicktime ne peut pas lire les fichiers Ogg sans ce composant. Veuillez <a href="//www.mediawiki.org/wiki/Extension:OggHandler/Client_download/fr">télécharger XiphQT</a> ou choisir un autre lecteur.',
	'ogg-player-videoElement' => 'Support du navigateur natif',
	'ogg-player-oggPlugin' => 'Module complémentaire du navigateur',
	'ogg-player-thumbnail' => 'Image statique seulement',
	'ogg-player-soundthumb' => 'Aucun lecteur',
	'ogg-player-selected' => '(sélectionné)',
	'ogg-use-player' => 'Utiliser le lecteur :',
	'ogg-more' => 'Plus…',
	'ogg-dismiss' => 'Fermer',
	'ogg-download' => 'Télécharger le fichier',
	'ogg-desc-link' => 'À propos de ce fichier',
	'ogg-oggThumb-version' => 'OggHandler nécessite oggThumb, version $1 ou supérieure.',
	'ogg-oggThumb-failed' => 'oggThumb n’a pas réussi à créer la miniature.',
);

/** Franco-Provençal (Arpetan)
 * @author AVRS
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'ogg-desc' => 'Assistance por los fichiérs Ogg Theora et Vorbis, avouéc un liésor JavaScript.',
	'ogg-short-audio' => 'fichiér son Ogg $1, $2',
	'ogg-short-video' => 'Fichiér vidèô Ogg $1, $2',
	'ogg-short-general' => 'Fichiér mèdia Ogg $1, $2',
	'ogg-long-audio' => '(Fichiér son Ogg $1, temps $2, $3)',
	'ogg-long-video' => 'fichiér vidèô Ogg $1, temps $2, $4×$5 pixèls, $3',
	'ogg-long-multiplexed' => '(fichiér multiplèxo ôdiô / vidèô Ogg, $1, temps $2, $4×$5 pixèls, en tot $3)',
	'ogg-long-general' => '(Fichiér mèdia Ogg, temps $2, $3)',
	'ogg-long-error' => '(Fichiér Ogg envalido : $1)',
	'ogg-play' => 'Liére',
	'ogg-pause' => 'Pousa',
	'ogg-stop' => 'Arrét',
	'ogg-play-video' => 'Liére la vidèô',
	'ogg-play-sound' => 'Liére lo son',
	'ogg-no-player' => 'Dèsolâ, aparament voutron sistèmo at gins de liésor recognu.
Volyéd enstalar <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/fr">yon des liésors recognus</a>.',
	'ogg-no-xiphqt' => 'Aparament vos avéd pas lo composent XiphQT por QuickTime.
QuickTime pôt pas liére los fichiérs Ogg sen cél composent.
Volyéd <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/fr">tèlèchargiér XiphQT</a> ou ben chouèsir un ôtro liésor.',
	'ogg-player-videoElement' => 'Assistance du navigator nativa',
	'ogg-player-oggPlugin' => 'Modulo d’èxtension du navigator',
	'ogg-player-thumbnail' => 'Solament l’émâge fixa',
	'ogg-player-soundthumb' => 'Gins de liésor',
	'ogg-player-selected' => '(chouèsi)',
	'ogg-use-player' => 'Utilisar lo liésor :',
	'ogg-more' => 'De ples...',
	'ogg-dismiss' => 'Cllôre',
	'ogg-download' => 'Tèlèchargiér lo fichiér',
	'ogg-desc-link' => 'A propôs de ceti fichiér',
	'ogg-oggThumb-version' => 'OggHandler at fôta d’oggThumb, vèrsion $1 ou ben ples novèla.',
	'ogg-oggThumb-failed' => 'oggThumb at pas reussi a fâre la figura.',
);

/** Friulian (Furlan)
 * @author AVRS
 * @author Klenje
 */
$messages['fur'] = array(
	'ogg-desc' => 'Gjestôr pai files Ogg Theora e Vorbis, cuntun riprodutôr JavaScript',
	'ogg-short-audio' => 'File audio Ogg $1, $2',
	'ogg-short-video' => 'File video Ogg $1, $2',
	'ogg-short-general' => 'File multimediâl Ogg $1, $2',
	'ogg-long-audio' => '(File audio Ogg $1, durade $2, $3)',
	'ogg-long-video' => 'File video Ogg $1, durade $2, dimensions $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(File audio/video multiplexed Ogg $1, lungjece $2, dimensions $4×$5 pixels, in dut $3)',
	'ogg-long-general' => '(File multimediâl Ogg, durade $2, $3)',
	'ogg-long-error' => '(File ogg no valit: $1)',
	'ogg-play' => 'Riprodûs',
	'ogg-pause' => 'Pause',
	'ogg-stop' => 'Ferme',
	'ogg-play-video' => 'Riprodûs il video',
	'ogg-play-sound' => 'Riprodûs il file audio',
	'ogg-no-player' => 'Nus displâs ma il to sisteme nol à riprodutôrs software supuartâts.
Par plasê <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">discjame un riprodutôr</a>.',
	'ogg-no-xiphqt' => 'Al samee che no tu vedis il component XiphQT par QuickTime.
QuickTime nol pues riprodusi i files Ogg cence di chest component.
Par plasê <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">discjame XiphQT</a> o sielç un altri letôr.',
	'ogg-player-videoElement' => 'Supuart sgarfadôr natîf',
	'ogg-player-oggPlugin' => 'Plugin sgarfadôr',
	'ogg-player-thumbnail' => 'Dome figure fisse',
	'ogg-player-soundthumb' => 'Nissun riprodutôr',
	'ogg-player-selected' => '(selezionât)',
	'ogg-use-player' => 'Dopre il riprodutôr:',
	'ogg-more' => 'Altri...',
	'ogg-dismiss' => 'Siere',
	'ogg-download' => 'Discjame il file',
	'ogg-desc-link' => 'Informazions su chest file',
	'ogg-oggThumb-version' => 'A OggHandler i covente oggThumb version $1 o sucessive.',
	'ogg-oggThumb-failed' => 'oggThumb nol è rivât a creâ la miniature.',
);

/** Irish (Gaeilge)
 * @author Spacebirdy
 */
$messages['ga'] = array(
	'ogg-dismiss' => 'Dún',
);

/** Galician (Galego)
 * @author AVRS
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'ogg-desc' => 'Manipulador dos ficheiros Ogg Theora e mais dos ficheiros Vorbis co reprodutor JavaScript',
	'ogg-short-audio' => 'Ficheiro de son Ogg $1, $2',
	'ogg-short-video' => 'Ficheiro de vídeo Ogg $1, $2',
	'ogg-short-general' => 'Ficheiro multimedia Ogg $1, $2',
	'ogg-long-audio' => '(ficheiro de son Ogg $1, duración $2, $3)',
	'ogg-long-video' => 'ficheiro de vídeo Ogg $1, duración $2, $4×$5 píxeles, $3',
	'ogg-long-multiplexed' => '(ficheiro de son/vídeo Ogg multiplex, $1, duración $2, $4×$5 píxeles, $3 total)',
	'ogg-long-general' => '(ficheiro multimedia Ogg, duración $2, $3)',
	'ogg-long-error' => '(ficheiro Ogg non válido: $1)',
	'ogg-play' => 'Reproducir',
	'ogg-pause' => 'Pausar',
	'ogg-stop' => 'Deter',
	'ogg-play-video' => 'Reproducir o vídeo',
	'ogg-play-sound' => 'Reproducir o son',
	'ogg-no-player' => 'Parece que o seu sistema non dispón do software de reprodución axeitado.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Instale un reprodutor</a>.',
	'ogg-no-xiphqt' => 'Parece que non dispón do compoñente XiphQT para QuickTime. QuickTime non pode reproducir ficheiros Ogg sen este componente. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Instale XiphQT</a> ou escolla outro reprodutor.',
	'ogg-player-videoElement' => 'Soporte do navegador nativo',
	'ogg-player-oggPlugin' => 'Complemento do navegador',
	'ogg-player-thumbnail' => 'Só instantánea',
	'ogg-player-soundthumb' => 'Ningún reprodutor',
	'ogg-player-selected' => '(seleccionado)',
	'ogg-use-player' => 'Usar o reprodutor:',
	'ogg-more' => 'Máis...',
	'ogg-dismiss' => 'Pechar',
	'ogg-download' => 'Descargar o ficheiro',
	'ogg-desc-link' => 'Acerca deste ficheiro',
	'ogg-oggThumb-version' => 'O OggHandler necesita a versión $1 ou unha posterior do oggThumb.',
	'ogg-oggThumb-failed' => 'Houbo un erro por parte do oggThumb ao crear a miniatura.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Flyax
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'ogg-long-error' => '(Ἄκυρα ἀρχεῖα ogg: $1)',
	'ogg-play' => 'Ἀναπαράγειν',
	'ogg-player-selected' => '(ἐπειλεγμένη)',
	'ogg-more' => 'πλέον...',
	'ogg-dismiss' => 'Κλῄειν',
);

/** Swiss German (Alemannisch)
 * @author AVRS
 * @author Als-Holder
 * @author Melancholie
 */
$messages['gsw'] = array(
	'ogg-desc' => 'Styyrigsprogramm fir Ogg Theora- un Vorbis-Dateie, mit ere JavaScript-Abspiilsoftware',
	'ogg-short-audio' => 'Ogg-$1-Audiodatei, $2',
	'ogg-short-video' => 'Ogg-$1-Videodatei, $2',
	'ogg-short-general' => 'Ogg-$1-Mediadatei, $2',
	'ogg-long-audio' => '(Ogg-$1-Audiodatei, Längi: $2, $3)',
	'ogg-long-video' => 'Ogg-$1-Videodatei, Längi: $2, $4×$5 Pixel, $3',
	'ogg-long-multiplexed' => '(Ogg-Audio-/Video-Datei, $1, Längi: $2, $4×$5 Pixel, $3)',
	'ogg-long-general' => '(Ogg-Mediadatei, Längi: $2, $3)',
	'ogg-long-error' => '(Uugiltigi Ogg-Datei: $1)',
	'ogg-play' => 'Start',
	'ogg-pause' => 'Paus',
	'ogg-stop' => 'Stopp',
	'ogg-play-video' => 'Video abspiile',
	'ogg-play-sound' => 'Audio abspiile',
	'ogg-no-player' => 'Dyy Syschtem het schyyns kei Abspiilsoftware. Bitte installier <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">e Abspiilsoftware</a>.',
	'ogg-no-xiphqt' => 'Dyy Syschtem het schyyns d XiphQT-Komponent fir QuickTime nit. QuickTime cha ohni die Komponent kei Ogg-Dateie abspiile. Bitte <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">lad XiphQT</a> oder wehl e anderi Abspiilsoftware.',
	'ogg-player-videoElement' => 'Vorhandeni Browserunterstitzig',
	'ogg-player-oggPlugin' => 'Browser-Plugin',
	'ogg-player-thumbnail' => 'Zeig Vorschaubild',
	'ogg-player-soundthumb' => 'Kei Player',
	'ogg-player-selected' => '(usgwehlt)',
	'ogg-use-player' => 'Abspiilsoftware:',
	'ogg-more' => 'Meh …',
	'ogg-dismiss' => 'Zuemache',
	'ogg-download' => 'Datei spychere',
	'ogg-desc-link' => 'Iber die Datei',
	'ogg-oggThumb-version' => 'OggHandler brucht oggThumb in dr Version $1 oder hecher.',
	'ogg-oggThumb-failed' => 'oggThumb het kei Miniaturbild chenne aalege.',
);

/** Gujarati (ગુજરાતી)
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'ogg-short-audio' => 'Ogg $1 ધ્વનિ ફાઈલ, $2',
	'ogg-short-video' => 'Ogg $1 વિડીઓ ફાઈલ, $2',
	'ogg-short-general' => 'Ogg $1 મિડીઆ ફાઈલ, $2',
	'ogg-long-audio' => 'Ogg $1 ધ્વનિ ફાઈલ, લંબાઈ $2, $3',
	'ogg-long-video' => 'Ogg $1 વિડીઓ ફાઈલ, લંબાઈ $2, $4×$5 પિક્સેલ્સ, $3',
	'ogg-long-general' => 'Ogg મિડીઆ ફાઈલ, લંબાઈ $2, $3',
	'ogg-long-error' => 'અજ્ઞાત ogg ફાઇલ : $1',
	'ogg-play' => 'ચાલુ કરો',
	'ogg-pause' => 'ઊભું રાખો',
	'ogg-stop' => 'બંધ કરો',
	'ogg-play-video' => 'વિડીઓ ચલાવો',
	'ogg-play-sound' => 'ધ્વનિ ચલાવો',
	'ogg-player-videoElement' => 'મૂળભૂત બ્રાઉઝર આધાર',
	'ogg-player-oggPlugin' => 'બ્રાઉઝર પ્લગઈન',
	'ogg-player-thumbnail' => 'માત્ર સ્થિત ચિત્ર જ',
	'ogg-player-soundthumb' => 'કોઈ પ્લેયર નહી',
	'ogg-player-selected' => '(પસંદ કરેલ)',
	'ogg-use-player' => 'પ્લેયર વાપરો:',
	'ogg-more' => 'વધુ...',
	'ogg-dismiss' => 'બંધ કરો',
	'ogg-download' => 'ફાઈલ ડાઉનલોડ કરો',
	'ogg-desc-link' => 'આ ફાઈલ વિષે',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'ogg-desc-link' => 'Mychione y choadan shoh',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotem Liss
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'ogg-desc' => 'מציג מדיה לקובצי Ogg Theora ו־Vorbis, עם נגן JavaScript',
	'ogg-short-audio' => 'קובץ שמע $1 של Ogg, $2',
	'ogg-short-video' => 'קובץ וידאו $1 של Ogg, $2',
	'ogg-short-general' => 'קובץ מדיה $1 של Ogg, $2',
	'ogg-long-audio' => '(קובץ שמע $1 של Ogg, באורך $2, $3)',
	'ogg-long-video' => 'קובץ וידאו $1 של Ogg, באורך $2, $4×$5 פיקסלים, $3',
	'ogg-long-multiplexed' => '(קובץ Ogg מרובב של שמע ווידאו, $1 באורך $2, $4×$5 פיקסלים, $3 בסך הכול)',
	'ogg-long-general' => '(קובץ מדיה של Ogg, באורך $2, $3)',
	'ogg-long-error' => '(קובץ ogg בלתי תקין: $1)',
	'ogg-play' => 'נגן',
	'ogg-pause' => 'הפסק',
	'ogg-stop' => 'עצור',
	'ogg-play-video' => 'נגן וידאו',
	'ogg-play-sound' => 'נגן שמע',
	'ogg-no-player' => 'מצטערים, נראה שהמערכת שלכם אינה כוללת תוכנת נגן נתמכת. אנא <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">הורידו נגן</a>.',
	'ogg-no-xiphqt' => 'נראה שלא התקנתם את רכיב XiphQT של QuickTime, אך QuickTime אינו יכול לנגן קובצי Ogg בלי רכיב זה. אנא <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">הורידו את XiphQT</a> או בחרו נגן אחר.',
	'ogg-player-videoElement' => 'תמיכה טבעית של הדפדפן',
	'ogg-player-oggPlugin' => 'תוסף לדפדפן',
	'ogg-player-thumbnail' => 'עדיין תמונה בלבד',
	'ogg-player-soundthumb' => 'אין נגן',
	'ogg-player-selected' => '(נבחר)',
	'ogg-use-player' => 'שימוש בנגן:',
	'ogg-more' => 'עוד…',
	'ogg-dismiss' => 'סגירה',
	'ogg-download' => 'הורדת הקובץ',
	'ogg-desc-link' => 'אודות הקובץ',
	'ogg-oggThumb-version' => 'OggHandler דורש את oggThumb בגרסה $1 ומעלה.',
	'ogg-oggThumb-failed' => 'oggThumb נכשל ביצירת התמונה הממוזערת.',
);

/** Hindi (हिन्दी)
 * @author AVRS
 * @author Ansumang
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'ogg-desc' => 'ऑग थियोरा और वॉर्बिस फ़ाईल्सके लिये चालक, जावास्क्रीप्ट प्लेयर के साथ',
	'ogg-short-audio' => 'ऑग $1 ध्वनी फ़ाईल, $2',
	'ogg-short-video' => 'ऑग $1 चलतचित्र फ़ाईल, $2',
	'ogg-short-general' => 'ऑग $1 मीडिया फ़ाईल, $2',
	'ogg-long-audio' => '(ऑग $1 ध्वनी फ़ाईल, लंबाई $2, $3)',
	'ogg-long-video' => 'ऑग $1 चलतचित्र फ़ाईल, लंबाई $2, $4×$5 पीक्सेल्स, $3',
	'ogg-long-multiplexed' => '(ऑग ध्वनी/चित्र फ़ाईल, $1, लंबाई $2, $4×$5 पिक्सेल्स, $3 कुल)',
	'ogg-long-general' => '(ऑग मीडिया फ़ाईल, लंबाई $2, $3)',
	'ogg-long-error' => '(गलत ऑग फ़ाईल: $1)',
	'ogg-play' => 'शुरू करें',
	'ogg-pause' => 'विराम',
	'ogg-stop' => 'रोकें',
	'ogg-play-video' => 'विडियो शुरू करें',
	'ogg-play-sound' => 'ध्वनी चलायें',
	'ogg-no-player' => 'क्षमा करें, आपके तंत्र में कोई प्रमाणिक चालक सॉफ्टवेयर दर्शित नहीं हो रहा है।
कृपया <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">एक चालक डाउनलोड करें</a>।',
	'ogg-no-xiphqt' => 'आपके पास QuickTime के लिए XiphQT घटक प्रतीत नहीं हो रहा है।
QuickTime बिना इस घटक के Ogg files चलने में असमर्थ है।
कृपया <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT डाउनलोड करें</a> अथवा अन्य चालक चुनें।',
	'ogg-player-videoElement' => 'मूल ब्राउज़र समर्थन',
	'ogg-player-oggPlugin' => 'ब्राउज़र प्लगइन',
	'ogg-player-thumbnail' => 'सिर्फ स्थिर चित्र',
	'ogg-player-soundthumb' => 'प्लेअर नहीं हैं',
	'ogg-player-selected' => '(चुने हुए)',
	'ogg-use-player' => 'यह प्लेअर इस्तेमाल करें:',
	'ogg-more' => 'और...',
	'ogg-dismiss' => 'बंद करें',
	'ogg-download' => 'फ़ाईल डाउनलोड करें',
	'ogg-desc-link' => 'इस फ़ाईलके बारे में',
);

/** Croatian (Hrvatski)
 * @author AVRS
 * @author CERminator
 * @author Dalibor Bosits
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'ogg-desc' => 'Poslužitelj za Ogg Theora i Vorbis datoteke, s JavaScript preglednikom',
	'ogg-short-audio' => 'Ogg $1 zvučna datoteka, $2',
	'ogg-short-video' => 'Ogg $1 video datoteka, $2',
	'ogg-short-general' => 'Ogg $1 medijska datoteka, $2',
	'ogg-long-audio' => '(Ogg $1 zvučna datoteka, duljine $2, $3)',
	'ogg-long-video' => 'Ogg $1 video datoteka, duljine $2, $4x$5 piksela, $3',
	'ogg-long-multiplexed' => '(Ogg multipleksirana zvučna/video datoteka, $1, duljine $2, $4×$5 piksela, $3 ukupno)',
	'ogg-long-general' => '(Ogg medijska datoteka, duljine $2, $3)',
	'ogg-long-error' => '(nevaljana ogg datoteka: $1)',
	'ogg-play' => 'Pokreni',
	'ogg-pause' => 'Pauziraj',
	'ogg-stop' => 'Zaustavi',
	'ogg-play-video' => 'Pokreni video',
	'ogg-play-sound' => 'Sviraj zvuk',
	'ogg-no-player' => "Oprostite, izgleda da Vaš operacijski sustav nema instalirane medijske preglednike. Molimo <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">instalirajte medijski preglednik (''player'')</a>.",
	'ogg-no-xiphqt' => "Nemate instaliranu XiphQT komponentu za QuickTime (ili je neispravno instalirana). QuickTime ne može pokretati Ogg datoteke bez ove komponente. Molimo <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">instalirajte XiphQT</a> ili izaberite drugi preglednik (''player'').",
	'ogg-player-videoElement' => 'Ugrađena podrška za preglednik',
	'ogg-player-oggPlugin' => 'Plugin preglednika',
	'ogg-player-vlc-activex' => 'VLC (ActiveX kontrola)',
	'ogg-player-thumbnail' => 'Samo (nepokretne) slike',
	'ogg-player-soundthumb' => 'Nema preglednika',
	'ogg-player-selected' => '(odabran)',
	'ogg-use-player' => "Rabi preglednik (''player''):",
	'ogg-more' => 'Više...',
	'ogg-dismiss' => 'Zatvori',
	'ogg-download' => 'Snimi datoteku',
	'ogg-desc-link' => 'O ovoj datoteci',
	'ogg-oggThumb-version' => 'OggHandler zahtijeva oggThumb inačicu $1 ili noviju.',
	'ogg-oggThumb-failed' => 'oggThumb nije uspio stvoriti sličicu.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author AVRS
 * @author Dundak
 * @author Michawiki
 */
$messages['hsb'] = array(
	'ogg-desc' => 'Wodźenski program za dataje Ogg Theora a Vorbis, z JavaScriptowym wothrawakom',
	'ogg-short-audio' => 'Awdiodataja Ogg $1, $2',
	'ogg-short-video' => 'Widejodataja Ogg $1, $2',
	'ogg-short-general' => 'Ogg medijowa dataja $1, $2',
	'ogg-long-audio' => '(Ogg-awdiodataja $1, dołhosć: $2, $3)',
	'ogg-long-video' => 'Ogg-widejodataja $1, dołhosć: $2, $4×$5 pikselow, $3',
	'ogg-long-multiplexed' => '(Ogg multipleksna awdio-/widejodataja, $1, dołhosć: $2, $4×$5 pikselow, $3)',
	'ogg-long-general' => '(Ogg medijowa dataja, dołhosć: $2, $3)',
	'ogg-long-error' => 'Njepłaćiwa ogg-dataja: $1',
	'ogg-play' => 'Wothrać',
	'ogg-pause' => 'Přestawka',
	'ogg-stop' => 'Stój',
	'ogg-play-video' => 'Widejo wothrać',
	'ogg-play-sound' => 'Zynk wothrać',
	'ogg-no-player' => 'Bohužel twój system po wšěm zdaću nima wothrawansku software. Prošu <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">sćehń wothrawak</a>.',
	'ogg-no-xiphqt' => 'Po wšěm zdaću nimaš komponentu XiphQT za QuickTime. QuickTime njemóže Ogg-dataje bjez tuteje komponenty wothrawać. Prošu <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">sćehń XiphQT</a> abo wubjer druhi wothrawak.',
	'ogg-player-videoElement' => 'Eksistowace podpěra wobhladowaka',
	'ogg-player-oggPlugin' => 'Tykač wobhladowaka',
	'ogg-player-thumbnail' => 'Hišće jenož wobraz',
	'ogg-player-soundthumb' => 'Žadyn wothrawak',
	'ogg-player-selected' => '(wubrany)',
	'ogg-use-player' => 'Wothrawak:',
	'ogg-more' => 'Wjace ...',
	'ogg-dismiss' => 'Začinić',
	'ogg-download' => 'Dataju sćahnyć',
	'ogg-desc-link' => 'Wo tutej dataji',
	'ogg-oggThumb-version' => 'OggHandler trjeba wersiju $1 oggThumb abo nowšu.',
	'ogg-oggThumb-failed' => 'oggThumb njemóžeše wobrazk wutworić.',
);

/** Haitian (Kreyòl ayisyen)
 * @author Masterches
 */
$messages['ht'] = array(
	'ogg-play' => 'Jwe',
	'ogg-pause' => 'Poz',
	'ogg-stop' => 'Stope',
);

/** Hungarian (Magyar)
 * @author AVRS
 * @author Dani
 * @author Glanthor Reviol
 * @author Tgr
 */
$messages['hu'] = array(
	'ogg-desc' => 'JavaScript nyelven írt lejátszó Ogg Theora és Vorbis fájlokhoz',
	'ogg-short-audio' => 'Ogg $1 hangfájl, $2',
	'ogg-short-video' => 'Ogg $1 videofájl, $2',
	'ogg-short-general' => 'Ogg $1 médiafájl, $2',
	'ogg-long-audio' => '(Ogg $1 hangfájl, hossza: $2, $3)',
	'ogg-long-video' => 'Ogg $1 videófájl, hossza $2, $4×$5 képpont, $3',
	'ogg-long-multiplexed' => '(Ogg egyesített audió- és videófájl, $1, hossz: $2, $4×$5 képpont, $3 összesen)',
	'ogg-long-general' => '(Ogg médiafájl, hossza: $2, $3)',
	'ogg-long-error' => '(Érvénytelen ogg fájl: $1)',
	'ogg-play' => 'Lejátszás',
	'ogg-pause' => 'Szüneteltetés',
	'ogg-stop' => 'Állj',
	'ogg-play-video' => 'Videó lejátszása',
	'ogg-play-sound' => 'Hang lejátszása',
	'ogg-no-player' => 'Sajnáljuk, de úgy tűnik, hogy nem rendelkezel a megfelelő lejátszóval. Amennyiben le szeretnéd játszani, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">tölts le egyet</a>.',
	'ogg-no-xiphqt' => 'Úgy tűnik, nem rendelkezel a QuickTime-hoz való XiphQT összetevővel. Enélkül a QuickTime nem tudja lejátszani az Ogg fájlokat. A lejátszáshoz tölts le egyet <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">innen</a>, vagy válassz másik lejátszót.',
	'ogg-player-videoElement' => 'A böngésző támogatja',
	'ogg-player-oggPlugin' => 'Beépülő modul böngészőhöz',
	'ogg-player-thumbnail' => 'Csak állókép',
	'ogg-player-soundthumb' => 'Nincs lejátszó',
	'ogg-player-selected' => '(kiválasztott)',
	'ogg-use-player' => 'Lejátszó:',
	'ogg-more' => 'Tovább...',
	'ogg-dismiss' => 'Bezárás',
	'ogg-download' => 'Fájl letöltése',
	'ogg-desc-link' => 'Fájlinformációk',
	'ogg-oggThumb-version' => 'Az OggHandlerhez $1 vagy későbbi verziójú oggThumb szükséges.',
	'ogg-oggThumb-failed' => 'Az oggThumb nem tudta elkészíteni a bélyegképet.',
);

/** Interlingua (Interlingua)
 * @author AVRS
 * @author McDutchie
 */
$messages['ia'] = array(
	'ogg-desc' => 'Gestor pro le files Ogg Theora e Vorbis, con reproductor JavaScript',
	'ogg-short-audio' => 'File audio Ogg $1, $2',
	'ogg-short-video' => 'File video Ogg $1, $2',
	'ogg-short-general' => 'File media Ogg $1, $2',
	'ogg-long-audio' => '(File audio Ogg $1, duration $2, $3)',
	'ogg-long-video' => 'File video Ogg $1, duration $2, $4×$5 pixel, $3',
	'ogg-long-multiplexed' => '(File multiplexate audio/video Ogg, $1, duration $2, $4×$5 pixel, $3 in total)',
	'ogg-long-general' => '(File media Ogg, duration $2, $3)',
	'ogg-long-error' => '(File Ogg invalide: $1)',
	'ogg-play' => 'Jocar',
	'ogg-pause' => 'Pausar',
	'ogg-stop' => 'Stoppar',
	'ogg-play-video' => 'Jocar video',
	'ogg-play-sound' => 'Sonar audio',
	'ogg-no-player' => 'Excusa, ma il pare que non es installate alcun lector compatibile in tu systema.
Per favor <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">discarga un lector.</a>',
	'ogg-no-xiphqt' => 'Pare que tu non ha le componente XiphQT pro QuickTime.
Sin iste componente, QuickTime non sape leger le files Ogg.
Per favor <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">discarga XiphQT</a> o selige un altere lector.',
	'ogg-player-videoElement' => 'Supporto native in navigator',
	'ogg-player-oggPlugin' => 'Plugin pro navigator',
	'ogg-player-thumbnail' => 'Imagine static solmente',
	'ogg-player-soundthumb' => 'Necun lector',
	'ogg-player-selected' => '(seligite)',
	'ogg-use-player' => 'Usar lector:',
	'ogg-more' => 'Plus…',
	'ogg-dismiss' => 'Clauder',
	'ogg-download' => 'Discargar file',
	'ogg-desc-link' => 'A proposito de iste file',
	'ogg-oggThumb-version' => 'OggHandler require oggThumb version $1 o plus recente.',
	'ogg-oggThumb-failed' => 'oggThumb ha fallite de crear le miniatura.',
);

/** Indonesian (Bahasa Indonesia)
 * @author AVRS
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'ogg-desc' => 'Menangani berkas Ogg Theora dan Vorbis dengan pemutar JavaScript',
	'ogg-short-audio' => 'Berkas suara $1 ogg, $2',
	'ogg-short-video' => 'Berkas video $1 ogg, $2',
	'ogg-short-general' => 'Berkas media $1 ogg, $2',
	'ogg-long-audio' => '(Berkas suara $1 ogg, panjang $2, $3)',
	'ogg-long-video' => 'Berkas video $1 ogg, panjang $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Berkas audio/video multiplexed ogg, $1, panjang $2, $4×$5 piksel, $3 keseluruhan)',
	'ogg-long-general' => '(Berkas media ogg, panjang $2, $3)',
	'ogg-long-error' => '(Berkas ogg tak valid: $1)',
	'ogg-play' => 'Mainkan',
	'ogg-pause' => 'Jeda',
	'ogg-stop' => 'Berhenti',
	'ogg-play-video' => 'Putar video',
	'ogg-play-sound' => 'Putar suara',
	'ogg-no-player' => 'Maaf, sistem Anda tampaknya tak memiliki satupun perangkat lunak pemutar yang mendukung.
Silakan <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">mengunduh salah satu pemutar</a>.',
	'ogg-no-xiphqt' => 'Tampaknya Anda tak memiliki komponen XiphQT untuk QuickTime. QuickTime tak dapat memutar berkas Ogg tanpa komponen ini. Silakan <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">mengunduh XiphQT</a> atau pilih pemutar lain.',
	'ogg-player-videoElement' => 'elemen <video>',
	'ogg-player-oggPlugin' => 'plugin Ogg',
	'ogg-player-thumbnail' => 'Hanya gambar statis',
	'ogg-player-soundthumb' => 'Tak ada pemutar',
	'ogg-player-selected' => '(terpilih)',
	'ogg-use-player' => 'Gunakan pemutar:',
	'ogg-more' => 'Lainnya...',
	'ogg-dismiss' => 'Tutup',
	'ogg-download' => 'Unduh berkas',
	'ogg-desc-link' => 'Mengenai berkas ini',
	'ogg-oggThumb-version' => 'OggHandler membutuhkan oggThumb versi $1 atau terbaru.',
	'ogg-oggThumb-failed' => 'oggThumb gagal membuat miniatur gambar.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'ogg-play' => 'Dọ',
	'ogg-pause' => "Zùy'íké",
	'ogg-stop' => 'Kwùshí',
	'ogg-more' => 'Ozókwá...',
	'ogg-dismiss' => 'Mèchié',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'ogg-desc' => 'Agtengngel para dagiti Ogg Theora ken Vorbis a papeles, nga addaan ti JavaScript a pagay-ayam.',
	'ogg-short-audio' => 'Ogg $1 mangeg a papeles, $2',
	'ogg-short-video' => 'Ogg $1 mabuya a papeles, $2',
	'ogg-short-general' => 'Ogg $1 media a papeles, $2',
	'ogg-long-audio' => 'Ogg $1 mangeg a papeles, kaatiddog $2, $3',
	'ogg-long-video' => 'Ogg $1 mabuya a papeles, lkaatiddog $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => 'Ogg multiplexed a mangeg/mabuya a  papeles, $1, kaatiddog $2, $4×$5 pixels, $3 amin-amin',
	'ogg-long-general' => 'Ogg media a papeles, kaatiddog $2, $3',
	'ogg-long-error' => 'Imbalido nga ogg a papeles: $1',
	'ogg-play' => 'Ayayamen',
	'ogg-pause' => 'Pasardengan',
	'ogg-stop' => 'Isardeng',
	'ogg-play-video' => 'Ay-ayamen ti mabuya',
	'ogg-play-sound' => 'Ay-ayamen ti mangeg',
	'ogg-no-player' => 'Pasensian a, ti sistemam ket kasla awan ti natapayaan na nga agpa-ayayam a software.
Pangngaasi a <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">mangipan ti agpa-ayayam</a>.',
	'ogg-no-xiphqt' => 'Kasla awanen ka ti XiphQT  a banag para iti QuickTime
Ti QuickTime ket saan nga agy-ayam iti Ogg a papeles nga awanen daytoy a banag.
Pangngaasi a <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">mangipan ti XiphQT</a> wenno agpili iti sabali a pagay-ayam.',
	'ogg-player-videoElement' => 'Patneng a pagbasabasa tapayaen',
	'ogg-player-oggPlugin' => 'Pagbasabasa a pasullat',
	'ogg-player-thumbnail' => 'Saan a nakuti nga imahen laeng',
	'ogg-player-soundthumb' => 'Awan ti pagay-ayam',
	'ogg-player-selected' => '(napili)',
	'ogg-use-player' => 'Usaren ti pagay-ayam:',
	'ogg-more' => 'Adu pay...',
	'ogg-dismiss' => 'Irikep',
	'ogg-download' => 'Mangipan ti papeles',
	'ogg-desc-link' => 'Maipanggep daytoy nga imahen',
	'ogg-oggThumb-version' => 'Ti OggHandler ket masapul na ti oggThumb a bersion $1 wenno ti naududi.',
	'ogg-oggThumb-failed' => 'Napaay ti oggThumb nga agaramid ti imahen.',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'ogg-long-error' => '(Ne-valida ogg-arkivo: $1)',
	'ogg-player-selected' => '(selektita)',
	'ogg-more' => 'Plus…',
	'ogg-dismiss' => 'Klozar',
	'ogg-desc-link' => 'Pri ca arkivo',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Spacebirdy
 */
$messages['is'] = array(
	'ogg-play' => 'Spila',
	'ogg-pause' => 'gera hlé',
	'ogg-stop' => 'Stöðva',
	'ogg-play-video' => 'Spila myndband',
	'ogg-play-sound' => 'Spila hljóð',
	'ogg-player-soundthumb' => 'Enginn spilari',
	'ogg-player-selected' => '(valið)',
	'ogg-use-player' => 'Nota spilara:',
	'ogg-more' => 'Meira...',
	'ogg-dismiss' => 'Loka',
	'ogg-download' => 'Sækja skrá',
);

/** Italian (Italiano)
 * @author .anaconda
 * @author AVRS
 * @author BrokenArrow
 * @author Darth Kule
 * @author HalphaZ
 */
$messages['it'] = array(
	'ogg-desc' => 'Gestore per i file Ogg Theora e Vorbis, con programma di riproduzione in JavaScript',
	'ogg-short-audio' => 'File audio Ogg $1, $2',
	'ogg-short-video' => 'File video Ogg $1, $2',
	'ogg-short-general' => 'File multimediale Ogg $1, $2',
	'ogg-long-audio' => '(File audio Ogg $1, durata $2, $3)',
	'ogg-long-video' => 'File video Ogg $1, durata $2, dimensioni $4×$5 pixel, $3',
	'ogg-long-multiplexed' => '(File audio/video multiplexed Ogg $1, durata $2, dimensioni $4×$5 pixel, complessivamente $3)',
	'ogg-long-general' => '(File multimediale Ogg, durata $2, $3)',
	'ogg-long-error' => '(File ogg non valido: $1)',
	'ogg-play' => 'Riproduci',
	'ogg-pause' => 'Pausa',
	'ogg-stop' => 'Ferma',
	'ogg-play-video' => 'Riproduci il filmato',
	'ogg-play-sound' => 'Riproduci il file sonoro',
	'ogg-no-player' => 'Siamo spiacenti, ma non risulta installato alcun software di riproduzione compatibile. Si prega di <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">scaricare un lettore</a> adatto.',
	'ogg-no-xiphqt' => 'Non risulta installato il componente XiphQT di QuickTime. Senza tale componente non è possibile la riproduzione di file Ogg con QuickTime. Si prega di <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">scaricare XiphQT</a> o scegliere un altro lettore.',
	'ogg-player-videoElement' => 'Supporto browser nativo',
	'ogg-player-oggPlugin' => 'Plugin browser',
	'ogg-player-thumbnail' => 'Solo immagini fisse',
	'ogg-player-soundthumb' => 'Nessun lettore',
	'ogg-player-selected' => '(selezionato)',
	'ogg-use-player' => 'Usa il lettore:',
	'ogg-more' => 'Altro...',
	'ogg-dismiss' => 'Chiudi',
	'ogg-download' => 'Scarica il file',
	'ogg-desc-link' => 'Informazioni su questo file',
	'ogg-oggThumb-version' => 'OggHandler richiede la versione $1 o superiore di oggThumb.',
	'ogg-oggThumb-failed' => 'oggThumb non è riuscito a creare la miniatura.',
);

/** Japanese (日本語)
 * @author AVRS
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Kahusi
 */
$messages['ja'] = array(
	'ogg-desc' => 'Theora および Vorbis 形式の Ogg ファイルハンドラーと JavaScript プレイヤー',
	'ogg-short-audio' => 'Ogg $1 音声ファイル、$2',
	'ogg-short-video' => 'Ogg $1 動画ファイル、$2',
	'ogg-short-general' => 'Ogg $1 メディアファイル、$2',
	'ogg-long-audio' => '(Ogg $1 音声ファイル、長さ $2、$3)',
	'ogg-long-video' => 'Ogg $1 動画ファイル、長さ $2、$4×$5px、$3',
	'ogg-long-multiplexed' => '(Ogg 多重音声/動画ファイル、$1、長さ $2、$4×$5 ピクセル、$3)',
	'ogg-long-general' => '(Ogg メディアファイル、長さ $2、$3)',
	'ogg-long-error' => '(無効な Ogg ファイル: $1)',
	'ogg-play' => '再生',
	'ogg-pause' => '一時停止',
	'ogg-stop' => '停止',
	'ogg-play-video' => '動画を再生',
	'ogg-play-sound' => '音声を再生',
	'ogg-no-player' => '申し訳ありません、あなたのシステムには対応する再生ソフトウェアがインストールされていないようです。<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ここからダウンロードしてください</a>。',
	'ogg-no-xiphqt' => 'QuickTime 用 XiphQT コンポーネントがインストールされていないようです。QuickTime で Ogg ファイルを再生するには、このコンポーネントが必要です。<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ここから XiphQT をダウンロードする</a>か、別の再生ソフトをインストールしてください。',
	'ogg-player-videoElement' => 'ネイティヴ・ブラウザをサポート',
	'ogg-player-oggPlugin' => 'ブラウザ・プラグイン',
	'ogg-player-thumbnail' => '静止画像のみ',
	'ogg-player-soundthumb' => 'プレーヤー無し',
	'ogg-player-selected' => '(選択)',
	'ogg-use-player' => '利用するプレーヤー:',
	'ogg-more' => 'その他……',
	'ogg-dismiss' => '閉じる',
	'ogg-download' => 'ファイルをダウンロード',
	'ogg-desc-link' => 'ファイルの詳細',
	'ogg-oggThumb-version' => 'OggHandler は oggThumb バージョン$1またはそれ以降が必要です。',
	'ogg-oggThumb-failed' => 'oggThumb によるサムネイル作成に失敗しました。',
);

/** Jutish (Jysk)
 * @author AVRS
 * @author Huslåke
 */
$messages['jut'] = array(
	'ogg-desc' => 'Håndlær før Ogg Theora og Vorbis filer, ve JavaScript spæler',
	'ogg-short-audio' => 'Ogg $1 sond file, $2',
	'ogg-short-video' => 'Ogg $1 video file, $2',
	'ogg-short-general' => 'Ogg $1 media file, $2',
	'ogg-long-audio' => '(Ogg $1 sond file, duråsje $2, $3)',
	'ogg-long-video' => 'Ogg $1 video file, duråsje $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Ogg multipleksen audio/video file, $1, duråsje $2, $4×$5 piksler, $3 åverål)',
	'ogg-long-general' => '(Ogg $1 media file, duråsje $2, $3)',
	'ogg-long-error' => '(Ugyldegt ogg file: $2)',
	'ogg-play' => 'Spæl',
	'ogg-pause' => 'Pås',
	'ogg-stop' => 'Ståp',
	'ogg-play-video' => 'Spæl video',
	'ogg-play-sound' => 'Spæl sond',
	'ogg-no-player' => 'Unskyld, deres sistæm dä ekke appiære til har søm understønenge spæler softwær. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Nærlæĝ en spæler</a>.',
	'ogg-no-xiphqt' => 'Du däst ekke appiær til har æ XiphQT kompånent før QuickTime. QuickTime ken ekke spæl Ogg filer veud dette kompånent. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Nærlæĝ XiphQT</a> æller vælg\'en andes spæler.',
	'ogg-player-videoElement' => '<video> ælement',
	'ogg-player-oggPlugin' => 'Ogg plugin',
	'ogg-player-thumbnail' => 'Stil billet ålen',
	'ogg-player-soundthumb' => 'Ekke spæler',
	'ogg-player-selected' => '(sælektærn)',
	'ogg-use-player' => 'Brug spæler:',
	'ogg-more' => 'Mære...',
	'ogg-dismiss' => 'Slut',
	'ogg-download' => 'Nærlæĝ billet',
	'ogg-desc-link' => 'Åver dette file',
);

/** Javanese (Basa Jawa)
 * @author AVRS
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'ogg-desc' => 'Sing ngurusi berkas Ogg Theora lan Vorbis mawa pamain JavaScript',
	'ogg-short-audio' => 'Berkas swara $1 ogg, $2',
	'ogg-short-video' => 'Berkas vidéo $1 ogg, $2',
	'ogg-short-general' => 'Berkas média $1 ogg, $2',
	'ogg-long-audio' => '(Berkas swara $1 ogg, dawané $2, $3)',
	'ogg-long-video' => 'Berkas vidéo $1 ogg, dawané $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Berkas audio/vidéo multiplexed ogg, $1, dawané $2, $4×$5 piksel, $3 gunggungé)',
	'ogg-long-general' => '(Berkas média ogg, dawané $2, $3)',
	'ogg-long-error' => '(Berkas ogg ora absah: $1)',
	'ogg-play' => 'Main',
	'ogg-pause' => 'Lèrèn',
	'ogg-stop' => 'Mandeg',
	'ogg-play-video' => 'Main vidéo',
	'ogg-play-sound' => 'Main swara',
	'ogg-no-player' => 'Nuwun sèwu, sistém panjenengan katoné ora ndarbèni siji-sijia piranti empuk sing didukung. 
Mangga <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ngundhuh salah siji piranti pamain</a>.',
	'ogg-no-xiphqt' => 'Katoné panjenengan ora ana komponèn XiphQT kanggo QuickTime.
QuickTime ora bisa mainaké berkas-berkas Ogg tanpa komponèn iki.
Please <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ngundhuh XiphQT</a> utawa milih piranti pamain liya.',
	'ogg-player-videoElement' => 'Dhukungan browser asli',
	'ogg-player-oggPlugin' => "''Plugin browser''",
	'ogg-player-thumbnail' => 'Namung gambar statis waé',
	'ogg-player-soundthumb' => 'Ora ana piranti pamain',
	'ogg-player-selected' => '(dipilih)',
	'ogg-use-player' => 'Nganggo piranti pamain:',
	'ogg-more' => 'Luwih akèh...',
	'ogg-dismiss' => 'Tutup',
	'ogg-download' => 'Undhuh berkas',
	'ogg-desc-link' => 'Prekara berkas iki',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 * @author Dawid Deutschland
 * @author ITshnik
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'ogg-short-audio' => 'Ogg $1 აუდიო ფაილი, $2',
	'ogg-short-video' => 'Ogg $1 ვიდეო ფაილი, $2',
	'ogg-short-general' => 'Ogg $1 მედია ფაილი, $2',
	'ogg-long-audio' => 'Ogg $1 აუდიო ფაილი, სიგრძე $2, $3',
	'ogg-long-video' => 'Ogg $1 ვიდეო ფაილი, სიგრძე $2, $4×$5 პიქსელი, $3',
	'ogg-long-multiplexed' => 'Ogg აუდიო/ვიდეო ფაილი, $1, სიგრძე: $2, $4×$5 პიქსელი, $3',
	'ogg-long-general' => 'Ogg მედია ფაილი, სიგრძე $2, $3',
	'ogg-long-error' => 'არასწორი ogg-ფაილი: $1',
	'ogg-play' => 'თამაში',
	'ogg-pause' => 'პაუზა',
	'ogg-stop' => 'შეჩერება',
	'ogg-play-video' => 'ვიდეოს ჩართვა',
	'ogg-play-sound' => 'ხმის მოსმენა',
	'ogg-player-videoElement' => 'მშობლიური ბრაუზერის მხარდაჭერა',
	'ogg-player-oggPlugin' => 'ბრაუზერის მოდული',
	'ogg-player-thumbnail' => 'მხოლოდ წინასწარი სურათი',
	'ogg-player-soundthumb' => 'No player',
	'ogg-player-selected' => '(არჩეულია)',
	'ogg-use-player' => 'დამკვრელის გამოყენება:',
	'ogg-more' => 'მეტი...',
	'ogg-dismiss' => 'დახურვა',
	'ogg-download' => 'ფაილის ჩამოტვირთვა',
	'ogg-desc-link' => 'ამ ფაილის შესახებ',
	'ogg-oggThumb-version' => 'OggHandler-ს სჭირდება oggThumb ვერსია $1 ან უფრო გვიანდელი.',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬)
 * @author AVRS
 */
$messages['kk-arab'] = array(
	'ogg-short-audio' => 'Ogg $1 دىبىس فايلى, $2',
	'ogg-short-video' => 'Ogg $1 بەينە فايلى, $2',
	'ogg-short-general' => 'Ogg $1 تاسپا فايلى, $2',
	'ogg-long-audio' => '(Ogg $1 دىبىس فايلى, ۇزاقتىعى $2, $3)',
	'ogg-long-video' => 'Ogg $1 بەينە فايلى, ۇزاقتىعى $2, $4 × $5 پىيكسەل, $3',
	'ogg-long-multiplexed' => '(Ogg قۇرامدى دىبىس/بەينە فايلى, $1, ۇزاقتىعى $2, $4 × $5 پىيكسەل, $3 نە بارلىعى)',
	'ogg-long-general' => '(Ogg تاسپا فايلى, ۇزاقتىعى $2, $3)',
	'ogg-long-error' => '(جارامسىز ogg فايلى: $1)',
	'ogg-play' => 'ويناتۋ',
	'ogg-pause' => 'ايالداتۋ',
	'ogg-stop' => 'توقتاتۋ',
	'ogg-play-video' => 'بەينەنى ويناتۋ',
	'ogg-play-sound' => 'دىبىستى ويناتۋ',
	'ogg-no-player' => 'عافۋ ەتىڭىز, جۇيەڭىزدە ەش سۇيەمەلدەگەن ويناتۋ باعدارلامالىق قامتاماسىزداندىرعىش ورناتىلماعان. <a href="http://www.java.com/en/download/manual.jsp">Java</a> بۋماسىن ورناتىپ شىعىڭىز.',
	'ogg-no-xiphqt' => 'QuickTime ويناتقىشىڭىزدىڭ XiphQT دەگەن قۇراشى جوق سىيياقتى. بۇل قۇراشىسىز Ogg فايلدارىن QuickTime ويناتا المايدى. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT قۇراشىن</a> نە باسقا ويناتقىشتى جۇكتەڭىز.',
	'ogg-player-videoElement' => '<video> داناسى',
	'ogg-player-oggPlugin' => 'Ogg قوسىمشا باعدارلاماسى',
	'ogg-player-thumbnail' => 'تەك ستوپ-كادر',
	'ogg-player-soundthumb' => 'ويناتقىشسىز',
	'ogg-player-selected' => '(بولەكتەلگەن)',
	'ogg-use-player' => 'ويناتقىش پايدالانۋى:',
	'ogg-more' => 'كوبىرەك...',
	'ogg-dismiss' => 'جابۋ',
	'ogg-download' => 'فايلدى جۇكتەۋ',
	'ogg-desc-link' => 'بۇل فايل تۋرالى',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬)
 * @author AVRS
 */
$messages['kk-cyrl'] = array(
	'ogg-short-audio' => 'Ogg $1 дыбыс файлы, $2',
	'ogg-short-video' => 'Ogg $1 бейне файлы, $2',
	'ogg-short-general' => 'Ogg $1 таспа файлы, $2',
	'ogg-long-audio' => '(Ogg $1 дыбыс файлы, ұзақтығы $2, $3)',
	'ogg-long-video' => 'Ogg $1 бейне файлы, ұзақтығы $2, $4 × $5 пиксел, $3',
	'ogg-long-multiplexed' => '(Ogg құрамды дыбыс/бейне файлы, $1, ұзақтығы $2, $4 × $5 пиксел, $3 не барлығы)',
	'ogg-long-general' => '(Ogg таспа файлы, ұзақтығы $2, $3)',
	'ogg-long-error' => '(Жарамсыз ogg файлы: $1)',
	'ogg-play' => 'Ойнату',
	'ogg-pause' => 'Аялдату',
	'ogg-stop' => 'Тоқтату',
	'ogg-play-video' => 'Бейнені ойнату',
	'ogg-play-sound' => 'Дыбысты ойнату',
	'ogg-no-player' => 'Ғафу етіңіз, жүйеңізде еш сүйемелдеген ойнату бағдарламалық қамтамасыздандырғыш орнатылмаған. <a href="http://www.java.com/en/download/manual.jsp">Java</a> бумасын орнатып шығыңыз.',
	'ogg-no-xiphqt' => 'QuickTime ойнатқышыңыздың XiphQT деген құрашы жоқ сияқты. Бұл құрашысыз Ogg файлдарын QuickTime ойната алмайды. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT құрашын</a> не басқа ойнатқышты жүктеңіз.',
	'ogg-player-videoElement' => '<video> данасы',
	'ogg-player-oggPlugin' => 'Ogg қосымша бағдарламасы',
	'ogg-player-thumbnail' => 'Тек стоп-кадр',
	'ogg-player-soundthumb' => 'Ойнатқышсыз',
	'ogg-player-selected' => '(бөлектелген)',
	'ogg-use-player' => 'Ойнатқыш пайдалануы:',
	'ogg-more' => 'Көбірек...',
	'ogg-dismiss' => 'Жабу',
	'ogg-download' => 'Файлды жүктеу',
	'ogg-desc-link' => 'Бұл файл туралы',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬)
 * @author AVRS
 */
$messages['kk-latn'] = array(
	'ogg-short-audio' => 'Ogg $1 dıbıs faýlı, $2',
	'ogg-short-video' => 'Ogg $1 beýne faýlı, $2',
	'ogg-short-general' => 'Ogg $1 taspa faýlı, $2',
	'ogg-long-audio' => '(Ogg $1 dıbıs faýlı, uzaqtığı $2, $3)',
	'ogg-long-video' => 'Ogg $1 beýne faýlı, uzaqtığı $2, $4 × $5 pïksel, $3',
	'ogg-long-multiplexed' => '(Ogg quramdı dıbıs/beýne faýlı, $1, uzaqtığı $2, $4 × $5 pïksel, $3 ne barlığı)',
	'ogg-long-general' => '(Ogg taspa faýlı, uzaqtığı $2, $3)',
	'ogg-long-error' => '(Jaramsız ogg faýlı: $1)',
	'ogg-play' => 'Oýnatw',
	'ogg-pause' => 'Ayaldatw',
	'ogg-stop' => 'Toqtatw',
	'ogg-play-video' => 'Beýneni oýnatw',
	'ogg-play-sound' => 'Dıbıstı oýnatw',
	'ogg-no-player' => 'Ğafw etiñiz, jüýeñizde eş süýemeldegen oýnatw bağdarlamalıq qamtamasızdandırğış ornatılmağan. <a href="http://www.java.com/en/download/manual.jsp">Java</a> bwmasın ornatıp şığıñız.',
	'ogg-no-xiphqt' => 'QuickTime oýnatqışıñızdıñ XiphQT degen quraşı joq sïyaqtı. Bul quraşısız Ogg faýldarın QuickTime oýnata almaýdı. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT quraşın</a> ne basqa oýnatqıştı jükteñiz.',
	'ogg-player-videoElement' => '<video> danası',
	'ogg-player-oggPlugin' => 'Ogg qosımşa bağdarlaması',
	'ogg-player-thumbnail' => 'Tek stop-kadr',
	'ogg-player-soundthumb' => 'Oýnatqışsız',
	'ogg-player-selected' => '(bölektelgen)',
	'ogg-use-player' => 'Oýnatqış paýdalanwı:',
	'ogg-more' => 'Köbirek...',
	'ogg-dismiss' => 'Jabw',
	'ogg-download' => 'Faýldı jüktew',
	'ogg-desc-link' => 'Bul faýl twralı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author AVRS
 * @author Chhorran
 * @author Lovekhmer
 * @author T-Rithy
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'ogg-desc' => 'គាំទ្រចំពោះ Ogg Theora និង Vorbis files, ជាមួយ ឧបករណ៍អាន JavaScript',
	'ogg-short-audio' => 'ឯកសារ សំឡេង Ogg $1, $2',
	'ogg-short-video' => 'ឯកសារវីដេអូ Ogg $1, $2',
	'ogg-short-general' => 'ឯកសារមេឌាOgg $1, $2',
	'ogg-long-audio' => '(ឯកសារសំឡេងប្រភេទOgg $1, រយៈពេល$2 និងទំហំ$3)',
	'ogg-long-video' => 'ឯកសារវីដេអូប្រភេទOgg $1, រយៈពេល$2, $4×$5px, $3',
	'ogg-long-multiplexed' => '(ឯកសារអូឌីយ៉ូ/វីដេអូចម្រុះប្រភេទOgg , $1, រយៈពេល$2, $4×$5px, ប្រហែល$3)',
	'ogg-long-general' => '(ឯកសារមេឌាប្រភេទOgg, រយៈពេល$2, $3)',
	'ogg-long-error' => '(ឯកសារ ogg មិនមាន សុពលភាព ៖ $1)',
	'ogg-play' => 'លេង',
	'ogg-pause' => 'ផ្អាក',
	'ogg-stop' => 'ឈប់',
	'ogg-play-video' => 'លេងវីដេអូ',
	'ogg-play-sound' => 'បន្លឺសំឡេង',
	'ogg-no-player' => 'សូមអភ័យទោស! ប្រព័ន្ធដំណើរការរបស់អ្នក ហាក់បីដូចជាមិនមានកម្មវិធី ណាមួយសម្រាប់លេងទេ។ សូម <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ទាញយកកម្មវិធី សម្រាប់លេងនៅទីនេះ</a> ។',
	'ogg-no-xiphqt' => 'មិនឃើញមាន អង្គផ្សំ XiphQT សម្រាប់ QuickTime។ QuickTime មិនអាចអាន ឯកសារ ដោយ គ្មាន អង្គផ្សំនេះ។ ទាញយក <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download"> និង ដំឡើង XiphQT</a> ឬ ជ្រើសរើស ឧបករណ៍អាន ផ្សេង ។',
	'ogg-player-videoElement' => 'Native browser support',
	'ogg-player-oggPlugin' => 'កម្មវិធីជំនួយ​របស់​កម្មវិធីរុករក',
	'ogg-player-thumbnail' => 'នៅតែជារូបភាព',
	'ogg-player-soundthumb' => 'មិនមានឧបករណ៍លេងទេ',
	'ogg-player-selected' => '(បានជ្រើសយក)',
	'ogg-use-player' => 'ប្រើប្រាស់ឧបករណ៍លេង៖',
	'ogg-more' => 'បន្ថែម...',
	'ogg-dismiss' => 'បិទ',
	'ogg-download' => 'ទាញយកឯកសារ',
	'ogg-desc-link' => 'អំពីឯកសារនេះ',
);

/** Korean (한국어)
 * @author AVRS
 * @author ITurtle
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'ogg-desc' => 'OGG Theora 및 Vorbis 파일 핸들러와 자바스크립트 플레이어',
	'ogg-short-audio' => 'Ogg $1 소리 파일, $2',
	'ogg-short-video' => 'Ogg $1 영상 파일, $2',
	'ogg-short-general' => 'Ogg $1 미디어 파일, $2',
	'ogg-long-audio' => '(Ogg $1 소리 파일, 길이 $2, $3)',
	'ogg-long-video' => 'Ogg $1 영상 파일, 길이 $2, $4×$5 픽셀, $3',
	'ogg-long-multiplexed' => '(Ogg 다중 소리/영상 파일, $1, 길이 $2, $4×$5 픽셀, 대략 $3)',
	'ogg-long-general' => '(Ogg 미디어 파일, 길이 $2, $3)',
	'ogg-long-error' => '(잘못된 ogg 파일: $1)',
	'ogg-play' => '재생',
	'ogg-pause' => '일시정지',
	'ogg-stop' => '정지',
	'ogg-play-video' => '영상 재생하기',
	'ogg-play-sound' => '소리 재생하기',
	'ogg-no-player' => '죄송합니다. 이 시스템에는 재생을 지원하는 플레이어가 설치되지 않은 것 같습니다. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">플레이어를 내려받으세요.</a>',
	'ogg-no-xiphqt' => 'QuickTime의 XiphQT 구성 요소가 없는 것 같습니다.
QuickTime은 이 구성 요소 없이는 Ogg 파일을 재생할 수 없습니다.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download"> XiphQT를 내려받거나</a> 다른 플레이어를 선택하십시오.',
	'ogg-player-videoElement' => '기본 브라우저 지원',
	'ogg-player-oggPlugin' => '브라우저 플러그인',
	'ogg-player-thumbnail' => '정지 화면만',
	'ogg-player-soundthumb' => '플레이어 없음',
	'ogg-player-selected' => '(선택함)',
	'ogg-use-player' => '사용할 플레이어:',
	'ogg-more' => '더 보기...',
	'ogg-dismiss' => '닫기',
	'ogg-download' => '파일 다운로드',
	'ogg-desc-link' => '파일 정보',
	'ogg-oggThumb-version' => 'OggHandler는 oggThumb 버전 $1 이상을 요구합니다.',
	'ogg-oggThumb-failed' => 'oggThumb가 섬네일을 생성하지 못했습니다.',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'ogg-more' => 'Raku pa...',
);

/** Colognian (Ripoarisch)
 * @author AVRS
 * @author Purodha
 */
$messages['ksh'] = array(
	'ogg-desc' => 'En Projamm (<i lang="en">handler</i>) för <i lang="en">Ogg Theora</i> un <i lang="en">Ogg Vorbis</i> Dateie, met enem Afspiller-Projramm en Javaskrip.',
	'ogg-short-audio' => '<i lang="en">Ogg $1</i> Tondatei, $2',
	'ogg-short-video' => '<i lang="en">Ogg $1</i> Viddejodatei, $2',
	'ogg-short-general' => '<i lang="en">Ogg $1</i> Medijedatei, $2',
	'ogg-long-audio' => '(<i lang="en">Ogg $1</i> Tondatei fum Ömfang $2, $3)',
	'ogg-long-video' => '<i lang="en">Ogg $1</i> Viddejodatei fum Ömfang $2 un {{PLURAL:$4|ein Pixel|$4 Pixelle|kei Pixel}} × {{PLURAL:$5|ei Pixel|$4 Pixelle|kei Pixel}}, $3',
	'ogg-long-multiplexed' => '(<i lang="en">Ogg</i> jemultipex Ton- un Viddejodatei, $1, fum Ömfang $2 un {{PLURAL:$4|ein Pixel|$4 Pixelle|kei Pixel}} × {{PLURAL:$5|ei Pixel|$4 Pixelle|kei Pixel}}, $3 ennsjesammp)',
	'ogg-long-general' => '(<i lang="en">Ogg</i> Medijedatei fum Ömfang $2, $3)',
	'ogg-long-error' => '(ene kapodde <i lang="en">Ogg</i> Datei: $1)',
	'ogg-play' => 'Loßläje!',
	'ogg-pause' => 'Aanhallde!',
	'ogg-stop' => 'Ophüre!',
	'ogg-play-video' => 'Dun der Viddejo affshpelle',
	'ogg-play-sound' => 'Dä Ton afshpelle',
	'ogg-no-player' => 'Deijt mer leid, süüd_esu uß, wi wann Dinge Kompjutor kei
Affspellprojramm hät, wat mer öngerstoze däte.
Beß esu joot, un <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">donn e Affspellprojramm erunger lade</a>.',
	'ogg-no-xiphqt' => 'Deijt mer leid, süüd_esu uß, wi wann Dinge Kompjutor nit
dat XiphQT Affspellprojrammstöck för <i lang="en">QuickTime</i> hät,
ävver <i lang="en">QuickTime</i> kann <i lang="en">Ogg</i>-Dateie
der oohne nit affspelle.
Beß esu joot, un <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">donn dat XiphQT erunger lade</a>,
udder sök Der en annder Affspellprojramm uß.',
	'ogg-player-videoElement' => 'Ongerstözung för Brauser',
	'ogg-player-oggPlugin' => 'Brauser <i lang="en">Plug-In</i>',
	'ogg-player-cortado' => 'Cortado (Java)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (<i lang="en">ActiveX</i>)',
	'ogg-player-quicktime-mozilla' => '<i lang="en">QuickTime</i>',
	'ogg-player-quicktime-activex' => '<i lang="en">QuickTime</i> (<i lang="en">ActiveX</i>)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KM<i lang="en">Player</i>',
	'ogg-player-kaffeine' => '<i lang="en">Kaffeine</i>',
	'ogg-player-mplayerplug-in' => '<i lang="en">mplayerplug-in</i>',
	'ogg-player-thumbnail' => 'Bloß e Standbeld',
	'ogg-player-soundthumb' => 'Kei Affspellprojramm',
	'ogg-player-selected' => '(Ußjesoht)',
	'ogg-use-player' => 'Affspellprojramm:',
	'ogg-more' => 'Enshtelle&nbsp;…',
	'ogg-dismiss' => 'Zohmaache',
	'ogg-download' => 'Datei erunger lade',
	'ogg-desc-link' => 'Övver di Datei',
	'ogg-oggThumb-version' => 'Dä <code lang="en">OggHandler</code> bruch <code lang="en">oggThumb</code> in dä Version $1 udder hüüter.',
	'ogg-oggThumb-failed' => '<code lang="en">oggThumb</code> kunnt kei MiniBelldsche maache.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'ogg-play' => 'Bileyzîne',
	'ogg-pause' => 'Rawestîne',
	'ogg-stop' => 'Bisekne',
	'ogg-play-video' => 'Vîdeoyê bileyzîne',
	'ogg-play-sound' => 'Deng veke',
	'ogg-more' => 'Bêhtir...',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'ogg-more' => 'Plus...',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author AVRS
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'ogg-desc' => 'Steierungsprogramm fir Ogg Theora a Vorbis Fichieren, mat enger JavaScript-Player-Software',
	'ogg-short-audio' => 'Ogg-$1-Tounfichier, $2',
	'ogg-short-video' => 'Ogg-$1-Videofichier, $2',
	'ogg-short-general' => 'Ogg-$1-Mediefichier, $2',
	'ogg-long-audio' => '(Ogg-$1-Tounfichier, Dauer: $2, $3)',
	'ogg-long-video' => 'Ogg-$1-Videofichier, Dauer: $2, $4×$5 Pixel, $3',
	'ogg-long-multiplexed' => '(Ogg-Toun-/Video-Fichier, $1, Dauer: $2, $4×$5 Pixel, $3)',
	'ogg-long-general' => '(Ogg Media-Fichier, Dauer $2, $3)',
	'ogg-long-error' => '(Ongëltegen Ogg-Fichier: $1)',
	'ogg-play' => 'Ofspillen',
	'ogg-pause' => 'Paus',
	'ogg-stop' => 'Stopp',
	'ogg-play-video' => 'Video ofspillen',
	'ogg-play-sound' => 'Tounfichier ofspillen',
	'ogg-no-player' => 'Pardon, Äre Betriibssystem schengt keng Software ze hunn fir d\'Fichieren ofzespillen. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Lued w.e.g. esou eng Software erof</a> an installéiert se w.e.g. .',
	'ogg-no-xiphqt' => 'Dir hutt anscheinend d\'Komponent  XiphQT fir QuickTime net installéiert.
QuickTime kann Ogg-Fichiere net ouni dës Komponent spillen.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Lued XiphQT w.e.g. erof</a> oder wielt eng aner Software.',
	'ogg-player-videoElement' => 'Ënnerstëtzt duerch de Browser',
	'ogg-player-oggPlugin' => 'Browser-Plugin',
	'ogg-player-thumbnail' => 'Just als Bild weisen',
	'ogg-player-soundthumb' => 'Keng Player-Software',
	'ogg-player-selected' => '(erausgewielt)',
	'ogg-use-player' => "Benotzt d'Player-Software:",
	'ogg-more' => 'Méi ...',
	'ogg-dismiss' => 'Zoumaachen',
	'ogg-download' => 'Fichier eroflueden',
	'ogg-desc-link' => 'Iwwer dëse Fichier',
	'ogg-oggThumb-version' => 'OggHandler brauch oggThumb Versioun $1 oder méi eng nei.',
	'ogg-oggThumb-failed' => 'oggThumb konnt kee Miniaturbild maachen.',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'ogg-more' => 'Plu…',
);

/** Limburgish (Limburgs)
 * @author AVRS
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'ogg-desc' => "Handelt Ogg Theora- en Vorbis-bestande aaf met 'n JavaScript-mediaspeler",
	'ogg-short-audio' => 'Ogg $1 geluidsbestandj, $2',
	'ogg-short-video' => 'Ogg $1 videobestandj, $2',
	'ogg-short-general' => 'Ogg $1 mediabestandj, $2',
	'ogg-long-audio' => '(Ogg $1 geluidsbestandj, lingdje $2, $3)',
	'ogg-long-video' => 'Ogg $1 videobestandj, lingdje $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(Ogg gemultiplexeerd geluids-/videobestandj, $1, lingdje $2, $4×$5 pixels, $3 totaal)',
	'ogg-long-general' => '(Ogg mediabestandj, lingdje $2, $3)',
	'ogg-long-error' => '(Óngeljig oggg-bestandj: $1)',
	'ogg-play' => 'Aafspele',
	'ogg-pause' => 'Óngerbraeke',
	'ogg-stop' => 'Oetsjeije',
	'ogg-play-video' => 'Video aafspele',
	'ogg-play-sound' => 'Geluid aafspele',
	'ogg-no-player' => 'Sorry, uch systeem haet gein van de ongersteunde mediaspelers. Installeer estebleef <a href="http://www.java.com/nl/download/manual.jsp">Java</a>.',
	'ogg-no-xiphqt' => "'t Liek d'r op det geer 't component XiphQT veur QuickTime neet haet. QuickTime kin Ogg-bestenj neet aafspele zonger dit component. Download <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">XiphQT</a> estebleef of kees 'ne angere speler.",
	'ogg-player-videoElement' => 'Native browsersupport',
	'ogg-player-oggPlugin' => 'Browserplugin',
	'ogg-player-thumbnail' => 'Allein stilstaondj beild',
	'ogg-player-soundthumb' => 'Geine mediaspeler',
	'ogg-player-selected' => '(geselectieërdj)',
	'ogg-use-player' => 'Gebroek speler:',
	'ogg-more' => 'Mieë...',
	'ogg-dismiss' => 'Sloet',
	'ogg-download' => 'Bestandj downloade',
	'ogg-desc-link' => 'Euver dit bestandj',
	'ogg-oggThumb-version' => 'OggHandler vereis oggThumb versie $1 of hoeger.',
	'ogg-oggThumb-failed' => 'oggThumb kós geine thumbnail make.',
);

/** Lithuanian (Lietuvių)
 * @author AVRS
 * @author Homo
 * @author Matasg
 */
$messages['lt'] = array(
	'ogg-desc' => 'Įrankis groti Ogg Theora ir Vorbis failus su JavaScript grotuvu',
	'ogg-short-audio' => 'Ogg $1 garso byla, $2',
	'ogg-short-video' => 'Ogg $1 video byla, $2',
	'ogg-short-general' => 'Ogg $1 medija byla, $2',
	'ogg-long-audio' => '(Ogg $1 garso byla, ilgis $2, $3)',
	'ogg-long-video' => 'Ogg $1 video byla, ilgis $2, $4×$5 pikseliai, $3',
	'ogg-long-multiplexed' => '(Ogg sutankinta audio/video byla, $1, ilgis $2, $4×$5 pikseliai, $3 viso)',
	'ogg-long-general' => '(Ogg media byla, ilgis $2, $3)',
	'ogg-long-error' => '(Bloga ogg byla: $1)',
	'ogg-play' => 'Groti',
	'ogg-pause' => 'Pauzė',
	'ogg-stop' => 'Sustabdyti',
	'ogg-play-video' => 'Groti video',
	'ogg-play-sound' => 'Groti garsą',
	'ogg-no-player' => 'Atsiprašome, neatrodo, kad jūsų sistema turi palaikomą grotuvą. Prašome <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">jį atsisiųsti</a>.',
	'ogg-no-xiphqt' => 'Neatrodo, kad jūs turite XiphQT komponentą QuickTime grotuvui. QuickTime negali groti Ogg bylų be šio komponento. Prašome <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">atsisiųsti XiphQT</a> arba pasirinkti kitą grotuvą.',
	'ogg-player-videoElement' => 'Pagrindinės naršyklės palaikymas',
	'ogg-player-oggPlugin' => 'Naršyklės priedas',
	'ogg-player-thumbnail' => 'Tik paveikslėlis',
	'ogg-player-soundthumb' => 'Nėra grotuvo',
	'ogg-player-selected' => '(pasirinkta)',
	'ogg-use-player' => 'Naudoti grotuvą:',
	'ogg-more' => 'Daugiau...',
	'ogg-dismiss' => 'Uždaryti',
	'ogg-download' => 'Atsisiųsti bylą',
	'ogg-desc-link' => 'Apie šią bylą',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 * @author Papuass
 * @author Xil
 */
$messages['lv'] = array(
	'ogg-desc' => 'Ogg Theora un Vorbis failu apstrādātājs ar JavaScript atskaņotāju',
	'ogg-short-audio' => 'Ogg $1 skaņas fails, $2',
	'ogg-short-video' => 'Ogg $1 video fails, $2',
	'ogg-short-general' => 'Ogg $1 multimediju fails, $2',
	'ogg-long-audio' => 'Ogg $1 skaņas fails, garums $2, $3',
	'ogg-long-video' => 'Ogg $1 video fails, garums $2, $4×$5 pikseļi, $3',
	'ogg-long-general' => 'Ogg multimediju fails, garums $2, $3',
	'ogg-long-error' => 'Nepareizs ogg fails: $1',
	'ogg-play' => 'Atskaņot',
	'ogg-pause' => 'Pauze',
	'ogg-stop' => 'Apstādināt',
	'ogg-play-video' => 'Atskaņot videoklipu',
	'ogg-play-sound' => 'Atskaņot skaņu',
	'ogg-player-oggPlugin' => 'Pārlūka spraudnis',
	'ogg-player-selected' => '(izvēlēts)',
	'ogg-more' => 'Vairāk...',
	'ogg-dismiss' => 'Aizvērt',
	'ogg-download' => 'Lejupielādēt failu',
	'ogg-desc-link' => 'Par šo failu',
	'ogg-oggThumb-version' => 'OggHandler nepieciešama oggThumb $1 vai jaunāka versija.',
);

/** Macedonian (Македонски)
 * @author AVRS
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'ogg-desc' => 'Ракувач со Ogg Theora и Vorbis податотеки, со JavaScript изведувач',
	'ogg-short-audio' => 'Ogg $1 звучна податотека, $2',
	'ogg-short-video' => 'Ogg $1 видео податотека, $2',
	'ogg-short-general' => 'Мултимедијална податотека Ogg $1, $2',
	'ogg-long-audio' => '(Ogg $1 аудиоснимка, времетраење: $2, $3)',
	'ogg-long-video' => 'Ogg $1 видеоснимка, времетраење: $2, $4 × $5 пиксели, $3',
	'ogg-long-multiplexed' => '(мултиплексирана Ogg аудио/видеоснимка, $1, времетраење: $2, $4 × $5 пиксели, вкупно $3)',
	'ogg-long-general' => '(Ogg-снимка, времетраење: $2, $3)',
	'ogg-long-error' => '(Оштетена ogg податотека: $1)',
	'ogg-play' => 'Пушти',
	'ogg-pause' => 'Паузирај',
	'ogg-stop' => 'Запри',
	'ogg-play-video' => 'Пушти видеоснимка',
	'ogg-play-sound' => 'Слушни аудио снимка',
	'ogg-no-player' => 'Изгледа дека вашиот систем нема инсталирано никаква програмска опрема за преслушување/прегледување на аудио или видео снимки.
 a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Тука преземете изведувач за таа намена</a>.',
	'ogg-no-xiphqt' => 'Изгледа го немате инсталирано делот XiphQT за QuickTime.
QuickTime не може да преслушува/прегледува Ogg податотеки без оваа компонента.
Можете да го <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">преземете XiphQT</a> или да изберете некоја друга програмска опрема за преслушување/прегледување.',
	'ogg-player-videoElement' => 'Поддржано од прелистувачот',
	'ogg-player-oggPlugin' => 'Вградено во прелистувачот',
	'ogg-player-cortado' => 'Cortado (Java)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (ActiveX)',
	'ogg-player-quicktime-mozilla' => 'QuickTime',
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-kaffeine' => 'Kaffeine',
	'ogg-player-mplayerplug-in' => 'mplayerplug-in',
	'ogg-player-thumbnail' => 'Само неподвижни слики',
	'ogg-player-soundthumb' => 'Нема изведувач',
	'ogg-player-selected' => '(избрано)',
	'ogg-use-player' => 'Користи:',
	'ogg-more' => 'Повеќе...',
	'ogg-dismiss' => 'Затвори',
	'ogg-download' => 'Преземи податотека',
	'ogg-desc-link' => 'Информации за оваа податотека',
	'ogg-oggThumb-version' => 'OggHandler бара oggThumb - верзија $1 или понова.',
	'ogg-oggThumb-failed' => 'oggThumb не успеа да ја создаде минијатурата.',
);

/** Malayalam (മലയാളം)
 * @author AVRS
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'ogg-desc' => 'ജാവാസ്ക്രിപ്റ്റ് പ്ലേയർ ഉപയോഗിച്ച് ഓഗ് തിയോറ, വോർബിസ് പ്രമാണങ്ങൾ കൈകാര്യം ചെയ്യൽ',
	'ogg-short-audio' => 'ഓഗ് $1 ശബ്ദപ്രമാണം, $2',
	'ogg-short-video' => 'ഓഗ് $1 വീഡിയോ പ്രമാണം, $2',
	'ogg-short-general' => 'ഓഗ് $1 മീഡിയ പ്രമാണം, $2',
	'ogg-long-audio' => '(ഓഗ് $1 ശബ്ദ പ്രമാണം, ദൈർഘ്യം $2, $3)',
	'ogg-long-video' => 'ഓഗ് $1 വീഡിയോ പ്രമാണം, ദൈർഘ്യം $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(ഓഗ് മൾട്ടിപ്ലക്സ്‌‌ഡ് ശബ്ദ/ചലച്ചിത്ര പ്രമാണം, $1, ദൈർഘ്യം $2, $4×$5 ബിന്ദു, ആകെക്കൂടി $3)',
	'ogg-long-general' => '(ഓഗ് മീഡിയ പ്രമാണം, ദൈർഘ്യം $2, $3)',
	'ogg-long-error' => '(അസാധുവായ ഓഗ് പ്രമാണം: $1)',
	'ogg-play' => 'പ്രവർത്തിപ്പിക്കുക',
	'ogg-pause' => 'താൽക്കാലികമായി നിർത്തുക',
	'ogg-stop' => 'നിർത്തുക',
	'ogg-play-video' => 'വീഡിയോ പ്രവർത്തിപ്പിക്കുക',
	'ogg-play-sound' => 'ശബ്ദം പ്രവർത്തിപ്പിക്കുക',
	'ogg-no-player' => 'ക്ഷമിക്കണം. താങ്കളുടെ കമ്പ്യൂട്ടറിൽ ഓഗ് പ്രമാണം പ്രവർത്തിപ്പിക്കാനാവശ്യമായ സോഫ്റ്റ്‌ഫെയർ ഇല്ല. ദയവു ചെയ്ത് ഒരു പ്ലെയർ <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ഡൗൺലോഡ് ചെയ്യുക</a>.',
	'ogg-no-xiphqt' => 'ക്വിക്ക്റ്റൈമിനുള്ള XiphQT ഘടകം താങ്കളുടെ പക്കലുണ്ടെന്നു കാണുന്നില്ല.
ഓഗ് പ്രമാണങ്ങൾ ഈ ഘടകമില്ലാതെ പ്രവർത്തിപ്പിക്കാൻ ക്വിക്ക്റ്റൈമിനു കഴിയില്ല.
ദയവായി <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT ഡൗൺലോഡ് ചെയ്യുക</a> അല്ലെങ്കിൽ മറ്റൊരു പ്ലേയർ തിരഞ്ഞെടുക്കുക.',
	'ogg-player-videoElement' => 'ബ്രൗസറിൽ സ്വതേയുള്ള പിന്തുണ',
	'ogg-player-oggPlugin' => 'ബ്രൗസർ പ്ലഗിൻ',
	'ogg-player-quicktime-mozilla' => 'ക്വിക്ക്റ്റൈം',
	'ogg-player-quicktime-activex' => 'ക്വിക്ക്റ്റൈം (ആക്റ്റീവ്‌‌എക്സ്)',
	'ogg-player-thumbnail' => 'നിശ്ചല ചിത്രം മാത്രം',
	'ogg-player-soundthumb' => 'പ്ലെയർ ഇല്ല',
	'ogg-player-selected' => '(തിരഞ്ഞെടുത്തവ)',
	'ogg-use-player' => 'ഈ പ്ലെയർ ഉപയോഗിക്കുക',
	'ogg-more' => 'കൂടുതൽ...',
	'ogg-dismiss' => 'അടയ്ക്കുക',
	'ogg-download' => 'പ്രമാണം ഡൗൺലോഡ് ചെയ്യുക',
	'ogg-desc-link' => 'ഈ പ്രമാണത്തെക്കുറിച്ച്',
	'ogg-oggThumb-version' => 'ഓഗ്-തമ്പ് പതിപ്പ് $1 അല്ലെങ്കിൽ പുതിയത് ഓഗ്-ഹാൻഡ്ലറിനാവശ്യമാണ്.',
	'ogg-oggThumb-failed' => 'ലഘുചിത്രം സൃഷ്ടിക്കുന്നതിൽ ഓഗ്-തമ്പ് പരാജയപ്പെട്ടു.',
);

/** Marathi (मराठी)
 * @author AVRS
 * @author Kaajawa
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'ogg-desc' => 'ऑग थियोरा व वॉर्बिस संचिकांसाठीचा चालक, जावास्क्रीप्ट प्लेयर सकट',
	'ogg-short-audio' => 'ऑग $1 ध्वनी संचिका, $2',
	'ogg-short-video' => 'ऑग $1 चलतचित्र संचिका, $2',
	'ogg-short-general' => 'ऑग $1 मीडिया संचिका, $2',
	'ogg-long-audio' => '(ऑग $1 ध्वनी संचिका, लांबी $2, $3)',
	'ogg-long-video' => 'ऑग $1 चलतचित्र संचिका, लांबी $2, $4×$5 पीक्सेल्स, $3',
	'ogg-long-multiplexed' => '(ऑग ध्वनी/चित्र संचिका, $1, लांबी $2, $4×$5 पिक्सेल्स, $3 एकूण)',
	'ogg-long-general' => '(ऑग मीडिया संचिका, लांबी $2, $3)',
	'ogg-long-error' => '(चुकीची ऑग संचिका: $1)',
	'ogg-play' => 'चालू करा',
	'ogg-pause' => 'विराम',
	'ogg-stop' => 'थांबवा',
	'ogg-play-video' => 'चलतचित्र चालू करा',
	'ogg-play-sound' => 'ध्वनी चालू करा',
	'ogg-no-player' => 'माफ करा, पण तुमच्या संगणकामध्ये कुठलाही प्लेयर आढळला नाही. कृपया <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">प्लेयर डाउनलोड करा</a>.',
	'ogg-no-xiphqt' => 'तुमच्या संगणकामध्ये क्वीकटाईम ला लागणारा XiphQT हा तुकडा आढळला नाही. याशिवाय क्वीकटाईम ऑग संचिका चालवू शकणार नाही. कॄपया <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT डाउनलोड करा</a> किंवा दुसरा प्लेयर वापरा.',
	'ogg-player-videoElement' => 'मूल ब्राउज़र समर्थन',
	'ogg-player-oggPlugin' => 'न्याहाळक प्लगीन',
	'ogg-player-cortado' => 'कोर्टाडो (जावा)',
	'ogg-player-thumbnail' => 'फक्त स्थिर चित्र',
	'ogg-player-soundthumb' => 'प्लेयर उपलब्ध नाही',
	'ogg-player-selected' => '(निवडलेले)',
	'ogg-use-player' => 'हा प्लेयर वापरा:',
	'ogg-more' => 'आणखी...',
	'ogg-dismiss' => 'बंद करा',
	'ogg-download' => 'संचिका उतरवा',
	'ogg-desc-link' => 'या संचिकेबद्दलची माहिती',
	'ogg-oggThumb-version' => 'OggHandler ला  oggThumb च्या  $1 अथवा त्या नंतरच्या आवृउत्तीची गरज आहे',
	'ogg-oggThumb-failed' => 'oggThumb इवलेसे-चित्र निर्माणकरण्यात यशस्वी झाले नाही.',
);

/** Malay (Bahasa Melayu)
 * @author AVRS
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'ogg-desc' => 'Pengelola fail Ogg Theora dan Vorbis, dengan pemain JavaScript',
	'ogg-short-audio' => 'fail bunyi Ogg $1, $2',
	'ogg-short-video' => 'fail video Ogg $1, $2',
	'ogg-short-general' => 'fail media Ogg $1, $2',
	'ogg-long-audio' => '(fail bunyi Ogg $1, tempoh $2, $3)',
	'ogg-long-video' => 'fail video Ogg $1, tempoh $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(fail audio/video multipleks Ogg, $1, tempoh $2, $4×$5 piksel, keseluruhan $3)',
	'ogg-long-general' => '(fail media Ogg, tempoh $2, $3)',
	'ogg-long-error' => '(Fail Ogg tidak sah: $1)',
	'ogg-play' => 'Mainkan',
	'ogg-pause' => 'Jedakan',
	'ogg-stop' => 'Hentikan',
	'ogg-play-video' => 'Main video',
	'ogg-play-sound' => 'Main bunyi',
	'ogg-no-player' => 'Maaf, sistem anda tidak mempunyai perisian pemain yang disokong. Sila <a href=\\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\\">muat turun sebuah pemain</a>.',
	'ogg-no-xiphqt' => 'Anda tidak mempunyai komponen XiphQT untuk QuickTime. QuickTime tidak boleh memainkan fail Ogg tanpa komponen ini. Sila <a href=\\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\\">muat turun XiphQT</a> atau pilih pemain lain.',
	'ogg-player-videoElement' => 'Sokongan dalaman pelayar web',
	'ogg-player-oggPlugin' => 'Pemalam untuk pelayar web',
	'ogg-player-cortado' => 'Cortado (Java)',
	'ogg-player-vlc-activex' => 'VLC (ActiveX)',
	'ogg-player-quicktime-mozilla' => 'QuickTime',
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-thumbnail' => 'Imej pegun sahaja',
	'ogg-player-soundthumb' => 'Tiada pemain',
	'ogg-player-selected' => '(dipilih)',
	'ogg-use-player' => 'Gunakan pemain:',
	'ogg-more' => 'Lagi…',
	'ogg-dismiss' => 'Tutup',
	'ogg-download' => 'Muat turun fail',
	'ogg-desc-link' => 'Perihal fail ini',
	'ogg-oggThumb-version' => 'OggHandler memerlukan oggThumb versi $1 ke atas.',
	'ogg-oggThumb-failed' => 'oggThumb gagal mencipta gambar kenit.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'ogg-dismiss' => 'Agħlaq',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'ogg-play' => 'Седик',
	'ogg-pause' => 'Аштевтик',
	'ogg-stop' => 'Лоткавтык',
	'ogg-play-video' => 'Нолдык видеонть',
	'ogg-play-sound' => 'Нолдык вайгеленть',
	'ogg-player-selected' => '(кочказь)',
	'ogg-dismiss' => 'Пекстамс',
	'ogg-desc-link' => 'Те файладонть',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'ogg-more' => 'Huehca ōmpa...',
	'ogg-download' => 'Tictemōz tlahcuilōlli',
	'ogg-desc-link' => 'Inīn tlahcuilōltechcopa',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author AVRS
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'ogg-desc' => 'Gjør at Ogg Theora- og Ogg Vorbis-filer kan kjøres med hjelp av JavaScript-avspiller.',
	'ogg-short-audio' => 'Ogg $1 lydfil, $2',
	'ogg-short-video' => 'Ogg $1 videofil, $2',
	'ogg-short-general' => 'Ogg $1 mediefil, $2',
	'ogg-long-audio' => '(Ogg $1 lydfil, lengde $2, $3)',
	'ogg-long-video' => 'Ogg $1 videofil, lengde $2, $4×$5 piksler, $3',
	'ogg-long-multiplexed' => '(Sammensatt ogg lyd-/videofil, $1, lengde $2, $4×$5 piksler, $3 til sammen)',
	'ogg-long-general' => '(Ogg mediefil, lengde $2, $3)',
	'ogg-long-error' => '(Ugyldig ogg-fil: $1)',
	'ogg-play' => 'Spill',
	'ogg-pause' => 'Pause',
	'ogg-stop' => 'Stopp',
	'ogg-play-video' => 'Spill av video',
	'ogg-play-sound' => 'Spill av lyd',
	'ogg-no-player' => 'Beklager, systemet ditt har ingen medieavspillere som støtter filformatet. Vennligst <a href="http://mediawiki.org/wiki/Extension:OggHandler/Client_download">last ned en avspiller</a> som støtter formatet.',
	'ogg-no-xiphqt' => 'Du har ingen XiphQT-komponent for QuickTime. QuickTime kan ikke spille Ogg-filer uten denne komponenten. <a href="http://mediawiki.org/wiki/Extension:OggHandler/Client_download">last ned XiphQT</a> eller velg en annen medieavspiller.',
	'ogg-player-videoElement' => 'Innebygd nettleserstøtte',
	'ogg-player-oggPlugin' => 'Programtillegg for nettleser',
	'ogg-player-thumbnail' => 'Kun stillbilder',
	'ogg-player-soundthumb' => 'Ingen medieavspiller',
	'ogg-player-selected' => '(valgt)',
	'ogg-use-player' => 'Bruk avspiller:',
	'ogg-more' => 'Mer …',
	'ogg-dismiss' => 'Lukk',
	'ogg-download' => 'Last ned fil',
	'ogg-desc-link' => 'Om denne filen',
	'ogg-oggThumb-version' => 'OggHandler krever oggThumb versjon $1 eller senere.',
	'ogg-oggThumb-failed' => 'oggThumb klarte ikke å opprette miniatyrbildet.',
);

/** Low German (Plattdüütsch)
 * @author AVRS
 * @author Slomox
 */
$messages['nds'] = array(
	'ogg-desc' => 'Stüürprogramm för Ogg-Theora- un Vorbis Datein, mitsamt en Afspeler in JavaScript',
	'ogg-short-audio' => 'Ogg-$1-Toondatei, $2',
	'ogg-short-video' => 'Ogg-$1-Videodatei, $2',
	'ogg-short-general' => 'Ogg-$1-Mediendatei, $2',
	'ogg-long-audio' => '(Ogg-$1-Toondatei, $2 lang, $3)',
	'ogg-long-video' => 'Ogg-$1-Videodatei, $2 lang, $4×$5 Pixels, $3',
	'ogg-long-multiplexed' => '(Ogg-Multiplexed-Audio-/Video-Datei, $1, $2 lang, $4×$5 Pixels, $3 alltohoop)',
	'ogg-long-general' => '(Ogg-Mediendatei, $2 lang, $3)',
	'ogg-long-error' => '(Kaputte Ogg-Datei: $1)',
	'ogg-play' => 'Afspelen',
	'ogg-pause' => 'Paus',
	'ogg-stop' => 'Stopp',
	'ogg-play-video' => 'Video afspelen',
	'ogg-play-sound' => 'Toondatei afspelen',
	'ogg-no-player' => 'Süht so ut, as wenn dien Reekner keen passlichen Afspeler hett. Du kannst en <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Afspeler dalladen</a>.',
	'ogg-no-xiphqt' => 'Süht so ut, as wenn dien Reekner de XiphQT-Kumponent för QuickTime nich hett. Ahn dat Ding kann QuickTime keen Ogg-Datein afspelen. Du kannst <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT dalladen</a> oder en annern Afspeler utwählen.',
	'ogg-player-videoElement' => 'Standard-Ünnerstüttung in’n Browser',
	'ogg-player-oggPlugin' => 'Browser-Plugin',
	'ogg-player-thumbnail' => 'blot Standbild',
	'ogg-player-soundthumb' => 'Keen Afspeler',
	'ogg-player-selected' => '(utwählt)',
	'ogg-use-player' => 'Afspeler bruken:',
	'ogg-more' => 'Mehr...',
	'ogg-dismiss' => 'Dichtmaken',
	'ogg-download' => 'Datei dalladen',
	'ogg-desc-link' => 'Över disse Datei',
);

/** Nedersaksisch (Nedersaksisch)
 * @author AVRS
 * @author Servien
 */
$messages['nds-nl'] = array(
	'ogg-desc' => 'Haandelt veur Ogg Theora- en Vorbis-bestaanden, mit JavaScript-mediaspeuler',
	'ogg-short-audio' => 'Ogg $1 geluudsbestaand, $2',
	'ogg-short-video' => 'Ogg $1 videobestaand, $2',
	'ogg-short-general' => 'Ogg $1 mediabestaand, $2',
	'ogg-long-audio' => '(Ogg $1 geluudsbestaand, lengte $2, $3)',
	'ogg-long-video' => 'Ogg $1 videobestaand, lengte $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(Ogg-emultiplext geluuds-/videobestaand, $1, lengte $2, $4×$5 pixels, $3 totaal)',
	'ogg-long-general' => '(Ogg-mediabestaand, lengte $2, $3)',
	'ogg-long-error' => '(Ongeldig ogg-bestaand: $1)',
	'ogg-play' => 'Aofspeulen',
	'ogg-pause' => 'Pauze',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Video aofspeulen',
	'ogg-play-sound' => 'Geluud aofspeulen',
	'ogg-no-player' => 'Joew system hef gien ondersteunende mediaspeulers.
Installeer n <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">mediaspeuler</a>.',
	'ogg-no-xiphqt' => 't Lik derop da\'j de komponent XiphQT veur QuickTime niet hebben.
QuickTime kan Ogg-bestaanden niet aofspeulen zonder dit komponent.
Installeer <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT</a> of kies n aandere mediaspeuler.',
	'ogg-player-videoElement' => 'Standardondersteuning in webkieker',
	'ogg-player-oggPlugin' => 'Webkiekeruutbreiding',
	'ogg-player-thumbnail' => 'Allenig stilstaond beeld',
	'ogg-player-soundthumb' => 'Gien mediaspeuler',
	'ogg-player-selected' => '(ekeuzen)',
	'ogg-use-player' => 'Gebruuk mediaspeuler:',
	'ogg-more' => 'Meer...',
	'ogg-dismiss' => 'Sluten',
	'ogg-download' => 'Bestaand binnenhaolen',
	'ogg-desc-link' => 'Over dit bestaand',
	'ogg-oggThumb-version' => "Veur OggHandler he'j oggThumb-versie $1 of hoger neudig.",
	'ogg-oggThumb-failed' => 'oggThumb kon gien miniatuuraofbeelding anmaken.',
);

/** Dutch (Nederlands)
 * @author AVRS
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'ogg-desc' => 'Handelt Ogg Theora- en Vorbis-bestanden af met een JavaScript-mediaspeler',
	'ogg-short-audio' => 'Ogg $1 geluidsbestand, $2',
	'ogg-short-video' => 'Ogg $1 videobestand, $2',
	'ogg-short-general' => 'Ogg $1 mediabestand, $2',
	'ogg-long-audio' => '(Ogg $1 geluidsbestand, lengte $2, $3)',
	'ogg-long-video' => 'Ogg $1 videobestand, lengte $2, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(Ogg gemultiplexed geluids/videobestand, $1, lengte $2, $4×$5 pixels, $3 totaal)',
	'ogg-long-general' => '(Ogg mediabestand, lengte $2, $3)',
	'ogg-long-error' => '(Ongeldig ogg-bestand: $1)',
	'ogg-play' => 'Afspelen',
	'ogg-pause' => 'Pauze',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Video afspelen',
	'ogg-play-sound' => 'Geluid afspelen',
	'ogg-no-player' => 'Uw systeem heeft geen van de ondersteunde mediaspelers.
Installeer <a href="http://www.java.com/nl/download/manual.jsp">Java</a>.',
	'ogg-no-xiphqt' => 'Het lijkt erop dat u de component XiphQT voor QuickTime niet hebt.
QuickTime kan Ogg-bestanden niet afspelen zonder deze component.
Download <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT</a> of kies een andere speler.',
	'ogg-player-videoElement' => 'Standaardondersteuning in browser',
	'ogg-player-oggPlugin' => 'Browserplugin',
	'ogg-player-thumbnail' => 'Alleen stilstaand beeld',
	'ogg-player-soundthumb' => 'Geen mediaspeler',
	'ogg-player-selected' => '(geselecteerd)',
	'ogg-use-player' => 'Gebruik speler:',
	'ogg-more' => 'Meer…',
	'ogg-dismiss' => 'Sluiten',
	'ogg-download' => 'Bestand downloaden',
	'ogg-desc-link' => 'Over dit bestand',
	'ogg-oggThumb-version' => 'OggHandler vereist oggThumb versie $1 of hoger.',
	'ogg-oggThumb-failed' => 'oggThumb kon geen miniatuurafbeelding aanmaken.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author AVRS
 * @author Eirik
 * @author Harald Khan
 */
$messages['nn'] = array(
	'ogg-desc' => 'Gjer at Ogg Theora- og Ogg Vorbis-filer kan verta køyrte ved hjelp av JavaScript-avspelar.',
	'ogg-short-audio' => 'Ogg $1-lydfil, $2',
	'ogg-short-video' => 'Ogg $1-videofil, $2',
	'ogg-short-general' => 'Ogg $1-mediafil, $2',
	'ogg-long-audio' => '(Ogg $1-lydfil, lengd $2, $3)',
	'ogg-long-video' => 'Ogg $1-videofil, lengd $2, $4×$5 pikslar, $3',
	'ogg-long-multiplexed' => '(Samansett ogg lyd-/videofil, $1, lengd $2, $4×$5 pikslar, $3 til saman)',
	'ogg-long-general' => '(Ogg mediafil, lengd $2, $3)',
	'ogg-long-error' => '(Ugyldig ogg-fil: $1)',
	'ogg-play' => 'Spel av',
	'ogg-pause' => 'Pause',
	'ogg-stop' => 'Stopp',
	'ogg-play-video' => 'Spel av videofila',
	'ogg-play-sound' => 'Spel av lydfila',
	'ogg-no-player' => 'Beklagar, systemet ditt har ikkje støtta programvare til avspeling. Ver venleg og <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">last ned ein avspelar</a>.',
	'ogg-no-xiphqt' => 'Du ser ikkje ut til å ha XiphQT-komponenten til QuickTime. QuickTime kan ikkje spele av ogg-filer utan denne. Ver venleg og <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">last ned XiphQT</a> eller vel ein annan avspelar.',
	'ogg-player-videoElement' => 'Innebygd nettlesarstøtte',
	'ogg-player-oggPlugin' => 'Programtillegg for nettlesar',
	'ogg-player-thumbnail' => 'Berre stillbilete',
	'ogg-player-soundthumb' => 'Ingen avspelar',
	'ogg-player-selected' => '(valt)',
	'ogg-use-player' => 'Bruk avspelaren:',
	'ogg-more' => 'Meir...',
	'ogg-dismiss' => 'Lat att',
	'ogg-download' => 'Last ned fila',
	'ogg-desc-link' => 'Om denne fila',
);

/** Occitan (Occitan)
 * @author AVRS
 * @author Cedric31
 */
$messages['oc'] = array(
	'ogg-desc' => 'Supòrt pels fichièrs Ogg Theora e Vorbis, amb un lector Javascript',
	'ogg-short-audio' => 'Fichièr son Ogg $1, $2',
	'ogg-short-video' => 'Fichièr vidèo Ogg $1, $2',
	'ogg-short-general' => 'Fichièr mèdia Ogg $1, $2',
	'ogg-long-audio' => '(Fichièr son Ogg $1, durada $2, $3)',
	'ogg-long-video' => 'Fichièr vidèo Ogg $1, durada $2, $4×$5 pixèls, $3',
	'ogg-long-multiplexed' => '(Fichièr multiplexat àudio/vidèo Ogg, $1, durada $2, $4×$5 pixèls, $3)',
	'ogg-long-general' => '(Fichièr mèdia Ogg, durada $2, $3)',
	'ogg-long-error' => '(Fichièr Ogg invalid : $1)',
	'ogg-play' => 'Legir',
	'ogg-pause' => 'Pausa',
	'ogg-stop' => 'Stòp',
	'ogg-play-video' => 'Legir la vidèo',
	'ogg-play-sound' => 'Legir lo son',
	'ogg-no-player' => 'O planhèm, aparentament, vòstre sistèma a pas cap de lectors suportats. Installatz <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/oc">un dels lectors suportats</a>.',
	'ogg-no-xiphqt' => 'Aparentament avètz pas lo compausant XiphQT per Quicktime. Quicktime pòt pas legir los fiquièrs Ogg sens aqueste compausant. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/fr"> Telecargatz-lo XiphQT</a> o causissètz un autre lector.',
	'ogg-player-videoElement' => 'Supòrt del navigador natiu',
	'ogg-player-oggPlugin' => 'Plugin del navigador',
	'ogg-player-thumbnail' => 'Imatge estatic solament',
	'ogg-player-soundthumb' => 'Cap de lector',
	'ogg-player-selected' => '(seleccionat)',
	'ogg-use-player' => 'Utilizar lo lector :',
	'ogg-more' => 'Mai…',
	'ogg-dismiss' => 'Tampar',
	'ogg-download' => 'Telecargar lo fichièr',
	'ogg-desc-link' => "A prepaus d'aqueste fichièr",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'ogg-desc' => 'ଜାଭାସ୍କ୍ରିପ୍ଟ ପ୍ଲେଅର ସହିତ Ogg Theora ଓ Vorbis ଫାଇଲ ନିମନ୍ତେ ପରିଚାଳନାକାରୀ',
	'ogg-short-audio' => 'Ogg $1 ଶବ୍ଦ ଫାଇଲ, $2',
	'ogg-short-video' => 'Ogg $1 ଭିଡ଼ିଓ ଫାଇଲ, $2',
	'ogg-short-general' => 'Ogg $1 ମିଡ଼ିଆ ଫାଇଲ, $2',
	'ogg-long-audio' => 'Ogg $1 ଶବ୍ଦ ଫାଇଲ, ଲମ୍ବ $2, $3',
	'ogg-long-video' => 'Ogg $1 ଭିଡ଼ିଓ, ଲମ୍ବ $2, $4×$5 ପିକ୍ସେଲ, $3',
	'ogg-long-multiplexed' => 'Ogg ମଲଟିପ୍ଲେକ୍ସ audio/video ଫାଇଲ, $1, ଲମ୍ବ $2, $4×$5 ପିକ୍ସେଲ, ମୋଟ $3',
	'ogg-long-general' => 'Ogg ମିଡ଼ିଆ ଫାଇଲ, ଲମ୍ବ $2, $3',
	'ogg-long-error' => 'ଅଚଳ ogg ଫାଇଲ: $1',
	'ogg-play' => 'ଚଲାଇବା',
	'ogg-pause' => 'ବିରତି',
	'ogg-stop' => 'ବିରାମ',
	'ogg-play-video' => 'ଭିଡ଼ିଓ ଚଳାଇବେ',
	'ogg-play-sound' => 'ଶବ୍ଦ ଚଳାଇବେ',
	'ogg-no-player' => 'କ୍ଷମା କରିବେ, ଆପଣଙ୍କ କମ୍ପୁଟରରେ କୌଣସି ଭିଡ଼ିଓ ଚାଳନ ସଫ୍ଟୱେର ଇନଷ୍ଟଲ ହୋଇଥିବା ଜଣାଯାଉନାହିଁ ।
ଦୟାକରି <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ଏକ ପ୍ଲେଅର ଡାଉନଲୋଡ଼ କରିନିଅନ୍ତୁ</a> ।',
	'ogg-no-xiphqt' => 'ଆପଣଙ୍କ ପାଖରେ QuickTime ପାଇଁ XiphQT କମ୍ପୋନେଣ୍ଟ ନଥିବା ଭଳି ଲାଗୁଛି ।
ଏହି କମ୍ପୋନେଣ୍ଟ ବିନା QuickTime Ogg ଫାଇଲ ଚଳାଇପାରିବ ନାହିଁ । 
ଦୟାକରି <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT ଡାଉନଲୋଡ଼ କରନ୍ତୁ</a> ଅବା ଆଉ ଏକ ପ୍ଲେଅର ବାଛନ୍ତୁ ।',
	'ogg-player-videoElement' => 'ଆଞ୍ଚଳିକ ବ୍ରାଉଜର ସହଯୋଗ',
	'ogg-player-oggPlugin' => 'ବ୍ରାଉଜର ପ୍ଲଗଇନ',
	'ogg-player-thumbnail' => 'ଏବେଯାଏଁ କେବଳ ଛବି',
	'ogg-player-soundthumb' => 'ଚାଳନଯନ୍ତ୍ର ନାହିଁ',
	'ogg-player-selected' => '(ବଛା)',
	'ogg-use-player' => 'ଚାଳନ ଯନ୍ତ୍ର ବ୍ୟବହାର କରିବେ:',
	'ogg-more' => 'ଅଧିକ...',
	'ogg-dismiss' => 'ବନ୍ଦ କରିବେ',
	'ogg-download' => 'ଫାଇଲ ଡାଉନଲୋଡ଼',
	'ogg-desc-link' => 'ଏହି ଫାଇଲ ବାବଦରେ',
	'ogg-oggThumb-version' => 'OggHandler ନିମନ୍ତେ oggThumb ର $1 ତମ ବା ତାହା ପରର ସଂସ୍କରଣ ଲୋଡ଼ା',
	'ogg-oggThumb-failed' => 'oggThumb ସାନଦେଖଣା ତିଆରିବାରେ ବିଫଳ ହେଲା ।',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'ogg-more' => 'Фылдæр…',
	'ogg-download' => 'Файл æрбавгæн',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Gman124
 */
$messages['pa'] = array(
	'ogg-more' => 'ਹੋਰ...',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'ogg-short-general' => 'Ogg-$1-Mediafeil, $2',
	'ogg-more' => 'Mehr…',
	'ogg-dismiss' => 'Zumache',
	'ogg-download' => 'Feil runnerlaade',
	'ogg-desc-link' => 'Iwwer sell Feil',
);

/** Polish (Polski)
 * @author AVRS
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'ogg-desc' => 'Obsługa plików w formacie Ogg Theora i Vorbis z odtwarzaczem w JavaScripcie',
	'ogg-short-audio' => 'Plik dźwiękowy Ogg $1, $2',
	'ogg-short-video' => 'Plik wideo Ogg $1, $2',
	'ogg-short-general' => 'Plik multimedialny Ogg $1, $2',
	'ogg-long-audio' => '(plik dźwiękowy Ogg $1, długość $2, $3)',
	'ogg-long-video' => 'plik wideo Ogg $1, długość $2, rozdzielczość $4×$5, $3',
	'ogg-long-multiplexed' => '(plik audio/wideo Ogg, $1, długość $2, rozdzielczość $4×$5, ogółem $3)',
	'ogg-long-general' => '(plik multimedialny Ogg, długość $2, $3)',
	'ogg-long-error' => '(niepoprawny plik Ogg: $1)',
	'ogg-play' => 'Odtwórz',
	'ogg-pause' => 'Pauza',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Odtwórz wideo',
	'ogg-play-sound' => 'Odtwórz dźwięk',
	'ogg-no-player' => 'W Twoim systemie brak obsługiwanego programu odtwarzacza. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/pl">Pobierz i zainstaluj odtwarzacz</a>.',
	'ogg-no-xiphqt' => 'Brak komponentu XiphQT dla programu QuickTime. QuickTime nie może odtwarzać plików Ogg bez tego komponentu. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/pl">Pobierz XiphQT</a> lub użyj innego odtwarzacza.',
	'ogg-player-videoElement' => 'Obsługa bezpośrednio przez przeglądarkę',
	'ogg-player-oggPlugin' => 'Wtyczka do przeglądarki',
	'ogg-player-thumbnail' => 'Tylko nieruchomy obraz',
	'ogg-player-soundthumb' => 'Bez odtwarzacza',
	'ogg-player-selected' => '(wybrany)',
	'ogg-use-player' => 'Użyj odtwarzacza:',
	'ogg-more' => 'Więcej...',
	'ogg-dismiss' => 'Zamknij',
	'ogg-download' => 'Pobierz plik',
	'ogg-desc-link' => 'Właściwości pliku',
	'ogg-oggThumb-version' => 'OggHandler wymaga oggThumb w wersji $1 lub późniejszej.',
	'ogg-oggThumb-failed' => 'oggThumb nie udało się utworzyć miniaturki.',
);

/** Piedmontese (Piemontèis)
 * @author AVRS
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'ogg-desc' => 'Gestor për ij file Ogg Theora e Vorbis, con riprodotor JavaScript',
	'ogg-short-audio' => 'Registrassion Ogg $1, $2',
	'ogg-short-video' => 'Film Ogg $1, $2',
	'ogg-short-general' => 'Archivi Multimojen Ogg $1, $2',
	'ogg-long-audio' => "(Registrassion Ogg $1, ch'a dura $2, $3)",
	'ogg-long-video' => "Film Ogg $1, ch'a dura $2, formà $4×$5 px, $3",
	'ogg-long-multiplexed' => "(Archivi audio/video multiplessà Ogg, $1, ch'a dura $2, formà $4×$5 px, $3 an tut)",
	'ogg-long-general' => "(Archivi multimojen Ogg, ch'a dura $2, $3)",
	'ogg-long-error' => '(Archivi ogg nen bon: $1)',
	'ogg-play' => 'Smon',
	'ogg-pause' => 'Pàusa',
	'ogg-stop' => 'Fërma',
	'ogg-play-video' => 'Smon ël film',
	'ogg-play-sound' => 'Smon ël sonòr',
	'ogg-no-player' => "Darmagi, ma sò calcolator a smija ch'a l'abia pa gnun programa ch'a peul smon-e dj'archivi multi-mojen. Për piasì <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">ch'as në dëscaria un</a>.",
	'ogg-no-xiphqt' => "A smija che ansima a sò calcolator a-i sia nen ël component XiphQT dël programa QuickTime. QuickTime a-i la fa pa a dovré dj'archivi an forma Ogg files s'a l'ha nen ës component-lì. Për piasì <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">ch'as dëscaria XiphQT</a> ò pura ch'as sërna n'àotr programa për dovré j'archivi multi-mojen.",
	'ogg-player-videoElement' => 'Apògg browser nativ',
	'ogg-player-oggPlugin' => 'Spinòt (plugin) për browser',
	'ogg-player-thumbnail' => 'Mach na figurin-a fissa',
	'ogg-player-soundthumb' => 'Gnun programa për vardé/scoté',
	'ogg-player-selected' => '(selessionà)',
	'ogg-use-player' => 'Dovré ël programa:',
	'ogg-more' => 'Dë pì...',
	'ogg-dismiss' => 'sëré',
	'ogg-download' => "Dëscarié l'archivi",
	'ogg-desc-link' => "Rësgoard a st'archivi",
	'ogg-oggThumb-version' => "OggHandler a ciama la version $1 d'oggThumb o pi agiornà.",
	'ogg-oggThumb-failed' => "oggThumb a l'ha falì a creé la figurin-a.",
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'ogg-desc' => 'اوگ تھیورا تے ووربس فائل لئی ہینڈلر، جاواسکرپٹ پلیر نال',
	'ogg-short-audio' => 'اوگ $1 واز فائل, $2',
	'ogg-short-video' => 'اوگ $1 وڈیو فائل, $2',
	'ogg-short-general' => 'اوگ $1 میڈیا فائل, $2',
	'ogg-long-audio' => 'اوگ $1 واز فائل, لمبآی $، $32',
	'ogg-long-video' => 'اوگ $1 وڈیو فائل، لمبائی $2، $4×$5 ykvgS, $3',
	'ogg-long-multiplexed' => 'اوگ ملٹیپلیکسڈ آڈیو/وڈیو فائل، $1، لمبآئی $2، $4×$5 پکسلز, $3 اورآل',
	'ogg-long-general' => 'اوگ میڈیا فائل، لمبائی $2، $3',
	'ogg-long-error' => 'ناں منی جان والی اوگ فائل: $1',
	'ogg-play' => 'چلاؤ',
	'ogg-pause' => 'وقفہ',
	'ogg-stop' => 'رکو',
	'ogg-play-video' => 'وڈیو چلاؤ',
	'ogg-play-sound' => 'واز چلاؤ',
	'ogg-no-player' => 'معاف کرنا تواڈے پربندھ چ لگدا اے موسیقی چلان دا سوفٹویر نئیں۔ مہربانی کرکے <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">موسیقی چلان والا ڈاؤنلوڈ کرو۔</a>',
	'ogg-no-xiphqt' => 'تواڈے کول لگدا اے QuickTime دا پرزہ XiphQT کوئی نیں  QuickTime ایس توں بنا اوگ فائلاں نئیں چلاسکدا۔
مہربانی کرکے <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">download XiphQT</a> ڈاؤنلوڈ کرو یا ہور سوفٹویر چنو۔',
	'ogg-player-videoElement' => 'دیسی براؤزر سپورٹ',
	'ogg-player-oggPlugin' => 'براؤزر پلگ ان',
	'ogg-player-thumbnail' => 'صرف کذڑیاں مورتاں',
	'ogg-player-soundthumb' => 'کوئی چلان والا نغیں۔',
	'ogg-player-selected' => '(چنے)',
	'ogg-use-player' => 'چلان والا ورتو:',
	'ogg-more' => 'مزید۔۔۔',
	'ogg-dismiss' => 'بند کرو',
	'ogg-download' => 'فائل ڈاؤنلوڈ کرو',
	'ogg-desc-link' => 'ایس مورت بارے',
	'ogg-oggThumb-version' => 'اوگہینڈلر لئی اوگتھمب ورین $1 یا مگر آن والا۔',
	'ogg-oggThumb-failed' => 'اوگتھمب تھمبنیل بنان چ ماڑا',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'ogg-short-audio' => 'Ogg $1 غږيزه دوتنه، $2',
	'ogg-short-video' => 'Ogg $1 ويډيويي دوتنه، $2',
	'ogg-short-general' => 'Ogg $1 رسنيزه دوتنه، $2',
	'ogg-long-audio' => 'Ogg $1 غږيزه دوتنه، اوږدوالی $2، $3',
	'ogg-long-video' => 'Ogg $1 ويډيويي دوتنه، اوږدوالی $2، $4×$5 پېکسل، $3',
	'ogg-long-general' => 'Ogg رسنيزه دوتنه، اوږدوالی $2، $3',
	'ogg-long-error' => 'ناسمه ogg دوتنه: $1',
	'ogg-play' => 'غږول',
	'ogg-pause' => 'درول',
	'ogg-stop' => 'درول',
	'ogg-play-video' => 'ويډيو غږول',
	'ogg-play-sound' => 'غږ غږول',
	'ogg-player-videoElement' => 'د کورني کتنمل ملاتړ',
	'ogg-player-thumbnail' => 'يوازې ولاړ انځور',
	'ogg-player-soundthumb' => 'هېڅ کوم غږونکی نه',
	'ogg-player-selected' => '(ټاکل شوی)',
	'ogg-use-player' => 'غږونکی کارول:',
	'ogg-more' => 'نور...',
	'ogg-dismiss' => 'تړل',
	'ogg-download' => 'دوتنه ښکته کول',
	'ogg-desc-link' => 'د همدې دوتنې په اړه',
);

/** Portuguese (Português)
 * @author 555
 * @author AVRS
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'ogg-desc' => 'Manuseador para ficheiros Ogg Theora e Vorbis, com reprodutor JavaScript',
	'ogg-short-audio' => 'Áudio Ogg $1, $2',
	'ogg-short-video' => 'Vídeo Ogg $1, $2',
	'ogg-short-general' => 'Multimédia Ogg $1, $2',
	'ogg-long-audio' => '(Áudio Ogg $1, $2 de duração, $3)',
	'ogg-long-video' => 'Vídeo Ogg $1, $2 de duração, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(Áudio/vídeo Ogg multifacetado, $1, $2 de duração, $4×$5 pixels, $3 no todo)',
	'ogg-long-general' => '(Multimédia Ogg, $2 de duração, $3)',
	'ogg-long-error' => '(Ficheiro ogg inválido: $1)',
	'ogg-play' => 'Reproduzir',
	'ogg-pause' => 'Pausar',
	'ogg-stop' => 'Parar',
	'ogg-play-video' => 'Reproduzir vídeo',
	'ogg-play-sound' => 'Reproduzir som',
	'ogg-no-player' => "Desculpe, mas o seu sistema não aparenta ter qualquer leitor suportado. Por favor, faça o <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">''download'' de um leitor</a>.",
	'ogg-no-xiphqt' => "Aparentemente não tem o componente XiphQT do QuickTime.
O QuickTime não pode reproduzir ficheiros Ogg sem este componente.
Por favor, faça o <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">''download'' do XiphQT</a> ou escolha outro leitor.",
	'ogg-player-videoElement' => 'Suporte nativo do browser',
	'ogg-player-oggPlugin' => "''Plugin'' do browser",
	'ogg-player-thumbnail' => 'Apenas imagem estática',
	'ogg-player-soundthumb' => 'Sem player',
	'ogg-player-selected' => '(selecionado)',
	'ogg-use-player' => 'Usar player:',
	'ogg-more' => 'Mais...',
	'ogg-dismiss' => 'Fechar',
	'ogg-download' => 'Fazer download do ficheiro',
	'ogg-desc-link' => 'Sobre este ficheiro',
	'ogg-oggThumb-version' => 'O oggHandler requer o oggThumb versão $1 ou posterior.',
	'ogg-oggThumb-failed' => 'O oggThumb não conseguiu criar a miniatura.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author AVRS
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'ogg-desc' => 'Manipulador para arquivos Ogg Theora e Vorbis, com reprodutor JavaScript',
	'ogg-short-audio' => 'Arquivo de áudio Ogg $1, $2',
	'ogg-short-video' => 'Arquivo de vídeo Ogg $1, $2',
	'ogg-short-general' => 'Arquivo multimídia Ogg $1, $2',
	'ogg-long-audio' => '(Arquivo de Áudio Ogg $1, $2 de duração, $3)',
	'ogg-long-video' => 'Vídeo Ogg $1, $2 de duração, $4×$5 pixels, $3',
	'ogg-long-multiplexed' => '(Áudio/vídeo Ogg multifacetado, $1, $2 de duração, $4×$5 pixels, $3 no todo)',
	'ogg-long-general' => '(Multimídia Ogg, $2 de duração, $3)',
	'ogg-long-error' => '(Ficheiro ogg inválido: $1)',
	'ogg-play' => 'Reproduzir',
	'ogg-pause' => 'Pausar',
	'ogg-stop' => 'Parar',
	'ogg-play-video' => 'Reproduzir vídeo',
	'ogg-play-sound' => 'Reproduzir som',
	'ogg-no-player' => 'Lamentamos, mas seu sistema aparenta não ter um reprodutor suportado. Por gentileza, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">faça o download de um reprodutor</a>.',
	'ogg-no-xiphqt' => 'Aparentemente você não tem o componente XiphQT para QuickTime. Não será possível reproduzir arquivos Ogg pelo QuickTime sem tal componente. Por gentileza, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">faça o descarregamento do XiphQT</a> ou escolha outro reprodutor.',
	'ogg-player-videoElement' => 'Suporte interno do navegador',
	'ogg-player-oggPlugin' => 'Plugin do navegador',
	'ogg-player-thumbnail' => 'Apenas imagem estática',
	'ogg-player-soundthumb' => 'Sem reprodutor',
	'ogg-player-selected' => '(selecionado)',
	'ogg-use-player' => 'Usar reprodutor:',
	'ogg-more' => 'Mais...',
	'ogg-dismiss' => 'Fechar',
	'ogg-download' => 'Descarregar arquivo',
	'ogg-desc-link' => 'Sobre este arquivo',
	'ogg-oggThumb-version' => 'O oggHandler requer o oggThumb versão $1 ou posterior.',
	'ogg-oggThumb-failed' => 'O oggThumb não conseguiu criar a miniatura.',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'ogg-play' => 'Waqachiy',
	'ogg-pause' => "P'itiy",
	'ogg-stop' => 'Tukuchiy',
	'ogg-play-video' => 'Widyuta rikuchiy',
	'ogg-play-sound' => 'Ruqyayta uyarichiy',
	'ogg-player-soundthumb' => 'Manam waqachiqchu',
	'ogg-player-selected' => '(akllasqa)',
	'ogg-use-player' => "Kay waqachiqta llamk'achiy:",
	'ogg-more' => 'Astawan...',
	'ogg-dismiss' => "Wichq'ay",
	'ogg-download' => 'Willañiqita chaqnamuy',
	'ogg-desc-link' => 'Kay willañiqimanta',
);

/** Romanian (Română)
 * @author AVRS
 * @author Cin
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'ogg-short-audio' => 'Fișier de sunet ogg $1, $2',
	'ogg-short-video' => 'Fișier video ogg $1, $2',
	'ogg-short-general' => 'Fișier media ogg $1, $2',
	'ogg-long-audio' => '(Fișier de sunet ogg $1, lungime $2, $3)',
	'ogg-long-video' => 'Fișier video ogg $1, lungime $2, $4×$5 pixeli, $3',
	'ogg-long-multiplexed' => '(Fișier multiplexat audio/video ogg, $1, lungime $2, $4×$5 pixeli, $3)',
	'ogg-long-general' => '(Fișier media ogg, lungime $2, $3)',
	'ogg-long-error' => '(Fișier ogg incorect: $1)',
	'ogg-play' => 'Redă',
	'ogg-pause' => 'Pauză',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Redă video',
	'ogg-play-sound' => 'Redă sunet',
	'ogg-no-player' => 'Îmi pare rău, sistemul tău nu pare să aibă vreun program de redare suportat.
Te rog <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">descarcă un program de redare</a>.',
	'ogg-player-videoElement' => 'Navigator cu suport nativ',
	'ogg-player-oggPlugin' => 'Plugin-ul navigatorului',
	'ogg-player-thumbnail' => 'Doar imagine statică',
	'ogg-player-soundthumb' => 'Niciun program de redare',
	'ogg-player-selected' => '(selectat)',
	'ogg-use-player' => 'Folosește programul de redare:',
	'ogg-more' => 'Mai mult…',
	'ogg-dismiss' => 'Închide',
	'ogg-download' => 'Descărcare fișier',
	'ogg-desc-link' => 'Despre acest fișier',
	'ogg-oggThumb-version' => 'OggHandler necesită oggThumb, versiunea $1 sau mai recentă.',
	'ogg-oggThumb-failed' => 'oggThumb nu a reușit să creeze miniatura.',
);

/** Tarandíne (Tarandíne)
 * @author AVRS
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'ogg-desc' => "Gestore pe le file Ogg Theora e Vorbis, cu 'nu programme de riproduzione JavaScript",
	'ogg-short-audio' => 'File audie Ogg $1, $2',
	'ogg-short-video' => 'File video Ogg $1, $2',
	'ogg-short-general' => 'File media Ogg $1, $2',
	'ogg-long-audio' => '(File audie Ogg $1, lunghezze $2, $3)',
	'ogg-long-video' => 'File video Ogg $1, lunghezze $2, $4 x $5 pixel, $3',
	'ogg-long-multiplexed' => '(File multiplexed audie e video Ogg $1, lunghezze $2, $4 x $5 pixel, $3 in totale)',
	'ogg-long-general' => '(File media Ogg, lunghezze $2, $3)',
	'ogg-long-error' => '(Ogg file invalide: $1)',
	'ogg-play' => 'Riproduce',
	'ogg-pause' => 'Mitte in pause',
	'ogg-stop' => 'Stuèppe',
	'ogg-play-video' => "Riproduce 'u video",
	'ogg-play-sound' => 'Riproduce le suène',
	'ogg-no-player' => "Ne dispiace, 'u sisteme tune pare ca non ge tène nisciune softuare p'a riproduzione.<br />
Pe piacere, <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">scareche 'u reproduttore</a>.",
	'ogg-no-xiphqt' => "Non ge pare ca tìne 'u combonende XiphQT pu QuickTime.<br />
QuickTime non ge pò reproducere file Ogg senze stu combonende.<br />
Pe piacere <a href=\"http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download\">scareche XiphQT</a> o scacchie 'n'otre reproduttore.",
	'ogg-player-videoElement' => 'Supporte browser native',
	'ogg-player-oggPlugin' => "Plugin d'u browser",
	'ogg-player-thumbnail' => 'Angore sulamende immaggine',
	'ogg-player-soundthumb' => 'Nisciune reproduttore',
	'ogg-player-selected' => '(scacchiate)',
	'ogg-use-player' => "Ause 'u reproduttore:",
	'ogg-more' => 'De cchiù...',
	'ogg-dismiss' => 'Chiude',
	'ogg-download' => 'Scareche stu file',
	'ogg-desc-link' => "'Mbormaziune sus a stu file",
	'ogg-oggThumb-version' => "OggHandler richiede 'a versione $1 de oggThumb o una cchiù nove.",
	'ogg-oggThumb-failed' => 'oggThumb ha fallite sus a crejazione de le miniature.',
);

/** Russian (Русский)
 * @author AVRS
 * @author Ahonc
 * @author Dim Grits
 * @author Kaganer
 * @author Kv75
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'ogg-desc' => 'Обработчик файлов Ogg Theora и Vorbis с использованием JavaScript-проигрывателя',
	'ogg-short-audio' => 'Звуковой файл Ogg $1, $2',
	'ogg-short-video' => 'Видео-файл Ogg $1, $2',
	'ogg-short-general' => 'Медиа-файл Ogg $1, $2',
	'ogg-long-audio' => '(звуковой файл Ogg $1, длительность $2, $3)',
	'ogg-long-video' => 'видео-файл Ogg $1, длительность $2, $4×$5 {{PLURAL:$5|пиксель|пикселя|пикселей}}, $3',
	'ogg-long-multiplexed' => 'мультиплексный аудио/видео-файл Ogg, $1, длительность $2, $4×$5 {{PLURAL:$5|пиксель|пикселя|пикселей}}, $3 всего',
	'ogg-long-general' => '(медиа-файл Ogg, длительность $2, $3)',
	'ogg-long-error' => '(неправильный ogg-файл: $1)',
	'ogg-play' => 'Воспроизвести',
	'ogg-pause' => 'Пауза',
	'ogg-stop' => 'Остановить',
	'ogg-play-video' => 'Воспроизвести видео',
	'ogg-play-sound' => 'Воспроизвести звук',
	'ogg-no-player' => 'Извините, ваша система не имеет необходимого программного обеспечение для воспроизведения файлов. Пожалуйста, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">скачайте проигрыватель</a>.',
	'ogg-no-xiphqt' => 'Отсутствует компонент XiphQT для QuickTime. QuickTime не может воспроизвести файл Ogg без этого компонента. Пожалуйста, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">скачайте XiphQT</a> или выберите другой проигрыватель.',
	'ogg-player-videoElement' => 'Встроенная поддержка браузером',
	'ogg-player-oggPlugin' => 'Ogg модуль',
	'ogg-player-cortado' => 'Cortado (Java)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (ActiveX)',
	'ogg-player-quicktime-mozilla' => 'QuickTime',
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-kaffeine' => 'Kaffeine',
	'ogg-player-mplayerplug-in' => 'mplayerplug-in',
	'ogg-player-thumbnail' => 'Только неподвижное изображение',
	'ogg-player-soundthumb' => 'Нет проигрывателя',
	'ogg-player-selected' => '(выбран)',
	'ogg-use-player' => 'Использовать проигрыватель:',
	'ogg-more' => 'Больше…',
	'ogg-dismiss' => 'Скрыть',
	'ogg-download' => 'Загрузить файл',
	'ogg-desc-link' => 'Информация об этом файле',
	'ogg-oggThumb-version' => 'OggHandler требует oggThumb версии $1 или более поздней.',
	'ogg-oggThumb-failed' => 'oggThumb не удалось создать миниатюру.',
);

/** Rusyn (Русиньскый)
 * @author AVRS
 * @author Gazeb
 */
$messages['rue'] = array(
	'ogg-desc' => 'Обслуга файлів Ogg Theora і Vorbis з JavaScript-овым перегравачом',
	'ogg-short-audio' => 'Звуковый файл Ogg $1, $2',
	'ogg-short-video' => 'Відео-файл Ogg $1, $2',
	'ogg-short-general' => 'Файл Ogg $1, $2',
	'ogg-long-audio' => '(звуковый файл Ogg $1, довжка $2, $3)',
	'ogg-long-video' => 'відео-файл Ogg $1, довжка $2, $4×$5 пікселів, $3',
	'ogg-long-multiplexed' => '(мултіплексный аудіо/відео-файл ogg, $1, довжка $2, $4×$5 пікселів, $3 вшыткого)',
	'ogg-long-general' => '(медіа-файл Ogg, довжка $2, $3)',
	'ogg-long-error' => '(Неправилный ogg-файл: $1)',
	'ogg-play' => 'Заграти',
	'ogg-pause' => 'Пауза',
	'ogg-stop' => 'Заставити',
	'ogg-play-video' => 'Переграти відео',
	'ogg-play-sound' => 'Переграти звук',
	'ogg-no-player' => 'Ваша сістема асі не має жаден підпорованый перегравач. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">скачайте перегравач</a>.',
	'ogg-no-xiphqt' => 'Не маєте росшырїна XiphQT про QuickTime. QuickTime не може перегравати файлы без того росшырїня. <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Скачайте XiphQT</a> або звольте іншый перегравач.',
	'ogg-player-videoElement' => 'Вставляна підпора в переглядачу',
	'ogg-player-oggPlugin' => 'Модул до переглядача',
	'ogg-player-thumbnail' => 'Лем снимок нагляду',
	'ogg-player-soundthumb' => 'Жадный перегравач',
	'ogg-player-selected' => '(выбране)',
	'ogg-use-player' => 'Выберте перегравач:',
	'ogg-more' => 'Веце…',
	'ogg-dismiss' => 'Заперти',
	'ogg-download' => 'Скачати файл',
	'ogg-desc-link' => 'О файлі',
	'ogg-oggThumb-version' => 'OggHandler потребує oggThumb верзії $1 або новшый.',
	'ogg-oggThumb-failed' => 'oggThumb не быв годен створити нагляд.',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'ogg-play' => 'प्रयोग',
	'ogg-pause' => 'विराम',
	'ogg-stop' => 'स्थापयति',
	'ogg-dismiss' => 'निबिड',
);

/** Sakha (Саха тыла)
 * @author AVRS
 * @author HalanTul
 * @author Kyraha
 */
$messages['sah'] = array(
	'ogg-desc' => 'Обработчик файлов Ogg Theora и Vorbis с использованием JavaScript-проигрывателя',
	'ogg-short-audio' => 'Звуковой файл Ogg $1, $2',
	'ogg-short-video' => 'Видео-файл Ogg $1, $2',
	'ogg-short-general' => 'Медиа-файл Ogg $1, $2',
	'ogg-long-audio' => '(звуковой файл Ogg $1, уһуна $2, $3)',
	'ogg-long-video' => 'видео-файл Ogg $1, уһуна $2, $4×$5 пииксэллээх, $3',
	'ogg-long-multiplexed' => '(мультиплексный аудио/видео-файл Ogg, $1, уһуна $2, $4×$5 пииксэллээх, барыта $3)',
	'ogg-long-general' => '(медиа-файл Ogg, уһуна $2, $3)',
	'ogg-long-error' => '(сыыһа ogg-файл: $1)',
	'ogg-play' => 'Оонньот',
	'ogg-pause' => 'Тохтото түс',
	'ogg-stop' => 'Тохтот',
	'ogg-play-video' => 'Көрдөр',
	'ogg-play-sound' => 'Иһитиннэр',
	'ogg-no-player' => 'Хомойуох иһин эн систиэмэҕэр иһитиннэрэр/көрдөрөр анал бырагырааммалар суохтар эбит. Бука диэн, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">плееры хачайдан</a>.',
	'ogg-no-xiphqt' => 'QuickTime маннык тэрээбэтэ: XiphQT суох эбит. Онон QuickTime бу Ogg билэни (файлы) оонньотор кыаҕа суох. Бука диэн, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download"> XiphQT хачайдан</a> эбэтэр атын плееры тал.',
	'ogg-player-videoElement' => 'Браузер бэйэтин өйөөһүнэ',
	'ogg-player-oggPlugin' => 'Браузер плагина',
	'ogg-player-thumbnail' => 'Хамсаабат ойууну эрэ',
	'ogg-player-soundthumb' => 'Плеер суох',
	'ogg-player-selected' => '(талыллыбыт)',
	'ogg-use-player' => 'Бу плееры туттарга:',
	'ogg-more' => 'Өссө...',
	'ogg-dismiss' => 'Кистээ/сап',
	'ogg-download' => 'Билэни хачайдаа',
	'ogg-desc-link' => 'Бу билэ туһунан',
	'ogg-oggThumb-version' => 'OggHandler oggThumb $1 эбэтэр ордук версиятын наадыйар',
	'ogg-oggThumb-failed' => 'oggThumb миниатюраны кыайан оҥорбото.',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'ogg-dismiss' => 'Chiùi',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 */
$messages['sgs'] = array(
	'ogg-play' => 'Gruotė',
	'ogg-pause' => 'Pauzė',
	'ogg-stop' => 'Sostabdītė',
	'ogg-play-video' => 'Gruotė video',
	'ogg-play-sound' => 'Gruotė garsa',
	'ogg-download' => 'Atsėsiōstė faila',
);

/** Sinhala (සිංහල)
 * @author AVRS
 * @author Budhajeewa
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'ogg-desc' => 'Ogg Theora සහ Vorbis ගොනු සඳහා හසුරුවනය, ජාවාස්ක්‍රිප්ට් ප්ලේයර් සමඟ',
	'ogg-short-audio' => 'Ogg $1 ශ්‍රව්‍ය ගොනුව, $2',
	'ogg-short-video' => 'Ogg $1 දෘශ්‍ය ගොනුව, $2',
	'ogg-short-general' => 'Ogg $1 මාධ්‍ය ගොනුව, $2',
	'ogg-long-audio' => '(Ogg $1 ශ්‍රව්‍ය ගොනුව, ප්‍රවර්තනය $2, $3)',
	'ogg-long-video' => 'Ogg $1 දෘශ්‍ය ගොනුව, ප්‍රවර්තනය $2, $4×$5 පික්සල්, $3',
	'ogg-long-multiplexed' => '(Ogg බහුපථකාරක ශ්‍රව්‍ය/දෘශ්‍ය ගොනුව, $1, ප්‍රවර්තනය $2, $4×$5 පික්සල්, $3 සමස්ත)',
	'ogg-long-general' => '(Ogg මාධ්‍ය ගොනුව, ප්‍රවර්තනය $2, $3)',
	'ogg-long-error' => '(අනීතික ogg ගොනුව: $1)',
	'ogg-play' => 'වාදනය කරන්න',
	'ogg-pause' => 'විරාම කරන්න',
	'ogg-stop' => 'නවතන්න',
	'ogg-play-video' => 'දෘශ්‍ය වාදනය කරන්න',
	'ogg-play-sound' => 'ශබ්දය වාදනය කරන්න',
	'ogg-no-player' => 'කණගාටුයි, කිසිම සහායක ධාවක මෘදුකාංගයක් ඔබ පද්ධතිය සතුව ඇති බවක් නොපෙනේ.
කරුණාකර <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ධාවකයක් බා ගන්න</a>.',
	'ogg-no-xiphqt' => 'QuickTime සඳහා XiphQT සංරචකය ඔබ සතුව ඇති බවක් නොපෙනේ.
මෙම සංරචකය නොමැතිව Ogg ගොනු ධාවනය කිරීම  QuickTime විසින් සිදුකල නොහැක.
කරුණාකර <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download"> XiphQT බා ගන්න</a> නැතහොත් වෙනත් ධාවකයක් තෝරාගන්න.',
	'ogg-player-videoElement' => 'පියවි පරික්සක සහය',
	'ogg-player-oggPlugin' => 'බ්‍රවුසර ප්ලගිත',
	'ogg-player-cortado' => 'Cortado (ජාවා)',
	'ogg-player-thumbnail' => 'නිශ්චල රූප පමණි',
	'ogg-player-soundthumb' => 'ධාවකයක් නොමැත',
	'ogg-player-selected' => '(තෝරාගෙන)',
	'ogg-use-player' => 'ධාවකය භාවිතා කරන්න:',
	'ogg-more' => 'ඉතිරිය…',
	'ogg-dismiss' => 'වසන්න',
	'ogg-download' => 'ගොනුව බා ගන්න',
	'ogg-desc-link' => 'මෙම ගොනුව පිළිබඳ',
	'ogg-oggThumb-version' => 'OggHandler සඳහා oggThumb $1 සංස්කරණය හෝ අලුත් එකක් අවැසිය.',
	'ogg-oggThumb-failed' => 'තම්බ්නේලය තැනුමට oggThumb අසමත්විය.',
);

/** Slovak (Slovenčina)
 * @author AVRS
 * @author Helix84
 * @author Jkjk
 */
$messages['sk'] = array(
	'ogg-desc' => 'Obsluha súborov Ogg Theora a Vorbis s JavaScriptovým prehrávačom',
	'ogg-short-audio' => 'Zvukový súbor ogg $1, $2',
	'ogg-short-video' => 'Video súbor ogg $1, $2',
	'ogg-short-general' => 'Multimediálny súbor ogg $1, $2',
	'ogg-long-audio' => '(Zvukový súbor ogg $1, dĺžka $2, $3)',
	'ogg-long-video' => 'Video súbor ogg $1, dĺžka $2, $4×$5 pixelov, $3',
	'ogg-long-multiplexed' => '(Multiplexovaný zvukový/video súbor ogg, $1, dĺžka $2, $4×$5 pixelov, $3 celkom)',
	'ogg-long-general' => '(Multimediálny súbor ogg, dĺžka $2, $3)',
	'ogg-long-error' => '(Neplatný súbor ogg: $1)',
	'ogg-play' => 'Prehrať',
	'ogg-pause' => 'Pozastaviť',
	'ogg-stop' => 'Zastaviť',
	'ogg-play-video' => 'Prehrať video',
	'ogg-play-sound' => 'Prehrať zvuk',
	'ogg-no-player' => 'Prepáčte, zdá sa, že váš systém nemá žiadny podporovaný softvér na prehrávanie. Prosím, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">stiahnite si prehrávač</a>.',
	'ogg-no-xiphqt' => 'Zdá sa, že nemáte komponent QuickTime XiphQT. QuickTime nedokáže prehrávať ogg súbory bez tohto komponentu. Prosím, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">stiahnite si XiphQT</a> alebo si vyberte iný prehrávač.',
	'ogg-player-videoElement' => 'Natívna podpora prehliadača',
	'ogg-player-oggPlugin' => 'Zásuvný modul prehliadača',
	'ogg-player-thumbnail' => 'iba nepohyblivý obraz',
	'ogg-player-soundthumb' => 'žiadny prehrávač',
	'ogg-player-selected' => '(vybraný)',
	'ogg-use-player' => 'Použiť prehrávač:',
	'ogg-more' => 'viac...',
	'ogg-dismiss' => 'Zatvoriť',
	'ogg-download' => 'Stiahnuť súbor',
	'ogg-desc-link' => 'O tomto súbore',
	'ogg-oggThumb-version' => 'OggHandler vyžaduje verziu oggThumbu $1 alebo novšiu.',
	'ogg-oggThumb-failed' => 'oggThumbu sa neporarilo vytvoriť obraz.',
);

/** Slovenian (Slovenščina)
 * @author AVRS
 * @author Dbc334
 */
$messages['sl'] = array(
	'ogg-desc' => 'Upravljavec datotek Ogg Theora in Vorbis, s predvajalnikom JavaScript',
	'ogg-short-audio' => 'Zvočna datoteka Ogg $1, $2',
	'ogg-short-video' => 'Videodatoteka Ogg $1, $2',
	'ogg-short-general' => 'Predstavnostna datoteka Ogg $1, $2',
	'ogg-long-audio' => '(zvočna datoteka ogg $1, dolžine $2, $3)',
	'ogg-long-video' => 'videodatoteka ogg $1, dolžine $2, $4 × $5 pik, $3',
	'ogg-long-multiplexed' => '(multipleksna zvočna/videodatoteka ogg, $1, dolžina $2, $4 × $5 pik, $3 skupno)',
	'ogg-long-general' => '(predstavnostna datoteka ogg, dolžina $2, $3)',
	'ogg-long-error' => '(Neveljavna datoteka ogg: $1)',
	'ogg-play' => 'Predvajaj',
	'ogg-pause' => 'Pavza',
	'ogg-stop' => 'Ustavi',
	'ogg-play-video' => 'Predvajaj video',
	'ogg-play-sound' => 'Predvajaj zvok',
	'ogg-no-player' => 'Oprostite, kaže da vaš sistem nima nameščenega programja nobenega podprtega predvajalnika.
Prosimo, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">prenesite predvajalnik</a>.',
	'ogg-no-xiphqt' => 'Kot kaže, nimate komponente XiphQT za QuickTime.
QuickTime ne more oredvajati datotek Ogg brez te komponente.
Prosimo, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">prenesite XiphQT</a> ali izberite drug predvajalnik.',
	'ogg-player-videoElement' => 'Vgrajena podpora brskalnika',
	'ogg-player-oggPlugin' => 'Vtičnik brskalnika',
	'ogg-player-thumbnail' => 'Samo stoječa slika',
	'ogg-player-soundthumb' => 'Brez predvajalnika',
	'ogg-player-selected' => '(izbrano)',
	'ogg-use-player' => 'Uporabi predvajalnik:',
	'ogg-more' => 'Več ...',
	'ogg-dismiss' => 'Zapri',
	'ogg-download' => 'Prenesi datoteko',
	'ogg-desc-link' => 'O datoteki',
	'ogg-oggThumb-version' => 'OggHandler potrebuje oggThumb različice $1 ali novejše.',
	'ogg-oggThumb-failed' => 'oggThumb ni uspel ustvariti predogledne sličice.',
);

/** Albanian (Shqip)
 * @author AVRS
 * @author Dori
 * @author Olsi
 */
$messages['sq'] = array(
	'ogg-desc' => 'Mbajtës për Ogg Theora dhe skeda Vorbis, me luajtës JavaScript',
	'ogg-short-audio' => 'Skedë zanore Ogg $1, $2',
	'ogg-short-video' => 'Skedë pamore Ogg $1, $2',
	'ogg-short-general' => 'Skedë mediatike Ogg $1, $2',
	'ogg-long-audio' => '(Skedë zanore Ogg $1, kohëzgjatja $2, $3)',
	'ogg-long-video' => 'Skedë pamore Ogg $1, kohëzgjatja $2, $4×$5 pixel, $3',
	'ogg-long-multiplexed' => 'Skedë ogg audio/video, $1, gjatësia $2, $4×$5 piksel, $3 gjithsej',
	'ogg-long-general' => 'Skedë Ogg, kohëzgjatja $2, $3',
	'ogg-long-error' => 'Skedë ogg e pavlefshme: $1',
	'ogg-play' => 'Fillo',
	'ogg-pause' => 'Pusho',
	'ogg-stop' => 'Ndalo',
	'ogg-play-video' => 'Fillo videon',
	'ogg-play-sound' => 'Fillo zërin',
	'ogg-no-player' => 'Ju kërkojmë ndjesë por sistemi juaj nuk ka mundësi për të kryer këtë veprim. Mund të <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">shkarkoni një mjet</a> tjetër.',
	'ogg-no-xiphqt' => 'Ju nuk duket të keni komponentin XiphQT për QuickTime.
QuickTime nuk mund të luajë skeda Ogg pa këtë komponent.
Ju lutemi <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">shkarkoni XiphQT</a> ose zgjidhni një luajtës tjetër.',
	'ogg-player-videoElement' => 'Mbështetje amtare shfletuesi',
	'ogg-player-oggPlugin' => 'Plugin shfletuesi',
	'ogg-player-thumbnail' => 'Ende vetëm figurë',
	'ogg-player-soundthumb' => 'Nuk ka luajtës',
	'ogg-player-selected' => '(përzgjedhur)',
	'ogg-use-player' => 'Përdorni luajtës:',
	'ogg-more' => 'Më shumë...',
	'ogg-dismiss' => 'Mbylle',
	'ogg-download' => 'Shkarko skedën',
	'ogg-desc-link' => 'Rreth kësaj skede',
	'ogg-oggThumb-version' => 'OggHandler kërkon versionin oggThumb $1 ose më të vonshëm.',
	'ogg-oggThumb-failed' => 'oggThumb dështoi të krijojë parapamjen.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author AVRS
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'ogg-desc' => 'Руководилац OGG теора и ворбис датотекама с јаваскрипт плејером',
	'ogg-short-audio' => 'Ogg $1 звучна датотека, $2',
	'ogg-short-video' => 'Ogg $1 видео-снимак, $2.',
	'ogg-short-general' => 'Ogg $1 медијска датотека, $2.',
	'ogg-long-audio' => 'Ogg $1 звучна датотека, трајање $2, $3',
	'ogg-long-video' => 'Ogg $1 видео-снимак, трајање $2, $4 × $5 пиксела, $3',
	'ogg-long-multiplexed' => 'Мултиплексирани .ogg аудио/видео снимак, $1, трајање $2, $4 × $5 пиксела, $3',
	'ogg-long-general' => 'Ogg медијска датотека, трајање $2, $3.',
	'ogg-long-error' => '(неисправна .ogg датотека: $1)',
	'ogg-play' => 'Пусти',
	'ogg-pause' => 'Паузирај',
	'ogg-stop' => 'Заустави',
	'ogg-play-video' => 'Пусти видео-снимак',
	'ogg-play-sound' => 'Пусти звучни снимак',
	'ogg-no-player' => 'Изгледа да немате инсталиран никакав програм за пуштање медијских датотека.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Овде преузмите програм за ту намену</a>.',
	'ogg-no-xiphqt' => 'Изгледа да немате инсталиран део XiphQT за Квиктајм.
Квиктајм не може да пусти .ogg датотеке без ове компоненте.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Преузмите XiphQT</a> или изаберите други плејер.',
	'ogg-player-videoElement' => 'Подршка од прегледача',
	'ogg-player-oggPlugin' => 'Додатак за прегледач',
	'ogg-player-cortado' => 'Кортадо (Јава)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (Активикс)',
	'ogg-player-quicktime-mozilla' => 'Квиктајм',
	'ogg-player-quicktime-activex' => 'Квиктајм (Активикс)',
	'ogg-player-totem' => 'Тотем',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-kaffeine' => 'Кафин',
	'ogg-player-mplayerplug-in' => 'mplayerplug-in',
	'ogg-player-thumbnail' => 'још увек само слика',
	'ogg-player-soundthumb' => 'нема плејера',
	'ogg-player-selected' => '(изабрано)',
	'ogg-use-player' => 'Користи плејер:',
	'ogg-more' => 'Више...',
	'ogg-dismiss' => 'Затвори',
	'ogg-download' => 'Преузми датотеку',
	'ogg-desc-link' => 'Подаци о овој датотеци',
	'ogg-oggThumb-version' => 'OggHandler захтева oggThumb – верзију $1 или новију.',
	'ogg-oggThumb-failed' => 'oggThumb не може да направи минијатуру.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author AVRS
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'ogg-desc' => 'Rukovaoc ogg Teora i Vorbis fajlovima sa javaskript plejerom',
	'ogg-short-audio' => 'Ogg $1 zvučni fajl, $2.',
	'ogg-short-video' => 'Ogg $1 video fajl, $2.',
	'ogg-short-general' => 'Ogg $1 medijski fajl, $2.',
	'ogg-long-audio' => '(Ogg $1 zvučni fajl, dužina $2, $3.)',
	'ogg-long-video' => 'Ogg $1 video fajl, dužina $2, $4×$5 piksela, $3.',
	'ogg-long-multiplexed' => '(Ogg multipleksovani audio/video fajl, $1, dužina $2, $4×$5 piksela, $3 ukupno.)',
	'ogg-long-general' => '(Ogg medijski fajl, dužina $2, $3.)',
	'ogg-long-error' => '(Loš ogg fajl: $1.)',
	'ogg-play' => 'Pusti',
	'ogg-pause' => 'Pauza',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Pusti video',
	'ogg-play-sound' => 'Pusti zvuk',
	'ogg-no-player' => 'Izgleda da nemate instaliran nikakav program za puštanje medijskih datoteka.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Ovde preuzmite program za tu namenu</a>.',
	'ogg-no-xiphqt' => 'Izgleda da nemate instaliran deo XiphQT za Kviktajm.
Kviktajm ne može da pusti .ogg datoteke bez ove komponente.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Preuzmite XiphQT</a> ili izaberite drugi plejer.',
	'ogg-player-videoElement' => 'Ugrađena podrška u brauzer',
	'ogg-player-oggPlugin' => 'Plagin za brauzer',
	'ogg-player-cortado' => 'Kortado (Java)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (Aktiviks)',
	'ogg-player-quicktime-mozilla' => 'Kviktajm',
	'ogg-player-quicktime-activex' => 'Kviktajm (Aktiviks)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-kaffeine' => 'Kafin',
	'ogg-player-mplayerplug-in' => 'mplayerplug-in',
	'ogg-player-thumbnail' => 'još uvek samo slika',
	'ogg-player-soundthumb' => 'nema plejera',
	'ogg-player-selected' => '(označeno)',
	'ogg-use-player' => 'Koristi plejer:',
	'ogg-more' => 'Više...',
	'ogg-dismiss' => 'Zatvori',
	'ogg-download' => 'Preuzmi datoteku',
	'ogg-desc-link' => 'O ovom fajlu',
	'ogg-oggThumb-version' => 'OggHandler zahteva oggThumb – verziju $1 ili noviju.',
	'ogg-oggThumb-failed' => 'oggThumb ne može da napravi minijaturu.',
);

/** Seeltersk (Seeltersk)
 * @author AVRS
 * @author Pyt
 */
$messages['stq'] = array(
	'ogg-desc' => 'Stjuurengsprogramm foar Ogg Theora- un Vorbis-Doatäie, inklusive n JavaScript-Ouspielsoftware',
	'ogg-short-audio' => 'Ogg-$1-Audiodoatäi, $2',
	'ogg-short-video' => 'Ogg-$1-Videodoatäi, $2',
	'ogg-short-general' => 'Ogg-$1-Mediadoatäi, $2',
	'ogg-long-audio' => '(Ogg-$1-Audiodoatäi, Loangte: $2, $3)',
	'ogg-long-video' => 'Ogg-$1-Videodoatäi, Loangte: $2, $4×$5 Pixel, $3',
	'ogg-long-multiplexed' => '(Ogg-Audio-/Video-Doatäi, $1, Loangte: $2, $4×$5 Pixel, $3)',
	'ogg-long-general' => '(Ogg-Mediadoatäi, Loangte: $2, $3)',
	'ogg-long-error' => '(Uungultige Ogg-Doatäi: $1)',
	'ogg-play' => 'Start',
	'ogg-pause' => 'Pause',
	'ogg-stop' => 'Stop',
	'ogg-play-video' => 'Video ouspielje',
	'ogg-play-sound' => 'Audio ouspielje',
	'ogg-no-player' => 'Dien System skient uur neen Ouspielsoftware tou ferföigjen. Installier <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ne Ouspielsoftware</a>.',
	'ogg-no-xiphqt' => 'Dien System skient nit uur ju XiphQT-Komponente foar QuickTime tou ferföigjen. QuickTime kon sunner disse Komponente neen Ogg-Doatäie ouspielje. 
Dou <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">leede XiphQT</a> of wääl ne uur Ouspielsoftware.',
	'ogg-player-videoElement' => 'Anweesende Browser-Unnerstutsenge',
	'ogg-player-oggPlugin' => 'Browser-Plugin',
	'ogg-player-thumbnail' => 'Wies Foarbekiekbielde',
	'ogg-player-soundthumb' => 'Naan Player',
	'ogg-player-selected' => '(uutwääld)',
	'ogg-use-player' => 'Ouspielsoftware:',
	'ogg-more' => 'Optione …',
	'ogg-dismiss' => 'Sluute',
	'ogg-download' => 'Doatäi spiekerje',
	'ogg-desc-link' => 'Uur disse Doatäi',
);

/** Sundanese (Basa Sunda)
 * @author AVRS
 * @author Kandar
 */
$messages['su'] = array(
	'ogg-short-audio' => 'Koropak sora $1 ogg, $2',
	'ogg-short-video' => 'Koropak vidéo $1 ogg, $2',
	'ogg-short-general' => 'Koropak média $1 ogg, $2',
	'ogg-long-audio' => '(Koropak sora $1 ogg, lilana $2, $3)',
	'ogg-long-video' => 'Koropak vidéo $1 ogg, lilana $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Koropak sora/vidéo ogg multipléks, $1, lilana $2, $4×$5 piksel, $3 gembleng)',
	'ogg-long-general' => '(Koropak média ogg, lilana $2, $3)',
	'ogg-long-error' => '(Koropak ogg teu valid: $1)',
	'ogg-play' => 'Setél',
	'ogg-pause' => 'Eureun',
	'ogg-stop' => 'Anggeusan',
	'ogg-play-video' => 'Setél vidéo',
	'ogg-play-sound' => 'Setél sora',
	'ogg-player-oggPlugin' => 'Plugin ogg',
	'ogg-player-thumbnail' => 'Gambar statis wungkul',
	'ogg-player-selected' => '(pinilih)',
	'ogg-use-player' => 'Paké panyetél:',
	'ogg-more' => 'Lianna...',
	'ogg-dismiss' => 'Tutup',
	'ogg-download' => 'Bedol',
	'ogg-desc-link' => 'Ngeunaan ieu koropak',
);

/** Swedish (Svenska)
 * @author AVRS
 * @author Ainali
 * @author Jon Harald Søby
 * @author Lejonel
 * @author Rotsee
 * @author Skalman
 */
$messages['sv'] = array(
	'ogg-desc' => 'Stöder filtyperna Ogg Theora och Ogg Vorbis med en JavaScript-baserad mediaspelare',
	'ogg-short-audio' => 'Ogg $1 ljudfil, $2',
	'ogg-short-video' => 'Ogg $1 videofil, $2',
	'ogg-short-general' => 'Ogg $1 mediafil, $2',
	'ogg-long-audio' => '(Ogg $1 ljudfil, längd $2, $3)',
	'ogg-long-video' => 'Ogg $1 videofil, längd $2, $4×$5 pixel, $3',
	'ogg-long-multiplexed' => '(Ogg multiplexad ljud/video-fil, $1, längd $2, $4×$5 pixel, $3 totalt)',
	'ogg-long-general' => '(Ogg mediafil, längd $2, $3)',
	'ogg-long-error' => '(Felaktig ogg-fil: $1)',
	'ogg-play' => 'Spela upp',
	'ogg-pause' => 'Pausa',
	'ogg-stop' => 'Stoppa',
	'ogg-play-video' => 'Spela upp video',
	'ogg-play-sound' => 'Spela upp ljud',
	'ogg-no-player' => 'Tyvärr verkar det inte finnas någon mediaspelare som stöds installerad i ditt system. Det finns <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">spelare att ladda ner</a>.',
	'ogg-no-xiphqt' => 'Du verkar inte ha XiphQT-komponenten för QuickTime. Utan den kan inte QuickTime spela upp ogg-filer.Du kan <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ladda ner XiphQT</a> eller välja någon annan spelare.',
	'ogg-player-videoElement' => '<video>-element',
	'ogg-player-oggPlugin' => 'Ogg-plugin',
	'ogg-player-thumbnail' => 'Endast stillbilder',
	'ogg-player-soundthumb' => 'Ingen spelare',
	'ogg-player-selected' => '(vald)',
	'ogg-use-player' => 'Välj mediaspelare:',
	'ogg-more' => 'Mer...',
	'ogg-dismiss' => 'Stäng',
	'ogg-download' => 'Ladda ner filen',
	'ogg-desc-link' => 'Om filen',
	'ogg-oggThumb-version' => 'OggHandler kräver oggThumb version $1 eller senare.',
	'ogg-oggThumb-failed' => 'oggThumb misslyckades med att skapa miniatyrbilden.',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'ogg-dismiss' => 'Funga',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 * @author Sodabottle
 * @author TRYPPN
 */
$messages['ta'] = array(
	'ogg-short-audio' => 'Ogg  $1  ஒலி கோப்பு ,$2',
	'ogg-short-video' => 'Ogg  $1  வீடியோ கோப்பு$2',
	'ogg-short-general' => 'Ogg  $1  ஊடக கோப்பு$2',
	'ogg-long-audio' => 'Ogg  $1  ஒலி கோப்பு, நீளம்  $2 ,$3',
	'ogg-long-video' => 'Ogg  $1  வீடியோ கோப்பு, நீளம்  $2 ,  $4 × $5  பிக்சல்கள்,$3',
	'ogg-long-general' => 'Ogg  ஊடக கோப்பு நீளம்   $2 ,$3',
	'ogg-long-error' => 'செல்லாத ogg கோப்பு:$1',
	'ogg-play' => 'ஓட்டு',
	'ogg-pause' => 'இடைநிறுத்து',
	'ogg-stop' => 'நிறுத்து',
	'ogg-play-video' => 'காணொளியை ஓடவிடு',
	'ogg-play-sound' => 'ஒலி ஓடவிடு',
	'ogg-no-player' => 'மன்னிக்கவும், உங்கள் கணினியில் எந்த ஒரு ஆதரவு ஓடல்  மென்பொருளும் இருப்பதாக தெரியவில்லை.
தயவுசெய்து <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ஒரு ஓடல்  மென்பொருளை தகவலிறக்கம் செய்யவும்</a>.',
	'ogg-player-videoElement' => 'சொந்த உலாவி ஆதரவு',
	'ogg-player-oggPlugin' => 'மேய்வான் செருகுநிரல்',
	'ogg-player-thumbnail' => 'நிழற்படம் மட்டும்',
	'ogg-player-soundthumb' => 'ஓடல் மென்பொருள் இல்லை',
	'ogg-player-selected' => '(தேர்ந்தெடுத்தது)',
	'ogg-use-player' => 'ஓடல் மென்பொருள் பயன்படுத்தவும்:',
	'ogg-more' => 'மேலும்...',
	'ogg-dismiss' => 'மூடுக',
	'ogg-download' => 'கோப்பை பதிவிறக்கம் செய்',
	'ogg-desc-link' => 'இந்த கோப்பைப் பற்றி',
	'ogg-oggThumb-version' => 'OggHandler ஆனது oggThumb பதிப்பு  $1 அதற்கு மேல் உள்ளவற்றை வேண்டுகிறது.',
	'ogg-oggThumb-failed' => 'இந்த சிறுஉருவம் உருவாக்க oggThumb தோல்வியுற்றது.',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'ogg-short-audio' => 'Ogg $1 శ్రావ్యక ఫైలు, $2',
	'ogg-short-video' => 'Ogg $1 వీడియో ఫైలు, $2',
	'ogg-short-general' => 'Ogg $1 మీడియా ఫైలు, $2',
	'ogg-long-audio' => '(Ogg $1 శ్రవణ ఫైలు, నిడివి $2, $3)',
	'ogg-long-video' => 'Ogg $1 వీడియో ఫైలు, నిడివి $2, $4×$5 పిక్సెళ్ళు, $3',
	'ogg-long-multiplexed' => '(ఓగ్ మల్టిప్లెక్సుడ్ శ్రవణ/దృశ్యక ఫైలు, $1, నిడివి $2, $4×$5 పిక్సెళ్ళు, $3 మొత్తం)',
	'ogg-long-general' => '(Ogg మీడియా ఫైలు, నిడివి $2, $3)',
	'ogg-long-error' => '(తప్పుడు ogg ఫైలు: $1)',
	'ogg-play' => 'ఆడించు',
	'ogg-pause' => 'ఆపు',
	'ogg-stop' => 'ఆపివేయి',
	'ogg-play-video' => 'వీడియోని ఆడించు',
	'ogg-play-sound' => 'శబ్ధాన్ని వినిపించు',
	'ogg-player-videoElement' => 'విహారిణిలో సహజాత తోడ్పాటు',
	'ogg-player-oggPlugin' => 'బ్రౌజరు ప్లగిన్',
	'ogg-player-thumbnail' => 'నిచ్చల చిత్రాలు మాత్రమే',
	'ogg-player-soundthumb' => 'ప్లేయర్ లేదు',
	'ogg-player-selected' => '(ఎంచుకున్నారు)',
	'ogg-use-player' => 'ప్లేయర్ ఉపయోగించు:',
	'ogg-more' => 'మరిన్ని...',
	'ogg-dismiss' => 'మూసివేయి',
	'ogg-download' => 'ఫైలుని దిగుమతి చేసుకోండి',
	'ogg-desc-link' => 'ఈ ఫైలు గురించి',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author AVRS
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'ogg-desc' => 'Ба дастгирандае барои парвандаҳои  Ogg Theora ва Vorbis, бо пахшкунандаи JavaScript',
	'ogg-short-audio' => 'Ogg $1 парвандаи савтӣ, $2',
	'ogg-short-video' => 'Ogg $1 парвандаи наворӣ, $2',
	'ogg-short-general' => 'Ogg $1 парвандаи расона, $2',
	'ogg-long-audio' => '(Ogg $1 парвандаи савтӣ, тӯл $2, $3)',
	'ogg-long-video' => 'Ogg $1 парвандаи наворӣ, тӯл $2, $4×$5 пикселҳо, $3',
	'ogg-long-multiplexed' => '(Парвандаи Ogg савтӣ/наворӣ печида, $1, тӯл $2, $4×$5 пикселҳо, дар маҷмӯъ $3)',
	'ogg-long-general' => '(Парвандаи расонаи Ogg, тӯл $2, $3)',
	'ogg-long-error' => '(Парвандаи ғайримиҷози ogg: $1)',
	'ogg-play' => 'Пахш',
	'ogg-pause' => 'Сукут',
	'ogg-stop' => 'Қатъ',
	'ogg-play-video' => 'Пахши навор',
	'ogg-play-sound' => 'Пахши овоз',
	'ogg-no-player' => 'Бубахшед, дастгоҳи шумо нармафзори пахшкунандаи муносибе надорад. Лутфан <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">як барномаи пахшкунандаро боргирӣ кунед</a>.',
	'ogg-no-xiphqt' => 'Афзунаи XiphQT барои QuickTime ба назар намерасад. QuickTime наметавонад бидуни ин афзуна парвандаҳои Ogg-ро пахш кунад. Лутфан <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT-ро боргирӣ кунед</a>  ё дигар нармафзори пахшкунандаро интихоб намоед.',
	'ogg-player-videoElement' => 'унсури <наворӣ>',
	'ogg-player-oggPlugin' => 'Афзунаи ogg',
	'ogg-player-thumbnail' => 'Фақат акс ҳанӯз',
	'ogg-player-soundthumb' => 'Пахшкунанда нест',
	'ogg-player-selected' => '(интихобшуда)',
	'ogg-use-player' => 'Истифода аз пахшкунанда:',
	'ogg-more' => 'Бештар...',
	'ogg-dismiss' => 'Бастан',
	'ogg-download' => 'Боргирии парванда',
	'ogg-desc-link' => 'Дар бораи ин парванда',
);

/** Tajik (Latin script) (tojikī)
 * @author AVRS
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'ogg-desc' => 'Ba dastgirandae baroi parvandahoi  Ogg Theora va Vorbis, bo paxşkunandai JavaScript',
	'ogg-short-audio' => 'Ogg $1 parvandai savtī, $2',
	'ogg-short-video' => 'Ogg $1 parvandai navorī, $2',
	'ogg-short-general' => 'Ogg $1 parvandai rasona, $2',
	'ogg-long-audio' => '(Ogg $1 parvandai savtī, tūl $2, $3)',
	'ogg-long-video' => 'Ogg $1 parvandai navorī, tūl $2, $4×$5 pikselho, $3',
	'ogg-long-multiplexed' => "(Parvandai Ogg savtī/navorī pecida, $1, tūl $2, $4×$5 pikselho, dar maçmū' $3)",
	'ogg-long-general' => '(Parvandai rasonai Ogg, tūl $2, $3)',
	'ogg-long-error' => '(Parvandai ƣajrimiçozi ogg: $1)',
	'ogg-play' => 'Paxş',
	'ogg-pause' => 'Sukut',
	'ogg-stop' => "Qat'",
	'ogg-play-video' => 'Paxşi navor',
	'ogg-play-sound' => 'Paxşi ovoz',
	'ogg-no-player' => 'Bubaxşed, dastgohi şumo narmafzori paxşkunandai munosibe nadorad. Lutfan <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">jak barnomai paxşkunandaro borgirī kuned</a>.',
	'ogg-no-xiphqt' => 'Afzunai XiphQT baroi QuickTime ba nazar namerasad. QuickTime nametavonad biduni in afzuna parvandahoi Ogg-ro paxş kunad. Lutfan <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT-ro borgirī kuned</a>  jo digar narmafzori paxşkunandaro intixob namoed.',
	'ogg-player-thumbnail' => 'Faqat aks hanūz',
	'ogg-player-soundthumb' => 'Paxşkunanda nest',
	'ogg-player-selected' => '(intixobşuda)',
	'ogg-use-player' => 'Istifoda az paxşkunanda:',
	'ogg-more' => 'Beştar...',
	'ogg-dismiss' => 'Bastan',
	'ogg-download' => 'Borgiriji parvanda',
	'ogg-desc-link' => 'Dar borai in parvanda',
);

/** Thai (ไทย)
 * @author Manop
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'ogg-play' => 'เล่น',
	'ogg-pause' => 'หยุดชั่วคราว',
	'ogg-stop' => 'หยุด',
	'ogg-play-video' => 'เล่นวิดีโอ',
	'ogg-play-sound' => 'เล่นเสียง',
	'ogg-no-player' => 'ขออภัย ระบบของคุณไม่มีซอฟต์แวร์ที่สนับสนุนไฟล์สื่อนี้
กรุณา<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ดาวน์โหลดซอฟต์แวร์เล่นสื่อ</a>',
	'ogg-no-xiphqt' => 'ไม่พบซอฟต์แวร์เสริม XiphQT ของโปรแกรม QuickTime บนระบบของคุณ
โปรแกรม QuickTime ไม่สามารถเล่นไฟล์สกุล Ogg ได้ถ้าไม่มีโปรแกรมเสริมนี้
กรุณา<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">ดวาน์โหลด XiphQT</a> หรือเลือกโปรแกรมอื่น',
);

/** Turkmen (Türkmençe)
 * @author AVRS
 * @author Hanberke
 */
$messages['tk'] = array(
	'ogg-desc' => 'Ogg Theora we Vorbis faýllary üçin işleýji, JavaScript pleýeri bilen bilelikde',
	'ogg-short-audio' => 'Ogg $1 ses faýly, $2',
	'ogg-short-video' => 'Ogg $1 wideo faýly, $2',
	'ogg-short-general' => 'Ogg $1 media faýly, $2',
	'ogg-long-audio' => '(Ogg $1 ses faýly, uzynlyk $2, $3)',
	'ogg-long-video' => 'Ogg $1 wideo faýly, uzynlyk $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Ogg multipleks audio/wideo faýly, $1, uzynlyk $2, $4×$5 piksel, $3 jemi)',
	'ogg-long-general' => '(Ogg media faýly, uzynlyk $2, $3)',
	'ogg-long-error' => '(Nädogry ogg faýly: $1)',
	'ogg-play' => 'Oýnat',
	'ogg-pause' => 'Pauza',
	'ogg-stop' => 'Duruz',
	'ogg-play-video' => 'Wideo oýnat',
	'ogg-play-sound' => 'Ses oýnat',
	'ogg-no-player' => 'Gynansak-da, ulgamyňyzda goldanylýan haýsydyr bir pleýer programmaňyz ýok ýaly-la.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download"> Pleýer düşüriň</a>.',
	'ogg-no-xiphqt' => 'QuickTime üçin XiphQT komponentiňiz ýok bolarly.
QuickTime bu komponent bolmasa Ogg faýllaryny oýnadyp bilmeýär.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT-i düşüriň</a> ýa-da başga bir pleýer saýlaň.',
	'ogg-player-videoElement' => 'Milli brauzer goldawy',
	'ogg-player-oggPlugin' => 'Brauzer goşmaça moduly',
	'ogg-player-thumbnail' => 'Diňe hereketsiz surat',
	'ogg-player-soundthumb' => 'Pleýer ýok',
	'ogg-player-selected' => '(saýlanylan)',
	'ogg-use-player' => 'Pleýer ulan:',
	'ogg-more' => 'Has köp...',
	'ogg-dismiss' => 'Ýap',
	'ogg-download' => 'Faýl düşür',
	'ogg-desc-link' => 'Bu faýl hakda',
	'ogg-oggThumb-version' => 'OggHandler oggThumb programmasynyň $1 wersiýasyny ýa-da has täzesini talap edýär.',
	'ogg-oggThumb-failed' => 'oggThumb miniatýura döredip bilmedi.',
);

/** Tagalog (Tagalog)
 * @author AVRS
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'ogg-desc' => 'Tagahawak para sa mga talaksang Ogg Theora at Vorbis, na may panugtog/pampaandar na JavaScript',
	'ogg-short-audio' => '$1 na talaksang pangtunog ng Ogg, $2',
	'ogg-short-video' => "$1 talaksang pampalabas (''video'') ng Ogg, $2",
	'ogg-short-general' => '$1 talaksang pangmidya ng Ogg, $2',
	'ogg-long-audio' => '($1 talaksang pantunog ng Ogg, haba $2, $3)',
	'ogg-long-video' => '$1 talaksan ng palabas ng Ogg, haba $2, $4×$5 mga piksel, $3',
	'ogg-long-multiplexed' => '(magkasanib at nagsasabayang talaksang nadirinig o audio/palabas ng Ogg, $1, haba $2, $4×$5 mga piksel, $3 sa kalahatan)',
	'ogg-long-general' => "(Talaksang pangmidya ng ''Ogg'', haba $2, $3)",
	'ogg-long-error' => "(Hindi tanggap na talaksang ''ogg'': $1)",
	'ogg-play' => 'Paandarin',
	'ogg-pause' => 'Pansamantalang pahintuin',
	'ogg-stop' => 'Ihinto/itigil',
	'ogg-play-video' => "Paandarin ang palabas (''video'')",
	'ogg-play-sound' => 'Patugtugin ang tunog',
	'ogg-no-player' => 'Paumanhin, tila parang walang anumang sinusuportahang pamapatugtog/pampaandar na sopwer ang sistema mo.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Magkarga lamang po muna ng isang panugtog/pampaandar</a>.',
	'ogg-no-xiphqt' => 'Tila parang wala ka pang sangkap (komponente) na XiphQT para sa QuickTime.
Hindi makapagpapatugtog ang QuickTime ng mga talaksang Ogg kapag wala ang ganitong sangkap.
<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">Magkarga muna po ng XiphQT</a> o pumili ng iba pang panugtog/pampaandar.',
	'ogg-player-videoElement' => "Katutubong tagapagtangkilik/pangsuporta ng pantingin-tingin (''browser'')",
	'ogg-player-oggPlugin' => "Pampasak sa pantingin-tingin (''browser'')",
	'ogg-player-cortado' => 'Cortado (Java)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (ActiveX)',
	'ogg-player-quicktime-mozilla' => 'QuickTime',
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-kaffeine' => 'Kaffeine',
	'ogg-player-mplayerplug-in' => "pampasak na pampatugtog/pampaandar ng tunog (''mplayerplug-in'')",
	'ogg-player-thumbnail' => 'Larawang hindi gumagalaw lamang',
	'ogg-player-soundthumb' => 'Walang pampatugtog/pampaandar',
	'ogg-player-selected' => '(napili na)',
	'ogg-use-player' => 'Gamitin ang pampaandar:',
	'ogg-more' => 'Marami pa…',
	'ogg-dismiss' => 'Isara',
	'ogg-download' => 'Ikarga ang talaksan',
	'ogg-desc-link' => 'Tungkol sa talaksang ito',
	'ogg-oggThumb-version' => 'Nangangailangan ang OggHandler ng bersyong $1 o mas luma.',
	'ogg-oggThumb-failed' => 'Nabigo ang oggThumb na lumikha ng munting larawan.',
);

/** Tok Pisin (Tok Pisin)
 * @author Iketsi
 */
$messages['tpi'] = array(
	'ogg-more' => 'Moa...',
);

/** Turkish (Türkçe)
 * @author AVRS
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Mach
 * @author Runningfridgesrule
 * @author Srhat
 */
$messages['tr'] = array(
	'ogg-desc' => 'Ogg Theora ve Vorbis dosyaları için işleyici, JavaScript oynatıcısı ile',
	'ogg-short-audio' => 'Ogg $1 ses dosyası, $2',
	'ogg-short-video' => 'Ogg $1 film dosyası, $2',
	'ogg-short-general' => 'Ogg $1 medya dosyası, $2',
	'ogg-long-audio' => '(Ogg $1 ses dosyası, süre $2, $3)',
	'ogg-long-video' => 'Ogg $1 film dosyası, süre $2, $4×$5 piksel, $3',
	'ogg-long-multiplexed' => '(Ogg çok düzeyli ses/film dosyası, $1, süre $2, $4×$5 piksel, $3 genelde)',
	'ogg-long-general' => '(Ogg medya dosyası, süre $2, $3)',
	'ogg-long-error' => '(Geçersiz ogg dosyası: $1)',
	'ogg-play' => 'Oynat',
	'ogg-pause' => 'Duraklat',
	'ogg-stop' => 'Durdur',
	'ogg-play-video' => 'Video filmini oynat',
	'ogg-play-sound' => 'Sesi oynat',
	'ogg-no-player' => 'Üzgünüz, sisteminiz desteklenen herhangi bir oynatıcı yazılımına sahip gibi görünmüyor.
Lütfen <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">bir oynatıcı indirin</a>.',
	'ogg-no-xiphqt' => 'QuickTime için XiphQT bileşenine sahip değil görünüyorsunuz.
QuickTime bu bileşen olmadan Ogg dosyalarını oynatamaz.
Lütfen <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">XiphQT\'i indirin</a> ya da başka bir oynatıcı seçin.',
	'ogg-player-videoElement' => 'Yerel tarayıcı desteği',
	'ogg-player-oggPlugin' => 'Tarayıcı eklentisi',
	'ogg-player-thumbnail' => 'Henüz sadece resimdir',
	'ogg-player-soundthumb' => 'Oynatıcı yok',
	'ogg-player-selected' => '(seçilmiş)',
	'ogg-use-player' => 'Oynatıcıyı kullanın:',
	'ogg-more' => 'Daha...',
	'ogg-dismiss' => 'Kapat',
	'ogg-download' => 'Dosya indir',
	'ogg-desc-link' => 'Bu dosya hakkında',
	'ogg-oggThumb-version' => 'OggHandler, oggThumb sürüm $1 veya üstü gerektirir.',
	'ogg-oggThumb-failed' => 'oggThumb küçük resim oluşturmayı başaramadı.',
);

/** Tsonga (Xitsonga)
 * @author Thuvack
 */
$messages['ts'] = array(
	'ogg-more' => 'Swinwana…',
	'ogg-dismiss' => 'Pfala',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'ogg-play' => 'Җырлату',
	'ogg-pause' => 'Туктатып тору',
	'ogg-stop' => 'Туктату',
	'ogg-play-video' => 'Видеоязманы карау',
	'ogg-play-sound' => 'Көйне тыңлау',
	'ogg-no-player' => 'Гафу итегез, ләкин сезнең системагыз бу файллар төрен ача алмый, зинһар кирәк булган программаларны  <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">үзегезгә йөкләп алыгыз</a>.',
	'ogg-player-videoElement' => 'Браузер ярдәмендә тыңлау',
	'ogg-player-oggPlugin' => 'Ogg модуль',
	'ogg-player-thumbnail' => 'Тыйнак рәсемнәрне генә куллану',
	'ogg-player-soundthumb' => 'Уйнаутучы юк',
	'ogg-player-selected' => '(сайланган)',
	'ogg-use-player' => 'Бирелгән уйнаткычны куллану:',
	'ogg-more' => 'Тулырак...',
	'ogg-dismiss' => 'Ябу',
	'ogg-download' => 'Файлны алу',
	'ogg-desc-link' => 'Файл турында мәгълүмат',
	'ogg-oggThumb-version' => 'OggHandler $1 юрамасыннан да югарырак oggThumb тәэминатын сорый.',
	'ogg-oggThumb-failed' => 'oggThumb нигезендә миниатюраны ясап булмады.',
);

/** Ukrainian (Українська)
 * @author AS
 * @author AVRS
 * @author Ahonc
 * @author Arturyatsko
 * @author Dim Grits
 * @author NickK
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'ogg-desc' => 'Оброблювач файлів Ogg Theora і Vorbis з використанням JavaScript-програвача',
	'ogg-short-audio' => 'Звуковий файл Ogg $1, $2',
	'ogg-short-video' => 'Відео-файл Ogg $1, $2',
	'ogg-short-general' => 'Файл Ogg $1, $2',
	'ogg-long-audio' => 'звуковий файл Ogg $1, довжина $2, $3',
	'ogg-long-video' => 'відео-файл Ogg $1, довжина $2, $4×$5 пікселів, $3',
	'ogg-long-multiplexed' => '(мультиплексний аудіо/відео-файл ogg, $1, довжина $2, $4×$5 пікселів, $3 усього)',
	'ogg-long-general' => '(медіа-файл Ogg, довжина $2, $3)',
	'ogg-long-error' => '(Неправильний ogg-файл: $1)',
	'ogg-play' => 'Відтворити',
	'ogg-pause' => 'Пауза',
	'ogg-stop' => 'Зупинити',
	'ogg-play-video' => 'Відтворити відео',
	'ogg-play-sound' => 'Відтворити звук',
	'ogg-no-player' => 'Вибачте, ваша ситема не має необхідного програмного забезпечення для відтворення файлів. Будь ласка, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">завантажте програвач</a>.',
	'ogg-no-xiphqt' => 'Відсутній компонент XiphQT для QuickTime.
QuickTime не може відтворювати ogg-файли без цього компонента.
Будь ласка, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">завантажте XiphQT</a> або оберіть інший програвач.',
	'ogg-player-videoElement' => 'Рідна підтримка веб-оглядача',
	'ogg-player-oggPlugin' => 'Плаґін для браузера',
	'ogg-player-cortado' => 'Cortado (Java)',
	'ogg-player-vlc-mozilla' => 'VLC',
	'ogg-player-vlc-activex' => 'VLC (ActiveX)',
	'ogg-player-quicktime-mozilla' => 'QuickTime',
	'ogg-player-quicktime-activex' => 'QuickTime (ActiveX)',
	'ogg-player-totem' => 'Totem',
	'ogg-player-kmplayer' => 'KMPlayer',
	'ogg-player-kaffeine' => 'Kaffeine',
	'ogg-player-mplayerplug-in' => 'mplayerplug-in',
	'ogg-player-thumbnail' => 'Тільки нерухоме зображення',
	'ogg-player-soundthumb' => 'Нема програвача',
	'ogg-player-selected' => '(обраний)',
	'ogg-use-player' => 'Використовувати програвач:',
	'ogg-more' => 'Більше…',
	'ogg-dismiss' => 'Закрити',
	'ogg-download' => 'Завантажити файл',
	'ogg-desc-link' => 'Інформація про цей файл',
	'ogg-oggThumb-version' => 'OggHandler вимагає oggThumb версії $1 або більш пізньої.',
	'ogg-oggThumb-failed' => 'oggThumb не вдалося створити мініатюру.',
);

/** Vèneto (Vèneto)
 * @author AVRS
 * @author Candalua
 */
$messages['vec'] = array(
	'ogg-desc' => 'Gestor par i file Ogg Theora e Vorbis, con riprodutor JavaScript',
	'ogg-short-audio' => 'File audio Ogg $1, $2',
	'ogg-short-video' => 'File video Ogg $1, $2',
	'ogg-short-general' => 'File multimedial Ogg $1, $2',
	'ogg-long-audio' => '(File audio Ogg $1, durata $2, $3)',
	'ogg-long-video' => 'File video Ogg $1, durata $2, dimensioni $4×$5 pixel, $3',
	'ogg-long-multiplexed' => '(File audio/video multiplexed Ogg $1, durata $2, dimensioni $4×$5 pixel, conplessivamente $3)',
	'ogg-long-general' => '(File multimedial Ogg, durata $2, $3)',
	'ogg-long-error' => '(File ogg mìa valido: $1)',
	'ogg-play' => 'Riprodusi',
	'ogg-pause' => 'Pausa',
	'ogg-stop' => 'Fèrma',
	'ogg-play-video' => 'Varda el video',
	'ogg-play-sound' => 'Scolta el file',
	'ogg-no-player' => 'Semo spiacenti, ma sul to sistema no risulta instalà nissun software de riproduzion conpatibile. Par piaser <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">scàrichete un letor</a> che vaga ben.',
	'ogg-no-xiphqt' => 'No risulta mìa instalà el conponente XiphQT de QuickTime. Senza sto conponente no se pode mìa riprodur i file Ogg con QuickTime. Par piaser, <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">scàrichete XiphQT</a> o siegli n\'altro letor.',
	'ogg-player-videoElement' => 'Suporto browser zà de suo (nativo)',
	'ogg-player-oggPlugin' => 'Plugin browser',
	'ogg-player-thumbnail' => 'Solo imagini fisse',
	'ogg-player-soundthumb' => 'Nissun letor',
	'ogg-player-selected' => '(selezionà)',
	'ogg-use-player' => 'Dòpara el letor:',
	'ogg-more' => 'Altro...',
	'ogg-dismiss' => 'Sara',
	'ogg-download' => 'Descarga el file',
	'ogg-desc-link' => 'Informazion su sto file',
	'ogg-oggThumb-version' => 'Par OggHandler ghe vole oggThumb version $1 o sucessiva.',
	'ogg-oggThumb-failed' => "oggThumb no'l xe stà bon de crear la miniatura.",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'ogg-play' => 'Väta',
	'ogg-pause' => 'Pauz',
	'ogg-stop' => 'Azotada',
	'ogg-play-video' => 'Ozutada video',
	'ogg-play-sound' => 'Väta kulundad',
	'ogg-player-oggPlugin' => 'Kaclim-plagin',
	'ogg-player-soundthumb' => 'Ei ole plejerad',
	'ogg-player-selected' => '(valitud)',
	'ogg-use-player' => 'Kävutada plejer:',
	'ogg-more' => 'Enamba...',
	'ogg-dismiss' => 'Peitta',
	'ogg-download' => 'Jügutoitta fail',
	'ogg-desc-link' => 'Informacii neciš failas',
);

/** Vietnamese (Tiếng Việt)
 * @author AVRS
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'ogg-desc' => 'Bộ trình bày các tập tin Ogg Theora và Vorbis dùng hộp chơi phương tiện bằng JavaScript',
	'ogg-short-audio' => 'Tập tin âm thanh Ogg $1, $2',
	'ogg-short-video' => 'Tập tin video Ogg $1, $2',
	'ogg-short-general' => 'Tập tin Ogg $1, $2',
	'ogg-long-audio' => '(tập tin âm thanh Ogg $1, dài $2, $3)',
	'ogg-long-video' => 'tập tin video Ogg $1, dài $2, $4×$5 điểm ảnh, $3',
	'ogg-long-multiplexed' => '(tập tin Ogg có âm thanh và video ghép kênh, $1, dài $2, $4×$5 điểm ảnh, $3 tất cả)',
	'ogg-long-general' => '(tập tin phương tiện Ogg, dài $2, $3)',
	'ogg-long-error' => '(Tập tin Ogg có lỗi: $1)',
	'ogg-play' => 'Chơi',
	'ogg-pause' => 'Tạm ngừng',
	'ogg-stop' => 'Ngừng',
	'ogg-play-video' => 'Coi video',
	'ogg-play-sound' => 'Nghe âm thanh',
	'ogg-no-player' => 'Rất tiếc, hình như máy tính của bạn cần thêm phần mềm. Xin <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/vi">tải về chương trình chơi nhạc</a>.',
	'ogg-no-xiphqt' => 'Hình như bạn không có bộ phận XiphQT cho QuickTime, nên QuickTime không thể chơi những tập tin Ogg được. Xin <a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download/vi">truyền xuống XiphQT</a> hay chọn một chương trình chơi nhạc khác.',
	'ogg-player-videoElement' => 'Bộ chơi có sẵn trong trình duyệt',
	'ogg-player-oggPlugin' => 'Phần bổ trợ trình duyệt',
	'ogg-player-thumbnail' => 'Chỉ hiển thị hình tĩnh',
	'ogg-player-soundthumb' => 'Tắt',
	'ogg-player-selected' => '(được chọn)',
	'ogg-use-player' => 'Chọn chương trình chơi:',
	'ogg-more' => 'Thêm nữa…',
	'ogg-dismiss' => 'Đóng',
	'ogg-download' => 'Tải về tập tin',
	'ogg-desc-link' => 'Chi tiết của tập tin này',
	'ogg-oggThumb-version' => 'OggHandler cần oggThumb, phiên bản $1 trở lên.',
	'ogg-oggThumb-failed' => 'oggThumb bị thất bại trong việc tạo hình thu nhỏ.',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'ogg-stop' => 'Stöpön',
	'ogg-player-videoElement' => 'Stüt bevüresodanaföm gebidon',
	'ogg-more' => 'Pluikos...',
	'ogg-dismiss' => 'Färmükön',
	'ogg-download' => 'Donükön ragivi',
	'ogg-desc-link' => 'Tefü ragiv at',
);

/** Walloon (Walon) */
$messages['wa'] = array(
	'ogg-dismiss' => 'Clôre',
);

/** Yiddish (ייִדיש)
 * @author Imre
 * @author פוילישער
 */
$messages['yi'] = array(
	'ogg-play' => 'שפּיל',
	'ogg-pause' => 'פויזע',
	'ogg-more' => 'נאך…',
	'ogg-dismiss' => 'שליסן',
	'ogg-download' => 'אראָפלאָדן טעקע',
	'ogg-desc-link' => 'וועגן דער טעקע',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'ogg-short-audio' => 'Fáìlì amóhùn Ogg $1, $2',
	'ogg-play' => 'Ìmúṣeré',
	'ogg-pause' => 'Ìjáwọ́',
	'ogg-stop' => 'Ìdádúró',
	'ogg-player-selected' => '(ṣíṣàyàn)',
	'ogg-dismiss' => 'Padé',
	'ogg-download' => 'Ìrùsílẹ̀ fáìlì',
	'ogg-desc-link' => 'Nípa fáìlì yìí',
);

/** Cantonese (粵語)
 * @author AVRS
 */
$messages['yue'] = array(
	'ogg-desc' => 'Ogg Theora 同 Vorbis 檔案嘅處理器，加埋 JavaScript 播放器',
	'ogg-short-audio' => 'Ogg $1 聲檔，$2',
	'ogg-short-video' => 'Ogg $1 畫檔，$2',
	'ogg-short-general' => 'Ogg $1 媒檔，$2',
	'ogg-long-audio' => '(Ogg $1 聲檔，長度$2，$3)',
	'ogg-long-video' => 'Ogg $1 畫檔，長度$2，$4×$5像素，$3',
	'ogg-long-multiplexed' => '(Ogg 多工聲／畫檔，$1，長度$2，$4×$5像素，總共$3)',
	'ogg-long-general' => '(Ogg 媒檔，長度$2，$3)',
	'ogg-long-error' => '(無效嘅ogg檔: $1)',
	'ogg-play' => '去',
	'ogg-pause' => '暫停',
	'ogg-stop' => '停',
	'ogg-play-video' => '去畫',
	'ogg-play-sound' => '去聲',
	'ogg-no-player' => '對唔住，你嘅系統並無任何可以支援得到嘅播放器。請安裝<a href="http://www.java.com/zh_TW/download/manual.jsp">Java</a>。',
	'ogg-no-xiphqt' => '你似乎無畀QuickTime用嘅XiphQT組件。響未有呢個組件嗰陣，QuickTime係唔可以播放Ogg檔案。請<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">下載XiphQT</a>或者揀過另外一個播放器。',
	'ogg-player-videoElement' => '<video>元素',
	'ogg-player-oggPlugin' => 'Ogg插件',
	'ogg-player-thumbnail' => '只有靜止圖像',
	'ogg-player-soundthumb' => '無播放器',
	'ogg-player-selected' => '(揀咗)',
	'ogg-use-player' => '使用播放器:',
	'ogg-more' => '更多...',
	'ogg-dismiss' => '閂',
	'ogg-download' => '下載檔案',
	'ogg-desc-link' => '關於呢個檔案',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author AVRS
 * @author Gaoxuewei
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'ogg-desc' => 'Ogg Theora 和 Vorbis 文件的处理器，含 JavaScript 播放器',
	'ogg-short-audio' => 'Ogg $1 声音文件，$2',
	'ogg-short-video' => 'Ogg $1 视频文件，$2',
	'ogg-short-general' => 'Ogg $1 媒体文件，$2',
	'ogg-long-audio' => 'Ogg $1 声音文件，长度$2，$3',
	'ogg-long-video' => 'Ogg $1 视频文件，长度$2，$4×$5像素，$3',
	'ogg-long-multiplexed' => 'Ogg 多工声音／视频文件，$1，长度$2，$4×$5像素，共$3',
	'ogg-long-general' => 'Ogg 媒体文件，长度$2，$3',
	'ogg-long-error' => '无效的ogg文件：$1',
	'ogg-play' => '播放',
	'ogg-pause' => '暂停',
	'ogg-stop' => '停止',
	'ogg-play-video' => '播放视频',
	'ogg-play-sound' => '播放声音',
	'ogg-no-player' => '抱歉，您的系统并无任何可以支持播放的播放器。请安装<a href="http://www.java.com/zh_CN/download/manual.jsp">Java</a>。',
	'ogg-no-xiphqt' => '您似乎没有给QuickTime用的XiphQT组件。在未有这个组件的情况下，QuickTime是不能播放Ogg文件的。请<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">下载XiphQT</a>或者选取另一个播放器。',
	'ogg-player-videoElement' => '<video>元素',
	'ogg-player-oggPlugin' => 'Ogg插件',
	'ogg-player-thumbnail' => '只有静止图像',
	'ogg-player-soundthumb' => '沒有播放器',
	'ogg-player-selected' => '（已选取）',
	'ogg-use-player' => '使用播放器:',
	'ogg-more' => '更多...',
	'ogg-dismiss' => '关闭',
	'ogg-download' => '下载文件',
	'ogg-desc-link' => '关于这个文件',
	'ogg-oggThumb-version' => 'OggHandler需要oggThumb $1或者之后的版本',
	'ogg-oggThumb-failed' => 'oggThumb未能创建缩略图。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author AVRS
 * @author Gaoxuewei
 * @author Horacewai2
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'ogg-desc' => 'Ogg Theora 和 Vorbis 檔案的處理器，含 JavaScript 播放器',
	'ogg-short-audio' => 'Ogg $1 聲音檔案，$2',
	'ogg-short-video' => 'Ogg $1 影片檔案，$2',
	'ogg-short-general' => 'Ogg $1 媒體檔案，$2',
	'ogg-long-audio' => '（Ogg $1 聲音檔案，長度$2，$3）',
	'ogg-long-video' => 'Ogg $1 影片檔案，長度$2，$4×$5像素，$3',
	'ogg-long-multiplexed' => '（Ogg 多工聲音／影片檔案，$1，長度$2，$4×$5像素，共$3）',
	'ogg-long-general' => '（Ogg 媒體檔案，長度$2，$3）',
	'ogg-long-error' => '（無效的 ogg 檔案：$1）',
	'ogg-play' => '播放',
	'ogg-pause' => '暫停',
	'ogg-stop' => '停止',
	'ogg-play-video' => '播放影片',
	'ogg-play-sound' => '播放聲音',
	'ogg-no-player' => '抱歉，您的系統並無任何可以支援播放的播放器。請安裝<a href=「http://www.java.com/zh_TW/download/manual.jsp」>Java</a>。',
	'ogg-no-xiphqt' => '您似乎沒有給 QuickTime 用的 XiphQT 元件。在未有這個元件的情況下，QuickTime 是不能播放 Ogg 檔案的。請<a href=「http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download」>下載 XiphQT</a> 或者選取另一個播放器。',
	'ogg-player-videoElement' => '<video>元素',
	'ogg-player-oggPlugin' => 'Ogg 外掛程式',
	'ogg-player-thumbnail' => '只有靜止圖片',
	'ogg-player-soundthumb' => '沒有播放器',
	'ogg-player-selected' => '（已選取）',
	'ogg-use-player' => '使用播放器：',
	'ogg-more' => '更多...',
	'ogg-dismiss' => '關閉',
	'ogg-download' => '下載檔案',
	'ogg-desc-link' => '關於這個檔案',
	'ogg-oggThumb-version' => 'OggHandler 需要 oggThumb $1 或者之後的版本',
	'ogg-oggThumb-failed' => 'oggThumb 無法建立縮圖。',
);

