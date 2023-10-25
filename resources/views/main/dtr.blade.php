@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daily Time Record</h2>
        </div>
    </div>

<div class="modal fade" id="employee_ca_view" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="row">            
              <div class="card">
                  <div class="header">
                  <div class="container-fluid">
                    <div class="container-fluid">
                      <h4>Employee: <span class="employee_name"></span></h4>
                    </div>
                    <br/>
                    <ul class="nav nav-tabs">
                      <li class="active">
                        <a href="#ca_tab" data-toggle="tab">
                          <div class="block-header">
                            <h2> Cash Advance Logs 
                              <span id="ca_tab_badge" class="badge-notify-parent" style="display:none;"><span class="badge badge-notify">!</span></span>
                              <span class="modal_title_ca"></span>
                            </h2>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#payment_tab" data-toggle="tab" id="render">
                          <div class="block-header">
                            <h2>Payment Logs 
                              <span id="payment_tab_badge" class="badge-notify-parent" style="display:none;"><span class="badge badge-notify">!</span></span>
                              <span class="modal_title_ca"></span>
                            </h2>
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div> 
                      
                   </div>
                   <div class="body">
                   <div class="tab-content">
                    <div id="ca_tab" class="tab-pane fade in active">
                       <div class="table-responsive">
                       <br>
                            <table id="view_employee_ca_table" class="table table-bordered table-striped table-hover" style="width: 100%;">
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
                      
                   </div>
                    <div id="payment_tab" class="tab-pane fade">
                      <div class="table-responsive">
                      <br>
                        <table id="payment_table" class="table table-bordered table-striped table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th  width="100" style="text-align:center;">Payment Method</th>
                                    <th  width="100" style="text-align:center;">Amount</th>
                                    <th  width="100" style="text-align:center;">Date</th>
                                    <th  width="100" style="text-align:center;">Check Number</th>
                                    <th  width="100" style="text-align:center;">Remarks</th>
                                    <th  width="100" style="text-align:center;">Remaining Balance</th>
                                    <th  width="100" style="text-align:center;">Received by</th>
                                    <th  width="100" style="text-align:center;">Receiving</th>
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
                 <div class="modal-footer">
                               <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                       </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
 </div>

 <!-- Add CA modal -->
    <div class="modal fade" id="employee_ca_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                     <div class="header">
                          <h2 class="modal_title">Add Employee Cash Advance</h2>
                   <ul class="header-dropdown m-r--5">
                       <li class="dropdown">
                            <button id="print_ca" type="button" class="btn btn-sm btn-icon print-icon" ><i class="glyphicon glyphicon-print"></i></button>
                       </li>
                       <li class="dropdown">
                            <!-- <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_ca') }}">
                            <input type="hidden" id="customer_id_clone" name="customer_id_clone">
                            <input type="hidden" id="reason_clone" name="reason_clone">
                            <input type="hidden" id="amount_clone" name="amount_clone">
                            <input type="hidden" id="balance1_clone" name="balance1_clone">
                            <input type="hidden" id="month_clone" name="month_clone">
                            <input type="hidden" id="received_clone" name="received_clone">
                            <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form1" id="print_form1" title="PRINT ONLY"><i class="glyphicon glyphicon-print"></i></button>
                            </form> -->
                       </li>
                   </ul>
                     </div>
                     <div class="body">
                             <div class="clearfix"></div>
                             <br>

                              <div class="tab-content">
                             <div id="home" class="tab-pane fade in active">
                          <form class="form-horizontal " id="ca_emp_form">
                               <input type="hidden"  name="id_ca" id="id_ca" value="">
                               <input type="hidden"  name="button_action_ca" id="button_action_ca" value="">

                               <div class="row clearfix">
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                         <label for="name">Name</label>
                                    </div>
                                    <div class="col-lg-9 col-md-10 col-sm-8 col-xs-7">
                                         <div class="form-group">
                                              <div id="c" class="form-line">
                                                   <select type="text" id="employee_ca" name="employee_id" class="form-control" required style="width: 100%;">
                                                        @foreach($employee as $a)
                                                        <option></option>
                                                        <option value="{{ $a->id }}">{{ $a->lname.", ".$a->fname." ".$a->mname}}</option>
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
                                                   <input type="text" id="reason" name="reason" class="form-control" required>
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
                                                   <input type="number" id="amount" min="0" name="amount" class="form-control" required>
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
                                                   <input type="number" id="balance" name="balance" class="form-control" readonly>
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
                                                    <input name="month" id="month" class="date-picker form-control" style="width: 100%;" required/>
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
                                                    <input type="text" id="received" name="received" class="form-control" required>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                          </form>
                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <div class="print-only">
                                    <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_ca') }}">
                                        <input type="hidden" id="customer_id_clone" name="customer_id_clone">
                                        <input type="hidden" id="reason_clone" name="reason_clone">
                                        <input type="hidden" id="amount_clone" name="amount_clone">
                                        <input type="hidden" id="balance1_clone" name="balance1_clone">
                                        <input type="hidden" id="month_clone" name="month_clone">
                                        <input type="hidden" id="received_clone" name="received_clone">
                                        <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form1" id="print_form1" title="PRINT ONLY">PRINT ONLY</button>
                                    </form>
                                    </div>
                                        <button type="submit" id="add_cash_advance" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                          </div>
                          </div>
                     </div>
               </div>
          </div>
      </div>
</div>

<!-- Add Payment -->
<div class="modal fade" id="payment_modal" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div class="card">
                  <div class="header">
                       <h2 class="modal_title">Add Payment</h2>
                   <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <button id="print_balance_payment" type="button" class="btn btn-sm btn-icon print-icon" ><i class="glyphicon glyphicon-print"></i></button>
                       </li>
                       <li class="dropdown">
                            <!-- <form method="POST" id="printBalanceForm" name="printBalanceForm" target="_blank" action="{{ route('print_balance_payment') }}">
                                <input type="hidden" id="customer_id1_clone" name="customer_id1_clone">
                                <input type="hidden" id="paymentmethod_clone" name="paymentmethod_clone">
                                <input type="hidden" id="checknumber_clone" name="checknumber_clone">
                                <input type="hidden" id="amount2_clone" name="amount2_clone">
                                <input type="hidden" id="balance2_clone" name="balance2_clone">
                                <input type="hidden" id="remarks_clone" name="remarks_clone">
                                <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_balance_form" id="print_balance_form" title="PRINT ONLY">PRINT ONLY</button>
                            </form> -->
                       </li> 
                   </ul>
                  </div>
                  <div class="body">
                       <form class="form-horizontal " id="balanceform" method="POST">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="button_action_payment" id="button_action_payment" value="">

                            <div class="row clearfix">
                                  <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                       <label for="name">Name</label>
                                  </div>
                                  <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                       <div class="form-group">
                                            <div id="c1" class="form-line">
                                                 <select type="text" id="employee_payment_id" name="employee_payment_id" class="form-control" required style="width: 100%;">
                                            @foreach($employee as $a)

                                            <option value="{{ $a->id }}">{{ $a->lname.", ".$a->fname." ".$a->mname}}</option>
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
                                                 <input type="number" id="amount_payment" min="0" name="amount" class="form-control" required>
                                            </div>
                                       </div>
                                  </div>
                        </div>
                        <div class="row clearfix">
                                  <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                       <label for="name">Remarks</label>
                                  </div>
                                  <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                       <div class="form-group">
                                            <div class="form-line">
                                                 <input type="text" id="remarks"  name="remarks" class="form-control" required>
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
                                                 <input type="number" id="balancepayment" name="balance" readonly="readonly" class="form-control" readonly>
                                            </div>
                                       </div>
                                  </div>
                            </div>

                       </form>
                        <div class="row clearfix">
                                <div class="modal-footer">
                                    <div class="print-form">
                                    <form method="POST" id="printBalanceForm" name="printBalanceForm" target="_blank" action="{{ route('print_balance_payment') }}">
                                        <input type="hidden" id="customer_id1_clone" name="customer_id1_clone">
                                        <input type="hidden" id="paymentmethod_clone" name="paymentmethod_clone">
                                        <input type="hidden" id="checknumber_clone" name="checknumber_clone">
                                        <input type="hidden" id="amount2_clone" name="amount2_clone">
                                        <input type="hidden" id="balance2_clone" name="balance2_clone">
                                        <input type="hidden" id="remarks_clone" name="remarks_clone">
                                        <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_balance_form" id="print_balance_form" title="PRINT ONLY">PRINT ONLY</button>
                                    </form>
                                    </div>
                                    <button type="submit" id="add_balance" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                        </div>
                  </div>
             </div>
         </div>
   </div>
