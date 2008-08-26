<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of Quiz.
 * Copyright (c) 2007 Louis-Rémi BABE. All rights reserved.
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
 * * Create a new directory named quiz into the directory "extensions" of MediaWiki.
 * * Place this file and the files Quiz.i18n.php and quiz.js there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once 'extensions/quiz/Quiz.php';
 *
 * @version 1.0
 * @link http://www.mediawiki.org/wiki/Extension:Quiz
 *
 * @author BABE Louis-Rémi <lrbabe@gmail.com>
 */

/**
 * Messages list.
 */

$messages = array();

$messages['en'] = array(
	'quiz_desc'	        => 'Allows creation of quizzes',
	'quiz_addedPoints'	=> "Point(s) added for a correct answer",
	'quiz_cutoffPoints'	=> "Point(s) subtracted for a wrong answer",
	'quiz_ignoreCoef'	=> "Ignore the questions' coefficients",
	'quiz_shuffle'		=> "Shuffle questions",
	'quiz_colorRight'	=> "Right",
	'quiz_colorWrong'	=> "Wrong",
	'quiz_colorNA'		=> "Not answered",
	'quiz_colorError'	=> "Syntax error",
	'quiz_correction'	=> "Submit",
	'quiz_score'		=> "Your score is $1 / $2",
	'quiz_points'		=> "$1 | {{PLURAL:$2|1 point|$2 points}}",
	'quiz_reset'		=> "Reset"
);

/** Message documentation (Message documentation)
 * @author Александр Сигачёв
 * @author Jon Harald Søby
 */
