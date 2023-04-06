 <style>
     #map {
         height: 400px;
     }
 </style>
 <div id="map"></div>
 <script>
     var lokasi = "{{ $presensi->location_in }}";
     var lokasi_user = lokasi.split(",");
     var latitude = lokasi_user[0];
     var longitude = lokasi_user[1];
     var map = L.map('map').setView([latitude, longitude], 17);
     L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
         maxZoom: 19,
         attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
     }).addTo(map);
     var marker = L.marker([latitude, longitude]).addTo(map);
     var circle = L.circle([-6.254017, 106.825138], {
         // -6.254017, 106.825138
         color: '#00b3ff',
         fillColor: '#00b3ff',
         fillOpacity: 0.5,
         radius: 50
     }).addTo(map);
     var popup = L.popup()
         .setLatLng([latitude, longitude])
         .setContent("{{ $presensi->nama_lengkap }}")
         .openOn(map);
 </script>
