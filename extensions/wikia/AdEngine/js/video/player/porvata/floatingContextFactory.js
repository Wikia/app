/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floatingContextFactory', [
		'ext.wikia.adEngine.video.player.porvata.floaterConfiguration',
		'wikia.document',
		'wikia.window'
	], function (floaterConfiguration, doc, win) {
		'use strict';

		var events = {
				attach: 'attach',
				beforeDetach: 'beforeDetach',
				detach: 'detach',
				end: 'end',
				start: 'start'
			},
			floatingThreshold = 55,
			state = {
				deactivated: 'deactivated',
				floating: 'floating',
				never: 'never',
				paused: 'paused',
				stopped: 'stopped'
			};

		function create(video, params, eventHandlers) {
			var configuration = floaterConfiguration.selectConfigurationUsing(params),
				adContainer = doc.getElementById(configuration.container),
				elements = {
					adContainer: adContainer,
					ad: adContainer.querySelector('.wikia-ad'),
					imageContainer: params.container.parentElement.querySelector('#image'),
					video: video
				},
				floatingContext = {
					beforeFloat: function () {
						this.fireEvent(events.beforeDetach);
					},
					doNotFloat: false,
					elements: elements,
					eventHandlers: eventHandlers,
					fireEvent: function (eventName) {
						var eventHandler = 'on' + eventName.charAt(0).toUpperCase() + eventName.slice(1);

						if (this.eventHandlers[eventHandler]) {
							this.eventHandlers[eventHandler](this);
						}
					},
					float: function () {
						this.state = state.floating;
						this.fireEvent(events.detach);
					},
					floatAgain: function () {
						this.doNotFloat = false;
					},
					forceDoNotFloat: function () {
						this.doNotFloat = true;
					},
					/**
					 * Checks whether floating is active.
					 *
					 * @returns {boolean} - true if state is different from stopped - stopped state is set when
					 * floating element was closed or when video ended
					 */
					isActive: function () {
						return this.state !== state.stopped;
					},
					invokeLater: function (callback) {
						this.floatLater(callback);
						// this.fireEvent(events.start);
					},
					isFloating: function () {
						return this.state === state.floating;
					},
					isOutsideOfViewport: function () {
						var rect = this.elements.viewport.getBoundingClientRect();

						// return rect.top > (win.innerHeight || doc.documentElement.clientHeight) || rect.bottom < floatingThreshold;
						return rect.bottom < floatingThreshold;
					},
					isStill: function () {
						return this.state === state.never || this.state === state.paused;
					},
					listeners: {},
					pause: function () {
						this.state = state.paused;
						this.fireEvent(events.attach);
					},
					state: state.never,
					stop: function () {
						this.state = state.stopped;
						this.fireEvent(events.end);
					}
				};

			floaterConfiguration.configure(floatingContext, params);

			return floatingContext;
		}

		return {
			create: create
		};
	}
);
