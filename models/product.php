<?php

class Product extends Model
{
    const TABLENAME = 'product';

    protected $schema =
    [
        'id'             => [ 'type' => Model::TYPE_UINT   ],
        'createdAt'      => [ 'type' => Model::TYPE_STRING ],
        'updatedAt'      => [ 'type' => Model::TYPE_STRING ],
        'name'           => [ 'type' => Model::TYPE_STRING ],
        'price'          => [ 'type' => Model::TYPE_DECIMAL, 'max' =>   4 ],
        'numberInStock'  => [ 'type' => Model::TYPE_INT    ],
        'description'    => [ 'type' => Model::TYPE_STRING,  'max' => 300 ],
        'category_id'    => [ 'type' => Model::TYPE_UINT   ],
        'productTags_id' => [ 'type' => Model::TYPE_UINT   ]
    ];
}

?>