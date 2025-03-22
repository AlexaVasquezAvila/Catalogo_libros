import { Component } from '@angular/core';
import { RouterOutlet, RouterModule } from '@angular/router';

@Component({
  standalone: true,
  imports: [RouterOutlet,
            RouterModule    
  ],
  selector: 'app-root',
  template: `
    <h1>Mi Catálogo de Libros</h1>
    <nav>
      <a routerLink="/busqueda">Inicio</a>
    </nav>
    <hr />
    <!-- Aquí se mostrarán los componentes según la ruta -->
    <router-outlet></router-outlet>
  `
})
export class AppComponent {}
