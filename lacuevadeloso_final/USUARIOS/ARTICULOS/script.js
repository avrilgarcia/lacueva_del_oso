// Definir la ruta base para imágenes u otros archivos
const BASE_URL = "http://localhost/USUARIOS/ARTICULOS/";

// Cargar filtros dinámicamente
function cargarFiltros() {
  fetch("obtener_filtros.php")
    .then(res => res.json())
    .then(data => {
      const colorCont = document.getElementById("filtro-color");
      const tipoCont = document.getElementById("filtro-tipo");
      const tallaSel = document.getElementById("filtro-talla");

      colorCont.innerHTML = data.colores.map(c =>
        `<div class="form-check">
          <input class="form-check-input" type="checkbox" value="${c.id}" id="color-${c.id}">
          <label class="form-check-label" for="color-${c.id}">${c.nombre}</label>
        </div>`
      ).join("");

      tipoCont.innerHTML = data.tipos.map(t =>
        `<div class="form-check">
          <input class="form-check-input" type="checkbox" value="${t.id}" id="tipo-${t.id}">
          <label class="form-check-label" for="tipo-${t.id}">${t.nombre}</label>
        </div>`
      ).join("");

      tallaSel.innerHTML = `<option value="">Todas</option>` + data.tallas.map(t =>
        `<option value="${t.id}">${t.nombre}</option>`
      ).join("");
    });
}

// Obtener filtros seleccionados
function obtenerFiltros() {
  const filtros = {};

  const colores = Array.from(document.querySelectorAll("#filtro-color input:checked")).map(el => el.value);
  const tipos = Array.from(document.querySelectorAll("#filtro-tipo input:checked")).map(el => el.value);
  const talla = document.getElementById("filtro-talla").value;
  const precioMin = document.getElementById("precioMin").value;
  const precioMax = document.getElementById("precioMax").value;

  if (colores.length > 0) filtros.colores = colores.join(",");
  if (tipos.length > 0) filtros.tipos = tipos.join(",");
  if (talla) filtros.talla = talla;
  if (precioMin) filtros.precioMin = precioMin;
  if (precioMax) filtros.precioMax = precioMax;

  return filtros;
}

// Cargar productos según filtros
function cargarProductos() {
  const filtros = obtenerFiltros();
  const query = new URLSearchParams(filtros).toString();

  fetch("obtener_prenda.php?" + query)
    .then(res => res.json())
    .then(data => {
      const contenedor = document.getElementById("productos");
      contenedor.innerHTML = "";

      if (data.length === 0) {
        contenedor.innerHTML = "<div class='col'>No se encontraron resultados.</div>";
        return;
      }

      data.forEach(p => {
        contenedor.innerHTML += `
          <div class="col">
            <div class="card h-100">
              <img src="${BASE_URL + p.imagen}" class="card-img-top" alt="${p.nombre}">
              <div class="card-body">
                <h5 class="card-title">${p.nombre}</h5>
                <p class="card-text">$${p.precio} MXN</p>
              </div>
              <div class="card-footer bg-white">
                <button class="btn btn-sm btn-outline-primary w-100">Ver más</button>
              </div>
            </div>
          </div>`;
      });
    });
}

// Cargar todo al inicio
window.onload = () => {
  cargarFiltros();
  cargarProductos();
};

