<?php
/**
 * All BlogPage's hooked functions. These were previously scattered all over
 * the place in various files.
 *
 * @file
 */
class BlogHooks {

	/**
	 * Calls BlogPage instead of standard Article for pages in the NS_BLOG
	 * namespace.
	 *
	 * @param $title Object: instance of Title
	 * @param $article Object: instance of Article that we convert into a BlogPage
	 * @return Boolean: true
	 */
	public static function blogFromTitle( &$title, &$article ) {
		global $wgRequest, $wgOut, $wgHooks, $wgScriptPath;
		global $wgSupressPageTitle, $wgSupressSubTitle, $wgSupressPageCategories;

		if ( $title->getNamespace() == NS_BLOG ) {
			if( !$wgRequest->getVal( 'action' ) ) {
				$wgSupressPageTitle = true;
			}

			$wgSupressSubTitle = true;
			$wgSupressPageCategories = true;

			// This will suppress category links in SkinTemplate-based skins
			$wgHooks['SkinTemplateOutputPageBeforeExec'][] = function( $sk, $tpl ) {
				$tpl->set( 'catlinks', '' );
				return true;
			};

			$wgOut->enableClientCache( false );

			// Add CSS
			$wgOut->addModules( 'ext.blogPage' );

			// This originally used $wgTitle but I saw no point in that, so I
			// changed that as per Chad et al.
			$article = new BlogPage( $title );
		}

		return true;
	}

	/**
	 * Checks that the user is logged is, is not blocked via Special:Block and has
	 * the 'edit' user right when they're trying to edit a page in the NS_BLOG NS.
	 *
	 * @param $editPage Object: instance of EditPage
	 * @return Boolean: true if the user should be allowed to continue, else false
	 */
	public static function allowShowEditBlogPage( $editPage ) {
		global $wgOut, $wgUser;

		if( $editPage->mTitle->getNamespace() == NS_BLOG ) {
			if( $wgUser->isAnon() ) { // anons can't edit blog pages
				if( !$editPage->mTitle->exists() ) {
					$wgOut->addWikiMsg( 'blog-login' );
				} else {
					$wgOut->addWikiMsg( 'blog-login-edit' );
				}
				return false;
			}

			if ( !$wgUser->isAllowed( 'edit' ) || $wgUser->isBlocked() ) {
				$wgOut->addHTML( wfMsg( 'blog-permission-required' ) );
				return false;
			}
		}

		return true;
	}

