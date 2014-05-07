-- Users Table. Auth and all
CREATE SEQUENCE user_id_seq;
CREATE TABLE users (
    user_id BIGINT PRIMARY KEY
          DEFAULT nextval('user_id_seq'),
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    paid BOOLEAN NOT NULL,
    nickname TEXT
) WITHOUT OIDS;

-- Fixtures
CREATE SEQUENCE game_id_seq;
CREATE TABLE fixtures (
    game_id BIGINT PRIMARY KEY
          DEFAULT nextval('game_id_seq'),
    time BIGINT NOT NULL,
    team1 TEXT NOT NULL,
    team2 BOOLEAN NOT NULL
) WITHOUT OIDS;

-- Results
CREATE TABLE results (
    game_id BIGINT PRIMARY KEY REFERENCES fixtures(game_id),
    result TEXT NOT NULL,
    score_team_A INT NOT NULL,
    score_team_B INT NOT NULL
) WITHOUT OIDS;

-- user betting
CREATE TABLE users_betting (
    user_id BIGINT PRIMARY KEY REFERENCES users(user_id),
    game_id BIGINT PRIMARY KEY REFERENCES fixtures(game_id),
    prediction TEXT NOT NULL
) WITHOUT OIDS;

-- team info
CREATE SEQUENCE team_id_seq;
CREATE TABLE teams (
    team_id BIGINT PRIMARY KEY
          DEFAULT nextval('team_id_seq'),
    name TEXT NOT NULL,
    flag_url TEXT NOT NULL
) WITHOUT OIDS;


