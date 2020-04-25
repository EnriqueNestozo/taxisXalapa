function cargarListado(){
    var data = sessionStorage.getItem('token');
    $('#listadoServiciosPendientes').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
        url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        ajax: {
        url: rutaListadoServiciosPendientes,
        type: "GET",
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+data,
        }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'horarios[0].hora', name: 'horarios[0].hora'},
            {data: "cliente.nombre", name: 'cliente.nombre'},
            {data: "direccionCompleta", name: 'direccionCompleta'},
            {data: 'action', name:'action'}
        ]
    });
}

function generarRegistro(idServicio){
    console.log(idServicio);
    $('#modalRegistroDiario').modal('show');
}

function cancelarRegistro(idServicio){
    console.log(idServicio);
}