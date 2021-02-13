<?php

class ProductTags extends Model
{
    const TABLENAME = 'producttags';

    protected $schema =
    [
        'id'        => [ 'type' => Model::TYPE_UINT   ],
        'createdAt' => [ 'type' => Model::TYPE_STRING ],
        'updatedAt' => [ 'type' => Model::TYPE_STRING ],
        'tags'      => [ 'type' => Model::TYPE_STRING, 'max' => 255 ]
    ];
}

?>