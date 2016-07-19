<?php
/** Aramaic (ܐܪܡܝܐ)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author 334a
 * @author A2raya07
 * @author Basharh
 * @author Man2fly2002
 * @author Michaelovic
 * @author The Thadman
 */

$rtl = true;

$namespaceNames = array(
	NS_MEDIA            => 'ܡܝܕܝܐ',
	NS_SPECIAL          => 'ܕܝܠܢܝܐ',
	NS_MAIN             => '',
	NS_TALK             => 'ܡܡܠܠܐ',
	NS_USER             => 'ܡܦܠܚܢܐ',
	NS_USER_TALK        => 'ܡܡܠܠܐ_ܕܡܦܠܚܢܐ',
	NS_PROJECT_TALK     => 'ܡܡܠܠܐ_ܕ$1',
	NS_FILE             => 'ܠܦܦܐ',
	NS_FILE_TALK        => 'ܡܡܠܠܐ_ܕܠܦܦܐ',
	NS_MEDIAWIKI        => 'ܡܝܕܝܐܘܝܩܝ',
	NS_MEDIAWIKI_TALK   => 'ܡܡܠܠܐ_ܕܡܝܕܝܐܘܝܩܝ',
	NS_TEMPLATE         => 'ܩܠܒܐ',
	NS_TEMPLATE_TALK    => 'ܡܡܠܠܐ_ܕܩܠܒܐ',
	NS_HELP             => 'ܥܘܕܪܢܐ',
	NS_HELP_TALK        => 'ܡܡܠܠܐ_ܕܥܘܕܪܢܐ',
	NS_CATEGORY         => 'ܣܕܪܐ',
	NS_CATEGORY_TALK    => 'ܡܡܠܠܐ_ܕܣܕܪܐ',
);

$namespaceAliases = array(
	'ܡܬܚܫܚܢܐ'        => NS_USER,
	'ܡܡܠܠܐ_ܕܡܬܚܫܚܢܐ' => NS_USER_TALK,
);

$specialPageAliases = array(
	'Allmessages'               => array( 'ܟܠ_ܐܓܪ̈ܬܐ' ),
	'Allpages'                  => array( 'ܟܠ_ܦܐܬܬ̈ܐ' ),
	'Blankpage'                 => array( 'ܦܐܬܐ_ܣܦܝܩܬܐ' ),
	'Categories'                => array( 'ܣܕܪ̈ܐ' ),
	'Contributions'             => array( 'ܫܘܬܦܘܝܬ̈ܐ' ),
	'CreateAccount'             => array( 'ܒܪܝ_ܚܘܫܒܢܐ' ),
	'DeletedContributions'      => array( 'ܫܘܬܦܘܝܬ̈ܐ_ܫܝܦܬ̈ܐ' ),
	'Filepath'                  => array( 'ܫܒܝܠܐ_ܕܦܐܬܐ' ),
	'Log'                       => array( 'ܣܓܠ̈ܐ' ),
	'Longpages'                 => array( 'ܦܐܬܬ̈ܐ_ܐܪ̈ܝܟܬܐ' ),
	'Movepage'                  => array( 'ܫܢܝ_ܦܐܬܐ' ),
	'Mycontributions'           => array( 'ܫܘܬܦܘܝܬ̈ܝ' ),
	'Newpages'                  => array( 'ܦܐܬܬ̈ܐ_ܚܕ̈ܬܬܐ' ),
	'Preferences'               => array( 'ܓܒܝܬ̈ܐ' ),
	'Protectedpages'            => array( 'ܦܐܬܬ̈ܐ_ܢܛܝܪ̈ܬܐ' ),
	'Protectedtitles'           => array( 'ܟܘܢܝ̈ܐ_ܢܛܝܪ̈ܐ' ),
	'Recentchanges'             => array( 'ܫܘܚܠܦ̈ܐ_ܚܕ̈ܬܐ' ),
	'Search'                    => array( 'ܒܨܝܐ' ),
	'Shortpages'                => array( 'ܦܐܬܬ̈ܐ_ܟܪ̈ܝܬܐ' ),
	'Specialpages'              => array( 'ܦܐܬܬ̈ܐ_ܕ̈ܝܠܢܝܬܐ' ),
	'Upload'                    => array( 'ܐܣܩ' ),
	'Watchlist'                 => array( 'ܪ̈ܗܝܬܐ' ),
	'Whatlinkshere'             => array( 'ܡܐ_ܐܣܪ_ܠܗܪܟܐ' ),
);

$magicWords = array(
	'redirect'                => array( '0', '#ܨܘܝܒܐ', '#REDIRECT' ),
	'numberofpages'           => array( '1', 'ܡܢܝܢܐ_ܕܦܐܬܬ̈ܐ', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'ܡܢܝܢܐ_ܕܡܠܘܐ̈ܐ', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'ܡܢܝܢܐ_ܕܠܦܦ̈ܐ', 'NUMBEROFFILES' ),
	'pagename'                => array( '1', 'ܫܡܐ_ܕܦܐܬܐ', 'PAGENAME' ),
	'pagenamee'               => array( '1', 'ܟܘܢܝܐ_ܕܦܐܬܐ', 'PAGENAMEE' ),
	'namespace'               => array( '1', 'ܚܩܠܐ', 'NAMESPACE' ),
	'msg'                     => array( '0', 'ܐܓܪܬܐ:', 'MSG:' ),
	'img_thumbnail'           => array( '1', 'ܙܥܘܪܬܐ', 'thumbnail', 'thumb' ),
	'img_manualthumb'         => array( '1', 'ܙܥܘܪܬܐ=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'ܝܡܝܢܐ', 'right' ),
	'img_left'                => array( '1', 'ܣܡܠܐ', 'left' ),
	'img_none'                => array( '1', 'ܠܐ_ܡܕܡ', 'none' ),
	'img_center'              => array( '1', 'ܡܨܥܐ', 'center', 'centre' ),
	'img_page'                => array( '1', 'ܦܐܬܐ=$1', 'ܦܐܬܐ $1', 'page=$1', 'page $1' ),
	'img_border'              => array( '1', 'ܬܚܘܡܐ', 'border' ),
	'img_baseline'            => array( '1', 'ܣܪܛܐ_ܫܪܫܝܐ', 'baseline' ),
	'img_sub'                 => array( '1', 'ܦܪܥܝܐ', 'sub' ),
	'grammar'                 => array( '0', 'ܬܘܪܨ_ܡܡܠܠܐ:', 'GRAMMAR:' ),
	'gender'                  => array( '0', 'ܓܢܣܐ:', 'GENDER:' ),
	'language'                => array( '0', '#ܠܫܢܐ:', '#LANGUAGE:' ),
	'special'                 => array( '0', 'ܕܝܠܢܝܐ', 'special' ),
	'url_path'                => array( '0', 'ܫܒܝܠܐ', 'PATH' ),
	'url_wiki'                => array( '0', 'ܘܝܩܝ', 'WIKI' ),
);

