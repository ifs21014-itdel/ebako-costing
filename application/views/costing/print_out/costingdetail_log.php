<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Costing Detail Log</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 2000px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e6f7ff;
        }
        .empty-message {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #777;
        }
        .date-column {
            white-space: nowrap;
        }
        .numeric-column {
            text-align: right;
        }
        .action-column {
            color: #e74c3c;
            font-weight: bold;
        }
        .updated-fields {
            max-width: 200px;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Costing Detail Log</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Material Code</th>
                        <th>Action Type</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th>Old Qty</th>
                        <th>New Qty</th>
                        <th>Old Yield</th>
                        <th>New Yield</th>
                        <th>Old Allowance</th>
                        <th>New Allowance</th>
                        <th>Old Req Qty</th>
                        <th>New Req Qty</th>
                        <th>Old Price</th>
                        <th>New Price</th>
                        <th>Category Name</th>
                        <th>Action User</th>
                        <th>Updated Fields</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($costing)) : ?>
                        <?php foreach ($costing as $row) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row->materialcode) ?></td>
                                <td class="action-column"><?= htmlspecialchars($row->action_type) ?></td>
                                <td><?= htmlspecialchars($row->created_by) ?></td>
                                <td><?= htmlspecialchars($row->updated_by) ?></td>
                                <td class="date-column"><?= date('d-m-Y H:i:s', strtotime($row->created_date)) ?></td>
                                <td class="date-column"><?= date('d-m-Y H:i:s', strtotime($row->updated_date)) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->old_qty) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->new_qty) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->old_yield) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->new_yield) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->old_allowance) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->new_allowance) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->old_req_qty) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->new_req_qty) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->old_total) ?></td>
                                <td class="numeric-column"><?= htmlspecialchars($row->new_total) ?></td>
                                <td><?= htmlspecialchars($row->category_name) ?></td>
                                <td><?= htmlspecialchars($row->action_user) ?></td>
                                <td class="updated-fields"><?= nl2br(htmlspecialchars($row->updated_fields)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="19" class="empty-message">Tidak ada data tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>