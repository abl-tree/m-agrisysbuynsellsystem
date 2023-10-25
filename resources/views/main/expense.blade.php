@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
<div class="container-fluid">
     <ul class="nav nav-tabs">
        <li class="active"><a href="#expense_tab" data-toggle="tab"><div class="block-header">
            <h2>Expense Dashboard</h2>
        </div></a></li>
        <li><a href="#trip_expense_tab" data-toggle="tab" id="render"><div class="block-header">
            <h2>Trip Expenses Dashboard</h2>
        </div></a></li>
        <li><a href="#od_expense_tab" data-toggle="tab" id="render"><div class="block-header">
            <h2>Outbound Expenses Dashboard</h2>
        </div></a></li>
      </ul>
</div> 

<div class="tab-content">
    <div id="expense_tab" class="tab-pane fade in active">
    <div class="modal fade" id="expense_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2 class="modal_title">Add Expense</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button id="print_expense" type="button" class="btn btn-sm btn-icon print-icon" title="PRINT AND SAVE" ><i class="glyphicon glyphicon-print"></i></button> 
                            </li>
                            <li class="dropdown">
                                <!-- <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_expense') }}">
                                <input type="hidden" id="expense_clone" name="expense_clone">
                                <input type="hidden" id="type_clone" name="type_clone">
                                <input type="hidden" id="amount_clone" name="amount_clone">
                                <input type="hidden" id="trans_clone" name="trans_clone">
                                <button class="btn btn-sm btn-icon print-icon" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                </form> -->
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="#" class="form-horizontal " id="expense_form">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="button_action" id="button_action" value="">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="expense">Transaction Number</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="trans_number" name="trans_number" class="form-control" readonly="readonly"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>      
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="expense">Name</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="expense" name="expense" class="form-control" placeholder="Enter your expense description"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="type">Type</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="type" name="type" class="form-control" placeholder="Enter type of expense"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="amount">Amount</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="row clearfix">
                            <div class="modal-footer">
                                <div class="print-only">
                                <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_expense') }}">
                                    <input type="hidden" id="expense_clone" name="expense_clone">
                                    <input type="hidden" id="type_clone" name="type_clone">
                                    <input type="hidden" id="amount_clone" name="amount_clone">
                                    <input type="hidden" id="trans_clone" name="trans_clone">
                                    <button class="btn btn-sm btn-icon print-icon" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                </form>
                                </div>
                                <button type="button" id="add_expense" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>List of expenses as of {{ date('Y-m-d ') }}</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            @if(canAddExpense())
                            <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20" data-toggle="modal" data-target="#expense_modal"><i class="material-icons">library_add</i></button>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <p id="date_filter">
                            <h5>Date Range Filter</h5>
                            <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
                            <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text" id="datepicker_to" />
                        </p>
                        <br>
                        <table id ="expensetable" class="table table-bordered table-striped table-hover  ">
                            <thead>
                                <tr>
                                    <th  width="100" style="text-align:center;">Expense Number</th>
                                    <th  width="100" style="text-align:center;">Name</th>
                                    <th  width="100" style="text-align:center;">Type</th>
                                    <th  width="100" style="text-align:center;">Amount</th>
                                    <th  width="100" style="text-align:center;">Status</th>
                                    <th  width="100" style="text-align:center;">Date</th>
                                    <th  width="100" style="text-align:center;">Released By</th>
                                    <th  width="100" style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="trip_expense_tab" class="tab-pane fade">
     <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>List of Trip Expenses as of {{ date('Y-m-d ') }}</h2>

                </div>
                <div class="body">
                    <div class="table-responsive">
                         <p id="trip_expense_date_filter">
                            <h5>Date Range Filter</h5>
                            <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="trip_expense_datepicker_from" />
                            <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text" id="trip_expense_datepicker_to" />
                        </p>
                        <br>
                        <table id="trip_expensetable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th  width="100" style="text-align:center;">Trip ID</th>
                                    <th  width="100" style="text-align:center;">Destination</th>
                                    <th  width="100" style="text-align:center;">Type</th>
                                    <th  width="100" style="text-align:center;">Amount</th>
                                    <th  width="100" style="text-align:center;">Status</th>
                                    <th  width="100" style="text-align:center;">Date</th>
                                    <th  width="100" style="text-align:center;">Released By</th>
                                    <th  width="100" style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="od_expense_tab" class="tab-pane fade">
     <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>List of OD Expenses as of {{ date('Y-m-d ') }}</h2>

                </div>
                <div class="body">
                    <div class="table-responsive">
                         <p id="trip_expense_date_filter">
                            <h5>Date Range Filter</h5>
                            <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="od_expense_datepicker_from" />
                            <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text" id="od_expense_datepicker_to" />
                        </p>
                        <br>
                        <table id="od_expensetable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th  width="100" style="text-align:center;">Outbound ID</th>
                                    <th  width="100" style="text-align:center;">Destination</th>
                                    <th  width="100" style="text-align:center;">Type</th>
                                    <th  width="100" style="text-align:center;">Amount</th>
                                    <th  width="100" style="text-align:center;">Status</th>
                                    <th  width="100" style="text-align:center;">Date</th>
                                    <th  width="100" style="text-align:center;">Released By</th>
                                    <th  width="100" style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
 <div class="modal fade" id="release_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Are You Sure?</h2>
                    </div>
                    <div class="body">
                        <form action="#" class="form-horizontal " id="release_form">


                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <button type="button" id="release_money" class="btn btn-success waves-effect">CONTINUE</button>
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="release_modal_od" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Are You Sure?</h2>
                    </div>
                    <div class="body">
                        <form action="#" class="form-horizontal " id="release_form">


                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <button type="button" id="release_money_od" class="btn btn-success waves-effect">CONTINUE</button>
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="release_modal_normal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Are You Sure?</h2>
                    </div>
                    <div class="body">
                        <form action="#" class="form-horizontal " id="release">


                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <button type="button" id="release_money_normal" class="btn btn-success waves-effect">CONTINUE</button>
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- #END# Exportable Table -->
@endsection

