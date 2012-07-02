<?php
/**
* HelpCommons
*
* @package MediaWiki
* @subpackage Extensions
*
* @author: Tim 'SVG' Weyer <SVG@Wikiunity.com>
*
* @copyright Copyright (C) 2011 Tim Weyer, Wikiunity
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
*/

if (!defined('MEDIAWIKI')) {
	echo "HelpCommons extension";
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'HelpCommons',
	'author'         => array( 'Tim Weyer' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:HelpCommons',
	'descriptionmsg' => 'helpcommons-desc',
	'version'        => '1.3.0', // 02-05-2012
);

// Internationalization
$wgExtensionMessagesFiles['HelpCommons'] = dirname( __FILE__ ) . '/HelpCommons.i18n.php';

// Help wiki(s) where the help namespace is fetched from
// You only need to give a database if you use help pages from your own wiki family so help pages are not fetched for help wiki from help wiki
// Examples:
// $wgHelpCommonsFetchingWikis['en']['no-database']['https://meta.wikimedia.org']['w'] = 'Help Wiki'; // https://meta.wikimedia.org/w/api.php
// $wgHelpCommonsFetchingWikis['de']['dewiki']['http://de.community.wikiunity.com']['no-prefix'] = 'dem deutschsprachigen Hilfe Wiki'; // http://de.community.wikiunity.com/api.php
// $wgHelpCommonsFetchingWikis['fr']['no-database']['http://fr.wikiunity.com']['no-prefix'] = 'Wikiunity Aidé'; // http://fr.wikiunity.com/api.php
// $wgHelpCommonsFetchingWikis['ja']['no-database']['http://meta.wikimedia.org']['w'] = 'Help Wiki'; // http://meta.wikimedia.org/w/api.php
$wgHelpCommonsFetchingWikis = array();

// Enable local discussions and add an extra tab to help wiki's talk or redirect local discussions to help wiki?
$wgHelpCommonsEnableLocalDiscussions = true;

// Show re-localized categories from help wiki?
$wgHelpCommonsShowCategories = true;

// Protection levels for the help namespace and its talk namespace
// $wgHelpCommonsProtection = 'existing'; => all existing help pages and their discussions
// $wgHelpCommonsProtection = 'all'; => every help page and every help page discussion
$wgHelpCommonsProtection = false;

// Hooks
$wgHooks['BeforePageDisplay'][] = 'fnHelpCommonsLoad';
$wgHooks['ArticleViewHeader'][] = 'fnHelpCommonsRedirectTalks';
$wgHooks['SkinTemplateTabs'][] = 'fnHelpCommonsInsertTabs';
$wgHooks['SkinTemplateNavigation'][] = 'fnHelpCommonsInsertTabsVector';
$wgHooks['getUserPermissionsErrors'][] = 'fnHelpCommonsProtection';
// This hook is not needed when 'TitleHelpCommonsPageIsKnown' and 'TitleHelpCommonsTalkIsKnown' hooks are used but it does not need to be removed
$wgHooks['LinkBegin'][] = 'fnHelpCommonsMakeBlueLinks';
// HelpCommons' hooks included in Title.php
// Please see https://www.mediawiki.org/wiki/Extension:HelpCommons to include these hooks
$wgHooks['TitleHelpCommonsPageIsKnown'][] = 'fnHelpCommonsPageIsKnown';
$wgHooks['TitleHelpCommonsTalkIsKnown'][] = 'fnHelpCommonsTalkIsKnown';

/**
 * @param $helppage Article
 * @return bool
 */
function fnHelpCommonsLoad( OutputPage &$helppage, Skin &$skin ) {
	global $wgRequest, $wgHelpCommonsFetchingWikis, $wgDBname, $wgLanguageCode, $wgOut, $wgHelpCommonsShowCategories, $wgContLang;

	$title = $helppage->getTitle();

	$action = $wgRequest->getVal( 'action', 'view' );
	if ( $title->getNamespace() != NS_HELP || ( $action != 'view' && $action != 'purge' ) ) {
		return true;
	}

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return true;
							}
						}

						$dbkey = $title->getDBkey();

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}

						// check if requested page does exist
						$apiResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $dbkey );
						$apiData = unserialize( $apiResponse );

						if ( !$apiResponse ) {
							return true;
						}

						if ( !$apiData ) {
							return true;
						}

						if ( !$apiData['query'] ) {
							return true;
						}

						foreach( $apiData['query']['pages'] as $pageId => $pageData ) {
							if ( !isset( $pageData['missing'] ) ) {

								// remove noarticletext message and its <div> if not existent (does remove all content)
								if ( !$title->exists() ) {
									$wgOut->clearHTML();
								}

								$response = file_get_contents( $url . $prefix . '/api.php?format=json&action=parse&prop=text|categorieshtml&redirects&disablepp&pst&text={{:Help:' . $dbkey . '}}' );
								$data = json_decode( $response, /*assoc=*/ true );
								$text = $data['parse']['text']['*'];
								$text_html = str_replace( '<span class="editsection">[<a href="'.$prefix.'/', '<span class="editsection">[<a href="'.$url.$prefix.'/', $text ); // re-locate [edit] links to help wiki
								if ( $wgHelpCommonsShowCategories ) {
									$categories = $data['parse']['categorieshtml']['*'];
									$categories_html = str_replace( '<a href="', '<a href="'.$url, $categories );
									$content = $text_html . $categories_html;
								} else {
									$content = $text_html;
								}
								$wgOut->addHTML( '<div id="helpCommons" style="border: solid 1px; padding: 10px; margin: 5px;">' . '<div class="helpCommonsInfo" style="text-align: right; font-size: smaller;padding: 5px;">' . wfMsgForContent( 'helpcommons-info', $name, '<a href="' . $url . $prefix . '/index.php?title=Help:' . $dbkey . '" title="' . $wgContLang->namespaceNames[NS_HELP] . ':' . str_replace( '_', ' ', $dbkey ) . '">' . $wgContLang->namespaceNames[NS_HELP] . ':' . str_replace( '_', ' ', $dbkey ) . '</a>' ) . '</div>' . $content . '</div>' );
								return false;
							} else {
								return true;
							}
						}

					}

				}
			}
		}
	}

	return true;
}

