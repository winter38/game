<?php

// include_once('../lib/functions.php');
inc_fl_lib('msg.php');
inc_fl_lib('player.php');
inc_fl_lib('skills/cfg_skill.php');
inc_fl_lib('skill.php');
inc_fl_lib('battle_steps.php');

// Fill basic player structure
function init_player($id = false){
    
    $cfg    = qdm_config();

    // Default values --------------------------------------------------------->
    $s = array();
    static $id = 1;
    $s['id']  = $id; // player id
    $s['index'] = 0; 
    $s['name']  = '';
    $s['team']  = 0;

    $s['exp']   = 0;

    $s['lvl']    = 1; // initial level

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
    $s['init'] = 1; // Initiative
    
    $s['st'] = 100; // stamina  
    $s['hp'] = 100; // health points
    $s['mp'] = 100; // mana points
    $s['ap'] = 100; // Action points
    $s['pp'] = 100; // Action points
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
    $s['dmg']     = 8 + floor($s['str']/5); // Max damage
    $s['dmg+']    = floor($s['str']/3); // bonus damage
    
    $s['fort'] += floor($s['con']/5);
    $s['ref']  += floor($s['dex']/5);
    $s['will'] += floor($s['int']/5);
    $s['init'] += mt_rand(1, 20) + floor($s['dex']/3);
    
    $s['hp_max'] = $s['hp'];
    $s['st_max'] = $s['st'];

    $s['armor']  = mt_rand(1, count(qdm_cfg_wepons()));
    $s['weapon'] = mt_rand(1, count(qdm_cfg_armors()));
    $s['ac']     = $cfg['armors'][$s['armor']]['ac'];
    // ------------------------------------------------------------------------>
    
    
    // Event on_init ---------------------------------------------------------->
    // Hm, player feature bonus?
    // + item bonus (only that work always)
    // ------------------------------------------------------------------------>


    // Player skills ---------------------------------------------------------->
    $s['skills'] = array();
    // ------------------------------------------------------------------------>


    // Magick ----------------------------------------------------------------->
    // Magick will be filled according skills - just nedd skill mastery
    $s['magic'] = array();
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
    
    $s['magic'] = $magic;
    // ------------------------------------------------------------------------>


    $s['tmp'] = array();
    $b = &$s['tmp'];

    $b['atk'] = 0;
    $b['def'] = 0;

    $b['dex'] = 0;
    $b['str'] = 0;
    $b['con'] = 0;
    $b['end'] = 0;
    $b['int'] = 0;

    $b['ac'] = 0;
    $b['eva'] = 0;
    $b['acc'] = 0;
    $b['dmg'] = 0;



    return $s;
}




// qdm_user_stcuct()
//   create basic user structure
// parameters:
//   -
// return:
//   array
// notes:
//   -
function qdm_user_stcuct(){

    static $counter = 1;

    // Basic
    $char = array();
    $char['id']    = 0;
    $char['index'] = 0; 
    $char['name']  = '';
    $char['type']  = 0;
    $char['team']  = 0;

    $char['init']  = 0; // iniative
    $char['exp']   = 0;

    $char['lvl']    = 1; // initial level
    $char['max_hp'] = 0;
    $char['hp']     = 0;

    $char['armor']  = 0;
    $char['dodge']  = 0;
    $char['shield'] = 0;
    $char['nat_armor']  = 0; // natural armor

    $char['weapon']    = 0;
    $char['atk']       = 0; // attack bonus
    $char['dmg']       = 0; // damage bonus
    $char['armor_add'] = 0; // armor bonus
    $char['will']      = 0;

    $char['tmp_atk'] = 0;   // temprery atk bonus - reseted each round
    $char['tmp_def'] = 0;   // temprery defense bonus - reseted each round

    $char['tmp']    = array(); // array for temprory effects
    $char['kills']  = array();
    $char['skills'] = array();
    
    // example
    // $char['skills'][1]['val_1'] = 1; 
    // $char['skills'][1]['exp']   = 1; // will be updated in DB
    // $char['skills'][1]['effect'] = array(); // affecting user structure
    // $char['skills'][1]['effect']['str'] = +1; // or -1

    // $char['skills'][$id]

    $char['round_bonus']['def'] = 0;
    $char['round_bonus']['atk'] = 0;


    # summ
    # id level eff stat
    # 12     1   1  dex
    # 12     2   2  dex
    # 12     4   1  str

    $char['dex'] = 0;
    $char['str'] = 0;
    $char['con'] = 0;
    $char['wis'] = 0;
    $char['cha'] = 0;

    $char['stamina']     = 0;
    $char['stamina_max'] = 0;

    // Statistic
    $char['stat'] = array();
    $stat = &$char['stat'];

    $stat['miss']        = 0;
    $stat['crit_count']  = 0;
    $stat['crit_dmg']    = 0;
    $stat['block']       = 0;
    $stat['eva']         = 0;
    $stat['hits']        = 0;
    $stat['miss']        = 0;
    $stat['dmg']         = 0;
    $stat['hp_lost']     = 0;
    $stat['defended']    = 0;
    $stat['atacked']     = 0;

    // bonus - need to reset each rouns
    $char['tmp'] = array();
    $b = &$char['bonus'];

    $b['atk'] = 0;
    $b['def'] = 0;
    $b['dex'] = 0;
    $b['str'] = 0;
    $b['con'] = 0;
    $b['wis'] = 0;
    $b['cha'] = 0;
    $b['ac'] = 0;
    $b['eva'] = 0;
    $b['acc'] = 0;
    $b['cha'] = 0;


    $counter++;

    return $char;
}


