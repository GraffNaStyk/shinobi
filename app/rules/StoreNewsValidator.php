<?php

namespace App\Rules;

class StoreNewsValidator
{
    public function getRule(array $optional = []): array
    {
        return [
        	'title'      => 'required|string|min_len:5',
        	'created_by' => 'required|int',
        	'text'       => 'required',
        ];
    }
}
