<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading"><?=__('actions.name')?></div>
		<div class="list-group">
			<a class="list-group-item" href="/receipts/admin/create" ><span class="fa fa-plus"></span> Create receipt</a>
		</div>
	</div>
</div>

<div class="col-md-8">
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="col-md-1">Id</th>
					<th><?=__('receipt.field.date')?></th>
					<th><?=__('receipt.field.notes')?></th>
					<th><?=__('actions.name')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($receipts as $receipt) { ?>
				<tr class="clickable-row" data-href="/receipts/view/<?=$receipt->id?>">
					<td><?=$receipt->id?></td>
					<td><?=$receipt->date?></td>
					<td><?=$receipt->notes?></td>
					<td>
						<a href="#" onclick="showDeleteModal(<?=$receipt->id?>)"><span class="fa fa-trash"></span> <?=__('actions.remove')?></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<em><?=sizeof($receipts) == 0 ? __('receipt.empty_list') : ''?></em>
	</div>
</div>
	

<!-- Modal dialog for receipt deletion -->
<div id="delete-receipt-modal" class="modal fade">
	<div class="modal-dialog active">
		<div class="modal-content">
			<form id="remove-package" action="/receipts/admin/delete/" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete receipt</h4>
				</div>
				<div class="modal-body">
					<p><strong>Are you sure you want to delete this receipt?</strong>
						<br>Deleting a receipt will redistribute all points
					among the participants. Costs calculated for the receipt will be lost and all session and/or products will be marked unsettled.
					</p>
					<!--  insert form elements here -->
					<div class="form-group">
						<input id="delete-receipt-id" type="hidden" class="form-control" name="receipt_id">
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-danger" value="Delete Receipt" />
					<button type="button" class="btn btn-default"
						data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
