<?php

namespace App\Controllers;

use Hleb\Scheme\App\Controllers\MainController;
use App\Middleware\Before\UserData;
use App\Models\{ContentModel, ActionModel, AuditModel, NotificationsModel};
use Translate, Config;

class AuditController extends MainController
{
    private $user;

    public function __construct()
    {
        $this->user  = UserData::get();
    }

    // Check the freeze and the amount of content per day 
    // Проверим заморозку и количество контента в день
    public function placementSpeed($content, $type)
    {
        self::stopContentQuietМode($this->user['limiting_mode']);
 
        $number =  ContentModel::getSpeed($this->user['id'], $type);

        self::stopLimit($this->user['trust_level'], $number, $type);

        if (!self::stopUrl($content, $this->user['id'])) {
            return false;
        }

        if (!self::stopWords($content, $this->user['id'])) {
            return false;
        }

        return true;
    }

    // Stop changing (adding) content if the user is "frozen"    
    // Остановим изменение (добавление) контента если пользователь "заморожен"
    public static function stopContentQuietМode($user_limiting_mode)
    {
        if ($user_limiting_mode == 1) {
            addMsg(Translate::get('limiting-mode-1'), 'error');
            redirect('/');
        }
        return true;
    }

    // Checking limits on the level of trust of a participant 
    // Проверка лимитов по уровню доверия участника
    public static function stopLimit($user_trust_level, $number, $type)
    {
        if ($user_trust_level >= 0 && $user_trust_level <= 2) {
            if ($number >= Config::get('trust-levels.tl_' . $user_trust_level . '_add_' . $type)) {
                self::infoMsg($user_trust_level, $type . 's');
            }
        }

        if ($number > Config::get('trust-levels.all_limit')) {
            self::infoMsg($user_trust_level, 'messages');
        }
        return true;
    }

    // If there is a link and the total contribution (adding posts, replies and comments) is less than N 
    // Если есть ссылка и общий вклад (добавления постов, ответов и комментариев) меньше N
    public static function stopUrl($content, $uid)
    {
        if (self::estimationUrl($content)) {
            $all_count = AuditModel::ceneralContributionCount($uid);
            if ($all_count < 2) {
                ActionModel::addLimitingMode($uid);
                addMsg(Translate::get('content-audit'), 'error');
                return false;
            }
        }
        return true;
    }

    // If the word is on the stop list and the total contribution is minimal (less than 2)
    // Если слово в стоп листе и общий вклад минимальный (меньше 2)
    public static function stopWords($content, $uid)
    {
        if (self::stopWordsExists($content)) {
            $all_count = AuditModel::ceneralContributionCount($uid);
            if ($all_count < 2) {
                ActionModel::addLimitingMode($uid);
                addMsg(Translate::get('content-audit'), 'error');
                return false;
            }
        }
        return true;
    }

    public static function infoMsg($tl, $content)
    {
        addMsg(sprintf(Translate::get('limit.day'), 'TL' . $tl, '«' . Translate::get($content) . '»'), 'error');

        redirect('/');
    }

    // For URL trigger 
    // Для триггера URL
    public static function estimationUrl($content)
    {
        $regex = '/(?<!!!\[\]\(|"|\'|\=|\)|>)(https?:\/\/[-a-zA-Z0-9@:;%_\+.~#?\&\/\/=!]+)(?!"|\'|\)|>)/i';
        if ($info = preg_match($regex, $content, $matches)) {
            return  $matches[1];
        }
        return false;
    }

    /// Check the presence of the word in the stop list (audit in the admin panel) 
    // Проверим наличия слова в стоп листе (аудит в админ-панели)
    public static function stopWordsExists($content)
    {
        $stop_words = ContentModel::getStopWords();

        foreach ($stop_words as $word) {

            $word = trim($word['stop_word']);

            if (!$word) {
                continue;
            }

            if (substr($word, 0, 1) == '{' and substr($word, -1, 1) == '}') {

                if (preg_match(substr($word, 1, -1), $content)) {
                    return true;
                }
            } else {
                if (strstr($content, $word)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function create($type, $last_content_id, $url)
    {
        AuditModel::add(
            [
                'audit_type'        => $type,
                'audit_user_id'     => $this->user['id'],
                'audit_content_id'  => $last_content_id,
            ]
        );

        // Send notification type 15 (audit) to administrator (id 1) 
        // Отправим тип уведомления 15 (аудит) администратору (id 1)
        NotificationsModel::send(
            [
                'notification_sender_id'    => $this->user['id'],
                'notification_recipient_id' => 1,  // admin
                'notification_action_type'  => 15, // 15 audit 
                'notification_url'          => $url,
                'notification_read_flag'    => 0,
            ]
        );

        return true;
    }
}