<?php
require_once('../include/config.php');
include '../include/function-update.php';

$netTotal = $total = 0;
$invoice_number = $_GET['invoice_number'];
$SelectedArray = GetInvoices($link)[$invoice_number];
$InvProducts = GetInvoiceItems($link, $invoice_number);
$Products = GetProducts($link);
$Units = GetUnit($link);
$PrinterName = $_GET['PrinterName'];

$reprintStatus = $_GET['reprintStatus'];
$titleSuffix = "";
if ($reprintStatus == 1) {
    $titleSuffix = " - REPRINT";
}


$inv_time = date("Y-m-d H:i:s", strtotime($SelectedArray['current_time']));
$TableID = $SelectedArray['table_id'];
if ($TableID == 0) {
    $TableName = "Take Away";
} else if ($TableID == -1) {
    $TableName = "Retail";
} else if ($TableID == -2) {
    $TableName = "Delivery";
} else {
    $TableName = GetTables($link)[$SelectedArray['table_id']]['table_name'];
}

$service_charge = $SelectedArray['service_charge'];
$discountPercentage = $SelectedArray['discount_percentage'];
$close_type = $SelectedArray['close_type'];
$tendered_amount = $SelectedArray['tendered_amount'];
$InvoiceNumber = $SelectedArray['invoice_number'];
$LocationName = GetLocations($link)[$SelectedArray['location_id']]['location_name'];
$invAmount = $SelectedArray['inv_amount'];
$customer_code = $SelectedArray['customer_code'];
$invoice_status = $SelectedArray['invoice_status'];
$discountAmount = $invAmount * ($discountPercentage / 100);
$netTotal = $invAmount - $discountAmount;

$created_by =  $SelectedArray['created_by'];
if (!empty($created_by)) {
    $LoggedStudent = GetAccounts($link)[$created_by];
    $LoggedName =  $LoggedStudent['first_name'] . " " . $LoggedStudent['last_name'];
} else {
    $LoggedName = "Unknown";
}

$selectedLocation =  GetLocations($link)[$SelectedArray['location_id']];
?>
<!DOCTYPE html>
<html lang="en" style="margin: 0; padding:0">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/print-invoice-1.0.css" />
    <title><?= $InvoiceNumber ?></title>
    <style></style>
</head>

<body id="body" style="margin: 0; padding:0">


    <div class="inv" id="inv">
        <div class="logo-box" style="margin-bottom: 20px;">
            <img class="logo-image" src="./assets/images/<?= $selectedLocation['logo_path'] ?>">
        </div>

        <p class="address">#<?= $selectedLocation['address_line1'] ?>, <?= $selectedLocation['address_line2'] ?>, <?= $selectedLocation['city'] ?></p>
        <p class="telephone">Tel : <?= $selectedLocation['phone_1'] ?> / <?= $selectedLocation['phone_2'] ?></p>
        <p class="telephone">Email : info@transitaradhana.com</p>
        <hr />

        <h2 class="company">KOT <?= $titleSuffix ?></h2>
        <div class="InvoiceID">Invoice # : <span class="invoice_number" style="font-weight: 800;"><?php echo $InvoiceNumber; ?></span></div>
        <div class="Customer">Customer : <span class="cus_name"><?php echo $customer_code; ?></span></div>
        <div class="dateContainer">Date : <span class="date"><?php echo $inv_time; ?></span></div>
        <div class="Customer">Cashier : <span class="cus_name"><?= $LoggedName ?></span></div>
        <hr />

        <table style="width: 100%;">
            <thead>
                <tr>
                    <th class="headerth">Qty</th>
                    <th class="headerth">Unit Price</th>
                    <th class="headerth">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($InvProducts)) {
                    foreach ($InvProducts as $SelectRecord) {
                        $display_name = $Products[$SelectRecord['product_id']]['display_name'];
                        $print_name = $Products[$SelectRecord['product_id']]['print_name'];
                        $item_unit = $Units[$Products[$SelectRecord['product_id']]['measurement']]['unit_name'];
                        $selling_price = $SelectRecord['item_price'];
                        $item_quantity = $SelectRecord['quantity'];
                        $item_discount = $SelectRecord['item_discount'];
                        $product_id = $SelectRecord['product_id'];

                        $line_total = ($selling_price - $item_discount) * $item_quantity;
                        $total += $line_total;
                ?>
                        <tr>
                            <td colspan="3"><?php echo $print_name; ?></td>
                        </tr>
                        <tr class="selected">
                            <td><?php echo $item_quantity; ?></td>
                            <td class="text-right"><?php echo number_format($selling_price, 2); ?></td>
                            <td class="text-right"><?php echo number_format($line_total, 2); ?></td>
                        </tr>

                <?php
                    }
                }
                ?>


            </tbody>
        </table>
        <hr />
        <div class="bill-foooter">Thank You..! Come Again</div>
        <div class="credits" style="margin-top:10px">Software by Payshia </div>
        <img class="logo-image" src="./assets/images/pos-logo.png" style="width: 25mm; margin-top:10px;">
        <div class="credits">0770481363 | www.payshia.com</div>
    </div>

    <script>
        function calculateFilledHeightInMillimeters(element) {
            var elementHeightInPixels = element.offsetHeight;
            var millimetersPerPixel = 0.264583; // This is an approximate value for common screen dpi (96dpi)
            var filledHeightInMillimeters = (elementHeightInPixels * millimetersPerPixel).toFixed(2);

            return filledHeightInMillimeters;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var invElement = document.getElementById("inv");
            var filledHeight = calculateFilledHeightInMillimeters(invElement);

            // Update the @page size in your style tag
            var styleTag = document.createElement("style");
            styleTag.innerHTML = `
            @media print {
                @page {
                    size: 78mm ${filledHeight}mm; /* Set the calculated height */
                    margin: 0;
                    /* Adjust margins as needed */
                }
            }
        `;
            document.head.appendChild(styleTag);

            // Print the page
            // window.print();

            // Close the window after printing
            // window.onafterprint = function() {
            //     window.close();
            // };

        });
    </script>

    <script>

    </script>
