-- SUS-3079: Add a default empty value to rc_user_text
ALTER TABLE /*$wgDBprefix*/recentchanges
    MODIFY COLUMN rc_user_text VARCHAR(255) BINARY NOT NULL DEFAULT '';
