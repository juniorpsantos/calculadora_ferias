
create table usuarios
(
    id        int auto_increment
        primary key,
    nome      varchar(45)  not null,
    sobrenome varchar(45)  not null,
    email     varchar(110) not null,
    celular   varchar(15)  not null,
    senha     varchar(255) not null,
    genero    varchar(1)   null,
    constraint usuarios_pk
        unique (email)
);

create table calculadora
(
    id                  int auto_increment
        primary key,
    user_id             int                                   not null,
    salary              decimal(8, 3)                         null,
    is_sale_vacation    tinyint(1)                            null,
    work_start_date     date                                  null,
    result              decimal(8, 3)                         null,
    is_resignation      tinyint(1)                            null,
    total_work_days     int                                   null,
    vacation_start_date date                                  null,
    vacation_end_date   date                                  null,
    work_end_date       date                                  null,
    created_at          timestamp default current_timestamp() not null,
    constraint fk_1
        foreign key (user_id) references usuarios (id)
);

