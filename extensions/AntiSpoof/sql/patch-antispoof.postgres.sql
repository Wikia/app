CREATE TABLE spoofuser (
  -- Equivalent to user_name, but not guaranteed to be in sync.
  -- Do a join against user_name to confirm that an account hasn't
  -- been renamed or deleted away.
  su_name character varying PRIMARY KEY,

  -- Normalized form of name for similarity-spoofing checks
  su_normalized character varying,

  -- ok/not-ok according to the looks-like-a-valid-name check
  su_legal boolean,

  -- error message that came out of the unicode check, if any
  su_error text
);

CREATE INDEX su_normname_idx ON spoofuser (su_normalized,su_name);
