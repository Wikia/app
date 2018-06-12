<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/tardis/images/9/9f/Bus_advert.jpg/revision/latest?cb=20180520222646',
				'title' => 'Doctor Who Wiki',
				'url' => 'http://tardis.wikia.com/wiki/Doctor_Who_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/cloverfield/images/3/37/10_cloverfield_lane.jpg/revision/latest?cb=20161209010930',
				'title' => 'Cloverfield Wiki',
				'url' => 'http://cloverfield.wikia.com/wiki/Cloverfield_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bighero6/images/a/a8/Wasabi_Testing_Apple.png/revision/latest?cb=20180314001947',
				'title' => 'Big Hero 6 Wiki',
				'url' => 'http://bighero6.wikia.com/wiki/Big_Hero_6_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/onepunchman/images/2/2b/Saitama_Garou.png/revision/latest?cb=20180327215233',
				'title' => 'One Punch Man Wiki',
				'url' => 'http://onepunchman.wikia.com/wiki/One-Punch_Man_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kingdomhearts/images/c/c9/Mickey_and_Friends_at_the_Great_Maw_%28KHIIFM%29_KHIIHD.png/revision/latest?cb=20140704182930',
				'title' => 'Kingdom Hearts Wiki',
				'url' => 'http://kingdomhearts.wikia.com/wiki/The_Keyhole'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/megaman/images/4/44/X4_03_078%2B079.jpg/revision/latest?cb=20180507135036',
				'title' => 'Mega Man Wiki',
				'url' => 'http://megaman.wikia.com/wiki/Mega_Man_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/wowsb/images/3/3b/De_Grasse_SS2.jpg/revision/latest?cb=20180430053310',
				'title' => 'World of Warships Blitz Wiki',
				'url' => 'http://wowsb.wikia.com/wiki/WoWSB'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/miitopia-fanon/images/9/99/Sprinkles.png/revision/latest?cb=20180523052623',
				'title' => 'Miitopia Fanon',
				'url' => 'http://miitopia-fanon.wikia.com/wiki/Miitopia_Fanon_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/studio-ghibli/images/b/be/Totoro_-_Spotlight.png/revision/latest?cb=20180530022514',
				'title' => 'Studio Ghibli',
				'url' => 'http://studio-ghibli.wikia.com/wiki/Studio_Ghibli_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/projectsalt/images/5/50/Wiki-background/revision/latest?cb=20180309223129',
				'title' => 'Salt Wiki',
				'url' => 'http://projectsalt.wikia.com/wiki/ProjectSalt_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/parahumans/images/3/36/Spotlight_Worm.jpg/revision/latest?cb=20180530142938',
				'title' => 'Worm Wiki',
				'url' => 'https://worm.wikia.com/wiki/Worm_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/d/d1/FR-13ReasonsWhy-Spotlight.jpg/revision/latest?cb=20180528104240&path-prefix=fr',
				'title' => 'Wiki 13 Reasons Why',
				'url' => 'http://fr.13reasonswhy.wikia.com/wiki/Wiki_13_Reasons_Why'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/f/f8/FR-Overwatch-Spotlight.jpg/revision/latest?cb=20180528104241&path-prefix=fr',
				'title' => 'Wiki Overwatch',
				'url' => 'http://fr.overwatch.wikia.com/wiki/Wiki_Overwatch'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/1/11/Marvel_Strike_Force_Spotlight.png/revision/latest?cb=20180427093415&path-prefix=de',
				'title' => 'Wiki Marvel Strike Force',
				'url' => 'http://fr.marvel-strike-force.wikia.com/wiki/Wiki_Marvel_Strike_Force'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/3/30/FR-MiraculousLadybug-Spotlight.jpg/revision/latest?cb=20180528104241&path-prefix=fr',
				'title' => 'Wiki Miraculous Ladybug',
				'url' => 'http://fr.miraculousladybug.wikia.com/wiki/Wikia_Miraculous_Ladybug'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/c/c2/FR-Deadpool-Spotlight.jpg/revision/latest?cb=20180528104239&path-prefix=fr',
				'title' => 'Wiki X-Men',
				'url' => 'http://fr.xmen.wikia.com/wiki/Wiki_X-Men_First_Class'
			],
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/you-are-wanted/images/7/75/Staffel_2_Slider.jpg/revision/latest/scale-to-width-down/670?cb=20180423133005&path-prefix=de',
				'title' => 'You Are Wanted Wiki',
				'url' => 'http://de.you-are-wanted.wikia.com/wiki/You_Are_Wanted_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/unbreakable-kimmy-schmidt/images/7/78/Kimmy_Schmidt_Slider.jpg/revision/latest?cb=20180510120150&path-prefix=de',
				'title' => 'Unbreakable Kimmy Schmidt Wiki',
				'url' => 'http://de.unbreakable-kimmy-schmidt.wikia.com/wiki/Unbreakable_Kimmy_Schmidt_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/df/Jurassic_World_2_Spotlight.jpg/revision/latest?cb=20180525085620&path-prefix=de',
				'title' => 'Jurassic Park Wiki',
				'url' => 'http://de.jurassicpark.wikia.com/wiki/Jurassic_Park_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/tote-madchen-lugen-nicht/images/a/a1/2x03_2.jpg/revision/latest?cb=20180508084545&path-prefix=de',
				'title' => 'Tote Mädchen lügen nicht Wiki',
				'url' => 'https://tote-maedchen-luegen-nicht.wikia.com/wiki/Tote_M%C3%A4dchen_l%C3%BCgen_nicht_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/avengers/images/a/a4/Deadpool_2_Wp.jpg/revision/latest?cb=20180422162203&path-prefix=de',
				'title' => 'Marvel-Filme Wiki',
				'url' => 'http://de.marvel-filme.wikia.com/wiki/Marvel-Filme'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/b6/Solo_Spotlight.png/revision/latest?cb=20180427090928&path-prefix=de',
				'title' => 'Jedipedia',
				'url' => 'https://jedipedia.wikia.com/wiki/Jedipedia:Hauptseite'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/3c/Tsubasa_Wiki.jpg/revision/latest?cb=20180427091239&path-prefix=de',
				'title' => 'Tsubasa Wiki',
				'url' => 'http://de.tsubasa.wikia.com/wiki/Captain_Tsubasa_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/b5/Greys_Anatomy_Spotlight.png/revision/latest?cb=20180427091600&path-prefix=de',
				'title' => 'Grey\'s Anatomy Wiki',
				'url' => 'http://de.greysanatomy.wikia.com/wiki/Grey%27s_Anatomy_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/5/56/New_Girl_Spotlight.jpg/revision/latest?cb=20180427092034&path-prefix=de',
				'title' => 'New Girl Wiki',
				'url' => 'http://de.newgirl.wikia.com/wiki/New_Girl_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/magi/images/1/1a/Mogiana.vorgestellter.charakter.png/revision/latest?cb=20160427164938&path-prefix=de',
				'title' => 'Magi Wiki',
				'url' => 'http://de.magi.wikia.com/wiki/Magi_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/7/71/Fairy_Tail_Spotlight.png/revision/latest?cb=20180525094211&path-prefix=de',
				'title' => 'Fairy Tail Wiki',
				'url' => 'http://de.fairytail.wikia.com/wiki/Fairy_Tail:Willkommen'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/c9/Haus_des_Geldes_Spotlight.png/revision/latest?cb=20180427092547&path-prefix=de',
				'title' => 'Haus des Geldes Wiki',
				'url' => 'https://haus-des-geldes.wikia.com/wiki/Haus_des_Geldes_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/8/8d/Westworld_Season_2_Spotlight.png/revision/latest?cb=20180427093001&path-prefix=de',
				'title' => 'Westworld Wiki',
				'url' => 'http://de.westworld.wikia.com/wiki/Westworld_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/1/11/Marvel_Strike_Force_Spotlight.png/revision/latest?cb=20180427093415&path-prefix=de',
				'title' => 'Marvel Strike Force Wiki',
				'url' => 'http://de.marvel-strike-force.wikia.com/wiki/Marvel_Strike_Force_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/1/11/Marvel_Strike_Force_Spotlight.png/revision/latest?cb=20180427093415&path-prefix=de',
				'title' => 'State of Decay Wiki',
				'url' => 'http://de.stateofdecay.wikia.com/wiki/State_of_Decay_Wiki'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/f/fc/Vampyr_Spotlight.png/revision/latest?cb=20180525135811&path-prefix=de',
				'title' => 'Vampyr Wiki',
				'url' => 'http://de.vampyr.wikia.com/wiki/Vampyr-Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/detroit-become-human/images/5/50/Connor7.jpg/revision/latest?cb=20170830142846&path-prefix=de',
				'title' => 'Detroit: Become Human Wiki',
				'url' => 'http://de.detroit-become-human.wikia.com/wiki/Detroit:_Become_Human_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/03/Pillars_of_Eternity_II_Deadfire_Spotlight.jpg/revision/latest?cb=20180228144059&path-prefix=de',
				'title' => 'Pillars of Eternity Wiki',
				'url' => 'http://de.pillarsofeternity.wikia.com/wiki/Pillars_of_Eternity_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ebfecc9a-0585-444e-8abe-c83d56dad824/',
				'title' => 'Frostpunk Wiki',
				'url' => 'http://de.frostpunk.wikia.com/wiki/Frostpunk_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/2cc8919c-fd51-4c02-9ff9-9d5732cc6b6e',
				'title' => 'Dark Souls Wiki',
				'url' => 'http://de.darksouls.wikia.com/wiki/Dark_Souls_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/db/BattleTech_Spotlight.png/revision/latest?cb=20180525094916&path-prefix=de',
				'title' => 'BattleTech Wiki',
				'url' => 'http://de.battletech.wikia.com/wiki/BattleTech_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/8/8e/Drachen_Wiki_Spotlight.jpg/revision/latest?cb=20180427095500&path-prefix=de',
				'title' => 'Drachen Wiki',
				'url' => 'http://de.drachen.wikia.com/wiki/Drachen_Wiki'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/cuphead/images/e/e1/CupheadBannerContract.png/revision/latest?cb=20180520175319&path-prefix=ru',
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
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kel/images/d/df/%D0%A1%D0%B8%D1%8F%D1%8E%D1%89%D0%B5%D0%B5_%D0%BE%D0%BA%D0%BE.png/revision/latest?cb=20180314110857&path-prefix=ru',
				'title' => 'Kelconf вики',
				'url' => 'http://bit.ly/ru-spotlight-kelconf'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/angrybirds/images/8/85/Piggy_Tales_4th_Street_png.png/revision/latest?cb=20180427154359&path-prefix=ru',
				'title' => 'Angry Birds Wiki',
				'url' => 'http://bit.ly/ru-spotlight-angrybirds'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kirby/images/a/a4/KirbyBanner.jpg/revision/latest?cb=20180512060811&path-prefix=ru',
				'title' => 'Кирби вики',
				'url' => 'http://bit.ly/ru-spotlight-kirby'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/brickipedia/images/0/04/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_06-07.2018.jpg/revision/latest?cb=20180520141544&path-prefix=ru',
				'title' => 'Legopedia',
				'url' => 'http://bit.ly/ru-spotlight-lego'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plantsvs-zombies/images/d/d3/BWBbanner1.png/revision/latest?cb=20180520175450&path-prefix=ru',
				'title' => 'Plants vs. Zombies Wiki',
				'url' => 'http://bit.ly/ru-spotlight-plantsvszombies'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/d7/Jurassic_World_2.jpg/revision/latest?cb=20180523132638',
				'title' => 'Мир Юрского периода 2',
				'url' => 'http://bit.ly/ru-spotlight-jurassicworld'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/2d/Pillars_of_eternity_2.jpg/revision/latest?cb=20180523132638',
				'title' => 'Pillars of Eternity 2',
				'url' => 'http://bit.ly/ru-spotlight-pillarsofeternity'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/6b/Conan_Exiles.jpg/revision/latest?cb=20180523132637',
				'title' => 'Conan Exiles',
				'url' => 'http://bit.ly/ru-spotlight-conanexiles'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a3/Shaman_King.jpg/revision/latest?cb=20180523132639',
				'title' => 'Shaman King Вики',
				'url' => 'http://bit.ly/ru-spotlight-shamanking'
			]
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/6/69/Spotlight_DITF.jpg/revision/latest?cb=20180502010925',
				'title' => 'DARLING in the FRANXX Wiki',
				'url' => 'http://bit.ly/2LdHYqf'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/f/fb/Amanecer_Rojo.png/revision/latest?cb=20180506042041',
				'title' => 'Amanecer Rojo Wiki',
				'url' => 'http://bit.ly/2L7nqj1'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/6/68/Animal_Crossing_Enciclopedia.jpg/revision/latest?cb=20180418150605',
				'title' => 'Animal Crossing Enciclopedia',
				'url' => 'http://bit.ly/2kF2PqW'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kings-raid/images/e/e6/KINGRAID.jpg/revision/latest?cb=20180422060120&path-prefix=zh-tw',
				'title' => '王之逆襲維基',
				'url' => 'http://zh-tw.kings-raid.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/tenka-hyakken/images/a/a6/Header.png/revision/latest?cb=20170429000748&path-prefix=zh',
				'title' => '天華百劍-斬 Wiki',
				'url' => 'http://zh.tenka-hyakken.wikia.com'
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