/**
 * @param $helppage
 * @param $fields
 * @return bool
 */
function fnHelpCommonsRedirectTalks( &$helppage, &$outputDone, &$pcache ) {
	global $wgHelpCommonsEnableLocalDiscussions, $wgHelpCommonsProtection, $wgHelpCommonsFetchingWikis, $wgLanguageCode, $wgDBname, $wgOut;

	$title = $helppage->getTitle();

	if ( $title->getNamespace() != NS_HELP_TALK || ( $wgHelpCommonsEnableLocalDiscussions && $wgHelpCommonsProtection != 'all' && $wgHelpCommonsProtection != 'existing' ) ) {
		return true;
	}

	$dbkey = $title->getDBkey();

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return true;
							}
						}

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}

						// check if requested page does exist
						$apiResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $dbkey );
						$apiData = unserialize( $apiResponse );

						if ( !$apiResponse ) {
							return true;
						}

						if ( !$apiData ) {
							return true;
						}

						if ( !$apiData['query'] ) {
							return true;
						}

						// check if page does exist
						foreach( $apiData['query']['pages'] as $pageId => $pageData ) {
							if ( !isset( $pageData['missing'] ) && !$title->exists() ) {
								$helpCommonsRedirectTalk = $url . $prefix . '/index.php?title=Help_talk:' . $dbkey;
								$wgOut->redirect( $helpCommonsRedirectTalk );
								return false;
							} else {
								return true;
							}
						}

					}

				}
			}
		}
	}

	return true;
}

/**
 * @param $talkpage Title
 * @param $content_actions
 * @return bool
 */
