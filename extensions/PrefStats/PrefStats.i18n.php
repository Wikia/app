<?php
/**
 * Internationalisation for Usability Initiative PrefStats extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Roan Kattouw
 */
$messages['en'] = array(
	'prefstats' => 'Preference statistics',
	'prefstats-desc' => 'Track statistics about how many users have certain preferences enabled',
	'prefstats-title' => 'Preference statistics',
	'prefstats-list-intro' => 'Currently, the following preferences are being tracked.
Click on one to view statistics about it.',
	'prefstats-list-elem' => '$1 = $2',
	'prefstats-noprefs' => 'No preferences are currently being tracked.
Configure $wgPrefStatsTrackPrefs to track preferences.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|user has|users have}} enabled this preference since preference statistics were activated
** $2 {{PLURAL:$2|user still has|users still have}} it enabled
** $3 {{PLURAL:$3|user has|users have}} disabled it since',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|user has|users have}} enabled this preference since preference statistics were activated
** $2 {{PLURAL:$2|user still has|users still have}} it enabled
** $3 {{PLURAL:$3|user has|users have}} disabled it since
* In total, $4 {{PLURAL:$4|user has|users have}} this preference set',
	'prefstats-xaxis' => 'Duration (hours)',
	'prefstats-factors' => 'View per: $1',
	'prefstats-factor-hour' => 'hour',
	'prefstats-factor-sixhours' => 'six hours',
	'prefstats-factor-day' => 'day',
	'prefstats-factor-week' => 'week',
	'prefstats-factor-twoweeks' => 'two weeks',
	'prefstats-factor-fourweeks' => 'four weeks',
	'prefstats-factor-default' => 'back to default scale',
	'prefstats-legend-out' => 'Opted out',
	'prefstats-legend-in' => 'Opted in',
);

/** Message documentation (Message documentation)
 * @author GerardM
 * @author Lloffiwr
 * @author Purodha
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'prefstats-desc' => '{{desc}}',
	'prefstats-factors' => '$1 is a list of values with a link each, and separated by {{msg-mw|pipe-separator}}.

See graph of [http://en.wikipedia.org/wiki/Special:PrefStats/skin user preference statistics].',
	'prefstats-factor-hour' => 'One hour. Used in {{msg-mw|prefstats-factors}} as part of the pipe separated list $1.',
	'prefstats-factor-day' => 'One day. Used in {{msg-mw|prefstats-factors}} as part of the pipe separated list $1.',
	'prefstats-factor-week' => 'One week. Used in {{msg-mw|prefstats-factors}} as part of the pipe separated list $1.',
	'prefstats-factor-twoweeks' => 'Used in {{msg-mw|prefstats-factors}} as part of the pipe separated list $1.',
	'prefstats-factor-fourweeks' => 'Used in {{msg-mw|prefstats-factors}} as part of the pipe separated list $1.',
	'prefstats-factor-default' => 'Used in {{msg-mw|prefstats-factors}} as part of the pipe separated list $1.

See graph of [http://en.wikipedia.org/wiki/Special:PrefStats/skin user preference statistics].',
	'prefstats-legend-out' => 'Legend on graph of [http://en.wikipedia.org/wiki/Special:PrefStats/skin user preference statistics].',
	'prefstats-legend-in' => 'Legend on graph of [http://en.wikipedia.org/wiki/Special:PrefStats/skin user preference statistics].',
);

/** Afrikaans (Afrikaans)
 * @author Adriaan
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'prefstats' => 'Voorkeur-statistieke',
	'prefstats-desc' => 'Track statistieke oor hoeveel gebruikers het sekere voorkeure in staat gestel',
	'prefstats-title' => 'Voorkeur-statistieke',
	'prefstats-xaxis' => 'Tydsduur (ure)',
	'prefstats-factors' => 'Wys per: $1',
	'prefstats-factor-hour' => 'uur',
	'prefstats-factor-sixhours' => 'ses uur',
	'prefstats-factor-day' => 'dag',
	'prefstats-factor-week' => 'week',
	'prefstats-factor-twoweeks' => 'twee weke',
	'prefstats-factor-fourweeks' => 'vier weke',
	'prefstats-factor-default' => 'terug na die verstek-skaal',
	'prefstats-legend-out' => 'Uitgeteken',
	'prefstats-legend-in' => 'Aangemeld',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'prefstats' => 'Statistikat e Preferencë',
	'prefstats-desc' => 'Statistika Track se si shumë përdorues të ketë preferenca të caktuara aktivizuar',
	'prefstats-title' => 'Statistikat e Preferencë',
	'prefstats-list-intro' => 'Aktualisht, preferencat e mëposhtme janë duke u gjurmuar.
 Klikoni mbi një për të parë statistikave në lidhje me të.',
	'prefstats-noprefs' => 'Nuk ka preferencat janë duke u gjurmuar. Konfiguro $wgPrefStatsTrackPrefs për të gjetur preferencave.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|përdorues ka|perdorues kanë}} mundësuar këtë parapëlqim që nga statistika preferencë ishin aktivizuar
** $2 {{PLURAL:$2 |përdorues ka akoma|përdoruesit kanë ende}} është aktivizuar
** $3 {{PLURAL:$3|përdorues ka|perdorues kanë}} me aftësi të kufizuara që',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|përdorues ka|perdorues kanë}} mundësuar këtë parapëlqim që nga statistika preferencë ishin aktivizuar
** $2 {{PLURAL:$2|përdorues ka akoma|përdoruesit kanë ende}} është aktivizuar',
	'prefstats-xaxis' => 'Kohëzgjatja (orë)',
	'prefstats-factors' => 'Shiko për: $1',
	'prefstats-factor-hour' => 'orë',
	'prefstats-factor-sixhours' => 'gjashtë orë',
	'prefstats-factor-day' => 'ditë',
	'prefstats-factor-week' => 'javë',
	'prefstats-factor-twoweeks' => 'dy javë',
	'prefstats-factor-fourweeks' => 'katër javë',
	'prefstats-factor-default' => 'back to default shkallë',
	'prefstats-legend-out' => 'Zgjedhur nga',
	'prefstats-legend-in' => 'Zgjedhur në',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'prefstats' => "Estatisticas d'as preferencias",
	'prefstats-desc' => 'Rechistrar as estatisticas sobre quántos usuarios tienen activatas ciertas preferencias',
	'prefstats-title' => "Estatisticas d'as preferencias",
	'prefstats-list-intro' => "Actualment s'están rechistrando as preferencias siguients. 
Clique sobre una ta veyer as suyas estatisticas.",
	'prefstats-noprefs' => 'No se ye rechistrando garra preferencia. Configure $wgPrefStatsTrackPrefs ta rechistrar as preferencias.',
	'prefstats-counters' => "* $1  {{PLURAL:$1|usuario ha|usuarios han}} activato ista preferencia dende que a estatistica s'activó.
** $2  {{PLURAL:$2|usuario aún tiene|usuarios encara tienen}} ista preferencia activata.
** $3  {{PLURAL:$1|usuario la ha|usuarios la han}} desactivato dende alavaez.",
	'prefstats-counters-expensive' => "* $1  {{PLURAL:$1|usuario ha|usuarios han}} activato ista preferencia dende que a estatistica s'activó.
** $2  {{PLURAL:$2|usuario aún tiene|usuarios encara tienen}} ista preferencia activata.
** $3  {{PLURAL:$1|usuario la ha|usuarios la han}} desactivato dende alavez.
* En total, $4 {{PLURAL:$4|usuario tien|usuarios tienen}} ista preferencia activa.",
	'prefstats-xaxis' => 'Duración (horas)',
	'prefstats-factors' => 'Veyer-lo seguntes: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'seis horas',
	'prefstats-factor-day' => 'día',
	'prefstats-factor-week' => 'semana',
	'prefstats-factor-twoweeks' => 'dos semanas',
	'prefstats-factor-fourweeks' => 'quatro semanas',
	'prefstats-factor-default' => 'torna a la escala por defecto',
	'prefstats-legend-out' => 'Ha deixau de participar',
	'prefstats-legend-in' => 'Quiere participar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Orango
 * @author OsamaK
 */
$messages['ar'] = array(
	'prefstats' => 'إحصاءات التفضيلات',
	'prefstats-desc' => 'تتبع الإحصاءات التي تظهر عدد المستخدمين الذين فعّلوا تفضيلات معينة.',
	'prefstats-title' => 'إحصاءات التفضيلات',
	'prefstats-list-intro' => 'يتم حاليًا تتبع التفضيلات التالية.
انقر على أحد التفضيلات لتظهر إحصاءات عنه.',
	'prefstats-noprefs' => 'لا توجد تفضيلات يتم تتبعها. اضبط $wgPrefStatsTrackPrefs لتتبع التفضيلات.',
	'prefstats-counters' => '* فعّل {{PLURAL:$1||مستخدم واحد|مستخدمان|$1 مستخدمين|$1 مستخدمًا|$1 مستخدم}} هذه التفضيلة منذ تنفعيل إحصاءات التفضيلات.
** فعّلها {{PLURAL:$2||مستخدم واحد|مستخدمان|$2 مستخدمين|$2 مستخدمًا|$2 مستخدم}}
** عطّلها {{PLURAL:$3||مستخدم واحد|مستخدمان|$3 مستخدمين|$3 مستخدمًا|$3 مستخدم}}',
	'prefstats-counters-expensive' => '* فعّل {{PLURAL:$1||مستخدم واحد|مستخدمان|$1 مستخدمين|$1 مستخدمًا|$1 مستخدم}} هذه التفضيلة منذ تنفعيل إحصاءات التفضيلات.
** فعّلها {{PLURAL:$2||مستخدم واحد|مستخدمان|$2 مستخدمين|$2 مستخدمًا|$2 مستخدم}}
** عطّلها {{PLURAL:$3||مستخدم واحد|مستخدمان|$3 مستخدمين|$3 مستخدمًا|$3 مستخدم}}
* في المحصلة، ضبط {{PLURAL:$4||مستخدم واحد|مستخدمان|$4 مستخدمين|$4 مستخدمًا|$4 مستخدم}} هذه التفضيلة',
	'prefstats-xaxis' => 'المدة (بالساعات)',
	'prefstats-factors' => 'عرض كل: $1',
	'prefstats-factor-hour' => 'ساعة',
	'prefstats-factor-sixhours' => 'ست ساعات',
	'prefstats-factor-day' => 'يوم',
	'prefstats-factor-week' => 'أسبوع',
	'prefstats-factor-twoweeks' => 'أسبوعين',
	'prefstats-factor-fourweeks' => 'أربعة أسابيع',
	'prefstats-factor-default' => 'عد إلى الجدول الإفتراضي',
	'prefstats-legend-out' => 'اختارت',
	'prefstats-legend-in' => 'مشترك',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'prefstats-xaxis' => 'ܡܬܚܐ (ܒܫܥܬ̈ܐ)',
	'prefstats-factor-hour' => 'ܫܥܬܐ',
	'prefstats-factor-sixhours' => 'ܫܬ ܫܥܬ̈ܐ',
	'prefstats-factor-day' => 'ܝܘܡܐ',
	'prefstats-factor-week' => 'ܫܒܘܥܐ',
	'prefstats-factor-twoweeks' => 'ܬܪܝܢ ܫܒܘܥ̈ܐ',
	'prefstats-factor-fourweeks' => 'ܐܪܒܥܐ ܫܒܘܥ̈ܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'prefstats' => 'إحصاءات التفضيلات',
	'prefstats-desc' => 'تتبع الإحصاءات التى تظهر عدد المستخدمين الذين فعّلوا تفضيلات معينه.',
	'prefstats-title' => 'إحصاءات التفضيلات',
	'prefstats-list-intro' => 'يتم حاليًا تتبع التفضيلات التاليه.
انقر على أحد التفضيلات لتظهر إحصاءات عنه.',
	'prefstats-noprefs' => 'لا توجد تفضيلات يتم تتبعها. اضبط $wgPrefStatsTrackPrefs لتتبع التفضيلات.',
	'prefstats-counters' => '* فعّل {{PLURAL:$1||مستخدم واحد|مستخدمان|$1 مستخدمين|$1 مستخدمًا|$1 مستخدم}} هذه التفضيله منذ تنفعيل إحصاءات التفضيلات.
** فعّلها {{PLURAL:$2||مستخدم واحد|مستخدمان|$2 مستخدمين|$2 مستخدمًا|$2 مستخدم}}
** عطّلها {{PLURAL:$3||مستخدم واحد|مستخدمان|$3 مستخدمين|$3 مستخدمًا|$3 مستخدم}}',
	'prefstats-counters-expensive' => '* فعّل {{PLURAL:$1||مستخدم واحد|مستخدمان|$1 مستخدمين|$1 مستخدمًا|$1 مستخدم}} هذه التفضيله منذ تنفعيل إحصاءات التفضيلات.
** فعّلها {{PLURAL:$2||مستخدم واحد|مستخدمان|$2 مستخدمين|$2 مستخدمًا|$2 مستخدم}}
** عطّلها {{PLURAL:$3||مستخدم واحد|مستخدمان|$3 مستخدمين|$3 مستخدمًا|$3 مستخدم}}
* فى المحصله، ضبط {{PLURAL:$4||مستخدم واحد|مستخدمان|$4 مستخدمين|$4 مستخدمًا|$4 مستخدم}} هذه التفضيلة',
	'prefstats-xaxis' => 'المده (بالساعات)',
	'prefstats-factors' => 'عرض كل: $1',
	'prefstats-factor-hour' => 'ساعة',
	'prefstats-factor-sixhours' => 'ست ساعات',
	'prefstats-factor-day' => 'يوم',
	'prefstats-factor-week' => 'أسبوع',
	'prefstats-factor-twoweeks' => 'أسبوعين',
	'prefstats-factor-fourweeks' => 'أربعه أسابيع',
	'prefstats-factor-default' => 'عد إلى الجدول الإفتراضي',
	'prefstats-legend-out' => 'اختارت',
	'prefstats-legend-in' => 'مشترك',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'prefstats' => 'Estadístiques de les preferencies',
	'prefstats-desc' => 'Siguir les estadístiques sobro cuantos usuarios tienen determinaes preferencies activaes',
	'prefstats-title' => 'Estadístiques de les preferencies',
	'prefstats-list-intro' => "De momentu, tan siguiendose les siguientes preferencies.
Calca nuna pa ver estadístiques d'ella.",
	'prefstats-noprefs' => 'De momentu nun se sigue preferencia denguna.
Configura $wgPrefStatsTrackPrefs pa siguir preferencies.',
	'prefstats-counters' => "* $1 {{PLURAL:$1|usuariu activó|usuarios activaron}} esta preferencia desque s'activaron les estadístiques de preferencies
** $2 {{PLURAL:$2|usuariu inda la tien|usuarios inda la tienen}} activada
** $3 {{PLURAL:$3|usuariu tienla|usuarios tienenla}} desactivada",
	'prefstats-counters-expensive' => "* $1 {{PLURAL:$1|usuariu activó|usuarios activaron}} esta preferencia desque s'activaron les estadístiques de preferencies
** $2 {{PLURAL:$2|usuariu inda la tien|usuarios inda la tienen}} activada
** $3 {{PLURAL:$3|usuariu tienla|usuarios tienenla}} desactivada
* En total, $4 {{PLURAL:$4|usuariu tien|usuarios tienen}} esta preferencia configurada",
	'prefstats-xaxis' => 'Duración (hores)',
	'prefstats-factors' => 'Ver por: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'seis hores',
	'prefstats-factor-day' => 'día',
	'prefstats-factor-week' => 'selmana',
	'prefstats-factor-twoweeks' => 'dos selmanes',
	'prefstats-factor-fourweeks' => 'cuatro selmanes',
	'prefstats-factor-default' => 'tornar a la escala predeterminada',
	'prefstats-legend-out' => 'Desactivao',
	'prefstats-legend-in' => 'Activao',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vugar 1981
 */
$messages['az'] = array(
	'prefstats-factor-hour' => 'saat',
	'prefstats-factor-sixhours' => 'Altı saat',
	'prefstats-factor-day' => 'gün',
	'prefstats-factor-week' => 'həftə',
	'prefstats-factor-twoweeks' => 'İki həftə',
	'prefstats-factor-fourweeks' => 'Dörd həftə',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'prefstats' => 'Көйләүҙәр статистикаһы',
	'prefstats-desc' => 'Нисә ҡатнашыусы үҙендә теге йәки был мөмкинлектәрҙе көйләүҙәре тураһында статистиканы күҙәтеү',
	'prefstats-title' => 'Көйләүҙәр статистикаһы',
	'prefstats-list-intro' => 'Хәҙерге ваҡытта түбәндәге көйләүҙәр күҙәтелә.
Статистиканы ҡарау өсөн береһен һайлағыҙ.',
	'prefstats-noprefs' => 'Хәҙерге ваҡытта бер көйләү ҙә күҙәтелмәй.
Статистиканы күҙәтеү өсөн $wgPrefStatsTrackPrefs билдәләгеҙ.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|ҡатнашыусы|ҡатнашыусы}} мәғлүмәт йыйыу мәленән был көйләүҙе һайлаған
** $2 {{PLURAL:$2|ҡатнашыусы|ҡатнашыусы}} был көйләүҙе һайланған килеш ҡалдырған
** $3 {{PLURAL:$3|ҡатнашыусы|ҡатнашыусы}} был көйләүҙе һундергән',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|ҡатнашыусы|ҡатнашыусы}} мәғлүмәт йыйыу мәленән был көйләүҙе һайлаған
** $2 {{PLURAL:$2|ҡатнашыусы|ҡатнашыусы}} был көйләүҙе һайланған килеш ҡалдырған
** $3 {{PLURAL:$3|ҡатнашыусы|ҡатнашыусы}} был көйләүҙе һундергән
* Барыһы, $4 {{PLURAL:$4|ҡатнашыусыла|ҡатнашыусыла}} был көйләү һайланған',
	'prefstats-xaxis' => 'Дауамы (сәғәттәрҙә)',
	'prefstats-factors' => '$1 эсендә ҡарау',
	'prefstats-factor-hour' => 'сәғәт',
	'prefstats-factor-sixhours' => 'алты сәғәт',
	'prefstats-factor-day' => 'көн',
	'prefstats-factor-week' => 'аҙна',
	'prefstats-factor-twoweeks' => 'ике аҙна',
	'prefstats-factor-fourweeks' => 'дүрт аҙна',
	'prefstats-factor-default' => 'ғәҙәттәге дәүмәлгә ҡайтыу',
	'prefstats-legend-out' => 'Һүндергәндәр',
	'prefstats-legend-in' => 'Һайлағандар',
);

/** Belarusian (Беларуская)
 * @author Yury Tarasievich
 */
$messages['be'] = array(
	'prefstats-counters' => '* $1 {{PLURAL:$1|удзельнік|удзельнікаў}} уключылі гэтую магчымасць ад пачатку збірання статыстыкі па настаўленнях
** $2 {{PLURAL:$2|удзельнік пакінуў|удзельнікаў пакінулі}} магчымасць уключанай
** $3 {{PLURAL:$3|удзельнік адключыў|удзельнікаў адключылі}} яе пасля таго',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|удзельнік|удзельнікаў}} уключылі гэтую магчымасць ад пачатку збірання статыстыкі па настаўленнях
** $2 {{PLURAL:$2|удзельнік пакінуў|удзельнікаў пакінулі}} магчымасць уключанай
** $3 {{PLURAL:$3|удзельнік адключыў|удзельнікаў адключылі}} яе пасля таго
* Разам, $4 {{PLURAL:$4|удзельнік|удзельнікаў}} трымаюць магчымасць уключанай',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'prefstats' => 'Статыстыка наладаў удзельнікаў',
	'prefstats-desc' => 'Зьбірае статыстыку пра тое, колькі ўдзельнікаў выкарыстоўваюць пэўныя налады',
	'prefstats-title' => 'Статыстыка наладаў',
	'prefstats-list-intro' => 'Цяпер адсочваюцца наступныя налады.
Націсьніце на адну зь іх для прагляду яе статыстыкі.',
	'prefstats-noprefs' => 'У цяперашні момант ніякія налады не адсочваюцца. Устанавіце $wgPrefStatsTrackPrefs для сачэньня за наладамі.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|удзельнік уключыў|удзельнікі ўключылі|удзельнікаў уключылі}} гэтую магчымасьць з моманту актывізацыі гэтай статыстыкі
** У $2 {{PLURAL:$2|удзельніка|удзельнікаў|удзельнікаў}} яна уключаная
** У $3 {{PLURAL:$3|удзельніка|удзельнікаў|удзельнікаў}} яна выключаная',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|удзельнік уключыў|удзельнікі ўключылі|удзельнікаў уключылі}} гэтую магчымасьць з моманту актывізацыі гэтай статыстыкі
** У $2 {{PLURAL:$2|удзельніка|удзельнікаў|удзельнікаў}} яна уключаная
** У $3 {{PLURAL:$3|удзельніка|удзельнікаў|удзельнікаў}} яна выключаная
* Агулам $4 {{PLURAL:$4|удзельнік устанавіў|удзельнікі устанавілі|удзельнікаў устанавілі}} гэтую магчымасьць',
	'prefstats-xaxis' => 'Працягласьць (у гадзінах)',
	'prefstats-factors' => 'Адзінка шкалы часу: $1',
	'prefstats-factor-hour' => 'гадзіна',
	'prefstats-factor-sixhours' => 'шэсьць гадзінаў',
	'prefstats-factor-day' => 'дзень',
	'prefstats-factor-week' => 'тыдзень',
	'prefstats-factor-twoweeks' => 'два тыдні',
	'prefstats-factor-fourweeks' => 'чатыры тыдні',
	'prefstats-factor-default' => 'вярнуцца да маштабу па змоўчваньні',
	'prefstats-legend-out' => 'Пакінулі тэставаньне',
	'prefstats-legend-in' => 'Прынялі ўдзел',
);

/** Bulgarian (Български)
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'prefstats' => 'Статистики за настройките',
	'prefstats-desc' => 'На тази страница се събират статистически данни за това колко потребители са включили определени свои лични настройки',
	'prefstats-title' => 'Статистики за настройките',
	'prefstats-list-intro' => 'Понастоящем се събира информация за следните настройки.
Щракнете на някоя от настройките, за да прегледате статистиките за нея.',
	'prefstats-noprefs' => 'Понастоящем не се събира информация за настройките.
Конфигурирайте $wgPrefStatsTrackPrefs, за да започнете да събирате данни за тях.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|потребител е включил|потребители са включили}} тази настройка, откакто се събират статистики за настройките
** $2 {{PLURAL:$2|потребител продължава да я ползва|потребители продължават да я ползват}}
** $3 {{PLURAL:$3|потребител я е изключил|потребители са я изключили}} оттогава',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|потребител е включил|потребители са включили}} тази настройка, откакто се събират статистики за настройките
** $2 {{PLURAL:$2|потребител продължава да я ползва|потребители продължават да я ползват}}
** $3 {{PLURAL:$3|потребител я е изключил|потребители са я изключили}} оттогава
* Общо, $4 {{PLURAL:$4|потребител има|потребители имат}} включена тази настройка',
	'prefstats-xaxis' => 'Времетраене (в часове)',
	'prefstats-factors' => 'Преглед на интервал от $1',
	'prefstats-factor-hour' => 'един час',
	'prefstats-factor-sixhours' => 'шест часа',
	'prefstats-factor-day' => 'един ден',
	'prefstats-factor-week' => 'една седмица',
	'prefstats-factor-twoweeks' => 'две седмици',
	'prefstats-factor-fourweeks' => 'четири седмици',
	'prefstats-factor-default' => 'връщане към подразбиращия се мащаб',
);

/** Banjar (Bahasa Banjar)
 * @author J Subhi
 */
$messages['bjn'] = array(
	'prefstats-factor-hour' => 'jam',
	'prefstats-factor-sixhours' => 'anam jam',
	'prefstats-factor-day' => 'hari',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'prefstats' => 'পছন্দনীয় পরিসংখ্যান',
	'prefstats-desc' => 'পরিসংখ্যান দেখুন, কতজন ব্যবহারকারী এই পছন্দসমূহ সক্রিয় করেছেন',
	'prefstats-title' => 'পছন্দনীয় পরিসংখ্যান',
	'prefstats-list-intro' => 'বর্তমানে নিচের পছন্দগুলো অনুসরণ করা হচ্ছে।
নির্দিষ্ট কোনোটির পরিসংখ্যান জানতে যে-কোনো একটি ওপর ক্লিক করুন।',
	'prefstats-noprefs' => 'বর্তমানে কোনো পছন্দ অনুসরণ করা হচ্ছে না।
পছন্দ অনুসরণ করতে $wgPrefStatsTrackPrefs কনফিগার করুন।',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|জন ব্যবহারকারী|জন ব্যবহারকারী}} এখন পর্যন্ত পছন্দের পরিসংখ্যান কার্যরত হবার পর তা চালু করেছেন
** $2 {{PLURAL:$2|জন ব্যবহারকারীর|জন ব্যবহারকারীর}} বর্তমানেও এটি চালু রয়েছে
** $3 {{PLURAL:$3|জন ব্যবহারকারী|জন ব্যবহারকারী}} কার্যরত হবার পর থেকে তা বন্ধ রেখেছেন
* সর্বমোট, $4 {{PLURAL:$4|জন ব্যবহারকারী|জন ব্যবহারকারী}} এই পছন্দের সেট ব্যবহার করছেন',
	'prefstats-xaxis' => 'সময় (ঘন্টা)',
	'prefstats-factors' => 'প্রদর্শন করো: $1টি',
	'prefstats-factor-hour' => 'ঘন্টা',
	'prefstats-factor-sixhours' => 'ছয় ঘন্টা',
	'prefstats-factor-day' => 'দিন',
	'prefstats-factor-week' => 'সপ্তাহ',
	'prefstats-factor-twoweeks' => 'দুই সপ্তাহ',
	'prefstats-factor-fourweeks' => 'চার সপ্তাহ',
	'prefstats-factor-default' => 'পূর্ব নির্ধারিত মাপে ফিরে যাও',
	'prefstats-legend-out' => 'ত্যাগ করুন',
	'prefstats-legend-in' => 'চেষ্টা করুন',
);

/** Bishnupria Manipuri (ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী)
 * @author Usingha
 */