$messages['qqq'] = array(
	'quiz_shuffle'    => 'Button title. See http://en.wikiversity.org/wiki/Help:Quiz',
	'quiz_colorError' => '{{Identical|Syntax error}}',
	'quiz_correction' => '{{Identical|Submit}}',
	'quiz_reset'      => '{{Identical|Reset}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'quiz_shuffle'    => 'Skommel vrae',
	'quiz_colorRight' => 'Reg',
	'quiz_colorWrong' => 'Verkeerd',
	'quiz_colorNA'    => 'Nie geantwoord',
	'quiz_colorError' => 'Sintaksfout',
	'quiz_score'      => 'U punte is $1 / $2',
	'quiz_points'     => '$1 | {{PLURAL:$2|1 punt|$2 punte}}',
	'quiz_reset'      => 'Herstel',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'quiz_desc'         => 'Premite a creyazión de quizes',
	'quiz_addedPoints'  => 'Puntos por cada respuesta enzertata',
	'quiz_cutoffPoints' => 'Puntos sacatos por cada respuesta entibocata',
	'quiz_ignoreCoef'   => "Innorar os puntos d'as preguntas",
	'quiz_shuffle'      => 'Desordenar as preguntas',
	'quiz_colorRight'   => 'Enzertatas',
	'quiz_colorWrong'   => 'Entibocatas',
	'quiz_colorNA'      => 'No responditas',
	'quiz_colorError'   => 'Error de sintacsis',
	'quiz_correction'   => 'Correchir',
	'quiz_score'        => 'A suya puntuazión ye $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 punto|$2 puntos}}',
	'quiz_reset'        => 'Prenzipiar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Alnokta
 */
$messages['ar'] = array(
	'quiz_desc'         => 'يسمح بإنشاء اختبارات',
	'quiz_addedPoints'  => 'نقطة (نقاط) مضافة للإجابة الصحيحة',
	'quiz_cutoffPoints' => 'نقطة (نقاط) تخصم للإجابة الخاطئة',
	'quiz_ignoreCoef'   => 'تجاهل معاملات الأسئلة',
	'quiz_shuffle'      => 'أسئلة مختلطة',
	'quiz_colorRight'   => 'صواب',
	'quiz_colorWrong'   => 'خطأ',
	'quiz_colorNA'      => 'لم تتم الإجابة عليه',
	'quiz_colorError'   => 'خطأ صياغة',
	'quiz_correction'   => 'تنفيذ',
	'quiz_score'        => 'نتيجتك هي $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 نقطة|$2 نقطة}}',
	'quiz_reset'        => 'صفر',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Cedric31
 */
$messages['ast'] = array(
	'quiz_addedPoints'  => 'Puntu/os añadíu/os por rempuesta correuta',
	'quiz_cutoffPoints' => 'Puntu/os quitáu/os por rempuesta incorreuta',
	'quiz_ignoreCoef'   => 'Inorar los coeficientes de les entrugues',
	'quiz_shuffle'      => 'Revolver les entrugues',
	'quiz_colorRight'   => 'Correuto',
	'quiz_colorWrong'   => 'Incorreuto',
	'quiz_colorNA'      => 'Non respondida',
	'quiz_colorError'   => 'Error de sintaxis',
	'quiz_correction'   => 'Unviar',
	'quiz_score'        => 'La to puntuación ye $1 / $2',
	'quiz_points'       => '$1 | $2 puntu/os',
	'quiz_reset'        => 'Reïnicializar',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'quiz_desc'         => 'اجازه دنت په شرکتن معما',
	'quiz_addedPoints'  => 'نمره په درستین جواب اضافه بوت',
	'quiz_cutoffPoints' => 'نمره په جواب غلظ کم بوت',
	'quiz_ignoreCoef'   => 'ضریب سوالات مه دید',
	'quiz_shuffle'      => 'جوستان به هم ریچ',
	'quiz_colorRight'   => 'راست',
	'quiz_colorWrong'   => 'اشتباه',
	'quiz_colorNA'      => 'بی پسوء',
	'quiz_colorError'   => 'حطا ساختار',
	'quiz_correction'   => 'دیم دی',
	'quiz_score'        => 'شمی نمره $1 / $2 اینت',
	'quiz_points'       => '$1 | $2 نکته(s)',
	'quiz_reset'        => 'برگردینگ',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'quiz_shuffle'    => 'Balasahon an mga hapot',
	'quiz_colorRight' => 'Tamâ',
	'quiz_colorWrong' => 'Salâ',
	'quiz_correction' => 'Isumitir',
	'quiz_points'     => '$1 | $2 punto(s)',
	'quiz_reset'      => 'Ibalik',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Borislav
 */
$messages['bg'] = array(
	'quiz_desc'         => 'Позволява създаването на анкети',
	'quiz_addedPoints'  => 'Точки, добавяни за правилен отговор',
	'quiz_cutoffPoints' => 'Точки, отнемани за грешен отговор',
	'quiz_shuffle'      => 'Разбъркване на въпросите',
	'quiz_colorRight'   => 'Правилно',
	'quiz_colorWrong'   => 'Грешно',
	'quiz_colorNA'      => 'Без отговор',
	'quiz_colorError'   => 'Синтактична грешка',
	'quiz_correction'   => 'Изпращане',
	'quiz_score'        => 'Постижението ви е $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|една точка|$2 точки}}',
	'quiz_reset'        => 'Отмяна',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'quiz_desc'         => 'কুইজ সৃষ্টির অনুমতি দেয়',
	'quiz_addedPoints'  => 'সঠিক উত্তরের জন্য পয়েন্ট(সমূহ) যোগ হয়েছে',
	'quiz_cutoffPoints' => 'ভুল উত্তরের জন্য পয়েন্ট(সমূহ) বিয়োগ হয়েছে',
	'quiz_ignoreCoef'   => 'প্রশ্নগুলির সহগগুলি উপেক্ষা করা হোক',
	'quiz_shuffle'      => 'প্রশ্ন উলোটপালোট করো',
	'quiz_colorRight'   => 'সঠিক',
	'quiz_colorWrong'   => 'ভুল',
	'quiz_colorNA'      => 'উত্তর দেওয়া হয়নি',
	'quiz_colorError'   => 'বাক্যপ্রকরণ ত্রুটি',
	'quiz_correction'   => 'জমা দাও',
	'quiz_score'        => 'আপনার স্কোর $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 পয়েন্ট|$2 পয়েন্টসমূহ}}',
	'quiz_reset'        => 'পুনরায় আরম্ভ করুন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'quiz_desc'       => 'Aotren a ra krouiñ kwizoù',
	'quiz_shuffle'    => 'Meskañ ar goulennoù',
	'quiz_colorRight' => 'Mat',
	'quiz_colorWrong' => 'Fall',
	'quiz_colorNA'    => 'Direspont',
	'quiz_colorError' => 'Fazi ereadur',
	'quiz_correction' => 'Kas',
	'quiz_score'      => 'Ho skor zo par da $1 / $2',
	'quiz_points'     => '$1 | $2 poent',
);

/** Catalan (Català)
 * @author SMP
 * @author Paucabot
 */
$messages['ca'] = array(
	'quiz_addedPoints'  => 'Punt(s) guanyats per resposta correcta',
	'quiz_cutoffPoints' => 'Punt(s) perduts per resposta incorrecta',
	'quiz_shuffle'      => 'Preguntes aleatòries',
	'quiz_colorRight'   => 'Correcte',
	'quiz_colorWrong'   => 'Incorrecte',
	'quiz_colorNA'      => 'Sense resposta',
	'quiz_colorError'   => 'Error de sintaxi',
	'quiz_correction'   => 'Envia',
	'quiz_score'        => 'La vostra puntuació és $1 / $2',
	'quiz_points'       => '$1 | $2 punt(s)',
	'quiz_reset'        => 'Restaura',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'quiz_desc'         => 'Umožňuje tvorbu kvízů',
	'quiz_addedPoints'  => 'Bod(y) připočtené za správnou odpověď',
	'quiz_cutoffPoints' => 'Bod(y) odečtené za špatnou odpověď',
	'quiz_ignoreCoef'   => 'Ignorovat koeficienty otázek',
	'quiz_shuffle'      => 'Promíchat otázky',
	'quiz_colorRight'   => 'Správně',
	'quiz_colorWrong'   => 'Špatně',
	'quiz_colorNA'      => 'Nezodpovězeno',
	'quiz_colorError'   => 'Syntaktická chyba',
	'quiz_correction'   => 'Odeslat',
	'quiz_score'        => 'Váš výsledek je $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|$2 bod|$2 body|$2 bodů}}',
	'quiz_reset'        => 'Reset',
);

/** Danish (Dansk)
 * @author M.M.S.
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'quiz_colorRight' => 'Ret',
	'quiz_colorWrong' => 'Fejl',
	'quiz_colorNA'    => 'Ikke svared',
	'quiz_colorError' => 'syntaksfejl',
	'quiz_correction' => 'Send',
	'quiz_points'     => '$1 | $2 poeng',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'quiz_desc'         => 'Ermöglicht die Erstellung von Quizspielen',
	'quiz_addedPoints'  => 'Pluspunkte für eine richtige Antwort',
	'quiz_cutoffPoints' => 'Minuspunkte für eine falsche Antwort',
	'quiz_ignoreCoef'   => 'Ignoriere den Fragen-Koeffizienten',
	'quiz_shuffle'      => 'Fragen mischen',
	'quiz_colorRight'   => 'Richtig',
	'quiz_colorWrong'   => 'Falsch',
	'quiz_colorNA'      => 'Nicht beantwortet',
	'quiz_colorError'   => 'Syntaxfehler',
	'quiz_correction'   => 'Korrektur',
	'quiz_score'        => 'Punkte: $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 Punkt|$2 Punkte}}',
	'quiz_reset'        => 'Neustart',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author ZaDiak
 */
$messages['el'] = array(
	'quiz_colorRight' => 'Σωστό',
	'quiz_colorWrong' => 'Λάθος',
	'quiz_correction' => 'Καταχώρηση',
	'quiz_score'      => 'Η Βαθμολογία σας είναι $1 / $2',
	'quiz_points'     => '$1 | {{PLURAL:$2|1 βαθμό|$2 βαθμούς}}',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'quiz_desc'         => 'Permesas kreadon de kvizoj',
	'quiz_addedPoints'  => 'Poento(j) por ĝusta respondo',
	'quiz_cutoffPoints' => 'Poento(j) subtrahita(j) por malĝusta respondo',
	'quiz_ignoreCoef'   => 'Ignoru la koeficientojn de demandoj.',
	'quiz_shuffle'      => 'Miksu demandaron',
	'quiz_colorRight'   => 'Ĝusta',
	'quiz_colorWrong'   => 'Malĝusta',
	'quiz_colorNA'      => 'Ne respondita',
	'quiz_colorError'   => 'Sintaksa eraro',
	'quiz_correction'   => 'Ek!',
	'quiz_score'        => 'Viaj poentoj estas $1 / $2',
	'quiz_points'       => '$1 | $2 {{PLURAL:$2|1 poento|poentoj}}',
	'quiz_reset'        => 'Reŝarĝi',
);

/** Spanish (Español)
 * @author Ascánder
 */
$messages['es'] = array(
	'quiz_desc'         => 'Permite la creación de quices',
	'quiz_addedPoints'  => 'Puntos por cada respuesta acertada',
	'quiz_cutoffPoints' => 'Penalización por cada respuesta errónea',
	'quiz_ignoreCoef'   => 'Ignorar los puntos de cada pregunta',
	'quiz_shuffle'      => 'Desordenar preguntas',
	'quiz_colorRight'   => 'Acertadas',
	'quiz_colorWrong'   => 'Falladas',
	'quiz_colorNA'      => 'No contestadas',
	'quiz_colorError'   => 'Error de sintaxis',
	'quiz_correction'   => 'Contestar',
	'quiz_score'        => 'Tu puntuación es de $1 / $2',
	'quiz_points'       => '$1 | $2 punto(s)',
	'quiz_reset'        => 'Empezar de nuevo',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'quiz_desc'         => 'ایجاد آزمون را ممکن می‌سازد',
	'quiz_addedPoints'  => 'امتیاز هر پاسخ درست',
	'quiz_cutoffPoints' => 'امتیاز منفی هر پاسخ نادرست',
	'quiz_ignoreCoef'   => 'نادیده گرفتن ضریب سوال‌ها',
	'quiz_shuffle'      => 'برزدن سوال‌ها',
	'quiz_colorRight'   => 'درست',
	'quiz_colorWrong'   => 'نادرست',
	'quiz_colorNA'      => 'پاسخ داده نشده',
	'quiz_colorError'   => 'خطای نحوی',
	'quiz_correction'   => 'ارسال',
	'quiz_score'        => 'امتیاز شما $1 از $2 است',
	'quiz_points'       => '$1 | {{PLURAL:$2|۱ امتیاز|$2 امتیاز}}',
	'quiz_reset'        => 'از نو',
);

/** Finnish (Suomi)
 * @author Pe3
 * @author Str4nd
 * @author Cimon Avaro
 * @author Crt
 */
$messages['fi'] = array(
	'quiz_desc'         => 'Mahdollistaa kyselyiden luomisen.',
	'quiz_addedPoints'  => 'Pisteiden lisäysmäärä oikeasta vastauksesta',
	'quiz_cutoffPoints' => 'Pisteiden vähennysmäärä väärästä vastauksesta',
	'quiz_ignoreCoef'   => 'Jätä huomioimatta kysymysten kertoimet',
	'quiz_shuffle'      => 'Sekoita kysymykset',
	'quiz_colorRight'   => 'Oikein',
	'quiz_colorWrong'   => 'Väärin',
	'quiz_colorNA'      => 'Vastaamatta',
	'quiz_colorError'   => 'Jäsennysvirhe',
	'quiz_correction'   => 'Lähetä',
	'quiz_score'        => 'Tuloksesi on $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 piste|$2 pistettä}}',
	'quiz_reset'        => 'Palautus',
);

/** French (Français)
 * @author Grondin
 * @author Urhixidur
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'quiz_desc'         => 'Permet la création des quiz',
	'quiz_addedPoints'  => 'Point(s) ajouté(s) pour une réponse juste',
	'quiz_cutoffPoints' => 'Point(s) retiré(s) pour une réponse erronée',
	'quiz_ignoreCoef'   => 'Ignorer les coefficients des questions',
	'quiz_shuffle'      => 'Mélanger les questions',
	'quiz_colorRight'   => 'Juste',
	'quiz_colorWrong'   => 'Faux',
	'quiz_colorNA'      => 'Non répondu',
	'quiz_colorError'   => 'Erreur de syntaxe',
	'quiz_correction'   => 'Correction',
	'quiz_score'        => 'Votre pointage est $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 point|$2 points}}',
	'quiz_reset'        => 'Réinitialiser',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'quiz_desc'         => 'Pèrmèt la crèacion des quiz.',
	'quiz_addedPoints'  => 'Pouent(s) apondu(s) por una rèponsa justa',
	'quiz_cutoffPoints' => 'Pouent(s) enlevâ(s) por una rèponsa fôssa',
	'quiz_ignoreCoef'   => 'Ignorar los coèficients de les quèstions',
	'quiz_shuffle'      => 'Mècllar les quèstions',
	'quiz_colorRight'   => 'Justo',
	'quiz_colorWrong'   => 'Fôx',
	'quiz_colorNA'      => 'Pas rèpondu',
	'quiz_colorError'   => 'Èrror de sintaxa',
	'quiz_correction'   => 'Corrèccion',
	'quiz_score'        => 'Voutra mârca est $1 / $2',
	'quiz_points'       => '$1 | $2 pouent(s)',
	'quiz_reset'        => 'Tornar inicialisar',
);

/** Galician (Galego)
 * @author Xosé
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'quiz_desc'         => 'Permite a creación de preguntas',
	'quiz_addedPoints'  => 'Punto(s) engadidos para unha resposta correcta',
	'quiz_cutoffPoints' => 'Punto(s) restado(s) por cada resposta errónea',
	'quiz_ignoreCoef'   => 'Ignorar os coeficientes das preguntas',
	'quiz_shuffle'      => 'Barallar as preguntas',
	'quiz_colorRight'   => 'Ben',
	'quiz_colorWrong'   => 'Mal',
	'quiz_colorNA'      => 'Sen resposta',
	'quiz_colorError'   => 'Erro de sintaxe',
	'quiz_correction'   => 'Enviar',
	'quiz_score'        => 'A súa puntuación é $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 punto|$2 puntos}}',
	'quiz_reset'        => 'Limpar',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'quiz_desc'         => 'אפשרות ליצירת חידונים',
	'quiz_addedPoints'  => 'הנקודות שנוספות עבור כל תשובה נכונה',
	'quiz_cutoffPoints' => 'הנקודות שמורדות עבור כל תשובה שגויה',
	'quiz_ignoreCoef'   => 'התעלמות ממקדמי שאלות',
	'quiz_shuffle'      => 'סדר משתנה של השאלות',
	'quiz_colorRight'   => 'נכון',
	'quiz_colorWrong'   => 'שגוי',
	'quiz_colorNA'      => 'לא סומנה תשובה',
	'quiz_colorError'   => 'שגיאת תחביר',
	'quiz_correction'   => 'שליחה',
	'quiz_score'        => 'הניקוד שלך הוא $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|נקודה אחת|$2 נקודות}}',
	'quiz_reset'        => 'איפוס',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'quiz_desc'         => 'क्विज़ बनाने के लिये सहायता करता हैं',
	'quiz_addedPoints'  => 'सही जवाब के लिये मार्क्स दिये',
	'quiz_cutoffPoints' => 'गलत जवाबके लिये मार्क्स घटाये',
	'quiz_ignoreCoef'   => 'प्रश्नोंके कोएफिशिअंटको नजर अंदाज करें',
	'quiz_shuffle'      => 'सवाल उपर नीचे करें',
	'quiz_colorRight'   => 'सहीं',
	'quiz_colorWrong'   => 'गलत',
	'quiz_colorNA'      => 'जवाब दिया नहीं',
	'quiz_colorError'   => 'सिन्टॅक्स गलती',
	'quiz_correction'   => 'भेजें',
	'quiz_score'        => 'आपके गुण $1 / $2',
	'quiz_points'       => '$1 | $2 गुण',
	'quiz_reset'        => 'पूर्ववत करें',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 * @author Dnik
 */
$messages['hr'] = array(
	'quiz_desc'         => 'Dozvoljava kreiranje kvizova',
	'quiz_addedPoints'  => 'Broj bodova za točan odgovor',
	'quiz_cutoffPoints' => 'Broj negativnih bodova (tj. bodova koji se oduzimaju) za netočan odgovor',
	'quiz_ignoreCoef'   => 'Ignoriraj težinske koeficijente pitanja',
	'quiz_shuffle'      => 'Promiješaj pitanja',
	'quiz_colorRight'   => 'Točno',
	'quiz_colorWrong'   => 'Netočno',
	'quiz_colorNA'      => 'Neodgovoreno',
	'quiz_colorError'   => 'Sintaksna greška',
	'quiz_correction'   => 'Ocijeni kviz',
	'quiz_score'        => 'Vaš rezultat je $1 / $2',
	'quiz_points'       => '$1 | $2 {{PLURAL:$1|bod|boda|bodova}}',
	'quiz_reset'        => 'Poništi kviz',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'quiz_desc'         => 'Dowola wutworjenje kwisow',
	'quiz_addedPoints'  => 'Plusdypki za prawu wotmołwu',
	'quiz_cutoffPoints' => 'Minusdypki za wopačnu wotmołwu',
	'quiz_ignoreCoef'   => 'Prašenske koeficienty ignorować',
	'quiz_shuffle'      => 'Prašenja měšeć',
	'quiz_colorRight'   => 'Prawje',
	'quiz_colorWrong'   => 'Wopak',
	'quiz_colorNA'      => 'Žana wotmołwa',
	'quiz_colorError'   => 'Syntaksowy zmylk',
	'quiz_correction'   => 'Korektura',
	'quiz_score'        => 'Twój hrajny staw je: $1 / $2',
	'quiz_points'       => '$1 | $2 dypkow',
	'quiz_reset'        => 'Znowastartowanje',
);

/** Haitian (Kreyòl ayisyen)
 * @author Jvm
 */
$messages['ht'] = array(
	'quiz_desc'         => 'Pemèt Kreyasyon kwiz yo',
	'quiz_addedPoints'  => 'Pwen mete pou repons kòrèk',
	'quiz_cutoffPoints' => 'Pwen retire pou repons ki enkòrèk',
	'quiz_ignoreCoef'   => 'Ignore koefisyan kesyon yo',
	'quiz_shuffle'      => 'Mikse kesyon yo',
	'quiz_colorRight'   => 'Korèk',
	'quiz_colorWrong'   => 'Enkòrèk',
	'quiz_colorNA'      => 'San repons',
	'quiz_colorError'   => 'Erè Sintaks',
	'quiz_correction'   => 'Soumèt',
	'quiz_score'        => 'Rezilta w se $1 / $2',
	'quiz_points'       => '$1 | $2 pwen',
	'quiz_reset'        => 'Resèt',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 */
$messages['hu'] = array(
	'quiz_desc'         => 'Lehetővé teszi kvízkérdések létrehozását',
	'quiz_addedPoints'  => 'Helyes válasz esetén adott pont',
	'quiz_cutoffPoints' => 'Hibás válasz esetén levont pont',
	'quiz_ignoreCoef'   => 'Ne vegye figyelembe a kérdések együtthatóit',
	'quiz_shuffle'      => 'Kérdések összekeverése',
	'quiz_colorRight'   => 'Jó',
	'quiz_colorWrong'   => 'Rossz',
	'quiz_colorNA'      => 'Nem válaszoltál',
	'quiz_colorError'   => 'Szintaktikai hiba',
	'quiz_correction'   => 'Elküldés',
	'quiz_score'        => 'A pontszámod: $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|egy|$2}} pont',
	'quiz_reset'        => 'Újraindít',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'quiz_desc'         => 'Permitte le creation de quizes',
	'quiz_addedPoints'  => 'Puncto(s) addite pro cata responsa correcte',
	'quiz_cutoffPoints' => 'Puncto(s) subtrahite pro cata responsa erronee',
	'quiz_ignoreCoef'   => 'Ignorar le coefficientes del questiones',
	'quiz_shuffle'      => 'Miscer questiones',
	'quiz_colorRight'   => 'Juste',
	'quiz_colorWrong'   => 'False',
	'quiz_colorNA'      => 'Non respondite',
	'quiz_colorError'   => 'Error de syntaxe',
	'quiz_correction'   => 'Submitter',
	'quiz_score'        => 'Punctos: $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 puncto|$2 punctos}}',
	'quiz_reset'        => 'Reinitiar',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'quiz_desc'         => 'Menyediakan fasilitas pembuatan kuis',
	'quiz_addedPoints'  => 'Penambahan angka untuk jawaban yang benar',
	'quiz_cutoffPoints' => 'Pengurangan angka untuk jawaban yang salah',
	'quiz_ignoreCoef'   => 'Abaikan koefisien pertanyaan',
	'quiz_shuffle'      => 'Mengacak pertanyaan',
	'quiz_colorRight'   => 'Benar',
	'quiz_colorWrong'   => 'Salah',
	'quiz_colorNA'      => 'Tak dijawab',
	'quiz_colorError'   => 'Kesalahan sintaks',
	'quiz_correction'   => 'Koreksi',
	'quiz_score'        => 'Skor Anda adalah $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 poin|$2 poin}}',
	'quiz_reset'        => 'Tataulang',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'quiz_colorRight' => 'Justa',
	'quiz_colorWrong' => 'Nejusta',
	'quiz_points'     => '$1 | $2 punti',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'quiz_desc'         => 'Heimilar gerð skyndiprófa',
	'quiz_addedPoints'  => 'Stig fyrir rétt svar',
	'quiz_cutoffPoints' => 'Stig dregin frá fyrir rangt svar',
	'quiz_shuffle'      => 'Stokka svörin',
	'quiz_colorRight'   => 'Rétt',
	'quiz_colorWrong'   => 'Röng',
	'quiz_colorNA'      => 'Ósvarað',
	'quiz_colorError'   => 'Málfræðivilla',
	'quiz_correction'   => 'Senda',
	'quiz_score'        => 'Stigafjöldinn þinn er $1 / $2',
	'quiz_points'       => '$1 | $2 stig',
	'quiz_reset'        => 'Endurstilla',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'quiz_desc'         => 'Consente di creare dei quiz',
	'quiz_addedPoints'  => 'Punti aggiunti per ogni risposta corretta',
	'quiz_cutoffPoints' => 'Punti sottratti per ogni risposta errata',
	'quiz_ignoreCoef'   => 'Ignora i coefficienti di domanda',
	'quiz_shuffle'      => 'Mescola le domande',
	'quiz_colorRight'   => 'Giusto',
	'quiz_colorWrong'   => 'Sbagliato',
	'quiz_colorNA'      => 'Nessuna risposta',
	'quiz_colorError'   => 'Errore di sintassi',
	'quiz_correction'   => 'Correggi',
	'quiz_score'        => 'Il tuo punteggio è $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 punto|$2 punti}}',
	'quiz_reset'        => 'Reimposta',
);

/** Japanese (日本語)
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'quiz_desc'         => 'クイズの作成',
	'quiz_addedPoints'  => '正解時の得点',
	'quiz_cutoffPoints' => '不正解時の失点',
	'quiz_ignoreCoef'   => '問題ごとの倍率を無視する',
	'quiz_shuffle'      => '問題をシャッフル',
	'quiz_colorRight'   => '正解',
	'quiz_colorWrong'   => '不正解',
	'quiz_colorNA'      => '無回答',
	'quiz_colorError'   => '構文エラー',
	'quiz_correction'   => '採点',
	'quiz_score'        => '得点：$1点（$2点満点）',
	'quiz_points'       => '$1 | $2点',
	'quiz_reset'        => 'リセット',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'quiz_desc'         => 'Gæv kreåsje der kwesser æ mågleghed',
	'quiz_addedPoints'  => 'Punkt(er) tilføjer før æ korrekt answer',
	'quiz_cutoffPoints' => 'Punkt(er) subtraktet før æ fejl answer',
	'quiz_ignoreCoef'   => 'Ignorær æ fråge han koeffisienter',
	'quiz_shuffle'      => 'Skuffel fråge',
	'quiz_colorRight'   => 'Gåd',
	'quiz_colorWrong'   => 'Fejl',
	'quiz_colorNA'      => 'Ekke answered',
	'quiz_colorError'   => 'Syntaks fejl',
	'quiz_correction'   => 'Gå',
	'quiz_score'        => 'Diin skår er $1 / $2',
	'quiz_points'       => '$1 | $2 punkt(er)',
	'quiz_reset'        => 'Reset',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'quiz_desc'         => 'Nyedyakaké fasilitas nggawé kuis',
	'quiz_addedPoints'  => 'Ditambahi angka biji kanggo wangsulan sing bener',
	'quiz_cutoffPoints' => 'Angka biji dikurangi kanggo wangsulan sing salah',
	'quiz_ignoreCoef'   => 'Lirwakna koéfisièn pitakonan',
	'quiz_shuffle'      => 'Ngacak pitakonan',
	'quiz_colorRight'   => 'Bener',
	'quiz_colorWrong'   => 'Salah',
	'quiz_colorNA'      => 'Ora diwangsuli',
	'quiz_colorError'   => "Kaluputan sintaksis (''syntax error'')",
	'quiz_correction'   => 'Kirim',
	'quiz_score'        => 'Skor biji panjenengan iku $1 / $2',
	'quiz_points'       => '$1 | $2 poin',
	'quiz_reset'        => 'Reset',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author គីមស៊្រុន
 * @author Lovekhmer
 */
$messages['km'] = array(
	'quiz_desc'         => 'អនុញ្ញាតអោយបង្កើតចំណោទសួរ',
	'quiz_addedPoints'  => 'ពិន្ទុត្រូវបានបូកចូលចំពោះចំលើយត្រឹមត្រូវ',
	'quiz_cutoffPoints' => 'ពិន្ទុត្រូវបានដកចេញចំពោះចំលើយខុស',
	'quiz_ignoreCoef'   => 'មិនខ្វល់ពី​មេគុណ​នៃ​សំណួរ',
	'quiz_shuffle'      => 'សាប់សំណួរ',
	'quiz_colorRight'   => 'ត្រូវ',
	'quiz_colorWrong'   => 'ខុស',
	'quiz_colorNA'      => 'មិនបានឆ្លើយ',
	'quiz_colorError'   => 'កំហុសពាក្យសម័្ពន្ធ',
	'quiz_correction'   => 'ដាក់ស្នើ',
	'quiz_score'        => 'តារាងពិន្ទុរបស់អ្នកគឺ  $1/$2',
	'quiz_points'       => '$1 | {{PLURAL:$2|១ពិន្ទុ|$2ពិន្ទុ}}',
	'quiz_reset'        => 'ធ្វើឱ្យដូចដើមវិញ',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'quiz_correction' => 'Verbessere!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'quiz_desc'         => 'Erméiglecht et Quizzer ze maachen',
	'quiz_addedPoints'  => 'Punkt(en) derbäi fir eng richteg Äntwert',
	'quiz_cutoffPoints' => 'Punkt(en) ofgezunn fir eng falsch Äntwert',
	'quiz_ignoreCoef'   => 'Koeffizient vun der Fro ignoréieren',
	'quiz_shuffle'      => 'Froe meschen',
	'quiz_colorRight'   => 'Richteg',
	'quiz_colorWrong'   => 'Falsch',
	'quiz_colorNA'      => 'Net beäntwert',
	'quiz_colorError'   => 'Syntaxfeeler',
	'quiz_correction'   => 'Verbesserung',
	'quiz_score'        => 'Punkten: $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 Punkt|$2 Punkten}}',
	'quiz_reset'        => 'Zrécksetzen',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'quiz_desc'         => "Maak 't aanmake van tes meugelik",
	'quiz_addedPoints'  => "Puntj(e) toegevoeg veur 'n good antjwaord",
	'quiz_cutoffPoints' => "Puntj(e) aafgetróg veur 'n fout antjwaord",
	'quiz_ignoreCoef'   => 'De coëfficiente van de vräög negere',
	'quiz_shuffle'      => 'De vräög in willekäörige volgorde',
	'quiz_colorRight'   => 'Ramkrèk',
	'quiz_colorWrong'   => 'Ónkrèk',
	'quiz_colorNA'      => 'Neet beantjwaord',
	'quiz_colorError'   => 'Algemeine fout',
	'quiz_correction'   => 'Verbaetering',
	'quiz_score'        => 'Dien score is $1 / $2',
	'quiz_points'       => '$1 | $2 puntj(e)',
	'quiz_reset'        => 'Oppernuuj',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'quiz_addedPoints'  => 'Taškai pridėti už teisingą atsakymą',
	'quiz_cutoffPoints' => 'Taškai atimti už blogą atsakymą',
	'quiz_ignoreCoef'   => 'Nepaisyti klausimų koeficientų',
	'quiz_shuffle'      => 'Maišyti klausimus',
	'quiz_colorRight'   => 'Teisingai',
	'quiz_colorWrong'   => 'Neteisingai',
	'quiz_colorNA'      => 'Neatsakyta',
	'quiz_colorError'   => 'Sintaksės klaida',
	'quiz_correction'   => 'Pateikti',
	'quiz_score'        => 'Jūsų surinkti taškai yra $1 iš $2',
	'quiz_points'       => '$1 | $2 taškas(ai)',
	'quiz_reset'        => 'Valyti',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 * @author Jacob.jose
 */
$messages['ml'] = array(
	'quiz_desc'         => 'ക്വിസുകള്‍ സൃഷ്ടിക്കാന്‍ സഹായിക്കുന്നു',
	'quiz_addedPoints'  => 'ശരിയുത്തരത്തിനു പോയിന്റ് ചേര്‍ത്തു',
	'quiz_cutoffPoints' => 'തെറ്റായ ഉത്തരത്തിനു പോയിന്റ് കുറച്ചു',
	'quiz_shuffle'      => 'ചോദ്യങ്ങള്‍ കശക്കുക',
	'quiz_colorRight'   => 'ശരി',
	'quiz_colorWrong'   => 'തെറ്റ്',
	'quiz_colorNA'      => 'ഉത്തരം നല്‍കിയിട്ടില്ല',
	'quiz_colorError'   => 'സിന്റാക്സ് പിഴവ്',
	'quiz_correction'   => 'സമര്‍പ്പിക്കുക',
	'quiz_score'        => 'താങ്കളുടെ സ്കോര്‍ $1/$2',
	'quiz_points'       => '$1|$2 പോയിന്റ്',
	'quiz_reset'        => 'പുനഃക്രമീകരിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'quiz_desc'         => 'प्रश्नावल्या तयार करण्याची परवानगी देते.',
	'quiz_addedPoints'  => 'बरोबर उत्तरासाठी गुण दिले',
	'quiz_cutoffPoints' => 'चुकीच्या उत्तरासाठी गुण वजा केले',
	'quiz_ignoreCoef'   => 'प्रश्नाच्या कोएफिशियंटकडे लक्ष देऊ नका',
	'quiz_shuffle'      => 'प्रश्न वरखाली करा',
	'quiz_colorRight'   => 'बरोबर',
	'quiz_colorWrong'   => 'चूक',
	'quiz_colorNA'      => 'उत्तर दिलेले नाही',
	'quiz_colorError'   => 'चुकीचा सिन्टॅक्स',
	'quiz_correction'   => 'पाठवा',
	'quiz_score'        => 'तुमचे गुण $1 / $2',
	'quiz_points'       => '$1 | $2 गुण',
	'quiz_reset'        => 'पूर्ववत करा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'quiz_desc'         => 'Membolehkan penciptaan kuiz',
	'quiz_addedPoints'  => 'Mata yang ditambah untuk jawapan betul',
	'quiz_cutoffPoints' => 'Mata yang ditolak untuk jawapan salah',
	'quiz_ignoreCoef'   => 'Abaikan pekali soalan',
	'quiz_shuffle'      => 'Papar soalan',
	'quiz_colorRight'   => 'Betul',
	'quiz_colorWrong'   => 'Salah',
	'quiz_colorNA'      => 'Tidak dijawab',
	'quiz_colorError'   => 'Ralat sintaks',
	'quiz_correction'   => 'Serah',
	'quiz_score'        => 'Anda mendapat $1 daripada $2 mata',
	'quiz_points'       => '$1 | $2 mata',
	'quiz_reset'        => 'Set semula',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'quiz_correction' => 'Tiquihuāz',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'quiz_desc'         => 'Verlööft dat Opstellen vun Quizspelen',
	'quiz_addedPoints'  => 'Punkten för richtige Antwoort',
	'quiz_cutoffPoints' => 'Minuspunkten för verkehrte Antwoort',
	'quiz_ignoreCoef'   => 'op Fragen-Koeffizienten nix op geven',
	'quiz_shuffle'      => 'Fragen mischen',
	'quiz_colorRight'   => 'Stimmt',
	'quiz_colorWrong'   => 'Verkehrt',
	'quiz_colorNA'      => 'Nich antert',
	'quiz_colorError'   => 'Syntaxfehler',
	'quiz_correction'   => 'Korrektur',
	'quiz_score'        => 'Punkten: $1 / $2',
	'quiz_points'       => '$1 | $2 {{PLURAL:$2|Punkt|Punkten}}',
	'quiz_reset'        => 'Trüchsetten',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'quiz_desc'         => 'Maakt het aanmaken van tests mogelijk',
	'quiz_addedPoints'  => 'Punt(en) toegevoegd voor een goed antwoord',
	'quiz_cutoffPoints' => 'Punt(en) afgetrokken voor een fout antwoord',
	'quiz_ignoreCoef'   => 'De coëfficienten van de vragen negeren',
	'quiz_shuffle'      => 'De vragen in willekeurige volgorde',
	'quiz_colorRight'   => 'Goed',
	'quiz_colorWrong'   => 'Fout',
	'quiz_colorNA'      => 'Niet beantwoord',
	'quiz_colorError'   => 'Algemene fout',
	'quiz_correction'   => 'Verbetering',
	'quiz_score'        => 'Uw score is $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 punt|$2 punten}}',
	'quiz_reset'        => 'Opnieuw',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 */
$messages['nn'] = array(
	'quiz_desc'         => 'Gjer oppretting av spørjekonkurransar mogleg',
	'quiz_addedPoints'  => 'Plusspoeng for rett svar',
	'quiz_cutoffPoints' => 'Minuspoeng for feil svar',
	'quiz_ignoreCoef'   => 'Oversjå verdiane på spørsmåla',
	'quiz_shuffle'      => 'Stokk om på spørsmåla',
	'quiz_colorRight'   => 'Rett',
	'quiz_colorWrong'   => 'Feil',
	'quiz_colorNA'      => 'Ikkje svara på',
	'quiz_colorError'   => 'Syntaksfeil',
	'quiz_correction'   => 'Svar',
	'quiz_score'        => 'Poengsummen din er $1 av $2 moglege',
	'quiz_points'       => '$1 | $2 poeng',
	'quiz_reset'        => 'Nullstill',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'quiz_desc'         => 'Tillater oppretting av quizer',
	'quiz_addedPoints'  => 'Plusspoeng for korrekt svar',
	'quiz_cutoffPoints' => 'Minuspoeng for galt svar',
	'quiz_ignoreCoef'   => 'Ignorer spørsmålets verdier',
	'quiz_shuffle'      => 'Stokk spørsmålene',
	'quiz_colorRight'   => 'Riktig',
	'quiz_colorWrong'   => 'Galt',
	'quiz_colorNA'      => 'Ikke besvart',
	'quiz_colorError'   => 'Syntaksfeil',
	'quiz_correction'   => 'Svar',
	'quiz_score'        => 'Din poengsum er $1 av $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 poeng|$2 poeng}}',
	'quiz_reset'        => 'Nullstill',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'quiz_desc'         => 'Permet la creacion dels Quiz',
	'quiz_addedPoints'  => 'Punt(s) ajustat(s) per una responsa justa',
	'quiz_cutoffPoints' => 'Punt(s) levat(s) per una responsa erronèa',
	'quiz_ignoreCoef'   => 'Ignorar los coeficients de las questions',
	'quiz_shuffle'      => 'Mesclar las questions',
	'quiz_colorRight'   => 'Just',
	'quiz_colorWrong'   => 'Fals',
	'quiz_colorNA'      => 'Pas respondut',
	'quiz_colorError'   => 'Error de sintaxi',
	'quiz_correction'   => 'Correccion',
	'quiz_score'        => 'Vòstra marca es $1 / $2',
	'quiz_points'       => '$1 | $2 punt(s)',
	'quiz_reset'        => 'Reïnicializar',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 * @author Maikking
 */
$messages['pl'] = array(
	'quiz_desc'         => 'Umożliwia tworzenie quizów',
	'quiz_addedPoints'  => 'Punkty dodawane za właściwą odpowiedź',
	'quiz_cutoffPoints' => 'Punkty odejmowane za niewłaściwą odpowiedź',
	'quiz_ignoreCoef'   => 'Ignoruj punktację pytań',
	'quiz_shuffle'      => 'Losuj kolejność pytań',
	'quiz_colorRight'   => 'Właściwa',
	'quiz_colorWrong'   => 'Niewłaściwa',
	'quiz_colorNA'      => 'Brak odpowiedzi',
	'quiz_colorError'   => 'Błąd składni',
	'quiz_correction'   => 'Wyślij',
	'quiz_score'        => 'Twoje punty to $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 punkt|$2 punkty|$2 punktów}}',
	'quiz_reset'        => 'Wyzeruj',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'quiz_addedPoints'  => "Pont da dé për n'aspòsta giusta",
	'quiz_cutoffPoints' => "Pont da gavé për n'aspòsta nen giusta",
	'quiz_ignoreCoef'   => 'Pa dovré ij coeficent dle domande',
	'quiz_shuffle'      => 'Mës-cé le domande',
	'quiz_colorRight'   => 'Giust',
	'quiz_colorWrong'   => 'Pa giust',
	'quiz_colorNA'      => "Anco' nen d'arspòsta",
	'quiz_colorError'   => 'Eror ëd sintassi',
	'quiz_correction'   => 'Manda',
	'quiz_score'        => "A l'ha pijait $1 pont ansima a $2",
	'quiz_points'       => '$1 | $2 pont',
	'quiz_reset'        => 'Aseré',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'quiz_shuffle'    => 'پوښتنې ګډوډول',
	'quiz_colorRight' => 'سم',
	'quiz_colorWrong' => 'ناسم',
	'quiz_colorNA'    => 'بې ځوابه',
	'quiz_score'      => 'ستاسو نومرې $1 / $2 دي',
	'quiz_points'     => '$1 | $2 نمره(ې)',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author 555
 */
$messages['pt'] = array(
	'quiz_desc'         => 'Permite a criação de questionários',
	'quiz_addedPoints'  => 'Ponto(s) adicionados por cada resposta certa',
	'quiz_cutoffPoints' => 'Ponto(s) subtraídos por cada resposta errada',
	'quiz_ignoreCoef'   => 'Ignorar os coeficientes das questões',
	'quiz_shuffle'      => 'Baralhar as questões',
	'quiz_colorRight'   => 'Correctas',
	'quiz_colorWrong'   => 'Erradas',
	'quiz_colorNA'      => 'Não respondidas',
	'quiz_colorError'   => 'Erro de sintaxe',
	'quiz_correction'   => 'Enviar',
	'quiz_score'        => 'Pontuação actual: $1 certas em $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|um ponto|$2 pontos}}',
	'quiz_reset'        => 'Repor a zero',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'quiz_addedPoints'  => 'Allin kutichisqapaq iñukuna yapasqa',
	'quiz_cutoffPoints' => 'Panta kutichisqapaq iñukuna qichusqa',
	'quiz_ignoreCoef'   => 'Sapa tapuypaq iñukunata qhawarpariy',
	'quiz_shuffle'      => 'Tapuykunata arwiy',
	'quiz_colorRight'   => 'Allin',
	'quiz_colorWrong'   => 'Panta',
	'quiz_colorNA'      => 'Mana kutichisqa',
	'quiz_colorError'   => 'Sintaksis pantasqa',
	'quiz_correction'   => 'Kutichiy',
	'quiz_score'        => 'Taripasqaykikunaqa kay hinam: $1 / $2',
	'quiz_points'       => '$1 | $2 iñu',
	'quiz_reset'        => 'Musuqmanta qallariy',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author EugeneZelenko
 */
$messages['ru'] = array(
	'quiz_desc'         => 'Позволяет создавать вопросники',
	'quiz_addedPoints'  => 'очко(ов) добавлено за правильный ответ',
	'quiz_cutoffPoints' => 'очко(ов) вычтено за неправильный ответ',
	'quiz_ignoreCoef'   => 'Пренебрегать коэффициентами вопросов',
	'quiz_shuffle'      => 'Перемешать вопросы',
	'quiz_colorRight'   => 'Правильно',
	'quiz_colorWrong'   => 'Ошибка',
	'quiz_colorNA'      => 'Нет ответа',
	'quiz_colorError'   => 'Синтаксическая ошибка',
	'quiz_correction'   => 'Отправить',
	'quiz_score'        => 'Вы набрали $1 {{PLURAL:$1|очко|очка|очков}} из $2',
	'quiz_points'       => '$1 | $2 {{PLURAL:$2|очко|очка|очков}}',
	'quiz_reset'        => 'Сбросить',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'quiz_desc'         => 'Вопросниктары оҥорор кыаҕы биэрэр',
	'quiz_addedPoints'  => 'Очкуо сөп эппиэт иһин эбилиннэ',
	'quiz_cutoffPoints' => 'очкуо сыыһа эппиэт иһин көҕүрэтилиннэ',
	'quiz_ignoreCoef'   => 'Ыйытыылар коэффициеннарын аахсыма',
	'quiz_shuffle'      => 'Ыйытыылары булкуй',
	'quiz_colorRight'   => 'Сөп',
	'quiz_colorWrong'   => 'Сыыһа',
	'quiz_colorNA'      => 'Эппиэт суох',
	'quiz_colorError'   => 'Синтаксическай алҕас',
	'quiz_correction'   => 'Ыыт',
	'quiz_score'        => '$2 очкуоттан $1 очкуону ыллыҥ',
	'quiz_points'       => '$1 | $2 очкуо',
	'quiz_reset'        => 'Саҥаттан',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'quiz_desc'         => 'Umožňuje tvorbu kvízov',
	'quiz_addedPoints'  => 'Bod(y) pričítané za správnu odpoveď',
	'quiz_cutoffPoints' => 'Bod(y) odčítané za nesprávnu odpoveď',
	'quiz_ignoreCoef'   => 'Ignorovať koeficienty otázok',
	'quiz_shuffle'      => 'Náhodný výber otázok',
	'quiz_colorRight'   => 'Správne',
	'quiz_colorWrong'   => 'Nesprávne',
	'quiz_colorNA'      => 'Nezodpovedané',
	'quiz_colorError'   => 'Syntaktická chyba',
	'quiz_correction'   => 'Oprava',
	'quiz_score'        => 'Vaše skóre je $1 / $2',
	'quiz_points'       => '$1 | $2 {{PLURAL:$2|bod|body|bodov}}',
	'quiz_reset'        => 'Reset',
);

/** Albanian (Shqip)
 * @author Cradel
 * @author Ergon
 */
$messages['sq'] = array(
	'quiz_desc'       => 'Lejon krijimin e enigmave',
	'quiz_ignoreCoef' => 'Injoro koificientin e pyetjes',
	'quiz_shuffle'    => 'Përziej pyetjet',
	'quiz_colorRight' => 'Korrekt',
	'quiz_colorWrong' => 'Gabim',
	'quiz_correction' => 'Dërgo',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'quiz_desc'         => 'Омогући стварање упитника.',
	'quiz_addedPoints'  => 'Поени додати за тачан одговор',
	'quiz_cutoffPoints' => 'Поени одузети због погрешног одговора',
	'quiz_ignoreCoef'   => 'Игнориши коефицијенте питања',
	'quiz_shuffle'      => 'Измешај питања',
	'quiz_colorRight'   => 'Тачно',
	'quiz_colorWrong'   => 'Погрешно',
	'quiz_colorNA'      => 'Није одговорено',
	'quiz_colorError'   => 'Грешка у синтакси',
	'quiz_correction'   => 'Постави',
	'quiz_score'        => 'Ваш резултат је $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 бод|$2 бода|$2 бодова}}',
	'quiz_reset'        => 'Ресетуј',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'quiz_addedPoints'  => 'Pluspunkte foar ne gjuchte Oantwoud',
	'quiz_cutoffPoints' => 'Minuspunkte foar ne falske Oantwoud',
	'quiz_ignoreCoef'   => 'Ignorierje do Froagen-Koeffiziente',
	'quiz_shuffle'      => 'Froagen miskje',
	'quiz_colorRight'   => 'Gjucht',
	'quiz_colorWrong'   => 'Falsk',
	'quiz_colorNA'      => 'Nit beoantwouded',
	'quiz_colorError'   => 'Syntaxfailer',
	'quiz_correction'   => 'Korrektuur',
	'quiz_score'        => 'Punkte: $1 / $2',
	'quiz_points'       => '$1 | $2 Punkte',
	'quiz_reset'        => 'Näistart',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'quiz_addedPoints'  => 'Peunteun ditambahan pikeun jawaban nu bener',
	'quiz_cutoffPoints' => 'Peunteun dikurangan pikeun jawaban nu salah',
	'quiz_colorRight'   => 'Bener',
	'quiz_colorWrong'   => 'Salah',
	'quiz_colorNA'      => 'Teu dijawab',
	'quiz_colorError'   => 'Salah rumpaka',
	'quiz_correction'   => 'Kirim',
	'quiz_score'        => 'Peunteun anjeun $1 / $2',
	'quiz_points'       => '$1 | $2 poin',
	'quiz_reset'        => 'Rését',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Boivie
 */
$messages['sv'] = array(
	'quiz_desc'         => 'Ger möjlighet att skapa frågeformulär',
	'quiz_addedPoints'  => 'Poäng för rätt svar',
	'quiz_cutoffPoints' => 'Poängavdrag för fel svar',
	'quiz_ignoreCoef'   => 'Använd inte frågornas koefficienter',
	'quiz_shuffle'      => 'Blanda om frågorna',
	'quiz_colorRight'   => 'Rätt',
	'quiz_colorWrong'   => 'Fel',
	'quiz_colorNA'      => 'Besvarades ej',
	'quiz_colorError'   => 'Syntaxfel',
	'quiz_correction'   => 'Skicka',
	'quiz_score'        => 'Din poäng är $1 av $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 poäng|$2 poäng}}',
	'quiz_reset'        => 'Återställ',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'quiz_reset' => 'மீட்டமைக்க',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author Mpradeep
 */
$messages['te'] = array(
	'quiz_desc'         => 'క్విజ్&zwnj;ల తయారీని అనుమతిస్తుంది',
	'quiz_addedPoints'  => 'సరియైన జవాబుకి కలిపే పాయింటు(లు)',
	'quiz_cutoffPoints' => 'తప్పు జవాబుకి తీసివేసే పాయింటు(లు)',
	'quiz_ignoreCoef'   => 'ప్రశ్నల యొక్క గుణకాలని పట్టించుకోకు',
	'quiz_shuffle'      => 'ప్రశ్నలను గజిబిజిచేయి',
	'quiz_colorRight'   => 'ఒప్పు',
	'quiz_colorWrong'   => 'తప్పు',
	'quiz_colorNA'      => 'జవాబు లేదు',
	'quiz_colorError'   => 'సింటాక్సు తప్పిదం',
	'quiz_correction'   => 'దాఖలుచెయ్యి',
	'quiz_score'        => 'మీ స్కోరు $1 / $2',
	'quiz_points'       => '$1 | $2 పాయింట్(లు)',
	'quiz_reset'        => 'రీసెట్',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'quiz_desc'         => 'Эҷоди озмунҳоро мумкин месозад',
	'quiz_addedPoints'  => 'Имтиёзи ҳар посухи дуруст',
	'quiz_cutoffPoints' => 'Имтиёзи манфии ҳар посухи нодуруст',
	'quiz_ignoreCoef'   => 'Нодида гирифтани зариби саволҳо',
	'quiz_shuffle'      => 'Бар задани саволҳо',
	'quiz_colorRight'   => 'Дуруст',
	'quiz_colorWrong'   => 'Нодуруст',
	'quiz_colorNA'      => 'Посух дода нашуд',
	'quiz_colorError'   => 'Хатои наҳвӣ',
	'quiz_correction'   => 'Ирсол',
	'quiz_score'        => 'Имтиёзи шумо $1 аз $2 аст',
	'quiz_points'       => '$1 | $2 имтиёз',
	'quiz_reset'        => 'Аз нав',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'quiz_colorRight' => 'ถูกต้อง',
	'quiz_colorWrong' => 'ผิด',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Runningfridgesrule
 */
$messages['tr'] = array(
	'quiz_colorRight' => 'Doğru',
	'quiz_colorWrong' => 'Yanlış',
	'quiz_colorNA'    => 'Cevaplandırılmadı',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'quiz_addedPoints'  => 'очко(ок) додано за правильну відповідь',
	'quiz_cutoffPoints' => 'очко(ок) віднято за неправильну відповідь',
	'quiz_ignoreCoef'   => 'Нехтувати коефіцієнтами запитань',
	'quiz_shuffle'      => 'Перемішати запитання',
	'quiz_colorRight'   => 'Правильно',
	'quiz_colorWrong'   => 'Неправильно',
	'quiz_colorNA'      => 'Нема відповіді',
	'quiz_colorError'   => 'Синтаксична помилка',
	'quiz_correction'   => 'Надіслати',
	'quiz_score'        => 'Ви набрали {{PLURAL:$1|$1 очко|$1 очки|$1 очок}} із $2',
	'quiz_points'       => '$1 | $2 {{PLURAL:$2|очко|очки|очок}}',
	'quiz_reset'        => 'Скинути',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'quiz_desc'         => 'Perméte de crear dei zughi a quiz',
	'quiz_addedPoints'  => 'Ponti zontà par ogni risposta giusta',
	'quiz_cutoffPoints' => 'Ponti cavà par ogni risposta sbaglià',
	'quiz_ignoreCoef'   => 'Ignora i coeficenti de domanda',
	'quiz_shuffle'      => 'Mìssia le domande',
	'quiz_colorRight'   => 'Giusto',
	'quiz_colorWrong'   => 'Sbaglià',
	'quiz_colorNA'      => 'Nissuna risposta',
	'quiz_colorError'   => 'Eror de sintassi',
	'quiz_correction'   => 'Corègi',
	'quiz_score'        => 'El to puntegio el xe $1 / $2',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 ponto|$2 ponti}}',
	'quiz_reset'        => 'Azzèra',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'quiz_desc'         => 'Tạo ra bài thi',
	'quiz_addedPoints'  => 'Số điểm cộng khi trả lời đúng',
	'quiz_cutoffPoints' => 'Số điểm trừ khi trả lời sai',
	'quiz_ignoreCoef'   => 'Bỏ qua hệ số của các câu hỏi',
	'quiz_shuffle'      => 'Xáo trộn các câu hỏi',
	'quiz_colorRight'   => 'Đúng',
	'quiz_colorWrong'   => 'Sai',
	'quiz_colorNA'      => 'Không trả lời',
	'quiz_colorError'   => 'Lỗi cú pháp',
	'quiz_correction'   => 'Đệ trình',
	'quiz_score'        => 'Bạn đã trúng $1 trên tổng số $2 điểm',
	'quiz_points'       => '$1 | {{PLURAL:$2|1 điểm|$2 điểm}}',
	'quiz_reset'        => 'Tẩy trống',
);

/** Volapük (Volapük)
 * @author Smeira
 * @author Malafaya
 */
$messages['vo'] = array(
	'quiz_colorRight' => 'Verätik',
	'quiz_colorWrong' => 'Neverätik',
	'quiz_colorNA'    => 'No pegesagon',
	'quiz_colorError' => 'Süntagapöl',
	'quiz_correction' => 'Sedön',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'quiz_desc' => 'דערלויבט שאפן אויספרעגן',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'quiz_desc'         => '容許開小測題',
	'quiz_addedPoints'  => '答啱咗加上嘅分數',
	'quiz_cutoffPoints' => '答錯咗減去嘅分數',
	'quiz_ignoreCoef'   => '略過問題嘅系數',
	'quiz_shuffle'      => '撈亂問題',
	'quiz_colorRight'   => '啱',
	'quiz_colorWrong'   => '錯',
	'quiz_colorNA'      => '未答',
	'quiz_colorError'   => '語法錯咗',
	'quiz_correction'   => '遞交',
	'quiz_score'        => '你嘅分數係 $1 / $2',
	'quiz_points'       => '$1 | $2 分',
	'quiz_reset'        => '重設',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'quiz_desc'         => '容许建立小测题目',
	'quiz_addedPoints'  => '答对加上的分数',
	'quiz_cutoffPoints' => '答错减去的分数',
	'quiz_ignoreCoef'   => '略过问题的系数',
	'quiz_shuffle'      => '随机问题',
	'quiz_colorRight'   => '对',
	'quiz_colorWrong'   => '错',
	'quiz_colorNA'      => '未回答',
	'quiz_colorError'   => '语法错误',
	'quiz_correction'   => '递交',
	'quiz_score'        => '您的分数是 $1 / $2',
	'quiz_points'       => '$1 | $2 分',
	'quiz_reset'        => '重设',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'quiz_desc'         => '容許建立小測題目',
	'quiz_addedPoints'  => '答對加上的分數',
	'quiz_cutoffPoints' => '答錯減去的分數',
	'quiz_ignoreCoef'   => '略過問題的系數',
	'quiz_shuffle'      => '隨機問題',
	'quiz_colorRight'   => '對',
	'quiz_colorWrong'   => '錯',
	'quiz_colorNA'      => '未回答',
	'quiz_colorError'   => '語法錯誤',
	'quiz_correction'   => '遞交',
	'quiz_score'        => '您的分數是 $1 / $2',
	'quiz_points'       => '$1 | $2 分',
	'quiz_reset'        => '重設',
);

