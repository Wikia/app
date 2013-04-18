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
		$writer = $this->getOption('writer');
		$publisher = $this->getOption('publisher');

		# Read the text
		$lyrics = $this->getStdin( Maintenance::STDIN_ALL );
		
		# Do the edit
		$this->output( "Creating tag ... " );
		if ( $page->exists() ) {
			$text = $page->getText();
			$re = '/additionalAlbums=([\'"])?((?(1).*?|[^\s>]+))(?(1)\1)/is';
			
			$albums = "";
			if ( preg_match( $re, $text, $match ) ) {
				$albums = $match[2];
			}
			$albums = sprintf( "%s%s%s", $albums, ( empty( $albums ) ) ? "" : ",", $album );
			$text = preg_replace( $re, "additionalAlbums=\"$albums\"", $text, 1 );			
		} else {
			$text = "<lyricfind artist=\"%s\" album=\"%s\" additionalAlbums=\"\" song=\"%s\" songwriter=\"%s\" publisher=\"%s\" amgid=%d>\n";
			$text.= "%s\n";
			$text.= "</lyricfind>";
			$text = sprintf( $text, $artist, $album, $song, $writer, $publisher, $lfid, $lyrics );
		}
		
		$this->output( "done\n");
		
		$this->output( "Saving... " );
		$status = $page->doEdit( $text, '', ( $bot ? EDIT_FORCE_BOT : 0 ) | ( $noRC ? EDIT_SUPPRESS_RC : 0 ) );
		if ( $status->isOK() ) {
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

