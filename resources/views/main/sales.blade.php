@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
	<div class="container-fluid">
		<div class="block-header">
			<h2>Sales Dashboard</h2>
		</div>
	</div>
	<div class="modal fade" id="sales_modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2 class="modal_title">Add Sales</h2>
						<ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button id="print_sales" type="button" class="btn btn-sm btn-icon print-icon" ><i class="glyphicon glyphicon-print"></i></button>
                            </li>
                            <li class="dropdown">
                                <!-- <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_sales') }}">
									<input type="hidden" id="transaction_clone" name="transaction_clone">
									<input type="hidden" id="commodity_clone" name="commodity_clone">
									<input type="hidden" id="company_clone" name="company_clone">
									<input type="hidden" id="kilos_clone" name="kilos_clone">
									<input type="hidden" id="price_clone" name="price_clone">
									<input type="hidden" id="payment_method_clone" name="payment_method_clone">
									<input type="hidden" id="check_number_clone" name="check_number_clone">
									<input type="hidden" id="amount_clone" name="amount_clone">
									<button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                </form> -->
                            </li>
                        </ul>
					</div>
					<div class="body">
						<form class="form-horizontal " id="sales_form">
							<input type="hidden" name="id" id="id" value="">
							<input type="hidden" name="button_action" id="button_action" value="">
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Transaction number</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="trans_num" name="trans_num" class="form-control"   required readonly="readonly">
										</div>
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="type">Commodity</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<select type="text" id="commodity" name="commodity" class="form-control" placeholder="Select item" required style="width:100%;">
											@foreach($commodity as $a)
											<option value="{{ $a->id }}">{{ $a->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
                                   <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="type">Company</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<select type="text" id="company" name="company" class="form-control" placeholder="Select company" required style="width:100%;">
											@foreach($company as $a)
											<option value="{{ $a->id }}">{{ $a->name }}</option>
											@endforeach
										</select>
									</div>
								</div> 
							</div>
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Kilos</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="kilos" name="kilos" class="form-control"   required>
										</div>
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Price</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="price" name="price" class="form-control"   required>
										</div>
									</div>
								</div>
							</div>

							<div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                     <label for="name">Payment Method</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                     <div class="form-group">
                                          <div id="pm" class="form-line">
                                               <select type="text" id="paymentmethod" name="paymentmethod" class="form-control" required style="width: 100%;">

                                          <option value="Cash">Cash</option>
                                           <option value="Check">Check</option>
                                       </select>
                                          </div>
                                     </div>
                                </div>
                          </div>
						  <div id="cn" class="row clearfix hidden">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="name">Check Number</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                              <div class="form-line">
                                                   <input type="text" id="checknumber"  name="checknumber" class="form-control" >
                                              </div>
                                         </div>
                                    </div>
                              </div>

							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Amount</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="amount" name="amount" class="form-control"   required readonly="readonly">
										</div>
									</div>
								</div>
							</div>

						</form>
						<div class="row clearfix">
							<div class="modal-footer">
								<div class="print-only">
									<form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_sales') }}">
										<input type="hidden" id="transaction_clone" name="transaction_clone">
										<input type="hidden" id="commodity_clone" name="commodity_clone">
										<input type="hidden" id="company_clone" name="company_clone">
										<input type="hidden" id="kilos_clone" name="kilos_clone">
										<input type="hidden" id="price_clone" name="price_clone">
										<input type="hidden" id="payment_method_clone" name="payment_method_clone">
										<input type="hidden" id="check_number_clone" name="check_number_clone">
										<input type="hidden" id="amount_clone" name="amount_clone">
										<button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
									</form>
								</div>
								<button type="submit" id="add_sales" class="btn btn-link waves-effect">SAVE CHANGES</button>
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
					<h2>List of Sales as of {{ date('Y-m-d ') }}</h2>
						<ul class="header-dropdown m-r--5">
							<li class="dropdown">
                @if(isAdmin() || isPurchaser())
								<button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 open_sales_modal"><i class="material-icons">library_add</i></button>
                @endif
              </li>
						</ul>
					</div>
					<div class="body">
						<div class="table-responsive">
							 <p id="date_filter">
                                <h5>Date Range Filter</h5>
                                <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="sales_datepicker_from" />
                                <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text" id="sales_datepicker_to" />
                            </p>
							<br>
							<table id="salestable" class="table table-bordered table-striped table-hover  ">
								<thead>
									<tr>
										<th width="100" style="text-align:center;">Transaction No.</th>
										<th width="100" style="text-align:center;">Date</th>
										<th width="100" style="text-align:center;">Received By</th>
										<th width="100" style="text-align:center;">Commodity</th>
										<th width="100" style="text-align:center;">Company</th>
										<th width="100" style="text-align:center;">No. Of Kilos</th>
										<th width="100" style="text-align:center;">Price</th>
										<th width="100" style="text-align:center;">Check Number</th>
										<th width="100" style="text-align:center;">Amount</th>
										<th width="100" style="text-align:center;">Action</th>
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
@endsection

@section('script')
<script>
var salestable;
var sales_date_from;
var sales_date_to;
$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});

