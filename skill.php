<?php

function skill_example(){

    // Requirements ----------------------------------------------------------->
    // What need to get this skill - level, other skill, stat?
    // ------------------------------------------------------------------------>
    
    // Skill Name, description ------------------------------------------------>
    // ------------------------------------------------------------------------>
    
    // Skill initial bonus ---------------------------------------------------->
    // Maybe
    // ------------------------------------------------------------------------>
    
    // What need to calc to get exp, level???
    // Maybe fight gives AP and divide among all active skills
    
    // Skill levels and their bonus ------------------------------------------->
    // Better all bonuses write to user structure - always +/- vals
    // Exteption active skills?
    // ------------------------------------------------------------------------>
    
}

function skill_dagger_mastery(){
    
    $s = array();
    
    // Requirements ----------------------------------------------------------->
    // What need to get this skill - level, other skill, stat?
    // ------------------------------------------------------------------------>
    
    // Skill Name, description ------------------------------------------------>
    $s['id']    = 'dagger_mastery';
    $s['name']  = 'Владение ножами';
    $s['descr'] = 'Умение обращатся с ножами';
    // ------------------------------------------------------------------------>
    
    // Skill initial bonus ---------------------------------------------------->
    // Maybe
    // ------------------------------------------------------------------------>
    
    // What need to calc to get exp, level???
    // Maybe fight gives AP and divide among all active skills
    
    // Skill levels and their bonus ------------------------------------------->
    $l = array();
    $l[1] = array(
                'w_dmg' => 1,
            );
    $l[2] = array(
                'acc' => 0.01,
            );
    $l[3] = array(
                'crit' => 0.05,
                'acc'  => 0.01,
            );
    $l[4] = array(
                'dex'   => 1,
                'block' => 0.05,
            );
    // ------------------------------------------------------------------------>
}


function skill_long_sword_mastery(){
    
    $s = array();
    
    // Requirements ----------------------------------------------------------->
    // What need to get this skill - level, other skill, stat?
    // ------------------------------------------------------------------------>
    
    // Skill Name, description ------------------------------------------------>
    $s['id']    = 'long_sword_mastery';
    $s['name']  = 'Владение длинным мечем';
    $s['descr'] = 'А меч действительно такой длинный как о нем говорят?';
    // ------------------------------------------------------------------------>
    
    // Skill initial bonus ---------------------------------------------------->
    // Maybe
    // ------------------------------------------------------------------------>
    
    // What need to calc to get exp, level???
    // Maybe fight gives AP and divide among all active skills
    
    // Skill levels and their bonus ------------------------------------------->
    $l = array();
    $l[1] = array(
                'w_dmg' => 1,
            );
    $l[2] = array(
                'acc' => 0.01,
            );
    $l[3] = array(
                'w_dmg' => 1,
            );
    $l[4] = array(
                'str' => 1,
            );
    $l[5] = array(
                'dmg' => 2,
            );
    // ------------------------------------------------------------------------>


}


?>
