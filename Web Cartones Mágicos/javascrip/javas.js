/*codigo cesta de la compra*/
// Creamos un array para guardar los productos
 let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
 // Asegurarse de que todos los precios son números (para evitar errores antiguos)
carrito = carrito.map(carta => ({
  ...carta,
  precio: parseFloat(carta.precio)
}));


    function guardarCarrito() {
      localStorage.setItem('carrito', JSON.stringify(carrito));
    }

    function agregarAlCarrito(nombre, precio, imagen = '') {
      const cartaExistente = carrito.find(carta => carta.nombre === nombre);

      if (cartaExistente) {
        cartaExistente.cantidad++;
      } else {
        carrito.push({ nombre, precio, cantidad: 1, imagen });
      }
      mostrarToast(`"${nombre}" añadido al carrito`);
      guardarCarrito();
      actualizarCarrito();
    }

    function actualizarCarrito() {
      const tbody = document.getElementById('carrito-tabla-body');
      tbody.innerHTML = '';

      let total = 0;

      carrito.forEach((carta, index) => {
        const subtotal = carta.precio * carta.cantidad;
        total += subtotal;

        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>
              <div class="mini-img-hover">
                <img src="${carta.imagen}" alt="${carta.nombre}" class="carrito-img">
                <div class="hover-ampliada">
                  <img src="${carta.imagen}" alt="${carta.nombre}">
                </div>
              </div>
          </td>
          <td>${carta.nombre}</td>
          <td>${carta.precio.toFixed(2)}€</td>
          <td>${carta.cantidad}</td>
          <td>${subtotal.toFixed(2)}€</td>
          <td><button class="btn btn-sm btn-danger" onclick="eliminarCarta(${index})">X</button></td>`;
        tbody.appendChild(fila);
      });

      document.getElementById('carrito-total').textContent = `${total.toFixed(2)}€`;

      actualizarContadorCarrito();
    }

    function eliminarCarta(index) {
      carrito.splice(index, 1);
      guardarCarrito();
      actualizarCarrito();
    }
    function actualizarContadorCarrito() {
      const contador = document.getElementById('contador-carrito');
      const totalCartas = carrito.reduce((sum, carta) => sum + carta.cantidad, 0);
      contador.textContent = totalCartas;
    }
function mostrarToast(mensaje) {
  if (!mensaje) return; // ⛔ No crear toast si no hay mensaje

  const contenedor = document.getElementById('toast-container');
  if (!contenedor) {
    console.error('No se encontró el contenedor del toast (#toast-container)');
    return;
  }

  const toast = document.createElement('div');
  toast.textContent = mensaje;

  toast.style.cssText = `
    background-color: #d18a00;
    color: black;
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    font-weight: bold;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    margin-bottom: 10px;
  `;

  contenedor.appendChild(toast);

  requestAnimationFrame(() => {
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
  });

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-10px)';
    setTimeout(() => toast.remove(), 300);
  }, 2500);
}



    document.getElementById('vaciar-carrito')?.addEventListener('click', () => {
      carrito = [];
      guardarCarrito();
      actualizarCarrito();
    });

    document.getElementById('comprar')?.addEventListener('click', () => {
      if (carrito.length === 0) {
        alert('Tu carrito está vacío.');
        return;
      }
      alert('¡Gracias por tu compra!');
      carrito = [];
      guardarCarrito();
      actualizarCarrito();
    });
    document.querySelectorAll('.carrito-icono').forEach(icono => {
      icono.addEventListener('click', () => {
        const nombre = icono.dataset.nombre;
        const precioTexto = icono.dataset.precio;
        const imagen = icono.dataset.imagen || ''; 

        // Quita el símbolo € y conviértelo a número
        const precio = parseFloat(precioTexto.replace('€', '').trim());

        if (!isNaN(precio) && nombre) {
          agregarAlCarrito(nombre, precio, imagen);
        } else { 
          console.error('Datos del producto inválidos:', { nombre, precioTexto });
        }
      });
    });
    actualizarContadorCarrito();
    actualizarCarrito();
  
    



/*supuesto codigo que sirve para el buscar cartas*/
  document.getElementById('filtro-cartas').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const cartas = document.querySelectorAll('.carta-item');

    cartas.forEach(carta => {
      const nombre = carta.getAttribute('data-nombre').toLowerCase();
      carta.style.display = nombre.includes(filtro) ? '' : 'none';
    });
  });
