import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, catchError, map, throwError } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ProfileService {

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
  public secureHeaderFile() {
    let httpOptionsSecure = {
      headers: new HttpHeaders({
        Authorization: 'Bearer ' + localStorage.getItem('token')
      })
    };
    return httpOptionsSecure;
  } 


  onGetProfile(data:any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/profile',data, this.secureHeader())
      .pipe(map(res => res), catchError(error => {  
        return throwError(error);
      })
    );
  } 

  onGetProfileUpdate(formData:any): Observable<any>  {
    return this._httpClient.post(this.baseUrl + 'user/profile-edit',formData, this.secureHeaderFile())
    .pipe(map(res => res), catchError(error => {
      return throwError(error);
    })
    );
  } 
}
