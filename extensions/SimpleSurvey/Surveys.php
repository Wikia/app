<?php

$wgSimpleSurveyRedirectURL = "";

$wgValidSurveys[] = 'vitals-07-2010';

$wgPrefSwitchSurveys['vitals-07-2010'] = array(
	'submit-msg' => 'vitals-07-2010-submit',
	'intro-msg' => 'simple-survey-intro-vitals-07-2010',
	'updatable' => false,
	'questions' => array(
		'use' => array(
			'question' => 'vitals-07-2010-question-use',
			'type' => 'select',
			'answers' => array(
					'blank' => 'vitals-07-2010-blank',
					'daily' => 'vitals-07-2010-answer-daily',
					'weekly' => 'vitals-07-2010-answer-weekly',
					'monthly' => 'vitals-07-2010-answer-monthly',
					'rarely' => 'vitals-07-2010-answer-rarely',
					'first' => 'vitals-07-2010-answer-firsttime',
				),
		),
		'edit' => array(
			'question' => 'vitals-07-2010-question-edit',
			'type' => 'select',
			'answers' => array(
					'blank' => 'vitals-07-2010-blank',
					'daily' => 'vitals-07-2010-answer-y-daily',
					'weekly' => 'vitals-07-2010-answer-y-weekly',
					'monthly' => 'vitals-07-2010-answer-y-monthly',
					'rarely' => 'vitals-07-2010-answer-y-rarely',
					'never' => 'vitals-07-2010-answer-n-never',
					'dunno' => 'vitals-07-2010-answer-dunno-edit',
				),
		),
		'nonprofit' => array(
			'question' => 'vitals-07-2010-question-nonprofit',
			'type' => 'select',
			'answers' => array(
					'blank' => 'vitals-07-2010-blank',
					'knew' => 'vitals-07-2010-answer-nonprof-knew',
					'business' => 'vitals-07-2010-answer-nonprof-business',
					'nothink' => 'vitals-07-2010-answer-nonprof-think',
				),
		),
		'wikimediafoundation' => array(
			'question' => 'vitals-07-2010-question-wikimedia',
			'type' => 'select',
			'answers' => array(
					'blank' => 'vitals-07-2010-blank',
					'notknow' => 'vitals-07-2010-answer-never-heard',
					'exists' => 'vitals-07-2010-answer-heard-nothing',
					'hosted' => 'vitals-07-2010-answer-hosted',
					'familiar' => 'vitals-07-2010-answer-know',
				),
		),
		'computerexp' => array(
			'question' => 'vitals-07-2010-question-computerexp',
			'type' => 'select',
			'answers' => array(
					'blank' => 'vitals-07-2010-blank',
					'beginner' => 'vitals-07-2010-answer-beginner',
					'one' => 'vitals-07-2010-answer-one-lang',
					'many' => 'vitals-07-2010-answer-many-lang',
					'none' => 'vitals-07-2010-answer-no-lang',
				),
		),
		'age' => array(
			'question' => 'vitals-07-2010-question-age',
			'type' => 'smallinput',
		),
		'gender' => array(
			'question' => 'vitals-07-2010-question-gender',
			'type' => 'select',
			'answers' => array(
					'blank' => 'vitals-07-2010-blank',
					'm' => 'vitals-07-2010-answer-male',
					'f' => 'vitals-07-2010-answer-female',
					'o' => 'vitals-07-2010-answer-other',
				),
		),
		'story' => array(
			'question' => 'vitals-07-2010-question-story',
			'type' => 'text',
		),
	),
);
