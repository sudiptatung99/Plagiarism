import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { map, catchError } from 'rxjs/operators';
import { Observable, throwError } from 'rxjs';
import { HttpHeaders, HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  static onGetDetails(userObj: any) {
    throw new Error('Method not implemented.');
  }

  constructor(private _httpClient: HttpClient) { }

  public baseUrl = environment.BASE_URL;

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

  onLogin(loginObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/login', loginObj, this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
    ); 
  }

  onRegister(registerObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/register', registerObj, this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
    );  
  }
  onRegisterOtp(registerObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/register/otp', registerObj, this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
    );  
  }

  onGetDetails(userObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/details', userObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
    );
  } 

  onGetFolder(userObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/folder-list', userObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  }   

  onGetPlan(userObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/plan-list', userObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
    );  
  }   

  onGetDocument(userObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/document-list', userObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 

  onGetDeleteDocument(userObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/delete-document-list', userObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 
 
  onGetFolderDocument(userObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/folder-document-list', userObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 

  onChangePassword(passObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/change-password', passObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 
 
  onforgetPassword(emailObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/forget-password', emailObj, this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 

  onGetOtp(otpObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/otp', otpObj, this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 

  onResendOtp(resendotpObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/resend-otp', resendotpObj, this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 

  onResetPassword(passObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/reset-password', passObj, this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    );  
  } 

  getFaq(){
    return this._httpClient.get(this.baseUrl + 'faq', this.publicHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      }) 
    ); 
  }
}  