import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor, HttpErrorResponse } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { Router } from "@angular/router";
import { catchError } from "rxjs/operators";
import { ToastrService } from 'ngx-toastr';

@Injectable({
  providedIn: 'root'
})
export class AuthInterceptorService implements HttpInterceptor {
  
  constructor(private _router: Router, 
              private _toastr: ToastrService) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    if(localStorage.getItem('accessToken')) {
      request = request.clone({
        setHeaders: {
          Authorization: 'Bearer ' + localStorage.getItem('accessToken')
        }
      });
    }
    return next.handle(request).pipe(catchError((error, caught) => {
      this.handleAuthError(error);
      return of(error);
    }) as any);
  }
   
  handleAuthError(err: HttpErrorResponse): Observable<any> {
    if (err.status === 401) {
      this._toastr.error('Session expired !', 'Error', { 
        timeOut: 3000,
        positionClass: 'toast-top-right', 
        progressBar: true,
        progressAnimation: 'increasing'
      });
      localStorage.clear()
      this._router.navigateByUrl('/login');
      window.location.reload();  
      return of(err.message);
    }
    throw err;
  }

} 