@extends('layouts.admin')
@section('content')
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>  --}}
{{--  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>  --}}
<!-- Year Picker CSS -->
{{--  <link rel="stylesheet" href="{{asset('css/yearpicker.css')}}" />  --}}




        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                  @if ($message = Session::get('success'))
                  <div class="alert alert-success ">    
                      <strong>{{ $message }}</strong>
                  </div>
                  @endif
                  @if ($message = Session::get('error'))
                  <div class="alert alert-danger ">    
                      <strong>{{ $message }}</strong>
                  </div>
                  @endif 
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Holidays</h4>
                            <a href="{{url('admin/add_holiday')}}" class="btn btn-primary float-right">
                              Add Holidays
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <p class="card-text">Holidays List</p>
                                <div class="table-responsive">
                                    <table class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Holiday Title</th>
                                                <th>Holiday Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($holiday_date as $holiday)
                                         <tr>
                                          <td>{{$holiday->holiday_title}}</td>
                                          <td>{{$holiday->holiday_date}}</td>
                                          <td>
                                              <a href="{{url('admin/update_holiday')}}/{{$holiday->id}}" class="text-primary mr-2"><i class="feather icon-edit" title="Edit"></i></a>
                                              <a href="{{url('admin/delete_holiday')}}/{{$holiday->id}}" class="text-danger"><i class="feather icon-trash " title="Delete"></i></a>
                                          </td>
                                      </tr>
                                         @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </section>

    @endsection