$messages['bpy'] = array(
	'prefstats' => 'পছনর পরিসংখ্যান',
	'prefstats-desc' => 'পরিসংখ্যান চা দিক, কুইগ আতাকুরা এরে পছনহানি থা করিসিতা',
	'prefstats-title' => 'পছনর পরিসংখ্যান',
	'prefstats-list-intro' => 'এপাগা তলর পছনহানি অনুসরন করানি অর।
লেপ্পা পরিসংখ্যান হারপিতে যে-কোনো আহানর গজে ক্লিক করিক।',
	'prefstats-noprefs' => 'এপাগা পছন অনুসরণ না কররাঙ।
পছন অনুসরণ করানির কা $wgPrefStatsTrackPrefs কনফিগার করিক।',
	'prefstats-counters' => '* $1 {{PLURAL:$1|গ আতাকুরা|গ আতাকুরা}} এবাকা পেয়া পছনর পরিসংখ্যান কামে থানার পিসে থা করানি অসে।
** $2 {{PLURAL:$2|গ আতাকুরার|গ আতাকুরার}} এবাকউ এহানই চলের হানে
** $3 {{PLURAL:$3|গ আতাকুরা|গ আতাকুরা}} কামে থানার পিসে থা নাকরিসি',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|গ আতাকুরা|গ আতাকুরা}} এবাকা পেয়া পছনর পরিসংখ্যান কামে থানার পিসে থা করানি অসে।
** $2 {{PLURAL:$2|গ আতাকুরার|গ আতাকুরার}} এবাকউ এহানই চলের হানে
** $3 {{PLURAL:$3|গ আতাকুরা|গ আতাকুরা}} কামে থানার পিসে থা নাকরিসি
* সর্বমোট, $4 {{PLURAL:$4|গ আতাকুরা|গ আতাকুরা}} এরে পছনর সেট ব্যবহার করতারা',
	'prefstats-xaxis' => 'সময় (ঘন্টা)',
	'prefstats-factors' => 'দেখাদে: $1হান',
	'prefstats-factor-hour' => 'ঘন্টা',
	'prefstats-factor-sixhours' => 'ছয় ঘন্টা',
	'prefstats-factor-day' => 'দিন',
	'prefstats-factor-week' => 'হাপ্তা',
	'prefstats-factor-twoweeks' => 'দুই হাপ্তা',
	'prefstats-factor-fourweeks' => 'চারি হাপ্তা',
	'prefstats-factor-default' => 'আগেত্ত লেপকরিসি মাপহাত আল',
	'prefstats-legend-out' => 'বেলা',
	'prefstats-legend-in' => 'হতনা কর',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'prefstats' => 'Stadegoù war ar penndibaboù',
	'prefstats-desc' => 'Stadegoù war an niver a implijerien o deus diuzet penndibaboù zo',
	'prefstats-title' => 'Stadegoù war ar penndibaboù',
	'prefstats-list-intro' => "Evit ar poent ec'h heulier an dibaboù-mañ.
Klikit war unan anezho da welet ar stadegoù stag outañ",
	'prefstats-noprefs' => 'Ne heulier dibab ebet evit ar mare. 
Kefluniañ $wgPrefStatsTrackPrefs evit heuliañ an dibaboù.',
	'prefstats-counters' => "* $1 {{PLURAL:$1|implijer en deus|implijer o deus}} gweredekaet an dibab-mañ abaoe m'eo bet gweredekaet ar stadegoù
** $2 {{PLURAL:$2|implijer en deus|implijer o deus}} gweredekaet an dibab-mañ
** $3 {{PLURAL:$3|implijer en deus|implijer o deus}} diweredekaet an dibab-mañ",
	'prefstats-counters-expensive' => "* $1 {{PLURAL:$1|implijer en deus|implijer o deus}} gweredekaet an dibab-mañ abaoe m'eo bet gweredekaet ar stadegoù
** $2 {{PLURAL:$2|implijer en deus|implijer o deus}} gweredekaet an dibab-mañ
** $3 {{PLURAL:$3|implijer en deus|implijer o deus}} diweredekaet an dibab-mañ
* En holl, $4 {{PLURAL:$4|implijer en deus|implijer o deus}} spisaet an dibab-mañ",
	'prefstats-xaxis' => 'Pad (eurvezhioù)',
	'prefstats-factors' => 'Diskouez dre : $1',
	'prefstats-factor-hour' => 'eur',
	'prefstats-factor-sixhours' => "c'hwec'h eur",
	'prefstats-factor-day' => 'deiz',
	'prefstats-factor-week' => 'sizhun',
	'prefstats-factor-twoweeks' => 'pemzektez',
	'prefstats-factor-fourweeks' => 'peder sizhun',
	'prefstats-factor-default' => "distreiñ d'ar skeul dre ziouer",
	'prefstats-legend-out' => 'Ne venn ket kemer perzh ken',
	'prefstats-legend-in' => 'A venn kemer perzh',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'prefstats' => 'Statistike postavki',
	'prefstats-desc' => 'Praćenje statistika o tome kako korisnici imaju postavljene određene postavke',
	'prefstats-title' => 'Statistike postavki',
	'prefstats-list-intro' => 'Trenutno, slijedeće postavke se prate.
Kliknite na jednu od njih da pogledate njene statistike.',
	'prefstats-noprefs' => 'Nijedna postavka se trenutno ne prati. Podesite $wgPrefStatsTrackPrefs za praćenje postavki.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|korisnik je|korisnika su|korisnika je}} omogućilo ove postavke od kako su omogućene statistike postavki
** $2 {{PLURAL:$2|korisnik još je|korisnika su još|korisnika je još}} omogućilo
** $3 {{PLURAL:$3|korisnik je|korisnika su|korisnika je}} od tada onemogućilo',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|korisnik je|korisnika su|korisnika je}} omogućilo ove postavke od kako su aktivirane statistike postavki
** $2 {{PLURAL:$2|korisnik|korisnika|korisnika}} još uvijek ima omogućene postavke
** $3 {{PLURAL:$3|korisnik|korisnika|korisnika}} je onemogućilo postavke
* Ukupno, $4 {{PLURAL:$4|korisnik|korisnika|korisnika}} ima postavljene ove postavke',
	'prefstats-xaxis' => 'Trajanje (sati)',
	'prefstats-factors' => 'Pregled prema: $1',
	'prefstats-factor-hour' => 'sat',
	'prefstats-factor-sixhours' => 'šest sati',
	'prefstats-factor-day' => 'dan',
	'prefstats-factor-week' => 'sedmica',
	'prefstats-factor-twoweeks' => 'dvije sedmice',
	'prefstats-factor-fourweeks' => 'četiri sedmice',
	'prefstats-factor-default' => 'nazad na pretpostavljenu skalu',
	'prefstats-legend-out' => 'Odjavljen',
	'prefstats-legend-in' => 'Prijavljen',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 * @author Vriullop
 */
$messages['ca'] = array(
	'prefstats' => 'Estadístiques de les preferències',
	'prefstats-desc' => 'Registra les estadístiques de quants usuaris tenen certes preferències activades',
	'prefstats-title' => 'Estadístiques de les preferències',
	'prefstats-list-intro' => "Actualment s'estan registrant les següents preferències.
Cliqueu sobre una d'elles per veure'n les seves estadístiques.",
	'prefstats-noprefs' => 'No s\'està registrant cap preferència. Configurau $wgPrefStatsTrackPrefs per registrar les preferències.',
	'prefstats-counters' => "* $1 {{PLURAL:$1|usuari ha|usuaris han}} activat aquesta preferència des que les estadístiques de preferència es van activar.
** $2 {{PLURAL:$2|usuari encara la té|usuaris encara la tenen}} activada.
** $3 {{PLURAL:$3|usuari l'ha|usuaris l'han}} desactivada des de llavors.",
	'prefstats-counters-expensive' => "* $1 {{PLURAL:$1|usuari ha|usuaris han}} activat aquesta preferència des que les estadístiques de preferència es van activar.
** $2 {{PLURAL:$2|usuari encara la té|usuaris encara la tenen}} activada.
** $3 {{PLURAL:$3|usuari l'ha|usuaris l'han}} desactivada des de llavors.
* En total, $4 {{PLURAL:$4|usuari té|usuaris tenen}} aquesta preferència activa.",
	'prefstats-xaxis' => 'Durada (hores)',
	'prefstats-factors' => 'Veure-ho segons: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'sis hores',
	'prefstats-factor-day' => 'dia',
	'prefstats-factor-week' => 'setmana',
	'prefstats-factor-twoweeks' => 'dues setmanes',
	'prefstats-factor-fourweeks' => 'quatre setmanes',
	'prefstats-factor-default' => "torna a l'escala per defecte",
	'prefstats-legend-out' => 'Desactivat',
	'prefstats-legend-in' => 'Activat',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'prefstats' => 'ГIирс латорна хилам',
	'prefstats-title' => 'ГIирс латорна хилам',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'prefstats-xaxis' => 'درێژە (کاتژمێر)',
	'prefstats-factors' => 'دیتن ھەر: $1',
	'prefstats-factor-hour' => 'کاتژمێر',
	'prefstats-factor-sixhours' => 'شەش کاتژمێر',
	'prefstats-factor-day' => 'ڕۆژ',
	'prefstats-factor-week' => 'حەوتوو',
	'prefstats-factor-twoweeks' => 'دوو حەوتوو',
	'prefstats-factor-fourweeks' => 'چوار حەوتوو',
	'prefstats-factor-default' => 'بگەڕێوە بۆ پێوەری بنەڕەت',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'prefstats' => 'Statistika nastavení',
	'prefstats-desc' => 'Statistické sledování toho, kolik uživatelů používá která nastavení',
	'prefstats-title' => 'Statistika nastavení',
	'prefstats-list-intro' => 'V současnosti se sledují následující nastavení.
Kliknutím zobrazíte příslušné statistiky.',
	'prefstats-noprefs' => 'Momentálně se nesleduje žádné nastavení. Sledování musíte nakonfigurovat v $wgPrefStatsTrackPrefs.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|uživatel si aktivoval|uživatelé si aktivovali|uživatelů si aktivovalo}} tuto volbu od zavedení statistik.
** $2 {{PLURAL:$2|uživatel si ji zapnul|uživatelé si ji zapnuli|uživatelů si ji zapnulo}}
** $3 {{PLURAL:$3|uživatel si ji vypnul|uživatelé si ji vypnuli|uživatelů si ji vypnulo}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|uživatel si aktivoval|uživatelé si aktivovali|uživatelů si aktivovalo}} tuto volbu od zavedení statistik.
** $2 {{PLURAL:$2|uživatel si ji zapnul|uživatelé si ji zapnuli|uživatelů si ji zapnulo}}
** $3 {{PLURAL:$3|uživatel si ji vypnul|uživatelé si ji vypnuli|uživatelů si ji vypnulo}}
* Celkem {{PLURAL:$4|má|mají|má}} tuto volbu nastavenu $4 {{PLURAL:$4|uživatel|uživatelé|uživatelů}}',
	'prefstats-xaxis' => 'Doba (hodin)',
	'prefstats-factors' => 'Zobrazit po: $1',
	'prefstats-factor-hour' => 'hodinách',
	'prefstats-factor-sixhours' => 'šesti hodinách',
	'prefstats-factor-day' => 'dnech',
	'prefstats-factor-week' => 'týdnech',
	'prefstats-factor-twoweeks' => 'dvou týdnech',
	'prefstats-factor-fourweeks' => 'čtyřech týdnech',
	'prefstats-factor-default' => 'zpět na základní měřítko',
	'prefstats-legend-out' => 'Odhlášení',
	'prefstats-legend-in' => 'Přihlášení',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author Omnipaedista
 * @author ОйЛ
 */
$messages['cu'] = array(
	'prefstats-factor-hour' => 'часъ',
	'prefstats-factor-sixhours' => 'шєсть часъ',
	'prefstats-factor-day' => 'дьнь',
	'prefstats-factor-week' => 'сєдмица',
	'prefstats-factor-twoweeks' => 'двѣ сєдмици',
	'prefstats-factor-fourweeks' => 'чєтꙑрє сєдмицѧ',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'prefstats' => 'Ystadegau dewisiadau',
	'prefstats-desc' => 'Dilyn ystadegau am y nifer o ddefnyddwyr sydd wedi galluogi rhai dewisiadau',
	'prefstats-title' => 'Ystadegau dewisiadau',
	'prefstats-list-intro' => 'Ar hyn o bryd, dilynir hynt y dewisiadau canlynol.
Cliciwch ar un i weld yr ystadegau amdano.',
	'prefstats-noprefs' => 'Ni ddilynir unrhyw ddewisiadau ar hyn o bryd.
Mae angen ffurfweddu $wgPrefStatsTrackPrefs er mwyn dilyn dewisiadau defnyddwyr.',
	'prefstats-counters' => "* {{PLURAL:$1|Nid oes dim defnyddwyr|Mae $1 defnyddiwr|Mae $1 ddefnyddiwr|Mae $1 defnyddiwr|Mae $1 defnyddiwr|Mae $1 o ddefnyddwyr}} wedi galluogi'r dewis hwn ers y dechreuwyd dilyn ystadegau dewisiadau.
** {{PLURAL:$2|Nid oes neb|Mae $1 defnyddiwr|Mae $1 ddefnyddiwr|Mae $1 defnyddiwr|Mae $1 defnyddiwr|Mae $1 o ddefnyddwyr}} o hyd wedi ei alluogi
*** {{PLURAL:$3|Nid oes neb|Mae $1 defnyddiwr|Mae $1 ddefnyddiwr|Mae $1 defnyddiwr|Mae $1 defnyddiwr|Mae $1 o ddefnyddwyr}} wedi ei analluogi wedi hynny",
	'prefstats-counters-expensive' => "* {{PLURAL:$1|Nid oes dim defnyddwyr|Mae $1 defnyddiwr|Mae $1 ddefnyddiwr|Mae $1 defnyddiwr|Mae $1 defnyddiwr|Mae $1 o ddefnyddwyr}} wedi galluogi'r dewis hwn ers y dechreuwyd dilyn ystadegau dewisiadau.
** {{PLURAL:$2|Nid oes neb|Mae $1 defnyddiwr|Mae $1 ddefnyddiwr|Mae $1 defnyddiwr|Mae $1 defnyddiwr|Mae $1 o ddefnyddwyr}} o hyd wedi ei alluogi
*** {{PLURAL:$3|Nid oes neb|Mae $1 defnyddiwr|Mae $1 ddefnyddiwr|Mae $1 defnyddiwr|Mae $1 defnyddiwr|Mae $1 o ddefnyddwyr}} wedi ei analluogi wedi hynny
* {{PLURAL:$4|Nid oes neb|Mae un defnyddiwr|Mae 2 ddefnyddiwr|Mae 3 defnyddiwr|Mae cyfanswm o $4 defnyddiwr|Mae cyfanswm o $4 o ddefnyddwyr}} yn defnyddio'r dewis hwn",
	'prefstats-xaxis' => 'Parhad (oriau)',
	'prefstats-factors' => 'Cyfnod y blociau ar y graff: $1',
	'prefstats-factor-hour' => 'awr',
	'prefstats-factor-sixhours' => 'chwech awr',
	'prefstats-factor-day' => 'diwrnod',
	'prefstats-factor-week' => 'wythnos',
	'prefstats-factor-twoweeks' => 'pythefnos',
	'prefstats-factor-fourweeks' => 'pedair wythnos',
	'prefstats-factor-default' => 'adfer y raddfa diofyn',
	'prefstats-legend-out' => 'Wedi tynnu allan',
	'prefstats-legend-in' => 'Wedi dewis ymuno',
);

/** Danish (Dansk)
 * @author Byrial
 */
$messages['da'] = array(
	'prefstats' => 'Statistik over indstillinger',
	'prefstats-desc' => 'Statistik over antal brugere som har bestemte indstillinger',
	'prefstats-title' => 'Statistik over indstillinger',
	'prefstats-list-intro' => 'I øjeblikket bliver følgende indstillinger sporet.
Klik på en for at se statistik om den.',
	'prefstats-noprefs' => 'Ingen ingen indstillinger bliver sporet.
Konfigurer $wgPrefStatsTrackPrefs for at spore indstillinger.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|bruger|brugere}} har aktiveret denne indstilling siden sporingen blev startet
** $2 {{PLURAL:$2|bruger|brugere}} har den stadig aktiveret
** $3 {{PLURAL:$3|bruger|brugere}} har deaktiveret den igen',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|bruger|brugere}} har aktiveret denne indstilling siden sporingen blev startet
** $2 {{PLURAL:$2|bruger|brugere}} har den stadig aktiveret
** $3 {{PLURAL:$3|bruger|brugere}} har deaktiveret den igen
* I alt har $4 {{PLURAL:$4|bruger|brugere}} indstillingen aktiv',
	'prefstats-xaxis' => 'Varighed (timer)',
	'prefstats-factors' => 'Vis per: $1',
	'prefstats-factor-hour' => 'time',
	'prefstats-factor-sixhours' => 'seks timer',
	'prefstats-factor-day' => 'dag',
	'prefstats-factor-week' => 'uge',
	'prefstats-factor-twoweeks' => 'to uger',
	'prefstats-factor-fourweeks' => 'fire uger',
	'prefstats-factor-default' => 'tilbage til standardskalering',
	'prefstats-legend-out' => 'Fravalgt',
	'prefstats-legend-in' => 'Tilvalgt',
);

/** German (Deutsch)
 * @author Imre
 * @author Kghbln
 * @author MF-Warburg
 * @author Metalhead64
 * @author Omnipaedista
 * @author Pill
 */
$messages['de'] = array(
	'prefstats' => 'Einstellungsstatistiken',
	'prefstats-desc' => 'Ermöglicht die Anzeige von Statistiken zu den einzelnen Einstellungen der Benutzer',
	'prefstats-title' => 'Einstellungsstatistiken',
	'prefstats-list-intro' => 'Derzeit werden die folgenden Einstellungen aufgezeichnet.
Klicke auf eine, um Statistiken darüber zu erhalten.',
	'prefstats-noprefs' => 'Derzeit werden keine Einstellungen verfolgt. Konfiguriere $wgPrefStatsTrackPrefs, um Einstellungen zu verfolgen.',
	'prefstats-counters' => '* $1 Benutzer {{PLURAL:$1|hat|haben}} diese Einstellung aktiviert seit Statistiken über Einstellungen erhoben werden
** $2 Benutzer {{PLURAL:$2|hat|haben}} sie aktiviert
** $3 Benutzer {{PLURAL:$3|hat|haben}} sie deaktiviert',
	'prefstats-counters-expensive' => '* $1 Benutzer {{PLURAL:$1|hat|haben}} diese Einstellung aktiviert seit Statistiken über Einstellungen erhoben werden
** $2 Benutzer {{PLURAL:$2|hat|haben}} sie aktiviert
** $3 Benutzer {{PLURAL:$3|hat|haben}} sie deaktiviert
* Insgesamt {{PLURAL:$4|hat|haben}} $4 Benutzer diese Einstellung gesetzt',
	'prefstats-xaxis' => 'Dauer (Stunden)',
	'prefstats-factors' => 'Zugriffe pro: $1',
	'prefstats-factor-hour' => 'Stunde',
	'prefstats-factor-sixhours' => 'sechs Stunden',
	'prefstats-factor-day' => 'Tag',
	'prefstats-factor-week' => 'Woche',
	'prefstats-factor-twoweeks' => 'zwei Wochen',
	'prefstats-factor-fourweeks' => 'vier Wochen',
	'prefstats-factor-default' => 'zurück zum Standard-Maßstab',
	'prefstats-legend-out' => 'Abgemeldet',
	'prefstats-legend-in' => 'Angemeldet',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 */
$messages['de-formal'] = array(
	'prefstats-list-intro' => 'Derzeit werden die folgenden Einstellungen aufgezeichnet.
Klicken Sie auf eine, um Statistiken darüber zu erhalten.',
	'prefstats-noprefs' => 'Derzeit werden keine Einstellungen verfolgt. 
Konfigurieren Sie $wgPrefStatsTrackPrefs, um Einstellungen zu verfolgen.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'prefstats' => 'istatiskê tercihi',
	'prefstats-desc' => 'Ser çend tene karber kamci terichan a kerdê înan ra îstatistikan mucneno',
	'prefstats-title' => 'istatiskê tercihi',
	'prefstats-list-intro' => 'nıka tercihê cêrıni seyr beni.
qey vinayişê istatiskê elaqedar biyayeyani bıtıknê',
	'prefstats-noprefs' => 'nıka tercihi seyr nêbeni
qey seyrkerdışê tercihani no $wgPrefStatsTrackPrefs\'i ronê/vırazê.',
	'prefstats-counters' => '* aktif biyayişê istatiskê tercihani ra nat $1 no/na {{PLURAL:$1|karber/e|karber/e}} no tercih kerdo/a aktif.
** $2 {{PLURAL:$2|karber/e|karber/e}} hema zi bı aktif şuxulneno/a
** $3 {{PLURAL:$3|karber/e|karber/e}} heta nıka pasif verdayo/a',
	'prefstats-counters-expensive' => '*aktif biyayişê istatiskê tercihani ra nat $1 no/na karber/e no tercih kerdo/a aktif. 
**$2 karber/e hema zi bı aktif şuxulneno/a 
**$3 karber/e heta nıka pasif verdayo/a 
*pêro piya, ındek/honde $4 {{PLURAL:$4|karber/e|karber/e}} no tercihi eyar kerd',
	'prefstats-xaxis' => 'wext (saat)',
	'prefstats-factors' => 'amarê ra motışi: $1',
	'prefstats-factor-hour' => 'saat',
	'prefstats-factor-sixhours' => 'şeş seet',
	'prefstats-factor-day' => 'roc',
	'prefstats-factor-week' => 'hefte',
	'prefstats-factor-twoweeks' => 'dı hefte',
	'prefstats-factor-fourweeks' => 'çar hefte',
	'prefstats-factor-default' => 'agêr peymawıtışo hesebyaye',
	'prefstats-legend-out' => 'cay o ke diyo kışt',
	'prefstats-legend-in' => 'musteşrik',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'prefstats' => 'Statistika nastajenjow',
	'prefstats-desc' => 'Statistice slědowaś, wjele wužywarjow jo wěste nastajenja zmóžniło',
	'prefstats-title' => 'Statistika nastajenjow',
	'prefstats-list-intro' => 'Tuchylu se slědujuce nastajenja slěduju.
Klikni na jadne z nich, aby se statistiku wó nim woglědał.',
	'prefstats-noprefs' => 'Tuchylu žedne nastajenja se slěduju. Konfigurěruj $wgPrefStatsTrackPrefs, aby nastajenja slědował.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|wužywaŕ jo|wužywarja stej|wužywarje su|wužywarjow jo}} toś to nastajenje {{PLURAL:$1|zmóžnił|zmóžniłej|zmóžnili|zmóžniło}}, wót togo, až statistika nastajenjow jo se aktiwěrowała
** $2 {{PLURAL:$2|wužywaŕ jo|wužywarja stej|wužywarje su|wužywarjow jo}} jo {{PLURAL:$2|zmóžnił|zmóžniłej|zmóžnili|zmóžniło}}
** $3 {{PLURAL:$3|wužywaŕ jo|wužywarja stej|wužywarje su|wužywarjow jo}} jo {{PLURAL:$3|znjemóžnił|znjemóžniłej|znjemóžnili|znjemóžniło}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|wužywaŕ jo|wužywarja stej|wužywarje su|wužywarjow jo}} toś to nastajenje {{PLURAL:$1|zmóžnił|zmóžniłej|zmóžnili|zmóžniło}}, wót togo, až statistika nastajenjow jo se aktiwěrowała
** $2 {{PLURAL:$2|wužywaŕ jo|wužywarja stej|wužywarje su|wužywarjow jo}} jo {{PLURAL:$2|zmóžnił|zmóžniłej|zmóžnili|zmóžniło}}
** $3 {{PLURAL:$3|wužywaŕ jo|wužywarja stej|wužywarje su|wužywarjow jo}} jo {{PLURAL:$3|znjemóžnił|znjemóžniłej|znjemóžnili|znjemóžniło}}
*Dogromady $4 {{PLURAL:$4|wužywaŕ jo|wužywarja stej|wužywarje su|wužywarjow jo}} toś to nastajenje {{PLURAL:$4|stajił|stajiłej|stajili|stajiło}}',
	'prefstats-xaxis' => 'Cas (goźiny)',
	'prefstats-factors' => 'Naglěd za: $1',
	'prefstats-factor-hour' => 'góźinu',
	'prefstats-factor-sixhours' => 'šesć góźinow',
	'prefstats-factor-day' => 'źeń',
	'prefstats-factor-week' => 'tyźeń',
	'prefstats-factor-twoweeks' => 'dwa tyźenja',
	'prefstats-factor-fourweeks' => 'styri tyźenje',
	'prefstats-factor-default' => 'slědk k standardnemu měritkoju',
	'prefstats-legend-out' => 'Wótzjawjony',
	'prefstats-legend-in' => 'Pśizjawjony',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'prefstats-xaxis' => 'Ɣeyiɣi (gaƒoƒowo)',
	'prefstats-factor-hour' => 'gaƒoƒo',
	'prefstats-factor-sixhours' => 'gaƒoƒo ade',
	'prefstats-factor-day' => 'ŋkeke',
	'prefstats-factor-week' => 'kɔsiɖa',
	'prefstats-factor-twoweeks' => 'kɔsiɖa eve',
	'prefstats-factor-fourweeks' => 'kɔsiɖa ene',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'prefstats' => 'Στατιστικά προτιμήσεων',
	'prefstats-desc' => 'Παρακολούθηση στατιστικών για το πόσοι χρήστες έχουν ενεργοποιημένες συγκεκριμένες προτιμήσεις',
	'prefstats-title' => 'Στατιστικά προτιμήσεων',
	'prefstats-list-intro' => 'Τώρα, οι παρακάτω προτιμήσεις παρακολουθούνται.
Κάντε "κλικ" σε μια για να δείτε τα στατιστικά για αυτή.',
	'prefstats-noprefs' => 'Αυτή τη στιγμή δεν παρακολουθούνται καθόλου προτιμήσεις.
Διαμορφώστε το $wgPrefStatsTrackPrefs για να παρακολουθήσετε τις προτιμήσεις.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|χρήστης έχει|χρήστες έχουν}} ενεργοποιήσει αυτήν την προτίμηση από τότε που τα στατιστικά προτίμησης ενεργοποιήθηκαν
** $2 {{PLURAL:$2|χρήστης ακόμη το έχει|χρήστες ακόμα το έχουν}} ενεργοποιημένο
** $3 {{PLURAL:$3|χρήστης το έχει|χρήστες το έχουν}} απενεργοποιήσει από τότε',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|ο χρήστης έχει|οι χρήστες έχουν}} ενεργοποιήσει αυτήν την προτίμηση από τότε που τα στατιστικά προτίμησης ενεργοποιήθηκαν
** $2 {{PLURAL:$2|ο χρήστης ακόμη το έχει|οι χρήστες ακόμα το έχουν}} ενεργοποιημένο
** $3 {{PLURAL:$3|ο χρήστης το έχει|οι χρήστες το έχουν}} απενεργοποιήσει από τότε
* Συνολικά, $4 {{PLURAL:$4|ο χρήστης έχει|οι χρήστες έχουν}} θέσει αυτήν την προτίμηση',
	'prefstats-xaxis' => 'Διάρκεια (ώρες)',
	'prefstats-factors' => 'Εμφάνιση ανά: $1',
	'prefstats-factor-hour' => 'ώρα',
	'prefstats-factor-sixhours' => 'έξι ώρες',
	'prefstats-factor-day' => 'ημέρα',
	'prefstats-factor-week' => 'εβδομάδα',
	'prefstats-factor-twoweeks' => 'δύο εβδομάδες',
	'prefstats-factor-fourweeks' => 'τέσσερις εβδομάδες',
	'prefstats-factor-default' => 'πίσω στην προεπιλεγμένη κλίμακα',
	'prefstats-legend-out' => 'Μη συμμετοχή',
	'prefstats-legend-in' => 'Συμμετοχή',
);

