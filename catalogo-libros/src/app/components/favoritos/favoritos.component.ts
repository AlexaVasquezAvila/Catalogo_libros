import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BooksService } from '../../services/books.service';

@Component({
  standalone: true,
  imports: [CommonModule],
  selector: 'app-favoritos',
  templateUrl: './favoritos.component.html',
})
export class FavoritosComponent implements OnInit {

  favoritos: any[] = [];

  constructor(private booksService: BooksService) {}

  ngOnInit(): void {
    // Al iniciar, cargamos la lista de favoritos del servicio
    this.favoritos = this.booksService.favoritos;
  }

}
