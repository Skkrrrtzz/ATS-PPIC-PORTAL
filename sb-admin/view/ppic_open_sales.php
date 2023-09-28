<?php require_once 'ppic_nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="../vendor/datatables/buttons.dataTables.min.css" rel="stylesheet">
  <style>
    .dataTables_wrapper .dataTables_filter {
      margin-top: .5rem;
      margin-right: .5rem;
    }

    .dataTables_wrapper .dataTables_length {
      margin-top: .5rem;
      margin-right: .5rem;
    }

    .dataTables_wrapper .dataTables_wrapper dt-bootstrap4 {
      margin-top: .5rem;
      margin-right: .5rem;
    }

    .dataTables_wrapper .dt-buttons {
      color: #6c757d;
    }

    table.dataTable th {
      font-size: 14px;
    }

    table.dataTable td {
      font-size: 12px;
    }
  </style>
</head>

<body id="openSales">
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- OPEN SALES TABLE -->
    <div class="card shadow my-2">
      <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
          Sales Orders
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="m-1">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#uploadModal"><i class="fas fa-upload"></i> Upload Excel</button>
          </div>
          <table class="table table-bordered table-hover text-nowrap" width="100%" cellspacing="0" id="sales_orders">
            <thead class="bg-gray-300 text-dark">
              <tr>
                <th>ID</th>
                <th>BP Reference No.</th>
                <th>Posting Date</th>
                <th>Row Delivery Date</th>
                <th>Customer Part No</th>
                <th>Item/Service Description</th>
                <th>Qty</th>
                <th>Open Qty</th>
                <th>Remarks</th>
                <!-- <th>No.</th> -->
                <th>Status</th>
                <th>Internal Number</th>
                <th>Document Number</th>
                <th>Customer/Vendor Code</th>
                <th>Customer/Vendor Name</th>
                <th>Item No</th>
                <th>Customer/Vendor Cat.No.</th>
                <th>Inventory UoM</th>
                <th>Purchasing UoM</th>
                <th>WareHouse Code</th>
                <th>Price Currency</th>
                <th>Distribution Rule</th>
                <th>Unit price</th>
                <th>Orig Amt</th>
                <th>Open Amt</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Sales Emp Name</th>
                <th>Pay Terms Code</th>
                <th>Payment Terms Code</th>
                <th>Ref Number</th>
                <th>Customer PO No</th>
                <th>Delivered Qty</th>
                <th>Add'l txt</th>
                <th>Free txt</th>
                <th>Contact Person</th>
              </tr>
            </thead>
            <tfoot class="bg-gray-300 text-dark">
              <tr>
                <th>ID</th>
                <th>BP Reference No.</th>
                <th>Posting Date</th>
                <th>Row Delivery Date</th>
                <th>Customer Part No</th>
                <th>Item/Service Description</th>
                <th>Qty</th>
                <th>Open Qty</th>
                <th>Remarks</th>
                <!-- <th>No.</th> -->
                <th>Status</th>
                <th>Internal Number</th>
                <th>Document Number</th>
                <th>Customer/Vendor Code</th>
                <th>Customer/Vendor Name</th>
                <th>Item No</th>
                <th>Customer/Vendor Cat.No.</th>
                <th>Inventory UoM</th>
                <th>Purchasing UoM</th>
                <th>WareHouse Code</th>
                <th>Price Currency</th>
                <th>Distribution Rule</th>
                <th>Unit price</th>
                <th>Orig Amt</th>
                <th>Open Amt</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Sales Emp Name</th>
                <th>Pay Terms Code</th>
                <th>Payment Terms Code</th>
                <th>Ref Number</th>
                <th>Customer PO No</th>
                <th>Delivered Qty</th>
                <th>Add'l txt</th>
                <th>Free txt</th>
                <th>Contact Person</th>
              </tr>
            </tfoot>
            <tbody class=" border border-dark">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- End of Main Content -->
  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <!-- <span>Copyright &copy; Your Website 2020</span> -->
      </div>
    </div>
  </footer>
  <!-- End of Footer -->
  <!-- Modal for uploading Excel file -->
  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel">Upload Excel File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form for uploading Excel file -->
          <form id="excelUploadForm" enctype="multipart/form-data">
            <div class="form-group" id="fileInputGroup">
              <label for="excelFile">Only accept these file types: xlsx, xls, csv.</br> And correct format of excel.</label>
              <input type="file" class="form-control-file" id="excelFile" name="excelFile" accept=".xlsx, .xls, .csv">
            </div>
          </form>
          <!-- Loading spinner -->
          <div id="loadingSpinner" class="d-none text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <p>Uploading file...</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" form="excelUploadForm" id="uploadButton" class="btn btn-success">Upload</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="../vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="../vendor/datatables/buttons.colVis.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  <script src="../js/sweetalert2.all.min.js"></script>

  <script>
    $(document).ready(function() {
      var defaultVisibleColumns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
      var table = $('#sales_orders').DataTable({
        ajax: {
          url: '../controller/get_data.php',
          method: 'GET',
          dataSrc: ''
        },
        dom: '<"row m-1"<"col-sm-8"Bl><"col-sm-4"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
        buttons: [{
          extend: 'copyHtml5',
          text: '<i class="fas fa-copy"></i> Copy',
          exportOptions: {
            columns: ':visible' // Export only visible columns
          }
        }, {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel"></i> Excel',
          exportOptions: {
            columns: ':visible' // Export only visible columns
          }
        }, {
          extend: 'csvHtml5',
          text: '<i class="fas fa-file-csv"></i> CSV',
          exportOptions: {
            columns: ':visible' // Export only visible columns
          }
        }, {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> PDF',
          orientation: 'landscape',
          pageSize: 'LEGAL',
          exportOptions: {
            columns: ':visible' // Export only visible columns
          }
        }, {
          extend: 'colvis',
          text: '<i class="fas fa-filter text"></i> Hide columns',
          collectionLayout: 'fixed columns',
          collectionTitle: 'Column visibility control',
        }],
        deferRender: true,
        scrollX: true,
        scrollY: '50vh',
        fixedColumns: true,
        columnDefs: [{
            targets: defaultVisibleColumns,
            visible: true // Set the default columns to be visible
          },
          {
            targets: '_all', // Target all columns
            visible: false // Hide all other columns by default
          }
        ],
        order: [
          [1, 'asc']
        ],
        columns: [{
            data: 'ID'
          },
          {
            data: 'BP_Reference_No'
          },
          {
            data: 'Posting_date'
          },
          {
            data: 'Row_Del_date',
          },
          {
            data: 'Customer_part_no'
          },
          {
            data: 'Item_Service_description'
          },
          {
            data: 'Qty'
          },
          {
            data: 'Open_Qty'
          },
          {
            data: 'Remarks'
          },
          {
            data: 'Docu_status',
            render: function(data, type, row) {
              if (data === 'O') {
                if (row.Row_Del_date) {
                  var deliveryDate = new Date(row.Row_Del_date);
                  var currentDate = new Date();

                  if (deliveryDate < currentDate && data === 'O') {
                    // If the delivery date is in the past, display both "OPEN" and "DELAYED" badges
                    return '<span class="badge badge-warning fw-bold">OPEN</span> ' +
                      '<span class="badge badge-danger fw-bold">DELAYED</span>';
                  }
                }
                return '<span class="badge badge-warning fw-bold">OPEN</span>';
              } else if (data === 'C') {
                return '<span class="badge badge-success fw-bold">CLOSED</span>';
              } else {
                return data;
              }
            }
          },
          {
            data: 'Int_number'
          },
          {
            data: 'Docu_number'
          },
          {
            data: 'CV_code'
          },
          {
            data: 'CV_name'
          },
          {
            data: 'Item_no'
          },
          {
            data: 'CV_Cat_No'
          },
          {
            data: 'Inventory_UoM'
          },
          {
            data: 'Purchasing_UoM'
          },
          {
            data: 'WH_Code'
          },
          {
            data: 'Price_Currency'
          },
          {
            data: 'Distribution_rule'
          },
          {
            data: 'Unit_price'
          },
          {
            data: 'Orig_Amt'
          },
          {
            data: 'Open_Amt'
          },
          {
            data: 'First_Name',
            render: function(data, type, row) {
              return '<span style="font-weight: bold;">' + data + '</span>';
            }
          },
          {
            data: 'Last_Name',
            render: function(data, type, row) {
              return '<span style="font-weight: bold;">' + data + '</span>';
            }
          },
          {
            data: 'Sales_Emp_name'
          },
          {
            data: 'Pay_Terms_Code'
          },
          {
            data: 'Payment_Terms_Code'
          },
          {
            data: 'Ref_Number'
          },
          {
            data: 'Customer_PO_No'
          },
          {
            data: 'Delivered_Qty'
          },
          {
            data: 'Addl_txt'
          },
          {
            data: 'Free_txt'
          },
          {
            data: 'Contact_Person'
          }
        ]
      });
      $("#excelUploadForm").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Disable the upload button
        $("#uploadButton").prop("disabled", true);

        // Check if a file has been selected
        var fileInput = document.getElementById("excelFile");
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
          // Show an error message for no file selected
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select a file to upload.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000 // 3 seconds
          });

          // Enable the upload button
          $("#uploadButton").prop("disabled", false);

          return; // Exit the function
        }

        // Hide the file input and show the loading spinner
        $("#fileInputGroup").css("display", "none");
        $("#loadingSpinner").removeClass("d-none");

        var formData = new FormData(this);

        $.ajax({
          url: "../controller/upload_excel.php",
          type: "POST",
          data: formData,
          dataType: "json",
          contentType: false,
          processData: false,
          success: function(response) {
            // console.log(response);
            // Hide the loading spinner and show the file input again
            $("#loadingSpinner").addClass("d-none");
            $("#fileInputGroup").css("display", "block");

            if (response.icon === "success") {
              // File upload was successful, show a success toast
              Swal.fire({
                icon: response.icon,
                title: 'Success',
                text: response.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000 // 3 seconds
              });
              // Clear the file input field
              $("#excelFile").val(""); // Reset the file input
              // Close the modal
              $('#uploadModal').modal('hide');
              table.ajax.reload(); // Log the rowData
            } else {
              // File upload failed, show an error toast
              Swal.fire({
                icon: response.icon,
                title: 'Warning!',
                text: response.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000 // 3 seconds
              });
            }

            // Enable the upload button
            $("#uploadButton").prop("disabled", false);
          },
          error: function(xhr, status, error) {
            // Hide the loading spinner and show the file input again
            $("#loadingSpinner").addClass("d-none");
            $("#fileInputGroup").css("display", "block");
            // File upload failed, show an error toast
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Cannot read the excel file!',
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 5000
            });
            // Enable the upload button
            $("#uploadButton").prop("disabled", false);
          }
        });
      });
    });
  </script>
</body>

</html>