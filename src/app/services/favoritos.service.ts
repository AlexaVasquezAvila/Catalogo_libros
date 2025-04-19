import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class FavoritosService {
  private url = 'http://localhost/compendio_api/favoritos.php';

  constructor(private http: HttpClient) {}

  obtenerFavoritos(): Observable<any> {
    return this.http.get(this.url);
  }

  crearFavorito(favorito: any): Observable<any> {
    return this.http.post(this.url, favorito);
  }

  eliminarFavorito(id: number): Observable<any> {
    return this.http.delete(`${this.url}?id=${id}`);
  }
}
