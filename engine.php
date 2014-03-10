<?php

include_once 'config.php';
inc_fl_lib('qdm.php');
inc_fl_lib('qdm/qdm_cfg.php');
inc_fl_lib('html.php');
inc_fl_lib('magic.php');

function mt_frand(){
    return mt_rand() / mt_getrandmax();
}

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


// TODO add element resistance
// fire > earth > air > air > water >
// light >< dark
// $p['resist_fire']
// $p['resist_water']
// $p['resist_air']
// $p['resist_earh']
// $p['resist_dark']
// $p['resist_light']




// Full battle
function battle($pls, $grp){

    $log = array();
    $file = array();


    $file['header']['teams'] = $grp;
    $params = array();
    $params['magic'] = array(); // magic stack
    $params['buf']   = array(); // buf stack

    // in stack will be added casted magic
    // check stack for simphony magic - then remove that spells from stack
    // for check will be closest?
    
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
        // TODO - maybe
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

            // TMP buf - add to main structure and create buf array
            // at the end unset buf, and next time take main structure again
            // Add tmp buff into buff stack, to each user (or users ids)

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
            $action($p1, $pls, $grp, $log, $params);
            // ---------------------------------------------------------------->
            
        }
        
        
        // End of round ------------------------------------------------------->
        // TODO
        remove_tmp_bufs($params);
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
function player_hit(&$p1, &$pls, $grp, &$log, &$params){
    
    global $game;

    $cur_log = array();
    $cur_log['who'] = $p1['index'];
    $cur_log['who_hp'] = $p1['hp'];
    $cur_log['who_st'] = $p1['st'];


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
    // ------------------------------------------------------------------------>
    
    
    // Apply bufs ------------------------------------------------------------->
    add_buf($p1, $params, $cur_log);
    add_buf($p2, $params, $cur_log);
    // ------------------------------------------------------------------------>

    
    // Recalc ----------------------------------------------------------------->
    $p1_defense = $p1['ac'] + $p1['tmp']['ac'];
    $p2_defense = $p2['ac'] + $p2['tmp']['ac'];
    $cur_log['p1_ac'] = $p1_defense;
    $cur_log['p2_ac'] = $p2_defense;
    $weapon_id  = $p1['weapon'];

    // $struct['d_hit'] = $hit;
    // $struct['d_dmg'] = $dmg;
    // $struct['d_def'] = $defense;

    // $b_atk = $p1['atk'] + $p1['bonus']['atk'];
    // $b_dmg = $p1['dmg'];
    // $b_def = $p2['bonus']['def'];
    // ------------------------------------------------------------------------>
    
    
    // Add some bonus (from user structure) ----------------------------------->
    // ------------------------------------------------------------------------>


    // magic ------------------------------------------------------------------>
    $activate_magic = player_active_magic($p1, $cur_log, $params);
    if( $activate_magic ) magic_simphony($p1, $pls, $grp, $cur_log, $params);    
    // ------------------------------------------------------------------------>
    

    $cur_log['dmg_log'] = '';
    // Hit example ------------------------------------------------------------>
    // min accuracity  10% - 15%
    $dex_bonus = $game['dex_bonus'];
    $dif = (($p1['dex'] + $p1['tmp']['dex']) - ($p2['dex'] + $p2['tmp']['dex'])) * $dex_bonus; // 1 dex = 1% accuracy/evasion

    // Acc may be + and - (do not recalc it too eva)
    $p1_acc = $p1['acc'] + $p1['tmp']['acc'] + $dif; // change p1 acc

    $hit_chance = $p1_acc - $p2['eva'] - $p2['tmp']['eva']; // float 0,02356
    if( $hit_chance < 0.1 ) $hit_chance = 0.1; // min 10%
    $cur_log['hit_chance'] = $hit_chance;
    $cur_log['crit'] = 0;
    
    // Rolls ------------------------------------------------------------------>
    $hit   = mt_frand();
    $dmg   = mt_rand(1, $cfg['weapons'][$weapon_id]['dmg']) + $p1['dmg'] + $p1['tmp']['dmg'];
    $block = mt_frand();
    $crit  = mt_frand();

    $cur_log['dmg_log'] .= '1d' . $cfg['weapons'][$weapon_id]['dmg'] . ' + ' . $p1['dmg'] . ' (player bonus as str) + '. $p1['tmp']['dmg'].'(buf) = ' . $dmg;

    $cur_log['hit']   = $hit;
    $cur_log['miss']  = 0;
    $cur_log['block'] = 0;
    // ------------------------------------------------------------------------>

    
    $cur_log['dmg'] = 0;
    if( $hit_chance >= $hit ){
        
        $cur_log['miss'] = 0;
        check_critical_hit($p1, $dmg, $cur_log);

        if( $cur_log['crit'] ) $cur_log['dmg_log'] .= '* ' . $cfg['weapons'][$p1['weapon']]['crit'] . ' (crit)';
        
        // Ok, player hit his target, now, opponent checks
        if( $p2['block'] >= $block && ($dmg/2) < $p2['st'] ){ // opponent have blocked that hit!
            
            // Block removes half physic damage
            $dmg = ceil($dmg/2);

            $cur_log['dmg_log'] .= '/2 (block)';
            $cur_log['dmg_log'] .= ' - ' . $p2_defense . ' (ac)'; 
            
            $dmg = armor($p2_defense, $dmg);
            
            $p2['st'] -= $dmg;
            $p2['hp'] -= $dmg;
            
            $cur_log['block'] = $dmg;
            $cur_log['block_msg'] = 1;
            $cur_log['dmg'] = $dmg;
            
        }
        else{ // opponent haven`t blocked
            
            $cur_log['dmg_log'] .= ' - ' . $p2_defense . ' (ac)'; 
            $dmg = armor($p2_defense, $dmg);
            
            $p2['hp'] -= $dmg;
            $cur_log['dmg'] = $dmg;
            // it`s dirrect hit to hp
            // calc damage
        }
    }
    else $cur_log['miss'] = 1;
    
    // ------------------------------------------------------------------------>

    $cur_log['target_hp'] = $p2['hp'];
    $cur_log['target_st'] = $p2['st'];
    $cur_log['buf_log'] = $p1['buf_log'];
    
    // Unset bufs ------------------------------------------------------------->
    array_items_to_zero($p1['tmp']);
    array_items_to_zero($p2['tmp']);
    
    unset($p1['status']);
    unset($p2['status']);

    $p1['buf_log'] = array();
    $p2['buf_log'] = array();
    // ------------------------------------------------------------------------>

    $log[] = $cur_log;

    return true;
}


