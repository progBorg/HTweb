<div class="col-lg-12">
	<?php if (Auth::has_access('sessions.administration')) : ?>
	<div class="button-float-container">
		<a href="<?=Uri::create('sessions/stats/reset')?>"  class="btn btn-default"><span class="fa fa-refresh"></span> <?=__('actions.refresh') ?></a>
	</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-lg-12">
			<div id="distr-bar-chart" style="height: 250px; width: 100%;"></div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h5 class="pull-left"><?= __('session.stats.next_cook_msg') . ': ' . $next_cook ?></h5>

			<?php
			$server = $checksum['server'];
			$local = $checksum['local'];
			?>

			<div class="pull-right">
				<?php if ($server == $local && $server < 11) : ?>
					<p class="label label-success"><span class="fa fa-check"></span> <?= __('receipt.view.point_check') ?> (<?= $server ?>)</p>
				<?php else : ?>
					<p class="label label-danger"><span class="fa fa-times"></span> <?= __('receipt.view.point_check') ?> (<?= $local . '/' . $server ?>)</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<h3><?= __('session.stats.all_time') . ' ' . strtolower(__('session.stats.title')) ?></h3>
	<div class="table-responsive">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th><?= __('session.role.cook') ?></th>
					<th>#</th>
					<th><?= __('session.stats.average') . ' ' . __('product.field.cost') ?></th>
					<th><?= __('session.stats.average') . ' ' . __('session.role.participant_plural') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach (\Sessions\Model_Session::get_session_statistics() as $entry) { ?>
					<tr class="clickable-row" data-href="#">
						<td><?= $entry['name'] ?></td>
						<td><?= $entry['count'] ?></td>
						<td><?= '€ ' . round($entry['avg_cost'], 2) ?></td>
						<td><?= round($entry['avg_enrollments']) ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>