create table rates (
    id         int auto_increment primary key,
    rate       double       null,
    rates_to   varchar(128) null,
    rates_from varchar(128) null,
    created_at datetime     null,
    updated_at datetime     null
);

INSERT INTO test.rates (id, rate, rates_to, rates_from, created_at, updated_at) VALUES (3, 65.2543, 'RUR', 'USD', '2019-08-09 23:00:50', '2019-08-10 17:52:58');
INSERT INTO test.rates (id, rate, rates_to, rates_from, created_at, updated_at) VALUES (4, 73.0196, 'RUR', 'EUR', '2019-08-09 23:00:51', '2019-08-10 17:52:58');