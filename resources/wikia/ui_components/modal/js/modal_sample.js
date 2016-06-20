require(['jquery', 'wikia.ui.factory'], function ($, uiFactory) {
	'use strict';
	uiFactory.init('modal').then(function (uiModal) {
		$(function () {

			/**
			 * Shows a modal; unified function for different modals
			 *
			 * @param {Object} modalConfig - uiFactory modal config object
			 * @param {Function} callback - optional; Callback after modal is initialized
			 */
			function showModal(modalConfig, callback) {
				if (typeof callback !== 'function') {
					callback = function (demoModal) {
						demoModal.show();
					};
				}
				uiModal.createComponent(modalConfig, callback);
			}

			// opening a small modal example
			$('#showSmallModalExample').click(function () {
				var modalConfig = {
					type: 'default',
					vars: {
						id: 'smallModalExample',
						size: 'small',
						content: 'This is small modal example',
						class: 'styleguide-example-small',
						title: 'Small modal example.',
						closeText: 'Close',
						buttons: [
							{
								vars: {
									value: 'Submit',
									classes: 'primary',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							},
							{
								vars: {
									value: 'Cancel',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							}
						]
					}
				};
				showModal(modalConfig);
			});

			// opening a medium modal example
			$('#showMediumModalExample').click(function () {
				var modalConfig = {
					type: 'default',
					vars: {
						id: 'mediumModalExample',
						size: 'medium',
						content: '<p>Do you see any Teletubbies in here? Do you see a slender plastic tag clipped to my shirt with my name printed on it? Do you see a little Asian child with a blank expression on his face sitting outside on a mechanical helicopter that shakes when you put quarters in it? No? Well, that\'s what you see at a toy store. And you must think you\'re in a toy store, because you\'re here shopping for an infant named Jeb.</p><p>Your bones don\'t break, mine do. That\'s clear. Your cells react to bacteria and viruses differently than mine. You don\'t get sick, I do. That\'s also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We\'re on the same curve, just on opposite ends.</p><p>Your bones don\'t break, mine do. That\'s clear. Your cells react to bacteria and viruses differently than mine. You don\'t get sick, I do. That\'s also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We\'re on the same curve, just on opposite ends.</p><p>My money\'s in that office, right? If she start giving me some bullshit about it ain\'t there, and we got to go someplace else and get it, I\'m gonna shoot you in the head then and there. Then I\'m gonna shoot that bitch in the kneecaps, find out where my goddamn money is. She gonna tell me too. Hey, look at me when I\'m talking to you, motherfucker. You listen: we go in there, and that nigga Winston or anybody else is in there, you the first motherfucker to get shot. You understand?</p><p>You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a week to climb out. Now, I don\'t know exactly when we turned on each other, but I know that seven of us survived the slide... and only five made it out. Now we took an oath, that I\'m breaking now. We said we\'d say it was the snow that killed the other two, but it wasn\'t. Nature is lethal but it doesn\'t hold a candle to man.</p>',
						class: 'styleguide-example-medium',
						title: 'Medium modal example.',
						closeText: 'Close',
						buttons: [
							{
								vars: {
									value: 'Submit',
									classes: 'primary',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							},
							{
								vars: {
									value: 'Cancel',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							}
						]
					}
				};
				showModal(modalConfig);
			});

			// opening a large modal example
			$('#showLargeModalExample').click(function () {
				var modalConfig = {
					type: 'default',
					vars: {
						id: 'largeModalExample',
						size: 'large',
						content: 'This is a large modal example. <a id="largeModalAltLink" href="#">Open small modal</a>',
						class: 'styleguide-example-large',
						title: 'Large modal example.',
						closeText: 'Close',
						buttons: [
							{
								vars: {
									value: 'Submit',
									classes: 'primary',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							},
							{
								vars: {
									value: 'Cancel',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							}
						]
					}
				};
				showModal(modalConfig, function (demoModal) {
					demoModal.show();

					// opening a small modal example over large modal
					$('#largeModalAltLink').click(function (event) {
						event.preventDefault();
						showModal({
							type: 'default',
							vars: {
								id: 'smallModalExampleOverLarge',
								size: 'small',
								content: $.msg('styleguide-example-modal-small-over-large-message'),
								class: 'styleguide-example-small-over-large',
								title: $.msg('styleguide-example-modal-small-over-large-title'),
								closeText: $.msg('styleguide-example-modal-close-text')
							}
						});
					});
				});
			});

			// opening a content-size modal example
			$('#showContentSizeModalExample').click(function () {
				var modalConfig = {
					type: 'default',
					vars: {
						id: 'contentSizeModalExample',
						size: 'content-size',
						content: '<p>Do you see any Teletubbies in here? Do you see a slender plastic tag clipped to my shirt with my name printed on it? Do you see a little Asian child with a blank expression on his face sitting outside on a mechanical helicopter that shakes when you put quarters in it? No? Well, that\'s what you see at a toy store. And you must think you\'re in a toy store, because you\'re here shopping for an infant named Jeb.</p><p>Your bones don\'t break, mine do. That\'s clear. Your cells react to bacteria and viruses differently than mine. You don\'t get sick, I do. That\'s also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We\'re on the same curve, just on opposite ends.</p><p>Your bones don\'t break, mine do. That\'s clear. Your cells react to bacteria and viruses differently than mine. You don\'t get sick, I do. That\'s also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We\'re on the same curve, just on opposite ends.</p><p>My money\'s in that office, right? If she start giving me some bullshit about it ain\'t there, and we got to go someplace else and get it, I\'m gonna shoot you in the head then and there. Then I\'m gonna shoot that bitch in the kneecaps, find out where my goddamn money is. She gonna tell me too. Hey, look at me when I\'m talking to you, motherfucker. You listen: we go in there, and that nigga Winston or anybody else is in there, you the first motherfucker to get shot. You understand?</p><p>You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a week to climb out. Now, I don\'t know exactly when we turned on each other, but I know that seven of us survived the slide... and only five made it out. Now we took an oath, that I\'m breaking now. We said we\'d say it was the snow that killed the other two, but it wasn\'t. Nature is lethal but it doesn\'t hold a candle to man.</p>',
						class: 'styleguide-example-content-size',
						title: 'Content Size modal example.',
						closeText: 'Close',
						buttons: [
							{
								vars: {
									value: 'Submit',
									classes: 'primary',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							},
							{
								vars: {
									value: 'Cancel',
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							}
						]
					}
				};
				showModal(modalConfig);
			});
		});
	});

});
