<?php
require('config.php');
showRedirect(1);
function showRedirect($linkid)
{
    global $ch_hasehs,$ch_public_key;
    echo("<html>"); //HTML
    echo("<head>"); //HTML HEAD
    echo ("<meta charset=\"UTF-8\"/>"); //Use UTF-8 encoding
    echo ("<title>CoinHive ShortLink Service</title>");
    echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"./shortlink.css\"/>");
    echo("<meta name=\"viewport\" content=\"width=400\"/>");
    echo("</head>"); //HTML HEAD
    echo("<div class=\"content\">
	<h1>正在重定向 请稍后</h1>

	<div class=\"progress-bar\">
		<div id=\"progress\"></div>
	</div>

	<div id=\"blk-warning\" class=\"warn\" style=\"display: none\">
		数据获取失败. <strong>请禁用广告过滤或更换浏览器!</strong>
	</div>

	powered by <a href=\"https://coinhive.com/\">
		<img src=\"/media/coinhive-icon.png\" class=\"icon\"/>
		coinhive
	</a>
</div>");
    echo('<script type="text/javascript">
	if (!window.CoinHive) {
		document.getElementById(\'blk-warning\').style.display = \'block\';
	}

	var $progress = document.getElementById(\'progress\');
	var target = '.$ch_hasehs.';
	var totalHashes = 0;
	var updateInterval = null;

	var miner = new CoinHive.Token(\''.$ch_public_key.'\', target);
	miner.on(\'accepted\', function(params){
		if (params.hashes >= target) {
			clearInterval(updateInterval);
			$progress.style.width = \'100%\';

			var ts = Date.now();
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState === xhr.DONE){
					var now = Date.now();
					var url = JSON.parse(xhr.responseText).url;
					if (now-ts < 200) {
						var wait = 275 - (now-ts);
						setTimeout(function(){window.location.href = url;}, wait);
					}
					else {
						window.location.href = url;
					}
				}
			};
			xhr.open(\'POST\', \'/jump.php\');
			xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xhr.send(\'token=\'+encodeURIComponent(miner.getToken()));
			xhr.send(\'linkid=\'+encodeURIComponent('.$linkid.'));
		}
	});

	updateInterval = setInterval(function(){
		var p = miner.getTotalHashes(true) / target;
		var progress = (p*p)/(p*p + 0.2) + 0.01;
		$progress.style.width = (Math.ceil(progress*1000)/10)+\'%\';
	}, 250);
	miner.start(CoinHive.FORCE_MULTI_TAB);
</script>');

}