<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Contains the iterable collection of questions with possible randomization
 * (optional selection of some random questions from the whole set)
 */
class qp_QuestionCollection {

	/**
	 * Note:
	 * We assume that $questions and $usedQuestions do not have sparce keys
	 * I was using internal indexes but each() was buggy and evil even in PHP 5.3.x
	 */

	# array of question objects associated with current poll
	private $questions = array();
	# current questions key, starting from 1
	private $qKey;
	# array of $this->questions[] indexes for question iterator (used by randomizer)
	private $usedQuestions = false;
	# current usedQuestions key, starting from 0
	private $usedKey;

	/**
	 * From http://php.net/manual/en/function.mt-rand.php
	 * function returns a random integer between min and max, just like function rand() does.
	 * Difference to rand is that the random generated number will not use any of the values
	 * placed in $except. ($except must therefore be an array)
	 * function returns false if $except holds all values between $min and $max.
	 */
	function rand_except( $min, $max, array $except ) {
		# first sort array values
		sort( $except, SORT_NUMERIC );
		# calculate average gap between except-values
		$except_count = count( $except );
		$avg_gap = ( $max - $min + 1 - $except_count ) / ( $except_count + 1 );
		if ( $avg_gap <= 0 ) {
			return false;
		}
		# now add min and max to $except, so all gaps between $except-values can be calculated
		array_unshift( $except, $min - 1 );
		array_push( $except, $max + 1 );
		$except_count += 2;
		# iterate through all values of except. If gap between 2 values is higher than average gap,
		# create random in this gap
		for ( $i = 1; $i < $except_count; $i++ ) {
			if ( $except[$i] - $except[$i - 1] - 1 >= $avg_gap ) {
				return mt_rand( $except[$i - 1] + 1, $except[$i] - 1 );
			}
		}
		return false;
	}

	function randomize( $randomQuestionCount ) {
		$questionCount = count( $this->questions );
		if ( $randomQuestionCount > $questionCount ) {
			$randomQuestionCount = $questionCount;
		}
		$this->usedQuestions = array();
		for ( $i = 0; $i < $randomQuestionCount; $i++ ) {
			if ( ( $r = $this->rand_except( 1, $questionCount, $this->usedQuestions ) ) === false ) {
				throw new MWException( 'Bug: too many random questions in ' . __METHOD__ );
			}
			$this->usedQuestions[] = $r;
		}
		sort( $this->usedQuestions, SORT_NUMERIC );
		if ( count( $this->usedQuestions ) === 0 ) {
			$this->usedQuestions = false;
		}
	}

	function getUsedQuestions() {
		return $this->usedQuestions;
	}

	function setUsedQuestions( $randomQuestions ) {
		if ( !is_array( $randomQuestions ) ) {
			foreach ( $this->questions as $qidx => $question ) {
				$question->usedId = $question->mQuestionId;
			}
			return;
		}
		sort( $randomQuestions, SORT_NUMERIC );
		$this->usedQuestions = array();
		# questions keys start from 1
		$usedId = 1;
		foreach ( $this->questions as $qidx => $question ) {
			if ( in_array( $qidx, $randomQuestions, true ) ) {
				# usedQuestions keys start from 0
				$this->usedQuestions[] = $qidx;
				$question->usedId = $usedId++;
			} else {
				$question->usedId = false;
			}
		}
		if ( count( $this->usedQuestions ) === 0 ) {
			throw new MWException( 'At least one question should not be unused in ' . __METHOD__ );
		}
	}

	function add( qp_AbstractQuestion $question ) {
		if ( count( $this->questions ) === 0 ) {
			$this->questions[1] = $question;
		} else {
			$this->questions[] = $question;
		}
	}

	function totalCount() {
		return count( $this->questions );
	}

	function usedCount() {
		$used = 0;
		foreach ( $this->questions as $question ) {
			if ( $question->usedId !== false ) {
				$used++;
			}
		}
		return $used;
	}

	/**
	 * Reset question iterator
	 */
	function reset() {
		$this->qKey = 1;
		if ( is_array( $this->usedQuestions ) ) {
			$this->usedKey = 0;
		}
	}

	/**
	 * Get current question and rewind to the next question
	 * @return instance of qp_AbstractQuestion or derivative or
	 *         boolean false - when there are no more questions left
	 */
	function iterate() {
		if ( is_array( $this->usedQuestions ) ) {
			while ( array_key_exists( $this->usedKey, $this->usedQuestions ) ) {
				$qidx = $this->usedQuestions[$this->usedKey++];
				if ( isset( $this->questions[$qidx] ) ) {
					return $this->questions[$qidx];
				}
			}
			return false;
		}
		if ( array_key_exists( $this->qKey, $this->questions ) ) {
			$question = $this->questions[$this->qKey++];
			return $question;
		}
		return false;
	}

}
