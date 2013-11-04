<?php


function mt_frand(){
    return mt_rand() / mt_getrandmax();
}

// events
$e = array();
// on_init - player contains only basic and default attributes

// Game config ---------------------------------------------------------------->
$game = array();
$game['rounds']     = 0;  // how many round to battle. 0 - to death
$game['round_hits'] = 10; // how many times players moves ( atomic round ) in each round
$game['dex_bonus']  = 0.1;
$game['crit'] = 0.05; // 5%
// ---------------------------------------------------------------------------->



// Fill basic player structure
function init_player($id = false){
    
    // Default values --------------------------------------------------------->
    $s = array();
    static $id = 1;
    $s['id']  = $id; // player id
    $s['dex'] = 0;   // dexterity
    $s['str'] = 0;   // srtength
    $s['con'] = 0;   // constitution
    $s['end'] = 0;   // endurance
    $s['int'] = 0;   // intelect
    
    $s['acc'] = 1;   // accuracy, default 100%
    $s['eva'] = 0.1; // evasion,  default 10%
    $s['dodge'] = 0; // dodge ??? 
    $s['block'] = 0.3; // block, default 30%
    
    $s['ref']  = 1; // reflex - evade traps
    $s['will'] = 1; // spell resistance
    $s['fort'] = 1; // Fortitude - physical resistance
    
    $s['st'] = 100; // stamina  
    $s['hp'] = 100; // health points
    $s['mp'] = 100; // mana points
    $s['ap'] = 100; // Action points
    // ------------------------------------------------------------------------>
    
    
    // Generate test player --------------------------------------------------->
    $points = 0; // make fair players - point to spend randomly
    if( $points ){
        
        $left = $points;
        $keys = array('dex', 'srt', 'con', 'end');
        $ci = count($keys);
        for( $i = 0; $i < $ci; $i++ ){
            $key = $keys[$i];
            $s[$key] = mt_rand(0, $left);  
            $left = $points - $s[$key];
        }
        
        // $s['dex'] = mt_rand(0, $left);  $left = $points - $s['dex'];
        // $s['str'] = mt_rand(0, $left);  $left = $points - $s['str'];
        // $s['con'] = mt_rand(0, $left);  $left = $points - $s['con'];
        // $s['end'] = mt_rand(0, $left);  $left = $points - $s['end'];
    }
    // ------------------------------------------------------------------------>
    
    if( $id ){ // Fill data from DB
        // TODO: later
    }
    
    // save basic values for logs and ui -------------------------------------->
    $s['base'] = $s;
    // ------------------------------------------------------------------------>
    
    
    // Calculate stat bonus and other not basic parametrs --------------------->
    $s['st']      += $s['end']*5;
    $s['hp']      += $s['con']*3;
    $s['dmg']     = 4 + floor($s['str']/5); // Max damage
    $s['dmg+']    = floor($s['str']/3); // bonus damage
    
    $s['fort'] += floor($s['con']/5);
    $s['ref']  += floor($s['dex']/5);
    $s['will'] += floor($s['int']/5);
    
    $s['hp_max'] = $s['hp'];
    // ------------------------------------------------------------------------>
    
    
    // Event on_init ---------------------------------------------------------->
    // Hm, player feature bonus?
    // + item bonus (only that work always)
    // ------------------------------------------------------------------------>
    
    return $s;
}

$pls = array();
$pls[] = init_player();
$pls[] = init_player();

$p1 = $p2 = $pls[0];
$p1['dex'] = 5;
$p2['dex'] = 8;
// if p1 hits p2 =>


// Group, Multihits ----------------------------------------------------------->
// if group fight - select opponent
// if multi hits  - select opponents and roll for all
// if all enemies - roll for all opponents
// if all         - enemies and allies

// tricky - mass hit - is 1 hit for all
// multi hit - multi hit (many hits for 1 or several opponents)
// ---------------------------------------------------------------------------->
// player_id -> index in $pls
$hit_targets[] = 0;

$action = 1;


$ci = count($hit_targets);
for( $i = 0; $i < $ci; $i++ ){

    switch( $action ){
        case 1:  player_hit($p1, $hit_targets[$i], $log);
    }
}


