<?= includeTemplate(
  '/view/default/menu',
  [
    'data'  => $data,
    'meta'  => $meta,
    'menus' => [],
  ]
); ?>

<label><?= __('admin.build'); ?> JS / CSS</label>
<div class="update btn btn-primary" data-type="css"><?= __('admin.build'); ?></div>
<fieldset>
  <label><?= __('admin.topics'); ?> / <?= __('admin.posts'); ?></label>
  <div class="update btn btn-primary" data-type="topic"><?= __('admin.update'); ?></div>
</fieldset>
<fieldset>
  <label><?= __('admin.like'); ?></label>
  <div class="update btn btn-primary" data-type="up"><?= __('admin.update'); ?></div>
</fieldset>
<fieldset>
  <label><?= __('admin.trust_level'); ?></label>
  <div class="update btn btn-primary" data-type="tl"><?= __('admin.update'); ?></div>
</fieldset>
<fieldset class="max-w300">
  <label for="mail"><?= __('admin.email'); ?></label>
  <form action="<?= url('admin.test.mail'); ?>" method="post">
    <input type="mail" name="mail" value="" required>
    <div class="help"><?= __('admin.test_email'); ?>...</div>
</fieldset>
<?= Html::sumbit(__('admin.send')); ?>
</form>
</main>

<?= includeTemplate('/view/default/footer'); ?>