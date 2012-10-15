<?php

/**
 * Static class for hooks handled by the DSMW extension.
 *
 * @since 1.1
 *
 * @file DSMW.hooks.php
 * @ingroup DSMW
 *
 * @author jean-philippe muller
 * @author Morel Émile
 */
final class DSMWHooks {

	/**
	 * @since 1.1
	 *
	 * @return true
	 */
	public function onExtensionSchemaUpdates() {
		global $wgExtNewTables;

		$wgExtNewTables[] = array(
			'model',
			dirname( __FILE__ ) . '/DSMW.sql'
		);

		$wgExtNewTables[] = array(
			'p2p_params',
			dirname( __FILE__ ) . '/DSMW.sql'
		);

		return true;
	}

	/**
	 * @since 1.1
	 *
	 * @param EditPage $editor
	 * @param OutputPage &$out
	 *
	 * @return true
	 */
	public function onEditConflict( EditPage &$editor, OutputPage &$out ) {
		$conctext = $editor->textbox1;
		$actualtext = $editor->textbox2;
		$initialtext = $editor->getBaseRevision()->mText;

		// TODO: WTF?!
		$editor->mArticle->doEdit( $actualtext, $editor->summary, $editor->minoredit ? EDIT_MINOR : 0 );
		$query = Title::newFromRedirect( $actualtext ) === null ? '' : 'redirect=no';
		$out->redirect( $editor->mTitle->getFullURL( $query ) );

		return true;
	}