function fnHelpCommonsInsertTalkpageTab( $talkpage, &$content_actions ) {
	global $wgHelpCommonsEnableLocalDiscussions, $wgHelpCommonsProtection, $wgHelpCommonsFetchingWikis, $wgLanguageCode, $wgDBname, $wgUser;

	if ( ( $talkpage->getTitle()->getNamespace() != NS_HELP && $talkpage->getTitle()->getNamespace() != NS_HELP_TALK ) || !$wgHelpCommonsEnableLocalDiscussions || $wgHelpCommonsProtection == 'all' || $wgHelpCommonsProtection == 'existing' ) {
		return false;
	}

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return false;
							}
						}

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}


						// check if requested page does exist
						$apiResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $talkpage->getTitle()->getDBkey() );
						$apiData = unserialize( $apiResponse );

						if ( !$apiResponse ) {
							return false;
						}

						if ( !$apiData ) {
							return false;
						}

						if ( !$apiData['query'] ) {
							return false;
						}

						// check if page does exist
						foreach( $apiData['query']['pages'] as $pageId => $pageData ) {
							if ( !isset( $pageData['missing'] ) ) {

								$tab_keys = array_keys( $content_actions );

								// find the location of the 'talk' link, and
								// add the link to 'Discuss on help wiki' right before it
								$helpcommons_tab_talk = array(
									'class' => false,
									'text' => wfMsg( 'helpcommons-discussion' ),
									'href' => $url.$prefix.'/index.php?title=Help_talk:'.$talkpage->getTitle()->getDBkey(),
								);

								$tab_values = array_values( $content_actions );
								if ( $wgUser->getSkin()->getSkinName() == 'vector' ) {
									$tabs_location = array_search( 'help_talk', $tab_keys );
								} else {
									$tabs_location = array_search( 'talk', $tab_keys );
								}
								array_splice( $tab_keys, $tabs_location, 0, 'talk-helpwiki' );
								array_splice( $tab_values, $tabs_location, 0, array( $helpcommons_tab_talk ) );

								$content_actions = array();
								for ( $i = 0; $i < count( $tab_keys ); $i++ ) {
									$content_actions[$tab_keys[$i]] = $tab_values[$i];
								}

							}
						}

					}
				}
			}
		}
	}

	return false;
}

/**
 * @param $action Title
 * @param $content_actions
 * @return bool
 */
function fnHelpCommonsInsertActionTab( $action, &$content_actions ) {
	global $wgHelpCommonsFetchingWikis, $wgLanguageCode, $wgDBname, $wgUser, $wgVectorUseIconWatch;

	if ( $action->getTitle()->getNamespace() != NS_HELP ) {
		return false;
	}

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return false;
							}
						}

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}


						// check if requested page does exist
						$apiResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $action->getTitle()->getDBkey() );
						$apiData = unserialize( $apiResponse );

						if ( !$apiResponse ) {
							return false;
						}

						if ( !$apiData ) {
							return false;
						}

						if ( !$apiData['query'] ) {
							return false;
						}

						// check if page does exist
						foreach( $apiData['query']['pages'] as $pageId => $pageData ) {
							if ( !isset( $pageData['missing'] ) ) {

								$tab_keys = array_keys( $content_actions );

								// find the location of the 'edit' link or the 'watch' icon of vector, and
								// add the link to 'Edit on help wiki' right before it
								if ( array_search( 'edit', $tab_keys ) || array_search( 'watch', $tab_keys ) ) {

									$helpcommons_tab_edit = array(
										'class' => false,
										'text' => wfMsg( 'helpcommons-edit' ),
										'href' => $url.$prefix.'/index.php?title=Help:'.$action->getTitle()->getDBkey().'&action=edit',
									);

									$tab_values = array_values( $content_actions );
									if ( $wgUser->getSkin()->getSkinName() == 'vector' && $wgVectorUseIconWatch && !$action->getTitle()->exists() ) {
										$tabs_location = array_search( 'watch', $tab_keys );
									} else {
										$tabs_location = array_search( 'edit', $tab_keys );
									}
									array_splice( $tab_keys, $tabs_location, 0, 'edit-on-helpwiki' );
									array_splice( $tab_values, $tabs_location, 0, array( $helpcommons_tab_edit ) );

									$content_actions = array();
									for ( $i = 0; $i < count( $tab_keys ); $i++ ) {
										$content_actions[$tab_keys[$i]] = $tab_values[$i];
									}

								// find the location of the 'viewsource' link, and
								// add the link to 'Edit on help wiki' right before it
								} elseif ( array_search( 'viewsource', $tab_keys ) ) {

									$helpcommons_tab_edit = array(
										'class' => false,
										'text' => wfMsg( 'helpcommons-edit' ),
										'href' => $url.$prefix.'/index.php?title=Help:'.$action->getTitle()->getDBkey().'&action=edit',
									);

									$tab_values = array_values( $content_actions );
									$tabs_location = array_search( 'viewsource', $tab_keys );
									array_splice( $tab_keys, $tabs_location, 0, 'edit-on-helpwiki' );
									array_splice( $tab_values, $tabs_location, 0, array( $helpcommons_tab_edit ) );

									$content_actions = array();
									for ( $i = 0; $i < count( $tab_keys ); $i++ ) {
										$content_actions[$tab_keys[$i]] = $tab_values[$i];
									}

								} else {

									$content_actions['edit-on-helpwiki'] = array(
										'class' => false,
										'text' => wfMsg( 'helpcommons-edit' ),
										'href' => $url.$prefix.'/index.php?title=Help:'.$action->getTitle()->getDBkey().'&action=edit',
									);

								}

							} else {

								$tab_keys = array_keys( $content_actions );

								// find the location of the 'edit' link or the 'watch' icon of vector, and
								// add the link to 'Edit on help wiki' right before it
								if ( array_search( 'edit', $tab_keys ) || array_search( 'watch', $tab_keys ) ) {

									$helpcommons_tab_create = array(
										'class' => false,
										'text' => wfMsg( 'helpcommons-create' ),
										'href' => $url.$prefix.'/index.php?title=Help:'.$action->getTitle()->getDBkey().'&action=edit',
									);

									$tab_values = array_values( $content_actions );
									if ( $wgUser->getSkin()->getSkinName() == 'vector' && $wgVectorUseIconWatch && !$action->getTitle()->exists() ) {
										$tabs_location = array_search( 'watch', $tab_keys );
									} else {
										$tabs_location = array_search( 'edit', $tab_keys );
									}
									array_splice( $tab_keys, $tabs_location, 0, 'create-on-helpwiki' );
									array_splice( $tab_values, $tabs_location, 0, array( $helpcommons_tab_create ) );

									$content_actions = array();
									for ( $i = 0; $i < count( $tab_keys ); $i++ ) {
										$content_actions[$tab_keys[$i]] = $tab_values[$i];
									}

								} else {

									$content_actions['create-on-helpwiki'] = array(
										'class' => false,
										'text' => wfMsg( 'helpcommons-create' ),
										'href' => $url.$prefix.'/index.php?title=Help:'.$action->getTitle()->getDBkey().'&action=edit',
									);

								}

							}
						}

					}
				}
			}
		}
	}

	return false;
}