$(document).ready(function() {
  document.title = "{{ env('APP_NAME') }} - Sales";

  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });

  //OUTBOUND DELIVERIES datatable starts here
  $("#sales_modal").on("hidden.bs.modal", function(e) {
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

  salestable = $("#salestable").DataTable({
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
        .column(8)
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(8, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(8).footer()).html(
        "Total: <br>₱" + number_format(pageTotal, 2)
      );

      // Total over this page
      pageTotal1 = api
        .column(5, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(5).footer()).html(
        "Total: <br>" + number_format(pageTotal1, 2) + " kg"
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
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
    processing: true,

    columnDefs: [
      {
        targets: "_all", // your case first column
        className: "text-center"
      }
    ],
    order: [],
    ajax: {
      url: "{{ route('refresh_sales') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        date_from: sales_date_from,
        date_to: sales_date_to
      }
    },
    columns: [
      { data: "trans_number" },
      { data: "created_at" },
      { data: "uname", name: "users.name" },
      { data: "commodity_name", name: "commodity.name" },
      { data: "name", name: "company.name" },
      { data: "kilos" },
      { data: "price", name: "price" },
      { data: "check_number" },
      { data: "amount" },
      { data: "action", orderable: false, searchable: false }
    ]
  });
  //Start of Date Range Filter
  $("#sales_datepicker_from")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        minDateFilter = new Date(date).getTime();
        var df = new Date(date);
        sales_date_from =
          df.getFullYear() + "-" + (df.getMonth() + 1) + "-" + df.getDate();
        $("#salestable")
          .dataTable()
          .fnDestroy();
        salestable = $("#salestable").DataTable({
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
              .column(8)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(8, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(8).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );

            // Total over this page
            pageTotal1 = api
              .column(5, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(5).footer()).html(
              "Total: <br>" + number_format(pageTotal1, 2) + " kg"
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
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
          processing: true,

          order: [],
          ajax: {
            url: "{{ route('refresh_sales') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: sales_date_from,
              date_to: sales_date_to
            }
          },
          columns: [
            { data: "trans_number" },
            { data: "created_at" },
            { data: "uname" },
            { data: "commodity_name" },
            { data: "name" },
            { data: "kilos" },
            { data: "price", name: "price" },
            { data: "check_number" },
            { data: "amount" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      sales_date_from = "";
      $("#salestable")
        .dataTable()
        .fnDestroy();
      salestable = $("#salestable").DataTable({
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
            .column(8)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(8, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(8).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );

          // Total over this page
          pageTotal1 = api
            .column(5, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(5).footer()).html(
            "Total: <br>" + number_format(pageTotal1, 2) + " kg"
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
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
        processing: true,

        order: [],
        ajax: {
          url: "{{ route('refresh_sales') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: sales_date_from,
            date_to: sales_date_to
          }
        },
        columns: [
          { data: "trans_number" },
          { data: "created_at" },
          { data: "uname" },
          { data: "commodity_name" },
          { data: "name" },
          { data: "kilos" },
          { data: "price", name: "price" },
          { data: "check_number" },
          { data: "amount" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $("#sales_datepicker_to")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        maxDateFilter = new Date(date).getTime();
        //oTable.fnDraw();
        var dt = new Date(date);
        sales_date_to =
          dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
        $("#salestable")
          .dataTable()
          .fnDestroy();
        salestable = $("#salestable").DataTable({
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
              .column(8)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(8, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(8).footer()).html(
              "Total: <br>₱" + number_format(pageTotal, 2)
            );

            // Total over this page
            pageTotal1 = api
              .column(5, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(5).footer()).html(
              "Total: <br>" + number_format(pageTotal1, 2) + " kg"
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
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
          processing: true,

          order: [],
          ajax: {
            url: "{{ route('refresh_sales') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: sales_date_from,
              date_to: sales_date_to
            }
          },
          columns: [
            { data: "trans_number" },
            { data: "created_at" },
            { data: "uname" },
            { data: "commodity_name" },
            { data: "name" },
            { data: "kilos" },
            { data: "price", name: "price" },
            { data: "check_number" },
            { data: "amount" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      sales_date_to = "";
      $("#salestable")
        .dataTable()
        .fnDestroy();
      salestable = $("#salestable").DataTable({
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
            .column(8)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(8, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(8).footer()).html(
            "Total: <br>₱" + number_format(pageTotal, 2)
          );

          // Total over this page
          pageTotal1 = api
            .column(5, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(5).footer()).html(
            "Total: <br>" + number_format(pageTotal1, 2) + " kg"
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
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
        processing: true,

        order: [],
        ajax: {
          url: "{{ route('refresh_sales') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: sales_date_from,
            date_to: sales_date_to
          }
        },
        columns: [
          { data: "trans_number" },
          { data: "created_at" },
          { data: "uname" },
          { data: "commodity_name" },
          { data: "name" },
          { data: "kilos" },
          { data: "price", name: "price" },
          { data: "check_number" },
          { data: "amount" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });
  //End of Date Range Filter
  var x;
  $("#paymentmethod").change(function() {
    x = $("#paymentmethod").val();
    if (x == "Check") {
      $("#cn").removeClass("hidden");
    } else {
      $("#checknumber").val("");
      $("#cn").addClass("hidden");
    }
  });
  function refresh_sales_table() {
    salestable.ajax.reload(); //reload datatable ajax
  }

  $(document).on("click", ".open_sales_modal", function() {
    $.ajax({
      url: "{{ route('getSales') }}",
      method: "get",
      dataType: "json",
      success: function(data) {
        $("#trans_num").val(data.trans_no);
      }
    });
    $(".modal_title").text("Add Sales");
    $("#button_action").val("add");
    $("#company")
      .val("")
      .trigger("change");
    $("#commodity")
      .val("")
      .trigger("change");
    $("#paymentmethod")
      .val("")
      .trigger("change");
    $("#sales_modal").modal("show");
  });
  mainMouseDownOne();
  function mainMouseDownOne() {
    $("#add_sales").one("click", function(event) {
      event.preventDefault();
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "{{ route('add_sales') }}",
        method: "POST",
        dataType: "text",
        data: $("#sales_form").serialize(),
        success: function(data) {
          mainMouseDownOne();
          button.disabled = false;
          input.html("SAVE CHANGES");
          $("#company")
            .val("")
            .trigger("change");
          $("#commodity")
            .val("")
            .trigger("change");
          $("#paymentmethod")
            .val("")
            .trigger("change");
          swal("Success!", "Record has been added to database", "success");
          $("#sales_modal").modal("hide");
          refresh_sales_table();
        },
        error: function(data) {
          mainMouseDownOne();
          swal("Oh no!", "Something went wrong, try again.", "error");
          button.disabled = false;
          input.html("SAVE CHANGES");
        }
      });
    });
  }

  $("#print_sales").click(function(event) {
    event.preventDefault();
    $("#add_sales").trigger("click");
    $("#print_form").trigger("click");
  });

  $("#print_form").click(function(event) {
    $("#transaction_clone").val($("#trans_num").val());
    $("#commodity_clone").val($("#commodity option:selected").text());
    $("#company_clone").val($("#company option:selected").text());
    $("#kilos_clone").val($("#kilos").val());
    $("#price_clone").val($("#price").val());
    $("#payment_method_clone").val($("#paymentmethod").val());
    $("#check_number_clone").val($("#checknumber").val());
    $("#amount_clone").val($("#amount").val());
  });

  $(document).on("click", ".update_sales", function() {
    var id = $(this).attr("id");
    $.ajax({
      url: "{{ route('update_sales') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#button_action").val("update");
        $("#id").val(id);
        $("#trans_num").val(data.trans_number);
        $("#company")
          .val(data.company_id)
          .trigger("change");
        $("#commodity")
          .val(data.commodity_id)
          .trigger("change");
        $("#kilos").val(data.kilos);
        $("#price").val(data.price);
        $("#amount").val(data.amount);
        if (data.check_number != "Not Specified") {
          $("#checknumber").val(data.check_number);
          $("#cn").removeClass("hidden");

          //$("#paymentmethod").val(0).trigger('change');
          $("#paymentmethod")
            .val("Check")
            .trigger("change");
        } else {
          $("#checknumber").val("");
          $("#cn").addClass("hidden");
          $("#paymentmethod")
            .val("Cash")
            .trigger("change");
        }
        $("#sales_modal").modal("show");
        $(".modal_title").text("Update Sales");
        refresh_sales_table();
      }
    });
  });

  $("#price").on("keyup keydown", function(e) {
    if ($("#kilos").val() != "" && $("#price").val() != "") {
      var a = parseFloat($("#kilos").val());
      var b = parseFloat($("#price").val());
      var x;
      if ($("#kilos").val() != "") {
        a = parseFloat($("#kilos").val());
        x = a * b;
        var temp3 = parseFloat(x).toFixed(2);
        $("#amount").val(temp3);
      }
    } else {
      $("#amount").val(0);
    }
  });
  $("#kilos").on("keyup keydown", function(e) {
    var a = parseFloat($("#price").val());
    var b = parseFloat($("#kilos").val());
    var x;

    if ($("#price").val() != "" && $("#kilos").val() != "") {
      a = parseFloat($("#price").val());

      x = a * b;
      var temp3 = parseFloat(x).toFixed(2);
      $("#amount").val(temp3);
    } else {
      $("#amount").val(0);
    }
  });

  $(document).on("click", ".delete_sales", function() {
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
          url: "{{ route('delete_sales') }}",
          method: "get",
          data: { id: id },
          success: function(data) {
            refresh_sales_table();
          }
        });
        swal("Deleted!", "The record has been deleted.", "success");
      }
    });
  });
  //OUTBOUND DELIVERIES Datatable ends here

  $("#paymentmethod").select2({
    dropdownParent: $("#sales_modal"),
    placeholder: "Select a type of payment"
  });
  $("#commodity").select2({
    dropdownParent: $("#sales_modal"),
    placeholder: "Select an item"
  });
  $("#company").select2({
    dropdownParent: $("#sales_modal"),
    placeholder: "Select a company"
  });
});
</script>
@endsection
