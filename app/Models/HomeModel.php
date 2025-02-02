<?php

namespace App\Models;

use Hleb\Constructor\Handlers\Request;
use App\Models\IgnoredModel;
use UserData;
use DB;

class HomeModel extends \Hleb\Scheme\App\Models\MainModel
{
    // Posts on the central page
    // Посты на центральной странице
    public static function feed($page, $limit, $topics_user, $type)
    {
        $user_id = UserData::getUserId();

        $result = [];
        foreach ($topics_user as $ind => $row) {
            $result[$ind] = $row['facet_id'];
        }

        $resultNotUser = [];
        $ignored = IgnoredModel::getIgnoredUsers(50);
        foreach ($ignored as $ind => $row) {
            $resultNotUser[$ind] = $row['ignored_id'];
        }

        $ignoring = "post_user_id NOT IN(0) AND";
        if ($resultNotUser) $ignoring = "post_user_id NOT IN(" . implode(',', $resultNotUser ?? []) . ") AND";

        $string = "";
        if ($type != 'all' && $type != 'top') {
            if (!$user_id) {
                $string = "";
            } else {
                $string = "AND relation_facet_id IN(0)";
                if ($result) $string = "AND relation_facet_id IN(" . implode(',', $result ?? []) . ")";
            }
        }

        $display = self::display($type);
        $sort = self::sortDay($type);

        $start = ($page - 1) * $limit;
        $sql = "SELECT DISTINCT
                post_id,
                post_title,
                post_slug,
                post_feature,
                post_translation,
                post_draft,
                post_date,
                post_published,
                post_user_id,
                post_votes,
                post_hits_count,
                post_answers_count,
                post_comments_count,
                post_content,
                post_content_img,
                post_thumb_img,
                post_merged_id,
                post_closed,
                post_tl,
                post_lo,
                post_top,
                post_url_domain,
                post_is_deleted,
                rel.*,
                votes_post_item_id, votes_post_user_id,
                u.id, u.login, u.avatar, u.created_at, 
                fav.tid, fav.user_id, fav.action_type 
                    FROM facets_posts_relation 
                        LEFT JOIN posts ON relation_post_id = post_id
                        LEFT JOIN (
                            SELECT 
                                relation_post_id,
                                GROUP_CONCAT(facet_type, '@', facet_slug, '@', facet_title SEPARATOR '@') AS facet_list
                                FROM facets
                                LEFT JOIN facets_posts_relation 
                                    on facet_id = relation_facet_id
                                    GROUP BY relation_post_id
                        ) AS rel
                             ON rel.relation_post_id= post_id
                            LEFT JOIN users u ON u.id = post_user_id
                            LEFT JOIN favorites fav ON fav.tid = post_id 
                                AND fav.user_id = :uid AND fav.action_type = 'post'  
                            LEFT JOIN votes_post 
                                ON votes_post_item_id = post_id AND votes_post_user_id = :uid2
                                    WHERE $ignoring post_type != 'page' AND post_draft = 0 $string $display $sort LIMIT :start, :limit";

        return DB::run($sql, ['uid' => $user_id, 'uid2' => $user_id, 'start' => $start, 'limit' => $limit])->fetchAll();
    }

    public static function feedCount($topics_user, $type)
    {
        $result = [];
        foreach ($topics_user as $ind => $row) {
            $result[$ind] = $row['facet_id'];
        }

        $resultNotUser = [];
        $ignored = IgnoredModel::getIgnoredUsers(50);
        foreach ($ignored as $ind => $row) {
            $resultNotUser[$ind] = $row['ignored_id'];
        }

        $ignoring = "post_user_id NOT IN(0) AND";
        if ($resultNotUser) $ignoring = "post_user_id NOT IN(" . implode(',', $resultNotUser ?? []) . ") AND";

        $string = "";
        if ($type != 'all' && $type != 'top') {
            if (!UserData::getUserId()) {
                $string = "";
            } else {
                $string = "AND f_id IN(0)";
                if ($result) $string = "AND f_id IN(" . implode(',', $result ?? []) . ")";
            }
        }

        $display = self::display($type);
        $sql = "SELECT 
                    post_id
                        FROM posts
                        LEFT JOIN
                        (
                            SELECT 
                            MAX(facet_id) as f_id,
                                relation_post_id
                                FROM facets  
                                LEFT JOIN facets_posts_relation 
                                    on facet_id = relation_facet_id
                                    GROUP BY relation_post_id
                        ) AS rel
                            ON rel.relation_post_id = post_id 

            INNER JOIN users ON id = post_user_id
                WHERE $ignoring post_draft = 0 $string $display";

        return DB::run($sql)->rowCount();
    }

