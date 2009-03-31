<?php
/**
 * Special Page for the LogEntry extension
 *
 * @file
 * @ingroup Extensions
 */

// LogEntry special page
class LogEntry extends UnlistedSpecialPage {
	
	/* Functions */
	
	public function __construct() {
		// Register the special page as unlisted
		UnlistedSpecialPage::UnlistedSpecialPage( 'LogEntry' );
		
		// Internationalization
		wfLoadExtensionMessages( 'LogEntry' );
	}
	
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;
		global $egLogEntryUserName, $egLogEntryTimeStamp;
		
		// Begin output
		$this->setHeaders();
		
		// Check that the form was submitted
		if( $wgRequest->wasPosted() ) {
			// Check token
			if( !$wgUser->matchEditToken( $wgRequest->getText('token') ) )
			{
				// Alert of invalid page
				$wgOut->addWikiMsg( 'logentry-invalidtoken' );
				return;
			}
			
			// Get page
			$page = $wgRequest->getText('page');
			
			// Get title
			$title = Title::newFromText( $page );
			
			// Check permissions
			if( $title && $title->userCan( 'edit', $page ) )
			{
				// Get article
				$article = new Article( $title );
				
				// Build new line
				$newLine = '*';
				if ( $egLogEntryUserName ) {
					$newLine .= ' ' . $wgUser->getName();
				}
				if ( $egLogEntryTimeStamp ) {
					$newLine .= ' ' . gmdate( 'H:i' );
				}
				$newLine .= ': ' . str_replace( "\n", '<br />',
					trim( htmlspecialchars( $wgRequest->getText( 'line' ) ) )
				);
				
				// Get content without logentry tag in it
				$content = $article->getContent();
				
				// Detect section date
				$contentLines = explode( "\n", $content );
				
				// Build heading
				$heading = sprintf( '== %s ==', gmdate( 'F j' ) );
				
				// Find line of first section
				$sectionLine = false;
				foreach( $contentLines as $i => $contentLine )
				{
					// Look for == starting at the first character
					if(strpos( $contentLine, '==' ) === 0) {
						$sectionLine = $i;
						break;
					}
				}
				
				// Assemble final output
				$output = '';
				if( $sectionLine !== false )
				{
					// Lines up to section
					$preLines = array_slice( $contentLines, 0, $sectionLine );
					
					// Lines after section
					$postLines = array_slice( $contentLines, $sectionLine + 1 );
					
					// Output Lines
					$outputLines = array(); 
					
					if( trim( $contentLines[$sectionLine] ) == $heading ) {
						// Top section is current
						$outputLines = array_merge(
							$preLines,
							array(
								$contentLines[$sectionLine],
								$newLine
							),
							$postLines
						);
					}
					else
					{
						// Top section is old
						$outputLines = array_merge(
							$preLines,
							array(
								$heading,
								$newLine,
								$contentLines[$sectionLine]
							),
							$postLines
						);
					}
					$output = implode( "\n", $outputLines );
				}
				else
				{
					// There is no section, make one
					$output = sprintf( "%s\n%s\n%s", $content, $heading, $newLine );
				}
				
				// Edit article
				$article->quickEdit( $output );
				
				// Redirect
				$wgOut->redirect( $title->getPrefixedURL() );
			}
		}
		// Alert of invalid page
		$wgOut->addHTML( wfMsgHtml( 'logentry-invalidpage' ) . ": {$page}" );
	}
}
