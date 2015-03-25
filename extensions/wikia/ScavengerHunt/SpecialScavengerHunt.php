<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class SpecialScavengerHunt extends SpecialPage {

	/**
	 * @var ScavengerHuntGames
	 */
	protected $games = null;

	private $optionalSprites = array('finishPopupSprite', 'startPopupSprite');

	public function __construct() {
		$this->app = F::app();
		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');
		$this->user = $this->app->getGlobal('wgUser');
		parent::__construct('ScavengerHunt', 'scavengerhunt');
	}

	protected function getBlankImgUrl() {
		return $this->app->getGlobal('wgBlankImgUrl');
	}

	public function execute( $subpage ) {
		wfProfileIn(__METHOD__);

		$this->games = new ScavengerHuntGames();

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('scavengerhunt');

		if ($this->isRestricted() && !$this->userCanExecute($this->user)) {
			$this->displayRestrictionError();
			wfProfileOut(__METHOD__);
			return;
		}

		@list( $action, $id ) = explode('/', $subpage);
		$action = !empty($action) ? $action : 'list';
		$id = ( int ) $id;
		$game = $this->games->findById($id);
		if (empty($game)) $game = $this->games->newGame();

		// check edit tokens
		if ($this->request->wasPosted() && !$this->user->matchEditToken($this->request->getVal('wpEditToken'))) {
			BannerNotificationsController::addConfirmation(
				wfMsg('scavengerhunt-edit-token-mismatch'),
				BannerNotificationsController::CONFIRMATION_ERROR
			);
			$this->out->redirect( $this->mTitle->getFullUrl() );
			wfProfileOut(__METHOD__);
			return;
		}

		$this->out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ScavengerHunt/css/scavenger-special.scss'));
		$this->out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ScavengerHunt/css/scavenger-game.scss'));
		$this->out->addScriptFile($this->app->getGlobal('wgExtensionsPath') . '/wikia/ScavengerHunt/js/scavenger-special.js');
		$template = new EasyTemplate(dirname( __FILE__ ) . '/templates/');

		$errors = array();
		switch ($action) {
			case 'list':
				$button = '<a class="wikia-button scavengerhunt-add-button" href="' . $this->mTitle->getFullUrl() . '/add">'.
					Xml::element('img', array( 'class' => 'sprite new', 'src' => $this->app->getGlobal('wgBlankImgUrl'))) . wfMsg('scavengerhunt-button-add') . '</a>';

				$this->out->mPagetitle .= $button;
				$this->out->mPageLinkTitle = true;

				// Games list
				$pager = new ScavengerHuntGamesPager($this->games, $this->mTitle->getFullUrl(), $template);
				$this->out->addHTML(
					$pager->getBody() .
					$pager->getNavigationBar()
				);

				break;

			case 'toggle':
				$enable = !$game->isEnabled();
				$game->setEnabled($enable);
				$errors = $this->validateGame($game);

				if (empty($errors['errors'])) {
					$game->save();

					BannerNotificationsController::addConfirmation(
						$enable
						? wfMsg('scavengerhunt-game-has-been-enabled')
						: wfMsg('scavengerhunt-game-has-been-disabled')
					);

					//success! go to the list
					$this->out->redirect( $this->mTitle->getFullUrl() );
					wfProfileOut(__METHOD__);
					return;
				} else {
					//failure - display errors
					$game->setEnabled( false );
				}
				// no "break" on purpose - wasPosted() will return false but we'll display proper template

			case 'edit':
				if ($this->request->wasPosted()) {
					if ($this->request->getVal('enable')) {
						$enabled = !$this->request->getVal('prevEnabled');
						$game->setEnabled($enabled);
						$errors = $this->validateGame($game);

						if (empty($errors['errors'])) {

							$game->save();

							BannerNotificationsController::addConfirmation(
								$enabled
								? wfMsg('scavengerhunt-game-has-been-enabled')
								: wfMsg('scavengerhunt-game-has-been-disabled')
							);

							$this->out->redirect( $this->mTitle->getFullUrl() . "/edit/$id" );
							wfProfileOut(__METHOD__);
							return;
						} else {
							$game->setEnabled( false );
						}
					} else if ($this->request->getVal('delete')) {

						$game->delete();

						BannerNotificationsController::addConfirmation(
							wfMsg('scavengerhunt-game-has-been-deleted')
						);
						$this->out->redirect( $this->mTitle->getFullUrl() );
						wfProfileOut(__METHOD__);
						return;
					}
				}
				// no "break" on purpose

			case 'add':
				if ($this->request->wasPosted()) {
					if ($this->request->getVal('save')) {
						$game = $this->updatePostedGame($game);
						// move the validation process to the moment of enabling the game
						$errors = $this->validateGame($game);
						// save changes
						if (empty($errors['errors']) && $game->save()) {
							BannerNotificationsController::addConfirmation(
								$action == 'add'
								? wfMsg('scavengerhunt-game-has-been-created')
								: wfMsg('scavengerhunt-game-has-been-saved')
							);

							$this->out->redirect( $this->mTitle->getFullUrl() );
							wfProfileOut(__METHOD__);
							return;
						} else {
							BannerNotificationsController::addConfirmation(
								wfMsg('scavengerhunt-game-has-not-been-saved'),
								BannerNotificationsController::CONFIRMATION_NOTIFY
							);
						}
					}
				}
				$template->set('errors', isset($errors['errors']) ? $errors['errors'] : array() );
				$template->set('highlight', isset($errors['highlight']) ? $errors['highlight'] : array() );
				$template->set('editToken', $this->user->getEditToken());
				$template->set_vars($this->getTemplateVarsFromGame($game) );
				$this->out->addHTML($template->render('form'));
				break;
		}

		wfProfileOut(__METHOD__);
	}

	protected function updatePostedGame( $game = null ) {
		wfProfileIn(__METHOD__);

		if (empty($game)) {
			$gameId = (int)$this->request->getVal('gameId');
			$game = $this->games->findById($gameId, true);
			if ( empty( $game ) ) {
				throw new WikiaException("Could not retrieve specified game");
			}
		}

		if ($game->getId() == 0) {
			$game->setWikiId($this->app->getGlobal('wgCityId'));
		}

		// prepare data for normal params
		$nonArrayParams = $game->getDataNonArrayProperties();
		$paramValues = array();
		foreach( $nonArrayParams as $param ) {
			$mValue = $this->request->getVal( $param );
			$paramValues[ $param ] = $mValue;
		}

		// prepare data for sprites
		$arrayParams = $game->getDataArrayProperties();

		$spriteSchema = array( 'X', 'Y', 'X1', 'Y1', 'X2', 'Y2' );

		foreach( $arrayParams as $param ) {
			$mValue = array();
			foreach ( $spriteSchema as $dimension ) {
				$mValue[ $dimension ] = (int) $this->request->getVal( $param.$dimension );
			}
			$paramValues[ $param ] = $mValue;
		}

		$game->setAll( $paramValues );

		//create list of articles
		$articleMarkers = $this->request->getArray('articleMarker');

		$articleTitles = $this->request->getArray('articleTitle');
		$clueTexts = $this->request->getArray('clueText');

		$aCongrats = $this->request->getArray('congrats');
		$spritesInArticles = array( 'spriteInProgressBarNotFound', 'spriteNotFound', 'spriteInProgressBar', 'spriteInProgressBarHover' );

		foreach( $spriteSchema as $dimension ) {
			foreach( $spritesInArticles as $spriteName ) {
				$tmpName = $spriteName.$dimension;
				$$tmpName = $this->request->getArray( $tmpName );
			}
		}
		$articles = array();
		if( !empty( $articleMarkers ) && is_array( $articleMarkers ) ){
			foreach( array_keys( $articleMarkers ) as $i ){
				$article = $game->newGameArticle();

				// prepare data for acticle sprites
				$spriteNotFound = ScavengerHuntGameArticle::getSpriteTemplate();
				$spriteInProgressBar = ScavengerHuntGameArticle::getSpriteTemplate();
				$spriteInProgressBarHover = ScavengerHuntGameArticle::getSpriteTemplate();

				$aResults = array();
				foreach ( $spriteSchema as $dimension ){
					foreach( $spritesInArticles as $spriteName ){
						$tmpName = $spriteName.$dimension;
						$aParam = $$tmpName;
						if ( !isset( $aResults[ $spriteName ] ) ){
							$aResults[ $spriteName ] = array();
						}
						$aResults[ $spriteName ][ $dimension ] = isset( $aParam[$i] ) ? (int)$aParam[$i] : 0;
					}
				}
				$article->setAll(array(
					'title' => isset( $articleTitles[$i] ) ? $articleTitles[$i] : '',
					'clueText' => isset( $clueTexts[$i] ) ? $clueTexts[$i] : '',
					'congrats' => isset( $aCongrats[$i] ) ? $aCongrats[$i] : '',
					'spriteInProgressBarHover' => $aResults['spriteInProgressBarHover'],
					'spriteInProgressBarNotFound' =>  $aResults['spriteInProgressBarNotFound'],
					'spriteInProgressBar' => $aResults['spriteInProgressBar'],
					'spriteNotFound' => $aResults['spriteNotFound']
				));
				$articles[] = $article;
			}
		}
		$game->setArticles( $articles );

		wfProfileOut(__METHOD__);
		return $game;
	}

	protected function ifAnyEmpty( $data, $elements, $msg, &$errors, &$highlight ) {
		wfProfileIn(__METHOD__);
		$error = false;
		foreach( $elements as $element ) {
			if ( empty( $data[ $element ] ) ) {
				if ( !$error ) {
					$error = true;
				};
				$highlight[] = $element;
			}
		}
		if ( $error ) {
			$errors[] = $msg;
		}
		wfProfileOut(__METHOD__);
	}

	protected function ifNotProperURL( $data, $elements, $msg, &$errors, &$highlight ) {
		wfProfileIn(__METHOD__);
		$error = false;
		foreach( $elements as $element ) {
			if ( !preg_match( '/^(?:' . wfUrlProtocols() . ')/', $data[$element] ) ) {
				if ( !$error ) {
					$error = true;
				};
				$highlight[] = $element;
			}
		}
		if ( $error ) {
			$errors[] = $msg;
		}
		wfProfileOut(__METHOD__);
	}

	protected function validateGame( ScavengerHuntGame $game ) {
		wfProfileIn(__METHOD__);

		$errors = $highlight = array();

		$data = $game->getAll();
		if ( empty( $data['name'] ) ) {
			$errors[] = wfMsg( 'scavengerhunt-form-error-name' );
			$highlight[] = 'name';
		}

		if (!$game->isEnabled()) {
			wfProfileOut(__METHOD__);
			return array(
				'errors' => $errors,
				'highlight' => $highlight
			);
		}

		// sprite image has to be a proper URL
		$this->ifNotProperURL(
			$data,
			array( 'spriteImg' ),
			wfMsg( 'scavengerhunt-form-error-no-sprite-image' ),
			$errors,
			$highlight
		);

		// landing title has to be a proper URL
		$this->ifNotProperURL(
			$data,
			array( 'landingTitle' ),
			wfMsg( 'scavengerhunt-form-error-no-landing-title' ),
			$errors,
			$highlight
		);

		// no landing button
		$this->ifAnyEmpty(
			$data,
			array( 'landingButtonText' ),
			wfMsg( 'scavengerhunt-form-error-landing-button-text' ),
			$errors,
			$highlight
		);

		// no landing button position
		$this->ifAnyEmpty(
			$data,
			array( 'landingButtonX', 'landingButtonY' ),
			wfMsg( 'scavengerhunt-form-error-landing-button-position' ),
			$errors,
			$highlight
		);

		// no starting clue
		$this->ifAnyEmpty(
			$data,
			array( 'startingClueTitle', 'startingClueText', 'startingClueButtonText' ),
			wfMsg( 'scavengerhunt-form-error-starting-clue' ),
			$errors,
			$highlight
		);

		// sprite image has to be a proper URL
		$this->ifNotProperURL(
			$data,
			array( 'startingClueButtonTarget' ),
			wfMsg( 'scavengerhunt-form-error-invalid-url' ),
			$errors,
			$highlight
		);

		// error form incompleat
		$this->ifAnyEmpty(
			$data,
			array( 'entryFormTitle', 'entryFormText', 'entryFormButtonText' ),
			wfMsg( 'scavengerhunt-form-error-entry-form' ),
			$errors,
			$highlight
		);

		// error facebook data incompleat
		$this->ifAnyEmpty(
			$data,
			array( 'facebookImg', 'facebookDescription' ),
			wfMsg( 'scavengerhunt-form-error-facebook-empty' ),
			$errors,
			$highlight
		);

		// no goodbye form incompleat
		$this->ifAnyEmpty(
			$data,
			array( 'goodbyeTitle', 'goodbyeText' ),
			wfMsg( 'scavengerhunt-form-error-goodbye' ),
			$errors,
			$highlight
		);

		if ( empty( $data['clueColor'] ) || !preg_match( '/^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/', $data['clueColor'] ) ){
			$errors[] = wfMsg( 'scavengerhunt-form-error-clueColor' );
			$highlight[] = 'clueColor';
		}

		foreach ( $game->getDataArrayProperties() as $property ) {
			if (in_array($property, $this->optionalSprites)) {
				continue;
			}
			if (
				( (int)$data[ $property ]['X1'] >= (int)$data[ $property ]['X2'] ) ||
				( (int)$data[ $property ]['Y1'] >= (int)$data[ $property ]['Y2'] )) {
				$errors[] = wfMsg( 'scavengerhunt-form-error-'.$property.'-sprite-empty' );
				if ( (int)$data[ $property ]['X1'] >= (int)$data[ $property ]['X2'] ) {
					$highlight[] = $property.'X1';
					$highlight[] = $property.'X2';
				}
				if (  (int)$data[ $property ]['Y1'] >= (int)$data[ $property ]['Y2']  ) {
					$highlight[] = $property.'Y1';
					$highlight[] = $property.'Y2';
				}
			}
		}

		$spritesInArticles = array( 'spriteInProgressBarNotFound', 'spriteNotFound', 'spriteInProgressBar', 'spriteInProgressBarHover' );

		if ( count( $data['articles'] ) == 0 ){
			$errors[] = wfMsg( 'scavengerhunt-form-error-no-articles' );
		}

		$articleTitlesList = array();
		foreach ($data['articles'] as $n => $article) {

			$article = $article->getAll();

			//check if article title is not a duplicate.
			if ( in_array( $article['title'], $articleTitlesList ) ){
				$errors[] = wfMsg( 'scavengerhunt-form-error-duplicated-article-title' );
				$highlight[] = "articleTitle[$n]";
			} else {
				$articleTitlesList[] = $article['title'];
			}

			// articleTitle has to be a proper URL
			if ( !preg_match( '/^(?:' . wfUrlProtocols() . ')/', $article['title'] ) ) {
				$errors[] = wfMsg( 'scavengerhunt-form-error-no-article-title' );
				$highlight[] = "articleTitle[$n]";
			}

			foreach ( $spritesInArticles as $property ) {
				if (( (int)$article[$property]['X1'] >= (int)$article[$property]['X2'] ) ||
				( (int)$article[$property]['Y1'] >= (int)$article[$property]['Y2'] )) {
					$errors[] = wfMsg( 'scavengerhunt-form-error-article-'.$property.'-sprite-empty', $article['title'] );
					if ( (int)$article[$property]['X1'] >= (int)$article[$property]['X2'] ) {
						$highlight[] = $property."X1[$n]";
						$highlight[] = $property."X2[$n]";
					}
					if ( (int)$article[$property]['Y1'] >= (int)$article[$property]['Y2'] ) {
						$highlight[] = $property."Y1[$n]";
						$highlight[] = $property."Y2[$n]";
					}
				}
			}

			if ( empty($article['clueText']) ) {
				$errors[] = wfMsg( 'scavengerhunt-form-error-article-clue' );
				$highlight[] = "clueText[$n]";
			}
			if ( empty($article['congrats']) ) {

				$errors[] = wfMsg( 'scavengerhunt-form-error-article-clue' );
				$highlight[] = "congrats[$n]";
			}
		}
		wfProfileOut(__METHOD__);

		return array(
			'errors' => $errors,
			'highlight' => $highlight
		);
	}

	protected function getTemplateVarsFromGame( ScavengerHuntGame $game ) {
		wfProfileIn(__METHOD__);

		$vars = $game->getAll();
		$vars['gameId'] = $vars['id'];
		$vars['enabled'] = $vars['isEnabled'];
		foreach ($vars['articles'] as $k => $v) {
			$vars['articles'][$k] = $vars['articles'][$k]->getAll();
		}
		if ( empty ( $vars['articles'] ) ) {
			$vars['articles'][] = $game->newGameArticle()->getAll();
		}

		unset($vars['id']);
		unset($vars['isEnabled']);

		wfProfileOut(__METHOD__);
		return $vars;
	}
}

