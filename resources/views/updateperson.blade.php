<div class="modal fade updateperson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form action="<?= route('update.person') ?>" method="post" id="update-person-form">
                    @csrf
                     <input type="hidden" name="person_id">
                     <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="name" placeholder="Nombres">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                       <label for="">Apellido</label>
                       <input type="text" class="form-control" name="last_name" placeholder="Apellidos">
                       <span class="text-danger error-text last_name_error"></span>
                   </div>
                    <div class="form-group">
                        <label for="">DNI</label>
                        <input type="text" class="form-control" name="dni" placeholder="Ejemplo: 123465">
                        <span class="text-danger error-text dni_error"></span>
                    </div>
                    <div class="form-group">
                       <label for="">Telefono</label>
                       <input type="text" class="form-control" name="phone" placeholder="Ejemplo: 55586422">
                       <span class="text-danger error-text phone_error"></span>
                   </div>
                     <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">Guardar Cambios</button>
                     </div>
                 </form>
                

            </div>
        </div>
    </div>
</div>