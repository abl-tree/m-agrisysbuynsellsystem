@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
<div class="container-fluid">
     <ul class="nav nav-tabs">
        <li class="active"><a href="#expense_tab" data-toggle="tab"><div class="block-header">
            <h2>Prices Table</h2>
        </div></a></li>
        <li><a href="#price_chart" data-toggle="tab" id="render"><div class="block-header">
            <h2>Prices Chart</h2>
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
                        <h2 class="modal_title">Add Price Update</h2>
                         
                    </div>
                    <div class="body">
                        <form action="#" class="form-horizontal " id="expense_form">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="button_action" id="button_action" value="">
                            <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="type">Commodity</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<select type="text" id="commodity" name="commodity_id" class="form-control" placeholder="Select Commodity" required style="width:100%;">
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
										<select type="text" id="company" name="company_id" class="form-control" placeholder="Select Company" required style="width:100%;">
											@foreach($company as $a)
											<option value="{{ $a->id }}">{{ $a->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="price">Price</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="price" name="price" class="form-control" placeholder="Enter Price Update"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="month">Date</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input name="date" id="month" class="date-picker form-control" style="width: 100%;" required/>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="month">Time</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <input class="date-picker form-control timepicker " name="time" id="time" required autocomplete="off" />
                                                </div>
                                            </div>
                                    </div>
                                </div>

                        </form>
                        <div class="row clearfix">
                            <div class="modal-footer">
                                <!-- <div class="print-only">
                                <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_expense') }}">
                                    <input type="hidden" id="expense_clone" name="expense_clone">
                                    <input type="hidden" id="type_clone" name="type_clone">
                                    <input type="hidden" id="amount_clone" name="amount_clone">
                                    <input type="hidden" id="trans_clone" name="trans_clone">
                                    <button class="btn btn-sm btn-icon print-icon" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                </form>
                                </div> -->
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
                    <h2>Price Update as of {{ date('Y-m-d ') }}</h2>
                    <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                            @if(canAddExpense())
                            <button type="button" style="display:''" class="btn bg-danger btn-xs waves-effect m-r-20 delete_item"  data-toggle="tooltip" data-placement="top" title="Update Data"><i class="material-icons">tune</i></button>
                            @endif
                        </li>
                        <li class="dropdown">
                            @if(canAddExpense())
                            <button type="button" style="display:none" class="btn bg-danger btn-xs waves-effect m-r-20 back_display" data-toggle="tooltip" data-placement="top" title="Back To Display"><i class="material-icons">navigate_before</i></button>
                            @endif
                        </li>
                        <li class="dropdown">
                            @if(canAddExpense())
                            <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20" data-toggle="modal" data-target="#expense_modal" ><i class="material-icons">library_add</i></button>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id ="expensetable" class="table table-bordered table-striped table-hover  ">
                            <thead>
                                <tr>
                                    <th  width="100" style="text-align:center;">Commodity</th>
                                    <th  width="100" style="text-align:center;">Company</th>
                                    <th  width="100" style="text-align:center;">Price</th>
                                    <th  width="100" style="text-align:center;">Date</th>
                                    <th  width="100" style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
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


<div id="price_chart" class="tab-pane fade">
     <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Graph</h2>
                    <div class="row clearfix">
								<div class="col-lg-2 col-md-12 col-sm-4 col-xs-5 form-control-label">
									<label for="type">Company</label>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<select multiple="multiple" type="text" id="companyList" name="company_id" class="form-control"  required style="width:100%;">
											@foreach($company as $a)
											<option value="{{ $a->id }}">{{ $a->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
                <div class="col-lg-2 col-md-12 col-sm-4 col-xs-5 form-control-label">
									<label for="type">Commodity</label>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<select type="text" id="commodityList" name="commodity_id" class="form-control" placeholder="Select Company" required style="width:100%;">
											@foreach($commodity as $a)
											<option value="{{ $a->id }}">{{ $a->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    <canvas id="myChart" class="chartjs" width="770" height="360" style="display: block; width: 770px; height: 385px;"></canvas>
                    </div>
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
var commodity_id=null;
var company_id=null;
document.title = "{{ env('APP_NAME') }} - Expenses";

$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});

$(document).ready(function() {

  var dataArray=[];
  var priceList=[];
  var items=[];
  var ctx = document.getElementById('myChart');
  var myChart = new Chart(ctx);
  commodity_id=$("#commodityList").val();
$(".delete_item").click(function () {
    $(".delete_item").css("display","none");
    $(".back_display").css("display","");
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
      url: "{{ route('getPrices') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
            all_data: true,
          }
    },
    processing: true,
    columns: [
      { data: "commodity" },
      { data: "company" },
      { data: "price" },
      { data: "date" },
      { data: "action", orderable: false, searchable: false } 
    ]
  });
  });
$(".back_display").click(function () {
  $(".back_display").css("display","none");
  $(".delete_item").css("display","");
  $("#expensetable").dataTable().fnDestroy(); 
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
      url: "{{ route('getPrices') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
            all_data: "false",
          }
    },
    processing: true,
    columns: [
      { data: "commodity" },
      { data: "company" },
      { data: "price" },
      { data: "date" },
      { data: "action", orderable: false, searchable: false } 
    ]
  });
});

  $('#commodityList').on('change', function (e) {
    myChart.destroy();
    commodity_id=$("#commodityList").select2("val");
    $.ajax({
      url: "{{ route('getPriceList') }}",
      method: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data:{commodity_id:commodity_id,company_id:company_id},
      dataType: "json",
      success: function(data) {
        myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data['labels'],
            datasets: data['dataset']
        },
        options: {
            scales: {
                yAxes: [{
                  ticks: {
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return '₱ ' + value;
                    }
                }
                }],
                xAxes: [{
                type: 'time',
                time: {
                    unit: 'week',
                    tooltipFormat: 'll h:mm a',
                },
                distribution: 'series'
            }]
            }
        }
    });
       
      }
    });
   
  });

  function refresh_price_table() {
    expensetable.ajax.reload(); //reload datatable ajax
  }

  $(document).on("click", ".update_price", function() {
    var id = $(this).attr("id");
    $.ajax({
      url: "{{ route('update_price') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        let hours= data.date.split(" ");
        $("#expense_modal").modal("show");
        $("#button_action").val("update");
        $("#id").val(id);
        $("#company")
          .val(data.company_id)
          .trigger("change");
        $("#commodity")
          .val(data.commodity_id)
          .trigger("change");
        $("#price").val(data.price);
        $("#month").val(hours[0]);
        $("#time").val(hours[1]);
         
      }
    });
  });

  
  $(document).on("click", ".delete_price", function() {
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
          url: "{{ route('delete_price') }}",
          method: "get",
          data: { id: id },
          dataType: "json",
          success: function(data) {
            refresh_price_table();
          }
        });
        swal("Deleted!", "The record has been deleted.", "success");
      }
    });
  });
  
  $('#companyList').on('change', function (e) {
    myChart.destroy();
    company_id=$("#companyList").select2("val");
    $.ajax({
      url: "{{ route('getPriceList') }}",
      method: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data:{commodity_id:commodity_id,company_id:company_id},
      dataType: "json",
      success: function(data) {
       myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data['labels'],
            datasets: data['dataset']
        },
        options: {
            scales: {
                yAxes: [{
                  ticks: {
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                      return '₱ ' + value;
                    }
                }
                }],
                xAxes: [{
                type: 'time',
                time: {
                    unit: 'week',
                    tooltipFormat: 'll h:mm a',
                },
                distribution: 'series'
            }]
            }
        }
    });
       
      }
    });
   
  });
  
  $('.nav-tabs a[href="#price_chart"]').on('shown.bs.tab', function(event){
    myChart.destroy();
    if(commodity_id!==null&&company_id!==null)
    $.ajax({
      url: "{{ route('getPriceList') }}",
      method: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data:{commodity_id:commodity_id,company_id:company_id},
      dataType: "json",
      success: function(data) {
       myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data['labels'],
            datasets: data['dataset']
        },
        options: {
            scales: {
                yAxes: [{
                  ticks: {
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                      return '₱ ' + value;
                    }
                }
                }],
                xAxes: [{
                type: 'time',
                time: {
                    unit: 'week',
                    tooltipFormat: 'll h:mm a',
                },
                distribution: 'series'
            }]
            }
        }
    });
       
      }
    });
});


 $("#month").datepicker({
    changeMonth: true,
    changeYear: true,
    changeDay:true,
    showButtonPanel: true,
    dateFormat: "yy-mm-dd",
    beforeShow: function() {
      $(".ui-datepicker").css("font-size", 18);
    },
    onClose: function(dateText, inst) {
      $(this).datepicker(
        "setDate",
        new Date(inst.selectedYear, inst.selectedMonth,inst.selectedDay)
      );
    }
  });

  $('.timepicker').timepicker({
    zindex: 9999999,
    timeFormat: 'hh:mm:ss p',
    interval: 1,
    minTime: '1',
    maxTime: '22',
    // defaultTime: hourNow,
    startTime: '01:00',
    dynamic: true,
    dropdown: true,
    scrollbar: false
});
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
      url: "{{ route('getPrices') }}",
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
    columns: [
      { data: "commodity" },
      { data: "company" },
      { data: "price" },
      { data: "date" },
      { data: "action", orderable: false, searchable: false } 
    ]
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
    $(".modal_title").text("Add Price Update");
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
        url: "{{ route('add_price')}}",
        dataType: "text",
        data: $("#expense_form").serialize(),
        success: function(data) {
          swal("Success!", "Record has been added to database", "success");
          $("#expense_modal").modal("hide");
          mainMouseDownOne();
          button.disabled = false;
          input.html("SAVE CHANGES");
          $(".modal_title").text("Add Price Update");
          refresh_expense_table();
        },
        error: function(data) {
          mainMouseDownOne();
          swal("Oh no!", "Something went wrong, try again.", "error");
          button.disabled = false;
          input.html("SAVE CHANGES");
          $(".modal_title").text("Add Price Update");
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
  $("#commodity").select2({
    dropdownParent: $("#expense_modal"),
    placeholder: "Select Commodity"
  });

  $("#company").select2({
    dropdownParent: $("#expense_modal"),
    placeholder: "Select Company"
  });

  $("#companyList").select2({
    // dropdownParent: $("#expense_modal"),
    placeholder: "Company"
  });
  $("#commodityList").select2({
    // dropdownParent: $("#expense_modal"),
    placeholder: "Select Commodity"
  });

  if (window.location.hash) {
    $('.nav-tabs li a[href="' + window.location.hash + '"]').tab("show");
  }
});

</script>
@endsection
