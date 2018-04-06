<?php
return  [
        'theme'                         => env("THEME"),
        'slider_puth'                   => 'slider-cycle',
        'home_portfolio_count'          => -5,
        'non_portfolio'                 => 'Портфолио отсутствуют!',
        'articles_only'                 => ['name', 'img', 'created_at', 'alias'],
        'home_articles_count'           => 3,
        'paginate'                      => 2,

        'latest_portf_articl_bar'       => -3,
        'latest_comm_articl_bar'        => -2,

        'all_portfolio_count'           => -2,

        'enter_to_admin'                =>[
                                            'login'    => 'Введите логин',
                                            'password' => 'Введите пароль'
                                            ],

        'size_articles_img'             => [
                                            'mini'=>['width' => 55, 'height' => 55],
                                            'max' => ['width' => 816, 'height' => 282]
                                            ],

        'image_for_server'              => [
                                            'width' => 1024,
                                            'height' =>768
                                                ],
        'size_portfolio_img'            => [
                                            'mini' => ['width'=>55, 'height' => 55 ],
                                            'max' => ['width'=> 770, 'height' => 368]
                                            ],





];
