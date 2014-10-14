var exports = exports || {};

define.call(exports, {
	centralDomain: 'community.wikia.com',
	//testDomain: 'federico.wikia-dev.com',//comment out or set to null/false before release
	sharedAudioPath: "shared/audio/",
	webAudioPath: "audio/",
	webPrefix: "extensions/wikia/PhotoPop/",

	images: {
		PHOTOPOP_LOGO: "logo_photopop",
		POWERED_BY_LOGO: "logo_wikia",
		buttonSrc_play: "button_play",
		buttonSrc_scores: "button_scores",
		buttonSrc_tutorial: "button_tutorial",
		buttonSrc_volumeOn: "button_volume_on",
		buttonSrc_volumeOff: "button_volume_off",
		buttonSrc: "button_down_arrow",
		buttonSrc_home: "button_home",
		buttonSrc_answerOpen: "button_answers_open",
		buttonSrc_answerClose: "button_answers_close",
		buttonSrc_contiunue: "button_continue",
		buttonSrc_endHome: "button_end_home",
		buttonSrc_endReplay: "button_end_replay",
		buttonSrc_endScores: "button_end_scores",
		buttonSrc_pause: "button_pause",
		buttonSrc_resume: "button_resume",
		buttonSrc_gameMute: "button_mute",
		buttonSrc_gameUnmute: "button_unmute",
		gameicon_default: "gameicon_default",
		watermark_default: "watermark_default",
		background: "photopop_background_tile",
		tutorial_1: 'tutorial_1.jpeg',
		tutorial_2: 'tutorial_2.jpeg'
	},

	sounds: {
		fail: "Sad-Trombone",
		pop: "FingerPlop4",
		win: "Human-Applause-MediumCrowd03",
		timeLow: "CountdowntoBlastOff",
		wrongAnswer: "tubePop"
	},

	tutorial:[
		{
			image: 'tutorial_1',
			answers:[
				'Edward Cullen',
				'Jacob Black',
				'Bella Swan',
				'Emmett Cullen'
			],
			correct: 'Edward Cullen'
		},
		{
			image: 'tutorial_2',
			answers:[
				'Kermit the Frog',
				'Gonzo',
				'Miss Piggy',
				'Cookie Monster'
			],
			correct: 'Miss Piggy'
		}
	]
});
