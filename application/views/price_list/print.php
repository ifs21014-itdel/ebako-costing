<?php
/**
 * Print file untuk Price List
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Price List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PRICE LIST</h2>
        <p>Print Date: <?php echo date('d-m-Y H:i:s'); ?></p>
    </div>
    
    <button onclick="window.print();" style="margin-bottom: 10px;">Print</button>
    <button onclick="window.close();" style="margin-bottom: 10px; margin-left: 10px;">Close</button>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <?php if (in_array('date', $selected_columns)): ?>
                <th>Date</th>
                <?php endif; ?>
                <?php if (in_array('model_id', $selected_columns)): ?>
                <th>Model ID</th>
                <?php endif; ?>
                <?php if (in_array('customer_name', $selected_columns)): ?>
                <th>Customer Name</th>
                <?php endif; ?>
                <?php if (in_array('quantity', $selected_columns)): ?>
                <th>Quantity</th>
                <?php endif; ?>
                <?php if (in_array('last_costing_price', $selected_columns)): ?>
                <th>Last Costing Price</th>
                <?php endif; ?>
                <?php if (in_array('total_last_costing', $selected_columns)): ?>
                <th>Total Last Costing</th>
                <?php endif; ?>
                <?php if (in_array('last_quotation_price', $selected_columns)): ?>
                <th>Last Quotation Price</th>
                <?php endif; ?>
                <?php if (in_array('total_last_quotation', $selected_columns)): ?>
                <th>Total Last Quotation</th>
                <?php endif; ?>
                <?php if (in_array('target_price', $selected_columns)): ?>
                <th>Target Price</th>
                <?php endif; ?>
                <?php if (in_array('total_target_price', $selected_columns)): ?>
                <th>Total Target Price</th>
                <?php endif; ?>
                <?php if (in_array('rate', $selected_columns)): ?>
                <th>Rate</th>
                <?php endif; ?>
                <?php if (in_array('price_rate', $selected_columns)): ?>
                <th>Price Rate</th>
                <?php endif; ?>
                <?php if (in_array('total_price_rate', $selected_columns)): ?>
                <th>Total Price Rate</th>
                <?php endif; ?>
                <?php if (in_array('profit_percentage', $selected_columns)): ?>
                <th>Profit %</th>
                <?php endif; ?>
                <?php if (in_array('fixed_cost', $selected_columns)): ?>
                <th>Fixed Cost</th>
                <?php endif; ?>
                <?php if (in_array('variable_cost', $selected_columns)): ?>
                <th>Variable Cost</th>
                <?php endif; ?>
                <?php if (in_array('status', $selected_columns)): ?>
                <th>Status</th>
                <?php endif; ?>
                <th>Approval Date</th>
                <th>Approval Price</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($price_list as $result): 
                // Hitung total untuk kolom baru
                $total_last_costing = isset($result->last_costing_price) ? ($result->quantity * $result->last_costing_price) : 0;
                $total_last_quotation = isset($result->last_quotation_price) ? ($result->quantity * $result->last_quotation_price) : 0;
                $total_target_price = isset($result->target_price) ? ($result->quantity * $result->target_price) : 0;
                $total_price_rate = isset($result->price_rate) ? ($result->quantity * $result->price_rate) : 0;
                
                // Konversi tanggal jika ada
                $formatted_date = isset($result->created_at) ? date('d-m-Y', strtotime($result->created_at)) : '';
                $formatted_approval_date = isset($result->approval_date) ? date('d-m-Y', strtotime($result->approval_date)) : '-';
            ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <?php if (in_array('date', $selected_columns)): ?>
                <td><?php echo $formatted_date; ?></td>
                <?php endif; ?>
                <?php if (in_array('model_id', $selected_columns)): ?>
                <td><?php echo isset($result->model_no) ? $result->model_no : ''; ?></td>
                <?php endif; ?>
                <?php if (in_array('customer_name', $selected_columns)): ?>
                <td><?php echo isset($result->customer_name) ? $result->customer_name : ''; ?></td>
                <?php endif; ?>
                <?php if (in_array('quantity', $selected_columns)): ?>
                <td class="text-center"><?php echo isset($result->quantity) ? $result->quantity : ''; ?></td>
                <?php endif; ?>
                <?php if (in_array('last_costing_price', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->last_costing_price) ? number_format($result->last_costing_price, 2) : '0.00'; ?></td>
                <?php endif; ?>
                <?php if (in_array('total_last_costing', $selected_columns)): ?>
                <td class="text-right"><?php echo number_format($total_last_costing, 2); ?></td>
                <?php endif; ?>
                <?php if (in_array('last_quotation_price', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->last_quotation_price) ? number_format($result->last_quotation_price, 2) : '0.00'; ?></td>
                <?php endif; ?>
                <?php if (in_array('total_last_quotation', $selected_columns)): ?>
                <td class="text-right"><?php echo number_format($total_last_quotation, 2); ?></td>
                <?php endif; ?>
                <?php if (in_array('target_price', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->target_price) ? number_format($result->target_price, 2) : '0.00'; ?></td>
                <?php endif; ?>
                <?php if (in_array('total_target_price', $selected_columns)): ?>
                <td class="text-right"><?php echo number_format($total_target_price, 2); ?></td>
                <?php endif; ?>
                <?php if (in_array('rate', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->rate) ? number_format($result->rate, 2) : '0.00'; ?></td>
                <?php endif; ?>
                <?php if (in_array('price_rate', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->price_rate) ? number_format($result->price_rate, 2) : '0.00'; ?></td>
                <?php endif; ?>
                <?php if (in_array('total_price_rate', $selected_columns)): ?>
                <td class="text-right"><?php echo number_format($total_price_rate, 2); ?></td>
                <?php endif; ?>
                <?php if (in_array('profit_percentage', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->profit_percentage) ? number_format($result->profit_percentage, 2) : '0.00'; ?>%</td>
                <?php endif; ?>
                <?php if (in_array('fixed_cost', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->fixed_cost) ? number_format($result->fixed_cost, 2) : '0.00'; ?></td>
                <?php endif; ?>
                <?php if (in_array('variable_cost', $selected_columns)): ?>
                <td class="text-right"><?php echo isset($result->variable_cost) ? number_format($result->variable_cost, 2) : '0.00'; ?></td>
                <?php endif; ?>
                <?php if (in_array('status', $selected_columns)): ?>
                <td><?php echo isset($result->status) ? $result->status : 'Draft'; ?></td>
                <?php endif; ?>
                <td><?php echo $formatted_approval_date; ?></td>
                 <td class="text-right"><?php echo isset($result->approval_price) ? number_format($result->approval_price, 2) : '0.00'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="<?php echo count($selected_columns) + 3; ?>" class="text-right">
                    <strong>Total Items: <?php echo count($price_list); ?></strong>
                </td>
            </tr>
        </tfoot>
    </table>
    
    
    
    <script>
        window.onload = function() {
            // Optional: Automatically print when page loads
            // window.print();
        }
    </script>
</body>
</html>