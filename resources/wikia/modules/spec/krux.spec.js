/*global describe, it, modules, expect*/
describe('Krux module', function () {
	'use strict';

	var mocks;

	function getModule() {
		return modules['wikia.krux'](
			mocks.window, mocks.document
		);
	}

	mocks = {
		window: {
			localStorage: {
				kxuser: 'testUser'
			}
		},
		document: {}
	};

	it('Expects to get user from localStorage', function () {
		expect(getModule().getUser()).toBe(mocks.window.localStorage.kxuser);
	});

	it('Expects to get limited amount of segments from localStorage', function () {
		var kruxSegmentsLots = "l7lznzoty,l4ml7tc6y,l4w5i2lte,l555eyz3i,l5g2q8ndp,l5h9g8s81,l5pog7454,l60oj8o6a,l65e7q72q,l6dwvwk4q,l6s4rzsar,l6sy2oz2g,m2q9mod98,m3049zgxw,m68e86ids,mab53nyfo,mab7cpvql,mdfzhvp3x,mf20tfg50,mjdpm83vl,mkcdphvyq,moz384t50,mt6nf08we,mueu17q3u,myuf1vmwd,n42nikugn,n4mr5r49z,n6lut96hn,nal53baeb,ne8px8c8b,nm90py68x,ntvki36t7,o4r0zitna,o854qerhj,o854virtj,o86oeigis,o86ohot8d,o95199u9p,ocr1te1tc,ocr52415y,ocry7a4xg,odm1prs9l,oefi4m6j2,ofbnn8fc5,ofbnrmvhq,ofbnwbwaj,ofe048xdm,ojahmr70e,ot2f7awir,ot2gg03he,oum6dbij4,ovdzqycj7,ow152zgq2,oxp6br1jd,oy9yr2sov,ozdaez94q,pa1q3hofr,paaug1j3r,pad70j24u,patp1wvps,pb2adfv75,pc84sj3ub,pc92edcv0,pcg8teuuj,pchbvgfqo,pcm7nq9z9,pcm831wgx,pcnao4717,pcof4tttq,pd88jzqbt,pd9ev7exz,pdtyi77yf,pdxhi3xue,pdxi4ub9w,peonvp4b7",
			kruxSegments27 = ["l7lznzoty", "l4ml7tc6y", "l4w5i2lte", "l555eyz3i", "l5g2q8ndp", "l5h9g8s81", "l5pog7454", "l60oj8o6a", "l65e7q72q", "l6dwvwk4q", "l6s4rzsar", "l6sy2oz2g", "m2q9mod98", "m3049zgxw", "m68e86ids", "mab53nyfo", "mab7cpvql", "mdfzhvp3x", "mf20tfg50", "mjdpm83vl", "mkcdphvyq", "moz384t50", "mt6nf08we", "mueu17q3u", "myuf1vmwd", "n42nikugn", "n4mr5r49z"];

		mocks.window.localStorage.kxsegs = kruxSegmentsLots;
		expect(getModule().getSegments()).toEqual(kruxSegments27);
	});

	it('ph3uhzc41 - last position', function () {
		var kruxSegmentsLots = "l7lznzoty,l4ml7tc6y,l4w5i2lte,l555eyz3i,l5g2q8ndp,l5h9g8s81,l5pog7454,l60oj8o6a,l65e7q72q,l6dwvwk4q,l6s4rzsar,l6sy2oz2g,m2q9mod98,m3049zgxw,m68e86ids,mab53nyfo,mab7cpvql,mdfzhvp3x,mf20tfg50,mjdpm83vl,mkcdphvyq,moz384t50,mt6nf08we,mueu17q3u,myuf1vmwd,n42nikugn,n4mr5r49z,n6lut96hn,nal53baeb,ne8px8c8b,nm90py68x,ntvki36t7,o4r0zitna,o854qerhj,o854virtj,o86oeigis,o86ohot8d,o95199u9p,ocr1te1tc,ocr52415y,ocry7a4xg,odm1prs9l,oefi4m6j2,ofbnn8fc5,ofbnrmvhq,ofbnwbwaj,ofe048xdm,ojahmr70e,ot2f7awir,ot2gg03he,oum6dbij4,ovdzqycj7,ow152zgq2,oxp6br1jd,oy9yr2sov,ozdaez94q,pa1q3hofr,paaug1j3r,pad70j24u,patp1wvps,pb2adfv75,pc84sj3ub,pc92edcv0,pcg8teuuj,pchbvgfqo,pcm7nq9z9,pcm831wgx,pcnao4717,pcof4tttq,pd88jzqbt,pd9ev7exz,pdtyi77yf,pdxhi3xue,pdxi4ub9w,peonvp4b7,ph3uhzc41",
			kruxSegments27 = ["ph3uhzc41", "l7lznzoty", "l4ml7tc6y", "l4w5i2lte", "l555eyz3i", "l5g2q8ndp", "l5h9g8s81", "l5pog7454", "l60oj8o6a", "l65e7q72q", "l6dwvwk4q", "l6s4rzsar", "l6sy2oz2g", "m2q9mod98", "m3049zgxw", "m68e86ids", "mab53nyfo", "mab7cpvql", "mdfzhvp3x", "mf20tfg50", "mjdpm83vl", "mkcdphvyq", "moz384t50", "mt6nf08we", "mueu17q3u", "myuf1vmwd", "n42nikugn"];

		mocks.window.localStorage.kxsegs = kruxSegmentsLots;
		expect(getModule().getSegments()).toEqual(kruxSegments27);
	});

	it('ph3uhzc41 - 27th position', function () {
		var kruxSegmentsLots = "l7lznzoty,l4ml7tc6y,l4w5i2lte,l555eyz3i,l5g2q8ndp,l5h9g8s81,l5pog7454,l60oj8o6a,l65e7q72q,l6dwvwk4q,l6s4rzsar,l6sy2oz2g,m2q9mod98,m3049zgxw,m68e86ids,mab53nyfo,mab7cpvql,mdfzhvp3x,mf20tfg50,mjdpm83vl,mkcdphvyq,moz384t50,mt6nf08we,mueu17q3u,myuf1vmwd,n42nikugn,ph3uhzc41,n4mr5r49z,n6lut96hn,nal53baeb,ne8px8c8b,nm90py68x,ntvki36t7,o4r0zitna,o854qerhj,o854virtj,o86oeigis,o86ohot8d,o95199u9p,ocr1te1tc,ocr52415y,ocry7a4xg,odm1prs9l,oefi4m6j2,ofbnn8fc5,ofbnrmvhq,ofbnwbwaj,ofe048xdm,ojahmr70e,ot2f7awir,ot2gg03he,oum6dbij4,ovdzqycj7,ow152zgq2,oxp6br1jd,oy9yr2sov,ozdaez94q,pa1q3hofr,paaug1j3r,pad70j24u,patp1wvps,pb2adfv75,pc84sj3ub,pc92edcv0,pcg8teuuj,pchbvgfqo,pcm7nq9z9,pcm831wgx,pcnao4717,pcof4tttq,pd88jzqbt,pd9ev7exz,pdtyi77yf,pdxhi3xue,pdxi4ub9w,peonvp4b7",
			kruxSegments27 = ["l7lznzoty", "l4ml7tc6y", "l4w5i2lte", "l555eyz3i", "l5g2q8ndp", "l5h9g8s81", "l5pog7454", "l60oj8o6a", "l65e7q72q", "l6dwvwk4q", "l6s4rzsar", "l6sy2oz2g", "m2q9mod98", "m3049zgxw", "m68e86ids", "mab53nyfo", "mab7cpvql", "mdfzhvp3x", "mf20tfg50", "mjdpm83vl", "mkcdphvyq", "moz384t50", "mt6nf08we", "mueu17q3u", "myuf1vmwd", "n42nikugn", "ph3uhzc41"];

		mocks.window.localStorage.kxsegs = kruxSegmentsLots;
		expect(getModule().getSegments()).toEqual(kruxSegments27);
	});

	it('ph3uhzc41 - middle possition (between 0 and 27)', function () {
		var kruxSegmentsLots = "l7lznzoty,l4ml7tc6y,l4w5i2lte,l555eyz3i,l5g2q8ndp,l5h9g8s81,l5pog7454,l60oj8o6a,l65e7q72q,l6dwvwk4q,l6s4rzsar,l6sy2oz2g,m2q9mod98,m3049zgxw,m68e86ids,mab53nyfo,mab7cpvql,mdfzhvp3x,mf20tfg50,mjdpm83vl,mkcdphvyq,moz384t50,ph3uhzc41,mt6nf08we,mueu17q3u,myuf1vmwd,n42nikugn,n4mr5r49z,n6lut96hn,nal53baeb,ne8px8c8b,nm90py68x,ntvki36t7,o4r0zitna,o854qerhj,o854virtj,o86oeigis,o86ohot8d,o95199u9p,ocr1te1tc,ocr52415y,ocry7a4xg,odm1prs9l,oefi4m6j2,ofbnn8fc5,ofbnrmvhq,ofbnwbwaj,ofe048xdm,ojahmr70e,ot2f7awir,ot2gg03he,oum6dbij4,ovdzqycj7,ow152zgq2,oxp6br1jd,oy9yr2sov,ozdaez94q,pa1q3hofr,paaug1j3r,pad70j24u,patp1wvps,pb2adfv75,pc84sj3ub,pc92edcv0,pcg8teuuj,pchbvgfqo,pcm7nq9z9,pcm831wgx,pcnao4717,pcof4tttq,pd88jzqbt,pd9ev7exz,pdtyi77yf,pdxhi3xue,pdxi4ub9w,peonvp4b7",
			kruxSegments27 = ["l7lznzoty", "l4ml7tc6y", "l4w5i2lte", "l555eyz3i", "l5g2q8ndp", "l5h9g8s81", "l5pog7454", "l60oj8o6a", "l65e7q72q", "l6dwvwk4q", "l6s4rzsar", "l6sy2oz2g", "m2q9mod98", "m3049zgxw", "m68e86ids", "mab53nyfo", "mab7cpvql", "mdfzhvp3x", "mf20tfg50", "mjdpm83vl", "mkcdphvyq", "moz384t50", "ph3uhzc41", "mt6nf08we", "mueu17q3u", "myuf1vmwd", "n42nikugn"];

		mocks.window.localStorage.kxsegs = kruxSegmentsLots;
		expect(getModule().getSegments()).toEqual(kruxSegments27);
	});

	it('ph3uhzc41 - first', function () {
		var kruxSegmentsLots = "ph3uhzc41,l7lznzoty,l4ml7tc6y,l4w5i2lte,l555eyz3i,l5g2q8ndp,l5h9g8s81,l5pog7454,l60oj8o6a,l65e7q72q,l6dwvwk4q,l6s4rzsar,l6sy2oz2g,m2q9mod98,m3049zgxw,m68e86ids,mab53nyfo,mab7cpvql,mdfzhvp3x,mf20tfg50,mjdpm83vl,mkcdphvyq,moz384t50,mt6nf08we,mueu17q3u,myuf1vmwd,n42nikugn,n4mr5r49z,n6lut96hn,nal53baeb,ne8px8c8b,nm90py68x,ntvki36t7,o4r0zitna,o854qerhj,o854virtj,o86oeigis,o86ohot8d,o95199u9p,ocr1te1tc,ocr52415y,ocry7a4xg,odm1prs9l,oefi4m6j2,ofbnn8fc5,ofbnrmvhq,ofbnwbwaj,ofe048xdm,ojahmr70e,ot2f7awir,ot2gg03he,oum6dbij4,ovdzqycj7,ow152zgq2,oxp6br1jd,oy9yr2sov,ozdaez94q,pa1q3hofr,paaug1j3r,pad70j24u,patp1wvps,pb2adfv75,pc84sj3ub,pc92edcv0,pcg8teuuj,pchbvgfqo,pcm7nq9z9,pcm831wgx,pcnao4717,pcof4tttq,pd88jzqbt,pd9ev7exz,pdtyi77yf,pdxhi3xue,pdxi4ub9w,peonvp4b7",
			kruxSegments27 = ["ph3uhzc41", "l7lznzoty", "l4ml7tc6y", "l4w5i2lte", "l555eyz3i", "l5g2q8ndp", "l5h9g8s81", "l5pog7454", "l60oj8o6a", "l65e7q72q", "l6dwvwk4q", "l6s4rzsar", "l6sy2oz2g", "m2q9mod98", "m3049zgxw", "m68e86ids", "mab53nyfo", "mab7cpvql", "mdfzhvp3x", "mf20tfg50", "mjdpm83vl", "mkcdphvyq", "moz384t50", "mt6nf08we", "mueu17q3u", "myuf1vmwd", "n42nikugn"];

		mocks.window.localStorage.kxsegs = kruxSegmentsLots;
		expect(getModule().getSegments()).toEqual(kruxSegments27);
	});

	it('ph3uhzc41 only', function () {
		var kruxSegmentsLots = "ph3uhzc41",
			kruxSegments27 = ["ph3uhzc41"];

		mocks.window.localStorage.kxsegs = kruxSegmentsLots;
		expect(getModule().getSegments()).toEqual(kruxSegments27);
	});
});
