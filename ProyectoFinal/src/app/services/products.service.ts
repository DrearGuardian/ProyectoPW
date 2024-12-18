import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { product } from '../models/product';
import { Observable } from 'rxjs/internal/Observable';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {

  private apiURL = 'http://127.0.0.1:8000/api/products/';

  constructor(private _httpClient: HttpClient) { }

  public getProduct(): Observable<product[]>{
    return this._httpClient.get<product[]>(this.apiURL);
  }
}
