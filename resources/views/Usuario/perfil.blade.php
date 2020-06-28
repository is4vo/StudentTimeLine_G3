@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom-ajustarVistaPerfil">
                <div class="card-header custom-color custom-perfil">Mi Perfil</div>
                <div class="card-body"> 
                    <div class= "custom-foto float-center">
                        <img id="avatarImagen" class="imagen" src="../images/{{$user->imagen}}" alt="">
                    </div> 
                        <form id="avatarCambio" action="{{ route('users.postProfileImage') }}" class="float-center custom-olvido custom-perfilElemento">
                            {{ __('Cambiar foto de perfil') }}  
                            <input class="col-md-8 float-center custom-invisible" type="file" id="avatarInput" onclick="cambiarImagen()">                
                        </form>
                    <ul class= "float-left custom-perfilElemento">
                        <a class="custom-negrita">Nombre:</a> 
                        {{$user->name}}
                    </ul>
                    <ul class= "float-left custom-perfilElemento">
                        <a class="custom-negrita">Correo:</a>
                        {{$user->email}}
                    </ul>
                    <button type="button" class="btn btn-link loat-center custom-olvido" data-toggle="modal" data-target="#exampleModal">
                        ¿Desea cambiar su contraseña?
                    </button>
                    
                    
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                    <div class="modal-header custom-color">
                            <h5 class="modal-title" id="exampleModalLabel" style="color:white">Cambio de Contraseña</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('users.updatecontrasena') }}" method="post">
                <div class="modal-body">
                    <!-- Aqui va el código de las contraseñar -->

                    
                    @csrf
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña Antigua') }}</label>

                            <div class="col-md-6 inputWithIcon">
                                <input id="old_password" type="password" placeholder="••••••••••••••" class="custom-ajusteTextoImagen form-control" name="old_password" >
                                <i class="fa fa-key fa-lg" aria-hidden="true"></i>
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña Nueva') }}</label>

                            <div class="col-md-6 inputWithIcon">
                                <input id="password" type="password" placeholder="••••••••••••••" class="custom-ajusteTextoImagen form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <i id="show_password" class="fa fa-eye-slash fa-lg icon"  onclick="mostrarPassword()"></i>


                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar nueva Contraseña') }}</label>
                            
                            <div class="col-md-6 inputWithIcon">
                                <input id="password-confirm" type="password" placeholder="••••••••••••••" class="custom-ajusteTextoImagen form-control" name="password_confirmation" required autocomplete="new-password">
                                <i class="fa fa-lock fa-lg" aria-hidden="true"></i>
                            </div>
                        </div>
                
                </div>

                <div class="modal-footer">
                    
                    <button style="background-color: #2a9d8f" class="btn btn-info btn-sm">Guardar Cambios</button>
                    </form>
                    <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
             
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script type="text/javascript">
    var $avatarInput, $avatarCambio, $avatarImagen;
    var avartarUrl;

    function cambiarImagen(){
        $avatarInput = $('#avatarInput');
        $avatarCambio = $('#avatarCambio');
        $avatarImagen = $('#avatarImagen');

        $avatarUrl = $avatarCambio.attr('action');

        $avatarInput.on('change', function() {

            var formData = new FormData();
            formData.append('photo', $avatarInput[0].files[0]);

            $.ajax({
                url: $avatarUrl+'?'+$avatarCambio.serialize(),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false
            })
            .done(function(data){
                if(data.success)
                    $avatarImagen.attr('src', '..images/'+data.file_name);
            })
            .fail(function() {
                alert('La imagen subida no tiene el formato correcto');
            });
        });
    }
</script>

<script type="text/javascript">
        
    function mostrarPassword(){
        var cambio = document.getElementById("password");

        if(cambio.type == "password"){
            cambio.type = "text";
        
            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }

        else{
            cambio.type = "password";

            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }                           
    }
     
</script>

<script>
     
    $( document ).ready(function() {
        $('.modal').on('show.bs.modal', function(){
            $(this).find('form')[0].reset();
        });
    });
</script>
@endsection
