<div class="wrap">
  <main class="admin">
    <div class="white-box pt5 pr15 pb5 pl15">
      <a class="right" title="<?= lang('Add'); ?>" href="/admin/webs/add">
        <i class="icon-plus middle"></i>
      </a>
      <?= breadcrumb('/admin', lang('Admin'), null, null, lang('Domains')); ?>

      <div class="domains">
        <?php if (!empty($data['domains'])) { ?>
          <?php foreach ($data['domains'] as $key => $link) { ?>
            <div class="domain-box">
              <span class="add-favicon right size-13" data-id="<?= $link['link_id']; ?>">
                +фавикон
              </span>
              <div class="size-21">
                <?php if ($link['link_title']) { ?>
                  <?= $link['link_title']; ?>
                <?php } else { ?>
                  Add title...
                <?php } ?>
              </div>
              <div class="content-telo">
                <?php if ($link['link_content']) { ?>
                  <?= $link['link_content']; ?>
                <?php } else { ?>
                  Add content...
                <?php } ?>
              </div>

              <div class="border-bottom mb15 mt5 pb5 size-13 hidden gray">
                <a class="green" rel="nofollow noreferrer" href="<?= $link['link_url']; ?>">
                  <?= favicon_img($link['link_id'], $link['link_url_domain']); ?>
                  <span class="green"><?= $link['link_url']; ?></span>
                </a> |
                id<?= $link['link_id']; ?>
                <span class="mr5 ml5"> &#183; </span>
                <?= $link['link_url_domain']; ?>

                <span class="mr5 ml5"> &#183; </span>
                <?php if ($link['link_is_deleted'] == 0) { ?>
                  active
                <?php } else { ?>
                  <span class="red">Ban</span>
                <?php } ?>
                <span class="mr5 ml5"> &#183; </span>
                <a href="/admin/webs/<?= $link['link_id']; ?>/edit"><?= lang('Edit'); ?></a>
                <span class="right heart-link red">
                  +<?= $link['link_count']; ?>
                </span>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <?= no_content('No'); ?>
        <?php } ?>
      </div>
    </div>
  </main>
</div>