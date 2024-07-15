const toggleBtn = document.getElementById("toggleBtn");
const submitBtn = document.getElementById("submitBtn");
const resetBtn = document.getElementById("resetBtn");
const inputLat = document.getElementById("inputLat");
const inputLng = document.getElementById("inputLng");

var toggleBtnState = true;
toggleBtn.innerText = "Sembunyikan"

toggleBtn.addEventListener("click", () => toggleExistMarker(toggleBtnState));
resetBtn.addEventListener("click", () => resetForm());

inputLat.addEventListener("input", (e) => {
  var targetValue = e.target.value;

  if (targetValue > 90) {
    e.target.value = 90;
  } else if (targetValue < -90) {
    e.target.value = -90;
  }

  if (!isNaN(targetValue)) {
    var currentLng = map.getCenter().lng;
    var latlng = [targetValue, currentLng];

    map.setView(latlng);
    if (marker == undefined) {
      addMarkerToMap(latlng);
    } else {
      marker.setLatLng(latlng);
    }
  }

  validateInputLatLng();
});
inputLng.addEventListener("input", (e) => {
  var targetValue = e.target.value;
  
  console.log(targetValue)
  if (targetValue >= 180) {
    e.target.value = 180;
  } else if (targetValue <= -180) {
    e.target.value = -180;
  }
  console.log(targetValue)

  if (!isNaN(targetValue)) {
    var currentLat = map.getCenter().lat;
    var latlng = [currentLat, targetValue];

    map.setView(latlng);
    if (marker == undefined) {
      addMarkerToMap(latlng);
    } else {
      marker.setLatLng(latlng);
    }
  }

  validateInputLatLng();
});

var marker, previousMarker;
map.on("click", (e) => {
  var latlng;

  latlng = e.latlng;

  inputLat.value = latlng.lat;
  inputLng.value = latlng.lng;

  addMarkerToMap(latlng);

  map.panTo(latlng, map.getZoom(), {
    animate: true,
  });
  validateInputLatLng();
});

map.on("moveend", (e) => {
  var latlng, zoom;
  latlng = e.target.getCenter();
  zoom = e.target.getZoom();

  sessionStorage.setItem("lastMapLatLng", JSON.stringify(latlng));
  sessionStorage.setItem("lastMapZoom", zoom);
});

map.on("movestart", () => {
  L.DomUtil.removeClass(map._container, 'crosshair-cursor-enabled');
});

map.on("moveend", () => {
  L.DomUtil.addClass(map._container, 'crosshair-cursor-enabled');
});

var markersGroup = L.layerGroup().addTo(map);
if (json.markers.data.length > 0) {
  var data = json.markers.data;

  markersGroup.clearLayers();

  data.forEach((data) => {
    var marker = L.marker([data.lat, data.lng], {
      interactive: false,
      opacity: 0.5,
    });

    markersGroup.addLayer(marker);
  });
  toggleBtn.removeAttribute("disabled");
} else {
  toggleBtn.setAttribute("disabled", true);
}

var lastMapLatLng, lastMapZoom;

lastMapLatLng = sessionStorage.getItem("lastMapLatLng");
lastMapZoom = sessionStorage.getItem("lastMapZoom");

if (lastMapLatLng && lastMapZoom) {
  var jsonParseLatMapLatLng, jsonParseLastMapZoom;

  jsonParseLatMapLatLng = JSON.parse(lastMapLatLng);
  jsonParseLastMapZoom = lastMapZoom;

  map.setView(jsonParseLatMapLatLng, jsonParseLastMapZoom);
}

function addMarkerToMap(latlng) {
  if (previousMarker !== undefined) {
    previousMarker.remove();
  }

  marker = L.marker(latlng, {
    draggable: true,
    autoPan: true,
  })
    .on("moveend", (e) => {
      var latlng = e.target.getLatLng();
      inputLat.value = latlng.lat;
      inputLng.value = latlng.lng;

      map.panTo(latlng, map.getZoom(), {
        animate: true,
      });
    })
    .addTo(map);

  previousMarker = marker;
}

function toggleExistMarker() {
  toggleBtnState = !toggleBtnState;
  if (toggleBtnState) {
    toggleBtn.innerText = "Sembunyikan";
    markersGroup.addTo(map);
  } else {
    toggleBtn.innerText = "Tampilkan";
    markersGroup.remove();
  }
}

function resetForm() {
  marker.remove();
  marker = undefined;
  inputLat.value = "";
  inputLng.value = "";

  validateInputLatLng();
}

function validateInputLatLng() {
  var inputLatValue = inputLat.value.trim();
  var inputLngValue = inputLng.value.trim();

  var notEmpty = inputLatValue != "" && inputLngValue != "";
  var notNaN = !isNaN(inputLatValue) && !isNaN(inputLngValue);

  if (notEmpty && notNaN) {
    submitBtn.removeAttribute("disabled");
    resetBtn.removeAttribute("disabled");
  } else {
    submitBtn.setAttribute("disabled", true);
    resetBtn.setAttribute("disabled", true);
  }
}
