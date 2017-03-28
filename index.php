<!DOCTYPE html>
<html>
    <head>
        <title>Leaflet PouchDB Tiles example</title>
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link  rel= stylesheet href="css/leaflet.css" />
    </head>
    <body>
        <div id="map" style="width: 100vh; height: 90vh"></div>

        <button onclick="seed()">Enregister cette partie de la map Z:12 Z:14</button>





        <script src="js/leaflet-src.js"></script>
        <script src="js/pouchdb-6.1.2.js"></script>

        <script src="js/tile_cached.js"></script>
        <script>

            // 		var map = L.map('map').setView([63.41784,10.40359], 5);
            var map = L.map('map').setView([
                46.56901044210197,6.223411560058595],12);


            var layer = L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                maxZoom: 14,
                minZoom:12,
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                id: 'examples.map-i875mjb7',
                useCache: true,
                crossOrigin: true

            });


            // Listen to cache hits and misses and spam the console
            // The cache hits and misses are only from this layer, not from the WMS layer.
            layer.on('tilecachehit',function(ev){
                console.log('Cache hit: ', ev.url);
            });
            layer.on('tilecachemiss',function(ev){
                console.log('Cache miss: ', ev.url);
            });
            layer.on('tilecacheerror',function(ev){
                console.log('Cache error: ', ev.tile, ev.error);
            });

            layer.addTo(map);




            // stocke en mémoire cache les fonds de map de la vue séléctionner par l'utilisateur dans PouchDB
            function seed() {
                var bbox = map.getBounds();// la partie de la map que veut l'utilisateur

                layer.seed( bbox, 12, 14 );

            }

            // affiche une progression dans la console
            layer.on('seedprogress', function(seedData){
                var percent = 100 - Math.floor(seedData.remainingLength / seedData.queueLength * 100);
                console.log('Seeding ' + percent + '% done');
            });
            layer.on('seedend', function(seedData){
                console.log('Cache seeding complete');
            });

////////////////////////////////TEST BASE DE DONNÉES/////////////////////////////////////////////////////////////////////////////!!!

            var prsDB = new PouchDB('localDB');

            ////////////////////////////////////////////////////////

            // localDB.sync(remoteDB, {
            //   live: true,
            //   retry: true
            // }).on('change', function (change) {
            //   // yo, something changed!
            // }).on('paused', function (info) {
            //   // replication was paused, usually because of a lost connection
            // }).on('active', function (info) {
            //   // replication was resumed
            // }).on('error', function (err) {
            //   // totally unhandled error (shouldn't happen)
            // });

          /////////////////////////////////////////////////////////////
          
            prsDB.info().then(function (info) {
                console.log(info);
                // Donnes les infos sur la base de données nombre de docs etc
            })

            // recupere les infos sur un prs en fonction de sont id

            prsDB.get("cef41ea3701f8e4274a935cb14161c9b", function(err, doc) {
                if (err) {
                    return console.log(err);
                } else {
                    console.log(doc);
                }
            });


            prsDB.allDocs({include_docs: true}, function(err, docs) {
                if (err) {
                    return console.log(err);
                } else {
                    var prs = docs.rows;
                    console.log(prs);
                }
            });


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





        </script>
    </body>
</html>
