<?php



    // Init ------------------------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    
    // Apply bufs ------------------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    
    // Recalc ----------------------------------------------------------------->
    // ------------------------------------------------------------------------>
    
    
    // Add some bonus (from user structure) ----------------------------------->
    // ------------------------------------------------------------------------>


    // magic ------------------------------------------------------------------>
    $activate_magic = player_active_magic($p1, $cur_log, $params); // Select magic
    if( $activate_magic ) magic_simphony($p1, $pls, $grp, $cur_log, $params);    
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
        
        if( isset($skill[$school][$key] ) $cur[$key] += $skill[$school][$key];
        
    }
    
    if( isset($skils['fire']) )
    
}




function player_magic_fill(){
    
    
    $magic = array();
    $magic['fire']['id'] = 'fire_1';
    $magic['fire']['name'] = 'Огонёк';
    $magic['fire']['dmg_min'] = 1;
    $magic['fire']['dmg_max'] = 4;
    $magic['fire']['target']  = 1;
    $magic['fire']['chance']  = 0.1;
    $magic['fire']['weight']  = 0.1;

    $magic['ice']['id'] = 'ice_1';
    $magic['ice']['name'] = 'Лёд';
    $magic['ice']['dmg_min'] = 1;
    $magic['ice']['dmg_max'] = 4;
    $magic['ice']['target']  = 1;
    $magic['ice']['chance']  = 0.1;
    $magic['ice']['weight']  = 0.1;


    $magic['ice']['id'] = 'poison_1';
    $magic['ice']['name'] = 'Яд';
    $magic['ice']['dmg_min'] = 1;
    $magic['ice']['dmg_max'] = 2;
    $magic['ice']['target']  = 1;
    $magic['ice']['duration']  = 3;
    $magic['ice']['chance']  = 0.1;
    $magic['ice']['weight']  = 0.1;
    
    $magic['earth_shield']['id'] = 'poison_1';
    $magic['earth_shield']['name'] = 'Каменный щит';
    $magic['earth_shield']['effect']['ac'] = 2;
    $magic['earth_shield']['target']  = 0; // self!
    $magic['earth_shield']['duration']  = 3;
    $magic['earth_shield']['chance']  = 0.1;
    $magic['earth_shield']['weight']  = 0.1;
    
    
}


?>