// qdm_player_init()
//   create basic user structure
//   cacl user values
// parameters:
//   $id - int - user id
// return:
//   array
// notes:
//   -
function qdm_player_init($id, $index, $grp){

    $cfg    = qdm_config();
    $pl     = qdm_user_stcuct();

    if( !$pl ) return false;

    $user   = qdm_player($id);
    $lv     = calc_level($user['exp']);

    $pl['id']    = $user['player_id'];
    $pl['name']  = $user['name'];
    $pl['index'] = $index;
    $pl['dex']   = $user['dex'];
    $pl['str']   = $user['str'];
    $pl['con']   = $user['con'];
    $pl['wis']   = $user['wis'];
    $pl['cha']   = $user['cha'];
    $pl['exp']   = $user['exp'];
    $pl['lvl']   = $lv['lvl'];

    qdm_fill_skills($pl);
    $stat_coef = 3;

    $pl['save']  = 0;
    $pl['atk']   += floor($pl['str'] / $stat_coef);
    $pl['will']  += floor($pl['will'] / $stat_coef) + floor($lv['lvl']/4);
    $pl['dmg']   += floor($pl['str'] / $stat_coef);
    $pl['dodge'] += floor($pl['dex'] / $stat_coef);
    $pl['nat_armor'] += floor($pl['con'] / 6);

    $pl['init']   = mt_rand(1, 20) + $pl['dex'];
    $pl['hp']     = mt_rand(10, $cfg['hp'][mt_rand(1, count($cfg['hp']))]) + $cfg['base_hp'] + 2*$pl['con'];
    $pl['hp']    += ($pl['lvl']-1) *  5; // 5hp for each level
    $pl['max_hp'] = $pl['hp'];
    $pl['armor']  = mt_rand(1, count(qdm_cfg_wepons()));
    $pl['weapon'] = mt_rand(1, count(qdm_cfg_armors()));

    skill_on_player_init($pl);
    // qdm_stamina($pl);
    // In group must be number of player in $pl array
    $pl['team'] = find_grp($index, $grp);
    return $pl;

}




