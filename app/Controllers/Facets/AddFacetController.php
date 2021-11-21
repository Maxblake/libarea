<?php

namespace App\Controllers\Facets;

use Hleb\Scheme\App\Controllers\MainController;
use Hleb\Constructor\Handlers\Request;
use App\Models\User\UserModel;
use App\Models\{FacetModel, SubscriptionModel};
use Base, Validation, Config, Translate;

class AddFacetController extends MainController
{
    private $uid;

    public function __construct()
    {
        $this->uid  = Base::getUid();
    }

    // Add form topic
    public function index()
    {
        $count_topic        = FacetModel::countFacetsUser($this->uid['user_id'], 'topic');
        $count_add_topic    = $this->uid['user_trust_level'] == 5 ? 999 : Config::get('trust-levels.count_add_topic');

        $valid = Validation::validTl($this->uid['user_trust_level'], Config::get('trust-levels.tl_add_topic'), $count_topic, $count_add_topic);
        if ($valid === false) {
            redirect('/');
        }

        return view(
            '/facets/add',
            [
                'meta'  => meta($m = [], Translate::get('add topic')),
                'uid'   => $this->uid,
                'data'  => [
                    'sheet'         => 'topics',
                    'count_topic'   => $count_add_topic - $count_topic,
                ]
            ]
        );
    }

    // Add topic
    public function create()
    {
        $facet  = UserModel::blogs($this->uid['user_id']);

        // Topic or Sapce
        $type   = Request::getPost('facet_type');
        $tl     = Validation::validTl($this->uid['user_trust_level'], Config::get('trust-levels.tl_add_' . $type), count($facet), Config::get('trust-levels.count_add_' . $type));
        if ($tl === false) {
            redirect('/');
        }

        $facet_title                = Request::getPost('facet_title');
        $facet_description          = Request::getPost('facet_description');
        $facet_short_description    = Request::getPost('facet_short_description');
        $facet_slug                 = Request::getPost('facet_slug');
        $facet_seo_title            = Request::getPost('facet_seo_title');

        $redirect = getUrlByName('topic.add');
        if ($type == 'blog') {
            $redirect = getUrlByName('user.blog', ['login' => $this->uid['user_login']]);
        }

        Validation::charset_slug($facet_slug, 'Slug (url)', $redirect);
        Validation::Limits($facet_title, Translate::get('title'), '3', '64', $redirect);
        Validation::Limits($facet_description, Translate::get('neta description'), '44', '225', $redirect);
        Validation::Limits($facet_short_description, Translate::get('short description'), '11', '160', $redirect);
        Validation::Limits($facet_slug, Translate::get('slug'), '3', '43', $redirect);
        Validation::Limits($facet_seo_title, Translate::get('slug'), '4', '225', $redirect);

        if (FacetModel::getFacet($facet_slug, 'slug')) {
            addMsg(Translate::get('url-already-exists'), 'error');
            redirect($redirect);
        }

        if (preg_match('/\s/', $facet_slug) || strpos($facet_slug, ' ')) {
            addMsg(Translate::get('url-gaps'), 'error');
            redirect($redirect);
        }

        $type = $type ?? 'topic';
        $facet_slug = strtolower($facet_slug);
        $data = [
            'facet_title'               => $facet_title,
            'facet_description'         => $facet_description,
            'facet_short_description'   => $facet_short_description,
            'facet_slug'                => $facet_slug,
            'facet_img'                 => 'facet-default.png',
            'facet_add_date'            => date("Y-m-d H:i:s"),
            'facet_seo_title'           => $facet_seo_title,
            'facet_user_id'             => $this->uid['user_id'],
            'facet_type'                => $type,
        ];

        $new_facet_id = FacetModel::add($data);

        SubscriptionModel::focus($new_facet_id['facet_id'], $this->uid['user_id'], 'topic');

        redirect(getUrlByName($type, ['slug' => $facet_slug]));
    }
}
