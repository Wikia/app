<?php
/**********************************************************************************
Copyright (C) 2007-08 Sean Colombo (sean@lyricwiki.org)
Copyright (C) 2008 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki (http://lyrics.wikia.com/)

What has been verified:
* this works for most artists
* this works for artists with unicode characters
* puts merges when a page already exists
	- need to check to see if it skips redirect pages and just overwrites them.
* artists that have pages that need to be merged
* artists that have the artist page already moved

***********************************************************************************

Version 0.2.2	2008-04-13
* Bugfix: Encode HTML entities inside of hidden form inputs

Version 0.2.1 2008-03-03
* Convert text to i18n file
* Add confirmation step
* Add preview option
* Wikify script output

Version 0.1.1  ????-??-??
* Initial Coding

*/

if(!defined('MEDIAWIKI')) die();


require_once "extras.php";

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['BatchMove'] = $dir.'Special_BatchMove.i18n.php';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Batch Move',
	'author' => '[http://lyrics.wikia.com/User:Teknomunk teknomunk]',
	'description' => 'Batch move special page',
	'version' => '0.2.2',
);

require_once($IP . '/includes/SpecialPage.php');
$wgSpecialPages['Batchmove'] = 'Batchmove';

class Batchmove extends SpecialPage{

	public function __construct(){
		parent::__construct('Batchmove');
	}

	/**
	 *
	 * @param $par String subpage string, if one was specified
	 */
	function execute( $par ){
		global $wgOut;
		global $wgRequest, $wgUser;

		// get the parameters
		$from = trim($wgRequest->getText( 'from' ));
		$to = trim($wgRequest->getText( 'to' ));
		$reason = $wgRequest->getText( 'reason' );

		if( $from != "" and $to != "" )
		{
			if( $wgRequest->getVal("wpPreview") )
			{
				// Preview batch move
				$wgOut->addHTML(wfMsg("batchmove-preview-header")."<br/>");
				$wgOut->addHTML(doBatchMove( $from, $to, $reason, true ) );
				$wgOut->addHTML("<form>");
					$wgOut->addHTML("<input id='to' name='to' type='hidden' value='".htmlentities($to, ENT_QUOTES, "UTF-8")."' />");
					$wgOut->addHTML("<input id='from' name='from' type='hidden' value='".htmlentities($from, ENT_QUOTES, "UTF-8")."' />");
					$wgOut->addHTML("<input id='reason' name='reason' type='hidden' value='".htmlentities($reason, ENT_QUOTES, "UTF-8")."' />");
					$wgOut->addHTML("<input id='wpConfirm' name='wpConfirm' type='submit' value='".wfMsg("batchmove-confirm")."'/>");
					$wgOut->addHTML("<input id='wpPreview' name='wpPreview' type='submit' value='".wfMsg("batchmove-preview")."'/>");
				$wgOut->addHTML("</form>");
			}
			else if( $wgRequest->getVal("wpConfirm") )
			{
				// Do batch move
				$wgOut->addHTML(doBatchMove( $from, $to, $reason ));
				$wgOut->addHTML("<i>".wfMsg("batchmove-complete")."</i>");
			}
			else
			{
				$wgOut->setPageTitle(wfMsg("batchmove-title"));
				$wgOut->addHTML(sandboxParse(wfMsg("batchmove-confirm-msg",$from,$to)));
				$wgOut->addHTML("<form>");
					$wgOut->addHTML("<input id='to' name='to' type='hidden' value='".htmlentities($to, ENT_QUOTES, "UTF-8")."' />");
					$wgOut->addHTML("<input id='from' name='from' type='hidden' value='".htmlentities($from, ENT_QUOTES, "UTF-8")."' />");
					$wgOut->addHTML("<input id='reason' name='reason' type='hidden' value='".htmlentities($reason, ENT_QUOTES, "UTF-8")."' />");
					$wgOut->addHTML("<input id='wpConfirm' name='wpConfirm' type='submit' value='".wfMsg("batchmove-confirm")."'/>");
					$wgOut->addHTML("<input id='wpPreview' name='wpPreview' type='submit' value='".wfMsg("batchmove-preview")."'/>");
				$wgOut->addHTML("</form>");
			}
		}
		else
		{
			$wgOut->setPageTitle(wfMsg("batchmove-title"));
			$wgOut->addHTML(""
				.wfMsg("batchmove-description")
				."<br/><br/>"
				."<form>"
				.wfMsg("batchmove-from").": <input type='edit' name='from' size=28/>"
				."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
				.wfMsg("batchmove-to").": <input type='edit' name='to' size=28/>"
				."<br/><br/>"
				.wfMsg("batchmove-reason").": <input type='edit' name='reason' size=60/>"
				."<br/><br/>"
				."<input type='submit'/>"
				."<input id='wpPreview' name='wpPreview' type='submit' value='".wfMsg("batchmove-preview")."'/>"
				."</form><br/>"
				);
		}
	} // end execute()

} // end class Batchmove

