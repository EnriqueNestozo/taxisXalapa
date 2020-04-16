function verificarExistenciasDeServicios() {
    console.log("aqui");
    md.showNotification('bottom','right','info','Hay un servicio pendiente sin asignar en 1 hora.');
    setTimeout(verificarExistenciasDeServicios, 15000);
}