<main>
  <div class="flex justify-between mb20">
    <ul class="nav">
      <?= insert('/_block/navigation/nav', ['list' => config('navigation/nav.comments')]); ?>
    </ul>
  </div>
  <?php if (!empty($data['comments'])) : ?>
    <?= insert('/content/comment/comment', ['comments' => $data['comments']]); ?>
    <?= Html::pagination($data['pNum'], $data['pagesCount'], false, '/comments'); ?>
  <?php else : ?>
    <?= insert('/_block/no-content', ['type' => 'small', 'text' => __('app.no_comments'), 'icon' => 'info']); ?>
  <?php endif; ?>
</main>
<aside>
  <div class="box bg-beige sticky top-sm">
    <?= __('meta.comments_desc'); ?>
  </div>
</aside>