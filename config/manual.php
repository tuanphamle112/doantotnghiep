<?php

return [
    'permission' => [
        'admin' => 1,
        'user' => 2,
    ],
    'pagination' => [
        'default' => 2,
        'user' => 8,
        'recipe' => 5,
        'category' => 2,
        'recipe_home' => 12,
        'comment' => 10,
        'post' => 10,
    ],
    'star_num' => [
        'be_commented' => 2,
        'recipe_be_loved' => 3,
        'post_actived' => 5,
        'recipe_actived' => 5,
    ],
    'gift_status' => [
        'Pending' => 0,
        'Shipped' => 1,
    ],
    'recipe_status' => [
        'Pending' => 0,
        'Actived' => 1,
        'Rejected' => 2,
    ],
    'post_status' => [
        'Pending' => 0,
        'Actived' => 1,
        'Rejected' => 2,
    ],
    'home_page' => [
        'take' => [
            'feature_recipe' => 6,
            'feature_post' => 6,
            'feature_member' => 6,
        ],
    ],
    'default_media' => [
        'logo' => 'images/logo.png',
        'avatar' => [
            'man' => '/images/default1.jpeg',
            'women' => '/images/default2.png',
        ],
        'recipe' => '/images/37.jpg',
    ],
    'recipe_url' => 'uploads/recipes/',
    'posts_url' => 'uploads/posts/',
];
