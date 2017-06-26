#!/usr/bin/php
<?
	// Simple script to extract Laravel translation tokens from all your views

	$views = glob('*.blade.php');

	$tokens = [];

	foreach($views as $v)
	{
		$lines = file($v);

		foreach($lines as $l)
		{
			if(preg_match('/.*__\([\'\"a-zA-Z0-9\-\_]*\.([a-zA-Z0-9.\-_]*).*/', $l, $matches))
			{
				foreach($matches as $index => $m)
				{
					if($index == 0) continue;
					$tokens[ $m ] = $m;
				}
			}
		}
	}

	array_unique($tokens);
	asort($tokens, SORT_FLAG_CASE | SORT_NATURAL);

	foreach($tokens as $t)
		echo "$t\n";

?>
