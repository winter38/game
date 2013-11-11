<?php

include_once 'config.php';
inc_fl_lib('qdm.php');
inc_fl_lib('qdm/qdm_cfg.php');
inc_fl_lib('html.php');

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
$game['dex_bonus']  = 0.01;
$game['crit'] = 0.05; // 5%
// ---------------------------------------------------------------------------->



// Fot test ------------------------------------------------------------------->
$pls = array();
$pls[] = init_player();
$pls[] = init_player();

$p1 = $p2 = $pls[0];
$p1['dex'] = 10;
$p2['dex'] = 8;
$p1['name'] = 'player1';
$p2['name'] = 'player2';
$p1['index'] = 0;
$p2['index'] = 1;
$p1['team'] = 0;
$p2['team'] = 1;

$p2['id'] = 2;
$pls[0] = $p1;
$pls[1] = $p2;
// if p1 hits p2 =>

$grps = array(); // battle groups
$grp[0][] = 0;
$grp[1][] = 1;
// ---------------------------------------------------------------------------->


battle($pls, $grp);


// Full battle
function battle($pls, $grp){

    $log = array();
    $file = array();


    $file['header']['teams'] = $grp;
    // Sort by init, in reverse order ----------------------------------------->
    // this part can used, when there are many players  
    $init = players_initiative($pls);
    // ------------------------------------------------------------------------>
        
    // d_echo($pls);
    $while_counter = 0;
    $rounds_counter = 0;
    $ci = count($init);

    // will fight till one team left
    while( !qdm_battle_end($pls, $grp) ){

        $while_counter++;
        
        // Group bonus --------------------------------------------->
        // Group bonus goes to tmp bufs - so, when bufer dies - bonus will end
        // Applies every round
        // TODO
        // qdm_grp_bonus($grp, $players, $file);
        // --------------------------------------------------------->

        
        // Group attack -------------------------------------------->
        // TODO
        // --------------------------------------------------------->

        
        // Decide which action
        $ci = count($init);
        for( $i = 0; $i < $ci; $i++ ){ 
            
            $rounds_counter++;
            
            
            // One team left - end of battle
            if( count($grp) < 2 ) break;

            // Player hit order - index is player number in $pls array
            $string = strstr($init[$i], '_');
            $index  = substr($string, 1);

            if( $pls[$index]['hp'] < 1 ) continue; // skip dead players
            $p1 = &$pls[$index];



            // Trigger some skill action before hit --------------------------->
            // qdm_skill_second_breath($pls[$index], $grp, $pls, $file);
            // qdm_skill_intimidate($p1, $grp, $pls, $file);
            // ---------------------------------------------------------------->
            
            
            // Group, Multihits ----------------------------------------------->
            // if group fight - select opponent
            // if multi hits  - select opponents and roll for all
            // if all enemies - roll for all opponents
            // if all         - enemies and allies
            // tricky - mass hit - is 1 hit for all
            // multi hit - multi hit (many hits for 1 or several opponents)
            // ---------------------------------------------------------------->


            // Skill as actions ----------------------------------------------->
            // if( qdm_cleric_heal($p1, $pls, $grp)     && qdm_tmp_effects($p1) ) continue;
            // if( qdm_cleric_grp_heal($p1, $pls, $grp) && qdm_tmp_effects($p1) ) continue;
            // ---------------------------------------------------------------->
            
            
            // Decide what we will do ----------------------------------------->
            // TODO
            $action = player_battle_actions($p1, $pls, $grp);
            // Do it!
            $action($p1, $pls, $grp, $log);
            // ---------------------------------------------------------------->
            
        }
        
        
        // End of round ------------------------------------------------------->
        // TODO
        // remove_tmp_bufs($p1);
        // -------------------------------------------------------------------->

        $file['header']['pls'] = $pls;
        $file['body'][] = $log; // Battle rounds
        $log = array();

        // TODO remove
        if( $while_counter > 100 ) break;
        // d_echo($pls);
    }

    // d_echo($file);
    d_echo('End of battle ' . ($while_counter), 'r');
    // d_echo($file);



    $res = log_to_html($file);
    d_echo($res);
    
}



// sort players by initiative
function players_initiative(&$pls){

    $ci = count($pls);
    for( $i = 0; $i < $ci; $i++ ){
        $init_zero = ( $pls[$i]['init'] < 10 ) ? '0' . $pls[$i]['init'] : $pls[$i]['init'];
        $init[$i] = $init_zero . '_' . $i;
    }
    rsort($init);

    return $init;
}


// Select player action
function player_battle_actions($p1, $pls, $grp){
    
    return 'player_hit';
    
}


