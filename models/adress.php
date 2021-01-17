<?php

class Address extends Model
{
    const TABLENAME = 'address';

    protected $schema =
    [
        'id'        => [ 'type' => Model::TYPE_UINT   ],
        'createdAt' => [ 'type' => Model::TYPE_STRING ],
        'updatedAt' => [ 'type' => Model::TYPE_STRING ],
        'zip'       => [ 'type' => Model::TYPE_STRING, 'min' => 5, 'max' => 5 ],
        'city'      => [ 'type' => Model::TYPE_STRING, 'max' => 50 ],
        'street'    => [ 'type' => Model::TYPE_STRING, 'max' => 70 ],
        'number'    => [ 'type' => Model::TYPE_STRING, 'max' => 4  ]
    ];
}

?>