<?php

define('SPELL_TARGET_OPPONENT',  1);
define('SPELL_TARGET_SELF',      2);
define('SPELL_TARGET_ALLY',      3);



    // Init ------------------------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    
    // Apply bufs ------------------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    
    // Recalc ----------------------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    
    // Add some bonus (from user structure) ----------------------------------->
    // ------------------------------------------------------------------------>


    // magic ------------------------------------------------------------------>
    // $activate_magic = player_active_magic($p1, $cur_log, $params); // Select magic
    // if( $activate_magic ) magic_simphony($p1, $pls, $grp, $cur_log, $params);    
    // ------------------------------------------------------------------------>
    

    // Hit example ------------------------------------------------------------>
    // ------------------------------------------------------------------------>

    
    // Unset bufs ------------------------------------------------------------->
    // ------------------------------------------------------------------------>

function magic_fire($magic, $skill = array()){
    
    $cur = array();
    $school = 'fire';
    
    $cur['id']   = 'fire_1';
    $cur['name'] = 'Огонёк';
    $cur['dmg_min'] = 1;
    $cur['dmg_max'] = 4;
    $cur['target']  = 1;
    $cur['chance']  = 0.1;
    $cur['weight']  = 0.1;
    
    
    $keys = array_keys($cur);
    $ci = count($keys);
    for( $i = 0; $i < $ci; $i++ ){
        
        $key = $keys[$i];
        
        if( isset($skill[$school][$key]) ) $cur[$key] += $skill[$school][$key];
        
    }
    
    // if( isset($skils['fire']) )
    
}


// p1 - needs if skills affects spells
// magic.target - target count, that affects selected spell 
// magic.target_type - type of targets 
// magic.target_type = 1 - opponent
// magic.target_type = 2 - self
// magic.target_type = 3 - ally
// magic.spell_type - what to do with spell
// magic.spell_type = 'dmg' - dmg (hp) to player
// magic.spell_type = 'buf' - stat increase
// magic.duration  - will placed in bufs (duration battle rounds)
// magic.effects   - will placed in bufs (duration battle rounds)
// magic.weight    - spell weight (more chance spell will be selected) always selected 1 on all known
// magic.chance    - chance to activate spell
// magic.school    - chool of magic - some sort of type, will be used for resist (for sort spells by type)
// magic.name      - name of spell
// magic.multiply  - how many time to take roll
// magic.dmg       - static dmg will be added to
function player_magic_fill($p1){
    
    $tpl = array(); // defaul template
    $tpl['dmg_min'] = 1;
    $tpl['dmg_max'] = 4;
    $tpl['dmg+']    = 0;
    $tpl['multiply'] = 1;
    $tpl['target']  = 1;
    $tpl['chance']  = 0.1;
    $tpl['weight']  = 0.1;
    $tpl['spell_type'] = 'dmg';
    $tpl['mp'] = 5;


    $magic = array();
    
    $tmp = $tpl;
    $tmp['id'] = 'fire';
    $tmp['school'] = 'fire';
    $tmp['name'] = 'Огонёк';
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 4;
    $magic[] = $tmp;
    
    $tmp = $tpl;
    $tmp['id'] = 'flame';
    $tmp['school'] = 'fire';
    $tmp['name'] = 'Пламя';
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 4;
    $tmp['multiply'] = 2;
    // $magic[] = $tmp;
    
    $tmp = $tpl;
    $tmp['id'] = 'fire_flash';
    $tmp['school'] = 'fire';
    $tmp['name'] = 'Пламя';
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 4;
    $tmp['multiply'] = 3;
    // $magic[] = $tmp;
    
    $tmp = $tpl;
    $tmp['id'] = 'flame';
    $tmp['school'] = 'fire';
    $tmp['name'] = 'Пламя';
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 4;
    // $magic[] = $tmp;
    
    
    $tmp = $tpl;
    $tmp['id'] = 'water';
    $tmp['name'] = 'Ледянное прикосновение';
    $tmp['school']  = 'water';
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 4;
    $tmp['target']  = 1;
    $tmp['chance']  = 0.1;
    $tmp['weight']  = 0.1;
    // $magic[] = $tmp;
    
    $tmp = $tpl;
    $tmp['id'] = 'ice_needle';
    $tmp['name'] = 'Лёдeная игла';
    $tmp['school']  = 'water';
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 4;
    $tmp['multiply'] = 3;
    $tmp['target']  = 1;
    $tmp['chance']  = 0.1;
    $tmp['weight']  = 0.1;
    // $magic[] = $tmp;

    $tmp = $tpl;
    $tmp['id'] = 'poison';
    $tmp['school'] = 'water'; // water or dark
    $tmp['name'] = 'Яд';
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 2;
    $tmp['target']  = 1;
    $tmp['duration']  = 3;
    $tmp['chance']  = 0.1;
    $tmp['weight']  = 0.1;
    $magic[] = $tmp;
    
    $tmp = $tpl;
    $tmp['id'] = 'earth_shield';
    $tmp['school'] = 'earth';
    $tmp['name'] = 'Каменный щит';
    $tmp['effect']['ac'] = 2;
    $tmp['res'] = '+2 AC';
    $tmp['target']  = 1;
    $tmp['duration']  = 3;
    $tmp['chance']  = 0.1;
    $tmp['weight']  = 0.1;
    $magic[] = $tmp;
    
 
    $tmp = $tpl;
    $tmp['id'] = 'heal';
    $tmp['school'] = 'water';
    $tmp['name'] = 'Лечение';
    $tmp['target']  = 1;
    $tmp['chance']  = 0.1;
    $tmp['weight']  = 0.1;
    $tmp['dmg_min'] = 1;
    $tmp['dmg_max'] = 10;
    $magic[] = $tmp;
    
    return $magic;
}


?>
