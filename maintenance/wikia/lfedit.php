<?php
/**
 * Make an edit on LyricWiki in LyricFind namespace
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class LFEditCLI extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Edit an article from the command line, text is from stdin";
		# edit options
		$this->addOption( 'user', 'Username', false, true, 'u' );
		$this->addOption( 'bot', 'Bot edit', false, false, 'b' );
		$this->addOption( 'no-rc', 'Do not show the change in recent changes', false, false, 'r' );
		$this->addArg( 'title', 'Title of article to edit' );
		
		# lyrifind options
		$this->addOption( 'lfid', 'LyricFind ID', true, true );
		$this->addOption( 'artist', 'Artist name', true, true );
		$this->addOption( 'album', 'Album name', true, true );
		$this->addOption( 'song', 'Song name', true, true );
		$this->addOption( 'writer', 'Song writer', false, true );
		$this->addOption( 'publisher', 'Song publisher', false, true );
	}

	public function execute() {
		global $wgUser, $wgTitle;

		$userName = $this->getOption( 'user', 'UberBot' );
		$bot = $this->hasOption( 'bot' );
		$noRC = $this->hasOption( 'no-rc' );

		$wgUser = User::newFromName( $userName );
		if ( !$wgUser ) {
			$this->error( "Invalid username", true );
		}

		$wgTitle = Title::newFromText( $this->getArg() );
		if ( !$wgTitle ) {
			$this->error( "Invalid title", true );
		}
			
		$page = WikiPage::factory( $wgTitle );

		# Read LF params
		$lfid = $this->getOption('lfid');
		$artist = $this->getOption('artist');
		$album = $this->getOption('album');
		$song = $this->getOption('song');
		$songwriter = $this->getOption('writer');
		$publisher = $this->getOption('publisher');

		# Read the text
		$lyrics = $this->getStdin( Maintenance::STDIN_ALL );
		
		# Do the edit
		$this->output( "Creating tag ... " );
		if ( $page->exists() ) {
			$text = $page->getText();
			$re = '/%s=([\'"])?((?(1).*?|[^\s>]+))(?(1)\1)/is';			
		
			$old_album = "";
			foreach ( array( 'artist', 'album', 'song', 'songwriter', 'publisher', 'lfid' ) as $tag ) {
				$reTag = sprintf( $re, $tag  );
				
				$tag_value = "";
				if ( preg_match( $reTag, $text, $match ) ) {
					$tag_value = $match[2];
				}
				
				if ( $tag == 'album' ) {
					$old_album = $tag_value;
				} 					
				
				if ( $tag_value != $$tag ) {
					$text = preg_replace( $reTag, sprintf( "%s=\"%s\"", $tag, $$tag ), $text, 1 );	
				}
			}
			
			# check additionalAlbums
			if ( $old_album != "" && $album != $old_album ) {
				$albums = "";
				$reTag = sprintf( $re, 'additionalAlbums'  );
				if ( preg_match( $reTag, $text, $match ) ) {
					$albums = $match[2];
				}
				$additionalAlbums = array();
				if ( !empty( $albums ) ) {
					$additionalAlbums = explode(",", $albums);
				}
				
				if ( in_array( $album, $additionalAlbums ) ) {
					 unset($additionalAlbums[array_search($album, $additionalAlbums)]);
				}
				
				if ( !in_array( $old_album, $additionalAlbums ) ) {
					$additionalAlbums[] = $old_album;
					$text = preg_replace( $reTag, "additionalAlbums=\"" . implode( ",", $additionalAlbums ) . "\"", $text, 1 );	
				}
			}	
		} else {
			$text = "<lyricfind artist=\"%s\" album=\"%s\" additionalAlbums=\"\" song=\"%s\" songwriter=\"%s\" publisher=\"%s\" amgid=%d>\n";
			$text.= "%s\n";
			$text.= "</lyricfind>";
			$text = sprintf( $text, $artist, $album, $song, $songwriter, $publisher, $lfid, $lyrics );
		}
		
		$this->output( "done\n");
		
		$this->output( "Saving... " );
		$status = $page->doEdit( $text, '', ( $bot ? EDIT_FORCE_BOT : 0 ) | ( $noRC ? EDIT_SUPPRESS_RC : 0 ) );
		if ( $status->isOK() ) {
			$page_id = $page->getId();
			if ( empty( $page_id ) ) {
				if ( !empty( $status->value['revision'] ) ) {
					$page_id = $status->value['revision']->getPage();
				}
			}			
			if ( $page_id ) {
				global $wgStatsDB;
				$dbw = wfGetDB( DB_MASTER, array(), $wgStatsDB );
				$dbw->update( '`lyricfind`.`lf_track`', array( 'lw_id' => $page_id ), array( 'track_id' => $lfid ), __METHOD__ );
			}
			$this->output( "done\n" );
			$exit = 0;
		} else {
			$this->output( "failed\n" );
			$exit = 1;
		}
		if ( !$status->isGood() ) {
			$this->output( $status->getWikiText() . "\n" );
		}
		exit( $exit );
	}
}

$maintClass = "LFEditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

