import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BooksService {

   // Declara aquí la propiedad resultados
   resultados: any[] = [];

  private baseUrl = 'https://openlibrary.org';

  constructor(private http: HttpClient) {}

  // Método para buscar libros según un término
  buscarLibros(termino: string): Observable<any> {
    // Ejemplo: https://openlibrary.org/search.json?q=harry+potter
    const url = `${this.baseUrl}/search.json?q=${termino}`;
    return this.http.get(url);
  }

  // Método para obtener detalle de un libro (work) por su ID
  obtenerDetalle(keyObra: string): Observable<any> {
    // Ejemplo: https://openlibrary.org/works/OL82563W.json
    const url = `${this.baseUrl}${keyObra}.json`;
    return this.http.get(url);
  }
}
