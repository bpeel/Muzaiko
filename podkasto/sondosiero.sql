drop table if exists `sondosiero`;

create table `sondosiero` (
       `programero` int(11) not null references `programero`.`id`,
       `nomo` varchar(254) not null,

       index(`programero`)
) default charset=utf8;
