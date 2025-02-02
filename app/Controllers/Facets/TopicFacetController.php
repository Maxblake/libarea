<?php

namespace App\Controllers\Facets;

use Hleb\Constructor\Handlers\Request;
use App\Controllers\Controller;
use App\Services\Сheck\FacetPresence;
use App\Models\User\UserModel;
use App\Models\{FeedModel, SubscriptionModel, FacetModel, PostModel};
use Meta, Img;

class TopicFacetController extends Controller
{
    protected $limit = 25;

    // Posts in the topic 
    // Посты по теме
    public function index($sheet)
    {
        $facet  = FacetPresence::index(Request::get('slug'), 'slug', 'topic');

        if ($facet['facet_type'] == 'blog' || $facet['facet_type'] == 'section') {
            include HLEB_GLOBAL_DIRECTORY . '/app/Optional/404.php';
            hl_preliminary_exit();
        }

        $posts      = FeedModel::feed($this->pageNumber, $this->limit, $sheet, $facet['facet_slug']);
        $pagesCount = FeedModel::feedCount($sheet, $facet['facet_slug']);

        $title  = $facet['facet_seo_title'] . ' — ' .  __('app.topic');
        $description   = $facet['facet_description'];

        $url = url('topic', ['slug' => $facet['facet_slug']]);
        if ($sheet == 'recommend') {
            $url    =  url('recommend', ['slug' => $facet['facet_slug']]);
            $title  = $facet['facet_seo_title'] . ' — ' .  __('app.rec_posts');
            $description  = __('app.rec_posts_desc', ['name' => $facet['facet_seo_title']]) . $facet['facet_description'];
        }

        $m = [
            'og'         => true,
            'imgurl'     => Img::PATH['facets_logo'] . $facet['facet_img'],
            'url'        => $url,
        ];

        return $this->render(
            '/facets/topic',
            [
                'meta'  => Meta::get($title, $description, $m),
                'data'  => array_merge(
                    $this->sidebar($facet),
                    [
                        'pagesCount'    => ceil($pagesCount / $this->limit),
                        'pNum'          => $this->pageNumber,
                        'posts'         => $posts,
                        'sheet'         => $sheet,
                        'type'          => 'topic',
                    ]
                ),
                'facet'   => ['facet_id' => $facet['facet_id'], 'facet_type' => $facet['facet_type'], 'facet_user_id' => $facet['facet_user_id']],
            ]
        );
    }

    // Information on the topic 
    // Информация по теме
    public function info()
    {
        $facet  = FacetPresence::index(Request::get('slug'), 'slug', 'topic');

        $m = [
            'og'         => true,
            'imgurl'     => Img::PATH['facets_logo'] . $facet['facet_img'],
            'url'        => url('topic.info', ['slug' => $facet['facet_slug']]),
        ];

        return $this->render(
            '/facets/info',
            [
                'meta'  => Meta::get($facet['facet_seo_title'] . ' — ' .  __('app.info'), $facet['facet_description'], $m),
                'data'  => array_merge(
                    $this->sidebar($facet),
                    [
                        'sheet' => 'info',
                        'type'  => 'info',
                    ]
                ),
            ]
        );
    }

    // Information on the topic 
    // Информация по теме
    public function writers()
    {
        $facet  = FacetPresence::index(Request::get('slug'), 'slug', 'topic');

        $m = [
            'og'         => true,
            'imgurl'     => Img::PATH['facets_logo'] . $facet['facet_img'],
            'url'        => url('topic.writers', ['slug' => $facet['facet_slug']]),
        ];

        return $this->render(
            '/facets/writers',
            [
                'meta'  => Meta::get($facet['facet_seo_title'] . ' — ' .  __('app.info'), $facet['facet_description'], $m),

                'data'  => array_merge(
                    $this->sidebar($facet),
                    [
                        'sheet' => 'writers',
                        'type'  => 'writers',
                    ]
                ),
            ]
        );
    }

    public function sidebar($facet)
    {
        return [
            'facet'         => $facet,
            'facet_signed'  => SubscriptionModel::getFocus($facet['facet_id'], 'facet'),
            'related_posts' => PostModel::postRelated($facet['facet_post_related'] ?? null),
            'high_topics'   => FacetModel::getHighLevelList($facet['facet_id']),
            'writers'       => FacetModel::getWriters($facet['facet_id'], 15),
            'low_topics'    => FacetModel::getLowLevelList($facet['facet_id']),
            'low_matching'  => FacetModel::getLowMatching($facet['facet_id']),
            'user'          => UserModel::getUser($facet['facet_user_id'], 'id'),
        ];
    }
}
