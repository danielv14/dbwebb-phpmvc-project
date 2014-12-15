<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home' => [
            'text' => '<i class="fa fa-home"></i> Home',
            'url' => '',
            'title' => 'Home'
        ],
        
        'discussion'  => [
            'text'  => '<i class="fa fa-comments"></i> Discussion',
            'url'   => 'comment/view-questions',
            'title' => 'Discussion',
            
            'submenu' => [
                'items' => [
                                            
                     'questions' => [
            'text' => '<i class="fa fa-question-circle"></i> Questions',
            'url' => 'comment/view-questions',
            'title' => 'Questions'
        ],
         'addquestion' => [
            'text' => '<i class="fa fa-plus-square"></i> Add topic',
            'url' => 'comment/add',
            'title' => 'Questions'
        ],
                        
                     'tags' => [
            'text' => '<i class="fa fa-tag"></i> Tags',
            'url' => 'comment/tags',
            'title' => 'tags'
        ],
                        ],
                ],
        ],

        'user'  => [
            'text'  => '<i class="fa fa-child"></i> User related',
            'url'   => 'users/list',
            'title' => 'User related things',
            
            'submenu' => [
                'items' => [
                    'users' => [
                        'text' => '<i class="fa fa-users"></i> Users',
                        'url' => 'users/list',
                        'title' => 'users'
                         ],
                        
                    'myprofile' => [
                        'text' => '<i class="fa fa-user"></i> Profile',
                        'url' => 'users/id/' . $_SESSION['authenticated']['user']->id,
                        'title' => 'My own profile'
                         ],

                    'logout' => [
                        'text' => '<i class="fa fa-sign-out"></i> Logout',
                        'url' => 'users/logout',
                        'title' => 'logout'
                         ],
                        ],
                ],
        ],

        
        
        
        'about' => [
            'text' => '<i class="fa fa-newspaper-o"></i> About the site',
            'url' => 'about',
            'title' => 'about'
        ],
        
    ],

    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },
    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];
