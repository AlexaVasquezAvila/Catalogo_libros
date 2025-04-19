import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { FavoritosService } from '../../services/favoritos.service';

@Component({
  standalone: true,
  selector: 'app-favoritos',
  templateUrl: './favoritos.component.html',
  imports: [CommonModule, FormsModule],
})
export class FavoritosComponent implements OnInit {
  favoritos: any[] = [];

  nuevoFavorito = {
    usuario_id: '',
    libro_id: '',
  };

  constructor(private favoritosService: FavoritosService) {}

  ngOnInit(): void {
    this.obtenerFavoritos();
  }

  obtenerFavoritos() {
    this.favoritosService.obtenerFavoritos().subscribe((data) => {
      this.favoritos = data;
    });
  }

  crearFavorito() {
    if (!this.nuevoFavorito.usuario_id || !this.nuevoFavorito.libro_id) return;

    this.favoritosService.crearFavorito(this.nuevoFavorito).subscribe((res) => {
      this.nuevoFavorito = { usuario_id: '', libro_id: '' };
      this.obtenerFavoritos(); // Refresca la lista
    });
  }
}