/**
 * @param $skin Title
 * @param $content_actions
 * @return bool
 */
function fnHelpCommonsInsertTabs( $skin, &$content_actions ) {
	fnHelpCommonsInsertTalkpageTab( $skin, $content_actions );
	fnHelpCommonsInsertActionTab( $skin, $content_actions );
	return true;
}

/**
 * @param $sktemplate Title
 * @param $links
 * @return bool
 */
function fnHelpCommonsInsertTabsVector( SkinTemplate &$sktemplate, array &$links ) {
	// the old '$content_actions' array is thankfully just a
	// sub-array of this one
	fnHelpCommonsInsertTalkpageTab( $sktemplate, $links['namespaces'] );
	fnHelpCommonsInsertActionTab( $sktemplate, $links['views'] );
	return true;
}

/**
 * @param $title Title
 * @param $user User
 * @param $action
 * @param $result
 * @return bool
 */
function fnHelpCommonsProtection( &$title, &$user, $action, &$result ) {
	global $wgHelpCommonsFetchingWikis, $wgDBname, $wgLanguageCode, $wgHelpCommonsEnableLocalDiscussions, $wgHelpCommonsProtection;

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return true;
							}
						}

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}

						$ns = $title->getNamespace();

						// don't protect existing pages
						if ( $title->exists() ) {
							return true;
						}

						// block actions 'create', 'edit' and 'protect'
						if ( $action != 'create' && $action != 'edit' && $action != 'protect' ) {
							return true;
						}

						if ( !$wgHelpCommonsEnableLocalDiscussions && $ns == NS_HELP_TALK ) {
							// error message if action is blocked
							$result = array( 'protectedpagetext' );
							// bail, and stop the request
							return false;
						}

						switch ( $wgHelpCommonsProtection ) {

							case 'all':
								if ( $ns == NS_HELP || $ns == NS_HELP_TALK ) {
								// error message if action is blocked
								$result = array( 'protectedpagetext' );
								// bail, and stop the request
								return false;
								}
							break;

							case 'existing':
								// check if requested page does exist
								$apiResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $title->getDBkey() );
								$apiData = unserialize( $apiResponse );

								if ( !$apiResponse ) {
									return true;
								}

								if ( !$apiData ) {
									return true;
								}

								if ( !$apiData['query'] ) {
									return true;
								}

								// check if page does exist
								foreach( $apiData['query']['pages'] as $pageId => $pageData ) {
									if ( !isset( $pageData['missing'] ) && ( $ns == NS_HELP || $ns == NS_HELP_TALK ) ) {
										// error message if action is blocked
										$result = array( 'protectedpagetext' );
										// bail, and stop the request
										return false;
									}
								}
							break;

							default:
							return true;
						}

					}

				}
			}
		}
	}

	return true;
}

