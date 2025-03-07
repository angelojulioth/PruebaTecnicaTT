// src/app/components/usuarios/usuarios.component.ts
import { Component, OnInit } from '@angular/core';
import { Usuario } from '../../models/usuario.model';
import { Departamento } from '../../models/departamento.model';
import { Cargo } from '../../models/cargo.model';
import { UsuarioService } from '../../services/usuario.service';
import { DepartamentoService } from '../../services/departamento.service';
import { CargoService } from '../../services/cargo.service';
import { ModalService } from '../../services/modal.service';
import { forkJoin } from 'rxjs';

@Component({
  selector: 'app-usuarios',
  templateUrl: './usuarios.component.html',
  styleUrls: ['./usuarios.component.scss'],
})
export class UsuariosComponent implements OnInit {
  usuarios: Usuario[] = [];
  usuariosFiltrados: Usuario[] = [];
  departamentos: Departamento[] = [];
  cargos: Cargo[] = [];

  usuarioSeleccionado: Usuario | null = null;
  departamentoSeleccionado: Departamento | null = null;
  cargoSeleccionado: Cargo | null = null;

  modoEdicion = false;

  constructor(
    private usuarioService: UsuarioService,
    private departamentoService: DepartamentoService,
    private cargoService: CargoService,
    private modalService: ModalService
  ) {}

  ngOnInit(): void {
    this.cargarDatos();
  }

  cargarDatos(): void {
    // Primero cargar usuarios
    this.usuarioService.getUsuarios().subscribe({
      next: (usuarios) => {
        console.log('Usuarios recibidos:', usuarios);
        this.usuarios = usuarios;
        this.usuariosFiltrados = [...usuarios];
      },
      error: (error) => {
        console.error('Error al cargar usuarios:', error);
        this.usuarios = [];
        this.usuariosFiltrados = [];
      },
    });

    // Luego cargar departamentos y cargos
    forkJoin({
      departamentos: this.departamentoService.getDepartamentos(),
      cargos: this.cargoService.getCargos(),
    }).subscribe({
      next: (result) => {
        this.departamentos = result.departamentos || [];
        this.cargos = result.cargos || [];
      },
      error: (error) => {
        console.error('Error al cargar datos complementarios:', error);
        this.departamentos = [];
        this.cargos = [];
      },
    });
  }

  seleccionarDepartamento(departamento: Departamento | null): void {
    this.departamentoSeleccionado = departamento;
    this.aplicarFiltros();
  }

  seleccionarCargo(cargo: Cargo | null): void {
    this.cargoSeleccionado = cargo;
    this.aplicarFiltros();
  }

  aplicarFiltros(): void {
    this.usuariosFiltrados = this.usuarios.filter((usuario) => {
      let cumpleFiltros = true;

      if (this.departamentoSeleccionado && this.departamentoSeleccionado.id) {
        cumpleFiltros =
          cumpleFiltros &&
          usuario.departamento_id === this.departamentoSeleccionado.id;
      }

      if (this.cargoSeleccionado && this.cargoSeleccionado.id) {
        cumpleFiltros =
          cumpleFiltros && usuario.cargo_id === this.cargoSeleccionado.id;
      }

      return cumpleFiltros;
    });
  }

  abrirModalCrear(): void {
    this.modoEdicion = false;
    this.usuarioSeleccionado = {
      usuario: '',
      primer_nombre: '',
      segundo_nombre: '',
      primer_apellido: '',
      segundo_apellido: '',
      email: '',
      departamento_id: 0,
      cargo_id: 0,
    };
    this.modalService.mostrar('usuarioModal');
  }

  abrirModalEditar(usuario: Usuario): void {
    this.modoEdicion = true;
    this.usuarioSeleccionado = { ...usuario };
    this.modalService.mostrar('usuarioModal');
  }

  abrirModalConfirmacion(usuario: Usuario): void {
    this.usuarioSeleccionado = usuario;
    this.modalService.mostrar('confirmModal');
  }

  guardarUsuario(usuario: Usuario): void {
    if (this.modoEdicion && usuario.id) {
      this.usuarioService
        .actualizarUsuario(usuario.id, usuario)
        .subscribe(() => {
          this.cargarDatos();
          this.cerrarModal();
        });
    } else {
      this.usuarioService.crearUsuario(usuario).subscribe(() => {
        this.cargarDatos();
        this.cerrarModal();
      });
    }
  }

  eliminarUsuario(): void {
    if (this.usuarioSeleccionado && this.usuarioSeleccionado.id) {
      this.usuarioService
        .eliminarUsuario(this.usuarioSeleccionado.id)
        .subscribe(() => {
          this.cargarDatos();
          this.modalService.ocultar('confirmModal');
        });
    }
  }

  cerrarModal(): void {
    this.modalService.ocultar('usuarioModal');
  }
}
