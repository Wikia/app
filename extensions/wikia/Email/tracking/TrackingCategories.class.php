i<?php

namespace Email\Tracking;

class TrackingCategories {
	const DEFAULT_CATEGORY = "UserMailer";
	const WALL_NOTIFICATION = "WallNotification";

	const FOUNDER_FIRST_EDIT_USER_EN = 'FounderEmailsFirstEditUserEN';
	const FOUNDER_FIRST_EDIT_USER_INT = 'FounderEmailsFirstEditUserINT';
	const FOUNDER_EDIT_USER_EN = 'FounderEmailsEditUserEN';
	const FOUNDER_EDIT_USER_INT = 'FounderEmailsEditUserINT';
	const FOUNDER_EDIT_ANON_EN = 'FounderEmailsEditAnonEN';
	const FOUNDER_EDIT_ANON_INT = 'FounderEmailsEditAnonINT';
	const FOUNDER_NEW_MEMBER_EN = 'FounderEmailsRegisterdEN';
	const FOUNDER_NEW_MEMBER_INT = 'FounderEmailsRegisterdINT';

	const EMAIL_CONFIRMATION = "ConfirmationMail";
	const EMAIL_CONFIRMATION_REMINDER = "ConfirmationReminderMail";
	const CHANGED_EMAIL_CONFIRMATION = "ReConfirmationMail";
	const WEEKLY_DIGEST = "GlobalWatchlist";
	const FOUNDER_ACTIVITY_DIGEST_EN = 'FounderEmailsActivityDigestEN';
	const FOUNDER_ACTIVITY_DIGEST_INT = 'FounderEmailsActivityDigestINT';
	const FOUNDER_VIEWS_DIGEST_EN = 'FounderEmailsVieiwsDigestEN';
	const FOUNDER_VIEWS_DIGEST_INT = 'FounderEmailsViewsDigestINT';
	const TEMPORARY_PASSWORD = 'TemporaryPassword';
}
