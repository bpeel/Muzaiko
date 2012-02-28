drop table if exists `netrovita_kanto`;

create table `netrovita_kanto` (
       `artistoj` varchar(128) not null,
       `titolo` varchar(128) not null,

       `dato_de_manko` datetime not null,

       unique(`artistoj`, `titolo`)
) default charset=utf8;