function doBatchMove( $from, $to, $reason, $fake=false )
{
	# get the wiki title for the pages
	$from=str_replace(" ","_",$from);
	$to=str_replace(" ","_",$to);
	$fromRegexp = preg_replace("/[ _]/","[ _]",$from);
	$toNice = str_replace("_"," ",$to);

	# query database for all pages starting with $from
	$dbr =& wfGetDB( DB_SLAVE );
	$res = $dbr->select( 'page',
		array( 'page_namespace', 'page_title', 'page_is_redirect' ),
		array(
			'page_namespace' => 0,
			'page_title LIKE \'' . $dbr->escapeLike( $from ) .':%\'',
		),
		__METHOD__,
		array(
			'ORDER BY'  => 'page_title',
			'USE INDEX' => 'name_title',
		)
	);

	# make sure to log all actions of this
	$results = "";
	$results .= "From: $from<br/>";
	$results .= wfMsg("batchmove-header",$from,$to)."<br/>";

	# need to track pages so that they can be purged after all pages have been updated
	$pagesToPurge = Array();

	while( $s = $dbr->fetchObject( $res ) )
	{
		#$results .= "<hr>";
		$ot = Title::makeTitle( $s->page_namespace, $s->page_title );

		$titleRegexp = "/^$fromRegexp(|:[^\]]*)$/";
		if( preg_match( $titleRegexp, $ot->getText(), $matches ) )
		{
			$newTitle = preg_replace("/^$fromRegexp/",$to,$ot->getText());
			$nt = Title::newFromText( $newTitle );

			# keep track of pages that need to be purged
			array_push( $pagesToPurge, $nt );

			# replace text strings in the article in this manner => s/$from/$to/
			$ot_article = new Article( $ot );
			$ot_text = $ot_article->getContent();
			$ot_redirect = !( strpos( $ot_text, "#REDIRECT" ) === false );
			if( $nt->exists() )
			{
				$nt_article = new Article( $nt );
				$nt_text = $nt_article->getContent();
				$nt_redirect = !( strpos( $nt_text, "#REDIRECT" ) === false );
			}

			# update page contents
			if( !$ot_redirect )
			{
				# update text of articles to point to new pages
				$ot_text = preg_replace(("/\[\[".$fromRegexp."(|[:\|][^\]]*)\]\]/"),("[[".$toNice."$1]]"),$ot_text);
				$ot_text = preg_replace("@{{Song\|(.*)\|$fromRegexp}}@","{{Song|$1|$toNice}}",$ot_text);

				if( $nt->exists() )
				{
					$nt_text = preg_replace(("/\[\[".$fromRegexp."(|[:\|][^\]]*)\]\]/"),("[[".$toNice."$1]]"),$nt_text);
					$nt_text = preg_replace("@{{Song\|(.*)\|$fromRegexp}}@","{{Song|$1|$toNice}}",$nt_text);
				}
			}

			#$results .= "---<br/>";
			# mark for merge if the target page already exists
			if( $nt->exists() and !$nt_redirect and !$ot_redirect )
			{
				# add merge banner to new article if it does not already exist
				if( strpos( $ot_text, "{{mergeto|".$nt->getText()."}}" ) === FALSE )
					$ot_text = "{{mergeto|".$nt->getText()."}}\n".$ot_text;

				if( $nt->exists() and strpos( $nt_text, "{{mergefrom|".$ot->getText()."}}" ) === FALSE )
				{
					$nt_text = "{{mergefrom|".$ot->getText()."}}\n".$nt_text;

					$results .= wfMsg("batchmove-marked",$nt->getText())."<br/>";
				}

				if( !$fake )
				{
					$ot_article->doEdit( $ot_text, $reason, EDIT_UPDATE | EDIT_DEFER_UPDATES );
					if( $nt->exists() )
					{
						$nt_article->doEdit( $nt_text, $reason, EDIT_UPDATE | EDIT_DEFER_UPDATES );
					}
				}
			}
			else
			{
				if( !$fake )
				{
					$ot_article->doEdit( $ot_text, $reason, EDIT_UPDATE | EDIT_DEFER_UPDATES );
				}

				# move page
				if( $ot_redirect )
				{
					$results .= wfMsg("batchmove-skip",$ot->getText())."<br/>";
				}
				else
				{
					if( $fake or $ot->moveTo( $nt, true, $reason ) )
					{
						# be nice and report what has been done.
						$results .= wfMsg("batchmove-success",$ot->getText(), $nt->getText() )."<br/>";

						# move talk pages if the origional page was moved
						$ott = $ot->getTalkPage();
						if( $ott->exists() )
						{
							$ntt = $nt->getTalkPage();
							if( $fake or !$ott->moveTo( $ntt, true, $reason ) )
							{
								# be nice and report what has been done.
								$results .= wfMsg("batchmove-success",$ott->getText(), $ntt->getText() )."<br/>";
							}
							else
							{
								# be nice and report what has been done.
								$results .= wfMsg("batchmove-failed",$ott->getText(),$ntt->getText())."<br/>";
							}
						}
					}
					else
					{
						# be nice and report what has been done.
						$results .= wfMsg("batchmove-failed",$ot->getText(),$nt->getText())."<br/>";
					}
				}
			}
		}
		else
		{
			$results .= wfMsg("batchmove-skip",$ot->getText())."<br/>";
		}
	}

	$dbr->freeResult($res);

	# purge pages after everything has been moved
	foreach( $pagesToPurge as $title )
	{
		$title->invalidateCache();
	}

	return sandboxParse($results);
}
