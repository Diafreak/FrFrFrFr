<?php

class ShoppingCart extends Model
{
    const TABLENAME = 'shoppingcart';

    protected $schema =
    [
        'id'        => [ 'type' => Model::TYPE_UINT   ],
        'createdAt' => [ 'type' => Model::TYPE_STRING ],
        'updatedAt' => [ 'type' => Model::TYPE_STRING ],
        'user_id'   => [ 'type' => Model::TYPE_UINT   ]
    ];
}

?>