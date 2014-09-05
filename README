kampasswd
=========

A PHP script to be used by kamailio (openSER) subscribers to change their password while using digest authentication with MySQL.

Passwords should have been stored as pre-calculated HA1 strings, NOT plain text.
You should enable ha1 calculation on your kamailio.cfg config file and disable the plain tex password column:

#!ifdef WITH_AUTH
modparam("auth_db", "db_url", DBURL)
#modparam("auth_db", "password_column", "password")
modparam("auth_db", "password_column", "ha1")
modparam("auth_db", "calculate_ha1", no)
modparam("auth_db", "load_credentials", "")
modparam("auth_db", "use_domain", MULTIDOMAIN)

