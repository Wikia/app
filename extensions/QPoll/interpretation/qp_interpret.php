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

class qp_Interpret {

	/**
	 * Lint the code of specified language by appropriate interpretator
	 * @param   $lang  string language key (eg. 'php')
	 * @param   $code  string source code
	 * @return  bool   true, when code has no syntax errors;
	 *          string  error message from lint
	 */
	static function lint( $lang, $code ) {
		switch ( $lang ) {
		case 'php' :
			return qp_Eval::lint( $code );
		default :
			# unknown languages syntax is "valid" because it cannot be checked
			return true;
		}
	}

	/**
	 * Glues the content of <qpinterpret> tags together, checks "lang" attribute
	 * and calls appropriate interpretator to evaluate the user answer
	 *
	 * @param $interpArticle  _existing_ Article with interpretation script enclosed in <qpinterp> tags
	 * @param $injectVars  array with the following possible keys:
	 *                     key 'answer' array of user selected categories for
	 *                     every proposal & question of the poll;
	 *                     key 'usedQuestions' array of used questions for randomized polls
	 *                     or false, when the poll questions were not randomized
	 * @return instance of qp_InterpResult class (interpretation result)
	 */
	static function getResult( Article $interpArticle, array $injectVars ) {
		global $wgParser, $wgContLang;
		$matches = array();
		# extract <qpinterpret> tags from the article content
		$wgParser->extractTagsAndParams( array( qp_Setup::$interpTag ), $interpArticle->getRawText(), $matches );
		$interpResult = new qp_InterpResult();
		# glue content of all <qpinterpret> tags at the page together
		$interpretScript = '';
		$lang = '';
		foreach ( $matches as &$match ) {
			list( $tagName, $content, $attrs ) = $match;
			# basic checks for lang attribute (only lang="php" is implemented yet)
			# however we do not want to limit interpretation language,
			# so the attribute is enforced to use
			if ( !isset( $attrs['lang'] ) ) {
				return $interpResult->setError( wfMsg( 'qp_error_eval_missed_lang_attr' ) );
			}
			if ( $lang == '' ) {
				$lang = $attrs['lang'];
			} elseif ( $attrs['lang'] != $lang ) {
				return $interpResult->setError( wfMsg( 'qp_error_eval_mix_languages', $lang, $attrs['lang'] ) );
			}
			if ( $tagName == qp_Setup::$interpTag ) {
				$interpretScript .= $content;
			}
		}
		switch ( $lang ) {
		case 'php' :
			$result = qp_Eval::interpretAnswer( $interpretScript, $injectVars, $interpResult );
			if ( $result instanceof qp_InterpResult ) {
				# evaluation error (environment error) , return it;
				return $interpResult;
			}
			break;
		default :
			return $interpResult->setError( wfMsg( 'qp_error_eval_unsupported_language', $lang ) );
		}
		/*** process the result ***/
		if ( !is_array( $result ) ) {
			return $interpResult->setError( wfMsg( 'qp_error_interpretation_no_return' ) );
		}
		if ( isset( $result['options'] ) &&
				is_array( $result['options'] ) &&
				array_key_exists( 'store_erroneous', $result['options'] ) ) {
			$interpResult->storeErroneous = (boolean) $result['options']['store_erroneous'];
		}
		if ( isset( $result['error'] ) && is_array( $result['error'] ) ) {
			# initialize $interpResult->qpcErrors[] member array
			foreach ( $result['error'] as $qidx => $question ) {
				if ( is_array( $question ) ) {
					foreach ( $question as $pidx => $prop_error ) {
						# integer indicates proposal id; string - proposal name
						if ( is_array( $prop_error ) ) {
							# separate error messages list for proposal categories
							foreach ( $prop_error as $cidx => $cat_error ) {
								$interpResult->setQPCerror( $cat_error, $qidx, $pidx, $cidx );
							}
						} else {
							# error message for the whole proposal line
							$interpResult->setQPCerror( $prop_error, $qidx, $pidx );
						}
					}
				}
			}
		}
		if ( isset( $result['errmsg'] ) && trim( strval( $result['errmsg'] ) ) != '' ) {
			# script-generated error message for the whole answer
			return $interpResult->setError( (string) $result['errmsg'] );
		}
		# if there were question/proposal errors, return them;
		if ( $interpResult->isError() ) {
			return $interpResult->setDefaultErrorMessage();
		}
		$interpCount = 0;
		foreach ( qp_Setup::$show_interpretation as $interpType => $show ) {
			if ( isset( $result[$interpType] ) ) {
				$interpCount++;
			}
		}
		if ( $interpCount == 0 ) {
			return $interpResult->setError( wfMsg( 'qp_error_interpretation_no_return' ) );
		}
		$interpResult->structured = isset( $result['structured'] ) ? serialize( $result['structured'] ) : '';
		if ( strlen( $interpResult->structured ) > qp_Setup::$field_max_len['serialized_interpretation'] ) {
			# serialized structured interpretation is too long and
			# this type of interpretation cannot be truncated
			unset( $interpResult->structured );
			return $interpResult->setError( wfMsg( 'qp_error_structured_interpretation_is_too_long' ) );
		}
		$interpResult->short = isset( $result['short'] ) ? strval( $result['short'] ) : '';
		$interpResult->long = isset( $result['long'] ) ? strval( $result['long'] ) : '';
		if ( strlen( $interpResult->long ) > qp_Setup::$field_max_len['long_interpretation'] ) {
			$interpResult->long = $wgContLang->truncate( $interpResult->long, qp_Setup::$field_max_len['long_interpretation'] , '' );
		}
		return $interpResult;
	}

} /* end of qp_Interpret class */
