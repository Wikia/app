<?php

/**
 * Data Model for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

class WikiaBarDataFailsafeModel extends WikiaBarModelBase {

	/**
	 * @var array
	 * Structure should look like:
	 * [
	 *        language =>
	 *             [
	 *                 varticalid => message,
	 *                 varticalid => message
	 *            ],
	 *        language =>
	 *             [
	 *                 varticalid => message,
	 *                 varticalid => message
	 *            ]
	 * ]
	 */
	protected $data = array(
		'en' => array(
			WikiFactoryHub::CATEGORY_ID_GAMING =>
			'button-1-class=cup
button-1-text=Gaming: New Releases
button-1-href=http://www.wikia.com/Video_Games
button-2-class=travel
button-2-text=Halo 4
button-2-href=http://halo.wikia.com/wiki/Halo_4
button-3-class=beauty
button-3-text=Twitter
button-3-href=http://twitter.com/wikiagames
line-1-text=Click here for the latest features, news, and current events in gaming
line-1-href=http://www.wikia.com/Video_Games
line-2-text=Borderlands 2: Complete Weapon Guide now available
line-2-href=http://borderlands.wikia.com/wiki/Borderlands_2_Enemies
line-3-text=Up to the minute facts and figures on Halo 4
line-3-href=http://halo.wikia.com/wiki/Halo_4
line-4-text=What\'s new with Call of Duty multiplayer? Find out here!
line-4-href=http://callofduty.wikia.com
line-5-text=Tips and game-winning strategies for League of Legends
line-5-href=http://leagueoflegends.wikia.com/wiki/League_of_Legends_Wiki
',
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT =>
			'button-1-class=cup
button-1-text=New In Entertainment
button-1-href=http://www.wikia.com/Entertainment
button-2-class=travel
button-2-text=Fall TV
button-2-href=http://www.wikia.com/Entertainment/TV_Schedule
button-3-class=beauty
button-3-text=@WikiaEnt
button-3-href=https://twitter.com/wikiaent
line-1-text=Go behind the scenes for the 23rd Bond film.
line-1-href=http://jamesbond.wikia.com/wiki/Skyfall
line-2-text=Learn about the mysterious blackout in J.J. Abrams\' Revolution.
line-2-href=http://revolution.wikia.com/wiki/Revolution_Wiki
line-3-text=Explore the final adaptation of Twilight: Breaking Dawn
line-3-href=http://twilightsaga.wikia.com/wiki/Breaking_Dawn
line-4-text=Look up the Lyrics of your favorite song now!
line-4-href=http://lyrics.wikia.com/Lyrics_Wiki
line-5-text=Follow the development process of the new Hobbit trilogy.
line-5-href=http://lotr.wikia.com/wiki/The_Hobbit_%28films%29
',
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'button-1-class=cup
button-1-text=Gaming: New Releases
button-1-href=http://www.wikia.com/Video_Games
button-2-class=travel
button-2-text=New in Entertainment
button-2-href=http://www.wikia.com/Entertainment
button-3-class=beauty
button-3-text=Lifestyle: Travel
button-3-href=http://travel.wikia.com/wiki/Wikia_Travel
line-1-text=The world\'s most popular logos at your fingertips.
line-1-href=http://logos.wikia.com/wiki/Main_Page
line-2-text=Your family\'s genealogy awaits you.
line-2-href=http://familypedia.wikia.com/wiki/Family_History_and_Genealogy_Wiki
line-3-text=You have questions. We have answers.
line-3-href=http://how-to.wikia.com/wiki/How_To
line-4-text=Recipes for all your favorite dishes.
line-4-href=http://recipes.wikia.com/wiki/Recipes_Wiki
line-5-text=Over 8,000 pages dedicated to cars.
line-5-href=http://automobile.wikia.com/wiki/Autopedia
'
		),
		'de' => array(
			WikiFactoryHub::CATEGORY_ID_GAMING =>
			'button-1-class=cup
button-1-text=Videospiele
button-1-href=http://de.wikia.com/Videospiele
button-2-class=cup
button-2-text=Herbstauswahl
button-2-href=http://de.community.wikia.com/wiki/Benutzer_Blog:Foppes/Herbstauswahl_2012
button-3-class=cup
button-3-text=Assassin’s Creed 3
button-3-href=http://de.assassinscreed.wikia.com
line-1-text=Schau doch einfach hier rein und neue und interessante Videospiele Wikis kennenzulernen.
line-1-href=http://de.wikia.com/Videospiele
line-2-text=Das neueste Spiel aus der NeedforSpeed Reihe und Informationen zu vielen alten NfS-Titeln
line-2-href=http://de.neefdorspeed.wikia.com
line-3-text=Züchte neue Drachen und erweitere deinen Park mit deinen Freunden in DragonVale
line-3-href=http://de.dragonvale.wikia.com
line-4-text=Die Welt von Skyrim und ihrer Bewohner fasziniert dich und du willst alles erkunden?
line-4-href=http://de.elderscrolls.wikia.com
line-5-text=Du willst mit Mario und seinen vielen Freunden das große Nintendo-Universum kennen lernen?
line-5-href=http://de.mario.wikia.com
',
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT =>
			'button-1-class=cup
button-1-text=Entertainment
button-1-href=http://de.wikia.com/Entertainment
button-2-class=cup
button-2-text=Wikia bei Twitter
button-2-href=http://twitter.com/wikia_de
button-3-class=cup
button-3-text=Wikia bei Facebook
button-3-href=http://www.facebook.com/wikia.de
line-1-text=Das Neueste aus den Entertainment-Wikis
line-1-href=http://de.wikia.com/Entertainment
line-2-text=Besuche die magische Welt von Harry Potter
line-2-href=http://de.harry-potter.wikia.com
line-3-text=Physiker und hübsche Frauen - The Big Bang Theory
line-3-href=http://de.bigbangtheory.wikia.com
line-4-text=Bist du ein Freund von J.D. und Turk? Komm im Scrubs-Wiki vorbei!
line-4-href=http://de.scrubs.wikia.com
line-5-text=Der Herr der Elemente oder die Legende von Korra? Schau ins Avatar-Wiki!
line-5-href=http://de.avatar.wikia.com
',
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'button-1-class=cup
button-1-text=Lifestyle
button-1-href=http://de.wikia.com/Lifestyle
button-2-class=cup
button-2-text=Community-Wiki
button-2-href=http://de.community.wikia.com
button-3-class=cup
button-3-text=Mittelalter-Wiki
button-3-href=http://de.mittelalter.wikia.com
line-1-text=Alles rund um das große Lego-Universum
line-1-href=http://de.lego.wikia.com
line-2-text=Neue Rezepte für leckere Gerichte
line-2-href=http://rezepte.wikia.com
line-3-text=Wir unterstützen die deutsche Partner-Seite von Wikia Green. Du auch? Schau im Umwelt-Wiki vorbei!
line-3-href=http://de.green.wikia.com
line-4-text=Zu Guttenberg und Co. - Kritische Auseinandersetzungen mit Hochschulschriften auf Basis belastbarer Plagiatsfundstellen
line-4-href=http://de.vroniplag.wikia.com
line-5-text=Das Ele-Wiki - Wirf einen Blick in unsere riesige Datenbank zu den grauen Riesen
line-5-href=http://elefanten.wikia.com
'
		)
	);

	public function getData() {
		$this->wf->profileIn(__METHOD__);
		if (
			!empty($this->data[$this->getLang()])
			&& !empty($this->data[$this->getLang()][$this->getVertical()])
		) {
			$message = trim($this->data[$this->getLang()][$this->getVertical()]);
		} else {
			$message = null;
		}
		$this->wf->profileOut(__METHOD__);

		return $message;

	}
}

