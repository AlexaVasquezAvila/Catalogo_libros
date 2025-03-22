import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BooksService {
  private baseUrl = 'https://openlibrary.org';

  // Declara aquí la propiedad resultados
  resultados: any[] = [];
  favoritos: any[] = [];
  
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

  // Método para agregar un libro a la lista de favoritos
  agregarAFavoritos(libro: any) {
    const existe = this.favoritos.some(fav => fav.key === libro.key);
    if (!existe) {
      this.favoritos.push(libro);
    }
  }
}
