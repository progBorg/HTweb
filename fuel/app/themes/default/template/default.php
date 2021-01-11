<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($page_title) && empty($title) ? $page_title : $title?> | <?=__('site_title').' '.__('site_sub')?></title>
	
	<?php 
	echo \Theme::instance()->asset->css('bootstrap.min.css');
	
	echo Asset::css([
		'font-awesome.css',
		'general.css',
		]); 
	
	foreach ($add_css as $sheet) { 
		echo Asset::css($sheet . '.css');
	} 
	
	echo Asset::js('jquery-3.1.1.min.js'); 
	
	echo \Theme::instance()->asset->js('bootstrap.min.js');
	echo \Theme::instance()->asset->js('scripts.js');
	
	foreach ($add_js as $script) { 
		echo Asset::js($script . '.js');
	} 
	?>	
</head>
<body>
	<?=$partials['navbar']?>
	<div class="container">
		<?=$partials['header']?>
		<div class="row">
			<?=$content?>
		</div>
		<?=$partials['footer']?>
	</div>
</body>
</html>