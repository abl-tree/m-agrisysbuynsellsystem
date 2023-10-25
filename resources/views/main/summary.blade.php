@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
	<div align="center" class="container-fluid">
		<div class="block-header">
			<h1>Summary</h1>
			<h2 id=date_today></h2>
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
					<div class="body">
						<div class="table-responsive">
                        <div style="margin-bottom: -62px; margin-left: 480px;z-index: 999;">
                              <h5>Commodity Filter</h5>
                              <select style="width: 350px;" type="text"  id="commodityfilter" name="commodityfilter" multiple="multiple" data-placeholder="Select Commodity" >
                                     @foreach($commodity as $a)
                                     <option value="{{ $a->name }}">{{ $a->name }}</option>
                                     @endforeach
                                </select>
                            </div>
                            <!--<div style="margin-bottom: -68px; margin-left: 850px;z-index: 1000;">
                              <h5>Group By</h5>
                              <select size="3" style="width: 200px;" type="text" id="typeFilter" name="typeFilter" data-placeholder="Select Group" >
                                    <option value="All">All</option>
                                    <option value="Price">Price</option>
                                </select>
                            </div>-->
                          
							 <p id="date_filter">
                                <h5>Date Range Filter</h5>
                                <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="sales_datepicker_from" />
                                <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text" id="sales_datepicker_to" />
                            </p>
							<br>
							<table id="salestable" class="table table-bordered table-striped table-hover  ">
								<thead>
									<tr>
										<th width="100" style="text-align:center;">Commodity (Price)</th>
										<th width="100" style="text-align:center;">Total Net Weight (KG)</th>
										<th width="100" style="text-align:center;">Total Amount</th>
									</tr>
								</thead>
								<tfoot>
	                                <tr>
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
var sales_date_from = "";
var sales_date_to = "";
var commodityselected = [];
var typeselected = "";
var day = new Date();

var today =
  day.getFullYear() + "-" + (day.getMonth() + 1) + "-" + day.getDate();

$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});

