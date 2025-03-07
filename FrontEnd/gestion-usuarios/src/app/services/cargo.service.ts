import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Cargo } from '../models/cargo.model';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class CargoService {
  private apiUrl = `${environment.apiUrl}/cargos`;

  constructor(private http: HttpClient) {}

  // Obtener todos los cargos
  getCargos(): Observable<Cargo[]> {
    return this.http.get<Cargo[]>(this.apiUrl);
  }

  // Obtener un cargo por ID
  getCargo(id: number): Observable<Cargo> {
    return this.http.get<Cargo>(`${this.apiUrl}/${id}`);
  }

  // Crear un nuevo cargo
  crearCargo(cargo: Cargo): Observable<Cargo> {
    return this.http.post<Cargo>(this.apiUrl, cargo);
  }

  // Actualizar un cargo existente
  actualizarCargo(id: number, cargo: Cargo): Observable<Cargo> {
    return this.http.put<Cargo>(`${this.apiUrl}/${id}`, cargo);
  }

  // Eliminar un cargo
  eliminarCargo(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
