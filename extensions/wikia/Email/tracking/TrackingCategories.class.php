<?php

namespace Email\Tracking;

class TrackingCategories {
	const DEFAULT_CATEGORY = "UserMailer";
	const WALL_NOTIFICATION = "WallNotification";
	const EMAIL_CONFIRMATION = "ConfirmationMail";
	const EMAIL_CONFIRMATION_REMINDER = "ConfirmationReminderMail";
	const CHANGED_EMAIL_CONFIRMATION = "ReConfirmationMail";
	const WEEKLY_DIGEST = "GlobalWatchlist";
	const FORGOT_PASSWORD = 'TemporaryPassword';
}