	/**
	 * This function was originally in the UserStats directory, in the file
	 * CreatedOpinionsCount.php.
	 * This function here updates the stats_opinions_created column in the
	 * user_stats table every time the user creates a new blog post.
	 *
	 * This is hooked into two separate hooks (todo: find out why), ArticleSave
	 * and ArticleSaveComplete. Their arguments are mostly the same and both
	 * have $article as the first argument.
	 *
	 * @param $article Object: Article object representing the page that was/is
	 *                         (being) saved
	 * @return Boolean: true
	 */
	public static function updateCreatedOpinionsCount( &$article ) {
		global $wgOut, $wgUser;

		$aid = $article->getTitle()->getArticleID();
		// Shortcut, in order not to perform stupid queries (cl_from = 0...)
		if ( $aid == 0 ) {
			return true;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'categorylinks',
			'cl_to',
			// Chad was right, $wgTitle is pure satan; this used to use that
			// and as a result this was completely busted
			array( 'cl_from' => $aid ),
			__METHOD__
		);

		foreach ( $res as $row ) {
			$ctg = Title::makeTitle( NS_CATEGORY, $row->cl_to );
			$ctgname = $ctg->getText();
			$blogCat = wfMsgForContent( 'blog-category' );
			$userBlogCat = wfMsgForContent( 'blog-by-user-category', $blogCat );

			if( strpos( $ctgname, $userBlogCat ) !== false ) {
				$user_name = trim( str_replace( $userBlogCat, '', $ctgname ) );
				$u = User::idFromName( $user_name );

				if( $u ) {
					$stats = new UserStatsTrack( $u, $user_name );
					// Copied from UserStatsTrack::updateCreatedOpinionsCount()
					// Throughout this code, we could use $u and $user_name
					// instead of $stats->user_id and $stats->user_name but
					// there's no point in doing that because we have to call
					// clearCache() in any case
					if ( !$wgUser->isAnon() && $stats->user_id ) {
						$ctg = $userBlogCat . ' ' . $stats->user_name;
						$parser = new Parser();
						$ctgTitle = Title::newFromText(
							$parser->preprocess(
								trim( $ctg ),
								$wgOut->getTitle(),
								$wgOut->parserOptions()
							)
						);
						$ctgTitle = $ctgTitle->getDBkey();
						$dbw = wfGetDB( DB_MASTER );

						$opinions = $dbw->select(
							array( 'page', 'categorylinks' ),
							array( 'COUNT(*) AS CreatedOpinions' ),
							array(
								'cl_to' => $ctgTitle,
								'page_namespace' => NS_BLOG // paranoia
							),
							__METHOD__,
							array(),
							array(
								'categorylinks' => array(
									'INNER JOIN',
									'page_id = cl_from'
								)
							)
						);

						// Please die in a fire, PHP.
						// selectField() would be ideal above but it returns
						// insane results (over 300 when the real count is
						// barely 10) so we have to fuck around with a
						// foreach() loop that we don't even need in theory
						// just because PHP is...PHP.
						$opinionsCreated = 0;
						foreach ( $opinions as $opinion ) {
							$opinionsCreated = $opinion->CreatedOpinions;
						}

						$res = $dbw->update(
							'user_stats',
							array( 'stats_opinions_created' => $opinionsCreated ),
							array( 'stats_user_id' => $stats->user_id ),
							__METHOD__
						);

						$stats->clearCache();
					}
				}
			}
		}

		return true;
	}

	/**
	 * Show a list of this user's blog articles in their user profile page.
	 *
	 * @param $userProfile Object: instance of UserProfilePage
	 * @return Boolean: true
	 */
	public static function getArticles( $userProfile ) {
		global $wgUserProfileDisplay, $wgMemc, $wgOut;

		if ( !$wgUserProfileDisplay['articles'] ) {
			return '';
		}

		$user_name = $userProfile->user_name;
		$output = '';

		// Try cache first
		$key = wfMemcKey( 'user', 'profile', 'articles', $userProfile->user_id );
		$data = $wgMemc->get( $key );
		$articles = array();

		if( $data != '' ) {
			wfDebugLog(
				'BlogPage',
				"Got UserProfile articles for user {$user_name} from cache\n"
			);
			$articles = $data;
		} else {
			wfDebugLog(
				'BlogPage',
				"Got UserProfile articles for user {$user_name} from DB\n"
			);
			$categoryTitle = Title::newFromText(
				wfMsgForContent(
					'blog-by-user-category',
					wfMsgForContent( 'blog-category' )
				) . " {$user_name}"
			);

			$dbr = wfGetDB( DB_SLAVE );
			/**
			 * I changed the original query a bit, since it wasn't returning
			 * what it should've.
			 * I added the DISTINCT to prevent one page being listed five times
			 * and added the page_namespace to the WHERE clause to get only
			 * blog pages and the cl_from = page_id to the WHERE clause so that
			 * the cl_to stuff actually, y'know, works :)
			 */
			$res = $dbr->select(
				array( 'page', 'categorylinks' ),
				array( 'DISTINCT page_id', 'page_title', 'page_namespace' ),
				/* WHERE */array(
					'cl_from = page_id',
					'cl_to' => array( $categoryTitle->getDBkey() ),
					'page_namespace' => NS_BLOG
				),
				__METHOD__,
				array( 'ORDER BY' => 'page_id DESC', 'LIMIT' => 5 )
			);

			foreach ( $res as $row ) {
				$articles[] = array(
					'page_title' => $row->page_title,
					'page_namespace' => $row->page_namespace,
					'page_id' => $row->page_id
				);
			}

			$wgMemc->set( $key, $articles, 60 );
		}

		// Load opinion count via user stats;
		$stats = new UserStats( $userProfile->user_id, $user_name );
		$stats_data = $stats->getUserStats();
		$articleCount = $stats_data['opinions_created'];

		$articleLink = Title::makeTitle(
			NS_CATEGORY,
			wfMsgForContent(
				'blog-by-user-category',
				wfMsgForContent( 'blog-category' )
			) . " {$user_name}"
		);

		if ( count( $articles ) > 0 ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'blog-user-articles-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">';
			if( $articleCount > 5 ) {
				$output .= '<a href="' . $articleLink->escapeFullURL() .
					'" rel="nofollow">' . wfMsg( 'user-view-all' ) . '</a>';
			}
			$output .= '</div>
					<div class="action-left">' . wfMsgExt(
						'user-count-separator',
						'parsemag',
						count( $articles ),
						$articleCount
					) . '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="user-articles-container">';

			$x = 1;

			foreach( $articles as $article ) {
				$articleTitle = Title::makeTitle(
					$article['page_namespace'],
					$article['page_title']
				);
				$voteCount = BlogPage::getVotesForPage( $article['page_id'] );
				$commentCount = BlogPage::getCommentsForPage( $article['page_id'] );

				if ( $x == 1 ) {
					$divClass = 'article-item-top';
				} else {
					$divClass = 'article-item';
				}
				$output .= '<div class="' . $divClass . "\">
					<div class=\"number-of-votes\">
						<div class=\"vote-number\">{$voteCount}</div>
						<div class=\"vote-text\">" .
							wfMsgExt(
								'blog-user-articles-votes',
								'parsemag',
								$voteCount
							) .
						'</div>
					</div>
					<div class="article-title">
						<a href="' . $articleTitle->escapeFullURL() .
							"\">{$articleTitle->getText()}</a>
						<span class=\"item-small\">" .
							wfMsgExt(
								'blog-user-article-comment',
								'parsemag',
								$commentCount
							) . '</span>
					</div>
					<div class="cleared"></div>
				</div>';

				$x++;
			}

			$output .= '</div>';
		}

