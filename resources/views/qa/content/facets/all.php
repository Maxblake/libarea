<main class="col-span-12 mb-col-12">
  <div class="bg-white center justify-between br-box-gray box-shadow-all br-rd5 p15 mb15">
    <h1 class="m0 text-xl font-normal"><?= Translate::get($data['sheet']); ?></h1>
    <span class="text-sm gray-600">
      <?= Translate::get($data['sheet'] . '.info'); ?>.
    </span>
  </div>

  <div class="bg-white flex flex-row items-center justify-between br-rd5 p15">
    <ul class="flex flex-row list-none m0 p0 center">

      <?= tabs_nav(
        'nav',
        $data['sheet'],
        $user,
        $pages = [
          [
            'id'    => $data['type'] . 's.all',
            'url'   => getUrlByName($data['type'] . '.all'),
            'title' => Translate::get('all'),
            'icon'  => 'bi bi-app'
          ],
          [
            'id'    => $data['type'] . 's.new',
            'url'   => getUrlByName($data['type'] . '.new'),
            'title' => Translate::get('new ones'),
            'icon'  => 'bi bi-sort-up'
          ],
          [
            'tl'    => 1,
            'id'    => $data['type'] . 's.my',
            'url'   => getUrlByName($data['type'] . '.my'),
            'title' => Translate::get('reading'),
            'icon'  => 'bi bi-check2-square'
          ],
        ]
      );
      ?>

    </ul>
    <?php if ($user['trust_level'] > 1) { ?>
    <p class="m0 text-xl">
     <?php if ($data['limit']) { ?>
        <a class="ml15" title="<?= Translate::get('add'); ?>" href="<?= getUrlByName($data['type'] . '.add'); ?>">
          <i class="bi bi-plus-lg middle"></i>
        </a>
     <?php } ?>
    </p>
    <?php } ?>
  </div>

  <div class="bg-white p15">

    <?php if (!empty($data['facets'])) { ?>
      <?php if ($data['type'] == 'blog') { ?>
        <?= Tpl::import('/_block/facet/blog-list-all', ['facets' => $data['facets'], 'user' => $user]); ?>
      <?php } else { ?>
        <?= Tpl::import('/_block/facet/topic-list-all', ['facets' => $data['facets'], 'user' => $user]); ?>
      <?php } ?>
    <?php } else { ?>
      <?= no_content(Translate::get('no.content'), 'bi bi-info-lg'); ?>
    <?php } ?>

    <?= pagination($data['pNum'], $data['pagesCount'], $data['sheet'], '/' . $data['type'] . 's'); ?>
  </div>

</main>
</div>
<?= Tpl::import('/_block/wide-footer'); ?>