<?php include TEMPLATE_DIR . '/header.php'; ?>
<main class="w-75">
    <div class="box-users">
        <h1><?= $data['h1']; ?></h1>
        <div class="all-users">
        <?php foreach($users as $ind => $user) { ?>
            <div class="column">
                <div class="user_card">
                    <div>
                        <a href="/u/<?= $user['login']; ?>">
                            <img class="gr small" alt="<?= $user['login']; ?>" src="/uploads/users/avatars/<?= $user['avatar']; ?>">
                        </a>
                    </div>
                    <div class="box-footer">
                    <a href="/u/<?= $user['login']; ?>"><?= $user['login']; ?></a>
                    <br>
                    <?php if($user['name']) { ?>
                       <small> <?= $user['name']; ?> </small>
                    <?php } else { ?>
                        
                    <?php } ?>
                    </div>
                </div>    
            </div>        
        <?php } ?>
        </div> 
    </div>
</main>
<aside>
    <?php if ($uid['id'] == 0) { ?>
        <?php include TEMPLATE_DIR . '/_block/login.php'; ?>
    <?php } else { ?>
        <?= lang('info_users'); ?>    
    <?php } ?>    
</aside>
<?php include TEMPLATE_DIR . '/footer.php'; ?>