<?php
/**
 * Internationalisation file for extension Vote.
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @license Please see the LICENCE file for terms of use and redistribution
 */

$messages = array();

/** English
 * @author Rob Church
 */
$messages['en'] = array(
	'vote'                => 'Vote',
	'vote-desc'           => 'Provides simple polling capabilities',
	'vote-header'         => "You can vote for '''Supreme Overlord of the World''' here!",
	'vote-current'        => "Your current vote is for '''$1'''.",
	'vote-legend'         => 'Place or amend vote',
	'vote-caption'        => 'Your selection:',
	'vote-choices'        => "joker|The Joker
penguin|The Penguin
riddler|Riddler",
	'vote-submit'         => 'Vote',
	'vote-registered'     => 'Your vote has been registered.',
	'vote-view-results'   => 'View results',
	'vote-results'        => 'Vote results',
	'vote-results-choice' => 'Choice',
	'vote-results-count'  => 'Count',
	'vote-results-none'   => 'No votes have been placed at this time.',
	'vote-login'          => 'You must [$1 log in] to vote.',
	'vote-invalid-choice' => 'You must select one of the available options.',
	'right-vote' => 'Vote',
	'right-voteadmin' => 'See vote results',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Lloffiwr
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'vote' => '{{Identical|Vote}}',
	'vote-desc' => '{{desc}}',
	'vote-submit' => '{{Identical|Vote}}',
	'vote-results-count' => '{{Identical|Count}}',
	'vote-login' => '$1 is the link to the log-in page.',
	'right-vote' => '{{doc-right|vote}}

{{Identical|Vote}}',
	'right-voteadmin' => '{{doc-right|voteadmin}}',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'vote' => 'Stem',
	'vote-desc' => 'Maak eenvoudige opiniepeilins moontlik',
	'vote-header' => "U kan hier stem vir '''Alleenheerser oor die Wêreld'''!",
	'vote-current' => "U stem is tans vir '''$1'''.",
	'vote-legend' => 'Stem of wysig stem',
	'vote-caption' => 'U keuse:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Stem',
	'vote-registered' => 'U stem is geregistreer.',
	'vote-view-results' => 'Wys resultate',
	'vote-results' => 'Resultate van stemming',
	'vote-results-choice' => 'Keuse',
	'vote-results-count' => 'Aantal',
	'vote-results-none' => 'Daar is nog geen stemme uitgebring nie.',
	'vote-login' => 'U moet [$1 inteken] om te kan stem.',
	'vote-invalid-choice' => 'U moet een van die beskikbare opsies kies.',
	'right-vote' => 'Stem',
	'right-voteadmin' => 'Resultate van stemmings bekyk',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'vote' => 'Votim',
	'vote-desc' => 'Ofron aftësive të thjeshtë votimi',
	'vote-header' => "Ju mund të votojnë për'''Lartë zot e Botërore''' këtu!",
	'vote-current' => "Vota juaj e tanishme është për '''$1'''.",
	'vote-legend' => 'Vendi apo ndryshuar votave',
	'vote-caption' => 'Zgjedhja juaj:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Votim',
	'vote-registered' => 'Vota juaj është regjistruar.',
	'vote-view-results' => 'Shiko rezultatet',
	'vote-results' => 'Rezultatet Voto',
	'vote-results-choice' => 'Zgjedhje',
	'vote-results-count' => 'Akuzë',
	'vote-results-none' => 'Nuk ka vota kanë qenë të vendosur në këtë kohë.',
	'vote-login' => 'Ju duhet [$1 hyni brënda] për të votuar.',
	'vote-invalid-choice' => 'Ju duhet të zgjidhni një nga opsionet në dispozicion.',
	'right-vote' => 'Votim',
	'right-voteadmin' => 'Shiko rezultatet votave',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'vote' => 'ምርጫ',
	'vote-submit' => 'ይምረጡ',
	'vote-registered' => 'ምርጫዎ ተመዝግቧል።',
	'vote-results' => 'የምርጫው ውጤት፦',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'vote' => 'تصويت',
	'vote-desc' => 'يقدم قدرات الاقتراع البسيط',
	'vote-header' => "يمكنك التصويت لاختيار '''الرئيس الأعلى للعالم''' هنا!",
	'vote-current' => "تصويتك الحالي ل'''$1'''.",
	'vote-legend' => 'وضع أو تغيير التصويت',
	'vote-caption' => 'اختيارك:',
	'vote-choices' => 'جوكر|الجوكر
بطريق|البطريق
ريدلر|ريدلر',
	'vote-submit' => 'تصويت',
	'vote-registered' => 'تصويتك تم تسجيله',
	'vote-view-results' => 'عرض النتائج',
	'vote-results' => 'نتائج التصويت',
	'vote-results-choice' => 'الاختيار',
	'vote-results-count' => 'العدد',
	'vote-results-none' => 'لا أصوات تم وضعها في هذا الوقت.',
	'vote-login' => 'يجب أن [$1 تسجل الدخول] للتصويت.',
	'vote-invalid-choice' => 'يجب عليك اختيار واحد من الخيارات المتاحة.',
	'right-vote' => 'تصويت',
	'right-voteadmin' => 'مشاهدة نتائج التصويتات',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'vote' => 'تصويت',
	'vote-desc' => 'بيقدم قدرات الانتخابات البسيطه',
	'vote-header' => "أنت ممكن هنا تدى صوتك لانتخاب '''أعظم ريس فى الدنيا دى كلها'''",
	'vote-current' => ".'''$1'''انت بتدى صوتك لـ",
	'vote-legend' => 'ادى صوتك أو عدل فيه',
	'vote-caption' => 'انت اخترت:',
	'vote-choices' => 'جوكر|الجوكر
بطريق|البطريق
ريدلر|ريدلر',
	'vote-submit' => 'صوت',
	'vote-registered' => 'التصويت بتاعك اتسجل',
	'vote-view-results' => 'عرض النتايج',
	'vote-results' => 'نتايج التصويت',
	'vote-results-choice' => 'الاختيار',
	'vote-results-count' => 'العدد',
	'vote-results-none' => 'ماحدش ادى صوته فى الوقت دا',
	'vote-login' => 'لازم تكون [$1 دخول] علشان تصوت.',
	'vote-invalid-choice' => 'لازم تختار واحد من الاختيارات  الموجودة',
	'right-vote' => 'صوت',
	'right-voteadmin' => 'شوف نتايج التصويت',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'vote' => 'Votación',
	'vote-desc' => 'Ufre capacidá pa facer encuestes cencielles',
	'vote-header' => "¡Equí pues votar pol '''Cabezaleru Supremu del Mundu'''!",
	'vote-current' => "El to votu actual ye pa '''$1'''.",
	'vote-legend' => 'Votar o camudar el votu',
	'vote-caption' => 'La to seleición:',
	'vote-choices' => 'joker|El Joker
penguin|El Pingüín
riddler|Riddler',
	'vote-submit' => 'Votar',
	'vote-registered' => 'Se rexistró el to votu.',
	'vote-view-results' => 'Ver los resultaos',
	'vote-results' => 'Resultaos de la votación',
	'vote-results-choice' => 'Seleición',
	'vote-results-count' => 'Recuentu',
	'vote-results-none' => 'Entá nun se rexistró dengún votu.',
	'vote-login' => "Tienes d'[$1 aniciar sesión] pa votar.",
	'vote-invalid-choice' => "Tienes d'escoyer una de les opciones disponibles.",
	'right-vote' => 'Votar',
	'right-voteadmin' => "Ver los resultaos d'una votación",
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'vote' => 'Magboto',
	'vote-submit' => 'Magboto',
	'vote-registered' => 'Nairehistro na an boto mo.',
	'vote-view-results' => 'Hilingón an mga resulta',
	'vote-results' => 'Mga resulta kan boto',
	'vote-results-choice' => 'Pinilî',
	'vote-results-count' => 'Bilang',
	'vote-results-none' => 'Mayong botong naikaag sa mga oras na ini.',
	'vote-login' => 'Kaipuhan mong [$1 maglaog] magboto.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'vote' => 'Галасаваньне',
	'vote-desc' => 'Надае магчымасьць простага галасаваньня',
	'vote-header' => "Вы можаце галасаваць за '''Вышэйшага Ўладара Сьвету''' тут!",
	'vote-current' => "Ваш цяперашні голас адданы за '''$1'''.",
	'vote-legend' => 'Прагаласаваць альбо зьмяніць голас',
	'vote-caption' => 'Ваш выбар:',
	'vote-choices' => 'джокер|Джокер
пінгвін|Пінгвін
загадка|Загадка',
	'vote-submit' => 'Галасаваць',
	'vote-registered' => 'Ваш голас быў залічаны.',
	'vote-view-results' => 'Паказаць вынікі',
	'vote-results' => 'Вынікі галасаваньня',
	'vote-results-choice' => 'Выбар',
	'vote-results-count' => 'Колькасьць',
	'vote-results-none' => 'Няма галасоў адданых за гэты час.',
	'vote-login' => 'Вам трэба [$1 увайсьці ў сыстэму], каб галасаваць.',
	'vote-invalid-choice' => 'Вы павінны выбраць адзін з прапанаваных варыянтаў.',
	'right-vote' => 'удзел ў галасаваньні',
	'right-voteadmin' => 'прагляд вынікаў галасаваньняў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'vote' => 'Гласуване',
	'vote-desc' => 'Предоставя опростена възможност за участие в анкети',
	'vote-header' => "На тази страница можете да гласувате за '''Върховен повелител на Света'''!",
	'vote-current' => "В момента сте гласували за '''$1'''.",
	'vote-caption' => 'Текущ избор:',
	'vote-submit' => 'Гласуване',
	'vote-registered' => 'Вашият глас беше отчетен.',
	'vote-view-results' => 'Преглед на резултатите',
	'vote-results' => 'Резултати от гласуването',
	'vote-results-none' => 'Все още никой не е гласувал.',
	'vote-login' => 'За гласуване е необходимо [$1 влизане].',
	'vote-invalid-choice' => 'Необходимо е да бъде избрана една от наличните възможности.',
	'right-vote' => 'Гласуване',
	'right-voteadmin' => 'Преглеждане на резултатите от гласуванията',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'vote' => 'ভোট দিন',
	'vote-header' => "আপনি এখানে '''বিশ্বের সর্বাধিপতি'''-র জন্য এখানে ভোট দিতে পারেন!",
	'vote-current' => "আপনার বর্তমান ভোট  '''$1'''-এর জন্য সংরক্ষিত।",
	'vote-legend' => 'ভোট স্থাপন বা পরিবর্তন করুন',
	'vote-caption' => 'আপনার নির্বাচন:',
	'vote-choices' => 'জোকার|দ্য জোকার
পেঙ্গুইন|দ্য পেঙ্গুইন
রিডলার|রিডলার',
	'vote-submit' => 'ভোট দিন',
	'vote-registered' => 'আপনার ভোট নিবন্ধিত হয়েছে।',
	'vote-view-results' => 'ফলাফল দেখুন',
	'vote-results' => 'ভোটের ফলাফল',
	'vote-results-choice' => 'পছন্দ',
	'vote-results-count' => 'গণনা',
	'vote-results-none' => 'এ পর্যন্ত কোন ভোট পড়েনি।',
	'vote-login' => 'ভোট দিতে হলে আপনাকে অবশ্যই [$1 লগ ইন] করতে হবে।',
	'vote-invalid-choice' => 'আপনাকে অবশ্যই প্রদত্ত পছন্দগুলি থেকে যেকোন একটি নির্বাচন করতে হবে।',
	'right-vote' => 'ভোট',
	'right-voteadmin' => 'ভোটের ফলাফল দেখুন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'vote' => 'Votiñ',
	'vote-desc' => 'Aotren a ra sevel sontadegoù aes-tre',
	'vote-header' => "Amañ e c'hallit votiñ evit '''mestr an Hollved''' boulc'hurun !",
	'vote-current' => "Votet hoc'h eus evit '''$1'''.",
	'vote-legend' => 'Lakaat ur vot pe distreiñ warnañ',
	'vote-caption' => 'Ho tibab :',
	'vote-choices' => 'joker|Ar Joker
pengouin|Ar pengouin
sfinks|Sfinks',
	'vote-submit' => 'Votiñ',
	'vote-registered' => 'Enrollet eo bet ho vot.',
	'vote-view-results' => "Gwelet an disoc'hoù",
	'vote-results' => "Disoc'h ar votadeg",
	'vote-results-choice' => 'Dibab',
	'vote-results-count' => 'Mouezh',
	'vote-results-none' => "N'eus bet lakaet vot ebet evit c'hoazh",
	'vote-login' => "Ret eo deoc'h [$1 kevreañ] evit votiñ.",
	'vote-invalid-choice' => "Ret eo deoc'h dibab unan eus an dibarzhioù hegerz.",
	'right-vote' => 'Vot',
	'right-voteadmin' => "Gwelet disoc'hoù ar votadeg",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'vote' => 'Glasanje',
	'vote-desc' => 'Omogućuje jednostavne mogućnosti glasanja',
	'vote-header' => "Ovdje možete glasati za '''Vrhovnog vladara nad vladarima Svijeta'''!",
	'vote-current' => "Vaš trenutni glas je za '''$1'''.",
	'vote-legend' => 'Postavite ili dopunite glas',
	'vote-caption' => 'Vaš odabir:',
	'vote-choices' => 'joker|Džoker
penguin|Pingvin
riddler|Zagonetka',
	'vote-submit' => 'Glasaj',
	'vote-registered' => 'Vaš glas je registrovan.',
	'vote-view-results' => 'Pogledaj rezultate',
	'vote-results' => 'Rezultati glasanja',
	'vote-results-choice' => 'Izbor',
	'vote-results-count' => 'Brojanje',
	'vote-results-none' => 'Do sada nisu dati glasovi.',
	'vote-login' => 'Morate se [$1 prijaviti] za glasanje.',
	'vote-invalid-choice' => 'Morate odabrati jednu od ponuđenih opcija.',
	'right-vote' => 'Glasanje',
	'right-voteadmin' => 'Pregled rezultata glasanja',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'vote-desc' => 'Proporciona un mecanisme simple de vot',
	'vote-submit' => 'Vota',
	'vote-registered' => 'El vostre vot ha estat registrat.',
	'vote-view-results' => 'Visualitza resultats',
	'right-vote' => 'Votar',
	'right-voteadmin' => 'Veure els resultats de la votació',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'vote-registered' => 'ده‌نگی تۆ تۆمار کرا.',
	'vote-results' => 'ئه‌نجامه‌کانی ده‌نگ',
	'vote-results-choice' => 'هه‌ڵبژێردراو',
	'vote-results-count' => 'ژماردن',
	'vote-invalid-choice' => 'ده‌بێ یه‌کێک له‌ هه‌ڵبژارده‌ ئاماده‌کان دیاری بکه‌یت.',
	'right-voteadmin' => 'دیتنی ئه‌نجامه‌کانی ده‌نگ',
);

