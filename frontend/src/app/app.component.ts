import { Component } from '@angular/core';
import { AuthService } from './service/authentication/auth.service';
import { Router } from '@angular/router';
import { DashboardService } from './service/dashboard.service';
import { Location } from '@angular/common';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  dashboardDetails: any;
  isLoggedIn$: boolean = false;
  userObj: any = {
    user_id: localStorage.getItem('userId')
  }
  constructor(private _authService: AuthService,
    private _router: Router,
    private _dashboard: DashboardService,
    private location: Location) { }



  ngOnInit() {
    this.isLoggedIn();


  }

  public isLoggedIn() {
    if (this._authService.isAuthenticated()) {
      this.isLoggedIn$ = true;
      var pathString = this.location.path();
      if (pathString == '/login'|| pathString == '' || pathString == '/register' || pathString == '/forget-password' || pathString == '/otp'|| pathString == '/reset-password') {
        this._router.navigate(['/workspace']);
      }else{
        this._router.navigate([`/${pathString}`]);
      }

    } else {
      this._router.navigate(['/login']);
    }
  }

}
