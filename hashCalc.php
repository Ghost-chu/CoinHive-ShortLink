<?php

//You can write yourself hash calc method
function hashVerify($time, $hash)
{
    $result = base64_encode(base64_encode(base64_encode(md5(md5(md5(md5(md5(base64_encode(base64_encode(md5(base64_encode($time))))))))))));
    if ($result == $hash) {
        return true;
    } else {
        return false;
    }
}

function hashCalc($time)
{
    return base64_encode(base64_encode(base64_encode(md5(md5(md5(md5(md5(base64_encode(base64_encode(md5(base64_encode($time))))))))))));
}
