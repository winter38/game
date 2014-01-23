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
                'dex'  => 1,
            );
    $l[4] = array(
                'dex'   => 1,
                'block' => 0.05,
            );
    $l[5] = array(
                'dex'   => 2,
                'crit'  => 0.1,
                'ref'   => 1,
            );
    // ------------------------------------------------------------------------>
}


function skill_raiper_mastery(){
    
    $s = array();
    
    // Requirements ----------------------------------------------------------->
    // What need to get this skill - level, other skill, stat?
    // ------------------------------------------------------------------------>
    
    // Skill Name, description ------------------------------------------------>
    $s['id']    = 'raiper_mastery';
    $s['name']  = 'Владение рапирой';
    $s['descr'] = 'Рапира?';
    // ------------------------------------------------------------------------>
    
    // Skill initial bonus ---------------------------------------------------->
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
                'dex' => 2,
            );
    $l[4] = array(
                'acc' => 0.01,
            );
    $l[5] = array(
                'dex' => 5,
                'ref' => 1,
                'crit' => 0.01,
            );
    // ------------------------------------------------------------------------>


}


function skill_short_sword_mastery(){
    
    $s = array();
    
    // Requirements ----------------------------------------------------------->
    // What need to get this skill - level, other skill, stat?
    // ------------------------------------------------------------------------>
    
    // Skill Name, description ------------------------------------------------>
    $s['id']    = 'short_sword_mastery';
    $s['name']  = 'Владение мечем';
    $s['descr'] = 'Умение обращатся с мечем';
    // ------------------------------------------------------------------------>
    
    // Skill initial bonus ---------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    // Skill levels and their bonus ------------------------------------------->
    $l = array();
    $l[1] = array(
                'w_dmg' => 1,
            );
    $l[2] = array(
                'acc' => 0.02,
            );
    $l[3] = array(
                'dex'  => 1,
                'srt'  => 1,
            );
    $l[4] = array(
                'con'   => 1,
                'block' => 0.02,
            );
    $l[5] = array(
                'dex'   => 1,
                'ref'   => 1,
                'fort'  => 1,
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
    // ------------------------------------------------------------------------>
    
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
                'fort' => 1,
                'acc' => 0.01,
            );
    // ------------------------------------------------------------------------>
}


function skill_bastard_mastery(){
    
    $s = array();
    
    // Requirements ----------------------------------------------------------->
    // What need to get this skill - level, other skill, stat?
    // ------------------------------------------------------------------------>
    
    // Skill Name, description ------------------------------------------------>
    $s['id']    = 'bastard_mastery';
    $s['name']  = 'Владение полуторным мечем';
    $s['descr'] = 'Он огромен!';
    // ------------------------------------------------------------------------>
    
    // Skill initial bonus ---------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    // Skill levels and their bonus ------------------------------------------->
    $l = array();
    $l[1] = array(
                'w_dmg' => 1,
            );
    $l[2] = array(
                'dex' => 1,
            );
    $l[3] = array(
                'w_dmg' => 1,
                'block' => 0.03,
            );
    $l[4] = array(
                'str' => 1,
                'acc' => 0.01,
            );
    $l[5] = array(
                'dmg' => 1,
                'con' => 1,
                'dex' => 1,
                'block' => 0.05,
            );
    // ------------------------------------------------------------------------>
}


function skill_poleaxe_mastery(){
    
    $s = array();
    
    // Requirements ----------------------------------------------------------->
    // What need to get this skill - level, other skill, stat?
    // ------------------------------------------------------------------------>
    
    // Skill Name, description ------------------------------------------------>
    $s['id']    = 'poleaxe_mastery';
    $s['name']  = 'Владение алебардой';
    $s['descr'] = 'Серкира!';
    // ------------------------------------------------------------------------>
    
    // Skill initial bonus ---------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    // Skill levels and their bonus ------------------------------------------->
    $l = array();
    $l[1] = array(
                'w_dmg' => 1,
            );
    $l[2] = array(
                'srt' => 1,
            );
    $l[3] = array(
                'con' => 1,
                'block' => 0.05,
            );
    $l[4] = array(
                'str' => 1,
                'acc' => 0.01,
            );
    $l[5] = array(
                'dmg' => 1,
                'con' => 1,
                'block' => 0.05,
            );
    // ------------------------------------------------------------------------>
}


?>