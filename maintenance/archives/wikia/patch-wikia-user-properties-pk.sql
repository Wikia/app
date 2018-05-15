-- set proper primary key for wikia_user_properties table
START TRANSACTION;

DELETE FROM wikia_user_properties
WHERE wup_property IS NULL;

ALTER TABLE wikia_user_properties
  MODIFY COLUMN wup_property VARBINARY(255) NOT NULL DEFAULT '';

ALTER TABLE wikia_user_properties
  ADD PRIMARY KEY (wup_user, wup_property);

ALTER TABLE wikia_user_properties
  DROP INDEX wup_user;

COMMIT;
