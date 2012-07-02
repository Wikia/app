<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of Quiz.
 * Copyright © 2007 Louis-Rémi BABE. All rights reserved.
 *
 * Quiz is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Quiz is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Quiz; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * Quiz is a quiz tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named Quiz into the "extensions" directory of MediaWiki.
 * * Place this file and the files Quiz.php and quiz.js there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once 'extensions/Quiz/Quiz.php';
 *
 * @file
 * @version 1.0
 * @link http://www.mediawiki.org/wiki/Extension:Quiz Documentation
 * @author BABE Louis-Rémi <lrbabe@gmail.com>
 */

/**
 * Messages list.
 */

$messages = array();

/** English
 * @author Louis-Rémi Babe <lrbabe@gmail.com>
 */
$messages['en'] = array(
	'quiz_desc'	        => 'Allows creation of quizzes',
	'quiz_addedPoints'	=> '{{PLURAL:$1|Point|Points}} added for a correct answer',
	'quiz_cutoffPoints'	=> '{{PLURAL:$1|Point|Points}} for a wrong answer',
	'quiz_ignoreCoef'	=> "Ignore the questions' coefficients",
	'quiz_shuffle'		=> 'Shuffle questions',
	'quiz_colorRight'	=> 'Right',
	'quiz_colorWrong'	=> 'Wrong',
	'quiz_colorNA'		=> 'Not answered',
	'quiz_colorError'	=> 'Syntax error',
	'quiz_correction'	=> 'Submit',
	'quiz_score'		=> 'Your score is $1 / $2',
	'quiz_points'		=> '$1 | {{PLURAL:$2|1 point|$2 points}}',
	'quiz_reset'		=> 'Reset'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Kwj2772
 * @author Purodha
 * @author The Evil IP address
 * @author Александр Сигачёв
 */
$messages['qqq'] = array(
	'quiz_desc' => '{{desc}}',
	'quiz_addedPoints' => 'http://en.wikiversity.org/wiki/Help:Quiz',
	'quiz_ignoreCoef' => 'http://en.wikiversity.org/wiki/Help:Quiz',
	'quiz_shuffle' => 'Button title. See http://en.wikiversity.org/wiki/Help:Quiz',
	'quiz_colorRight' => 'http://en.wikiversity.org/wiki/Help:Quiz
{{Identical|Right}}',
	'quiz_colorWrong' => 'http://en.wikiversity.org/wiki/Help:Quiz',
	'quiz_colorNA' => 'http://en.wikiversity.org/wiki/Help:Quiz',
	'quiz_colorError' => '{{Identical|Syntax error}}',
	'quiz_correction' => '{{Identical|Submit}}',
	'quiz_score' => "$1 = Examminee's score
$2 = Perfect score",
	'quiz_reset' => '{{Identical|Reset}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'quiz_desc' => 'Maak dit moontlik om toetse te skep.',
	'quiz_addedPoints' => "{{PLURAL:$1|Punt|Punte}} bygevoeg vir 'n korrekte antwoord",
	'quiz_cutoffPoints' => "{{PLURAL:$1|Punt|Punte}} afgetrek vir 'n verkeerde antwoord",
	'quiz_ignoreCoef' => "Ignoreer die vrae 'koëffisiënte",
	'quiz_shuffle' => 'Skommel vrae',
	'quiz_colorRight' => 'Reg',
	'quiz_colorWrong' => 'Verkeerd',
	'quiz_colorNA' => 'Nie geantwoord',
	'quiz_colorError' => 'Sintaksfout',
	'quiz_correction' => 'Verbetering',
	'quiz_score' => 'U punte is $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punt|$2 punte}}',
	'quiz_reset' => 'Herstel',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'quiz_desc' => 'Premite a creyación de quizzes',
	'quiz_addedPoints' => '{{PLURAL:$1|Punto|Puntos}} por cada respuesta encertata',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punto sacato|Puntos sacatos}} por cada respuesta entivocata:',
	'quiz_ignoreCoef' => "Ignorar os puntos d'as preguntas",
	'quiz_shuffle' => 'Desordenar as preguntas',
	'quiz_colorRight' => 'Encertatas',
	'quiz_colorWrong' => 'Entivocatas',
	'quiz_colorNA' => 'No responditas',
	'quiz_colorError' => 'Error de sintaxi',
	'quiz_correction' => 'Correchir',
	'quiz_score' => 'A suya puntuación ye $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punto|$2 puntos}}',
	'quiz_reset' => 'Prencipiar',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'quiz_desc' => 'يسمح بإنشاء اختبارات',
	'quiz_addedPoints' => 'أضيفت {{PLURAL:$1||نقطة|نقطتان|نقاط}} مقابل الإجابة الصحيحة',
	'quiz_cutoffPoints' => 'خصمت {{PLURAL:$1||نقطة|نقطتان|نقطاط}} مقابل الإجابة الخاطئة',
	'quiz_ignoreCoef' => 'تجاهل معاملات الأسئلة',
	'quiz_shuffle' => 'أسئلة مختلطة',
	'quiz_colorRight' => 'صواب',
	'quiz_colorWrong' => 'خطأ',
	'quiz_colorNA' => 'لم تتم الإجابة عليه',
	'quiz_colorError' => 'خطأ صياغة',
	'quiz_correction' => 'أرسل',
	'quiz_score' => 'نتيجتك هي $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2||نقطة واحدة|نقطتان|$2 نقاط|$2 نقطة}}',
	'quiz_reset' => 'إعادة ضبط',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'quiz_colorRight' => 'ܬܪܝܨܐ',
	'quiz_colorWrong' => 'ܠܐ ܬܪܝܨܐ',
	'quiz_correction' => 'ܫܕܪ',
	'quiz_score' => 'ܦܠܛܐ ܕܝܠܟ ܗܘ $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 ܢܘܩܙܐ|$2 ܢܘܩܙ̈ܐ}}',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'quiz_desc' => 'بيسمح بعمل امتحانات',
	'quiz_addedPoints' => '{{PLURAL:$1|النقطة|النقط}} اللى بتضاف لما تجاوب صح',
	'quiz_cutoffPoints' => '{{PLURAL:$1|النقطة|النقط}} اللى بتتخصم لما تجاوب غلط',
	'quiz_ignoreCoef' => 'اتجاهل معاملات الاسئلة',
	'quiz_shuffle' => 'اسئلة متلخبطة',
	'quiz_colorRight' => 'صح',
	'quiz_colorWrong' => 'غلط',
	'quiz_colorNA' => 'ماتجاوبش عليه',
	'quiz_colorError' => 'غلط فى السينتاكس',
	'quiz_correction' => 'تنفيذ',
	'quiz_score' => '$1 / $2 النتيجة بتاعتك هي',
	'quiz_points' => '$1 | {{PLURAL:$2|1 نقطة|$2 نقطة}}',
	'quiz_reset' => 'اضبط من تاني',
);

/** Asturian (Asturianu)
 * @author Cedric31
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'quiz_desc' => "Permite la creación d'encuestes",
	'quiz_addedPoints' => '{{PLURAL:$1|Puntu añadíu|Puntos añadíos}} por rempuesta correuta',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Puntu|Puntos}} por rempuesta incorreuta',
	'quiz_ignoreCoef' => 'Inorar los coeficientes de les entrugues',
	'quiz_shuffle' => 'Revolver les entrugues',
	'quiz_colorRight' => 'Correuto',
	'quiz_colorWrong' => 'Incorreuto',
	'quiz_colorNA' => 'Non respondida',
	'quiz_colorError' => 'Error de sintaxis',
	'quiz_correction' => 'Unviar',
	'quiz_score' => 'La to puntuación ye $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 puntu|$2 puntos}}',
	'quiz_reset' => 'Reaniciar',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vugar 1981
 * @author Wertuose
 */
$messages['az'] = array(
	'quiz_colorRight' => 'Doğru',
	'quiz_colorWrong' => 'Yanlış',
	'quiz_colorNA' => 'Cavabsız',
	'quiz_correction' => 'Təsdiq et',
	'quiz_reset' => 'Qur',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'quiz_desc' => 'Һораулыҡ булдырырға мөмкинлек бирә',
	'quiz_addedPoints' => 'Дөрөҫ яуап өсөн {{PLURAL:$1|мәрәй|мәрәй}} өҫтәлде',
	'quiz_cutoffPoints' => 'Яңылыш яуап өсөн {{PLURAL:$1|мәрәй|мәрәй}}',
	'quiz_ignoreCoef' => 'Һорау коэффициенттарын иҫәпкә алмаҫҡа',
	'quiz_shuffle' => 'Һорауҙарҙы бутарға',
	'quiz_colorRight' => 'Дөрөҫ',
	'quiz_colorWrong' => 'Яңылыш',
	'quiz_colorNA' => 'Яуапланманы',
	'quiz_colorError' => 'Синтаксик хата',
	'quiz_correction' => 'Ебәрергә',
	'quiz_score' => 'Мәрәйегеҙ: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 мәрәй|$2 мәрәй}}',
	'quiz_reset' => 'Баштан алырға',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'quiz_desc' => 'اجازه دنت په شرکتن معما',
	'quiz_addedPoints' => 'نمره په درستین جواب اضافه بوت',
	'quiz_cutoffPoints' => 'نمره په جواب غلظ کم بوت',
	'quiz_ignoreCoef' => 'ضریب سوالات مه دید',
	'quiz_shuffle' => 'جوستان به هم ریچ',
	'quiz_colorRight' => 'راست',
	'quiz_colorWrong' => 'اشتباه',
	'quiz_colorNA' => 'بی پسوء',
	'quiz_colorError' => 'حطا ساختار',
	'quiz_correction' => 'دیم دی',
	'quiz_score' => 'شمی نمره $1 / $2 اینت',
	'quiz_points' => '$1 | $2 نکته(s)',
	'quiz_reset' => 'برگردینگ',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'quiz_shuffle' => 'Balasahon an mga hapot',
	'quiz_colorRight' => 'Tamâ',
	'quiz_colorWrong' => 'Salâ',
	'quiz_correction' => 'Isumitir',
	'quiz_points' => '$1 | $2 punto(s)',
	'quiz_reset' => 'Ibalik',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'quiz_desc' => 'Дазваляе стварэньне віктарын',
	'quiz_addedPoints' => '$1 {{PLURAL:$1|пункт дададзены|пункты дададзеныя|пунктаў дададзена}} за правільны адказ',
	'quiz_cutoffPoints' => '$1 {{PLURAL:$1|пункт зьняты|пункты зьнятыя|пунктаў зьнята}} за няправільны адказ',
	'quiz_ignoreCoef' => 'Ігнараваць каэфіцыенты пытаньняў',
	'quiz_shuffle' => 'Перамяшаць пытаньні',
	'quiz_colorRight' => 'Правільна',
	'quiz_colorWrong' => 'Няправільна',
	'quiz_colorNA' => 'Няма адказу',
	'quiz_colorError' => 'Сынтаксычная памылка',
	'quiz_correction' => 'Даслаць',
	'quiz_score' => 'Вы набралі $1 {{PLURAL:$1|пункт|пункты|пунктаў}} з $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|пункт|пункты|пунктаў}}',
	'quiz_reset' => 'Скінуць',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'quiz_desc' => 'Позволява създаването на анкети',
	'quiz_addedPoints' => '{{PLURAL:$1|Точка, добавяна|Точки, добавяни}} за правилен отговор',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Точка, отнемана|Точки, отнемани}} за грешен отговор',
	'quiz_ignoreCoef' => 'Пренебрегване на коефициентите на въпросите',
	'quiz_shuffle' => 'Разбъркване на въпросите',
	'quiz_colorRight' => 'Правилно',
	'quiz_colorWrong' => 'Грешно',
	'quiz_colorNA' => 'Без отговор',
	'quiz_colorError' => 'Синтактична грешка',
	'quiz_correction' => 'Изпращане',
	'quiz_score' => 'Постижението ви е $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|една точка|$2 точки}}',
	'quiz_reset' => 'Отмяна',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'quiz_desc' => 'কুইজ সৃষ্টির অনুমতি দেয়',
	'quiz_addedPoints' => 'সঠিক উত্তরের জন্য {{PLURAL:$1|পয়েন্ট|পয়েন্টসমূহ}} যোগ হয়েছে',
	'quiz_cutoffPoints' => 'ভুল উত্তরের জন্য {{PLURAL:$1|পয়েন্ট|পয়েন্টসমূহ}} বিয়োগ হয়েছে',
	'quiz_ignoreCoef' => 'প্রশ্নগুলির সহগগুলি উপেক্ষা করা হোক',
	'quiz_shuffle' => 'প্রশ্ন উলোটপালোট করো',
	'quiz_colorRight' => 'সঠিক',
	'quiz_colorWrong' => 'ভুল',
	'quiz_colorNA' => 'উত্তর দেওয়া হয়নি',
	'quiz_colorError' => 'বাক্যপ্রকরণ ত্রুটি',
	'quiz_correction' => 'জমা দাও',
	'quiz_score' => 'আপনার স্কোর $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 পয়েন্ট|$2 পয়েন্টসমূহ}}',
	'quiz_reset' => 'পুনরায় আরম্ভ করুন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'quiz_desc' => 'Aotren a ra krouiñ kwizoù',
	'quiz_addedPoints' => 'Ouzhpennet {{PLURAL:$1|Poent|Poent}} dre respont mat',
	'quiz_cutoffPoints' => 'Tennet {{PLURAL:$1|Poent|Poent}} dre respont fall',
	'quiz_ignoreCoef' => 'Na ober van ouzh kenefeder ar goulennoù',
	'quiz_shuffle' => 'Meskañ ar goulennoù',
	'quiz_colorRight' => 'Mat',
	'quiz_colorWrong' => 'Fall',
	'quiz_colorNA' => 'Direspont',
	'quiz_colorError' => 'Fazi ereadur',
	'quiz_correction' => 'Kas',
	'quiz_score' => 'Ho skor zo par da $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 poent|$2 poent}}',
	'quiz_reset' => 'Adderaouekaat',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'quiz_desc' => 'Omogućuje pravljenje kvizova',
	'quiz_addedPoints' => '{{PLURAL:$1|Bod dodan|Boda dodana|Bodova dodano}} za tačan odgovor',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Bod|Boda|Bodova}} za pogrešan odgovor',
	'quiz_ignoreCoef' => 'Zanemari koeficijente pitanja',
	'quiz_shuffle' => 'Izmiješaj pitanja',
	'quiz_colorRight' => 'Tačno',
	'quiz_colorWrong' => 'Pogrešno',
	'quiz_colorNA' => 'Nije odgovoreno',
	'quiz_colorError' => 'Sintaksna greška',
	'quiz_correction' => 'Pošalji',
	'quiz_score' => 'Vaš rezultat je $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 bod|$2 boda|$2 bodova}}',
	'quiz_reset' => 'Očisti',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 */
