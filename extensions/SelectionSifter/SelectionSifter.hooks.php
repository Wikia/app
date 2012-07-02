<?php
/**
 *
 * @file
 * @ingroup Extensions
 * @author Yuvi Panda, http://yuvi.in
 * @copyright © 2011 Yuvaraj Pandian (yuvipanda@yuvi.in)
 * @licence Modified BSD License
 */

class SelectionSifterHooks {
	private static function updateDatabase( $title, $assessments, $timestamp ) {
		$main_title = Title::makeTitle( NS_MAIN, $title->getText() );
		$ratings = Rating::forTitle( $main_title );
		foreach ( $assessments as $project => $assessment ) {
			$curRating = $ratings[$project];
			if( $curRating ) {
				$curRating->update( $assessment['importance'], $assessment['quality'], $timestamp );
			} else {
				$rating = new Rating(
					$project, 
					$main_title->getNamespace(),
					$main_title->getText(),
					$assessment['quality'],
					$timestamp,
					$assessment['importance'],
					$timestamp
				);
				$rating->saveAll();
				
				if( isset( $assessment['quality'] ) ) {
					AssessmentChangeLog::makeEntry(
						$project,
						$main_title->getNamespace(),
						$main_title->getText(),
						$timestamp,
						"quality",
						"",
						$assessment['quality'],
						$timestamp
					);
				}
				if( isset( $assessment['importance'] ) ) {
					AssessmentChangeLog::makeEntry(
						$project,
						$main_title->getNamespace(),
						$main_title->getText(),
						$timestamp,
						"importance",
						"",
						$assessment['importance'],
						$timestamp
					);
				}
			}
		}
	}

	public static function TitleMoveComplete( &$title, &$newtitle, &$user, $oldid, $newid ) {
		Rating::moveArticle( $title, $newtitle );
		return true;
	}

	public static function ArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgParser;
		$title = $article->getTitle();
		if( $title->getNamespace() == NS_TALK && $revision ) {
			// All conditions to minimize the situations we've to run the job to update the data
			$preparedText = $article->prepareTextForEdit( $text )->output->getText();
			$extractor = new AssessmentsExtractor( $preparedText );
			$assessments = $extractor->extractAssessments();
			SelectionSifterHooks::updateDatabase( $title, $assessments, wfTimestamp( TS_MW, $revision->getTimestamp() ) );
		}
		return true;
	}

	public static function SetupSchema( DatabaseUpdater $du ) {
		$base = dirname( __FILE__ ) . '/schema';
		$du->addExtensionTable( "ratings", "$base/ratings.sql");
		$du->addExtensionTable( "project_stats", "$base/project_stats.sql" );
		$du->addExtensionTable( "assessment_changelog", "$base/log.sql" );
		$du->addExtensionTable( "selections", "$base/selections.sql" );
		return true;
	}
}
