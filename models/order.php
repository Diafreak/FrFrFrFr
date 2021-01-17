<?php

class Order extends Model
{
    const TABLENAME = 'order';

    protected $schema =
    [
        'id'        => [ 'type' => BaseModel::TYPE_UINT   ],
        'createdAt' => [ 'type' => BaseModel::TYPE_STRING ],
        'updatedAt' => [ 'type' => BaseModel::TYPE_STRING ],
        'user_id'   => [ 'type' => BaseModel::TYPE_UINT   ]
    ];
}

?>