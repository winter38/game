<?php

function mt_frand(){
    return mt_rand() / mt_getrandmax();
}


function tree_tpl(){
    
    $res = array();
    $res['name'] = 'No name';  // name of item
	$res['item_id'] = 0;       // id for or from DB
	$res['weight'] = 1;        // to select among other items - more weight, more chance
	$res['chance'] = 1;        // chance to get this item (1 = 100%)
    $res['count_min'] = 1;     // Min items
    $res['count_max'] = 1;     // Max items
    $res['hp'] = 5;            // Durability of item (TBD)
    $res['price_min'] = 1;     // Min price - default price at shop
    $res['price_max'] = 10;    // Max price - at shop with + at barter
    
    return $res;
}


function ore_tpl(){
    
    $res = array();
    $res['name'] = 'No name';  // name of item
	$res['item_id'] = 0;       // id for or from DB
	$res['weight'] = 1;        // to select among other items - more weight, more chance
	$res['chance'] = 1;        // chance to get this item (1 = 100%)
    $res['count_min'] = 1;     // Min items
    $res['count_max'] = 1;     // Max items
    // $ar['hp'] = 5;          // Durability of item (TBD)
    $res['price_min'] = 1;     // Min price - default price at shop
    $res['price_max'] = 10;    // Max price - at shop with + at barter
    
    return $res;
}

function fruit_tpl(){
    
    $res = array();
    $res['name'] = 'No name';  // name of item
	$res['item_id'] = 0;       // id for or from DB
	$res['weight'] = 1;        // to select among other items - more weight, more chance
	$res['chance'] = 0.05;     // chance to get this item (1 = 100%)
    $res['count_min'] = 1;     // Min items
    $res['count_max'] = 1;     // Max items
    $res['price_min'] = 1;     // Min price - default price at shop
    $res['price_max'] = 8;     // Max price - at shop with + at barter
    // $ar['hp'] = 5;          // Durability of item (TBD)
    
    return $res;
}


function herb_tpl(){
    
    $res = array();
    $res['name'] = 'No name';  // name of item
	$res['item_id'] = 0;       // id for or from DB
	$res['weight'] = 1;        // to select among other items - more weight, more chance
	$res['chance'] = 1;        // chance to get this item (1 = 100%)
    $res['count_min'] = 1;     // Min items
    $res['count_max'] = 1;     // Max items
    // $ar['hp'] = 5;            // Durability of item (TBD)
    $res['price_min'] = 1;     // Min price - default price at shop
    $res['price_max'] = 10;    // Max price - at shop with + at barter
    
    return $res;
}


function jewel_tpl(){
    
    $res = array();
    $res['name'] = 'No name';  // name of item
	$res['item_id'] = 0;       // id for or from DB
	$res['weight'] = 1;        // to select among other items - more weight, more chance
	$res['chance'] = 0.05;     // chance to get this item (1 = 100%)
    $res['count_min'] = 1;     // Min items
    $res['count_max'] = 1;     // Max items
    $res['price_min'] = 10;    // Min price - default price at shop
    $res['price_max'] = 100;   // Max price - at shop with + at barter
    // $ar['hp'] = 5;          // Durability of item (TBD)
    
    return $res;
}

// Trees ---------------------------------------------------------------------->
function tree_tis(){

    $ar = tree_tpl();
    $ar['name'] = 'Тисовое дерево';
	$ar['item_id'] = 1;
    
    return $ar;
}

function tree_pihta(){

    $ar = tree_tpl();
    $ar['name'] = 'Пихта';
	$ar['item_id'] = 2;
    
    return $ar;
}

function tree_sosna(){

    $ar = array();
    $ar['name'] = 'Сосна';
	$ar['item_id'] = 3;
    
    return $ar;
}

function tree_el(){

    $ar = array();
    $ar['name'] = 'Ель';
	$ar['item_id'] = 4;
    
    return $ar;
}
// ---------------------------------------------------------------------------->


// Ores ----------------------------------------------------------------------->
function ore_stone(){

    $res = ore_tpl();
	$res['name'] = 'Камень';
	$res['item_id'] = 1; 
    
    return $res;
}


function ore_iron(){

    $res = ore_tpl();
	$res['name'] = 'Железная руда';
	$res['item_id'] = 1; 
    
    return $res;
}


