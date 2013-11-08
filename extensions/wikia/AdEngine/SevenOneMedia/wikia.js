// Identifier
// http://de.wikia.com
window.SOI_IDENTIFIER = 'wikia';

// DFPSite, DFPZone
window.DFPSite   = 'DE_WIKIA';
window.DFPSiteRP = 'RP_WIKIA';
window.DFPZone = 'other';

switch (window.SOI_SUBSITE) {
	case 'home':
	/*
	case 'gaming':
	case 'lifestyle':
	case 'entertainment':
	*/
		window.DFPZone = window.SOI_SUBSITE;
		break;
}
if (!window.DFPZone) window.DFPZone = 'other';

switch (window.SOI_CONTENT) {
	case 'video':
		// FIXME: adjust as needed
		// if (window.SOI_VP) window.DFPSite += '.video';
		break;
}

// Rogator
window.SOI_ROGATOR = true;

// AdAudience
window.SOI_ADA = 'wikia_1307628';

// Nuggad
window.SOI_NUGGSID = 906739120;

// AdProbe
window.SOI_AP = {
	adaudience: { // RoP
		disabled: false,
		units: {
				pu1pl:    12467,
				pu1pu:    13604,
				pu1br:    12468,
				fb2:      12464,
				fb2low:   12536,
				fb2exp:   12956,
				fb2bb:    12955,
				fb2pl:    13603,
				fb2wp:    12466,
				fb2wpexp: 12959,
				rt1:      12463,
				rt1low:   12537,
				rt1pl:    13602,
				rt1hp:    12470,
				rt1hppl:  12958,
				sc1:      12465,
				sc1low:   12538,
				sc1pl:    12469,
				sc1exp:   12954,
				ma1:      12471 // ma1, ts1
			},
		ids: {
				pub_id:  1616,
				site_id: 6498,
				cu_id:   12463
			}
	},
	procter: {
		disabled: false,
		units: {
				nn1: 13191 // global unit
			},
		ids: {
				pub_id:  1538,
				site_id: 6672,
				cu_id:   13191
			}
	}
};

// YieldProbe
window.SOI_YP = {
	disabled: false,
	units: {
		fb2: 13826,
		sc1: 13822,
		rt1: 13824,
		nn1: 24842
	}
};

// Exclusion
if (window.SOI_CONTENT != 'video') window.SOI_EXCL = 'ga'; // SIC!

// wallpaper and fireplace
window.SOI_WP_LEFT     =   10;
window.SOI_WP_TOP      =    0;
window.SOI_FP_DISTANCE = 1032; // fb2 width 1322
window.SOI_FP_LEFT     =    1;
window.SOI_FP_TOP      =   10;

// old wallpaper - remove eventually
window.SOI_FB_POS_LEFT = window.SOI_WP_LEFT;
window.SOI_FB_POS_TOP  = window.SOI_WP_TOP;
