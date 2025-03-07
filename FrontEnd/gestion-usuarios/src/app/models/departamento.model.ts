import { Usuario } from './usuario.model';

export interface Departamento {
  id?: number;
  nombre: string;
  usuarios?: Usuario[];
}
