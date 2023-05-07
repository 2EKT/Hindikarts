@include("admin.include.header");
@include("admin.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Monthly Fees List </h5>
                        
                        </div>
                        @if(session()->has('success'))
                            <div class="alert alert-secondary alert-dismissible alert-solid alert-label-icon fade show" role="alert">
                                <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{ session()->get('success') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    
                        @if(session()->has('error'))
                            <div class="alert alert-warning alert-dismissible alert-solid alert-label-icon fade show" role="alert">
                                <i class="ri-alert-line label-icon"></i><strong>Error</strong> - {{ session()->get('error') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>     
                        @endif
                        <div class="card-body">
                            <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Zonepartner Reg Fee</th>
                                        <th>Zonepartner Monthly Fee</th>
                                        <th>Districtpartner Reg fee</th>
                                        <th>Districtpartner Monthly fee</th>
                                        <th>Blockpartner Reg Fee</th>
                                        <th>Blockpartner Monthly Fee</th>
                                        <th>Employee Reg Fee</th>
                                        <th>Employee Monthly Fee</th>
                                        <th>Deliveryboy Reg Fee</th>
                                        <th>Deliveryboy Monthly Fee</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $row=DB::table('monthlyfees')->get();
                                    @endphp
                                    @foreach ($row as $details)
                                        
                                        <tr>
                                            <td>{{$loop->iteration }}</td>
                                            <td>{{$details->zone_reg}}</td>
                                            <td>{{$details->zone_monthly}}</td>
                                            <td>{{$details->district_reg}}</td>
                                            <td>{{$details->district_monthly}}</td>
                                            <td>{{$details->block_reg}}</td>
                                            <td>{{$details->block_monthly}}</td>
                                            <td>{{$details->employee_reg}}</td>
                                            <td>{{$details->employee_monthly}}</td>
                                            <td>{{$details->delivery_boy_reg}}</td>
                                            <td>{{$details->delivery_boy_monthly}}</td>
                                            <td><a href="{{url('/admin/monthlyfee/'.$details->id.'/edit')}}"><i data-feather="edit"></i></a></td>
                                            
                                        </tr>
                                        
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->
@include("admin.include.footer");

