import { Component } from '@angular/core';
import { RouterOutlet, RouterModule } from '@angular/router';

@Component({
  standalone: true,
  imports: [RouterOutlet, RouterModule],
  selector: 'app-root',
  template: `
    <div class="layout-principal text-center py-4">
      <h1 class="titulo-principal">🧭 Compendio de Tesoros Literarios</h1>
      <nav class="mb-3">
        <a class="btn btn-busqueda" routerLink="/busqueda">🏠 Ir a Búsqueda</a>
      </nav>
      <hr />
      <router-outlet></router-outlet>
    </div>
  `
})
export class AppComponent {}
