<?php

/**
 * AdEngine3 InstantGlobals
 */
class AdEngine3InstantGlobals
{
	/**
	 * Register Instant Globals
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	public static function onInstantGlobalsGetVariables(array &$vars)
	{
		$vars[] = 'wgAdDriverAbTestIdTargeting';
		$vars[] = 'wgAdDriverAdditionalVastSizeCountries';
		$vars[] = 'wgAdDriverAdEngine3Countries';
		$vars[] = 'wgAdDriverAolBidderCountries';
		$vars[] = 'wgAdDriverAolOneMobileBidderCountries';
		$vars[] = 'wgAdDriverAppNexusAstBidderCountries';
		$vars[] = 'wgAdDriverAppNexusBidderCountries';
		$vars[] = 'wgAdDriverAppNexusDfpCountries';
		$vars[] = 'wgAdDriverA9BidRefreshingCountries';
		$vars[] = 'wgAdDriverA9BidderCountries';
		$vars[] = 'wgAdDriverA9DealsCountries';
		$vars[] = 'wgAdDriverA9IncontentBoxadCountries';
		$vars[] = 'wgAdDriverA9OptOutCountries';
		$vars[] = 'wgAdDriverA9VideoBidderCountries';
		$vars[] = 'wgAdDriverNativeSearchDesktopCountries';
		$vars[] = 'wgAdDriverBabDetectionDesktopCountries';
		$vars[] = 'wgAdDriverBabDetectionMobileCountries';
		$vars[] = 'wgAdDriverBeachfrontBidderCountries';
		$vars[] = 'wgAdDriverBeachfrontDfpCountries';
		$vars[] = 'wgAdDriverBillTheLizardConfig';
		$vars[] = 'wgAdDriverBottomLeaderBoardLazyPrebidCountries';
		$vars[] = 'wgAdDriverBottomLeaderBoardAdditionalSizesCountries';
		$vars[] = 'wgAdDriverBrowsiCountries';
		$vars[] = 'wgAdDriverCollapseTopLeaderboardMobileWikiCountries';
		$vars[] = 'wgAdDriverDelayTimeout';
		$vars[] = 'wgAdDriverDisableAdStackCountries';
		$vars[] = 'wgAdDriverFMRRotatorDelay';
		$vars[] = 'wgAdDriverFVMidrollCountries';
		$vars[] = 'wgAdDriverFVPostrollCountries';
		$vars[] = 'wgAdDriverGumGumBidderCountries';
		$vars[] = 'wgAdDriverHighImpactSlotCountries';
		$vars[] = 'wgAdDriverHighImpact2SlotCountries';
		$vars[] = 'wgAdDriverMobileFloorAdhesionCountries';
		$vars[] = 'wgAdDriverIncontentPlayerRailCountries';
		$vars[] = 'wgAdDriverIncontentPlayerSlotCountries';
		$vars[] = 'wgAdDriverIndexExchangeBidderCountries';
		$vars[] = 'wgAdDriverKargoBidderCountries';
		$vars[] = 'wgAdDriverKikimoraPlayerTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraViewabilityTrackingCountries';
		$vars[] = 'wgAdDriverKruxCountries';
		$vars[] = 'wgAdDriverKruxNewParamsCountries';
		$vars[] = 'wgAdDriverLABradorDfpKeyvals';
		$vars[] = 'wgAdDriverLABradorTestCountries';
		$vars[] = 'wgAdDriverLazyBottomLeaderboardMobileWikiCountries';
		$vars[] = 'wgAdDriverLkqdBidderCountries';
		$vars[] = 'wgAdDriverLkqdOutstreamCountries';
		$vars[] = 'wgAdDriverMoatTrackingForFeaturedVideoAdCountries';
		$vars[] = 'wgAdDriverMoatTrackingForFeaturedVideoAdSampling';
		$vars[] = 'wgAdDriverMoatTrackingForFeaturedVideoAdditionalParamsCountries';
		$vars[] = 'wgAdDriverMoatYieldIntelligenceCountries';
		$vars[] = 'wgAdDriverMobileBottomLeaderboardSwapCountries';
		$vars[] = 'wgAdDriverMobileTopBoxadCountries';
		$vars[] = 'wgAdDriverMobileWikiAE3NativeSearchCountries';
		$vars[] = 'wgAdDriverMobileWikiAE3SearchCountries';
		$vars[] = 'wgAdDriverNetzAthletenCountries';
		$vars[] = 'wgAdDriverNielsenCountries';
		$vars[] = 'wgAdDriverOasisFloorAdhesionCountries';
		$vars[] = 'wgAdDriverOasisHiviLeaderboardCountries';
		$vars[] = 'wgAdDriverOpenXPrebidBidderCountries';
		$vars[] = 'wgAdDriverOutstreamVideoFrequencyCapping';
		$vars[] = 'wgAdDriverPlayAdsOnNextFVCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextFVFrequency';
		$vars[] = 'wgAdDriverPorvataMoatTrackingCountries';
		$vars[] = 'wgAdDriverPorvataMoatTrackingSampling';
		$vars[] = 'wgAdDriverPrebidBidderCountries';
		$vars[] = 'wgAdDriverPrebidBuiltInTargetingCountries';
		$vars[] = 'wgAdDriverPrebidOptOutCountries';
		$vars[] = 'wgAdDriverPubMaticBidderCountries';
		$vars[] = 'wgAdDriverPubMaticDfpCountries';
		$vars[] = 'wgAdDriverPubMaticOutstreamCountries';
		$vars[] = 'wgAdDriverRabbitTargetingKeyValues';
		$vars[] = 'wgAdDriverRepeatMobileIncontentCountries';
		$vars[] = 'wgAdDriverRepeatMobileIncontentExtendedCountries';
		$vars[] = 'wgAdDriverRubiconDisplayPrebidCountries';
		$vars[] = 'wgAdDriverRubiconPrebidCountries';
		$vars[] = 'wgAdDriverRubiconDfpCountries';
		$vars[] = 'wgAdDriverScrollDepthTrackingCountries';
		$vars[] = 'wgAdDriverSingleBLBSizeForUAPCountries';
		$vars[] = 'wgAdDriverStickySlotsLines';
		$vars[] = 'wgAdDriverUnstickHiViLeaderboardAfterTimeoutCountries';
		$vars[] = 'wgAdDriverVmgBidderCountries';
		$vars[] = 'wgAdDriverWadBTCountries';
		$vars[] = 'wgAdDriverWadHMDCountries';

		/**
		 * Disaster Recovery
		 * @link https://wikia-inc.atlassian.net/wiki/display/ADEN/Disaster+Recovery
		 */
		$vars[] = 'wgSitewideDisableGpt';
		$vars[] = 'wgSitewideDisableKrux';

