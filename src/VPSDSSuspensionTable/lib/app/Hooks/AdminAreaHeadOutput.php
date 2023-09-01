<?php
use WHMCS\Module\Addon\VPSDSSuspensionTable\app\Models\TicketTpl;

return function ($vars) {
	if ($vars['filename'] === 'supporttickets' && $_GET['action'] == 'open' && $_GET['modulefrom'] == 'vpsds') {
		$serviceid = (int) $_GET['hid'];
		$templateid = (int) $_GET['tplid'];

		$tpl = TicketTpl::find($templateid);
		$subject = $tpl->title;
		$content = $tpl->content;
		if ($subject && $content) {


			$return = <<<JS
	<script>$(function() {
		$("#customServicesSelect").val(${serviceid})
	$("[name='deptid'] > option").each(function() { if(this.text==='Sales') { $("[name='deptid']").val(this.value)} })   
	$("#replymessage").val(`${content}`)
	$("[name='subject']").val(`${subject}`);
});

	</script>
JS;
			return $return;
		}
	}
};