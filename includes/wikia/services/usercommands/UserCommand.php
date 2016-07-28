<?php

/**
 * Base class for the various commands and tools presented in the bottom toolbar of the Oasis skin
 */
abstract class UserCommand {

	/**
	 * @var string|null $id Unique id of this tool (tool type and tool name separated by a : )
	 */
	protected $id = null;
	/**
	 * @var string|null $type
	 * Type of this tool (one of: follow, menu, link, html, customize, devinfo or disabled)
	 */
	protected $type = null;
	/**
	 * @var string|null $name Name of this tool
	 */
	protected $name = null;
	/**
	 * @var array|null $data Data presupplied to this object (caption string etc.)
	 */
	protected $data = null;

	/**
	 * UserCommand constructor - determines type and name from id and sets any presupplied data
	 * @param string $id Unique id of this tool (tool type and tool name separated by a : )
	 * @param array $data Data presupplied to this object (caption string etc.)
	 */
	public function __construct( $id, $data = [] ) {
		$this->id = $id;
		list( $this->type, $this->name ) = explode( ':', $this->id, 2 );
		$this->data = $data;
	}

	/**
	 * Gets the unique id of this tool
	 * @return null|string unique id of this tool
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Gets information about this tool
	 * @return array array containing the unique id, default caption and actual caption of this tool
	 */
	public function getInfo() {
		$defaultCaption = $this->getAbstractCaption();
		$caption = !empty( $this->data['caption'] ) ? $this->data['caption'] : $defaultCaption;
		return [
			'id'             => $this->getId(),
			'defaultCaption' => $defaultCaption,
			'caption'        => $caption,
		];
	}

	/**
	 * Returns whether the current user is allowed to add this tool to their toolbar
	 * @return bool Whether the current user is allowed to add this tool to their toolbar
	 */
	public function isAvailable() {
		$this->needData();
		return $this->available;
	}

	/**
	 * Returns whether the current user is allowed to use this tool on this wiki or page
	 * @return bool Whether the current user is allowed to use this tool on this wiki or page
	 */
	public function isEnabled() {
		$this->needData();
		return $this->enabled;
	}

	/**
	 * Returns the caption (link text used in <a> element) of this tool
	 * @return string|null caption (link text) of this tool
	 */
	public function getCaption() {
		return $this->caption;
	}

	/**
	 * Returns the URL this tool points to
	 * @return string URL this tool points to
	 */
	public function getHref() {
		return $this->href;
	}

	protected $overflow = true;
	/**
	 * @var string $defaultRenderType Default type to be used by UserToolsController Menu template, if none were specified
	 */
	protected $defaultRenderType = 'link';

	/**
	 * @var bool $available Whether the current user is allowed to add this tool to their toolbar
	 */
	protected $available = false;
	/**
	 * @var bool $enabled Whether the current user is allowed to use this tool on this wiki or page
	 */
	protected $enabled = false;

	/**
	 * @var bool|string $imageSprite Image sprite used by the icon of this tool, if any
	 */
	protected $imageSprite = false;
	/**
	 * @var bool|string $imageUrl Image URL used by the icon of this tool, if any
	 */
	protected $imageUrl = false;


	/**
	 * @var string $listItemId HTML id attribute used for rendering this tool (for menu-type)
	 */
	protected $listItemId = '';
	/**
	 * @var string $listItemClass HTML class attribute used for rendering this tool (for menu-type)
	 */
	protected $listItemClass = '';
	/**
	 * @var string $linkId HTML id attribute used for the <a> element of this tool
	 */
	protected $linkId = '';
	/**
	 * @var string $linkClass HTML class attribute used for the <a> element of this tool
	 */
	protected $linkClass = '';
	/**
	 * @var bool|string Accesskey of the <a> element of this tool, if any
	 */
	protected $accessKey = false;

	/**
	 * @var string $href URL of this tool
	 */
	protected $href = '#';
	/**
	 * @var null|string $caption Link text of this tool
	 */
	protected $caption = null;
	/**
	 * @var null|string $description Textual description of this tool
	 */
	protected $description = null;

	/**
	 * @var null|string $abstractCaption
	 */
	protected $abstractCaption = null;
	/**
	 * @var null|string $abstractDescription
	 */
	protected $abstractDescription = null;

	protected function getAbstractCaption() {
		$this->needData();
		return $this->abstractCaption;
	}

	protected function getAbstractDescription() {
		$this->needData();
		return $this->description;
	}

	/**
	 * Returns the attributes used for the <li> element when outputting this tool (for menu-type)
	 * @return array key-value array of attributes and their values
	 */
	protected function getListItemAttributes() {
		$attributes = [];
		if ( $this->listItemId ) $attributes['id'] = $this->listItemId;
		$listItemClass = trim( $this->listItemClass . ( $this->overflow ? ' overflow' : '' ) );
		if ( $listItemClass ) $attributes['class'] = $listItemClass;
		return $attributes;
	}