$messages['ca'] = array(
	'quiz_desc' => 'Permet la creació de concursos',
	'quiz_addedPoints' => '{{PLURAL:$1|punt|punts}} per resposta correcta',
	'quiz_cutoffPoints' => '{{PLURAL:$1|punt|punts}} per resposta incorrecta',
	'quiz_ignoreCoef' => 'Ignora els coeficients de les qüestions',
	'quiz_shuffle' => 'Preguntes aleatòries',
	'quiz_colorRight' => 'Correcte',
	'quiz_colorWrong' => 'Incorrecte',
	'quiz_colorNA' => 'Sense resposta',
	'quiz_colorError' => 'Error de sintaxi',
	'quiz_correction' => 'Envia',
	'quiz_score' => 'La vostra puntuació és $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punt|$2 punts}}',
	'quiz_reset' => 'Restaura',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'quiz_correction' => 'ناردن',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'quiz_desc' => 'Umožňuje tvorbu kvízů',
	'quiz_addedPoints' => '{{PLURAL:$1|Bod připočtený|Body připočtené|Body připočtené}} za správnou odpověď',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Bod odečtený|Body odečtené|Body odečtené}} za špatnou odpověď',
	'quiz_ignoreCoef' => 'Ignorovat koeficienty otázek',
	'quiz_shuffle' => 'Promíchat otázky',
	'quiz_colorRight' => 'Správně',
	'quiz_colorWrong' => 'Špatně',
	'quiz_colorNA' => 'Nezodpovězeno',
	'quiz_colorError' => 'Syntaktická chyba',
	'quiz_correction' => 'Odeslat',
	'quiz_score' => 'Váš výsledek je $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|$2 bod|$2 body|$2 bodů}}',
	'quiz_reset' => 'Reset',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'quiz_desc' => 'Yn galluogi llunio cwisiau',
	'quiz_addedPoints' => 'Nifer y {{PLURAL:$1|pwyntiau}} am ateb cywir',
	'quiz_cutoffPoints' => 'Nifer y {{PLURAL:$1|pwyntiau}} am ateb anghywir',
	'quiz_ignoreCoef' => "Anwybyddu cyfernodau'r cwestiynau",
	'quiz_shuffle' => 'Cymysger y cwestiynau',
	'quiz_colorRight' => 'Cywir',
	'quiz_colorWrong' => 'Anghywir',
	'quiz_colorNA' => 'Heb ei ateb',
	'quiz_colorError' => 'Gwall yn y gystrawen',
	'quiz_correction' => 'Cyflwyner',
	'quiz_score' => 'Eich sgôr yw $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|0 pwyntiau|1 pwynt|2 bwynt|3 phwynt|6 phwynt|$2 pwynt}}',
	'quiz_reset' => 'Ailosoder',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 * @author Peter Alberti
 */
$messages['da'] = array(
	'quiz_desc' => 'Tillader oprettelse af quizzer',
	'quiz_addedPoints' => '{{PLURAL:$1|Point|point}} for korrekt svar',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Point|Point}} for et forkert svar',
	'quiz_ignoreCoef' => 'Ignorer spørgsmålenes koefficienter',
	'quiz_shuffle' => 'Bland spørgsmålene',
	'quiz_colorRight' => 'Ret',
	'quiz_colorWrong' => 'Fejl',
	'quiz_colorNA' => 'Ikke svared',
	'quiz_colorError' => 'syntaksfejl',
	'quiz_correction' => 'Send',
	'quiz_score' => 'Din pointsum er $1 af $2 mulige',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|point|point}}',
	'quiz_reset' => 'Nulstil',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'quiz_desc' => 'Ermöglicht die Erstellung von Quizspielen',
	'quiz_addedPoints' => '{{PLURAL:$1|Pluspunkt|Pluspunkte}} für eine richtige Antwort',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Minuspunkt|Minuspunkte}} für eine falsche Antwort',
	'quiz_ignoreCoef' => 'Ignoriere den Fragen-Koeffizienten',
	'quiz_shuffle' => 'Fragen mischen',
	'quiz_colorRight' => 'Richtig',
	'quiz_colorWrong' => 'Falsch',
	'quiz_colorNA' => 'Nicht beantwortet',
	'quiz_colorError' => 'Syntaxfehler',
	'quiz_correction' => 'Speichern',
	'quiz_score' => 'Punkte: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 Punkt|$2 Punkte}}',
	'quiz_reset' => 'Neustart',
);

/** Zazaki (Zazaki)
 * @author Aspar
 */
$messages['diq'] = array(
	'quiz_desc' => 'desturê vıraştışê quizi dano',
	'quiz_addedPoints' => '{{PLURAL:$1|Puan|Puan}} qey cewabo raşt diyayo.',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Puan|Puan}} qey cewabo şaş',
	'quiz_ignoreCoef' => 'Soruların katsayısını ihmal et',
	'quiz_shuffle' => 'persan têmiyan ker.',
	'quiz_colorRight' => 'raşt',
	'quiz_colorWrong' => 'şaş',
	'quiz_colorNA' => 'cewab cı nêdiya',
	'quiz_colorError' => 'xetaya sebtaksi',
	'quiz_correction' => 'bışaw',
	'quiz_score' => 'Skorê şıma $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 puan|$2 puan}}',
	'quiz_reset' => 'sıfır ker/reset ker',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'quiz_desc' => 'Zmóžnja wutwórjenje kwisow',
	'quiz_addedPoints' => '{{PLURAL:$1|Dypk|Dypka|Dypki|Dypkow}} za pšawe wótegrono',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Dypk|Dypka|Dypki|Dypjkow}} za wopacne wótegrono',
	'quiz_ignoreCoef' => 'Ignorěruj koeficientow pšašanjow',
	'quiz_shuffle' => 'Pšašanja měšaś',
	'quiz_colorRight' => 'Pšawy',
	'quiz_colorWrong' => 'Wopacny',
	'quiz_colorNA' => 'Bźez wótegrona',
	'quiz_colorError' => 'Syntaksowa zmólka',
	'quiz_correction' => 'Wótpósłaś',
	'quiz_score' => 'Twóje dypki: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 dypk|$2 dypka|$2 dypki|$2 dypkow}}',
	'quiz_reset' => 'Wót nowego zachopiś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author ZaDiak
 */
$messages['el'] = array(
	'quiz_desc' => 'Επιτρέπει τη δημιουργία των κουίζ',
	'quiz_addedPoints' => '{{PLURAL:$1|πόντος|πόντοι}} προστίθονται για μια σωστή απάντηση',
	'quiz_cutoffPoints' => '{{PLURAL:$1|πόντος|πόντοι}} για μια λανθασμένη απάντηση',
	'quiz_ignoreCoef' => 'Αγνοήστε τους συντελεστές των ερωτήσεων',
	'quiz_shuffle' => 'Ανακάτεμα ερωτήσεων',
	'quiz_colorRight' => 'Σωστό',
	'quiz_colorWrong' => 'Λάθος',
	'quiz_colorNA' => 'Δεν απαντήθηκε',
	'quiz_colorError' => 'Συντακτικό λάθος',
	'quiz_correction' => 'Καταχώρηση',
	'quiz_score' => 'Η Βαθμολογία σας είναι $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 βαθμό|$2 βαθμούς}}',
	'quiz_reset' => 'Αναίρεση',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'quiz_desc' => 'Permesas kreadon de kvizoj',
	'quiz_addedPoints' => '{{PLURAL:$1|Poento|Poentoj}} por ĝusta respondo',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Poento subtrahita|Poentoj subtrahitaj}} por malĝusta respondo',
	'quiz_ignoreCoef' => 'Ignoru la koeficientojn de demandoj.',
	'quiz_shuffle' => 'Hazardmiksi demandaron',
	'quiz_colorRight' => 'Ĝusta',
	'quiz_colorWrong' => 'Malĝusta',
	'quiz_colorNA' => 'Ne respondita',
	'quiz_colorError' => 'Sintaksa eraro',
	'quiz_correction' => 'Ek!',
	'quiz_score' => 'Viaj poentoj estas $1 / $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|1 poento|poentoj}}',
	'quiz_reset' => 'Reŝarĝi',
);

/** Spanish (Español)
 * @author Ascánder
 * @author Crazymadlover
 * @author Sanbec
 */
