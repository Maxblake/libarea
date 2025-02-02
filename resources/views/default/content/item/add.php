<?= insert('/_block/add-js-css'); ?>
<div id="contentWrapper" class="wrap-item">
  <main>
    <?= insert('/_block/navigation/breadcrumbs', [
      'list' => [
        [
          'name' => __('web.catalog'),
          'link' => url('web')
        ], [
          'name' => __('web.add_website'),
          'link' => 'red'
        ],
      ]
    ]); ?>

    <form action="<?= url('content.create', ['type' => 'item']); ?>" class="max-w780" method="post">
      <?= csrf_field() ?>
      <?= insert('/_block/form/select/category', ['data' => ['topic' => false], 'action' => 'add']); ?>
      <?= insert('/_block/form/add-website'); ?>
      <?= Html::sumbit(__('web.add')); ?>
    </form>
  </main>
  <aside>
    <div class="box box-shadow-all text-sm">
      <h4 class="uppercase-box"><?= __('web.help'); ?></h4>
      <?= __('web.data_help'); ?>
      <div>
  </aside>
</div>