import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, Subject, catchError, map, retry, throwError } from 'rxjs';

import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {
  private subject = new Subject<any>();
  constructor(private _httpClient: HttpClient) { }

  public baseUrl = environment.BASE_URL;

  public secureHeader() {
    let httpOptionsSecure = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + localStorage.getItem('token')
      })
    };
    return httpOptionsSecure;
  }

  onGetDashboardData(data:any): Observable<any>{
    return this._httpClient.post(this.baseUrl + 'user/dashboard', data, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  sendClickEvent(){
    this.subject.next(true);
    
  }

  getClickEvent(): Observable<any>{
    return this.subject.asObservable();
  }


}
