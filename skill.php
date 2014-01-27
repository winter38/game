<?php


// get list of skill - what player can see
function skill_list($p1){

    $list = array();

    skill_dagger_mastery($list, $p1);
    skill_raiper_mastery($list, $p1);
    skill_short_sword_mastery($list, $p1);
    skill_long_sword_mastery($list, $p1);
    skill_bastard_mastery($list, $p1);
    skill_poleaxe_mastery($list, $p1);

}


?>
