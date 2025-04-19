import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UsuariosService {
  private url = 'http://localhost/compendio_api/usuarios.php';

  constructor(private http: HttpClient) {}

  obtenerUsuarios(): Observable<any> {
    return this.http.get(this.url);
  }

  crearUsuario(usuario: any): Observable<any> {
    return this.http.post(this.url, usuario);
  }

  editarUsuario(id: number, usuario: any): Observable<any> {
    return this.http.put(`${this.url}?id=${id}`, usuario);
  }

  eliminarUsuario(id: number): Observable<any> {
    return this.http.delete(`${this.url}?id=${id}`);
  }
}
