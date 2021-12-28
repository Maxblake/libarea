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
  <?php if ($data['reports']) { ?>
    <table>
      <thead>
        <th class="center">N</th>
        <th><?= Translate::get('avatar'); ?></th>
        <th><?= Translate::get('information'); ?></th>
        <th><?= Translate::get('saw'); ?></th>
      </thead>
      <?php foreach ($data['reports'] as $report) {  ?>
        <tr>
          <td class="center">
            <?= $report['report_id']; ?>
            </span>
          <td>
            <a class="gray" href="<?= getUrlByName('user', ['login' => $report['user']['user_login']]); ?>">
              <?= user_avatar_img($report['user']['user_avatar'], 'max', $report['user']['user_login'], 'w24 mr5'); ?>
              <?= $report['user']['user_login']; ?>
            </a>
          </td>
          <td>
            <div class="text-sm gray lowercase">
              <?= $report['report_type']; ?>
              <span class="mr5 ml5"> &#183; </span>
              <?= $report['date']; ?>
            </div>
            <div class="mt5">
              <a href="<?= $report['report_url']; ?>"><?= $report['report_url']; ?></a>
            </div>
          </td>
          <td class="center<?php if ($report['report_status'] == 0) { ?> bg-red-100<?php } ?>">
            <span class="report-status" data-id="<?= $report['report_id']; ?>">
              <i class="bi bi-record-circle gray text-2xl"></i>
            </span>
          </td>
        </tr>
      <?php } ?>
    </table>
  <?php } else { ?>
    <?= no_content(Translate::get('no users'), 'bi bi-info-lg'); ?>
  <?php } ?>
  <?= pagination($data['pNum'], $data['pagesCount'], null, getUrlByName('admin.reports')); ?>
</div>
</main>