    public static function display($type)
    {
        $countLike = config('feed.countLike');
        $trust_level = UserData::getUserTl();

        if ($type == 'questions') {
            return "AND post_is_deleted = 0 AND post_tl <= " . $trust_level . " AND post_feature = 1";
        }

        if ($type == 'posts') {
            return "AND post_is_deleted = 0 AND post_tl <= " . $trust_level . " AND post_feature = 0";
        }

        if ($trust_level == 10) {
            $display = "AND post_is_deleted = 0";

            if ($type == 'deleted') {
                $display = "AND post_is_deleted = 1";
            }
        } elseif ($trust_level > 0) {
            $display = "AND post_is_deleted = 0 AND post_tl <= " . $trust_level;
        } else {
            $display = "AND post_is_deleted = 0 AND post_votes >= $countLike AND post_tl <= " . $trust_level;
        }

        return $display;
    }

    // The last 5 responses on the main page
    // Последние 5 ответа на главной
    public static function latestAnswers()
    {
        $trust_level = UserData::getUserTl();
        $user_answer = "AND post_tl = 0";

        if ($user_id = UserData::getUserId()) {
            $user_answer = "AND answer_user_id != $user_id AND post_tl <= $trust_level";
        }

        $sql = "SELECT 
                    answer_id,
                    answer_post_id,
                    answer_content,
                    answer_date,
                    post_id,
                    post_slug,
                    login,
                    avatar
                        FROM answers 
                        LEFT JOIN users ON id = answer_user_id
                        RIGHT JOIN posts ON post_id = answer_post_id
                            WHERE answer_is_deleted = 0 AND post_is_deleted = 0 
                                $user_answer AND post_type = 'post'
                                    ORDER BY answer_id DESC LIMIT 5";

        return DB::run($sql)->fetchAll();
    }

    public static function latestItems($limit)
    {
        $sql = "SELECT item_title, item_domain FROM items WHERE item_published = 1 AND item_is_deleted = 0 ORDER BY item_id DESC LIMIT :limit";

        return DB::run($sql, ['limit' => $limit])->fetchAll();
    }

    public static function sortDay($type)
    {
        $sort = "ORDER BY post_top DESC, post_date DESC";
        
        if ($type == 'top') {

            $sort_day = Request::getGet('sort_day');
            $sortDay = (int)$sort_day ?? null;

            switch ($sortDay) {
                case 1:
                    $sort =  "ORDER BY post_votes and post_date > CURDATE()-INTERVAL 1 WEEK DESC";
                    break;
                case 3:
                    $sort =  "ORDER BY post_votes and post_date > CURDATE()-INTERVAL 3 WEEK DESC";
                    break;
                default:
                    $sort =  "ORDER BY post_votes DESC";
                    break;
            }
        }
        
        return $sort;
    }


    // Facets (topic, blogs) all / subscribed
    // Фасеты (темы, блоги) все / подписан
    public static function subscription()
    {
        $sql = "SELECT 
                    facet_id, 
                    facet_slug, 
                    facet_title,
                    facet_user_id,
                    facet_img,
                    facet_type                   
                        FROM facets 
                           LEFT JOIN facets_signed ON signed_facet_id = facet_id 
                                WHERE signed_user_id = :id AND (facet_type = 'topic' OR facet_type = 'blog')
                                    ORDER BY facet_id DESC";

        return DB::run($sql, ['id' => UserData::getUserId()])->fetchAll();
    }
}
