<div class="w-100">
  <?= insert('/content/user/profile/header', ['data' => $data]); ?>
  <div class="flex gap">
    <main>
      <div class="mb15"><?= __('app.comments'); ?> <b><?= $data['profile']['login']; ?></b></div>
      <?php if (!empty($data['comments'])) : ?>
        <?= insert('/content/comment/comment', ['comments' => $data['comments']]); ?>
        <?= Html::pagination($data['pNum'], $data['pagesCount'], false, '/@' . $data['profile']['login'] . '/comments'); ?>
      <?php else : ?>
        <?= insert('/_block/no-content', ['type' => 'small', 'text' => __('app.no_comments'), 'icon' => 'info']); ?>
      <?php endif; ?>
    </main>
    <aside>
      <?= insert('/content/user/profile/sidebar', ['data' => $data]); ?>
    </aside>
  </div>
</div>