		return true;
	}

	/**
	 * Register News&Stories Instant Globals
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	public static function onInstantGlobalsGetNewsAndStoriesVariables(array &$vars)
	{
		// Shared variables with communities
		$vars[] = 'wgAdDriverKikimoraPlayerTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraViewabilityTrackingCountries';
		$vars[] = 'wgAdDriverMoatYieldIntelligenceCountries';
		$vars[] = 'wgAdDriverNielsenCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextVideoCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextVideoFrequency';
		$vars[] = 'wgAdDriverPorvataMoatTrackingCountries';
		$vars[] = 'wgAdDriverPorvataMoatTrackingSampling';
		$vars[] = 'wgAdDriverSingleBLBSizeForUAPCountries';
		$vars[] = 'wgAdDriverStickySlotsLines';
		$vars[] = 'wgAdDriverVideoMidrollCountries';
		$vars[] = 'wgAdDriverVideoMoatTrackingCountries';
		$vars[] = 'wgAdDriverVideoMoatTrackingSampling';
		$vars[] = 'wgAdDriverVideoPostrollCountries';
		$vars[] = 'wgAdDriverLABradorDfpKeyvals';
		$vars[] = 'wgAdDriverMoatTrackingForFeaturedVideoAdditionalParamsCountries';

		// News&Stories variables only
		$vars[] = 'wgAdDriverLABradorTestF2Countries';
		$vars[] = 'wgAdDriverF2BabDetectionCountries';
		$vars[] = 'wgAdDriverF2DelayTimeout';
		$vars[] = 'wgAdDriverF2VideoF15nCountries';
		$vars[] = 'wgAdDriverF2VideoF15nMap';

		return true;
	}

	/**
	 * Register Fandom Creator Instant Globals
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	public static function onInstantGlobalsGetFandomCreatorVariables(array &$vars)
	{
		$vars[] = 'wgAdDriverKikimoraPlayerTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraViewabilityTrackingCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextVideoCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextVideoFrequency';
		$vars[] = 'wgAdDriverPorvataMoatTrackingCountries';
		$vars[] = 'wgAdDriverPorvataMoatTrackingSampling';
		$vars[] = 'wgAdDriverSingleBLBSizeForUAPCountries';
		$vars[] = 'wgAdDriverVideoMidrollCountries';
		$vars[] = 'wgAdDriverVideoMoatTrackingCountries';
		$vars[] = 'wgAdDriverVideoMoatTrackingSampling';
		$vars[] = 'wgAdDriverVideoPostrollCountries';

		return true;
	}
}
