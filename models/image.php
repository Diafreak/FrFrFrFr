<?php

class Image extends Model
{
    const TABLENAME = 'image';

    protected $schema =
    [
        'id'         => [ 'type' => Model::TYPE_UINT   ],
        'createdAt'  => [ 'type' => Model::TYPE_STRING ],
        'updatedAt'  => [ 'type' => Model::TYPE_STRING ],
        'imageUrl'   => [ 'type' => Model::TYPE_STRING, 'max' => 255 ],
        'altText'    => [ 'type' => Model::TYPE_STRING, 'max' => 100 ],
        'product_id' => [ 'type' => Model::TYPE_UINT   ]
    ];
}

?>