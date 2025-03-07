import { Departamento } from './departamento.model';
import { Cargo } from './cargo.model';

export interface Usuario {
  id?: number;
  usuario: string;
  primer_nombre: string;
  segundo_nombre?: string;
  primer_apellido: string;
  segundo_apellido?: string;
  email: string;
  departamento_id: number;
  cargo_id: number;
  departamento?: Departamento;
  cargo?: Cargo;
}
