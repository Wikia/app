CREATE SEQUENCE invitation_inv_id_seq;
CREATE TABLE invitation (
	inv_id         INTEGER      NOT NULL DEFAULT nextval('invitation_inv_id_seq'),
	inv_inviter    INTEGER      NOT NULL,
	inv_invitee    INTEGER      NOT NULL,
	inv_type       TEXT         NOT NULL,
	inv_timestamp  TIMESTAMPTZ  NOT NULL DEFAULT now()
);
ALTER TABLE invitation ADD CONSTRAINT invitation_pk PRIMARY KEY (inv_id);
CREATE INDEX invitation_index ON invitation(inv_type, inv_inviter);

CREATE TABLE invite_count (
	ic_user  INTEGER NOT NULL PRIMARY KEY,
	ic_type  TEXT    NOT NULL,
	ic_count INTEGER NOT NULL DEFAULT 0
);
CREATE INDEX invite_count_index ON invite_count(ic_type);
