-- Postgres version of the schema for the LiquidThreads extension

BEGIN;

CREATE SEQUENCE thread_thread_id_seq;
CREATE TABLE thread (
  thread_id                INTEGER     NOT NULL PRIMARY KEY DEFAULT nextval('thread_thread_id_seq'),
  thread_root              INTEGER     NOT NULL,
  thread_ancestor          INTEGER     NOT NULL,
  thread_parent            INTEGER     NOT NULL,
  thread_summary_page      INTEGER     NOT NULL,
  thread_subject           TEXT            NULL,
  thread_author_id         INTEGER         NULL,
  thread_author_name       TEXT            NULL,
  thread_modified          TIMESTAMPTZ     NULL DEFAULT now(),
  thread_created           TIMESTAMPTZ     NULL DEFAULT now(),
  thread_editedness        SMALLINT    NOT NULL DEFAULT 0,
  thread_article_namespace SMALLINT    NOT NULL,
  thread_article_title     TEXT        NOT NULL,
  thread_article_id        INTEGER     NOT NULL,
  thread_type              SMALLINT    NOT NULL DEFAULT 0,
  thread_sortkey           TEXT        NOT NULL DEFAULT '',
  thread_replies           INTEGER     NOT NULL DEFAULT -1
);

CREATE UNIQUE INDEX thread_root_page ON thread(thread_root);
CREATE INDEX thread_ancestor ON thread(thread_ancestor, thread_parent);
CREATE INDEX thread_article_title ON thread(thread_article_namespace, thread_article_title, thread_sortkey);
CREATE INDEX thread_article ON thread(thread_article_id, thread_sortkey);
CREATE INDEX thread_modified ON thread(thread_modified);
CREATE INDEX thread_created ON thread(thread_created);
CREATE INDEX thread_summary_page ON thread(thread_summary_page);
CREATE INDEX thread_author ON thread(thread_author_id,thread_author_name);
CREATE INDEX thread_sortkey ON thread(thread_sortkey);

CREATE TABLE historical_thread (
  hthread_id            INTEGER NOT NULL,
  hthread_revision      INTEGER NOT NULL,
  hthread_contents      TEXT    NOT NULL,
  hthread_change_type   INTEGER NOT NULL,
  hthread_change_object INTEGER NOT NULL
);
CREATE UNIQUE INDEX historical_thread_unique ON historical_thread(hthread_id, hthread_revision);

CREATE TABLE user_message_state (
  ums_user           INTEGER NOT NULL,
  ums_thread         INTEGER NOT NULL,
  ums_read_timestamp TIMESTAMPTZ
);
CREATE UNIQUE INDEX user_message_state_unique ON user_message_state(ums_user, ums_thread);

CREATE SEQUENCE thread_history_th_id_seq;
CREATE TABLE thread_history (
  th_id             INTEGER NOT NULL PRIMARY KEY DEFAULT nextval('thread_history_th_id_seq'),
  th_thread         INTEGER NOT NULL,
  th_timestamp      TEXT    NOT NULL,
  th_user           INTEGER NOT NULL,
  th_user_text      TEXT    NOT NULL,
  th_change_type    INTEGER NOT NULL,
  th_change_object  INTEGER NOT NULL,
  th_change_comment TEXT    NOT NULL,
  th_content        TEXT    NOT NULL
);
CREATE INDEX thread_history_thread ON thread_history(th_thread,th_timestamp);
CREATE INDEX thread_history_user ON thread_history(th_user,th_user_text);

COMMIT;
