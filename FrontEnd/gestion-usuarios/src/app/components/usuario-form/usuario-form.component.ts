import {
  Component,
  EventEmitter,
  Input,
  OnChanges,
  OnInit,
  Output,
  SimpleChanges,
} from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Usuario } from '../../models/usuario.model';
import { Departamento } from '../../models/departamento.model';
import { Cargo } from '../../models/cargo.model';

@Component({
  selector: 'app-usuario-form',
  templateUrl: './usuario-form.component.html',
  styleUrls: ['./usuario-form.component.scss'],
})
export class UsuarioFormComponent implements OnInit, OnChanges {
  @Input() usuario: Usuario | null = null;
  @Input() departamentos: Departamento[] = [];
  @Input() cargos: Cargo[] = [];
  @Input() modoEdicion = false;

  @Output() onGuardar = new EventEmitter<Usuario>();
  @Output() onCancelar = new EventEmitter<void>();

  usuarioForm: FormGroup;

  constructor(private fb: FormBuilder) {
    this.usuarioForm = this.fb.group({
      id: [null],
      usuario: ['', Validators.required],
      primer_nombre: ['', Validators.required],
      segundo_nombre: [''],
      primer_apellido: ['', Validators.required],
      segundo_apellido: [''],
      email: ['', [Validators.required, Validators.email]],
      departamento_id: [0, Validators.required],
      cargo_id: [0, Validators.required],
    });
  }

  ngOnInit(): void {
    this.inicializarFormulario();
  }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes['usuario'] && this.usuario) {
      this.inicializarFormulario();
    }
  }

  inicializarFormulario(): void {
    if (this.usuario) {
      this.usuarioForm.patchValue({
        id: this.usuario.id,
        usuario: this.usuario.usuario,
        primer_nombre: this.usuario.primer_nombre,
        segundo_nombre: this.usuario.segundo_nombre || '',
        primer_apellido: this.usuario.primer_apellido,
        segundo_apellido: this.usuario.segundo_apellido || '',
        email: this.usuario.email,
        departamento_id: this.usuario.departamento_id,
        cargo_id: this.usuario.cargo_id,
      });
    }
  }

  getDepartamentoNombre(): string {
    const departamentoId = this.usuarioForm.get('departamento_id')?.value;
    if (departamentoId) {
      const departamento = this.departamentos.find(
        (d) => d.id === departamentoId
      );
      return departamento ? departamento.nombre : 'Seleccione un Departamento';
    }
    return 'Seleccione un Departamento';
  }

  getCargoNombre(): string {
    const cargoId = this.usuarioForm.get('cargo_id')?.value;
    if (cargoId) {
      const cargo = this.cargos.find((c) => c.id === cargoId);
      return cargo ? cargo.nombre : 'Seleccione un perfil';
    }
    return 'Seleccione un perfil';
  }

  seleccionarDepartamento(departamento: Departamento): void {
    this.usuarioForm.patchValue({
      departamento_id: departamento.id,
    });
  }

  seleccionarCargo(cargo: Cargo): void {
    this.usuarioForm.patchValue({
      cargo_id: cargo.id,
    });
  }

  guardar(): void {
    if (this.usuarioForm.valid) {
      this.onGuardar.emit(this.usuarioForm.value);
    } else {
      this.usuarioForm.markAllAsTouched();
    }
  }

  cancelar(): void {
    this.onCancelar.emit();
  }
}
