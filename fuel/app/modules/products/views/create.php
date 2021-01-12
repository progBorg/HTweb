<div class="col-md-6">
	<?=Form::open(['action' => '/products/create', 'class' => 'form-horizontal'])?>
	<div class="form-group">
		<?=Form::label(__('product.field.name').'*', 'name', ['class' => 'col-sm-2'])?>
		<div class="col-sm-10">
			<?=Form::input('name', '', ['class' => 'form-control', 'type' => 'text', 'maxlength' => 50, 'required'])?>
		</div>
	</div>

	<div class="form-group">
		<?=Form::label(__('product.field.notes'), 'notes', ['class' => 'col-sm-2'])?>
		<div class="col-sm-10">
			<?=Form::textarea('notes', '', ['rows' => '3', 'maxlenght' => 255, 'class' => 'form-control'])?>
		</div>
	</div>

	<div class="form-group">
		<?=Form::label(__('product.field.date').'*', 'date', ['class' => 'col-sm-2'])?>
		<div class="col-sm-6">
			<?=Form::input('date', date('Y-m-d'), ['class' => 'form-control', 'type' => 'date', 'required'])?>
		</div>
	</div>

	<div class="form-group">
		<?=Form::label(__('product.field.cost').'*', 'cost', ['class' => 'col-sm-2'])?>
		<div class="col-sm-6">
			<div class="input-group">
				<div class="input-group-addon">€</div>
				<?=Form::input('cost', null, ['class' => 'form-control', 'type' => 'number', 'min' => Products\Model_Product::MIN_PRICE,'max' => Products\Model_Product::MAX_PRICE, 'step' => '0.01', 'required'])?>
			</div>
		</div>
	</div>

	<?php if(isset($is_admin)) { ?>
	<div class="form-group">
		<?=Form::label(__('product.field.paid_by').'*', 'payer-id', ['class' => 'col-sm-2'])?>
		<div class="col-sm-6">
			<?=Form::select('payer-id', $current_user->id, $active_user_options, ['class' => 'form-control', 'required'])?>
		</div>
	</div>
	<?php } ?>
</div>
<div class="col-md-6">
		<div class="btn-group btn-group-sm pull-right">
		<a class="btn btn-primary" onClick="checkAll()"><?=__('actions.select_all')?></a>
		<a class="btn btn-primary" onClick="uncheckAll()"><?=__('actions.deselect_all')?></a>
	</div>
	<div class="form-group">
		<p><?=isset($is_admin) ? __('product.admin.create.participants') : __('product.create.participants')?></p>
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th><?=__('user.field.name')?></th>
					<th><?=__('product.field.amount')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($users as $user) {?>
				<tr>
					<td class="<?=$user->active ? '' : 'warning'?>">
						<label class="checkbox-inline" style="padding-top: 0px !important;">
							<?=Form::checkbox('users[]', $user->id, ['class' => ($user->active ? 'user-select' : '')])?>
							<?=$user->get_fullname()?>
						</label>
					</td>
					<td>
						<?=Form::input($user->id, null, ['type' => 'number', 'min' => 0, 'max' => 20, 'placeholder' => 1])?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<input type="submit" class="btn btn-primary btn-block" value="<?=__('product.create.btn')?>" />
<?=Form::close()?>
