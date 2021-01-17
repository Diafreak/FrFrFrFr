<?php

class Category extends Model
{
    const TABLENAME = 'category';

    protected $schema =
    [
        'id'        => [ 'type' => Model::TYPE_UINT   ],
        'createdAt' => [ 'type' => Model::TYPE_STRING ],
        'updatedAt' => [ 'type' => Model::TYPE_STRING ],
        'name'      => [ 'type' => Model::TYPE_STRING, 'max' => 50 ]
    ];
}

?>