-- MySQL for the Education Program extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

ALTER TABLE /*_*/ep_revisions ADD COLUMN rev_object_identifier VARCHAR(255) NULL;
CREATE INDEX /*i*/ep_revision_object_identifier ON /*_*/ep_revisions (rev_object_identifier);