// // $p1 hits $p2 - only 1 hit!
function player_hit(&$p1, &$p2, &$log = array()){

    // Hit example ---------------------------------------------------------------->
    // min accuracity  10% - 15%
    $dex_bonus = 0.02;
    $dif = abs($p1['dex']-$p2['dex']) * $dex_bonus; // 1 dex = 1% accuracy/evasion

    $p1['acc'] += $dif; // change p1 acc

    $hit_chance = $p1['acc'] - $p2['eva']; // float 0,02356 
    
    $hit = mt_frand();
    $block = mt_frand();

    if( $hit_chance >= $hit ){
        // Ok, player hitted his targer, now, opponent action
        
        if( $p2['block'] >= $block ){ // opponent have blocked that hit!
            // hit to block - to stamina and hp?
            // Block decreases damage
            $log[] = 'blocked';
        }
        else{ // opponent haven`t blocked
            
            
            $dmg = mt_rand(5+floor($p1['str']), 10+$p1['str']);
            $p2['hp'] -= $dmg;
            $log[] = 'hit for ' . $dmg;
            // it`s dirrect hit to hp
            // calc damage
        }
    }
    else $log[] = 'miss';
    // ---------------------------------------------------------------------------->

    return true;
}


function battle(&$p1, &$p2, &$log = array()){

    $game['rounds'] = false;
    // Battle --------------------------------------------------------------------->
    if( $game['rounds'] ) $counter = $game['rounds'];
    while( 1 ){ // yes, always!
        

        player_hit($p1, $p2, $log);
        player_hit($p2, $p1, $log);
        
        // for( $i = 0; $i < $game['round_hits']; $i++ ){
            
        // }
        
        
        // End condition --------------------------------------------------------->>
        if( $game['rounds'] ){
            $counter--;
            if( $counter <= 0 ) break; // Round 0 - end of battle
        }
        else{
            if( $p1['hp'] < 1 || $p2['hp'] < 1 ) break;
        }
        // ----------------------------------------------------------------------->>
    }
    // ---------------------------------------------------------------------------->

    d_echo('end of battle');
}




