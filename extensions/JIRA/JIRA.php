<?php
/* Copyright (c) 2007 River Tarnell <river@wikimedia.org>.        */
/*
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or implied
 * warranty.
 */

/* @(#) $Id: JIRA.php 584 2008-07-29 13:59:13Z emil $ */


# To use:
# 
# * Make sure remote API is enabled in your JIRA.
# * Set $JIRAs similar to this:
#
#   $JIRAs = array(
#       'whit' => array(
#           'user' => 'river',
#           'password' => 'whatever',
#           'url' => 'http://whit.local/jira/rpc/soap/jirasoapservice-v2?wsdl',
#       ),
#   );
# * Add to LocalSettings.php: require_once(".../path/to/JIRA.php");
#
# Obviously, user, password and url need to be set to the URL of your JIRA
# installation.  You can configure as many JIRAs as you want.
#
# Also set:
#   $JIRAdefault = 'whit';
# 
# This sets the default jira install to use when none is specified.
# 
# To display a list of JIRA issues in a wiki page, do this:
#
# <jiralist jira="whit" projects="TEST,OTHER">
#   search term ...
# </jiralist>
#
# jira="" is optional, and defaults to $JIRAdefault.  projects="" is also
# optional; if not specified, all projects will be searched.  The search term
# is a quick search string, as describe at 
#   http://www.atlassian.com/software/jira/docs/v3.11/quicksearch.html

$wgExtensionFunctions[] = 'efJIRASetup';

function efJIRASetup() {
global	$wgParser;
	$wgParser->setHook( 'jiralist', 'efJIRARender' );
}
 
function efJIRARender( $input, $args, $parser ) {
global	$JIRAs, $JIRAdefault;
	try {
		if (isset($args['jira']))
			$which = $args['jira'];
		else
			$which = $JIRAdefault;

		$jira = new SoapClient($JIRAs[$which]['url']);

		$auth = $jira->login($JIRAs[$which]['user'], $JIRAs[$which]['password']);
		$info = $jira->getServerInfo($auth);
		$url = $info->baseUrl;

		if (isset($args['projects'])) {
			$projs = array_map('trim', explode(',', $args['projects']));
			$issues = $jira->getIssuesFromTextSearchWithProject($auth, $projs, $input, 100);
		} else
			$issues = $jira->getIssuesFromTextSearch($auth, $input);

		$statuses = $jira->getStatuses($auth);
		$priorities = $jira->getPriorities($auth);
		$resolutions = $jira->getResolutions($auth);

		$fields = array(
			'status' => $statuses, 
			'priority' => $priorities,
			'resolution' => $resolutions,
			'url' => $url);

		$s = "<table border='1' cellspacing='0'><tr><th>Key</th><th>Summary</th><th>Status</th><th>Pri</th><th>Res</th><th>Assignee</th></tr>";

		foreach ($issues as $issue) {
			$s .= JIRAformatOneIssue($jira, $auth, $fields, $issue);
		}

		$s .= "</table>";

		return $s;
	} catch (Exception $e) {
		return htmlspecialchars($e->getMessage());
	}
}

function JIRAfindId($objs, $id) {
	foreach ($objs as $o) {
		if ($o->id === $id)
			return $o;
	}

	return null;
}

function JIRAformatOneIssue($jira, $auth, $fields, $issue) {
	$statuses = $fields['status'];
	$priorities = $fields['priority'];
	$resolutions = $fields['resolution'];

	$key = htmlspecialchars($issue->key);
	$url = $fields['url'] . '/browse/' . $key;

	$summary = htmlspecialchars($issue->summary);
	$status = htmlspecialchars(JIRAfindId($statuses, $issue->status)->name);

	$p = JIRAfindId($priorities, $issue->priority);
	$priorityicon = htmlspecialchars($p->icon);
	$priority = htmlspecialchars($p->name);

	$assignee = $jira->getUser($auth, $issue->assignee);

	$resolution = htmlspecialchars(JIRAfindId($resolutions, $issue->resolution)->name);

	return "<tr><td><a href=\"$url\">$key</a></td><td>$summary</td><td>$status</td><td><img src=\"$priorityicon\" alt=\"$priority\" /></td><td>$resolution</td><td>{$assignee->fullname}</td></tr>";
}