		$wgOut->addHTML( $output );

		return true;
	}

	/**
	 * Register the canonical names for our namespace and its talkspace.
	 *
	 * @param $list Array: array of namespace numbers with corresponding
	 *                     canonical names
	 * @return Boolean: true
	 */
	public static function onCanonicalNamespaces( &$list ) {
		$list[NS_BLOG] = 'Blog';
		$list[NS_BLOG_TALK] = 'Blog_talk';
		return true;
	}

	/* optimization :)
	public static function updateFacebookProfile() {
		global $wgUser, $IP, $wgTitle, $wgServer, $wgSitename;

		// Check if the current user has the app installed
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'fb_link_view_opinions',
			array( 'fb_user_id', 'fb_user_session_key' ),
			array( 'fb_user_id_wikia' => $wgUser->getID() ),
			__METHOD__
		);

		if ( $s !== false ) {
			require_once "$IP/extensions/Facebook/appinclude.php";
			$facebook = new Facebook( $appapikey, $appsecret );
			//$facebook->api_client->auth_getSession( 'QR1YVV' );
			//$facebook->api_client->session_key = 'QR1YVV';

			// Update Facebook profile
			try {
				$facebook->api_client->session_key = $infinite_session_key;
				$facebook->api_client->fbml_refreshRefUrl(
					"http://sports.box8.tpa.wikia-inc.com/index.php?title=Special:FacebookGetOpinions&id={$s->fb_user_id}"
				);
			} catch( exception $ex ) {
			}

			$feedTitle = '<fb:userlink uid="' . $s->fb_user_id .
				'" /> wrote a new article on <a href="' . $wgServer . '">' .
				$wgSitename . '</a>';
			$feedBody = "<a href=\"{$wgTitle->getFullURL()}\">{$wgTitle->getText()}</a>";
			try{
				$facebook->api_client->feed_publishActionOfUser( $feedTitle, $feedBody );
			} catch( exception $ex ) {
			}
		}

		return true;
	}
	*/
}