/**
 * @param $skin
 * @param $target Title
 * @param $text
 * @param $customAttribs
 * @param $query
 * @param $options array
 * @param $ret
 * @return bool
 */
function fnHelpCommonsMakeBlueLinks( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
	global $wgHelpCommonsEnableLocalDiscussions, $wgHelpCommonsFetchingWikis, $wgLanguageCode, $wgDBname;

	if ( is_null( $target ) ) {
		return true;
	}

	if ( ( $target->getNamespace() != NS_HELP && $target->getNamespace() != NS_HELP_TALK ) || $target->exists() ) {
		return true;
	}

	if ( $wgHelpCommonsEnableLocalDiscussions && $target->getNamespace() == NS_HELP_TALK ) {
		return true;
	}

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return true;
							}
						}

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}

						// check if requested page does exist
						$apiResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $target->getDBkey() );
						$apiData = unserialize( $apiResponse );

						if ( !$apiResponse ) {
							return true;
						}

						if ( !$apiData ) {
							return true;
						}

						if ( !$apiData['query'] ) {
							return true;
						}

						// check if page does exist
						foreach( $apiData['query']['pages'] as $pageId => $pageData ) {
							if ( !isset( $pageData['missing'] ) ) {

								// remove "broken" assumption/override
								$brokenKey = array_search( 'broken', $options );
								if ( $brokenKey !== false ) {
									unset( $options[$brokenKey] );
								}

								// make the link "blue"
								$options[] = 'known';

							}
						}

					}

				}
			}
		}
	}

	return true;
}

/**
 * @param $page Article
 * @return bool
 */
function fnHelpCommonsPageIsKnown( $page ) {
	global $wgHelpCommonsFetchingWikis, $wgLanguageCode, $wgDBname;

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return false;
							}
						}

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}

						// check if requested page does exist
						$apiResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $page->getDBkey() );
						$apiData = unserialize( $apiResponse );

						if ( !$apiResponse ) {
							return false;
						}

						if ( !$apiData ) {
							return false;
						}

						if ( !$apiData['query'] ) {
							return false;
						}

						// check if page does exist
						foreach( $apiData['query']['pages'] as $pageId => $pageData ) {
							if ( !isset( $pageData['missing'] ) ) {
								return true;
							} else {
								return false;
							}
						}

					}

				}
			}
		}
	}

	return false;
}

/**
 * @param $talk Article
 * @return bool
 */
function fnHelpCommonsTalkIsKnown( $talk ) {
	global $wgHelpCommonsEnableLocalDiscussions, $wgHelpCommonsFetchingWikis, $wgLanguageCode, $wgDBname;

	if ( $wgHelpCommonsEnableLocalDiscussions ) {
		return false;
	}

	foreach ( $wgHelpCommonsFetchingWikis as $language => $dbs ) {
		foreach ( $dbs as $db => $urls ) {
			foreach ( $urls as $url => $helpWikiPrefixes ) {
				foreach ( $helpWikiPrefixes as $helpWikiPrefix => $name ) {
					if ( $wgLanguageCode == $language ) {

						if ( $db != 'no-database' ) {
							if ( $wgDBname == $db ) {
								return false;
							}
						}

						if ( $helpWikiPrefix != 'no-prefix' ) {
							$prefix = '/' . $helpWikiPrefix;
						} else {
							$prefix = '';
						}

						// check if requested page does exist
						$apiPageResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help:' . $talk->getDBkey() );
						$apiPageData = unserialize( $apiPageResponse );

						if ( !$apiPageResponse ) {
							return false;
						}

						if ( !$apiPageData ) {
							return false;
						}

						if ( !$apiPageData['query'] ) {
							return false;
						}

						// check if requested talkpage does exist
						$apiTalkResponse = file_get_contents( $url . $prefix . '/api.php?format=php&action=query&titles=Help_talk:' . $talk->getDBkey() );
						$apiTalkData = unserialize( $apiTalkResponse );

						if ( !$apiTalkResponse ) {
							return false;
						}

						if ( !$apiTalkData ) {
							return false;
						}

						if ( !$apiTalkData['query'] ) {
							return false;
						}

						// check if page and its talk do exist
						foreach( $apiPageData['query']['pages'] as $pageId => $pageData ) {
							foreach( $apiTalkData['query']['pages'] as $talkId => $talkData ) {
								if ( !isset( $pageData['missing'] ) && !isset( $talkData['missing'] ) ) {
									return true;
								} else {
									return false;
								}
							}
						}

					}

				}
			}
		}
	}

	return false;
}
