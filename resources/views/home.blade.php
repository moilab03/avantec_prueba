@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">                
                    <nav class="navbar navbar-expand-lg navbar-light bg-light" >
                        
                        <div id="navbarNav">
                          <ul class="navbar-nav">
                            <li class="nav-item active">
                              <a class="nav-link" href="#">Persona</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#">Citas</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#">Agenda</a>
                            </li>
                          </ul>
                        </div>
                      </nav>    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="pull-left">
                      
                      </div>
                      <div class="pull-right mb-2">
                      <a class="btn btn-success" id="add-new-person"> Crear Persona</a>
                      </div>
                      </div>

                    <table class="table" id="people_table" >
                        <thead>
                          <tr>
                            <th></th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Telefono</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        
                      </table>
                
            </div>
        </div>
    </div>
</div>
@include('addnewperson')
@include('updateperson')

<script>

toastr.options.preventDuplicates = true;

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});


$(function(){

       //ADD NEW PERSON
       $('#add-new-person-form').on('submit', function(e){
           e.preventDefault();
           var form = this;
           $.ajax({
               url:$(form).attr('action'),
               method:$(form).attr('method'),
               data:new FormData(form),
               processData:false,
               dataType:'json',
               contentType:false,
               beforeSend:function(){
                    $(form).find('span.error-text').text('');
               },
               success:function(data){
                    if(data.code == 0){
                          $.each(data.error, function(prefix, val){
                              $(form).find('span.'+prefix+'_error').text(val[0]);
                          });
                    }else{
                        $(form)[0].reset();
                        $('.addnewperson').modal('hide');
                        $('.addnewperson').find('form')[0].reset();
                                  toastr.success(data.msg);                      
                       $('#people_table').DataTable().ajax.reload(null, false);
                       toastr.success(data.msg);
                    }
               }
           });
       });

       $(document).on('click','#add-new-person', function(){

                    $('.addnewperson').modal('show');
                    
        });

                var table =  $('#people_table').DataTable({
                     processing:true,
                     info:true,
                     ajax:"{{ route('get.people') }}",
                     "pageLength":5,
                     "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                     columns:[                        
                         {data:'name', name:'name'},
                         {data:'last_name', name:'last_name'},
                         {data:'dni', name:'dni'},
                         {data:'phone', name:'phone'},
                         {data:'actions', name:'actions', orderable:false, searchable:false},
                     ]
                }); 
                 
                 $(document).on('click','#updatePersonBtn', function(){
                    var person_id = $(this).data('id');
                    $('.updateperson').find('form')[0].reset();
                    $('.updateperson').find('span.error-text').text('');
                    $.post('<?= route("get.person.detail") ?>',{person_id:person_id}, function(data){                        
                        $('.updateperson').find('input[name="person_id"]').val(data.details.id);
                        $('.updateperson').find('input[name="name"]').val(data.details.name);
                        $('.updateperson').find('input[name="last_name"]').val(data.details.last_name);
                        $('.updateperson').find('input[name="dni"]').val(data.details.dni);
                        $('.updateperson').find('input[name="phone"]').val(data.details.phone);
                        $('.updateperson').modal('show');
                    },'json');
                });

                $('#update-person-form').on('submit', function(e){
                    e.preventDefault();
                    var form = this;
                    $.ajax({
                        url:$(form).attr('action'),
                        method:$(form).attr('method'),
                        data:new FormData(form),
                        processData:false,
                        dataType:'json',
                        contentType:false,
                        beforeSend: function(){
                             $(form).find('span.error-text').text('');
                        },
                        success: function(data){console.log()
                              if(data.code == 0){
                                  $.each(data.error, function(prefix, val){
                                      $(form).find('span.'+prefix+'_error').text(val[0]);
                                  });
                              }else{
                                  $('#people_table').DataTable().ajax.reload(null, false);
                                  $('.updateperson').modal('hide');
                                  $('.updateperson').find('form')[0].reset();
                                  toastr.success(data.msg);
                              }
                        }
                    });
                });

                $(document).on('click','#deletePersonBtn', function(){
                    var person_id = $(this).data('id');
                    var url = '<?= route("delete.person") ?>';

                    swal.fire({
                         title:'Estas seguro?',
                         html:'Se <b>borrara</b> esta persona!',
                         showCancelButton:true,
                         showCloseButton:true,
                         cancelButtonText:'Cancelar',
                         confirmButtonText:'Si, estoy seguro',
                         cancelButtonColor:'#d33',
                         confirmButtonColor:'#556ee6',
                         width:300,
                         allowOutsideClick:false
                    }).then(function(result){
                          if(result.value){
                              $.post(url,{person_id:person_id}, function(data){
                                   if(data.code == 1){
                                       $('#people_table').DataTable().ajax.reload(null, false);
                                       toastr.success(data.msg);
                                   }else{
                                       toastr.error(data.msg);
                                   }
                              },'json');
                          }
                    });

                });




});
</script>
@endsection