/** Esperanto (Esperanto)
 * @author AVRS
 * @author Yekrats
 */
$messages['eo'] = array(
	'prefstats' => 'Statistikoj pri preferoj',
	'prefstats-desc' => 'Atenti statistikojn pri kiom da uzantoj ŝaltas certajn agordojn',
	'prefstats-title' => 'Statistikoj pri preferoj',
	'prefstats-list-intro' => 'Nune, la jenaj agordoj estas atentitaj.
Klaku por vidi statistikojn pri ĝi.',
	'prefstats-noprefs' => 'Neniuj preferoj estas nune sekvita.
Konfiguru $wgPrefStatsTrackPrefs por sekvi preferojn.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|uzanto|uzantoj}} ŝaltis ĉi tiun preferon ekde statistikoj pri preferoj aktiviĝis
** $2 {{PLURAL:$2|uzanto|uzantoj}} plu havas ĝin ŝaltita
** $3 {{PLURAL:$3|uzanto|uzantoj}} malŝaltis ĝin',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|uzanto|uzantoj}} ŝaltis ĉi tiun preferon ekde statistikoj pri preferoj aktiviĝis
** $2 {{PLURAL:$2|uzanto|uzantoj}} plu havas ĝin ŝaltita
** $3 {{PLURAL:$3|uzanto|uzantoj}} malŝaltis ĝin
* Sume, $4 {{PLURAL:$4|uzanto|uzantoj}} uzas ĉi tiun preferon.',
	'prefstats-xaxis' => 'Daŭro (horoj)',
	'prefstats-factors' => 'Vidi laŭ: $1',
	'prefstats-factor-hour' => 'horo',
	'prefstats-factor-sixhours' => 'ses horoj',
	'prefstats-factor-day' => 'tago',
	'prefstats-factor-week' => 'semajno',
	'prefstats-factor-twoweeks' => 'du semajnoj',
	'prefstats-factor-fourweeks' => 'kvar semajnoj',
	'prefstats-factor-default' => 'reuzi defaŭltan skalon',
	'prefstats-legend-out' => 'Elektis ne partopreni',
	'prefstats-legend-in' => 'Elektis partopreni',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Dalton2
 * @author Imre
 * @author Locos epraix
 * @author Omnipaedista
 */
$messages['es'] = array(
	'prefstats' => 'Estadísticas de preferencias',
	'prefstats-desc' => 'Seguimiento de las estadísticas sobre cuántos usuarios tienen ciertas preferencias habilitadas',
	'prefstats-title' => 'Estadísticas de preferencias',
	'prefstats-list-intro' => 'De momento, se están siguiendo las siguientes preferencias.
Seleccione una para ver estadísticas acerca de ella.',
	'prefstats-noprefs' => 'No se han establecido preferencias.
Configure $wgPrefStatsTrackPrefs para establecerlas.',
	'prefstats-counters' => '* $1  {{PLURAL:$1|usuario ha|usuarios han}} activado esta preferencia desde que la estadística fue activada.
** $2  {{PLURAL:$2|usuario aún tiene|usuarios aún tienen}} esta preferencia activada.
** $3  {{PLURAL:$1|usuario la ha|usuarios la han}} desactivado.',
	'prefstats-counters-expensive' => '* $1  {{PLURAL:$1|usuario ha|usuarios han}} activado esta preferencia desde el inicio de la estadística de preferencias.
** $2 {{PLURAL:$2|usuario todavía la mantiene|usuarios todavía la mantienen}} activada.
** $3 {{PLURAL:$3|usuario la ha|usuarios la han}} desactivado.
* En total $4 {{PLURAL:$4|usuario ha|usuarios han}} utilizado esta preferencia.',
	'prefstats-xaxis' => 'Duración (horas)',
	'prefstats-factors' => 'Vista por: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'seis horas',
	'prefstats-factor-day' => 'día',
	'prefstats-factor-week' => 'semana',
	'prefstats-factor-twoweeks' => 'dos semanas',
	'prefstats-factor-fourweeks' => 'cuatro semanas',
	'prefstats-factor-default' => 'regresar a la escala por defecto',
	'prefstats-legend-out' => 'Desactivado',
	'prefstats-legend-in' => 'Activado',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'prefstats' => 'Eelistuste arvandmed',
	'prefstats-desc' => 'Kogub arvandmeid kindlate eelistuste kasutatavuse kohta.',
	'prefstats-title' => 'Eelistuste arvandmed',
	'prefstats-list-intro' => 'Parajasti jälgitakse järgmisi eelistusi. Klõpsa ühel, et näha selle arvandmeid.',
	'prefstats-noprefs' => 'Ühtegi eelistust ei jälgita parajasti.
Eelistuse jälgimiseks redigeeri muutujat $wgPrefStatsTrackPrefs.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|kasutaja|kasutajat}} on alates eelistuse jälgimahakust selle eelistuse kasutusele võtnud
** $2 {{PLURAL:$2|kasutaja kasutab|kasutajat kasutavad}} seda endiselt
** $3 {{PLURAL:$3|kasutaja|kasutajat}} on sellest loobunud',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|kasutaja|kasutajat}} on alates eelistuse jälgimahakust selle eelistuse kasutusele võtnud
** $2 {{PLURAL:$2|kasutaja kasutab|kasutajat kasutavad}} seda endiselt
** $3 {{PLURAL:$3|kasutaja|kasutajat}} on sellest loobunud
* Kokku kasutab seda eelistust $4 {{PLURAL:$4|kasutaja|kasutajat}}.',
	'prefstats-xaxis' => 'Kestus (tundides)',
	'prefstats-factors' => 'Astmiku jaotis: $1',
	'prefstats-factor-hour' => 'tund',
	'prefstats-factor-sixhours' => 'kuus tundi',
	'prefstats-factor-day' => 'päev',
	'prefstats-factor-week' => 'nädal',
	'prefstats-factor-twoweeks' => 'kaks nädalat',
	'prefstats-factor-fourweeks' => 'neli nädalat',
	'prefstats-factor-default' => 'vaikeastmik',
	'prefstats-legend-out' => 'Loobunud',
	'prefstats-legend-in' => 'Kasutanud',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Joxemai
 * @author Theklan
 */
$messages['eu'] = array(
	'prefstats' => 'Hobespen estatistikak',
	'prefstats-desc' => 'Bilatu estatistikak, hobespen zehatzak indarrean dituzten lankideak zenbat diren jasotzen dutenak',
	'prefstats-title' => 'Hobespen estatistikak',
	'prefstats-list-intro' => 'Une honetan, ondorengo hobespenak jarraitzen ari dira.
Klikatu batean bere estatistikak ikusteko.',
	'prefstats-noprefs' => 'Ez dago hobespenik jarraipen zerrendan.
Konfiguratu $wgPrefStatsTrackPrefs hobespenak jarraitzeko.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|lankide batek gaitu du|lankideek gaitu dute}} hobespen hau hobespen-estatistikak martxan jarri zirenetik
** $2 {{PLURAL:$2|lankide batek gaituta du|lankideek gaituta dute}} oraindik
** $3 {{PLURAL:$3|lankide batek ezgaitu du|lankideek ezgaitu dute}} ordutik',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|lankide batek gaitu du|lankideek gaitu dute}} hobespen hau hobespen-estatistikak martxan jarri zirenetik
** $2 {{PLURAL:$2|lankide batek gaituta du|lankideek gaituta dute}} oraindik
** $3 {{PLURAL:$3|lankide batek ezgaitu du|lankideek ezgaitu dute}} ordutik
* Guztira, $4 {{PLURAL:$4|lankide batek du martxan|lankideek dute martxan}} hobespen hau',
	'prefstats-xaxis' => 'Iraupena (ordutan)',
	'prefstats-factors' => 'Ikusi: $1',
	'prefstats-factor-hour' => 'ordu',
	'prefstats-factor-sixhours' => 'sei ordu',
	'prefstats-factor-day' => 'egun',
	'prefstats-factor-week' => 'aste',
	'prefstats-factor-twoweeks' => 'bi aste',
	'prefstats-factor-fourweeks' => 'lau aste',
	'prefstats-factor-default' => 'itzuli berezko eskalara',
	'prefstats-legend-out' => 'Irten zara',
	'prefstats-legend-in' => 'Bat egin duzu',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Ladsgroup
 * @author Mardetanha
 * @author Sahim
 * @author Wayiran
 */
$messages['fa'] = array(
	'prefstats' => 'آمار ترجیحات',
	'prefstats-desc' => 'درباره چگونگی بدست آوردن آمار ردپاهای کاربران که مطمئنا باید تنظیمات خاصی انجام شود.',
	'prefstats-title' => 'آمار ترجیحات',
	'prefstats-list-intro' => 'هم‌اکنون، ترجیحات زیر در حال ردگیری هستند.
برای دیدن آمار مرتبط، بروی یکی‌شان کلیک کنید.',
	'prefstats-noprefs' => '‏‫در حال حال حاضر ترجیحات ردگیری نمی‌شوند.
$wgPrefStatsTrackPrefs را تنظیم کنید تا ترجیحات ردگیری شوند.',
	'prefstats-counters' => '* از هنگامی که آمار ترجیح به کار انداخته شده، $1 کاربر این ترجیح را فعال کرده‌اند.
**$2 کاربر هنوز آن را فعال دارند
**$3 کاربر از آن هنگام آن را غیرفعال کرده‌اند',
	'prefstats-counters-expensive' => '* از هنگامی که آمار ترجیح به کار انداخته شده، $1 کاربر این ترجیح را فعال کرده‌اند.
**$2 کاربر هنوز آن را فعال دارند
**$3 کاربر از آن هنگام آن را غیرفعال کرده‌اند
*در کل، $4 کاربر این ترجیح را تنظیم‌شده دارند',
	'prefstats-xaxis' => 'مدت زمان (ساعت)',
	'prefstats-factors' => 'نمایش برای هر: $1',
	'prefstats-factor-hour' => 'ساعت',
	'prefstats-factor-sixhours' => 'شش ساعت',
	'prefstats-factor-day' => 'روز',
	'prefstats-factor-week' => 'هفته',
	'prefstats-factor-twoweeks' => 'دو هفته',
	'prefstats-factor-fourweeks' => 'چهار هفته',
	'prefstats-factor-default' => 'بازگشت به مقیاس پیش‌فرض',
	'prefstats-legend-out' => 'تصمیم گرفتند از',
	'prefstats-legend-in' => 'برگزیده در',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'prefstats' => 'Asetustilastot',
	'prefstats-desc' => 'Kerää tilastoja siitä, kuinka moni käyttäjä on ottanut käyttöön erinäiset asetukset.',
	'prefstats-title' => 'Asetustilastot',
	'prefstats-list-intro' => 'Tällä hetkellä seuraavia asetuksia seurataan.
Tilastot näkyvät painamalla asetusta.',
	'prefstats-noprefs' => 'Yhtään asetusta ei seurata tällä hetkellä.
Aseta $wgPrefStatsTrackPrefs asetusten seuraamiseksi.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|käyttäjä|käyttäjää}} on ottanut tämän asetuksen käyttöön asetustilastojen käyttöönoton jälkeen
** $2 käyttäjällä on se edelleen käytössä
** $3 {{PLURAL:$3|käyttäjä|käyttäjää}} on poistanut sen käytöstä sen jälkeen',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|käyttäjä|käyttäjää}} on ottanut tämän asetuksen käyttöön asetustilastojen käyttöönoton jälkeen
** $2 käyttäjällä on se edelleen käytössä
** $3 {{PLURAL:$3|käyttäjä|käyttäjää}} on poistanut sen käytöstä sen jälkeen
* Yhteensä $4 käyttäjällä on tämä asetus käytössä',
	'prefstats-xaxis' => 'Kesto (tuntia)',
	'prefstats-factors' => 'Järjestä: $1',
	'prefstats-factor-hour' => 'tunti',
	'prefstats-factor-sixhours' => 'kuusi tuntia',
	'prefstats-factor-day' => 'päivä',
	'prefstats-factor-week' => 'viikko',
	'prefstats-factor-twoweeks' => 'kaksi viikkoa',
	'prefstats-factor-fourweeks' => 'neljä viikkoa',
	'prefstats-factor-default' => 'takaisin oletusmittakaavaan',
	'prefstats-legend-out' => 'Poistunut',
	'prefstats-legend-in' => 'Liittynyt',
);

/** Faroese (Føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'prefstats-xaxis' => 'Varir (tímar)',
	'prefstats-factors' => 'Vís per: $1',
	'prefstats-factor-hour' => 'tími',
	'prefstats-factor-sixhours' => 'seks tímar',
	'prefstats-factor-day' => 'dagur',
	'prefstats-factor-week' => 'vika',
	'prefstats-factor-twoweeks' => 'tvær vikur',
	'prefstats-factor-fourweeks' => 'fýra vikur',
	'prefstats-legend-out' => 'Valt frá',
	'prefstats-legend-in' => 'Valt til',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Kropotkine 113
 * @author Omnipaedista
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'prefstats' => 'Statistiques des préférences',
	'prefstats-desc' => 'Statistiques sur le nombre d’utilisateurs ayant certaines préférences activées',
	'prefstats-title' => 'Statistiques des préférences',
	'prefstats-list-intro' => 'En ce moment, les préférences suivantes sont suivies.
Cliquez sur l’une d’entre elles pour voir les statistiques à son propos.',
	'prefstats-noprefs' => 'Aucune préférence n’est actuellement suivie. Configurer $wgPrefStatsTrackPrefs pour suivre des préférences.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|utilisateur a|utilisateurs ont}} activé cette préférence depuis que les statistiques de préférences ont été activées
** $2 {{PLURAL:$2|utilisateur a|utilisateurs ont}} activé cette préférence
** $3 {{PLURAL:$3|utilisateur a|utilisateurs ont}} désactivé cette préférence',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|utilisateur a|utilisateurs ont}} activé cette préférence depuis que les statistiques de préférences ont été activées
** $2 {{PLURAL:$2|utilisateur a|utilisateurs ont}} activé cette préférence
** $3 {{PLURAL:$3|utilisateur a|utilisateurs ont}} désactivé cette préférence
* Au total, $4 {{PLURAL:$4|utilisateur a|utilisateurs ont}} défini cette préférence',
	'prefstats-xaxis' => 'Durée (heures)',
	'prefstats-factors' => 'Afficher par : $1',
	'prefstats-factor-hour' => 'heure',
	'prefstats-factor-sixhours' => 'six heures',
	'prefstats-factor-day' => 'jour',
	'prefstats-factor-week' => 'semaine',
	'prefstats-factor-twoweeks' => 'deux semaines',
	'prefstats-factor-fourweeks' => 'quatre semaines',
	'prefstats-factor-default' => 'revenir à l’échelle par défaut',
	'prefstats-legend-out' => 'Ne veut plus participer',
	'prefstats-legend-in' => 'Veut participer',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'prefstats' => 'Statistiques de les prèferences',
	'prefstats-desc' => 'Statistiques sur lo nombro d’usanciérs qu’ont quârques prèferences activâs.',
	'prefstats-title' => 'Statistiques de les prèferences',
	'prefstats-list-intro' => 'Ora, cetes prèferences sont siuvues.
Clicâd dessus yona d’entre-lor por vêre les statistiques a son propôs.',
	'prefstats-noprefs' => 'Ora, niona prèference est siuvua.
Configurâd $wgPrefStatsTrackPrefs por siuvre des prèferences.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|usanciér a|usanciérs on}}t activâ ceta prèference dês que les statistiques de prèferences ont étâ activâs
** $2 {{PLURAL:$2|usanciér l’a|usanciérs l’on}}t adés activâ
** $3 {{PLURAL:$3|usanciér l’a|usanciérs l’on}}t dèsactivâ',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|usanciér a|usanciérs on}}t activâ ceta prèference dês que les statistiques de prèferences ont étâ activâs
** $2 {{PLURAL:$2|usanciér l’a|usanciérs l’on}}t adés activâ
** $3 {{PLURAL:$3|usanciér l’a|usanciérs l’on}}t dèsactivâ
* En tot, $4 {{PLURAL:$4|usanciér a|usanciérs on}}t dèfeni ceta prèference',
	'prefstats-xaxis' => 'Temps (hores)',
	'prefstats-factors' => 'Fâre vêre per : $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'siéx hores',
	'prefstats-factor-day' => 'jorn',
	'prefstats-factor-week' => 'semana',
	'prefstats-factor-twoweeks' => 'doves semanes',
	'prefstats-factor-fourweeks' => 'quatro semanes',
	'prefstats-factor-default' => 'tornar a l’èchiéla per dèfôt',
	'prefstats-legend-out' => 'Vôt pas més participar',
	'prefstats-legend-in' => 'Vôt participar',
);

/** Scottish Gaelic (Gàidhlig)
 * @author Akerbeltz
 */
$messages['gd'] = array(
	'prefstats' => 'Staitistearachd nan roghainnean',
	'prefstats-desc' => "Cum sùil air an staitistearachd a dh'innseas dhut cò mheud cleachdaiche a tha a' cleachdadh a leithid seo de dh'fheart",
	'prefstats-title' => 'Staitistearachd nan roghainnean',
	'prefstats-list-intro' => "Tha thu a' cumail sùil air staitistearachd na leanas.
Briog air aonan dhiubh gus a chuid staitistearachd fhaicinn.",
	'prefstats-noprefs' => 'Chan eil thu a\' cumail sùil air staitistearachd sam bith.
Deasaich $wgPrefStatsTrackPrefs gus sùil a chumail air roghainnean.',
	'prefstats-counters' => '* Chuir $1 {{PLURAL:$1|chleachdaiche|chleachdaiche|chleachdaiche|chleachdaiche|cleachdaichean|cleachdaiche}} an roghainn seo an comas on a chaidh stadastaireachd na roghainnean a chur an gnìomh. 
** Tha e beò aig $2 {{PLURAL:$2|chleachdaiche|chleachdaiche|chleachdaiche|chleachdaiche|cleachdaichean|cleachdaiche}} fhathast
** Chuir $3 {{PLURAL:$3|chleachdaiche|chleachdaiche|chleachdaiche|chleachdaiche|cleachdaichean|cleachdaiche}} à comas e on uairsin',
	'prefstats-counters-expensive' => '* Chuir $1 {{PLURAL:$1|chleachdaiche|chleachdaiche|chleachdaiche|chleachdaiche|cleachdaichean|cleachdaiche}} an roghainn seo an comas on a chaidh stadastaireachd na roghainnean a chur an gnìomh. 
** Tha e beò aig $2 {{PLURAL:$2|chleachdaiche|chleachdaiche|chleachdaiche|chleachdaiche|cleachdaichean|cleachdaiche}} fhathast
** Chuir $3 {{PLURAL:$3|chleachdaiche|chleachdaiche|chleachdaiche|chleachdaiche|cleachdaichean|cleachdaiche}} à comas e on uairsin
* Tha an roghainn seo aig $4 {{PLURAL:$4|chleachdaiche|chleachdaiche|chleachdaiche|chleachdaiche|cleachdaichean|cleachdaiche}} uile gu lèir',
	'prefstats-xaxis' => 'Faid (uairean a thìde)',
	'prefstats-factors' => 'Seall gach: $1',
	'prefstats-factor-hour' => 'uair a thìde',
	'prefstats-factor-sixhours' => 'sia uairean a thìde',
	'prefstats-factor-day' => 'latha',
	'prefstats-factor-week' => 'seachdain',
	'prefstats-factor-twoweeks' => 'dà sheachdain',
	'prefstats-factor-fourweeks' => 'ceithir seachdainean',
	'prefstats-factor-default' => 'air ais dhan sgèile bhunaiteach',
	'prefstats-legend-out' => 'Air a dhiùltadh',
	'prefstats-legend-in' => 'Air gabhail ris',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'prefstats' => 'Estatísticas das preferencias',
	'prefstats-desc' => 'Segue as estatísticas sobre cantos usuarios teñen determinadas preferencias activadas',
	'prefstats-title' => 'Estatísticas das preferencias',
	'prefstats-list-intro' => 'Actualmente estanse a seguir as seguintes preferencias.
Prema sobre unha para ver as estatísticas sobre ela.',
	'prefstats-noprefs' => 'Actualmente non se segue preferencia algunha. Configure $wgPrefStatsTrackPrefs para seguir preferencias.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|usuario ten|usuarios teñen}} activada esta preferencia des que as estatísticas de preferencias foron activadas
** $2 {{PLURAL:$2|usuario aínda a ten|usuarios aínda a teñen}} activada
** $3 {{PLURAL:$3|usuario tena|usuarios téñena}} desactivada',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|usuario ten|usuarios teñen}} activada esta preferencia des que as estatísticas de preferencias foron activadas
** $2 {{PLURAL:$2|usuario aínda a ten|usuarios aínda a teñen}} activada
** $3 {{PLURAL:$3|usuario tena|usuarios téñena}} desactivada
* En total, $4 {{PLURAL:$4|usuario ten|usuarios teñen}} definida esta preferencia',
	'prefstats-xaxis' => 'Duración (horas)',
	'prefstats-factors' => 'Vista por: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'seis horas',
	'prefstats-factor-day' => 'día',
	'prefstats-factor-week' => 'semana',
	'prefstats-factor-twoweeks' => 'dúas semanas',
	'prefstats-factor-fourweeks' => 'catro semanas',
	'prefstats-factor-default' => 'volver á escala por defecto',
	'prefstats-legend-out' => 'Deixou de participar',
	'prefstats-legend-in' => 'Quixo participar',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'prefstats' => 'Στατιστικὰ προτιμήσεων',
	'prefstats-desc' => 'Παρακολουθεῖν τὰ στατιστικὰ περὶ τοῦ ἀριθμοῦ χρωμένων οἵπερ ἔχουσιν ἐνεργοποιημένας συγκεκριμένας προτιμήσεις',
	'prefstats-title' => 'Στατιστικὰ προτιμήσεων',
	'prefstats-xaxis' => 'Διάρκεια (ὧραι)',
	'prefstats-factors' => 'Προβάλλειν ἀνά: $1',
	'prefstats-factor-hour' => 'ὥρα',
	'prefstats-factor-sixhours' => 'ἓξ ὧραι',
	'prefstats-factor-day' => 'ἡμέρα',
	'prefstats-factor-week' => 'ἑβδομάς',
	'prefstats-factor-twoweeks' => 'δύο ἑβδομάδες',
	'prefstats-factor-fourweeks' => 'τέσσαρες ἑβδομάδες',
	'prefstats-factor-default' => 'ὀπίσω εἰς τὴν προεπειλεγμένην κλίμακα',
	'prefstats-legend-out' => 'Μὴ συμμετοχή',
	'prefstats-legend-in' => 'Συμμετοχή',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Purodha
 */
$messages['gsw'] = array(
	'prefstats' => 'Prioritäte-Statischtik',
	'prefstats-desc' => 'Statischtik wievil Benutzer di sichere Yystellige meglig gmacht hän',
	'prefstats-title' => 'Priorotätestatischtik',
	'prefstats-list-intro' => 'Zur Zyt wäre die Prioritäte verfolgt.
Druck uf eini go Statischtike iber si aaluege.',
	'prefstats-noprefs' => 'Bis jetz wäre kei Yystellige verfolgt. Konfigurier $wgPrefStatsTrackPrefs go Yystellige verfolge.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|Benutzer het|Benutzer hän}} die Yystellig megli gmacht syt d Yystelligsstatischtike aktiviert wore sin
** $2 {{PLURAL:$2|Benutzer het|Benutzer hän}} si megli gmacht
** $3 {{PLURAL:$3|Benutzer het|Benutzer hän}} si abgstellt',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|Benutzer het|Benutzer hän}} die Yystellig megli gmacht syt d Yystelligsstatischtike aktiviert wore sin
** $2 {{PLURAL:$2|Benutzer het|Benutzer hän}} si megli gmacht
** $3 {{PLURAL:$3|Benutzer het|Benutzer hän}} si abgstellt
* $4 {{PLURAL:$4|Benutzer het si insgsamt|Benutzer hän si insgsamt}} die Yystellig megli gmacht',
	'prefstats-xaxis' => 'Duur (Stunde)',
	'prefstats-factors' => 'Aaluege fir: $1',
	'prefstats-factor-hour' => 'Stund',
	'prefstats-factor-sixhours' => 'segs Stunde',
	'prefstats-factor-day' => 'Tag',
	'prefstats-factor-week' => 'Wuche',
	'prefstats-factor-twoweeks' => 'Zwo Wuche',
	'prefstats-factor-fourweeks' => 'Vier Wuche',
	'prefstats-factor-default' => 'Zruck zur dr Standardskala',
	'prefstats-legend-out' => 'Abgmäldet',
	'prefstats-legend-in' => 'Aagmäldet',
);

/** Gujarati (ગુજરાતી)
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'prefstats' => 'પ્રાથમિકતા આંકડા',
	'prefstats-title' => 'પ્રાથમિકતા આંકડાઓ',
	'prefstats-xaxis' => 'અવધિ (કલાકો)',
	'prefstats-factors' => 'સંખ્યા પ્રતિ : $1',
	'prefstats-factor-hour' => 'કલાક',
	'prefstats-factor-sixhours' => 'છ કલાકો',
	'prefstats-factor-day' => 'દિવસ',
	'prefstats-factor-week' => 'અઠવાડિયું',
	'prefstats-factor-twoweeks' => 'બે અઠવાડિયાં',
	'prefstats-factor-fourweeks' => 'ચાર અઠવાડિયાં',
	'prefstats-factor-default' => 'મૂળભૂત પ્રમાણ પર પાછા જાવ',
	'prefstats-legend-out' => 'બહાર નીકળવાનું પસંદ કર્યું',
	'prefstats-legend-in' => 'અંદર આવવાનું પસંદ કર્યું',
);

/** Manx (Gaelg)
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'prefstats' => 'Earroo tosheeaghtyn',
	'prefstats-desc' => "Freill arrey er quoid ymmydeyryn t'er reih tosheeaghtyn ennagh",
	'prefstats-title' => 'Earrooyn er tosheeaghtyn',
	'prefstats-factor-hour' => 'oor',
	'prefstats-factor-sixhours' => 'shey ooryn',
	'prefstats-factor-day' => 'laa',
	'prefstats-factor-week' => 'shiaghtin',
	'prefstats-factor-twoweeks' => 'daa hiaghtin',
	'prefstats-factor-fourweeks' => 'kiare shiaghteeyn',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'prefstats' => 'סטטיסטיקת העדפות',
	'prefstats-desc' => 'בדיקה כמה משתמשים הפעילו העדפה מסוימת',
	'prefstats-title' => 'סטטיסטיקת העדפות',
	'prefstats-list-intro' => 'כרגע, ההעדפות הבאות נמצאות במעקב.
לחצו על אחת כדי לצפות בסטטיסטיקות אודותיה.',
	'prefstats-noprefs' => 'נכון לעכשיו לא מתבצע מעקב אחר העדפות. יש להגדיר את $wgPrefStatsTrackPrefs כדי לעקוב אחר העדפות.',
	'prefstats-counters' => '* {{PLURAL:$1|משתמש אחד הפעיל|$1 משתמשים הפעילו}} העדפה זו מאז שהופעלו סטטיסטיקות ההעדפות
** {{PLURAL:$2|משתמש אחד השאיר|$2 משתמשים השאירו}} אותה מופעלת
** {{PLURAL:$3|משתמש אחד ביטל|$3 משתמשים ביטלו}} אותה מאז',
	'prefstats-counters-expensive' => '* {{PLURAL:$1|משתמש אחד הפעיל|$1 משתמשים הפעילו}} העדפה זו מאז שהופעלו סטטיסטיקות ההעדפות
** {{PLURAL:$2|משתמש אחד השאיר|$2 משתמשים השאירו}} אותה מופעלת
** {{PLURAL:$3|משתמש אחד ביטל|$3 משתמשים ביטלו}} אותה מאז
* בסך הכול, תכונה זו מופעלת אצל {{PLURAL:$4|משתמש אחד|$4 משתמשים}}',
	'prefstats-xaxis' => 'משך (בשעות)',
	'prefstats-factors' => 'צפייה לפי: $1',
	'prefstats-factor-hour' => 'שעה',
	'prefstats-factor-sixhours' => 'שש שעות',
	'prefstats-factor-day' => 'יום',
	'prefstats-factor-week' => 'שבוע',
	'prefstats-factor-twoweeks' => 'שבועיים',
	'prefstats-factor-fourweeks' => 'ארבעה שבועות',
	'prefstats-factor-default' => 'חזרה למימדי ברירת המחדל',
	'prefstats-legend-out' => 'ביטול ההעדפה',
	'prefstats-legend-in' => 'הפעלת ההעדפה',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'prefstats' => 'वरीयता के आँकड़े',
	'prefstats-title' => 'पसंद आँकड़े',
	'prefstats-xaxis' => 'अवधि (घंटे)',
	'prefstats-factors' => 'दृश्य प्रति: $1',
	'prefstats-factor-hour' => 'घंटे',
	'prefstats-factor-sixhours' => 'छह घंटे',
	'prefstats-factor-day' => 'दिन',
	'prefstats-factor-week' => 'सप्ताह',
	'prefstats-factor-twoweeks' => 'दो सप्ताह',
	'prefstats-factor-fourweeks' => 'चार सप्ताह',
	'prefstats-factor-default' => 'मूल स्केल को बापिस',
	'prefstats-legend-out' => 'बाहर का विकल्प चुनना',
	'prefstats-legend-in' => 'में चुना',
);

/** Croatian (Hrvatski)
 * @author Ex13
 */
$messages['hr'] = array(
	'prefstats' => 'Statistike postavki',
	'prefstats-desc' => 'Praćenje statistike o tome koliko suradnika ima omogućene određene postavke',
	'prefstats-title' => 'Statistike postavki',
	'prefstats-list-intro' => 'Trenutačno su sljedeće postavke praćene. 
Kliknite na jednu kako biste vidjeli njezinu statistiku.',
	'prefstats-noprefs' => 'Trenutačno se ne prati niti jedna postavka. Podesite $wgPrefStatsTrackPrefss za praćenje postavki.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|suradnik je omogućio|suradnika su omogućili}} ovu postavku od kada je aktivirana statistika postavki
** $2 {{PLURAL:$2|suradnik ju je omogućio|suradnika ju je omogućilo}}
** $3 {{PLURAL:$2|suradnik ju je onemogućio|suradnika ju je onemogućilo}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|suradnik je omogućio|suradnika su omogućili}} ovu postavku od kada je aktivirana statistika postavki
** $2 {{PLURAL:$2|suradnik ju je omogućio|suradnika ju je omogućilo}}
** $3 {{PLURAL:$2|suradnik ju je onemogućio|suradnika ju je onemogućilo}}
* Ukupno, $4 {{PLURAL:$4|suradnik je postavio|suradnika je postavilo}} ovu postavku',
	'prefstats-xaxis' => 'Trajanje (sati)',
	'prefstats-factors' => 'Pregled po: $1',
	'prefstats-factor-hour' => 'sat',
	'prefstats-factor-sixhours' => 'šest sati',
	'prefstats-factor-day' => 'dan',
	'prefstats-factor-week' => 'tjedan',
	'prefstats-factor-twoweeks' => 'dva tjedna',
	'prefstats-factor-fourweeks' => 'četiri tjedna',
	'prefstats-factor-default' => 'nazad na zadanu ljestvicu',
	'prefstats-legend-out' => 'Bez',
	'prefstats-legend-in' => 'Sa',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'prefstats' => 'Statistika nastajenjow',
	'prefstats-desc' => 'Statistika wo tym, kelko wužiwarjow je wěste nastajenja aktiwizowało',
	'prefstats-title' => 'Statistika nastajenjow',
	'prefstats-list-intro' => 'Tuchwilu so slědowace nastajenja sćěhuja. Klikń na jedne z nich, zo by sej statistiku wo nim wobhladał.',
	'prefstats-noprefs' => 'Tuchwilu so žane nastajenja njesćěhuja. Konfiguruj $wgPrefStatsTrackPrefs, zo by nastajenja sćěhował.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|wužiwar je|wužiwarjej staj|wužiwarjo su|wužiwarjow je}} tute nastajenje {{PLURAL:$1|zmóžnił|zmóžniłoj|zmóžnili|zmóžniło}}, wot toho, zo statistika nastajenjow je so aktiwizowała
** $2 {{PLURAL:$2|wužiwar je|wužiwarjej staj|wužiwarjo su|wužiwarjow je}} jo {{PLURAL:$2|zmóžnił|zmóžniłoj|zmóžnili|zmóžniło}}
** $3 {{PLURAL:$3|wužiwar je|wužiwarjej staj|wužiwarjo su|wužiwarjow je}} jo {{PLURAL:$3|znjemóžnił|znjemóžniłoj|znjemóžnili|znjemóžniło}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|wužiwar je|wužiwarjej staj|wužiwarjo su|wužiwarjow je}} tute nastajenje {{PLURAL:$1|zmóžnił|zmóžniłoj|zmóžnili|zmóžniło}}, wot toho, zo statistika nastajenjow je so aktiwizowała
** $2 {{PLURAL:$2|wužiwar je|wužiwarjej staj|wužiwarjo su|wužiwarjow je}} jo {{PLURAL:$2|zmóžnił|zmóžniłoj|zmóžnili|zmóžniło}}
** $3 {{PLURAL:$3|wužiwar je|wužiwarjej staj|wužiwarjo su|wužiwarjow je}} jo {{PLURAL:$3|znjemóžnił|znjemóžniłoj|znjemóžnili|znjemóžniło}}
Dohromady $4 {{PLURAL:$4|wužiwar je|wužiwarjej saj|wužiwarjo su|wužiwarjow je}} tute nastajenje {{PLURAL:$4|stajił|stajiłoj|stajili|stajiło}}',
	'prefstats-xaxis' => 'Traće (hodźiny)',
	'prefstats-factors' => 'Přehlad za: $1',
	'prefstats-factor-hour' => 'hodźinu',
	'prefstats-factor-sixhours' => 'šěsć hodźin',
	'prefstats-factor-day' => 'dźeń',
	'prefstats-factor-week' => 'tydźeń',
	'prefstats-factor-twoweeks' => 'njedźeli',
	'prefstats-factor-fourweeks' => 'štyri njedźele',
	'prefstats-factor-default' => 'wróćo k standardnemu měritku',
	'prefstats-legend-out' => 'Wotzjewjeny',
	'prefstats-legend-in' => 'Přizjewjeny',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Tgr
 */
