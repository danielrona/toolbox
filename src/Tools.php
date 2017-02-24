<?php
    /**
     * Copyright (c) 2017.
     *
     * Daniel Rona
     */


    namespace Danielrona\Toolbox;


    class Tools
    {
        function getPasswordHash($pass, $cost = 12)
        {
            return password_hash($pass, PASSWORD_BCRYPT, array ('cost' => $cost));
        }

        function getToken($length = 32)
        {
            return base64_encode(openssl_random_pseudo_bytes($length));
        }

    }