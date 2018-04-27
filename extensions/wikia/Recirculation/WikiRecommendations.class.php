<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/the-resident/images/e/e1/The_Resident_-_Episode_1.02_%2822%29.jpg/revision/latest?cb=20180208151304',
				'title' => 'The Resident Wiki',
				'url' => 'http://the-resident.wikia.com/wiki/The_Resident_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/erwikia/images/5/5e/Match_made_in_heaven.jpg/revision/latest?cb=20180405181443',
				'title' => 'ER Wiki',
				'url' => 'http://er.wikia.com/wiki/ER_wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ducktales2017/images/4/4d/DuckTales-2017-11.png/revision/latest?cb=20170325001051',
				'title' => 'Ducktales Wiki',
				'url' => 'http://ducktales.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/legiontv/images/f/fd/Season_2_screenshot_%281%29.jpg/revision/latest?cb=20180308043013',
				'title' => 'Legion Wiki',
				'url' => 'http://legion.wikia.com/wiki/Legion_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/acourtofthornsandroses/images/9/96/Ce85fb20f51b18d763cbe3a367de89c6.jpg/revision/latest?cb=20180204181608',
				'title' => 'A Court of Thorns and Roses Wiki',
				'url' => 'http://acourtofthornsandroses.wikia.com/wiki/A_Court_of_Thorns_and_Roses_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fairytail/images/7/70/What_You_Are_DCEnding.png/revision/latest?cb=20171127140806',
				'title' => 'Fairy Tail Wiki',
				'url' => 'http://fairytail.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/stine/images/a/ac/Webp.net-resizeimage.jpg/revision/latest?cb=20180327120703',
				'title' => 'R. L. Stine Wiki',
				'url' => 'http://stine.wikia.com/wiki/R.L._Stine_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/forgeofempires/images/e/e7/FoE_2015_Logo_Big.png/revision/latest?cb=20151110181010',
				'title' => 'Forge of Empires Wiki',
				'url' => 'http://forgeofempires.wikia.com/wiki/Forge_of_Empires_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/thezaynmalik/images/6/62/Zayn-let-me-video-thatgrapejuice-600x268.jpg/revision/latest?cb=20180416015214',
				'title' => 'ZAYN Wiki',
				'url' => 'http://zayn.wikia.com/wiki/ZAYN_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/deltora/images/0/0e/Community-header-background/revision/latest?cb=20171201035358',
				'title' => 'Deltora Quest Wiki',
				'url' => 'http://deltoraquest.wikia.com/wiki/Deltora_Quest_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/inkagames-english/images/5/52/Grandpa_SSG.png/revision/latest?cb=20180409114327',
				'title' => 'Inkagames English Wiki',
				'url' => 'http://inkagames-english.wikia.com/wiki/Inkagames_English_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bakugan/images/d/d1/Battle_brawlers.PNG/revision/latest?cb=20111216130203',
				'title' => 'Bakugan Wiki',
				'url' => 'http://bakugan.wikia.com/wiki/Bakugan_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/21/Infinity_War_Spotlight.jpg/revision/latest?cb=20180329092936&path-prefix=de',
				'title' => 'Wiki Univers Cinématographique Marvel',
				'url' => 'http://fr.universcinematographiquemarvel.wikia.com/wiki/Wikia_Marvel_Studios'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/3/35/FR-LaCasaDePapel-Spotlight.jpg/revision/latest?cb=20180426125602&path-prefix=fr',
				'title' => 'Wiki La Casa de papel',
				'url' => 'http://fr.la-casa-de-papel.wikia.com/wiki/Wiki_La_Casa_de_Papel'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/4/40/Far_Cry_5_Spotlight.jpg/revision/latest?cb=20180228131517&path-prefix=de',
				'title' => 'Wiki Far Cry',
				'url' => 'http://fr.far-cry.wikia.com/wiki/Wiki_Far_Cry'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/4/45/FR-LostInSpace-Spotlight.jpg/revision/latest?cb=20180426125843&path-prefix=fr',
				'title' => 'Wiki Perdus dans l\'espace',
				'url' => 'http://fr.perdus-dans-lespace.wikia.com/wiki/Wiki_Perdus_dans_l%27espace'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/c/cb/FR-Solo-Spotlight.jpg/revision/latest?cb=20180426125601&path-prefix=fr',
				'title' => 'Wiki Star Wars',
				'url' => 'http://fr.starwars.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/4/43/FR-DarkSouls-Spotlight.jpg/revision/latest?cb=20180426125604&path-prefix=fr',
				'title' => 'Wiki Dark Souls',
				'url' => 'http://fr.dark-souls.wikia.com/wiki/Wiki_Dark_Souls'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/7/7c/FR-The100-Spotlight.jpg/revision/latest?cb=20180426125603&path-prefix=fr',
				'title' => 'Wiki The 100',
				'url' => 'http://fr.the100.wikia.com/wiki/Wiki_The_100'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/farcry5/images/5/5f/%E3%83%91%E3%83%83%E3%82%B1%E3%83%BC%E3%82%B8%E3%83%87%E3%82%B6%E3%82%A4%E3%83%B3_Farcry5.jpg/revision/latest?cb=20180116060949&path-prefix=ja',
				'title' => 'ファークライ5 Wiki',
				'url' => 'http://ja.farcry5.wikia.com'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a3/TES_Summerset.jpg/revision/latest?cb=20180424104907',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://bit.ly/teswiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/6d/Dark_Souls_remastered.jpg/revision/latest?cb=20180424104904',
				'title' => 'Dark Souls вики',
				'url' => 'http://bit.ly/ru-spotlight-darksouls-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/2c/Far_Cry_5.jpg/revision/latest?cb=20180322084609',
				'title' => 'Far Cry Wiki',
				'url' => 'http://bit.ly/ru-spotlight-farcry-april'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/61/The_100_season_5.jpg/revision/latest?cb=20180424104907',
				'title' => 'Сотня вики',
				'url' => 'http://bit.ly/ru-spotlight-the100-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/3/33/Smeshariki-Dezha-vu.jpg/revision/latest?cb=20180322084614',
				'title' => 'Смешарики. Дежавю',
				'url' => 'http://bit.ly/ru-spotlight-smesh-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/dc/Winx.jpg/revision/latest?cb=20180322084615',
				'title' => 'Винксопедия',
				'url' => 'http://bit.ly/ru-spotlight-winx-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/overwatch/images/9/9c/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20180402153434&path-prefix=ru',
				'title' => 'Overwatch вики',
				'url' => 'http://bit.ly/ru-spotlight-overwatch-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/49/Tokyo_Ghoul.jpg/revision/latest?cb=20180322084615',
				'title' => 'Tokyo Ghoul:re',
				'url' => 'http://bit.ly/ru-spotlight-tokyoghoul-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/gravityfallsrp/images/6/68/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_%D0%93%D0%A4%D0%A4_2.jpg/revision/latest?cb=20180213085730&path-prefix=ru',
				'title' => 'Гравити Фолз Фанон Вики',
				'url' => 'http://bit.ly/ru-spotlight-gravityfallsfanon'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/star-and-the-forces-of-evil/images/7/74/S3E27_Star_Butterfly_with_her_hair_braided.png/revision/latest?cb=20180307015001',
				'title' => 'Стар против Сил Зла Вики',
				'url' => 'http://bit.ly/ru-spotlight-starvsforceofevil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hello-bob/images/d/d2/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.PNG/revision/latest?cb=20180402174930&path-prefix=ru',
				'title' => 'Знакомьтесь, Боб вики',
				'url' => 'http://bit.ly/ru-spotlight-hellobob'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/swfanon/images/f/f3/AllNewBanner.jpg/revision/latest?cb=20180403003831&path-prefix=ru',
				'title' => 'Star Wars Фанон',
				'url' => 'http://bit.ly/ru-spotlight-swfanon'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/cuphead/images/9/95/Cuphead_Banner.png/revision/latest?cb=20180407185829&path-prefix=ru',
				'title' => 'Cuphead вики',
				'url' => 'http://bit.ly/ru-spotlight-cuphead'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/blackclover/images/c/c6/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.png/revision/latest?cb=20180409211011&path-prefix=ru',
				'title' => 'Чёрный Клевер Вики',
				'url' => 'http://bit.ly/ru-spotlight-blackclover'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/igromania/images/7/74/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_%D0%BC%D0%B0%D0%B9-%D0%B8%D1%8E%D0%BD%D1%8C_18.jpg/revision/latest?cb=20180420073555&path-prefix=ru',
				'title' => 'ИгроВики',
				'url' => 'http://bit.ly/ru-spotlight-igrowiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b6/Nintendo_games.jpg/revision/latest?cb=20180424104905',
				'title' => 'Nintendo Wiki',
				'url' => 'http://bit.ly/ru-spotlight-nintendo'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/1/1a/Avengers_Infinity_war.jpg/revision/latest?cb=20180424104903',
				'title' => 'Мстители: Война Бесконечности',
				'url' => 'http://bit.ly/ru-spotlight-avengers-infinitywar'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/9/91/Solo_star_wars.jpg/revision/latest?cb=20180424104906',
				'title' => 'Хан Соло. Звёздные войны',
				'url' => 'http://bit.ly/ru-spotlight-solo-starwars'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/8/86/God_of_war_2018.jpg/revision/latest?cb=20180424104904',
				'title' => 'God of War',
				'url' => 'http://bit.ly/ru-spotlight-god-of-war'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/5/51/State_of_decay.jpg/revision/latest?cb=20180424104906',
				'title' => 'State Of Decay Wiki',
				'url' => 'http://bit.ly/ru-spotlight-stateofdecay'
			]
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/6/6c/Portada1.jpg/revision/latest?cb=20180323154306',
				'title' => 'Steven Universe Fanon',
				'url' => 'http://bit.ly/2c54Ubr'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/5/5d/Marvel_Fanon_Wiki_II.png/revision/latest?cb=20180416061856',
				'title' => 'Marvel Fanon Wiki',
				'url' => 'http://bit.ly/2efKVsl'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/6/62/45f85506b4b137687eed2436284fa7ce.jpeg/revision/latest?cb=20180422202753',
				'title' => 'Happy Tree Friends Wiki',
				'url' => 'http://bit.ly/2r2k9sC'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/marvel/images/4/4f/%E5%BE%A9%E4%BB%87%E8%80%853.jpg/revision/latest?cb=20180417130828&path-prefix=zh',
				'title' => 'Marvel維基',
				'url' => 'http://zh.marvel.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/legendofzelda/images/7/7c/BotW_Tile.png/revision/latest?cb=20171128141246&path-prefix=zh-tw',
				'title' => '薩爾達傳說Wiki',
				'url' => 'http://zh-tw.legendofzelda.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/lobotomycorp/images/d/d5/Wikibanner.png/revision/latest?cb=20171212043320&path-prefix=zh',
				'title' => '脑叶公司维基',
				'url' => 'http://zh.lobotomycorp.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/pacificrim/images/b/b5/20180326-112617_U3792_M395231_5850.jpg/revision/latest?cb=20180401105122&path-prefix=zh',
				'title' => '環太平洋Wiki',
				'url' => 'http://zh.pacificrim.wikia.com'
			],
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

		if ( $wgWikiaEnvironment === WIKIA_ENV_DEV ) {
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