$messages['hu'] = array(
	'prefstats' => 'Beállítás-statisztikák',
	'prefstats-desc' => 'Statisztikák készítése arról, hány felhasználó kapcsolt be bizonyos beállításokat',
	'prefstats-title' => 'Beállítás-statisztikák',
	'prefstats-list-intro' => 'Jelenleg az alábbi beállításokról készül statisztika.
Kattints rá valamelyikre a róla gyűjtött adatok megtekintéséhez.',
	'prefstats-noprefs' => 'A beállítások nyomkövetése inaktív. Állítsd be megfelelően a $wgPrefStatsTrackPrefs értékét a beállítások követéséhez.',
	'prefstats-counters' => '* {{PLURAL:$1|Egy|$1}} szerkesztő kapcsolta be ezt a beállítást a statisztika aktiválása óta
** {{PLURAL:$2|egy|$2}} szerkesztőnél még mindig be van kapcsolva
** {{PLURAL:$3|egy|$3}} már kikapcsolta azóta',
	'prefstats-counters-expensive' => '* {{PLURAL:$1|Egy|$1}} szerkesztő kapcsolta be ezt a beállítást a statisztika aktiválása óta
** {{PLURAL:$2|egy|$2}} szerkesztőnél még mindig be van kapcsolva
** {{PLURAL:$3|egy|$3}} már kikapcsolta azóta
* Összesen {{PLURAL:$4|egy|$4}} szerkesztőnél van bekapcsolva ez a beállítás',
	'prefstats-xaxis' => 'Időtartam (óra)',
	'prefstats-factors' => 'Időköz: $1',
	'prefstats-factor-hour' => 'óránként',
	'prefstats-factor-sixhours' => 'hat óránként',
	'prefstats-factor-day' => 'naponként',
	'prefstats-factor-week' => 'hetenként',
	'prefstats-factor-twoweeks' => 'kéthetenként',
	'prefstats-factor-fourweeks' => 'négyhetenként',
	'prefstats-factor-default' => 'alapértelmezett időköz',
	'prefstats-legend-out' => 'Kikapcsolások',
	'prefstats-legend-in' => 'Bekapcsolások',
);

/** Armenian (Հայերեն)
 * @author Xelgen
 */
$messages['hy'] = array(
	'prefstats' => 'Նախընտրությունների վիճակագրություն',
	'prefstats-title' => 'Նախընտրությունների վիճակագրություն',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'prefstats' => 'Statisticas de preferentias',
	'prefstats-desc' => 'Statistics super le numero de usatores que ha activate certe preferentias',
	'prefstats-title' => 'Statisticas de preferentias',
	'prefstats-list-intro' => 'Actualmente, le sequente preferentias es sequite.
Clicca super un pro vider statisticas super illo.',
	'prefstats-noprefs' => 'Nulle preferentia es ora sequite. Configura $wgPrefStatsTrackPrefs pro sequer preferentias.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|usator|usatores}} ha activate iste preferentia depost le comenciamento del statisticas de preferentias
** $2 {{PLURAL:$2|usator|usatores}} lo ha activate
** $3 {{PLURAL:$3|usator|usatores}} lo ha disactivate',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|usator|usatores}} ha activate iste preferentia depost le comenciamento del statisticas de preferentias
** $2 {{PLURAL:$2|usator|usatores}} lo ha activate
** $3 {{PLURAL:$3|usator|usatores}} lo ha disactivate
* In total, iste preferentia es active pro $4 {{PLURAL:$4|usator|usatores}}',
	'prefstats-xaxis' => 'Durata (horas)',
	'prefstats-factors' => 'Monstrar per: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'sex horas',
	'prefstats-factor-day' => 'die',
	'prefstats-factor-week' => 'septimana',
	'prefstats-factor-twoweeks' => 'duo septimanas',
	'prefstats-factor-fourweeks' => 'quatro septimanas',
	'prefstats-factor-default' => 'retornar al scala predefinite',
	'prefstats-legend-out' => 'Non active',
	'prefstats-legend-in' => 'Active',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author Kandar
 * @author Rex
 */
$messages['id'] = array(
	'prefstats' => 'Statistik preferensi',
	'prefstats-desc' => 'Statistik mengenai berapa banyak pengguna yang mengaktifkan preferensi tertentu',
	'prefstats-title' => 'Statistik preferensi',
	'prefstats-list-intro' => 'Saat ini, preferensi-preferensi berikut sedang ditelusuri.
Klik pada salah satu untuk melihat statistiknya.',
	'prefstats-noprefs' => 'Tidak ada preferensi yang sedang ditelusuri. Konfigurasikan $wgPrefStatsTrackPrefs untuk menelusuri preferensi.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|pengguna telah|pengguna sudah}} mengaktifkan preferensi ini sejak statistik preferensi diaktifkan
** $2 {{PLURAL:$2|pengguna|pengguna}} mengaktifkan
** $3 {{PLURAL:$3|pengguna|pengguna}} menonaktifkan',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|pengguna telah|pengguna sudah}} mengaktifkan preferensi ini sejak statistik preferensi diaktifkan
** $2 {{PLURAL:$2|pengguna|pengguna}} mengaktifkan
** $3 {{PLURAL:$3|pengguna|pengguna}} menonaktifkan
* dengan total, $4 {{PLURAL:$4|pengguna|pengguna}} mengatur preferensi ini',
	'prefstats-xaxis' => 'Durasi (jam)',
	'prefstats-factors' => 'Lihat per: $1',
	'prefstats-factor-hour' => 'jam',
	'prefstats-factor-sixhours' => 'enam jam',
	'prefstats-factor-day' => 'hari',
	'prefstats-factor-week' => 'pekan',
	'prefstats-factor-twoweeks' => 'dua pekan',
	'prefstats-factor-fourweeks' => 'empat pekan',
	'prefstats-factor-default' => 'kembali ke sekala awal',
	'prefstats-legend-out' => 'Membatalkan',
	'prefstats-legend-in' => 'Disertakan',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'prefstats-factor-hour' => 'àmànì',
	'prefstats-factor-sixhours' => 'àmànị ishíi',
	'prefstats-factor-day' => 'chi',
	'prefstats-factor-week' => 'izù',
	'prefstats-factor-twoweeks' => 'izù abụọ',
	'prefstats-factor-fourweeks' => 'izù ànȯ',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'prefstats' => 'Dagiti estadistika ti kakaykayatan',
	'prefstats-desc' => 'Suruten na dagiti estadistika a maipanggep no kasano ti kaadu dagiti agar-aramat ti addaan ti maysa a kita a kakaykayatan ti napakabaelan',
	'prefstats-title' => 'Dagiti estadistika ti kakaykayatan',
	'prefstats-list-intro' => 'Agdama, dagiti sumaganad a kakaykayatan ket masusurot.
Agtakla iti maysa tapno makita dagiti estadistika a maipanggep ditoy.',
	'prefstats-noprefs' => 'Awan dagiti kakaykayatan iti agdama a masusurot.
Pabalinen ti $wgPrefStatsTrackPrefs tapno masurot dagiti kaykayat.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|ti agar-aramat ket addaan ti|dagiti agar-aramat ket addaan ti}} napakabaelan daytoy a kaykayat manipud idi naipasiglat ti estadistika ti kakaykayatan
** $2 {{PLURAL:$2|ti agar-aramat ket|dagiti agar-aramat ket}} napakabaelan da pay laeng
** $3 {{PLURAL:$3|tiagar-aramat ket|dagiti agar-aramat ket}} naibaldado  dan manipud idi',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|ti agar-aramat ket addaan ti|dagiti agar-aramat ket addaan ti}} napakabaelan daytoy a kaykayat manipud idi naipasiglat ti estadistika ti kakaykayatan
** $2 {{PLURAL:$2|ti agar-aramat ket|dagiti agar-aramat ket}} napakabaelan da pay laeng
** $3 {{PLURAL:$3|tiagar-aramat ket|dagiti agar-aramat ket}} naibaldado  dan manipud idi
* Iti dagup, $4 {{PLURAL:$4|ti agar-aramat ket|dagiti agar-aramat ket}} napakabaelan da daytoy a kakaykayatan',
	'prefstats-xaxis' => 'Kabayag (oras)',
	'prefstats-factors' => 'Kita tunggal maysa: $1',
	'prefstats-factor-hour' => 'oras',
	'prefstats-factor-sixhours' => 'innem nga oras',
	'prefstats-factor-day' => 'aldaw',
	'prefstats-factor-week' => 'lawas',
	'prefstats-factor-twoweeks' => 'dua a lawas',
	'prefstats-factor-fourweeks' => 'uppat a lawas',
	'prefstats-factor-default' => 'agsubli ti kinasigud a panagrukod',
	'prefstats-legend-out' => 'Saan a nagpili',
	'prefstats-legend-in' => 'Nagpili',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'prefstats-xaxis' => 'Duro (hori)',
	'prefstats-factor-hour' => 'horo',
	'prefstats-factor-sixhours' => 'sis hori',
	'prefstats-factor-day' => 'dio',
	'prefstats-factor-week' => 'semano',
	'prefstats-factor-twoweeks' => 'du semani',
	'prefstats-factor-fourweeks' => 'quar semani',
);

/** Icelandic (Íslenska)
 * @author Snævar
 */
$messages['is'] = array(
	'prefstats' => 'Tölfræði stillinga',
	'prefstats-desc' => 'Tölfræði um hversu margir hafa ákveðnar stillingar virkar',
	'prefstats-title' => 'Tölfræði stillinga',
	'prefstats-list-intro' => 'Eins og er, er fylgst með eftirfarandi stillingum
Ýttu á eitt þeirra til að skoða tölfræði þess.',
	'prefstats-noprefs' => 'Eins og er ekki fylgst með neinum stillingum.
Stilltu $wgPrefStatsTrackPrefs til þess að fylgjast með stillingum.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|notandi hefur|notendur hafa}} virkjað þennan möguleika frá upphafi mælinga
** $2 {{PLURAL:$2|notandi hefur|notendur hafa}} möguleikann enn virkan
** $3 {{PLURAL:$3|notandi hefur|notendur hafa}} óvirkjað möguleikan síðan',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|notandi hefur|notendur hafa}} virkjað þennan möguleika frá upphafi mælinga
** $2 {{PLURAL:$2|notandi hefur|notendur hafa}} möguleikann enn virkan
** $3 {{PLURAL:$3|notandi hefur|notendur hafa}} óvirkjað möguleikan síðan
* Í heildina, {{PLURAL:$4|hefur $4 notandi|hafa $4 notendur}} þennan möguleika virkan',
	'prefstats-xaxis' => 'Tímalengd (klukkutímar)',
	'prefstats-factors' => 'Skoða eftir: $1',
	'prefstats-factor-hour' => 'klukkutíma',
	'prefstats-factor-sixhours' => 'sex klukkutímum',
	'prefstats-factor-day' => 'degi',
	'prefstats-factor-week' => 'viku',
	'prefstats-factor-twoweeks' => 'tveimur vikum',
	'prefstats-factor-fourweeks' => 'fjórum vikum',
	'prefstats-factor-default' => 'aftur á sjálfgefinn mælikvarða',
	'prefstats-legend-out' => 'Óvirkjuðu',
	'prefstats-legend-in' => 'Virkjuðu',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Gianfranco
 * @author Melos
 * @author Una giornata uggiosa '94
 */
