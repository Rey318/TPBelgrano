/* document.addEventListener("DOMContentLoaded", function() {
    var promoModalId = "#modal-<?php echo $promoRandomId; ?>"; // ID del modal aleatorio
    
    // Verificar si el modal existe antes de mostrarlo
    var promoModalElement = document.querySelector(promoModalId);
    
    if (promoModalElement) {
        var promoModal = new bootstrap.Modal(promoModalElement);
        promoModal.show();  // Mostrar la modal aleatoria
    }
}); */


//========================= AJAX =============================

function descontarProducto(idProducto) {
    fetch('descuento-productos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: idProducto, cantidad: 1 }) // Cambia la cantidad aquí si deseas otro valor
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Su compra exitosamente!');
            // 
            // Actualizar el contador de productos en la interfaz.
        } else {
            alert('Error al descontar el producto.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al realizar la acción.');
    });
}

