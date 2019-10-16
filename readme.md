## PHP Backend to the react-bio project

Implemented EntryPoints:
* <a href="https://bio.tuffsruffs.se/">/</a> GET, HTML
* <a href="https://bio.tuffsruffs.se/api/">/api</a> GET, HTML, Redirect to github
* <a href="https://bio.tuffsruffs.se/api/all">/api/all</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/auditorium/1">/api/auditorium/{id}</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/auditorium/all">/api/auditorium/all</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/auditoriums">/api/auditoriums</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/book">/api/book</a> POST, JSON, ['token','show_id','seats']
* <a href="https://bio.tuffsruffs.se/api/cinema/1">/api/cinema/{id}</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/cinema/all">/api/cinema/all</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/cinemas">/api/cinemas</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/login">/api/login</a> POST, string, [email, password]
* <a href="https://bio.tuffsruffs.se/api/logout">/api/logout</a> POST, JSON, ['token']
* <a href="https://bio.tuffsruffs.se/api/movie/1">/api/movie/{id}</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/movie/1/shows">/api/movie/{id}/shows</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/movie/all">/api/movie/all</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/movies">/api/movies</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/register">/api/register</a> POST, string, [email, password]
* <a href="https://bio.tuffsruffs.se/api/reservation/1">/api/reservation/{id}</a> POST, JSON, [token]
* <a href="https://bio.tuffsruffs.se/api/reservation/all">/api/reservation/all</a> POST, JSON, [token]
* <a href="https://bio.tuffsruffs.se/api/reservations">/api/reservations</a> POST, JSON, [token]
* <a href="https://bio.tuffsruffs.se/api/show/1">/api/show/{id}</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/show/all">/api/show/all</a> GET, JSON
* <a href="https://bio.tuffsruffs.se/api/shows">/api/shows</a> GET, JSON