$messages['it'] = array(
	'prefstats' => 'Statistiche delle preferenze',
	'prefstats-desc' => 'Statistiche circa il numero di utenti che hanno attivato alcune preferenze',
	'prefstats-title' => 'Statistiche delle preferenze',
	'prefstats-list-intro' => 'Attualmente, le seguenti preferenze vengono seguite.
Fare clic su una per vedere le statistiche su di essa.',
	'prefstats-noprefs' => 'Nessuna preferenza è al momento monitorata. Configurare $wgPrefStatsTrackPrefs per monitorare le preferenze.',
	'prefstats-counters' => "* $1 {{PLURAL:$1|l'utente ha|gli utenti hanno}} attivato questa preferenza dopo che le statistiche sulle preferenze erano state attivate
** $2 {{PLURAL:$2|l'utente ce l'ha ancora|gli utenti ce l'hanno ancora}} attivata
** $3 {{PLURAL:$3|l'utente la ha|gli utenti la hanno}} disattivata dal",
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|utente ha|utenti hanno}} attivato questa preferenza da quando le statistiche per le preferenze vengono registrate
** $2 {{PLURAL:$2|utente la ha|utenti la hanno}} ancora attivata
** $3 {{PLURAL:$3|utente la ha|utenti la hanno}} disattivata
* In total, $4 {{PLURAL:$4|utente ha|utenti hanno}} modificato questa preferenza',
	'prefstats-xaxis' => 'Durata (ore)',
	'prefstats-factors' => 'Visualizza per: $1',
	'prefstats-factor-hour' => 'ora',
	'prefstats-factor-sixhours' => 'sei ore',
	'prefstats-factor-day' => 'giorno',
	'prefstats-factor-week' => 'settimana',
	'prefstats-factor-twoweeks' => 'due settimane',
	'prefstats-factor-fourweeks' => 'quattro settimane',
	'prefstats-factor-default' => 'ritorna alla scala predefinita',
	'prefstats-legend-out' => 'Non hai partecipato',
	'prefstats-legend-in' => 'Hai partecipato',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'prefstats' => '個人設定の統計',
	'prefstats-desc' => 'どの程度の数の利用者が個人設定のある項目を有効にしているかの追跡統計',
	'prefstats-title' => '個人設定に関する統計',
	'prefstats-list-intro' => '現在、以下の個人設定項目について追跡調査を行っています。調査結果を見るにはそれぞれをクリックしてください。',
	'prefstats-noprefs' => '現在、追跡調査の対象となっている個人設定項目はありません。追跡調査を行うには $wgPrefStatsTrackPrefs を設定してください。',
	'prefstats-counters' => '* 個人設定の統計が稼動して以降、$1人の利用者がこの設定を有効にしました
** $2人の利用者がこれを有効にしています
** $3人の利用者がこれを無効にしています',
	'prefstats-counters-expensive' => '* 個人設定の統計が稼動して以降、$1人の利用者がこの設定を有効にしました
** $2人の利用者がこれを有効にしています
** $3人の利用者がこれを無効にしています
* 合計では、$4人の利用者がこの項目を設定しています',
	'prefstats-xaxis' => '期間(単位：時間)',
	'prefstats-factors' => '表示する縮尺: $1',
	'prefstats-factor-hour' => '1時間',
	'prefstats-factor-sixhours' => '6時間',
	'prefstats-factor-day' => '1日',
	'prefstats-factor-week' => '1週間',
	'prefstats-factor-twoweeks' => '2週間',
	'prefstats-factor-fourweeks' => '4週間',
	'prefstats-factor-default' => 'デフォルトの縮尺に戻る',
	'prefstats-legend-out' => '無効化',
	'prefstats-legend-in' => '有効化',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'prefstats' => 'Statistik preferensi',
	'prefstats-desc' => 'Statistik ngenani ana pira panganggo sing ngaktifaké preferensi tinamtu',
	'prefstats-title' => 'Statistik preferensi',
	'prefstats-factor-hour' => 'jam',
	'prefstats-factor-sixhours' => 'enem jam',
	'prefstats-factor-day' => 'dina',
	'prefstats-factor-week' => 'minggu',
	'prefstats-factor-twoweeks' => 'rong minggu',
	'prefstats-factor-fourweeks' => 'patang minggu',
);

/** Georgian (ქართული)
 * @author Alsandro
 * @author BRUTE
 * @author Temuri rajavi
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'prefstats' => 'კონფიგურაციათა სტატისტიკა',
	'prefstats-desc' => 'გარკვეული კონფიგურაციების ჩამრთველ მომხმარელთა სტატისტიკის კონტროლი',
	'prefstats-title' => 'კონფიგურაციათა სტატისტიკა',
	'prefstats-list-intro' => 'ეხლა მიმდინარეობს შემდეგ კონფიგურაციათა კონტროლი
აირჩიეთ რომელიმე მათგანი სტატისტიკის სანახავად',
	'prefstats-noprefs' => 'რაიმე უპირატესობა ამჟამად კონტროლი არ ეწევა. კონფიგურაციის კონტროლისთვის შეიტანეთ ცვლილებები $wgPrefStatsTrackPrefs გვერდზე.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|მომხმარებელმა ჩართო|მომხმარებლებმა ჩართეს}} ეს პარამეტრი სტატისტიკის შეგროვების მომენტიდან
** $2 {{PLURAL:$2|მომხმარებელმა დატოვა|მომხმარებლებმა დატოვეს}} პარამეტრი ჩართულად
** $3 {{PLURAL:$3|მომხმარებელმა ჩართო|მომხმარებლებმა გათიშეს}} პარამეტრი',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|მომხმარებელმა ჩართო|მომხმარებლებმა ჩართეს}} ეს პარამეტრი სტატისტიკის შეგროვების მომენტიდან
** $2 {{PLURAL:$2|მომხმარებელმა დატოვა|მომხმარებლებმა დატოვეს}} პარამეტრი ჩართულად
** $3 {{PLURAL:$3|მომხმარებელმა ჩართო|მომხმარებლებმა გათიშეს}} პარამეტრი
*სულ ეს პარამეტრი {{PLURAL:$4|აქვს|აქვთ}} $4 მომხმარებელს',
	'prefstats-xaxis' => 'ხანგძლივობა (საათი)',
	'prefstats-factors' => 'ნახვები $1',
	'prefstats-factor-hour' => 'საათი',
	'prefstats-factor-sixhours' => 'ექვსი საათი',
	'prefstats-factor-day' => 'დღე',
	'prefstats-factor-week' => 'კვირა',
	'prefstats-factor-twoweeks' => 'ორი კვირა',
	'prefstats-factor-fourweeks' => 'ოთხი კვირა',
	'prefstats-factor-default' => 'ძველ მასშტაბზე დაბრუნება',
	'prefstats-legend-out' => 'გამორიცხვის პრინციპით',
	'prefstats-legend-in' => 'დაშვების პრინციპით',
);

/** Khmer (ភាសាខ្មែរ)
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'prefstats' => 'ស្ថិតិ​ ចំណូលចិត្ត​',
	'prefstats-title' => 'ស្ថិតិ​ ចំណូលចិត្ត​',
	'prefstats-xaxis' => 'រយៈពេល​ (ម៉ោង​)',
	'prefstats-factors' => 'មើល​ក្នុងមួយ​៖ $1',
	'prefstats-factor-hour' => 'ម៉ោង',
	'prefstats-factor-sixhours' => 'ប្រាំ​មួយ​ម៉ោង​',
	'prefstats-factor-day' => 'ថ្ងៃ',
	'prefstats-factor-week' => 'សប្តាហ៍',
	'prefstats-factor-twoweeks' => '២ សប្តាហ៍',
	'prefstats-factor-fourweeks' => '៤ សប្តាហ៍',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'prefstats-factor-hour' => 'ಘಂಟೆ',
	'prefstats-factor-sixhours' => 'ಆರು ಘಂಟೆಗಳು',
	'prefstats-factor-day' => 'ದಿನ',
	'prefstats-factor-week' => 'ವಾರ',
	'prefstats-factor-twoweeks' => 'ಎರಡು ವಾರಗಳು',
	'prefstats-factor-fourweeks' => 'ನಾಲ್ಕು ವಾರಗಳು',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 */
$messages['ko'] = array(
	'prefstats' => '환경 설정 통계',
	'prefstats-desc' => '각 환경 설정에 대한 사용자 비율 통계',
	'prefstats-title' => '환경 설정 통계',
	'prefstats-list-intro' => '다음 설정의 통계를 구하고 있습니다.
통계를 보려면 다음 중 하나를 클릭하십시오.',
	'prefstats-noprefs' => '통계를 내고 있는 설정이 없습니다.
환경 설정의 통계를 구하려면 $wgPrefStatsTrackPrefs를 설정하십시오.',
	'prefstats-counters' => '* 이 환경 설정에 대한 통계가 활성화된 이후로 $1명의 사용자가 이 설정을 사용하였습니다.
** $2명의 사용자가 계속 이 설정을 사용하고 있습니다.
** $3명의 사용자가 나중에 이 설정을 비활성화하였습니다.',
	'prefstats-counters-expensive' => '* 이 환경 설정에 대한 통계가 활성화된 이후로 $1명의 사용자가 이 설정을 사용하였습니다.
** $2명의 사용자가 계속 이 설정을 사용하고 있습니다.
** $3명의 사용자가 나중에 이 설정을 비활성화하였습니다.
* 총 $4명의 사용자가 이 설정을 설정하였습니다.',
	'prefstats-xaxis' => '기간(단위: 시간)',
	'prefstats-factors' => '시간 단위로 보기: $1',
	'prefstats-factor-hour' => '1시간',
	'prefstats-factor-sixhours' => '6시간',
	'prefstats-factor-day' => '1일',
	'prefstats-factor-week' => '1주',
	'prefstats-factor-twoweeks' => '2주',
	'prefstats-factor-fourweeks' => '4주',
	'prefstats-factor-default' => '기본값',
	'prefstats-legend-out' => '비활성화한 사용자 수',
	'prefstats-legend-in' => '활성화한 사용자 수',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'prefstats' => 'Джарашдырыуланы статистикасы',
	'prefstats-desc' => 'Ненчи къошулуўчу къайсы джарашдырыўну хайырланнганын сынчыкълагъан статистика',
	'prefstats-title' => 'Джарашдырыўланы статистикасы',
	'prefstats-list-intro' => 'Бусагъатда эндиги джарашдырыўла сынчыкъланадыла.
Бирин сайлагъыз статистикасына къарар ючюн.',
	'prefstats-noprefs' => 'Бусагъатда джарашдырўла сынчыкъланмайдыла.
$wgPrefStatsTrackPrefs-ни салыгъыз, джарашдырыўланы сынчыкълар ючюн.',
	'prefstats-counters' => '* $1 Статистика джыйыу башланнганлы бу параметрни {{PLURAL:$1|къошулуучу|къошулуучу}} джандыргъанды.
** $2 {{PLURAL:$2|къошулуучу|къошулуучу}} параметрни джандыргъанлай къойгъандыла
** $3 {{PLURAL:$3|къошулуучу|къошулуучу}} параметрни джукълатхандыла',
	'prefstats-counters-expensive' => '* $1 Параметрле ючюн статистика джыйыу башланнганлы бу параметрни {{PLURAL:$1|къошулуучу|къошулуучу}} джандыргъанды.
** $2 {{PLURAL:$2|къошулуучу|къошулуучу}} параметрни джандыргъандыла
** $3 {{PLURAL:$3|къошулуучу|къошулуучу}} параметрни джукълатхандыла
* Бютеўлей бу параметрни $4 {{PLURAL:$4|къошулуўчу|къошулуўчу}} салгъанды',
	'prefstats-xaxis' => 'Баргъанлыгъы (сагъат)',
	'prefstats-factors' => 'Къараула: $1',
	'prefstats-factor-hour' => 'сагъат',
	'prefstats-factor-sixhours' => 'алты сагъат',
	'prefstats-factor-day' => 'кюн',
	'prefstats-factor-week' => 'ыйыкъ',
	'prefstats-factor-twoweeks' => 'эки ыйыкъ',
	'prefstats-factor-fourweeks' => 'тёрт ыйыкъ',
	'prefstats-factor-default' => 'Тынгылау бла масштабха къайт',
	'prefstats-legend-out' => 'Джукъландыла',
	'prefstats-legend-in' => 'Джандырылдыла',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'prefstats' => 'Shtatistike övver Enshtellunge',
	'prefstats-desc' => 'Määt Shtatistike doh drövver, wi vill Metmaacher beshtemmpte Enshtellunge för sesch jemaat han.',
	'prefstats-title' => 'Shtatistike övver de Metmaacher ier Enshtellunge',
	'prefstats-list-intro' => 'Em Momang donn mer heh di Enshtellunge vun de Metmaacher biobachte.
Donn op ein dovun drop klecke, öm dä ier Shtatistik ze belooere.',
	'prefstats-noprefs' => 'De Enshtellunge wääde nit Verfollsch. Donn <code lang="en">$wgPrefStatsTrackPrefs</code> opsäze, öm dat ze ändere.',
	'prefstats-counters' => '* {{PLURAL:$1|Eine Metmaacher hät|$1 Metmaacher han|Keine Metmaacher hät}} di Enshtellung aanjemaat zick dämm de Shtatistike ennjeschalldt woode sin.
** {{PLURAL:$2|Eine Metmaacher hät|$2 Metmaacher han|Keine Metmaacher hät}} se jäz noch aanjeschalldt.
** {{PLURAL:$3|Eine Metmaacher hät|$3 Metmaacher han|Keine Metmaacher hät}} se zick dämm ußjeschalldt.',
	'prefstats-counters-expensive' => '* {{PLURAL:$1|Eine Metmaacher hät|$1 Metmaacher han|Keine Metmaacher hät}} di Enshtellung aanjemaat zick dämm de Shtatistike ennjeschalldt woode sin.
** {{PLURAL:$2|Eine Metmaacher hät|$2 Metmaacher han|Keine Metmaacher hät}} se jäz noch aanjeschalldt.
** {{PLURAL:$3|Eine Metmaacher hät|$3 Metmaacher han|Keine Metmaacher hät}} se zick dämm ußjeschalldt.
* Ennsjesamp, {{PLURAL:$4|hät eine Metmaacher|hann_er $4 Metmaacher|keine Metmaacher}} se övverhoub_ens jesaz.',
	'prefstats-xaxis' => 'Duuer en Stunde',
	'prefstats-factors' => 'Beloore för: $1',
	'prefstats-factor-hour' => 'Shtund',
	'prefstats-factor-sixhours' => 'sechs Shtunde',
	'prefstats-factor-day' => 'Daach',
	'prefstats-factor-week' => 'Woch',
	'prefstats-factor-twoweeks' => 'Zwei Woche',
	'prefstats-factor-fourweeks' => 'Vier Woche',
	'prefstats-factor-default' => 'Retuur op der Shtandatt',
	'prefstats-legend-out' => 'Afjemeldt',
	'prefstats-legend-in' => 'Aanjemelldt',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Erdal Ronahi
 */
$messages['ku-latn'] = array(
	'prefstats-factor-hour' => 'demjimêr',
	'prefstats-factor-sixhours' => 'şeş demjimêr',
	'prefstats-factor-day' => 'roj',
	'prefstats-factor-week' => 'hefte',
	'prefstats-factor-twoweeks' => 'du hefte',
	'prefstats-factor-fourweeks' => 'çar hefte',
);

/** Latin (Latina)
 * @author Omnipaedista
 * @author UV
 */
$messages['la'] = array(
	'prefstats-xaxis' => 'Tempus (horae)',
	'prefstats-factors' => 'Videre per: $1',
	'prefstats-factor-hour' => 'horam',
	'prefstats-factor-sixhours' => 'sex horas',
	'prefstats-factor-day' => 'diem',
	'prefstats-factor-week' => 'hebdomadem',
	'prefstats-factor-twoweeks' => 'duas hebdomades',
	'prefstats-factor-fourweeks' => 'quattuor hebdomades',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'prefstats' => 'Statistike vun den Astellungen',
	'prefstats-desc' => 'Statistiken doriwwer wéi vill Benotzer bestëmmt Astellungen aktivéiert hunn',
	'prefstats-title' => 'Statistike vun den Astellungen',
	'prefstats-list-intro' => 'Elo ginn dës Astellungen iwwerwaacht.
Klickt op eng fir Statistiken iwwer hire Gebrauch ze gesinn.',
	'prefstats-noprefs' => "Et ginn elo keng Astellungen iwwerwaacht. Stellt \$wgPrefStatsTrackPrefs an fir d'Astellungen z'iwwerwaachen.",
	'prefstats-counters' => "* $1 {{PLURAL:$1|Benotzer huet|Benotzer hunn}} dës Astellung ageschalt zënter datt d'Statistik vun de Benotzerastellungen aktivéiert gouf
** $2 {{PLURAL:$2|Benotzer huet|Benotzer hunn}} et ageschalt
** $3 {{PLURAL:$3|Benotzer huet|Benotzer hunn}} et ausgeschalt",
	'prefstats-counters-expensive' => "* $1 {{PLURAL:$1|Benotzer huet|Benotzer hunn}} dës Astellung ageschalt zënter datt d'Statistik vun de Benotzerastellungen aktivéiert gouf
** $2 {{PLURAL:$2|Benotzer huet|Benotzer hunn}} et ageschalt
** $3 {{PLURAL:$3|Benotzer huet|Benotzer hunn}} et ausgeschalt
* am Ganzen, $4 {{PLURAL:$3|Benotzer huet|Benotzer hunn}} dës Astellung konfiguréiert",
	'prefstats-xaxis' => 'Dauer (Stonnen)',
	'prefstats-factors' => 'Gekuckt pro: $1',
	'prefstats-factor-hour' => 'Stonn',
	'prefstats-factor-sixhours' => 'sechs Stonnen',
	'prefstats-factor-day' => 'Dag',
	'prefstats-factor-week' => 'Woch',
	'prefstats-factor-twoweeks' => 'zwou Wochen',
	'prefstats-factor-fourweeks' => 'véier Wochen',
	'prefstats-factor-default' => "zréck op d'Standard-Gréisst",
	'prefstats-legend-out' => 'Mécht net mat',
	'prefstats-legend-in' => 'Mécht mat',
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'prefstats' => 'Prifferensiesjtattistieke',
	'prefstats-desc' => 'Sjtattistieke biehauwe euver wieväöl gebroekers bepaolde prifferensies höbbe ingesjakeld',
	'prefstats-title' => 'Prifferensiesjtattistieke',
	'prefstats-list-intro' => "Insjtellinge veur de ongerstaonde prifferensies waere biegehauwe.
Klik op 'n prifferensie óm de sjtattistieke te betrachte.",
	'prefstats-noprefs' => 'D\'r waere gein prifferensies biegehauwe.
Sjtèl $wgPrefStatsTrackPrefs in óm prifferensies bie te hauwe.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|gebroeker haet|gebroekers höbbe}} dees prifferensie ingesjakeld sinds de prifferensiesjtattistieke geaktiveerd zeen.
** $2 {{PLURAL:$2|gebroeker haet|gebroekers höbbe}} deze nog ummer ingesjakeld
** $3 {{PLURAL:$3|gebroeker haet|gebroekers höbbe}} deze weer oetgesjakeld',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|gebroeker haet|gebroekers höbbe}} deze prifferensie ingesjakeld sinds de prifferentiesjtattistieke zeen geaktiveerd.
** $2 {{PLURAL:$2|gebroeker haet|gebroekers höbbe}} deze nog ummer ingesjakeld
** $3 {{PLURAL:$3|gebroeker haet|gebroekers höbbe}} deze weer oetgesjakeld
* In totaal {{PLURAL:$4|haet $4 gebroeker|höbbe $4 gebroekers}} deze prifferentie ingesjakeld.',
	'prefstats-xaxis' => 'Door (oere)',
	'prefstats-factors' => 'Weergeve per: $1',
	'prefstats-factor-hour' => 'oer',
	'prefstats-factor-sixhours' => 'zès oer',
	'prefstats-factor-day' => 'daag',
	'prefstats-factor-week' => 'waek',
	'prefstats-factor-twoweeks' => 'twie waeke',
	'prefstats-factor-fourweeks' => 'veer waeke',
	'prefstats-factor-default' => 'trök nao de sjtandaardsjaol',
	'prefstats-legend-out' => 'Aafgemeld',
	'prefstats-legend-in' => 'Aangemeld',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Garas
 * @author Matasg
 */
$messages['lt'] = array(
	'prefstats' => 'Nustatymų statistika',
	'prefstats-desc' => 'Rinkite statistiką apie naudotojus, pasirinkusius šiuos nustatymus',
	'prefstats-title' => 'Nustatymų statistika',
	'prefstats-list-intro' => 'Šiuo metu yra sekami šie pasirinkimai.
Pasirinkite vieną iš jų, norėdami pamatyti statistiką.',
	'prefstats-xaxis' => 'Trukmė (valandomis)',
	'prefstats-factors' => 'Peržiūrėti per: $1',
	'prefstats-factor-hour' => 'valandą',
	'prefstats-factor-sixhours' => 'šešias valandas',
	'prefstats-factor-day' => 'dieną',
	'prefstats-factor-week' => 'savaitę',
	'prefstats-factor-twoweeks' => 'dvi savaites',
	'prefstats-factor-fourweeks' => 'keturias savaites',
);

/** Latvian (Latviešu)
 * @author Papuass
 */
$messages['lv'] = array(
	'prefstats-xaxis' => 'Ilgums (stundas)',
	'prefstats-factor-hour' => 'stunda',
	'prefstats-factor-sixhours' => 'sešas stundas',
	'prefstats-factor-day' => 'diena',
	'prefstats-factor-week' => 'nedēļa',
	'prefstats-factor-twoweeks' => 'divas nedēļas',
	'prefstats-factor-fourweeks' => 'četras nedēļas',
	'prefstats-factor-default' => 'atpakaļ uz noklusēto skalu',
);

/** Lazuri (Lazuri)
 * @author Bombola
 */
$messages['lzz'] = array(
	'prefstats-factor-hour' => "saat'i",
	'prefstats-factor-day' => 'ndğa',
	'prefstats-factor-week' => 'doloni',
	'prefstats-factor-twoweeks' => 'jur doloni',
	'prefstats-factor-fourweeks' => 'xut doloni',
);

/** Minangkabau (Baso Minangkabau)
 * @author VoteITP
 */
$messages['min'] = array(
	'prefstats' => 'Statistik preferensi',
	'prefstats-desc' => 'Talian statistik tentang barapo banyak pangguno yang mengaktifkan preferensi tertentu',
	'prefstats-title' => 'Statistik preferensi',
	'prefstats-list-intro' => 'Kini ko, babarapo preferensi ko sedang ditelusuri.
Klik salah satu untuak malihek statistiknyo',
	'prefstats-noprefs' => 'Indak ado preferensi yang ditelusuri.
Konfigurasi $wgPrefStatsTrackPrefs untuak telusuri preferensi.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|pangguno|pangguno}} sudah mengaktifkan preferensi ko sejak statistik preferensi diaktifkan
** $2 {{PLURAL:$2|pangguno|pangguno}} masih mengaktifkan
** $3 {{PLURAL:$3|pangguno|pangguno}} sudah indak aktif',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|pangguno|pangguno}} sudah mengaktifkan preferensi ko sejak statistik preferensi diaktifkan
** $2 {{PLURAL:$2|pangguno|pangguno}} masih mengaktifkan
** $3 {{PLURAL:$3|pangguno|pangguno}} sudah indak aktif
* Dengan total, $4 {{PLURAL:$4|pengguno|pengguno}} mengatur preferensi ko',
	'prefstats-xaxis' => 'Durasi (jam)',
	'prefstats-factors' => 'Lihek per: $1',
	'prefstats-factor-hour' => 'jam',
	'prefstats-factor-sixhours' => 'anam jam',
	'prefstats-factor-day' => 'hari',
	'prefstats-factor-week' => 'saminggu',
	'prefstats-factor-twoweeks' => 'duo minggu',
	'prefstats-factor-fourweeks' => 'ampek minggu',
	'prefstats-factor-default' => 'Baliak ka skala default',
	'prefstats-legend-out' => 'Membatalkan',
	'prefstats-legend-in' => 'Menyertakan',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'prefstats' => 'Статистики за прилагодувања',
	'prefstats-desc' => 'Следи ги статистиките кои кажуваат колку корисници имаат овозможено извесни прилагодувања',
	'prefstats-title' => 'Статистики за прилагодувања',
	'prefstats-list-intro' => 'Моментално ги следите следниве прилагодувања.
Кликнете на едно од нив за да ги видите статистиките за него.',
	'prefstats-noprefs' => 'Моментално не се следите никакви прилагодувања.
Конфигурирајте го $wgPrefStatsTrackPrefs за да следите прилагодувања.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|корисник ја има|корисници ја имаат}} вклучено оваа можност откога се активирани статистиките за прилагодувања
** $2 {{PLURAL:$2|корисник сè уште ја чува вклучена|корисници сè уште ја чуваат вклучена}}
** $3 {{PLURAL:$3|корисник во меѓувреме ја оневозможил|корисници во меѓувреме ја оневозможиле}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|корисник ја има|корисници ја имаат}} вклучено оваа можност од кога е активирана статистиката на прилагодувања
** $2 {{PLURAL:$2|корисник сè уште ја чува вклучена|корисници сè уште ја чуваат вклучена}}
** $3 {{PLURAL:$3|корисник во меѓувреме ја оневозможил|корисници во меѓувреме ја оневозможиле}}
* Вкупно $4 {{PLURAL:$4|корисник ја има вклучено оваа можност|корисници ја имаат вклучено оваа можност}}',
	'prefstats-xaxis' => 'Времетрање (часови)',
	'prefstats-factors' => 'Преглед за: $1',
	'prefstats-factor-hour' => 'час',
	'prefstats-factor-sixhours' => 'шест часа',
	'prefstats-factor-day' => 'ден',
	'prefstats-factor-week' => 'седмица',
	'prefstats-factor-twoweeks' => 'две седмици',
	'prefstats-factor-fourweeks' => 'четири седмици',
	'prefstats-factor-default' => 'врати основно зададен размер',
	'prefstats-legend-out' => 'Пристапил',
	'prefstats-legend-in' => 'Напуштил',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'prefstats' => 'ക്രമീകരണ ഐച്ഛികങ്ങളുടെ സ്ഥിതിവിവരക്കണക്കുകൾ',
	'prefstats-desc' => 'എത്ര ഉപയോക്താക്കൾ പ്രത്യേക ക്രമീകരണ ഐച്ഛികം ഉപയോഗിക്കുന്നുണ്ടെന്നുള്ളതിന്റെ സ്ഥിതിവിവരക്കണക്കുകൾ എടുക്കുക',
	'prefstats-title' => 'ക്രമീകരണ ഐച്ഛികങ്ങളുടെ സ്ഥിതിവിവരക്കണക്കുകൾ',
	'prefstats-list-intro' => 'ഇപ്പോൾ, താഴെ പറയുന്ന ക്രമീകരണ ഐച്ഛികങ്ങൾ അനുഗമിക്കുന്നുണ്ട്.
ഒന്നിൽ ഞെക്കിയാൽ അതിന്റെ സ്ഥിതിവിവരക്കണക്കുകൾ കാണാവുന്നതാണ്.',
	'prefstats-noprefs' => 'ഇപ്പോൾ യാതൊരു ക്രമീകരണ ഐച്ഛികത്തേയും അനുഗമിക്കുന്നില്ല.
ക്രമീകരണ ഐച്ഛികങ്ങൾ അനുഗമിക്കാൻ $wgPrefStatsTrackPrefs ക്രമീകരിക്കുക',
	'prefstats-counters' => '* {{PLURAL:$1|ഒരു ഉപയോക്താവ്|$1 ഉപയോക്താക്കൾ}} ക്രമീകരണ ഐച്ഛികങ്ങളുടെ സ്ഥിതിവിവരക്കണക്കുകൾ പ്രവർത്തനക്ഷമമാക്കിയതിനു ശേഷം സജ്ജമാക്കിയിട്ടുണ്ട്
** {{PLURAL:$2|ഒരു ഉപയോക്താവ്|$2 ഉപയോക്താക്കൾ}} ഇതിപ്പോഴും ഉപയോഗിക്കുന്നു
** {{PLURAL:$3|ഒരു ഉപയോക്താവ്|$3 ഉപയോക്താക്കൾ}} ഇതു പിന്നീട് ഒഴിവാക്കി',
	'prefstats-counters-expensive' => '* {{PLURAL:$1|ഒരു ഉപയോക്താവ്|$1 ഉപയോക്താക്കൾ}} ക്രമീകരണ ഐച്ഛികങ്ങളുടെ സ്ഥിതിവിവരക്കണക്കുകൾ പ്രവർത്തനക്ഷമമാക്കിയതിനു ശേഷം സജ്ജമാക്കിയിട്ടുണ്ട്
** {{PLURAL:$2|ഒരു ഉപയോക്താവ്|$2 ഉപയോക്താക്കൾ}} ഇതിപ്പോഴും ഉപയോഗിക്കുന്നു
** {{PLURAL:$3|ഒരു ഉപയോക്താവ്|$3 ഉപയോക്താക്കൾ}} ഇതു പിന്നീട് ഒഴിവാക്കി
* ആകെ, {{PLURAL:$4|ഒരു ഉപയോക്താവ്|$4 ഉപയോക്താക്കൾ}} ഈ ക്രമീകരണ ഐച്ഛികം ഉപയോഗിക്കുന്നു',
	'prefstats-xaxis' => 'കാലയളവ് (മണിക്കൂർ)',
	'prefstats-factors' => 'കാണേണ്ട വിധം: $1',
	'prefstats-factor-hour' => 'മണിക്കൂർ',
	'prefstats-factor-sixhours' => 'ആറു മണിക്കൂർ',
	'prefstats-factor-day' => 'ദിവസം',
	'prefstats-factor-week' => 'ആഴ്ച്ച',
	'prefstats-factor-twoweeks' => 'രണ്ട് ആഴ്ച്ച',
	'prefstats-factor-fourweeks' => 'നാല് ആഴ്‌‌ച്ച',
	'prefstats-factor-default' => 'സ്വതേയുള്ള അളവിലേയ്ക്ക് മടങ്ങുക',
	'prefstats-legend-out' => 'ഐച്ഛിക ഒഴിവാക്കൽ',
	'prefstats-legend-in' => 'ഐച്ഛിക ഉൾപ്പെടുത്തൽ',
);

/** Marathi (मराठी)
 * @author Mahitgar
 * @author V.narsikar
 * @author अभय नातू
 */
