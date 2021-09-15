<div class="wrap">
  <main class="admin">
    <div class="white-box pt5 pr15 pb5 pl15">
      <a class="right" title="<?= lang('Add'); ?>" href="/space/add">
        <i class="icon-plus middle"></i>
      </a>
      <?= breadcrumb('/admin', lang('Admin'), null, null, lang('Spaces'));
      $pages = array(
        array('id' => 'spaces', 'url' => '/admin/spaces', 'content' => lang('All')),
        array('id' => 'spaces-ban', 'url' => '/admin/spaces/ban', 'content' => lang('Banned')),
      );
      echo returnBlock('tabs_nav', ['pages' => $pages, 'sheet' => $data['sheet'], 'user_id' => $uid['user_id']]);
      ?>

      <?php if (!empty($data['spaces'])) { ?>
        <table>
          <thead>
            <th>Id</th>
            <th><?= lang('Logo'); ?></th>
            <th><?= lang('Info'); ?></th>
            <th>Ban</th>
            <th><?= lang('Action'); ?></th>
          </thead>
          <?php foreach ($data['spaces'] as $key => $sp) { ?>
            <tr>
              <td class="center">
                <?= $sp['space_id']; ?>
              </td>
              <td class="center">
                <?= spase_logo_img($sp['space_img'], 'max', $sp['space_slug'], 'ava-64'); ?>
              </td>
              <td class="size-13">
                <a class="size-21" title="<?= $sp['space_name']; ?>" href="<?= getUrlByName('space', ['slug' => $sp['space_slug']]); ?>">
                  <?= $sp['space_name']; ?> (s/<?= $sp['space_slug']; ?>)
                </a>
                <sup>
                  <?php if ($sp['space_type'] == 1) {  ?>
                    <span class="red"><?= lang('official'); ?></span>
                  <?php } else { ?>
                    <?= lang('All'); ?>
                  <?php } ?>
                </sup>
                <div class="content-telo">
                  <?= $sp['space_description']; ?>
                </div>
                <?= $sp['space_date']; ?>
                <span class="mr5 ml5"> &#183; </span>
                <?= user_avatar_img($sp['user_avatar'], 'small', $sp['user_login'], 'ava'); ?>
                <a target="_blank" rel="noopener" href="<?= getUrlByName('user', ['login' => $sp['user_login']]); ?>">
                  <?= $sp['user_login']; ?>
                </a>
              </td>
              <td class="center">
                <?php if ($sp['space_is_delete']) { ?>
                  <span class="type-ban" data-type="space" data-id="<?= $sp['space_id']; ?>">
                    <span class="red"><?= lang('Unban'); ?></span>
                  </span>
                <?php } else { ?>
                  <span class="type-ban" data-type="space" data-id="<?= $sp['space_id']; ?>">
                    <?= lang('Ban it'); ?>
                  </span>
                <?php } ?>
              </td>
              <td class="center">
                <a title="<?= lang('Edit'); ?>" href="/space/edit/<?= $sp['space_id']; ?>">
                  <i class="icon-pencil size-15"></i>
                </a>
              </td>
            </tr>
          <?php } ?>
        </table>
        * <?= lang('Ban-space-info-posts'); ?>...
      <?php } else { ?>
        <?= returnBlock('no-content', ['lang' => 'No']); ?>
      <?php } ?>
    </div>
    <?= pagination($data['pNum'], $data['pagesCount'], $data['sheet'], '/admin/spaces'); ?>
  </main>
</div>