<!DOCTYPE html>
<html>
<head>
    <title>Print Proforma Quotation Detail</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 10px;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
            text-align: center;
            text-decoration: underline;
        }
        .info-box {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .info-box td {
            padding: 5px;
            vertical-align: top;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .detail-table th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        .detail-table td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .signature-area {
            margin-top: 30px;
            width: 100%;
        }
        .signature-box {
            width: 33%;
            float: left;
            text-align: center;
            margin-bottom: 60px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 70%;
            margin: 45px auto 0 auto;
        }
        .signature-title {
            margin-top: 5px;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            font-size: 10px;
            width: 100%;
            text-align: center;
            font-style: italic;
        }
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
            window.onfocus = function() { setTimeout(function() { window.close(); }, 500); }
        }
    </script>
</head>
<body>
    <div class="header">
        <div class="company-name"><?php echo isset($company) ? $company->name : 'PT. EBAKO NUSANTARA'; ?></div>
        <div class="company-address">
            <?php echo isset($company) ? $company->address : 'Jl. Terboyo Industri Blok N-3C Kawasan Industri Terboyo Semarang - Indonesia'; ?>
            <br>
            <?php echo isset($company) ? "Tel: ".$company->phone : 'Telp. 62.24.6593407 Fax. 62.24.6591732'; ?>
        </div>
    </div>
    
    <div class="document-title">PROFORMA QUOTATION DETAIL</div>
    
    <table class="info-box">
        <tr>
            <td width="15%"><strong>Number</strong></td>
            <td width="35%">: <?php echo $proforma_quotation->number; ?></td>
            <td width="15%"><strong>Date</strong></td>
            <td width="35%">: <?php echo date('d/m/Y', strtotime($proforma_quotation->date)); ?></td>
        </tr>
        <tr>
            <td><strong>Customer</strong></td>
            <td colspan="3">: <?php echo $proforma_quotation->customer_name; ?></td>
        </tr>
    </table>
    
    <table class="detail-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Ebako Code</th>
                <th width="15%">Customer Code</th>
                <th width="13%">FOB Quotation</th>
                <th width="13%">FOB Product Price</th>
                <th width="13%">FOB Costing</th>
                <th width="26%">Remark</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($proforma_quotation_detail as $detail) { 
            ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><?php echo $detail->ebako_code; ?></td>
                <td><?php echo $detail->customer_code; ?></td>
                <td class="text-right"><?php echo number_format($detail->fob_quotation, 2); ?></td>
                <td class="text-right"><?php echo number_format($detail->fob_product_price, 2); ?></td>
                <td class="text-right"><?php echo number_format($detail->fob_costing, 2); ?></td>
                <td><?php echo $detail->remark; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
  
    
    <div class="no-print" style="text-align: center; margin: 20px;">
        <button onclick="window.print();">Print</button>
        <button onclick="window.close();">Close</button>
    </div>
</body>
</html>