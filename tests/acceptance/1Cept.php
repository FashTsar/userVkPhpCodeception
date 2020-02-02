<?php

$I = new AcceptanceTester($scenario);

// принимаемые параметры
$loginVK = "79035327901";
$passwordVK = "oCQS3So";

// переходим на страницу ВК и авторизуемся
$I->authorizationVK($loginVK, $passwordVK);

// собираем слово
$I->amOnUrl("http://free-generator.ru/words.html");
$I->wait(rand(3, 5));
$word = $I->grabMultiple("//div[@id='result']");
$word = $word[0];

// выкладываем в ВК
$I->amOnUrl("https://vk.com/");
$I->wait(rand(3, 5));
$I->click("//li[@id='l_gr']");
$I->wait(rand(3, 5));
$I->fillField("//input[@id='groups_list_search']", $word);
$I->wait(rand(3, 5));
$I->pressKey("//input[@id='groups_list_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
$I->wait(rand(3,5));
$groupsSearchSummary = $I->grabMultiple("//span[@id='groups_search_summary']");
$groupsSearchSummary = $groupsSearchSummary[0];
$groupsSearchSummary = str_replace(" ","",$groupsSearchSummary);
if ($groupsSearchSummary >= 20) {
    $groupsSearchSummary = 20;
}
$randMax = rand(1, $groupsSearchSummary);
$I->wait(rand(3, 5));
$urlGroup = $I->grabMultiple("//div[@id='groups_list_search_cont']/div[$randMax]/a", "href");
$urlGroup = $urlGroup[0];
$I->amOnUrl($urlGroup);
$I->wait(rand(3, 5));
try {
    try {
        $I->click("Вступить в группу");
    } catch (Exception $e) {
        try {
            $I->click("Подписаться");
        } catch (Exception $e) {
            try {
                $I->click("Подать заявку");
            } catch (Exception $e) {
                $I->click("Присоединиться");
            }
        }
    }
} catch (Exception $e) {
    $day = date("d.m.y");
    $time = date("H:i:s");
    $errorPlay = $time . ' ' . $day . ' ' . "Error: Group NOT click button addGroup";
    file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
}
$I->wait(rand(3, 5));
echo "\nДобавились в группу";