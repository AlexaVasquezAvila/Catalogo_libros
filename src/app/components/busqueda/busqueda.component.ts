import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { BooksService } from '../../services/books.service';
import { Router } from '@angular/router';

@Component({
  standalone: true,
  imports: [CommonModule, FormsModule],  // Habilita *ngFor, *ngIf y [(ngModel)]
  selector: 'app-busqueda',
  templateUrl: './busqueda.component.html',
})
export class BusquedaComponent {
  terminoBusqueda: string = '';

  constructor(
    private booksService: BooksService,
    private router: Router
  ) {}

  buscar() {
    console.log('Buscando libros:', this.terminoBusqueda);

    // Llamamos al servicio para buscar
    this.booksService.buscarLibros(this.terminoBusqueda).subscribe({
      next: (resp) => {
        console.log('Respuesta de la API:', resp);
        
        // Guardamos los resultados en el servicio
        this.booksService.resultados = resp.docs;  // 'docs' suele ser el array principal
        
        // Navegamos al listado para mostrar los resultados
        this.router.navigate(['/listado']);
      },
      error: (err) => {
        console.error('Error al buscar libros:', err);
      }
    });
  }
}
