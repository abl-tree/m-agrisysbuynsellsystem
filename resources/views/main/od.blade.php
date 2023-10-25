@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
	<div class="container-fluid">
		<div class="block-header">
			<h2>Outbound Deliveries Dashboard</h2>
		</div>
	</div>
	<div class="modal fade" id="od_modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2 class="modal_title">Add Delivery</h2>
						<ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button id="print_od" type="button" class="btn btn-sm btn-icon print-icon" ><i class="glyphicon glyphicon-print"></i></button>
                            </li>
                            <li class="dropdown">
                                <!-- <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_od') }}">
									<input type="hidden" id="ticket_clone" name="ticket_clone">
									<input type="hidden" id="commodity_clone" name="commodity_clone">
									<input type="hidden" id="destination_clone" name="destination_clone">
									<input type="hidden" id="driver_id_clone" name="driver_id_clone">
									<input type="hidden" id="company_clone" name="company_clone">
									<input type="hidden" id="plateno_clone" name="plateno_clone">
									<input type="hidden" id="liter_clone" name="liter_clone">
									<input type="hidden" id="kilos_clone" name="kilos_clone">
									<input type="hidden" id="allowance_clone" name="allowance_clone">
									<button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button> 
                                </form> -->
                            </li>
                        </ul>
					</div>
					<div class="body">
						<form class="form-horizontal " id="od_form">
							<input type="hidden" name="id" id="id" value="">
							<input type="hidden" name="button_action" id="button_action" value="">
							
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Outbound Ticket</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="ticket" name="ticket" readonly="readonly" value="" class="form-control" required>
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
										<select type="text" id="commodity" name="commodity" class="form-control" placeholder="Select Commodity" required style="width:100%;">
											@foreach($commodity as $a)
											<option value="{{ $a->id }}">{{ $a->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Destination</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="destination" name="destination" class="form-control"   required>
										</div>
									</div>
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="type">Driver</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<select type="text" id="driver_id" name="driver_id" class="form-control" placeholder="Select driver" required style="width:100%;">
											@foreach($driver as $a)
											<option value="{{ $a->emp_id }}">{{ $a->lname }}, {{ $a->fname }} {{ $a->mname }}</option>
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
									<label for="name">Plate #</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<select type="text" id="plateno" name="plateno" class="form-control" placeholder="Select truck" required style="width:100%;">
											@foreach($trucks as $a)
											<option value="{{ $a->id }}">{{ $a->name }} ({{ $a->plate_no }})</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">No. of Liters</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="liter" name="liter" class="form-control"   required>
										</div>
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">No. of Kilos</label>
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
									<label for="name">Allowance</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="allowance" name="allowance" class="form-control"   required>
										</div>
									</div>
								</div>
							</div>

						</form>
						<div class="row clearfix">
							<div class="modal-footer">
								<div>
									<form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_od') }}">
										<input type="hidden" id="ticket_clone" name="ticket_clone">
										<input type="hidden" id="commodity_clone" name="commodity_clone">
										<input type="hidden" id="destination_clone" name="destination_clone">
										<input type="hidden" id="driver_id_clone" name="driver_id_clone">
										<input type="hidden" id="company_clone" name="company_clone">
										<input type="hidden" id="plateno_clone" name="plateno_clone">
										<input type="hidden" id="liter_clone" name="liter_clone">
										<input type="hidden" id="kilos_clone" name="kilos_clone">
										<input type="hidden" id="allowance_clone" name="allowance_clone">
										<button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button> 
									</form>
								</div>
								<button type="submit" id="add_delivery" class="btn btn-link waves-effect">SAVE CHANGES</button>
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
					<h2>List of Outbound Deliveries as of {{ date('Y-m-d ') }}</h2>
						<ul class="header-dropdown m-r--5">
							<li class="dropdown">
                @if(isAdmin() || isPurchaser())
								<button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 open_od_modal"><i class="material-icons">library_add</i></button>
                @endif
              </li>
						</ul>
					</div>
					<div class="body">
						<div class="table-responsive">
							<p id="date_filter">
                            <h5>Date Range Filter</h5>
                            <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="od_datepicker_from" />
                            <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text" id="od_datepicker_to" />
                        </p>
						<br>
							<table id="deliverytable" class="table table-bordered table-striped table-hover  ">
								<thead>
									<tr>
										<th width="20" style="text-align:center;">Ticket No</th>
										<th width="100" style="text-align:center;">Commodity</th>
										<th width="100" style="text-align:center;">Destination</th>
										<th width="100" style="text-align:center;">Company</th>
										<th width="100" style="text-align:center;">Driver</th>
										<th width="100" style="text-align:center;">Plate No.</th>
										<th width="100" style="text-align:center;">Liters</th>
										<th width="100" style="text-align:center;">Kilos</th>
										<th width="100" style="text-align:center;">Allowance</th>
										<th width="100" style="text-align:center;">Date</th>
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
var deliveriestable;
var od_date_from;
var od_date_to;
$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});

