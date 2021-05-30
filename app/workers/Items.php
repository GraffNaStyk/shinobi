<?php

namespace App\Workers;

use App\Helpers\Storage;
use App\Model\Item;

class Items
{
    protected static array $itemTypes = [
        'sword', 'distance', 'axe', 'fist',
        'body', 'legs', 'feet', 'head', 'ring',
        'necklace'
    ];
    
    protected static array $attributes = [
        'attack' => 'attack',
        'defense' => 'defense',
        'armor' => 'defense',
        'description' => 'description',
        'range' => 'range',
        'weight' => 'weight',
        'extradef' => 'jutsu_damage',
        'skillfish' => 'extra_def',
        'absorbPercentAll' => 'protection_all',
	    'skillfist' => 'attack_speed',
	    'skillclub' => 'critical_chance',
	    'skillsword' => 'sword_fighting',
	    'skillaxe' => 'glove_fighting',
	    'skilldist' => 'distance_fighting',
	    'maxhitpoints' => 'health',
	    'maxmanapoints' => 'chakra',
	    'healthgain' => 'health_regen',
	    'managain' => 'chakra_regen',
    ];
    
    protected static array $mapTypeToModel = [
        'sword' => 'swords',
        'distance' => 'distance',
        'axe' => 'glovers',
        'body' => 'armors',
        'legs' => 'legs',
        'feet' => 'boots',
        'head' => 'helmets',
        'ring' => 'belts',
        'necklace' => 'robes'
    ];
    
    protected static array $return = [];
    
    public function __construct()
    {
    	$this->parse();
    }
    
    public static function parse()
    {
        $others = [];
        if (is_readable(app('ots.items_path'))) {
            foreach (simplexml_load_file(app('ots.items_path')) as $item) {
                $item = get_object_vars($item);
                $key = self::isInTypes($item);
                
                if ((bool) $key === true) {
                    self::$return[$key][] = self::getAttributes($item);
                } else {
                    $others[] = $item;
                }
            }
        } else {
            exit('file not exist');
        }

        foreach (self::$return as $key => $items) {
            foreach ($items as $item) {
                $item['type'] = self::$mapTypeToModel[$key];
                
                if (! isset($item['description'])) {
                    $item['description'] = '';
                }
				
                if (Image::get((int) $item['cid'], $item['name'])) {
	                Item::onDuplicate(['cid'])->insert($item)->exec();
                }
                
            }
        }
        
//        self::parseOtherItems($others);
    }
    
    protected static function isInTypes($item)
    {
        if (!isset($item['attribute'])) {
            return false;
        }
        
        $key = false;
        
        foreach ($item['attribute'] as $attr) {
            $attr = get_object_vars($attr['value'])[0];
            
            if (in_array($attr, self::$itemTypes)) {
                $key = $attr;
                break;
            }
        }
        
        return $key;
        
    }
    
    protected static function getAttributes($item)
    {
        $return = [
            'name' => $item['@attributes']['name'],
            'cid' => (int) $item['@attributes']['id']
        ];

        foreach ($item['attribute'] as $attr) {
            $attr = get_object_vars($attr)['@attributes'];
     
            if (isset(self::$attributes[strtolower($attr['key'])])) {
                $return[self::$attributes[strtolower($attr['key'])]] = $attr['value'];
            }
        }
        
        return $return;
    }
    
    protected static function parseOtherItems(array $others)
    {
        foreach ($others as $other) {
            if (isset($other['attribute'])) {
                $insert = false;
                $data = [];
                if (empty(get_object_vars($other['attribute']))) {
                    foreach ($other['attribute'] as $attr) {
                        $attr = get_object_vars($attr);
        
                        if ($attr['@attributes']['key'] === 'weight') {
                            $insert = true;
                            $data['weight'] = $attr['@attributes']['value'];
                        }
                        if ($attr['@attributes']['key'] === 'description') {
                            $data['description'] = $attr['@attributes']['value'];
                        }
                    }
                } else {
                    $item = get_object_vars($other['attribute']);
                    
                    if ($item['@attributes']['key'] === 'weight') {
                        $insert = true;
                        $data['weight'] = $item['@attributes']['value'];
                    }
                    if ($item['@attributes']['key'] === 'description') {
                        $insert = true;
                        $data['description'] = $item['@attributes']['value'];
                    }
                }
                
                if ($insert && (bool) preg_match('/dead/i', $other['@attributes']['name']) === false) {
                    $data['name'] = $other['@attributes']['name'];
                    $data['cid'] = (int) $other['@attributes']['id'];
                    $data['type'] = 'item';
                    Item::insert($data);
                    self::getImage((int) $other['@attributes']['id'], $other['@attributes']['name'], 'items');
                }
            }
        }
    }
}
