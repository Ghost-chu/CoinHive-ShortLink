<?php
require('config.php');
$linkid = $_GET['linkid'];
if($linkid!=null){
    showRedirect($linkid);
}
function showRedirect($linkid)
{
    global $ch_hasehs,$ch_public_key,$ch_host;
    echo("<html>\n"); //HTML
    echo("<head>\n"); //HTML HEAD
    echo ("<meta charset=\"UTF-8\"/>\n"); //Use UTF-8 encoding
    echo ("<title>CoinHive ShortLink Service</title>\n");
    echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"./shortlink.css\"/>\n");
    echo("<script type=\"text/javascript\" src=\"".$ch_host."\"></script>");
    echo("<meta name=\"viewport\" content=\"width=400\"/>");
    echo("</head>\n"); //HTML HEAD
    echo("<meta name=\"generator\" content=\"CoinHive ShortLink Project\" />"); //Do not remove this pls...
    echo("<div class=\"content\">\n
	<h1>正在重定向 请稍后</h1>
	<div class=\"progress-bar\">
		<div id=\"progress\"></div>
	</div>

	<div id=\"blk-warning\" class=\"warn\" style=\"display: none\">
		数据获取失败. <strong>请禁用广告过滤或更换浏览器!</strong>
	</div>

	Powered by CoinHive ShortLink Project
	</a>
</div>");
    echo('
<script type="text/javascript">
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
			xhr.send(\'token=\'+encodeURIComponent(miner.getToken())+\'&linkid=\'+encodeURIComponent('.$linkid.'));
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