$messages['es'] = array(
	'quiz_desc' => 'Permite la creación de quices',
	'quiz_addedPoints' => '{{PLURAL:$1|Punto|Puntos}} agregados por una respuesta acertada',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punto|Puntos}} penalizados por una respuesta errónea',
	'quiz_ignoreCoef' => 'Ignorar los puntos de cada pregunta',
	'quiz_shuffle' => 'Desordenar preguntas',
	'quiz_colorRight' => 'Acertadas',
	'quiz_colorWrong' => 'Falladas',
	'quiz_colorNA' => 'No contestadas',
	'quiz_colorError' => 'Error de sintaxis',
	'quiz_correction' => 'Enviar',
	'quiz_score' => 'Tu puntuación es de $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punto|$2 puntos}}',
	'quiz_reset' => 'Empezar de nuevo',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'quiz_desc' => 'Võimaldab küsitlusi korraldada.',
	'quiz_colorRight' => 'Õige',
	'quiz_colorWrong' => 'Vale',
	'quiz_colorNA' => 'Vastamata',
	'quiz_colorError' => 'Süntaksiviga',
	'quiz_correction' => 'Saada',
	'quiz_score' => 'Punktid: $1 / $2',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'quiz_desc' => 'Galdera-sortak sortzeko',
	'quiz_colorRight' => 'Zuzenak',
	'quiz_colorWrong' => 'Okerrak',
	'quiz_colorNA' => 'Erantzun gabe',
	'quiz_colorError' => 'Sintaxi-errorea',
	'quiz_correction' => 'Bidali',
	'quiz_score' => 'Zure kalifikazioa $1 / $2 da',
	'quiz_points' => '$1 | {{PLURAL:$2|puntu 1|$2 puntu}}',
	'quiz_reset' => 'Hasieratu',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'quiz_desc' => 'ایجاد آزمون را ممکن می‌سازد',
	'quiz_addedPoints' => '{{PLURAL:$1|امتیاز|امتیاز}} هر پاسخ درست',
	'quiz_cutoffPoints' => '{{PLURAL:$1|امتیاز|امتیاز}} منفی هر پاسخ نادرست',
	'quiz_ignoreCoef' => 'نادیده گرفتن ضریب سوال‌ها',
	'quiz_shuffle' => 'برزدن سوال‌ها',
	'quiz_colorRight' => 'درست',
	'quiz_colorWrong' => 'نادرست',
	'quiz_colorNA' => 'پاسخ داده نشده',
	'quiz_colorError' => 'خطای نحوی',
	'quiz_correction' => 'ارسال',
	'quiz_score' => 'امتیاز شما $1 از $2 است',
	'quiz_points' => '$1 | {{PLURAL:$2|۱ امتیاز|$2 امتیاز}}',
	'quiz_reset' => 'از نو',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Pe3
 * @author Str4nd
 * @author Tarmo
 */
$messages['fi'] = array(
	'quiz_desc' => 'Mahdollistaa kyselyiden luomisen.',
	'quiz_addedPoints' => '{{PLURAL:$1|Piste|Pisteitä}} lisätty oikeasta vastauksesta',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Piste|Pisteitä}} väärästä vastauksesta',
	'quiz_ignoreCoef' => 'Jätä huomioimatta kysymysten kertoimet',
	'quiz_shuffle' => 'Sekoita kysymykset',
	'quiz_colorRight' => 'Oikein',
	'quiz_colorWrong' => 'Väärin',
	'quiz_colorNA' => 'Vastaamatta',
	'quiz_colorError' => 'Jäsennysvirhe',
	'quiz_correction' => 'Lähetä',
	'quiz_score' => 'Tuloksesi on $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 piste|$2 pistettä}}',
	'quiz_reset' => 'Tyhjennä',
);

/** Faroese (Føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'quiz_desc' => 'Loyvir upprættan av spurnarkappingum',
	'quiz_colorRight' => 'Rætt',
	'quiz_colorWrong' => 'Skeivt',
	'quiz_colorNA' => 'Onki svar',
	'quiz_colorError' => 'Syntaks feilur',
	'quiz_correction' => 'Send inn',
);

/** French (Français)
 * @author Grondin
 * @author Meno25
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'quiz_desc' => 'Permet la création des quiz',
	'quiz_addedPoints' => '{{PLURAL:$1|Point ajouté|Points ajoutés}} pour une réponse juste',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Point retiré|Points retirés}} pour une réponse erronée',
	'quiz_ignoreCoef' => 'Ignorer les coefficients des questions',
	'quiz_shuffle' => 'Mélanger les questions',
	'quiz_colorRight' => 'Juste',
	'quiz_colorWrong' => 'Faux',
	'quiz_colorNA' => 'Non répondu',
	'quiz_colorError' => 'Erreur de syntaxe',
	'quiz_correction' => 'Soumettre',
	'quiz_score' => 'Votre pointage est $1 / $2',
	'quiz_points' => '$1 | $2 point{{PLURAL:||s}}',
	'quiz_reset' => 'Réinitialiser',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'quiz_desc' => 'Pèrmèt la crèacion des quèstionèros.',
	'quiz_addedPoints' => '{{PLURAL:$1|Pouent apondu|Pouents apondus}} por una rèponsa justa',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Pouent enlevâ|Pouents enlevâs}} por una rèponsa fôssa',
	'quiz_ignoreCoef' => 'Ignorar los factors de les quèstions',
	'quiz_shuffle' => 'Mècllar les quèstions',
	'quiz_colorRight' => 'Justo',
	'quiz_colorWrong' => 'Fôx',
	'quiz_colorNA' => 'Pas rèpondu',
	'quiz_colorError' => 'Èrror de sintaxa',
	'quiz_correction' => 'Sometre',
	'quiz_score' => 'Voutra mârca est $1 / $2',
	'quiz_points' => '$1 | $2 pouent{{PLURAL:$2||s}}',
	'quiz_reset' => 'Tornar inicialisar',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'quiz_reset' => 'Leechmeitsje',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'quiz_desc' => 'Permite a creación de preguntas',
	'quiz_addedPoints' => '{{PLURAL:$1|Punto engadido|Puntos engadidos}} por cada resposta correcta',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punto restado|Puntos restados}} por cada resposta errónea',
	'quiz_ignoreCoef' => 'Ignorar os coeficientes das preguntas',
	'quiz_shuffle' => 'Barallar as preguntas',
	'quiz_colorRight' => 'Ben',
	'quiz_colorWrong' => 'Mal',
	'quiz_colorNA' => 'Sen resposta',
	'quiz_colorError' => 'Erro de sintaxe',
	'quiz_correction' => 'Enviar',
	'quiz_score' => 'A súa puntuación é $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punto|$2 puntos}}',
	'quiz_reset' => 'Limpar',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'quiz_correction' => 'Ὑποβάλλειν',
	'quiz_reset' => 'Ἀνατιθέναι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'quiz_desc' => 'Macht s Aalege vu Quizspiiler megli',
	'quiz_addedPoints' => '{{PLURAL:$1|Punkt|Pinkt}} fir e richtigi Antwort',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Minuspunkt|Minuspinkt}} fir e falschi Antwort',
	'quiz_ignoreCoef' => 'Ignorier dr Froge-Koeffizient',
	'quiz_shuffle' => 'Froge mischle',
	'quiz_colorRight' => 'Richtig',
	'quiz_colorWrong' => 'Falsch',
	'quiz_colorNA' => 'Kei Antwort gee',
	'quiz_colorError' => 'Syntaxfähler',
	'quiz_correction' => 'Korrektur',
	'quiz_score' => 'Pinkt: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 Punkt|$2 Pinkt}}',
	'quiz_reset' => 'Nejstart',
);

/** Gujarati (ગુજરાતી)
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'quiz_desc' => 'પ્રશોત્તર રચવાની પરવાનગિ આપો',
	'quiz_addedPoints' => 'ખરા જવાબ માટે {{PLURAL:$1|ગુણ|ગુણો}} ઉમેરાયા.',
	'quiz_cutoffPoints' => 'ખોટા જવાબ માટે {{PLURAL:$1|ગુણ|ગુણો}}.',
	'quiz_ignoreCoef' => 'પ્રશ્નોના અચળાંકો અવગણો',
	'quiz_shuffle' => 'પ્રશ્ન બદલો',
	'quiz_colorRight' => 'સાચું',
	'quiz_colorWrong' => 'ખોટું',
	'quiz_colorNA' => 'જવાબ ન અપાયેલ',
	'quiz_colorError' => 'સૂત્રલેખન ત્રુટિ',
	'quiz_correction' => 'જમા કરો',
	'quiz_score' => 'તમારા ગુણ છે $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 પોઈન્ટ|$2 પોઈન્ટ}}',
	'quiz_reset' => 'ફરી ગોઠવો',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'quiz_desc' => 'אפשרות ליצירת חידונים',
	'quiz_addedPoints' => '{{PLURAL:$1|הנקודה שנוספת|הנקודות שנוספות}} עבור כל תשובה נכונה',
	'quiz_cutoffPoints' => '{{PLURAL:$1|הנקודה שמורדת|הנקודות שמורדות}} עבור כל תשובה שגויה',
	'quiz_ignoreCoef' => 'התעלמות ממקדמי שאלות',
	'quiz_shuffle' => 'סדר משתנה של השאלות',
	'quiz_colorRight' => 'נכון',
	'quiz_colorWrong' => 'שגוי',
	'quiz_colorNA' => 'לא סומנה תשובה',
	'quiz_colorError' => 'שגיאת תחביר',
	'quiz_correction' => 'שליחה',
	'quiz_score' => 'הניקוד שלך הוא $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|נקודה אחת|$2 נקודות}}',
	'quiz_reset' => 'איפוס',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'quiz_desc' => 'क्विज़ बनाने के लिये सहायता करता हैं',
	'quiz_addedPoints' => 'सही जवाब के लिये मार्क्स दिये',
	'quiz_cutoffPoints' => 'गलत जवाबके लिये मार्क्स घटाये',
	'quiz_ignoreCoef' => 'प्रश्नोंके कोएफिशिअंटको नजर अंदाज करें',
	'quiz_shuffle' => 'सवाल उपर नीचे करें',
	'quiz_colorRight' => 'सहीं',
	'quiz_colorWrong' => 'गलत',
	'quiz_colorNA' => 'जवाब दिया नहीं',
	'quiz_colorError' => 'सिन्टॅक्स गलती',
	'quiz_correction' => 'भेजें',
	'quiz_score' => 'आपके गुण $1 / $2',
	'quiz_points' => '$1 | $2 गुण',
	'quiz_reset' => 'पूर्ववत करें',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'quiz_desc' => 'Dozvoljava kreiranje kvizova',
	'quiz_addedPoints' => '{{PLURAL:$1|Bod|Bodovi}} za točan odgovor',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Bod|Bodovi}} za netočan odgovor',
	'quiz_ignoreCoef' => 'Ignoriraj težinske koeficijente pitanja',
	'quiz_shuffle' => 'Promiješaj pitanja',
	'quiz_colorRight' => 'Točno',
	'quiz_colorWrong' => 'Netočno',
	'quiz_colorNA' => 'Neodgovoreno',
	'quiz_colorError' => 'Sintaksna greška',
	'quiz_correction' => 'Ocijeni kviz',
	'quiz_score' => 'Vaš rezultat je $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 bod|$2 bodova}}',
	'quiz_reset' => 'Poništi kviz',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'quiz_desc' => 'Dowola wutworjenje kwisow',
	'quiz_addedPoints' => '{{PLURAL:$1|Plusdypk|Plusdypkaj|Plusdypki|Plusdypkow}} za prawu wotmołwu',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Minusdypk|Minusdypkaj|Minusdypki|Minusdypkow}} za wopačnu wotmołwu',
	'quiz_ignoreCoef' => 'Prašenske koeficienty ignorować',
	'quiz_shuffle' => 'Prašenja měšeć',
	'quiz_colorRight' => 'Prawje',
	'quiz_colorWrong' => 'Wopak',
	'quiz_colorNA' => 'Žana wotmołwa',
	'quiz_colorError' => 'Syntaksowy zmylk',
	'quiz_correction' => 'Korektura',
	'quiz_score' => 'Twój hrajny staw je: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 dypk|$2 dypkaj|$2 dypki|$2 dypkow}}',
	'quiz_reset' => 'Znowastartowanje',
);

/** Haitian (Kreyòl ayisyen)
 * @author Boukman
 * @author Jvm
 */
$messages['ht'] = array(
	'quiz_desc' => 'Pemèt Kreyasyon kwiz yo',
	'quiz_addedPoints' => '{{PLURAL:$1|Pwen|Pwen}} mete pou repons ki bon',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Pwen|Pwen}} retire pou repons ki pa bon',
	'quiz_ignoreCoef' => 'Inyore koefisyan kesyon yo',
	'quiz_shuffle' => 'Mikse kesyon yo',
	'quiz_colorRight' => 'Bon',
	'quiz_colorWrong' => 'Move',
	'quiz_colorNA' => 'San repons',
	'quiz_colorError' => 'Erè Sentaks',
	'quiz_correction' => 'Soumèt',
	'quiz_score' => 'Rezilta w se $1 / $2',
	'quiz_points' => '$1 | $2 pwen{{PLURAL:||}}',
	'quiz_reset' => 'Rekomanse',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 * @author Terik
 */
