create database bookmarks;
use bookmarks;

create table tblUser (
	username varchar(16) not null primary key,
	passwd char(40) not null,
	email varchar(100) not null
				);

create table tblBookmark (
	username varchar(16) not null,
	bm_url varchar(255) not null,
	index(username),
	index(bm_url),
	primary key (username, bm_url)
				);

grant select, insert, update, delete on bookmarks.*
to bm_user@localhost identified by 'bm_user';
