<?php if (!empty($flows)) { ?> 

    <?php foreach ($flows as  $flow) { ?>
 
        <div class="flow-telo
            <?php if($flow['flow_is_delete'] == 1) { ?> dell<?php } ?>
            <?php if($uid['trust_level'] ==5) { ?> block<?php } ?>">
        
            <?php if($uid['trust_level'] == 5) { ?>
                <span id="cm_dell" class="right">
                    <a data-flow="<?= $flow['flow_id']; ?>" class="del-flow">
                        <small>
                            <?php if($flow['flow_is_delete'] == 1) { ?>
                                <?= lang('Recover'); ?> 
                            <?php } else { ?>
                                <span class="red"><?= lang('Remove'); ?></spam>
                            <?php } ?>
                        </small>
                    </a>
                </span>
            <?php } ?>

            <?php if($flow['flow_action_type'] == 'add_chat') { ?>
                <div class="v-ots"></div> 
                <div class="comm-header">
                     <img class="avatar" src="<?= user_avatar_url($flow['avatar'], 'small'); ?>">
                    <span class="user"> 
                         <a href="/u/<?= $flow['login']; ?>"><?= $flow['login']; ?></a> 
                    </span> 
                    <span class="date">
                        <?= $flow['flow_pubdate']; ?> 
                    </span>
                </div>  
                <div class="flow-telo">
                    <?= $flow['flow_content']; ?>
                </div>  
            <?php } elseif ($flow['flow_action_type'] == 'add_comment') { ?>
                <div class="flow-comment">
                    <i class="icon bubbles"></i>
                    <div class="box">
                        <img class="avatar" src="<?= user_avatar_url($flow['avatar'], 'small'); ?>">
                        <span class="user"> 
                            <a href="/u/<?= $flow['login']; ?>"><?= $flow['login']; ?></a> 
                        </span> 
                        <span class="date">
                            <?= $flow['flow_pubdate']; ?> 
                        </span>
                          — <a href="<?= $flow['flow_url']; ?>"><?= lang($flow['flow_action_type']); ?>...</a>
                    </div>
                </div>
            <?php } elseif ($flow['flow_action_type'] == 'add_answer') { ?>
                <div class="flow-answer">
                    <i class="icon action-undo"></i>
                    <div class="box">
                        <img class="avatar" src="<?= user_avatar_url($flow['avatar'], 'small'); ?>">
                        <span class="user"> 
                            <a href="/u/<?= $flow['login']; ?>"><?= $flow['login']; ?></a> 
                        </span> 
                        <span class="date">
                            <?= $flow['flow_pubdate']; ?> 
                        </span>
                          — <a href="<?= $flow['flow_url']; ?>"><?= lang($flow['flow_action_type']); ?>...</a>
                    </div>
                </div>
            <?php } else { ?>

            <?php } ?>
            
        </div>
    <?php } ?> 

<?php } else { ?> 

    <div class="no-content"><?= lang('no-post'); ?>...</div>

<?php } ?> 
        
