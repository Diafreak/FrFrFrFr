<?php

class ProductInShoppingCart extends Model
{
    const TABLENAME = 'productinshoppingcart';

    protected $schema =
    [
        'shoppingCart_id' => [ 'type' => Model::TYPE_UINT   ],
        'product_id'      => [ 'type' => Model::TYPE_UINT   ],
        'quantity'        => [ 'type' => Model::TYPE_UINT   ]
    ];
}

?>