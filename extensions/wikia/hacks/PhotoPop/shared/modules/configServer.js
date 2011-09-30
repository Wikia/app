var exports = exports || {};

define.call(exports, {
	
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
		gameicon_trueblood: "gameicon_trueblood",
		gameicon_glee: "gameicon_glee",
		gameicon_lyrics: "gameicon_lyrics",
		gameicon_muppet: "gameicon_muppet",
		gameicon_dexter: "gameicon_dexter",
		gameicon_futurama: "gameicon_futurama",
		gameicon_twilight: "gameicon_twilight",
		watermark_trueblood: "watermark_trueblood",
		watermark_glee: "watermark_glee",
		watermark_lyrics: "watermark_lyrics",
		watermark_muppet: "watermark_muppet",
		watermark_dexter: "watermark_dexter",
		watermark_futurama: "watermark_futurama",
		watermark_twilight: "watermark_twilight",
		tutorial_1: 'tutorial_1.jpeg',
		tutorial_2: 'tutorial_2.jpeg',
		tutorial_3: 'tutorial_3.jpeg',
		tutorial_4: 'tutorial_4.jpeg',
		tutorial_5: 'tutorial_5.jpeg'
	},
	
	urls: {
		playButtonUrl: "playButton();",
		tutorialButtonUrl: "#tutorial",
		backHomeUrl: "",
		trueblood: "",
		glee: "",
		lyrics: "",
		muppet: "",
		dexter: "",
		futurama: "",
		twilight: ""
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
	],

	games: [{
			category: "Category:Characters",
			gameName: "True Blood",
			name: "trueblood"
		},
		{
			category: "Category:Characters",
			gameName: "Glee Wiki",
			name: "glee"
		},
		{
			category: "Category:Albums_released_in_2011",
			gameName: "LyricWiki",
			name: "lyrics"
		},
		{
			category: "Category:The_Muppets_Characters",
			gameName: "Muppet Wiki",
			name: "muppet"
		},
		{
			category: "Category:Characters",
			gameName: "Dexter Wiki",
			name: "dexter"
		},
		{
			category: "Category:Characters",
			gameName: "Futurama",
			name: "futurama"
		},
		{
			category: "Category:Twilight_Characters",
			gameName: "Twilight Saga",
			name: "twilight"
		}]
});
