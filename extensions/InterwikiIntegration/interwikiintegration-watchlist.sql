BEGIN;

CREATE TABLE integration_watchlist (
  -- Key to user.user_id
  integration_wl_user int unsigned NOT NULL,
  -- Database name of the wiki
  integration_wl_db varchar(255) binary NOT NULL,
  -- Key to page_namespace
  integration_wl_namespace int NOT NULL default 0,
  -- Key to page_title
  integration_wl_title varchar(255) binary NOT NULL default '',
  -- Timestamp when user was last sent a notification e-mail;
  -- cleared when the user visits the page.
  integration_wl_notificationtimestamp varbinary(14)
);

CREATE UNIQUE INDEX integration_wl_user ON integration_watchlist (integration_wl_user, integration_wl_namespace, integration_wl_title, integration_wl_db );
CREATE INDEX integration_namespace_title ON integration_watchlist (integration_wl_namespace, integration_wl_title );

COMMIT;
