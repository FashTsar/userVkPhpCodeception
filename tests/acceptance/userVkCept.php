<?php

$I = new AcceptanceTester($scenario);

// принимаемые параметры
$loginVK = "";
$passwordVK = "";
$numberIterations = 1000000;
$runCheckFriendRequests = true;
$runAddNewsMyPageVk = true;
$runAddNewsPageNewsVk = true;
$runAddNewsMyPageVkNotWords = true;
$runAddNewsPageNewsVkNotWords = true;
$runAddLikeNews = true;
$runAddStatusVk = true;
$runAddRepostNews = true;
$runAddMusic = true;
$runAddVideo = true;
$runAddGroup = true;
$runAddFineFriend = true;
$runAddOfferFriend = true;

// чистим логи перед запуском
file_put_contents('tests/log/log', '');

// переходим на страницу ВК и авторизуемся
$I->authorizationVK($loginVK, $passwordVK);

// запускаем цикл
for ($man = 1; $man <= $numberIterations; $man++) {

    if ($runCheckFriendRequests === true) {
        // проверяем заявки в друзья
        $I->checkFriendRequests();
    }

    $randChance = rand(1, 100);

    if($randChance <= 15) {
        if ($runAddNewsMyPageVk === true) {
            // добавляем новость со своей страницы
            $I->addNewsMyPageVk();
        }
    }
    if ($randChance > 15 && $randChance <= 30) {
        if ($runAddNewsPageNewsVk === true) {
            // добавляем новост со страницы новостей
            $I->addNewsPageNewsVk();
        }
    }
    if ($randChance > 30 && $randChance <= 45) {
        if ($runAddNewsMyPageVkNotWords === true) {
            // добавляем новость со своей страницы БЕЗ слов
            $I->addNewsMyPageVkNotWords();
        }
    }
    if ($randChance > 45 && $randChance <= 60) {
        if ($runAddNewsPageNewsVkNotWords === true) {
            // добавляем новость со страницы новостей БЕЗ слов
            $I->addNewsPageNewsVkNotWords();
        }
    }
    if ($randChance > 60 && $randChance <= 75) {
        if ($runAddLikeNews === true) {
            // ставим лайк на новость
            $I->addLikeNews();
        }
    }
    if ($randChance > 75 && $randChance <= 80) {
        if ($runAddStatusVk === true) {
            // выкладываю статус ВК
            $I->addStatusVk();
        }
    }
    if ($randChance > 80 && $randChance <= 90) {
        if ($runAddRepostNews === true) {
            // делаем репост новости
            $I->addRepostNews();
        }
    }
    if ($randChance > 90 && $randChance <= 93) {
        if ($runAddMusic === true) {
            // добавляем песню
            $I->addMusic();
        }
    }
    if ($randChance > 93 && $randChance <= 95) {
        if ($runAddVideo === true) {
            // добавляем видео
            $I->addVideo();
        }
    }
    if ($randChance > 95 && $randChance <= 98) {
        if ($runAddGroup === true) {
            // добавляемся в группу
            $I->addGroup();
        }
    }
    if ($randChance === 99) {
        if ($runAddFineFriend === true) {
            // добавляем друга из поиска
            $I->addFineFriend();
        }
    }
    if ($randChance === 100) {
        if ($runAddOfferFriend === true) {
            // добавляем друга из предложенных
            $I->addOfferFriend();
        }
    }
}
