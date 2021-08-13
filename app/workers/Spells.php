<?php

namespace App\Workers;

class Spells
{
    private array $result;
    
    public function parse(): array
    {
        if (is_readable(app_path('app/config/spells.xml'))) {
            foreach (simplexml_load_file(app_path('app/config/spells.xml')) as $item) {
            	$item = get_object_vars($item);
                $spell = self::spellFactory($item);
                
                if (isset($item['vocation'])) {
                	$name = get_object_vars($item['vocation'][0]);
                	$this->result[$name['@attributes']['name']][] = $spell;
                } else {
                	$this->result['all'][$spell['lvl']] = $spell;
                }
               
            }
            
            ksort($this->result['all']);
            unset($this->result['None']);
        }
        
		return $this->result;
    }
    
    private static function spellFactory(array $spell): array
    {
    	$return = [];
	    $return['name'] = $spell['@attributes']['name'];
	    $return['words'] = $spell['@attributes']['words'];
	    $return['lvl'] = (int) $spell['@attributes']['lvl'];
	    $return['mana'] = $spell['@attributes']['mana'];
	    $return['exhausted'] = $spell['@attributes']['exhaustion'];
	    
	    return $return;
    }
}
