import { Usuario } from './usuario.model';

export interface Cargo {
  id?: number;
  nombre: string;
  usuarios?: Usuario[];
}
