<?php

function mt_frand(){
    return mt_rand() / mt_getrandmax();
}




function tree_tis(){

    $ar = array();
    $ar['name'] = 'Тисовое дерево';
	$ar['item_id'] = 1;
	$ar['weight'] = 1;
	$ar['chance'] = 1;
    $ar['count_min'] = 1;
    $ar['count_max'] = 2;
    
    
    return $ar;
}

function tree_pihta(){

    $ar = array();
    $ar['name'] = 'Пихта';
	$ar['item_id'] = 1;
	$ar['weight'] = 1;
	$ar['chance'] = 1;
    $ar['count_min'] = 1;
    $ar['count_max'] = 2;
    $ar['hp'] = 5;
    
    return $ar;
}

function tree_sosna(){

    $ar = array();
    $ar['name'] = 'Сосна';
	$ar['item_id'] = 1;
	$ar['weight'] = 1;
	$ar['chance'] = 1;
    $ar['count_min'] = 1;
    $ar['count_max'] = 2;
    
    return $ar;
}

function tree_el(){

    $ar = array();
    $ar['name'] = 'Ель';
	$ar['item_id'] = 1;
	$ar['weight'] = 1;
	$ar['chance'] = 1;
    $ar['count_min'] = 1;
    $ar['count_max'] = 2;
    $ar['hp'] = 10;
    
    return $ar;
}


function qdm_ores(){

	$res = array();
	$ar = array();
	$ar['name'] = 'Медь';
	$ar['item_id'] = 1; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.6;


	$res[] = $ar;


	$ar['name'] = 'Железистый кварцит';
	$ar['item_id'] = 2;
	$ar['weight'] = 40;
	$ar['chance'] = 0.4;


	$res[] = $ar;

	return $res;

}


function qdm_herbs(){

	$res = array();
	$ar = array();
	$ar['name'] = 'Листья черного чая';
	$ar['item_id'] = 1001; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.6; // chance


	$res[] = $ar;


	$ar['name'] = 'Листя зеленного чая';
	$ar['item_id'] = 1002;
	$ar['weight'] = 60;
	$ar['chance'] = 0.4;


	$res[] = $ar;

	return $res;

}


function qdm_wood(){

	$res = array();
	$ar = array();
	$ar['name'] = 'бревно Сосны';
	$ar['item_id'] = 2001; 
 	$ar['weight'] = 100;
	$ar['chance'] = 0.6;


	$res[] = $ar;


	$ar['name'] = 'бревно Сосны';
	$ar['item_id'] = 2001;
	$ar['weight'] = 60;
	$ar['chance'] = 0.4;


	$res[] = $ar;

	return $res;

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

$items = qdm_herbs();
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

?>
