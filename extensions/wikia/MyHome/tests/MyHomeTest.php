<?php
class MyHomeTest extends WikiaBaseTest {

	function setUp() {
		global $wgParser;

		$this->setupFile = __DIR__ . "/../MyHome.php";
		parent::setUp();

		if ( empty($wgParser->mOptions) ) {
			$wgParser->Options(new ParserOptions());
		}
	}

	function doEdit($edit) {
		// create "fake" EditPage
		$editor = (object) array(
			'textbox1' => isset($edit['text']) ? $edit['text'] : '',
		);

		// try to get section name
		MyHome::getSectionName($editor, '', !empty($edit['section']) ? $edit['section'] : false, $errno);

		// create "fake" RecentChange object
		$row = (object) array(
			'rev_timestamp' => time(),
			'rev_user' => 1,
			'rev_user_text' => 'test',
			'page_namespace' => NS_MAIN,
			'page_title' => 'Test',
			'rev_comment' => isset($edit['comment']) ? $edit['comment'] : '',
			'rev_minor_edit' => true,
			'page_is_new' => !empty($edit['is_new']),
			'page_id' => 1,
			'rev_id' => 1,
			'rc_id' => 1,
			'rc_patrolled' => 1,
			'rc_old_len' => 1,
			'rc_new_len' => 1,
			'rc_deleted' => 1,
			'rc_timestamp' => time(),
		);
		$rc = RecentChange::newFromCurRow($row);

		// call MyHome to add its data to rc object and Wikia vars
		MyHome::storeInRecentChanges($rc);

		$data = Wikia::getVar('rc_data');

		unset( $data['articleComment'] );

		return $data;
	}

	/**
	 * @group UsingDB
	 */
	function testNewPageCreation() {
		// set content of new article
		global $wgParser;

		$wgParser->clearState();
		$wgParser->getOutput()->setText('<p>new content</p>');

		$edit = array(
			'is_new' => true,
		);

		$out = array(
			'intro' => 'new content',
		);

		$this->assertEquals(
			$out,
			$this->doEdit($edit)
		);
	}

	function testEditFromViewMode() {
		Wikia::setVar('EditFromViewMode', true);

		$edit = array();

		$out = array(
			'viewMode' => 1,
			'CategorySelect' => 1
		);

		$this->assertEquals(
			$out,
			$this->doEdit($edit)
		);

		// cleanup
		Wikia::unsetVar('EditFromViewMode');
	}

	function testSectionEditWithComment() {
		$edit = array(
			'text' => "== foo ==\n",
			'section' => 1,
			'comment' => 'comment',
		);

		$out = array(
			'sectionName' => ' foo ',
			'summary' => 'comment',
		);

		$this->assertEquals(
			$out,
			$this->doEdit($edit)
		);
	}

	function testSectionEditWithDefaultComment() {
		$edit = array(
			'text' => "=== foo bar ===\n",
			'section' => 1,
			'comment' => '/* foo */',
		);

		$out = array(
			'sectionName' => ' foo bar ',
		);

		$this->assertEquals(
			$out,
			$this->doEdit($edit)
		);
	}

	function testRollback() {
		$rollbackRevId = rand();
		Wikia::setVar('RollbackedRevId', $rollbackRevId);

		$edit = array();

		$out = array(
			'rollback' => true,
			'revId' => $rollbackRevId,
		);

		$this->assertEquals(
			$out,
			$this->doEdit($edit)
		);

		// cleanup
		Wikia::unsetVar('RollbackedRevId');
	}

	function testAutosummaryType() {
		Wikia::setVar('AutoSummaryType', 'autosumm-replace');

		$edit = array();

		$out = array(
			'autosummaryType' => 'autosumm-replace',
		);

		$this->assertEquals(
			$out,
			$this->doEdit($edit)
		);

		// cleanup
		Wikia::unsetVar('AutoSummaryType');
	}

	function testPackData() {
		$in = array('foo' => 'bar');
		$out = MyHome::CUSTOM_DATA_PREFIX . '{"foo":"bar"}';

		$this->assertEquals(
			$out,
			MyHome::packData($in)
		);
	}

	function testUnpackData() {
		$in = MyHome::CUSTOM_DATA_PREFIX . '{"foo":"bar"}';
		$out = array('foo' => 'bar');

		$this->assertEquals(
			$out,
			MyHome::unpackData($in)
		);
	}
}
