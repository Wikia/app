<?php
/**
 * TODO: Indicate which fields are optional.
 * TODO: Add comments to SQL queries (so ops ppl and other engineers will know what's going on).
 * TODO: When a user hits the page, automatically display their nominations on it (the token thing can probably go away & we can just use id's instead).
 * TODO: Use our code-conventions for linebreaks (not a huge issue).
 */

class SOTD extends SpecialPage
{
	function __construct()
	{
		parent::__construct( 'SOTD' );
		wfLoadExtensionMessages('SOTD');
		global $errors, $errorlist, $wgOut, $wgScriptPath, $wgStyleVersion;
		$wgOut->addStyle( "$wgScriptPath/extensions/SOTD/Special_SOTD.css?$wgStyleVersion" );
		$errors = array ( 'set' => false );
		$errorlist = '';
	}

	function addError ( $obj , $type='' )
	{
		global $errors, $errorlist;
		$errors['set'] = true;
		$errors[$obj] = true;
		if ( ! empty( $type ) )
		{
			$errorlist.='
										<li>'. wfMsg("sotd-error-$obj-$type").'</li>';
		}
	}

	function getFormat ( $obj )
	{
		global $wgRequest, $errors;
		$val = '';
		switch ( $obj ) {
			case 'checked';
				if ( $wgRequest->getBool('prefdate') ) { $val = ' checked="true"'; }; break;
			case 'prefdate';
			case 'artist';
			case 'song';
			case 'reason';
				if ( isset( $errors[$obj] ) ) { $val = ' class="sotd-error"'; }; break;
			default;
				$val = ''; break;
		}
		return $val;
	}

	function firstLetterUpperCase ( $title )
	{
		$parsed = '';			# Output
		$ucNext = true;		# Uppercase first letter
		$aTitle = str_split( $title );
		foreach ( $aTitle as $letter )
		{
			if ( $ucNext && ctype_alpha( $letter ) )
			{
				$parsed .= mb_strtoupper($letter, 'UTF-8');
				$ucNext = false;
			}
			else
			{
				$parsed .= $letter;
			};
			if ($letter == " ")
			{ # Uppercase next alpha character
				$ucNext = true;
			}
		}
		return $parsed;
	}

	function pageExists ( $title )
	{
		$pageTitle = Title::makeTitle(NS_MAIN, $title);
		return ( $pageTitle && $pageTitle->exists() );
	}

	function findPage ( &$artist , &$song )
	{
		# Best checking order according empiric knowledge (U = User's value, P = Parsed)
		# Check		Situation																				Reason																		Frequency
		# U:U			Everything entered correctly										User knows LyricWiki or clicked a link		Typical
		# U:P			Artist ok, title contains critical word					Artist is a name, title a phrase					Common
		# P:P			Artist and title contain critical words					All upper- or lowercase etc.							Unusual
		# P:U			Artist contains critical word, title does not		Exceptional song title										Rare
		if ( $this->pageExists( $artist.':'.$song ) )
		{
			return $artist.':'.$song;
		}
		else
		{
			$songF = $this->firstLetterUpperCase ( strtolower( $song ) );
			if ( $this->pageExists( $artist.':'.$songF ) )
			{
				$song = $songF;
				return $artist.':'.$songF;
			}
			else
			{
				$artistF = $this->firstLetterUpperCase ( strtolower( $artist ) );
				if ( $this->pageExists( $artistF.':'.$songF ) )
				{
					$artist = $artistF;
					$song = $songF;
					return $artistF.':'.$songF;
				}
				elseif ( $this->pageExists( $artistF.':'.$song ) )
				{
					$artist = $artistF;
					return $artistF.':'.$song;
				}
				else
				{
					return '';
				}
			}
		}
	}

	function getGoEarLink( $param )
	{
		return '<a href="http://www.goear.com/'.$param.'" target="_blank">'.wfMsg('sotd-audio').'</a>';
	}

	function getYouTubeLink( $param )
	{
		return '<a href="http://www.youtube.com/'.$param.'" target="_blank">'.wfMsg('sotd-video').'</a>';
	}

