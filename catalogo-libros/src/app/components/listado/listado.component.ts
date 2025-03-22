import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BooksService } from '../../services/books.service';

@Component({
  standalone: true,
  imports: [CommonModule],
  selector: 'app-listado',
  templateUrl: './listado.component.html',
})
export class ListadoComponent implements OnInit {
  libros: any[] = [];

  constructor(private booksService: BooksService) {}

  ngOnInit() {
    // Tomamos los resultados que se guardaron en el servicio
    this.libros = this.booksService.resultados;
  }
}
