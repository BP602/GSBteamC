CREATE USER 'userGsb'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON gsb_frais.* TO 'userGsb'@'%' WITH GRANT OPTION;