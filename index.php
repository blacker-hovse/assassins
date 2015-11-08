<?
include(__DIR__ . '/lib/md/Michelf/MarkdownExtra.inc.php');

$scores = array(
	'Cannes' => 0,
	'Fort Knight' => 0,
	'Heaven' => 0,
	'Hell' => 0,
	'Misc. Off' => 0,
	'Munth' => 0,
	'Pub' => 0,
	'Swamp' => 0,
	'Tunnel' => 0,
	'Upper P' => 0,
	'Vatikremlin' => 0,
	'Womb' => 0
);

$max = max(100, max($scores));
$min = min(-50, min($scores));
$page = isset($_GET['p']) ? htmlentities($_GET['p'], NULL, 'UTF-8') : 'logs';
$dir = $page == 'logs' ? '.' : '..';
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Alley Assassins 2015</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="//fonts.googleapis.com/css?family=Share+Tech+Mono|Audiowide" rel="stylesheet" type="text/css" />
		<link href="<?
echo $dir;
?>/lib/css/assassins.css" rel="stylesheet" type="text/css" />
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
		// ]]></script>
	</head>
	<body>
		<h1>Alley Assassins 2015</h1>
		<div id="links" class="block">
			<p>
<?
echo <<<EOF
				<a href="$dir/" class="btn">Logs</a>
				<a href="$dir/targets/" class="btn">Targets</a>
				<a href="$dir/rules/" class="btn">Rules</a>

EOF;
?>			</p>
			<p class="small">Web design by <a href="http://dt.clrhome.org/">DT</a></p>
		</div>
		<div id="scores" class="block">
			<h2>Scores</h2>
			<div class="content">
				<div class="outer">
					<div class="inner">
						<table>
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
			<div class="content">
				<div class="outer">
					<div class="inner">
<?
echo str_replace('h2>', 'h3>', \Michelf\MarkdownExtra::defaultTransform(file_get_contents(__DIR__ . "/src/$page.md")));
?>					</div>
				</div>
			</div>
		</div>
	</body>
</html>
