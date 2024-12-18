import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Worker } from '../models/Worker';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class WorkersService {
  private apiURLWorkers = 'http://127.0.0.1:8000/api/Workers/';

  constructor(private _httpClient: HttpClient) {}

  // Obtiene todos los trabajadores
  public getWorkers(): Observable<Worker[]> {
    return this._httpClient.get<Worker[]>(this.apiURLWorkers);
  }

  // Inserta un nuevo trabajador
  insertWorker(worker: Worker): Observable<Object> {
    return this._httpClient.post(this.apiURLWorkers, worker);
  }

  // Elimina un trabajador por su ID
  deleteWorker(id: number): Observable<Object> {
    return this._httpClient.delete(`${this.apiURLWorkers}${id}`);
  }

  // Actualiza un trabajador por su ID
  updateWorker(id: number, worker: Worker): Observable<Object> {
    return this._httpClient.put(`${this.apiURLWorkers}${id}`, worker);
  }
}
