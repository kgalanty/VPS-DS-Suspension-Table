<?php
use \Illuminate\Database\Eloquent\Builder;
use \WHMCS\Billing\Invoice\Item;
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\TicketsStatus;

return function ($vars) {

	$invoice = Item::where(function (Builder $query) use ($vars) {
		$query->where("invoiceid", $vars['invoiceid'])->where('type', 'Hosting');
	})
		->get();

	foreach ($invoice as $item) {
		if ($item->relid) {
			$isThereSomethingToDelete = TicketsStatus::serviceToDelete($item->relid)->count();
			if ($isThereSomethingToDelete > 0) {
				TicketsStatus::serviceToDelete($item->relid)->update(['deleted_at' => \WHMCS\Carbon::now()->toDateTimeString()]);

				logActivity('VPSDS marked as deleted upon invoice paid. Invoice id: ' . $vars['invoiceid'] . ', service id: ' . $item->relid);
			}
		}
	}
};