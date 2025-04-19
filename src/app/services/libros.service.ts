import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class LibrosService {
  private url = 'http://localhost/compendio_api/libros.php';

  constructor(private http: HttpClient) {}

  obtenerLibros(): Observable<any> {
    return this.http.get(this.url);
  }

  crearLibro(libro: any): Observable<any> {
    return this.http.post(this.url, libro);
  }

  editarLibro(id: number, libro: any): Observable<any> {
    return this.http.put(`${this.url}?id=${id}`, libro);
  }

  eliminarLibro(id: number): Observable<any> {
    return this.http.delete(`${this.url}?id=${id}`);
  }
}
