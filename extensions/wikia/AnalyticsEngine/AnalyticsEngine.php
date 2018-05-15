<?php
class AnalyticsEngine {

	const TTL = 86400;

	const EVENT_PAGEVIEW = 'page_view';

	const ANALYTICS_MODULE = 'ext.wikia.analyticsEngine';

	/**
	 * Inject configuration settings related to analytics modules
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 */
	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( self::isEnabled( $out ) ) {
			global $wgQualarooUrl, $wgQualarooDevUrl, $wgCityId, $wgGAUserIdSalt;
			$configurations = [];

			$comscoreValue = static::getC7Value();

			if ( $comscoreValue ) {
				$configurations['wgComscoreConfiguration'] = [
					'partnerId' => 6177433,
					'c7value' => $comscoreValue,
					'url' => 'https://sb.scorecardresearch.com/beacon.js'
				];
			}

			$configurations['wgQuantcastConfiguration'] = [
				'account' => 'p-8bG6eLqkH6Avk',
				'url' => 'https://secure.quantserve.com/quant.js'
			];

			$user = $skin->getUser();
			$isAdmin = !empty( array_intersect( [ 'sysop', 'bureaucrat' ], $user->getGroups() ) );

			$hub = new WikiFactoryHub();

			$configurations['wgQualarooConfiguration'] = [
				// TODO set env specific config override
				'url' => Wikia::isProductionEnv() ? $wgQualarooUrl : $wgQualarooDevUrl,
				'isContributor' => $user->getEditCount() > 0,
				'isCurrentWikiAdmin' => $isAdmin && !$user->isAllowed( 'bot' ),
				'fullVerticalName' => $hub->getWikiVertical( $wgCityId )['short'],
				'dartGnreValues' => AdTargeting::getRatingFromDartKeyValues( 'gnre' ),
			];

			$configurations['wgUniversalAnalyticsConfiguration'] = [
				'userIdHash' => $user->isLoggedIn() ? md5($user->getId() . $wgGAUserIdSalt ) : null,
				// TODO set env specific config override
				'isProduction' => Wikia::isProductionEnv(),
			];

			$out->addJsConfigVars( $configurations );
		}
	}

	public static function getMinifiedAnalyticsBootstrapCode( IContextSource $context ): string {
		global $wgMemc, $wgStyleVersion;

		$key = wfMemcKey( static::ANALYTICS_MODULE, $wgStyleVersion );

		$cached = $wgMemc->get( $key );

		if ( $cached !== false ) {
			return $cached;
		}

		$resourceLoader = $context->getOutput()->getResourceLoader();
		$resourceLoaderContext = new ResourceLoaderContext( $resourceLoader, $context->getRequest() );

		$analyticsModule = $resourceLoader->getModule( static::ANALYTICS_MODULE );
		$script = $analyticsModule->getScript( $resourceLoaderContext );

		$wgMemc->set( $key, $script, static::TTL );

		return $script;
	}

	public static function isEnabled( IContextSource $context ): bool {
		return !$context->getRequest()->getCheck( 'noexternals' ) &&
			   $context->getSkin()->getSkinName() === 'oasis' &&
			   !in_array( $context->getRequest()->getVal( 'action', 'view' ), [ 'edit', 'submit' ] );
	}

	private static function getC7Value() {
		global $wgCityId;

		$verticalName = HubService::getVerticalNameForComscore( $wgCityId );

		$categoryOverride = HubService::getComscoreCategoryOverride( $wgCityId );
		if ( $categoryOverride ) {
			$verticalName = $categoryOverride;
		}

		if ( !$verticalName ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Vertical not set for comscore', [
				'cityId' => $wgCityId,
				'exception' => new Exception()
			] );
			return false;
		} else {
			return 'wikiacsid_' . $verticalName;
		}
	}

	static public function track($provider, $event, $eventDetails=array(), $setupParams=array()){
		global $wgNoExternals, $wgRequest;
		global $wgBlockedAnalyticsProviders;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		if ( !empty($wgBlockedAnalyticsProviders) && in_array($provider, $wgBlockedAnalyticsProviders) ) {
			return '<!-- AnalyticsEngine::track - ' . $provider . ' blocked via $wgBlockedAnalyticsProviders -->';
		}

		if ( !empty($wgNoExternals) ) {
			return '<!-- AnalyticsEngine::track - externals disabled -->';
		}

		$AP = self::getProvider($provider);
		if (empty($AP)) {
			return '<!-- Invalid provider for AnalyticsEngine::getTrackCode -->';
		}

		$out = $AP->getSetupHtml($setupParams);

		if ( !empty( $out ) ) {
			$out = "\n<!-- Start for $provider, $event -->\n" . $out;
		}

		$out .= $AP->trackEvent($event, $eventDetails);
		return $out;
	}

	private static function getProvider($provider) {
		switch ($provider) {
			case 'Exelate':
				return new AnalyticsProviderExelate();
			case 'GoogleFundingChoices':
				return new AnalyticsProviderGoogleFundingChoices();
			case 'Krux':
				return new AnalyticsProviderKrux();
			case 'A9':
				return new AnalyticsProviderA9();
			case 'Prebid':
				return new AnalyticsProviderPrebid();
			case 'DynamicYield':
				return new AnalyticsProviderDynamicYield();
			case 'NetzAthleten':
				return new AnalyticsProviderNetzAthleten();
		}

		return null;
	}
}
