class CRUD {
    cargarEndpoint = '/cargar';
    completarEndpoint = '/completar';
    modificarEndpoint = '/modificar';
    eliminarEndpoint = '/eliminar';
    agregarEndpoint = '/agregar';
    tareaOriginal = '';
    constructor() {
        this.cargarTabla();
        this.nuevaTarea();

    }

    cargarTabla(){
        let _this = this;
        if ($.fn.DataTable.isDataTable('#tablaTareas')) {
            $('#tablaTareas').DataTable().destroy();
        }

        $('#tablaTareas').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "ajax": {
                "url": baseUrl+_this.cargarEndpoint,
                "type": "POST",
                "dataType": "json",
                "data": 'data',
                "error": function(error) {
                    console.log("Error al obtener los datos de la pagina");
                }
            },
            "columns": [
                {
                    "data": "tarea",
                    "render": function(data, type, row) {
                        let clase = row.estatus == 'completada' ? 'tachado' : '';
                        return '<span class="' + clase + '">' + data + '</span>';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        let acciones = '<div style="width: 100%; float: right;">';
                        if (row.estatus == 'completada'){
                            acciones += '<button class="btn btn-success disabled" data-id="' + row.id + '"><i class="fas fa-check"></i></button>';
                            acciones += ' <button class="btn btn-primary disabled" data-id="' + row.id + '"><i class="fas fa-edit"></i></button>';
                        }else{
                            acciones += '<button class="btn btn-success completar" data-id="' + row.id + '"><i class="fas fa-check"></i></button>';
                            acciones += ' <button class="btn btn-primary editar" data-id="' + row.id + '"><i class="fas fa-edit"></i></button>';
                        }
                        acciones += ' <button class="btn btn-danger eliminar" data-id="' + row.id + '"><i class="fas fa-times"></i></button>';
                        acciones += '</div>';
                        return acciones;
                    }
                },
            ],
            "language": {
                "emptyTable":     "No hay tareas registradas",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ tareas",
                "infoEmpty":      "Mostrando 0 a 0 de 0 tareas",
                "infoFiltered":   "(filtrados de _MAX_ tareas totales)",
                "lengthMenu":     "Mostrar _MENU_ registros por página",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "zeroRecords":    "No se encontraron tareas registradas",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
        });
        $('#accionesCol').css('width', '12%');
        _this.editarTarea();
        _this.completarTarea();
        _this.eliminarTarea();
    }

    nuevaTarea(){
        let _this = this;
        $('#agregarTarea').click(function (e) {
            e.preventDefault();
            let tarea = $('#inputTarea').val().trim();

            if (tarea == ''){
                alert('El campo con la tarea se encuentra vacío')
                return;
            }

            let data = {
                "tarea": tarea
            };

            $.ajax({
                type: "POST",
                url: baseUrl+_this.agregarEndpoint,
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.estatus == true){
                        $('#inputTarea').val('');
                        _this.cargarTabla();
                        _this.editarTarea();
                    }
                },error: function(error) {
                    console.log(error);
                    alert('No se pudo agregar la tarea');
                }
            });

        });
    }

    editarTarea(){
        let _this = this;
        $('#tablaTareas').on('click', '.editar', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let tareaCelda = $(this).closest('tr').find('td:first');
            if (tareaCelda.find('input').length > 0) {
                let inputEdit = tareaCelda.find('input');
                tareaCelda.text(_this.tareaOriginal);
                return;
            }
            _this.tareaOriginal = tareaCelda.text();
            let inputTarea = $('<input type="text" class="form-control">').val(_this.tareaOriginal);
            tareaCelda.html(inputTarea);

            inputTarea.focus();

            inputTarea.on('keypress', function(event) {
                if (event.key === 'Enter') {
                    let nuevaTarea = $(this).val().trim();
                    if (nuevaTarea == '') {
                        alert('El campo de tarea no puede estar vacío');
                        $(this).val(_this.tareaOriginal);
                        return;
                    }
                    let data = {
                        "tarea": nuevaTarea
                    };
                    $.ajax({
                        type: "PUT",
                        url: baseUrl+_this.modificarEndpoint+'/'+id,
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            if (response.estatus == true) {
                                _this.cargarTabla();
                                _this.editarTarea();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            alert('No se pudo modificar la tarea');
                            inputTarea.val(_this.tareaOriginal);
                        }
                    });
                }
            });
        });
    }

    completarTarea(){
        let _this = this;
        $('#tablaTareas').on('click', '.completar', function(e) {
            e.preventDefault
            let id = $(this).data('id');
            $.ajax({
                type: "PATCH",
                url: baseUrl+_this.completarEndpoint+'/'+id,
                dataType: "json",
                success: function (response) {
                    if (response.estatus == true){
                        _this.cargarTabla();
                        _this.editarTarea();
                    }
                },error: function(error) {
                    console.log(error);
                    alert('No se pudo completar la tarea');
                }
            });
        });
    }

    eliminarTarea(){
        let _this = this;
        $('#tablaTareas').on('click', '.eliminar', function(e) {
            e.preventDefault
            let id = $(this).data('id');
            $('#confirmarEliminarModal').modal('show');

            $('#confirmarEliminarBtn').off('click').on('click', function() {
                $('#confirmarEliminarModal').modal('hide');
                $.ajax({
                    type: "DELETE",
                    url: baseUrl+_this.eliminarEndpoint+'/'+id,
                    dataType: "json",
                    success: function (response) {
                        if (response.estatus == true){
                            _this.cargarTabla();
                            _this.editarTarea();
                        }
                    },error: function(error) {
                        console.log(error);
                        alert('No se pudo eliminar la tarea');
                    }
                });
            });
        });
    }

}

$(document).ready(function() {
    let manejador = new CRUD();
});

