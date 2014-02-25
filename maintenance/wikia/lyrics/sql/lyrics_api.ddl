CREATE DATABASE IF NOT EXISTS lyrics_api;
USE lyrics_api;

CREATE TABLE artist (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name           VARCHAR(255),
  romanized_name VARCHAR(255),
  pic            VARCHAR(255),
  official_site  VARCHAR(255),
  myspace        VARCHAR(50),
  twitter        VARCHAR(50),
  facebook       VARCHAR(50),
  wikia          VARCHAR(50),
  wikipedia      VARCHAR(50),
  wikipedia2     VARCHAR(50),
  country        VARCHAR(100),
  state          VARCHAR(50),
  hometown       VARCHAR(50),
  iTunes         VARCHAR(50),
  asin           VARCHAR(10),
  allmusic       VARCHAR(15),
  discogs        VARCHAR(10),
  musicbrainz    VARCHAR(30),
  youtube        VARCHAR(30),
  PRIMARY KEY (id),
  UNIQUE KEY (name)
)
  ENGINE =InnoDB;

CREATE TABLE album (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  artist_id      INT          NOT NULL,
  genre          VARCHAR(50),
  name           VARCHAR(255),
  romanized_name VARCHAR(255),
  year           SMALLINT DEFAULT NULL,
  length         SMALLINT DEFAULT NULL,
  image          VARCHAR(255),
  wikipedia      VARCHAR(50),
  asin           VARCHAR(10),
  itunes         VARCHAR(30),
  allmusic       VARCHAR(15),
  discogs        VARCHAR(10),
  musicbrainz    VARCHAR(30),
  download       VARCHAR(255),
  PRIMARY KEY (id),
  UNIQUE KEY (artist_id, name)
)
  ENGINE =InnoDB;

CREATE TABLE song (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  artist_id      INT          NOT NULL,
  name           VARCHAR(255),
  lyrics         TEXT,
  romanized_name VARCHAR(255),
  language       VARCHAR(100),
  youtube        VARCHAR(10),
  goear          VARCHAR(10),
  itunes         VARCHAR(30),
  asin           VARCHAR(10),
  musicbrainz    VARCHAR(30),
  allmusic       VARCHAR(15),
  download       VARCHAR(255),
  PRIMARY KEY (id),
  UNIQUE KEY (artist_id, name)
)
  ENGINE =InnoDB;

CREATE TABLE track (
  album_id     INT UNSIGNED      NOT NULL,
  song_id      INT UNSIGNED      NOT NULL,
  track_number SMALLINT UNSIGNED NOT NULL,
  UNIQUE KEY (album_id, song_id)
)
  ENGINE =InnoDB;