$(document).ready(function() {
  document.title = "{{ env('APP_NAME') }} - Outbound Deliveries";

  $($.fn.dataTable.tables(true)).css("width", "100%");
  $($.fn.dataTable.tables(true))
    .DataTable()
    .columns.adjust()
    .draw();

  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });

  //OUTBOUND DELIVERIES datatable starts here
  $("#od_modal").on("hidden.bs.modal", function(e) {
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

  deliveriestable = $("#deliverytable").DataTable({
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
        .column(7, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(7).footer()).html(
        "Total: <br>" + number_format(pageTotal1, 2) + " kg"
      );

      // Total over this page
      pageTotal1 = api
        .column(6, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(6).footer()).html(
        "Total: <br>" + number_format(pageTotal1, 2) + " L"
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          modifier: {
            page: "current"
          }
        },
        customize: function(doc) {
          doc.styles.tableHeader.fontSize = 8;
          doc.styles.tableFooter.fontSize = 8;
          doc.defaultStyle.fontSize = 8;
        }
      }
    ],
    paging: true,
    pageLength: 10,
    order: [],
    ajax: {
      url: "{{ route('refresh_deliveries') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        date_from: od_date_from,
        date_to: od_date_to
      }
    },
    processing: true,
    columns: [
      { data: "outboundTicket" },
      { data: "commodity_name" },
      { data: "destination" },
      { data: "name" },
      {
        data: "fname",
        render: function(data, type, full, meta) {
          return full.fname + " " + full.mname + " " + full.lname;
        }
      },
      { data: "plateno" },
      { data: "fuel_liters" },
      { data: "kilos" },
      { data: "allowance" },
      { data: "created_at" },
      { data: "action", orderable: false, searchable: false }
    ]
  });
  //START OF DATE RANGE FILTER
  $("#od_datepicker_from")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        minDateFilter = new Date(date).getTime();
        var df = new Date(date);
        od_date_from =
          df.getFullYear() + "-" + (df.getMonth() + 1) + "-" + df.getDate();
        $("#deliverytable")
          .dataTable()
          .fnDestroy();
        deliveriestable = $("#deliverytable").DataTable({
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
              .column(7, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(7).footer()).html(
              "Total: <br>" + number_format(pageTotal1, 2) + " kg"
            );

            // Total over this page
            pageTotal1 = api
              .column(6, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(6).footer()).html(
              "Total: <br>" + number_format(pageTotal1, 2) + " L"
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
              }
            }
          ],
          paging: true,
          pageLength: 10,
          order: [],
          ajax: {
            url: "{{ route('refresh_deliveries') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: od_date_from,
              date_to: od_date_to
            }
          },
          processing: true,
          columns: [
            { data: "outboundTicket" },
            { data: "commodity_name" },
            { data: "destination" },
            { data: "name" },
            {
              data: "fname",
              render: function(data, type, full, meta) {
                return full.fname + " " + full.mname + " " + full.lname;
              }
            },
            { data: "plateno" },
            { data: "fuel_liters" },
            { data: "kilos" },
            { data: "allowance" },
            { data: "created_at" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      od_datepicker_from = "";
      $("#deliverytable")
        .dataTable()
        .fnDestroy();
      deliveriestable = $("#deliverytable").DataTable({
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
            .column(7, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(7).footer()).html(
            "Total: <br>" + number_format(pageTotal1, 2) + " kg"
          );

          // Total over this page
          pageTotal1 = api
            .column(6, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(6).footer()).html(
            "Total: <br>" + number_format(pageTotal1, 2) + " L"
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        ajax: {
          url: "{{ route('refresh_deliveries') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: od_date_from,
            date_to: od_date_to
          }
        },
        processing: true,

        columns: [
          { data: "outboundTicket" },
          { data: "commodity_name" },
          { data: "destination" },
          { data: "name" },
          {
            data: "fname",
            render: function(data, type, full, meta) {
              return full.fname + " " + full.mname + " " + full.lname;
            }
          },
          { data: "plateno" },
          { data: "fuel_liters" },
          { data: "allowance" },
          { data: "kilos" },
          { data: "created_at" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $("#od_datepicker_to")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        maxDateFilter = new Date(date).getTime();
        //oTable.fnDraw();
        var dt = new Date(date);
        od_date_to =
          dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
        $("#deliverytable")
          .dataTable()
          .fnDestroy();
        deliveriestable = $("#deliverytable").DataTable({
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
              .column(7, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(7).footer()).html(
              "Total: <br>" + number_format(pageTotal1, 2) + " kg"
            );

            // Total over this page
            pageTotal1 = api
              .column(6, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(6).footer()).html(
              "Total: <br>" + number_format(pageTotal1, 2) + " L"
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8;
              }
            }
          ],
          paging: true,
          pageLength: 10,
          order: [],
          ajax: {
            url: "{{ route('refresh_deliveries') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: od_date_from,
              date_to: od_date_to
            }
          },
          processing: true,
          columns: [
            { data: "outboundTicket" },
            { data: "commodity_name" },
            { data: "destination" },
            { data: "name" },
            {
              data: "fname",
              render: function(data, type, full, meta) {
                return full.fname + " " + full.mname + " " + full.lname;
              }
            },
            { data: "plateno", name: "plateno" },
            { data: "fuel_liters", name: "fuel_liters" },
            { data: "kilos", name: "kilos" },
            { data: "allowance", name: "allowance" },
            { data: "created_at", name: "created_at" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      od_date_to = "";

      $("#deliverytable")
        .dataTable()
        .fnDestroy();
      deliveriestable = $("#deliverytable").DataTable({
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
            .column(7, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(7).footer()).html(
            "Total: <br>" + number_format(pageTotal1, 2) + " kg"
          );

          // Total over this page
          pageTotal1 = api
            .column(6, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(6).footer()).html(
            "Total: <br>" + number_format(pageTotal1, 2) + " L"
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
              modifier: {
                page: "current"
              }
            },
            customize: function(doc) {
              doc.styles.tableHeader.fontSize = 8;
              doc.styles.tableFooter.fontSize = 8;
              doc.defaultStyle.fontSize = 8;
            }
          }
        ],
        paging: true,
        pageLength: 10,
        order: [],
        ajax: {
          url: "{{ route('refresh_deliveries') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: od_date_from,
            date_to: od_date_to
          }
        },
        processing: true,
        columns: [
          { data: "outboundTicket" },
          { data: "commodity_name" },
          { data: "destination" },
          { data: "name" },
          {
            data: "fname",
            render: function(data, type, full, meta) {
              return full.fname + " " + full.mname + " " + full.lname;
            }
          },
          { data: "plateno" },
          { data: "fuel_liters" },
          { data: "kilos" },
          { data: "allowance" },
          { data: "created_at" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });
  //END OF DATE RANGE FILTER
  function refresh_delivery_table() {
    deliveriestable.ajax.reload(); //reload datatable ajax
  }

  $(document).on("click", ".open_od_modal", function() {
    $(".modal_title").text("Add Delivery");
    $("#button_action").val("add");
    $.ajax({
      url: "{{ route('refresh_id') }}",
      method: "get",
      data: { temp: "temp" },
      dataType: "json",
      success: function(data) {
        var t = 0;
        if (data[0].temp != null) {
          t = data[0].temp;
        }
        $("#driver_id")
          .val("")
          .trigger("change");
        $("#company")
          .val("")
          .trigger("change");
        $("#commodity")
          .val("")
          .trigger("change");
        $("#plateno")
          .val("")
          .trigger("change");
        var a = parseInt(t);
        var b = a + 1;
        var c = new Date();
        var twoDigitMonth =
          c.getMonth().length + 1 == 1
            ? c.getMonth() + 1
            : "0" + (c.getMonth() + 1);
        var currentDate = c.getFullYear() + twoDigitMonth + c.getDate();
        $("#ticket").val(currentDate + b);
        $("#od_modal").modal("show");
      }
    });
  });
  mainMouseDownOne();
  function mainMouseDownOne() {
    $("#add_delivery").one("click", function(event) {
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      event.preventDefault();
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "{{ route('add_delivery') }}",
        method: "POST",
        dataType: "text",
        data: $("#od_form").serialize(),
        success: function(data) {
          console.log(data);
          dataparsed = $.parseJSON(data);
          button.disabled = false;
          input.html("SAVE CHANGES");
          mainMouseDownOne();
          $("#driver_id")
            .val("")
            .trigger("change");
          $("#company")
            .val("")
            .trigger("change");
          $("#commodity")
            .val("")
            .trigger("change");
          if (dataparsed != "Success" && dataparsed != "Add") {
            swal(
              "Cash Reverted!",
              "Cash On Hand: ₱" + dataparsed.cashOnHand.toFixed(2),
              "success"
            );
            $("#curCashOnHand").html(dataparsed.cashOnHand.toFixed(2));
          }
          if (dataparsed == "Add") {
            swal("Success!", "Record has been added", "success");
          }
          if (dataparsed == "Success") {
            swal("Success!", "Record has been updated", "success");
          }
          $("#od_modal").modal("hide");
          refresh_delivery_table();
        },
        error: function(data) {
          mainMouseDownOne();
          button.disabled = false;
          input.html("SAVE CHANGES");
          swal("Oh no!", "Something went wrong, try again.", "error");
        }
      });
    });
  }

  $("#print_od").click(function(event) {
    event.preventDefault();
    $("#add_delivery").trigger("click");
    $("#print_form").trigger("click");
  });

  $("#print_form").click(function(event) {
    $("#ticket_clone").val($("#ticket").val());
    $("#commodity_clone").val($("#commodity option:selected").text());
    $("#destination_clone").val($("#destination").val());
    $("#driver_id_clone").val($("#driver_id option:selected").text());
    $("#company_clone").val($("#company option:selected").text());
    $("#plateno_clone").val($("#plateno option:selected").text());
    $("#liter_clone").val($("#liter").val());
    $("#kilos_clone").val($("#kilos").val());
    $("#allowance_clone").val($("#allowance").val());
  });

  $(document).on("click", ".update_delivery", function() {
    var id = $(this).attr("id");
    $.ajax({
      url: "{{ route('update_delivery') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        console.log("maoni", data);
        $("#button_action").val("update");
        $("#id").val(id);
        $("#ticket").val(data.outboundTicket);
        $("#destination").val(data.destination);
        $("#driver_id")
          .val(data.driver_id)
          .trigger("change");
        $("#company")
          .val(data.company_id)
          .trigger("change");
        $("#commodity")
          .val(data.commodity_id)
          .trigger("change");
        $("#plateno")
          .val(data.plateno)
          .trigger("change");
        $("#liter").val(data.fuel_liters);
        $("#kilos").val(data.kilos);
        $("#allowance").val(data.allowance);
        $("#od_modal").modal("show");
        $(".modal_title").text("Update Delivery");
        refresh_delivery_table();
      }
    });
  });

  $(document).on("click", ".delete_delivery", function() {
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
          url: "{{ route('delete_delivery') }}",
          method: "get",
          data: { id: id },
          success: function(data) {
            dataparsed = $.parseJSON(data);
            console.log(dataparsed);
            if (dataparsed != "success") {
              swal(
                "Cash Reverted!",
                "Cash On Hand: ₱" + dataparsed.cashOnHand.toFixed(2),
                "success"
              );
              $("#curCashOnHand").html(dataparsed.cashOnHand.toFixed(2));
            } else {
              swal("Success!", "Record has been Deleted", "success");
            }
            refresh_delivery_table();
          }
        });
      }
    });
  });
  //OUTBOUND DELIVERIES Datatable ends here

  $("#plateno").select2({
    dropdownParent: $("#od_modal"),
    placeholder: "Select a truck"
  });

  $("#driver_id").select2({
    dropdownParent: $("#od_modal"),
    placeholder: "Select a driver"
  });
  $("#commodity").select2({
    dropdownParent: $("#od_modal"),
    placeholder: "Select Commodity"
  });
  $("#company").select2({
    dropdownParent: $("#od_modal"),
    placeholder: "Select a company"
  });
});

</script>
@endsection