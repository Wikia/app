<?php
# Copyright (C) 2008 Chad Horohoe <innocentkiller@gmail.com>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 * SandboxMessage
 *
 * Add a predefined header message to the Sandbox of your wiki. As
 * defined by $wgSandboxName.
 *
 * @package MediaWiki
 */

$wgHooks['ParserBeforeStrip'][] = 'addSandboxMessage';
$wgSandboxNS = NS_PROJECT;
$wgSandboxName = 'Sandbox';

function addSandboxMessage( &$parser, &$text, &$strip_state ) {
	global $wgSandboxName, $wgSandboxNS;
	if ( $parser->mTitle->getNamespace() == $wgSandboxNS && $parser->mTitle->getText() == $wgSandboxName ) {
		$text = wfMsgForContent( $wgSandboxName ) . $text;
	}
	return true;
}
