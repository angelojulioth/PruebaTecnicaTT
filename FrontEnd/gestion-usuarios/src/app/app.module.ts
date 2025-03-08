import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { UsuariosComponent } from './components/usuarios/usuarios.component';
import { UsuarioFormComponent } from './components/usuario-form/usuario-form.component';
import { ConfirmDialogComponent } from './components/confirm-dialog/confirm-dialog.component';
import { ToastComponent } from './components/toast/toast.component'; // importar el componente Toast

@NgModule({
  declarations: [
    AppComponent,
    UsuariosComponent,
    UsuarioFormComponent,
    ConfirmDialogComponent,
    ToastComponent, // declara el componente Toast
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