function player_active_magic($p1, &$log, &$params){

    $log['magic'] = false;

    if( empty($p1['magic']) ) return false;
    
    $magic = $p1['magic'];
    
    // Take all known magic --------------------------------------------------->
    $ci   = count($magic);
    $keys = array_keys($magic);
    $chances = array();
    for($i = 0; $i < $ci; $i++){ 
        
        $key = $keys[$i];
        $tmp = array();
        $tmp['name'] = $key;
        $tmp['chance'] = $magic[$key]['chance'];
        $tmp['weight'] = $magic[$key]['weight'];
        $chances[] = $tmp;
    }
    // ------------------------------------------------------------------------>
    

    // Calc total weight and select among them -------------------------------->
    $ci = count($chances);
    $total_weight = 0;
    $cum_weight = array();
    for( $i = 0; $i < $ci; $i++ ){ 

        $total_weight += $chances[$i]['weight']*100;
        $cum_weight[] = $total_weight;

    }

    $select = mt_rand(1, $total_weight);
    // ------------------------------------------------------------------------>
    

    // Select magic ----------------------------------------------------------->
    $ci = count($cum_weight)-1;
    $index = NULL;
    $index = 0;
    for( $i = $ci; $i > 0; $i-- ){ 
        
        if( $cum_weight[$i] >= $select && $cum_weight[$i-1] < $select ){
            $index = $i;
            break;
        }
        $index = 0;
    }

    // ------------------------------------------------------------------------>

    $cur = $magic[$keys[$index]];   
    $cast = mt_frand();

    // Chance to activate magic
    if( $cast > $cur['chance'] ) return false; // No magic
    // d_echo($cur, 'r');

    // Log -------------------------------------------------------------------->
    // $dmg = mt_rand($cur['dmg_min'], $cur['dmg_max']);
    // $cur['dmg'] = $dmg;
    // $cur['target'] = '';

    $params['stack'][] = $cur;

    // $log['magic'] = $cur;
    // ------------------------------------------------------------------------>

    return $cur;
}


