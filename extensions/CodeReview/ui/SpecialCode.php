<?php

/**
 * Main UI entry point. This calls the appropriate CodeView subclass and runs it
 */
class SpecialCode extends SpecialPage {
	public function __construct() {
		parent::__construct( 'Code' , 'codereview-use' );
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser;

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();
		// Base styles used for all code review UI actions.
		$wgOut->addModules( 'ext.codereview' );
		$wgOut->addModules( 'ext.codereview.tooltips' );
		$wgOut->addModuleStyles( 'ext.codereview.styles' );

		$view = $this->getViewFrom( $subpage );
		if( $view ) {
			$view->execute();
		} else {
			$wgOut->addWikiMsg( 'nosuchactiontext' );
			$wgOut->returnToMain( null, $this->getTitle() );
			return;
		}

		// Add subtitle for easy navigation
		if ( $view instanceof CodeView ) {
			$repo = $view->getRepo();

			if ( $repo ) {
				$wgOut->setSubtitle(
					wfMsgExt( 'codereview-subtitle', 'parse', CodeRepoListView::getNavItem( $repo ) )
				);
			}
		}
	}

	/**
	 * Get a view object from a sub page path.
	 * @return CodeView object or null if no valid action could be found
	 */
	private function getViewFrom( $subpage ) {
		global $wgRequest;

		// Defines the classes to use for each view type.
		// The first class name is used if no additional parameters are provided.
		// The second, if defined, is used if there is an additional parameter.  If
		// there is no second class defined, then the first class is used in both 
		// cases.
		static $paramClasses 
			= array(
				'tag' => array( "CodeTagListView", "CodeRevisionTagView" ),
				'author' => array( "CodeAuthorListView", "CodeRevisionAuthorView" ),
				'status' => array( "CodeStatusListView", "CodeRevisionStatusView" ),
				'comments' => array( "CodeCommentsListView" ),
				'statuschanges' => array( "CodeStatusChangeListView" ),
				'releasenotes' => array( "CodeReleaseNotes" ),
				'stats' => array( "CodeRepoStatsView" ),
			);

		# Remove stray slashes
		$subpage = preg_replace( '/\/$/', '', $subpage );
		if ( $subpage == '' ) {
			$view = new CodeRepoListView();
		} else {
			$params = explode( '/', $subpage );

			$repo = CodeRepository::newFromName( $params[0] );
			// If a repository was specified, but it does not exist, redirect to the
			// repository list with an appropriate message.
			if ( !$repo ) {
				$view = new CodeRepoListView();
				global $wgOut;
				$wgOut->addWikiMsg( 'code-repo-not-found', wfEscapeWikiText( $params[0] ) );
				return $view;
			}

			switch( count( $params ) ) {
			case 1:
				$view = new CodeRevisionListView( $repo );
				break;
			case 2:		// drop through...
			case 3:
				if ( isset( $paramClasses[$params[1]] ) ) {
					$row = $paramClasses[$params[1]];
					if ( isset( $params[2] ) && isset( $row[1] ) ) {
						$view = new $row[1]( $repo, $params[2] );
					} else {
						$view = new $row[0]( $repo );
					}
				} elseif ( $wgRequest->wasPosted() && !$wgRequest->getCheck( 'wpPreview' ) ) {
					# This is not really a view, but we return it nonetheless.
					# Add any tags, Set status, Adds comments
					$view = new CodeRevisionCommitter( $repo, $params[1] );
				} elseif ( empty( $params[1] ) ) {
					$view = new CodeRevisionListView( $repo );
				} else {
					$view = new CodeRevisionView( $repo, $params[1] );
				}
				break;
			case 4:
				if ( $params[1] === 'author' && $params[3] === 'link' ) {
					$view = new CodeRevisionAuthorLink( $repo, $params[2] );
					break;
				} elseif ( $params[1] === 'comments' ) {
					$view = new CodeCommentsAuthorListView( $repo, $params[3]  );
					break;
				} elseif ( $params[1] === 'statuschanges' ) {
					$view = new CodeStatusChangeAuthorListView( $repo, $params[3] );
					break;
				}
			default:
				if ( $params[2] == 'reply' ) {
					$view = new CodeRevisionView( $repo, $params[1], $params[3] );
					break;
				}
				return null;
			}
		}
		return $view;
	}
}

