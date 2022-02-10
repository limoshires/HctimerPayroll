@extends('layouts.admin')
@section('content')


    
    <section id="basic-datatable">
    
  <div class="row">
      
      <div class="col-12">
        
        
        <div class="card">
                  
              <div class="card-header">
                <h4 class="card-title">Show All Vacation Leaves List</h4>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModalCenter">
                    Add Maternity Leave
                  </button>
               

                 
              </div>
              
              <div class="card-content">
                  
                  <div class="card-body card-dashboard">
                      <p class="card-text">Vacation Leaves List</p>
                      
                      <div class="table-responsive">
                          <table class="table zero-configuration">
                              <thead>
                                  <tr>
                                    <th>#id</th>
                                    <th>Employee Name</th>
                                    <th>Title</th>
                                    <th>Leave Start Date</th>
                                    <th>No of Weaks</th>
                                    <th>Desc</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @php
                                    $i=1;
                                  
                                @endphp
                                 @foreach($maternity as $mat)
                                 <tr>
                                    <td>{{$i}}</td>
                                    @php $i+=1 @endphp
                                    <td>{{$mat->name}}</td>
                                    <td>{{$mat->title}}</td>
                                    <td>{{$mat->start_date}}</td>
                                    <td>{{$mat->no_weak}}</td>
                                    <td>{{$mat->desc}}</td>
                                    <td>
                                        @if($mat->status == 1)
                                        <span class="text-success">Approved</span>
                                        @else
                                        <span class="text-danger">Pending</span>
  
                                        @endif
                                    </td>
                                    <td>
                                        <div class="row"> 
                                        @if($mat->status != 0)
                                         
                                        
                                          @else
                                          <div class="col-6">
                                           <a class="btn btn-success btn-sm text-white"
                                             href="{{url('admin/approve_maternity', $mat->id)}}">Approve</a>   
                                         </div> 
                                         <div class="col-6">                 
                                          <a class="btn btn-danger btn-sm text-white"
                                          href="{{url('admin/delete_maternity', $mat->id)}}">Delete</a> 
                                      </div>
                                         @endif 
                                         
                                       

                                        </div>
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
</div>
<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add vacation Leave</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-material mx-2" method="POST"
          action="{{ url('admin/insert_maternity_leave') }}" >
          @csrf
              <div class="form-group">
                <label for="first-name-icon">Employee Name</label>
                <div class="position-relative has-icon-left">
                  <select name="user_name" class="form-control ">
                    <option value="">Select Employee</option>
                    @foreach($all_emp as $list)
                    <option value="{{$list->first_name." ".$list->last_name}}">{{$list->first_name}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-position">
                    <i class="feather icon-user"></i>
                </div>
                </div>
                <div class="form-group">
                  <label for="first-name-icon">Title</label>
                  <div class="position-relative has-icon-left">
                      <input type="text" id="first-name-icon" class="form-control" name="title"
                          placeholder="Title" value="" required="">
                      <div class="form-control-position">
                          <i class="feather icon-user"></i>
                      </div>
                  </div>
              </div>
                <div class="form-group">
                  <label for="first-name-icon">Leave Date Start</label>
                  <div class="position-relative has-icon-left">
                      <input type="date" id="first-name-icon" class="form-control" name="leave_date"
                          placeholder="Leave Date" value="" required="">
                      <div class="form-control-position">
                          <i class="feather icon-user"></i>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                <label for="first-name-icon">No of Weaks</label>
                <div class="position-relative has-icon-left">
                    <input type="number" id="first-name-icon" class="form-control" name="no_weak"
                        placeholder="No of Weak" value="" required="" min="1" max="12" >
                    <div class="form-control-position">
                        <i class="feather icon-user"></i>
                    </div>
                </div>
            </div>
              <div class="form-group">
                <label for="first-name-icon">Description</label>
                <div class="position-relative has-icon-left">
        
                        <textarea cols="4" rows="4" name="description" class="form-control"></textarea>
                    <div class="form-control-position">
                        <i class="feather icon-user"></i>
                    </div>
                </div>
            </div>
              
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit"  class="btn btn-primary">Add Vacation Leave</button>
        </div>
    </form>

      </div>
    </div>
  </div>
@endsection
