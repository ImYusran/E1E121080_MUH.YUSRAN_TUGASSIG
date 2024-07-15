// Inisialisasi variabel UI
const centerMapByAllMarkerBtn = document.getElementById(
  "centerMapByAllMarkerBtn"
);
const markerNameEl = document.getElementById("markerName");
const markerDescEl = document.getElementById("markerDescription");
const markerLatLngEl = document.getElementById("markerLatLng");

centerMapByAllMarkerBtn.addEventListener("click", () => {
  resetView();
});

// Boostrap Tooltip Element
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Bootstrap OffCanvas Element
var offcanvasRightEl = document.getElementById("offcanvasRight");
var bsOffcanvasRight = new bootstrap.Offcanvas(offcanvasRightEl);

// Bootstrap tooltip
var addMarkerLinkEl = document.getElementById("addMarkerLink");
var addMarkerTooltip = new bootstrap.Tooltip(addMarkerLinkEl);

var lastMapLatLng = sessionStorage.getItem("lastMapLatLng");
var lastMapZoom = sessionStorage.getItem("lastMapZoom");

var markersLatLng = [];

map.on("moveend", (e) => saveLastMapState(e));

// Tampilkan marker jika ada
if (json.markers.data.length > 0) {
  var data = json.markers.data;

  data.forEach((data) => {
    const name = data.name === "" ? "Marker tanpa nama" : data.name;
    const description =
      data.description === "" ? "Marker tanpa deskripsi" : data.description;

    L.marker([data.lat, data.lng])
      // Listener 'Klik'
      .on("click", (e) => {
        map.flyTo(e.latlng, map.getZoom(), {
          animate: true,
          duration: 1,
        });
      })
      // Listener 'contextmenu' / klik kanan
      .on("contextmenu", () => {
        markerNameEl.innerText = name;
        markerDescEl.innerText = description;
        markerLatLngEl.innerText = `Lat: ${data.lat.toPrecision(
          6
        )}, Lng: ${data.lng.toPrecision(6)}`;

        bsOffcanvasRight.show();
      })
      // Tambahkan tooltip ke marker
      .bindTooltip("Klik kanan untuk melihat informasi marker")
      .addTo(map);

    markersLatLng.push([data.lat, data.lng]);
  });

  // Atur posisi peta jika keadaan sebelumnya ada
  setMapViewBySessionState();

  centerMapByAllMarkerBtn.removeAttribute("disabled");
} else {
  addMarkerTooltip.show();
  setTimeout(() => {
    addMarkerTooltip.hide();
  }, 3000);

  centerMapByAllMarkerBtn.setAttribute("disabled", true);
  setMapViewBySessionState()
}

function setMapViewBySessionState() {
  if (lastMapLatLng && lastMapZoom) {
    var jsonParseLatMapLatLng, jsonParseLastMapZoom;

    jsonParseLatMapLatLng = JSON.parse(lastMapLatLng);
    jsonParseLastMapZoom = lastMapZoom;

    map.setView(jsonParseLatMapLatLng, jsonParseLastMapZoom);
  } else {
    resetView();
  }
}

function resetView() {
  if (markersLatLng.length > 0) {
    map.flyToBounds(markersLatLng, {animate: true, maxZoom: map.getZoom()})
  
  } else {map.fitWorld()}
}

function saveLastMapState(e) {
  var center, zoom, options;
  latlng = e.target.getCenter();
  zoom = e.target.getZoom();

  sessionStorage.setItem("lastMapLatLng", JSON.stringify(latlng));
  sessionStorage.setItem("lastMapZoom", zoom);
}

