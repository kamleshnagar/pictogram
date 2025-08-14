<!-- Bootstrap Modal -->
<?php
    if(!isset($_SESSION['invoiceData'])){
        $_GET['log'] == true;
    }else{

    ?>



<div class="modal fade modal-dialog-scrollable " id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl  " style="max-width: 600px;">
        <div class="modal-content ">


            <!-- Begin Modal Body -->
            <div class="modal-body  " id="invoiceContent">
                <!-- ---------------------------------------------------------------------------------------------- -->



                <div id="invoice-content" class="modal-invoice-content w-100">
                    <?php
                    ?>

                    <?php
                    include 'process/db.php';
                    // session_start();

                    $result = mysqli_query($conn, "SELECT id FROM invoices ORDER BY id DESC LIMIT 1");
                    $row = mysqli_fetch_assoc($result);
                    $lastInvoiceID = $row['id'] ?? 0;

                    // Optional: Create a custom formatted invoice number
                    $invoiceNo = "S888/2526/" . str_pad($lastInvoiceID + 1, 3, '0', STR_PAD_LEFT);

                    $transactions = $_SESSION['transactions'] ?? [];
                    $invoiceData = json_decode($_SESSION['invoiceData'] ?? '{}', true);
                    $products = $invoiceData['products'] ?? [];

                    $customername = strtoupper(htmlspecialchars($invoiceData['customerName'] ?? '-'));
                    $customerMobile = htmlspecialchars($invoiceData['customerMobile'] ?? '-');
                    $salesman = htmlspecialchars($invoiceData['salesman'] ?? '-');
                    $totalQty = number_format($invoiceData['totalQty'] ?? 0);
                    $totalSelling = $invoiceData['totalSelling'] ?? 0;
                    $finalDiscount = $invoiceData['finalDiscount'] ?? 0;
                    $netAmount = $invoiceData['netAmount'] ?? 0;
                    $payableAmount = $invoiceData['payableAmount'] ?? 0;
                    $invoiceNo = htmlspecialchars($invoiceData['invoiceNo'] ?? $invoiceNo);
                    $date = date('M d Y H:i:s');
                    $offerApplied = $invoiceData['offerApplied'];
                    $customer_mo =  $customerMobile;



                    $stmt = $conn->prepare("SELECT id FROM customers WHERE customer_mo = ?");
                    $stmt->bind_param("s", $customer_mo);
                    $stmt->execute();
                    $stmt->store_result();





                    if ($stmt->num_rows == 0) {

                        $stmt->close();
                        $stmt = $conn->prepare("INSERT INTO customers (customer_name, customer_mo) VALUES (?, ?)");
                        $stmt->bind_param("ss", $customername, $customer_mo);
                        $stmt->execute();
                    }
                    $stmt->close();


                    ?>



                    <div class="w-100">
                        <div class="invoice-modal">

                            <h5 class="text-center mt-3"><strong>Retail Invoice</strong></h5>

                            <div class="text-center mb-3">
                                AXE<br>
                                AXE_AMD_VASTRAL<br>
                                <strong>LACONIC ENTERPRISE PRIVATE LIMITED</strong><br>
                                24AADCL3990Q2ZV<br>
                            </div>
                            GF-8, SatvaIcon., S.P.Ring Road, Vastral, Ahmedabad, 382418 Gujarat, India

                            <div class="dashed"></div>

                            <div class="row mb-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <div>Invoice No:</div>
                                    <div><strong><?= $invoiceNo ?></strong></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <div> Customer Name:</div>
                                    <div><?= $customername ?></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <div>Mobile:</div>
                                    <div> <?= $customerMobile ?></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <div>Date:</div>
                                    <div> <?= $date ?></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <div>Sales Person:</div>
                                    <div><strong><?= $salesman ?></strong></div>
                                </div>

                            </div>


                            <div class="dashed"></div>

                            <div class="barcode  w-auto">
                                <svg id="invoiceBarcode"></svg>
                            </div>
                            <div class="dashed"></div>
                            <table class="table-invoice ">
                                <thead class="w-100">
                                    <tr class="w-100">
                                        <th>SNO</th>
                                        <th>Item</th>
                                        <th>MRP</th>
                                        <th>QTY</th>
                                        <th>Disc</th>
                                        <th>HSN</th>
                                        <th>Amount</th>

                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $sno = 1;



                                    foreach ($products as $item) {
                                        $barcode = htmlspecialchars($item['barcode']);
                                        $name = htmlspecialchars($item['productName']);
                                        $color = $item['color'];
                                        $size = $item['size'];
                                        $sku = htmlspecialchars($item['sku']);
                                        $qty = (int)$item['qty'];
                                        $price =  (float)$item['price'];
                                        $discount =  (float)$item['discount'];
                                        $value = (float)$item['value'];

                                        $gst = (float)$item['gst'];
                                        $tax =  $value * ($gst / 100);
                                        $taxable = $value - $tax;

                                        $total = $value * $qty;
                                        $totalTax =  number_format(($tax * $qty), 2);
                                        $cat = substr($name, 0, 2);
                                        if ($cat === "SH") {
                                            $hsn = 62052000;
                                        } else if ($cat === "TR" || $cat === "JN" || $cat === "MS") {
                                            $hsn = 62034200;
                                        } else if ($cat === "TS" || $cat === "FK") {
                                            $hsn = 61091000;
                                        } else if ($cat === "WL") {
                                            $hsn = 42023120;
                                        } else if ($cat === "BL") {
                                            $hsn = 42033000;
                                        } else if ($cat === "SK") {
                                            $hsn = 61159200;
                                        } else {
                                            $hsn = 'N/A';
                                        }

                                        if (!isset($_SESSION['InsertSelesData']) || $_SESSION['InsertSelesData'] !== true) {



                                            $InsertSelesData = "INSERT INTO `sales` (`customer_name`, `customer_mo`, `invoice_no`, `date`, `barcode`, `article_no`, `color`, `size`, `qty`, `mrp`, `discount`, `taxable`, `tax`, `value`) VALUES
                                             ('$customername', '$customerMobile', '$invoiceNo', current_timestamp(), '$barcode', '$name', '$color', '$size','$qty', '$price', '$discount', '$taxable', '$tax', '$total')";
                                            $result = mysqli_query($conn, $InsertSelesData);
                                        }

                                        echo
                                        "<tr>
                                        <td class=''>{$sno}</td>
                                        <td class='text-start' >{$name}<br>{$sku}</td>
                                        <td  class=''>{$price}</td>
                                        <td class=''>{$qty}</td>
                                        <td  class=''>{$discount}</td>
                                        <td  class=''>{$hsn}</td>
                                        <td>
                                            <div  class=''>" . number_format($taxable, 2) . "</div>
                                            <div  class=''><small>Tax:" . number_format($tax, 2) . "</small></div>
                                        </td>

                                        <td  class=''>$total</td>
                                    </tr>";
                                        $sno++;
                                    }
                                    $_SESSION['InsertSelesData'] = true;

                                    ?>

                                </tbody>
                            </table>
                            <?php

                            $gst5Total = $gst12Total = 0;
                            foreach ($products as $item) {
                                $gst = (float)$item['gst'];
                                $value = (float)$item['value'];
                                $qty = (int)$item['qty'];
                                $totalTax = $value * ($gst / 100) * $qty;
                                if ($gst == 5.0) {
                                    $gst5Total += $totalTax;
                                } elseif ($gst == 12.0) {
                                    $gst12Total += $totalTax;
                                }
                            }
                            $totalTax = $gst12Total + $gst5Total;
                            $totalTaxable = $payableAmount - $totalTax;

                            if (!isset($_SESSION['InsertInvoiceData']) || $_SESSION['InsertInvoiceData'] !== true) {

                                $InsertInvoiceData = "INSERT INTO `invoices` ( `invoice_no`, `date`, `customer_name`, `customer_mo`, `salesman`, `qty`, `total_mrp`, `total_discount`, `payable_amount`, `selected_offer`) VALUES ('$invoiceNo',  current_timestamp(), '$customername', '$customerMobile', '$salesman', '$totalQty', '$totalSelling', '$finalDiscount', '$payableAmount', '$offerApplied')";
                                $result = mysqli_query($conn, $InsertInvoiceData);
                                $invoiceId = mysqli_insert_id($conn);

                                $_SESSION['InsertInvoiceData'] = true;
                            }


                            ?>


                            <div class="row d-flex flex-column">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between mt-3">
                                        <div><strong>Total Quantity:</strong></div>
                                        <div><strong><?= number_format($totalQty, 2) ?></strong></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div><strong>Total Discount:</strong></div>
                                        <div><strong>₹<?= number_format($finalDiscount, 2) ?></strong></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div><strong>Total Taxable Amount:</strong></div>
                                        <div><strong>₹<?= number_format($totalTaxable, 2) ?></strong></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div><strong>Total Tax:</strong></div>
                                        <div><strong>₹<?= number_format($totalTax, 2) ?></strong></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div><strong>Total Payable:</strong></div>
                                        <div><strong> ₹<?= number_format($payableAmount, 2) ?></strong></div>
                                    </div>
                                    <div class="dashed"></div>
                                </div>
                                <div class="col-12 text-end">
                                    <?php
                                    $hasTransaction = false;
                                    foreach ($transactions as $txn) {
                                        if ($txn['amount'] > 0) {
                                            $hasTransaction = true;
                                            echo "<strong>" . ucfirst($txn['mode']) . ": ₹" . number_format($txn['amount'], 2) . "</strong><br>";
                                        }
                                    }

                                    ?>


                                    <div class="dashed"></div>
                                </div>
                            </div>



                            <div class="text-center mb-2">
                                <strong>Tax Breakup</strong>
                                <div class="dashed"></div>
                            </div>



                            <table class="  text-center tax-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tax %</th>
                                        <th>SGST %</th>
                                        <th>CGST %</th>
                                        <th>SGST Amount</th>
                                        <th>CGST Amount</th>
                                        <th>Tax Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($gst5Total > 0): ?>
                                        <tr>
                                            <td>5%</td>
                                            <td>2.5%</td>
                                            <td>2.5%</td>
                                            <td>₹<?= number_format($gst5Total / 2, 2) ?></td>
                                            <td>₹<?= number_format($gst5Total / 2, 2) ?></td>
                                            <td>₹<?= number_format($gst5Total, 2) ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($gst12Total > 0): ?>
                                        <tr>
                                            <td>12%</td>
                                            <td>6%</td>
                                            <td>6%</td>
                                            <td>₹<?= number_format($gst12Total / 2, 2) ?></td>
                                            <td>₹<?= number_format($gst12Total / 2, 2) ?></td>
                                            <td>₹<?= number_format($gst12Total, 2) ?></td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>

                            </table>

                            <div class="footer">
                                <div class="footer-note my-2">
                                    <strong>Thank you! Visit again!</strong><br>
                                </div>
                                <p>*All prices are tax-inclusive *</p>
                                <p> *Exchange accepted within 7 days of purchase on original condition.*</p>
                            </div>
                        </div>
                        <script>
                            // Pass PHP invoice number to JavaScript
                            const invoiceNo = "<?= $invoiceNo ?>";

                            // Render barcode using JsBarcode
                            JsBarcode("#invoiceBarcode", invoiceNo, {
                                format: "CODE128",
                                lineColor: "#000",
                                width: 1.5,
                                height: 80,
                                displayValue: true
                            });
                        </script>


                    </div>

                    <?php
                    // if (isset($_GET['s']) && $_GET === "s") {
                    //     header('Location: https://wa.me/91' . $customer_mo);
                    //     echo "success";
                    //     exit;

                    ?>



                    <!-- ---------------------------------------------------------------------------------------------- -->





                </div>
                <div class="modal-footer">

                    <script>
                        function printInvoice() {

                            setTimeout(() => {

                                const printContent = document.getElementById('invoice-content').innerHTML;
                                const originalContent = document.body.innerHTML;
                                document.body.innerHTML = printContent;
                                window.print();
                                setTimeout(() => {
                                    document.body.innerHTML = originalContent;
                                    location.reload();
                                }, 1000);
                            }, 300);




                        }
                    </script>
                    <?php
                    $waurl = "https://wa.me/91" . $customer_mo;
                    ?>



                    <button class="btn btn-primary text-light" style="width:150px;" onclick="printInvoice(); window.open('<?= $waurl ?>', '_blank');">Print</button>


                    <a href="sales.php" class="btn btn-secondary text-light text-decoration-none" style="width:150px; display:inline-block; text-align:center;">
                        Exit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>