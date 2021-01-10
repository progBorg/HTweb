<footer class="row">
	<hr/>

	<div class="col-sm-4 col-sm-push-4">
		<p class="text-center">
			<span class="fa fa-bank"></span> <?=__('product_name')?>
		</p>
	</div>

	<div class="col-sm-4 col-sm-pull-4 col-xs-6">
		<p class="text-left text-muted">
			<small>
				<u><?=__('dev')?></u> <br />
				Melcher Stikkelorum &copy; 2016-2020 <br />
				Tom Veldman &copy; 2020-<?=date('Y')?>
			</small>
		</p>
	</div>

	<div class="col-sm-4 col-xs-6">
		<p class="text-right text-muted">
			<small>
				<a href="https://github.com/ProgBorg/HVOweb" target="_blank">
					<i class="fa fa-github"></i> <u class="text-muted"> <?=__('github')?></u>
				</a> <br />
				<?=__('fuel')?> <br />
				<strong><?=\FUEL::$env.' / '.\Utils::current_branch() . ' / ' . \Utils::get_short_head()?></strong>
			</small>
		</p>
	</div>
</footer>