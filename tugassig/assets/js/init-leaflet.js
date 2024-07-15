const map = L.map("map", {
  center: [-3.9883, 122.5182],  
  minZoom: 3,
  maxZoom: 18,
  maxBounds: [
    [90, 180],
    [-90, -180],
  ],
  maxBoundsViscosity: 1.0,
  worldCopyJump: true,
});

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,  
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
