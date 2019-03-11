CoppaTool
=========

[CoppaTool](https://community.wikia.com/wiki/Special:CoppaTool) is a central place for staff to quickly perform all the actions needed to cleanup an account due to COPPA compliance.

It mostly calls out to other existing functionality such as disabling an account, removing the profile image, deleting user pages, and in the case of IP addresses, renaming the IP address to `0.0.0.0` to remove identifying information.

It has a companion in COPPA Image Review which allows staff to review images uploaded by a user and delete them (and suppress them so admins can't undelete the images) if the image contains personally identifiable details about the COPPA user. The code is available in extensions/wikia/CoppaTool and the COPPA Image Review part is located within [the ImageReview extension](https://github.com/Wikia/app/blob/dev/extensions/wikia/ImageReview/CoppaImageReview.setup.php).