</body>


</html>

<script>
    console.log("PrinterName:KOT-Printer,InvoiceNumber:<?= $invoice_number ?>");

    function calculateFilledHeightInMillimeters(element) {
        var elementHeightInPixels = element.offsetHeight;
        var millimetersPerPixel = 0.264583; // This is an approximate value for common screen dpi (96dpi)
        var filledHeightInMillimeters = (elementHeightInPixels * millimetersPerPixel).toFixed(2);

        return filledHeightInMillimeters;
    }

    document.addEventListener("DOMContentLoaded", function() {
        var invElement = document.getElementById("inv");
        var filledHeight = calculateFilledHeightInMillimeters(invElement);

        filledHeight = parseFloat(filledHeight) + 30; // Parse to an integer and then add 40
        // Update the @page size in your style tag
        var styleTag = document.createElement("style");
        styleTag.innerHTML = `
            @media print {
                @page {
                    size: 78mm ${filledHeight}mm; /* Set the calculated height */
                    margin: 0;
                }
            }
        `;
        document.head.appendChild(styleTag);
    });

    <?php if ($PrinterName == "default") { ?>
        // Print the page
        window.print();

        // Close the window after printing
        window.onafterprint = function() {
            window.close();
        };
    <?php } ?>
</script>

<!-- <script>
        // Function to print the invoice to a specific printer
        function printToPrinter(printerName) {
            var styleTag = document.createElement("style");
            styleTag.innerHTML = `
        @media print {
            @page {
                size: auto;
                margin: 0;
                printer: "${printerName}";
            }
        }
    `;
            document.head.appendChild(styleTag);


            var invElement = document.getElementById("inv");
            // Set the desired printer as the default printer using a CSS style
            var css = `
                @media print {
                    @page {
                        size: auto;
                        margin: 0;
                        /* Set the printer name here */
                        printer: "${printerName}";
                    }
                }
            `;

            var printNewWindow = window.open("", "", "width=600, height=600");

            // Check if the printWindow is not null before attempting to access its properties
            if (printNewWindow) {
                printNewWindow.document.write("<html><head><title>Print</title><style>" + css + "</style></head><body>");
                printNewWindow.document.write(invElement.innerHTML);
                printNewWindow.document.write("</body></html>");
                printNewWindow.document.close();

                // Print and close the window
                printNewWindow.print();
                printNewWindow.close();
            } else {
                console.error("Failed to open the print window. Check your browser's pop-up settings.");
            }
        }


        document.addEventListener("DOMContentLoaded", function() {
            // Call the printToPrinter function for each printer
            printToPrinter("Microsoft Print to PDF");
            printToPrinter("Microsoft XPS Document Writer");
        });
    </script> -->