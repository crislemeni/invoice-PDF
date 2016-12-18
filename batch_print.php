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

  include("invoice_template.php");

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