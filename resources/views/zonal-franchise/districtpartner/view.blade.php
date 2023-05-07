@include("zonal-franchise.include.header");
@include("zonal-franchise.include.sidebar");
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">District Partner </h5>
                        
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
                                        <th>Image</th>
                                        <th>District</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Login Permission</th>
                                        {{-- <th>Edit</th>
                                        <th>Delete</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $row=DB::table('districtpartners')->where('zone_partner_id',Auth::guard('zonepartner')->user()->id)->get();
                                    @endphp
                                    @foreach ($row as $details)
                                        @php
                                        $district_row=DB::table('district')->where('id','=',$details->district_id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration }}</td>
                                            <td><img src="{{ asset('user_image/'.$details->image) }}" alt="" style="height: 60px;width: 70px;"></td>
                                            <td>{{$district_row->district}}</td>
                                            <td>{{$details->name}}</td>
                                            <td>{{$details->email}}</td>
                                            <td>{{$details->phone}}</td>
                                            <td>{{$details->active_status}}</td>
                                            {{-- <td><a href="{{url('/zonal-franchise/districtpartner/edit/'.$details->id)}}"><i data-feather="edit"></i></a></td>
                                            <td><i data-feather="archive" onclick="delete_row({{$details->id}})"></i></td>
                                            <form action="{{url('/zonal-franchise/districtpartner/delete')}}" method="post" id="delete_submit{{$details->id}}" style="display:none;">
                                                <input type="hidden" name="id" value="{{ $details->id }}">
                                                <input type="hidden" name="image" value="{{ $details->image }}">        
                                                {{csrf_field()}}
                                            </form> --}}
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
@include("zonal-franchise.include.footer");

<script>
    function delete_row(id)
    {
       //  alert(id);exit();
        swal({
                 title: "Are you sure?",
                 text: "Once deleted, you will not be able to recover this imaginary file!",
                 icon: "warning",
                 buttons: true,
                 dangerMode: true,
               })
               .then((willDelete) => {
                 if (willDelete) 
                 {
                   document.getElementById("delete_submit"+id).submit();
                 } else 
                 {
                   // swal("Your imaginary file is safe!");
                 }
               });
    } 
   
   </script>