	/**
	 * Returns the attributes used for the <a> element when outputting this tool
	 * @return array key-value array of attributes and their values
	 */
	protected function getLinkAttributes() {
		$attributes = [];
		$attributes['data-tool-id'] = $this->id;
		$attributes['data-name'] = $this->getTrackerName();
		if ( $this->href ) $attributes['href'] = $this->href;
		if ( $this->linkId ) $attributes['id'] = $this->linkId;
		if ( $this->linkClass ) $attributes['class'] = $this->linkClass;
		if ( $this->accessKey ) $attributes['accesskey'] = $this->accessKey;
		return $attributes;
	}

	/**
	 * Returns the unique name used by tracking functions to identify this tool
	 * @return string unique name used by tracking functions to identify this tool
	 */
	protected function getTrackerName() {
		return strtolower( $this->name );
	}

	/**
	 * Returns the formatted HTML (list item+link) for this tool
	 * @return string HTML list item for this tool
	 */
	public function render() {
		$this->needData();

		if ( !$this->available ) {
			return '';
		}

		$html = '';
		$html .= Xml::openElement( 'li', $this->getListItemAttributes() );

		$html .= $this->renderIcon();

		if ( $this->enabled ) {
			$html .= Xml::element( 'a', $this->getLinkAttributes(), $this->caption );
			$html .= $this->renderSubmenu();
		} else {
			$spanAttributes = [
				'title' => $this->getDisabledMessage(),
			];
			$html .= Xml::element( 'span', $spanAttributes, $this->caption );
		}

		$html .= Xml::closeElement( 'li' );
		return $html;
	}

	/**
	 * Returns information for UserToolsController Menu template to output this tool
	 * @return array|bool Array of information used by UserToolsController Menu template to output this tool, or false if disabled
	 */
	public function getRenderData() {
		$this->needData();
		if ( !$this->available )
			return false;

		$data = [
			'type'         => $this->defaultRenderType,
			'caption'      => $this->caption,
			'tracker-name' => $this->getTrackerName(),
		];
		if ( $this->enabled ) {
			$data['href'] = $this->href;
		} else {
			$data['type'] = 'disabled';
			$data['error-message'] = $this->getDisabledMessage();
		}

		return $data;
	}

	/**
	 * Returns the HTML for the icon of this tool (empty by default, can be overridden by subclasses)
	 * @return string Icon HTML (default: empty)
	 */
	protected function renderIcon() {
		return '';
	}

	/**
	 * Returns the HTML for the list if this is a menu-type tool (default: empty)
	 * @return string Submenu HTML (default: empty)
	 */
	public function renderSubmenu() {
		return '';
	}

	/**
	 * Gets the error message text shown as a tooltip if this tool is disabled
	 * @return String Error message text - not safe for HTML output, needs to be escaped
	 */
	protected function getDisabledMessage() {
		return wfMessage( 'oasis-toolbar-for-admins-only' )->text();
	}


	/**
	 * @var bool $dataBuilt Whether the data required for rendering this tool has been loaded
	 */
	protected $dataBuilt = false;

	/**
	 * Populates this object with information required for rendering this tool
	 */
	protected function needData() {
		if ( !$this->dataBuilt ) {
			$this->buildData();
			$this->abstractCaption = $this->caption;
			if ( !empty( $this->data['caption'] ) )
				$this->caption = $this->data['caption'];
			$this->dataBuilt = true;
		}
	}

	/**
	 * Actually loads the information required for rendering this tool
	 */
	abstract protected function buildData();

	/**
	 * @var array|null $skinData Data related to the current page as provided by the skin (content actions, navigation URLs)
	 */
	static protected $skinData = null;

	/**
	 * Set the skin data to be used for rendering this tool (content actions and navigation URLs)
	 * @param array $skinData array with keys content_actions and nav_urls
	 */
	static public function setSkinData( $skinData ) {
		self::$skinData = $skinData;
	}

	/**
	 * Loads the content actions and navigation URLs as set by the current skin
	 */
	static public function needSkinData() {
		if ( is_null( self::$skinData ) ) {
			/** @var WikiaSkinTemplate $skinTemplateObj */
			$skinTemplateObj = F::app()->getSkinTemplateObj();
			if ( $skinTemplateObj ) {
				self::$skinData = [
					'content_actions' => $skinTemplateObj->get( 'content_actions' ),
					'nav_urls'        => $skinTemplateObj->get( 'nav_urls' ),
				];
			} else {
				/** @var $context RequestContext */
				$context = RequestContext::getMain();
				/** @var $skin WikiaSkin */
				$skin = $context->getSkin();

				if ( !isset( $skin->iscontent ) ) {
					$title = $skin->getTitle();

					// SUS-767: remove file pages from exclusion list to show "What links here" and other useful tools
					if ( $title->inNamespace( NS_SPECIAL ) ) {
						$skin->getOutput()->setArticleRelated( false );
					}
					$skin->thispage = $title->getPrefixedDBkey();
					$skin->loggedin = $context->getUser()->isLoggedIn();
				}

				self::$skinData = [
					'content_actions' => $skin->buildContentActionUrls( $skin->buildContentNavigationUrls() ),
					'nav_urls'        => $skin->buildNavUrls(),
				];
			}
		}
	}
}
