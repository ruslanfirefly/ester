<?php
header('Content-Type: text/html; charset=utf-8');
$db = new PDO("mysql:host=localhost; dbname=ester", "root", "12345678", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$test = $db->query('SELECT ester_users.id,
                                  ester_users.username,
                                  ester_users.firstname,
                                  ester_users.secondname,
                                  ester_rolename.rolename as role,
                                  ester_city.city,
                                  ester_users.dogovor FROM ester_users, ester_city,ester_rolename
                                  WHERE ester_users.city = ester_city.id AND ester_rolename.id = ester_users.role')->fetchAll();
echo var_dump($test);