$messages['hu'] = array(
	'quiz_desc' => 'Lehetővé teszi kvízkérdések létrehozását',
	'quiz_addedPoints' => 'Helyesen válaszoltál, így {{PLURAL:$1|pontot|pontokat}} szereztél',
	'quiz_cutoffPoints' => 'Hibásan válaszoltál, így {{PLURAL:$1|pont lett|pontok lettek}} levonva',
	'quiz_ignoreCoef' => 'Ne vegye figyelembe a kérdések együtthatóit',
	'quiz_shuffle' => 'Kérdések összekeverése',
	'quiz_colorRight' => 'Jó',
	'quiz_colorWrong' => 'Rossz',
	'quiz_colorNA' => 'Nem válaszoltál',
	'quiz_colorError' => 'Szintaktikai hiba',
	'quiz_correction' => 'Elküldés',
	'quiz_score' => 'A pontszámod: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|egy|$2}} pont',
	'quiz_reset' => 'Újraindít',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'quiz_desc' => 'Permitte le creation de quizes',
	'quiz_addedPoints' => '{{PLURAL:$1|Puncto|Punctos}} addite pro cata responsa correcte',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Puncto|Punctos}} subtrahite pro cata responsa erronee',
	'quiz_ignoreCoef' => 'Ignorar le coefficientes del questiones',
	'quiz_shuffle' => 'Miscer questiones',
	'quiz_colorRight' => 'Juste',
	'quiz_colorWrong' => 'False',
	'quiz_colorNA' => 'Non respondite',
	'quiz_colorError' => 'Error de syntaxe',
	'quiz_correction' => 'Submitter',
	'quiz_score' => 'Punctos: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 puncto|$2 punctos}}',
	'quiz_reset' => 'Reinitialisar',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'quiz_desc' => 'Menyediakan fasilitas pembuatan kuis',
	'quiz_addedPoints' => 'Penambahan {{PLURAL:$1|angka|angka}} untuk jawaban yang tepat',
	'quiz_cutoffPoints' => 'Pengurangan {{PLURAL:$1|angka|angka}} untuk jawaban yang salah',
	'quiz_ignoreCoef' => 'Abaikan koefisien pertanyaan',
	'quiz_shuffle' => 'Mengacak pertanyaan',
	'quiz_colorRight' => 'Benar',
	'quiz_colorWrong' => 'Salah',
	'quiz_colorNA' => 'Tak dijawab',
	'quiz_colorError' => 'Kesalahan sintaks',
	'quiz_correction' => 'Kirim',
	'quiz_score' => 'Skor Anda adalah $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 poin|$2 poin}}',
	'quiz_reset' => 'Reset',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'quiz_desc' => 'Në nyé uzor I ké nlele akwúkwuó',
	'quiz_addedPoints' => '{{PLURAL:$1|Ogùgù Onyìnyé|Onú Ogùgù Onyìnyé}} a bálá màkà otu é shi a zá ajújú ofuma',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Ogùgù Onyìnyé|Onú Ogùgù Onyìnyé}} màkà otu é shi daá I zá ajújú ofuma',
	'quiz_ignoreCoef' => 'Á zàkwàlà nkwado ónú ogùgù bu nke ájújú ndiá',
	'quiz_shuffle' => 'gbàsá ájújú',
	'quiz_colorRight' => 'Ézíbóté',
	'quiz_colorWrong' => 'Í dạrạ ya',
	'quiz_colorNA' => 'O saghị',
	'quiz_colorError' => 'Édé nwèrè nsogbú',
	'quiz_correction' => 'Dànyé',
	'quiz_score' => 'Owu gi bu $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 ogùgù onyìnyé|$2 onú ogùgù onyìnyé}}',
	'quiz_reset' => 'Kuwaria',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'quiz_desc' => 'Agpalubos ti agramid kadagiti saludsod',
	'quiz_addedPoints' => '{{PLURAL:$1|Puntos|Pun-puntos}} ti mainayon iti pudno a sungbat',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Puntos|Pun-puntos}} para iti di umisu a sungbat',
	'quiz_ignoreCoef' => 'Saan nga ikaskaso dagiti coefficient ti salusod',
	'quiz_shuffle' => 'Yakar-akaren dagiti saludsod',
	'quiz_colorRight' => 'Umisu',
	'quiz_colorWrong' => 'Di umisu',
	'quiz_colorNA' => 'Saan a nasungbatan',
	'quiz_colorError' => 'Biddut ti gramatika',
	'quiz_correction' => 'Ited',
	'quiz_score' => 'Ti iskor mo ket $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 puntos|$2 pun-puntos}}',
	'quiz_reset' => 'Isubli',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'quiz_colorRight' => 'Justa',
	'quiz_colorWrong' => 'Nejusta',
	'quiz_score' => 'Vua nombro di punti esas $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punto|$2 punti}}',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'quiz_desc' => 'Heimilar gerð skyndiprófa',
	'quiz_addedPoints' => 'Stig fyrir rétt svar',
	'quiz_cutoffPoints' => 'Stig dregin frá fyrir rangt svar',
	'quiz_shuffle' => 'Stokka svörin',
	'quiz_colorRight' => 'Rétt',
	'quiz_colorWrong' => 'Röng',
	'quiz_colorNA' => 'Ósvarað',
	'quiz_colorError' => 'Málfræðivilla',
	'quiz_correction' => 'Senda',
	'quiz_score' => 'Stigafjöldinn þinn er $1 / $2',
	'quiz_points' => '$1 | $2 stig',
	'quiz_reset' => 'Endurstilla',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'quiz_desc' => 'Consente di creare dei quiz',
	'quiz_addedPoints' => '{{PLURAL:$1|Punto aggiunto|Punti aggiunti}} per ogni risposta corretta',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punto sottratto|Punti sottratti}} per ogni risposta errata',
	'quiz_ignoreCoef' => 'Ignora i coefficienti di domanda',
	'quiz_shuffle' => 'Mescola le domande',
	'quiz_colorRight' => 'Giusto',
	'quiz_colorWrong' => 'Sbagliato',
	'quiz_colorNA' => 'Nessuna risposta',
	'quiz_colorError' => 'Errore di sintassi',
	'quiz_correction' => 'Correggi',
	'quiz_score' => 'Il tuo punteggio è $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punto|$2 punti}}',
	'quiz_reset' => 'Reimposta',
);

/** Japanese (日本語)
 * @author Aotake
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'quiz_desc' => 'クイズの作成を可能にする',
	'quiz_addedPoints' => '正解により$1{{PLURAL:$1|点}}追加',
	'quiz_cutoffPoints' => '不正解に$1{{PLURAL:$1|点}}',
	'quiz_ignoreCoef' => '問題ごとの倍率を無視する',
	'quiz_shuffle' => '問題をシャッフル',
	'quiz_colorRight' => '正解',
	'quiz_colorWrong' => '不正解',
	'quiz_colorNA' => '無回答',
	'quiz_colorError' => '構文エラー',
	'quiz_correction' => '採点',
	'quiz_score' => '得点：$1点($2点満点)',
	'quiz_points' => '$1 | $2{{PLURAL:$2|点}}',
	'quiz_reset' => 'リセット',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'quiz_desc' => 'Gæv kreåsje der kwesser æ mågleghed',
	'quiz_addedPoints' => 'Punkt(er) tilføjer før æ korrekt answer',
	'quiz_cutoffPoints' => 'Punkt(er) subtraktet før æ fejl answer',
	'quiz_ignoreCoef' => 'Ignorær æ fråge han koeffisienter',
	'quiz_shuffle' => 'Skuffel fråge',
	'quiz_colorRight' => 'Gåd',
	'quiz_colorWrong' => 'Fejl',
	'quiz_colorNA' => 'Ekke answered',
	'quiz_colorError' => 'Syntaks fejl',
	'quiz_correction' => 'Gå',
	'quiz_score' => 'Diin skår er $1 / $2',
	'quiz_points' => '$1 | $2 punkt(er)',
	'quiz_reset' => 'Reset',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'quiz_desc' => 'Nyedyakaké fasilitas nggawé kuis',
	'quiz_addedPoints' => 'Panambahan {{PLURAL:$1|angka|angka}} kanggo wangsulan sing bener',
	'quiz_cutoffPoints' => 'Pangurangan {{PLURAL:$1|angka|angka}} kanggo wangsulan sing salah',
	'quiz_ignoreCoef' => 'Lirwakna koéfisièn pitakonan',
	'quiz_shuffle' => 'Ngacak pitakonan',
	'quiz_colorRight' => 'Bener',
	'quiz_colorWrong' => 'Salah',
	'quiz_colorNA' => 'Ora diwangsuli',
	'quiz_colorError' => "Kaluputan sintaksis (''syntax error'')",
	'quiz_correction' => 'Kirim',
	'quiz_score' => 'Skor biji panjenengan iku $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 poin|$2 poin}}',
	'quiz_reset' => 'Reset',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 * @author ITshnik
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'quiz_cutoffPoints' => '(($1 ქულა)) ერთი არასწორი პასუხისთვის',
	'quiz_shuffle' => 'კითხვების არევა',
	'quiz_colorRight' => 'სწორი',
	'quiz_colorWrong' => 'არასწორი',
	'quiz_colorNA' => 'პასუხი არ არის',
	'quiz_colorError' => 'სინტაქსური შეცდომა',
	'quiz_correction' => 'გაგზავნა',
	'quiz_score' => 'თქვენ შეაგროვეთ $1 {{PLURAL:$1|ქულა|ქულები}} $2-დან',
	'quiz_points' => '$1 | $2 ქულა',
	'quiz_reset' => 'გაუქმება',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'quiz_desc' => 'អនុញ្ញាតឱ្យបង្កើតចំណោទសួរ',
	'quiz_addedPoints' => '{{PLURAL:$1|ពិន្ទុ|ពិន្ទុ}}$1 ត្រូវបានបូកចូលចំពោះចម្លើយត្រឹមត្រូវ',
	'quiz_cutoffPoints' => '{{PLURAL:$1|ពិន្ទុ|ពិន្ទុ}} $1 ត្រូវបានដកចេញចំពោះចម្លើយខុស',
	'quiz_ignoreCoef' => 'មិនខ្វល់ពី​មេគុណ​នៃ​សំណួរ',
	'quiz_shuffle' => 'សាប់សំណួរ',
	'quiz_colorRight' => 'ត្រូវ',
	'quiz_colorWrong' => 'ខុស',
	'quiz_colorNA' => 'មិនបានឆ្លើយ',
	'quiz_colorError' => 'កំហុសពាក្យសម័្ពន្ធ',
	'quiz_correction' => 'ដាក់ស្នើ',
	'quiz_score' => 'តារាងពិន្ទុរបស់អ្នកគឺ  $1/$2',
	'quiz_points' => '$1 | {{PLURAL:$2|១ពិន្ទុ|$2ពិន្ទុ}}',
	'quiz_reset' => 'ធ្វើឱ្យដូចដើមវិញ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'quiz_colorRight' => 'ಸರಿ',
	'quiz_colorWrong' => 'ತಪ್ಪು',
);

/** Korean (한국어)
 * @author Ilovesabbath
 * @author Kwj2772
 * @author ToePeu
 * @author Yknok29
 */
