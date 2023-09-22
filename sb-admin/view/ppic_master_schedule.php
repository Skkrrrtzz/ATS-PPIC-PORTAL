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
                    <!-- Save Button -->
                    <button type="submit" class="btn btn-success btn-sm float-end" id="saveChangesBtn" name="save_btn">Save Changes</button>
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
                                <th class="h4 m-2 fw-bold bg-blue-80" colspan="4" name="curmonth"><?php echo $currentMonthName; ?></th>
                                <th class="h4 m-2 fw-bold bg-gray-60" colspan="5" name="nxtmonth"><?php echo $nextMonthName; ?></th>
                            </tr>
                            <tr>
                                <th class="bg-light fw-bold">WW</th>
                                <?php foreach ($weekNumbers as $week) {
                                    $sunday = $dateRanges[$week]['Sunday'];
                                    // Check if the week's Sunday date's month matches the current month
                                    $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-80' : 'bg-gray-60';
                                    echo "<th class='$class fw-bold' name='week'>Week $week</th>";
                                } ?>
                            </tr>

                            <tr>
                                <th class="bg-light fw-bold">Start Build Plan</th>
                                <?php foreach ($weekNumbers as $week) {
                                    $sunday = $dateRanges[$week]['Sunday'];
                                    // Check if the date's month matches the current month
                                    $isCurrentMonth = (date('F', strtotime($sunday)) === $currentMonthName);
                                    $class = $isCurrentMonth ? 'bg-blue-60' : 'bg-gray-80';
                                    echo "<th class='$class fw-bold' name='wkstart'>$sunday</th>";
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
                                    echo "<th class='$class' name='wkend'>$saturday</th>";
                                    // Check if $saturday falls on a Saturday
                                    if (date('l', strtotime($saturday)) === 'Saturday') {
                                        $saturdaysCount++;
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <?php
                        foreach ($products as $product) {
                        }
                        $tbodyId = 'tbody_' . $product;
                        $build_qtyId = 'prod_build_qty' . $product;
                        $product_noId = 'product_no' . $product;
                        $ship_qtyId = 'shipment_qty' . $product;
                        $boh_eohId = 'boh_eoh' . $product;
                        $actual_batch_outputId = 'actual_batch_output' . $product;
                        $delayId = 'delay' . $product;
                        ?>
                        <tbody class="text-center text-dark" id=<?php echo $tbodyId; ?>'>
                            <tr>
                                <td rowspan="7" class="h3 fw-bold" name="product"><?php echo $product; ?></td>
                            </tr>
                            <tr>
                                <td>Prod Build Qty</td>
                                <?php
                                for ($i = 0; $i < $saturdaysCount; $i++) {
                                    echo  "<td contenteditable='true' id='$build_qtyId' name='prod_build_qty'></td>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <td><?php echo $product; ?> No.</td>
                                <?php
                                for ($i = 0; $i < $saturdaysCount; $i++) {
                                    $firstEditableAdded = false;
                                    for ($i = 0; $i < $saturdaysCount; $i++) {
                                        if (!$firstEditableAdded) {
                                            echo "<td contenteditable='true' id='$product_noId' name='prod_no'></td>";
                                            $firstEditableAdded = true;
                                        } else {
                                            echo "<td id='$product_noId' name='prod_no'></td>";
                                        }
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td>Shipment Qty</td>
                                <?php
                                for ($i = 0; $i < $saturdaysCount; $i++) {
                                    echo "<td contenteditable='true' id='$ship_qtyId' name='ship_qty'></td>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <td>BOH/EOH</td>
                                <?php
                                $firstEditableAdded = false;
                                for ($i = 0; $i < $saturdaysCount; $i++) {
                                    if (!$firstEditableAdded) {
                                        echo "<td contenteditable='true' id='$boh_eohId' name='boh_eoh'></td>";
                                        $firstEditableAdded = true;
                                    } else {
                                        echo "<td id='$boh_eohId'></td>";
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td>Actual Batch Output</td>
                                <?php
                                for ($i = 0; $i < $saturdaysCount; $i++) {
                                    echo "<td contenteditable='true' id='$actual_batch_outputId' name='act_batch_output'></td>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <td>Delay</td>
                                <?php
                                for ($i = 0; $i < $saturdaysCount; $i++) {
                                    echo "<td id='$delayId' name='delay'></td>";
                                }
                                ?>
                            </tr>
                        </tbody>
                        <?php  ?>
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
        $(document).ready(function() {
            function isWithinDateRange(editedValue, curMonth, dateRange) {
                // Split the date range into Sunday and Saturday dates
                let sundayDate = dateRange["Sunday"];
                let saturdayDate = dateRange["Saturday"];

                // Convert the Sunday and Saturday dates to JavaScript Date objects
                let sundayDateObj = new Date(sundayDate);
                let saturdayDateObj = new Date(saturdayDate);

                // Check if the current month matches the specified month
                if (curMonth !== sundayDateObj.toLocaleString('en-US', {
                        month: 'long'
                    })) {
                    return false;
                }

                // Convert the edited value to a number (assuming it's a numeric value)
                let editedValueNumber = parseFloat(editedValue);

                // Check if the edited value is a valid number
                if (isNaN(editedValueNumber)) {
                    return false;
                }

                // Check if the edited value is within the range of 0 and 100 (or adjust as needed)
                if (editedValueNumber < 0 || editedValueNumber > 100) {
                    return false;
                }

                // Check if the edited value is within the date range
                if (sundayDateObj <= saturdayDateObj) {
                    // If Sunday is before or the same as Saturday, check if the edited value
                    // falls within the range of Sunday and Saturday dates
                    let editedDateObj = new Date(sundayDate);
                    editedDateObj.setDate(editedDateObj.getDate() + 1); // Start from Sunday

                    while (editedDateObj <= saturdayDateObj) {
                        if (editedDateObj.toLocaleDateString() === sundayDateObj.toLocaleDateString()) {
                            // If the edited date matches a date within the range, return true
                            return true;
                        }
                        editedDateObj.setDate(editedDateObj.getDate() + 1); // Move to the next day
                    }
                }

                // If none of the conditions matched, return false
                return false;
            }

            // Disable the save button initially
            $("#saveChangesBtn").prop("disabled", true);

            // Create an array to store the edited data
            let editedData = [];

            // Define the expected month, week, and date range
            let curMonth = "<?php echo $currentMonthName; ?>";
            let weekNumbers = <?php echo json_encode($weekNumbers); ?>;
            let dateRanges = <?php echo json_encode($dateRanges); ?>;

            // Add event listener for detecting changes in the table cells
            $("tbody tr td").on("input", function() {
                // Enable the save button when any cell is edited
                $("#saveChangesBtn").prop("disabled", false);

                // Get the edited cell's content
                let editedCellValue = $(this).text();
                // Get the ID attribute of the edited cell (which corresponds to the product name)
                let productId = $(this).attr("id");
                let cellIndex = $(this).index();
                // Find the corresponding week number based on the product ID
                let weekNumber = weekNumbers[cellIndex];

                // Add debugging statements
                console.log("productId:", productId);
                console.log("weekNumber:", weekNumber);
                console.log("dateRange:", dateRanges[weekNumber]);
                console.log("Value:", editedCellValue);
                console.log("Index:", cellIndex);
                // Get the date range for the corresponding week number
                let dateRange = dateRanges[weekNumber];

                // Check if the edited value is within the expected month and date range
                if (isWithinDateRange(editedCellValue, curMonth, dateRange)) {
                    // Get the ID attribute of the edited cell (which corresponds to the product name)
                    let productId = $(this).attr("id");

                    // Push the edited data to the array
                    editedData.push({
                        curMonth: curMonth,
                        week: week,
                        dateRange: dateRange,
                        product: productId,
                        value: editedCellValue
                    });
                } else {
                    alert("Invalid value for the selected month, week, or date range.");
                    // You can choose to revert the cell value to its previous state here
                }
            });

            // Add event listener for saving changes
            $("#saveChangesBtn").click(function() {
                // Check if any data has been edited
                if (editedData.length > 0) {
                    // Send the edited data to the PHP script using AJAX
                    $.ajax({
                        url: "../controller/commands.php",
                        method: "POST",
                        data: {
                            data: editedData
                        },
                        success: function(response) {
                            // Handle the success response
                            console.log(response);
                            alert("Data updated successfully!");
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.log(xhr.responseText);
                            alert("Error: " + xhr.responseText);
                        }
                    });
                } else {
                    alert("No changes to save.");
                }
            });
        });



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