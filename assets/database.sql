create database chat;
use chat;

create table chat
(
	id int(9) primary key not null auto_increment,
    usuario int(9) not null, -- numero do corretor que é dono desse chat
    destinatario varchar(255) not null,
    DMY datetime
);

create table menssagens
(
	id int(9) not null primary key auto_increment,
    chat int(9) not null, -- numero do chat que é dono dessa menssagem
    txt LONGTEXT not null,
    horario time not null,
    m_status int(1) not null -- status = 1 -> menssagem foi enviada, status = 2 -> menssagem foi recebida 
);

ALTER TABLE `menssagens` ADD CONSTRAINT `fk_chat_menssagens` FOREIGN KEY ( `chat` ) REFERENCES `chat` ( `id` ) ;

insert into chat (DMY) values (NOW());

select * from chat;
select max(id) from chat;

select * from menssagens;