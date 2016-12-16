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
	else $indexNumber = 0;

//gets the current row
$currentArray = $csv[$indexNumber];
$invoiceNo = str_pad(($indexNumber+1), 3, '0', STR_PAD_LEFT);

$html = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Easy (corporate)</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Invoicebus Invoice Template">
    <meta name="author" content="Invoicebus">
    <meta name="template-hash" content="91216e926eab41d8aa403bf4b00f4e19">
    <link rel="stylesheet" href="css/template.css">
    <style>
		
    </style>
  </head>';
$html .= '<body>
	<div id="container">
	<div class="left-stripes">
      </div>
      <div class="right-invoice">
        <section id="memo">
          <div class="company-info">
            <div>Ovidiu Savescu
            </div>
            <br>
            <span>{company_address}</span>
            <span>{company_city_zip_state}</span>
            <br>
            <span>{company_phone_fax}</span>
            <br>
            <span>{company_email_web}</span>
          </div>

          <div class="logo">
            <img data-logo="{company_logo}" />
          </div>
        </section>

        <section id="invoice-title-number">

          <div class="title-top">
           <div id="number" style="float: right;">#'.$invoiceNo.'</div><div>'.array_values($currentArray)[3].'</div>
          </div>
        
          <div id="title">INVOICE</div>
          
        </section>

        <section id="client-info">
          <span>CLIENT</span>
          <div class="client-name">
            <span>'.array_values($currentArray)[4].'</span>
          </div>
          
          <div>
            <span>{client_address}</span>
          </div>
          
          <div>
            <span>{client_city_zip_state}</span>
          </div>
          
          <div>
            <span>{client_phone_fax}</span>
          </div>
          
          <div>
            <span>{client_email}</span>
          </div>
          
          <div>
            <span>{client_other}</span>
          </div>
        </section>
        
        <div class="clearfix"></div>
        
        <section id="invoice-info">
          <div>
            <span>{net_term_label}</span> <span>{net_term}</span>
          </div>
          <div>
            <span>{due_date_label}</span> <span>{due_date}</span>
          </div>
          <div>
            <span>{po_number_label}</span> <span>{po_number}</span>
          </div>
        </section>
        
        <div class="clearfix"></div>

        <div class="currency">
          <span>'.array_values($currentArray)[5].'</span> <span>{currency}</span>
        </div>
        
        <section id="items">
          
          <table cellpadding="0" cellspacing="0">
          
            <tr>
              <th></th> <!-- Dummy cell for the row number and row commands -->
              <th>Item</th>
              <th>Price</th>
              <th>Tax</th>
              <th>Total</th>
            </tr>
            
            <tr data-iterate="item">
              <td>1</td> <!-- Dont remove this column as its needed for the row commands -->
              <td>'.array_values($currentArray)[2].' '.array_values($currentArray)[1].'</td>
              <td>'.array_values($currentArray)[6].'</td>
              <td> - </td>
              <td>'.array_values($currentArray)[6].'</td>
            </tr>            
          </table>
          
        </section>
        
        <section id="sums">
        
          <table cellpadding="0" cellspacing="0" style="float: right;" align="right">
            <tr>
              <th>{amount_subtotal_label}</th>
              <td>{amount_subtotal}</td>
            </tr>
            
            <tr data-iterate="tax">
              <th>{tax_name}</th>
              <td>{tax_value}</td>
            </tr>
            
            <tr class="amount-total">
              <!-- {amount_total_label} -->
              <td colspan="2">'.array_values($currentArray)[6].'</td>
            </tr>
            
           
            <tr data-hide-on-quote="true">
              <th>Amount Paid</th>
              <td>'.array_values($currentArray)[6].'</td>
            </tr>
            
            <tr data-hide-on-quote="true" class="due-amount">
              <th>Due Sum</th>
              <td>$0</td>
            </tr>
            
          </table>
          
        </section>
        
        <div class="clearfix"></div>
        
        <section id="terms">
        
          <span>Notes</span>
          <div>'.array_values($currentArray)[0].'</div>
          
        </section>

        <div class="payment-info">
          <div>{payment_info1}</div>
          <div>{payment_info2}</div>
          <div>{payment_info3}</div>
          <div>{payment_info4}</div>
          <div>{payment_info5}</div>
        </div>
      </div>
      </div>
    </div>
</body>
</html>';
?>
<?php
	// checks if the print button was clicked to output the PDF file
	if(isset($_POST['submit']) && ($_POST['submit']=="Print")) {
		include("mpdf.php");
		$mpdf=new mPDF(); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($_POST['content']);
		$mpdf->Output(('invoice#'.$invoiceNo.'.pdf'), 'I'); 
		exit;
	}
	// outputs the HTML version
	else echo $html;

	
?>
<div class="formHolder">
	<form action="#" method="post" style="float: left;">
		<input type="hidden" name="indexNumber" value="<?= $indexNumber ?>" />
		<textarea name="content" style="display: none;">
	      <?= $html ?>
	   </textarea>
		<input type="submit" name="submit" value="Prev" <?= ($indexNumber==0) ? "disabled='disabled'" : "";?>></input>
		<input type="submit" name="submit" value="Next" <?= ($indexNumber==count($csv)-1) ? "disabled='disabled'" : "";?>></input>
		<input type="submit" name="submit" value="Print"></input>
	</form>
	<form action="#" method="post"  style="float: right;margin-left: 20px;">
		<div style="float: left; position: relative; top: -1px;">Go to invoice #<input style="font-size: 16px; width: 60px;" type="text" name="indexNumberjump" value="<?=($indexNumber+1)?>" />
		<span style="display: block; font-size: 14px; background-color: #999; color: #fff;padding: 3px 5px;">Numbers range 1 - <?= count($csv)?>.
		</span></div>
		<input type="submit" name="submit" value="Go!"></input>
	</form>
</div>