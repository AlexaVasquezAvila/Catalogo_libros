import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms'; // Necesario para [(ngModel)]
import { LibrosService } from '../../services/libros.service';

@Component({
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  selector: 'app-listado',
  templateUrl: './listado.component.html',
})
export class ListadoComponent implements OnInit {
  libros: any[] = [];

  // Objeto para capturar los datos del formulario
  nuevoLibro = {
    titulo: '',
    autor: '',
  };

  constructor(private librosService: LibrosService) {}

  ngOnInit(): void {
    this.obtenerLibros();
  }

  obtenerLibros() {
    this.librosService.obtenerLibros().subscribe((data) => {
      this.libros = data;
    });
  }

  crearLibro() {
    if (!this.nuevoLibro.titulo || !this.nuevoLibro.autor) return;

    this.librosService.crearLibro(this.nuevoLibro).subscribe((res) => {
      console.log('Libro creado:', res);
      this.nuevoLibro = { titulo: '', autor: '' };
      this.obtenerLibros(); // Recargar la lista
    });
  }

  agregarAFavoritos(libro: any) {
    // Aquí más adelante puedes usar favoritos.service.ts
    console.log('Favorito agregado:', libro);
  }
}
