// Relies on WikiaDartHelper and DartUrl

var WikiaDartMobileHelper = function (log, window, document) {
	'use strict';

	var nullKrux,
		nullAdLogicShortPage,
		dartUrl = DartUrl(),
		wikiaDartHelper = WikiaDartHelper(log, window, document, nullKrux, nullAdLogicShortPage, dartUrl);

	return {
		/**
		 * Get URL for a mobile ad
		 *
		 * @param params (slotname, positionfixed, uniqueId)
		 * @return {String} URL of DART script
		 */
		getMobileUrl: function (params) {
			return wikiaDartHelper.getUrl({
				slotname: params.slotname,
				positionfixed: params.positionfixed,
				subdomain: 'ad.mo',
				adType: 'mobile',
				src: 'mobile',
				slotsize: '5x5',
				omitEndTag: true
			}) + '&csit=1&dw=1&u=' + params.uniqueId;
		}
	};
};
