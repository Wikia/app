<?php

define( 'MW_SEARCH_LIMIT', 50 );

require_once( './lib/HTTP/WebDAV/Server.php' );

class WebDavServer extends HTTP_WebDAV_Server {

	function init() {
		parent::init();

		# Prepend script path component to path components
		array_unshift( $this->pathComponents, array_pop( $this->baseUrlComponents['pathComponents'] ) );
	}

	function getAllowedMethods() {
		return array( 'OPTIONS', 'PROPFIND', 'GET', 'HEAD', 'DELETE', 'PUT', 'REPORT', 'SEARCH' );
	}

	function options( &$serverOptions ) {
		parent::options( &$serverOptions );

		if ( $serverOptions['xpath']->evaluate( 'boolean(/D:options/D:activity-collection-set)' ) ) {
			$this->setResponseHeader( 'Content-Type: text/xml; charset="utf-8"' );

			echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
			echo "<D:options-response xmlns:D=\"DAV:\">\n";
			echo '  <D:activity-collection-set><D:href>' . $this->getUrl( array( 'path' => 'deltav.php/act' ) ) . "</D:href></D:activity-collection-set>\n";
			echo "</D:options-response>\n";
		}

		return true;
	}

	function propfind( &$serverOptions ) {
		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'deltav.php' && $pathComponent != 'webdav.php' ) {
			return;
		}

		if ( $pathComponent == 'deltav.php' ) {
			if ( empty( $this->pathComponents ) ) {
				return;
			}
			$pathComponent = array_shift( $this->pathComponents );
			if ( $pathComponent != 'bc' && $pathComponent != 'bln' && $pathComponent != 'vcc' && $pathComponent != 'ver' ) {
				return;
			}

			if ( $pathComponent == 'vcc' ) {
				if ( empty( $this->pathComponents ) ) {
					return;
				}
				$pathComponent = array_shift( $this->pathComponents );
				if ( $pathComponent != 'default' ) {
					return;
				}
				if ( !empty( $this->pathComponents ) ) {
					return;
				}

				if ( isset( $serverOptions['label'] ) ) {
					return $this->propfindBln( $serverOptions, $serverOptions['label'] );
				}

				return $this->propfindVcc( $serverOptions );
			}

			if ( empty( $this->pathComponents ) ) {
				return;
			}
			$revisionId = array_shift( $this->pathComponents );

			if ( $pathComponent == 'bc' ) {
				return $this->propfindBc( $serverOptions, $revisionId, $this->pathComponents );
			}

			if ( !empty( $this->pathComponents ) ) {
				return;
			}

			if ( $pathComponent == 'bln' ) {
				return $this->propfindBln( $serverOptions, $revisionId );
			}

			return $this->propfindVer( $serverOptions, $revisionId );
		}

		if ( isset( $serverOptions['label'] ) ) {
			# TODO: Verify revision belongs to this resource, or should we care?
			return $this->propfindVer( $serverOptions, $serverOptions['label'] );
		}

		$serverOptions['namespaces']['http://subversion.tigris.org/xmlns/dav/'] = 'V';

		$status = array();

		# Handle root collection
		if ( empty( $this->pathComponents ) ) {
			global $wgSitename;

			$response = array();
			$response['path'] = 'webdav.php/';

			# TODO: Use Main_Page revision?
			$response['props'][] = WebDavServer::mkprop( 'checked-in', $this->getUrl( array( 'path' => 'deltav.php/ver' ) ) );

			$response['props'][] = WebDavServer::mkprop( 'displayname', $wgSitename );
			$response['props'][] = WebDavServer::mkprop( 'getcontentlength', 0 );
			$response['props'][] = WebDavServer::mkprop( 'getcontenttype', 'httpd/unix-directory' );
			$response['props'][] = WebDavServer::mkprop( 'resourcetype', 'collection' );
			$response['props'][] = WebDavServer::mkprop( 'version-controlled-configuration', $this->getUrl( array( 'path' => 'deltav.php/vcc/default' ) ) );

			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'baseline-relative-path', null );

