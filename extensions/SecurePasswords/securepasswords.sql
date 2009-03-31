--- Modify the user table for the SecurePasswords extension
--- tinyblob doesn't cut it anymore for the password hashing used by this extension
--- so this will change it to mediumblob

ALTER TABLE /*$wgDBprefix*/user MODIFY user_password MEDIUMBLOB NOT NULL;
ALTER TABLE /*$wgDBprefix*/user MODIFY user_newpassword MEDIUMBLOB NOT NULL;