<?php

namespace App\Controllers\Admin;

use Hleb\Scheme\App\Controllers\MainController;
use App\Models\{HomeModel, AnswerModel, CommentModel, AgentModel, WebModel, TopicModel, Admin\PostModel};
use App\Models\User\UserModel;
use Base, Translate;

class HomeController extends MainController
{
    public function index()
    {
        $uid    = Base::getUid();
        $size   = disk_total_space(HLEB_GLOBAL_DIRECTORY);
        $bytes  = number_format($size / 1048576, 2) . ' MB';

        return view(
            '/admin/index',
            [
                'meta'  => meta($m = [], Translate::get('admin')),
                'uid'   => $uid,
                'data'  => [
                    'topics_count'      => TopicModel::getTopicsAllCount($uid['user_id'], 'all'),
                    'posts_count'       => HomeModel::feedCount([], $uid, 'all'),
                    'posts_no_topic'    => PostModel::getNoTopic(),
                    'users_count'       => UserModel::getUsersAllCount('all'),
                    'answers_count'     => AnswerModel::getAnswersAllCount('all'),
                    'comments_count'    => CommentModel::getCommentsAllCount('all'),
                    'links_count'       => WebModel::getLinksAllCount(),
                    'last_visit'        => AgentModel::getLastVisit(),
                    'bytes'             => $bytes,
                    'sheet'             => 'admin',
                ]
            ]
        );
    }
}