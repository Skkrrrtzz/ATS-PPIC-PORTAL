<?php include_once 'ppic_headers.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <style>
    .dataTables_wrapper .dataTables_filter {
      margin-top: .5rem;
      margin-right: .5rem;
    }

    .dataTables_wrapper .dataTables_length {
      margin-top: .5rem;
      margin-right: .5rem;
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
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- OPEN SALES TABLE -->
          <div class="card shadow my-3">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Sales Orders
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover display compact" id="sales_orders" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <!-- <th>No.</th> -->
                      <th>Status</th>
                      <th>Internal Number</th>
                      <th>Document Number</th>
                      <th>Customer/Vendor Code</th>
                      <th>Customer/Vendor Name</th>
                      <th>Posting Date</th>
                      <th>Row Delivery Date</th>
                      <th>Item No</th>
                      <th>Item/Service Description</th>
                      <th>Customer Part No</th>
                      <th>Customer/Vendor Cat.No.</th>
                      <th>Qty</th>
                      <th>Inventory UoM</th>
                      <th>Purchasing UoM</th>
                      <th>Open Qty</th>
                      <th>WareHouse Code</th>
                      <th>Price Currency</th>
                      <th>Distribution Rule</th>
                      <th>Unit price</th>
                      <th>Orig Amt</th>
                      <th>Open Amt</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Sales Emp Name</th>
                      <th>Remarks</th>
                      <th>Pay Terms Code</th>
                      <th>Payment Terms Code</th>
                      <th>Ref Number</th>
                      <th>BP Reference No.</th>
                      <th>Customer PO No</th>
                      <th>Delivered Qty</th>
                      <th>Add'l txt</th>
                      <th>Free txt</th>
                      <th>Contact Person</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <!-- <th>No.</th> -->
                      <th>Status</th>
                      <th>Internal Number</th>
                      <th>Document Number</th>
                      <th>Customer/Vendor Code</th>
                      <th>Customer/Vendor Name</th>
                      <th>Posting Date</th>
                      <th>Row Delivery Date</th>
                      <th>Item No</th>
                      <th>Item/Service Description</th>
                      <th>Customer Part No</th>
                      <th>Customer/Vendor Cat.No.</th>
                      <th>Qty</th>
                      <th>Inventory UoM</th>
                      <th>Purchasing UoM</th>
                      <th>Open Qty</th>
                      <th>WareHouse Code</th>
                      <th>Price Currency</th>
                      <th>Distribution Rule</th>
                      <th>Unit price</th>
                      <th>Orig Amt</th>
                      <th>Open Amt</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Sales Emp Name</th>
                      <th>Remarks</th>
                      <th>Pay Terms Code</th>
                      <th>Payment Terms Code</th>
                      <th>Ref Number</th>
                      <th>BP Reference No.</th>
                      <th>Customer PO No</th>
                      <th>Delivered Qty</th>
                      <th>Add'l txt</th>
                      <th>Free txt</th>
                      <th>Contact Person</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
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
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <script>
    $(document).ready(function() {
      var table = $('#sales_orders').DataTable({
        ajax: {
          url: 'get_data.php',
          method: 'GET',
          dataSrc: ''
        },
        // dom: 'B<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
        // buttons: [{
        //   extend: 'copyHtml5',
        //   text: '<i class="fa-solid fa-copy"></i> Copy',
        //   className: 'btn btn-dark-subtle btn-sm',
        //   init: function(api, node, config) {
        //     $(node).removeClass('dt-button');
        //   }
        // }, {
        //   extend: 'excelHtml5',
        //   text: '<i class="fa-solid fa-file-excel"></i> Excel',
        //   className: 'btn btn-success btn-sm',
        //   init: function(api, node, config) {
        //     $(node).removeClass('dt-button');
        //   }
        // }, {
        //   extend: 'csvHtml5',
        //   text: '<i class="fa-solid fa-file-csv"></i> CSV',
        //   className: 'btn btn-dark btn-sm',
        //   init: function(api, node, config) {
        //     $(node).removeClass('dt-button');
        //   }
        // }, {
        //   extend: 'print',
        //   text: '<i class="fa-solid fa-print"></i> Print',
        //   className: 'btn btn-info btn-sm',
        //   init: function(api, node, config) {
        //     $(node).removeClass('dt-button');
        //   }
        // }],
        deferRender: true,
        scrollX: true,
        scrollY: '50vh',
        // language: {
        //   searchPlaceholder: 'Search here..',
        //   search: ""
        // },
        fixedColumns: true,
        order: [
          [1, 'asc']
        ],
        // columnDefs: [{
        //   targets: [''],
        //   className: "fontsize"
        // }],
        columns: [{
            data: 'ID'
          },
          {
            data: 'Docu_status',
            render: function(data, type, row) {
              if (data === 'O') {
                return '<span class="badge badge-success fw-bold">OPEN</span>';
              } else if (data === 'C') {
                return '<span class="badge badge-warning fw-bold">CLOSED</span>';
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
            data: 'Posting_date'
          },
          {
            data: 'Row_Del_date'
          },
          {
            data: 'Item_no'
          },
          {
            data: 'Item/Service_description'
          },
          {
            data: 'Customer_part_no'
          },
          {
            data: 'CV_Cat_No'
          },
          {
            data: 'Qty'
          },
          {
            data: 'Inventory_UoM'
          },
          {
            data: 'Purchasing_UoM'
          },
          {
            data: 'Open_Qty'
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
            data: 'Remarks'
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
            data: 'BP_Reference_No'
          },
          {
            data: 'Customer_PO_No'
          },
          {
            data: 'Delivered_Qty'
          },
          {
            data: 'Add\'l_txt'
          },
          {
            data: 'Free_txt'
          },
          {
            data: 'Contact_Person'
          }
        ]
      });
    });
  </script>
</body>

</html>