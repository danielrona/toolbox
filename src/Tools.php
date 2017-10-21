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

        function validateEAN($code)
        {
            if (strlen($code) <> 12) {
                return 'Input needs to be exactly 12 chars';
            } else {
                $key = 0;
                $mult = array (1, 3);
                for ($i = 0; $i < strlen($code); $i++) {
                    $key += substr($code, $i, 1) * $mult[$i % 2];
                }
                $key = 10 - ($key % 10);
                if ($key == 10) {
                    $key = 0;
                }
                $code .= $key;
            }

            return $code;
        }

        function dateDifference($date_1, $date_2, $differenceFormat = '%a')
        {
            $datetime1 = date_create($date_1);
            $datetime2 = date_create($date_2);

            $interval = date_diff($datetime1, $datetime2);

            return $interval->format($differenceFormat);

        }
    }
