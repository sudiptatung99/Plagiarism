import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { map, catchError } from 'rxjs/operators';
import { Observable, throwError } from 'rxjs';
import { HttpHeaders, HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class PlanService {

  constructor(private _httpClient: HttpClient) { }

  public baseUrl = environment.BASE_URL;
  // http = "http://localhost:4500/about"
  public publicHeader() {
    let httpOptionsSecure = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
      })
    };
    return httpOptionsSecure;
  }

  public secureHeader() {
    let httpOptionsSecure = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + localStorage.getItem('token')  
      }) 
    };
    return httpOptionsSecure;
  } 
 
  onGetPlan(): Observable<any> {
    return this._httpClient.get(this.baseUrl + 'plan/list', this.secureHeader())
      .pipe(map(res => res), catchError(error => {  
        return throwError(error);
      })
    );
  } 

  onAddPlan(planObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'plan/add', planObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })  
    );
  } 

  encryptdata(data:any): Observable<any>{
    return this._httpClient.post(this.baseUrl + 'payment',data, this.secureHeader())
    .pipe(map(res => res), catchError(error => {
      return throwError(error);
    })  
  );
  }
  countPlan(data:any): Observable<any>{
    return this._httpClient.post(this.baseUrl + 'plan/count',data, this.secureHeader())
    .pipe(map(res => res), catchError(error => {
      return throwError(error);
    })  
  );
  }

}   