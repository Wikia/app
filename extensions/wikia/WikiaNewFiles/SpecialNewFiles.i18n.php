<?php
/**
 * Internationalisation file for SpecialNewFiles extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'wikianewfiles-title' => 'New files on this wiki',
	'wikianewfiles-desc' => 'Extends a [[Special:NewFiles|special page]] to override some of the header formatting',
	'wikianewfiles-uploadby' => 'by {{GENDER:$2|$1}}',
	'wikianewfiles-postedin' => 'Posted in',
	'wikianewfiles-more' => 'more...',
);

$messages['qqq'] = array(
	'wikianewfiles-title' => 'Title of the special page.',
	'wikianewfiles-desc' => '{{desc}}',
	'wikianewfiles-uploadby' => 'Text displayed below a file to indicate which user uploaded the file.
* $1 is a link to the user page of the user who uploaded the file.
* $2 is the user name for GENDER support.',
	'wikianewfiles-postedin' => 'Text displayed below a file to indicate which articles the file is posted in.',
	'wikianewfiles-more' => 'Text displayed when there are more articles the file is posted in.',
);
