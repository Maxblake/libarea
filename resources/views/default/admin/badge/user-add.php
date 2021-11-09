<div class="sticky col-span-2 justify-between no-mob">
  <?= includeTemplate('/admin/admin-menu', ['sheet' => $data['sheet'], 'uid' => $uid]); ?>
</div>
<main class="col-span-10 mb-col-12">
  <?= breadcrumb(
    getUrlByName('admin'),
    Translate::get('admin'),
    getUrlByName('admin.badges'),
    Translate::get('badges'),
    Translate::get('reward the user') . ' ' . $data['user']['user_login']
  ); ?>

  <form action="<?= getUrlByName('admin.user.badge.create'); ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb20">
      <label class="block" for="post_content"><?= Translate::get('badge'); ?></label>
      <select class="w-100 h30" name="badge_id">
        <?php foreach ($data['badges'] as $badge) { ?>
          <option value="<?= $badge['badge_id']; ?>"> <?= $badge['badge_title']; ?></option>
        <?php } ?>
      </select>
      <input type="hidden" name="user_id" id="post_id" value="<?= $data['user']['user_id']; ?>">
    </div>
    <input type="submit" class="button block br-rd5 mb15 white" name="submit" value="<?= Translate::get('add'); ?>" />
  </form>
</main>