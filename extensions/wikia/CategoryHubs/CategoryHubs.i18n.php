<?php
/**
 * Author: Sean Colombo
 * Date: 20091123
 *
 * Internationalization file for CategoryHub extension.
 */

$messages = array();

$messages['en'] = array(
	'cathub-desc' => 'Extension for turning category pages into a view of the category as a hub of activity. Designed for [http://answers.wikia.com answers.wikia.com]',
	'cathub-progbar-mouseover-answered'     => '$1% answered',
	'cathub-progbar-mouseover-not-answered' => '$1% not answered yet',
	'cathub-progbar-label-answered'         => 'Answered',
	'cathub-progbar-label-unanswered'       => 'Unanswered',
	'cathub-progbar-none-done'              => 'No questions answered yet',
	'cathub-progbar-all-done'               => 'All questions answered!',
	'cathub-progbar-allmost-done'           => '$1 unanswered {{PLURAL:$1|question|questions}} left!',

	// Keep in mind that there may be questions either unanswer/answered that just don't show up in this pagination so it would be wrong to say there are none in the category at all.
	'cathub-no-unanswered-questions'        => 'There are no unanswered questions to see right now.',
	'cathub-no-answered-questions'          => 'There are no answered questions to see right now.',

	'cathub-top-contributors'               => 'Top contributors to this category',
	'cathub-top-contribs-all-time'          => 'Of all time',
	'cathub-top-contribs-recent'            => 'In the last $1 {{PLURAL:$1|day|days}}',
	'cathub-question-asked-ago'             => 'asked $1 $2',
	'cathub-question-answered-ago'          => 'answered $1 $2',
	'cathub-question-asked-by'              => 'by $1',
	'cathub-anon-username'                  => 'a curious user',
	'cathub-answer-heading'                 => 'Answer',
	'cathub-button-answer'                  => 'Answer',
	'cathub-button-improve-answer'          => 'Improve answer',
	'cathub-button-rephrase'                => 'rephrase',
	'cathub-edit-success'                   => 'Your answer has been saved',
	'cathub-prev'                           => '&larr; Previous',
	'cathub-next'                           => 'Next &rarr;',
);