</div>


    <!-- Add DTR Modal -->
    <div class="modal fade" id="dtr_modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2 class="dtr_modal_title">Add DTR</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button id="print_dtr" type="button" class="btn btn-sm btn-icon print-icon" ><i class="glyphicon glyphicon-print"></i></button>
                            </li>
                            <li class="dropdown">
                                <!-- <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_dtr') }}">
                                    <input type="hidden" id="view_dtr_name" name="view_dtr_name">
                                    <input type="hidden" id="employee_id_clone" name="employee_id_clone">
                                    <input type="hidden" id="role_clone" name="role_clone">
                                    <input type="hidden" id="overtime_clone" name="overtime_clone">
                                    <input type="hidden" id="rate_clone" name="rate_clone">
                                    <input type="hidden" id="num_hours_clone" name="num_hours_clone">
                                    <input type="hidden" id="salary_clone" name="salary_clone">
                                    <input type="hidden" id="bonus_clone" name="bonus_clone">
                                    <input type="hidden" id="balance_clone" name="balance_clone">
                                    <input type="hidden" id="partial_payment_clone" name="partial_payment_clone">
                                    <input type="hidden" id="remaining_balance_clone" name="remaining_balance_clone">
                                    <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                </form> -->
                            </li>
                        </ul> 
					</div>
					<div class="body">
						<form class="form-horizontal " id="dtr_form">
							<input type="hidden" name="add_id" id="add_id" value="">
							<input type="hidden" name="button_action" id="button_action" value="">
              <input type="hidden" name="last_payment" id="last_payment" value="">
              <input type="hidden" name="employee_ni" id="employee_ni" value="">
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Name</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<select type="text" id="employee_id" name="employee_id" class="form-control" required style="width: 100%;">
                                                @foreach($employee as $a)
                                                <option></option>
                                                <option value="{{ $a->id }}">{{ $a->lname.", ".$a->fname." ".$a->mname}}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</div>
							</div>

              <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Role</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="role" name="role" class="form-control" readonly>
										</div>
									</div>
								</div>
							</div>

              <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Overtime</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="" id="overtime" min="0" name="overtime" class="form-control" required>
										</div>
									</div>
								</div>
							</div>

              <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Rate</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="rate" name="rate" class="form-control" readonly>
										</div>
									</div>
								</div>
							</div>

              <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Number Of Hours</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="num_hours" min="0" name="num_hours" class="form-control" required>
										</div>
									</div>
								</div>
							</div>
                            
              <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Bonus</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="" id="bonus" min="0" name="bonus" class="form-control" required>
										</div>
									</div>
								</div>
               </div>
               <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" >
                  <label for="name">Balance</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="" id="emp_balance" min="0" name="emp_balance" class="form-control" required readonly>
                    </div>
                  </div>
                </div>
               </div>
               <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                  <label for="name">Partial Payment</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="" id="p_payment" min="0" name="p_payment" class="form-control" required>
                    </div>
                  </div>
                </div>
               </div>
               <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" >
                  <label for="name">Remaining Balance</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="number" id="emp_rbalance" min="0" name="emp_rbalance" class="form-control" required readonly>
                    </div>
                  </div>
                </div>
               </div>

               <div class="row clearfix">
								<div class="col-md-2 form-control-label">
									<label for="name">SSS</label>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="sss-deductions" min="0" value="0" name="sss_deductions" class="form-control deductions">
										</div>
									</div>
								</div>
								<div class="col-md-2 form-control-label">
									<label for="name">PHIC</label>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="phic-deductions" min="0" value="0" name="phic_deductions" class="form-control deductions">
										</div>
									</div>
								</div>
							</div>
               <div class="row clearfix">
								<div class="col-md-2 form-control-label">
									<label for="name">HDMF</label>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="hdmf-deductions" min="0" value="0" name="hdmf_deductions" class="form-control deductions">
										</div>
									</div>
								</div>
								<div class="col-md-2 form-control-label">
									<label for="name">Lodging</label>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="lodging-deductions" min="0" value="0" name="lodging_deductions" class="form-control deductions">
										</div>
									</div>
								</div>
							</div>
               <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Other Deductions</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="other-deductions" min="0" value="0" name="other_deductions" class="form-control deductions">
										</div>
									</div>
								</div>
							</div>

               <div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
									<label for="name">Salary</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
									<div class="form-group">
										<div class="form-line">
											<input type="number" id="salary" min="0" name="salary" class="form-control" readonly>
										</div>
									</div>
								</div>
							</div>

						</form>
                        <div class="row clearfix">
                            <div class="modal-footer">
                                <div>
                                    <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_dtr') }}">
                                        <input type="hidden" id="view_dtr_name" name="view_dtr_name">
                                        <input type="hidden" id="employee_id_clone" name="employee_id_clone">
                                        <input type="hidden" id="role_clone" name="role_clone">
                                        <input type="hidden" id="overtime_clone" name="overtime_clone">
                                        <input type="hidden" id="rate_clone" name="rate_clone">
                                        <input type="hidden" id="num_hours_clone" name="num_hours_clone">
                                        <input type="hidden" id="salary_clone" name="salary_clone">
                                        <input type="hidden" id="bonus_clone" name="bonus_clone">
                                        <input type="hidden" id="balance_clone" name="balance_clone">
                                        <input type="hidden" id="partial_payment_clone" name="partial_payment_clone">
                                        <input type="hidden" id="sss_deductions_clone" name="sss_deductions_clone">
                                        <input type="hidden" id="phic_deductions_clone" name="phic_deductions_clone">
                                        <input type="hidden" id="hdmf_deductions_clone" name="hdmf_deductions_clone">
                                        <input type="hidden" id="lodging_deductions_clone" name="lodging_deductions_clone">
                                        <input type="hidden" id="other_deductions_clone" name="other_deductions_clone">
                                        <input type="hidden" id="remaining_balance_clone" name="remaining_balance_clone">
                                        <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                    </form>
                                </div>
                                <button type="submit" id="add_dtr" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>

	</div>

    <!-- View Person DTR Modal -->
    <div class="modal fade" id="dtr_view_modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document" style="width: 90%;">
            <div class="row">
                    <div class="card">
                        <div class="header">
                            <h2> Daily Time Records History - <span class="modal_title_dtr"></span></h2>
                        </div>
                        <div class="body">
                        <div id="reportrange" class="reportrange btn btn-lg" style="">

                            <span></span> <b class="caret"></b>
                          </div>
                            <div class="table-responsive">
                            <br>
                                <table id="view_dtr_table" class="table table-bordered table-striped table-hover" style="width: 100%;">
                                <h5 id="balance_view"></h5>
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Overtime</th>
                                            <th rowspan="2">Number of Hours</th>
                                            <th rowspan="2">Date/Time</th>
                                            <th rowspan="2">Bonus</th>
                                            <th rowspan="2">Balance</th>
                                            <th rowspan="2">Partial Payment</th>
                                            <th rowspan="2">Remaining Balance</th>
                                            <th colspan="5" style="text-align:center;">DEDUCTIONS</th>
                                            <th rowspan="2" width="80" style="text-align:center;">Total Deductions</th>
                                            <th rowspan="2" width="80" style="text-align:center;">SSS/ 
                                              PHIC/ 
                                              HDMF/ 
                                              LODGING/ 
                                              OTHERS
                                            </th>
                                            <th rowspan="2">Salary</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Released By</th>
                                            <th rowspan="2">Releasing</th>
                                        </tr>
                                        <tr>
                                          <th width="80" style="text-align:center;">SSS</th>
                                          <th width="80" style="text-align:center;">PHIC</th>
                                          <th width="80" style="text-align:center;">HDMF</th>
                                          <th width="80" style="text-align:center;">Lodging</th>
                                          <th width="80" style="text-align:center;">Others</th>
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
             
            </div>
		</div>
	</div>

  <!-- view all CA table-->

    <div class="modal fade" id="ca_view_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
            <div class="row">
                 
                    <div class="card">
                        <div class="header">
                            <h2> Employees with Balances</span></h2>
                        </div>
                        <div class="body">
                         
                            <div class="table-responsive">
                            <br>
                                <table id="view_balance_table" class="table table-bordered table-striped table-hover" style="width: 100%;">
                                <h5 id="balance_view"></h5>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Balance</th>
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
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
             
            </div>
    </div>
  </div>


  <!-- end of view all CA table -->

    <div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>Daily Time Records as of {{ date('Y-m-d ') }}</h2>
						<ul class="header-dropdown m-r--5">
							<li class="dropdown">
                @if(isAdmin() || isPurchaser())
                  <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 open_dtr_modal" title="Add DTR"><i class="material-icons">library_add</i></button>
                  <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 add_ca" title="Add Cash Advance"><i class="material-icons">attach_money</i></button>
                  <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 add_payment" title="Add Payment"><i class="material-icons">playlist_add</i></button>
                  <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 open_ca_list" title="Employee CA List"><i class="material-icons">subject</i></button>
                @endif
              </li>
						</ul>
					</div>
					<div class="body">
            <div id="dtr-daterange" class="reportrange btn btn-lg" style="">
              <span></span> <b class="caret"></b>
            </div>
						<div class="table-responsive">
              <br>
							<table id="dtr_table" class="table table-bordered table-striped table-hover" style="width: 100%;">
								<thead>
									<tr>
										<th rowspan="2" width="100" style="text-align:center;">Name</th>
                    <th rowspan="2" width="100" style="text-align:center;">mname</th>
                    <th rowspan="2" width="100" style="text-align:center;">lname</th>
										<th rowspan="2" width="40" style="text-align:center;">Role</th>
										<th rowspan="2" width="40" style="text-align:center;">Overtime</th>
										<th rowspan="2" width="40" style="text-align:center;">No. of Hours</th>
                    <th rowspan="2" width="100" style="text-align:center;">Date/Time</th>
                    <th rowspan="2" width="70" style="text-align:center;">Bonus</th>
                    <th rowspan="2" width="80" style="text-align:center;">Balance</th>
                    <th rowspan="2" width="80" style="text-align:center;">Partial Payment</th>
                    <th rowspan="2" width="80" style="text-align:center;">Remaining Balance</th>
                    <th rowspan="2" width="80" style="text-align:center;">Gross Salary</th>
                    <th colspan="5" style="text-align:center;">DEDUCTIONS</th>
                    <th rowspan="2" width="80" style="text-align:center;">Total Deductions</th>
                    <th rowspan="2" width="80" style="text-align:center;">SSS/ 
                      PHIC/ 
                      HDMF/ 
                      LODGING/ 
                      OTHERS
                    </th>
                    <th rowspan="2" width="80" style="text-align:center;">Net Salary</th>
                    <th rowspan="2" width="60" style="text-align:center;">Status</th>
                    <th rowspan="2" width="100" style="text-align:center;">Signature</th>
										<th rowspan="2" width="100" style="text-align:center;">Action</th>
									</tr>
									<tr>
                    <th width="80" style="text-align:center;">SSS</th>
                    <th width="80" style="text-align:center;">PHIC</th>
                    <th width="80" style="text-align:center;">HDMF</th>
                    <th width="80" style="text-align:center;">Lodging</th>
                    <th width="80" style="text-align:center;">Others</th>
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
                      <th></th>
                  </tr>
                </tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    <div class="modal fade" id="release_modal_dtr" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Are You Sure?</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="modal-footer">
                                <button type="button" id="release_money_dtr" class="btn btn-success waves-effect">CONTINUE</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
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
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script>
var overtime;
var salary;
var id;
var dtr_info;
var person_id;
var fname;
var lname;
var mname;
var idmain;
var total;
var role;
var bonus;
var trig_update;
var payment_table;
var cash_advance_release;
var emp_balance;
var start = moment().subtract(1, 'year');
var end = moment();
var dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
var timeOptions = { hour: '2-digit', minute: '2-digit' };