function ore_copper(){

    $res = ore_tpl();
	$res['name'] = 'Медная руда';
	$res['item_id'] = 2; 
    
    return $res;
}


function ore_tin(){

    $res = ore_tpl();
	$res['name'] = 'Кристаллы касситерита'; // олово
	$res['item_id'] = 3; 
    
    return $res;
}



function ore_silver(){

    $res = ore_tpl();
	$res['name'] = 'Серебряный самородок';
	$res['item_id'] = 3; 
    
    return $res;
}


function ore_gold(){

    $res = ore_tpl();
	$res['name'] = 'Золотой самородок';
	$res['item_id'] = 4; 
    
    return $res;
}

function ore_titan(){

    $res = ore_tpl();
	$res['name'] = 'Титанит (Титановая руда)';
	$res['item_id'] = 5; 
    
    return $res;
}


function ore_mithril(){

    $res = ore_tpl();
	$res['name'] = 'Мифриловая руда';
	$res['item_id'] = 7; 
    
    return $res;
}

function ore_adamantin(){

    $res = ore_tpl();
	$res['name'] = 'Адамантин';
	$res['item_id'] = 8; 
    
    return $res;
}
// ---------------------------------------------------------------------------->

// 3 ores = bar

// tin + coppen = bronze




// Jewels --------------------------------------------------------------------->
function jewel_crystal(){

    $res = jewel_tpl();
	$res['name'] = 'Кристалл';
	$res['item_id'] = 1; 
    
    return $res;
}


function jewel_topaz(){

    $res = jewel_tpl();
	$res['name'] = 'Топаз';
	$res['item_id'] = 2; 
    
    return $res;
}

function jewel_emerald(){

    $res = jewel_tpl();
	$res['name'] = 'Изумруд';
	$res['item_id'] = 3; 
    
    return $res;
}

function jewel_ruby(){

    $res = jewel_tpl();
	$res['name'] = 'Рубин';
	$res['item_id'] = 4; 
    
    return $res;
}

function jewel_diamond(){

    $res = jewel_tpl();
	$res['name'] = 'Алмаз';
	$res['item_id'] = 5; 
    
    return $res;
}

function jewel_sapphire(){

    $res = jewel_tpl();
	$res['name'] = 'Сапфир';
	$res['item_id'] = 6; 
    
    return $res;
}

// ---------------------------------------------------------------------------->


function herb_green_tea(){

    $ar = herb_tpl();
	$ar['name'] = 'Листя зеленного чая';
	$ar['item_id'] = 1002;
	$ar['weight'] = 60;
	$ar['chance'] = 0.4;
}

function herb_gback_tea(){

    $res = array();
	$ar = herb_tpl();
	$ar['name'] = 'Листья черного чая';
	$ar['item_id'] = 1001; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.6;
}


function herb_lily(){

    $res = array();
	$ar = herb_tpl();
	$ar['name'] = 'Лилия';
	$ar['item_id'] = 1001; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.4;
}

function herb_rose(){

    $res = array();
	$ar = herb_tpl();
	$ar['name'] = 'Роза';
	$ar['item_id'] = 1001; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.4;
}

function herb_blueberry(){

    $res = array();
	$ar = herb_tpl();
	$ar['name'] = 'Куст черники';
	$ar['item_id'] = 1001; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.4;
}

function herb_ginseng(){

    $res = array();
	$ar = herb_tpl();
	$ar['name'] = 'Женьшень';
	$ar['item_id'] = 1001; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.4;
}


/* FRUITS */
function fruit_blueberry(){

    $res = array();
	$ar = herb_tpl();
	$ar['name'] = 'Черника';
	$ar['item_id'] = 1; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.4;
}



function qdm_ores(){
    
    $res = array();
	$res[] = ore_stone();
    $res[] = ore_iron();
    $res[] = ore_copper();
    $res[] = ore_tin();
    $res[] = ore_silver();
    $res[] = ore_gold();
    $res[] = ore_titan();
    $res[] = ore_mithril();
    $res[] = ore_adamantin();

	return $res;

}

function jewels(){

    $res = array();
    
    $res[] = jewel_crystal();
    $res[] = jewel_topaz();
    $res[] = jewel_emerald();
    $res[] = jewel_ruby();
    $res[] = jewel_diamond();
    $res[] = jewel_sapphire();
    
    return $res;
}