function magic_simphony(&$p1, &$pls, $grp, &$cur_log, &$params = array()){

    $ci   = count($params['stack']);
    $last = $ci - 1;

    $magic = $params['stack'][$last];
    $cur = $magic;

    switch ($cur['id']) {

        case 'flame':
        case 'fire_flash':
        case 'ice_needle':
        case 'ice':
        case 'fire':{
             
            $ci = $cur['target'];
            for($i = 0; $i < $ci; $i++){ 
                
                $index  = $p1['index'];
                $op_index = qdm_find_opponent($pls, $grp, $index); // Now we must find opponent
                $p2 = &$pls[$op_index];
                $cur_log['targets'][] = $p2['index'];

                $dmg = mt_rand($cur['dmg_min'], $cur['dmg_max']) * $cur['multiply'];

                $p2['hp'] -= $dmg;
                $cur['ids'][] = $p2['index'];
                $cur['dmg'] = $dmg;
            }

            break;
        }

        case 'earth_shield':{

            $cur['ids'][] = $p1['index'];
            $params['buf'][] = $cur;
            break;
        }

        case 'poison':{

            $dmg = mt_rand($cur['dmg_min'], $cur['dmg_max']) * $cur['multiply'];
            $cur['dmg'] = $dmg;
            $cur['effect'] = array();
            $cur['ids'][] = $p1['index'];
            $params['buf'][] = $cur;
            break;
        }

        case 'heal':

            $dmg = mt_rand($cur['dmg_min'], $cur['dmg_max']);

            $need_hp = $p1['hp_max'] - $p1['hp'];
            if( $dmg > $need_hp ) $dmg = $need_hp;

            $p1['hp'] += $dmg;
            $cur['ids'][] = $p1['index'];
            $cur['dmg'] = $dmg;

            break;
        
        default:
            # code...
            break;
    }

    // Spell consumes stamina ------------------------------------------------->
    $p1['st'] -= round($cur['mp']);
    // ------------------------------------------------------------------------>


    // Find target ------------------------------------------------------------>
    // magic.target - target count, that affects selected spell 
    // magic.target_type - type of targets 
    // magic.target_type == 1 - opponent
    // magic.target_type == 2 - self
    // magic.target_type == 3 - ally    
    
    if( 0 ){ // target exists
        
        $ci = $cur['target'];
        for($i = 0; $i < $ci; $i++){ 
            
            switch( $cur['target_type'] ){

                case SPELL_TARGET_OPPONENT:{

                    $index  = $p1['index'];
                    $op_index = qdm_find_opponent($pls, $grp, $index); // Now we must find opponent
                    $p2 = &$pls[$op_index];
                    $cur_log['targets'][] = $p2['index'];

                    if( $cur['spell_type'] == 'dmg' ) $p2['hp'] -= $dmg;
                    $cur['ids'][] = $p2['index'];
                    
                    break;
                }
                case SPELL_TARGET_SELF:{
                    
                    if( $cur['spell_type'] == 'dmg' ) $p1['hp'] -= $dmg;
                    $cur['targets'][] = $p1['index'];
                    $cur['ids'][]     = $p1['index'];
                    
                    break;
                }
                case SPELL_TARGET_ALLY:{

                    $index  = $p1['index'];
                    $op_index = qdm_find_ally($pls, $grp, $index); // Now we must find ally
                    $p2 = &$pls[$op_index];
                    $cur_log['targets'][] = $p2['index'];

                    if( $cur['spell_type'] == 'dmg' ) $p2['hp'] -= $dmg;
                    $cur['ids'][] = $p2['index'];
                    
                    break;
                }
            }
        }
    }
    // ------------------------------------------------------------------------>
    
    
    $cur_log['magic'] = $cur;
}



// Remove bufs that lost their effect
// Decrease buf counter
function remove_tmp_bufs(&$params){

    if( !isset($params['buf']) ) return true; // no buf

    $ci = count($params['buf']);
    for($i = 0; $i < $ci; $i++){ 
        
        $cur_buf = &$params['buf'][$i];

        // d_echo($cur_buf);

        $cur_buf['duration']--;
        if( $cur_buf['duration'] < 0 ){
            unset($cur_buf);
            unset($params['buf'][$i]);
        }
    }

    $params['buf'] = array_values($params['buf']);
}


// Fill player with tmp buf values
function add_buf(&$p, $params, &$cur_log){
    
    
    $ci = count($params['buf']);
    for( $i = 0; $i < $ci; $i++ ){
    
        $cur_buf = $params['buf'][$i];
        
        if( !in_array($p['index'], $cur_buf['ids']) ) continue; // do not affect current user
        
        $p['buf_log'] = array_merge($cur_buf['effect'], $p['buf_log']);

        // Apply effects to user tmp stats
        $stat_keys = array_keys($cur_buf['effect']);
        $cj = count($stat_keys);
        for( $j = 0; $j < $cj; $j++ ){

            $key = $stat_keys[$j];
            if( !isset($p['tmp'][$key]) ) $p['tmp'][$key] = 0;
            $p['tmp'][$key] += $cur_buf['effect'][$key];
        }


        switch( $cur_buf['id'] ){
            case 'poison':                

                $cur_log['status'][] = $cur_buf;
                break;
            
            default:
                break;
        }
        
      
        // Show buf icons
        $p['status'][] = $cur_buf;
    }
    
    return true;
}

// Fill all array items with zero
// Set tmp bonuses to initial state
function array_items_to_zero(&$ar){

    $keys = array_keys($ar);
    $ci = count($ar);
    for($i = 0; $i < $ci; $i++) { 
        
        $key = $keys[$i];
        if( !is_array($ar[$key]) ) $ar[$key] = 0;
        else array_items_to_zero($ar[$key]);
    }

    return true;
}

// Armor decrease damage
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
function check_critical_hit($player, &$dmg, &$log){

    $cfg = qdm_config();
    
    $crit_range = $cfg['weapons'][$player['weapon']]['crit_range'];

    $crit = mt_frand();
    $log['crit_range'] = 0;
    $log['crit_dice'] = $crit;
    if( $crit <= $crit_range ){

        $log['crit'] = 1;
        $dmg = $dmg * $cfg['weapons'][$player['weapon']]['crit'];
        return true;
    }

    $log['crit'] = 0;
    return false;
}
 
 
?>

Round n
|_ Player n
|    |- Hit who
|    |_ Casted magic + dmg
|    |_ bufs + status
|
|- Player n