$(document).ready(function() {
  document.title = "{{ env('APP_NAME') }} - Summary Date " + new Date(today).toDateString();
  $("#date_today").html(new Date(today).toDateString());
  // console.log(today);
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
        .column(1)
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(1, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(1).footer()).html(number_format(pageTotal, 2) + " KG");

      // Total over this page
      pageTotal1 = api
        .column(2, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);
      // Update footer
      $(api.column(2).footer()).html(
        "Total: <br>₱" + number_format(pageTotal1, 2)
      );
      $(api.column(0).footer()).html(
        "Average Price = " + number_format(pageTotal1 / pageTotal, 2)
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
          columns: [0, 1, 2],
          modifier: {
            page: "current"
          }
        },
        customize: function(win) {
          $(win.document.body).css("font-size", "15pt");

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
          columns: [0, 1, 2],
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
      url: "{{ route('refresh_summary') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        date_from: sales_date_from,
        date_to: sales_date_to,
        commodity: commodityselected,
        type: typeselected
      }
    },
    columns: [
      { data: "commodity_name" },
      { data: "net_weight" },
      { data: "total" }
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
        $("#date_today").html(
          new Date(sales_date_from).toDateString() +
            " to " +
            new Date(sales_date_to).toDateString()
        );
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
              .column(1)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(1, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(1).footer()).html(number_format(pageTotal, 2) + " KG");

            // Total over this page
            pageTotal1 = api
              .column(2, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(2).footer()).html(
              "Total: <br>₱" + number_format(pageTotal1, 2)
            );
            $(api.column(0).footer()).html(
              "Average Price = " + number_format(pageTotal1 / pageTotal, 2)
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
                columns: [0, 1, 2],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "15pt");

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
                columns: [0, 1, 2],
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
            url: "{{ route('refresh_summary') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: sales_date_from,
              date_to: sales_date_to,
              commodity: commodityselected,
              type: typeselected
            }
          },
          columns: [
            { data: "commodity_name" },
            { data: "net_weight" },
            { data: "total" }
          ]
        });
      }
    })
    .keyup(function() {
      sales_date_from = "";
      $("#date_today").html(new Date(today).toDateString());
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
            .column(1)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(1, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(1).footer()).html(number_format(pageTotal, 2) + " KG");

          // Total over this page
          pageTotal1 = api
            .column(2, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(2).footer()).html("₱" + number_format(pageTotal1, 2));
          $(api.column(0).footer()).html(
            "Average Price = " + number_format(pageTotal1 / pageTotal, 2)
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
              columns: [0, 1, 2],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "15pt");

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
              columns: [0, 1, 2],
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
          url: "{{ route('refresh_summary') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: sales_date_from,
            date_to: sales_date_to,
            commodity: commodityselected,
            type: typeselected
          }
        },
        columns: [
          { data: "commodity_name" },
          { data: "net_weight" },
          { data: "total" }
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
        document.title =
          "{{ env('APP_NAME') }} - Summary Date: From " +
          new Date(sales_date_from).toDateString() +
          " to " +
          new Date(sales_date_to).toDateString();
        $("#date_today").html(
          new Date(sales_date_from).toDateString() +
            " to " +
            new Date(sales_date_to).toDateString()
        );
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
              .column(1)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(1, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(1).footer()).html(number_format(pageTotal, 2) + " KG");

            // Total over this page
            pageTotal1 = api
              .column(2, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(2).footer()).html("₱" + number_format(pageTotal1, 2));
            $(api.column(0).footer()).html(
              "Average Price = " + number_format(pageTotal1 / pageTotal, 2)
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
                columns: [0, 1, 2],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                $(win.document.body).css("font-size", "15pt");

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
                columns: [0, 1, 2],
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
            url: "{{ route('refresh_summary') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: sales_date_from,
              date_to: sales_date_to,
              commodity: commodityselected,
              type: typeselected
            }
          },
          columns: [
            { data: "commodity_name" },
            { data: "net_weight" },
            { data: "total" }
          ]
        });
      }
    })
    .keyup(function() {
      sales_date_to = "";
      $("#date_today").html(new Date(today).toDateString());
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
            .column(1)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(1, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(1).footer()).html(number_format(pageTotal, 2) + " KG");

          // Total over this page
          pageTotal1 = api
            .column(2, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(2).footer()).html("₱" + number_format(pageTotal1, 2));
          $(api.column(0).footer()).html(
            "Average Price = " + number_format(pageTotal1 / pageTotal, 2)
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
              columns: [0, 1, 2],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              $(win.document.body).css("font-size", "15pt");

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
              columns: [0, 1, 2],
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
          url: "{{ route('refresh_summary') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: sales_date_from,
            date_to: sales_date_to,
            commodity: commodityselected,
            type: typeselected
          }
        },
        columns: [
          { data: "commodity_name" },
          { data: "net_weight" },
          { data: "total" }
        ]
      });
    });
  //End of Date Range Filter
  var x;
  $("#commodityfilter").on("change", function(e) {
    commodityselected = $("#commodityfilter").select2("val");
    console.log(commodityselected);
    //    console.log(this.value)

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
          .column(1)
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(1, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(1).footer()).html(number_format(pageTotal, 2) + " KG");

        // Total over this page
        pageTotal1 = api
          .column(2, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(2).footer()).html("₱" + number_format(pageTotal1, 2));
        $(api.column(0).footer()).html(
          "Average Price = " + number_format(pageTotal1 / pageTotal, 2)
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
            columns: [0, 1, 2],
            modifier: {
              page: "current"
            }
          },
          customize: function(win) {
            $(win.document.body).css("font-size", "15pt");

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
            columns: [0, 1, 2],
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
        url: "{{ route('refresh_summary') }}",
        // dataType: 'text',
        type: "post",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        data: {
          date_from: sales_date_from,
          date_to: sales_date_to,
          commodity: commodityselected,
          type: typeselected
        }
      },
      columns: [
        { data: "commodity_name" },
        { data: "net_weight" },
        { data: "total" }
      ]
    });
  });

  $("#typeFilter").on("change", function(e) {
    typeselected = this.value;
    console.log(typeselected);
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
          .column(1)
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(1, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(1).footer()).html(number_format(pageTotal, 2) + " KG");

        // Total over this page
        pageTotal1 = api
          .column(2, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(2).footer()).html("₱" + number_format(pageTotal1, 2));
        $(api.column(0).footer()).html(
          "Average Price = " + number_format(pageTotal1 / pageTotal, 2)
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
            columns: [0, 1, 2],
            modifier: {
              page: "current"
            }
          },
          customize: function(win) {
            $(win.document.body).css("font-size", "15pt");

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
            columns: [0, 1, 2],
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
        url: "{{ route('refresh_summary') }}",
        // dataType: 'text',
        type: "post",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        data: {
          date_from: sales_date_from,
          date_to: sales_date_to,
          commodity: commodityselected,
          type: typeselected
        }
      },
      columns: [
        { data: "commodity_name" },
        { data: "net_weight" },
        { data: "total" }
      ]
    });
  });

  function refresh_sales_table() {
    salestable.ajax.reload(); //reload datatable ajax
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

  $("#commodityfilter").select2({
    placeholder: "Select Commodity"
  });

  $("#typeFilter").select2({
    placeholder: "Select Group"
  });
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
