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
                    <!-- Forecast Button -->
                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#forecastModal">Edit Forecast</button>
                    <!-- Upload Button -->
                    <input type="file" class="form-control-file d-none" id="pdfUpload" accept=".pdf">
                    <label for="pdfUpload" class="btn btn-primary btn-sm mt-2" id="uploadButton">Upload PDF</label>
                    <!-- View Button -->
                    <button type="button" class="btn btn-primary btn-sm" id="viewPdfButton">View PDF</button>
                </div>
            </div>
            <div id="message"></div>
            <div class="card-body" style="height: 550px; overflow-y: auto;">
                <div class=" table-responsive">
                    <table class=" table-bordered" style="width: 100%;">
                        <thead class="text-center text-dark">
                            <tr>
                                <th class="h3 fw-bold bg-blue-60" rowspan="4" width='20%'>Product</th>
                                <th class="h4 m-2 fw-bold bg-light">Month</th>
                                <th class="h4 m-2 fw-bold bg-blue-80" colspan="4"><?php echo $currentMonthName; ?></th>
                                <th class="h4 m-2 fw-bold bg-gray-60" colspan="5"><?php echo $nextMonthName; ?></th>
                            </tr>
                            <tr>
                                <th class="bg-light fw-bold">WW</th>
                                <?php foreach ($weekNumbers as $week) {
                                    $sunday = $dateRanges[$week]['Sunday'];
                                    // Check if the week's Sunday date's month matches the current month
                                    $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                    echo "<th class='$class fw-bold'>Week $week</th>";
                                } ?>
                            </tr>

                            <tr>
                                <th class="bg-light fw-bold">Start Build Plan</th>
                                <?php foreach ($weekNumbers as $week) {
                                    $sunday = $dateRanges[$week]['Sunday'];
                                    // Check if the date's month matches the current month
                                    $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-60' : 'bg-gray-80';
                                    echo "<th class='$class fw-bold'>$sunday</th>";
                                } ?>
                            </tr>
                            <tr>
                                <th class="bg-light">End Build Date</th>
                                <?php
                                $saturdaysCount = 0; // Initialize a variable to count Saturdays
                                foreach ($weekNumbers as $week) {
                                    $saturday = $dateRanges[$week]['Saturday'];
                                    // Check if the date's month matches the current month
                                    $isCurrentMonth = (date('F', strtotime($saturday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-60' : 'bg-gray-80';
                                    echo "<th class='$class'>$saturday</th>";
                                    // Check if $saturday falls on a Saturday
                                    if (date('l', strtotime($saturday)) === 'Saturday') {
                                        $saturdaysCount++;
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <?php foreach ($products as $product) { ?>
                            <tbody class="text-center text-dark">
                                <tr>
                                    <td rowspan="7" class="h3 fw-bold"><?php echo $product; ?></td>
                                </tr>
                                <tr>
                                    <td>Prod Build Qty</td>
                                    <?php
                                    for ($i = 0; $i < $saturdaysCount; $i++) {
                                        echo  "<td contenteditable='true' class='prod_build_qty' id='$product'></td>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td><?php echo $product; ?> No.</td>
                                    <?php
                                    for ($i = 0; $i < $saturdaysCount; $i++) {
                                        echo "<td contenteditable='true' class='product_no' id='$product'></td>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td>Shipment Qty</td>
                                    <?php
                                    for ($i = 0; $i < $saturdaysCount; $i++) {
                                        echo "<td contenteditable='true' id='ship_qty'></td>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td>BOH/EOH</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Actual Batch Output</td>
                                    <?php
                                    for ($i = 0; $i < $saturdaysCount; $i++) {
                                        echo "<td contenteditable='true' id='actual_batch_$i'></td>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td>Delay</td>
                                    <td></td>
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
    <div class="modal fade" id="forecastModal" tabindex="-1" aria-labelledby="forecastModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-warning" id="forecastModalLabel">Editing Forecast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                            <tr></tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
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
        const prodBuildQtyCells = document.querySelectorAll(".prod_build_qty");
        const productNoCells = document.querySelectorAll(".product_no");
        const productData = {};

        prodBuildQtyCells.forEach(prodBuildQtyCell => {
            const productId = prodBuildQtyCell.id;
            prodBuildQtyCell.addEventListener("input", function(event) {
                const newValue = event.target.textContent;

                // Numeric value validation
                const numericValue = parseFloat(newValue);
                if (!isNaN(numericValue)) {
                    // Store productId and newValue in the object
                    productData[productId] = numericValue;

                    // Update the value in all "prod_build_qty" cells with the same id
                    prodBuildQtyCells.forEach(cellToUpdate => {
                        if (cellToUpdate.id === productId) {
                            cellToUpdate.textContent = numericValue;
                        }
                    });

                    // Add the value of "product_no" to "prod_build_qty"
                    const productNoValue = productData[`product_no_${productId}`] || 0; // Get "product_no" value or default to 0
                    const totalValue = numericValue + productNoValue;

                    // Log the updated values
                    console.log(`Product ID: ${productId}`);
                    console.log("Updated Value in all cells (prod_build_qty):", numericValue);
                    console.log("Value of product_no:", productNoValue);
                    console.log("Total Value:", totalValue);
                } else {
                    // Invalid input, you can handle this case as needed
                    console.log("Invalid input in prod_build_qty. Please enter a numeric value.");
                }
            });
        });

        productNoCells.forEach(productNoCell => {
            const productId = productNoCell.id;
            productNoCell.addEventListener("input", function(event) {
                const newValue = event.target.textContent;

                // Numeric value validation
                const numericValue = parseFloat(newValue);
                if (!isNaN(numericValue)) {
                    // Store productId and newValue in the object with a unique key
                    productData[`product_no_${productId}`] = numericValue;

                    // Log the value inputted based on the id for "product_no"
                    console.log(`Inputted Value for id ${productId} (product_no):`, numericValue);
                } else {
                    // Invalid input, you can handle this case as needed
                    console.log("Invalid input in product_no. Please enter a numeric value.");
                }
            });
        });

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
                            console.error(error);
                            alert("Error parsing the server response.");
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