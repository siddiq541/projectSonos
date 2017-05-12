/*
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Playlist;
DROP TABLE IF Song details checked;
*/

CREATE TABLE users (
	u_ID INT AUTO_INCREMENT,
	u_fname varchar(50) not null,
	u_lname varchar(50) not null,
	u_nickname varchar(50)  null,
	u_email varchar(50) not null,
	u_avatar varchar (255) null,
	is_admin tinyint(1) not null default 0,
	CONSTRAINT pk_users PRIMARY KEY (u_ID)
);ENGINE = InnoDB;

CREATE TABLE playlist(
    playlistID int AUTO_INCREMENT,
    u_ID int not null,
    s_ID int not null,
    CONSTRAINT pk_playlist PRIMARY KEY (playlistID),
    CONSTRAINT fk_playlist_usr FOREIGN KEY (userID) REFERENCES users (userID),
    CONSTRAINT fk_playlist_songs FOREIGN KEY (s_ID) REFERENCES songs (s_ID)
    ON DELETE CASCADE ON UPDATE CASCADE
);ENGINE = InnoDB;

CREATE TABLE songs(
	s_ID int AUTO_INCREMENT,
	title varchar(50) not null,
	artist varchar(50) not null,
	playcount bigint null,
	likecount bigint null,
	dislikecount bigint null,
	duration decimal(4,2),
	CONSTRAINT pk_songs PRIMARY KEY (s_ID)
);ENGINE = InnoDB;
    