$messages['ko'] = array(
	'quiz_desc' => '퀴즈를 만들 수 있도록 해줍니다',
	'quiz_addedPoints' => '$1점이 정답으로 추가되었습니다.',
	'quiz_cutoffPoints' => '틀린 답마다 $1점 감점',
	'quiz_ignoreCoef' => '문제의 배점 무시',
	'quiz_shuffle' => '문제 섞기',
	'quiz_colorRight' => '정답',
	'quiz_colorWrong' => '오답',
	'quiz_colorNA' => '무응답',
	'quiz_colorError' => '문법 오류',
	'quiz_correction' => '제출',
	'quiz_score' => '당신의 점수는 $1 / $2입니다.',
	'quiz_points' => '$1 | {{PLURAL:$2|1점|$2점}}',
	'quiz_reset' => '초기화',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'quiz_desc' => 'Mäht et müjjelesch, em Wiki e Quiß opzesäze',
	'quiz_addedPoints' => '{{PLURAL:$1|Punk, dä|Punkte, di|Püngkscher, di}} för en reschtijje Antwoot dobeijezallt {{PLURAL:$1|weed|wäde|weede}}',
	'quiz_cutoffPoints' => "{{PLURAL:$1|Punk, dä|Punkte, di|Püngkscher, di}} för en fo'keehte Antwoot affjetroke {{PLURAL:$1|weed|wäde|weede}}",
	'quiz_ignoreCoef' => 'Donn de einzel Jeweschte fun de Froore nit zälle',
	'quiz_shuffle' => 'Frore neu mesche',
	'quiz_colorRight' => 'Reschtesch',
	'quiz_colorWrong' => "Fo'keeht",
	'quiz_colorNA' => 'Kei Antwoot',
	'quiz_colorError' => 'Fääler en de Syntax',
	'quiz_correction' => 'Verbessere!',
	'quiz_score' => 'Do häs zesamme {{PLURAL:$1|eine Punk|$1 Punkte|keine Punk}} {{PLURAL:$2|fun einem müjjelesche Punk jemaat|fun müjjelesche $2 Punke jemaat|Punk jemaat, et wohr ävver och nix ze holle do}}.',
	'quiz_points' => '$1 | {{PLURAL:$2|1 Punk|$2 Punkte|Nix}}',
	'quiz_reset' => 'Neu Aanfange!',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'quiz_colorRight' => 'Rast',
	'quiz_colorWrong' => 'Nerast',
	'quiz_correction' => 'Tomar bike',
	'quiz_score' => 'Skora te  $1 / $2 e',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'quiz_desc' => 'Erméiglecht et Quizzer ze maachen',
	'quiz_addedPoints' => '{{PLURAL:$1|Punkt|Punkten}} derbäi fir eng richteg Äntwert',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punkt|Punkten}} ofgezunn fir eng falsch Äntwert',
	'quiz_ignoreCoef' => 'Koeffizient vun der Fro ignoréieren',
	'quiz_shuffle' => 'Froe meschen',
	'quiz_colorRight' => 'Richteg',
	'quiz_colorWrong' => 'Falsch',
	'quiz_colorNA' => 'Net beäntwert',
	'quiz_colorError' => 'Syntaxfeeler',
	'quiz_correction' => 'Verbesserung',
	'quiz_score' => 'Punkten: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 Punkt|$2 Punkten}}',
	'quiz_reset' => 'Zrécksetzen',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'quiz_desc' => "Maak 't aanmake van tes meugelik",
	'quiz_addedPoints' => "{{PLURAL:$1|Pöntj|Pöntjer}} toegevoeg veur 'n good antjwaord",
	'quiz_cutoffPoints' => "{{PLURAL:$1|Pöntj|Pöntjer}} aafgetróg veur 'n fout antjwaord",
	'quiz_ignoreCoef' => 'De coëfficiente van de vräög negere',
	'quiz_shuffle' => 'De vräög in willekäörige volgorde',
	'quiz_colorRight' => 'Ramkrèk',
	'quiz_colorWrong' => 'Verkièrd',
	'quiz_colorNA' => 'Neet beantjwaord',
	'quiz_colorError' => 'Algemeine fout',
	'quiz_correction' => 'Verbaetering',
	'quiz_score' => 'Dien score is $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 puntj|$2 puntje}}',
	'quiz_reset' => 'Oppernuuj',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'quiz_desc' => 'Leidžia kurti klausimynus',
	'quiz_addedPoints' => '{{PLURAL:$1|Taškas|Taškai}} {{PLURAL:$1|pridėtas|pridėti}} už teisingą atsakymą',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Taškas|Taškai}} {{PLURAL:$1|atimtas|atimti}} už neteisingą atsakymą',
	'quiz_ignoreCoef' => 'Nepaisyti klausimų koeficientų',
	'quiz_shuffle' => 'Maišyti klausimus',
	'quiz_colorRight' => 'Teisingai',
	'quiz_colorWrong' => 'Neteisingai',
	'quiz_colorNA' => 'Neatsakyta',
	'quiz_colorError' => 'Sintaksės klaida',
	'quiz_correction' => 'Pateikti',
	'quiz_score' => 'Jūsų surinkti taškai yra $1 iš $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 taškas|$2 taškai}}',
	'quiz_reset' => 'Valyti',
);

/** Latvian (Latviešu)
 * @author Dark Eagle
 * @author Xil
 * @author Yyy
 */
$messages['lv'] = array(
	'quiz_desc' => 'Ļauj veidot anketas',
	'quiz_addedPoints' => '{{PLURAL:$1|Punkts|Punkti}} par pareizu atbildi',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punkts|Punkti}}, kas tiek atņemti par nepareizu atbildi',
	'quiz_ignoreCoef' => 'Neņemt vērā jautājumu koeficientus',
	'quiz_shuffle' => 'Sajaukt jautājumus',
	'quiz_colorRight' => 'Pareizi',
	'quiz_colorWrong' => 'Nepareizi',
	'quiz_colorNA' => 'Nav atbildēts',
	'quiz_colorError' => 'Sintakses kļūda',
	'quiz_correction' => 'Sūtīt',
	'quiz_score' => 'Tavs rezultāts ir $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punkts|$2 punkti}}',
	'quiz_reset' => 'Notīrīt',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'quiz_desc' => 'Овозможува создавање на квизови',
	'quiz_addedPoints' => 'добивате {{PLURAL:$1|бод|бода}} за точен одговор',
	'quiz_cutoffPoints' => '{{PLURAL:$1|бод|бода}} за погрешен одговор',
	'quiz_ignoreCoef' => 'Занемари ги коефициентите на прашањата',
	'quiz_shuffle' => 'Измешај ги прашањата',
	'quiz_colorRight' => 'Точно',
	'quiz_colorWrong' => 'Погрешно',
	'quiz_colorNA' => 'Неодговорено',
	'quiz_colorError' => 'синтаксна грешка',
	'quiz_correction' => 'Поднеси',
	'quiz_score' => 'Вашето бодовно салдо изнесува $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 бод|$2 бода}}',
	'quiz_reset' => 'Врати одново',
);

/** Malayalam (മലയാളം)
 * @author Jacob.jose
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'quiz_desc' => 'ക്വിസുകൾ സൃഷ്ടിക്കാൻ സഹായിക്കുന്നു',
	'quiz_addedPoints' => 'ശരിയുത്തരത്തിനു {{PLURAL:$1|പോയിന്റ്|പോയിന്റുകൾ}} ചേർത്തു',
	'quiz_cutoffPoints' => 'തെറ്റായ ഉത്തരത്തിനു {{PLURAL:$1|പോയിന്റ്|പോയിന്റുകൾ}} കുറച്ചു',
	'quiz_shuffle' => 'ചോദ്യങ്ങൾ കശക്കുക',
	'quiz_colorRight' => 'ശരി',
	'quiz_colorWrong' => 'തെറ്റ്',
	'quiz_colorNA' => 'ഉത്തരം നൽകിയിട്ടില്ല',
	'quiz_colorError' => 'സിന്റാക്സ് പിഴവ്',
	'quiz_correction' => 'സമർപ്പിക്കുക',
	'quiz_score' => 'താങ്കളുടെ സ്കോർ $1/$2',
	'quiz_points' => '$1|{{PLURAL:$2|ഒരു പോയിന്റ്|$2 പോയിന്റുകൾ}}',
	'quiz_reset' => 'പുനഃക്രമീകരിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'quiz_correction' => 'Явуулах',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaajawa
 * @author Kaustubh
 */
$messages['mr'] = array(
	'quiz_desc' => 'प्रश्नावल्या तयार करण्याची परवानगी देते.',
	'quiz_addedPoints' => 'बरोबर उत्तरासाठी गुण {{PLURAL:$1|दिला|दिले}}',
	'quiz_cutoffPoints' => 'चुकीच्या उत्तरासाठी {{PLURAL:$1|गुण|गुण}} वजा',
	'quiz_ignoreCoef' => 'प्रश्नाच्या कोएफिशियंटकडे लक्ष देऊ नका',
	'quiz_shuffle' => 'प्रश्न वरखाली करा',
	'quiz_colorRight' => 'बरोबर',
	'quiz_colorWrong' => 'चूक',
	'quiz_colorNA' => 'उत्तर दिलेले नाही',
	'quiz_colorError' => 'चुकीचा सिन्टॅक्स',
	'quiz_correction' => 'पाठवा',
	'quiz_score' => 'तुमचे गुण $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|१ गुण|$2 गुण}}',
	'quiz_reset' => 'पूर्ववत करा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'quiz_desc' => 'Membolehkan penciptaan kuiz',
	'quiz_addedPoints' => '$1 mata ditambah untuk jawapan salah',
	'quiz_cutoffPoints' => '$1 mata ditolak untuk jawapan salah',
	'quiz_ignoreCoef' => 'Abaikan pekali soalan',
	'quiz_shuffle' => 'Papar soalan',
	'quiz_colorRight' => 'Betul',
	'quiz_colorWrong' => 'Salah',
	'quiz_colorNA' => 'Tidak dijawab',
	'quiz_colorError' => 'Ralat sintaks',
	'quiz_correction' => 'Serahkan',
	'quiz_score' => 'Anda mendapat $1 daripada $2 mata',
	'quiz_points' => '$1 | $2 mata',
	'quiz_reset' => 'Set semula',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'quiz_score' => "L-iskor tiegħek hu ta' $1 / $2",
	'quiz_reset' => 'Irrisettja',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'quiz_colorRight' => 'Виде',
	'quiz_colorWrong' => 'А виде',
	'quiz_colorNA' => 'Апак пандо',
	'quiz_correction' => 'Максомс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'quiz_correction' => 'Tiquihuāz',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'quiz_desc' => 'Tillater oppretting av quizer',
	'quiz_addedPoints' => '{{PLURAL:$1|Plusspoeng}} for korrekt svar',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Minuspoeng}} for galt svar',
	'quiz_ignoreCoef' => 'Ignorer spørsmålets verdier',
	'quiz_shuffle' => 'Stokk spørsmålene',
	'quiz_colorRight' => 'Riktig',
	'quiz_colorWrong' => 'Galt',
	'quiz_colorNA' => 'Ikke besvart',
	'quiz_colorError' => 'Syntaksfeil',
	'quiz_correction' => 'Svar',
	'quiz_score' => 'Din poengsum er $1 av $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 poeng|$2 poeng}}',
	'quiz_reset' => 'Nullstill',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'quiz_desc' => 'Verlööft dat Opstellen vun Quizspelen',
	'quiz_addedPoints' => '{{PLURAL:$1|Punkt|Punkten}} för richtige Antwoord',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Minuspunkt|Minuspunkten}} för verkehrte Antwoord',
	'quiz_ignoreCoef' => 'op Fragen-Koeffizienten nix op geven',
	'quiz_shuffle' => 'Fragen mischen',
	'quiz_colorRight' => 'Stimmt',
	'quiz_colorWrong' => 'Verkehrt',
	'quiz_colorNA' => 'Nich antert',
	'quiz_colorError' => 'Syntaxfehler',
	'quiz_correction' => 'Korrektur',
	'quiz_score' => 'Punkten: $1 / $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|Punkt|Punkten}}',
	'quiz_reset' => 'Trüchsetten',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'quiz_desc' => 'Maakt het aanmaken van tests mogelijk',
	'quiz_addedPoints' => '{{PLURAL:$1|Punt|Punten}} toegevoegd voor een goed antwoord',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punt|Punten}} afgetrokken voor een fout antwoord',
	'quiz_ignoreCoef' => 'De coëfficienten van de vragen negeren',
	'quiz_shuffle' => 'De vragen in willekeurige volgorde',
	'quiz_colorRight' => 'Goed',
	'quiz_colorWrong' => 'Fout',
	'quiz_colorNA' => 'Niet beantwoord',
	'quiz_colorError' => 'Algemene fout',
	'quiz_correction' => 'Antwoord opslaan',
	'quiz_score' => 'Uw score is $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punt|$2 punten}}',
	'quiz_reset' => 'Herstellen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Harald Khan
 */
