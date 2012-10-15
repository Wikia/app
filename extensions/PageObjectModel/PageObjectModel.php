<?php
#
# This will enable POM editing through MediaWiki API
#
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

require_once( dirname( __FILE__ ) . '/POM.php' );

require_once ( "$IP/includes/api/ApiBase.php" );

global $wgAPIModules;
$wgAPIModules['pomsettplparam'] = 'ApiPOMSetTemplateParameter';
$wgAPIModules['pomgettplparam'] = 'ApiPOMGetTemplateParameter';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Page Object Model',
	'author' => 'Sergey Chernyshev',
	'descriptionmsg' => 'pageobjectmodel-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Page_Object_Model',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['PageObjectModel'] =  "$dir/PageObjectModel.i18n.php";

/**
 * @ingroup API
 */
class ApiPOMSetTemplateParameter extends ApiBase {

	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName );
	}

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();
		if ( is_null( $params['page'] ) ) {
			$this->dieUsage( 'Must specify page title', 0 );
		}
			
		if ( is_null( $params['tpl'] ) ) {
			$this->dieUsage( 'Must specify template name', 1 );
		}
			
		if ( is_null( $params['param'] ) ) {
			$this->dieUsage( 'Must specify parameter name', 2 );
		}
			
		if ( is_null( $params['value'] ) ) {
			$this->dieUsage( 'Must specify value', 3 );
		}
			
		if ( is_null( $params['summary'] ) ) {
			$this->dieUsage( 'Must specify edit summary', 4 );
		}

		$page = $params['page'];
		$template = $params['tpl'];
		$instance = $params['tplinstance'];
		$parameter = $params['param'];
		$value = $params['value'];
		$summary = $params['summary'];

		$articleTitle = Title::newFromText( $page );
		
		if ( !$articleTitle ) {
			$this->dieUsage( "Can't create title object ($page)", 5 );
		}
		
		$errors = $articleTitle->getUserPermissionsErrors( 'edit', $wgUser );
		
		if ( !empty( $errors ) ) {
			$this->dieUsage( wfMsg( $errors[0][0], $errors[0][1] ), 8 );
		}

		$article = new Article( $articleTitle );
		
		if ( !$article->exists() ) {
			$this->dieUsage( "Article doesn't exist ($page)", 6 );
		}
	
		$pom = new POMPage( $article->getContent() );
		
		if ( array_key_exists( $template, $pom->templates )
			&& array_key_exists( $instance, $pom->templates[$template] )
			)
		{
			$pom->templates[$template][$instance]->setParameter( $parameter, $value );
		}
		else
		{
			$this->dieUsage( "This template ($template, instance #$instance) with this parameter ($parameter) doesn't exist within this page ($page)", 7 );
		}

		$success = $article->doEdit( $pom->asString(), $summary );

		$result = array();
		
		$result['result'] = $success ? 'Success' : 'Failure';

		$this->getResult()->addValue( null, 'pomsettplparam', $result );
	}

	protected function getAllowedParams() {
		return array (
			'page' => null,
			'tpl' => null,
			'tplinstance' => array (
                                ApiBase :: PARAM_TYPE => 'integer',
                                ApiBase :: PARAM_DFLT => 0,
                                ApiBase :: PARAM_MIN => 0
                        ),
			'param' => null,
			'value' => null,
			'summary' => null
		);
	}

	protected function getParamDescription() {
		return array (
			'page' => 'Title of the page to modify',
			'tpl' => 'Name of the template withing the page',
			'tplinstance' => 'Instance number of the template - by dafault firt (0) is used',
			'param' => 'Parameter name',
			'value' => 'Value to set',
			'summary' => 'Edit summary'
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}
	
	protected function getDescription() {
		return 'Call to set template parameter value using Page Object Model (http://www.mediawiki.org/Extension:Page_Object_Model)';
	}

	public function getExamples() {
		return array (
			'api.php?action=pomsettplparam&page=Somepage&tpl=SomeTempate&param=templateparam&value=It+works!&summary=Editing+template+param+using+Page+Object+Model'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}

/**
 * @ingroup API
 */
class ApiPOMGetTemplateParameter extends ApiBase {

	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName );
	}

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();
		
		if ( is_null( $params['page'] ) ) {
			$this->dieUsage( 'Must specify page title', 0 );
		}
			
		if ( is_null( $params['tpl'] ) ) {
			$this->dieUsage( 'Must specify template name', 1 );
		}
			
		if ( is_null( $params['param'] ) ) {
			$this->dieUsage( 'Must specify parameter name', 2 );
		}

		$page = $params['page'];
		$template = $params['tpl'];
		$instance = $params['tplinstance'];
		$parameter = $params['param'];

		$articleTitle = Title::newFromText( $page );
		
		if ( !$articleTitle ) {
			$this->dieUsage( "Can't create title object ($page)", 5 );
		}
		
		$errors = $articleTitle->getUserPermissionsErrors( 'read', $wgUser );
		
		if ( !empty( $errors ) ) {
			$this->dieUsage( wfMsg( $errors[0][0], $errors[0][1] ), 8 );
		}

		$article = new Article( $articleTitle );
		
		if ( !$article->exists() ) {
			$this->dieUsage( "Article doesn't exist ($page)", 6 );
		}
	
		$pom = new POMPage( $article->getContent() );
		if ( array_key_exists( $template, $pom->templates )
			&& array_key_exists( $instance, $pom->templates[$template] )
			)
		{
			$result['value'] = $pom->templates[$template][$instance]->getParameter( $parameter );
			$this->getResult()->addValue( null, 'pomgettplparam', $result );
		}
		else
		{
			$this->dieUsage( "This template ($template, instance #$instance) with this parameter ($parameter) doesn't exist within this page ($page)", 7 );
		}
	}

	protected function getAllowedParams() {
		return array (
			'page' => null,
			'tpl' => null,
			'tplinstance' => array (
                                ApiBase :: PARAM_TYPE => 'integer',
                                ApiBase :: PARAM_DFLT => 0,
                                ApiBase :: PARAM_MIN => 0
                        ),
			'param' => null
		);
	}

	protected function getParamDescription() {
		return array (
			'page' => 'Title of the page to query',
			'tpl' => 'Name of the template withing the page',
			'tplinstance' => 'Instance number of the template - by dafault firt (0) is used',
			'param' => 'Parameter name'
		);
	}

	protected function getDescription() {
		return 'Call to get template parameter value using Page Object Model (http://www.mediawiki.org/Extension:Page_Object_Model)';
	}

	public function getExamples() {
		return array (
			'api.php?action=pomgettplparam&page=Somepage&tpl=SomeTempate&param=templateparam'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}