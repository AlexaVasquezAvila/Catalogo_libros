import { bootstrapApplication } from '@angular/platform-browser';
import { importProvidersFrom } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { provideHttpClient } from '@angular/common/http';
import { provideRouter } from '@angular/router';

import { AppComponent } from './app/app.component';
import { routes } from './app/app.routes';

bootstrapApplication(AppComponent, {
  providers: [
    // Habilita [(ngModel)] en modo standalone
    importProvidersFrom(FormsModule),

    // Habilita HttpClient
    provideHttpClient(),

    // Rutas de la aplicación
    provideRouter(routes),
  ]
})
.catch(err => console.error(err));
