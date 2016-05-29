<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/6
 * Time: 16:25
 */
$pdo = new PDO("mysql:host=localhost;dbname=oilsystem","root","root");
$rs = $pdo -> query("select * from oil_test");
while($row = $rs -> fetch()){
    print_r($row);
}