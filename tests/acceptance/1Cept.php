<?php

$I = new AcceptanceTester($scenario);

// принимаемые параметры
$loginVK = "79035327901";
$passwordVK = "oCQS3So";

// переходим на страницу ВК и авторизуемся
$I->authorizationVK($loginVK, $passwordVK);

// собираем слово
$I->amOnUrl("http://free-generator.ru/words.html");
$I->wait(rand(3,5));
$word = $I->grabMultiple("//div[@id='result']");
$word = $word[0];

// добавляем песню
$I->amOnUrl("https://vk.com/");
$I->wait(rand(3,5));
$I->click("Музыка");
$I->wait(rand(3,5));
$I->fillField("//input[@id='audio_search']", $word);
$I->wait(rand(3,5));
$I->pressKey("//input[@id='audio_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
$I->wait(rand(3,5));
$randAudio = rand(1, 7);
$I->moveMouseOver("//div[@class='clear_fix _audio_pl audio_recoms_audios_block audio_w_covers']/div[$randAudio]");
$I->wait(rand(3,5));
$I->click("//div[@class='clear_fix _audio_pl audio_recoms_audios_block audio_w_covers']/div[$randAudio]//button[@aria-label='Добавить в мою музыку']");
$I->wait(rand(3,5));
echo "\nДобавили песню в свою музыку";