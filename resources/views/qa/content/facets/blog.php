<?php $blog = $data['facet'];
if ($blog['facet_is_deleted'] == 0) { ?>

  <div class="col-span-12 mb-col-12">
    <div class="bg-white flex flex-row items-center box-shadow justify-between br-rd5 mb15 p15" style="background-image: linear-gradient(to right, white 0%, transparent 60%), url(<?= cover_url($blog['facet_cover_art'], 'blog'); ?>); background-position: 50% 50%;">
      <div class="mb-none">
        <?= facet_logo_img($blog['facet_img'], 'max', $blog['facet_title'], 'w94 br-box-gray mt5'); ?>
      </div>
      <div class="ml15 mb-ml-0 flex-auto">
        <h1 class="mb0 mt10 text-2xl">
          <?= $blog['facet_seo_title']; ?>
          <?php if (UserData::checkAdmin() || $blog['facet_user_id'] == $user['id']) { ?>
            <a class="right white fon-rgba -mt20" href="<?= getUrlByName('blog.edit', ['id' => $blog['facet_id']]); ?>">
              <i class="bi bi-pencil bold"></i>
            </a>
          <?php } ?>
        </h1>
        <div class="text-sm"><?= $blog['facet_short_description']; ?></div>

        <div class="mt15 right">
          <?= Tpl::import('/_block/facet/signed', [
            'user'           => $user,
            'topic'         => $blog,
            'topic_signed'  => is_array($data['facet_signed']),
          ]); ?>
        </div>

        <?= Tpl::import('/_block/facet/focus-users', [
          'user'               => $user,
          'topic_focus_count' => $blog['facet_focus_count'],
          'focus_users'       => $data['focus_users'] ?? '',
        ]); ?>
      </div>
    </div>

    <div class="grid grid-cols-12 gap-4 mb-gap-05">
      <main class="col-span-9 mb-col-12">
        <?= Tpl::import('/content/post/post', ['data' => $data, 'user' => $user]); ?>
        <?= pagination($data['pNum'], $data['pagesCount'], $data['sheet'], getUrlByName('blog', ['slug' => $blog['facet_slug']])); ?>
      </main>
      <aside class="col-span-3 relative mb-none">
        <?php if ($blog['facet_is_deleted'] == 0) { ?>
          <div class="br-box-gray p15 mb15 br-rd5 bg-white text-sm">
            <div class="uppercase gray mb5"> <?= Translate::get('created by'); ?></div>
            <a class="flex relative pt5 pb5 items-center hidden gray-600" href="/@<?= $data['user']['login']; ?>">
              <?= user_avatar_img($data['user']['avatar'], 'max', $data['user']['login'], 'w30 mr5 br-rd-50'); ?>
              <span class="ml5"><?= $data['user']['login']; ?></span>
            </a>
            <div class="gray-400 text-sm mt5">
              <i class="bi bi-calendar-week mr5 ml5 middle"></i>
              <span class="middle lowercase"><?= $blog['facet_add_date']; ?></span>
            </div>
          </div>
          <?php if ($data['info']) { ?>
            <div class="br-box-gray pt0 pr15 pb0 pl15 mb15 br-rd5 bg-white text-sm shown_post">
              <?= $data['info']; ?>
            </div>
          <?php } ?>

          <?php if (!empty($data['pages'])) { ?>
            <div class="sticky top0 top70">
              <div class="br-box-gray mt15 p15 mb15 br-rd5 bg-white text-sm">
                <div class="uppercase gray mt5 mb5"> <?= Translate::get('pages'); ?></div>
                <?php foreach ($data['pages'] as $ind => $row) { ?>
                  <div class="mb5">
                    <a class="relative pt5 pb5 hidden" href="<?= getUrlByName('page', ['facet' => $blog['facet_slug'], 'slug' => $row['post_slug']]); ?>">
                      <?= $row['post_title']; ?>
                    </a>
                    <?php if (UserData::checkAdmin() || $blog['facet_user_id'] == $user['id']) { ?>
                      <a class="text-sm gray-400" title="<?= Translate::get('edit'); ?>" href="<?= getUrlByName('page.edit', ['id' => $row['post_id']]); ?>">
                        <i class="bi bi-pencil"></i>
                      </a>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </aside>
    </div>
  </div>
<?php } else { ?>
  <div class="center col-span-10">
    <i class="bi bi-x-octagon text-8xl"></i>
    <div class="mt5 gray"><?= Translate::get('remote'); ?></div>
  </div>
<?php } ?>

<script nonce="<?= $_SERVER['nonce']; ?>">
  document.addEventListener('DOMContentLoaded', function() {
    tippy('.focus-user', {
      allowHTML: true,
      trigger: 'click',
      trigger: 'mouseenter click',
      allowHTML: 'true',
      hideOnClick: 'toggle',
      maxWidth: 'none',
      interactive: 'true',
      placement: 'auto',
      theme: 'light',
      onShow(instance) {
        fetch('/topic/<?= $blog['facet_slug']; ?>/followers/<?= $blog['facet_id']; ?>')
          .then((response) => response.text())
          .then(function(data) {
            instance.setContent(data);
          })
          .catch((error) => {
            instance.setContent(`Request failed. ${error}`);
          });
      },
    });
  });
</script>