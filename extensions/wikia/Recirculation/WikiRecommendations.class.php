<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/the-crown/images/e/e1/106public.jpeg/revision/latest?cb=20170814204901',
				'title' => 'The Crown Wiki',
				'url' => 'http://the-crown.wikia.com/wiki/The_Crown_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/pitch-perfect/images/0/0a/World_championship.jpg/revision/latest?cb=20150525201210',
				'title' => 'Pitch Perfect Wiki',
				'url' => 'http://pitch-perfect.wikia.com/wiki/Pitch_Perfect_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/lady-bug/images/b/b8/The_Mime_1528.png/revision/latest?cb=20171017032708',
				'title' => 'Miraculous Ladybug Wiki',
				'url' => 'http://miraculousladybug.wikia.com/wiki/Miraculous_Ladybug_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/janethevirgin/images/d/d8/70familia.jpeg/revision/latest?cb=20171117172616',
				'title' => 'Jane the Virgin Wiki',
				'url' => 'http://janethevirgin.wikia.com/wiki/Jane_the_Virgin_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/zelda/images/c/c1/Promotional_Art_%28The_Legend_of_Zelda_Wii_U%29.jpg/revision/latest?cb=20160613151743',
				'title' => 'Legend of Zelda Wiki',
				'url' => 'http://zelda.wikia.com/wiki/Zeldapedia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/destinypedia/images/5/5a/D2_titan_gear_02.jpg/revision/latest?cb=20170531052426',
				'title' => 'Destiny Wiki',
				'url' => 'http://destiny.wikia.com/wiki/Destiny_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/merrystartest/images/8/86/DoctorWhoSpotlight.jpg/revision/latest?cb=20171031023604',
				'title' => 'Doctor Who Collectors Wiki',
				'url' => 'http://doctor-who-collectors.wikia.com/wiki/Doctor_Who_Collectors_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/central/images/6/67/LMS2.jpg/revision/latest?cb=20170517125302',
				'title' => 'Lego Marvel and DC Superheroes Wiki',
				'url' => 'http://legomarveldc.wikia.com/wiki/Lego_Marvel_and_DC_Superheroes_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/thedescendants/images/6/6c/Descendants-2-Still-7.png/revision/latest?cb=20170503220546',
				'title' => 'Descendants Wiki',
				'url' => 'http://descendants.wikia.com/wiki/Descendants_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/karlacamilacabello/images/2/2d/Camila_in_London_UK_SL.jpg/revision/latest?cb=20171122020203',
				'title' => 'Camila Cabello Wiki',
				'url' => 'http://camilacabello.wikia.com/wiki/Camila_Cabello_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fablehaven/images/2/2a/GripoftheShadowPlague-CroppedCover.jpg/revision/latest?cb=20170627145330',
				'title' => 'Fablehaven Wiki',
				'url' => 'http://fablehaven.wikia.com/wiki/Fablehaven_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/central/images/2/20/Puroresu_System_Wiki_Banner.jpg/revision/latest?cb=20171002224331',
				'title' => 'Puroresu System Wikia',
				'url' => 'http://puroresusystem.wikia.com/wiki/PuroresuSystem_Wikia'
			]
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/9/93/The-punisher-netflix-2017.jpg/revision/latest?cb=20171130180222&path-prefix=de',
				'title' => 'The Defenders Wiki',
				'url' => 'http://de.the-defenders.wikia.com/wiki/The_Defenders_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dark/images/e/ea/Dark_Slider.png/revision/latest/scale-to-width-down/670?cb=20171114182520&path-prefix=de',
				'title' => 'Dark Wiki',
				'url' => 'http://de.dark.wikia.com/wiki/Dark_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/5/5f/Star-wars-the-last-jedi-rey_2794981.jpg/revision/latest?cb=20171130180958&path-prefix=de',
				'title' => 'Jedipedia',
				'url' => 'http://jedipedia.wikia.com/wiki/Jedipedia:Hauptseite'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/2e/Chris-sowder-53992.png/revision/latest?cb=20171130181457&path-prefix=de',
				'title' => 'Weihnachts-Wiki',
				'url' => 'http://weihnachten.wikia.com/wiki/Weihnachts-Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/disney/images/f/f1/Coco_Migel_spielt_Gitarre.jpg/revision/latest?cb=20171130160754&path-prefix=de',
				'title' => 'Disney Wiki',
				'url' => 'http://de.disney.wikia.com/wiki/Disney_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/cb/Marvels-runaways.jpg/revision/latest?cb=20171130181820&path-prefix=de',
				'title' => 'Marvel-Filme Wiki',
				'url' => 'http://de.marvel-filme.wikia.com/wiki/Marvel-Filme'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/9/9d/1_Animal_Crossing_Pocket_Camp_Illustration_SMDP_ZAC_WWillu02_01_R_ad-0.jpg/revision/latest?cb=20171130182559&path-prefix=de',
				'title' => 'Animal Crossing Wiki',
				'url' => 'http://de.animalcrossing.wikia.com/wiki/Animal_Crossing_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spellforce/images/4/4c/SpellForce_3_Slider.jpg/revision/latest/scale-to-width-down/670?cb=20171122111342&path-prefix=de',
				'title' => 'SpellForce Wiki',
				'url' => 'http://de.spellforce.wikia.com/wiki/SpellForce_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/8/89/Destiny_2_Osiris.jpg/revision/latest?cb=20171130183425&path-prefix=de',
				'title' => 'Destiny Wiki',
				'url' => 'http://de.destiny.wikia.com/wiki/Destiny_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/deponia/images/b/b0/Chaos_auf_Deponia_Screenshot_09.jpg/revision/latest?cb=20131022163649&path-prefix=de',
				'title' => 'Deponia Wiki',
				'url' => 'http://de.deponia.wikia.com/wiki/Deponia_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/layton/images/a/a3/Catoli_Pose_1.png/revision/latest?cb=20160727150527&path-prefix=de',
				'title' => 'Layton Wiki',
				'url' => 'de.layton.wikia.com/wiki/Hauptseite'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/monsterhunternews/images/0/00/Monster_Hunter_World_-_Slider.jpg/revision/latest/scale-to-width-down/670?cb=20170825122405&path-prefix=de',
				'title' => 'Monster Hunter Wiki',
				'url' => 'http://de.monsterhunter.wikia.com/wiki/Monster_Hunter_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/1/1f/FR-MyHeroAcademia-Spotlight.jpg/revision/latest?cb=20171122162235&path-prefix=fr',
				'title' => 'Wiki Boku no Hero Academia',
				'url' => 'http://fr.bokunoheroacademia.wikia.com/wiki/Wiki_Boku_no_Hero_Academia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/a/ae/FR-NFS-Spotlight.jpg/revision/latest?cb=20171122162233&path-prefix=fr',
				'title' => 'Wiki Need for Speed',
				'url' => 'http://fr.needforspeed.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/d/d0/FR-StarWars-Spotlight.jpg/revision/latest?cb=20171122162235&path-prefix=fr',
				'title' => 'Star Wars Wiki',
				'url' => 'http://fr.starwars.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/b/be/FR-Mario-Spotlight.jpg/revision/latest?cb=20171122162235&path-prefix=fr',
				'title' => 'Wiki Mario',
				'url' => 'http://fr.mario.wikia.com/wiki/Wiki_Mario'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/4/48/FR-FoodWars-Spotlight.jpg/revision/latest?cb=20171122162234&path-prefix=fr',
				'title' => 'Wiki Shokugeki no Soma',
				'url' => 'http://fr.shokugekinosoma.wikia.com/wiki/Wiki_Shokugeki_no_soma'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/9/95/FR-LEGO-Spotlight.jpg/revision/latest?cb=20171123171755&path-prefix=fr',
				'title' => 'Wiki Lego',
				'url' => 'http://fr.lego.wikia.com/wiki/Wiki_LEGO'
			],
			[
				'thumbnailUrl' => 'vignette.wikia.nocookie.net/frwikia/images/0/09/1493123130-257-card.jpg/revision/latest?cb=20171107185704',
				'title' => 'Wiki Resident Evil',
				'url' => 'http://fr.residentevil.wikia.com/wiki/Wiki_Resident_Evil'
			]
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/7/75/Wiki_Lalaloopsy_propuesta_spotlight.png/revision/latest?cb=20171111030839',
				'title' => 'Wiki Lalaloopsy',
				'url' => 'http://bit.ly/2jws65U'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/d/dc/7-_Burgers.png/revision/latest?cb=20160105231553',
				'title' => 'Wiki Clarence',
				'url' => 'http://bit.ly/2BxmzUE'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/b/bc/Luxo_jr.png/revision/latest?cb=20171129231432',
				'title' => 'Pixar Wiki',
				'url' => 'http://bit.ly/2j34uq2'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/b/ba/CV_Spotlight.jpg/revision/latest?cb=20171129232651',
				'title' => 'Wiki Cardfight!! Vanguard',
				'url' => 'http://bit.ly/2j17iUw'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b1/Warframe_11_17.jpg/revision/latest?cb=20171029100936',
				'title' => 'Warframe вики',
				'url' => 'http://ru.warframe.wikia.com/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a6/Fallout_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'Убежище',
				'url' => 'http://ru.fallout.wikia.com/wiki/Fallout_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/izumgorod/images/b/b5/Izumgorod_banner2.jpg/revision/latest?cb=20170921084949&path-prefix=ru',
				'title' => 'Изумрудный город вики',
				'url' => 'http://ru.izumgorod.wikia.com/wiki/%D0%98%D0%B7%D1%83%D0%BC%D1%80%D1%83%D0%B4%D0%BD%D1%8B%D0%B9_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/7e/Shameless_11_17.jpg/revision/latest?cb=20171029100934',
				'title' => 'Shameless Wiki',
				'url' => 'http://ru.shameless.wikia.com/wiki/Shameless_US_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/af/Elex_11_17.jpg/revision/latest?cb=20171029100934',
				'title' => 'Elex wiki',
				'url' => 'http://ru.elex.wikia.com/wiki/Welcome'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/0f/Wolfenstain_11_17.jpg/revision/latest?cb=20171029100933',
				'title' => 'Wolfenstein Wiki',
				'url' => 'http://ru.wolfenstein.wikia.com/wiki/Wolfenstein_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/e/e5/Assassins_Creed_11_17.jpg/revision/latest?cb=20171029100933',
				'title' => 'Assassin\'s Creed: Истоки',
				'url' => 'http://ru.assassinscreed.wikia.com/wiki/Assassin%27s_Creed:_%D0%98%D1%81%D1%82%D0%BE%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/aa/Call_of_Duty_WW2_11_17.jpg/revision/latest?cb=20171029100933',
				'title' => 'Call of Duty: WWII',
				'url' => 'http://ru.callofduty.wikia.com/wiki/Call_of_Duty:_WWII'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/c/cd/Transformers_11_17.jpg/revision/latest?cb=20171029100932',
				'title' => 'Transformers вики',
				'url' => 'http://ru.transformers.wikia.com/wiki/Transformers_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/dd/Divinity_11_17.jpg/revision/latest?cb=20171029100932',
				'title' => 'Divinity вики',
				'url' => 'http://ru.divinity.wikia.com/wiki/Divinity_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/gravityfallsrp/images/a/a0/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_%D0%93%D0%A4%D0%A4.jpg/revision/latest?cb=20170913063608&path-prefix=ru',
				'title' => 'Гравити Фолз Фанон Вики',
				'url' => 'http://ru.gravityfallsrp.wikia.com/wiki/%D0%93%D1%80%D0%B0%D0%B2%D0%B8%D1%82%D0%B8_%D0%A4%D0%BE%D0%BB%D0%B7_%D0%A4%D0%B0%D0%BD%D0%BE%D0%BD_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/platform/images/e/e8/Logo-CSE.PNG/revision/latest?cb=20171117120531&path-prefix=uk',
				'title' => 'Енциклопедія громадянського суспільства в Україні',
				'url' => 'http://uk.prostir.wikia.com/wiki/%D0%93%D0%BE%D0%BB%D0%BE%D0%B2%D0%BD%D0%B0_%D1%81%D1%82%D0%BE%D1%80%D1%96%D0%BD%D0%BA%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elderscrollsukr/images/f/f8/%D0%94%D0%BB%D1%8F_%D0%B1%D0%B0%D0%BD%D0%B5%D1%80%D1%83.jpg/revision/latest?cb=20171123174601&path-prefix=ru',
				'title' => 'Стародавні Сувої українською',
				'url' => 'http://uk.elderscrolls.wikia.com/wiki/The_Elder_Scrolls_%D0%B2%D1%96%D0%BA%D1%96'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/wikia/images/e/e1/%D0%A1%D1%83%D0%BF%D0%B5%D1%80%D0%B3%D1%91%D1%80%D0%BB._%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20171123200226&path-prefix=ru',
				'title' => 'Супергёрл Вики',
				'url' => 'http://ru.supergirl.wikia.com/wiki/%D0%A1%D1%83%D0%BF%D0%B5%D1%80%D0%B3%D1%91%D1%80%D0%BB_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/c/ce/Star_Wars_Ladt_Jedi.jpg/revision/latest?cb=20171125111901',
				'title' => 'Звёздные войны: Последние джедаи',
				'url' => 'http://ru.starwars.wikia.com/wiki/%D0%97%D0%B2%D1%91%D0%B7%D0%B4%D0%BD%D1%8B%D0%B5_%D0%B2%D0%BE%D0%B9%D0%BD%D1%8B._%D0%AD%D0%BF%D0%B8%D0%B7%D0%BE%D0%B4_VIII:_%D0%9F%D0%BE%D1%81%D0%BB%D0%B5%D0%B4%D0%BD%D0%B8%D0%B5_%D0%B4%D0%B6%D0%B5%D0%B4%D0%B0%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/bf/Vikings_Season_5.jpg/revision/latest?cb=20171125111902',
				'title' => 'Викинги Вики',
				'url' => 'http://ru.vikings.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D0%BD%D0%B3%D0%B8_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/f/fc/RE7_Not_a_Hero.jpg/revision/latest?cb=20171125111901',
				'title' => 'Resident Evil 7: Not a Hero',
				'url' => 'http://ru.residentevil.wikia.com/wiki/Resident_Evil_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/70/Riverdale_S2.jpg/revision/latest?cb=20171125111901',
				'title' => 'Riverdale вики',
				'url' => 'http://ru.riverdale.wikia.com/wiki/Riverdale_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a9/Gamboll.jpg/revision/latest?cb=20171125111900',
				'title' => 'Удивительный Мир Гамбола Вики',
				'url' => 'http://ru.theamazingworldofgumball.wikia.com/wiki/%D0%A3%D0%B4%D0%B8%D0%B2%D0%B8%D1%82%D0%B5%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9_%D0%9C%D0%B8%D1%80_%D0%93%D0%B0%D0%BC%D0%B1%D0%BE%D0%BB%D0%B0_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/9/98/Rainbow_Six.JPG/revision/latest?cb=20171125111900',
				'title' => 'Rainbow Six Вики',
				'url' => 'http://ru.rainbowsix.wikia.com/wiki/Rainbow_Six_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/1/16/The-lion-guard.jpg/revision/latest?cb=20171125111902',
				'title' => 'Король Лев вики',
				'url' => 'http://ru.thelionking.wikia.com/wiki/%D0%9A%D0%BE%D1%80%D0%BE%D0%BB%D1%8C_%D0%9B%D0%B5%D0%B2_%D0%92%D0%B8%D0%BA%D0%B8'
			]
		],
		'it' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/zelda/images/b/b1/The_Legend_of_Zelda_WiiU_Artwork.png/revision/latest?cb=20170306075901',
				'title' => 'Zeldapedia',
				'url' => 'http://bit.ly/fandom-it-footer-itzelda'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/rickandmorty/images/b/bc/Slider_-_Personaggi.png/revision/latest/scale-to-width-down/670?cb=20170802162630&path-prefix=it',
				'title' => 'Rick and Morty Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itrickandmorty'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/supermarioitalia/images/8/81/Wikia-Visualization-Main%2Citsupermarioitalia.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102154509&path-prefix=it',
				'title' => 'Super Mario Italia Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itmario'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/starwars/images/2/2a/Wikia-Visualization-Main%2Citstarwars.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102142316&path-prefix=it',
				'title' => 'Jawapedia',
				'url' => 'http://bit.ly/fandom-it-footer-itstarwars'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/assassinscreed/images/f/f9/Wikia-Visualization-Main%2Citassassinscreed.png/revision/latest?cb=20161102150231&path-prefix=it',
				'title' => 'Assassin\'s Creed Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itassassinscreed'
			]
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
			]
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
				'url' => 'http://zh.hunterxhunter.wikia.com/wiki/%E7%8D%B5%E4%BA%BA_wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlegirl/images/8/87/Banner.png/revision/latest?cb=20170725105753&path-prefix=zh',
				'title' => '戰鬥女子學園Wiki',
				'url' => 'http://zh.battlegirl.wikia.com/wiki/%E6%88%B0%E9%AC%A5%E5%A5%B3%E5%AD%90%E5%AD%B8%E5%9C%92_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dccomics/images/c/c1/%E6%AD%A3%E7%BE%A9%E8%81%AF%E7%9B%9F.jpg/revision/latest?cb=20171109133024&path-prefix=zh',
				'title' => 'DC Wiki',
				'url' => 'http://zh.dc.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ro-foreverlove/images/5/5e/Header.jpg/revision/latest?cb=20171018022448&path-prefix=zh',
				'title' => 'RO仙境傳說：守護永恒的愛',
				'url' => 'http://zh.ro-foreverlove.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/digimonlinkz/images/7/71/%E6%95%B8%E7%A2%BC%E5%AF%B6%E8%B2%9D_Linkz_Wikia_header.png/revision/latest?cb=20160413185637&path-prefix=zh',
				'title' => '數碼寶貝Linkz',
				'url' => 'http://zh.digimonlinkz.wikia.com'
			]
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
			]
		],
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
