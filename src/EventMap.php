<?php

namespace GSManager\AuthenticationLog;

trait EventMap
{
    /**
     * The Authentication Log event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        'Illuminate\Auth\Events\Login' => [
            'GSManager\AuthenticationLog\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'GSManager\AuthenticationLog\Listeners\LogSuccessfulLogout',
        ],
    ];
}
