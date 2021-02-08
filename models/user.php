<?php

class User extends Model
{
    const TABLENAME = 'user';

    protected $schema =
    [
        'id'           => [ 'type' => Model::TYPE_UINT   ],
        'createdAt'    => [ 'type' => Model::TYPE_STRING ],
        'updatedAt'    => [ 'type' => Model::TYPE_STRING ],
        'email'        => [ 'type' => Model::TYPE_STRING, 'max' => 120 ],
        'passwordHash' => [ 'type' => Model::TYPE_STRING, 'max' => 255 ],
        'firstName'    => [ 'type' => Model::TYPE_STRING, 'min' =>   2, 'max' =>  50 ],   //because Rhoshandiatellyneshiaunneveshenk Koyaanisquatsiuth
        'lastName'     => [ 'type' => Model::TYPE_STRING, 'min' =>   2, 'max' =>  50 ],
        'address_id'   => [ 'type' => Model::TYPE_UINT   ]
    ];
}

?>