@section('script')
<script>
 var id;
var expensetable;
var date_from;
var date_to;
var date_from_trip;
var date_to_trip;
var date_from_od;
var date_to_od;
var trip_expensetable;
var od_expensetable;
var type;

document.title = "{{ env('APP_NAME') }} - Expenses";

$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});

$(document).ready(function() {
  $(".nav-tabs a").click(function() {
    $(this).tab("show");
  });

  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });

  //EXPENSE Datatable starts here
  $("#expense_modal").on("hidden.bs.modal", function(e) {
    $(this)
      .find("input,textarea,select")
      .val("")
      .end()
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
  });

  function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = typeof thousands_sep == "undefined" ? "," : thousands_sep,
      dec = typeof dec_point == "undefined" ? "." : dec_point,
      s = "",
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return "" + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
      s[1] = s[1] || "";
      s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
  }

  expensetable = $("#expensetable").DataTable({
    footerCallback: function(row, data, start, end, display) {
      var api = this.api(),
        data;

      // Remove the formatting to get integer data for summation
      var intVal = function(i) {
        return typeof i == "string"
          ? i.replace(/[\₱,]/g, "") * 1
          : typeof i == "number"
          ? i
          : 0;
      };

      // Total over all pages
      total = api
        .column(2)
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(3, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(3).footer()).html(
        "Total: <br>₱" + number_format(pageTotal, 2)
      );
    },
    dom: "Blfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    buttons: [
      {
        extend: "print",
        text: "PRINT",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
          modifier: {
            page: "current"
          }
        },
        customize: function(win) {
          $(win.document.body).css("font-size", "10pt");

          $(win.document.body)
            .find("table")
            .addClass("compact")
            .css("font-size", "inherit");
        },
        footer: true
      },
      {
        extend: "pdfHtml5",
        footer: true,
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
          modifier: {
            page: "current"
          }
        },
        customize: function(doc) {
          doc.styles.tableHeader.fontSize = 8;
          doc.styles.tableFooter.fontSize = 8;
          doc.defaultStyle.fontSize = 8;
          doc.content[1].table.widths = Array(
            doc.content[1].table.body[0].length + 1
          )
            .join("*")
            .split("");
        }
      }
    ],
    paging: true,
    pageLength: 10,
    order: [],
    columnDefs: [
      {
        targets: "_all", // your case first column
        className: "text-center"
      }
    ],
    ajax: {
      url: "{{ route('refresh_expense') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        date_from: date_from,
        date_to: date_to
      }
    },
    processing: true,
    columns: [
      { data: "trans_number" },
      { data: "description" },
      { data: "type" },
      { data: "amount" },
      { data: "status" },
      { data: "created_at" },
      { data: "released_by" },
      { data: "action", orderable: false, searchable: false }
    ]
  });

  $("#datepicker_from")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        minDateFilter = new Date(date).getTime();
        var df = new Date(date);
        date_from =
          df.getFullYear() + "-" + (df.getMonth() + 1) + "-" + df.getDate();
        $("#expensetable")
          .dataTable()
          .fnDestroy();
        expensetable = $("#expensetable").DataTable({
          footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
              data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
              return typeof i == "string"
                ? i.replace(/[\₱,]/g, "") * 1
                : typeof i == "number"
                ? i
                : 0;
            };

            // Total over all pages
            total = api
              .column(2)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(3, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(3).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );
          },
          dom: "Blfrtip",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          buttons: [
            {
              extend: "print",
              text: "PRINT",
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "10pt");

                $(win.document.body)
                  .find("table")
                  .addClass("compact")
                  .css("font-size", "inherit");
              },
              footer: true
            },
            {
              extend: "pdfHtml5",
              footer: true,
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
                doc.content[1].table.widths = Array(
                  doc.content[1].table.body[0].length + 1
                )
                  .join("*")
                  .split("");
              }
            }
          ],
          paging: true,
          pageLength: 10,
          order: [],
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          ajax: {
            url: "{{ route('refresh_expense') }}",
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: date_from,
              date_to: date_to
            }
          },
          processing: true,
          serverSide: true,
          columns: [
            { data: "trans_number" },
            { data: "description" },
            { data: "type" },
            { data: "amount" },
            { data: "status" },
            { data: "created_at" },
            { data: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      date_from = "";
      $("#expensetable")
        .dataTable()
        .fnDestroy();
      expensetable = $("#expensetable").DataTable({
        footerCallback: function(row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i == "string"
              ? i.replace(/[\₱,]/g, "") * 1
              : typeof i == "number"
              ? i
              : 0;
          };

          // Total over all pages
          total = api
            .column(2)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(3, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(3).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );
        },
        dom: "Blfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        buttons: [
          {
            extend: "print",
            text: "PRINT",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "10pt");

              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("font-size", "inherit");
            },
            footer: true
          },
          {
            extend: "pdfHtml5",
            footer: true,
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
              doc.content[1].table.widths = Array(
                doc.content[1].table.body[0].length + 1
              )
                .join("*")
                .split("");
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('refresh_expense') }}",
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: date_from,
            date_to: date_to
          }
        },
        processing: true,
        serverSide: true,
        columns: [
          { data: "trans_number" },
          { data: "description" },
          { data: "type" },
          { data: "amount" },
          { data: "status" },
          { data: "created_at" },
          { data: "released_by" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $("#datepicker_to")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        maxDateFilter = new Date(date).getTime();
        //oTable.fnDraw();
        var dt = new Date(date);
        date_to =
          dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
        $("#expensetable")
          .dataTable()
          .fnDestroy();
        expensetable = $("#expensetable").DataTable({
          footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
              data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
              return typeof i == "string"
                ? i.replace(/[\₱,]/g, "") * 1
                : typeof i == "number"
                ? i
                : 0;
            };

            // Total over all pages
            total = api
              .column(2)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(3, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(3).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );
          },
          dom: "Blfrtip",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          buttons: [
            {
              extend: "print",
              text: "PRINT",
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "10pt");

                $(win.document.body)
                  .find("table")
                  .addClass("compact")
                  .css("font-size", "inherit");
              },
              footer: true
            },
            {
              extend: "pdfHtml5",
              footer: true,
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
                doc.content[1].table.widths = Array(
                  doc.content[1].table.body[0].length + 1
                )
                  .join("*")
                  .split("");
              }
            }
          ],
          paging: true,
          pageLength: 10,
          order: [],
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          ajax: {
            url: "{{ route('refresh_expense') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: date_from,
              date_to: date_to
            }
          },
          processing: true,
          serverSide: true,
          columns: [
            { data: "trans_number" },
            { data: "description" },
            { data: "type" },
            { data: "amount" },
            { data: "status" },
            { data: "created_at" },
            { data: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      date_to = "";
      $("#expensetable")
        .dataTable()
        .fnDestroy();
      expensetable = $("#expensetable").DataTable({
        footerCallback: function(row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i == "string"
              ? i.replace(/[\₱,]/g, "") * 1
              : typeof i == "number"
              ? i
              : 0;
          };

          // Total over all pages
          total = api
            .column(2)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(3, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(3).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );
        },
        dom: "Blfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        buttons: [
          {
            extend: "print",
            text: "PRINT",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "10pt");

              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("font-size", "inherit");
            },
            footer: true
          },
          {
            extend: "pdfHtml5",
            footer: true,
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
              doc.content[1].table.widths = Array(
                doc.content[1].table.body[0].length + 1
              )
                .join("*")
                .split("");
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('refresh_expense') }}",
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: date_from,
            date_to: date_to
          }
        },
        processing: true,
        serverSide: true,
        columns: [
          { data: "trans_number" },
          { data: "description" },
          { data: "type" },
          { data: "amount" },
          { data: "status" },
          { data: "created_at" },
          { data: "released_by" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  //TRIP EXPENSE TABLE
  trip_expensetable = $("#trip_expensetable").DataTable({
    footerCallback: function(row, data, start, end, display) {
      var api = this.api(),
        data;

      // Remove the formatting to get integer data for summation
      var intVal = function(i) {
        return typeof i == "string"
          ? i.replace(/[\₱,]/g, "") * 1
          : typeof i == "number"
          ? i
          : 0;
      };

      // Total over all pages
      total = api
        .column(3)
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(3, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(3).footer()).html(
        "Total: <br>₱" + number_format(pageTotal, 2)
      );
    },
    createdRow: function(row, data, dataIndex) {
      $(row)
        .find("td:eq(5)")
        .attr("data-order", data.created_at);
    },
    dom: "Blfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],

    buttons: [
      {
        extend: "print",
        text: "PRINT",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
          modifier: {
            page: "current"
          }
        },
        customize: function(win) {
          $(win.document.body).css("font-size", "10pt");

          $(win.document.body)
            .find("table")
            .addClass("compact")
            .css("font-size", "inherit");
        },
        footer: true
      },
      {
        extend: "pdfHtml5",
        footer: true,
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
          modifier: {
            page: "current"
          }
        },
        customize: function(doc) {
          doc.styles.tableHeader.fontSize = 8;
          doc.styles.tableFooter.fontSize = 8;
          doc.defaultStyle.fontSize = 8;
          doc.content[1].table.widths = Array(
            doc.content[1].table.body[0].length + 1
          )
            .join("*")
            .split("");
        }
      }
    ],
    paging: true,
    pageLength: 10,
    order: [],
    columnDefs: [
      {
        targets: "_all", // your case first column
        className: "text-center"
      }
    ],
    ajax: {
      url: "{{ route('trip_expense_view') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        date_from: date_from_trip,
        date_to: date_to_trip
      }
    },
    processing: true,
    serverSide: true,
    columns: [
      { data: "trip_id" },
      { data: "description" },
      { data: "type" },
      { data: "amount" },
      { data: "status" },
      { data: "created_at" },
      { data: "released_by" },
      { data: "action", orderable: false, searchable: false }
    ]
  });

  $("#trip_expense_datepicker_from")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        minDateFilter = new Date(date).getTime();
        var df = new Date(date);
        date_from_trip =
          df.getFullYear() + "-" + (df.getMonth() + 1) + "-" + df.getDate();
        $("#trip_expensetable")
          .dataTable()
          .fnDestroy();
        trip_expensetable = $("#trip_expensetable").DataTable({
          footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
              data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
              return typeof i == "string"
                ? i.replace(/[\₱,]/g, "") * 1
                : typeof i == "number"
                ? i
                : 0;
            };

            // Total over all pages
            total = api
              .column(3)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(3, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(3).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );
          },
          createdRow: function(row, data, dataIndex) {
            $(row)
              .find("td:eq(5)")
              .attr("data-order", data.created_at);
          },
          dom: "Blfrtip",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          buttons: [
            {
              extend: "print",
              text: "PRINT",
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "10pt");

                $(win.document.body)
                  .find("table")
                  .addClass("compact")
                  .css("font-size", "inherit");
              },
              footer: true
            },
            {
              extend: "pdfHtml5",
              footer: true,
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
                doc.content[1].table.widths = Array(
                  doc.content[1].table.body[0].length + 1
                )
                  .join("*")
                  .split("");
              }
            }
          ],
          paging: true,
          pageLength: 10,
          order: [],
          ajax: {
            url: "{{ route('trip_expense_view') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: date_from_trip,
              date_to: date_to_trip
            }
          },
          processing: true,
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          serverSide: true,
          columns: [
            { data: "trip_id" },
            { data: "description" },
            { data: "type" },
            { data: "amount" },
            { data: "status" },
            { data: "created_at" },
            { data: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      date_from = "";
      $("#trip_expensetable")
        .dataTable()
        .fnDestroy();
      trip_expensetable = $("#trip_expensetable").DataTable({
        footerCallback: function(row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i == "string"
              ? i.replace(/[\₱,]/g, "") * 1
              : typeof i == "number"
              ? i
              : 0;
          };

          // Total over all pages
          total = api
            .column(2)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(3, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(3).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );
        },
        createdRow: function(row, data, dataIndex) {
          $(row)
            .find("td:eq(5)")
            .attr("data-order", data.created_at);
        },
        dom: "Blfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        buttons: [
          {
            extend: "print",
            text: "PRINT",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "10pt");

              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("font-size", "inherit");
            },
            footer: true
          },
          {
            extend: "pdfHtml5",
            footer: true,
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
              doc.content[1].table.widths = Array(
                doc.content[1].table.body[0].length + 1
              )
                .join("*")
                .split("");
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('trip_expense_view') }}",
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: date_from_trip,
            date_to: date_to_trip
          }
        },
        processing: true,
        serverSide: true,
        columns: [
          { data: "trip_id" },
          { data: "description" },
          { data: "type" },
          { data: "amount" },
          { data: "status" },
          { data: "created_at" },
          { data: "released_by" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $("#trip_expense_datepicker_to")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        maxDateFilter = new Date(date).getTime();
        var dt = new Date(date);
        date_to_trip =
          dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
        $("#trip_expensetable")
          .dataTable()
          .fnDestroy();
        trip_expensetable = $("#trip_expensetable").DataTable({
          footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
              data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
              return typeof i == "string"
                ? i.replace(/[\₱,]/g, "") * 1
                : typeof i == "number"
                ? i
                : 0;
            };

            // Total over all pages
            total = api
              .column(3)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(3, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(3).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );
          },
          createdRow: function(row, data, dataIndex) {
            $(row)
              .find("td:eq(5)")
              .attr("data-order", data.created_at);
          },
          dom: "Blfrtip",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          buttons: [
            {
              extend: "print",
              text: "PRINT",
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "10pt");

                $(win.document.body)
                  .find("table")
                  .addClass("compact")
                  .css("font-size", "inherit");
              },
              footer: true
            },
            {
              extend: "pdfHtml5",
              footer: true,
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
                doc.content[1].table.widths = Array(
                  doc.content[1].table.body[0].length + 1
                )
                  .join("*")
                  .split("");
              }
            }
          ],
          paging: true,
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          pageLength: 10,
          order: [],
          ajax: {
            url: "{{ route('trip_expense_view') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: date_from_trip,
              date_to: date_to_trip
            }
          },
          processing: true,
          serverSide: true,
          columns: [
            { data: "trip_id" },
            { data: "description" },
            { data: "type" },
            { data: "amount" },
            { data: "status" },
            { data: "created_at" },
            { data: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      date_to = "";
      $("#trip_expensetable")
        .dataTable()
        .fnDestroy();
      trip_expensetable = $("#trip_expensetable").DataTable({
        footerCallback: function(row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i == "string"
              ? i.replace(/[\₱,]/g, "") * 1
              : typeof i == "number"
              ? i
              : 0;
          };

          // Total over all pages
          total = api
            .column(2)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(3, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(3).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );
        },
        createdRow: function(row, data, dataIndex) {
          $(row)
            .find("td:eq(5)")
            .attr("data-order", data.created_at);
        },
        dom: "Blfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        buttons: [
          {
            extend: "print",
            text: "PRINT",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "10pt");

              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("font-size", "inherit");
            },
            footer: true
          },
          {
            extend: "pdfHtml5",
            footer: true,
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
              doc.content[1].table.widths = Array(
                doc.content[1].table.body[0].length + 1
              )
                .join("*")
                .split("");
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('trip_expense_view') }}",
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: date_from_trip,
            date_to: date_to_trip
          }
        },
        processing: true,
        serverSide: true,
        columns: [
          { data: "trip_id" },
          { data: "description" },
          { data: "type" },
          { data: "amount" },
          { data: "status" },
          { data: "created_at" },
          { data: "released_by" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
    $($.fn.dataTable.tables(true)).css("width", "100%");
    $($.fn.dataTable.tables(true))
      .DataTable()
      .columns.adjust()
      .draw();
  });
  //-----------------------------------             //END OF TRIP EXPENSE

  //-----------------------STart of OD Expense

  od_expensetable = $("#od_expensetable").DataTable({
    footerCallback: function(row, data, start, end, display) {
      var api = this.api(),
        data;

      // Remove the formatting to get integer data for summation
      var intVal = function(i) {
        return typeof i == "string"
          ? i.replace(/[\₱,]/g, "") * 1
          : typeof i == "number"
          ? i
          : 0;
      };

      // Total over all pages
      total = api
        .column(3)
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(3, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(3).footer()).html(
        "Total: <br>₱" + number_format(pageTotal, 2)
      );
    },
    dom: "Blfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    buttons: [
      {
        extend: "print",
        text: "PRINT",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
          modifier: {
            page: "current"
          }
        },
        customize: function(win) {
          $(win.document.body).css("font-size", "10pt");

          $(win.document.body)
            .find("table")
            .addClass("compact")
            .css("font-size", "inherit");
        },
        footer: true
      },
      {
        extend: "pdfHtml5",
        footer: true,
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
          modifier: {
            page: "current"
          }
        },
        customize: function(doc) {
          doc.styles.tableHeader.fontSize = 8;
          doc.styles.tableFooter.fontSize = 8;
          doc.defaultStyle.fontSize = 8;
          doc.content[1].table.widths = Array(
            doc.content[1].table.body[0].length + 1
          )
            .join("*")
            .split("");
        }
      }
    ],
    paging: true,
    pageLength: 10,
    order: [],
    columnDefs: [
      {
        targets: "_all", // your case first column
        className: "text-center"
      }
    ],
    ajax: {
      url: "{{ route('od_expense_view') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        date_from: date_from_od,
        date_to: date_to_od
      }
    },
    processing: true,
    serverSide: true,
    columns: [
      { data: "od_id" },
      { data: "description" },
      { data: "type" },
      { data: "amount" },
      { data: "status" },
      { data: "created_at" },
      { data: "released_by" },
      { data: "action", orderable: false, searchable: false }
    ]
  });

  $("#od_expense_datepicker_from")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        minDateFilter = new Date(date).getTime();
        var df = new Date(date);
        date_from_od =
          df.getFullYear() + "-" + (df.getMonth() + 1) + "-" + df.getDate();
        $("#od_expensetable")
          .dataTable()
          .fnDestroy();
        od_expensetable = $("#od_expensetable").DataTable({
          footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
              data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
              return typeof i == "string"
                ? i.replace(/[\₱,]/g, "") * 1
                : typeof i == "number"
                ? i
                : 0;
            };

            // Total over all pages
            total = api
              .column(3)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(3, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(3).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );
          },
          dom: "Blfrtip",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          buttons: [
            {
              extend: "print",
              text: "PRINT",
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "10pt");

                $(win.document.body)
                  .find("table")
                  .addClass("compact")
                  .css("font-size", "inherit");
              },
              footer: true
            },
            {
              extend: "pdfHtml5",
              footer: true,
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
                doc.content[1].table.widths = Array(
                  doc.content[1].table.body[0].length + 1
                )
                  .join("*")
                  .split("");
              }
            }
          ],
          paging: true,
          pageLength: 10,
          order: [],
          ajax: {
            url: "{{ route('od_expense_view') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: date_from_od,
              date_to: date_to_od
            }
          },
          processing: true,
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          serverSide: true,
          columns: [
            { data: "od_id" },
            { data: "description" },
            { data: "type" },
            { data: "amount" },
            { data: "status" },
            { data: "created_at" },
            { data: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      date_from = "";
      $("#od_expensetable")
        .dataTable()
        .fnDestroy();
      od_expensetable = $("#od_expensetable").DataTable({
        footerCallback: function(row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i == "string"
              ? i.replace(/[\₱,]/g, "") * 1
              : typeof i == "number"
              ? i
              : 0;
          };

          // Total over all pages
          total = api
            .column(2)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(3, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(3).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );
        },
        dom: "Blfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        buttons: [
          {
            extend: "print",
            text: "PRINT",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "10pt");

              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("font-size", "inherit");
            },
            footer: true
          },
          {
            extend: "pdfHtml5",
            footer: true,
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
              doc.content[1].table.widths = Array(
                doc.content[1].table.body[0].length + 1
              )
                .join("*")
                .split("");
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('od_expense_view') }}",
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: date_from_od,
            date_to: date_to_od
          }
        },
        processing: true,
        serverSide: true,
        columns: [
          { data: "od_id" },
          { data: "description" },
          { data: "type" },
          { data: "amount" },
          { data: "status" },
          { data: "created_at" },
          { data: "released_by" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $("#od_expense_datepicker_to")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        maxDateFilter = new Date(date).getTime();
        var dt = new Date(date);
        date_to_od =
          dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
        $("#od_expensetable")
          .dataTable()
          .fnDestroy();
        od_expensetable = $("#od_expensetable").DataTable({
          footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
              data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
              return typeof i == "string"
                ? i.replace(/[\₱,]/g, "") * 1
                : typeof i == "number"
                ? i
                : 0;
            };

            // Total over all pages
            total = api
              .column(3)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(3, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(3).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );
          },
          dom: "Blfrtip",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          buttons: [
            {
              extend: "print",
              text: "PRINT",
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "10pt");

                $(win.document.body)
                  .find("table")
                  .addClass("compact")
                  .css("font-size", "inherit");
              },
              footer: true
            },
            {
              extend: "pdfHtml5",
              footer: true,
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
                doc.content[1].table.widths = Array(
                  doc.content[1].table.body[0].length + 1
                )
                  .join("*")
                  .split("");
              }
            }
          ],
          paging: true,
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          pageLength: 10,
          order: [],
          ajax: {
            url: "{{ route('od_expense_view') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: date_from_od,
              date_to: date_to_od
            }
          },
          processing: true,
          serverSide: true,
          columns: [
            { data: "od_id" },
            { data: "description" },
            { data: "type" },
            { data: "amount" },
            { data: "status" },
            { data: "created_at" },
            { data: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      date_to = "";
      $("#od_expensetable")
        .dataTable()
        .fnDestroy();
      od_expensetable = $("#od_expensetable").DataTable({
        footerCallback: function(row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i == "string"
              ? i.replace(/[\₱,]/g, "") * 1
              : typeof i == "number"
              ? i
              : 0;
          };

          // Total over all pages
          total = api
            .column(2)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(3, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(3).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );
        },
        dom: "Blfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        buttons: [
          {
            extend: "print",
            text: "PRINT",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "10pt");

              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("font-size", "inherit");
            },
            footer: true
          },
          {
            extend: "pdfHtml5",
            footer: true,
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
              doc.content[1].table.widths = Array(
                doc.content[1].table.body[0].length + 1
              )
                .join("*")
                .split("");
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('od_expense_view') }}",
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: date_from_od,
            date_to: date_to_od
          }
        },
        processing: true,
        serverSide: true,
        columns: [
          { data: "od_id" },
          { data: "description" },
          { data: "type" },
          { data: "amount" },
          { data: "status" },
          { data: "created_at" },
          { data: "released_by" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
    $($.fn.dataTable.tables(true)).css("width", "100%");
    $($.fn.dataTable.tables(true))
      .DataTable()
      .columns.adjust()
      .draw();
  });

  //---END of OD EXPense
  $(document).on("click", ".release_expense_normal", function(event) {
    event.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      url: "{{ route('check_balance') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        if (data == 0) {
          swal("Insufficient Balance!", "Contact Boss", "warning");
          return;
        } else if (data == 2) {
          swal(
            "Money already released for this!",
            "Please refresh the page",
            "info"
          );
          return;
        } else {
          $("#release_modal_normal").modal("show");
        }
      }
    });
  });

  $(document).on("click", ".release_expense", function(event) {
    event.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      url: "{{ route('check_balance2') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        if (data == 0) {
          swal("Insufficient Balance!", "Contact Boss", "warning");
          return;
        } else if (data == 2) {
          swal(
            "Money already released for this!",
            "Please refresh the page",
            "info"
          );
          return;
        } else {
          $("#release_modal").modal("show");
        }
      }
    });
  });

  $(document).on("click", ".release_expense_od", function(event) {
    event.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      url: "{{ route('check_balance_od') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        if (data == 0) {
          swal("Insufficient Balance!", "Contact Boss", "warning");
          return;
        } else if (data == 2) {
          swal(
            "Money already released for this!",
            "Please refresh the page",
            "info"
          );
          return;
        } else {
          $("#release_modal_od").modal("show");
        }
      }
    });
  });

  $(document).on("click", "#release_money", function() {
    var input = $(this);
    var button = this;
    button.disabled = true;
    input.html("Releasing...");
    var button = this;
    button.disabled = true;
    $.ajax({
      url: "{{ route('release_update') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        swal(
          "Cash Released!",
          "Remaining Balance: ₱" +
            data.cashOnHand.toFixed(2) +
            " | Transaction ID: " +
            data.cashHistory,
          "success"
        );
        $("#release_modal").modal("hide");
        $("#curCashOnHand").html(data.cashOnHand.toFixed(2));
        button.disabled = false;
        input.html("CONTINUE");
        trip_expensetable.ajax.reload(); //reload datatable ajax
      }
    });
  });
  $(document).on("click", "#release_money_od", function() {
    var input = $(this);
    var button = this;
    button.disabled = true;
    input.html("Releasing...");
    var button = this;
    button.disabled = true;
    $.ajax({
      url: "{{ route('release_update_od') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        swal(
          "Cash Released!",
          "Remaining Balance: ₱" +
            data.cashOnHand.toFixed(2) +
            " | Transaction ID: " +
            data.cashHistory,
          "success"
        );
        $("#release_modal_od").modal("hide");
        $("#curCashOnHand").html(data.cashOnHand.toFixed(2));
        button.disabled = false;
        input.html("CONTINUE");
        od_expensetable.ajax.reload(); //reload datatable ajax
      }
    });
  });

  $(document).on("click", "#release_money_normal", function() {
    var input = $(this);
    var button = this;
    button.disabled = true;
    input.html("Releasing...");
    var button = this;
    button.disabled = true;
    $.ajax({
      url: "{{ route('release_update_normal') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        swal(
          "Cash Released!",
          "Remaining Balance: ₱" +
            data.cashOnHand.toFixed(2) +
            " | Transaction ID: " +
            data.cashHistory,
          "success"
        );
        $("#release_modal_normal").modal("hide");
        $("#curCashOnHand").html(data.cashOnHand.toFixed(2));
        button.disabled = false;
        input.html("CONTINUE");
        expensetable.ajax.reload(); //reload datatable ajax
      }
    });
  });

  function refresh_expense_table() {
    expensetable.ajax.reload(); //reload datatable ajax
  }
  $("#expense_modal").on("hidden.bs.modal", function() {
    $(".modal_title").text("Add Expense");
    type = "";
  });
  $("#expense_modal").on("shown.bs.modal", function() {
    $.ajax({
      url: "{{ route('getNumber') }}",
      method: "get",
      data: { temp: "temp" },
      dataType: "json",
      success: function(data) {
        var t = 0;
        if (data[0].temp != null) {
          t = data[0].temp;
        }
        var a = parseInt(t);
        var b = a + 1;
        var c = new Date();
        var twoDigitMonth =
          c.getMonth().length + 1 == 1
            ? c.getMonth() + 1
            : "0" + (c.getMonth() + 1);
        var currentDate = c.getFullYear() + twoDigitMonth + c.getDate();
        if (type != "update") {
          $("#trans_number").val(currentDate + b);
        }
      }
    });
  });
  mainMouseDownOne();
  function mainMouseDownOne() {
    $("#add_expense").one("click", function(event) {
      console.log("tura");
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      event.preventDefault();
      $.ajax({
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "{{ route('add_expense')}}",
        dataType: "text",
        data: $("#expense_form").serialize(),
        success: function(data) {
          swal("Success!", "Record has been added to database", "success");
          $("#expense_modal").modal("hide");
          mainMouseDownOne();
          button.disabled = false;
          input.html("SAVE CHANGES");
          $(".modal_title").text("Add Expense");
          refresh_expense_table();
        },
        error: function(data) {
          mainMouseDownOne();
          swal("Oh no!", "Something went wrong, try again.", "error");
          button.disabled = false;
          input.html("SAVE CHANGES");
          $(".modal_title").text("Add Expense");
        }
      });
    });
  }
  $(document).on("click", ".update_expense", function() {
    var id = $(this).attr("id");
    type = "update";
    $("#trans_number")
      .val("")
      .trigger("change");
    $.ajax({
      url: "{{ route('update_expense') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#button_action").val("update");
        $("#trans_number").val(data.trans_number);
        $("#id").val(id);
        $("#expense").val(data.description);
        $("#type").val(data.type);
        $("#amount").val(data.amount);
        $("#expense_modal").modal("show");
        $(".modal_title").text("Update Expense");
        refresh_expense_table();
      }
    });
  });

  //Delete expense
  $(document).on("click", ".delete_expense", function() {
    var id = $(this).attr("id");
    swal({
      title: "Are you sure?",
      text: "Delete this record?",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        $.ajax({
          url: "{{ route('delete_expense') }}",
          method: "get",
          data: { id: id },
          success: function(data) {
            var dataparsed = JSON.parse(data);
            console.log(dataparsed);
            refresh_expense_table();

            if (typeof dataparsed.cashOnHand !== "undefined") {
              $("#curCashOnHand").html(dataparsed.cashOnHand.toFixed(2));
              swal(
                "Released Expense Deleted!",
                "Remaining Balance: ₱" +
                  dataparsed.cashOnHand.toFixed(2) +
                  " | Transaction ID: " +
                  dataparsed.cashHistory,
                "success"
              );
            } else {
              swal("Deleted!", "The record has been deleted.", "success");
            }
          }
        });
      }
    });
  });

  $("#print_expense").click(function(event) {
    event.preventDefault();
    $("#add_expense").trigger("click");
    $("#print_form").trigger("click");
  });

  $("#print_form").click(function(event) {
    $("#expense_clone").val($("#expense").val());
    $("#type_clone").val($("#type").val());
    $("#amount_clone").val($("#amount").val());
    $("#trans_clone").val($("#trans_number").val());
  });
  //EXPENSE Datatable ends here

  src = "{{ route('autocomplete_name') }}";

  $("#expense").autocomplete({
    source: function(request, response) {
      $.ajax({
        url: src,
        dataType: "json",
        data: {
          term: request.term
        },
        success: function(data) {
          response(data);
        }
      });
    }
  });

  if (window.location.hash) {
    $('.nav-tabs li a[href="' + window.location.hash + '"]').tab("show");
  }
});

</script>
@endsection
