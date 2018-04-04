<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/forthepeople5309/images/8/8a/ForThePeople.jpg/revision/latest?cb=20180130160036',
				'title' => 'For the People Wiki',
				'url' => 'http://forthepeople.wikia.com/wiki/For_the_People_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/greys/images/d/dd/GAS6cast.jpg/revision/latest?cb=20100614210055',
				'title' => 'Grey\'s Anatomy Wiki',
				'url' => 'http://greysanatomy.wikia.com/wiki/Grey%27s_Anatomy_Universe_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/chicago-pd/images/c/c3/Chicago-pd21.jpg/revision/latest?cb=20140123152937',
				'title' => 'Chicago PD Wiki',
				'url' => 'http://chicago-pd.wikia.com/wiki/Chicago_PD_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/chicagotrilogy/images/8/82/ChicagoFire.jpg/revision/latest?cb=20150825184429',
				'title' => 'Chicago Fire Wiki',
				'url' => 'http://chicagofire.wikia.com/wiki/Chicago_Fire_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/chicagomed/images/3/36/Mountains_And_Molehills_4.jpg/revision/latest?cb=20171219153457',
				'title' => 'Chicago Med Wiki',
				'url' => 'http://chicagomed.wikia.com/wiki/Chicago_Med_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/the-handmaids-tale/images/c/c2/Handmaids_tale_hulu_ep_5.jpg/revision/latest/scale-to-width-down/2000?cb=20170511002613',
				'title' => 'The Handmaid\'s Tale Wiki',
				'url' => 'http://the-handmaids-tale.wikia.com/wiki/The_Handmaid%27s_Tale_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dresdenfiles/images/9/93/HarryThomas.jpg/revision/latest?cb=20180223024704',
				'title' => 'The Dresden Files Wiki',
				'url' => 'http://dresdenfiles.wikia.com/wiki/Dresden_Files'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/diepio/images/3/32/Spotlight.png/revision/latest?cb=20180227151035',
				'title' => 'Diep.io Wikia',
				'url' => 'http://diepio.wikia.com/wiki/Diepio_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/future/images/2/22/Future-wallpaper-beautiful-future-wallpaper-x-of-future-wallpaper-1024x576.jpg/revision/latest?cb=20180316120033',
				'title' => 'Future Wiki',
				'url' => 'http://future.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/criminal-case-grimsborough/images/0/0e/Community-header-background/revision/latest?cb=20170614003827',
				'title' => 'Criminal Case Wiki',
				'url' => 'http://criminalcasegame.wikia.com/wiki/Criminal_Case_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/unordinary6344/images/4/47/UnOrdinary_spotlight.png/revision/latest?cb=20180325053803',
				'title' => 'unOrdinary Wiki',
				'url' => 'http://unordinary.wikia.com/wiki/UnOrdinary_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/snsd/images/d/d5/Girl%27s_Generation_Promotional_Picture_for_Holiday_Night.png/revision/latest?cb=20180324135038',
				'title' => 'SoNyuhShiDae Wiki',
				'url' => 'http://snsd.wikia.com/wiki/Girls%27_Generation_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/a/a8/FR-Westworld-Spotlight.jpg/revision/latest?cb=20180316162000&path-prefix=fr',
				'title' => 'Wiki Westworld',
				'url' => 'http://fr.westworld.wikia.com/wiki/Wiki_Westworld'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/7/75/FR-Krypton-Spotlight.jpg/revision/latest?cb=20180316161958&path-prefix=fr',
				'title' => 'Wiki DC Extended Universe',
				'url' => 'http://fr.dc-extended-universe.wikia.com/wiki/Wikia_L%27univers_cin%C3%A9matique_DC'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/c/c1/FR-MyHeroAcademiaS3-Spotlight.jpg/revision/latest?cb=20180316161959&path-prefix=fr',
				'title' => 'Wiki My Hero Academia',
				'url' => 'http://fr.bokunoheroacademia.wikia.com/wiki/Wiki_Boku_no_Hero_Academia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/1/1e/FR-Legion-Spotlight.jpg/revision/latest?cb=20180316162000&path-prefix=fr',
				'title' => 'Wiki X-Men',
				'url' => 'http://fr.xmen.wikia.com/wiki/Wiki_X-Men_First_Class'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/7/70/FR-Naruto-Spotlight.jpg/revision/latest?cb=20180321133028&path-prefix=fr',
				'title' => 'Wiki Naruto',
				'url' => 'http://fr.naruto.wikia.com/wiki/Accueil'
			],
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/21/Infinity_War_Spotlight.jpg/revision/latest?cb=20180329092936&path-prefix=de',
				'title' => 'Marvel-Filme Wiki',
				'url' => 'http://de.marvel-filme.wikia.com/wiki/Marvel-Filme'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/d4/Arrow_Season_5_Spotlight.jpg/revision/latest?cb=20180329093812&path-prefix=de',
				'title' => 'Arrowverse Wiki',
				'url' => 'http://de.arrowverse.wikia.com/wiki/Arrowverse_Wiki:Hauptseite'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/b7/Siren_Spotlight.png/revision/latest?cb=20180329094230&path-prefix=de',
				'title' => 'Siren Wiki',
				'url' => 'http://de.siren.wikia.com/wiki/Siren_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/26/Pacific_Rim_Uprising_Spotlight.png/revision/latest?cb=20180329100738&path-prefix=de',
				'title' => 'Pacific Rim Wiki',
				'url' => 'http://de.pacific-rim.wikia.com/wiki/Pacific_Rim_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/04/My_Hero_Academia_Spotlight.jpg/revision/latest?cb=20180329100933&path-prefix=de',
				'title' => 'My Hero Academia Wiki',
				'url' => 'http://de.myheroacademia.wikia.com/wiki/My_Hero_Academia_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/d0/Sword_Art_Online_SAO_Gun_Gale_Phantom_Bullet_Spotlight.png/revision/latest?cb=20180329102613&path-prefix=de',
				'title' => 'Sword Art Online Wiki',
				'url' => 'http://de.swordartonline.wikia.com/wiki/Sword_Art_Online_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/03/Kirby_Main_Artwork_HD.jpg/revision/latest?cb=20180228112718&path-prefix=de',
				'title' => 'Kirby Wiki',
				'url' => 'http://de.kirby.wikia.com/wiki/Kirby_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/1/18/Ni_No_Kuni_2_Key_Art_16-9.jpg/revision/latest?cb=20180228114650&path-prefix=de',
				'title' => 'Ni No Kuni Wiki',
				'url' => 'http://de.ninokuni.wikia.com/wiki/Ni_no_Kuni_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/4/40/Far_Cry_5_Spotlight.jpg/revision/latest?cb=20180228131517&path-prefix=de',
				'title' => 'Far Cry Wiki',
				'url' => 'http://de.farcry.wikia.com/wiki/FarCry_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/21/Videospiele_Wiki.jpg/revision/latest?cb=20180228143312&path-prefix=de',
				'title' => 'Videospiele Wiki',
				'url' => 'http://videospiele.wikia.com/wiki/Videospiele_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/cf/God_of_War_2018_Spotlight.jpg/revision/latest?cb=20180329102954&path-prefix=de',
				'title' => 'God of War Wiki',
				'url' => 'http://de.godofwar.wikia.com/wiki/God_of_War_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/03/Pillars_of_Eternity_II_Deadfire_Spotlight.jpg/revision/latest?cb=20180228144059&path-prefix=de',
				'title' => 'Pillars of Eternity Wiki',
				'url' => 'http://de.pillarsofeternity.wikia.com/wiki/Pillars_of_Eternity_Wiki'
			],
		],
		'it' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/onepunchman/images/a/a7/Tatsumaki.png/revision/latest?cb=20171101151651&path-prefix=it',
				'title' => 'One-Punch Man Wiki',
				'url' => 'https://goo.gl/QrXG3a'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/monsterhunter/images/c/c9/MHW-Rathalos_Artwork_002.jpg/revision/latest?cb=20170613095127',
				'title' => 'Monster Hunter Wiki',
				'url' => 'https://goo.gl/B8GDED'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/supermarioitalia/images/8/81/Wikia-Visualization-Main%2Citsupermarioitalia.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102154509&path-prefix=it',
				'title' => 'Super Mario Italia Wiki',
				'url' => 'https://goo.gl/8q571K'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/starwars/images/2/2a/Wikia-Visualization-Main%2Citstarwars.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102142316&path-prefix=it',
				'title' => 'Jawapedia',
				'url' => 'https://goo.gl/MF5jEG'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kingdomhearts/images/b/b1/Wikia-Visualization-Main%2Ckingdomhearts.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102141406',
				'title' => 'Kingdom Hearts Wiki',
				'url' => 'https://goo.gl/4VQrt1'
			],
		],
		'ja' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlefront/images/3/3b/BF2_IMG.jpg/revision/latest?cb=20170905023120&path-prefix=ja',
				'title' => 'Battlefront Wiki',
				'url' => 'http://ja.battlefront.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/gameofthrones/images/7/75/GOTS7-E5-25.jpg/revision/latest/scale-to-width-down/640?cb=20170822083703&path-prefix=ja',
				'title' => 'ゲームオブスローンズ Wiki',
				'url' => 'http://ja.gameofthrones.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/starwars/images/6/65/Battle_of_Endor.png/revision/latest?cb=20150129051829&path-prefix=ja',
				'title' => 'ウーキーペディア',
				'url' => 'http://ja.starwars.wikia.com'
			],
		],
		'pl' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/7/7b/ELEX_Wiki.png/revision/latest?cb=20171105202319&path-prefix=pl',
				'title' => 'ELEX Wiki',
				'url' => 'http://pl.elex.wikia.com/wiki/ELEX_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/2/27/YouTube_Wiki.jpg/revision/latest?cb=20171105210441',
				'title' => 'YouTube Wiki',
				'url' => 'http://pl.youtube.wikia.com/wiki/YouTube_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/7/74/UTfRdUj.jpg/revision/latest?cb=20171201175632&path-prefix=pl',
				'title' => 'Phoenotopia Wiki',
				'url' => 'http://pl.phoenotopia.wikia.com/wiki/Phoenotopia_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/4/4c/TI6Q6jX.jpg/revision/latest?cb=20171201175705&path-prefix=pl',
				'title' => 'Xenopedia',
				'url' => 'http://pl.alien.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/lowcy-trolli/images/c/c1/Jim_sezon2.jpg/revision/latest?cb=20171217213110&path-prefix=pl',
				'title' => 'Łowcy Trolli Wiki',
				'url' => 'http://pl.lowcy-trolli.wikia.com/wiki/%C5%81owcy_Trolli_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/f/f3/Dziedzictwo_Wiki_01-2018.jpg/revision/latest?cb=20180102224021&path-prefix=pl',
				'title' => 'Dziedzictwo Wiki',
				'url' => 'http://dziedzictwo.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/8/8d/Star_Butterfly_kontra_si%C5%82y_z%C5%82a_Wiki_01_2018.png/revision/latest?cb=20180102224140&path-prefix=pl',
				'title' => 'Star Butterfly kontra Siły Zła Wiki',
				'url' => 'http://pl.star-butterfly-kontra-sily-zla.wikia.com/wiki/Star_Butterfly_kontra_si%C5%82y_z%C5%82a_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/e/ed/TG_Spotlight.png/revision/latest?cb=20180202194503&path-prefix=pl',
				'title' => 'Tokyo Ghoul Wiki',
				'url' => 'http://pl.tokyo-ghoul.wikia.com/wiki/Tokyo_Ghoul_Wiki'
			],
		],
		'pt-br' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/6/62/16569930111_2397ecbdf3_o.jpg/revision/latest?cb=20171128042327&path-prefix=pt-br',
				'title' => 'RuneScape Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-runescape'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dccomics/images/c/c9/DC_Rebirth.png/revision/latest?cb=20161205133034&path-prefix=pt',
				'title' => 'Wiki DC Comics',
				'url' => 'http://bit.ly/fandom-ptbr-footer-dc'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/marvel/images/3/30/Universo_Marvel.png/revision/latest?cb=20170804153745&path-prefix=pt-br',
				'title' => 'Marvel Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-marvel'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/f/f9/Crisis-on-earth-x-90.jpg/revision/latest?cb=20171128043022&path-prefix=pt-br',
				'title' => 'Arrowverso Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-arrowverse'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/9/97/814586-paradise_falls.jpg/revision/latest?cb=20171128043807&path-prefix=pt-br',
				'title' => 'Fallout Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-fallout'
			]
		],
		'ru' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/8/80/Elder_Scrolls_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://bit.ly/teswiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b5/Dark_Souls_January_17.jpg/revision/latest?cb=20171221092333',
				'title' => 'Dark Souls вики',
				'url' => 'http://bit.ly/ru-spotlight-darksouls-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a6/Fallout_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'Убежище',
				'url' => 'http://bit.ly/ru-spotlight-fallout-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ninga/images/f/fc/Rise_of_TMNT_Promo_1.jpg/revision/latest?cb=20180201103754&path-prefix=ru',
				'title' => 'Черепахопедия',
				'url' => 'http://bit.ly/ru-spotlight-turtle-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spore/images/c/c2/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80-%D0%B4%D0%BB%D1%8F-SporeWiki-2-%D0%B8%D1%81%D0%BF%D1%80.png/revision/latest?cb=20180221114256&path-prefix=ru',
				'title' => 'Spore Wiki',
				'url' => 'http://bit.ly/ru-spotlight-spore-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/stalker/images/f/f9/XR_3DA_2014-05-16_23-15-37-09.png/revision/latest?cb=20140517123013&path-prefix=ru',
				'title' => 'S.T.A.L.K.E.R. Wiki',
				'url' => 'http://bit.ly/ru-spotlight-stalker-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/meownjik/images/0/00/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_%D0%BD%D0%BE%D0%B2.png/revision/latest?cb=20180220132208&path-prefix=ru',
				'title' => 'Википисалия',
				'url' => 'http://bit.ly/ru-spotlight-pisalia-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/6f/Mount_and_Blade.jpg/revision/latest?cb=20180223092135',
				'title' => 'Mount & Blade Wiki',
				'url' => 'http://bit.ly/ru-spotlight-mountblade-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/2c/Far_Cry_5.jpg/revision/latest?cb=20180322084609',
				'title' => 'Far Cry 5',
				'url' => 'http://bit.ly/ru-spotlight-farcry-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/c/c7/Shadowhunters.jpg/revision/latest?cb=20180322084613',
				'title' => 'Сумеречные охотники вики',
				'url' => 'http://bit.ly/ru-spotlight-shadowhunters-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/02/Kingdom-Come-Deliverance.jpg/revision/latest?cb=20180322084610',
				'title' => 'Kingdom Come: Deliverance Wiki',
				'url' => 'http://bit.ly/ru-spotlight-kingdomcome-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/24/Scoobydoo.jpg/revision/latest?cb=20180322084612',
				'title' => 'Скуби Ду Вики',
				'url' => 'http://bit.ly/ru-spotlight-scoobydoo-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/4a/Lucifer-season-3.jpg/revision/latest?cb=20180322084611',
				'title' => 'Люцифер Вики',
				'url' => 'http://bit.ly/ru-spotlight-lucifer-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/61/The_100_season_5.jpg/revision/latest?cb=20180322084614',
				'title' => 'Сотня вики',
				'url' => 'http://bit.ly/ru-spotlight-the100-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/23/Fear-the-Walking-Dead-season-4.jpg/revision/latest?cb=20180322084610',
				'title' => 'Бойся ходячих мертвецов',
				'url' => 'http://bit.ly/ru-spotlight-fearwalkingdead-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/3/33/Smeshariki-Dezha-vu.jpg/revision/latest?cb=20180322084614',
				'title' => 'Смешарики. Дежавю',
				'url' => 'http://bit.ly/ru-spotlight-smesh-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/09/Slime_rancher.jpg/revision/latest?cb=20180322084613',
				'title' => 'Slime Rancher вики',
				'url' => 'http://bit.ly/ru-spotlight-slimerancher-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/dc/Winx.jpg/revision/latest?cb=20180322084615',
				'title' => 'Винксопедия',
				'url' => 'http://bit.ly/ru-spotlight-winx-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/07/Overwatch.jpg/revision/latest?cb=20180322084612',
				'title' => 'Overwatch вики',
				'url' => 'http://bit.ly/ru-spotlight-overwatch-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/49/Tokyo_Ghoul.jpg/revision/latest?cb=20180322084615',
				'title' => 'Tokyo Ghoul:re',
				'url' => 'http://bit.ly/ru-spotlight-tokyoghoul-april'
			]
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/9/97/Spotlight-TG.png/revision/latest?cb=20180219211758',
				'title' => 'Wiki Tokyo Ghoul',
				'url' => 'http://bit.ly/2pTVtSO'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/2/24/Aslan-de-narnia_xtrafondos.jpg/revision/latest?cb=20180330201529',
				'title' => 'Narnia Wiki',
				'url' => 'http://bit.ly/2uyklVJ'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/1/14/Spotlight_%28BHA%29.jpg/revision/latest?cb=20180323030538',
				'title' => 'Wiki Boku no Hero Academia',
				'url' => 'http://bit.ly/2E7Wbkk'
			],
		],
		'zh' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/shironekoproject/images/5/50/Wiki-background/revision/latest?cb=20150130211808&path-prefix=zh',
				'title' => '白貓計劃Wiki',
				'url' => 'http://zh.shironekoproject.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fate-go/images/2/2f/Mainvisual.png/revision/latest?cb=20160105185037&path-prefix=zh',
				'title' => 'Fate/Grand Order Wiki',
				'url' => 'http://zh.fate-go.wikia.com/wiki/Fate/Grand_Order_%E4%B8%AD%E6%96%87_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/asoiaf/images/3/32/17966414_10154688723507734_1247624339901587946_o.jpg/revision/latest?cb=20170420224445&path-prefix=zh',
				'title' => '冰与火之歌中文维基',
				'url' => 'http://zh.asoiaf.wikia.com/wiki/%E5%86%B0%E4%B8%8E%E7%81%AB%E4%B9%8B%E6%AD%8C%E4%B8%AD%E6%96%87%E7%BB%B4%E5%9F%BA'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/nekowiz/images/5/50/Wiki-background/revision/latest?cb=20150130231207&path-prefix=zh',
				'title' => '問答RPG 魔法使與黑貓維茲 維基',
				'url' => 'http://zh.nekowiz.wikia.com/wiki/%E5%95%8F%E7%AD%94RPG_%E9%AD%94%E6%B3%95%E4%BD%BF%E8%88%87%E9%BB%91%E8%B2%93%E7%B6%AD%E8%8C%B2_%E7%B6%AD%E5%9F%BA'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ffexvius/images/5/50/Wiki-background/revision/latest?cb=20160912171651&path-prefix=zh',
				'title' => 'FINAL FANTASY BRAVE EXVIUS中文 Wiki',
				'url' => 'http://zh.ffexvius.wikia.com/wiki/FINAL_FANTASY_BRAVE_EXVIUS%E4%B8%AD%E6%96%87_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/starwars/images/4/42/Header_bf2.png/revision/latest?cb=20170824065801&path-prefix=zh-hk',
				'title' => '星戰維基',
				'url' => 'http://zh.starwars.wikia.com/wiki/%E6%98%9F%E7%90%83%E5%A4%A7%E6%88%B0%E7%99%BE%E7%A7%91%E5%85%A8%E6%9B%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hongkongbus/images/f/f2/KMB_GB9206_263.JPG/revision/latest?cb=20090802113442&path-prefix=zh',
				'title' => '香港巴士大典',
				'url' => 'http://hkbus.wikia.com/wiki/%E9%A6%96%E9%A0%81'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hunterxhunter/images/4/48/Hunterxhunter.jpg/revision/latest?cb=20170904145736&path-prefix=zh',
				'title' => '獵人Wiki',
				'url' => 'http://zh.hunterxhunter.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlegirl/images/8/87/Banner.png/revision/latest?cb=20170725105753&path-prefix=zh',
				'title' => '戰鬥女子學園Wiki',
				'url' => 'http://zh.battlegirl.wikia.com/wiki/%E6%88%B0%E9%AC%A5%E5%A5%B3%E5%AD%90%E5%AD%B8%E5%9C%92_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fireemblem/images/1/14/20170120044344.jpg/revision/latest?cb=20171225154833&path-prefix=zh',
				'title' => '聖火降魔錄Wiki',
				'url' => 'http://zh.fireemblem.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kirara-fantasia/images/5/5e/Header.jpg/revision/latest?cb=20171218002428&path-prefix=zh',
				'title' => 'KIRARA FANTASIA 中文Wiki',
				'url' => 'http://zh.kirara-fantasia.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/d2-megaten-l/images/b/b8/%EF%BC%A4%C3%97%EF%BC%92_%E7%9C%9F%E3%83%BB%E5%A5%B3%E7%A5%9E%E8%BD%89%E7%94%9F.JPG/revision/latest?cb=20180128004321&path-prefix=zh',
				'title' => 'Ｄ×２ 真・女神轉生 Liberation Wiki',
				'url' => 'http://zh.d2megaten.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/violet-evergarden/images/2/21/Violet-Evergarden-Header-001-20160527.jpg/revision/latest?cb=20160616112327',
				'title' => '紫羅蘭永恆花園Wiki',
				'url' => 'http://zh.violet-evergarden.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/legendofzelda/images/7/7c/BotW_Tile.png/revision/latest?cb=20171128141246&path-prefix=zh-tw',
				'title' => '薩爾達傳說Wiki',
				'url' => 'http://zh-tw.legendofzelda.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/opbr/images/a/a0/Unnamed.png/revision/latest?cb=20180401105503&path-prefix=zh',
				'title' => '航海王Bounty Rush Wiki',
				'url' => 'http://zh.opbr.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/pacificrim/images/b/b5/20180326-112617_U3792_M395231_5850.jpg/revision/latest?cb=20180401105122&path-prefix=zh',
				'title' => '環太平洋Wiki',
				'url' => 'http://zh.pacificrim.wikia.com'
			],
		]
	];

	const STAGING_RECOMMENDATIONS = [
		[
			'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/muppet/images/4/4b/Image001.png/revision/latest?cb=20170911141514',
			'title' => 'Selenium',
			'url' => 'http://selenium.wikia-staging.com',
		],
		[
			'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/selenium/images/e/e2/Image009.jpg/revision/latest?cb=20170911141722',
			'title' => 'Halloween',
			'url' => 'http://halloween.wikia-staging.com',
		],
		[
			'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/selenium/images/2/2e/WallPaperHD_138.jpg/revision/latest?cb=20170911141722',
			'title' => 'Sktest123',
			'url' => 'http://sktest123.wikia-staging.com',
		]
	];

	const DEV_RECOMMENDATIONS = [
		'us' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.us/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
				'title' => 'Game of Thrones',
				'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.us/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
				'title' => 'Death Note',
				'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.us/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
				'title' => 'Midnight Texas',
				'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
			]
		],
		'pl' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.pl/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
				'title' => 'Game of Thrones',
				'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.pl/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
				'title' => 'Death Note',
				'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.pl/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
				'title' => 'Midnight Texas',
				'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
			]
		]
	];

	public static function getRecommendations( $contentLanguage ) {
		global $wgWikiaDatacenter, $wgWikiaEnvironment;

		if ( $wgWikiaEnvironment === WIKIA_ENV_STAGING ) {
			$recommendations = self::STAGING_RECOMMENDATIONS;
		} elseif ( $wgWikiaEnvironment === WIKIA_ENV_DEV ) {
			if ( $wgWikiaDatacenter === WIKIA_DC_POZ ) {
				$recommendations = self::DEV_RECOMMENDATIONS['pl'];
			} else {
				$recommendations = self::DEV_RECOMMENDATIONS['us'];
			}
		} else {
			$recommendations = self::RECOMMENDATIONS['en'];
			$fallbackedContentLanguage = self::fallbackToSupportedLanguages( $contentLanguage );

			if ( array_key_exists( $fallbackedContentLanguage, self::RECOMMENDATIONS ) ) {
				$recommendations = self::RECOMMENDATIONS[$fallbackedContentLanguage];
			}
			shuffle( $recommendations );
		}

		$recommendations = array_slice( $recommendations, 0, self::WIKI_RECOMMENDATIONS_LIMIT );

		$index = 1;
		foreach ( $recommendations as &$recommendation ) {
			$recommendation['thumbnailUrl'] = self::getThumbnailUrl( $recommendation['thumbnailUrl'] );
			$recommendation['index'] = $index;
			$index++;
		}

		return $recommendations;
	}

	private static function fallbackToSupportedLanguages( $language ) {
		switch ( $language ) {
			case 'pt':
				return 'pt-br';
			case 'zh-tw':
			case 'zh-hk':
				return 'zh';
			case 'be':
			case 'kk':
			case 'uk':
				return 'ru';
			default:
				return $language;
		}
	}

	private static function getThumbnailUrl( $url ) {
		try {
			return VignetteRequest::fromUrl( $url )->zoomCrop()->width( self::THUMBNAIL_WIDTH )->height(
				floor( self::THUMBNAIL_WIDTH / self::THUMBNAIL_RATIO )
			)->url();
		} catch ( Exception $exception ) {
			\Wikia\Logger\WikiaLogger::instance()->warning(
				"Invalid thumbnail url provided for explore-wikis module inside mixed content footer",
				[
					'thumbnailUrl' => $url,
					'message' => $exception->getMessage(),
				]
			);

			return '';
		}
	}
}