$messages['nn'] = array(
	'quiz_desc' => 'Gjer oppretting av spørjekonkurransar mogleg',
	'quiz_addedPoints' => 'Plusspoeng for rett svar',
	'quiz_cutoffPoints' => 'Minuspoeng for feil svar',
	'quiz_ignoreCoef' => 'Oversjå verdiane på spørsmåla',
	'quiz_shuffle' => 'Stokk om på spørsmåla',
	'quiz_colorRight' => 'Rett',
	'quiz_colorWrong' => 'Feil',
	'quiz_colorNA' => 'Ikkje svara på',
	'quiz_colorError' => 'Syntaksfeil',
	'quiz_correction' => 'Svar',
	'quiz_score' => 'Poengsummen din er $1 av $2 moglege',
	'quiz_points' => '$1 | {{PLURAL:$2|eitt poeng|$2 poeng}}',
	'quiz_reset' => 'Nullstill',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'quiz_desc' => 'Permet la creacion dels Quiz',
	'quiz_addedPoints' => '{{PLURAL:$1|Punt apondut|Punts aponduts}} per una responsa corrècta',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punt levat|Punts levats}} per una responsa erronèa',
	'quiz_ignoreCoef' => 'Ignorar los coeficients de las questions',
	'quiz_shuffle' => 'Mesclar las questions',
	'quiz_colorRight' => 'Just',
	'quiz_colorWrong' => 'Fals',
	'quiz_colorNA' => 'Pas respondut',
	'quiz_colorError' => 'Error de sintaxi',
	'quiz_correction' => 'Correccion',
	'quiz_score' => 'Vòstra marca es $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punt|$2 punts}}',
	'quiz_reset' => 'Reïnicializar',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'quiz_desc' => 'ପ୍ରଶ୍ନୋତ୍ତର ତିଆରି କରିବାରେ ସହଯୋଗ କରିଥାଏ ।',
	'quiz_addedPoints' => 'ଠିକ ଉତ୍ତର ନିମନ୍ତେ {{PLURAL:$1|ଗୋଟି ପଏଣ୍ଟ|ଗୋଟି ପଏଣ୍ଟ}} ଯୋଡ଼ାଗଲା',
	'quiz_cutoffPoints' => 'ଭୁଲ ଉତ୍ତର ନିମନ୍ତେ {{PLURAL:$1|ଗୋଟିଏ ପଏଣ୍ଟ|ଗୋଟି ପଏଣ୍ଟ}}',
	'quiz_ignoreCoef' => 'ପ୍ରଶ୍ନର ଗୁଣାଙ୍କସବୁକୁ ଅଣଦେଖା କରନ୍ତୁ',
	'quiz_shuffle' => 'ପ୍ରଶ୍ନ ସବୁକୁ ଗୋଳାଇଘାଣ୍ଟି ଦିଅନ୍ତୁ',
	'quiz_colorRight' => 'ଠିକ',
	'quiz_colorWrong' => 'ଭୁଲ',
	'quiz_colorNA' => 'ଉତ୍ତର ଦିଆଯାଇନାହିଁ',
	'quiz_colorError' => 'ସିଣ୍ଟାକ୍ସ ଭୁଲ',
	'quiz_correction' => 'ଦାଖଲ କରିବା',
	'quiz_score' => 'ଆପଣଙ୍କର ସ୍କୋର $1 / $2 ହେଲା',
	'quiz_points' => '$1 | {{PLURAL:$2|ଗୋଟିଏ ପଏଣ୍ଟ|$2 ଗୋଟି ପଏଣ୍ଟ}}',
	'quiz_reset' => 'ପୁନସ୍ଥାପନ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'quiz_colorRight' => 'Раст',
	'quiz_colorWrong' => 'Рæдыд',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'quiz_colorWrong' => 'Letz',
	'quiz_colorNA' => 'Kene Antwatt gewwe',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'quiz_desc' => 'Umożliwia tworzenie quizów',
	'quiz_addedPoints' => '{{PLURAL:$1|Punkt dodawany|Punkty dodawane|Punktów dodawanych}} za właściwą odpowiedź',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punkt odejmowany|Punkty odejmowane|Punktów odejmowanych}} za niewłaściwą odpowiedź',
	'quiz_ignoreCoef' => 'Ignoruj punktację pytań',
	'quiz_shuffle' => 'Losuj kolejność pytań',
	'quiz_colorRight' => 'Właściwa',
	'quiz_colorWrong' => 'Niewłaściwa',
	'quiz_colorNA' => 'Brak odpowiedzi',
	'quiz_colorError' => 'Błąd składni',
	'quiz_correction' => 'Wyślij',
	'quiz_score' => 'Twoje punty to $1 na możliwych $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punkt|$2 punkty|$2 punktów}}',
	'quiz_reset' => 'Wyzeruj',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'quiz_desc' => 'A përmëtt la creassion ëd quiz',
	'quiz_addedPoints' => "{{PLURAL:$1|Pont|Pont}} da dé për n'aspòsta giusta",
	'quiz_cutoffPoints' => "{{PLURAL:$1|Pont|Pont}} da gavé për n'aspòsta pa giusta",
	'quiz_ignoreCoef' => 'Pa dovré ij coeficent dle domande',
	'quiz_shuffle' => 'Mës-cé le domande',
	'quiz_colorRight' => 'Giust',
	'quiz_colorWrong' => 'Pa giust',
	'quiz_colorNA' => "Anco' nen d'arspòsta",
	'quiz_colorError' => 'Eror ëd sintassi',
	'quiz_correction' => 'Manda',
	'quiz_score' => "A l'ha pijait $1 pont ansima a $2",
	'quiz_points' => '$1 | {{PLURAL:$2|1 pont|$2 pont}}',
	'quiz_reset' => 'Aseré',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'quiz_desc' => 'کوئز دے بنن دی اجازت',
	'quiz_addedPoints' => '{{انیک:$1|نمبر}} جوڑے گۓ ٹھیک جواب لئی۔',
	'quiz_cutoffPoints' => 'غلط جواب لئی {{انیک:$1|پوائینٹ|پوائینٹ}}',
	'quiz_ignoreCoef' => 'سوال دے کوایفیشینٹو نوں چھڈو',
	'quiz_shuffle' => 'سوال رلاؤ',
	'quiz_colorRight' => 'ٹھیک۔ سجے پاسے',
	'quiz_colorWrong' => 'غلط',
	'quiz_colorNA' => 'جواب نئیں دتا گیا۔',
	'quiz_colorError' => 'بولی دی غلطی',
	'quiz_correction' => 'اگے رکھو',
	'quiz_score' => 'تواڈا سکور اے $1 / $2',
	'quiz_points' => '$1 | {{انیک:$2|1 پوائینٹ|$2 پوائینٹ}}',
	'quiz_reset' => 'دوبارہ ٹھیک کرنا',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'quiz_shuffle' => 'پوښتنې ګډوډول',
	'quiz_colorRight' => 'سم',
	'quiz_colorWrong' => 'ناسم',
	'quiz_colorNA' => 'بې ځوابه',
	'quiz_correction' => 'سپارل',
	'quiz_score' => 'ستاسې نومرې $1 / $2 دي',
	'quiz_points' => '$1 | {{PLURAL:$2|1 نمره|$2 نمرې}}',
	'quiz_reset' => 'بياايښودل',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 */
$messages['pt'] = array(
	'quiz_desc' => 'Permite a criação de questionários',
	'quiz_addedPoints' => '{{PLURAL:$1|Ponto adicionado|Pontos adicionados}} por cada resposta certa',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Ponto subtraído|Pontos subtraídos}} por cada resposta errada',
	'quiz_ignoreCoef' => 'Ignorar os coeficientes das questões',
	'quiz_shuffle' => 'Baralhar as questões',
	'quiz_colorRight' => 'Correctas',
	'quiz_colorWrong' => 'Erradas',
	'quiz_colorNA' => 'Não respondidas',
	'quiz_colorError' => 'Erro de sintaxe',
	'quiz_correction' => 'Enviar',
	'quiz_score' => 'Pontuação actual: $1 certas em $2',
	'quiz_points' => '$1 | {{PLURAL:$2|um ponto|$2 pontos}}',
	'quiz_reset' => 'Repor a zero',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'quiz_desc' => 'Permite a criação de questionários',
	'quiz_addedPoints' => '{{PLURAL:$1|Ponto adicionado|Pontos adicionados}} por cada resposta certa',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Ponto subtraído|Pontos subtraídos}} por cada resposta errada',
	'quiz_ignoreCoef' => 'Ignorar os coeficientes das questões',
	'quiz_shuffle' => 'Embaralhar as questões',
	'quiz_colorRight' => 'Corretas',
	'quiz_colorWrong' => 'Erradas',
	'quiz_colorNA' => 'Não respondidas',
	'quiz_colorError' => 'Erro de sintaxe',
	'quiz_correction' => 'Enviar',
	'quiz_score' => 'Pontuação atual: $1 certas em $2',
	'quiz_points' => '$1 | {{PLURAL:$2|um ponto|$2 pontos}}',
	'quiz_reset' => 'Reiniciar',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'quiz_desc' => 'Watuchi pukllay kamariyta saqillan',
	'quiz_addedPoints' => 'Allin kutichisqapaq {{PLURAL:$1|iñu|iñukuna}} yapasqa',
	'quiz_cutoffPoints' => 'Panta kutichisqapaq {{PLURAL:$1|iñu|iñukuna}} qichusqa',
	'quiz_ignoreCoef' => 'Sapa tapuypaq iñukunata qhawarpariy',
	'quiz_shuffle' => 'Tapuykunata arwiy',
	'quiz_colorRight' => 'Allin',
	'quiz_colorWrong' => 'Panta',
	'quiz_colorNA' => 'Mana kutichisqa',
	'quiz_colorError' => 'Sintaksis pantasqa',
	'quiz_correction' => 'Kachay',
	'quiz_score' => 'Taripasqaykikunaqa kay hinam: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$1|huk iñu|$2 iñukuna}}',
	'quiz_reset' => 'Musuqmanta qallariy',
);

/** Romanian (Română)
 * @author Cin
 * @author Firilacroco
 * @author Mihai
 * @author Minisarm
 */
$messages['ro'] = array(
	'quiz_desc' => 'Permite crearea de chestionare',
	'quiz_addedPoints' => '{{PLURAL:$1|Punct adăugat|Puncte adăugate}} pentru un răspuns corect',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Punct scăzut|Puncte scăzute}} pentru un răspuns greșit',
	'quiz_ignoreCoef' => 'Ignoră coeficienții întrebărilor',
	'quiz_shuffle' => 'Întrebări amestecate',
	'quiz_colorRight' => 'Corect',
	'quiz_colorWrong' => 'Greșit',
	'quiz_colorNA' => 'Fără răspuns',
	'quiz_colorError' => 'Eroare de sintaxă',
	'quiz_correction' => 'Trimitere',
	'quiz_score' => 'Scorul tău este $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 punct|$2 puncte}}',
	'quiz_reset' => 'Reinițializare',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'quiz_desc' => 'Permette de ccrejà le quiz',
	'quiz_addedPoints' => "{{PLURAL:$1|Punde|Punde}} aggiunde pe 'na resposta corrette",
	'quiz_cutoffPoints' => "{{PLURAL:$1|Punde|Punde}} pe 'na resposta sbagliate",
	'quiz_ignoreCoef' => 'No scè penzanne a le coefficiende de le domande',
	'quiz_shuffle' => 'Miscke le domande',
	'quiz_colorRight' => 'Esatte',
	'quiz_colorWrong' => 'Sbagliete',
	'quiz_colorNA' => 'Nò resposte',
	'quiz_colorError' => 'Errore de sindasse',
	'quiz_correction' => 'Conferme',
	'quiz_score' => "'U pundegge tue ète $1 / $2",
	'quiz_points' => '$1 | {{PLURAL:$2|1 punde|$2 punde}}',
	'quiz_reset' => 'Azzera',
);

