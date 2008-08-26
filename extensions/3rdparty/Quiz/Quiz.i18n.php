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
 * Quiz is a quiz tool for mediawiki.
 *
 * To activate this extension :
 * * Create a new directory named quiz into the directory "extensions" of mediawiki.
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
$wgQuizMessages = array(
 	'en' => array(
 		'quiz_addedPoints' 		=> "Point(s) added for a correct answer",
		'quiz_cutoffPoints'		=> "Point(s) subtracted for a wrong answer",
		'quiz_ignoreCoef'		=> "Ignore the questions' coefficients",
		'quiz_shuffle'			=> "Shuffle questions",
		'quiz_colorRight'		=> "Right",
		'quiz_colorWrong'		=> "Wrong",
		'quiz_colorNA'			=> "Not answered",
		'quiz_colorError'		=> "Syntax error",
		'quiz_correction'		=> "Submit",
		'quiz_score'			=> "Your score is $1 / $2",
		'quiz_points'			=> "$1 | $2 point(s)",
		'quiz_reset'			=> "Reset"
 	),
 	'de' => array(
 		'quiz_addedPoints' 		=> "Pluspunkte für eine richtige Antwort",
		'quiz_cutoffPoints'		=> "Minuspunkte für eine falsche Antwort",
		'quiz_ignoreCoef'		=> "Ignoriere den Fragen-Koeffizienten",
		'quiz_shuffle'			=> "Fragen mischen",
		'quiz_colorRight'		=> "Richtig",
		'quiz_colorWrong'		=> "Falsch",
		'quiz_colorNA'			=> "Nicht beantwortet",
		'quiz_colorError'		=> "Syntaxfehler",
		'quiz_correction'		=> "Korrektur",
		'quiz_score'			=> "Punkte: $1 / $2",
		'quiz_points'			=> "$1 | $2 Punkte",
		'quiz_reset'			=> "Neustart"
 	),
 	'fr' => array(
 		'quiz_addedPoints' 		=> "Point(s) ajouté(s) pour une réponse juste",
		'quiz_cutoffPoints'		=> "Point(s) retiré(s) pour une réponse erronée",
		'quiz_ignoreCoef'		=> "Ignorer les coefficients des questions",
		'quiz_shuffle'			=> "Mélanger les questions",
		'quiz_colorRight'		=> "Juste",
		'quiz_colorWrong'		=> "Faux",
		'quiz_colorNA'			=> "Non répondu",
		'quiz_colorError'		=> "Erreur de syntaxe",
		'quiz_correction'		=> "Correction",
		'quiz_score'			=> "Votre score est $1 / $2",
		'quiz_points'			=> "$1 | $2 point(s)",
		'quiz_reset'			=> "Réinitialiser"
 	),
  	'id' => array(
 		'quiz_addedPoints' 		=> "Penambahan angka untuk jawaban yang benar",
		'quiz_cutoffPoints'		=> "Pengurangan angka untuk jawaban yang salah",
		'quiz_ignoreCoef'		=> "Abaikan koefisien pertanyaan",
		'quiz_shuffle'			=> "Mengacak pertanyaan",
		'quiz_colorRight'		=> "Benar",
		'quiz_colorWrong'		=> "Salah",
		'quiz_colorNA'			=> "Tak dijawab",
		'quiz_colorError'		=> "Kesalahan sintaks",
		'quiz_correction'		=> "Koreksi",
		'quiz_score'			=> "Skor Anda adalah $1 / $2",
		'quiz_points'			=> "$1 | $2 poin",
		'quiz_reset'			=> "Reset"
 	),
 	'pt' => array(
 		'quiz_addedPoints' 		=> "Ponto(s) adicionados para cada resposta certa",
		'quiz_cutoffPoints'		=> "Ponto(s) subtraídos para cada resposta errada",
		'quiz_ignoreCoef'		=> "Ignorar os coeficientes das questões",
		'quiz_shuffle'			=> "Embaralhar as questões",
		'quiz_colorRight'		=> "Corretas",
		'quiz_colorWrong'		=> "Erradas",
		'quiz_colorNA'			=> "Não respondidas",
		'quiz_colorError'		=> "Erro de sintaxe",
		'quiz_correction'		=> "Enviar",
		'quiz_score'			=> "Pontuação atual: $1 acertadas (dentre $2)",
		'quiz_points'			=> "$1 | $2 ponto(s)",
		'quiz_reset'			=> "Zerar"
 	),
	'sk' => array(
 		'quiz_addedPoints' 		=> "Bod(y) pričítané za správnu odpoveď",
		'quiz_cutoffPoints' 	=> "Bod(y) odčítané za nesprávnu odpoveď",
		'quiz_ignoreCoef'		=> "Ignorovať koeficienty otázok",
		'quiz_shuffle'			=> "Náhodný výber otázok",
		'quiz_colorRight'		=> "Správne",
		'quiz_colorWrong'		=> "Nesprávne",
		'quiz_colorNA'			=> "Nezodpovedané",
		'quiz_colorError'		=> "Syntaktická chyba",
		'quiz_correction'		=> "Oprava",
		'quiz_score'			=> "Vaše skóre je $1 / $2"
	),
 	'it' => array(
 	 	'quiz_addedPoints'		=> "Punti aggiunti per ogni risposta corretta",
        'quiz_cutoffPoints'		=> "Punti sottratti per ogni risposta errata",
        'quiz_ignoreCoef'		=> "Ignora i coefficienti di domanda",
        'quiz_shuffle'			=> "Mescola le domande",
        'quiz_colorRight'		=> "Giusto",
        'quiz_colorWrong'		=> "Sbagliato",
        'quiz_colorNA'			=> "Nessuna risposta",
        'quiz_colorError'		=> "Errore di sintassi",
        'quiz_correction'		=> "Correggi",
        'quiz_score'			=> "Il tuo punteggio è $1 / $2",
        'quiz_points'			=> "$1 | $2 punti",
        'quiz_reset'			=> "Reset"
	),
	'es' => array(
		'quiz_addedPoints'		=> "Puntos por cada respuesta acertada",
		'quiz_cutoffPoints'		=> "Penalización por cada respuesta errónea",
		'quiz_ignoreCoef'		=> "Ignorar los puntos de cada pregunta",
		'quiz_shuffle'			=> "Desordenar preguntas",
		'quiz_colorRight'		=> "Acertadas",
		'quiz_colorWrong'		=> "Falladas",
		'quiz_colorNA'			=> "No contestadas",
		'quiz_colorError'		=> "Error de sintaxis",
		'quiz_correction'		=> "Contestar",
		'quiz_score'			=> "Tu puntuación es de $1 / $2",
		'quiz_points'			=> "$1 | $2 punto(s)",
		'quiz_reset'			=> "Empezar de nuevo"
	)
);
?>