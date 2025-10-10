document.addEventListener('DOMContentLoaded', function() {
    const iconoBusqueda = document.getElementById('icono-busqueda');
    const navbarItems = document.getElementById('navbar-items');
    const barraBusqueda = document.getElementById('barra-busqueda');
    let barraVisible = false;

    iconoBusqueda.addEventListener('click', function() {
        barraVisible = !barraVisible;
        if(barraVisible) {
            navbarItems.style.display = 'none';
            barraBusqueda.style.display = 'block';
            barraBusqueda.focus();
        } else {
            navbarItems.style.display = '';
            barraBusqueda.style.display = 'none';
            barraBusqueda.value = '';
        }
    });
});