function qdm_herbs(){

	$res = array();
	$res[] = herb_green_tea();
    $res[] = herb_gback_tea();
    $res[] = herb_lily();
    $res[] = herb_ginseng();
    $res[] = herb_blueberry();
    $res[] = herb_lily();

	return $res;

}

function qdm_locations(){
    
    // Tmp location and dungeon names
    $res = array();
    $res[] = 'Забытые земли';
    $res[] = 'Драконьи горы';
    $res[] = 'Лунный лес';
    $res[] = 'Лабиринт забвения';
    $res[] = 'Бесконечные пески';
    $res[] = '';
    $res[] = '';
    $res[] = '';
    
}


function qdm_fishing(){
    
    // fish
    // some chests
    // pearl?
    
}



// Select random item
function qdm_select_prof_item($items, &$log = array()){

    // more weight = more chance (among weight);
    // chance 1 = 100%
    
    // Take all items --------------------------------------------------------->
    $ci = count($items);
    $keys = array_keys($items);
    $chances = array();
    for($i = 0; $i < $ci; $i++){
        
        $key = $keys[$i];
        $tmp = array();
        $tmp['name'] = $key;
        $tmp['chance'] = $items[$key]['chance'];
        $tmp['weight'] = $items[$key]['weight'];
        $chances[] = $tmp;
    }
    // ------------------------------------------------------------------------>
    

    // Calc total weight and select among them -------------------------------->
    $ci = count($chances);
    $total_weight = 0;
    $cum_weight = array();
    for( $i = 0; $i < $ci; $i++ ){

        $total_weight += $chances[$i]['weight']*100; // may be as % 0.1
        $cum_weight[] = $total_weight;

    }

    $select = mt_rand(1, $total_weight);
    $log['weight_select'] = $select;
    $log['weights'] = $cum_weight;
    $log['items'] = $items;
    // ------------------------------------------------------------------------>
    
    
    // Select item ------------------------------------------------------------>
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

    $item = $items[$keys[$index]];
    $chance = mt_frand();
    $log['dice'] = $chance;
    $log['item_chance'] = $item['chance'];

    // Chance to activate item
    if( $chance > $item['chance'] ) return false; // No item
    
    
    
	return $item;
}

$items = array(jewel_sapphire());
$item  = qdm_select_prof_item($items, $log);
d_echo($log);
d_echo($item);

// $skill_id = S_PROF_MINER;
// if( isset($player['skills'][$skill_id]) ){
   	
	// $skill_info = calc_level($player['skills'][$skill_id]['exp']);

	// $ores = qdm_ores();
	// $ore = qdm_select_prof_item($ores);
	// $chance = mt_rand(1, 100);
	// $bonus = $skill_info['lvl'];
	// if( $chance > ((100-$ore['c']*100)+$bonus) ){
		// $tmp = array();
		// $tmp['msg'] = ' Вы добыли ' . $ore['name'];
		// $tmp['date'] = date('d.m.Y H:m:s', time());
		// $_SESSION['mining'][] = $tmp;
		// qdm_player_items_add($player['id'], $ore['item_id'], 1);

		// $exp = 50 + 30*(1 - $ore['c'])*$skill_info['lvl'];
		// qdm_skill_update_exp($player['id'], $skill_id, $exp);
	// }
	// else{
		// $tmp = array();
		// $tmp['msg'] = 'Руда не найдена';
		// $tmp['date'] = date('d.m.Y H:m:s', time());
		// $_SESSION['mining'][] = $tmp;
		// qdm_skill_update_exp($player['id'], $skill_id, $skill_info['lvl']*10);
	// }

	// // d_echo($_SESSION['mining']); die;
	// qdm_statistic_update($player['id'], array('mining' => 1));

	// $player['stamina'] = $player['stamina'] - 10;
	// qdm_stamina_update($player);
// }

d_echo('test');
die;



// Sript to multiplayer round by round

// if( !isset($_SESSION['player']) ){
    // $_SESSION['player'] = 'player ' . time();
    // $_SESSION['hp'] = 100;
// }

// 1. set ts of round start in db, count players
// 2. wait for player actions - if scipt is called
// 2.1. read from db params of round - (if player counts not all and round time still goes, just save player actions)
// 2.2. if all players done or time is up - cacl result - write result to db

?>
