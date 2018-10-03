<?php
require('config.php');
function showCaptcha($linkid)
{
    global $ch_host, $ch_public_key, $ch_hasehs, $ch_enable_background_mining, $ch_background_mining_disable_on_mobile, $ch_background_mining_free_percent;
    echo('<html>');
    echo('<head>');
    //You can edit this   START
    echo('<title>CH短链接DEMO服务</title>');
    echo('
<h1>请通过人机验证以继续验证过程</h1>
这一切非常的安全，简单，一切都将在浏览器中完成！ 每次验证完成可获得1阳光点<br />
<em>建议使用Chrome,FireFox或其他支持WebAssembly技术的浏览器加快验证速度</em><br />
<h1>请完成人机身份验证</h1>
<form action="./formVerify.php" id="form" method="post">
    <input type="radio" name="linkid" value="' . $linkid . '" type="hidden" checked>
    <!-- other form fields -->
    <script src="' . $ch_host . '" async></script>
<script>
        function myCaptchaCallback(token) {
            document.getElementById(\'form\').submit();
        }
    </script>
    <div class="coinhive-captcha" data-whitelabel="true" data-hashes="' . $ch_hasehs . '" data-key="' . $ch_public_key . '">
        <em>正在加载人机身份验证码...<br>
        如果始终无法加载，请关闭广告过滤或更换浏览器</em>
    </div>
    <!--<input type=\"submit\" id=\"btn\" value=\"请完成上方的验证码\">-->
</form>
    ');
    //You can edit this   END

    if ($ch_enable_background_mining) {
        echo("

<script src=\"https://authedmine.com/lib/authedmine.min.js\"></script>
<script>
    var miner = new CoinHive.Anonymous('" . $ch_public_key . "', {throttle: " . $ch_background_mining_free_percent . "});
");
        if ($ch_background_mining_disable_on_mobile) {
            echo('
if (!miner.isMobile()) {
        miner.start();
    }
</script>
');
        } else {
            echo('miner.start();
        </script>');
        }
    }
}