@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')

<div class="modal fade" id="balancemodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2 class="modal_title">Add Payment</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <button id="print_balance_payment" type="button" class="btn btn-sm btn-icon print-icon"><i
                                    class="glyphicon glyphicon-print"></i></button>
                        </li>
                        <li class="dropdown">
                            <!-- <form method="POST" id="printBalanceForm" name="printBalanceForm" target="_blank" action="{{ route('print_balance_payment') }}">
                                <input type="hidden" id="customer_id1_clone" name="customer_id1_clone">
                                <input type="hidden" id="paymentmethod_clone" name="paymentmethod_clone">
                                <input type="hidden" id="checknumber_clone" name="checknumber_clone">
                                <input type="hidden" id="amount1_clone" name="amount1_clone">
                                <input type="hidden" id="balance2_clone" name="balance2_clone">
                                <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_balance_form" id="print_balance_form" title="PRINT ONLY"><i class="glyphicon glyphicon-print"></i></button>
                            </form> -->
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <form class="form-horizontal " id="balanceform">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="button_action" id="button_action" value="">

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div id="c1" class="form-line">
                                        <select type="text" id="customer_id1" name="customer_id1" class="form-control"
                                            required style="width: 100%;">
                                            @foreach($customer as $a)

                                            <option value="{{ $a->id }}">{{ $a->lname.", ".$a->fname." ".$a->mname}}
                                            </option>
                                            @endforeach
                                        </select>
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
                                        <select type="text" id="paymentmethod" name="paymentmethod" class="form-control"
                                            required style="width: 100%;">

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
                                        <input type="text" id="checknumber" name="checknumber" class="form-control">
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
                                        <input type="number" id="amount1" min="0" name="amount1" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Balance</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="balance2" name="balance2" readonly="readonly"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Remaining Balance</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="r_balance" name="r_balance" readonly="readonly"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="row clearfix">
                        <div class="modal-footer">
                            <div class="print-only">
                                <form method="POST" id="printBalanceForm" name="printBalanceForm" target="_blank"
                                    action="{{ route('print_balance_payment') }}">
                                    <input type="hidden" id="customer_id1_clone" name="customer_id1_clone">
                                    <input type="hidden" id="paymentmethod_clone" name="paymentmethod_clone">
                                    <input type="hidden" id="checknumber_clone" name="checknumber_clone">
                                    <input type="hidden" id="amount1_clone" name="amount1_clone">
                                    <input type="hidden" id="balance2_clone" name="balance2_clone">
                                    <input type="hidden" id="r_balance_clone" name="r_balance_clone">
                                    <button class="btn btn-sm btn-icon print-icon" type="submit"
                                        name="print_balance_form" id="print_balance_form" title="PRINT ONLY">PRINT
                                        ONLY</button>
                                </form>
                            </div>
                            <button type="submit" id="add_balance" class="btn btn-link waves-effect">SAVE
                                CHANGES</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ca_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2 class="modal_title">Add Cash Advance</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <button id="print_ca" type="button" class="btn btn-sm btn-icon print-icon"><i
                                    class="glyphicon glyphicon-print"></i></button>
                        </li>
                        <li class="dropdown">
                            <!-- <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_ca') }}">
                                <input type="hidden" id="customer_id_clone" name="customer_id_clone">
                                <input type="hidden" id="reason_clone" name="reason_clone">
                                <input type="hidden" id="amount_clone" name="amount_clone">
                                <input type="hidden" id="balance_clone" name="balance_clone">
                                <input type="hidden" id="month_clone" name="month_clone">
                                <input type="hidden" id="received_clone" name="received_clone">
                                <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                            </form> -->
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" id="homeclick" href="#home">Customer Cash Advance</a>
                        </li>
                        <li><a data-toggle="tab" id="homeclick1" href="#home1">Walk-in Cash Advance</a></li>
                    </ul>
                    <div class="clearfix"></div>
                    <br>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <form class="form-horizontal " id="ca_form">
                                <input type="hidden" name="id_ca" id="id_ca" value="">
                                <input type="hidden" name="button_action_ca" id="button_action_ca" value="">

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div id="c" class="form-line">
                                                <select type="text" id="customer_id" name="customer_id"
                                                    class="form-control" required style="width: 100%;">
                                                    @foreach($customer as $a)
                                                    <option></option>
                                                    <option value="{{ $a->id }}">
                                                        {{ $a->lname.", ".$a->fname." ".$a->mname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="name">Reason</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="reason" name="reason" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="name">Amount</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" id="amount" min="0" name="amount"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="month">To be paid on</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input name="month" id="month" class="date-picker form-control"
                                                    style="width: 100%;" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="received">Received by</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="received" name="received" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="name">Balance</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" id="balance" name="balance" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <div class="print-only">
                                        <form method="POST" id="printForm" name="printForm" target="_blank"
                                            action="{{ route('print_ca') }}">
                                            <input type="hidden" id="customer_id_clone" name="customer_id_clone">
                                            <input type="hidden" id="reason_clone" name="reason_clone">
                                            <input type="hidden" id="amount_clone" name="amount_clone">
                                            <input type="hidden" id="balance_clone" name="balance_clone">
                                            <input type="hidden" id="month_clone" name="month_clone">
                                            <input type="hidden" id="received_clone" name="received_clone">
                                            <button class="btn btn-sm btn-icon print-icon print-only" type="submit"
                                                name="print_form1" id="print_form1" title="PRINT ONLY">PRINT
                                                ONLY</button>
                                        </form>
                                    </div>
                                    <button type="submit" id="add_cash_advance" class="btn btn-link waves-effect">SAVE
                                        CHANGES</button>
                                    <button type="button" class="btn btn-link waves-effect"
                                        data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </div>
                        <div id="home1" class="tab-pane fade in ">
                            <form class="form-horizontal " id="ca_form1">

                                <input type="hidden" name="stat" id="stat" value="old">
                                <input type="hidden" name="button_action" id="button_action" value="">


                                <div class="row clearfix" style="margin-left:5%;">
                                    <div class="col-lg-4">
                                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <label for="name">First Name</label>
                                                <div class="form-line">
                                                    <input type="text" id="fname" name="fname" class="form-control"
                                                        placeholder="First" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <label for="name">Middle Name</label>
                                                <div class="form-line">
                                                    <input type="text" id="mname" name="mname" class="form-control"
                                                        placeholder="Middle" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <label for="name">Last Name</label>
                                                <div class="form-line">
                                                    <input type="text" id="lname" name="lname" value=""
                                                        class="form-control" placeholder="Last" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="lname">Address</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="address" name="address" class="form-control"
                                                    placeholder="Enter customer's address">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="lname">Reason</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="reason1" name="reason1" class="form-control"
                                                    placeholder="Enter customer's reason">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="lname">Contacts</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" id="contacts" name="contacts" class="form-control"
                                                    placeholder="Enter customer's contact number">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="lname">Amount</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" id="bal" name="bal" class="form-control"
                                                    placeholder="Enter customer's cash advance">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="month1">To be paid on</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input name="month1" id="month1" class="date-picker form-control"
                                                    style="width: 100%;" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="received1">Received by</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="received1" name="received1" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <div class="print-only">
                                        <form method="POST" id="printForm" name="printForm" target="_blank"
                                            action="{{ route('print_ca') }}">
                                            <input type="hidden" id="customer_id2_clone" name="customer_id2_clone">
                                            <input type="hidden" id="reason2_clone" name="reason2_clone">
                                            <input type="hidden" id="amount2_clone" name="amount2_clone">
                                            <input type="hidden" id="balance2_clone" name="balance2_clone">
                                            <input type="hidden" id="r_balance_clone" name="r_balance_clone">
                                            <input type="hidden" id="month2_clone" name="month2_clone">
                                            <input type="hidden" id="received2_clone" name="received2_clone">
                                            <button class="btn btn-sm btn-icon print-icon print-only" type="submit"
                                                name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                        </form>
                                    </div>
                                    <button type="submit" id="add_cash_advance1" class="btn btn-link waves-effect">SAVE
                                        CHANGES</button>
                                    <button type="button" class="btn btn-link waves-effect"
                                        data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ca_view_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="row">
            <div class="card">
                <div class="header">
                    <h2> Cash Advance - <span class="modal_title_ca"></span> as of {{ date('Y-m-d ') }}</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <br>
                        <table id="view_cash_advancetable" class="table table-bordered table-striped table-hover"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Reason</th>
                                    <th>Amount</th>
                                    <th>Date/Time</th>
                                    <th>Status</th>
                                    <th>Released By</th>
                                    <th>Releasing</th>
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
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="balance_view_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="row">
            <form class="form-horizontal " id="ca_view_form">
                <div class="card">
                    <div class="header">
                        <h2> Payment History <span class="modal_title_balance"></span> as of {{ date('Y-m-d ') }}</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <br>
                            <table id="view_balancetable" class="table table-bordered table-striped table-hover"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Check Number</th>
                                        <th>Status</th>
                                        <th>Received By</th>
                                        <th>Action</th>
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
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <ul class="nav nav-tabs">
        <li id="ca1" class="active"><a id="cahref" data-toggle="tab" href="#cashadvance1">
                <div class="block-header">
                    <h2>Cash Advance</h2>
                </div>
            </a> </li>
        <li id="bal1"><a id="balancehref" data-toggle="tab" href="#balance1">
                <div class="block-header">
                    <h2>Balances</h2>
                </div>
            </a></li>
    </ul>



    <div class="tab-content">
        <!-- Add Cash Advance Modal -->
        <div id="cashadvance1" class="tab-pane fade in active">
            <!-- View Person Cash Advances Modal -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>List of cash advances as of {{ date('Y-m-d ') }}</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    @if(isAdmin() || isPurchaser())
                                    <button type="button"
                                        class="btn bg-grey btn-xs waves-effect m-r-20 open_ca_modal"><i
                                            class="material-icons">library_add</i></button>
                                    @endif()
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <br>
                                <table id="cash_advancetable" class="table table-bordered table-striped table-hover"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>mname</th>
                                            <th>lname</th>
                                            <th>Recent Amount</th>
                                            <th>Latest Date/Time</th>
                                            <th>Total Balance</th>
                                            <th width="90">View History</th>
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
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="balance1" class="tab-pane fade in">


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>List of Customer Balance as of {{ date('Y-m-d ') }}</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    @if(isAdmin() || isPurchaser())
                                    <button type="button" id="balancebutton"
                                        class="btn bg-grey btn-xs waves-effect m-r-20 open_balancemodal"><i
                                            class="material-icons">chrome_reader_mode</i></button>
                                    @endif()
                                </li>
                            </ul>

                        </div>
                        <div class="body">
                            <div>
                                <h5>Advance Filter</h5>
                                <select style="width: 150px;" type="text" id="commodityfilter" name="commodityfilter"
                                    data-placeholder="Select Commodity">
                                    <option value="has">Has Balance</option>
                                    <option value="receive">To Receive</option>
                                    <option value="all">All</option>

                                </select>
                            </div>
                            <div class="table-responsive">
                                <br>
                                <table id="balancetable" class="table table-bordered table-striped table-hover"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Total Balance</th>
                                            <th>Latest Transaction</th>
                                            <th width="90">View History</th>
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
    </div>
</div>
@endsection

@section('script')
<script>
    var print_checker = "";
    var selectedFilter=" "
$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});
$("#homeclick").on("click", function() {
  $("#stat").val("old");
  //$('#stat1').val("old");

  print_checker = "old";
});

