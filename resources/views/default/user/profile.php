<?php include TEMPLATE_DIR . '/header.php'; ?>

<?php if ($user['user_cover_art'] != 'cover_art.jpeg') { ?>
  <div class="profile-box-cover" style="background-image: url(<?= user_cover_url($user['user_cover_art']); ?>); background-position: 50% 50%;">
    <div class="wrap">
    <?php } else { ?>
      <style nonce="<?= $_SERVER['nonce']; ?>">
        .profile-box {
          background: <?= $user['user_color']; ?>;
          min-height: 90px;
        }
      </style>
      <div class="profile-box">
        <div class="wrap">
        <?php } ?>
        <?php if ($uid['user_id'] > 0) { ?>
          <div class="profile-header">
            <?php if ($uid['user_login'] != $user['user_login']) { ?>
              <?php if ($button_pm === true) { ?>
                <a class="right pm" href="/u/<?= $user['user_login']; ?>/mess">
                  <i class="icon-mail"></i>
                </a>
              <?php } ?>
            <?php } else { ?>
              <a class="right pm" href="/u/<?= $uid['user_login']; ?>/setting">
                <i class="icon-pencil size-21"></i>
              </a>
            <?php } ?>
          </div>
        <?php } ?>
        <div class="profile-ava">
          <?= user_avatar_img($user['user_avatar'], 'max', $user['user_login'], 'ava'); ?>
        </div>
        </div>
      </div>

      <div class="wrap">
        <main>
          <div class="profile-box-telo hidden white-box">
            <div class="pt5 pr15 pb5 pl15">

              <div class="profile-header-telo">
                <h1 class="profile">
                  <?= $user['user_login']; ?>
                  <?php if ($user['user_name']) { ?> / <?= $user['user_name']; ?><?php } ?>
                </h1>
              </div>

              <div class="left mt10 stats<?php if ($user['user_cover_art'] == 'cover_art.jpeg') { ?> no-cover<?php } ?>">
                <?php if ($user['user_ban_list'] == 0) { ?>
                  <?php if ($data['posts_count'] > 0) { ?>
                    <div class="mb5 size-15">
                      <label class="required"><?= lang('Posts-m'); ?>:</label>
                      <span class="right">
                        <a title="<?= lang('Posts-m'); ?> <?= $user['user_login']; ?>" href="/u/<?= $user['user_login']; ?>/posts">
                          <?= $data['posts_count']; ?>
                        </a>
                      </span>
                    </div>
                  <?php } ?>
                  <?php if ($data['answers_count'] > 0) { ?>
                    <div class="mb5 size-15">
                      <label class="required"><?= lang('Answers'); ?>:</label>
                      <span class="right">
                        <a title="<?= lang('Answers'); ?> <?= $user['user_login']; ?>" href="/u/<?= $user['user_login']; ?>/answers">
                          <?= $data['answers_count']; ?>
                        </a>
                      </span>
                    </div>
                  <?php } ?>
                  <?php if ($data['comments_count'] > 0) { ?>
                    <div class="mb5 size-15">
                      <label class="required"><?= lang('Comments'); ?>:</label>
                      <span class="right">
                        <a title="<?= lang('Comments'); ?> <?= $user['user_login']; ?>" href="/u/<?= $user['user_login']; ?>/comments">
                          <?= $data['comments_count']; ?>
                        </a>
                      </span>
                    </div>
                  <?php } ?>

                  <?php if ($data['spaces_user']) { ?>
                    <div class="uppercase mb5 mt15 size-13"><?= lang('Created by'); ?></div>
                    <span class="d">
                      <?php foreach ($data['spaces_user'] as  $space) { ?>
                        <div class="mt5 mb5">
                          <a class="bar-space-telo flex relative pt5 pb5 hidden gray" href="/s/<?= $space['space_slug']; ?>">
                            <?= spase_logo_img($space['space_img'], 'small', $space['space_name'], 'space-logo mr5'); ?>
                            <span class="bar-name size-13"><?= $space['space_name']; ?></span>
                          </a>
                        </div>
                      <?php } ?>
                    </span>
                  <?php } ?>
                <?php } else { ?>
                  ...
                <?php } ?>
              </div>

              <div class="box profile-telo left">
                <div class="mb20">
                  <blockquote>
                    <?= $user['user_about']; ?>...
                  </blockquote>
                </div>
                <div class="mb20">
                  <i class="icon-calendar middle"></i>
                  <span class="middle">
                    <span class="ts"><?= $user['user_created_at']; ?></span> —
                    <?= $data['user_trust_level']['trust_name']; ?> <sup class="date">TL<?= $user['user_trust_level']; ?></sup>
                  </span>
                </div>
                <h2 class="mb5 uppercase pt15 size-13"><?= lang('Contacts'); ?></h2>
                <?php if ($user['user_website']) { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('URL'); ?>:</label>
                    <a href="<?= $user['user_website']; ?>" rel="noopener nofollow ugc">
                      <span class="mr5 ml5"><?= $user['user_website']; ?></span>
                    </a>
                  </div>
                <?php } ?>
                <?php if ($user['user_location']) { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('City'); ?>:</label>
                    <span class="mr5 ml5"><?= $user['user_location']; ?></span>
                  </div>
                <?php } else { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('City'); ?>:</label>
                    <span class="mr5 ml5">...</span>
                  </div>
                <?php } ?>
                <?php if ($user['user_public_email']) { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('E-mail'); ?>:</label>
                    <a href="mailto:<?= $user['user_public_email']; ?>" rel="noopener nofollow ugc">
                      <span class="mr5 ml5"><?= $user['user_public_email']; ?></span>
                    </a>
                  </div>
                <?php } ?>
                <?php if ($user['user_skype']) { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('Skype'); ?>:</label>
                    <a class="mr5 ml5" href="skype:<?= $user['user_skype']; ?>" rel="noopener nofollow ugc">
                      <span class="mr5 ml5"><?= $user['user_skype']; ?></span>
                    </a>
                  </div>
                <?php } ?>
                <?php if ($user['user_twitter']) { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('Twitter'); ?>:</label>
                    <a href="https://twitter.com/<?= $user['user_twitter']; ?>" rel="noopener nofollow ugc">
                      <span class="mr5 ml5"><?= $user['user_twitter']; ?></span>
                    </a>
                  </div>
                <?php } ?>
                <?php if ($user['user_telegram']) { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('Telegram'); ?>:</label>
                    <a href="tg://resolve?domain=<?= $user['user_telegram']; ?>" rel="noopener nofollow ugc">
                      <span class="mr5 ml5"><?= $user['user_telegram']; ?></span>
                    </a>
                  </div>
                <?php } ?>
                <?php if ($user['user_vk']) { ?>
                  <div class="boxline">
                    <label for="name"><?= lang('VK'); ?>:</label>
                    <a href="https://vk.com/<?= $user['user_vk']; ?>" rel="noopener nofollow ugc">
                      <span class="mr5 ml5"><?= $user['user_vk']; ?></span>
                    </a>
                  </div>
                <?php } ?>

                <?php if ($user['user_my_post'] != 0) { ?>
                  <h3 class="mb5 uppercase pt15 size-13"><?= lang('Selected Post'); ?></h3>

                  <div class="post-body mb15">
                    <a class="title" href="/post/<?= $onepost['post_id']; ?>/<?= $onepost['post_slug']; ?>">
                      <?= $onepost['post_title']; ?>
                    </a>

                    <div class="size-13 lowercase">
                      <a class="gray" href="/u/<?= $user['user_login']; ?>">
                        <?= user_avatar_img($user['user_avatar'], 'small', $user['user_login'], 'ava'); ?>
                        <span class="mr5 ml5"></span>
                        <?= $user['user_login']; ?>
                      </a>

                      <span class="mr5 ml5"> &#183; </span>
                      <span class="gray"><?= $onepost['post_date'] ?></span>

                      <span class="mr5 ml5"> &#183; </span>
                      <a class="gray" href="/s/<?= $onepost['space_slug']; ?>" title="<?= $onepost['space_name']; ?>">
                        <?= $onepost['space_name']; ?>
                      </a>

                      <?php if ($onepost['post_answers_count'] != 0) { ?>
                        <a class="gray right" href="/post/<?= $onepost['post_id']; ?>/<?= $onepost['post_slug']; ?>">
                          <span class="mr5 ml5"></span>
                          <i class="icon-comment-empty middle"></i>
                          <?= $onepost['post_answers_count']; ?>
                        </a>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </main>
        <aside>
          <div class="profile-box-telo relative white-box">
            <div class="pt5 pr15 pb5 pl15">
              <h3 class="mt0 mb5 uppercase pt10 size-13"><?= lang('Badges'); ?></h3>
              <div class="profile-badge">
                <?php if ($user['user_id'] < 50) { ?>
                  <i title="<?= lang('Joined in the early days'); ?>" class="icon-award green"></i>
                <?php } ?>
                <?php foreach ($data['badges'] as $badge) { ?>
                  <?= $badge['badge_icon']; ?>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php if ($uid['user_trust_level'] > 4) { ?>
            <div class="profile-box-telo white-box">
              <div class="pt5 pr15 pb5 pl15">
                <h3 class="mt0 mb10 uppercase pt10 size-13"><?= lang('Admin'); ?></h3>
                <div class="mb5">
                  <a class="gray size-15 mb5 block" href="/admin/users/<?= $user['user_id']; ?>/edit">
                    <i class="icon-cog-outline middle"></i>
                    <span class="middle"><?= lang('Edit'); ?></span>
                  </a>
                  <a class="gray size-15 block" href="/admin/badges/user/add/<?= $user['user_id']; ?>">
                    <i class="icon-award middle"></i>
                    <span class="middle"><?= lang('Reward the user'); ?></span>
                  </a>
                  <hr>
                  <span class="gray">id<?= $user['user_id']; ?> | <?= $user['user_email']; ?></span>
                </div>
              </div>
            </div>
          <?php } ?>
        </aside>
      </div>
      <?php include TEMPLATE_DIR . '/footer.php'; ?>