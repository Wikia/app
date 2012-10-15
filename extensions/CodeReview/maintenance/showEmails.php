<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class CodeReviewShowEmails extends Maintenance {
	private $EmailData = array(
		'author'  => 'Author',
		'repo'    => 'Repository',
		'rev'     => 'r88888',
		'URL'     => 'http://www.example.org/CR/repo/r88888',
		'prevrev' => 'r52100',
		'prevURL'     => 'http://www.example.org/CR/repo/r52100',
		'summary' => 'This is a patch to fix a nasty bug
This is not the best commit summary but should be enough to:
* display something
* get a rough idea of message formatting
* some other thing
Follow up r52100
',
		'follow-up-summary' => 'Fix up r52100',
		'comment' => 'My comment is that this revision is obviously wrong.
You missed a lot of points there and need to revert or fix your code
',
		'oldstatus' => 'new',
		'newstatus' => 'fixme',
	);

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Show example emails for CodeReview";
	}

	public function execute() {
		$this->printSubject( '' );
		print wfMsg( 'codereview-email-body'
			, $this->EmailData['author']
			, $this->EmailData['URL']
			, $this->EmailData['rev']
			, $this->EmailData['comment']
			, $this->EmailData['summary']
		) . "\n" ;
		$this->printRule();

		$this->printSubject( 2 );
		print wfMsg( 'codereview-email-body2'
			, $this->EmailData['author']
			, $this->EmailData['prevrev']
			, $this->EmailData['URL']
			, $this->EmailData['follow-up-summary']
			, $this->EmailData['prevURL']
			, $this->EmailData['summary']
		). "\n";
		$this->printRule();

		$this->printSubject( 3 );
		print wfMsg( 'codereview-email-body3'
			, $this->EmailData['author']
			, $this->EmailData['rev']
			, $this->EmailData['oldstatus']
			, $this->EmailData['newstatus']
			, $this->EmailData['URL']
			, $this->EmailData['summary']
		). "\n";
		$this->printRule();

		$this->printSubject( 4 );
		print wfMsg( 'codereview-email-body4'
			, $this->EmailData['author']
			, $this->EmailData['rev']
			, $this->EmailData['oldstatus']
			, $this->EmailData['newstatus']
			, $this->EmailData['URL']
			, $this->EmailData['summary']
			, $this->EmailData['follow-up-summary']
		). "\n";
		$this->printRule();
	}

	/**
	 * Print the subject line.
	 * @param $type Either '', 2, 3 or 4
	 */
	function printSubject( $type ) {
		$repo = $this->EmailData['repo'];
		if( $type == 2 ) {
			$rev  = $this->EmailData['prevrev'];
		} else {
			$rev  = $this->EmailData['rev'];
		}
		printf( "Subject: %s\n\n",
			wfMsg( 'codereview-email-subj'.$type
				, $repo
				, $rev
			)
		);
	}
	function printRule() {
		print "===============================================\n";
	}
}

$maintClass = 'CodeReviewShowEmails';
require_once( DO_MAINTENANCE );
