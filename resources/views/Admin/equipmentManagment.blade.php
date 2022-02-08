@extends('layouts.admin')
@section('content')

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
                            <h4 class="card-title">Equipment Managment</h4>
                            <a href="{{url('admin/add_equipment')}}" class="btn btn-primary float-right">
                              Add
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <p class="card-text">Equipment List</p>
                                <div class="table-responsive">
                                    <table class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Device Type</th>
                                                <th>Employee Assign To</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @php
                                                    $i=1;
                                                @endphp
                                         @foreach($eq as $equipment)
                                         <tr>
                                          <td>{{$i++}}</td>
                                          <td>{{$equipment->type}}</td>
                                          <td>{{$equipment->employee}}</td>
                                          <td>
                                              <a href="{{url('admin/edit_equipment')}}/{{$equipment->id}}" class="text-primary mr-2"><i class="feather icon-edit" title="Edit"></i></a>
                                              <a href="{{url('admin/delete_equipment')}}/{{$equipment->id}}" class="text-danger"><i class="feather icon-trash " title="Delete"></i></a>
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