/** Czech (Česky)
 * @author Kuvaly
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'vote' => 'Hlasování',
	'vote-desc' => 'Poskytuje jednoduchou možnost průzkumu',
	'vote-header' => "Zde můžete hlasovat o '''hlavním diktátorovi světa'''!",
	'vote-current' => "Aktuálně hlasujete pro '''$1'''.",
	'vote-legend' => 'Hlasovat nebo změnit hlas',
	'vote-caption' => 'Vaše volba:',
	'vote-choices' => 'joker|Joker
tucnak|Tučňák
riddler|Riddler',
	'vote-submit' => 'Hlasovat',
	'vote-registered' => 'Váš hlas byl zaznamenán',
	'vote-view-results' => 'Zobrazit výsledky',
	'vote-results' => 'Výsledky hlasování',
	'vote-results-choice' => 'Volba',
	'vote-results-count' => 'Počet',
	'vote-results-none' => 'Momentálně nejsou zaznamenány žádné hlasy.',
	'vote-login' => 'Abyste mohli hlasovat, musíte [$1 se přihlásit].',
	'vote-invalid-choice' => 'Musíte vybrat jednu z dostupných možností',
	'right-vote' => 'Hlasování',
	'right-voteadmin' => 'Prohlížení výsledků hlasování',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'vote' => 'Pleidleisio',
	'vote-desc' => 'Yn cynnal etholiad syml',
	'vote-header' => "Gallwch ethol '''Ymerawdwr y Bydysawd''' fan hyn!",
	'vote-current' => "Rydych wedi dewis '''$1''' ar hyn o bryd.",
	'vote-legend' => 'Bwrw pleidlais neu ei newid',
	'vote-caption' => 'Eich dewis:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|The Riddler',
	'vote-submit' => 'Bwrw pleidlais',
	'vote-registered' => 'Cofnodwyd eich pleidlais.',
	'vote-view-results' => 'Edrych ar y canlyniadau',
	'vote-results' => "Canlyniadau'r bleidlais",
	'vote-results-choice' => 'Y dewis',
	'vote-results-count' => 'Cyfrif',
	'vote-results-none' => 'Nid oes neb wedi pleidleisio eto.',
	'vote-login' => 'Rhaid [$1 mewngofnodi] i bleidleisio.',
	'vote-invalid-choice' => "Rhaid dewis un o'r dewisiadau a gynigwyd.",
	'right-vote' => 'Pleidleisio',
	'right-voteadmin' => "Gweld canlyniadau'r bleidlais",
);

/** German (Deutsch)
 * @author Leithian
 * @author MF-Warburg
 * @author Melancholie
 * @author Metalhead64
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'vote' => 'Wählen',
	'vote-desc' => 'Bietet einfache Umfragefähigkeiten',
	'vote-header' => "Du kannst hier den '''Obersten Oberherrn der Welt''' wählen!",
	'vote-current' => "Deine aktuelle Stimme ist für '''$1'''.",
	'vote-legend' => 'Abstimmen',
	'vote-caption' => 'Deine Stimme:',
	'vote-choices' => 'joker|Der Joker
penguin|Der Pinguin
riddler|Riddler',
	'vote-submit' => 'Abstimmen',
	'vote-registered' => 'Deine Stimme wurde registriert.',
	'vote-view-results' => 'Ergebnisse zeigen',
	'vote-results' => 'Wahlergebnisse',
	'vote-results-choice' => 'Wahl',
	'vote-results-count' => 'Anzahl',
	'vote-results-none' => 'Es wurden noch keine Stimmen abgegeben.',
	'vote-login' => 'Du musst [$1 dich anmelden], um abstimmen zu können.',
	'vote-invalid-choice' => 'Du musst eine der möglichen Optionen wählen.',
	'right-vote' => 'Wählen',
	'right-voteadmin' => 'Wahlergebnis anschauen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'vote-header' => "Sie können hier den '''Obersten Oberherrn der Welt''' wählen!",
	'vote-current' => "Ihre aktuelle Stimme ist für '''$1'''.",
	'vote-caption' => 'Ihre Stimme:',
	'vote-registered' => 'Ihre Stimme wurde registriert.',
	'vote-login' => 'Sie müssen [$1 sich anmelden], um abstimmen zu können.',
	'vote-invalid-choice' => 'Sie müssen eine der möglichen Optionen wählen.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'vote' => 'Głosowaś',
	'vote-desc' => 'Dawa jadnore napšašowańske móžnosći',
	'vote-header' => "Móžoš how za '''Nanejwušego kněza swěta''' glosowaś!",
	'vote-current' => "Twój aktualny głos jo za '''$1'''.",
	'vote-legend' => 'Swój głos wótedaś abo změniś',
	'vote-caption' => 'Twójo wuzwólenje:',
	'vote-choices' => 'joker|Joker
penguin|Penguin
riddler|Riddler',
	'vote-submit' => 'Głosowaś',
	'vote-registered' => 'Twój głos jo se zregistrěrował.',
	'vote-view-results' => 'Wuslědki pokazaś',
	'vote-results' => 'Wuslědki wótgłosowanja',
	'vote-results-choice' => 'Wuzwólenje',
	'vote-results-count' => 'Licba',
	'vote-results-none' => 'Dotychměst głose njejsu se wótedali.',
	'vote-login' => 'Musyš [$1 se pśizjawiś], aby wótgłosował.',
	'vote-invalid-choice' => 'Musyš jadnu z k dispoziciji stojecych opcijow wubraś.',
	'right-vote' => 'Wótgłosowaś',
	'right-voteadmin' => 'Wuslědki wótgłosowanja pokazaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author K sal 15
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'vote' => 'Ψηφοφορία',
	'vote-desc' => 'Παρέχει δυνατότητες απλών δημοσκοπήσεων',
	'vote-header' => "Μπορείτε να ψηφίσετε για τον '''Ανώτατο Άρχοντα του Κόσμου''' εδώ!",
	'vote-current' => "Η τρέχουσα ψήφος σας είναι για '''$1'''.",
	'vote-legend' => 'Τοποθετήστε ή τροποποιήστε την ψήφο σας',
	'vote-caption' => 'Η επιλογή σας:',
	'vote-choices' => 'τζόκερ|Ο Τζόκερ
πιγκουίνος|Ο Πιγκουίνος
γρίφος|Γρίφος',
	'vote-submit' => 'Ψηφοφορία',
	'vote-registered' => 'Η ψήφος σας έχει προσμετρηθεί.',
	'vote-view-results' => 'Δείτε τα αποτελέσματα',
	'vote-results' => 'Αποτελέσματα ψηφοφορίας',
	'vote-results-choice' => 'Επιλογή',
	'vote-results-count' => 'Καταμέτρηση',
	'vote-results-none' => 'Δεν διεξάγονται ψηφοφορίες αυτήν την περίοδο.',
	'vote-login' => 'Πρέπει [$1 να συνδεθείτε] για να ψηφίσετε.',
	'vote-invalid-choice' => 'Πρέπει να επιλέξετε μια από της διαθέσιμες επιλογές.',
	'right-vote' => 'Ψηφοφορία',
	'right-voteadmin' => 'Δείτε τα αποτελέσματα της ψηφοφορίας',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'vote' => 'Voĉdonu',
	'vote-header' => "Vi povas voĉdoni por '''Supera Mastro de la Universo''' ĉi tie!",
	'vote-current' => "Via nuna voĉdono estas por '''$1'''.",
	'vote-legend' => 'Voĉdoni aŭ ŝanĝi voĉdonon',
	'vote-caption' => 'Via elekto:',
	'vote-submit' => 'Balotu',
	'vote-registered' => 'Via voĉdono estis registrita.',
	'vote-view-results' => 'Vidi rezultojn',
	'vote-results' => 'Voĉdoni rezultojn',
	'vote-results-choice' => 'Elekto',
	'vote-results-count' => 'Nombro',
	'vote-login' => 'Vi devas [$1 ensaluti] por voĉdoni.',
	'right-vote' => 'Voĉdoni',
	'right-voteadmin' => 'Vidi rezultojn de voĉdono',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Fluence
 * @author Imre
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'vote' => 'Votar',
	'vote-desc' => 'Provea capacidades de encuesta simple',
	'vote-header' => "¡Puedes votar por '''Supremo Señor Feudal del Mundo''' aquí!",
	'vote-current' => "Tu voto actual es para '''$1'''.",
	'vote-legend' => 'Reemplazar o enmendar voto',
	'vote-caption' => 'Su selección:',
	'vote-choices' => 'bufón|El Bufón
pingüino|El Pingüino
adivinador|Adivinador',
	'vote-submit' => 'Votar',
	'vote-registered' => 'Su voto ha sido registrado.',
	'vote-view-results' => 'Ver resultados',
	'vote-results' => 'Resultados de votación',
	'vote-results-choice' => 'Selección',
	'vote-results-count' => 'Contar',
	'vote-results-none' => 'Ningún voto ha sido emitido en este momento.',
	'vote-login' => 'Debes [$1 iniciar sesión] para votar.',
	'vote-invalid-choice' => 'Usted debe seleccionar una de las opciones disponibles.',
	'right-vote' => 'Votar',
	'right-voteadmin' => 'Ver resultados de votos',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'vote' => 'Hääletus',
	'vote-current' => "Su praegune hääl on '''$1''' poolt.",
	'vote-caption' => 'Sinu valik:',
	'vote-submit' => 'Hääleta',
	'vote-registered' => 'Sinu hääl on registreeritud.',
	'vote-view-results' => 'Vaata tulemusi',
	'vote-results' => 'Hääletuse tulemused',
	'vote-results-choice' => 'Valik',
	'vote-results-count' => 'Üldarv',
	'vote-login' => 'Hääletamiseks on vajalik [$1 sisse logida].',
	'vote-invalid-choice' => 'Üks valik tuleb teha.',
	'right-vote' => 'Hääleta',
	'right-voteadmin' => 'Vaata hääletuse tulemusi',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Theklan
 */
