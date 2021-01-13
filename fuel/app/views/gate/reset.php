<div class="col-lg-12">
	<p><?=__('gate.reset.msg')?></p>
	<div class="row">
		<div class="col-md-3 col-sm-6">
		<?php echo Form::open()?>
			<div class="form-group">
				<?=Form::label(__('gate.reset.label.mail'), 'email')?>
				<?=Form::input('email', '', ['type' => 'email', 'class' => 'form-control', 'placeholder' => __('gate.reset.label.mail'), 'autofocus'])?>
			</div>
			<div class="actions">
				<?=Form::submit(['value'=> __('gate.reset.btn'), 'name'=>'submit', 'class' => 'btn btn-primary btn-block'])?>
			</div>
		<?php echo Form::close()?>
		</div>
	</div>
</div>