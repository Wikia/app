<?php
/**
 * Repository administration
 */
class SpecialRepoAdmin extends SpecialPage {
	public function __construct() {
		parent::__construct( 'RepoAdmin', 'repoadmin' );
	}

	public function execute( $subpage ) {
		global $wgRequest, $wgUser;

		$this->setHeaders();

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$repo = $wgRequest->getVal( 'repo', $subpage );
		if ( $repo == '' ) {
			$view = new RepoAdminListView( $this->getTitle() );
		} else {
			$view = new RepoAdminRepoView( $this->getTitle( $repo ), $repo );
		}
		$view->execute();
	}
}

/**
 * View for viewing all of the repositories
 */
class RepoAdminListView {
	/**
	 * Reference to Special:RepoAdmin
	 * @var Title
	 */
	private $title;

	/**
	 * Constructor
	 * @param $t Title object referring to Special:RepoAdmin
	 */
	public function __construct( Title $t ) {
		$this->title = $t;
	}

	/**
	 * Get "create new repo" form
	 * @return String
	 */
	private function getForm() {
		global $wgScript;
		return Xml::fieldset( wfMsg( 'repoadmin-new-legend' ) ) .
			Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) ) .
			Html::hidden( 'title', $this->title->getPrefixedDBKey() ) .
			Xml::inputLabel( wfMsg( 'repoadmin-new-label' ), 'repo', 'repo' ) .
			Xml::submitButton( wfMsg( 'repoadmin-new-button' ) ) .
			'</form></fieldset>';
	}

	public function execute() {
		global $wgOut;
		$wgOut->addHTML( $this->getForm() );
		$repos = CodeRepository::getRepoList();
		if ( !count( $repos ) ) {
			return;
		}
		$text = '';
		foreach ( $repos as $repo ) {
			$name = $repo->getName();
			$text .= "* [[Special:RepoAdmin/$name|$name]]\n";
		}
		$wgOut->addWikiText( $text );
	}
}

/**
 * View for editing a single repository
 */
class RepoAdminRepoView {
	/**
	 * Reference to Special:RepoAdmin
	 * @var Title
	 */
	private $title;

	/**
	 * Human-readable name of the repository
	 * @var String
	 */
	private $repoName;

	/**
	 * Actual repository object
	 */
	private $repo;

	/**
	 * @
	 * @param $page Title Special page title (with repo subpage)
	 * @param $repo
	 */
	public function __construct( Title $t, $repo ) {
		$this->title = $t;
		$this->repoName = $repo;
		$this->repo = CodeRepository::newFromName( $repo );
	}

	function execute() {
		global $wgOut, $wgRequest, $wgUser;
		$repoExists = (bool)$this->repo;
		$repoPath = $wgRequest->getVal( 'wpRepoPath', $repoExists ? $this->repo->getPath() : '' );
		$bugPath = $wgRequest->getVal( 'wpBugPath', $repoExists ? $this->repo->getBugzillaBase() : '' );
		$viewPath = $wgRequest->getVal( 'wpViewPath', $repoExists ? $this->repo->getViewVcBase() : '' );
		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ), $this->repoName ) ) {
			// @todo log
			$dbw = wfGetDB( DB_MASTER );
			if ( $repoExists ) {
				$dbw->update(
					'code_repo',
					array(
						'repo_path' => $repoPath,
						'repo_viewvc' => $viewPath,
						'repo_bugzilla' => $bugPath
					),
					array( 'repo_id' => $this->repo->getId() ),
					__METHOD__
				);
			} else {
				$dbw->insert(
					'code_repo',
					array(
						'repo_name' => $this->repoName,
						'repo_path' => $repoPath,
						'repo_viewvc' => $viewPath,
						'repo_bugzilla' => $bugPath
					),
					__METHOD__
				);
			}
			$wgOut->wrapWikiMsg( '<div class="successbox">$1</div>', array( 'repoadmin-edit-sucess', $this->repoName ) );
			return;
		}
		$wgOut->addHTML(
			Xml::fieldset( wfMsg( 'repoadmin-edit-legend', $this->repoName ) ) .
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->title->getLocalURL() ) ) .
			Xml::buildForm(
				array(
					'repoadmin-edit-path' =>
						Xml::input( 'wpRepoPath', 60, $repoPath, array( 'dir' => 'ltr') ),
					'repoadmin-edit-bug' =>
						Xml::input( 'wpBugPath', 60, $bugPath, array( 'dir' => 'ltr') ),
					'repoadmin-edit-view' =>
						Xml::input( 'wpViewPath', 60, $viewPath, array( 'dir' => 'ltr') ) ) ) .
			Html::hidden( 'wpEditToken', $wgUser->editToken( $this->repoName ) ) .
			Xml::submitButton( wfMsg( 'repoadmin-edit-button' ) ) .
			'</form></fieldset>'
		);
	}
}
