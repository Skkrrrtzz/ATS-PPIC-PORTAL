<?php require_once 'ppic_nav.php';
include_once '../controller/commands.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Schedule</title>
    <style>
        .bg-blue-60 {
            background-color: #b8c4e4;
        }

        .bg-blue-80 {
            background-color: #e0e4f4;
        }

        .bg-gray-60 {
            background-color: #e0dcdc;
        }

        .bg-gray-80 {
            background-color: #f0ecec;
        }

        .bg-pink {
            background-color: #ffcccc;
        }
    </style>
</head>

<body id="master_schedule">

    <div class="container-fluid">
        <div class="card shadow my-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">
                    Master Schedule
                </h4>
                <!-- Buttons -->
                <div class="my-0">
                    <!-- Edit Button -->
                    <button type="button" class="btn btn-sm btn-warning edit-all-button" data-toggle="modal" data-target="#masterSchedModal">Edit Master Schedule</button>
                    <!-- Save Button -->
                    <button type="submit" class="btn btn-success btn-sm float-end save-button" id="saveChangesBtn" name="save_btn">Save Changes</button>
                    <!-- Upload Button -->
                    <input type="file" class="form-control-file d-none" id="pdfUpload" accept=".pdf">
                    <label for="pdfUpload" class="btn btn-primary btn-sm mt-2" id="uploadButton">Upload PDF</label>
                    <!-- View Button -->
                    <button type="button" class="btn btn-primary btn-sm" id="viewPdfButton">View PDF</button>
                </div>
            </div>
            <div id="message"></div>
            <div class="card-body" style="height: 550px; overflow-y: auto;">
                <div class="table-responsive">
                    <input type="hidden" name="monthnow" value="<?= $currentMonthName; ?>">
                    <input type="hidden" name="monthnxt" value="<?= $nextMonthName; ?>">

                    <table class=" table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="4">Product</th>
                                <th>Month</th>
                                <td colspan="4" class="bg-blue-80 text-dark" name="monthnow"><?= $currentMonthName; ?></td>
                                <td colspan="5" class="bg-gray-60 text-dark" name="monthnxt"><?= $nextMonthName; ?></td>
                            </tr>
                            <tr>
                                <th>Week</th>
                                <?php foreach ($weekNumbers as $week) : ?>
                                    <?php
                                    $sunday = $dateRanges[$week]['Sunday'];
                                    $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                    ?>
                                    <td class="<?= $class; ?> text-dark">
                                        Week <?= $week; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <th>Start Build Plan</th>
                                <?php foreach ($weekNumbers as $week) : ?>
                                    <?php
                                    $sunday = $dateRanges[$week]['Sunday'];
                                    $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                    ?>
                                    <td class="<?= $class; ?> text-dark"><?= $sunday; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <th>End Build Date</th>
                                <?php foreach ($weekNumbers as $week) : ?>
                                    <?php
                                    $saturday = $dateRanges[$week]['Saturday'];
                                    $isCurrentMonth = (date('F', strtotime($saturday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                    ?>
                                    <td class="<?= $class; ?> text-dark"><?= $saturday; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <?php
                        foreach ($products as $product) {
                            $firstTd = true;
                        ?>
                            <tbody>
                                <tr>
                                    <td rowspan="7" data-product="<?php echo $product; ?>" name="product" data-month="<?php echo $currentMonthName; ?> ">
                                        <?php echo $product; ?>
                                    </td>
                                    <input type="hidden" name="product[]" value="<?= $product; ?>">
                                    <th>Prod Build Qty</th>
                                    <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                        <td class="" name="prod_build_qty" data-product="<?php echo $product; ?>">
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                                <tr>
                                    <th><?php echo $product; ?> No.</th>
                                    <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                        <td class="" data-product="<?= $product; ?>">
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                                <tr>
                                    <th>Shipment Qty</th>
                                    <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                        <td class="" name="ship_qty" data-product="<?php echo $product; ?>">
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                                <tr>
                                    <th>BOH/EOH</th>
                                    <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                        <td class="" name="boh_eoh" data-product="<?php echo $product; ?>"></td>
                                    <?php endfor; ?>
                                </tr>
                                <tr>
                                    <th>Actual Batch Output</th>
                                    <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                        <td class="" name="act_batch_output" data-product="<?php echo $product; ?>"></td>
                                    <?php endfor; ?>
                                </tr>
                                <tr>
                                    <th>Delay</th>
                                    <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                        <td class="" name="delay" data-product="<?php echo $product; ?>"></td>
                                    <?php endfor; ?>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Viewing PDF -->
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-gray-300 my-0">
                    <h5 class="modal-title fw-bold" id="pdfModalLabel">PDF Viewer</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="" id="uploaded_by"></h6>
                    <iframe id="pdfViewer" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for editing Forecast -->
    <div class="modal fade" id="masterSchedModal" tabindex="-1" aria-labelledby="masterSchedLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-warning" id="masterSchedLabel">Editing Master Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group col-md-4 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="productSelect">Products</label>
                        </div>
                        <select class="custom-select" id="productSelect">
                            <option selected>Choose...</option>
                            <?php foreach ($products as $product) { ?>
                                <option><?php echo $product; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="table-responsive" id="productTable" style="display: none;">
                        <form action="../controller/upload_data.php" method="post">
                            <input type="text" name="emp_name" id="emp_name" value="<?php echo $emp_name; ?>">
                            <input type="text" name="product" id="product" value="<?php echo $product; ?>">
                            <input type="text" name="curmonth" id="curmonth" value="<?php echo $currentMonthName; ?>">
                            <input type="text" name="monthnxt" id="monthnxt" value="<?php echo $nextMonthName; ?>">
                            <table class=" table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Month</th>
                                        <td colspan="5" class="bg-blue-80 text-dark" name="monthnow"><?= $currentMonthName; ?></td>
                                        <td colspan="4" class="bg-gray-60 text-dark" name="monthnxt"><?= $nextMonthName; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Week</th>
                                        <?php foreach ($weekNumbers as $week) : ?>
                                            <?php
                                            $sunday = $dateRanges[$week]['Sunday'];
                                            $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                            $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                            ?>
                                            <td class="<?= $class; ?> text-dark"> Week <?= $week; ?>
                                                <input type="hidden" name="week[]" value="<?php echo $week; ?>">
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>

                                    <tr>
                                        <th>Start Build Plan</th>
                                        <?php foreach ($weekNumbers as $week) : ?>
                                            <?php
                                            $sunday = $dateRanges[$week]['Sunday'];
                                            $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                            $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                            ?>
                                            <td class="<?= $class; ?> text-dark"><?= $sunday; ?>
                                                <input type="hidden" name="wkstart[]" value="<?php echo $sunday; ?>">
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <th>End Build Date</th>
                                        <?php foreach ($weekNumbers as $week) : ?>
                                            <?php
                                            $saturday = $dateRanges[$week]['Saturday'];
                                            $isCurrentMonth = (date('F', strtotime($saturday)) === $currentMonthName);
                                            $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                            ?>
                                            <td class="<?= $class; ?> text-dark"><?= $saturday; ?>
                                                <input type="hidden" name="wkend[]" value="<?php echo $saturday; ?>">
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Prod Build Qty</th>
                                        <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                            <td name="prod_build_qty">
                                                <input type="number" class="w-75" name="prod_build_qty[]" value="">
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <th id="productHeader"></th>
                                        <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                            <td name="product_no">
                                                <?php if ($i === 0) { ?>
                                                    <input type="number" class="w-75" name="product_no[]" value="">
                                                <?php } ?>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <th>Shipment Qty</th>
                                        <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                            <td name="ship_qty">
                                                <input type="number" class="w-75" name="ship_qty[]" value="">
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <th>BOH/EOH</th>
                                        <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                            <td name="boh_eoh">
                                                <?php if ($i === 0) { ?>
                                                    <input type="number" class="w-75" name="boh_eoh[]" value="">
                                                <?php } ?>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <th>Actual Batch Output</th>
                                        <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                            <td name="act_batch_output"></td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <th>Delay</th>
                                        <?php for ($i = 0; $i < $saturdaysCount; $i++) : ?>
                                            <td name="delay"></td>
                                        <?php endfor; ?>
                                    </tr>
                                </tbody>
                            </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productSelect = document.getElementById("productSelect");
            const productTable = document.getElementById("productTable");
            const productHeader = document.getElementById("productHeader");

            productSelect.addEventListener("change", function() {
                const selectedProduct = productSelect.value;

                // Set the selected product as a variable
                document.getElementById("product").value = selectedProduct;

                if (selectedProduct === "Choose...") {
                    productTable.style.display = "none";
                } else {
                    productTable.style.display = "block";

                    // Update the table header text with the selected product
                    productHeader.textContent = selectedProduct + " No.";
                }
            });
        });
    </script>
    <script>
        // document.getElementById('sidebarToggleTop').click();
        // JavaScript code to add the bg-pink class if the td has a numeric value
        const editableCells = document.querySelectorAll("#ship_qty");

        editableCells.forEach(function(cell) {
            cell.addEventListener("input", function() {
                const content = cell.textContent.trim();
                if (/^\d+(\.\d+)?$/.test(content)) {
                    cell.classList.add("bg-pink");
                } else {
                    cell.classList.remove("bg-pink");
                }
            });
        });

        // JavaScript code to allow only numbers in content-editable cells
        const cells = document.querySelectorAll('[id^="actual_batch_"]');

        cells.forEach(function(cell) {
            cell.addEventListener('input', function() {
                const content = cell.textContent.trim();
                const numericContent = content.replace(/[^0-9]/g, '');
                cell.textContent = numericContent;
            });
        });
        // const prodBuildQtyCells = document.querySelectorAll(".prod_build_qty");
        // const productNoCells = document.querySelectorAll(".product_no");
        // const productData = {};

        // prodBuildQtyCells.forEach(prodBuildQtyCell => {
        //     const productId = prodBuildQtyCell.id;
        //     prodBuildQtyCell.addEventListener("input", function(event) {
        //         const newValue = event.target.textContent;

        //         // Numeric value validation
        //         const numericValue = parseFloat(newValue);
        //         if (!isNaN(numericValue)) {
        //             // Store productId and newValue in the object
        //             productData[productId] = numericValue;

        //             // Update the value in all "prod_build_qty" cells with the same id
        //             prodBuildQtyCells.forEach(cellToUpdate => {
        //                 if (cellToUpdate.id === productId) {
        //                     cellToUpdate.textContent = numericValue;
        //                 }
        //             });

        //             // Add the value of "product_no" to "prod_build_qty"
        //             const productNoValue = productData[`product_no_${productId}`] || 0; // Get "product_no" value or default to 0
        //             const totalValue = numericValue + productNoValue;

        //             // Log the updated values
        //             console.log(`Product ID: ${productId}`);
        //             console.log("Updated Value in all cells (prod_build_qty):", numericValue);
        //             console.log("Value of product_no:", productNoValue);
        //             console.log("Total Value:", totalValue);
        //         } else {
        //             // Invalid input, you can handle this case as needed
        //             console.log("Invalid input in prod_build_qty. Please enter a numeric value.");
        //         }
        //     });
        // });

        // productNoCells.forEach(productNoCell => {
        //     const productId = productNoCell.id;
        //     productNoCell.addEventListener("input", function(event) {
        //         const newValue = event.target.textContent;

        //         // Numeric value validation
        //         const numericValue = parseFloat(newValue);
        //         if (!isNaN(numericValue)) {
        //             // Store productId and newValue in the object with a unique key
        //             productData[`product_no_${productId}`] = numericValue;

        //             // Log the value inputted based on the id for "product_no"
        //             console.log(`Inputted Value for id ${productId} (product_no):`, numericValue);
        //         } else {
        //             // Invalid input, you can handle this case as needed
        //             console.log("Invalid input in product_no. Please enter a numeric value.");
        //         }
        //     });
        // });

        // Javascript for uploading PDF file and Viewing uploaded PDF
        $(document).ready(function() {
            $("#pdfUpload").click(function() {
                $("#pdfUpload").change(function() {
                    var fileInput = document.getElementById('pdfUpload');
                    var file = fileInput.files[0];
                    var empName = '<?php echo $emp_name; ?>';

                    if (file) {
                        var formData = new FormData();
                        formData.append("pdfFile", file);
                        formData.append("empName", empName);

                        $.ajax({
                            type: "POST",
                            url: "../controller/upload_file.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $("#message").html(response);
                            }
                        });
                    }
                });
            });

            // Attach a click event handler to the "View PDF" button
            $("#viewPdfButton").click(function() {

                $.ajax({
                    type: "POST",
                    url: "../controller/upload_file.php",
                    data: {
                        empName: '<?php echo $emp_name; ?>',
                        upload: true
                    }, // Pass the parameter as an object
                    success: function(response) {
                        try {
                            // Parse the JSON response
                            var responseData = JSON.parse(response);

                            // Check if responseData has the file_loc property
                            if (responseData.file_loc) {
                                // Combine "Uploaded by:" and the value of uploaded_by
                                var uploadedByText = "Uploaded by: " + responseData.uploaded_by + " - Date: " + responseData.uploaded_date;
                                // Set the text content of the HTML element
                                $("#uploaded_by").text(uploadedByText);
                                // Set the src attribute of the iframe in the modal
                                $("#pdfViewer").attr("src", responseData.file_loc);
                                // Show the modal
                                $("#pdfModal").modal("show");
                            } else {
                                // Handle the case where the PDF URL is not found
                                alert("PDF URL not found in the database.");
                            }
                        } catch (error) {
                            // Handle JSON parsing errors or other issues
                            // console.error(error);
                            alert("No PDF uploaded");
                        }
                    },
                    error: function() {
                        // Handle AJAX error, if any
                        alert("Error fetching PDF URL from the database.");
                    }
                });
            });
        });
    </script>
</body>

</html>