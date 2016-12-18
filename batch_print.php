<?php 
$csv = array_map('str_getcsv', file('payments.csv'));

// batch print



//gets the current row

$dateSubtract = '-'.rand(1, 10).' days';





require("mpdf.php");
for ($i=($_POST['indexNumberStart']-1); $i < $_POST['indexNumberEnd']; $i++) { 
  $indexNumber = $i;
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
          </section>

          <section id="invoice-title-number">

            <div class="title-top">
             <div id="number" style="float: right;">#'.$invoiceNo.'</div>
             <div>'.date('m/d/Y', strtotime($dateSubtract, strtotime(array_values($currentArray)[3]))).'

             </div>
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
                <td>$0</td>
              </tr>
              
              <tr data-hide-on-quote="true" class="due-amount">
                <th>Due Sum</th>
                <td>'.array_values($currentArray)[6].'</td>
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

  $mpdf=new mPDF(); 
  $mpdf->SetDisplayMode('fullpage');
  $mpdf->WriteHTML($html);
  $mpdf->Output(('PDFs/invoice#'.$invoiceNo.'.pdf'), 'F'); 
}
//echo $html;




?>
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
  </head>
  <body style="text-align: center; padding-top: 40px; min-height: 0;">
    <!-- <h1 style="font-size: 100px;padding: 40px 0 20px;">JOB DONE!</h1>
    <h2 style="font-size: 50px;">Wanna <a href="index.php" style="background-color: #eaeaea; text-decoration: none; color: #444; padding: 0 10px;">go back</a>?</h2> -->
    <script type="text/javascript">
      alert("Job done. Bye for now.");
      window.close();
    </script>
</body>
</html>