/** Russian (Русский)
 * @author Aleksandrit
 * @author EugeneZelenko
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'quiz_desc' => 'Позволяет создавать вопросники',
	'quiz_addedPoints' => '{{PLURAL:$1|очко|очков}} добавлено за правильный ответ',
	'quiz_cutoffPoints' => '{{PLURAL:$1|очко|очков}} вычтено за неправильный ответ',
	'quiz_ignoreCoef' => 'Пренебрегать коэффициентами вопросов',
	'quiz_shuffle' => 'Перемешать вопросы',
	'quiz_colorRight' => 'Правильно',
	'quiz_colorWrong' => 'Ошибка',
	'quiz_colorNA' => 'Нет ответа',
	'quiz_colorError' => 'Синтаксическая ошибка',
	'quiz_correction' => 'Отправить',
	'quiz_score' => 'Вы набрали $1 {{PLURAL:$1|очко|очка|очков}} из $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|очко|очка|очков}}',
	'quiz_reset' => 'Сбросить',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'quiz_desc' => 'Уможнює створёвати квізы',
	'quiz_addedPoints' => '{{PLURAL:$1|Очко придане|Очка приданы}} за правилну одповідь',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Очко одняте|Очка одняты}} за неправилну одповідь',
	'quiz_ignoreCoef' => 'Іґноровати коефіціенты вопросів',
	'quiz_shuffle' => 'Замішати вопросы',
	'quiz_colorRight' => 'Правилно',
	'quiz_colorWrong' => 'Неправилно',
	'quiz_colorNA' => 'Неодповіджене',
	'quiz_colorError' => 'Сінтаксічна хыба',
	'quiz_correction' => 'Одослати',
	'quiz_score' => 'Ваш резултат є $1 / $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|очко|очка|очок}}',
	'quiz_reset' => 'Ресетовати',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'quiz_desc' => 'Вопросниктары оҥорор кыаҕы биэрэр',
	'quiz_addedPoints' => '$1 очкуо сөп эппиэт иһин эбилиннэ',
	'quiz_cutoffPoints' => '$1 очкуо сыыһа эппиэт иһин көҕүрэтилиннэ',
	'quiz_ignoreCoef' => 'Ыйытыылар коэффициеннарын аахсыма',
	'quiz_shuffle' => 'Ыйытыылары булкуй',
	'quiz_colorRight' => 'Сөп',
	'quiz_colorWrong' => 'Сыыһа',
	'quiz_colorNA' => 'Эппиэт суох',
	'quiz_colorError' => 'Синтаксическай алҕас',
	'quiz_correction' => 'Ыыт',
	'quiz_score' => '$2 очкуоттан $1 очкуону ыллыҥ',
	'quiz_points' => '$1 | {{PLURAL:$2|1 очкуо|$2 очкуо}}',
	'quiz_reset' => 'Саҥаттан',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'quiz_colorRight' => 'Giustu',
	'quiz_colorWrong' => 'Sbajjàtu',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'quiz_correction' => 'Unesi',
);

/** Sinhala (සිංහල)
 * @author Budhajeewa
 * @author Singhalawap
 * @author තඹරු විජේසේකර
 * @author බිඟුවා
 */
$messages['si'] = array(
	'quiz_desc' => 'ප්‍රශ්න විමසුම් නිර්මාණයට අවසර දෙයි',
	'quiz_addedPoints' => 'නිවැරදි පිළිතුර සඳහා ලැබෙන {{PLURAL:$1|ලකුණ|ලකුණු}}',
	'quiz_cutoffPoints' => 'වැරදි පිළිතුර සඳහා ලැබෙන {{PLURAL:$1|ලකුණ|ලකුණු}}',
	'quiz_ignoreCoef' => 'ප්‍රශ්නවල සංගුණක නොසලකන්න',
	'quiz_shuffle' => 'ප්‍රශ්න අනුපිළිවෙල වෙනස් කරන්න',
	'quiz_colorRight' => 'නිවැරදි',
	'quiz_colorWrong' => 'වැරදි',
	'quiz_colorNA' => 'පිළිතුරුදී නැත',
	'quiz_colorError' => 'කාරක-රීති දෝෂය',
	'quiz_correction' => 'යොමන්න',
	'quiz_score' => 'ඔබේ ලකුණ $1 / $2 ය',
	'quiz_points' => '$1 | {{PLURAL:$2|එක් ලකුණක්|ලකුණු $2 ක්}}',
	'quiz_reset' => 'නැවත සකසන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'quiz_desc' => 'Umožňuje tvorbu kvízov',
	'quiz_addedPoints' => '{{PLURAL:$1|Bod pričítaný|Body pričítané}} za správnu odpoveď',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Bod odčítaný|Body odčítané}} za nesprávnu odpoveď',
	'quiz_ignoreCoef' => 'Ignorovať koeficienty otázok',
	'quiz_shuffle' => 'Náhodný výber otázok',
	'quiz_colorRight' => 'Správne',
	'quiz_colorWrong' => 'Nesprávne',
	'quiz_colorNA' => 'Nezodpovedané',
	'quiz_colorError' => 'Syntaktická chyba',
	'quiz_correction' => 'Oprava',
	'quiz_score' => 'Vaše skóre je $1 / $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|bod|body|bodov}}',
	'quiz_reset' => 'Reset',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'quiz_desc' => 'Omogoča ustvarjanje kvizov',
	'quiz_addedPoints' => '{{PLURAL:$1|Točka dodana|Točki dodani|Točke dodane}} za pravilen odgovor',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Točka odbita|Točki odbiti|Točke odbite}} za napačen odgovor',
	'quiz_ignoreCoef' => 'Prezri koeficiente vprašanj',
	'quiz_shuffle' => 'Premešaj vprašanja',
	'quiz_colorRight' => 'Pravilno',
	'quiz_colorWrong' => 'Napačno',
	'quiz_colorNA' => 'Ni odgovorjeno',
	'quiz_colorError' => 'Skladenjska napaka',
	'quiz_correction' => 'Pošlji',
	'quiz_score' => 'Vaš rezultat je $1 / $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|točka|točki|točke|točk}}',
	'quiz_reset' => 'Ponastavi',
);

/** Albanian (Shqip)
 * @author Cradel
 * @author Ergon
 * @author Mikullovci11
 * @author Olsi
 */
$messages['sq'] = array(
	'quiz_desc' => 'Lejon krijimin e enigmave',
	'quiz_addedPoints' => '{{PLURAL:$1|Pika|Pikët}} shtuar për një përgjigje të saktë',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Pika|Pikët}} për një përgjigje të gabuar',
	'quiz_ignoreCoef' => 'Injoro koificientin e pyetjes',
	'quiz_shuffle' => 'Përziej pyetjet',
	'quiz_colorRight' => 'Korrekt',
	'quiz_colorWrong' => 'Gabim',
	'quiz_colorNA' => "S'ka përgjigje",
	'quiz_colorError' => 'Gabim sintakse',
	'quiz_correction' => 'Dërgo',
	'quiz_score' => 'Rezultati juaj është $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 pikë|$2 pikë}}',
	'quiz_reset' => 'Riktheje',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'quiz_desc' => 'Омогућава стварање квизова',
	'quiz_addedPoints' => '{{PLURAL:$1|бод|бода|бодова}} се додаје на тачан одговор',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Бод|Бода|Бодова}} за погрешан одговор',
	'quiz_ignoreCoef' => 'Игнориши коефицијенте питања',
	'quiz_shuffle' => 'Измешај питања',
	'quiz_colorRight' => 'Тачно',
	'quiz_colorWrong' => 'Погрешно',
	'quiz_colorNA' => 'Неодговорено',
	'quiz_colorError' => 'Грешка у синтакси',
	'quiz_correction' => 'Пошаљи',
	'quiz_score' => 'Ваш резултат је $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 бод|$2 бода|$2 бодова}}',
	'quiz_reset' => 'Поништи',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'quiz_desc' => 'Omogući stvaranje upitnika.',
	'quiz_addedPoints' => '{{PLURAL:$1|bod|boda|bodova}} se dodaje na tačan odgovor',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Bod|Boda|Bodova}} za pogrešan odgovor',
	'quiz_ignoreCoef' => 'Ignoriši koeficijente pitanja',
	'quiz_shuffle' => 'Izmešaj pitanja',
	'quiz_colorRight' => 'Tačno',
	'quiz_colorWrong' => 'Pogrešno',
	'quiz_colorNA' => 'Nije odgovoreno',
	'quiz_colorError' => 'Greška u sintaksi',
	'quiz_correction' => 'Postavi',
	'quiz_score' => 'Vaš rezultat je $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 bod|$2 boda|$2 bodova}}',
	'quiz_reset' => 'Poništi',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'quiz_desc' => 'Moaket dät Moakjen fon Quizspiele muugelk',
	'quiz_addedPoints' => '{{PLURAL:$1|Pluspunkt|Pluspunkte}} foar ne gjuchte Oantwoud',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Minuspunkt|Minuspunkte}} foar ne falske Oantwoud',
	'quiz_ignoreCoef' => 'Ignorierje do Froagen-Koeffiziente',
	'quiz_shuffle' => 'Froagen miskje',
	'quiz_colorRight' => 'Gjucht',
	'quiz_colorWrong' => 'Falsk',
	'quiz_colorNA' => 'Nit beoantwouded',
	'quiz_colorError' => 'Syntaxfailer',
	'quiz_correction' => 'Korrektuur',
	'quiz_score' => 'Punkte: $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 Punkt|$2 Punkte}}',
	'quiz_reset' => 'Näistart',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'quiz_addedPoints' => 'Peunteun ditambahan pikeun jawaban nu bener',
	'quiz_cutoffPoints' => 'Peunteun dikurangan pikeun jawaban nu salah',
	'quiz_colorRight' => 'Bener',
	'quiz_colorWrong' => 'Salah',
	'quiz_colorNA' => 'Teu dijawab',
	'quiz_colorError' => 'Salah rumpaka',
	'quiz_correction' => 'Kirim',
	'quiz_score' => 'Peunteun anjeun $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 poin|$2 poin}}',
	'quiz_reset' => 'Rését',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'quiz_desc' => 'Ger möjlighet att skapa frågeformulär',
	'quiz_addedPoints' => '{{PLURAL:$1|Poäng}} för rätt svar',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Poängavdrag}} för fel svar',
	'quiz_ignoreCoef' => 'Använd inte frågornas koefficienter',
	'quiz_shuffle' => 'Blanda om frågorna',
	'quiz_colorRight' => 'Rätt',
	'quiz_colorWrong' => 'Fel',
	'quiz_colorNA' => 'Besvarades ej',
	'quiz_colorError' => 'Syntaxfel',
	'quiz_correction' => 'Skicka',
	'quiz_score' => 'Din poäng är $1 av $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 poäng|$2 poäng}}',
	'quiz_reset' => 'Återställ',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'quiz_colorRight' => 'Ni sahihi',
	'quiz_colorWrong' => 'Si sahihi',
	'quiz_colorNA' => 'Haikujibiwa',
	'quiz_correction' => 'Wasilisha',
	'quiz_score' => 'Una maksi $1/$2',
	'quiz_points' => '{{PLURAL:$2|Maksi}} | $1',
	'quiz_reset' => 'Panga upya',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 * @author செல்வா
 */
$messages['ta'] = array(
	'quiz_desc' => 'புதிர்களை உருவாக்க அனுமதிக்கிறது',
	'quiz_addedPoints' => 'சரியான விடைகளுக்கு {{PLURAL:$1|Point|$1 புள்ளிகள்}} கொடுக்கப்பட்டுள்ளது',
	'quiz_cutoffPoints' => 'தவறான விடைகளுக்கு {{PLURAL:$1|Point|$1 புள்ளிகள்}} கொடுக்கப்பட்டுள்ளது',
	'quiz_ignoreCoef' => 'கேள்வியின் பெருக்கும் எண்ணை ஒதுக்கித்தள்ளவும்',
	'quiz_shuffle' => 'கேள்விகளை மாற்றிப்போடவும்',
	'quiz_colorRight' => 'சரி',
	'quiz_colorWrong' => 'தவறு',
	'quiz_colorNA' => 'விடை அளிக்கவில்லை',
	'quiz_colorError' => 'வழிமுறைத் தொடரமைப்பு பிழை',
	'quiz_correction' => 'சமர்ப்பி',
	'quiz_score' => 'தங்களுக்குக் கிடைத்த மதிப்பெண்கள் $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|புள்ளி|$2 புள்ளிகள்}}',
	'quiz_reset' => 'மீட்டமைக்க',
);

/** Telugu (తెలుగు)
 * @author Mpradeep
 * @author Veeven
 */
