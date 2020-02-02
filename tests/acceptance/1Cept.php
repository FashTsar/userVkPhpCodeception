<?php

$I = new AcceptanceTester($scenario);

// принимаемые параметры
$loginVK = "79035327901";
$passwordVK = "oCQS3So";

// переходим на страницу ВК и авторизуемся
$I->authorizationVK($loginVK, $passwordVK);

// ставим лайк на новость
$I->amOnUrl("https://vk.com/feed");
$I->wait(rand(3, 5));

$I->moveMouseOver("//div[@id='feed_rows']/div[1]//a[@class='like_btn like _like']");
$I->wait(rand(3, 5));
$I->click("//div[@id='feed_rows']/div[1]//a[@class='like_btn like _like']");
$I->wait(rand(3, 5));
echo "\nПоставили лайк на новость";