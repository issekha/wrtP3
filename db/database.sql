create database if not exists cmswrt character set utf8 collate utf8_unicode_ci;
use cmswrt;

grant all privileges on cmswrt.* to 'cmswrt_user'@'localhost' identified by 'secret';