<?php

/**
 * SelfServiceAdvertisingSplashController
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class SelfServiceAdvertisingSplashController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('SelfServiceAdvertisingSplash');
		$this->app->wg->ShowAds = false;
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SpecialSelfServiceAdvertisingSplash/css/SelfServiceAdvertisingSplash.scss'));
	}

	public function index() {
		F::build('JSMessages')->enqueuePackage('SelfServiceAdvertisingSplash', JSMessages::EXTERNAL);
		$this->response->addAsset('extensions/wikia/SpecialSelfServiceAdvertisingSplash/js/SelfServiceAdvertisingSplash.js');
		$model = F::build('SelfServiceAdvertisingSplashModel');
		$this->getCouponForm = wfRenderModule(
			'WikiaForm',
			'Index',
			array('form' => $model->getFormData())
		);
	}

	/**
	 * request has to contain following fields:
	 * - name
	 * - email
	 *
	 * optional fields are:
	 * - company
	 * - telephone
	 */
	public function sendEmails() {
		$model = F::build('SelfServiceAdvertisingSplashModel');
		$model->setSrcEmail($this->request->getVal('email',null));
		$model->setUserName($this->request->getVal('name',null));
		$model->setUserPhone($this->request->getVal('telephone',null));
		$model->setUserCompany($this->request->getVal('company',null));
		$model->generateEmailBody();

		$this->validationResult = $model->validateData();
		if($this->validationResult) {
			$this->sendResult = $model->sendEmails();
			$this->sendMessage = $model->getSendResultMessage();
		} else {
			$this->validationMessages = $model->getValidationMessages();
		}
	}
}