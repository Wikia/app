<?php
/**
 * Settings for the Semantic Forms Inputs extension.
 *
 * @author Stephan Gambke
 *
 * To change the default settings you can uncomment (or copy) the
 * examples here and adjust them to your needs. You may as well
 * include them in your LocalSettings.php.
 */

if ( !defined( 'SFI_VERSION' ) ) {
	die( 'This file is part of the SemanticFormsInputs extension, it is not a valid entry point.' );
}

##
# This is the path to your installation of Semantic Forms Inputs as
# seen from the web. No final slash.
#
$sfigSettings->scriptPath = $wgScriptPath . '/extensions/SemanticFormsInputs';

## Date Picker Settings

##
# This is the first selectable date (format yyyy/mm/dd)
# Sample value: '2005/01/01'
#
$sfigSettings->datePickerFirstDate = null;

##
# This is the last selectable date (format yyyy/mm/dd)
# Sample value: '2015/31/12'
#
$sfigSettings->datePickerLastDate = null;

##
# The date format string used for the user input.
# The date sent back to the form is fixed to yyyy/mm/dd
# (that is, yy/mm/dd in the format code below).
#
# The format can be combinations of the following:
#
# d - day of month (no leading zero)
# dd - day of month (two digit)
# o - day of the year (no leading zeros)
# oo - day of the year (three digit)
# D - day name short
# DD - day name long
# m - month of year (no leading zero)
# mm - month of year (two digit)
# M - month name short
# MM - month name long
# y - year (two digit)
# yy - year (four digit)
# @ - Unix timestamp (ms since 01/01/1970)
#  ! - Windows ticks (100ns since 01/01/0001)
# '...' - literal text
# '' - single quote
# anything else - literal text
#
# There are also two predefined standard date formats available:
#
# SHORT - short date format localized to the wiki user language
# LONG - long date format localized to the wiki user language
#
$sfigSettings->datePickerDateFormat = 'SHORT';

##
# This determines the start of the week in the display.
# Set it to: 0 (Zero) for Sunday, 1 (One) for Monday etc.
# If set to null the day is localized to the wiki user language
# Sample value: 1
#
$sfigSettings->datePickerWeekStart = null;

##
# This determines if the number of the week shall be shown.
#
$sfigSettings->datePickerShowWeekNumbers = false;

##
# This determines if the input field shall be disabled. The user can
# only set the date via the datepicker in this case.
#
$sfigSettings->datePickerDisableInputField = false;

##
# This determines if a reset button shall be shown. This is the only
# way to erase the input field if it is disabled for direct input.
#
$sfigSettings->datePickerShowResetButton = false;

##
# This is a string of disabled days of the week, i.e. days the user can not
# pick. The days must be given as comma-separated list of numbers starting
# with 0 for Sunday.
# Sample value: "6,0"
#
$sfigSettings->datePickerDisabledDaysOfWeek = null;

##
# This is a string of highlighted days of the week. The days must be given as
# comma-separated list of numbers starting with 0 for Sunday.
# Sample value: "6,0"
#
$sfigSettings->datePickerHighlightedDaysOfWeek = null;

##
# This is a string of disabled dates, i.e. days the user cannot pick. The
# days must be given as comma-separated list of dates or date ranges. The
# format for days is yyyy/mm/dd, for date ranges use yyyy/mm/dd-yyyy/mm/dd.
# Spaces are permissible.
# Sample value: "2010/12/25 - 2011/01/06, 2011/05/01"
#
$sfigSettings->datePickerDisabledDates = null;

##
# This is a string of highlighted dates. The days must be given as
# comma-separated list of dates or date ranges. The format for days is
# yyyy/mm/dd, for date ranges use yyyy/mm/dd-yyyy/mm/dd. Spaces are
# permissible.
# Sample value: "2010/12/25 - 2011/01/06, 2011/05/01"
#
$sfigSettings->datePickerHighlightedDates = null;


## Time Picker Settings

##
# This is the first selectable time (format hh:mm)
# Sample value: '00:00'
#
$sfigSettings->timePickerMinTime = null;

##
# This is the last selectable time (format hh:mm)
# Sample value: '24:00'
#
$sfigSettings->timePickerMaxTime = null;

##
# This determines if the input field shall be disabled. The user can
# only set the time via the timepicker in this case.
#
$sfigSettings->timePickerDisableInputField = false;

##
# This determines if a reset button shall be shown. This is the only
# way to erase the input field if it is disabled for direct input.
#
$sfigSettings->timePickerShowResetButton = false;


##
# This determines if a reset button shall be shown. This is the only
# way to erase the input field if it is disabled for direct input.
#
$sfigSettings->datetimePickerShowResetButton = false;

##
# This determines if the input field shall be disabled. The user can
# only set the value via the menu in this case.
#
$sfigSettings->menuSelectDisableInputField = false;

