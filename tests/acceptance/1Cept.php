<?php

$I = new AcceptanceTester($scenario);

// принимаемые параметры
$loginVK = "79035327901";
$passwordVK = "oCQS3So";

// переходим на страницу ВК и авторизуемся
$I->authorizationVK($loginVK, $passwordVK);

// собираем афоризм
$I->amOnUrl("https://quote-citation.com/random");
$I->wait(rand(3,5));
$afor = $I->grabMultiple("//div[@class='quote-text']");
$afor = $afor[0];

// собираем слово
$I->amOnUrl("http://free-generator.ru/words.html");
$I->wait(rand(3,5));
$word = $I->grabMultiple("//div[@id='result']");
$word = $word[0];

// выкладываем в ВК
$I->amOnUrl("https://vk.com/");
$I->wait(rand(3,5));
$I->click("//div[@class='head_nav_item fl_r']");
$I->wait(rand(3,5));
$I->click("Моя страница");
$I->wait(rand(3,5));
$I->fillField("//div[@id='post_field']", $afor);
$I->wait(rand(3,5));

$I->click("Опубликовать");
$I->wait(rand(3,5));
echo "\nАфоризм добавлен в новости со своей страницы";