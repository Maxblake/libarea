<?php

namespace Modules\Admin\Controllers;

use Hleb\Constructor\Handlers\Request;
use Modules\Admin\Models\WordsModel;
use Lori\Base;

class WordsController extends \MainController
{
    public function index($sheet)
    {
        $uid    = Base::getUid();
        $pg     = \Request::getInt('page');
        $page   = (!$pg) ? 1 : $pg;

        $words = WordsModel::getStopWords();

        $data = [
            'h1'            => lang('Stop words'),
            'meta_title'    => lang('Stop words'),
            'sheet'         => 'words',
        ];

        return view('/templates/word/words', ['data' => $data, 'uid' => $uid, 'words' => $words]);
    }
    // Форма добавления стоп-слова
    public function addPage()
    {
        $uid  = Base::getUid();
        $data = [
            'h1'            => lang('Add a stop word'),
            'meta_title'    => lang('Add a stop word'),
            'sheet'         => 'words',
        ];

        return view('/templates/word/add', ['data' => $data, 'uid' => $uid]);
    }

    // Добавление стоп-слова
    public function add()
    {
        $word = \Request::getPost('word');
        $data = [
            'stop_word'     => $word,
            'stop_add_uid'  => 1,
            'stop_space_id' => 0, // Глобально
        ];

        WordsModel::setStopWord($data);

        redirect('/admin/words');
    }

    // Удаление стоп-слова
    public function deletes()
    {
        $word_id    = \Request::getPostInt('id');

        WordsModel::deleteStopWord($word_id);

        redirect('/admin/words');
    }
}