			# TODO: Don't hardcode this
			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'repository-uuid', '87a9137c-6795-46f8-83b9-2ee953e66e08' );

			$status[] = $response;

			# Don't descend if depth is zero
			if ( empty( $serverOptions['depth'] ) ) {
				return $status;
			}
		}

		# TODO: Use $wgMemc
		$dbr =& wfGetDB( DB_SLAVE );

		# TODO: Think harder about pages' hierarchical structure.  The trouble is most filesystems don't support directories which themselves have file content, which is a problem for making pages descendents of other pages.
		$where = array();
		if ( !empty( $this->pathComponents ) ) {
			$where[] = 'page_title = ' . $dbr->addQuotes( implode( '/', $this->pathComponents ) );
		}

		$whereClause = null;
		if ( !empty( $where ) ) {
			$whereClause = ' WHERE ' . implode( ' AND ', $where );
		}
		$results = $dbr->query( '
			SELECT page_title, page_latest, page_len, page_touched
			FROM page' . $whereClause );

		while ( ( $result = $dbr->fetchRow( $results ) ) !== false ) {
			# TODO: Should maybe not be using page_title as URL component, but it's currently what we do elsewhere
			$title = Title::newFromUrl( $result[0] );

			$response = array();
			$response['path'] = 'webdav.php/' . $result[0];
			$response['props'][] = WebDavServer::mkprop( 'checked-in', $this->getUrl( array( 'path' => 'deltav.php/ver/' . $result[1] ) ) );
			$response['props'][] = WebDavServer::mkprop( 'displayname', $title->getText() );
			$response['props'][] = WebDavServer::mkprop( 'getcontentlength', $result[2] );
			$response['props'][] = WebDavServer::mkprop( 'getcontenttype', 'text/x-wiki' );
			$response['props'][] = WebDavServer::mkprop( 'getlastmodified', wfTimestamp( TS_UNIX, $result[3] ) );
			$response['props'][] = WebDavServer::mkprop( 'resourcetype', null );
			$response['props'][] = WebDavServer::mkprop( 'version-controlled-configuration', $this->getUrl( array( 'path' => 'deltav.php/vcc/default' ) ) );

			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'baseline-relative-path', $result[0] );

			$status[] = $response;
		}

		return $status;
	}

	function propfindBc( &$serverOptions, $revisionId, $pathComponents ) {
		$serverOptions['namespaces']['http://subversion.tigris.org/xmlns/dav/'] = 'V';

		$status = array();

		# TODO: Verify $revisionId is valid
		# Handle root collection
		if ( empty( $pathComponents ) ) {
			global $wgSitename;

			$response = array();
			$response['path'] = 'deltav.php/bc/' . $revisionId . '/';
			# TODO: Use Main_Page revision?
			$response['props'][] = WebDavServer::mkprop( 'checked-in', $this->getUrl( array( 'path' => 'deltav.php/ver' ) ) );

			$response['props'][] = WebDavServer::mkprop( 'displayname', $wgSitename );
			$response['props'][] = WebDavServer::mkprop( 'getcontentlength', 0 );
			$response['props'][] = WebDavServer::mkprop( 'getcontenttype', 'httpd/unix-directory' );
			$response['props'][] = WebDavServer::mkprop( 'resourcetype', 'collection' );
			$response['props'][] = WebDavServer::mkprop( 'version-controlled-configuration', $this->getUrl( array( 'path' => 'deltav.php/vcc/default' ) ) );
			$response['props'][] = WebDavServer::mkprop( 'version-name', null );

			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'baseline-relative-path', null );

			# TODO: Don't hardcode this
			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'repository-uuid', '87a9137c-6795-46f8-83b9-2ee953e66e08' );

			$status[] = $response;

			# Don't descend if depth is zero
			if ( empty( $serverOptions['depth'] ) ) {
				return $status;
			}
		}

		# TODO: Use $wgMemc
		$dbr =& wfGetDB( DB_SLAVE );

		# TODO: Think harder about pages' hierarchical structure.  The trouble is most filesystems don't support directories which themselves have file content, which is a problem for making pages descendents of other pages.
		$where = array();
		$where[] = 'rev_page = page_id';
		$where[] = 'rev_id <= ' . $dbr->addQuotes( $revisionId );
		if ( !empty( $pathComponents ) ) {
			$where[] = 'page_title = ' . $dbr->addQuotes( implode( '/', $pathComponents ) );
		}

		$whereClause = null;
		if ( !empty( $where ) ) {
			$whereClause = ' WHERE ' . implode( ' AND ', $where );
		}
		$results = $dbr->query( '
			SELECT page_title, MAX(rev_id), page_len, page_touched
			FROM page, revision' . $whereClause . '
			GROUP BY page_id' );

		while ( ( $result = $dbr->fetchRow( $results ) ) !== false ) {
			# TODO: Should maybe not be using page_title as URL component, but it's currently what we do elsewhere
			$title = Title::newFromUrl( $result[0] );

			$response = array();
			$response['path'] = 'deltav.php/bc/' . $revisionId . '/' . $result[0];
			$response['props'][] = WebDavServer::mkprop( 'checked-in', $this->getUrl( array( 'path' => 'deltav.php/ver/' . $result[1] ) ) );
			$response['props'][] = WebDavServer::mkprop( 'displayname', $title->getText() );
			$response['props'][] = WebDavServer::mkprop( 'getcontentlength', $result[2] );
			$response['props'][] = WebDavServer::mkprop( 'getcontenttype', 'text/x-wiki' );
			$response['props'][] = WebDavServer::mkprop( 'getlastmodified', wfTimestamp( TS_UNIX, $result[3] ) );
			$response['props'][] = WebDavServer::mkprop( 'resourcetype', null );
			$response['props'][] = WebDavServer::mkprop( 'version-controlled-configuration', $this->getUrl( array( 'path' => 'deltav.php/vcc/default' ) ) );
			$response['props'][] = WebDavServer::mkprop( 'version-name', $result[1] );

			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'baseline-relative-path', $result[0] );

			# TODO: Don't hardcode this
			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'repository-uuid', '87a9137c-6795-46f8-83b9-2ee953e66e08' );

			$status[] = $response;
		}

		return $status;
	}

	function propfindBln( &$serverOptions, $revisionId ) {
		$response = array();
		$response['path'] = 'bln/' . $revisionId;
		$response['props'][] = WebDavServer::mkprop( 'baseline-collection', $this->getUrl( array( 'path' => 'deltav.php/bc/' . $revisionId . '/' ) ) );
		$response['props'][] = WebDavServer::mkprop( 'version-name', $revisionId );

		return array( $response );
	}

	function propfindVcc( &$serverOptions ) {
		# TODO: Use $wgMemc
		$dbr =& wfGetDB( DB_SLAVE );

		$results = $dbr->query( '
			SELECT MAX(rev_id)
			FROM revision' );

		if ( ( $result = $dbr->fetchRow( $results ) ) === false ) {
			return;
		}

		$response = array();
		$response['path'] = 'deltav.php/vcc/default';
		$response['props'][] = WebDavServer::mkprop( 'checked-in', $this->getUrl( array( 'path' => 'deltav.php/bln/' . $result[0] ) ) );

		return array( $response );
	}

	function propfindVer( &$serverOptions, $revisionId ) {
		$response = array();
		$response['path'] = 'deltav.php/ver/' . $revisionId;
		$response['props'][] = WebDavServer::mkprop( 'resourcetype', null );
		#$response['props'][] = WebDavServer::mkprop( 'version-controlled-configuration', $this->getUrl( array( 'path' => 'deltav.php/vcc/default' ) ) );

		#$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'baseline-relative-path', null );

		return array( $response );
	}

	function getRawPage() {
		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'deltav.php' && $pathComponent != 'webdav.php' ) {
			return;
		}

		if ( $pathComponent == 'deltav.php' ) {
			if ( empty( $this->pathComponents ) ) {
				return;
			}
			$pathComponent = array_shift( $this->pathComponents );
			if ( $pathComponent != 'bc' && $pathComponent != 'ver' ) {
				return;
			}

			if ( empty( $this->pathComponents ) ) {
				return;
			}
			$revisionId = array_shift( $this->pathComponents );

			if ( $pathComponent == 'bc' ) {
				$title = Title::newFromUrl( implode( '/', $this->pathComponents ) );
				if (!isset( $title )) {
					$title = Title::newMainPage();
				}
			} else {
				if ( !empty( $this->pathComponents ) ) {
					return;
				}

				$revision = Revision::newFromId( $revisionId );
				$title = $revision->getTitle();
			}
		} else {
			if ( isset( $serverOptions['label'] ) ) {
				# TODO: Verify revision belongs to this resource, or should we care?
				$revisionId = $serverOptions['label'];
			}

			$title = Title::newFromUrl( implode( '/', $this->pathComponents ) );
			if (!isset( $title )) {
				$title = Title::newMainPage();
			}
		}

		$mediaWiki = new MediaWiki();
		$article = $mediaWiki->articleFromTitle( $title );

		$rawPage = new RawPage( $article );

		if ( isset( $revisionId ) ) {
			$rawPage->mOldId = $revisionId;
		}
		
		return $rawPage;
	}

	# RawPage::view handles Content-Type, Cache-Control, etc. and we don't want get_response_helper to overwrite, but MediaWiki doesn't let us get response headers.  It could work if we kept setResponseHeader updated with headers_list on PHP 5.
	function get_wrapper() {
		$rawPage = $this->getRawPage();
		if ( !isset( $rawPage ) ) {
			$this->setResponseStatus( false, false );
			return;
		}

		$rawPage->view();
	}

	function head_wrapper() {
		$rawPage = $this->getRawPage();
		if ( !isset( $rawPage ) ) {
			$this->setResponseStatus( false, false );
			return;
		}

		# TODO: Does MediaWiki handle HEAD requests specially?
		ob_start();
		$rawPage->view();
		ob_end_clean();
	}

	function delete( $serverOptions ) {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'delete' ) ) {
			$this->setResponseStatus( '401 Unauthorized' );
			return;
		}

		if ( wfReadOnly() ) {
			$this->setResponseStatus( '403 Forbidden' );
			return;
		}

		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'webdav.php' ) {
			return;
		}

		$title = Title::newFromUrl( implode( '/', $this->pathComponents ) );
		if (!isset( $title )) {
			$title = Title::newMainPage();
		}

		$mediaWiki = new MediaWiki();
		$article = $mediaWiki->articleFromTitle( $title );

		# Must check if article exists to avoid 500 Internal Server Error

		# No way to get reason for deletion.  Can't use null: MySQL returned error "<tt>1048: Column 'log_comment' cannot be null (localhost)</tt>".
		$article->doDelete( null );
	}

	function put( $serverOptions ) {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'edit' ) ) {
			$this->setResponseStatus( '401 Unauthorized' );
			return;
		}

		if ( wfReadOnly() ) {
			$this->setResponseStatus( '403 Forbidden' );
			return;
		}

		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'webdav.php' ) {
			return;
		}

		$title = Title::newFromUrl( implode( '/', $this->pathComponents ) );
		if (!isset( $title )) {
			$title = Title::newMainPage();
		}

		if ( !$title->exists() && !$title->userCan( 'create' ) ) {
			$this->setResponseStatus( '401 Unauthorized' );
			return;
		}

		$mediaWiki = new MediaWiki();
		$article = $mediaWiki->articleFromTitle( $title );

		if ( ( $handle = $this->openRequestBody() ) === false ) {
			return;
		}

		$text = null;
		while ( !feof( $handle ) ) {
			if ( ( $buffer = fread( $handle, 4096 ) ) === false ) {
				return;
			}

			$text .= $buffer;
		}

		$article->doEdit( $text, null );

		return true;
	}

	function versionTreeReport( &$serverOptions ) {
		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'deltav.php' && $pathComponent != 'webdav.php' ) {
			return;
		}

		$serverOptions['props'] = array();
		foreach ( $serverOptions['xpath']->query( '/D:version-tree/D:prop/*' ) as $node) {
			$serverOptions['props'][] = $this->mkprop( $node->namespaceURI, $node->localName, null );

			# Namespace handling
			if ( empty( $node->namespaceURI ) || empty( $node->prefix ) ) {
			    continue;
			}

			# http://bugs.php.net/bug.php?id=42082
			#$serverOptions['namespaces'][$node->namespaceURI] = $node->prefix;
		}

		if (empty($serverOptions['props'])) {
			$serverOptions['props'] = $serverOptions['xpath']->evaluate( 'local-name(/D:version-tree/*)' );
		}

		$status = array();

		# Handle root collection
		if ( empty( $this->pathComponents ) ) {
			$response = array();
			$response['props'][] = WebDavServer::mkprop( 'getcontentlength', 0 );
			$response['props'][] = WebDavServer::mkprop( 'getcontenttype', 'httpd/unix-directory' );
			$response['props'][] = WebDavServer::mkprop( 'resourcetype', 'collection' );

			$status[] = $response;

			# Don't descend if depth is zero
			if ( empty( $serverOptions['depth'] ) ) {
				return $status;
			}
		}

		# TODO: Use $wgMemc
		$dbr =& wfGetDB( DB_SLAVE );

		# TODO: Think harder about pages' hierarchical structure.  The trouble is most filesystems don't support directories which themselves have file content, which is a problem for making pages descendents of other pages.
		$where = array();
		$where[] = 'rev_page = page_id';
		if ( !empty( $this->pathComponents ) ) {
			$where[] = 'page_title = ' . $dbr->addQuotes( implode( '/', $this->pathComponents ) );
		}

		$whereClause = null;
		if ( !empty( $where ) ) {
			$whereClause = ' WHERE ' . implode( ' AND ', $where );
		}
		$results = $dbr->query( '
			SELECT page_title, rev_id, rev_comment, rev_user_text, rev_len, rev_timestamp, rev_parent_id
			FROM page, revision' . $whereClause );

		$successors = array();
		while ( ( $result = $dbr->fetchRow( $results ) ) !== false ) {
			$response = array();
			$response['path'] = 'deltav.php/ver/' . $result[1];
			$response['props'][] = WebDavServer::mkprop( 'comment', $result[2] );
			$response['props'][] = WebDavServer::mkprop( 'creator-displayname', $result[3] );
			$response['props'][] = WebDavServer::mkprop( 'getcontentlength', $result[4] );
			$response['props'][] = WebDavServer::mkprop( 'getcontenttype', 'text/x-wiki' );
			$response['props'][] = WebDavServer::mkprop( 'getlastmodified', wfTimestamp( TS_UNIX, $result[5] ) );
			$response['props'][] = WebDavServer::mkprop( 'predecessor-set', array( $result[6] ) );
			$response['props'][] = WebDavServer::mkprop( 'resourcetype', null );
			$response['props'][] = WebDavServer::mkprop( 'successor-set', array() );
			$response['props'][] = WebDavServer::mkprop( 'version-name', $result[1] );

			$status[$result[1]] = $response;

			# Build successor-set
			$successors[$result[6]][] = $result[1];
		}

		return $status;
	}

	function updateReport( &$serverOptions ) {
		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'deltav.php' ) {
			return;
		}

		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'vcc' ) {
			return;
		}

		if ( empty( $this->pathComponents ) ) {
			return;
		}
		$pathComponent = array_shift( $this->pathComponents );
		if ( $pathComponent != 'default' ) {
			return;
		}
		if ( !empty( $this->pathComponents ) ) {
			return;
		}

		# TODO: Can we ignore this?
		if ( isset( $serverOptions['label'] ) ) {
			return;
		}

		$serverOptions['xpath']->registerNamespace( 'S', 'svn:' );

		# TODO: Error checking?
		$targetRevision = $serverOptions['xpath']->evaluate( 'string(/S:update-report/S:target-revision)' );

		# src-path is a misnomer, it's a URL
		$srcPath = $serverOptions['xpath']->evaluate( 'string(/S:update-report/S:src-path)' );
		$srcComponents = $this->parseUrl( $srcPath );
		$srcComponents['pathComponents'] = array_slice( $srcComponents['pathComponents'], count( $this->baseUrlComponents['pathComponents'] ) + 1 );

		# TODO: Use $wgMemc
		$dbr =& wfGetDB( DB_SLAVE );

		$entryConditions = array();
		foreach ( $serverOptions['xpath']->query( '/S:update-report/S:entry' ) as $node ) {
			$entryConditions[$node->textContent] = null;
			if ( !$node->hasAttribute( 'start-empty' ) ) {

				# TODO: Error checking?
				$entryConditions[$node->textContent] = 'new.rev_id > ' . $dbr->addQuotes( $node->getAttribute( 'rev' ) );
			}
		}

		function cmp( $a, $b ) {
			return strlen( $a ) - strlen( $b );
		}
		uksort( $entryConditions, 'cmp' );

		$entryCondition = null;
		foreach ( $entryConditions as $path => $revisionCondition ) {
			if ( !empty( $path ) ) {
				$pathCondition = '(page_title = ' . $dbr->addQuotes( $path ) . ' OR page_title LIKE \'' . $dbr->escapeLike( $path ) . '/%\')';

				if ( !empty( $revisionCondition ) ) {
					$revisionCondition = ' AND ' . $revisionCondition;
				}
				$revisionCondition = $pathCondition . $revisionCondition;

				if ( !empty( $entryCondition ) ) {
					$entryCondition = ' AND ' . $entryCondition;
				}
				$entryCondition = 'NOT ' . $pathCondition . $entryCondition;
			}

			if ( !empty( $revisionCondition ) ) {
				if ( !empty( $entryCondition ) ) {
					$revisionCondition = '(' . $revisionCondition;
					$entryCondition = ' OR ' . $entryCondition . ')';
				}
				$entryCondition = $revisionCondition . $entryCondition;
			}
		}
		if ( !empty( $entryCondition ) ) {
			$entryCondition = ' AND ' . $entryCondition;
		}

		$where = array();
		if ( !empty( $targetRevision ) ) {
			$where[] = 'old.rev_id <= ' . $dbr->addQuotes( $targetRevision );
		}
		if ( !empty( $srcComponents['pathComponents'] ) ) {
			$where[] = 'page_title = ' . $dbr->addQuotes( implode( '/', $srcComponents['pathComponents'] ) );
		}

		if ( empty( $targetRevision ) ) {
			$results = $dbr->query( '
				SELECT MAX(rev_id)
				FROM revision' );

			if ( ( $result = $dbr->fetchRow( $results ) ) === false ) {
				return;
			}

			$targetRevision = $result[0];
		}

		$this->setResponseHeader( 'Content-Type: text/xml; charset="utf-8"', false );

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
		echo "<S:update-report xmlns:D=\"DAV:\" xmlns:S=\"svn:\" xmlns:V=\"http://subversion.tigris.org/xmlns/dav\" send-all=\"true\">\n";

		# TODO: Get the revision from the report request
		echo "  <S:target-revision rev=\"$targetRevision\"/>\n";

		# TODO: Use Main_Page revision?
		echo "  <S:open-directory rev=\"$targetRevision\">\n";
		echo '    <D:checked-in><D:href>' . $this->getUrl( array( 'path' => 'deltav.php/ver' ) ) . "</D:href></D:checked-in>\n";

		$whereClause = null;
		if ( !empty( $where ) ) {
			$whereClause = ' WHERE ' . implode( ' AND ', $where );
		}

		# SUM(new.rev_id IS NULL) is the number of revisions which didn't match the entry condition
		# TODO: Invert entry condition to make getting the base revision cleaner
		$results = $dbr->query( '
			SELECT page_title, SUM(new.rev_id IS NULL), MAX(CASE WHEN new.rev_id IS NULL THEN old.rev_id ELSE NULL END), MAX(new.rev_id)
			FROM page
			JOIN revision AS old
			ON page_id = old.rev_page
			LEFT JOIN revision AS new
			ON old.rev_id = new.rev_id' . $entryCondition . $whereClause . '
			GROUP BY page_id
			HAVING COUNT(new.rev_id)' );

		while ( ( $result = $dbr->fetchRow( $results ) ) !== false ) {
			$addOrOpen = 'add';
			$baseRev = null;

			$newText = Revision::newFromId( $result[3] )->revText();
			$oldText = null;

			if ( $result[1] > 0 ) {
				$addOrOpen = 'open';
				$baseRev = ' rev="' . $result[2] . '"';

				$oldText = Revision::newFromId( $result[2] )->revText();
			}

			# TODO: Use only last path component
			echo "    <S:$addOrOpen-file name=\"$result[0]\"$baseRev>\n";

			echo '      <D:checked-in><D:href>' . $this->getUrl( array( 'path' => 'deltav.php/ver/' . $result[3] ) ) . "</D:href></D:checked-in>\n";
			echo '      <S:txdelta>' . base64_encode( $this->getSvnDiff( $oldText, $newText ) ) . "\n</S:txdelta>\n";
			echo '      <S:prop><V:md5-checksum>' . md5( $newText ) . "</V:md5-checksum></S:prop>\n";
			echo "    </S:$addOrOpen-file>\n";
		}

		echo "  </S:open-directory>\n";
		echo "</S:update-report>\n";

		return true;
	}

	function getSvnDiff( $oldText, $newText ) {
		$instructions = chr( 0x80 | strlen( $newText ) );
		if ( strlen( $newText ) > 0x37 ) {
			$instructions = "\x80" . $this->encodeInt( strlen( $newText ) );
		}

		return "SVN\x00\x00"
			. $this->encodeInt( strlen( $oldText ) )
			. $this->encodeInt( strlen( $newText ) )
			. $this->encodeInt( strlen( $instructions ) )
			. $this->encodeInt( strlen( $newText ) )
			. $instructions
			. $newText;
	}

	function encodeInt( $int ) {
		# Least seven bits
		$bytes = chr( $int & 0x7f );

		# Shift by seven bits until nothing remains
		while ( 0 < $int >>= 7 ) {
			# Prepend seven bits with the eighth bit, the continuation bit, set, to the string of bytes
			$bytes = chr( $int & 0x7f | 0x80 ) . $bytes;
		}

		return $bytes;
	}

	function search( &$serverOptions ) {
		$serverOptions['namespaces']['http://subversion.tigris.org/xmlns/dav/'] = 'V';

		$status = array();

		$search = SearchEngine::create();

		# TODO: Use (int)$wgUser->getOption( 'searchlimit' );
		$search->setLimitOffset( MW_SEARCH_LIMIT );

		$results = $search->searchText( $serverOptions['xpath']->evaluate( 'string(/D:searchrequest/D:basicsearch/D:where/D:contains)' ) );

		while ( ( $result = $results->next() ) !== false ) {
			$title = $result->getTitle();
			$revision = Revision::newFromTitle( $title );

			$response = array();
			$response['path'] = 'webdav.php/' . $title->getPrefixedUrl();
			$response['props'][] = WebDavServer::mkprop( 'checked-in', $this->getUrl( array( 'path' => 'deltav.php/ver/' . $revision->getId() ) ) );
			$response['props'][] = WebDavServer::mkprop( 'displayname', $title->getText() );
			$response['props'][] = WebDavServer::mkprop( 'getcontentlength', $revision->getSize() );
			$response['props'][] = WebDavServer::mkprop( 'getcontenttype', 'text/x-wiki' );
			$response['props'][] = WebDavServer::mkprop( 'getlastmodified', wfTimestamp( TS_UNIX, $revision->mTimestamp ) );
			$response['props'][] = WebDavServer::mkprop( 'resourcetype', null );
			$response['props'][] = WebDavServer::mkprop( 'version-controlled-configuration', $this->getUrl( array( 'path' => 'deltav.php/vcc/default' ) ) );

			$response['props'][] = WebDavServer::mkprop( 'http://subversion.tigris.org/xmlns/dav/', 'baseline-relative-path', $title->getFullUrl() );
			$response['score'] = $result->getScore();

			$status[] = $response;
		}

		# TODO: Check if we exceed our limit
		#$response = array();
		#$response['status'] = '507 Insufficient Storage';

		#$status[] = $response;

		return $status;
	}
}
