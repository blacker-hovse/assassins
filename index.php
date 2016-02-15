<?
include(__DIR__ . '/../../lib/md/Michelf/MarkdownExtra.inc.php');
$year = 1970;
$scores = array();
$handle = fopen(__DIR__ . '/src/scores.yaml', 'r');
$scoring = false;

while ($buffer = rtrim(fgets($handle))) {
	if (preg_match('/^year: (\d+)$/', $buffer, $matches)) {
		$year = $matches[1];
	} elseif ($buffer == 'scores:') {
		$scoring = true;
	} elseif ($scoring and preg_match('/^ +(.+): (-?\d+)$/', $buffer, $matches)) {
		$scores[$matches[1]] = (int) $matches[2];
	}
}

$max = max(50, max($scores));
$min = min(-50, min($scores));
$page = isset($_GET['p']) ? htmlentities($_GET['p'], NULL, 'UTF-8') : 'logs';
$dir = $page == 'logs' ? '.' : '..';
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Alley Assassins <?
echo $year;
?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="//fonts.googleapis.com/css?family=Share+Tech+Mono|Audiowide" rel="stylesheet" type="text/css" />
		<link href="<?
echo $dir;
?>/assassins.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			.progress .negative {
				width: <?
echo -$min / ($max - $min) * 100 - 1;
?>%;
			}
			.progress .positive {
				width: <?
echo $max / ($max - $min) * 100 - 1;
?>%;
			}
		</style>
		<script type="text/javascript">// <![CDATA[
			document.onmousemove = function(e) {
				document.body.style.backgroundPosition = -e.clientX / 80 + 'px';
			}

			var j = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
			var k = [];

			document.onkeydown = function(e) {
				var h = true;

				if (k.length == 10) {
					k.shift();
				}

				k.push(e.keyCode);

				for (var i = 0; i < 10; i++) {
					h &= j[i] == k[i];
				}

				if (h) {
					document.getElementsByTagName('h1')[0].firstChild.firstChild.nodeValue = 'Slain Asses Slay';
					var g = document.getElementsByClassName('progress');

					for (var i = 0; i < g.length; i++) {
						g[i].className += ' konami';
					}
				}
			}
		// ]]></script>
		<script type="text/javascript">// <![CDATA[
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-65942614-1', 'auto');
          ga('send', 'pageview');
        // ]]></script>
	</head>
	<body>
		<h1><span>Alley Assassins</span> <?
echo $year;
?></h1>
		<div id="links" class="block">
<?
echo <<<EOF
			<p>
				<a href="$dir/" class="btn">Logs</a>
				<a href="$dir/targets/" class="btn">Targets</a>
				<a href="$dir/rules/" class="btn">Rules</a>
			</p>
			<p class="small"><a href="$dir/../survival.pdf">SURVIVAL GUIDE</a> &middot; web design by <a href="http://dt.clrhome.org/">DT</a></p>

EOF;
?>		</div>
		<div id="scores" class="block">
			<h2>Scores</h2>
			<div class="container">
				<div class="outer">
					<div class="inner">
						<table class="content">
<?
foreach ($scores as $alley => $score) {
	$number = str_replace('-', '&minus;', $score);
	$negative = 0;
	$positive = 0;

	if ($score < 0) {
		$negative = $score / $min * 100;
	} else {
		$positive = $score / $max * 100;
	}

	echo <<<EOF
							<tr>
								<td>$alley</td>
								<td class="progress" title="$number">
									<span class="negative">
										<span style="width: $negative%;">
											<span class="bar">&nbsp;</span>
										</span>
									</span>
									<span class="positive">
										<span style="width: $positive%;">
											<span class="bar">&nbsp;</span>
										</span>
									</span>
								</td>
							</tr>

EOF;
}
?>						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="<?
echo $page;
?>" class="main block">
			<h2><?
echo $page;
?></h2>
			<div class="container">
				<div class="outer">
					<div class="inner">
						<div class="content">
<?
echo str_replace('h2>', 'h3>', \Michelf\MarkdownExtra::defaultTransform(file_get_contents(__DIR__ . "/src/$page.md")));
?>						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