function qdm_fill_skills(&$player){

    $act_skills = qdm_skills_act($player['id'], 1);
    $ci = count($act_skills);

    for ($i = 0; $i < $ci; $i++) { 
        
        $skill = $act_skills[$i];
        $skill_level = calc_level($skill['exp']);
        $skill_cfg = qdm_skill_cfg($skill['id'], $skill_level['lvl']);

        // form key based effects
        $res = array();
        $cj  = count($skill_cfg);

        if( !$cj ){
            $player['skills'][$skill['id']] = $res;
            $player['skills'][$skill['id']]['exp'] = 0; // initial gained skill exp
            $player['skills'][$skill['id']]['id'] = $skill['id'];
        }

        for ($j = 0; $j < $cj; $j++) {

            $cur = $skill_cfg[$j];
            // d_echo($cur);

            if( isset($cur['stat_name']) && $cur['stat_name'] ){
                if( isset($player[$cur['stat_name']]) )  $player[$cur['stat_name']] += $cur['stat_value'];
                else  $player[$cur['stat_name']] = $cur['stat_value'];
            }

            if( isset($res[$cur['key_val_1']]) ) $res[$cur['key_val_1']] += $cur['val_1'];
            else $res[$cur['key_val_1']] = $cur['val_1'];

            if( isset($res[$cur['key_val_2']]) ) $res[$cur['key_val_2']] += $cur['val_2'];
            else $res[$cur['key_val_2']] = $cur['val_2'];

            if( isset($res[$cur['key_val_3']]) ) $res[$cur['key_val_3']] += $cur['val_3'];
            else $res[$cur['key_val_3']] = $cur['val_3'];

            $res['id'] = $cur['skill_id'];

            if( $res ){
            
                // d_echo($res);
                $player['skills'][$res['id']] = $res;
                $player['skills'][$res['id']]['exp'] = 0; // initial gained skill exp
                // d_echo($player);
                // d_echo($skill_cfg);
            }
        }
    }
}


// qdm_multiple_hit()
//   one player hits many players
//   creates log - rolls, checks. statistic
// parameters:
//   $p1  - array  - attacker
//   $p2s - array - players
//   $grp - array - player groups
//   $players - array - all playres in battle
//   $file - array - log structure will be written there
// return:
//
// notes:
//  -
function qdm_multiple_hit(&$p1, &$p2s, &$grp, $players, &$file, $log_type = 0){

    $msg    = array();
    $struct = array();
    $msg    = msg_fill($msg);
    $msg_max_hit  = count($msg['hit'])-1;
    $msg_max_crit = count($msg['crit'])-1;
    $cfg    = qdm_config();
    $skills = &$p1['skills'];
    $ops    = $ops;

    $weapon_id = $p1['weapon'];
    $dmg = mt_rand(1, $cfg['weapons'][$weapon_id]['dmg']);
    $hit = mt_rand(1, 20);
    $b_atk = $p1['atk'] + $p1['tmp_atk'];
    $b_dmg = $p1['dmg'];

    $struct['p1']  = $p1['index'];

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

    $struct['d_hit']    = $hit;
    $struct['d_dmg']    = $dmg;
    $struct['crit_mod'] = $cfg['weapons'][$p1['weapon']]['crit'];
    $struct['d_hit+']   = $b_atk;
    $struct['d_dmg+']   = $b_dmg;

    $dmg  = $dmg + $b_dmg; // add bonus

    // 1 roll for all, or each 
    $ci = count($p2s);
    for( $i = 0; $i < $ci; $i++ ){ 

        $p2 = $ops[$i];
        $defense = $cfg['base_armor'] + $cfg['armors'][$p2['armor']]['ac'];
        $struct['d_def'] = $defense;
        $b_def = $p2['tmp_def'];

        // TODO: add weapon skills!
        // Create structure for log
        $struct['p2']       = $p2['index'];
        
        $del = ' ';
        $eva = 0;

        // TODO: add shield
        $defense   = $cfg['base_armor'] + $cfg['armors'][$p2['armor']]['ac'] + $p2['nat_armor'] + $p2['dodge'] + $b_def;    // full def (eveision)
        $block_def = $cfg['base_armor'] + $cfg['armors'][$p2['armor']]['ac'] + $p2['nat_armor'];                   // armor def
        $miss_def  = $cfg['base_armor'] + $p2['nat_armor']; // base def
        $struct['opp_def'][]  = $defense . '/' . $block_def . '/' . $miss_def;


        // Skills block - for player move ------------------------>
        // Move to function before
        if( isset($skills[S_SECOND_BREATH]) ){
            if( $skills[S_SECOND_BREATH]['count'] && ($p1['hp']/$p1['max_hp']) < 0.5 ){

                $skill = &$skills[S_SECOND_BREATH];

                $min_range = $skill['min_range'];
                $max_range = $skill['max_range'];

                $skill['count']--;
                $hp = mt_rand($min_range, $max_range); // tmp

                $p1['hp']        += $hp; 
                $skill['msg']     = 1;
                $skill['type']    = 1;
                $skill['msg_val'] = $hp;
                $skill['exp']    += $hp*40;
                $struct['skill'][S_SECOND_BREATH] = $skill;
            }
        }
        // ------------------------------------------------------->

        $crit = qdm_battle_check_crit($hit, $p1, $dmg, $defense);

        if( $crit ){
            
            $p1['stat']['crit_count']++;
            if( $dmg > $p1['stat']['crit_dmg'] ) $p1['stat']['crit_dmg'] = $dmg; // max crit
            $log_dmg = $dmg;
            $struct['crit'] = 1;
        }
        else $struct['crit'] = 0; 

        $hit  = $hit + $b_atk; // add bonus to hit

        if( $hit >= $defense ){
            // d_debug(1, 'Hit for -'.$dmg.' ('.$p2['hp'].'/'.$p2['max_hp'].')');
            $p2['hp'] = $p2['hp'] - $dmg;
            $p1['stat']['dmg']     += $dmg;
            $p2['stat']['hp_lost'] += $dmg;
            $struct['dmg'][]  = $dmg;

            if( $crit ){  $struct['msg'] = mt_rand(0, $msg_max_crit);  }
            else{         $struct['msg'] = mt_rand(0, $msg_max_hit);   }

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

            $msg_max_miss = count($msg['miss'])-1;
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

        $struct['p2_hp'][] = $p2['hp'];
        $struct['p2_max_hp'][] = $p2['max_hp'];
        $p1['stat']['atacked']++;
        $p2['stat']['defended']++;

    }

    $struct['type'] = 1;

    $file[] = $struct;
} // qdm_multiple_hit





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
    //if( $player['skill'] == 20 + $player['weapon'] ){ $crit_range = $cfg['skill'][$player['skill']]; } // imroved critical

    if( $hit >= $crit_range && $hit+$player['atk'] >= $opp_defense || $hit == 20 ){
        $confirm = mt_rand(1, 20);
        if( $confirm >= $opp_defense ){

            $dmg = $dmg * $cfg['weapons'][$player['weapon']]['crit'];
            return true;
        }
    }
    return false;
}



