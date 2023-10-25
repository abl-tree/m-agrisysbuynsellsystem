@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Company Dashboard</h2>
        </div>
    </div>
    <div class="modal fade" id="company_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2 class="modal_title">Add Company</h2>
                    </div>
                    <div class="body">
                        <form class="form-horizontal " id="company_form">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="button_action" id="button_action" value="">
                            
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Company</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter company name"  required>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <button type="submit" id="add_company" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>List of companies as of {{ date('Y-m-d ') }}</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 open_company_modal" data-toggle="modal" data-target="#company_modal"><i class="material-icons">library_add</i></button>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="companytable" class="table table-bordered table-striped table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
@endsection

@section('script')
<script>
$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});

$(document).ready(function() {
  document.title = "{{ env('APP_NAME') }} - Companies";

  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });

  //COMPANY Datatable starts here
  $("#company_modal").on("hidden.bs.modal", function(e) {
    $(this)
      .find("input,textarea,select")
      .val("")
      .end()
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
  });

  var companytable = $("#companytable").DataTable({
    dom: "Blfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    buttons: [
      {
        extend: "print",
        exportOptions: {
          columns: [0],
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
          columns: [0],
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

    ajax: "{{ route('refresh_company') }}",
    columns: [
      { data: "name", name: "name" },
      { data: "action", orderable: false, searchable: false }
    ]
  });

  function refresh_company_table() {
    companytable.ajax.reload(); //reload datatable ajax
  }

  //Open Company Modal
  $(document).on("click", ".open_company_modal", function() {
    $(".modal_title").text("Add Company");
    $("#button_action").val("add");
  });

  //Add Company
  $(document).on("submit", "#company_form", function(event) {
    event.preventDefault();
    var data = $(this).serialize();
    var input = $("#add_company");
    var button = $("#add_company");
    button.disabled = true;
    input.html("SAVING...");
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "{{ route('add_company') }}",
      method: "POST",
      dataType: "json",
      data: data,
      success: function(data) {
        button.disabled = false;
        input.html("SAVE CHANGES");
        swal("Success!", "Record has been added to database", "success");
        $("#company_modal").modal("hide");
        refresh_company_table();
      },
      error: function(err) {
        if (err.statusText === "abort") return;
        var errorMessage = "";

        $.each(err.responseJSON.errors, function(key, val) {
          errorMessage += "<li>" + val[0] + "</li>";
        });

        const wrapper = document.createElement("div");
        wrapper.innerHTML = errorMessage;

        swal({
          title: "Something went wrong!",
          content: wrapper,
          icon: "error"
        });

        button.disabled = false;
        input.html("SAVE CHANGES");
      }
    });
  });

  //Update Company
  $(document).on("click", ".update_company", function() {
    var id = $(this).attr("id");
    $.ajax({
      url: "{{ route('update_company') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#button_action").val("update");
        $("#id").val(id);
        $("#name").val(data.name);
        $("#company_modal").modal("show");
        $(".modal_title").text("Update Company");
        refresh_company_table();
      }
    });
  });

  //Delete Company
  $(document).on("click", ".delete_company", function() {
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
          url: "{{ route('delete_company') }}",
          method: "get",
          data: { id: id },
          success: function(data) {
            refresh_company_table();
          }
        });
        swal("Deleted!", "The record has been deleted.", "success");
      }
    });
  });
  //COMPANY Datatable ends here
});

</script>
@endsection