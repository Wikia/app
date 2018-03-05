<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/evildead/images/2/22/Family.jpeg/revision/latest?cb=20180225133219',
				'title' => 'Evil Dead Wiki',
				'url' => 'http://evildead.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/pacificrim/images/e/ed/Nate_Lambert_%28EMPIRE_Magazine%29-01.jpg/revision/latest?cb=20180125042426',
				'title' => 'Pacific Rim Wiki',
				'url' => 'http://pacificrim.wikia.com/wiki/Pacific_Rim_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/laracroft/images/5/50/Wiki-background/revision/latest?cb=20170924002231',
				'title' => 'Tom Raider Wiki',
				'url' => 'http://tombraider.wikia.com/wiki/Tomb_Raider_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/wrinkle-in-time/images/1/17/Ed06d736-cd9b-4b32-b628-a974802d97c4-awit-11916.jpg/revision/latest?cb=20171201212242',
				'title' => 'A Wrinkle in Time Wiki',
				'url' => 'http://wrinkle-in-time.wikia.com/wiki/Wrinkle_in_Time_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/redsparrow/images/c/ce/Red-sparrow-1.jpg/revision/latest?cb=20180226181940',
				'title' => 'Red Sparrow Wiki',
				'url' => 'http://redsparrow.wikia.com/wiki/Red_Sparrow_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/readyplayerone/images/b/ba/Ready-player-one.jpg/revision/latest?cb=20180208214114',
				'title' => 'Ready Player One Wiki',
				'url' => 'http://readyplayerone.wikia.com/wiki/Ready_Player_One_Wiki'
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
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dumbledoresarmyroleplay/images/1/17/Staircases_in_school_Hogwarts.jpg/revision/latest?cb=20121009182445',
				'title' => 'Dumbledore\'s Army Role Play Wiki',
				'url' => 'http://dumbledoresarmyroleplay.wikia.com/wiki/Dumbledore%27s_Army_Role-Play_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/rodeo-stampede-official/images/7/79/Spotlight16-9.png/revision/latest?cb=20180124064751',
				'title' => 'Rodeo Stampedia',
				'url' => 'http://rodeo-stampede.wikia.com/wiki/Rodeo_Stampedia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elementalacadmeyrp/images/b/b6/Spotlight.jpg/revision/latest?cb=20180129050033',
				'title' => 'The Elemental Academy Roleplay Wiki',
				'url' => 'http://elementalacadmeyrp.wikia.com/wiki/The_Elemental_Academy_Roleplay_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/central/images/d/d6/Level3Rogue2.png/revision/latest?cb=20180226051411',
				'title' => 'Merchant RPG Wiki',
				'url' => 'http://merchantrpg.wikia.com/wiki/Merchant_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/0/0b/FR-SwordArtOnline-Spotlight.jpg/revision/latest/scale-to-width-down/640?cb=20180129165210&path-prefix=fr',
				'title' => 'Wiki Sword Art Online',
				'url' => 'http://fr.sword-art-online.wikia.com/wiki/Wiki_Sword_Art_Online'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/8/89/FR-SevenDeadlySins-Spotlight.jpg/revision/latest?cb=20180129165302&path-prefix=fr',
				'title' => ' Wiki Seven Deadly Sins',
				'url' => 'http://fr.seven-deadly-sins.wikia.com/wiki/Wiki_Seven_Deadly_Sins'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/2/2c/FR-Subnautica-Spotlight.jpg/revision/latest?cb=20180228101053&path-prefix=fr',
				'title' => 'Wiki Subnautica',
				'url' => 'http://fr.subnautica.wikia.com/wiki/Wikia_Subnautica'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/6/63/FR-Stargate-Spotlight.jpg/revision/latest?cb=20180228101053&path-prefix=fr',
				'title' => 'Wiki Stargate',
				'url' => 'http://fr.stargate.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/8/82/FR-Kirby-Spotlight2.jpg/revision/latest?cb=20180228101052&path-prefix=fr',
				'title' => 'Wiki Kirby',
				'url' => 'http://fr.kirby.wikia.com/wiki/Kirby_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/4/4f/FR-AgeOfEmpires-Spotlight.jpg/revision/latest?cb=20180228101054&path-prefix=fr',
				'title' => 'Wiki Age of Empires',
				'url' => 'http://fr.ageofempires.wikia.com/wiki/Wiki_Age_of_Empires'
			]
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/d2/Jessica_Jones_Spotlight.jpg/revision/latest?cb=20180228160654&path-prefix=de',
				'title' => 'The Defenders Wiki',
				'url' => 'http://de.the-defenders.wikia.com/wiki/The_Defenders_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/e/e0/Tomb_Raider_2018_Spotlight.jpg/revision/latest?cb=20180228164144&path-prefix=de',
				'title' => 'Tomb Raider Wiki',
				'url' => 'http://de.tombraider.wikia.com/wiki/Tomb_Raider_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/c2/Fear_the_Walking_Dead_Spotlight.jpg/revision/latest?cb=20180228165826&path-prefix=de',
				'title' => 'The Walking Dead Wiki',
				'url' => 'http://de.thewalkingdeadtv.wikia.com/wiki/The_Walking_Dead_(TV)_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/3e/Lucifer_Season_3_Spotlight.jpg/revision/latest?cb=20180228170424&path-prefix=de',
				'title' => 'Lucifer Wiki',
				'url' => 'http://de.lucifer.wikia.com/wiki/Lucifer_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/7/75/Stargate_Origins_Spotlight.jpg/revision/latest?cb=20180228171958&path-prefix=de',
				'title' => 'Stargate Wiki',
				'url' => 'http://de.stargate.wikia.com/wiki/Stargate_SG-1_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/4/44/Shadowhunters_Spotlight.jpg/revision/latest?cb=20180228172418&path-prefix=de',
				'title' => 'Shadowhunters Wiki',
				'url' => 'http://de.shadowhunterstv.wikia.com/wiki/Shadowhunterstv_Wiki'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/db/Subnautica_Spotlight.jpg/revision/latest?cb=20171023143728&path-prefix=de',
				'title' => 'Subnautica Wiki',
				'url' => 'http://de.subnautica.wikia.com/wiki/Subnautica_Wikia'
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
			],
		],
		'ru' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a6/Fallout_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'Убежище',
				'url' => 'http://ru.fallout.wikia.com/wiki/Fallout_Wiki'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/civ/images/e/e2/%D0%93%D0%B8%D0%BB%D1%8C%D0%B3%D0%B0%D0%BC%D0%B5%D1%88_Civ6.jpg/revision/latest?cb=20171226081350&path-prefix=ru',
				'title' => 'Цивилопедия',
				'url' => 'http://ru.civilopedia.wikia.com/wiki/Civilization_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/71/Nerf.JPG/revision/latest?cb=20180125141414',
				'title' => 'Nerf вики',
				'url' => 'http://ru.nerf.wikia.com/wiki/Nerf_%D0%B2%D0%B8%D0%BA%D0%B8'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/civ/images/e/e2/%D0%93%D0%B8%D0%BB%D1%8C%D0%B3%D0%B0%D0%BC%D0%B5%D1%88_Civ6.jpg/revision/latest?cb=20171226081350&path-prefix=ru',
				'title' => 'Цивилопедия',
				'url' => 'http://ru.civilopedia.wikia.com/wiki/Civilization_Wiki'
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
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/b/b5/Arte_de_la_wiki.jpg/revision/latest?cb=20180228225933',
				'title' => 'Walhalla Krieg',
				'url' => 'http://bit.ly/2HTexZv'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/3/30/Season_2_Promotion_Poster.png/revision/latest?cb=20180219004137',
				'title' => 'Shokugeki no Soma',
				'url' => 'http://bit.ly/2F51IK0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/1/1f/Spotlight_%28Kirbypedia%29.jpg/revision/latest?cb=20180226141624',
				'title' => 'Kirbypedia',
				'url' => 'http://bit.ly/2t2M14t'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/b/b4/Re_Zero_-_Spotlight.png/revision/latest?cb=20180210023101',
				'title' => 'Wiki Re:Zero',
				'url' => 'http://bit.ly/2dVVtyn'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/5/50/One_Piece_Fanon_Spotlight.png/revision/latest?cb=20170420162143',
				'title' => 'One Piece Fanon',
				'url' => 'http://bit.ly/2u3gdsl'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/0/09/Wiki_Cazadores_de_Sombras.png/revision/latest?cb=20170113234553',
				'title' => 'Cazadores de Sombras Wiki',
				'url' => 'http://bit.ly/2mpODVP'
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