$messages['eu'] = array(
	'vote' => 'Bozkatu',
	'vote-caption' => 'Zure aukeraketa:',
	'vote-choices' => 'joker|Jokerra
penguin|Pinguinoa
riddler|Riddlerra',
	'vote-submit' => 'Bozkatu',
	'vote-registered' => 'Zure bozka erregistratu da.',
	'vote-view-results' => 'Ikusi emaitzak',
	'vote-results' => 'Ikusi emaitzak',
	'vote-results-choice' => 'Aukeratu',
	'vote-results-count' => 'Kontatu',
	'vote-results-none' => 'Ez dago bozkarik oraindik ordu honetan.',
	'vote-login' => '[$1 Saioa hasi] behar duzu bozkatzeko.',
	'vote-invalid-choice' => 'Eskuragarri dauden aukeretako bat aukeratu behar duzu.',
	'right-vote' => 'Bozkatu',
	'right-voteadmin' => 'Ikusi bozketaren emaitzak',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'vote' => 'Votal',
	'vote-submit' => 'Votal',
	'vote-registered' => 'El tu votu s´á rustrau.',
	'vote-results-count' => 'Cuenta',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Mjbmr
 */
$messages['fa'] = array(
	'vote' => 'رای‌گیری',
	'vote-desc' => 'امکاناتی برای رای‌گیری ساده فراهم می‌کند',
	'vote-header' => "شما می‌توانید برا '''خداوندگار عالی‌مرتبهٔ دنیا''' اینجا رأی دهید!",
	'vote-current' => "رای فعلی شما '''$1''' است.",
	'vote-legend' => 'رای خود را وارد یا اصلاح نمایید',
	'vote-caption' => 'انتخاب شما:',
	'vote-choices' => 'شوخ|جناب شوخ
پنگوئن|جناب پنگوئن
معماگو|جناب معماگو',
	'vote-submit' => 'ثبت رای',
	'vote-registered' => 'رای شما ثبت شد.',
	'vote-view-results' => 'مشاهده نتایج',
	'vote-results' => 'نتیجه رای‌گیری',
	'vote-results-choice' => 'انتخاب',
	'vote-results-count' => 'شمارش',
	'vote-results-none' => 'در حال حاضر هیچ رایی ثبت نشده است.',
	'vote-login' => 'برای رای دادن باید [$1 به سامانه وارد شوید].',
	'vote-invalid-choice' => 'شما باید یکی از گزینه‌های موجود را انتخاب کنید.',
	'right-vote' => 'ثبت رای',
	'right-voteadmin' => 'مشاهده نتایج آراء',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Mobe
 * @author Nike
 * @author Str4nd
 * @author Varusmies
 * @author Vililikku
 */
$messages['fi'] = array(
	'vote' => 'Äänestä',
	'vote-desc' => 'Tarjoaa yksinkertaisen äänestysmahdollisuuden.',
	'vote-header' => "Voit äänestää '''Maailman ylivaltiasta''' täällä!",
	'vote-current' => "Nykyinen äänesi on '''$1'''.",
	'vote-legend' => 'Äänestä tai muuta ääntäsi',
	'vote-caption' => 'Valintasi:',
	'vote-choices' => 'joker|Jokeri
penguin|Pingviini
riddler|Arvuuttaja',
	'vote-submit' => 'Äänestä',
	'vote-registered' => 'Äänesi on rekisteröity.',
	'vote-view-results' => 'Näytä tulokset',
	'vote-results' => 'Äänestystulokset',
	'vote-results-choice' => 'Valinta',
	'vote-results-count' => 'Määrä',
	'vote-results-none' => 'Yhtään ääntä ei ole annettu.',
	'vote-login' => 'Sinun tulee [$1 kirjautua sisään] äänestääksesi.',
	'vote-invalid-choice' => 'Sinun tulee valita vaihtoehdoista yksi.',
	'right-vote' => 'Äänestää',
	'right-voteadmin' => 'Katsoa äänestystulokset',
);

/** French (Français)
 * @author Ashar Voultoiz
 * @author Crochet.david
 * @author Grondin
 * @author Meithal
 * @author PieRRoMaN
 * @author Urhixidur
 */
$messages['fr'] = array(
	'vote' => 'Vote',
	'vote-desc' => 'Permet de mettre en place des sondages simplement',
	'vote-header' => "Vous pouvez voter pour le '''maître de l’Univers''' ici !",
	'vote-current' => "Votre vote actuel est pour '''$1'''.",
	'vote-legend' => 'Placer ou modifier un vote',
	'vote-caption' => 'Votre sélection :',
	'vote-choices' => 'joker|Le Joker
pingouin|Le Pingouin
sphinx|Sphinx',
	'vote-submit' => 'Voter',
	'vote-registered' => 'Votre vote a été enregistré.',
	'vote-view-results' => 'Résultats',
	'vote-results' => 'Résultats',
	'vote-results-choice' => 'Choix',
	'vote-results-count' => 'Voix',
	'vote-results-none' => 'Aucun vote n’a été placé pour le moment.',
	'vote-login' => 'Vous devez [$1 vous connecter] pour voter.',
	'vote-invalid-choice' => 'Vous devez choisir une des options disponibles.',
	'right-vote' => 'Vote',
	'right-voteadmin' => 'Voir les résultats du vote',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'vote' => 'Votar',
	'vote-desc' => 'Pèrmèt de betar en place des sondâjos simplos.',
	'vote-header' => "Vos pouede votar por lo '''mêtre de l’Univèrs''' ique !",
	'vote-current' => "Voutron voto d’ora est por '''$1'''.",
	'vote-legend' => 'Betar ou ben changiér un voto',
	'vote-caption' => 'Voutron chouèx :',
	'vote-choices' => 'j·oquère|Lo J·oquère
pingoin|Lo Pingoin
sfinxe|Sfinxe',
	'vote-submit' => 'Votar',
	'vote-registered' => 'Voutron voto at étâ encartâ.',
	'vote-view-results' => 'Vêde los rèsultats',
	'vote-results' => 'Rèsultats du voto',
	'vote-results-choice' => 'Chouèx',
	'vote-results-count' => 'Vouèx',
	'vote-results-none' => 'Por lo moment, nion voto at étâ betâ.',
	'vote-login' => 'Vos vos dête [$1 branchiér] por votar.',
	'vote-invalid-choice' => 'Vos dête chouèsir yon des chouèx disponiblos.',
	'right-vote' => 'Votar',
	'right-voteadmin' => 'Vêde los rèsultats du voto',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 */
$messages['fy'] = array(
	'vote' => 'Stimme',
	'vote-desc' => 'Makket simpele stimmings mûglik',
	'vote-header' => "Jo kinne hjirre foar '''Baas fan de Wrâld''' stimme!",
	'vote-current' => "Op it stuit stimme jo foar '''$1'''.",
	'vote-legend' => 'Stimme of stim feroarje',
	'vote-caption' => 'Jo kar:',
	'vote-choices' => 'joker|De Joker
pinguin|De Pinguin
grapmakker|De Grapmakker',
	'vote-submit' => 'Stimme',
	'vote-registered' => 'Jo stim is fêstlein.',
	'vote-view-results' => 'Utslaggen besjen',
	'vote-results' => 'Utslaggen ferkiezings',
	'vote-results-choice' => 'Kar',
	'vote-results-count' => 'Oantal',
	'vote-results-none' => 'Der binne noch gjin stimmen útbrocht.',
	'vote-login' => 'Jo moatte jo [$1 oanmelde] om te kinne stimmen.',
	'vote-invalid-choice' => 'Jo moatte ien fan de beskikbere opsjes kiezen.',
	'right-vote' => 'Stimme',
	'right-voteadmin' => 'Sjoch útslaggen ferkiezings',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'vote-submit' => 'Vótáil',
);

/** Galician (Galego)
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'vote' => 'Votación',
	'vote-desc' => 'Proporciona a capacidade de obter enquisas sinxelas',
	'vote-header' => "Pode votar aquí polo '''Mellor Candidato do Mundo'''!",
	'vote-current' => "O seu voto actual é para '''$1'''.",
	'vote-legend' => 'Votar ou modificar o voto',
	'vote-caption' => 'A súa escolla:',
	'vote-choices' => 'joker|O Joker
penguin|O Pingüín
riddler|Riddler',
	'vote-submit' => 'Votar',
	'vote-registered' => 'O seu voto foi rexistrado.',
	'vote-view-results' => 'Ver os resultados',
	'vote-results' => 'Resultados da votación',
	'vote-results-choice' => 'Escolla',
	'vote-results-count' => 'Reconto',
	'vote-results-none' => 'Aínda non se rexistrou ningún voto.',
	'vote-login' => 'Debe [$1 acceder ao sistema] para votar.',
	'vote-invalid-choice' => 'Ten que escoller unha das opcións dispoñíbeis.',
	'right-vote' => 'Votar',
	'right-voteadmin' => 'Ver os resultados dunha votación',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'vote' => 'Ψηφίζειν',
	'vote-choices' => 'γελωτοποιός|Ὁ Γελωτοποιός
σφηνίσκος|Ὁ Σφηνίσκος
γρῖφος|Γρῖφος',
	'vote-submit' => 'Ψηφίζειν',
	'vote-results-count' => 'Καταμετρεῖν',
	'right-vote' => 'Ψηφίζειν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'vote' => 'Wähle',
	'vote-desc' => 'Bietet eifach Umfrogefähigkeite',
	'vote-header' => "Du chasch doo dr '''Oberscht Oberherr vu dr Wält''' wähle!",
	'vote-current' => "Dyyni aktuäll Stimm isch fir '''$1'''.",
	'vote-legend' => 'Abstimme',
	'vote-caption' => 'Dyyni Stimm:',
	'vote-choices' => 'joker|Dr Joker
penguin|Dr Pinguin
riddler|Riddler',
	'vote-submit' => 'Abstimme',
	'vote-registered' => 'Dyyni Stimm isch regischtriert wore.',
	'vote-view-results' => 'Ergebniss zeige',
	'vote-results' => 'Wahlergebniss',
	'vote-results-choice' => 'Wahl',
	'vote-results-count' => 'Aazahl',
	'vote-results-none' => 'S sin no kei Stimme abgee wore.',
	'vote-login' => 'Du muesch [$1 Di aamälde] zum abstimme.',
	'vote-invalid-choice' => 'Du muesch eini vu dr meglige Optione wähle.',
	'right-vote' => 'Abstimme',
	'right-voteadmin' => 'Abstimmigsergebnis aaluege',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author StuB
 * @author YaronSh
 */
$messages['he'] = array(
	'vote' => 'הצבעה',
	'vote-desc' => 'מתן אפשרות ליכולות הצבעה בסיסיות',
	'vote-header' => "ניתן להצביע כאן ל'''שליט העליון של העולם'''!",
	'vote-current' => "הצבעתכם הנוכחית היא ל'''$1'''.",
	'vote-legend' => 'קבעו או שנו את הצבעתכם',
	'vote-caption' => 'בחירתכם:',
	'vote-choices' => "ג'וקר|הג'וקר
פנגוין|הפנגוין
איש החידות|איש החידות",
	'vote-submit' => 'הצבעה',
	'vote-registered' => 'הצבעתכם נרשמה.',
	'vote-view-results' => 'צפייה בתוצאות',
	'vote-results' => 'תוצאות ההצבעה',
	'vote-results-choice' => 'אפשרות',
	'vote-results-count' => 'מספר מצביעים',
	'vote-results-none' => 'עד כה טרם נשלחו הצבעות.',
	'vote-login' => 'עליכם [$1 להיכנס לחשבון] כדי להצביע.',
	'vote-invalid-choice' => 'יש לבחור באחת האפשרויות הזמינות.',
	'right-vote' => 'הצבעה',
	'right-voteadmin' => 'צפייה בתוצאות ההצבעה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'vote-results-count' => 'गिनती',
);

/** Hiligaynon (Ilonggo)
 * @author Tagimata
 */
$messages['hil'] = array(
	'vote' => 'Boto',
	'vote-submit' => 'Boto',
	'vote-results-count' => 'Isipon',
	'right-vote' => 'Boto',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'vote' => 'Hłosować',
	'vote-desc' => 'Skića jednore naprašowanske móžnosće',
	'vote-header' => "Móžeš tu za '''Supreme Overlord of the World''' hłosować!",
	'vote-current' => "Twój aktualny hłós je za '''$1'''.",
	'vote-legend' => 'Hłosować abo hłós změnić',
	'vote-caption' => 'Waš wuběr:',
	'vote-choices' => 'joker|Joker penguin|Penguin riddler|Riddler',
	'vote-submit' => 'Hłosować',
	'vote-registered' => 'Waše wuzwolenje bu zregistrowane.',
	'vote-view-results' => 'Wuslědki sej wobhladać',
	'vote-results' => 'Wothłosowanske wuslědki',
	'vote-results-choice' => 'Wólba',
	'vote-results-count' => 'Ličić',
	'vote-results-none' => 'Dotal njebu wothłosowane.',
	'vote-login' => 'Dyrbiš so [$1 přizjewić], zo by wothłosował.',
	'vote-invalid-choice' => 'Dyrbiš jednu z k dispoziciji stejacych opcijow wubrać.',
	'right-vote' => 'Wothłosować',
	'right-voteadmin' => 'Wuslědki wothłosowanja pokazać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'vote' => 'Szavazás',
	'vote-desc' => 'Egyszerű szavazások kiírását teszi lehetővé',
	'vote-header' => "Itt szavazhatsz a '''Világ Leghatalmasabb Urára'''!",
	'vote-current' => "Szavazatod ('''$1'''):",
	'vote-legend' => 'Szavazás vagy szavazás módosítása',
	'vote-caption' => 'A te szavazatod:',
	'vote-choices' => 'joker|Joker
penguin|Pingvin
riddler|Rébusz',
	'vote-submit' => 'Szavazás',
	'vote-registered' => 'A szavazatodat rögzítettük.',
	'vote-view-results' => 'Eredmények megtekintése',
	'vote-results' => 'A szavazás eredményei',
	'vote-results-choice' => 'Válasz',
	'vote-results-count' => 'Szavazatok',
	'vote-results-none' => 'Még senki sem adott le szavazott.',
	'vote-login' => 'A szavazáshoz [$1 be kell jelentkezned].',
	'vote-invalid-choice' => 'Választanod kell egyet a megadott lehetőségek közül.',
	'right-vote' => 'szavazás',
	'right-voteadmin' => 'a szavazás eredményének megtekintése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'vote' => 'Votar',
	'vote-desc' => 'Forni le capabilitate de un votation simple.',
	'vote-header' => "Tu pote votar pro le '''Domino Supreme del Mundo''' hic!",
	'vote-current' => "Tu voto actual es pro '''$1.'''",
	'vote-legend' => 'Placiar o modificar voto',
	'vote-caption' => 'Tu selection:',
	'vote-choices' => 'joker|Le Joker
penguin|Le Pinguin
sphinx|Sphinx',
	'vote-submit' => 'Votar',
	'vote-registered' => 'Tu voto ha essite registrate.',
	'vote-view-results' => 'Vider resultatos',
	'vote-results' => 'Resultatos del votation',
	'vote-results-choice' => 'Selection',
	'vote-results-count' => 'Numero',
	'vote-results-none' => 'Nulle votos ha essite placiate pro le momento.',
	'vote-login' => 'Tu debe [$1 aperir un session] pro votar.',
	'vote-invalid-choice' => 'Tu debe seliger un del optiones disponibile.',
	'right-vote' => 'Votar',
	'right-voteadmin' => 'Vider resultatos de votationes',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Ivan Lanin
 * @author Rex
 */
$messages['id'] = array(
	'vote' => 'Pilih',
	'vote-desc' => 'Memberikan fungsi pemungutan suara sederhana',
	'vote-header' => "Anda dapat memilih '''Penguasa Tertinggi Dunia''' di sini!",
	'vote-current' => "Pilihan Anda saat ini adalah '''$1'''.",
	'vote-legend' => 'Berikan atau ubah pilihan',
	'vote-caption' => 'Pilihan Anda:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Pilih',
	'vote-registered' => 'Pilihan Anda telah didaftarkan.',
	'vote-view-results' => 'Lihat hasil',
	'vote-results' => 'Hasil pemungutan suara',
	'vote-results-choice' => 'Pilihan',
	'vote-results-count' => 'Jumlah',
	'vote-results-none' => 'Saat ini belum ada suara yang masuk.',
	'vote-login' => 'Anda harus [$1 masuk log] untuk memberikan suara.',
	'vote-invalid-choice' => 'Anda harus memilih salah satu pilihan yang tersedia.',
	'right-vote' => 'Memberikan suara',
	'right-voteadmin' => 'Melihat hasil pemungutan suara',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'vote' => 'Votu',
	'vote-caption' => 'Ihe Í kpàtàrà áká:',
	'vote-submit' => 'Votu',
	'vote-results' => 'Ihe fútárá votu',
	'right-vote' => 'Votu',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author Cruccone
 * @author Darth Kule
 * @author Stefano-c
 */
$messages['it'] = array(
	'vote' => 'Vota',
	'vote-desc' => 'Fornisce una funzionalità per semplici sondaggi',
	'vote-header' => "Qui è possibile votare per il '''Capo Supremo del Mondo'''",
	'vote-current' => "Il tuo voto corrente è per '''$1'''.",
	'vote-legend' => 'Imposta o modifica il voto',
	'vote-caption' => 'La tua selezione:',
	'vote-choices' => 'joker|Il Joker
pinguino|Il Pinguino
enigmista|Enigmista',
	'vote-submit' => 'Vota',
	'vote-registered' => 'Il tuo voto è stato registrato.',
	'vote-view-results' => 'Vedi risultati',
	'vote-results' => 'Risultati della votazione',
	'vote-results-choice' => 'Scelta',
	'vote-results-count' => 'Conteggio',
	'vote-results-none' => 'Non è stato espresso alcun voto.',
	'vote-login' => 'È necessario [$1 accedere] per votare.',
	'vote-invalid-choice' => 'Devi selezionare una delle possibili opzioni.',
	'right-vote' => 'Vota',
	'right-voteadmin' => 'Vede i risultati del voto',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'vote' => '投票',
	'vote-desc' => '簡素な投票機能を提供する',
	'vote-header' => "あなたはここで'''世界最高君主'''に投票することができます！",
	'vote-current' => "あなたは現在'''$1'''に投票しています。",
	'vote-legend' => '投票または票の修正',
	'vote-caption' => 'あなたの選択:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => '投票',
	'vote-registered' => 'あなたの投票を受け付けました。',
	'vote-view-results' => '結果を表示',
	'vote-results' => '投票結果',
	'vote-results-choice' => '選択',
	'vote-results-count' => '票数',
	'vote-results-none' => '現時点までになされた投票はありません。',
	'vote-login' => '投票するには[$1 ログイン]しなければなりません。',
	'vote-invalid-choice' => 'あなたは選択肢のうち1つを選ばなければなりません。',
	'right-vote' => '投票する',
	'right-voteadmin' => '投票結果を見る',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'vote' => 'Coblos',
	'vote-header' => "Panjenengan bisa milih '''Panguwasa Paling Dhuwur sa-Donya''' ing kéné!",
	'vote-current' => "Swara panjenengan saiki kanggo '''$1'''.",
	'vote-legend' => 'Mèlu nyoblos utawa ganti pilihan',
	'vote-caption' => 'Pilihan panjenengan:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Coblos',
	'vote-registered' => 'Coblosan panjenengan wis dirégistrasi.',
	'vote-view-results' => 'Deleng kasil',
	'vote-results' => 'Kasil coblosan',
	'vote-results-choice' => 'Pilihan',
	'vote-results-count' => 'Cacah swara',
	'vote-results-none' => 'Wektu iki durung ana swara/pilihan sing mlebu.',
	'vote-login' => 'Panjenengan kudu [$1 mlebu log] kanggo mènèhi swara.',
	'vote-invalid-choice' => 'Panjenengan kudu milih salah siji pilihan sing ana.',
);

/** Georgian (ქართული)
 * @author Alsandro
 */
$messages['ka'] = array(
	'vote' => 'ხმა მიეცით',
	'vote-desc' => 'მარტივი გამოკითხვის შესაძლებლობას იძლევა',
	'vote-header' => '??',
	'vote-current' => "თქვენ ხმა მიეცით '''$1'''-ს.",
	'vote-legend' => 'დაადასტურეთ ან შეცვალეთ ხმა',
	'vote-caption' => 'თქვენი არჩევანი:',
	'vote-submit' => 'ხმა',
	'vote-registered' => 'თქვენი ხმა დარეგისტრირდა.',
	'vote-view-results' => 'იხილეთ შედეგები',
	'vote-results' => 'არჩევნების შედეგები',
	'vote-results-choice' => 'არჩევანი',
	'vote-results-count' => 'ათვლა',
	'vote-results-none' => 'ხმები ამ დროისთვის მიცემული არ არის.',
	'vote-login' => 'უნდა [$1 დარეგისტრირდეთ] ხმის მისაცემად.',
	'vote-invalid-choice' => 'უნდა აირჩიოთ ერთ-ერთი არსებული ვარიანტი.',
	'right-vote' => 'ხმა',
	'right-voteadmin' => 'იხილეთ არჩევნების შედეგები',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'vote' => 'បោះឆ្នោត',
	'vote-current' => "អ្នកកំពុងបោះឆ្នោតឱ្យ '''$1'''។",
	'vote-caption' => 'ការជ្រើសរើសរបស់អ្នក:',
	'vote-submit' => 'បោះឆ្នោត',
	'vote-registered' => 'សំឡេងឆ្នោតរបស់អ្នកត្រូវបានកត់ចូលបញ្ជី។',
	'vote-view-results' => 'បង្ហាញ​លទ្ឋផល',
	'vote-results' => 'លទ្ឋផលនៃការបោះឆ្នោត',
	'vote-results-choice' => 'ជម្រើស',
	'vote-results-count' => 'រាប់',
	'vote-results-none' => 'គ្មាន​សំឡេងឆ្នោត ត្រូវ​បាន​បោះ​​ទេ​នាពេលនេះ​។',
	'vote-login' => 'អ្នកត្រូវតែ[$1 កត់ឈ្មោះចូល]ដើម្បីបោះឆ្នោត។',
	'vote-invalid-choice' => 'អ្នកត្រូវតែជ្រើសយកជម្រើសមួយក្នុងចំណោមជម្រើសទាំងឡាយដែលបានផ្ដល់ឱ្យ។',
	'right-vote' => 'បោះ​ឆ្នោត​',
	'right-voteadmin' => 'មើល​លទ្ធផល​ការបោះឆ្នោត​',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'vote-results' => 'ಚುನಾವಣೆಯ ಫಲಿತಾಂಶಗಳು',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'vote' => '투표',
	'vote-desc' => '간단한 투표 기능',
	'vote-header' => "'''세계 대마왕'''을 뽑는 투표를 시작합니다!",
	'vote-current' => "현재 '''$1'''을 투표하고 있습니다.",
	'vote-legend' => '표를 제출하거나 변경하기',
	'vote-caption' => '선택:',
	'vote-choices' => 'joker|조커
penguin|펭귄
riddler|리들러',
	'vote-submit' => '투표',
	'vote-registered' => '해당 표를 등록했습니다.',
	'vote-view-results' => '결과 보기',
	'vote-results' => '투표 결과',
	'vote-results-choice' => '선택',
	'vote-results-count' => '갯수',
	'vote-results-none' => '현재 아무도 투표하지 않았습니다.',
	'vote-login' => '투표하려면 먼저 [$1 로그인]을 해 주세요.',
	'vote-invalid-choice' => '선택지 중 하나를 선택해야 합니다.',
	'right-vote' => '투표하기',
	'right-voteadmin' => '투표 결과 보기',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'vote' => 'Affstemme',
	'vote-desc' => 'Määt en eifache Zoot Afshtemmunge müjjelesch.',
	'vote-header' => "Do kanns hee för der '''Bövverschte en de Welt''' affstemme!",
	'vote-current' => "Ding Stemm (em Momang) es för '''$1'''.",
	'vote-legend' => 'Afstemme',
	'vote-caption' => 'Ding Stemm:',
	'vote-choices' => 'Quatschkopp|Dä Quatschkopp
Charly|Dä Pinguiin
Laachsack|Dä Laachsack',
	'vote-submit' => 'Afstemme',
	'vote-registered' => 'Ding Stemm es jezallt.',
	'vote-view-results' => 'Resultate zeije',
	'vote-results' => 'Et Äjepnis fun de Affstemmung',
	'vote-results-choice' => 'Zor Wahl',
	'vote-results-count' => 'Stemme',
	'vote-results-none' => 'Et sin bes jez kei Stemme afjejovve woode.',
	'vote-login' => 'Do moß [$1 enjelogg sin], öm afstemme ze künne.',
	'vote-invalid-choice' => 'Do moß ein fun de vörhande Müjjeleschkeite ußwähle.',
	'right-vote' => 'Affstemme',
	'right-voteadmin' => 'Affstemmunge beloore',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'vote' => 'Deng',
	'vote-submit' => 'Deng bide',
	'vote-results' => 'Encama dengan',
	'right-vote' => 'Deng',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'vote' => 'Ofstëmmen',
	'vote-desc' => 'Erméiglecht einfach Ënfroen',
	'vote-header' => "Dir kënnt hei iwwer den '''Supreme Overlord of the World''' ofstëmmen!",
	'vote-current' => "Är aktuell Stëmm ass fir '''$1'''.",
	'vote-legend' => 'Stëmm ofginn oder änneren',
	'vote-caption' => 'Är Wiel:',
	'vote-choices' => 'joker|Den Joker
penguin|De Pinguin
riddler|Riddler',
	'vote-submit' => 'Ofstëmmen',
	'vote-registered' => 'Är Stëmm gouf ofgespäichert.',
	'vote-view-results' => "Kuckt d'Resultater",
	'vote-results' => 'Resultater vun der Ofstëmmung',
	'vote-results-choice' => 'Wiel',
	'vote-results-count' => 'Zielen',
	'vote-results-none' => 'Et goufe bis elo nach keng Stëmmen ofginn.',
	'vote-login' => 'Dir musst [$1 Iech aloggen] fir ofzestëmmen.',
	'vote-invalid-choice' => 'Dir musst eng vun de Méiglechkeeten auswielen.',
	'right-vote' => 'Ofstëmmen',
	'right-voteadmin' => "Kuckt d'Resultater vun de Walen",
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 * @author Matasg
 * @author Tomasdd
 */
$messages['lt'] = array(
	'vote' => 'Balsuoti',
	'vote-current' => "Tavo dabartinis balsas yra už '''$1'''.",
	'vote-caption' => 'Tavo pasirinkimas:',
	'vote-submit' => 'Balsuoti',
	'vote-registered' => 'Jūsų balsas buvo užregistruotas.',
	'vote-view-results' => 'Žiūrėti rezultatus',
	'vote-results' => 'Balsavimo rezultatai',
	'vote-login' => 'Norėdami balsuoti, privalote būti [$1 prisijungęs].',
	'right-vote' => 'Balsuoti',
	'right-voteadmin' => 'Žiūrėti balsavimo rezultatus',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'vote-results-none' => 'Tsy nisy vato nalatsaka ankehitriny.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'vote' => 'Гласање',
	'vote-desc' => 'Дава едноставни можности за гласање',
	'vote-header' => "Можете да гласате за '''Врховниот Владетел на Светот''' овде!",
	'vote-current' => "Вашиот моментален глас е за '''$1'''.",
	'vote-legend' => 'Дај или измнени глас',
	'vote-caption' => 'Вашиот избор:',
	'vote-choices' => 'џокер|Џокерот
пингвин|Пингвинот
загатнувач|Загатнувачот',
	'vote-submit' => 'Гласај',
	'vote-registered' => 'Вашиот глас е заведен.',
	'vote-view-results' => 'Преглед на резултатите',
	'vote-results' => 'Резултати од гласањето',
	'vote-results-choice' => 'Избор',
	'vote-results-count' => 'Број',
	'vote-results-none' => 'Досега нема гласови.',
	'vote-login' => 'Мора да [$1 се најавите] за да гласате.',
	'vote-invalid-choice' => 'Морате да изберете нешто од предложеното.',
	'right-vote' => 'Гласање',
	'right-voteadmin' => 'преглед на резултатите од гласањето',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'vote' => 'വോട്ട്',
	'vote-current' => "താങ്കളുടെ നിലവിലുള്ള വോട്ട് '''$1'''വിനാണ്‌.",
	'vote-caption' => 'താങ്കൾ തിരഞ്ഞെടുത്തത്:',
	'vote-submit' => 'വോട്ട്',
	'vote-registered' => 'താങ്കളുടെ വോട്ട് രേഖപ്പെടുത്തിയിരിക്കുന്നു.',
	'vote-view-results' => 'ഫലങ്ങൾ കാണുക',
	'vote-results' => 'വോട്ടെടുപ്പിന്റെ ഫലം',
	'vote-results-count' => 'എണ്ണം',
	'vote-results-none' => 'നിലവിൽ വോട്ടുകളൊന്നും രേഖപ്പെടുത്തിയിട്ടില്ല.',
	'vote-login' => 'വോട്ടു ചെയ്യാൻ താങ്കൾ [$1 ലോഗിൻ] ചെയ്തിരിക്കണം.',
);

/** Marathi (मराठी)
 * @author Mahitgar
 */
$messages['mr'] = array(
	'vote' => 'कौल',
	'vote-header' => "'''विश्वाचा सर्वोच्च ओव्हरलॉर्ड'''ची तुम्ही येथे निवड करु शकता!",
	'vote-current' => "तुमचे सध्याचे मत '''$1'''करिता आहे.",
	'vote-legend' => 'मतदानात सहभागी व्हा अथवा बदल करा',
	'vote-caption' => 'तुमची निवड',
	'vote-choices' => 'जोकर|जोकर पेग्वीन|पेग्वीन रीड्लर |रीडलर',
	'vote-submit' => 'कौल',
	'vote-registered' => 'तुमच्या मताची नोंद झाली आहे.',
	'vote-view-results' => 'निकाल पहा',
	'vote-results' => 'मतदान निकाल',
	'vote-results-choice' => 'पर्याय',
	'vote-results-count' => 'मत मोजणी',
	'vote-results-none' => 'या वेळेपर्यंत कोणतेही मत आले नाही.',
	'vote-login' => 'मतदानात सहभागी होण्याकरिता [$1 दाखल व्हा] केलेच पाहिजे.',
	'vote-invalid-choice' => 'तुम्ही उपलब्ध पर्यायांपैकीच एक पर्याय निवडला पाहिजे.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 * @author Diagramma Della Verita
 * @author Zamwan
 */
$messages['ms'] = array(
	'vote' => 'Undi',
	'vote-desc' => 'Menyediakan keupayaan undian ringkas',
	'vote-header' => "Anda boleh mengundi untuk '''Maharajalela Sedunia''' di sini!",
	'vote-current' => "Undian terkini anda adalah untuk '''$1'''.",
	'vote-legend' => 'Taruh atau pinda undian',
	'vote-caption' => 'Pilihan anda:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Undi',
	'vote-registered' => 'Undian anda telah didaftar',
	'vote-view-results' => 'Lihat hasil',
	'vote-results' => 'Keputusan undian',
	'vote-results-choice' => 'Pilihan',
	'vote-results-count' => 'Kira',
	'vote-results-none' => 'Tiada undian yang ditaruh pada masa ini.',
	'vote-login' => 'Anda perlu [$1 log masuk] untuk mengundi.',
	'vote-invalid-choice' => 'Anda mesti memilih salah satu dari pilihan yang ada.',
	'right-vote' => 'Mengundi',
	'right-voteadmin' => 'Lihat keputusan undian',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'vote' => 'Ivvota',
	'vote-desc' => 'Tipprovdi funzjonalità għal sondaġġi simili',
	'vote-current' => "Il-vot kurrenti tiegħek hu għal '''$1'''.",
	'vote-legend' => 'Ibgħat jew emenda l-vot',
	'vote-caption' => 'L-għażla tiegħek:',
	'vote-submit' => 'Ivvota',
	'vote-registered' => 'Il-vot tiegħek ġie rreġistrat.',
	'vote-view-results' => 'Ara r-riżultati',
	'vote-results' => 'Riżultati tal-votazzjoni',
	'vote-results-choice' => 'Għażla',
	'vote-results-count' => 'Għadd',
	'vote-results-none' => 'Ma ġie espress l-ebda vot.',
	'vote-login' => 'Trid [$1 tidħol fil-kont] biex tivvota.',
	'vote-invalid-choice' => 'Trid tagħżel waħda mill-għażliet disponibbli.',
	'right-voteadmin' => 'Ara r-riżultati tal-voti',
);

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = array(
	'vote' => 'ဆန္ဒမဲ',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'vote' => 'Вайгелень каямо',
	'vote-header' => "Тесэ маштови кочкамс '''Масторлангонь Менельалдонь Ине Азор'''!",
	'vote-caption' => 'Мезе кочкить:',
	'vote-submit' => 'Каямс вайгель',
	'vote-login' => 'Вайгелень каямга эряви [совамс $1 лопантень].',
	'vote-invalid-choice' => 'Эряви кочкамс максозетнень эйстэ.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'vote' => 'Avstemning',
	'vote-desc' => 'Gir enkle avstemningsmuligheter',
	'vote-header' => "Du kan stemme på '''(eksempelbruker)''' her!",
	'vote-current' => "Din nåværende stemme er på '''$1'''.",
	'vote-legend' => 'Velg hvordan du vil stemme',
	'vote-caption' => 'Ditt valg:',
	'vote-choices' => 'bruker1|Første brukernavn
bruker2|Andre brukernavn
bruker3|Tredje brukernavn',
	'vote-submit' => 'Stem',
	'vote-registered' => 'Din stemme har blitt registrert.',
	'vote-view-results' => 'Vis resultater',
	'vote-results' => 'Avstemningsresultater',
	'vote-results-choice' => 'Valg',
	'vote-results-count' => 'Antall',
	'vote-results-none' => 'Ingen stemmer har blitt avgitt enda.',
	'vote-login' => 'Du må [$1 logge inn] for å stemme.',
	'vote-invalid-choice' => 'Du må velge en av de tilgjengelige alternativene.',
	'right-vote' => 'Stem',
	'right-voteadmin' => 'Se resultater fra avstemningen',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'vote' => 'भोट गर्नुहोस',
	'vote-submit' => 'भोट गर्नुहोस',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'vote' => 'Stemmen',
	'vote-desc' => 'Maakt eenvoudige opiniepeilingen mogelijk',
	'vote-header' => "U kunt hier stemmen voor '''Alleenheerser over de Wereld'''!",
	'vote-current' => "Uw huidige stem is voor '''$1'''.",
	'vote-legend' => 'Stem plaatsen of wijzigen',
	'vote-caption' => 'Uw keuze:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Stemmen',
	'vote-registered' => 'Uw stem is opgeslagen.',
	'vote-view-results' => 'Bekijk resultaten',
	'vote-results' => 'Resultaten stemming',
	'vote-results-choice' => 'Keuze',
	'vote-results-count' => 'Aantal',
	'vote-results-none' => 'Er zijn nog geen stemmen uitgebracht.',
	'vote-login' => 'U moet [$1 aanmelden] om te kunnen stemmen.',
	'vote-invalid-choice' => 'U moet een van de beschikbare opties kiezen.',
	'right-vote' => 'Stemmen',
	'right-voteadmin' => 'Resultaten van stemmingen bekijken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'vote' => 'Avstemming',
	'vote-desc' => 'Gjev enkle avrøystingsmoglegheiter.',
	'vote-header' => "Du kan stemme på '''(brukardøme)''' her!",
	'vote-current' => "Di noverande stemme er på '''$1'''.",
	'vote-legend' => 'Velg korleis du vil stemme',
	'vote-caption' => 'Ditt val:',
	'vote-choices' => 'brukar1|Første brukarnamn
brukar2|Andre brukernamn
brukar3|Tredje brukernamn',
	'vote-submit' => 'Stem',
	'vote-registered' => 'Stemma di er registrert.',
	'vote-view-results' => 'Sjå resultat',
	'vote-results' => 'Avstemmingsresultat',
	'vote-results-choice' => 'Val',
	'vote-results-count' => 'Tal',
	'vote-results-none' => 'Ingen stemmer er gjeve enno.',
	'vote-login' => 'Du må [$1 logga inn] for å stemme.',
	'vote-invalid-choice' => 'Du må velje eit av dei tilgjengelege alternativa.',
	'right-vote' => 'Stem',
	'right-voteadmin' => 'Sjå resultatar frå avrøystinga',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'vote' => 'Vòte',
	'vote-desc' => 'Provesís las possibilitats d’eleccion simpla.',
	'vote-header' => "Podètz votar pel '''mèstre de l'Univèrs''' aicí !",
	'vote-current' => "Vòstre vòte actual es per '''$1'''.",
	'vote-legend' => 'Plaçar o modificar un vòte',
	'vote-caption' => 'Vòstra seleccion:',
	'vote-choices' => 'joker|Lo Joquèr
pingouin|Lo Pingoin
sphinx|Esfinx',
	'vote-submit' => 'Votar',
	'vote-registered' => 'Vòstre vòte es estat enregistrat.',
	'vote-view-results' => 'Vejatz los resultats',
	'vote-results' => 'Resultats del vòte',
	'vote-results-choice' => 'Causida',
	'vote-results-count' => 'Compte',
	'vote-results-none' => 'Cap de vòte es pas estat efectuat a aqueste moment.',
	'vote-login' => 'Vos cal [$1 vos connectar] per votar.',
	'vote-invalid-choice' => 'Vos cal causir una de las opcions disponiblas.',
	'right-vote' => 'Vòte',
	'right-voteadmin' => 'Vejatz los resultats del vòte',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Gman124
 */
$messages['pa'] = array(
	'vote' => 'ਵੋਟ',
	'vote-submit' => 'ਵੋਟ',
	'vote-view-results' => 'ਨਤੀਜਾ ਵੇਖੋ',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'vote' => 'Głosuj',
	'vote-desc' => 'Dostarcza prosty mechanizm wyborów',
	'vote-header' => "Tutaj możesz zagłosować na '''Naczelnego Przywódcę Świata'''!",
	'vote-current' => "Głos oddałeś na '''$1'''.",
	'vote-legend' => 'Zagłosuj lub zmień głos',
	'vote-caption' => 'Twój wybór:',
	'vote-choices' => 'joker|Joker
penguin|Pingwin
riddler|Człowiek-Zagadka',
	'vote-submit' => 'Głosuj',
	'vote-registered' => 'Głos został zarejestrowany.',
	'vote-view-results' => 'Zobacz wyniki',
	'vote-results' => 'Wyniki głosowania',
	'vote-results-choice' => 'Wybór',
	'vote-results-count' => 'Policz',
	'vote-results-none' => 'Nikt jeszcze dotąd nie głosował.',
	'vote-login' => 'Głosowanie możliwe jest po [$1 zalogowaniu się].',
	'vote-invalid-choice' => 'Musisz wybrać jedną z dostępnych opcji.',
	'right-vote' => 'Głosowanie',
	'right-voteadmin' => 'Przeglądanie wyników głosowania',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'vote' => 'Voté',
	'vote-desc' => 'A dà na possibilità ëd sondagi sempi',
	'vote-header' => "A peul voté për '''ël superbargé dl<nowiki>'</nowiki>ann''' ambelessì!",
	'vote-current' => "Sò vot corent a l'é për '''$1'''.",
	'vote-legend' => 'Voté ò cambié sò vot',
	'vote-caption' => 'Soa selession:',
	'vote-choices' => 'Mini|Dumini
Chin-a|Chin-a
Gioanin|Gioanin',
	'vote-submit' => 'Voté',
	'vote-registered' => "Sò vot a l'é stait registrà.",
	'vote-view-results' => "Vardé j'arzultà",
	'vote-results' => 'Arzultà dël vot',
	'vote-results-choice' => 'Sërnùa',
	'vote-results-count' => 'Cont',
	'vote-results-none' => "Al dì d'ancheuj a l'ha anco' pa votà gnun.",
	'vote-login' => 'It deuve [$1 intré ant ël sistema] për voté.',
	'vote-invalid-choice' => "A venta ch'as selession-a un-a dj'opsion disponibij.",
	'right-vote' => 'Vota',
	'right-voteadmin' => "Varda j'arzultà dij vot",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'vote' => 'رايه ورکول',
	'vote-desc' => 'په ساده توګه د رايو ورکولو آسانتياوې برابروي',
	'vote-current' => "ستاسې اوسنۍ رايه د '''$1''' لپاره ورکړل شوې.",
	'vote-caption' => 'ستاسې ټاکنه:',
	'vote-submit' => 'رايه ورکول',
	'vote-registered' => 'ستاسې رايه ثبته شوه.',
	'vote-view-results' => 'پايلې کتل',
	'vote-results' => 'د رايو پايلې',
	'vote-results-choice' => 'خوښه',
	'vote-results-count' => 'شمېرل',
	'vote-results-none' => 'تر اوسه پورې هېڅ کومه رايه نه ده ورکړل شوې.',
	'vote-login' => 'د رايې ورکولو لپاره بايد [$1 غونډال ته ننوځۍ].',
	'vote-invalid-choice' => 'بايد چې د شتو خوښو نه يوه وټاکۍ.',
	'right-vote' => 'رايه ورکول',
	'right-voteadmin' => 'د رايو پايلې کتل',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 */
$messages['pt'] = array(
	'vote' => 'Votar',
	'vote-desc' => 'Fornece funcionalidades simples de sondagem',
	'vote-header' => "Pode votar no '''Senhor Supremo do Mundo''' aqui!",
	'vote-current' => "O seu voto actual é a favor de '''$1'''.",
	'vote-legend' => 'Colocar ou corrigir voto',
	'vote-caption' => 'A sua selecção:',
	'vote-choices' => 'joker|O Joker
penguin|O Pinguim
riddler|Enigmático',
	'vote-submit' => 'Votar',
	'vote-registered' => 'O seu voto foi registado.',
	'vote-view-results' => 'Ver resultados',
	'vote-results' => 'Resultado da votação',
	'vote-results-choice' => 'Escolha',
	'vote-results-count' => 'Contagem',
	'vote-results-none' => 'De momento ainda não foram submetidos votos.',
	'vote-login' => 'Terá de [$1 autenticar-se] para votar.',
	'vote-invalid-choice' => 'Deverá seleccionar uma das opções disponíveis.',
	'right-vote' => 'Votar',
	'right-voteadmin' => 'Ver resultados da votação',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author GKnedo
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'vote' => 'Votar',
	'vote-desc' => 'Fornece funcionalidades simples de enquetes',
	'vote-header' => "Pode votar no '''Senhor Supremo do Mundo''' aqui!",
	'vote-current' => "O seu voto atual é a favor de '''$1'''.",
	'vote-legend' => 'Colocar ou corrigir voto',
	'vote-caption' => 'Sua seleção:',
	'vote-choices' => 'joker|O Curinga
penguin|O Pinguim
riddler|O Charada',
	'vote-submit' => 'Votar',
	'vote-registered' => 'O seu voto foi registrado.',
	'vote-view-results' => 'Ver resultados',
	'vote-results' => 'Resultado da votação',
	'vote-results-choice' => 'Escolha',
	'vote-results-count' => 'Contagem',
	'vote-results-none' => 'De momento ainda não foram submetidos votos.',
	'vote-login' => 'Você precisa [$1 autenticar-se] para votar.',
	'vote-invalid-choice' => 'Você deve selecionar uma das opções disponíveis.',
	'right-vote' => 'Votar',
	'right-voteadmin' => 'Ver resultados da votação',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 */
$messages['ro'] = array(
	'vote' => 'Votați',
	'vote-desc' => 'Furnizează capacități simple de votare',
	'vote-current' => "Votul dumneavoastră curent este pentru '''$1'''.",
	'vote-legend' => 'Plasați sau modificați votul',
	'vote-caption' => 'Alegerea dumneavoastră:',
	'vote-submit' => 'Votează',
	'vote-registered' => 'Votul dumneavoastră a fost înregistrat.',
	'vote-view-results' => 'Vizualizează rezultatele',
	'vote-results' => 'Rezultatele votului',
	'vote-results-choice' => 'Alegeți',
	'vote-results-count' => 'Numărare',
	'vote-results-none' => 'Niciun vot nu a fost plasat în acest timp.',
	'vote-login' => 'Trebuie [$1 să vă autentificați] pentru a vota.',
	'vote-invalid-choice' => 'Trebuie să selectați una din opțiunile disponibile.',
	'right-vote' => 'Votați',
	'right-voteadmin' => 'Vedeți rezultatele votului',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'vote' => 'Vote',
	'vote-desc' => "Face ausà 'na capacità semblice pe le sondagge",
	'vote-header' => "Tu puè vutà pe 'u '''Signore Supreme d'u Munne''' aqquà!",
	'vote-current' => "'U vote tuje l'è date a '''$1'''.",
	'vote-legend' => "Chiazze o amende 'u vote",
	'vote-caption' => "'A seleziona toje:",
	'vote-choices' => "chicche|Chicche
checche|Checche
cacheme'ucazze|Cacheme 'u cazze",
	'vote-submit' => 'Vote',
	'vote-registered' => "'U vote tue ha state reggistrate",
	'vote-view-results' => 'Vide le resultete',
	'vote-results' => "Resultete d'u vote",
	'vote-results-choice' => 'Scacchie',
	'vote-results-count' => 'Cuende',
	'vote-results-none' => "Non g'à state date nemmanghe 'nu vote.",
	'vote-login' => 'Tu a essere [$1 collegate] pe vutà.',
	'vote-invalid-choice' => "Tu à scacchià almene 'na opzione valide.",
	'right-vote' => 'Vote',
	'right-voteadmin' => "Vide 'u resultate de le votaziune",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'vote' => 'Голосование',
	'vote-desc' => 'Предоставляет средства для проведения простых голосований',
	'vote-header' => "Вы можете проголосовать за '''Высшего повелителя мира''' здесь!",
	'vote-current' => "Ваш текущий голос за '''$1'''.",
	'vote-legend' => 'Проголосовать или изменить голос',
	'vote-caption' => 'Ваш выбор:',
	'vote-choices' => 'джокер|Джокер
пингвин|Пингвин
загадка|Загадка',
	'vote-submit' => 'Голосовать',
	'vote-registered' => 'Ваш голос был зарегистрирован.',
	'vote-view-results' => 'Посмотреть результаты',
	'vote-results' => 'Результаты голосования',
	'vote-results-choice' => 'Выбор',
	'vote-results-count' => 'Количество',
	'vote-results-none' => 'Нет голосов, отданных в это время',
	'vote-login' => 'Вы должны [$1 представиться системе] для голосования.',
	'vote-invalid-choice' => 'Вы можете выбрать один из доступных вариантов',
	'right-vote' => 'голосовать',
	'right-voteadmin' => 'просматривать результаты голосования',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'vote' => 'Голосованя',
	'vote-submit' => 'Голосовати',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'vote' => 'ඡන්දය දෙන්න',
	'vote-desc' => 'ඡන්දය දීමේ සරල හැකියාවන් සපයා දෙයි',
	'vote-header' => "ඔබට මෙහිදී '''Supreme Overlord of the World''' සඳහා ඡන්දය දිය හැක!",
	'vote-current' => 'ඔබගේ දැනට ඡන්දය "\'$1"\' සඳහා වේ.',
	'vote-legend' => 'ඡන්දය සංශෝධනය හෝ ස්ථානගත කරන්න',
	'vote-caption' => 'ඔබේ තේරීම:',
	'vote-submit' => 'ඡන්දය දෙන්න',
	'vote-registered' => 'ඔබගේ ඡන්දය ලියාපදිංචි කරනු ලැබීය.',
	'vote-view-results' => 'ප්‍රතිඵල පෙන්වන්න',
	'vote-results' => 'ඡන්ද ප්‍රතිඵල',
	'vote-results-choice' => 'තේරීම',
	'vote-results-count' => 'ගණනය',
	'vote-results-none' => 'මෙම අවස්ථාවේ කිසිම ඡන්දයක් ස්ථානගත කරනු නොලැබීය.',
	'vote-login' => 'ඡන්දය දීමට ඔබ [$1 ප්‍රවිෂ්ට] විය යුතුය.',
	'vote-invalid-choice' => 'ඔබ ලබා ගත හැකි විකල්පවලින් එකක් තෝරාගත යුතුය.',
	'right-vote' => 'ඡන්දය දෙන්න',
	'right-voteadmin' => 'ඡන්ද ප්‍රතිඵල බලන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'vote' => 'Hlasovať',
	'vote-desc' => 'Poskytuje jednoduchú možnosť zisťovania',
	'vote-header' => "Tu môžete hlasovať o '''Hlavnom diktátorovi sveta'''!",
	'vote-current' => "Aktuálne hlasujete za '''$1'''.",
	'vote-legend' => 'Hlasovať alebo zmeniť hlas',
	'vote-caption' => 'Vaša voľba:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Hlasovať',
	'vote-registered' => 'Váš hlas bol zaznamenaný.',
	'vote-view-results' => 'Zobraziť výsledky',
	'vote-results' => 'Výsledky hlasovania',
	'vote-results-choice' => 'Voľba',
	'vote-results-count' => 'Počet',
	'vote-results-none' => 'Momentálne nie sú žiadne hlasy.',
	'vote-login' => 'Aby ste mohli hlasovať, musíte [$1 sa prihlásiť].',
	'vote-invalid-choice' => 'Musíte vybrať jednu z dostupných možností.',
	'right-vote' => 'Hlasovať',
	'right-voteadmin' => 'Pozrieť výsledky hlasovania',
);

/** Albanian (Shqip)
 * @author Ergon
 * @author Puntori
 */
$messages['sq'] = array(
	'vote' => 'Voto',
	'vote-current' => "Vota juaj momentale është pë '''$1'''.",
	'vote-caption' => 'Zgjedhja juaj:',
	'vote-submit' => 'Votoni',
	'vote-registered' => 'Vota juaj u regjistrua.',
	'vote-view-results' => 'Shiko rezultatet',
	'vote-results' => 'Rezultatet e votimit',
	'vote-results-choice' => 'Zgjedhja',
	'vote-results-count' => 'Numërimi',
	'vote-results-none' => 'Asnjë votë nuk është regjistruar në këtë kohë.',
	'vote-login' => '[$1 Kyçu] për të votuar.',
	'vote-invalid-choice' => 'Duhet të zgjidhni një nga zgjedhjet e mundshme.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'vote' => 'Гласање',
	'vote-desc' => 'Пружа могућности за постављање једноставних гласања',
	'vote-header' => "Овде можете да гласате за '''ваше омиљено јело'''!",
	'vote-current' => "Ваш тренутни глас је '''$1'''.",
	'vote-legend' => 'Дајте или измените глас',
	'vote-caption' => 'Ваш избор:',
	'vote-choices' => 'vsalata|Воћна салата
pica|Пица
pecenje|Печење',
	'vote-submit' => 'Гласај',
	'vote-registered' => 'Ваш глас је био урачунат.',
	'vote-view-results' => 'Приказ резултата',
	'vote-results' => 'Резултати гласања',
	'vote-results-choice' => 'Избор',
	'vote-results-count' => 'Број гласова',
	'vote-results-none' => 'Тренутно није дат ни један глас.',
	'vote-login' => 'Морате да се [$1 пријавите], да бисте гласали.',
	'vote-invalid-choice' => 'Морате изабрати једну од расположивих опција.',
	'right-vote' => 'Гласање',
	'right-voteadmin' => 'Прегледање резултата гласања',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'vote' => 'Glasanje',
	'vote-desc' => 'Pruža mogućnosti za postavljanje jednostavnih glasanja',
	'vote-header' => "Ovde možete da glasate za '''vaše omiljeno jelo'''!",
	'vote-current' => "Vaš trenutni glas je '''$1'''.",
	'vote-legend' => 'Dajte ili izmenite glas',
	'vote-caption' => 'Vaš izbor:',
	'vote-choices' => 'vsalata|Voćna salata
pica|Pica
pecenje|Pečenje',
	'vote-submit' => 'Glasaj',
	'vote-registered' => 'Vaš glas je bio uračunat.',
	'vote-view-results' => 'Prikaz rezultata',
	'vote-results' => 'Rezultati glasanja',
	'vote-results-choice' => 'Izbor',
	'vote-results-count' => 'Broj glasova',
	'vote-results-none' => 'Trenutno nije dat ni jedan glas.',
	'vote-login' => 'Morate da se [$1 prijavite], da biste glasali.',
	'vote-invalid-choice' => 'Morate izabrati jednu od raspoloživih opcija.',
	'right-vote' => 'Glasanje',
	'right-voteadmin' => 'Pregledanje rezultata glasanja',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'vote' => 'Wääljen',
	'vote-desc' => 'Bjut eenfache Uumfroage-Muugelkhaide',
	'vote-header' => "Du koast hier dän '''Bupperste Buppeheer fon de Waareld''' wäälje!",
	'vote-current' => "Dien aktuelle Stämme is foar '''$1'''",
	'vote-legend' => 'Oustämme',
	'vote-caption' => 'Dien Stämme:',
	'vote-choices' => 'joker|Die Joker
penguin|Die Pinguin
riddler|Riddler',
	'vote-submit' => 'Oustämme',
	'vote-registered' => 'Dien Stämme wuud registrierd.',
	'vote-view-results' => 'Resultoate wiese',
	'vote-results' => 'Woal-Resultoate',
	'vote-results-choice' => 'Woal',
	'vote-results-count' => 'Antaal',
	'vote-results-none' => 'Der wuuden noch neen Stämmen ouroat.',
	'vote-login' => 'Du moast [$1 die anmäldje], uum oustämme tou konnen.',
	'vote-invalid-choice' => 'Du moast een fon do muugelke Optione wäälje.',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'vote-header' => "Anjeun bisa milih '''Supreme Overlord of the World''' di dieu!",
	'vote-current' => "Anjeun geus milih '''$1'''.",
	'vote-caption' => 'Pilihan anjeun:',
	'vote-registered' => 'Pilihan anjeun geus didaptarkeun.',
	'vote-results-count' => 'Itung',
	'vote-login' => 'Anjeun kudu [$1 asup log] pikeun milu milih.',
	'vote-invalid-choice' => 'Anjeun kudu milih salah sahiji ti nu aya.',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author Najami
 */
$messages['sv'] = array(
	'vote' => 'Rösta',
	'vote-desc' => 'Ger enkla omröstningsmöjligheter',
	'vote-header' => "Här kan du rösta fram '''Världens Enväldige Härskare'''!",
	'vote-current' => "Ditt nuvarande val är '''$1'''.",
	'vote-legend' => 'Rösta eller ändra din röst',
	'vote-caption' => 'Ditt val:',
	'vote-choices' => 'joker|Jokern
penguin|Pingvinen
riddler|Gåtan',
	'vote-submit' => 'Rösta',
	'vote-registered' => 'Din röst har registrerats.',
	'vote-view-results' => 'Se resultat',
	'vote-results' => 'Omröstningsresultat',
	'vote-results-choice' => 'Val',
	'vote-results-count' => 'Antal',
	'vote-results-none' => 'Inga röster har avgivits ännu.',
	'vote-login' => 'Du måste [$1 logga in] för att rösta.',
	'vote-invalid-choice' => 'Du måste välja något av de angivna alternativen.',
	'right-vote' => 'Rösta',
	'right-voteadmin' => 'Se resultat från omröstningen',
);

/** Silesian (Ślůnski)
 * @author Lajsikonik
 */
$messages['szl'] = array(
	'vote' => 'Absztimuj',
	'vote-desc' => 'Dowo ajnfachowe możliwośći sznupańo we raji zadań',
	'vote-header' => "Tukej możesz absztimować na '''Naczelnygo Prziwůdce śwjata'''!",
	'vote-current' => "Terozki, absztimowołżeś na '''$1'''",
	'vote-legend' => 'Absztimuj abo zmjyń absztimowańy',
	'vote-caption' => 'Twůj wybůr:',
	'vote-choices' => 'joker|Joker
penguin|Pingwin
riddler|Czowjek-Cweka',
	'vote-submit' => 'Absztimuj',
	'vote-registered' => 'Twoje absztimowańy zostało zarejerowane.',
	'vote-view-results' => 'Uobejzdrzij wyńiki',
	'vote-results' => 'Wyńiki absztimůngu',
	'vote-results-choice' => 'Wybůr',
	'vote-results-count' => 'Policz',
	'vote-results-none' => 'Ńikt jeszcze ńy absztimowoł',
	'vote-login' => 'Coby absztimować, muśisz [$1 zaloguj śe].',
	'vote-invalid-choice' => 'Muśisz wybrać jadna s dostympnych uopcyji.',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'vote' => 'వోటేయండి',
	'vote-current' => "మీ ప్రస్తుత వోటు '''$1'''కి వేసారు.",
	'vote-caption' => 'మీ ఎంపిక:',
	'vote-submit' => 'వోటేయండి',
	'vote-registered' => 'మీ వోటు నమోదయ్యింది.',
	'vote-view-results' => 'ఫలితాలు చూడండి',
	'vote-results' => 'వోటు ఫలితాలు',
	'vote-results-choice' => 'ఎంపిక',
	'vote-results-count' => 'లెక్క',
	'vote-login' => 'వోటేయడానికి మీరు [$1 ప్రవేశించి] ఉండాలి.',
	'right-vote' => 'వోటు',
	'right-voteadmin' => 'వోటు ఫలితాలను చూడండి',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'vote' => 'Раъйгирӣ',
	'vote-header' => "Шумо дар инҷо метавонед барои '''Арбоби Олии Ҷаҳон''' раъй бидиҳед!",
	'vote-current' => "Раъйи феълии шумо барои '''$1''' аст.",
	'vote-legend' => 'Раъйи худро ворид ё ислоҳ намоед',
	'vote-caption' => 'Интихоби шумо:',
	'vote-submit' => 'Сабти раъй',
	'vote-registered' => 'Раъйи шумо сабт шуд.',
	'vote-view-results' => 'Мушоҳидаи натоиҷ',
	'vote-results' => 'Натоиҷи раъйгирӣ',
	'vote-results-choice' => 'Интихоб',
	'vote-results-count' => 'Шумориш',
	'vote-results-none' => 'Дар ҳоли ҳозир ҳеҷ раъйе сабт нашудааст.',
	'vote-login' => 'Барои раъй додан бояд [$1 ба систем вуруд шавед].',
	'vote-invalid-choice' => 'Шумо бояд яке аз ихтиёрҳои мавҷудро интихоб кунед.',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'vote' => "Ra'jgirī",
	'vote-header' => "Şumo dar inço metavoned baroi '''Arbobi Oliji Çahon''' ra'j bidihed!",
	'vote-current' => "Ra'ji fe'liji şumo baroi '''$1''' ast.",
	'vote-legend' => "Ra'ji xudro vorid jo isloh namoed",
	'vote-caption' => 'Intixobi şumo:',
	'vote-submit' => "Sabti ra'j",
	'vote-registered' => "Ra'ji şumo sabt şud.",
	'vote-view-results' => 'Muşohidai natoiç',
	'vote-results' => "Natoiçi ra'jgirī",
	'vote-results-choice' => 'Intixob',
	'vote-results-count' => 'Şumoriş',
	'vote-results-none' => "Dar holi hozir heç ra'je sabt naşudaast.",
	'vote-invalid-choice' => 'Şumo bojad jake az ixtijorhoi mavçudro intixob kuned.',
);

/** Thai (ไทย)
 * @author Manop
 * @author Mopza
 * @author Passawuth
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'vote' => 'ลงคะแนน',
	'vote-current' => "ปัจจุบันคุณลงคะแนนให้ '''$1'''",
	'vote-caption' => 'คุณกำลังเลือก:',
	'vote-submit' => 'ลงคะแนน',
	'vote-registered' => 'คะแนนของคุณถูกนับเรียบร้อยแล้ว',
	'vote-view-results' => 'ดูผล',
	'vote-results' => 'ผลโหวต',
	'vote-results-choice' => 'ตัวเลือก',
	'vote-login' => 'คุณต้อง[$1 ลงชื่อเข้าระบบ]เพื่อลงคะแนน',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'vote' => 'Maghalal/bumoto',
	'vote-desc' => 'Nagbibigay ng payak kakayahan sa pagtanggap ng bilang ng mga boto',
	'vote-header' => "Maaari kang humalal/bumoto para kay/sa '''Kataastaasang Pinakamakapangyarihang Panginoon ng Daigdig''' dito!",
	'vote-current' => "Ang pangkasalukuyang mong boto/paghalal ay para kay '''$1'''.",
	'vote-legend' => 'Ilagay o baguhin ang boto/hinalal',
	'vote-caption' => 'Ang pagpipilian mo:',
	'vote-choices' => "joker|''The Joker'' (\"Ang Mambibiro\")
penguin|''The Penguin'' (\"Ang Penguino\")
riddler|''Riddler'' (\"Mambubugtong\")",
	'vote-submit' => 'Maghalal/Bumoto',
	'vote-registered' => 'Itinala na ang iyong paghalal/boto.',
	'vote-view-results' => 'Tingnan ang mga kinalabasan (resulta)',
	'vote-results' => 'Kinalabasan/resulta ng halalan',
	'vote-results-choice' => 'Pinili',
	'vote-results-count' => 'Bilang',
	'vote-results-none' => 'Wala pang iniligay na mga boto/paghalal sa panahong (oras) ito.',
	'vote-login' => 'Dapat kang [$1 lumagdang papasok] upang makaboto.',
	'vote-invalid-choice' => 'Dapat kang pumili ng isa mula sa makukuhang mga pagpipilian.',
	'right-vote' => 'Bumoto',
	'right-voteadmin' => 'Tingnan ang mga resulta ng pagboto',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'vote' => 'Oy',
	'vote-desc' => 'Basit oylama yetenekleri sağlar',
	'vote-header' => "Burada '''Dünyanın Yüce Derebeyi''' için oy kullanabilirsiniz!",
	'vote-current' => "Şuanki oyunuz '''$1''' için.",
	'vote-legend' => 'Oyu yerleştir veya düzelt',
	'vote-caption' => 'Oyunuz :',
	'vote-choices' => 'joker|Joker
penguin|Penguen
riddler|Bilmececi',
	'vote-submit' => 'Oy',
	'vote-registered' => 'Oyunuz kaydedilmiştir.',
	'vote-view-results' => 'Sonuçları görüntüle',
	'vote-results' => 'Oylama sonuçları',
	'vote-results-choice' => 'Seçim',
	'vote-results-count' => 'Sayma',
	'vote-results-none' => 'Şu anda hiç bir oy yerleştirilmemiş.',
	'vote-login' => 'Oy kullanmak için [$1 giriş yap]malısınız.',
	'vote-invalid-choice' => 'Müsait seçeneklerden birini seçmelisiniz.',
	'right-vote' => 'Oy verir',
	'right-voteadmin' => 'Oylama sonuçlarını görür',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Aleksandrit
 * @author Ilyaroz
 */
$messages['uk'] = array(
	'vote' => 'Голосування',
	'vote-desc' => 'Надає можливість простого голосування',
	'vote-header' => "Ви можете проголосувати за '''Верховного повелителя світу''' тут!",
	'vote-current' => "Ваш поточний голос за '''$1'''.",
	'vote-legend' => 'Проголосувати або змінити голос',
	'vote-caption' => 'Ваш вибір:',
	'vote-choices' => 'джокер|Джокер
пінгвін|Пінгвін
загадка|Загадка',
	'vote-submit' => 'Голосувати',
	'vote-registered' => 'Ваш голос був зареєстрований.',
	'vote-view-results' => 'Переглянути результати',
	'vote-results' => 'Результати голосування',
	'vote-results-choice' => 'Вибір',
	'vote-results-count' => 'Кількість',
	'vote-results-none' => 'Нема голосів, відданих за цей час.',
	'vote-login' => 'Щоб проголосувати, ви повинні [$1 ввійти до системи].',
	'vote-invalid-choice' => 'Ви можете обрати один з доступних варіантів.',
	'right-vote' => 'голосувати',
	'right-voteadmin' => 'переглянути результати голосування',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'vote' => 'Änesta',
	'vote-caption' => 'Teiden valičend:',
	'vote-submit' => 'Änesta',
	'vote-view-results' => "Nähta rezul'tatad",
	'vote-results' => "Änestusen rezul'tatad",
	'vote-results-choice' => 'Valičend',
	'vote-results-count' => 'Lugumär',
	'right-vote' => 'Änesta',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'vote' => 'Bỏ phiếu',
	'vote-desc' => 'Cung cấp tính năng bầu cử đơn giản',
	'vote-header' => "Bạn có thể bỏ phiếu cho '''Chúa tể Tối cao Thế giới''' tại đây!",
	'vote-current' => "Phiếu bầu của bạn hiện ủng hộ '''$1'''.",
	'vote-legend' => 'Bỏ hay đổi phiếu',
	'vote-caption' => 'Lựa chọn của bạn:',
	'vote-choices' => 'joker|The Joker
penguin|The Penguin
riddler|Riddler',
	'vote-submit' => 'Bỏ phiếu',
	'vote-registered' => 'Phiếu bầu của bạn đã được đăng ký.',
	'vote-view-results' => 'Xem kết quả',
	'vote-results' => 'Kết quả bỏ phiếu',
	'vote-results-choice' => 'Lựa chọn',
	'vote-results-count' => 'Đếm',
	'vote-results-none' => 'Chưa có phiếu nào được bỏ vào lúc này.',
	'vote-login' => 'Bạn cần [$1 đăng nhập] để bỏ phiếu.',
	'vote-invalid-choice' => 'Bạn phải chọn một trong các tùy chọn hiện có.',
	'right-vote' => 'Bỏ phiếu',
	'right-voteadmin' => 'Xem kết quả cuộc bỏ phiếu',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'vote' => 'Vögodön',
	'vote-current' => "Vögod anuik ola stüton gebani: '''$1'''.",
	'vote-caption' => 'Väl olik:',
	'vote-submit' => 'Vögodön',
	'vote-registered' => 'Vögod olik peregistaron.',
	'vote-view-results' => 'Logön sekis',
	'vote-results' => 'Vögodamaseks',
	'vote-results-choice' => 'Väl',
	'vote-results-none' => 'Vögods nonik pegivons ün tim at.',
	'vote-login' => 'Mutol [$1 nunädön oki] ad vögodön.',
	'vote-invalid-choice' => 'Mutol välön bali välas gebidik.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'right-vote' => 'שטימען',
);

/** Cantonese (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'vote' => '投票',
	'vote-header' => "你可以響呢度投下'''響呢個世界度至高無尚'''嘅一票！",
	'vote-current' => "你而家係投緊'''$1'''。",
	'vote-legend' => '放或改票',
	'vote-caption' => '你嘅選擇:',
	'vote-choices' => 'joker|小丑
penguin|企鵝
riddler|謎人',
	'vote-submit' => '投',
	'vote-registered' => '你嘅一票已經記錄咗。',
	'vote-view-results' => '睇結果',
	'vote-results' => '投票結果',
	'vote-results-choice' => '選擇',
	'vote-results-count' => '數量',
	'vote-results-none' => '響呢個時間無放任何票。',
	'vote-login' => '你一定要[$1 登入]先可以投票。',
	'vote-invalid-choice' => '你一定要響可以揀嘅選項度揀一個。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author Shinjiman
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'vote' => '投票',
	'vote-desc' => '提供简单的投票功能',
	'vote-header' => "你可以在这里为'''世界霸主'''投票！",
	'vote-current' => "你正在为'''$1'''投票。",
	'vote-legend' => '设置或修改投票',
	'vote-caption' => '你的选择：',
	'vote-choices' => 'joker|小丑
penguin|企鹅
riddler|谜题先生',
	'vote-submit' => '投票',
	'vote-registered' => '已记录你的投票。',
	'vote-view-results' => '查看结果',
	'vote-results' => '投票结果',
	'vote-results-choice' => '选项',
	'vote-results-count' => '总数',
	'vote-results-none' => '现在没有投票。',
	'vote-login' => '你必须[$1 登录]以投票。',
	'vote-invalid-choice' => '你必须选择一个可选选项。',
	'right-vote' => '投票',
	'right-voteadmin' => '查看投票结果',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Shinjiman
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'vote' => '投票',
	'vote-desc' => '提供簡單的投票能力',
	'vote-header' => "您可以在這裡投下'''在這個世界中至高無尚'''的一票！",
	'vote-current' => "您現正為'''$1'''投票。",
	'vote-legend' => '放下或更改投票',
	'vote-caption' => '您的選擇:',
	'vote-choices' => 'joker|小丑
penguin|企鵝
riddler|謎人',
	'vote-submit' => '投票',
	'vote-registered' => '您的一票已經記錄。',
	'vote-view-results' => '看結果',
	'vote-results' => '投票結果',
	'vote-results-choice' => '選擇',
	'vote-results-count' => '數量',
	'vote-results-none' => '在這個時間無放任何投票。',
	'vote-login' => '你必須[$1 登入]以投票。',
	'vote-invalid-choice' => '您一定要在可以選擇的選項中選擇一個。',
	'right-vote' => '投票',
	'right-voteadmin' => '觀看投票結果',
);

