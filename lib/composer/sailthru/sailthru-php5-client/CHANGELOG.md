## 1.2.1 (May 11th, 2016)
  - Fix typo, make tests pass

## 1.2.0 (May 4th, 2016)
  - Added getLastRateLimitInfo() call

## 1.1.0 (July 16, 2014)
  - Bump Version number for packagist to pick up
  - Removed contact import API call
  - Added stats_send call
  - Updated cancelSend()
  - Added Preview and Trigger API calls
  - Removed createNewUser() call
  - Removed setHorizon() call
  - Added Event call
  - Added options to pushContent()
## 1.09 (October 31, 2011)
  - Purchase API call

## 1.08 (September 07, 2011)
  - Added getBlasts() for querying blasts meta-data
  - Update job methods: processUpdateJob(), processUpdateJobFromUrl(), processUpdateJobFromFile() and processUpdateJobFromEmails()
  - Fixed bug for purchase API request

## 1.07 (June 02, 2011)
  - Preserve data type when sending to the server, All data are sent in json encoded format
  - Job API Call with file uploading support
  - Template Revisions

## 1.06 (May 14, 2011)
 - Added Hard bounce postback call
 - Added delete template API call
 - Added getLastResponseInfo()
 - Bug Fix: When boolean False is used for any parameter values, generated signature hash gets invalidated