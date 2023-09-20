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

<body id="delPlanStatus">
    <div class="container-fluid">
        <div class="card shadow my-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">
                    Master Schedule
                </h4>
                <div>
                    <!-- Upload Button -->
                    <label for="pdfUpload" class="form-label">Upload PDF</label>
                    <input type="file" class="form-control-file d-none" id="pdfUpload" accept=".pdf">
                    <label for="pdfUpload" class="btn btn-primary btn-sm m-2" id="uploadButton">Upload</label>

                    <!-- View Button -->
                    <button type="button" class="btn btn-primary btn-sm ml-2" id="viewPdfButton">View PDF</button>
                </div>
            </div>
            <div id="message"></div>
            <div class="card-body" style="height: 600px; overflow-y: auto;">
                <div class=" table-responsive">
                    <table class=" table-bordered" style="width: 100%;">
                        <thead class="text-center text-dark sticky-top">
                            <tr>
                                <th class=" h3 fw-bold bg-blue-60" rowspan="4">Product</th>
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
                                        echo "<td contenteditable='true' class='product_no' id='product_no'></td>";
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
    <!-- Add this modal to your HTML -->
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewer" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script>
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

        document.addEventListener("input", function(event) {
            const firstProdBuildQty = document.querySelector(".prod_build_qty");
            const firstproduct_no_cell = document.querySelector("#product_no");

            if (firstProdBuildQty && firstproduct_no_cell) {
                const firstProd_Build_Qty = firstProdBuildQty.textContent;
                const firstProduct_No = firstproduct_no_cell.textContent;
                console.log("First Value:", firstProd_Build_Qty);
                console.log("First Value:", firstProduct_No);
            } else {
                console.log("No element found");
            }
            // Send the values to the server via AJAX
            fetch("../controller/get_data.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        prod_build_qty: Prod_Build_Qty,
                        product_no: Product_No,
                        solve: true,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Data sent successfully:", data);
                })
                .catch(error => {
                    console.error("Error:", error);
                });

        });



        // JavaScript to handle the modal
        document.getElementById('viewPdfButton').addEventListener('click', function() {
            // Replace 'pdf_url.pdf' with the actual URL of the PDF you want to display
            var pdfUrl = '/ATS/ATSPPIC_PORTAL/files_data/pdf/try_convert_pdf.pdf';
            document.getElementById('pdfViewer').src = pdfUrl;
            $('#pdfModal').modal('show');
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
        });
    </script>
</body>

</html>