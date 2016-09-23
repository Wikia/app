<?php
/**
 * These permissions will be applied even when Forum extension is disabled
 *
 * @see PLATFORM-1664
 */
$wgAvailableRights[] = 'forum';
$wgAvailableRights[] = 'boardedit';
$wgAvailableRights[] = 'forumadmin';

$wgGroupPermissions['*']['forum'] = false;
$wgGroupPermissions['staff']['forum'] = true;
$wgGroupPermissions['sysop']['forum'] = true;
$wgGroupPermissions['bureaucrat']['forum'] = true;
$wgGroupPermissions['helper']['forum'] = true;

$wgGroupPermissions['*']['boardedit'] = false;
$wgGroupPermissions['staff']['boardedit'] = true;

$wgGroupPermissions['*']['forumoldedit'] = false;
$wgGroupPermissions['staff']['forumoldedit'] = true;
$wgGroupPermissions['helper']['forumoldedit'] = true;
$wgGroupPermissions['sysop']['forumoldedit'] = true;
$wgGroupPermissions['bureaucrat']['forumoldedit'] = true;

$wgGroupPermissions['*']['forumadmin'] = false;
$wgGroupPermissions['staff']['forumadmin'] = true;
$wgGroupPermissions['helper']['forumadmin'] = true;
$wgGroupPermissions['sysop']['forumadmin'] = true;
$wgGroupPermissions['threadmoderator']['forumadmin'] = true;
