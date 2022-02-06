<?php
$topic = $data['topic'] ?? null;
if ($topic) { ?>

  <p>
    <?= num_word($data['count'], Translate::get('num-website'), false); ?>: <?= $data['count']; ?>
    <span class="right mr30">
      <a class="<?php if ($data['sheet'] == 'web.all') { ?>bg-gray-100 p5 gray-600 <?php } ?>mr20" href="<?= getUrlByName('web.dir.all', ['slug' => $topic['facet_slug']]); ?>">
        <?= Translate::get('by.date'); ?>
      </a>
      <a class="<?php if ($data['sheet'] == 'web.top') { ?>bg-gray-100 p5 gray-600 <?php } ?>" href="<?= getUrlByName('web.dir.top', ['slug' => $topic['facet_slug']]); ?>">
        TOP
      </a>
    </span>
  </p>

<?php } else { ?>
  <p>
    <?= num_word($data['count'], Translate::get('num-website'), false); ?>: <?= $data['count']; ?>
    <span class="right mr30">
      <a class="<?php if ($data['sheet'] == 'web.all') { ?>bg-gray-100 p5 gray-600 <?php } ?>mr20" href="<?= getUrlByName('web.all'); ?>">
        <?= Translate::get('by.date'); ?>
      </a>
      <a class="<?php if ($data['sheet'] == 'web.top' || $data['sheet'] == 'web') { ?>bg-gray-100 p5 gray-600 <?php } ?>" href="<?= getUrlByName('web.top'); ?>">
        TOP
      </a>
    </span>
  </p>
<?php } ?>