import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { DashboardService } from 'src/app/service/dashboard.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent {

  url = '';
  userObj: any = {
    user_id: localStorage.getItem('userId')
  };
  dashboardDetails: any;
  isLoader = true;

  constructor(private _router: Router,
    private _dashboard: DashboardService) {
    this.url = _router.url;
    this.url = this.url.replace('/', '');
  }

  // getDashboard() {
  //   this.isLoader = true;
  //   this._dashboard.onGetDashboardData(this.userObj).subscribe(res => {
  //     if (res.success == true) {
  //       this.isLoader = false;
  //       console.log(res);
        
  //       this.dashboardDetails = res;
  //     }

  //   },(error)=>{
  //     console.log(error);
      
  //     this.isLoader = false;
  //   })
  // }


  ngOnInit(): void {
    // this.getDashboard();
  }

}
