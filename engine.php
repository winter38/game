<?php
/*

Game engine - may be used for different games

Notes:
*Some fitures and player stats used for box game, u may not use it

*/

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
// ---------------------------------------------------------------------------->


// Some information to me
// If player have 0 hp - knockout
// Нокаут см Нок англ knockout удар сбивающий с ног состояние боксёра характеризующееся головокружением частичной или полной потерей ориентации а иногда...
// Полная информация о понятии Нокаут

// Согласно общепринятому определению, Нокаут (см. Нок) (англ. knock-out - удар, сбивающий с ног), состояние боксёра, 
// характеризующееся головокружением, частичной или полной потерей ориентации, а иногда и сознания, 
// возникшее в результате полученного удара. В состоянии Н. спортсмен не может продолжать поединок. 
// Боксёру, проигравшему бой Н., как правило, запрещается участвовать в соревнованиях не менее 3 мес. 
// С ростом мастерства боксёров значительно сокращаются случаи Н. Так, на первенствах СССР (см. СССР) 1970-73 зафиксировано лишь около 1,5% побед Н.


// Fill basic player structure
function init_player($id = false){
    
    // Default values --------------------------------------------------------->
    $s = array();
    $s['dex'] = 0;   // dexterity
    $s['str'] = 0;   // srtength
    $s['con'] = 0;   // constitution
    $s['end'] = 0;   // endurance
    $s['acc'] = 1;   // accuracy, default 100%
    $s['eva'] = 0.1; // evasion,  default 10%
    $s['block'] = 0.3; // block, default 30%
    $s['st'] = 100; // stamina  
    $s['hp'] = 100; // health points
    $s['mp'] = 100; // mana points
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
    $s['hp']      += $s['con']*5;
    $s['dmg']     = 4 + floor($s['str']/5); // Max damage
    $s['dmg+']    = floor($s['str']/3); // bonus damage
    
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


// Hit example ---------------------------------------------------------------->
// min accuracity  10% - 15%
// Difference between players dex gives or removes accuracy (for 1player its accuracy, for 2player evasion)
$dif = abs($p1['dex']-$p2['dex']) * $game['dex_bonus']; // 1 dex = 1% accuracy/evasion

$p1['acc'] += $dif; // change p1 acc

$hit_chance = $p1['acc'] - $p2['eva'];
$hit   = mt_frand();
$block = mt_frand();
$d_dmg = mt_rand(1, $p1['dmg']);

$dmg = $d_dmg + $p1['dmg+'];

if( $hit_chance >= $hit ){
    // Ok, player hitted his targer, now, opponent action
    
    if( $p2['block'] >= $block ){ // opponent have blocked that hit!
        // hit to block - to stamina and hp?
        // Block decreases damage
        if( $p2['st'] < $dmg ){
            $dmg = $p2['st'] - $dmg; // part of damage taken by stamina
            $p2['hp'] -= $dmg;
        }
        else{
            $p2['hp'] -= $dmg;
        }
    }
    else{ // opponent haven`t blocked
       
        // it`s dirrect hit to hp
        $p2['hp'] -= $dmg;
        if( $p1['st'] < $dmg ) $dmg = $p1['st']; // For damage we need stamina
        $p1['st'] -= $dmg;
    }
}
else{
    // miss
}
// ---------------------------------------------------------------------------->



// Battle --------------------------------------------------------------------->
if( $game['rounds'] ) $counter = $game['rounds'];
while( 1 ){ // yes, always!
    
    
    for( $i = 0; $i < $game['round_hits']; $i++ ){

        // players hits
    }
    
    
    // End condition --------------------------------------------------------->>
    if( $game['rounds'] ){
        $counter--;
        if( $counter =< 0 ) break; // Round 0 - end of battle
    }
    else{
        // Check if player has 0hp
    }
    // ----------------------------------------------------------------------->>
}
// ---------------------------------------------------------------------------->

// $p1 hits $p2 - only 1 hit!
function player_hit($p1, $p2){
    
}

 
?>
