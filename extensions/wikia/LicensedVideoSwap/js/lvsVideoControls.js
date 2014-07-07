/**
 * Handle clicks on play buttons so they play the video
 */

define('lvs.videocontrols', [
	'wikia.videoBootstrap',
	'wikia.nirvana',
	'jquery',
	'lvs.tracker'
], function (VideoBootstrap, nirvana, $, tracker) {

	'use strict';

	/* @var videoInstances
	 * Keeps track of player instances on the page.  The element containing the
	 * video player will have a data-vb-instance property to store the index of
	 * the vb instance it contains. That way we can add and splice vb's into the
	 * videoInstances array as they get switched out on the page.
	 */
	var videoInstances = [];

	function setVerticalAlign($element, video) {
		var videoHeight = video.height,
			wrapperHeight = $element.height(),
			topMargin = (wrapperHeight - videoHeight) / 2;

		$element.data('height', wrapperHeight).height(wrapperHeight - topMargin).css('padding-top', topMargin);
	}

	// remove vertical alignment css
	function removeVerticalAlign($element) {
		var height = $element.data('height');
		if (height) {
			$element.height(height).css('padding-top', 0);
		}
	}

	function syncVideoInteraction(title, premiumTitle) {
		nirvana.sendRequest({
			controller: 'LicensedVideoSwapSpecialController',
			method: 'playVideo',
			data: {
				videoTitle: title,
				premiumTitle: premiumTitle
			}
		});
	}

	function init($container) {
		var videoWidth = $container.find('.grid-3').width();

		$container.find('.video').on('click.lvs', function (e) {
			// allow click-through if command/control click
			if (e.metaKey || e.ctrlKey) {
				return;
			}
			e.preventDefault();

			var $this = $(this),
				fileTitle = decodeURIComponent($this.children('img').attr('data-video-key')),
				$element,
				$thumbList,
				$row = $this.closest('.row'),
				$parent = $this.parent(),
				$wrapper,
				$newFlag,
				trackingRank = 0,
				isPremium = 1,
				nonPremiumTitle;

			$newFlag = $row.find('.new');

			/*
			 * For all premium video plays that are 'new' to user, including plays from the 'more suggestions' thumbs
			 * send a call to backend to persist and track user interaction, then hide 'New' flag
			 */
			if (!$this.closest('.non-premium').length && $newFlag.is(':visible')) {
				nonPremiumTitle = $row.find('.keep-button').attr('data-video-keep');
				syncVideoInteraction(nonPremiumTitle, fileTitle);
				$newFlag.fadeOut();
			}

			if ($this.hasClass('small')) {
				// one of the thumbnails was clicked
				$element = $this.closest('.row').find('.premium .video-wrapper');
				$thumbList = $this.closest('ul');

				// put outline around the thumbnail that was clicked
				$thumbList.find('.selected').removeClass('selected');
				$parent.addClass('selected');

				// swap titles
				$element.find('.title').text(
					$parent.find('.title').attr('title')
				);

				// Update swap button so it contains the dbkey of the new video to swap
				$row.find('.swap-button').attr('data-video-swap', fileTitle);

				// tracking rank should be 1-indexed, so add 1 to the 0-based index
				trackingRank = $parent.index() + 1;
			} else {
				// Large image was clicked
				$element = $parent;

				// remove click event - this is no longer a video thumbnail
				$this.off('.lvs')
					.on('click.lvs', function (e) {
						e.preventDefault();
					});

				// For tracking purposes, figure out if premium or non-premium was clicked
				$wrapper = $parent.closest('.grid-3');
				if (!$wrapper.hasClass('premium')) {
					isPremium = 0;
					trackingRank = 1;
				}
			}

			tracker.track(tracker.defaults, {
				action: tracker.actions.PLAY,
				label: isPremium ? tracker.labels.PREMIUM : tracker.labels.NON_PREMIUM,
				value: trackingRank
			});

			nirvana.sendRequest({
				controller: 'VideoHandler',
				method: (isPremium ? 'getPremiumEmbedCode' : 'getEmbedCode'),
				data: {
					fileTitle: fileTitle,
					width: videoWidth,
					autoplay: 1
				},
				callback: function (data) {
					var videoInstance,
						vbIndex,
						$playerContainer = $element.find('.video-thumbnail');

					// Remove styles of previous video
					removeVerticalAlign($playerContainer);

					videoInstance = new VideoBootstrap(
						$playerContainer[0],
						data.embedCode,
						'licensedVideoSwap'
					);

					// remove image so user doesn't see it get styles applied
					$playerContainer.find('img').remove();

					setVerticalAlign($playerContainer, videoInstance);

					/* Track video instances so we can reset them later:
					 * If the wrapper element already has a player in it, switch it for this new one.
					 * If not, add it to the videoInstances array.
					 */
					vbIndex = $element.data('vb-index');
					if (!vbIndex) {
						$element.data('vb-index', videoInstances.length);
						videoInstances.push(videoInstance);
					} else {
						videoInstances.splice(vbIndex, 1, videoInstance);
					}
				}
			});
		});

		$container.on('contentReset', function () {
			// All video instances will have been wiped away with the html reset
			videoInstances = [];
		});

		// If a title is clicked, trigger a click on it's thumbnail counterpart
		$container.find('.title a').on('click', function (e) {
			// allow click-through if command/control click
			if (e.metaKey || e.ctrlKey) {
				return;
			}
			e.preventDefault();
			$(this).parent().siblings('.video').click();
		});
	}

	function reset() {
		var i,
			len = videoInstances.length,
			vb,
			playerWidth = 500,
			clickSource = 'licensedVideoSwap',
			autoPlay = false;

		// loop through all loaded video players on the page
		for (i = 0; i < len; i++) {
			vb = videoInstances[i];

			// reload the player
			vb.reload(vb.title, playerWidth, autoPlay, clickSource);
		}
	}

	return {
		init: init,
		reset: reset
	};
});