// find_grp()
//   find group for player with index
// parameters:
//   $index - player index
//   $grp - array - players groups
// return:
//   int - number of group
// notes:
//  -
function find_grp($index, $grp){

    $keys = array_keys($grp);

    $ci = count($grp);
    for ($i=0; $i < $ci; $i++) { 
        $key = $keys[$i];
        if( in_array($index, $grp[$key]) ) return $i;
    }
}


// qdm_versus()
//   rolls for 1 player
// parameters:
//   $p1 - array info of player 1
//   $p2 - array info of player 2
//   $log - log file
//
// return:
//   -
// notes:
//   -
function qdm_versus($players, $grp, $debug = 0){

    $cfg = qdm_config();
    $msg = array();
    $msg = msg_fill($msg);
    $max_grp_msg = count($msg['grp']) - 1;
    if( !$debug ) $_SESSION['debug'] = 1;

    debug($cfg, 'Cfg');
    debug($players, 'Players');
    debug($grp, 'Teams');


    // Init players structure, get stats -------------------------------------->
    $ci = count($players);
    for ($i = 0; $i < $ci; $i++){
        if( $players[$i]['id'] > 0 ) $players[$i] = qdm_player_init($players[$i], $i, $grp);
        else $players[$i] = qdm_monster_init($players[$i], $i, $grp);
       
    }
    debug($players, 'players initiated');
    // ------------------------------------------------------------------------>
    
    
    $log = array();
    $log['header']['teams'] = $grp;
    $init = array();


    // Sort by init, in reverse order ----------------------------------------->
    // this part can used, when there are many players  
    $init = qdm_player_initiative($players);
    // ------------------------------------------------------------------------>

    // Team skills ------------------------------------------------------------>
    $team_wep = array();
    $ci = count($grp);
    for( $i = 0; $i < $ci; $i++ ){ 
        if( count($grp[$i] > 1) ){   
            $cj = count($grp[$i]);
            for( $j = 0; $j < $cj; $j++ ){ 
                
                $index = $grp[$i][$j];
                $players[$index];
                
                $wep = $players[$index]['weapon'];
                $team_wep[$i][$wep][] = $index;
            }
        }
        else $team_wep[$i] = array();
    }
    // ------------------------------------------------------------------------>

    
    // Battle ----------------------------------------------------------------->
    $counter = 0;
    $c_counter = 0;
    $ci = count($init);
    while( !qdm_battle_end($players, $grp) ){

        $counter++;
        qdm_grp_bonus($grp, $players, $file);

        
        // Group attack -------------------------------------------->
        $ck = count($grp);
        for( $k = 0; $k < $ck; $k++ ){ 
            $cur_grp = $grp[$k];
            $pl_live = count($cur_grp);

            if( !$pl_live < 2 ) continue;
            // qdm_grp_hit($cur_grp, $players);
            // hm - how can 1 or group attack 1ppl or all ppl
        }
        // --------------------------------------------------------->

        // Decide which action
        $ci = count($init);
        for( $i = 0; $i < $ci; $i++ ){ 
            
            $c_counter++;

            if( count($grp) < 2 ) break; // No opponent group

            // Player hit order - index is player number in $players array
            $string = strstr($init[$i], '_');
            $index  = substr($string, 1);

            if( $players[$index]['hp'] < 1 ) continue; // skip dead players

            $p1 = &$players[$index];

            // Trigger some skill action before hit --------------------------->
            qdm_skill_second_breath($players[$index], $grp, $players, $file);
            qdm_skill_intimidate($p1, $grp, $players, $file);
            // ---------------------------------------------------------------->


            // Skill as actions ----------------------------------------------->
            if( qdm_cleric_heal($p1, $players, $grp)     && qdm_tmp_effects($p1) ) continue;
            if( qdm_cleric_grp_heal($p1, $players, $grp) && qdm_tmp_effects($p1) ) continue;
            // ---------------------------------------------------------------->
            
            qdm_one_hit($p1, $grp, $players, $file); // Make hit to one opponent
            
            // Counter
            // qdm_one_hit($players[$op_index], $players[$index], $file);
            // d_echo($file);            

            qdm_tmp_effects($p1); // remove buffs
            // d_echo($file, 'r');
        }


        // remove tmp bonus
        // $keys = array_keys($players);
        $cj = count($players);
        for( $j = 0; $j < $cj; $j++ ){ 
            
            $p = &$players[$j];

            $ck = count($p['bonus']);
            $keys = array_keys($p['bonus']);
            for( $k = 0; $k < $ck; $k++ ){ 
                $key = $keys[$k];
                $p['bonus'][$key] = 0;
            }
        }

        
        $log['body'][] = $file; // Battle rounds
        $file = array();
        if( $counter > 100 ) break;
    }
    // ------------------------------------------------------------------------>
    debug($counter, 'while counter ' . $counter . ', cicle counter ' . $c_counter);
    // d_echo($log);
    // d_echo($players);
    // die;

    // Calc expiriance coeficent according players levels
    $ci = count($players);
    $lvl_sum = 0;
    for( $i = 0; $i < $ci; $i++ ) $lvl_sum +=$players[$i]['lvl'];
    $avg_level = $lvl_sum/$ci;
    $rounds = count($log['body']);

    debug($avg_level, 'Battle coeficent');
    for( $i = 0; $i < $ci; $i++ ){ 
        
        $p = &$players[$i];
        // d_echo($p); 
        // Update statistic ------------------------------->
        $data = array();
        $data['crit']     =  $p['stat']['crit_count'];
        $data['evasion']  =  $p['stat']['eva'];
        $data['block']    =  $p['stat']['block'];
        $data['hits']     =  $p['stat']['hits'];
        $data['miss']     =  $p['stat']['miss'];
        $data['dmg']      =  $p['stat']['dmg'];
        $data['hp_lost']  =  $p['stat']['hp_lost'];
        $data['max_crit'] =  $p['stat']['crit_dmg'];
        $data['btl_count'] = 1;
        $data['kill'] = count($p['kills']);
        if( $p['hp'] > 0 ){ $data['win'] = 1; }

        qdm_statistic_update($p['id'], $data);
        // ------------------------------------------------->

        //d_echo($log,'g');
        //d_echo($p); 

        // Calc Experiance --------------------------------->
        $battle_coef = $avg_level/$p['lvl']; // battle exp coef for each player
        $exp = calc_exp($p['exp'], $battle_coef, $p['stat']['dmg']);
        // ------------------------------------------------->


        // Calc Skill Experiance --------------------------->
        $cj = count($p['skills']);
        $skill_update = array();
        $keys = array_keys($p['skills']);

        // TODO: count for each player how many round he fought
        for ($j = 0; $j < $cj; $j++) {

            $key = $keys[$j];
            switch( $key ){
                case S_WEP_DAGGER:
                case S_WEP_SHORT_SWORD:
                case S_WEP_RAPIER:
                case S_WEP_LONG_SWORD:
                case S_WEP_BASTARD:
                case S_WEP_POLEAXE:
                case S_ARM_1:
                case S_ARM_2:
                case S_ARM_3:
                case S_ARM_4:
                case S_ARM_5:
                case S_ARM_6:
                     $p['skills'][$key]['exp'] += $rounds; // additional exp
                     break;
                default: break;
            }

            qdm_skill_update_exp($p['id'], $key, $p['skills'][$key]['exp']);
        }

        // $battle_coef = $avg_level/$p['lvl']; // battle exp coef for each player
        // $exp = calc_exp($p['exp'], $battle_coef, $p['stat']['dmg']);
        // ------------------------------------------------->


        // Bonus expireance for win ------------------------>
        if( $p['hp'] > 0 ){

            $exp['bonus'] = $p['lvl'] * 50;
            $exp['exp'] += $exp['bonus']; // bonus for stayed alive
        }
        // ------------------------------------------------->


        // Calc gold --------------------------------------->
        $min = 1 + $p['lvl'];
        $max = $exp['exp_earned'];
        $exp['gold'] = mt_rand($min, $max);
        qdm_gold_update($p['id'], $exp['gold']);
        // ------------------------------------------------->

        // $exp contains info about level up - check it
        if( $exp['new_lvl'] > $exp['lvl'] ) qdm_level_up($p, $exp['new_lvl']);
        qdm_exp_update($p['id'], $exp['exp']);
        
        $p['res'] = $exp;
    }


    $log['header']['players'] = $players;
    debug($log['header'], 'Log header');
    debug($log['body'], 'Battle log ' . $rounds . ' Rounds');

    // echo(log_to_html($log));

    // update skill info -------------------------------->>
    // $players_conf = array();
    // $players_conf[] = $player;
    // $players_conf[] = $opponent;
    // skills_update($players_conf, $log); // update player used skills
    // -------------------------------------------------->>
    // ------------------------------------------------------------------------>

    return $log;
}


