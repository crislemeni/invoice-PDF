<?php
//imports csv file
$csv = array_map('str_getcsv', file('payments.csv'));

// checks the post variables
	if(isset($_POST['indexNumber']) && ($_POST['indexNumber']!=null) && ($_POST['submit']=="Next"))
		$indexNumber = $_POST['indexNumber']+1;
		elseif(isset($_POST['indexNumber']) && ($_POST['indexNumber']!=null) && ($_POST['submit']=="Prev"))
			$indexNumber = $_POST['indexNumber']-1;
		elseif(isset($_POST['indexNumberjump']) && ($_POST['indexNumberjump']!=null) && ($_POST['submit']=="Go!") && ($_POST['indexNumberjump']>0) && ($_POST['indexNumberjump']<count($csv)+1) && is_numeric($_POST['indexNumberjump']) )
			$indexNumber = $_POST['indexNumberjump']-1;
		elseif(isset($_POST['indexNumber']))
			$indexNumber = $_POST['indexNumber'];
		elseif(isset($_POST['submit']) && $_POST['submit']=="Save")
			$indexNumber = $_POST['indexNumberStart']-1;
		else $indexNumber = 0;

//gets the current row
$currentArray = $csv[$indexNumber];
$invoiceNo = str_pad(($indexNumber+1), 3, '0', STR_PAD_LEFT);
$dateSubtract = '-'.rand(1, 10).' days';

include("invoice_template.php");
?>
<?php
	// checks if the print button was clicked to output the PDF file
	if(isset($_POST['submit']) && ($_POST['submit']=="Print")) {
		include("mpdf.php");
		$mpdf=new mPDF(); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$mpdf->Output(('invoice#'.$invoiceNo.'.pdf'), 'I'); 
		exit;
	}
	
	
	// outputs the HTML version
	else echo $html;

	
?>
<div class="formHolder">
	<form action="#" method="post" style="float: left;">
		<input type="hidden" name="indexNumber" value="<?= $indexNumber ?>" />
		<input type="submit" name="submit" value="Prev" <?= ($indexNumber==0) ? "disabled='disabled'" : "";?>></input>
		<input type="submit" name="submit" value="Next" <?= ($indexNumber==count($csv)-1) ? "disabled='disabled'" : "";?>></input>
		<input type="submit" name="submit" value="Print"></input>
	</form>
	<form action="batch_print.php" method="post" target="_blank"  style="float: right;margin-left: 20px;">
		<div style="float: left; position: relative; top: -1px;">Print invoices from #<input style="font-size: 16px; width: 30px;" type="text" name="indexNumberStart" value="<?=($indexNumber+1)?>" /> to #<input style="font-size: 16px; width: 30px;" type="text" name="indexNumberEnd" value="<?=($indexNumber+1)?>" />
		<span style="display: block; font-size: 14px; background-color: #999; color: #fff;padding: 3px 5px;">Numbers range 1 - <?= count($csv)?>.
		</span></div>
		<input type="submit" name="submit" value="Save"></input>
	</form>
	<form action="#" method="post"  style="float: right;margin-left: 20px;">
		<div style="float: left; position: relative; top: -1px;">Go to invoice #<input style="font-size: 16px; width: 60px;" type="text" name="indexNumberjump" value="<?=($indexNumber+1)?>" />
		<span style="display: block; font-size: 14px; background-color: #999; color: #fff;padding: 3px 5px;">Numbers range 1 - <?= count($csv)?>.
		</span></div>
		<input type="submit" name="submit" value="Go!"></input>
	</form>
</div>