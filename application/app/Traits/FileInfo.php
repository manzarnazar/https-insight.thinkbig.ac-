<?php

namespace App\Traits;

trait FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This trait basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo(){
        $data['withdrawVerify'] = [
            'path'=>'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      =>'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      =>'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/general/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/general',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/plugins',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      =>'assets/images/user/profile',
            'size'      =>'400x250',
        ];
        $data['adminProfile'] = [
            'path'      =>'assets/admin/images/profile',
            'size'      =>'400x400',
        ];
        $data['frontend'] = [
            'path'      =>'assets/images/frontend',
            'size'      =>'400x230'
        ];


        $data['episod'] = [
            'path'      =>'assets/images/frontend/episod',
            'size'      =>'400x230'
        ];

        $data['podcastEpisode'] = [
            'path'      =>'assets/images/podcast/episode',
            'size'      =>'400x230'
        ];

        $data['podcast'] = [
            'path'      =>'assets/images/podcastImage',
            'size'      =>'400x230'
        ];

        $data['category'] = [
            'path'      => 'assets/images/categoryImage',
            'size'      => '400x230'
        ];

        $data['episodePlayer'] = [
            'path'      => 'assets/images/podcast/episode',
        ];

        $data['blog'] = [
            'path'      =>'assets/images/frontend/blog',

        ];
        return $data;


	}




}
