var localDB = new PouchDB('prs25');
var remoteDB = new PouchDB('http://localhost:5984/prs25_test');

localDB.sync(remoteDB, {
  live: true,
  retry: true
}).on('change', function (change) {
  // yo, something changed!
}).on('paused', function (info) {
  // replication was paused, usually because of a lost connection
}).on('active', function (info) {
  // replication was resumed
}).on('error', function (err) {
  // totally unhandled error (shouldn't happen)
});
