<!-- Widget row -->
<div class="col-lg-12">
	<div class="row">
	<?php foreach($widgets as $widget) {
		echo Request::forge($widget)->execute();
	} ?>
	</div>
</div>
