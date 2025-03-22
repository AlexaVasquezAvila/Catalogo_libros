import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router'; // <-- Importa RouterModule
import { BooksService } from '../../services/books.service';

@Component({
  standalone: true,
  imports: [
    CommonModule,
    RouterModule   // <-- Agrégalo aquí para usar routerLink
  ],
  selector: 'app-listado',
  templateUrl: './listado.component.html',
})
export class ListadoComponent implements OnInit {
  libros: any[] = [];

  constructor(private booksService: BooksService) {}

  ngOnInit() {
    this.libros = this.booksService.resultados;
  }
}
