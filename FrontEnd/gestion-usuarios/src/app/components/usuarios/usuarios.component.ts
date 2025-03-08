// src/app/components/usuarios/usuarios.component.ts
import { Component, OnInit } from '@angular/core';
import { Usuario } from '../../models/usuario.model';
import { Departamento } from '../../models/departamento.model';
import { Cargo } from '../../models/cargo.model';
import { UsuarioService } from '../../services/usuario.service';
import { DepartamentoService } from '../../services/departamento.service';
import { CargoService } from '../../services/cargo.service';
import { ModalService } from '../../services/modal.service';
import { ToastService } from '../../services/toast.service'; // impotar el servicio toast
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

  // Add loading states
  isLoading = false;
  isLoadingData = false;
  isDeletingUser = false;

  constructor(
    private usuarioService: UsuarioService,
    private departamentoService: DepartamentoService,
    private cargoService: CargoService,
    private modalService: ModalService,
    private toastService: ToastService // injectar el servicio toast
  ) {}

  ngOnInit(): void {
    this.cargarDatos();
  }

  cargarDatos(): void {
    this.isLoadingData = true;
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
        this.toastService.showError(
          'Error',
          'No se pudieron cargar los usuarios'
        );
      },
      complete: () => {
        this.isLoadingData = false;
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
        this.toastService.showError(
          'Error',
          'No se pudieron cargar departamentos o cargos'
        );
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

  // Guardar un usuario, ya sea creación o actualización
  guardarUsuario(usuario: Usuario): void {
    this.isLoading = true;
    if (this.modoEdicion && usuario.id !== undefined) {
      this.usuarioService
        .actualizarUsuario(usuario.id as number, usuario)
        .subscribe({
          next: (usuarioActualizado) => {
            console.log('Usuario actualizado', usuarioActualizado);
            this.cargarDatos();
            this.modalService.ocultar('usuarioModal');
            this.toastService.showSuccess(
              'Éxito',
              'Usuario actualizado correctamente'
            );
          },
          error: (error) => {
            console.error('Error al actualizar usuario', error);
            this.toastService.showError(
              'Error',
              'No se pudo actualizar el usuario'
            );
          },
          complete: () => {
            this.isLoading = false;
          },
        });
    } else {
      this.usuarioService.crearUsuario(usuario).subscribe({
        next: (nuevoUsuario) => {
          console.log('Usuario creado', nuevoUsuario);
          this.cargarDatos();
          this.modalService.ocultar('usuarioModal');
          this.toastService.showSuccess(
            'Éxito',
            'Usuario creado correctamente'
          );
        },
        error: (error) => {
          console.error('Error al crear usuario', error);
          this.toastService.showError('Error', 'No se pudo crear el usuario');
        },
        complete: () => {
          this.isLoading = false;
        },
      });
    }
  }

  eliminarUsuario(): void {
    if (this.usuarioSeleccionado && this.usuarioSeleccionado.id) {
      this.isDeletingUser = true;
      this.usuarioService
        .eliminarUsuario(this.usuarioSeleccionado.id)
        .subscribe({
          next: () => {
            this.cargarDatos();
            this.modalService.ocultar('confirmModal');
            this.toastService.showSuccess(
              'Éxito',
              'Usuario eliminado correctamente'
            );
          },
          error: (error) => {
            console.error('Error al eliminar usuario', error);
            this.toastService.showError(
              'Error',
              'No se pudo eliminar el usuario'
            );
          },
          complete: () => {
            this.isDeletingUser = false;
          },
        });
    }
  }

  cerrarModal(): void {
    this.modalService.ocultar('usuarioModal');
  }
}