// qdm_battle_end()
//   Check if group wins game
//   that means no other player in opp teams
// parameters:
//   $players  - array - players structure
//   $grp      - array - players index team
// return:
//   bool - end of battle
// notes:
//   -
// dependencies:
//   -
// history:
//   -
function qdm_battle_end($players, &$grp){
    
    $keys = array_keys($grp);
    $ci   = count($grp);
    $res  = array();

    if( $ci < 2 ){

        // d_debug($grp, 'End of match');
        return true; // left 1 team
    }

    // All teams
    for( $i = 0; $i < $ci; $i++ ){ 

        $key = $keys[$i];

        $pl_keys = array_keys($grp[$key]);
        $cj = count($grp[$key]);

        // Inside 1 team
        for( $j = 0; $j < $cj; $j++ ){

            $pl_key = $pl_keys[$j];
            $index = $grp[$key][$pl_key];

            if( $players[$index]['hp'] > 0 ){ 
                $res[$key][] = $index;
                break;
            }
        }
    }

    $grp = $res;

    return false;
}


function qdm_stamina(&$player){
    
    
    $stamina = array();
    $time = time();
    $con  = $player['con'];
    $mins_passed = ($time - $player['utc_stamina'])/60;
    $stamina['cur'] = $player['stamina'] + round($mins_passed);
    $stamina['max'] = 50 + $player['con'] * 5;
    if( isset($player['stamina_max']) ) $stamina['max'] += $player['stamina_max'];
    if( $stamina['cur'] > $stamina['max'] ) $stamina['cur'] = $stamina['max'];
    $player['stamina'] = $stamina['cur'];



    $height = 130;
    $coef = $height/$stamina['max'];
    $stamina['left'] = ( $stamina['max'] == $stamina['cur']  ) ? 0 : $height - round(($stamina['cur'])*$coef);
    qdm_stamina_update($player);
    if( $mins_passed < 1 ) return $stamina;
    // d_echo($stamina);
    

    return $stamina;
}



?>
