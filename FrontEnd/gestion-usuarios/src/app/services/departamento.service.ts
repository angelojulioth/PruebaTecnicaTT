import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Departamento } from '../models/departamento.model';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class DepartamentoService {
  private apiUrl = `${environment.apiUrl}/departamentos`;

  constructor(private http: HttpClient) {}

  // Obtener todos los departamentos
  getDepartamentos(): Observable<Departamento[]> {
    return this.http.get<Departamento[]>(this.apiUrl);
  }

  // Obtener un departamento por ID
  getDepartamento(id: number): Observable<Departamento> {
    return this.http.get<Departamento>(`${this.apiUrl}/${id}`);
  }

  // Crear un nuevo departamento
  crearDepartamento(departamento: Departamento): Observable<Departamento> {
    return this.http.post<Departamento>(this.apiUrl, departamento);
  }

  // Actualizar un departamento existente
  actualizarDepartamento(
    id: number,
    departamento: Departamento
  ): Observable<Departamento> {
    return this.http.put<Departamento>(`${this.apiUrl}/${id}`, departamento);
  }

  // Eliminar un departamento
  eliminarDepartamento(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