$messages['mr'] = array(
	'prefstats' => 'पसंती सांख्यिकी',
	'prefstats-desc' => 'किती सदस्यांनी विशिष्ट पसंती निवडल्या आहेत ते दर्शविणारी सांख्यिकी बघा',
	'prefstats-title' => 'पसंती सांख्यिकी',
	'prefstats-list-intro' => 'सध्या,खालील पसंतींचा वेध घेतला जातो.
संबधीत सांख्यिकी पहाण्या साठी त्यापैकी एकावर टिचकी मारा.',
	'prefstats-noprefs' => 'सध्या कोणत्याही पसंतींचा वेध घेतला जात नाही.
पसंतींचा वेध घेण्या साठी $wgPrefStatsTrackPrefs ची मांडणी संक्षम करा.',
	'prefstats-counters' => '*पसंती सांख्यिकी मोजणी चालू केल्यापासून $1 {{PLURAL:$1|सदस्याने|सदस्यांनी}} हि पसंती सक्षम केली आहे
** $2 {{PLURAL:$2|सदस्य अजून |सदस्यांकडे अजून }} सक्षमता आहे
** $3 पासून {{PLURAL:$3|सदस्याने|सदस्यांनी }} अक्षम केले आहे',
	'prefstats-counters-expensive' => '*पसंती सांख्यिकी मोजणी चालू केल्यापासून $1 {{PLURAL:$1|सदस्याने|सदस्यांनी}} हि पसंती सक्षम केली आहे
** $2 {{PLURAL:$2|सदस्य अजून |सदस्यांकडे अजून }} सक्षमता आहे
** $3 पासून {{PLURAL:$3|सदस्याने|सदस्यांनी }} अक्षम केले आहे
* एकुण, $4 {{PLURAL:$4|सदस्याकडे आहे|सदस्यांकडे आहे}} हा पसंती संच आहे',
	'prefstats-xaxis' => 'कालावधी (तासात)',
	'prefstats-factors' => 'दृष्ये प्रती: $1',
	'prefstats-factor-hour' => 'तास',
	'prefstats-factor-sixhours' => 'सहा तास',
	'prefstats-factor-day' => 'दिवस',
	'prefstats-factor-week' => 'आठवडा',
	'prefstats-factor-twoweeks' => 'दोन आठवडे',
	'prefstats-factor-fourweeks' => 'चार आठवडे',
	'prefstats-factor-default' => 'अविचल मापनाकडे परत',
	'prefstats-legend-out' => 'निवडीतुन बाहेर',
	'prefstats-legend-in' => 'निवडुन आत',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Kurniasan
 */
$messages['ms'] = array(
	'prefstats' => 'Statistik keutamaan',
	'prefstats-desc' => 'Jejaki statistik mengenai seberapa ramai pengguna yang membolehkan keutamaan tertentu',
	'prefstats-title' => 'Statistik keutamaan',
	'prefstats-list-intro' => 'Keutamaan-keutamaan berikut sedang dijejaki.
Klik salah satu untuk melihat statistik mengenainya.',
	'prefstats-noprefs' => 'Tiada keutamaan sedang dijejaki buat masa ini.
Tatarajahkan $wgPrefStatsTrackPrefs untuk menjejaki keutamaan-keutamaan.',
	'prefstats-counters' => '* $1 pengguna telah membolehkan keutamaan ini sejak statistik keutamaan diaktifkan
** $2 pengguna masih membolehkannya
** $3 pengguna telah melumpuhkannya',
	'prefstats-counters-expensive' => '* $1 orang pengguna telah membolehkan keutamaan ini sejak statistik keutamaan diaktifkan
** $2 orang pengguna masih membolehkannya
** $3 orang pengguna telah melumpuhkannya
* Secara keseluruhan, $4 orang pengguna mempunyai set keutamaan ini',
	'prefstats-xaxis' => 'Tempoh (jam)',
	'prefstats-factors' => 'Papar per: $1',
	'prefstats-factor-hour' => 'jam',
	'prefstats-factor-sixhours' => 'enam jam',
	'prefstats-factor-day' => 'hari',
	'prefstats-factor-week' => 'minggu',
	'prefstats-factor-twoweeks' => 'dua minggu',
	'prefstats-factor-fourweeks' => 'empat minggu',
	'prefstats-factor-default' => 'kembali ke skala asali',
	'prefstats-legend-out' => 'Berhenti',
	'prefstats-legend-in' => 'Menyertai',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'prefstats' => 'Statistika tal-preferenzi',
	'prefstats-desc' => 'Tikseb statistika fuq kemm-il utent attivaw ċerti preferenzi',
	'prefstats-title' => 'Statistika tal-preferenzi',
	'prefstats-list-intro' => 'Attwalment, il-preferenzi segwenti huma segwiti.
Agħfas fuq waħda biex tara l-istatistika fuqha.',
	'prefstats-noprefs' => 'L-ebda preferenza mhi segwita fil-mument. Ikkonfigura $wgPrefStatsTrackPrefs sabiex issegwi l-preferenzi.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|utent attiva|utenti attivaw}} din il-preferenza wara li l-istatistika fuq il-preferenzi ġew attivati
** $2 {{PLURAL:$2|utent għad għandu l-preferenza attivata|utenti għad għandhom il-preferenza attivata}}
** $3 {{PLURAL:$3|utent għandu l-preferenza|utenti għandhom il-preferenza}} diżattivata',
	'prefstats-counters-expensive' => "* $1 {{PLURAL:$1|utent attiva|utenti attivaw}} din il-preferenza minn mindu l-istatistika fuq il-preferenzi ġew attivati
** $2 {{PLURAL:$2|utent għad għandu l-preferenza attivata|utenti għad għandhom il-preferenza attivata}}
** $3 {{PLURAL:$3|utent għandu l-preferenza|utenti għandhom il-preferenza}} diżattivata
* B'kollox, $4 {{PLURAL:$4|utent immodifika|utenti mmodifikaw}} din il-preferenza",
	'prefstats-xaxis' => 'Tul (sigħat)',
	'prefstats-factors' => 'Uri kull: $1',
	'prefstats-factor-hour' => 'siegħa',
	'prefstats-factor-sixhours' => 'sitt sigħat',
	'prefstats-factor-day' => 'ġurnata',
	'prefstats-factor-week' => 'ġimgħa',
	'prefstats-factor-twoweeks' => 'ġimgħatejn',
	'prefstats-factor-fourweeks' => "erba' ġimgħat",
	'prefstats-factor-default' => 'lura lejn l-iskala predefinita',
	'prefstats-legend-out' => 'Ma ħadtx sehem',
	'prefstats-legend-in' => 'Ħadt sehem',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'prefstats-factor-hour' => 'цяс',
	'prefstats-factor-sixhours' => 'кото цяст',
	'prefstats-factor-day' => 'чи',
	'prefstats-factor-week' => 'тарго',
	'prefstats-factor-twoweeks' => 'кавто таргт',
	'prefstats-factor-fourweeks' => 'ниле таргт',
);

/** Nahuatl (Nāhuatl)
 * @author Ricardo gs
 */
$messages['nah'] = array(
	'prefstats-factors' => 'Ōquitto in: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'chicuacē horas',
	'prefstats-factor-day' => 'tōnalli',
	'prefstats-factor-week' => 'chicuēyilhuitl',
	'prefstats-factor-twoweeks' => 'ōme chicuēyilhuitl',
	'prefstats-factor-fourweeks' => 'nāhui chicuēyilhuitl',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Laaknor
 * @author Simny
 * @author Stigmj
 */
$messages['nb'] = array(
	'prefstats' => 'Statistikk over innstillinger',
	'prefstats-desc' => 'Statistikk over tallet på brukere som har visse innstillinger',
	'prefstats-title' => 'Statistikk over innstillinger',
	'prefstats-list-intro' => 'For tiden blir følgende innstillinger sporet.
Klikk på en for å se statistikk om den.',
	'prefstats-noprefs' => 'Ingen preferanser blir sporet. Konfigurer $wgPrefStatsTrackPrefs for å spore preferanser',
	'prefstats-counters' => '* {{PLURAL:$1|Én bruker|$1 brukere}} har aktivert denne innstillingen siden sporingen ble startet
** {{PLURAL:$2|Én bruker|$2 brukere}} har den fortsatt aktivert
** {{PLURAL:$3|Én bruker|$3 brukere}} har deaktivert den igjen',
	'prefstats-counters-expensive' => '* {{PLURAL:$1|Én bruker|$1 brukere}} har aktivert denne innstillingen siden sporingen ble startet
** {{PLURAL:$2|Én bruker|$2 brukere}} har den fortsatt aktivert
** {{PLURAL:$3|Én bruker|$3 brukere}} har deaktivert den igjen
* Sammenlagt har {{PLURAL:$4|én bruker|$4 brukere}} innstillingen aktivert',
	'prefstats-xaxis' => 'Varighet (timer)',
	'prefstats-factors' => 'Vis etter $1',
	'prefstats-factor-hour' => 'time',
	'prefstats-factor-sixhours' => 'seks timer',
	'prefstats-factor-day' => 'dag',
	'prefstats-factor-week' => 'uke',
	'prefstats-factor-twoweeks' => 'to uker',
	'prefstats-factor-fourweeks' => 'fire uker',
	'prefstats-factor-default' => 'tilbake til standardskalering',
	'prefstats-legend-out' => 'Valgt vekk',
	'prefstats-legend-in' => 'Valgt',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'prefstats' => 'Veurkeurenstaotistieken',
	'prefstats-title' => 'Veurkeurenstaotistieken',
	'prefstats-factor-hour' => 'ure',
	'prefstats-factor-sixhours' => 'zes uren',
	'prefstats-factor-day' => 'dag',
	'prefstats-factor-week' => 'weke',
	'prefstats-factor-twoweeks' => 'twee weken',
	'prefstats-factor-fourweeks' => 'vier weken',
	'prefstats-factor-default' => 'weerumme naor de standardschaole',
	'prefstats-legend-out' => 'Aofemeld',
	'prefstats-legend-in' => 'An-emeld',
);

/** Dutch (Nederlands)
 * @author Romaine
 * @author Siebrand
 */
$messages['nl'] = array(
	'prefstats' => 'Voorkeurenstatistieken',
	'prefstats-desc' => 'Statistieken bijhouden over hoeveel gebruikers bepaalde voorkeuren hebben ingeschakeld',
	'prefstats-title' => 'Voorkeurenstatistieken',
	'prefstats-list-intro' => 'Instellingen voor de onderstaande voorkeuren worden bijgehouden.
Klik op een voorkeur om de statistieken te bekijken.',
	'prefstats-noprefs' => 'Er worden geen voorkeuren bijgehouden.
Stel $wgPrefStatsTrackPrefs in om voorkeuren bij te houden.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|gebruiker heeft|gebruikers hebben}} deze voorkeur ingesteld sinds de voorkeurstatistieken zijn geactiveerd.
** $2 {{PLURAL:$2|gebruiker heeft|gebruikers hebben}} deze nog ingesteld
** $3 {{PLURAL:$3|gebruiker heeft|gebruikers hebben}} deze weer uitgeschakeld',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|gebruiker heeft|gebruikers hebben}} deze voorkeur ingesteld sinds de voorkeurstatistieken zijn geactiveerd.
** $2 {{PLURAL:$2|gebruiker heeft|gebruikers hebben}} deze nog ingesteld.
** $3 {{PLURAL:$3|gebruiker heeft|gebruikers hebben}} deze weer uitgeschakeld.
* In totaal {{PLURAL:$4|heeft $4 gebruiker|hebben $4 gebruikers}} deze voorkeur ingesteld.',
	'prefstats-xaxis' => 'Duur (uren)',
	'prefstats-factors' => 'Weergeven per: $1',
	'prefstats-factor-hour' => 'uur',
	'prefstats-factor-sixhours' => 'zes uur',
	'prefstats-factor-day' => 'dag',
	'prefstats-factor-week' => 'week',
	'prefstats-factor-twoweeks' => 'twee weken',
	'prefstats-factor-fourweeks' => 'vier weken',
	'prefstats-factor-default' => 'terug naar de standaardschaal',
	'prefstats-legend-out' => 'Afgemeld',
	'prefstats-legend-in' => 'Aangemeld',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'prefstats' => 'Statistikk over innstillingar',
	'prefstats-desc' => 'Statistikk over talet på brukarar som har visse innstillingar',
	'prefstats-title' => 'Statistikk over innstillingar',
	'prefstats-list-intro' => 'For tida vert dei fylgjande innstillingane spora.
Trykk på éi for å sjå statistikk for ho.',
	'prefstats-noprefs' => 'For tida vert ingen innstillingar spora.
Endra oppsettet til $wgPrefStatsTrackPrefs for å spora innstillingar.',
	'prefstats-counters' => '* {{PLURAL:$1|Éin brukar|$1 brukarar}} har aktivert denne innstillinga sidan innstillingsstatistikken vart sett i gang
** {{PLURAL:$2|Éin brukar|$2 brukarar}} har enno innstillinga aktivert
** {{PLURAL:$3|Éin brukar|$3 brukarar}} har sidan deaktivert innstillinga',
	'prefstats-counters-expensive' => '* {{PLURAL:$1|Éin brukar|$1 brukarar}} har aktivert denne innstillinga sidan innstillingsstatistikken vart sett i gang
** {{PLURAL:$2|Éin brukar|$2 brukarar}} har enno innstillinga aktivert
** {{PLURAL:$3|Éin brukar|$3 brukarar}} har sidan deaktivert innstillinga
* I alt har {{PLURAL:$4|éin brukar|$4 brukarar}} innstillinga aktivert',
	'prefstats-xaxis' => 'Tid i timar',
	'prefstats-factors' => 'Vis per $1',
	'prefstats-factor-hour' => 'time',
	'prefstats-factor-sixhours' => 'seks timar',
	'prefstats-factor-day' => 'dag',
	'prefstats-factor-week' => 'veke',
	'prefstats-factor-twoweeks' => 'to veker',
	'prefstats-factor-fourweeks' => 'fire veker',
	'prefstats-factor-default' => 'tilbake til standardskalering',
	'prefstats-legend-out' => 'Valde vekk',
	'prefstats-legend-in' => 'Valde',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'prefstats-factor-hour' => 'iri',
	'prefstats-factor-day' => 'letšatši',
	'prefstats-factor-week' => 'beke',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'prefstats' => 'Preferéncia de las estatisticas',
	'prefstats-desc' => "Estatisticas sul nombre d'utilizaires qu'an cèrtas preferéncias activadas",
	'prefstats-title' => 'Estatisticas de las preferéncias',
	'prefstats-list-intro' => "En aqueste moment, las preferéncias seguentas son seguidas.
Clicatz sus una d'entre elas per veire las estatisticas a son prepaus.",
	'prefstats-noprefs' => 'Cap de preferéncia es pas seguida actualament. Configuratz $wgPrefStatsTrackPrefs per seguir de preferéncias.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|utilizaire a|utilizaires an}} activat aquesta preferéncia dempuèi que las estatisticas de preferéncias son estadas activadas
** $2 {{PLURAL:$2|utilizaire a|utilizaires an}} activat aquesta preferéncia
** $3 {{PLURAL:$3|utilizaire a|utilizaires an}} desactivat aquesta preferéncia',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|utilizaire a|utilizaires an}} activat aquesta preferéncia dempuèi que las estatisticas de preferéncias son estadas activadas
** $2 {{PLURAL:$2|utilizaire a|utilizaires an}} activat aquesta preferéncia
** $3 {{PLURAL:$3|utilizaire a|utilizaires an}} desactivat aquesta preferéncia
* Al total, $4 {{PLURAL:$4|utilizaire a|utilizaires an}} definit aquesta preferéncia',
	'prefstats-xaxis' => 'Durada (oras)',
	'prefstats-factors' => 'Afichar per : $1',
	'prefstats-factor-hour' => 'ora',
	'prefstats-factor-sixhours' => 'sièis oras',
	'prefstats-factor-day' => 'jorn',
	'prefstats-factor-week' => 'setmana',
	'prefstats-factor-twoweeks' => 'doas setmanas',
	'prefstats-factor-fourweeks' => 'quatre setmanas',
	'prefstats-factor-default' => "tornar a l'escala per defaut",
	'prefstats-legend-out' => 'Vòl pas pus participar',
	'prefstats-legend-in' => 'Vòl participar',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'prefstats' => 'ପସନ୍ଦ ପରିସଂଖ୍ୟାନ',
	'prefstats-desc' => ' କେତେଜଣ ସଭ୍ୟ ନିର୍ଦ୍ଦିଷ୍ଟ ପସନ୍ଦ ସଚଳ କରିଅଛନ୍ତି ତାହାର ପରିସଂଖ୍ୟାନ ଦେଖିବେ',
	'prefstats-title' => 'ପସନ୍ଦ ପରିସଂଖ୍ୟାନ',
	'prefstats-list-intro' => 'ଅଧୁନା, ତଳଲିଖିତ ପସନ୍ଦସବୁ ନିରେଖି ଦେଖାଯାଉଅଛି ।
ପରିସଙ୍ଖ୍ୟାନ ଦେଖିବା ନିମନ୍ତେ କ୍ଲିକ କରନ୍ତୁ ।',
	'prefstats-noprefs' => 'କୌଣସିଟି ପସନ୍ଦର ଏବେ ଅନୁଧାବନ କରାଯାଉନାହିଁ ।
ପସନ୍ଦସବୁର ଗତିବିଧି ଜାଣିବା ନିମନ୍ତେ $wgPrefStatsTrackPrefs କୁ ସଜାଇବେ ।',
	'prefstats-counters' => '* $1 {{PLURAL:$1|ଜଣ ସଭ୍ୟ|ଜଣ ସଭ୍ୟ}} ପସନ୍ଦ ପରିସଙ୍ଖ୍ୟାନସବୁ ସଚଳ ହେବା ପରେ ଏହି ପସନ୍ଦ ସଚଳ କରାଇଛନ୍ତି
** $2 {{PLURAL:$2|ଜଣ ସଭ୍ୟ ଏବେବି|ଜଣ ସଭ୍ୟ ଏବେବି}} ଏହାକୁ ସଚଳ କରାଯାଇଛନ୍ତି
** $3 {{PLURAL:$3|ଜଣ ସଭ୍ୟ|ଜଣ ସଭ୍ୟ}} ସଚଳ କରାଯାଇଛନ୍ତି',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|ଜଣ ସଭ୍ୟ|ଜଣ ସଭ୍ୟ}} ପସନ୍ଦ ପରିସଙ୍ଖ୍ୟାନସବୁ ସଚଳ ହେବା ପରେ ଏହି ପସନ୍ଦ ସଚଳ କରାଇଛନ୍ତି
** $2 {{PLURAL:$2|ଜଣ ସଭ୍ୟ ଏବେବି|ଜଣ ସଭ୍ୟ ଏବେବି}} ଏହାକୁ ସଚଳ କରାଯାଇଛନ୍ତି
** $3 {{PLURAL:$3|ଜଣ ସଭ୍ୟ|ଜଣ ସଭ୍ୟ}} ସଚଳ କରାଯାଇଛନ୍ତି
* ମୋଟ, $4 {{PLURAL:$4|ଜଣ ସଭ୍ୟ|ଜଣ ସଭ୍ୟ}} ଏହି ପସନ୍ଦ ସଚଳ କରାଇଛନ୍ତି',
	'prefstats-xaxis' => 'ସମୟସୀମା (ଘଣ୍ଟା)',
	'prefstats-factors' => '$1 ପ୍ରତି ଦେଖଣା',
	'prefstats-factor-hour' => 'ଘଣ୍ଟା',
	'prefstats-factor-sixhours' => 'ଛଅ ଘଣ୍ଟା',
	'prefstats-factor-day' => 'ଦିନ',
	'prefstats-factor-week' => 'ସପ୍ତାହ',
	'prefstats-factor-twoweeks' => 'ଦୁଇ ସପ୍ତାହ',
	'prefstats-factor-fourweeks' => 'ଚାରି ସପ୍ତାହ',
	'prefstats-factor-default' => 'ଆପେଆପେ ଥିବା ସ୍କେଲକୁ ଫେରୁଅଛି',
	'prefstats-legend-out' => 'ବାହାରି ପଡ଼ିଲେ',
	'prefstats-legend-in' => 'ବାଛିନେଲେ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'prefstats-xaxis' => 'Dauer (Schtunde)',
	'prefstats-factor-hour' => 'Schtund',
	'prefstats-factor-sixhours' => 'sex Schtund',
	'prefstats-factor-day' => 'Daag',
	'prefstats-factor-week' => 'Woch',
	'prefstats-factor-twoweeks' => 'zwee Woche',
	'prefstats-factor-fourweeks' => 'vier Woche',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'prefstats' => 'Statystyki dla preferencji',
	'prefstats-desc' => 'Dane statystyczne na temat liczby użytkowników, którzy korzystają z poszczególnych preferencji',
	'prefstats-title' => 'Statystyki dla preferencji',
	'prefstats-list-intro' => 'Obecnie następujące preferencje są analizowane.
Kliknij na jednej aby zobaczyć statystyki jej dotyczące.',
	'prefstats-noprefs' => 'Żadne preferencje nie są obecnie śledzone. Skonfiguruj $wgPrefStatsTrackPrefs aby śledzić preferencje.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|użytkownik włączał|użytkowników włączało}} tę opcję od momentu aktywowania tej statystyki
** $2 {{PLURAL:$2|użytkownik|użytkowników}} ma tę opcję włączoną
** $3 {{PLURAL:$3|użytkownik|użytkowników}} ma tę opcję wyłączoną',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|użytkownik włączał|użytkowników włączało}} tę opcję od momentu aktywowania tej statystyki
** $2 {{PLURAL:$2|użytkownik|użytkowników}} ma tę opcję włączoną
** $3 {{PLURAL:$3|użytkownik|użytkowników}} ma tę opcję wyłączoną
* Ogólnie $4  {{PLURAL:$4|użytkownik|użytkowników}} ustawiło tę opcję',
	'prefstats-xaxis' => 'Czas trwania (godz.)',
	'prefstats-factors' => 'Widoczny okres – $1',
	'prefstats-factor-hour' => 'godzina',
	'prefstats-factor-sixhours' => 'sześć godzin',
	'prefstats-factor-day' => 'dzień',
	'prefstats-factor-week' => 'tydzień',
	'prefstats-factor-twoweeks' => 'dwa tygodnie',
	'prefstats-factor-fourweeks' => 'cztery tygodnie',
	'prefstats-factor-default' => 'powrót do domyślnej skali',
	'prefstats-legend-out' => 'Korzystali',
	'prefstats-legend-in' => 'Korzystają',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'prefstats' => 'Statìstiche dle preferense',
	'prefstats-desc' => "Trassa statìstiche ch'a dan vàire utent a l'han serte preferense abilità",
	'prefstats-title' => 'Statìstiche dle preferense',
	'prefstats-list-intro' => 'Al moment, le preferense sota a son trassà.
Sgnaca su un-a për vëdde le statìstiche an dzora a chila.',
	'prefstats-noprefs' => 'Pa gnun-e preferense trassà al moment.
Configura $wgPrefStatsTrackPrefs për trassé l epreferense.',
	'prefstats-counters' => "* $1 {{PLURAL:$1|utent a l'ha|utent a l'han}} abilità sta preferensa-sì
** $2 {{PLURAL:$2|utent al l'ha|utent al l'han}} ancó abilità
** $3 {{PLURAL:$3|utent a l'ha|utent a l'han}} disabilitala",
	'prefstats-counters-expensive' => "* $1 {{PLURAL:$1|utent a l'ha|utent a l'han}} abilità sta preferensa-sì
** $2 {{PLURAL:$2|utent al l'ha|utent al l'han}} ancó abilità
** $3 {{PLURAL:$3|utent a l'ha|utent a l'han}} disabilitala
* An total, $4 {{PLURAL:$4|utent a l'ha|utent a l'han}} sta preferensa-sì ampostà",
	'prefstats-xaxis' => 'Durà (ore)',
	'prefstats-factors' => 'Varda për: $1',
	'prefstats-factor-hour' => 'ora',
	'prefstats-factor-sixhours' => 'ses ore',
	'prefstats-factor-day' => 'di',
	'prefstats-factor-week' => 'sman-e',
	'prefstats-factor-twoweeks' => 'doe sman-e',
	'prefstats-factor-fourweeks' => 'quatr sman-e',
	'prefstats-factor-default' => 'Torna a la scala ëd default',
	'prefstats-legend-out' => 'Sërnù fòra',
	'prefstats-legend-in' => 'Sërnù drinta',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'prefstats' => 'پسند دے سعاب کتاب',
	'prefstats-desc' => 'سعاب کتاب ویکھو جے کنے ورتن والیاں نے اپنے پسند دے سعاب کتاب نوں چلایا۔',
	'prefstats-title' => 'پسند دے سعاب کتاب',
	'prefstats-list-intro' => 'ایس ویلے تھلے دتیاں گیاں پسند دیاں چیزاں دا سعاب رکھیا جاریا اے۔
اے سعاب کتاب ویکھن لئی کلک کرو',
	'prefstats-noprefs' => 'کوئی پسندی سعاب کتاب اس ویلے نئیں ویکھیا جاریا۔
پسندی سعاب کتاب ویکھن لئی $wgPrefStatsTrackPrefs نوں ویکھو',
	'prefstats-counters' => '* $1 {{انیک:$1|ورتن والا|ورتن والے}} نے ایس تانگ نوں قابل کیتا جدوں تانگ سعاب کتاب چلیا
** $2 {{انیک:$2|ورتن والا|ورتن والے}} قابل کیتا
** $3 {{انیک:$3|ورتن والا|ورتن والے}} نکارہ کیتا',
	'prefstats-counters-expensive' => '* $1 {{انیک:$1|ورتن والا|ورتن والے}} جدوں تانگاںدا سعاب چلیا تے تانگاں اودوں دیاں چل ریاں نیں
** $2 {{انیک:$2|ورتن والے نے|ورتن والیاں نیں}} اینوں قابل کیتا اے
** $3 {{انیک:$3|ورتن والے نے|ورتن والیاں نیں}} ناقابل کیتا اے
* In total, $4 {{انیک:$4|ورتن والے نے|ورتن والیاں نیں}} اے تانگ سیٹ اے',
	'prefstats-xaxis' => 'ویلہ (کینٹیاں چ)',
	'prefstats-factors' => 'وکھالہ : $1',
	'prefstats-factor-hour' => 'کینٹہ',
	'prefstats-factor-sixhours' => 'چھے کینٹے',
	'prefstats-factor-day' => 'دیاڑھ',
	'prefstats-factor-week' => 'ہفتہ',
	'prefstats-factor-twoweeks' => 'دو ہفتے',
	'prefstats-factor-fourweeks' => 'چار ہفتے',
	'prefstats-factor-default' => 'ڈیفالٹ ناپ ول چلو',
	'prefstats-legend-out' => 'وکھرا کرنا',
	'prefstats-legend-in' => 'چننا',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'prefstats-title' => 'د غوره توبونو شمار',
	'prefstats-xaxis' => 'موده (ساعتونه)',
	'prefstats-factor-hour' => 'ساعت',
	'prefstats-factor-sixhours' => 'شپږ ساعته',
	'prefstats-factor-day' => 'ورځ',
	'prefstats-factor-week' => 'اونۍ',
	'prefstats-factor-twoweeks' => 'دوه اونۍ',
	'prefstats-factor-fourweeks' => 'څلور اونۍ',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'prefstats' => 'Estatísticas de preferências',
	'prefstats-desc' => 'Monitorizar estatísticas de quantos utilizadores têm certas preferências activadas',
	'prefstats-title' => 'Estatísticas de preferências',
	'prefstats-list-intro' => 'Neste momento estão a ser monitorizadas as seguintes preferências.
Clique numa delas para ver as estatísticas dessa preferência.',
	'prefstats-noprefs' => 'As preferências não estão a ser monitorizadas.
Para monitorizá-las configure $wgPrefStatsTrackPrefs.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|utilizador activou|utilizadores activaram}} esta preferência desde que são coligidas estatísticas de preferências
** $2 {{PLURAL:$2|utilizador mantém|utilizadores mantêm}} esta preferência activa
** $3 {{PLURAL:$3|utilizador desactivou-a|utilizadores desactivaram-na}} desde então',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|utilizador activou|utilizadores activaram}} esta preferência desde que são coligidas estatísticas de preferências
** $2 {{PLURAL:$2|utilizador mantém|utilizadores mantêm}} esta preferência activa
** $3 {{PLURAL:$3|utilizador desactivou-a|utilizadores desactivaram-na}} desde então
* No total, $4 {{PLURAL:$4|utilizador tem|utilizadores têm}} esta preferência activada',
	'prefstats-xaxis' => 'Duração (horas)',
	'prefstats-factors' => 'Visionar por: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'seis horas',
	'prefstats-factor-day' => 'dia',
	'prefstats-factor-week' => 'semana',
	'prefstats-factor-twoweeks' => 'duas semanas',
	'prefstats-factor-fourweeks' => 'quatro semanas',
	'prefstats-factor-default' => 'repor a escala padrão',
	'prefstats-legend-out' => 'Desactivou',
	'prefstats-legend-in' => 'Activou',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 * @author Eduardo.mps
 * @author Helder.wiki
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'prefstats' => 'Estatísticas de preferências',
	'prefstats-desc' => 'Monitore estatísticas sobre quantos usuários têm certas preferências ativadas',
	'prefstats-title' => 'Estatísticas de preferências',
	'prefstats-list-intro' => 'Atualmente, as seguintes preferências estão sendo monitoradas.
Clique em uma para ver as estatísticas sobre ela.',
	'prefstats-noprefs' => 'Nenhuma preferência está sendo monitorada no momento.
Configure $wgPrefStatsTrackPrefs para monitorar preferências.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|usuário habilitou|usuários habilitaram}} esta preferência desde que as estatísticas foram ativadas
** Ela foi habilitada por $2 {{PLURAL:$2|usuário|usuários}}
** Ela foi desabilitada por $3 {{PLURAL:$3|usuário|usuários}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|habilitou|habilitaram}} esta preferência desde que as estatísticas de preferências foram habilitadas
** Ela foi habilitada por $2 {{PLURAL:$2|usuário|usuários}}
** Ela foi desabilitada por $3 {{PLURAL:$3|usuário|usuários}}
* Ao todo, $4 {{PLURAL:$4|usuário|usuários}} definiram esta preferência',
	'prefstats-xaxis' => 'Duração (horas)',
	'prefstats-factors' => 'Visualizar por: $1',
	'prefstats-factor-hour' => 'hora',
	'prefstats-factor-sixhours' => 'seis horas',
	'prefstats-factor-day' => 'dia',
	'prefstats-factor-week' => 'semana',
	'prefstats-factor-twoweeks' => 'duas semanas',
	'prefstats-factor-fourweeks' => 'quatro semanas',
	'prefstats-factor-default' => 'retornar à escala padrão',
	'prefstats-legend-out' => 'Saiu',
	'prefstats-legend-in' => 'Entrou',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'prefstats' => 'Munakusqa ranuy (kanchachani)',
	'prefstats-desc' => "Kaypiqa rukunki, hayk'a ruraqkuna ima munakusqankunata allinkachina nisqapi akllarqan",
	'prefstats-title' => 'Munakusqa ranuy (kanchachani)',
	'prefstats-list-intro' => "Kunanqa kay qatiq allinkachinakunam qatipasqa kachkanku.
Hukta ñit'ispa akllay paymanta ranuyta (kanchachanita) qhawanaykipaq.",
	'prefstats-noprefs' => 'Kunanqa manam ima allinkachinakunapas qatipasqa kachkankuchu.
