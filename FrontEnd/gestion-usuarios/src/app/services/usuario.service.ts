import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError, map, forkJoin } from 'rxjs';
import { catchError, tap, switchMap } from 'rxjs/operators';
import { Usuario } from '../models/usuario.model';
import { Departamento } from '../models/departamento.model';
import { Cargo } from '../models/cargo.model';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class UsuarioService {
  private apiUrl = `${environment.apiUrl}/usuarios`;
  private departamentosUrl = `${environment.apiUrl}/departamentos`;
  private cargosUrl = `${environment.apiUrl}/cargos`;

  constructor(private http: HttpClient) {}

  getUsuarios(): Observable<Usuario[]> {
    return this.http.get<any>(this.apiUrl).pipe(
      map((response) => {
        // Asegurarse de que la respuesta sea un array
        if (response.data && Array.isArray(response.data)) {
          return response.data;
        }
        // Si la respuesta ya es un array, devolverla directamente
        if (Array.isArray(response)) {
          return response;
        }
        // Si no hay datos, devolver array vacío
        return [];
      }),
      switchMap((usuarios: Usuario[]) => {
        if (usuarios.length === 0) {
          return []; // Si no hay usuarios, devolver array vacío
        }

        // Obtener todos los departamentos y cargos únicos
        const departamentoIds = [
          ...new Set(usuarios.map((u) => u.departamento_id)),
        ];
        const cargoIds = [...new Set(usuarios.map((u) => u.cargo_id))];

        return forkJoin({
          departamentos: this.getDepartamentosByIds(departamentoIds),
          cargos: this.getCargosByIds(cargoIds),
        }).pipe(
          map(({ departamentos, cargos }) => {
            // Asignar departamento y cargo a cada usuario
            return usuarios.map((usuario) => ({
              ...usuario,
              departamento: departamentos.find(
                (d) => d.id === usuario.departamento_id
              ),
              cargo: cargos.find((c) => c.id === usuario.cargo_id),
            }));
          })
        );
      }),
      catchError(this.handleError)
    );
  }

  // Obtener un usuario por ID
  getUsuario(id: number): Observable<Usuario> {
    return this.http.get<Usuario>(`${this.apiUrl}/${id}`).pipe(
      switchMap((usuario) => {
        // Obtener el departamento y cargo relacionados
        return forkJoin({
          departamento: this.getDepartamento(usuario.departamento_id),
          cargo: this.getCargo(usuario.cargo_id),
        }).pipe(
          map(({ departamento, cargo }) => {
            return {
              ...usuario,
              departamento,
              cargo,
            };
          })
        );
      }),
      catchError(this.handleError)
    );
  }

  // Obtener múltiples departamentos por sus IDs
  private getDepartamentosByIds(ids: number[]): Observable<Departamento[]> {
    if (ids.length === 0)
      return new Observable((subscriber) => subscriber.next([]));

    // Puedes ajustar esto según la API - quizás soporte filtro por múltiples IDs
    return forkJoin(ids.map((id) => this.getDepartamento(id)));
  }

  // Obtener múltiples cargos por sus IDs
  private getCargosByIds(ids: number[]): Observable<Cargo[]> {
    if (ids.length === 0)
      return new Observable((subscriber) => subscriber.next([]));

    // Puedes ajustar esto según la API - quizás soporte filtro por múltiples IDs
    return forkJoin(ids.map((id) => this.getCargo(id)));
  }

  // Obtener un departamento por su ID
  private getDepartamento(id: number): Observable<Departamento> {
    return this.http
      .get<Departamento>(`${this.departamentosUrl}/${id}`)
      .pipe(catchError(this.handleError));
  }

  // Obtener un cargo por su ID
  private getCargo(id: number): Observable<Cargo> {
    return this.http
      .get<Cargo>(`${this.cargosUrl}/${id}`)
      .pipe(catchError(this.handleError));
  }

  // Crear un nuevo usuario
  crearUsuario(usuario: Usuario): Observable<Usuario> {
    return this.http
      .post<Usuario>(this.apiUrl, usuario)
      .pipe(catchError(this.handleError));
  }

  // Actualizar un usuario existente
  actualizarUsuario(id: number, usuario: Usuario): Observable<Usuario> {
    return this.http
      .put<Usuario>(`${this.apiUrl}/${id}`, usuario)
      .pipe(catchError(this.handleError));
  }

  // Eliminar un usuario
  eliminarUsuario(id: number): Observable<any> {
    return this.http
      .delete(`${this.apiUrl}/${id}`)
      .pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    let errorMessage = 'Error desconocido';
    if (error.error instanceof ErrorEvent) {
      // Error del lado del cliente
      errorMessage = `Error: ${error.error.message}`;
    } else {
      // Error del lado del servidor
      errorMessage = `Código de error: ${error.status}, mensaje: ${error.message}`;
    }
    console.error(errorMessage);
    return throwError(() => new Error(errorMessage));
  }
}
