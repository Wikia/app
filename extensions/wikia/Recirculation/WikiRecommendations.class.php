<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/thevoice/images/6/6a/Thevoiceneondrea-1509417700172-1-HR.jpg/revision/latest?cb=20171221015400',
				'title' => 'The Voice Wiki',
				'url' => 'http://thevoice.wikia.com/wiki/The_Voice_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/scandal/images/7/7e/7x10_-_Olivia_Pope_08.jpg/revision/latest?cb=20180127020049',
				'title' => 'Scandal Wiki',
				'url' => 'http://scandal.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/roseanne/images/b/b2/RoseanneSeason10MainCast.jpg/revision/latest?cb=20180112055254',
				'title' => 'Roseanne Wiki',
				'url' => 'http://roseanne.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/mazerunner/images/1/17/TDCstill5.jpg/revision/latest?cb=20171210210934',
				'title' => 'The Maze Runner Wiki',
				'url' => 'http://mazerunner.wikia.com/wiki/The_Maze_Runner_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/the-good-doctor/images/a/ac/148380_3796.jpg/revision/latest?cb=20180111211619',
				'title' => 'The Good Doctor Wiki',
				'url' => 'http://the-good-doctor.wikia.com/wiki/The_Good_Doctor_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ccs/images/f/fc/CCSTCCA-OP148.png/revision/latest?cb=20180127202133',
				'title' => 'CardCaptor Sakura Wiki',
				'url' => 'http://ccsakura.wikia.com/wiki/Cardcaptor_Sakura_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/pixel-gun-3d/images/3/33/PGWikiSpotlight.png/revision/latest?cb=20171220143025',
				'title' => 'Pixel Gun Wiki',
				'url' => 'http://pixelgun.wikia.com/wiki/Pixel_Gun_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/customherofactory/images/0/0e/Community-header-background/revision/latest?cb=20170803042759',
				'title' => 'Custom Hero Factory Wiki',
				'url' => 'http://customherofactory.wikia.com/wiki/Custom_Hero_Factory_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/differenthistory/images/3/3c/288px-SocialistYugoslavia_en.svg.png/revision/latest?cb=20170926155855',
				'title' => 'DifferentHistory Wiki',
				'url' => 'http://differenthistory.wikia.com/wiki/DifferentHistory_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/halloweenhorrornights/images/4/45/Jack-the-clown.jpg/revision/latest?cb=20171231131253',
				'title' => 'Halloween Horror Nights Wiki',
				'url' => 'http://halloweenhorrornights.wikia.com/wiki/Halloween_Horror_Nights_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/merrystartest/images/9/96/TowerOfGod.png/revision/latest?cb=20180126014906',
				'title' => 'Tower of God Wiki',
				'url' => 'http://towerofgod.wikia.com/wiki/Tower_of_God_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/merrystartest/images/2/28/Subnautica.jpg/revision/latest?cb=20180126015246',
				'title' => 'Subnautica Wiki',
				'url' => 'http://subnautica.wikia.com/wiki/Subnautica_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/0/0b/FR-SwordArtOnline-Spotlight.jpg/revision/latest/scale-to-width-down/640?cb=20180129165210&path-prefix=fr',
				'title' => 'Wiki Sword Art Online',
				'url' => 'http://fr.sword-art-online.wikia.com/wiki/Wiki_Sword_Art_Online'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/8/88/FR-BlackPanther-Spotlight.jpg/revision/latest?cb=20180129164833&path-prefix=fr',
				'title' => 'Wiki Marvel Studios',
				'url' => 'http://fr.universcinematographiquemarvel.wikia.com/wiki/Wikia_Marvel_Studios'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/f/fe/FR-Lucifer-Spotlight.jpg/revision/latest?cb=20180129164832&path-prefix=fr',
				'title' => 'Wiki Lucifer',
				'url' => 'http://fr.lucifer.wikia.com/wiki/Wiki_Lucifer'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/9/9f/FR-DragonQuest-Spotlight.jpg/revision/latest?cb=20180129164830&path-prefix=fr',
				'title' => 'Wiki Dragon Quest',
				'url' => 'http://fr.dragonquest.wikia.com/wiki/Wiki_Dragon_Quest'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/b/bf/FR-Desencyclopedie-Spotlight.jpg/revision/latest?cb=20180129164832&path-prefix=fr',
				'title' => 'Désencyclopédie',
				'url' => 'http://desencyclopedie.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/9/90/FR-MazeRunner-Spotlight.jpg/revision/latest?cb=20180129164831&path-prefix=fr',
				'title' => 'Wiki Maze Runner',
				'url' => 'http://fr.mazerunner.wikia.com/wiki/Wiki_The_Maze_Runner'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/8/89/FR-SevenDeadlySins-Spotlight.jpg/revision/latest?cb=20180129165302&path-prefix=fr',
				'title' => ' Wiki Seven Deadly Sins',
				'url' => 'http://fr.seven-deadly-sins.wikia.com/wiki/Wiki_Seven_Deadly_Sins'
			],
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/babylon-berlin/images/9/9f/Header_Charlotte.png/revision/latest/scale-to-width-down/670?cb=20171129204224&path-prefix=de',
				'title' => 'Babylon Berlin Wiki',
				'url' => 'http://de.babylon-berlin.wikia.com/wiki/Babylon_Berlin_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/5/5e/Akte-X-Spotlight.jpg/revision/latest?cb=20171221160355&path-prefix=de',
				'title' => 'Akte-X Wiki',
				'url' => 'http://de.akte-x.wikia.com/wiki/Akte-X_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dewikia/images/b/b9/T0season52.jpg/revision/latest?cb=20180104185748',
				'title' => 'The Originals Wiki',
				'url' => 'http://de.vampirediaries.wikia.com/wiki/Vampire_Diaries_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dewikia/images/5/57/Spotlightantrag.jpg/revision/latest?cb=20180114144703',
				'title' => 'Lego Ninjago Wiki',
				'url' => 'http://de.lego-ninjago.wikia.com/wiki/Lego_Ninjago_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/0c/Altered_Carbon_Spotlight.jpg/revision/latest?cb=20180123121216&path-prefix=de',
				'title' => 'Altered Carbon Wiki',
				'url' => 'http://de.altered-carbon.wikia.com/wiki/Altered_Carbon_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/ce/Sword_Art_Online_Spotlight.jpg/revision/latest?cb=20180123121412&path-prefix=de',
				'title' => 'Sword Art Online Wiki',
				'url' => 'http://de.swordartonline.wikia.com/wiki/Sword_Art_Online_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/25/Maze_Runner_Spotlight.jpg/revision/latest?cb=20180123121703&path-prefix=de',
				'title' => 'Maze Runner Wiki',
				'url' => 'http://de.mazerunner.wikia.com/wiki/Maze_Runner_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bigbangtheory/images/5/51/Young-sheldon_CBS.jpg/revision/latest/scale-to-width-down/670?cb=20180106125702&path-prefix=de',
				'title' => 'Young Sheldon Wiki',
				'url' => 'http://de.bigbangtheory.wikia.com/wiki/Big_Bang_Theory_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/0c/American_Crime_Story_Spotlight.jpg/revision/latest?cb=20180123122501&path-prefix=de',
				'title' => 'American Crime Story Wiki',
				'url' => 'http://de.americancrimestory.wikia.com/wiki/American_Crime_Story_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fraufruehling/images/1/1f/Citrus_Spotlights_2.jpg/revision/latest?cb=20180125132932&path-prefix=de',
				'title' => 'Citrus Wiki',
				'url' => 'http://de.citrus.wikia.com/wiki/Citrus_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/monsterhunternews/images/0/00/Monster_Hunter_World_-_Slider.jpg/revision/latest/scale-to-width-down/670?cb=20170825122405&path-prefix=de',
				'title' => 'Monster Hunter Wiki',
				'url' => 'http://de.monsterhunter.wikia.com/wiki/Monster_Hunter_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/db/Subnautica_Spotlight.jpg/revision/latest?cb=20171023143728&path-prefix=de',
				'title' => 'Subnautica Wiki',
				'url' => 'http://de.subnautica.wikia.com/wiki/Subnautica_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/0c/Final_Fantasy_Spotlight.jpg/revision/latest?cb=20180123123706&path-prefix=de',
				'title' => 'Final Fantasy Wiki',
				'url' => 'http://de.finalfantasy.wikia.com/wiki/Final_Fantasy_Almanach'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/b0/Kingdom-Come-Deliverance-Spotlight.jpg/revision/latest?cb=20180123123322&path-prefix=de',
				'title' => 'Kingdom Come: Deliverance Wiki',
				'url' => 'http://de.kingdom-come-deliverance.wikia.com/wiki/Kingdom_Come:_Deliverance_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/8/86/Secret_of_Mana_Spotlight.jpg/revision/latest?cb=20180123124131&path-prefix=de',
				'title' => 'Secret of Mana Wiki',
				'url' => 'http://de.secretofmana.wikia.com/wiki/Secret_of_Mana_Wiki'
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
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/a/a2/League_of_Legends_Wiki.jpg/revision/latest?cb=20170901024914&path-prefix=pl',
				'title' => 'League of Legends Wiki',
				'url' => 'http://pl.leagueoflegends.wikia.com/wiki/League_of_Legends_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/e/e1/Rayman_Wiki.jpg/revision/latest?cb=20170825174755&path-prefix=pl',
				'title' => 'Rayman Wiki',
				'url' => 'http://pl.rayman.wikia.com/wiki/Rayman_Wiki:Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/6/60/DC_Wiki.jpg/revision/latest?cb=20170825173855&path-prefix=pl',
				'title' => 'DC Wiki',
				'url' => 'http://pl.dc.wikia.com/wiki/DC_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/7/7f/The_Elder_Scrolls_Wiki.jpg/revision/latest?cb=20170901024627&path-prefix=pl',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://pl.elderscrolls.wikia.com/wiki/The_Elder_Scrolls_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/8/81/Slider-Z%C5%82oczy%C5%84cy_Wiki.jpg/revision/latest?cb=20170929175616',
				'title' => 'Złoczyńcy Wiki',
				'url' => 'http://pl.villains.wikia.com/wiki/Z%C5%82oczy%C5%84cy_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/3/35/Wied%C5%BAmin_Wiki.jpg/revision/latest?cb=20170901031050&path-prefix=pl',
				'title' => 'Wiedźmin Wiki',
				'url' => 'http://wiedzmin.wikia.com/wiki/Wied%C5%BAmin_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/2/2b/Warframe_Wiki.jpg/revision/latest?cb=20170901031050&path-prefix=pl',
				'title' => 'Warframe Wiki',
				'url' => 'http://pl.warframe.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/b/b3/My_Little_Pony_Wiki.jpg/revision/latest?cb=20170901030633&path-prefix=pl',
				'title' => 'My Little Pony Wiki',
				'url' => 'http://pl.mlp.wikia.com/wiki/My_Little_Pony_Przyja%C5%BA%C5%84_to_magia_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/f/fa/Naruto_Wiki.jpg/revision/latest?cb=20170901032034&path-prefix=pl',
				'title' => 'Naruto Wiki',
				'url' => 'http://pl.naruto.wikia.com/wiki/Naruto_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/b/ba/Gwint_Wiki.jpg/revision/latest?cb=20170901031049&path-prefix=pl',
				'title' => 'Gwint Wiki',
				'url' => 'http://gwint.wikia.com/wiki/Gwint_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/5/5d/Gra_o_Tron_Wiki.jpg/revision/latest?cb=20170901033400&path-prefix=pl',
				'title' => 'Gra o Tron Wiki',
				'url' => 'http://graotron.wikia.com/wiki/Gra_o_tron_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/0/0f/Pokemon_Wiki.jpg/revision/latest?cb=20170901033359&path-prefix=pl',
				'title' => 'Pokemon Wiki',
				'url' => 'http://pl.pokemon.wikia.com/wiki/Pok%C3%A9mon_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/f/fe/Need_for_Speed_Wiki.jpg/revision/latest?cb=20170901033401&path-prefix=pl',
				'title' => 'Need for Speed Wiki',
				'url' => 'http://pl.nfs.wikia.com/wiki/Need_for_Speed_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/5/59/Overwatch_Wiki.jpg/revision/latest?cb=20170901030239&path-prefix=pl',
				'title' => 'Overwatch Wiki',
				'url' => 'http://pl.overwatch.wikia.com/wiki/Overwatch_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/d/d7/Death_Note.jpg/revision/latest?cb=20170901032713&path-prefix=pl',
				'title' => 'Death Note Wiki',
				'url' => 'http://pl.deathnote.wikia.com/wiki/Death_Note_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/5/5e/Battlefield_Wiki.jpg/revision/latest?cb=20170901033400&path-prefix=pl',
				'title' => 'Battlefield Wiki',
				'url' => 'http://pl.battlefield.wikia.com/wiki/Battlefield_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/b/b1/Auta_Wiki.png/revision/latest?cb=20170901025628&path-prefix=pl',
				'title' => 'Auta Wiki',
				'url' => 'http://pl.auta.wikia.com/wiki/Auta_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/6/6e/Life_is_Strange_Wiki.jpg/revision/latest?cb=20170901032033&path-prefix=pl',
				'title' => 'Life is Strange Wiki',
				'url' => 'http://pl.lifeisstrange.wikia.com/wiki/Life_Is_Strange_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/unturned-polska/images/b/b6/Spotlight.jpg/revision/latest?cb=20170929203539&path-prefix=pl',
				'title' => 'Unturned Wiki',
				'url' => 'http://pl.unturned.wikia.com/wiki/Unturned_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/6/66/Spotlight_Arrowwersum_%28pa%C5%BAdziernik_2017_nowa_wersja%29.png/revision/latest?cb=20170923195223',
				'title' => 'Arrowwersum',
				'url' => 'http://arrowwersum.wikia.com/wiki/Arrowwersum'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/3/30/Fanonpedia_spotlight_listopad_2017.png/revision/latest?cb=20171008170243',
				'title' => 'Star Wars Fanonpedia',
				'url' => 'http://gwfanon.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
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
			]
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
				'url' => 'http://ru.darksouls.wikia.com/wiki/Dark_Souls_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a6/Fallout_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'Убежище',
				'url' => 'http://ru.fallout.wikia.com/wiki/Fallout_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/sporerolevetion1/images/4/4b/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%802.png/revision/latest?cb=20171208171026&path-prefix=ru',
				'title' => 'Ролевые игры Spore Вики',
				'url' => 'http://ru.sporeroleplay.wikia.com/wiki/%D0%A0%D0%BE%D0%BB%D0%B5%D0%B2%D1%8B%D0%B5_%D0%B8%D0%B3%D1%80%D1%8B_Spore_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/igromania/images/4/4c/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_01-02_2018.png/revision/latest?cb=20171216183041&path-prefix=ru',
				'title' => 'ИгроВики',
				'url' => 'http://ru.igrowiki.wikia.com/wiki/%D0%98%D0%B3%D1%80%D0%BE%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/e/e5/Heroes-of-might-and-magic.jpg/revision/latest?cb=20171221093021',
				'title' => 'Меч и Магия вики',
				'url' => 'http://ru.mightandmagic.wikia.com/wiki/%D0%9C%D0%B5%D1%87_%D0%B8_%D0%9C%D0%B0%D0%B3%D0%B8%D1%8F_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/d9/Clash-of-Clans.jpg/revision/latest?cb=20171221093359',
				'title' => 'Clash of Clans Wiki',
				'url' => 'http://ru.clashofclans.wikia.com/wiki/Clash_of_Clans_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/2f/Zlodei.jpg/revision/latest?cb=20171221093852',
				'title' => 'Злодеи вики',
				'url' => 'http://ru.zlodei.wikia.com/wiki/%D0%97%D0%BB%D0%BE%D0%B4%D0%B5%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b9/Heroes.jpg/revision/latest?cb=20171221094216',
				'title' => 'Герои вики',
				'url' => 'http://ru.protagonist.wikia.com/wiki/%D0%93%D0%B5%D1%80%D0%BE%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/1/17/Dying_light.jpg/revision/latest?cb=20171221094606',
				'title' => 'Dying Light вики',
				'url' => 'http://ru.dyinglight.wikia.com/wiki/Dying_Light:_Good_Night,_Good_Luck!_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plantsvs-zombies/images/2/2a/Yeti_Banner.png/revision/latest?cb=20171230203716&path-prefix=ru',
				'title' => 'Plants vs. Zombies Wiki',
				'url' => 'http://ru.plantsvs-zombies.wikia.com/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/monarchs/images/f/ff/1363168471023.jpg/revision/latest?cb=20171231153508&path-prefix=ru',
				'title' => 'Монархия Вики',
				'url' => 'http://ru.monarchs.wikia.com/wiki/%D0%9C%D0%BE%D0%BD%D0%B0%D1%80%D1%85%D0%B8%D1%8F_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/warriors-cats/images/e/e1/%D0%92%D1%80%D0%B5%D0%BC%D1%8F_%D0%B2%D1%8B%D0%B1%D0%BE%D1%80%D0%B0_%D0%B1%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20180116182212&path-prefix=ru',
				'title' => 'Коты-воители вики',
				'url' => 'http://ru.warriors-cats.wikia.com/wiki/%D0%9A%D0%BE%D1%82%D1%8B-%D0%B2%D0%BE%D0%B8%D1%82%D0%B5%D0%BB%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/life-is-strange/images/3/38/For_banner.jpeg/revision/latest?cb=20180117175617&path-prefix=ru',
				'title' => 'Life is Strange вики',
				'url' => 'http://ru.life-is-strange.wikia.com/wiki/Life_is_Strange_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/guardiansofgahoole/images/c/c2/%D0%A1%D0%BE%D1%80%D0%B5%D0%BD_%D0%BF%D0%BE%D1%81%D1%82%D0%B5%D1%80_%D0%B1%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20180119180451&path-prefix=ru',
				'title' => 'Ночные Стражи Вики',
				'url' => 'http://ru.guardiansofgahoole.wikia.com/wiki/Guardians_of_Ga%27Hoole_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/03/Civ_VI_Rise_Fall.jpg/revision/latest?cb=20180125141413',
				'title' => 'Civilization VI: Rise & Fall',
				'url' => 'http://ru.civilopedia.wikia.com/wiki/Civilization_VI:_Rise_%26_Fall'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/71/Nerf.JPG/revision/latest?cb=20180125141414',
				'title' => 'Nerf вики',
				'url' => 'http://ru.nerf.wikia.com/wiki/Nerf_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/44/Stardew_Valley.jpg/revision/latest?cb=20180125141415',
				'title' => 'Stardew Valley Вики',
				'url' => 'http://ru.stardewvalley.wikia.com/wiki/StardewValley_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/ba/Type-moon.jpg/revision/latest?cb=20180125141416',
				'title' => 'TYPE-MOON Wiki',
				'url' => 'http://ru.typemoon.wikia.com/wiki/TYPE-MOON_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/aa/Overlord_anime.jpg/revision/latest?cb=20180125141415',
				'title' => 'Повелитель Вики',
				'url' => 'http://ru.overlordanime.wikia.com/wiki/%D0%9F%D0%BE%D0%B2%D0%B5%D0%BB%D0%B8%D1%82%D0%B5%D0%BB%D1%8C_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/7a/%D0%A1%D0%B5%D0%BC%D1%8C_%D0%B3%D1%80%D0%B5%D1%85%D0%BE%D0%B2_%D0%B0%D0%BD%D0%B8%D0%BC%D0%B5.jpg/revision/latest?cb=20180125141417',
				'title' => 'Семь смертных грехов вики',
				'url' => 'http://ru.nanatsunotaizai.wikia.com/wiki/%D0%A1%D0%B5%D0%BC%D1%8C_%D1%81%D0%BC%D0%B5%D1%80%D1%82%D0%BD%D1%8B%D1%85_%D0%B3%D1%80%D0%B5%D1%85%D0%BE%D0%B2_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/28/Subnautica.jpg/revision/latest?cb=20180125141416',
				'title' => 'Subnautica вики',
				'url' => 'http://ru.subnautica.wikia.com/wiki/Subnautica_%D0%B2%D0%B8%D0%BA%D0%B8'
			]
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/5/50/One_Piece_Fanon_Spotlight.png/revision/latest?cb=20170420162143',
				'title' => 'One Piece Fanon',
				'url' => 'http://bit.ly/2u3gdsl'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/0/09/Wiki_Cazadores_de_Sombras.png/revision/latest?cb=20170113234553',
				'title' => 'Wiki Shadowhunters en español',
				'url' => 'http://bit.ly/2mpODVP'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/b/b8/Tron.png/revision/latest?cb=20160402195421',
				'title' => 'Wiki Tron',
				'url' => 'http://bit.ly/2nvUiaW'
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
				'url' => 'https://goo.gl/jKuEWF'
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
				'url' => 'https://goo.gl/e9WRKa'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/violet-evergarden/images/2/21/Violet-Evergarden-Header-001-20160527.jpg/revision/latest?cb=20160616112327',
				'title' => '紫羅蘭永恆花園Wiki',
				'url' => 'https://goo.gl/yThbPc'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/legendofzelda/images/7/7c/BotW_Tile.png/revision/latest?cb=20171128141246&path-prefix=zh-tw',
				'title' => '薩爾達傳說Wiki',
				'url' => 'https://goo.gl/k7LFBN'
			]
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
