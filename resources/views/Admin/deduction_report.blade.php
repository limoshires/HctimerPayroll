@extends('layouts.admin')
@section('content')
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>  --}}
{{--  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>  --}}
<!-- Year Picker CSS -->
{{--  <link rel="stylesheet" href="{{asset('css/yearpicker.css')}}" />  --}}
<div class="card">

    @php
        use App\Models\Department;

        $dept = Department::get();

    @endphp
    <div class="card-content ml-4 mr-4 mt-4 mb-2">
        <form class="form-horizontal form-material" method="post" action="{{ url('admin/deduction_response') }}"  >
            @csrf
            <div class="form-group">
                <label for="department">Department</label>
                <div class="position-relative has-icon-left">
                  <select name="dep" class="form-control ">
                    <option value="">Select Department</option>
                    @foreach($dept as $list)
                    <option value="{{$list->department}}">{{$list->department}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-position">
                    <i class="feather icon-user"></i>
                  </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
      <h4 class="card-title">Bonus Report</h4>
      </div>


    <div class="card-content">
      @if($message = Session::get('error'))
        <div class="alert alert-danger ">
          <strong>{{ $message }}</strong>
        </div>
      @endif
        <div class="card-body card-dashboard">
            <p class="card-text">List of Report</p>
            <div class="table-responsive">
                <table class="table zero-configuration">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Year</th>
                            <th>Start Period</th>
                            <th>End Period</th>
                            <th>Total Pay</th>
                            <th>NIS</th>
                            <th>NHT</th>
                            <th>ED Tax</th>
                            <th>Income Tax</th>
                            <th>Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($deduction!=null)
                    @foreach ($deduction as $payroll)
                    <tr>
                        <td>{{$payroll->emp_name}}</td>
                        <td>{{$payroll->year}}</td>
                        <td>{{$payroll->start_date}}</td>
                        <td>{{$payroll->end_date}}</td>
                        <td>{{$payroll->total_pay}}</td>
                        <td>{{$payroll->nis}}</td>
                        <td>{{$payroll->nht}}</td>
                        <td>{{$payroll->edtax}}</td>
                        <td>{{$payroll->income}}</td>
                        <td>{{$payroll->bonus}}</td>
                    </tr>
                    @endforeach
                    @endif









  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="get" action="{{url('admin/add_start_date')}}">
            <div class="modal-body">
                <div class="form-group">
                    <div class="position-relative has-icon-left">
                        <input type="date" class="form-control"  name="start_d" placeholder="Start Date" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>

    @endsection
