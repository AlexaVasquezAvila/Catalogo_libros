import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { UsuariosService } from '../../services/usuarios.service';

@Component({
  standalone: true,
  selector: 'app-usuarios',
  templateUrl: './usuarios.component.html',
  imports: [CommonModule, FormsModule],
})
export class UsuariosComponent implements OnInit {
  usuarios: any[] = [];

  nuevoUsuario = {
    nombre: '',
    correo: '',
  };

  constructor(private usuariosService: UsuariosService) {}

  ngOnInit(): void {
    this.obtenerUsuarios();
  }

  obtenerUsuarios() {
    this.usuariosService.obtenerUsuarios().subscribe((data) => {
      this.usuarios = data;
    });
  }

  crearUsuario() {
    if (!this.nuevoUsuario.nombre || !this.nuevoUsuario.correo) return;

    this.usuariosService.crearUsuario(this.nuevoUsuario).subscribe((res) => {
      this.nuevoUsuario = { nombre: '', correo: '' };
      this.obtenerUsuarios();
    });
  }
}
