//See http://www.mediawiki.org/wiki/Extension:WikiLove for basic documentation on configuration.
//<nowiki>
( function( $ ) {
$.wikiLoveOptions = {
	defaultText: '{| style="background-color: $5; border: 1px solid $6;"\n\
|rowspan="2" style="vertical-align: middle; padding: 5px;" | [[$3|$4]]\n\
|style="font-size: x-large; padding: 3px 3px 0 3px; height: 1.5em;" | \'\'\'$2\'\'\'\n\
|-\n\
|style="vertical-align: middle; padding: 3px;" | $1 ~~~~\n\
|}',
	defaultBackgroundColor: '#fdffe7',
	defaultBorderColor: '#fceb92',
	defaultImageSize: '100px',
	defaultImage: 'Trophy.png',

	types: {
		// example type, could be removed later
		'barnstar': {
			name: mw.msg( 'wikilove-type-barnstars' ), // name of the type (appears in the types menu)
			select: mw.msg( 'wikilove-barnstar-select' ), // subtype select label
			subtypes: { // some different subtypes
				// note that when not using subtypes you should use these subtype options
				// for the top-level type
				'original': {
					fields: [ 'message' ], // fields to ask for in form
					option: mw.msg( 'wikilove-barnstar-original-option' ), // option listed in the select list
					descr: mw.msg( 'wikilove-barnstar-original-desc' ), // description
					header: mw.msg( 'wikilove-barnstar-header' ), // header that appears at the top of the talk page post (optional)
					title: mw.msg( 'wikilove-barnstar-original-title' ), // title that appears inside the award box (optional)
					image: 'Original Barnstar Hires.png' // image for the award
				},
				'admins': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-admins-option' ),
					descr: mw.msg( 'wikilove-barnstar-admins-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-admins-title' ),
					image: 'Administrator Barnstar Hires.png'
				},
				'antivandalism': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-antivandalism-option' ),
					descr: mw.msg( 'wikilove-barnstar-antivandalism-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-antivandalism-title' ),
					image: 'Barnstar of Reversion Hires.png'
				},
				'diligence': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-diligence-option' ),
					descr: mw.msg( 'wikilove-barnstar-diligence-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-diligence-title' ),
					image: 'Barnstar of Diligence Hires.png'
				},
				'diplomacy': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-diplomacy-option' ),
					descr: mw.msg( 'wikilove-barnstar-diplomacy-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-diplomacy-title' ),
					image: 'Peace Barnstar Hires.png'
				},
				'goodhumor': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-goodhumor-option' ),
					descr: mw.msg( 'wikilove-barnstar-goodhumor-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-goodhumor-title' ),
					image: 'Barnstar of Humour Hires.png'
				},
				'brilliant': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-brilliant-option' ),
					descr: mw.msg( 'wikilove-barnstar-brilliant-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-brilliant-title' ),
					image: 'Brilliant Idea Barnstar Hires.png'
				},
				'citation': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-citation-option' ),
					descr: mw.msg( 'wikilove-barnstar-citation-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-citation-title' ),
					image: 'Citation Barnstar Hires.png'
				},
				'civility': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-civility-option' ),
					descr: mw.msg( 'wikilove-barnstar-civility-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-civility-title' ),
					image: 'Civility Barnstar Hires.png'
				},
				'copyeditor': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-copyeditor-option' ),
					descr: mw.msg( 'wikilove-barnstar-copyeditor-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-copyeditor-title' ),
					image: 'Copyeditor Barnstar Hires.png'
				},
				'defender': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-defender-option' ),
					descr: mw.msg( 'wikilove-barnstar-defender-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-defender-title' ),
					image: 'WikiDefender Barnstar Hires.png'
				},
				'editors': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-editors-option' ),
					descr: mw.msg( 'wikilove-barnstar-editors-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-editors-title' ),
					image: 'Editors Barnstar Hires.png'
				},
				'designers': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-designers-option' ),
					descr: mw.msg( 'wikilove-barnstar-designers-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-designers-title' ),
					image: 'Graphic Designer Barnstar Hires.png'
				},
				'half': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-half-option' ),
					descr: mw.msg( 'wikilove-barnstar-half-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-half-title' ),
					image: 'Halfstar Hires.png',
					imageSize: '60px'
				},
				'minor': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-minor-option' ),
					descr: mw.msg( 'wikilove-barnstar-minor-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-minor-title' ),
					image: 'Minor Barnstar Hires.png'
				},
				'antispam': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-antispam-option' ),
					descr: mw.msg( 'wikilove-barnstar-antispam-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-antispam-title' ),
					image: 'No Spam Barnstar Hires.png'
				},
				'photographers': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-photographers-option' ),
					descr: mw.msg( 'wikilove-barnstar-photographers-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-photographers-title' ),
					image: 'Camera Barnstar Hires.png'
				},
				'kindness': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-kindness-option' ),
					descr: mw.msg( 'wikilove-barnstar-kindness-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-kindness-title' ),
					image: 'Kindness Barnstar Hires.png'
				},
				'reallife': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-reallife-option' ),
					descr: mw.msg( 'wikilove-barnstar-reallife-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-reallife-title' ),
					image: 'Real Life Barnstar.jpg'
				},
				'resilient': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-resilient-option' ),
					descr: mw.msg( 'wikilove-barnstar-resilient-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-resilient-title' ),
					image: 'Resilient Barnstar Hires.png'
				},
				'rosetta': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-rosetta-option' ),
					descr: mw.msg( 'wikilove-barnstar-rosetta-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-rosetta-title' ),
					image: 'Rosetta Barnstar Hires.png'
				},
				'special': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-special-option' ),
					descr: mw.msg( 'wikilove-barnstar-special-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-special-title' ),
					image: 'Special Barnstar Hires.png'
				},
				'surreal': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-surreal-option' ),
					descr: mw.msg( 'wikilove-barnstar-surreal-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-surreal-title' ),
					image: 'Surreal Barnstar Hires.png'
				},
				'teamwork': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-teamwork-option' ),
					descr: mw.msg( 'wikilove-barnstar-teamwork-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-teamwork-title' ),
					image: 'Team Barnstar Hires.png'
				},
				'technical': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-technical-option' ),
					descr: mw.msg( 'wikilove-barnstar-technical-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-technical-title' ),
					image: 'Vitruvian Barnstar Hires.png'
				},
				'tireless': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-tireless-option' ),
					descr: mw.msg( 'wikilove-barnstar-tireless-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-tireless-title' ),
					image: 'Tireless Contributor Barnstar Hires.gif'
				},
				'writers': {
					fields: [ 'message' ],
					option: mw.msg( 'wikilove-barnstar-writers-option' ),
					descr: mw.msg( 'wikilove-barnstar-writers-desc' ),
					header: mw.msg( 'wikilove-barnstar-header' ),
					title: mw.msg( 'wikilove-barnstar-writers-title' ),
					image: 'Writers Barnstar Hires.png'
				}
			},
			icon: mw.config.get( 'wgExtensionAssetsPath' ) + '/WikiLove/modules/ext.wikiLove/images/icons/wikilove-icon-barnstar.png' // icon for left-side menu
		},
		'food': {
			name: mw.msg( 'wikilove-type-food' ), // name of the type (appears in the types menu)
			select: mw.msg( 'wikilove-food-select' ), // subtype select label
			text: '{| style="background-color: $5; border: 1px solid $6;"\n\
|style="vertical-align: middle; padding: 5px;" | [[$3|$4]]\n\
|style="vertical-align: middle; padding: 3px;" | $1 ~~~~\n\
|}', // custom text
			subtypes: { // some different subtypes
				// note that when not using subtypes you should use these subtype options
				// for the top-level type
				'baklava': {
					fields: [ 'header', 'message' ], // fields to ask for in form
					option: mw.msg( 'wikilove-food-baklava-option' ), // option listed in the select list
					descr: mw.msg( 'wikilove-food-baklava-desc' ),
					header: mw.msg( 'wikilove-food-baklava-header' ), // header that appears at the top of the talk page post (optional)
					image: 'Baklava - Turkish special, 80-ply.JPEG', // image for the award
					imageSize: '135px' // size to display image
				},
				'beer': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-beer-option' ),
					descr: mw.msg( 'wikilove-food-beer-desc' ),
					header: mw.msg( 'wikilove-food-beer-header' ),
					image: 'Export hell seidel steiner.png',
					imageSize: '70px'
				},
				'brownie': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-brownie-option' ),
					descr: mw.msg( 'wikilove-food-brownie-desc' ),
					header: mw.msg( 'wikilove-food-brownie-header' ),
					image: 'Brownie transparent.png',
					imageSize: '120px'
				},
				'bubble tea': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-bubbletea-option' ),
					descr: mw.msg( 'wikilove-food-bubbletea-desc' ),
					header: mw.msg( 'wikilove-food-bubbletea-header' ),
					image: 'Bubble_Tea.png',
					imageSize: '65px'
				},
				'cheeseburger': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-cheeseburger-option' ),
					descr: mw.msg( 'wikilove-food-cheeseburger-desc' ),
					header: mw.msg( 'wikilove-food-cheeseburger-header' ),
					image: 'Cheeseburger.png',
					imageSize: '120px'
				},
				'cookie': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-cookie-option' ),
					descr: mw.msg( 'wikilove-food-cookie-desc' ),
					header: mw.msg( 'wikilove-food-cookie-header' ),
					image: 'Choco_chip_cookie.png',
					imageSize: '120px'
				},
				'coffee': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-coffee-option' ),
					descr: mw.msg( 'wikilove-food-coffee-desc' ),
					header: mw.msg( 'wikilove-food-coffee-header' ),
					image: 'A small cup of coffee.JPG',
					imageSize: '120px'
				},
				'tea': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-tea-option' ),
					descr: mw.msg( 'wikilove-food-tea-desc' ),
					header: mw.msg( 'wikilove-food-tea-header' ),
					image: 'Meissen-teacup pinkrose01.jpg',
					imageSize: '120px'
				},
				'cupcake': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-cupcake-option' ),
					descr: mw.msg( 'wikilove-food-cupcake-desc' ),
					header: mw.msg( 'wikilove-food-cupcake-header' ),
					image: 'Choco-Nut Bake with Meringue Top cropped.jpg',
					imageSize: '120px'
				},
				'pie': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-pie-option' ),
					descr: mw.msg( 'wikilove-food-pie-desc' ),
					header: mw.msg( 'wikilove-food-pie-header' ),
					image: 'A very beautiful Nectarine Pie.jpg',
					imageSize: '120px'
				},
				'strawberries': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-strawberries-option' ),
					descr: mw.msg( 'wikilove-food-strawberries-desc' ),
					header: mw.msg( 'wikilove-food-strawberries-header' ),
					image: 'Erdbeerteller01.jpg',
					imageSize: '120px'
				},
				'stroopwafels': {
					fields: [ 'header', 'message' ],
					option: mw.msg( 'wikilove-food-stroopwafels-option' ),
					descr: mw.msg( 'wikilove-food-stroopwafels-desc' ),
					header: mw.msg( 'wikilove-food-stroopwafels-header' ),
					image: 'Gaufre biscuit.jpg',
					imageSize: '135px'
				}
			},
			icon: mw.config.get( 'wgExtensionAssetsPath' ) + '/WikiLove/modules/ext.wikiLove/images/icons/wikilove-icon-food.png'
		},
		'kitten': {
			name: mw.msg( 'wikilove-type-kittens' ),
			fields: [ 'header', 'message' ],
			header: mw.msg( 'wikilove-kittens-header' ),
			text: '[[$3|left|150px]]\n$1\n\n~~~~\n<br style="clear: both"/>', // $3 is the image filename
			gallery: {
				imageList: [ 'Cucciolo gatto Bibo.jpg', 'Kitten (06) by Ron.jpg', 'Kitten-stare.jpg', 'Red Kitten 01.jpg', 'Kitten in a helmet.jpg', 'Cute grey kitten.jpg' ],
				width: 145,
				height: 150,
				number: 3
			},
			icon: mw.config.get( 'wgExtensionAssetsPath' ) + '/WikiLove/modules/ext.wikiLove/images/icons/wikilove-icon-kitten.png'
		},
		// default type, nice to leave this one in place when adding other types
		'makeyourown': {
			name: mw.msg( 'wikilove-type-makeyourown' ),
			fields: [ 'header', 'title', 'image', 'message' ],
			icon: mw.config.get( 'wgExtensionAssetsPath' ) + '/WikiLove/modules/ext.wikiLove/images/icons/wikilove-icon-create.png'
		}
	}
};

} )( jQuery );
//</nowiki>