	function makeUserLink( $userId, $userName )
	{
		global $wgUser;

		if ( $userId == 0 )
		{
			$userLink = SpecialPage::getTitleFor( 'Contributions', $userName )->getPrefixedText();
			$userText = $userName;
		}
		else
		{
			$userLink = User::newFromName( User::whoIs( $userId ) )->getUserPage()->getPrefixedText();
			$userText = User::whoIsReal( $userId );
		}
		return "[[$userLink|$userText]]";
	}

	function execute( $par )
	{
		global $wgRequest, $wgOut, $wgUser, $wgPageName, $errors, $errorlist;

		$this->setHeaders();
		$canModify = $wgUser->isAllowed('moderatesotd');
		$action = $wgRequest->getText('action');
		$mode = $wgRequest->getText('mode');
		if ( $par == 'Admin' )
		{ # Admin mode subpage
			if ( $canModify )
			{
				if ( $wgRequest->wasPosted() )
				{
					if ( $action == "manage" )
					{
						$dbw = wfGetDB( DB_MASTER );
						$clearOld = $wgRequest->getBool('clearold');
						if ( $clearOld )
						{
							$aWeekAgo = mktime(0, 0, 0, date("m"), date("d")-7, date("Y"));
							$aMonthAgo = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
							$dbw->delete( 'sotdnoms' , array( "sn_prefdate is not NULL", "sn_prefdate<'$aWeekAgo'", "sn_status='4'" ) );
							$dbw->delete( 'sotdnoms' , array( "sn_nomdate<'$aMonthAgo'", "sn_status='4'" ) );
						}
						$values = $wgRequest->getValues();
						$ids = array_keys( $values );
						$count = 0;
						$text = '';
						foreach ( $ids as $id )
						{
							if ( is_numeric($id) )
							{ # Is a status
								$result = $dbw->update( 'sotdnoms' , array( 'sn_status' => $values[$id] ) , array( 'sn_id' => $id ) );
								if ( $values[$id] == 4 )
								{	# Accepted
									$sql = "SELECT * FROM sotdnoms WHERE sn_id=$id";
									$result = $dbw->doQuery( $sql );
									$row = $dbw->fetchRow( $result );
									$id = $row['sn_id'];
									$artist = $row['sn_artist'];
									$song = $row['sn_song'];
									$reason = $row['sn_reason'];
									$alink = $row['sn_audio'];
									$vlink = $row['sn_video'];
									$prefDate = $row['sn_prefdate'];
									$occasion = $row['sn_occasion'];
									$text .= "\n".
													"'''Song: \"[[$artist:$song|$song]]\" by [[$artist]]'''<br/>\n".
													"'''Nominated by:''' " . $this->makeUserLink( $row['sn_userid'] , $row['sn_username'] ) . "<br/>\n".
													"'''Reason:''' $reason<br/>\n";
									if ( $alink ) {
									$text .= "'''Audio:''' {{audio|$alink}}<br/>\n";
									}
									if ( $vlink ) {
									$text .= "'''Video:''' {{video|$vlink}}<br/>\n";
									}
									if ( ! is_null( $prefDate ))
									{
										$prefDateF = "'''Preferred Date:''' " . date( 'F j, Y', $prefDate );
										if ( ! empty( $occasion ) )
										{
											$prefDateF .= " ($occasion)";
										};
										$text .= "$prefDateF<br/>\n";
									};
									$text .= "\n<br/>";
									++$count;
								}
							}
						}
						if ( $count )
						{	# Insert into database
							$SOTDTitle = Title::makeTitle( NS_PROJECT, 'SOTD' );
							$SOTDArticle = new Article( $SOTDTitle , 0 );
							$content = $SOTDArticle->getContent();
							
							// Make sure the previous nominations (if there are any) end with two br's in a row.
							// If there are no previous nominations, there should still be one nomination.
							$matches = array();
							while(0 >= preg_match("/(==START==|<br\/?>)\s*<br\/>\s*$/is", $content, $matches)){
								$content .= "\n<br/>\n";
							}

							$content .= $text;
							$SOTDArticle->doEdit($content , ( $count > 1 ) ? "Accepted $count new nominations" : 'Accepted 1 new nomination' );
						}
					}
					else
					{
						$wgOut->addHTML(wfMsg('sotd-action-unknown') . "<br /><b>$action</b>");
					}
				}
				$dbw = wfGetDB( DB_SLAVE );
				$sql = 'SELECT * FROM sotdnoms';
				$result = $dbw->doQuery( $sql );
				$rows = $dbw->numRows( $result );
				if ( $rows )
				{
					$source = $wgOut->parseInline('[[' .
						$this->getTitle() . '|'.wfMsg('sotd-links-addone').']] | [[' .
						$this->getTitle() . '/Edit|'.wfMsg('sotd-links-view').']] | [[' .
						$this->getTitle() . '/Admin|'.wfMsg('sotd-links-refresh') . ']]');
					$wgOut->addHTML( '<span class="sotd-navlinks">
					' . $source . '
				</span>
				<form method="post" id="manage-sotd">
					<table cellspacing="0" cellpadding="3">
						<tr>
							<th>'.wfMsg('sotd-manage-id').'</th>
							<th>'.wfMsg('sotd-manage-nomination').'</th>
							<th>'.wfMsg('sotd-manage-nominatedby').'</th>
							<th>'.wfMsg('sotd-manage-reason').'</th>
							<th>'.wfMsg('sotd-manage-links').'</th>
							<th>'.wfMsg('sotd-manage-prefdate').'</th>
							<th>'.wfMsg('sotd-manage-status').'</th>
							<th>'.wfMsg('sotd-manage-token').'</th>
						</tr>');
					while( $row = $dbw->fetchRow( $result ) )
					{
						$id = $row['sn_id'];
						$nomdate = $row['sn_nomdate'];
						$nomdateF = date( 'F j, Y', $nomdate );
						$nominated = $this->makeUserLink( $row['sn_userid'] , $row['sn_username'] );
						$nominated = $wgOut->parseInline( "$nominated<br />''$nomdateF''" );
						$artist = $row['sn_artist'];
						$song = $row['sn_song'];
						$nomination = $wgOut->parseInline( "'''[[$artist:$song|$song]]'''<br />([[$artist]])" );
						$reason = $row['sn_reason'];
						$alink = $row['sn_audio'];
						$vlink = $row['sn_video'];
						$links = ( empty( $alink ) ) ? '' : $this->getGoEarLink( 'listen.php?v='.$alink );
						if ( ! ( empty( $alink ) || empty( $vlink ) ) )
						{
							$links .= '<br />';
						}
						$links .= ( empty( $vlink ) ) ? '' : $this->getYouTubeLink( 'watch?v='.$vlink );
						$prefDate = $row['sn_prefdate'];
						$occasion = $row['sn_occasion'];
						$token = $row['sn_token'];
						$status = $row['sn_status'];
						if ( is_null( $prefDate ))
						{
							$prefDateF = wfMsg('sotd-manage-noprefdate');
						}
						else
						{
							$prefDateF = date( 'F j, Y', $prefDate );
							if ( ! empty( $occasion ) )
							{
								$prefDateF .= "<br />''($occasion)''";
							}
							$prefDateF = $wgOut->parseInline( $prefDateF );
						};
						$wgOut->addHTML("
						<tr>
							<td class=\"id\">$id</td>
							<td class=\"ta-center\">$nomination</td>
							<td>$nominated</td>
							<td>$reason</td>
							<td>$links</td>
							<td>$prefDateF</td>".'
							<td class="ta-center">');
						if ( $status < 4 )
						{
							$wgOut->addHTML('
								<select name="'.$id.'" onChange="this.parentNode.parentNode.style.backgroundColor=\'#FFE0E0\'">');
						for ( $i = 0 ; $i < 5 ; ++$i )
						{
							$select = ( $status == $i ) ? '" selected="true"' : '"';
							$wgOut->addHTML("
									<option value=\"$i$select>".wfMsg('sotd-status-'.$i)."</option>");
						};
						$wgOut->addHTML('
								</select>');
						}
						else
						{
							$wgOut->addHTML(wfMsg('sotd-status-4'));
						}
						$wgOut->addHTML('
							</td>
							<td>'. $row['sn_token'] .'</td>
						</tr>');
					};
					$wgOut->addHTML('
						<tr class="submit">
							<td colspan="6" class="label" style="padding-right: 0;">
								<input type="hidden" name="action" value="manage" />
								<input type="checkbox" name="clearold" id="clearold"/>
								<label for="clearold">'.wfMsg('sotd-manage-clearold').'</label>
							</td>
							<td class="ta-center"><input type="submit" value="'.wfMsg('sotd-button-apply').'" /></td>
						</tr>
					</table>
				</form>
				');
				}
				else
				{
					$source = $wgOut->parseInline('[[' . $this->getTitle() . '|'.wfMsg('sotd-links-addone').']]');
					$wgOut->addHTML( '<p>'.wfMsg('sotd-manage-nonominations')."</p>
				<p>$source</p>
			");
				}
			}
			else
			{
				$this->displayRestrictionError();
				$wgOut->addHTML( wfMsgExt('sotd-thank-you', 'parseinline', $this->getTitle()->getPrefixedText() ) );
			}
		}
		elseif ( $par == 'Edit' )
		{ # Edit mode subpage
			$token = $wgRequest->getText('token');
			$source = ( $canModify ) ? $wgOut->parseInline('[[' . $this->getTitle() . '/Admin|'.wfMsg('sotd-links-manage').']] | ') : '' ;
			$source .= $wgOut->parseInline('[[' . $this->getTitle() . '|'.wfMsg('sotd-links-addone').']]');
			$wgOut->addHTML( '<span class="sotd-navlinks">
				' . $source . '
			</span>
			');
			if ( empty( $token ) )
			{	# No token supplied. Could be a deletion or a basic call
				if ( $action == "delete" && $wgRequest->wasPosted() )
				{	# A deletion has to be posted
					$id = $wgRequest->getText('id');
					$dbw = wfGetDB( DB_MASTER );
					$result = $dbw->delete( 'sotdnoms', array("sn_id='$id'" , "sn_status<'3'") );
					if ( $result )
					{	# Deletion successful. Maybe got another one?
						$wgOut->addHTML( $wgOut->parse( wfMsg('sotd-deletion-success') ) . '
				<form method="get" target="_self">
					<label for="token">'.wfMsg('sotd-edit-token').':</label>
					<input type="text" name="token" />
					<input type="submit" value="'.wfMsg('sotd-button-ok').'" />
				</form>
				');
					}
					else
					{ # Something went wrong on deletion. Retry or enter a different one.
						$wgOut->addHTML( $wgOut->parse( wfMsg('sotd-deletion-failure') ) . '
				<form method="post" target="_self">
					<input type="hidden" name="action" value="delete" />
					<input type="hidden" name="id" value="'.$id.'" />
					<input type="submit" value="'.wfMsg('sotd-button-retry').'" />
				</form>
				<form method="get" target="_self">
					<label for="token">'.wfMsg('sotd-edit-token').':</label>
					<input type="text" name="token" />
					<input type="submit" value="'.wfMsg('sotd-button-ok').'" />
				</form>
				');
					}
				}
				else
				{ # Basic visit, just output the form.
					$wgOut->addHTML( '<form method="get" target="_self">
					<label for="token">'.wfMsg('sotd-edit-token').':</label>
					<input type="text" name="token" />
					<input type="submit" value="'.wfMsg('sotd-button-ok').'" />
				</form>
				');
				}
			}
			else
			{	# A token was submitted to the page
				$dbw = wfGetDB( DB_SLAVE );
				$sql = "SELECT * FROM sotdnoms WHERE sn_token='$token'";
				$result = $dbw->doQuery( $sql );
				$rows = $dbw->numRows( $result );
				if ( $rows )
				{	# Try to retrieve the according nomination
					while ( $row = $dbw->fetchRow( $result ) )
					{
						$id = $row['sn_id'];
						$artist = $row['sn_artist'];
						$song = $row['sn_song'];
						$reason = $row['sn_reason'];
						$alink = $row['sn_audio'];
						$vlink = $row['sn_video'];
						$prefDate = $row['sn_prefdate'];
						$occasion = $row['sn_occasion'];
						if ( ! empty ( $prefDate ) )
						{ # Resurrect preferred date for edit mode
							$prefDay = date('j',$prefDate);
							$prefMonth = date('n',$prefDate);
							$prefYear = date('Y',$prefDate)-date('Y');
							$prefdate = '1';
						}
						else
						{ # No preferred date
							$prefDay = '';
							$prefMonth = '';
							$prefYear = '';
							$prefdate = '0';
						}
						$text = "\n".
										"'''Song: \"[[$artist:$song|$song]]\" by [[$artist]]'''<br/>\n".
										"'''Nominated by:''' " . $this->makeUserLink( $row['sn_userid'] , $row['sn_username'] ) . "<br/>\n".
										"'''Reason:''' $reason<br/>\n";
						if ( $alink ) {
						$text .= "'''Audio:''' {{audio|$alink}}<br/>\n";
						}
						if ( $vlink ) {
						$text .= "'''Video:''' {{video|$vlink}}<br/>\n";
						}
						if ( ! is_null( $prefDate ))
						{
							$prefDateF = "'''Preferred Date:''' " . date( 'F j, Y', $prefDate );
							if ( ! empty( $occasion ) )
							{
								$prefDateF .= " ($occasion)";
							};
							$text .= "$prefDateF<br/>\n";
						};
						$text .= "\n<br/>";
						$wgOut->addHTML( '<table cellspacing="0" cellpadding="3" id="edit-sotd">
					<tr>
						<td><label for="token">'.wfMsg('sotd-edit-token').':</label></td>
						<td>
							<form method="get" target="_self">
								<input type="text" name="token" value="'.$token.'" />
								<input type="submit" value="'.wfMsg('sotd-button-ok').'"/>
							</form>
						</td>
					</tr>
					<tr>
						<td>'.wfMsg('sotd-manage-status').':</td>
						<td>'.wfMsg('sotd-status-'.$row['sn_status']).'</td>
					</tr>
					<tr>
						<td><label for="preview">'.wfMsg('sotd-edit-preview').':</label></td>
						<td>'.$wgOut->parseInline( $text ).'</td>
					</tr>
					<tr>
						<td colspan="2" class="ta-center">');
							if ( ( $row['sn_status'] < 4 ) && $canModify && ( ! $wgUser->getID() == $row['sn_userid'] ) )
							{ # As manager, you can review nominations e. g. to fix typos, until they were accepted and posted
								$wgOut->addHTML('
							<form method="post" action="' . $this->getTitle()->getLocalURL() . '" target="_self">
								<input type="hidden" name="artist" value="'.$artist.'" />
								<input type="hidden" name="song" value="'.$song.'" />
								<input type="hidden" name="reason" value="'.$reason.'" />
								<input type="hidden" name="alink" value="'.$alink.'" />
								<input type="hidden" name="vlink" value="'.$vlink.'" />
								<input type="hidden" name="prefdate" value="'.$prefdate.'" />
								<input type="hidden" name="pday" value="'.$prefDay.'" />
								<input type="hidden" name="pmonth" value="'.$prefMonth.'" />
								<input type="hidden" name="pyear" value="'.$prefYear.'" />
								<input type="hidden" name="occasion" value="'.$occasion.'" />
								<input type="hidden" name="token" value="'.$token.'" />
								<input type="hidden" name="mode" value="review" />
								<input type="submit" value="'.wfMsg('sotd-button-review').'" />
							</form>
							<form method="get" target="_self">
								<input type="hidden" name="token" value="'.$token.'" />
								<input type="submit" value="'.wfMsg('sotd-button-refresh').'"/>
							</form>');
							}
							elseif ( $row['sn_status'] < 3 && ( $wgUser->getID() == $row['sn_userid'] ) )
							{ # You can edit or delete your own nominations until they are declined or accepted
								$wgOut->addHTML('
							<form method="get" target="_self">
								<input type="hidden" name="token" value="'.$token.'" />
								<input type="submit" value="'.wfMsg('sotd-button-refresh').'"/>
							</form>
							<form method="post" action="' . $this->getTitle()->getLocalURL() . '" target="_self">
								<input type="hidden" name="artist" value="'.$artist.'" />
								<input type="hidden" name="song" value="'.$song.'" />
								<input type="hidden" name="reason" value="'.$reason.'" />
								<input type="hidden" name="alink" value="'.$alink.'" />
								<input type="hidden" name="vlink" value="'.$vlink.'" />
								<input type="hidden" name="prefdate" value="'.$prefdate.'" />
								<input type="hidden" name="pday" value="'.$prefDay.'" />
								<input type="hidden" name="pmonth" value="'.$prefMonth.'" />
								<input type="hidden" name="pyear" value="'.$prefYear.'" />
								<input type="hidden" name="occasion" value="'.$occasion.'" />
								<input type="hidden" name="token" value="'.$token.'" />
								<input type="submit" value="'.wfMsg('sotd-button-edit').'" />
							</form>
							<form method="post" action="' . $this->getTitle()->getLocalURL() . '/Edit" target="_self">
								<input type="hidden" name="action" value="delete" />
								<input type="hidden" name="id" value="'.$id.'" />
								<input type="submit" value="'.wfMsg('sotd-button-delete').'" />
							</form>');
							}
							elseif ( $row['sn_status'] < 3 )
							{ # Even with the token, you can only view other's nominations (log in to edit)
								$wgOut->addHTML('
							<form method="get" target="_self">
								<input type="hidden" name="token" value="'.$token.'" />
								<input type="submit" value="'.wfMsg('sotd-button-refresh').'"/>
							</form>');
							}
							else
							{ # De facto it's impossible to be perform changes to status 4 nominations on a normal way
								$wgOut->addHTML( wfMsg('sotd-edit-toolate') );
							}
							$wgOut->addHTML('
						</td>
					</tr>
				</table>
				');
					}
				}
				else
				{ # The token isn't in our database [anymore]
					$wgOut->addHTML( $wgOut->parse( "'''" . wfMsg('sotd-edit-nosuchtoken') . "'''" ) . '
				<form method="get" target="_self">
					<label for="token">'.wfMsg('sotd-edit-token').':</label>
					<input type="text" name="token" value="'.$token.'" />
					<input type="submit" value="'.wfMsg('sotd-button-ok').'" />
				</form>
				');
				};
			}
		}
		else
		{ # No subpage was called, retrieve the usual request data
			$artist = $wgRequest->getText('artist');
			$song = $wgRequest->getText('song');
			$reason = $wgRequest->getText('reason');
			$vlink = $wgRequest->getText('vlink');
			$alink = $wgRequest->getText('alink');
			$prefDay = $wgRequest->getInt('pday');
			$prefMonth = $wgRequest->getInt('pmonth');
			$prefYear = $wgRequest->getInt('pyear');
			$occasion = $wgRequest->getText('occasion');
			$prefDate = NULL;
			$token = $wgRequest->getText('token');
			if ( $action == 'save' )
			{ # Action "save" means the user really tried to submit the nomination/edit. Check values
				if ( empty ( $artist ) )
				{ # Error: No artist provided
					$this->addError( 'artist' , 'undefined' );
				}
				elseif ( ! $this->pageExists( $artist ) )
				{	# Error: Artist provided but unknown
					$this->addError( 'artist' , 'unknown' );
				}
				if ( empty( $song ) )
				{ # Error: No song provided
					$this->addError( 'song' , 'undefined' );
				}
				elseif ( ! empty ( $artist ) )
				{	# Artist ok, song provided; check song
					$page = $this->findPage( $artist , $song );
					if ( empty( $page ) )
					{ # Error: Unknown song
						$this->addError( 'song' , 'unknown' );
					}
				}
				if ( empty ( $reason ) )
				{ # Error: No reason provided
					$this->addError( 'reason' , 'undefined' );
				}
				if ( $wgRequest->getBool('prefdate') )
				{ # Check date
					if ( ! checkdate( $prefMonth , $prefDay , $prefYear + date('Y') ) )
					{ # Error: Not a valid date (e. g. "Feb 30")
						$this->addError( 'prefdate' , 'invalid' );
					}
					else
					{	# Valid date, but maybe in the past?
						$prefDate = mktime( 0, 0, 0, $prefMonth, $prefDay, $prefYear + date('Y'));
						if ( $prefDate <= time() )
						{ # Error: Date was in the past
							$this->addError( 'prefdate' , 'past' );
							unset( $prefDate );
						}
					}
				}
				else
				{	# No preferred date set, no occasion needed
					$occasion = '';
				}
			}
			else
			{ # Wasn't a save request, prevent from insertion into database by triggering the unspecific error
				$this->addError( 'set' );
			}
			if ( ! $errors['set'] )
			{	# No errors occured
				if ( empty( $token ) )
				{	# No token yet => seems to be a new nomination
					$dbw = wfGetDB( DB_MASTER );
					$now = time();
					$token = md5( $now );
					$dbw->insert('sotdnoms', array(
						'sn_userid'		=> $wgUser->getID(),
						'sn_username'	=> $wgUser->getName(),
						'sn_artist'		=> $artist,
						'sn_song'			=> $song,
						'sn_reason'		=> $reason,
						'sn_video'		=> $vlink,
						'sn_audio'		=> $alink,
						'sn_prefdate'	=> $prefDate,
						'sn_occasion' => $occasion,
						'sn_nomdate'	=> $now,
						'sn_token'		=> $token
					));
					$wgOut->addHTML( wfMsgExt('sotd-thank-you', 'parseinline', array ( $token , $this->getTitle() )) . '
					');
					$token = ''; # Security
				}
				else
				{	# A token was submitted, seems to be an attempt to update
					$dbw = wfGetDB( DB_MASTER );
					$sql = "SELECT * FROM sotdnoms WHERE sn_token='$token'";
					$result = $dbw->doQuery( $sql );
					$rows = $dbw->numRows( $result );
					if ( $rows )
					{
						while ( $row = $dbw->fetchRow( $result ) )
						{
							$status = $row['sn_status'];
							if ( ( $mode == 'review' ) && $canModify && ( $status < 4 ) )
							{ # Silently perform changes without taking over the nomination (managers only)
								$dbw->update('sotdnoms', array(
									'sn_artist'		=> $artist,
									'sn_song'			=> $song,
									'sn_reason'		=> $reason,
									'sn_video'		=> $vlink,
									'sn_audio'		=> $alink,
									'sn_prefdate'	=> $prefDate,
									'sn_occasion' => $occasion,
									'sn_token'		=> $token
								), array("sn_token='$token'", "sn_status<'4'"));
								$wgOut->addHTML( $wgOut->parse( wfMsg('sotd-edit-success-review') ) . wfMsgExt('sotd-back-to-page', 'parseinline', $this->getTitle()->getPrefixedText() ) );
							}
							elseif ( $status < 3 )
							{	# Others can perform a usual edit which will set a new submission date etc.
								$now = time();
								if ( $status == 2 )
								{	# If the status was already set to "suitable", inform the manager about the modification
									$status = 1;
								}
								$dbw->update('sotdnoms', array(
									'sn_userid'		=> $wgUser->getID(),
									'sn_username'	=> $wgUser->getName(),
									'sn_artist'		=> $artist,
									'sn_song'			=> $song,
									'sn_reason'		=> $reason,
									'sn_video'		=> $vlink,
									'sn_audio'		=> $alink,
									'sn_prefdate'	=> $prefDate,
									'sn_occasion' => $occasion,
									'sn_nomdate'	=> $now,
									'sn_token'		=> $token,
									'sn_status'   => $status
								), array("sn_token='$token'", "sn_status<'3'"));
								$wgOut->addHTML( $wgOut->parse( wfMsg('sotd-edit-success') ) . wfMsgExt('sotd-back-to-page', 'parseinline', $this->getTitle()->getPrefixedText() ) );
							}
							else
							{	# The nomination was already accepted
								$wgOut->addHTML( $wgOut->parse( wfMsg('sotd-edit-toolate') ) . wfMsgExt('sotd-back-to-page', 'parseinline', $this->getTitle()->getPrefixedText() ) );
							}
						}
					}
					else
					{ # Something went wrong
						$wgOut->addHTML( $wgOut->parse( wfMsg('sotd-edit-failure') ) . wfMsgExt('sotd-back-to-page', 'parseinline', $this->getTitle()->getPrefixedText() ) );
					}
				}
			}
			else
			{ # Detected errors or wasn't a post request => default output
				if ( empty( $alink ) )
				{
					if ( empty ( $artist ) || empty ( $song ) )
					{ # Link to GoEar
						$audio='';
					}
					else
					{ # Define a GoEar search
						$audio="search/$artist $song/&utm_source=opensearch";
					}
				}
				else
				{ # Link to GoEar song
					$audio="listen.php?v=$alink";
				}
				if ( empty( $vlink ) )
				{
					if ( empty ( $artist ) || empty ( $song ) )
					{	# Link to YouTube
						$video='';
					}
					else
					{ # Define a YouTube search
						$video="results?search_query=$artist $song&utm_source=opensearch";
					}
				}
				else
				{ # Link to YouTube video
					$video="watch?v=$vlink";
				}
				$source = ( $canModify ) ? $wgOut->parseInline('[[' . $this->getTitle() . '/Admin|'.wfMsg('sotd-links-manage').']] | ') : '' ;
				$source .= $wgOut->parseInline('[[' . $this->getTitle() . '/Edit|'.wfMsg('sotd-links-view').']]');
				$wgOut->addHTML( '<span class="sotd-navlinks">
					' . $source . '
				</span>
				');
				# Insert the form
				$wgOut->addHTML( '<form method="post" id="add-sotd">
							<table cellspacing="0" cellpadding="3">
								<tr'. $this->getFormat( 'artist' ) .'>
									<td class="label">'.wfMsg('sotd-artist').':</td>
									<td><input type="text" name="artist" value="'.$artist.'" placeholder="'.wfMsg('sotd-placeholder-artist').'" /></td>' );
				# Errors column
				if ( ! empty( $errorlist ) )
				{
					$wgOut->addHTML( '
									<td rowspan="8" class="sotd-error-col">
										<b>' . wfMsgExt( 'sotd-error-title', 'parseinline', ( sizeof( $errors )-1 )) . '</b>
										<ul>' . $errorlist . '
										</ul>
									</td>' );
				}
				$wgOut->addHTML( '
								</tr>
								<tr'. $this->getFormat( 'song' ) .'>
									<td class="label">'.wfMsg('sotd-song').':</td>
									<td><input type="text" name="song" value="'.$song.'" placeholder="'.wfMsg('sotd-placeholder-song').'" /></td>
								</tr>
								<tr'. $this->getFormat( 'reason' ) .'>
									<td class="label">'.wfMsg('sotd-reason').':</td>
									<td><textarea name="reason" placeholder="'.wfMsg('sotd-placeholder-reason').'">'.$reason.'</textarea></td>
								</tr>
								<tr>
									<td class="label">'.$this->getYouTubeLink( $video ).':</td>
									<td><input type="text" name="vlink" value="'.$vlink.'" placeholder="'.wfMsg('sotd-placeholder-video').'" /></td>
								</tr>
								<tr>
									<td class="label">'.$this->getGoEarLink( $audio ).':</td>
									<td><input type="text" name="alink" value="'.$alink.'" placeholder="'.wfMsg('sotd-placeholder-audio').'" /></td>
								</tr>
								<tr'. $this->getFormat( 'prefdate' ) .'>
									<td class="label">'.wfMsg('sotd-prefdate').':</td>
									<td class="input">
										<input type="checkbox" name="prefdate" id="prefdate"'. $this->getFormat('checked') . '/>
										<label for="prefdate" style="margin-right: 1em">'.wfMsg('sotd-yes').'</label>
										<select name="pday" style="width: 40px;">');
				for ( $i = 1 ; $i < 32 ; ++$i )
				{
					$select = ( $prefDay == $i ) ? ' selected="true"' : '';
					$wgOut->addHTML( "
											<option value=\"$i\"$select>$i</option>");
				}
				$wgOut->addHTML( '
										</select>
										<select name="pmonth" style="width: 40px;">');
				for ( $i = 1 ; $i < 13 ; ++$i )
				{
					$select = ( $prefMonth == $i ) ? ' selected="true"' : '';
					$wgOut->addHTML( "
											<option value=\"$i\"$select>$i</option>");
				}
				unset( $select ); # remove text from variable to re-use it as array
				$select = array ('', '');
				$select[$prefYear]=' selected="true"';
				$useMsg = ( empty( $token ) ) ? 'nominate' : 'apply';
				$wgOut->addHTML( '
										</select>
										<select name="pyear" style="min-width: 85px;">
											<option value="0"'.$select[0].'>'.wfMsg('sotd-thisyear').'</option>
											<option value="1"'.$select[1].'>'.wfMsg('sotd-nextyear').'</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="label">'.wfMsg('sotd-occasion').':</td>
									<td><input type="text" name="occasion" maxlength="255" value="'.$occasion . '" placeholder="'.wfMsg('sotd-placeholder-occasion').'" /></td>
								<tr>
									<td style="text-align: center;" colspan="2">
										<input type="hidden" name="mode" value="'.$mode.'" />
										<input type="hidden" name="action" value="save" />
										<input type="hidden" name="token" value="'.$token.'" />
										<input type="submit" value="'. wfMsg('sotd-button-'.$useMsg ) .'" />
									</td>
								</tr>
							</table>
						</form>
					' );
			}
		}
	}
}
