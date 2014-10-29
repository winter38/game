1. make live battle structure (include battlefield envirment, user structure,)
2. Structure will be serialized (only of battle, other must be in table) 
3. Each time page called - will draw battle from serialized structure
4. Processors of battle will update structure


battle
  id
  current_round
  state
  player  - player structure with current states
  enemies - array with enemies structures




resits and elements
Damage can have element 
 - no element
 - fire
 - water
 - earth
 - wind

can have many elements, but sum only 100% (fire 5% + 95% non elemental)
  
