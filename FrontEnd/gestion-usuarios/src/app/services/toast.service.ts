import { Injectable } from '@angular/core';

export interface Toast {
  id: number;
  title: string;
  message: string;
  type: 'success' | 'error' | 'info' | 'warning';
  autoClose: boolean;
  timeout?: number;
}

@Injectable({
  providedIn: 'root',
})
export class ToastService {
  private toasts: Toast[] = [];
  private nextId = 0;

  constructor() {}

  getToasts(): Toast[] {
    return this.toasts;
  }

  showSuccess(title: string, message: string, timeout: number = 5000): void {
    this.show(title, message, 'success', timeout);
  }

  showError(title: string, message: string, timeout: number = 7000): void {
    this.show(title, message, 'error', timeout);
  }

  showInfo(title: string, message: string, timeout: number = 5000): void {
    this.show(title, message, 'info', timeout);
  }

  showWarning(title: string, message: string, timeout: number = 5000): void {
    this.show(title, message, 'warning', timeout);
  }

  private show(
    title: string,
    message: string,
    type: 'success' | 'error' | 'info' | 'warning',
    timeout: number
  ): void {
    const id = this.nextId++;
    const toast: Toast = {
      id,
      title,
      message,
      type,
      autoClose: true,
      timeout,
    };

    this.toasts.push(toast);

    if (toast.autoClose) {
      setTimeout(() => this.remove(id), toast.timeout);
    }
  }

  remove(id: number): void {
    this.toasts = this.toasts.filter((toast) => toast.id !== id);
  }

  clear(): void {
    this.toasts = [];
  }
}
