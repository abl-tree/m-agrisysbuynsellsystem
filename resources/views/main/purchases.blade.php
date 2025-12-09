@extends(isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Purchases Dashboard</h2>
        </div>
    </div>

    <div class="modal fade" id="purchase_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog" role="document">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="card">
                        <div class="header">
                             <h2 class="modal_title">Add Purchases</h2>
                             <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button id="print_purchase" type="button" class="btn btn-sm btn-icon print-icon" ><i class="glyphicon glyphicon-print"></i></button>
                            </li>
                            <li class="dropdown">
                                <!-- <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_purchase') }}">
                                    <input type="hidden" name="button_action" id="button_action" value="">
                                    <input type="hidden" id="ticket_clone" name="ticket_clone">
                                    <input type="hidden" id="customer_clone" name="customer_clone">
                                    <input type="hidden" id="commodity_clone" name="commodity_clone">
                                    <input type="hidden" id="type_clone" name="type_clone">
                                    <input type="hidden" id="tare_clone" name="tare_clone">
                                    <input type="hidden" id="moist_clone" name="moist_clone">
                                    <input type="hidden" id="net_clone" name="net_clone">
                                    <input type="hidden" id="sacks_clone" name="sacks_clone">
                                    <input type="hidden" id="ca_clone" name="ca_clone">
                                    <input type="hidden" id="balance_clone" name="balance_clone">
                                    <input type="hidden" id="partial_clone" name="partial_clone">
                                    <input type="hidden" id="kilos_clone" name="kilos_clone">
                                    <input type="hidden" id="price_clone" name="price_clone">
                                    <input type="hidden" id="total_clone" name="total_clone">
                                    <input type="hidden" id="amount_clone" name="amount_clone">
                                    <input type="hidden" id="remarks_clone" name="remarks_clone">
                                    <input type="hidden" id="previous_balance_clone" name="previous_balance_clone">
                                    <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                </form> -->
                            </li>
                        </ul> 
                        </div>
                        <div class="body">
                             <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" id ="homeclick" href="#home">Customer Purchases</a></li>
                                <li><a data-toggle="tab" id="homeclick1" href="#home1">Walk-in Purchases</a></li>
                             </ul>
                             <div class="clearfix"></div>
                             <br>

                              <div class="tab-content">
                             <div id="home" class="tab-pane fade in active">
                             <form class="form-horizontal " id="purchase_form">
                                   <input type="hidden" name="stat1" id="stat1" value="old">
                                  <input type="hidden" name="id" id="id" value="">
                                  <input type="hidden" name="balance1" id="balance1" value="">
                                  <input type="hidden" name="last" id="last" value="">
                                  <input type="hidden" name="pr" id="pr" value="">
                                  <input type="hidden" name="suki" id="suki" value="">
                                  <input type="hidden" name="customerID" id="customerID" value="">
                                  <input type="hidden" name="commodityID" id="commodityID" value="">
                                  <input type="hidden" name="caID" id="caID" value="">
                                  <input type="hidden" name="cashLAST" id="cashLAST" value="">
                                  <input type="hidden" name="partialLAST" id="partialLAST" value="">
                                  <input type="hidden" name="balanceLAST" id="balanceLAST" value="">
                                  <input type="hidden" name="button_action1" id="button_action1" value="">
                                  <div class="row clearfix">
                                       <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Transaction Number</label>
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
                                        <label for="type">Customer</label>
                                  </div>
                                  <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 " id="flagupdate1">
                                        <div class="form-group">
                                             <select type="text" id="customer" name="customer" class="form-control" placeholder="Select company" required style="width:100%;">
                                                  <!-- @foreach($customer as $a)
                                                  <option value="{{ $a->id }}">{{ $a->lname }}, {{ $a->fname }} {{ $a->mname }}</option>
                                                  @endforeach -->
                                             </select>
                                        </div>
                                  </div>
                                  <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 " id="flagupdate">
                                            <div class="form-group">
                                                 <div class="form-line">
                                                      <input type="text" id="customerName" name="customerName" disabled="disabled"  name="customer" class="form-control"   required>
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
                                            <label for="type">Moisture</label>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                            <select  id="type1" name="type1" class="form-control" placeholder="Select item" required style="width:100%;">
                                                      <option value="Wet">Wet</option>
                                                      <option value="Dry">Dry</option>
                                                        </select>
                                            </div>
                                       </div>
                                  </div>

                                  <div class="row clearfix">
                                       <div class="col-md-4">
                                       <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                 <label for="name">Sacks</label>
                                                 <div class="form-line">
                                                      <input type="number" id="sacks" min="0"    name="sacks" class="form-control"   required>
                                                 </div>
                                            </div>
                                       </div>
                                  </div>
                                        <div class="col-md-4">
                                            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                 <div class="form-group">
                                                      <label for="name">Kilograms</label>
                                                      <div class="form-line">
                                                           <input type="number" id="kilo" min="0"   name="kilo"  class="form-control"   required>
                                                      </div>
                                                 </div>
                                            </div>
                                         </div>
                                         <div class="col-md-4">
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                             <div class="form-group">
                                                  <label for="name">Price</label>
                                                  <div class="form-line">
                                                       <input type="number" id="price" min="0"   name="price" readonly="readonly" value="" class="form-control" required>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                       </div>

                                    <div class="row clearfix">
                                    <div class="col-md-4">
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                             <div class="form-group">
                                                  <label for="name">Tare (KG)</label>
                                                  <div class="form-line">
                                                       <input type="number" id="tare" min="0"    name="tare" value="" class="form-control" required>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                         <div class="col-md-4">
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                             <div class="form-group">
                                                  <label for="name">Moisture (%)</label>
                                                  <div class="form-line">
                                                       <input type="number" min="0"   id="moist"  name="moist" value="" class="form-control" required>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="col-md-4">
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                             <div class="form-group">
                                                  <label for="name">Net Weight</label>
                                                  <div class="form-line">
                                                       <input type="number" id="net"  name="net" readonly="readonly" value="" class="form-control" required>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                       </div>   


                                  <div class="row clearfix">
                                       <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Previous Balance</label>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                 <div class="form-line">
                                                      <input type="number" id="ca" min="0"   name="ca" readonly="readonly" value="" class="form-control" required>
                                                 </div>
                                            </div>
                                       </div>
                                    
                                  </div>
                                  
                                  <div class="row clearfix">
                                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                           <label for="name">Cash Advance</label>
                                      </div>
                                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                           <div class="form-group input-group">
                                                <div class="form-line">
                                                    <input type="number"  min="0"   id="cash" name="cash"  class="form-control"   required>
                                                </div>
                                                <span class="input-group-btn">
                                                    <button type="button" id="resetNiCash" class="btn btn-primary waves-effect">Reset</button>
                                                </span>
                                           </div>
                                      </div>
                                 </div>

                                  <div class="row clearfix">
                                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                           <label for="name">Partial Payment</label>
                                      </div>
                                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                           <div class="form-group input-group">
                                                <div class="form-line">
                                                     <input type="number" id="partial" min="0"  name="partial"  class="form-control"   required>
                                                </div>
                                                <span class="input-group-btn">
                                                    <button type="button" id="resetNiPartial" class="btn btn-primary waves-effect">Reset</button>
                                                </span>
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
                                                      <input type="number" id="balance"  name="balance" readonly="readonly" value="" class="form-control" required>
                                                 </div>
                                            </div>
                                       </div>
                                  </div>





                                  <div class="row clearfix">
                                       <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Total</label>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                 <div class="form-line">
                                                      <input type="number" id="total" name="total" readonly="readonly" value="" class="form-control" required>
                                                 </div>
                                            </div>
                                       </div>
                                  </div>

                                  <div class="row clearfix">
                                       <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Amount to Pay</label>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                 <div class="form-line">
                                                      <input type="number" id="amount" name="amount" readonly="readonly" value="" class="form-control" required>
                                                 </div>
                                            </div>
                                       </div>
                                  </div>

                                  <div class="row clearfix">
                                       <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="type">Remarks</label>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                 <select type="text" id="remarks" name="remarks" class="form-control" placeholder="Select item" required style="width:100%;">

                                                      <option value="Good">Good</option>
                                                      <option value="Immature">Immature</option>
                                                      <option value="Reject">Reject</option>
                                                 </select>
                                            </div>
                                       </div>
                                  </div>

                             </form>
                                <div class="row clearfix">
                                    <div class="modal-footer">
                                        <div class="print-only">
                                            <form method="POST" id="printForm" name="printForm" target="_blank" action="{{ route('print_purchase') }}">
                                                <input type="hidden" name="button_action" id="button_action" value="">
                                                <input type="hidden" id="ticket_clone" name="ticket_clone">
                                                <input type="hidden" id="customer_clone" name="customer_clone">
                                                <input type="hidden" id="commodity_clone" name="commodity_clone">
                                                <input type="hidden" id="type_clone" name="type_clone">
                                                <input type="hidden" id="tare_clone" name="tare_clone">
                                                <input type="hidden" id="moist_clone" name="moist_clone">
                                                <input type="hidden" id="net_clone" name="net_clone">
                                                <input type="hidden" id="sacks_clone" name="sacks_clone">
                                                <input type="hidden" id="ca_clone" name="ca_clone">
                                                <input type="hidden" id="balance_clone" name="balance_clone">
                                                <input type="hidden" id="partial_clone" name="partial_clone">
                                                <input type="hidden" id="kilos_clone" name="kilos_clone">
                                                <input type="hidden" id="price_clone" name="price_clone">
                                                <input type="hidden" id="total_clone" name="total_clone">
                                                <input type="hidden" id="amount_clone" name="amount_clone">
                                                <input type="hidden" id="remarks_clone" name="remarks_clone">
                                                <input type="hidden" id="previous_balance_clone" name="previous_balance_clone">
                                                <button class="btn btn-sm btn-icon print-icon print-only" type="submit" name="print_form" id="print_form" title="PRINT ONLY">PRINT ONLY</button>
                                            </form>
                                        </div>
                                        <button type="submit" id="add_purchase" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                           <div id="home1" class="tab-pane fade in ">
                                <form class="form-horizontal " id="purchase_form1">
                                
                                     <input type="hidden" name="stat" id="stat" value="new">
                                     <input type="hidden" name="id1" id="id1" value="">
                                     <input type="hidden" name="balance2" id="balance2" value="">
                                     <input type="hidden" name="last1" id="last1" value="">
                                     <input type="hidden" name="pr1" id="pr1" value="">
                                     <input type="hidden" name="suki1" id="suki1" value="">
                                      <input type="hidden" name="ca1" id="ca1" value="">
                                      <input type="hidden" name="partial1" id="partial1" value="">
                                      <input type="hidden" name="balance1" id="balance1" value="">
                                       <input type="hidden" name="total1" id="total1" value="">
                                        <input type="hidden" name="pricenopad" id="pricenopad" value="">

                                        <input type="hidden" name="customerid" id="customerid" value="">

                                     <input type="hidden" name="button_action" id="button_action" value="">
                                     <div class="row clearfix">
                                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                               <label for="name">Transaction Number</label>
                                          </div>
                                          <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                               <div class="form-group">
                                                    <div class="form-line">
                                                         <input type="text" id="ticket1" name="ticket1" readonly="readonly" value="" class="form-control" required>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>

                                     <div class="row clearfix">
                                          <div class="col-md-4">
                                          <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                          </div>
                                          <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                               <div class="form-group">
                                                    <label for="name">First Name</label>
                                                    <div class="form-line">
                                                         <input type="text" id="fname"   name="fname" class="form-control"   required>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                           <div class="col-md-4">
                                               <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                               </div>
                                               <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                         <label for="name">Middle Name</label>
                                                         <div class="form-line">
                                                              <input type="text" id="mname" name="mname"  class="form-control"   required>
                                                         </div>
                                                    </div>
                                               </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                           </div>
                                           <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                     <label for="name">Last Name</label>
                                                     <div class="form-line">
                                                          <input type="text" id="lname" name="lname"  value="" class="form-control" required>
                                                     </div>
                                                </div>
                                           </div>
                                      </div>
                                          </div>

                                          <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                 <label for="lname">Address</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                 <div class="form-group">
                                                    <div class="form-line">
                                                         <input type="text" id="address" name="address" class="form-control" placeholder="Enter customer's address"  >
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="lname">Contacts</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" id="contacts" name="contacts" class="form-control" placeholder="Enter customer's contact number">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="lname">Cash Advance</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" id="bal" name="bal" class="form-control" placeholder="Enter customer's cash advance">
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
                                                    <select type="text" id="commodity1" name="commodity1" class="form-control" placeholder="Select item" required style="width:100%;">
                                                         @foreach($commodity as $a)
                                                         <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                         @endforeach
                                                    </select>
                                               </div>
                                          </div>
                                     </div>
                                    
                                   <div class="row clearfix">
                                       <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="type">Moisture</label>
                                       </div>
                                       <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                            <select  id="type2" name="type2" class="form-control" placeholder="Select item" required style="width:100%;">
                                                      <option value="Wet">Wet</option>
                                                      <option value="Dry">Dry</option>
                                                        </select>
                                            </div>
                                       </div>
                                  </div>

                                     <div class="row clearfix">
                                          <div class="col-md-4">
                                          <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                          </div>
                                          <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                               <div class="form-group">
                                                    <label for="name">Sacks</label>
                                                    <div class="form-line">
                                                         <input type="number" id="sacks1" min="0"     name="sacks1" class="form-control"   required>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                           <div class="col-md-4">
                                               <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5 form-control-label">

                                               </div>
                                               <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                         <label for="name">Kilograms</label>
                                                         <div class="form-line">
                                                              <input type="number" id="kilo1" min="0"   name="kilo1" onkeyup="kilos2(this)" class="form-control"   required>
                                                         </div>
                                                    </div>
                                               </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                           </div>
                                           <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                     <label for="name">Price</label>
                                                     <div class="form-line">
                                                          <input type="number" id="price1" name="price1" readonly="readonly" value="" class="form-control" required>
                                                     </div>
                                                </div>
                                           </div>
                                      </div>
                                          </div>

                                <div class="row clearfix">
                                    <div class="col-md-4">
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                             <div class="form-group">
                                                  <label for="name">Tare (KG)</label>
                                                  <div class="form-line">
                                                       <input type="number" id="tare2" min="0"   name="tare2"  value="" class="form-control" required>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                         <div class="col-md-4">
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                             <div class="form-group">
                                                  <label for="name">Moisture (%)</label>
                                                  <div class="form-line">
                                                       <input type="number" id="moist2" min="0"   name="moist2" value="" class="form-control" required>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="col-md-4">
                                         <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                             <div class="form-group">
                                                  <label for="name">Net Weight</label>
                                                  <div class="form-line">
                                                       <input type="number" id="net2" min="0"   name="net2" readonly="readonly" value="" class="form-control" required>
                                                  </div>
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
                                                         <input type="number" id="partialpayment" min="0"   name="partialpayment"  value="" class="form-control" required>
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
                                                         <input type="number" readonly="readonly" id="balanceWALKIN" name="balanceWALKIN"  value="" class="form-control" required>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                     <div class="row clearfix">
                                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                               <label for="name">Total</label>
                                          </div>
                                          <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                               <div class="form-group">
                                                    <div class="form-line">
                                                         <input type="number" id="amount1" min="0"   name="amount1" readonly="readonly" value="" class="form-control" required>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>

                                    <div class="row clearfix">
                                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                               <label for="name">Amount to pay</label>
                                          </div>
                                          <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                               <div class="form-group">
                                                    <div class="form-line">
                                                         <input type="number" id="amountpay1" min="0"   name="amountpay1" readonly="readonly" value="" class="form-control" required>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>   

                                     <div class="row clearfix">
                                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                               <label for="type">Remarks</label>
                                          </div>
                                          <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                               <div class="form-group">
                                                    <select type="text" id="remarks1" name="remarks1" class="form-control" placeholder="Select item" required style="width:100%;">

                                                         <option value="Good">Good</option>
                                                         <option value="Immature">Immature</option>
                                                         <option value="Reject">Reject</option>
                                                    </select>
                                               </div>
                                          </div>
                                     </div>

                                </form>
                                    <div class="row clearfix">
                                        <div class="modal-footer">
                                        <button class="btn btn-sm btn-icon print-icon print-only" id="print_form1" title="PRINT ONLY">PRINT ONLY</button>
                                        <button type="submit" id="add_purchase1" class="btn btn-link waves-effect">SAVE CHANGES</button>
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
    <div class="modal fade" id="release_purchase_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Are You Sure?</h2>
                    </div>
                    <div class="body">                      
                            <div class="row clearfix">
                                <div class="modal-footer">
                                    <button type="button" id="release_purchase_normal" class="btn btn-success waves-effect">CONTINUE</button>
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
                        <h2>List of Purchases as of {{ date('Y-m-d ') }}</h2>
                             <ul class="header-dropdown m-r--5">
                                  <li class="dropdown">
                                    @if(isAdmin() || isPurchaser())
                                       <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 open_purchase_modal"><i class="material-icons">library_add</i></button>
                                    @endif
                                  </li>
                             </ul>
                        </div>
                         
                        <div class="body"> 
                             <div class="table-responsive">
                             
                             <div style="margin-bottom: -62px; margin-left: 480px;z-index: 999;">
                              <h5>Commodity Filter</h5>
                              <select style="width: 150px;" type="text" id="commodityfilter" name="commodityfilter" data-placeholder="Select Commodity" >
                                    <option value="none">All</option>
                                     @foreach($commodity as $a)
                                     <option value="{{ $a->name }}">{{ $a->name }}</option>
                                     @endforeach
                                </select>
                            </div>
                              <p id="date_filter">
                                <h5>Date Range Filter</h5>
                                <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="purchase_datepicker_from" />
                                <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text" id="purchase_datepicker_to" />
                            </p>
                            <button type="button" class="btn bg-grey btn-xs waves-effect m-r-20 refresh_table"><i class="material-icons">cached</i></button><br><br>
                                <table id="purchasetable" class="table table-bordered table-striped table-hover" style="z-index: -1;">
                                  
                                       <thead>
                                            <tr>
                                                 <th width="100" style="text-align:center;">ID</th>
                                                 <th width="100" style="text-align:center;">Customer</th>
                                                 <th width="100" style="text-align:center;">mname</th>
                                                 <th width="100" style="text-align:center;">lname</th>
                                                 <th width="100" style="text-align:center;">Commodity</th>
                                                 <th width="100" style="text-align:center;">No. of Sacks</th>
                                                 <th width="100" style="text-align:center;">Cash Advance</th>
                                                 <th width="100" style="text-align:center;">Partial Payment</th>
                                                 <th width="100" style="text-align:center;">Previous Balance </th>
                                                 <th width="100" style="text-align:center;">Balance </th>
                                                 <th width="100" style="text-align:center;" >No. of Kilos</th>
                                                 <th width="100" style="text-align:center;" >Moisture</th>
                                                 <th width="100" style="text-align:center;" >Tare</th>
                                                 <th width="100" style="text-align:center;" >Moisture %</th>
                                                 <th width="100" style="text-align:center;" >Net Weight</th>
                                                 <th width="100" style="text-align:center;">Price</th>
                                                 <th width="100" style="text-align:center;">Total</th>
                                                 <th width="100" style="text-align:center;">Amount Paid</th>
                                                 <th width="100" style="text-align:center;">Date</th>
                                                 <th width="100" style="text-align:center;">Status</th>
                                                 <th width="100" style="text-align:center;">Released By</th>
                                                 <th width="100" style="text-align:center;">Remarks</th>
                                                 <th width="150" style="text-align:center;">Releasing</th>
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
    </div>
@endsection


@section('script')
<script>
var kilo = 0;
var price = 0;
var tare = 0;
var moist = 0;
var net = 0;
var percentage = 0;
var ca = 0;
var partial = 0;
var balance = 0;
var prev = 0;
var total = 0;
var amtpay = 0;

$("#kilo").blur(function() {
  if ($("#kilo").val() == "") {
    $("#kilo").val("0");
  }
  computeAll();
});
$("#cash").blur(function() {
  var mois = $("#moist").val();
  console.log(mois);

  $("#moist").val("0");
  computeAll();
  $("#moist").val(mois);
  computeAll();
});
$("#partial").blur(function() {
  var mois = $("#moist").val();
  console.log(mois);

  $("#moist").val("0");
  computeAll();
  $("#moist").val(mois);
  computeAll();
});
$("#tare").blur(function() {
  if ($("#tare").val() == "") {
    $("#tare").val("0");
  }
  computeAll();
});
$("#moist").blur(function() {
  if ($("#moist").val() == "") {
    $("#moist").val("0");
  }
  computeAll();
});

$("#tare2").blur(function() {
  if ($("#tare2").val() == "") {
    $("#tare2").val("0");
  }
  tare3();
});
$("#moist2").blur(function() {
  var mois = $("#moist2").val();
  console.log(mois);

  $("#moist2").val("0");
  moist3();
  $("#moist2").val(mois);
  moist3();
});
$("#bal").blur(function() {
  var mois = $("#moist2").val();
  console.log(mois);

  $("#moist2").val("0");
  compute();
  $("#moist2").val(mois);
  compute();
});
$("#partialpayment").blur(function() {
  var mois = $("#partialpayment").val();
  console.log(mois);

  $("#partialpayment").val("0");
  compute();
  $("#partialpayment").val(mois);
  compute();
});
function computeAll(value) {
  if ($("#kilo").val() != "") {
    kilo = parseFloat($("#kilo").val()) > 0 ? parseFloat($("#kilo").val()) : 0;
  }
  if ($("#price").val() != "") {
    price =
      parseFloat($("#price").val()) > 0 ? parseFloat($("#price").val()) : 0;
  }
  if ($("#tare").val() != "") {
    tare = parseFloat($("#tare").val()) > 0 ? parseFloat($("#tare").val()) : 0;
  }
  if ($("#moist").val() != "") {
    moist =
      parseFloat($("#moist").val()) > 0 ? parseFloat($("#moist").val()) : 0;
  }
  if ($("#cash").val() != "") {
    ca = parseFloat($("#cash").val()) > 0 ? parseFloat($("#cash").val()) : 0;
  }
  if ($("#partial").val() != "") {
    partial =
      parseFloat($("#partial").val()) > 0 ? parseFloat($("#partial").val()) : 0;
  }
  if ($("#balance").val() != "") {
    balance = parseFloat($("#balance").val());
  }
  if ($("#ca").val() != "") {
    prev = parseFloat($("#ca").val());
  }
  if ($("#net").val() != "") {
    net = parseFloat($("#net").val());
  }
  console.log("net:", net);
  console.log("moist:", moist);
  percentage = (moist / 100) * net;
  console.log("percentage:", percentage);
  net = kilo - tare - percentage;
  total = net * price;
  let ca_to_partial = 0;
  if (partial > parseFloat(ca + prev) || partial > parseFloat(total + ca)) {
    ca_to_partial = 0;
    partial = 0;
    $("#partial").val("");
  } else {
    ca_to_partial = ca > 0 ? ca - partial : partial;
  }
  amtpay = ca > 0 ? ca_to_partial + total : total - partial;
  balance = prev + ca - partial;
  $("#total").val(parseFloat(total).toFixed(2));
  $("#amount").val(parseFloat(amtpay).toFixed(2));
  $("#balance").val(parseFloat(balance).toFixed(2));
  $("#net").val(parseFloat(net).toFixed(2));
}

$("form").on("focus", "input[type=number]", function(e) {
  $(this).on("mousewheel.disableScroll", function(e) {
    e.preventDefault();
  });
});
$("form").on("blur", "input[type=number]", function(e) {
  $(this).off("mousewheel.disableScroll");
});
$("#resetNiCash").click(function() {
  $("#cash").prop("disabled", false);
  var t = 0;
  var x = 0;
  var flag = false;
  if ($("#ca").val() != "") {
    t = parseFloat($("#ca").val());
  }
  if ($("#cashLAST").val() != "") {
    x = parseFloat($("#cashLAST").val());
  }
  t = t - x;
  $("#ca").val(t);
  $("#balance").val(t);
  $("#cash").val(0);
  $("#resetNiCash").hide();
});
$("#resetNiPartial").click(function() {
  $("#partial").prop("disabled", false);
  var t = 0;
  var y = 0;
  var x = 0;
  if ($("ca").val() != "") {
    t = parseFloat($("#ca").val());
  }
  if ($("#partial").val() != "") {
    y = parseFloat($("#partial").val());
  }

  if ($("#amount").val() != "") {
    x = parseFloat($("#amount").val());
  }
  t = parseFloat($("#balanceLAST").val()) + y;
  x = x + y;
  $("#ca").val(t);
  $("#balance").val(t);
  $("#partial").val(0);
  $("#amount").val(x);
  $("#resetNiPartial").hide();
});
var purchasestable;
var purchase_date_from = "";
var purchase_date_to = "";
var id;
var commodityselected = "";
function compute(value) {
  var total = parseFloat($("#total1").val());
  var amount = parseFloat($("#amountpay1").val());
  var balance = parseFloat($("#balanceWALKIN").val());
  var partial = parseFloat($("#partialpayment").val());
  if ($("#bal").val() != "") {
    var t = parseFloat($("#bal").val());

    var x = 0;
    if ($("#partialpayment").val() != "") {
      x = parseFloat($("#partialpayment").val());
    }
    console.log(amount);
    t = t - x;
    $("#balanceWALKIN").val(parseFloat(t).toFixed(2));
    $("#amountpay1").val(parseFloat(amount - x).toFixed(2));
  }
  if ($("#partialpayment").val() == "" || $("#partialpayment").val() == 0) {
    $("#partialpayment").val(0);
    $("#amountpay1").val(parseFloat(total + balance).toFixed(2));
  } else {
    $("#amountpay1").val(parseFloat(total + balance - partial).toFixed(2));
  }
  if ($("#bal").val() == "") {
    $("#balanceWALKIN").val(0);
  }
}

function tare3(value) {
  if ($("#moist2").val() == "") {
    $("#moist2").val(0);
    var t = parseFloat($("#total1").val());
    var kilo = parseFloat($("#kilo1").val());
    var amount = parseFloat($("#amount1").val());
    var partialpayment = parseFloat($("#partialpayment").val());
    var tare = 0;
    if ($("#tare2").val()) {
      tare = parseFloat($("#tare2").val());
    }
    var partial = 0;

    if ($("#partial1").val() != "") {
      partial = parseFloat($("#partial1").val());
    }

    var price = parseFloat($("#price1").val());
    var temp = price * (kilo - tare) - partial;
    var temp1 = price * (kilo - tare);
    var temp3 = kilo - tare;
    var x = parseFloat(temp).toFixed(2);
    var y = parseFloat(temp1).toFixed(2);
    var z = parseFloat(temp1).toFixed(2);
    $("#amount1").val(x);
    $("#total1").val(x);
    if ($("#partialpayment").val() != "") {
      x = x - partialpayment;
      $("#amountpay1").val(x);
    } else {
      $("#amountpay1").val(x);
    }
    if ($("#bal").val() != "" && $("#bal").val() != "0") {
      if ($("#partialpayment").val() != "") {
        var t = parseFloat($("#bal").val());
        t = t - partialpayment;

        $("#bal").val(t);
      }
    }
    if ($("#tare2").val() != "") {
      $("#net2").val(temp3);
    } else {
      $("#net2").val(kilo);
    }
  }

  if ($("#moist2").val() != "") {
    var t = parseFloat($("#total1").val());
    var kilo = parseFloat($("#kilo1").val());
    var amount = parseFloat($("#amount1").val());
    var partialpayment = parseFloat($("#partialpayment").val());
    var moist = 0;
    if ($("#moist2").val() != "") {
      moist = parseFloat($("#moist2").val());
    }
    var tare = 0;
    if ($("#tare2").val() != "") {
      tare = parseFloat($("#tare2").val());
    }
    var partial = 0;
    if ($("#partial1").val() != "") {
      partial = parseFloat($("#partial1").val());
    }
    var price = parseFloat($("#price1").val());
    var temp4 = (moist / 100) * kilo;
    var temp5 = temp4 * price;
    var x2 = parseFloat(temp5).toFixed(2);
    var x1 = parseFloat(temp4).toFixed(2);
    var temp = price * (kilo - tare) - temp5 - partial;
    var temp1 = price * (kilo - tare) - temp5;
    var temp3 = kilo - temp4 - tare;

    var x = parseFloat(temp).toFixed(2);
    var y = parseFloat(temp1).toFixed(2);
    var z = parseFloat(temp1).toFixed(2);
    $("#amount1").val(x);
    $("#total1").val(x);

    if ($("#partialpayment").val() != "") {
      x = x - partialpayment;
      $("#amountpay1").val(x);
    } else {
      $("#amountpay1").val(x);
    }
    $("#net2").val(temp3);
  }
}
function moist3(value) {
  if ($("#moist2").val() == "") {
    $("#moist2").val(0);
  }
  // if( $('#tare2').val() == ""  ){
  //     var total = parseFloat($('#total1').val());
  //     var moist = 0;
  //     var partialpayment = parseFloat($('#partialpayment').val());
  //     if($('#moist2').val()!=""){
  //         moist = parseFloat($('#moist2').val());
  //     }
  //     var kilo = parseFloat($('#kilo1').val());
  //     var amount = parseFloat($('#amount1').val());
  //     var tare = 0;
  //     if($('#tare2').val()!=""){
  //         tare = parseFloat($('#tare2').val());
  //     }
  //     var price = parseFloat($('#price1').val());
  //     var partial = 0;
  //     if($('#partial1').val()!=""){
  //         partial =  parseFloat($('#partial1').val());
  //     }
  //     var temp4 = moist/100 * kilo;
  //     var temp5 = temp4*price;
  //     var temp6 = (kilo * price) - temp5;
  //     var temp7 = ((kilo * price) - partial)-temp5 ;
  //     var temp8 = kilo - temp4;
  //     var x5 = parseFloat(temp8).toFixed(2);
  //     var x4 = parseFloat(temp7).toFixed(2);
  //     var x3 = parseFloat(temp6).toFixed(2);
  //     var x2 = parseFloat(temp5).toFixed(2);
  //     var x1 = parseFloat(temp4).toFixed(2);
  //     $('#amount1').val(x4);
  //     $('#total1').val(x3);
  //     if($('#partialpayment').val()!=""){
  //         x4 = x4-partialpayment;
  //         $('#amountpay1').val(x4);
  //     }
  //     else{
  //     $('#amountpay1').val(x4);
  //     }
  //     $('#net2').val(x5);
  // }
  if ($("#tare2").val() != "") {
    console.log("dri");
    var partialpayment = parseFloat($("#partialpayment").val());
    var bal = parseFloat($("#balanceWALKIN").val());
    var total = parseFloat($("#total1").val());
    var moist = parseFloat($("#moist2").val());
    var kilo = parseFloat($("#kilo1").val());
    var net = parseFloat($("#net2").val());
    var amount = parseFloat($("#amount1").val());
    var tare = parseFloat($("#tare2").val());
    var price = parseFloat($("#price1").val());
    var partial = 0;
    if ($("#partial1").val() != "") {
      partial = parseFloat($("#partial1").val());
    }
    var percentage = (moist / 100) * net;
    var temp5 = percentage * price;
    var temp6 = kilo * price - temp5 - tare * price;
    var temp8 = kilo - tare - percentage;
    var temp7 = temp8 * price;

    var x5 = parseFloat(temp8).toFixed(2);
    var x4 = parseFloat(temp7).toFixed(2);
    var x3 = parseFloat(temp6).toFixed(2);
    var x2 = parseFloat(temp5).toFixed(2);
    // var x1 = parseFloat(temp4).toFixed(2);
    $("#amount1").val(x4);
    $("#total1").val(x3);
    if ($("#partialpayment").val() != "") {
      x4 = x4 - partialpayment;
      $("#amountpay1").val(x4);
    }
    if ($("#bal").val() != "" || $("#bal").val() != "0") {
      x4 = parseFloat(x4) + parseFloat(bal);
      $("#amountpay1").val(x4);
    } else {
      $("#amountpay1").val(x4);
    }
    $("#net2").val(x5);
  }
}
$(document).ready(function() {
  $(".refresh_table").click(function() {
    refresh_purchase_table();
  });

  document.title = "{{ env('APP_NAME') }} - Purchases";

  //Delete Purchases
  $(document).on("click", ".delete_purchase", function() {
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
          url: "{{ route('delete_purchases') }}",
          method: "get",
          data: { id: id },
          success: function(data) {
            console.log(data);
            swal(data.title, data.description, data.type);
            if (data.cash != null) {
              $("#curCashOnHand").html(data.cash);
            }
            refresh_purchase_table();
          }
        });
      }
    });
  });

  $(document).on("click", ".edit_purchase", function() {
    $("#homeclick1").hide();
    $("#homeclick").trigger("click");
    var id = $(this).attr("id");
    $(".modal_title").text("Update Purchases");
    $("#resetNiCash").show();
    $("#resetNiPartial").show();
    $.ajax({
      url: "{{ route('update_purchases') }}",
      method: "get",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#button_action1").val("update");
        $("#id").val(id);
        // $('#customer').select2('enable',false);
        $("#flagupdate1").hide();
        $("#flagupdate").show();
        $("#customerName").val(data.name);
        $("#customerID").val(data.customer_id);
        $("#commodityID").val(data.commodity_id);
        $("#caID").val(data.ca_id);
        $("#ticket").val(data.trans_no);
        $("#commodity")
          .val(data.commodity_id)
          .trigger("change");
        $("#sacks").val(data.sacks);
        $("#tare").val(data.tare);
        $("#net").val(data.net);
        $("#partial").val(data.partial);
        $("#partialLAST").val(data.partial);
        $("#cashLAST").val(data.balance_id);
        $("#cash").val(data.balance_id);
        $("#cash").prop("disabled", true);
        $("#partial").prop("disabled", true);
        $("#moist").val(data.moist);
        $("#type")
          .val(data.type)
          .trigger("change");
        $("#kilo").val(data.kilo);
        $("#price").val(data.price);
        $("#total").val(data.total);
        $("#amount").val(data.amtpay);
        $("#remarks")
          .val(data.remarks)
          .trigger("change");
        var a = data.customer_id;
        $.ajax({
          url: "{{ route('find_amt') }}",
          data: { id: a },
          dataType: "json",
          success: function(data) {
            $("#ca").val(data.balance);
            $("#balance").val(data.balance);
            $("#balance1").val(data.balance);
            $("#balanceLAST").val(data.balance);
            $("#last").val(data.suki_type);
          }
        });
        $("#purchase_modal").modal("show");
      }
    });
  });

  $("#homeclick").on("click", function() {
    $("#stat").val("old");
    $("#stat1").val("old");
  });

  $("#homeclick1").on("click", function() {
    $("#stat").val("new");
    $("#stat1").val("new");
  });

  $("#last").val(1);
  $("#balance").val("0");
  $("#ca1").val("0");
  $("#partial").val("0");
  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });
  $("#commodityfilter").on("change", function(e) {
    commodityselected = this.value;
    console.log(commodityselected);
    console.log(purchase_date_from);
    console.log(purchase_date_to);
    $("#purchasetable")
      .dataTable()
      .fnDestroy();
    purchasestable = $("#purchasetable").DataTable({
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

        // Total over this page
        pageTotal4 = api
          .column(10, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(10).footer()).html(
          "Total: <br>" + number_format(pageTotal4, 2) + " kg"
        );

        // Total over this page
        pageTotal5 = api
          .column(16, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(16).footer()).html(
          "Total: <br>₱" + number_format(pageTotal5, 2)
        );

        // Total over this page
        pageTotal6 = api
          .column(17, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(17).footer()).html(
          "Total: <br>₱" + number_format(pageTotal6, 2)
        );

        // Total over this page
        pageTotal7 = api
          .column(14, { page: "current" })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(14).footer()).html(
          "Total: <br>" + number_format(pageTotal7, 2) + " kg"
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
          pageSize: "LEGAL",
          exportOptions: {
            columns: [
              0,
              1,
              4,
              5,
              6,
              7,
              8,
              9,
              10,
              11,
              12,
              13,
              14,
              15,
              16,
              17,
              18,
              19,
              20
            ],
            modifier: {
              page: "current"
            }
          },
          customize: function(win) {
            var last = null;
            var current = null;
            var bod = [];

            var css = "@page { size: landscape; }",
              head =
                win.document.head ||
                win.document.getElementsByTagName("head")[0],
              style = win.document.createElement("style");

            style.type = "text/css";
            style.media = "print";

            if (style.styleSheet) {
              style.styleSheet.cssText = css;
            } else {
              style.appendChild(win.document.createTextNode(css));
            }

            head.appendChild(style);

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
          orientation: "landscape",
          pageSize: "LEGAL",
          exportOptions: {
            columns: [
              0,
              1,
              4,
              5,
              6,
              7,
              8,
              9,
              10,
              11,
              12,
              13,
              14,
              15,
              16,
              17,
              18,
              19,
              20
            ],
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
      scrollX: true,
      fixedColumns: {
        leftColumns: 2,
        rightColumns: 1
      },
      processing: true,

      order: [],
      columnDefs: [
        {
          targets: "_all", // your case first column
          className: "text-center"
        }
      ],
      ajax: {
        url: "{{ route('refresh_purchases') }}",
        // dataType: 'text',
        type: "post",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        data: {
          date_from: purchase_date_from,
          date_to: purchase_date_to,
          commodity: commodityselected
        }
      },
      columns: [
        { data: "trans_no" },
        { data: "wholename", name: "customer.fname" },
        { data: "mname", name: "customer.mname", visible: false },
        { data: "lname", name: "customer.lname", visible: false },
        { data: "commname", name: "commodity.name" },
        { data: "sacks" },
        { data: "balance_id" },
        { data: "partial" },
        { data: "previous_bal" },
        { data: "balance" },
        { data: "kilo" },
        { data: "type" },
        { data: "tare" },
        { data: "moist" },
        { data: "net" },
        { data: "price" },
        { data: "total" },
        { data: "amtpay" },
        { data: "created_at" },
        { data: "status" },
        { data: "released_by" },
        { data: "remarks" },
        { data: "action", orderable: false, searchable: false }
      ]
    });
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

  purchasestable = $("#purchasetable").DataTable({
    footerCallback: function(row, data, start, end, display) {
      console.log(data);
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

      // Total over this page
      pageTotal4 = api
        .column(10, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(10).footer()).html(
        "Total: <br>" + number_format(pageTotal4, 2) + " kg"
      );

      // Total over this page
      pageTotal5 = api
        .column(16, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(16).footer()).html(
        "Total: <br>₱" + number_format(pageTotal5, 2)
      );

      // Total over this page
      pageTotal6 = api
        .column(17, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(17).footer()).html(
        "Total: <br>₱" + number_format(pageTotal6, 2)
      );

      // Total over this page
      pageTotal7 = api
        .column(14, { page: "current" })
        .data()
        .reduce(function(a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(14).footer()).html(
        "Total: <br>" + number_format(pageTotal7, 2) + " kg"
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
        pageSize: "LEGAL",
        exportOptions: {
          columns: [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14,
            15,
            16,
            17,
            18,
            19,
            20
          ],
          modifier: {
            page: "current"
          }
        },
        customize: function(win) {
          var last = null;
          var current = null;
          var bod = [];

          var css = "@page { size: landscape; }",
            head =
              win.document.head || win.document.getElementsByTagName("head")[0],
            style = win.document.createElement("style");

          style.type = "text/css";
          style.media = "print";

          if (style.styleSheet) {
            style.styleSheet.cssText = css;
          } else {
            style.appendChild(win.document.createTextNode(css));
          }

          head.appendChild(style);

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
        orientation: "landscape",
        pageSize: "LEGAL",
        exportOptions: {
          columns: [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14,
            15,
            16,
            17,
            18,
            19,
            20
          ],
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

    scrollX: true,
    fixedColumns: {
      leftColumns: 2,
      rightColumns: 1
    },
    order: [],
    columnDefs: [
      {
        targets: "_all", // your case first column
        className: "text-center"
      }
    ],
    ajax: {
      url: "{{ route('refresh_purchases') }}",
      // dataType: 'text',
      type: "post",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        date_from: purchase_date_from,
        date_to: purchase_date_to,
        commodity: commodityselected
      }
    },
    columns: [
      { data: "trans_no" },
      { data: "wholename", name: "customer.fname" },
      { data: "mname", name: "customer.mname", visible: false },
      { data: "lname", name: "customer.lname", visible: false },
      { data: "commname", name: "commodity.name" },
      { data: "sacks" },
      { data: "balance_id" },
      { data: "partial" },
      { data: "previous_bal" },
      { data: "balance" },
      { data: "kilo" },
      { data: "type" },
      { data: "tare" },
      { data: "moist" },
      { data: "net" },
      { data: "price" },
      { data: "total" },
      { data: "amtpay" },
      { data: "created_at" },
      { data: "status" },
      { data: "released_by" },
      { data: "remarks" },
      { data: "action", orderable: false, searchable: false }
    ]
  });

  //Start of Date Range Filter
  $("#purchase_datepicker_from")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        minDateFilter = new Date(date).getTime();
        var df = new Date(date);
        purchase_date_from =
          df.getFullYear() + "-" + (df.getMonth() + 1) + "-" + df.getDate();
        $("#purchasetable")
          .dataTable()
          .fnDestroy();
        purchasestable = $("#purchasetable").DataTable({
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

            // Total over this page
            pageTotal4 = api
              .column(10, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(10).footer()).html(
              "Total: <br>" + number_format(pageTotal4, 2) + " kg"
            );

            // Total over this page
            pageTotal5 = api
              .column(16, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(16).footer()).html(
              "Total: <br>₱" + number_format(pageTotal5, 2)
            );

            // Total over this page
            pageTotal6 = api
              .column(17, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(17).footer()).html(
              "Total: <br>₱" + number_format(pageTotal6, 2)
            );

            // Total over this page
            pageTotal7 = api
              .column(14, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(14).footer()).html(
              "Total: <br>" + number_format(pageTotal7, 2) + " kg"
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
              pageSize: "LEGAL",
              exportOptions: {
                columns: [
                  0,
                  1,
                  4,
                  5,
                  6,
                  7,
                  8,
                  9,
                  10,
                  11,
                  12,
                  13,
                  14,
                  15,
                  16,
                  17,
                  18,
                  19,
                  20
                ],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                var last = null;
                var current = null;
                var bod = [];

                var css = "@page { size: landscape; }",
                  head =
                    win.document.head ||
                    win.document.getElementsByTagName("head")[0],
                  style = win.document.createElement("style");

                style.type = "text/css";
                style.media = "print";

                if (style.styleSheet) {
                  style.styleSheet.cssText = css;
                } else {
                  style.appendChild(win.document.createTextNode(css));
                }

                head.appendChild(style);

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
              orientation: "landscape",
              pageSize: "LEGAL",
              exportOptions: {
                columns: [
                  0,
                  1,
                  4,
                  5,
                  6,
                  7,
                  8,
                  9,
                  10,
                  11,
                  12,
                  13,
                  14,
                  15,
                  16,
                  17,
                  18,
                  19,
                  20
                ],
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
          scrollX: true,
          fixedColumns: {
            leftColumns: 2,
            rightColumns: 1
          },
          processing: true,

          order: [],
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          ajax: {
            url: "{{ route('refresh_purchases') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: purchase_date_from,
              date_to: purchase_date_to,
              commodity: commodityselected
            }
          },
          columns: [
            { data: "trans_no" },
            { data: "wholename", name: "customer.fname" },
            { data: "mname", name: "customer.mname", visible: false },
            { data: "lname", name: "customer.lname", visible: false },
            { data: "commname", name: "commodity.name" },
            { data: "sacks" },
            { data: "balance_id" },
            { data: "partial" },
            { data: "previous_bal" },
            { data: "balance" },
            { data: "kilo" },
            { data: "type" },
            { data: "tare" },
            { data: "moist" },
            { data: "net" },
            { data: "price" },
            { data: "total" },
            { data: "amtpay" },
            { data: "created_at" },
            { data: "status" },
            { data: "released_by" },
            { data: "remarks" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      $("#purchasetable")
        .dataTable()
        .fnDestroy();
      purchase_date_from = "";
      purchasestable = $("#purchasetable").DataTable({
        dom: "Blfrtip",
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
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

          // Total over this page
          pageTotal4 = api
            .column(10, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(10).footer()).html(
            "Total: <br>" + number_format(pageTotal4, 2) + " kg"
          );

          // Total over this page
          pageTotal5 = api
            .column(16, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(16).footer()).html(
            "Total: <br>₱" + number_format(pageTotal5, 2)
          );

          // Total over this page
          pageTotal6 = api
            .column(17, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(17).footer()).html(
            "Total: <br>₱" + number_format(pageTotal6, 2)
          );

          // Total over this page
          pageTotal7 = api
            .column(14, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(14).footer()).html(
            "Total: <br>" + number_format(pageTotal7, 2) + " kg"
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
            pageSize: "LEGAL",
            exportOptions: {
              columns: [
                0,
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18
              ],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              var last = null;
              var current = null;
              var bod = [];

              var css = "@page { size: landscape; }",
                head =
                  win.document.head ||
                  win.document.getElementsByTagName("head")[0],
                style = win.document.createElement("style");

              style.type = "text/css";
              style.media = "print";

              if (style.styleSheet) {
                style.styleSheet.cssText = css;
              } else {
                style.appendChild(win.document.createTextNode(css));
              }

              head.appendChild(style);

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
            orientation: "landscape",
            pageSize: "LEGAL",
            exportOptions: {
              columns: [
                0,
                1,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18,
                19,
                20
              ],
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
        scrollX: true,
        fixedColumns: {
          leftColumns: 2,
          rightColumns: 1
        },
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('refresh_purchases') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: purchase_date_from,
            date_to: purchase_date_to,
            commodity: commodityselected
          }
        },
        columns: [
          { data: "trans_no" },
          { data: "wholename", name: "customer.fname" },
          { data: "mname", name: "customer.mname", visible: false },
          { data: "lname", name: "customer.lname", visible: false },
          { data: "commname", name: "commodity.name" },
          { data: "sacks" },
          { data: "balance_id" },
          { data: "partial" },
          { data: "previous_bal" },
          { data: "balance" },
          { data: "kilo" },
          { data: "type" },
          { data: "tare" },
          { data: "moist" },
          { data: "net" },
          { data: "price" },
          { data: "total" },
          { data: "amtpay" },
          { data: "created_at" },
          { data: "status" },
          { data: "released_by" },
          { data: "remarks" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });

  $("#purchase_datepicker_to")
    .datepicker({
      showOn: "button",
      buttonImage: "assets/images/calendar2.png",
      buttonImageOnly: false,
      onSelect: function(date) {
        maxDateFilter = new Date(date).getTime();
        //oTable.fnDraw();
        var dt = new Date(date);
        purchase_date_to =
          dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
        $("#purchasetable")
          .dataTable()
          .fnDestroy();
        purchasestable = $("#purchasetable").DataTable({
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

            // Total over this page
            pageTotal4 = api
              .column(10, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(10).footer()).html(
              "Total: <br>" + number_format(pageTotal4, 2) + " kg"
            );

            // Total over this page
            pageTotal5 = api
              .column(16, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(16).footer()).html(
              "Total: <br>₱" + number_format(pageTotal5, 2)
            );

            // Total over this page
            pageTotal6 = api
              .column(17, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(17).footer()).html(
              "Total: <br>₱" + number_format(pageTotal6, 2)
            );

            // Total over this page
            pageTotal7 = api
              .column(14, { page: "current" })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(14).footer()).html(
              "Total: <br>" + number_format(pageTotal7, 2) + " kg"
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
                columns: [
                  0,
                  1,
                  4,
                  5,
                  6,
                  7,
                  8,
                  9,
                  10,
                  11,
                  12,
                  13,
                  14,
                  15,
                  16,
                  17,
                  18,
                  19,
                  20
                ],
                modifier: {
                  page: "current"
                }
              },
              customize: function(win) {
                var last = null;
                var current = null;
                var bod = [];

                var css = "@page { size: landscape; }",
                  head =
                    win.document.head ||
                    win.document.getElementsByTagName("head")[0],
                  style = win.document.createElement("style");

                style.type = "text/css";
                style.media = "print";

                if (style.styleSheet) {
                  style.styleSheet.cssText = css;
                } else {
                  style.appendChild(win.document.createTextNode(css));
                }

                head.appendChild(style);

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
              orientation: "landscape",
              pageSize: "LEGAL",
              exportOptions: {
                columns: [
                  0,
                  1,
                  4,
                  5,
                  6,
                  7,
                  8,
                  9,
                  10,
                  11,
                  12,
                  13,
                  14,
                  15,
                  16,
                  17,
                  18,
                  19,
                  20
                ],
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
          scrollX: true,
          fixedColumns: {
            leftColumns: 2,
            rightColumns: 1
          },
          processing: true,

          order: [],
          columnDefs: [
            {
              targets: "_all", // your case first column
              className: "text-center"
            }
          ],
          ajax: {
            url: "{{ route('refresh_purchases') }}",
            // dataType: 'text',
            type: "post",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
              date_from: purchase_date_from,
              date_to: purchase_date_to,
              commodity: commodityselected
            }
          },
          columns: [
            { data: "trans_no" },
            { data: "wholename", name: "customer.fname" },
            { data: "mname", name: "customer.mname", visible: false },
            { data: "lname", name: "customer.lname", visible: false },
            { data: "commname", name: "commodity.name" },
            { data: "sacks" },
            { data: "balance_id" },
            { data: "partial" },
            { data: "previous_bal" },
            { data: "balance" },
            { data: "kilo" },
            { data: "type" },
            { data: "tare" },
            { data: "moist" },
            { data: "net" },
            { data: "price" },
            { data: "total" },
            { data: "amtpay" },
            { data: "created_at" },
            { data: "status" },
            { data: "released_by" },
            { data: "remarks" },
            { data: "action", orderable: false, searchable: false }
          ]
        });
      }
    })
    .keyup(function() {
      $("#purchasetable")
        .dataTable()
        .fnDestroy();
      purchase_date_to = "";
      purchasestable = $("#purchasetable").DataTable({
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

          // Total over this page
          pageTotal4 = api
            .column(10, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(10).footer()).html(
            "Total: <br>" + number_format(pageTotal4, 2) + " kg"
          );

          // Total over this page
          pageTotal5 = api
            .column(16, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(16).footer()).html(
            "Total: <br>₱" + number_format(pageTotal5, 2)
          );

          // Total over this page
          pageTotal6 = api
            .column(17, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(17).footer()).html(
            "Total: <br>₱" + number_format(pageTotal6, 2)
          );

          // Total over this page
          pageTotal7 = api
            .column(14, { page: "current" })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(14).footer()).html(
            "Total: <br>" + number_format(pageTotal7, 2) + " kg"
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
              columns: [
                0,
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18
              ],
              modifier: {
                page: "current"
              }
            },
            customize: function(win) {
              var last = null;
              var current = null;
              var bod = [];

              var css = "@page { size: landscape; }",
                head =
                  win.document.head ||
                  win.document.getElementsByTagName("head")[0],
                style = win.document.createElement("style");

              style.type = "text/css";
              style.media = "print";

              if (style.styleSheet) {
                style.styleSheet.cssText = css;
              } else {
                style.appendChild(win.document.createTextNode(css));
              }

              head.appendChild(style);

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
            orientation: "landscape",
            pageSize: "LEGAL",
            exportOptions: {
              columns: [
                0,
                1,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18,
                19,
                20
              ],
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
        scrollX: true,
        fixedColumns: {
          leftColumns: 2,
          rightColumns: 1
        },
        order: [],
        columnDefs: [
          {
            targets: "_all", // your case first column
            className: "text-center"
          }
        ],
        ajax: {
          url: "{{ route('refresh_purchases') }}",
          // dataType: 'text',
          type: "post",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
            date_from: purchase_date_from,
            date_to: purchase_date_to,
            commodity: commodityselected
          }
        },
        columns: [
          { data: "trans_no" },
          { data: "wholename", name: "customer.fname" },
          { data: "mname", name: "customer.mname", visible: false },
          { data: "lname", name: "customer.lname", visible: false },
          { data: "commname", name: "commodity.name" },
          { data: "sacks" },
          { data: "balance_id" },
          { data: "partial" },
          { data: "previous_bal" },
          { data: "balance" },
          { data: "kilo" },
          { data: "type" },
          { data: "tare" },
          { data: "moist" },
          { data: "net" },
          { data: "price" },
          { data: "total" },
          { data: "amtpay" },
          { data: "created_at" },
          { data: "status" },
          { data: "released_by" },
          { data: "remarks" },
          { data: "action", orderable: false, searchable: false }
        ]
      });
    });
  //End of Date Range Filter

  function refresh_purchase_table() {
    purchasestable.ajax.reload(); //reload datatable ajax
  }
  mainMouseDownOne();

  function mainMouseDownOne() {
    $("#add_purchase").one("click", function(event) {
      $(".modal_title").text("Add Purchase");
      $("#button_action").val("add");

      event.preventDefault();
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      if (parseFloat($("#amount").val()) >= 0) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: "{{ route('add_purchases') }}",
          method: "POST",
          dataType: "text",
          data: $("#purchase_form").serialize(),
          success: function(data) {
            if (data != "Not") {
              button.disabled = false;
              input.html("SAVE CHANGES");
              $("#customer")
                .val("")
                .trigger("change");
              $("#commodity")
                .val("")
                .trigger("change");
              swal("Success!", "Record has been added to database", "success");
              $("#purchase_modal").modal("hide");
              refresh_purchase_table();
              $("#sacks").val("");
              $("#kilo").val("");
              $("#price").val("");
              $("#sacks1").val("");
              $("#kilo1").val("");
              $("#price1").val("");
              $("#fname").val("");
              $("#tare").val("");
              $("#moist").val("");
              $("#net").val("");
              $("#mname").val("");
              $("#lname").val("");
              $("#amount1").val("");
              $("#total").val("");
              $("#amount").val("");
              $("#ca").val("");
              $("#balance").val("");
              $("#partial").val("");
              $("#commodity")
                .val("")
                .trigger("change");
              $("#commodity1")
                .val("")
                .trigger("change");
              $("#customer")
                .val("")
                .trigger("change");
              $("#curCashOnHand").html(data);
              //refresh_delivery_table();
              mainMouseDownOne();
            } else {
              mainMouseDownOne();
              button.disabled = false;
              input.html("SAVE CHANGES");
              swal(
                "Oh no!",
                "You are not authorized to edit this. try again.",
                "error"
              );
            }
          },
          error: function(data) {
            mainMouseDownOne();
            button.disabled = false;
            input.html("SAVE CHANGES");
            swal("Oh no!", "Something went wrong, try again.", "error");
          }
        });
      } else {
        mainMouseDownOne();
        button.disabled = false;
        input.html("SAVE CHANGES");
        swal("Oh no!", "Amount to Pay shouldn't be negative.", "warning");
      }
    });
  }
  $(document).on("click", ".release_purchase", function(event) {
    event.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      url: "{{ route('check_balance3') }}",
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
          $("#release_purchase_modal").modal("show");
        }
      }
    });
  });

  $(document).on("click", "#release_purchase_normal", function() {
    var input = $(this);
    var button = this;
    button.disabled = true;
    input.html("Releasing...");
    $.ajax({
      url: "{{ route('release_purchase') }}",
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: { id: id },
      dataType: "json",
      success: function(data) {
        button.disabled = false;
        input.html("CONTINUE");
        if (data == false) {
          swal("Cash Already Released!", "error");
        }
        swal(
          "Cash Released!",
          "Remaining Balance: ₱" +
            data.cashOnHand.toFixed(2) +
            " | Transaction ID: " +
            data.cashHistory,
          "success"
        );
        $("#release_purchase_modal").modal("hide");
        $("#curCashOnHand").html(data.cashOnHand.toFixed(2));

        refresh_purchase_table();
      }
    });
  });

  $("#print_purchase").on("click", function(event) {
    event.preventDefault();
    if ($("#stat1").val() == "old") {
      $("#add_purchase").trigger("click");
    } else if ($("#stat").val() == "new") {
      $("#add_purchase1").trigger("click");
    }
    $("#print_form").trigger("click");
  });

  $("#print_form1").click(function(event) {
    event.preventDefault();
    $("#print_form").trigger("click");
  });

  $("#print_form").click(function(event) {
    if ($("#stat1").val() == "old") {
      $("#ticket_clone").val($("#ticket").val());
      if ($("#customerName").val()) {
        $("#customer_clone").val($("#customerName").val());
      } else {
        $("#customer_clone").val($("#customer option:selected").text());
      }
      $("#commodity_clone").val($("#commodity option:selected").text());
      $("#sacks_clone").val($("#sacks").val());
      $("#ca_clone").val($("#cash").val());
      $("#balance_clone").val($("#balance").val());
      $("#partial_clone").val($("#partial").val());
      $("#kilos_clone").val($("#kilo").val());
      $("#price_clone").val($("#price").val());
      $("#total_clone").val($("#total").val());
      $("#amount_clone").val($("#amount").val());
      $("#remarks_clone").val($("#remarks").val());
      $("#type_clone").val($("#type1").val());
      $("#moist_clone").val($("#moist").val());
      $("#tare_clone").val($("#tare").val());
      $("#net_clone").val($("#net").val());
      $("#previous_balance_clone").val($("#ca").val());
    } else if ($("#stat").val() == "new") {
      $("#ticket_clone").val($("#ticket1").val());
      $("#customer_clone").val(
        $("#fname").val() + " " + $("#mname").val() + " " + $("#lname").val()
      );
      $("#commodity_clone").val($("#commodity1 option:selected").text());
      $("#sacks_clone").val($("#sacks1").val());
      $("#ca_clone").val($("#bal").val());
      $("#balance_clone").val($("#bal").val() - $("#partialpayment").val());
      $("#partial_clone").val($("#partialpayment").val());
      $("#kilos_clone").val($("#kilo1").val());
      $("#price_clone").val($("#price1").val());
      $("#total_clone").val($("#amount1").val());
      $("#amount_clone").val($("#amountpay1").val());
      $("#remarks_clone").val($("#remarks1").val());
      $("#type_clone").val($("#type2").val());
      $("#moist_clone").val($("#moist2").val());
      $("#tare_clone").val($("#tare2").val());
      $("#net_clone").val($("#net2").val());
      $("#previous_balance_clone").val(null);
    }
  });

  mainMouseDownOne2();

  function mainMouseDownOne2() {
    $("#add_purchase1").one("click", function(event) {
      var input = $(this);
      var button = this;
      button.disabled = true;
      input.html("SAVING...");
      event.preventDefault();
      if (parseFloat($("#balanceWALKIN").val()) < 0) {
        mainMouseDownOne2();
        button.disabled = false;
        input.html("SAVE CHANGES");
        swal("Oh no!", "There's a negative number in the form", "error");
      } else {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: "{{ route('add_purchases') }}",
          method: "POST",
          dataType: "text",
          data: $("#purchase_form1").serialize(),
          success: function(data) {
            button.disabled = false;
            input.html("SAVE CHANGES");
            $("#sacks1").val("");
            $("#kilo1").val("");
            $("#price1").val("");
            $("#fname").val("");
            $("#tare2").val("");
            $("#cash").val("");
            $("#moist2").val("");
            $("#net2").val("");
            $("#mname").val("");
            $("#lname").val("");
            $("#amount1").val("");
            $("#commodity1")
              .val("")
              .trigger("change");
            swal("Success!", "Record has been added to database", "success");
            $("#purchase_modal").modal("hide");
            refresh_purchase_table();
            //refresh_delivery_table();
            mainMouseDownOne2();
          },
          error: function(xhr, textStatus, error) {
            mainMouseDownOne2();
            button.disabled = false;
            input.html("SAVE CHANGES");
            swal("Oh no!", xhr.responseText, "error");
          }
        });
      }
    });
  }
});

function sacks1(value) {
  if (value.which != 9) {
    var a = 0;
    var b = parseFloat($("#price").val());
    var d = 0;
    var c = 0;
    var e = 0;
    var r = 0;
    var x = 0;
    var t = 0;
    var z = 0;
    if ($("#price").val() != "") {
      a = 0;
      d = a * 50;
      if ($("#sacks").val() == "") {
        $("#total").val("");
        if ($("#partial").val() != "" || $("#total").val() != "") {
          if ($("#partial").val() != "") {
            r = parseFloat($("#partial").val());
          }
          if ($("#total").val() != "") {
            t = parseFloat($("#total").val());
          }
          var temp2 = t + r;
          var temp3 = parseFloat(temp2).toFixed(2);
          $("#amount").val(temp3);
        } else {
          $("#amount").val("");
        }
      } else {
        c = d * b;
        var temp = c + r;
        var temporary = parseFloat(c).toFixed(2);
        $("#total").val(temporary);
        var temp3 = parseFloat(temp).toFixed(2);
        $("#amount").val(temp3);
        if ($("#partial").val() != "") {
          r = parseFloat($("#partial").val());
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount").val(temp3);
        }
        if ($("#total").val() != "") {
          t = parseFloat($("#total").val());
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount").val(temp3);
        }

        if ($("#kilo").val() == "") {
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount").val(temp3);
        }
      }
      if ($("#kilo").val() != "") {
        e = parseFloat($("#kilo").val());
        x = b * e;
        z = x + c;
        var temp1 = z + r;
        var temporary = parseFloat(z).toFixed(2);
        $("#total").val(temporary);
        var temp3 = parseFloat(temp1).toFixed(2);
        $("#amount").val(temp3);
      }
    }
  }
}

function sacks2(value) {
  if (value.which != 9) {
    var a = 0;
    var b = parseFloat($("#price1").val());
    var d = 0;
    var c = 0;
    var e = 0;
    var r = 0;
    var x = 0;
    var t = 0;
    var z = 0;
    if ($("#price1").val() != "") {
      a = 0;
      d = a * 50;
      if ($("#sacks1").val() == "") {
        $("#total1").val("");
        if ($("#partial1").val() != "" || $("#total1").val() != "") {
          if ($("#partial1").val() != "") {
            r = parseFloat($("#partial1").val());
          }
          if ($("#total1").val() != "") {
            t = parseFloat($("#total1").val());
          }
          var temp2 = t + r;
          var temp3 = parseFloat(temp2).toFixed(2);
          $("#amount1").val(temp3);
        } else {
          $("#amount1").val("");
        }
      } else {
        c = d * b;
        var temp = c + r;
        $("#total1").val(c);
        $("#amount1").val(temp);
        if ($("#partial1").val() != "") {
          r = parseFloat($("#partial1").val());
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount1").val(temp3);
        }
        if ($("#total1").val() != "") {
          t = parseFloat($("#total1").val());
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount1").val(temp3);
        }

        if ($("#kilo1").val() == "") {
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount1").val(temp3);
        }
      }
      if ($("#kilo1").val() != "") {
        e = parseFloat($("#kilo1").val());
        x = b * e;
        z = x + c;
        var temp1 = z + r;
        var tempo = parseFloat(z).toFixed(2);
        $("#total1").val(tempo);
        var temp3 = parseFloat(temp1).toFixed(2);
        $("#amount1").val(temp3);
      }
    }
  }
}

function kilos2(value) {
  if (value.which != 9) {
    var a = 0;
    var b = parseFloat($("#price1").val());
    var c = 0;
    var d = 0;
    var i = 0;
    var e = 0;
    var x = 0;
    var z = 0;
    var r = 0;
    var t = 0;
    if ($("#price1").val() != "") {
      a = parseFloat($("#kilo1").val());
      if ($("#kilo1").val() == "") {
        $("#total1").val("");
        if ($("#partial1").val() != "" || $("#total1").val() != "") {
          if ($("#partial1").val() != "") {
            r = parseFloat($("#partial1").val());
          }
          if ($("#total1").val() != "") {
            t = parseFloat($("#total1").val());
          }
          var temp2 = t + r;
          var temp3 = parseFloat(temp2).toFixed(2);
          $("#amount1").val(temp3);
          $("#amountpay1").val(temp3);
        } else {
          $("#amount1").val("");
        }
      } else {
        c = a * b;
        var temp = c + r;
        var tempo = parseFloat(c).toFixed(2);
        $("#total1").val(tempo);
        var temp3 = parseFloat(temp).toFixed(2);
        $("#amount1").val(temp3);
        $("#amountpay1").val(temp3);
        if ($("#partial1").val() != "") {
          r = parseFloat($("#partial1").val());
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount1").val(temp3);
          $("#amountpay1").val(temp3);
        }
        if ($("#total1").val() != "") {
          t = parseFloat($("#total1").val());
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount1").val(temp3);
          $("#amountpay1").val(temp3);
        }
        if ($("#sacks1").val() == "") {
          temp = c + r;
          var temp3 = parseFloat(temp).toFixed(2);
          $("#amount1").val(temp3);
          $("#amountpay1").val(temp3);
        }
      }
      if ($("#sacks1").val() != "") {
        e = 0;
        x = b * (e * 50);
        z = x + c;
        i = x + c + r;
        var tempo = parseFloat(z).toFixed(2);
        $("#total1").val(tempo);
        var temp3 = parseFloat(i).toFixed(2);
        $("#amount1").val(temp3);
        $("#amountpay1").val(temp3);
      }
    }

    tare3(this);
    moist3(this);
  }
}

function partial2(value) {
  if (
    value.which != 9 &&
    value.which != 8 &&
    isNaN(String.fromCharCode(value.which))
  ) {
    if ($("#balance1").val() != "") {
      var a = 0;
      var b = parseFloat($("#balance1").val());
      var d = 0;
      var c = 0;
      var e = 0;
      if ($("#partial").val() != "") {
        a = parseFloat($("#partial1").val());
        if ($("#total1").val() != "") {
          e = parseFloat($("#total1").val());
        }
        x = a + e;
        var temp3 = parseFloat(x).toFixed(2);
        $("#amount1").val(temp3);
      }

      c = d - a;
      $("#balance1").val(c);
      if ($("#total1").val() != "") {
        e = parseFloat($("#total1").val());
      }
      x = a + e;
      var temp3 = parseFloat(x).toFixed(2);
      $("#amount1").val(temp3);
    }
  }
}

$(document).on("click", "#link", function() {
  $("#bod").toggleClass("overlay-open");
});

$(document).ready(function() {
  $.extend($.fn.dataTable.defaults, {
    language: {
      processing: "Loading.. Please wait"
    }
  });

  $(document).on("click", ".open_purchase_modal", function() {
    $("#homeclick1").show();
    $(".modal_title").text("Add Purchase");
    $("#resetNiCash").hide();
    $("#resetNiPartial").hide();
    $("#button_action").val("add");
    $("#flagupdate1").show();
    $("#flagupdate").hide();
    $("#button_action1").val("add");
    $("#customerName").val("");
    $("#customer").select2("enable");
    $("#customer")
      .val("")
      .trigger("change");
    $("#commodity")
      .val("")
      .trigger("change");
    $("#cash").prop("disabled", false);
    $("#partial").prop("disabled", false);
    $("#purchase_modal").modal("hide");
    $("#cash").val("");
    $("#tare").val("");
    $("#moist").val("");
    $("#net").val("");
    $("#sacks").val("");
    $("#kilo").val("");
    $("#price").val("");
    $("#sacks1").val("");
    $("#kilo1").val("");
    $("#amountpay1").val("");
    $("#partialpayment").val("");
    $("#address").val("");
    $("#contacts").val("");
    $("#bal").val("");
    $("#price1").val("");
    $("#fname").val("");
    $("#mname").val("");
    $("#lname").val("");
    $("#amount1").val("");
    $("#total").val("");
    $("#amount").val("");
    $("#ca").val("");
    $("#balance").val("");

    $("#partial").val("");
    $("#commodity")
      .val("")
      .trigger("change");
    $("#commodity1")
      .val("")
      .trigger("change");
    $("#customer")
      .val("")
      .trigger("change");
    $.ajax({
      url: "{{ route('refresh_trans') }}",
      method: "get",
      data: { temp: "temp" },
      dataType: "json",
      success: function(data) {
        var t = 0;
        if (data[0].temp != null) {
          t = data[0].temp;
        }
        var a = parseFloat(t);
        var b = a + 1;
        $("#id1").val(b);
        var c = new Date();
        var twoDigitMonth =
          c.getMonth().length + 1 == 1
            ? c.getMonth() + 1
            : "0" + (c.getMonth() + 1);
        var currentDate = c.getFullYear() + twoDigitMonth + c.getDate();
        $("#ticket").val(currentDate + b);
        $("#ticket1").val(currentDate + b);
        $("#commodity")
          .val("")
          .trigger("change");
        $("#commodity1")
          .val("")
          .trigger("change");
        $("#customer")
          .val("")
          .trigger("change");
        $("#purchase_modal").modal("show");
      }
    });

    $.ajax({
      url: "{{ route('findCustomer') }}",
      method: "get",
      data: { temp: "temp" },
      dataType: "json",
      success: function(data) {
        var t = 0;
        if (data[0].temp != null) {
          t = data[0].temp;
        }
        var a = parseFloat(t);
        var b = a + 1;
        $("#customerid").val(b);
      }
    });
  });
  $("#commodityfilter").select2({
    placeholder: "Select Commodity"
  });

  $("#commodity").select2({
    dropdownParent: $("#purchase_modal"),
    placeholder: "Select an item"
  });

  $("#commodity1").select2({
    dropdownParent: $("#purchase_modal"),
    placeholder: "Select an item"
  });

  $("#customer").select2({
    dropdownParent: $("#purchase_modal"),
    placeholder: "Select a customer",
    ajax: {
      url: "{{ route('customerAll') }}",
      dataType: "json",

      data: function(params) {
        return {
          name: params.term, // search term
          page: params.page
        };
      },
      processResults: function(data) {
        return {
          results: data.results
        };
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

  $("#remarks").select2({
    dropdownParent: $("#purchase_modal"),
    placeholder: "Remarks"
  });

  $("#remarks1").select2({
    dropdownParent: $("#purchase_modal"),
    placeholder: "Remarks"
  });
  $("#type1").select2({
    dropdownParent: $("#purchase_modal"),
    placeholder: "Select a type"
  });

  $("#type2").select2({
    dropdownParent: $("#purchase_modal"),
    placeholder: "Select a type"
  });

  $("#customer").on("select2:select", function(e) {
    var id = $(e.currentTarget).val();
    $.ajax({
      url: "{{ route('find_amt') }}",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#moist").val(0);
        $("#ca").val(data.balance);
        $("#balance").val(data.balance);
        $("#balance1").val(data.balance);
        $("#last").val(data.suki_type);
        computeAll();
      }
    });
  });

  $("#commodity").on("select2:select", function(e) {
    if ($("#button_action1").val() == "update") {
      $("#commodityID").val($(e.currentTarget).val());
    }
    var id = $(e.currentTarget).val();
    $.ajax({
      url: "{{ route('find_comm') }}",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#moist").val("0");
        $("#pr").val(data.price);
        $("#suki").val(data.suki_price);
        var a = parseFloat($("#last").val());
        if (a == 1) {
          $("#price").val(data.suki_price);
        } else {
          $("#price").val(data.price);
        }
        computeAll();
      }
    });
  });
  $("#type1").on("select2:select", function(e) {
    var id = $(e.currentTarget).val();
    if (id == "Dry") {
      $("#moist").prop("readonly", true);
      $("#moist").val("0");
      computeAll();
    } else {
      $("#tare").prop("readonly", false);
      $("#moist").prop("readonly", false);
    }
  });

  $("#type2").on("select2:select", function(e) {
    var id = $(e.currentTarget).val();
    if (id == "Dry") {
      $("#moist2").prop("readonly", true);
      $("#moist2").val("0");
    } else {
      $("#tare2").prop("readonly", false);
      $("#moist2").prop("readonly", false);
    }
  });
  $("#commodity1").on("select2:select", function(e) {
    var id = $(e.currentTarget).val();
    $.ajax({
      url: "{{ route('find_comm') }}",
      data: { id: id },
      dataType: "json",
      success: function(data) {
        $("#pr1").val(data.price);
        $("#suki1").val(data.suki_price);

        var a = parseFloat($("#last1").val());
        if (a == 1) {
          $("#price1").val(data.suki_price);
          var d = 0;
          var e = 0;
          var b = parseFloat($("#suki").val());
          var c = parseFloat($("#pr").val());
          var t = 0;
          if ($("#sacks1").val() != "" || $("#kilo1").val() != "") {
            var x = 0;

            if ($("#kilo1").val() != "") {
              var x = parseFloat($("#kilo").val());
            }
            if ($("#sacks1").val() == "") {
              d = 0;
            } else {
              d = parseFloat($("#sacks1").val());
            }

            if ($("#partial1").val() != "") {
              t = parseFloat($("#partial1").val());
            }
            e = b * d;
            var y = e + b * x;
            var z = e + b * x + t;
            //alert(e);
            var tempo = parseFloat(y).toFixed(2);
            $("#total1").val(tempo);
            var temp3 = parseFloat(z).toFixed(2);
            $("#amount1").val(temp3);
            $("#amountpay1").val(temp3);
          }
        } else {
          $("#price1").val(data.price);
          var d = 0;
          var e = 0;
          var b = parseFloat($("#suki1").val());
          var c = parseFloat($("#pr1").val());
          var t = 0;
          if ($("#sacks1").val() != "" || $("#kilo1").val() != "") {
            var x = 0;

            if ($("#kilo1").val() != "") {
              var x = parseFloat($("#kilo1").val());
            }
            if ($("#sacks1").val() == "") {
              d = 0;
            } else {
              d = parseFloat($("#sacks1").val());
            }

            if ($("#partial1").val() != "") {
              t = parseFloat($("#partial1").val());
            }
            e = c * d;
            var y = e + c * x;
            var z = e + c * x + t;
            //alert(e);
            var tempo = parseFloat(y).toFixed(2);
            $("#total1").val(tempo);
            var temp3 = parseFloat(z).toFixed(2);
            $("#amount1").val(temp3);
            $("#amountpay1").val(temp3);
          }
        }
      }
    });
    moist3(this);
    tare3(this);
  });
});
</script>
@endsection
