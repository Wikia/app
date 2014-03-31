require([ 'jquery', 'wikia.ui.factory' ], function( $, uiFactory ) {
	var content = ["Bucko sutler flogging yawl hail-shot Cat o'nine tails piracy rutters provost poop deck. Belaying pin lass pillage quarter keel shrouds line man-of-war starboard fire in the hole. Sheet fire ship gibbet heave to quarter stern Pirate Round no prey, no pay bilged on her anchor lanyard. Lateen sail provost pirate gaff heave to clap of thunder gibbet squiffy reef sails hornswaggle. No prey, no pay cog draught quarterdeck strike colors killick carouser blow the man down fathom rigging.",
	"Rope's end measured fer yer chains Privateer crow's nest driver Pirate Round deadlights grog mizzenmast dead men tell no tales. Main sheet squiffy splice the main brace fluke stern belay jib carouser Yellow Jack haul wind. Overhaul grog blossom gally gangplank broadside shrouds Sail ho maroon Arr booty. Buccaneer run a rig six pounders provost dance the hempen jig Chain Shot bilge water parrel grog blossom hands. Spyglass Brethren of the Coast chantey squiffy rum gibbet cackle fruit topmast carouser heave down.",
	"Crow's nest Arr nipperkin spirits me plunder tender Jack Tar Letter of Marque Davy Jones' Locker. Bucko barque grog lateen sail Yellow Jack chase hulk plunder hearties American Main. Topgallant Spanish Main strike colors schooner wherry aye coffer barkadeer black jack to go on account. Davy Jones' Locker chandler port gabion hardtack matey barque ho spyglass gally. Hempen halter handsomely clap of thunder nipper reef sails spirits splice the main brace trysail Shiver me timbers belaying pin.",
		"Trysail topmast sheet fore barque lateen sail jolly boat nipperkin marooned pinnace. Cog Jolly Roger gabion heave to yawl sheet ye loot swing the lead Jack Ketch. Cable Spanish Main pirate crow's nest scuttle Letter of Marque Jolly Roger red ensign Davy Jones' Locker jack. Hearties topgallant case shot hands fluke quarter sutler stern Jolly Roger reef. Wench poop deck Sink me loot maroon hardtack dance the hempen jig crow's nest gibbet dead men tell no tales.",
		"Parrel belay crack Jennys tea cup man-of-war hardtack black jack code of conduct aye boatswain prow. Fire ship belay bilged on her anchor barque nipper quarter hornswaggle Cat o'nine tails provost overhaul. Maroon nipper blow the man down Letter of Marque hornswaggle boatswain poop deck skysail Jack Ketch topmast. Fire in the hole black spot grapple no prey, no pay gunwalls dance the hempen jig long clothes fire ship bilge American Main. Trysail draught pinnace six pounders yawl cackle fruit wench grog blossom spanker tender."];

	uiFactory.init( [ 'drawer' ] ).then( function( uiDrawer ) {
		uiDrawer.createComponent({
			vars: {
				//style: 'fixed',
				closeText: 'CLOSE',
				side: 'left',
				content: content.join('<br/>'),
				subcontent: content.join('<br/>')
			}
		}, function ( drawer ) {
			console.log(drawer);
			window.drawer = drawer;
		} );
	} );
} );
