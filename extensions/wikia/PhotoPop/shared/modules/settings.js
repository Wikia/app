var exports = exports || {};

define.call(exports, {
	centralDomain: 'community.wikia.com',
	testDomain: 'jolek.wikia-dev.com',//comment out or set to null/false before release

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
		tutorial_1: 'tutorial_1.jpeg',
		tutorial_2: 'tutorial_2.jpeg',
		tutorial_3: 'tutorial_3.jpeg',
		tutorial_4: 'tutorial_4.jpeg',
		tutorial_5: 'tutorial_5.jpeg'
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
				'Hermione Granger',
				'Ron Weasley',
				'Tom Riddle',
				'Harry Potter'
			],
			correct: 'Harry Potter'
		},
		{
			image: 'tutorial_3',
			answers:[
				'Kermit the Frog',
				'Gonzo',
				'Miss Piggy',
				'Cookie Monster'
			],
			correct: 'Miss Piggy'
		},
		{
			image: 'tutorial_4',
			answers:[
				'Marge Simpson',
				'Lisa Simpson',
				'Bart Simpson',
				'Mr. Burns'
			],
			correct: 'Lisa Simpson'
		},
		{
			image: 'tutorial_5',
			answers:[
				'Joker',
				'Two-Face',
				'Scarecrow',
				'Penguin'
			],
			correct: 'Joker'
		}
	]
});
