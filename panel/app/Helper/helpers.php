<?php


if (!function_exists('gratavarUrl')) {
    
    /**
     * Gravatar URL from Email address.
     *
     * @param string $email   Email address
     * @param string $size    Size in pixels
     * @param string $default Default image [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $rating  Max rating [ g | pg | r | x ]
     *
     * @return string
     */
    function gravatarUrl($email, $size = 60, $default = 'mm', $rating = 'g')
    {
        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email)))."?s={$size}&d={$default}&r={$rating}";
    }
}

if (!function_exists('GUID')) {

    function GUID($length = 8) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}