$wgPrefStatsTrackPrefs nisqata allinchaykuy allinkachinakunata qatipanaykipaq.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|ruraqmi|ruraqmi}} kay allinkachinayuq kachkan, allinkachina ranuypa qallarisqanmantapacha
** $2 {{PLURAL:$2|ruraqraqmi|ruraqraqmi}} kay allinkachinayuq
** $3 {{PLURAL:$3|ruraqmi|ruraqmi}} mana kay allinkachinayuq',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|ruraqmi|ruraqmi}} kay allinkachinayuq kachkan, allinkachina ranuypa qallarisqanmantapacha
** $2 {{PLURAL:$2|ruraqraqmi|ruraqraqmi}} kay allinkachinayuq
** $3 {{PLURAL:$3|ruraqmi|ruraqmi}} mana kay allinkachinayuq 
* Tukuymantaqa $4 {{PLURAL:$4|ruraqmi|ruraqmi}} kay allinkachinata hukcharqan',
	'prefstats-xaxis' => "Mit'a (pacha/urakuna)",
	'prefstats-factors' => 'Rikuy llapa: $1',
	'prefstats-factor-hour' => 'ura',
	'prefstats-factor-sixhours' => 'suqta ura',
	'prefstats-factor-day' => "p'unchaw",
	'prefstats-factor-week' => 'simana',
	'prefstats-factor-twoweeks' => 'iskay simana',
	'prefstats-factor-fourweeks' => 'tawa simana',
	'prefstats-factor-default' => 'kikinmanta kaq iskalaman kutimuy',
	'prefstats-legend-out' => 'Mana atichisqa',
	'prefstats-legend-in' => 'Atichisqa',
);

/** Romanian (Română)
 * @author AdiJapan
 * @author Firilacroco
 * @author Minisarm
 * @author Stelistcristi
 * @author Strainu
 */
$messages['ro'] = array(
	'prefstats' => 'Statistici despre preferințe',
	'prefstats-desc' => 'Urmărirea statisticilor referitoare la numărul utilizatorilor care au activat o anumită preferință',
	'prefstats-title' => 'Statistici despre preferințe',
	'prefstats-list-intro' => 'În prezent, următoarele preferințe sunt urmărite.
Apăsați pe una dintre ele pentru a vizualiza statisticile în cauză.',
	'prefstats-noprefs' => 'Nicio preferință nu este în prezent urmărită.
Configurați $wgPrefStatsTrackPrefs pentru a urmări preferințe.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|utilizator și-a|utilizatori și-au}} activat această preferință de cînd a început colectarea datelor statistice
** $2 {{PLURAL:$2|utilizator încă o are|utilizatori încă o au}} activată
** $3 {{PLURAL:$3|utilizator și-a|utilizatori și-au}} dezactivat-o între timp',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|utilizator și-a|utilizatori și-au}} activat această preferință de cînd a început colectarea datelor statistice
** $2 {{PLURAL:$2|utilizator încă o are|utilizatori încă o au}} activată
** $3 {{PLURAL:$3|utilizator și-a|utilizatori și-au}} dezactivat-o între timp
În total $4 {{PLURAL:$4|utilizator folosește|utilizatori folosesc}} această preferință',
	'prefstats-xaxis' => 'Durată (ore)',
	'prefstats-factors' => 'Vizualizări pe: $1',
	'prefstats-factor-hour' => 'oră',
	'prefstats-factor-sixhours' => 'șase ore',
	'prefstats-factor-day' => 'zi',
	'prefstats-factor-week' => 'săptămână',
	'prefstats-factor-twoweeks' => 'două săptămâni',
	'prefstats-factor-fourweeks' => 'patru săptămâni',
	'prefstats-factor-default' => 'înapoi la scala inițială',
	'prefstats-legend-out' => 'Renunțat',
	'prefstats-legend-in' => 'Optat',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'prefstats' => 'Statistece de preferenze',
	'prefstats-desc' => 'Traccie le statisteche sus a quanda utinde onne certe preferenze abbilitate',
	'prefstats-title' => 'Statisteche de le preferenze',
	'prefstats-list-intro' => 'Pe mò, le seguende preferenze stonne avènene tracciate.
Cazze sus a une de le statisteche da vedè.',
	'prefstats-noprefs' => 'Nisciuna preferenze ha state tracciate pe mò. Configure $wgPrefStatsTrackPrefs pe traccià le preferenze.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|utende ave|utinde onne}} abbilitate sta preferenze da quanne le statisteche sus a le preferenze onne state attivate<br />
** $2 {{PLURAL:$2|utende a tène angore|utinde a tènene angore}} abbilitate<br />
** $3 {{PLURAL:$3|utende a tène|utinde a tènene}} disabbilitate',
	'prefstats-counters-expensive' => "* $1 {{PLURAL:$1|utende ave|utinde onne}} abbilitate sta preferenze da quanne le statisteche sus a le preferenze onne state attivate<br />
** $2 {{PLURAL:$2|utende a tène angore|utinde a tènene angore}} abbilitate<br />
** $3 {{PLURAL:$3|utende a tène|utinde a tènene}} disabbilitate <br />
* In totale, $4 {{PLURAL:$4|utende ave|utinde onne}} st'inzieme de preferenze",
	'prefstats-xaxis' => 'Durate (ore)',
	'prefstats-factors' => 'Visite pe: $1',
	'prefstats-factor-hour' => 'ore',
	'prefstats-factor-sixhours' => 'sei ore',
	'prefstats-factor-day' => 'sciurne',
	'prefstats-factor-week' => 'sumáne',
	'prefstats-factor-twoweeks' => 'doje sumáne',
	'prefstats-factor-fourweeks' => 'quattre sumáne',
	'prefstats-factor-default' => "tuèrne a 'a scale de base",
	'prefstats-legend-out' => 'Nò partecipà cchiù',
	'prefstats-legend-in' => 'Pigghie parte',
);

/** Russian (Русский)
 * @author AlexSm
 * @author Ferrer
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'prefstats' => 'Статистика настроек',
	'prefstats-desc' => 'Отслеживание статистики о том, сколько участников включили у себя те или иные настройки',
	'prefstats-title' => 'Статистика настроек',
	'prefstats-list-intro' => 'Сейчас отслеживаются следующие настройки.
Выберите одну из них для просмотра статистики.',
	'prefstats-noprefs' => 'В настоящее время настройки не отслеживаются.
Установите $wgPrefStatsTrackPrefs для отслеживания настроек.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|участник включил|участника включили|участников включили}} этот параметр с момента начала сбора статистики
** $2 {{PLURAL:$2|участник оставил|участника оставили|участников оставили}} параметр включённым
** $3 {{PLURAL:$3|участник выключил|участника выключили|участников выключили}} параметр',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|участник включил|участника включили|участников включили}} этот параметр, с момента начала работы статистики по параметрам
** $2 {{PLURAL:$2|участник включил|участника включили|участников включили}} параметр
** $3 {{PLURAL:$3|участник выключил|участника выключили|участников выключили}} параметр
* Всего этот параметр установлен у $4 {{PLURAL:$4|участника|участников|участников}}',
	'prefstats-xaxis' => 'Продолжительность (в часах)',
	'prefstats-factors' => 'Просмотр за: $1',
	'prefstats-factor-hour' => 'час',
	'prefstats-factor-sixhours' => 'шесть часов',
	'prefstats-factor-day' => 'день',
	'prefstats-factor-week' => 'неделя',
	'prefstats-factor-twoweeks' => 'две недели',
	'prefstats-factor-fourweeks' => 'четыре недели',
	'prefstats-factor-default' => 'назад к масштабу по умолчанию',
	'prefstats-legend-out' => 'Отключились',
	'prefstats-legend-in' => 'Подключились',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'prefstats' => 'Штатістіка наставлїнь',
	'prefstats-desc' => 'Штатістічне слїдованя того, кілько хоснователїв хоснує котры наставлїня',
	'prefstats-title' => 'Штатістіка наставлїнь',
	'prefstats-list-intro' => 'Теперь ся слїдують наслїдуючі наставлїня.
Кликнутём зобразите прислухаючу штатістіку.',
	'prefstats-noprefs' => 'Моменталнї ся не слїдує жадне наставлїня. Слїдованя мусите наконфіґуровати в $wgPrefStatsTrackPrefs.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|хоснователь собі актівовав|хоснователї собі актівовали|хоснователїв собі актівовало}} тот параметер од початку робиня штатістікы.
** $2 {{PLURAL:$2|хоснователь  єй собі запнув|хоснователї єй собі запнули|хоснователїв собі єй запнуло}}
** $3 {{PLURAL:$3|хоснователь  єй собі выпнув|хоснователї єй собі выпнули|хоснователїв собі єй выпнуло}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|хоснователь собі актівовав|хоснователї собі актівовали|хоснователїв собі актівовало}} тот параметер од початку робиня штатістікы.
** $2 {{PLURAL:$2|хоснователь  єй собі запнув|хоснователї єй собі запнули|хоснователїв собі єй запнуло}}
** $3 {{PLURAL:$3|хоснователь  єй собі выпнув|хоснователї єй собі выпнули|хоснователїв собі єй выпнуло}}
* Цілком {{PLURAL:$4|має|мають|має}} тот параметер наставлено  $4 {{PLURAL:$4|хоснователь|хоснователї|хоснователїв}}',
	'prefstats-xaxis' => 'Тырваня (в годинах)',
	'prefstats-factors' => 'Зобразити по: $1',
	'prefstats-factor-hour' => 'годину',
	'prefstats-factor-sixhours' => 'шість годин',
	'prefstats-factor-day' => 'день',
	'prefstats-factor-week' => 'тыждень',
	'prefstats-factor-twoweeks' => 'два тыжднї',
	'prefstats-factor-fourweeks' => 'штири тыжднї',
	'prefstats-factor-default' => 'назад на імпліцітну шкалу',
	'prefstats-legend-out' => 'Одголошіня',
	'prefstats-legend-in' => 'Приголошіня',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'prefstats-factor-hour' => 'घंटा',
	'prefstats-factor-day' => 'दिवस',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'prefstats' => 'Туруоруулар статиистикалара',
	'prefstats-desc' => 'Хас киһи ханнык эмит туруорууну талбыттарын көрүү',
	'prefstats-title' => 'Туруоруулар статиистикалара',
	'prefstats-list-intro' => 'Билигин маннык туруоруулар ааҕыллыахтарын сөп.
Статиистикатын көрөргө ханныгы эмит биири тал.',
	'prefstats-noprefs' => 'Билигин туруоруулар кэтэммэттэр.
Ону кэтиир гынарга $wgPrefStatsTrackPrefs туруор.',
	'prefstats-counters' => '* $1 кыттааччы бу туруорууну холбоммут (туруоруулары ааҕар кэмтэн ыла)
** $2 кыттааччы холбообут
** $3 кыттааччы араарбыт',
	'prefstats-counters-expensive' => '* $1 кыттааччы бу туруорууну холбоммут (туруоруулары ааҕар кэмтэн ыла)
** $2 кыттааччы холбообут
** $3 кыттааччы араарбыт
* Барыта бу туруорууну $4 кыттааччы холбообут.',
	'prefstats-xaxis' => 'Болдьоҕо, уһуна (чааһынан)',
	'prefstats-factors' => 'Баччалыынан көрдөр: $1',
	'prefstats-factor-hour' => 'чаас',
	'prefstats-factor-sixhours' => 'алта чаас',
	'prefstats-factor-day' => 'хонук',
	'prefstats-factor-week' => 'нэдиэлэ',
	'prefstats-factor-twoweeks' => 'икки нэдиэлэ',
	'prefstats-factor-fourweeks' => 'түөрт нэдиэлэ',
	'prefstats-factor-default' => 'төттөрү, ыйыллыбатаҕына көстөр улаханыгар (масштаабыгар)',
	'prefstats-legend-out' => 'Арахсарга',
	'prefstats-legend-in' => 'Холбонорго',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'prefstats-xaxis' => 'Durada (oras)',
	'prefstats-factors' => 'Abbista pro: $1',
	'prefstats-factor-hour' => 'ora',
	'prefstats-factor-sixhours' => 'ses oras',
	'prefstats-factor-day' => 'die',
	'prefstats-factor-week' => 'chida',
	'prefstats-factor-twoweeks' => 'duas chidas',
	'prefstats-factor-fourweeks' => 'bator chidas',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 * @author Melos
 */
$messages['scn'] = array(
	'prefstats' => 'Statistichi dê prifirenzi',
	'prefstats-title' => 'Statistichi dê prifirenzi',
	'prefstats-factor-day' => 'jornu',
	'prefstats-factor-week' => 'simana',
	'prefstats-factor-twoweeks' => 'dui simani',
	'prefstats-factor-fourweeks' => 'quattru simani',
);

/** Sinhala (සිංහල)
 * @author Budhajeewa
 * @author Calcey
 * @author චතුනි අලහප්පෙරුම
 */
$messages['si'] = array(
	'prefstats' => 'වරණීය සංඛ්‍යාන දත්ත',
	'prefstats-desc' => 'කිනම් පරිශීලක පිරිසක් ඒ ඒ රිසිකෙරුම් සක්‍රීය කොට ඇතිදැය් සොයා බැලීම',
	'prefstats-title' => 'වරණිය සංඛ්‍යායනය',
	'prefstats-list-intro' => 'මේ වන විට පහත රිසිකෙරුම් පරීක්‍ෂාව යටතේ පවතී.
සංඛ්‍යාලේඛන පරීක්‍ෂාවට ඉන් එකක් මත ක්ලික් කරන්න.',
	'prefstats-noprefs' => 'මේ වන විට කිසිදු රිසිකෙරුමක් පරීක්‍ෂාව යටතේ නැත.
රිසිකෙරුම් පරීක්‍ෂාව යටතට පත් කෙරුමට $wgPrefStatsTrackPrefs සකසන්න.',
	'prefstats-counters' => '* රිසිකෙරුම් සංඛ්‍යාලේඛනය සක්‍රීය කළ මොහොතේ පටන් පරිශීලකයන් $1 {{PLURAL:$1|අයෙක්|දෙනෙක්}} මෙය සක්‍රීය කොට ඇත
** පරිශීලකයන් $2 {{PLURAL:$2|අයෙක්|දෙනෙක්}} තවමත් එය සක්‍රීයව තබාගෙන සිටිති
** පරිශීලකයන් $3 {{PLURAL:$3|අයෙක්|දෙනෙක්}} එය අක්‍රීය කොට ඇත',
	'prefstats-counters-expensive' => '* රිසිකෙරුම් සංඛ්‍යාලේඛනය සක්‍රීය කළ මොහොතේ පටන් පරිශීලකයන් $1 {{PLURAL:$1|අයෙක්|දෙනෙක්}} මෙය සක්‍රීය කොට ඇත
** පරිශීලකයන් $2 {{PLURAL:$2|අයෙක්|දෙනෙක්}} තවමත් එය සක්‍රීයව තබාගෙන සිටිති
** පරිශීලකයන් $3 {{PLURAL:$3|අයෙක්|දෙනෙක්}} එය අක්‍රීය කොට ඇත
* සමස්ථයක් වශයෙන්, පරිශීලකයන් $4 {{PLURAL:$4|අයෙක්|දෙනෙක්}} මෙම රිසිකරණය භාවිතා කරති',
	'prefstats-xaxis' => 'කාල සීමාව (පැය)',
	'prefstats-factors' => ' $1: කට නැරඹුම්',
	'prefstats-factor-hour' => 'පැය',
	'prefstats-factor-sixhours' => 'පැය හය',
	'prefstats-factor-day' => 'දිනය',
	'prefstats-factor-week' => 'සතිය',
	'prefstats-factor-twoweeks' => 'සති දෙක',
	'prefstats-factor-fourweeks' => 'සති හතර',
	'prefstats-factor-default' => 'යළි පෙර නිමි පරිමාණයට',
	'prefstats-legend-out' => 'ඉවත් කෙරුමට තීරණය කළ',
	'prefstats-legend-in' => 'අන්තර්ගත කෙරුමට තීරණය කළ',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'prefstats' => 'Štatistika nastavení',
	'prefstats-desc' => 'Umožňuje sledovať štatistiku, koľko ľudí má zapnutú určitú voľbu v nastaveniach',
	'prefstats-title' => 'Štatistika nastavení',
	'prefstats-list-intro' => 'Momentálne sa sledujú nasledovné nastavenia.
Po kliknutí na niektoré z nich zobrazíte štatistiku o ňom.',
	'prefstats-noprefs' => 'Momentálne sa nesledujú žiadne nastavenia. Ak chcete sledovať nastavenia, nastavte $wgPrefStatsTrackPrefs.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|používateľ zapol|používatelia zapli|používateľov zaplo}} túto voľbu od aktivácie štatistiky nastavení
** $2 {{PLURAL:$2|používateľ ju zapol|používatelia ju zapli|používateľov ju zaplo}}
** $3 {{PLURAL:$3|používateľ ju vypol|používatelia ju vypli|používateľov ju vyplo}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|používateľ zapol|používatelia zapli|používateľov zaplo}} túto voľbu od aktivácie štatistiky nastavení
** $2 {{PLURAL:$2|používateľ ju zapol|používatelia ju zapli|používateľov ju zaplo}}
** $3 {{PLURAL:$3|používateľ ju vypol|používatelia ju vypli|používateľov ju vyplo}}
* Celkom {{PLURAL:$4|má|majú}} túto voľbu zapnutú $4 {{PLURAL:$4|používateľ|používatelia|používateľov}}',
	'prefstats-xaxis' => 'Trvanie (hodín)',
	'prefstats-factors' => 'Zobrazenie za: $1',
	'prefstats-factor-hour' => 'hodina',
	'prefstats-factor-sixhours' => 'šesť hodín',
	'prefstats-factor-day' => 'deň',
	'prefstats-factor-week' => 'týždeň',
	'prefstats-factor-twoweeks' => 'dva týždne',
	'prefstats-factor-fourweeks' => 'štyri týždne',
	'prefstats-factor-default' => 'späť na predvolenú mierku',
	'prefstats-legend-out' => 'Odhlásený',
	'prefstats-legend-in' => 'Prihlásený',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 * @author Smihael
 */
$messages['sl'] = array(
	'prefstats' => 'Statistika nastavitev',
	'prefstats-desc' => 'Spremlja statistike o tem, koliko uporabnikov ima omogočene določene nastavitve',
	'prefstats-title' => 'Statistika nastavitev',
	'prefstats-list-intro' => 'Trenutno so naslednje nastavitve spremljane.
Kliknite na eno, če si želite ogledati njeno statistiko.',
	'prefstats-noprefs' => 'Trenutno nastavitve niso spremljane.
Omogočite spremljanje nastavitev v $wgPrefStatsTrackPrefs.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|uporabnik je omogočil|uporabnika sta omogočila|uporabiki so omogočili|uporabnikov je omogočilo}} to nastavitev odkar je bila začeta statistika nastavitev
** $2 {{PLURAL:$2|uporabnik jo ima še vedno|uporabnika jo imata še vedno|uporabniki jo imajo še vedno|uporabnikov jo ima še vedno}} omogočeno
** $3 {{PLURAL:$3|uporabnik jo je|uporabnika sta jo|uporabniki so jo|uporabnikov jo je}} od takrat {{PLURAL:$3|onemogočil|onemogočila|onemogočili|onemogočilo}}',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|uporabnik je omogočil|uporabnika sta omogočila|uporabiki so omogočili|uporabnikov je omogočilo}} to nastavitev odkar je bila začeta statistika nastavitev
** $2 {{PLURAL:$2|uporabnik jo ima še vedno|uporabnika jo imata še vedno|uporabniki jo imajo še vedno|uporabnikov jo ima še vedno}} omogočeno
** $3 {{PLURAL:$3|uporabnik jo je|uporabnika sta jo|uporabniki so jo|uporabnikov jo je}} od takrat {{PLURAL:$3|onemogočil|onemogočila|onemogočili|onemogočilo}}
* Skupno, $4 {{PLURAL:$4|uporabnik ima|uporabnika imata|uporabniki ima|uporabnikov ima}} izbrano to nastavitev',
	'prefstats-xaxis' => 'Trajanje (ur)',
	'prefstats-factors' => 'Poglejte na: $1',
	'prefstats-factor-hour' => 'ura',
	'prefstats-factor-sixhours' => 'šest ur',
	'prefstats-factor-day' => 'dan',
	'prefstats-factor-week' => 'teden',
	'prefstats-factor-twoweeks' => 'dva tedna',
	'prefstats-factor-fourweeks' => 'štiri tedni',
	'prefstats-factor-default' => 'nazaj na privzeto lestvico',
	'prefstats-legend-out' => 'Onemogočeno',
	'prefstats-legend-in' => 'Omogočeno',
);

/** Albanian (Shqip)
 * @author Mikullovci11
 * @author Olsi
 */
$messages['sq'] = array(
	'prefstats' => 'Statistikat e preferencave',
	'prefstats-desc' => 'Ndiqni statistikat se sa përdorues kanë të aktivizuara preferenca të caktuara',
	'prefstats-title' => 'Statistikat e preferencave',
	'prefstats-list-intro' => 'Aktualisht, preferencat e mëposhtmë po ndiqen.
Klikoni mbi një për të parë statistikat në lidhje me të.',
	'prefstats-noprefs' => 'Asnjë preferencë nuk po ndiqet.
Konfiguroni $wgPrefStatsTrackPrefs për të ndjekur preferencat.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|përdoruesi ka|përdoruesit kanë}} aktivizuar këtë preferencë që kur statistikat e preferencave u aktivizuan
** $2  {{PLURAL:$2|përdoruesi e ka akoma|përdoruesit e kanë akoma}} të aktivizuar
** $3 {{PLURAL:$3|përdoruesi e ka|përdoruesit e kanë}} e kanë çaktivizuar që',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|përdoruesi ka|përdoruesit kanë}} aktivizuar këtë preferencë që kur statistikat e preferencave u aktivizuan
** $2  {{PLURAL:$2|përdoruesi e ka akoma|përdoruesit e kanë akoma}} të aktivizuar
** $3 {{PLURAL:$3|përdoruesi e ka|përdoruesit e kanë}} e kanë çaktivizuar që
* Në total, $4 {{PLURAL:$4|përdoruesi e ka|përdoruesit e kanë}} të vendosur këtë preferencë',
	'prefstats-xaxis' => 'Kohëzgjatja (orë)',
	'prefstats-factors' => 'Shikoni për: $1',
	'prefstats-factor-hour' => 'Orë',
	'prefstats-factor-sixhours' => 'gjashtë orë',
	'prefstats-factor-day' => 'ditë',
	'prefstats-factor-week' => 'javë',
	'prefstats-factor-twoweeks' => 'dy javë',
	'prefstats-factor-fourweeks' => 'katër javë',
	'prefstats-factor-default' => 'kthehuni tek shkalla kryesore',
	'prefstats-legend-out' => 'Vendosur jashtë',
	'prefstats-legend-in' => 'Vendosur brenda',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'prefstats' => 'Статистике поставки',
	'prefstats-desc' => 'Праћење статистика које говоре колико корисника има омогућене одређене поставке',
	'prefstats-title' => 'Статистике поставки',
	'prefstats-list-intro' => 'Тренутно се прате следеће поставке.
Кликните на једну од њих да бисте видели њене статистике.',
	'prefstats-noprefs' => 'Тренутно се не прати ниједна поставка.
Подесите $wgPrefStatsTrackPrefs да прати поставке.',
	'prefstats-xaxis' => 'Трајање (у сатима)',
	'prefstats-factors' => 'Преглед за: $1',
	'prefstats-factor-hour' => 'сат',
	'prefstats-factor-sixhours' => 'шест сати',
	'prefstats-factor-day' => 'дан',
	'prefstats-factor-week' => 'недеља',
	'prefstats-factor-twoweeks' => 'две недеље',
	'prefstats-factor-fourweeks' => 'четири недеље',
	'prefstats-factor-default' => 'врати се на подразумевану скалу',
	'prefstats-legend-out' => 'Приступили',
	'prefstats-legend-in' => 'Напустили',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'prefstats' => 'Statistike postavki',
	'prefstats-desc' => 'Praćenje statistika koje govore koliko korisnika ima omogućene određene postavke',
	'prefstats-title' => 'Statistike postavki',
	'prefstats-list-intro' => 'Trenutno se prate sledeće postavke.
Kliknite na jednu od njih da biste videli njene statistike.',
	'prefstats-noprefs' => 'Trenutno se ne prati nijedna postavka.
Podesite $wgPrefStatsTrackPrefs da prati postavke.',
	'prefstats-xaxis' => 'Trajanje (sati)',
	'prefstats-factors' => 'Pregled za: $1',
	'prefstats-factor-hour' => 'sat',
	'prefstats-factor-sixhours' => 'šest sati',
	'prefstats-factor-day' => 'dan',
	'prefstats-factor-week' => 'nedelja',
	'prefstats-factor-twoweeks' => 'dve nedelje',
	'prefstats-factor-fourweeks' => '4 nedelje',
	'prefstats-factor-default' => 'vrati se na podrazumevanu skalu',
	'prefstats-legend-out' => 'Pristupili',
	'prefstats-legend-in' => 'Napustili',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'prefstats' => 'Statistika préferénsi',
	'prefstats-title' => 'Statistika préferénsi',
	'prefstats-xaxis' => 'Durasi (jam)',
	'prefstats-factors' => 'Tempo unggal: $1',
	'prefstats-factor-hour' => 'jam',
	'prefstats-factor-sixhours' => 'genep jam',
	'prefstats-factor-day' => 'poé',
	'prefstats-factor-week' => 'minggu',
	'prefstats-factor-twoweeks' => 'dua minggu',
	'prefstats-factor-fourweeks' => 'opat minggu',
	'prefstats-factor-default' => 'balik deui ka skala buhun',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Ozp
 * @author Rotsee
 */