	/**
	 * MW Hook used to redirect to page creation (pushfeed, pullfeed, changeset),
	 * to forms or to push/pull action testing the action param
	 *
	 * @since 1.1
	 *
	 * @param string $action
	 * @param Article $article
	 *
	 * @return true
	 */
	public function onUnknownAction( $action, Article $article ) {
		global $wgOut, $wgServerName, $wgScriptPath, $wgUser, $wgScriptExtension, $wgDSMWIP;

		$urlServer = 'http://' . $wgServerName . $wgScriptPath . "/index{$wgScriptExtension}";
		$urlAjax = 'http://' . $wgServerName . $wgScriptPath;

		///////// / pull form page////////
		if ( isset( $_GET['action'] ) && $_GET['action'] == 'addpullpage' ) {
			wfDebugLog( 'p2p', 'addPullPage ' );
			$newtext = "Add a new site:
	<div id='dsmw' style=\"color:green;\"></div>

	{{#form:action=" . $urlServer . "?action=pullpage|method=POST|
		PushFeed Url: {{#input:type=button|value=Url test|onClick=
		var url = document.getElementsByName('url')[0].value;
		if(url.indexOf('PushFeed')==-1){
			alert('No valid PushFeed syntax, see example.');
		}else{
			var urlTmp = url.substring( 0, url.indexOf( 'PushFeed' ) );
			//alert(urlTmp);

			var pos1 = urlTmp.indexOf( 'index.php' );
			//alert( pos1 );
			var pushUrl='';
			if( pos1 != -1 ){
				pushUrl = urlTmp.substring(0,pos1);
				//alert('if');
			} else {
				pushUrl = urlTmp;
				//alert('else');
			}
			//alert(pushUrl);

			//alert(pushUrl+'api.php?action=query&meta=patch&papatchId=1&format=xml');
			var xhr_object = null;

			if( window.XMLHttpRequest ) { // Firefox
				xhr_object = new XMLHttpRequest();
			}else if( window.ActiveXObject ) { // Internet Explorer
				xhr_object = new ActiveXObject('Microsoft.XMLHTTP');
			} else {
				alert('Votre navigateur ne supporte pas les objets XMLHTTPRequest...');
				return;
			}
			try {
				xhr_object.open('GET', '" . $urlAjax . "/extensions/DSMW/files/ajax.php?url='+escape(pushUrl+'api.php?action=query&meta=patch&papatchId=1&format=xml'), true);
			} catch( e ) {
				//alert('There is no DSMW Server responding at this URL');
				document.getElementById('dsmw').innerHTML = 'There is no DSMW Server responding at this URL!';
				document.getElementById('dsmw').style.color = 'red';
			}
			xhr_object.onreadystatechange = function() {

			if( xhr_object.readyState == 4 ) {
				if( xhr_object.statusText=='OK' ){
					if( xhr_object.responseText == 'true' ){
						//alert('URL valid, there is a DSMW Server responding');
						document.getElementById('dsmw').innerHTML = 'URL valid, there is a DSMW Server responding!';
						document.getElementById('dsmw').style.color = 'green';
					} else{ //alert('There is no DSMW Server responding at this URL');
						document.getElementById('dsmw').innerHTML = 'There is no DSMW Server responding at this URL!';
						document.getElementById('dsmw').style.color = 'red';
					}
				} else{
					//alert('There is no DSMW Server responding at this URL');
					document.getElementById('dsmw').innerHTML = 'There is no DSMW Server responding at this URL!';
					document.getElementById('dsmw').style.color = 'red';
				}
			}
		}

		xhr_object.send(null);
	}
	}}<br>        {{#input:type=text|name=url|size=50}} <b>e.g. http://server/path/index.php?title=PushFeed:PushName</b><br>
	PullFeed Name:   <br>    {{#input:type=text|name=pullname}}<br>
	{{#input:type=submit|value=ADD}}
	}}";

			$article->doEdit( $newtext, $summary = "" );
			$wgOut->redirect( $article->getTitle()->getFullURL() );

			return false;
		}


		//////// / push form page////////
		elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'addpushpage' ) {
			wfDebugLog( 'p2p', 'addPushPage' );
			$specialAsk = $urlServer . '?title=Special:Ask';
			$newtext = "Add a new pushfeed:

	{{#form:action=" . $urlServer . "?action=pushpage|method=POST|
	PushFeed Name:   <br>    {{#input:class=test|name=name|type=text|onKeyUp=test('$urlServer');}}<div style=\"display:inline; \" id=\"state\" ></div><br />
	Request: {{#input:type=button|value=Test your query|title=click here to test your query results|onClick=
	var query = document.getElementsByName('keyword')[0].value;
	var query1 = encodeURI(query);
	window.open('" . $specialAsk . "&q='+query1+'&eq=yes&p%5Bformat%5D=broadtable','querywindow','menubar=no, status=no, scrollbars=yes, menubar=no, width=1000, height=900');}}
	  <br>{{#input:type=textarea|cols=30 | style=width:auto |rows=2|name=keyword}} <b>e.g. [[Category:city]][[locatedIn::France]]</b><br>
	{{#input:type=submit|value=ADD}}
	}}";

			$article->doEdit( $newtext, $summary = "" );
			$wgOut->redirect( $article->getTitle()->getFullURL() );
			return false;
		}

		////// / PushFeed page////////
		elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'pushpage' ) {
			// $url = $_POST['url'];//pas url mais changesetId
			wfDebugLog( 'p2p', 'Create new push ' . $_POST['name'] . ' with ' . $_POST['keyword'] );
			$name = $_POST['name'];
			$request = $_POST['keyword'];
			$stringReq = utils::encodeRequest( $request ); // avoid "semantic injection" :))
			// addPushSite($url, $name, $request);


			$newtext = "
[[Special:ArticleAdminPage|DSMW Admin functions]]

==Features==
[[name::PushFeed:" . $name . "| ]]
'''Semantic query:''' [[hasSemanticQuery::" . $stringReq . "| ]]<nowiki>" . $request . "</nowiki>

'''Pages concerned:'''
{{#ask: " . $request . "}}
[[deleted::false| ]]

==Actions==

{{#input:type=ajax|value=PUSH|onClick=pushpull('" . $urlServer . "','PushFeed:" . $name . "', 'onpush');}}
The \"PUSH\" action publishes the (unpublished) modifications of the articles listed above.

== PUSH Progress : ==
<div id=\"state\" ></div><br />
";

			wfDebugLog( 'p2p', '  -> push page contains : ' . $newtext );
			$title = Title::newFromText( $_POST['name'], PUSHFEED );

			$article = new Article( $title );
			$edit = $article->doEdit( $newtext, $summary = "" );
			$wgOut->redirect( $title->getFullURL() );
			return false;
		}
		////// / ChangeSet page////////
		elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'onpush' ) {

			/* In case we push directly from an article page */
			if ( isset( $_POST['page'] ) && isset( $_POST['request'] ) ) {
			$articlename = Title::newFromText( $_POST['name'] );

			if ( !$articlename->exists() ) {
				$result = utils::createPushFeed( $_POST['name'], $_POST['request'] );
				utils::writeAndFlush( "Create push <A HREF=" . 'http://' . $wgServerName . $wgScriptPath . "/index.php?title=" . $_POST['name'] . ">" . $_POST['name'] . "</a>" );
				if ( $result == false ) {
					throw new MWException(
						__METHOD__ . ': no Pushfeed created in utils:: createPushFeed: ' .
						'name: ' . $_POST['name'] . ' request' . $_POST['request'] );
					}
				}
			}

			wfDebugLog( 'p2p', 'push on ' );
			$patches = array();
			$tmpPatches = array();

			if ( isset( $_POST['name'] ) ) {
				$name1 = $_POST['name'];
				if ( !is_array( $name1 ) )
					$name1 = array( $name1 );
				foreach ( $name1 as $push ) {
					wfDebugLog( 'p2p', ' - ' . $push );
				}
			} else {
				$name1 = '';
			}

			if ( $name1 == '' ) {
				utils::writeAndFlush( '<p><b>No pushfeed selected!</b></p>' );

				$title = Title::newFromText( 'Special:ArticleAdminPage' );
				$wgOut->redirect( $title->getFullURL() );

				return false;
			}

			// $name = $name1[0];
			utils::writeAndFlush( '<p><b>Start push </b></p>' );

			foreach ( $name1 as $name ) {
				utils::writeAndFlush( "<span style=\"margin-left:30px;\">begin push: <A HREF=" . 'http://' . $wgServerName . $wgScriptPath . "/index.php?title=$name>" . $name . "</a></span> <br/>" );
				$patches = array();  // / / for each pushfeed name==> push
				wfDebugLog( 'p2p', '  -> pushname ' . $name );
				// $name = $_GET['name'];//PushFeed name
				$request = getPushFeedRequest( $name );
				// $previousCSID = getPreviousCSID($name);
				$previousCSID = getHasPushHead( $name );
				if ( $previousCSID == false ) {
					$previousCSID = "none";
					// $CSID = $name."_0";
				}// else{
				//	$count = explode(" ", $previousCSID);
				//	$cnt = $count[1] + 1;
				//	$CSID = $name."_".$cnt;
				// }
				wfDebugLog( 'p2p', '  ->pushrequest ' . $request );
				wfDebugLog( 'p2p', '  ->pushHead : ' . $previousCSID );
				$CSID = utils::generateID(); // changesetID
				if ( $request == false ) {
					$outtext = '<p><b>No semantic request found!</b></p> <a href="' . $_SERVER['HTTP_REFERER'] . '">back</a>';
					$wgOut->addHTML( $outtext );
					return false;
				}

				$pages = getRequestedPages( $request ); // ce sont des pages et non des patches
				foreach ( $pages as $page ) {
					wfDebugLog( 'p2p', '  ->requested page ' . $page );
					$page = str_replace( '"', '', $page );
					$request1 = '[[Patch:+]][[onPage::' . $page . ']]';
					$tmpPatches = utils::orderPatchByPrevious( $page );
					if ( !is_array( $tmpPatches ) )
						throw new MWException( __METHOD__ . ': $tmpPatches is not an array' );
					$patches = array_merge( $patches, $tmpPatches );
					wfDebugLog( 'p2p', '  -> ' . count( $tmpPatches ) . 'patchs were found for the page ' . $page );
				}
				wfDebugLog( 'p2p', '  -> ' . count( $patches ) . ' patchs were found for the pushfeed ' . $name );
				$published = getPublishedPatches( $name );
				$unpublished = array_diff( $patches, $published ); /* unpublished = patches-published */
				wfDebugLog( 'p2p', '  -> ' . count( $published ) . ' patchs were published for the pushfeed ' . $name . ' and ' . count( $unpublished ) . ' unpublished patchs' );
				if ( empty( $unpublished ) ) {
					wfDebugLog( 'p2p', '  -> no unpublished patch' );
					utils::writeAndFlush( "<span style=\"margin-left:60px;\">no unpublished patch</span><br/>" );
					// return false; //If there is no unpublished patch
				} else {
					utils::writeAndFlush( "<span style=\"margin-left:60px;\">" . count( $unpublished ) . " unpublished patch</span><br/>" );
					$pos = strrpos( $CSID, ":" ); // NS removing
					if ( $pos === false ) {
						// not found...
						$articleName = $CSID;
						$CSID = "ChangeSet:" . $articleName;
					} else {
						$articleName = substr( $CSID, 0, $pos + 1 );
						$CSID = "ChangeSet:" . $articleName;
					}
					$newtext = "
[[Special:ArticleAdminPage|DSMW Admin functions]]

==Features==
[[changeSetID::" . $CSID . "| ]]

'''Date:''' " . date( DATE_RFC822 ) . "

'''User:''' " . $wgUser->getName() . "

This ChangeSet is in : [[inPushFeed::" . $name . "]]<br>
==Published patches==

{| class=\"wikitable\" border=\"1\" style=\"text-align:left; width:30%;\"
|-
!bgcolor=#c0e8f0 scope=col | Patch
|-
";
					// wfDebugLog('p2p','  -> count unpublished patch '.count($unpublished));
					foreach ( $unpublished as $patch ) {
						wfDebugLog( 'p2p', '  -> unpublished patch ' . $patch );
						$newtext .= "|[[hasPatch::" . $patch . "]]
	|-
	";
					}
					$newtext .= "
	|}";
					$newtext .= "
==Previous ChangeSet==
[[previousChangeSet::" . $previousCSID . "]]
";

					$update = updatePushFeed( $name, $CSID );
					if ( $update == true ) {// update the "hasPushHead" value successful
						$title = Title::newFromText( $articleName, CHANGESET );
						$article = new Article( $title );
						$article->doEdit( $newtext, $summary = "" );
					} else {
						$outtext = '<p><b>PushFeed has not been updated!</b></p>';
						$wgOut->addHTML( $outtext );
					}
				}
			}// end foreach pushfeed list
			utils::writeAndFlush( '<p><b>End push</b></p>' );
			$title = Title::newFromText( 'Special:ArticleAdminPage' );
			$wgOut->redirect( $title->getFullURL() );

			return false;
		}


		///////// / PullFeed page////////
		elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'pullpage' ) {
			// wfDebugLog('p2p','Create pull '.$_POST['pullname'].' with pushName '.$_POST['pushname'].' on '.$_POST['url']);
			// $url = rtrim($_POST['url'], "/"); //removes the final "/" if there is one
			$urlTmp = $_POST['url'];
			if ( utils::isValidURL( $urlTmp ) == false ) {
				// throws an exception if $url is invalid
				throw new MWException( __METHOD__ . ': ' . $urlTmp . ' seems not to be an url' );
			}

			$res = utils::parsePushURL( $urlTmp );

			if ( $res === false || empty( $res ) ) {
				throw new MWException( __METHOD__ . ': URL format problem' );
			}

			$pushname = $res[0];
			$url = $res[1];

			// $pushname = $_POST['pushname'];
			$pullname = $_POST['pullname'];

			$newtext = "
[[Special:ArticleAdminPage|DSMW Admin functions]]

==Features==

[[name::PullFeed:" . $pullname . "| ]]
'''URL of the DSMW PushServer:''' [[pushFeedServer::" . $url . "]]<br>
'''PushFeed name:''' [[pushFeedName::PushFeed:" . $pushname . "]]
[[deleted::false| ]]

==Actions==

{{#input:type=ajax|value=PULL|onClick=pushpull('" . $urlServer . "','PullFeed:" . $pullname . "','onpull');}}

The \"PULL\" action gets the modifications published in the PushFeed of the PushFeedServer above.

== PULL Progress : ==
<div id=\"state\" ></div><br />
";

			$title = Title::newFromText( $pullname, PULLFEED );
			$article = new Article( $title );
			$article->doEdit( $newtext, $summary = "" );
			$wgOut->redirect( $title->getFullURL() );

			return false;
		}

		///////// / OnPull/////////////
		elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'onpull' ) {
			if ( isset( $_POST['name'] ) ) {
				$name1 = $_POST['name'];
				wfDebugLog( 'p2p', 'pull on ' );
				if ( !is_array( $name1 ) )
					$name1 = array( $name1 );
			} else {
				$name1 = '';
			}

			if ( $name1 == '' ) {
				utils::writeAndFlush( '<p><b>No pullfeed selected!</b></p> ' );
				$title = Title::newFromText( 'Special:ArticleAdminPage' );
				$article = new Article( $title );
				$article->doEdit( '', $summary = "" );
				$wgOut->redirect( $title->getFullURL() );
				return false;
			}

			// $name = $name1[0];//with NS
			utils::writeAndFlush( '<p><b>Start pull</b></p>' );
			foreach ( $name1 as $name ) {// for each pullfeed name==> pull
				utils::writeAndFlush( "<span style=\"margin-left:30px;\">begin pull: <A HREF=" . 'http://' . $wgServerName . $wgScriptPath . "/index.php?title=$name>" . $name . "</a></span> <br/>" );
				wfDebugLog( 'p2p', '      -> pull : ' . $name );

				// $previousCSID = getPreviousPulledCSID($name);
				// if($previousCSID==false) {
				//	$previousCSID = "none";
				// }
				$previousCSID = getHasPullHead( $name );
				if ( $previousCSID == false ) {
					$previousCSID = "none";
				}

				wfDebugLog( 'p2p', '      -> pullHead : ' . $previousCSID );

				$relatedPushServer = getPushURL( $name );
				if ( is_null( $relatedPushServer ) ) {
					throw new MWException( __METHOD__ . ': no relatedPushServer url' );
				}

				$namePush = getPushName( $name );
				$namePush = str_replace( ' ', '_', $namePush );

				wfDebugLog( 'p2p', '      -> pushServer : ' . $relatedPushServer );
				wfDebugLog( 'p2p', '      -> pushName : ' . $namePush );

				if ( is_null( $namePush ) ) {
					throw new MWException( __METHOD__ . ': no PushName' );
				}

				// split NS and name
				preg_match( "/^(.+?)_*:_*(.*)$/S", $namePush, $m );
				$nameWithoutNS = $m[2];

				// $url = $relatedPushServer.'/api.php?action=query&meta=changeSet&cspushName='.$nameWithoutNS.'&cschangeSet='.$previousCSID.'&format=xml';
				// $url = $relatedPushServer."/api{$wgScriptExtension}?action=query&meta=changeSet&cspushName=".$nameWithoutNS.'&cschangeSet='.$previousCSID.'&format=xml';
				wfDebugLog( 'testlog', '      -> request ChangeSet : ' . $relatedPushServer . '/api.php?action=query&meta=changeSet&cspushName=' . $nameWithoutNS . '&cschangeSet=' . $previousCSID . '&format=xml' );
				$cs = utils::file_get_contents_curl( utils::lcfirst( $relatedPushServer ) . "/api.php?action=query&meta=changeSet&cspushName=" . $nameWithoutNS . '&cschangeSet=' . $previousCSID . '&format=xml' );

				/* test if it is a xml file. If not, the server is not reachable via the url
				 * Then we try to reach it with the .php5 extension
				 */
				if ( strpos( $cs, "<?xml version=\"1.0\"?>" ) === false ) {
					$cs = utils::file_get_contents_curl( utils::lcfirst( $relatedPushServer ) . "/api.php5?action=query&meta=changeSet&cspushName=" . $nameWithoutNS . '&cschangeSet=' . $previousCSID . '&format=xml' );
				}

				if ( strpos( $cs, "<?xml version=\"1.0\"?>" ) === false ) {
					$cs = false;
				}

				if ( $cs === false ) {
					throw new MWException( __METHOD__ . ': Cannot connect to Push Server (ChangeSet API)' );
				}

				$cs = trim( $cs );
				$dom = new DOMDocument();
				$dom->loadXML( $cs );

				$changeSet = $dom->getElementsByTagName( 'changeSet' );
				$CSID = null;

				foreach ( $changeSet as $cs ) {
					if ( $cs->hasAttribute( "id" ) ) {
						$CSID = $cs->getAttribute( 'id' );
						$csName = $CSID;
					}
				}

				wfDebugLog( 'p2p', '     -> changeSet found ' . $CSID );

				while ( $CSID != null ) {
					// if(!utils::pageExist($CSID)) {
					$listPatch = null;
					$patchs = $dom->getElementsByTagName( 'patch' );
					foreach ( $patchs as $p ) {
						wfDebugLog( 'p2p', '          -> patch ' . $p->firstChild->nodeValue );
						$listPatch[] = $p->firstChild->nodeValue;
					}

					// $CSID = substr($CSID,strlen('changeSet:'));
					utils::createChangeSetPull( $CSID, $name, $previousCSID, $listPatch );

					integrate( $CSID, $listPatch, $relatedPushServer, $csName );
					updatePullFeed( $name, $CSID );

					// }

					$previousCSID = $CSID;
					wfDebugLog( 'p2p', '     -> request ChangeSet : ' . $relatedPushServer . '/api.php?action=query&meta=changeSet&cspushName=' . $nameWithoutNS . '&cschangeSet=' . $previousCSID . '&format=xml' );
					$cs = utils::file_get_contents_curl( utils::lcfirst( $relatedPushServer ) . "/api.php?action=query&meta=changeSet&cspushName=" . $nameWithoutNS . '&cschangeSet=' . $previousCSID . '&format=xml' );

					/* test if it is a xml file. If not, the server is not reachable via the url
					 * Then we try to reach it with the .php5 extension
					 */
					if ( strpos( $cs, "<?xml version=\"1.0\"?>" ) === false ) {
						$cs = utils::file_get_contents_curl( utils::lcfirst( $relatedPushServer ) . "/api.php5?action=query&meta=changeSet&cspushName=" . $nameWithoutNS . '&cschangeSet=' . $previousCSID . '&format=xml' );
					}
					if ( strpos( $cs, "<?xml version=\"1.0\"?>" ) === false )
						$cs = false;

					if ( $cs === false )
						throw new MWException( __METHOD__ . ': Cannot connect to Push Server (ChangeSet API)' );
					$cs = trim( $cs );

					$dom = new DOMDocument();
					$dom->loadXML( $cs );

					$changeSet = $dom->getElementsByTagName( 'changeSet' );
					$CSID = null;
					foreach ( $changeSet as $cs ) {
						if ( $cs->hasAttribute( "id" ) ) {
							$CSID = $cs->getAttribute( 'id' );
						}
					}
					wfDebugLog( 'p2p', '     -> changeSet found ' . $CSID );
				}
				if ( is_null( $csName ) ) {
					wfDebugLog( 'p2p', '  - redirect to Special:ArticleAdminPage' );
					utils::writeAndFlush( "<span style=\"margin-left:60px;\">no new patch</span><br/>" );
				} else {
					wfDebugLog( 'p2p', '  - redirect to ChangeSet:' . $csName );
				}
			}// end foreach list pullfeed

			utils::writeAndFlush( '<p><b>End pull</b></p>' );
			$title = Title::newFromText( 'Special:ArticleAdminPage' );
			$wgOut->redirect( $title->getFullURL() );

			return false;
		} else {
			return true;
		}
	}

	/* * *************************************************************************** */
	/*
	        V0 : initial revision
	       /  \
	      /
	  P1 /      \P2
	    /
	   /          \
	  V1          V2:2nd edit of the same article
	  1st Edit
	 */
	/* * *************************************************************************** */

	/**
	 * @since 1.1
	 *
	 * @param EditPage $editpage
	 *
	 * @return true
	 */
	public function onAttemptSave( EditPage $editpage ) {
		global $wgServerName, $wgScriptPath;

		$urlServer = 'http://' . $wgServerName . $wgScriptPath;

		$ns = $editpage->mTitle->getNamespace();
		if ( ( $ns == PATCH ) || ( $ns == PUSHFEED ) || ( $ns == PULLFEED ) || ( $ns == CHANGESET ) ) {
			return true;
		}

		$actualtext = $editpage->textbox1; // V2

		$dbr = wfGetDB( DB_SLAVE );
		$lastRevision = Revision::loadFromTitle( $dbr, $editpage->mTitle );

		if ( is_null( $lastRevision ) ) {
			$conctext = "";
			$rev_id = 0;
		} elseif ( ( $ns == NS_FILE || $ns == NS_IMAGE || $ns == NS_MEDIA ) && $lastRevision->getRawText() == "" ) {
			$rev_id = 0;
			$conctext = $lastRevision->getText();
		} else {
			$conctext = $lastRevision->getText(); // V1 conc
			$rev_id = $lastRevision->getId();
		}

		// if there is no modification on the text
		if ( $actualtext == $conctext ) {
			return true;
		}

		$model = DSMWRevisionManager::loadModel( $rev_id );
		$logoot = new logootEngine( $model );

		// get the revision with the edittime==>V0
		$rev = Revision::loadFromTimestamp( $dbr, $editpage->mTitle, $editpage->edittime );
		if ( is_null( $rev ) ) {
			$text = "";
			$rev_id1 = 0;
		} else {
			$text = $rev->getText(); // VO
			$rev_id1 = $rev->getId();
		}

		if ( $conctext != $text ) {// if last revision is not V0, there is editing conflict
			$model1 = DSMWRevisionManager::loadModel( $rev_id1 );
			$logoot1 = new logootEngine( $model1 );
			$listOp1 = $logoot1->generate( $text, $actualtext );
			// creation Patch P2
			$tmp = serialize( $listOp1 );
			$patch = new DSMWPatch( false, false, $listOp1, $urlServer, $rev_id1 );

			if ( $editpage->mTitle->getNamespace() == 0 ) {
				$title = $editpage->mTitle->getText();
			}
			else {
				$title = $editpage->mTitle->getNsText() . ':' . $editpage->mTitle->getText();
			}

			// integration: diffs between VO and V2 into V1

			$modelAfterIntegrate = $logoot->integrate( $listOp1 );
		} else {// no edition conflict
			$listOp = $logoot->generate( $conctext, $actualtext );
			$modelAfterIntegrate = $logoot->getModel();
			$tmp = serialize( $listOp );
			$patch = new DSMWPatch( false, false, $listOp, $urlServer, $rev_id1 );

			if ( $editpage->mTitle->getNamespace() == 0 )
				$title = $editpage->mTitle->getText();
			else
				$title = $editpage->mTitle->getNsText() . ':' . $editpage->mTitle->getText();
		}

		$revId = utils::getNewArticleRevId();
		wfDebugLog( 'p2p', ' -> store model rev : ' . $revId . ' session ' . session_id() . ' model ' . $modelAfterIntegrate->getText() );
		DSMWRevisionManager::storeModel( $revId + 1, $sessionId = session_id(), $modelAfterIntegrate, $blobCB = 0 );

		$patch->storePage( $title, $revId + 1 ); // stores the patch in a wikipage
		$editpage->textbox1 = $modelAfterIntegrate->getText();
		return true;
	}

	/**
	 * @since 1.1
	 *
	 * @param UploadForm $image
	 *
	 * @return true
	 */
	public function onUploadComplete( UploadForm $image ) {
		global $wgServerName, $wgScriptPath, $wgServer, $wgVersion;
		$urlServer = 'http://' . $wgServerName . $wgScriptPath;

		// $classe = get_class($image);
		if ( compareMWVersion( $wgVersion, '1.16.0' ) == -1 ) {
			$localfile = $image->mLocalFile;
		} else {
			$localfile = $image->getLocalFile();
		}

		$path = utils::prepareString( $localfile->mime, $localfile->size, $wgServer . urldecode( $localfile->url ) );

		if ( !file_exists( $path ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$lastRevision = Revision::loadFromTitle( $dbr, $localfile->getTitle() );

			if ( $lastRevision->getPrevious() == null ) {
				$rev_id = 0;
			} else {
				$rev_id = $lastRevision->getPrevious()->getId();
			}

			$revID = $lastRevision->getId();
			$model = DSMWRevisionManager::loadModel( $rev_id );
			$patch = new DSMWPatch( false, true, null, $urlServer, $rev_id, null, null, null, $localfile->mime, $localfile->size, urldecode( $localfile->url ), null );
			$patch->storePage( $localfile->getTitle(), $revID ); // stores the patch in a wikipage
			DSMWRevisionManager::storeModel( $revID, $sessionId = session_id(), $model, $blobCB = 0 );
		}

		return true;
	}

}