// qdm_one_hit()
//   creates log - rolls, checks. statistic
// parameters:
//   $p1 - array - attacker
//   $p2 - array - defender
//   $grp - array - player groups
//   $players - array - all playres in battle
//   $file - array - log structure will be written there
// return:
//
// notes:
//  -
function qdm_one_hit(&$p1, &$grp, &$pls, &$file){

    $msg    = array();
    $struct = array();
    $msg    = msg_fill($msg);
    $cfg    = qdm_config();
    $skills = &$p1['skills'];
    $index  = $p1['index'];



    $players = $pls; // !!! nedd p2 by link, but no players

    $op_index = qdm_find_opponent($players, $grp, $index); // Now we must find opponent
    $p2 = &$pls[$op_index];

    $defense   = $cfg['base_armor'] + $cfg['armors'][$p2['armor']]['ac'];
    $weapon_id = $p1['weapon'];

    $dmg = mt_rand(1, $cfg['weapons'][$weapon_id]['dmg']);
    $hit = mt_rand(1, 20);

    $struct['d_hit'] = $hit;
    $struct['d_dmg'] = $dmg;
    $struct['d_def'] = $defense;

    $b_atk = $p1['atk'] + $p1['bonus']['atk'];
    $b_dmg = $p1['dmg'];
    $b_def = $p2['bonus']['def'];


    // Weapon skill damage bonus
    if( isset($skills[$weapon_id]) && isset($skills[$weapon_id]['wep_dmg']) ){
        $dmg   += $skills[$weapon_id]['wep_dmg'];
        $b_dmg += $skills[$weapon_id]['wep_dmg'];
    }
    // Weapon skill atk bonus
    if( isset($skills[$weapon_id]) && isset($skills[$weapon_id]['wep_atk']) ){
        $hit    += $skills[$weapon_id]['wep_atk'];
        $b_atk += $skills[$weapon_id]['wep_atk'];
    }
    
    // TODO: add weapon skills!
    // Create structure for log
    $struct['p1']  = $p1['index'];
    $struct['p2']  = $p2['index'];
    $struct['d_hit+'] = $b_atk;
    $struct['d_dmg+']   = $b_dmg;
    $struct['crit_mod'] = $cfg['weapons'][$p1['weapon']]['crit'];

    $del = ' ';
    $eva = 0;

    // TODO: add shield
    $defense   = $cfg['base_armor'] + $cfg['armors'][$p2['armor']]['ac'] + $p2['nat_armor'] + $p2['dodge'] + $b_def;    // full def (eveision)
    $block_def = $cfg['base_armor'] + $cfg['armors'][$p2['armor']]['ac'] + $p2['nat_armor'];                   // armor def
    $miss_def  = $cfg['base_armor']  + $p2['nat_armor']; // base def
    $struct['opp_def']  = $defense . '/' . $block_def . '/' . $miss_def;

    $dmg  = $dmg + $b_dmg; // add bonus

    $crit = qdm_battle_check_crit($hit, $p1, $dmg, $defense);
    if( $crit ){
        
        $p1['stat']['crit_count']++;
        if( $dmg > $p1['stat']['crit_dmg'] ) $p1['stat']['crit_dmg'] = $dmg; // max crit
        $log_dmg = $dmg;
        $struct['crit'] = 1;
    }
    else $struct['crit'] = 0; 
    
    $hit  = $hit + $b_atk; // add bonus to hit
    //if( $player['skill'] == $player['weapon'] ){ $hit++; }                      // weapon skill

    if( $hit >= $defense ){
        // d_debug(1, 'Hit for -'.$dmg.' ('.$p2['hp'].'/'.$p2['max_hp'].')');
        $p2['hp'] = $p2['hp'] - $dmg;
        $p1['stat']['dmg']     += $dmg;
        $p2['stat']['hp_lost'] += $dmg;
        $struct['dmg']  = $dmg;
        $msg_max_hit  = count($msg['hit'])-1;
        $msg_max_crit = count($msg['crit'])-1;

        if( $crit )  $struct['msg'] = mt_rand(0, $msg_max_crit); 
        else         $struct['msg'] = mt_rand(0, $msg_max_hit); 

        $p1['stat']['hits']++;
    }
    else{ // miss

        if( $hit <= $miss_def ){
            // Total miss
            $p1['stat']['miss']++;
            $struct['dmg'] = -1;
        }
        elseif( $hit <= $block_def ){
            // Enemy blcked attack
            $p2['stat']['block']++;
            $struct['dmg'] = -2;
        }
        else{ // enemy evaded attack
            $p2['stat']['eva']++;
            $struct['dmg'] = -3;
        }

        $msg_max_miss  = count($msg['miss'])-1;
        $struct['msg'] = mt_rand(0, $msg_max_miss);
    }


    // Count kills 
    if( $p2['hp'] < 1 ){ 

        // d_debug($p2, 'Dead ' . $p2['name']);
        // d_debug($grp, 'grp');
        $p1['kills'][] = $p2['index']; // frags
        $left = count($grp[$p2['team']]); // Last player in this team

        // Mark defeated player
        if( $left > 1 ){

            // find team index
            $player_index = array_search($p2['index'], $grp[$p2['team']]);

            // Unset defeated plyer from team
            unset($grp[$p2['team']][$player_index]);
            $grp[$p2['team']] = array_values($grp[$p2['team']]);

        }
        else unset($grp[$p2['team']]); // no players in team - remove team

        // tmp - need to remove or replace while-cicle continue
        unset($players[$p2['index']]);
    }

    $p2['stat']['defended']++;
    $p1['stat']['atacked']++;
    $struct['p2_hp']  = $p2['hp'];
    $struct['p2_max_hp']  = $p2['max_hp'];
    $struct['action'] = -1;

    $file[] = $struct;
} // qdm_log_hit

// qdm_battle_check_crit()
//   check critical for weapon
// parameters:
//   $hit - without mod
//   $weapon - weapon type
//   $dmg - damage value
//   $opp_defense - opponent defense
// return:
//   true/false (if true it will owerwrite damage value)
// notes:
//  -
function qdm_battle_check_crit($hit, $player, &$dmg, $opp_defense){

    $cfg = qdm_config();
    
    $crit_range = $cfg['weapons'][$player['weapon']]['crit_range'];
    // Crit in %
    // Base crit 5%

    if( $hit >= $crit_range && $hit+$player['atk'] >= $opp_defense || $hit == 20 ){
        $confirm = mt_rand(1, 20);
        if( $confirm >= $opp_defense ){

            $dmg = $dmg * $cfg['weapons'][$player['weapon']]['crit'];
            return true;
        }
    }
    return false;
}
 
?>
