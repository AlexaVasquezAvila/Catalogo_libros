import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { BooksService } from '../../services/books.service';

@Component({
  standalone: true,           // Si tu proyecto es standalone
  imports: [CommonModule],    // Para usar *ngIf, *ngFor, etc.
  selector: 'app-detalle',
  templateUrl: './detalle.component.html',
})
export class DetalleComponent implements OnInit {
  libroId: string = '';
  detalleLibro: any;          // Aquí guardaremos la info del libro

  constructor(
    private route: ActivatedRoute,
    private booksService: BooksService
  ) {}

  ngOnInit(): void {
    // 1. Capturamos el parámetro "id" de la URL
    this.libroId = this.route.snapshot.paramMap.get('id') || '';

    // 2. Llamamos al servicio para obtener detalles del libro
    this.booksService.obtenerDetalle(this.libroId).subscribe({
      next: (resp) => {
        this.detalleLibro = resp;
        console.log('Detalle del libro:', resp);
      },
      error: (err) => {
        console.error('Error al obtener detalle:', err);
      }
    });
  }
}
