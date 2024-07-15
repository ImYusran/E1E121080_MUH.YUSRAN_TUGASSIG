// Inisialisasi UI Element
const formText = document.getElementById("formText");
const formFieldSet = document.getElementById("formFieldSet");
const inputForm = document.getElementById("inputForm");
const inputMarkerId = document.getElementById("inputMarkerId");
const inputLat = document.getElementById("inputLat");
const inputLng = document.getElementById("inputLng");
const inputName = document.getElementById("inputName");
const inputDesc = document.getElementById("inputDesc");
const submitBtn = document.getElementById("submitBtn");
const deleteBtn = document.getElementById("deleteBtn");

// Deklarasi Variabel
var markersGroup = L.layerGroup().addTo(map);
var markersGroup2 = L.layerGroup().addTo(map);
var markersLatLng = [];
var markers = [];

var onEditMarker = false;
var selectedMarker;

var lastMapLatLng = sessionStorage.getItem("lastMapLatLng");
var lastMapZoom = sessionStorage.getItem("lastMapZoom");

// Listener
inputMarkerId.addEventListener("valueChangeMarkerId", (e) => {
  var toggleButtonInput = e.target.value !== "";
  if (toggleButtonInput) {
    disableInputForm(false);
  }
});

map.on("click", (e) => {
  if (onEditMarker && selectedMarker !== undefined) {
    inputLat.value = e.latlng.lat;
    inputLng.value = e.latlng.lng;
    selectedMarker.setLatLng(e.latlng);

    map.panTo(e.latlng, map.getZoom(), {
      animate: true,
    });
  }
});

map.on("moveend", (e) => {
  var zoom;
  latlng = e.target.getCenter();
  zoom = e.target.getZoom();

  sessionStorage.setItem("lastMapLatLng", JSON.stringify(latlng));
  sessionStorage.setItem("lastMapZoom", zoom);
});

map.on("movestart", () => {
  L.DomUtil.removeClass(map._container, 'crosshair-cursor-enabled');
});

map.on("moveend", () => {
  if (onEditMarker) {
    L.DomUtil.addClass(map._container, 'crosshair-cursor-enabled');
  }
});

if (json.markers.data.length == 0) {
  Swal.fire({
    title: "Tidak ada data marker",
    icon: "info",
    text: "Untuk bisa mengelola marker, silahkan tambahkan marker",
    toast: true,
    showConfirmButton: false,
    position: "top-end",
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    },
  });
  disableInputForm();
  formText.innerText = "Tidak ada marker. Tambahkan terlebih dahulu untuk bisa mengelola marker"
}


if (json.markers.data.length > 0) {
  var data = json.markers.data;
  populateMarker();
  mapSetViewBySession();
} else {
  setMapViewBySessionState();
}

// Function
// Custom Event
function dispatchMarkedIdEvent() {
  const event = new CustomEvent("valueChangeMarkerId");
  inputMarkerId.dispatchEvent(event);
  onEditMarker = true;
}

function mapSetViewBySession() {
  if (lastMapLatLng && lastMapZoom) {
    var jsonParseLatMapLatLng, jsonParseLastMapZoom;

    jsonParseLatMapLatLng = JSON.parse(lastMapLatLng);
    jsonParseLastMapZoom = JSON.parse(lastMapZoom);

    map.setView(jsonParseLatMapLatLng, jsonParseLastMapZoom);
  }
}

function populateMarker() {
  markersGroup.clearLayers();

  markersGroup2.clearLayers();
  markersGroup2.removeFrom(map);

  data.forEach((data) => {
    var marker = L.marker([data.lat, data.lng]).on("click", (e) => {
      markersGroup.clearLayers();

      markersGroup2.addTo(map);

      const id = data.id;
      const lat = e.latlng.lat !== data.lat ? e.latlng.lat : data.lat;
      const lng = e.latlng.lng !== data.lng ? e.latlng.lng : data.lng;
      const name = data.name;
      const desc = data.description;

      inputMarkerId.value = id;
      inputLat.value = lat;
      inputLng.value = lng;
      inputName.value = name;
      inputDesc.value = desc;

      map.flyTo([lat, lng], map.getZoom(), {
        animate: true,
      });

      var marker = L.marker([lat, lng], {
        draggable: true,
        autoPan: true,
      }).on("moveend", (e) => {
        var latlng = e.target.getLatLng();
        inputLat.value = latlng.lat;
        inputLng.value = latlng.lng;

        map.panTo(latlng, map.getZoom(), {
          animate: true,
        });
      });

      markersGroup.addLayer(marker);
      selectedMarker = marker;

      if (selectedMarker !== undefined) {
        const latlngSelectedMarker = selectedMarker.getLatLng();
        markersGroup2.eachLayer((e) => {
          var latlng = e.getLatLng();
          console.log(e)
          if (
            latlngSelectedMarker.lat === latlng.lat &&
            latlngSelectedMarker.lng === latlng.lng
          ) {
            e.removeFrom(markersGroup2);
          }
        });
      }

      formText.innerText =
        "Klik peta atau drag marker untuk memperbarui posisi Latitude dan Longitude";

      dispatchMarkedIdEvent();
    });

    var marker2 = L.marker([data.lat, data.lng], {
      interactive: false,
      opacity: 0.35,
    });

    markersLatLng.push([data.lat, data.lng]);

    markersGroup.addLayer(marker);
    markersGroup2.addLayer(marker2);
  });
}

function resetForm(populateMarker) {
  formText.innerText = "Klik pada marker untuk mulai mengubah informasi marker";
  inputMarkerId.value = "";
  inputLat.value = "";
  inputLng.value = "";
  inputName.value = "";
  inputDesc.value = "";

  disableInputForm();

  populateMarker();

  onEditMarker = false;
}

function disableInputForm(b = true) {
  if (!b) {
    formFieldSet.removeAttribute("disabled");
    return;
  }
  formFieldSet.setAttribute("disabled", b);
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
    map.fitBounds(markersLatLng, {
      maxZoom: map.getZoom(),
      animate: true,
    });
  }
}
