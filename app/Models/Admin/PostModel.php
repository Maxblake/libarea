<?php

namespace App\Models\Admin;

use Hleb\Scheme\App\Models\MainModel;
use DB;
use PDO;

class PostModel extends MainModel
{
    // Все ответы
    public static function getPostsAll($page, $limit, $sheet)
    {
        $sort = "WHERE post_is_deleted = 0";
        if ($sheet == 'ban') {
            $sort = "WHERE post_is_deleted = 1";
        }

        $start  = ($page - 1) * $limit;
        $sql = "SELECT 
                    post_id,
                    post_title,
                    post_slug,
                    post_type,
                    post_translation,
                    post_draft,
                    post_date,
                    post_published,
                    post_user_id,
                    post_votes,
                    post_answers_count,
                    post_comments_count,
                    post_content,
                    post_content_img,
                    post_thumb_img,
                    post_merged_id,
                    post_ip,
                    post_closed,
                    post_tl,
                    post_lo,
                    post_top,
                    post_url_domain,
                    post_is_deleted,
                    rel.*,
                    user_id, user_login, user_avatar
                    
                        FROM posts
                        LEFT JOIN
                        (
                            SELECT 
                                MAX(topic_id), 
                                MAX(topic_slug), 
                                MAX(topic_title),
                                MAX(relation_topic_id), 
                                relation_post_id,

                                GROUP_CONCAT(topic_slug, '@', topic_title SEPARATOR '@') AS topic_list
                                FROM topics  
                                LEFT JOIN topics_post_relation 
                                    on topic_id = relation_topic_id
                                GROUP BY relation_post_id
                        ) AS rel
                            ON rel.relation_post_id = post_id 

                    INNER JOIN users ON user_id = post_user_id
                    $sort ORDER BY post_top DESC, post_date DESC LIMIT $start, $limit";

        return DB::run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Посты где нет тем
    public static function getNoTopic()
    {
        $sql = "SELECT DISTINCT
                    post_id,
                    post_title,
                    post_slug,
                    post_draft,
                    post_is_deleted,
                    relation_post_id,
                    relation_topic_id
                        FROM posts
                            LEFT JOIN topics_post_relation on relation_post_id = post_id
                            
                            WHERE relation_topic_id is NULL AND post_is_deleted = 0 AND post_draft = 0";

        return DB::run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Количество ответов
    public static function getPostsAllCount($sheet)
    {
        $sort = "WHERE post_is_deleted = 0";
        if ($sheet == 'ban') {
            $sort = "WHERE post_is_deleted = 1";
        }

        $sql = "SELECT post_id
                FROM posts  $sort";

        return DB::run($sql)->rowCount();
    }
}