<?php

class CodeTestSuite {
	public static function newFromRow( CodeRepository $repo, $row ) {
		$suite = new CodeTestSuite();
		$suite->id = intval( $row->ctsuite_id );
		$suite->repo = $repo;
		$suite->repoId = $repo->getId();
		$suite->branchPath = $row->ctsuite_branch_path;
		$suite->name = $row->ctsuite_name;
		$suite->desc = $row->ctsuite_desc;
		return $suite;
	}
	
	function getRun( $revId ) {
		return CodeTestRun::newFromRevId( $this, $revId );
	}

	function setStatus( $revId, $status ) {
		$run = $this->getRun( $revId );
		if( $run ) {
			$run->setStatus( $status );
		} else {
			$run = CodeTestRun::insertRun( $this, $revId, $status );
		}
		return $run;
	}
	
	function saveResults( $revId, $results ) {
		$run = $this->getRun( $revId );
		if( $run ) {
			$run->saveResults( $results );
		} else {
			$run = CodeTestRun::insertRun( $this, $revId, "complete", $results );
		}
		$breakage = false;
		// Email test case breakers
		$runPrev = $this->getRun( $revId - 1 ); // previous results
		if( $runPrev ) {
			$oldPassed = $runPrev->getResults( true ); // tests that passed before
			foreach( $oldPassed as $test ) {
				// If this test is still there, worked before, and failed now...we have a problem
				if( array_key_exists($test->caseName,$results) && !$results[$test->caseName] ) {
					$breakage = true;
					break;
				}
			}
		}
		// Email the committer of the broken revision
		if( $breakage ) {
			$codeRev = $this->repo->getRevision( $revId );
			if( !$codeRev ) return $run; // wtf?
			$user = $codeRev->getWikiUser();
			// User must exist on wiki and have a valid email addy
			if( $user && $user->canReceiveEmail() ) {
				wfLoadExtensionMessages( 'CodeReview' );
				// Send message in receiver's language
				// Get repo and build comment title (for url)
				$title = SpecialPage::getTitleFor( 'Code', $this->repo->getName() . '/' . $revId );
				$url = $title->getFullUrl();
				$lang = array( 'language' => $user->getOption( 'language' ) );
				$user->sendMail(
					wfMsgExt( 'codereview-email-subj3', $lang, $this->repo->getName(), $revId ),
					wfMsgExt( 'codereview-email-body3', $lang, $revId, $url, $codeRev->getMessage() )
				);
			}
		}
		return $run;
	}
}
