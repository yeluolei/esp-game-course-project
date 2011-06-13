drop database esp;
create database esp;
use esp;

create table player(
userid varchar(15) not null,
passwd varchar(20) not null,
status smallint default 0,
partid varchar(15) default null,
pairid int default 0,
primary key (userid),
foreign key (partid) references player(userid)
) engine=innodb charset=utf8;

create table pic(
picid int not null AUTO_INCREMENT,
url varchar(100) not null,
primary key(picid)
)engine=innodb charset=utf8;

create table gamepair(
id int not null AUTO_INCREMENT,
player1 varchar(15) not null,
player2 varchar(15) not null,
currentgame int default null,
primary key(id),
foreign key(player1) references player(userid),
foreign key(player2) references player(userid)
)engine=innodb charset=utf8;

create table game(
id int not null AUTO_INCREMENT primary key,
pairid int not null,
picid int not null,
status int not null default 0,
foreign key(pairid) references gamepair(id),
foreign key(picid) references pic(picid)
)engine=innodb charset=utf8;

create table labelforgame(
labelid varchar(30) not null,
player varchar(15) not null,
picid int not null,
pairid int not null,
gameid int not null,
primary key(labelid,player,picid,gameid),
foreign key(player) references player(userid),
foreign key(pairid) references gamepair(id),
foreign key(gameid) references game(id),
foreign key(picid) references pic(picid)
)engine=innodb charset=utf8;

create table label(
picid int not null,
content varchar(30) not null,
times int not null default 0,
foreign key(picid) references pic(picid)
)engine=innodb charset=utf8;

create table admin(
userid varchar(15) not null,
passwd varchar(20) not null,
primary key (userid)
) engine=innodb charset=utf8;