// Hack to enable multiple modals by making sure the .modal-open class
// is set to the <body> when there is at least one modal open left
// https://stackoverflow.com/questions/28077066/bootstrap-modal-issue-scrolling-gets-disabled
$('body').on('hidden.bs.modal', function () {
  if($('.modal.in').length > 0)
  {
    $('body').addClass('modal-open');
  }
});

$(document).ready(function() {
  var pusher = new Pusher("{{$pusher['key']}}", {
    cluster: "{{$pusher['cluster']}}"
  });

  var channel = pusher.subscribe('homepage');
  channel.bind('App\\Events\\DtrUpdated', function(data) {
    if ("{{ auth()->user()->id }}" != data?.user) {
      swal({
        title: "New DTR Created",
        text: "A new DTR entry has been created. Do you want to refresh this table?",
        icon: "warning",
        buttons: true
      }).then(refresh => {
        if (refresh) {
          refresh_dtr_table();
        }
      });
    }
  });

  function cb(start, end) {
    $('.reportrange span').html(
      start.format("MMMM D YYYY, h:mm:ss a") +
        " - " +
        end.format("MMMM D YYYY, h:mm:ss a")
    );
  }

  $(".reportrange").daterangepicker(
    {
      startDate: start,
      endDate: end,
      locale: {
        format: 'MMMM D YYYY, h:mm:ss a'
      },
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment()
            .subtract(1, "month")
            .startOf("month"),
          moment()
            .subtract(1, "month")
            .endOf("month")
        ]
      }
    },
    cb
  );

  $('.reportrange').val(
    start.format("MMMM D YYYY, h:mm:ss a") +
    " to " +
    end.format("MMMM D YYYY, h:mm:ss a")
  );
  cb(start, end);

  $(document).on("click", ".add_ca", function() {
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
    $("#employee_ca_modal").modal("show");
  });

  $(document).on("click", ".add_ca", function() {
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
    $("#employee_ca_modal").modal("show");
  });

  $("#paymentmethod").change(function() {
    x = $("#paymentmethod").val();
    if (x == "Check") {
      $("#cn").removeClass("hidden");
    } else {
      $("#checknumber").val("");
      $("#cn").addClass("hidden");
    }
  });

  $(document).on("click", ".add_payment", function() {
    $("#pm").removeClass("focused");
    $("#c1").removeClass("focused");
    $("#employee_payment_id")
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
    $("#payment_modal").modal("show");
  });

  $(document).on("click", ".open_ca_list", function() {
    $("#ca_view_modal").modal("show");
    $.ajax({
      url: "{{ route('employee_balance') }}",
      method: "get",
      dataType: "json",
      success: function(data) {
        employee_balace_view = $("#view_balance_table").DataTable({
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
              .column(2, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(2).footer()).html(
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
              title: "Employees With Balances",
              exportOptions: {
                columns: [0, 1, 2],
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
              title: "Employees With Balances",
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
          order: [[2, "desc"]],
          bDestroy: true,
          data: data.data,
          columns: [
            { data: "name", name: "name" },
            { data: "role", name: "role" },
            { data: "balance", name: "balance" }
          ]
        });
      }
    });
  });

  $("#add_balance").one("click", function(event) {
    event.preventDefault();
    var input = $(this);
    var button = this;
    button.disabled = true;
    input.html("SAVING...");

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "{{ route('add_payment_emp') }}",
      method: "POST",
      dataType: "text",
      data: $("#balanceform").serialize(),
      success: function(data) {
        var data2 = JSON.parse(data);
        if (data2.cashOnHand == 0) {
          button.disabled = false;
          input.html("SAVE CHANGES");
          $("#employee_payment_id")
            .val("")
            .trigger("change");
          $("#paymentmethod")
            .val("")
            .trigger("change");
          $("#amount_payment").val("");
          $("#checknumber").val("");
          $("#remarks").val("");
          $("#balance").val("");
          swal("Denied!", "This employee has no balance to pay", "error");
        } else if (data2.cashOnHand == 1) {
          button.disabled = false;
          input.html("SAVE CHANGES");
          $("#employee_payment_id")
            .val("")
            .trigger("change");
          $("#paymentmethod")
            .val("")
            .trigger("change");
          $("#amount_payment").val("");
          $("#checknumber").val("");
          $("#balance").val("");
          $("#payment_modal").modal("hide");
          swal(
            "Payment Added!",
            "Please validate payment and then received it.",
            "success"
          );
        }
        // }else if(data2.cashHistory&&data2.user!=1){
        //     button.disabled = false;
        //     input.html('SAVE CHANGES');
        //     $("#employee_payment_id").val('').trigger('change');
        //     $("#paymentmethod").val('').trigger('change');
        //     $("#amount_payment").val('');
        //     $("#checknumber").val('');
        //     $("#balance").val('');
        //     $('#payment_modal').modal('hide');
        //     swal("Payment Success!", "Payment Recieved by Admin.", "success")
        //   }
      },
      error: function(data) {
        let error = JSON.parse(data.responseText);
        let errorMessage = error?.message || "Something went wrong, try again.";

        swal("Oh no!", errorMessage, "error");
        button.disabled = false;
        input.html("SAVE CHANGES");
      }
    });
  });

  $("#employee_payment_id").change(function() {
    var id = $(this).val();
    $.ajax({
      url: "{{ route('check_emp_balance') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        if (data == null) {
          $("#balancepayment").val(0.0);
        } else {
          $("#balancepayment").val(data.balance);
        }
      }
    });
  });

  $(document).on("click", ".view_ca", function() {
    person_id = $(this).attr("id");

    //Datatable for each person
    $.ajax({
      url: "{{ route('employee_view_ca') }}",
      method: "get",
      data: { id: person_id },
      dataType: "json",
      success: function(data) {
        $("#ca_tab_badge").css("display", "none");
        data.data.forEach((item) => {
          if(item.status != "Released") {
            $("#ca_tab_badge").css("display", "revert");
          }
        })

        if (data.data[0]){
          $(".employee_name").text(
          data.data[0].fname +
            " " +
            data.data[0].mname +
            " " +
            data.data[0].lname
          );
        } else {
          $(".employee_name").text("");
        }

        cash_advance_release = $("#view_employee_ca_table").DataTable({
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
              // title: $("#view_dtr_name").val(),
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
              // title: $("#view_dtr_name").val(),
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
            { data: "reason", name: "reason" },
            { data: "amount", name: "amount" },
            { data: "created_at", name: "created_at" },
            { data: "status", name: "status" },
            { data: "released_by", name: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    });

    $.ajax({
      url: "{{ route('employee_view_payment') }}",
      method: "get",
      data: { id: person_id },
      dataType: "json",
      success: function(data) {
        $("#payment_tab_badge").css("display", "none");
        data.data.forEach((item) => {
          if(item.status != "Received" && item.paymentmethod != "From ADD DTR Form") {
            $("#payment_tab_badge").css("display", "revert");
          }
        });

        payment_table = $("#payment_table").DataTable({
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

            // // Update footer
            // $( api.column( 1 ).footer() ).html(
            //     'Total: <br>₱' + number_format(pageTotal,2)
            // );
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
                columns: [0, 1, 2, 3, 4, 5],
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
                columns: [0, 1, 2, 3, 4, 5],
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
            { data: "paymentmethod", name: "paymentmethod" },
            { data: "paymentamount", name: "paymentamount" },
            { data: "created_at", name: "created_at" },
            { data: "checknumber", name: "checknumber" },
            { data: "remarks", name: "remarks" },
            { data: "r_balance", name: "r_balance" },
            { data: "received_by", name: "received_by" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    });

    $("#employee_ca_view").modal("show");
  });

  $("#employee_ca").change(function() {
    var id = $(this).val();

    $.ajax({
      url: "{{ route('check_emp_balance') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        if (data == null) {
          $("#balance").val(0.0);
        } else {
          $("#balance").val(data.balance);
        }
      }
    });
  });

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
        url: "{{ route('emp_add_cashadvance') }}",
        method: "POST",
        dataType: "text",
        data: $("#ca_emp_form").serialize(),
        success: function(data) {
          mainMouseDownOne2();
          button.disabled = false;
          input.html("SAVE CHANGES");
          $("#employee_ca")
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
          $("#employee_ca_modal").modal("hide");
        },
        error: function(data) {
          let error = JSON.parse(data.responseText);
          let errorMessage = error?.message || "Something went wrong, try again.";

          mainMouseDownOne2();
          swal("Oh no!", errorMessage, "error");
          button.disabled = false;
          input.html("SAVE CHANGES");
        }
      });
    });
  }

  $(document).on("click", "#link", function() {
    $("#bod").toggleClass("overlay-open");
  });

  document.title = "{{ env('APP_NAME') }} - Daily Time Record";

  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });

  //DTR datatable starts here
  $("#dtr_modal").on("hidden.bs.modal", function(e) {
    $(this)
      .find("input,textarea,select")
      .val("")
      .end()
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
  });
  
  function calculateTotal(api, column, isOverall = false) {
    // Remove the formatting to get integer data for summation
    var intVal = function(i) {
        return typeof i == "string"
          ? i.replace(/[\₱,]/g, "") * 1
          : typeof i == "number"
          ? i
          : 0;
      };
    
    let config = {};
    if (isOverall) {
      config = {};
    } else {
      config = { page: "current" }
    }

    return api
        .column(column, config)
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);
  }

  function appendTotalToFooter(api, column, total, prepend = "₱") {
    $(api.column(column).footer()).html(
      prepend + number_format(total, 2)
    );
  }

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

  var dtr = $("#dtr_table").DataTable({
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

      total = calculateTotal(api, 19, true); // Total over all pages
      pageTotal = calculateTotal(api, 19); // Total over this page
      totalBalancePayment = calculateTotal(api, 9); // Total balance payment over this page
      totalBeforeDeduction = pageTotal + totalBalancePayment; // Calculate total over this page before deduction
      overtimeTotal = calculateTotal(api, 4); // Total overtime over this page
      hoursTotal = calculateTotal(api, 5); // Total hours over this page
      bonusTotal = calculateTotal(api, 7); // Total bonus over this page
      balanceTotal = calculateTotal(api, 8); // Total balance over this page
      partialPaymentTotal = calculateTotal(api, 9); // Total partial payment over this page
      remainingBalanceTotal = calculateTotal(api, 10); // Total remaining balance over this page
      deductionsTotal = calculateTotal(api, 18); // Total remaining balance over this page

      // Append totals to footer
      appendTotalToFooter(api, 17, deductionsTotal);
      appendTotalToFooter(api, 19, pageTotal);
      appendTotalToFooter(api, 11, totalBeforeDeduction);
      appendTotalToFooter(api, 10, remainingBalanceTotal);
      appendTotalToFooter(api, 9, partialPaymentTotal);
      appendTotalToFooter(api, 8, balanceTotal);
      appendTotalToFooter(api, 7, bonusTotal);
      appendTotalToFooter(api, 5, hoursTotal, "");
      appendTotalToFooter(api, 4, overtimeTotal, "");
    },
    dom: "Blfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    buttons: [
      {
        extend: "print",
        orientation: 'landscape',
        exportOptions: {
          columns: [6, 0, 3, 4, 5, 7, 8, 9, 10, 11, 18, 19, 20, 21],
          modifier: {
            page: "current"
          },
          stripHtml: false
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
        orientation: 'landscape',
        footer: true,
        exportOptions: {
          columns: [6, 0, 3, 4, 5, 7, 8, 9, 10, 11, 18, 19, 20, 21],
          modifier: {
            page: "current"
          },
          stripNewlines: false
        },
        customize: function(doc) {
          doc.styles.tableHeader.fontSize = 8;
          doc.styles.tableFooter.fontSize = 8;
          doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 10
          doc.content[1].table.widths = [ '7%','12%','7%','5%','5%','7%','8%','7%','8%','8%','7%','8%','5%','*'];
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

    ajax: "{{ route('refresh_dtr') }}",
    columns: [
      { data: "wholename", name: "employee.fname" },
      { data: "mname", name: "employee.mname", visible: false },
      { data: "lname", name: "employee.lname", visible: false },
      { data: "role", name: "role" },
      { data: "overtime", name: "overtime" },
      { data: "num_hours", name: "num_hours" },
      {
        data: "created_at",
        name: "created_at",
        type: "date",
        render: function(value) {
          var ts = new Date(value);

          return ts.toLocaleDateString("en-US", dateOptions) + " \n" + ts.toLocaleTimeString('en-US', timeOptions);
        }
      },
      { data: "bonus", name: "bonus" },
      { data: "dtr_balance", name: "dtr_balance", visible: false },
      { data: "p_payment", name: "p_payment", visible: false },
      { data: "r_balance", name: "r_balance", visible: false },
      { data: "gross_salary", name: "gross_salary" },
      { data: "sss_deductions", name: "sss_deductions" },
      { data: "phic_deductions", name: "phic_deductions" },
      { data: "hdmf_deductions", name: "hdmf_deductions" },
      { data: "lodging_deductions", name: "lodging_deductions" },
      { data: "other_deductions", name: "other_deductions" },
      { data: "deductions", name: "deductions" },
      { data: "deductions", name: "total_deductions", visible: false, 
        render: function(data, type, row, meta) {
          return row.sss_deductions + ' /\n' +
            row.phic_deductions + ' /\n' +
            row.hdmf_deductions + ' /\n' +
            row.lodging_deductions + ' /\n' +
            row.other_deductions;
        } },
      { data: "salary", name: "salary" },
      { data: "status", name: "status" },
      { name: "signature", render: () => { return "" }, visible: false },
      { data: "action", orderable: false, searchable: false }
    ]
  });
  $(".reportrange").on("apply.daterangepicker", function(ev, picker) {
    $(this).val(
      picker.startDate.format("MMMM D YYYY, h:mm:ss a") +
      " to " +
      picker.endDate.format("MMMM D YYYY, h:mm:ss a")
    );

    if (picker.element[0].id == 'reportrange'){
      dtr_info.draw();
    } else {
      dtr.draw();
      if (dtr_info) dtr_info.draw();
    }
  });
  $(".reportrange").on("cancel.daterangepicker", function(ev, picker) {
    $(this).val(
      start.format("MMMM D YYYY, h:mm:ss a") +
      " to " +
      end.format("MMMM D YYYY, h:mm:ss a")
    );
    cb(start, end);

    if (picker.element[0].id == 'reportrange'){
      dtr_info.draw();
    } else {
      dtr.draw();
      if (dtr_info) dtr_info.draw();
    }
  });

  $('#dtr_view_modal').on('show.bs.modal', function (e) {
    cb($('#reportrange').data('daterangepicker').startDate, $('#reportrange').data('daterangepicker').endDate);
  })

  $('#dtr_view_modal').on('hide.bs.modal', function (e) {
    cb($('#dtr-daterange').data('daterangepicker').startDate, $('#dtr-daterange').data('daterangepicker').endDate);
  })

  $.fn.dataTableExt.afnFiltering.push(function(oSettings, aData, iDataIndex) {
    var grab_daterange = ""
    var iStartDateCol = 2;
    var iEndDateCol = 2;
    if (oSettings.sTableId == 'dtr_table'){
      grab_daterange= $("#dtr-daterange").val();
      iStartDateCol = 6;
      iEndDateCol = 6;
    } else if (oSettings.sTableId == 'view_dtr_table') {
      grab_daterange = $("#reportrange").val();
      iStartDateCol = 2;
      iEndDateCol = 2;
    }

    var give_results_daterange = grab_daterange.split(" to ");
    var filterstart = give_results_daterange[0];
    var filterend = give_results_daterange[1];
    var tabledatestart = aData[iStartDateCol];
    var tabledateend = aData[iEndDateCol];

    if (!filterstart && !filterend) {
      return true;
    } else if (
      (moment(filterstart).isSame(tabledatestart) ||
        moment(filterstart).isBefore(tabledatestart)) &&
      filterend === ""
    ) {
      return true;
    } else if (
      (moment(filterstart).isSame(tabledatestart) ||
        moment(filterstart).isAfter(tabledatestart)) &&
      filterstart === ""
    ) {
      return true;
    } else if (
      (moment(filterstart).isSame(tabledatestart) ||
        moment(filterstart).isBefore(tabledatestart)) &&
      (moment(filterend).isSame(tabledateend) ||
        moment(filterend).isAfter(tabledateend))
    ) {
      return true;
    }
    return false;
  });

  function refresh_dtr_table() {
    dtr.ajax.reload(); //reload datatable ajax
  }

  $(document).on("click", ".open_dtr_modal", function() {
    $("#employee_id")
      .val("")
      .trigger("change");
    $("#role")
      .val("")
      .trigger("change");
    $("#overtime")
      .val("")
      .trigger("change");
    $("#num_hours")
      .val("")
      .trigger("change");
    $("#dtr_modal").modal("show");
  });

  //check employee details
  $("#employee_id").change(function() {
    var id = $(this).val();
    $.ajax({
      url: "{{ route('check_employee') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#role").val(data.role);
        $("#rate").val(data.rate);
        if (trig_update != 1) {
          if (data.balance == null) {
            $("#emp_balance").val(0);
          } else {
            $("#emp_balance").val(data.balance);
          }
          $("#emp_rbalance").val(data.balance);
          emp_balance = data.balance;
          salary = data.rate;
        }
      }
    });
  });
  var p_payment;

  function setSalaryValue(){
    salary = parseFloat($("#rate").val());
    overtime =
      parseFloat($("#overtime").val()) + parseFloat($("#num_hours").val());
    p_payment = $("#p_payment").val();
    bonus = parseFloat($("#bonus").val());
    deductions = parseFloat($("#sss-deductions").val()) + parseFloat($("#phic-deductions").val()) +
      parseFloat($("#hdmf-deductions").val()) + parseFloat($("#lodging-deductions").val()) + parseFloat($("#other-deductions").val());
    $("#salary").val((((overtime * salary) + bonus) - p_payment) - deductions);
  }
  $(".deductions").change(function() {
    setSalaryValue();
  });
  $("#overtime").change(function() {
    setSalaryValue();
  });
  $("#p_payment").change(function() {
    p_payment = $("#p_payment").val();
    emp_balance = $("#emp_balance").val();
    $("#emp_rbalance").val(emp_balance - p_payment);

    setSalaryValue();
  });

  $("#num_hours").change(function() {
    setSalaryValue();
  });

  $("#bonus").change(function() {
    setSalaryValue();
  });

  $(document).on("click", ".release_expense_dtr", function(event) {
    var input = $(this);
    var button = this;
    button.disabled = true;
    event.preventDefault();
    id = $(this).attr("id");
    var button = this;
    button.disabled = true;
    $.ajax({
      url: "{{ route('check_balance5') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        if (data == 0) {
          swal("Insufficient Balance!", "Contact Boss", "warning");
          button.disabled = false;
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
            url: "{{ route('release_update_dtr') }}",
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: { id: id },
            dataType: "json",
            success: function(data) {
              var total = "";
              $.ajax({
                url: "/refresh_view_total",
                method: "get",
                data: { id: idmain },
                dataType: "json",
                success: function(data) {
                  total = addCommas(data);
                  $(".modal_title_dtr").text(
                    fname +
                      " " +
                      mname +
                      " " +
                      lname +
                      " (" +
                      role +
                      ") Pending Salary: ₱" +
                      total
                  );
                }
              });
              $.ajax({
                url: "{{ route('refresh_view_dtr') }}",
                method: "get",
                data: { id: person_id },
                dataType: "json",
                success: function(data) {
                  dtr_info = $("#view_dtr_table").DataTable({
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

                      total = calculateTotal(api, 14, true); // Total over all pages
                      pageTotal = calculateTotal(api, 14); // Total over this page
                      deductionsTotal = calculateTotal(api, 12); // Total deductions over this page

                      // Update footer
                      appendTotalToFooter(api, 14, pageTotal); // salary
                      appendTotalToFooter(api, 12, deductionsTotal); // deductions
                    },
                    dom: "Blfrtip",
                    lengthMenu: [
                      [10, 25, 50, -1],
                      [10, 25, 50, "All"]
                    ],
                    bDestroy: true,
                    buttons: [
                      {
                        extend: "print",
                        exportOptions: {
                          columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                          modifier: {
                            page: "current"
                          }
                        },
                        title: $("#view_dtr_name").val(),
                        customize: function(win) {
                          $(win.document.body).css("font-size", "10pt");

                          $(win.document.body)
                            .find("table")
                            .addClass("compact")
                            .css("font-size", "inherit");

                          $(win.document.body)
                            .find("h1")
                            .css("font-size", "15pt");
                        },
                        footer: true
                      },
                      {
                        extend: "pdfHtml5",
                        title: $("#view_dtr_name").val(),
                        footer: true,
                        exportOptions: {
                          columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                          modifier: {
                            page: "current"
                          }
                        },
                        customize: function(doc) {
                          doc.styles.tableHeader.fontSize = 8;
                          doc.styles.tableFooter.fontSize = 8;
                          doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 10
                          doc.content[1].table.widths = Array(
                            doc.content[1].table.body[0].length + 1
                          )
                            .join("*")
                            .split("");
                        }
                      }
                    ],
                    columnDefs: [
                      {
                        targets: "_all", // your case first column
                        className: "text-center"
                      }
                    ],
                    data: data.data,
                    columns: [
                      { data: "overtime", name: "overtime" },
                      { data: "num_hours", name: "num_hours" },
                      {
                        data: "created_at",
                        name: "created_at",
                        type: "date",
                        render: function(value) {
                          var ts = new Date(value);

                          return ts.toLocaleDateString("en-US", dateOptions) + " " + ts.toLocaleTimeString('en-US', timeOptions);
                        }
                      },
                      { data: "bonus", name: "bonus" },
                      { data: "dtr_balance", name: "dtr_balance" },
                      { data: "p_payment", name: "p_payment" },
                      { data: "r_balance", name: "r_balance" },
                      { data: "sss_deductions", name: "sss_deductions" },
                      { data: "phic_deductions", name: "phic_deductions" },
                      { data: "hdmf_deductions", name: "hdmf_deductions" },
                      { data: "lodging_deductions", name: "lodging_deductions" },
                      { data: "other_deductions", name: "other_deductions" },
                      { data: "deductions", name: "deductions" },
                      { data: "deductions", name: "total_deductions", visible: false, 
                        render: function(data, type, row, meta) {
                          return row.sss_deductions + ' /\n' +
                            row.phic_deductions + ' /\n' +
                            row.hdmf_deductions + ' /\n' +
                            row.lodging_deductions + ' /\n' +
                            row.other_deductions;
                        } },
                      { data: "salary", name: "salary" },
                      { data: "status", name: "status" },
                      { data: "released_by", name: "released_by" },
                      { data: "action", orderable: false, searchable: false }
                    ],
                    order: [[2, "desc"]],
                  });

                  dtr.ajax.reload();
                }
              });
              button.disabled = true;
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

  mainMouseDownOne();
  function mainMouseDownOne() {
    $("#add_dtr").one("click", function(event) {
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      event.preventDefault();
      if (
        parseInt($("#p_payment").val()) <= parseInt($("#emp_balance").val()) &&
        parseInt($("#salary").val()) >= 0
      ) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: "{{ route('add_dtr') }}",
          method: "POST",
          dataType: "text",
          data: $("#dtr_form").serialize(),
          success: function(data) {
            var data2 = JSON.parse(data);
            $("#dtr_modal").modal("hide");
            $.ajax({
              url: "{{ route('refresh_view_dtr') }}",
              method: "get",
              data: { id: person_id },
              dataType: "json",
              success: function(data) {
                dtr_info = $("#view_dtr_table").DataTable({
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

                    total = calculateTotal(api, 14, true); // Total over all pages
                    pageTotal = calculateTotal(api, 14); // Total over this page
                    deductionsTotal = calculateTotal(api, 12); // Total deductions over this page

                    // Update footer
                    appendTotalToFooter(api, 14, pageTotal); // salary
                    appendTotalToFooter(api, 12, deductionsTotal); // deductions
                  },
                  dom: "Blfrtip",
                  lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                  ],
                  bDestroy: true,
                  buttons: [
                    {
                      extend: "print",
                      exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                        modifier: {
                          page: "current"
                        }
                      },
                      title: $("#view_dtr_name").val(),
                      customize: function(win) {
                        $(win.document.body).css("font-size", "10pt");

                        $(win.document.body)
                          .find("table")
                          .addClass("compact")
                          .css("font-size", "inherit");

                        $(win.document.body)
                          .find("h1")
                          .css("font-size", "15pt");
                      },
                      footer: true
                    },
                    {
                      extend: "pdfHtml5",
                      title: $("#view_dtr_name").val(),
                      footer: true,
                      exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                        modifier: {
                          page: "current"
                        }
                      },
                      customize: function(doc) {
                        doc.styles.tableHeader.fontSize = 8;
                        doc.styles.tableFooter.fontSize = 8;
                        doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 10
                        doc.content[1].table.widths = Array(
                          doc.content[1].table.body[0].length + 1
                        )
                          .join("*")
                          .split("");
                      }
                    }
                  ],
                  columnDefs: [
                    {
                      targets: "_all", // your case first column
                      className: "text-center"
                    }
                  ],
                  data: data.data,
                  columns: [
                    { data: "overtime", name: "overtime" },
                    { data: "num_hours", name: "num_hours" },
                    {
                      data: "created_at",
                      name: "created_at",
                      type: "date",
                      render: function(value) {
                        var ts = new Date(value);

                        return ts.toLocaleDateString("en-US", dateOptions) + " " + ts.toLocaleTimeString('en-US', timeOptions);
                      }
                    },
                    { data: "bonus", name: "bonus" },
                    { data: "dtr_balance", name: "dtr_balance" },
                    { data: "p_payment", name: "p_payment" },
                    { data: "r_balance", name: "r_balance" },
                    { data: "sss_deductions", name: "sss_deductions" },
                    { data: "phic_deductions", name: "phic_deductions" },
                    { data: "hdmf_deductions", name: "hdmf_deductions" },
                    { data: "lodging_deductions", name: "lodging_deductions" },
                    { data: "other_deductions", name: "other_deductions" },
                    { data: "deductions", name: "deductions" },
                    { data: "deductions", name: "total_deductions", visible: false, 
                      render: function(data, type, row, meta) {
                        return row.sss_deductions + ' /\n' +
                          row.phic_deductions + ' /\n' +
                          row.hdmf_deductions + ' /\n' +
                          row.lodging_deductions + ' /\n' +
                          row.other_deductions;
                      } },
                    { data: "salary", name: "salary" },
                    { data: "status", name: "status" },
                    { data: "released_by", name: "released_by" },
                    { data: "action", orderable: false, searchable: false }
                  ],
                  order: [[2, "desc"]],
                });

                dtr.ajax.reload();
              }
            });
            if (data2.cashHistory && data2.user == 1) {
              swal(
                "Success!",
                "Cash on Hand: ₱" +
                  data2.cashOnHand.toFixed(2) +
                  " | Transaction ID: " +
                  data2.cashHistory,
                "success"
              );
              $("#curCashOnHand").html(data2.cashOnHand.toFixed(2));
            } else if (data2.cashHistory && data2.user != 1) {
              swal("Success!", "Partial Payment Received by Admin.", "success");
            } else {
              swal("Success!", "Record has been added to database", "success");
            }
            mainMouseDownOne();
            button.disabled = false;
            input.html("SAVE CHANGES");
            refresh_dtr_table();
          },
          error: function(data) {
            let error = JSON.parse(data.responseText);
            let errorMessage = error?.message || "Something went wrong, try again.";

            mainMouseDownOne();
            swal("Oh no!", errorMessage, "error");
            button.disabled = false;
            input.html("SAVE CHANGES");
          }
        });
      } else {
        mainMouseDownOne();
        swal(
          "Denied! Can't Partial Payment",
          "Payment is greater than Balance or greater than Salary",
          "error"
        );
        button.disabled = false;
        input.html("SAVE CHANGES");
      }
    });
  }

  $("#dtr_modal").on("hidden.bs.modal", function() {
    $(".dtr_modal_title").text("Add DTR");
  });

  $(document).on("click", ".update_dtr", function(event) {
    event.preventDefault();
    var id = $(this).attr("id");
    $.ajax({
      url: "{{ route('update_dtr') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        trig_update = 1;
        $("#button_action").val("update");
        $("#last_payment").val(data.p_payment);
        $("#add_id").val(id);
        $("#employee_id").select2("enable", false);
        $("#employee_id")
          .val(data.employee_id)
          .trigger("change");
        $("#employee_ni").val(data.employee_id);
        $("#role").val(data.role);
        $("#overtime").val(data.overtime);
        $("#rate").val(data.rate);
        $("#num_hours").val(data.num_hours);
        $("#p_payment").val(data.p_payment);
        $("#emp_balance").val("");
        $("#emp_rbalance").val("");
        $("#emp_balance").val(data.dtr_balance);
        $("#emp_rbalance").val(data.r_balance);
        $("#bonus").val(data.bonus);
        $("#salary").val(data.salary);
        $("#sss-deductions").val(data.deductions_object.sss_deductions);
        $("#phic-deductions").val(data.deductions_object.phic_deductions);
        $("#hdmf-deductions").val(data.deductions_object.hdmf_deductions);
        $("#lodging-deductions").val(data.deductions_object.lodging_deductions);
        $("#other-deductions").val(data.deductions_object.other_deductions);
        $(".dtr_modal_title").text("Update DTR");
        $("#dtr_modal").modal("show");
        $("#dtr_view_modal").modal("hide");
        //refresh_expense_table();
      }
    });
    trig_update = 0;
  });

  $(document).on("click", ".delete_dtr", function(event) {
    var ObjData;
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
          url: "{{ route('delete_dtr') }}",
          method: "get",
          data: { id: id },
          success: function(data) {
            ObjData = JSON.parse(data);

            $.ajax({
              url: "{{ route('refresh_view_dtr') }}",
              method: "get",
              data: { id: person_id },
              dataType: "json",
              success: function(data) {
                dtr_info = $("#view_dtr_table").DataTable({
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

                    total = calculateTotal(api, 14, true); // Total over all pages
                    pageTotal = calculateTotal(api, 14); // Total over this page
                    deductionsTotal = calculateTotal(api, 12); // Total deductions over this page

                    // Update footer
                    appendTotalToFooter(api, 14, pageTotal); // salary
                    appendTotalToFooter(api, 12, deductionsTotal); // deductions
                  },
                  dom: "Blfrtip",
                  lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                  ],
                  bDestroy: true,
                  buttons: [
                    {
                      extend: "print",
                      exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                        modifier: {
                          page: "current"
                        }
                      },
                      title: $("#view_dtr_name").val(),
                      customize: function(win) {
                        $(win.document.body).css("font-size", "10pt");

                        $(win.document.body)
                          .find("table")
                          .addClass("compact")
                          .css("font-size", "inherit");

                        $(win.document.body)
                          .find("h1")
                          .css("font-size", "20pt");
                      },
                      footer: true
                    },
                    {
                      extend: "pdfHtml5",
                      title: $("#view_dtr_name").val(),
                      footer: true,
                      exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                        modifier: {
                          page: "current"
                        }
                      },
                      customize: function(doc) {
                        doc.styles.tableHeader.fontSize = 8;
                        doc.styles.tableFooter.fontSize = 8;
                        doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 10
                        doc.content[1].table.widths = Array(
                          doc.content[1].table.body[0].length + 1
                        )
                          .join("*")
                          .split("");
                      }
                    }
                  ],
                  columnDefs: [
                    {
                      targets: "_all", // your case first column
                      className: "text-center"
                    }
                  ],
                  data: data.data,
                  columns: [
                    { data: "overtime", name: "overtime" },
                    { data: "num_hours", name: "num_hours" },
                    {
                      data: "created_at",
                      name: "created_at",
                      type: "date",
                      render: function(value) {
                        var ts = new Date(value);

                        return ts.toLocaleDateString("en-US", dateOptions) + " " + ts.toLocaleTimeString('en-US', timeOptions);
                      }
                    },
                    { data: "bonus", name: "bonus" },
                    { data: "dtr_balance", name: "dtr_balance" },
                    { data: "p_payment", name: "p_payment" },
                    { data: "r_balance", name: "r_balance" },
                    { data: "sss_deductions", name: "sss_deductions" },
                    { data: "phic_deductions", name: "phic_deductions" },
                    { data: "hdmf_deductions", name: "hdmf_deductions" },
                    { data: "lodging_deductions", name: "lodging_deductions" },
                    { data: "other_deductions", name: "other_deductions" },
                    { data: "deductions", name: "deductions" },
                    { data: "deductions", name: "total_deductions", visible: false, 
                      render: function(data, type, row, meta) {
                        return row.sss_deductions + ' /\n' +
                          row.phic_deductions + ' /\n' +
                          row.hdmf_deductions + ' /\n' +
                          row.lodging_deductions + ' /\n' +
                          row.other_deductions;
                      } },
                    { data: "salary", name: "salary" },
                    { data: "status", name: "status" },
                    { data: "released_by", name: "released_by" },
                    { data: "action", orderable: false, searchable: false }
                  ],
                  order: [[2, "desc"]],
                });
                dtr.ajax.reload();
              }
            });
            refresh_dtr_table();
            if (ObjData != "deleted") {
              $("#curCashOnHand").html(ObjData.cashOnHand.toFixed(2));
              swal(
                "Data Deleted !",
                "Cash On Hand: ₱" +
                  ObjData.cashOnHand.toFixed(2) +
                  " | Transaction ID: " +
                  ObjData.cashHistory,
                "success"
              );
            } else {
              swal("Data Deleted !", "success");
            }
          }
        });
      }
    });
  });

  $(document).on("click", ".delete_ca", function(event) {
    var ObjData;
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
          url: "{{ route('delete_ca_employee') }}",
          method: "get",
          data: { id: id },
          success: function(data) {
            var data2 = JSON.parse(data);
            if (data2 == "No") {
              swal(
                "Denied! Can't Delete CA",
                "Amount is greater than Balance",
                "error"
              );
            } else if (data2.cashOnHand != undefined) {
              swal(
                "Data Deleted! Employee Balance : ₱" +
                  data2.balance
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
            } else if (data2 == "deleted") {
              swal("Data Deleted", " Cash Advance", "success");
            }
            $.ajax({
              url: "{{ route('employee_view_ca') }}",
              method: "get",
              data: { id: person_id },
              dataType: "json",
              success: function(data) {
                // $('.modal_title_ca').text(data.data[0].fname + " " + data.data[0].mname + " " + data.data[0].lname);

                cash_advance_release = $("#view_employee_ca_table").DataTable({
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
                      // title: $("#view_dtr_name").val(),
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
                      // title: $("#view_dtr_name").val(),
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
                    { data: "reason", name: "reason" },
                    { data: "amount", name: "amount" },
                    { data: "created_at", name: "created_at" },
                    { data: "status", name: "status" },
                    { data: "released_by", name: "released_by" },
                    { data: "action", orderable: false, searchable: false }
                  ]
                });
              }
            });
          }
        });
      }
    });
  });

  $(document).on("click", ".receive_payment", function(event) {
    var ObjData;
    event.preventDefault();
    var id = $(this).attr("id");
    swal({
      title: "Accept this payment?",
      text: "",
      icon: "warning",
      buttons: true
    }).then(willDelete => {
      if (willDelete) {
        $.ajax({
          url: "{{ route('receive_payment') }}",
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: { id: id },
          dataType: "text",
          success: function(data) {
            var data2 = JSON.parse(data);

            swal(
              "Payment Received : ₱" +
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

            $.ajax({
              url: "{{ route('employee_view_payment') }}",
              method: "get",
              data: { id: person_id },
              dataType: "json",
              success: function(data) {
                payment_table = $("#payment_table").DataTable({
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

                    // // Update footer
                    // $( api.column( 1 ).footer() ).html(
                    //     'Total: <br>₱' + number_format(pageTotal,2)
                    // );
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
                        columns: [0, 1, 2, 3, 4, 5],
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
                        columns: [0, 1, 2, 3, 4, 5],
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
                    { data: "paymentmethod", name: "paymentmethod" },
                    { data: "paymentamount", name: "paymentamount" },
                    { data: "created_at", name: "created_at" },
                    { data: "checknumber", name: "checknumber" },
                    { data: "remarks", name: "remarks" },
                    { data: "r_balance", name: "r_balance" },
                    { data: "received_by", name: "received_by" },
                    { data: "action", orderable: false, searchable: false }
                  ]
                });
              }
            });
          }
        });
      }
    });
  });

  $(document).on("click", ".delete_payment", function(event) {
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
          url: "{{ route('delete_payment') }}",
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: { id: id },
          dataType: "text",
          success: function(data) {
            if (data == "deleted") {
              swal(
                "Payment Deleted!",
                "Successfully deleted a payment.",
                "success"
              );
            } else {
              var data2 = JSON.parse(data);
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
            }

            $.ajax({
              url: "{{ route('employee_view_payment') }}",
              method: "get",
              data: { id: person_id },
              dataType: "json",
              success: function(data) {
                payment_table = $("#payment_table").DataTable({
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
                  }
                });
              }
            });
          }
        });
      }
    });
  });

  // $(document).on('click', '.release_ca', function(event){
  //   event.preventDefault();
  //   id = $(this).attr("id");
  //   var input = $(this);
  //   var button = this;
  //   button.disabled = true; 
  //   $.ajax({
  //     url:"{{ route('check_balance_user') }}",
  //     method: 'POST',
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     },
  //     buttons: [
        
  //       {
  //         extend: "pdfHtml5",
  //         footer: true,
  //         exportOptions: {
  //           columns: [0, 1, 2, 3, 4, 5],
  //           modifier: {
  //             page: "current"
  //           }
  //         },
  //         customize: function(doc) {
  //           doc.styles.tableHeader.fontSize = 8;
  //           doc.styles.tableFooter.fontSize = 8;
  //           doc.defaultStyle.fontSize = 8;
  //           doc.content[1].table.widths = Array(
  //             doc.content[1].table.body[0].length + 1
  //           )
  //             .join("*")
  //             .split("");
  //         }
  //       }
  //     ],
  //     order: [[2, "desc"]],
  //     bDestroy: true,
  //     data: data,
  //     columns: [
  //       { data: "paymentmethod", name: "paymentmethod" },
  //       { data: "paymentamount", name: "paymentamount" },
  //       { data: "created_at", name: "created_at" },
  //       { data: "checknumber", name: "checknumber" },
  //       { data: "remarks", name: "remarks" },
  //       { data: "r_balance", name: "r_balance" },
  //       { data: "received_by", name: "received_by" },
  //       { data: "action", orderable: false, searchable: false }
  //     ]
  //   });
  // });

  // PRINT DTR

  $("#print_dtr").click(function(event) {
    event.preventDefault();
    $("#add_dtr").trigger("click");
    $("#print_form").trigger("click");
  });

  $("#print_form").click(function(event) {
    $("#employee_id_clone").val($("#employee_id option:selected").text());
    $("#role_clone").val($("#role").val());
    $("#overtime_clone").val($("#overtime").val());
    $("#rate_clone").val($("#rate").val());
    $("#num_hours_clone").val($("#num_hours").val());
    $("#salary_clone").val($("#salary").val());
    $("#bonus_clone").val($("#bonus").val());
    $("#balance_clone").val($("#emp_balance").val());
    $("#partial_payment_clone").val($("#p_payment").val());
    $("#sss_deductions_clone").val($("#sss-deductions").val());
    $("#phic_deductions_clone").val($("#phic-deductions").val());
    $("#hdmf_deductions_clone").val($("#hdmf-deductions").val());
    $("#lodging_deductions_clone").val($("#lodging-deductions").val());
    $("#other_deductions_clone").val($("#other-deductions").val());
    $("#remaining_balance_clone").val($("#emp_rbalance").val());
  });

  // END PRINT DTR

  // PRINT CA

  $("#print_ca").click(function(event) {
    event.preventDefault();
    $("#add_cash_advance").trigger("click");
    $("#print_form1").trigger("click");
  });

  $("#print_form1").click(function(event) {
    $("#customer_id_clone").val($("#employee_ca option:selected").text());
    $("#reason_clone").val($("#reason").val());
    $("#amount_clone").val($("#amount").val());
    $("#balance1_clone").val($("#balance").val());
    $("#received_clone").val($("#received").val());
    $("#month_clone").val($("#month").val());
  });

  // END PRINT CA

  // PRINT PAYMENT

  $("#print_balance_payment").click(function(event) {
    event.preventDefault();
    $("#add_payment").trigger("click");
    $("#print_balance_form").trigger("click");
  });

  $("#print_balance_form").click(function(event) {
    $("#customer_id1_clone").val(
      $("#employee_payment_id option:selected").text()
    );
    $("#paymentmethod_clone").val($("#paymentmethod option:selected").text());
    $("#checknumber_clone").val($("#checknumber").val());
    $("#amount2_clone").val($("#amount_payment").val());
    $("#balance2_clone").val($("#balancepayment").val());
    $("#remarks_clone").val($("#remarks").val());
  });

  // END PRINT PAYMENT

  function addCommas(nStr) {
    nStr += "";
    x = nStr.split(".");
    x1 = x[0];
    x2 = x.length > 1 ? "." + x[1] : "";
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, "$1" + "," + "$2");
    }
    return x1 + x2;
  }

  $(document).on("click", ".view_dtr", function(event) {
    event.preventDefault();
    var id = $(this).attr("id");
    idmain = id;
    person_id = id;

    $.ajax({
      url: "/refresh_view_total",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        total = addCommas(data);
      }
    });
    $.ajax({
      url: "/check_employee",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        if (data.balance == 0 || data.balance == null) {
          $("#balance_view").html("Balance: ₱ 0.00");
        } else {
          $("#balance_view").html(
            "Balance: ₱" +
              data.balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
          );
        }
      }
    });
    $.ajax({
      url: "{{ route('refresh_view_dtr') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        fname = data.data[0].fname;
        mname = data.data[0].mname;
        lname = data.data[0].lname;
        role = data.data[0].role;
        $(".modal_title_dtr").text(
          data.data[0].fname +
            " " +
            data.data[0].mname +
            " " +
            data.data[0].lname +
            " (" +
            data.data[0].role +
            ")  Pending Salary: ₱" +
            total
        );

        $("#view_dtr_name").val(
          fname +
            " " +
            mname +
            " " +
            lname +
            " (" +
            role +
            ")  Pending Salary: ₱" +
            total
        );

        dtr_info = $("#view_dtr_table").DataTable({
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

            total = calculateTotal(api, 14, true); // Total over all pages
            pageTotal = calculateTotal(api, 14); // Total over this page
            deductionsTotal = calculateTotal(api, 12); // Total deductions over this page

            // Update footer
            appendTotalToFooter(api, 14, pageTotal); // salary
            appendTotalToFooter(api, 12, deductionsTotal); // deductions
          },
          dom: "Blfrtip",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          bDestroy: true,
          buttons: [
            {
              extend: "print",
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                modifier: {
                  page: "current"
                }
              },
              title: $("#view_dtr_name").val(),
              customize: function(win) {
                $(win.document.body).css("font-size", "10pt");

                $(win.document.body)
                  .find("table")
                  .addClass("compact")
                  .css("font-size", "inherit");

                $(win.document.body)
                  .find("h1")
                  .css("font-size", "15pt");
              },
              footer: true
            },
            {
              extend: "pdfHtml5",
              title: $("#view_dtr_name").val(),
              footer: true,
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 13, 14, 15],
                modifier: {
                  page: "current"
                }
              },
              customize: function(doc) {
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 10
                doc.content[1].table.widths = Array(
                  doc.content[1].table.body[0].length + 1
                )
                  .join("*")
                  .split("");
              }
            }
          ],
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          data: data.data,
          columns: [
            { data: "overtime", name: "overtime" },
            { data: "num_hours", name: "num_hours" },
            {
              data: "created_at",
              name: "created_at",
              type: "date",
              render: function(value) {
                var ts = new Date(value);

                return ts.toLocaleDateString("en-US", dateOptions) + " " + ts.toLocaleTimeString('en-US', timeOptions);
              }
            },
            { data: "bonus", name: "bonus" },
            { data: "dtr_balance", name: "dtr_balance" },
            { data: "p_payment", name: "p_payment" },
            { data: "r_balance", name: "r_balance" },
            { data: "sss_deductions", name: "sss_deductions" },
            { data: "phic_deductions", name: "phic_deductions" },
            { data: "hdmf_deductions", name: "hdmf_deductions" },
            { data: "lodging_deductions", name: "lodging_deductions" },
            { data: "other_deductions", name: "other_deductions" },
            { data: "deductions", name: "deductions" },
            { data: "deductions", name: "total_deductions", visible: false, 
              render: function(data, type, row, meta) {
                return row.sss_deductions + ' /\n' +
                  row.phic_deductions + ' /\n' +
                  row.hdmf_deductions + ' /\n' +
                  row.lodging_deductions + ' /\n' +
                  row.other_deductions;
              } },
            { data: "salary", name: "salary" },
            { data: "status", name: "status" },
            { data: "released_by", name: "released_by" },
            { data: "action", orderable: false, searchable: false }
          ],
          order: [[2, "desc"]],
        });
        $("#dtr_view_modal").modal("show");
      }
    });
  });

  $("#employee_ca_modal").on("hidden.bs.modal", function(e) {
    $(this)
      .find("input,textarea,select")
      .val("")
      .end();
  });

  $("#dtr_modal").on("hidden.bs.modal", function(e) {
    $(this)
      .find("input,textarea,select")
      .val("")
      .end();

    $("#employee_id").select2("enable");
    trig_update = 0;
  });

  //CASH ADVANCE datatable ends here

  $(document).on("click", ".release_ca", function(event) {
    event.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      url: "{{ route('check_balance_user') }}",
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
        } else {
          $.ajax({
            url: "{{ route('release_ca_employee') }}",
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: { id: id },
            dataType: "json",
            success: function(data) {
              $.ajax({
                url: "{{ route('employee_view_ca') }}",
                method: "get",
                data: { id: person_id },
                dataType: "json",
                success: function(data) {
                  // $('.modal_title_ca').text(data.data[0].fname + " " + data.data[0].mname + " " + data.data[0].lname);

                  cash_advance_release = $("#view_employee_ca_table").DataTable(
                    {
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
                          // title: $("#view_dtr_name").val(),
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
                          // title: $("#view_dtr_name").val(),
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
                        { data: "reason", name: "reason" },
                        { data: "amount", name: "amount" },
                        { data: "created_at", name: "created_at" },
                        { data: "status", name: "status" },
                        { data: "released_by", name: "released_by" },
                        { data: "action", orderable: false, searchable: false }
                      ]
                    }
                  );
                }
              });
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

  $("#employee_id").select2({
    dropdownParent: $("#dtr_modal"),
    placeholder: "Select an employee"
  });
  $("#employee_ca").select2({
    dropdownParent: $("#employee_ca_modal"),
    placeholder: "Select an employee"
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

  $("#employee_payment_id").select2({
    dropdownParent: $("#payment_modal"),
    placeholder: "Select an employee"
  });
  $("#paymentmethod").select2({
    dropdownParent: $("#payment_modal"),
    placeholder: "Select a type of payment"
  });
});
</script>
@endsection
