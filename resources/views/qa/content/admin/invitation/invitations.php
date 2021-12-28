<div class="sticky mt5 top0 col-span-2 justify-between no-mob">
  <?= tabs_nav(
        'menu',
        $data['type'],
        $uid,
        $pages = Config::get('menu.admin'),
      ); ?>
</div>

<?= import(
  '/content/admin/menu',
  [
    'type'    => $data['type'],
    'sheet'   => $data['sheet'],
    'pages'   => []
  ]
); ?>

<div class="bg-white br-box-gray p15">
  <?php if (!empty($data['invitations'])) { ?>
    <?php foreach ($data['invitations'] as $key => $inv) { ?>
      <div class="content-telo mt5">
        <a href="<?= getUrlByName('user', ['login' => $inv['uid']['user_login']]); ?>">
          <?= $inv['uid']['user_login']; ?>
        </a>
        <sup>id<?= $inv['uid']['user_id']; ?></sup>
        =>
        <a href="<?= getUrlByName('user', ['login' => $inv['user_login']]); ?>">
          <?= $inv['user_login']; ?>
        </a>
        <sup>id<?= $inv['active_uid']; ?></sup>
        <span class="text-sm"> - <?= $inv['active_time']; ?></span>
      </div>
    <?php } ?>
  <?php } else { ?>
    <?= no_content(Translate::get('there are no comments'), 'bi bi-info-lg'); ?>
  <?php } ?>
</div>
</main>