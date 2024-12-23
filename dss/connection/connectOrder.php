<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'toy-shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Thực hiện truy vấn SQL
$sql = "SELECT * FROM `order`";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
            <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                        <p class="font-semibold">' . htmlspecialchars($row['o_id']) . '</p>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['u_id']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['p_id']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Product_Name']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Product_Category']) . '</td>
                <td class="px-4 py-3 text-sm">$' . number_format($row['Product_Cost'], 2) . '</td>
                <td class="px-4 py-3 text-sm">$' . number_format($row['Product_Price'], 2) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Stock_On_Hand']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Sale_ID']) . '</td>
                <td class="px-4 py-3 text-sm">$' . number_format($row['o_price'], 2) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['o_quantity']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['o_status']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['o_date']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Store_Name']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Store_City']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Store_Location']) . '</td>
                <td class="px-4 py-3 text-sm">' . htmlspecialchars($row['Store_Open_Date']) . '</td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                        <a href="editOrder.php?o_id=' . htmlspecialchars($row['o_id']) . '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                        </a>

                        <a href="deleteOrders.php?o_id=' . htmlspecialchars($row['o_id']) . '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>';
    }
} else {
    echo '<tr><td colspan="17" class="text-center">No results found</td></tr>';
}

$conn->close();
?>