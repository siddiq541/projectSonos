CREATE TABLE users (
	u_ID varchar(50) NOT NULL,
	u_fname varchar(50) NOT NULL,
	u_lname varchar(50) NOT NULL,
	u_nickname varchar(50),
	u_avatar varchar(255),
	is_admin tinyint(1) NOT NULL DEFAULT 0,
	is_loggedIn tinyint(1) NOT NULL DEFAULT 0,
	hasVoted tinyint(4) DEFAULT 0,
	PRIMARY KEY (u_ID)
);
/* streaming service needs to be a user */
INSERT INTO users (u_ID, u_nickname) VALUES ('Streaming', 'Streaming');

CREATE TABLE pendingAdmin (
	p_email varchar(100) NOT NULL,
	p_requestedBy varchar(50) NOT NULL
);

CREATE TABLE queue (
	position int(10) unsigned NOT NULL AUTO_INCREMENT,
	user varchar(50),
	PRIMARY KEY (position)
);

CREATE TABLE currentTrack (
	likes int(11) DEFAULT 0,
	dislikes int(11) DEFAULT 0,
);
/* need to add one row to this table */
INSERT INTO currentTrack () Values ();

CREATE TABLE trackhistory (
	URI varchar(50),
	Count int(11),
	Votes int(11) DEFAULT 0, 
	Date varchar(15)
);

CREATE TABLE recommendedTracks (
	ID int(11) NOT NULL AUTO_INCREMENT,
	track varchar(50) NOT NULL,
	PRIMARY KEY (ID)
);


    