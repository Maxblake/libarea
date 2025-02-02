<?php
$type = $data['type'];
$sw = $sw ?? '?';
?>
<div id="contentWrapper" class="box">
  <main>

    <?php foreach ($data['tags'] as $tag) : ?>
      <?php $url = $type == 'post' ? url('topic', ['slug' => $tag['facet_slug']]) : url('category', ['sort' => 'all', 'slug' => $tag['facet_slug']]); ?>
      <a class="mr20 tag-yellow" href="<?= $url; ?>">
        <?= $tag['facet_title']; ?>
      </a>
    <?php endforeach; ?>

    <?php if (!empty($data['results'])) : ?>

      <p>
        <?= __('search.results_search'); ?> <?= $data['count']; ?>
        <?php if ($data['sw'] != 0) : ?>
          <span class="ml30 gray-600">
            <?= $data['sw']; ?> ms
          </span>
        <?php endif; ?>
      </p>

      <?php foreach ($data['results'] as $result) :

        if ($type == 'website') {
          $url_content = $result['item_url'];
        } elseif ($type == 'answer') {
          $url_content = post_slug($result['post_id'], $result['post_slug']) . '#answer_' . $result['answer_id'];
        } else {
          $url_content = '/post/' . $result['post_id'];
        }
      ?>

        <div class="max-w780 mb20">
          <div>
            <a class="text-xl" target="_blank" rel="nofollow noreferrer" href="<?= $url_content; ?>">
              <?= $result['title']; ?>
            </a>
          </div>
          <?php if ($type == 'website') : ?>
            <div class="text-sm mb5 lowercase">
              <span class="green">
                <?= Img::website($result['item_domain'], 'favicon', $result['item_domain'], 'favicons mr5'); ?>
                <?= $result['item_domain']; ?>
              </span>
              <a class="gray-600 ml15" href="<?= url('website', ['slug' => $result['item_domain']]); ?>"><?= __('web.more'); ?></a>
            </div>
            <?= fragment($result['content'], 250); ?>
          <?php elseif ($type == 'answer') : ?>

            <?= fragment($result['answer_content'], 250); ?>
          <?php else : ?>
            <div>
              <?= Html::facets($result['facet_list'], 'topic', 'tag mr15'); ?>
            </div>
            <?= fragment($result['content'], 250); ?>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <?php $url = 'go?q=' . $data['q'] . '&cat=' . $data['type'] . ''; ?>
      <?= insert('/content/search/pagination', ['pNum' => $data['pNum'], 'pagesCount' => $data['pagesCount'] - 1, 'url' => $url]); ?>
    <?php else : ?>
      <?= insert('/content/search/no-result', ['query' => $data['q']]); ?>
    <?php endif; ?>

  </main>
  <aside>
    <div class="box">
    </div>
  </aside>
</div>