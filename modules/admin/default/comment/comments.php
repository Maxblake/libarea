<div class="wrap">
  <main class="admin">
    <div class="white-box pt5 pr15 pb5 pl15">
      <?= breadcrumb('/admin', lang('Admin'), null, null, lang('Comments-n'));
      $pages = array(
        array('id' => 'comments', 'url' => '/admin/comments', 'content' => lang('All')),
        array('id' => 'comments-ban', 'url' => '/admin/comments/ban', 'content' => lang('Deleted comments')),
      );
      echo returnBlock('tabs_nav', ['pages' => $pages, 'sheet' => $data['sheet'], 'user_id' => $uid['user_id']]);
      ?>

      <?php if (!empty($data['comments'])) { ?>
        <?php foreach ($data['comments'] as $comment) { ?>
          <a href="<?= getUrlByName('post', ['id' => $comment['post_id'], 'slug' => $comment['post_slug']]); ?>">
            <b><?= $comment['post_title']; ?></b>
          </a>
          <div id="comment_<?= $comment['comment_id']; ?>">
            <div class="size-13 gray">
              <?= user_avatar_img($comment['user_avatar'], 'small', $comment['user_login'], 'ava mr5'); ?>
              <a class="date mr5" href="<?= getUrlByName('user', ['login' => $comment['user_login']]); ?>">
                <?= $comment['user_login']; ?>
              </a>
              <span class="date mr5">
                <?= $comment['date']; ?>
              </span>
              <a class="gray-light ml10" href="/admin/logip/<?= $comment['comment_ip']; ?>">
                <?= $comment['comment_ip']; ?>
              </a>
              <?php if ($comment['post_type'] == 1) { ?>
                <i class="icon-commenting-o middle"></i>
              <?php } ?>
            </div>
            <div class="comm-telo-body">
              <?= $comment['content']; ?>
            </div>
            <div class="border-bottom mb15 mt5 pb5 size-13 hidden gray">
              + <?= $comment['comment_votes']; ?>
              <span id="cm_dell" class="right comment_link size-13">
                <a data-type="comment" data-id="<?= $comment['comment_id']; ?>" class="type-action">
                  <?php if ($data['sheet'] == 'comments-ban') { ?>
                    <?= lang('Recover'); ?>
                  <?php } else { ?>
                    <?= lang('Remove'); ?>
                  <?php } ?>
                </a>
              </span>
            </div>
          </div>
        <?php } ?>

      <?php } else { ?>
        <?= returnBlock('no-content', ['lang' => 'There are no comments']); ?>
      <?php } ?>
    </div>
    <?= pagination($data['pNum'], $data['pagesCount'], $data['sheet'], '/admin/comments'); ?>
  </main>
</div>