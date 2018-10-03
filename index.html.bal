<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建属于你自己的短链接！</title>
    <script type="text/javascript" src="base64.js"></script>
</head>
<body>
<script>
    function submitForm(url) {
        var xhr = new XMLHttpRequest();
        url = Base64.encode(url);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === xhr.DONE) {
                var now = Date.now();
                var reurl = "http://link.mcsunnyside.com/showRedirect.php?linkid=" + xhr.responseText;
                console.info("您的URL为："+reurl);
                document.write("您的URL为："+reurl+"<br/>");
                alert("您的URL为："+reurl);
            }
        };
        xhr.open('POST', '/linkManager.php');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('type=' + encodeURIComponent('addlink') + '&arg=' + encodeURIComponent(url));

    }
</script>
<form id="form" name="form" action="linkManager.php" method="POST">
    <span>请输入需要缩短(变长)的URL:</span><input type="text" name="urlBox" id="urlBox" value="http://www.baidu.com">
    <button type="button" name="submitButton" href="javascript:void(0);" id="submitButton"
            onclick="submitForm(document.getElementById('urlBox').value)">确定喵
    </button>
</form>

</body>
</html>