$("#homeclick1").on("click", function() {
  $("#stat").val("new");
  //$('#stat1').val("new");

  print_checker = "new";
});

$(document).ready(function() {
   
  $("#commodityfilter").select2({
    placeholder: "Select Filter"
  });
  document.title = "{{ env('APP_NAME') }} - Cash Advance";

  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });

  //CASH ADVANCE datatable starts here
  $("#ca_modal").on("hidden.bs.modal", function(e) {
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

  var cash_advancetable = $("#cash_advancetable").DataTable({
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
        .column(3, {
          page: "current"
        })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(3).footer()).html(
        "Total: <br>₱" + number_format(pageTotal, 2)
      );

      // Total over this page
      pageTotal1 = api
        .column(5, {
          page: "current"
        })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(5).footer()).html(
        "Total: <br>₱" + number_format(pageTotal1, 2)
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
          columns: [0, 3, 4, 5],
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
          columns: [0, 3, 4, 5],
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
    ajax: "{{ route('refresh_cashadvance') }}",
    columns: [
      {
        data: "wholename"
      },
      {
        data: "mname",
        name: "customer.mname",
        visible: false
      },
      {
        data: "lname",
        name: "customer.lname",
        visible: false
      },
      {
        data: "amount",
        name: "amount"
      },
      {
        data: "created_at",
        name: "created_at"
      },
      {
        data: "balance",
        name: "balance"
      },
      {
        data: "action",
        orderable: false,
        searchable: false
      }
    ]
  });

  $("#commodityfilter").on("change", function(e) {
    selectedFilter = this.value;
    if (selectedFilter == "has") {
        query= "{{ route('hasbalance') }}"
    }else if(selectedFilter == "all"){
      query= "{{ route('refresh_balancedt') }}"
    }else{
      query= "{{ route('toReceive') }}"
    }
      $("#balancetable")
        .dataTable()
        .fnDestroy();
      balancetable = $("#balancetable").DataTable({
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
            .column(1, {
              page: "current"
            })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(1).footer()).html(
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
            exportOptions: {
              columns: [0, 1],
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
              columns: [0, 1],
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
        "order": [[2,"desc"]],
        ajax: query,
        columns: [
          {
            data: "fname",
            render: function(data, type, full, meta) {
              return full.lname + ", " + full.fname + " " + full.lname.charAt(0);
            }
          },
          {
            data: "balance",
            name: "balance",
            orderable: true,
            
          },
          {
          data: "maxdate",
          name: "maxdate",
          orderable: true,
          },
          {
            data: "action",
            orderable: false,
            searchable: false
          }
        ],
       

      });

  });

  var balancetable = $("#balancetable").DataTable({
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
        .column(1, {
          page: "current"
        })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(1).footer()).html(
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
        exportOptions: {
          columns: [0, 1],
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
          columns: [0, 1],
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
    "order": [[2,"desc"]],
    ajax: "{{ route('hasbalance') }}",
    columns: [
      {
        data: "fname",
        render: function(data, type, full, meta) {
          return full.lname + ", " + full.fname + " " + full.lname.charAt(0);
        }
      },
      {
        data: "balance",
        name: "balance"
      },
      {
        data: "maxdate",
        name: "maxdate",
        orderable: true,
      },
      {
        data: "action",
        orderable: false,
        searchable: false
      }
    ]
  });

  function refresh_cash_advance_table() {
    cash_advancetable.ajax.reload(); //reload datatable ajax
  }

  function refresh_balance_table() {
    balancetable.ajax.reload(); //reload datatable ajax
  }
  $("#balancehref").on("click", function() {
    refresh_balance_table();
  });
  $("#cahref").on("click", function() {
    refresh_cash_advance_table();
  });

  $(document).on("click", ".open_ca_modal", function() {
    $("#c").removeClass("focused");
    $("#customer_id")
      .val("")
      .trigger("change");
    $("#reason")
      .val("")
      .trigger("change");
    $("#amount")
      .val("")
      .trigger("change");
    $("#balance")
      .val("")
      .trigger("change");
    $("#ca_modal").modal("show");
    $("#homeclick1").show();
    $("#homeclick").trigger("click");
    $(".modal_title").text("Add Cash Advance");
  });
 
  $(document).on("click", ".open_balancemodal", function() {
    $("#pm").removeClass("focused");
    $("#c1").removeClass("focused");
    $("#customer_id1")
      .val("")
      .trigger("change");
    $("#paymentmethod")
      .val("")
      .trigger("change");
    $("#reason")
      .val("")
      .trigger("change");
    $("#amount")
      .val("")
      .trigger("change");
    $("#balance")
      .val("")
      .trigger("change");
    $(".modal_title").text("Add Payment");
    $("#balancemodal").modal("show");
  });

  //check balance of customer
  $("#customer_id1").change(function() {
    var id = $(this).val();
    $.ajax({
      url: "{{ route('check_balance') }}",
      method: "get",
      data: {
        id: id
      },
      dataType: "json",
      success: function(data) {
        if (!$.trim(data)) {
          $("#balance2").val(0.0);
        } else {
          $("#balance2").val(data[0].balance);
        }
      }
    });
  });

  $("#amount1").blur(function() {
    var balance = $("#balance2").val();
    var amount = $("#amount1").val();
    $("#r_balance").val(balance - amount);
  });

  //check balance of customer
  $("#customer_id").change(function() {
    var id = $(this).val();
    $.ajax({
      url: "{{ route('check_balance') }}",
      method: "get",
      data: {
        id: id
      },
      dataType: "json",
      success: function(data) {
        if (!$.trim(data)) {
          $("#balance").val(0.0);
        } else {
          $("#balance").val(data[0].balance);
        }
      }
    });
  });
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

  mainMouseDownOne();

  function mainMouseDownOne() {
    $("#add_cash_advance1").one("click", function(event) {
      event.preventDefault();
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "{{ route('add_cashadvance') }}",
        method: "POST",
        dataType: "text",
        data: $("#ca_form1").serialize(),
        success: function(data) {
          mainMouseDownOne();
          button.disabled = false;
          input.html("SAVE CHANGES");
          $("#customer_id")
            .val("")
            .trigger("change");
          $("#reason")
            .val("")
            .trigger("change");
          $("#amount")
            .val("")
            .trigger("change");
          $("#balance")
            .val("")
            .trigger("change");
          swal("Success!", "Record has been added to database", "success");
          $("#ca_modal").modal("hide");
          refresh_cash_advance_table();
          $.ajax({
            url: "{{ route('refresh_view_cashadvance') }}",
            method: "get",
            data: {
              id: person_id
            },
            dataType: "json",
            success: function(data) {
              $.ajax({
                url: "{{ route('getCustomer') }}",
                method: "get",
                data: {
                  id: person_id
                },
                dataType: "json",
                success: function(data) {
                  $(".modal_title_ca").text(
                    data.fname + " " + data.mname + " " + data.lname
                  );
                }
              });
              cash_advance_release = $("#view_cash_advancetable").DataTable({
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
                    .column(1, {
                      page: "current"
                    })
                    .data()
                    .reduce(function(a, b) {
                      return intVal(a) + intVal(b);
                    }, 0);

                  // Update footer
                  $(api.column(1).footer()).html(
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
                    exportOptions: {
                      columns: [0, 1, 2, 3, 4],
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
                      columns: [0, 1, 2, 3, 4],
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
                order: [[2, "desc"]],
                bDestroy: true,
                data: data.data,
                columns: [
                  {
                    data: "reason",
                    name: "reason"
                  },
                  {
                    data: "amount",
                    name: "amount"
                  },
                  {
                    data: "created_at",
                    name: "created_at"
                  },
                  {
                    data: "status",
                    name: "status"
                  },
                  {
                    data: "released_by",
                    name: "released_by"
                  },
                  {
                    data: "action",
                    orderable: false,
                    searchable: false
                  }
                ]
              });
            }
          });
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

  mainMouseDownOne2();

  function mainMouseDownOne2() {
    $("#add_cash_advance").one("click", function(event) {
      event.preventDefault();
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "{{ route('add_cashadvance') }}",
        method: "POST",
        dataType: "text",
        data: $("#ca_form").serialize(),
        success: function(data) {
          mainMouseDownOne2();
          button.disabled = false;
          input.html("SAVE CHANGES");
          $("#customer_id")
            .val("")
            .trigger("change");
          $("#reason")
            .val("")
            .trigger("change");
          $("#amount")
            .val("")
            .trigger("change");
          $("#balance")
            .val("")
            .trigger("change");
          swal("Success!", "Record has been added to database", "success");
          $("#ca_modal").modal("hide");
          if (data) {
            // if Released
            $("#curCashOnHand").html(parseFloat(data).toFixed(2));
          }
          refresh_cash_advance_table();
          $.ajax({
            url: "{{ route('refresh_view_cashadvance') }}",
            method: "get",
            data: {
              id: person_id
            },
            dataType: "json",
            success: function(data) {
              $.ajax({
                url: "{{ route('getCustomer') }}",
                method: "get",
                data: {
                  id: person_id
                },
                dataType: "json",
                success: function(data) {
                  $(".modal_title_ca").text(
                    data.fname + " " + data.mname + " " + data.lname
                  );
                }
              });
              cash_advance_release = $("#view_cash_advancetable").DataTable({
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
                    .column(1, {
                      page: "current"
                    })
                    .data()
                    .reduce(function(a, b) {
                      return intVal(a) + intVal(b);
                    }, 0);

                  // Update footer
                  $(api.column(1).footer()).html(
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
                    exportOptions: {
                      columns: [0, 1, 2, 3, 4],
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
                      columns: [0, 1, 2, 3, 4],
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
                order: [[2, "desc"]],
                bDestroy: true,
                data: data.data,
                columns: [
                  {
                    data: "reason",
                    name: "reason"
                  },
                  {
                    data: "amount",
                    name: "amount"
                  },
                  {
                    data: "created_at",
                    name: "created_at"
                  },
                  {
                    data: "status",
                    name: "status"
                  },
                  {
                    data: "released_by",
                    name: "released_by"
                  },
                  {
                    data: "action",
                    orderable: false,
                    searchable: false
                  }
                ]
              });
              //$('#ca_view_modal').modal('show');
            }
          });
        },
        error: function(data) {
          mainMouseDownOne2();
          swal("Oh no!", "Something went wrong, try again.", "error");
          button.disabled = false;
          input.html("SAVE CHANGES");
        }
      });
    });
  }

  $("#add_balance").click(function(event) {
    event.preventDefault();
    event.stopPropagation();
    var input = $(this);
    var button = this;
    button.disabled = true;
    input.html("SAVING...");
    if (parseFloat($("#amount1").val()) > parseFloat($("#balance2").val())) {
      swal("Hold on!", "Payment more than balance.", "warning");
      button.disabled = false;
      input.html("SAVE CHANGES");
      return;
    }
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "{{ route('add_payment') }}",
      method: "POST",
      dataType: "text",
      data: $("#balanceform").serialize(),
      success: function(data) {
        var data2 = JSON.parse(data);
        button.disabled = false;
        input.html("SAVE CHANGES");
        $("#customer_id1")
          .val("")
          .trigger("change");
        $("#paymentmethod")
          .val("")
          .trigger("change");
        $("#amount1").val("");
        $("#checknumber").val("");
        $("#balance2").val("");
        $("#r_balance").val("");
        $("#balancemodal").modal("hide");
        // if(data2.user==1){
        //     swal("Payment Success!", "Cash on Hand: ₱"+data2.cashOnHand.toFixed(2)+" | Transaction ID: "+data2.cashHistory, "success")
        // $('#curCashOnHand').html(data2.cashOnHand.toFixed(2));
        //     refresh_cash_advance_table();
        //     refresh_balance_table();
        // }else if(data2.user!=1){
        //     swal("Payment Success!", "Payment Received By the Admin.", "success")
        //     refresh_cash_advance_table();
        //     refresh_balance_table();
        // }
        swal("Payment Success!", "Payment Added.", "success");
        refresh_cash_advance_table();
        refresh_balance_table();
      },
      error: function(data) {
        swal("Oh no!", "Something went wrong, try again.", "error");
        button.disabled = false;
        input.html("SAVE CHANGES");
      }
    });
  });

  //        $("#add_balance").one('click',function(event){
  //        event.preventDefault();
  //        var input = $(this);
  //        var button =this;
  //        button.disabled = true;
  //        input.html('SAVING...');
  //        if(parseFloat($("#amount1").val()) > parseFloat($("#balance2").val())){
  //             swal("Hold on!", "Payment more than balance.", "warning");
  //             button.disabled = false;
  //             input.html('SAVE CHANGES');
  //             return;
  //        }
  //        $.ajax({
  //            headers: {
  //                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //            },
  //            url: "{{ route('add_payment') }}",
  //            method: 'POST',
  //            dataType: 'text',
  //            data: $('#balanceform').serialize(),
  //            success:function(data){
  //             var data2= JSON.parse(data);
  //                 button.disabled = false;
  //                 input.html('SAVE CHANGES');
  //                 $("#customer_id1").val('').trigger('change');
  //                 $("#paymentmethod").val('').trigger('change');
  //                 $("#amount1").val('');
  //                 $("#checknumber").val('');
  //                 $("#balance2").val('');
  //                 $('#balancemodal').modal('hide');
  //                 swal("Payment Success!", "Payment Added.", "success")
  //                 refresh_cash_advance_table();
  //                 refresh_balance_table();
  //            },
  //            error: function(data){
  //                 swal("Oh no!", "Something went wrong, try again.", "error");
  //                 button.disabled = false;
  //                 input.html('SAVE CHANGES');
  //             }
  //        });
  //    });

  $(document).on("click", ".delete_customer_payment", function(event) {
    var ObjData;
    event.preventDefault();
    var id = $(this).attr("id");
    swal({
      title: "Delete this Payment?",
      text: "",
      icon: "warning",
      buttons: true
    }).then(willDelete => {
      if (willDelete) {
        $.ajax({
          url: "{{ route('delete_cutomer_payment') }}",
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            id: id
          },
          dataType: "text",
          success: function(data) {
            var data2 = JSON.parse(data);
            if (data2.cashOnHand != null) {
              swal(
                "Amount Reverted : ₱" +
                  data2.amount
                    .toFixed(2)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                "Remaining Money: ₱" +
                  data2.cashOnHand
                    .toFixed(2)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                  " | Transaction ID: " +
                  data2.cashHistory,
                "success"
              );
              $("#curCashOnHand").html(
                data2.cashOnHand
                  .toFixed(2)
                  .toString()
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
              );
            } else {
              swal(
                "Payment Deleted!",
                "Successfully deleted a payment.",
                "success"
              );
            }
            refresh_balance_table();
            $.ajax({
              url: "{{ route('balancelogs') }}",
              method: "get",
              data: {
                id: person_id
              },
              dataType: "json",
              success: function(data) {
                $("#view_balancetable").DataTable({
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
                      .column(1, {
                        page: "current"
                      })
                      .data()
                      .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                      }, 0);

                    // Update footer
                    $(api.column(1).footer()).html(
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
                      exportOptions: {
                        columns: [0, 1, 2, 3],
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
                        columns: [0, 1, 2, 3],
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
                  order: [[0, "desc"]],
                  bDestroy: true,
                  data: data.data,
                  columns: [
                    {
                      data: "created_at",
                      name: "created_at"
                    },
                    {
                      data: "paymentamount",
                      name: "paymentamount"
                    },
                    {
                      data: "paymentmethod",
                      name: "paymentmethod"
                    },
                    {
                      data: "checknumber",
                      name: "checknumber"
                    },
                    {
                      data: "status",
                      name: "status"
                    },
                    {
                      data: "received_by",
                      name: "received_by"
                    },
                    {
                      data: "action",
                      name: "action"
                    }
                  ]
                });
              }
            });
          }
        });
      }
    });
  });

  $(document).on("click", ".receive_payment_customer", function(event) {
    var ObjData;
    event.preventDefault();
    var id = $(this).attr("id");
    swal({
      title: "Receive Payment?",
      text: "",
      icon: "warning",
      buttons: true
    }).then(willDelete => {
      if (willDelete) {
        $.ajax({
          url: "{{ route('receive_payment_customer') }}",
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            id: id
          },
          dataType: "text",
          success: function(data) {
            var query='';
            if(selectedFilter=="has"){
                query="{{route('hasbalance')}}"
            }else{
                query="{{route('refresh_balancedt')}}"
            }
            $("#balancetable")
              .dataTable()
              .fnDestroy();
            balancetable = $("#balancetable").DataTable({
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
                  .column(1, {
                    page: "current"
                  })
                  .data()
                  .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                  }, 0);

                // Update footer
                $(api.column(1).footer()).html(
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
                  exportOptions: {
                    columns: [0, 1],
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
                    columns: [0, 1],
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
              "order": [[2,"desc"]],
              ajax: query,
              columns: [
                {
                  data: "fname",
                  render: function(data, type, full, meta) {
                    return full.lname + ", " + full.fname + " " + full.lname.charAt(0);
                  }
                },
                {
                  data: "balance",
                  name: "balance",
                  orderable: true,
                  
                },
                {
                data: "maxdate",
                name: "maxdate",
                orderable: true,
                },
                {
                  data: "action",
                  orderable: false,
                  searchable: false
                }
              ],
            

            });
            var data2 = JSON.parse(data);
            swal(
              "Amount Received : ₱" +
                data2.amount
                  .toFixed(2)
                  .toString()
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ","),
              "Current Cash: ₱" +
                data2.cashOnHand
                  .toFixed(2)
                  .toString()
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                " | Transaction ID: " +
                data2.cashHistory,
              "success"
            );
            $("#curCashOnHand").html(
              data2.cashOnHand
                .toFixed(2)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            );

            $.ajax({
              url: "{{ route('balancelogs') }}",
              method: "get",
              data: {
                id: person_id
              },
              dataType: "json",
              success: function(data) {
                $("#view_balancetable").DataTable({
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
                      .column(1, {
                        page: "current"
                      })
                      .data()
                      .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                      }, 0);

                    // Update footer
                    $(api.column(1).footer()).html(
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
                      exportOptions: {
                        columns: [0, 1, 2, 3],
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
                        columns: [0, 1, 2, 3],
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
                  order: [[0, "desc"]],
                  bDestroy: true,
                  data: data.data,
                  columns: [
                    {
                      data: "created_at",
                      name: "created_at"
                    },
                    {
                      data: "paymentamount",
                      name: "paymentamount"
                    },
                    {
                      data: "paymentmethod",
                      name: "paymentmethod"
                    },
                    {
                      data: "checknumber",
                      name: "checknumber"
                    },
                    {
                      data: "status",
                      name: "status"
                    },
                    {
                      data: "received_by",
                      name: "received_by"
                    },
                    {
                      data: "action",
                      name: "action"
                    }
                  ]
                });
              }
            });
          }
        });
      }
    });
  });

  $("#print_ca").click(function(event) {
    event.preventDefault();
    $("#add_cash_advance").trigger("click");
    $("#print_form").trigger("click");
  });

  $("#print_form").click(function(event) {
    if (print_checker == "new") {
      $("#customer_id2_clone").val(
        $("#fname").val() + " " + $("#mname").val() + " " + $("#lname").val()
      );
      $("#reason2_clone").val($("#reason1").val());
      $("#amount2_clone").val($("#bal").val());
      $("#balance2_clone").val("0");
      $("#received2_clone").val($("#received1").val());
      $("#month2_clone").val($("#month1").val());
    } else {
      $("#print_form1").trigger("click");
    }
  });

  $("#print_form1").click(function(event) {
    $("#customer_id_clone").val($("#customer_id option:selected").text());
    $("#reason_clone").val($("#reason").val());
    $("#amount_clone").val($("#amount").val());
    $("#balance_clone").val($("#balance").val());
    $("#received_clone").val($("#received").val());
    $("#month_clone").val($("#month").val());
  });

  $("#print_balance_payment").click(function(event) {
    event.preventDefault();
    $("#add_balance").trigger("click");
    $("#print_balance_form").trigger("click");
  });

  $("#print_balance_form").click(function(event) {
    $("#customer_id1_clone").val($("#customer_id1 option:selected").text());
    $("#paymentmethod_clone").val($("#paymentmethod option:selected").text());
    $("#checknumber_clone").val($("#checknumber").val());
    $("#amount1_clone").val($("#amount1").val());
    $("#balance2_clone").val($("#balance2").val());
    $("#r_balance_clone").val($("#r_balance").val());
  });

  $(document).on("click", ".view_balance", function() {
    var id = $(this).attr("id");
    person_id = id;
    //Datatable for each person
    $.ajax({
      url: "{{ route('balancelogs') }}",
      method: "get",
      data: {
        id: id
      },
      dataType: "json",
      success: function(data) {
        $("#view_balancetable").DataTable({
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
              .column(1, {
                page: "current"
              })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(1).footer()).html(
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
              exportOptions: {
                columns: [0, 1, 2, 3],
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
                columns: [0, 1, 2, 3],
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
          order: [[0, "desc"]],
          bDestroy: true,
          data: data.data,
          columns: [
            {
              data: "created_at",
              name: "created_at"
            },
            {
              data: "paymentamount",
              name: "paymentamount"
            },
            {
              data: "paymentmethod",
              name: "paymentmethod"
            },
            {
              data: "checknumber",
              name: "checknumber"
            },
            {
              data: "status",
              name: "status"
            },
            {
              data: "received_by",
              name: "received_by"
            },
            {
              data: "action",
              name: "action"
            }
          ]
        });
        $("#balance_view_modal").modal("show");
      }
    });
  });
  var person_id;
  var id;
  var cash_advance_release;
  $(document).on("click", ".view_cash_advance", function() {
    person_id = $(this).attr("id");

    //Datatable for each person
    $.ajax({
      url: "{{ route('refresh_view_cashadvance') }}",
      method: "get",
      data: {
        id: person_id
      },
      dataType: "json",
      success: function(data) {
        $.ajax({
          url: "{{ route('getCustomer') }}",
          method: "get",
          data: {
            id: person_id
          },
          dataType: "json",
          success: function(data) {
            $(".modal_title_ca").text(
              data.fname + " " + data.mname + " " + data.lname
            );
          }
        });
        cash_advance_release = $("#view_cash_advancetable").DataTable({
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
              .column(1, {
                page: "current"
              })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(1).footer()).html(
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
              exportOptions: {
                columns: [0, 1, 2, 3, 4],
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
                columns: [0, 1, 2, 3, 4],
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
          order: [[2, "desc"]],
          bDestroy: true,
          data: data.data,
          columns: [
            {
              data: "reason",
              name: "reason"
            },
            {
              data: "amount",
              name: "amount"
            },
            {
              data: "created_at",
              name: "created_at"
            },
            {
              data: "status",
              name: "status"
            },
            {
              data: "released_by",
              name: "released_by"
            },
            {
              data: "action",
              orderable: false,
              searchable: false
            }
          ]
        });
        $("#ca_view_modal").modal("show");
      }
    });
  });
  //CASH ADVANCE datatable ends here

  $(document).on("click", ".update_ca", function(event) {
    $("#ca_view_modal").modal("hide");
    event.preventDefault();
    var id = $(this).attr("id");
    $.ajax({
      url: "{{ route('update_ca') }}",
      method: "get",
      data: {
        id: id
      },
      dataType: "json",
      success: function(data) {
        $("#homeclick").trigger("click");
        $("#homeclick1").hide();
        $("#button_action_ca").val("update");
        $("#id_ca").val(id);
        $("#customer_id")
          .val(data.customer_id)
          .trigger("change");
        $("#reason")
          .val(data.reason)
          .trigger("change");
        $("#amount")
          .val(data.amount)
          .trigger("change");
        $("#balance")
          .val(data.balance)
          .trigger("change");
        $("#ca_modal").modal("show");
        $(".modal_title").text("Update Cash Advance");
      }
    });
  });

  $(document).on("click", ".delete_ca", function(event) {
    event.preventDefault();
    var id = $(this).attr("id");
    swal({
      title: "Are you sure?",
      text: "Delete this record?",
      icon: "warning",
      buttons: true
    }).then(willDelete => {
      if (willDelete) {
        $.ajax({
          url: "{{ route('delete_ca') }}",
          method: "get",
          data: {
            id: id
          },
          success: function(data) {
            if (data == 2) {
              swal(
                "Hold On!",
                "Record to delete is higher than balance.",
                "warning"
              );
              return;
            }
            refresh_cash_advance_table();
            refresh_balance_table();
            swal("Deleted!", "The record has been deleted.", "success");
            if (data) {
              $("#curCashOnHand").html(data);
            }
            $.ajax({
              url: "{{ route('refresh_view_cashadvance') }}",
              method: "get",
              data: {
                id: person_id
              },
              dataType: "json",
              success: function(data) {
                $.ajax({
                  url: "{{ route('getCustomer') }}",
                  method: "get",
                  data: {
                    id: person_id
                  },
                  dataType: "json",
                  success: function(data) {
                    $(".modal_title_ca").text(
                      data.fname + " " + data.mname + " " + data.lname
                    );
                  }
                });
                cash_advance_release = $("#view_cash_advancetable").DataTable({
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
                      .column(1, {
                        page: "current"
                      })
                      .data()
                      .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                      }, 0);

                    // Update footer
                    $(api.column(1).footer()).html(
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
                      exportOptions: {
                        columns: [0, 1, 2, 3, 4],
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
                        columns: [0, 1, 2, 3, 4],
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
                  order: [[2, "desc"]],
                  bDestroy: true,
                  data: data.data,
                  columns: [
                    {
                      data: "reason",
                      name: "reason"
                    },
                    {
                      data: "amount",
                      name: "amount"
                    },
                    {
                      data: "created_at",
                      name: "created_at"
                    },
                    {
                      data: "status",
                      name: "status"
                    },
                    {
                      data: "released_by",
                      name: "released_by"
                    },
                    {
                      data: "action",
                      orderable: false,
                      searchable: false
                    }
                  ]
                });
              }
            });
          }
        });
      }
    });
  });

  $(document).on("click", ".release_ca", function(event) {
    var input = $(this);
    var button = this;
    button.disabled = true;
    event.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      url: "{{ route('check_balance4') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        id: id
      },
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
          button.disabled = false;
          return;
        } else {
          $.ajax({
            url: "{{ route('release_ca') }}",
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              id: id
            },
            dataType: "json",
            success: function(data) {
              $.ajax({
                url: "{{ route('refresh_view_dtr') }}",
                method: "get",
                data: {
                  id: id
                },
                dataType: "json",
                success: function(data) {
                  $("#view_cash_advancetable")
                    .DataTable()
                    .destroy();
                  $.ajax({
                    url: "{{ route('refresh_view_cashadvance') }}",
                    method: "get",
                    data: {
                      id: person_id
                    },
                    dataType: "json",
                    success: function(data) {
                      $.ajax({
                        url: "{{ route('getCustomer') }}",
                        method: "get",
                        data: {
                          id: person_id
                        },
                        dataType: "json",
                        success: function(data) {
                          $(".modal_title_ca").text(
                            data.fname + " " + data.mname + " " + data.lname
                          );
                        }
                      });
                      cash_advance_release = $(
                        "#view_cash_advancetable"
                      ).DataTable({
                        footerCallback: function(
                          row,
                          data,
                          start,
                          end,
                          display
                        ) {
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
                            .column(1, {
                              page: "current"
                            })
                            .data()
                            .reduce(function(a, b) {
                              return intVal(a) + intVal(b);
                            }, 0);

                          // Update footer
                          $(api.column(1).footer()).html(
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
                            exportOptions: {
                              columns: [0, 1, 2, 3, 4],
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
                              columns: [0, 1, 2, 3, 4],
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
                        order: [[2, "desc"]],
                        bDestroy: true,
                        columnDefs: [
                          {
                            targets: "_all", // your case first column
                            className: "text-left"
                          }
                        ],
                        data: data.data,
                        columns: [
                          {
                            data: "reason",
                            name: "reason"
                          },
                          {
                            data: "amount",
                            name: "amount"
                          },
                          {
                            data: "created_at",
                            name: "created_at"
                          },
                          {
                            data: "status",
                            name: "status"
                          },
                          {
                            data: "released_by",
                            name: "released_by"
                          },
                          {
                            data: "action",
                            orderable: false,
                            searchable: false
                          }
                        ]
                      });
                    }
                  });
                }
              });
              refresh_cash_advance_table();
              refresh_balance_table();
              swal(
                "Cash Released!",
                "Remaining Balance: ₱" +
                  data.cashOnHand.toFixed(2) +
                  " | Transaction ID: " +
                  data.cashHistory,
                "success"
              );
              $("#curCashOnHand").html(data.cashOnHand.toFixed(2));
            }
          });
        }
      }
    });
  });

  $("#customer_id").select2({
    dropdownParent: $("#ca_modal"),
    placeholder: "Select a customer"
  });

  $("#month").datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: "MM, yy",
    beforeShow: function() {
      $(".ui-datepicker").css("font-size", 18);
    },
    onClose: function(dateText, inst) {
      $(this).datepicker(
        "setDate",
        new Date(inst.selectedYear, inst.selectedMonth, 1)
      );
    }
  });

  $("#customer_id1").select2({
    dropdownParent: $("#balancemodal"),
    placeholder: "Select a customer"
  });

  $("#month1").datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: "MM, yy",
    beforeShow: function() {
      $(".ui-datepicker").css("font-size", 18);
    },
    onClose: function(dateText, inst) {
      $(this).datepicker(
        "setDate",
        new Date(inst.selectedYear, inst.selectedMonth, 1)
      );
    }
  });

  $("#paymentmethod").select2({
    dropdownParent: $("#balancemodal"),
    placeholder: "Select a type of payment"
  });
});
</script>
@endsection