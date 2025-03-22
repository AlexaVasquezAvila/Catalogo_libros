import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';

@Component({
  standalone: true,
  imports: [RouterOutlet],
  selector: 'app-root',
  template: `
    <h1>Mi Catálogo de Libros</h1>
    <nav>
      <a routerLink="/busqueda">Búsqueda</a> |
      <a routerLink="/listado">Listado</a>
    </nav>
    <hr />
    <!-- Aquí se mostrarán los componentes según la ruta -->
    <router-outlet></router-outlet>
  `
})
export class AppComponent {}
