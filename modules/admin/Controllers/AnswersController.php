<?php

namespace Modules\Admin\Controllers;

use Hleb\Constructor\Handlers\Request;
use Modules\Admin\Models\AnswerModel;
use Lori\Content;
use Lori\Base;

class AnswersController extends \MainController
{
    public function index($sheet)
    {
        $uid    = Base::getUid();
        $page   = \Request::getInt('page');
        $page   = $page == 0 ? 1 : $page;

        $limit = 100;
        $pagesCount = AnswerModel::getAnswersAllCount($sheet);
        $answers    = AnswerModel::getAnswersAll($page, $limit, $sheet);

        $result = array();
        foreach ($answers  as $ind => $row) {
            $row['content'] = Content::text($row['answer_content'], 'text');
            $row['date']    = lang_date($row['answer_date']);
            $result[$ind]   = $row;
        }

        $meta_title = lang('Answers-n');
        if ($sheet == 'ban') {
            $meta_title = lang('Deleted answers');
        }

        $data = [
            'meta_title'    => $meta_title,
            'sheet'         => $sheet == 'ban' ? 'answerban' : 'answerall',
            'pagesCount'    => ceil($pagesCount / $limit),
            'pNum'          => $page,
        ];

        return view('/templates/answers', ['data' => $data, 'uid' => $uid, 'answers' => $result]);
    }
}
