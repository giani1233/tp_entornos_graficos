function moverCarrusel(direccion) {
    const carrusel = document.querySelector('.carrusel-promociones');
    if (!carrusel) return;
    const tarjetas = document.querySelectorAll('.tarjeta-promo');
    if (tarjetas.length === 0) return;
    const gap = parseInt(getComputedStyle(carrusel).gap) || 20;
    const anchoTarjeta = tarjetas[0].offsetWidth + gap;
    let desplazamiento = anchoTarjeta * direccion;
    const scrollLeft = Math.round(carrusel.scrollLeft);
    const maxScrollLeft = carrusel.scrollWidth - carrusel.offsetWidth;
    if (direccion === 1 && scrollLeft >= maxScrollLeft) {
        carrusel.scrollTo({ left: 0, behavior: 'smooth' });
        return;
    }
    if (direccion === -1 && scrollLeft === 0) {
        carrusel.scrollTo({ left: maxScrollLeft, behavior: 'smooth' });
        return;
    }
    carrusel.scrollBy({
        left: desplazamiento,
        behavior: 'smooth'
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const promociones = document.querySelectorAll('.tarjeta-promo');
    if (promociones.length > 1) {
        setInterval(() => {
            moverCarrusel(1);
        }, 8000);
    }
});
