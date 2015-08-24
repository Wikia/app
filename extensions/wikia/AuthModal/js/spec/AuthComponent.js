describe('AuthComponent', function () {
	'use strict';

	var rootElement = window.document.createElement('div'),
		AuthComponent = modules.AuthComponent(),
		authComponent = new AuthComponent(rootElement),
		baseUrl = window.location.origin;

	it('creates proper urls to auth pages', function () {
		var loginUrl = authComponent.getPageUrl(authComponent.pages.login),
			fbConnectUrl = authComponent.getPageUrl(authComponent.pages.facebookConnect, 'pl'),
			registerUrl = authComponent.getPageUrl(authComponent.pages.register, 'zh'),
			fbRegisterUrl = authComponent.getPageUrl(authComponent.pages.facebookRegister, 'de');

		expect(loginUrl).toEqual(baseUrl + '/signin?modal=1');
		expect(fbConnectUrl).toEqual(baseUrl + '/signin?modal=1&method=facebook&uselang=pl');
		expect(registerUrl).toEqual(baseUrl + '/register?modal=1&uselang=zh');
		expect(fbRegisterUrl).toEqual(baseUrl + '/register?modal=1&method=facebook&uselang=de');
	});

	it('creates proper uselang param', function () {
		expect(authComponent.getUselangParam('en')).toEqual('uselang=en');
		expect(authComponent.getUselangParam('pt-br')).toEqual('uselang=pt-br');
	});
});
