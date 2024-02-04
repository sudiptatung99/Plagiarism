import { Injectable } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(public jwtHelper: JwtHelperService) { }

  public isAuthenticated(): any {
    const token = localStorage.getItem('accessToken'); 
    if(token) {
      return true;
    }
  }  

} 