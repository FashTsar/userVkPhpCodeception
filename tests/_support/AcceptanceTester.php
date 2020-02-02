<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * ---======= ДЕЙСТВИЯ ДО ЗАПУСКА ЦИКЛА =======---
     */

    /**
     * Авторизуемся в ВК
     */

    function authorizationVK($loginVk, $passwordVk) {
        // переходим на страницу ВК и авторизуемся
        $this->amOnUrl("https://vk.com/login");
        $this->waitForElementVisible("//input[@id='email']", 60);
        $this->wait(3);
        $this->fillField("//input[@id='email']", $loginVk);
        $this->wait(1);
        $this->fillField("//input[@id='pass']", $passwordVk);
        $this->wait(1);
        $this->click("//button[@id='login_button']");
        try {
            $this->waitForText("Моя страница", 60);
            echo "\nАвторизация прошла успешно";
        } catch (Exception $e) {
            echo "\nОшибка: Авторизация не прошла";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: not authorization VK";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
            $this->closeTab();
        }

    }

    /**
     * ---======= ДЕЙСТВИЯ в ЦИКЛЕ =======---
     */

    /**
     * Проверяем заявки в друзья
     */
    function checkFriendRequests() {
        try {
            // проверяем есть ли заявки в друзья
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3,5));
            $this->click("//div[@class='head_nav_item fl_r']");
            $this->wait(rand(3,5));
            $this->click("Моя страница");
            $this->wait(rand(3,5));
            $this->click("Друзья", "//div[@id='side_bar']");
            $this->wait(rand(3,5));
            $this->click("Заявки в друзья", "//div[@id='narrow_column']");
            $this->wait(rand(3,5));
            $this->click("Добавить в друзья", "//div[@id='list_content']/div[1]/div[1]");
            $this->wait(rand(3,5));
            echo "\nЗаявка в друзья подтверждена";
        } catch (Exception $e) {
            echo "\nНовых друзей не обнаружено";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: check Friend Requests NOT run";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
    }

    /**
     * ---======= ДЕЙСТВИЯ в ЦИКЛЕ, участвующие в РАНДОМЕ =======---
     */

    /**
     * добавляем статус ВК
     */
    function addStatusVk() {
        try {
            // собираем афоризм
            $this->amOnUrl("https://quote-citation.com/random");
            $this->wait(rand(3,5));
            $afor = $this->grabMultiple("//div[@class='quote-text']");
            $afor = $afor[0];

            // выкладываем в ВК
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3,5));
            $this->click("//div[@class='head_nav_item fl_r']");
            $this->wait(rand(3,5));
            $this->click("Моя страница");
            $this->wait(rand(3,5));
            try{
                $this->moveMouseOver("//div[@id='page_info_wrap']", 1, 1);
                $this->wait(1);
                $this->click("//span[@class='no_current_info']");
            } catch (Exception $e) {
                $this->moveMouseOver("//div[@id='page_info_wrap']", 1, 1);
                $this->wait(1);
                $this->click("//div[@id='currinfo_wrap']//span[@class='current_text']");
            }
            $this->wait(rand(3,5));
            $this->fillField("//div[@id='currinfo_input']", $afor);
            $this->wait(rand(3,5));
            echo "\nСтатус в ВК добавлен";
        }catch (Exception $e){
            echo "\nОшибка: Статус в ВК не добавлен";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: not add Status Vk";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        };
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем новость со своей страницы
     */
    function addNewsMyPageVk() {
        try {
            // собираем афоризм
            $this->amOnUrl("https://quote-citation.com/random");
            $this->wait(rand(3,5));
            $afor = $this->grabMultiple("//div[@class='quote-text']");
            $afor = $afor[0];

            // собираем слово
            $this->amOnUrl("http://free-generator.ru/words.html");
            $this->wait(rand(3,5));
            $word = $this->grabMultiple("//div[@id='result']");
            $word = $word[0];

            // выкладываем в ВК
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3,5));
            $this->click("//div[@class='head_nav_item fl_r']");
            $this->wait(rand(3,5));
            $this->click("Моя страница");
            $this->wait(rand(3,5));
            $this->fillField("//div[@id='post_field']", $afor);
            $this->wait(rand(3,5));
            $random = rand(1, 8);
            if($random === 1) {
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм добавлен в новости со своей страницы";
            }
            if ($random === 2) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с видео добавлен в новости со своей страницы";
            }
            if ($random === 3) {
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с песней добавлен в новости со своей страницы";
            }
            if ($random === 4) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photoRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photoRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото добавлен в новости со своей страницы";
            }
            if ($random === 5) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с песней и видео добавлен в новости со своей страницы";
            }
            if ($random === 6) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото и видео добавлен в новости со своей страницы";
            }
            if ($random === 7) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото и песней добавлен в новости со своей страницы";
            }
            if ($random === 8) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото, видео и песней добавлен в новости со своей страницы";
            }
        } catch (Exception $e){
            echo "\nОшибка: новость не добавилась со своей страницы";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: News My Page Vk NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        };
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем новость со страницы новостей
     */
    function addNewsPageNewsVk() {
        try {
            // собираем афоризм
            $this->amOnUrl("https://quote-citation.com/random");
            $this->wait(rand(3,5));
            $afor = $this->grabMultiple("//div[@class='quote-text']");
            $afor = $afor[0];

            // собираем слово
            $this->amOnUrl("http://free-generator.ru/words.html");
            $this->wait(rand(3,5));
            $word = $this->grabMultiple("//div[@id='result']");
            $word = $word[0];

            // выкладываем в ВК
            $this->amOnUrl("https://vk.com/feed");
            $this->wait(rand(3,5));
            $this->fillField("//div[@id='post_field']", $afor);
            $this->wait(rand(3,5));
            $random = rand(1, 8);
            if($random === 1) {
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм добавлен в новости";
            }
            if ($random === 2) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с видео добавлен в новости";
            }
            if ($random === 3) {
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с песней добавлен в новости";
            }
            if ($random === 4) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото добавлен в новости";
            }
            if ($random === 5) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с песней и видео добавлен в новости";
            }
            if ($random === 6) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото и видео добавлен в новости";
            }
            if ($random === 7) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото и песней добавлен в новости";
            }
            if ($random === 8) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nАфоризм с фото, видео и песней добавлен в новости";
            }
        } catch (Exception $e){
            echo "\nОшибка: новость не добавилась";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: News Page News Vk NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        };
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем новость со своей страницы БЕЗ слов
     */
    function addNewsMyPageVkNotWords() {
        try {
            // собираем слово
            $this->amOnUrl("http://free-generator.ru/words.html");
            $this->wait(rand(3,5));
            $word = $this->grabMultiple("//div[@id='result']");
            $word = $word[0];

            // выкладываем в ВК
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3,5));
            $this->click("//div[@class='head_nav_item fl_r']");
            $this->wait(rand(3,5));
            $this->click("Моя страница");
            $this->wait(rand(3,5));
            $random = rand(1, 7);
            if ($random === 1) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nВидео добавлено в новости со своей страницы";
            }
            if ($random === 2) {
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nПесня добавлена в новости со своей страницы";
            }
            if ($random === 3) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nФото добавлено в новости со своей страницы";
            }
            if ($random === 4) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nВидео и песня добавлены в новости со своей страницы";
            }
            if ($random === 5) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nВидео и фото добавлены в новости со своей страницы";
            }
            if ($random === 6) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nПесня и фото добавлены в новости со своей страницы";
            }
            if ($random === 7) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nПесня, видео и фото добавлены в новости со своей страницы";
            }
        } catch (Exception $e){
            echo "\nОшибка: новость без слов не добавилась со своей страницы";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: News My Page Vk Not Words NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        };
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем новость со страницы новостей БЕЗ слов
     */
    function addNewsPageNewsVkNotWords() {
        try {
            // собираем слово
            $this->amOnUrl("http://free-generator.ru/words.html");
            $this->wait(rand(3,5));
            $word = $this->grabMultiple("//div[@id='result']");
            $word = $word[0];

            // выкладываем в ВК
            $this->amOnUrl("https://vk.com/feed");
            $this->wait(rand(3,5));
            $random = rand(1, 7);
            if ($random === 1) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nВидео добавлено в новости";
            }
            if ($random === 2) {
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nПесня добавлена в новости";
            }
            if ($random === 3) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photoRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photoRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nФото добавлено в новости";
            }
            if ($random === 4) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nПесня и видео добавлены в новости";
            }
            if ($random === 5) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nФото и видео добавлены в новости";
            }
            if ($random === 6) {
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nФото и песня добавлены в новости";
            }
            if ($random === 7) {
                $this->click("//a[@class='ms_item ms_item_video _type_video']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='video_search_input']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $videoRandom = rand(1, 5);
                try{
                    $this->click("//div[@id='video_search_global_videos_list']/div[$videoRandom]//div[@class='media_check_btn']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@id='video_search_global_videos_list']/div[1]//div[@class='media_check_btn']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_photo _type_photo']");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ui_box_search']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='photos_attach_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='photos_attach_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $photosRandom = rand(1, 5);
                try{
                    $this->click("//div[@class='photos_choose_rows']/a[$photosRandom]/div[@class='media_check_btn_wrap']/div");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='photos_choose_rows']/a[1]/div[@class='media_check_btn_wrap']/div");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Прикрепить");
                $this->wait(rand(3,5));
                $this->click("//a[@class='ms_item ms_item_audio _type_audio']");
                $this->wait(rand(3,5));
                $this->fillField("//input[@id='ape_edit_playlist_search']", $word);
                $this->wait(rand(3,5));
                $this->pressKey("//input[@id='ape_edit_playlist_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
                $this->wait(rand(3,5));
                $audioRandom = rand(2, 6);
                try{
                    $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[$audioRandom]/div[@class='ape_attach']");
                    $this->wait(rand(3,5));
                } catch (Exception $e){
                    try{
                        $this->click("//div[@class='ape_item_list _ape_item_list noselect']/div[2]/div[@class='ape_attach']");
                        $this->wait(rand(3,5));
                    } catch (Exception $e){}
                };
                $this->click("Отправить");
                $this->wait(rand(3,5));
                echo "\nФото, видео и песня добавлены в новости";
            }
        } catch (Exception $e){
            echo "\nОшибка: новость без слов не добавилась";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: News Page News Vk Not Words NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        };
        $this->wait(rand(21, 59));
    }

    /**
     * добавляемся в группу
     */
    function addGroup() {
        try {
            // собираем слово
            $this->amOnUrl("http://free-generator.ru/words.html");
            $this->wait(rand(3, 5));
            $word = $this->grabMultiple("//div[@id='result']");
            $word = $word[0];

            // выкладываем в ВК
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3, 5));
            $this->click("Группы");
            $this->wait(rand(3, 5));
            $this->fillField("//input[@id='groups_list_search']", $word);
            $this->wait(rand(3, 5));
            $this->pressKey("//input[@id='groups_list_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
            $this->wait(rand(3,5));
            $groupsSearchSummary = $this->grabMultiple("//span[@id='groups_search_summary']");
            $groupsSearchSummary = $groupsSearchSummary[0];
            $groupsSearchSummary = str_replace(" ","",$groupsSearchSummary);
            if ($groupsSearchSummary >= 20) {
                $groupsSearchSummary = 20;
            }
            $randMax = rand(1, $groupsSearchSummary);
            $this->wait(rand(3, 5));
            $urlGroup = $this->grabMultiple("//div[@id='groups_list_search_cont']/div[$randMax]/a", "href");
            $urlGroup = $urlGroup[0];
            $this->amOnUrl($urlGroup);
            $this->wait(rand(3, 5));
            try {
                try {
                    $this->click("Вступить в группу");
                } catch (Exception $e) {
                    try {
                        $this->click("Подписаться");
                    } catch (Exception $e) {
                        try {
                            $this->click("Подать заявку");
                        } catch (Exception $e) {
                            $this->click("Присоединиться");
                        }
                    }
                }
            } catch (Exception $e) {
                $day = date("d.m.y");
                $time = date("H:i:s");
                $errorPlay = $time . ' ' . $day . ' ' . "Error: Group NOT click button addGroup";
                file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
            }
            $this->wait(rand(3, 5));
            echo "\nДобавились в группу";
        } catch (Exception $e){
            echo "\nОшибка: не получилось добавиться в группу";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: Group NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем друга из поиска
     */
    function addFineFriend() {
        try {
            // ищем случайного человека
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3, 5));
            $this->click("Друзья", "//div[@id='side_bar']");
            $this->wait(rand(3, 5));

            $this->click("Найти друзей");
            $this->wait(rand(3, 5));

            $listName = file_get_contents("tests/lists/name_list");
            $arrayListName = explode(",", $listName);
            $arrayListName = array_filter($arrayListName);
            $countListName = count($arrayListName);
            $countListName = $countListName - 1;

            $randName = $arrayListName[rand(0, $countListName)];

            $this->fillField("//input[@id='search_query']", $randName);
            $this->wait(rand(3, 5));
            $this->pressKey("//input[@id='search_query']", \Facebook\WebDriver\WebDriverKeys::ENTER);
            $this->wait(rand(3, 5));
            $peopleSearchSummary = $this->grabMultiple("//span[@class='page_block_header_count']");
            $peopleSearchSummary = str_replace(" ","",$peopleSearchSummary);
            if ($peopleSearchSummary >= 20) {
                $peopleSearchSummary = 20;
            }
            $randMax = rand(1, $peopleSearchSummary);
            $this->wait(rand(3, 5));
            $urlPeople = $this->grabMultiple("//div[@id='results']/div[$randMax]//a[@class='search_item_img_link _online']", "href");
            $urlPeople = $urlPeople[0];
            $this->amOnUrl($urlPeople);
            $this->wait(rand(3, 5));
            try {
                try {
                    $this->click("Добавить в друзья");
                } catch (Exception $e) {
                    try {
                        $this->click("Подписаться");
                    } catch (Exception $e) {}
                }
            } catch (Exception $e) {
                $day = date("d.m.y");
                $time = date("H:i:s");
                $errorPlay = $time . ' ' . $day . ' ' . "Error: Friend NOT click button addFineFriend";
                file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
            }
            $this->wait(rand(3, 5));
            echo "\nДобавили друга из поиска";
        } catch (Exception $e) {
            echo "\nОшибка: не полусилось добавить друга из поиска";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: Friend NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем друга из предложенных
     */
    function addOfferFriend() {
        try {
            // добавляем первого из предложенных
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3, 5));
            $this->click("Друзья", "//div[@id='side_bar']");
            $this->wait(rand(3, 5));

            $this->click("Найти друзей");
            $this->wait(rand(3, 5));

            $this->click("//div[@id='friends_list']/div[1]//a[@class='friends_find_user_add']");
            $this->wait(rand(3, 5));
            echo "\nДобавили друга из предложенных";
        } catch (Exception $e) {
            echo "\nОшибка: не получилось добавить друга из предложенных";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: Offer Friend NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
        $this->wait(rand(21, 59));
    }

    /**
     * ставим лайк в ленте новостей
     */
    function addLikeNews() {
        try {
            // ставим лайк на новость
            $this->amOnUrl("https://vk.com/feed");
            $this->wait(rand(3, 5));

            $randNews = rand(1, 7);
            $this->moveMouseOver("//div[@id='feed_rows']/div[$randNews]//a[@class='like_btn like _like']");
            $this->wait(rand(3, 5));
            $this->click("//div[@id='feed_rows']/div[$randNews]//a[@class='like_btn like _like']");
            $this->wait(rand(3, 5));
            echo "\nПоставили лайк на новость";
        } catch (Exception $e) {
            echo "\nОшибка: не получилось поставить лайк на новость";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: Like News NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
        $this->wait(rand(21, 59));
    }

    /**
     * делаем репост из ленты новостей
     */
    function addRepostNews() {
        try {
            // ставим лайк на новость
            $this->amOnUrl("https://vk.com/feed");
            $this->wait(rand(3, 5));

            $randNews = rand(1, 7);
            $this->moveMouseOver("//div[@id='feed_rows']/div[$randNews]//a[@class='like_btn share _share empty']");
            $this->wait(rand(3, 5));
            $this->click("//div[@id='feed_rows']/div[$randNews]//a[@class='like_btn share _share empty']");
            $this->wait(rand(3, 5));
            $this->click("Поделиться записью");
            $this->wait(rand(3, 5));
            echo "\nСделали репост из ленты новостей";
        } catch (Exception $e) {
            echo "\nОшибка: не получилось сделать репост из ленты новостей";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: Repost News NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем музыку
     */
    function addMusic() {
        try {
            // собираем слово
            $this->amOnUrl("http://free-generator.ru/words.html");
            $this->wait(rand(3,5));
            $word = $this->grabMultiple("//div[@id='result']");
            $word = $word[0];

            // добавляем песню
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3,5));
            $this->click("Музыка");
            $this->wait(rand(3,5));
            $this->fillField("//input[@id='audio_search']", $word);
            $this->wait(rand(3,5));
            $this->pressKey("//input[@id='audio_search']", \Facebook\WebDriver\WebDriverKeys::ENTER);
            $this->wait(rand(3,5));
            $randAudio = rand(1, 7);
            $this->moveMouseOver("//div[@class='clear_fix _audio_pl audio_recoms_audios_block audio_w_covers']/div[$randAudio]");
            $this->wait(rand(3,5));
            $this->click("//div[@class='clear_fix _audio_pl audio_recoms_audios_block audio_w_covers']/div[$randAudio]//button[@class='audio_row__action audio_row__action_add _audio_row__action_add']");
            $this->wait(rand(3,5));
            echo "\nДобавили песню в свою музыку";
        } catch (Exception $e) {
            echo "\nОшибка: не получилось добавить к себе песню";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: Music NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
        $this->wait(rand(21, 59));
    }

    /**
     * добавляем видео
     */
    function addVideo() {
        try {
            // собираем слово
            $this->amOnUrl("http://free-generator.ru/words.html");
            $this->wait(rand(3,5));
            $word = $this->grabMultiple("//div[@id='result']");
            $word = $word[0];

            // добавляем видео
            $this->amOnUrl("https://vk.com/");
            $this->wait(rand(3,5));
            $this->click("Видео");
            $this->wait(rand(3,5));
            $this->fillField("//input[@id='video_search_input']", $word);
            $this->wait(rand(3,5));
            $this->pressKey("//input[@id='video_search_input']", \Facebook\WebDriver\WebDriverKeys::ENTER);
            $this->wait(rand(3,5));
            $randVideo = rand(1, 7);
            $this->moveMouseOver("//div[@id='video_search_global_videos_list']/div[$randVideo]");
            $this->wait(rand(3,5));
            $this->click("//div[@id='video_search_global_videos_list']/div[$randVideo]//div[@class='icon icon_add']");
            $this->wait(rand(3,5));
            echo "\nДобавили к себе видео";
        } catch (Exception $e) {
            echo "\nОшибка: не получилось добавить к себе видео";
            $day = date("d.m.y");
            $time = date("H:i:s");
            $errorPlay = $time . ' ' . $day . ' ' . "Error: Video NOT add";
            file_put_contents('tests/log/log', $errorPlay . ",\n", FILE_APPEND);
        }
        $this->wait(rand(21, 59));
    }
}