$messages['te'] = array(
	'quiz_desc' => 'క్విజ్&zwnj;ల తయారీని అనుమతిస్తుంది',
	'quiz_addedPoints' => 'సరియైన జవాబుకి కలిపే {{PLURAL:$1|పాయింటు|పాయింట్లు}}',
	'quiz_cutoffPoints' => 'తప్పు జవాబుకి తీసివేసే {{PLURAL:$1|పాయింటు|పాయింట్లు}}',
	'quiz_ignoreCoef' => 'ప్రశ్నల యొక్క గుణకాలని పట్టించుకోకు',
	'quiz_shuffle' => 'ప్రశ్నలను గజిబిజిచేయి',
	'quiz_colorRight' => 'ఒప్పు',
	'quiz_colorWrong' => 'తప్పు',
	'quiz_colorNA' => 'జవాబు లేదు',
	'quiz_colorError' => 'సింటాక్సు తప్పిదం',
	'quiz_correction' => 'దాఖలుచెయ్యి',
	'quiz_score' => 'మీ స్కోరు $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 పాయింటు|$2 పాయింట్లు}}',
	'quiz_reset' => 'రీసెట్',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'quiz_desc' => 'Эҷоди озмунҳоро мумкин месозад',
	'quiz_addedPoints' => 'Имтиёзи ҳар посухи дуруст',
	'quiz_cutoffPoints' => 'Имтиёзи манфии ҳар посухи нодуруст',
	'quiz_ignoreCoef' => 'Нодида гирифтани зариби саволҳо',
	'quiz_shuffle' => 'Бар задани саволҳо',
	'quiz_colorRight' => 'Дуруст',
	'quiz_colorWrong' => 'Нодуруст',
	'quiz_colorNA' => 'Посух дода нашуд',
	'quiz_colorError' => 'Хатои наҳвӣ',
	'quiz_correction' => 'Ирсол',
	'quiz_score' => 'Имтиёзи шумо $1 аз $2 аст',
	'quiz_points' => '$1 | $2 имтиёз',
	'quiz_reset' => 'Аз нав',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'quiz_desc' => 'Eçodi ozmunhoro mumkin mesozad',
	'quiz_ignoreCoef' => 'Nodida giriftani zaribi savolho',
	'quiz_shuffle' => 'Bar zadani savolho',
	'quiz_colorRight' => 'Durust',
	'quiz_colorWrong' => 'Nodurust',
	'quiz_colorNA' => 'Posux doda naşud',
	'quiz_colorError' => 'Xatoi nahvī',
	'quiz_correction' => 'Irsol',
	'quiz_score' => 'Imtijozi şumo $1 az $2 ast',
	'quiz_reset' => 'Az nav',
);

/** Thai (ไทย)
 * @author Mopza
 * @author Passawuth
 */
$messages['th'] = array(
	'quiz_colorRight' => 'ถูกต้อง',
	'quiz_colorWrong' => 'ผิด',
	'quiz_correction' => 'ยืนยัน',
	'quiz_score' => 'คุณได้คะแนน $1 จาก $2 คะแนน',
	'quiz_reset' => 'ตั้งค่าใหม่',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'quiz_desc' => 'Soragnama döretmeklige rugsat berýär',
	'quiz_addedPoints' => 'Dogry jogap üçin {{PLURAL:$1|utuk|utuk}} goşuldy',
	'quiz_cutoffPoints' => 'Nädogry jogap üçin {{PLURAL:$1|utuk|utuk}}',
	'quiz_ignoreCoef' => 'Soraglaryň koeffisientlerine üns berme',
	'quiz_shuffle' => 'Soraglary gar',
	'quiz_colorRight' => 'Dogry',
	'quiz_colorWrong' => 'Ýalňyş',
	'quiz_colorNA' => 'Jogapsyz',
	'quiz_colorError' => 'Sintaksis säwligi',
	'quiz_correction' => 'Tabşyr',
	'quiz_score' => 'Utugyňyz $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 utuk|$2 utuk}}',
	'quiz_reset' => 'Başky ýagdaýa getir',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'quiz_desc' => 'Nagpapahintulot na makalikha ng mumunting mga pagsusulit',
	'quiz_addedPoints' => 'Nagdaragdag ng {{PLURAL:$1|puntos|mga puntos}} para sa isang tamang sagot',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Puntos|Mga puntos}} para sa isang maling sagot',
	'quiz_ignoreCoef' => 'Balewalain ang mga koepisyente (katuwang na bilang) ng mga katanungan.',
	'quiz_shuffle' => 'Balasahin ang mga katanungan',
	'quiz_colorRight' => 'Tama',
	'quiz_colorWrong' => 'Mali',
	'quiz_colorNA' => 'Hindi nasagot',
	'quiz_colorError' => 'Kamalian sa palaugnayan',
	'quiz_correction' => 'Ipasa',
	'quiz_score' => 'Ang puntos mo ay $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 puntos|$2 mga puntos}}',
	'quiz_reset' => 'Itakdang muli',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Runningfridgesrule
 */
$messages['tr'] = array(
	'quiz_desc' => 'Quiz oluşturulmasına izin verir',
	'quiz_addedPoints' => '{{PLURAL:$1|Puan|Puan}} doğru cevap için eklendi',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Puan|Puan}} yanlış cevap için',
	'quiz_ignoreCoef' => 'Soruların katsayısını ihmal et',
	'quiz_shuffle' => 'Soruları karıştır',
	'quiz_colorRight' => 'Doğru',
	'quiz_colorWrong' => 'Yanlış',
	'quiz_colorNA' => 'Cevaplandırılmadı',
	'quiz_colorError' => 'Sözdizim hatası',
	'quiz_correction' => 'Gönder',
	'quiz_score' => 'Skorunuz $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 puan|$2 puan}}',
	'quiz_reset' => 'Sıfırla',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'quiz_desc' => 'Дозволяє створювати питальники',
	'quiz_addedPoints' => '{{PLURAL:$1|Очко додане|Очки додані}} за правильну відповідь',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Очко відняте|Очки відняті}} за неправильну відповідь',
	'quiz_ignoreCoef' => 'Нехтувати коефіцієнтами запитань',
	'quiz_shuffle' => 'Перемішати запитання',
	'quiz_colorRight' => 'Правильно',
	'quiz_colorWrong' => 'Неправильно',
	'quiz_colorNA' => 'Нема відповіді',
	'quiz_colorError' => 'Синтаксична помилка',
	'quiz_correction' => 'Надіслати',
	'quiz_score' => 'Ви набрали {{PLURAL:$1|$1 очко|$1 очки|$1 очок}} із $2',
	'quiz_points' => '$1 | $2 {{PLURAL:$2|очко|очки|очок}}',
	'quiz_reset' => 'Скинути',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'quiz_desc' => 'Perméte de crear dei zughi a quiz',
	'quiz_addedPoints' => '{{PLURAL:$1|Ponto|Ponti}} zontà par ogni risposta giusta',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Ponto|Ponti}} cavà par ogni risposta sbaglià',
	'quiz_ignoreCoef' => 'Ignora i coeficenti de domanda',
	'quiz_shuffle' => 'Mìssia le domande',
	'quiz_colorRight' => 'Giusto',
	'quiz_colorWrong' => 'Sbaglià',
	'quiz_colorNA' => 'Nissuna risposta',
	'quiz_colorError' => 'Eror de sintassi',
	'quiz_correction' => 'Corègi',
	'quiz_score' => 'El to puntegio el xe $1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 ponto|$2 ponti}}',
	'quiz_reset' => 'Azzèra',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'quiz_colorRight' => 'Oikti',
	'quiz_colorWrong' => 'Värin',
	'quiz_colorNA' => 'Ei ole vastust',
	'quiz_colorError' => 'Sintaksine petuz',
	'quiz_correction' => 'Oigeta',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'quiz_desc' => 'Tạo ra bài thi',
	'quiz_addedPoints' => '{{PLURAL:$1|Điểm|Số điểm}} cộng khi trả lời đúng',
	'quiz_cutoffPoints' => '{{PLURAL:$1|Điểm|Số điểm}} trừ khi trả lời sai',
	'quiz_ignoreCoef' => 'Bỏ qua hệ số của các câu hỏi',
	'quiz_shuffle' => 'Xáo trộn các câu hỏi',
	'quiz_colorRight' => 'Đúng',
	'quiz_colorWrong' => 'Sai',
	'quiz_colorNA' => 'Không trả lời',
	'quiz_colorError' => 'Lỗi cú pháp',
	'quiz_correction' => 'Đệ trình',
	'quiz_score' => 'Bạn đã trúng $1 trên tổng số $2 điểm',
	'quiz_points' => '$1 | {{PLURAL:$2|1 điểm|$2 điểm}}',
	'quiz_reset' => 'Tẩy trống',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'quiz_colorRight' => 'Verätik',
	'quiz_colorWrong' => 'Neverätik',
	'quiz_colorNA' => 'No pegesagon',
	'quiz_colorError' => 'Süntagapöl',
	'quiz_correction' => 'Sedön',
	'quiz_reset' => 'Geükön ad stad kösömik',
);

/** Yiddish (ייִדיש)
 * @author Imre
 * @author פוילישער
 */
$messages['yi'] = array(
	'quiz_desc' => 'דערלויבט שאפן אויספרעגן',
	'quiz_colorRight' => 'ריכטיק',
	'quiz_colorWrong' => 'פֿאַלש',
	'quiz_colorNA' => 'נישט געענטפֿערט',
	'quiz_colorError' => 'סינטאקס גרייז',
	'quiz_correction' => 'אײַנגעבן',
	'quiz_score' => 'פונקטן:$1 / $2',
	'quiz_points' => '$1 | {{PLURAL:$2|1 פונקט|$2 פונקטן}}',
	'quiz_reset' => 'צוריקשטעלן',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'quiz_colorRight' => 'Ẹ̀tọ́',
	'quiz_colorWrong' => 'Àìtọ́',
	'quiz_correction' => 'Fúnsílẹ̀',
	'quiz_reset' => 'Ìtúntò',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'quiz_desc' => '容許開小測題',
	'quiz_addedPoints' => '答啱咗加上嘅分數',
	'quiz_cutoffPoints' => '答錯咗減去嘅分數',
	'quiz_ignoreCoef' => '略過問題嘅系數',
	'quiz_shuffle' => '撈亂問題',
	'quiz_colorRight' => '啱',
	'quiz_colorWrong' => '錯',
	'quiz_colorNA' => '未答',
	'quiz_colorError' => '語法錯咗',
	'quiz_correction' => '遞交',
	'quiz_score' => '你嘅分數係 $1 / $2',
	'quiz_points' => '$1 | $2 分',
	'quiz_reset' => '重設',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'quiz_desc' => '允许创建测验',
	'quiz_addedPoints' => '答对加上的{{PLURAL:$1|分数|分数}}',
	'quiz_cutoffPoints' => '答错减去的{{PLURAL:$1|分数|分数}}',
	'quiz_ignoreCoef' => '略过问题的系数',
	'quiz_shuffle' => '随机问题',
	'quiz_colorRight' => '对',
	'quiz_colorWrong' => '错',
	'quiz_colorNA' => '未回答',
	'quiz_colorError' => '语法错误',
	'quiz_correction' => '递交',
	'quiz_score' => '您的分数是 $1 / $2',
	'quiz_points' => '$1 | $2 分',
	'quiz_reset' => '重置',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gaoxuewei
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'quiz_desc' => '容許建立小測題目',
	'quiz_addedPoints' => '答對加上的{{PLURAL:$1|分數|分數}}',
	'quiz_cutoffPoints' => '答錯減去的{{PLURAL:$1|分數|分數}}',
	'quiz_ignoreCoef' => '略過問題的係數',
	'quiz_shuffle' => '隨機問題',
	'quiz_colorRight' => '對',
	'quiz_colorWrong' => '錯',
	'quiz_colorNA' => '未回答',
	'quiz_colorError' => '語法錯誤',
	'quiz_correction' => '遞交',
	'quiz_score' => '您的分數是 $1 / $2',
	'quiz_points' => '$1 | $2 分',
	'quiz_reset' => '重設',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'quiz_desc' => '允許新增試卷',
	'quiz_colorRight' => '正確',
	'quiz_colorWrong' => '錯誤',
	'quiz_colorNA' => '未答',
	'quiz_colorError' => '語法錯誤',
	'quiz_correction' => '提交',
	'quiz_reset' => '重設',
);

