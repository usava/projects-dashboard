<?php

/**
 * @param $email
 * @param string $size
 * @return string
 */
function gravatar_url($email, $size = '60')
{
    $email = md5($email);

    return "https://gravatar.com/avatar/{$email}?s={$size}";
}
