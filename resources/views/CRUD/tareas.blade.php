@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatable/datatables.min.css') }}">
@endsection

@section('content')
<div class="card mt-5">
    <div class="card-body">
        <form class="form-inline mb-3 d-flex justify-content-center">
            <div class="form-group mr-2 flex-grow-1 me-2">
                <input type="text" class="form-control w-100" placeholder="Ingresar Tarea..." id="inputTarea">
            </div>

            <button type="submit" class="btn btn-primary" id="agregarTarea"><i class="fas fa-plus"></i></button>
        </form>

        <table class="table" id="tablaTareas">
            <thead>
                <tr>
                    <th >Tarea</th>
                    <th id="accionesCol"">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@include('modals.confirmarEliminar')
@endsection

@section('scripts')
    <script src="{{ asset('js/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('js/CRUD/CRUD.js') }}"></script>
@endsection