$messages['sv'] = array(
	'prefstats' => 'Statistik över inställningar',
	'prefstats-desc' => 'Statistik över hur många användare som har vissa inställningar',
	'prefstats-title' => 'Statistik över inställningar',
	'prefstats-list-intro' => 'För närvarande spåras följande inställningar.
Klicka på en inställning för att visa statistik om den.',
	'prefstats-noprefs' => 'Inga inställningar spåras för närvarande. Ändra $wgPrefStatsTrackPrefs för att spåra inställningar.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|användare|användare}} har slagit på den här inställningen sedan spårningen av inställningar inleddes.
** $2 {{PLURAL:$2|användare|användare}} har slagit på den
** $3 {{PLURAL:$3|användare|användare}} har slagit av den',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|användare|användare}} har slagit på den här inställningen sedan spårningen av inställningar inleddes
** $2 {{PLURAL:$2|användare|användare}} har slagit på den
** $3 {{PLURAL:$3|användare|användare}} har slagit av den
* Sammanlagt har $4 {{PLURAL:$4|användare|användare}} den här inställningen påslagen',
	'prefstats-xaxis' => 'Varaktighet (timmar)',
	'prefstats-factors' => 'Visa efter $1',
	'prefstats-factor-hour' => 'timme',
	'prefstats-factor-sixhours' => 'sex timmar',
	'prefstats-factor-day' => 'dag',
	'prefstats-factor-week' => 'vecka',
	'prefstats-factor-twoweeks' => 'två veckor',
	'prefstats-factor-fourweeks' => 'fyra veckor',
	'prefstats-factor-default' => 'återgå till standardskala',
	'prefstats-legend-out' => 'Lämnat',
	'prefstats-legend-in' => 'Deltar',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 * @author Muddyb Blast Producer
 */
$messages['sw'] = array(
	'prefstats' => 'Takwimu za mapendekezo',
	'prefstats-desc' => 'Fuatilia takwimu kuhusu idadi ya watumiaji wanaotumia mapendekezo fulani',
	'prefstats-title' => 'Takwimu za mapendekezo',
	'prefstats-list-intro' => 'Hivi sasa, mapendekezo yafuatayo yanafuatiliwa. 
Bonyeza kitu ili kuangalia takwimu zake.',
	'prefstats-xaxis' => 'Muda (masaa)',
	'prefstats-factors' => 'Tazama kwa: $1',
	'prefstats-factor-hour' => 'saa',
	'prefstats-factor-sixhours' => 'masaa sita',
	'prefstats-factor-day' => 'siku',
	'prefstats-factor-week' => 'wiki',
	'prefstats-factor-twoweeks' => 'wiki mbili',
	'prefstats-factor-fourweeks' => 'wiki nne',
	'prefstats-factor-default' => 'rudi kwa kipimo cha chaguo-msingi',
	'prefstats-legend-out' => 'Walioamua kutoshiriki',
	'prefstats-legend-in' => 'Waliochagua kushiriki',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 * @author TRYPPN
 * @author செல்வா
 */
$messages['ta'] = array(
	'prefstats' => 'விருப்பங்களின் புள்ளிவிவரங்கள்',
	'prefstats-desc' => 'எவ்வளவு பயனீட்டாளர்கள்   சில விருப்பங்களை செயலாக்கியுள்ளனர் என்பதை பற்றி புள்ளிவிவரம் மூலம் அறியவும்.',
	'prefstats-title' => 'விருப்பங்களின் புள்ளிவிவரங்கள்',
	'prefstats-xaxis' => 'இடைப்பட்ட நேரம் (hours)',
	'prefstats-factor-hour' => 'மணி',
	'prefstats-factor-sixhours' => 'ஆறு மணி நேரம்',
	'prefstats-factor-day' => 'நாள்',
	'prefstats-factor-week' => 'கிழமை (வாரம்)',
	'prefstats-factor-twoweeks' => 'இரண்டு வாரங்கள்',
	'prefstats-factor-fourweeks' => 'நான்கு வாரங்கள்',
	'prefstats-legend-out' => 'விருப்பத்துடன் வெளியேறு',
	'prefstats-legend-in' => 'விருப்பத்துடன் வந்துசேர்',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'prefstats' => 'అభిరుచుల గణాంకాలు',
	'prefstats-title' => 'అభిరుచుల గణాంకాలు',
	'prefstats-list-intro' => 'ప్రస్తుతం, ఈ క్రింది అభిరుచులను గమనిస్తున్నాం.
ఒక్కోదాని గణాంకాలు చూడడానికి దానిపై నొక్కండి.',
	'prefstats-xaxis' => 'సమయం (గంటల్లో)',
	'prefstats-factor-hour' => 'గంట',
	'prefstats-factor-sixhours' => 'ఆరు గంటలు',
	'prefstats-factor-day' => 'రోజు',
	'prefstats-factor-week' => 'వారం',
	'prefstats-factor-twoweeks' => 'రెండు వారాలు',
	'prefstats-factor-fourweeks' => 'నాలుగు వారాలు',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'prefstats-factor-hour' => 'соат',
	'prefstats-factor-sixhours' => 'шаш соат',
	'prefstats-factor-day' => 'рӯз',
	'prefstats-factor-week' => 'ҳафта',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'prefstats-factor-hour' => 'soat',
	'prefstats-factor-sixhours' => 'şaş soat',
	'prefstats-factor-day' => 'rūz',
	'prefstats-factor-week' => 'hafta',
);

/** Thai (ไทย)
 * @author Ans
 * @author Octahedron80
 */
$messages['th'] = array(
	'prefstats-xaxis' => 'ช่วงเวลา (ชั่วโมง)',
	'prefstats-factors' => 'เปิดดูทุกๆ: $1',
	'prefstats-factor-hour' => 'ชั่วโมง',
	'prefstats-factor-sixhours' => 'หกชั่วโมง',
	'prefstats-factor-day' => 'วัน',
	'prefstats-factor-week' => 'สัปดาห์',
	'prefstats-factor-twoweeks' => 'สองสัปดาห์',
	'prefstats-factor-fourweeks' => 'สี่สัปดาห์',
	'prefstats-factor-default' => 'กลับไปมาตราเริ่มต้น',
	'prefstats-legend-out' => 'เลิกติดตาม',
	'prefstats-legend-in' => 'ร่วมติดตาม',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'prefstats' => 'Ileri tutma statistikalary',
	'prefstats-desc' => 'Belli-belli ileri tutmalaryň näçe ulanyjy tarapyndan açylandygy baradaky statistikalary yzarla',
	'prefstats-title' => 'Ileri tutma statistikalary',
	'prefstats-list-intro' => 'Häzirki wagtda aşakdaky ileri tutmalar yzarlanýar.
Birini saýlaň-da ol baradaky statistikalary görüň.',
	'prefstats-noprefs' => 'Häzirki wagtda hiç bir ileri tutma yzarlanmaýar.
Ileri tutmalary yzarlamak üçin konfigurirläň: $wgPrefStatsTrackPrefs',
	'prefstats-counters' => '* Ileri tutma statistikalary açylaly bäri $1 {{PLURAL:$1|ulanyjy|ulanyjy}} bu ileri tutmany açdy
** $2 {{PLURAL:$2|ulanyjy|ulanyjy}} henizem işjeň peýdalanýar
** $3 {{PLURAL:$3|ulanyjy|ulanyjy}} şondan bäri ýapyp goýdy',
	'prefstats-counters-expensive' => '* Ileri tutma statistikalary açylaly bäri $1 {{PLURAL:$1|ulanyjy|ulanyjy}} bu ileri tutmany açdy
** $2 {{PLURAL:$2|ulanyjy|ulanyjy}} henizem işjeň peýdalanýar
** $3 {{PLURAL:$3|ulanyjy|ulanyjy}} şondan bäri ýapyp goýdy
* Jemi, $4 {{PLURAL:$4|ulanyjy|ulanyjy}} bu ileri tutmany sazlady',
	'prefstats-xaxis' => 'Dowamlylyk (sagat)',
	'prefstats-factors' => 'Görkeziş ýygylygy: $1',
	'prefstats-factor-hour' => 'sagat',
	'prefstats-factor-sixhours' => 'alty sagat',
	'prefstats-factor-day' => 'gün',
	'prefstats-factor-week' => 'hepde',
	'prefstats-factor-twoweeks' => 'iki hepde',
	'prefstats-factor-fourweeks' => 'dört hepde',
	'prefstats-factor-default' => 'gaýybana masştaba gaýdyp bar',
	'prefstats-legend-out' => 'Çykan',
	'prefstats-legend-in' => 'Goşulan',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'prefstats' => 'Estadistika ng nais',
	'prefstats-desc' => 'Subaybayan ang estadistika tungkol sa ilang mga tagagamit ang mayroong partikular na pinaaandar na mga nais',
	'prefstats-title' => 'Estadistika ng nais',
	'prefstats-list-intro' => 'Sa kasalukuyan, sinusubaybayan ang sumusunod na mga nais.
Pindutin ang isa upang matingnan ang estadistikang tungkol dito.',
	'prefstats-noprefs' => 'Kasalukuyang walang sinusubaybayang mga nais.
Iayos ang $wgPrefStatsTrackPrefs upang subaybayan ang mga nais.',
	'prefstats-counters' => ' $1 {{PLURAL:$1|tagagamit|mga tagagamit}} ang nagpapagana ng ganitong nais magmula noong pasiglahin ang estadistika ng nais
** $2 {{PLURAL:$2|tagagamit pa rin|mga tagagamit pa rin}} nagpapagana nito
** $3 {{PLURAL:$3|tagagamit|mga tagagamit}} ang hindi na nagpagana nito mula noon',
	'prefstats-counters-expensive' => '$1 {{PLURAL:$1|tagagamit|mga tagagamit}} ang nagpapagana ng ganitong nais magmula noong pasiglahin ang estadistika ng nais
** $2 {{PLURAL:$2|tagagamit pa rin|mga tagagamit pa rin}} nagpapagana nito
** $3 {{PLURAL:$3|tagagamit|mga tagagamit}} ang hindi na nagpagana nito mula noon
* Sa kabuoan, {{PLURAL:$4|tagagamit ang|mga tagagamit ang}}  nagtakda ng ganitong nais',
	'prefstats-xaxis' => 'Pamamarati (mga oras)',
	'prefstats-factors' => 'Pagtingin bawat: $1',
	'prefstats-factor-hour' => 'oras',
	'prefstats-factor-sixhours' => 'anim na oras',
	'prefstats-factor-day' => 'araw',
	'prefstats-factor-week' => 'linggo',
	'prefstats-factor-twoweeks' => 'dalawang linggo',
	'prefstats-factor-fourweeks' => 'apat na linggo',
	'prefstats-factor-default' => 'bumalik sa likas na nakatakdang tumbasan',
	'prefstats-legend-out' => 'Hindi sumali',
	'prefstats-legend-in' => 'Sumali',
);

/** Tok Pisin (Tok Pisin)
 * @author Iketsi
 */
$messages['tpi'] = array(
	'prefstats-factor-day' => 'de',
	'prefstats-factor-week' => 'wik',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'prefstats' => 'Tercih istatistikleri',
	'prefstats-desc' => 'Belirli tercihlerin kaç kullanıcı tarafından etkinleştirildiği hakkında istatistikleri izle',
	'prefstats-title' => 'Tercih istatistikleri',
	'prefstats-list-intro' => 'Şu anda, aşağıdaki tercihler izleniyor.
İlgili istatistikleri görmek için birine tıklayın.',
	'prefstats-noprefs' => 'Şu anda hiçbir tercih izlenmiyor.
Tercihleri izlemek için $wgPrefStatsTrackPrefs\'i yapılandırın.',
	'prefstats-counters' => '* Tercih istatistikleri etkinleştirildiğinden beri $1 {{PLURAL:$1|kullanıcı|kullanıcı}} bu tercihi etkinleştirdi.
** $2 {{PLURAL:$2|kullancı|kullanıcı}} hala etkin olarak kullanıyor
** $3 {{PLURAL:$3|kullanıcı|kullanıcı}} şimdiye kadar devre dışı bıraktı',
	'prefstats-counters-expensive' => '* Tercih istatistikleri etkinleştirildiğinden beri $1 {{PLURAL:$1|kullanıcı|kullanıcı}} bu tercihi etkinleştirdi.
** $2 {{PLURAL:$2|kullancı|kullanıcı}} hala etkin olarak kullanıyor
** $3 {{PLURAL:$3|kullanıcı|kullanıcı}} şimdiye kadar devre dışı bıraktı
* Toplamda, $4 {{PLURAL:$4|kullanıcı|kullanıcı}} bu tercihi ayarladı',
	'prefstats-xaxis' => 'Süre (saat)',
	'prefstats-factors' => 'Görüntüleme sıklığı: $1',
	'prefstats-factor-hour' => 'saat',
	'prefstats-factor-sixhours' => 'altı saat',
	'prefstats-factor-day' => 'gün',
	'prefstats-factor-week' => 'hafta',
	'prefstats-factor-twoweeks' => 'iki hafta',
	'prefstats-factor-fourweeks' => 'dört hafta',
	'prefstats-factor-default' => 'varsayılan ölçeğe dön',
	'prefstats-legend-out' => 'Ayrılan',
	'prefstats-legend-in' => 'Katılan',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Rinatus
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'prefstats' => 'Көйләүләр хисапнамәсе',
	'prefstats-title' => 'Көйләүләр хисапнамәсе',
	'prefstats-factor-hour' => 'сәгать',
	'prefstats-factor-sixhours' => 'алты сәгать',
	'prefstats-factor-day' => 'көн',
	'prefstats-factor-week' => 'атна',
	'prefstats-factor-twoweeks' => 'ике атна',
	'prefstats-factor-fourweeks' => 'дүрт атна',
	'prefstats-legend-out' => 'Ябылды',
	'prefstats-legend-in' => 'Ачылды',
);

/** Ukrainian (Українська)
 * @author A1
 * @author AS
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'prefstats' => 'Статистика налаштувань',
	'prefstats-desc' => 'Відслідковування статистики про популярність тих чи інших налаштувань',
	'prefstats-title' => 'Статистика налаштувань',
	'prefstats-list-intro' => 'Зараз відстежуються такі налаштування.
Натисніть на якомусь, щоб побачити його статистику.',
	'prefstats-noprefs' => 'Наразі параметри не відстежуються. Налаштуйте $wgPrefStatsTrackPrefs для відстеження параметрів.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|користувач увімкнув|користувачі увімкнули|користувачів увімкнули}} цей параметр з моменту початку роботи статистики параметрів
** У $2 {{PLURAL:$2|користувача|користувачів}} він ввімкнений
** У $3 {{PLURAL:$3|користувача|користувачів}} він вже вимкнений',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|користувач увімкнув|користувачі увімкнули|користувачів увімкнули}} цей параметр з моменту початку роботи статистики параметрів
** У $2 {{PLURAL:$2|користувача|користувачів}} він ввімкнений
** У $3 {{PLURAL:$3|користувача|користувачів}} він вже вимкнений
* Загалом, цей параметр встановлено у $4 {{PLURAL:$4|користувача|користувачів}}',
	'prefstats-xaxis' => 'Тривалість (у годинах)',
	'prefstats-factors' => 'Перегляд за: $1',
	'prefstats-factor-hour' => 'годину',
	'prefstats-factor-sixhours' => 'шість годин',
	'prefstats-factor-day' => 'день',
	'prefstats-factor-week' => 'тиждень',
	'prefstats-factor-twoweeks' => 'два тижні',
	'prefstats-factor-fourweeks' => 'чотири тижні',
	'prefstats-factor-default' => 'назад до масштабу за умовчанням',
	'prefstats-legend-out' => 'Відключились',
	'prefstats-legend-in' => 'Підключились',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'prefstats' => 'Statìsteghe de le preferense',
	'prefstats-desc' => 'Statìsteghe sirca el nùmaro de utenti che ga ativà serte preferense',
	'prefstats-title' => 'Statìsteghe de le preferense',
	'prefstats-list-intro' => 'Al momento, vien tegnù tràcia de le seguenti preferense.
Strucando su de una te vedi le so statìsteghe.',
	'prefstats-noprefs' => 'In sto momento no vien monitorà nissuna preferensa. Configura $wgPrefStatsTrackPrefs par monitorar le preferense.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|utente el|utenti i}} gà abilità sta preferensa da quando le statìsteghe su le preferense le xe ative
** $2 {{PLURAL:$2|utente el|utenti i}} la gà ancora abilità
** $3 {{PLURAL:$3|utente el|utenti i}} la gà in seguito disabilità',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|utente el|utenti i}} gà abilità sta preferensa da quando le statìsteghe su le preferense le xe ative
** $2 {{PLURAL:$2|utente el|utenti i}} la gà ancora abilità
** $3 {{PLURAL:$3|utente el|utenti i}} la gà in seguito disabilità
* In total, $4 {{PLURAL:$4|utente el|utenti i}} gà inpostà sta preferensa',
	'prefstats-xaxis' => 'Durata (ore)',
	'prefstats-factors' => 'Viste par: $1',
	'prefstats-factor-hour' => 'ora',
	'prefstats-factor-sixhours' => 'sié ore',
	'prefstats-factor-day' => 'zorno',
	'prefstats-factor-week' => 'setimana',
	'prefstats-factor-twoweeks' => 'do setimane',
	'prefstats-factor-fourweeks' => 'quatro setimane',
	'prefstats-factor-default' => 'torna a la scala predefinìa',
	'prefstats-legend-out' => 'Destacà',
	'prefstats-legend-in' => 'Intacà',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'prefstats-factor-hour' => 'čas',
	'prefstats-factor-sixhours' => "kuz' časud",
	'prefstats-factor-day' => 'päiv',
	'prefstats-factor-week' => "nedal'",
	'prefstats-factor-twoweeks' => "kaks' nedalid",
	'prefstats-factor-fourweeks' => "nell' nedalid",
	'prefstats-factor-default' => 'tagaze masštabannoks augotižjärgendusen mödhe',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'prefstats' => 'Thống kê tùy chọn',
	'prefstats-desc' => 'Theo dõi số người dùng đã bật lên những tùy chọn',
	'prefstats-title' => 'Thống kê tùy chọn',
	'prefstats-list-intro' => 'Hiện đang theo dõi các tùy chọn sau.
Hãy nhấn vào một tùy chọn để xem thống kê về nó.',
	'prefstats-noprefs' => 'Không có tùy chọn nào được theo dõi. Hãy cấu hình $wgPrefStatsTrackPrefs để theo dõi tùy chọn.',
	'prefstats-counters' => '* $1 {{PLURAL:$1|thành viên|thành viên}} bật tùy chọn này từ khi thống kê tùy chọn được kích hoạt
** $2 {{PLURAL:$2|thành viên|thành viên}} vẫn bật nó
** $3 {{PLURAL:$3|thành viên|thành viên}} từ đó đã tắt nó đi',
	'prefstats-counters-expensive' => '* $1 {{PLURAL:$1|thành viên|thành viên}} bật tùy chọn này từ khi thống kê tùy chọn được kích hoạt
** $2 {{PLURAL:$2|thành viên|thành viên}} vẫn bật nó
** $3 {{PLURAL:$3|thành viên|thành viên}} từ đó đã tắt nó đi
* Tổng cộng, có $4 {{PLURAL:$4|thành viên|thành viên}} đã thiết lập tùy chọn này',
	'prefstats-xaxis' => 'Khoảng thời gian (tiếng)',
	'prefstats-factors' => 'Xem theo: $1',
	'prefstats-factor-hour' => 'tiếng',
	'prefstats-factor-sixhours' => 'sáu tiếng',
	'prefstats-factor-day' => 'ngày',
	'prefstats-factor-week' => 'tuần',
	'prefstats-factor-twoweeks' => 'hai tuần',
	'prefstats-factor-fourweeks' => 'bốn tuần',
	'prefstats-factor-default' => 'trở lại mức mặc định',
	'prefstats-legend-out' => 'Không dùng nữa',
	'prefstats-legend-in' => 'Dùng thử',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'prefstats-factor-hour' => 'düp',
	'prefstats-factor-sixhours' => 'düps mäl',
	'prefstats-factor-day' => 'del',
	'prefstats-factor-week' => 'vig',
	'prefstats-factor-twoweeks' => 'vigs tel',
	'prefstats-factor-fourweeks' => 'vigs fol',
);

/** Mingrelian (მარგალური)
 * @author Lika2672
 */
$messages['xmf'] = array(
	'prefstats-factor-day' => 'დღა',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'prefstats' => 'פרעפֿערענץ סטאַטיסטיק',
	'prefstats-title' => 'פרעפֿערענץ סטאַטיסטיק',
	'prefstats-xaxis' => "געדויער (שעה'ן)",
	'prefstats-factors' => 'צוקוק לויט: $1',
	'prefstats-factor-hour' => 'שעה',
	'prefstats-factor-sixhours' => 'זעקס שעה',
	'prefstats-factor-day' => 'טאָג',
	'prefstats-factor-week' => 'וואך',
	'prefstats-factor-twoweeks' => 'צוויי וואכן',
	'prefstats-factor-fourweeks' => 'פֿיר וואכן',
	'prefstats-factor-default' => 'צוריק צום גרונטמאָס',
	'prefstats-legend-out' => 'פרעפֿערענץ אַנולירט',
	'prefstats-legend-in' => 'פרעפֿערענץ אקטיוויזירט',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'prefstats' => 'Àwọn statístíkì ìfẹ́ràn',
	'prefstats-desc' => 'Ìtẹ̀lé statístíkì iye àwọn oníṣe tí wọ́n ní ìgbàláyé àwọn ìfẹ́ràn pàtó',
	'prefstats-title' => 'Àwọn statístíkì ìfẹ́ràn',
	'prefstats-list-intro' => 'Lọ́wọ́lọ́wọ́, àwọn ìfẹ́ràn wọ̀nyí únjẹ́ títẹ̀lé.
Ẹ tẹ ìkan láti wo statístíkì nípa rẹ̀.',
	'prefstats-noprefs' => 'Àwọn ìfẹ́ràn kankan kó jẹ́ títẹ̀lé lọ́wọ́lọ́wọ́.
Ẹ ṣètò $wgPrefStatsTrackPrefs láti tẹ̀lé àwọn ìfẹ́ràn.',
	'prefstats-counters' => '* {{PLURAL:$1|Oníṣe|Àwọn oníṣe}} $1 ti ṣe ìgbàláyè ìfẹ́ràn yìí látìgbà ti àwọn statístíkì ìfẹ́ràn ti jẹ́ gbígbàláyé
** {{PLURAL:$2|Oníṣe|Àwọn oníṣe}} $2 sì úngbàláyé 
** {{PLURAL:$3|Oníṣe|Àwọn oníṣe}} $3 ti dẹ́kun rẹ̀ látìgbà náà',
	'prefstats-counters-expensive' => '* {{PLURAL:$1|Oníṣe|Àwọn oníṣe}} $1 ti ṣe ìgbàláyè ìfẹ́ràn yìí látìgbà ti àwọn statístíkì ìfẹ́ràn ti jẹ́ gbígbàláyé
** {{PLURAL:$2|Oníṣe|Àwọn oníṣe}} $2 sì úngbàláyé 
** {{PLURAL:$3|Oníṣe|Àwọn oníṣe}} $3 ti dẹ́kun rẹ̀ látìgbà náà
* Nì iye àpapọ̀, {{PLURAL:$4|oníṣe|àwọn oníṣe}} $4 ti ṣètò ìfẹ́ràn yìí',
	'prefstats-xaxis' => 'Àsìkò (wákàtí)',
	'prefstats-factors' => 'Ìwò ti: $1',
	'prefstats-factor-hour' => 'wákàtí',
	'prefstats-factor-sixhours' => 'wákàtí mẹ́fà',
	'prefstats-factor-day' => 'ọjọ́',
	'prefstats-factor-week' => 'ọ̀sẹ̀',
	'prefstats-factor-twoweeks' => 'ọ̀sẹ̀ méjì',
	'prefstats-factor-fourweeks' => 'ọ̀sẹ̀ mẹ́rin',
	'prefstats-factor-default' => 'Ẹ padà sí ìwọ̀n ìbẹ̀rẹ̀',
	'prefstats-legend-out' => 'Ẹ mọ́ kòópa',
	'prefstats-legend-in' => 'Ẹ kópa',
);

/** Cantonese (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'prefstats' => '喜好統計',
	'prefstats-desc' => '追蹤統計，有幾多用戶開咗特定設定',
	'prefstats-title' => '喜好統計',
	'prefstats-list-intro' => '直到而家，下面嘅喜好設定會追蹤落來。
撳其中一樣去睇有關佢嘅統計。',
	'prefstats-noprefs' => '無喜好可以追蹤得到。設定 $wgPrefStatsTrackPrefs 去追蹤喜好。',
	'prefstats-counters' => '* $1 位用戶自從開着咗喜好統計之後開咗呢個設定
** $2 位用戶已經將佢開咗
** $3 位用戶已經將佢閂咗',
	'prefstats-counters-expensive' => '* $1 位用戶自從開着咗喜好統計之後開咗呢個設定
** $2 位用戶已經將佢開咗
** $3 位用戶已經將佢閂咗
* 總共，$4位用戶已經設定咗呢選項',
	'prefstats-xaxis' => '持續時間 (鐘頭)',
	'prefstats-factors' => '睇吓每: $1',
	'prefstats-factor-hour' => '1個鐘頭',
	'prefstats-factor-sixhours' => '6個鐘頭',
	'prefstats-factor-day' => '1日',
	'prefstats-factor-week' => '1個星期',
	'prefstats-factor-twoweeks' => '2個星期',
	'prefstats-factor-fourweeks' => '4個星期',
	'prefstats-factor-default' => '返去預設比例',
	'prefstats-legend-out' => '選出咗',
	'prefstats-legend-in' => '選入咗',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Jimmy xu wrk
 * @author PhiLiP
 * @author Shinjiman
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'prefstats' => '系统设置统计',
	'prefstats-desc' => '追踪统计，有多少用户启用了特定的设置',
	'prefstats-title' => '系统设置统计',
	'prefstats-list-intro' => '直到现时，以下的喜好设置会追踪下来。
	点击其中一种设置去查看有关它的统计。',
	'prefstats-noprefs' => '无喜好可供追踪。设置 $wgPrefStatsTrackPrefs 去追踪喜好。',
	'prefstats-counters' => '* $1名用户在统计启用之后启用了此选项
** $2名用户启用了它
** $3名用户禁用了它',
	'prefstats-counters-expensive' => '* $1名用户在统计启用之后启用了此选项
** $2名用户启用了它
** $3名用户禁用了它
* 总的来说，$4名用户设置了此选项',
	'prefstats-xaxis' => '持续时间（小时）',
	'prefstats-factors' => '查看时限：$1',
	'prefstats-factor-hour' => '1小时',
	'prefstats-factor-sixhours' => '6小时',
	'prefstats-factor-day' => '1天',
	'prefstats-factor-week' => '1周',
	'prefstats-factor-twoweeks' => '2周',
	'prefstats-factor-fourweeks' => '4周',
	'prefstats-factor-default' => '恢复默认设置',
	'prefstats-legend-out' => '已禁用',
	'prefstats-legend-in' => '已启用',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'prefstats' => '喜好統計',
	'prefstats-desc' => '追蹤統計，有多少用戶啟用了特定的設定',
	'prefstats-title' => '喜好統計',
	'prefstats-list-intro' => '直到現時，以下的喜好設定會追蹤下來。
點擊其中一種設定去查看有關它的統計。',
	'prefstats-noprefs' => '無喜好可供追蹤。設定 $wgPrefStatsTrackPrefs 去追蹤喜好。',
	'prefstats-counters' => '* $1 名用戶在統計啟用之後啟用了此選項
** $2 名用戶啟用了它
** $3 名用戶禁用了它',
	'prefstats-counters-expensive' => '* $1 名用戶在統計啟用之後啟用了此選項
** $2 名用戶啟用了它
** $3 名用戶禁用了它
* 總的來說，$4 名用戶設定了此選項',
	'prefstats-xaxis' => '持續時間（小時）',
	'prefstats-factors' => '檢視時限︰$1',
	'prefstats-factor-hour' => '1 小時',
	'prefstats-factor-sixhours' => '6 小時',
	'prefstats-factor-day' => '1 天',
	'prefstats-factor-week' => '1 週',
	'prefstats-factor-twoweeks' => '2 週',
	'prefstats-factor-fourweeks' => '4 週',
	'prefstats-factor-default' => '恢復預設設定',
	'prefstats-legend-out' => '已停用',
	'prefstats-legend-in' => '已啟用',
);