class ScavengerHuntGamesPager extends AlphabeticPager {

	protected $games = null;
	protected $url = '';
	/**
	 * @var EasyTemplate
	 */
	protected $tpl = null;

	public function __construct( ScavengerHuntGames $games, $url, $tpl ) {
		parent::__construct();
		$this->games = $games;
		$this->url = $url;
		$this->tpl = $tpl;
		$this->mDb = $this->games->getDb();
	}

	public function formatRow( $row ) {
		$this->tpl->reset();
		$game = $this->games->newGameFromRow($row);
		$gameId = (int)$game->getId();
		$this->tpl->set_vars(array(
			'toggleUrl' => $this->url . '/toggle/' . $gameId,
			'editUrl' => $this->url . '/edit/' . $gameId,
			'game' => $game,
		));
		return $this->tpl->render('game-list-item');
	}

	public function getStartBody() {
		$this->tpl->reset();
		return $this->tpl->render('game-list-top');
	}

	public function getEndBody() {
		$this->tpl->reset();
		return $this->tpl->render('game-list-bottom');
	}

	public function getQueryInfo() {
		$wikiId = F::app()->getGlobal('wgCityId');
		return array(
			'tables' => ScavengerHuntGames::GAMES_TABLE_NAME,
			'fields' => '*',
		);
	}

	public function getIndexField() {
		return 'game_id';
	}
}
