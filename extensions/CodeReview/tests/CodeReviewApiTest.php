<?php

/**
 * This should let us test the CodeReview API
 * Broken as of 2011-09-02
 */
class CodeReviewApiTest extends ApiTestCase {

	/** The test repository created by CodeReviewApiTest::createRepo() */
	private $repo;
	/** array of common parameters used to query API */
	private $commonApiData;

	function setUp() {
		parent::setUp();
		$this->doLogin();
		$this->createRepo();
		$this->commonApiData = array(
			'repo' => 'Test',
			'format' => 'json',
		);
	}

	function tearDown() {
		parent::tearDown();
		//TODO:
		//$this->destroyRepo();
	}

	private function createRepo() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'code_repo',
			array(
				'repo_name' => 'Test',
				'repo_path' => 'somewhere',
				'repo_viewvc'   => 'http://example.com/view/',
				'repo_bugzilla' => 'http://www.example.com/$1',
			),
			__METHOD__
		);
		$id = $dbw->insertId();

		$this->repo = CodeRepository::newFromId( $id );

		# Now insert a revision
		$row = new StdClass();
		$row->cr_repo_id = $this->repo->getId();
		$row->cr_id = 777;
		$row->cr_author = 'hashar';
		$row->cr_timestamp = '20110731063300';
		$row->cr_message = 'I am the very first revision of this life';
		$row->cr_status = '';
		$row->cr_path = '/trunk/';

		$rev = CodeRevision::newFromRow( $this->repo, $row );
		$rev->save();
	}

	/**
	 * @group Broken
	 * Send a backtrace:
	 * MWException: Empty $mTitle in OutputPage::parse
	 * Caused because our wgOut object does not have a title thus a call to
	 * $wgOut->parse() backtrace :b
	 */
	function testAddInlineComment() {
		$data = $this->doApiRequest( array(
			'action' => 'coderevisionupdate',
			'rev' => 777,
			'comment' => 'Awesome comment',

		) + $this->commonApiData );

		//$this->assertArrayHasKey( 'key', $data );
	}
}
