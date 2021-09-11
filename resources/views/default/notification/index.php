<div class="wrap">
  <main class="white-box pt5 pr15 pb5 pl15">
    <a class="right size-13 button mt15 mb15" href="/notifications/delete"><?= lang('I read'); ?></a>
    <?= breadcrumb('/', lang('Home'), '/u/' . $uid['user_login'], lang('Profile'), lang('Notifications')); ?>

    <?php if (!empty($data['notifications'])) { ?>
      <?php foreach ($data['notifications'] as  $notif) { ?>

        <div class="border-bottom p5<?php if ($notif['notification_read_flag'] == 0) { ?> active-notif<?php } ?>">
          <?php if ($notif['notification_action_type'] == 1) { ?>
            <i class="icon-mail middle"></i>
            <a class="gray ml5" href="/u/<?= $notif['user_login']; ?>"><?= $notif['user_login']; ?></a>
            <?= lang('Wrote to you'); ?>
            <a href="/notifications/read/<?= $notif['notification_id']; ?>"><?= lang('Message'); ?></a>
          <?php } ?>

          <?php if ($notif['notification_action_type'] == 2) { ?>
            <?= lang('Wrote a post'); ?>
          <?php } ?>

          <?php if ($notif['notification_action_type'] == 3) { ?>
            <i class="icon-book-open middle"></i>
            <a class="gray ml5" href="/u/<?= $notif['user_login']; ?>">@<?= $notif['user_login']; ?></a>
            <a class="ntf2 lowercase" href="/notifications/read/<?= $notif['notification_id']; ?>">
              <?= lang('Replied to post'); ?>
            </a>
          <?php } ?>

          <?php if ($notif['notification_action_type'] == 10 || $notif['notification_action_type'] == 11 || $notif['notification_action_type'] == 12) { ?>
            <i class="icon-user-o middle"></i>
            <a class="gray ml5" href="/u/<?= $notif['user_login']; ?>">@<?= $notif['user_login']; ?></a>
            <?= lang('appealed to you'); ?>
            <a class="ntf2 lowercase" href="/notifications/read/<?= $notif['notification_id']; ?>">
              <?php if ($notif['notification_action_type'] == 10) { ?>
                <?= lang('in post'); ?>
              <?php } elseif ($notif['notification_action_type'] == 11) { ?>
                <?= lang('in answer'); ?>
              <?php } else { ?>
                <?= lang('in the comment'); ?>
              <?php } ?>
            </a>
          <?php } ?>
          <?php if ($notif['notification_action_type'] == 20) { ?>
            <i class="icon-warning-empty middle red"></i>
            <a class="gray ml5" href="/u/<?= $notif['user_login']; ?>"><?= $notif['user_login']; ?></a>
            <?= lang('complained about'); ?>
            <a class="ntf2 lowercase" href="/notifications/read/<?= $notif['notification_id']; ?>">
              <?= lang('Comment'); ?>
            </a>
          <?php } ?>
          <?php if ($notif['notification_action_type'] == 15) { ?>
            <a class="ntf2 lowercase" href="/notifications/read/<?= $notif['notification_id']; ?>">
              <i class="icon-lightbulb middle red"></i>
              <?= lang('Audit'); ?>
            </a>
            |
            <a class="ntf2 lowercase" href="/admin/users/<?= $notif['notification_sender_id']; ?>/edit">
              <?= $notif['user_login']; ?>
            </a>
            |
            <a class="ntf2 lowercase" href="/admin/audits">
              <?= lang('Admin'); ?>
            </a>
          <?php } ?>
          <span class="lowercase">
            <?php if ($notif['notification_action_type'] == 4) { ?>
              <i class="icon-commenting-o middle"></i>
              <a class="gray ml5" href="/u/<?= $notif['user_login']; ?>"><?= $notif['user_login']; ?></a>
              <?= lang('Wrote'); ?>
              <a class="ntf2" href="/notifications/read/<?= $notif['notification_id']; ?>">
                <?= lang('Comment'); ?>
              </a>
              <?= lang('to your answer'); ?>
            <?php } ?>
          </span>
          <span class="size-13 gray"> — <?= $notif['notification_add_time']; ?></span>
          <?php if ($notif['notification_read_flag'] == 0) { ?>&nbsp;<sup class="red">✔</sup><?php } ?>
        </div>
      <?php } ?>

    <?php } else { ?>
      <?= lang('No notifications yet'); ?>...
    <?php } ?>
  </main>
  <?= aside('lang', ['lang' => lang('info-notifications')]); ?>
</div>