// $p1 hits $p2 - only 1 hit!
function player_hit(&$p1, &$pls, $grp, &$log = array()){
    
    global $game;

    $cur_log = array();
    $cur_log['who'] = $p1['index'];
    $cur_log['who_hp'] = $p1['hp'];



    // Init ------------------------------------------------------------------->
    $msg    = array();
    $struct = array();
    $msg    = msg_fill($msg);
    $cfg    = qdm_config();
    $skills = &$p1['skills'];
    $index  = $p1['index'];
    $op_index = qdm_find_opponent($pls, $grp, $index); // Now we must find opponent
    $p2 = &$pls[$op_index];
    $cur_log['target'] = $p2['index'];
    $cur_log['target_hp'] = $p2['hp'];
    // ------------------------------------------------------------------------>
    
    
    // Recalc ----------------------------------------------------------------->
    $p1_defense = $p1['ac'];
    $p2_defense = $p2['ac'];
    $weapon_id = $p1['weapon'];

    // $struct['d_hit'] = $hit;
    // $struct['d_dmg'] = $dmg;
    // $struct['d_def'] = $defense;

    // $b_atk = $p1['atk'] + $p1['bonus']['atk'];
    // $b_dmg = $p1['dmg'];
    // $b_def = $p2['bonus']['def'];
    // ------------------------------------------------------------------------>
    
    
    // Add some bonus (from user structure) ----------------------------------->
    // ------------------------------------------------------------------------>

    
    // Hit example ------------------------------------------------------------>
    // min accuracity  10% - 15%
    $dex_bonus = $game['dex_bonus'];
    $dif = ($p1['dex']-$p2['dex']) * $dex_bonus; // 1 dex = 1% accuracy/evasion

    // Acc may be + and - (do not recalc it too eva)
    $p1_acc = $p1['acc'] + $dif; // change p1 acc

    $hit_chance = $p1_acc - $p2['eva']; // float 0,02356
    if( $hit_chance < 0.1 ) $hit_chance = 0.1; // min 10%
    $cur_log['hit_chance'] = $hit_chance;
    
    // Rolls ------------------------------------------------------------------>
    $hit   = mt_frand();
    $dmg   = mt_rand(1, $cfg['weapons'][$weapon_id]['dmg']) + $p1['dmg'];
    $block = mt_frand();
    $crit  = mt_frand();

    $cur_log['hit']   = $hit;
    $cur_log['miss']  = 0;
    $cur_log['block'] = 0;
    // ------------------------------------------------------------------------>

    

    if( $hit_chance >= $hit ){
        
        $cur_log['miss'] = 0;
        // TODO: check critical
        
        // Ok, player hit his target, now, opponent checks
        if( $p2['block'] >= $block ){ // opponent have blocked that hit!
            
            // Block removes half physic damage
            $dmg = ceil($dmg/2);
            $dmg = armor($p2_defense, $dmg);
            
            $p2['st'] -= $dmg;
            $p2['hp'] -= $dmg;
            
            $cur_log['dmg']   = $dmg;
            $cur_log['block'] = 1;
            $cur_log['block_msg'] = 1;
            $cur_log['target_hp'] = $p2['hp'];
            $cur_log['target_st'] = $p2['st'];
        }
        else{ // opponent haven`t blocked
            
            $dmg = armor($p2_defense, $dmg);
            
            $p2['hp'] -= $dmg;
            $cur_log['dmg']   = $dmg;
            
            $cur_log['target_st'] = $p2['st'];
            // it`s dirrect hit to hp
            // calc damage
        }
    }
    else $cur_log['miss'] = 1;
    // ------------------------------------------------------------------------>

    $cur_log['target_hp'] = $p2['hp'];

    $log[] = $cur_log;

    return true;
}



function armor($ac, $dmg){

    $dmg -= $ac;
    if( $dmg < 0 ) $dmg = 0;

    return $dmg;
}


// Another way to end battle
function battle_test(&$p1, &$p2, &$log = array()){

    $game['rounds'] = false;
    // Battle ----------------------------------------------------------------->
    if( $game['rounds'] ) $counter = $game['rounds'];
    while( 1 ){ // yes, always!
        

        player_hit($p1, $p2, $log);
        player_hit($p2, $p1, $log);
        
        // for( $i = 0; $i < $game['round_hits']; $i++ ){
            
        // }
        
        
        // End condition ----------------------------------------------------->>
        if( $game['rounds'] ){
            $counter--;
            if( $counter <= 0 ) break; // Round 0 - end of battle
        }
        else{
            if( $p1['hp'] < 1 || $p2['hp'] < 1 ) break;
        }
        // ------------------------------------------------------------------->>
    }
    // ------------------------------------------------------------------------>

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
function q1dm_one_hit(&$p1, &$grp, &$pls, &$file){

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
function qdm1_battle_check_crit($hit, $player, &$dmg, $opp_defense){

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
