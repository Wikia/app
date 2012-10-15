<?php
/**
 * SwarmExport
 * @author Daniel Friesen http://mediawiki.org/wiki/User:Dantman
 * @version 1.0
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

if ( !isset( $options['outfile'] ) ) {
	echo <<<SH
Usage: php swarmExport.php --outfile=... [options...]

 --outfile=<file>      File to output swarm history to
 --append              Append new history instead of rebuilding
 --startid=<id>        For use with --append, specify a revision number instead
                       of autodetecting
 --pageprefix=<prefix> Prefix to add before titles, good if you are outputting
                       multiple wiki's into the same swarm log
 --namespaces=<ids>    Comma separated list of namespace id's to restrict to
 --usersonly           Ignore anon users and system users (anyone with id=0)
SH;
	exit( 0 );
}
$file = $options['outfile'];
$append = isset( $options['append'] );
$start = isset( $options['startid'] ) ? intval($options['startid']) : null;
$prefix = isset( $options['pageprefix'] ) ? $options['pageprefix'] : '';
$namespaces = isset( $options['namespaces'] )
	? array_map( 'intval', explode( ',', $options['namespaces'] ) )
	: null;

if ( !isset( $start ) ) {
	if ( $append ) {
		if ( $f = fopen( $file, 'r' ) ) {
			while ( !feof( $f ) ) {
				$line = fgets( $f );
				$x = explode( '|', $line );
				$num = $x[0];
				if ( is_numeric( $num ) ) $start = intval( $num );
			}
		}
		if ( !isset( $start ) ) die( 'Failed, could not guess rev id to start with' );
	} else $start = 0;
}

if ( $append ) {
	echo "Appending new history items to file starting at revision $start\n";
} else {
	if ( $start == 0 ) echo "Generating complete history report\n";
	else echo "Generating history report with only revision $start onwards\n";
}

$f = fopen( $file, $append ? 'a' : 'w' );

$db = wfGetDB( DB_SLAVE );
$conds = array( 'rev_page=page_id', 'rev_deleted' => 0, "rev_id > $start" );
if ( isset( $namespaces ) ) $conds['page_namespace'] = $namespaces;
if ( isset( $options['usersonly'] ) ) $conds[] = 'rev_user != 0';

echo "Starting db query:\n";

$res = $db->select( array( 'revision', 'page' ),
	array( 'rev_id', 'page_namespace', 'page_title', 'rev_user_text', /*'rev_minor_edit',*/ 'rev_timestamp' ),
	$conds, null, array( 'ORDER BY' => 'rev_id' ) );

printf( "Writing data for %s rows\n", $res->numRows() );

while ( $row = $res->fetchObject() ) {
	$time = wfTimestamp( TS_UNIX, $row->rev_timestamp );
	$title = $prefix . MWNamespace::getCanonicalName( $row->page_namespace ) . ':' . $row->page_title;
	fwrite( $f, "{$row->rev_id}|{$title}|{$row->rev_user_text}|{$time}\n" );
}

printf( "Completed output of %s history items to %s\n", $res->numRows(), $file );
