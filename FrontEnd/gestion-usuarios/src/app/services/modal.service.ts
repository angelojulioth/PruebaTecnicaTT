// src/app/services/modal.service.ts
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class ModalService {
  private modals: Map<string, any> = new Map();

  constructor() {}

  // Inicializar un modal de Bootstrap
  inicializar(id: string): void {
    const modalElement = document.getElementById(id);
    if (modalElement) {
      // Asegurarse de que bootstrap está disponible
      if (typeof (window as any).bootstrap !== 'undefined') {
        const modalInstance = new (window as any).bootstrap.Modal(modalElement);
        this.modals.set(id, modalInstance);
      } else {
        console.error('Bootstrap no está disponible');
      }
    } else {
      console.error(`Elemento con ID ${id} no encontrado`);
    }
  }

  // Mostrar un modal
  mostrar(id: string): void {
    const modal = this.modals.get(id);
    if (modal) {
      modal.show();
    } else {
      this.inicializar(id);
      setTimeout(() => this.mostrar(id), 100);
    }
  }

  // Ocultar un modal
  ocultar(id: string): void {
    const modal = this.modals.get(id);
    if (modal) {
      modal.hide();
    }
  }
}
