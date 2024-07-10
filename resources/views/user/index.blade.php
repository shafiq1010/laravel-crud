@extends('layout.master')
@section('title','Index Page')
@section('content')

<div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Hi @if(Auth::check()){{auth()->user()->name}}@else {{'Guest'}} @endif</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('user.create') }}"> Create User</a>
                    @if(!Auth::check())
                    <a class="btn btn-success" href="{{ route('user.show','login') }}">Login</a>
                    @else
                    <a class="btn btn-success" href="user/logout">Logout</a>
                    @endif
                    

                    
                    <button class="btn btn-primary delete_all" data-url="{{ url('user/deleteAll') }}">Delete All Selected</button> 
                   
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="master"></th>
                    <th>S.No</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Address</th>
                    <th>User Image</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr>
                        <td><input type="checkbox" class="sub_chk" data-id="{{$item->id}}"></td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->address }}</td>
                        <td><img width="100" height="90" src="{{ asset('uploads/user/'.$item->image) }}" alt="user image"></td>
                        <td>
                            <form action="{{ route('user.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('user.edit',$item->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" Onclick="return ConfirmDelete();" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    {!! $users->links() !!}
    </div>

    <script>
        
        function ConfirmDelete()
        {
          return confirm("Are you sure you want to delete?");
        }
        
        $(document).ready(function(){
            
           $('#master').on('click', function(e){
               if($(this).is(':checked',true)){
                  $('.sub_chk').prop('checked',true);
                }else{
                  $('.sub_chk').prop('checked',false);
                }  
           }) ;
            $('.delete_all').on('click', function(e) { 
            console.log('hi');
                var allVals=[];
                $('.sub_chk:checked').each(function(){
                    var vals = allVals.push($(this).attr('data-id'));
                    console.log(vals);
                });
                if(allVals.length <= 0){
                   alert('Plese select row');
                }else{
                   var check = confirm('Are you sure want to delete all users.');
                    if(check==true){
                        
                       var join_selected_values = allVals.join(',');
                        
                        $.ajax({
                            url: $(this).data('url'),  
                            type: 'DELETE',  
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                            data: 'ids='+join_selected_values,  
                            success: function (data) {  
                                if (data['success']) {  
                                    $(".sub_chk:checked").each(function() {    
                                        $(this).parents("tr").remove();  
                                    });  
                                    alert(data['success']);  
                                } else if (data['error']) {  
                                    alert(data['error']);  
                                } else {  
                                    alert('Whoops Something went wrong!!');  
                                }  
                            },  
                            error: function (data) {  
                                alert(data.responseText);  
                            }  
                        });
                    }
                }
            });    
            
        });
    </script>

@endsection